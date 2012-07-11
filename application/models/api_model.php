<?php
class Api_Model extends CI_Model {

	function Api_Model (){
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
	}

	function api_get($url, $params=NULL) {
		if (!preg_match('/^https?:/', $url)) $url = $this->api_host . $url;
		return request($url, $params, 'GET');
	}

	function api_signin($validate, $username, $passwd, $salt) {
		$return = $this->api_get('/auth/signin',
				array('username' => $username, 'passwd' => $passwd, 'key' => $salt));
		if ($validate) $this->_validate_api($return);
		return $return;
	}

	function api_getkey($validate) {
		$return = $this->api_get('/auth/getkey');
		if ($validate) $this->_validate_api($return);
		return $return;
	}

	function _validate_api($result) { //{{{
		if ($result['httpcode'] >= 300) {
			show_error_text($result['httpcode'], $result['data']);
		}
	} //}}}
}
