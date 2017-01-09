<?php 
$session_post_data = $this->session->userdata('add_news_data');
$rss = $this->load->database('rss', TRUE);
//print_r($session_post_data);exit;
//echo "<pre>";print_r($get_my_event);exit;
?>
<!DOCTYPE html>
<html>
<head>
<style>
 .ui-autocomplete {
    height: auto;
    max-height: 200px;
    overflow-y: auto;
    width:auto;
}
.upload-file {
	float:left;
	margin-left:15px;
}
</style>
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
          <div class="panel">
            <div class="panel-heading">
				<div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit event</div>
				<a href="<?php echo base_url('event/manage_event/'); ?>">
					<div class="panel-title hidden-xs pull-right">
						<span class="glyphicon glyphicon-hand-left"></span>
						Go Back
					</div>
				</a>
				</div>
            <div class="panel-body alerts-panel">
             
						<?php
							if($this->session->flashdata('err_message')){
						?>
								<div class="alert alert-danger" id="fail"><?php echo $this->session->flashdata('err_message'); ?></div>
						<?php
							}
							
							if($this->session->flashdata('ok_message')){
						?>
								<div class="alert alert-success alert-dismissable" id="success"><?php echo $this->session->flashdata('ok_message'); ?></div>
						<?php 
							}//if($this->session->flashdata('ok_message'))
							
						?>	
						
						<?php
						
						//$query2=$this->db->get('kt_nation_custom_text')->result_array();
						?>
						 <form class="cmxform" id="" action="<?php echo base_url(); ?>event/manage_event/edit_event_process" method="POST"  enctype="multipart/form-data">

						<div class="form-group" id="write_c">
							<label for="">Enter Competition Name *</label>
							<input type="text" placeholder="Competition Name" value="<?php echo $get_my_event[0]['competition_name'];?>" class="form-control" name="competition" id="new_comp" style="padding:16px;">
							<!--
						<div class="form-group upload-file">
							<input type="file" id="upload" name="c_upload">
							<img style="width:50px; height:50px;" src="<?php echo $get_my_event[0]['comp_logo']; ?>">
						</div>
						-->
						</div>
						<input type="hidden" name="event_id" value="<?php echo $get_my_event[0]['id'];?>">
						<input type="hidden" name="old_comp" value="<?php echo $get_my_event[0]['competition_id'];?>">
						<div class="clearfix"></div>
						<div class="wrapper" id="input_url">
							<div class="form-group">
								<label for="">Home Team *</label>
								<input type="text"  value="<?php echo $get_my_event[0]['home_team'];?>"  placeholder="Home Team" class="form-control" name="home_team" id="home_team" class="home_team"  required style="padding:16px;">
							</div>
						</div>
						<!--
						<div class="form-group upload-file">
							<input type="file" id="upload" name="h_upload">
							<?php //if($get_my_event[$i]['home_team_logo'] == '') {?>
							
							<img src="http://www.realstreamsports.com/images/teams/default.png" style="height:50px;width:50px;" >
							<?php// } else {?>
								<img src="<?php// echo $get_my_event[$i]['home_team_logo'];?>" style="height:50px;width:50px;" >
						<?php //} ?>
						</div> --> <div class="clearfix"></div>
						<div class="wrapper" id="input_url" >
							<div class="form-group" >
								<label for="">Away Team *</label>
								<input type="text"  value="<?php echo $get_my_event[0]['away_team'];?>" placeholder="Away Team" class="form-control" name="away_team" id="away_team" class="away_team" required style="padding:16px;">
							</div>
						</div>
						<!--
						<div class="form-group upload-file">
							<input type="file" id="upload" name="a_upload">
						</div> 
						<?php //if($get_my_event[$i]['away_team_logo'] == '') {?>
							
							<img src="http://www.realstreamsports.com/images/teams/default.png" style="height:50px;width:50px;" >
							<?php //} else {?>
								<img src="<?php// echo $get_my_event[$i]['away_team_logo'];?>" style="height:50px;width:50px;" >
						<?php //} ?>
						-->
						<div class="clearfix"></div>
						<div class="form-group">
						
						<div id="datetimepicker1" class="input-append date col-sm-4" >
						<label for="">Start Date and Time *</label>
							<input type="text" class="form-control" value="<?php echo $get_my_event[0]['start_date'];?>" style="padding:16px;" name="start_date"></input>
							<span class="add-on" style="padding:16px;">
								<i data-time-icon="icon-time" data-date-icon="icon-calendar" style="hight:10px;"></i>
							</span>
						</div>
			
						<div id="datetimepicker2" class="input-append date col-sm-4" >
						<label for="" style=" margin-left:20px;">Ending Date and Time *</label>
							<input type="text" value="<?php echo $get_my_event[0]['end_date'];?>" class="form-control" style="padding:16px;margin-left:20px;" name="end_date"></input>
							<span class="add-on" style="padding:16px;">
								<i data-time-icon="icon-time" data-date-icon="icon-calendar" style="hight:10px;"></i>
							</span>
						</div>
						</div>
						
						<div class="form-group" align="right" style="">
							<input class="submit btn btn-primary" type="submit" name="add_sevent" id="add_event" value="Update event" />
						</div>
		
			</form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End: Content --> 
  	
