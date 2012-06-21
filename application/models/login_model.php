<?php
class Login_Model extends CI_Model {

	function Login_Model (){
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
		$this->load->library('session');
	}	

	function login($username, $passwd){
		$url = $this->api_host."/auth/getkey";
		$getkey = request($url);
		if ($getkey['httpcode'] == '200'){
			$getkey_data = $getkey['data']['key'];
			$passwd = md5(md5($passwd).$getkey_data);
			$api_data = request($this->api_host."/auth/signin?username=$username&passwd=$passwd");
			$this->session->set_userdata('user_id', $api_data['data']['user_id']);
			$return = $api_data;
		}
		else {
			$return = $getkey;
		}
		return $return;
	}
}
