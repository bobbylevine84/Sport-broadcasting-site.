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
				<div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Highlight</div>
				<a href="<?php echo base_url('highlight/manage_highlight/'); ?>">
					<div class="panel-title pull-right">
						<span class="glyphicon glyphicon-hand-left"></span>
						Go Back
					</div>
				</a>
				</div>
            <div class="panel-body alerts-panel">
            <form class="cmxform" id="" action="<?php echo base_url(); ?>highlight/manage_highlight/add_new_highlight_process" method="POST"  enctype="multipart/form-data">
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
								
								$converted_datetime = gmdate('Y-m-d H:i:s');
								$converted_date = date('Y-m-d', strtotime($converted_datetime));
			
								$datetime = new DateTime($converted_datetime);
								$datetime->modify('-2 day');
								$session_date_yesterday = $datetime->format('Y-m-d H:i:s');
							
							
						?>	
									<?php
							$rss = $this->load->database('rss', TRUE);
							$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
							$rss->where('rss_events.start_date <',$converted_datetime ); //h:i:s for time as well.
							$rss->order_by('rss_events.start_date','aesc');
							$query=$rss->get('rss_events')->result_array();
							//echo $this->db->last_query();
									//echo "<pre>";print_r($query);exit;
									?>	
							<div class="form-group" style="margin-top:42px;">
								<label for="standard-list1"> Select Event</label>
								<select class="form-control" id="event" name="event">
								<?php foreach($query As $event) { ?>
									<option value="<?php echo $event['id']; ?>" id="<?php $event['id'];?>" >
									<?php date('G:i', (strtotime($event['start_date'])+(5*60*60)+($session_time * 60 * 60)));?> /
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


<script>
//FOR DATE
formatAMPMd();


function formatAMPMd() {
var d = new Date(),

    minutes2 = d.getMinutes().toString().length == 1 ? '0'+d.getMinutes() : d.getMinutes(),
    hours2 = d.getHours().toString().length == 1 ? '0'+d.getHours() : d.getHours(),
   // ampm2 = d.getHours() >= 12 ? ' PM' : ' AM';
  months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
   days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
	var my_date = months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear();
	var my_time = months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear()+' '+hours2+':'+minutes2;
	//alert(my_date);
	
	$.post("<?php echo base_url();?>stream/manage_stream/get_date",{
				date : my_date,
				date_time : my_time
			}).done(function(data){
				console.log(data);
			});
			
return days[d.getDay()]+' '+months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear()+' '+hours+':'+minutes+ampm;

}

</script>