</div>



<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">	
<script type="text/javascript"
	src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
</script>
<script type="text/javascript"
	src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
</script>
<!--
<script src="<?php //echo SUR; ?>resources/js/jquery-ui.js"></script>	
<link rel="stylesheet" href="<?php //echo SUR; ?>resources/css/jquery-ui.css">
<script src="<?php //echo SUR; ?>resources/js/datepicker/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php //echo SUR; ?>resources/js/datepicker/datepicker.css"></script>
<script src="<?php //echo SUR; ?>resources/plugins/jquery-validation/dist/jquery.validate.min.js"></script>-->	
<!-- End: Footer --> 
    <script type="text/javascript">
      $('#datetimepicker1').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
        language: 'en'
      });
	   $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
        language: 'en'
      });
    </script>
<script>
$(function() {
    $( "#dob" ).datepicker({
		changeYear: true,
		yearRange: "1900:<?php echo date("Y"); ?>"
	});
});
</script>
<script>
$(document).ready(function () {
	

});
	


	$("#home_team").autocomplete({
    source: function(request, response) {
        $.ajax({
			type: "POST",
            url: "<?php echo base_url();?>event/manage_event/get_sport_team2",
            dataType: "json",
            data: {
                term : request.term,
                select_sport : $('#sport_category').val()
            },
            success: function(data) {
                response(data);
				//console.log(data)
            }
        });
    },
    //min_length: 3,
    //delay: 300
});
$("#away_team").autocomplete({
	
    source: function(request, response) {
        $.ajax({
			type: "POST",
            url: "<?php echo base_url();?>event/manage_event/get_sport_team2",
            dataType: "json",
            data: {
                term : request.term,
                select_sport : $('#sport_category').val()
            },
            success: function(data) {
                response(data);
				//console.log(data)
            }
        });
    },
});
		
	$('#competition_nation').change(function(){
		var nation_change = $('#competition_nation').val();
		//console.log(nation_change);
		$.ajax({
			type: "POST",
			url : "<?php echo base_url();?>event/manage_event/on_change_nation",
			//dataType : "json", If parsing JSON
			data : {
				nation : nation_change
			},
			success : function(data){
				console.log(data)
				document.getElementById("sport_competition").innerHTML = data;
			}
		});
	});
	
	$('#sport_category').change(function(){
		var sport_id = $('#sport_category').val();
		//console.log(sport_id)
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>event/manage_event/get_sport_competition",  
			data: {
					sport_category: sport_id //variable, value
			},
			success: function(data)
			{
				//console.log(data)
			  //  document.getElementById("sport_competition").innerHTML= data;
			}
		});
		// getting teams on the basis of sports id.
		
	});
	$('#sport_category').change(function(){
		var sport_cat_id = $('#sport_category').val();
		//console.log(sport_cat_id)
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>event/manage_event/get_sport_nation",
			data: {
				sport_category : sport_cat_id
			},
			success : function(data){
				//alert();
				//console.log(data)
			//	document.getElementById("competition_nation").innerHTML = data;
			}
		});
	});
	$('#sport_competition').change(function(){
		var nation_id = $('#sport_competition').val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>event/manage_event/get_competition_nation",
			data: {
				nation : nation_id //variable,value
			},
			success: function(data){
				//console.log(data)
				//document.getElementById("competition_nation").innerHTML = data;
			}
		});
	});

	// $("#home_team").autocomplete({
		// source: "<?php echo base_url(); ?>event/manage_event/get_sport_team",
    // });
	
</script>

<?php echo $INC_header_script_footer;?>
    <script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
		$("#add_new_slider_image_frm").validate({

            rules: {
				sponsor_bank_name: "required",
				display_order: {
					required: false,
					digits: true
				},
				sponsor_bank_url: {
					required: false,
					url: true
				},

            },

            messages: {
				display_order : "Use digit to set a display order",
				sponsor_bank_name : "Bank Name cannot be empty"
            }

		});

		$("#sponsor_image").rules(
		 	"add", {
			 required:true,
			 extension: "jpg|jpeg|gif|tiff|png",
         	messages: {
				extension : "Please select valid image for epaper pages(Use: jpg, jpeg, gif, tiff, png)",
         }
      	});
		
    
    });
    </script>

</body>
</html>
