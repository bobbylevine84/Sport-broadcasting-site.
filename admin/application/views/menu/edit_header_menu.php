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
                    				<span class="glyphicon glyphicon-list"></span>
                                    Edit Menu <?php echo $edit_header_menu[0][id]; ?>
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
                           
                           
                            <form action="<?php echo base_url('menu/manage_menu/process_edit_header_menu');?>" method="post">
                            <table class="table table-striped table-bordered table-hover" id="manage_all_menus">
                            	<tbody>
                                	<tr>
                                    	<td colspan="3">
                                        	<?php echo validation_errors(); ?>
                                        </td>
                                    </tr>
                            		<tr align="center">
                                    	<td width="250px"><label>Menu Name :</label></td>
                                        <td>
											<input type="text" name="menu_name" value="<?php echo $edit_header_menu[0][name]; ?>" />
                                      	</td>
                                    </tr>
                                    <tr align="center">
                                    	<td width="150px"><label>Menu Link :</label></td>
                                        <td>
											<input type="text" name="menu_link" value="<?php echo $edit_header_menu[0][link]; ?>" />
                                      	</td>
                                    </tr>
									
									<tr align="center">
                                    	<td width="250px"><label>Set Position :</label></td>
                                        <td>
											<input type="checkbox" name="top" <?php if(!empty($top)) { ?> checked="checked" <?php } ?> value="top"  /> <label>Header Menu</label>
											<input type="checkbox" name="side" <?php if(!empty($side)) { ?> checked="checked" <?php } ?> value="side" /> <label>Side Menu</label>
                                      	</td>
                                    </tr>
									<tr>
                                    	<td colspan="2" align="right">
                                        	<input type="hidden" name="mode" value="<?php echo $edit_header_menu[0][id]; ?>">
                                        	<input class="submit btn btn-blue" type="submit" value="Update" />
                                        </td>
                                    </tr>
                          		</tbody>
                          	</table>
                            </form>
                            
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
