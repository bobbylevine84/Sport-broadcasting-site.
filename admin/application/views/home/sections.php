
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
                            	<span class="glyphicon glyphicon-book"></span>Homepage Sections 
                            </div>
                            
                        	<ul class="nav panel-tabs">
                        		<li class="active">
                                	<a href="#welcome_content" data-toggle="tab">HOW IT WORKS</a>
                              	</li>
                        		<li class="">
                                	<a href="#Section_1"  data-toggle="tab">OUR FEATURES</a>
                                </li>
                                <li class="">
                                	<a href="#Section_2"  data-toggle="tab">SUPPORTED CONSOLES</a>
                                </li>
                                <li class="">
                                	<a href="#Section_3"  data-toggle="tab">WHAT WE DO</a>
                                </li>
                        	</ul>   
                        </div>
                        <div class="panel-body alerts-panel">
                            
                            <div class="tab-content border-none padding-none">
                                <div id="welcome_content" class="tab-pane active">
                                	<?php 
		$sec_desc = $adminsetting[3]['sec_desc'];
		$sec_content = $adminsetting[3]['sec_content'];	
		$sec_title = $adminsetting[3]['sec_title'];
		$link = $adminsetting[3]['link'];
		$id = $adminsetting[3]['id'];
		$iframe = $adminsetting[3]['iframe'];
		$sec_image = $adminsetting[0]['sec_image'];
		
	?>
    <form action="<?php echo base_url('home/manage_section/update_sections'); ?>" method="post" enctype="multipart/form-data">
    <table border="0" class="table table-striped">
        <tr>
            
            <td width="18%"><label>Title:</label></td>
            <td>
            	<!--<input type="text" class="form-control" value="<?php echo $sec_title; ?>" name="sec_title" />-->
            <textarea class="ckeditor form-control editor1" rows="14"  name="sec_title">
            <?php echo $sec_title;?>
            </textarea>
            </td>
        </tr>
        
        <tr>
            <td><label>Content:</label></td>
            <td>
            	<textarea class="ckeditor form-control editor1" rows="14"  name="sec_content">
                	<?php echo $sec_content;?>
            	</textarea>
            </td>
        </tr>

        
       
        

        <tr>
        	<td colspan="3">
            	<div class="col-md-offset-4 col-md-4">
                	<input name="menu_id" type="hidden" value="<?php echo $id;?>" />
                	<input class="form-control btn btn-primary" name="submit_sec" type="submit" value="Update"/>
              	</div>
                <div class="col-md-4" >
                &nbsp;
                </div>
           	</td>
            
        </tr>
    </table>
    </form>
                                </div>
                                
<div id="Section_1" class="tab-pane">

	
        <?php $this->load->view('home/sections_1'); ?>
		<!--<form action="<?php echo base_url('home/manage_section/update_sections'); ?>" method="post" enctype="multipart/form-data">
    <table border="0" class="table table-striped">
        <tr>
            <!--<td rowspan="6" width="20%" >
				<?php //echo str_replace('_',' ',ucfirst($sec_desc)) ; ?>
         	</td>
            <td width="18%"><label>Title:</label></td>
            <td>
            	<input type="text" class="form-control" value="<?php echo $sec_title; ?>" name="sec_title" />
            </td>
        </tr>
        <tr>
            <td><label>Image</label></td>
            <td>
            	<div>
                <img class="thumbnail" src="<?php echo IMG_section.stripslashes($slider_images_arr[$i]['slider_image']).$sec_image ; ?>">
                	<span class="help-block margin-top-sm">
                		<i class="fa fa-bell"></i> 
                    		- If you don't want to edit IMAGE, leave as it! 
                 	</span>
                    <span class="help-block margin-top-sm">
                		<i class="fa fa-bell"></i> 
                    		- Allowed Extensions: jpg, jpeg, gif, tiff, png
                 	</span>
                    <span class="help-block margin-top-sm">
                		<i class="fa fa-bell"></i> 
                    		- Max Upload Size: 6MB; Recommended Dimension: 350 * 150 
                 	</span>
                
