<?php
defined ('BASEPATH') or exit ('No direct access script allow');

class Ovsmodel extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function insUsrInfo($vars)
	{
		if(!empty($vars))
    	{
        	$this->db->insert('tbl_invent_user', $vars);
    	}
  	}

  	public function auth($usrEmail , $usrPassword)
  	{ 
  		$retVal = false;
  		$usrEmail = trim($usrEmail);
  		$usrPassword = trim($usrPassword);
  		
  		$usrInfo = '';
  		if($usrEmail != '' && $usrPassword != '') 
  		{  
  			$condition = array('usrEmail' => $usrEmail,
  					           'usrPass' => $usrPassword); 
  			
  			$usrInfo = $this->db->get_where('tbl_invent_user', $condition);
  		}    
  		if($usrInfo->num_rows() == 1)
  		{
  			$retVal = $usrInfo->result();
  		} 
  		return $retVal;	
  	}
 	public function checkEmail($vars)
 	{
		$list = $this->db->get_where('tbl_invent_user', $vars);
 		return $list->num_rows();
	}

	public function ovslist($table, $limit, $offset=0, $condition, $orderKey)
	{
		if(!empty($condition))
		{
			$this->db->where($condition);
		}
		if ($offset > 0) { $this->db->limit($limit, $offset); }
		else { $this->db->limit($limit); }
		
		$this->db->order_by($orderKey, 'DESC');
		
		return $this->db->get($table);
	}


} // End of Class 
