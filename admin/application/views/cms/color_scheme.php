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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Color</div>
              
            </div>
            
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_liquidity_image_frm" method="POST" action="<?php echo SURL ?>cms/color_scheme/color_scheme_process" enctype="multipart/form-data">
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

                      <!-- <div class="form-group"> -->
                        <!-- <label for="page_short_desc">Title</label> -->
                        <!-- <textarea class="form-control" id="liquidity_caption" name="liquidity_caption" rows="1"><?php echo $session_post_data['liquidity_caption'] ?></textarea> -->
                      <!-- </div> -->
                      
						<div class="row form-group">
						<?php 
						$ip = $_SERVER['REMOTE_ADDR'];
						$this->db->where('user_ip',$ip);
						$color = $this->db->get('kt_color')->result_array();
								
						?>
							<div class="col-md-5">
							  <label for="standard-list1">Choose Color</label>
								<select class="form-control" id="status" name="color">
								<option value="blue" <?php if($color[0]['color'] == "blue") { ?> selected <?php }?> >Blue</option>
								<option value="orange" <?php if($color[0]['color'] == "orange") { ?> selected <?php }?> >Orange</option>
								<option value="purple" <?php if($color[0]['color'] == "purple") { ?> selected <?php }?> >Purple</option>
								<option value="green" <?php if($color[0]['color'] == "green") { ?> selected <?php }?> >Green</option>
								<option value="black" <?php if($color[0]['color'] == "black") { ?> selected <?php }?> >Night</option>
							</select>
							</div>
						</div>                 
                  </div>
                  
                    <div class="form-group" align="" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="add_image_sbt" id="add_image_sbt" value="Change Color" />
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
		$("#add_new_liquidity_image_frm").validate({

            rules: {
				display_order: {
					required: false,
					digits: true
				},
            },

            messages: {
				display_order : "Use digit to set a display order"
            }

		});

		$("#liquidity_image").rules(
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
