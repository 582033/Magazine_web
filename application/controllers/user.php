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

	function signout () {	//{{{
		$this->session->sess_destroy();
		delete_cookie('username');
		delete_cookie('nickname');
		delete_cookie('rmsalt');
		header('Location: /', TRUE, 302);
		exit;
	}	//}}}

	function _get_loved ($user_id, $page, $type, $page_url) {	//获取用户喜欢的(杂志|元素|作者){{{
		$page = $page ? $page : 1;
		if ($user_id == 'me') {
			$this->auth->check();
			$user_id = $this->session->userdata('id');
		}
		$is_me = $user_id == $this->session->userdata('id');
		$this->load->model('display_model');
		$url_data = array(
				'start' => ($page-1)*($this->limit),
				'limit' => $this->limit,
				);
		$loved_author = $this->user_loved_model->get_loved($user_id, $url_data, 'author');
		if ($type != 'followees') {
			$loved_ob = $this->user_loved_model->get_loved($user_id, $url_data, $type);
			if ($type == 'element') {
				$loved_ob['items'] = $this->display_model->process_elements($loved_ob['items']);
			}
			$page_style = null;
		}
		else {
			$loved_ob = $loved_author;
			$page_style = TRUE;
		}
		$data = array(
				'loved_author' => $loved_author,
				$type => $loved_ob,
				'is_me' => $is_me,
				'user_id' => $is_me ? 'me' : $user_id,
				);
		if ($type == 'element') {
			$total = $loved_ob['totalResults'];
			if ($total > $url_data['start'] + $url_data['limit']) {
				$data['nextpage'] = $page_url . '/p/' . ($page + 1);
			}
		}
		else {
			$data['page_list'] = $this->page_model->page_list($page_url, $this->limit, $loved_ob['totalResults'], $page, $page_style);
		}
		$this->smarty->view('user/user_center_main.tpl', $data);
	}	//}}}

	function magazines($user_id, $page = '1'){	//喜欢的杂志列表{{{
		$page_url = "/user/$user_id/magazines"; 
		$this->_get_loved($user_id, $page, 'magazine', $page_url);
	}	//}}}

	function elements($user_id, $page = '1'){	//喜欢的元素列表{{{
		$page_url = "/user/$user_id/elements"; 
		$this->_get_loved($user_id, $page, 'element', $page_url);
		$this->auth->check();
	}	//}}}

	function followees($user_id, $page = '1') {	//关注的作者{{{
		$page_url = "/user/$user_id/followees"; 
		$this->_get_loved($user_id, $page, 'followees', $page_url);
	}	//}}}

	function bookstore($user_id, $page = '1'){	//{{{
		$page = $page ? $page : 1;
		if ($user_id == 'me') {
			$this->auth->check();
			$user_id = $this->session->userdata('id');
		}
		$is_me = $user_id == $this->session->userdata('id');

		$url_data = array(
				'start' => ($page-1)*($this->limit),
				'limit' => $this->limit,
				);
		$request = request($this->api_host."/user/$user_id/magazines/published?start=" . $url_data['start'] . '&limit=' . $url_data['limit']);
		$loved_author = $this->user_loved_model->get_loved($user_id, $url_data, 'author');
		$data = array(
				'page_list' => $this->page_model->page_list("/user/$user_id/bookstore", $this->limit, $request['data']['totalResults'], $page),
				'loved_author' => $loved_author,
				'bookstore' => $request['data'],
				'is_me' => $is_me,
				'user_id' => $is_me ? 'me' : $user_id,
				);
		$this->smarty->view('user/user_center_main.tpl', $data);
	}	//}}}

	function get_user_info () {
		$this->_json_output($this->user_info_model->get_user_info());
	}

	function set_base () {	//设置个人信息{{{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$data = array(
					'nickname' => $this->input->post('nickname'),
					'gender' => $this->input->post('gender'),
					'birthday' => $this->input->post('year') . "-" . $this->input->post('month') . "-"  . $this->input->post('day'),
					'province' => $this->input->post('true_province'),
					'city' => $this->input->post('true_city'),
					);
			$return = $this->user_info_model->set_base(json_encode($data));
			echo json_encode($return);
		}
		else {
			$data = array(
					'user_set' => 'set_base',
					'user_set_name' => '基本资料',
					);
			$this->smarty->view('user/set_main.tpl', $data);
		}
	}	//}}}

	function set_headpic () {	//头像设置{{{
		$data = array(
				'user_set' => 'set_headpic',
				'user_set_name' => '头像设置',
				);
		$this->smarty->view('user/set_main.tpl', $data);
	}

	function set_tag () {	//个人标签{{{
		$data = array(
				'user_set' => 'set_tag',
				'user_set_name' => '个人标签',
				);
		$this->smarty->view('user/set_main.tpl', $data);
	}

	function set_auther () {	//作者信息设置{{{
		$data = array(
				'user_set' => 'set_auther',
				'user_set_name' => '作者信息设置',
				);
		$this->smarty->view('user/set_main.tpl', $data);
	}	//}}}

	function set_user_info () {	//{{{
		$session_id = $this->session->userdata('sid');
		$keys =	array('nickname', 'birthday', 'sex');
		$user_info = $this->_get_json_values($keys);
		$post = array('user_info' => $user_info);
		$url_with_get = $this->api_host."/magazine/set_user_info?session_id=$session_id";
		opt($url_with_get, $post);
	}	//}}}
	
	public function set_share() {	//绑定第三方帐号{{{
		$data = array();
		$session_id = $this->session->userdata('session_id');
		$this->load->model('Sns_Model');
		$unbind = Sns_Model::getAllSns();
		if(!$session_id) return;

		$result = request($this->api_host.'/sns/bindinfo',array('session_id'=>$session_id),'GET');
		if($result['httpcode']!=200) return;
		foreach ($result['data'] AS $v) {
			$data['bindinfo'][$v['snsid']] = $v;
			unset($unbind[$v['snsid']]);
		}
		$other = array(
				'ubind' => $unbind,
				'session_id' => $session_id,
				'user_set' => 'set_share',
				'user_set_name' => '分享管理',
				);
		$this->smarty->view('user/set_main.tpl', array_merge($data, $other));
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
	
//show all messages
function messages($user_id, $p=1) {
	$p = $p ? $p : 1;
	$user_info = $this->check_signin();
	//check login status
	if($user_info===FALSE){
		header('HTTP1.1 401');
		exit();

	}
	if ($user_id != 'me' && $user_id != $user_info['id']) {
		show_error('', 401);
	}
	if($p==1){
		$start=0;
		$limit=$this->config->item('page_msg_num');
	}
	else{
		$start=$this->config->item('page_msg_num')*($p-1);
		$limit=$this->config->item('page_msg_num');

	}
	$res = request($this->api_host."/user/".$user_info['id']."/activities",
			array('start'=>$start,"limit"=>$limit,"session_id"=>$user_info['session_id']));
	$arr_totpl=array();
	$msg_ctt='';
	$totalnum=$res['data']['totalResults'];
	foreach($res['data']['items'] as $k=>$v){

		$tmp_msg=(json_decode($v['object'],true));
		$msg_ctt.='
			<dl class="clearfix" id="'.$v['msg_id'].'"> <dt><a href="#"><img src="/sta/images/userhead/50.jpg" alt="用户名" /></a></dt> <dd> <div> <p> <strong><a href="#">戴斯：</a></strong>欢迎阅读杂志编号为'.'------'.$v['msg_id'].'的杂志<a href="#">《我的杂志》</a> </p> <span> 2012-5-6 17:40 <a href="javascript:delmsg('.$v['msg_id'].')" class="del_msg" onclick="delmsg('.$v['msg_id'].')">删除</a> </span> </div> </dd> </dl> ';

	}
	$page_list = $this->page_model->page_list("/user/me/messages", $this->config->item('page_msg_num'), $totalnum, $p,'msg');
	$data=array();
	$data['msg']=$msg_ctt;
	$data['love_msg']="true";
	$data['page_list']=$page_list;
	$data['msg_page']='msg_page';
	$data['web_host']='$.getJSON("'.$this->config->item('web_host').'/message/del/"+msgid, {}, function(response){window.location.reload(); });';
	$data['is_me'] = TRUE;
	$data['user_id'] = 'me';
	$this->smarty->view('user/user_center_main.tpl',$data);

}
	//show all messages
	function msglist($page){
	$this->index($page);


}

//api proxy
function del_msg($msgid){
	$user_info=$this->check_signin();
	$res=request($this->api_host."/activity/".$msgid,'session_id='.$user_info['session_id'],"DELETE");
}


}
