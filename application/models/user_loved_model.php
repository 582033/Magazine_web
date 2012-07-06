<?php
class user_loved_model extends CI_Model {

	var $api_host;

	function user_loved_model () {	//{{{
		parent::__Construct();
		$this->load->helper('api');
		$this->api_host = $this->config->item('api_host');
	}	//}}} 

	function get_loved ($url_data, $type, $mag_category = null) {	//{{{
		$user_id = $this->session->userdata('id');
		switch ($type) {
			case 'author':
				$uri = "followees";
				break;
			case 'element':
				$uri = "elements/like";
				break;
			case 'magazine':
				$uri = "magazines/like";
				break;
		}
		$loved = request($this->api_host . "/user/$user_id/" . $uri  .  "?start=" . $url_data['start'] . "&limit=" . $url_data['limit']);
		return $loved['data'];
	}	//}}}

}
