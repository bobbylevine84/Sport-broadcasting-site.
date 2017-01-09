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
    <section id="content"> <?php echo $INC_breadcrum ; ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                            	<span class="glyphicon glyphicon-book"></span>Manage 
                            </div>
                            
                        	<ul class="nav panel-tabs">
                        		<li class="active">
                                	<a href="#shadow_box_1" data-toggle="tab">Shadow Box 1</a>
                              	</li>
                        		<li class="">
                                	<a href="#shadow_box_2" data-toggle="tab">Shadow Box 2</a>
                                </li>
                                <li class="">
                                	<a href="#shadow_box_3" data-toggle="tab">Shadow Box 3</a>
                                </li>
                                
                        	</ul>
                            
                        </div>
                        <?php
                        
						//echo '<pre>';
						//print_r($boxes_data);
						$box1_id = $boxes_data[1]['id'];
						$box1_title = $boxes_data[1]['title'];
						
						$box2_id = $boxes_data[2]['id'];
						$box2_title = $boxes_data[2]['title'];
						
						$box3_id = $boxes_data[3]['id'];
						$box3_title = $boxes_data[3]['title'];
						
						//exit;
						?>
                        
                        <div class="panel-body alerts-panel">
                            <div class="tab-content border-none padding-none">
                                <div id="shadow_box_1" class="tab-pane active">
                                	<form action="<?php echo base_url('home/manage_shadow_boxes/update_shadow_box'); ?>" method="post" >
                                    	<table border="0" class="table table-striped">
                                            <tr>
                                                <td><label>Shadow Box Content 1:</label></td>
                                                <td>
                                                    <textarea class="ckeditor form-control editor1" rows="14"  name="shadow_box_content">
                   <?php echo $box1_title;?>
                                                    </textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <div class="col-md-offset-4 col-md-4">
                                                        <input name="box_id" type="hidden" value="<?php echo $box1_id;?>" />
                                                        <input class="form-control btn btn-primary" name="" type="submit" value="Update"/>
                                                    </div>
                                                    <div class="col-md-4" >
                                                    &nbsp;
                                                    </div>
                                                </td>
                                                
                                            </tr>
    									</table>
    								</form>
                                </div>
								<div id="shadow_box_2" class="tab-pane">
									<form action="<?php echo base_url('home/manage_shadow_boxes/update_shadow_box'); ?>" method="post" >
                                    	<table border="0" class="table table-striped">
                                            <tr>
                                                <td><label>Shadow Box Content 2:</label></td>
                                                <td>
                                                    <textarea class="ckeditor form-control editor1" rows="14"  name="shadow_box_content">
                   <?php echo $box2_title;?>
                                                    </textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <div class="col-md-offset-4 col-md-4">
                                                        <input name="box_id" type="hidden" value="<?php echo $box2_id;?>" />
                                                        <input class="form-control btn btn-primary" name="" type="submit" value="Update"/>
                                                    </div>
                                                    <div class="col-md-4" >
                                                    &nbsp;
                                                    </div>
                                                </td>
                                                
                                            </tr>
    									</table>
    								</form>
                                </div>
                                <div id="shadow_box_3" class="tab-pane">
									<form action="<?php echo base_url('home/manage_shadow_boxes/update_shadow_box'); ?>" method="post" >
                                    	<table border="0" class="table table-striped">
                                            <tr>
                                                <td><label>Shadow Box Content 3:</label></td>
                                                <td>
                                                    <textarea class="ckeditor form-control editor1" rows="14"  name="shadow_box_content">
                   <?php echo $box3_title;?>
                                                    </textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <div class="col-md-offset-4 col-md-4">
                                                        <input name="box_id" type="hidden" value="<?php echo $box3_id;?>" />
                                                        <input class="form-control btn btn-primary" name="" type="submit" value="Update"/>
                                                    </div>
                                                    <div class="col-md-4" >
                                                    &nbsp;
                                                    </div>
                                                </td>
                                                
                                            </tr>
    									</table>
    								</form>
                                </div>
            
                            </div>
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


<style>


</style>

<script>
    function show_input_field()
	{
		document.getElementById('http_field').style.display = 'block';
		document.getElementById('menus').style.display = 'none';
		document.getElementById('selected_welcm_link').style.display = 'none';
	}
	function hide_input_field()
	{
		document.getElementById('menus').style.display = 'block';
		document.getElementById('http_field').style.display = 'none';
		document.getElementById('selected_welcm_link').style.display = 'none';
	}
	
	
	function show_input_field1()
	{
		document.getElementById('http_field1').style.display = 'block';
		document.getElementById('menus1').style.display = 'none';
		document.getElementById('selected_sec1_link').style.display = 'none';
	}
	function hide_input_field1()
	{
		document.getElementById('menus1').style.display = 'block';
		document.getElementById('http_field1').style.display = 'none';
		document.getElementById('selected_sec1_link').style.display = 'none';
	}
	
	
	
	function show_input_field2()
	{
		document.getElementById('http_field2').style.display = 'block';
		document.getElementById('menus2').style.display = 'none';
		document.getElementById('selected_sec2_link').style.display = 'none';
		
	}
	function hide_input_field2()
	{
		document.getElementById('menus2').style.display = 'block';
		document.getElementById('http_field2').style.display = 'none';
		document.getElementById('selected_sec2_link').style.display = 'none';
	}
	
	function show_input_field3()
	{
		document.getElementById('http_field3').style.display = 'block';
		document.getElementById('menus3').style.display = 'none';
		document.getElementById('selected_sec3_link').style.display = 'none';
		
	}
	function hide_input_field3()
	{
		document.getElementById('menus3').style.display = 'block';
		document.getElementById('http_field3').style.display = 'none';
		document.getElementById('selected_sec3_link').style.display = 'none';
	}
    </script>
    </body>
</html>
