<?php 
$session_post_data = $this->session->userdata('add_news_data');
//print_r($session_post_data);exit;
?>
<!DOCTYPE html>
<html>
<head>

<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<title><?php echo $meta_title ?></title>
<meta name="keywords" content="<?php echo $meta_keywords ?>" />
<meta name="description" content="<?php echo $meta_description ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo $INC_header_script_top; ?>
</head>

<body>
<!-- Start: Header -->
<header class="navbar navbar-fixed-top"> <?php echo $INC_top_header; ?> </header>
<!-- End: Header --> 
<!-- Start: Main -->
<div id="main"> 
  <!-- Start: Sidebar --> 
  <?php echo $INC_left_nav_panel; ?> 
  <!-- End: Sidebar --> 
  <!-- Start: Content -->
  <section id="content"> <?php echo $INC_breadcrum?>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading">
				<div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Ads</div>
				<a href="<?php echo base_url('ads/manage_ads/'); ?>">
					<div class="panel-title hidden-xs pull-right">
						<span class="glyphicon glyphicon-hand-left"></span>
						Go Back
					</div>
				</a>
				</div>
            <div class="panel-body alerts-panel">
            <form class="cmxform" id="" action="<?php echo base_url(); ?>ads/manage_ads/add_new_ads_process" method="POST"  enctype="multipart/form-data">
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
							
						?>	<!--
						<div class="wrapper" id="">
							<div class="form-group">
								<label for="">Channel Name *</label>
								<input type="text"  value="" placeholder="name" class="form-control" name="name" id="name" required>
							</div>
						</div
						--><?php
						$rss = $this->load->database('rss', TRUE);
						$rss->select('competition_id,competition_name');
						$competition = $rss->get('rss_competition')->result_array();
						?>
						
						<label>Competition Name </label>
						<div class="form-group">
						
						<select class="form-control" id="c_id" class="c_id" name="id" >
							<?php foreach($competition as $c ) {?>
							<option value="<?php echo $c['competition_id'];?>"><?php echo $c['competition_name'];?></option>
							<?php } ?>
						</select>
						</div>
						<div class="form-group">
							<label>Link </label>
							<input type="text" class="form-control" id="url" value="" name="url" required>
						</div>
						<div class="checking">
							<label>Watch HD </label>
							<input type="checkbox" id="check" value="HD" name="hd">
						</div>
						<div class="clearfix"></div>
						<div class="form-group logo">
							<label for="upload">Ad image </label>
							<input type="file" id="image" name="image" >
						</div>
						<div class="form-group" align="" style="">
							<input class="submit btn btn-primary" type="submit" name="add_ads" id="add_ads" value="Add My Ad" />
						</div>
					</div>
				</div>
			</form>
            </div>
          </div>
        </div>
      </div>
    </div><!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->


<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
<script>
$('#check').click(function(){
	$('.logo').hide();
 });
</script>
<script>
// $(document).ready(function(){
    // $("btn2").click(function(){
        // $(".add").toggle(1000, function(){
            // alert("The toggle() method is finished!");
        // });
    // });
// });
</script>
<script>

$(document).ready(function(){
    $("#success").fadeOut(2000);
    $("#fail").fadeOut(2000);
});
</script>


    <script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
		$("#add_new_slider_image_frm").validate({

            rules: {
				sponsor_bank_name: "required",
				display_order: {
					required: false,
					digits: true
				},
				sponsor_bank_url: {
					required: false,
					url: true
				},

            },

            messages: {
				display_order : "Use digit to set a display order",
				sponsor_bank_name : "Bank Name cannot be empty"
            }

		});

		$("#sponsor_image").rules(
		 	"add", {
			 required:true,
			 extension: "jpg|jpeg|gif|tiff|png",
         	messages: {
				extension : "Please select valid image for epaper pages(Use: jpg, jpeg, gif, tiff, png)",
         }
      	});
		
    
    });
    </script>

</body>
</html>

