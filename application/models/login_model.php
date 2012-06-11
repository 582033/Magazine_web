<?php
class Login_Model extends CI_Model {

	function Login_Model (){
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
	}	

	function login($getkey, $username, $passwd){
		$username = md5($username);
		$api_data = api($this->api_host."/magazine/login?username=$username&passwd=$passwd&session_id=".$getkey['session_id']);
		print_r($api_data);
		return $api_data;
	}
}
