<?php
class Magazine extends MY_Controller {

	var $api_host;
	var $current_url;
	var $limit;

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
		$this->load->model('page_model');
		$this->load->library('session');
		$this->limit = '3';
/*
 *		验证登录状态
 */
		$this->load->model('auth');
		$this->auth->auth_user();
/*
 *		传递当前浏览页,使其登录后可以跳转到登录前的页面
 */
		$this->load->helper('url');
		//$this->current_url = current_url();
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

	function index(){		//首页显示{{{
		$index_info = $this->mag_model->_get_index_info();
		for ($i = 0; $i < count($index_info['elem_gallery']); $i++){
			if ($index_info['elem_gallery'][$i]['page'] == 'cover'){
				$index_info['elem_gallery'][$i]['page'] = 'p1';
			}else{
				$index_info['elem_gallery'][$i]['page'] = substr($index_info['elem_gallery'][$i]['page'], 0, 1) .  (substr($index_info['elem_gallery'][$i]['page'], 1)+2);
			}
			if (strlen($index_info['elem_gallery'][$i]['magId']) <= 3){
				$index_info['elem_gallery'][$i]['read_mag_id'] = $index_info['elem_gallery'][$i]['magId'];
			}else{
				$index_info['elem_gallery'][$i]['read_mag_id'] = substr($index_info['elem_gallery'][$i]['magId'], 0, 3);
			}
		}
		for ($j = 0; $j <count($index_info['elem_list']); $j++){
			if ($index_info['elem_list'][$j]['page'] == 'cover'){
				$index_info['elem_list'][$j]['page'] = 'p1';
			}else{
				$index_info['elem_list'][$j]['page'] = substr($index_info['elem_list'][$j]['page'], 0, 1) .  (substr($index_info['elem_list'][$j]['page'], 1)+2);
			}
			if (strlen($index_info['elem_list'][$j]['magId']) <= 3){
				$index_info['elem_list'][$j]['read_mag_id'] = $index_info['elem_list'][$j]['magId'];
			}else{
				$index_info['elem_list'][$j]['read_mag_id'] = substr($index_info['elem_list'][$j]['magId'], 0, 3);
			}
		}
		$this->smarty->view('magazine/index.tpl', $index_info);
	}//}}}

	function find_elements($page = '1'){		//元素列表页面{{{
		$start = ($page-1)*30;
		$limit = 30;
		//$this->page_model->page_list("/find", "每页显示的数量", "数据总数", $page)
		$element = $this->mag_model->_get_element_list($limit, $start);
		$page_list = $this->page_model->page_list("/find", $limit, $element['data']['totalResults'], $page);
		$element_list = $element['data']['items'];
		$mode = '/[0-9]{3}x[0-9]{3}/';
		for ($i = 0; $i < count($element_list); $i++){
			preg_match($mode, $element_list[$i]['image']['180'], $matches);
			$size[$i] = $matches[0];
			if ($element_list[$i]['thumbSize'] == '1x2'){
				$element_list[$i]['width'] = substr($size[$i], 0, 3);
				$element_list[$i]['height'] = substr($size[$i], 4, 3);
			}else{
				$element_list[$i]['width'] = substr($size[$i], 0, 3);
				$element_list[$i]['height'] = substr($size[$i], 4, 3) - 10;
			}
			if ($element_list[$i]['page'] == 'cover'){
				$element_list[$i]['page'] = 'p1';
			}else{
				$element_list[$i]['page'] = substr($element_list[$i]['page'], 0, 1) .  (substr($element_list[$i]['page'], 1)+2);
			}
			if (strlen($element_list[$i]['magId']) <= 3){
				$element_list[$i]['read_mag_id'] = $element_list[$i]['magId'];
			}else{
				$element_list[$i]['read_mag_id'] = substr($element_list[$i]['magId'], 0, 3);
			}

		}
		$data = array(
					'element_list' => $element_list,
					'page_list' => $page_list,
					);
		$this->smarty->view('magazine/element.tpl', $data);
	}//}}}

	function magazine_list($tag = 'tour_reader', $page = '1'){		//杂志列表页面{{{
		$page = $page ? $page : 1;
		$limit = 5;
		$start = ($page-1)*$limit;
		$mag_list = $this->mag_model->_get_magazines_by_tag($limit, $start);
		$totalResults = $mag_list[$tag]['data']['totalResults'];
		$page_list = $this->page_model->page_list("/mag_list/$tag", $limit, $totalResults, $page);
		$data = array(
				'items' => $mag_list[$tag]['data']['items'],
				'page_list' => $page_list,
				'tag' => $tag,
				);
		$this->smarty->view('magazine/magazine_list.tpl', $data);

	//	$page_list = $this->page_model->page_list("/mag_list/$tag/$page", $limit, $totalResults, $page);
/*		$data = array(
					'tour_reader' => $mag_list['tour_reader']['data']['items'],
					'foreign' => $mag_list['foreign']['data']['items'],
					'local' => $mag_list['local']['data']['items'],
					'page_list' => $page_list,
					);
		$this->smarty->view('magazine/magazine_list.tpl', $data);
*/
	}//}}}

	function main_magazine_list(){		//杂志二级列表页面{{{
		$limit_gallery = 4;
		$start_gallery = 0;
		$mag_recommend = $this->mag_model->_get_recommendation_mag($limit_gallery, $start_gallery);
		$limit_list = 15;
		$start_list = 0;
		$mag_list = $this->mag_model->_get_magazines_by_tag($limit_list, $start_list);
		$data = array(
					'mag_gallery' => $mag_recommend,
					'tour_reader' => $mag_list['tour_reader']['data']['items'],
					'foreign' => $mag_list['foreign']['data']['items'],
					'domestic' => $mag_list['domestic']['data']['items'],
					);
		$this->smarty->view('magazine/magazine.tpl', $data);
	}//}}}

	function magazine_detail($id){		//杂志详情页面{{{
		$magazine_id = $id;
		$magazine = $this->mag_model->_get_magazine_by_id($magazine_id);
		$magazine['publishedAt'] = substr($magazine['publishedAt'], 0, 10);
		if (strlen($magazine['id']) <= 3){
			$magazine['read_mag_id'] = $magazine['id'];
		}else{
			$magazine['read_mag_id'] = substr($magazine['id'], 0, 3);
		}
		$limit_recom = 6;
		$start_recom = 0;
		$limit_maylike = 6;
		$start_maylike = 6;
		$recommendation = $this->mag_model->_get_recommendation_mag($limit_recom, $start_recom);
		$maylike = $this->mag_model->_get_maylike_mag($limit_maylike, $start_maylike);
		$comment = $this->comment_model->comment_list('magazine', $magazine_id, $start=0, $limit=5);
		$data = array(
					'api_host' => $this->config->item('api_host'),
					'magazine' => $magazine,
					'recommendation' => $recommendation,
					'maylike' => $maylike,
					'comment' => $comment['items'],
					);
		$this->smarty->view('magazine/magazine_detail.tpl', $data);
	}//}}}

