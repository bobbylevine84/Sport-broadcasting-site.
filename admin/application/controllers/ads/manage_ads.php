<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_ads extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		//$this->load->model('sponsor/mod_sponsor');
		$this->load->model('common/mod_common');
		$this->load->model('ads/mod_ads');
		//$this->load->library('image_lib');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
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
		$this->breadcrumbcomponent->add('Manage channel', base_url().'channel/manage-channel');
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
		$get_ads= $this->mod_ads->get_all_ads();
		$data['ads_arr'] = $get_ads['ads_arr'];
		$data['ads_count'] = $get_ads['ads_count'];
		$this->load->view('ads/manage_ads',$data);
	}//end index()
	public function live_ads(){
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
		$this->breadcrumbcomponent->add('Manage channel', base_url().'channel/manage-channel');
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
		
		$this->load->view('ads/live_ads');
	}
	public function update_live_ad(){
		$url = $this->input->post('url');
		$update = array(
			'url' => $url
		);
		$this->db->where('id',1);
		$updatee = $this->db->update('kt_ads_live',$update);
		if($updatee){
			$this->session->set_flashdata('ok_message', 'Successful');
			redirect('ads/manage_ads/live_ads');
		} else {
			$this->session->set_flashdata('ok_message', 'Successful');
			redirect('ads/manage_ads/live_ads');
		}
	}
	public function stream_ads(){
		
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
		$this->breadcrumbcomponent->add('Manage channel', base_url().'channel/manage-channel');
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
		$get_ads= $this->mod_ads->get_all_ads_stream();
		$data['ads_arr'] = $get_ads['ads_arr'];
		$data['ads_count'] = $get_ads['ads_count'];
		$this->load->view('ads/manage_ads_stream',$data);
	}
	public function add_new_ads(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage ads', base_url().'ads/manage_cads');
		$this->breadcrumbcomponent->add('Manage ads', base_url().'ads/manage_ads/add_new');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view("ads/add_new_ads",$data);
		
	}
	public function add_new_stream_ads(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage ads', base_url().'ads/manage_ads');
		$this->breadcrumbcomponent->add('Manage ads', base_url().'ads/manage_ads/add_new');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view("ads/add_new_ads_stream",$data);
		
	}
	public function add_new_ads_process(){
		
		$ads_id = $this->input->post("id");
		$url = $this->input->post("url");
		if($this->input->post("hd") == ''){
			$hd = 'No';
		} else {
			$hd = $this->input->post("hd"); 
		}
		
		if($_FILES['image']['name'] != '')
			{
				$file_name=$this->upload_it('image');
				//print_r($file_name);exit;
			}
			else
			{
				$file_name="";
			}
		$main_frame = $this->input->post('main_frame');
			$insert_array = array(
			"comp_id" => $ads_id,
			"url" => $url,
			"hd" => $hd,
			"image" => $file_name
		);
		$query = $this->db->insert("kt_ads", $insert_array);
		if ($query) {
				$this->session->set_flashdata('ok_message', 'Successful');
				redirect('ads/manage_ads');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong, please try again later');
			redirect('');
		}
		redirect('ads/manage_ads');
	}
	public function add_new_stream_ads_process(){
		
		$ads_id = $this->input->post("id");
		$url = $this->input->post("url");
		$bitrate = $this->input->post("bitrate");
		$lang = $this->input->post("lang");
		if($this->input->post("sponser") == ''){
			$sponser = '0';
		} else {
			$sponser = "1"; 
		}
		
			$insert_array = array(
			"comp_id" => $ads_id,
			"url" => $url,
			"bitrate" => $bitrate,
			"lang" => $lang,
			"sponsered" => $sponser,
		);
		$query = $this->db->insert("kt_ads_stream", $insert_array);
		if ($query) {
				$this->session->set_flashdata('ok_message', 'Successful');
				redirect('ads/manage_ads/stream_ads');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong, please try again later');
			redirect('ads/manage_ads/stream_ads');
		}
		redirect('ads/manage_ads');
	}
	
	public function update_ads($ads_id){
	//echo $channel_id;exit;
			//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 1;
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
		$this->breadcrumbcomponent->add('Manage Channels', base_url().'ads/manage_ads');
		$this->breadcrumbcomponent->add('Edit Channels', base_url().'ads/manage_ads/edit_ads/'.$ads_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$data['get_ads'] = $this->mod_ads->get_all_ads_to_update($ads_id);
	
		$data['ads_arr'] = $data['get_ads']['ads_arr'];
		$data['ads_count'] = $data['get_ads']['ads_count'];
		
		$this->load->view('ads/edit_ads',$data);
		
	}
	public function update_ads_stream($ads_id){
	//echo $channel_id;exit;
			//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 1;
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
		$this->breadcrumbcomponent->add('Manage Channels', base_url().'ads/manage_ads');
		$this->breadcrumbcomponent->add('Edit Channels', base_url().'ads/manage_ads/edit_ads/'.$ads_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$data['get_ads'] = $this->mod_ads->get_stream_ads_to_update($ads_id);
	
		$data['ads_arr'] = $data['get_ads']['ads_arr'];
		$data['ads_count'] = $data['get_ads']['ads_count'];
		
		$this->load->view('ads/edit_ads_stream',$data);
		
	}
	public function edit_ads_stream_process(){
			$c_id = $this->input->post('id');
			$ads_id = $this->input->post("ads_id");
			if($this->input->post("sponser") == ''){
			$sponser = '0';
			} else {
				$sponser = "1"; 
			}
			$url = $this->input->post("url");
			$bitrate = $this->input->post("bitrate");
			$lang = $this->input->post("lang");
			$status = $this->input->post("status");
			
				$update_array = array(
				"comp_id" => $c_id,
				"sponsered" => $sponser,
				"url" => $url,
				"bitrate" => $bitrate,
				"lang" => $lang,
				"status" => $status
				);
				
				$this->db->where("id", $ads_id);
				$query_update = $this->db->update("kt_ads_stream",$update_array);
				if ($query_update) 
				{	
					$this->session->set_flashdata('ok_message', 'Successfully updated.' );
					redirect('ads/manage_ads/stream_ads');			
				}
				else
				{	
					$this->session->set_flashdata('error', 'Something went wrong, please try again' );
					redirect('ads/manage_ads/stream_ads');
				}

	}
	public function edit_ads_process(){
			$c_id = $this->input->post('id');
			$ads_id = $this->input->post("ads_id");
			if($this->input->post("hd") == ''){
			$hd = 'No';
			} else {
				$hd = $this->input->post("hd"); 
			}
			$url = $this->input->post("url");
			if($_FILES['image']['name'] != '')
			{
				$file_name=$this->upload_it('image');
			}
			else
			{
				$file_name="";
			}
			$status = $this->input->post("status");
			
				if($file_name ==''){ 
				$update_array = array(
				"comp_id" => $c_id,
				"hd" => $hd,
				"url" => $url,
				"status" => $status
				);
				}else{
				$update_array = array(
				"comp_id" => $c_id,
				"hd" => $hd,
				"url" => $url,
				'image'=>$file_name,
				"status" => $status
				);
				}
				$this->db->where("id", $ads_id);
				$query_update = $this->db->update("kt_ads",$update_array);
				if ($query_update) 
				{	
					$this->session->set_flashdata('ok_message', 'Successfully updated.' );
					redirect('ads/manage_ads');			
				}
				else
				{	
					$this->session->set_flashdata('error', 'Something went wrong, please try again' );
					redirect('ads/manage_ads');
				}

	}
	public function upload_it($fieldname){
		$data =NULL;
		$config['upload_path'] = 'uploads/game_images/';
		$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
		$config['max_size']	= '4096';
		$config['height']	= '83';
		$config['width']	= '58';
		
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
	public function delete_ads($ads_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if
		
		//If Post is not SET
		if(!isset($ads_id)) redirect(base_url());
		
		//Updating Page
		$del_ads = $this->mod_ads->delete_ads($ads_id);
		
		if($del_ads){
			
			$this->session->set_flashdata('ok_message', '- Ad deleted successfully.');
			redirect(base_url().'ads/manage_ads');
			
		}else{
			$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
			redirect(base_url().'ads/manage_ads');
			
		}//end if

	}//end
	public function delete_ads_stream($ads_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if
		
		//If Post is not SET
		if(!isset($ads_id)) redirect(base_url());
		
		//Updating Page
		$del_ads = $this->mod_ads->delete_ads_streams($ads_id);
		
		if($del_ads){
			
			$this->session->set_flashdata('ok_message', '- Ad deleted successfully.');
			redirect(base_url().'ads/manage_ads/stream_ads');
			
		}else{
			$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
			redirect(base_url().'ads/manage_ads/stream_ads');
			
		}//end if

	}//end delete_page
	

}
