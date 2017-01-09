
<html lang="en">
    <head>
    	<?php $meta_title = str_replace("%duration%",$duration,$meta_title);
              $meta_title = str_replace("%home_team%",$get_myteam_events[0]['home_team'],$meta_title);	
              $meta_title = str_replace("%away_team%",$get_myteam_events[0]['away_team'],$meta_title);	
              $meta_title = str_replace("%start_date%",$new_date_start,$meta_title);	
              $meta_title = str_replace("%end_date%",$new_date_end,$meta_title);	
              $meta_title = str_replace("%nation%",$get_myteam_events[0]['nation'],$meta_title);	
              $meta_title = str_replace("%competition%",$get_myteam_events[0]['competition_name'],$meta_title);	
              
              $meta_description = str_replace("%duration%",$duration,$meta_description);
              $meta_description = str_replace("%home_team%",$get_myteam_events[0]['home_team'],$meta_description);	
              $meta_description = str_replace("%away_team%",$get_myteam_events[0]['away_team'],$meta_description);	
              $meta_description = str_replace("%start_date%",$new_date_start,$meta_description);	
              $meta_description = str_replace("%end_date%",$new_date_end,$meta_description);	
              $meta_description = str_replace("%nation%",$get_myteam_events[0]['nation'],$meta_description);	
              $meta_description = str_replace("%competition%",$get_myteam_events[0]['competition_name'],$meta_description);

              $meta_keyword = str_replace("%duration%",$duration,$meta_keyword);
              $meta_keyword = str_replace("%home_team%",$get_myteam_events[0]['home_team'],$meta_keyword);	
              $meta_keyword = str_replace("%away_team%",$get_myteam_events[0]['away_team'],$meta_keyword);	
              $meta_keyword = str_replace("%start_date%",$new_date_start,$meta_keyword);	
              $meta_keyword = str_replace("%end_date%",$new_date_end,$meta_keyword);	
              $meta_keyword = str_replace("%nation%",$get_myteam_events[0]['nation'],$meta_keyword);	
              $meta_keyword = str_replace("%competition%",$get_myteam_events[0]['competition_name'],$meta_keyword);
              ?>
	<title><?php echo $meta_title;?></title>
	<?php echo $meta_description;?>
	<?php echo $meta_keyword;?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>WiziWig</title><!--
       <link rel="icon" type="image/png" href="<?php// echo base_url() ?>assets/images/favicon.ico">-->
	   <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link href="https://file.myfontastic.com/n6vo44Re5QaWo8oCKShBs7/icons.css" rel="stylesheet">	
  
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php //echo base_url(); ?>assets/css/demo.css" type="text/css" media="screen" />
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,500,700,600,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>

		
		
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]



        <style>
            .my-error-class
            {
                color:red;
            }
            .my-valid-class
            {
                color:green;
            }	
            ul.slides li div.slider-text h1 {
               font-size: 32px !important;
           }

        </style>
    </head>
    <body>
<!-- header -->
<?php $this->load->view('includes/header');?>
<!-- header --> 

<!-- banner -->
<style>
span.score2 {
    float: right;
}
span.score1 {
    float: left;
}

.evedetail-outer h3 {
    padding: 8px 8px;
}
span.a {
    float: left;
}

