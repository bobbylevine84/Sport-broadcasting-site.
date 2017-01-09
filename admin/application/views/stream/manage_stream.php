<!DOCTYPE html>
<?php// echo "<pre>";print_r($stream_count);exit;?>
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
	
    <!-- START HERE --> <div class="container">
      
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
					
              <div class="panel panel-visible">
                <div class="panel-heading">
					<div class="panel-title"> <span class="glyphicon glyphicon-picture"></span>Manage Stream <input type="submit" form="change_multiple_publishstatus" class="btn btn-success" class="raw_stream" name="raw_stream" value="Approve Selected" /></div>
				<?php
					//$this->db->where('is_sup_admin',0);
					
					$partner = $this->db->get('kt_admin')->result_array();
					
					//echo $partner[0]['is_sup_admin'];
					?>
				<?php// if($this->session->userdata('is_sup_admin')==0){ ?>
				 <a href="<?php echo base_url('stream/manage_stream/add_new_stream/'); ?>">
					<div class="panel-title pull-right">
						<span class="glyphicon glyphicon-plus"></span>
						Add New Stream
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

					<div class="tab-content" style = "overflow-x: scroll !important;">
					  <div id="home" class="tab-pane fade in active">
						<?php
					if($stream_count2 > 0){
                ?>
				<form class="cmxform" id="change_multiple_publishstatus" method="POST" action="<?php echo base_url(); ?>stream/manage_stream/approve_multiple_stream_pending">
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
                        <th>URL</th>
                        <th>Language</th>
                        <th>Total Bitrate</th>
                        <th>Type</th>
                        <th>Source</th>
                        <th>Mobile Compatibility</th>
                       
                        <th class="">Status</th>
                       <!-- <th class="">Sponsered</th> -->
						<th class="">View</th>
						<?php if($this->session->userdata('is_sup_admin')==0){ } else {?><th class="">Action</th>
						<?php } ?>
                        <!--<th class="text-center hidden-xs">Actions</th> -->
                      </tr>
                    </thead>
                    <tbody>
					
                    <?php 
							for($i=0;$i<$stream_count2;$i++){
								
								
					?>	
                            <tr>	<!-- Count rows -->
							
								<td style="vertical-align: middle;">
									<input name="raw_stream[]" type="checkbox" class="cb-element checkbox1" value="<?php echo $stream_arr2[$i]['id']; ?>"/>
								</td>
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                                <td class=""><?php echo $stream_arr2[$i]['home_team'].' <b>VS</b> '.$stream_arr2[$i]['away_team']; ?></td>
                                <td class="hidden-xs hidden-sm"><?php echo substr($stream_arr2[$i]['stream_domain'],0,15); ?>
								<?php if($this->session->userdata('is_sup_admin')==1){ ?>
								<a href="<?php echo base_url('stream/manage_stream/block_stream').'/'.$stream_arr2[$i]['id'] ; ?>" id="highlight" class="btn btn-danger"><span class="glyphicons glyphicons-remove"></span></a>
								<?php } else{ }?>
								</td>
								<td><?php echo $stream_arr2[$i]['url']; ?></td>
								<!-- Language -->
                                <td class="">
									<div class="select_all">
										<a href="javascript:;" id="href_<?php echo $stream_arr2[$i]['id']; ?>" data-language="<?php echo $stream_arr2[$i]['language']; ?>" class="language" >
										<?php echo $stream_arr2[$i]['language']; ?>
										</a>
										<!-- here -->
										
										<div class="show_language" id="show_<?php echo $stream_arr2[$i]['id']; ?>" style="display:none;">
										<!--
											<input value="<?php //echo $stream_arr2[$i]['language']; ?>" id="my_language_<?php //echo $stream_arr2[$i]['id']; ?>" type="text" name="language">
											-->
											<select class="form-control" id="my_language_<?php echo $stream_arr2[$i]['id']; ?>" name="language">
												<option value="English" <?php if($stream_arr2[$i]['language'] == "English") { ?> selected <?php } ?> >English</option>
												<option value="Arabic" <?php if($stream_arr2[$i]['language'] == "Arabic") { ?> selected <?php } ?> >Arabic</option>
												<option value="Russian" <?php if($stream_arr2[$i]['language'] == "Russian") { ?> selected <?php } ?> >Russian</option>
												<option value="Dutch" <?php if($stream_arr2[$i]['language'] == "Dutch") { ?> selected <?php } ?> >Dutch</option>
												<option value="Spanish" <?php if($stream_arr2[$i]['language'] == "Spanish") { ?> selected <?php } ?> >Spanish</option>
												<option value="German" <?php if($stream_arr2[$i]['language'] == "German") { ?> selected <?php } ?> >German</option>
												<option value="Chinese" <?php if($stream_arr2[$i]['language'] == "Chinese") { ?> selected <?php } ?> >Chinese</option>
												<option value="Urdu" <?php if($stream_arr2[$i]['language'] == "Urdu") { ?> selected <?php } ?> >Urdu</option>
												<option value="Italian" <?php if($stream_arr2[$i]['language'] == "Italian") { ?> selected <?php } ?> >Italian</option>
												<option value="Japenese" <?php if($stream_arr2[$i]['language'] == "Japenese") { ?> selected <?php } ?> >Japenese</option>
												<option value="Hindi" <?php if($stream_arr2[$i]['language'] == "Hindi") { ?> selected <?php } ?> >Hindi</option>
												<option value="Other" <?php if($stream_arr2[$i]['language'] == "Other") { ?> selected <?php } ?> >Other</option>
											</select>
											<input type="button" onClick="update_language(<?php echo $stream_arr2[$i]['id']; ?>);" value="Update" >
										</div>
									</div>
								</td>
								<td><?php echo $stream_arr2[$i]['total_bitrate']; ?></td>
								
							
								<!-- Type -->
                                <td class="">
									<div class="select_all3">
										<a href="javascript:;" id="href3_<?php echo $stream_arr2[$i]['id']; ?>" class="type" >
										<?php echo $stream_arr2[$i]['type']; ?>
										</a>
										<!-- here -->
										
										<div class="show_type" id="show3_<?php echo $stream_arr2[$i]['id']; ?>" style="display:none;">
											<select class="form-control" id="my_type_<?php echo $stream_arr2[$i]['id']; ?>" name="type">
												<option value="http" <?php if($stream_arr2[$i]['type'] == "http") { ?> selected <?php } ?> >http</option>
												<option value="acestream" <?php if($stream_arr2[$i]['type'] == "acestream") { ?> selected <?php } ?> >Acestream</option>
												<option value="sopcast" <?php if($stream_arr2[$i]['type'] == "sopcast") { ?> selected <?php } ?> >Sopcast</option>
												<option value="vlc" <?php if($stream_arr2[$i]['type'] == "vlc") { ?> selected <?php } ?> >Vlc</option>
												<option value="p2p" <?php if($stream_arr2[$i]['type'] == "p2p") { ?> selected <?php } ?> >p2p</option>
												<option value="Zenex" <?php if($stream_arr2[$i]['type'] == "Zenex") { ?> selected <?php } ?> >Zenex</option>
												<option value="Veetle" <?php if($stream_arr2[$i]['type'] == "Veetle") { ?> selected <?php } ?> >Veetle</option>
												<option value="Streamup" <?php if($stream_arr2[$i]['type'] == "Streamup") { ?> selected <?php } ?> >Streamup</option>
												<option value="Miplayer" <?php if($stream_arr2[$i]['type'] == "Miplayer") { ?> selected <?php } ?> >Miplayer</option>
												<option value="P2pcast" <?php if($stream_arr2[$i]['type'] == "P2pcast") { ?> selected <?php } ?> >P2pcast</option>
												<option value="Flash" <?php if($stream_arr2[$i]['type'] == "Flash") { ?> selected <?php } ?> >Flash</option>
												<option value="Other" <?php if($stream_arr2[$i]['type'] == "Other") { ?> selected <?php } ?> >Other</option>
											</select>
											<input type="button" onClick="update_type(<?php echo $stream_arr2[$i]['id']; ?>);" value="Update" >
										</div>
									</div>
								</td>
									<td><?php echo $stream_arr2[$i]['source']; ?></td>
								<!-- compatibility -->
                                <td class="">
								<div class="select_all2">
									<a href="javascript:;" id="href2_<?php echo $stream_arr2[$i]['id']; ?>" class="compatibility" >
									<?php echo $stream_arr2[$i]['compatibility']; ?>
									</a>
									<div class="show_compatibility" id="show2_<?php echo $stream_arr2[$i]['id']; ?>" style="display:none;">
									
										<input type="text" id="my_compatibility_<?php echo $stream_arr2[$i]['id']; ?>" value="<?php echo $stream_arr2[$i]['compatibility']; ?>" name="compatibility">
										<input type="button" onClick="update_compatibility(<?php echo $stream_arr2[$i]['id']; ?>);" value="Update" >
										
										
									</div>
								</div>
								</td>
                                
								<?php if($this->session->userdata('is_sup_admin')==0){ ?>
								<td class=""><?php echo ($stream_arr2[$i]['stream_status'] == 'approved') ? '<span class="label btn-success">Approved</span>' : '<span class="label btn-danger">Pending</span>' ?></td>
								
								<?php } else { ?>
								
                                 <td class="">
									<a  href="<?php echo base_url();?>stream/manage_stream/update_stream_status/<?php echo $stream_arr2[$i]['id']; ?>" class="btn <?php
									echo (($stream_arr2[$i]['stream_status']=="approved")?"btn-success":"btn-danger")?>"><?php
									echo (($stream_arr2[$i]['stream_status']=="approved")?"Approved":"Pending")?></a>
								
									</td> 
								<?php } ?>
								<!--
								<td>
								<?php //if($stream_arr2[$i]['sponsered']=="1") { echo "Yes"; } else { echo "No"; } ?>
								</td> -->
								<td>
								<a href="<?php echo base_url('stream/manage_stream/view_stream').'/'.$stream_arr2[$i]['id'] ; ?>" id="highlight" class="btn btn-primary">View Stream </button></td>
								
								<?php if($this->session->userdata('is_sup_admin')==0){ } else {?>									
								<td>
								<a href="<?php echo base_url();?>stream/manage_stream/delete_stream/<?php echo $stream_arr2[$i]['id']?>" type="button" class="btn btn-danger btn-gradient" style="" onClick="return confirm('Are you sure you want to delete?')"> <span class="glyphicon glyphicon-thumbs-down"></span> </a>
								</td>
									<?php }?>
                            </tr>
							<div id="<?php echo $stream_arr2[$i]['id']; ?>" class="modal fade" role="dialog" style="z-index: 1;">
							  <div class="modal-dialog">

								<!-- Modal content-->

							  </div>
							</div>
							
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
                	<strong>No Stream Found</strong> </div>                	
                <?php		
					}//end if($sponsor_count > 0)
				  ?>
					  </div>
					  <div id="menu1" class="tab-pane fade">
							<?php
					if($stream_count > 0){
                ?><div class="table-responsive">
                 <table class="table table-striped table-bordered table-hover" id="manage_sponsor">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Event Name</th>
                        <th>Domain</th>
                        <th>URL</th>
                        <th>Language</th>
                        <th>Total Bitrate</th>
                        <th>Type</th>
                        <th>Source</th>
                        <th>Mobile Compatibility</th>
                       
                        <th class="">Status</th>
                       <!-- <th class="">Sponsered</th> -->
						<th class="">View</th>
						<?php if($this->session->userdata('is_sup_admin')==0){ } else {?><th class="">Action</th>
						<?php } ?>
                        <!--<th class="text-center hidden-xs">Actions</th> -->
                      </tr>
                    </thead>
                    <tbody>
					
                    <?php 
							for($i=0;$i<$stream_count;$i++){
								
								
					?>	
                            <tr>	<!-- Count rows -->
							
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                                <td class=""><?php echo $stream_arr[$i]['home_team'].' <b>VS</b> '.$stream_arr[$i]['away_team']; ?></td>
                                <td class="hidden-xs hidden-sm"><?php echo substr($stream_arr[$i]['stream_domain'],0,15); ?>
								<?php if($this->session->userdata('is_sup_admin')==1){ ?>
								<a href="<?php echo base_url('stream/manage_stream/block_stream').'/'.$stream_arr[$i]['id'] ; ?>" id="highlight" class="btn btn-danger"><span class="glyphicons glyphicons-remove"></span></a>
								<?php } else{ }?>
								</td>
									<td><?php echo $stream_arr[$i]['url']; ?></td>
                                <td class="">
								<div class="select_all">
									<a href="javascript:;" id="href_<?php echo $stream_arr[$i]['id']; ?>" data-language="<?php echo $stream_arr[$i]['language']; ?>" class="language" >
									<?php echo $stream_arr[$i]['language']; ?>
									</a>
									<!-- here -->
									
									<div class="show_language" id="show_<?php echo $stream_arr[$i]['id']; ?>" style="display:none;">
									<!--
											<input value="<?php //echo $stream_arr[$i]['language']; ?>" id="my_language_<?php //echo $stream_arr[$i]['id']; ?>" type="text" name="language">
											-->
											<select class="form-control" id="my_language_<?php echo $stream_arr[$i]['id']; ?>" name="language">
												<option value="English" <?php if($stream_arr[$i]['language'] == "English") { ?> selected <?php } ?> >English</option>
												<option value="Arabic" <?php if($stream_arr[$i]['language'] == "Arabic") { ?> selected <?php } ?> >Arabic</option>
												<option value="Russian" <?php if($stream_arr[$i]['language'] == "Russian") { ?> selected <?php } ?> >Russian</option>
												<option value="Dutch" <?php if($stream_arr[$i]['language'] == "Dutch") { ?> selected <?php } ?> >Dutch</option>
												<option value="Spanish" <?php if($stream_arr[$i]['language'] == "Spanish") { ?> selected <?php } ?> >Spanish</option>
												<option value="German" <?php if($stream_arr[$i]['language'] == "German") { ?> selected <?php } ?> >German</option>
												<option value="Chinese" <?php if($stream_arr[$i]['language'] == "Chinese") { ?> selected <?php } ?> >Chinese</option>
												<option value="Urdu" <?php if($stream_arr[$i]['language'] == "Urdu") { ?> selected <?php } ?> >Urdu</option>
												<option value="Italian" <?php if($stream_arr[$i]['language'] == "Italian") { ?> selected <?php } ?> >Italian</option>
												<option value="Japenese" <?php if($stream_arr[$i]['language'] == "Japenese") { ?> selected <?php } ?> >Japenese</option>
												<option value="Hindi" <?php if($stream_arr[$i]['language'] == "Hindi") { ?> selected <?php } ?> >Hindi</option>
												<option value="Other" <?php if($stream_arr[$i]['language'] == "Other") { ?> selected <?php } ?> >Other</option>
											</select>
											<input type="button" onClick="update_language(<?php echo $stream_arr[$i]['id']; ?>);" value="Update" >
										
										
									</div>
								</div>
								</td>
								<td><?php echo $stream_arr[$i]['total_bitrate']; ?></td>
                                <!-- Type -->
                                <td class="">
									<div class="select_all3">
										<a href="javascript:;" id="href3_<?php echo $stream_arr[$i]['id']; ?>" class="type" >
										<?php echo $stream_arr[$i]['type']; ?>
										</a>
										<!-- here -->
										
										<div class="show_type" id="show3_<?php echo $stream_arr[$i]['id']; ?>" style="display:none;">
											<select class="form-control" id="my_type_<?php echo $stream_arr[$i]['id']; ?>" name="type">
												<option value="http" <?php if($stream_arr[$i]['type'] == "http") { ?> selected <?php } ?> >http</option>
												<option value="acestream" <?php if($stream_arr[$i]['type'] == "acestream") { ?> selected <?php } ?> >Acestream</option>
												<option value="sopcast" <?php if($stream_arr[$i]['type'] == "sopcast") { ?> selected <?php } ?> >Sopcast</option>
												<option value="vlc" <?php if($stream_arr[$i]['type'] == "vlc") { ?> selected <?php } ?> >Vlc</option>
												<option value="p2p" <?php if($stream_arr[$i]['type'] == "p2p") { ?> selected <?php } ?> >p2p</option>
												<option value="Zenex" <?php if($stream_arr[$i]['type'] == "Zenex") { ?> selected <?php } ?> >Zenex</option>
												<option value="Veetle" <?php if($stream_arr[$i]['type'] == "Veetle") { ?> selected <?php } ?> >Veetle</option>
												<option value="Streamup" <?php if($stream_arr[$i]['type'] == "Streamup") { ?> selected <?php } ?> >Streamup</option>
												<option value="Miplayer" <?php if($stream_arr[$i]['type'] == "Miplayer") { ?> selected <?php } ?> >Miplayer</option>
												<option value="P2pcast" <?php if($stream_arr[$i]['type'] == "P2pcast") { ?> selected <?php } ?> >P2pcast</option>
												<option value="Flash" <?php if($stream_arr[$i]['type'] == "Flash") { ?> selected <?php } ?> >Flash</option>
												<option value="Other" <?php if($stream_arr[$i]['type'] == "Other") { ?> selected <?php } ?> >Other</option>
											</select>
											<input type="button" onClick="update_type(<?php echo $stream_arr[$i]['id']; ?>);" value="Update" >
										</div>
									</div>
								</td>
								<td><?php echo $stream_arr[$i]['source']; ?></td>
                                <td class="">
								<div class="select_all2">
									<a href="javascript:;" id="href2_<?php echo $stream_arr[$i]['id']; ?>" class="compatibility" >
									<?php echo $stream_arr[$i]['compatibility']; ?>
									</a>
									<div class="show_compatibility" id="show2_<?php echo $stream_arr[$i]['id']; ?>" style="display:none;">
									
										<input type="text" id="my_compatibility_<?php echo $stream_arr[$i]['id']; ?>" value="<?php echo $stream_arr[$i]['compatibility']; ?>" name="compatibility">
										<input type="button" onClick="update_compatibility(<?php echo $stream_arr[$i]['id']; ?>);" value="Update" >
										
										
									</div>
								</div>
								</td>
                                
								<?php if($this->session->userdata('is_sup_admin')==0){ ?>
								<td class=""><?php echo ($stream_arr[$i]['stream_status'] == 'approved') ? '<span class="label btn-success">Approved</span>' : '<span class="label btn-danger">Pending</span>' ?></td>
								
								<?php } else { ?>
								
                                 <td class="">
									<a  href="<?php echo base_url();?>stream/manage_stream/update_stream_status/<?php echo $stream_arr[$i]['id']; ?>" class="btn <?php
									echo (($stream_arr[$i]['stream_status']=="approved")?"btn-success":"btn-danger")?>"><?php
									echo (($stream_arr[$i]['stream_status']=="approved")?"Approved":"Pending")?></a>
								
									</td> 
								<?php } ?>
								<!--
								<td>
								<?php //if($stream_arr[$i]['sponsered']=="1") { echo "Yes"; } else { echo "No"; } ?>
								</td> -->
								<td>
								<a href="<?php echo base_url('stream/manage_stream/view_stream').'/'.$stream_arr[$i]['id'] ; ?>" id="highlight" class="btn btn-primary">View Stream </button></td>
								
								<?php if($this->session->userdata('is_sup_admin')==0){ } else {?>									
								<td>
								<a href="<?php echo base_url();?>stream/manage_stream/delete_stream/<?php echo $stream_arr[$i]['id']?>" type="button" class="btn btn-danger btn-gradient" style="" onClick="return confirm('Are you sure you want to delete?')"> <span class="glyphicon glyphicon-thumbs-down"></span> </a>
								</td>
									<?php }?>
                            </tr>
							<div id="<?php echo $stream_arr[$i]['id']; ?>" class="modal fade" role="dialog" style="z-index: 1;">
							  <div class="modal-dialog">

								<!-- Modal content-->

							  </div>
							</div>
							
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
                	<strong>No Stream Actived</strong> </div>                	
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
    </div> <!-- END HERE -->
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
</script>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
<script>
//FOR DATE
formatAMPMd();


function formatAMPMd() {
var d = new Date(),

    minutes2 = d.getMinutes().toString().length == 1 ? '0'+d.getMinutes() : d.getMinutes(),
    hours2 = d.getHours().toString().length == 1 ? '0'+d.getHours() : d.getHours(),
   // ampm2 = d.getHours() >= 12 ? ' PM' : ' AM';
  months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
   days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
	var my_date = months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear();
	var my_time = months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear()+' '+hours2+':'+minutes2;
	//alert(my_date);
	
	$.post("<?php echo base_url();?>stream/manage_stream/get_date",{
				date : my_date,
				date_time : my_time
			}).done(function(data){
				console.log(data);
			});
			
return days[d.getDay()]+' '+months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear()+' '+hours+':'+minutes+ampm;

}

</script>
  <script>
  $('.select_all').click(function(e){
	  $(this).find('a').hide();
	  $(this).find('.show_language').show();
	  
  });
  $('.select_all2').click(function(e){
	  $(this).find('a').hide();
	  $(this).find('.show_compatibility').show();
	  
  });
  $('.select_all3').click(function(e){
	  $(this).find('a').hide();
	  $(this).find('.show_type').show();
	  
  });
  
  // $('.language').click(function(e){
	  // $(this).hide();

	  // var get_language = $(this).data("language");
	  
	  
  // });
$(document).ready(function(){
	myFunction();
	function myFunction() {
    var d = new Date();
    var n = d.getTimezoneOffset();
    //document.getElementById("demo").innerHTML = n;

    var d = new Date();
    //alert(n); Shows offset for time zone.
	var gmtHours = -d.getTimezoneOffset()/60;
	//var d = new Date();
	//var na = d.toUTCString();
	//alert(gmtHours); shows local time GMT
	//document.write("The local time zone is: GMT " + gmtHours);
	var newtime = gmtHours;
	//alert(newtime) SHOWS NEW GMT according to database.

	$.ajax({
		url : '<?php echo base_url();?>stream/manage_stream/get_date_by_timezone',
		data : {'timezone' : newtime},
		type : 'POST',
		success : function(data){
			console.log(data);
		}
	});

	}
	});
function update_language(id){
	
	var new_language = $('#my_language_'+id).val();
	// console.log(id)
	// console.log(new_language);
	$.ajax({
		type : "POST",
		url : '<?php echo base_url();?>stream/manage_stream/update_new',
		data : {'language' : new_language , 'id' : id},
		success : function(data){
			//console.log(data)
			if(data == 'success'){
				$('#show_'+id).hide();
				$('#href_'+id).html(new_language);
				$('#href_'+id).show();
			}
		}
	});
}
function update_compatibility(id){
	var comp =	$('#my_compatibility_'+id).val();
	$.ajax({
		type : "POST",
		url : '<?php echo base_url();?>stream/manage_stream/update_new',
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
	$.ajax({
		type : "POST",
		url : '<?php echo base_url();?>stream/manage_stream/update_new',
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