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
            <form class="cmxform" id="" action="<?php echo base_url(); ?>custom/manage_custom/custom_competition_process" method="POST"  enctype="multipart/form-data">
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
							$rss->select('nation');
							$rss->group_by('nation');
							$nation = $rss->get('rss_competition')->result_array();
							
							$rss->select('competition_name,competition_id');
							$rss->where('nation',$nation[0]['nation']);
							$rss->group_by('competition_id');
							$competition = $rss->get('rss_competition')->result_array();
							
							
							
							$this->db->where('competition_id',$competition[0]['competition_id']);
							$get_competition = $this->db->get('kt_nation_custom_text_custom_text')->result_array();
						?>
						<div class="form-group">
							<label for="standard-list1">Select Nation</label>
							<select class="form-control" id="c_type" name="nation_type">
								<?php foreach($nation as $se){ ?>
									<option value="<?php echo $se['nation'];?>">
										<?php echo ucwords($se['nation']);?>
									</option>
								<?php } ?>
							</select>
						</div>
								<div class="form-group">
							<label for="standard-list1">Text Type</label>
							<select class="form-control" id="text" name="text">
							<option value="spinnable" selected>Spinabble</option>
								<option value="fixed" >Fixed</option>
								
								
							</select>
						</div> 
						<div class="form-group">
							<label for="standard-list1">Select Competition</label>
							<select class="form-control" id="type" name="competition_type">
								<?php foreach($competition as $s){ ?>
									<option value="<?php echo $s['competition_id'];?>">
										<?php echo ucwords($s['competition_name']);?>
									</option>
								<?php } ?>
							</select>
						</div>  

						<div class="form-group">
							<label for="standard-list1">Title</label>
							<input type="text" required id="title" name="title" value="<?php echo $get_competition[0]['title']; ?>" class="form-control">
						</div>
						<div class="form-group">
							<label for="standard-list1">Keywords</label>
							<input type="text" required value="<?php echo $get_competition[0]['keywords']; ?>" id="keywords" name="keywords" class="form-control">
						</div>
						<div class="form-group">
							<label for="standard-list1">Description</label>
							<input type="text" required value="<?php echo $get_competition[0]['description']; ?>" id="description" name="description" class="form-control">
						</div>
					
						<div class="wrapper" id="description">
							<div class="form-group">
								<label for="">Add Text *</label>
								<div class="spin">
								<textarea class="ckeditor editor1" name="detail" id="spinnable_detail" name="detail" rows="14"><?php echo $get_competition[0]['article']; ?></textarea>
								</div>
								<textarea rows="5" id="fixed" style="width:100%;border-radius:3%;" name="article" placeholder="Add Description....."><?php echo $get_competition[0]['article']; ?></textarea>
							</div>
						</div>
							<span>%season% <b>Season.</b></span></br>
					<span>%competition% <b>Competition Name.</b></span></br>
						<input type="hidden" value="<?php $get_id[0]['competition_id'];?>" name="id">
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
	
	$('#type').change(function() {
		var c_type = $('#type').val();
		//console.log(sport_type)
		$.ajax({
			type : "POST",
			url : "<?php echo base_url();?>custom/manage_custom/get_data",
			data : {'c_id' : c_type},
			success : function(data){
				
				data = JSON.parse(data);
				console.log(data);
				if(data.length == 0){
					$('#title').val('Live %competition% Streams');
					$('#keywords').val('%competition% live sports streams, live %competition% streams, live streaming %competition% sports, %competition% live streaming, %competition% live streams');
					$('#fixed').val('');
					$('#description').val('Welcome to Real Stream Sports this is our live %competition% streams page.');
					 CKEDITOR.instances.spinnable_detail.setData('');
				} else {
					$('#title').val(data[0].title);
					$('#keywords').val(data[0].keywords);
					$('#fixed').val(data[0].article);
					$('#description').val(data[0].description);
				   CKEDITOR.instances.spinnable_detail.setData(data[0].article);
				}
				
				
			}
		});
	});
	$('#c_type').change(function() {
		var c_type = $('#c_type').val();
		
		$.ajax({
			type : "POST",
			url : "<?php echo base_url();?>custom/manage_custom/get_competition_by_nation",
			data : {'nation' : c_type},
			success : function(data){
				console.log(data)
				$('#title').val('');
					$('#keywords').val('');
					$('#fixed').val('');
					$('#description').val('');
				   CKEDITOR.instances.spinnable_detail.setData('');
				document.getElementById('type').innerHTML = '<option>Select Team </option>' + data;
				
				
				
				
			}
		});
	});
	
});
</script>
