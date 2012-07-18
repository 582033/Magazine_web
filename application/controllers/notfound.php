<?php
class Notfound extends MY_Controller {


	function __construct (){
		parent::__construct();
	}

	function index() {
		$this->smarty->view('about/error_us.tpl');
	}

}
?>
