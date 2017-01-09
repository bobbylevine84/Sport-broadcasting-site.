<style>
    #register_form label.error {
        font-weight: normal;
        color: #ff0000;
    }
</style>
<div class="inner-content">
  <div class="container">
  <div class="form-bg">
  <input type="button" value="Update Your Profile" class="register-button" disabled style="margin-bottom: 15px; margin-top:15px; padding:15px 0">
  <div class="clear-fix"></div>
  <!--register-->
  <div  class="register-wrape">
  <form id="register_form" method="POST" action="<?php echo base_url();?>profile/updateProfile" enctype="multipart/form-data">
  <div class="row">
  
  <div class="col-md-6">
  <div class="form-group">
      <label>First Name</label>
    <input type="text" name="fname" class="form-control form-register1" id="fname" value="<?php echo $userdata[0]['first_name']; ?>" placeholder="First Name">

  </div>
  </div>
  
<!--  <div class="col-md-6">
  <div class="form-group">
      <label>Username</label>
    <input type="text" name="uname" class="form-control form-register1" id="uname" value="<?php echo $userdata[0]['user_name'];?>" placeholder="User Name">

  </div>
  </div>
  <div class="clearfix"></div>
  <div class="col-md-6">
  <div class="form-group">
      <label>Middle Name</label>
    <input type="text" name="mname" class="form-control form-register1" id="mname" value="<?php echo $userdata[0]['middle_name'];?>" placeholder="Middle Name">
	
  </div>
  </div>-->
  <div class="col-md-6">
  <div class="form-group">
  <label>Date Of birth</label>
    <input type="text" class="form-control form-register1" id="dob" name="dob" value="<?php echo $userdata[0]['date_of_birth'];?>" placeholder="Date of Birth">
	
  </div>
  </div>
  <div class="clearfix"></div>
  <div class="col-md-6">
  <div class="form-group">
      <label>Last Name</label>
    <input type="text" class="form-control form-register1" id="lname" name="lname" value="<?php echo $userdata[0]['last_name'];?>" placeholder="Last Name">

  </div>
  </div>
    <div class="col-md-6">
  <div class="form-group">
      <label>Mobile Number</label>
    <input type="text" class="form-control form-register1" id="mobnum" name="mobnum" value="<?php echo $userdata[0]['mobile_number'];?>" placeholder="Mobile Number">
	
  </div>
  </div>
   <div class="clearfix"></div>
    <div class="col-md-6">
  <div class="form-group">
      <label>Password</label>
    <input type="password" class="form-control form-register1" id="new_password" name="new_password"  placeholder="New Password (Leave Empty To Use Old Password)">
	
  </div>
  
  </div>
  
   <div class="col-md-6">
  <div class="form-group">
      <label>Email</label>
    <input type="email" class="form-control form-register1" id="email" name="email" value="<?php echo $userdata[0]['email_address'];?>">
	
  </div>
  </div>
   <div class="clearfix"></div>
  <div class="col-md-6">
  <div class="form-group">
      <label>Confirm Password</label>
    <input type="password" class="form-control form-register1" id="confirm_password" name="confirm_password"  placeholder="Confirm Password">
  </div>
  </div>
   
  <div class="col-md-6">
  <div class="form-group">
      <label>Twitch tv Id</label>
    <input type="text" class="form-control form-register1" id="twitchid" name="twitchid" value="<?php echo $userdata[0]['twitch_id'];?>" placeholder="Twitch ID">
  </div>
  </div>
  <div class="clearfix"></div>
  <div class="col-md-6">
      <label>Country</label>
  <select class="form-control form-register1" name="country" id="country">
  <option value="" name="">Select Your Country</option>
  <?php
  foreach($country as $count)
  {?>
  <option value="<?php echo $count['name'] ;?>" data-id="<?php echo $count['id'] ;?>" <?php if(   $count['name']== $userdata[0]['country']){ echo 'selected="selected"';}?>>
  <?php echo $count['name'];?>
  </option>
  <?php
  }
  ?>
</select>
  </div>
  <div class="col-md-6">
      <label>Address</label>
   <?php foreach($userdata as $data)
	{
	?>
  <input type="text" class="form-control form-register1" id="address" name="address" value="<?php echo $data['front_user_address'];?>" placeholder="Address">	
  <?php
	}
	?>
  </div>
  <div class="clearfix"></div>
  <div class="col-md-6">
      <label>State</label>
  <select class="form-control form-register1" name="stateDropdown" id="stateDropdown">
 <option>Select Your State</option>
 <option value="<?php echo $userdata[0]['state']; ?>" selected="selected"><?php echo $userdata[0]['state']; ?></option>
