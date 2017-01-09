<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stream extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->load->model("index_model/index_model");
    }

    public function index($para = NULL) {

        if ($this->session->userdata('front_user_id') == '') {
            $url = site_url("home");
            //$this->data['country'] = $this->index_model->get_countries();
           // $this->data['states'] = $this->index_model->get_states();
            $this->data['settings'] = $this->index_model->get_settings();
            $this->data['social_icons'] = $this->index_model->get_social_icons();
            $this->data['get_my_header'] = $this->index_model->get_header_menus();
            $this->data['games'] = $this->index_model->get_games();
          //  $this->data['content'] = $this->index_model->get_content();
			$this->data['games'] = $this->index_model->get_my_games();
			$this->data['news'] = $this->index_model->get_news();
			 $this->data['news1'] = $this->index_model->get_news1();
			 //$this->data['footer_events'] = $this->index_model->get_footer_events();
			$this->data['footer'] = $this->index_model->get_footer_content();
		   $this->load->view('stream/add_stream', $this->data);
        } else {
            redirect('home/dashboard');
        }
    }
	
function getPage ($url)
{
    $url = 'http://www.google.com/search?q='.urlencode($url);
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com/search?hl=en&q=google&btnG=Google+Search');
        return curl_exec($ch);
    } else {
        return file_get_contents($url);
    }
}

	public function add_stream_process(){
	
	$url = $this->input->post('url');
	$html = $this->getPage($url );
	
	$banner = $this->input->post('banner');	
	$html2 = $this->getPage($banner );

	preg_match('/([0-9\,]+) results<nobr>/si', $html, $match);
	preg_match('/([0-9\,]+) results<nobr>/si', $html2, $match2);
	$value = $match[1] ?: 0;
	$value2 = $match2[1] ?: 0;

	
		
	$rss = $this->load->database('rss', TRUE);
	$event = $this->input->post('event');
	
	//$pieces = explode('.com',$url);
	$result = parse_url($url);
	$pieces2 = $result['host']; // To get www.youtube.com not http://
	$language = $this->input->post('language');
	$audio_bitrate = $this->input->post('audio_bitrate');
	$total_bitrate = $this->input->post('total_bitrate');
	$type = $this->input->post('type');
	$compatibility = $this->input->post('compatibility');
	$channel = $this->input->post('channel');
	
	if($value == "" || $value == 0 && $value2 == "" || $value2 == 0){
		$this->session->set_flashdata('error', 'Stream cannot be submitted');
		redirect('stream');
	} else {
		$insert_arrayy = array(
	"event_id_stream" => $event,
	"url" => $url,
	"stream_domain" => $pieces2,
	"language" => $language,
	"total_bitrate" => $total_bitrate,
	"type" => $type,
	"compatibility" => $compatibility,
	"channel" => $channel,
	"stream_rating" => '50',
	"stream_status" => 'pending'
	);
	$insert_query = $rss->insert('rss_streams',$insert_arrayy);
	if($insert_query){
		$this->session->set_flashdata('ok_message', 'Successful');
		redirect('stream');
	}else{
		$this->session->set_flashdata('error', 'Something went wrong, please try again later');
		redirect('stream');
	}
	$this->session->set_flashdata('ok_message', 'Successful');
	redirect('stream');
	}
	
	}
	
	public function upload_it($fieldname){
		$data =NULL;
		$config['upload_path'] = 'uploads/matches/';
		$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
		$config['max_size']	= '4096';
		//$config['max_width'] = '11700';
       // $config['max_height'] = '2230';
		$this->load->library('upload', $config);
    
    	$this->upload->initialize($config);
    
    	$this->upload->set_allowed_types('*');

		$data['upload_data'] = '';
		if (!$this->upload->do_upload($fieldname)) {
			$data = array('msg' => $this->upload->display_errors());
			$this->session->set_userdata('image_error',$this->upload->display_errors());

		} else { //else, set the success message
			$this->session->unset_userdata('image_error');
			$data = array('msg' => "Upload success !");
      		$data['upload_data'] = $this->upload->data();
		}
		//print_r($data);exit;
		return $data['upload_data']['file_name']; 
	}
	
	public function my_menu(){
		 $this->data['get_my_header'] = $this->index_model->get_header_menus();
		 $this->data['footer'] = $this->index_model->get_footer_content();
		 $this->load->view('includes/header', $this->data);
		 $this->load->view('includes/footer', $this->data);
	}
	public function news($slug = null){
		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		$this->data['footer'] = $this->index_model->get_footer_content();
		$this->data['get_my_news'] = $this->index_model->get_news_by_id($slug);
		$this->data['news'] = $this->index_model->get_news();
		$this->load->view('news', $this->data);
	}
	
	 public function menu($menu_id = NULL) {
		 $this->data['footer'] = $this->index_model->get_footer_content();
        $this->data['get_my_header'] = $this->index_model->get_header_menus();
        $this->data['get_my_header_data'] = $this->index_model->get_header_menus_data($menu_id);
        if ($menu_id == "contact-us") {
            $this->load->view("contact-us", $this->data);
        } else {
            $this->load->view('front_menu/menu_show', $this->data);
        }
    }
	
	
}
