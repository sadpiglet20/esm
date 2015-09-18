<?php
class Adminusers_model extends CI_Model
{
    function __construct() {
       parent::__construct();
    }

    function findAll() {
        $this->db->select('*');
		$this->db->where(array('user_type != ' => 'SA'));
        $query = $this->db->get('tbl_admin_users');
		if ($query->num_rows() > 0)
		{
        	return $query->result_array();
		}
		return array();
    }
	
	function findById($id) {
		if (!preg_match('/^[-0-9]+$/', $id)) {
	            return array();
	    }
		$this->db->select('*');
		$this->db->where(array('id = ' => $id));
        $query = $this->db->get('tbl_admin_users');
		if ($query->num_rows() > 0)	{
        	return $query->row_array();
		}	
		return array();
	}
	
	function findByArray($arrCond) {
		$this->db->select('*');
		$this->db->where($arrCond);
		$this->db->where(array('user_type != ' => 'SA'));
        $query = $this->db->get('tbl_admin_users');
		if ($query->num_rows() > 0)	{
        	return $query->row_array();
		}	
		return array();
	}	
	
	
	function saveUser($data, $id)
	{
		unset($data['submit'], $data['id'],$data['old_password'],
		      $data['new_password'],$data['id'], $data['isChangePass']);
		if (!is_array($data)){
			return false;
		}
		if (!empty($data['password']) && trim($data['password']) != '') {
			$data['password'] = md5($data['password']);
		} else {
			unset($data['password']);
		}
		// insert
		if (empty($id))
		{
			try {
	        	$this->db->insert('tbl_admin_users', $data);
	        } catch (Exception $ex) {
	        	return false;
	        }
		}
		// update
		else if(preg_match('/^[-0-9]+$/', $id)) {
			try {
	        	$this->db->update('tbl_admin_users', $data, "id = " . $id);
	        } catch (Exception $ex) {
	        	return false;
	        }
	    }
		else
		{
     		return false;
		}
		return true;
	}

	function delAdminUsers($id)
	{
		if(!preg_match('/^[-0-9]+$/', $id)) {
			return false;
		}
		try {
			$this->db->delete('tbl_admin_users', array('id' => $id));
		} catch (Exception $ex) {
        	return false;
	    }
		return true;
	}
	
	// for admin
    function findPageItems($offset, $limit = ADMIN_PAGE_MAX_RECORD) {
        $sql = " select adu.*, cp.company_name from tbl_admin_users adu
                 left join company cp on cp.id = adu.company_id and cp.delete_flag = 0
                 where 1 = 1 and adu.user_type != 'SA' order by adu.id desc limit ?,?  ";
		$query = $this->db->query($sql ,array(@intval($offset), @intval($limit)));
        $result = $query->result_array();
        if (!empty($result) && count($result) > 0) {
            return $result;
        }
        return array();
    }
    
		// for admin
    function countAll() {
    	$sql = " select count(id) cnt from tbl_admin_users where user_type != 'SA' ";
    	$query = $this->db->query($sql);
    	$result = $query->row_array();
    	if (!empty($result) && count($result) > 0) {
    		return $result['cnt'];
    	}
    	return 0;    	
    	 	
	 }
}