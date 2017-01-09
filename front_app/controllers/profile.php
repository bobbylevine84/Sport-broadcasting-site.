<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("index_model/index_model");
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->load->model("index_model/index_model");
        $this->load->model("profile/profile_model");
        $this->load->model("profile/chats");
    }

    public function index($para = NULL) {
        $this->data['userdata'] = $this->profile_model->get_data();
        $total_amount = $this->index_model->get_amount_info();
        $total_amount = $total_amount[0]['amount'];
        $this->data['amount'] = $total_amount;
        $this->data['country'] = $this->index_model->get_countries();

        $this->data['settings'] = $this->index_model->get_settings();
        $this->data['social_icons'] = $this->index_model->get_social_icons();

        $this->load->view('includes/header_after_login', $this->data);
        $this->load->view('profile/profile', $this->data);
        $this->load->view('includes/footer_after_login');
    }

    public function consoles() {
        $user_id = $this->session->userdata('front_user_id');
        $consoles = $this->input->post('consoles');
        $tags = $this->input->post('tags');
        $count = count($consoles);
        for ($i = 0; $i < $count; $i++) {
            if($consoles[$i] != "" && $tags[$i] != "") {
                $insert_array = array
                    (
                    "console_name" => $consoles[$i],
                    "gamer_tag" => $tags[$i],
                    "user_id" => $user_id
                );
                $query = $this->db->insert("sg_user_console", $insert_array);
            }
        }
        redirect('home/dashboard');
    }

    public function get_messages_count() {
        if ($this->session->userdata('front_user_id')) {
            $count = $this->index_model->get_unread_messages_record($this->session->userdata('front_user_id'));
            echo $count;
        } else {
            echo 0;
        }
    }

    public function submit_my_shout() {
        if (!$this->session->userdata('front_user_id')) {
            echo "login";
            exit;
        }
        $user_id = $this->session->userdata('front_user_id');
        $message = $this->input->post("message");
        if (trim($message) != "") {
            $query = $this->db->insert("kt_shout_messages", array("chat_message" => $message, "front_user_id" => $user_id));
            if ($query) {
                echo "success";
            } else {
                echo "error";
            }
        } else {
            echo "error";
        }
    }

    public function online_users() {
        if (!$this->session->userdata('front_user_id')) {
            echo "login";
            exit;
        }
        $this->db->where("online_status", "1");
        $this->db->where("front_user_id !=", $this->session->userdata('front_user_id'));
        $query = $this->db->get("sg_front_users")->result_array();
        if (!empty($query)) {
            foreach ($query as $user) {
                echo '<p><a href="' . base_url() . 'profile/member/' . $user['front_user_name_slug'] . '"><img src="' . base_url() . 'uploads/users/' . $user['user_image'] . '" width="50px" height="50px" class="img-thumbnail"></img> <span>' . $user['user_name'] . '</span></a></p>';
            }
            echo '<div class="clearfix"></div>';
        } else {
            echo '<div class="col-md-12 text-center no_record">No User Online</div><div class="clearfix"></div>';
        }
    }

    public function load_more_shouts() {
        $id = $this->input->post("last_id");
        $shouts = $this->index_model->get_shout_messages($id);
        if (!empty($shouts)) {
            foreach ($shouts as $shout) {
                echo '<li id="' . $shout['shout_id'] . '" class="row shout_li" style="margin: 0px;">';
                echo '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">';
                echo '<a href="' . base_url() . 'profile/member/' . $shout['slug'] . '"><img src="' . base_url() . 'uploads/users/' . $shout['image'] . '" alt="" class="img-thumbnail"></a>';
                echo '</div>';
                echo '<div class="col-lg-7 col-md-7 col-sm-10 col-xs-8">';
                echo '<h4>' . $shout['name'] . '</h4>';
                echo '<p>' . $shout['shout'] . '</p>';
                echo '</div>';
                echo '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">';
                echo '<div class="date-box">';
                echo '<p>' . date('h:i A', strtotime($shout['date'])) . '</p>';
                echo '<p>' . date('Y-m-d', strtotime($shout['date'])) . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</li>';
            }
            echo '<div class="clearfix"></div>';
        } else {
            echo "empty";
        }
    }

    public function updateProfile() {
        if (!$this->session->userdata('front_user_id')) {
            redirect('home');
        }
        $first_name = $this->input->post("fname");
        $middle_name = $this->input->post("mname");
        $last_name = $this->input->post("lname");
        $full_name = trim($first_name)." ".trim($last_name);
        $old_full_name = trim($this->session->userdata('first_name'))." ".trim($this->session->userdata('last_name'));
        $image = "";

        if ($_FILES['my_image']['name'] != "") {
            $upload_res = $this->upload_it('my_image');
            if ($upload_res['msg'] == 'Upload success !') {
                $data = array('msg' => "Upload success !");
                $data['upload_data'] = $this->upload->data();
                $image = $data['upload_data']['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('profile/profile');
            }
        }
        //if($_FILES['my_image'])
        if ($full_name == $old_full_name) {
            $slug = $this->session->userdata('slug');
        } else {
            $slug = $this->index_model->format_uri($full_name);
            $slug = trim($slug, '-');
            $slug = $this->index_model->member_slug_generator($slug);
        }

//        $user_name = $this->input->post("uname");
        //echo $user_name;exit;
        $dob = $this->input->post("dob");
        $mobile_number = $this->input->post("mobnum");
        $country = $this->input->post("country");
        $country_name = $this->index_model->get_country($country);
        $name_count = $country_name[0]['Country'];
        $state = $this->input->post("stateDropdown");
        $twitch = $this->input->post("twitchid");
        $address = $this->input->post("address");
        if ($this->input->post("email") != '') {
            $email = $this->input->post("email");
            $email_key = md5(rand() . microtime());
        }
        if ($image != "") {
            if ($this->input->post("confirm_password") != '') {
                $confirm_password = $this->input->post("confirm_password");
                $confirm_password = $this->tank_auth->admin_password_hash($confirm_password);
                $update_array = array(
                    "first_name" => $first_name,
//                    "middle_name" => $middle_name,
                    "last_name" => $last_name,
//                    "user_name" => $user_name,
                    "date_of_birth" => $dob,
                    "email_address" => $email,
                    "password" => $confirm_password,
                    "mobile_number" => $mobile_number,
                    "country" => $name_count,
                    "state" => $state,
                    "twitch_id" => $twitch,
                    "front_user_address" => $address,
                    "front_user_name_slug" => $slug,
                    "front_user_email_key" => $email_key,
                    "user_image" => $image
                );
            } else {
                $update_array = array(
                    "first_name" => $first_name,
//                    "middle_name" => $middle_name,
                    "last_name" => $last_name,
//                    "user_name" => $user_name,
                    "date_of_birth" => $dob,
                    "email_address" => $email,
                    "mobile_number" => $mobile_number,
                    "country" => $country,
                    "state" => $state,
                    "twitch_id" => $twitch,
                    "front_user_address" => $address,
                    "front_user_name_slug" => $slug,
                    "front_user_email_key" => $email_key,
                    "user_image" => $image
                );
            }
        } else {
            if ($this->input->post("confirm_password") != '') {
                $confirm_password = $this->input->post("confirm_password");
                $confirm_password = $this->tank_auth->admin_password_hash($confirm_password);
                $update_array = array(
                    "first_name" => $first_name,
//                    "middle_name" => $middle_name,
                    "last_name" => $last_name,
//                    "user_name" => $user_name,
                    "date_of_birth" => $dob,
                    "email_address" => $email,
                    "password" => $confirm_password,
                    "mobile_number" => $mobile_number,
                    "country" => $name_count,
                    "state" => $state,
                    "twitch_id" => $twitch,
                    "front_user_address" => $address,
                    "front_user_name_slug" => $slug,
                    "front_user_email_key" => $email_key
                );
            } else {
                $update_array = array(
                    "first_name" => $first_name,
//                    "middle_name" => $middle_name,
                    "last_name" => $last_name,
//                    "user_name" => $user_name,
                    "date_of_birth" => $dob,
                    "email_address" => $email,
                    "mobile_number" => $mobile_number,
                    "country" => $country,
                    "state" => $state,
                    "twitch_id" => $twitch,
                    "front_user_address" => $address,
                    "front_user_name_slug" => $slug,
                    "front_user_email_key" => $email_key
                );
            }
        }


        $user_id = $this->session->userdata('front_user_id');
        $this->db->where('front_user_id', $user_id);
        $query = $this->db->update("sg_front_users", $update_array);
        if ($query) {
            $this->session->set_flashdata('message', 'Profile Updated Successfully');
            $this->session->set_userdata(array(
                'front_user_id' => $user_id,
                'first_name' => $first_name,
//                'middle_name' => $middle_name,
                'last_name' => $last_name,
//                'user_name' => $user_name,
                'email' => $email,
                'country' => $country,
                'state' => $state
            ));
            redirect('home/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, please try again later');
            redirect('profile/profile');
        }
    }

    public function account_view() {
        $this->data['userdata'] = $this->profile_model->get_data();
        $this->load->view('profile/account_view', $this->data);
    }

    public function validate_email() {
        $email = $this->input->post("email");
        $session_email = $this->session->userdata('email');
        if ($email == $session_email) {
            echo 'true';
        } else {
            $this->db->where("email_address", $email);
            $query = $this->db->count_all_results('sg_front_users');
            if ($query > 0) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }
    
    public function validate_twitch() {
        $twitch = $this->input->post("twitchid");
        if(trim($twitch) != "") {
            $chan = 'https://api.twitch.tv/kraken/channels/'.$twitch.'';
            $json = json_decode(@file_get_contents($chan), true);
            if (!empty($json)) {
                echo "true";
            } else {
                echo "false";
            }
        }else {
            echo "true";
        }
    }

    public function validate_uname() {
        $username = $this->input->post("uname");
        $session_user_name = $this->session->userdata('user_name');
//        echo $session_user_name;exit;
        if ($username == $session_user_name) {
            echo 'true';
        } else {
            $this->db->where("user_name", $username);
            $query = $this->db->count_all_results('sg_front_users');
            if ($query > 0) {
                echo "false";
            } else {
                echo "true";
            }
        }
    }

    public function validate_password() {
        if ($this->session->userdata('front_user_id') != '') {
            $password = $this->input->post('old_password');
            $user_id = $this->session->userdata('front_user_id');
            $this->db->where("front_user_id", $user_id);
            $query = $this->db->get('sg_front_users')->result_array();
            //$db_password = $query[0]['password'];
            if (!empty($query)) {
                $check_password = $this->tank_auth->my_password_match($password, $query[0]['password']);
                if ($check_password) {
                    echo 'true';
                } else {
                    echo 'false';
                }
            }
        }
    }

    public function my_matches() {
        if (!$this->session->userdata('front_user_id')) {
            redirect("home");
        }
        $this->data['matches'] = $this->profile_model->get_pending_matches($this->session->userdata('front_user_id'));
        $total_amount = $this->index_model->get_amount_info();
        $this->data['shouts'] = $this->index_model->get_shout_messages();
        $total_amount = $total_amount[0]['amount'];
        $this->data['amount'] = $total_amount;

        //footer content
        $this->data['settings'] = $this->index_model->get_settings();
        $this->data['social_icons'] = $this->index_model->get_social_icons();

        $this->load->view('includes/header_after_login', $this->data);
        $this->load->view('profile/my_matches');
        $this->load->view('includes/footer_after_login');
    }

    public function filter_my_matches() {
        if (!$this->session->userdata('front_user_id')) {
            echo "login";
            exit;
        }
        $type = $this->input->post("type");
        $matches = $this->profile_model->get_pending_matches($this->session->userdata('front_user_id'), $type);
//        echo "<pre>";
//        print_r($matches);
//        exit;
        if (!empty($matches)) {
            foreach ($matches as $console) {

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
                            $winner_text = '<span class="match_claimed"><a href="' . base_url() . 'profile/member/' . $slug . '">You</a> claimed you won this match. <span>(' . $this->time_ago($console['claim_time']) . ')</span></span>';
                        } else {
                            $winner_text = '<span class="match_claimed"><a href="' . base_url() . 'profile/member/' . $slug . '">' . $winner . '</a> claimed he won this match. <span>(' . $this->time_ago($console['claim_time']) . ')</span></span>';
                        }
                    } else {
                        if ($this->session->userdata('front_user_id') == $console['winner_id']) {
                            $winner_text = '<span class="match_won"><a href="' . base_url() . 'profile/member/' . $slug . '"><strong>You</strong></a> won!!!</span>';
                        } else {
                            $winner_text = '<span class="match_won"><a href="' . base_url() . 'profile/member/' . $slug . '"><strong>' . $winner . '</strong></a> won!!!</span>';
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
                        $dispute_text = '<span class="match_disputed"><a href="' . base_url() . 'profile/member/' . $slug . '">You</a> disputed the match results. <span>(' . $this->time_ago($console['dispute_time']) . ')</span></span>';
                    } else {
                        $dispute_text = '<span class="match_disputed"><a href="' . base_url() . 'profile/member/' . $slug . '">' . $dispute_by . '</a> disputed the match results. <span>(' . $this->time_ago($console['dispute_time']) . ')</span></span>';
                    }
                } else if ($console['match_status'] == "pending") {
                    $claim_text = '<span class="pending_match">No result submitted</span>';
                }

                echo '<li class="list-group-item" id="open_challange_' . $console['id'] . '" style="padding-top: 25px; padding-bottom: 25px; margin-top: 10px;">';
                echo '<div class="col-md-10">';
                echo '<strong>' . $console['game'] . '    -   ' . $console['console'] . '    -   ' . '($' . $console['match_amount'] . ') </strong>';
                echo '<span>(' . $this->time_ago($console['created_date']) . ')</span><br><br>';
                echo '' . $claim_text . $winner_text . $dispute_text . '';
                echo '</div>';
                echo ' <div class="col-md-2">';
                echo '<button style="float: right; padding-top: 6px; margin-top: -5px;" class="btn btn-info view_details" data-id="' . $console['match_id'] . '" >View Details</button>';
                echo '</div>';
                echo '<div class="clearfix"></div>';
                echo '</li>';
            }
        } else {
            echo '<div class="col-md-12 text-center no_record_found">No Matches Found</div>';
        }
    }

    public function match_details() {
        if (!$this->session->userdata('front_user_id')) {
            echo "login";
            exit;
        }
        $id = $this->input->post("id");

        $this->db->select('matches.*, user1.user_name as user1_name, user2.user_name as user2_name, console.console_name, game.game_name, challenges.comments as comment1, challenges.comments2 as comments2');
        $this->db->from('kt_sg_matches AS matches');
        $this->db->join('sg_front_users AS user1', 'user1.front_user_id = matches.challange_by_user AND user1.front_user_flag = "active"');
        $this->db->join('sg_front_users AS user2', 'user2.front_user_id = matches.challange_accepted_by_user AND user2.front_user_flag = "active"');
        $this->db->join('kt_sg_consoles AS console', 'console.consoles_id = matches.match_console_id');
        $this->db->join('kt_sg_consoles_games AS game', 'game.game_id = matches.match_game_id');
        $this->db->join('kt_sg_challanges AS challenges', 'challenges.challenge_id = matches.challenge_id');
        $this->db->where("match_id", $id);
        $this->db->order_by("matches.updated_date", "desc");
        $this->db->group_by("matches.match_id");
        $result = $this->db->get()->result_array();
//        echo "<pre>";
//        print_r($result);exit;
        if (!empty($result)) {
            //echo json_encode($result[0]);
            $comment2 = "N/A";
            if ($result[0]['comments2'] != "") {
                $comment2 = $result[0]['comments2'];
            }
            $comment1 = "N/A";
            if ($result[0]['comments2'] != "") {
                $comment1 = $result[0]['comment1'];
            }
            $claim_text = "";
            $winner_text = "";
            $dispute_text = "";
            if (($result[0]['match_status'] == "claimed" || $result[0]['match_status'] == "completed") && $result[0]['winner_id'] != "") {
                if ($result[0]['challange_by_user'] == $result[0]['winner_id']) {
                    $winner = $result[0]['user1_name'];
                } else {
                    $winner = $result[0]['user2_name'];
                }
                if ($result[0]['match_status'] == "claimed") {
                    if ($this->session->userdata('front_user_id') == $result[0]['winner_id']) {
                        $winner_text = '<span class="match_claimed">You claimed you won this match.</span>';
                    } else {
                        $winner_text = '<span class="match_claimed">' . $winner . ' claimed he won this match. <a href="javascript:;" class="btn btn-danger i_dispute" data-id="' . $result[0]['match_id'] . '">File Dispute</a> <a href="javascript:;" class="btn btn-danger i_lost" data-id="' . $result[0]['match_id'] . '">I Lost</a></span>';
                    }
                } else {
                    if ($this->session->userdata('front_user_id') == $result[0]['winner_id']) {
                        $winner_text = '<span class="match_won"><strong>You</strong> won!!!</span>';
                    } else {
                        $winner_text = '<span class="match_won"><strong>' . $winner . '</strong> won!!!</span>';
                    }
                }
            } else if ($result[0]['match_status'] == "disputed" && $result[0]['disputed_by'] != "") {
                if ($result[0]['challange_by_user'] == $result[0]['disputed_by']) {
                    $dispute_by = $result[0]['user1_name'];
                } else {
                    $dispute_by = $result[0]['user2_name'];
                }
                if ($this->session->userdata('front_user_id') == $result[0]['disputed_by']) {
                    $dispute_text = '<span class="match_disputed">You disputed the match results.</span>';
                } else {
                    $dispute_text = '<span class="match_disputed">' . $dispute_by . ' disputed the match results.</span>';
                }
            } else if ($result[0]['match_status'] == "pending") {
                $claim_text = '<a href="javascript:;" class="btn btn-success i_am_winner" data-id="' . $result[0]['match_id'] . '">I won</a> <a href="javascript:;" class="btn btn-danger i_lost" data-id="' . $result[0]['match_id'] . '">I Lost</a>';
            }
            echo '<p id="match_detail" class="text text-info" style="padding: 10px;"><strong>' . $result[0]['game_name'] . '</strong>  on  <strong> ' . $result[0]['console_name'] . '</strong> for <strong>$' . $result[0]['match_amount'] . ' </strong></strong></p>';
            echo '<p id="created_by" class="text text-info">Created By: ' . $result[0]['user1_name'] . '</p>';
            echo '<p id="created_by_comment" class="text text-danger">Comment: ' . $comment1 . '</p>';
            echo '<p id="accepted_by" class="text text-info">Accepted By: ' . $result[0]['user2_name'] . '</p>';
            echo '<p id="accepted_by_comment" class="text text-danger">Comment: ' . $comment2 . '</p>';
            echo '<div class="clearfix"></div>';
            echo '<hr>';
            echo '<div id="match_results_div" class="col-md-12">' . $claim_text . $winner_text . $dispute_text . '</div>';
            echo '<div class="clearfix"></div>';
        } else {
            echo "error";
        }
    }

    public function claim_winner() {
        if (!$this->session->userdata('front_user_id')) {
            echo "login";
            exit;
        }
        $my_id = $this->session->userdata('front_user_id');
        $id = $this->input->post("id");
        $this->db->select('matches.*, user1.user_name as user1_name, user2.user_name as user2_name');
        $this->db->from('kt_sg_matches AS matches');
        $this->db->join('sg_front_users AS user1', 'user1.front_user_id = matches.challange_by_user');
        $this->db->join('sg_front_users AS user2', 'user2.front_user_id = matches.challange_accepted_by_user AND user1.front_user_flag = "active"');
        $this->db->where("match_id", $id);
        $this->db->order_by("matches.updated_date", "desc");
        $this->db->group_by("matches.match_id");
        $result = $this->db->get()->result_array();
//        echo "<pre>";
//        print_r($result);
//        exit;
        if (!empty($result)) {
            //echo json_encode($result[0]);
            $claim_text = "";
            $winner_text = "";
            $dispute_text = "";
            if (($result[0]['match_status'] == "claimed" || $result[0]['match_status'] == "completed") && $result[0]['winner_id'] != "") {
                if ($result[0]['challange_by_user'] == $result[0]['winner_id']) {
                    $winner = $result[0]['user1_name'];
                } else {
                    $winner = $result[0]['user2_name'];
                }
                if ($result[0]['match_status'] == "claimed") {
                    if ($this->session->userdata('front_user_id') == $result[0]['winner_id']) {
                        $winner_text = '<span class="match_claimed">You claimed you won this match.</span>';
                    } else {
                        $winner_text = '<span class="match_claimed"><strong>' . $winner . '</strong> claimed he won this match. <a href="javascript:;" class="btn btn-danger i_dispute" data-id="' . $result[0]['match_id'] . '">File Dispute</a> <a href="javascript:;" class="btn btn-danger i_lost" data-id="' . $result[0]['match_id'] . '">I Lost</a></span>';
                    }
                } else {
                    if ($this->session->userdata('front_user_id') == $result[0]['winner_id']) {
                        $winner_text = '<span class="match_won">You won!!!</span>';
                    } else {
                        $winner_text = '<span class="match_won"><strong>' . $winner . '</strong> won!!!</span>';
                    }
                }
            } else if ($result[0]['match_status'] == "disputed" && $result[0]['disputed_by'] != "") {
                if ($result[0]['challange_by_user'] == $result[0]['disputed_by']) {
                    $dispute_by = $result[0]['user1_name'];
                } else {
                    $dispute_by = $result[0]['user2_name'];
                }
                if ($this->session->userdata('front_user_id') == $result[0]['disputed_by']) {
                    $dispute_text = '<span class="match_disputed">You disputed the match results.</span>';
                } else {
                    $dispute_text = '<span class="match_disputed">' . $dispute_by . ' disputed the match results.</span>';
                }
            } else if ($result[0]['match_status'] == "pending") {
                $this->db->where("match_id", $id);
                $query1 = $this->db->update("kt_sg_matches", array("match_status" => "claimed", "winner_id" => $my_id, "claim_time" => date("Y-m-d H:i:s")));
                if ($query1) {
                    echo '<span class="match_claimed">You claimed you won this match.</span>';
                    exit;
                } else {
                    echo "error";
                    exit;
                }
            }
            echo '' . $claim_text . $winner_text . $dispute_text . '';
            echo '<div class="clearfix"></div>';
        } else {
            echo "error";
        }
    }

    public function claim_lost() {
        if (!$this->session->userdata('front_user_id')) {
            echo "login";
            exit;
        }
        $my_id = $this->session->userdata('front_user_id');
        $id = $this->input->post("id");
        $this->db->select('matches.*, user1.user_name as user1_name, user2.user_name as user2_name');
        $this->db->from('kt_sg_matches AS matches');
        $this->db->join('sg_front_users AS user1', 'user1.front_user_id = matches.challange_by_user');
        $this->db->join('sg_front_users AS user2', 'user2.front_user_id = matches.challange_accepted_by_user AND user1.front_user_flag = "active"');
        $this->db->where("match_id", $id);
        $this->db->order_by("matches.updated_date", "desc");
        $this->db->group_by("matches.match_id");
        $result = $this->db->get()->result_array();
//        echo "<pre>";
//        print_r($result);
//        exit;
        if (!empty($result)) {
            //echo json_encode($result[0]);
            $claim_text = "";
            $winner_text = "";
            $dispute_text = "";

            if ($result[0]['match_status'] == "completed" && $result[0]['winner_id'] != "") {
                if ($result[0]['challange_by_user'] == $result[0]['winner_id']) {
                    $winner = $result[0]['user1_name'];
                } else {
                    $winner = $result[0]['user2_name'];
                }
                if ($this->session->userdata('front_user_id') == $result[0]['winner_id']) {
                    $winner_text = '<span class="match_won">You won!!!</span>';
                } else {
                    $winner_text = '<span class="match_won"><strong>' . $winner . '</strong> won!!!</span>';
                }
            } else if ($result[0]['match_status'] == "disputed" && $result[0]['disputed_by'] != "") {
                if ($result[0]['challange_by_user'] == $result[0]['disputed_by']) {
                    $dispute_by = $result[0]['user1_name'];
                } else {
                    $dispute_by = $result[0]['user2_name'];
                }
                if ($this->session->userdata('front_user_id') == $result[0]['disputed_by']) {
                    $dispute_text = '<span class="match_disputed">You disputed the match results.</span>';
                } else {
                    $dispute_text = '<span class="match_disputed">' . $dispute_by . ' disputed the match results.</span>';
                }
            } else if ($result[0]['match_status'] == "pending" || $result[0]['match_status'] == "claimed") {
                if ($result[0]['challange_by_user'] == $my_id) {
                    $other_id = $result[0]['challange_accepted_by_user'];
                    $u_name = $result[0]['user2_name'];
                } else {
                    $other_id = $result[0]['challange_by_user'];
                    $u_name = $result[0]['user1_name'];
                }
                $winner = $other_id;
                $amount = $result[0]['match_amount'];
                $half_amount = $amount / 2;
                $looser = $this->session->userdata('front_user_id');

                $this->db->where("id", 1);
                $data = $this->db->get("kt_sg_comissions")->result_array();
                $this->db->where("user_id", $winner);
                $winner_wallet = $this->db->get("kt_sg_wallet")->result_array();
                if (!empty($winner_wallet)) {
                    if (!empty($data)) {
                        $percentage = $data['0']['commission_percentage'];
                        $percentage = 100 - $percentage;
                        $new_amount = ($percentage / 100) * $half_amount;
                        $update_array = array(
                            "match_status" => "completed",
                            "winner_id" => $winner
                        );
                        $this->db->where("match_id", $id);
                        $query = $this->db->update("kt_sg_matches", $update_array);
                        if ($query) {
                            $withdraw_array = array(
                                "transaction_type" => "withdraw",
                                "user_id_fk" => $looser,
                                "amount" => $new_amount,
                                "reason" => "Lost a match"
                            );
                            $this->db->insert("kt_sg_transactions", $withdraw_array);
                            $refund_array = array(
                                "transaction_type" => "refund",
                                "user_id_fk" => $winner,
                                "amount" => $new_amount,
                                "reason" => "Won match"
                            );
                            $this->db->insert("kt_sg_transactions", $refund_array);
                            $new_wallet_money = $winner_wallet[0]['amount'] + $new_amount;
                            $this->db->where("wallet_id", $winner_wallet[0]['wallet_id']);
                            $this->db->update("kt_sg_wallet", array("amount" => $new_wallet_money));

                            $deposit_array = array(
                                "transaction_type" => "deposit",
                                "user_id_fk" => $winner,
                                "amount" => $new_amount,
                                "reason" => "Won match"
                            );
                            $this->db->insert("kt_sg_transactions", $deposit_array);
                            $new_wallet_money = $new_wallet_money + $new_amount;
                            $this->db->where("wallet_id", $winner_wallet[0]['wallet_id']);
                            $this->db->update("kt_sg_wallet", array("amount" => $new_wallet_money));

                            $this->db->where("user_id", 0);
                            $admin_wallet = $this->db->get("kt_sg_wallet")->result_array();

                            $admin_amount = $new_amount * 2;
                            $admin_amount_new = $admin_wallet[0]['amount'] - $admin_amount;
                            $this->db->where("wallet_id", $admin_wallet[0]['wallet_id']);
                            $this->db->update("kt_sg_wallet", array("amount" => $admin_amount_new));

                            echo '<span class="match_won"><strong>' . $u_name . '</strong> won!!!</span>';
                            exit;
                        } else {
                            echo "error";
                            exit;
                        }
                    } else {
                        echo "error";
                        exit;
                    }
                } else {
                    echo "error";
                    exit;
                }
            }
            echo '' . $claim_text . $winner_text . $dispute_text . '';
            echo '<div class="clearfix"></div>';
        } else {
            echo "error";
        }
    }

    public function submit_dispute() {
        if (!$this->session->userdata('front_user_id')) {
            echo "login";
            exit;
        }
        $my_id = $this->session->userdata('front_user_id');
        $id = $this->input->post('match_id', $id);
        $comment = $this->input->post("dispute_comment");
        $files_data = $_FILES;
        $images = array();
        $new_images = "";
        $this->db->select('matches.*, user1.user_name as user1_name, user2.user_name as user2_name');
        $this->db->from('kt_sg_matches AS matches');
        $this->db->join('sg_front_users AS user1', 'user1.front_user_id = matches.challange_by_user');
        $this->db->join('sg_front_users AS user2', 'user2.front_user_id = matches.challange_accepted_by_user AND user1.front_user_flag = "active"');
        $this->db->where("match_id", $id);
        $this->db->order_by("matches.updated_date", "desc");
        $this->db->group_by("matches.match_id");
        $result = $this->db->get()->result_array();
//        echo "<pre>";
//        print_r($result);
//        exit;
        if (!empty($result)) {
            //echo json_encode($result[0]);
            $receiverid = $result[0]['winner_id'];
            $claim_text = "";
            $winner_text = "";
            $dispute_text = "";
            if ($result[0]['match_status'] == "completed" && $result[0]['winner_id'] != "") {
                if ($result[0]['challange_by_user'] == $result[0]['winner_id']) {
                    $winner = $result[0]['user1_name'];
                } else {
                    $winner = $result[0]['user2_name'];
                }
                if ($this->session->userdata('front_user_id') == $result[0]['winner_id']) {
                    $winner_text = '<span class="match_won">You won!!!</span>';
                } else {
                    $winner_text = '<span class="match_won"><strong>' . $winner . '</strong> won!!!</span>';
                }
            } else if ($result[0]['match_status'] == "disputed" && $result[0]['disputed_by'] != "") {
                if ($result[0]['challange_by_user'] == $result[0]['disputed_by']) {
                    $dispute_by = $result[0]['user1_name'];
                } else {
                    $dispute_by = $result[0]['user2_name'];
                }
                if ($this->session->userdata('front_user_id') == $result[0]['disputed_by']) {
                    $dispute_text = '<span class="match_disputed">You disputed the match results.</span>';
                } else {
                    $dispute_text = '<span class="match_disputed">' . $dispute_by . ' disputed the match results.</span>';
                }
            } else if ($result[0]['match_status'] == "claimed") {
                if (!empty($files_data)) {
                    $files = $this->reArrayFiles($files_data['c_img']);
                    foreach ($files as $key => $file) {
                        $result = $this->upload_it_posts($file, $key);
                        if ($result['msg'] == 'Upload success !') {
                            $is_empty = "no";
                            $data1['upload_data'] = $this->upload->data();
                            if ($new_images != "") {
                                $new_images .= ",";
                            }
                            $new_images .= $data1['upload_data']['file_name'];
                        }
                    }
                    if ($new_images == "") {
                        echo $this->upload->display_errors();
                        exit;
                    }
                }
                $this->db->where("match_id", $id);
                $query1 = $this->db->update("kt_sg_matches", array("match_status" => "disputed", "disputed_by" => $my_id, "dispute_time" => date("Y-m-d H:i:s"), "dispute_comment" => $comment, "dispute_files" => $new_images));
                if ($query1) {
                    $msg = 'Dispute filed against your claim. <a href="' . base_url() . 'profile/my_matches">Go to matches</a>';
                    $this->db->insert("tbl_chatting", array("sender_id" => 0, "reciever_id" => $receiverid, "message" => $msg));
                    echo '<span class="match_disputed">You disputed the match results.</span>';
                    exit;
                } else {
                    echo "error";
                    exit;
                }
            }
            echo '' . $claim_text . $winner_text . $dispute_text . '';
            echo '<div class="clearfix"></div>';
        } else {
            echo "error";
        }
    }

    public function reArrayFiles(&$file_post) {
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }

    public function find_match() {
        $this->data['consoles'] = $this->index_model->get_consoles();
        $total_amount = $this->index_model->get_amount_info();
        $this->data['shouts'] = $this->index_model->get_shout_messages();
        $total_amount = $total_amount[0]['amount'];
        $this->data['amount'] = $total_amount;

        //footer content
        $this->data['settings'] = $this->index_model->get_settings();
        $this->data['social_icons'] = $this->index_model->get_social_icons();

        $this->load->view('includes/header_after_login', $this->data);
        $this->load->view('profile/find_match', $this->data);
        $this->load->view('includes/footer_after_login');
    }

    public function open_challenge($type = NULL, $type2 = NULL) {
        if (!$this->session->userdata('front_user_id')) {
            redirect("home");
        }
        $user = $this->session->userdata('front_user_id');
        if($type2 != NULL) {
            if($user == $type2) {
                $this->data['type'] = "sent";
            }else {
                $this->data['type'] = "received";
            }
        }else {
            $this->data['type'] = "";
        }
        $this->data['consoles'] = $this->index_model->get_consoles();
        $this->data['challanges'] = $this->index_model->get_challanges($this->session->userdata('front_user_id'));
        $total_amount = $this->index_model->get_amount_info();
        $this->data['shouts'] = $this->index_model->get_shout_messages();
        $total_amount = $total_amount[0]['amount'];
        $this->data['amount'] = $total_amount;        

        //footer content
        $this->data['settings'] = $this->index_model->get_settings();
        $this->data['social_icons'] = $this->index_model->get_social_icons();

        $this->load->view('includes/header_after_login', $this->data);
        $this->load->view('profile/open_challenge', $this->data);
        $this->load->view('includes/footer_after_login');
    }

    public function get_filtered_challenges() {
        if (!$this->session->userdata('front_user_id')) {
            echo "login";
            exit;
        }
        $type = $this->input->post("type");
        $console = $this->input->post("console");
        $game = $this->input->post("game");

        $challanges = $this->index_model->get_challanges($this->session->userdata('front_user_id'), $type, $console, $game);
        if (!empty($challanges)) {
            foreach ($challanges as $console) {
                if ($console['user'] == $this->session->userdata('front_user_id')) {
                    $button = '<button style="float: right; padding-top: 6px; margin-top: -5px;" id="" class="btn btn-primary cancel_my_challenge" data-type="cancel" data-id="' . $console["id"] . '" data-amount="' . $console["amount"] . '" type="submit">Cancel Challenge</button>';
                } else {
                    $button = '<button style="float: right; padding-top: 6px; margin-top: -5px;" class="btn btn-success accept_challenge" data-id="' . $console['id'] . '" data-user="' . $console['user'] . '" data-game="' . $console['game'] . '" data-console="' . $console['console'] . '" data-comment="' . $console['comments'] . '" data-amount="' . $console['amount'] . '" data-console_id="' . $console['console_id'] . '" data-game_id="' . $console['game_id'] . '>" >Accept Challenge</button>';
                }
                echo '<li class="list-group-item" id="open_challange_' . $console['id'] . '" style="padding-top: 25px; padding-bottom: 25px; margin-top: 10px;"><span><strong>' . $console['game'] . '    -   ' . $console['console'] . '    -   ($ ' . $console['amount'] . ') </strong><br>Created by: ' . $console['user_name'] . '</span>';
                echo $button;
                echo '</li>';
            }
        } else {
            echo '<div class="col-md-12 text-center no_record_found">No Challenges Found</div>';
        }
    }

    public function my_tournaments() {
        $total_amount = $this->index_model->get_amount_info();
        $total_amount = $total_amount[0]['amount'];
        $this->data['amount'] = $total_amount;

        //footer content
        $this->data['settings'] = $this->index_model->get_settings();
        $this->data['social_icons'] = $this->index_model->get_social_icons();

        $this->load->view('includes/header_after_login', $this->data);
        $this->load->view('profile/my_tournaments');
        $this->load->view('includes/footer_after_login');
    }

    public function get_games() {
        $id = $this->input->post("consoles");
        $this->db->select("game_id as id, game_name as name");
        $this->db->where('console_id', $id);
        $this->db->group_by('game_id');
        $query = $this->db->get('kt_sg_consoles_games')->result_array();
        echo json_encode($query);
    }

    public function validate_amount() {
        $user_id = $this->session->userdata('front_user_id');
        $amount = $this->input->post("amount");
        $challange_amount = intval($amount);
        $this->db->where("user_id", $user_id);
        $query = $this->db->get('kt_sg_wallet')->result_array();
        $total_amount = intval($query[0]['amount']);
        if ($total_amount >= $challange_amount) {
            echo "true";
        } else {
            echo "false";
        }
    }

    public function create_challange() {
        if (!$this->session->userdata('front_user_id')) {
            redirect("home");
        }
        $user_id = $this->session->userdata('front_user_id');
        //$this->session->userdata('slug')
        $user2 = $this->input->post("user_id_hidden");
        $console = $this->input->post("device");
        //$console_name=$this->index_model->get_console_name($console);
        //$name_console=$console_name[0]['console_name'];
        $game = $this->input->post("gameDropdown");
        $amount = $this->input->post("amount");
        $comments = $this->input->post("comments");
        $p_slug = $this->input->post("this_slug");
        $type = 'open';
        $challange_status = 'pending';
        if ($user2 == "") {
            $create_challange = array(
                "console_name" => $console,
                "game_name" => $game,
                "amount" => $amount,
                "comments" => $comments,
                "type" => $type,
                "status" => $challange_status,
                "created_by_user" => $user_id
            );
            //$message = "Challenged you to a match"
        } else {
            $create_challange = array(
                "console_name" => $console,
                "game_name" => $game,
                "amount" => $amount,
                "comments" => $comments,
                "type" => "1v1",
                "status" => $challange_status,
                "created_by_user" => $user_id,
                "challenge_to_user_id" => $user2
            );
        }
        $tran_type = 'escrow';
        $status = 'pending';

        $transaction_data = array(
            "transaction_type" => $tran_type,
            "user_id_fk" => $user_id,
            "amount" => $amount,
            "status" => $status
        );
        $total_amount = $this->index_model->get_amount_info();
        $total_amount = $total_amount[0]['amount'];
        $final_amount = $total_amount - $amount;
        //echo '<pre>';print_r($create_challange);print_r($transaction_data);print_r($total_amount);print_r($final_amount);print_r($update_wallet);exit;
        $insert_challange = $this->db->insert("kt_sg_challanges", $create_challange);
        if ($insert_challange) {
//            $c_id = $this->db->insert_id();
            if ($user2 != "") {
                $msg = '1vs1 Challenge set <a href="' . base_url() . 'profile/open_challenge/1v1/'.$user_id.'">Go to challenges</a>';
                //echo $msg;exit;
                $this->db->insert("tbl_chatting", array("sender_id" => $user_id, "reciever_id" => $user2, "message" => $msg));
            }
            $insert_transaction = $this->db->insert("kt_sg_transactions", $transaction_data);
            if ($insert_transaction) {
                $update_wallet = array('amount' => $final_amount);
                $this->db->where('user_id', $user_id);
                $this->db->update('kt_sg_wallet', $update_wallet);
                $this->session->set_flashdata('message', 'Challange has been created.');
                if ($p_slug != "") {
                    redirect('profile/member/' . $p_slug);
                } else {
                    redirect('home/dashboard');
                }
            } else {
                $this->session->set_flashdata('error', 'Something Went Wrong');
                if ($p_slug != "") {
                    redirect('profile/member/' . $p_slug);
                } else {
                    redirect('home/dashboard');
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong');
            if ($p_slug != "") {
                redirect('profile/member/' . $p_slug);
            } else {
                redirect('home/dashboard');
            }
        }
    }

    public function cancel_challange() {
        $action = $this->input->post("action");
        $amount_challange = $this->input->post("amount");
        $user_id = $this->session->userdata('front_user_id');
        if (!empty($action)) {
            switch ($action) {
                case "cancel":
                    $id = $this->input->post("open_challange_id");
                    if (!empty($id)) {
                        $this->db->query("DELETE FROM kt_sg_challanges WHERE challenge_id=$id");
                        $tran_type = 'refund';
                        $status = 'complete';
                        $transaction_data = array(
                            "transaction_type" => $tran_type,
                            "user_id_fk" => $user_id,
                            "amount" => $amount_challange,
                            "status" => $status);
                        $insert_transaction = $this->db->insert("kt_sg_transactions", $transaction_data);
                        if ($insert_transaction) {
                            $total_amount = $this->index_model->get_amount_info();
                            $total_amount = $total_amount[0]['amount'];
                            $final_amount = $total_amount + $amount_challange;
                            $update_wallet = array('amount' => $final_amount);
                            $this->db->where('user_id', $user_id);
                            $this->db->update('kt_sg_wallet', $update_wallet);
                        }
                    }
                    break;
            }
        }
    }

    public function member($slug) {
        if (!$this->session->userdata('front_user_id')) {
            redirect("home");
        }
        $user_data = $this->index_model->get_user_data($slug);
        if (!empty($user_data)) {
            $slug_id = $user_data[0]['front_user_id'];
        } else {
            redirect('home');
        }
        $this->data['consoles'] = $this->index_model->get_consoles();
        $user_data[0]['user'] = $user_data;
        //$slug_id = $this->profile_model->get_user_id_from_slug($slug);
        $user_data[0]['following'] = $this->profile_model->check_if_following($this->session->userdata('front_user_id'), $slug_id);
        $total_amount = $this->index_model->get_amount_info();
        $total_amount = $total_amount[0]['amount'];
        $this->data['amount'] = $total_amount;

        //footer content
        $this->data['settings'] = $this->index_model->get_settings();
        $this->data['social_icons'] = $this->index_model->get_social_icons();

        $this->load->view('includes/header_after_login', $this->data);
        $this->load->view('user/profile', $user_data[0]);
        $this->load->view('includes/footer_after_login');
    }

    public function follow_people() {
        /* FOLLOWED BY , FOLLOWED TO */
        $result = $this->index_model->follow_people($this->input->post('followby'), $this->input->post('followto'));
        if ($result) {
            echo 1;
        }
    }

    public function unfollow_people() {
        /* FOLLOWED BY , FOLLOWED TO */
        $result = $this->profile_model->unfollow_people($this->input->post('followby'), $this->input->post('followto'));
        if ($result) {
            echo 1;
        }
    }

    public function follow_list() {
        $result = $this->profile_model->follow_list($this->input->post('id'));

        $followed_names = array();

        foreach ($result as $key => $value) {
            $followed_names[$key]['name'] = $this->profile_model->username_from_id($value['followed_to']);
            $followed_names[$key]['slug'] = $this->profile_model->get_user_slug($value['followed_to']);
            $followed_names[$key]['image'] = $this->profile_model->get_user_image($value['followed_to']);
        }

        echo json_encode($followed_names);
    }

    public function upload_it($fieldname) {
        $data = NULL;
        //Configure
        //set the path where the files uploaded will be copied. NOTE if using linux, set the folder to permission 777
        $config['upload_path'] = 'uploads/users';
        //echo $config['upload_path'];exit;
        // set the filter image types
        $config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
        $config['max_size'] = '5000';
        //$config['max_width'] = '1170';
        //$config['max_height'] = '223';
        //$config['file_name'] = $this->image_name();
        //load the upload library
        $this->load->library('upload', $config);

        $this->upload->initialize($config);

        $this->upload->set_allowed_types('*');

        $data['upload_data'] = '';

        //if not successful, set the error message
        if (!$this->upload->do_upload($fieldname)) {
            $data = array('msg' => $this->upload->display_errors());
        } else { //else, set the success message
            $data = array('msg' => "Upload success !");

            $data['upload_data'] = $this->upload->data();
        }
        return $data;
    }

    public function time_ago($datetime, $full = false) {
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

    public function upload_it_posts($fieldname, $key) {
        $_FILES['c_img']['name'] = $fieldname['name'];
        $_FILES['c_img']['type'] = $fieldname['type'];
        $_FILES['c_img']['tmp_name'] = $fieldname['tmp_name'];
        $_FILES['c_img']['error'] = $fieldname['error'];
        $_FILES['c_img']['size'] = $fieldname['size'];
        //echo $fieldname['type'];exit;
        $this->load->library('image_lib');
        $data = NULL;
        $config['upload_path'] = 'uploads/matches';
        $config['allowed_types'] = '*';
        $config['max_size'] = '20480';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $data['upload_data'] = '';
        if (!$this->upload->do_upload("c_img")) {
            $data = array('msg' => $this->upload->display_errors());
        } else {
            $data = array('msg' => "Upload success !");
            $data['upload_data'] = $this->upload->data();
            $config = array(
                'source_image' => $data['upload_data']['full_path'],
                'new_image' => 'uploads/matches',
                'maintain_ratio' => true,
                'new_image' => $data['upload_data']['file_name']
            );
            //$this->image_lib->initialize($config);
        }
        return $data;
    }
    
    public function stream($channel) {
        if (!$this->session->userdata('front_user_id')) {
            redirect("home");
        }
        $total_amount = $this->index_model->get_amount_info();
        $total_amount = $total_amount[0]['amount'];
        $this->data['amount'] = $total_amount;
        //footer content
        $this->data['settings'] = $this->index_model->get_settings();
        $this->data['social_icons'] = $this->index_model->get_social_icons();
        
        $this->data['channel'] = $channel;
        $this->load->view('includes/header_after_login', $this->data);
        $this->load->view('test', $this->data);
        $this->load->view('includes/footer_after_login');
    }
    public function twitch_tv() {
        if (!$this->session->userdata('front_user_id')) {
            echo "login";
            exit;
        }
        $this->db->select("twitch_id, user_name");
        $this->db->where("twitch_id !=", "");
        $twitches = $this->db->get("sg_front_users")->result_array();
        $online_array = array();
        $offline_array = array();
        $twitches_user = array();
        if(!empty($twitches)) {
            foreach($twitches as $twitch) {
                $twitches_array[] = $twitch['twitch_id'];
                $twitches_user[$twitch['twitch_id']] = $twitch['user_name'];
            }
            $chan = 'https://api.twitch.tv/kraken/streams?channel='.implode(",", $twitches_array).'';
            $json = json_decode(@file_get_contents($chan), true);
            if(!empty($json['streams'])) {
                foreach($json['streams'] as $abc) {
                    $online_array[] = $abc['channel']['name'];
                }
            }
            $offline_array = array_diff($twitches_array,$online_array);
            $merged = array_merge($online_array, $offline_array);
            if(!empty($merged)) {
                foreach($merged as $chanel) {
                    $online= "";
                    if (in_array($chanel, $online_array)) {
                        $online = '<span class="btn btn-success" style="width: 10px; height: 10px; padding: 4px 0; font-size: 10px;   border-radius: 15px"></span>';
                    }
                    echo '<li>';
                    echo '<a href="'.base_url().'profile/stream/'.$chanel.'">';                    
                    echo '<div class="col-md-9">'.$chanel.'<br>('.$twitches_user[$chanel].')</div>';
                    echo '<div class="col-md-3 text-right">';
                    echo '&nbsp; '.$online.'';
                    echo '</div>';
                    echo '<div class="clearfix"></div>';
                    echo '</a>';
                    echo '</li>';
                    echo '<div class="clearfix"></div>';
                    
                }
            }else {
                echo "empty";
            }
        }else {
            echo "empty";
        }
        
        
//        $chan = "";
//	$streams = array(
//	"ridesideways"
//	);
//	echo "<span class=\"smalltext\"><strong>Live User Streams:</strong> ";
//	foreach ($streams as &$i) {
//		$chan = "https://api.twitch.tv/kraken/streams/" . $i;
////                echo "<pre>"; print_r($chan);exit;                
//		//$json = file_get_contents($chan);
//                $json = json_decode(@file_get_contents($chan));
//                
//                
//                //echo '<iframe src="https://www-cdn.jtvnw.net/swflibs/TwitchPlayer.swf?channel=ridesideways" frameborder="0" scrolling="no" height="460px;" width="100%"></iframe>';
//                
//                echo "<pre>";
//                print_r($json);
//                echo '<img src="'.$json->stream->preview->large.'" />';exit;
//		$exist = strpos($json, 'name');
//		if($exist) {
//			echo " <a href=\"http://twitch.tv/" . $i . "\">" . $i . "</a>";
//		}
//		
//	}
//	echo "</span><br />";
//        exit;
//        $this->data['test'] = "test";
//        $this->load->view('includes/header_after_login', $this->data);
//        $this->load->view('test', $this->data);
//        $this->load->view('includes/footer_after_login');
    }
}
