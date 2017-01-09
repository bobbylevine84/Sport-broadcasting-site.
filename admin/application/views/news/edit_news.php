<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="<?php echo VENDOR ?>editors/ckeditor/ckeditor.js"></script> 
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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit News</div>
			  <a href="<?php echo base_url('news/manage_news/'); ?>">
					<div class="panel-title hidden-xs pull-right">
						<span class="glyphicon glyphicon-hand-left"></span>
						Go Back
					</div>
				</a>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL?>news/manage_news/edit_news_process" enctype="multipart/form-data">
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
                        <label for="sponsor_bank_name">Title *</label>
                        <input type="text"  value="<?php echo stripslashes($news_data['title']) ?>" placeholder="" class="form-control" name="title" id="title" required>
                    </div>
                      <div class="form-group">
                        <label for="sponsor_bank_name">Keywords *</label>
                        <input type="text"  value="<?php echo stripslashes($news_data['keywords']) ?>" placeholder="" class="form-control" name="keywords" id="keywords" required>
                    </div>
					 <div class="form-group">
                        <label for="sponsor_bank_name">Description *</label>
                        <input type="text"  value="<?php echo stripslashes($news_data['description']) ?>" placeholder="" class="form-control" name="description" id="description" required>
                    </div>

                    <div class="form-group">
                        <label for="content">Content *</label>
                        <textarea  placeholder="" class="form-control ckeditor editor1" name="content"  required><?php echo stripslashes($news_data['content']) ?> </textarea>
                    </div>
                      <div class="form-group">
                    
						<span class="btn btn-default btn-file">
						 <input type="file" id="upload" name="upload">
                         	<a class="image-popup-no-margins" href="<?php echo base_url();?>uploads/game_images/<?php echo stripslashes($news_data['image'])?>">
                            	<img src="<?php echo base_url();?>uploads/game_images/<?php echo stripslashes($news_data['image'])?>" style="height:50px;width:50px;" >
                            </a>
                      </div> 
                    <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1" <?php echo ($news_data['status'] == '1') ? 'selected' : ''?>  >Active</option>
                            <option value="0" <?php echo ($news_data['status'] == '0') ? 'selected' : ''?>>InActive</option>
                        </select>
                        </div>
                    </div>                      
                  </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="upd_news_sbt" id="upd_news_sbt" value="Update News" />
                        <input type="hidden" name="news_id" id="news_id" value="<?php echo $news_data['id'] ?>" readonly>
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
    
		//Image Gallery 
		$('.image-popup-no-margins').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			closeBtnInside: false,
			fixedContentPos: true,
			mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
			image: {
				verticalFit: true
			},
			zoom: {
				enabled: true,
				duration: 300 // don't foget to change the duration also in CSS
			}
		});

      // validate signup form on keyup and submit
		$("#add_new_slider_image_frm").validate({

            rules: {
				display_order: {
					required: false,
					digits: true
				},
				sponsor_bank_url: {
					required: false,
					url: true
				},
				
            },

            messages: {
				display_order : "Use digit to set a display order"
            }

		});

    });
	
    </script>

</body>
</html>
