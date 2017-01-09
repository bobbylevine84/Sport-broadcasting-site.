<?php
class mod_event extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }
	public function get_sport_team_name($q,$nation){
		// echo $nation; 
		// echo $q; exit;
		//$sport_team = $this->input->post('sport_team');
		$rss = $this->load->database('rss', TRUE);
		$rss->select('name');
		$rss->like('name', $q);
		$rss->where('nation',$nation);
		//$this->db->join('kt_team','kt_team.sport_cat_id=kt_sport_category.id');
		$get_team = $rss->get('rss_team')->result_array();
		echo "<pre>";print_r($get_team);
		$i=0;
        foreach ($get_team as $row) {
			
            $row_set[$i]['label'] = htmlentities(stripslashes($row['name']));
			$row_set[$i]['id'] = htmlentities(stripslashes($row['id']));
			$i++;
        }
		if($row_set == NULl)
		{
			$i=0;
			$row_set[$i]['label'] = 'No Search Results';
			$row_set[$i]['id'] = -1;
		}
        echo json_encode($row_set);
		//echo json_encode($get_team);
	}
	public function get_all_event(){
		
		
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->where('DATE(rss_events.start_date) =', $converted_date );

		//$rss->where('rss_events.end_date >= ', $converted_datetime );
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$get_event = $rss->get('rss_events');
		//echo $rss->last_query();exit;
		
		

		$row_event['event_arr'] = $get_event->result_array();
		//echo "<pre>";print_r($row_event['event_arr']);exit;
		$row_event['event_count'] = $get_event->num_rows;
		return $row_event;
		
	}
	public function edit_my_event($id){
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		

		//$rss->where('rss_events.end_date >= ', $converted_datetime );
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		
		$rss->where('rss_events.id',$id);
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$get_event_new = $rss->get('rss_events')->result_array();
		
		//echo $rss->last_query();exit;
		
		//echo "<pre>";print_r($get_event_new);exit;
		return $get_event_new;
	}
	public function get_event_raw(){
		$this->db->select('kt_events_raw.*, hometeam.logo as home_team_logo, awayteam.logo as away_team_logo, kt_nation_custom_text.competition_name');		
		$this->db->join('kt_nation_custom_text','kt_nation_custom_text.competition_id=kt_events_raw.competition_id');
		$this->db->join('kt_team as hometeam','hometeam.name=kt_events_raw.home_team ','left');
		$this->db->join('kt_team as awayteam','awayteam.name=kt_events_raw.away_team', 'left');
		$this->db->where('kt_events_raw.event_status_raw','pending');
		$this->db->order_by('kt_events_raw.id','desc');
		$this->db->group_by('kt_events_raw.id');
		$get_event = $this->db->get('kt_events_raw');

		$row_event['event_arr'] = $get_event->result_array();
		
		$row_event['event_count'] = $get_event->num_rows;
		return $row_event;
	}
	public function get_all_event_pending(){
		// $this->db->select('kt_event.home_team,kt_event.away_team,kt_stream.*');
		// $this->db->where('stream_status','pending');
		// $this->db->join('kt_event','kt_event.id=kt_stream.event_id_stream');
		// $get_stream2 = $this->db->get('kt_events');

		// $row_event2['event_arr2'] = $get_event2->result_array();
		// $row_event2['event_count2'] = $get_event2->num_rows;
		//echo "<pre>"; print_r($row_stream2['stream_count2']);exit;
		// return $row_event2;
		
	}
	public function get_event($event_id){

		// $this->db->select('kt_event.home_team,kt_event.away_team,kt_stream.*');
		// $this->db->where('kt_stream.id',$event_id);
		// $this->db->join('kt_event','kt_event.id=kt_stream.event_id_stream');
		// $get_event = $this->db->get('kt_events')->result_array();
		// return $get_event;
		
	}
	public function get_demo_event(){

		$this->db->select('kt_sport_category.*,kt_nation_custom_text.*');
		$this->db->where('kt_sport_category.id',2);
		$this->db->join('kt_nation_custom_text','kt_nation_custom_text.sport_cat_id=kt_sport_category.id');
		$get_event = $this->db->get('kt_sport_category')->result_array();
		return $get_event;
		
	}
	public function delete_event($event_id){
		$rss = $this->load->database('rss', TRUE);
		$rss->where('id',$event_id);
		$del_into_db = $rss->delete('rss_events');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db){
		return true;	
		} else {
			return false;
		}

	}
	public function delete_events_raw($event_id){
		//echo $event_id;exit;
		$this->db->where('id',$event_id);
		$del_into_db = $this->db->delete('kt_events_raw');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db){
		return true;	
		} else {
			return false;
		}

	}


}
?>