<script defer src="<?php echo base_url(); ?>assets/js/moment.js"></script>
<?php
$my_ip = $_SERVER['REMOTE_ADDR'];
// $this->db->where('user_ip',$my_ip);
// $color = $this->db->get('kt_color')->result_array();
// if($color){
	// $this->session->set_userdata('session_color',$color[0]['color']);
	// $this->session->set_userdata('session_ip',$color[0]['user_ip']);
// }
 // else {
	 // $this->session->set_userdata('session_color','');
 // }
// echo $this->session->userdata('session_ip');
$color_used = $this->session->userdata('session_color');
switch ($color_used) {
    case "blue":
        $image_color = "blue2.png";
        break;
    case "green":
        $image_color = "green2.png";
        break;
    case "purple":
        $image_color = "purple2.png";
        break;
	case "orange":
        $image_color = "orange2.png";
        break;
	case "black":
        $image_color = "green.png";
        break;
	default :
		$image_color = "green2.png";
}
//echo $image_color;exit;
?>
<?php //echo standard_date($format, $time);  //echo "<pre>";print_r($get_my_header);exit; ?>
<style>
#curTime{
//background-color:#000;
//text-color:black;
}
</style>

<nav role="navigation" class="navbar navbar-default navbar-<?php echo $this->session->userdata('session_color'); ?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"> 
				<div class="navbar-header page-scroll">
					<button data-target=".navbar-ex1-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo base_url();?>"><img src="<?php echo base_url(); ?>assets/images/myimages/images/<?php echo $image_color;?>" alt=""></a>
					<!--<a class="navbar-brand hidden-lg " href="#"><img src="images/logo-tab.jpg"  alt=""></a>-->
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="navbar-collapse navbar-ex1-collapse collapse" aria-expanded="false" style="height: 1px;">
					<ul class="nav navbar-nav">
			<!-- 		  <li><a class="<?php //echo $this->session->userdata('session_color').'-txt';?>" href="<?php //echo base_url();?>"><i class="fa fa-home"></i> &nbsp;Home</a></li> -->
					  <li><a class="<?php echo $this->session->userdata('session_color').'-txt';?>" href="<?php echo base_url();?>"><i class="fa fa-soccer-ball-o"></i> &nbsp;Live sports</a></li>
					  <li><a class="<?php echo $this->session->userdata('session_color').'-txt';?>" href="<?php echo base_url();?>live-channels/42"><i class="fa fa-tv"></i> &nbsp;Live TV</a></li>
					  <li><a class="<?php echo $this->session->userdata('session_color').'-txt';?>" href="<?php echo base_url();?>video-highlights"><i class="fa fa-sticky-note"></i> &nbsp;Highlights</a></li>
					  <?php foreach($get_my_header As $header ) {?>
						  <li><a class="<?php echo $this->session->userdata('session_color').'-txt';?>" href="<?php echo base_url(); ?>blog" title=""><i class="fa fa-newspaper-o"></i> &nbsp;<?php echo $header['menu_name']; ?></a></li>
												
					  <?php } ?>
					  
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col-lg-offset-0 " >
				<div class="current-date-time"><?php if($this->session->userdata('session_color') == "black"){ ?><span style="color:white;"><strong>Your Time: <span id="para1"></span></strong></span> <?php } else {?> <strong>Your Time: <span id="para1"></span></strong> <?php }?>
