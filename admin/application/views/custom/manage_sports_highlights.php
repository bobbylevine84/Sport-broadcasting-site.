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
            <form class="cmxform" id="" action="<?php echo base_url(); ?>custom/manage_custom/custom_sports_highlights_process" method="POST"  enctype="multipart/form-data">
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
							$rss->select('category_name,id, sport_status');
							$rss->group_by('id');
							$rss->where('sport_status','active');
							$sport = $rss->get('rss_sport_category')->result_array();
							
							$this->db->where('sport_id',$sport[0]['id']);
							$get_sport = $this->db->get('kt_sports_highlights_custom_text')->result_array();
							//echo "<pre>";print_r($get_sport);
						?>	
						<div class="form-group">
							<label for="standard-list1">Select Sport</label>
							<select class="form-control" id="type" name="sport_type">
								<?php foreach($sport as $s){ ?>
									<option value="<?php echo $s['id'];?>">
										<?php echo ucwords($s['category_name']);?>
									</option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label for="standard-list1">Title</label>
							<input type="text" required id="title" name="title" value="<?php echo $get_sport[0]['title']; ?>" class="form-control">
						</div>
						<div class="form-group">
							<label for="standard-list1">Keywords</label>
							<input type="text" required value="<?php echo $get_sport[0]['keywords']; ?>" id="keywords" name="keywords" class="form-control">
						</div>
						<div class="form-group">
							<label for="standard-list1">Description</label>
							<input type="text" required value="<?php echo $get_sport[0]['description']; ?>" id="description" name="description" class="form-control">
						</div>
					 
						<div class="wrapper" id="description">
							<div class="form-group">
								<label for="">Add Text *</label>
							
								<textarea class="ckeditor editor1" rows="5" id="fixed" style="width:100%;border-radius:3%;" name="article" placeholder="Add Description....."><?php echo $get_sport[0]['article']; ?></textarea>
							</div>
						</div>
						<?php $this->db->select('id');
						$this->db->where('sport_id',$sport['id']);
						$get_id = $this->db->get('kt_sports_highlights_custom_text')->result_array();
						?>
						<input type="hidden" value="<?php $get_id[0]['id'];?>" name="id">
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

	
	
	$('#type').change(function() {
		var sport_type = $('#type').val();
		//console.log(sport_type)
		$.ajax({
			type : "POST",
			url : "<?php echo base_url();?>custom/manage_custom/get_data",
			data : {'sport1_id' : sport_type},
			success : function(data){
				
				data = JSON.parse(data);
				console.log(data);
				if(data.length == 0){
					$('#title').val('');
					$('#keywords').val('');
					CKEDITOR.instances.fixed.setData('');
					$('#description').val('');
				} else {
					$('#title').val(data[0].title);
					$('#keywords').val(data[0].keywords);
					CKEDITOR.instances.fixed.setData(data[0].article);
					$('#description').val(data[0].description);
				}
				
				
			}
		});
	});
});
	
</script>