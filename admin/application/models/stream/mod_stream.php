<?php
class mod_stream extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }
	public function get_all_stream(){
		$rss = $this->load->database('rss', TRUE);
		
		
		
		
		$count = $rss->count_all('rss_block_domain');
		
		$rss->select('domain_name');
		$block = $rss->get('rss_block_domain')->result_array();
		
		$array = array();
		foreach($block as $domain) {
			$array[]=$domain['domain_name'];
		}
		$rss->select('rss_events.home_team,rss_events.start_date,rss_events.away_team,rss_streams.*');
		$rss->where('stream_status','approved');
		if($count > 0){
			$rss->where_not_in('stream_domain', $array);
		}
		$rss->join('rss_events','rss_events.id=rss_streams.event_id_stream');
		
		$get_stream = $rss->get('rss_streams');

		$row_stream['stream_arr'] = $get_stream->result_array();
		
		$row_stream['stream_count'] = $get_stream->num_rows;
	//	echo "<pre>"; print_r($row_stream['stream_arr']);exit;
		return $row_stream;
	}
	public function get_all_stream_pending(){
		$rss = $this->load->database('rss', TRUE);

		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		
		$count = $rss->count_all('rss_block_domain');
		
		$rss->select('domain_name');
		$block = $rss->get('rss_block_domain')->result_array();
		
		$array = array();
		foreach($block as $domain) {
			$array[]=$domain['domain_name'];
		}
		$rss->select('rss_events.home_team,rss_events.start_date,rss_events.away_team,rss_streams.*');
		$rss->where('stream_status','pending');
		if($count > 0){
			$rss->where_not_in('stream_domain', $array);
		}
		$rss->join('rss_events','rss_events.id=rss_streams.event_id_stream');
		//$rss->where('DATE(rss_events.start_date) =', $converted_date );
		$get_stream2 = $rss->get('rss_streams');
		$row_stream2['stream_arr2'] = $get_stream2->result_array();
		$row_stream2['stream_count2'] = $get_stream2->num_rows;
	//	echo "<pre>"; print_r($row_stream2['stream_arr2']);exit;
		return $row_stream2;
		
	}
	public function get_all_stream_raw(){
		$this->db->select('kt_events.home_team,kt_events.away_team,kt_stream_raw.*');
		$this->db->where('stream_status','pending');
		$this->db->group_by('kt_stream_raw.event_id_stream');
		$this->db->join('kt_events','kt_events.id=kt_stream_raw.event_id_stream');
		$get_stream2 = $this->db->get('kt_stream_raw');
		$row_stream2['stream_arr'] = $get_stream2->result_array();
		$row_stream2['stream_count'] = $get_stream2->num_rows;
		//echo "<pre>"; print_r($row_stream['stream_count']);exit;
		return $row_stream2;
	}
	
	public function get_stream($stream_id){
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.home_team,rss_events.away_team,rss_streams.*');
		$rss->where('rss_streams.id',$stream_id);
		$rss->join('rss_events','rss_events.id=rss_streams.event_id_stream');
		$get_stream = $rss->get('rss_streams')->result_array();
		return $get_stream;
		
	}
	public function delete_stream($stream_id){
		$rss = $this->load->database('rss', TRUE);
		$rss->where('id',$stream_id);
		$del_into_db = $rss->delete('rss_streams');
		if($del_into_db){
		return true;	
		} else {
			return false;
		}

	}
	public function delete_stream_raw($stream_id){
		//echo $highlight_id;exit;
		$this->db->where('id',$stream_id);
		$del_into_db = $this->db->delete('kt_stream_raw');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db){
		return true;	
		} else {
			return false;
		}

	}


}
?>