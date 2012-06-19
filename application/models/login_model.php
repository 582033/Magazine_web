<?php
class Login_Model extends CI_Model {

	function Login_Model (){
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
	}	

	function login($getkey, $username, $passwd){
		$passwd = md5(md5($passwd).$getkey['key']);
		$api_data = api($this->api_host."/magazine/login?username=$username&passwd=$passwd");
		return $api_data;
	}
}
