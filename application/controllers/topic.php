<?php
include 'magazine.php';
class Topic extends Magazine {

	function topic(){
		parent::__construct();
		$this->load->helper('api');
	}

	function self_tour(){		//1001自驾游{{{
		$pageid = 'topic_self_tour';
		$common_data = $this->_get_common_data($pageid);
		$limit = 8;
		$this->load->model('mag_model');	
		$result = $this->mag_model->_get_topic_magazine($limit);
		$mag_recommend = $result['data']['items'];
		$data = array('mag_recommend' => $mag_recommend);
		$data = array_merge($data, $common_data);
		$this->smarty->view('topic/self_tour.tpl', $data);
	}//}}}
	
	function on_line(){		//上线专题{{{
		$pageid = 'topic_on_line';
		$data = array();
		$common_data = $this->_get_common_data($pageid);
		$data = array_merge($data, $common_data);
		$this->smarty->view('topic/on_line.tpl', $data);
	}//}}}
}
?>
