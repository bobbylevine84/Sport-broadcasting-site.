<?php 
$session_post_data = $this->session->userdata('add_partners_data');
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
				<div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Partner</div>
				<a href="<?php echo base_url('partners/manage_partners/'); ?>">
					<div class="panel-title hidden-xs pull-right">
						<span class="glyphicon glyphicon-hand-left"></span>
						Go Back
					</div>
				</a>
				</div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="" action="<?php echo SURL?>partners/manage_partners/add_new_partners_process" method="POST"  enctype="multipart/form-data">
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
					<!--
                    <div class="form-group">
                        <label for="">First Name *</label>
                        <input type="text"  value="" placeholder="First Name" class="form-control" name="first_name" id="first_name" >
                    </div>
					<div class="form-group">
                        <label for="">Last Name *</label>
                        <input type="text"  value="" placeholder="Last name" class="form-control" name="last_name" id="last_name" >
                    </div>
					<div class="form-group">
                        <label for="">Display Name *</label>
                        <input type="text"  value="" placeholder="Display Name" class="form-control" name="display_name"  id="display_name" >
                    </div>
					-->
					<div class="form-group">
                        <label for="">UserName *</label>
                        <input type="text"  value="" placeholder="UserName" class="form-control" name="username" id="username" >
                    </div>
					<div class="form-group">
                        <label for="">Email *</label>
                        <input type="email"  value="" placeholder="Email" class="form-control" name="email_address" id="email_address" >
                    </div>
					<div class="form-group">
                        <label for="">Password *</label>
                        <input type="password"  value="" placeholder="Password" class="form-control" name="password" id="password" required>
                    </div>
					<div class="checkbox">
					  <label><input type="checkbox" name="seo" value="1">SEO</label>
					</div>
                    <div class="form-group">
                        <label for="upload">Upload Image *</label>
						 <input type="file" id="upload" name="upload">
					</div>
					
					<!--
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1" selected >Active</option>
                            <option value="0">InActive</option>
                        </select>
                        </div>
                    </div>  
					-->
                  </div> 
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="add_new_partners" id="add_new_partners" value="Add New Partner" />
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
