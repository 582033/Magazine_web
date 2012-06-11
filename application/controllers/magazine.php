<?php
class Magazine extends MY_Controller {
	
	var $api_host;
	
	function Magazine (){
		parent::__construct();
		$this->load->helper('api');
		$this->api_host = $this->config->item('api_host');
		$this->load->model('Login_Model');	
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

	function reg (){	//{{{
		$username = $this_non_empty();
	}	//}}}

	function login (){	//{{{
	//	$username = $this->input->post('username');
	//	$passwd = $this->input->post('passwd');
		$username = $this->input->get('username');
		$passwd = $this->input->get('passwd');
		$getkey = api($this->api_host."/magazine/getkey");	
		echo "<pre>";print_r($getkey);
		$return = $this->Login_Model->login($getkey, $username, $passwd);
		echo "<pre>";print_r($return);
	}	//}}}

	function mag_list (){	//杂志列表{{{
		$keys = array('start', 'limit');
		$gets = $this->_get_more_non_empty($keys);
		$mag_list = api($this->api_host."/magazine/mag_list?start=".$gets['start']."&limit=".$gets['limit']);
		echo "<pre>";print_r($mag_list);
		//$this->smarty->view('index.tpl');
	}	//}}}

	function detail (){	//详情页`{{{
		$id = $this->_get_non_empty('id');		
		$detail = api($this->api_host."/magazine/detail?id=".$id);
		echo "<pre>";print_r($detail);
		//$this->smarty->view('index.tpl');
	}	//}}}
	
	
	
	
	
	
	
	
	
	
	
	function loved_num(){		//喜欢数量{{{
		$loved_num = api($this->api_host."/magazine/get_loved_nums");
		$this->_json_output($loved_num['data']);
	}//}}}
	
	function loved_data(){		//喜欢数据{{{
		$keys = array('start', 'limit');
		$gets = $this->_get_more_non_empty($keys);
		$type = $this->input->get('type');
		$loved_data = api($this->api_host."/magazine/get_loved_data?limit=".$gets['limit']."&start=".$gets['start']."&type=".$type);
		$this->_json_output($loved_data['data']);
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
		$mag_element = api($this->api_host."/magazine/get_mag_element?for=".$gets['for']."&limit=".$gets['limit']."&start=".$gets['start']."&type=".$type);
		$this->_json_output($mag_element['data']);
	}//}}}
	
	function category(){		//杂志分类{{{
		$cat_info = api($this->api_host."/magazine/category");
		$this->_json_output($cat_info['data']);
	}//}}}
	
	function ads(){		//广告{{{
		$keys = array('limit', 'start');
		$position = $this->input->get('position');
		$gets = $this->_get_more_non_empty($keys);
		$ads = api($this->api_host."/magazine/ads?limit=".$gets['limit']."&start=".$gets['start']."&position=".$position);
		$this->_json_output($ads);
	}//}}}
/*	
	function _get_download_url(){		//获取杂志下载地址{{{
		$id = $this->_get_non_empty('id');
		$url = api($this->api_host."/magazine/download?id=".$id);
		$this->_json_output($url);
	}//}}}
*/
}
