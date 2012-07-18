<?php

class About extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('auth');
		$this->auth->auth_user();
	}
	
	function foot_link($link){		//网站底部链接及跳转{{{
		if ($link == 'about_us'){
			$this->smarty->view('about/about_us.tpl');
		}else if ($link == 'contact_us'){
			$this->smarty->view('about/contact_us.tpl');
		}else if ($link == 'join_us'){
			$this->smarty->view('about/join_us.tpl');
		}		
	}//}}}
}
