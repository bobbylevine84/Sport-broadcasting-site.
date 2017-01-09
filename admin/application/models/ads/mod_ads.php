<?php
class mod_ads extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }
	public function get_all_ads(){
	//	$this->db->where('iframe !=', '');
		$get_ads = $this->db->get('kt_ads');

		$row_ads['ads_arr'] = $get_ads->result_array();
		$row_ads['ads_count'] = $get_ads->num_rows;
		//echo "<pre>";print_r($row_channel['channel_arr']);exit;
		return $row_ads;
		
	}
	public function get_all_ads_stream(){
		$get_ads = $this->db->get('kt_ads_stream');

		$row_ads['ads_arr'] = $get_ads->result_array();
		$row_ads['ads_count'] = $get_ads->num_rows;
		return $row_ads;
		
	}
	public function get_all_ads_to_update($ads_id){
		$this->db->where('id',$ads_id);
		$get_ads = $this->db->get('kt_ads');
		$row_ads['ads_arr'] = $get_ads->result_array();
		$row_ads['ads_count'] = $get_ads->num_rows;
		return $row_ads;
	}
	public function get_stream_ads_to_update($ads_id){
		$this->db->where('id',$ads_id);
		$get_ads = $this->db->get('kt_ads_stream');
		$row_ads['ads_arr'] = $get_ads->result_array();
		$row_ads['ads_count'] = $get_ads->num_rows;
		return $row_ads;
	}
	public function get_all_highlight_pending(){
		$this->db->select('domain_name');
		$block = $this->db->get('kt_block_domain')->result_array();
		
		$blocked = array();
		foreach($block as $domain){
			$blocked[]=$domain['domain_name'];
		}//echo "<pre>";print_r($blocked);exit;
		
		$this->db->select('kt_events.home_team,kt_events.away_team,kt_highlight.*');
		$this->db->where('status','pending');
		$this->db->where_not_in('highlight_domain',$blocked);
		//$this->db->like('highlight_domain',$blocked);
		$this->db->join('kt_events','kt_events.id=kt_highlight.event_id');
		$get_highlight2 = $this->db->get('kt_highlight');

		$row_highlight2['highlight_arr2'] = $get_highlight2->result_array();
		$row_highlight2['highlight_count2'] = $get_highlight2->num_rows;
		$row_highlight2['blocked'] = $blocked;
		
		return $row_highlight2;
		
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

		$this->db->select('kt_events.home_team,kt_events.away_team,kt_highlight.*');
		$this->db->where('kt_highlight.id',$highlight_id);
		$this->db->join('kt_events','kt_events.id=kt_highlight.event_id');
		$get_highlight = $this->db->get('kt_highlight')->result_array();
		return $get_highlight;
		
	}
	public function news_slug_generator($slug) {
        $newslug = str_replace(" ","-",strtolower($slug));
        $i = 0;
        $slug2 = $newslug;
        while ($i >= 0) {
            $this->db->where("slug_news", $slug2);
            $count = $this->db->count_all_results('kt_news');
            if ($count < 1) {
                if ($i == 0) {
                    return $slug2;
                    break;
                } else {
                    return $slug2;
                    break;
                }
            }
            $slug2 .= "-" . ($i + 1);
            $i++;
        }

    }
	

	public function delete_ads($ads_id){
		$this->db->where('id',$ads_id);
		$del_into_db = $this->db->delete('kt_ads');
		
		if($del_into_db){
		return true;	
		} else {
			return false;
		}

	}
	public function delete_ads_streams($ads_id){
		$this->db->where('id',$ads_id);
		$del_into_db = $this->db->delete('kt_ads_stream');
		
		if($del_into_db){
		return true;	
		} else {
			return false;
		}

	}


}
?>