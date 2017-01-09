<!-- CENTER CONTENT SECTION -->	
<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-8  col-md-offset-3">
            <div id="profile-box">
                <div class="row">
                    <?php $image_location = base_url() . 'uploads/users/' . $user_image; ?>
                    <div class='col-lg-4 user-image'>
                        <img class="img-thumbnail" src=<?php echo $image_location; ?>>
                    </div>
                    <div class='col-lg-6 user-data'>
                        <h2 class="username-text"><strong><?php echo $user[0]['user_name']; ?></strong></h2><br>
                        <!--<p><strong><?php //echo $user[0]['user_name']; ?></strong></p>-->
                    </div>
                </div>
                <br>
                <h3 class="username-text"><?php echo $user[0]['first_name']." ".$user[0]['last_name']; ?></h3><br>
                <div id="follow-button">
                    <?php
                    if ($user[0]['front_user_id'] != $this->session->userdata('front_user_id')) {
                        if ($following) {
                            echo '<a href="javascript:;"  id="unfollow-user" class="btn btn-primary">Unfollow ' . $first_name . '</a>';
                        } else {
                            echo '<a href="javascript:;"  id="follow-user" class="btn btn-primary">Follow ' . $first_name . '</a>';
                        }
                    }
                    ?>

                    <?php
                    if ($user[0]['front_user_id'] != $this->session->userdata('front_user_id')) {
                        echo '<a href="javascript:;" id="send_message" class="btn btn-primary">Send Message</a>';
                    }
                    ?>

<?php
if ($user[0]['front_user_id'] != $this->session->userdata('front_user_id')) {
    echo '<a href="javascript:;" id="challenge_user" class="btn btn-primary">Send Challenge</a>';
}
?>
                    <br><br>	
                </div>

                <!--<p class="user-data"><img src="<?php //echo base_url(); ?>users/<?php //echo $user[0]['country']; ?>" /></p><br><br><br>Further contents-->
            </div><br>
        </div>
    </div>
</div>
</div>

<div class="modal fade modal_style_class" id="send_message_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title texts">Send Message</h4>
            </div>
            <div id="modal_body_data" class="modal-body">
                <input type="hidden" id="this_id" value="<?php echo $user[0]['front_user_id']; ?>" />
                <textarea class="form-control" id="message_text"></textarea>
                <span>Press enter to send message</span>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-primary" id="submit_message">Send Message</button>-->
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade modal_style_class" id="send_challenge_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title texts">Send Challenge</h4>
            </div>
            <div id="modal_body_data" class="modal-body">
                <form role="form" id="create_challange" method="post" action="<?php echo base_url(); ?>profile/create_challange">
                    <input type="hidden" class="challenge_type" name="challenge_type" value="user">
                    <input type="hidden" class="this_slug" name="this_slug" value="<?php echo $user[0]['front_user_name_slug']; ?>">
                    <input type="hidden" class="form-control" name="user_id_hidden" id="user_id_hidden" value="<?php echo $user[0]['front_user_id']; ?>">
                    <div class="form-group ">
                        <label for="device" class="label">Choose A Device:</label>
                        <select class="form-control" id="consoles" name="device">
                            <option value="">Choose Console</option>
                            <?php
                            foreach ($consoles as $console) {
                                ?>
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
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-primary" id="submit_message">Send Message</button>-->
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!-- END CONTENT SECTION -->
<script type="text/javascript">


    /*FOLLOW USER*/
    $nocon('#follow-user').click(function () {

        /*follow by is us who is login follow to is other person*/
        var post_data = 'followby=' + <?php echo $this->session->userdata('front_user_id'); ?> + '&followto=' + <?php echo $front_user_id; ?>;

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>profile/follow_people',
            data: post_data,
            success: function (response) {
                if (response == 1) {
                    setTimeout(function () {
                        location.reload();
                    }, 10);
                }
            }



        });
    });

    $nocon(document).on("click", "#send_message", function () {
        $nocon("#message_text").val("");
        $nocon("#send_message_modal").modal("show");
    });

    $nocon(document).on("click", "#challenge_user", function () {
        $nocon("#send_challenge_modal").modal("show");
    });

    $nocon(document).on("keypress", "#message_text", function (e) {
        if (e.which == 13) {
            var tag = this;
            if ($nocon.trim($nocon(tag).val()) == "") {
                $nocon("#error_container").html("Sorry! empty message not allowed.");
                $nocon("#error_container").show().delay(4000).fadeOut();
                return false;
            }
            var message = $nocon.trim($nocon(tag).val());
            var reciver_u_id = $nocon("#this_id").val();
            $nocon.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>messages/send_message",
                data: {
                    rec_id: reciver_u_id,
                    message: message
                },
                success: function (data) {
                    if ($nocon.trim(data) == "login") {
                        $nocon("#error_container").html("Sorry! your session expired, please login again.");
                        $nocon("#error_container").show().delay(4000).fadeOut();
                    } else if ($nocon.trim(data) != "error") {
                        $nocon("#success_container").html("Message sent successfully.");
                        $nocon("#success_container").show().delay(4000).fadeOut();
                        $nocon("#message_text").val("");
                        $nocon("#send_message_modal").modal("hide");
                    } else {
                        $nocon("#error_container").html("Something went wrong, please try again later.");
                        $nocon("#error_container").show().delay(4000).fadeOut();
                    }
                }
            });
        }
    });
    /*UNFOLLOW USER*/
    $nocon('#unfollow-user').click(function () {

        /*follow by is us who is login follow to is other person*/
        var post_data = 'followby=' + <?php echo $this->session->userdata('front_user_id'); ?> + '&followto=' + <?php echo $front_user_id; ?>;

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>profile/unfollow_people',
            data: post_data,
            success: function (response) {
                if (response == 1) {
                    setTimeout(function () {
                        location.reload();
                    }, 10);
                }
            }



        });
    });
</script>

<script>
    var $con = jQuery.noConflict();
    $con(document).ready(function () {
        $con('#consoles').change(function () {
            $con.ajax({
                url: '<?php echo base_url(); ?>profile/get_games',
                type: 'POST',
                dataType: 'json',
                data: {consoles: $con(this).val()},
                success: function (data)
                {
                    var states = $con.parseJSON(JSON.stringify(data));

                    var gameDropdown = $con('#gameDropdown');
                    var gameTextbox = $con('#gameTextbox');
                    if (states == null)
                    {
                        gameTextbox.show();
                        gameDropdown.hide();
                        $con('#game_container').hide();
                    }
                    else {
                        if (states == "") {
                            $con('#game_container').slideUp();
                        } else {
                            $con('#game_container').slideDown();
                        }

                        gameTextbox.hide();
                        gameDropdown.show()
                                .find('option')
                                .remove();

                        $con.each(states, function (key, value)
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

        $con("#create_challange").validate({
            errorClass: "my-error-class",
            validClass: "my-valid-class",
            rules: {
                device: {
                    required: true
                },
                gameDropdown: {
                    required: true
                },
                amount:
                        {
                            required: true,
                            number: true,
                            min: 3,
                            remote: {
                                url: "<?php echo base_url(); ?>profile/validate_amount",
                                type: "post"
                            }
                        },
                comments: {
                    required: true
                }
            },
            messages: {
                amount: {
                    remote: "You Don't Have Enough Amount In Your Wallet",
                    min: "Minimum amount for 1v1 challenge is $3"
                }
            },
        });

    });
</script>