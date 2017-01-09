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
			<div class=" col-md-12">
				<?php 
             if (validation_errors()) {
                echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                        <button type='button' class='close' data-dismiss='alert'>
                            <span aria-hidden='true'>&times;</span>
                            <span class='sr-only'>Close</span>
                        </button>" .validation_errors(). "</div>"; 
              }
			  if ( isset($success) && $success != '' ) { 
					echo "<div class='alert alert-success alert-dismissible' role='alert'>
							<button type='button' class='close' data-dismiss='alert'>
								<span aria-hidden='true'>&times;</span>
								<span class='sr-only'>Close</span>
							</button>". $success ."</div>";
			  }
              ?>
                 
           
               <div class="panel panel-visible">
                      <div class="panel-heading">
                    
                        <div class="panel-title hidden-xs"> 
                            <span class="glyphicon glyphicon-list"></span>Gateway Settings
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
							
							
				if($gayway_list_count > 0)
							{?>

								<table class="table table-striped table-bordered table-hover" id="manage_all_menus">
                                    <thead>
                                        <tr>
                        <th>Gatway</th>
                        <th>Account</th>
                        
                        <th>Status</th>
                        <th>Action</th>
                                            
                                    	</tr>
                                    </thead>
                                    <!--
                                    [user_id] => 1
                                    [user_firstname] => test
                                    [user_email] => test
                                    [user_country] => test
                                    [user_status] => 0
                                    -->
                                    <tbody>
                                    <?php 
									/*echo '<pre>';
							print_r($all_consumer);
							exit;*/

									
									foreach($all_gatway as $c) {?>
                                    <tr>
                                    	<td><?php echo $c['gatway_name'];?></td>
                                        <td><?php echo $c['gatway_account'];?></td>
                                        <td><?php if($c['status']==1){?>
                                        	<a href="<?php echo base_url('settings/manage_setting/status_inactive').'/'.$c['id'] ;?>">
                                                <span class="label btn-success">
                                                    <?php echo 'Active'; ;?>
                                                </span>
                                            </a>
											<?php }else{?>
                                            <a href="<?php echo base_url('settings/manage_setting/status_active').'/'.$c['id'] ;?>">
                                            	<span class="label btn-danger">
													<?php echo 'InActive'; ;?>
                                             	</span>
                                          	</a>
											<?php }?>
                                        </td>
                                        <td>
                                        	<div class="btn-group">
                                            <a type="button" class="btn btn-info btn-gradient" href="<?php echo base_url('settings/manage_setting/edit').'/'.$c['id'] ;?>"><span class="glyphicons glyphicons-edit"></span></a>
                                      		
                                            </div>
                                        </td>
                                        
                                    </tr>
                                    <?php }?>
                                   
                                    </tbody>
                            	</table>
							<?php 
                            }
							else
							{
                            ?>
                                <div class="alert alert-danger alert-dismissable">
                                <strong>No Menus Found</strong> </div>                	
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
