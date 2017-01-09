
<!DOCTYPE html>
<html lang="en">
    <head>
		<title>
			<?php echo $meta_title;?>
		</title>
		<?php echo $meta_description;?>
		<?php echo $meta_keyword;?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>WiziWig</title><!--
       <link rel="icon" type="image/png" href="<?php// echo base_url() ?>assets/images/favicon.ico">-->
	   <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>
  
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
      <!--  <link rel="stylesheet" href="<?php //echo base_url(); ?>assets/css/demo.css" type="text/css" media="screen" />-->
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,500,700,600,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]



        <style>
            .my-error-class
            {
                color:red;
            }
            .my-valid-class
            {
                color:green;
            }	
            ul.slides li div.slider-text h1 {
               font-size: 32px !important;
           }

        </style>
    </head>
    <body>
<!-- header -->
<?php $this->load->view('includes/header');?>
<!-- header --> 

<!-- banner -->
<!-- banner -->
<div class="clearfix"></div>
<!-- games container -->
<section id="games-links" class="game-links <?php echo $this->session->userdata('session_color').'-games-links'?>">
    <div class="container">
    <i class="fa fa-navicon mob-nav"></i>
        <div class="row animated slideInDown" id="mob-navig">
            <div class="col-lg-12">
                <ul>
                    <?php for($i=0;$i<=6;$i++){ ?>
                    <li>
                        <?php ?>
                        <a href="<?php echo base_url();?>livestreaming/<?php if($sports_arr[$i]['category_name'] == "Soccer") { $sports_arr[$i]['category_name'] ="Football"; } echo str_replace(' ', '-', $sports_arr[$i]['category_name']);?>">
                            <span class="left-icon">
                                <img src="<?php echo base_url();  ?>admin/uploads/game_images/<?php echo $sports_arr[$i]['sport_logo'];?>">
                            </span>
                            <span>
                                <?php if($sports_arr[$i]['category_name'] == "Soccer") { $sports_arr[$i]['category_name'] = "Football"; } echo $sports_arr[$i]['category_name'];?>
                            </span>
                        </a>
                    </li>
                    <?php } 
                    if($sports_count > 7) {?>
                    <div class="btn-group">
                    
                        <button type="button" class="dropdown-toggle" data-toggle="dropdown">
                            Other... <span class="caret"></span>
                        </button>
                        
                        <ul class="dropdown-menu <?php echo $this->session->userdata('session_color').'-dropdown-menu'?>" role="menu">
                        <?php for($z=7;$z<$sports_count;$z++) {?>
                        <li>
                            <a href="<?php echo base_url();?>livestreaming/<?php echo str_replace(' ', '-', $sports_arr[$z]['category_name']);?>">
                                <span class="left-icon">
                                    <img src="<?php echo base_url();  ?>admin/uploads/game_images/<?php echo $sports_arr[$z]['sport_logo'];?>" style="width:28px;height:28px;">
                                </span>
                                <span>
                                    <?php echo $sports_arr[$z]['category_name'];?>
                                </span>
                            </a>
                        </li>
                        <?php }?>
                        </ul>
                    </div> <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- games container --> 
<?php
$live_ad = $this->db->get('kt_ads_live')->result_array();
 ?>
<div class="clearfix"></div>
<!-- table container -->
<section id="highlight-container">
<div class="container">
<div class="row">
<div class="col-md-10 col-sm-12 col-xs-12 col-md-offset-1">
<h2 style="padding-bottom:0">
    You Are Watching <?php echo $live_streaming[0]['name'];?>
      <div class="" style="float:right;">
                    <span class='st_facebook_hcount' displayText='Facebook'></span>
                    <span class='st_twitter_hcount' displayText='Tweet'></span>
                </div>
</h2>
	<h2 style="padding-bottom:15px">

        <center>
		<span>Alternate links</span>
		<!-- here -->
		<?php $i=1; foreach($live_streaming as $streams){?>
		<span><a href="javascript:;" data-id="<?php echo $streams['feedid'];?>" class="mystream" >
		Server (<?php echo $i; ?>)</a></span><span>
		<?php $i++; } ?>
		
		<a style="background:none;" href="<?php echo $live_ad[0]['url']; ?>"><img src="<?php echo base_url();?>hd/<?php echo "hd.png"; ?>"></a>
    </center>
     </h2>
        
<div class="row">
<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0">



<ul class="livematches">
<?php foreach($streams_logo as $streams){?>
<li style="margin-bottom:10px;height:none;"> <a href="<?php echo base_url();?>live-channels/<?php echo $streams['id'];?>"> <img height="25" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo $streams['logo'];?>">  </a></li>
<?php } ?>

</ul> 

</div>
<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
	
	<div class="video-container">
		<div class="abc" id="stream_content">
			<?php echo $live_streaming[0]['main_frame'];
						
			
			?>
		</div>
	</div>
	
</div> 
<?php /*?><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0">



<ul class="livematches">
<?php foreach($streams_logo as $streams){?>
<li style="margin-bottom:10px;"> <a href="<?php echo base_url();?>live-channels/<?php echo $streams['id'];?>"> <img height="25" src="<?php echo base_url();?>admin/uploads/game_images/<?php echo $streams['logo'];?>">  </a></li>
<?php } ?>

</ul>

</div><?php */?> 
</div>
</div>
</div>
<div class="clearfix"></div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-right:15px">
		<div class="dummytext">
		<!--
		<h2> Lorem <strong>Lipsum dollar Sits</strong> Asmit Dummy </h2>
		-->
		<p>
		<?php echo $live_streaming[0]['description'];?></p>
		<!--
		<div class="socialmedia">  
			<h4> Follow Us </h4>
			<a href="#" class="facebook"> <i class="fa fa-facebook-square"></i>  </a>
			<a href="#" class="twitter"> <i class="fa fa-twitter-square"></i>  </a>
			<a href="#" class="googleplus"> <i class="fa fa-google-plus-square"></i>  </a>
			<a href="#" class="youtube"> <i class="fa fa-youtube-square"></i>  </a>
		</div>
		-->
		</div>
	</div>
</div>


<!--
<div class="row">
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
<div class="comment-container">
<div class="row">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="comment-now">
	<h2>Comments</h2>
	<form>
    	<textarea name="txtcomment" cols="50" rows="5"></textarea>
        <div class="clearfix"></div>
        <div class="rating1" style="margin-top:0; margin-bottom:15px; float:left">  
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star-half-o"></i> </a>
        
        </div>
        <div class="clearfix"></div>
        <input type="submit" name="btn-submit" value="submit">
    </form>
</div>
</div>
<div class="clearfix"></div>
<div class="commented-by">
<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
	<div class="user-img"><img src="images/user1.jpg" ></div>
</div>

<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12" style="padding-left:0">

	<div class="commet-txt">
    	<div class="comment-heading">Spencer Hill  <span>Posted 4 years ago</span> </div>
        
        
        <div class="rating1">  
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star-half-o"></i> </a>
        
        </div>
        
        
        
        <p>
        	It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ,  <a href="">Read More</a>
        </p>
    </div>
</div>
</div>
<div class="clearfix"></div>
<div class="commented-by">
<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
	<div class="user-img"><img src="images/user1.jpg" ></div>
</div>

<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12" style="padding-left:0">

	<div class="commet-txt">
    	<div class="comment-heading">Spencer Hill  <span>Posted 4 years ago</span> </div>
        
        
        <div class="rating1">  
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star-half-o"></i> </a>
        
        </div>
        
        
        
        <p>
        	It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ,  <a href="">Read More</a>
        </p>
    </div>
</div>
</div>
<div class="clearfix"></div>
<div class="commented-by">
<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
	<div class="user-img"><img src="images/user1.jpg" ></div>
</div>

<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12" style="padding-left:0">

	<div class="commet-txt">
    	<div class="comment-heading">Spencer Hill  <span>Posted 4 years ago</span> </div>
        
        
        <div class="rating1">  
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star"></i> </a>
        <a href="#"> <i class="fa fa-star-half-o"></i> </a>
        
        </div>
        
        
        
        <p>
        	It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ,  <a href="">Read More</a>
        </p>
    </div>
</div>
</div>

</div>
</div>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="ad-container">
<div class="ad"><img src="<?php// echo base_url();?>assets/images/ad1.jpg" class="img-responsive" alt=""></div>
<div class="ad"><img src="<?php// echo base_url();?>assets/images/ad2.jpg" class="img-responsive" alt=""></div>
</div>
</div>
</div>r -->
</div>
</section>
<!-- highlight containe

<div class="clearfix"></div>
<!-- news container
<section id="news-container">
<div class="container">
<div class="row">

<?php //foreach($news1 as $new) {?>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	<div class="blog-data">
    	<h4><b><i><?php //echo $new['title'];?>.</i></b></h4>
        <div class="blog-date" style="margin:20px;"><?php //echo $new['created_date'];?></div>
        <div class="blog-img"><img style="height:300px;width:300px; border-radius:20%;"src="<?php //echo base_url();?>admin/uploads/game_images/<?php// echo stripslashes($new['image']) ?>"></div>
        <p><?php// echo substr($new['description'], 0, 50);?>......</p>
		    <a href="<?php //base_url(); ?>home/news/<?php// echo $new['slug_news']; ?>" title="">Read More</a><hr>
    </div>
</div>
<?php //} ?> 

</div>
</div>
</section> -->


	
<!-- news container -->

<!-- footer --> 
<?php $this->load->view("includes/footer"); ?>
<!-- footer --> 
<!-- copy right -->

<!-- copy right --> 
<!-- Page Wrapper --> 

<!-- End Page Wrapper --> 

<!-- JavaScripts --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/own-menu.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.sticky.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/button.js"></script>
</body>
</html>

<script>
$(".mystream").click(function(){
var id = $(this).data("id");	
//console.log(id)
$.post("<?php echo base_url();?>home/get_alternate_stream_channel",{
				channel_id : id,
			}).done(function(data){
			//	console.log(data)
				document.getElementById('stream_content').innerHTML=data;
			
			});
});

$(".mob-nav").click(function(){
    $("#mob-navig").toggle();
});

</script>
