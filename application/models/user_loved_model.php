<?php
class user_loved_model extends CI_Model {

	var $api_host;

	function user_loved_model () {	//{{{
		parent::__Construct();
		$this->load->helper('api');
		$this->api_host = $this->config->item('api_host');
	}	//}}} 

	function get_loved ($user_id, $url_data, $type, $mag_category = null) {	//{{{
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

	function my_magazines ($user_id, $url_data, $type){	//用户自己的杂志{{{
		$api_url = $this->api_host."/user/$user_id/magazines/$type?start=" . $url_data['start'] . '&limit=' . $url_data['limit'];
		if ($type == 'unpublished') {
			$session_id = $this->session->userdata('session_id');
			$api_url .= "?session_id=$session_id"; 
		}
		$request = request($api_url);
		array_push($request['data'], $this->_get_my_magazines_total());
		return $request;
	}	//}}}

	function _get_my_magazines_total () {	//获取自己已发布及未发布杂志的总数{{{
		$session_id = $this->session->userdata('session_id');
		$user_id = $this->session->userdata('id');
		$published_data = request($this->api_host."/user/$user_id/magazines/published?start=0&limit=0");
		$unpublished_data = request($this->api_host."/user/$user_id/magazines/unpublished?start=0&limit=0&session_id=$session_id");
		$total = array(
				'pub_total' => $published_data['data']['totalResults'],
				'unpub_total' => $unpublished_data['data']['totalResults'],
				);
		return $total;	
	}	//}}}

}
