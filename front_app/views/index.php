         <?php  
?><?php //echo "<pre>"; print_r($events);?>
<?php $new_session_time= $this->session->userdata('time_formate') * 60 * 60; $current_date = gmdate('Y-m-d H:i:s');	?>
<!DOCTYPE html>
<html lang="en">
<?php
	$rss = $this->load->database('rss', TRUE);
	$rss->select('rss_sport_category.category_name');
	$rss->group_by('rss_events.sport_category_id');
	$rss->order_by('start_date');
	$rss->where('rss_sport_category.category_name != ', 'other');
	$rss->where('DATE(rss_events.start_date) =',$this->session->userdata('date_timezone'));
	$rss->join('rss_sport_category','rss_sport_category.id = rss_events.sport_category_id');
	$get_sport_name = $rss->get('rss_events')->result_array();
	?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title> 
       	 <?php echo $meta_title ?>
        </title>
		<?php echo $meta_description;?>
		<?php echo $meta_keyword;?>
	   <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>
  
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
		<!-- For Calender -->
		 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
       <!-- <link rel="stylesheet" href="<?php //echo base_url(); ?>assets/css/demo.css" type="text/css" media="screen" />-->
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,500,700,600,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif] -->

	

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
		   .data-circle:red-color
		   {
			   background-color:red;
		   }
		  #loading-image {
			  position: absolute;
			  top: 7%;
			  left: 50%;
			  z-index: 100;
			}
					   
		   

        </style>
   <!-- </head>
    <body>
<!-- header -->

<?php $this->load->view('includes/header');?>

<!-- header --> 

<!-- banner -->

<?php
// $date = new DateTime('2000-01-01', new DateTimeZone('Pacific/Nauru'));
// echo $date->format('Y-m-d H:i:sP') . "\n";

// $date->setTimezone(new DateTimeZone('Pacific/Chatham'));
// echo $date->format('Y-m-d H:i:sP') . "\n";

?>

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
							<a href="<?php echo base_url();?>livestreaming/<?php echo str_replace(' ', '-', strtolower($sports_arr[$z]['category_name']));?>">
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
<section id="welcome-container" class="welcome-container-<?php echo$this->session->userdata('session_color');?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center index-welcome <?php echo $this->session->userdata('session_color').'-index-welcome'?>">
			<h1 style="text-align:center">Welcome to <strong>REAL STREAM SPORTS</strong> Live sports streaming aggregator.</h1>
<div class="heading-brdr" style="box-sizing: border-box; margin-bottom:-40px !important; margin: 20px auto; padding: 0px; width: 200px; height: 3px; font-family: 'Open Sans', sans-serif; font-size: 12px; text-align: center; line-height: 17.1429px; background: rgb(226, 226, 226);"></div>
			</div>
		</div>
	</div>
</section>
<div id="loading" style="display:none;">
	<img id="loading-image" src="<?php echo base_url();?>hd/ajax-loader.gif" alt="Loading..." />
</div>
<!-- welcome container -->
<div class="clearfix"></div>
<!-- table container -->

<div id="table-container" class="table-container-<?php echo $this->session->userdata('session_color'); ?> ">

<div class="container">
<!--<div id="get_calender" class="get_calender">
	<center><label>Filter By Date</label><input type="button" class="get_datepicker_date form-control btn btn-default" id="datepickers">
	
	<span class="glyphicon glyphicon-calendar"></span>
	
	</center>
</div>-->

<div class="filter-container">
<form>

<?php
		$converted_datetime = gmdate('Y-m-d H:i:s');
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('+1 day');
		$session_date_tommorrow = $datetime->format('Y-m-d');


?>

<div class="row">
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
<label>Filter By Date</label>
<div id="get_calender" class="get_calender">
	<input type="button" class="get_datepicker_date form-control btn btn-default" id="datepicker">
