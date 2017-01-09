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
				<div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New keyword</div>
				<a href="<?php echo base_url('keyword/manage_keyword/'); ?>">
					<div class="panel-title hidden-xs pull-right">
						<span class="glyphicon glyphicon-hand-left"></span>
						Go Back
					</div>
				</a>
				</div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="" action="<?php echo base_url(); ?>keyword/manage_keyword/add_keyword_process" method="POST"  enctype="multipart/form-data">
						<?php
							if($this->session->flashdata('err_message')){
						?>
								<div class="alert alert-danger" id="fail"><?php echo $this->session->flashdata('err_message'); ?></div>
						<?php
							}
							
							if($this->session->flashdata('ok_message')){
						?>
								<div class="alert alert-success alert-dismissable" id="success"><?php echo $this->session->flashdata('ok_message'); ?></div>
						<?php 
							}//if($this->session->flashdata('ok_message'))
							
						?>	
						
						
							<div class="form-group">
								<label for="">Keyword*</label>
								<input type="text"  value="" placeholder="Enter Keyword" class="form-control" name="keyword" id="keyword" class="keyword" required>
							</div>
						<div class="form-group" align="right" style="">
							<input class="submit btn btn-primary" type="submit" name="add_Keyword" id="add_Keyword" value="Add Keyword" />
						</div>
		
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


<script src="<?php //echo SUR; ?>resources/js/jquery-ui.js"></script>	
<link rel="stylesheet" href="<?php //echo SUR; ?>resources/css/jquery-ui.css">
<script src="<?php //echo SUR; ?>resources/plugins/jquery-validation/dist/jquery.validate.min.js"></script>-->	
<!-- End: Footer --> 
 




</body>
</html>
