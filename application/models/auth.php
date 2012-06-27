<?php class auth extends CI_Model {

	var $user_id;

	function __construct () {
		parent::__construct();
		$this->load->helper('api');
		$this->load->library('session');
		$this->user_id = $this->session->userdata('id');
	}

	function auth_user () {
		if ($this->user_id) {
			$user_info = request($this->config->item('api_host') . "/user/" . $this->user_id);
			$data = array('user_info' => $user_info['data']);
			$this->smarty->assign($data);
		}
	}

	function check () {
		if (!$this->user_id) exit("haven't userId, signin please"); 
	}

}
