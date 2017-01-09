<?php 
$rss = $this->load->database('rss', TRUE);

?><?php $new_session_time= $this->session->userdata('time_formate') * 60 * 60; 
$current_date = gmdate('Y-m-d H:i:s');	?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<?php echo $meta_keyword;?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Real sport Streams Highlights</title><!--
       <link rel="icon" type="image/png" href="<?php// echo base_url() ?>assets/images/favicon.ico">-->
	   <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>
		<!-- For Calender -->
		 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,500,700,600,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
        
        <style>
		#table-container .table-content .table-width4 {
    width: 56%;
}
		</style>

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
<?php
// $date = new DateTime('2000-01-01', new DateTimeZone('Pacific/Nauru'));
// echo $date->format('Y-m-d H:i:sP') . "\n";

// $date->setTimezone(new DateTimeZone('Pacific/Chatham'));
// echo $date->format('Y-m-d H:i:sP') . "\n";
?>
<!-- banner -->
<div class="clearfix"></div>
<!-- games container -->
<section id="games-links" class="games-links <?php echo $this->session->userdata('session_color').'-games-links'?>">
	<div class="container">
     <i class="fa fa-navicon mob-nav"></i>
		<div class="row"  id="mob-navig">
			<div class="col-lg-12">
				<ul>
					<?php for($i=0;$i<=6;$i++){ ?>
					<li>
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
							<a href="<?php echo base_url();?>video-highlights/sport_event/<?php echo $sports_arr[$z]['id'];?>"><span class="left-icon"><img src="<?php echo base_url();  ?>admin/uploads/game_images/<?php echo $sports_arr[$z]['sport_logo'];?>" style="width:28px;height:28px;"></span><span><?php echo $sports_arr[$z]['category_name'];?></span></a></li>
						<?php }?>
						</ul>
					</div> <?php } ?>
				</ul>
			</div>
		</div>
	</div>
</section>
<!-- games container --> 


<div class="clearfix"></div>
<!-- table container -->
<div id="table-container" class="table-container-<?php echo $this->session->userdata('session_color'); ?> ">
<div class="container">
<!--<div id="get_calender" class="get_calender">
	<center><label>Filter By Date</label><input type="button" class="get_datepicker_date form-control btn btn-default" id="datepicker">
	<!--
	<span class="glyphicon glyphicon-calendar"></span>
	
	</center>
</div>-->
<?php
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_date =  $this->session->userdata('session_date');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) - ($my_timezone * 60 * 60));
		$converted_datetime = date('Y-m-d H:i:s', $date_time);
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		
		
		$datetime = new DateTime($converted_date);
		$datetime->modify('-2 day');
		$session_date_yesterday = $datetime->format('Y-m-d');
?>
<div class="filter-container">
<form>
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
		$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
		$rss->where('DATE(rss_events.start_date) <',$converted_date );
		//$this->db->where('DATE(kt_events.start_date) >=',(date('Y-m-d')) );
		//$this->db->where('DATE(kt_events.start_date) <=',(date('Y-m-d', strtotime("1 day"))) ); //h:i:s for time as well.
		$rss->order_by('start_date','aesc');
		$rss->group_by('rss_events.nation');
		$nation = $rss->get('rss_events')->result_array();
		?>
		<select name="my_nation" id="my_nation">
			<option value="">All Nations</option>
			<?php foreach($nation as $name){?>
			<option value="<?php echo $name['nation'];?>"><?php echo ucwords(strtolower($name['nation']));?></option>
			<?php } ?>
		</select> 	 
	</div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		<label>Sports</label>
		<?php
		$rss = $this->load->database('rss', TRUE);
		$rss->select('rss_sport_category.id,rss_sport_category.category_name');
		$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
		$rss->where('DATE(rss_events.start_date) <',$converted_date );
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
	
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		<label>Competitions</label>
		<?php
			$rss->select('rss_competition.competition_id,rss_competition.competition_name');
			$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
			$rss->where('DATE(rss_events.start_date) <',$converted_date );
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
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 pull-right">
		<input id="filter" type="text" class="form-control" placeholder="Search here..." >
	</div>
	<!--
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	<label>Event Type</label>
    <select name="select1">
    	<option value="">Top Rated</option>
        <option value="">Top Rated</option>
        <option value="">Top Rated</option>
        <option value="">Top Rated</option>
    </select> 
</div>-->
</div>
</form>
</div>

<div class="table-content">
<div class="table-responsive">
	<table class="table table-striped  datatable-<?php echo $this->session->userdata('session_color');?>  text-center table-striped-<?php echo $this->session->userdata('session_color');?>"  id="manage_events" border="0">
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
			<?php if($events) { ?>
			<?php foreach($events as $event){ ?>
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
						<a href="<?php echo base_url();?>video-highlights/nations/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>" style="background:none;color:blue; padding:2px 0; margin:0;" title="<?php echo ucwords($event['nation']); ?>">
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
						<?php 

						$rss->select('comp_logo as logo,competition_name');
						$rss->where('competition_name',$event['competition_name']);
						$rss->group_by('competition_name');
						$comp_flag = $rss->get('rss_competition')->result_array();
						//echo "<pre>";print_r($comp_flag);exit;
						//For Competition Flag
						foreach($comp_flag as $flag){
							if($flag['logo']){
						?>
						<span class="cont-flag">
							<?php if($flag['logo'] == 'default.jpg') { ?>
								<img src="http://www.realstreamsports.com/images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else { ?>
							<img src="<?php echo $flag['logo'];?>" alt="">
							<?php } ?>
						</span>
						<?php }
						} ?>
					<span class="teamname">
						<a href="<?php echo base_url();?>video-highlights/competitions/<?php echo $event['competition_id'];?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(',','',str_replace(' ', '-', $event['competition_name'])));?>" style="background:none;color:red;  padding:5px 0; margin:0;" title="<?php echo ucwords($event['competition_name']); ?>">
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
				<!-- teams -->
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
								<span class="country-name" style="text-transform:capitalize;">
									<a href="<?php echo base_url();?>video-highlights/teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">
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
							<span class="score1"> <?php if($status[0] == '') { echo "-"; } else { echo $status[1]; }  ?> </span> &nbsp;:&nbsp;
							<span class="score2"> <?php if($status[1] == '') { echo "-"; } else { echo $status[0]; }  ?> </span>
							</div>
						</div>
						<div class="col-sm-5 no-pad tablet-data1 dev-float-right text-right">
							<div class="team-data2">
								<span class="country-name">
									<a href="<?php echo base_url();?>video-highlights/teams/<?php echo ucwords($event['away_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['away_team']));?>" title="<?php echo ucwords($event['away_team']); ?>">
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
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>"><a href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Highlight</a></div>
				</td><td style="display:none"></td>
				
			</tr>
			<?php } } else { echo "No Events To Display"; } ?>
			
		</tbody>
	</table>
