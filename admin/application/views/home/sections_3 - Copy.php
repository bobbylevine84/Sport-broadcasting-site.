
<?php 
  $sec_desc = $adminsetting[2]['sec_desc'];
		$sec_content = $adminsetting[2]['sec_content'];	
		$sec_title = $adminsetting[2]['sec_title'];
		$sec_title_1 = $adminsetting[2]['sec_title_1'];
		$link = $adminsetting[2]['link'];
		$id = $adminsetting[2]['id'];
		$iframe = $adminsetting[2]['iframe'];

?>

<form action="<?php echo base_url('home/manage_section/update_sections'); ?>" method="post" enctype="multipart/form-data">
    <table border="0" class="table table-striped">
        <tr>
            <!--<td rowspan="6" width="20%" >
				<?php //echo str_replace('_',' ',ucfirst($sec_desc)) ; ?>
         	</td>-->
            <td width="18%"><label>Content:</label></td>
            <td>
            <textarea class="ckeditor form-control editor1" rows="14"  name="sec_title">
            <?php echo $sec_title; ?>
            </textarea>
            	<!--<input type="text" class="form-control" value="<?php echo $sec_title; ?>" name="sec_title" />-->
            </td>
        </tr>
		
		<!--<tr>
			<td><label>Sidebar Contents:</label></td>
            <td>
            	<textarea class="ckeditor form-control editor1" rows="14"  name="iframe">
                	<?php echo $iframe;?>
            	</textarea>
            </td>
		</tr>-->
		
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
        </tr> -->
								<!-- End -->
                               <!-- <tr>
            <td><label>Title:</label></td>
            <td>
            	<textarea class="ckeditor form-control editor1" rows="14"  name="sec_title_1">
                	<?php echo $sec_title_1; ?>
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
        </tr>-->
        
        
       <!-- <tr>
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
        </tr>-->
        
        
       <!-- <tr style="" id="selected_sec3_link">
        	<td><label>Selected Readmore Link:</label></td>
            <td><label><?php echo $link; ?></label></td>
        </tr>-->
        
        
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