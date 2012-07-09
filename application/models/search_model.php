<?php
	class search_model extends CI_Model {

	function search ($type, $start, $limit, $keyword=null) {
		/**
		  type - magazine/author
		 */
		if ($type == 'author') $apiname = 'users';
		else $apiname = "${type}s";
		$result = request($this->config->item('api_host') . "/$apiname?" .
				http_build_query(array('start' => $start, 'limit' => $limit, 'q' => $keyword)));
		return $result['data'];
	}

}
