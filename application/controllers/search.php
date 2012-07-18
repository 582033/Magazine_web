<?php
include 'magazine.php';

class search extends Magazine{
	function search () {
		parent::__construct();	
		$this->load->model('search_model');
	}

	function index ($type, $keyword, $page='1') {	//{{{
		$keyword = urldecode($keyword);
		if ($type && !in_array($type, array('all', 'magazine', 'author'))) {
			show_error("Bad type $type", 400);
		}
		if ($keyword === '') {
			show_error("Empty keyword", 400);
		}
		$page = $page ? $page : 1;
		if ($type == 'all') {
			$start = '0';
			$limit = 20;
			$types = array('magazine', 'author');
		}
		else {
			$limit = $type == 'magazine' ? 20 : 60;
			$start = ($page-1) * $limit;
			$types = array($type);
		}

		$results = array();
		foreach ($types as $type0) {
			$data = $this->search_model->search($type0, $start, $limit, $keyword);
			if ($type == 'all') {
				$data['moreUrl'] = "/search/$type0/" . urlencode($keyword);
			}
			$results[$type0 . 's'] = $data;
		}
		$words = array('旅游', '美食');
		$hotwords = array();
		foreach ($hotwords as $word) {
			$url = '/search/' . urlencode($word);
			if ($type) $url .= "/$type";
			$hotwords[] = array(
					'word' => $word,
					'url' => $url,
					);
		}

		$search_types = array();
		foreach (array('all' => '全部', 'magazine' => '杂志', 'author' => '作者') as $type0 => $name) {
			$search_types[] = array(
					'name' => $name,
					'url' => "/search/$type0/" . urlencode($keyword),
					'current' => $type == $type0,
					);
		}

		$extra = array(
				'keyword' => $keyword,
				'type' => $type,
				'hotwords' => $hotwords,
				'search_types' => $search_types,
				);
		if ($type != 'all') {
			$extra['page_list'] = $this->page_model->page_list("/search/$type/" . urlencode($keyword),
					$limit, $results[$type."s"]['totalResults'], $page);
		}
		$this->smarty->assign('title', $keyword."-1001夜互动阅读平台");
		$this->smarty->view('search.tpl', array_merge($results, $extra));
	}	//}}}
}