.goal-outer {padding:5px; border-bottom:1px solid #ddd; margin-bottom:0px; transition: all 0.5s ease; font-weight:bold;}

span.b {
    float: right;
}

</style>

<!-- banner -->
<div class="clearfix"></div>
<!-- games container -->
<section id="games-links" class="game-links <?php echo $this->session->userdata('session_color').'-games-links'?>">
	<div class="container">
    <i class="fa fa-navicon mob-nav"></i>
		<div class="row animated slideInDown" id="mob-navig">
			<div class="col-lg-12">
				<ul>
					<?php for($i=0;$i<=6;$i++){ ?>
					<li>
						<?php ?>
						<a href="<?php echo base_url();?>video-highlights/<?php if($sports_arr[$i]['category_name'] == "Soccer") { $sports_arr[$i]['category_name'] ="Football"; } echo str_replace(' ', '-', strtolower($sports_arr[$i]['category_name']));?>">
							<span class="left-icon">
								<img src="<?php echo base_url();  ?>admin/uploads/game_images/<?php echo $sports_arr[$i]['sport_logo'];?>">
							</span>
							<span>
								<?php if($sports_arr[$i]['category_name'] == "Soccer") { $sports_arr[$i]['category_name'] = "Football"; } echo $sports_arr[$i]['category_name'];?>
							</span>
						</a>
					</li>
					<?php } 
					if($sports_count > 7) {?>
					<div class="btn-group">
					
						<button type="button" class="dropdown-toggle" data-toggle="dropdown">
							Other... <span class="caret"></span>
						</button>
						
						<ul class="dropdown-menu <?php echo $this->session->userdata('session_color').'-dropdown-menu'?>" role="menu">
						<?php for($z=7;$z<$sports_count;$z++) {?>
						<li>
							<a href="<?php echo base_url();?>video-highlights/<?php echo str_replace(' ', '-', strtolower($sports_arr[$z]['category_name']));?>">
								<span class="left-icon">
									<img src="<?php echo base_url();  ?>admin/uploads/game_images/<?php echo $sports_arr[$z]['sport_logo'];?>" style="width:28px;height:28px;">
								</span>
								<span>
									<?php echo $sports_arr[$z]['category_name'];?>
								</span>
							</a>
						</li>
						<?php }?>
						</ul>
					</div> <?php } ?>
				</ul>
			</div>
		</div>
	</div>
</section>
<!-- games container --> 

<!-- welcome container -->

<!-- welcome container -->
<div class="clearfix"></div>
<!-- table container -->

<!-- table container -->

<div class="clearfix"></div>
<!-- news container -->
<section id="result-container">
	<section id="result-container" style ="background:#F5F5F5;">

	<!--
	<a href="<?php //echo base_url();?>home/get_team_events_highlights/<?php// echo $get_myteam_events[0]['id'];?>" class="btn btn-success">View highlight</a>
	-->
	

<?php foreach($get_myteam_events as $team) { ?>

    <div class="new-result-container">
    
        <div class="breadcrumbs <?php echo $this->session->userdata('session_color').'-style'?>">
            <div class="container">
                <div>
                  <a href="<?php echo base_url();?>video-highlights/<?php if($team['category_name'] == "Soccer") { $team['category_name'] ="Football"; } echo str_replace(' ', '-', $team['category_name']);?>"><?php echo $team['category_name'];?>  </a>

                                 </div>
                <div>
                    <a href="<?php echo base_url();?>video-highlights/nations/<?php if($team['category_name'] == "Soccer") { $team['category_name'] = "football"; } echo str_replace(' ', '-', $team['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $team['nation']));?>"><?php if(strlen($team['nation'])>25) {
								echo ucwords(substr($team['nation'],0,25)).'..';
								}
								else if(strlen($team['nation']) == 3){
									echo ucwords(strtoupper($team['nation']));
								} else {
									echo ucwords(strtolower($team['nation']));
								}
								?> </a>
                </div>
                <div>
                    <a href="<?php echo base_url();?>video-highlights/competitions/<?php echo $team['competition_id'];?>/<?php if($team['category_name'] == "Soccer") { $team['category_name'] = "football"; } echo str_replace(' ', '-', $team['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $team['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $team['competition_name'])));?>"><?php
						if($team['category_name']== "Tennis" || $team['category_name']== "Golf" || $team['category_name']== "MotorSports"){
									
									if(strpos($team['competition_name'], ',')){
										$name=explode(',',ucwords(strtolower($team['competition_name'])));
										echo ucwords(strtolower($name[1]));
									} else {
										echo ucwords(strtolower($team['competition_name']));
									}
									
									
								}else{
								if(strlen($team['competition_name'])>25) {
									echo ucwords(substr($team['competition_name'],0,25)).'..';
								}
								else if(strlen($team['competition_name']) == 3){
									echo ucwords(strtoupper($team['competition_name']));
								} else {
									echo ucwords(strtolower($team['competition_name']));
								}
								}?></a>
                </div>
                	
                <div>
                    <a <?php if ($team['category_name']=="Tennis") echo "title"; else echo "href"; ?>="<?php echo base_url();?>video-highlights/teams/<?php echo ucwords($team['home_team_id']); ?>/<?php if($team['category_name'] == "Soccer") { $team['category_name'] = "football"; } echo str_replace(' ', '-', $team['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $team['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $team['home_team']));?>"><span><?php echo ucwords($team['home_team']);?></span></a> vs <a <?php if ($team['category_name']=="Tennis") echo "title"; else echo "href"; ?>="<?php echo base_url();?>video-highlights/teams/<?php echo ucwords($team['away_team_id']); ?>/<?php if($team['category_name'] == "Soccer") { $team['category_name'] = "football"; } echo str_replace(' ', '-', $team['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $team['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $team['away_team']));?>"><span><?php echo ucwords($team['away_team']);?></span></a>
                </div>
                
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="logo-holder col-md-7">
                    	
										<?php if($team['sport_name'] == 'Tennis') { ?>
									<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$team['home_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" >
									<?php } else {?>
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" class="img-responsive">

									<?php } ?>
									<?php } else if($team['home_team_logo'] == '' || $team['home_team_logo'] == '/images/teams/default.png' ) { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $team['sport_name'];?>-default.png" class="img-responsive">
									
									<?php } else { ?>
									<img src='<?php echo $team['home_team_logo'];?>' class="img-responsive">
									<?php } ?>
                             <span></span>
                    </div>
                    <h2>
                        <a href="<?php echo base_url();?>home/team_events/<?php echo $team['home_team_id'];?>"><?php echo ucwords($team['home_team']);?></a>
                    </h2>
                     <div class="btn-group-centerized statistics">
                   <?php if ($team['category_name'] != "Tennis" && $team['category_name'] != "Golf" && $team['category_name'] != "MotorSports" && $team['category_name'] != "Other" && $team['category_name'] != "Fighting"){ 

							
							$status_of_event = explode('-',$team['events_status']); 
							
					
										$rss = $this->load->database('rss', TRUE);  
										$rss->where('home_team_id',$get_myteam_events[0]['home_team_id']);
										$rss->where('events_status !=',' ');
										$rss->limit('5');
										$rss->where('id !=',$team['id']);
										$rss->group_by('id');
										$rss->order_by('start_date','desc');
										$home_team_data = $rss->get('rss_events')->result_array();

										foreach($home_team_data as $home_data){
											
										$event_status[$i] = explode(' - ',$home_data['events_status']);
										$event_status1 = $event_status[$i][0];
										$event_status2 = $event_status[$i][1];
										 

										if($event_status1 == $event_status2){

											$new_status = 'D';
											
										}
										if($event_status1 > $event_status2){

											$new_status = "W";
											
										}
										if($event_status1 < $event_status2) {
											
											$new_status = "L";
										}
										//echo $new_status;
										//echo "<pre>";print_r($home_team_data);
										
										

										if($new_status == "W") { ?>
											 <span class="stat2"> <?php } else if($new_status == "L") { ?> <span class="stat-red"> <?php } else { ?> <span class="stat1"> <?php }
											?><a href="<?php echo base_url().'video-highlights/team-highlights/'.$home_data['id'];; ?>" title="<?php echo $home_data[home_team].' : '.$home_data[away_team].' '.$home_data[events_status]; ?>" data-toggle="tooltip" ><?php echo $new_status.' ';?> </a> 
											 </span> <?php 
										}
									?>	</span> 
 <?php } ?>
								</div>
                
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 nopadding">
                    <div class="match-info">
                        <p>
                          		<?php if($team['game_week']){?>Week : <?php echo $team['game_week']; } else { if($team['round_id']) { ?> Round  : <?php echo $team['round_id']; } } ?>
                        </p>
                        <p>
                            <span>Date:</span> <?php echo date('j', (strtotime($team['start_date']))+ $new_session_time);?>
						<?php echo date('F', (strtotime($team['start_date']))); ?>
						<?php echo date('o', (strtotime($team['start_date']))); ?>
                        </p>
                        <p>
                            <span>Time:</span> <?php echo date('G:i', (strtotime($team['start_date']) + $new_session_time));?><br />
                        </p>
                    </div>
                    <div class="count">
                        <span><?php if($status_of_event[0] == '') { echo "-"; } else { echo $status_of_event[0]; }  ?></span> : <span><?php if($status_of_event[1] == '') { echo "-"; } else { echo $status_of_event[1]; }  ?></span>
                    </div>
                    	<?php
								$this->db->where('comp_id',$get_myteam_events[0]['competition_id']);
								$ca = $this->db->get('kt_ads')->result_array();
								if($ca[0]['hd'] == 'HD') { 
							 ?>
                    <a href="#" class="btn btn-lg btn-hd" title="Watch in HD">
                        Watch
                        <span>
                            <img src="<?php echo base_url();?>assets/hd.svg" alt="" />
                        </span>
                    </a>
                    	<?php 	} ?>
                    				<?php
				
				
				if($new_session_time){
					$newdate =  date('F d, Y H:i:s', (strtotime($team['start_date']))+$new_session_time);
				// echo $newdate;
				?>
						
						<input type="hidden" value="<?php echo $newdate; ?>" id="getting_timer">
				<?php 	} else { ?>
						<input type="hidden" value="<?php echo $newdate; ?>" id="getting_timer">
				<?php	} ?>
                    <div id="getting-started"></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
                    <div class="logo-holder right col-md-7">
                     <?php if($team['sport_name'] == 'Tennis') { ?>
									<?php $rss = $this->load->database('rss', TRUE);
                                         $rss->select('rss_players.headshot_image');
		    	                         $rss->where('rss_players.player_name =',$team['away_team'] );
               		                     $query = $rss->get('rss_players')->row_array();
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" >
									<?php } else {?>
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png">

									<?php } ?>
									<?php } else if($team['away_team_logo'] == '' || $team['away_team_logo'] == '/images/teams/default.png' ) { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $team['sport_name'];?>-default.png" class="img-responsive">
									
									<?php } else { ?>
									<img src='<?php echo $team['away_team_logo'];?>' class="img-responsive">
									<?php } ?>
                       
                        <span></span>
                    </div>
                    <h2>
                        <a href="<?php echo base_url();?>home/team_events/<?php echo $team['away_team_id'];?>"><?php echo ucwords($team['away_team']);?></a>
                    </h2>
                    <div class="btn-group-centerized statistics">
                                   <?php if ($team['category_name'] != "Tennis" && $team['category_name'] != "Golf" && $team['category_name'] != "MotorSports" && $team['category_name'] != "Other" && $team['category_name'] != "Fighting"){ 

										$rss->where('away_team_id',$get_myteam_events[0]['away_team_id']);
										
										$rss->where('events_status !=',' ');
										$rss->limit('5');
										$rss->group_by('id');
										$rss->where('id !=',$team['id']);
										$rss->order_by('start_date','desc');
										$home_team_data = $rss->get('rss_events')->result_array();

										foreach($home_team_data as $home_data){
											
										$event_status[$i] = explode(' - ',$home_data['events_status']);
										$event_status1 = $event_status[$i][0];
										$event_status2 = $event_status[$i][1];
										 

										if($event_status1 == $event_status2){

											$new_status = 'D';
											
										}
										if($event_status1 < $event_status2){

											$new_status = "W";
											
										}
										if($event_status1 > $event_status2) {
											
											$new_status = "L";
										}
										//echo $new_status;
										//echo "<pre>";print_r($home_team_data);
										
										

										if($new_status == "W") { ?>
											 <span class="stat2"> <?php } else if($new_status == "L") { ?> <span class="stat-red"> <?php } else { ?> <span class="stat1"> <?php }
											?><a href="<?php echo base_url().'video-highlights/team-highlights/'.$home_data['id'];; ?>" title="<?php echo $home_data[home_team].' : '.$home_data[away_team].' '.$home_data[events_status]; ?>" data-toggle="tooltip" ><?php echo $new_status.' ';?> </a> 
											 </span> <?php 
										}
									?>	

 <?php } ?>
								</div>
                
                </div>
            </div>
        </div>
      
        
        <?php } 
        		if(date('Y-m-d H:i:s', (strtotime($team['start_date']))) <= $current_date && date('Y-m-d H:i:s', (strtotime($team['end_date']))) >= $current_date ) { ?>
							<div class="live"></div>
							<?php } else {	 ?>
						<div class="message"></div>
						
							<?php } ?>
        <div class="share-block <?php echo $this->session->userdata('session_color').'-style'?>">
            <div class="container">
                Share this event with your friends:
                <a data-toggle="modal" class="btn fb" href="#"><span class="socicon socicon-facebook"></span></a><a data-toggle="modal" class="btn tw" href="#"><span class="socicon socicon-twitter"></span></a><a data-toggle="modal" class="btn gp" href="#"><span class="socicon socicon-googleplus"></span></a><a data-toggle="modal" class="btn vk" href="#"><span class="socicon socicon-vkontakte"></span></a><a data-toggle="modal" class="btn tl" href="#"><span class="socicon socicon-tumblr"></span></a>
            </div>
        </div>
    </div>
	