</div>
</div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		<label>Nations</label>
		<?php 
		$rss->select('rss_events.id,rss_events.sport_category_id,rss_events.nation');
		$rss->where('DATE(rss_events.start_date) =',$converted_date  );
		
		$rss->where('rss_events.end_date >= ', $converted_datetime );
		$rss->order_by('start_date','aesc');
		$rss->group_by('rss_events.nation');
		$nation = $rss->get('rss_events')->result_array();
		?>
		<select name="my_nation" id="my_nation">
			<option value="">All Nations</option>
			<?php foreach($nation as $name){?>
			<option value="<?php echo str_replace(' ', '-', $name['nation']);?>"><?php echo ucwords(strtolower($name['nation']));?></option>
			<?php } ?>
		</select> 	 
	</div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		<label>Sports</label>
		<?php
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_sport_category.id,rss_sport_category.category_name');
		$rss->where('DATE(rss_events.start_date) =',$converted_date );
		
		$rss->where('rss_events.end_date >= ', $converted_datetime );
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
			<option  value="<?php echo $sport['id'];?>"><?php if($sport['category_name'] == "Soccer") { $sport['category_name'] = "Football"; } echo ucwords(strtolower($sport['category_name']));?>
			</option>
			<?php } ?>
		</select> 
	</div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		<label>Competitions</label>
		<?php
			$rss->select('rss_competition.competition_id,rss_competition.competition_name');
			$rss->where('DATE(rss_events.start_date) =',$converted_date );
			
			$rss->where('rss_events.end_date >= ', $converted_datetime );
			$rss->join('rss_events','rss_events.competition_id=rss_competition.competition_id');
			$rss->order_by('rss_events.start_date','aesc');
			$rss->group_by('rss_competition.competition_id');
			$competition = $rss->get('rss_competition')->result_array();
			//echo $this->db->last_query();
			?>
		<select name="my_competition" id="my_competition" >
			<option value="">All Competitions</option>
			<?php foreach($competition as $name){?>
			<option value="<?php echo $name['competition_id'];?>"><?php echo strtoupper($name['competition_name']);?></option>
			<?php } ?>
		</select> 
	</div>
    
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
    <label>Live</label>
		<select name="live_events" id="show_live_events" >
			<option value="">All Events</option>
			<option value="live">Live Events</option>
		</select> 
	</div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
    <input id="filter" type="text" class="form-control form-control-fields" placeholder="Search here..." >
	</div>
	
</div>
</form>
</div>
<?php $session_date_time = $this->session->userdata('time_timezone');?>

<div class="table-content">

