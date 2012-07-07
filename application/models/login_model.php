<?php
class Login_Model extends CI_Model {

	function Login_Model (){
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
		$this->load->library('session');
	}	

	function login($username, $passwd, $need_remember=null){	//{{{
		$url = $this->api_host."/auth/getkey";
		$getkey = request($url);
		if ($getkey['httpcode'] == '200'){
			$salt = $getkey['data']['key'];
			$passwd = md5(md5($passwd) . $salt);
			$api_data = request($this->api_host."/auth/signin?username=$username&passwd=$passwd&key=$salt");
			$return = $this->check_signin_api($username, $api_data, $need_remember);
		}
		else {
			$return = "getkey error:" . $getkey['httpcode'];
		}
		return $return;
	}	//}}}

	function check_signin_api($username, $api_data, $need_remember=null) {	//访问登录api成功,判断登录返回状态{{{
		if ($api_data['httpcode'] == '200')	{
			switch ($api_data['data']['status']) {
				case 'OK':
					$user_info  = $api_data['data'];
					$this->session->set_userdata($user_info);
					if ($need_remember) {	//设置cookie,下次自动登录{{{
						$rmsalt = $this->_get_rmsalt($username);
						$cookie_username = array(
								'name' => 'username',
								'value' => $username,
								'expire' => $this->config->item('cookie_expire'),
								);
						$this->input->set_cookie($cookie_username);
						$cookie_rmsalt = array(
								'name' => 'rmsalt',
								'value' => $rmsalt,
								'expire' => $this->config->item('cookie_expire'),
								);
						$this->input->set_cookie($cookie_rmsalt);
					}	//}}}
					$msg = $api_data;
					break;
				case 'INVALID_KEY':
					$msg = "key失效或不正确";
					break;
				case 'AUTH_FAIL':
					$msg = "错误的用户名或密码";
					break;
			}
		}
		else {
			$msg = "signin errer:" . $api_data['httpcode'];
		}
		return $msg;
	}	//}}}

	function _get_rmsalt ($username) {	//{{{
		$this->load->database();
		$result = $this->db->from('account')->where(array('account_name' => $username))->get()->row_array();
		$rmsalt = md5($result['passwd'].$result['rmsalt']);
		return $rmsalt;
	}	//}}}
}
