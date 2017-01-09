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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add Icon</div>
              
            </div>
            <div class="panel-body alerts-panel">
            
            <!--displays validation error messege-->
			<?php if(validation_errors()){?>
            <div class="alert alert-warning alert-dismissable">
   				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php echo validation_errors(); ?>
        	</div>
            <?php }else{?>
            <?php } ?>
              <form method="POST" action="<?php echo SURL?>home/manage-section/add-icon-process">
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
                    
    <table class="table table-striped table-hover" >
        <thead>
            <th>Social Service Name</th>
            <th>Url</th>
            <th>Action</th>
        </thead>
        <tbody >
           	
            <?php foreach($social_icons_drop as $icon){?>
            	<?php if($icon['temp_status']==1){?>
            <tr>
                <td>
                    <label><?php echo $icon['name']; ?></label>
                </td>
                <td>
                    <input type="hidden" name="<?php echo $icon['name'];?>" value="<?php echo $icon['id'];?>">
                    <input type="text" class="form-control" name="<?php echo $icon['name'].'_link'; ?>" value="<?php echo $icon['social_link']; ?>" />
                    
                </td>
                <td>
                    <a href="<?php echo base_url('home/manage-section/remove-icon').'/'.$icon['id']; ?>" type="button" class="btn btn-danger btn-gradient form-control" onClick="return confirm('Are you sure you want to delete?')" ><span class="glyphicons glyphicons-remove"></span></a>
                </td>
            </tr>
            	<?php }?>
			<?php }?>
            <?php //echo '<pre>'; print_r($remain_icons_count);exit;
				if($remain_icons_count>0){ ?>
           	<tr>
                <td>
                	<select required class="form-control" name="id_icon">
                        <?php foreach($social_icons_drop as $icon){
                            	if($icon['temp_status']==0) {?>
                            <option value="<?php echo $icon['id'] ?>">
								<?php echo $icon['name']; ?>
                           	</option>
                        <?php } 
							}?>
                    </select>
                </td>
                <td>
                    <input required type="text" class="form-control" name="url1" />
                </td>
                <td>
                    <button name="add" type="submit" class="btn-success form-control">Add More</button>
                </td>
            </tr>
					
			<?php }?>
            
            
            
        </tbody>
    </table>
                    
                    <br/>
                    <!--<div><label>Select Social Icons Style</label></div>
                    <br/>
                    <table class="table table-striped table-hover">
                        <thead>
                            <th>Select</th>
                            <th>Available styles</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="radio" name="style_id" value="1" /></td>
                                <td>
                                    <div>
                                        <img src="<?php echo IMG_social_icons."style1.PNG";?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="style_id" value="2" /></td>
                                <td>
                                    <div>
       <img src="<?php echo IMG_social_icons."style2.PNG";?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="style_id" value="3" /></td>
                                <td>
                                    <div>
                                        <img src="<?php echo IMG_social_icons."style3.PNG";?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="style_id" value="4" /></td>
                                <td>
                                    <div>
                                        <img src="<?php echo IMG_social_icons."style4.PNG";?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="style_id" value="5" /></td>
                                <td>
                                    <div>
                                        <img src="<?php echo IMG_social_icons."style5.PNG";?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="style_id" value="6" /></td>
                                <td>
                                    <div>
                                        <img src="<?php echo IMG_social_icons."style6.png";?>">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table> -->
                    
                    <div class="form-group" align="right" style="margin-right:17px">
                    	<input name="update" class="submit btn btn-blue" type="submit" value="Update" />
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
<script type="application/javascript">


	$(document).ready(function(){
		var data = <?php echo json_encode($social_icons); ?>;
		//alert(data);
		var i=1;
		$('#but').click(function(){	
			$('.new').append( "<tr class='r"+i+"'><td><select class='form-control'><?php foreach($social_icons as $icon): ?><option value='<?=$icon['id'] ?>'><?=$icon['social_icon'] ?></option><?php endforeach;?></select></td><td><input type='text' class='form-control' name='url"+i+"' /></td><td><a href='#' id='r"+i+"' class='btn-danger form-control'>Remove</a></td></tr>")
					
			for (var j=1; j<=i; j++)
			{
				//alert(i);
				$('#r'+j).click(function(){ 
					j--;
					//alert(j);
					$('.r'+j).empty() 
				});
			}
		i++;
		});
	});
		
</script>
</body>
</html>
