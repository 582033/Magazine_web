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
		$user_id = $this->session->userdata('id');
		switch ($type) {
			case 'author':
				$loved = request($this->api_host . "/user/me/followers?start=" . $url_data['start'] . "&limit=" . $url_data['limit']);	
				break;
			case 'element':
				$loved = request($this->api_host . "/user/$user_id/elements/like?start=" . $url_data['start'] . "&limit=" . $url_data['limit']);
				break;
			case 'magazine':
				$loved = request($this->api_host . "/user/$user_id/magazines/like?start=" . $url_data['start'] . "&limit=" . $url_data['limit']);
				break;
		}
		return $loved['data'];
	}	//}}}

}
