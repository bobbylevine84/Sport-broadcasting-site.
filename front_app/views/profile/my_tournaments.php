
<script type="text/javascript">var usunick = "<?php echo $nombre; ?>";</script>	

<script>jQuery.noConflict();</script>
  <script src="<?php echo base_url();?>assets/login/chat/prototype.js"></script>
  
  
 	
	

  <!--dashboard home page started-->
  <section id="dashboard-home">
  <?php if($this->session->flashdata('message')){ ?>
  <p class="alert alert-success" style="width: 371px;margin-left: 475px;"><?php echo $this->session->flashdata('message') ?></p>
<?php } ?>
<?php if($this->session->flashdata('error')){ ?>
  <p class="alert alert-danger" style="width: 371px;margin-left: 475px; text-align:center;"><?php echo $this->session->flashdata('error') ?></p>
<?php } ?>
  <div class="container">
      <div class="col-md-12 text-center"><strong>Coming Soon!!!</strong></div>
<!--  	<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
            
        </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
    	<div class="locker-wrapper">
        	<div class="locker-heading">The Locker Room</div>
            <div class="chat-box">
			<div id="chatboxgroup">
			</div>
                <div class="row">
                <div class="chat-form" id="chat-msg">
				<form action='' method='post' onsubmit="var usermsg = $('usermsg').value;comet.doRequest(usermsg); $('usermsg').value=''; return false;">
                	<span class="left-input"><input type="text" id="usermsg" placeholder="Lock Here"></span>
                    <span class="left-input"><input type="submit" id="submitmsg"  value="Lock"></span>
					</form>
            	</div>
                </div>
                <div class="clearfix"></div>
            </div>
            
        </div>
    </div>-->
  </div>
  </section> 
  <script>

		jQuery(document).ready(function(){
        jQuery("#usermsg").focus();
        jQuery("#chat-msg").bind("keypress", function(e)
		{
            if(e.keyCode==13)
			{  
                var jqueryUs = document.getElementById('usermsg');
               var oldscrollHeight = jQuery("#chatboxgroup").prop("scrollHeight") - 20;

                comet.doRequest(jqueryUs.value);
                jqueryUs.value = '';  
               var newscrollHeight = jQuery("#chatboxgroup").prop("scrollHeight");
                   if(newscrollHeight > oldscrollHeight)
                     jQuery("#chatboxgroup").animate({ scrollTop: newscrollHeight }, 'slow'); 
            }
        });
		
		 //cometusers.doRequest("");
        //submitUsers();
        
        //Close window
      //  jQuery(window).unload( function(){
          //  userPart();
       // });
        //Button logout
       // jQuery("#linkLogout").click(function(){
       //     userPart();
      // });
});

</script>
<script>

var Comet = Class.create();
Comet.prototype = {
    timestamp: 0,
    url: "backend",
    noerror: true,
    initialize: function()
	{
		
	},

    connect: function(){
		
        this.ajax = new Ajax.Request(this.url, {
            method: "POST",
            parameters: { 'timestamp': this.timestamp},
            onSuccess: function(transport){
                var response = transport.responseText.evalJSON();
                this.comet.timestamp = response['timestamp'];
                this.comet.handleResponse(response);
                this.comet.noerror = true;
            },
            onComplete: function(transport){
                //Enviando nuevo ajax request
                if(!this.comet.noerror){
                    //Si ocurrio un problema reconectar en 5 segundos
                    setTimeout(function(){comet.connect()}, 50000);
                }else{
                    this.comet.connect();
                    this.comet.noerror = false;
                }
            }
        });
        this.ajax.comet = this;
		
    },
    disconnect: function()
	{
    },
    handleResponse: function(response)
	{
		$("chatboxgroup").innerHTML = '';
        $("chatboxgroup").innerHTML += response["msg"];
    },
    doRequest: function(request)
	{
		
        new Ajax.Request(this.url, 
		{
            method: "POST",
            parameters: {"msg": usunick +": "+ request}
        });
		}
   
}
var comet = new Comet();
comet.connect();
</script>
	

  
  