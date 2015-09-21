<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends CI_Controller {
/**
 * ark Admin Panel for Codeigniter 
 * Author: Abhishek R. Kaushik
 * downloaded from http://devzone.co.in
 *
 */
    var $user_id;
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model('customer_model');
         if (!$this->session->userdata('is_admin_login') ) {
            redirect('admin/home');
        }
		$this->user_id = $this->session->userdata('id');
		if (empty($this->user_id)) {
			redirect('admin/home');
		}
    }

    public function index() {
    	// get post group_id
    	//$groupId = $this->input->post('group_id');
		// not have get from session
		/*if (empty($groupId)) {
			$groupId = $this->session->userdata('group_id');
			if (empty($groupId)) {
				redirect('admin/home');
			}
		} else {
			$this->session->set_userdata('group_id', $groupId);
		}*/
        $arr['page'] = 'customer';
		// id of customer
		$id = $this->input->post('id');
		if (!empty($id)) {
			$this->customer_model->delCustomer($id);
		}
		// pagination >>>
		$offset = 0;  	
	  	$cnt = $this->customer_model->countAll($this->user_id);
	  	$arr['dataItem'] = $this->customer_model->findPageItems($offset, ADMIN_PAGE_MAX_RECORD,$this->user_id);
	  	$paging_link = get_link_pagination('admin/customer', $cnt,$offset, ADMIN_PAGE_MAX_RECORD, 1, TRUE);
	  	$arr['paging_link'] = $paging_link;
		$arr['user_id'] = $this->user_id;
		// <<< pagination		
	
        $this->load->view('admin/vwManageCustomer',$arr);
    }

    public function add_customer($id = '') {
        $arr['page'] = 'customer';
		// TODO cần thêm thông tin mặt mũi khách hàng
        $this->form_validation->set_rules('customer_name', 'Name', "trim|required");
		$this->form_validation->set_rules('customer_email', 'Email', "trim|required|valid_email|callback_is_duplicate_email[{$id}]");
		$this->form_validation->set_rules('customer_phone', 'Phone', "trim|required|numeric|callback_is_duplicate_phone[{$id}]");
		$arr['mode'] = 'insert';
		$arr['id'] = $id;
		$arrPost = array();
		if (empty($id))
	    {
	    	// insert
     	  	$arrPost = $this->input->post(); 
	    } else {
	    	// update
	    	// check customer have belong to this customer
	    	$arrCheck = $this->db->get_where('m_customer', array('user_id' => $this->user_id, 'id' => $id))->row_array();
			if (empty($arrCheck)) {
				$arr['errorMsg'] = ('Not allowed to edit');
				$arr['notAllowed'] = '1';
	        } else {
		    	// 1. Load default from DB
		    	if ($this->input->post('submit') === false) {
					$arrPost = $this->customer_model->findById($id);
		    	} else {
		    		// 2. Reload if false
		    		$arrPost = $this->input->post();
		    	} 
	    	}
	    }
        
        if ($this->form_validation->run() !== FALSE) {
        	// insert/update
        	$arrPost['user_id'] = $this->user_id;
        	$val = $this->customer_model->saveCustomer($arrPost, $id);
			if ($val) {
				$arr['sucessMsg'] = (empty($id)?'Insert' : 'Update') . ' Successfully!'; 
			} else {
				$arr['errorMsg'] = (empty($id)?'Insert' : 'Update') . ' Failed!';
			} 
		}		
        if ($arrPost === false) {
        	$arrPost = array();
        }

		$arr +=  $arrPost;		
        $this->load->view('admin/vwAddCustomer',$arr);
    }
    
	// delete customer by submit 
    public function edit_customer() {
        $arr['page'] = 'customer';
        $this->load->view('admin/vwEditCustomer',$arr);
    }
    
     public function block_customer() {
        // Code goes here
    }
    
    public function delete_customer() {
        // Code goes here
    }
	 
	public function is_duplicate_email($name, $id) {
		$arrData = $this->customer_model->findByArray(array('customer_email' => $name, 'id != ' => (int)$id));
		if (empty($arrData)) {
			return TRUE;
        } else {
            $this->form_validation->set_message('is_duplicate_email', 'Customer Email is duplicate');
            return FALSE;
        }
	}  

	public function is_duplicate_phone($name, $id) {
		$arrData = $this->customer_model->findByArray(array('customer_phone' => $name, 'id != ' => (int)$id));
		if (empty($arrData)) {
			return TRUE;
        } else {
            $this->form_validation->set_message('is_duplicate_phone', 'Customer Phone is duplicate');
            return FALSE;
        }
	} 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
