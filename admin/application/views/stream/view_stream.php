<?php //echo "<pre>"; print_r($get_highlight);exit; ?>
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
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-visible">
							<div class="panel-heading">
								<div class="panel-title"> <span class="glyphicon glyphicon-book"></span> View Stream</div>
								<a href="<?php echo base_url('stream/manage_stream/'); ?>">
									<div class="panel-title hidden-xs pull-right">
										<span class="glyphicon glyphicon-hand-left"></span>
										Go Back
									</div>
								</a>
							</div>
							<div class="panel-body">
								<?php 
								foreach($get_stream as $b) {?><?php if($this->session->userdata('is_sup_admin')==0){ }else{ ?>
								<?php if($b['stream_status']=='approved') {}else{
									?><a href="<?php echo base_url();?>stream/manage_stream/update_stream_status/<?php echo $b['id']?>" type="button" class="btn btn-success btn-gradient btn pull-right" style="" > Approve Stream </a>
									<?php
								} 
								?>
                                <div class="row">
                                
                                <div class="col-sm-10 col-xs-12">
								<div class="wrap1">
									<b>Event Name : </b>  <?php echo $b['home_team'].' <b>VS</b> '.$b['away_team']; ?>
								</div>
								<div class="wrap1">
									<b>Domain : </b>  <?php echo $b['stream_domain']; ?>
								</div>
								<div class="wrap2">
									<b>Language : </b>  <?php echo $b['language']; ?>
								</div>
								<div class="wrap2">
									<b>Mobile Compatibility : </b>  <?php echo $b['compatibility']; ?>
								</div>
								<div class="wrap2">
									<b>Highlight Type : </b>  <?php echo $b['type']; ?>
								</div>
								<div class="wrap2">
									<b>Bitrate  : </b>  <?php echo $b['total_bitrate']; ?>
								</div>
								<div class="wrap2">
									<b>Channel : </b>  <?php echo $b['channel']; ?>
								</div><hr>
								<div class="wrap3" span="6">
									<b>URL : </b><a href="<?php echo $b['url']; ?>" target="_blank"><?php echo $b['url']; ?></a>
								</div>
                                </div>
                                <div class="col-sm-2 col-xs-12">
								<a href="<?php echo base_url();?>stream/manage_stream/delete_stream/<?php echo $b['id']?>" type="button" class="btn btn-danger btn-gradient btn pull-right" style="" onClick="return confirm('Are you sure you want to delete?')"> Delete Stream </a>
								<?php } ?>
                                </div>
                                </div>	
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
    <div class="clearfix"></div>
    <div class="row" style="min-height:250px;">&nbsp;</div>
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
<script type="application/javascript">
</script>
