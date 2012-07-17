<?php

class Msgpub extends MY_Controller {

	function __construct() {
		parent::__construct();
	}
	
	function find_pwd_mail() { //{{{
		/**
		  add to check message queue
		  */
		$email = $this->_get_non_empty('email');
		$nickname = $this->_get_non_empty('nickname');
		$url = $this->_get_non_empty('url');
		$this->load->model('msgbroker');
		$res = $this->msgbroker->find_pwd_mail($email, $nickname, $url);
		$this->_json_output($res);
	} //}}}

}
