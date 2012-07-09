<?php
class Mag_Model extends CI_Model {
	function Mag_Model (){
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
	}


	function _get_category(){		//杂志分类
		$cat_info = api($this->api_host."/magazine/category");
		return $cat_info;
	}

	function _get_mag_list($gets, $type){
		$mag_list = api($this->api_host . "/magazine/mag_list?start=".$gets['start']."&limit=".$gets['limit']."&type=".$type."&status=".$gets['status']);
		return $mag_list['data'];
	}

	function _get_same_author_mag($gets){		//获取该作者的其他杂志{{{
		if($gets['status'] == ''){
			$list = api($this->api_host . "/magazine/get_same_author_mag?mag_id=".$gets['mag_id']."&limit=".$gets['limit']."&start=".$gets['start']);
		}else{
			$list = api($this->api_host . "/magazine/get_same_author_mag?mag_id=".$gets['mag_id']."&limit=".$gets['limit']."&start=".$gets['start']."&status=".$gets['status']);
		}
		return $list['data'];
	}//}}}
	
	function _get_same_category_mag($gets){		//获取同类型杂志{{{
		if($gets['status'] == ''){
			$list = api($this->api_host . "/magazine/get_same_category_mag?mag_id=".$gets['mag_id']."&limit=".$gets['limit']."&start=".$gets['start']);
		}else{
			$list = api($this->api_host . "/magazine/get_same_category_mag?mag_id=".$gets['mag_id']."&limit=".$gets['limit']."&start=".$gets['start']."&status=".$gets['status']);
		}		return $list['data'];
	}//}}}
	
	function _get_index_info(){		//首页杂志信息{{{
		$mag_result = request($this->api_host . "/magazines?limit=9&start=0");
		$mag_resultad = request($this->api_host."/ads/image/indextop");
		$mag_item = $mag_result['data']['items'];
		$mag_itemad = $mag_resultad['data']['items'];
		$mag_gallery = $mag_list = array();
		for($i=0; $i <count($mag_itemad); $i++){
				array_push($mag_gallery, $mag_itemad[$i]);

		}
		for ($i = 0; $i < count($mag_item); $i++){
			//if ($i < 4){
			//	array_push($mag_gallery, $mag_item[$i]);
			//}else{
				array_push($mag_list, $mag_item[$i]);
			//}
		}
		$elem_gallery = $elem_list = array();
		$elem_result = request($this->api_host . "/elements?limit=12&start=0");
		$elem_item = $elem_result['data']['items'];
		for ($j = 0; $j < count($elem_item); $j++){
			if ($j < 4){
				array_push($elem_gallery, $elem_item[$j]);
			}else{
				array_push($elem_list, $elem_item[$j]);
			}
		}
		$index_info = array(
							'mag_gallery' => $mag_gallery,
							'mag_list' => $mag_list,
							'elem_gallery' => $elem_gallery,
							'elem_list' => $elem_list,
							);
		return $index_info;
	}//}}}
	function get_magazines($params) {
		$url = $this->api_host . '/magazines?' . http_build_query($params);
		return request($url);
	}
	
	function _get_magazine_by_id($id){		//获取杂志详情页信息{{{
		$magazine = request($this->api_host . "/magazine/$id");
		return $magazine['data'];
	}//}}}
	
	function _get_recommendation_mag($limit, $start, $id){		//获得推荐杂志列表{{{
		$mag_resultad = request($this->api_host."/ads/image/magtop");
		return $mag_resultad;
		//$recommendation = request($this->api_host . "/recommendation/maylike?limit=$limit&start=$start&id=$id");
		//return $recommendation['data']['items'];
	}//}}}
	
	function _get_maylike_mag($limit, $start, $id){		//获得猜你喜欢的杂志列表{{{
		$maylike = request($this->api_host . "/recommendation/maylike?limit=$limit&start=$start&id=$id");
		return $maylike['data']['items'];
	}//}}}
	
	function _get_detail_comment_data($type, $object_id){		//获得详情页面评论信息{{{
		$comment = request($this->api_host . "/magazine/223/comments?type=magazine&object_id=$object_id&limit=5&start=0");
		return $comment;
	}//}}}
	
	function _get_element_list($limit, $start){		//获取元素列表{{{
		$element = request($this->api_host . "/elements?limit=$limit&start=$start");
		return $element;
	}//}}}
	
	function _get_element_by_id($id){		//获取单一元素信息{{{
		$element = request($this->api_host . "/element/$id");
		return $element['data'];
	}//}}}
	
	function _like($type, $id, $action='like') {// 喜欢杂志/元素, follow用户, 以及逆向操作 {{{
		return request($this->api_host . "/$type/$id/$action?session_id=" . $this->session->userdata('session_id'), array(), 'POST');
	}//}}}
}
