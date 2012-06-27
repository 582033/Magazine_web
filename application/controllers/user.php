<?php
include 'magazine.php';

class User extends Magazine {
	
	var $limit;

	function User () {	//{{{
		parent::__construct();
		$this->load->model('user_loved_model');
		$this->load->model('user_info_model');
		$this->load->model('page_model');

/*
 *		验证登录状态
 */
		$this->load->model('auth');
		$this->auth->auth_user();		

		$this->load->helper('api');
		$this->load->library('session');
		$this->limit = '3';
	}	//}}}

	function _get_json_values ($keys) {	//{{{
		$return = array();
		foreach ($keys as $item) {
			$return[$item] = $this->input->post($item);
		}
		return json_encode($return, true);	
	}	//}}}

	function signup (){	//{{{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$username = $this->input->post('username');
			$passwd = $this->input->post('passwd');
			$return = $this->reg_model->reg($username, $passwd);
			echo "<pre>";
			echo $return;
		}
		else {
			$this->smarty->view('user/signup.tpl');
		}
	}	//}}}

	function signin (){	//{{{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$username = $this->input->post('username');
			$passwd = $this->input->post('passwd');
			$return = $this->Login_Model->login($username, $passwd);
			echo "<pre>";
			print_r($return);
			$this->smarty->assign('commend_author', $return);
		}
		$this->smarty->view('user/signin.tpl');
	}	//}}}

	function logout () {	//{{{
		$this->session->sess_destroy();	
		echo "已退出登录";
	}	//}}}

	function magazine ($page = '1'){	//喜欢的杂志列表{{{
		$url_data = array(
				'start' => ($page-1)*($this->limit),
				'limit' => $this->limit,
				);
		$mag_category = $this->input->get('mag_category');
		$user_id = $this->session->userdata('id');
		if (!$user_id) exit("haven't userId, signin please"); 
		$user_info = $this->session->userdata;
		if ($mag_category) $url_data['mag_category'] = $mag_category;
		$loved_author = $this->user_loved_model->get_loved($url_data, 'author');
		$loved_magazine = $this->user_loved_model->get_loved($url_data, 'magazine');
		/*
		   get_loved($url_data, $type) $type[element/author/magazine]
		*/
		$data = array(
				'page_list' => $this->page_model->page_list("/user/magazine", $this->limit, 100, $page),
				'user_info' => $user_info,
				'loved_author' => $loved_author,
				'loved_magazine' => $loved_magazine,
				);
		$this->smarty->view('user/user_center_main.tpl');
	}	//}}}

	function element ($page = '1'){	//喜欢的元素列表{{{
		$url_data = array(
				'start' => ($page-1)*($this->limit),
				'limit' => $this->limit,
				);
		$element_type = $this->input->get('element_type');
		$user_id = $this->session->userdata('id');
		if (!$user_id) exit("haven't userId, signin please"); 
		$user_info = $this->session->userdata;
		if ($element_type) $url_data['element_type'] = $element_type;
		$loved_element = $this->user_loved_model->get_loved($url_data, 'element');
		$loved_author = $this->user_loved_model->get_loved($url_data, 'author');
		/*
		   get_loved($url_data, $type) $type[element/author/magazine]
		*/
		$data = array(
				//'page_list' => $this->page_list("/user/element", 100, $page),
				'page_list' => $this->page_model->page_list("/user/element", $this->limit, $loved_element['totalResults'], $page),
				'user_info' => $user_info,
				'loved_author' => $loved_author,
				'loved_element' => $loved_element,
				);
		$this->smarty->view('user/user_center_main.tpl', $data);
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
