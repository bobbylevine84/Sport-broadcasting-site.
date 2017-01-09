 

<section id="dashboard-home">
    <div class="container">
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12" style="background:#000">
            <div class="dashboard-left">
                <ul class="listing-wraper row"> 
                    <li class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="match-heading">my matches</div>
                        <div class="product-button"><a href="#"> create challenge   </a>  </div>
                    </li>
                    <li class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="match-heading">find a match</div>
                        <div class="product-button"><a href="#"> create challenge </a>  </div>
                    </li>
                    <li class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="match-heading">OPEN CHALLENGES</div>
                        <div class="product-button"><a href="#">  create challenge  </a>  </div>
                    </li>
                    <li class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="match-heading">MY TOURNAMENTS</div>
                        <div class="product-button"><a href="#">  create challenge  </a>  </div>
                    </li>        
                </ul>
            </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
            <div class="locker-wrapper">
                <div class="locker-heading">Change Account Settings</div>
                <div class="chat-box">
                    <form role="form" method="post" id="change_form" action="<?php echo base_url(); ?>profile/account">
                        <div class="form-group">
                            <label for="email" >Email address:</label>
                            <?php
                            foreach ($userdata as $data) {
                                ?>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $data['email_address']; ?>">
                                <?php
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="password" >Old Password:</label>
                            <input type="password" name="old_password" class="form-control" id="old_password">
                        </div>
                        <div class="form-group">
                            <label for="password" >New Password:</label>
                            <input type="password" class="form-control" id="new_password" id="new_password">
                        </div>
                        <div class="form-group">
                            <label for="password" >Confirm Password:</label>
                            <input type="password" name="confirm_password"  class="form-control" id="confirm_password">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="confirm_password"  class="btn btn-success" id="submit_chnage">
                        </div>

                    </form>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
</section> 
<script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>


<script>
    var $jquery = jQuery.noConflict();
    $jquery(document).ready(function ()
    {
        $jquery("#change_form").validate({
            rules:
                    {
                        email:
                                {
                                    required: true,
                                    email: true,
                                    remote:
                                            {
                                                url: "<?php echo base_url(); ?>profile/validate_email",
                                                type: "post"
                                            }
                                },
                        old_password:
                                {
                                    required: true,
                                    remote:
                                            {
                                                url: "<?php echo base_url(); ?>profile/validate_password",
                                                type: "post"
                                            }
                                },
                        new_password:
                                {
                                    required: true,
                                    minlength: 5
                                },
                        new_password:
                                {
                                    required: true,
                                    minlength: 5
                                }
                    },
            messages: {
                email: {
                    required: "This field is required",
                    email: "Invalid Email Address",
                    remote: "Email address already in use."
                }
            },
            submitHandler: function (form)
            {
                if (validForm)
                    alert("valid");
                else
                    alert("invalid");
            },
        });

    });

</script>
<?php $this->load->view('includes/footer_after_login'); ?>