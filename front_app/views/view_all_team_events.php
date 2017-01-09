<style>
#table-container {
  
   
    border-bottom: 1px solid transparent !important;
    
}
span.no-eve {
    width: 81%;
    text-align: center;
    float: left;
    position: absolute;
    top: inherit;
    padding: 10px;
    margin-top: 50px !important;
}
</style>
<?php  
//echo "<strong>Coming Soon</strong><br><br><br>"; 
	//echo "<a href='".base_url()."admin'>Go to admin panel</a>";
?><?php $rss = $this->load->database('rss', TRUE);// echo "<pre>"; print_r($get_team_events);exit;?>
	<?php 
//echo $team_id_for_calender;
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_players.nation,age,player_name,rss_sport_category.category_name,rss_team.founded_year as fy,rss_team.name,rss_team.logo,rss_team.id, rss_players.headshot_image');
		$rss->where('rss_team.id',$team_id_for_calender);
		$rss->join('rss_sport_category','rss_sport_category.category_name=rss_players.sport_name','left');
		//$rss->join('rss_countries','rss_countries.id=rss_players.country_id','left');
		$rss->join('rss_team','rss_team.id=rss_players.team_id','left');
		$rss->group_by('rss_players.player_name');
		$get_team_players = $rss->get('rss_players')->result_array();
		
	$meta_title = str_replace("%year_founded%",$get_team_players[0]['fy'],$meta_title);
	$meta_description = str_replace("%year_founded%",$get_team_players[0]['fy'],$meta_description);
	$meta_keyword = str_replace("%year_founded%",$get_team_players[0]['fy'],$meta_keyword);
	$meta_article = str_replace("%year_founded%",$get_team_players[0]['fy'],$meta_article);

	$meta_title = str_replace("%Team_name%",$get_team_players[0]['name'],$meta_title);
	$meta_description = str_replace("%Team_name%",$get_team_players[0]['name'],$meta_description);
	$meta_keyword = str_replace("%Team_name%",$get_team_players[0]['name'],$meta_keyword);
	$meta_article = str_replace("%Team_name%",$get_team_players[0]['name'],$meta_article);

if ($get_team_events) {

foreach($get_team_events as $event){ 
	$meta_title = str_replace("%nation_name%",$event['nation'],$meta_title);
	$meta_description = str_replace("%nation_name%",$event['nation'],$meta_description);
	$meta_keyword = str_replace("%nation_name%",$event['nation'],$meta_keyword);
	$meta_article = str_replace("%nation_name%",$event['nation'],$meta_article);
    }
            
    	
}          ?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<title>
			<?php echo $meta_title;?>
		</title>
		<?php echo $meta_description;?>
		<?php echo $meta_keyword;?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <!--
       <link rel="icon" type="image/png" href="<?php// echo base_url() ?>assets/images/favicon.ico">-->
	   <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>
  
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php //echo base_url(); ?>assets/css/demo.css" type="text/css" media="screen" />
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,800' rel='stylesheet' type='text/css'>
		<!-- For Calender -->
		 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,500,700,600,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>

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

<style>
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding-bottom: 1px !important;
    padding-top: 1px;
}

.mytable {margin-right:10px;}

.mytable, .tabel-2 {width:48%; float:left;}
</style>

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
						<li><a href="<?php echo base_url();?>livestreaming/<?php echo str_replace(' ', '-', strtolower($sports_arr[$z]['category_name']));?>"><span class="left-icon"><img src="<?php echo base_url();  ?>admin/uploads/game_images/<?php echo $sports_arr[$z]['sport_logo'];?>" style="width:28px;height:28px;"></span><span><?php echo $sports_arr[$z]['category_name'];?></span></a></li>
						<?php }?>
						</ul>
					</div> <?php } ?>
				</ul>
			</div>
		</div>
	</div>
</section>

<!-- games container -->
<?php
//echo $team_id_for_calender;
$rss->where('id',$team_id_for_calender);
$team = $rss->get('rss_team')->result_array();
//echo "<pre>";print_r($team);exit;
 ?>
 <div class="container">
