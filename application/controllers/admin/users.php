<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends CI_Controller {
/**
 * ark Admin Panel for Codeigniter 
 * Author: Abhishek R. Kaushik
 * downloaded from http://devzone.co.in
 *
 */
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model('adminusers_model');
        if (!$this->session->userdata('is_admin_login')) {
            redirect('admin/home');
        }
    }

    public function index() {
        $arr['page'] = 'user';
		// add >>> 
		$id = $this->input->post('id');
		if (!empty($id)) {
			$this->adminusers_model->delAdminUsers($id);
		}
		// pagination >>>
		$offset = 0;  	
	  	$cnt = $this->adminusers_model->countAll($arrCond = array());
	  	$arr['dataItem'] = $this->adminusers_model->findPageItems($offset, ADMIN_PAGE_MAX_RECORD);
	  	$paging_link = get_link_pagination('admin/users', $cnt,$offset, ADMIN_PAGE_MAX_RECORD, 1, TRUE);
	  	$arr['paging_link'] = $paging_link;
		// <<< pagination			
		// <<<< add
        $this->load->view('admin/vwManageUser',$arr);
    }

    public function add_user($id = '') {
        $arr['page'] = 'user';
		// add >>>
		// TODO cần thêm hình user 
        $this->form_validation->set_rules('username', 'User Name', "trim|required|callback_have_blank['test']|callback_is_duplicate_username[{$id}]");
		$this->form_validation->set_rules('email', 'Email', "trim|required|valid_email|callback_is_duplicate_email[{$id}]");
		$this->form_validation->set_rules('mobile', 'Mobile', "trim|required|numeric|callback_is_duplicate_mobile[{$id}]");
		$this->form_validation->set_rules('company_id', 'Company Name', 'trim|required|numberic');
		if ($this->input->post('isChangePass') == '1') {
			$newPass = $this->input->post('new_password');
			$this->form_validation->set_rules('old_password', 'Old Password', "trim|required|callback_is_true_pass[{$id}]");
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
			$this->form_validation->set_rules('password', "Confirm New Password", "trim|required|callback_is_pass_check[{$newPass}]");
		} elseif (empty($id)) {
			$confirmPass = $this->input->post('new_password');
			$this->form_validation->set_rules('password', 'Password',  "trim|required|callback_is_pass_check[{$confirmPass}]");
			$this->form_validation->set_rules('new_password', 'Confirm Password', 'trim|required');
		} 
		
		$arr['mode'] = 'insert';
		$arr['id'] = $id;
		$arrPost = array();
		$this->load->model('company_model');
		$arrCommpany = $this->company_model->findAllSelect();
		if (empty($id))
	    {
	    	// insert
     	  	$arrPost = $this->input->post(); 
	    } else {
	    	// update
	    	// 1. Load default from DB
	    	if ($this->input->post('submit') === false) {
				$arrPost = $this->adminusers_model->findById($id);
	    	} else {
	    		// 2. Reload if false
	    		$arrPost = $this->input->post();
	    	} 
	    }
        
        if ($this->form_validation->run() !== FALSE) {
        	// insert/update
        	$val = $this->adminusers_model->saveUser($arrPost, $id);
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
		$arr['arrCommpany'] = $arrCommpany;		
		// <<< add end		
        $this->load->view('admin/vwAddUser',$arr);
    }

     public function edit_user() {
        $arr['page'] = 'user';
        $this->load->view('admin/vwEditUser',$arr);
    }
    
     public function block_user() {
        // Code goes here
    }
    
     public function delete_user() {
        // Code goes here
    }
    
	
	
	public function is_pass_check($input_password, $new_pass) {
		if ($input_password == $new_pass) {
			return TRUE;
        } else {
            $this->form_validation->set_message('is_pass_check', 'Confirm password is not match');
            return FALSE;
        }
	}
	
	public function is_true_pass($input_password, $id) {
		$arrData = $this->adminusers_model->findByArray(array('password' => md5($input_password), 'id = ' => (int)$id));
		if (!empty($arrData)) {
			return TRUE;
        } else {
            $this->form_validation->set_message('is_true_pass', 'Old password is not match');
            return FALSE;
        }
	}	
	
	public function is_duplicate_email($email, $id) {
		$arrData = $this->adminusers_model->findByArray(array('email' => $email, 'id != ' => (int)$id));
		if (empty($arrData)) {
			return TRUE;
        } else {
            $this->form_validation->set_message('is_duplicate_email', 'Email is duplicated');
            return FALSE;
        }
	}	

	public function is_duplicate_username($username, $id) {
		$arrData = $this->adminusers_model->findByArray(array('username' => $username, 'id != ' => (int)$id));
		var_dump($arrData);
		if (empty($arrData)) {
			return TRUE;
        } else {
            $this->form_validation->set_message('is_duplicate_username', 'User Name is existed');
            return FALSE;
        }
	}		
	
	



	public function is_duplicate_mobile($mobile, $id) {
		$arrData = $this->adminusers_model->findByArray(array('mobile' => $mobile, 'id != ' => (int)$id));
		if (empty($arrData)) {
			return TRUE;
        } else {
            $this->form_validation->set_message('is_duplicate_mobile', 'Mobile is duplicated');
            return FALSE;
        }
	}		
	
	public function have_blank($username) {
		if (strpos($username,' ') === FALSE) {
			return TRUE;
        } else {
            $this->form_validation->set_message('have_blank', 'User Name must not have blank');
            return FALSE;
        }
	}	    
    
    

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */