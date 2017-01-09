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
<!-- games container -->

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
		<div class="row">
			<form class="cmxform" id="" action="<?php echo base_url(); ?>highlight/add_event_process" method="POST"  enctype="multipart/form-data">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
					<div class="panel-body alerts-panel">
						<?php
							if($this->session->flashdata('err_message')){
						?>
								<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
						<?php
							}//end if($this->session->flashdata('err_message'))
							
							if($this->session->flashdata('ok_message')){
						?>
								<div class="alert alert-success alert-dismissable" id="success"><?php echo $this->session->flashdata('ok_message'); ?></div>
						<?php 
							}//if($this->session->flashdata('ok_message'))
						?>
						<div class="form-group">
							<label for="">Home Team *</label>
							<input type="text"  value="" placeholder="Home" class="form-control" name="home_team" id="home_team" >
						</div>
						<div class="form-group">
							<label for="">Away Team *</label>
							<input type="text"  value="" placeholder="Away" class="form-control" name="away_team" id="away_team" >
						</div>
						<div class="form-group">
							<label for="">Competition *</label>
							<input type="text"  value="" placeholder="Competition" class="form-control" name="competition" id="competition" >
						</div>
						<div class="form-group">
							<label for="">Nation *</label>
							<input type="text"  value="" placeholder="Nation" class="form-control" name="nation" id="nation" >
						</div>
						<div class="form-group">
							<label for="standard-list1">Sports Category</label>
							<select class="form-control" id="category" name="category">
								<option value="cricket" selected >Cricket</option>
								<option value="football">Football</option>
								<option value="baseball">Baseball</option>
								<option value="rugby">Rugby</option>
								<option value="motorcycling">Motorcycling</option>
								<option value="hockey">Hockey</option>
								<option value="basketball">Basketball</option>
							</select>
						</div>  
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top:20px;">
				
					<div class="form-group">
						<label for="upload">Home Logo *</label>
						<input type="file" id="upload" name="home_logo">
					</div>
					<div class="form-group">
						<label for="upload">Away Logo *</label>
						<input type="file" id="upload" name="away_logo">
					</div>
					<div class="form-group">
						<label for="upload">Competiotion Logo *</label>
						<input type="file" id="upload" name="competition_logo">
					</div>
					<div class="form-group">
						<label for="upload">Nation Flag *</label>
						<input type="file" id="upload" name="nation_flag">
					</div>
				</div>
				<div class="form-group" align="right" style="">
					<input class="submit btn btn-blue" type="submit" name="add_event" id="add_event" value="Add Event" />
				</div>
	
			</form>
		</div>
	</div>
</section>
<!-- news container -->

<!-- footer --> 
<?php $this->load->view("includes/footer"); ?>
<!-- footer --> 
<!-- copy right -->
<section id="copyright-container">
<div class="container">
<div class="row">

</div>
</div>
</section>
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
    $("#success").fadeOut(1500);
});

$(".mob-nav").click(function(){
    $("#mob-navig").toggle();
});

</script>