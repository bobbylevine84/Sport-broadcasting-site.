<?php
//echo 'i am consumer/edit view file';
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
<style>

</style>
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
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-visible">
                    		<div class="panel-heading">
                    			<div class="panel-title hidden-xs"> 
                    				<span class="glyphicon glyphicon-list"></span>Manage Users
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
                            <?php if(validation_errors()== '' ){ ?>
                            		<div></div>
							<?php }else{ ?>
							<div class="alert alert-danger"><?php echo validation_errors(); ?>
                            </div>
							<?php } ?>
							
							
                            	<form action="<?php echo base_url('users/manage_user/edit_process') ; ?>" method="post">
                                
                                <?php foreach($user_record as $d) {?>
                                	
                                    <div class="form-group">
                                    	<label>First Name:</label>
                                        <input class="form-control" type="text" name="first_name" value="<?php echo $d['first_name'] ;?>" required />
                                    </div>
                                    
                                    <div class="form-group">
                                      <label>Middle Name:</label>
                                        <input class="form-control" type="text" name="middle_name" value="<?php echo $d['middle_name'] ;?>" required />
                                    </div>

                                    <div class="form-group">
                                    	<label>Last Name:</label>
                                        <input class="form-control" type="text" name="last_name" value="<?php echo $d['last_name'] ;?>" required />
                                    </div>
                                    
                                    <div class="form-group">
                                    	<label>Email:</label>
                                        <input class="form-control" type="text" name="email" value="<?php echo $d['email_address'] ;?>" required />
                                    </div>
                                    
                                    <div class="form-group">
                                    	<label>Mobile No. :</label>
                                        <input class="form-control" placeholder="xxxx-xxx-xxxx" type="tel" name="mobile_number" value="<?php echo $d['mobile_number'] ;?>" id="phonenum" />
                                    </div>
                                    
                                    <div class="form-group">
                                    	<label>Date Of Birth:</label>
                                        <input class="form-control" type="date" name="dob" value="<?php echo date('Y-m-d',strtotime($d['date_of_birth']));?>" />
                                    </div>
                                    
									<div class="form-group">
                                    	<label>Address:</label>
                                        <input class="form-control" type="text" name="address" value="<?php echo $d['front_user_address'];?>" />
                                    </div>
									
                                   <!-- <div class="form-group">
                                    	<label>State:</label>
                                        <select class="form-control form-register" name="country" id="country">
                                            <option value="" name="">Select Your State</option> 
                                            <?php
                                            foreach($states as $state)
                                            {
                                            ?>
                                            <option value="<?php echo $state['id'] ;?>" <?php echo ($d['state']==$state['name'])?'selected':''; ?> ><?php echo $state['name'] ;?></option>
                                            <?php
                                            }
                                            ?>
                                         </select>
                                    </div>
                                    
                                    <div class="form-group">
                                    	<label>Country:</label>
                                          <select class="form-control form-register" name="country" id="country">
                                            <option value="" name="">Select Your Country</option> 
                                            <?php
                                            foreach($countries as $country)
                                            {
                                            ?>
                                            <option value="<?php echo $country['id'] ;?>" <?php echo ($d['country']==$country['name'])?'selected':''; ?> ><?php echo $country['name'] ;?></option>
                                            <?php
                                            }
                                            ?>
                                          </select>
                                    </div>

                                    <div class="form-group">
                                      <label>Twitch ID:</label>
                                        <input class="form-control" type="text" name="twitch_id" value="<?php echo $d['twitch_id'] ;?>" />
                                    </div>-->
                                  
                                    <div class="form-group">
                                    	<label>User Name:</label>
                                        <input onkeypress="validate_password(event);" class="form-control" type="text" name="user_name" value="<?php echo $d['user_name'] ;?>" />
										<div id="uac" class="error-r"><?php echo form_error('user_name'); ?></div>
                                    </div>
                                    
              <div class="form-group">
                  <label>Status Active:</label>
                  <input type="radio" name="status" value="active" <?php
                  if($d['front_user_flag']=='active'){echo 'checked';}
                  ?> />
                  <br/>
                  <label>Status Inactive:</label>
                  <input type="radio" name="status" value="inactive" <?php
                  if($d['front_user_flag']=='inactive'){echo 'checked';}
                  ?> />
				  <br/>
				  <label>Status Banned:</label>
                  <input type="radio" name="status" value="banned" <?php
                  if($d['front_user_flag']=='banned'){echo 'checked';}
                  ?> />
                  
              </div>
                                    
                                    
									<input type="hidden" name="front_user_id" value="<?php echo $d['front_user_id'] ;?>" />
									<input type="hidden" name="page" value="<?php echo $page;?>"/>
                                
								<?php }?>
                                	<div class="form-group">
                                    	<input class="btn btn-primary pull-right" type="submit" value="Update" />
                                    </div>
								</form>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="clearfix"></div>
    <div class="row" style="min-height:250px;">&nbsp;</div>
    </div>
  </section>
  <!-- End: Content --> 

</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
<script>
function validate_password(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /^\S*$/;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
</script>
</body>
</html>
