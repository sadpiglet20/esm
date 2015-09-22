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

	// TODO not duplicate email/sms in the same group
	public function customer() {
		$this->load->model('group_customer_model');
		// TODO show list customer with checkbox, pagination,button add emails to groups
		$groupId = $this->input->post('group_id');
		if (empty($groupId)) {
			$groupId = $this->session->userdata('group_id');
			if (empty($groupId)) {
				redirect('admin/home');
			}
		} else {
			$this->session->set_userdata('group_id', $groupId);
		}
		$groupInfo = $this->db->get_where('m_group', array('id' => $groupId))->row_array();
		
		$arr['group_name'] = "";
		if (!empty($groupInfo)) {
			$arr['group_name'] = $groupInfo['group_name'];
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
	
	
	// todo
    public function add_customer($id = '') {
        $arr['page'] = 'group';
		// TODO cần thêm thông tin thêm cho customer nếu cần
        $this->form_validation->set_rules('customer_name', 'Customer Name', "trim|required");
		$this->form_validation->set_rules('customer_email', 'Customer Email', "trim|required|callback_is_duplicate_email[{$id}]");
		$this->form_validation->set_rules('customer_phone', 'Customer Phone', "trim|required|numeric|callback_is_duplicate_phone[{$id}]");
		$arr['mode'] = 'insert';
		$arr['id'] = $id;
		$arrPost = array();
		if (empty($id))
	    {
	    	// insert
     	  	$arrPost = $this->input->post(); 
	    } else {
		    // TODO when import customer to group:
		    // 1. Insert to customer check validate duplicate like import to customer 
		    // 2.  Check if (1) not duplicate  or duplicate but belongs to this user_id { 
		    //      Insert to t_group_customer if not exist       
		    // }	
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
	
	public function cus_import() {
		// TODO when import customer to group:
	    // 1. Insert to customer check validate duplicate like import to customer 
	    // 2.  Check if (1) not duplicate  or duplicate but belongs to this user_id { 
	    //      Insert to t_group_customer if not exist       
	     //  }	
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
						/*$arrColumns = array('id' => 'A',
						              	  'customer_name' => 'B',
						              	  'customer_email' => 'C',
							              'customer_phone' => 'D',
							              'description' => 'E'
										 );*/
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
	} 

	public function cus_export() {
		// TODO Export just get data and export of group 
		$arr['user_id'] = $this->user_id;
		// export 
		$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("Customer Export " . date('Ymd'))
		                 ->setDescription("description");
		// set design for beauty
		// Assign cell values
		$objPHPExcel->setActiveSheetIndex(0);
		$sheet = $objPHPExcel->getActiveSheet();
		$this->load->model('group_customer_model');
		$arrCustomer = $this->group_customer_model->findAllCustomers($this->user_id);
		$sheet->setCellValue('A1', 'STT');
		$sheet->setCellValue('B1', 'Họ và Tên');
		$sheet->setCellValue('C1', 'Email');
		$sheet->setCellValue('D1', 'SĐT');
		$sheet->setCellValue('E1', 'Ghi Chú');
		$sheet->getStyle('A1')->applyFromArray(
							    array(
							        'fill' => array(
							            'type' => PHPExcel_Style_Fill::FILL_SOLID,
							            'color' => array('rgb' => 'FFFF99')
							        )
							    ));
		$sheet->getStyle('B1')->applyFromArray(
							    array(
							        'fill' => array(
							            'type' => PHPExcel_Style_Fill::FILL_SOLID,
							            'color' => array('rgb' => 'FFFF99')
							        )
							    ));
		$sheet->getStyle('C1')->applyFromArray(
							    array(
							        'fill' => array(
							            'type' => PHPExcel_Style_Fill::FILL_SOLID,
							            'color' => array('rgb' => 'FFFF99')
							        )
							    ));
		$sheet->getStyle('D1')->applyFromArray(
							    array(
							        'fill' => array(
							            'type' => PHPExcel_Style_Fill::FILL_SOLID,
							            'color' => array('rgb' => 'FFFF99')
							        )
							    ));
		$sheet->getStyle('E1')->applyFromArray(
							    array(
							        'fill' => array(
							            'type' => PHPExcel_Style_Fill::FILL_SOLID,
							            'color' => array('rgb' => 'FFFF99')
							        )
							    ));																																
		$row = 2;
		foreach ($arrCustomer as $v) {
			$sheet->setCellValue('A' . $row, $row-1);
			$sheet->setCellValue('B' . $row, $v['customer_name']);
			$sheet->setCellValue('C' . $row, $v['customer_email']);
			$sheet->getCell('D' . $row)->setValueExplicit($v['customer_phone'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue('E' . $row, $v['description']);
			$row++;	
		}
	    @ob_end_clean();
		$file_name = 'CustomerList_' . date('YmdHis') .'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $file_name .'"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	    @ob_end_clean();
	
	    $objWriter->save('php://output');
	    $objPHPExcel->disconnectWorksheets();
	    unset($objPHPExcel);			
		// $this->load->view('admin/vwCustomerExport',$arr);
	} 	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
