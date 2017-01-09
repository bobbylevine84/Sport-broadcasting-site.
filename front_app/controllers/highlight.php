<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Highlight extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->load->model("highlight/index_model");
    }
	public function my_upload_team(){
		$this->db->select('logo');
		$team_logo = $this->db->get('kt_team')->result_array();
		//echo "<pre>";print_r($team_logo);exit;

		foreach($team_logo as $t_logo){
			$str = $t_logo['logo'];
			
			$this->load->library('image_lib');
			$config['image_library'] = 'gd2';
			$config['source_image']	= "images/".$str;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	= "28px";
			$config['height']	= "28px";
			$config['new_image'] = "images/";//you should have write permission here..
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
		}
	}
	public function my_upload_competition(){
		$this->db->select('comp_logo');
		$competition_logo = $this->db->get('kt_nation_custom_text')->result_array();
		//echo "<pre>";print_r($competition_logo);exit;

		foreach($competition_logo as $c_logo){
			$str = $c_logo['comp_logo'];
			
			$this->load->library('image_lib');
			$config['image_library'] = 'gd2';
			$config['source_image']	= "images/leagues/".$str;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	= "30px";
			$config['height']	= "19px";
			$config['new_image'] = "images/leagues/";//you should have write permission here..
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
		}
	}
	public function my_upload_nation(){
		$this->db->select('flag_128');
		$nation_logo = $this->db->get('kt_country')->result_array();
		//echo "<pre>";print_r($competition_logo);exit;

		foreach($nation_logo as $n_logo){
			$str = $n_logo['flag_128'];
			
			$this->load->library('image_lib');
			$config['image_library'] = 'gd2';
			$config['source_image']	= "uploads/flags/".$str;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	= "30px";
			$config['height']	= "19px";
			$config['new_image'] = "uploads/flags/";//you should have write permission here..
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
		}
	}

    public function index($para = NULL) {
       if ($this->session->userdata('front_user_id') == '') {
            $url = site_url("home");
            $this->data['settings'] = $this->index_model->get_settings();
            $this->data['social_icons'] = $this->index_model->get_social_icons();
            $this->data['get_my_header'] = $this->index_model->get_header_menus();
            $this->data['games'] = $this->index_model->get_games();
            $this->data['events'] = $this->index_model->get_events();
            //$this->data['content'] = $this->index_model->get_content();
			$this->data['games'] = $this->index_model->get_my_games();
			$this->data['news1'] = $this->index_model->get_news1();
			$this->data['footer'] = $this->index_model->get_footer_content();
			//$this->data['footer_events'] = $this->index_model->get_footer_events();
			$this->data['get_sport_events'] = $this->index_model->get_sport_events($sports_id);
			
			$get_sports = $this->index_model->get_all_sports();
			$this->data['sports_arr'] = $get_sports['sports_arr'];
			$this->data['sports_count'] = $get_sports['sports_count'];
			//echo "<pre>"; print_r($this->data['sports_count']);exit; 
			
			$keyword = $this->db->get('kt_keyword')->result_array();
			$this->data['meta_keyword'] = '<META name="keywords" content="'.$keyword[0]['keyword'].'">';
			
            $this->load->view('highlight/highlight_header', $this->data);
        } else {
            redirect('home/dashboard');
        }
    }
	public function scrap_highlight(){
		 if ($this->session->userdata('front_user_id') == '') {
            $url = site_url("home");
            $this->data['settings'] = $this->index_model->get_settings();
            $this->data['social_icons'] = $this->index_model->get_social_icons();
            $this->data['get_my_header'] = $this->index_model->get_header_menus();
            $this->data['games'] = $this->index_model->get_games();
			
            $this->data['events'] = $this->index_model->get_scrap_events();
           // $this->data['content'] = $this->index_model->get_content();
			$this->data['games'] = $this->index_model->get_my_games();
			$this->data['news1'] = $this->index_model->get_news1();
			$this->data['footer'] = $this->index_model->get_footer_content();
			//$this->data['footer_events'] = $this->index_model->get_footer_events();
			$this->data['get_sport_events'] = $this->index_model->get_sport_events($sports_id);
			
			$get_sports = $this->index_model->get_all_sports();
			$this->data['sports_arr'] = $get_sports['sports_arr'];
			$this->data['sports_count'] = $get_sports['sports_count'];
			//echo "<pre>"; print_r($this->data['sports_count']);exit; 
            $this->load->view('highlight/scrap_highlight', $this->data);
        } else {
            redirect('home/dashboard');
        }
	}
	public function submit_highlight($para = NULL) {
        if ($this->session->userdata('front_user_id') == '') {
            $url = site_url("home");
            //$this->data['country'] = $this->index_model->get_countries();
           // $this->data['states'] = $this->index_model->get_states();
            $this->data['settings'] = $this->index_model->get_settings();
            $this->data['social_icons'] = $this->index_model->get_social_icons();
            $this->data['get_my_header'] = $this->index_model->get_header_menus();
            $this->data['games'] = $this->index_model->get_games();
           // $this->data['content'] = $this->index_model->get_content();
			$this->data['games'] = $this->index_model->get_my_games();
			 $this->data['news1'] = $this->index_model->get_news1();
			$this->data['news'] = $this->index_model->get_news();
			//$this->data['footer_events'] = $this->index_model->get_footer_events();
			$this->data['footer'] = $this->index_model->get_footer_content();
			
			$keyword = $this->db->get('kt_keyword')->result_array();
			$this->data['meta_keyword'] = '<META name="keywords" content="'.$keyword[0]['keyword'].'">';
			
		   $this->load->view('highlight/add_highlight', $this->data);
        } else {
            redirect('home/dashboard');
        }
    }
	function getPage ($url)
{
    $url = 'http://www.google.com/search?q='.urlencode($url);
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com/search?hl=en&q=google&btnG=Google+Search');
        return curl_exec($ch);
    } else {
        return file_get_contents($url);
    }
}
	public function add_highlight_process(){
		
		$rss = $this->load->database('rss', TRUE);
		$url = $this->input->post("url");
		$html = $this->getPage($url );
		
		$banner = $this->input->post('banner');	
		$html2 = $this->getPage($banner);
		
		preg_match('/([0-9\,]+) results<nobr>/si', $html, $match);
		preg_match('/([0-9\,]+) results<nobr>/si', $html2, $match2);
		//echo $value = $match[1] ?: 0;
		//echo $value2 = $match2[1] ?: 0;exit;
		
		if($this->input->post("video") == 'youtube'){
			
		$url = $this->input->post("url");

		preg_match('/([0-9\,]+) results<nobr>/si', $html, $match);
		preg_match('/([0-9\,]+) results<nobr>/si', $html2, $match2);
		$value = $match[1] ?: 0;
		$value2 = $match2[1] ?: 0;
	
	
		$result = parse_url($url);
		$pieces4 = $result['host']; // To get www.youtube.com not http://
		
		if($url != ''){
		//$url = $this->input->post("url");
		preg_match(
        '/[\\?\\&]v=([^\\?\\&]+)/',
        $url,
        $matches
		);
		$id = $matches[1];
		 
		$width = '500px'; //$_POST['width'];
		$height = '500px'; //$_POST['height'];
		
		$new_url = '<object width="' . $width . '" height="' . $height . '"><param name="movie" value="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' . $width . '" height="' . $height . '"></embed></object>';
		}else{
			$this->session->set_flashdata('err_message', 'please Enter Youtube URL');
			redirect('highlight');
			exit;
		}
		
		//dailymotion
		}else if($this->input->post("video") == 'dailymotion'){
		$url = $this->input->post("url");
		if($url != ''){
		$url = $this->input->post("url");
		$result = parse_url($url);
		$pieces4 = $result['host']; // To get www.youtube.com not http://
		$pieces = explode('video/',$url);
		$string=substr($pieces[1],0,7);
		preg_match(
				'/[\\?\\&]v=([^\\?\\&]+)/',
				$url,
				$matches
			);
			$width =  '500px';
			$height = '500px';
			$new_url ='<iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="//www.dailymotion.com/embed/video/'.$string.'" allowfullscreen></iframe><br /><a href="'.$url.'" target="_blank"></a> <i>by <a href="http://www.dailymotion.com/autovideoreviewcom" target="_blank">autovideoreviewcom</a></i>';
		}else{
			$this->session->set_flashdata('err_message', 'please Enter URL');
			redirect('highlight');
			exit;
		}
		//imgur
		}else if($this->input->post("video") == 'imgur'){
		$url = $this->input->post("url");
		if($url != ''){
		$url = $this->input->post("url");
		$result = parse_url($url);
		$pieces4 = $result['host']; // To get www.youtube.com not http://

		$pieces = explode('gallery/',$url);
		$string=substr($pieces[1],0,7);
		//echo $string;exit;

		?>
		<?php
		preg_match(
				'/[\\?\\&]v=([^\\?\\&]+)/',
				$url,
				$matches
			);
		$new_url ='<blockquote class="imgur-embed-pub" lang="en" data-id="'.$string.'"><a href="//imgur.com/'.$string.'">&amp;quot;o-okay.. i guess&amp;quot;FP*: Send pictures of your t̶o̶e̶s̶ feet to my inbox</a></blockquote><script async src="//s.imgur.com/min/embed.js" charset="utf-8"></script>';
		//echo $new_url;exit;
		}else{
			$this->session->set_flashdata('err_message', 'please Enter URL');
			redirect('highlight');
			exit;
		}
		//gyfcat
		}else if($this->input->post("video") == 'gyfcat'){
		$url = $this->input->post("url");
		$result = parse_url($url);
		$pieces4 = $result['host']; // To get www.youtube.com not http://
		if($url != ''){
		$url = $this->input->post("url");
		//echo $url;

		$pieces = explode('http://gfycat.com/',$url);
		$string=substr($pieces[1],0,50);
		//echo $string;exit;

		?>
		<?php
		preg_match(
				'/[\\?\\&]v=([^\\?\\&]+)/',
				$url,
				$matches
			);
		$new_url ="<iframe src='http://gfycat.com/ifr/".$string."' frameborder='0' scrolling='no' width='700' height='700' style='-webkit-backface-visibility: hidden;-webkit-transform: scale(1);' ></iframe>";
		//echo $new_url;exit;
		}else{
			$this->session->set_flashdata('err_message', 'please Enter URL');
			redirect('highlight');
			exit;
		}
		}
		//Embed Code For Other!
		else if($this->input->post("video") == 'other'){
			//echo "ammar";exit;
			$new_url = $this->input->post("embed_code");
			function GetRealURL( $url ) // A function taht will convert embed code into url.
			{ 
			   $options = array(
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_HEADER         => true,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_ENCODING       => "",
				  CURLOPT_USERAGENT      => "spider",
				  CURLOPT_AUTOREFERER    => true,
				  CURLOPT_CONNECTTIMEOUT => 120,
				  CURLOPT_TIMEOUT        => 120,
				  CURLOPT_MAXREDIRS      => 10,
			   );
			   $ch      = curl_init( $url ); 
			   curl_setopt_array( $ch, $options ); 
			   $content = curl_exec( $ch ); 
			   $err     = curl_errno( $ch ); 
			   $errmsg  = curl_error( $ch ); 
			   $header  = curl_getinfo( $ch ); 
			   curl_close( $ch ); 
			   return $header['url']; 
			} //end of function
			if($new_url != ''){
				$new_url = $this->input->post("embed_code");
				
				$string = $new_url;
				$regex = '$\b(https?|ftp|file)://[-A-Z0-9+&@#/%?=~_|!:,.;]*[-A-Z0-9+&@#/%=~_|]$i';
				preg_match_all($regex, $string, $result, PREG_PATTERN_ORDER);
				$A = $result[0];
				$URL = null;
				foreach($A as $B)
				{
				   $URL = GetRealURL($B);
				   break;
				}

				echo $URL;
				$result = parse_url($URL);
				$pieces4 = $result['host'];

			}
			else{
				$this->session->set_flashdata('err_message', 'Please Enter Embed Code');
			redirect('highlight');
			exit;
			}
		}else{
			//$new_url = $this->input->post("embed_code");
			$this->session->set_flashdata('err_message', 'Please Select Video Type');
			redirect('highlight');
			exit;
			
		}
		$type = $this->input->post("type");
		$compatibility = $this->input->post("compatibility");
		$event = $this->input->post('event');
		
		if($value == "" || $value == 0 && $value2 == "" || $value2 == 0){
		$this->session->set_flashdata('error', 'Highlight cannot be submitted');
		redirect('highlight');
		} else {
		$insert_array = array(
			"event_id_highlight" => $event,
			"url" => $new_url,
			"highlight_domain" => $pieces4,
			"type" => $type,
			"compatibility" => $compatibility,
			"status_raw" => 'pending'
		);
		
		$query = $rss->insert('rss_highlight',$insert_array);
		if ($query) {
				$this->session->set_flashdata('ok_message', 'Successful');
				redirect('highlight/submit_highlight');
				
		} else {
			$this->session->set_flashdata('error', 'Something went wrong, please try again later');
			redirect('highlight/submit_highlight');
		}
		}
	}
	public function upload_it($fieldname){
		$data =NULL;
		$config['upload_path'] = 'uploads/matches/';
		$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
		$config['max_size']	= '4096';
		//$config['max_width'] = '11700';
       // $config['max_height'] = '2230';
		$this->load->library('upload', $config);
    
    	$this->upload->initialize($config);
    
    	$this->upload->set_allowed_types('*');

		$data['upload_data'] = '';
		if (!$this->upload->do_upload($fieldname)) {
			$data = array('msg' => $this->upload->display_errors());
			$this->session->set_userdata('image_error',$this->upload->display_errors());

		} else { //else, set the success message
			$this->session->unset_userdata('image_error');
			$data = array('msg' => "Upload success !");
      		$data['upload_data'] = $this->upload->data();
		}
		//print_r($data);exit;
		return $data['upload_data']['file_name']; 
	}
	public function ajax_nation_competition(){
		
		$rss = $this->load->database('rss', TRUE);
		
		$new_session_time= $this->session->userdata('time_formate') * 60 * 60;
		$current_date = gmdate('Y-m-d H:i:s');
		
		
		$datepick = $this->input->post('datepick');
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) - ($my_timezone * 60 * 60));
		$converted_datetime = date('Y-m-d H:i:s', $date_time);
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		$c_nation = $this->input->post('c_nation');
		$nation_sport_id = $this->input->post('nation_sport_id');
		if($c_nation == ''){?>
		<div class="competition_id" id="competition_id" style="display:none;">
			<?php
				$rss->select('rss_competition.competition_id,rss_competition.competition_name');
				if($datepick){
					$datepicker = date('Y-m-d',strtotime($datepick));
					$rss->where('DATE(rss_events.start_date) =',$datepicker );
				}else {
					$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
					$rss->where('DATE(rss_events.start_date) <',$converted_date );
				}
				
				if($nation_sport_id){
					$rss->where('rss_competition.sport_cat_id',$nation_sport_id);
					$rss->join('rss_sport_category','rss_sport_category.id=rss_competition.sport_cat_id');
				}
				$rss->join('rss_events','rss_events.competition_id=rss_competition.competition_id');
				$rss->order_by('rss_events.start_date','aesc');
				$rss->group_by('rss_competition.competition_id');
				$competition = $rss->get('rss_competition')->result_array();
				//echo "<pre>";print_r($competition);exit;
			//echo $this->db->last_query();
			?>
			<select name="my_competition" id="my_competition" >
				<option value="">All Competitions</option>
				<?php foreach($competition as $name){?>
				<option value="<?php echo $name['competition_id'];?>"><?php echo ucwords(strtolower($name['competition_name']));?></option>
				<?php } ?>
			</select> 
		</div>
		
		<?php $events = $this->index_model->ajax_all_nations($nation_sport_id,$datepick);
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
						<?php
						$this->db->select('code3l,code2l,name,flag_128');
						$this->db->join('kt_nation_custom_text','kt_nation_custom_text.nation = kt_country.code3l || kt_nation_custom_text.nation = kt_country.code2l || kt_nation_custom_text.nation = kt_country.name');
						$this->db->where('nation',$event['nation']);
						$this->db->group_by('flag_128');
						$nationflag = $this->db->get('kt_country')->result_array();
						//echo "<pre>";print_r($nationflag);exit;
						//For Nation flag
						foreach($nationflag as $nation_flag){ ?>
							
						<span class="cont-flag">
						<?php if($nation_flag['flag_128']){ ?> 
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/flags/flags/32/<?php echo ucwords($nation).'.png';?>" alt="">
							<?php 
							} else { echo "&nbsp;";	} ?>
						</span>
						<?php } ?>	<!--<a href="#">Live</a>-->
						<span>
						<a href="<?php echo base_url();?>video-highlights/nation_events/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation">
								<?php echo ucwords($event['nation']); ?>
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="http://www.realstreamsports.com/images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>video-highlights/competition_events/<?php echo $event['competition_id'];?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
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
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['home_team_logo'] == ''){ ?>
									
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo ucwords($event['home_team_id']); ?>" title="<?php echo ucwords($event['home_team']); ?>">
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
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo $event['away_team_id']; ?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                               <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['away_team_logo'] == ''){ ?>
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
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
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>"><a href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">View Highlight</a></div>
				</td><td style="display:none"></td>
				
			</tr> <?php
		}
	} 
	else {
	$nation = $this->input->post('c_nation');
	
	$events2 = $this->index_model->get_competition_nations($nation,$nation_sport_id,$datepick);
	//echo "<pre>"; print_r($events2);exit;
	?>
		<div class="competetition" id="competition" style="display:none;">
		<?php
		$exist = array();
		//when sports get selected on competition change.
		echo "<option id='competition_id' value=''>All Competitions</option>";
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
		$events = $this->index_model->get_nation_ajax($nation_id);
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
						<?php
						$this->db->select('code3l,code2l,name,flag_128');
						$this->db->join('kt_nation_custom_text','kt_nation_custom_text.nation = kt_country.code3l || kt_nation_custom_text.nation = kt_country.code2l || kt_nation_custom_text.nation = kt_country.name');
						$this->db->where('nation',$event['nation']);
						$this->db->group_by('flag_128');
						$nationflag = $this->db->get('kt_country')->result_array();
						//echo "<pre>";print_r($nationflag);exit;
						//For Nation flag
						foreach($nationflag as $nation_flag){ ?>
							
						<span class="cont-flag">
						<?php if($nation_flag['flag_128']){ ?> 
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/flags/flags/32/<?php echo ucwords($nation).'.png';?>" alt="">
							<?php 
							} else { echo "&nbsp;";	} ?>
						</span>
						<?php } ?>	<!--<a href="#">Live</a>-->
						<span>
						<a href="<?php echo base_url();?>video-highlights/nation_events/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation">
								<?php echo ucwords(strtolower($event['nation'])); ?>
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="http://www.realstreamsports.com/images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>video-highlights/competition_events/<?php echo $event['competition_id'];?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
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
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['home_team_logo'] == ''){ ?>
									
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo ucwords($event['home_team_id']); ?>" title="<?php echo ucwords($event['home_team']); ?>">
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
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo $event['away_team_id']; ?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                               <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['away_team_logo'] == ''){ ?>
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
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
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>"><a href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">View Highlight</a></div>
				</td><td style="display:none"></td>
				
			</tr>
<?php 	} 
	}
	}
	
	public function ajax_sports(){
		
		$rss = $this->load->database('rss', TRUE);
		$datepick = $this->input->post('datepicker');
		
		$new_session_time= $this->session->userdata('time_formate') * 60 * 60;
		$current_date = gmdate('Y-m-d H:i:s');
		
		$session_date = $this->session->userdata('session_date');
		$datetime = new DateTime($session_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		
		
		$sport = $this->input->post('sport');
		$competition = $this->input->post('competition');
		$nation = $this->input->post('nation');
		//echo $sport;exit;
		if($sport == "all"){ ?>
			<div class="compete" id="compete" style="display:none;">
					<?php
						$rss = $this->load->database('rss', TRUE);
						$rss->select('rss_competition.competition_id,rss_competition.competition_name');
						$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
						$rss->where('DATE(rss_events.start_date) <',$session_date );
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
			 $events = $this->index_model->get_ajax_sports_empty();
			 
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
						<?php
						$this->db->select('code3l,code2l,name,flag_128');
						$this->db->join('kt_nation_custom_text','kt_nation_custom_text.nation = kt_country.code3l || kt_nation_custom_text.nation = kt_country.code2l || kt_nation_custom_text.nation = kt_country.name');
						$this->db->where('nation',$event['nation']);
						$this->db->group_by('flag_128');
						$nationflag = $this->db->get('kt_country')->result_array();
						//echo "<pre>";print_r($nationflag);exit;
						//For Nation flag
						foreach($nationflag as $nation_flag){ ?>
							
						<span class="cont-flag">
						<?php if($nation_flag['flag_128']){ ?> 
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/flags/flags/32/<?php echo ucwords($nation).'.png';?>" alt="">
							<?php 
							} else { echo "&nbsp;";	} ?>
						</span>
						<?php } ?>	<!--<a href="#">Live</a>-->
						<span>
						<a href="<?php echo base_url();?>video-highlights/nation_events/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation">
								<?php echo ucwords(strtolower($event['nation'])); ?>
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="http://www.realstreamsports.com/images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>video-highlights/competition_events/<?php echo $event['competition_id'];?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
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
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['home_team_logo'] == ''){ ?>
									
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo ucwords($event['home_team_id']); ?>" title="<?php echo ucwords($event['home_team']); ?>">
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
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo $event['away_team_id']; ?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                               <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['away_team_logo'] == ''){ ?>
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
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
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>"><a href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">View Highlight</a></div>
				</td><td style="display:none"></td>
				
			</tr>
		<?php } 
		}else if($sport == ""){?>
		
			<div class="compete" id="compete" style="display:none;">
					<?php
					
					$session_date = $this->session->userdata('session_date');
					$datetime = new DateTime($session_date);
					$datetime->modify('-2 day');
					$session_date_yesterday = $datetime->format('Y-m-d');
					
					$rss = $this->load->database('rss', TRUE);
					$rss->select('rss_competition.competition_id,rss_competition.competition_name');
					$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
					$rss->where('DATE(rss_events.start_date) <',$session_date );
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
			 <?php $events = $this->index_model->get_ajax_sports_empty();
			 
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
						<?php
						$this->db->select('code3l,code2l,name,flag_128');
						$this->db->join('kt_nation_custom_text','kt_nation_custom_text.nation = kt_country.code3l || kt_nation_custom_text.nation = kt_country.code2l || kt_nation_custom_text.nation = kt_country.name');
						$this->db->where('nation',$event['nation']);
						$this->db->group_by('flag_128');
						$nationflag = $this->db->get('kt_country')->result_array();
						//echo "<pre>";print_r($nationflag);exit;
						//For Nation flag
						foreach($nationflag as $nation_flag){ ?>
							
						<span class="cont-flag">
						<?php if($nation_flag['flag_128']){ ?> 
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/flags/flags/32/<?php echo ucwords($nation).'.png';?>" alt="">
							<?php 
							} else { echo "&nbsp;";	} ?>
						</span>
						<?php } ?>	<!--<a href="#">Live</a>-->
						<span>
						<a href="<?php echo base_url();?>video-highlights/nation_events/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation">
								<?php echo ucwords(strtolower($event['nation'])); ?>
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="http://www.realstreamsports.com/images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>video-highlights/competition_events/<?php echo $event['competition_id'];?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
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
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['home_team_logo'] == ''){ ?>
									
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo ucwords($event['home_team_id']); ?>" title="<?php echo ucwords($event['home_team']); ?>">
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
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo $event['away_team_id']; ?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                               <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['away_team_logo'] == ''){ ?>
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
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
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>"><a href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">View Highlight</a></div>
				</td><td style="display:none"></td>
				
			</tr>
		<?php } 
		}
		
		
		else{ //------------------------------------HERE TO GET COMPETITIONS----------------------------------------------------
			if($nation ==''){
				$events2 = $this->index_model->ajax_events_sports_empty($sport,$datepick);
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
							echo "<option id='sport_id' class='competition' value='".$myevent['competition_id']."'>".ucwords(strtolower($myevent['competition_name']))."</option>";
							$exist[] = $myevent['competition_id'];
						}
					
					 }//end of foreach loop ?>
					</div>

			<?php }else{
				$events2 = $this->index_model->ajax_nations_sports($sport,$nation,$datepick); ?>
				<div class="compete" id="compete" style="display:none;">
					<?php
					$exist = array();
					//when sports get selected ... competition change.
					echo "<option id='competition_id' value='all'>All Competitions</option>";
					foreach($events2 as $myevent) {
						//Do Not Repeat if same Sport id exists in array more then once
							if(!in_array($myevent['competition_id'], $exist, TRUE)){ 
							echo "<option id='sport_id' class='competition' value='".$myevent['competition_id']."'>".ucwords(strtolower($myevent['competition_name']))."</option>";
							$exist[] = $myevent['competition_id'];
						}
					
					 }//end of foreach loop ?>
					</div>
			<?php } 
			
			//echo $sport;
			//echo $competition;
			//echo "<pre>";print_r($events2);
			if($events2)
			{	
				foreach($events2 as $event){ ?>
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
						<?php
						$this->db->select('code3l,code2l,name,flag_128');
						$this->db->join('kt_nation_custom_text','kt_nation_custom_text.nation = kt_country.code3l || kt_nation_custom_text.nation = kt_country.code2l || kt_nation_custom_text.nation = kt_country.name');
						$this->db->where('nation',$event['nation']);
						$this->db->group_by('flag_128');
						$nationflag = $this->db->get('kt_country')->result_array();
						//echo "<pre>";print_r($nationflag);exit;
						//For Nation flag
						foreach($nationflag as $nation_flag){ ?>
							
						<span class="cont-flag">
						<?php if($nation_flag['flag_128']){ ?> 
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/flags/flags/32/<?php echo ucwords($nation).'.png';?>" alt="">
							<?php 
							} else { echo "&nbsp;";	} ?>
						</span>
						<?php } ?>	<!--<a href="#">Live</a>-->
						<span>
						<a href="<?php echo base_url();?>video-highlights/nation_events/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation">
								<?php echo ucwords(strtolower($event['nation'])); ?>
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="http://www.realstreamsports.com/images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>video-highlights/competition_events/<?php echo $event['competition_id'];?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
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
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['home_team_logo'] == ''){ ?>
									
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo ucwords($event['home_team_id']); ?>" title="<?php echo ucwords($event['home_team']); ?>">
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
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo $event['away_team_id']; ?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                               <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['away_team_logo'] == ''){ ?>
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
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
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>"><a href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">View Highlight</a></div>
				</td><td style="display:none"></td>
				
			</tr>
	<?php 		} 
			}else {	
					echo "No Events Found For This Competition";
			}
		}
	}

