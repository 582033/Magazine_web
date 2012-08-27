<?php
class Magazine extends MY_Controller {

	var $api_host;
	var $limit;
	var $cate_map = array(
			'tour_recommendation' => '目的地推荐',
			'tour_foreign' => '异域风情',
			'tour_domestic' => '狂野中国',
			);

	function Magazine (){
		parent::__construct();
		$this->load->helper('api');
		$this->load->helper('cookie');
		$this->api_host = $this->config->item('api_host');
		$this->load->model('api_model');
		$this->load->model('mag_model');
		$this->load->model('comment_model');
		$this->load->model('page_model');
		$this->load->helper('url');
		$this->limit = '20';
		$this->smarty->assign('pub_host', $this->config->item('pub_host'));
	}
	function index(){		//首页显示{{{
		$pageid = 'magazines_index';
		$common_data  = $this->_get_common_data($pageid);
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
		foreach($index_infotpl['ad_slot_indexbottom']['items'] as $k => $v){
			$index_infotpl['ad_slot_indexbottom']['items'][$k]['image'] = $v['image']['url'];
		}
		foreach($index_infotpl['ad_slot_indextop']['items'] as $k => $v){
			$index_infotpl['ad_slot_indextop']['items'][$k]['image'] = $v['image']['url'];
		}
		$index_infotpl = array_merge($index_infotpl,$common_data);
		$this->smarty->view('magazine/index.tpl', $index_infotpl);
	}//}}}

	function find_elements($page = '1'){		//元素列表页面{{{
		$pageid = 'magazine_find';
		$common_data = $this->_get_common_data($pageid);
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
		if($page == '1'){
		$elem_ad = request($this->config->item('api_host').'/ltapp/ads/element/findpage?limit=999');
		$arr_elem_ad = $elem_ad['data']['items'];
		$data['element_ad'] = $arr_elem_ad;
		}
		if ($total > $start + $limit) {
			$data['nextpage'] = '/find/p/' . ($page + 1);
		}
		$data = array_merge($data, $common_data); 
		$this->smarty->view('magazine/element.tpl', $data);
	}//}}}

