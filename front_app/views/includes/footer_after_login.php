<!--foooter started-->
<div class="footer-wraper">

    <!--about & news feedback-->
    <div class="container">

        <!--about sigod-->
        <div class="col-md-6">
            <div class="about-wraper">
                <div class="about-img"> <img src="<?php echo base_url(); ?>assets/login/images/footerlogo.png"></div>  

                <?php echo $settings['3']['value']; ?>

<!-- <div class="about-logo"> <img src="<?php echo base_url(); ?>assets/login/images/about-logo.png"> </div> -->



                <div class="about-socail">
                    <a href="<?php echo $social_icons[0]['social_link']; ?>">  <i class="fa fa-facebook"></i>  </a>
                    <a href="<?php echo $social_icons[1]['social_link']; ?>">  <i class="fa fa-twitter"></i>  </a>   
                    <a href="<?php echo $social_icons[2]['social_link']; ?>">  <i class="fa fa-twitch"></i>  </a>   
<!--                    <a href="<?php //echo $social_icons[3]['social_link']; ?>">  <i class="fa fa-google-plus"></i>  </a>   
                    <a href="<?php //echo $social_icons[4]['social_link']; ?>">  <i class="fa fa-youtube"></i>  </a>  -->
                </div>





            </div>
        </div>
        <!--about sigod-->

        <!--NEWS FEEDBACK-->
        <div class="col-md-6">
            <div class="news-wraper">
                <div class="news-heading"> NEWS FEEDBACK </div>

                <div id="footer_news_div">
                </div>
            </div>
        </div>
        <!--NEWS FEEDBACK-->

    </div>
    <!--about & news feedback-->


    <!--copyright-->
    <div class="copyright">
        2015 © SIGOD.com All right reserved 
    </div>
    <!--copyright-->

</div>
<!--foooter ends-->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- <script src="<?php //echo base_url(); ?>assets/login/js/bootstrap.min.js"></script> -->
<script>
    var jfq = jQuery.noConflict();
    jfq(document).ready(function () {
        jfq.ajax({
            url: '<?php echo base_url(); ?>social_me/footer_tweets',
            type: 'POST',
            data: {
                abc: "ads"
            },
            success: function (data) {
                jfq("#footer_news_div").html(jfq.trim(data));
                jfq.ajax({
                    url: '<?php echo base_url(); ?>social_me/instagram',
                    type: 'POST',
                    data: {
                        abc: "ads"
                    },
                    success: function (data) {
                        jfq("#footer_news_div").append(jfq.trim(data));
                    }
                });
            }
        });
    });//document.ready
</script>
</body>

</html>