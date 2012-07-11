<?php
class send_email_model extends CI_Model{
	function send_email_model (){
		parent::__construct();
		$this->load->database();
	}
	
	function _get_username($email){		//判断是否有邮箱
		$where = array('account_name' => $email);
		$row = $this->db
						->from('account')
						->where($where)
						->get()
						->num_rows();
		return $row;
	}
	
	
	
}