<div class="table-responsive">

	<table class="table datatable-<?php echo $this->session->userdata('session_color');?> table-striped table-striped-<?php echo $this->session->userdata('session_color');?> text-center" id="manage_events" border="0">
		<thead class="<?php echo $this->session->userdata('session_color'); ?>-thead">
			<tr>
				<th class="brdr-right table-width1 text-center">Sports</th>
				<th class="brdr-right table-width2 text-center">Date</th>
				
				<th class="brdr-right table-width3 text-center">Competitions</th>
				<th colspan="2" class="brdr-right table-width4">

				<span class="col-sm-5  mobile-pad">Home Team</span>
				<span class="col-sm-2   home-blank">&nbsp;</span>  
				<span class="col-sm-5  mobile-pad text-right">Away Team</span>

				</th>
				<th class="table-width5 text-center text-center-1">Broadcast</th>
			</tr>
		</thead>
		<tbody id="show_competition" class="searchable">
			<input id='sport_id' type='hidden' value='all'>
			<?php 	
					$my_date_time =  $this->session->userdata('session_date_time');
					$my_date =  $this->session->userdata('session_date');
				?>
			<?php foreach($events as $event){ ?>
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
								>
								<?php echo  date('H:i', (strtotime($event['start_date'])+ $new_session_time));?></span><?php } ?>
							<span class="match_time" style="color:red; font-size:12px;">	<?php $rss->where('event_id',$event['id']);
							$minute = $rss->get('rss_event_details')->result(); echo $minute[0]->game_minute ?> </span>
						</div>
					</div>
				</td>
				<td class="brdr-right">
					<div class="event-data eventdata-main" style="text-align:center">
						<span class="cont-flag">
							<?php $nation = strtolower($event['nation']);
							if (file_exists($_SERVER["DOCUMENT_ROOT"].'/images/Flags/'.ucwords($nation).'.png')) {
							?>
							
							<img src="<?php echo base_url();?>images/Flags/<?php echo ucwords($nation).'.png';?>" alt="">
							<?php }else{?>
							<img src="<?php echo base_url();?>images/Flags/default_flag.png" alt="">
							<?php }?>
						</span>

						<span>
						<a href="<?php echo base_url();?>nations/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
							<span class="cont-nation cont-nation-<?php echo $this->session->userdata('session_color');?> ">
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
								<img src="http://www.realstreamsports.com/images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else if($event['comp_logo'] == '' ){?> <img src=" http://www.realstreamsports.com/images/competitions/default.png" alt=""> <?php } else { ?>
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
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">

									<?php } ?>
									<?php } else if($event['home_team_logo'] == '' || $event['home_team_logo'] == '/images/teams/default.png') { ?>
									<img src="<?php echo base_url();?>assets/images/defaults/<?php echo $event['sport_name'];?>-default.png" style="width:28px; float:left;">
									
									<?php } else { ?>
									<img src="<?php echo $event['home_team_logo'];?>" style="width:28px; float:left;">
									<?php } ?>
								</span>
								<span class="country-name" style="text-transform:capitalize;">
                                <span class="score1 mobile-score1"> <?php if($status[0] == '') { echo "-"; } else { echo $status[0]; }  ?> </span>
                               <?php if($event['category_name']== "Tennis" || $event['category_name']== "MotorSports" || $event['category_name']== "Motorcycle Racing" || $event['category_name']== "Auto Racing" || $event['category_name']== "Other" || $event['category_name']== "Golf") {?>
									<a title="<?php echo ucwords($event['home_team']); ?>">
										<?php } else{?>
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">


								<?php 	}?>
									<?php
										echo ucwords($event['home_team']);
									?> 
									</a>
								</span> <?php $status = explode('-',$event['events_status']); 
								
								?>
							</div>
						</div>
						<?php  
						if($event['away_team']) {?>
						
						<div class="col-sm-2 hidden-xs no-pad  tablet-data1 text-center-event">
							<div class="vs-match">VS</div>
							<div class="result-outer">
							<span class="score1 pc-score1"> <?php if($status[1] == '') { echo "-"; } else { echo $status[1]; }  ?> </span> &nbsp;:&nbsp;
							<span class="score2 pc-score2"> <?php if($status[0] == '') { echo "-"; } else { echo $status[0]; }  ?> </span>
							</div>
						</div>
						<div class="col-sm-5 no-pad tablet-data1 dev-float-right text-right">
							<div class="team-data2">
								<span class="country-name">
                                <span class="score2 mobile-score2"> <?php if($status[1] == '') { echo "-"; } else { echo $status[1]; }  ?> </span>
									  <?php if($event['category_name']== "Tennis" || $event['category_name']== "MotorSports" || $event['category_name']== "Other" || $event['category_name']== "Golf") {?>
									<a title="<?php echo ucwords($event['away_team']); ?>">
										<?php } else{?>
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['away_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['away_team']));?>" title="<?php echo ucwords($event['away_team']); ?>">


								<?php 	}?>
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
									<img src="http://www.realstreamsports.com/images/players/tennisplayer.png" style="width:28px; float:left;">

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
			<?php // } 
			}?>
			
		</tbody>
	</table>
</div>

		<div class="load-all-events text-center">
			<a href="javascript:;" id="view_more" onclick="load_events()">
			
			Click here to load more events</a></div>
		</div>

	</div>
</div>
<input type="hidden" value="0" id="get_event">
<!-- table container -->

<div class="clearfix"></div>
<!-- news container
<section id="news-container">
<div class="container">
<div class="row">

<?php //foreach($news1 as $new) {?>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	<div class="blog-data">
    	<h4><b><i><?php //echo $new['title'];?>.</i></b></h4>
        <div class="blog-date" style="margin:20px;"><?php //echo $new['created_date'];?></div>
        <div class="blog-img"><img style="height:300px;width:300px; border-radius:20%;"src="<?php //echo base_url();?>admin/uploads/game_images/<?php// echo stripslashes($new['image']) ?>"></div>
        <p><?php// echo substr($new['description'], 0, 50);?>......</p>
		    <a href="<?php //base_url(); ?>home/news/<?php// echo $new['slug_news']; ?>" title="">Read More</a><hr>
    </div>
</div>
<?php //} ?> 

</div>
</div>
</section> -->

<!-- welcome container -->
<section id="welcome-container" class="welcome-container-<?php echo$this->session->userdata('session_color');?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center index-welcome <?php echo $this->session->userdata('session_color').'-index-welcome'?>">
				<?php echo $meta_article;
				?>
			</div>
		</div>
	</div>
</section>

<div class="clearfix"></div>
<!-- news container -->
<!-- news container -->

<input type="hidden" value="<?php echo $my_ip;?>" id="get_ip">
<!-- footer --> 
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
<!-- for Date Picker -->
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/DataTable/media/css/dataTables.bootstrap.css"/>

<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/DataTable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/DataTable/media/js/dataTables.bootstrap.js"></script>
</body>

</html>
  <script>
$(document).ready(function () {
    (function ($) {
        $('#filter').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        })
    }(jQuery));
});
</script>
<script type="application/javascript">

	$('#manage_events').dataTable({
		"iDisplayLength": 5,
		"bPaginate": false, //false to disable selection box and pagination
		"bLengthChange": false, //true to show selection box for rows.
		"info": false, // True to show "showing 1 out of 4 fields."
	//	"bLengthChange": true,
		"bFilter": true, //true to make search available.
		"bSearchable": true,
		"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0,1,2, 3, 4 ] } ],
		//"visible": true
		
		//"oLanguage": { "oPaginate": {"sPrevious": "", "sNext": ""} },
		
	});	
