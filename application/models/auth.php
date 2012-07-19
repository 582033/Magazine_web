<?php

class auth extends CI_Model {

	function __construct () {
		parent::__construct();
		$this->load->library('session');
	}


	function get_sess_userdata() {
		$this->load->library('session');
		if (!$this->session->checkAndRead()) {
			return FALSE;
		}
		if (!$this->session->userdata('user_id')) {
			$this->session->sess_destroy();
			return FALSE;
		}
		return array(
				'id' => $this->session->userdata('user_id'),
				'session_id' => $this->session->userdata('session_id'),
				);
	}
}
