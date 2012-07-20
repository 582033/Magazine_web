<?php
class Notfound extends MY_Controller {


	function __construct (){
		parent::__construct();
	}

	function index() {
		header('HTTP/1.1 404');
		$data = array(
					'error_code' => 404,
					'error_msg' => '抱歉，您查看都页面可能已经被删除或暂时不可用',
					);
		$this->smarty->view('about/error_us.tpl', $data);
	}

}
?>
