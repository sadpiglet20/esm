<?php
class Ajax extends CI_Controller {

	/**
	 * Controller constructor sets the Title and Permissions
	 *
	 */
	public function __construct() {
		parent::__construct();
	}

	
	public function get_company_list() {
		$items_per_page = $this -> input -> post('num_items') ? $this -> input -> post('num_items') : 30;
		$offset = $this -> input -> post('offset') ? $this -> input -> post('offset') : 0;
		$this -> load -> model("company_model");
		$items = $this -> company_model -> findPageItems($offset, $items_per_page);
		$total = $this -> company_model -> countAll();
		// Paging
		$page_link = get_link_pagination('', $total, $offset, $items_per_page, TRUE);
		$data['dataItem'] = $items;
		$html['paging_link'] = $page_link;
		$html['item_list'] = $this -> load -> view('admin/vwCompanyList', $data, TRUE);
		echo json_encode($html);
		die();
	}
	
	public function get_admin_user_list() {
		$items_per_page = $this -> input -> post('num_items') ? $this -> input -> post('num_items') : 30;
		$offset = $this -> input -> post('offset') ? $this -> input -> post('offset') : 0;
		$this -> load -> model("adminusers_model");
		$items = $this -> adminusers_model -> findPageItems($offset, $items_per_page);
		$total = $this -> adminusers_model -> countAll();
		// Paging
		$page_link = get_link_pagination('', $total, $offset, $items_per_page, TRUE);
		$data['dataItem'] = $items;
		$html['paging_link'] = $page_link;
		$html['item_list'] = $this -> load -> view('admin/vwUserList', $data, TRUE);
		echo json_encode($html);
		die();
	}
	
	
	public function get_group_list() {
		$items_per_page = $this -> input -> post('num_items') ? $this -> input -> post('num_items') : 30;
		$offset = $this -> input -> post('offset') ? $this -> input -> post('offset') : 0;
		$user_id = $this -> input -> post('user_id') ? $this -> input -> post('user_id') : 0;
		$this -> load -> model("group_model");
		$items = $this -> group_model -> findPageItems($offset, $items_per_page, $user_id);
		$total = $this -> group_model -> countAll($user_id);
		// Paging
		$page_link = get_link_pagination('', $total, $offset, $items_per_page, TRUE);
		$data['dataItem'] = $items;
		$html['paging_link'] = $page_link;
		$html['item_list'] = $this -> load -> view('admin/vwGroupList', $data, TRUE);
		echo json_encode($html);
		die();
	}
	
	public function get_customer_list() {
		$user_id = $this -> input -> post('user_id') ? $this -> input -> post('user_id') : 0;
		$items_per_page = $this -> input -> post('num_items') ? $this -> input -> post('num_items') : 30;
		$offset = $this -> input -> post('offset') ? $this -> input -> post('offset') : 0;
		$this -> load -> model("customer_model");
		$items = $this -> customer_model -> findPageItems($offset, $items_per_page, $user_id);
		$total = $this -> customer_model -> countAll($user_id);
		// Paging
		$page_link = get_link_pagination('', $total, $offset, $items_per_page, TRUE);
		$data['dataItem'] = $items;
		$html['paging_link'] = $page_link;
		$html['item_list'] = $this -> load -> view('admin/vwCustomerList', $data, TRUE);
		echo json_encode($html);
		die();
	}					
}//end class
