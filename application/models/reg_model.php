<?php
class reg_model extends CI_Model{
	function reg_model (){
		parent::__construct();
	}
	
	function reg ($api_data){
		if($api_data['errcode'] == '1'){
			return $api_data['msg'];
		}
		else{
			return "注册成功";	
		}	
	}
}
