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
            <form class="cmxform" id="" action="<?php echo base_url(); ?>custom/manage_custom/custom_team_process" method="POST"  enctype="multipart/form-data">
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
							
							$rss->order_by('display_order','asc');
							$rss->where('parent',NULL);
							$rss->where('sport_status','active');
							$get_sport = $rss->get('rss_sport_category')->result_array();
							
							$rss->select('name,id');
							$rss->group_by('id');
							$rss->where('sport_cat_id',$get_sport[0]['id']);
							$team = $rss->get('rss_team')->result_array();
							
							$this->db->where('team_id',$team[0]['id']);
							$my_team = $this->db->get('kt_team_custom_text')->result_array();
						?>	
						<div class="form-group">
							<label for="standard-list1">Select Sport</label>
							<select class="form-control" id="c_type" name="sport_type">
								<?php foreach($get_sport as $st){ ?>
									<option value="<?php echo $st['id'];?>">
										<?php echo ucwords($st['category_name']);?>
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
							<label for="standard-list1">Select Team</label>
							<select class="form-control" id="type" name="team_type">

								<?php foreach($team as $s){ ?>
									<option value="<?php echo $s['id'];?>">
										<?php echo ucwords($s['name']);?>
									</option>
								<?php } ?>
							</select>
						</div>  
						<div class="form-group">
							<label for="standard-list1">Title</label>
							<input type="text" required id="title" name="title" value="<?php echo $my_team[0]['title']; ?>" class="form-control">
						</div>
						<div class="form-group">
							<label for="standard-list1">Keywords</label>
							<input type="text" required value="<?php echo $my_team[0]['keywords']; ?>" id="keywords" name="keywords" class="form-control">
						</div>
						<div class="form-group">
							<label for="standard-list1">Description</label>
							<input type="text" required value="<?php echo $my_team[0]['description']; ?>" id="description" name="description" class="form-control">
						</div>
						
						<div class="wrapper" id="description">
							<div class="form-group">
								<label for="">Add Text *</label>
								<div class="spin">
								<textarea class="ckeditor editor1" name="detail" id="spinnable_detail" name="detail" rows="14"><?php echo $my_team[0]['article']; ?></textarea>
								</div>
								<textarea rows="5" id="fixed" style="width:100%;border-radius:3%;" name="article" placeholder="Add Description....."><?php echo $my_team[0]['article']; ?></textarea>
							</div>
						</div>
						
						<div class="form-group" align="right" style="">
					<input class="submit btn btn-primary" type="submit" name="add_highlight" id="add_highlight" value="Add Text" />
				</div>
				<div class="spin">
					<span>%Team_name% <b>for Team name.</b></span></br>
					<span>%nation_name% <b>for Nation name.</b></span></br>
					<span>%year_founded% <b>for year Founded.</b></span></br>
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
$('#c_type').change(function() {
		var c_type = $('#c_type').val();
		//alert(c_type);
		$.ajax({
			type : "POST",
			url : "<?php echo base_url();?>custom/manage_custom/get_team_by_sport",
			data : {'sport' : c_type},
			success : function(data){
				console.log(data)
					$('#title').val('');
					$('#keywords').val('');
					$('#fixed').val('');
					$('#description').val('');
				document.getElementById('type').innerHTML = '<option>Select Team </option>' + data;
				
				
				
				
			}
		});
	});
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
		var team_type = $('#type').val();
		//console.log(team_type)
		$.ajax({
			type : "POST",
			url : "<?php echo base_url();?>custom/manage_custom/get_data",
			data : {'team_id' : team_type},
			success : function(data){
				
				data = JSON.parse(data);
				console.log(data);
				if(data.length == 0){
					$('#title').val('%Team_name% live streams');
					$('#keywords').val('%Team_name% live sports streams, live streaming %Team_name% sports, %Team_name% live streaming, %Team_name% live streams, live %Team_name% streams');
					$('#fixed').val('');
					CKEDITOR.instances.spinnable_detail.setData('');
					$('#description').val('Welcome to Real Stream Sports, this page is for %Team_name% live streams, we hope you enjoy our site.');
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
