<?php
class Comment_model extends CI_Model {

	function Comment_model() {
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
	}

	function comment_list ($magazine_id, $start=0, $limit=20) {
		$url = $this->api_host."/magazine/get_user_comment?session_id=1&magazine_id=$magazine_id&start=$start&limit=$limit";
		return api($url);
	}

	function comment_add () {

	}
}
?>
