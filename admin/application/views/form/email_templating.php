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
Start: Header -->
<header class="navbar navbar-fixed-top"> <?php echo $INC_top_header; ?> </header>
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
                    				<span class="glyphicon glyphicon-list"></span>Manage Template
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

							if($template_list_count > 0)
							{?>

								<table class="table table-striped table-bordered table-hover" id="manage_all_templates">
                         
                                    <thead>
                                      <tr>
                                        <th>Subject</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
									
									foreach($templates as $t)
									{?>
                                    <tr>
                                    <td><?php echo $t->subject; ?></td>
                                    <td><?php echo $t->email_type; ?></td>
                                    <td><a type="button" class="btn btn-info btn-gradient" href="<?php echo base_url('templates/email/edit_template').'/'.$t->id;?>"><span class="glyphicons glyphicons-edit"></span></a>
                    				</td>
      							</tr>	
									<?php }
									
									?>
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
        <div class="clearfix"></div>
    	<div class="row" style="min-height:250px;">&nbsp;</div>
    </div>
  </section>
</div><!-- End: Content --> 
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>


</body>
<script type="application/javascript">

//$(document).ready(function(){
	//var type = $('select[name=user_type]').val();
/*+function ($) { "use strict";
$(function(){*/
	
	  // datatable
	  /*$('#manage_all_templates').each(function() { 
		  
		
		var oTable = $(this).dataTable( { alert('hello');
		
		  "bProcessing": true,
		  "sAjaxSource": base_url+"templates/email/process_template_grid/",
		  "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
		  "sPaginationType": "full_numbers",
		  "bDestroy":true,
		  "aoColumns": [
			
			{"mData":"subject"},
			{"mData": "message" },
			{"mData": "type" },*/
			/*{"mData":"status"},
			{"mData":function(oObj)
				{
					if(oObj.banned == 0)
						{ 
							return '<p>NO</p>';
						}
						else
						{
							return '<p>Yes</p>';
						}    
				}
			},*/
			/*{   "mData": "id",
				"bSearchable": false,
				"bSortable": false,
				"fnRender": function (oObj) {*/
					//return '<a href=\"'+base_url+'restaurant/home/edit/' + oObj.aData.id2 + '\">Edit</a>&nbsp;&nbsp;&nbsp;<a onclick=\"return confirm(\'Are you sure you want to delete this restaurant?\');" href=\"'+base_url+'restaurant/home/delete/' + oObj.aData.id2 + '\">Delete</a>';
				/*	return '<button class="btn btn-success dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button><ul class="dropdown-menu"><li><a href=\"'+base_url+'settings/manage/edit_consumers/' + oObj.aData.id + '\">Edit</a></li><li><a onclick=\"return confirm(\'Are you sure you want to delete this restaurant?\');" href=\"'+base_url+'settings/manage/delete_consumers/' + oObj.aData.id + '\">Delete</a></li></ul>';				
				}
				},
			
			]
		} );
	  });
  });
 
}(window.jQuery);

});
*/



/*
	$('#manage_all_templates').dataTable({
		
		"bProcessing": true,
		"bServerSide": false,
		"sServerMethod": "POST",
		"sAjaxSource": "<?php //echo base_url()?>templates/email/process_template_grid",
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-2] }],
		"aaSorting": false//[],
		/*"order": [[ 3, "desc" ]]*/
		/*"iDisplayLength": 10,
		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": false,
		"aLengthMenu": [[25, 50, 75,100], [25, 50, 75,100]],
		"aoColumns": [
		{ "bSearchable": true, "sWidth": "25%"  },
		{ "bSearchable": true, "sWidth": "50%"  },
		{ "bSearchable": false, "sWidth": "25%"}
		],
		"oLanguage": {
           "sProcessing": "Searching Please Wait..."
         }
		
	}).fnSetFilteringDelay(700);*/	
</script>
</html>