<?php
class Magazine extends MY_Controller {
	
	var $api_host;
	
	function Magazine (){
		parent::__construct();
		$this->load->helper('api');
		$this->api_host = $this->config->item('api_host');
		$this->load->model('Login_Model');	
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
		$username = $this_non_empty();
	}	//}}}

	function login (){	//{{{
	//	$username = $this->input->post('username');
	//	$passwd = $this->input->post('passwd');
		$username = $this->input->get('username');
		$passwd = $this->input->get('passwd');
		$getkey = api($this->api_host."/magazine/getkey");	
		echo "<pre>";print_r($getkey);
		$return = $this->Login_Model->login($getkey, $username, $passwd);
		echo "<pre>";print_r($return);
	}	//}}}

	function mag_list (){	//杂志列表{{{
		$keys = array('start', 'limit');
		$gets = $this->_get_more_non_empty($keys);
		$mag_list = api($this->api_host."/magazine/mag_list?start=".$gets['start']."&limit=".$gets['limit']);
		echo "<pre>";print_r($mag_list);
		//$this->smarty->view('index.tpl');
	}	//}}}

	function detail (){	//详情页`{{{
		$id = $this->_get_non_empty('id');		
		$detail = api($this->api_host."/magazine/detail?id=".$id);
		echo "<pre>";print_r($detail);
		//$this->smarty->view('index.tpl');
	}	//}}}
	
}