<input type="file" name="sec_image" />
<input type="hidden" name="sec_curr_image" value="<?php echo $sec_image; ?>" />
<input type="hidden" value="<?php echo $iframe;?>" name="curr_iframe" />
				</div>
			</td>
        </tr>
        <tr>
            <td><label>Content:</label></td>
            <td>
            	<textarea class="ckeditor form-control editor1" rows="14"  name="sec_content">
                	<?php echo $sec_content;?>
            	</textarea>
            </td>
        </tr>
        
        <tr>
            <td><label>Readmore Link:</label></td>
            <td>
            	<div class="col-md-6">
               <select id="menu_url2" class="form-control" onChange="show_hide2();" >
                	<option value="self">Self</option>
                	<option value="other">Other</option>
            	</select>
                </div>
                <div class="col-md-6">
                	<input name="menu_url_other" type="text" style="display:none;" id="http_field1" class="form-control" placeholder="http:" />
                	<select style="display:block" name="menu_url_self" id="menus1" class="form-control">
                	<option value="<?php echo FRONT_SURL.'content/view/'?>" selected>
                    	Select Link inside website
                   	
                    </option>
					<?php
					
					foreach($self_menu as $m){ ?>
                    	
						<option value="<?php echo FRONT_SURL.'content/view/'.$m['slug_menu']; ?>">
                           	<?php echo $m['menu_name']; ?>
                        </option>
					<?php } ?>
						
            		</select>
                </div>
            </td>
        </tr>

        <tr style="" id="selected_sec1_link">
        	<td><label>Selected Readmore Link:</label></td>
            <td><label><?php echo $link; ?></label></td>
        </tr>
        
        <tr>
        	<td colspan="3">
            	<div class="col-md-offset-4 col-md-4">
                	<input name="menu_id" type="hidden" value="<?php echo $id;?>" />
                	<input class="form-control btn btn-primary" name="submit_sec" type="submit" value="Update"/>
              	</div>
                <div class="col-md-4" >
                &nbsp;
                </div>
           	</td>
            
        </tr>
    </table>
    </form>-->
   
	<?php	/*$data['sec_desc']=$sec_desc;
		$data['sec_content']=$sec_content;
		$data['sec_title']=$sec_title;
		$data['link']=$link;
		$data['sec_image']=$sec_image;
		$data['id']=$id;
		$this->load->view('home/section_1',$data);*/
		?>

