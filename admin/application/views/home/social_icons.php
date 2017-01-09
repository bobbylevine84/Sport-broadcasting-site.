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
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-visible">
                <div class="panel-heading">
                  <div class="panel-title hidden-xs"> 
                  	<span class="glyphicon glyphicon-picture"></span>
                    	Social Icons
                	</div>
                    <a href="<?php echo base_url('home/manage-section/add_new_icon');?>">
                        <div class="panel-title hidden-xs pull-right">
                            <span class="glyphicon glyphicon-plus"></span>
                            Manage
                        </div>
                    </a>
                                
                </div>
                <div class="panel-body padding-bottom-none">

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
					
					
					$num_icons = count($social_icons);
					
					//echo '<pre>';
					//print_r($social_icons);
					//exit;
					
					if($num_icons > 0){
                ?>
                
                
        <div class="row">
        	<div class="col-md-3">
            	<!--<div><label>Current Style</label></div> -->
            </div>
            <div class="col-md-9">
			<!--<?php //echo '<pre>'; print_r($style_type); exit;
					//$social_icons[0]
					
if($style_type==1)
					{
						foreach($social_icons as $i)
						{?>
							<span>
                	<img src="<?php echo IMG_social_icons.$i['social_icon1']; ?>">
                			</span>
						<?php }
					}
					elseif($style_type==2)
					{
						foreach($social_icons as $i)
						{?>
							<span>
                	<img src="<?php echo IMG_social_icons.$i['social_icon2']; ?>">
                			</span>
						<?php }
					}
					elseif($style_type==3)
					{
						foreach($social_icons as $i)
						{?>
							<span>
                	<img src="<?php echo IMG_social_icons.$i['social_icon3']; ?>">
                			</span>
						<?php }
						
					}elseif($style_type==4)
					{
						foreach($social_icons as $i)
						{?>
							<span>
                	<img src="<?php echo IMG_social_icons.$i['social_icon4']; ?>">
                			</span>
					<?php }
					}elseif($style_type==5)
					{
						foreach($social_icons as $i)
						{?>
							<div class="social-slide <?php echo $i['social_icon5']; ?>">
                			</div>
					<?php }
					}elseif($style_type==6)
					{?>
						<div class="socialicons">
							<ul>
					<?php
						foreach($social_icons as $i)
						{?>
							<a href="#" alt="Facebook" target="_blank">
								<li class="<?php echo $i['social_icon6']; ?>"></li>
							</a>
					<?php }?>
							</ul>
						</div>
					<?php						
					}?> -->
					
<!--style 6
<div class="socialicons">
	<ul>
	<a href="#" alt="Facebook" target="_blank">
	<li class="fb"></li>
	</a>
	<a href="#" alt="Facebook" target="_blank">
	<li class="tw"></li>
	</a>
	<a href="#" alt="YouTube" target="_blank">
	<li class="tube"></li>
	</a>
	<a href="#" alt="gp" target="_blank">
	<li class="gp"></li>
	</a>
	</ul>
</div>
         --> 
		   </div>
        </div>
        <br/><br/> 
        
        <table class="table table-striped table-hover">
        	<thead>
            	<th>Selected Socail Services</th>
                <th>URL</th>
                <th>Status</th>
            </thead>
            <tbody>
            <?php foreach($social_icons as $i){ ?>
            	<tr>
                	<td><?php echo $i['name']; ?></td>
                    <td><?php echo $i['social_link']; ?></td>
                    <td><span class="label btn-success">Active</span></td>
                </tr>
           	<?php }?>
            </tbody>
        </table>      


                  
                  <?php 
					}else{
				?>
                <div class="alert alert-danger alert-dismissable">
                	<strong>No Social Icons Found</strong> </div>                	
                <?php		
					}//end if($social_icons_count > 0)
				  ?>
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
<style>
/*style 5*/
.social-slide {
	height: 29px;
	width: 29px;
	//margin: 1px;
	float: left;
	border-radius: 50%;
	-webkit-transition: all ease 0.3s;
	-moz-transition: all ease 0.3s;
	-o-transition: all ease 0.3s;
	-ms-transition: all ease 0.3s;
	transition: all ease 0.3s;
}
.twitter-hover {
	background-image: url(<?php echo base_url("../uploads/social_icons/style5_twitter.png"); ?>);
}
.facebook-hover {
	background-image: url(<?php echo base_url("../uploads/social_icons/style5_facebook.png"); ?>);
}
.gplus-hover {
	background-image: url(<?php echo base_url("../uploads/social_icons/style5_gplus.png"); ?>);
}
.youtube-hover {
	background-image: url(<?php echo base_url("../uploads/social_icons/style5_youtube.png"); ?>);
}
.social-slide:hover {
	background-position: 0px -29px;
	box-shadow: 0px 0px 4px 1px rgba(0,0,0,0.8);
}
</style>
</body>
</html>
