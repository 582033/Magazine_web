<?php
class user_loved_model extends CI_Model {

	var $api_host;

	function user_loved_model () {	//{{{
		parent::__Construct();
		$this->load->helper('api');
		$this->api_host = $this->config->item('api_host');
	}	//}}} 

	function get_loved ($url_data, $type) {	//{{{
		$loved_author = api($this->api_host ."/magazine/get_loved_data?limit=". $url_data['limit'] ."&start=". $url_data['start']  ."&type=". $type ."&session_id=". $url_data['session_id']);
		return $loved_author;
	}	//}}}
	

}
