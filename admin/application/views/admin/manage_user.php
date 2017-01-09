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
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> Manage Users </div>
            </div>
            <div class="panel-body">
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

              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Display Name</th>
                      <th>Username</th>
                      <th>Admin Role</th>
                      <th>Last SignIn Date</th>
                      <th>Created Date</th>
                      <th>Status</th>
                      <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php 
						if($admin_user_list_count > 0){
							for($i=0;$i<$admin_user_list_count;$i++){
					?>
                            <tr>
                                <td><?php echo ($i+1);?></td>
                                <td><?php echo $admin_user_list[$i]['display_name'];?></td>
                                <td><?php echo $admin_user_list[$i]['username'];?></td>
                                <td><?php echo $admin_user_list[$i]['role_title'];?></td>
                                <td><?php echo date('F j, Y', strtotime($admin_user_list[$i]['last_signin_date']) );?></td>
                                <td><?php echo date('F j, Y', strtotime($admin_user_list[$i]['created_date']) );?></td>
                                <td><?php echo ($admin_user_list[$i]['status'] == 1) ? '<span class="label btn-success">Active</span>' : '<span class="label btn-danger">InActive</span>' ?></td>
                                <td>
                                <div class="btn-group">
								<?php 
                                    if($ALLOW_user_edit == 1){ 
								?>
										<a href="<?php echo base_url()?>admin/manage-user/edit-user/<?php echo $admin_user_list[$i]['id'] ?>" type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </a>                                
                                <?php	
									}//end if
									
                                    if($ALLOW_user_delete == 1){ 
								?>
                                		<a href="<?php echo base_url()?>admin/manage-user/delete-user/<?php echo $admin_user_list[$i]['id'] ?>" onClick="return confirm('Are you sure you want to delete?')" type="button" class="btn btn-danger btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </a>
                                <?php	
									}//end if

                                 ?>
                                </div>
                                </td>
                            </tr>
                    <?php		
							
						}//enf for
						}else{
					?>	
                        <tr>
	                        <th colspan="8">
                                <div class="alert alert-danger alert-dismissable">
                                No User(s) Found </div>
                            </th>
                        </tr>
                    <?php		
						}//end if($admin_user_list_count > 0)
					?>
                    
                  </tbody>
                </table>
                <div align="right">
                	<?php //echo "Showing $start - $end of $total total results"; ?>
                	<?php echo $page_links?>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
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
