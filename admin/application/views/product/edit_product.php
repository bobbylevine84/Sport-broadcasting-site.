<?php 
$session_post_data = $this->session->userdata('add-page-data');
?>
<!DOCTYPE html>
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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Product </div>
              
            </div>
            
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL ?>product/manage_product/update_product_process/" enctype="multipart/form-data">
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
                        <label for="page_short_desc">Title</label>
                        <input type="text" value="<?php echo $product[0]['product_title'];?>" name="title" class="form-control">
                      </div>

                      <div class="form-group">
                        <label for="page_short_desc">Description</label>
                        <textarea class="ckeditor form-control editor1" rows="14"  id="slider_caption" name="description" ><?php echo $product[0]['description'];?></textarea>
                      </div>
					 <div class="form-group" style="padding-left: 0px;">
                                    <label for="brand"><b>Brand</b></label>
                                    <input id="brand" value="<?php echo $product[0]['brand_name'];?>" name="brand" type="text" class="form-control" style="width:50%;"/>
									<input id="brand1" name="brand1" type="hidden" class="form-control" />
									<div id="empty-message"></div>
                                    
                                </div>
					  <div class="form-group">
                        <label for="page_short_desc">Product Type</label>
                        <input type="text" value="<?php echo $product[0]['product_type'];?>" id="product_type" name="product_type" class="form-control" style="width:50%;">
						<input id="product_type1" name="product_type1" type="hidden" class="form-control" />
									<div id="empty-message"></div>
						<div id="empty-message1"></div>
                      </div>
                      <div class="row form-group">
                      <label class="col-md-11 text-left">Thumb Image</label>
                      <div class="col-xs-3">
                        <input type="file" name="upload" accept="image/*" />
						<input type="hidden" name="upload1" value="<?php echo $product[0]['image'];?>" accept="image/*" />
                      </div>
                    </div>
					 <div class="form-group col-md-12">
                            <div class="col-md-6">
                                <div class="col-md-9" style="padding-left: 0px;">
                                    <label for="flavour"><b>Flavour</b></label>
                                    <input style="float:left;" id="flavour" name="flavour" type="text" class="form-control" />
									<input id="flavour1" name="flavour1" type="hidden" class="form-control" />
									<input id="flavour2" name="flavour2" type="hidden" class="form-control" />
									<input id="flavour_icon" name="flavour_icon" type="hidden" class="form-control" />
									<input id="flavour_icon1" name="flavour_icon1" type="hidden" class="form-control" />
									
									<div id="empty-message2"></div>
                                    <span>Space are not allowed in tag</span>
                                </div>
								<div class="col-md-3" style="margin-top:25px;">
								<img width="20px" height="20px" id="flavour_img" src="" class="ui-state-default" alt=""/>
								</div>
                            </div>
                            <div class="col-md-6">                                
                                <div class="form-group pull-right"  style="margin-right:50px; margin-top:30px">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="flavour">&nbsp;</label>
                                <ul id="selected_flavors" class="list-inline">
								<?php if(!empty($product)){ foreach($product as $row){?>
								 <li class="tags_li" style="background-color: green; color: #fff; padding: 10px; margin: 0 5px 5px 0;"><?php echo $row['flavour_name'];?><img width="20px" height="20px" id="flavour_img" src="<?php echo SUR?>uploads/section/<?php echo $row['flavour_image'];?>" class="ui-state-default" alt=""/><a href="javascript:;" data-tag="<?php echo $row['flavour_name'];?>" class="glyphicon glyphicon-remove remove_tag_li" style="top: -10px; right: -10px; color: #fff;"></a><input type="hidden" name="selected_flavors[]" value="<?php echo $row['flavour_name'];?>"></li>
								<?php }}elseif(!empty($exist_tg)) { foreach($exist_tg as $tag) { ?>
                                        <li class="tags_li" style="background-color: green; color: #fff; padding: 10px; margin: 0 5px 5px 0;"><?php echo $tag; ?><a href="javascript:;" data-tag="<?php echo $tag; ?>" class="glyphicon glyphicon-remove remove_tag_li" style="top: -10px; right: -10px; color: #fff;"></a><input type="hidden" name="selected_flavors[]" value="<?php echo $tag; ?>"></li>
                                    <?php } } ?>
                                </ul>
                            </div>
                        </div>
                                         
                  </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="update_product" id="update_product" value="Update Product" />
						<input class="submit btn btn-blue" type="hidden" name="product_id" id="product_id" value="<?php echo $product[0]['p_id'];?>" />
                    </div>
                </div>
				
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
	<div id="addimage" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
        <h4 class="modal-title">Add Flavour Image</h4>
      </div>
      <div class="modal-body">
          <input type="file" name="upload_image" id="upload_image" class="form-control" />
		  
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" id="submit_post_btn" data-dismiss="modal">Done</button>
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
    <script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
		$("#add_new_slider_image_frm").validate({

            rules: {
				display_order: {
					required: false,
					digits: true
				},
            },

            messages: {
				display_order : "Use digit to set a display order"
            }

		});

		$("#slider_image").rules(
		 	"add", {
			 required:true,
			 extension: "jpg|jpeg|gif|tiff|png",
         	messages: {
				extension : "Please select valid image for epaper pages(Use: jpg, jpeg, gif, tiff, png)",
         }
      	});
		
    
    });
	var tags_array = [];	
	<?php		
	if(!empty($product)) {  foreach($product as $row) { ?>
            tags_array.push("<?php echo $row['flavour_name']; ?>");
	<?php }}elseif(!empty($exist_tg)) { foreach($exist_tg as $tag) { ?>
            tags_array.push("<?php echo $tag; ?>");
        <?php } } ?>
		 var publications_array = [];
        <?php if(!empty($selected_publication)) { foreach($selected_publication as $key => $publication) { if(is_numeric($publication)) { ?>
            publications_array['<?php echo $selected_pubnames[$key]; ?>'] = '<?php echo $publication; ?>';
        <?php }else { ?>
            publications_array['<?php echo $publication; ?>'] = '<?php echo $publication; ?>';
        <?php } } } ?>
	        $("#flavour").keyup(function (e) {
            if (e.which === 32) {
                alert('Space are not allowed in tag!');
                var str = $(this).val();
                str = str.replace(/\s/g, '');
                $(this).val(str);
            }
        }).blur(function () {
            var str = $(this).val();
            str = str.replace(/\s/g, '');
            $(this).val(str);
        });
        
        $("#add_tag").click(function () {
            if ($("#flavour").val() != "") {
                if (jQuery.inArray($("#flavour").val(), tags_array) == -1) {
                    tags_array.push($("#flavour").val());
                    $("#selected_flavors").append('<li class="tags_li" style="background-color: green; color: #fff; padding: 10px; margin: 0 5px 5px 0;">' + $("#flavour").val() + '&nbsp;<img width="20px" height="20px" id="flavour_img" src="<?php echo SUR?>uploads/section/'+$("#flavour_icon").val()+'" class="ui-state-default" alt=""/><a href="javascript:;" data-tag="' + $("#flavour").val() + '" class="glyphicon glyphicon-remove remove_tag_li" style="top: -10px; right: -10px; color: #fff;"></a><input type="hidden" name="selected_flavors[]" value="' + $("#flavour").val() + '"><input type="hidden" name="selected_images[]" value="' + $("#flavour_icon").val() + '"></li>');
                } else {
                    alert("Tag already selected");
                }
            } else {
                alert("Can not add empty tag!");
            }
        });
		$(document).on("click", ".remove_tag_li", function () {
            tags_array.splice($.inArray($(this).data("tag"), tags_array), 1);
            $(this).parent().remove();
        });
		
		 $("#brand").autocomplete({
            source: "<?php echo base_url(); ?>product/manage_product/get_brands_name",
			 select: function (event, ui) {
                $("#brand1").val(ui.item.id);
				if(ui.item.id == -1)
				{
					var brand= $("#brand").val();
					
					 $.getJSON("<?php echo base_url(); ?>product/manage_product/add_brand/",{brand : brand}, function(data){
						 if(data == 1)
						 {
							 $("#brand").val(brand);
						 }
		});
				}
            }
        });
		 $("#product_type").autocomplete({
            source: "<?php echo base_url(); ?>product/manage_product/get_brands_type",
			 select: function (event, ui) {
                $("#product_type1").val(ui.item.id);
				if(ui.item.id == -1)
				{
					var product_type= $("#product_type").val();
					$.getJSON("<?php echo base_url(); ?>product/manage_product/add_product_type/",{product_type : product_type}, function(data){
						 if(data == 1)
						 {
							 $("#product_type").val(product_type);
						 }
					});
				}
            }
        });
		/* $("#flavour").autocomplete({
            source: "<?php echo base_url(); ?>product/manage_product/get_flavor"
        });*/

		    $( "#flavour" ).autocomplete({
      minLength: 0,
      source:"<?php echo base_url(); ?>product/manage_product/get_flavor",
      select: function( event, ui ) {
		  var flavour= $("#flavour").val();
		 $("#flavour1").val(ui.item.id);
		 if(ui.item.id == -1)
				{
				$("#flavour2").val(flavour);
				$("#addimage").modal("show");
				}
				else{
        $( "#flavour" ).val( ui.item.label );
		$( "#flavour_img" ).attr( "src", "<?php echo SUR?>uploads/section/" + ui.item.icon );
		$( "#flavour_icon" ).val( ui.item.icon );
		
		
		
		
		if ($("#flavour").val() != "") {
                if (jQuery.inArray($("#flavour").val(), tags_array) == -1) {
                    tags_array.push($("#flavour").val());
                    $("#selected_flavors").append('<li class="tags_li" style="background-color: green; color: #fff; padding: 10px; margin: 0 5px 5px 0;">' + $("#flavour").val() + '&nbsp;<img width="20px" height="20px" id="flavour_img" src="<?php echo SUR?>uploads/section/'+$("#flavour_icon").val()+'" class="ui-state-default" alt=""/><a href="javascript:;" data-tag="' + $("#flavour").val() + '" class="glyphicon glyphicon-remove remove_tag_li" style="top: -10px; right: -10px; color: #fff;"></a><input type="hidden" name="selected_flavors[]" value="' + $("#flavour").val() + '"><input type="hidden" name="selected_images[]" value="' + $("#flavour_icon").val() + '"></li>');
                } else {
                    alert("Tag already selected");
                }
            } else {
                alert("Can not add empty tag!");
            }
		
		
		
		
		
		
				}
 
        return false;
      }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.label + "<br>" + item.icon + "</a>" )
        .appendTo( ul );
    };
	</script>
	<script>
	$("#submit_post_btn").click(function() {
		var flavour1= $("#flavour2").val();
		//var file = $('#upload_image')[0].files[0];
		//$( "#flavour_icon1" ).val(file.name);
                    var formdata = new FormData();
                   jQuery.each($('#upload_image')[0].files, function(i, file) {
                        formdata.append('c_img', file);
						
                    });
                    formdata.append("flavour", $("#flavour2").val());
		   $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>product/manage_product/add_flavor/",  
                        data: formdata,	
                        contentType: false,
                        processData: false,						
                        success: function(data)
                        {
							
							var obj = JSON.parse(data);
							if(data != '')
							{
								$( "#flavour_icon1" ).val(obj[0].flavour_image);
								//location.reload();
								$("#flavour").val('');
								//$("#flavour").val(flavour1);
								
								if ($("#flavour2").val() != "") {
                if (jQuery.inArray($("#flavour2").val(), tags_array) == -1) {
                    tags_array.push($("#flavour2").val());
                    $("#selected_flavors").append('<li class="tags_li" style="background-color: green; color: #fff; padding: 10px; margin: 0 5px 5px 0;">' + $("#flavour2").val() + '&nbsp;<img width="20px" height="20px" id="flavour_img" src="<?php echo SUR?>uploads/section/'+$("#flavour_icon1").val()+'" class="ui-state-default" alt=""/><a href="javascript:;" data-tag="' + $("#flavour2").val() + '" class="glyphicon glyphicon-remove remove_tag_li" style="top: -10px; right: -10px; color: #fff;"></a><input type="hidden" name="selected_flavors[]" value="' + $("#flavour2").val() + '"><input type="hidden" name="selected_images[]" value="' + $("#flavour_icon").val() + '"></li>');
                } else {
                    alert("Tag already selected");
                }
            } else {
                alert("Can not add empty tag!");
            }
							}
							else{
								alert("image cannot be uploaded ");
							}
                        }
		   });
		});
	 /* function addbrand(){
	var brand= $("#brand").val();
	  $.getJSON("<?php echo base_url(); ?>product/manage_product/add_brand/",{brand : brand}, function(data){
		});
  }
  //////////////////
  	  function addbrand_type(){
	var product_type= $("#product_type").val();
	  $.getJSON("<?php echo base_url(); ?>product/manage_product/add_product_type/",{product_type : product_type}, function(data){
		});
  }
    	  function add_flavor(){
			  
	var flavour= $("#flavour").val();
	  $.getJSON("<?php echo base_url(); ?>product/manage_product/add_flavor/",{flavour : flavour}, function(data){
		});
  }*/
	</script>

</body>
</html>
