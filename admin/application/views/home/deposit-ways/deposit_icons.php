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
                  	<span class="glyphicon glyphicon-picture"></span>
                    	Manage Deposit Method Icons
                	</div>
                    <a href="<?php echo base_url('home/manage-section/add-new-deposit-icon'); ?>">
                                	<div class="panel-title hidden-xs pull-right">
                                    	<span class="glyphicon glyphicon-plus"></span>
                                        Add New Deposit Method Icon
                                   	</div>
                             	</a>
                </div>
                <div class="panel-body padding-bottom-none">

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
					
					if($deposit_icons_count > 0){
                ?>
                
<table class="table table-striped table-bordered table-hover" id="manage_deposit_icons">
    <thead>
    <tr>
        <th>#</th>
        <th>Image Thumbnail</th>
        <th class="hidden-xs">Link</th>
        <th class="hidden-xs hidden-sm">Status</th>
        <th class="text-center hidden-xs">Actions</th>
    </tr>
    </thead>
    <tbody>
		<?php 
        for($i=0;$i<$deposit_icons_count;$i++){
        
        ?>
        <tr>
        	<td><span class="xedit"><?php echo ($i+1) ?></span></td>
        	<td class="hidden-xs">
            	<span class="xedit">
        			<img width="50" height="50" src="<?php echo IMG_deposit_icons.stripslashes($deposit_icons_arr[$i]['deposit_icon'])//echo IMG.stripslashes($deposit_icons_arr[$i]['slider_image']) ?>">
            	</span>
        	</td>
       		<td class="hidden-xs hidden-sm">
				<?php echo (stripslashes($deposit_icons_arr[$i]['deposit_link']) == '') ? '-' : stripslashes($deposit_icons_arr[$i]['deposit_link']); ?>
          	</td>
            <td class="hidden-xs hidden-sm">
				<?php if($deposit_icons_arr[$i]['status']==1){?>
                                        	<a style="text-decoration:none;" href="<?php echo base_url('home/manage_section/active').'/'.$deposit_icons_arr[$i]['id'] ;?>">
                                                <span class="label btn-success">
                                                    <?php echo 'Active'; ;?>
                                                </span>
                                            </a>
											<?php }else{?>
                                            <a style="text-decoration:none;" href="<?php echo base_url('home/manage_section/inactive').'/'.$deposit_icons_arr[$i]['id'] ;?>">
                                            	<span class="label btn-danger">
													<?php echo 'InActive'; ;?>
                                             	</span>
                                          	</a>
											<?php }?>
         	</td>
         
        	<!--<td class="hidden-xs hidden-sm">
				<?php echo ($deposit_icons_arr[$i]['status'] == 1) ? '<span class="label btn-success">Active</span>' : '<span class="label btn-danger">InActive</span>' ?>
         	</td>-->
        
        
        	<td class="hidden-xs text-center">
        		<div class="btn-group">
        			<?php if($ALLOW_pages_edit == 1){ ?>
        			<a href="<?php echo SURL?>home/manage-section/edit-deposit-icon/<?php echo $deposit_icons_arr[$i]['id']?>" type="button" class="btn btn-info btn-gradient"> 
                    	<span class="glyphicons glyphicons-edit"></span> 
                    </a>                                    
        			<?php }//end if 
        				if($ALLOW_pages_delete == 1){ ?>
        			<a href="<?php echo SURL?>home/manage-section/delete-deposit-icon/<?php echo $deposit_icons_arr[$i]['id']?>" type="button" class="btn btn-danger btn-gradient" onClick="return confirm('Are you sure you want to delete?')"> 
                    	<span class="glyphicons glyphicons-remove"></span> 
                   	</a>                                    
        			<?php }//end if 
					?>
        		</div>
        	</td>
    	</tr>
    <?php			
    }//end for
    ?>
    </tbody>
</table>
                  
                  <?php 
					}else{
				?>
                <div class="alert alert-danger alert-dismissable">
                	<strong>No deposit Icons Found</strong> </div>                	
                <?php		
					}//end if($deposit_icons_count > 0)
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

<script type="application/javascript">

	$('#manage_deposit_icons').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-4,-5,-6 ] }],
		"aaSorting": [],
		"oLanguage": { "oPaginate": {"sPrevious": "", "sNext": ""} },
		"iDisplayLength": 25,
		"bPaginate": true,
		"bLengthChange": true,
		"bFilter": true,
		"aLengthMenu": [[25, 50, 75,100], [25, 50, 75,100]],
		"sDom": 'T<"panel-menu dt-panelmenu"lfr><"clearfix">tip',
		"oTableTools": {
			"sSwfPath": "<?php echo VENDOR ?>plugins/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
		}
		
	});	
</script>
</body>
</html>
