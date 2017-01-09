<?php 
$sec_desc = $adminsetting[0]['sec_desc'];
		$sec_content = $adminsetting[0]['sec_content'];	
		$sec_title = $adminsetting[0]['sec_title'];
		$link = $adminsetting[0]['link'];
		$id = $adminsetting[0]['id'];
		$sec_image = $adminsetting[0]['sec_image'];
?>
<form action="<?php echo base_url('home/manage_section/update_sections'); ?>" method="post" enctype="multipart/form-data">
    <table border="0" class="table table-striped">
        <tr>
            <!--<td rowspan="6" width="20%" >
				<?php //echo str_replace('_',' ',ucfirst($sec_desc)) ; ?>
         	</td>-->
            <td width="18%"><label>Title:</label></td>
            <td>
            	<?php 
		$sec_desc = $adminsetting[0]['sec_desc'];
		$sec_content = $adminsetting[0]['sec_content'];	
		$sec_title = $adminsetting[0]['sec_title'];
		$link = $adminsetting[0]['link'];
		$id = $adminsetting[0]['id'];
		$sec_image = $adminsetting[0]['sec_image'];
			
				?>
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
   