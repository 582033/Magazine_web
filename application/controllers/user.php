<?php
include 'magazine.php';

class User extends Magazine {
	
	function User () {	//{{{
		parent::__construct();
		$this->load->model('user_loved_model');
	}	//}}}

	function _get_json_values ($keys) {
		$return = array();
		foreach ($keys as $item) {
			$return[$item] = $this->input->post($item);
		}
		return json_encode($return, true);	
	}

	function magazine (){	//喜欢的杂志列表{{{
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
	}	//}}}

	function element (){	//喜欢的元素列表{{{
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
	}	//}}}

	function user_info () {	//设置个人信息{{{
		$session_id = $this->session->userdata('sid');
		$user_info = api($this->api_host."/magazine/user_info?session_id=$session_id");
		print_r($user_info);
		$this->smarty->view('user/user_info.tpl');
	}	//}}}

	function set_user_info () {	//{{{
		$session_id = $this->session->userdata('sid');
		$keys =	array('nickname', 'birthday', 'sex'); 
		$user_info = $this->_get_json_values($keys);
		$post = array('user_info' => $user_info);
		$url_with_get = $this->api_host."/magazine/set_user_info?session_id=$session_id";
		opt($url_with_get, $post);
	}	//}}}
}

