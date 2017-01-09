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
        <link rel="stylesheet" href="<?php //echo base_url(); ?>assets/css/demo.css" type="text/css" media="screen" />
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,500,700,600,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
<style>
.contact label {
    float: left;
    width: 104px;
}
.contact input, textarea.form-control {
	margin-bottom: 16px;
    float: left;
    width: 76%;
    margin-top: 0;
    margin-left: 30px;
}

textarea {resize:none}

.contact-heading {
	    text-align: center;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
    margin-bottom: 43px;
	}
.captcha {  margin-left: 135px;}
.submit-btn {float: right;
    margin-top: 12px;}
	
.captcha-field {    margin-left: 21%;
    margin-top: 15px;}
	
.captcha-field input[type="text"]	{    margin-left: 0;
    width: 79%;}	

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
<section id="games-links" class="game-links <?php echo $this->session->userdata('session_color').'-games-links'?>">
	<div class="container">
    <i class="fa fa-navicon mob-nav"></i>
		<div class="row animated slideInDown" id="mob-navig">
			<div class="col-lg-12">
				<ul>
					<?php for($i=0;$i<=6;$i++){ ?>
					<li><a href="<?php echo base_url();?>livestreaming/<?php echo str_replace(' ', '-', $sports_arr[$i]['category_name']);?>"><span class="left-icon"><img src="<?php echo base_url();  ?>admin/uploads/game_images/<?php echo $sports_arr[$i]['sport_logo'];?>"></span><span><?php echo $sports_arr[$i]['category_name'];?></span></a></li>
					<?php } 
					if($sports_count > 7) {?>
					<div class="btn-group">
					
						<button type="button" class="dropdown-toggle" data-toggle="dropdown">
							More... <span class="caret"></span>
						</button>
						
						<ul class="dropdown-menu <?php echo $this->session->userdata('session_color').'-dropdown-menu'?>" role="menu">
						<?php for($z=7;$z<$sports_count;$z++) {?>
						<li><a href="<?php echo base_url();?>livestreaming/<?php echo str_replace(' ', '-', $sports_arr[$z]['category_name']);?>"><span class="left-icon"><img src="<?php echo base_url();  ?>admin/uploads/game_images/<?php echo $sports_arr[$z]['sport_logo'];?>" style="width:28px;height:28px;"></span><span><?php echo $sports_arr[$z]['category_name'];?></span></a></li>
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

	<div class="container">
		<form method="POST" action="<?php echo base_url();?>home/contact_us" >
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-offset-3 contact">
                
                <h1 class="contact-heading"><span style="font-size:24px"><strong>Contact Us</strong></span></h1>
                
					<div class="box-border">
						  <?php if($this->session->flashdata('message')): ?>
						  <div class="alert alert-warning"> <?php echo $this->session->flashdata('message'); ?> </div>
						  <?php endif; ?>
						   <?php if($this->session->flashdata('ok_message')): ?>
						  <div class="alert alert-success"> <?php echo $this->session->flashdata('ok_message'); ?> </div>
						  <?php endif; ?>
						  
						<div class="form-group">
							<label>Name </label>
							<input class="form-control" type="text" name="name" id="name" maxlength="100"  placeholder="Enter Your Name" required>
							<div id="f1" class="help-block" style="color:red;"><?php ?></div>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input class="form-control" type="email" name="email" onkeypress="validate_email(event)" value="<?php echo $this->session->userdata('email') ? $this->session->userdata('email'):''?>" placeholder="Enter Your Email" required>
							<div class="help-block" style="color:red;"><?php ?></div>
						</div>
						<div class="form-group">
							<label> Phone Number </label>
							<input class="form-control" type="text" maxlength="10"  onkeypress="validate(event)" name="phone" value="" placeholder="Enter Your Phone Number" required>
							<div class="help-block" style="color:red;"><?php ?></div>
						</div>
						
						<div class="form-group">
							<label> Message </label>
							<textarea class="form-control" rows="4" cols="50" name="message" placeholder="Enter your message here..."></textarea>
							<div class="help-block" style="color:red;"><?php ?></div>
						</div>
						<div class="col-md-offset-3 captcha"> 
							<?php echo $captcha_image['image']; ?> 
						</div>
						<div class="col-md-12 col-md-offset-3 captcha-field">
							<div class="input-group margin-bottom"> 
								<span class="input-group-addon">
                                <i class="fa fa-qrcode"></i>
									<!--<span class="glyphicon glyphicon-qrcode"></span> -->
								</span>
								<input type="text" name="captcha_code" id="captcha_code" class="form-control product" autocomplete="off" placeholder="Type the Security Code">
							</div>
						</div> 
						<div class="form-group submit-btn"> 
							<button type="submit" class="btn btn-primary"><i class="fa fa-phone"></i> &nbsp; Send</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>

	<!-- footer --> 
	<?php $this->load->view("includes/footer"); ?>
	<!-- footer --> 
	<!-- JavaScripts --> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/own-menu.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.sticky.js"></script>
	</body>
</html>
<script>

</script>
