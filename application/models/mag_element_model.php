<?php

class Mag_Element_Model extends CI_Model{
	function mag_element_model(){
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
	}
	
	function _get_mag_element($gets, $type){
		$mag_element = api($this->api_host."/magazine/get_mag_element?for=".$gets['for']."&limit=".$gets['limit']."&start=".$gets['start']."&type=".$type);
		return $mag_element['data'];
	}
}
