<?php

class Index_model extends CI_Model {
	
	  public function __construct() {
        parent::__construct();
		$this->load->library('user_agent');
    }
    public function my_model_method()
	{
		
	  //$rss = $this->load->database('rss', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

	  $rss->select('competition_id, competition_name');
	  $query = $rss->get('rss_competition')->result_array();
	  echo "<pre>";print_r($query);exit;
	  var_dump($query);
	  
	}
	public function get_countries() {
        $this->db->select("CountryId as id, Country as name");
        $query = $this->db->get('kt_countries')->result_array();
        return $query;
    }

	public function get_events(){
		$rss = $this->load->database('rss', TRUE);
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time));
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		
		$rss->select('hometeam.team_slug,rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->where('DATE(rss_events.start_date) =', $converted_date );

		$rss->where('rss_events.end_date >= ', $converted_datetime );
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function get_last_events(){
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		//$session_date = $this->session->userdata('date_timezone');
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->where('DATE(rss_events.start_date) =', $session_date_tommorrow );
		//$this->db->where('DATE(kt_events.start_date) <=',(date('Y-m-d', strtotime("2 day"))) ); //h:i:s for time as well.
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		return $query;
	}
	public function get_events_old(){
		
		$session_date = $this->session->userdata('session_date');
		
		$datetime = new DateTime($session_date);
		$datetime->modify('+1 day');
		echo $session_date_tommorrow = $datetime->format('Y-m-d');
		
		$this->db->select('kt_events.*, hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,kt_nation_custom_text.competition_name,kt_sport_category.sport_logo,kt_sport_category.category_name');		
		$this->db->where('DATE(kt_events.start_date) >=',$session_date );
		$this->db->where('DATE(kt_events.start_date) <=',$session_date_tommorrow ); //h:i:s for time as well.
		$this->db->join('kt_nation_custom_text','kt_nation_custom_text.competition_id=kt_events.competition_id');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$this->db->join('kt_sport_category','kt_sport_category.id=kt_events.sport_category_id');
		$this->db->order_by('kt_events.start_date','desc');
		$this->db->group_by('kt_events.id');
		$query = $this->db->get('kt_events')->result_array();
		//echo $this->db->last_query();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	// If selected ALL Competitions from front!
	public function get_sport_competition_by_name($sport_id)
	{

		$rss = $this->load->database('rss', TRUE);
		$rss->_reserved_identifiers[] = 200;
		$rss->_reserved_identifiers[] = 201;
		$rss->_reserved_identifiers[] = 202;
		$rss->_reserved_identifiers[] = 203;
$rss->_reserved_identifiers[] = 204;
		$rss->select('rss_sport_category.*,rss_competition.*');
		$rss->from('rss_sport_category');
			if($sport_id == 16){
			
		$rss->join('rss_competition','rss_competition.sport_cat_id=200 OR rss_competition.sport_cat_id=201 OR rss_competition.sport_cat_id=202 OR rss_competition.sport_cat_id=202 OR rss_competition.sport_cat_id=203 OR rss_competition.sport_cat_id=204');
		}else{
		$rss->join('rss_competition','rss_competition.sport_cat_id=rss_sport_category.id');
	}
		
		if($sport_id == 16){
			$where = "(rss_sport_category.id =200 OR rss_sport_category.id =201 OR rss_sport_category.id =202 OR rss_sport_category.id =203 OR  rss_sport_category.id =204)";
		$rss->where($where);
		}else{
		$rss->where('rss_sport_category.id',$sport_id);
	}
		$rss->order_by('competition_name');
		//$rss->group_by('rss_competition.competition_name');
		$res=$rss->get()->result_array();
		//echo '<pre>';
	//print_r($res);exit;
		return $res;
	}
	public function get_sport_competition_by_nation($nation)
	{
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_competition.*');
		$rss->from('rss_competition');
		$rss->where('nation',strtolower($nation));
		$rss->group_by('competition_name');
		$res=$rss->get()->result_array();
		return $res;
	}
	public function get_sport_competition_by_nation_by_game($nation,$sport_id)
	{
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_competition.*');
		$rss->from('rss_competition');
		$rss->where('nation',strtolower($nation));
		$rss->where('sport_cat_id',$sport_id);
		$rss->group_by('competition_name');
		$res=$rss->get()->result_array();
		return $res;
	}
	public function ajax_events_competition_all($value){
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		

		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');

		if($value == 0){
			$rss->where('DATE(rss_events.start_date) =', $converted_date );
			$current_time = $this->session->userdata('time_timezone');
			$rss->where('rss_events.end_date >= ', $converted_datetime );
		} else if ($value == 1){
			
			$rss->where('DATE(rss_events.start_date) >=', $converted_date );
			$rss->where('DATE(rss_events.start_date) <=', $session_date_tommorrow );
		}
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
	//	echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function ajax_all_nations($value){

		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		
		if($value == 0){
			$rss->where('DATE(rss_events.start_date) =', $converted_date );

			$rss->where('rss_events.end_date >= ', $converted_datetime );
		} else if ($value == 1){
			$rss->where('DATE(rss_events.start_date) >=',$converted_date );
			$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );
			$current_time = $this->session->userdata('timetimezone');
			$rss->where('rss_events.end_date >= ', $converted_datetime );
		}
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function get_nation_ajax($nation,$value,$nation_sport_id = NULL,$datepicker = NULL){
		$datepick = date('Y-m-d',strtotime($datepicker));
		//echo $datepick;
		$rss = $this->load->database('rss', TRUE);
		
		$new_nation = str_replace('-',' ',$nation);
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');			
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		$rss->where('rss_events.nation',$new_nation);
		if($datepicker){
			$rss->where('DATE(rss_events.start_date) =',$datepick);
		} else {
			if($value == 0){
			
			$rss->where('DATE(rss_events.start_date) =',$converted_date );

			$rss->where('rss_events.end_date >= ', $converted_datetime );
			} else if ($value == 1){
				$rss->where('DATE(rss_events.start_date) >=',$converted_date );
				$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );
				$current_time = $this->session->userdata('time_timezone');
				$rss->where('rss_events.end_date >= ', $current_time );
			}
		}
		
		if($nation_sport_id){
			$rss->where('rss_sport_category.id',$nation_sport_id);
		}
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo $rss->last_query();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function get_nation_ajax2($nation,$value = NULL,$datepick = NULL){
		
		$rss = $this->load->database('rss', TRUE);
		$new_nation = str_replace('-',' ',$nation);
		$session_date = $this->session->userdata('date_timezone');
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		$rss->where('rss_events.nation',$new_nation);
		if($value == 0){
			
			$rss->where('DATE(rss_events.start_date) =',$converted_date );
			$current_time = $this->session->userdata('time_timezone');
			$rss->where('rss_events.end_date >= ', $converted_datetime );
		} else if ($value == 1){
			$rss->where('DATE(rss_events.start_date) >=',$converted_date );
			$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );
			$current_time = $this->session->userdata('session_date_time');
			$rss->where('rss_events.end_date >= ', $converted_datetime );
		}
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function get_nation_sports($nation,$value,$datepicker){
		$datepick = date('Y-m-d',strtotime($datepicker));
		$rss = $this->load->database('rss', TRUE);
		$new_nation = str_replace('-',' ',$nation);
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		$rss->where('rss_events.nation',$new_nation);
		if($datepicker){
			$rss->where('DATE(rss_events.start_date) =',$datepick );
		} else {
			if($value == 0){
			
			$rss->where('DATE(rss_events.start_date) =',$converted_date );
	
			$rss->where('rss_events.end_date >= ', $converted_datetime );
			} else if ($value == 1){
				$rss->where('DATE(rss_events.start_date) >=',$converted_date );
				$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );
				$current_time = $this->session->userdata('time_timezone');
				$rss->where('rss_events.end_date >= ', $current_time );
			}
		}
		
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function get_competition_nations($nation,$value,$nation_sport_id = NULL){
		$rss = $this->load->database('rss', TRUE);
		$new_nation = str_replace('-',' ',$nation);
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id AND rss_events.nation = hometeam.nation','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id AND rss_events.nation = awayteam.nation','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		
		$rss->where('rss_events.nation',$new_nation);
		if($nation_sport_id){
			$rss->where('rss_events.sport_category_id',$nation_sport_id);
		}
		if($value == 0){
			$rss->where('DATE(rss_events.start_date) =',$converted_date );
			
			$rss->where('rss_events.end_date >= ', $converted_datetime );
		} else{
			$rss->where('DATE(rss_events.start_date) >=',$converted_date );
			$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );
			$current_time = $this->session->userdata('time_timezone');
			$rss->where('rss_events.end_date >= ', $current_time );
		}
		
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo $this->db->last_query();exit;
		return $query;
	}
	public function get_nation_sports_competition($sport_id_changed){
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$this->db->select('kt_events.*, hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,kt_nation_custom_text.competition_name,kt_sport_category.category_name,kt_sport_category.sport_logo,kt_sport_category.category_name');			
		$this->db->join('kt_nation_custom_text','kt_nation_custom_text.competition_id=kt_events.competition_id');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id AND rss_events.nation = hometeam.nation','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id AND rss_events.nation = awayteam.nation','left');
		$this->db->join('kt_sport_category','kt_sport_category.id=kt_events.sport_category_id');
		$this->db->where('kt_sport_category.id',$sport_id_changed);
		$this->db->where('DATE(kt_events.start_date) >=',$converted_date );
		$this->db->where('DATE(kt_events.start_date) <=',$session_date_tommorrow );
		
		$rss->where('rss_events.end_date >= ', $converted_datetime );
		$this->db->order_by('kt_events.start_date','aesc');
		$this->db->group_by('kt_events.id');
		$query = $this->db->get('kt_events')->result_array();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	//when a competition name is selected from front!
	public function ajax_events_competition($competition,$value = null,$datepicker = null){
		$datepick = date('Y-m-d',strtotime($datepicker));
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->where('rss_competition.competition_id',$competition);
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		if($datepicker){
			$rss->where('DATE(rss_events.start_date) =', $datepick );
		} else {
			if($value == 0){
			$rss->where('DATE(rss_events.start_date) =', $converted_date );

			$rss->where('rss_events.end_date >= ', $converted_datetime );
		} else if ($value == 1){
			$rss->where('DATE(rss_events.start_date) >=', $converted_date );
			$rss->where('DATE(rss_events.start_date) <=', $session_date_tommorrow );

			$rss->where('rss_events.end_date >= ', $converted_datetime );
		}
		}
		
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo "<pre>";print_r($query);exit;
		return $query;
		
	}
	//when All sports is selcted from front.
	public function get_ajax_sports_empty($value){
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		
		if($value == 0){
			$rss->where('DATE(rss_events.start_date) =', $converted_date );

			$rss->where('rss_events.end_date >= ', $converted_datetime );
		} else{
			$rss->where('DATE(rss_events.start_date) >=', $converted_date );
			$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );

			$rss->where('rss_events.end_date >= ', $converted_datetime );
		}
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo "<pre>";print_r($query);exit;
		//echo $this->db->last_query();
		return $query;
	}
	public function get_ajax_sports($competition){
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		
		
		$this->db->select('kt_events.*, hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,kt_nation_custom_text.competition_name,kt_sport_category.sport_logo,kt_sport_category.category_name');			
		$this->db->join('kt_nation_custom_text','kt_nation_custom_text.competition_id=kt_events.competition_id');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$this->db->join('kt_sport_category','kt_sport_category.id=kt_events.sport_category_id');
		//$this->db->where('kt_sport_category.id',$sport);
		$this->db->where('kt_nation_custom_text.competition_id',$competition);
		$this->db->where('DATE(kt_events.start_date) >=',$converted_date );
		$this->db->where('DATE(kt_events.start_date) <=',$session_date_tommorrow );
	
		$rss->where('rss_events.end_date >= ', $converted_datetime );
		$this->db->order_by('kt_events.start_date','aesc');
		$this->db->group_by('kt_events.id');
		$query = $this->db->get('kt_events')->result_array();
		//echo $this->db->last_query();exit;
		return $query;
	}
	//when nation is slected and then sports or when single nation is changed
	public function ajax_nations_sports($sports_id,$nation,$value=null,$datepicker=null){
		$datepick = date('Y-m-d',strtotime($datepicker));
		$new_nation = str_replace('-',' ',$nation);
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		if($datepicker){
			$rss->where('DATE(rss_events.start_date) =', $datepick );
		}else {
			if($value == 0){
			$rss->where('DATE(rss_events.start_date) =', $converted_date );

			$rss->where('rss_events.end_date >= ', $converted_datetime );
		} else{
			$rss->where('DATE(rss_events.start_date) >=', $converted_date );
			$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );
	
			$rss->where('rss_events.end_date >= ', $converted_datetime );
		}
		}
		
		if($sports_id){
			$rss->where('rss_sport_category.id',$sports_id);
		}
		$rss->where('rss_events.nation =', $new_nation );
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo $this->db->last_query();
		return $query;
	}
	//When Sports Category is clicked from front!
	public function ajax_events_sports_empty($sports_id,$value = NULL,$datepicker = NULL){
		//echo $datepicker;
		$datepick = date('Y-m-d',strtotime($datepicker));
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		if($datepicker){
			$rss->where('DATE(rss_events.start_date) =', $datepick );
		} else {
			if($value == 0){
			$rss->where('DATE(rss_events.start_date) =', $converted_date );
			
			$rss->where('rss_events.end_date >= ', $converted_datetime );
		} else{
			$rss->where('DATE(rss_events.start_date) >=', $converted_date );
			$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );
	
			$rss->where('rss_events.end_date >= ', $converted_datetime );
		}
		}
		
		if($sports_id){
			$rss->where('rss_sport_category.id',$sports_id);
		}
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
		//echo $sport_id;exit;
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
//print_r($session_date_tommorrow) ;exit;
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		//$rss->where('DATE(rss_events.start_date) =', $converted_date );
	
		$rss->where('rss_events.end_date >= ', $converted_datetime );
		$rss->where('DATE(rss_events.start_date) <=', $session_date_tommorrow );
		if($sport_id == 16){
			$where = "(rss_sport_category.id =200 OR rss_sport_category.id =201 OR rss_sport_category.id =202 OR rss_sport_category.id =203 OR  rss_sport_category.id =204)";
		$rss->where($where);
		}else{
			$rss->where('rss_sport_category.id',$sport_id);
		}
		
		//$this->db->where('DATE(kt_events.start_date) <=',(date('Y-m-d', strtotime("2 day"))) ); //h:i:s for time as well.
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
	//	$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		
		$rss->order_by('rss_events.start_date','asc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo $rss->last_query();
		//echo "<pre>";print_r($query);exit;
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
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->where('rss_competition.competition_id',$competition);
		//$rss->where('start_date =', $converted_date );
		$rss->where('start_date <=', $session_date_tommorrow );
		$rss->where('end_date >= ', $converted_datetime );
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id ','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		$rss->order_by('start_date','asc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
	
	
		//echo "<pre>";print_r($query);exit;
		return $query;
	}

	public function get_last_competition_events($competition){
		$rss = $this->load->database('rss', TRUE);
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->where('rss_competition.competition_id',$competition);
		$rss->where('start_date <', $converted_date );
		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		$rss->order_by('rss_events.start_date','desc');
		$rss->group_by('rss_events.id');
		$rss->limit(5);
		$query = $rss->get('rss_events')->result_array();
	
	
		//echo "<pre>";print_r($new_array);exit;
		return $query;
	}


	public function get_future_competition_events($competition){
		$rss = $this->load->database('rss', TRUE);
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->where('rss_competition.competition_id',$competition);
		$rss->where('start_date >', $converted_date );
		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		$rss->order_by('rss_events.start_date','desc');
		$rss->group_by('rss_events.id');
		$rss->limit(5);
		$query = $rss->get('rss_events')->result_array();
	
	
		//echo "<pre>";print_r($new_array);exit;
		return $query;
	}
	public function get_team_events($id){
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		
		$converted_datetime = gmdate('Y-m-d H:i:s');
		
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
				$rss->where('start_date >=', $converted_date );
		$rss->where('start_date <=', $session_date_tommorrow );
		$rss->where('end_date >= ', $converted_datetime );
		
		$rss->where('hometeam.id',$id);
		
		$rss->or_where('start_date ',$converted_datetime);
		$rss->where('awayteam.id',$id);
		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->limit(5);
		$rss->order_by('rss_events.start_date','asc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		
		//echo "<pre>";print_r($query);exit;

		//echo "<pre>";print_r($new_array);exit;
		//echo "<pre>";print_r($query2);exit;
		return $query;
	}
	public function get_last_team_events($id){
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		
		$converted_datetime = gmdate('Y-m-d H:i:s');
		
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
				$rss->where('rss_events.start_date <', $converted_date );
	
		
		$rss->where('hometeam.id',$id);
		
		$rss->or_where('start_date ',$converted_datetime);
		$rss->where('awayteam.id',$id);
		
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		$rss->limit(5);
		$rss->order_by('rss_events.start_date','desc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		
		//echo "<pre>";print_r($query);exit;

		//echo "<pre>";print_r($new_array);exit;
		//echo "<pre>";print_r($query2);exit;
		return $query;
	}

	public function get_team_from_view_events($event_id = NULL){
		
	
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->where('rss_events.id',$event_id);
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		$rss->limit(5);
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function get_nation_events($nation,$sports_id){
		$new_nation = str_replace('-',' ',$nation);
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->where('DATE(rss_events.start_date) =', $converted_date );
		//$rss->where('DATE(rss_events.start_date) <=', $session_date_tommorrow );
		
		//$rss->where('rss_events.end_date >= ', $converted_datetime );
		$rss->where('rss_events.nation =', $new_nation );
		if($sports_id){
			$rss->where('rss_sport_category.id',$sports_id);
		}
		//$this->db->where('DATE(kt_events.start_date) <=',(date('Y-m-d', strtotime("2 day"))) ); //h:i:s for time as well.
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		
		$rss->order_by('rss_events.start_date','asc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo $this->db->last_query();
		return $query;
	}

		public function get_last_nation_events($nation,$sports_id){
		$new_nation = str_replace('-',' ',$nation);
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		

		
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->where('DATE(rss_events.start_date) <', $converted_date );
		
		
		
		$rss->where('rss_events.nation =', $new_nation );
		if($sports_id){
			$rss->where('rss_sport_category.id',$sports_id);
		}
		//$this->db->where('DATE(kt_events.start_date) <=',(date('Y-m-d', strtotime("2 day"))) ); //h:i:s for time as well.
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		$rss->limit(5);
		$rss->order_by('rss_events.start_date','desc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
		//echo $this->db->last_query();
		//print_r($query); exit;
		return $query;
	}
	
	public function get_myteam_events($id){
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
	public function get_streams($id){
		$rss = $this->load->database('rss', TRUE);
		//echo $ip;exit;
		$ip = $_SERVER['REMOTE_ADDR'];	
		$rss->select('rss_streams.*,rss_stream_rating.ip_address');
		$rss->join('rss_events','rss_events.id=rss_streams.event_id_stream');
		$rss->join('rss_stream_rating','rss_stream_rating.stream_id=rss_streams.id AND rss_stream_rating.ip_address = "'.$ip.'"','left');
		$rss->where('rss_streams.event_id_stream',$id);
		$rss->where('rss_streams.type !=','p2p');
		$rss->where('rss_streams.type !=','sopcast');
		$rss->where('rss_streams.type !=','acestream');
		$rss->where('stream_status','approved');
		if ($this->agent->is_mobile()){
			$rss->where('rss_streams.compatibility','Yes');
		}
		$rss->order_by('rss_streams.sponsered','desc');
		$rss->order_by('rss_streams.stream_rating','desc');
		$rss->group_by('rss_streams.id');
		
		$stream = $rss->get('rss_streams')->result_array();
		//echo "<pre>";print_r($stream->result_array());exit;
		return $stream;
	}
	public function get_streams_p2p($id){
		$rss = $this->load->database('rss', TRUE);
		$ip = $_SERVER['REMOTE_ADDR'];	
		$rss->select('rss_streams.*,rss_stream_rating.ip_address');
		$rss->join('rss_events','rss_events.id=rss_streams.event_id_stream');
		$rss->join('rss_stream_rating','rss_stream_rating.stream_id=rss_streams.id AND rss_stream_rating.ip_address = "'.$ip.'"','left');
		
		
		
		$rss->where('rss_streams.event_id_stream',$id);
		$rss->where('rss_streams.type','p2p');
		$rss->where('stream_status','approved');
		if ($this->agent->is_mobile()){
			$rss->where('rss_streams.compatibility','Yes');
		}
		
		$rss->or_where('rss_streams.event_id_stream',$id);
		$rss->where('rss_streams.type','acestream');
		$rss->where('stream_status','approved');
		if ($this->agent->is_mobile()){
			$rss->where('rss_streams.compatibility','Yes');
		}
		
		$rss->or_where('rss_streams.event_id_stream',$id);
		$rss->where('rss_streams.type','sopcast');
		$rss->where('stream_status','approved');
		if ($this->agent->is_mobile()){
			$rss->where('rss_streams.compatibility','Yes');
		}
		

		$rss->order_by('rss_streams.sponsered','desc');
		$rss->order_by('rss_streams.stream_rating','desc');
		$rss->group_by('rss_streams.id');
		$p2p = $rss->get('rss_streams')->result_array();
		// echo $rss->last_query();
		// echo "<pre>";print_r($p2p);exit;
		return $p2p;
	}

	function get_sponsored_streams($id){
		$rss = $this->load->database('rss', TRUE);
		$rss->select('competition_id');
		$rss->where('id',$id);
		$rss->where('id',$id);
		$competition_id = $rss->get('rss_events')->result_array();
		
		$this->db->where('comp_id', $competition_id[0]['competition_id']);
		$this->db->order_by('id','desc');
		$query =$this->db->get('kt_ads_stream')->result_array();
		return $query;
	}
	
	public function get_highlights($id){
		//echo $id;
		$this->db->join('kt_events','kt_events.id=kt_highlight.event_id');
		$this->db->where('kt_highlight.status','approved');
		$this->db->where('kt_highlight.event_id',$id);
		$get_highlights = $this->db->get('kt_highlight');
		$row_highlight['highlight_arr'] = $get_highlights->result_array();
		$row_highlight['highlight_count'] = $get_highlights->num_rows;
		///echo "<pre>"; print_r($row_highlight['highlight_count']);exit;
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
		//echo "<pre>";print_r($query);exit;
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
	public function get_events_live_filter(){
		//where condition is changed with respect to other!

		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) );
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		$rss->where('rss_events.start_date <=', $converted_datetime );
		$rss->where('rss_events.end_date >=', $converted_datetime );
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		//$rss->join('rss_countries','rss_countries.id=rss_competition.country_id','left');
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_events.id');
		$query = $rss->get('rss_events')->result_array();
	//	echo $this->db->last_query();
		return $query;
	}
	
		
	public function get_datepicker_events($date,$sport = NULL,$nation_calender_value = NULL,$nation_sport_id = NULL,$competition_calender_id = NULL,$team_id_for_calender = NULL){
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_events.*,hometeam.logo as home_team_logo, awayteam.logo as away_team_logo,hometeam.id as home_team_id,awayteam.id as away_team_id,rss_competition.competition_name,rss_competition.comp_logo,rss_sport_category.sport_logo,rss_sport_category.category_name');
		
		$rss->where('DATE(rss_events.start_date) =', $date);
		//$this->db->where('DATE(kt_events.start_date) =',date('Y-m-d',$session_date));
		
		//$this->db->where('DATE(kt_events.start_date) <=',(date('Y-m-d', strtotime("0 day"))) ); //h:i:s for time as well.
		$rss->join('rss_competition','rss_competition.competition_id=rss_events.competition_id','left');
		$rss->join('rss_team as hometeam','hometeam.name=rss_events.home_team AND rss_events.sport_category_id = hometeam.sport_cat_id AND hometeam.id=rss_events.home_team_id','left');
		$rss->join('rss_team as awayteam','awayteam.name=rss_events.away_team AND rss_events.sport_category_id = awayteam.sport_cat_id AND awayteam.id=rss_events.away_team_id','left');
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id','left');
		
		//$rss->where('rss_events.sport_category_id','hometeam.sport_cat_id');
		
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
		$query = $rss->get('rss_events')->result_array();
		//echo $rss->last_query();
	//	echo "<pre>";print_r($query);exit;
		return $query;
	}
	public function golf_leadersboard(){
		$rss = $this->load->database('rss', TRUE);

		$rss->select('rss_golf_leaderboards.*,rss_tournaments_and_races.name,rss_tournaments_and_races.country,rss_tournaments_and_races.sport_name,rss_tournaments_and_races.start_date,rss_tournaments_and_races.end_date');

		$rss->join('rss_tournaments_and_races','rss_tournaments_and_races.id = rss_golf_leaderboards.tournament_id');	

		$golf = $rss->get('rss_golf_leaderboards')->result_array();
		return $golf;
	}
	public function motorsport_results(){
		$rss = $this->load->database('rss', TRUE);

		$rss->select('rss_motorsport_results.*,rss_tournaments_and_races.name,rss_tournaments_and_races.country,rss_tournaments_and_races.sport_name,rss_tournaments_and_races.start_date,rss_tournaments_and_races.end_date');
		$rss->join('rss_tournaments_and_races','rss_tournaments_and_races.id = rss_motorsport_results.race_id');
		$motor = $rss->get('rss_motorsport_results')->result_array();
		return $motor;
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
	public function meta_tags5(){
		//echo $event_id;
		$this->db->where('id',1);
		$event = $this->db->get('kt_event_custom_text')->result_array();
		return $event;
		
		
	}
	public function meta_tags6(){
		//echo $event_id;
		$this->db->where('id',1);
		$event = $this->db->get('kt_highlight_custom_text')->result_array();
		//echo "<pre>";print_r($event);
		return $event;
	}
	public function meta_tags7(){
		
		$this->db->where('id',1);
		$event = $this->db->get('kt_home_custom_text')->result_array();
		return $event;
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
}

?>
