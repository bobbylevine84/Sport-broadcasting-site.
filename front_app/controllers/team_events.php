<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Team_events extends CI_Controller {

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
           // $this->data['content'] = $this->index_model->get_content();
			$this->data['news1'] = $this->index_model->get_news1();
			$this->data['games'] = $this->index_model->get_my_games();
			$this->data['news'] = $this->index_model->get_news();
			$this->data['footer'] = $this->index_model->get_footer_content();
			//$this->data['footer_events'] = $this->index_model->get_footer_events();
			$this->data['get_team_events']=$this->index_model->get_team_events($id);
			//echo "<pre>";print_r($this->data['get_team_events']);exit;
		   $this->load->view('view_team_events', $this->data);
        } else {
            redirect('home/dashboard');
        }
    }
	public function events($id = NULL) {

		$url = site_url("home");
		$this->data['social_icons'] = $this->index_model->get_social_icons();
		$this->data['get_my_header'] = $this->index_model->get_header_menus();
		//$this->data['content'] = $this->index_model->get_content();
		$this->data['news'] = $this->index_model->get_news();
		$this->data['news1'] = $this->index_model->get_news1();
		$this->data['games'] = $this->index_model->get_my_games();
		$this->data['footer'] = $this->index_model->get_footer_content();
		//$this->data['footer_events'] = $this->index_model->get_footer_events();
		$this->data['get_team_events']=$this->index_model->get_team_events($id);
		//echo "<pre>";print_r($this->data['get_team_events']);exit;
		$this->load->view('view_team_events', $this->data);

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
}