</script>
<script>
// $("#button1").click(function(){
	// alert();
// });
$(document).ready(function () { 
$('#loading').hide();
				
		var ip_address = $('#get_ip').val();
        $(".change_color").click(function(){
			var get_color = $(this).data("color");
			$.ajax({
				url : "<?php echo base_url();?>home/change_color",
				type : "POST",
				data : {"ip" : ip_address , "color" : get_color},
				success : function(data){
					location.reload();
				}
			});
        });
    });
	
$(document).ready(function(){
	$('#manage_events_filter').hide();
	//$('#manage_events_filter').append("#search_box");
		
});
function load_events(){
	$('#loading').show();
	$('#get_event').val('1');
	$.post("<?php echo base_url();?>home/get_last_events",{
	}).done(function(data){
		$('#show_competition').append(data);
		$('#view_more').hide();
		$('#loading').hide();
	});
	
	var change_nation = $('#get_event').val();
	$.post("<?php echo base_url();?>home/change_nation_by_load_events",{
		//value : change_nation
	}).done(function(data){
		document.getElementById('my_nation').innerHTML = data;
	});
	
	$.post("<?php echo base_url();?>home/change_sports_by_load_events",{
	}).done(function(data){
		document.getElementById('my_sports').innerHTML = data;
	});
	$.post("<?php echo base_url();?>home/change_competitions_by_load_events",{
	}).done(function(data){
		document.getElementById('my_competition').innerHTML = data;
	});
}
	
	$(document).ready(function(){
		$('#my_nation').change(function(){
			var nation = $('#my_nation').val();
			var get_value = $('#get_event').val();
			var datepicker =  $('.get_datepicker_date').val();
			//console.log(datepicker)
			$.post("<?php echo base_url();?>home/ajax_nation_sport",{
				nation_id : nation,
				value : get_value,
				datepick : datepicker
				
			}).done(function(data){
				//console.log(data)
				$('#loading').hide();
				//console.log(data);
				document.getElementById('show_competition').innerHTML = data;
				document.getElementById('my_sports').innerHTML = data;
				
			});
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
				
			});
			});
			
		//On click of nation change competition
		$('#my_nation').change(function(){
			var competition_nation = $('#my_nation').val();
			var get_value = $('#get_event').val();
			//console.log(nation);
			$.post("<?php echo base_url();?>home/ajax_nation_competition",{
				c_nation : competition_nation,
				value : get_value
			}).done(function(data){
				//console.log(data)
				document.getElementById('my_competition').innerHTML=data;
			});
		});
		
		$('#my_sports').change(function(){
			//alert();
			var sports = $('#my_sports').val();
			var nations = $('#my_nation').val();
			var get_value = $('#get_event').val();
			var datepicker =  $('.get_datepicker_date').val();
			//console.log(nations)
			$.post("<?php echo base_url();?>home/ajax_sports",{
				sport : sports,
				nation : nations,
				value : get_value,
				datepicker : datepicker,
			}).done(function(data){
				//alert(data);
				console.log(data)
				 document.getElementById('show_competition').innerHTML=data;
				 document.getElementById('my_competition').innerHTML=data;
			});
		});
		
		$('#my_competition').change(function(){
			var value = $('#my_competition').val();
			var get_value = $('#get_event').val();
			var datepicker =  $('.get_datepicker_date').val();
			//console.log(value)
			$.post("<?php echo base_url();?>home/ajax_events/",{
				competition : value,
				value : get_value,
				datepick : datepicker,
			}).done(function(data){
				console.log(data)
				  document.getElementById('show_competition').innerHTML=data;
				 // document.getElementById('my_sports').innerHTML=data;
			});
		});
		
		
		
	});
	setInterval(function(){ var sport_id = $('#sport_id').val();
		$('#my_sports option:eq('+sport_id+')').attr('selected', 'selected'); //To get the selected value.
		
		//console.log(sport_id);
		}, 1000);
		setInterval(function(){ var competition_id = $('#competition_id').val();
		$('#my_competition option:eq('+competition_id+')').attr('selected', 'selected'); //To get the selected value.
		
		//console.log(sport_id);
		}, 1000);
		
	

	$('#show_live_events').change(function(){
		$('#loading').show();
		var live_events = $('#show_live_events').val();
		$.post("<?php echo base_url();?>home/show_live_events_filter/",{
			live : live_events
		}).done(function(data){
			$('#loading').hide();
			document.getElementById('show_competition').innerHTML = data;
			$('#view_more').hide();
		});
	});
	
	$(".mob-nav").click(function(){
    $("#mob-navig").toggle();
});
	

