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
		$mag_result = request($this->api_host . "/v1/magazines?limit=13&start=0");
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
		$elem_result = request($this->api_host . "/v1/elements?limit=12&start=0");
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
}
