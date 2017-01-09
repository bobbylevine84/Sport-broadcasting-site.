<!--dashboard home page started-->
  <section id="dashboard-home">
  <?php if($this->session->flashdata('message')){ ?>
  <p class="alert alert-success" style="width: 371px;margin-left: 475px;"><?php echo $this->session->flashdata('message') ?></p>
<?php } ?>
<?php if($this->session->flashdata('error')){ ?>
  <p class="alert alert-danger" style="width: 371px;margin-left: 475px; text-align:center;"><?php echo $this->session->flashdata('error') ?></p>
<?php } ?>
  <div class="container">
  	<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
    <div class="form-bg" style="margin:0; padding:15px">
	<form role="form" id="create_challange" method="post" action="<?php echo base_url();?>profile/create_challange">
        <div class="form-group">
          <label><input type="radio" class="challenge_type" name="challenge_type" value="open" checked>&nbsp;&nbsp;Open Challenge &nbsp;&nbsp;</label>
          <label><input type="radio" class="challenge_type" name="challenge_type" value="user">&nbsp;&nbsp;Challenge User</label>
        </div>
        <div class="form-group" id="user_field" style="display: none;">
          <label for="user" class="label">Select User</label>
          <input type="text" class="form-control" name="user" id="user_field_val" style="color: #000;">
          <input type="hidden" class="form-control" name="user_id_hidden" id="user_id_hidden" style="color: #000;" value="">
        </div>
    <div class="form-group ">
      <label for="device" class="label">Choose A Device:</label>
      <select class="form-control" id="consoles" name="device">
	  <option value="">Choose Console</option>
	  <?php
	  foreach($consoles as $console)
	  { ?>
		<option value="<?php echo $console['id']; ?>"><?php echo $console['name']; ?></option>
		<?php 
	  }
	  ?>
	  </select>
    </div>
	<div id="game_container" class="form-group" style="display: none;">
      <label for="game" class="label">Choose a Game:</label>
      <select class="form-control" name="gameDropdown" id="gameDropdown">
	  <option value="">Choose Game</option>
	  </select>
    </div>
    <div class="form-group">
      <label for="amount" class="label">Enter Dollar Amount : </label>
      <input type="text" class="form-control" name="amount" id="amount" placeholder="$" style="color: #000;">
    </div>
	<div class="form-group">
      <label for="comments" class="label">Comments/Rules : </label>
      <textarea class="form-control" rows="3" name="comments" id="comment" placeholder="Enter any pre-match rules/stipulations or comments with your  fellow/potential opponents"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  	</div>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
            <div class="locker-wrapper">
                    <div class="locker-heading">The Locker Room</div>
                <div class="chat-box">
                    <ul id="chat_ul" style="height: 431px;">
                        <?php if(!empty($shouts)) { foreach($shouts as $shout) { ?>
                        <li id="<?php echo $shout['shout_id']; ?>" class="row shout_li" style="margin: 0px;">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                                <a href="<?php echo base_url(); ?>profile/member/<?php echo $shout['slug']; ?>"><img src="<?php echo base_url(); ?>uploads/users/<?php echo $shout['image']; ?>" alt="" class="img-thumbnail"></a>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-10 col-xs-7">
                                    <h4><?php echo $shout['name']; ?></h4>
                                <p><?php echo $shout['shout']; ?></p>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="date-box">
                                    <p><?php echo date('h:i A', strtotime($shout['date'])); ?></p>
                                    <p><?php echo date('Y-m-d', strtotime($shout['date'])); ?></p>
                                </div>
                            </div>
                        </li>
                        <?php } } ?>
                    </ul>
                    <div class="row">
                    <div class="chat-form">
                        <span class="left-input"><input type="text" id="shout_input" name="" placeholder="type here" value=""></span>
                        <span class="left-input"><input type="submit" id="submit_shout" name="" value="Send"></span>
                    </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
        </div>
  </div>
  </section> 
