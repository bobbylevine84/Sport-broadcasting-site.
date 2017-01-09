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
					<div class="panel-title hidden-xs"> <span class="glyphicon glyphicon-picture"></span>Manage event</div>
				<?php
					//$this->db->where('is_sup_admin',0);
					
					$partner = $this->db->get('kt_admin')->result_array();
					
					//echo $partner[0]['is_sup_admin'];
					?>
				 <a href="<?php echo base_url('event/manage_event/add_new_event/'); ?>">
					<div class="panel-title  pull-right">
						<span class="glyphicon glyphicon-plus"></span>
						Add New event
						<span id="para1"></span>
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
                        <div class="alert alert-success alert-dismissable" id="success"><?php echo $this->session->flashdata('ok_message'); ?></div>
                <?php 
                    }//if($this->session->flashdata('ok_message'))
					?>
				<?php
					if($event_count > 0){
                ?><div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="manage_raw_data">
                    <thead>
                      <tr>
                        <th>#</th>
						<th>Event</th>
                        <th>Match</th>
                        <th width="25px;">Nation</th>
                       <!-- <th>Date</th>-->
                        <th>Action</th>
						
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
							for($i=0;$i<$event_count;$i++){
								
					?>	<?php// echo "<pre>";print_r($event_arr[$i]);exit;?>
                            <tr>	<!-- Count rows -->
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                                <td class="">
									<span class="flag">
										<img src="<?php echo $event_arr[$i]['comp_logo'];?>" style="width:25px;height:17px;">
									</span> 
									<span class="country-name">
										<a style="width:100%;" href="#" data-toggle="modal" data-target="#meModal_<?php echo $event_arr[$i]['competition_id']?>">
											<?php echo ucwords($event_arr[$i]['competition_name']);?>
										</a>
										<div id="meModal_<?php echo ucwords($event_arr[$i]['competition_id']);?>" class="modal fade" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content--> 
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">
														<?php echo ucwords($event_arr[$i]['competition_name']);?>
														</h4>
													</div>
													<form class="cmxform" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL?>event/manage_event/update_competition_logo" enctype="multipart/form-data">
													<div class="modal-body">
															<input type="file" id="upload" name="upload">
															<span>
																<img src="<?php echo $event_arr[$i]['comp_logo'];?>" style="height:50px;width:50px;" >
															</span>
															<input type="hidden" name="competition" value="<?php echo $event_arr[$i]['competition_id']; ?>">
													</div>
													<div class="modal-footer">
														<input type="submit" value="Update" style="float:right;" class="btn btn-default pull-right" >
														
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														</form>
														
													</div>
												</div>
											</div>
										</div>
									</span>
								
								</td>
								<td class="">
									<span class="flag">
										<?php if($event_arr[$i]['home_team_logo'] == '') {?>				
										<img src="http://www.realstreamsports.com/images/teams/default.png" style="height:25px;width:17px;" >
										<?php } else {?>
										<img src="<?php echo $event_arr[$i]['home_team_logo'];?>" style="height:25px;width:17px;" >
										<?php } ?>
									</span>
									<span class="country-name">
										<a style="width:100%;" href="#" data-toggle="modal" data-target="#meModal_<?php echo $event_arr[$i]['home_team_id']?>">
										
											<?php echo ucwords($event_arr[$i]['home_team']);?>
											
										</a>
										
										<div id="meModal_<?php echo $event_arr[$i]['home_team_id']?>" class="modal fade" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content--> 
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">
														<?php echo ucwords($event_arr[$i]['home_team']);?>
														</h4>
													</div>
													<form class="cmxform" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL?>event/manage_event/update_team_logo" enctype="multipart/form-data">
													<div class="modal-body">
														<input type="file" id="upload" name="upload">
														
														<span>
															<?php if($event_arr[$i]['home_team_logo'] == '') {?>
																
																<img src="http://www.realstreamsports.com/images/teams/default.png" style="height:50px;width:50px;" >
															<?php } else {?>
															<img src="<?php echo $event_arr[$i]['home_team_logo'];?>" style="height:50px;width:50px;" >
															<?php } ?>
														</span>
															<input type="hidden" name="team" value="<?php echo $event_arr[$i]['home_team_id']; ?>">
														
														
													</div>
													<div class="modal-footer">
														
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														
														<input type="submit" value="Update" style="float:right;" class="btn btn-default pull-right" >
														</form>
														
													</div>
												</div>
											</div>
										</div>
									</span>
									&nbsp&nbsp<b>VS</b>&nbsp&nbsp
									<span class="flag">
										<?php if($event_arr[$i]['away_team_logo'] == '') {?>
																
											<img src="http://www.realstreamsports.com/images/teams/default.png" style="height:25px;width:17px;" >
										<?php } else {?>
										<img src="<?php echo $event_arr[$i]['away_team_logo'];?>" style="height:25px;width:17px;" >
										<?php } ?>
									</span> 
									<span class="country-name">
										<a style="width:100%;" href="#" data-toggle="modal" data-target="#meModal_<?php echo $event_arr[$i]['away_team_id']?>">
										
											<?php echo $event_arr[$i]['away_team'];?>
											
										</a>
										
										<div id="meModal_<?php echo $event_arr[$i]['away_team_id']?>" class="modal fade" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content--> 
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">
														<?php echo ucwords($event_arr[$i]['away_team']);?>
														</h4>
													</div>
													<form class="cmxform" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL?>event/manage_event/update_team_logo" enctype="multipart/form-data">
													<div class="modal-body">
														
													
															
															<input type="file" id="upload" name="upload">
															<span><?php if($event_arr[$i]['away_team_logo']) {?>
																<img src="<?php echo $event_arr[$i]['away_team_logo'];?>" style="height:50px;width:50px;" >
															<?php } else {?>
															<img src=">http://www.realstreamsports.com/images/teams/default.png" style="height:50px;width:50px;" >
															<?php } ?>
															</span>
															<input type="hidden" name="team" value="<?php echo $event_arr[$i]['away_team_id']; ?>">
															
															
													
														
														
													</div>
													<div class="modal-footer">
														
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														<input type="submit" value="Update" style="float:right;" class="btn btn-default pull-right" >
														</form>
														
													</div>
												</div>

											</div>
										</div>
									
									
										
									</span>
								</td>
								<td class="">
								<?php
									 ?> 
											<span class="cont-flag">
												<img style="height:25px;width:17px;" src="<?php echo FRONT?>/Flags/<?php echo ucwords(strtolower($event_arr[$i]['nation'])).'.png';?>" alt="">
											</span>
								
								
								<?php echo $event_arr[$i]['nation']; ?></td>
								
								<!--<td class="">
									<?php //echo date('jS', strtotime($event_arr[$i]['start_date']));?>
									<?php ////echo date('F', strtotime($event_arr[$i]['start_date'])); ?>
									<?php //echo date('o', strtotime($event_arr[$i]['start_date'])); ?>,
									<?php //echo date('l', strtotime($event_arr[$i]['start_date']));?>
								</td> -->
								<td>
								<a href="<?php echo base_url();?>event/manage_event/delete_event/<?php echo $event_arr[$i]['id']; ?>" type="button" class="btn btn-danger btn-gradient" > <span class="glyphicons glyphicons-remove"></span> </a>
								<a href="<?php echo base_url();?>event/manage_event/update_event/<?php echo $event_arr[$i]['id']; ?>" type="button" class="btn btn-primary btn-gradient" > <span class="glyphicons glyphicons-edit"></span> </a>
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
                	<strong>No Events Actived</strong> </div>                	
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
	$('#manage_raw_data').dataTable({
		"aoColumnDefs": [{ 'bSortable': true, 'aTargets': [-2,-3, -4,-5,-6 ] }],
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 

<script>
// function DisplayTime(timeZoneOffsetminutes){
// if (!document.all && !document.getElementById)
// return
// timeElement=document.getElementById? document.getElementById("para1"): document.all.tick2
// var requiredDate=getTimeZoneTimeObj(timeZoneOffsetminutes)
// var hours=requiredDate.h;
// var minutes=requiredDate.m;
// var seconds=requiredDate.s;
// var DayNight="PM";
// if (hours<12) DayNight="AM";
// if (hours>12) hours=hours-12;
// if (hours==0) hours=12;
// if (minutes<=9) minutes="0"+minutes;
// if (seconds<=9) seconds="0"+seconds;
// var currentTime=hours+":"+minutes+":"+seconds+" "+DayNight;
// timeElement.innerHTML="<font style='font-family:Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-extfont-size:14px;color:;'>"+currentTime+"</b>"
// setTimeout("DisplayTime(-300)",1000)
// }
// window.onload=DisplayTime(-300);
// function getTimeZoneTimeObj(timeZoneOffsetminutes){
   // var localdate = new Date()
   // var timeZoneDate = new Date(localdate.getTime() + ((localdate.getTimezoneOffset()- timeZoneOffsetminutes)*60*1000));
  // return {'h':timeZoneDate.getHours(),'m':timeZoneDate.getMinutes(),'s':timeZoneDate.getSeconds()};
// }
//FOR DATE
document.getElementById("para1").innerHTML = formatAMPM();
document.getElementById("para2").innerHTML = formatAMPMd();
function formatAMPM() {
var d = new Date(),

    minutes = d.getMinutes().toString().length == 1 ? '0'+d.getMinutes() : d.getMinutes(),
    hours = d.getHours().toString().length == 1 ? '0'+d.getHours() : d.getHours(),
    ampm = d.getHours() >= 12 ? ' PM' : ' AM';
  months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
   days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
	return hours+':'+minutes+ampm;
return days[d.getDay()]+' '+months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear()+' '+hours+':'+minutes+ampm;
}
function formatAMPMd() {
var d = new Date(),

    minutes2 = d.getMinutes().toString().length == 1 ? '0'+d.getMinutes() : d.getMinutes(),
    hours2 = d.getHours().toString().length == 1 ? '0'+d.getHours() : d.getHours(),
   // ampm2 = d.getHours() >= 12 ? ' PM' : ' AM';
  months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
   days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
	var my_date = months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear();
	var my_time = months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear()+' '+hours2+':'+minutes2;
	//alert(my_time);
	
	$.post("<?php echo base_url();?>event/manage_event/get_date/",{
				date : my_date,
				date_time : my_time
			}).done(function(data){
				console.log(data)
				
			});
			
return days[d.getDay()]+' '+months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear()+' '+hours+':'+minutes+ampm;

}
</script>
 <script>
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
	//alert(newtime);
	//alert(newtime) SHOWS NEW GMT according to database.

	$.ajax({
		url : '<?php echo base_url();?>event/manage_event/get_date_by_timezone/',
		data : {'timezone' : newtime},
		type : 'POST',
		success : function(data){
			//window.location.href = document.URL;
 				//console.log(data)
		}
	});

	}
	});


</script>