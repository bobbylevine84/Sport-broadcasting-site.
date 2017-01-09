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
              <form class="cmxform" id="" action="<?php echo base_url(); ?>stream/manage_stream/update_stream_process" method="POST"  enctype="multipart/form-data">
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
							
							$my_date_time =  $this->session->userdata('session_date_time');
							
							
							$session_time = $this->session->userdata('my_timezone'); 
							$date_time = (strtotime($my_date_time) - ($my_timezone * 60 * 60));
							$converted_datetime = date('Y-m-d H:i:s', $date_time);
							$converted_date = date('Y-m-d', strtotime($converted_datetime));
						
							
							$datetime = new DateTime($converted_date);
							$datetime->modify('-1 day');
							$session_date_yesterday = $datetime->format('Y-m-d');
							
						?>	
						<?php
						$rss = $this->load->database('rss', TRUE);
						$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
						$rss->where('DATE(rss_events.start_date) <',$converted_date ); //h:i:s for time as well.
						$rss->order_by('rss_events.start_date','aesc');
						$query=$rss->get('rss_events')->result_array();
						
						//$rss->where('parent',NULL);
						$rss->where('sport_status','active');
						$rss->order_by('display_order','aesc');
						$sport_category = $rss->get('rss_sport_category')->result_array();
						//echo $rss->last_query();
						?>
						
						<input type="hidden" value="<?php echo $stream_data[0]['id']; ?>" name="my_id">
						<div class="wrapper" id="input_url">
							<div class="form-group">
								<label for="">Stream URL *</label>
								<input type="text"  value="<?php echo $stream_data[0]['url']; ?>" placeholder="URL" class="form-control" name="url" id="url" required>
							</div>
						</div>
						<div class="form-group">
							<label for="standard-list1">Language</label>
							<select class="form-control" id="language" name="language">
								<option value="English" <?php if($stream_data[0]['language'] == "English"){?> selected <?php } ?> >English</option>
								<option value="Arabic" <?php if($stream_data[0]['language'] == "Arabic"){?> selected <?php } ?> >Arabic</option>
								<option value="Russian" <?php if($stream_data[0]['language'] == "Russian"){?> selected <?php } ?> >Russian</option>
								<option value="Dutch" <?php if($stream_data[0]['language'] == "Dutch"){?> selected <?php } ?> >Dutch</option>
								<option value="Spanish" <?php if($stream_data[0]['language'] == "Spanish"){?> selected <?php } ?> >Spanish</option>
								<option value="German" <?php if($stream_data[0]['language'] == "German"){?> selected <?php } ?> >German</option>
								<option value="Chinese" <?php if($stream_data[0]['language'] == "Chinese"){?> selected <?php } ?> >Chinese</option>
								<option value="Urdu"<?php if($stream_data[0]['language'] == "Urdu"){?> selected <?php } ?> >Urdu</option>
								<option value="Japenese" <?php if($stream_data[0]['language'] == "Japenese"){?> selected <?php } ?> >Japenese</option>
								<option value="Hindi" <?php if($stream_data[0]['language'] == "Hindi"){?> selected <?php } ?> >Hindi</option>
								<option value="Other" <?php if($stream_data[0]['language'] == "Other"){?> selected <?php } ?> >Other</option>
							</select>
						</div>  						
						<div class="form-group">
						<label for="standard-list1">Bitrate(kbps) *</label>
						<input type="text"  value="<?php echo $stream_data[0]['total_bitrate']; ?>" placeholder="Bitrate in Kbps:" class="form-control" name="total_bitrate" id="total_bitrate" required>
						</div> 
						<div class="form-group">
						<label for="standard-list1">Type</label>
						<select class="form-control" id="type" name="type">
							<option value="http" <?php if($stream_data[0]['type'] == "http"){?> selected <?php } ?> >http</option>
							<option value="acestream" <?php if($stream_data[0]['type'] == "acestream"){?> selected <?php } ?> >acestream</option>
							<option value="sopcast" <?php if($stream_data[0]['type'] == "sopcast"){?> selected <?php } ?> >sopcast</option>
							<option value="vlc" <?php if($stream_data[0]['type'] == "vlc"){?> selected <?php } ?> >vlc</option>
							<option value="p2p" <?php if($stream_data[0]['type'] == "p2p"){?> selected <?php } ?> >p2p</option>
							<option value="Other" <?php if($stream_data[0]['type'] == "Other"){?> selected <?php } ?> >Other </option>
						</select>
						</div>  						
						<div class="form-group">
							<label for="standard-list1">Mobile Compatibility</label>
							<select class="form-control" id="compatibility" name="compatibility">
								<option value="Yes" <?php if($stream_data[0]['compatibility'] == "Yes"){?> selected <?php } ?> >Yes.</option>
								<option value="No" <?php if($stream_data[0]['compatibility'] == "No"){?> selected <?php } ?> >No.</option>
							</select>
						</div>  
						<div class="wrapper" id="input_channel">
							<div class="form-group">
								<label for=""> Sponsered *</label>
								<input type="checkbox"  value="1"  name="check" id="" <?php if($stream_data[0]['sponsered'] == "1"){?> checked <?php } ?> >
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
<script>
$('#sport_highlight').change(function(){
	var id = $('#sport_highlight').val();

	$.post("<?php echo base_url();?>stream/manage_stream/change_event_stream",{
		sport_id_stream : id,
	}).done(function(data){
		//alert(data);
		console.log(data)
		document.getElementById('event').innerHTML=data;
		 //document.getElementById('my_competition').innerHTML=data;
	});
		
});
</script>
</body>
</html>
