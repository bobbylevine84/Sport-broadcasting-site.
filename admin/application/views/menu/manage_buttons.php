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
<script>
function save_text(a, id)
		{ 
			var content_text = document.getElementById(id).value;
				$.ajax({
				url: "<?php echo base_url(); ?>menu/manage_buttons/save_text/"+a+"/"+content_text+"", // Url to delete image function
				success: function()   // A function to be called if request succeeds
				{
					window.location.reload();
					//window.location.href="<?php echo base_url(); ?>templates/email/maintenance";
				}
				});
		}
</script>

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
						<div id="created-alert" class="alert alert-info"><!--Notification--></div>
						<div id="updated-alert" class="alert alert-success"><!--Notification--></div>
						<div id="deleted-alert" class="alert alert-danger"><!--Notification--></div>
						<div class="panel panel-visible">
                    		<div class="panel-heading">
                    			<div class="panel-title hidden-xs"> 
                    				<span class="glyphicon glyphicon-list"></span>Manage Buttons
                    			</div>
                                <a href="<?php echo base_url('menu/manage-buttons/add-new-button'); ?>">
                                	<div class="panel-title hidden-xs pull-right">
                                    	<span class="glyphicon glyphicon-plus"></span>
                                        Add New Button
                                   	</div>
                             	</a>

                    		</div>
							<div class="panel-body padding-bottom-none">
							
								<table class="table table-striped table-bordered table-hover" id="example_form">
									<tr>
										<th>Button</th>
										<th>Label / Title / Name</th>
										<th>Text</th>
										<th>URL</th>
										<th>Action</th>
									</tr>
									<?php
									foreach($button_data as $btn_row){
									?>
										<tr>
											<td>
												<?php 
												if($btn_row['button_type']==1){
												?>
													<a href="#" class="image-replaced" id="open-live-account"><?php echo $btn_row['button_text'];?></a>
												<?php
												}else{
												?>
													<a href="#" id="open-demo-account"><?php echo $btn_row['button_text'];?></a>
												<?php
												}
												?>
											</td>
											<td><?php echo $btn_row['button_slug'];?></td>
											<td><?php echo $btn_row['button_text'];?></td>
											<td><?php echo $btn_row['button_url'];?></td>
											<td>
												<div class="btn-group">
												<a href="<?php echo base_url('menu/manage_buttons/edit_button')."/".$btn_row['id'];?>" class="btn btn-info btn-gradient">
													<span class="glyphicons glyphicons-edit"></span>
												</a>
												<a href="<?php echo base_url('menu/manage_buttons/delete_button')."/".$btn_row['id'];?>" class="btn btn-danger btn-gradient">
													<span class="glyphicons glyphicons-remove"></span>
												</a>
											</td>
										</tr>
									<?php
									}
									?>
								</table>
							</div>
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

<script>
	$(document).ready(function() {
		$('#example_form').DataTable();
	});
	//Notification
	$( "#created-alert").hide();
	$( "#updated-alert").hide();
	$( "#deleted-alert").hide();
	<?php if($this->session->flashdata('created')){ ?>
		$('#created-alert').html('<strong><?php echo $this->session->flashdata('created'); ?></strong>').show();
	<?php } ?>
	<?php if($this->session->flashdata('updated')){ ?>
		$('#updated-alert').html('<strong><?php echo $this->session->flashdata('updated'); ?></strong>').show();
	<?php } ?>
	<?php if($this->session->flashdata('deleted')){ ?>
		$('#deleted-alert').html('<strong><?php echo $this->session->flashdata('deleted'); ?></strong>').show();
	<?php } ?>
	

	</script>

</body>
</html>