<script>
var $jquery=jQuery.noConflict();
    $jquery(document).ready(function() {

        $jquery("#user_field_val").autocomplete({
            source: "<?php echo base_url(); ?>challenge/get_users",
            select: function (event, ui) {
                $jquery("#user_id_hidden").val(ui.item.id);
            }
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            var inner_html = '<div style="vertical-align: center"><div class="image" style="float: left"><img style="border-radius:50%; width:30px; height:30px "  src="<?php echo base_url()."uploads/users/"; ?>' + item.image + '"></div><div style="float: left; padding:5px 10px;">' + item.label + '</div></div><div class="clearfix"></div>';
            return $jquery( "<li></li>" ).data( "item.autocomplete", item ).append(inner_html).appendTo( ul );
    };

        $jquery('input:radio[name=challenge_type]').click(function() {
            var challenge_type = $jquery('input:radio[name=challenge_type]:checked').val();
            if(challenge_type == "user") {
                $jquery("#user_field").slideDown();
            }else {
                $jquery("#user_field").slideUp();
                $jquery("#user_id_hidden").val("");
                $jquery("#user_field_val").val("");
            }
        });

        $jquery("#create_challange").validate({
			errorClass: "my-error-class",
			validClass: "my-valid-class",
            rules: 
			{
                device: 
				{
                    required: true
                },
                gameDropdown: 
				{
                    required: true
                },
                amount: 
				{
                    required: true,
					number: true,
                    remote: 
					{
                        url: "<?php echo base_url();?>profile/validate_amount",
                        type: "post"
                    }
                },
                comments: 
				{
                    required: true
                }
            },
            messages: 
			{
				amount: 
				{
                    remote: "You Don't Have Enough Amount In Your Wallet"
                }
            },
        }); 

        
        $jquery("#create_challange").submit(function() {
            var challenge_type = $jquery('input:radio[name=challenge_type]:checked').val();
            if(challenge_type == "user") {
                if($jquery("#amount").val() < 3) {
                    $jquery("#error_container").html("Minimum amount for 1v1 challenge is $3");
                    $jquery("#error_container").show().delay(5000).fadeOut();
                    return false;
                }
                
                if($jquery("#user_id_hidden").val() == "") {
                    $jquery("#error_container").html("No user selected");
                    $jquery("#error_container").show().delay(5000).fadeOut();
                    return false;
                }
            }
        });


    });
</script>
  
  
  <script>
  var $con=jQuery.noConflict();
    $con(document).ready(function(){
        $con('#consoles').change(function(){
            $con.ajax({
                url: '<?php echo base_url();?>profile/get_games',
                type: 'POST',
				dataType:'json',
                data: { consoles: $con(this).val() },
                success: function(data)
				{
                    var states = $con.parseJSON(JSON.stringify(data));
					
                    var gameDropdown = $con('#gameDropdown');
                    var gameTextbox = $con('#gameTextbox');
                    if(states == null)
					{
                        gameTextbox.show();
                        gameDropdown.hide();
                        $con('#game_container').hide();
                    }
                    else{  
                        if(states == "") {    
                            $con('#game_container').slideUp();              
                        }else {
                            $con('#game_container').slideDown();
                        }
                        
                        gameTextbox.hide();
                        gameDropdown.show()
                            .find('option')
                            .remove();
 
                        $con.each(states, function(key, value)
						{
							
                            var option = $con('<option></option>')
                                            .text(value.name)
                                            .val(value.id);
                            gameDropdown.append(option);
                        });
                    }
                }
            });
        });
 
    });
</script>

<script>
    var Jshout = jQuery.noConflict();
    function autoRefresh_shout() {
        var last_id = Jshout('#chat_ul li.shout_li:last').attr("id");
            Jshout.ajax({
               type: "POST",
               url: "<?php echo base_url() ?>profile/load_more_shouts",  
               data: {
                   last_id: last_id,
                   <?php echo $this->security->get_csrf_token_name(); ?> : '<?php echo $this->security->get_csrf_hash(); ?>'
               },				
               success: function(data) {
                if(Jshout.trim(data) != "empty") {
                    Jshout("#chat_ul").append(Jshout.trim(data));
                    Jshout("#chat_ul").mCustomScrollbar("destroy");
                    Jshout("#chat_ul").mCustomScrollbar();
                    Jshout("#chat_ul").mCustomScrollbar("scrollTo","bottom",{
                        scrollInertia:0
                    });
                    //Jshout("#chat_ul").scrollTop = Jshout("#chat_ul").scrollHeight;
                }
               }

       }); // Load more posts 
     }
    Jshout(document).ready(function() {
        Jshout("#chat_ul").mCustomScrollbar();
        Jshout("#chat_ul").mCustomScrollbar("scrollTo","bottom",{
            scrollInertia:0
        });
        setInterval('autoRefresh_shout()', 2000); 
//        var divx = document.getElementById("chat_ul");
//        divx.scrollTop = divx.scrollHeight;
       Jshout("#shout_input").keyup(function(e) {
           if(e.which == 13) {
               if(Jshout.trim(Jshout("#shout_input").val()) != "") {
                   submit_shout();
               }
           }
       });
       
       Jshout("#submit_shout").click(function(e) {
            if(Jshout.trim(Jshout("#shout_input").val()) != "") {
                submit_shout();
            }
       });
       
       function submit_shout() {
           var message = Jshout.trim(Jshout("#shout_input").val());
           Jshout.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>profile/submit_my_shout",
                data: {
                    message: message,
                    <?php echo $this->security->get_csrf_token_name(); ?> : '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function (data) {
                    if (Jshout.trim(data) == "login") {
                        location.href = "<?php echo base_url(); ?>home";
                    } else if (Jshout.trim(data) == "error") {
                        Jshout("#error_container").html("Something went wrong, please try again later.");
                        Jshout("#error_container").show().delay(4000).fadeOut();
                    }else {
                        Jshout("#shout_input").val("");
                    }
                }
            });
       }
    });
</script>