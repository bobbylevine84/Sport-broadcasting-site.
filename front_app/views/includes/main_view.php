<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<?php
	$this->db->select('kt_sport_category.category_name');
	$this->db->join('kt_sport_category','kt_sport_category.id = kt_events.sport_category_id')
	$get_sport_name = $this->db->get('kt_events')->result_array();
	?>
    <title>
      <?php foreach($get_sport_name as $s) {
     if($s['category_name'] == "Soccer") { $s['category_name'] = "Football"; }echo $s['category_name'];
      }?>
    </title>
<link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/images/favicon.ico">
    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    
     <link href="<?php echo base_url(); ?>assets/css/animate.css" rel="stylesheet">
    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,500,700,600,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>

	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/modernizr.js"></script>
    <script defer src="<?php echo base_url(); ?>assets/js/jquery.flexslider.js"></script>
    <script defer src="<?php echo base_url(); ?>assets/js/withdraw.js"></script>
	
	
	<script>
    $(document).ready(function(){
		$( ".mobile-toggle" ).click(function() {
			$( ".navigation-menu" ).toggle( "slow" );
	    });
    });
	
	    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "fade",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
	
	
	
	$(window).load(function() {
  $('.flexsliders').flexslider({
    animation: "slide",
    animationLoop: true,
    itemWidth: 271,
    itemMargin: 4
  });
});

	
    </script>
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="<?php echo $this->session->userdata('session_color').'-body';?>">
<!-- HEADER SECTION -->
<?php $this->load->view("includes/header"); ?>

<!-- NAVBAR END  -->

<?= $content ?>

<!--FOOTER SECTION START  -->
<?php $this->load->view("includes/footer"); ?>
</body>
</html>
