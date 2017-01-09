<?php
class mod_highlight extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }
	public function get_all_highlight(){
		$rss = $this->load->database('rss', TRUE);
		$count = $rss->count_all('rss_block_domain');
		
		$rss->select('domain_name');
		$block = $rss->get('rss_block_domain')->result_array();
		
		$array = array();
		foreach($block as $domain) {
			$array[]=$domain['domain_name'];
		}
		$rss->select('rss_events.home_team,rss_events.away_team,rss_highlight.*');
		$rss->where('status_raw','approved');
		if($count > 0){
			$rss->where_not_in('highlight_domain',$array);
		}
		
		
		//$this->db->like('highlight_domain',$blocked2);
		
		$rss->join('rss_events','rss_events.id=rss_highlight.event_id_highlight');
		$get_highlight = $rss->get('rss_highlight');

		$row_highlight['highlight_arr'] = $get_highlight->result_array();
		$row_highlight['highlight_count'] = $get_highlight->num_rows;
		return $row_highlight;
		
	}
	public function get_all_highlight_pending(){
		$rss = $this->load->database('rss', TRUE);
		$count = $rss->count_all('rss_block_domain');
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		$rss->select('domain_name');
		$block = $rss->get('rss_block_domain')->result_array();
		
		$array = array();
		foreach($block as $domain) {
			$array[]=$domain['domain_name'];
		} 
		$rss->select('rss_events.home_team,rss_events.away_team,rss_highlight.*');
		$rss->where('status_raw','pending');
		if($count > 0){
			$rss->where_not_in('highlight_domain',$array);
		}
		
		//$this->db->like('highlight_domain',$blocked);
		
		$rss->join('rss_events','rss_events.id=rss_highlight.event_id_highlight');
		 $rss->where('DATE(rss_events.start_date) =', $converted_date );
		$get_highlight2 = $rss->get('rss_highlight');

		$row_highlight2['highlight_arr2'] = $get_highlight2->result_array();
	//	echo "<pre>";print_r($row_highlight2['highlight_arr2']);exit;
		$row_highlight2['highlight_count2'] = $get_highlight2->num_rows;
		$row_highlight2['blocked'] = $blocked;
		
		return $row_highlight2;
		
	}
	public function get_all_highlight_raw(){
		//$this->db->select('kt_events.home_team,kt_events.away_team,kt_highlight_raw2.*');
		$this->db->select('kt_highlight_raw2.*');
		$this->db->where('status_raw','pending');
		//$this->db->join('kt_events','kt_events.id=kt_highlight_raw2.event_id_highlight');
		$get_highlight = $this->db->get('kt_highlight_raw2');
		$row_highlight['highlight_arr'] = $get_highlight->result_array();
		$row_highlight['highlight_count'] = $get_highlight->num_rows;
		//echo "<pre>"; print_r($row_highlight['highlight_arr']);exit;
		return $row_highlight;
	}
	public function get_all_highlight_raw2(){
		$this->db->select('kt_events.home_team,kt_events.away_team,kt_highlight_raw.*');
		$this->db->join('kt_events','kt_events.id=kt_highlight_raw.event_id_highlight');
		$this->db->where('status_raw','pending');
		$get_highlight = $this->db->get('kt_highlight_raw');
		
		$row_highlight['highlight_arr'] = $get_highlight->result_array();
		$row_highlight['highlight_count'] = $get_highlight->num_rows;
		//echo "<pre>"; print_r($row_highlight['highlight_arr']);exit;
		return $row_highlight;
	}
	
	
	// public function check_array_of_words_in_string($words, $string, $option){
		
		// if ($option == "all") {
			// $isFound = true;
			// foreach ($words as $value) {
				// $isFound = $isFound && (stripos($string, $value) !== false); // returns boolean false if nothing is found, not 0
				// if (!$isFound) break; // if a word wasn't found, there is no need to continue
			// }
		// } else {
			// $isFound = false;
			// foreach ($words as $value) {
				// $isFound = $isFound || (stripos($string, $value) !== false);
				// if ($isFound) break; // if a word was found, there is no need to continue
			// }
		// }
		// return $isFound;

	// }
	public function get_highlight($highlight_id){
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.home_team,rss_events.away_team,rss_highlight.*');
		$rss->where('rss_highlight.id',$highlight_id);
		$rss->join('rss_events','rss_events.id=rss_highlight.event_id_highlight');
		$get_highlight = $rss->get('rss_highlight')->result_array();
		return $get_highlight;
		
	}

	public function delete_highlight($highlight_id){
		$rss = $this->load->database('rss', TRUE);
		$rss->where('id',$highlight_id);
		$del_into_db = $rss->delete('rss_highlight');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db){
		return true;	
		} else {
			return false;
		}

	}//end delete_sponsor()
	public function delete_highlights_raw($highlight_id){
		//echo $highlight_id;exit;
		$this->db->where('id',$highlight_id);
		$del_into_db = $this->db->delete('kt_highlight_raw');
		if($del_into_db){
		return true;	
		} else {
			return false;
		}

	}


}
?>