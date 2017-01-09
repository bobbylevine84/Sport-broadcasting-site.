<?php
class mod_domain extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }
	public function get_all_domain(){
		$rss = $this->load->database('rss', TRUE);
		$get_domain = $rss->get('rss_block_domain');

		$row_domain['domain_arr'] = $get_domain->result_array();
		$row_domain['domain_count'] = $get_domain->num_rows;
		//echo "<pre>";print_r($row_channel['channel_arr']);exit;
		return $row_domain;
		
	}

	public function delete_domain($domain_id){
		$rss = $this->load->database('rss', TRUE);
		$rss->where('id',$domain_id);
		$del_into_db = $rss->delete('rss_block_domain');
		
		if($del_into_db){
		return true;	
		} else {
			return false;
		}

	}//end delete_sponsor()


}
?>