</div>
                                <div id="Section_2" class="tab-pane">
                                    <?php 
										  $this->load->view('home/sections_2');
										
									
									?>
									<!--<form action="<?php echo base_url('home/manage_section/update_sections'); ?>" method="post" enctype="multipart/form-data">
									<table border="0" class="table table-striped">
										<tr>
											<td width="18%"><label>Title:</label></td>
											<td>
												<input type="text" class="form-control" value="<?php echo $sec_title; ?>" name="sec_title" />
											</td>
										</tr>
										<tr>
											<td><label>Image</label></td>
											<td>
												<div>
												<img class="thumbnail" src="<?php echo IMG_section.stripslashes($slider_images_arr[$i]['slider_image']).$sec_image ; ?>">
                                                <span class="help-block margin-top-sm">
                		<i class="fa fa-bell"></i> 
                    		- If you don't want to edit IMAGE, leave as it! 
                 	</span>
                    <span class="help-block margin-top-sm">
                		<i class="fa fa-bell"></i> 
                    		- Allowed Extensions: jpg, jpeg, gif, tiff, png
                 	</span>
                    <span class="help-block margin-top-sm">
                		<i class="fa fa-bell"></i> 
                    		- Max Upload Size: 6MB; Recommended Dimension: 350 * 150 
                 	</span>
                    	<input type="file" name="sec_image" />
                   		<input type="hidden" name="sec_curr_image" value="<?php echo $sec_image; ?>" />
                        <input type="hidden" value="<?php echo $iframe;?>" name="curr_iframe" />
												</div>
											</td>
										</tr>
										<tr>
											<td><label>Content:</label></td>
											<td>
												<textarea class="ckeditor form-control editor1" rows="14"  name="sec_content">
													<?php echo $sec_content;?>
												</textarea>
											</td>
										</tr>
										
										<tr>
											<td><label>Readmore Link:</label></td>
											<td>
												<div class="col-md-6">
												<select id="menu_url3" class="form-control" onChange="show_hide3();" >
													<option value="self">Self</option>
													<option value="other">Other</option>
												</select>
												</div>
												<div class="col-md-6">
													<input name="menu_url_other" type="text" style="display:none;" id="http_field2" class="form-control" placeholder="http:" />
													<select style="display:block" name="menu_url_self" id="menus2" class="form-control">
													<option value="<?php echo FRONT_SURL.'content/view/'?>" selected>Select Link inside website</option>
													<?php
															/*echo '<pre>dsafsa';
															print_r($self_menu);
															exit;*/
													foreach($self_menu as $m){ ?>
														<option value="<?php echo FRONT_SURL.'content/view/'.$m['slug_menu']; ?>">
															<?php echo $m['menu_name']; ?>
														</option>
													<?php } ?>
														
													</select>
												</div>
											</td>
										</tr>
                                        
                                        
                                        <tr style="" id="selected_sec2_link">
                                            <td><label>Selected Readmore Link:</label></td>
                                            <td><label><?php echo $link; ?></label></td>
                                        </tr>
											<td colspan="3">
												<div class="col-md-offset-4 col-md-4">
													<input name="menu_id" type="hidden" value="<?php echo $id;?>" />
													<input class="form-control btn btn-primary" name="submit_sec" type="submit" value="Update"/>
												</div>
												<div class="col-md-4" >
												&nbsp;
												</div>
											</td>
											
										</tr>
									</table>
									</form>-->
                                </div>
	<div id="Section_3" class="tab-pane">
    
           <?php 
		 $this->load->view('home/sections_3');
	?>
    <!--<form action="<?php echo base_url('home/manage_section/update_sections'); ?>" method="post" enctype="multipart/form-data">
    <table border="0" class="table table-striped">
        <tr>
            <!--<td rowspan="6" width="20%" >
				<?php //echo str_replace('_',' ',ucfirst($sec_desc)) ; ?>
         	</td>
            <td width="18%"><label>Title:</label></td>
            <td>
            	<input type="text" class="form-control" value="<?php echo $sec_title; ?>" name="sec_title" />
            </td>
        </tr>
		
		<tr>
			<td><label>Sidebar Contents:</label></td>
            <td>
            	<textarea class="ckeditor form-control editor1" rows="14"  name="iframe">
                	<?php echo $iframe;?>
            	</textarea>
            </td>
		</tr>
		
							<!-- Start -->
        <!-- <tr>
            <td><label>Video</label></td>
            <td>
            	<div>
                <embed style="margin-left:10px;" width="420" height="240" src="<?php //echo $iframe;?>"> -->
				
								<!-- End -->
				<!--<video class="thumbnail" controls="" height="240" width="360">
            		<source src="" type="video/mp4">
        		</video>-->

								<!-- Start -->
								
				<!-- <span class="help-block margin-top-sm">
                		<i class="fa fa-bell"></i> 
                    		- If you want to change the video,Enter its link in below field! 
                 	</span>
                    
<input class="form-control" type="text" placeholder="<?php //echo $iframe;?>" value="<?php //echo $iframe;?>" name="iframe" /> 