	function magazines($cate0 = 'tour_recommendation', $page = '1'){		//杂志列表页面 {{{
		$pageid = $cate0;
		$common_data = $this->_get_common_data($pageid);
		$cate = element($cate0, $this->cate_map, $cate0);
		$page = $page ? $page : 1;
		$limit = 20;
		$start = ($page-1) * $limit;
		$result = $this->mag_model->get_magazines(array('cate' => $cate, 'start' => $start, 'limit' => $limit, 'orderby' => 'newest'));
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
		$data = array_merge($data, $common_data);
		$this->smarty->view('magazine/magazines.tpl', $data);
	}//}}}
	function _get_common_data($pageid, $pagename='', $pageclass='') {		//获取title {{{
		$title = '';
		switch ($pageid) {
			case 'magazines_index': // 首页
				$title = '1001夜互动阅读平台-灵动阅读、轻松制作、随心分享';
				break;
			case 'magazine_home': // 阅读发现
				$title = '最实用的移动旅游攻略、高品质游记-1001夜互动阅读平台';
				break;	
			case 'magazine_find': // 发现
				$title = '精品碎片化阅读、旅行风景图片-1001夜互动阅读平台';
				break;
			case 'down':
				$title = '最实用的旅游攻略、高品质游记、移动阅读-1001夜互动阅读平台';
				break;
			case 'mag_detail':
				$title = '1001夜阅读-'.$pagename['cate'].'、《'.$pagename['name'].'》';
				break;
			case 'search':
				$title = $pagename.'-1001夜互动阅读平台';
				break;
			case 'setting':
				$title = '账号设置-1001夜互动阅读平台';
				break;
			case 'change-password':
				$title = '修改密码-1001夜互动阅读平台'; 
				break;
			case 'set_headpic':
			    $title = '头像设置-1001夜互动阅读平台';
			    break;	
			case 'set_tag':
	            $title = '个人标签-1001夜互动阅读平台';
                break;  
			case 'set_share':
	            $title = '分享管理-1001夜互动阅读平台';
                break;  
			case 'magazines_love':
				$title = $pagename.'喜欢的阅读-1001夜互动阅读平台';
				break;
			case 'elements':
				$title = $pagename.'喜欢的发现-1001夜互动阅读平台';
				break;
			case 'followees':
				$title = $pagename.'的关注-1001夜互动阅读平台';
				break;
			case 'followers':
				$title = $pagename.'的粉丝-1001夜互动阅读平台';
				break;
			case 'messages':
				$title = '消息中心-1001夜互动阅读平台';
				break;
			case 'comment_list':
				$title = '留言板-1001夜互动阅读平台';
				break;
			case 'forget_password':
				$title = '找回密码-1001夜互动阅读平台';
				break;
			case 'tour_recommendation':
				$title = '旅游目的地推荐、旅游攻略、旅游指南、游记-1001夜互动阅读平台';
				break;
			case 'tour_foreign':
				$title = '异域风情、国外旅游攻略、出境游-1001夜互动阅读平台';
				break;
			case 'tour_domestic':
				$title = '狂野中国、国内旅游攻略、境内游-1001夜互动阅读平台';
				break;
			case 'topic_on_line':
				$title = '1001夜互动阅读平台-灵动阅读、轻松制作、随心分享';
				break;
			case 'topic_self_tour':
				$title = '1001夜自游书、每个人都可以用全新的方式去讲述自己的故事';
				break;
			case 'about_us':
				$title = '关于1001夜-1001夜互动阅读平台';
				break;
			case 'contact_us':
				$title = '联系我们-1001夜互动阅读平台';
				break;
			case 'join_us':
				$title = '加入我们-1001夜招聘';
				break;
			case 'legal_statement':
				$title = '法律声明-1001夜互动阅读平台';
				break;
			case 'mag_tag':
				$title = '1001夜阅读、'.$pagename;
				break;
			case 'bookstore':
				$title = $pagename."的作品";
				break;
			case 'sns-signup':
				$title = "创建绑定账号-1001夜";
				break;
			case 'sns-bind':
				$title = "绑定成功-1001夜";
				break;
		}
		$data = array(
					'title' => $title,
					'pageid' => $pageid
					);
		return $data;
	}//}}}
	function magazines_tag($tag, $page = '1'){		//杂志列表页面 {{{
		$pageid = 'mag_tag';
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
				);
		$common_data = $this->_get_common_data($pageid, $tag);
		$data = array_merge($data, $common_data);
		$this->smarty->view('magazine/magazines.tpl', $data);
	}//}}}
	function magazine_home(){		//杂志二级列表页面{{{
		$pageid = "magazine_home";
		$common_data  = $this->_get_common_data($pageid);
		$limit_gallery = 4;
		$start_gallery = 0;
		$id = '';
		$mag_middle=$this->mag_model->_get_mag_middle();
		$mag_mddtj = $this->mag_model->_get_mag_catead('magepagemdd');
		$mag_kyzg = $this->mag_model->_get_mag_catead('magepagekyzg');
		$mag_yyfq = $this->mag_model->_get_mag_catead('magpageyyfq');
		$cat_map = array(
			'tour_recommendation' => $mag_mddtj,
			'tour_foreign' => $mag_yyfq,
			'tour_domestic' => $mag_kyzg,
			);


		$mag_recommend = $this->mag_model->_get_recommendation_mag($limit_gallery, $start_gallery, $id);
		foreach($mag_recommend['data']['items'] as $k =>$v){
			$mag_recommend['data']['items'][$k]['image']=$v['image']['url'];
		}

		$cate_magazines = array();
		foreach ($this->cate_map as $cid => $cname) {
				$cate_magazines[] = array(
						'cid' => $cid,
						'cname' => $cname,
						'items' => $cat_map[$cid],
						'more_url' => "/mag_list/$cid",
						);
		}

		$limit_list = 15;
		$start_list = 0;
		//$mag_list = $this->mag_model->_get_magazines_by_tag($limit_list, $start_list);
		$mag_limit = 3;
		$mag_text = $this->mag_model->_get_mag_text($mag_limit);
		//echo "<pre>";var_dump($cate_magazines);exit;

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
		$data = array_merge($data,$common_data);
		$this->smarty->view('magazine/magazine_home.tpl', $data);
	}//}}}
	function magazine_detail($id){		//杂志详情页面{{{
		$magazine_id = $id;
		$magazine = $this->mag_model->_get_magazine_by_id($magazine_id);
		
		if ($magazine) {
			$pageid = 'mag_detail';
			$temp = array();
			foreach ($magazine['pageThumbs'] AS $key=>$value) {
				$a = explode('/',$value);	
				array_pop($a);
				$temp[$key]['pageId'] = array_pop($a);
				$temp[$key]['thumbUrl'] = $value;
			}
			$magazine['pageThumbs'] = $temp;

			$magazine['publishedAt'] = substr($magazine['publishedAt'], 0, 10);
			$common_data = $this->_get_common_data($pageid, $magazine);
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
							'name' => '阅读',
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
						);
			$data = array_merge($data, $common_data);
			$this->smarty->view('magazine/magazine_detail.tpl', $data);
		}
		else {
			require_once APPPATH . "controllers/notfound.php";
			$error_404 = new Notfound();
			$error_404->index();
		}
	}//}}}
	function comment_list($id, $page="1"){		//杂志评论页面{{{
		$pageid = 'comment_list';
		$commondata = $this->_get_common_data($pageid);
		$page = $page ? $page : 1;
		$limit = 10;
		$start = ($page-1)*$limit;
		$page = $page ? $page : 1;
		$magazine = $this->mag_model->_get_magazine_by_id($id);
		$magazine['url'] = '/magazine/detail/' . $magazine['id'];
		$comment = $this->comment_model->comment_list('magazine', $id, $start, $limit);
		$totalResults = $comment['totalResults'];
		$page_list = $this->page_model->page_list("/magazine/$id/comments", $limit, $totalResults, $page, 'pagenav');
		$reverse_cate_mag = array_flip($this->cate_map);
		$data = array(
				'navs' => array(
					array(
						'name' => '阅读',
						'url' => '/mag',
						),
					array(
						'name' => '留言板',
						'current' => TRUE,
						),
					),
					'magazine' => $magazine,
					'comments' => $comment['items'],
					'page_list' => $page_list,
					);
		if (is_array($magazine)) {
			$magazine_date = array(
						array(
							'name' => $magazine['cate'],
							'url' => '/mag_list/' . element($magazine['cate'], $reverse_cate_mag, $magazine['cate']),
							),
						array(
							'name' => $magazine['name'],
							'url' => '/magazine/detail/' . $magazine['id'],
							),
						);
			$data = array_merge($data, $magazine_date);
		}
		$data = array_merge($data, $commondata);
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

	function soft ($type='android') {	//{{{
		$pageid = 'down';
		$common_data = $this->_get_common_data($pageid);	
		$data = array(
				'type' => $type,
				'curnav' => 'soft',
				);
		if ($type == 'pc') {
			$data['user_info'] = $this->_get_current_user();
		}
		$data = array_merge($data, $common_data);
		$this->smarty->view('magazine/down.tpl', $data);
	}	//}}}
	
	function refresh_comment(){	//{{{
		$this->_auth_check_api();
		$type = $this->input->get('type');
		$object_id = $this->input->get('object_id');
		$comment = $this->input->post('comment');
		$parent_id = $this->input->post('parent_id');
		$start = $this->input->get('start');
		$limit = $this->input->get('limit');
		$data = $this->comment_model->refresh_comment($type, $object_id, $parent_id, $comment, $start, $limit);
		$this->smarty->view('magazine/lib/comments.tpl', array('comments' => $data['items'], 'totalComments' => $data['totalResults']));
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
		$this->load->model('auth');
		if ($this->auth->get_sess_userdata()) {
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
	public function pub_for_last() {
		$id = $this->input->get('id');
		$magazine = $this->mag_model->_get_magazine_by_id($id);
		$recommendation= $this->mag_model->_get_maylike_mag(10,mt_rand(0,50),$id);
		$data = array(
				'author'=>$magazine['author'],
				'recommend'=>$recommendation
				);
		$this->smarty->view('magazine/pub_for_last.tpl', $data);
	}
	public function pub_for_sign() {
		$data = array();
		$data['do'] = $this->input->get('do')?$this->input->get('do'):'in';
		$data['close'] = $this->input->get('close');
		$this->smarty->view('pub/pub_for_sign.tpl',$data);
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

	function _delete_signin_cookies() {
		delete_cookie('ci_session');
		delete_cookie('session_id');
		delete_cookie('uid');
		delete_cookie('nickname');
		delete_cookie('avatar');
		delete_cookie('rmsalt');
	}
	function _to_signin_page() {
		$this->load->library('session');
		$this->session->sess_destroy();
		$this->_delete_signin_cookies();
		redirect('/user/signin?return=' . current_url());
		exit;
	}
	function _auth_check_web () { // {{{
		$this->load->model('auth');
		$sessdata = $this->auth->get_sess_userdata();
		if (!$sessdata) {
			$this->_to_signin_page();
		}
		return $sessdata;
	} // }}}
	function _auth_check_api() { // {{{
		$this->load->model('auth');
		$sessdata = $this->auth->get_sess_userdata();
		if (!$sessdata) {
			$this->_delete_signin_cookies();
			show_error_text(401);
		}
		return $sessdata;
	} // }}}
	function _get_current_user() { // {{{
		$user_info = NULL;
		$this->load->library('session');
		$user_id = $this->session->userdata('user_id');
		if ($user_id) {
			$this->load->model('user_info_model');
			$user_info = $this->user_info_model->get_user($user_id);
		}
		return $user_info;
	} // }}}
}
