<?php
include 'magazine.php';
include("PHPMailer/class.phpmailer.php");
include("PHPMailer/class.smtp.php"); // note, this is optional - gets called from main class if not already loaded
class User extends Magazine {

	function User () {	//{{{
		parent::__construct();
		$this->load->model('user_loved_model');
		$this->load->model('user_info_model');
		$this->load->model('send_email_model');
		$this->load->helper('email');

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
			$return = $this->_get('return');
			$this->smarty->view('user/signup.tpl', array('pageid' => 'signup', 'return' => $return));
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
			$return = $this->_get('return');
			$this->smarty->view('user/signin.tpl', array('pageid' => 'signin', 'return' => $return));
		}
	} //}}}
	function signout() { //{{{
		$this->session->sess_destroy();
		delete_cookie('uid');
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
			$this->_auth_check_web();
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
		$this->_auth_check_web();
	}	//}}}

	function followees($user_id, $page = '1') {	//关注的作者{{{
		$page_url = "/user/$user_id/followees"; 
		$this->_get_loved($user_id, $page, 'followees', $page_url);
	}	//}}}

	function bookstore($user_id, $page = '1', $type = 'published'){	//{{{
		echo $page;
		$page = $page ? $page : 1;
		$type = $type ? $type : 'published';
		if ($user_id == 'me') {
			$this->_auth_check_web();
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
	} // }}}
	function set_pwd(){	// {{{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			if ($this->input->post('old_pwd') && $this->input->post('reset_pwd')){
				$post = array(
							'old_pwd' => trim($this->input->post('old_pwd')),
							'new_pwd' => trim($this->input->post('reset_pwd')),
							);
				$item = $this->user_info_model->_modify_user_pwd($post);
				$this->_json_output($item);
			}else{
				$msg = '未提交密码信息';
				$this->_json_output($msg);
			}
		}else{
			$data = array(
					'user_set' => 'set_pwd',
					'user_set_name' => '修改密码',
					);
			$this->smarty->view('user/set_main.tpl', $data);
		}
	} // }}}
	
	function set_tag () { //个人标签{{{
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
	} // }}}

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

	function pub_mag (){	//发布杂志{{{
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->auth->check();
			$request = $this->user_loved_model->pub_mag();
			echo $request;
		}
		else {
			$this->auth->check();
			$mag_id = $this->input->get('mag_id');	
			$mag_info = $this->mag_model->_get_magazine_by_id($mag_id);
			$mag_info['tag'] = implode(",", $mag_info['tag']);
			$data = array(
				'mag_category' => $this->mag_model->_get_mag_category(),
				'mag_info' => $mag_info,
				'mag_id' => $mag_id,
				);
			$this->smarty->view('user/pub_mag.tpl', $data);
		}
	}	//}}}

	function verb_msg($row){
		switch($row['verb']){
			case 'signup':
		//$ret_verb = '<dl class="clearfix">  <dd> <div align="center"> <p> '.$row['occur_time'].$row['msg_content'].'</p> <span></span> </div> </dd> </dl> ';
				if($row['status'] == 0){
				$msg_css=' style=\'background:#ffff37;\'';
				}
				else{
				$msg_css='';
				}

		$ret_verb = ' <dl class="clearfix" id="'.$row['msg_id'].'"> <dt><a href="#"><img src="/sta/images/userhead/50.jpg" alt="System" /></a></dt> <dd'.$msg_css.'> <div> <p> <strong><a href="#">System：</a></strong>'.$row['msg_content'].'</p> <span> '.$row['occur_time'].'<a href="javascript:delmsg('.$row['msg_id'].')" class="del_msg" onclick="delmsg('.$row['msg_id'].')">删除</a> </span> </div> </dd> </dl> ';
			break;
			case 'typeb':
		$ret_verb = '<dl class="clearfix">  <dd> <div align="center"> <p>verb typeb </p> <span></span> </div> </dd> </dl> ';
			break;
			default:
		$ret_verb = '';
		
		
		}

		return $ret_verb;
	}

//join msg  info from db and tpl
function print_msg($arr_db,$info){
	if(count($arr_db) == 0){
		//no msg ，show message to prompt
		$ret= '<dl class="clearfix">  <dd> <div align="center"> <p> 目前暂无消息</p> <span></span> </div> </dd> </dl> ';
	}
	else{
		$ret = '';
		foreach($arr_db as $v){
			$ret.= $this->verb_msg($v);
			//update message status
		 request($this->api_host."/activity/".$v['msg_id'].'?session_id='.$info['session_id'],json_encode(array()),"PUT");
		}
	}
return $ret;	

}
	
//show all messages
function messages($user_id, $p=1) {
	$p = $p ? $p : 1;
	//check login status
	$user_info = $this->_auth_check_web();
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
		$msg_ctt=$this->print_msg($res['data']['items'],$user_info);
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
	function del_msg($msgid) {
		$user_info = $this->_auth_check_api();
		$res = request($this->api_host."/activity/".$msgid,'session_id='.$user_info['session_id'],"DELETE");
	}

	function reset_pwd($key){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$account_name = $this->get_redis()->get($key);
			$new_pwd = trim($this->input->post('reset_pwd'));
		//	$this->_json_output($data);
			$result = $this->send_email_model->_update_account_name($account_name, $new_pwd);
			if ($result == 'true'){
				$msg = "true";
				$this->_json_output($msg);
			}else{
				$msg = "fail";
				$this->_json_output($msg);
			}
		}else{
			$msg = "error!";
			$this->_json_output($msg);
		}
	}

	function reset_password_show($key){
		$data = array('key' => $key);
		$this->smarty->view('user/reset_password.tpl', $data);
	}

	 function get_redis () { //{{{
        $redis = new Redis();
        $redis->connect($this->config->item('redis_server'));
        return $redis;
    }   //}}}

	function forget_password(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$email = trim($this->input->post('email'));
			$info = $this->send_email_model->_get_username($email);
			if (!is_array($info)){
				$msg = 'false';
				$this->_json_output($msg);
			}else{
				$key = random_string('alnum', 8);
				$this->get_redis()->setex($key, $this->config->item('salt_expires'), $email);
				$mail             = new PHPMailer();
				$body = "Dear user!<br />";
				$body .= "&nbsp;&nbsp;&nbsp;&nbsp;We have received your password reset request,please click <a href='".$this->config->item('web_host')."/user/reset_password_show/$key'>HERE</a> to complete your request.";
				$body .= "Thank you for your support!<br />";
				$body .= "&nbsp;&nbsp;&nbsp;&nbsp;<font style='font-weight:bold;'>1001 NIGHT</font>";
				$mail->IsHTML(true);
				$mail->IsSMTP();
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
				$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
				$mail->Port       = 465;                   // set the SMTP port
				$mail->Username   = "eee168m@gmail.com";  // GMAIL username
				$mail->Password   = "eee168mailer";            // GMAIL password
				$mail->From       = "eee168m@gmail.com";
				$mail->FromName   = "1001 NIGHT";
				$mail->Subject = "RESET YOUR PASSWORD";
//				$mail->Body = "http://mtong.a.1001s.cn/user/reset_password_show/$key";
				$mail->Body = $body;
				$mail->WordWrap   = 80; // set word wrap
				$mail->AddAddress($email);
				if(!$mail->Send()) {
					$msg = 'false';
					$this->_json_output($msg);
				}else{
					$msg = 'true';
					$this->_json_output($msg);
				}
			}
		}else{
			$this->smarty->view('user/forget_password.tpl');
		}
	}
}
