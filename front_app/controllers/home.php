<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->load->model("index_model/index_model");
        $this->load->model("profile/chats");
		$this->load->library('image_lib');
        $this->load->helpers("captcha_helper");
		$this->load->library('user_agent');
    }

    public function index($para = NULL) {
			
			
			$my_ip  = $_SERVER['REMOTE_ADDR'];
			if($my_ip){
				
			$this->db->where('user_ip',$my_ip);
			$get_color_count = $this->db->get('kt_color')->num_rows();
			
			$this->db->where('user_ip',$my_ip);
			$get_color = $this->db->get('kt_color')->result_array();
			}
			
			if($get_color_count < 1) {
				$this->db->where('admin','1');
				$get_default = $this->db->get('kt_color')->result_array();
				$default = $get_default[0]['color'];
				if($get_default){
					$my_color = $default;
				} 
			} else {
				
				
				$my_color = $get_color[0]['color'];
			}

			$this->session->set_userdata('session_color',$my_color);
			
			if(!$this->session->userdata('time_formate')){
				$this->load->view('get_date');
				
			} else {
				
			 if ($this->session->userdata('front_user_id') == '') {
            $url = site_url("home");
            $this->data['settings'] = $this->index_model->get_settings();
            $this->data['social_icons'] = $this->index_model->get_social_icons();
            $this->data['get_my_header'] = $this->index_model->get_header_menus();
            $this->data['games'] = $this->index_model->get_games();

			$this->data['games'] = $this->index_model->get_my_games();
			$this->data['news1'] = $this->index_model->get_news1();
			$this->data['footer'] = $this->index_model->get_footer_content();
			//$this->data['footer_events'] = $this->index_model->get_footer_events();
			$this->data['get_sport_events'] = $this->index_model->get_sport_events($sports_id);
			
			$get_sports = $this->index_model->get_all_sports();
			$this->data['sports_arr'] = $get_sports['sports_arr'];
			$this->data['sports_count'] = $get_sports['sports_count'];
			
			$keyword = $this->db->get('kt_keyword')->result_array();
			$this->data['meta_keyword'] = '<META name="keywords" content="'.$keyword[0]['keyword'].'">';
			$this->data['my_ip'] = $my_ip;
			
			 $this->data['events'] = $this->index_model->get_events();
			 
			// Meta TAgs
		//echo $competition_id;exit;
		$meta_tag = $this->index_model->meta_tags7();
		//echo "<pre>";print_r($meta_tag);exit;
		$this->data['meta_title'] = $meta_tag[0]['title'];;
		
		$this->data['meta_description'] = '<meta name="description" content="'.$meta_tag[0]['description'].'">';
		
		$this->data['competition_id']=$competition_id;
		$this->data['meta_keyword'] = '<META name="keywords" content="'.$meta_tag[0]['keywords'].'">';
		$this->data['meta_article'] = $meta_tag[0]['article'];
		//End Of MEta TAgss
		
		
            $this->load->view('index', $this->data);
        } else {
            redirect('home/dashboard');
			} 
			}
		
		
		//$this->load->driver('cache', array('adapter' => 'xcache'));

//$this->cache->save('my_variable', array(0=>'data', 1=>'other data'));

//echo ($this->cache->get('my_variable'));exit;
//if ( ! $foo = $this->cache->get('foo'))
//{
       // echo 'Saving to the cache!<br />';
       // $foo = 'foobarbaz!';

        // Save into the cache for 5 minutes
       // $this->cache->save('foo', $foo, 300);
//}

//echo $foo.'<br>';
//var_dump($this->cache->cache_info());
       
    }
	public function get_date_by_timezone(){
		//echo "here";exit;
		$session_date = date("M d Y H:i:s"); //Get start date here
		$timezone = $this->input->post('timezone'); // Get time zone
		$this->session->set_userdata('time_formate',$timezone); //Storing time zone in session
		if($stored_timezone){
		echo $stored_timezone = $this->session->userdata('time_formate'); // To display stored session
		}
		//to get time zone in Y-m-d H:i:s
		$timezone_date_time = date("Y-m-d H:i:s", strtotime($session_date));

		//To get timezone in Date format
		$timezone_date = date('Y-m-d',strtotime($timezone_date_time));
		
		// Setting Up Sessions......
		$this->session->set_userdata('time_timezone',$timezone_date_time);
		$this->session->set_userdata('date_timezone',$timezone_date);

		//Echoing Sessions.
		//echo $time_timezone = $this->session->userdata('time_timezone');
		//echo $time_timezone_date = $this->session->userdata('date_timezone');

	}
	public function set_time_in_session()
	{
		$time_formate=$this->input->post('hour');
		$this->session->set_userdata('time_formate',$time_formate);
	}
	public function change_event_highlight(){
		$highlight_sport_id = $this->input->post('sport_id');
		$stream_sport_id = $this->input->post('sport_id_stream');
		$rss = $this->load->database('rss', TRUE);
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) - ($my_timezone * 60 * 60));
		//$converted_datetime = date('Y-m-d H:i:s', $date_time);
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		if($highlight_sport_id){
			$datetime = new DateTime($converted_datetime);
			$datetime->modify('-2 day');
			$session_date_yesterday = $datetime->format('Y-m-d H:i:s');
			$session_time = $this->session->userdata('my_timezone');
			
			$rss->where('sport_category_id',$highlight_sport_id);
			$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
			$rss->where('rss_events.start_date <',$converted_datetime ); //h:i:s for time as well.
			$rss->order_by('rss_events.start_date','aesc');
			$query=$rss->get('rss_events')->result_array();
		
		} else if($stream_sport_id){
			$datetime = new DateTime($converted_datetime);
			$datetime->modify('+1 day');
			$session_date_yesterday = $datetime->format('Y-m-d H:i:s');
			$session_time = $this->session->userdata('my_timezone');
			
			$rss->where('sport_category_id',$stream_sport_id);
			
			$rss->where('rss_events.start_date >=',$converted_datetime );
			$rss->where('rss_events.start_date <=',$session_date_yesterday );
			 //h:i:s for time as well.
			$rss->order_by('rss_events.start_date','aesc');
			$query=$rss->get('rss_events')->result_array();
		}
		 
		
		//echo $rss->last_query();
		//echo "<pre>";print_r($query);
		foreach($query as $event){ ?>
			<option value="<?php echo $event['id']; ?>" id="<?php $event['id']; ?>" >
			<?php echo date('G:i', (strtotime($event['start_date'])));?> /
			<?php echo $event['home_team'].' vs '.$event['away_team']; ?></option>
		<?php }
		
	}
	public function get_last_events(){
		$new_session_time= $this->session->userdata('time_formate') * 60 * 60;
		$current_date = gmdate('Y-m-d H:i:s');
		
		$rss = $this->load->database('rss', TRUE);
		$events = $this->index_model->get_last_events();
		if(!empty($events)) {
			foreach($events as $event){ ?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
				<td class="brdr-right">
					<div class="event-data ">
						<div class="text-left">
							<img  class="team-img-bg <?php echo $this->session->userdata('session_color');?>-team-img-bg" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo $event['sport_logo'];?>">
						</div>
						<!--
						<div class="col-xs-9 text-left sports-name">
							<p><?php //echo $event['category_name'] ?></p><!--<a href="#">Live</a>
						</div>
						-->
					</div>
				</td>
				<td class="brdr-right">
					<div class="date-data">
						<div id="data_<?php echo $event['id'] ?>" class="date-circle <?php echo $this->session->userdata('session_color');?>-date-circle">	<?php echo  date("j", (strtotime($event['start_date'])));?>
							 <?php echo date('M', (strtotime($event['start_date'])));?>
						</div>
						<div class="time-content">
							<?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?>
							
							<span class="match_time" style="color:red; font-size:12px;"  
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?> " 
								data-id="<?php echo $event['id'] ?>">
								<?php echo date('H:i', (strtotime($event['start_date'])+$new_session_time));?>
							</span>
							<?php } else { ?>
							<span class="match_time"
							data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
							data-month="<?php echo date('m', strtotime($event['start_date']));?>"
							data-day="<?php echo date('d', strtotime($event['start_date']));?>"
							data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
							data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
							data-secound="<?php echo date('s', strtotime($event['start_date']));?>"
							data-id="<?php echo $event['id'] ?>"
							><?php echo  date('H:i', (strtotime($event['start_date'])+ $new_session_time));?>
							</span><?php } ?>
						</div>
					</div>
				</td>
				<td class="brdr-right">
					<div class="event-data eventdata-main" style="text-align:center">
						<span class="cont-flag">
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/<?php echo ucwords($nation).'.png';?>" alt="">
						</span>

						<span>
						<a href="<?php echo base_url();?>nations/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?>">
								<?php
								if(strlen($event['nation'])>25) {
								echo ucwords(substr($event['nation'],0,25)).'..';
								}
								else if(strlen($event['nation']) == 3){
									echo ucwords(strtoupper($event['nation']));
								} else {
									echo ucwords(strtolower($event['nation']));
								}
								?> 
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else if($event['comp_logo'] == '' ){?> <img src=" images/competitions/default.png" alt=""> <?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>competitions/<?php echo $event['competition_id'];?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?> ">
								<?php
								if($event['category_name']== "Tennis" || $event['category_name']== "Golf" || $event['category_name']== "MotorSports"){
									
									if(strpos($event['competition_name'], ',')){
										$name=explode(',',ucwords(strtolower($event['competition_name'])));
										echo ucwords(strtolower($name[1]));
									} else {
										echo ucwords(strtolower($event['competition_name']));
									}
									
									
								}else{
								if(strlen($event['competition_name'])>25) {
									echo ucwords(substr($event['competition_name'],0,25)).'..';
								}
								else if(strlen($event['competition_name']) == 3){
									echo ucwords(strtoupper($event['competition_name']));
								} else {
									echo ucwords(strtolower($event['competition_name']));
								}
								}
								?> 
							</span>
						</a>
					</span>	
				</td>
			`	<td colspan="2" class="brdr-right">
					<div class="">
						<div class="<?php if($event['away_team']) {?>col-sm-5 no-pad tablet-data1 dev-float-left<?php } else {?>col-sm-12 no-pad  tablet-data1 dev-float-left<?php } ?>">
							<di		<span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['home_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
									<?php } else if($event['home_team_logo'] == '' || $event['home_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
									
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">
									<?php
										echo ucwords($event['home_team']);
									?> 
									</a>
								</span> <?php $status = explode('-',$event['events_status']); ?>
							</div>
						</div>
						<?php  
						if($event['away_team']) {?>
						
						<div class="col-sm-1 hidden-xs no-pad  tablet-data1 text-center-event">
							<div class="vs-match">VS</div>
							<div class="result-outer">
							<span class="score1"> <?php if($status[0] == '') { echo "-"; } else { echo $status[0]; }  ?> </span> &nbsp;:&nbsp;
							<span class="score2"> <?php if($status[1] == '') { echo "-"; } else { echo $status[1]; }  ?> </span>
							</div>
						</div>
						<div class="col-sm-5 no-pad tablet-data1 dev-float-right text-right">
							<div class="team-data2">
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['away_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['away_team']));?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                                      <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
								<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['away_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
								<?php } else if($event['away_team_logo'] == '' || $event['away_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
																		<?php } else { ?>
									<img src="<?php echo $event['away_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
							</div>
						</div>
                        <?php } ?>
					</div>
				</td>
				<td style="vertical-align: middle;">
				 
				<?php if(date('Y-m-d H:i:s', (strtotime($event['end_date']))) < $current_date){ ?>
				
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">Highlight</a>
					</div>
					
				<?php } else { ?>
					<div class="view-event <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) { } else { ?> <?php echo $this->session->userdata('session_color').'-view-event'; } ?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>watch/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Event</a>
					</div>
				<?php } ?>
				</td>
				<td style="display:none"></td>
				
			</tr>
			<?php
			}
		}
	}
	
	public function ajax_nation_competition(){
		$new_session_time= $this->session->userdata('time_formate') * 60 * 60;
		$current_date = gmdate('Y-m-d H:i:s');
		
		$rss = $this->load->database('rss', TRUE);
		$session_date = $this->session->userdata('date_timezone');
		
		$datetime = new DateTime($session_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		$nation_sport_id = $this->input->post('nation_sport_id');
		
		
		$c_nation = $this->input->post('c_nation');
		$value = $this->input->post('value');
		if($c_nation == ''){?>
			<div class="competition_id" id="competition_id" style="display:none;">
				<?php
				$rss = $this->load->database('rss', TRUE);
				$rss->select('rss_competition.competition_id,rss_competition.competition_name');
				if($value == 0){
					$rss->where('DATE(rss_events.start_date) =',$session_date );
				} else{
					$rss->where('DATE(rss_events.start_date) >=',$session_date );
					$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );
				}
				if($nation_sport_id){
					$rss->where('rss_competition.sport_cat_id',$nation_sport_id);
					$rss->join('rss_sport_category','rss_sport_category.id=rss_competition.sport_cat_id');
				}
				
				$rss->join('rss_events','rss_events.competition_id=rss_competition.competition_id');
				$rss->order_by('rss_events.start_date','aesc');
				$rss->group_by('rss_competition.competition_id');
				$competition = $rss->get('rss_competition')->result_array();
				//echo $this->db->last_query();
				?>
				<select name="my_competition" id="my_competition" >
					<option value="">All Competitions</option>
					<?php foreach($competition as $name){?>
					<option value="<?php echo $name['competition_id'];?>"><?php echo ucwords(strtolower($name['competition_name']));?></option>
					
					<?php } ?>
				</select> 
			</div>
		
			<?php $events = $this->index_model->ajax_all_nations($value);
			foreach($events as $event){ ?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
				<td class="brdr-right">
					<div class="event-data ">
						<div class="text-left">
							<img  class="team-img-bg <?php echo $this->session->userdata('session_color');?>-team-img-bg" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo $event['sport_logo'];?>">
						</div>
						<!--
						<div class="col-xs-9 text-left sports-name">
							<p><?php //echo $event['category_name'] ?></p><!--<a href="#">Live</a>
						</div>
						-->
					</div>
				</td>
				<td class="brdr-right">
					<div class="date-data">
						<div id="data_<?php echo $event['id'] ?>" class="date-circle <?php echo $this->session->userdata('session_color');?>-date-circle">	<?php echo  date("j", (strtotime($event['start_date'])));?>
							 <?php echo date('M', (strtotime($event['start_date'])));?>
						</div>
						<div class="time-content">
							<?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?>
							
							<span class="match_time" style="color:red; font-size:12px;"  
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?> " 
								data-id="<?php echo $event['id'] ?>">
								<?php echo date('H:i', (strtotime($event['start_date'])+$new_session_time));?>
							</span>
							<?php } else { ?>
							<span class="match_time"
							data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
							data-month="<?php echo date('m', strtotime($event['start_date']));?>"
							data-day="<?php echo date('d', strtotime($event['start_date']));?>"
							data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
							data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
							data-secound="<?php echo date('s', strtotime($event['start_date']));?>"
							data-id="<?php echo $event['id'] ?>"
							><?php echo  date('H:i', (strtotime($event['start_date'])+ $new_session_time));?>
							</span><?php } ?>
						</div>
					</div>
				</td>
				<td class="brdr-right">
					<div class="event-data eventdata-main" style="text-align:center">
						<span class="cont-flag">
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/<?php echo ucwords($nation).'.png';?>" alt="">
						</span>

						<span>
						<a href="<?php echo base_url();?>nations/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?>">
								<?php
								if(strlen($event['nation'])>25) {
								echo ucwords(substr($event['nation'],0,25)).'..';
								}
								else if(strlen($event['nation']) == 3){
									echo ucwords(strtoupper($event['nation']));
								} else {
									echo ucwords(strtolower($event['nation']));
								}
								?> 
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else if($event['comp_logo'] == '' ){?> <img src=" images/competitions/default.png" alt=""> <?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>competitions/<?php echo $event['competition_id'];?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?> ">
								<?php
								if($event['category_name']== "Tennis" || $event['category_name']== "Golf" || $event['category_name']== "MotorSports"){
									
									if(strpos($event['competition_name'], ',')){
										$name=explode(',',ucwords(strtolower($event['competition_name'])));
										echo ucwords(strtolower($name[1]));
									} else {
										echo ucwords(strtolower($event['competition_name']));
									}
									
									
								}else{
								if(strlen($event['competition_name'])>25) {
									echo ucwords(substr($event['competition_name'],0,25)).'..';
								}
								else if(strlen($event['competition_name']) == 3){
									echo ucwords(strtoupper($event['competition_name']));
								} else {
									echo ucwords(strtolower($event['competition_name']));
								}
								}
								?> 
							</span>
						</a>
					</span>	
				</td>
				<td colspan="2" class="brdr-right">
					<div class="">
						<div class="<?php if($event['away_team']) {?>col-sm-5 no-pad tablet-data1 dev-float-left<?php } else {?>col-sm-12 no-pad  tablet-data1 dev-float-left<?php } ?>">
							<div class="team-data1">
								<span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['home_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
									<?php } else if($event['home_team_logo'] == '' || $event['home_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
									
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">
									<?php
										echo ucwords($event['home_team']);
									?> 
									</a>
								</span> <?php $status = explode('-',$event['events_status']); ?>
							</div>
						</div>
						<?php  
						if($event['away_team']) {?>
						
						<div class="col-sm-1 hidden-xs no-pad  tablet-data1 text-center-event">
							<div class="vs-match">VS</div>
							<div class="result-outer">
							<span class="score1"> <?php if($status[0] == '') { echo "-"; } else { echo $status[0]; }  ?> </span> &nbsp;:&nbsp;
							<span class="score2"> <?php if($status[1] == '') { echo "-"; } else { echo $status[1]; }  ?> </span>
							</div>
						</div>
						<div class="col-sm-5 no-pad tablet-data1 dev-float-right text-right">
							<div class="team-data2">
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['away_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['away_team']));?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                              <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
								<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['away_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
								<?php } else if($event['away_team_logo'] == '' || $event['away_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
																		<?php } else { ?>
									<img src="<?php echo $event['away_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
							</div>
						</div>
                        <?php } ?>
					</div>
				</td>
				<td style="vertical-align: middle;">
				<?php if(date('Y-m-d H:i:s', (strtotime($event['end_date']))) < $current_date){ ?>
				
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">Highlight</a>
					</div>
					
				<?php } else { ?>
					<div class="view-event <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) { } else { ?> <?php echo $this->session->userdata('session_color').'-view-event'; } ?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>watch/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Event</a>
					</div>
				<?php } ?>
				</td>
				<td style="display:none"></td>
				
			</tr>
			<?php
			}
		} 
		else {
		$nation = $this->input->post('c_nation');
		//echo $value;
		
		$events2 = $this->index_model->get_competition_nations($nation,$value,$nation_sport_id);
		//echo "<pre>"; print_r($events2);exit;
		?>
		<div class="competetition" id="competition" style="display:none;">
		<?php
		$exist = array();
		//when sports get selected on competition change.
		if($nation_sport_id) { echo "<option id='competition_id' value='' disabled>Competitions</option>"; } else { 
			echo "<option id='competition_id' value=''>All Competitions</option>";
		}
		foreach($events2 as $myevent) {
			//Do Not Repeat if same Sport id exists in array more then once
				if(!in_array($myevent['competition_id'], $exist, TRUE)){ 
				echo "<option id='competition_id' class='view' value='".$myevent['competition_id']."'>".ucwords(strtolower($myevent['competition_name']))."</option>";
				$exist[] = $myevent['competition_id'];
			}
		
		 }//end of foreach loop
		 exit; ?>
		</div>
		<?php
		//$sport_id_changed = $events2[0]['sport_category_id'];
		//if($sport_id_changed){
		//	$nation = $this->input->post('nation_id');
			////$events = $this->index_model->get_nation_sports_competition($sport_id_changed);
			//echo "<pre>"; print_r($events);
		//}
		
		
		$events = $this->index_model->get_nation_ajax2($nation_id,$value);
		foreach($events as $event){ ?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
				<td class="brdr-right">
					<div class="event-data ">
						<div class="text-left">
							<img  class="team-img-bg <?php echo $this->session->userdata('session_color');?>-team-img-bg" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo $event['sport_logo'];?>">
						</div>
						<!--
						<div class="col-xs-9 text-left sports-name">
							<p><?php //echo $event['category_name'] ?></p><!--<a href="#">Live</a>
						</div>
						-->
					</div>
				</td>
				<td class="brdr-right">
					<div class="date-data">
					
						<div id="data_<?php echo $event['id'] ?>" class="date-circle <?php echo $this->session->userdata('session_color');?>-date-circle">	<?php echo  date("j", (strtotime($event['start_date'])));?>
							 <?php echo date('M', (strtotime($event['start_date'])));?>
						</div>
						 
						<div class="time-content">
							<?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?>
							
							<span class="match_time" style="color:red; font-size:12px;"  
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?> " 
								data-id="<?php echo $event['id'] ?>">
								<?php echo date('H:i', (strtotime($event['start_date'])+$new_session_time));?>
								</span>
								<?php } else { ?>
								<span class="match_time"
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?>"
								data-id="<?php echo $event['id'] ?>"
								><?php echo  date('H:i', (strtotime($event['start_date'])+ $new_session_time));?></span><?php } ?>
						</div>
					</div>
				</td>
				<td class="brdr-right">
					<div class="event-data eventdata-main" style="text-align:center">
						<span class="cont-flag">
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/<?php echo ucwords($nation).'.png';?>" alt="">
						</span>

						<span>
						<a href="<?php echo base_url();?>nations/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?>">
								<?php
								if(strlen($event['nation'])>25) {
								echo ucwords(substr($event['nation'],0,25)).'..';
								}
								else if(strlen($event['nation']) == 3){
									echo ucwords(strtoupper($event['nation']));
								} else {
									echo ucwords(strtolower($event['nation']));
								}
								?> 
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else if($event['comp_logo'] == '' ){?> <img src=" images/competitions/default.png" alt=""> <?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>competitions/<?php echo $event['competition_id'];?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?> ">
								<?php
								if($event['category_name']== "Tennis" || $event['category_name']== "Golf" || $event['category_name']== "MotorSports"){
									
									if(strpos($event['competition_name'], ',')){
										$name=explode(',',ucwords(strtolower($event['competition_name'])));
										echo ucwords(strtolower($name[1]));
									} else {
										echo ucwords(strtolower($event['competition_name']));
									}
									
									
								}else{
								if(strlen($event['competition_name'])>25) {
									echo ucwords(substr($event['competition_name'],0,25)).'..';
								}
								else if(strlen($event['competition_name']) == 3){
									echo ucwords(strtoupper($event['competition_name']));
								} else {
									echo ucwords(strtolower($event['competition_name']));
								}
								}
								?> 
							</span>
						</a>
					</span>	
				</td>
				<td colspan="2" class="brdr-right">
					<div class="">
						<div class="<?php if($event['away_team']) {?>col-sm-5 no-pad tablet-data1 dev-float-left<?php } else {?>col-sm-12 no-pad  tablet-data1 dev-float-left<?php } ?>">
							<div class="team-data1">
										<span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['home_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
									<?php } else if($event['home_team_logo'] == '' || $event['home_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
									
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">
									<?php
										echo ucwords($event['home_team']);
									?> 
									</a>
								</span> <?php $status = explode('-',$event['events_status']); ?>
							</div>
						</div>
						<?php  
						if($event['away_team']) {?>
						
						<div class="col-sm-1 hidden-xs no-pad  tablet-data1 text-center-event">
							<div class="vs-match">VS</div>
							<div class="result-outer">
							<span class="score1"> <?php if($status[0] == '') { echo "-"; } else { echo $status[0]; }  ?> </span> &nbsp;:&nbsp;
							<span class="score2"> <?php if($status[1] == '') { echo "-"; } else { echo $status[1]; }  ?> </span>
							</div>
						</div>
						<div class="col-sm-5 no-pad tablet-data1 dev-float-right text-right">
							<div class="team-data2">
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['away_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['away_team']));?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                                 <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
								<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['away_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
								<?php } else if($event['away_team_logo'] == '' || $event['away_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
																		<?php } else { ?>
									<img src="<?php echo $event['away_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
							</div>
						</div>
                        <?php } ?>
					</div>
				</td>
				<td style="vertical-align: middle;">
				<?php if(date('Y-m-d H:i:s', (strtotime($event['end_date']))) < $current_date){ ?>
				
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">Highlight</a>
					</div>
					
				<?php } else { ?>
					<div class="view-event <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) { } else { ?> <?php echo $this->session->userdata('session_color').'-view-event'; } ?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>watch/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Event</a>
					</div>
				<?php } ?>
				</td>
				<td style="display:none"></td>
				
			</tr>
<?php 	} 
	}
	}
	
	public function ajax_sports(){
		$new_session_time= $this->session->userdata('time_formate') * 60 * 60;
		$current_date = gmdate('Y-m-d H:i:s');
		$rss = $this->load->database('rss', TRUE);
	//	$session_date = $this->session->userdata('date_timezone');
		$datepick = $this->input->post('datepicker');
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) - ($my_timezone * 60 * 60));
		$converted_datetime = date('Y-m-d H:i:s', $date_time);
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$sport = $this->input->post('sport');
		$competition = $this->input->post('competition');
		$nation = $this->input->post('nation');
		$value = $this->input->post('value');
		//echo $sport;exit;
		if($sport == "all"){ ?>
			<div class="compete" id="compete" style="display:none;">
				<?php
					$rss->select('rss_competition.competition_id,rss_competition.competition_name');
					if($value == 0){
						$rss->where('DATE(rss_events.start_date) =',$converted_date );
					} else{
						$rss->where('DATE(rss_events.start_date) >=',$converted_date );
						$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );
					}
					$rss->join('rss_events','rss_events.competition_id=rss_competition.competition_id');
					$rss->order_by('rss_events.start_date','aesc');
					$rss->group_by('rss_competition.competition_id');
					$competition = $rss->get('rss_competition')->result_array();
					//echo $this->db->last_query();
				?>
				<select name="my_competition" id="my_competition" >
					<option value="">All Competitions</option>
					<?php foreach($competition as $name){?>
					<option value="<?php echo $name['competition_id'];?>"><?php echo ucwords(strtolower($name['competition_name']));?></option>
					
					<?php } ?>
				</select> 
			</div>
			<?php  //$events = $this->index_model->get_ajax_sports($competition);
			 $events = $this->index_model->get_ajax_sports_empty($value);
			 
			foreach($events as $event){ ?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
				<td class="brdr-right">
					<div class="event-data ">
						<div class="text-left">
							<img  class="team-img-bg <?php echo $this->session->userdata('session_color');?>-team-img-bg" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo $event['sport_logo'];?>">
						</div>
						<!--
						<div class="col-xs-9 text-left sports-name">
							<p><?php //echo $event['category_name'] ?></p><!--<a href="#">Live</a>
						</div>
						-->
					</div>
				</td>
				<td class="brdr-right">
					<div class="date-data">
					
						<div id="data_<?php echo $event['id'] ?>" class="date-circle <?php echo $this->session->userdata('session_color');?>-date-circle">	<?php echo  date("j", (strtotime($event['start_date'])));?>
							 <?php echo date('M', (strtotime($event['start_date'])));?>
						</div>
						 
						<div class="time-content">
							<?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?>
							
							<span class="match_time" style="color:red; font-size:12px;"  
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?> " 
								data-id="<?php echo $event['id'] ?>">
								<?php echo date('H:i', (strtotime($event['start_date'])+$new_session_time));?>
								</span>
								<?php } else { ?>
								<span class="match_time"
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?>"
								data-id="<?php echo $event['id'] ?>"
								><?php echo  date('H:i', (strtotime($event['start_date'])+ $new_session_time));?></span><?php } ?>
						</div>
					</div>
				</td>
				<td class="brdr-right">
					<div class="event-data eventdata-main" style="text-align:center">
						<span class="cont-flag">
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/<?php echo ucwords($nation).'.png';?>" alt="">
						</span>

						<span>
						<a href="<?php echo base_url();?>nations/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?>">
								<?php
								if(strlen($event['nation'])>25) {
								echo ucwords(substr($event['nation'],0,25)).'..';
								}
								else if(strlen($event['nation']) == 3){
									echo ucwords(strtoupper($event['nation']));
								} else {
									echo ucwords(strtolower($event['nation']));
								}
								?> 
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else if($event['comp_logo'] == '' ){?> <img src=" images/competitions/default.png" alt=""> <?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>competitions/<?php echo $event['competition_id'];?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?> ">
								<?php
								if($event['category_name']== "Tennis" || $event['category_name']== "Golf" || $event['category_name']== "MotorSports"){
									
									if(strpos($event['competition_name'], ',')){
										$name=explode(',',ucwords(strtolower($event['competition_name'])));
										echo ucwords(strtolower($name[1]));
									} else {
										echo ucwords(strtolower($event['competition_name']));
									}
									
									
								}else{
								if(strlen($event['competition_name'])>25) {
									echo ucwords(substr($event['competition_name'],0,25)).'..';
								}
								else if(strlen($event['competition_name']) == 3){
									echo ucwords(strtoupper($event['competition_name']));
								} else {
									echo ucwords(strtolower($event['competition_name']));
								}
								}
								?> 
							</span>
						</a>
					</span>	
				</td>
				<td colspan="2" class="brdr-right">
					<div class="">
						<div class="<?php if($event['away_team']) {?>col-sm-5 no-pad tablet-data1 dev-float-left<?php } else {?>col-sm-12 no-pad  tablet-data1 dev-float-left<?php } ?>">
							<div class="team-data1">
								<span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['home_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
									<?php } else if($event['home_team_logo'] == '' || $event['home_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
									
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">
									<?php
										echo ucwords($event['home_team']);
									?> 
									</a>
								</span> <?php $status = explode('-',$event['events_status']); ?>
							</div>
						</div>
						<?php  
						if($event['away_team']) {?>
						
						<div class="col-sm-1 hidden-xs no-pad  tablet-data1 text-center-event">
							<div class="vs-match">VS</div>
							<div class="result-outer">
							<span class="score1"> <?php if($status[0] == '') { echo "-"; } else { echo $status[0]; }  ?> </span> &nbsp;:&nbsp;
							<span class="score2"> <?php if($status[1] == '') { echo "-"; } else { echo $status[1]; }  ?> </span>
							</div>
						</div>
						<div class="col-sm-5 no-pad tablet-data1 dev-float-right text-right">
							<div class="team-data2">
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['away_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['away_team']));?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                           <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
								<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['away_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
								<?php } else if($event['away_team_logo'] == '' || $event['away_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
																		<?php } else { ?>
									<img src="<?php echo $event['away_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
							</div>
						</div>
                        <?php } ?>
					</div>
				</td>
				<td style="vertical-align: middle;">
				<?php if(date('Y-m-d H:i:s', (strtotime($event['end_date']))) < $current_date){ ?>
				
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">Highlight</a>
					</div>
					
				<?php } else { ?>
					<div class="view-event <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) { } else { ?> <?php echo $this->session->userdata('session_color').'-view-event'; } ?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>watch/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Event</a>
					</div>
				<?php } ?>
				</td>
				<td style="display:none"></td>
				
			</tr>
		<?php } 
		}else if($sport == ""){?>
			
			 <?php //when all sports is selected from front.
			 $events = $this->index_model->get_ajax_sports_empty($value);
			 
			foreach($events as $event){ ?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
				<td class="brdr-right">
					<div class="event-data ">
						<div class="text-left">
							<img  class="team-img-bg <?php echo $this->session->userdata('session_color');?>-team-img-bg" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo $event['sport_logo'];?>">
						</div>
						<!--
						<div class="col-xs-9 text-left sports-name">
							<p><?php //echo $event['category_name'] ?></p><!--<a href="#">Live</a>
						</div>
						-->
					</div>
				</td>
				<td class="brdr-right">
					<div class="date-data">
					
						<div id="data_<?php echo $event['id'] ?>" class="date-circle <?php echo $this->session->userdata('session_color');?>-date-circle">	<?php echo  date("j", (strtotime($event['start_date'])));?>
							 <?php echo date('M', (strtotime($event['start_date'])));?>
						</div>
						 
						<div class="time-content">
							<?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?>
							
							<span class="match_time" style="color:red; font-size:12px;"  
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?> " 
								data-id="<?php echo $event['id'] ?>">
								<?php echo date('H:i', (strtotime($event['start_date'])+$new_session_time));?>
								</span>
								<?php } else { ?>
								<span class="match_time"
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?>"
								data-id="<?php echo $event['id'] ?>"
								><?php echo  date('H:i', (strtotime($event['start_date'])+ $new_session_time));?></span><?php } ?>
						</div>
					</div>
				</td>
				<td class="brdr-right">
					<div class="event-data eventdata-main" style="text-align:center">
						<span class="cont-flag">
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/<?php echo ucwords($nation).'.png';?>" alt="">
						</span>

						<span>
						<a href="<?php echo base_url();?>nations/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?>">
								<?php
								if(strlen($event['nation'])>25) {
								echo ucwords(substr($event['nation'],0,25)).'..';
								}
								else if(strlen($event['nation']) == 3){
									echo ucwords(strtoupper($event['nation']));
								} else {
									echo ucwords(strtolower($event['nation']));
								}
								?> 
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else if($event['comp_logo'] == '' ){?> <img src=" images/competitions/default.png" alt=""> <?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>competitions/<?php echo $event['competition_id'];?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?> ">
								<?php
								if($event['category_name']== "Tennis" || $event['category_name']== "Golf" || $event['category_name']== "MotorSports"){
									
									if(strpos($event['competition_name'], ',')){
										$name=explode(',',ucwords(strtolower($event['competition_name'])));
										echo ucwords(strtolower($name[1]));
									} else {
										echo ucwords(strtolower($event['competition_name']));
									}
									
									
								}else{
								if(strlen($event['competition_name'])>25) {
									echo ucwords(substr($event['competition_name'],0,25)).'..';
								}
								else if(strlen($event['competition_name']) == 3){
									echo ucwords(strtoupper($event['competition_name']));
								} else {
									echo ucwords(strtolower($event['competition_name']));
								}
								}
								?> 
							</span>
						</a>
					</span>	
				</td>
				<td colspan="2" class="brdr-right">
					<div class="">
						<div class="<?php if($event['away_team']) {?>col-sm-5 no-pad tablet-data1 dev-float-left<?php } else {?>col-sm-12 no-pad  tablet-data1 dev-float-left<?php } ?>">
							<d<span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['home_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
									<?php } else if($event['home_team_logo'] == '' || $event['home_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
									
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">
									<?php
										echo ucwords($event['home_team']);
									?> 
									</a>
								</span> <?php $status = explode('-',$event['events_status']); ?>
							</div>
						</div>
						<?php  
						if($event['away_team']) {?>
						
						<div class="col-sm-1 hidden-xs no-pad  tablet-data1 text-center-event">
							<div class="vs-match">VS</div>
							<div class="result-outer">
							<span class="score1"> <?php if($status[0] == '') { echo "-"; } else { echo $status[0]; }  ?> </span> &nbsp;:&nbsp;
							<span class="score2"> <?php if($status[1] == '') { echo "-"; } else { echo $status[1]; }  ?> </span>
							</div>
						</div>
						<div class="col-sm-5 no-pad tablet-data1 dev-float-right text-right">
							<div class="team-data2">
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['away_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['away_team']));?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                              <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
								<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['away_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
								<?php } else if($event['away_team_logo'] == '' || $event['away_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
																		<?php } else { ?>
									<img src="<?php echo $event['away_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
							</div>
						</div>
                        <?php } ?>
					</div>
				</td>
				<td style="vertical-align: middle;">
				<?php if(date('Y-m-d H:i:s', (strtotime($event['end_date']))) < $current_date){ ?>
				
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">Highlight</a>
					</div>
					
				<?php } else { ?>
					<div class="view-event <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) { } else { ?> <?php echo $this->session->userdata('session_color').'-view-event'; } ?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>watch/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Event</a>
					</div>
				<?php } ?>
				</td>
				<td style="display:none"></td>
				
			</tr>
		<?php } ?>
		<div class="compete" id="compete" style="display:none;">
				<?php
				$rss = $this->load->database('rss', TRUE);
				
				$my_date_time =  $this->session->userdata('session_date_time');
				$my_timezone = $this->session->userdata('my_timezone');
				$date_time = (strtotime($my_date_time) - ($my_timezone * 60 * 60));
				$converted_datetime = date('Y-m-d H:i:s', $date_time);
				$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
				$datetime = new DateTime($converted_date);
				$datetime->modify('+1 day');
				$session_date_tommorrow = $datetime->format('Y-m-d');
				
				$rss->select('rss_competition.competition_id,rss_competition.competition_name');
				if($value == 0){
					$rss->where('DATE(rss_events.start_date) =',$converted_date );
				} else{
					$rss->where('DATE(rss_events.start_date) >=',$converted_date );
					$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );
				}
				$rss->join('rss_events','rss_events.competition_id=rss_competition.competition_id');
				$rss->order_by('rss_events.start_date','aesc');
				$rss->group_by('rss_competition.competition_id');
				$competition = $rss->get('rss_competition')->result_array();
				//echo $this->db->last_query();
				?>
				<!-- when All sports is selected from front, competition filter is changed! -->
				<select name="my_competition" id="my_competition" >
					<option value="">All Competitions</option>
					<?php foreach($competition as $name){?>
					<option value="<?php echo $name['competition_id'];?>"><?php echo ucwords(strtolower($name['competition_name']));?></option>
					<?php } ?>
				</select> 
			</div>
		<?php }
		
		
		else{ //------------------------------------HERE TO GET COMPETITIONS----------------------------------------------------
			if($nation ==''){
				//When sport Category is clicked from front
				
				$events2 = $this->index_model->ajax_events_sports_empty($sport,$value,$datepick);
				//echo "<pre>";print_r($events2);exit;
				?>
					<div class="compete" id="compete" style="display:none;">
					<?php
					$exist = array();
					//when sports get selected ... competition change.
					if($datepick){ ?>
						<option id='competition_id' selected disabled>Competitions</option>
					<?php } else {
						echo "<option id='competition_id' value='all'>All Competitions</option>";
					}
					
					foreach($events2 as $myevent) {
						//Do Not Repeat if same Sport id exists in array more then once
						
							if(!in_array($myevent['competition_id'], $exist, TRUE)){ 
							echo "<option id='sport_id' class='competition' value='".$myevent['competition_id']."'>".$myevent['competition_name']."</option>";
							$exist[] = $myevent['competition_id'];
						}
					
					 }//end of foreach loop ?>
					</div>


			<?php }else{
				
				//<?php $session_date_time = $this->session->userdata('time_timezone');
				$events2 = $this->index_model->ajax_nations_sports($sport,$nation,$value,$datepick);
				//echo "<pre>";print_r($events2);exit;
				?>
				
				<div class="compete" id="compete" style="display:none;">
					<?php
					$exist = array();
					//when sports get selected ... competition change.
					echo "<option id='competition_id' value='all'>All Competitions</option>";
					foreach($events2 as $myevent) {
						//Do Not Repeat if same Sport id exists in array more then once
							if(!in_array($myevent['competition_id'], $exist, TRUE)){ 
							echo "<option id='sport_id' class='competition' value='".$myevent['competition_id']."'>".$myevent['competition_name']."</option>";
							$exist[] = $myevent['competition_id'];
						}
					
					 }//end of foreach loop ?>
					</div>
			<?php } 
			if($events2)
			{	
			foreach($events2 as $event){ ?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
				<td class="brdr-right">
					<div class="event-data ">
						<div class="text-left">
							<img  class="team-img-bg <?php echo $this->session->userdata('session_color');?>-team-img-bg" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo $event['sport_logo'];?>">
						</div>
					</div>
				</td>
				<td class="brdr-right">
					<div class="date-data">
					
						<div id="data_<?php echo $event['id'] ?>" class="date-circle <?php echo $this->session->userdata('session_color');?>-date-circle">	<?php echo  date("j", (strtotime($event['start_date'])));?>
							 <?php echo date('M', (strtotime($event['start_date'])));?>
						</div>
						 
						<div class="time-content">
							<?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?>
							
							<span class="match_time" style="color:red; font-size:12px;"  
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?> " 
								data-id="<?php echo $event['id'] ?>">
								<?php echo date('H:i', (strtotime($event['start_date'])+$new_session_time));?>
								</span>
								<?php } else { ?>
								<span class="match_time"
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?>"
								data-id="<?php echo $event['id'] ?>"
								><?php echo  date('H:i', (strtotime($event['start_date'])+ $new_session_time));?></span><?php } ?>
						</div>
					</div>
				</td>
				<td class="brdr-right">
					<div class="event-data eventdata-main" style="text-align:center">
						<span class="cont-flag">
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/<?php echo ucwords($nation).'.png';?>" alt="">
						</span>

						<span>
						<a href="<?php echo base_url();?>nations/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?>">
								<?php
								if(strlen($event['nation'])>25) {
								echo ucwords(substr($event['nation'],0,25)).'..';
								}
								else if(strlen($event['nation']) == 3){
									echo ucwords(strtoupper($event['nation']));
								} else {
									echo ucwords(strtolower($event['nation']));
								}
								?> 
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else if($event['comp_logo'] == '' ){?> <img src=" images/competitions/default.png" alt=""> <?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>competitions/<?php echo $event['competition_id'];?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?> ">
								<?php
								if($event['category_name']== "Tennis" || $event['category_name']== "Golf" || $event['category_name']== "MotorSports"){
									
									if(strpos($event['competition_name'], ',')){
										$name=explode(',',ucwords(strtolower($event['competition_name'])));
										echo ucwords(strtolower($name[1]));
									} else {
										echo ucwords(strtolower($event['competition_name']));
									}
									
									
								}else{
								if(strlen($event['competition_name'])>25) {
									echo ucwords(substr($event['competition_name'],0,25)).'..';
								}
								else if(strlen($event['competition_name']) == 3){
									echo ucwords(strtoupper($event['competition_name']));
								} else {
									echo ucwords(strtolower($event['competition_name']));
								}
								}
								?> 
							</span>
						</a>
					</span>	
				</td>
				<td colspan="2" class="brdr-right">
					<div class="">
						<div class="<?php if($event['away_team']) {?>col-sm-5 no-pad tablet-data1 dev-float-left<?php } else {?>col-sm-12 no-pad  tablet-data1 dev-float-left<?php } ?>">
							<div class="team-data1">
								<span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['home_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
									<?php } else if($event['home_team_logo'] == '' || $event['home_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
									
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">
									<?php
										echo ucwords($event['home_team']);
									?> 
									</a>
								</span> <?php $status = explode('-',$event['events_status']); ?>
							</div>
						</div>
						<?php  
						if($event['away_team']) {?>
						
						<div class="col-sm-1 hidden-xs no-pad  tablet-data1 text-center-event">
							<div class="vs-match">VS</div>
							<div class="result-outer">
							<span class="score1"> <?php if($status[0] == '') { echo "-"; } else { echo $status[0]; }  ?> </span> &nbsp;:&nbsp;
							<span class="score2"> <?php if($status[1] == '') { echo "-"; } else { echo $status[1]; }  ?> </span>
							</div>
						</div>
						<div class="col-sm-5 no-pad tablet-data1 dev-float-right text-right">
							<div class="team-data2">
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['away_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['away_team']));?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                                <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
								<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['away_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
								<?php } else if($event['away_team_logo'] == '' || $event['away_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
																		<?php } else { ?>
									<img src="<?php echo $event['away_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
							</div>
						</div>
                        <?php } ?>
					</div>
				</td>
				<td style="vertical-align: middle;">
				<?php if(date('Y-m-d H:i:s', (strtotime($event['end_date']))) < $current_date){ ?>
				
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">Highlight</a>
					</div>
					
				<?php } else { ?>
					<div class="view-event <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) { } else { ?> <?php echo $this->session->userdata('session_color').'-view-event'; } ?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>watch/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Event</a>
					</div>
				<?php } ?>
				</td>
				<td style="display:none"></td>
				
			</tr>
	<?php 		} 
			}else {	
					echo "No Events Found For This Competition";
			}
		}
	}
public function ajax_nation_sport(){
	$new_session_time= $this->session->userdata('time_formate') * 60 * 60;
	$current_date = gmdate('Y-m-d H:i:s');
		
	$datepick = $this->input->post('datepick');
	$rss = $this->load->database('rss', TRUE);
	$session_date_time = $this->session->userdata('time_timezone');
	$nation_id = $this->input->post('nation_id');
	$value = $this->input->post('value');
	$nation_sport_id = $this->input->post('nation_sport_id');
	
	if($nation_id == ''){ ?>
		
		
		<?php
		//Selecting a Nation
		$events = $this->index_model->ajax_all_nations($value);
		foreach($events as $event){
		
		?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
				<?php if($nation_sport_id) { } else { ?>
				<td class="brdr-right">
					<div class="event-data ">
						<div class="text-left">
							<img  class="team-img-bg <?php echo $this->session->userdata('session_color');?>-team-img-bg" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo $event['sport_logo'];?>">
						</div>
						<!--
						<div class="col-xs-9 text-left sports-name">
							<p><?php //echo $event['category_name'] ?></p><!--<a href="#">Live</a>
						</div>
						-->
					</div>
				</td> <?php } ?>
				<td class="brdr-right">
					<div class="date-data">
					
						<div id="data_<?php echo $event['id'] ?>" class="date-circle <?php echo $this->session->userdata('session_color');?>-date-circle">	<?php echo  date("j", (strtotime($event['start_date'])));?>
							 <?php echo date('M', (strtotime($event['start_date'])));?>
						</div>
						 
						<div class="time-content">
							<?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?>
							
							<span class="match_time" style="color:red; font-size:12px;"  
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?> " 
								data-id="<?php echo $event['id'] ?>">
								<?php echo date('H:i', (strtotime($event['start_date'])+$new_session_time));?>
								</span>
								<?php } else { ?>
								<span class="match_time"
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?>"
								data-id="<?php echo $event['id'] ?>"
								><?php echo  date('H:i', (strtotime($event['start_date'])+ $new_session_time));?></span><?php } ?>
						</div>
					</div>
				</td>
				<td class="brdr-right">
					<div class="event-data eventdata-main" style="text-align:center">
						<span class="cont-flag">
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/<?php echo ucwords($nation).'.png';?>" alt="">
						</span>

						<span>
						<a href="<?php echo base_url();?>nations/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?>">
								<?php
								if(strlen($event['nation'])>25) {
								echo ucwords(substr($event['nation'],0,25)).'..';
								}
								else if(strlen($event['nation']) == 3){
									echo ucwords(strtoupper($event['nation']));
								} else {
									echo ucwords(strtolower($event['nation']));
								}
								?> 
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else if($event['comp_logo'] == '' ){?> <img src=" images/competitions/default.png" alt=""> <?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>competitions/<?php echo $event['competition_id'];?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?> ">
								<?php
								if($event['category_name']== "Tennis" || $event['category_name']== "Golf" || $event['category_name']== "MotorSports"){
									
									if(strpos($event['competition_name'], ',')){
										$name=explode(',',ucwords(strtolower($event['competition_name'])));
										echo ucwords(strtolower($name[1]));
									} else {
										echo ucwords(strtolower($event['competition_name']));
									}
									
									
								}else{
								if(strlen($event['competition_name'])>25) {
									echo ucwords(substr($event['competition_name'],0,25)).'..';
								}
								else if(strlen($event['competition_name']) == 3){
									echo ucwords(strtoupper($event['competition_name']));
								} else {
									echo ucwords(strtolower($event['competition_name']));
								}
								}
								?> 
							</span>
						</a>
					</span>	
				</td>
				<td colspan="2" class="brdr-right">
					<div class="">
						<div class="<?php if($event['away_team']) {?>col-sm-5 no-pad tablet-data1 dev-float-left<?php } else {?>col-sm-12 no-pad  tablet-data1 dev-float-left<?php } ?>">
							<div class="team-data1">
								<span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['home_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
									<?php } else if($event['home_team_logo'] == '' || $event['home_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
									
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">
									<?php
										echo ucwords($event['home_team']);
									?> 
									</a>
								</span> <?php $status = explode('-',$event['events_status']); ?>
							</div>
						</div>
						<?php  
						if($event['away_team']) {?>
						
						<div class="col-sm-1 hidden-xs no-pad  tablet-data1 text-center-event">
							<div class="vs-match">VS</div>
							<div class="result-outer">
							<span class="score1"> <?php if($status[0] == '') { echo "-"; } else { echo $status[0]; }  ?> </span> &nbsp;:&nbsp;
							<span class="score2"> <?php if($status[1] == '') { echo "-"; } else { echo $status[1]; }  ?> </span>
							</div>
						</div>
						<div class="col-sm-5 no-pad tablet-data1 dev-float-right text-right">
							<div class="team-data2">
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['away_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['away_team']));?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                              <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
								<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['away_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
								<?php } else if($event['away_team_logo'] == '' || $event['away_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
																		<?php } else { ?>
									<img src="<?php echo $event['away_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
							</div>
						</div>
                        <?php } ?>
					</div>
				</td>
				<td style="vertical-align: middle;">
				<?php if(date('Y-m-d H:i:s', (strtotime($event['end_date']))) < $current_date){ ?>
				
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">Highlight</a>
					</div>
					
				<?php } else { ?>
					<div class="view-event <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) { } else { ?> <?php echo $this->session->userdata('session_color').'-view-event'; } ?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>watch/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Event</a>
					</div>
				<?php } ?>
				</td>
				<td style="display:none"></td>
				
			</tr> <?php
		} ?><div class="compete" id="compete" style="display:none;">
		
			<?php
			
				$my_date_time =  $this->session->userdata('session_date_time');
				$my_timezone = $this->session->userdata('my_timezone');
				$date_time = (strtotime($my_date_time) - ($my_timezone * 60 * 60));
				$converted_datetime = date('Y-m-d H:i:s', $date_time);
				$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
				$datetime = new DateTime($converted_date);
				$datetime->modify('+1 day');
				$session_date_tommorrow = $datetime->format('Y-m-d');
				$rss = $this->load->database('rss', TRUE);
				$rss->select('rss_sport_category.id,rss_sport_category.category_name');
				if($value == 0){
					$rss->where('DATE(rss_events.start_date) =',$converted_date );
				} else{
					$rss->where('DATE(rss_events.start_date) >=',$converted_date );
					$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );
				}
				if($nation_sport_id){
					$rss->where('rss_competition.sport_cat_id',$nation_sport_id);
					$rss->join('rss_sport_category','rss_sport_category.id=rss_competition.sport_cat_id');
				}
				$rss->join('rss_events','rss_events.sport_category_id=rss_sport_category.id');
				$rss->join('rss_competition','rss_competition.sport_cat_id=rss_sport_category.id');
				$rss->group_by('rss_sport_category.id');
				$sports = $rss->get('rss_sport_category')->result_array();
				//echo "<pre>";print_r($sports);exit;
			?>
			<select name="my_sports" id="my_sports" >
				<?php if($datepick){ ?><option value="" selected disabled>Sports</option> <?php } else { ?>
				<option value="">All Sports</option> <?php } ?>
				<?php foreach($sports as $sport){?>
				<option  value="<?php echo $sport['id'];?>"><?php echo ucwords(strtolower($sport['category_name']));?></option>
				<?php } ?>
			</select> 
		</div>

	<?php } 
	else { 
	$nation_id = $this->input->post('nation_id');
	//change sport on nation
	$events2 = $this->index_model->get_nation_sports($nation_id,$value,$datepick);
	//echo $nation_id;
	?>
		<div class="compete" id="compete" style="display:none;">
		<?php
		$exist = array();
		//when sports get selected on Nation change.
		echo "<option id='sport_id' value='all'>All Sports</option>";
		foreach($events2 as $myevent) {
			//Do Not Repeat if same Sport id exists in array more then once
				if(!in_array($myevent['sport_category_id'], $exist, TRUE)){ 
				echo "<option id='sport_id' class='view' value='".$myevent['sport_category_id']."'>".ucwords(strtolower($myevent['category_name']))."</option>";
				$exist[] = $myevent['sport_category_id'];
			}
		
		 }//end of foreach loop ?>
		</div>
		<?php
		//On nation change from start
		$events = $this->index_model->get_nation_ajax($nation_id,$value,$nation_sport_id,$datepick);
		
		foreach($events as $event){ ?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
			<?php if($nation_sport_id) { } else {?>
				<td class="brdr-right">
					<div class="event-data ">
						<div class="text-left">
							<img  class="team-img-bg <?php echo $this->session->userdata('session_color');?>-team-img-bg" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo $event['sport_logo'];?>">
						</div>
					</div>
				</td> <?php } ?>
				<td class="brdr-right">
					<div class="date-data">
					
						<div id="data_<?php echo $event['id'] ?>" class="date-circle <?php echo $this->session->userdata('session_color');?>-date-circle">	<?php echo  date("j", (strtotime($event['start_date'])));?>
							 <?php echo date('M', (strtotime($event['start_date'])));?>
						</div>
						 
						<div class="time-content">
							<?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?>
							
							<span class="match_time" style="color:red; font-size:12px;"  
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?> " 
								data-id="<?php echo $event['id'] ?>">
								<?php echo date('H:i', (strtotime($event['start_date'])+$new_session_time));?>
								</span>
								<?php } else { ?>
								<span class="match_time"
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?>"
								data-id="<?php echo $event['id'] ?>"
								><?php echo  date('H:i', (strtotime($event['start_date'])+ $new_session_time));?></span><?php } ?>
						</div>
					</div>
				</td>
				<td class="brdr-right">
					<div class="event-data eventdata-main" style="text-align:center">
						<span class="cont-flag">
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/<?php echo ucwords($nation).'.png';?>" alt="">
						</span>

						<span>
						<a href="<?php echo base_url();?>nations/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?>">
								<?php
								if(strlen($event['nation'])>25) {
								echo ucwords(substr($event['nation'],0,25)).'..';
								}
								else if(strlen($event['nation']) == 3){
									echo ucwords(strtoupper($event['nation']));
								} else {
									echo ucwords(strtolower($event['nation']));
								}
								?> 
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else if($event['comp_logo'] == '' ){?> <img src=" images/competitions/default.png" alt=""> <?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>competitions/<?php echo $event['competition_id'];?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?> ">
								<?php
								if($event['category_name']== "Tennis" || $event['category_name']== "Golf" || $event['category_name']== "MotorSports"){
									
									if(strpos($event['competition_name'], ',')){
										$name=explode(',',ucwords(strtolower($event['competition_name'])));
										echo ucwords(strtolower($name[1]));
									} else {
										echo ucwords(strtolower($event['competition_name']));
									}
									
									
								}else{
								if(strlen($event['competition_name'])>25) {
									echo ucwords(substr($event['competition_name'],0,25)).'..';
								}
								else if(strlen($event['competition_name']) == 3){
									echo ucwords(strtoupper($event['competition_name']));
								} else {
									echo ucwords(strtolower($event['competition_name']));
								}
								}
								?> 
							</span>
					</span>	
				</td>
				<td colspan="2" class="brdr-right">
					<div class="">
						<div class="<?php if($event['away_team']) {?>col-sm-5 no-pad tablet-data1 dev-float-left<?php } else {?>col-sm-12 no-pad  tablet-data1 dev-float-left<?php } ?>">
							<div class="team-data1">
								<span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['home_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
									<?php } else if($event['home_team_logo'] == '' || $event['home_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
									
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">
									<?php
										echo ucwords($event['home_team']);
									?> 
									</a>
								</span> <?php $status = explode('-',$event['events_status']); ?>
							</div>
						</div>
						<?php  
						if($event['away_team']) {?>
						
						<div class="col-sm-1 hidden-xs no-pad  tablet-data1 text-center-event">
							<div class="vs-match">VS</div>
							<div class="result-outer">
							<span class="score1"> <?php if($status[0] == '') { echo "-"; } else { echo $status[0]; }  ?> </span> &nbsp;:&nbsp;
							<span class="score2"> <?php if($status[1] == '') { echo "-"; } else { echo $status[1]; }  ?> </span>
							</div>
						</div>
						<div class="col-sm-5 no-pad tablet-data1 dev-float-right text-right">
							<div class="team-data2">
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['away_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['away_team']));?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                                 <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
								<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['away_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
								<?php } else if($event['away_team_logo'] == '' || $event['away_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
																		<?php } else { ?>
									<img src="<?php echo $event['away_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
							</div>
						</div>
                        <?php } ?>
					</div>
				</td>
				<td style="vertical-align: middle;">
				<?php if(date('Y-m-d H:i:s', (strtotime($event['end_date']))) < $current_date){ ?>
				
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">Highlight</a>
					</div>
					
				<?php } else { ?>
					<div class="view-event <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) { } else { ?> <?php echo $this->session->userdata('session_color').'-view-event'; } ?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>watch/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Event</a>
					</div>
				<?php } ?>
				</td>
				<td style="display:none"></td>
				
			</tr>
<?php 	} 
	}
}
	
	public function ajax_events(){
		$new_session_time= $this->session->userdata('time_formate') * 60 * 60;
		$current_date = gmdate('Y-m-d H:i:s');
		
		$rss = $this->load->database('rss', TRUE);
		$datepick = $this->input->post('datepick');
		$competition = $this->input->post('competition');
		$value = $this->input->post('value');
		$nation_sport_id = $this->input->post('nation_sport_id');
		if($competition == ""){?>
			

		<?php	//When all competition is selected....
		//echo "<input id='sport_id' type='hidden' value='all'>";
			 $events = $this->index_model->ajax_events_competition_all($value); //if selected all competitions show up.
			 
			 
			foreach($events as $event){ ?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
			<?php if($nation_sport_id) { } else {?>
				<td class="brdr-right">
					<div class="event-data ">
						<div class="text-left">
							<img  class="team-img-bg <?php echo $this->session->userdata('session_color');?>-team-img-bg" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo $event['sport_logo'];?>">
						</div>
						<!--
						<div class="col-xs-9 text-left sports-name">
							<p><?php //echo $event['category_name'] ?></p><!--<a href="#">Live</a>
						</div>
						-->
					</div>
				</td> <?php } ?>
				<td class="brdr-right">
					<div class="date-data">
					
						<div id="data_<?php echo $event['id'] ?>" class="date-circle <?php echo $this->session->userdata('session_color');?>-date-circle">	<?php echo  date("j", (strtotime($event['start_date'])));?>
							 <?php echo date('M', (strtotime($event['start_date'])));?>
						</div>
						 
						<div class="time-content">
							<?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?>
							
							<span class="match_time" style="color:red; font-size:12px;"  
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?> " 
								data-id="<?php echo $event['id'] ?>">
								<?php echo date('H:i', (strtotime($event['start_date'])+$new_session_time));?>
								</span>
								<?php } else { ?>
								<span class="match_time"
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?>"
								data-id="<?php echo $event['id'] ?>"
								><?php echo  date('H:i', (strtotime($event['start_date'])+ $new_session_time));?></span><?php } ?>
						</div>
					</div>
				</td>
				<td class="brdr-right">
					<div class="event-data eventdata-main" style="text-align:center">
						<span class="cont-flag">
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/<?php echo ucwords($nation).'.png';?>" alt="">
						</span>

						<span>
						<a href="<?php echo base_url();?>nations/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?>">
								<?php
								if(strlen($event['nation'])>25) {
								echo ucwords(substr($event['nation'],0,25)).'..';
								}
								else if(strlen($event['nation']) == 3){
									echo ucwords(strtoupper($event['nation']));
								} else {
									echo ucwords(strtolower($event['nation']));
								}
								?> 
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else if($event['comp_logo'] == '' ){?> <img src=" images/competitions/default.png" alt=""> <?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>competitions/<?php echo $event['competition_id'];?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?> ">
								<?php
								if($event['category_name']== "Tennis" || $event['category_name']== "Golf" || $event['category_name']== "MotorSports"){
									
									if(strpos($event['competition_name'], ',')){
										$name=explode(',',ucwords(strtolower($event['competition_name'])));
										echo ucwords(strtolower($name[1]));
									} else {
										echo ucwords(strtolower($event['competition_name']));
									}
									
									
								}else{
								if(strlen($event['competition_name'])>25) {
									echo ucwords(substr($event['competition_name'],0,25)).'..';
								}
								else if(strlen($event['competition_name']) == 3){
									echo ucwords(strtoupper($event['competition_name']));
								} else {
									echo ucwords(strtolower($event['competition_name']));
								}
								}
								?> 
							</span>
						</a>
					</span>	
				</td>
				<td colspan="2" class="brdr-right">
					<div class="">
						<div class="<?php if($event['away_team']) {?>col-sm-5 no-pad tablet-data1 dev-float-left<?php } else {?>col-sm-12 no-pad  tablet-data1 dev-float-left<?php } ?>">
							<div class="team-data1">
							<span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['home_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
									<?php } else if($event['home_team_logo'] == '' || $event['home_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
									
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">
									<?php
										echo ucwords($event['home_team']);
									?> 
									</a>
								</span> <?php $status = explode('-',$event['events_status']); ?>
							</div>
						</div>
						<?php  
						if($event['away_team']) {?>
						
						<div class="col-sm-1 hidden-xs no-pad  tablet-data1 text-center-event">
							<div class="vs-match">VS</div>
							<div class="result-outer">
							<span class="score1"> <?php if($status[0] == '') { echo "-"; } else { echo $status[0]; }  ?> </span> &nbsp;:&nbsp;
							<span class="score2"> <?php if($status[1] == '') { echo "-"; } else { echo $status[1]; }  ?> </span>
							</div>
						</div>
						<div class="col-sm-5 no-pad tablet-data1 dev-float-right text-right">
							<div class="team-data2">
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['away_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['away_team']));?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                           <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
								<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['away_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
								<?php } else if($event['away_team_logo'] == '' || $event['away_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
																		<?php } else { ?>
									<img src="<?php echo $event['away_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
							</div>
						</div>
                        <?php } ?>
					</div>
				</td>
				<td style="vertical-align: middle;">
				<?php if(date('Y-m-d H:i:s', (strtotime($event['end_date']))) < $current_date){ ?>
				
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">Highlight</a>
					</div>
					
				<?php } else { ?>
					<div class="view-event <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) { } else { ?> <?php echo $this->session->userdata('session_color').'-view-event'; } ?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>watch/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Event</a>
					</div>
				<?php } ?>
				</td>
				<td style="display:none"></td>
				
			</tr>
	<?php 	} ?>
	<div class="compete" id="compete" style="display:none;">
				<?php
					$my_date_time =  $this->session->userdata('session_date_time');
					$my_timezone = $this->session->userdata('my_timezone');
					$date_time = (strtotime($my_date_time) - ($my_timezone * 60 * 60));
					$converted_datetime = date('Y-m-d H:i:s', $date_time);
					$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
					$datetime = new DateTime($converted_date);
					$datetime->modify('+1 day');
					$session_date_tommorrow = $datetime->format('Y-m-d');
					$rss = $this->load->database('rss', TRUE);
					$rss->select('rss_sport_category.id,rss_sport_category.category_name');
					if($value == 0){
					$rss->where('DATE(rss_events.start_date) =',$converted_date );
					} else{
						$rss->where('DATE(rss_events.start_date) >=',$converted_date );
						$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow  );
					}
					$rss->order_by('rss_events.start_date','aesc');
					$rss->join('rss_events','rss_events.sport_category_id=rss_sport_category.id');
					$rss->join('rss_competition','rss_competition.sport_cat_id=rss_sport_category.id');
					$rss->group_by('rss_sport_category.id');
					$sports = $rss->get('rss_sport_category')->result_array();
					//echo "<pre>";print_r($sports);exit;
				?> <!-- When All competitions is selected from front -->
					<select name="my_sports" id="my_sports" >
						<option value="">All Sports</option>
						<?php foreach($sports as $sport){?>
						<option  value="<?php echo $sport['id'];?>"><?php echo ucwords(strtolower($sport['category_name']));?></option>
						<?php } ?>
					</select> 
				</div>
		<?php } else if($competition == "all"){?>
			<div class="compete" id="compete" style="display:none;">
				<?php
				
					$my_date_time =  $this->session->userdata('session_date_time');
					$my_timezone = $this->session->userdata('my_timezone');
					$date_time = (strtotime($my_date_time) - ($my_timezone * 60 * 60));
					$converted_datetime = date('Y-m-d H:i:s', $date_time);
					$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
					$datetime = new DateTime($converted_date);
					$datetime->modify('+1 day');
					$session_date_tommorrow = $datetime->format('Y-m-d');
				
				
					$rss = $this->load->database('rss', TRUE);
					$rss->select('rss_sport_category.id,rss_sport_category.category_name');
					if($value == 0){
					$rss->where('DATE(rss_events.start_date) =',$converted_date );
					} else{
						$rss->where('DATE(rss_events.start_date) >=',$converted_date );
						$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );
					}
					$rss->order_by('rss_events.start_date','aesc');
					$rss->join('rss_events','rss_events.sport_category_id=rss_sport_category.id');
					$rss->join('rss_competition','rss_competition.sport_cat_id=rss_sport_category.id');
					$rss->group_by('rss_sport_category.id');
					$sports = $rss->get('rss_sport_category')->result_array();
					//echo "<pre>";print_r($sports);exit;
					?>
					<select name="my_sports" id="my_sports" >
						<option value="">All Sports</option>
						<?php foreach($sports as $sport){?>
						<option  value="<?php echo $sport['id'];?>"><?php echo ucwords(strtolower($sport['category_name']));?></option>
						<?php } ?>
					</select> 
			</div>
		<?php	//when all competition is selected after load events.
			 $events = $this->index_model->ajax_events_competition_all($competition,$value); //if selected all competitions show up.
			 
			foreach($events as $event){ ?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
			<?php if($nation_sport_id) { } else {?>
				<td class="brdr-right">
					<div class="event-data event-data-col">
						<div class="col-xs-3 text-left">
							<img  class="team-img-bg <?php echo $this->session->userdata('session_color');?>-team-img-bg" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo $event['sport_logo'];?>">
						</div>
					</div>
				</td> <?php } ?>
				<td class="brdr-right">
					<div class="date-data">
					
						<div id="data_<?php echo $event['id'] ?>" class="date-circle <?php echo $this->session->userdata('session_color');?>-date-circle">	<?php echo  date("j", (strtotime($event['start_date'])));?>
							 <?php echo date('M', (strtotime($event['start_date'])));?>
						</div>
						 
						<div class="time-content">
							<?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?>
							
							<span class="match_time" style="color:red; font-size:12px;"  
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?> " 
								data-id="<?php echo $event['id'] ?>">
								<?php echo date('H:i', (strtotime($event['start_date'])+$new_session_time));?>
								</span>
								<?php } else { ?>
								<span class="match_time"
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?>"
								data-id="<?php echo $event['id'] ?>"
								><?php echo  date('H:i', (strtotime($event['start_date'])+ $new_session_time));?></span><?php } ?>
						</div>
					</div>
				</td>
				<td class="brdr-right">
					<div class="event-data eventdata-main" style="text-align:center">
						<span class="cont-flag">
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/<?php echo ucwords($nation).'.png';?>" alt="">
						</span>

						<span>
						<a href="<?php echo base_url();?>nations/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?>">
								<?php
								if(strlen($event['nation'])>25) {
								echo ucwords(substr($event['nation'],0,25)).'..';
								}
								else if(strlen($event['nation']) == 3){
									echo ucwords(strtoupper($event['nation']));
								} else {
									echo ucwords(strtolower($event['nation']));
								}
								?> 
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else if($event['comp_logo'] == '' ){?> <img src=" images/competitions/default.png" alt=""> <?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>competitions/<?php echo $event['competition_id'];?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?> ">
								<?php
								if($event['category_name']== "Tennis" || $event['category_name']== "Golf" || $event['category_name']== "MotorSports"){
									
									if(strpos($event['competition_name'], ',')){
										$name=explode(',',ucwords(strtolower($event['competition_name'])));
										echo ucwords(strtolower($name[1]));
									} else {
										echo ucwords(strtolower($event['competition_name']));
									}
									
									
								}else{
								if(strlen($event['competition_name'])>25) {
									echo ucwords(substr($event['competition_name'],0,25)).'..';
								}
								else if(strlen($event['competition_name']) == 3){
									echo ucwords(strtoupper($event['competition_name']));
								} else {
									echo ucwords(strtolower($event['competition_name']));
								}
								}
								?> 
							</span>
						</a>
					</span>	
				</td>
				<td colspan="2" class="brdr-right">
					<div class="">
						<div class="<?php if($event['away_team']) {?>col-sm-5 no-pad tablet-data1 dev-float-left<?php } else {?>col-sm-12 no-pad  tablet-data1 dev-float-left<?php } ?>">
							<div class="team-data1">
								<span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['home_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
									<?php } else if($event['home_team_logo'] == '' || $event['home_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
									
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">
									<?php
										echo ucwords($event['home_team']);
									?> 
									</a>
								</span> <?php $status = explode('-',$event['events_status']); ?>
							</div>
						</div>
						<?php  
						if($event['away_team']) {?>
						
						<div class="col-sm-1 hidden-xs no-pad  tablet-data1 text-center-event">
							<div class="vs-match">VS</div>
							<div class="result-outer">
							<span class="score1"> <?php if($status[0] == '') { echo "-"; } else { echo $status[0]; }  ?> </span> &nbsp;:&nbsp;
							<span class="score2"> <?php if($status[1] == '') { echo "-"; } else { echo $status[1]; }  ?> </span>
							</div>
						</div>
						<div class="col-sm-5 no-pad tablet-data1 dev-float-right text-right">
							<div class="team-data2">
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['away_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['away_team']));?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                           <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
								<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['away_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
								<?php } else if($event['away_team_logo'] == '' || $event['away_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
																		<?php } else { ?>
									<img src="<?php echo $event['away_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
							</div>
						</div>
                        <?php } ?>
					</div>
				</td>
				<td style="vertical-align: middle;">
				<?php if(date('Y-m-d H:i:s', (strtotime($event['end_date']))) < $current_date){ ?>
				
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">Highlight</a>
					</div>
					
				<?php } else { ?>
					<div class="view-event <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) { } else { ?> <?php echo $this->session->userdata('session_color').'-view-event'; } ?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>watch/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Event</a>
					</div>
				<?php } ?>
				</td>
				<td style="display:none"></td>
			</tr>
		<?php } 
		}
			
		else{ //---------------------------HERE TO COPY---------------------------------------------------------------------
			//when competition name is selected from the front!

			$events2 = $this->index_model->ajax_events_competition($competition,$value,$datepick);
			
			//echo "<pre>";print_r($events2);exit;
			if($events2)
			{	?>
				<div class="compete" id="compete" style="display:none;">
				<?php //echo "<option id='sport_id' type='hidden' value='all'>All Sports</option>";?>
				<?php
				$exist = array();
				//when sports get selected on competition change.
				echo "<option id='sport_id' value=''>All Sports</option>";
				foreach($events2 as $myevent) {
					//Do Not Repeat if same Sport id exists in array more then once
						if(!in_array($myevent['sport_category_id'], $exist, TRUE)){ 
						echo "<option id='sport_id' type='hidden' value='".$myevent['sport_category_id']."'>".ucwords(strtolower($myevent['category_name']))."</option>";
						$exist[] = $myevent['sport_category_id'];
					}
				
				 }//end of foreach loop ?>
				</div>
			<?php foreach($events2 as $event){ ?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
			 <?php if($nation_sport_id) { } else {?>
				<td class="brdr-right">
					<div class="event-data ">
						<div class="text-left">
							<img  class="team-img-bg <?php echo $this->session->userdata('session_color');?>-team-img-bg" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo $event['sport_logo'];?>">
						</div>
						<!--
						<div class="col-xs-9 text-left sports-name">
							<p><?php //echo $event['category_name'] ?></p><!--<a href="#">Live</a>
						</div>
						-->
					</div>
				</td> <?php } ?>
				<td class="brdr-right">
					<div class="date-data">
					
						<div id="data_<?php echo $event['id'] ?>" class="date-circle <?php echo $this->session->userdata('session_color');?>-date-circle">	<?php echo  date("j", (strtotime($event['start_date'])));?>
							 <?php echo date('M', (strtotime($event['start_date'])));?>
						</div>
						 
						<div class="time-content">
							<?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?>
							
							<span class="match_time" style="color:red; font-size:12px;"  
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?> " 
								data-id="<?php echo $event['id'] ?>">
								<?php echo date('H:i', (strtotime($event['start_date'])+$new_session_time));?>
								</span>
								<?php } else { ?>
								<span class="match_time"
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?>"
								data-id="<?php echo $event['id'] ?>"
								><?php echo  date('H:i', (strtotime($event['start_date'])+ $new_session_time));?></span><?php } ?>
						</div>
					</div>
				</td>
				<td class="brdr-right">
					<div class="event-data eventdata-main" style="text-align:center">
						<span class="cont-flag">
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/<?php echo ucwords($nation).'.png';?>" alt="">
						</span>

						<span>
						<a href="<?php echo base_url();?>nations/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?>">
								<?php
								if(strlen($event['nation'])>25) {
								echo ucwords(substr($event['nation'],0,25)).'..';
								}
								else if(strlen($event['nation']) == 3){
									echo ucwords(strtoupper($event['nation']));
								} else {
									echo ucwords(strtolower($event['nation']));
								}
								?> 
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else if($event['comp_logo'] == '' ){?> <img src=" images/competitions/default.png" alt=""> <?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>competitions/<?php echo $event['competition_id'];?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?> ">
								<?php
								if($event['category_name']== "Tennis" || $event['category_name']== "Golf" || $event['category_name']== "MotorSports"){
									
									if(strpos($event['competition_name'], ',')){
										$name=explode(',',ucwords(strtolower($event['competition_name'])));
										echo ucwords(strtolower($name[1]));
									} else {
										echo ucwords(strtolower($event['competition_name']));
									}
									
									
								}else{
								if(strlen($event['competition_name'])>25) {
									echo ucwords(substr($event['competition_name'],0,25)).'..';
								}
								else if(strlen($event['competition_name']) == 3){
									echo ucwords(strtoupper($event['competition_name']));
								} else {
									echo ucwords(strtolower($event['competition_name']));
								}
								}
								?> 
							</span>
						</a>
					</span>	
				</td>
				<td colspan="2" class="brdr-right">
					<div class="">
						<div class="<?php if($event['away_team']) {?>col-sm-5 no-pad tablet-data1 dev-float-left<?php } else {?>col-sm-12 no-pad  tablet-data1 dev-float-left<?php } ?>">
							<div class="team-data1">
							<span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['home_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
									<?php } else if($event['home_team_logo'] == '' || $event['home_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
									
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">
									<?php
										echo ucwords($event['home_team']);
									?> 
									</a>
								</span> <?php $status = explode('-',$event['events_status']); ?>
							</div>
						</div>
						<?php  
						if($event['away_team']) {?>
						
						<div class="col-sm-1 hidden-xs no-pad  tablet-data1 text-center-event">
							<div class="vs-match">VS</div>
							<div class="result-outer">
							<span class="score1"> <?php if($status[0] == '') { echo "-"; } else { echo $status[0]; }  ?> </span> &nbsp;:&nbsp;
							<span class="score2"> <?php if($status[1] == '') { echo "-"; } else { echo $status[1]; }  ?> </span>
							</div>
						</div>
						<div class="col-sm-5 no-pad tablet-data1 dev-float-right text-right">
							<div class="team-data2">
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['away_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['away_team']));?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                                <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
								<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$event['away_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" style="width:28px; float:left;">
									<?php } else {?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
								<?php } else if($event['away_team_logo'] == '' || $event['away_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
																		<?php } else { ?>
									<img src="<?php echo $event['away_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
							</div>
						</div>
                        <?php } ?>
					</div>
				</td>
				<td style="vertical-align: middle;">
				<?php if(date('Y-m-d H:i:s', (strtotime($event['end_date']))) < $current_date){ ?>
				
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">Highlight</a>
					</div>
					
				<?php } else { ?>
					<div class="view-event <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) { } else { ?> <?php echo $this->session->userdata('session_color').'-view-event'; } ?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>watch/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Event</a>
					</div>
				<?php } ?>
				</td>
				<td style="display:none"></td>
				
			</tr>
	<?php 	} 
			}else {	
					echo "No Events Found For This Competition";
			}
		}
	}
	public function change_nation_by_load_events(){
		$rss = $this->load->database('rss', TRUE);
		$change_nation = $this->input->post('value');
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) - ($my_timezone * 60 * 60));
		$converted_datetime = date('Y-m-d H:i:s', $date_time);
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$rss->select('rss_events.id,rss_events.sport_category_id,rss_events.nation');
		$rss->where('DATE(rss_events.start_date) >=',$converted_date );
		$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );
		$rss->order_by('start_date','aesc');
		$rss->group_by('rss_events.nation');
		$nation = $rss->get('rss_events')->result_array();
		echo "<option value=''>All Nations</option>";
		foreach($nation as $name){
			echo "<option value=".str_replace(' ', '-', $name['nation']).">".ucwords($name['nation'])."</option>";
		} 
	}
	public function change_sports_by_load_events(){
		
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) - ($my_timezone * 60 * 60));
		$converted_datetime = date('Y-m-d H:i:s', $date_time);
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$change_nation = $this->input->post('value');
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_sport_category.id,rss_sport_category.category_name');
		$rss->where('DATE(rss_events.start_date) >=',$converted_date );
		$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );
		$rss->order_by('rss_events.start_date','aesc');
		$rss->join('rss_events','rss_events.sport_category_id=rss_sport_category.id');
		$rss->join('rss_competition','rss_competition.sport_cat_id=rss_sport_category.id');
		$rss->group_by('rss_sport_category.id');
		$sports = $rss->get('rss_sport_category')->result_array();
		echo "<option value=''>All Sports</option>";
		foreach($sports as $sport){
			echo "<option value=".$sport['id'].">".$sport['category_name']."</option>";
		} 
	}
	public function change_competitions_by_load_events(){
		$rss = $this->load->database('rss', TRUE);
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) - ($my_timezone * 60 * 60));
		$converted_datetime = date('Y-m-d H:i:s', $date_time);
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');
		
		$change_nation = $this->input->post('value');
		$rss->select('rss_competition.competition_id,rss_competition.competition_name');
		$rss->where('DATE(rss_events.start_date) >=',$converted_date );
		$rss->where('DATE(rss_events.start_date) <=',$session_date_tommorrow );
		$rss->join('rss_events','rss_events.competition_id=rss_competition.competition_id');
		$rss->order_by('rss_events.start_date','aesc');
		$rss->group_by('rss_competition.competition_id');
		$competition = $rss->get('rss_competition')->result_array();
		
		echo "<option value=''>All Competitions</option>";
		foreach($competition as $name){
			echo "<option value=".$name['competition_id'].">".ucwords($name['competition_name'])."</option>";
		}
		
	}
	
	public function get_myteam_event($id = NULL,$slug=NULL){
		//echo $id;exit;
		//echo $slug;exit;
		
		// $rss->select('id');
		// $rss->where('event_slug',$slug);
		// $get_event_id = $rss->get('rss_events')->result_array();
		// $id = $get_event_id[0]['id'];
		
		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		$this->data['footer'] = $this->index_model->get_footer_content();
		
		$this->data['news1'] = $this->index_model->get_news1();
		//$this->data['footer_events'] = $this->index_model->get_footer_events();
		
		$this->data['get_myteam_events'] = $this->index_model->get_myteam_events($id);
		
		$get_sports = $this->index_model->get_all_sports();
		$this->data['sports_arr'] = $get_sports['sports_arr'];
		$this->data['sports_count'] = $get_sports['sports_count'];
		$this->data['stream'] = $this->index_model->get_streams($id); 
		$this->data['sponsored_stream'] = $this->index_model->get_sponsored_streams($id); 
		
		//echo "<pre>";print_r($this->data['stream']);exit;
		$this->data['p2p'] = $this->index_model->get_streams_p2p($id); 
		
		$get_team_events = $this->data['get_myteam_events'];
		if($get_team_events[0]['category_name'] == "Soccer") { $get_team_events[0]['category_name'] = "Football"; }
		//Meta Title
			$meta_tag = $this->index_model->meta_tags5();
			//echo "<pre>";print_r($meta_tag);exit;
			$this->data['meta_title'] = $meta_tag[0]['title'];
			$meta_tag[0]['title'] =  $this->uri->segment(2);
			// Meta Description 
			$this->data['meta_description'] = '<meta name="description" content="'.$meta_tag[0]['description'].'">';
			// Meta Keywords
			$this->data['meta_keyword'] = '<META name="keywords" content="'.$meta_tag[0]['keywords'].'">';
			// Meta Article
			$this->data['meta_article'] = $meta_tag[0]['article'];
		//End Of Meta
		$this->data['event_id'] = $id;
		$this->load->view('view_team_events',$this->data);
	}
	public function get_team_events_highlights($id = NULL,$slug=NULL){
		
		// $rss->select('id');
		// $rss->where('event_slug',$slug);
		// $get_event_id = $rss->get('rss_events')->result_array();
		// $id = $get_event_id[0]['id'];
		
		
		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		$this->data['footer'] = $this->index_model->get_footer_content();
		
		$this->data['news1'] = $this->index_model->get_news1();
		//$this->data['footer_events'] = $this->index_model->get_footer_events();
		$this->data['get_myteam_events'] = $this->index_model->get_myteam_events($id);
		$get_sports = $this->index_model->get_all_sports();
		$this->data['sports_arr'] = $get_sports['sports_arr'];
		$this->data['sports_count'] = $get_sports['sports_count'];
		$this->data['highlight'] = $this->index_model->get_highlights($id); 
		
		$get_highlight = $this->index_model->get_highlights($id);
		
		$this->data['highlight_arr'] = $get_highlight['highlight_arr'];
		$this->data['highlight_count'] = $get_highlight['highlight_count'];
		
		$highlight_arr = $this->data['highlight_arr'];
		
		//Meta Title
			$meta_tag = $this->index_model->meta_tags6();
			//echo "<pre>";print_r($meta_tag);exit;
			$this->data['meta_title'] = $meta_tag[0]['title'];
			// Meta Description 
			$this->data['meta_description'] = '<meta name="description" content="'.$meta_tag[0]['description'].'">';
			// Meta Keywords
			$this->data['meta_keyword'] = '<META name="keywords" content="'.$meta_tag[0]['keywords'].'">';
			// Meta Article
			$this->data['meta_article'] = $meta_tag[0]['article'];
		//End Of Meta
		
		$this->load->view('view_team_highlights',$this->data);
	}
	public function get_video(){
		$rss = $this->load->database('rss', TRUE);
		$category = $this->input->post('category');
		$event_id = $this->input->post('event_id');
		$rss->select('*');
		$rss->where('type',$category);
		$rss->where('event_id_highlight',$event_id);

		$highlight = $rss->get('rss_highlight')->result_array();
		
		//echo "<pre>"; print_r($highlight);exit;
		if($highlight){
		$related_highlights = "";
		$first_video =  $highlight[0]['url'];
		
		foreach($highlight AS $each_light){
			//if($highlight[0]['url'] != $each_light['url']){
				// $related_highlights[]=$each_light['url'];
				$related_highlights = $related_highlights."".'<li>
					<a href="javascript:;" class="button" style="color:black;" onClick="change_video('.$each_light['id'].')"><div class="video-tumbnail"><img src="http://dev.ejuicysolutions.com/wiziwig/assets/images/myimages/images/video3.jpg"></div></a>
				</li>';
			//} 
		} 
		echo json_encode(array('first_video' => $first_video,'related_videos'=>$related_highlights));
		} else {
			$error = 'No Results';
			echo json_encode($error);
		}
	}
	
	public function get_selected_video(){
		$rss = $this->load->database('rss', TRUE);
		//echo $this->input->post("vid_id");
		$rss->where('id',$this->input->post("vid_id"));
		$highlight = $rss->get('rss_highlight')->result_array();
		//echo "<pre>";print_r($highlight);
		echo $highlight[0]["url"];
	}
	
	public function sport_event($sport_name){
		
		$rss = $this->load->database('rss', TRUE);
		//echo $sport_name;exit;
		$this->data['sport_name'] = $sport_name; 
		if($sport_name == "football" OR $sport_name == "Football") { $sport_name = "Soccer"; }
		if(!$this->session->userdata('date_timezone')){
			$this->load->view('get_date', $this->data);
			//exit;
		} else {
			$name = str_replace('-', ' ',$sport_name); 
			$rss->select('id');
			$rss->where('category_name',$name);
			$sport_id = $rss->get('rss_sport_category')->result_array();
			$competition_name=$this->index_model->get_sport_competition_by_name($sport_id[0]['id']);
			//print_r($competition_name);
			//echo "<pre>";print_r($competition_name);exit;
			$this->data['competition_name']=$competition_name;
			$this->data['get_my_header'] = $this->index_model->get_header_menus();
			$this->data['footer'] = $this->index_model->get_footer_content();
			//$this->data['footer_events'] = $this->index_model->get_footer_events();
			$this->data['news1'] = $this->index_model->get_news1();
			$get_sports = $this->index_model->get_all_sports();

			$this->data['sports_arr'] = $get_sports['sports_arr'];
			$this->data['sports_count'] = $get_sports['sports_count'];
			$this->data['get_sport_events'] = $this->index_model->get_sport_events($sport_id[0]['id']);
			$get_sport_events = $this->data['get_sport_events'];
			//print_r($get_sport_events);
			if($sport_name == "Soccer") { $sport_name = "Football"; } 
			
			//Meta Title
			
			$meta_tag = $this->index_model->meta_tags4($sport_id[0]['id']);
			$this->data['meta_title'] = $meta_tag[0]['title'];
			$this->data['meta_description'] = '<meta name="description" content="'.$meta_tag[0]['description'].'">';
			$this->data['meta_keyword'] = '<META name="keywords" content="'.$meta_tag[0]['keywords'].'">';
			$this->data['meta_article'] = $meta_tag[0]['article'];
			
			//End Of Meta
			
			$this->data['sport'] = $sport_name; 
		
			$this->data['sport_id_for_calender'] = $sport_id[0]['id'];
			$this->load->view('view_sport_events',$this->data);
		}
	}
	public function team_events($team_id = NULL,$slug=NULL) {
		
		// echo $slug;
		// $rss->select('id');
		// $rss->where('team_slug',$slug);
		// $get_team_id = $rss->get('rss_team')->result_array();
		// $team_id = $get_team_id[0]['id'];
		
		if($team_id){
		$this->data['get_team_events'] = $this->index_model->get_team_events($team_id);
		$this->data['get_last_team_events'] = $this->index_model->get_last_team_events($team_id);
		$get_team_events = $this->data['get_team_events'];
		
		if($get_team_events[0]['category_name'] == "Soccer") { $get_team_events[0]['category_name'] = "Football"; }
		}
		
		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		$this->data['footer'] = $this->index_model->get_footer_content();
		//$this->data['footer_events'] = $this->index_model->get_footer_events();
		$this->data['news1'] = $this->index_model->get_news1();
		$get_sports = $this->index_model->get_all_sports();
		$this->data['sports_arr'] = $get_sports['sports_arr'];
		$this->data['sports_count'] = $get_sports['sports_count'];
		$this->data['get_sport_events'] = $this->index_model->get_sport_events($sport_id);
		$get_sport_events = $this->data['get_sport_events'];
		
		
		//Meta Title
		$meta_tag= $this->index_model->meta_tags3($team_id);
		$this->data['meta_title'] = $meta_tag[0]['title'];
		// Meta Description 
		$this->data['meta_description'] = '<meta name="description" content="'.$meta_tag[0]['description'].'">';
		// Meta Keywords
		$this->data['meta_keyword'] = '<META name="keywords" content="'.$meta_tag[0]['keywords'].'">';
		// Meta Article
		$this->data['meta_article'] = $meta_tag[0]['article'];
		//End Of Meta
		$this->data['team_id_for_calender'] = $team_id;
		$this->load->view('view_all_team_events',$this->data);	
	
	}
	public function get_my_event($event_id = NULL) {
	
		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		$this->data['footer'] = $this->index_model->get_footer_content();
		//$this->data['footer_events'] = $this->index_model->get_footer_events();
		$this->data['news1'] = $this->index_model->get_news1();
		$get_sports = $this->index_model->get_all_sports();
		$this->data['sports_arr'] = $get_sports['sports_arr'];
		$this->data['sports_count'] = $get_sports['sports_count'];
		$this->data['get_sport_events'] = $this->index_model->get_sport_events($sport_id);
		$get_sport_events = $this->data['get_sport_events'];
		
		if($event_id){
		$this->data['get_team_events'] = $this->index_model->get_team_from_view_events($event_id);
		$get_team_events = $this->data['get_team_events'];
		
		if($get_team_events[0]['category_name'] == "Soccer") { $get_team_events[0]['category_name'] = "Football"; }
		// Meta TAgs
		
		$this->data['meta_title'] = ucwords($get_team_events[0]['home_team']).' - '.ucwords($get_team_events[0]['away_team']).' / '.ucwords($get_team_events[0]['category_name']).' / '.date('d',strtotime($get_team_events[0]['start_date'])).' '.date('F',strtotime($get_team_events[0]['start_date'])).' / '.' RealStreamSports';
		
		$this->data['meta_description'] = '<meta name="description" content="Watch RealSportsStreams Live Online '.ucwords($get_team_events[0]['home_team']).' - '.ucwords($get_team_events[0]['away_team']).' ('.date('Y-m-d',strtotime($get_team_events[0]['start_date'])).'). Real-Sports Live Stream ('.ucwords($get_team_events[0]['category_name']).') '.ucwords($get_team_events[0]['home_team']).' - '.ucwords($get_team_events[0]['away_team']).' RealStreamSports'.'">';
		}
		
		$this->data['view_events_id'] = $event_id;
		$keyword = $this->db->get('kt_keyword')->result_array();
		$this->data['meta_keyword'] = '<META name="keywords" content="'.$keyword[0]['keyword'].'">';
		// End of meta tags
		$this->data['team_id_for_calender'] = $team_id;
		$this->load->view('view_all_team_events',$this->data);	
	}
	public function nation_events($nation,$sport_name = NULL){
		if($sport_name == "Football") { $sport_name = "Soccer"; }
		$name = str_replace('-', ' ',$sport_name);
		$this->db->select('id');
		$this->db->where('category_name',$name);
		$sport_id = $this->db->get('kt_sport_category')->result_array();
		if($sport_name== "Soccer")
		{
		$this->data['sport']='Football';	
		}else{
		$this->data['sport']=$sport_name;
		}
		if($sport_name){
			if($sport_name== "Soccer"){
				$sport_name="Football";
			$this->data['nation_name']=$nation.' - '.$sport_name;
			}else
			{
				$this->data['nation_name']=$nation.'-'.$sport_name;
			}
			$competition_by_nation_and_game=$this->index_model->get_sport_competition_by_nation_by_game($nation,$sport_id[0]['id']);
			$this->data['competition_by_nation']=$competition_by_nation_and_game;
		}else{
			$this->data['nation_name']=$nation;
			$competition_by_nation=$this->index_model->get_sport_competition_by_nation($nation);
		$this->data['competition_by_nation']=$competition_by_nation;
		}
		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		$this->data['footer'] = $this->index_model->get_footer_content();
		//$this->data['footer_events'] = $this->index_model->get_footer_events();
		$this->data['news1'] = $this->index_model->get_news1();
		$get_sports = $this->index_model->get_all_sports();
		$this->data['sports_arr'] = $get_sports['sports_arr'];
		$this->data['sports_count'] = $get_sports['sports_count'];
		$this->data['get_sport_events'] = $this->index_model->get_sport_events($sport_id[0]['id']);
		$newnation = str_replace('%20', '-', $nation);
		
		$this->data['nation_sport_id'] = $sport_id[0]['id'];
		$this->data['get_nation_events'] = $this->index_model->get_nation_events($newnation,$sport_id[0]['id']);
		$this->data['get_last_nation_events'] = $this->index_model->get_last_nation_events($newnation,$sport_id[0]['id']);
		$get_nation_events = $this->data['get_nation_events'];
		//Meta
		
		//Meta Title
	//	echo $nation;exit;
		$meta_tag= $this->index_model->meta_tags($nation);
		$this->data['meta_title'] = $meta_tag[0]['title'];
		// Meta Description 
		$this->data['meta_description'] = '<meta name="description" content="'.$meta_tag[0]['description'].'">';
		// Meta Keywords
		$this->data['meta_keyword'] = '<META name="keywords" content="'.$meta_tag[0]['keywords'].'">';
		// Meta Article
		$this->data['meta_article'] = $meta_tag[0]['article'];
		//End Of Meta
		//echo '<pre>';print_r($this->data['get_nation_events']);exit;
		$this->load->view('view_all_nation_events',$this->data);
	}
	public function competition_events($competition_id = NULL,$competition_name = NULL){
	//	echo $competition_id = str_replace('-',' ',$competition1);
		//echo $competition;exit;
		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		$this->data['footer'] = $this->index_model->get_footer_content();
		//$this->data['footer_events'] = $this->index_model->get_footer_events();
		$this->data['news1'] = $this->index_model->get_news1();
		$get_sports = $this->index_model->get_all_sports();
		$this->data['sports_arr'] = $get_sports['sports_arr'];
		$this->data['sports_count'] = $get_sports['sports_count'];
		$this->data['get_sport_events'] = $this->index_model->get_sport_events($sport_id);
		$this->data['get_last_competition_events'] = $this->index_model->get_last_competition_events($competition_id);
		$this->data['get_future_competition_events'] = $this->index_model->get_future_competition_events($competition_id);
		$this->data['get_competition_events'] = $this->index_model->get_competition_events($competition_id);
		//echo "<pre>";print_r($this->data['get_competition_events']);exit;
		$get_competition_events = $this->data['get_competition_events'];

		// Meta TAgs
		//echo $competition_id;exit;
		$meta_tag = $this->index_model->meta_tags2($competition_id);
		//echo "<pre>";print_r($meta_tag);exit;
		$this->data['meta_title'] = $meta_tag[0]['title'];;
		
		$this->data['meta_description'] = '<meta name="description" content="'.$meta_tag[0]['description'].'">';
		
		$this->data['competition_id']=$competition_id;
		$this->data['meta_keyword'] = '<META name="keywords" content="'.$meta_tag[0]['keywords'].'">';
		$this->data['meta_article'] = $meta_tag[0]['article'];
		//End Of MEta TAgss
		$this->load->view('view_all_competition_events',$this->data);
	}
	
	
	public function ratings(){
		$stream_id = $_POST['id'];
		$action = $_POST['positive'];
		$event_id = $_POST['event_id'];
		$rss = $this->load->database('rss', TRUE);
		//echo $stream_id;exit;
		//echo $action;
		//echo $event_id;exit;
		$rss->select('stream_rating');
		$rss->where('id',$stream_id);
		$myratings = $rss->get('rss_streams')->result_array();
		
		$rating =  $myratings[0]['stream_rating'];
		
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$insert_array = array(
		'stream_id' => $stream_id,
		'action' => $action,
		'ip_address' => $ipaddress
		);
		$result = $rss->insert('rss_stream_rating',$insert_array);
		if($result){
			if($action ==1){

				$update_array = array(
			'stream_rating' => $rating+10,
			);
				$rating = $rating+10;
			}else{
			$update_array = array(
			'stream_rating' => $rating-10,
			);
			$rating = $rating-10;
			}
			
			$rss->where('id',$stream_id);
			$update = $rss->update('rss_streams',$update_array);
			if($update){
				//redirect('home/get_myteam_event/'.$event_id.'');exit;
				echo $rating;
			}else{
				echo "UPDATE FAILED";exit;
			}
			
		}else{
			echo "Something went wrong when inserting data</br>";exit;
		}
	}
	public function my_menu(){
		 $this->data['get_my_header'] = $this->index_model->get_header_menus();
		 $this->data['footer'] = $this->index_model->get_footer_content();
		 //$this->data['footer_events'] = $this->index_model->get_footer_events();
		 $this->data['news1'] = $this->index_model->get_news1();
		// echo "<pre>";print_r($this->data['footer_events']);exit;
		 $this->load->view('includes/header', $this->data);
		 $this->load->view('includes/footer', $this->data);
	}
	/*public function news($slug = null){
		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		$this->data['footer'] = $this->index_model->get_footer_content();
		 $this->data['news1'] = $this->index_model->get_news1();
		 //$this->data['footer_events'] = $this->index_model->get_footer_events();
		$this->data['get_my_news'] = $this->index_model->get_news_by_id($slug);
		$this->data['news'] = $this->index_model->get_news();
		$this->load->view('news', $this->data);
	}*/
	 public function menu($menu_id = NULL) {
		 $this->data['footer'] = $this->index_model->get_footer_content();
        $this->data['get_my_header'] = $this->index_model->get_header_menus();
		 //$this->data['footer_events'] = $this->index_model->get_footer_events();
		  $this->data['news1'] = $this->index_model->get_news1();
		// echo "<pre>";print_r($this->data['footer_events']);exit;
        $this->data['get_my_header_data'] = $this->index_model->get_header_menus_data($menu_id);
        if ($menu_id == "contact-us") {
            $this->load->view("contact-us", $this->data);
        } else {
            $this->load->view('front_menu/menu_show', $this->data);
        }
    }
	public function live_channel_streaming(){
		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		$this->data['footer'] = $this->index_model->get_footer_content();
		//$this->data['footer_events'] = $this->index_model->get_footer_events();
		$this->data['news1'] = $this->index_model->get_news1();
		$get_sports = $this->index_model->get_all_sports();
		$this->data['sports_arr'] = $get_sports['sports_arr'];
		$this->data['sports_count'] = $get_sports['sports_count'];
		$this->data['live_streaming']=$this->index_model->live_streaming();
		$this->data['streams_logo'] = $this->index_model->get_live_streams_logo();
		$this->load->view('live_channel_stream',$this->data);
	}
	public function get_live_channel_streaming($id){
		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		$this->data['footer'] = $this->index_model->get_footer_content();
		//$this->data['footer_events'] = $this->index_model->get_footer_events();
		$this->data['news1'] = $this->index_model->get_news1();
		$get_sports = $this->index_model->get_all_sports();
		$this->data['sports_arr'] = $get_sports['sports_arr'];
		$this->data['sports_count'] = $get_sports['sports_count'];
		$this->data['streams_logo'] = $this->index_model->get_live_streams_logo();
		$this->data['live_streaming']=$this->index_model->get_live_streaming($id);
		
		
		
		$this->data['meta_title'] = 'RealStreamSports (Live TV)';
		
		$this->data['meta_description'] = '<meta name="description" content="You Are Watching Live TV.">';
		
		$keyword = $this->db->get('kt_keyword')->result_array();
		$this->data['meta_keyword'] = '<META name="keywords" content="'.$keyword[0]['keyword'].'">';
		
		$this->load->view('live_channel_stream',$this->data);
	}

	public function get_alternate_stream_channel(){
		$channel_id = $this->input->post('channel_id');
		if($channel_id){
			$channel_streams = $this->index_model->get_alternate_streams_channel($channel_id);
			foreach($channel_streams as $streams){?>
				<div class="abc" id="stream_content">
					<?php echo $streams['iframe_feeds'];?>
				</div>
				
			<?php }
		}
		
	}

    public function register() {
        if ($this->session->userdata('front_user_id') == '') {
            $first_name = $this->input->post("fname");
            //$middle_name = $this->input->post("mname");
            $last_name = $this->input->post("lname");
            $full_name = trim($first_name)." ".trim($last_name);
            $user_name = $this->input->post("uname");

            $to = $this->input->post("email");
            $email_key = md5(rand() . microtime());

            $dob = $this->input->post("dob");
            $mobile_number = $this->input->post("mobnum");
            $password = $this->input->post("password");
            $password = $this->tank_auth->admin_password_hash($password);
           // $country = $this->input->post("country");
         //   $country_name = $this->index_model->get_country($country);
          //  $name_count = $country_name[0]['Country'];
           // $state = $this->input->post("stateDropdown");
            //$twitch = $this->input->post("twitchid");
            $address = $this->input->post("address");
            $slug = $this->index_model->format_uri($full_name);
            $slug = trim($slug, '-');
            $slug = $this->index_model->member_slug_generator($slug);

            $insert_array = array(
                "first_name" => $first_name,
                //"middle_name" => $middle_name,
                "last_name" => $last_name,
                "profile_image" => 'default.jpg',
                "user_name" => $user_name,
                "date_of_birth" => $dob,
                "email_address" => $to,
                "password" => $password,
                "mobile_number" => $mobile_number,
               // "country" => $name_count,
               // "state" => $state,
                //"twitch_id" => $twitch,
                "front_user_address" => $address,
                "created_date" => date("Y-m-d H:i:s"),
                "front_user_name_slug" => $slug,
                "front_user_email_key" => $email_key
            );
			
            $query = $this->db->insert("sg_front_users", $insert_array);
            if ($query) {
                $front_user_id = $this->db->insert_id();
             //   $sql = $this->db->insert("kt_sg_wallet", array("user_id" => $front_user_id));
            //    if ($sql) {
					
                    $this->_send_email_admin($insert_array,$front_user_id);
                    $this->session->set_flashdata('message', 'Signup Successful, A Verification Email has been sent');
                    redirect('');
                    $this->session->set_flashdata('error', 'Something went wrong, please try again later');
                    redirect('');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, please try again later');
                redirect('');
            }
        } else {
            redirect('home/dashboard');
        }
    }
	

    public function verify_signup($email_key, $front_user_id) {
        $this->db->where("front_user_id", $front_user_id);
        $this->db->where("front_user_email_key", $email_key);
        $this->db->update("sg_front_users", array("email_verify" => "yes", "front_user_flag" => "active"));
        redirect('');
    }

    public function validate_email() {
        $email = $this->input->post("email");
        $this->db->where("email_address", $email);
        $query = $this->db->count_all_results('sg_front_users');
        if ($query > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }


    public function validate_uname() {
        $username = $this->input->post("uname");
        $this->db->where("user_name", $username);
        $query = $this->db->count_all_results('sg_front_users');
        if ($query > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }

    public function get_states() {
        $id = $this->input->post("country");
        $this->db->select("RegionID as id, Region as name");
        $this->db->where('CountryID', $id);
        $this->db->group_by('RegionID');
        $query = $this->db->get('kt_state')->result_array();
        echo json_encode($query);
    }
	public function contact(){
		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		$this->data['footer'] = $this->index_model->get_footer_content();
		//$this->data['footer_events'] = $this->index_model->get_footer_events();
		$this->data['news1'] = $this->index_model->get_news1();
		$get_sports = $this->index_model->get_all_sports();
		$this->data['sports_arr'] = $get_sports['sports_arr'];
		$this->data['sports_count'] = $get_sports['sports_count'];
		
		$this->load->model('captcha/mod_captcha');
		$this->data['captcha_image'] = $this->mod_captcha->creat_captcha();
		$this->load->view('contact_us',$this->data);
	}
    public function contact_us() {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $message = $this->input->post('message');
        $message = html_entity_decode($message);
        
		$captcha_code = trim($this->input->post('captcha_code'));
		
		$this->load->model('captcha/mod_captcha');
		$isvalid_captcha = $this->mod_captcha->chk_isvalid_captcha($captcha_code);
		if($isvalid_captcha == 0){
			$this->session->set_flashdata("message", "Please Enter  Correct Captcha");
            redirect('home/contact');
		}
		if ($name == "") {
            $this->session->set_flashdata("message", "Please Enter  Name");
            redirect('home/contact');
        }
		if ($email == "") {
            $this->session->set_flashdata("message", "Please Enter  Email");
            redirect('home/contact');
        }
		if ($phone == "") {
            $this->session->set_flashdata("message", "Please Enter  Phone");
            redirect('home/contact');
        }
		
		if ($message == "") {
            $this->session->set_flashdata("message", "Please Enter  message");
            redirect('home/contact');
        }
        if ($name != "" && $email != "" && $message != "") {

            $this->session->unset_userdata('first_name');
            $this->session->unset_userdata('email');
            $data['name'] = $name;
            $data['email'] = $email;
            $data['phone'] = $phone;
            $data['message'] = $message;
            $this->_send_email_contact($data);
            $this->session->set_flashdata("ok_message", "Your Request Submited Successfully");
            redirect('home/contact');
        }
    }
	function _send_email_contact($data) {
		
        $this->db->where("email_type","contact-us");
        $template1 = $this->db->get("kt_email_template")->result();
		//echo "<pre>";print_r($template1);exit;
        $template = $template1[0]->message;
        $subject = $template1[0]->subject; 
        $reciever = $template1[0]->email;
        $to = $reciever;
        $email = trim($data['email']);
        $logo= base_url()."assets/images/happy-face.png";
        $headers = "From: " . $data['email'] . PHP_EOL;
        $headers .= "Reply-To: " . $data['email'] . PHP_EOL;
        $headers .= "MIME-Version: 1.0" . PHP_EOL;
        $headers .= "Content-Type: text/html; charset=ISO-8859-1" . PHP_EOL;
		$template = str_replace("%company_logo%",'<img src="'.$logo.'"  alt="" />',$template);
		$template = str_replace("%message%",$data['message'],$template);
	    $template = str_replace("%name%",$data['name'],$template);
		$template = str_replace("%phone%",$data['phone'],$template);
	    $template = str_replace("%email%",$data['email'],$template);
		$is_email = mail($to, $subject, $template, $headers);
		//echo "<pre>";print_r($is_email);exit;
		if($is_email)
		{
			return true;
		}
    }
	 public function _send_email_admin($updated_data,$front_user_id) {
         $this->db->where("email_type","user_registration"); 
         $template1=$this->db->get("kt_email_template")->result();
	      $template=$template1[0]->message;
	      $sender =$template1[0]->email;
	      $to = $updated_data['email_address'];		
          $subject = "Registration";		
	 $logo= base_url()."assets/login/images/logo.png";
	
	//$abc=  base_url()."home/step_2/".$data['cat_id'].'/'.$data['user_id'].'/'.$data['new_email_key'];
	$message = base_url()."home/verify_signup/" . $updated_data['front_user_email_key'] . "/" . $front_user_id;
	//$template= str_replace("%site_links%",'<a href="'.$abc.'">'.$data['site_name'].'</a>',$template);
	
	
	   //$template= str_replace("%password%",$pass,$template);
	   //$template= str_replace("%top_links%",'<h1>'.$data['site_name'].'</h1>',$template);
	   //$template= str_replace("%email%",$data['email'],$template);
	    $headers = "From: " . $sender . PHP_EOL;
        $headers .= "Reply-To: ". $sender . PHP_EOL;
        $headers .= "MIME-Version: 1.0" . PHP_EOL;
        $headers .= "Content-Type: text/html; charset=ISO-8859-1" . PHP_EOL;
	   
	   
	   
	   
	    $template = str_replace("%company_logo%",'<img src="'.$logo.'"  alt="" />',$template);
		$template = str_replace("%link%",'<a href="'.$message.'">here</a>',$template);
	  
	
	   $is_email = mail($to, $subject, $template, $headers);
	   
	   if($is_email)
	{

		return true;
	}
	   
	    
	        

    }


	
	public function get_data_for_name(){
		$this->db->select('kt_legu_teams.*,kt_sport_category.id As sport_id');
		$this->db->join('kt_sport_category','kt_sport_category.category_name = kt_legu_teams.strSport','left');
		$this->db->group_by('kt_legu_teams.id');
		$result = $this->db->get('kt_legu_teams')->result_array();
	//	echo "<pre>";print_r($result);
		if($result){
			foreach($result as $data){
				$team_id = $data['idTeam'];
				$team_name = $data['strTeam'];
				$team_sport = $data['strSport'];
				$team_badge_temp = $data['strTeamBadge'];
				$team_jersey = $data['strTeamJersey'];
				$team_logo = $data['strTeamLogo'];
				$sport_id = $data['sport_id'];
				
					if(trim($team_badge_temp) != '') {
					
					$content = file_get_contents($team_badge_temp);
					if(file_put_contents('./././images/'.substr($team_badge_temp, strrpos($team_badge_temp, '/') + 1), $content)) {
						$team_badge = substr($team_badge_temp, strrpos($team_badge_temp, '/') + 1);
					}else {
						$team_badge = 'default.jpg';
					}					
				}else {
					$team_logo = 'default.jpg';
				}
				// $insert_array = array(
				// 'l_team_id' => $team_id,
				// 'sport_cat_id' => $sport_id,
				// 'name' => $team_name,
				// 'l_team_sport' => $team_sport,
				// 'l_team_logo' => $team_logo,
				// 'l_team_jersey' => $team_jersey,
				// 'logo' => $team_badge
				// );
			
			
			// $insert = $this->db->insert('kt_team',$insert_array);
			// if($insert){
				// echo "success </br>";
			// }else{
				// echo "something went wrong </br>";
			// }
			}
		}
	}

			
public function get_data_for_league(){ //TO FETCH and Insert DATA FROM ONE TABLE AND INSERT IN ANOTHER AND SAVE IMAGE TO A FOLDER AS WELL...
	
	$this->db->select('*');
	$result = $this->db->get('kt_leagues')->result_array();
	//echo "<pre>";print_r($result);exit;

		

	if($result){
		foreach($result as $data){
			$league_name = $data['strLeague'];
			$sport_id = $data['sports_cat'];
			$league_website = $data['strWebsite'];
			$league_description = $data['strDescriptionEN'];
			$league_logo_temp = $data['strBadge'];
			$league_trophy_temp = $data['strTrophy'];
			
			if(trim($league_logo_temp) != '') {
				
				$content = file_get_contents($league_logo_temp);
				
				
				if(file_put_contents('./././images/leagues/'.substr($league_logo_temp, strrpos($league_logo_temp, '/') + 1), $content)) {
					$league_logo = substr($league_logo_temp, strrpos($league_logo_temp, '/') + 1);
				}else {
					$league_logo = 'default.jpg';
				}					
			}else {
				$league_logo = 'default.jpg';
			}
			
			// if(trim($league_trophy_temp) != '') {
				
				// $content = file_get_contents($league_trophy_temp);
				// if(file_put_contents('./././images/leagues_trophies/'.substr($league_trophy_temp, strrpos($league_trophy_temp, '/') + 1), $content)) {
				$league_trophy = substr($league_trophy_temp, strrpos($league_trophy_temp, '/') + 1);
				// }else {
					// $league_trophy = 'default.jpg';
				// }					
			// }else {
				// $league_trophy = 'default.jpg';
			// }
			
			$insert_array = array(
			'league_name' => $league_name,
			'sport_id' => $sport_id,
			'league_website' => $league_website,
			'league_description' => $league_description,
			'logo' => $league_logo,
			'league_trophy' => $league_trophy
		);
		
		
		$insert = $this->db->insert('kt_league',$insert_array);
		if($insert){
			echo "success </br>";
		}
		else
		{
			echo "something went wrong </br>";
		}
		}
	}
}	
	public function get_date(){
		$my_date = $this->input->post('date');
		$date = date("Y-m-d",strtotime($my_date));
		$this->session->set_userdata('session_date',$date);
		$this->session->userdata('session_date');
		
		$my_date_time = $this->input->post('date_time');
		
		$date_time = date("Y-m-d H:i:s",strtotime($my_date_time));
		$this->session->set_userdata('session_date_time',$date_time);
		$this->session->userdata('session_date_time');
	}
	
	public function show_live_events_filter(){
		$new_session_time= $this->session->userdata('time_formate') * 60 * 60;
		$current_date = gmdate('Y-m-d H:i:s');
		
		$rss = $this->load->database('rss', TRUE);
		$live = $this->input->post('live');
		if($live == 'live'){
			$get_live_events = $this->index_model->get_events_live_filter();
			
		} else if ($live == '') {
			$get_live_events = $this->index_model->get_events();
			//echo "here";exit;
		}	
			$session_time = $this->session->userdata('my_timezone'); 
				
			foreach($get_live_events as $event){
			$todays_date = date('Y-m-d',strtotime($event['start_date']));
			if( $todays_date == $this->session->userdata('session_date')){ 
			?>
			
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
				<td class="brdr-right">
					<div class="event-data ">
						<div class="text-left">
							<img  class="team-img-bg <?php echo $this->session->userdata('session_color');?>-team-img-bg" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo $event['sport_logo'];?>">
						</div>
						<!--
						<div class="col-xs-9 text-left sports-name">
							<p><?php //echo $event['category_name'] ?></p><!--<a href="#">Live</a>
						</div>
						-->
					</div>
				</td>
				<td class="brdr-right">
					<div class="date-data">
					
						<div id="data_<?php echo $event['id'] ?>" class="date-circle <?php echo $this->session->userdata('session_color');?>-date-circle">	<?php echo  date("j", (strtotime($event['start_date'])));?>
							 <?php echo date('M', (strtotime($event['start_date'])));?>
						</div>
						 
						<div class="time-content">
							<?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?>
							
							<span class="match_time" style="color:red; font-size:12px;"  
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?> " 
								data-id="<?php echo $event['id'] ?>">
								<?php echo date('H:i', (strtotime($event['start_date'])+$new_session_time));?>
								</span>
								<?php } else { ?>
								<span class="match_time"
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?>"
								data-id="<?php echo $event['id'] ?>"
								><?php echo  date('H:i', (strtotime($event['start_date'])+ $new_session_time));?></span><?php } ?>
						</div>
					</div>
				</td>
				<td class="brdr-right">
					<div class="event-data eventdata-main" style="text-align:center">
						<span class="cont-flag">
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/<?php echo ucwords($nation).'.png';?>" alt="">
						</span>

						<span>
						<a href="<?php echo base_url();?>nations/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?>">
								<?php
								if(strlen($event['nation'])>25) {
								echo ucwords(substr($event['nation'],0,25)).'..';
								}
								else if(strlen($event['nation']) == 3){
									echo ucwords(strtoupper($event['nation']));
								} else {
									echo ucwords(strtolower($event['nation']));
								}
								?> 
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else if($event['comp_logo'] == '' ){?> <img src=" images/competitions/default.png" alt=""> <?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>competitions/<?php echo $event['competition_id'];?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?> ">
								<?php
								if($event['category_name']== "Tennis" || $event['category_name']== "Golf" || $event['category_name']== "MotorSports"){
									
									if(strpos($event['competition_name'], ',')){
										$name=explode(',',ucwords(strtolower($event['competition_name'])));
										echo ucwords(strtolower($name[1]));
									} else {
										echo ucwords(strtolower($event['competition_name']));
									}
									
									
								}else{
								if(strlen($event['competition_name'])>25) {
									echo ucwords(substr($event['competition_name'],0,25)).'..';
								}
								else if(strlen($event['competition_name']) == 3){
									echo ucwords(strtoupper($event['competition_name']));
								} else {
									echo ucwords(strtolower($event['competition_name']));
								}
								}
								?> 
							</span>
						</a>
					</span>	
				</td>
				<td colspan="2" class="brdr-right">
					<div class="">
						<div class="<?php if($event['away_team']) {?>col-sm-5 no-pad tablet-data1 dev-float-left<?php } else {?>col-sm-12 no-pad  tablet-data1 dev-float-left<?php } ?>">
							<div class="team-data1">
								<span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['home_team_logo'] == ''){ ?>
									
									<img src="images/teams/default.png" style="width:28px; float:left;">
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">
									<?php
										echo ucwords($event['home_team']);
									?> 
									</a>
								</span> <?php $status = explode('-',$event['events_status']); ?>
							</div>
						</div>
						<?php  
						if($event['away_team']) {?>
						
						<div class="col-sm-1 hidden-xs no-pad  tablet-data1 text-center-event">
							<div class="vs-match">VS</div>
							<div class="result-outer">
							<span class="score1"> <?php if($status[0] == '') { echo "-"; } else { echo $status[0]; }  ?> </span> &nbsp;:&nbsp;
							<span class="score2"> <?php if($status[1] == '') { echo "-"; } else { echo $status[1]; }  ?> </span>
							</div>
						</div>
						<div class="col-sm-5 no-pad tablet-data1 dev-float-right text-right">
							<div class="team-data2">
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['away_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['away_team']));?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                               <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['away_team_logo'] == ''){ ?>
									<img src="images/teams/default.png" style="width:28px; float:left;">
									<?php } else { ?>
									<img src="<?php echo $event['away_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
							</div>
						</div>
                        <?php } ?>
					</div>
				</td>
				<td style="vertical-align: middle;">
					<!-- Live Events -->
					<div class="view-event <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) { } else { ?> <?php echo $this->session->userdata('session_color').'-view-event'; } ?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>watch/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Event</a>
					</div>
				</td>
				<td style="display:none"></td>
				
			</tr> <?php } ?>
<?php  	}
	}
	public function filter_datepicker(){
		
		$new_session_time= $this->session->userdata('time_formate') * 60 * 60;
		$current_date = gmdate('Y-m-d H:i:s');
		
		
		$rss = $this->load->database('rss', TRUE);
		$my_date = $this->input->post('date');
		$date = date('Y-m-d', strtotime($my_date));
		$sport = $this->input->post('sport');
		$nation_calender = $this->input->post('nation_calender_filter');
		$nation_sport_id = $this->input->post('nation_sport_id');
		$team_id_for_calender = $this->input->post('team_id_for_calender');
		
		$competition_calender_id = $this->input->post('competition_calender_id');
		$datepicker_events = $this->index_model->get_datepicker_events($date,$sport,$nation_calender,$nation_sport_id,$competition_calender_id,$team_id_for_calender);
		//echo "<pre>";print_r($datepicker_events);exit;
		foreach($datepicker_events as $event){?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
			
				<?php if($sport){  } else { ?>
				<td class="brdr-right">
					<div class="event-data ">
						<div class="text-left">
							<img  class="team-img-bg <?php echo $this->session->userdata('session_color');?>-team-img-bg" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo $event['sport_logo'];?>">
						</div>
					</div>
				</td>
				<?php } ?>
				<td class="brdr-right">
					<div class="date-data">
					
						<div id="data_<?php echo $event['id'] ?>" class="date-circle <?php echo $this->session->userdata('session_color');?>-date-circle">	<?php echo  date("j", (strtotime($event['start_date'])));?>
							 <?php echo date('M', (strtotime($event['start_date'])));?>
						</div>
						 
						<div class="time-content">
							<?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?>
							
							<span class="match_time" style="color:red; font-size:12px;"  
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?> " 
								data-id="<?php echo $event['id'] ?>">
								<?php echo date('H:i', (strtotime($event['start_date'])+$new_session_time));?>
								</span>
								<?php } else { ?>
								<span class="match_time"
								data-year="<?php echo date('Y', strtotime($event['start_date']));?>"
								data-month="<?php echo date('m', strtotime($event['start_date']));?>"
								data-day="<?php echo date('d', strtotime($event['start_date']));?>"
								data-hour="<?php echo date('H', strtotime($event['start_date']));?>" 
								data-minute="<?php echo date('i', strtotime($event['start_date']));?>"
								data-secound="<?php echo date('s', strtotime($event['start_date']));?>"
								data-id="<?php echo $event['id'] ?>"
								><?php echo  date('H:i', (strtotime($event['start_date'])+ $new_session_time));?></span><?php } ?>
						</div>
					</div>
				</td>
				<td class="brdr-right">
					<div class="event-data eventdata-main" style="text-align:center">
						<span class="cont-flag">
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/<?php echo ucwords($nation).'.png';?>" alt="">
						</span>

						<span>
						<a href="<?php echo base_url();?>nations/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?>">
								<?php
								if(strlen($event['nation'])>25) {
								echo ucwords(substr($event['nation'],0,25)).'..';
								}
								else if(strlen($event['nation']) == 3){
									echo ucwords(strtoupper($event['nation']));
								} else {
									echo ucwords(strtolower($event['nation']));
								}
								?> 
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else if($event['comp_logo'] == '' ){?> <img src=" images/competitions/default.png" alt=""> <?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>competitions/<?php echo $event['competition_id'];?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?> ">
								<?php
								if($event['category_name']== "Tennis" || $event['category_name']== "Golf" || $event['category_name']== "MotorSports"){
									
									if(strpos($event['competition_name'], ',')){
										$name=explode(',',ucwords(strtolower($event['competition_name'])));
										echo ucwords(strtolower($name[1]));
									} else {
										echo ucwords(strtolower($event['competition_name']));
									}
									
									
								}else{
								if(strlen($event['competition_name'])>25) {
									echo ucwords(substr($event['competition_name'],0,25)).'..';
								}
								else if(strlen($event['competition_name']) == 3){
									echo ucwords(strtoupper($event['competition_name']));
								} else {
									echo ucwords(strtolower($event['competition_name']));
								}
								}
								?> 
							</span>
						</a>
					</span>	
				</td>
				<td colspan="2" class="brdr-right">
					<div class="">
						<div class="<?php if($event['away_team']) {?>col-sm-5 no-pad tablet-data1 dev-float-left<?php } else {?>col-sm-12 no-pad  tablet-data1 dev-float-left<?php } ?>">
							<div class="team-data1">
								<span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['home_team_logo'] == ''){ ?>
									
									<img src="images/teams/default.png" style="width:28px; float:left;">
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">
									<?php
										echo ucwords($event['home_team']);
									?> 
									</a>
									
									
									
								</span> <?php $status = explode('-',$event['events_status']); ?>
								
							</div>
						</div>
						<?php  
						if($event['away_team']) {?>
						
						<div class="col-sm-1 hidden-xs no-pad  tablet-data1 text-center-event">
							<div class="vs-match">VS</div>
							<div class="result-outer">
							<span class="score1"> <?php if($status[0] == '') { echo "-"; } else { echo $status[0]; }  ?> </span> &nbsp;:&nbsp;
							<span class="score2"> <?php if($status[1] == '') { echo "-"; } else { echo $status[1]; }  ?> </span>
							</div>
						</div>
						
						<div class="col-sm-5 no-pad tablet-data1 dev-float-right text-right">
							
							<div class="team-data2">
								
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['away_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['away_team']));?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                               <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<img src="images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['away_team_logo'] == ''){ ?>
									<img src="images/teams/default.png" style="width:28px; float:left;">
									<?php } else { ?>
									<img src="<?php echo $event['away_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
							</div>
						</div>
                        <?php } ?>
					</div>
				</td>
				<td style="vertical-align: middle;">
				<?php if(date('Y-m-d H:i:s', (strtotime($event['end_date']))) < $current_date){ ?>
				
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">Highlight</a>
					</div>
					
				<?php } else { ?>
					<div class="view-event <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) { } else { ?> <?php echo $this->session->userdata('session_color').'-view-event'; } ?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date']))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>watch/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Event</a>
					</div>
				<?php } ?>
				</td>
				<td style="display:none"></td>
				
			</tr>
<?php  	}
	}
	public function change_color(){
		$color = $this->input->post('color');
		$ip = $this->input->post('ip');
		
		$this->db->select('user_ip');
		$this->db->where('user_ip',$ip);
		$check = $this->db->get('kt_color')->num_rows();
		if($check > 0) {
			$update_data = array(
				'color' => $color,
				
			);
		$this->db->where('user_ip',$ip);
		$query = $this->db->update('kt_color',$update_data);
			if($query){
				//$this->session->userdata('session_color'); 
				$this->session->unset_userdata('session_color');
				$this->session->set_userdata('session_color',$color);
				$this->session->userdata('session_color');
				echo "success";
			}
		} else {
			$insert_data = array(
				'user_ip' => $ip,
				'color' => $color
			);
		$query = $this->db->insert('kt_color',$insert_data);
		}
	}
	public function my_model_method(){
		$get_data = $this->index_model->my_model_method();
	}
	public function getting_events(){
		$get_data = $this->index_model->get_events();
		echo  "<pre>";print_r($get_data);exit;
	}
	public function golf_leadersboards(){
		$get_data = $this->index_model->golf_leadersboard();
		echo "<pre>";print_r($get_data);
	}
	public function motorsport_result(){
		$get_motorsport_result = $this->index_model->motorsport_results();
		echo "<pre>";print_r($get_motorsport_result);
	}
	public function get_tennis(){
		$rss = $this->load->database('rss', TRUE);
		
		
		$rss->where('sport_name','tennis');
		//$rss->join('rss_events','rss_events.home_team = rss_players.player_name');
		$tennis = $rss->get('rss_players')->result_array();
		echo "<pre>";print_r($tennis);
	}
	//change nation by date picker
	public function filter_datepicker_nation(){
		$sport = $this->input->post('sport'); 
		$datepick = date('Y-m-d',strtotime($this->input->post('date')));
		
		$nation =  $this->index_model->datepicker_nation_filter_results($datepick,$sport);
		?><option value="" disabled selected> Nations </option> <?php
		foreach($nation as $name){ ?>
		
		<option value="<?php echo str_replace(' ', '-', $name['nation']);?>"><?php echo ucwords(strtolower($name['nation']));?></option>
		
		<?php }
	}
	public function filter_datepicker_sport(){
		$datepick = date('Y-m-d',strtotime($this->input->post('date')));
		$nation = $this->input->post('nation');
		$sports =  $this->index_model->datepicker_sports_filter_results($datepick,$nation);
		?><option value="" disabled selected> Sports </option> <?php
		foreach($sports as $sport){?>
			<option  value="<?php echo $sport['id'];?>"><?php if($sport['category_name'] == "Soccer") { $sport['category_name'] = "Football"; } echo ucwords(strtolower($sport['category_name']));?>
			</option>
			<?php }
	}
	public function filter_datepicker_competition(){
		$datepick = date('Y-m-d',strtotime($this->input->post('date')));
		$nation = $this->input->post('nation');
		$sport = $this->input->post('sport'); 
		
		$competition =  $this->index_model->datepicker_competitions_filter_results($datepick,$sport,$nation);
		?><option value="" disabled selected> Competitions </option> <?php
		foreach($competition as $name){?>
			<option value="<?php echo $name['competition_id'];?>"><?php echo ucwords(strtolower($name['competition_name']));?></option>
			<?php }
	}

}
