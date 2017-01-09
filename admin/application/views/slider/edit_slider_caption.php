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
              <span class="glyphicon glyphicon-book"></span> Edit Slider Caption </div>
              
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL?>slider/manage-slider/edit-caption-process">
                <div class="tab-content border-none padding-none">
                  <div id="cms_main_contents" class="tab-pane active">
                  <?php 
				  
				  	foreach($slide_cap as $r)
					{
						$title=$r->title;
						$content=$r->content;
						$readmore=$r->readmore;
					}
					 
				  ?>
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
                        <label for="page_short_desc">URL Link</label>
                        <textarea class="form-control" name="slider_caption" rows="1"><?php echo $title; ?></textarea>
                      </div>
                      <div class="form-group">
                        <label for="page_short_desc">Content</label>
                        <textarea class="form-control" id="slider_content" name="slider_content" rows="3"><?php echo $content; ?></textarea>
                      </div>
                      
                      <div class="row form-group">
                      <label class="col-md-11 text-left">Readmore Link</label>
                      <div class="col-xs-3">
                        <input type="text" name="caption_readmore" id="display_order" value="<?php echo $readmore; ?>" class="form-control">
                      </div>
                    </div>                
                  </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="upd_image_sbt" id="upd_image_sbt" value="Update Caption" />
                        
                    </div>
                </div>
				
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="min-height:50px;">&nbsp;</div>
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
