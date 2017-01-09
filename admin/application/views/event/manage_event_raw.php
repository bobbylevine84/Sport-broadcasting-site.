<!DOCTYPE html>
<?php //echo "<pre>";print_r($event_arr);exit;?>
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
					<div class="panel-title"> <span class="glyphicon glyphicon-picture"></span>Manage event <input type="submit" form="change_multiple_publishstatus" class="btn btn-success" class="raw_event" name="raw_event" value="Approve Selected" /></div>
				<?php
					//$this->db->where('is_sup_admin',0);
					
					$partner = $this->db->get('kt_admin')->result_array();
					
					//echo $partner[0]['is_sup_admin'];
					?>
				
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
				<?php
					if($event_count > 0){
                ?>
				
			     <form class="cmxform" id="change_multiple_publishstatus" method="POST" action="<?php echo base_url(); ?>event/manage_event/approve_multiple_event">
				<div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="manage_raw_data">
                    <thead>
                      <tr>
					  <th>
					  <input type="checkbox" id="checkbox1">
					  </th>
                        <th>#</th>
						
						<th>Event</th>
                        <th>Match</th>
                        <th>Date</th>
						<th>status</th>
                        <th>Action</th>
						
                      </tr>

                    </thead>
                    <tbody>
                    <?php 
							for($i=0;$i<$event_count;$i++){
								
					?>	
                            <tr>	<!-- Count rows -->
								<td style="vertical-align: middle;">
								<!--
								<input type="checkbox" name="checked[]" value="<?php //echo $event_arr[$i]['id']; ?>" style="width: auto; height: auto;" id="checkall" class="checkall" /> -->
								 <input name="raw_event[]" type="checkbox" class="cb-element checkbox1" value="<?php echo $event_arr[$i]['id']; ?>"/>
								</td>
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                                <td class=""><?php echo $event_arr[$i]['competition_name']; ?></td>
								<td class="">
									<span class="flag">
										<img src="<?php echo FRONT?>/images/<?php echo $event_arr[$i]['home_team_logo'];?>" style="width:25px;height:17px;">
									</span>
									<span class="country-name">
										<?php echo $event_arr[$i]['home_team'];?>
									</span>
									&nbsp&nbsp<b>VS</b>&nbsp&nbsp
									<span class="flag">
										<img src="<?php echo FRONT?>/images/<?php echo $event_arr[$i]['away_team_logo'];?>" style="width:25px;height:17px;">
									</span> 
									<span class="country-name">
										<?php echo $event_arr[$i]['away_team'];?>
									</span>
								</td>
								<td class="">
									<?php echo date('jS', strtotime($event_arr[$i]['start_date']));?>
									<?php echo date('F', strtotime($event_arr[$i]['start_date'])); ?>
									<?php echo date('o', strtotime($event_arr[$i]['start_date'])); ?>,
									<?php echo date('l', strtotime($event_arr[$i]['start_date']));?>
								</td> 
								<td class="">
									<a  href="<?php echo base_url();?>event/manage_event/update_event_raw/<?php echo $event_arr[$i]['id']; ?>" class="btn <?php
									echo (($event_arr[$i]['event_status_raw']=="approved")?"btn-success":"btn-danger")?>"><?php
									echo (($event_arr[$i]['event_status_raw']=="approved")?"Approved":"Pending")?></a>
								</td> 
								<td>
								<a href="<?php echo base_url();?>event/manage_event/delete_event_raw/<?php echo $event_arr[$i]['id']; ?>" type="button" class="btn btn-danger btn-gradient" > <span class="glyphicons glyphicons-remove"></span> </a>
								</td>
							
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
                	<strong>No event Actived</strong> </div>                	
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
	
	
	
	$('#manage_raw_data').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -0,-1,-2,-3, -4,-5,-6 ] }],
		"aaSorting": [],
		"oLanguage": { "oPaginate": {"sPrevious": "", "sNext": ""} },
		"iDisplayLength": 10,
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
function raw_event(){
	alert();
}
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
