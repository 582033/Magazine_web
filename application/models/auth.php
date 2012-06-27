<?php class auth extends CI_Model {

	function auth_user () {
		$this->smarty->assign('userdata', $this->session->userdata);
	}

}
