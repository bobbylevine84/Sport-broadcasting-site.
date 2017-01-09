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
            <form class="cmxform" id="" action="<?php echo base_url(); ?>custom/manage_custom/custom_nation_process" method="POST"  enctype="multipart/form-data">
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
							$rss->where('nation !=', ' ');
							$nation = $rss->get('rss_competition')->result_array();
							
							$this->db->where('nation',$nation[0]['nation']);
							$my_nation = $this->db->get('kt_nation_custom_text')->result_array();
						?>	
						<div class="form-group">
							<label for="standard-list1">Select Nation</label>
							<select class="form-control" id="type" name="nation_type">
								<?php foreach($nation as $s){ ?>
									<option value="<?php echo $s['nation'];?>">
										<?php echo ucwords($s['nation']);?>
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
							<label for="standard-list1">Title</label>
							<input type="text" required id="title" name="title" value="<?php echo $my_nation[0]['title']; ?>" class="form-control">
						</div>
						<div class="form-group">
							<label for="standard-list1">Keywords</label>
							<input type="text" required value="<?php echo $my_nation[0]['keywords']; ?>" id="keywords" name="keywords" class="form-control">
						</div>
						<div class="form-group">
							<label for="standard-list1">Description</label>
							<input type="text" required value="<?php echo $my_nation[0]['description']; ?>" id="description" name="description" class="form-control">
						</div>
					 
						<div class="wrapper" id="description">
							<div class="form-group">
								<label for="">Add Text *</label>
								<div class="spin">
								<textarea class="ckeditor editor1" name="detail" id="spinnable_detail" name="detail" rows="14"><?php echo $my_nation[0]['article']; ?></textarea>
								</div>
								<textarea rows="5" id="fixed" style="width:100%;border-radius:3%;" name="article" placeholder="Add Description....."><?php echo $my_nation[0]['article']; ?></textarea>
							</div>
						</div>
					
					<span>%nation% <b>for Nation Name.</b></span></br>
					<span>%competitions% <b>Competitions belong to this nation.</b></span></br>
						
						<div class="form-group" align="right" style="">
					<input class="submit btn btn-primary" type="submit" name="nation" id="nation" value="Add Text" />
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
		var nation_type = $('#type').val();
		//console.log(sport_type)
		$.ajax({
			type : "POST",
			url : "<?php echo base_url();?>custom/manage_custom/get_data",
			data : {'n_id' : nation_type},
			success : function(data){
				
				data = JSON.parse(data);
				console.log(data);
				if(data.length == 0){
					$('#title').val('%nation% live streams');
					$('#keywords').val('%nation% live sports streams, live streaming %nation% sports, %nation% live streaming sports, %nation% sports live streams');
					$('#fixed').val('');
					$('#description').val('%nation% live sports streams page,  if you are a sports fan looking for sports streams for teams from %nation% this is the page for you.');
					CKEDITOR.instances.spinnable_detail.setData('');

				} else {
					$('#title').val(data[0].title);
					$('#keywords').val(data[0].keywords);
					$('#fixed').val(data[0].article);
				   CKEDITOR.instances.spinnable_detail.setData(data[0].article);
					$('#description').val(data[0].description);
				}
				
				
			}
		});
	});
});
</script>

