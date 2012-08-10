<?php
class Mag_Model extends CI_Model {
	function __construct (){
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
	}

	function _get_mag_text($limit)	{
		$mag_text  = request($this->api_host . "/ltapp/ads/text/magmiddle?limit=" .$limit);
		return $mag_text;
	}
	
	//mag page ,middle magazine ,2  个	
 	function _get_mag_middle()	{
		$mag_result = request($this->api_host . "/ltapp/ads/magazine/magmiddle?limit=2");
		$mag_item = $mag_result['data']['items'];
		return $mag_item;
	}
	//mag page ,15 ads for each category 
 	function _get_mag_catead($categ)	{
		$mag_result = request($this->api_host . "/ltapp/ads/magazine/".$categ."?limit=15");
		$mag_item = $mag_result['data']['items'];
		return $mag_item;
	}
	
	function _get_index_info(){		//首页杂志信息{{{
		//右上及中部的9本杂志
		//$mag_result = request($this->api_host . "/magazines?limit=9&start=0");
		$mag_result = request($this->api_host . "/ltapp/ads/magazine/indextop?limit=9");
		//顶部幻灯片，最多5张
		$mag_resultad = request($this->api_host."/ltapp/ads/image/indextop?limit=5");
		$mag_itemad = $mag_resultad['data']['items'];
		$mag_gallery = $mag_list = array();
		for($i=0; $i <count($mag_itemad); $i++){
				array_push($mag_gallery, $mag_itemad[$i]);

		}
		$elem_gallery = $elem_list4 = array();
		$elem_list3 = $elem_list1 = array();
		//elem gallery
		$elem_gallery_result= request($this->api_host."/ltapp/ads/image/indexlovefind?limit=5");
		$elem_item = $elem_gallery_result['data']['items'];
		for ($j = 0; $j < count($elem_item); $j++){
				array_push($elem_gallery, $elem_item[$j]);
		}

		//elem list4
		$elem_list_result= request($this->api_host."/ltapp/ads/element/indexelem4?limit=9");
		$elem_item = $elem_list_result['data']['items'];
		for ($j = 0; $j < count($elem_item); $j++){
				array_push($elem_list4, $elem_item[$j]);
		}


		//echo "<pre>";var_dump($elem_list);exit;
		$index_info = array(
							'mag_gallery' => $mag_gallery,
							'mag_list' => $mag_result['data']['items'],
							'elem_gallery' => $elem_gallery,
							'elm_4' => $elem_list4,
							);
		//echo "<pre>";print_r($index_info);exit;
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
	
	function _get_recommend_bycat($catid){		//获得推荐杂志列表,仅用于商品详情页的推荐的杂志部分{{{
		$mag_rec = request($this->api_host. "/ltapp/ads/magazine/guessulove?limit=20");
		if(count($mag_rec['data']['items'])>6){
			shuffle($mag_rec['data']['items']);
			foreach($mag_rec['data']['items'] as $k =>$v){
				if($k>5){
					unset($mag_rec['data']['items'][$k]);
				}
			}
		}
		return $mag_rec;
	} // }}}
	function _get_recommendation_mag($limit, $start, $id){		//获得推荐杂志列表{{{
		$mag_resultad = request($this->api_host."/ltapp/ads/image/magtop");
		return $mag_resultad;
		//$recommendation = request($this->api_host . "/recommendation/maylike?limit=$limit&start=$start&id=$id");
		//return $recommendation['data']['items'];
	}//}}}
	
	function _get_maylike_mag($limit, $start, $id){		//获得猜你喜欢的杂志列表{{{
		$maylike = request($this->api_host . "/recommendation/maylike?limit=$limit&start=$start&id=$id");
		return $maylike['data']['items'];
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

	function _get_mag_category () {	//获取杂志分类列表{{{
		$cates = request($this->api_host . "/cates");
		if ($cates['httpcode'] == '200') {
			$mag_category = array();
			for ($i=0; $i < $cates['data']['totalResults']; $i++) {
				$mag_category[$i] = $cates['data']['items'][$i]['name'];
			}
			return $mag_category;
		}
	}	//}}}
	
	function _get_topic_magazine($limit){
		$mag_list = request($this->api_host . "/ltapp/ads/magazine/ztmag?limit=$limit");
		return $mag_list;
	}
}
