<?php
class user_loved_model extends CI_Model {

	var $api_host;

	function user_loved_model () {	//{{{
		parent::__Construct();
		$this->load->helper('api');
		$this->api_host = $this->config->item('api_host');
	}	//}}} 

	function get_loved ($user_id, $url_data, $type, $mag_category = null) {	//{{{
		switch ($type) {
			case 'followees':
				$uri = "followees";
				break;
			case 'followers':
				$uri = "followers";
				break;
			case 'element':
				$uri = "elements/like";
				break;
			case 'magazine':
				$uri = "magazines/like";
				break;
		}
		$loved = request($this->api_host . "/user/$user_id/" . $uri  .  "?start=" . $url_data['start'] . "&limit=" . $url_data['limit']);
		return $loved['data'];
	}	//}}}

	function my_magazines ($user_id, $url_data, $type){	//用户自己的杂志{{{
		$api_url = $this->api_host."/user/$user_id/magazines/$type?start=" . $url_data['start'] . '&limit=' . $url_data['limit'];
		if ($type == 'unpublished') {
			$session_id = $this->session->userdata('session_id');
			$api_url .= "?session_id=$session_id"; 
		}
		$request = request($api_url);
		if ($this->session->userdata('session_id')) array_push($request['data'], $this->_get_my_magazines_total());
		return $request;
	}	//}}}

	function _get_my_magazines_total () {	//获取自己已发布及未发布杂志的总数{{{
		$session_id = $this->session->userdata('session_id');
		$user_id = $this->session->userdata('user_id');
		$published_data = request($this->api_host."/user/$user_id/magazines/published?start=0&limit=0");
		$unpublished_data = request($this->api_host."/user/$user_id/magazines/unpublished?start=0&limit=0&session_id=$session_id");
		$total = array(
				'pub_total' => $published_data['data']['totalResults'],
				'unpub_total' => $unpublished_data['data']['totalResults'],
				);
		return $total;	
	}	//}}}

	function pub_mag () {	//发布杂志{{{
		$mag_id = $this->input->get('mag_id');
		$session_id = $this->session->userdata('session_id');
		$pub_mag = request($this->api_host . "/magazine/". $mag_id . "/pub?session_id=" . $session_id, json_encode(''), 'PUT', false);
		if ($pub_mag['httpcode'] == '202'){
			$msg = '发布成功';
		}
		else {
			$msg = '发布失败';
		}
		return $msg;
	}
	
	function appc_mag () {	//申请审核杂志{{{
		$magazine_id = $this->input->post('mag_id');
		$session_id = $this->session->userdata('session_id');
		$mag_info = array(
				'name' => $this->input->post('name'),
				'mag_category' => $this->input->post('mag_category'),
				'description' => $this->input->post('description'),
				'tag' => $this->input->post('tag'),
				);
print_r($mag_info);exit;
		$appc_mag = request($this->api_host."/magazine/$magazine_id?session_id=$session_id", json_encode($mag_info), 'PUT', false);
		if ($appc_mag['httpcode'] == '202'){
			$msg = 'ok';
		}
		else {
			$msg = 'error';
		}
		return $msg;
	}	//}}}

}
