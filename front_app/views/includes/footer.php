<?php
$color_used = $this->session->userdata('session_color');
switch ($color_used) {
    case "blue":
        $image_color = "blue.png";
        break;
    case "green":
        $image_color = "green.png";
        break;
    case "purple":
        $image_color = "purple.png";
        break;
	case "orange":
        $image_color = "orange.png";
        break;
	default :
		$image_color = "green.png";
}
?>
<div class="clearfix"></div>
<footer id="footer-container" class="<?php echo $this->session->userdata('session_color').'-footer-container';?>">
<?php //echo "<pre>";print_r($get_my_header);exit; ?>
	<div class="container">
		<div class="row">
			<!--
			<div class="col-lg-4 col-md-4">
				<div class="about-footer">
				
					<?php //foreach($footer as $foot){ ?>
					<div class="footer-logo">
						<img src="<?php// echo base_url(); ?>assets/images/myimages/images/<?php// echo $image_color;?>" alt="">
					</div>
					<?php// if(strlen($foot['footer'])>400) {
						?><p><?php //echo "Footer Exceeds Maximum limit"; ?></p>
					<?php //}// else {?>
					<p><?php// echo $foot['footer'];?></p>
					<?php //} }?>
					<?php //echo "<pre>";print_r($footer_events);exit;?>
				</div>
			</div>
			-->
			<div class="col-lg-4 col-md-4 col-sm-3">
				<div class="footer-heading">Quick links</div>
				<div class="quick-links">
				<ul>
					<li><a href="<?php echo base_url();?>">Home</a></li>
					<li><a href="">Live sports </a></li>
					<li><a href="<?php echo base_url();?>live-channels/42">Live TV</a></li>
					<li><a href="<?php echo base_url();?>video-highlights">Highlights </a></li>
					<?php //foreach($get_my_header as $header)?>
					<!--<li><a href="<?php //echo base_url();?>blog">News & Guide</a></li>-->
					<?php ?>
					<li><a href="<?php echo base_url();?>home/contact">Contact Us</a></li> 
				</ul>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-3 stream-footer">
				<div class="footer-heading">Web Masters and Streamers</div>
				<div class="quick-links">
				<ul>
					<li><a href="<?php echo base_url();?>stream">Submit Streams </a></li>
					<li><a href="<?php echo base_url();?>video-highlights/submit_highlight">Submit Highlights</a></li>
					<li><a href="<?php echo base_url();?>live-channels/42">Live TV</a></li>
					<li><a href="">Content Partner</a></li>
				</ul>
				</div>
                
                
                
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 news-footer">
				<div class="footer-heading">Latest News</div>
				<div class="footer-events">
					<div class="ftr-event-data <?php echo $this->session->userdata('session_color').'-event-date';?>">
						<div class="row">
						<?php foreach($news1 as $new) {?>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="event-heading"><a href="<?php echo base_url(); ?>home/news/<?php echo $new['slug_news']; ?>"><i><?php echo $new['title'];?>.</i></a></div>
								
								<div class="event-date <?php echo $this->session->userdata('session_color').'-event-date';?>"><?php echo date('jS', strtotime($new['created_date']));?>
								<?php echo date('F', strtotime($new['created_date']));
								     echo date('o', strtotime($new['created_date']));?>
								<?php //echo date('l', strtotime($new['created_date'])); ?>
								</div>
								
							</div>
						<?php } ?>
                        
                        <!--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="change-color">
                <h3>Choose Color</h3>
                <span class="blue change_color" data-color ="blue" value="blue" id="blue"></span>
                <span class="orange change_color" data-color ="orange" value="orange" id="orange"></span>
                <span class="purple change_color" data-color ="purple" value="purple" id="purple"></span>
                <span class="green change_color" data-color ="green" value="green" id="green"></span>
                <span class="black change_color" data-color ="black" value="black" id="black"></span>
                </div>
                        </div>-->
                        
						</div>
					</div>
				</div>
                
                
                
			</div>
            
      
            
            <div class="col-xs-12 text-center">
            	<!--<p style="color:#FFF">Copyright @<?php echo date('Y');?> : RealStreamSports.com</p>-->
            </div>
		</div>
	</div> <?php $my_ip = $_SERVER['REMOTE_ADDR']; ?> 
</footer><input type="hidden" value="<?php echo $my_ip;?>" id="get_ip">
<script>
$(document).ready(function () { 
		var ip_address = $('#get_ip').val();
		
        $(".change_color").click(function(){
			var get_color = $(this).data("color");
			$.ajax({
				url : "<?php echo base_url();?>home/change_color",
				type : "POST",
				data : {"ip" : ip_address , "color" : get_color},
				success : function(data){
					location.reload();
				}
			});
        });
    });
</script>