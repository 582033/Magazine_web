<?php
include 'magazine.php';

class User extends Magazine {


	function User () {	//{{{
		parent::__construct();
		$this->load->model('user_loved_model');
		$this->load->model('user_info_model');

/*
 *		验证登录状态
 */
		$this->load->model('auth');
		$this->auth->auth_user();

		$this->load->helper('api');
		$this->load->library('session');
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
			/*
			echo "<pre>";
			print_r($return);
			$this->smarty->assign('commend_author', $return);
			*/
			//redirect($this->current_url);
			redirect("/");
		}
		$this->smarty->view('user/signin.tpl');
	}	//}}}

	function logout () {	//{{{
		$this->session->sess_destroy();	
		redirect("/");
	}	//}}}

	function magazine ($page = '1'){	//喜欢的杂志列表{{{
		$this->auth->check();
		$url_data = array(
				'start' => ($page-1)*($this->limit),
				'limit' => $this->limit,
				);
		$mag_category = $this->input->get('mag_category');
		if ($mag_category) $url_data['mag_category'] = $mag_category;
		$loved_author = $this->user_loved_model->get_loved($url_data, 'author');
		$loved_magazine = $this->user_loved_model->get_loved($url_data, 'magazine');
		/*
		   get_loved($url_data, $type) $type[element/author/magazine]
		*/
		$data = array(
				'page_list' => $this->page_model->page_list("/user/magazine", $this->limit, $loved_magazine['totalResults'], $page),
				'loved_author' => $loved_author,
				'loved_magazine' => $loved_magazine,
				);
		$this->smarty->view('user/user_center_main.tpl', $data);
	}	//}}}

	function element ($page = '1'){	//喜欢的元素列表{{{
		$this->auth->check();
		$url_data = array(
				'start' => ($page-1)*($this->limit),
				'limit' => $this->limit,
				);
		$element_type = $this->input->get('element_type');
		if ($element_type) $url_data['element_type'] = $element_type;
		$loved_element = $this->user_loved_model->get_loved($url_data, 'element');
		$loved_author = $this->user_loved_model->get_loved($url_data, 'author');
		/*
		   get_loved($url_data, $type) $type[element/author/magazine]
		*/
		$data = array(
				//'page_list' => $this->page_list("/user/element", 100, $page),
				'page_list' => $this->page_model->page_list("/user/element", $this->limit, $loved_element['totalResults'], $page),
				'loved_author' => $loved_author,
				'loved_element' => $loved_element,
				);
		$this->smarty->view('user/user_center_main.tpl', $data);
	}	//}}}

	function bookstore($page = '1'){	//{{{
		$this->auth->check();
		$url_data = array(
				'start' => ($page-1)*($this->limit),
				'limit' => $this->limit,
				);
		$user_id = 2;//$this->session->userdata('id');
		$request = request($this->api_host.'/user/'.$user_id.'/magazines/published?start=' . $url_data['start'] . '&limit=' . $url_data['limit']);
		$loved_author = $this->user_loved_model->get_loved($url_data, 'author');
		$data = array(
				'page_list' => $this->page_model->page_list("/user/bookstore", $this->limit, $request['data']['totalResults'], $page),
				'loved_author' => $loved_author,
				'bookstore' => $request['data'],
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
	
	public function bind() {
		$data = array();
		$sessionid = $this->session->userdata('session_id');
		$this->load->model('Sns_Model');
		$unbind = Sns_Model::getAllSns();
		if(!$sessionid) return;

		$result = request($this->api_host.'/sns/bindinfo',array('session_id'=>$sessionid),'GET');
		if($result['httpcode']!=200) return;
		foreach ($result['data'] AS $v) {
			$data['bindinfo'][$v['snsid']] = $v;
			unset($unbind[$v['snsid']]);
		}
		$data['unbind'] = $unbind;
		$this->smarty->view('user/bind.tpl',$data);
		
	}
	public function unbind() {
		$data = array(
			'error'=>null,
			'status'=>0,
			'data'=>null
		);
		$sessionid = $this->session->userdata('session_id');
		$snsid = $this->input->get('snsid');
		$this->load->model('Sns_Model');
		$unbind = Sns_Model::getAllSns();
		if($sessionid && in_array($snsid,Sns_Model::getAllSns()) && $this->input->is_ajax_request()) {
			$snsid = $this->input->get('snsid');
			$result = request($this->api_host.'/sns/unbind',array('session_id'=>$sessionid,'snsid'=>$snsid),'GET');
			if($result['httpcode']!=200) {
				$data['error'] = '';
			}
			elseif($result['data'] === true) {
				$data['status'] = 'OK';
			}
		}
		$this->_json_output($data);
	}
}
