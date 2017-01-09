<!DOCTYPE html>
<html>
<head>
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<title><?php echo $meta_title ?></title>
<meta name="keywords" content="<?php echo $meta_keywords ?>" />
<meta name="description" content="<?php echo $meta_description ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/from_builder/vendor/css/vendor.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/from_builder/dist/formbuilder.css" />
    <script src="<?php echo base_url(); ?>assets/from_builder/vendor/js/vendor.js"></script>
  <script src="<?php echo base_url(); ?>assets/from_builder/dist/formbuilder.js"></script>
<?php echo $INC_header_script_top; ?>
</head>
<body>
Start: Header -->
<header class="navbar navbar-fixed-top"> <?php echo $INC_top_header; ?> </header>
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
                    			<div class="panel-title hidden-xs"> 
                    				<span class="glyphicon glyphicon-list"></span>Add Forms
                    			</div>
                    		</div>
							<div  class="panel-body padding-bottom-none" >
							<?php
                            if($this->session->flashdata('err_message')){
                            ?>
                            <div id="error_mmsg" style="text-align:center;" class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?>
                            </div>
                            <script>
                            $('#error_mmsg').fadeOut(4000);
                            </script>
							<?php
                            }//end if($this->session->flashdata('err_message'))
                            if($this->session->flashdata('ok_message'))
							{
                            ?>
                            <div class="alert alert-success alert-dismissable">
								<?php echo $this->session->flashdata('ok_message'); ?>
                         	</div>
                            <?php 
                            }//if($this->session->flashdata('ok_message'))

                            ?>
                        <div class='fb-main'></div>
						</div>
					</div>
				
		</div>
	        
		</div>
        <div class="clearfix"></div>
    	<div class="row" style="min-height:250px;">&nbsp;</div>
    </div>
  </section>
</div><!-- End: Content --> 
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>


</body>

</html>
<script>
    $(function(){
      fb = new Formbuilder({
        selector: '.fb-main',
        
      });
/* $('.js-save-form').click(function(payload){
		alert(payload);
		});*/
		fb.on('save', function(payload){ //alert(payload);
		var payload_1 = JSON.parse( payload );
		var email=$('#email_client_1').val();
		var form_name=$('#form_name').val();
		var button_name=$('#button_name').val();
		var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
		if (email == '' || !re.test(email))
		{
		  alert('Please enter a valid email address.');
		  location.reload();
		   return false;
		}
		else
		{


var base_url = '<?php echo base_url();?>';
		
				$.ajax({
				url: base_url+'form/from_management/generate_form',
				type: 'GET',
				data: {'payload':payload_1,'email':email,'form_name':form_name,'button_name':button_name},
				success: function(data){
					if(data=='error')
					{
						location.reload();
						}
					else
					{
				     window.location=base_url+'form/from_management/all_form';
					}
				//alert(data);
				//console.log(data);
				},
				error: function (xhr, ajaxOptions, thrownError)
				{alert("ERROR:" + xhr.responseText+" - "+thrownError);}
		});  
		}
		
      })
	
    });
	
  $(document).ready(function(){
	  $('.fb-save-wrapper').append('<input type="text" class="email_client" id="email_client_1" placeholder="Email" name="Email"/>');
	  $('.fb-save-wrapper').append('<input type="text" class="form_name" id="form_name" placeholder="Form Name" name="from_name"/>');
	  $('.fb-save-wrapper').append('<input type="text" class="form_sub_button" id="button_name" placeholder="Button Name" name="button_name"/>');
	  });	
  </script>