<h3><img style="width:35px;" src="<?php echo $team[0]['logo']; ?>"> <?php echo ' '.$team[0]['name'].' Live Streams'; ?></h3>
</div>
<div class="clearfix"></div>
<!-- table container -->
<div id="table-container" class="table-container-<?php echo $this->session->userdata('session_color'); ?> ">
<div class="container">
<!--<div id="get_calender" class="get_calender">
	<center><label>Filter By Date</label><input type="button" class="get_datepicker_date form-control btn btn-default" id="datepicker">
	<!--
	<span class="glyphicon glyphicon-calendar"></span>
	
	</center>-->
	<div class="filter-container">
	<form>
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
<label>Filter By Date</label>
<div id="get_calender" class="get_calender">
	<input type="button" class="get_datepicker_date form-control btn btn-default" id="datepicker">
</div>
</div>
            <!--
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
				
			</div>
			-->
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 pull-right">
				<input id="filter" type="text" class="form-control" placeholder="Search here..." >
			</div>
		</div>
	</form>
</div>



<div class="table-content">
<div class="table-responsive">
<?php 	$session_date_time = $this->session->userdata('session_date_time');
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) - ($my_timezone * 60 * 60));
		$converted_datetime = date('Y-m-d H:i:s', $date_time);
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
?>
	<table class="table table-striped  datatable-<?php echo $this->session->userdata('session_color');?>  text-center table-striped-<?php echo $this->session->userdata('session_color');?>"  id="manage_events" border="0">
		<thead class="<?php echo $this->session->userdata('session_color'); ?>-thead" >
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
			<?php if($get_team_events) { ?>
			<?php foreach($get_team_events as $event){ ?>
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
				<?php
				$session_time = $this->session->userdata('my_timezone'); 
				$my_date_time =  $this->session->userdata('session_date_time');
				$current_date = $my_date_time;?>
				
					<div id="data_<?php echo $event['id'] ?>" class="date-circle <?php echo $this->session->userdata('session_color');?>-date-circle">	<?php echo  date("j", (strtotime($event['start_date'])+($session_time * 60 * 60)));?>
						 <?php echo date('M', (strtotime($event['start_date'])+($session_time * 60 * 60)));?>
					</div>
					 
					<div class="time-content">
					<?php $new_session_time= $this->session->userdata('time_formate') * 60 * 60;?>
						<?php if(date('Y-m-d H:i:s', (strtotime($event['start_date'])+($session_time * 60 * 60))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date'])+($session_time * 60 * 60))) >= $current_date ) {  ?>
						
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
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png'){
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
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png'){
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
				 
				<?php if(date('Y-m-d H:i:s', (strtotime($event['end_date'])+($session_time * 60 * 60))) < $current_date){ ?>
				
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date'])+($session_time * 60 * 60))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date'])+($session_time * 60 * 60))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">Highlight</a>
					</div>
					
				<?php } else { ?>
					<div class="view-event <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date'])+($session_time * 60 * 60))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date'])+($session_time * 60 * 60))) >= $current_date ) { } else { ?> <?php echo $this->session->userdata('session_color').'-view-event'; } ?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date'])+($session_time * 60 * 60))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date'])+($session_time * 60 * 60))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>watch/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Event</a>
					</div>
				<?php } ?>
				</td>
			<td style="display:none"></td>
				
			</tr>
			<?php } ?>
	<?php
if ($get_last_team_events) {
	 foreach($get_last_team_events as $event){ ?>
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
				<?php
				$session_time = $this->session->userdata('my_timezone'); 
				$my_date_time =  $this->session->userdata('session_date_time');
				$current_date = $my_date_time;?>
				
					<div id="data_<?php echo $event['id'] ?>" class="date-circle <?php echo $this->session->userdata('session_color');?>-date-circle">	<?php echo  date("j", (strtotime($event['start_date'])+($session_time * 60 * 60)));?>
						 <?php echo date('M', (strtotime($event['start_date'])+($session_time * 60 * 60)));?>
					</div>
					 
					<div class="time-content">
					<?php $new_session_time= $this->session->userdata('time_formate') * 60 * 60;?>
						<?php if(date('Y-m-d H:i:s', (strtotime($event['start_date'])+($session_time * 60 * 60))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date'])+($session_time * 60 * 60))) >= $current_date ) {  ?>
						
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
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png'){
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
		                                  if($query['headshot_image'] !='' && $query['headshot_image'] !='/images/players/defaulltplayer.png'){
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
				 
				<?php if(date('Y-m-d H:i:s', (strtotime($event['end_date'])+($session_time * 60 * 60))) < $current_date){ ?>
				
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date'])+($session_time * 60 * 60))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date'])+($session_time * 60 * 60))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">Highlight</a>
					</div>
					
				<?php } else { ?>
					<div class="view-event <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date'])+($session_time * 60 * 60))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date'])+($session_time * 60 * 60))) >= $current_date ) { } else { ?> <?php echo $this->session->userdata('session_color').'-view-event'; } ?>">
						<a  <?php if(date('Y-m-d H:i:s', (strtotime($event['start_date'])+($session_time * 60 * 60))) <= $current_date && date('Y-m-d H:i:s', (strtotime($event['end_date'])+($session_time * 60 * 60))) >= $current_date ) {  ?> class="selected" style="background:none;" <?php } ?> href="<?php echo base_url();?>watch/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Event</a>
					</div>
				<?php } ?>
				</td>
			<td style="display:none"></td>
				
			</tr>
			<?php } }
			 } else { echo "<span class='no-eve'> No Events To Display </span><style>#footer-container{position : fixed; bottom : 0;}</style>"; } ?>
			
		</tbody>
	</table>
	<input type="hidden" id="team_id_for_calender" class="team_id_for_calender" value="<?php echo $team_id_for_calender;?>" >
	
	
