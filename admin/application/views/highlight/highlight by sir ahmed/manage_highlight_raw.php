<!DOCTYPE html>
<?php //echo "<pre>";print_r($highlight_arr);exit;?>
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
				<div class="panel-title">
					<span class="glyphicon glyphicon-picture"></span>Manage Highlight Raw 
					
					<input type="submit" form="change_multiple_publishstatus" class="btn btn-success" class="raw_highlight" name="raw_highlight" value="Approve Selected" />
				</div>
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
                    }
					// foreach($highlight_arr as $h){
					// $this->db->select('id,home_team,away_team');
					// $this->db->where('home_team',$h['home_team']);
					// $this->db->where('away_team',$h['away_team']);
					// $query = $this->db->get('kt_events')->result_array();
					// echo print_r($query)."<br>";
					// echo $this->db->last_query()."<br>";
					// }
					
					
					
					if($highlight_count > 0){
                ?>
				<form class="cmxform" id="change_multiple_publishstatus" method="POST" action="<?php echo base_url(); ?>highlight/manage_highlight/approve_multiple_highlight">
				<div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="manage_sponsor">
                    <thead>
                      <tr>
					  <th>
						<input type="checkbox" id="checkbox1">
					  </th>
                       <th>#</th>
                        <th>Event Name</th>
                        <th>Time</th>
						<th>Status</th>
						<th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
							for($i=0;$i<$highlight_count;$i++){
					?>	
								<tr>	<!-- Count rows -->
									<td style="vertical-align: middle;">
										<input name="raw_highlight[]" type="checkbox" class="cb-element checkbox1" value="<?php echo $highlight_arr[$i]['id']; ?>"/>
									</td>
									<td><span class="xedit"><?php echo ($i+1) ?></span></td>
									<td class=""><?php echo $highlight_arr[$i]['home_team'].' <b>VS</b> '.$highlight_arr[$i]['away_team']; ?></td>
									<td class=""><?php echo date("Y-m-d H:i:s",$highlight_arr[$i]['time']); ?></td>
									<td class="">
										<a  href="<?php echo base_url();?>video-highlights/manage_highlight/update_highlight_raw2/<?php echo $highlight_arr[$i]['id']; ?>" class="btn <?php
										echo (($highlight_arr[$i]['status_raw']=="approved")?"btn-success":"btn-danger")?>"><?php
										echo (($highlight_arr[$i]['status_raw']=="approved")?"Approved":"Pending")?></a>
									</td>
									<td>
										<a href="<?php echo base_url();?>video-highlights/manage_highlight/delete_highlight_raw/<?php echo $highlight_arr[$i]['id']?>" type="button" class="btn btn-danger btn-gradient" style="" onClick="return confirm('Are you sure you want to delete?')"> <span class="glyphicons glyphicons-remove"></span> 
										</a>
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
                	<strong>No Highlight Found</strong> </div>                	
                <?php		
					}//end if($sponsor_count > 0)
				  ?>
			  
					
					</div>
                </div>
				<?php
				
				
				
				?>
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
		} 
		else{
			$('.checkbox1').each(function() { //loop through each checkbox
				this.checked = false; //deselect all checkboxes with class "checkbox1"                       
			});
		 }       
		
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
$(document).ready(function(){
    $("#success").fadeOut(2000);
    $("#fail").fadeOut(2000);
});
</script>
</body>
</html>
