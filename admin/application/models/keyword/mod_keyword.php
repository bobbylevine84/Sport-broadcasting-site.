<?php
class mod_keyword extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }
	public function get_all_keyword(){
		
		$get_keyword = $this->db->get('kt_keyword');

		$row_keyword['keyword_arr'] = $get_keyword->result_array();
		
		$row_keyword['keyword_count'] = $get_keyword->num_rows;
		return $row_keyword;
		
	}
}
?>