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
        <?php if($get_my_news): ?>
        <?php foreach($get_my_news as $new) {?> 
        <title><?php echo $new['title'];?></title>
      <meta name="description" content="<?php echo $new['keywords'];?>" >
      <meta name="keywords" content="<?php echo $new['description'];?>9">
        
        <?php } ?>
        <?php else :?>
        <title>WiziWig</title>
       <?php endif; ?>
        <!--
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

<?php foreach($get_my_news as $new) {?>
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
	<div class="blog-data">
	
    	<h1><?php echo $new['title'];?>.</h1>
        <div class="blog-date" style="margin:10px 0;"><?php echo $new['created_date'];?></div>
        <div class="blog-img1" style="margin-bottom:15px"><img class="img-responsive" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo stripslashes($new['image']) ?>"></div>
        <p><?php echo $new['content'];?>.</p>
        
		
    </div>
</div>
<?php } ?> 
<h1 style="font-size:28px"> Other News</h1><hr>
<?php foreach($news as $new) {?>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	<div class="blog-data">
    <div class="row">
	 
        <div class="col-xs-4"><div class="blog-img"><img src="<?php echo base_url();?>admin/uploads/game_images/<?php echo stripslashes($new['image']) ?>"></div></div>
        <div class="col-xs-8" style="padding-left:0">
        <h4><a href="<?php base_url(); ?>news/<?php echo $new['slug_news']; ?>" title=""><?php echo $new['title'];?>.</a></h4>
        <p><?php echo substr($new['content'], 0, 50);?>.......</p>
        </div>
      </div>  
		
    </div>
    <hr style="margin:9px 0" / >
</div>
<?php } ?> 
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