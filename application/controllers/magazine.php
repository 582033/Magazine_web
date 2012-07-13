<?php
class Magazine extends MY_Controller {

	var $api_host;
	var $current_url;
	var $limit;
	var $cate_map = array(
			'tour_recommendation' => '目的地推荐',
			'tour_foreign' => '异域风情',
			'tour_domestic' => '狂野中国',
			);

	function Magazine (){
		parent::__construct();
		$this->load->helper('api');
		$this->api_host = $this->config->item('api_host');
		$this->load->model('api_model');
		$this->load->model('Login_Model');
		$this->load->model('mag_model');
		$this->load->model('love_model');
		$this->load->model('ads_model');
		$this->load->model('mag_element_model');
		$this->load->model('reg_model');
		$this->load->model('comment_model');
		$this->load->model('page_model');
		$this->load->library('session');
		$this->load->helper('url');
		$this->limit = '20';
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
		$this->smarty->assign('pub_host', $this->config->item('pub_host'));
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

		$index_infotpl['mag_list']=$index_info['mag_list'];
		foreach ($index_info['elem_gallery'] as $i => $elem) {
			/*
			   if ($elem['page'] == 'cover'){
			   $elem['page'] = 'p1';
			   }else{
			   $elem['page'] = substr($elem['page'], 0, 1) .  (substr($elem['page'], 1)+2);
			   }
			 */
			$elem_items[] = array(
					"title" => $elem['title'],
					"image" => array(
						'url' => $elem['image'],
						),
					'url' => $elem['url'],
					);
		}

		$mag_items = array();
		foreach ($index_info['mag_gallery'] as $i => $mag) {
			$mag_items[] = array(
					'title' => $mag['title'],
					'text' => $mag['text'] ,
					"image" => array(
						'url' => $mag['image'],
						),
					'url' => $mag['url'],
					);
		}

		$ad_slot_indextop = array(
			'width' => 580,
			'height' => 576,
			'show_text' => true,
			'items' => $mag_items,
			);
		$ad_slot_indexbottom = array(
			'width' => 580,
			'height' => 380,
			'show_text' => false,
			'items' => $elem_items,
			);

		$index_infotpl['ad_slot_indextop'] = $ad_slot_indextop;
		$index_infotpl['ad_slot_indexbottom'] = $ad_slot_indexbottom;
		$index_infotpl['elm_4'] = $index_info['elm_4'];

		$index_infotpl['curnav'] = 'home';
		$this->smarty->view('magazine/index.tpl', $index_infotpl);
	}//}}}

	function find_elements($page = '1'){		//元素列表页面{{{
		if (!$page) $page = 1;
		$this->load->model('display_model');
		$limit = 30;
		$start = ($page-1) * $limit;
		$element = $this->mag_model->_get_element_list($limit, $start);
		$page_list = $this->page_model->page_list("/find", $limit, $element['data']['totalResults'], $page);
		$elements = $this->display_model->process_elements($element['data']['items']);
		$total = $element['data']['totalResults'];
		$data = array(
					'element_list' => $elements,
					'page_list' => $page_list,
					'curnav' => 'find',
					);
		if ($total > $start + $limit) {
			$data['nextpage'] = '/find/p/' . ($page + 1);
		}
		$this->smarty->view('magazine/element.tpl', $data);
	}//}}}

	function magazines($cate0 = 'tour_recommendation', $page = '1'){		//杂志列表页面 {{{
		$cate = element($cate0, $this->cate_map, $cate0);
		$page = $page ? $page : 1;
		$limit = 20;
		$start = ($page-1) * $limit;
		$result = $this->mag_model->get_magazines(array('cate' => $cate, 'start' => $start, 'limit' => $limit));
		if ($result['httpcode'] != 200) {
			show_error('', $result['httpcode']);
		}
		$mags = $result['data'];
		$totalResults = $mags['totalResults'];
		$page_list = $this->page_model->page_list("/mag_list/$cate0", $limit, $totalResults, $page);
		$cates = array();
		foreach ($this->cate_map as $cid => $cname) {
			$cates[] = array(
					'id' => $cid,
					'name' => $cname,
					'url' => "/mag_list/$cid",
					'current' => $cid == $cate0,
					);
		}
		$data = array(
				'items' => $mags['items'],
				'page_list' => $page_list,
				'curnav' => 'mag',
				'cates' => $cates,
				);
		$this->smarty->view('magazine/magazines.tpl', $data);
	}//}}}
	function magazines_tag($tag, $page = '1'){		//杂志列表页面 {{{
		$tag = urldecode($tag);
		$page = $page ? $page : 1;
		$limit = 20;
		$start = ($page-1) * $limit;
		$result = $this->mag_model->get_magazines(array('tag' => $tag, 'start' => $start, 'limit' => $limit));
		if ($result['httpcode'] != 200) {
			show_error('', $result['httpcode']);
		}
		$mags = $result['data'];
		$totalResults = $mags['totalResults'];
		$page_list = $this->page_model->page_list("/mag_list/tag/$tag", $limit, $totalResults, $page);
		$data = array(
				'items' => $mags['items'],
				'page_list' => $page_list,
				'curnav' => 'mag',
				'tag' => $tag,
				'pageid' => 'mag_tag',
				);
		$this->smarty->view('magazine/magazines.tpl', $data);
	}//}}}