</select>
  </div>
  
  <div class="col-md-6">
      <label>Image</label>
  <div class="row">
  <div class="col-md-2">      
  <img id="user_p_img" src="<?php echo base_url(); ?>uploads/users/<?php echo $userdata[0]['user_image']; ?>"  >
  </div>
  <div class="col-md-10">
  	<div class="upload-file1">
            <span class="file-input btn btn-block btn-primary btn-file">
                Browse&hellip; <input type="file" id="editmyImage" name="my_image"  multiple>
            </span>
        </div>
  </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="col-md-6">
  <div class="form-group">
  <input type="submit" value="Update" class="register-button">
  </div>
  </div>
  </div>
  </form>
  </div>
<script>

var $jquery=jQuery.noConflict();
    $jquery(document).ready(function(){
      load_states($jquery('#country').find(':selected').data('id'));
      var current_state = '<?php echo $userdata[0]['state']; ?>';
        $jquery('#country').change(function(){
            load_states($jquery(this).find(':selected').data('id'));
        });

        $jquery("#editmyImage").change(function() {
          var input = this;
          if (input.files && input.files[0]) {
              var reader = new FileReader();

              reader.onload = function (e) {
                  $jquery('#user_p_img').attr('src', e.target.result);
              }

              reader.readAsDataURL(input.files[0]);
          }

        });
 
        function load_states(c_val) {
          $jquery.ajax({
                url: '<?php echo base_url();?>home/get_states',
                type: 'POST',
                dataType:'json',
                data: { country: c_val },
                success: function(data)
        {
                    var states = $jquery.parseJSON(JSON.stringify(data));
                    var stateDropdown = $jquery('#stateDropdown');
                    var stateTextbox = $jquery('#stateTextbox');
                    if(states == null)
          {
                        stateTextbox.show();
                        stateDropdown.hide();
                    }
                    else{
                        stateTextbox.hide();
                        stateDropdown.show()
                            .find('option')
                            .remove();
 
                        $jquery.each(states, function(key, value)
            {
              var is_selected = "";
              if(current_state == value.name) {
              is_selected = "selected";
              }
                            var option = $jquery('<option '+is_selected+'></option>')
                                            .text(value.name)
                                            .val(value.name);
                            stateDropdown.append(option);
                        });
                    }
                }
            });
        }

    });
</script>			
		
<script>
var $jquery=jQuery.noConflict();
    $jquery(document).ready(function() 
	{
        $jquery("#register_form").validate({
            rules: 
			{
                fname: 
				{
                    required: true
                },
                mname: 
				{
                    required: true
                },
				lname: 
				{
                    required: true
                },
                uname: {
                    required: true,
                    remote: {
                        url: "<?php echo base_url(); ?>profile/validate_uname",
                        type: "post"
                    }
                },
                password: 
				{
					minlength: 5
                },
                dob: 
				{
                    required: true
                },
                country: 
				{
                    required: true
                },
                state: 
				{
                    required: true
                },
                twitchid: {
                    remote: {
                        url: "<?php echo base_url();?>profile/validate_twitch",
                        type: "post"
                    }
                },
                mobnum: {
                    required: true,
                    number:true
                },
                address: {
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "<?php echo base_url();?>profile/validate_email",
                        type: "post"
                    }
                },
                new_password: {
                    minlength:5
                },
                confirm_password: {
                    minlength:5,
                    equalTo:"#new_password"
                }
            },
            messages: {
                email: {
                    required: "This field is required",
                    email: "Invalid Email Address",
                    remote: "Email address already in use."
                },
                uname: {
                    required: "This field is required",
                    remote: "Username already in use."
                },
                twitchid: {
                    remote: "Channel does not exist."
                },
                old_password: {
                    required: "This field is required",
                    remote: "Please Enter Correct Password"
                },
                confirm_password: {
                    equalTo: "Password Not Matched"
                }
            },
        }); //Form.Validate
        
        $jquery("#register_form").submit(function(){
            var now = new Date();                            
            var past = new Date($jquery("#dob").val());                            
            var nowYear = now.getFullYear();
            var pastYear = past.getFullYear();
            var age = nowYear - pastYear;
            if(age < 18) {
                $jquery("#error_container").html("You must be 18 or older to signup with us");
                $jquery("#error_container").show().delay(4000).fadeOut();
                return false;
            }
        });
        
    });
</script>
		
		<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>		
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
		<script src="<?php echo base_url(); ?>assets/js/datepicker/bootstrap-datepicker.js"></script>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/datepicker/datepicker.css"></script>
<script>
$jquery(function() {
    $jquery( "#dob" ).datepicker({
		changeYear: true,
                yearRange: "1900:<?php echo date("Y"); ?>",
                dateFormat: "yyyy-mm-dd"
	});
});
</script>
  </div>
  </div>
  </div>
  <script>
    var $jqu=jQuery.noConflict();
    $jqu(document).ready(function(){
        $jqu( ".mobile-toggle" ).click(function() {
            $jqu( ".navigation-menu" ).toggle( "slow" );
        });
    });	
	
    </script>



