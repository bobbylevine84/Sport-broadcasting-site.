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
                    				<span class="glyphicon glyphicon-list"></span>Header Menus
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

							if(count($Header_menu_list)>0)
							{?>
                            	<table class="table table-striped table-bordered table-hover" id="manage_all_menus">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Menu link</th>
                                            <th>Action</th>
                                    	</tr>
                                    </thead>
                                    <tbody>
                                    	<?php 
											$serial_no = 1 ;
											foreach($Header_menu_list as $h){?>
                                    	<tr>
                                        	<td><?php echo $serial_no; ?></td>
                                        	<td><label><?php echo $h['name']; ?></label></td>
                                            <td><?php echo $h['link']; ?></td>
                                            <td align="center">
                                            	<a href="<?php echo base_url('menu/manage-menu/edit_header_menu')."/".$h['id']; ?>" class="btn btn-info btn-gradient">
                                                	<span class="glyphicons glyphicons-edit"></span>
                                              	</a>
                                         	</td>
                                        </tr>
                                        <?php
											$serial_no++;
										 }?>
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