	function magazine_home(){		//杂志二级列表页面{{{
		$limit_gallery = 4;
		$start_gallery = 0;
		$id = '';

		$mag_middle=$this->mag_model->_get_mag_middle();

		$mag_recommend = $this->mag_model->_get_recommendation_mag($limit_gallery, $start_gallery, $id);

		$cate_magazines = array();
		foreach ($this->cate_map as $cid => $cname) {
			$result = $this->mag_model->get_magazines(array('cate' => $cname, 'start' => 0, 'limit' => 15));
			if ($result['httpcode'] == 200) {
				$cate_magazines[] = array(
						'cid' => $cid,
						'cname' => $cname,
						'items' => $result['data']['items'],
						'more_url' => "/mag_list/$cid",
						);
			}
		}

		$limit_list = 15;
		$start_list = 0;
		//$mag_list = $this->mag_model->_get_magazines_by_tag($limit_list, $start_list);
		$mag_limit = 3;
		$mag_text = $this->mag_model->_get_mag_text($mag_limit);

		$data = array(
					'mag_gallery' => $mag_recommend['data']['items'],
					'cate_magazines' => $cate_magazines,
					'curnav' => 'mag',
					'mag_text' => $mag_text['data']['items'],
					);

		$mag_items = array();
		foreach ($data['mag_gallery'] as $i => $mag) {
			$mag_items[] = array(
					'title' => $mag['title'],
					'text' => $mag['text'] . $i,
					"image" => array(
						'url' => $mag['image'],
						),
					'url' => $mag['url']
					);
		}

		$mag_text = array();
		foreach($data['mag_text'] as $k => $v){
			$mag_text[]=array(
					'title' => $v['title'],
					'text' => $v['text'],
					'url' => $v['url'],
					
					);

		
		
		}
		$data['ad_slot_magtop'] = array(
			'width' => 980,
			'height' => 280,
			'show_text' => false,
			'items' => $mag_items,
			'text' => $mag_text,
			);
		$data['mag_mid']=$mag_middle;
		$this->smarty->view('magazine/magazine_home.tpl', $data);
	}//}}}

	function magazine_detail($id){		//杂志详情页面{{{
		$magazine_id = $id;
		$magazine = $this->mag_model->_get_magazine_by_id($magazine_id);
		$magazine['publishedAt'] = substr($magazine['publishedAt'], 0, 10);
		$limit_recom = 6;
		$start_recom = 0;
		$limit_maylike = 6;
		$start_maylike = 6;
		//catid 目前不使用，因所有杂志页推荐相同，取广告位api
		$catid=0;
		$all_recommendation = $this->mag_model->_get_recommend_bycat($catid);
		$recommendation=$all_recommendation['data']['items'];
		$maylike = $this->mag_model->_get_maylike_mag($limit_maylike, $start_maylike, $id);
		$comment = $this->comment_model->comment_list('magazine', $magazine_id, $start=0, $limit=5);
		$reverse_cate_mag = array_flip($this->cate_map);
		$data = array(
				'navs' => array(
					array(
						'name' => '杂志',
						'url' => '/mag',
						),
					array(
						'name' => $magazine['cate'],
						'url' => '/mag_list/' . element($magazine['cate'], $reverse_cate_mag, $magazine['cate']),
						),
					array(
						'name' => $magazine['name'],
						'current' => TRUE,
						),
					),
					'api_host' => $this->config->item('api_host'),
					'magazine' => $magazine,
					'recommendation' => $recommendation,
					'maylike' => $maylike,
					'comments' => $comment['items'],
					'hasMoreComments' => $comment['totalResults'] > 5,
					'curnav' => 'mag',
					'pageid' => 'mag_detail',
					);
		$this->smarty->view('magazine/magazine_detail.tpl', $data);
	}//}}}

