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
	var $company_id;
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model('customer_model');
         if (!$this->session->userdata('is_admin_login') ) {
            redirect('admin/home');
        }
		$this->user_id = $this->session->userdata('id');
		$this->company_id = $this->session->userdata('company_id');
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
	
	public function import() {
		$this->load->model('group_customer_model');
		$arr['user_id'] = $this->user_id;
		// import 
		if ($this->input->post('submit')) {
			$this->load->library('PHPExcel');
			// check
			$tmp_name = $_FILES['fName']['tmp_name'];
			if ($_FILES["fName"]["error"] > 0) {
			 	$arr['errorMsg'] = 'Upload Failed!Check file name, or capacity';
			} else {
				$file_name = EXCEL_EXPORT_DIR . 'excel_' . str_replace('.', '_', microtime(true)) . '.xls';
				$moveFlag = @move_uploaded_file($tmp_name, $file_name);
				if ($moveFlag) {
					// read file
					try {
						$objReader = PHPExcel_IOFactory::createReader('Excel5');
						$objPHPExcel = $objReader->load($file_name);
						$objPHPExcel->setActiveSheetIndex(0); 
						$sheet = $objPHPExcel->getActiveSheet();
						$rowStart = 2;
						$batchLimit = 500;
						$arrColumns = array('id' => 'A',
						              	  'customer_name' => 'B',
						              	  'customer_email' => 'C',
							              'customer_phone' => 'D',
							              'description' => 'E'
										 );
						$i = $rowStart;
						$arrData = array();
						$dupCustomer = 0;
						while (1) {
							$customer_name = $sheet->getCell('B' . $i)->getValue();
							$customer_email = $sheet->getCell('C' . $i)->getValue();
							$customer_phone = $sheet->getCell('D' . $i)->getValue();
							$isDuplicate = $this->group_customer_model->checkDuplicateImportCustomer($customer_email, $customer_phone, $this->company_id);
							$dupCustomer += $isDuplicate ? 1 : 0;
							if (!$isDuplicate && !empty($customer_name) && !empty($customer_email)) {
								// will optimize later
								$arrData[] = array(
										  'customer_name' => $customer_name,
						              	  'customer_email' => $customer_email,
							              'customer_phone' => $customer_phone,
							              'user_id' => $this->user_id,
							              'description' => $sheet->getCell('E' . $i)->getValue()
									   );
							}
							if (empty($customer_name) && empty($customer_email)) {
								break;
							}
							if ($i%$batchLimit == 0 && !empty($arrData)) {
								$this->db->insert_batch('m_customer', $arrData);
								// reset
								$arrData = array();
							} 
							$i++;
						}
						if (!empty($arrData)) {
							$this->db->insert_batch('m_customer', $arrData);
						}
						$arr['sucessMsg'] = 'Import '.($i - $dupCustomer - $rowStart).' row(s) successfully! ' . $dupCustomer . " row(s) duplicated!";
						// delete file upload
						@unlink($tmp_name);
						@unlink($file_name);
					} catch (Exception $ex) {
						$arr['errorMsg'] = 'Upload Failed!' . $ex->getMessage();
					}
				}  
			}
		}
		$this->load->view('admin/vwCustomerImport',$arr);
		/*$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")
		                 ->setDescription("description");
		
		// Assign cell values
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'cell value here');
		
	    @ob_end_clean();
		$domain_name = str_replace('http://', '', base_url());
		$domain_name = substr($domain_name, 0, -1);
		$file_name = 'CustomerList_' . date('YmdHis') .'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $file_name .'"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
	
	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	    @ob_end_clean();
	
	    $objWriter->save('php://output');
	    $objPHPExcel->disconnectWorksheets();
	    unset($objPHPExcel);*/
	} 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
