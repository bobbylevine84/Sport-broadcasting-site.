<?php 
$session_post_data = $this->session->userdata('add-new-menu-data');
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
                            <div class="panel-title">
                            	<span class="glyphicon glyphicon-book"></span> Add New Menu 
                            </div>
                        	<ul class="nav panel-tabs">
                        		<li class="active">
                                	<a href="#data_content" data-toggle="tab">Data Contents</a>
                              	</li>
                        		<!--<li class="">
                                	<a href="#seo_content" data-toggle="tab">SEO Contents</a>
                                </li>-->
                        	</ul>
                        </div>
                        <div class="panel-body alerts-panel">
                            <form class="cmxform" id="add_new_menu_frm" method="POST" 
                            	action="<?php echo SURL?>menu/manage-menu/add-new-menu-process">
                                <div class="tab-content border-none padding-none">
                                    <div id="data_content" class="tab-pane active">
										<?php
                                        if($this->session->flashdata('err_message'))
										{
                                        ?>
                                        <div class="alert alert-danger">
											<?php echo $this->session->flashdata('err_message'); ?>
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
                                        <div class="form-group">
                                        	<label for="menu_name">Menu Name *</label>
                                        	<input maxlength="25" id="menu_name" name="menu_name" type="text" class="form-control" placeholder="Menu Name" value="<?php //echo $session_post_data['menu_name'] ?>" />
                                        </div>
<!--<div class="row form-group">
    <div class="col-md-11">
        <label for="standard-list1">Select Menu Parent</label>
        <select class="form-control" id="parent_id" name="parent_id" style="font-size:12px">
            <option value="" selected >Select Parent Menu</option>
            <option value="0" >It Self Parent</option>
            
            <?php
            
           // for($i=0;$i<$menu_parent_list_count;$i++){
            ?>
            <option 
            title="<?php// echo $menu_parent_list_arr[$i]['menu_name'] ?>" 
            value="<?php //echo $menu_parent_list_arr[$i]['id'] ?>" 
			<?php //echo ($menu_arr['parent_id'] == $menu_parent_list_arr[$i]['id']) ? 'selected' : ''?>>
			<?php //echo stripslashes($menu_parent_list_arr[$i]['menu_name']) ?></option>
            <?php		
            //}//end for
            
            ?>
        </select>
    </div>
</div>-->
                                        
                                        <input type="hidden" id="parent_id" name="position_id[]" value="Header">
                                        <!--
                                        <div class="row form-group">
                                            <div class="col-md-11">
                                                <label for="standard-list1">Menu Position</label>
                                                <select multiple class="form-control" id="parent_id" name="position_id[]" style="font-size:12px">
                                                    <option value="Top Header">TopHeader</option>
                                                    <option value="Header" selected>Header</option>
                                                    <option value="Footerwidget1">Footerwidget1</option>
                                                    <option value="Footerwidget2">Footerwidget2</option>
                                                    <option value="Footerwidget3">Footerwidget3</option>
                                                    <option value="Footerwidget4">Footerwidget4</option>
                                                    <option value="Footerwidget5">Footerwidget5</option>
													<option value="Footerwidget6">Footerwidget6</option>
                                                    <option value="FooterBottom">FooterBottom</option>
                                                </select>
                                            </div>
                                        </div>
										-->
                                        
                                        
   <!-- 
    <div class="row form-group">
    <label class="col-md-11">Menu Path</label>
    <div class="col-xs-3">
    	<select id="menu_url" class="form-control">
        	<option onClick="hide_input_field();">Self</option>
            <option onClick="show_input_field();">Other</option>
        </select>
    </div>
    <div class="col-xs-3">
    <input name="menu_url" type="text" style="display:none;" id="http_field" class="form-control" placeholder="http:" />
    </div>
    
    </div>-->
                                        
                                        
                                        
                                        <div class="row form-group">
                                        	<label class="col-md-11 text-left">Display Order</label>
                                        	<div class="col-xs-3">
                                        		<input type="text" name="display_order" id="display_order" value="<?php echo ($session_post_data['display_order'] != 0) ? $session_post_data['display_order'] : 0 ?>" class="form-control">
                                        	</div>
                                        </div>
                                        
                                        <div class="row form-group">
                                        
                                            <div class="col-md-3">
                                                <label for="standard-list1">Status</label>
                                                <select class="form-control" id="status" name="status">
                                                <option value="1" <?php echo ($session_post_data['status'] == 1 ) ? 'selected' : ''?>  >Active</option>
                                                <option value="0" <?php echo ($session_post_data['status'] == 0 && isset($session_post_data['status'])) ? 'selected' : ''?>>InActive</option>
                                                </select>
                                            </div>
                                        </div>                      
                                    </div>
                                <div id="seo_content" class="tab-pane">
                                    <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <input id="meta_title" name="meta_title" type="text" class="form-control" value="<?php echo $session_post_data['meta_title'] ?>" placeholder="Meta Title"/>
                                    </div>
                                    
                                    <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3"><?php echo $session_post_data['meta_keywords'] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3"><?php echo $session_post_data['meta_description'] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                    <label for="menu_description">Menu Description</label>
                                    </div>
                                    <div class="form-group">
                                    <textarea class="ckeditor editor1"  id="menu_description" name="menu_description" rows="14"><?php echo $session_post_data['menu_description'] ?></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                    <label for="seo_url_name">SEO URL Name</label>
                                    <input id="seo_url_name" name="seo_url_name" type="text" class="form-control" readonly />
                                    <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> Change in URL string, will loose its identity in Search Engines</span>
                                    </div>
                                </div>
                                <div class="form-group pull-right"  style="margin-right:50px">
                                <input class="submit btn btn-blue" type="submit" name="add_new_menu_sbt" id="add_new_menu_sbt" value="Add New Menu" />
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
    <script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
        $("#add_new_menu_frm").validate({
            rules: {
                menu_name: "required",
                parent_id: "required",
				display_order: {
					required: false,
					digits: true

				},
                
            },
			
            messages: {
                menu_name: "Enter Menu Name.",
                parent_id: "Select Parent Menu.",
				display_order : "Use digit to set a display order"
            }
        });
    
    });
    </script>
    <script>
    function show_input_field()
	{
		document.getElementById('http_field').style.display = 'block';
	}
	function hide_input_field()
	{
		document.getElementById('http_field').style.display = 'none';
	}
    </script>

</body>
</html>
