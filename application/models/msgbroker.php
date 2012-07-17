<?php
class Msgbroker extends CI_Model {
	function __construct() {
		parent::__construct();
		$CI =& get_instance();
		$CI->load->model('mq');
		$this->load->helper('ltitem');
	}
	
	function find_pwd_mail($email, $nickname, $url){//{{{
		$subject = "1001夜互动阅读平台—找回密码";
		$date = date("Y-m-d");
		$data = array(
					'date' => $date,
					'nickname' => $nickname,
					'url' => $url
					);
		$body = $this->smarty->fetch('user/email_view.tpl', $data);
		$spec = array(
					'from' => 'autopost@eee168.com',
					'to' => $email,
					'subject' => $subject,
					'body' => $body,
					'type' => 'html',
					);
		$queue = 'mail';
		$this->mq->publish($spec, $queue, 'magazine');
		$res = array(
					'spec' => $spec,
					'queue' => $queue,
					'vhost' => 'magazine',
					'status' => 'ok'
					);
		return $res;
	}//}}}
	
}
