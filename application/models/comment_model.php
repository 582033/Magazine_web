<?php
class Comment_model extends CI_Model {

	function Comment_model() {
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
	}

	function comment_list ($type, $object_id, $start=0, $limit=20) {
		$url = $this->api_host."/magazine/$object_id/comments?start=$start&limit=$limit";
		$data = request($url);
		return $data['data'];
	}

	function refresh_comment ($type, $object_id, $parent_id, $comment, $start=0, $limit=10) {
		$params = array(
			'comment' => $comment,
			'parent_id' => '0',
		);
		$session_id = $this->session->userdata('session_id');
		request($this->api_host."/magazine/$object_id/comments?session_id=$session_id", $params, "POST");
//		echo $this->api_host."/magazine/$object_id/comments?session_id=$session_id";exit;
		$data = request($this->api_host."/magazine/$object_id/comments?start=$start&limit=$limit");
		$this->api_host."/magazine/$object_id/comments?start=0&limit=5";
		return $data['data'];
	}
}
