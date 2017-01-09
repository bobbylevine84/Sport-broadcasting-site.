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
<!--Start: Header -->
<header class="navbar navbar-fixed-top"> <?php echo $INC_top_header; ?> </header>
<div id="main"> 
  <!-- Start: Sidebar --> 
  <?php echo $INC_left_nav_panel; ?> 
  <!-- End: Sidebar --> 
  <!-- Start: Content -->
  <section id="content"> 
  		<?php echo $INC_breadcrum?>
  	<div class="container">
    	<div class="row">
        	<div class="col-md-12">
				<div class="panel panel-visible">
               		
                    <div class="panel-heading">
                    	<div class="panel-title hidden-xs"> 
                    		<span class="glyphicon glyphicon-list"></span>Edit Form
                    	</div>
                  	</div>
					
                    <div class="panel-body padding-bottom-none">
						<?php
							if($this->session->flashdata('err_message')){
							?>
							<div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?>
							</div>
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
                        <!--<form action="<?php echo base_url('templates/email/update_process') ;?>" method="post">
                                <?php 
                                
                                foreach($result_form as $t)
                                {?>
                                <div class="from-group">
                                <label>Subject</label>
                                <input type="text" class="form-control" value="" name="subject" />
                                </div>
                                <div class="from-group">
                                <label>Template</label>
                                <textarea class="ckeditor editor1"  id="page_long_desc" name="template" rows="14"></textarea>
                                </div>
                                
                                <div class="from-group">
                                <br/>
                                <input type="hidden" name='id' value="">
                                <input type="submit" value="Update" class="btn btn-primary pull-right" />
                                </div>
                                <?php }
                                
                                ?>
                     	</form>-->
                         <?php

      if(!empty($form_data[0]->form_id))
	  {
		   $from_id=$form_data[0]->form_id;
		  $this->db->where('form_id',$from_id);
		  $form_fields=$this->db->get('kt_forms_detail')->result();
		
		 ?>
         <script>

   // var form_details = '<?php echo json_encode($form_fields); ?>';
   
		 <!--var field_type=new Array("<?php foreach($form_fields as $row){ echo $row->field_type;} ?>");-->
		 
         </script>
         <?php
		  }
 ?>   
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
	//alert(<?php $form_fields; ?>)
		//var form_fields=<?php $form_fields; ?>;
		//alert(form_fields);
      fb = new Formbuilder({
        selector: '.fb-main',
	     <?php if(!empty($form_data[0]->form_id))
	  {
		   $from_id=$form_data[0]->form_id;
		  $this->db->where('form_id',$from_id);
		  $form_fields=$this->db->get('kt_forms_detail')->result();
	  }
		  ?>
          bootstrapData: [
		  <?php foreach($form_fields as $row_1){ ?>
		  {
            "label": "<?php echo $row_1->label; ?>",
            "field_type": "<?php echo $row_1->field_type; ?>",
            "required":<?php echo $row_1->required; ?>,
			"size": "<?php echo $row_1->size; ?>",
            "field_options": {
                "options": [
				<?php  $id=$row_1->id;
				      if(!empty($id))
					   {
						   $this->db->where('form_detail_id',$id);
						   $option_detail=$this->db->get('kt_forms_detail_options')->result();
						   if(!empty($option_detail))
						   {
							  foreach($option_detail as $row_2)
							   {
								 if(!empty($row_2->option_name))
								 {  
								   ?>
								{
									"label": "<?php echo $row_2->option_name; ?>",
									//"size": "<?php echo $row_2->field_size; ?>",
									"checked": <?php echo $row_2->option_type; ?>
								},
				
								   <?php
								 }
								   }
							   
							   }
						   }
				 ?>
				
				],
                
            
				
								   
            
				
				},
           //"cid": "c1"
          },
		 <?php } ?>
		  ]
			/*$.each(json, function(form_details, obj) {
			alert(obj.id);
			alert(obj.field_type);
			});	*/
       
      });
/* $('.js-save-form').click(function(payload){
		alert(payload);
		});*/
		fb.on('save', function(payload){ //alert(payload);
		var payload_1 = JSON.parse( payload );
		var email=$('#email_client_1').val();
		var form_name=$('#form_name').val();
		var form_id =$('#form_id').val();
		var button_name=$('#button_name').val();
		var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
		if (email == '' || !re.test(email))
		{
		  alert('Please enter a valid email address.');
		   return false;
		}
		else
		{
			
		
				$.ajax({
				url: base_url+'form/from_management/edit_current_form',
				type: 'GET',
				data: {'payload':payload_1,'email':email,'form_name':form_name,'form_id':form_id,'button_name':button_name},
				success: function(data){
					window.location=base_url+'form/from_management/all_form';
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
	  $('.fb-save-wrapper').append('<input type="text" class="email_client" id="email_client_1" value="<?php echo @$form_data[0]->email; ?>" placeholder="Email" name="Email"/>');
	  $('.fb-save-wrapper').append('<input type="text" class="form_name" id="form_name" value="<?php echo @$form_data[0]->form_name; ?>" placeholder="Form Name" name="from_name"/>');
	$('.fb-save-wrapper').append('<input type="text" class="form_sub_button" id="button_name" placeholder="Button Name" value="<?php echo @$form_data[0]->button_name; ?>" name="button_name"/>');
	  $('.fb-save-wrapper').append('<input type="hidden" class="" id="form_id" value="<?php echo @$form_data[0]->form_id; ?>"  name="form_id"/>');
	  });	
  </script>