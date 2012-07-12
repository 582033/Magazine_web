<?php class auth extends CI_Model {

	var $user_id;
	var $session_id;
	var $cookie_username;
	var $cookie_rmsalt;

	function __construct () {
		parent::__construct();
		$this->load->helper('api');
		$this->load->helper('url');
		$this->load->helper('cookie');
		$this->load->library('session');
		$this->user_id = $this->session->userdata('id');
		$this->session_id = $this->session->userdata('session_id');
		$this->cookie_username = $this->input->cookie('username');
		$this->cookie_rmsalt = $this->input->cookie('rmsalt');
	}

	function auth_user () {
		if ((!$this->user_id or !$this->session_id) && ($this->cookie_username && $this->cookie_rmsalt)) {
			$signin = request($this->api_host."/auth/signin?username=$this->cookie_username&rmsalt=$this->cookie_rmsalt");
			if ($signin['httpcode'] == '200' && $signin['data']['status'] == 'OK')	{
				$this->session->set_userdata($api_data['data']);
			}
			else {
				delete_cookie("username");
				delete_cookie("rmsalt");
			}
			redirect("/");
		}
		else {
			if ($this->user_id && $this->session_id) {
				$user_info = request($this->config->item('api_host') . "/user/" . $this->user_id);
				$user_info['data']['image'] =  $user_info['data']['image'] ? $user_info['data']['image'] : "/sta/images/userhead/50.jpg";
				$data = array('user_info' => $user_info['data']);
				$this->smarty->assign($data);
			}
		}
	}

	function is_logged_in() {
		return $this->user_id and $this->session_id;
	}
}
