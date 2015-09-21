<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Company extends CI_Controller {
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
		$this->load->model('company_model');
         if (!$this->session->userdata('is_admin_login')) {
            redirect('admin/home');
        }
    }

    public function index() {
        $arr['page'] = 'company';
		$id = $this->input->post('id');
		if (!empty($id)) {
			$this->company_model->delCompany($id);
		}
		// pagination >>>
		$offset = 0;  	
	  	$cnt = $this->company_model->countAll($arrCond = array());
	  	$arr['dataItem'] = $this->company_model->findPageItems($offset, ADMIN_PAGE_MAX_RECORD);
	  	$paging_link = get_link_pagination('admin/company', $cnt,$offset, ADMIN_PAGE_MAX_RECORD, 1, TRUE);
	  	$arr['paging_link'] = $paging_link;
		// <<< pagination		
	
        $this->load->view('admin/vwManageCompany',$arr);
    }

    public function add_company($id = '') {
        $arr['page'] = 'company';
		// TODO cần thêm thông tin logo công ty nữa
        $this->form_validation->set_rules('company_name', 'Company Name', "trim|required|callback_is_duplicate_name[{$id}]");
		$arr['mode'] = 'insert';
		$arr['id'] = $id;
		$arrPost = array();
		if (empty($id))
	    {
	    	// insert
     	  	$arrPost = $this->input->post(); 
	    } else {
	    	// update
	    	// 1. Load default from DB
	    	if ($this->input->post('submit') === false) {
				$arrPost = $this->company_model->findById($id);
	    	} else {
	    		// 2. Reload if false
	    		$arrPost = $this->input->post();
	    	} 
	    }
        
        if ($this->form_validation->run() !== FALSE) {
        	// insert/update
        	$val = $this->company_model->saveCompany($arrPost, $id);
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
        $this->load->view('admin/vwAddCompany',$arr);
    }
    
	// delete company by submit 
    public function edit_company() {
        $arr['page'] = 'company';
        $this->load->view('admin/vwEditCompany',$arr);
    }
    
     public function block_company() {
        // Code goes here
    }
    
    public function delete_company() {
        // Code goes here
    }
	 
	public function is_duplicate_name($name, $id) {
		$arrData = $this->company_model->findByArray(array('company_name' => $name, 'id != ' => (int)$id));
		if (empty($arrData)) {
			return TRUE;
        } else {
            $this->form_validation->set_message('is_duplicate_name', 'Company Name is duplicate');
            return FALSE;
        }
	}  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */