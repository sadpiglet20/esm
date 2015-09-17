<?php
	function get_value(&$array, $key, $defval = '') {
	    if (is_array($array) && array_key_exists($key, $array)) {
	        return $array[$key];
	    }
	    return $defval;
	}  
	
	function get_link_pagination($url, $total_rows, $offset, $per_page, $is_ajax = false) {
		$pagination_config['base_url'] = "#";
		$pagination_config['total_rows'] = $total_rows;
		$pagination_config['per_page'] = $per_page;
		$pagination_config['first_link'] = '';
		$pagination_config['last_link'] = '';
		$pagination_config['cur_page'] = $offset;
		
		//$pagination_config['num_links'] = $num_links;
		//$pagination_config['next_link'] = '次';
		//$pagination_config['prev_link'] = '前';
	
		//$pagination_config['first_tag_open'] = '<li>';
		//$pagination_config['first_tag_close'] = '</li>';
		//$pagination_config['last_tag_open'] = '<li>';
		//$pagination_config['last_tag_close'] = '</li>';
		$pagination_config['next_tag_open'] = '<li>';
		$pagination_config['next_tag_close'] = '</li>';
		$pagination_config['prev_tag_open'] = '<li>';
		$pagination_config['prev_tag_close'] = '</li>';
		$pagination_config['cur_tag_open'] = '<li class="active"><a>';
		$pagination_config['cur_tag_close'] = '</a></li>';
		$pagination_config['num_tag_open'] = '<li>';
		$pagination_config['num_tag_close'] = '</li>';
		$ci = &get_instance();
		$ci->load->library('pagination');
		$ci->pagination->initialize($pagination_config);
		return $ci->pagination->create_links();
		if($is_ajax)
			return $ci->pagination->create_links_ajax();
		else
			return $ci->pagination->create_links();
	}
