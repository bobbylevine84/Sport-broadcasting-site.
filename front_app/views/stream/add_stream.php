<?php //echo "<strong>Coming Soon</strong><br><br><br>"; 
	//echo "<a href='".base_url()."admin'>Go to admin panel</a>";
?><?php //echo "<pre>"; print_r($news);exit;?>
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
<?php $this->load->view('includes/header');?>
<!-- header --> 

<!-- banner -->

<!-- banner -->
<div class="clearfix"></div>
<!-- games  -->

<!-- games container --> 

<!-- welcome container -->

<!-- welcome container -->
<div class="clearfix"></div>
<!-- table container -->

<!-- table container -->

<div class="clearfix"></div>
<!-- news container -->
<section id="news-container">
	<div class="container">
	<?php
		if($this->session->flashdata('error')){
	?>
			<div class="alert alert-danger" id="fail"><?php echo $this->session->flashdata('error'); ?></div>
	<?php
		}//end if($this->session->flashdata('err_message'))
		
		if($this->session->flashdata('ok_message')){
	?>
			<div class="alert alert-success alert-dismissable" id="success"><?php echo $this->session->flashdata('ok_message'); ?></div>
	<?php 
		}//if($this->session->flashdata('ok_message'))
	
			$converted_datetime = gmdate('Y-m-d H:i:s');
			$converted_date = date('Y-m-d', strtotime($converted_datetime));
			
			$datetime = new DateTime($converted_datetime);
			$datetime->modify('+1 day');
			$session_date_yesterday = $datetime->format('Y-m-d H:i:s');
	
			$rule = $this->db->get('kt_stream_rule')->result_array();
			echo $rule[0]['stream_rule']; ?>
		<div class="col-lg-12">
		<img  style=" float: left; border: 1px solid #ddd;" src="<?php echo base_url();?>assets/b.jpg"> <br/>
		<img style="    float: left;  clear: both; margin-top: 18px;   border: 1px solid #ddd;" src="<?php echo base_url();?>assets/a.jpg">
		</div>
		<div class="row">
			<form class="cmxform" id="" action="<?php echo base_url(); ?>stream/add_stream_process" method="POST"  enctype="multipart/form-data">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
					<div class="panel-body alerts-panel">
						<?php 
						$rss = $this->load->database('rss', TRUE);
						$new_session_time= $this->session->userdata('time_formate') * 60 * 60;
						
						
						$rss->where('parent',NULL);
						$rss->order_by('display_order','aesc');
						$sport_category = $rss->get('rss_sport_category')->result_array();
						//echo $rss->last_query();
						?>
						
						<div class="form-group" style="margin-top:42px;">
							<label for="standard-list1"> Select Sport Category</label>
							<select class="form-control" id="sport_highlight" name="sport">
							<?php foreach($sport_category As $s) { ?>
								<option value="<?php echo $s['id']; ?>" id="<?php $s['id'];?>" >
									<?php echo $s['category_name']; ?>
								</option>
							<?php } ?>
							</select>
						</div> 
						<?php
						$rss->where('rss_events.start_date >=',$converted_datetime );
						$rss->where('rss_events.start_date <=',$session_date_yesterday );
						
						$rss->order_by('rss_events.start_date','aesc');
						$query=$rss->get('rss_events')->result_array();
						//echo $rss->last_query();
						
						?>	
						<div class="form-group" style="margin-top:42px;">
							<label for="standard-list1"> Select Event</label>
							<select class="form-control" id="event" name="event">
							<?php foreach($query As $event) { ?>
								<option value="<?php echo $event['id']; ?>" id="<?php $event['id'];?>" >
								<?php echo date('G:i', (strtotime($event['start_date']))+$new_session_time);?> /
								<?php echo $event['home_team'].' vs '.$event['away_team']; ?></option>
							<?php } ?>
							</select>
						</div> 
						<input type="hidden" name="banner" value="http://dev.ejuicysolutions.com/wiziwig/assets/b.jpg">
						<div class="wrapper" id="input_url">
							<div class="form-group">
								<label for="">Stream URL *</label>
								<input type="text"  value="" placeholder="URL" class="form-control" name="url" id="url" required>
							</div>
						</div>
						<div class="form-group">
							<label for="standard-list1">Language</label>
							<select class="form-control" id="language" name="language">
								<option value="English" selected >English</option>
								<option value="Arabic">Arabic</option>
								<option value="Russian">Russian</option>
								<option value="Dutch">Dutch</option>
								<option value="Spanish">Spanish</option>
								<option value="German">German</option>
								<option value="Italic">Italic</option>
								<option value="Chinese">Chinese</option>
								<option value="Urdu">Urdu</option>
								<option value="Japenese">Japenese</option>
								<option value="Hindi">Hindi</option>
								<option value="Other">Other</option>
							</select>
						</div>  						
						<div class="form-group">
						<label for="standard-list1">Bitrate(kbps) *</label>
						<input type="text"  value="" placeholder="Bitrate in Kbps:" class="form-control" name="total_bitrate" id="total_bitrate" required>
						</div> 
						<div class="form-group">
						<label for="standard-list1">Type</label>
						<select class="form-control" id="type" name="type">
							<option value="http" selected >http</option>
							<option value="acestream">acestream</option>
							<option value="sopcast">sopcast</option>
							<option value="vlc">vlc</option>
							<option value="p2p">p2p</option>
							<option value="Other ">Other </option>
						</select>
						</div>  						
						<div class="form-group">
							<label for="standard-list1">Mobile Compatibility</label>
							<select class="form-control" id="compatibility" name="compatibility">
								<option value="YES" selected >Yes.</option>
								<option value="NO">No.</option>
							</select>
						</div>  <!--
						<div class="wrapper" id="input_channel">
							<div class="form-group">
								<label for=""> Channel *</label>
								<input type="text"  value="" placeholder="Channel" class="form-control" name="channel" id="channel" required>
							</div>
						</div> -->
						<div class="form-group" align="right" style="">
					<input class="submit btn btn-primary" type="submit" name="add_stream" id="add_stream" value="Add Stream" />
				</div>
					</div>
				</div>
				
				<!-- Here -->
				
	
			</form>
		</div>
	</div>
</section>
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

</body>
</html>
<script>
$(document).ready(function(){
    $("#success").fadeOut(2000);
    $("#fail").fadeOut(2000);
});
</script>
<script>
$(document).ready(function(){
	$("#input_embed").hide();
	
    $("#other").click(function(){
        $("#input_url").hide();
		$("#input_embed").show();
    });
     $(".show_input").click(function(){
         $("#input_url").show();
		 $("#input_embed").hide();
     });
});
</script>
<script>
$('#sport_highlight').change(function(){
	var id = $('#sport_highlight').val();

	$.post("<?php echo base_url();?>home/change_event_highlight",{
		sport_id_stream : id,
	}).done(function(data){
		//alert(data);
		console.log(data)
		document.getElementById('event').innerHTML=data;
		 //document.getElementById('my_competition').innerHTML=data;
	});
		
});
</script>