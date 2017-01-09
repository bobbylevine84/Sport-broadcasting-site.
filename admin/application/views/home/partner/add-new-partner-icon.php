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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add Strategic Partner Icon</div>
              
            </div>
            <div class="panel-body alerts-panel">
            
            <div class="alert-danger"><?php echo validation_errors(); ?></div>
            
              <form class="cmxform" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL?>home/manage-section/add-icon-partner-process" enctype="multipart/form-data">
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
                        <label for="page_title">Upload partner Icon *</label>
                        	<br/>
						 	 <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                - Allowed Extensions: jpg, jpeg, gif, tiff, png
                            </span>
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                Max Upload Size: 6MB; Recommended Dimension: 50 * 50
                            </span>
                        <input type="file" name="partner_icon">
                      </div>
                      
                      
                      <div class="row form-group">
                      <label class="col-md-11 text-left">URL Link</label>
                      <div class="col-xs-3">
                      <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                Please insert Full Link
                            </span>
                        <input type="text" name="partner_link" id="display_order" class="form-control">
                      </div>
                      </div>
                      
                      
                      <div class="row form-group">
                      <label class="col-md-11 text-left">Display Order</label>
                      <div class="col-xs-3">
                        <input type="text" name="display_order" id="display_order" value="1" class="form-control">
                      </div>
                    </div>
                    <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
<option value="1" <?php echo ($partner_icon_arr['status'] == 1) ? 'selected' : ''?>  >Active</option>
<option value="0" <?php echo ($partner_icon_arr['status'] == 0) ? 'selected' : ''?>>InActive</option>
                        </select>
                        </div>
                    </div>                      
                  </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" value="Add Icon" />
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
    

</body>
</html>
