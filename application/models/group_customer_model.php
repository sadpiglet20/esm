<?php
class Group_customer_model extends CI_Model
{
    function __construct() {
       parent::__construct();
    }

    function findAll() {
        $this->db->select('id, group_id, customer_id');
        $query = $this->db->get('t_group_customer');
		if ($query->num_rows() > 0)
		{
        	return $query->result_array();
		}
		return array();
    }
	
	function findByGroupId($id) {
		if (!preg_match('/^[-0-9]+$/', $id)) {
	            return array();
	    }
		 $sql = " select grc.*, cus.customer_name,cus.customer_email,cus.customer_phone from t_group_customer grc
        	    left join m_customer cus on cus.id = grc.customer_id
                 where grc.group_id = ". $id . " order by cus.customer_name asc";
		if ($query->num_rows() > 0)	{
        	return $query->result_array();
		}	
		return array();
	}
	
	function findByArray($arrCond) {
		$this->db->select('*');
		$this->db->where($arrCond);
        $query = $this->db->get('t_group_customer');
		if ($query->num_rows() > 0)	{
        	return $query->row_array();
		}	
		return array();
	}	
	
	
	function saveGroupCustomer($data, $id)
	{
		unset($data['submit'], $data['id']);
		if (!is_array($data)){
			return false;
		}
		// insert
		if (empty($id))
		{
			try {
	        	$this->db->insert('t_group_customer', $data);
	        } catch (Exception $ex) {
	        	return false;
	        }
		}
		// update
		else if(preg_match('/^[-0-9]+$/', $id)) {
			try {
	        	$this->db->update('t_group_customer', $data, "id = " . $id);
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

	function delGroupEmail($id)
	{
		if(!preg_match('/^[-0-9]+$/', $id)) {
			return false;
		}
		try {
			$this->db->delete('t_group_customer', array('id' => $id));
		} catch (Exception $ex) {
        	return false;
	    }
		return true;
	}
	
	// for admin
    function findPageItems($offset, $limit = ADMIN_PAGE_MAX_RECORD, $group_id) {
        $sql = " select grc.*, cus.customer_name,cus.customer_email,cus.customer_phone from t_group_customer grc
        	    left join m_customer cus on cus.id = grc.customer_id
                 where grc.group_id = ". $group_id . " order by cus.customer_name asc limit ?,?  ";
		$query = $this->db->query($sql ,array(@intval($offset), @intval($limit)));
        $result = $query->result_array();
        if (!empty($result) && count($result) > 0) {
            return $result;
        }
        return array();
    }
    
		// for admin
    function countAll($groupId) {
    	$sql = " select count(id) cnt from t_group_customer where group_id = " . $groupId;
    	$query = $this->db->query($sql);
    	$result = $query->row_array();
    	if (!empty($result) && count($result) > 0) {
    		return $result['cnt'];
    	}
    	return 0;    	
    	 	
	}
	
	function checkDuplicateImportCustomer($customer_email, $customer_phone, $company_id) {
		$sql = " select 
				    cu.id
				from m_customer cu 
				where ( cu.customer_email = '{$customer_email}'  or cu.customer_phone = '{$customer_phone}')  
				        and cu.user_id in (
				                            select id 
				                            from tbl_admin_users
				                            where company_id = {$company_id} 
				                            )
				limit 1   ";		
		
		$query = $this->db->query($sql);
    	$result = $query->row_array();
    	if (!empty($result) && count($result) > 0) {
    		return true;
    	}
    	return false;  
	}
	
	/*function checkUserOfCustomer($customer_email, $customer_phone, $user_id) {
		$sql = " select 
				    cu.id
				from m_customer cu 
				where ( cu.customer_email = '{$customer_email}'  or cu.customer_phone = '{$customer_phone}')  
				        and cu.user_id 
				limit 1   ";		
		$query = $this->db->query($sql);
    	$result = $query->row_array();
    	if (!empty($result) && count($result) > 0) {
    		return true;
    	}
    	return false;  
   }*/
	
	// for admin
    function findAllCustomers($user_id) {
        $sql = " select * from m_customer
                 where user_id = ". $user_id . " order by customer_name asc";
		$query = $this->db->query($sql);
        $result = $query->result_array();
        if (!empty($result) && count($result) > 0) {
            return $result;
        }
        return array();
    }	
	
	// for admin
    function findAllGroupCustomers($user_id, $group_id) {
        $sql = " select cus.* from m_customer cus
                 inner join t_group_customer grpcu 
                 			on grpcu.customer_id = cus.id and grpcu.group_id = {$group_id}
                 where cus.user_id = ". $user_id . " order by cus.customer_name asc";
		$query = $this->db->query($sql);
        $result = $query->result_array();
        if (!empty($result) && count($result) > 0) {
            return $result;
        }
        return array();
    }		
	 
	/*function chkExistGroupCustomer($groupId, $customerId) {
    	$sql = " SELECT 1
                  FROM t_group_customer AS a
                  WHERE a.group_id = {$groupId} and a.customer_id = {$customerId} ";
    	$query = $this->db->query($sql);
    	$result = $query->row_array();
    	$flag = false;
    	if (!empty($result) && count($result) > 0) {
    		$flag = true;
    	}
    	return false;    	
    	 					  
	}*/
	
	// return true => allow insert else => not alow
	function allowInsertGroupCustomer($userId, $groupId, $customer_email, $customer_phone, $id = '') {
		$sql = "
				select cu.id as cusId, grcu.id as grCuId
				from m_customer as cu
				left join t_group_customer grcu on  grcu.customer_id = cu.id and grcu.group_id = {$groupId} and grcu.id != ?
				where (cu.customer_email = '{$customer_email}'  or cu.customer_phone = '{$customer_phone}') and cu.user_id = {$userId} ";
		$query = $this->db->query($sql, $id);
    	$result = $query->row_array();
    	if (!empty($result) && count($result) > 0) {
			if (empty($result['grCuId'])) {
				return $result['cusId'];
			} else {
				return -1;
			}
    	}
		return -1; // this customer maybe belongs to others user 
	}
}