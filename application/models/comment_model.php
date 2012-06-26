<?php
class Comment_model extends CI_Model {

	function Comment_model() {
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
	}

	function comment_list ($type, $object_id, $start=0, $limit=20) {
		$url = $this->api_host."/magazine/get_user_comment?session_id=1&type=$type&object_id=$object_id&start=$start&limit=$limit";
		$url_1 = request($url);
		return $url_1['data'];
	}

	function refresh_comment ($type, $object_id, $parent_id, $comment) {
		request($this->api_host."/magazine/comment?type=$type&object_id=$object_id&parent_id=$parent_id&comment=$comment");
		$data = request($this->api_host."/magazine/get_user_comment?type=$type&object_id=$object_id&start=0&limit=5");
		return $data['data'];
	}
}
