<?php
class Magazine extends MY_Controller {

	var $api_host;

	function Magazine (){
		parent::__construct();
		$this->load->helper('api');
		$this->api_host = $this->config->item('api_host');
		$this->load->model('Login_Model');
		$this->load->model('mag_model');
		$this->load->model('love_model');
		$this->load->model('ads_model');
		$this->load->model('mag_element_model');
		$this->load->model('reg_model');
		$this->load->model('comment_model');
		$this->load->library('session');
		$this->load->library('session');
	}

	function _get_more ($keys, $input){	//{{{
		$return = array();
		foreach ($keys as $key){
			$return[$key] =	$this->input->$input($key);
		}
		return $return;
	}	//}}}

	function _get_more_non_empty($more) {	//{{{
		$return = array();
		foreach ($more as $item) {
			$return[$item] = $this->_get_non_empty($item);
		}
		return $return;
	}	//}}}

	function mag_list (){	//杂志列表{{{
		$keys = array('start', 'limit', 'status');
		$gets = $this->_get_more_non_empty($keys);
		$type = $this->input->get('type');
		$mag_list = $this->mag_model->_get_mag_list($gets, $type);
		$this->_json_output($mag_list);
		//$this->smarty->view('index.tpl');
	}	//}}}

	function detail (){	//详情页`{{{
		$id = $this->_get_non_empty('id');
		$this->session->userdata;
		$sid = $this->session->userdata('session_id');
		$detail = api($this->api_host."/magazine/detail?id=".$id);
		$comment_data = $this->comment_model->comment_list('magazine', $id, 0, 5);
		$comment = $comment_data['data'];
		$data = array(
			'sid' => $sid,
			'api_host' => $this->api_host,
			'detail' => $detail,
			'comment' => $comment,
		);
		$this->smarty->view('magazine/comment.html', $data);
	}//}}}

	function comment (){	//评论{{{
		$sid = $this->session->userdata('sid');
		$type = $this->_get_non_empty('type');
		$object_id = $this->_get_non_empty('object_id');
		$start = $this->_get_non_empty('start');
		$limit = $this->_get_non_empty('limit');
		$comment = $this->comment_model->comment_list($type, $object_id, $start, $limit);
		$data = array(
				'sid' => $sid,
				'api_host' => $this->api_host,
				'comment' => $comment['data'],
				);
		print_r($data);exit;
		$this->smarty->view('magazine/comment.html', $data);
	}	//}}}

	function refresh_comment(){	//{{{
		$type = $this->input->post('type');
		$object_id = $this->input->post('object_id');
		$comment = $this->input->post('comment');
		$parent_id = $this->input->post('parent_id');
		$data = $this->comment_model->refresh_comment($type, $object_id, $parent_id, $comment);
		echo json_encode($data);
	}	//}}}
	
	function get_same_author_mag(){		//获取该作者的其他杂志{{{
		$keys = array('mag_id', 'limit', 'start');
		$status = $this->input->get('status');
		$gets = $this->_get_more_non_empty($keys);
		$gets['status'] = $status;
		$mag_list = $this->mag_model->_get_same_author_mag($gets);
		$this->_json_output($mag_list);
	}//}}}
	
	function get_same_category_mag(){		//获取同类型杂志{{{
		$keys = array('mag_id', 'limit', 'start');
		$status = $this->input->get('status');
		$gets = $this->_get_more_non_empty($keys);
		$gets['status'] = $status;
		$mag_list = $this->mag_model->_get_same_category_mag($gets);
		$this->_json_output($mag_list);
	}//}}}

	function loved_num(){		//喜欢数量{{{
		$loved_num = $this->love_model->_get_user_loved_nums();
		$this->_json_output($loved_num);
	}//}}}

	function loved_data(){		//喜欢数据{{{
		$keys = array('start', 'limit');
		$gets = $this->_get_more_non_empty($keys);
		$type = $this->input->get('type');
		$loved_data = $this->love_model->_get_loved_data($gets, $type);
		$this->_json_output($loved_data);
	}//}}}

	function user_comment(){		//获得评论{{{
		$keys = array('start', 'limit');
		$gets = $this->_get_more_non_empty($keys);
		$magazine_id = $this->input->get('magazine_id');
		$user_comment = api($this->api_host."/magazine/get_user_comment?limit=".$gets['limit']."&start=".$gets['start']."&magazine_id=".$magazine_id);
		$this->_json_output($user_comment['data']);
	}//}}}

	function mag_element(){			//杂志元素{{{
		$keys = array('for', 'start', 'limit');
		$gets = $this->_get_more_non_empty($keys);
		$type = $this->input->get('type');
		$mag_element = $this->mag_element_model->_get_mag_element($gets, $type);
		$this->_json_output($mag_element);
	}//}}}

	function category(){		//杂志分类{{{
		$cat_info = $this->mag_model->_get_category();
		$this->_json_output($cat_info['data']);
	}//}}}

	function ads(){		//广告{{{
		$keys = array('limit', 'start');
		$position = $this->input->get('position');
		$gets = $this->_get_more_non_empty($keys);
		$ads = $this->ads_model->_get_list($gets, $position);
		$this->_json_output($ads);
	}//}}}

	function nums_of_loved(){		//获取对象(杂志，元素，作者)被喜欢的次数{{{
		$keys = array('loved_id', 'loved_type');
		$gets = $this->_get_more_non_empty($keys);
		$nums = $this->love_model->_get_nums_of_loved($gets);
		$this->_json_output($nums);
	}//}}}

	function index(){		//首页展示{{{
		$data = $this->mag_model->get_mag_list_for_index();
		$this->_json_output($data);
	//	$this->smarty->view('index.html',$data);
	}//}}}

	function _get_download_url(){		//获取杂志下载地址{{{
		$id = $this->_get_non_empty('id');
		$url = api($this->api_host."/magazine/download?id=".$id);
		$this->_json_output($url);
	}	//}}}
	
	function get_mag_for_list(){	//{{{
		$keys = array('mag_category', 'limit', 'start', 'status');
		$gets = $this->_get_more_non_empty($keys);
		$tag = $this->input->get('tag');
		$gets['tag'] = $tag;
		$mag_list = $this->mag_model->_get_mag_for_list($gets);
		$this->_json_output($mag_list);
	}	//}}}

	function bookstore(){	//{{{
		$user_id = $this->_get_non_empty('user_id');
		$data = api($this->api_host.'/magazine/bookstore?user_id='.$user_id);
		print_r($data);
	}	//}}}

}