</div>
<!--
<div class="load-all-events text-center"><a href="">Click here to load more events</a></div>
-->
</div>
</div>
</div>
<!-- table container -->

<div class="clearfix"></div>
<!-- welcome container -->
<section id="welcome-container" class="welcome-container-<?php echo$this->session->userdata('session_color');?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<?php $query = $this->db->get('kt_welcome_section')->result_array();
				echo $query[0]['note'];
				?>
			</div>
		</div>
	</div>
</section>
<!-- welcome container -->
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
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/DataTable/media/css/dataTables.bootstrap.css"/>
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/DataTable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/DataTable/media/js/dataTables.bootstrap.js"></script>



</body>
</html>
 <script>
$(document).ready(function () {
	$('.dataTables_filter').hide();
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
	$('#manage_highlight').dataTable({
		"iDisplayLength": 5,
		"bPaginate": false, //false to disable selection box and pagination
		"bLengthChange": false, //true to show selection box for rows.
		"info": false, // True to show "showing 1 out of 4 fields."
	//	"bLengthChange": true,
		"bFilter": true, //true to make search available.
		"bSearchable": true,
		//"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 2, 3, 4, 5, 6 ] } ],
		//"visible": true
		
		"oLanguage": { "oPaginate": {"sPrevious": "", "sNext": ""} },
		
	});	
</script>
<script>
	$(document).ready(function(){
		$('#my_nation').change(function(){
			var nation = $('#my_nation').val();
			var datepicker =  $('.get_datepicker_date').val();
			$.post("<?php echo base_url();?>highlight/ajax_nation_sport",{
				nation_id : nation,
				datepick : datepicker
			}).done(function(data){
				//console.log(data);
				document.getElementById('show_competition').innerHTML = data;
				document.getElementById('my_sports').innerHTML = data;
				
			});
		});
		$('#my_nation').change(function(){
			var competition_nation = $('#my_nation').val();
			var datepicker =  $('.get_datepicker_date').val();
			//console.log(nation);
			$.post("<?php echo base_url();?>highlight/ajax_nation_competition",{
				c_nation : competition_nation,
				datepick : datepicker
			}).done(function(data){
				console.log(data)
				document.getElementById('my_competition').innerHTML=data;
			});
		});
		
		$('#my_sports').change(function(){
			//alert();
			var sports = $('#my_sports').val();
			var nations = $('#my_nation').val();
			var datepicker =  $('.get_datepicker_date').val();
			$.post("<?php echo base_url();?>highlight/ajax_sports",{
				sport : sports,
				nation : nations,
				datepicker : datepicker,
			}).done(function(data){
				//alert(data);
				//console.log(data)
				 document.getElementById('show_competition').innerHTML=data;
				 document.getElementById('my_competition').innerHTML=data;
			});
		});
		
		$('#my_competition').change(function(){
			var value = $('#my_competition').val();
			var datepicker =  $('.get_datepicker_date').val();
			//console.log(value)
			$.post("<?php echo base_url();?>highlight/ajax_events/",{
				competition : value,
				datepick : datepicker,
			}).done(function(data){
				//console.log(data)
				 document.getElementById('show_competition').innerHTML=data;
				 document.getElementById('my_sports').innerHTML=data;
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
		

$(".mob-nav").click(function(){
    $("#mob-navig").toggle();
});

	
	// function team_event(id){
		// var id = id;
	//	console.log(id)
		// $.post("<?php echo base_url();?>home/ajax_team_events",{
			// id : id
		// }).done(function(data){
			// console.log(data);
			// document.getElementById('show_competition').innerHTML=data;
		// });
	// }
</script>
  
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
  <script>
  $('.get_datepicker_date').change(function(){
	 var datepicker =  $('.get_datepicker_date').val();
	 //console.log(datepicker);
	 $.ajax({
		url : '<?php echo base_url();?>highlight/filter_datepicker',
		data : {'date' : datepicker},
		type : 'POST',
		success : function(data){
			//console.log(data);
			document.getElementById('show_competition').innerHTML = data;
			$('#view_more').hide();
		}
	 });
	
  });
  //change nation by datepicker 
  $('.get_datepicker_date').change(function(){
	  var datepicker =  $('.get_datepicker_date').val();
	  $.ajax({
		url : '<?php echo base_url();?>highlight/filter_datepicker_nation',
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
		url : '<?php echo base_url();?>highlight/filter_datepicker_sport',
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
		url : '<?php echo base_url();?>highlight/filter_datepicker_competition',
		data : {'date' : datepicker},
		type : 'POST',
		success : function(data){
			document.getElementById('my_competition').innerHTML = data;
		}
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
  </script>