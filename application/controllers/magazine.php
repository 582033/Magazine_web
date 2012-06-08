<?php
class Magazine extends MY_Controller {
	
	var $api_host;
	
	function Magazine (){
		parent::__construct();
		$this->load->helper('api');
		$this->api_host = $this->config->item('api_host');
	}

	function _get_more_non_empty($more) {	//{{{
		$return = array();
		foreach ($more as $item) {
			$return[$item] = $this->_get_non_empty($item);
		}
		return $return;
	}	//}}}

	function mag_list (){	//杂志列表{{{
		$keys = array('start', 'limit');
		$gets = $this->_get_more_non_empty($keys);
		$mag_list = api($this->api_host."/magazine/mag_list?start=".$gets['start']."&limit=".$gets['limit']);
		echo "<pre>";print_r($mag_list);
		//$this->smarty->view('index.tpl');
	}	//}}}

	function detail (){	//{{{
		$id = $this->_get_non_empty('id');		
		$detail = api($this->api_host."/magazine/detail?id=".$id);
		echo "<pre>";print_r($detail);
		//$this->smarty->view('index.tpl');
	}	//}}}
	
}
