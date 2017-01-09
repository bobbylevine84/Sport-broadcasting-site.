<?php
//echo 'i am consumer/add view file';

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
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-visible">
                    		<div class="panel-heading">
                    			<div class="panel-title hidden-xs"> 
                    				<span class="glyphicon glyphicon-list"></span>Add Banner
                    			</div>
                    		</div>
							<div class="panel-body padding-bottom-none">
							<?php
                            if($this->session->flashdata('err_message')){
                            ?>
                            <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?>
                            </div>
							<?php
                            }//end if($this->session->flashdata('err_message'))
                            if($this->session->flashdata('ok_message'))
							{
                            ?>
                            <div class="alert alert-success alert-dismissable">
								<?php echo $this->session->flashdata('ok_message'); ?>
                         	</div>
                            <?php 
                            }//if($this->session->flashdata('ok_message'))
							?>
                            <?php if(validation_errors()== '' ){ ?>
                            		<div></div>
							<?php }else{ ?>
							<div class="alert alert-danger"><?php echo validation_errors(); ?>
                            </div>
							<?php } ?>
							
			<form action="<?php echo base_url('banner/manage_banner/add_new_banner_process') ; ?>" method="post" enctype="multipart/form-data"> 
                                
<div class="row">
    <div class="col-md-5">
			
            <div class="form-group">
				<label>Upload Banner:</label>
				<input id="banner_image" name="banner_image" class="form-control" type="file" required  />
			</div>
			
			<div class="form-group">
                  <label>Active:</label>
                  <input type="radio" name="status" value="1" required>
                  <br>
                  <label>Inactive:</label>
                  <input type="radio" name="status" value="0" required>
                  
              </div>
			
			<div class="form-group">
				<input id="add_banner_btn" name="add_banner_btn" class="btn btn-primary" type="submit" value="Add Banner"/>
			</div>
			
			
            
			
    </div>
</div>
			</form> 
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
</body>
</html>



