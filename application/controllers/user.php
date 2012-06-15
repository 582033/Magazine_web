<?php
include 'magazine.php';

class User extends Magazine {

	function User () {
		parent::__construct();
		$this->load->model('user_loved_model');
	}

	function magazine (){
		$key = array('start', 'limit', 'session_id');
		$url_data = $this->_get_more_non_empty($key);
		$loved_author = $this->user_loved_model->get_loved($url_data, 'author');
		/*
		   get_loved($url_data, $type) $type[element/author/magazine]
		*/
		print_r($loved_author);
		//$this->smarty->view('user/magazine.tpl');
	}


}

