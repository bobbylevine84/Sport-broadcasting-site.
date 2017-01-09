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
<?php //echo "<pre>";print_r($get_my_header);exit; ?>
<nav role="navigation" class="navbar navbar-default">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"> 
				<div class="navbar-header page-scroll">
					<button data-target=".navbar-ex1-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo base_url();?>"><img src="<?php echo base_url(); ?>assets/images/myimages/images/logo.jpg" alt=""></a>
					<a class="navbar-brand hidden-lg " href="#"><img src="images/logo-tab.jpg"  alt=""></a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="navbar-collapse navbar-ex1-collapse collapse" aria-expanded="false" style="height: 1px;">
					<ul class="nav navbar-nav">
					<li><a href="<?php echo base_url();?>">Home</a></li>
					<li><a href="<?php echo base_url();?>">Live sports</a></li>
					<li><a href="<?php echo base_url();?>live-channels/42">Live TV</a></li>
					<li><a href="<?php echo base_url();?>video-highlights">Highlights </a></li>
					  <?php foreach($get_my_header As $header ) {?>
						  <li><a href="<?php echo base_url(); ?>blog" title=""><?php echo $header['menu_name']; ?></a></li>
												
					  <?php } ?>
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col-lg-offset-0 " >
				<div class="current-date-time">Your time: <strong>23:39</strong> · Server time: <strong>08:37</strong></div>
					<div class="header-search">
						<div class="search-box">
							<div class="row">
								<form>
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-9" style="padding-right:0">
										<input type="text" class="form-control" name="search" placeholder="Search With Events" >
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3" style="padding-left:0">
										<button type="submit" class="btn-search form-control">
											<i class="fa fa-search"></i> 
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
			</div>
        </div>
    </div>   <!-- /.container -->
</nav>
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
<div class="inner-content">
            <div class="container">

                <!--register-->
                <div  class="register-wrape">
                    <?php foreach ($get_my_header_data As $data) { ?>
                        <?php
                        echo $data['page_long_desc'];
                    }
                    ?>

                </div>
                <!--------------------------------------------------------------------------------->


                <!-------------------------------------------------------------------------------------------------------------------------> 
                <!--register-->
            </div>
        </div>
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