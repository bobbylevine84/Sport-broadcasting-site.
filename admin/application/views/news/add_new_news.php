<?php 
$session_post_data = $this->session->userdata('add_news_data');
//print_r($session_post_data);exit;
?>
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
				<div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New News</div>
				<a href="<?php echo base_url('news/manage_news/'); ?>">
					<div class="panel-title hidden-xs pull-right">
						<span class="glyphicon glyphicon-hand-left"></span>
						Go Back
					</div>
				</a>
				</div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="" action="<?php echo SURL?>news/manage_news/add_new_news_process" method="POST"  enctype="multipart/form-data">
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
                        <label for="">Title *</label>
                        <input type="text"  value="" placeholder="Title" class="form-control" name="title" id="title" >
                    </div>
                       <div class="form-group">
                        <label for="sponsor_bank_name">Keywords *</label>
                        <input type="text"  value="<?php echo stripslashes($news_data['keywords']) ?>" placeholder="" class="form-control" name="keywords" id="keywords" required>
                    </div>
					<div class="form-group">
                        <label for="">Description *</label>
                        <input type="text"  value="" placeholder="Description" class="form-control" name="description" id="description" >
                    </div>
                       <div class="form-group">
                        <label for="content">Content *</label>
                        <textarea  placeholder="" class="form-control ckeditor editor1" name="content"  required><?php echo stripslashes($news_data['content']) ?> </textarea>
                    </div>
                      <div class="form-group">
                        <label for="upload">Upload Image *</label>
						<span>Please upload 28x28 sized logo</span>
						 <input type="file" id="upload" name="upload">
						 <!--
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                - Allowed Extensions: jpg, jpeg, gif, tiff, png
                            </span>
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                Max Upload Size: 6MB; Recommended Dimension: 800 * 600
                            </span>-->
                      </div>
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1" selected >Active</option>
                            <option value="0">InActive</option>
                        </select>
                        </div>
                    </div>                      
                  </div> 
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="add_new_news" id="add_new_news" value="Add New News" />
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
		$("#add_new_slider_image_frm").validate({

            rules: {
				sponsor_bank_name: "required",
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
				display_order : "Use digit to set a display order",
				sponsor_bank_name : "Bank Name cannot be empty"
            }

		});

		$("#sponsor_image").rules(
		 	"add", {
			 required:true,
			 extension: "jpg|jpeg|gif|tiff|png",
         	messages: {
				extension : "Please select valid image for epaper pages(Use: jpg, jpeg, gif, tiff, png)",
         }
      	});
		
    
    });
    </script>

</body>
</html>