</div>
</div>



<?php
		
		//echo "<pre>";print_r($get_team_players);
	?>
	<?php if($view_events_id) { } else { ?>
	<?php if($get_team_events) { ?>
	<?php if($get_team_players) { //If player exists??>
	<h4><img style="width:25px;height:25px;" src="<?php echo $get_team_players[0]['logo']; ?>"><?php echo ' '.$get_team_players[0]['name']." Line Up" ;?></h4>
	
    <!--<div class="col-lg-12 col-md-12 team-eve-list">
    <ul>
       <li>1</li>
       <li>1</li>
    </ul>
    </div>-->
    
    
    
    <div class="col-lg-12">
    <div class="table-content">
		<div class="table-responsive mytable2" style="overflow-x:hidden;">
			<table class="table table-hover team-player-listing table-bordered mytable">
				<div class="row">
					<div class="col-sm-6">
						<tr>
							
							<th>Player Name</th>
							<th>Age</th>
							<th>Nation</th>
						</tr>
						<?php foreach($get_team_players as $t) { ?>
						<tr>
							<td><img style="width:30px;height:30px; margin-right:5px;"src="<?php echo $t['headshot_image'];?> "><?php echo ' '.$t['player_name'];?></td>
							<td><?php  echo $t['age'];?></td>
							<td><img src="<?php echo base_url();?>images/Flags/<?php  echo ucwords(strtolower($t['nation'])).'.png';?>"></td>
						</tr>
						<?php } ?>
					</div>
				</div>
			</table>
                       
		</div>
	</div>
	</div>
	<?php } else { echo "<span class='no-players'>No Player Listings Yet</span>"; } //end of checking players! ?>
	<?php } }?>

</div>
</div>
</div>
<!-- table container -->
<div class="clearfix"></div>
<?php if($meta_article){ ?>
<section id="welcome-container" class="welcome-container-<?php echo $this->session->userdata('session_color');?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<?php echo $meta_article;
				?>
			</div>
		</div>
	</div>
</section>
<?php } ?>
<div class="clearfix"></div>
<!-- news container

<!-- news container -->

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
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/DataTable/media/css/dataTables.bootstrap.css"/>

<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/DataTable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/DataTable/media/js/dataTables.bootstrap.js"></script>
</body>
</html>
 <script>
 $(function() {
    $('<table class="table tabel-2 table-hover team-player-listing table-bordered">').append(
        $('.mytable tr:first-child').clone(), 
        $('.mytable tr').slice(Math.ceil($('.mytable tr').length / 2))
    ).appendTo('.mytable2');
});
$(document).ready(function () {
	$('#manage_events_filter').hide();
    (function ($) {
        $('#filter').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        })
    }(jQuery));
	
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
$(".mob-nav").click(function(){
    $("#mob-navig").toggle();
});
</script>
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
  <script>
  $('.get_datepicker_date').change(function(){
	 var datepicker =  $('.get_datepicker_date').val();
	 var team_id_for_calender =  $('.team_id_for_calender').val();
	// console.log(team_id_for_calender);
	 
	 $.ajax({
		url : '<?php echo base_url();?>home/filter_datepicker',
		data : {'date' : datepicker, 'team_id_for_calender' : team_id_for_calender},
		type : 'POST',
		success : function(data){
			// console.log(data)
			document.getElementById('show_competition').innerHTML = data;
		}
	 });
	
  });
  </script>