<select name="offset" class="offset" id="offset">
					  <option value="-12" <?php echo ($this->session->userdata('time_formate')== '-12')?'selected':''?>> (GMT -12)</option>
					  <option value="-11" <?php echo ($this->session->userdata('time_formate')== '-11')?'selected':''?>> (GMT -11)</option>
					  <option value="-10" <?php echo ($this->session->userdata('time_formate')== '-10')?'selected':''?>> (GMT -10)</option>
					  <option value="-9.5 <?php echo ($this->session->userdata('time_formate')== '-9.5')?'selected':''?>"> (GMT -9.5)</option>
					  <option value="-9" <?php echo ($this->session->userdata('time_formate')== '-9')?'selected':''?>> (GMT -9)</option>
					  <option value="-8" <?php echo ($this->session->userdata('time_formate')== '-8')?'selected':''?>> (GMT -8)</option>
					  <option value="-7" <?php echo ($this->session->userdata('time_formate')== '-7')?'selected':''?>> (GMT -7)</option>
					  <option value="-6" <?php echo ($this->session->userdata('time_formate')== '-6')?'selected':''?>> (GMT -6)</option>
					  <option value="-5" <?php echo ($this->session->userdata('time_formate')== '-5')?'selected':''?>> (GMT -5)</option>
					  <option value="-4.5" <?php echo ($this->session->userdata('time_formate')== '-4.5')?'selected':''?>> (GMT -4.5)</option>
					  <option value="-4" <?php echo ($this->session->userdata('time_formate')== '-4')?'selected':''?>> (GMT -4)</option>
					  <option value="-3.5" <?php echo ($this->session->userdata('time_formate')== '-3.5')?'selected':''?>> (GMT -3.5)</option>
					  <option value="-3" <?php echo ($this->session->userdata('time_formate')== '-3')?'selected':''?>> (GMT -3)</option>
					  <option value="-2" <?php echo ($this->session->userdata('time_formate')== '-2')?'selected':''?>> (GMT -2)</option>
					  <option value="-1" <?php echo ($this->session->userdata('time_formate')== '-1')?'selected':''?>> (GMT -1)</option>
					  <option value="0" <?php echo ($this->session->userdata('time_formate')== '0' || !$this->session->userdata('time_formate'))?'selected':''?>> (GMT +0)</option>
					  <option value="1" <?php echo ($this->session->userdata('time_formate')== '1')?'selected':''?>> (GMT +1)</option>
					  <option value="2" <?php echo ($this->session->userdata('time_formate')== '2')?'selected':''?>> (GMT +2)</option>
					  <option value="3" <?php echo ($this->session->userdata('time_formate')== '3')?'selected':''?>> (GMT +3)</option>
					  <option value="3.5" <?php echo ($this->session->userdata('time_formate')== '3.5')?'selected':''?>> (GMT +3.5)</option>
					  <option value="4" <?php echo ($this->session->userdata('time_formate')== '4')?'selected':''?>> (GMT +4)</option>
					  <option value="4.5" <?php echo ($this->session->userdata('time_formate')== '4.5')?'selected':''?>> (GMT +4.5)</option>
					  <option value="5" <?php echo ($this->session->userdata('time_formate')== '5')?'selected':''?>> (GMT +5)</option>
					  <option value="5.5" <?php echo ($this->session->userdata('time_formate')== '5.5')?'selected':''?>> (GMT +5.5)</option>
					  <option value="5.75" <?php echo ($this->session->userdata('time_formate')== '5.75')?'selected':''?>> (GMT +5.75)</option>
					  <option value="6" <?php echo ($this->session->userdata('time_formate')== '6')?'selected':''?>> (GMT +6)</option>
					  <option value="6.3" <?php echo ($this->session->userdata('time_formate')== '6.3')?'selected':''?>> (GMT +6.3)</option>
					  <option value="7" <?php echo ($this->session->userdata('time_formate')== '7')?'selected':''?>> (GMT +7)</option>
					  <option value="8" <?php echo ($this->session->userdata('time_formate')== '8')?'selected':''?>> (GMT +8)</option>
					  <option value="8.75" <?php echo ($this->session->userdata('time_formate')== '8.75')?'selected':''?>> (GMT +8.75)</option>
					  <option value="9" <?php echo ($this->session->userdata('time_formate')== '9')?'selected':''?>> (GMT +9)</option>
					  <option value="9.5" <?php echo ($this->session->userdata('time_formate')== '9.5')?'selected':''?>> (GMT +9.5)</option>
					  <option value="10" <?php echo ($this->session->userdata('time_formate')== '10')?'selected':''?>> (GMT +10)</option>
					  <option value="10.5" <?php echo ($this->session->userdata('time_formate')== '10.5')?'selected':''?>> (GMT +10.5)</option>
					  <option value="11" <?php echo ($this->session->userdata('time_formate')== '11')?'selected':''?>> (GMT +11)</option>
					  <option value="11.3" <?php echo ($this->session->userdata('time_formate')== '11.3')?'selected':''?>> (GMT +11.3)</option>
					  <option value="12" <?php echo ($this->session->userdata('time_formate')== '12')?'selected':''?>> (GMT +12)</option>
					  <option value="12.75" <?php echo ($this->session->userdata('time_formate')== '12.75')?'selected':''?>> (GMT +12.75)</option>
					  <option value="13" <?php echo ($this->session->userdata('time_formate')== '13')?'selected':''?>> (GMT +13)</option>
					  <option value="14" <?php echo ($this->session->userdata('time_formate')== '14')?'selected':''?>> (GMT +14)</option></select> 
			</div>
					<div class="header-search">
						<div class="search-box">
							<div class="row">
								<!-- <form>
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-9" style="padding-right:0">
										<input type="text" class="form-control" name="search" placeholder="Search With Events" >
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3" style="padding-left:0">
										<button type="submit" class="btn-search form-control">
											<i class="fa fa-search"></i> 
										</button>
									</div>
								</form> -->
							</div>
						</div>
					</div>
					 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pad-l">
                        <div class="change-color">
               <h3><?php if($this->session->userdata('session_color') == "black"){ ?><span style="color:white">Choose Color</span> <?php } else { ?> Choose Color <?php } ?></h3>
                <span class="blue change_color" data-color ="blue" value="blue" id="blue"></span>
                <span class="orange change_color" data-color ="orange" value="orange" id="orange"></span>
                <span class="purple change_color" data-color ="purple" value="purple" id="purple"></span>
                <span class="green change_color" data-color ="green" value="green" id="green"></span>
                <span class="black change_color" data-color ="black" value="black" id="black"></span>
                </div>
                        </div>
			</div>
			
        </div>
    </div>   <!-- /.container -->
</nav>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
<script>
//FOR DATE
document.getElementById("para1").innerHTML = formatAMPM();
formatAMPMd();
function formatAMPM() {
var d = new Date(),

    minutes = d.getMinutes().toString().length == 1 ? '0'+d.getMinutes() : d.getMinutes(),
    hours = d.getHours().toString().length == 1 ? '0'+d.getHours() : d.getHours(),
    ampm = d.getHours() >= 12 ? ' PM' : ' AM';
  months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
   days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
	return hours+':'+minutes+ampm;
return days[d.getDay()]+' '+months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear()+' '+hours+':'+minutes+ampm;
}

function formatAMPMd() {
var d = new Date(),

    minutes2 = d.getMinutes().toString().length == 1 ? '0'+d.getMinutes() : d.getMinutes(),
    hours2 = d.getHours().toString().length == 1 ? '0'+d.getHours() : d.getHours(),
   // ampm2 = d.getHours() >= 12 ? ' PM' : ' AM';
  months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
   days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
	var my_date = months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear();
	var my_time = months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear()+' '+hours2+':'+minutes2;
	//alert(my_date);
	
	$.post("<?php echo base_url();?>home/get_date/",{
				date : my_date,
				date_time : my_time
			}).done(function(data){
				//console.log(data)
				
			});
			
return days[d.getDay()]+' '+months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear()+' '+hours2+':'+minutes2;

}

</script>

<head>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-75879691-1', 'auto');
  ga('send', 'pageview');

</script>
	</head>