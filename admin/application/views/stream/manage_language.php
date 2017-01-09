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
					<div class="panel-title"> <span class="glyphicon glyphicon-picture"></span>Manage Language</div>
				<?php
					//$this->db->where('is_sup_admin',0);
					
					$partner = $this->db->get('kt_admin')->result_array();
					
					//echo $partner[0]['is_sup_admin'];
					?>
				<?php// if($this->session->userdata('is_sup_admin')==0){ ?>
				 <a data-toggle="modal" data-target="#a" >
					<div class="panel-title pull-right">
						<span class="glyphicon glyphicon-plus"></span>
						Add New Language
					</div>
				</a> 
				<div id="a" class="modal fade" role="dialog">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					<form enctype="multipart/form-data" method="POST" action="<?php echo base_url();?>stream/manage_stream/add_language" >
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add Language</h4>
					  </div>
					  <div class="modal-body">
						<div class="form-group">
						<label>Language Name </label>
						<input type="text" name="language" class="form-control">
						</div>
						<div class="form-group">
						<label>Upload Image </label>
						<input type="file" name="upload" class="form-control">
						</div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-success" value="Add" >
					  </div>
					  </form>
					</div>

				  </div>
				</div>
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
				
				<?php $lang = $this->db->get('kt_language_logo')->result_array(); ?>
					<div class="tab-content">
						<div id="home" class="tab-pane fade in active">
							<form class="cmxform" id="change_multiple_publishstatus" method="POST" action="<?php echo base_url(); ?>stream/manage_stream/approve_multiple_stream_pending">
								<div class="table-responsive">
									  <table class="table table-striped table-bordered table-hover" id="manage_sponsor">
										<thead>
										  <tr>
											<th>Name</th>
											<th>Image</th>
											<th>Action</th>
											
										  </tr>
										</thead>
										<tbody>
											<?php foreach($lang as $language) { ?>
												<tr>	<!-- Count rows -->
													<td class="hidden-xs hidden-sm">
														<?php echo $language['name']; ?>
													</td>						
													<td>
													<img src="<?php echo base_url();?>uploads/game_images/<?php echo $language['lang_logo']; ?>">
													</td>
													<td>
													<a href="<?php echo base_url();?>stream/manage_stream/manage_language/delete_language/<?php echo $language['id']; ?>" type="button" class="btn btn-danger btn-gradient" > <span class="glyphicons glyphicons-remove"></span> </a>
													<a href="<?php echo base_url();?>stream/manage_stream/update_language/<?php echo $language['id']; ?>" type="button" class="btn btn-primary btn-gradient" > <span class="glyphicons glyphicons-edit"></span> </a>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									  </table>
								  </div>
							 </form>
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


</script>