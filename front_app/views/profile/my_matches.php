<?php
    function time_ago($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
?>
<!--dashboard home page started-->
<section id="dashboard-home">
    <div class="container">
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
            <div class="form-bg" style="margin:0; padding:15px">
                <div class="row">
                    <div class="col-md-4">
                        <select id="challenge_types" class="form-control reload_challenges">
                            <option value="">All</option>
                            <option value="pending">Current Matches</option>
                            <option value="won">Won</option>
                            <option value="lost">Lost</option>
                            <option value="disputed">Disputed</option>                            
                        </select>
                    </div>
                </div>
                <div id="examples">
                    <div class="content mCustomScrollbar light" data-mcs-theme="minimal-dark">
                        <ul id="open_challenges_ul" class="list-group">
                            <?php
                            if (!empty($matches)) {
                                foreach ($matches as $console) {//echo "<pre>"; print_r($console);exit;
                                    
                                    $claim_text = "";
                                    $winner_text = "";
                                    $dispute_text = "";
                                    if (($console['match_status'] == "claimed" || $console['match_status'] == "completed") && $console['winner_id'] != "") {
//                                        echo $console['challange_by_user'];
                                        if ($console['challange_by_user'] == $console['winner_id']) {
                                            $winner = $console['user1_name'];
                                            $slug = $console['user1_slug'];
                                        } else {
                                            $winner = $console['user2_name'];
                                            $slug = $console['user2_slug'];
                                        }
                                        if ($console['match_status'] == "claimed") {
                                            if ($this->session->userdata('front_user_id') == $console['winner_id']) {
                                                $winner_text = '<span class="match_claimed"><a href="'.base_url().'profile/member/'.$slug.'">You</a> claimed you won this match. <span>('.time_ago($console['claim_time']).')</span></span>';
                                            } else {
                                                $winner_text = '<span class="match_claimed"><a href="'.base_url().'profile/member/'.$slug.'">' . $winner . '</a> claimed he won this match. <span>('.time_ago($console['claim_time']).')</span></span>';
                                            }
                                            
                                        } else {
                                            if ($this->session->userdata('front_user_id') == $console['winner_id']) {
                                                $winner_text = '<span class="match_won"><a href="'.base_url().'profile/member/'.$slug.'">You</a> won!!!</span>';
                                            } else {
                                                $winner_text = '<span class="match_won"><a href="'.base_url().'profile/member/'.$slug.'">' . $winner . '</a> won!!!</span>';
                                            }
                                        }
                                        
                                    } else if ($console['match_status'] == "disputed" && $console['disputed_by'] != "") {
                                        if ($console['challange_by_user'] == $console['disputed_by']) {
                                            $dispute_by = $console['user1_name'];
                                            $slug = $console['user1_slug'];
                                        } else {
                                            $dispute_by = $console['user2_name'];
                                            $slug = $console['user2_slug'];
                                        }
                                        if ($this->session->userdata('front_user_id') == $console['disputed_by']) {
                                            $dispute_text = '<span class="match_disputed"><a href="'.base_url().'profile/member/'.$slug.'">You</a> disputed the match results. <span>('.time_ago($console['dispute_time']).')</span></span>';
                                        } else {
                                            $dispute_text = '<span class="match_disputed"><a href="'.base_url().'profile/member/'.$slug.'">' . $dispute_by . '</a> disputed the match results. <span>('.time_ago($console['dispute_time']).')</span></span>';
                                        }
                                    }else if ($console['match_status'] == "pending") {
                                        $claim_text = '<span class="pending_match">No result submitted</span>';
                                    }
                                    
                                    ?>
                                    <li class="list-group-item" id="open_challange_<?php echo $console['id']; ?>" style="padding-top: 25px; padding-bottom: 25px; margin-top: 10px;">
                                    <div class="col-md-10">
                                        <strong><?php echo $console['game'] . '    -   ' . $console['console'] . '    -   ' . '($' . $console['match_amount'] . ')'; ?> </strong> <span>(<?php echo time_ago($console['created_date']); ?>)</span>
                                        <br><br>
                                        <?php echo '' . $claim_text . $winner_text . $dispute_text . ''; ?>
                                    </div>
                                    <div class="col-md-2">
                                        <button style="float: right; padding-top: 6px; margin-top: -5px;" class="btn btn-info view_details" data-id="<?php echo $console['match_id']; ?>" >View Details</button>
                                    </div>
                                        <div class="clearfix"></div>
                                    </li>
                                    <?php
                                }
                            } else {
                                echo '<div class="col-md-12 text-center no_record_found">No Matches Found</div>';
                            }
                            ?>
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
</section> 
<div class="modal fade modal_style_class" id="match_details_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title texts">Accept Challenge</h4>
            </div>
            <div id="modal_body_data" class="modal-body">
                
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-primary" id="challange_accept_form_submit">Accept Challenge</button>-->
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade modal_style_class" id="dispute_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title texts">File Dispute</h4>
            </div>
            <div id="dispute_modal_body" class="modal-body">
                <form id="dispute_form">
                    <input type="hidden" name="match_id" id="dispute_match_id" value="" />
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <div class="form-group">
                        <div class="col-md-12">
                            <textarea id="dispute_comment_field" name="dispute_comment" class="form-control"></textarea>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="dispute_files_div" class="col-md-12">                        
                        <div class="form-group">                        
                            <input type="file" class="dispute_file_field" name="dispute_match_file[]" accept=".jpg,.jpeg,.png,.gif,.mp4,.ogg"/>
                        </div>                        
                    </div>
                    <span id="label_for_dispute_files" class="col-md-12">Allowed extensions jpg, jpeg, png, gif, mp4, ogg (Max size: 20MB)</span>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="form-group">
                        <div class="col-md-12">
                            <a href="javascript:;" id="dispute_add_more">Add more</a>
                        </div>
                    </div>                    
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submit_dispute">File Dispute</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script>

    jQuery(document).ready(function () {
        
        jQuery(document).on("change", ".reload_challenges", function() {
        var type = jQuery(this).val();
        jQuery.ajax({
            url: '<?php echo base_url(); ?>profile/filter_my_matches',
            type: 'POST',
            data: {
                type: type
            },
            success: function (data) {
                if(jQuery.trim(data) == "login") {
                    window.location = "<?php echo base_url(); ?>home";
                }else {
                    jQuery("#open_challenges_ul").html(jQuery.trim(data));
                }
            }
        });
    });

        jQuery(document).on("click", ".view_details", function () {
            var id = jQuery(this).data("id");
            jQuery.ajax({
                type: "POST",
                //dataType: 'json',
                url: "<?php echo base_url(); ?>profile/match_details",
                data: {
                    id: id,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function (data) {
                    if (jQuery.trim(data) == "login") {
                        location.href = "<?php echo base_url(); ?>home";
                    } else if (jQuery.trim(data) != "error") {
                        jQuery("#modal_body_data").html(jQuery.trim(data));
                        jQuery("#match_details_modal").modal("show");
                    } else {
                        jQuery("#error_container").html("Something went wrong, please try again later.");
                        jQuery("#error_container").show().delay(4000).fadeOut();
                    }
                }
            });
        });
        
        jQuery(document).on("click", ".i_am_winner", function() {
            var id = jQuery(this).data("id");
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>profile/claim_winner",
                data: {
                    id: id,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function (data) {
                    if (jQuery.trim(data) == "login") {
                        location.href = "<?php echo base_url(); ?>home";
                    } else if (jQuery.trim(data) != "error") {
                        jQuery("#match_results_div").html(jQuery.trim(data));
                    } else {
                        jQuery("#error_container").html("Something went wrong, please try again later.");
                        jQuery("#error_container").show().delay(4000).fadeOut();
                    }
                }
            });
        }); // I won
        
        jQuery(document).on("click", ".i_lost", function() {
            var id = jQuery(this).data("id");
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>profile/claim_lost",
                data: {
                    id: id,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function (data) {
                    if (jQuery.trim(data) == "login") {
                        location.href = "<?php echo base_url(); ?>home";
                    } else if (jQuery.trim(data) != "error") {
                        jQuery("#match_results_div").html(jQuery.trim(data));
                    } else {
                        jQuery("#error_container").html("Something went wrong, please try again later.");
                        jQuery("#error_container").show().delay(4000).fadeOut();
                    }
                }
            });
        }); // I lost
        
        jQuery(document).on("click", ".i_dispute", function() {
            var id = jQuery(this).data("id");
            jQuery("#match_details_modal").modal("hide");
            jQuery("#dispute_match_id").val(id);
            jQuery("#dispute_modal").modal("show");
        }); // I Dispute
        
        jQuery(document).on("click", "#dispute_add_more", function() {
            jQuery("#dispute_files_div").append('<div class="form-group"><input type="file" class="dispute_file_field" name="dispute_match_file[]" accept=".jpg,.jpeg,.png,.gif,.mp4,.ogg"/></div>');
        }); // Dispute add more
        
        jQuery(document).on("click", "#submit_dispute", function() {
            if(jQuery.trim(jQuery("#dispute_comment_field").val()) == "") {
                jQuery("#error_container").html("Please write something in the textarea to file your dispute");
                jQuery("#error_container").show().delay(4000).fadeOut();
                return false;
            }
            var formdata = new FormData();
            jQuery(".dispute_file_field").each(function( index, element ) {
                jQuery.each(element.files, function(i, file) {
                    formdata.append('c_img[]', file);
                });                
            });
            var other_data = jQuery('#dispute_form').serializeArray();
            jQuery.each(other_data,function(key, input){
                formdata.append(input.name,input.value);
            });
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>profile/submit_dispute",
                data: formdata,
                contentType: false,
                processData: false,	
                success: function (data) {
                    if (jQuery.trim(data) == "login") {
                        location.href = "<?php echo base_url(); ?>home";
                    } else if (jQuery.trim(data) != "error") {
                        jQuery("#match_details_modal").modal("show");
                        jQuery("#dispute_modal").modal("hide");
                        jQuery("#match_results_div").html(jQuery.trim(data));
                    } else {
                        jQuery("#error_container").html("Something went wrong, please try again later.");
                        jQuery("#error_container").show().delay(4000).fadeOut();
                    }
                }
            });
        }); // Submit Dispuite
        
    }); // document.ready
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
//        divx.scrollTop = divx.scrollHeight;
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