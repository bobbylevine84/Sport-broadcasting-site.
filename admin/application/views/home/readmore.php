
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
                            	<span class="glyphicon glyphicon-book"></span>Homepage Readmore Sections 
                            </div>   
                        </div>
                        <div class="panel-body alerts-panel">
                            <?php
                                                if ($this->session->flashdata('err_message')) {
                                                    ?>
                                                    <div id="message" class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?>
                                                    </div>
                                                    <?php
                                                }//end if($this->session->flashdata('err_message'))
                                                if ($this->session->flashdata('ok_message')) {
                                                    ?>
                                                    <div id="message" class="alert alert-success alert-dismissable">
                                                        <?php echo $this->session->flashdata('ok_message'); ?>
                                                    </div>
                                                    <?php
                                                }//if($this->session->flashdata('ok_message'))
                                                ?>
                            
                        <form action="<?php echo base_url('home/manage_section/update_readmore'); ?>" method="post" enctype="multipart/form-data">
    <table border="0" class="table table-striped">
        <tr>
            
            <!--<td width="18%"><label>Title:</label></td>-->
<!--            <td>
            	<input type="text" class="form-control" value="<?php //echo $sec_title; ?>" name="sec_title" />
            <textarea class="ckeditor form-control editor1" rows="14"  name="sec_title">
            <?php //echo $sec_title;?>
            </textarea>
            </td>-->
        </tr>
        
        <tr>
            <td><label>Content:</label></td>
            <td>
            	<textarea class="ckeditor form-control editor1" rows="14"  name="readmore">
                	<?php echo $text;?>
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
