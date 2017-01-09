<?php 
$session_post_data = $this->session->userdata('add-page-data');
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
							<div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Manage Detail </div>
						</div>
						<div class="panel-body alerts-panel">
							<form class="cmxform" id="add_new_cms_page_frm" method="POST" action="<?php echo SURL?>event/manage_event/add_new_event_detail_process">
								<div class="tab-content border-none padding-none">
									<div id="cms_main_contents" class="tab-pane active">
										<?php
										if($this->session->flashdata('err_message')){
											?>
											<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
											<?php
										}//end if($this->session->flashdata('err_message'))
										
										if($this->session->flashdata('ok_message')){
											?>
											<div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
										<?php 
										}//if($this->session->flashdata('ok_message'))
										?>
										<div class="form-group">
										<label for="detail">Event Detail</label>
										</div>
										<?php $rule = $this->db->get('kt_event_detail')->result_array();?>
										<div class="form-group">
											<textarea class="ckeditor editor1"  id="detail" name="detail" rows="14"><?php echo $rule[0]['detail'] ?></textarea>
										</div>                    
									</div>
									<div class="form-group" align="right" style="margin-right:17px">
										<input class="submit btn btn-blue" type="submit" name="add_event_rule_sbt" id="add_event_rule_sbt" value="Update Event Detail" />
									</div>
								</div>
							</form>
							<span>%home_team% <b>for Home Team name.</b></span></br>
							<span>%away_team% <b>for Away Team name.</b></span></br>
							<span>%start_date% <b>for Event Start Date.</b></span></br>
							<span>%end_date% <b>for Event Ending Date.</b></span></br>
							<span>%duration% <b>for Duration.</b></span></br>
							<span>%nation% <b>for Nation Name.</b></span></br>
							<span>%competition% <b>for Competition Name.</b></span></br>
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
