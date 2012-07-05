<?php
	class search_model extends CI_Model {

	function search ($start, $limit, $keyword=null) {
		$magazines = request($this->config->item('api_host') . "/magazines?start=$start&limit=$limit&q=$keyword");
		$author = request($this->config->item('api_host') . "/users?start=$start&limit=$limit&q=$keyword");
		$return = array(
						'magazines' => $magazines['data'],
						'authors' => $author['data'],
						);
		return $return;
	}

}
