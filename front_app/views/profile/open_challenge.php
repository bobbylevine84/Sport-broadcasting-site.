<!--dashboard home page started-->
<section id="dashboard-home">
<div class="container">
<div class="row">    
    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
    <div class="form-bg" style="margin:0; padding:15px">
    	<div class="row">
        	<div class="col-md-4">
        <select id="challenge_types" class="form-control reload_challenges">
            <option value="">Open Challenges</option>
            <option value="my_matches">My Challenges</option>
            <option value="sent" <?php echo ($type == "sent")? "selected": ""; ?>>1v1 Challenges (Sent)</option>
            <option value="received" <?php echo ($type == "received")? "selected": ""; ?>>1v1 Challenges (Received)</option>
        </select>
    </div>
    <div class="col-md-4">
        <select class="form-control reload_challenges" id="consoles" name="device">
            <option value="">All Consoles</option>
            <?php foreach ($consoles as $console) { ?>
                <option value="<?php echo $console['id']; ?>"><?php echo $console['name']; ?></option>
            <?php } ?>
        </select>
    </div>
    <div id="game_container" class="col-md-4 reload_challenges" style="display: none;">
        <select class="form-control" name="gameDropdown" id="gameDropdown">
            <option value="">All Games</option>
        </select>
    </div>
        </div>
        <div id="examples">
        <div class="content mCustomScrollbar light" data-mcs-theme="minimal-dark">
        <div class="error_container" id="error_container"></div>
        <ul id="open_challenges_ul" class="list-group">
            <?php
            if(!empty($challanges)) {
            foreach ($challanges as $console) {
                ?>
            <li class="list-group-item" id="open_challange_<?php echo $console['id']; ?>" style="padding-top: 25px; padding-bottom: 25px; margin-top: 10px;"><span><strong><?php echo $console['game'] . '    -   ' . $console['console'] . '    -   ' . '($' . $console['amount'] . ')'; ?> </strong><br>Created by: <?php echo $console['user_name']?></span>
                    <?php
                    if ($console['user'] == $this->session->userdata('front_user_id')) {
                        ?>
                        <button style="float: right; padding-top: 6px; margin-top: -5px;" id="" class="btn btn-primary" onClick="callCrudAction('cancel', '<?php echo $console['id']; ?>', '<?php echo $console['amount']; ?>')" type="submit">Cancel Challenge</button>
                        <?php
                    } else {
                        ?>
                        <button style="float: right; padding-top: 6px; margin-top: -5px;" class="btn btn-success accept_challenge" data-id="<?php echo $console['id']; ?>" data-user="<?php echo $console['user']; ?>" data-game="<?php echo $console['game']; ?>" data-console="<?php echo $console['console']; ?>" data-comment="<?php echo $console['comments']; ?>" data-amount="<?php echo $console['amount']; ?>" data-console_id="<?php echo $console['console_id']; ?>" data-game_id="<?php echo $console['game_id']; ?>" >Accept Challenge</button>
                        <?php
                    }
                    ?>
                </li>
                <?php
            } }else {
            ?>
                <div class="col-md-12 text-center no_record_found">No Challenges Found</div>
            <?php } ?>
        </ul>
        </div>
        </div>
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
</div>
</section>


</div>

<div class="modal fade modal_style_class" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title texts">Accept Challenge</h4>
            </div>
            <div class="modal-body">
                <p id="challenge_detail" class="text text-info"></p>
                <p class="text text-danger"><strong>Comments/Rules : <span id="user1_comments"></span></strong></p>
                <div class="clearfix"></div>

                <form role="form" id="challenge_accept">
                    <div class="form-group">
                        <label for="comment">Comment:</label>
                        <div class="clearfix"></div>
                        <textarea class="form-control" name="comment_2" rows="5" id="comment" placeholder="Enter any pre-match rules/stipulations or comments with your fellow/potential opponent(s) "></textarea>
                    </div>
                    <div id="accept_error"></div>
                    <div class="form-group">
                        <div class="clearfix"></div>
                        <input type="hidden" name="challange_id" id="challenge_id" value="" />
                        <input type="hidden" name="price" id="dialog_challenge_price" value="" />
                        <input type="hidden" name="console" id="dialog_challenge_console" value="" />
                        <input type="hidden" name="game" id="dialog_challenge_game" value="" />
                        <input type="hidden" name="user" id="dialog_challenge_user" value="" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="challange_accept_form_submit">Accept Challenge</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
