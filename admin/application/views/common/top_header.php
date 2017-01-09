  	<div class="pull-left">
        <a class="navbar-brand" href="<?php echo base_url('dashboard/dashboard');?>">
            <div class="navbar-logo">
                <!--<img src="<?php echo IMG?>logo.png" class="img-responsive" alt="logo"/>-->
               <!-- <img src="<?php echo  base_url()?>logo-grey.png" class="img-responsive" style="height:34px;width:auto;" alt="logo"/> -->
            </div>
        </a>
    </div>
  <div class="pull-right header-btns">
 
    <div class="btn-group user-menu">
      <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-user"></span> <b>Welcome</b> <?php echo $this->session->userdata('display_name');?> </button>
      <button type="button" class="btn btn-sm dropdown-toggle padding-none" data-toggle="dropdown"> <img src="<?php echo ($this->session->userdata('profile_image') == '') ? IMG."avatars/default_user.png" : USER_FOLDER.'/'.$this->session->userdata('admin_id')."/t1-".$this->session->userdata('profile_image')?>" alt="user avatar" width="28" height="28" /> </button>
      <ul class="dropdown-menu checkbox-persist" role="menu">
        <li class="menu-arrow">
          <div class="menu-arrow-up"></div>
        </li>
        <li class="dropdown-header">Your Account <span class="pull-right glyphicons glyphicons-user"></span></li>
        <li>
          <ul class="dropdown-items">
           <!-- <li>
				<div class="item-icon"><i class="fa fa-eye"></i></div>
				<a href="<?php echo base_url()."../"; ?>">View Website</a>
			</li> -->
			<li>
              <div class="item-icon"><i class="fa fa-cog"></i> </div>
              <a class="item-message" href="<?php echo base_url() ?>admin/manage-user/edit-profile">Edit Profile</a> </li>
        
            <li class="border-bottom-none">
              <div class="item-icon"><i class="fa fa-lock"></i> </div>
              <a class="item-message" href="<?php echo base_url()?>admin/manage-user/edit-password">Change Password</a> </li>
            <li class="padding-none">
              <div class="dropdown-lockout">&nbsp;</div>
              <div class="dropdown-signout"><i class="fa fa-sign-out"></i> <a href="<?php echo SURL?>login/logout">Sign Out</a></div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
