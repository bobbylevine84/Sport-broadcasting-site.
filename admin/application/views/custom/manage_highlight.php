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
				<div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Text</div>
				</div>
            <div class="panel-body alerts-panel">
            <form class="cmxform" id="" action="<?php echo base_url(); ?>custom/manage_custom/custom_highlight_process" method="POST"  enctype="multipart/form-data">
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
							$rss = $this->load->database('rss', TRUE);

							$get_events = $this->db->get('kt_highlight_custom_text')->result_array();
							//echo "<pre>";print_r($get_sport);
						?>	

						<div class="form-group">
							<label for="standard-list1">Title</label>
							<input type="text" required id="title" name="title" value="<?php echo $get_events[0]['title']; ?>" class="form-control">
						</div>
						<div class="form-group">
							<label for="standard-list1">Keywords</label>
							<input type="text" required value="<?php echo $get_events[0]['keywords']; ?>" id="keywords" name="keywords" class="form-control">
						</div>
						<div class="form-group">
							<label for="standard-list1">Description</label>
							<input type="text" required value="<?php echo $get_events[0]['description']; ?>" id="description" name="description" class="form-control">
						</div> 
						<div class="wrapper" id="description">
							<div class="form-group">
								<label for="">Add Text *</label>
								<div class="spin">
								<textarea class="ckeditor editor1" name="detail" id="spinnable_detail" name="detail" rows="14"><?php echo $get_events[0]['article']; ?></textarea>
								</div>
							</div>
						</div>
						
					
				<div class="spin">
					<span>%home_team% <b>for Home Team name.</b></span></br>
					<span>%away_team% <b>for Away Team name.</b></span></br>
					<span>%start_date% <b>for Event Start Date.</b></span></br>
					<span>%end_date% <b>for Event Ending Date.</b></span></br>
					<span>%duration% <b>for Duration.</b></span></br>
					<span>%nation% <b>for Nation Name.</b></span></br>
					<span>%competition% <b>for Competition Name.</b></span></br>
				</div>

					  <?php $rule = $this->db->get('kt_welcome_section')->result_array();?>
					  <br><br>
                      <div class="form-group">

                      	<label for="">Main Page Article</label>
                        <textarea class="ckeditor editor1"  id="note" name="note" rows="14"><?php echo $rule[0]['note'] ?></textarea>
                      </div>
                    	<div class="form-group" align="right" style="">
					<input class="submit btn btn-primary" type="submit" name="add_highlight" id="add_highlight" value="Add Text" />
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

</body>
</html>

<script>
$(document).ready(function(){
	//$('.spin').hide();
	$('#fixed').hide();
	
	$('#text').change(function() {
		var value = $('#text').val();
		if(value == 'spinnable'){
			$('.spin').show();
			$('#fixed').hide();
		} else {
			$('.spin').hide();
			$('#fixed').show();
		}
	});
	
	$('#c_type').change(function() {
		var c_type = $('#c_type').val();
		
		$.ajax({
			type : "POST",
			url : "<?php echo base_url();?>custom/manage_custom/get_events_by_competition",
			data : {'c_id' : c_type},
			success : function(data){
				console.log(data)
				document.getElementById('type').innerHTML = data;
				
				
				
				
			}
		});
	});
	
	$('#type').change(function() {
		var h_type = $('#type').val();
		
		$.ajax({
			type : "POST",
			url : "<?php echo base_url();?>custom/manage_custom/get_data",
			data : {'h_id' : h_type},
			success : function(data){
				
				data = JSON.parse(data);
				console.log(data);
				if(data.length == 0){
					$('#title').val('');
					$('#keywords').val('');
					$('#fixed').val('');
					$('#description').val('');
				} else {
					$('#title').val(data[0].title);
					$('#keywords').val(data[0].keywords);
					$('#fixed').val(data[0].article);
					$('#description').val(data[0].description);
				}
				
				
			}
		});
	});
});
	
</script>