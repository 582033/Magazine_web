<?php
class user_loved_model extends CI_Model {

	var $api_host;

	function user_loved_model () {	//{{{
		parent::__Construct();
		$this->load->helper('api');
		$this->api_host = $this->config->item('api_host');
	}	//}}} 

	function get_loved ($url_data, $type, $mag_category = null) {	//{{{
		if (isset($url_data['mag_category']) && $url_data['mag_category'] != '') {
			$mag_category = $url_data['mag_category'];
		}
		if (isset($url_data['element_type']) && $url_data['element_type'] != '') {
			$element_type = $url_data['element_type'];
		}
		//@$loved = request($this->api_host ."/magazine/get_loved_data?limit=". $url_data['limit'] ."&start=". $url_data['start']  ."&type=". $type ."&session_id=". $url_data['session_id'] ."&mag_category=$mag_category&element_type=$element_type");
		switch ($type) {
			case 'author':
				$loved = request($this->api_host . "/user/me/followers?start=" . $url_data['start'] . "&limit=" . $url_data['limit']);	
				break;
			case 'element':
				$loved = request($this->api_host . "/user/me/followers?start=" . $url_data['start'] . "&limit=" . $url_data['limit']);	
				break;
		}
		return $loved['data'];
	}	//}}}

	function get_loved_magazine ($url_data){	//{{{
		$loved_magazine = $this->get_loved($url_data, 'magazine');
		foreach ($loved_magazine as &$item){
			if (isset($item['user_id']) && $item['user_id'] != '') {
				$nickname = api($this->api_host ."/magazine/get_nickname?user_id=". $item['user_id']);
				$item['nickname'] = $nickname['nickname'];
			}
			else {
				$item['nickname'] = null;
			}
		}
		return $loved_magazine;
	}	//}}}
	

}
