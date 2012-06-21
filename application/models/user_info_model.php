<?php class user_info_model extends CI_Model {

	function user_info_model () {	//{{{
		parent::__construct();		
		$this->load->helper('api');
		$this->api_host = $this->config->item('api_host');
	}	//}}}

	function get_user_tags ($user_id) {
		$tags = request($this->api_host . "/user/" . $user_id . "/tags/own");
		if (isset($tags['data']))
			$tags = $tags['data'];
		else
			$tags = null;
		//echo $this->api_host . "/user/" . $user_id . "/tags/own";
		//print_r($tags);
		return $tags;

	}
}
