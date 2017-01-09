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
$rss = $this->load->database('rss', TRUE);
 //echo "<strong>Coming Soon</strong><br><br><br>"; 
	//echo "<a href='".base_url()."admin'>Go to admin panel</a>";
?><?php $new_session_time= $this->session->userdata('time_formate') * 60 * 60; $current_date = gmdate('Y-m-d H:i:s');	?>
<!DOCTYPE html>

<html lang="en">
    <head><title>
	<?php echo $meta_title;?> </title>
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
  <!-- For Calender -->
		 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php //echo base_url(); ?>assets/css/demo.css" type="text/css" media="screen" />
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,800' rel='stylesheet' type='text/css'>
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
		#table-container .table-content .table-width4 {
			width: 56%;
		}	
		</style>
<?php $this->load->view('includes/header');?>
<!-- header --> 

<!-- banner -->
<!-- banner -->
<div class="clearfix"></div>
<!-- games container -->
<?php  if($sport == "Football") { $sport = "Soccer"; } ?>
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
							<a <?php if($sport == $sports_arr[$z]['category_name']) {?> class="selected" <?php } ?> href="<?php echo base_url();?>video-highlights/<?php echo str_replace(' ', '-', $sports_arr[$z]['category_name']);?>"><span class="left-icon"><img src="<?php echo base_url();  ?>admin/uploads/game_images/<?php echo $sports_arr[$z]['sport_logo'];?>" style="width:28px;height:28px;"></span><span><?php echo $sports_arr[$z]['category_name'];?></span></a></li>
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
<div id="table-container" class="table-container-<?php echo $this->session->userdata('session_color'); ?> ">
<div class="container">
	<!--<div id="get_calender" class="get_calender">
	<center><label>Filter By Date</label><input type="button" class="get_datepicker_date form-control btn btn-default" id="datepicker">
	</center>
</div>-->
<?php
		$my_date_time =  $this->session->userdata('session_date_time');
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
		$rss->where('DATE(rss_events.start_date) <',$converted_date ); //h:i:s for time as well.

		$rss->where('rss_sport_category.id',$get_sport_events[0]['sport_category_id']);
		$rss->join('rss_sport_category','rss_sport_category.id=rss_events.sport_category_id');
		$rss->order_by('start_date','aesc');
		$rss->group_by('rss_events.nation');
		$nation = $rss->get('rss_events')->result_array();
		?>
		<select name="my_nation" id="my_nation">
			<option value="" disabled selected>Nations</option>
			<?php foreach($nation as $name){?>
			<option value="<?php echo $name['nation'];?>"><?php echo ucwords(strtolower($name['nation']));?></option>
			<?php } ?>
		</select> 	 
	</div>
	
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		<label>Competitions</label>
		<?php
			$rss->select('rss_competition.competition_id,rss_competition.competition_name');
			$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
			$rss->where('DATE(rss_events.start_date) <',$converted_date ); //h:i:s for time as well.
			$rss->where('rss_competition.sport_cat_id',$get_sport_events[0]['sport_category_id']);
			$rss->join('rss_sport_category','rss_sport_category.id=rss_competition.sport_cat_id');
			$rss->join('rss_events','rss_events.competition_id=rss_competition.competition_id');
			$rss->order_by('rss_events.start_date','aesc');
			$rss->group_by('rss_competition.competition_id');
			$competition = $rss->get('rss_competition')->result_array();
			//echo $this->db->last_query();
		?>
		<select name="my_competition" id="my_competition" >
			<option value="" disabled selected>Competitions</option>
			<?php foreach($competition as $name){?>
			<option value="<?php echo $name['competition_id'];?>"><?php echo ucwords(strtolower($name['competition_name']));?></option>
			<?php } ?>
		</select> 
			 
	</div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 pull-right">
		<input id="filter" type="text" class="form-control" placeholder="Search here..." >
	</div>
