<?php
class reg_model extends CI_Model{
	function reg_model (){
		parent::__construct();
	}
	
	function reg ($username, $passwd){
		$err_msg = null;
		if ($username == '' or $passwd == ''){
			$err_msg = "用户名或密码不能为空";	
		}
		$this->load->helper('email');
		if (!valid_email($username)) {
			$err_msg = '请输入正确的email';
		}
		if ($err_msg) return $err_msg;
		$post = array(
				'username' => $username,
				'passwd' => $passwd,
				);
		$api_data = request($this->api_host."/auth/signup", $post, 'POST');
		if(isset($api_data['httpcode']) && $api_data['httpcode'] == '200'){
			switch ($api_data['data']['status']) {
				case 'OK':
					$this->Login_Model->login($username, $passwd);		
					$err_msg = "seccess";
					break;
				case 'USER_EXISTS':
					$err_msg = "用户已存在";
					break;
			}
		}
		elseif (isset($api_data['httpcode']) && $api_data['httpcode'] != '200' ) {
			$err_msg = $api_data['httpcode'];
		}
		else {
			$err_msg = "api未返回数据";	
		}
		return $err_msg;
	}

}
