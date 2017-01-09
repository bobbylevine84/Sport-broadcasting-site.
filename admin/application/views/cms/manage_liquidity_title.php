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
                                	<span class="glyphicon glyphicon-font"></span>Manage Liquidity Title
                              	</div>
    						</div>
    						<div class="panel-body padding-bottom-none">
                                <?php 
								/*echo '<pre>';
								print_r($title);
								echo $title[0]['id'];
								echo $title[0]['title'];
								echo $title[0]['desc'];
								exit;*/
								?>
                                <form action="<?php echo base_url('cms/manage_liquidity/update_title'); ?>" method="post" >
                                <table border="0" class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td width="18%"><label>Title For Liquidity Images:</label></td>
                                            <td>
                                                <textarea class="ckeditor form-control editor1" rows="14"  name="title_content">
                	<?php echo $title[0]['title']; ?>
            	</textarea>
                
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="3">
                                                <div class="col-md-offset-4 col-md-4">
                                                    <input name="id" type="hidden" value="<?php echo $title[0]['id']; ?>" />
                                                    <input class="form-control btn btn-primary" name="submit_sec" type="submit" value="Update"/>
                                                </div>
                                               <div class="col-md-4" >&nbsp;</div>
                                            </td>
                                        </tr>    
                                    </tbody>
                                </table>
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
