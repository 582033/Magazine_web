<?php
include 'magazine.php';
class About extends Magazine {
	
	function __construct(){
		parent::__construct();
	}
	
	function foot_link($link){		//网站底部链接及跳转{{{
		$data = array();
		if ($link == 'about_us'){
			$pageid = 'about_us';
			$common_data = $this->_get_common_data($pageid);
			$this->smarty->view('about/about_us.tpl', $common_data);
		}else if ($link == 'contact_us'){
			$pageid = 'contact_us';
			$common_data = $this->_get_common_data($pageid);
			$this->smarty->view('about/contact_us.tpl', $common_data);
		}else if ($link == 'join_us'){
			$pageid = 'join_us';
			$common_data = $this->_get_common_data($pageid);
			$this->smarty->view('about/join_us.tpl', $common_data);
		}else if ($link == 'legal_statement'){
			$pageid = 'legal_statement';
			$common_data = $this->_get_common_data($pageid);
			$this->smarty->view('about/legal_statement.tpl', $common_data);
		}		
	}//}}}
}
