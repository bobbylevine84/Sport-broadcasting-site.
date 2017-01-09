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
				<div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Stream</div>
				<a href="<?php echo base_url('stream/manage_stream/'); ?>">
					<div class="panel-title hidden-xs pull-right">
						<span class="glyphicon glyphicon-hand-left"></span>
						Go Back
					</div>
				</a>
				</div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="" action="<?php echo base_url(); ?>stream/manage_stream/add_stream_process" method="POST"  enctype="multipart/form-data">
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
							
							$converted_datetime = gmdate('Y-m-d H:i:s');
							$converted_date = date('Y-m-d', strtotime($converted_datetime));
						
							
							$datetime = new DateTime($converted_datetime);
							$datetime->modify('+1 day');
							$session_date_yesterday = $datetime->format('Y-m-d H:i:s');
							
						?>	
						<?php
						$rss = $this->load->database('rss', TRUE);
						$rss->where('rss_events.start_date >=',$converted_datetime );
						$rss->where('rss_events.start_date <=',$session_date_yesterday );
						$rss->order_by('rss_events.start_date','aesc');
						$query=$rss->get('rss_events')->result_array();
						?>	
						<div class="form-group" style="margin-top:42px;">
							<label for="standard-list1"> Select Event</label>
							<select class="form-control" id="event" name="event">
							<?php foreach($query As $event) { ?>
								<option value="<?php echo $event['id']; ?>" id="<?php $event['id'];?>" >
								<?php echo date('G:i', (strtotime($event['start_date'])+($session_time * 60 * 60)));?> /
								<?php echo $event['home_team'].' vs '.$event['away_team']; ?></option>
							<?php } ?>
							</select>
						</div> 
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
								<option value="YES" selected >Yes, My Stream is compatible with mobile.</option>
								<option value="NO">No, i cannot confirm mobile compatibility.</option>
							</select>
						</div>  
						<div class="wrapper" id="input_channel">
							<div class="form-group">
								<label for=""> Channel *</label>
								<input type="text"  value="" placeholder="Channel" class="form-control" name="channel" id="channel" required>
							</div>
						</div>
						<div class="form-group" align="right" style="">
					<input class="submit btn btn-primary" type="submit" name="add_stream" id="add_stream" value="Add Stream" />
				</div>
				
				<!-- Here -->
				
	
			</form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End: Content --> 
  
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
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
