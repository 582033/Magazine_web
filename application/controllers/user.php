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
		$mag_category = $this->input->get('mag_category');
		if ($mag_category) $url_data['mag_category'] = $mag_category;
		$loved_author = $this->user_loved_model->get_loved($url_data, 'author');
		$loved_magazine = $this->user_loved_model->get_loved_magazine($url_data);
		/*
		   get_loved($url_data, $type) $type[element/author/magazine]
		*/
		print_r($loved_magazine);
		//$this->smarty->view('user/magazine.tpl');
	}

	function element (){
		$key = array('start', 'limit', 'session_id');
		$url_data = $this->_get_more_non_empty($key);
		$element_type = $this->input->get('element_type');
		if ($element_type) $url_data['element_type'] = $element_type;
		$loved_author = $this->user_loved_model->get_loved($url_data, 'author');
		$loved_element = $this->user_loved_model->get_loved($url_data, 'element');
		/*
		   get_loved($url_data, $type) $type[element/author/magazine]
		*/
		print_r($loved_element);
		//$this->smarty->view('user/element.tpl');
	}

}

