<?php
class Group_model extends CI_Model
{
    function __construct() {
       parent::__construct();
    }

    function findAll() {
        $this->db->select('id, group_name');
		$this->db->where(array('delete_flag != ' => 1));
        $query = $this->db->get('m_group');
		if ($query->num_rows() > 0)
		{
        	return $query->result_array();
		}
		return array();
    }
	
    function findAllSelect() {
        $this->db->select('id, group_name');
		$this->db->where(array('delete_flag != ' => 1));
		$this->db->order_by('group_name','asc');
        $query = $this->db->get('m_group');
		if ($query->num_rows() > 0)
		{
        	$arr = $query->result_array();
			$arrReturn = array();
			foreach ($arr as $v) {
				$arrReturn[$v['id']] = $v['group_name'];
			}
			return $arrReturn; 
		}
		return array();
    }	
	
	function findById($id) {
		if (!preg_match('/^[-0-9]+$/', $id)) {
	            return array();
	    }
		$this->db->select('*');
		$this->db->where(array('id = ' => $id));
        $query = $this->db->get('m_group');
		if ($query->num_rows() > 0)	{
        	return $query->row_array();
		}	
		return array();
	}
	
	function findByArray($arrCond) {
		$this->db->select('*');
		$this->db->where($arrCond);
		$this->db->where_in(array('delete_flag != ' => 1));
        $query = $this->db->get('m_group');
		if ($query->num_rows() > 0)	{
        	return $query->row_array();
		}	
		return array();
	}	
	
	
	function saveGroup($data, $id)
	{
		unset($data['submit'], $data['id']);
		if (!is_array($data)){
			return false;
		}
		// insert
		if (empty($id))
		{
			try {
	        	$this->db->insert('m_group', $data);
	        } catch (Exception $ex) {
	        	return false;
	        }
		}
		// update
		else if(preg_match('/^[-0-9]+$/', $id)) {
			try {
	        	$this->db->update('m_group', $data, "id = " . $id);
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

	function delGroup($id)
	{
		if(!preg_match('/^[-0-9]+$/', $id)) {
			return false;
		}
		try {
			$this->db->delete('m_group', array('id' => $id));
		} catch (Exception $ex) {
        	return false;
	    }
		return true;
	}
	
	// for admin
    function findPageItems($offset, $limit = ADMIN_PAGE_MAX_RECORD, $user_id) {
        $sql = " select * from m_group
                 where 1 = 1 and user_id = ". $user_id . " order by id desc limit ?,?  ";
		$query = $this->db->query($sql ,array(@intval($offset), @intval($limit)));
        $result = $query->result_array();
        if (!empty($result) && count($result) > 0) {
            return $result;
        }
        return array();
    }
    
		// for admin
    function countAll($user_id) {
    	$sql = " select count(id) cnt from m_group where delete_flag = 0 and user_id = " . $user_id;
    	$query = $this->db->query($sql);
    	$result = $query->row_array();
    	if (!empty($result) && count($result) > 0) {
    		return $result['cnt'];
    	}
    	return 0;    	
    	 	
	 }
}