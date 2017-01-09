
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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit Channel</div>
			  <a href="<?php echo base_url('channel/manage_channel/'); ?>">
					<div class="panel-title hidden-xs pull-right">
						<span class="glyphicon glyphicon-hand-left"></span>
						Go Back
					</div>
				</a>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL?>channel/manage_channel/edit_channel_process" enctype="multipart/form-data">
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
                    ?>
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input type="text"  value="<?php echo stripslashes($channel_arr[0]['name']) ?>" placeholder="" class="form-control" name="name" id="name" required>
                    </div>
					 <div class="form-group">
                        <label for="description">Description *</label>
                        <input type="text"  value="<?php echo stripslashes($channel_arr[0]['description']) ?>" placeholder="" class="form-control" name="description" id="description" required>
                    </div>
                    <div class="form-group">
						<span class="btn btn-default btn-file">
						<input type="file" id="upload" name="upload">
						<a class="image-popup-no-margins" href="<?php echo base_url();?>uploads/game_images/<?php echo stripslashes($channel_arr[0]['logo'])?>">
							<img src="<?php echo base_url();?>uploads/game_images/<?php echo stripslashes($channel_arr[0]['logo'])?>" style="height:50px;width:50px;" >
						</a>
                    </div> <label for="">Main Channel Feed *</label>
					<div class="row form-group">
						<div class="wrapper" id="input_embed">
							<div class="form-group">
								<textarea style="margin-left:10px; border-radius:3px;" rows="5" cols="159" style="border-radius:3%;" name="main_frame" placeholder="Enter Feed....." required><?php echo $channel_arr[0]['main_frame'];?></textarea>
							</div>
						</div>
					</div>
					<?php
					
					$this->db->where('channel_id',$channel_arr[0]['id']);
					$frames = $this->db->get('kt_channel_feeds')->result_array();
					$i=1;
					foreach($frames As $channel){?>
					<label for="">Channel Feed (<?php echo $i; ?>)*</label>
					<div class="row form-group">
						<div class="wrapper" id="input_embed">
							<div class="form-group">
								<textarea style="margin-left:10px; border-radius:3px;" rows="5" cols="159" style="border-radius:3%;" name="iframe[]" placeholder="Enter Feed....." ><?php echo $channel['iframe_feeds'];?></textarea>
								
							</div>
						</div>
					</div>
					<input type="hidden" id="number" value="<?php $i;?>">
					<?php $i++; }
					
					?><div class="add" style="display:block;" id="add"></div>
					<a href="javascript:;" class="btn btn-success glyphicon-plus" id="btn2"></a>
					
					
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="approved" <?php echo ($channel_arr[0]['channel_status'] == 'approved') ? 'selected' : ''?>  >Approved</option>
                            <option value="pending" <?php echo ($channel_arr[0]['channel_status'] == 'pending') ? 'selected' : ''?>>Pending</option>
                        </select>
                        </div>
                    </div>                      
                  </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="upd_news_sbt" id="upd_channel_sbt" value="Update Channel" />
                        <input type="hidden" name="channel_id" id="channel_id" value="<?php echo $channel_arr[0]['id'] ?>" readonly>
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
