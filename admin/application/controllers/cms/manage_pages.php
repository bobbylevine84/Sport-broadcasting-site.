<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Pages extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('cms/mod_cms');
		$this->load->model('menu/mod_menu');
		$this->load->model('common/mod_common');
		
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(2,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage CMS Pages', base_url().'cms/manage-pages');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(4,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(5,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Pages Results
		$get_cms_pages = $this->mod_cms->get_all_cms_pages();

		$data['cms_pages_arr'] = $get_cms_pages['cms_pages_arr'];
		$data['cms_pages_count'] = $get_cms_pages['cms_pages_count'];
		
		$this->load->view('cms/manage_pages',$data);
		
	}//end index()
	public function welcome_section()
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
		
		$this->load->view('cms/welcome_section',$data);
		
	}
	public function add_new_note_process(){
		$note = $this->input->post('note');
		$status = $this->input->post('status');
		
		$update_array = array(
			"note" => $note,
			"status" => $status
		);
		$this->db->where('id',1);
		$query = $this->db->update("kt_welcome_section", $update_array);
		if ($query) {
				$this->session->set_flashdata('ok_message', 'Successful');
				redirect('cms/manage_pages/welcome_section');
				$this->session->set_flashdata('error', 'Something went wrong, please try again later');
				redirect('');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong, please try again later');
			redirect('');
		}
		redirect('cms/manage_pages/welcome_section');
	}
	
        public function live_registration_content(){
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(2,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
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
		$this->breadcrumbcomponent->add('Manage CMS Pages', base_url().'cms/manage-pages');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(4,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(5,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Pages Results
		$get_cms_pages = $this->mod_cms->get_all_cms_pages();

		$data['cms_pages_arr'] = $get_cms_pages['cms_pages_arr'];
		$data['cms_pages_count'] = $get_cms_pages['cms_pages_count'];
		
		$this->db->select('desc');
		$this->db->where('title', 'l_r_c');
		$data['contents'] = $this->db->get('kt_miscellaneous')->result();
				
		$this->load->view('cms/live_registration_content',$data);	
	}
	public function live_registration_content_update(){
		
		$contents = $this->input->post('live_reg_content');
		$desc = array('desc' => $contents);
		
		$this->db->where('title', 'l_r_c');
		$this->db->update('kt_miscellaneous',$desc);
		
		$this->live_registration_content();
		
	}

        public function live_registration_success(){
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(2,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
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
		$this->breadcrumbcomponent->add('Manage CMS Pages', base_url().'cms/manage-pages');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(4,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(5,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Pages Results
		$get_cms_pages = $this->mod_cms->get_all_cms_pages();

		$data['cms_pages_arr'] = $get_cms_pages['cms_pages_arr'];
		$data['cms_pages_count'] = $get_cms_pages['cms_pages_count'];
		
		$this->db->select('desc');
		$this->db->where('title', 'l_r_d_p_c');
		$data['contents'] = $this->db->get('kt_miscellaneous')->result();
				
		$this->load->view('cms/live_registration_success',$data);	
	}
	public function live_registration_success_update(){
		
		$contents = $this->input->post('live_reg_content');
		$desc = array('desc' => $contents);
		
		$this->db->where('title', 'l_r_d_p_c');
		$this->db->update('kt_miscellaneous',$desc);
		
		$this->live_registration_success();
		
	}
        
        //Demo Account
        
        public function demo_registration_content(){
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(2,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
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
		$this->breadcrumbcomponent->add('Manage CMS Pages', base_url().'cms/manage-pages');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(4,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(5,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Pages Results
		$get_cms_pages = $this->mod_cms->get_all_cms_pages();

		$data['cms_pages_arr'] = $get_cms_pages['cms_pages_arr'];
		$data['cms_pages_count'] = $get_cms_pages['cms_pages_count'];
		
		$this->db->select('desc');
		$this->db->where('title', 'd_r_c');
		$data['contents'] = $this->db->get('kt_miscellaneous')->result();
				
		$this->load->view('cms/demo_registration_content',$data);	
	}
	public function demo_registration_content_update(){
		
		$contents = $this->input->post('live_reg_content');
		$desc = array('desc' => $contents);
		
		$this->db->where('title', 'd_r_c');
		$this->db->update('kt_miscellaneous',$desc);
		
		$this->demo_registration_content();
		
	}

        public function demo_registration_success(){
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(2,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
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
		$this->breadcrumbcomponent->add('Manage CMS Pages', base_url().'cms/manage-pages');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(4,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(5,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Pages Results
		$get_cms_pages = $this->mod_cms->get_all_cms_pages();

		$data['cms_pages_arr'] = $get_cms_pages['cms_pages_arr'];
		$data['cms_pages_count'] = $get_cms_pages['cms_pages_count'];
		
		$this->db->select('desc');
		$this->db->where('title', 'd_r_d_p_c');
		$data['contents'] = $this->db->get('kt_miscellaneous')->result();
				
		$this->load->view('cms/demo_registration_success',$data);	
	}
	public function demo_registration_success_update(){
		
		$contents = $this->input->post('live_reg_content');
		$desc = array('desc' => $contents);
		
		$this->db->where('title', 'd_r_d_p_c');
		$this->db->update('kt_miscellaneous',$desc);
		
		$this->demo_registration_success();
		
	}
        
        //End Demo Account
        
	//Add New Page
	public function add_page(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(3,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage CMS Pages', base_url().'cms/manage-pages');
		$this->breadcrumbcomponent->add('Add New Page', base_url().'cms/manage-pages/add-page');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		//Fetching menu Listing
		$get_menu_list = $this->mod_menu->get_menu_parent_list();
		$data['menu_parent_list_arr'] = $get_menu_list['menu_parent_list_arr'];
		$data['menu_parent_list_count'] = $get_menu_list['menu_parent_list_count'];
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view('cms/add_page',$data);
		
	}//add_new_page

	public function add_page_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_page_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(3,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		

		$data_arr['add-page-data'] = $this->input->post();
		$this->session->set_userdata($data_arr);

		if(trim($this->input->post('page_title')) == ''){
			
			$this->session->set_flashdata('err_message', '- New Page is not added. Page Title missing.');
			redirect(base_url().'cms/manage-pages/add-page');
			
		}//end if(trim($this->input->post('page_title')) == '')

		//Adding New Page
		$add_cms_page = $this->mod_cms->add_new_page($this->input->post());
		
		if($add_cms_page){
			
			//Unset POST values from session
			$this->session->unset_userdata('add-page-data');
			
			$this->session->set_flashdata('ok_message', '- New Page added successfully.');
			redirect(base_url().'cms/manage-pages');
			
		}else{
			$this->session->set_flashdata('err_message', '- New Page is not added. Something went wrong, please try again.');
			redirect(base_url().'cms/manage-pages/add-page');
			
		}//end if($add_cms_page)

	}//end add_page_process

	//Edit Page
	public function edit_page($page_id){

		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(4,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage CMS Pages', base_url().'cms/manage-pages');
		$this->breadcrumbcomponent->add('Edit CMS Page', base_url().'cms/manage-pages/edit-page/'.$page_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Fetching menu Listing
		$get_menu_list = $this->mod_menu->get_menu_parent_list();
		$data['menu_parent_list_arr'] = $get_menu_list['menu_parent_list_arr'];
		$data['menu_parent_list_count'] = $get_menu_list['menu_parent_list_count'];

		//Fetching Pages Results
		$get_cms_page = $this->mod_cms->get_cms_page($page_id);
		$data['page_data'] = $get_cms_page['cms_page_arr'];
		$data['page_data_count'] = $get_cms_page['cms_page_count'];
		
		if($get_cms_page['cms_page_count'] == 0) redirect(base_url());
		
		$this->load->view('cms/edit_page',$data);
		
	}//add_new_page

	public function edit_page_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('upd_page_sbt')) redirect(base_url());
		
		$page_id = $this->input->post('page_id');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(4,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		if(trim($this->input->post('page_title')) == ''){
			
			$this->session->set_flashdata('err_message', '- Page is not updated. Page Title missing.');
			redirect(base_url().'cms/manage-pages/edit-page/'.$page_id);
			
		}//end if(trim($this->input->post('page_title')) == '')

		//Updating Page
		$upd_cms_page = $this->mod_cms->edit_new_page($this->input->post());
		
		if($upd_cms_page){
			
			$this->session->set_flashdata('ok_message', '- Page contents updated successfully.');
			redirect(base_url().'cms/manage-pages/edit-page/'.$page_id);
			
		}else{
			$this->session->set_flashdata('err_message', '- Page contents is not updated. Something went wrong, please try again.');
			redirect(base_url().'cms/manage-pages/edit-page/'.$page_id);
			
		}//end if($add_cms_page)

	}//end add_page_process
	
	public function delete_page($page_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(5,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//If Post is not SET
		if(!isset($page_id)) redirect(base_url());
		
		//Updating Page
		$del_cms_page = $this->mod_cms->delete_page($page_id);
		
		if($del_cms_page){
			
			$this->session->set_flashdata('ok_message', '- Page deleted successfully.');
			redirect(base_url().'cms/manage-pages');
			
		}else{
			$this->session->set_flashdata('err_message', '- Page cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'cms/manage-pages');
			
		}//end if($add_cms_page)

	}//end delete_page


}//end Dashboard 