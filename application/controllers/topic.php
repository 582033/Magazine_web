<?php

class Topic extends MY_Controller {

	function topic(){
		parent::__construct();
		$this->load->helper('api');
		$this->load->model('mag_model');	
	}

	function self_tour(){		//1001自驾游{{{
		$limit = 8;
		$result = $this->mag_model->_get_topic_magazine($limit);
		$mag_recommend = $result['data']['items'];
		$data = array('mag_recommend' => $mag_recommend);
		$this->smarty->view('topic/self_tour.tpl', $data);
	}//}}}
	
	function on_line(){		//上线专题{{{
		$this->smarty->view('topic/on_line.tpl');
	}//}}}
}
?>
