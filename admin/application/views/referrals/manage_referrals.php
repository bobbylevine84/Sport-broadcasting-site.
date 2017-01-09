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
                  <div class="panel-title hidden-xs"> <span class="glyphicon glyphicon-briefcase"></span>
                  Referrals
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
							
							
							if($banners_count > 0)
							{?>

								<table class="table table-striped table-bordered table-hover" id="">
                                    <thead>
										<tr>
											<th>S. No.</th>
											<th>Username</th>
											<th>Banner</th>
											<th>No. of referrals</th>                           
										</tr>
											</thead>
                                   
                                    <tbody>
                                    <?php 
									

									foreach($all_banners as $b) {?>
                                    <tr>
                                    	<td>
											<?php echo $b['banner_name'];?>
										</td>
										<td><img src="<?php echo site_url('../uploads/'.$b['banner_name']); ?>" width="300" height="100" /></td>
                                        <td><?php  if($b['status']==1){?>
												<a href="<?php echo base_url('banner/manage_banner/inactive/'.$b['id']);?>" class="label btn-success">Active</a>
											<?php }else{ ?>
												<a href="<?php echo base_url('banner/manage_banner/active/'.$b['id']);?>" class="label btn-danger">Inactive</a>
											<?php } ?>
										</td>
                                        <td><?php echo $b['updated'];?></td>
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
                                <strong>No Banners Found</strong> </div>                	
							<?php		
                            }//end if($banners count > 0)
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