</section>
<script>
var $nojqu = jQuery.noConflict();
$nojqu(document).ready(function () {
    
    var type_load = $nojqu("#challenge_types").val();
    var console_load = $nojqu("#consoles").val();
    var game_load = $nojqu("#gameDropdown").val();
    reload_all_data(type_load, console_load, game_load);
    
    $nojqu(document).on("click", ".cancel_my_challenge", function() {
        var action = $nojqu(this).data("type");
        var id = $nojqu(this).data("id");
        var value = $nojqu(this).data("amount");
        callCrudAction(action, id, value);
    });
    
    $nojqu(document).on("change", ".reload_challenges", function() {
        var type = $nojqu("#challenge_types").val();
        var console = $nojqu("#consoles").val();
        var game = $nojqu("#gameDropdown").val();
        reload_all_data(type, console, game);
    });
    
    function reload_all_data(type, console, game) {
        $nojqu.ajax({
            url: '<?php echo base_url(); ?>profile/get_filtered_challenges',
            type: 'POST',
            data: {
                type: type,
                console: console,
                game: game
            },
            success: function (data) {
                if($nojqu.trim(data) == "login") {
                    window.location = "<?php echo base_url(); ?>home";
                }else {
                    $nojqu("#open_challenges_ul").html($nojqu.trim(data));
                }
            }
        });
    }
    
    $nojqu('#consoles').change(function () {
        $nojqu.ajax({
            url: '<?php echo base_url(); ?>profile/get_games',
            type: 'POST',
            dataType: 'json',
            data: {consoles: $nojqu(this).val()},
            success: function (data) {
                var states = $nojqu.parseJSON(JSON.stringify(data));
                var gameDropdown = $nojqu('#gameDropdown');
                var gameTextbox = $nojqu('#gameTextbox');
                if (states == null) {
                    gameTextbox.show();
                    gameDropdown.hide();
                    $nojqu('#game_container').hide();
                } else {
                    gameTextbox.hide();
                    gameDropdown.show().find('option').remove();
                    if (states == "") {
                        $nojqu('#game_container').slideUp();
                        var option = $nojqu('<option></option>').text('All Games').val('');
                        gameDropdown.append(option);
                    } else {
                        $nojqu('#game_container').slideDown();
                        gameDropdown.append($nojqu('<option></option>').text('All Games').val(''));
                        $nojqu.each(states, function (key, value) {
                            var option = $nojqu('<option></option>').text(value.name).val(value.id);
                            gameDropdown.append(option);
                        });
                    }
                }
            }
        });
    });


    $nojqu(document).on("click", ".accept_challenge", function () {
        var game = $nojqu(this).data("game");
        var game_id = $nojqu(this).data("game_id");
        var console = $nojqu(this).data("console");
        var console_id = $nojqu(this).data("console_id");
        var user = $nojqu(this).data("user");
        var amount = $nojqu(this).data("amount");
        var comment = $nojqu(this).data("comment");
        var id = $nojqu(this).data("id");
        if (comment == "") {
            comment = "N/A";
        }
        $nojqu("#challenge_detail").html("<strong>" + game + "</strong>  on  <strong> " + console + "</strong> for <strong>$" + amount + "</strong></strong>");

        $nojqu("#user1_comments").html(comment);
        $nojqu("#challenge_id").val(id);
        $nojqu("#dialog_challenge_price").val(amount);
        $nojqu("#dialog_challenge_console").val(console_id);
        $nojqu("#dialog_challenge_game").val(game_id);
        $nojqu("#dialog_challenge_user").val(user);
        $nojqu("#myModal").modal("show");
    });

    $nojqu("#challange_accept_form_submit").click(function () {
        $nojqu.post("<?php echo base_url(); ?>challenge/accept_challange/", $nojqu("#challenge_accept").serialize()).done(function (data)
        {
            if ($nojqu.trim(data) == "login") {
                location.href = "<?php echo base_url(); ?>home";
            }
            else if ($nojqu.trim(data) == "less_money") {
                $nojqu("#error_container").html("You do not have sufficient balance to accept this challenge.");
                $nojqu("#error_container").show().delay(4000).fadeOut();
            } else if ($nojqu.trim(data) == "success") {
                var id = $nojqu("#challenge_id").val();
                $nojqu("#myModal").modal("hide");
                $nojqu("#open_challange_" + id).remove();
                $nojqu("#success_container").html("Challenge accepted Successfully.");
                $nojqu("#success_container").show().delay(4000).fadeOut();
            } else {
                $nojqu("#error_container").html("Something went wrong, please try again later.");
                $nojqu("#error_container").show().delay(4000).fadeOut();
            }
        });
    });//Login submit
});
</script>

<script>

    var $noCon = jQuery.noConflict();
    function callCrudAction(action, id, value) {
        if (confirm('Are you sure you want to delete this challenge?')) {
            var queryString;
            switch (action)
            {
                case "cancel":
                    queryString = 'action=' + action + '&open_challange_id=' + id + '&amount=' + value;
                    break;
            }
            jQuery.ajax({
                url: "cancel_challange",
                data: queryString,
                type: "POST",
                success: function (data)
                {
                    switch (action)
                    {
                        case "cancel":
                            $noCon('#open_challange_' + id).remove();
                            $nojqu("#error_container").html("Challenge Canceled Successfully.");
                            $nojqu("#error_container").show().delay(4000).fadeOut();
                            break;
                    }
                },
            });
        }
    }

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
                <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function (data) {
                if (Jshout.trim(data) != "empty") {
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
    Jshout(document).ready(function () {
        Jshout("#chat_ul").mCustomScrollbar();
        Jshout("#chat_ul").mCustomScrollbar("scrollTo","bottom",{
            scrollInertia:0
        });
        setInterval('autoRefresh_shout()', 2000);
//        var divx = document.getElementById("chat_ul");
        //divx.scrollTop = divx.scrollHeight;
        Jshout("#shout_input").keyup(function (e) {
            if (e.which == 13) {
                if (Jshout.trim(Jshout("#shout_input").val()) != "") {
                    submit_shout();
                }
            }
        });

        Jshout("#submit_shout").click(function (e) {
            if (Jshout.trim(Jshout("#shout_input").val()) != "") {
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
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function (data) {
                    if (Jshout.trim(data) == "login") {
                        location.href = "<?php echo base_url(); ?>home";
                    } else if (Jshout.trim(data) == "error") {
                        Jshout("#error_container").html("Something went wrong, please try again later.");
                        Jshout("#error_container").show().delay(4000).fadeOut();
                    } else {
                        Jshout("#shout_input").val("");
                    }
                }
            });
        }
    });
</script>