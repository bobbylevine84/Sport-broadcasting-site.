<div id="mainContainer"><style>
tr:nth-child(even) {background: #f1f1f1}
span.a {
    float: left;
}

.goal-outer {padding:5px; border-bottom:1px solid #ddd; margin-bottom:0px; transition: all 0.5s ease; font-weight:bold;}

span.b {
    float: right;
}

.stats-mid{text-align:center;     font-weight: bold; font-size:12px;}
.stats-count {font-size:12px; font-weight:bold;}

span.score2 {
    float: right;
}
span.score1 {
    float: left;
}

.evedetail-outer h3, .line-up-outer h3 {
    padding: 8px 7px;
}

#table-container .filter-container {
    padding: 4px 10px;
}
.positive, .negative{
cursor: pointer;
}


/* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
.modal {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                url('http://i.stack.imgur.com/FhHRx.gif') 
                50% 50% 
                no-repeat;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .modal {
    display: block;
}
</style>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link href="https://file.myfontastic.com/n6vo44Re5QaWo8oCKShBs7/icons.css" rel="stylesheet">	
	<?php $rss = $this->load->database('rss', TRUE);  
	//echo "<strong>Coming Soon</strong><br><br><br>"; 
	//echo "<a href='".base_url()."admin'>Go to admin panel</a>";
?><?php// echo "<pre>"; print_r($get_myteam_events);exit;

?>
<?php $new_session_time= $this->session->userdata('time_formate') * 60 * 60; $current_date = gmdate('Y-m-d H:i:s');	?>

<!DOCTYPE html>

<?php  $meta_title = str_replace("%duration%",$duration,$meta_title);
							$meta_title = str_replace("%home_team%",$get_myteam_events[0]['home_team'],$meta_title);	
							$meta_title = str_replace("%away_team%",$get_myteam_events[0]['away_team'],$meta_title);	
							$meta_title = str_replace("%start_date%",$new_date_start,$meta_title);	
							$meta_title = str_replace("%end_date%",$new_date_end,$meta_title);	
							$meta_title = str_replace("%nation%",$get_myteam_events[0]['nation'],$meta_title);	
							$meta_title = str_replace("%competition%",$get_myteam_events[0]['competition_name'],$meta_title);

							$meta_keyword = str_replace("%duration%",$duration,$meta_keyword);
							$meta_keyword = str_replace("%home_team%",$get_myteam_events[0]['home_team'],$meta_keyword);	
							$meta_keyword = str_replace("%away_team%",$get_myteam_events[0]['away_team'],$meta_keyword);	
							$meta_keyword = str_replace("%start_date%",$new_date_start,$meta_keyword);	
							$meta_keyword = str_replace("%end_date%",$new_date_end,$meta_keyword);	
							$meta_keyword = str_replace("%nation%",$get_myteam_events[0]['nation'],$meta_keyword);	
							$meta_keyword = str_replace("%competition%",$get_myteam_events[0]['competition_name'],$meta_keyword);	

							$meta_description = str_replace("%duration%",$duration,$meta_description);
							$meta_description = str_replace("%home_team%",$get_myteam_events[0]['home_team'],$meta_description);	
							$meta_description = str_replace("%away_team%",$get_myteam_events[0]['away_team'],$meta_description);	
							$meta_description = str_replace("%start_date%",$new_date_start,$meta_description);	
							$meta_description = str_replace("%end_date%",$new_date_end,$meta_description);	
							$meta_description = str_replace("%nation%",$get_myteam_events[0]['nation'],$meta_description);	
							$meta_description = str_replace("%competition%",$get_myteam_events[0]['competition_name'],$meta_description); ?>
<html lang="en">
    <head>
     <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		
		<?php echo $meta_title; ?>
		
	</title>
  <?php echo $meta_description; ?>
  <?php echo $meta_keyword;?>
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
						<a href="<?php echo base_url();?>livestreaming/<?php if($sports_arr[$i]['category_name'] == "Soccer") { $sports_arr[$i]['category_name'] ="Football"; } echo str_replace(' ', '-', strtolower($sports_arr[$i]['category_name']));?>">
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
							<a href="<?php echo base_url();?>livestreaming/<?php if($sports_arr[$i]['category_name'] == "Soccer") { $sports_arr[$i]['category_name'] ="Football"; } echo str_replace(' ', '-', strtolower($sports_arr[$i]['category_name']));?>">
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


<!-- welcome container -->
<div class="clearfix"></div>
<!-- table container -->

<!-- table container -->

<div class="clearfix"></div>
<!-- news container -->



<section id="result-container" style ="background:#F5F5F5;">

	<!--
	<a href="<?php //echo base_url();?>home/get_team_events_highlights/<?php// echo $get_myteam_events[0]['id'];?>" class="btn btn-success">View highlight</a>
	-->
	

<?php foreach($get_myteam_events as $team) { ?>

    <div class="new-result-container">
    
        <div class="breadcrumbs <?php echo $this->session->userdata('session_color').'-style'?>">
            <div class="container">
                <div>
                  <a href="<?php echo base_url();?>livestreaming/<?php echo str_replace(' ', '-', strtolower($team['category_name']));?>"><?php echo $team['category_name'];?>  </a>

                                 </div>
                <div>
                    <a href="<?php echo base_url();?>nations/<?php if($team['category_name'] == "Soccer") { $team['category_name'] = "football"; } echo str_replace(' ', '-', $team['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $team['nation']));?>"><?php if(strlen($team['nation'])>25) {
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
                    <a href="<?php echo base_url();?>competitions/<?php echo $team['competition_id'];?>/<?php if($team['category_name'] == "Soccer") { $team['category_name'] = "football"; } echo str_replace(' ', '-', $team['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $team['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $team['competition_name'])));?>"><?php
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
                    <a <?php if ($team['category_name']=="Tennis") echo "title"; else echo "href"; ?>="<?php echo base_url();?>teams/<?php echo ucwords($team['home_team_id']); ?>/<?php if($team['category_name'] == "Soccer") { $team['category_name'] = "football"; } echo str_replace(' ', '-', $team['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $team['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $team['home_team']));?>"><span><?php echo ucwords($team['home_team']);?></span></a> vs <a <?php if ($team['category_name']=="Tennis") echo "title"; else echo "href"; ?>="<?php echo base_url();?>teams/<?php echo ucwords($team['away_team_id']); ?>/<?php if($team['category_name'] == "Soccer") { $team['category_name'] = "football"; } echo str_replace(' ', '-', $team['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $team['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $team['away_team']));?>"><span><?php echo ucwords($team['away_team']);?></span></a>
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
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
									?>
									<img src="<?php echo base_url() . $query['headshot_image']; ?>" >
									<?php } else {?>
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png">

									<?php } ?>
									<?php } else if($team['home_team_logo'] == '' || $team['home_team_logo'] == '/images/teams/default.png' ) { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $team['sport_name'];?>-default.png" class="img-responsive">
									
									<?php } else { ?>
									<img src='<?php echo $team['home_team_logo'];?>' class="img-responsive">
									<?php } ?>
                             <span></span>
                    </div>
                    <h2>
                        <?php if($team['category_name']== "Tennis" || $team['category_name']== "MotorSports" || $team['category_name']== "Other" || $team['category_name']== "Golf") {?>
									<a><?php echo ucwords($team['home_team']);?></a>
										<?php } else{?>
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($team['home_team_id']); ?>/<?php if($team['category_name'] == "Soccer") { $team['category_name'] = "football"; } echo str_replace(' ', '-', $team['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $team['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $team['home_team']));?>"><?php echo ucwords($team['home_team']);?></a>


								<?php 	}?>
                    </h2>
                     <div class="btn-group-centerized statistics">
                    <?php if ($team['category_name'] != "Tennis" && $team['category_name'] != "Golf" && $team['category_name'] != "MotorSports" && $team['category_name'] != "Other" && $team['category_name'] != "Fighting"){ 

                    
							
							$status_of_event = explode('-',$team['events_status']); 
							
					
										
										$rss->where('home_team_id',$get_myteam_events[0]['home_team_id']);
										$rss->where('events_status !=',' ');
										$rss->limit('5');
										$rss->where('id !=',$team['id']);
										$rss->group_by('id');
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
                          		<?php if($team['round_name']){?><span>Round Name</span> : <?php echo $team['round_name']; } else { if($team['round_id']) { ?> Round  : <?php echo $team['round_id']; } } ?>
                        </p>
                        <p>
                            <span>Date:</span> <?php echo date('j', (strtotime($team['start_date']))+ $new_session_time);?>
						<?php echo date('F', (strtotime($team['start_date']))); ?>
						<?php echo date('o', (strtotime($team['start_date']))); ?>
					
                        </p>
                        <p>
                            <span>Time:</span> <?php echo date('G:i', (strtotime($team['start_date']) + $new_session_time));?>	<?php  $rss->select('game_minute');
							$rss->where('event_id',$event_id);
							$minute = $rss->get('rss_event_details')->result(); echo $minute[0]->game_minute ?><br />
                        </p>
                    </div>
                    <div class="count">
                        <span><?php if($status_of_event[0] == '') { echo "-"; } else { echo $status_of_event[0]; }  ?></span> : <span><?php if($status_of_event[1] == '') { echo "-"; } else { echo $status_of_event[1]; }  ?></span>
                    </div>
                    	
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
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png' && $query['headshot_image'] != '/images/players/tennisplayer.png'){
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
                            <?php if($team['category_name']== "Tennis" || $team['category_name']== "MotorSports" || $team['category_name']== "Other" || $team['category_name']== "Golf") {?>
									<a><?php echo ucwords($team['away_team']);?></a>
										<?php } else{?>
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($team['away_team_id']); ?>/<?php if($team['category_name'] == "Soccer") { $team['category_name'] = "football"; } echo str_replace(' ', '-', $team['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $team['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $team['away_team']));?>"><?php echo ucwords($team['away_team']);?></a>


								<?php 	}?>
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
     <?php if(date('Y-m-d H:i:s', (strtotime($team['start_date']))) >= $current_date && date('Y-m-d H:i:s', (strtotime($team['end_date']))) ) :?>
         <script type="text/javascript" src="<?php echo base_url();?>assets/jquery.countdown.min.js"></script>
        <script>
mydate = $('#getting_timer').val();
var mydate = new Date(mydate);

        $("#getting-started")
   .countdown(mydate, function (event) {
       $(this).html(
         event.strftime('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><span>%D</span>Days</div>' +
                        '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><span>%H</span>Hours</div>' +
                        '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><span>%M</span>Minutes</div>' +
                        '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><span>%S</span>Seconds</div><div class="clearfix"></div>')
  );
});</script>
        <?php else:  ?>
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

                    	<?php endif; } 
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
<!-- Stream container -->
<div class="clearfix"></div>
<!-- highlight container -->



													
<section id="highlight-container" class="highlight-container-<?php echo $this->session->userdata('session_color');?>" style="padding:0">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div id="table-container" style="padding:30px 0 0 0; margin:0; background:none; border:none">
					<div class="container">
					
						<div class="stream-container">
						<!-- Goals -->
						<?php
							//echo $event_id;
							$rss->select('match_goals');
							$rss->where('event_id',$event_id);
							$json = $rss->get('rss_event_details')->result_array(); 
							//$json_count = $rss->get('rss_event_details')->num_rows();
							//echo "<pre>";print_r($json);
							?>
						<?php if($json[0]['match_goals'] != ''){?>
							<div class = "row">
							<div class="col-md-12 line-up-outer table-responsive">
							<h3 class="text-center" style="font-size:20px; font-family:inherit"> <img src="<?php echo base_url();?>assets/images/goals.png"> Goals</h3>
							
						<div class="col-md-12">
						
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
		 <!-- End Of ROW -->
							<div class="filter-container" style="margin:15px 0 0 0; ">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="stream-type"><img src="<?php echo base_url();?>assets/images/http.png"> HTTP Streams <!-- (<a href="">Jump to P2P streams</a>)--></div>
									</div>
								</div>
							</div>
							<div class="table-content http" style="margin-top:10px;">

								<div class="table-responsive">
									<table class="table table-striped table-<?php echo $this->session->userdata('session_color');?>-stream text-center" id="manage_streams">
										<thead class="<?php echo $this->session->userdata('session_color'); ?>-thead">
										  <tr>
											<th style="width:15%" class="text-center text-center-1">Rating</th>
											<th style="width:15%" class="text-center text-center-1">Bitrate</th>
											<th  style="width:15%" class="text-center text-center-1">Language</th>
											<th  style="width:15%" class="text-center text-center-1">Compatibilty</th>
											<th  style="width:15%" class="text-center text-center-1">Type</th>
											<th  style="width:10%" class="text-center text-center-1">Links</th>
										  </tr>
										</thead>
										<tbody>
											<?php foreach($sponsored_stream as $sp){?>
											<tr  class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
												<td>
												<div class="event-data <?php echo $this->session->userdata('session_color').'-event-data';?> stream-padding">
												100%
												</div>
												</td>
												<td>
												<div class="event-data <?php echo $this->session->userdata('session_color').'-event-data';?> stream-padding">
												<?= $sp['bitrate']?></td>
												<td>
												<div class="event-data <?php echo $this->session->userdata('session_color').'-event-data';?> stream-padding">
												<?= $sp['lang']?></td>
												<td>
												<div class="event-data <?php echo $this->session->userdata('session_color').'-event-data';?> stream-padding">
												All</td>
												<td>
												<div class="event-data <?php echo $this->session->userdata('session_color').'-event-data';?> stream-padding">
												Sponsored</td>
												<td><div class="play-now"><a target="_blank" href="<?php echo $sp['url'];?>">
                                                        <i class="fa fa-play-circle-o play-btn-stream <?php echo $this->session->userdata('session_color');?>-play-btn-stream"></i>
                                                       <?php /*?> <img src="<?php echo base_url();?>images/play.png"><?php */?></a></div></td>
											</tr>
											<?php } ?>
											<?php foreach($stream as $s){?>
											
												<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
													<td><!--<span class="event-txt">-->
														<div class="rating">
															<div class="row">
																
																<?php /*?><div class="col-xs-3 text-right" style="padding-right:0">
																	<a href="<?php echo base_url();?>home/ratings/<?php echo $s['id'];?>/1/<?php echo $s['event_id_stream'];?>"> 
																		<?php if($s['ip_address'] != ''){} else { ?>
																		<div class="positive-vote">
																			<i class="fa fa-thumbs-up"></i>
																		</div> 
																		<?php } ?>
																	</a> 
																</div><?php */?>
																<div class="<?php echo $this->session->userdata('session_color').'-event-data';?> text-center" style="padding-left:0; padding-right:0"><?php //if($s['stream_rating'] >= 60){ ?>
																<a class="positive" value="<?php echo $s['id'];?>"> 
																		<?php if($s['ip_address'] != ''){} else { ?>
																		<div id ="positive-vote-<?php echo $s['id'];?>" class="positive-vote">
																			
																			
																			<input id="event_id" type = 'hidden' value="<?php echo $s['event_id_stream'];?>">
																			<span><i class="fa fa-arrow-up"></i></span>
																		</div> 
																		<?php } ?>
																	</a> 
                                                                
																	<div id = "right-smile1-<?php echo $s['id'];?>" class="right-smile1">
																																	
																		<?php
																		if($s['stream_rating']>100){
																		echo "100"; } 
																		else if($s['stream_rating']<0){ 
																		echo "0"; } else{ echo $s['stream_rating']; } 
																		?> % 
																	</div>
                                                                    <a class="negative" value="<?php echo $s['id'];?>">
																		<?php if($s['ip_address'] != ''){} else { ?>
																		<div id = "negative-vote-<?php echo $s['id'];?>" class="negative-vote">
																			<span><i class="fa fa-arrow-down"></i></span>
																		</div>
																		<?php } ?>
																	</a>
																</div>
																																										
															</div> 
														</div>
													</td>
													<td> <!-- ammar2 -->
														<div class="event-data <?php echo $this->session->userdata('session_color').'-event-data';?> stream-padding">
															<?php
																if($s['total_bitrate']){
																	$my_bitrate = $s['total_bitrate'];
																$pos = strpos($my_bitrate, 'kbps');
																
																?>
																<span class="event-txt">
																<?php
																
																if ($pos !== false) {
																	echo $s['total_bitrate'];
																} else {
																	 echo $s['total_bitrate'];
																} 

																}
															?>
														
															 </span>
														</div>
													</td>
													<td>
													<?php
														$this->db->where('name',$s['language']);
														$lan = $this->db->get('kt_language_logo')->result_array();
													?>
														
														<div class="event-data <?php echo $this->session->userdata('session_color').'-event-data';?> stream-padding">
															<span class="event-txt">
															<?php foreach($lan as $l){ ?>
															
																<img src="<?php echo base_url();?>admin/uploads/game_images/<?php echo ucwords(strtolower($l['lang_logo']));?>">
															<?php } ?>
															<?php if($s['language'] == ''){ echo "None"; } else { echo $s['language']; } ?></span>
														</div>
													</td>
													<td>
														<div class="event-data <?php echo $this->session->userdata('session_color').'-event-data';?> stream-padding">
																<span class="event-txt"><?php if($s['compatibility'] == "Yes") { ?><i class="fa fa-mobile"></i> <?php } ?><?php if($s['compatibility'] == '') { echo "None"; } else { echo $s['compatibility']; } ?></span>
														</div>
														
														
													</td>
													<td>
														<div class="event-data <?php echo $this->session->userdata('session_color').'-event-data';?> stream-padding">
															<span class="event-txt"><?php if($s['type'] == '') { echo "None"; } else { echo $s['type']; } ?>
															<?php if($s['sponsered'] == "1") { echo "(sponsered)"; } ?>
															</span>
														</div>
													</td>
													<td>
														<div class="play-now"><a target="_blank" href="<?php echo $s['url'];?>">
                                                        <i class="fa fa-play-circle-o play-btn-stream <?php echo $this->session->userdata('session_color');?>-play-btn-stream"></i>
                                                       <?php /*?> <img src="<?php echo base_url();?>images/play.png"><?php */?></a></div>
													</td>
											  </tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div id="table-container" style="padding:30px 0 0 0; margin:0; background:none; border:none">
					<div class="container">
						<div class="stream-container">
							<div class="filter-container" style="margin:0">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="stream-type"><img src="<?php echo base_url();?>assets/images/p2p.png"> P2P Streams <!-- (<a href="">Jump to P2P streams</a>)--></div>
									</div>
								</div>
							</div>
							<div class="table-content" style="margin-top:10px;">

								<div class="table-responsive">
									<table class="table table-striped table-<?php echo $this->session->userdata('session_color');?>-stream text-center" id="manage_p2p_streams">
										<thead class="<?php echo $this->session->userdata('session_color'); ?>-thead">
										  <tr>
											<th style="width:15%" class="text-center text-center-1">Rating</th>
											<th style="width:15%" class="text-center text-center-1">Bitrate</th>
											<th  style="width:15%" class="text-center text-center-1">Language</th>
											<th  style="width:15%" class="text-center text-center-1">Compatibilty</th>
											<th  style="width:15%" class="text-center text-center-1">Type</th>
											<th  style="width:10%" class="text-center text-center-1">Links</th>
										  </tr>
										</thead>
										<tbody>

										
										<?php foreach($p2p as $s){ ?>
                                        
                                        <tr class="white-color <?php echo $this->session->userdata('session_color');?>-color <?php echo $this->session->userdata('session_color');?>-hover">
										<td><!--<span class="event-txt">-->
												<div class="rating">
													<div class="row">
														
														<?php /*?><div class="col-xs-3 text-right" style="padding-right:0">
															<a href="<?php echo base_url();?>home/ratings/<?php echo $s['id'];?>/1/<?php echo $s['event_id_stream'];?>"> 
																<?php if($s['ip_address'] != ''){} else { ?>
																<div class="positive-vote">
																	<i class="fa fa-thumbs-up"></i>
																</div> 
																<?php } ?>
															</a> 
														</div><?php */?>
														<div class="<?php echo $this->session->userdata('session_color').'-event-data';?> text-center" style="padding-left:0; padding-right:0"><?php //if($s['stream_rating'] >= 60){ ?>
                                                      <a class="positive" value="<?php echo $s['id'];?>"> 
																		<?php if($s['ip_address'] != ''){} else { ?>
																		<div id ="positive-vote-<?php echo $s['id'];?>" class="positive-vote">
																			
																			
																			<input id="event_id" type = 'hidden' value="<?php echo $s['event_id_stream'];?>">
																			<span><i class="fa fa-arrow-up"></i></span>
																		</div> 
																		<?php } ?>
																	</a> 
                                                                
																	<div id = "right-smile1-<?php echo $s['id'];?>" class="right-smile1">
																																	
																		<?php
																		if($s['stream_rating']>100){
																		echo "100"; } 
																		else if($s['stream_rating']<0){ 
																		echo "0"; } else{ echo $s['stream_rating']; } 
																		?> % 
																	</div>
                                                                    <a class="negative" value="<?php echo $s['id'];?>">
																		<?php if($s['ip_address'] != ''){} else { ?>
																		<div id = "negative-vote-<?php echo $s['id'];?>" class="negative-vote">
																			<span><i class="fa fa-arrow-down"></i></span>
																		</div>
																<?php } ?>
															</a> 
														</div>
														
														<?php /*?><div class="col-xs-3 text-left">
															<a href="<?php echo base_url();?>home/ratings/<?php echo $s['id'];?>/0/<?php echo $s['event_id_stream'];?>">
																<?php if($s['ip_address'] != ''){} else { ?>
																<div class="negative-vote">
																	<i class="fa fa-thumbs-down"></i>
																</div>
																<?php } ?>
															</a>
														</div><?php */?>
														
													</div> 
												</div>
											</td>
											<td>
												<div class="event-data <?php echo $this->session->userdata('session_color').'-event-data';?> stream-padding">
													<?php
													if($s['total_bitrate']){
														$my_bitrate = $s['total_bitrate'];
													$pos = strpos($my_bitrate, 'kbps');
													
													?>
													<span class="event-txt"><?php
													
													if ($pos !== false) {
														echo $s['total_bitrate'];
													} else {
														 echo $s['total_bitrate'];
													} 

													}  ?>
													
													 </span>
												</div>
											</td>
											<td>
											<?php
												$this->db->where('name',$s['language']);
												$lan2 = $this->db->get('kt_language_logo')->result_array();
													?>
											
												<div class="event-data <?php echo $this->session->userdata('session_color').'-event-data';?> stream-padding">
													<span class="event-txt">
													<?php foreach($lan2 as $l2) { ?>
													<img src="<?php echo base_url();?>admin/uploads/game_images/<?php echo ucwords(strtolower($l2['lang_logo']));?>">
													<?php } ?>
													<?php echo $s['language'];?>
													
													</span>
												</div>
												
											</td>
											<td>
												<div class="event-data <?php echo $this->session->userdata('session_color').'-event-data';?> stream-padding">
													<span class="event-txt"><?php if($s['compatibility'] == "Yes") { ?><i class="fa fa-mobile"></i> <?php } ?><?php echo $s['compatibility']?></span>
												</div>
											</td>
											<td>
												<div class="event-data <?php echo $this->session->userdata('session_color').'-event-data';?> stream-padding">
													<span class="event-txt"><?php echo $s['type'];?>
													<?php if($s['sponsered'] == "1") { echo "(sponsered)"; } ?>
													</span>
												</div>
											</td>
											<td>
												<div class="play-now"><a target="_blank" href="<?php echo $s['url'];?>">
												<i class="fa fa-play-circle-o play-btn-stream <?php echo $this->session->userdata('session_color');?>-play-btn-stream"></i>
                                                <?php /*?><img src="<?php echo base_url();?>images/play.png"><?php */?></a>
                                                </div>
											</td>
										</tr>
										<?php } ?>
                                       
										
										</tbody>
									</table>
								</div>
							</div>
							<?php
							// Template HERE
							$event_details = $this->db->get('kt_event_detail')->result_array();
							if(!empty($event_details)){
							$template = $meta_article;
							
							$new_date_start = date('j', (strtotime($get_myteam_events[0]['start_date']))+ $new_session_time).' '.date('M', (strtotime($get_myteam_events[0]['start_date']))+ $new_session_time).' '.date('G:i', (strtotime($get_myteam_events[0]['start_date']))+ $new_session_time);
							
							$new_date_end = date('j', (strtotime($get_myteam_events[0]['end_date']))+ $new_session_time).' '.date('M', (strtotime($get_myteam_events[0]['end_date']))+ $new_session_time).' '.date('G:i', (strtotime($get_myteam_events[0]['end_date']))+ $new_session_time);
							
							
							
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


							}
							


							?>
							
							<!-- Stats -->
							<?php ?>
							<?php
							//echo $event_id;
							$team1 = $get_myteam_events[0]['home_team'];
							$team2 = $get_myteam_events[0]['away_team'];
							$rss->select('match_stats');
							$rss->where('event_id',$event_id);
							$json = $rss->get('rss_event_details')->result_array(); 
							//$json_count = $rss->get('rss_event_details')->num_rows();
							//echo "<pre>";print_r($json);
							if($json[0]['match_stats'] != '') {
							?>
							<div class = "row">
							<div class="col-md-12 line-up-outer table-responsive">
							<h3 class="text-center" style="font-size:20px; font-family:inherit"><img src="<?php echo base_url();?>assets/images/mstats.png"> Match Stats</h3>
							
							<table class="table <?php echo $this->session->userdata('session_color').'-';?>match-stats table-bordered">
							<tr>
								<th background="#ccc" width="15%"><?php echo ucwords($get_myteam_events[0]['home_team']); ?></th>
								<th background="#ccc" align="center" style="text-align:center;">Team Stats</th>
								<th background="#ccc" width="20%"><?php echo ucwords($get_myteam_events[0]['away_team']); ?></th>
								
							</tr>
							
							<?php
							//echo "<pre>";print_r($json);
							if($json){
								foreach($json as $j) {
								
								$my_arr= json_decode($j['match_stats'],true);
								if($my_arr){
							//	echo "<pre>";print_r($my_arr);
								$fouls = explode(':',$my_arr['Fouls']);$corner = explode(':',$my_arr['Corners']);$throw = explode(':',$my_arr['Throw Ins']);
								$shots = explode(':',$my_arr['Shots (on target)']);$shots2 = explode(':',$my_arr['Shots (off target)']);$attack = explode(':',$my_arr['Attacks (Dangerous)']);
								$shots3 = explode(':',$my_arr['Shots (blocked)']);$kicks = explode(':',$my_arr['Goal Kicks']);$free = explode(':',$my_arr['Free Kicks']);$Offsides = explode(':',$my_arr['Offsides']);
								 ?>
									<!--<tr>
										<td><?php echo ucwords($get_myteam_events[0]['home_team']); ?></td>
										<td style="text-align:center">Team Name</td>
										<td><?php echo ucwords($get_myteam_events[0]['away_team']); ?></td>
									</tr>-->
									<tr>
										<td><?php echo $fouls[0]; ?></td>
											<td style="text-align:center">
												<span class="team-a"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>" style="width:<?php echo $fouls[0]+50 .'%';?>"></div>--></span>
												<span class="team-action">Fouls</span>
												<span class="team-b"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $fouls[1]+50 .'%';?>"></div>--></span>
											</td>
										<td><?php echo $fouls[1]; ?></td>
									</tr>
									<tr>
										<td><?php echo $corner[0]; ?></td>
											<td style="text-align:center">
												<span class="team-a"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $corner[0]+50 .'%';?>"></div>--></span>
												<span class="team-action">Corners</span>
												<span class="team-b"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $corner[1]+50 .'%';?>"></div>--></span>
											</td>
										<td><?php echo $corner[1]; ?></td>
									</tr>
									<tr>
										<td><?php echo $throw[0]; ?></td>
											<td style="text-align:center">
												<span class="team-a"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $throw[0]+50 .'%';?>"></div>--></span>
												<span class="team-action">Throw Ins</span>
												<span class="team-b"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $throw[1]+50 .'%';?>"></div>--></span>
											</td>
										<td><?php echo $throw[1]; ?></td>
									</tr>
									<tr>
										<td><?php echo $shots[0]; ?></td>
											<td style="text-align:center">
												<span class="team-a"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $shots[0]+50 .'%';?>"></div>--></span>
												<span class="team-action">Shots (on target)</span>
												<span class="team-b"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $shots[1]+50 .'%';?>"></div>--></span>
											</td>
										<td><?php echo $shots[1]; ?></td>
									</tr>
									<tr>
										<td><?php echo $shots2[0]; ?></td>
											<td style="text-align:center">
												<span class="team-a"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $shots2[0]+50 .'%';?>"></div>--></span>
												<span class="team-action">Shots (off target)</span>
												<span class="team-b"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $shots2[1]+50 .'%';?>"></div>--></span>
											</td>
										<td><?php echo $shots2[1]; ?></td>
									</tr>
									<tr>
										<td><?php echo $attack[0]; ?></td>
											<td style="text-align:center">
												<span class="team-a"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $attack[0]+50 .'%';?>"></div>--></span>
												<span class="team-action">Attacks (Dangerous)</span>
												<span class="team-b"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $attack[1]+50 .'%';?>"></div>--></span>
											</td>
										<td><?php echo $attack[1]; ?></td>
									</tr>
									<tr>
										<td><?php echo $shots3[0]; ?></td>
											<td style="text-align:center">
												<span class="team-a"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $shots3[0]+50 .'%';?>"></div>--></span>
												<span class="team-action">Shots (blocked)</span>
												<span class="team-b"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $shots3[1]+50 .'%';?>"></div>--></span>
											</td>
										<td><?php echo $shots3[1]; ?></td>
									</tr>
									<tr>
										<td><?php echo $kicks[0]; ?></td>
											<td style="text-align:center">
												<span class="team-a"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $kicks[0]+50 .'%';?>"></div>--></span>
												<span class="team-action">Goal Kicks</span>
												<span class="team-b"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $kicks[1]+50 .'%';?>"></div>--></span>
											</td>
										<td><?php echo $kicks[1]; ?></td>
									</tr>
									<tr>
										<td><?php echo $free[0]; ?></td>
											<td style="text-align:center">
												<span class="team-a"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $free[0]+50 .'%';?>"></div>--></span>
												<span class="team-action">Free Kicks</span>
												<span class="team-b"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $free[1]+50 .'%';?>"></div>--></span>
											</td>
										<td><?php echo $free[1]; ?></td>
									</tr>
									<tr>
										<td><?php echo $Offsides[0]; ?></td>
											<td style="text-align:center">
												<span class="team-a"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $Offsides[0]+50 .'%';?>"></div>--></span>
												<span class="team-action">Offsides</span>
												<span class="team-b"><!--<div class="team-inner <?php echo $this->session->userdata('session_color').'-team-inner';?>"  style="width:<?php echo $Offsides[1]+50 .'%';?>"></div>--></span>
											</td>
										<td><?php echo $Offsides[1]; ?></td>
									</tr>
								
								<?php } else { echo "No match_stats Yet."; }
								}
							}  else { echo "No match_stats Yet"; }
							
							?>
							
							</table> 
						</div>

						
					</div>
					<?php } ?>
		 <!-- End Of ROW -->
			<?php if($get_myteam_events[0]['sport_name'] == 'tennis') { } else {  ?>
			<?php 
			//echo $event_id;
				$team1 = $get_myteam_events[0]['home_team'];
				$team2 = $get_myteam_events[0]['away_team'];
				$rss->select('lineups');
				$rss->where('event_id',$event_id);
				$json = $rss->get('rss_event_details')->result_array();

				//echo "<pre>";print_r($json);
				if($json[0]['lineups'] != ''){
			?>
            <div class = "row">
			<div class="col-md-12 line-up-outer">
				<h3 style="font-family:inherit" class="text-center"><img src="<?php echo base_url();?>assets/images/lineup.png"> Line UP</h3>
                
				<?php
				
					foreach($json as $j) {
					// echo "<pre>"; print_r(json_decode($j['lineups'],true));
					$my_array= json_decode($j['lineups'],true);
					foreach($my_array AS $key=>$each_val){
						// team name
						?>
						<div class="col-md-6 line-up-table <?php echo $this->session->userdata('session_color');?>-lineup" style="padding-left:0">

							<span style="font-size:14px; font-weight:bold"><?php echo $key; ?></span>
							<table class="table table-bordered">
								
								<?php
								if($each_val) {
									foreach($each_val AS $result_each){
									// echo $result_each['name'];
									
									//$rss->select('DISTINCT headshot_image', FALSE) ;
									$rss->where('player_name = ',$result_each['name']);
									$rss->group_by('headshot_image');
									$a = $rss->get('rss_players')->result_array();
									foreach($a As $i) {
										
									
									//echo "<pre>";print_r($a);
									?>
									<tr>
										<td width="2%"><img style="width:25px;height:25px;"src="<?php echo $i['headshot_image']; ?>"></td>
										<td width="2%"><?php echo $result_each['shirt-number']; ?></td>
										<td width="88%"><?php echo $result_each['name']; ?></td>
										<td  width="10%" valign="middle" class="flag-img-style">
										<?php 
										
										if (file_exists($_SERVER["DOCUMENT_ROOT"].'/wiziwig/Flags/'.$result_each["nation"].'.png')) {?>
											<img width="24" height="24" src="<?php echo base_url();?>images/Flags/<?php echo $result_each['nation'].'.png'; ?>">
										<?php }else{?>
											<img width="24" height="24" src="<?php echo base_url();?>images/Flags/default_flag.png">
										<?php }
										?>
										
										</td>
									</tr>
									<?php
										}
									}
								}
								
								?>
							</table>
						</div>
						<?php
						}
					}
				 /*else { echo "No Line Up Yet."; }*/
				
				?>
			</div>

			
		</div>
		<?php }?>
		<!-- End Of ROW -->
		<?php 
		//echo $event_id;
				$team1 = $get_myteam_events[0]['home_team'];
				$team2 = $get_myteam_events[0]['away_team'];
				$rss->select('substitutes');
				$rss->where('event_id',$event_id);
				$json = $rss->get('rss_event_details')->result_array();
				
				
			//	echo $json[0]['substitutes'];
				if($json[0]['substitutes'] != ''){
		?>
		<div class = "row">
			<div class="col-md-12 line-up-outer outer1">
				<h3 class="text-center" style="font-size:20px; font-family:inherit"><img src="<?php echo base_url();?>assets/images/substit.png"> Substitutions</h3>
				<?php
				
					foreach($json as $j) {
					// echo "<pre>"; print_r(json_decode($j['substitutes'],true));
					$my_array= json_decode($j['substitutes'],true);
					foreach($my_array AS $key=>$each_val){
						// team name
						?>
						<div class="col-md-6 line-up-table <?php echo $this->session->userdata('session_color');?>-lineup" style="padding-left:0">

							<?php ///echo $key; ?>
							<table class="table table-bordered">
								
								<?php
								if($each_val){
									foreach($each_val AS $result_each){
									// echo $result_each['name'];
									$rss->where('player_name = ',$result_each['name']);
									$a = $rss->get('rss_players')->result_array();
									foreach($a As $i) {
									?>
									<tr>
										<td width="2%"><img style="width:25px;height:25px;"src="<?php echo $i['headshot_image']; ?>"></td>
										<td width="2%"><?php echo $result_each['shirt-number']; ?></td>
										<td width="88%"><?php echo $result_each['name']; ?></td>
										<td width="10%" valign="middle" class="flag-img-style"><?php 
										
										if (file_exists($_SERVER["DOCUMENT_ROOT"].'/wiziwig/Flags/'.$result_each["nation"].'.png')) {?>
											<img width="24" height="24" src="<?php echo base_url();?>images/Flags/<?php echo $result_each['nation'].'.png'; ?>">
										<?php }else{?>
											<img width="24" height="24" src="<?php echo base_url();?>images/Flags/default_flag.png">
										<?php }
										?>
										</td>
									</tr>
									<?php
								} }
								}
								else { echo '<style>.outer1{display: none !important;}</style>';}
								?>
							</table>
						</div>
						<?php
						}
					}
				 /*else {
					echo "No Substitutions Yet.";
				}*/
				
				?>
			</div>

			
		</div>
		<?php }} ?>
		 <!-- End Of ROW -->
		
		 <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 evedetail-outer">
			
				 <h3 style="font-family:inherit" class="text-center"><img src="<?php echo base_url();?>assets/images/all-event.png"> Event Detail</h3>
			
				<div class="bottom-txt-container eve-inner-content">
					<!--<div class="heading">StreamSports?</div>-->                                       
					<p>
					<?php echo $template;
					?>
					<?php //echo $meta_article; ?></p>
				</div>
			</div>
		</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $rss = $this->load->database('rss', TRUE); ?>
		


	</div>
</section>



<!-- footer --> 
<?php $this->load->view("includes/footer"); ?>
<!-- footer --> 
<!-- copy right -->

<!-- copy right --> 
<!-- Page Wrapper --> 

<!-- End Page Wrapper --> 

<!-- JavaScripts --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/DataTable/media/css/jquery.dataTables.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/DataTable/media/css/dataTables.bootstrap.css"/>



<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/DataTable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/DataTable/media/js/dataTables.bootstrap.js"></script>

<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/own-menu.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.sticky.js"></script>







</body>
</html>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/button.js"></script>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<script type="application/javascript">

	$('#manage_streams').dataTable({
		"iDisplayLength": 5,
		"bPaginate": false, //false to disable selection box and pagination
		"bLengthChange": false, //true to show selection box for rows.
		"info": false, // True to show "showing 1 out of 4 fields."
	//	"bLengthChange": true,
		"bFilter": false, //true to make search available.
		"bSearchable": true,
		"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0,1,2,3,4,5] } ],
		//"visible": true
		"aaSorting": [], // Disable Sorting
		"columnDefs": [ { "targets": 0, "orderable": false } ],
		"oLanguage": { "oPaginate": {"sPrevious": "", "sNext": ""} , "sZeroRecords": "Check back later, streams are added 15 minutes before Game start"},
		
	});	
	$('#manage_p2p_streams').dataTable({
		"iDisplayLength": 5,
		"bPaginate": false, //false to disable selection box and pagination
		"bLengthChange": false, //true to show selection box for rows.
		"info": false, // True to show "showing 1 out of 4 fields."
	//	"bLengthChange": true,
		"bFilter": false, //true to make search available.
		"bSearchable": true,
		"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0,1,2,3,4,5] } ],
		//"visible": true
		"aaSorting": [], // Disable Sorting
		"oLanguage": { "oPaginate": {"sPrevious": "", "sNext": ""}, "sZeroRecords": "P2P streams are added just before game start" },
		"columnDefs": [ { "targets": 0, "orderable": false } ],

   
		
	});	
</script>
<script>
$(document).ready(function(){
    $("#success").fadeOut(1500);
});
</script>
<script type="text/javascript">
	var clock;
	var start2 = $('#myclock2').val();
	var start3 = $('#myclock3').val();
	var start = $('#myclock').val();
	console.log(start2);
	console.log(start3);
	
	console.log(start);
	$(document).ready(function() {
		var clock;
		mydate = $('#getting_timer').val();
		
		//alert(mydate);
		var mydates= '" '+mydate+' "';
		var date = new Date(mydates); //Month Days, Year HH:MM:SS
		console.log(mydates);//January 05, 2016 15:10:50
		//var date = new Date("January 06, 2016 02:15:00");
        var now = new Date();
        var diff = (date.getTime()/1000) - (now.getTime()/1000);
console.log(diff);
if(diff<=0){diff=1;}
		clock = $('.clock').FlipClock(diff, {
			clockFace: 'DailyCounter',
			autoStart: false,
			callbacks: {
				stop: function() {
					$('.message').html('Session is over!')
					//$('.live').html('Event is Live!')
					$('.clock').hide();
				}
			}
		});
		//clock.setTime(start);
		//clock.setTime(date);
		clock.setCountdown(true);
		clock.start();
	});
	
$(".mob-nav").click(function(){
    $("#mob-navig").toggle();
});
$('#offset').change(function(){
	
	
		var hour=$('#offset').val();
		$( ".match_time" ).each(function() {
			var time_year = parseInt($( this ).data( "year" ));
			var time_month = parseInt($( this ).data( "month" ));
			var time_day = parseInt($( this ).data( "day" ));
			var time_hour =parseInt($( this ).data( "hour" ));
			var time_minute =parseInt($( this ).data( "minute" ));
			var time_secound =parseInt($( this ).data( "secound" ));
			var time_date=$(this).data('id');
			var mydate = new Date(time_year, time_month-1, time_day, time_hour+(parseInt(hour)), time_minute, time_secound)
			var new_time=moment(mydate).format('HH:mm');
			$(this).html(new_time);
			var new_date=moment(mydate).format('D MMM');
			$('#data_'+time_date).html(new_date);
			
			
			
		});
			});
			$('.offset').change(function(){
				var hour=$('#offset').val();
				$.post("<?php echo base_url();?>home/set_time_in_session",{
				hour : hour,
			}).done(function(data){
				//alert(hour);
				var timer = $('#getting_timer').val();
				
				 var timer1 = timer+(hour*60*60);
				location.reload();
			});
			});	




			$('.positive').click(function(){
				var id=$(this).attr('value');
                var event_id=$('#event_id').val();
                var positive = 1;
                
				
				$.post("<?php echo base_url();?>home/ratings",{
				
                positive : positive,
				id : id,
				event_id : event_id,
			}).done(function(data){
        var rating = data;
        if (rating > 100) {rating = 100}
        if (rating < 0) {rating = 0}
        $("#right-smile1-" + id).html(rating +" %");
        $("#positive-vote-" + id).remove();
        $("#negative-vote-" + id).remove();
			});
			});

		$('.negative').click(function(){
				var id=$(this).attr('value');
                var event_id=$('#event_id').val();
                var positive = 0;
                
				$.post("<?php echo base_url();?>home/ratings",{
				
                positive : positive,
				id : id,
				event_id : event_id,
			}).done(function(data){
			 var rating = data;
        if (rating > 100) {rating = 100}
        if (rating < 0) {rating = 0}
   
        $("#right-smile1-" + id).html(rating +" %");
        $("#positive-vote-" + id).remove();
        $("#negative-vote-" + id).remove();
			});
			});
$body = $("body");

$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
})
</script>


</div>
<div class="modal"><!-- Place at bottom of page --></div>