</section>
	
</section>
<!-- Stream container -->

<div class="clearfix"></div>
<!-- highlight container -->
<?php if($highlight_arr[0]['url']) { ?>
<section id="highlight-container">

<div class="container">
	<!-- Goals -->
						<?php
							//echo $event_id;
							$rss->select('match_goals');
							$rss->where('event_id',$get_myteam_events[0]['id']);
							$json = $rss->get('rss_event_details')->result_array(); 
							//$json_count = $rss->get('rss_event_details')->num_rows();
							//echo "<pre>";print_r($json_count);
							?>
						<?php if($json){?>
							<div class = "row">
							<div class="col-md-12 line-up-outer table-responsive">
							<h3 class="text-center" style="font-size:20px; font-family:inherit"> <img src="<?php echo base_url();?>assets/images/goals.png"> Goals</h3>
							
						<div class="col-md-6 col-md-offset-3">
						
							<?php
							//echo "<pre>";print_r($json);
							
								foreach($json as $j) {
								
								$my_array_goal= json_decode($j['match_goals'],true);
								//echo "<pre>";print_r($my_array_goal);
								if($my_array_goal){
									foreach($my_array_goal as $goal){
									//echo "<pre>";print_r($goal);
									foreach($goal as $g) { ?>
										
										<div class='goal-outer goal-<?php echo $this->session->userdata('session_color').'-outer'; ?>'>
										<?php echo "<center>"; ?>
										<span class='a <?php echo $this->session->userdata('session_color').'-title'; ?>'>
										<?php echo $g['author'].' '.$g['extra'].' '.$g['munute'].' '."</span><span class='b".' '.$this->session->userdata('session_color')."-count '>".$g['score']."</span>";
										echo "<br/>";
										echo "</center>";
										echo "</div>";
									}
								}
								} else {
									echo "There are no Live scores For Now..";
								}
								
								}
							 /*else {
								echo "No Match Goals Yet.";
							}*/
							
							?>
							</div>
						</div>

						
					</div>
					<?php }?>
		 <!-- End Of ROW --><br/>
	<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 evedetail-outer">
		 <h3 style="font-family:inherit" class="text-center"> Video Categories</h3>
	</div>
	
	<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 evedetail-outer">
		 <h3 style="font-family:inherit" class="text-center"> Latest Highlights</h3>
	</div>	
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<!--<h2> Video Categories </h2>-->
		<!-- ammar -->
			<ul class="livematches1">
				<?php
				$rss->select('type');
				$rss->where('event_id_highlight',$highlight_arr[0]['event_id_highlight']);
				$rss->group_by('type');
				$check = $rss->get('rss_highlight')->result_array();
				//echo "<pre>";print_r($check);
				
				$i = 0;
				$exist = '';
				foreach($check as $c) {
					$exist .= $c['type'].',';
					
					//echo $c['type'];
				} 
				$abc = explode(',',$exist);
				?>
				<!--<li class="slected">-->
				<?php if(in_array("Highlights", $abc)) {?>
				<li>
					<a href="javascript:;" data-id="highlights" data-value="<?php echo $highlight_arr[0]['event_id_highlight']; ?>" class="myhighlight"> <i class="fa fa-television"></i> Match Highlights  </a>
				</li>
				<?php } ?>
				<?php if(in_array("highlights", $abc)) {?>
				<li>
					<a href="javascript:;" data-id="highlights" data-value="<?php echo $highlight_arr[0]['event_id_highlight']; ?>" class="myhighlight"> <i class="fa fa-television"></i> Match Highlights  </a>
				</li>
				<?php } ?>
				<?php if(in_array("Goals", $abc)) {?>
				<li> 
					<a href="javascript:;" data-id="Goals" data-value="<?php echo $highlight_arr[0]['event_id_highlight']; ?>" class="myhighlight"><i class="fa fa-television"></i> Goal Highlights  </a>
				</li>
				<?php } ?>
				<?php if(in_array("Full Match Record", $abc)) {?>
				<li> 
					<a href="javascript:;" data-id="Full Match Record" data-value="<?php echo $highlight_arr[0]['event_id_highlight']; ?>" class="myhighlight"><i class="fa fa-television"></i> Full Match Highlights </a>
				</li>
				<?php } ?>
				<?php if(in_array('OTHER', $abc)) {?>
				<li> 
					<a href="javascript:;#" data-id="OTHER" data-value="<?php echo $highlight_arr[0]['event_id_highlight']; ?>" class="myhighlight"><i class="fa fa-television"></i> Other Highlights </a>
				</li>
				<?php } ?>
			</ul> 

		</div>
		
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
			<!--<h2>Latest Highlights</h2>-->
			<span id="error" ></span>
			<div class="video-container" id="video-container">
				<div class="my-video" id="video">
					<br/>
					<?php echo $highlight_arr[0]['url']; ?>
				</div>
	
				<div class="more-videos" style="background:none;" >
					<ul id="related_highlights">
			
					</ul>
					<div class="clearfix"></div>
				</div> 
			
			</div>
		</div> 
	 
	</div>
	

</div>
</section>
	<?php } else { echo '<h4 class="pull-center" style=" color: #333;     padding: 10px; margin-left: 0; text-align: center; font-size: 13px; font-family: arial;">'."No highlights for this game yet, check back later".'</h4>'; } ?>
