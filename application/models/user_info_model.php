<?php class user_info_model extends CI_Model {

	var $default_tag_list = array(
			'0' => array('爱刷机', '爱加班', '苦逼程序员', '爱玩神仙道', '爱旅游', '爱吃田老师', '爱蹲坑', '机械键盘控'),
			'1' => array('萌正太', '美容滴', '老房子', '忧郁多', '斯蒂芬', '宝石钻戒', '半夜看电影'),
			'2' => array('蓉嬷嬷', '腊肉炒饭', '我爱DOTA', '任诗钊', '申妹妹', '要了我老命了', '爱旅游', 'Good Idea'),
			'3' => array('AIR控', '手尖上的键盘', '我恨瀑布流', '爱阅读', '爱分享', '自助游', '天生黑眼圈', '旅游'),
			);

	function user_info_model () {	//{{{
		parent::__construct();		
		$this->load->helper('api');
		$this->api_host = $this->config->item('api_host');
	}	//}}}

	function get_user($user_id) {
		$return = request($this->api_host . "/user/" . $user_id);
		return $return['data'];
	}

	function apply_author($code) {
		$user_id = $this->session->userdata('user_id');
		$params = array('code' => $code, 'session_id' => $this->session->userdata('session_id'));
		return request($this->api_host . "/user/$user_id/applyAuthor?" .  http_build_query($params));
	}

	function get_user_tags ($user_id) {
		$request = request($this->api_host . "/user/$user_id");
		if ($request['httpcode'] == '200'){
			$tags = is_array($request['data']['tags']) ? implode(",", $request['data']['tags']) : $request['data']['tags'];
			return $tags;
		}
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

	function get_tag_list () {
		return json_encode($this->default_tag_list[array_rand($this->default_tag_list, 1)]);
	}
	
	function _modify_user_pwd($data){
		$session_id = $this->session->userdata("session_id");
		$item = request($this->api_host . "/user/changepwd?session_id=$session_id", $data, 'POST');
		if ($item['httpcode'] == '200'){
			if ($item['data']['status'] == 'OK'){
				$msg = "修改成功";
			}else{
				$msg = "原密码错误";
			}
		}else{
			$msg = "修改失败";
		}
		return $msg;
	}
}
