<?php
class Magazine extends MY_Controller {
	
	var $api_host;
	
	function Magazine (){
		parent::__construct();
		$this->load->helper('api');
		$this->api_host = $this->config->item('api_host');
		$this->load->model('Login_Model');
		$this->load->model('mag_model');
		$this->load->model('love_model');
		$this->load->model('ads_model');
		$this->load->model('mag_element_model');
		$this->load->model('reg_model');
		$this->load->library('session');
	}
	
	function _get_more ($keys, $input){	//{{{		
		$return = array();
		foreach ($keys as $key){
			$return[$key] =	$this->input->$input($key);
		}
		return $return;
	}	//}}}
	
	function _get_more_non_empty($more) {	//{{{
		$return = array();
		foreach ($more as $item) {
			$return[$item] = $this->_get_non_empty($item);
		}
		return $return;
	}	//}}}

	function reg (){	//{{{
		$username = $this->_get_non_empty('username');
		$passwd = $this->_get_non_empty('passwd');
		$api_data = api($this->api_host."/magazine/reg?username=$username&passwd=$passwd");
		$return = $this->reg_model->reg($api_data);
		echo "<pre>";print_r($api_data);
		echo "<pre>";print_r($return);
	}	//}}}

	function login (){	//{{{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$username = $this->input->post('username');
			$passwd = $this->input->post('passwd');
			$getkey = api($this->api_host."/magazine/getkey");	
			$return = $this->Login_Model->login($getkey, $username, $passwd);
			print_r($return);
			$this->session->set_userdata('sid', $return['session_id']);
		}
		$this->smarty->view('user/login.tpl');
	}	//}}}

	function mag_list (){	//杂志列表{{{
		$keys = array('start', 'limit');
		$gets = $this->_get_more_non_empty($keys);
		$type = $this->input->get('type');
		$mag_list = $this->mag_model->_get_mag_list($gets, $type);
		$this->_json_output($mag_list);
		//$this->smarty->view('index.tpl');
	}	//}}}

	function detail (){	//详情页{{{
		$id = $this->_get_non_empty('id');		
		$detail = api($this->api_host."/magazine/detail?id=".$id);
		echo "<pre>";print_r($detail);
		//$this->smarty->view('index.tpl');
	}	//}}}

function comment (){
	print_r($this->session->userdata);
	$sid = $this->session->userdata('sid');
	$data = array(
			'sid' => $sid,
			'api_host' => $this->api_host,
			);
	$this->smarty->view('magazine/comment.html', $data);
}
	
	
	
	
	
	
	
	
	
	
	function loved_num(){		//喜欢数量{{{
		$loved_num = $this->love_model->_get_loved_nums();
		$this->_json_output($loved_num);
	}//}}}
	
	function loved_data(){		//喜欢数据{{{
		$keys = array('start', 'limit');
		$gets = $this->_get_more_non_empty($keys);
		$type = $this->input->get('type');
		$loved_data = $this->love_model->_get_loved_data($gets, $type);
		$this->_json_output($loved_data);
	}//}}}

	
	function mag_element(){			//杂志元素{{{
		$keys = array('for', 'start', 'limit');
		$gets = $this->_get_more_non_empty($keys);
		$type = $this->input->get('type');
		$mag_element = $this->mag_element_model->_get_mag_element($gets, $type);
		$this->_json_output($mag_element);
	}//}}}
	
	function category(){		//杂志分类{{{
		$cat_info = $this->mag_model->_get_category();
		$this->_json_output($cat_info['data']);
	}//}}}
	
	function ads(){		//广告{{{
		$keys = array('limit', 'start');
		$position = $this->input->get('position');
		$gets = $this->_get_more_non_empty($keys);
		$ads = $this->ads_model->_get_list($gets, $position);
		$this->_json_output($ads);
	}//}}}

	function nums_of_loved(){		//获取对象(杂志，元素，作者)被喜欢的次数{{{
		$keys = array('loved_id', 'loved_type');
		$gets = $this->_get_more_non_empty($keys);
		$nums = $this->love_model->_get_nums_of_loved($gets);
		$this->_json_output($nums);
	}//}}}
	
	function index(){		//首页展示{{{
		$data = $this->mag_model->get_mag_list_for_index();
		$this->smarty->view('index.html',$data);
	}//}}}
	
	function comment (){ //评论{{{
		$magazine_id = $this->_get_non_empty('magazine_id');
		$start = $this->_get('start');
		$limit = $this->_get('limit');
		$this->session->userdata;
		$sid = $this->session->userdata('sid');
		$data = $this->comment_model->comment_list($magazine_id);
		$data = $data['data'];
		print_r($data);
	}

}
