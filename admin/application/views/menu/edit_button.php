<?php 
$session_post_data = $this->session->userdata('add-new-button-data');
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
                            <div class="panel-title">
                            	<span class="glyphicon glyphicon-book"></span> Add New Button 
                            </div>
                        </div>
                        <div class="panel-body alerts-panel">
                            <form class="cmxform" id="add_new_menu_frm" method="POST" 
                            	action="<?php echo SURL?>menu/manage-buttons/edit-button/<?php echo $get_row['id']?>">
								<div class="row">
									<div class="col-md-offset-3 col-md-6">
										<?php if(validation_errors()){
										?>
											<div class="alert alert-danger"><?php echo validation_errors();?></div>
										<?php
										}?>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="">Button Type:</label>
													<div class="">
													<input type="radio" <?php if($get_row['button_type']==1){?>checked="checked" <?php }?> name="button_type" value="1"> Blue
													<input type="radio" <?php if($get_row['button_type']==2){?>checked="checked" <?php }?> name="button_type" value="2"> Black
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Text:</label>
											<input type="text" name="button_text" value="<?php echo $get_row['button_text']?>" class="form-control">
										</div>
										<div class="form-group">
											<label>URL:</label>
											<input type="text" name="button_url" value="<?php echo $get_row['button_url']?>" class="form-control">
										</div>
										<div class="form-group clearfix">
											<button type="submit" class="btn btn-warning pull-right">Update Button</button>
										</div>
									</div>
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
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
    <script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
        $("#add_new_menu_frm").validate({
            rules: {
                menu_name: "required",
                parent_id: "required",
				display_order: {
					required: false,
					digits: true

				},
                
            },
			
            messages: {
                menu_name: "Enter Menu Name.",
                parent_id: "Select Parent Menu.",
				display_order : "Use digit to set a display order"
            }
        });
    
    });
    </script>
    <script>
    function show_input_field()
	{
		document.getElementById('http_field').style.display = 'block';
	}
	function hide_input_field()
	{
		document.getElementById('http_field').style.display = 'none';
	}
	
    </script>

</body>
</html>
