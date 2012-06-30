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
			$getkey_data = $getkey['data']['key'];
			$passwd = md5(md5($passwd).$getkey_data);
			$api_data = request($this->api_host."/auth/signin?username=$username&passwd=$passwd");
			if ($api_data['httpcode'] == '200')	{
				switch ($api_data['data']['status']) {
					case 'OK':
						$user_info  = $api_data['data'];
						$this->session->set_userdata($user_info);
						if ($need_remember) {	//设置cookie,下次自动登录{{{
							$rmsalt = $this->_get_rmsalt($username);
							$cookie = array(
									'username' => $username,
									'rmsalt' => $rmsalt,
									);
							$this->input->set_cookie($cookie);
						}	//}}}
						//redirect("/");
						break;
					case 'INVALID_KEY':
						$api_data = "key失效或不正确";
						break;
					case 'AUTH_FAIL':
						$api_data = "错误的用户名或密码";
						break;
				}
			}
			else {
				return "errcode:" . $api_data['httpcode'];
			}
			$return = $api_data;
		}
		else {
			echo "1";
		}
		return $return;
	}	//}}}

	function _get_rmsalt ($username) {	//{{{
		$this->load->database();
		$result = $this->db->from('account')->where(array('account_name' => $username))->get()->row_array();
		$rmsalt = md5($result['passwd'].$result['rmsalt']);
		return $rmsalt;
	}	//}}}
}