<input type="hidden" value="<?php echo $iframe;?>" name="curr_iframe" />-->
				
				<!-- </div>
			</td>
        </tr> 
								
		
        <tr>
            <td><label>Content:</label></td>
            <td>
            	<textarea class="ckeditor form-control editor1" rows="14"  name="sec_content">
                	<?php echo $sec_content;?>
            	</textarea>
            </td>
        </tr>
        
        
        <tr>
            <td><label>Readmore Link:</label></td>
            <td>
            	<div class="col-md-6">
                <select id="menu_url4" class="form-control" onChange="show_hide4();" >
                	<option value="self">Self</option>
                	<option value="other">Other</option>
            	</select>
                </div>
                <div class="col-md-6">
                	<input name="menu_url_other" type="text" style="display:none;" id="http_field3" class="form-control" placeholder="http:" />
                	<select style="display:block" name="menu_url_self" id="menus3" class="form-control">
                	<option value="<?php echo FRONT_SURL.'content/view/'?>" selected>Select Link inside website</option>
					<?php
					/*
					[menu_url] => http://dev.ejuicysolutions.com/blackbull/admin/content/view
					[menu_name] => Financial Services Guide
					[slug_menu] => financial-services-guide    	
					*/
					foreach($self_menu as $m){ ?>
                    	<option value="<?php echo FRONT_SURL.'content/view/'.$m['slug_menu']; ?>">
                           	<?php echo $m['menu_name']; ?>
                        </option>
					<?php } ?>
						
            		</select>
                </div>
            </td>
        </tr>
        
        
        <tr style="" id="selected_sec3_link">
        	<td><label>Selected Readmore Link:</label></td>
            <td><label><?php echo $link; ?></label></td>
        </tr>
        
        
        <tr>
        	<td colspan="3">
            	<div class="col-md-offset-4 col-md-4">
                	<input name="menu_id" type="hidden" value="<?php echo $id;?>" />
                	<input class="form-control btn btn-primary" name="submit_sec" type="submit" value="Update"/>
              	</div>
                <div class="col-md-4" >
                &nbsp;
                </div>
           	</td>
            
        </tr>
    </table>
    </form>-->
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
    function show_hide1()
	{
		if($('#menu_url1').val() == "self") {
			document.getElementById('menus').style.display = 'block';
			document.getElementById('http_field').style.display = 'none';
			document.getElementById('selected_welcm_link').style.display = 'none';
		}
		if($('#menu_url1').val() == "other") {
			document.getElementById('http_field').style.display = 'block';
			document.getElementById('menus').style.display = 'none';
			document.getElementById('menu_url_self').style.display = 'none';
			document.getElementById('selected_welcm_link').style.display = 'none';
		}	
	}
	function show_hide2()
	{
		if($('#menu_url2').val() == "self") {
			document.getElementById('menus1').style.display = 'block';
			document.getElementById('http_field1').style.display = 'none';
			document.getElementById('selected_sec1_link').style.display = 'none';
		}
		if($('#menu_url2').val() == "other") {
			document.getElementById('http_field1').style.display = 'block';
			document.getElementById('menus1').style.display = 'none';
			document.getElementById('selected_sec1_link').style.display = 'none';
		}	
	}	
	function show_hide3()
	{
		if($('#menu_url3').val() == "self") {
			document.getElementById('menus2').style.display = 'block';
			document.getElementById('http_field2').style.display = 'none';
			document.getElementById('selected_sec2_link').style.display = 'none';
		}
		if($('#menu_url3').val() == "other") {
			document.getElementById('http_field2').style.display = 'block';
			document.getElementById('menus2').style.display = 'none';
			document.getElementById('selected_sec2_link').style.display = 'none';
		}	
	}
	function show_hide4()
	{
		if($('#menu_url4').val() == "self") {
			document.getElementById('menus3').style.display = 'block';
			document.getElementById('http_field3').style.display = 'none';
			document.getElementById('selected_sec3_link').style.display = 'none';
		}
		if($('#menu_url4').val() == "other") {
			document.getElementById('http_field3').style.display = 'block';
			document.getElementById('menus3').style.display = 'none';
			document.getElementById('selected_sec3_link').style.display = 'none';
		}	
	}
	
/*	function load_why_us()
	{

		$("#Section_1").load(base_url+"home/manage_section/section_1");
		
		}
		
  function getting_start()
  {
	  
	  $("#Section_2").load(base_url+"home/manage_section/section_2");
	  }	
	  
  function video_home_page()
  {
	  
	  $("#Section_3").load(base_url+"home/manage_section/section_3");
	  }	*/  
	
    </script>
    </body>
</html>
