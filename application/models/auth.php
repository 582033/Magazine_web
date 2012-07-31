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
		$this->check_cookie();
		return array(
				'id' => $this->session->userdata('user_id'),
				'session_id' => $this->session->userdata('session_id'),
				);
	}

	function check_cookie () {
		$this->load->helper('cookie');
		$session_id_cookie = $this->input->cookie('session_id');
		$session_id_get = $this->session->userdata('session_id');
		if ($session_id_cookie != $session_id_get) {
			$this->load->model('user_info_model');
			$user_info = $this->user_info_model->get_user_info();
			$this->load->model('login_model');
			$this->login_model->set_signin_cookie(array_merge($user_info, array('session_id' => $session_id_get)));
		}
	}
}
