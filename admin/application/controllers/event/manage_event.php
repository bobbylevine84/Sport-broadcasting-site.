<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_event extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		//$this->load->model('sponsor/mod_sponsor');
		$this->load->model('common/mod_common');
		$this->load->model('event/mod_event');
		//$this->load->library('image_lib');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
	//	echo $timezone = $this->input->post('timezone'); // Get time zoneexit;
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(99,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;

		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;
		
		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage event', base_url().'event/manage-event');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(37,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(38,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		//Fetching Pages Results
		$get_event = $this->mod_event->get_all_event();
		$data['event_arr'] = $get_event['event_arr'];
		$data['event_count'] = $get_event['event_count'];
		//echo "<pre>"; print_r($data['event_arr']);exit;
		if(!$this->session->userdata('session_date')){
		$this->load->view('event/get_date', $data);
		} else {
			$this->load->view('event/manage_event',$data);
		}
		
		
	}//end index()
	public function get_date(){
		$my_date = $this->input->post('date');
		$date = date("Y-m-d",strtotime($my_date));
		$this->session->set_userdata('session_date',$date);
		$this->session->userdata('session_date');
		
		$my_date_time = $this->input->post('date_time');
		
		$date_time = date("Y-m-d H:i:s",strtotime($my_date_time));
		$this->session->set_userdata('session_date_time',$date_time);
		$this->session->userdata('session_date_time');
	}
	public function get_date_by_timezone(){
		
		$session_date = date("M d Y H:i:s"); //Get start date here
		$timezone = $this->input->post('timezone'); // Get time zone
		$this->session->set_userdata('my_timezone',$timezone); //Storing time zone in session
		$stored_timezone = $this->session->userdata('my_timezone'); // To display stored session
		
		//to get time zone in Y-m-d H:i:s
		$timezone_date_time = date("Y-m-d H:i:s", strtotime($session_date));

		//To get timezone in Date format
		$timezone_date = date('Y-m-d',strtotime($timezone_date_time));
		
		// Setting Up Sessions......
		$this->session->set_userdata('time_timezone',$timezone_date_time);
		$this->session->set_userdata('date_timezone',$timezone_date);

		//Echoing Sessions.
		echo $time_timezone = $this->session->userdata('time_timezone');
		echo $time_timezone_date = $this->session->userdata('date_timezone');

	}
	public function event_details()
	{
		
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 1;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Event Detail', base_url().'event/Event Details');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view('event/event_detail',$data);
		
	}
	public function add_new_event_detail_process(){
		$detail = $this->input->post('detail');
		
		$update_array = array(
			"detail" => $detail
		);
		$this->db->where('id',1);
		$query = $this->db->update("kt_event_detail", $update_array);
		if ($query) {
				$this->session->set_flashdata('ok_message', 'Successful');
				redirect('event/manage_event/event_details');
				$this->session->set_flashdata('error', 'Something went wrong, please try again later');
				redirect('');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong, please try again later');
			redirect('');
		}
		redirect('event/manage_event/event_details');
		
	}
	
	public function manage_raw_event(){
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;

		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;
		
		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage event/ View event', base_url().'event/manage_event');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(37,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(38,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		//Fetching Pages Results
		$get_event = $this->mod_event->get_event_raw();
		$data['event_arr'] = $get_event['event_arr'];
		$data['event_count'] = $get_event['event_count'];
		
		$this->load->view('event/manage_event_raw',$data);
	}
	
	public function update_event_raw($raw_id){
		//echo $raw_id;exit;
		$update_array = array(
		"event_status_raw" => 'approved'
			);			
		$this->db->where("id", $raw_id);
		$query_update = $this->db->update("kt_events_raw",$update_array);
		
		if($query_update) {
			$this->db->where('id',$raw_id);
			$result = $this->db->get('kt_events_raw')->result_array();
			//echo "<pre>"; print_r($result);
			foreach ($result as $raw){
				//echo $id = $raw['id'];
				$sport_id = $raw['sport_category_id'];
				$c_id = $raw['competition_id'];
				$home = $raw['home_team'];
				$away = $raw['away_team'];
				$nation = $raw['nation'];
				$start = $raw['start_date'];
				$end = $raw['end_date'];
				$status = $raw['event_status_raw'];
			}
			
			
			$this->db->where('nation',$nation);
			$this->db->where('competition_id',$c_id);
			$this->db->where('home_team',$home);
			$this->db->where('away_team',$away);
			$this->db->where('start_date',$start);
			$this->db->where('end_date',$end);
			$this->db->where('sport_category_id',$sport_id);
			$query2 = $this->db->count_all_results('kt_events');
			
			
				
			if($query2 < 1) {
				$insert_array = array(
					'sport_category_id' => $sport_id,
					'competition_id' => $c_id,
					'home_team' => $home,
					'away_team' => $away,
					'nation' => $nation,
					'start_date' => $start,
					'end_date' => $end,
					'events_status' =>$status
				);
					
				$insert = $this->db->insert('kt_events',$insert_array);
				if($insert){
					$this->session->set_flashdata('ok_message', '- Event has been Approved.');
					redirect(base_url().'event/manage_event/manage_raw_event');
				}else{
					$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
					redirect(base_url().'stream/manage_event/manage_raw_event');
				}
			}
			$this->session->set_flashdata('ok_message', '- Event has been Approved.');
			redirect(base_url().'event/manage_event/manage_raw_event');
		}else{
			$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
			redirect(base_url().'stream/manage_event/manage_raw_event');
		}
	}
	

	public function view_event($event_id=null){
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;

		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;
		
		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage event/ View event', base_url().'event/manage_event');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(37,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(38,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		//Fetching Pages Results
		$data['get_event'] = $this->mod_event->get_event($event_id);
		
		$this->load->view('event/view_event',$data);
	}
	public function get_sport_competition(){
		
		$sport_category = $this->input->post('sport_category');
		//echo $sport_category;exit;
		$this->db->select('kt_nation_custom_text.*');
		$this->db->where('kt_sport_category.id',$sport_category);
		$this->db->join('kt_nation_custom_text','kt_nation_custom_text.sport_cat_id=kt_sport_category.id');
		$get_competition = $this->db->get('kt_sport_category')->result_array();
		
		foreach($get_competition as $competition) {
			
			
			echo "<option value='".$competition['competition_id']."' id='".$competition['competition_id']."'> ".$competition['competition_name']."</option>";
			//$competition['competition_id'];
			//$competition['competition_name'];
		}
		//echo "<pre>";print_r($get_competition);
	}
	public function get_sport_nation(){
		$sport_category = $this->input->post('sport_category');
		echo $sport_category;
		
		$this->db->select("nation");
		$this->db->where('sport_cat_id',$sport_category);
		$this->db->group_by('sport_cat_id');
		$get_my_nation = $this->db->get('kt_nation_custom_text')->result_array();
		//echo "<pre>"; print_r($get_my_nation);exit;
		foreach($get_my_nation as $comp){
			echo '<option value="'.$comp['nation'].'">'.$comp['nation'].'</option>';
		}
	}
	public function get_competition_nation(){
		$nation = $this->input->post('nation');
		
		$this->db->select('competition_id,nation');
		$this->db->where('competition_id',$nation);
		$get_nation=$this->db->get('kt_nation_custom_text')->result_array();
		
		foreach($get_nation as $nation) {
			echo "<option value='".$nation['nation']."' id='".$nation['competition_id']."'>".$nation['nation']."</option>";
		}
	}
	public function get_sport_team(){
		
		$sport_team = $this->input->post('sport_team');
		//echo $sport_category;exit;
		$this->db->select('kt_team.*');
		$this->db->where('kt_sport_category.id',$sport_team);
		$this->db->join('kt_team','kt_team.sport_cat_id=kt_sport_category.id');
		$get_team = $this->db->get('kt_sport_category')->result_array();
		//echo "<pre>"; print_r($get_team);
	}
	
	public function get_sport_team2(){
		
		// echo $this->input->post('term');
		// echo $this->input->post('select_sport');
		 if (isset($_POST['term'])) {
           $q = strtolower($_POST['term']);
			$sport_id = $this->input->post('select_sport');
			$this->mod_event->get_sport_team_name($q,$sport_id);
		  // echo "<pre>"; print_r($data['abc']);
        }
	}
	
	public function add_new_event(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(99,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;
		
		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;
		
		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage event', base_url().'event/manage_event');
		$this->breadcrumbcomponent->add('Manage event', base_url().'event/manage_event/add_new_event');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		$data['get_demo_event'] = $this->mod_event->get_demo_event();
		//echo "<pre>";print_r($data['get_demo_event']);exit;
		$this->load->view("event/add_new_event",$data);
		
	}
	public function update_event($id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(99,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;
		
		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;
		
		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage event', base_url().'event/manage_event');
		$this->breadcrumbcomponent->add('Manage event', base_url().'event/manage_event/add_new_event');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		$data['get_demo_event'] = $this->mod_event->get_demo_event();
		//echo "<pre>";print_r($data['get_demo_event']);exit;
		$data['event_id'] = $id;
		$data['get_my_event'] = $this->mod_event->edit_my_event($id);
		
		$this->load->view("event/edit_event",$data);
		
	}
	public function edit_event_process(){
	$rss = $this->load->database('rss', TRUE);
	
	$id = $this->input->post('event_id');
	$old_comp_id = $this->input->post('old_comp');
	$home_team = $this->input->post('home_team');
	$away_team = $this->input->post('away_team');
	$start_date = $this->input->post('start_date');
	$end_date = $this->input->post('end_date');
	$competition_name = $this->input->post('competition');
	
	
	$update_comp = array (
		'competition_name' => $competition_name
	);
	
	
	$rss->where('competition_id',$old_comp_id);
	$u = $rss->update('rss_competition',$update_comp);
	
	$update_array = array(

	"home_team" => $home_team,
	"away_team" => $away_team,
	"start_date" => $start_date,
	"end_date" => $end_date,
	);
	$rss->where('id',$id);
	$query = $rss->update('rss_events',$update_array);
	if($query){
		
		$this->session->set_flashdata('ok_message', 'Successful');
		redirect('event/manage_event');
		
	}else{
		$this->session->set_flashdata('error', 'Something went wrong, please try again later');
		redirect('event/manage_event');
	}
	redirect('event/manage_event');
	}
	public function upload_it_nation($fieldname){
		$data =NULL;
		$config['upload_path'] = '../Flags/';
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
	
	
	public function upload_it_home($fieldname){
		$data =NULL;
		$config['upload_path'] = '../images/teams/';
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
	public function upload_it_away($fieldname){
		$data =NULL;
		$config['upload_path'] = '../images/teams/';
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
	public function upload_it_competition($fieldname){
		//echo $fieldname;exit;
		$data =NULL;
		$config['upload_path'] = '../images/competitions/';
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
	public function add_event_process(){
	$rss = $this->load->database('rss', TRUE);
	
	$nation = $this->input->post('nation');
	$home_team = $this->input->post('home_team');
	$away_team = $this->input->post('away_team');
	$start_date = $this->input->post('start_date');
	$end_date = $this->input->post('end_date');
		$_FILES['upload']['name'];
		//Uploading Competition Logo
		if($_FILES['upload']['name'] != '')
			{
				$file_name=$this->upload_it2('upload');
				
			}
			else
			{
				$file_name="";
			}
		//End 
		
		
	$competition_new = $this->input->post('competition');
	if($competition_new){
		$competition = $competition_new;
	}else {
		$competition = $this->input->post('competition2');
	}
	
	
	$sport_category = $this->input->post('sport_category'); 
	if($sport_category){
		$rss->select('category_name');
		$rss->where('id',$sport_category);
		$new_sport_category_name = $rss->get('rss_sport_category')->result_array();
		$sport_category_name = $new_sport_category_name[0]['category_name'];
		
		if($this->input->post('competition2')){
				
			$insert_competition = array(
				'competition_name' => $competition,
				'nation' => $nation,
				'sport_cat_id' => $sport_category,
				'sport_name' => $sport_category_name,
				'comp_logo' => "http://www.realstreamsports.com/images/competitions/default.jpg",
				);
			$competition_inserted = $rss->insert('rss_competition',$insert_competition);
			$competition = $rss->insert_id() ;
			}
		
	} else {
		$rss->select('sport_cat_id,sport_name');
		$rss->where('competition_id',$competition);
		$new_sport_category_name = $rss->get('rss_competition')->result_array();
		$sport_category_name = $new_sport_category_name[0]['sport_name'];
		$sport_category = $new_sport_category_name[0]['sport_cat_id'];
	}
	
	
			
		
		if($this->input->post('home_team')) {
			
			$rss->where('name',$home_team);
			$check_h = $rss->get('rss_team')->num_rows();
			if($check_h < 1) {
				$insert_home_team = array (
					'name' => $home_team,
					'sport_cat_id' => $sport_category,
					'logo' => 'http://www.realstreamsports.com/images/teams/default.png',
					'nation' => $nation,
					'sport_name' => $sport_category_name,
					'competition_id' => $competition
				);
				$h_inserted = $rss->insert('rss_team',$insert_home_team);
			}
			
		}
		if($this->input->post('away_team')) {
			
			$rss->where('name',$away_team);
			$check_h = $rss->get('rss_team')->num_rows();
			if($check_h < 1) {
				$insert_home_team = array (
					'name' => $away_team,
					'sport_cat_id' => $sport_category,
					'logo' => 'http://www.realstreamsports.com/images/teams/default.png',
					'nation' => $nation,
					'sport_name' => $sport_category_name,
					'competition_id' => $competition
				);
				$h_inserted = $rss->insert('rss_team',$insert_home_team);
			}
			
		}
	
	$insert_array = array (
	"sport_category_id" => $sport_category,
	"sport_name" => $sport_category_name,
	"competition_id" => $competition,
	"nation" => $nation,
	"home_team" => $home_team,
	"away_team" => $away_team,
	"start_date" => $start_date,
	"end_date" => $end_date,
	"season_id" => " ",
	"round_id" => " ",
	"game_week" => " ",
	);
	$query = $rss->insert('rss_events',$insert_array);
	if($query){
		
		$this->session->set_flashdata('ok_message', 'Successful');
		redirect('event/manage_event');
		
	}else{
		$this->session->set_flashdata('error', 'Something went wrong, please try again later');
		redirect('event/manage_event');
	}
	redirect('event/manage_event');
	}
	public function update_event_status($event_id){
	
		//echo $highlight_id;exit;
		$update_array = array(
		"event_status" => 'approved'
			);			
		$this->db->where("id", $event_id);
		$query_update = $this->db->update("kt_events",$update_array);
		
		if($query_update) {
			$this->session->set_flashdata('ok_message', '- event has been Approved.');
			redirect(base_url().'event/manage_event/');
		} else {
			$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
			redirect(base_url().'event/manage_event/');
		}
	}
	public function update_team_logo(){
		$rss = $this->load->database('rss', TRUE);
		$id = $this->input->post('team');
		//print_r($_FILES['upload']['name']);exit;
		if($_FILES['upload']['name'] != '')
			{
				$file_name=$this->upload_it('upload');
				
			}
			else
			{
				$file_name="";
			}
			
			if($file_name != ''){
				$update_array = array(
                "logo" => $file_name
            );
			$rss->where('id',$id);
			$update = $rss->update('rss_team',$update_array);
			}
			if($update){
				$this->load->library('image_lib');
				$config['image_library'] = 'gd2';
				$config['source_image']	= "../images/".$file_name;
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width']	= "28px";
				$config['height']	= "28px";
				$config['new_image'] = "../images/";//you should have write permission here..
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				
				$this->session->set_flashdata('ok_message', '- Logo updated.');
				redirect(base_url().'event/manage_event/');
			} else {
				$this->session->set_flashdata('err_message', '- Not updated.');
			redirect(base_url().'event/manage_event/');
			}
	}
	
	public function upload_it($fieldname){
		$data =NULL;
		$config['upload_path'] = '../images';
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
	
	public function update_competition_logo(){
		$rss = $this->load->database('rss', TRUE);
		
		$id = $this->input->post('competition');
		//echo $_FILES['upload']['name'];
		//print_r($_FILES['upload']['name']);
		if($_FILES['upload']['name'] != '')
			{
				$file_name=$this->upload_it2('upload');
				
			}
			else
			{
				$file_name="";
			}
			if($file_name != ''){
				$update_array = array(
                "comp_logo" => $file_name
            );
			$rss->where('competition_id',$id);
			$update = $rss->update('rss_competition',$update_array);
			}
			
			if($update){
				$this->load->library('image_lib');
				$config['image_library'] = 'gd2';
				$config['source_image']	= "../images/leagues/".$file_name;
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width']	= "25px";
				$config['height']	= "25px";
				$config['new_image'] = "../images/leagues/";//you should have write permission here..
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				
				$this->session->set_flashdata('ok_message', '- Logo updated.');
				redirect(base_url().'event/manage_event/');
			} else {
				$this->session->set_flashdata('err_message', '- not updated.');
			redirect(base_url().'event/manage_event/');
			}
	}
	public function upload_it2($fieldname){
		$data =NULL;
		$config['upload_path'] = '../images/leagues/';
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
	public function delete_event($event_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(99,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if
		
		//If Post is not SET
		if(!isset($event_id)) redirect(base_url());
		
		//Updating Page
		$del_event = $this->mod_event->delete_event($event_id);
		
		if($del_event){
			
			$this->session->set_flashdata('ok_message', '- event deleted successfully.');
			redirect(base_url().'event/manage_event');
			
		}else{
			$this->session->set_flashdata('err_message', '- event cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'event/manage_stream');
			
		}//end if

	}//end delete_page
	public function delete_event_raw($event_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(99,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if
		
		//If Post is not SET
		if(!isset($event_id)) redirect(base_url());
		
		//Updating Page
		$del_event = $this->mod_event->delete_events_raw($event_id);
		
		if($del_event){
			
			$this->session->set_flashdata('ok_message', '- Raw Event deleted successfully.');
			redirect(base_url().'event/manage_event/manage_raw_event');
			
		}else{
			$this->session->set_flashdata('err_message', '- event cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'event/manage_event/manage_raw_event');
			
		}//end if

	}//end delete_page
	public function approve_multiple_event(){
		$all = $this->input->post("raw_event");
		//echo "<pre>";
		//print_r($all);exit;
		if(!empty($all) && $all != "Approve Selected") {
			foreach($all as $raw_id) {
				$update_array = array(
				"event_status_raw" => 'approved'
					);			
				$this->db->where("id", $raw_id);
				$query_update = $this->db->update("kt_events_raw",$update_array);
				
				if($query_update) {
					$this->db->where('id',$raw_id);
					$result = $this->db->get('kt_events_raw')->result_array();
					//echo "<pre>"; print_r($result);
					foreach ($result as $raw){
						//echo $id = $raw['id'];
						$sport_id = $raw['sport_category_id'];
						$c_id = $raw['competition_id'];
						$home = $raw['home_team'];
						$away = $raw['away_team'];
						$nation = $raw['nation'];
						$start = $raw['start_date'];
						$end = $raw['end_date'];
						$status = $raw['event_status_raw'];
					}
					
					
					$this->db->where('nation',$nation);
					$this->db->where('competition_id',$c_id);
					$this->db->where('home_team',$home);
					$this->db->where('away_team',$away);
					$this->db->where('start_date',$start);
					$this->db->where('end_date',$end);
					$this->db->where('sport_category_id',$sport_id);
					$query2 = $this->db->count_all_results('kt_events');
					
					
						
					if($query2 < 1) {
						$insert_array = array(
							'sport_category_id' => $sport_id,
							'competition_id' => $c_id,
							'home_team' => $home,
							'away_team' => $away,
							'nation' => $nation,
							'start_date' => $start,
							'end_date' => $end,
							'events_status' =>$status
						);
							
						$insert = $this->db->insert('kt_events',$insert_array);
					}
				}
			}
			$this->session->set_flashdata('ok_message', '- Selected events Approved.');
			redirect(base_url().'event/manage_event/manage_raw_event');
		}else {
			$this->session->set_flashdata('err_message', '- Please select events to approve.');
			redirect(base_url().'event/manage_event/manage_raw_event');
		}
		
	}

	public function on_change_nation(){
		$rss = $this->load->database('rss', TRUE);
		
		$nation = $this->input->post('nation');
		if($nation){
			
		$rss->select('competition_id,competition_name');
		$rss->where('nation',$nation);
		//$rss->group->by('competition_id');
		$get_nation=$rss->get('rss_competition')->result_array();
		
		foreach($get_nation as $nation) {
			echo "<option value='".$nation['competition_id']."' id='".$nation['competition_id']."'>".$nation['competition_name']."</option>";
		}
		
		}
	}

}
