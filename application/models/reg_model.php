<?php
class reg_model extends CI_Model{
	function reg_model (){
		parent::__construct();
	}
	
	function reg ($username, $passwd){
		$api_data = request($this->api_host."/magazine/reg?username=$username&passwd=$passwd");
		echo "<pre>";print_r($api_data);
		if(isset($api_data['data']['errcode']) && $api_data['data']['errcode'] == '0'){
			return "注册成功";	
		}
		else if (isset($api_data['data']['errcode'])){
			return $api_data['data']['msg'];
		}
		else {
			return "注册失败;api未返回数据";
		}
	}
}
