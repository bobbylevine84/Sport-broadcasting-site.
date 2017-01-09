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
                            <span class="glyphicon glyphicon-list"></span>Manage Settings
                        </div>
                    </div>
                    <div >
                    <form enctype="multipart/form-data" action="<?php echo base_url('settings/manage_setting/edit_set'); ?>" method="post">
			
             <table class="table table-striped" border="0" cellspacing="1" cellpadding="5">
				<?php 
				
				$limit = 0;
				
				foreach($adminsetting as $key => $value){ ?>
              <tr>
              	
				<td style="width: 300px;">
                	<label><?php echo ucfirst($value['desc']) ?></label>
              	</td>
                <td>
                	<?php
                    	if($limit == 1)
						{
						?>
                    <textarea class="ckeditor form-control editor1" rows="14" name="<?php echo $key; ?>" ><?php echo $value['value']?></textarea>
                    
                    
                    	<?php }else{?>
                    <input type="text" class="form-control" name="<?php echo $key; ?>" value="<?php echo $value['value']?>" >
					    
						<?php $limit++; }?>
              	</td>
                 
              </tr>
                <?php } ?>
                
              <tr>
                <td colspan="2" align="right">
                	<input type="submit" name="submit" value="Update Settings" class="btn btn-primary">
                </td>
              </tr>
              
			</table>
            </form>
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