	function comment_list($id, $page="1"){		//杂志评论页面{{{
		$page = $page ? $page : 1;
		$limit = 10;
		$start = ($page-1)*$limit;
		$page = $page ? $page : 1;
		$magazine = $this->mag_model->_get_magazine_by_id($id);
		$comment = $this->comment_model->comment_list('magazine', $id, $start, $limit);
		$totalResults = $comment['totalResults'];
		$page_list = $this->page_model->page_list("/magazine/$id/comments", $limit, $totalResults, $page, 'pagenav');
		$reverse_cate_mag = array_flip($this->cate_map);
		$magazine['url'] = '/magazine/detail/' . $magazine['id'];

		$this->load->model('user_info_model');
		$user_info = $this->user_info_model->get_user($this->session->userdata('id'));
		$data = array(
				'navs' => array(
					array(
						'name' => '杂志',
						'url' => '/mag',
						),
					array(
						'name' => $magazine['cate'],
						'url' => '/mag_list/' . element($magazine['cate'], $reverse_cate_mag, $magazine['cate']),
						),
					array(
						'name' => $magazine['name'],
						'url' => '/magazine/detail/' . $magazine['id'],
						),
					array(
						'name' => '留言板',
						'current' => TRUE,
						),
					),
					'magazine' => $magazine,
					'comments' => $comment['items'],
					'page_list' => $page_list,
					'user_info' => $user_info,
					);
		$this->smarty->view('magazine/comment_list.tpl', $data);
	}//}}}

	function like($type, $type_id, $action) { //喜欢杂志, 元素, 关注作者 {{{
		$this->_auth_check_api();
		$resp = $this->mag_model->_like($type, $type_id, $action);
		if ($resp['httpcode'] != 200) {
			show_error('', $resp['httpcode']);
		}

		if ($type == 'magazine'){
			$result = $this->mag_model->_get_magazine_by_id($type_id);
		}else if ($type == 'element'){
			$result = $this->mag_model->_get_element_by_id($type_id);
		}else if ($type == 'user'){
			$result = array(
							'status' => 'success',
							);
		}
		$this->_json_output($result);
	}//}}}

	function soft ($type='pc') {	//{{{
		$data = array(
				'type' => $type,
				'curnav' => 'soft',
				'pageid' => 'down',
				);
		if ($type == 'pc') {
			$this->load->library('session');
			$user_id = $this->session->userdata('id');
			if ($user_id) {
				$this->load->model('user_info_model');
				$data['user_info'] = $this->user_info_model->get_user($user_id);
			}
		}
		$this->smarty->view('magazine/down.tpl', $data);
	}	//}}}
	
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
		echo $type = $this->_get_non_empty('type');
		echo $object_id = $this->_get_non_empty('object_id');
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
		$this->_auth_check_api();
		$type = $this->input->get('type');
		$object_id = $this->input->get('object_id');
		$comment = $this->input->post('conment');
		$parent_id = $this->input->post('parent_id');
		$start = $this->input->get('start');
		$limit = $this->input->get('limit');
		$data = $this->comment_model->refresh_comment($type, $object_id, $parent_id, $comment, $start, $limit);
		$this->smarty->view('magazine/lib/comments.tpl', array('comments' => $data['items'], 'totalComments' => $data['totalResults']));
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
	
	public function pub_like() { //喜欢杂志, 元素, 关注作者 {{{

		$return = array(
				'status' => 'nologin'
				);
		$type = 'magazine';
		$type_id = $this->input->get('id');
		$action = 'like';
		if ($this->auth->is_logged_in()) {
			$resp = $this->mag_model->_like($type, $type_id, $action);
			if ($resp['httpcode'] != 200) {
				$return['status'] = 'error';
			}
			else {
				$return['status'] = 'ok';
			}
			if ($type == 'magazine'){
				$return['data'] = $this->mag_model->_get_magazine_by_id($type_id);
			}else if ($type == 'element'){
				$return['data'] = $this->mag_model->_get_element_by_id($type_id);
			}else if ($type == 'user'){
				$return['status'] = 'ok';
			}
		}
		$this->output->set_output($this->__jsonp($return));
	}//}}}
	public function __jsonp(array &$result) {
		return $this->input->get('callback').'('.json_encode($result).')';
	}

	function _validate_api_result($result) {
		if ($return['httpcode'] >= 300) {
			show_error_text($return['httpcode'], $return['data']);
		}
	}
	function _api_post($url, $params) {
		if (!preg_match('/^https?:/', $url)) $url = $this->api_host . $url;
		$return = request($url, $params, 'POST');
		if ($return['httpcode'] >= 300) {
			show_error_text($return['httpcode'], $return['data']);
		}
		return $return;
	}

	function _auth_check_web () {
		$this->load->model('auth');
		if (!$this->auth->is_logged_in()) {
			redirect('/user/signin?return=' . current_url());
			exit;
		}
		$session_id = $this->session->userdata('session_id');
		$user_id = $this->session->userdata('id');
		return array(
				'id' => $user_id,
				'session_id' => $session_id,
				);
	}
	function _auth_check_api() {
		$this->load->model('auth');
		if (!$this->auth->is_logged_in()) {
			show_error_text(401, 'signin please');
		}
		$session_id = $this->session->userdata('session_id');
		$user_id = $this->session->userdata('id');
		return array(
				'id' => $user_id,
				'session_id' => $session_id,
				);
	}
}
