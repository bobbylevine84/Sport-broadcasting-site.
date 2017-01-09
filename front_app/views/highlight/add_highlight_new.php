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
							if($this->session->flashdata('err_message')){
						?>
								<div class="alert alert-danger" id="fail"><?php echo $this->session->flashdata('err_message'); ?></div>
						<?php
							}//end if($this->session->flashdata('err_message'))
							
							if($this->session->flashdata('ok_message')){
						?>
								<div class="alert alert-success alert-dismissable" id="success"><?php echo $this->session->flashdata('ok_message'); ?></div>
						<?php 
							}//if($this->session->flashdata('ok_message'))
							
						?>	
	<?php $rule = $this->db->get('kt_highlight_rule')->result_array();
	echo $rule[0]['highlight_rule']; ?>
		
		<div class="row">
			<form class="cmxform" id="" action="<?php echo base_url(); ?>highlight/add_highlight_process/" method="POST"  enctype="multipart/form-data">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
					<div class="panel-body alerts-panel">
						<?php
							if($this->session->flashdata('err_message')){
						?>
								<div class="alert alert-danger" id="fail"><?php echo $this->session->flashdata('err_message'); ?></div>
						<?php
							}//end if($this->session->flashdata('err_message'))
							
							if($this->session->flashdata('ok_message')){
						?>
								<div class="alert alert-success alert-dismissable" id="success"><?php echo $this->session->flashdata('ok_message'); ?></div>
						<?php 
							}//if($this->session->flashdata('ok_message'))
							
						?>	
									<?php
							$this->db->where('DATE(start_date) >=',(date('Y-m-d', strtotime("-1 day"))) );
							$this->db->where('DATE(start_date) <=',(date('Y-m-d', strtotime("0 day"))) );
							$query=$this->db->get('kt_events')->result_array();
							//echo $this->db->last_query();
									//echo "<pre>";print_r($query);exit;
									?>	
							<div class="form-group" style="margin-top:42px;">
								<label for="standard-list1"> Select Event</label>
								<select class="form-control" id="event" name="event">
								<?php foreach($query As $event) { ?>
									<option value="<?php echo $event['id']; ?>" id="<?php $event['id'];?>" >
									<?php echo date('G:i', strtotime($event['start_date']));?> /
									<?php echo $event['home_team'].' vs '.$event['away_team']; ?></option>
								<?php } ?>
								</select>
							</div> 
						<div class="form-group">
							<label class="radio-inline">Select Type .</label>
								 <label class="radio-inline">
									<input type="radio" name="video" value="youtube" class="show_input" id="youtube" checked>Youtube &nbsp;&nbsp;
								</label>
							<label class="radio-inline">
								<input type="radio" name="video" value="dailymotion" class="show_input" id="dailymotion">Daily Motion &nbsp;&nbsp;
							</label>
							<label class="radio-inline">
								<input type="radio" name="video" value="imgur" class="show_input" id="imgur">Imgur &nbsp;&nbsp;
							</label>
							<label class="radio-inline">
								<input type="radio" name="video" value="gyfcat" class="show_input" id="gyfcat">Gyfcat &nbsp;&nbsp;
							</label>
							<label class="radio-inline">
								<input type="radio" name="video" value="other" id="other">Other
							</label>
						</div>
						<div class="wrapper" id="input_url">
							<div class="form-group">
								<label for="">URL *</label>
								<input type="text"  value="" placeholder="URL" class="form-control" name="url" id="url">
							</div>
						</div>
						<div class="wrapper" id="input_embed">
							<div class="form-group">
								<label for="">Add Embed code *</label>
								<textarea rows="5" style="width:100%;border-radius:3%;" name="embed_code" placeholder="Embed Code....."></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="standard-list1">Video Type</label>
							<select class="form-control" id="type" name="type">
								<option value="match_highlights" selected >Match Highlights</option>
								<option value="match_goals">Match Goals</option>
								<option value="full_match_video">Full Match Video</option>
								<option value="other">Other Videos</option>
							</select>
						</div>  
						<div class="form-group">
							<label for="standard-list1">Mobile Compatibility</label>
							<select class="form-control" id="compatibility" name="compatibility">
								<option value="YES" selected >Yes, My Stream is compatible with mobile.</option>
								<option value="NO">No, i cannot confirm mobile compatibility.</option>
							</select>
						</div>  
						<div class="form-group" align="right" style="">
					<input class="submit btn btn-primary" type="submit" name="add_highlight" id="add_highlight" value="Add Highlight" />
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
