
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
                                <tr>
            <td><label>Title:</label></td>
            <td>
            	<textarea class="ckeditor form-control editor1" rows="14"  name="sec_title">
                	<?php echo $sec_title; ?>
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