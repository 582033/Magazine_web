<?php
class Login_Model extends Api_Model {

	function Login_Model (){
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
		$this->load->library('session');
	}	

	function login($username, $passwd, $need_remember=null) {	//{{{
		$key_r = $this->api_getkey(TRUE);
		$salt = $key_r['data']['key'];
		$passwd = md5(md5($passwd) . $salt);
		$signin_r = $this->api_signin(TRUE, $username, $passwd, $salt);
		if ($signin_r['data']['status'] == 'OK') {
			$this->set_signin_session_cookie($signin_r['data']);
			if ($need_remember) {	//设置cookie,下次自动登录{{{
				$rmsalt = $this->_get_rmsalt($username);
				$cookie_rmsalt = array(
						'name' => 'rmsalt',
						'value' => $rmsalt,
						'expire' => $this->config->item('cookie_expire'),
						);
				$this->input->set_cookie($cookie_rmsalt);
			}	//}}}
		}
		return $signin_r;
	}	//}}}

	function set_signin_session_cookie($signin_info) { // {{{
		$this->session->set_userdata($signin_info);
		$this->set_signin_cookie($signin_info['id'], $signin_info['nickname']);
	} //}}}
	function set_signin_cookie($uid, $nickname) { // {{{
		$this->input->set_cookie(array(
					'name' => 'uid',
					'value' => $uid,
					'expire' => $this->config->item('cookie_expire'),
					));

		$this->input->set_cookie(array(
					'name' => 'nickname',
					'value' => $nickname,
					'expire' => $this->config->item('cookie_expire'),
					));
	} //}}}

	function _get_rmsalt ($username) {	//{{{
		$this->load->database();
		$result = $this->db->from('account')->where(array('account_name' => $username))->get()->row_array();
		$rmsalt = md5($result['passwd'].$result['rmsalt']);
		return $rmsalt;
	}	//}}}
}
