<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Group extends CI_Controller {
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
		$this->load->model('group_model');
         if (!$this->session->userdata('is_admin_login') ) {
            redirect('admin/home');
        }
		$this->user_id = $this->session->userdata('id');
		if (empty($this->user_id)) {
			redirect('admin/home');
		}
    }

    public function index() {
        $arr['page'] = 'group';
		$id = $this->input->post('id');
		if (!empty($id)) {
			$this->group_model->delGroup($id);
		}
		// pagination >>>
		$offset = 0;  	
	  	$cnt = $this->group_model->countAll($this->user_id);
	  	$arr['dataItem'] = $this->group_model->findPageItems($offset, ADMIN_PAGE_MAX_RECORD ,$this->user_id);
	  	$paging_link = get_link_pagination('admin/group', $cnt,$offset, ADMIN_PAGE_MAX_RECORD, 1, TRUE);
	  	$arr['paging_link'] = $paging_link;
		$arr['user_id'] = $this->user_id;
		// <<< pagination		
	
        $this->load->view('admin/vwManageGroup',$arr);
    }

    public function add_group($id = '') {
        $arr['page'] = 'group';
		// TODO cần thêm thông tin logo công ty nữa
        $this->form_validation->set_rules('group_name', 'group Name', "trim|required|callback_is_duplicate_name[{$id}]");
		$arr['mode'] = 'insert';
		$arr['id'] = $id;
		$arrPost = array();
		if (empty($id))
	    {
	    	// insert
     	  	$arrPost = $this->input->post(); 
	    } else {
	    	// update
	    	// check user have belong to this group
	    	$arrCheck = $this->db->get_where('m_group', array('user_id' => $this->user_id, 'id' => $id))->row_array();
			if (empty($arrCheck)) {
				$arr['errorMsg'] = ('Not allowed to edit');
				$arr['notAllowed'] = '1';
	        } else {
		    	// 1. Load default from DB
		    	if ($this->input->post('submit') === false) {
					$arrPost = $this->group_model->findById($id);
		    	} else {
		    		// 2. Reload if false
		    		$arrPost = $this->input->post();
		    	} 
	    	}
	    }
        
        if ($this->form_validation->run() !== FALSE) {
        	// insert/update
        	$arrPost['user_id'] = $this->user_id;
        	$val = $this->group_model->saveGroup($arrPost, $id);
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
        $this->load->view('admin/vwAddGroup',$arr);
    }
    
	// delete group by submit 
    public function edit_group() {
        $arr['page'] = 'group';
        $this->load->view('admin/vwEditGroup',$arr);
    }
    
     public function block_group() {
        // Code goes here
    }
    
    public function delete_group() {
        // Code goes here
    }
	 
	public function is_duplicate_name($name, $id) {
		$arrData = $this->group_model->findByArray(array('group_name' => $name, 'user_id' => $this->user_id, 'id != ' => (int)$id));
		if (empty($arrData)) {
			return TRUE;
        } else {
            $this->form_validation->set_message('is_duplicate_name', 'Group Name is duplicate');
            return FALSE;
        }
	}  

	// not duplicate email/sms in the same group
	public function customer() {
		$this->load->model('group_customer_model');
		// show list customer with checkbox, pagination,button add emails to groups
		$groupId = $this->input->post('group_id');
		if (empty($groupId)) {
			$groupId = $this->session->userdata('group_id');
			if (empty($groupId)) {
				redirect('admin/home');
			}
		} else {
			$this->session->set_userdata('group_id', $groupId);
		}
		$arr['groupId'] = $groupId;

        $arr['page'] = 'group';
		$id = $this->input->post('id');
		if (!empty($id)) {
			$this->group_customer_model->delGroupEmail($id);
		}
		// pagination >>>
		$offset = 0;  	
		
	  	$cnt = $this->group_customer_model->countAll($groupId);
	  	$arr['dataItem'] = $this->group_customer_model->findPageItems($offset, ADMIN_PAGE_MAX_RECORD ,$groupId);
	  	$paging_link = get_link_pagination('admin/group/customer', $cnt,$offset, ADMIN_PAGE_MAX_RECORD, 1, TRUE);
	  	$arr['paging_link'] = $paging_link;
		$arr['user_id'] = $this->user_id;
		// <<< pagination		
        $this->load->view('admin/vwManageGroupEmail',$arr);		
	}
	
	
	public function cus_import() {
	// when import customer to group:
	    // 1. Insert to customer check validate duplicate like import to customer 
	    // 2.  Check if (1) not duplicate  or duplicate but belongs to this user_id { 
	    //      Insert to t_group_customer if not exist       
	     //  }		
	}

	public function cus_export() {
		// Export just get data and export
	} 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
