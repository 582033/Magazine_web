<?php

class About extends MY_Controller {
	
	function about(){
		parent::__construct();
	}
	
	function foot_link($link){		//网站底部链接及跳转{{{
		if ($link == 'about_us'){
			$this->smarty->view('about/about_us.tpl');
		}else if ($link == 'contact_us'){
			$this->smarty->view('about/contact_us.tpl');
		}else if ($link == 'business_cooperation'){
			$this->smarty->view('about/business_cooperation.tpl');
		}else if ($link == 'legal_statement'){
			$this->smarty->view('about/legal_statement.tpl');
		}
	}//}}}
}
