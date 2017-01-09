<?php
class mod_footer extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }
	public function get_all_footer(){

		$get_footer = $this->db->get('kt_footer_content');
	
		$row_footer['footer_arr'] = $get_footer->result_array();
		//echo "<pre>";print_r($row_footer['footer_arr']);exit;
		$row_footer['footer_count'] = $get_footer->num_rows;
		return $row_footer;
		
	}
	public function get_footer($footer_id){
		
		$this->db->where('id',$footer_id);
		$get_footer = $this->db->get('kt_footer_content');
		$row_footer['footer_arr'] = $get_footer->row_array();
		$row_footer['footer_count'] = $get_footer->num_rows;
		return $row_footer;
		
	}
}
?>