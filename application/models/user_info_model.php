<?php class user_info_model extends CI_Model {

	function user_info_model () {	//{{{
		parent::__construct();		
		$this->load->helper('api');
		$this->api_host = $this->config->item('api_host');
	}	//}}}

	function get_user_tags ($user_id) {
		$tags = request($this->api_host . "/user/" . $user_id . "/tags/own");
		if (isset($tags['data']))
			$tags = $tags['data'];
		else
			$tags = null;
		//echo $this->api_host . "/user/" . $user_id . "/tags/own";
		//print_r($tags);
		return $tags;

	}

	function get_user_info () {
		$info = request($this->api_host . "/user/me?session_id=" . $this->session->userdata('session_id'));
		if	($info['httpcode'] == '200') {
			$info['data']['birthday'] = $info['data']['birthday'] ? explode("-", $info['data']['birthday']) : null;
			return $info['data'];	
		}
	}

	function set_base ($data) {
		$session_id = $this->session->userdata("session_id");
		$request = request($this->api_host . "/user/me?session_id=$session_id", $data, 'PUT',false);
		if ($request['httpcode'] == '202'){
			$msg = "修改成功";
		}
		else {
			$msg = "修改失败";
		}
		return $msg;
	}
}
