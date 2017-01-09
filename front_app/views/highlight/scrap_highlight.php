<?php //echo "<strong>Coming Soon</strong><br><br><br>"; 
	//echo "<a href='".base_url()."admin'>Go to admin panel</a>";
?><?php //echo "<pre>"; print_r($events);exit;?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>WiziWig</title><!--
       <link rel="icon" type="image/png" href="<?php// echo base_url() ?>assets/images/favicon.ico">-->
	   <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>
  
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
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
<section id="games-links">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<ul>
					<?php for($i=0;$i<=6;$i++){ ?>
					<li><a href="<?php echo base_url();?>video-highlights/sport_event/<?php echo $sports_arr[$i]['id'];?>"><span class="left-icon"><img src="<?php echo base_url();  ?>admin/uploads/game_images/<?php echo $sports_arr[$i]['sport_logo'];?>"></span><span><?php echo $sports_arr[$i]['category_name'];?></span></a></li>
					<?php } 
					if($sports_count > 7) {?>
					<div class="btn-group">
					
						<button type="button" class="dropdown-toggle" data-toggle="dropdown">
							More... <span class="caret"></span>
						</button>
						
						<ul class="dropdown-menu" role="menu">
						<?php for($z=7;$z<$sports_count;$z++) {?>
						<li><a href="<?php echo base_url();?>video-highlights/sport_event/<?php echo $sports_arr[$z]['id'];?>"><span class="left-icon"><img src="<?php echo base_url();  ?>admin/uploads/game_images/<?php echo $sports_arr[$z]['sport_logo'];?>" style="width:28px;height:28px;"></span><span><?php echo $sports_arr[$z]['category_name'];?></span></a></li>
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
<div id="table-container">
<div class="container">

<div class="table-content">
<div class="table-responsive">
	<table class="table table-striped  text-center" id="manage_highlight">
		<thead>
		  <tr>
			<th class="brdr-right" style="width:10%">Date</th>
			<th class="brdr-right" style="width:25%">Home Team</th>
			<th class="brdr-right"  style="width:25%">Away Team</th>
			<th  style="width:15%">Stream</th>
		  </tr>
		</thead>
		<tbody id="show_competition">
			<?php foreach($events as $event){ ?>
			<tr class="white-color">
				<td class="brdr-right">
					<div class="date-data">
						 <div class="date-circle gray-color"><?php echo  date("j", strtotime($event['time']));?> <br> <?php echo date('M', strtotime($event['time']));?></div>
						 
						<div class="time-content"><?php echo date('l', strtotime($event['time']));?> <?php echo date('G:i', strtotime($event['time']));?></div>
					</div>
				</td>
				<td colspan="2" class="brdr-right">
					<div class="row">
					<div class="col-sm-5  col-xs-12">
					<div class="team-data1">
						<span class="country-name"><?php echo $event['home_team'];?></span>
					</div>
					</div>
					<div class="col-sm-2  col-xs-12">
						<div class="vs-match">VS</div>
					</div>
					<div class="col-sm-5  col-xs-12">
					<div class="team-data2">
						<span class="country-name"><?php echo $event['away_team'];?></span>
					</div>
					</div>
					</div>
				</td>
				<td>
					<div class="view-event"><a target="_blank" href="<?php echo $event['url'];?>">View Stream</a></div>
				</td><td style="display:none"></td>
			</tr><?php } ?>
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

<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/DataTable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/DataTable/media/js/dataTables.bootstrap.js"></script>



</body>
</html>
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
