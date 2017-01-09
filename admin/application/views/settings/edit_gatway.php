<?php
//echo 'i am consumer/edit view file';
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
                    				<span class="glyphicon glyphicon-list"></span>Manage Gatway
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
							
							
                            
                            <?php    
							if($is_gatway_register > 0)
							{?>
                            	<form action="<?php echo base_url('settings/manage_setting/edit_process') ; ?>" method="post">
                               
                                <?php foreach($gatway_data as $d) {?>
                                	
                                    <div class="form-group">
                                    	<label>Gatway Name:</label>
                                        <input class="form-control" type="text" name="gatway_name" value="<?php echo $d['gatway_name'] ;?>" />
                                    </div>
                                    
                                    
                                    
                                    <div class="form-group">
                                    	<label>Account Id:</label>
                                        <input class="form-control" type="text" name="account_id" value="<?php echo $d['getway_account'] ;?>" />
                                    </div>
                                    
                                    <div class="form-group">
                                    	<label>Password:</label>
                                        <input class="form-control" type="text" name="password" value="<?php echo $d['gatway_password'] ;?>" />
                                    </div>
                                    
 
                                    
              <div class="form-group">
                  <label>Status Active:</label>
                  <input type="radio" name="status" value="1" <?php
                  if($d['status']==1){echo 'checked';}
                  ?> />
                  <br/>
                  <label>Status Inactive:</label>
                  <input type="radio" name="status" value="0" <?php
                  if($d['status']==0){echo 'checked';}
                  ?> />
                  
              </div>
                                    
                                    
									<input type="hidden" name="id" value="<?php echo $d['id'] ;?>" />
                                
								<?php }?>
                                	<div class="form-group">
                                    	<input class="btn btn-primary pull-right" type="submit" value="Update" />
                                    </div>
								</form>
							<?php 
                            }
							else
							{
                            ?>
                                <div class="alert alert-danger alert-dismissable">
                                <strong>Register Not Found</strong> </div>                	
							<?php		
                            }//end if($menu_list_count > 0)
                            ?>
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