</div>
</form>
</div>
<div class="table-content">
<div class="table-responsive">
<table class="table table-striped  datatable-<?php echo $this->session->userdata('session_color');?>  text-center table-striped-<?php echo $this->session->userdata('session_color');?>"  id="manage_events" border="0">
		<thead class="<?php echo $this->session->userdata('session_color'); ?>-thead">
			<tr>
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
			<?php if($get_sport_events) { ?>
			<?php foreach($get_sport_events as $event){ ?>
			<tr class="white-color <?php echo $this->session->userdata('session_color');?>-color  <?php echo $this->session->userdata('session_color');?>-hover">
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
						<span class="cont-flag">
							<?php if($event['comp_logo'] == 'default.jpg') { ?>
								<img src="http://www.realstreamsports.com/images/competitions/<?php echo $event['comp_logo'];?>" alt="">
							<?php } else if($event['comp_logo'] == '' ){?> <img src=" http://www.realstreamsports.com/images/competitions/default.png" alt=""> <?php } else { ?>
							<img src="<?php echo $event['comp_logo'];?>" alt="">
							<?php } ?>
						</span>
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
								</span> <?php $status = explode('-',$event['events_status']); ?>
								<span class="country-name">
									<a href="<?php echo base_url();?>teams/<?php echo ucwords($event['home_team_id']); ?>/<?php if($event['category_name'] == "Soccer") { $event['category_name'] = "football"; } echo str_replace(' ', '-', $event['category_name']);?>/<?php echo strtolower(str_replace(' ', '-', $event['nation']));?>/<?php echo strtolower(str_replace(' ', '-', $event['home_team']));?>" title="<?php echo ucwords($event['home_team']); ?>">
										<?php
											echo ucwords($event['home_team']);
										?> 
									</a>
								</span>
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
					<div class="view-event <?php echo $this->session->userdata('session_color').'-view-event';?>"><a href="<?php echo base_url();?>video-highlights/team-highlights/<?php echo $event['id'];?>/<?php echo strtolower(str_replace(' ','-',$event['home_team'])) .'-vs-'. strtolower(str_replace(' ','-',$event['away_team'])) ?>">View Highlight</a></div>
				</td><td style="display:none"></td>
				
			</tr>
			<?php } } else { echo "<span class='no-eve'> No Events To Display </span><style>#footer-container{position : fixed; bottom : 0;}</style>"; } ?>
			
		</tbody>
		
	</table><input type="hidden" id="nation_sport_id" class="nation_sport_id" value="<?php echo $sport_id_for_calender;?>">
</div>
</div>
</div>
</div>
<!-- table container -->
<div class="clearfix"></div>
<?php if($meta_article){ ?>
<section id="welcome-container" class="welcome-container-<?php echo$this->session->userdata('session_color');?>">
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
			var nation_sport_id = $('#nation_sport_id').val();
			 var datepicker =  $('.get_datepicker_date').val();
			//console.log(nation_sport_id);
			$.post("<?php echo base_url();?>highlight/ajax_nation_sport",{
				nation_id : nation,
				nation_sport_id : nation_sport_id,
				datepick : datepicker
			}).done(function(data){
				//console.log(data);
				document.getElementById('show_competition').innerHTML = data;
			});
		});
		$('#my_nation').change(function(){
			var competition_nation = $('#my_nation').val();
			var nation_sport_id = $('#nation_sport_id').val();
			var datepicker =  $('.get_datepicker_date').val();
			//console.log(nation);
			$.post("<?php echo base_url();?>highlight/ajax_nation_competition",{
				c_nation : competition_nation,
				nation_sport_id : nation_sport_id,
				datepick : datepicker,
			}).done(function(data){
				console.log(data)
				document.getElementById('my_competition').innerHTML=data;
			});
		});
		$('#my_competition').change(function(){
			var value = $('#my_competition').val()
			var nation_sport_id = $('#nation_sport_id').val();
			 var datepicker =  $('.get_datepicker_date').val();
			$.post("<?php echo base_url();?>highlight/ajax_events/",{
				competition : value,
				nation_sport_id : nation_sport_id,
				datepick : datepicker
			}).done(function(data){
				//console.log(data)
				 document.getElementById('show_competition').innerHTML=data;
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
</script>
  
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
  <script>
  $('.get_datepicker_date').change(function(){
	 var datepicker =  $('.get_datepicker_date').val();
	 var nation_sport_id = $('#nation_sport_id').val();
	 $.ajax({
		url : '<?php echo base_url();?>highlight/filter_datepicker',
		data : {'date' : datepicker , 'nation_sport_id' : nation_sport_id},
		type : 'POST',
		success : function(data){
			//console.log(data);
			document.getElementById('show_competition').innerHTML = data;
			//$('#view_more').hide();
		}
	 });
	
  });
    //change nation by datepicker 
  $('.get_datepicker_date').change(function(){
	  var datepicker =  $('.get_datepicker_date').val();
	  var nation_sport_id = $('#nation_sport_id').val();
	  $.ajax({
		url : '<?php echo base_url();?>highlight/filter_datepicker_nation',
		data : {'date' : datepicker , 'sport' : nation_sport_id },
		type : 'POST',
		success : function(data){
			console.log(data)
			document.getElementById('my_nation').innerHTML = data;
		}
	 });
  });
  //change competition by datepicker 
  $('.get_datepicker_date').change(function(){
	  var datepicker =  $('.get_datepicker_date').val();
	  var nation_sport_id = $('#nation_sport_id').val();
	  $.ajax({
		url : '<?php echo base_url();?>highlight/filter_datepicker_competition',
		data : {'date' : datepicker , 'sport' : nation_sport_id},
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