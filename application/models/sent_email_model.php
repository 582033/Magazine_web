<?php
class sent_email_model extends CI_Model{
	function sent_email_model (){
		parent::__construct();
		$this->load->database();
	}
	
	function _get_username($email){		//获取用户邮箱
		$where = array('account_name' => $email);
		$row = $this->db
						->from('account')
						->where($where)
						->get()
						->row_array();
		return $row;
	}
	
	
	
}
