<?php class auth extends CI_Model {

	var $user_id;
	var $session_id;

	function __construct () {
		parent::__construct();
		$this->load->helper('api');
		$this->load->library('session');
		$this->user_id = $this->session->userdata('id');
		$this->session_id = $this->session->userdata('session_id');
	}

	function auth_user () {
		if ($this->user_id && $this->session_id) {
			$user_info = request($this->config->item('api_host') . "/user/" . $this->user_id);
			$user_info['data']['image'] =  $user_info['data']['image'] ? $user_info['data']['image'] : "/sta/images/userhead/50.jpg";
			$data = array('user_info' => $user_info['data']);
			$this->smarty->assign($data);
		}
	}

	function check () {
		if (!$this->user_id or !$this->session_id) exit("haven't userId or session_id error, signin please"); 
	}

}
