<?php

class Ads_Model extends CI_Model{
	function ads_model(){
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
	}
	
	function _get_list($gets,$position){
		$ads = api($this->api_host."/magazine/ads?limit=".$gets['limit']."&start=".$gets['start']."&position=".$position);
		return $ads;
	}
}
