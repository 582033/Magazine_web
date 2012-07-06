<?php
include 'magazine.php';

class User extends Magazine {


	function User () {	//{{{
		parent::__construct();
		$this->load->model('user_loved_model');
		$this->load->model('user_info_model');

/*
 *		验证登录状态
 */
		$this->load->model('auth');
		$this->auth->auth_user();

		$this->load->helper('api');
		$this->load->library('session');
	}	//}}}

	function _get_json_values ($keys) {	//{{{
		$return = array();
		foreach ($keys as $item) {
			$return[$item] = $this->input->post($item);
		}
		return json_encode($return, true);
	}	//}}}

	function signup (){	//{{{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$username = $this->input->post('username');
			$passwd = $this->input->post('passwd');
			$return = $this->reg_model->reg($username, $passwd);
			//echo json_encode($return);
			//exit;
			$this->_json_output($return);
		}
		else {
			$this->smarty->view('user/signup.tpl');
		}
	}	//}}}

	function signin (){	//{{{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$username = $this->input->post('username');
			$passwd = $this->input->post('passwd');
			$need_remember = $this->input->post('need_remember');
			$return = $this->Login_Model->login($username, $passwd, $need_remember);
			echo json_encode($return);
			exit;
		}
		$this->smarty->view('user/signin.tpl');
	}	//}}}

	function logout () {	//{{{
		$this->session->sess_destroy();
		redirect("/");
	}	//}}}

	function magazine ($page = '1'){	//喜欢的杂志列表{{{
		$this->auth->check();
		$url_data = array(
				'start' => ($page-1)*($this->limit),
				'limit' => $this->limit,
				);
		$mag_category = $this->input->get('mag_category');
		if ($mag_category) $url_data['mag_category'] = $mag_category;
		$loved_author = $this->user_loved_model->get_loved($url_data, 'author');
		$loved_magazine = $this->user_loved_model->get_loved($url_data, 'magazine');
		/*
		   get_loved($url_data, $type) $type[element/author/magazine]
		*/
		$data = array(
				'page_list' => $this->page_model->page_list("/user/magazine", $this->limit, $loved_magazine['totalResults'], $page),
				'loved_author' => $loved_author,
				'loved_magazine' => $loved_magazine,
				);
		$this->smarty->view('user/user_center_main.tpl', $data);
	}	//}}}

	function element ($page = '1'){	//喜欢的元素列表{{{
		$this->auth->check();
		$url_data = array(
				'start' => ($page-1)*($this->limit),
				'limit' => $this->limit,
				);
		$element_type = $this->input->get('element_type');
		if ($element_type) $url_data['element_type'] = $element_type;
		$loved_element = $this->user_loved_model->get_loved($url_data, 'element');
		$loved_author = $this->user_loved_model->get_loved($url_data, 'author');
		/*
		   get_loved($url_data, $type) $type[element/author/magazine]
		*/
		$data = array(
				//'page_list' => $this->page_list("/user/element", 100, $page),
				'page_list' => $this->page_model->page_list("/user/element", $this->limit, $loved_element['totalResults'], $page),
				'loved_author' => $loved_author,
				'loved_element' => $loved_element,
				);
		$this->smarty->view('user/user_center_main.tpl', $data);
	}	//}}}

	function bookstore($page = '1'){	//{{{
		$this->auth->check();
		$url_data = array(
				'start' => ($page-1)*($this->limit),
				'limit' => $this->limit,
				);
		$user_id = 2;//$this->session->userdata('id');
		$request = request($this->api_host.'/user/'.$user_id.'/magazines/published?start=' . $url_data['start'] . '&limit=' . $url_data['limit']);
		$loved_author = $this->user_loved_model->get_loved($url_data, 'author');
		$data = array(
				'page_list' => $this->page_model->page_list("/user/bookstore", $this->limit, $request['data']['totalResults'], $page),
				'loved_author' => $loved_author,
				'bookstore' => $request['data'],
				);
		$this->smarty->view('user/user_center_main.tpl', $data);
	}	//}}}

	function user_info () {	//设置个人信息{{{
		$session_id = $this->session->userdata('sid');
		$user_info = api($this->api_host."/magazine/user_info?session_id=$session_id");
		$this->smarty->view('user/user_info.tpl', $user_info);
	}	//}}}

	function set_user_info () {	//{{{
		$session_id = $this->session->userdata('sid');
		$keys =	array('nickname', 'birthday', 'sex');
		$user_info = $this->_get_json_values($keys);
		$post = array('user_info' => $user_info);
		$url_with_get = $this->api_host."/magazine/set_user_info?session_id=$session_id";
		opt($url_with_get, $post);
	}	//}}}
	
	public function bind() {	//绑定第三方帐号{{{
		$data = array();
		$sessionid = $this->session->userdata('session_id');
		$this->load->model('Sns_Model');
		$unbind = Sns_Model::getAllSns();
		if(!$sessionid) return;

		$result = request($this->api_host.'/sns/bindinfo',array('session_id'=>$sessionid),'GET');
		if($result['httpcode']!=200) return;
		foreach ($result['data'] AS $v) {
			$data['bindinfo'][$v['snsid']] = $v;
			unset($unbind[$v['snsid']]);
		}
		$data['unbind'] = $unbind;
		$data['session_id'] = $sessionid;
		$this->smarty->view('user/bind.tpl',$data);
		
	}	//}}}

	public function unbind() {	//解除绑定第三方帐号{{{
		$data = array(
			'error'=>null,
			'status'=>0,
			'data'=>null
		);
		$sessionid = $this->session->userdata('session_id');
		$snsid = $this->input->get('snsid');
		$this->load->model('Sns_Model');
		$unbind = Sns_Model::getAllSns();
		if($sessionid && in_array($snsid,Sns_Model::getAllSns()) && $this->input->is_ajax_request()) {
			$snsid = $this->input->get('snsid');
			$result = request($this->api_host.'/sns/unbind',array('session_id'=>$sessionid,'snsid'=>$snsid),'GET');
			if($result['httpcode']!=200) {
				$data['error'] = '';
			}
			elseif($result['data'] === true) {
				$data['status'] = 'OK';
			}
		}
		$this->_json_output($data);
	}	//}}}



	function check_signin(){
	$this->auth->check();
	$session_id=$this->session->userdata('session_id');
	$user_id=$this->session->userdata('id');
	if(TRUE){
return array(
	'id'=>$user_id,
	'session_id'=>$session_id,

);

}
else{
return FALSE;

}

}
	

	//index msg page
	function index($p=1){
	$user_info=$this->check_signin();
	//check login status
	if($user_info===FALSE){
	header('HTTP1.1 401');
	exit();

}
	if($p==1){
	$start=0;
	$limit=$this->config->item('page_msg_num');
}
else{
	$start=$this->config->item('page_msg_num')*($p-1);
	$limit=$this->config->item('page_msg_num');

}
	$res=(request($this->api_host."/user/".$user_info['id']."/activities",array('start'=>$start,"limit"=>$limit,"session_id"=>$user_info['session_id'])));
	$arr_totpl=array();
	$msg_ctt='';
	$totalnum=$res['data']['totalResults'];
	foreach($res['data']['items'] as $k=>$v){
	
	$tmp_msg=(json_decode($v['object'],true));
	$msg_ctt.='
<dl class="clearfix" id="'.$v['msg_id'].'"> <dt><a href="#"><img src="/sta/images/userhead/50.jpg" alt="用户名" /></a></dt> <dd> <div> <p> <strong><a href="#">戴斯：</a></strong>欢迎阅读杂志编号为'.'------'.$v['msg_id'].'的杂志<a href="#">《我的杂志》</a> </p> <span> 2012-5-6 17:40 <a href="javascript:delmsg('.$v['msg_id'].')" class="del_msg" onclick="delmsg('.$v['msg_id'].')">删除</a> </span> </div> </dd> </dl> ';
	


}
$page_list = $this->page_model->page_list("/user/msg", $this->config->item('page_msg_num'), $totalnum, $p,'msg');
$data=array();
$data['msg']=$msg_ctt;
$data['love_msg']="true";
$data['page_list']=$page_list;
$data['msg_page']='msg_page';
$data['web_host']='$.getJSON("'.$this->config->item('web_host').'/msg/del/"+msgid, {}, function(response){window.location.reload(); });';
	$this->smarty->view('user/user_center_main.tpl',$data);

}
	//show all messages
	function msglist($page){
	$this->index($page);


}

	//api proxy
	function show(){	//{{{
	//$this->smarty->view('msg/show.tpl');
	$user_info=$this->check_signin();
	$res=(request($this->api_host."/user/1/activities",array('session_id'=>$user_info['session_id'])));
	//echo "<pre>";
	//print_r($res['data']);
	}	//}}}
	function del($msgid){
	//echo $this->api_host;

	$user_info=$this->check_signin();
	$res=request($this->api_host."/activity/".$msgid,'session_id='.$user_info['session_id'],"DELETE");


}


}
