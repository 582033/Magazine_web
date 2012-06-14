<?php
class Mag_Model extends CI_Model {
	function Mag_Model (){
		parent::__construct();
		$this->api_host = $this->config->item('api_host');
		$this->load->helper('api');
	}
<<<<<<< HEAD
	
=======

>>>>>>> 567a370... aa
	function get_mag_list_for_index(){		//杂志首页列表
		$mag_ad_list = array();
		$mag_list = array();
		$elem_ad_list = array();
		$elem_list = array();
		$mag = api($this->api_host . "/magazine/get_index_mag_list");
		for ($i = 0; $i<count($mag); $i++){
			if ($i < 5){
				array_push($mag_ad_list, $mag[$i]);
			}else{
				array_push($mag_list, $mag[$i]);
			}
		}
		$element = api($this->api_host . "/magazine/get_mag_element?for=index&limit=13&start=0");
		for ($j = 0; $j<count($element['data']); $j++){
			if ($j < 5){
				array_push($elem_ad_list, $element['data'][$j]);
			}else{
				array_push($elem_list, $element['data'][$j]);
			}
		}
		$data = array(
					'mag_ad_list' => $mag_ad_list,
					'mag_list' => $mag_list,
					'elem_ad_list' => $elem_ad_list,
					'elem_list' => $elem_list,
					);
		for ($k = 0; $k<count($data['mag_ad_list']); $k++){
			$result = api($this->api_host . "/magazine/judge_loved?loved_type=magazine&loved_id=".$data['mag_ad_list'][$k]['magazine_id']);
			$data['mag_ad_list'][$k]['loved_nums'] = $result['data'];
		}
		return $data;
	}
<<<<<<< HEAD
	
=======

>>>>>>> 567a370... aa
	function _get_category(){		//杂志分类
		$cat_info = api($this->api_host."/magazine/category");
		return $cat_info;
	}
<<<<<<< HEAD
	
=======

>>>>>>> 567a370... aa
	function _get_mag_list($gets, $type){
		$mag_list = api($this->api_host . "/magazine/mag_list?start=".$gets['start']."&limit=".$gets['limit']."&type=".$type);
		return $mag_list['data'];
	}
}
