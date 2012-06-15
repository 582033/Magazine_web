<?php

class Love_Model extends CI_Model{
	function love_model(){
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
	}
	
	function _get_nums_of_loved($keys){
		$nums = api($this->api_host."/magazine/nums_of_loved?loved_id=".$keys['loved_id']."&loved_type=".$keys['loved_type']);
		return $nums;
	}
	
	function _get_loved_data($gets, $type){
		$loved_data = api($this->api_host."/magazine/get_loved_data?limit=".$gets['limit']."&start=".$gets['start']."&type=".$type);
		return $loved_data['data'];
	}
	
	function _get_user_loved_nums(){
		$sid = $this->session->userdata('sid');
		$loved_num = api($this->api_host."/magazine/get_loved_nums?session_id=$sid");
		return $loved_num['data'];
	}
}
