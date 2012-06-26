<?php
class Mag_Model extends CI_Model {
	function Mag_Model (){
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
	}

	function get_mag_list_for_index(){		//杂志首页列表
		$mag_ad_list = array();
		$mag_list = array();
		$elem_ad_list = array();
		$elem_list = array();
		$result_mag = api($this->api_host . "/magazine/get_index_mag_list");
		$mag = $result_mag['data'];
		for ($i = 0; $i<count($mag); $i++){
			if ($i < 4){
				array_push($mag_ad_list, $mag[$i]);
			}else{
				array_push($mag_list, $mag[$i]);
			}
		}
		$result_elem = api($this->api_host . "/magazine/get_mag_element?for=index&limit=12&start=0");
		$element = $result_elem['data'];
		for ($j = 0; $j<count($element); $j++){
			if ($j < 4){
				array_push($elem_ad_list, $element[$j]);
			}else{
				array_push($elem_list, $element[$j]);
			}
		}
		$data = array(
					'mag_ad_list' => $mag_ad_list,
					'mag_list' => $mag_list,
					'elem_ad_list' => $elem_ad_list,
					'elem_list' => $elem_list,
					);
		return $data;
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
	
	function _get_mag_for_list($gets){		//获取杂志列表页 杂志列表{{{
			$list = api($this->api_host . "/magazine/get_mag_for_list?mag_category=".$gets['mag_category']."&status=".$gets['status']."&limit=".$gets['limit']."&start=".$gets['start']."&tag=".$gets['tag']);
			return $list['data'];
	}//}}}
	
	
	
	
	
	
	
	
	
	
	
	
	
	function _get_index_info(){		//首页杂志信息{{{
		$mag_result = request($this->api_host . "/magazines?limit=13&start=0");
		$mag_item = $mag_result['data']['items'];
		$mag_gallery = $mag_list = array();
		for ($i = 0; $i < count($mag_item); $i++){
			if ($i < 4){
				array_push($mag_gallery, $mag_item[$i]);
			}else{
				array_push($mag_list, $mag_item[$i]);
			}
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
	
	function _get_magazines_by_tag($limit, $start){		//杂志列表页数据{{{
		$tour_reader = request($this->api_host . "/magazines?limit=$limit&start=$start&tag=旅游攻略");
		$foreign = request($this->api_host . "/magazines?limit=$limit&start=$start&tag=出境游");
		$local = request($this->api_host . "/magazines?limit=$limit&start=$start&tag=国内游");
		$mag_list = array(
						'tour_reader' => $tour_reader['data']['items'],
						'foreign' => $foreign['data']['items'],
						'local' => $local['data']['items'],
						);
		return $mag_list;
	}//}}}
	
	function _get_mag_element_list($limit, $start){		//杂志元素列表数据获取{{{
		$mag_element = request($this->api_host . "/elements?limit=$limit&start=$start");
		return $mag_element['data']['items'];
	}//}}}
	
	function _get_magazine_by_id($id){		//获取杂志详情页信息{{{
		$magazine = request($this->api_host . "/magazine/$id");
		return $magazine['data'];
	}//}}}
	
	function _get_recommendation_mag(){		//获得推荐杂志列表{{{
		$recommendation = request($this->api_host . "/recommendation/maylike?limit=6&start=0");
		return $recommendation['data']['items'];
	}//}}}
	
	function _get_maylike_mag(){		//获得猜你喜欢的杂志列表{{{
		$maylike = request($this->api_host . "/recommendation/maylike?limit=6&start=6");
		return $maylike['data']['items'];
	}//}}}
	
	function _get_detail_comment_data($type, $object_id){		//获得详情页面评论信息{{{
		$comment = request($this->api_host . "/magazine/223/comments?type=magazine&object_id=$object_id&limit=5&start=0");
		return $comment;
	}//}}}
}
