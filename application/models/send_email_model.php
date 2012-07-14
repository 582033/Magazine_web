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
						->row_array();
		return $row;
	}
	
	function _update_account_name($account_name, $new_pwd){
		$where = array('account_name' => $account_name);
		$data = array('passwd' => md5($new_pwd));
		$result = $this->db->update('account', $data, $where);
		return $result;
	}
	
}
