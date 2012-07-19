<?php
require_once APPPATH . 'models/api_model.php';
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
			$this->set_signin_cookie($signin_r['data']);
			if ($need_remember) {
				$rmsalt = $this->_get_rmsalt($username);
				$this->set_cookies(array('rmsalt' => $rmsalt));
			}
		}
		return $signin_r;
	}	//}}}

	function set_cookies($cookies) {
		foreach ($cookies as $k => $v) {
			$this->input->set_cookie(array(
						'name' => $k,
						'value' => $v,
						'domain' => $this->config->item('cookie_domain'),
						'path' => $this->config->item('cookie_path'),
						'prefix' => $this->config->item('cookie_prefix'),
						'expire' => $this->config->item('cookie_expire'),
						'secure' => $this->config->item('cookie_secure'),
						));
		}
	}
	function set_signin_cookie($signdata) { // {{{
		$cookies = array(
				'session_id' => $signdata['session_id'],
				'uid' => $signdata['id'],
				'nickname' => $signdata['nickname'],
				'avatar' => $signdata['image'],
				);
		$this->set_cookies($cookies);
	} //}}}

	function _get_rmsalt ($username) {	//{{{
		$this->load->database();
		$result = $this->db->from('account')->where(array('account_name' => $username))->get()->row_array();
		$rmsalt = md5($result['passwd'].$result['rmsalt']);
		return $rmsalt;
	}	//}}}
}
