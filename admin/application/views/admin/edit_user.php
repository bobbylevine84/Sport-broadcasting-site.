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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit Admin User</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_user_frm" method="POST" action="<?php echo SURL?>admin/manage-user/edit-user-process" enctype="multipart/form-data">
                <div class="tab-content border-none padding-none">
                  <div id="user_prof_contents" class="tab-pane active">
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
                        <label for="first_name">First Name*</label>
                        <input id="first_name" name="first_name" type="text" class="form-control" placeholder="Enter First Name" value="<?php echo stripslashes($admin_user_data['first_name']) ?>" required/>
                      </div>
                      <div class="form-group">
                        <label for="last_name">Last Name*</label>
                        <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Enter Last Name" value="<?php echo stripslashes($admin_user_data['last_name']) ?>" required/>
                      </div>
                      <div class="form-group">
                        <label for="display_name">Display Name*</label>
                        <input id="display_name" name="display_name" type="text" class="form-control" placeholder="Enter user Display Name" value="<?php echo stripslashes($admin_user_data['display_name']) ?>" required/>
                      </div>

                      <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" name="username" type="text" class="form-control" placeholder="Enter Username" value="<?php echo stripslashes($admin_user_data['username']) ?>" required />
	                      <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> Username will be used to login into the CMS Panel.</span>
                      </div>
                      
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Enter Password" value="" />
                      </div>

                      <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input id="confirm_password" name="confirm_password" type="password" class="form-control" placeholder="Confirm Password" value="" />
                      </div>
                      
                      <div class="form-group">
                        <label for="email_address">Email Address</label>
                        <input id="email_address" name="email_address" type="text" class="form-control" placeholder="Enter Email Address" value="<?php echo stripslashes($admin_user_data['email_address']) ?>"/>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-5">
                        	<div class="form-group">
                      <label for="upload">Upload Profile Image</label>
                      <input type="file" id="prof_image" name="prof_image">
                        <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
	                        - Allowed Extensions: jpg, jpeg, gif, tiff, png <br>
                        </span>
                        <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
							- Max Upload Size: 2MB
                        </span>
                    </div>
                        </div>
                        <?php 
							if($admin_user_data['profile_image'] !=''){
						?>
                        <div class="col-md-5">
                            <img src="<?php echo USER_FOLDER.'/'.$admin_user_data['id'].'/'.stripslashes($admin_user_data['profile_image'])?>">
                        </div>
                        <?php }//end if?>
                      </div>
                                          
                      <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Administrative Role*</label>
                            <select class="form-control" id="admin_role_id" name="admin_role_id" required>
								<option value="">Select Admin Role</option>

                            	<?php 
									for($i=0;$i<$admin_roles_count;$i++){
								?>
                            			<option value="<?php echo $admin_roles_arr[$i]['id']?>" <?php echo ($admin_user_data['admin_role_id'] == $admin_roles_arr[$i]['id']) ? 'selected' : ''?> ><?php echo $admin_roles_arr[$i]['role_title']?></option>    
                                <?php		
									}//end for
								?>
                            
                        </select>
                        </div>
                    </div>
                      
                      <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1" <?php echo ($admin_user_data['status'] == 1) ? 'selected' : ''?> >Active</option>
                            <option value="0" <?php echo ($admin_user_data['status'] == 0) ? 'selected' : ''?>>InActive</option>
                        </select>
                        </div>
                    </div>
                                          
                  </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="upd_user_sbt" id="upd_user_sbt" value="Update User" />
                        <input type="hidden" name="admin_id" id="admin_id" value="<?php echo $admin_user_data['id'] ?>" readonly />
                    </div>
                </div>
                
              </form>
            </div>            
          </div>
        </div>
      </div>
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

    <script type="text/javascript">
	
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
        $("#add_new_user_frm").validate({
            rules: {
				first_name : 'required',
				last_name : 'required',
                display_name: "required",
				username: {
					required: true,
					minlength: 5,
					maxlength: 20
				},
				password: {
					required: false,
					minlength: 6
				},
				confirm_password: {
					required: false,
					equalTo: "#password"
				},
				email_address: {
					required: false,
					email: true
				},
				admin_role_id: {
					required: true,
				},
				prof_image: {
					required: false,
					extension: "jpg|jpeg|gif|tiff|png"
				}				
				
            },
            messages: {
                first_name: "This field is required.",
				last_name : "This field is required.",
				display_name: "This field is required.",
				prof_image : "Please select valid image for your profile (Use: jpg, jpeg, gif, tiff, png)",
				username: {
					required: "This field is required.",
					minlength: "Username must consist of at least 5 characters",
					maxlength: "Username cannot me more than 20 characters"
				},
				password: {
					minlength: "Password must be at least 6 characters long"
				},
				confirm_password: {
					equalTo: "New Password must match with confirm password"
				},				
				email_address: "Enter your valid email address",
				admin_role_id : "Please select Administrative Role"
            }
        });
    
    });
    </script>

</body>
</html>