public function ajax_nation_sport(){
	$rss = $this->load->database('rss', TRUE);
	
	$new_session_time= $this->session->userdata('time_formate') * 60 * 60;
	$current_date = gmdate('Y-m-d H:i:s');
		
	$datepick = $this->input->post('datepick');
	$session_date = $this->session->userdata('session_date');
	$datetime = new DateTime($session_date);
	$datetime->modify('-2 day');
	$session_date_yesterday = $datetime->format('Y-m-d');
					
	$nation_id = $this->input->post('nation_id');
	$nation_sport_id = $this->input->post('nation_sport_id');
	
	if($nation_id == ''){?>
		<div class="compete" id="compete" style="display:none;">
			<?php
				
				$rss->select('rss_sport_category.id,rss_sport_category.category_name');
				$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
				$rss->where('DATE(rss_events.start_date) <',$session_date );
				$rss->order_by('rss_events.start_date','aesc');
				$rss->join('rss_events','rss_events.sport_category_id=rss_sport_category.id');
				$rss->join('rss_competition','rss_competition.sport_cat_id=rss_sport_category.id');
				$rss->group_by('rss_sport_category.id');
				$sports = $rss->get('rss_sport_category')->result_array();
			?>
			<select name="my_sports" id="my_sports" >
				<option value="">All Sports</option>
				<?php foreach($sports as $sport){?>
				<option  value="<?php echo $sport['id'];?>"><?php echo ucwords(strtolower($sport['category_name']));?></option>
				<?php } ?>
			</select> 
		</div>
		
		<?php $events = $this->index_model->ajax_all_nations($nation_sport_id);
		
		foreach($events as $event){ ?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
			<?php if($nation_sport_id){ } else {?>
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
				</td><?php } ?>
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
						<?php
						$this->db->select('code3l,code2l,name,flag_128');
						$this->db->join('kt_nation_custom_text','kt_nation_custom_text.nation = kt_country.code3l || kt_nation_custom_text.nation = kt_country.code2l || kt_nation_custom_text.nation = kt_country.name');
						$this->db->where('nation',$event['nation']);
						$this->db->group_by('flag_128');
						$nationflag = $this->db->get('kt_country')->result_array();
						//echo "<pre>";print_r($nationflag);exit;
						//For Nation flag
						foreach($nationflag as $nation_flag){ ?>
							
						<span class="cont-flag">
						<?php if($nation_flag['flag_128']){ ?> 
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/flags/flags/32/<?php echo ucwords($nation).'.png';?>" alt="">
							<?php 
							} else { echo "&nbsp;";	} ?>
						</span>
						<?php } ?>	<!--<a href="#">Live</a>-->
						<span>
						<a href="<?php echo base_url();?>video-highlights/nation_events/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation">
								<?php echo ucwords(strtolower($event['nation'])); ?>
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="http://www.realstreamsports.com/images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>video-highlights/competition_events/<?php echo $event['competition_id'];?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
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
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['home_team_logo'] == ''){ ?>
									
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo ucwords($event['home_team_id']); ?>" title="<?php echo ucwords($event['home_team']); ?>">
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
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo $event['away_team_id']; ?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                               <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['away_team_logo'] == ''){ ?>
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
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
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>"><a href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">View Highlight</a></div>
				</td><td style="display:none"></td>
				
			</tr> <?php
		}
	} 
	else {
	$nation_id = $this->input->post('nation_id');
	$events2 = $this->index_model->get_nation_sports($nation_id,$datepick);
	//echo "<pre>";print_r($events2);exit;
	//echo $nation_id;
	?>
		<div class="compete" id="compete" style="display:none;">
		<?php
		$exist = array();
		//when sports get selected on competition change.
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
		$events = $this->index_model->get_nation_ajax($nation_id,$datepick);
		foreach($events as $event){ ?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
			
			<?php if($nation_sport_id){ } else {?>
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
				</td><?php } ?>
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
						<?php
						$this->db->select('code3l,code2l,name,flag_128');
						$this->db->join('kt_nation_custom_text','kt_nation_custom_text.nation = kt_country.code3l || kt_nation_custom_text.nation = kt_country.code2l || kt_nation_custom_text.nation = kt_country.name');
						$this->db->where('nation',$event['nation']);
						$this->db->group_by('flag_128');
						$nationflag = $this->db->get('kt_country')->result_array();
						//echo "<pre>";print_r($nationflag);exit;
						foreach($nationflag as $nation_flag){ ?>
							
						<span class="cont-flag">
						<?php
								$exploded = explode('.',$nation_flag['flag_128']);
								$new_name = $exploded[0]."_thumb.".$exploded[1];
							?>
						<?php if($nation_flag['flag_128']){ ?> 
							<img src="<?php echo base_url();?>uploads/flags/<?php echo $new_name;?>" alt=""><?php 
							} else { echo "&nbsp;";	} ?>
						</span>
						<?php } ?>	<!--<a href="#">Live</a>-->
						<span>
						<a href="<?php echo base_url();?>video-highlights/nation_events/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation">
								<?php echo ucwords(strtolower($event['nation'])); ?>
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="http://www.realstreamsports.com/images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>video-highlights/competition_events/<?php echo $event['competition_id'];?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
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
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['home_team_logo'] == ''){ ?>
									
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo ucwords($event['home_team_id']); ?>" title="<?php echo ucwords($event['home_team']); ?>">
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
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo $event['away_team_id']; ?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                               <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['away_team_logo'] == ''){ ?>
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
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
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>"><a href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">View Highlight</a></div>
				</td><td style="display:none"></td>
				
			</tr>
<?php 	} 
	}
}
	
	public function ajax_events(){
		$rss = $this->load->database('rss', TRUE);
		
		$new_session_time= $this->session->userdata('time_formate') * 60 * 60;
		$current_date = gmdate('Y-m-d H:i:s');
		
		$session_date = $this->session->userdata('session_date');
		$datetime = new DateTime($session_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
		$nation_sport_id = $this->input->post('nation_sport_id');
		
		$competition = $this->input->post('competition');
		if($competition == ""){?>
			<div class="compete" id="compete" style="display:none;">
				<?php
					$rss = $this->load->database('rss', TRUE);
					$rss->select('rss_sport_category.id,rss_sport_category.category_name');
					$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
					$rss->where('DATE(rss_events.start_date) <',$session_date );
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
		<?php	//echo "<input id='sport_id' type='hidden' value='all'>";
			 $events = $this->index_model->ajax_events_competition_all(); //if selected all competitions show up.
			foreach($events as $event){ ?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
			
			<?php if($nation_sport_id){ } else {?>
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
				</td><?php } ?>
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
						<?php
						$this->db->select('code3l,code2l,name,flag_128');
						$this->db->join('kt_nation_custom_text','kt_nation_custom_text.nation = kt_country.code3l || kt_nation_custom_text.nation = kt_country.code2l || kt_nation_custom_text.nation = kt_country.name');
						$this->db->where('nation',$event['nation']);
						$this->db->group_by('flag_128');
						$nationflag = $this->db->get('kt_country')->result_array();
						//echo "<pre>";print_r($nationflag);exit;
						//For Nation flag
						foreach($nationflag as $nation_flag){ ?>
							
						<span class="cont-flag">
						<?php if($nation_flag['flag_128']){ ?> 
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/flags/flags/32/<?php echo ucwords($nation).'.png';?>" alt="">
							<?php 
							} else { echo "&nbsp;";	} ?>
						</span>
						<?php } ?>	<!--<a href="#">Live</a>-->
						<span>
						<a href="<?php echo base_url();?>video-highlights/nation_events/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation">
								<?php echo ucwords($event['nation']); ?>
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="http://www.realstreamsports.com/images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>video-highlights/competition_events/<?php echo $event['competition_id'];?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
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
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['home_team_logo'] == ''){ ?>
									
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo ucwords($event['home_team_id']); ?>" title="<?php echo ucwords($event['home_team']); ?>">
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
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo $event['away_team_id']; ?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                               <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['away_team_logo'] == ''){ ?>
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
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
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>"><a href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">View Highlight</a></div>
				</td><td style="display:none"></td>
				
			</tr>


			
		<?php } 
		} else if($competition == "all"){?>

			<div class="compete" id="compete" style="display:none;">
				<?php
				$session_date = $this->session->userdata('session_date');
				$datetime = new DateTime($session_date);
				$datetime->modify('-2 day');
				$session_date_yesterday = $datetime->format('Y-m-d');
				
				
					$rss = $this->load->database('rss', TRUE);
					$rss->select('rss_sport_category.id,rss_sport_category.category_name');
					$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
					$rss->where('DATE(rss_events.start_date) <',$session_date );
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
						<option  value="<?php echo $sport['id'];?>">
						<?php echo ucwords(strtolower($sport['category_name']));?></option>
						<?php } ?>
					</select> 
			</div>
		<?php	//echo "<input id='sport_id' type='hidden' value='all'>";
			 $events = $this->index_model->ajax_events_competition_all($competition); //if selected all competitions show up.
			 
			foreach($events as $event){ ?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
			
			<?php if($nation_sport_id){ } else {?>
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
				</td><?php } ?>
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
						<?php
						$this->db->select('code3l,code2l,name,flag_128');
						$this->db->join('kt_nation_custom_text','kt_nation_custom_text.nation = kt_country.code3l || kt_nation_custom_text.nation = kt_country.code2l || kt_nation_custom_text.nation = kt_country.name');
						$this->db->where('nation',$event['nation']);
						$this->db->group_by('flag_128');
						$nationflag = $this->db->get('kt_country')->result_array();
						//echo "<pre>";print_r($nationflag);exit;
						//For Nation flag
						foreach($nationflag as $nation_flag){ ?>
							
						<span class="cont-flag">
						<?php if($nation_flag['flag_128']){ ?> 
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/flags/flags/32/<?php echo ucwords($nation).'.png';?>" alt="">
							<?php 
							} else { echo "&nbsp;";	} ?>
						</span>
						<?php } ?>	<!--<a href="#">Live</a>-->
						<span>
						<a href="<?php echo base_url();?>video-highlights/nation_events/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation">
								<?php echo ucwords(strtolower($event['nation'])); ?>
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="http://www.realstreamsports.com/images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>video-highlights/competition_events/<?php echo $event['competition_id'];?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
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
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['home_team_logo'] == ''){ ?>
									
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo ucwords($event['home_team_id']); ?>" title="<?php echo ucwords($event['home_team']); ?>">
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
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo $event['away_team_id']; ?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                               <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['away_team_logo'] == ''){ ?>
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
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
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>"><a href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">View Highlight</a></div>
				</td><td style="display:none"></td>
				
			</tr>
		<?php } 
		}
			
		else{ //---------------------------HERE TO COPY---------------------------------------------------------------------
		$datepick = $this->input->post('datepick');
			$events2 = $this->index_model->ajax_events_competition($competition,$datepick);
			
			//echo "<pre>";print_r($events2);
			if($events2)
			{	?>
				<div class="compete" id="compete" style="display:none;">
				<?php //echo "<option id='sport_id' type='hidden' value='all'>All Sports</option>";?>
				<?php
				$exist = array();
				//when sports get selected on competition change.
				echo "<option id='sport_id' value='all'>All Sports</option>";
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
			
			<?php if($nation_sport_id){ } else {?>
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
				</td><?php } ?>
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
						<?php
						$this->db->select('code3l,code2l,name,flag_128');
						$this->db->join('kt_nation_custom_text','kt_nation_custom_text.nation = kt_country.code3l || kt_nation_custom_text.nation = kt_country.code2l || kt_nation_custom_text.nation = kt_country.name');
						$this->db->where('nation',$event['nation']);
						$this->db->group_by('flag_128');
						$nationflag = $this->db->get('kt_country')->result_array();
						//echo "<pre>";print_r($nationflag);exit;
						//For Nation flag
						foreach($nationflag as $nation_flag){ ?>
							
						<span class="cont-flag">
						<?php if($nation_flag['flag_128']){ ?> 
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/flags/flags/32/<?php echo ucwords($nation).'.png';?>" alt="">
							<?php 
							} else { echo "&nbsp;";	} ?>
						</span>
						<?php } ?>	<!--<a href="#">Live</a>-->
						<span>
						<a href="<?php echo base_url();?>video-highlights/nation_events/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation">
								<?php echo ucwords(strtolower($event['nation'])); ?>
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="http://www.realstreamsports.com/images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>video-highlights/competition_events/<?php echo $event['competition_id'];?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
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
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['home_team_logo'] == ''){ ?>
									
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo ucwords($event['home_team_id']); ?>" title="<?php echo ucwords($event['home_team']); ?>">
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
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo $event['away_team_id']; ?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                               <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['away_team_logo'] == ''){ ?>
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
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
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>"><a href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>">View Highlight</a></div>
				</td><td style="display:none"></td>
				
			</tr>
	<?php 		} 
			}else {	
					echo "No Events Found For This Competition";
			}
		}
	}
	
	public function get_myteam_event($id){
		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		$this->data['footer'] = $this->index_model->get_footer_content();
		
		$this->data['news1'] = $this->index_model->get_news1();
		//$this->data['footer_events'] = $this->index_model->get_footer_events();
		$this->data['get_myteam_events'] = $this->index_model->get_myteam_events($id);
		$get_sports = $this->index_model->get_all_sports();
		$this->data['sports_arr'] = $get_sports['sports_arr'];
		$this->data['sports_count'] = $get_sports['sports_count'];
		$this->data['stream'] = $this->index_model->get_streams($id); 
		$this->data['p2p'] = $this->index_model->get_streams_p2p($id); 
		 //echo"<pre>";print_r($this->data['stream']);
		$this->load->view('view_team_events',$this->data);
	}
	public function get_team_events_highlights($id){
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
			//echo "<pre>";print_r($meta_tag6);exit;
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
		echo $category = $this->input->post('category');
		echo $event_id = $this->input->post('event_id');
		exit;
		$rss->select('*');
		$rss->where('type',$category);
		$rss->where('event_id_highlight',$event_id);

		$highlight = $rss->get('rss_highlight')->result_array();
		
		// print_r($highlight);
		if($highlight){
		$related_highlights = "";
		$first_video =  $highlight[0]['url'];
		
		foreach($highlight AS $each_light){
			if($highlight[0]['url'] != $each_light['url']){
				// $related_highlights[]=$each_light['url'];
				$related_highlights = $related_highlights."".'<li>
					<a href="javascript:;" class="button" style="color:black;" onClick="change_video('.$each_light['id'].')"><div class="video-tumbnail"><img src="http://dev.ejuicysolutions.com/wiziwig/assets/images/video3.jpg"></div></a>
				</li>';
			} 
		} 
		echo json_encode(array('first_video' => $first_video,'related_videos'=>$related_highlights));
		} else {
			$error = 'No Results';
			echo json_encode($error);
		}
	}
	
	public function get_selected_video(){
		$this->db->where('id',$this->input->post("vid_id"));
		$highlight = $this->db->get('kt_highlight')->result_array();
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
			if($sport_name == "Soccer") { $sport_name = "Football"; } 
			
			//Meta Title
			
			$meta_tag = $this->index_model->meta_tags7($sport_id[0]['id']);
			$this->data['meta_title'] = $meta_tag[0]['title'];
			$this->data['meta_description'] = '<meta name="description" content="'.$meta_tag[0]['description'].'">';
			$this->data['meta_keyword'] = '<META name="keywords" content="'.$meta_tag[0]['keywords'].'">';
			$this->data['meta_article'] = $meta_tag[0]['article'];
			
			//End Of Meta
			
			$this->data['sport'] = $sport_name; 
		
			$this->data['sport_id_for_calender'] = $sport_id[0]['id'];
			$this->load->view('highlight/view_sport_events',$this->data);
		}
		
	}
	public function team_events($team_id = NULL) {
		
		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		$this->data['footer'] = $this->index_model->get_footer_content();
		//$this->data['footer_events'] = $this->index_model->get_footer_events();
		$this->data['news1'] = $this->index_model->get_news1();
		$get_sports = $this->index_model->get_all_sports();
		$this->data['sports_arr'] = $get_sports['sports_arr'];
		$this->data['sports_count'] = $get_sports['sports_count'];
		$this->data['get_sport_events'] = $this->index_model->get_sport_events($sport_id);
		//$this->data['get_team_events'] = $this->index_model->get_team_events($team_id);
		if($team_id ){
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
		}
		$this->data['team_id_for_calender'] = $team_id;
		
		$this->load->view('highlight/view_all_team_events',$this->data);	
	}
	public function nation_events($nation,$nation_sport = NULL){
		if($nation_sport == "Football") { $nation_sport = "Soccer"; }
		$rss = $this->load->database('rss', TRUE);
		$name = str_replace('-', ' ',$nation_sport);
		$rss->select('id');
		$rss->where('category_name',$name);
		$sport_id = $rss->get('rss_sport_category')->result_array();

		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		$this->data['footer'] = $this->index_model->get_footer_content();
		//$this->data['footer_events'] = $this->index_model->get_footer_events();
		$this->data['news1'] = $this->index_model->get_news1();
		$get_sports = $this->index_model->get_all_sports();
		$this->data['sports_arr'] = $get_sports['sports_arr'];
		$this->data['sports_count'] = $get_sports['sports_count'];
		$this->data['get_sport_events'] = $this->index_model->get_sport_events($sport_id[0]['id']);
		$this->data['get_nation_events'] = $this->index_model->get_nation_events($nation,$sport_id[0]['id']);
		
		$this->data['nation_sport'] = $nation_sport;
		//$this->data['get_nation_events'] = $this->index_model->get_nation_events($nation,$sport_id[0]['id']);
		//echo $nation_sport;exit;
		$get_nation_events = $this->data['get_nation_events'];
		
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
		
		
		$this->load->view('highlight/view_all_nation_events',$this->data);
	}
	public function competition_events($competition_id = NULL,$competition_name = NULL){
		//echo $competition_id;exit;
		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		$this->data['footer'] = $this->index_model->get_footer_content();
		//$this->data['footer_events'] = $this->index_model->get_footer_events();
		$this->data['news1'] = $this->index_model->get_news1();
		$get_sports = $this->index_model->get_all_sports();
		$this->data['sports_arr'] = $get_sports['sports_arr'];
		$this->data['sports_count'] = $get_sports['sports_count'];
		$this->data['get_sport_events'] = $this->index_model->get_sport_events($sport_id);
		//$newcompetition = preg_replace('/', $competition);
		//$newcompetition = str_replace('%20', '-', $competition);
		//echo $newcompetition;exit;
		$this->data['get_competition_events'] = $this->index_model->get_competition_events($competition_id);
		
		$get_competition_events = $this->data['get_competition_events'];
		
		// Meta TAgs
		//echo $competition_id;exit;
		$meta_tag = $this->index_model->meta_tags2($competition_id);
		//echo "<pre>";print_r($meta_tag);exit;
		$this->data['meta_title'] = $meta_tag[0]['title'];;
		
		$this->data['meta_description'] = '<meta name="description" content="'.$meta_tag[0]['description'].'">';
		
		
		$this->data['meta_keyword'] = '<META name="keywords" content="'.$meta_tag[0]['keywords'].'">';
		$this->data['meta_article'] = $meta_tag[0]['article'];
		//End Of MEta TAgss
		
		$this->load->view('highlight/view_all_competition_events',$this->data);
		
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
		foreach($datepicker_events as $event){?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
				<?php if($sport || $nation_sport_id){ } else {?>
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
						<?php
						$this->db->select('code3l,code2l,name,flag_128');
						$this->db->join('kt_nation_custom_text','kt_nation_custom_text.nation = kt_country.code3l || kt_nation_custom_text.nation = kt_country.code2l || kt_nation_custom_text.nation = kt_country.name');
						$this->db->where('nation',$event['nation']);
						$this->db->group_by('flag_128');
						$nationflag = $this->db->get('kt_country')->result_array();
						//echo "<pre>";print_r($nationflag);exit;
						//For Nation flag
						foreach($nationflag as $nation_flag){ ?>
							
						<span class="cont-flag">
						<?php if($nation_flag['flag_128']){ ?> 
							<?php $nation = strtolower($event['nation']);?>
							<img src="<?php echo base_url();?>images/Flags/flags/flags/32/<?php echo ucwords($nation).'.png';?>" alt="">
							<?php 
							} else { echo "&nbsp;";	} ?>
						</span>
						<?php } ?>	<!--<a href="#">Live</a>-->
						<span>
						<a href="<?php echo base_url();?>video-highlights/nation_events/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation">
								<?php echo ucwords(strtolower($event['nation'])); ?>
							</span>
						</a>
					</div>
					<span class="country-name-team">
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="http://www.realstreamsports.com/images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
					<span class="teamname">
						<a href="<?php echo base_url();?>video-highlights/competition_events/<?php echo $event['competition_id'];?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
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
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['home_team_logo'] == ''){ ?>
									
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name">
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo ucwords($event['home_team_id']); ?>" title="<?php echo ucwords($event['home_team']); ?>">
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
									<a href="<?php echo base_url();?>video-highlights/team_events/<?php echo $event['away_team_id']; ?>" title="<?php echo ucwords($event['away_team']); ?>">
										<?php
											echo ucwords($event['away_team']);
										?> 
									</a>
								</span>
                               <span class="flag" >
									<?php if($event['sport_name'] == 'Tennis') { ?>
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">
									<?php } else if($event['away_team_logo'] == ''){ ?>
									<img src="http://www.realstreamsports.com/images/teams/default.png" style="width:28px; float:left;">
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
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>">
						<a <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date'])+($session_time * 60 * 60))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date'])+($session_time * 60 * 60))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?><?php if(date('Y-m-d H:i:s', (strtotime($event['end_date'])+($session_time * 60 * 60))) > $current_date ) {  ?>home/get_myteam_event/<?php } else { ?>highlight/get_team_events_highlights/<?php } echo $event['id'];?>"><?php if(date('Y-m-d H:i:s', (strtotime($event['end_date'])+($session_time * 60 * 60))) > $current_date) {  ?> View Event <?php } else { ?> View Highlight <?php } ?>
						</a>
					</div>
				</td>
				<td style="display:none"></td>
				
			</tr>
<?php  	}
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