<!-- footer --> 
<?php

$template = $meta_article;
							
$new_date_start = date('j', (strtotime($get_myteam_events[0]['start_date'])+($session_time * 60 * 60))).' '.date('M', (strtotime($get_myteam_events[0]['start_date'])+($session_time * 60 * 60))).' '.date('G:i', (strtotime($get_myteam_events[0]['start_date'])+($session_time * 60 * 60)));

$new_date_end = date('j', (strtotime($get_myteam_events[0]['end_date'])+($session_time * 60 * 60))).' '.date('M', (strtotime($get_myteam_events[0]['end_date'])+($session_time * 60 * 60))).' '.date('G:i', (strtotime($get_myteam_events[0]['end_date'])+($session_time * 60 * 60)));



$date_a = new DateTime($get_myteam_events[0]['start_date']);
$date_b = new DateTime($get_myteam_events[0]['end_date']);

$interval = date_diff($date_a,$date_b);
//echo $interval->format('%i');
if($interval->format('%i') == 0) {
	
	$duration = $interval->format('%h')." hours";
}else {
	$duration = $interval->format('%h')." hours and ".' '.$interval->format('%i')." minutes";
}
$template = str_replace("%duration%",$duration,$template);
$template = str_replace("%home_team%",$get_myteam_events[0]['home_team'],$template);	
$template = str_replace("%away_team%",$get_myteam_events[0]['away_team'],$template);	
$template = str_replace("%start_date%",$new_date_start,$template);	
$template = str_replace("%end_date%",$new_date_end,$template);	
$template = str_replace("%nation%",$get_myteam_events[0]['nation'],$template);	
$template = str_replace("%competition%",$get_myteam_events[0]['competition_name'],$template);	

 ?>
