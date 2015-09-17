<?php
class Company_model extends CI_Model
{
    function __construct() {
       parent::__construct();
    }

    function findAll() {
        $this->db->select('id, company_name');
		$this->db->where(array('delete_flag != ' => 1));
        $query = $this->db->get('company');
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
        $query = $this->db->get('company');
		if ($query->num_rows() > 0)	{
        	return $query->row_array();
		}	
		return array();
	}
	
	function findByArray($arrCond) {
		$this->db->select('*');
		$this->db->where($arrCond);
		$this->db->where_in(array('delete_flag != ' => 1));
        $query = $this->db->get('company');
		if ($query->num_rows() > 0)	{
        	return $query->row_array();
		}	
		return array();
	}	
	
	
	function saveCompany($data, $id)
	{
		unset($data['submit'], $data['id']);
		if (!is_array($data)){
			return false;
		}
		// insert
		if (empty($id))
		{
			try {
	        	$this->db->insert('company', $data);
	        } catch (Exception $ex) {
	        	return false;
	        }
		}
		// update
		else if(preg_match('/^[-0-9]+$/', $id)) {
			try {
	        	$this->db->update('company', $data, "id = " . $id);
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

	function delCompany($id)
	{
		if(!preg_match('/^[-0-9]+$/', $id)) {
			return false;
		}
		try {
			$this->db->delete('company', array('id' => $id));
		} catch (Exception $ex) {
        	return false;
	    }
		return true;
	}
	
	// for admin
    function findPageItems($offset, $limit = ADMIN_PAGE_MAX_RECORD) {
        $sql = " select * from company
                 where 1 = 1 limit ?,? ";
		$query = $this->db->query($sql ,array(@intval($offset), @intval($limit)));
        $result = $query->result_array();
        if (!empty($result) && count($result) > 0) {
            return $result;
        }
        return array();
    }
    
		// for admin
    function countAll() {
    	$sql = " select count(id) cnt from company where delete_flag = 0 ";
    	$query = $this->db->query($sql);
    	$result = $query->row_array();
    	if (!empty($result) && count($result) > 0) {
    		return $result['cnt'];
    	}
    	return 0;    	
    	 	
	 }
}