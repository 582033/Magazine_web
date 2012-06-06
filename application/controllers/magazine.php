<?php
class Magazine extends MY_Controller {
	
	function Magazine (){
		parent::__construct();
		$this->load->helper('api');
	}

	function _get_more_non_empty($more) {
		$return = array();
		foreach ($more as $item) {
			$return[$item] = $this->_get_non_empty($item);
		}
		return $return;
	}

	function mag_list (){	//杂志列表{{{
		$keys = array('start', 'limit');
		$gets = $this->_get_more_non_empty($keys);
		$mag_list = api("http://api.1001s.cn/magazine/mag_list?start=".$gets['start']."&limit=".$gets['limit']);
		print_r($mag_list);
	}	//}}}
}
