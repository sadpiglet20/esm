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
}//end class
