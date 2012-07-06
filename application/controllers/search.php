<?php
include 'magazine.php';

class search extends Magazine{
	function search () {
		parent::__construct();	
		$this->load->model('search_model');
	}

	function index ($keyword, $type=null, $page='1') {	//{{{
		$page = $page ? $page : 1;
		if ($type) {
			$limit = $type == 'magazine' ? 20 : 60;
			$start = ($page-1)*$limit;
		} 
		else {
			$start = '0';
			$limit = 20;
		}
		$data = $this->search_model->search($start, $limit, $keyword);
		$extra = array('keyword' => $keyword, 'type' => $type);
		if ($type) $extra['page_list'] = $this->page_model->page_list("/search/$keyword/$type", $limit, $data[$type."s"]['totalResults'], $page);
		$this->smarty->view('search.tpl', array_merge($data, $extra));
	}	//}}}
}
