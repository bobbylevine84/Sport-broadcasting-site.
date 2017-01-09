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
				<div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Channel</div>
				<a href="<?php echo base_url('channel/manage_channel/'); ?>">
					<div class="panel-title pull-right">
						<span class="glyphicon glyphicon-hand-left"></span>
						Go Back
					</div>
				</a>
				</div>
            <div class="panel-body alerts-panel">
            <form class="cmxform" id="" action="<?php echo base_url(); ?>channel/manage_channel/add_new_channel_process" method="POST"  enctype="multipart/form-data">
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
						<div class="wrapper" id="">
							<div class="form-group">
								<label for="">Channel Name *</label>
								<input type="text"  value="" placeholder="name" class="form-control" name="name" id="name" required>
							</div>
						</div>
						<div class="wrapper" id="input_embed">
							<div class="form-group">
								<label for="">Channel Description *</label>
								<textarea rows="5" style="border-radius:3%;width:100%;"name="description" placeholder="Enter Description....." required></textarea>
							</div>
						</div>
						<div class="wrapper" id="input_embed">
							<div class="form-group">
								<label for="">Main Channel Feed *</label>
								<textarea rows="5" cols="95" style="border-radius:3%;width:100%;" name="main_frame" placeholder="Enter Feed....." required></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="upload">Channel Logo </label>
							<input type="file" id="upload" name="upload" required>
						</div>
						
						<div class="wrapper" id="">
							<div class="form-group">
								<label for="">Channel Feed (1)*</label>
								<textarea rows="5" cols="95" style="border-radius:3%;width:100%;" name="iframe[]" placeholder="Embed Code....." required></textarea>
							</div>
							<div class="form-group">
								<label for="">Channel Feed (2)</label>
								<textarea rows="5" cols="95" style="border-radius:3%;width:100%;" name="iframe[]" placeholder="Embed Code....." ></textarea>
							
					
							</div>
							<div class="form-group">
								<label for="">Channel Feed (3)</label>
								<textarea rows="5" cols="95" style="border-radius:3%;width:100%;" name="iframe[]" placeholder="Embed Code....." ></textarea>
								<input type="hidden" id="number" value="3">
								<div class="add" style="display:block;" id="add"></div>
								<a href="javascript:;" class="btn btn-success glyphicon-plus" id="btn2"></a>
							</div>
						</div>
						
						<div class="form-group" align="right" style="">
							<input class="submit btn btn-primary" type="submit" name="add_channel" id="add_channel" value="Add Channel" />
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


 $("#btn2").click(function(){
		var number = $("#number").val();
		number++;
		//console.log(number);
        $(".add").append("<label for=''>Channel Feed ("+number+")</label><textarea rows='5' cols='95' style='border-radius:3%;width:100%;' name='iframe[]' id='last1' placeholder='Iframe.....' ></textarea>");
		
		$("#number").val(number);
    });
$('#btn3 #last1:last').remove();
// $(document).ready(function(){
   
// });
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