	function comment_list($id, $page){		//杂志评论页面{{{
	//	$this->auth->check();
		$limit = 10;
		$start = ($page-1)*$limit;
		$page = $page ? $page : 1;
	
	function comment_list($id){		//杂志评论页面{{{
		$this->auth->check();
		$magazine = $this->mag_model->_get_magazine_by_id($id);
		$comment = $this->comment_model->comment_list('magazine', $id, $start, $limit);
		$totalResults = $comment['totalResults'];
		$page_list = $this->page_model->page_list('magazine', $limit, $totalResults, $page, 'pagenav');
		$data = array(
					'magazine' => $magazine,
					'comment' => $comment['items'],
					'page_list' => $page_list,
					);
		$this->smarty->view('magazine/comment_list.tpl', $data);
	}//}}}

	function like($type, $type_id){		//喜欢杂志{{{
		//$this->auth->check();
		echo $type . "--" . $type_id;
		echo $this->session->userdata('id');
	//	$this->auth->check();
	}//}}}

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	function mag_list (){	//杂志列表{{{
		$keys = array('start', 'limit', 'status');
		$gets = $this->_get_more_non_empty($keys);
		$type = $this->input->get('type');
		$mag_list = $this->mag_model->_get_mag_list($gets, $type);
		$this->_json_output($mag_list);
		//$this->smarty->view('index.tpl');
	}	//}}}

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
				'comment' => $comment,
				);
//		$this->smarty->view('magazine/comment.html', $data);
	}	//}}}

	function refresh_comment(){	//{{{
		$type = $this->input->post('type');
		$object_id = $this->input->get('object_id');
		$comment = $this->input->post('comment');
		$parent_id = $this->input->post('parent_id');
		$start = $this->input->get('start');
		$limit = $this->input->get('limit');
		$data = $this->comment_model->refresh_comment($type, $object_id, $parent_id, $comment, $start, $limit);
		echo json_encode($data['items']);
	}	//}}}

	function get_same_author_mag(){		//获取该作者的其他杂志{{{
		$keys = array('mag_id', 'limit', 'start');
		$status = $this->input->get('status');
		$gets = $this->_get_more_non_empty($keys);
		$gets['status'] = $status;
		$mag_list = $this->mag_model->_get_same_author_mag($gets);
		$this->_json_output($mag_list);
	}	//}}}

	function get_same_category_mag(){		//获取同类型杂志{{{
		$keys = array('mag_id', 'limit', 'start');
		$status = $this->input->get('status');
		$gets = $this->_get_more_non_empty($keys);
		$gets['status'] = $status;
		$mag_list = $this->mag_model->_get_same_category_mag($gets);
		$this->_json_output($mag_list);
	}	//}}}

	function loved_num(){		//喜欢数量{{{
		$loved_num = $this->love_model->_get_user_loved_nums();
		$this->_json_output($loved_num);
	}	//}}}

	function loved_data(){		//喜欢数据{{{
		$keys = array('start', 'limit');
		$gets = $this->_get_more_non_empty($keys);
		$type = $this->input->get('type');
		$loved_data = $this->love_model->_get_loved_data($gets, $type);
		$this->_json_output($loved_data);
	}	//}}}

	function user_comment(){		//获得评论{{{
		$keys = array('start', 'limit');
		$gets = $this->_get_more_non_empty($keys);
		$magazine_id = $this->input->get('magazine_id');
		$user_comment = api($this->api_host."/magazine/get_user_comment?limit=".$gets['limit']."&start=".$gets['start']."&magazine_id=".$magazine_id);
		$this->_json_output($user_comment['data']);
	}	//}}}

	function mag_element(){			//杂志元素{{{
		$keys = array('for', 'start', 'limit');
		$gets = $this->_get_more_non_empty($keys);
		$type = $this->input->get('type');
		$mag_element = $this->mag_element_model->_get_mag_element($gets, $type);
		$this->_json_output($mag_element);
	}	//}}}

	function category(){		//杂志分类{{{
		$cat_info = $this->mag_model->_get_category();
		$this->_json_output($cat_info['data']);
	}	//}}}

	function ads(){		//广告{{{
		$keys = array('limit', 'start');
		$position = $this->input->get('position');
		$gets = $this->_get_more_non_empty($keys);
		$ads = $this->ads_model->_get_list($gets, $position);
		$this->_json_output($ads);
	}	//}}}

	function nums_of_loved(){		//获取对象(杂志，元素，作者)被喜欢的次数{{{
		$keys = array('loved_id', 'loved_type');
		$gets = $this->_get_more_non_empty($keys);
		$nums = $this->love_model->_get_nums_of_loved($gets);
		$this->_json_output($nums);
	}	//}}}

	function _get_download_url(){		//获取杂志下载地址{{{
		$id = $this->_get_non_empty('id');
		$url = api($this->api_host."/magazine/download?id=".$id);
		$this->_json_output($url);
	}	//}}}

	function get_mag_for_list(){	//获取列表页杂志列表{{{
		$keys = array('mag_category', 'limit', 'start', 'status');
		$gets = $this->_get_more_non_empty($keys);
		$tag = $this->input->get('tag');
		$gets['tag'] = $tag;
		$mag_list = $this->mag_model->_get_mag_for_list($gets);
		$this->_json_output($mag_list);
	}	//}}}

}
