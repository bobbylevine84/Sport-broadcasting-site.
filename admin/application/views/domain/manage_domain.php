<!DOCTYPE html>
<?php //echo "<pre>";print_r($domain_arr);exit;?>
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
					<div class="panel-title"> <span class="glyphicon glyphicon-picture"></span>Manage Domain</div>
				<!-- <a href="<?php echo base_url('domain/manage_domain/add_new_domain/'); ?>">
					<div class="panel-title pull-right">
						<span class="glyphicon glyphicon-plus"></span>
						Add New Domain
					</div>
				</a> -->
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
                        <div class="alert alert-success alert-dismissable" id="success"><?php echo $this->session->flashdata('ok_message'); ?></div>
                <?php 
                    }//if($this->session->flashdata('ok_message'))

					if($domain_count > 0){
                ?><div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="manage_sponsor">
                    <thead>
                      <tr>
                        <th class="">#</th>
                        <th class="">Domain Name</th>
                        <th class="text-center">UnBlock</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
							for($i=0;$i<$domain_count;$i++){ ?>

                            <tr>	<!-- Count rows -->
                                <td class=""><span class="xedit"><?php echo ($i+1) ?></span></td>
                                <td class=""><?php echo $domain_arr[$i]['domain_name'];
								?></td>
								<td class="">
								<a href="<?php echo base_url();?>domain/manage_domain/delete_domain/<?php echo $domain_arr[$i]['id']?>" type="button" class="btn btn-default" style="" onClick="return confirm('Are you sure you want to Unblock?')"> <span class="glyphicon glyphicon-thumbs-up"></span> </a>
								</td>
                            </tr>
                    <?php			
							}
					?>
                    </tbody>
                  </table>
                  </div>
                  <?php 
					}else{
				?>
                <div class="alert alert-danger alert-dismissable">
                	<strong>No domain Found</strong> </div>                	
                <?php		
					}//end if($sponsor_count > 0)
				  ?>
					  </div>
					  </div>
					</div>
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
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1] }],
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
<script>
function iframe(iframe){ 
  $.ajax({
				type: "POST",
				url: "<?php echo base_url();?>highlight/manage_highlight/get_highlight",  
				data: {
						iframe_id: iframe
				},
				success: function(data)
				{
				 // alert(data);
				  document.getElementById("video1").innerHTML= data;
				}
			});

 }


</script>
<script>
$(document).ready(function(){
    $("#success").fadeOut(2000);
    $("#fail").fadeOut(2000);
});
</script>
</body>
</html>
