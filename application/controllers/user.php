<?php
include 'magazine.php';

class User extends Magazine {

	function User () {	//{{{
		parent::__construct();
		$this->load->model('user_loved_model');
		$this->load->model('user_info_model');
		$this->load->model('send_email_model');

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

	function signupbox() {	//{{{
		$this->smarty->view('user/signupbox.tpl');
	}	//}}}
	function signinbox() { //{{{
		$this->smarty->view('user/signinbox.tpl');
	} //}}}
	function signup() {	//{{{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$username = $this->input->post('username');
			$passwd = $this->input->post('passwd');
			$return = $this->_api_post('/auth/signup', array('username' => $username, 'passwd' => $passwd));
			if ($return['data']['status'] == 'OK') {
				$this->Login_Model->set_signin_session_cookie($return['data']);
			}
			$this->_json_output($return['data']);
		}
		else {
			$this->smarty->view('user/signup.tpl');
		}
	}	//}}}
	function signin() { //{{{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$username = $this->input->post('username');
			$passwd = $this->input->post('passwd');
			$need_remember = $this->input->post('need_remember');
			$return = $this->Login_Model->login($username, $passwd, $need_remember);
			return $this->_json_output($return['data']);
		}
		else {
			$this->smarty->view('user/signin.tpl');
		}
	} //}}}
	function signout() { //{{{
		$this->session->sess_destroy();
		delete_cookie('username');
		delete_cookie('nickname');
		delete_cookie('rmsalt');
		redirect_to_referer();
	} //}}}

	function applyAuthor($stage){	//{{{
		if ($stage == 'invitation') {
			$user_id = $this->session->userdata('id');
			if (!$user_id) {
				header('Location: /user/signinbox', TRUE, 302);
				return;
			}
			$this->smarty->view('user/invitation_code.tpl');
		}
		elseif ($stage == 'apply') {
			$status2msg = array(
					'OK' => '成功',
					'INVALID_CODE' => '错误的邀请码',
					'CODE_USED' => '邀请码已被使用',
					);
			$code = $this->input->post('code');
			$this->load->model('user_info_model');
			$return = $this->user_info_model->apply_author($code);
			if ($return['httpcode'] != 200) show_error('', $return['httpcode']);
			$status = $return['data']['status'];
			$result = array(
					'status' => $status,
					'message' => element($status, $status2msg, '未知错误'),
					);
			$this->_json_output($result);
		}
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
		$this->load->model('user_info_model');
		$data = array(
				'loved_author' => $loved_author,
				$type => $loved_ob,
				'is_me' => $is_me,
				'user_id' => $is_me ? 'me' : $user_id,
				'user_info' => $this->user_info_model->get_user($user_id),
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

	function bookstore($user_id, $page = '1', $type = 'published'){	//{{{
		$page = $page ? $page : 1;
		$type = $type ? $type : 'published';
		if ($user_id == 'me') {
			$this->auth->check();
			$user_id = $this->session->userdata('id');
		}
		$is_me = $user_id == $this->session->userdata('id');

		$url_data = array(
				'start' => ($page-1)*($this->limit),
				'limit' => $this->limit,
				);
		$books = $this->user_loved_model->my_magazines($user_id, $url_data, $type);
		$loved_author = $this->user_loved_model->get_loved($user_id, $url_data, 'author');
		if ($type == 'unpublished') {
			$page_list = $this->page_model->page_list("/user/me/unpublished", $this->limit, $books['data']['totalResults'], $page);
		}
		else {
			if ($is_me){
				$page_list = $this->page_model->page_list("/user/me/published", $this->limit, $books['data']['totalResults'], $page);
			}
			else {
				$page_list = $this->page_model->page_list("/user/$user_id/bookstore", $this->limit, $books['data']['totalResults'], $page);
			}
		}
		$data = array(
				'page_list' => $page_list,
				'loved_author' => $loved_author,
				'bookstore' => $books['data'],
				'is_me' => $is_me,
				'user_id' => $is_me ? 'me' : $user_id,
				'type' => $type,
			);
		$this->smarty->view('user/user_center_main.tpl', $data);
	}	//}}}

	function get_user_info () {	//{{{
		$this->_json_output($this->user_info_model->get_user_info());
	}	//}}}

	function get_tag_list () {	//{{{
		echo $this->user_info_model->get_tag_list();
	}	//}}}

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
	function set_pwd(){		
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$post = array(
						'old_pwd' => trim($this->input->post('old_pwd')),
						'new_pwd' => trim($this->input->post('reset_pwd')),
						);
			$item = $this->user_info_model->_modify_user_pwd($post);
			echo json_encode($item);
		}else{
			$data = array(
					'user_set' => 'set_pwd',
					'user_set_name' => '修改密码',
					);
			$this->smarty->view('user/set_main.tpl', $data);
		}
	}
	
	function set_tag () {	//个人标签{{{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$data = array(
					'tags' => $this->input->post('tags'),
					);
			$return = $this->user_info_model->set_base(json_encode($data));
			echo json_encode($return);
		}
		else {
			$tags = $this->user_info_model->get_user_tags($this->session->userdata('id'));
			$data = array(
					'user_set' => 'set_tag',
					'user_set_name' => '个人标签',
					'tags' => $tags,
					);
			$this->smarty->view('user/set_main.tpl', $data);
		}
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
				'unbind' => $unbind,
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
	if(count($res['data']['items'])){
	foreach($res['data']['items'] as $k=>$v){

		$tmp_msg=(json_decode($v['object'],true));
		$msg_ctt.='
			<dl class="clearfix" id="'.$v['msg_id'].'"> <dt><a href="#"><img src="/sta/images/userhead/50.jpg" alt="用户名" /></a></dt> <dd> <div> <p> <strong><a href="#">戴斯：</a></strong>欢迎阅读杂志编号为'.'------'.$v['msg_id'].'的杂志<a href="#">《我的杂志》</a> </p> <span> 2012-5-6 17:40 <a href="javascript:delmsg('.$v['msg_id'].')" class="del_msg" onclick="delmsg('.$v['msg_id'].')">删除</a> </span> </div> </dd> </dl> ';

	}
	}
	$page_list = $this->page_model->page_list("/user/me/messages", $this->config->item('page_msg_num'), $totalnum, $p,'msg');
	$data=array();
	$data['msg']=$msg_ctt;
	$data['love_msg']="true";
	$data['page_list']=$page_list;
	$data['msg_page']='msg_page';
	$data['web_host']='$.getJSON("'.$this->config->item('api_host').'/message/del/"+msgid, {}, function(response){window.location.reload(); });';
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



function reset_password(){
		$this->smarty->view('user/reset_password.tpl');
}

function forget_password(){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$email = trim($this->input->post('email'));
		$info = $this->send_email_model->_get_username($email);
		if ($info == 0){
			$msg = 'false';
			echo json_encode($msg);
		}else{
			$msg = 'true';
			echo json_encode($msg);
		}
	}else{
		$this->smarty->view('user/forget_password.tpl');
	}
	
//	$this->smarty->view('user/forget_password.tpl');
/*		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$post = array(
						'old_pwd' => trim($this->input->post('old_pwd')),
						'new_pwd' => trim($this->input->post('reset_pwd')),
						);
			$item = $this->user_info_model->_modify_user_pwd($post);
			echo json_encode($item);
		}else{
			$data = array(
					'user_set' => 'set_pwd',
					'user_set_name' => '修改密码',
					);
			$this->smarty->view('user/set_main.tpl', $data);
		}
*/
}
}
