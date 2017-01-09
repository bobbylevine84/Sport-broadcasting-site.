<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Wiziwig</title>
        <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/images/favicon.ico">
        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>assets/login/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/login/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/login/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/login/css/jquery-ui.min.css" rel="stylesheet">
        <!-- <link href="<?php //echo base_url(); ?>assets/login/css/dataTables.bootstrap.min.css" rel="stylesheet"> -->
        <link href="<?php echo base_url(); ?>assets/login/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/login/css/dashboard.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/login/css/div-scroll.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/login/css/jquery.mCustomScrollbar.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/login/css/perfect-scrollbar.css" rel="stylesheet">

        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,500,700,600,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
        <script src="<?php echo base_url(); ?>assets/login/js/jquery-2.1.4.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/login/js/jquery-ui.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script> 
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/login/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/login/js/jquery.mCustomScrollbar.concat.min.js"></script>
        <!-- <script src="<?php //echo base_url(); ?>assets/login/js/dataTables.bootstrap.min.js"></script> -->
        <!-- <script defer src="<?php //echo base_url();  ?>assets/js/withdraw.js"></script> -->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script type="text/javascript">
            var $nojquheader = jQuery.noConflict();
            $nojquheader(document).ready(function () {
                $nojquheader(".flash_message_div").delay(4000).fadeOut();
            });
        </script>

    </head>
    <style type="text/css">
        .image-show-modal{
            padding: 5px;
            margin-right: 50px;
            width: 70px;
            height: 70px;
        }
    </style>
    <body id="dashboard-bg">
        <div id="success_container" class="alert alert-success" style="display: none; right:3%; top:30%;  z-index: 999999; position: fixed; width:30%;  float:right; "></div>
        <div id="error_container" class="alert alert-danger" style="display: none; right:3%; top:30%;  z-index: 999999; position: fixed;  width:30%;  float:right;"></div>

        <?php if ($this->session->flashdata('message')) { ?>
            <div class="alert alert-success flash_message_div" style="right:3%; top:30%;  z-index: 999999; position: fixed; width:30%;  float:right; "><?php echo $this->session->flashdata('message') ?></div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger flash_message_div" style="right:3%; top:30%;  z-index: 999999; position: fixed;  width:30%;  float:right;"><?php echo $this->session->flashdata('error') ?></div>
        <?php } ?>

        <!--header started-->
        <header id="dashboard-header">
            <div class="top-header">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                           <!-- <ul>
                                <li><a href="<?php //echo $_SERVER['HTTP_REFERER']; ?>">Back</a></li>                  
                                <!--<li><a href=<?php //echo base_url(); ?>profile/member/<?php //echo $this->session->userdata('slug'); ?>>Profile</a></li>-->                  
                                <!--<li><a href="<?php //echo base_url(); ?>profile/">Account</a></li>
                                <li><a href="<?php// echo base_url(); ?>transaction">Cashier</a></li>
                                <!--<li><a href="<?php //echo base_url(); ?>home/logout">Logout</a></li>-->
                            </ul>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-header">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                           <!-- <div class="logo-wraper">
                                <a href="<?php// echo base_url(); ?>"> <img src="<?php //echo base_url(); ?>assets/login/images/logo.png"></a>
                            </div> -->
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                            <div class="dashboard-nav">
                                <?php
                               // $messages = $this->my_messages->messages($this->session->userdata('front_user_id'));
                                ?>
                                <ul>
                                   <!-- <li><a href="javascript:;" id="twitter"><i class="fa fa-twitter"></i> Twitter</a></li>                  
                                    <li><a href="javascript:;" id="streams"><i class="fa fa-television"></i> Streams</a></li>
                                    <li><a href="javascript:;" id="followList"><i class="fa fa-plane" ></i> Followed</a></li>
                                    <li><a href="javascript:;" id="online_users_link"><i class="fa fa-users"></i> Online</a></li>                  
                                   <!-- <li><a href="<?php //echo base_url(); ?>messages"><i class="fa fa-envelope"></i> Messages<span id="messages_count"><?php //if ($messages > 0) { ?><span class="badge" style="position: absolute; background-color: #ff0000 ;"><?php// echo $messages; ?></span><?php //} ?></span></a></li>
									
                                    <li><a href="<?php //echo base_url(); ?>leader_board"><i class="fa fa-money"></i> Leaderboard</a></li>-->
                                    <li><a href="<?php echo base_url(); ?>home/logout"><i class="fa fa-user"></i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                       <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12 text-right">
                            <div class="logout-wraper">
                                <p>Welcome</p>
                                <p><strong><?php echo $this->session->userdata('user_name'); ?> </strong></p>
                              <!--  <div class="avialbale-balance">
                                    <h5 class="text">Available Balance: <strong>$<?php// echo $amount; ?></strong> </h5>
                                </div>

                            </div>
                        </div>-->
                    </div>
                </div>
                <input type="hidden" id="login_user_id" value=<?php echo $this->session->userdata('front_user_id'); ?>>
          
            </div>
        </header>