</script>
<script>
function formatAMPMd() {
var d = new Date(),

    minutes2 = d.getMinutes().toString().length == 1 ? '0'+d.getMinutes() : d.getMinutes(),
    hours2 = d.getHours().toString().length == 1 ? '0'+d.getHours() : d.getHours(),
   // ampm2 = d.getHours() >= 12 ? ' PM' : ' AM';
  months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
   days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
	var my_date = months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear();
	var my_time = months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear()+' '+hours2+':'+minutes2;
	//alert(my_date);
	
	$.post("<?php echo base_url();?>home/get_date/",{
				date : my_date,
				date_time : my_time
			}).done(function(data){
				console.log(data)
				
			});
			
return days[d.getDay()]+' '+months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear()+' '+hours+':'+minutes+ampm;

}
</script>

  
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
  <script>
  //change nation by datepicker 
  $('.get_datepicker_date').change(function(){
	  var datepicker =  $('.get_datepicker_date').val();
	  $.ajax({
		url : '<?php echo base_url();?>home/filter_datepicker_nation',
		data : {'date' : datepicker},
		type : 'POST',
		success : function(data){
			document.getElementById('my_nation').innerHTML = data;
		}
	 });
  });
   //change sport by datepicker 
  $('.get_datepicker_date').change(function(){
	  var datepicker =  $('.get_datepicker_date').val();
	  $.ajax({
		url : '<?php echo base_url();?>home/filter_datepicker_sport',
		data : {'date' : datepicker},
		type : 'POST',
		success : function(data){
			document.getElementById('my_sports').innerHTML = data;
		}
	 });
  });
   //change competition by datepicker 
  $('.get_datepicker_date').change(function(){
	  var datepicker =  $('.get_datepicker_date').val();
	  $.ajax({
		url : '<?php echo base_url();?>home/filter_datepicker_competition',
		data : {'date' : datepicker},
		type : 'POST',
		success : function(data){
			document.getElementById('my_competition').innerHTML = data;
		}
	 });
  });
  //Simple Date Picker Change
  $('.get_datepicker_date').change(function(){
	  $('#loading').show();
	 var datepicker =  $('.get_datepicker_date').val();
	 //console.log(datepicker);
	 $.ajax({
		url : '<?php echo base_url();?>home/filter_datepicker',
		data : {'date' : datepicker},
		type : 'POST',
		success : function(data){
			$('#loading').hide();
			//console.log(data);
			document.getElementById('show_competition').innerHTML = data;
			$('#view_more').hide();
		}
	 });
	
  });
  </script>
  <script>
$(document).ready(function(){
	myFunction();
	function myFunction() {
    var d = new Date();
    var n = d.getTimezoneOffset();
    //document.getElementById("demo").innerHTML = n;

    var d = new Date();
    //alert(n); Shows offset for time zone.
	var gmtHours = -d.getTimezoneOffset()/60;
	//var d = new Date();
	//var na = d.toUTCString();
	//alert(gmtHours); shows local time GMT
	//document.write("The local time zone is: GMT " + gmtHours);
	var newtime = gmtHours;
	//alert(newtime) SHOWS NEW GMT according to database.

	$.ajax({
		url : '<?php echo base_url();?>home/get_date_by_timezone',
		data : {'timezone' : newtime},
		type : 'POST',
		success : function(data){
			console.log(data);
		}
	});

	}
	});


</script>