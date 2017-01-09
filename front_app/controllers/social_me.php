<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Social_me extends CI_Controller {

    public function __construct() {
        parent::__construct();
		require_once('./tweet/Tweetphp.php');
    }

    public function tweets() {
        if (!$this->session->userdata('front_user_id')) {
            echo "login";
            exit;
        }
        //$this->load->library('twitterfetcher');
        $get_tweets = new Tweetphp(array(
            'consumerKey'       => 'S0f78R8e2AhcAf97jQbeugQU3',
            'consumerSecret'    => 'xItlrZu9ynlefIp0koqVQFwA4fdR54XK6ut8Zwh5wjMCaCVSn3',
            'accessToken'       => '2384399959-2PKthn3NXyKYWNJqWQ6KfnZsoFlCIkwHIzZrPzA',
            'accessTokenSecret' => 'CtHFk9sN55Jyn0S68rI3zh9igRaqbG6GTBWPx5Q7kme3O',
            'twitter_screen_name'       => 'SigodGaming'
        ));
        $tweets = $get_tweets->get_tweet_array();
        if(!empty($tweets)) {
            foreach($tweets as $tweet) {
                //echo "<pre>";
                //print_r($tweet);

                echo '<div class="out-wrape" style="border-bottom:1px solid #f1f2f2; margin-bottom:10px; padding-bottom:7px;">';
                echo '<div class="row">';
                echo '<div class="col-sm-2">';
                echo '<div class="news-img">';
                echo '<a target="_blank" href="https://twitter.com/'.$tweet['user']['screen_name'].'" style="text-decoration: none;"><img src="'.$tweet['user']['profile_image_url'].'" class="img-thumbnail" width="60px" height="60px"></a>';
                echo '</div>';
                echo '</div>';
                echo '<div class="col-sm-10" style="padding-left:0; margin-left:-10px">';
                echo '<div class="news-detail" style="padding-top: 0px;">';
                echo '<a target="_blank" href="https://twitter.com/'.$tweet['user']['screen_name'].'" style="color: #337ab7; text-decoration: none;"><div>'.$tweet['user']['name'].'<span style="font-weight:bold">&nbsp;@'.$tweet['user']['screen_name'].'</span></div></a>';
                echo '<p style="font-size:11px; line-height:15px;">'.$tweet['text'].'</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }        
        }
    }
    
    public function footer_tweets() {
        //$this->load->library('twitterfetcher');
//        $get_tweets = new Tweetphp(array(
//            'consumerKey'       => '7Np8gc5C9WhAdoypr5yD1Euyb',
//            'consumerSecret'    => 'Udk3s514CzlxpADtKG6hSDrhpfCKf30dHjJ0IQUaVuSfN09aJs',
//            'accessToken'       => '4208347582-0mXQYXyT1RxOAnNxaMD2hWmFuxLAI8bnWOzDu5T',
//            'accessTokenSecret' => 'zzF7vBYv1MdNgZ0EeLERAiJh9XmSoPkHSbHppLMWTNpfY',
//            'twitter_screen_name'       => 'comsian_faisal'
//        ));.
        $get_tweets = new Tweetphp(array(
            'consumerKey'       => 'S0f78R8e2AhcAf97jQbeugQU3',
            'consumerSecret'    => 'xItlrZu9ynlefIp0koqVQFwA4fdR54XK6ut8Zwh5wjMCaCVSn3',
            'accessToken'       => '2384399959-2PKthn3NXyKYWNJqWQ6KfnZsoFlCIkwHIzZrPzA',
            'accessTokenSecret' => 'CtHFk9sN55Jyn0S68rI3zh9igRaqbG6GTBWPx5Q7kme3O',
            'twitter_screen_name'       => 'SigodGaming'
        ));
        $tweets = $get_tweets->get_tweet_array();
        if(!empty($tweets)) {
            $i = 0;
            foreach($tweets as $tweet) {
                if($i > 0) {
                    break;
                }else {
                    echo '<div class="out-wrape" style="margin-bottom:10px; padding-bottom:7px;">';
                    echo '<div class="row">';
                    echo '<div class="col-sm-2 col-xs-3">';
                    echo '<div class="news-img">';
                    echo '<a target="_blank" href="https://twitter.com/'.$tweet['user']['screen_name'].'" style="text-decoration: none;"><img src="'.$tweet['user']['profile_image_url'].'" class="img-thumbnail" width="60px" height="60px"></a>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="col-sm-10 col-xs-9" style="padding-left:0; margin-left:-10px">';
                    echo '<div class="news-detail" style="padding-top: 0px;">';
                    echo '<a target="_blank" href="https://twitter.com/'.$tweet['user']['screen_name'].'" style="color: #337ab7; text-decoration: none;"><div>'.$tweet['user']['name'].'<span style="font-weight:bold">&nbsp;@'.$tweet['user']['screen_name'].'</span></div></a>';
                    echo '<p style="font-size:11px; line-height:15px;">'.$tweet['text'].'</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                $i++;
                }
            }       
            
            //echo "sadsad";exit;
//    	$this->load->library('instagram_api');
//        $this->instagram_api->access_token = "2290074123.1677ed0.100ce58209234d1794746bda4445df3e";
//        $data = (array)$this->instagram_api->getUserFeed(1);
//        if(!empty($data['data'])) {
//            $i = 0;
//            foreach($data['data'] as $instagram) {
//                //echo $instagram->user->username;exit;
//                if($i > 0) {
//                    break;
//                }else {
//                    echo '<div class="out-wrape" style="margin-bottom:10px; padding-bottom:7px;">';
//                    echo '<div class="row">';
//                    echo '<div class="col-sm-2 col-xs-3">';
//                    echo '<div class="news-img">';
//                    echo '<a target="_blank" href="https://www.instagram.com/'.$instagram->user->username.'" style="text-decoration: none;"><img src="'.$instagram->images->standard_resolution->url.'" class="img-thumbnail" width="60px" height="60px"></a>';
//                    echo '</div>';
//                    echo '</div>';
//                    echo '<div class="col-sm-10 col-xs-9" style="padding-left:0; margin-left:-10px">';
//                    echo '<div class="news-detail" style="padding-top: 0px;">';
//                    echo '<a target="_blank" href="https://www.instagram.com/'.$instagram->user->username.'" style="color: #337ab7; text-decoration: none;"><div>'.$instagram->user->username.'</div></a>';
//                    echo '<p style="font-size:11px; line-height:15px;">&nbsp; '.$instagram->caption->text.'</p>';
//                    echo '</div>';
//                    echo '</div>';
//                    echo '</div>';
//                    echo '</div>';
//                    $i++;
//                }
//            }
//        }
            
        }else {
            echo "empty";
        }
    }
    
    public function instagram($max = null, $min = null) {
        //echo "sadsad";exit;
    	$this->load->library('instagram_api');
//        $this->instagram_api->access_token = "2290074123.1677ed0.100ce58209234d1794746bda4445df3e";
        $this->instagram_api->access_token = "2291215142.1677ed0.b245349aade4457181e0f1efb5cd99e3";
        $data = (array)$this->instagram_api->getUserFeed(1);
        if(!empty($data['data'])) {
            $i = 0;
            foreach($data['data'] as $instagram) {
                //echo $instagram->user->username;exit;
                if($i > 0) {
                    break;
                }else {
                    echo '<div class="out-wrape" style="margin-bottom:10px; padding-bottom:7px;">';
                    echo '<div class="row">';
                    echo '<div class="col-sm-2 col-xs-3">';
                    echo '<div class="news-img">';
                    echo '<a target="_blank" href="https://www.instagram.com/'.$instagram->user->username.'" style="text-decoration: none;"><img src="'.$instagram->images->standard_resolution->url.'" class="img-thumbnail" width="60px" height="60px"></a>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="col-sm-10 col-xs-9" style="padding-left:0; margin-left:-10px">';
                    echo '<div class="news-detail" style="padding-top: 0px;">';
                    echo '<a target="_blank" href="https://www.instagram.com/'.$instagram->user->username.'" style="color: #337ab7; text-decoration: none;"><div>'.$instagram->user->username.'</div></a>';
                    echo '<p style="font-size:11px; line-height:15px;">&nbsp; '.$instagram->caption->text.'</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    $i++;
                }
            }
        }
//    	echo "<pre>";
//        print_r($data);
//        exit;
    }
}
