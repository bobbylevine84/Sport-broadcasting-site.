<?php //echo "<pre>";print_r($ads_arr);exit;?>
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
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit Ads</div>
			  <a href="<?php echo base_url('ads/manage_ads/'); ?>">
					<div class="panel-title hidden-xs pull-right">
						<span class="glyphicon glyphicon-hand-left"></span>
						Go Back
					</div>
				</a>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL?>ads/manage_ads/edit_ads_process" enctype="multipart/form-data">
                <div class="tab-content border-none padding-none">
					<div id="cms_main_contents" class="tab-pane active">
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
						
						$rss = $this->load->database('rss', TRUE);
						$rss->select('competition_id,competition_name');
						$competition = $rss->get('rss_competition')->result_array();
						?>
						
						<label>Competition Name </label>
						<div class="form-group">
						
						<select class="form-control" id="c_id" class="c_id" name="id" >
							<?php foreach($competition as $c ) {?>
							<option value="<?php echo $c['competition_id'];?>" <?php  if($ads_arr[0]['comp_id'] == $c['competition_id'])  { ?> selected <?php } ?> ><?php echo $c['competition_name'];?></option>
							<?php } ?>
						</select>
						</div>
						<div class="form-group">
							<label>Link </label>
							<input type="text" class="form-control" id="url" value="<?php echo $ads_arr[0]['url'];?>" name="url" required>
						</div>
						<div class="checking">
							<label>Watch HD </label>
							<input type="checkbox" id="check" value="HD" name="hd" <?php if($ads_arr[0]['hd'] == 'HD') { echo "checked"; } ?> >
						</div>
						<div class="form-group logo">
							<span class="btn btn-default btn-file">
							<input type="file" id="image" name="image">
							<a class="image-popup-no-margins" href="<?php echo base_url();?>uploads/game_images/<?php echo stripslashes($ads_arr[0]['image'])?>">
								<img src="<?php echo base_url();?>uploads/game_images/<?php echo stripslashes($ads_arr[0]['image'])?>" style="height:50px;width:50px;" >
							</a>
						</div> 
						<div class="row form-group">
							<div class="col-md-5">
							  <label for="standard-list1">Status</label>
								<select class="form-control" id="status" name="status">
								<option value="active" <?php echo ($ads_arr[0]['status'] == 'active') ? 'selected' : ''?>  >Active</option>
								<option value="inactive" <?php echo ($ads_arr[0]['status'] == 'inactive') ? 'selected' : ''?>>InActive</option>
							</select>  
						</div>
						</div>
                    <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="upd_ads_sbt" id="upd_ads_sbt" value="Update My Ad" />
                        <input type="hidden" name="ads_id" id="ads_id" value="<?php echo $ads_arr[0]['id'] ?>" readonly>
                    </div>
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
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
$(document).ready(function() {
    //var checkbox = $('#check').val();
			var result = $('#check').is(":checked");
			if(result){
				$('.logo').hide();
			} else {
			$('.logo').show();
		}
	$("#check").change( function() {
		var result = $(this).is(":checked");
		//alert(result)
		if(result) {
			//alert('a')   If true
			$('.logo').hide();
		} else {
			//alert('b')
			$('.logo').show();
		}
    //alert($(this).is(":checked"));
});
	
});
</script>
<script>


 $("#btn2").click(function(){
		var number = $("#number").val();
		number++;
		//console.log(number);
        $(".add").append("<label for=''>New Channel Feed ("+number+")</label><textarea rows='5' cols='159' style='border-radius:3%;' name='iframe[]' id='last1' placeholder='Iframe.....' ></textarea>");
		
		$("#number").val(number);
    });
</script>
    <script type="text/javascript">
      jQuery(document).ready(function() {
    
		//Image Gallery 
		$('.image-popup-no-margins').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			closeBtnInside: false,
			fixedContentPos: true,
			mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
			image: {
				verticalFit: true
			},
			zoom: {
				enabled: true,
				duration: 300 // don't foget to change the duration also in CSS
			}
		});

      // validate signup form on keyup and submit
		$("#add_new_slider_image_frm").validate({

            rules: {
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
				display_order : "Use digit to set a display order"
            }

		});

    });
	
    </script>

</body>
</html>
