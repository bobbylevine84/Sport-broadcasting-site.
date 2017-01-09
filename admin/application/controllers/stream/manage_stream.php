<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_stream extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		//$this->load->model('sponsor/mod_sponsor');
		$this->load->model('common/mod_common');
		$this->load->model('stream/mod_stream');
		//$this->load->library('image_lib');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
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
		$this->breadcrumbcomponent->add('Manage Stream', base_url().'testimonial/manage-testimonial');
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
		$get_stream = $this->mod_stream->get_all_stream();
		$data['stream_arr'] = $get_stream['stream_arr'];
		$data['stream_count'] = $get_stream['stream_count'];

		$get_stream2 = $this->mod_stream->get_all_stream_pending();
		$data['stream_arr2'] = $get_stream2['stream_arr2'];
		$data['stream_count2'] = $get_stream2['stream_count2'];
		//echo "<pre>";print_r($data['stream_arr2']);exit;
			$this->load->view('stream/manage_stream',$data);
	
		
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
	
	
	public function manage_stream_raw(){
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
		$this->breadcrumbcomponent->add('Manage Stream', base_url().'testimonial/manage-testimonial');
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
		$get_stream2 = $this->mod_stream->get_all_stream_raw();
		$data['stream_arr'] = $get_stream2['stream_arr'];
		$data['stream_count'] = $get_stream2['stream_count'];
		
		$this->load->view('stream/manage_stream_raw',$data);
	}
	
	
	public function view_stream($stream_id=null){
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
		$this->breadcrumbcomponent->add('Manage stream/ View stream', base_url().'stream/manage_stream');
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
		$data['get_stream'] = $this->mod_stream->get_stream($stream_id);
		
		$this->load->view('stream/view_stream',$data);
	}
	public function block_stream($domain_id){
		$this->db->dbprefix = '';
		$rss = $this->load->database('rss', TRUE);
		$rss->select('stream_domain');
		$rss->where('id',$domain_id);
		$get_domain = $rss->get('rss_streams')->result_array();
		$domain = $get_domain[0]['stream_domain'];
		
		$insert_array = array(
		"domain_name" => $domain
		);
		$query = $rss->insert('rss_block_domain',$insert_array);
		if ($query) {
				$this->session->set_flashdata('ok_message', 'Successful');
				redirect('stream/manage_stream');
				$this->session->set_flashdata('error', 'Something went wrong, please try again later');
				redirect('');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong, please try again later');
			redirect('');
		}
		redirect('stream/manage_stream');
	}
	public function rules()
	{
		
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		
		if(!in_array(98,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Stream Rule', base_url().'stream/stream rules');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view('stream/add_stream_rules',$data);
		
	}
	public function add_new_stream_rule_process(){
		$rule = $this->input->post('stream_rule');
		$status = $this->input->post('status');
		
		$update_array = array(
			"stream_rule" => $rule,
			"status" => $status
		);
		$this->db->where('id',1);
		$query = $this->db->update("kt_stream_rule", $update_array);
		if ($query) {
				$this->session->set_flashdata('ok_message', 'Successful');
				redirect('stream/manage_stream/rules');
				$this->session->set_flashdata('error', 'Something went wrong, please try again later');
				redirect('');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong, please try again later');
			redirect('');
		}
		redirect('stream/manage_stream/rules');
		
	}
	
	public function add_new_stream(){
		
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
		$this->breadcrumbcomponent->add('Manage Stream', base_url().'stream/manage_stream');
		$this->breadcrumbcomponent->add('Manage stream', base_url().'stream/manage_stream/add_new_stream');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view("stream/add_new_stream",$data);
		
	}
	public function add_stream_process(){
	$rss = $this->load->database('rss', TRUE);
	if($this->input->post('check') == ''){
		$check = '0';
	} else {
		$check = $this->input->post('check');
	}
	 $event = $this->input->post('event');
	 $url = $this->input->post('url');
	$result = parse_url($url);
	$pieces2 = $result['host']; // To get www.youtube.com not http://
	$language = $this->input->post('language');
	$audio_bitrate = $this->input->post('audio_bitrate');
	$total_bitrate = $this->input->post('total_bitrate');
	$type = $this->input->post('type');
	$compatibility = $this->input->post('compatibility');
	$channel = $this->input->post('channel');
		//exit;

	$insert_arrayyy = array(
	"event_id_stream" => $event,
	"url" => $url,
	"stream_domain" => $pieces2,
	"language" => $language,
	"total_bitrate" => $total_bitrate,
	"type" => $type,
	"compatibility" => $compatibility,
	"channel" => $channel,
	"stream_rating" => '50',
	"sponsered" => $check,
	"stream_status" => 'approved'
	);

	$insert_query = $rss->insert('rss_streams',$insert_arrayyy);
	if($insert_query){
		$this->session->set_flashdata('ok_message', 'Successful');
		redirect('stream/manage_stream');
		$this->session->set_flashdata('err_message', 'Something went wrongs, please try again later');
		redirect('stream/manage_stream');
	}else{
		$this->session->set_flashdata('err_message', 'Something went wrong, please try again later');
		redirect('stream/manage_stream');
	}
	redirect('stream/manage_stream');
	}
	public function update_stream($id){
		
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
		$this->breadcrumbcomponent->add('Manage Stream', base_url().'stream/manage_stream');
		$this->breadcrumbcomponent->add('Manage stream', base_url().'stream/manage_stream/add_new_stream');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$rss = $this->load->database('rss', TRUE);
		$rss->where('id',$id);
		$data['stream_data'] = $rss->get('rss_streams')->result_array();
		//echo "<pre>"; print_r($stream);exit;
		
		
		$this->load->view("stream/edit_stream",$data);
		
	}
	public function update_new(){
		$rss = $this->load->database('rss', TRUE);
		
		$id = $this->input->post('id');
		$language = $this->input->post('language');
		$type = $this->input->post('type');
		$compatibility = $this->input->post('compatibility');
		if($language){
			$update_language = array(
			'language' => $language
		);
		$rss->where('id',$id);
		$update = $rss->update('rss_streams',$update_language);
		}
		if($compatibility){
			$update_compatibility = array(
			'compatibility' => $compatibility
		);
		$rss->where('id',$id);
		$update = $rss->update('rss_streams',$update_compatibility);
		}
		if($type){
			$update_type = array(
			'type' => $type
		);
		$rss->where('id',$id);
		$update = $rss->update('rss_streams',$update_type);
		}
		if($update){
			echo "success";
		}else{
			echo "false";
		}
		
		
	}
	public function change_event_stream(){
		$highlight_sport_id = $this->input->post('sport_id');
		$stream_sport_id = $this->input->post('sport_id_stream'); 
		$rss = $this->load->database('rss', TRUE);
		
		$my_date_time =  $this->session->userdata('session_date_time');
		$my_timezone = $this->session->userdata('my_timezone');
		$date_time = (strtotime($my_date_time) - ($my_timezone * 60 * 60));
		$converted_datetime = date('Y-m-d H:i:s', $date_time);
		$converted_date = date('Y-m-d', strtotime($converted_datetime));
		if($highlight_sport_id){
			$datetime = new DateTime($converted_datetime);
			$datetime->modify('-2 day');
			$session_date_yesterday = $datetime->format('Y-m-d H:i:s');
			$session_time = $this->session->userdata('my_timezone');
			
			$rss->where('sport_category_id',$highlight_sport_id);
			$rss->where('DATE(rss_events.start_date) >=',$session_date_yesterday );
			$rss->where('rss_events.start_date <',$converted_datetime ); //h:i:s for time as well.
			$rss->order_by('rss_events.start_date','aesc');
			$query=$rss->get('rss_events')->result_array();
		
		} else if($stream_sport_id){
			$datetime = new DateTime($converted_datetime);
			$datetime->modify('+1 day');
			$session_date_yesterday = $datetime->format('Y-m-d H:i:s');
			$session_time = $this->session->userdata('my_timezone');
			
			$rss->where('sport_category_id',$stream_sport_id);
			
			$rss->where('rss_events.start_date >=',$converted_datetime );
			$rss->where('rss_events.start_date <=',$session_date_yesterday );
			 //h:i:s for time as well.
			$rss->order_by('rss_events.start_date','aesc');
			$query=$rss->get('rss_events')->result_array();
		}
		 
		
		//echo $rss->last_query();
		//echo "<pre>";print_r($query);
		foreach($query as $event){ ?>
			<option value="<?php echo $event['id']; ?>" id="<?php $event['id']; ?>" >
			<?php echo date('G:i', (strtotime($event['start_date'])+($session_time * 60 * 60)));?> /
			<?php echo $event['home_team'].' vs '.$event['away_team']; ?></option>
		<?php }
		
	}
	public function update_stream_raw($raw_id){
		//echo "<pre>";print_r($raw_id);exit;
		$update_array = array(
		"stream_status" => 'approved'
			);			
		$this->db->where("event_id_stream", $raw_id);
		$query_update = $this->db->update("kt_stream_raw",$update_array);
		
		if($query_update) {
			
			$this->db->where('event_id_stream',$raw_id);
			$result = $this->db->get('kt_stream_raw')->result_array();
			
			//echo "<pre>";print_r($result);exit;
			foreach ($result as $raw){
				
				$event_id_stream = $raw['event_id_stream'];
				$url = $raw['url'];
				$stream_domain = $raw['stream_domain'];
				$language = $raw['language'];
				$total_bitrate = $raw['total_bitrate'];
				$type = $raw['type'];
				$compatibility = $raw['compatibility'];
				$channel = $raw['channel'];
				$stream_rating = $raw['stream_rating'];
				$stream_status = $raw['stream_status'];
				
				$this->db->where('url',$url);
				$this->db->where('event_id_stream',$event_id_stream);
				$query = $this->db->count_all_results('kt_stream');
							
				if($query < 1) {
				
					$insert_array = array(
						'event_id_stream' => $event_id_stream,
						'url' => $url,
						'stream_domain' => $stream_domain,
						'language' => $language,
						'total_bitrate' => $total_bitrate,
						'type' => $type,
						'compatibility' => $compatibility,
						'channel' => $channel,
						'stream_rating' =>$stream_rating,
						'stream_status' =>$stream_status
					);
						
					$insert = $this->db->insert('kt_stream',$insert_array);
				}
			} 
			$this->session->set_flashdata('ok_message', '- Streams have been Approved.');
			redirect(base_url().'stream/manage_stream/manage_stream_raw');
		}else{
			$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
			redirect(base_url().'stream/manage_stream/manage_stream_raw');
		}
	}
	//ammar
	public function manage_language(){
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		
		if(!in_array(98,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Stream Rule', base_url().'stream/stream rules');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view('stream/manage_language',$data);
	}
	public function update_language($id){
		
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		
		if(!in_array(98,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Stream Rule', base_url().'stream/stream rules');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->db->where('id',$id);
		$my = $this->db->get('kt_language_logo')->result_array();
		$data['language'] = $my; 
		$this->load->view('stream/update_language',$data);
	}
	public function add_language(){
		$lang = $this->input->post('language');
		if($_FILES['upload']['name'] != '')
			{
				$file_name=$this->upload_it('upload');
				//print_r($file_name);exit;
			}
			else
			{
				$file_name="";
			}
			
			if($file_name) {
				$insert_array = array(
					'name' => $lang,
					'lang_logo ' => $file_name
				);
			} else {
				$insert_array = array(
					'name' => $lang,
				);
			}
			$query = $this->db->insert('kt_language_logo',$insert_array);
			if($query) {
				$this->session->set_flashdata('ok_message', '- Success.');
				redirect(base_url().'stream/manage_stream/manage_language');
			} else {
				$this->session->set_flashdata('err_message', '- Failed.');
				redirect(base_url().'stream/manage_stream/manage_language');
			}
	}
	public function update_language_process(){
		$id = $this->input->post('id');
		$lang = $this->input->post('language');
		if($_FILES['upload']['name'] != '')
			{
				$file_name=$this->upload_it('upload');
				//print_r($file_name);exit;
			}
			else
			{
				$file_name="";
			}
			
			if($file_name) {
				$insert_array = array(
					'name' => $lang,
					'lang_logo ' => $file_name
				);
			} else {
				$insert_array = array(
					'name' => $lang,
				);
			}
			$this->db->where('id',$id);
			$query = $this->db->update('kt_language_logo',$insert_array);
			if($query) {
				$this->session->set_flashdata('ok_message', '- Success.');
				redirect(base_url().'stream/manage_stream/manage_language');
			} else {
				$this->session->set_flashdata('err_message', '- Failed.');
				redirect(base_url().'stream/manage_stream/manage_language');
			}
	}
	public function language_logo(){
		$lang = $this->input->post('language');
		if($_FILES['upload']['name'] != '')
			{
				$file_name=$this->upload_it('upload');
				//print_r($file_name);exit;
			}
			else
			{
				$file_name="";
			}
			
			$my_array = array(
			 'lang_logo ' => $file_name
			);
			
			$this->db->where('name',$lang);
			$check = $this->db->get('kt_language_logo')->num_rows();
			
			if($check > 0) {
				$this->db->where('name',$lang);
				$query = $this->db->update('kt_language_logo',$my_array);
			} else {
				$query = $this->db->insert('kt_language_logo',$my_array);
			}
			if($query) {
				$this->session->set_flashdata('ok_message', '- Success.');
				redirect(base_url().'stream/manage_stream/manage_language');
			} else {
				$this->session->set_flashdata('err_message', '- Failed.');
				redirect(base_url().'stream/manage_stream/manage_language');
			}
			
			
			
	}
	public function upload_it($fieldname){
		$data =NULL;
		$config['upload_path'] = 'uploads/game_images/';
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
	public function approve_multiple_stream_pending(){
		$rss = $this->load->database('rss', TRUE);
		$all = $this->input->post("raw_stream");
		// echo "<pre>";
		// print_r($all);exit;
		if(!empty($all) && $all != "Approve Selected") {
			foreach($all as $raw_id) {
				$update_array = array(
				"stream_status" => 'approved'
					);			
				$rss->where("id", $raw_id);
				$query_update = $rss->update("rss_streams",$update_array);
			
			
				// if($query_update) {
					// $this->db->where('id',$raw_id);
					// $result = $this->db->get('rss_streams')->result_array();
								//echo "<pre>"; print_r($result);
					// foreach ($result as $raw){
								//echo $id = $raw['id'];
						// $event_id_stream = $raw['event_id_stream'];
						// $url = $raw['url'];
						// $stream_domain = $raw['stream_domain'];
						// $language = $raw['language'];
						// $total_bitrate = $raw['total_bitrate'];
						// $type = $raw['type'];
						// $compatibility = $raw['compatibility'];
						// $channel = $raw['channel'];
						// $stream_rating = $raw['stream_rating'];
						// $stream_status = $raw['stream_status'];
						
						// $this->db->where('url',$url);
						// $this->db->where('event_id_stream',$event_id_stream);
						// $this->db->where('stream_status','pending');
						// $query2 = $rss->count_all_results('rss_streams');
							
						// if($query2 < 1) {
							// $insert_array = array(
								// 'event_id_stream' => $event_id_stream,
								// 'url' => $url,
								// 'stream_domain' => $stream_domain,
								// 'language' => $language,
								// 'total_bitrate' => $total_bitrate,
								// 'type' => $type,
								// 'compatibility' => $compatibility,
								// 'channel' => $channel,
								// 'stream_rating' =>$stream_rating,
								// 'stream_status' =>$stream_status
							// );
							
							// $insert = $rss->insert('rss_streams',$insert_array);
						// }
					// }
				// }
			}
			$this->session->set_flashdata('ok_message', '- Streams have been Approved.');
			redirect(base_url().'stream/manage_stream/');
		}else{
			$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
			redirect(base_url().'stream/manage_stream/');
		}
		
	}
	public function approve_multiple_stream(){
		$all = $this->input->post("raw_stream");
		//echo "<pre>";
		//print_r($all);exit;
		if(!empty($all) && $all != "Approve Selected") {
			foreach($all as $raw_id) {
				$update_array = array(
				"stream_status" => 'approved'
					);			
				$this->db->where("event_id_stream", $raw_id);
				$query_update = $this->db->update("kt_stream_raw",$update_array);
			
			
				if($query_update) {
					$this->db->where('event_id_stream',$raw_id);
					$result = $this->db->get('kt_stream_raw')->result_array();
					//echo "<pre>"; print_r($result);
					foreach ($result as $raw){
						//echo $id = $raw['id'];
						$event_id_stream = $raw['event_id_stream'];
						$url = $raw['url'];
						$stream_domain = $raw['stream_domain'];
						$language = $raw['language'];
						$total_bitrate = $raw['total_bitrate'];
						$type = $raw['type'];
						$compatibility = $raw['compatibility'];
						$channel = $raw['channel'];
						$stream_rating = $raw['stream_rating'];
						$stream_status = $raw['stream_status'];
						
						$this->db->where('url',$url);
						$this->db->where('event_id_stream',$event_id_stream);
						$query2 = $this->db->count_all_results('kt_stream');
							
						if($query2 < 1) {
							$insert_array = array(
								'event_id_stream' => $event_id_stream,
								'url' => $url,
								'stream_domain' => $stream_domain,
								'language' => $language,
								'total_bitrate' => $total_bitrate,
								'type' => $type,
								'compatibility' => $compatibility,
								'channel' => $channel,
								'stream_rating' =>$stream_rating,
								'stream_status' =>$stream_status
							);
							
							$insert = $this->db->insert('kt_stream',$insert_array);
						}
					}
				}
			}
			$this->session->set_flashdata('ok_message', '- Streams have been Approved.');
			redirect(base_url().'stream/manage_stream/manage_stream_raw');
		}else{
			$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
			redirect(base_url().'stream/manage_stream/manage_stream_raw');
		}
		
	}
	public function update_stream_status($stream_id){
		$rss = $this->load->database('rss', TRUE);
		//echo $highlight_id;exit;
		$update_array = array(
		"stream_status" => 'approved'
			);			
		$rss->where("id", $stream_id);
		$query_update = $rss->update("rss_streams",$update_array);
		
		if($query_update) {
			$this->session->set_flashdata('ok_message', '- Stream has been Approved.');
			redirect(base_url().'stream/manage_stream/');
		} else {
			$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
			redirect(base_url().'stream/manage_stream/');
		}
	}
	
	
	public function delete_stream($stream_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(99,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if
		
		//If Post is not SET
		if(!isset($stream_id)) redirect(base_url());
		
		//Updating Page
		$del_stream = $this->mod_stream->delete_stream($stream_id);
		
		if($del_stream){
			
			$this->session->set_flashdata('ok_message', '- Stream deleted successfully.');
			redirect(base_url().'stream/manage_stream');
			
		}else{
			$this->session->set_flashdata('err_message', '- Stream cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'stream/manage_stream');
			
		}//end if

	}//end delete_page
	public function delete_stream_raw($stream_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(99,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if
		
		//If Post is not SET
		if(!isset($stream_id)) redirect(base_url());
		
		//Updating Page
		$del_stream = $this->mod_stream->delete_stream_raw($stream_id);
		
		if($del_stream){
			
			$this->session->set_flashdata('ok_message', '- Stream deleted successfully.');
			redirect(base_url().'stream/manage_stream/manage_stream_raw');
			
		}else{
			$this->session->set_flashdata('err_message', '- Stream cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'stream/manage_stream/manage_stream_raw');
			
		}//end if

	}//end delete_page
	

	

}
