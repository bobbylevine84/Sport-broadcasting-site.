<?php

class Index_model extends CI_Model {

    public function get_countries() {
        $this->db->select("CountryId as id, Country as name");
        $query = $this->db->get('kt_countries')->result_array();
        return $query;
    }
	public function get_events(){
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
		$rss->where('DATE(rss_events.start_date) <',$converted_date ); //h:i:s for time as well.
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$rss->limit(10);
		$query = $rss->get('rss_events')->result_array();
		//echo $this->db->last_query();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function get_scrap_events(){
		$query = $this->db->get('kt_highlight_raw2')->result_array();
		return $query;
	}
	public function ajax_events_competition_all(){
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
		$rss->where('DATE(rss_events.start_date) <',$converted_date ); //h:i:s for time as well.
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo $this->db->last_query();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function ajax_all_nations($nation_sport_id = NULL,$datepicker = null){
		$datepick = date('Y-m-d',strtotime($datepicker));
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		if($datepicker){
			$rss->where('DATE(rss_events.start_date) =',$datepick);
		} else {
			$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
			$rss->where('DATE(rss_events.start_date) <',$converted_date );
		}
		
		$rss->order_by('rss_events.start_date','desc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function get_nation_ajax($nation_id,$datepicker = null){
		$datepick = date('Y-m-d',strtotime($datepicker));
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		$rss->where('rss_events.nation',$nation_id);
		if($datepicker){
			$rss->where('DATE(rss_events.start_date) =',$datepick);
		} else {
			$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
			$rss->where('DATE(rss_events.start_date) <',$converted_date );
		}
		
		$rss->order_by('rss_events.start_date','desc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function get_nation_sports($nation_id,$datepicker){
		$datepick = date('Y-m-d',strtotime($datepicker));
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		$rss->where('rss_events.nation',$nation_id);
		if($datepicker){
			$rss->where('DATE(rss_events.start_date) =',$datepick );
		} else {
			$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
			$rss->where('DATE(rss_events.start_date) <',$converted_date ); //h:i:s for time as well.
		}
		
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		return $query;
	}
	public function get_competition_nations($nation_neww,$nation_sport_id = NULL,$datepicker = null){
		$datepick = date('Y-m-d',strtotime($datepicker));
		$nation = str_replace(' ','-',$nation_neww);
		$rss = $this->load->database('rss', TRUE);
		$new_nation = str_replace('-',' ',$nation);
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		
		$rss->where('rss_events.nation',$new_nation);
		if($nation_sport_id){
			$rss->where('rss_events.sport_category_id',$nation_sport_id);
		}
		if($datepicker){
			$rss->where('DATE(rss_events.start_date) =',$datepick );
		} else {
			$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
			$rss->where('DATE(rss_events.start_date) <',$converted_date ); //h:i:s for time as well.
		}
		
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo $rss->last_query();exit;
		return $query;
	}
	public function get_nation_sports_competition($sport_id_changed){
		
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');

		$rss->where('rss_sport_category.id',$sport_id_changed);
		$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
		$rss->where('DATE(rss_events.start_date) <',$converted_date ); //h:i:s for time as well.
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		return $query;
	}
	public function ajax_events_competition($competition = null,$datepicker = null){
		//echo $competition;exit;
		$datepick = date('Y-m-d',strtotime($datepicker));
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');

		$rss->where('rss_competition.competition_id',$competition);
		if($datepicker){
			$rss->where('DATE(rss_events.start_date) =',$datepick );
		} else {
			$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
			$rss->where('DATE(rss_events.start_date) <',$converted_date ); //h:i:s for time as well.
		}
		
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		return $query;
		
	}
	public function get_ajax_sports_empty(){
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
		$rss->where('DATE(rss_events.start_date) <',$converted_date ); //h:i:s for time as well.
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		return $query;
	}
	public function get_ajax_sports($competition){
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');

		$rss->where('rss_competition.competition_id',$competition);
		$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
		$rss->where('DATE(rss_events.start_date) <',$converted_date ); //h:i:s for time as well.
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		return $query;
	}
	public function ajax_nations_sports($sport,$nation = null,$datepicker = null){
		$datepick = date('Y-m-d',strtotime($datepicker));
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');

		$rss->where('rss_sport_category.id',$sport);
		if($nation){
			$rss->where('rss_events.nation',$nation);
		}
		
		if($datepicker){
			$rss->where('DATE(rss_events.start_date) =',$datepick );
		} else {
			$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
			$rss->where('DATE(rss_events.start_date) <',$converted_date );
		}
		 //h:i:s for time as well.
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		return $query;
	}
	public function ajax_events_sports_empty($sports_id = null,$datepicker = null){
		$datepick = date('Y-m-d',strtotime($datepicker));
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		
		if($datepicker){
			$rss->where('DATE(rss_events.start_date) =',$datepick);
		} else {
			$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
			$rss->where('DATE(rss_events.start_date) <',$converted_date );
		}
		
		$rss->where('rss_sport_category.id',$sports_id);
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo $this->db->last_query();
		return $query;
	}
	public function get_team_player($id){
		$this->db->where('kt_team.id',$id);
		$this->db->join('kt_team_player','kt_team_player.team_id=kt_team.id');
		$result = $this->db->get('kt_team')->result_array();
		//echo "<pre>";print_r($result);exit;
		return $result;
	}
	public function get_sport_events($sport_id){
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		
		$rss = $this->load->database('rss', TRUE);
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		
		$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
		$rss->where('DATE(rss_events.start_date) <',$converted_date ); //h:i:s for time as well.
		$rss->where('rss_sport_category.id',$sport_id);
		
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo $this->db->last_query();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function get_team_events($id){
		//echo $id;
		$rss = $this->load->database('rss', TRUE);
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->where('start_date >',$converted_datetime);
		
		$rss->where('hometeam.id',$id);
		 //$rss->or_where('DATE(rss_events.start_date) >=', $converted_date );
		// $rss->where('DATE(rss_events.start_date) <=', $session_date_tommorrow );
		//$rss->where('awayteam.id',$id);
		$rss->or_where('awayteam.id',$id);
		//$current_time = $this->session->userdata('time_timezone');
	//	$rss->where('rss_events.end_date >= ', $current_time );
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		$rss->limit(5);
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->where('start_date <',$converted_datetime);
		
		$rss->where('hometeam.id',$id);
		 //$rss->or_where('DATE(rss_events.start_date) >=', $converted_date );
		// $rss->where('DATE(rss_events.start_date) <=', $session_date_tommorrow );
		//$rss->where('awayteam.id',$id);
		$rss->or_where('awayteam.id',$id);
		//$current_time = $this->session->userdata('time_timezone');
	//	$rss->where('rss_events.end_date >= ', $current_time );
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		$rss->limit(5);
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query2 = $rss->get('rss_events')->result_array();
		
		$new_array = array_merge($query,$query2);
		//echo "<pre>";print_r($new_array);exit;
		//echo "<pre>";print_r($query2);exit;
		return $new_array;
	}
	public function get_nation_events($nation,$sport = NULL){
		//echo $sport;exit;
		$new_nation = str_replace('-',' ',$nation);
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->where('DATE(rss_events.start_date) >=', $session_date_yesterday );
		$rss->where('DATE(rss_events.start_date) <', $converted_date );
		$rss->where('rss_events.nation =', $new_nation );
		if($sport){
			$rss->where('rss_sport_category.id =', $sport );
		}
		
		//$this->db->where('DATE(kt_events.start_date) <=',(date('Y-m-d', strtotime("2 day"))) ); //h:i:s for time as well.
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo $this->db->last_query();
		return $query;
	}
	public function get_competition_events($competition){
		$rss = $this->load->database('rss', TRUE);
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->where('rss_competition.competition_id',$competition);
		$rss->where('start_date <',$converted_datetime);
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		$rss->order_by('rss_events.start_date','desc');
		$rss->group_by('rss_events.id');
		$rss->limit(5);
		$query = $rss->get('rss_events')->result_array();
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->where('rss_competition.competition_id',$competition);
		$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
		$rss->where('DATE(rss_events.start_date) <',$converted_date );
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$rss->limit(5);
		$query2 = $rss->get('rss_events')->result_array();
		
		$new_array = array_merge($query,$query2);
		//echo "<pre>";print_r($new_array);exit;
		return $new_array;
	}
	public function get_myteam_events($id){
	//	echo "here";exit;
		$rss = $this->load->database('rss', TRUE);
		
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->where('rss_events.id',$id);
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}


	public function get_highlights($id){
		
		$rss = $this->load->database('rss', TRUE);
		
		$rss->join('rss_events','rss_events.id=rss_highlight.event_id_highlight');
		$rss->where('rss_highlight.status_raw','approved');
		$rss->where('rss_highlight.event_id_highlight',$id);
		$get_highlights = $rss->get('rss_highlight');
		
		$row_highlight['highlight_arr'] = $get_highlights->result_array();
		$row_highlight['highlight_count'] = $get_highlights->num_rows;
		//echo "<pre>"; print_r($row_highlight['highlight_arr']);exit;
		return $row_highlight;
	}
	public function get_my_games(){
		$this->db->where('sport_status','active');
		$query = $this->db->get('kt_sport_category')->result_array();
		
		return $query;
	}
	
	public function get_all_sports(){
		$rss = $this->load->database('rss', TRUE);
		$rss->where('sport_status','active');
		$rss->order_by('display_order','aesc');
		$get_sports = $rss->get('rss_sport_category');
		$row_sports['sports_arr'] = $get_sports->result_array();
		$row_sports['sports_count'] = $get_sports->num_rows;
		return $row_sports;
		
	}
	
	public function get_news(){
		$this->db->order_by('created_date','desc');
		$this->db->where('status','1');
		$query = $this->db->get('kt_news')->result_array();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function get_news1(){
		$this->db->limit(3);
		$this->db->order_by('created_date','desc');
		$this->db->where('status','1');
		$query = $this->db->get('kt_news')->result_array();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	 public function get_news_by_id($slug) {
        $this->db->where('slug_news', $slug);
        $result = $this->db->get('kt_news');
        return $result->result_array();
    }
	

    public function get_states() {
        $this->db->select("RegionID as id, Region as name");
        $query = $this->db->get('kt_state')->result_array();
        return $query;
    }

    public function get_header_menus() {
        $this->db->where('status', 1);
        $result = $this->db->get("kt_menus");
        return $result->result_array();
    }
	 // public function get_content() {
        // $result = $this->db->get("kt_home_section");
        // return $result->result_array();
    // }

    public function get_games() {
        $result = $this->db->get("kt_slider_images");
        return $result->result_array();
    }
    /*public function get_footer_events(){
		$this->db->select('kt_events.*, hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,kt_nation_custom_text.competition_name');	
		$this->db->limit(3);
		$this->db->join('kt_nation_custom_text','kt_nation_custom_text.competition_id=kt_events.competition_id');
		$this->db->join('kt_team as hometeam','hometeam.name=kt_events.home_team ','left');
		$this->db->join('kt_team as awayteam','awayteam.name=kt_events.away_team', 'left');
		$this->db->order_by('kt_events.date','desc');
		$this->db->group_by('kt_events.id');
		$query = $this->db->get('kt_events')->result_array();
		echo "<pre>";print_r($query);exit;
		return $query;
	}*/

    public function get_header_menus_data($menu_id) {
        $this->db->where('kt_pages.slug_menu', $menu_id);
        $this->db->join('kt_pages', 'kt_pages.slug_menu = kt_menus.slug_menu');

        $result = $this->db->get('kt_menus');
        return $result->result_array();
    }
    public function get_settings() {
        return $this->db->get('kt_setting')->result_array();
    }
	public function get_footer_content() {
        return $this->db->get('kt_footer_content')->result_array();
    }

    public function get_social_icons() {
        return $this->db->get('kt_social_icons')->result_array();
    }
	public function live_streaming(){
		$this->db->select('kt_channel.*,kt_channel_feeds.id As feedid,kt_channel_feeds.iframe_feeds');
		$this->db->where('channel_status','approved');
		$this->db->join('kt_channel_feeds','kt_channel_feeds.channel_id=kt_channel.id');
		$query = $this->db->get('kt_channel');
		return $query->result_array();
	}
	public function get_live_streaming($id){
		$this->db->select('kt_channel.*,kt_channel_feeds.id As feedid,kt_channel_feeds.iframe_feeds');
		$this->db->where('channel_status','approved');
		$this->db->where('kt_channel.id',$id);
		$this->db->join('kt_channel_feeds','kt_channel_feeds.channel_id=kt_channel.id');
		$query = $this->db->get('kt_channel');
		return $query->result_array();
	}
	public function get_alternate_streams_channel($channel_id){
		//echo $channel_id;
		$this->db->where('id',$channel_id);
		$query = $this->db->get('kt_channel_feeds')->result_array();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function get_live_streams_logo(){
		$this->db->select('id,logo');
		$query = $this->db->get('kt_channel')->result_array();
		return $query;
		
	}
	public function get_datepicker_events($date,$sport = NULL,$nation_calender_value = NULL,$nation_sport_id = NULL,$competition_calender_id = NULL,$team_id_for_calender = NULL){
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->where('DATE(rss_events.start_date) =', $date);
		//$this->db->where('DATE(kt_events.start_date) =',date('Y-m-d',$session_date));
		
		//$this->db->where('DATE(kt_events.start_date) <=',(date('Y-m-d', strtotime("0 day"))) ); //h:i:s for time as well.
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
	
		
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		if(!empty($sport)){
			//echo $sport;exit;
			$rss->where('rss_sport_category.id',$sport);
		}
		if(!empty($nation_sport_id)){
			$rss->where('rss_sport_category.id',$nation_sport_id);
		}
		if(!empty($nation_calender_value)){
			$rss->where('rss_events.nation',$nation_calender_value);
		}
		 if(!empty($competition_calender_id)){
			$rss->where('rss_competition.competition_id',$competition_calender_id);
		}
		if(!empty($team_id_for_calender)){
			
			$rss->where('hometeam.id',$team_id_for_calender);
			$rss->or_where('DATE(rss_events.start_date) =', $date );
			$rss->where('awayteam.id',$team_id_for_calender);
			
		}
		
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function meta_tags($nation = NULL,$competition_id = NULL){
		if($nation){
			$this->db->where('nation',$nation);
		$nation = $this->db->get('kt_nation_custom_text')->result_array();
		return $nation;
		}
		
	}
	public function meta_tags2($competition_id = NULL){
		if($competition_id){
			$this->db->where('competition_id',$competition_id);
		$competition = $this->db->get('kt_competition_custom_text')->result_array();
		return $competition;
		}
		
	}
	public function meta_tags3($team_id = NULL){
		if($team_id){
			$this->db->where('team_id',$team_id);
		$team = $this->db->get('kt_team_custom_text')->result_array();
		return $team;
		}
	}
	public function meta_tags4($sport_id = NULL){
		if($sport_id){
			$this->db->where('sport_id',$sport_id);
		$sport = $this->db->get('kt_sport_custom_text')->result_array();
		return $sport;
		}
		
	}
	public function meta_tags5($event_id = NULL){
		//echo $event_id;
		if($event_id){
			$this->db->where('event_id',$event_id);
		$event = $this->db->get('kt_event_custom_text')->result_array();
		return $event;
		}
		
	}
	public function meta_tags6(){
		//echo $event_id;
		$this->db->where('id',1);
		$event = $this->db->get('kt_highlight_custom_text')->result_array();
		//echo "<pre>";print_r($event);
		return $event;
	}

		public function meta_tags7($sport_id = NULL){
		if($sport_id){
			$this->db->where('sport_id',$sport_id);
		$sport = $this->db->get('kt_sports_highlights_custom_text')->result_array();
		return $sport;
		}
		
	}
	public function datepicker_nation_filter_results($datepick,$sport = null){
		
		$rss = $this->load->database('rss', TRUE);
		
		$rss->select('rss_events.nation');
		$rss->where('DATE(rss_events.start_date) =',$datepick);
		if($sport){
			$rss->where('rss_sport_category.id',$sport);
			$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id');
		}
		$rss->order_by('start_date','aesc');
		$rss->group_by('rss_events.nation');
		$nation = $rss->get('rss_events')->result_array();
		return $nation;
	}
	public function datepicker_sports_filter_results($datepick,$nation = null){
		
		$rss = $this->load->database('rss', TRUE);
		
		$rss->select('rss_sport_category.id,rss_sport_category.category_name');
		$rss->where('DATE(rss_events.start_date) =',$datepick);
		if($nation){
			$rss->where('rss_events.nation',$nation);
		}
		$rss->order_by('rss_events.start_date','aesc');
		$rss->join('rss_events','rss_events.sport_category_id=rss_sport_category.id');
		$rss->join('rss_competition','rss_competition.sport_cat_id=rss_sport_category.id');
		$rss->group_by('rss_sport_category.id');
		$sports = $rss->get('rss_sport_category')->result_array();
		return $sports;
	}
	public function datepicker_competitions_filter_results($datepick,$sport = null,$nation = null){
		
		$rss = $this->load->database('rss', TRUE);
		
		$rss->where('DATE(rss_events.start_date) =',$datepick );
		if($sport){
			$rss->where('rss_competition.sport_cat_id',$sport);
			$rss->join('rss_sport_category','rss_sport_category.id=rss_competition.sport_cat_id');
		}
		if($nation){
			$rss->where('rss_events.nation',$nation);
		}
		$rss->join('rss_events','rss_events.competition_id=rss_competition.competition_id');
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_competition.competition_id');
		$competition = $rss->get('rss_competition')->result_array();
		
		return $competition;
	}
	public function get_sport_competition_by_name($sport_id)
	{
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_sport_category.*,rss_competition.*');
		$rss->from('rss_sport_category');
		$rss->join('rss_competition','rss_competition.sport_cat_id=rss_sport_category.id');
		$rss->where('rss_sport_category.id',$sport_id);
		$rss->order_by('competition_name');
		//$rss->group_by('rss_competition.competition_name');
		$res=$rss->get()->result_array();
		//echo '<pre>';
		//print_r($res);exit;
		return $res;
	}

}

?>