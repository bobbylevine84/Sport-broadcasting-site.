<!DOCTYPE html>
<?php// echo "<pre>";print_r($highlight_arr2);exit;?>
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
					<div class="panel-title"> <span class="glyphicon glyphicon-picture"></span>Manage Highlight <input type="submit" form="change_multiple_publishstatus" class="btn btn-success" class="raw_highlight" name="raw_highlight" value="Approve Selected" /></div>
					<?php// if($this->session->userdata('is_sup_admin')==0){ ?>
				 <a href="<?php echo base_url('highlight/manage_highlight/add_new_highlight/'); ?>">
					<div class="panel-title pull-right">
						<span class="glyphicon glyphicon-plus"></span>
						Add New Highlight
					</div>
				</a> 
				<?php// }?>
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
				<form class="cmxform" id="change_multiple_publishstatus" method="POST" action="<?php echo base_url(); ?>highlight/manage_highlight/approve_multiple_highlight_pending">
				<div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="manage_sponsor">
                    <thead>
                      <tr>
						<th>
							<input type="checkbox" id="checkbox1">
						</th>
                        <th>#</th>
                        <th>Event Name</th>
                        <th>Domain</th>
                        <th>Type</th>
                        <th>Compatability</th>
                        <th class="">Status</th>
                        <th class="">View</th>
                        <!--<th class="text-center hidden-xs">Actions</th> -->
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
							for($i=0;$i<$highlight_count2;$i++){
								$string = $highlight_arr2[$i]['url'];	
					?>	
                            <tr>	<!-- Count rows -->
								<td style="vertical-align: middle;">
									<input name="raw_highlight[]" type="checkbox" class="cb-element checkbox1" value="<?php echo $highlight_arr2[$i]['id']; ?>"/>
								</td>
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                                <td class=""><?php echo $highlight_arr2[$i]['home_team'].' <b>VS</b> '.$highlight_arr2[$i]['away_team'];
								?></td>
								<td class=""><?php echo $highlight_arr2[$i]['highlight_domain']; ?>
								<?php if($this->session->userdata('is_sup_admin')==1){ ?>
								<a href="<?php echo base_url('highlight/manage_highlight/block_highlight').'/'.$highlight_arr2[$i]['id'] ; ?>" id="highlight" class="btn btn-danger"><span class="glyphicon glyphicon-thumbs-down"></span></a>
								<?php } else{ }?>
								</td>
                                <!-- Type -->
                                <td class="">
									<div class="select_all3">
										<a href="javascript:;" id="href3_<?php echo $highlight_arr2[$i]['id']; ?>" class="type" >
										<?php echo $highlight_arr2[$i]['type']; ?>
										</a>
										<!-- here -->
										
										<div class="show_type" id="show3_<?php echo $highlight_arr2[$i]['id']; ?>" style="display:none;">
											<select class="form-control" id="my_type_<?php echo $highlight_arr2[$i]['id']; ?>" name="type">
												<option value="Highlights" <?php if($highlight_arr2[$i]['type'] == "Highlights") { ?> selected <?php } ?> >Highlights</option>
												<option value="Full Match Record" <?php if($highlight_arr2[$i]['type'] == "Full Match Record") { ?> selected <?php } ?> >Full Match Record</option>
												<option value="highlights" <?php if($highlight_arr2[$i]['type'] == "highlights") { ?> selected <?php } ?> >highlights</option>
												<option value="Goals" <?php if($highlight_arr2[$i]['type'] == "Goals") { ?> selected <?php } ?> >Goals</option>
												<option value="Other" <?php if($highlight_arr2[$i]['type'] == "Other") { ?> selected <?php } ?> >Other</option>
											</select>
											<input type="button" onClick="update_type(<?php echo $highlight_arr2[$i]['id']; ?>);" value="Update" >
										</div>
									</div>
								</td>
								<td class="">
								<div class="select_all2">
									<a href="javascript:;" id="href2_<?php echo $highlight_arr2[$i]['id']; ?>" class="compatibility" >
									<?php echo $highlight_arr2[$i]['compatibility']; ?>
									</a>
									<div class="show_compatibility" id="show2_<?php echo $highlight_arr2[$i]['id']; ?>" style="display:none;">
									
										<input type="text" id="my_compatibility_<?php echo $highlight_arr2[$i]['id']; ?>" value="<?php echo $highlight_arr2[$i]['compatibility']; ?>" name="compatibility">
										<input type="button" onClick="update_compatibility(<?php echo $highlight_arr2[$i]['id']; ?>);" value="Update" >
										
										
									</div>
								</div>
								</td>
								
                               <?php if($this->session->userdata('is_sup_admin')==0){ ?>
								<td class=""><?php echo ($stream_arr2[$i]['stream_status'] == 'approved') ? '<span class="label btn-success">Approved</span>' : '<span class="label btn-danger">Pending</span>' ?></td>
								
								<?php } else { ?>
                                 <td class="">
									<a href="<?php echo base_url();?>video-highlights/manage_highlight/update_highlight_status/<?php echo $highlight_arr2[$i]['id']; ?>" class="btn <?php
									echo (($highlight_arr2[$i]['status_raw']=="approved")?"btn-success":"btn-danger")?>"><?php
									echo (($highlight_arr2[$i]['status_raw']=="approved")?"Approved":"Pending")?></a>
								
								</td> <?php } ?>        
								<td><a href="<?php echo base_url('highlight/manage_highlight/view_highlight').'/'.$highlight_arr2[$i]['id'] ; ?>" id="highlight" class="btn btn-primary">View Highlight </button>
								<?php if($this->session->userdata('is_sup_admin')==0){ }else{ ?>
								<a href="<?php echo base_url();?>video-highlights/manage_highlight/delete_highlight/<?php echo $highlight_arr2[$i]['id']?>" type="button" class="btn btn-danger btn-gradient" style="" onClick="return confirm('Are you sure you want to delete?')"> <span class="glyphicons glyphicons-remove"></span> </a> <?php } ?>
								</td>
								
                                 <!--
                                <td class=""><?php //echo $games_arr[$i]['date']; ?></td>
								
                                <td class=" text-center">
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
                  </div>
				  </form>
                  <?php 
					}else{
				?>
                <div class="alert alert-danger alert-dismissable">
                	<strong>No Highlights Found</strong> </div>                	
                <?php		
					}//end if($sponsor_count > 0)
				  ?>
					  </div>
					  <div id="menu1" class="tab-pane fade">
							<?php
					if($highlight_count > 0){
                ?><div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="manage_sponsor2">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Event Name</th>
                        <th>Domain</th>
                        <th>Type</th>
                        <th>Compatability</th>
                        <th class="">Status</th>
                        <th class="">View</th>
                        <!--<th class="text-center hidden-xs">Actions</th> -->
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
							for($i=0;$i<$highlight_count;$i++){
								$string = $highlight_arr[$i]['url'];	
					?>	
                            <tr>	<!-- Count rows -->
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                                <td class=""><?php echo $highlight_arr[$i]['home_team'].' <b>VS</b> '.$highlight_arr[$i]['away_team'];
								// if(0 < count(array_intersect(array_map('strtolower', explode(' ', $string)), $blocked)))
								// {
									// echo 'blocked';
								// }else{
									// echo 'Unblocked';
								// }
								
								
								?></td>
								<td class=""><?php echo $highlight_arr[$i]['highlight_domain']; ?>
								<?php if($this->session->userdata('is_sup_admin')==1){ ?>
								<a href="<?php echo base_url('highlight/manage_highlight/block_highlight').'/'.$highlight_arr[$i]['id'] ; ?>" id="highlight" class="btn btn-danger"><span class="glyphicon glyphicon-thumbs-down"></span></a>
								<?php } else{ }?>
								</td>
                                 <!-- Type -->
                                <td class="">
									<div class="select_all3">
										<a href="javascript:;" id="href3_<?php echo $highlight_arr[$i]['id']; ?>" class="type" >
										<?php echo $highlight_arr[$i]['type']; ?>
										</a>
										<!-- here -->
										
										<div class="show_type" id="show3_<?php echo $highlight_arr[$i]['id']; ?>" style="display:none;">
											<select class="form-control" id="my_type_<?php echo $highlight_arr[$i]['id']; ?>" name="type">
												<option value="Highlights" <?php if($highlight_arr[$i]['type'] == "Highlights") { ?> selected <?php } ?> >Highlights</option>
												<option value="Full Match Record" <?php if($highlight_arr[$i]['type'] == "Full Match Record") { ?> selected <?php } ?> >Full Match Record</option>
												<option value="highlights" <?php if($highlight_arr[$i]['type'] == "highlights") { ?> selected <?php } ?> >highlights</option>
												<option value="Goals" <?php if($highlight_arr[$i]['type'] == "Goals") { ?> selected <?php } ?> >Goals</option>
												<option value="Other" <?php if($highlight_arr[$i]['type'] == "Other") { ?> selected <?php } ?> >Other</option>
											</select>
											<input type="button" onClick="update_type(<?php echo $highlight_arr[$i]['id']; ?>);" value="Update" >
										</div>
									</div>
								</td>
								<td class="">
								<div class="select_all2">
									<a href="javascript:;" id="href2_<?php echo $highlight_arr[$i]['id']; ?>" class="compatibility" >
									<?php echo $highlight_arr[$i]['compatibility']; ?>
									</a>
									<div class="show_compatibility" id="show2_<?php echo $highlight_arr[$i]['id']; ?>" style="display:none;">
									
										<input type="text" id="my_compatibility_<?php echo $highlight_arr[$i]['id']; ?>" value="<?php echo $highlight_arr[$i]['compatibility']; ?>" name="compatibility">
										<input type="button" onClick="update_compatibility(<?php echo $highlight_arr[$i]['id']; ?>);" value="Update" >
										
										
									</div>
								</div>
								</td>
								
                               <?php if($this->session->userdata('is_sup_admin')==0){ ?>
								<td class=""><?php echo ($stream_arr2[$i]['stream_status'] == 'approved') ? '<span class="label btn-success">Approved</span>' : '<span class="label btn-danger">Pending</span>' ?></td>
								
								<?php } else { ?>
                                 <td class="">
									<a  href="<?php echo base_url();?>video-highlights/manage_highlight/update_highlight_status/<?php echo $highlight_arr[$i]['id']; ?>" class="btn <?php
									echo (($highlight_arr[$i]['status_raw']=="approved")?"btn-success":"btn-danger")?>"><?php
									echo (($highlight_arr[$i]['status_raw']=="approved")?"Approved":"Pending")?></a>
								
								</td> <?php } ?>        
								<td><a href="<?php echo base_url('highlight/manage_highlight/view_highlight').'/'.$highlight_arr[$i]['id'] ; ?>" id="highlight" class="btn btn-primary">View Highlight </button>
								<?php if($this->session->userdata('is_sup_admin')==0){ }else{ ?>
								<a href="<?php echo base_url();?>video-highlights/manage_highlight/delete_highlight/<?php echo $highlight_arr[$i]['id']?>" type="button" class="btn btn-danger btn-gradient" style="" onClick="return confirm('Are you sure you want to delete?')"> <span class="glyphicons glyphicons-remove"></span> </a> <?php } ?>
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
                	<strong>No Highlights Actived</strong> </div>                	
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
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
<script type="application/javascript">
$('.select_all2').click(function(e){
	  $(this).find('a').hide();
	  $(this).find('.show_compatibility').show();
	  
  }); 
   $('.select_all3').click(function(e){
	  $(this).find('a').hide();
	  $(this).find('.show_type').show();
	  
  });
  
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
<script>
$('#checkbox1').click(function() {
	if (this.checked) {
		$('.checkbox1').each(function() { //loop through each checkbox
			this.checked = true;  //select all checkboxes with class "checkbox1"               
		});
     }else{
		$('.checkbox1').each(function() { //loop through each checkbox
			this.checked = false; //deselect all checkboxes with class "checkbox1"                       
		});
	 }
	//var checkedEvent = [];
	//var selectedoption = "";
	//checkedEvent = $('#active_users input:checkbox:checked').map(function() {
	//return this.value;
//	}).get();
        // if($(this).is(":checked")) {
             // $('tbody input:checkbox').attr('checked','checked');
        // }else{
			// $('tbody input:checkbox').removeAttr('checked');
		// }
     //   $('#textbox1').val($(this).is(':checked'));        
    });
$(document).ready(function(){
    $("#success").fadeOut(2000);
    $("#fail").fadeOut(2000);
});
function update_compatibility(id){
	var comp =	$('#my_compatibility_'+id).val();
	
	$.ajax({
		type : "POST",
		url : '<?php echo base_url();?>highlight/manage_highlight/update_new',
		data : {'compatibility' : comp , 'id' : id},
		success : function(data){
			//console.log(data)
			if(data == 'success'){
				$('#show2_'+id).hide();
				$('#href2_'+id).html(comp);
				$('#href2_'+id).show();
			}
		}
	});
}
function update_type(id){
	var type =	$('#my_type_'+id).val();
	//alert(type);
	$.ajax({
		type : "POST",
		url : '<?php echo base_url();?>highlight/manage_highlight/update_new',
		data : {'type' : type , 'id' : id},
		success : function(data){
			if(data == 'success'){
				$('#show3_'+id).hide();
				$('#href3_'+id).html(type);
				$('#href3_'+id).show();
			}
		}
	});
}
</script>
</body>
</html>
