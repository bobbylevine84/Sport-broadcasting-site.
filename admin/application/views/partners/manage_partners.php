<!DOCTYPE html>

<?php 
//echo "<pre>";print_r($partners_arr);exit;?>
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
                  <div class="panel-title"> <span class="glyphicon glyphicon-picture"></span>Manage Partners</div>
				   <a href="<?php echo base_url('partners/manage_partners/add_new_partners/'); ?>">
                                	<div class="panel-title pull-right">
                                    	<span class="glyphicon glyphicon-plus"></span>
                                        Add New Partners
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
					
					if($partners_count > 0){
                ?><div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="manage_sponsor">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th class="">Display Name</th>
                        <th class="">UserName</th>
                        <th class="">Email Address</th>
                        <th class="">Status</th>
                       <!-- <th class="hidden-xs hidden-sm">Date</th> -->
                        <th class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
							for($i=0;$i<$partners_count;$i++){
								
					?>	<?php if($partners_arr[$i]['is_sup_admin']==1) { } else { ?>
                            <tr>	<!-- Count rows -->
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                                <td class=""><span class="xedit">
									<img src="<?php echo base_url();?>assets/user_files/<?php echo $partners_arr[$i]['id']?>/<?php echo stripslashes($partners_arr[$i]['profile_image']) ?>"style="height:70px;width:70px;"></span>
                                </td>
                                <td class=""><?php echo $partners_arr[$i]['first_name'].' '.$partners_arr[$i]['last_name'];; ?></td>
                                <td class=""><?php echo $partners_arr[$i]['display_name']; ?></td>
                                <td class=""><?php echo $partners_arr[$i]['username']; ?></td>
                                <td class=""><?php echo $partners_arr[$i]['email_address']; ?></td>
                                <td class=""><?php echo ($partners_arr[$i]['status'] == '1') ? '<span class="label btn-success">Active</span>' : '<span class="label btn-danger">InActive</span>' ?></td>
                                 <!--
                                <td class="hidden-xs hidden-sm"><?php //echo $games_arr[$i]['date']; ?></td>
								-->
                                <td class="hidden-xs text-center">
                                	<div class="btn-group">
									
											<a href="<?php echo base_url();?>partners/manage_partners/edit_partners/<?php echo $partners_arr[$i]['id']?>" type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </a>                                    
                                   
											<a href="<?php echo base_url();?>partners/manage_partners/delete_partners/<?php echo $partners_arr[$i]['id']?>" type="button" class="btn btn-danger btn-gradient" onClick="return confirm('Are you sure you want to delete?')"> <span class="glyphicons glyphicons-remove"></span> </a>                                    
                                   
                                  </div>
                                 </td>
                            </tr>
                    <?php			
							}}
					?>
                    </tbody>
                  </table>
                  </div>
                  <?php 
					}else{
				?>
                <div class="alert alert-danger alert-dismissable">
                	<strong>No partners Found</strong> </div>                	
                <?php		
					}//end if($sponsor_count > 0)
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
	$('#manage_sponsor').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-3, -4,-6 ] }],
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
