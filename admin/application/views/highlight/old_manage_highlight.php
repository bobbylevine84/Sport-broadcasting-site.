<!DOCTYPE html>
<?php// echo "<pre>";print_r($news_count);exit;?>
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
                  <div class="panel-title hidden-xs"> <span class="glyphicon glyphicon-picture"></span>Manage Highlight</div>
				   <!--<a href="<?php //echo base_url('news/manage_news/add_new_news/'); ?>">
                                	<div class="panel-title hidden-xs pull-right">
                                    	<span class="glyphicon glyphicon-plus"></span>
                                        Add New highlight
                                   	</div>
                             	</a>-->
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
					?>
					<ul class="nav nav-tabs">
					  <li class="active"><a data-toggle="tab" href="#home">Pending</a></li>
					  <li><a data-toggle="tab" href="#menu1">Approved</a></li>
					</ul>

					<div class="tab-content">
					  <div id="home" class="tab-pane fade in active">
						<?php
					if($highlight_count2 > 0){
                ?>
                  <table class="table table-striped table-bordered table-hover" id="manage_sponsor">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Event Name</th>
                        <th>Type</th>
                        <th>Compatability</th>
                        <th class="hidden-xs hidden-sm">Status</th>
                        <th class="hidden-xs hidden-sm">View</th>
                        <!--<th class="text-center hidden-xs">Actions</th> -->
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
							for($i=0;$i<$highlight_count2;$i++){
								
					?>	
                            <tr>	<!-- Count rows -->
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                                <td class="hidden-xs hidden-sm"><?php echo $highlight_arr2[$i]['home_team'].' <b>VS</b> '.$highlight_arr2[$i]['away_team']; ?></td>
                                <td class="hidden-xs hidden-sm"><?php echo $highlight_arr2[$i]['type']; ?></td>
                                <td class="hidden-xs hidden-sm"><?php echo $highlight_arr2[$i]['compatibility']; ?></td>
                               
                                 <td class="hidden-xs hidden-sm">
									<a  href="<?php echo base_url();?>video-highlights/manage_highlight/update_highlight_status/<?php echo $highlight_arr2[$i]['id']; ?>" class="btn <?php
									echo (($highlight_arr2[$i]['status']=="approved")?"btn-success":"btn-danger")?>"><?php
									echo (($highlight_arr2[$i]['status']=="approved")?"Approved":"Pending")?></a>
								
									</td>         
								

								<td class="hidden-xs hidden-sm">
									<a style="width:100%;" href="#" class="btn btn-success" data-toggle="modal"  onclick="iframe(<?php echo $highlight_arr2[$i]['id']; ?>);" data-target="#meModal_video">View Video</a>
								<!-- Modal content--> 
									
									
								</td>
								
                                 <!--
                                <td class="hidden-xs hidden-sm"><?php //echo $games_arr[$i]['date']; ?></td>
								
                                <td class="hidden-xs text-center">
                                	<div class="btn-group">
									
											<a href="<?php //echo base_url();?>news/manage_news/edit_news/<?php// echo $news_arr[$i]['id']?>" type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </a>                                    
                                   
											<a href="<?php //echo base_url();?>news/manage_news/delete_news/<?php //echo $news_arr[$i]['id']?>" type="button" class="btn btn-danger btn-gradient" onClick="return confirm('Are you sure you want to delete?')"> <span class="glyphicons glyphicons-remove"></span> </a>                                    
                                   
                                  </div>
                                 </td>-->
                            </tr>
                    <?php			
							}
					?>
                    </tbody>
                  </table>
                  
                  <?php 
					}else{
				?>
                <div class="alert alert-danger alert-dismissable">
                	<strong>No Highlights Active</strong> </div>                	
                <?php		
					}//end if($sponsor_count > 0)
				  ?>
					  </div>
					  <div id="menu1" class="tab-pane fade">
							<?php
					if($highlight_count > 0){
                ?>
                  <table class="table table-striped table-bordered table-hover" id="manage_sponsor">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Event Name</th>
                        <th>Type</th>
                        <th>Mobile Compatability</th>
                        <th class="hidden-xs hidden-sm">Status</th>
                        <th class="hidden-xs hidden-sm">View</th>
                        <!--<th class="text-center hidden-xs">Actions</th> -->
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
							for($i=0;$i<$highlight_count;$i++){
								
					?>	
                            <tr>	<!-- Count rows -->
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                                <td class="hidden-xs hidden-sm"><?php echo $highlight_arr[$i]['home_team'].' <b>VS</b> '.$highlight_arr[$i]['away_team']; ?></td>
                                <td class="hidden-xs hidden-sm"><?php echo $highlight_arr[$i]['type']; ?></td>
                                <td class="hidden-xs hidden-sm"><?php echo $highlight_arr[$i]['compatibility']; ?></td>
                               
                                <td class="hidden-xs hidden-sm"><?php echo ($highlight_arr[$i]['status'] == 'approved') ? '<span class="label btn-success">Approved</span>' : '<span class="label btn-danger">Pending</span>' ?></td>
								

								<td class="hidden-xs hidden-sm">
									<a style="width:100%;" href="#" class="btn btn-success" data-toggle="modal"  onclick="iframe(<?php echo $highlight_arr[$i]['id']; ?>);" data-target="#meModal_video">View Video</a>
								<!-- Modal content--> 
									
									
								</td>
								
                                 <!--
                                <td class="hidden-xs hidden-sm"><?php //echo $games_arr[$i]['date']; ?></td>
								
                                <td class="hidden-xs text-center">
                                	<div class="btn-group">
									
											<a href="<?php //echo base_url();?>news/manage_news/edit_news/<?php// echo $news_arr[$i]['id']?>" type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </a>                                    
                                   
											<a href="<?php //echo base_url();?>news/manage_news/delete_news/<?php //echo $news_arr[$i]['id']?>" type="button" class="btn btn-danger btn-gradient" onClick="return confirm('Are you sure you want to delete?')"> <span class="glyphicons glyphicons-remove"></span> </a>                                    
                                   
                                  </div>
                                 </td>-->
                            </tr>
                    <?php			
							}
					?>
                    </tbody>
                  </table>
                  
                  <?php 
					}else{
				?>
                <div class="alert alert-danger alert-dismissable">
                	<strong>No Highlights Active</strong> </div>                	
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
      <div class="clearfix"></div>
      <div class="row" style="min-height:250px;">&nbsp;</div>
    </div>
  </section>
  <!-- End: Content -->
	<div id="meModal_video" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Video </h4>
				</div>
				<div class="modal-body" id="video1">
				  
					
					
				</div>
				<div class="modal-footer">
					<!-- onclick="document.getElementById('<?php //echo $highlight_arr[$i]['id'];?>').innerHTML='';"-->
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="document.getElementById('video1').innerHTML='';"  >Close</button>
				</div>
			</div>
		</div>
	</div>  
  
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
</body>
</html>