<div class="container">
<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 evedetail-outer">
		
			 <h3 style="font-family:inherit" class="text-center"><img src="<?php echo base_url();?>assets/images/all-event.png"> Event Detail</h3>
		
			<div class="bottom-txt-container eve-inner-content">
				<!--<div class="heading">StreamSports?</div>-->                                       
				<p>
				<?php echo $template;
	 //echo $meta_article; ?></p>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view("includes/footer"); ?>
<!-- footer --> 
<!-- copy right -->

<!-- copy right --> 
<!-- Page Wrapper --> 

<!-- End Page Wrapper --> 

<!-- JavaScripts --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/own-menu.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.sticky.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/button.js"></script>
</body>
</html>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<script type="application/javascript">
$('.myhighlight').click(function(){
	var type = $(this).data("id");	
	var value = $(this).data("value");	
	//alert(type)
	$.post("<?php echo base_url();?>home/get_video",{
		category : type,
		event_id : value
	}).done(function(data){
		console.log(data)
		data = JSON.parse(data);
		if(data == "No Results") {
			//alert();
			$("#error").text('No highlight added for this Category');
			$("#video").hide();
			$("#related_highlights").hide();
			$("#video-container").hide();
		} 
		else {
			$("#video").show();
			$("#video-container").show();
			$("#related_highlights").show();
			$("#error").text("");
			$("#related_highlights").html(data.related_videos);
			document.getElementById('video').innerHTML = data.first_video;
		}
	});
});

function change_video(video_id){
		$.post("<?php echo base_url();?>home/get_selected_video",{
		vid_id : video_id
	}).done(function(data){
		document.getElementById('video').innerHTML = data;
	});
}

$(".mob-nav").click(function(){
    $("#mob-navig").toggle();
});	
	
</script>
