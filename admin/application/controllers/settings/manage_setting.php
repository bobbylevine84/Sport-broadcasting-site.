<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_setting extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('slider/mod_slider');
		$this->load->model('common/mod_common');
		
		$this->load->library('BreadcrumbComponent');
		
		$this->load->model('settings/mod_settings');
		
	}

	public function index($val=NULL){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Pages Results
		$get_slider_images = $this->mod_slider->get_all_slider_images();

		$data['slider_images_arr'] = $get_slider_images['slider_images_arr'];
		$data['slider_images_count'] = $get_slider_images['slider_images_count'];
		$data['adminsetting'] = $this->gen_setting();
		
		if($val==1)
		{
			$data['success'] = "Setting updated successfully";
		}
		else
		{
			NULL;
		}
		
		
		$this->load->view('settings/settings',$data);
		
	}//end index()
	
public function currency_settings($val=NULL){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Pages Results
		
		$data['currency_list_count'] = $this->mod_settings->get_currency_list_count();
		$data['all_currency'] = $this->mod_settings->get_currency();
		
	//echo "<pre>";print_r($data['all_gatway']);echo $data['gayway_list_count']; exit;

		if($val==12)
		{
			
		}
		else if($val==20){
			
			$data['success'] = "Setting updated successfully";
		}else
		{
			NULL;
		}
		
		
		$this->load->view('settings/currency_settings',$data);
		
	}
	
	public function gatway_settings($val=NULL){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Pages Results
		$table = "kt_gatway";
		$col ="id";
		$data['gayway_list_count'] = $this->mod_settings->get_gatway_list_count();
		$data['all_gatway'] = $this->mod_settings->get_gatways();
		
	//echo "<pre>";print_r($data['all_gatway']);echo $data['gayway_list_count']; exit;

		if($val==12)
		{
			
		}
		else if($val==20){
			
			$data['success'] = "Setting updated successfully";
		}else
		{
			NULL;
		}
		
		
		$this->load->view('settings/gatway_settings',$data);
		
	}
	public function status_inactive($val)
	{
		$inactive = array('status'=> '0');
		$this->db->where('id',$val);
		$this->db->update('kt_gateways',$inactive);
		
		$this->gatway_settings();
	}
	public function currency_inactive($val)
	{
		$inactive = array('status'=> '0');
		$this->db->where('id',$val);
		$this->db->update('kt_currency',$inactive);
		
		$this->currency_settings();
	}
	public function currency_active($val)
	{
		$active = array('status'=> '1');
		$this->db->where('id',$val);
		$this->db->update('kt_currency',$active);
		
		$this->currency_settings();
	}
	public function status_active($val)
	{
		$active = array('status'=> '1');
		$this->db->where('id',$val);
		$this->db->update('kt_gateways',$active);
		
		$this->gatway_settings();
	}
	public function edit($val)
	{
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		////////////////////////////////////
		$data['is_gatway_register'] = $this->mod_settings->is_gatway_register($val);
		//exit;
		
		$data['gatway_data'] = $this->mod_settings->get_gatway_data($val);
		
		/*echo '<pre>';
		print_r($data['consumer_data']);
		exit;*/
		
		$this->load->view('settings/edit_gatway',$data);		
	}
	
	public function edit_process()
	{
		
		//$val = $this->input->post('user_id');
		$val=$this->input->post('id');
		
		$this->form_validation->set_rules('gatway_name','Gatway Name','required');
		$this->form_validation->set_rules('account_id','Account ID','required');
	
		
		if($this->form_validation->run()==False)
		{
			$this->edit($val);
		}else{
			
			$new_data = array(
				'gatway_name' => $this->input->post('gatway_name'),
				'gatway_account' => $this->input->post('account_id'),
				'gatway_password' => $this->input->post('password'),
				'status' => $this->input->post('status'),
			);
			
			//echo "<pre>"; print_r($new_data); exit;
			$this->mod_settings->update_gatway_data($new_data,$val);
			$this->gatway_settings();
		}
	}

	
	public function fee_settings($val=NULL){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Pages Results
		$table = "kt_fee_setting";
		$col ="id";
		$data['fee_data_inst']=$this->mod_settings->get_data_inst($table,$col)->result_array();
		$data['fee_data_all']=$this->mod_settings->get_data($table,$col)->result_array();
	//echo "<pre>";print_r($data['fee_data_all']);exit;

		if($val==12)
		{
			
		}
		else if($val==20){
			
			$data['success'] = "Setting updated successfully";
		}else
		{
			NULL;
		}
		
		
		$this->load->view('settings/fee_settings',$data);
		
	}//end index()
	
public function withdraw($val=NULL){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Pages Results
		$table = "kt_withdraw_setting";
		$col ="id";
		$data['fee_data_inst']=$this->mod_settings->get_data_inst($table,$col)->result_array();
		$data['fee_data_all']=$this->mod_settings->get_data($table,$col)->result_array();
	//echo "<pre>";print_r($data['fee_data_all']);exit;

		if($val==12)
		{
			
		}
		else if($val==20){
			
			$data['success'] = "Setting updated successfully";
		}else
		{
			NULL;
		}
		
		
		$this->load->view('settings/withdraw_settings',$data);
		
	}//end index()		
	
	public function sci($val=NULL){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Pages Results
		$table = "kt_sci_setting";
		$col ="id";
		$data['fee_data_inst']=$this->mod_settings->get_data_inst($table,$col)->result_array();
		$data['fee_data_all']=$this->mod_settings->get_data($table,$col)->result_array();
	//echo "<pre>";print_r($data['fee_data_all']);exit;

		if($val==12)
		{
			
		}
		else if($val==20){
			
			$data['success'] = "Setting updated successfully";
		}else
		{
			NULL;
		}
		
		
		$this->load->view('settings/sci_settings',$data);
		
	}//end index()	
	
	public function exchange($val=NULL){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Pages Results
		$table = "kt_exchange_setting";
		$col ="id";
		$data['fee_data_inst']=$this->mod_settings->get_data_inst($table,$col)->result_array();
		$data['fee_data_all']=$this->mod_settings->get_data($table,$col)->result_array();
	//echo "<pre>";print_r($data['fee_data_all']);exit;

		if($val==12)
		{
			
		}
		else if($val==20){
			
			$data['success'] = "Setting updated successfully";
		}else
		{
			NULL;
		}
		
		
		$this->load->view('settings/exchange_settings',$data);
		
	}//end index()		
	
	
	
public function SR_settings($val=NULL){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Pages Results
		$table = "kt_sr_setting";
		$col ="id";
		$data['fee_data_inst']=$this->mod_settings->get_data_inst($table,$col)->result_array();
		$data['fee_data_all']=$this->mod_settings->get_data($table,$col)->result_array();
	//echo "<pre>";print_r($data['fee_data_all']);exit;

		if($val==12)
		{
			
		}
		else if($val==20){
			
			$data['success'] = "Setting updated successfully";
		}else
		{
			NULL;
		}
		
		
		$this->load->view('settings/sr_settings',$data);
		
	}//end index()	
	
	public function gen_setting()
	{
		//$this->load->model('settings/mod_settings');
		//return $this->mod_settings->get_setting();
		
		$results_profile = $this->mod_settings->get_setting();
		foreach ($results_profile as $row){
			$setting_arr[$row['options']]['value']=$row['value'];
			$setting_arr[$row['options']]['desc']=$row['desc'];
		}
		/*echo '<pre>';
		print_r($setting_arr);
		exit;*/
		
		return $setting_arr;		
	}
	
	public function edit_set()
	{
		/*echo '<pre>';
		print_r($this->input->post());
		exit;
		*/
		foreach($this->input->post() as $key_valid => $value_valid){
		
		$this->form_validation->set_rules($key_valid, $key_valid, 'required');
		}
		
		if($this->form_validation->run() == False)
		{
			$this->index();
		}
		else
			{

			$this->mod_settings->update_set();
			$val=1;
			$this->index($val);
			//$this->load->view('settings/settings',$data);
		}		
	}
	
	
public function update_fee(){
	//echo "<pre>"; print_r($_POST);echo count($_POST);
	$table = "kt_fee_setting";
	$col ="id";
	$all_inst=$this->mod_settings->get_data_inst($table,$col)->result_array();
//	print_r($all_inst); 
	
	foreach($all_inst as $inst){

	
		$var1='in_per_w_'.$inst['inst_name'];
	 	$var2='in_fix_w_'.$inst['inst_name'];
	 	$var3='bu_per_w_'.$inst['inst_name'];
		$var4='bu_fix_w_'.$inst['inst_name'];
		
		$in_per_vd = $this->input->post($var1);
		$in_fix_vd = $this->input->post($var2);
		
		$bu_per_vd = $this->input->post($var3);
		$bu_fix_vd = $this->input->post($var4);
		$data = array(
		'indi_per'=>$in_per_vd,
		'indi_fix'=>$in_fix_vd,
		'busi_per'=>$bu_per_vd,
		'busi_fix'=>$bu_fix_vd,
		'updated'=>date('Y-m-d H:i:s'),
		);
		
		$hidden='hidden_'.$inst['inst_name'];
	//	echo "<pre>"; print_r($data); echo $this->input->post($hidden);
		$this->mod_settings->update_db($table,$data,$col,$this->input->post($hidden));
		
		$var5='in_per_d_'.$inst['inst_name'];
		$var6='in_fix_d_'.$inst['inst_name'];
		$var7='bu_per_d_'.$inst['inst_name'];
		$var8='bu_fix_d_'.$inst['inst_name'];
		
		$in_per_vd = $this->input->post($var5);
		$in_fix_vd = $this->input->post($var6);
		
		$bu_per_vd = $this->input->post($var7);
		$bu_fix_vd = $this->input->post($var8);
		$data1 = array(
		'indi_per'=>$in_per_vd,
		'indi_fix'=>$in_fix_vd,
		'busi_per'=>$bu_per_vd,
		'busi_fix'=>$bu_fix_vd,
		'updated'=>date('Y-m-d H:i:s'),
		);
			$hidden_d='hidden_d_'.$inst['inst_name'];
		//print_r($data1);echo $this->input->post($hidden_d);
	
		$this->mod_settings->update_db($table,$data1,$col,$this->input->post($hidden_d));

	}
	
		$this->fee_settings(20);		
}

public function update_sr(){
	//echo "<pre>"; print_r($_POST);echo count($_POST);exit;
	$table = "kt_sr_setting";
	$col ="id";
	$all_inst=$this->mod_settings->get_data_inst($table,$col)->result_array();
//	print_r($all_inst); 
	
	foreach($all_inst as $inst){

	
		$var1='in_per_w_'.$inst['inst_name'];
	 	$var2='in_fix_w_'.$inst['inst_name'];
	 	$var3='bu_per_w_'.$inst['inst_name'];
		$var4='bu_fix_w_'.$inst['inst_name'];
		
		$in_per_vd = $this->input->post($var1);
		$in_fix_vd = $this->input->post($var2);
		
		$bu_per_vd = $this->input->post($var3);
		$bu_fix_vd = $this->input->post($var4);
		$data = array(
		'indi_per'=>$in_per_vd,
		'indi_fix'=>$in_fix_vd,
		'busi_per'=>$bu_per_vd,
		'busi_fix'=>$bu_fix_vd,
		'updated'=>date('Y-m-d H:i:s'),
		);
		
		$hidden='hidden_'.$inst['inst_name'];
	//	echo "<pre>"; print_r($data); echo $this->input->post($hidden);
		$this->mod_settings->update_db($table,$data,$col,$this->input->post($hidden));
		
	}
	
		$this->sr_settings(20);		
}

public function update_sci(){
	//echo "<pre>"; print_r($_POST);echo count($_POST);exit;
	$table = "kt_sci_setting";
	$col ="id";
	$all_inst=$this->mod_settings->get_data_inst($table,$col)->result_array();
//	print_r($all_inst); 
	
	foreach($all_inst as $inst){

	
		$var1='in_per_w_'.$inst['inst_name'];
	 	$var2='in_fix_w_'.$inst['inst_name'];
	 	$var3='bu_per_w_'.$inst['inst_name'];
		$var4='bu_fix_w_'.$inst['inst_name'];
		
		$in_per_vd = $this->input->post($var1);
		$in_fix_vd = $this->input->post($var2);
		
		$bu_per_vd = $this->input->post($var3);
		$bu_fix_vd = $this->input->post($var4);
		$data = array(
		'indi_per'=>$in_per_vd,
		'indi_fix'=>$in_fix_vd,
		'busi_per'=>$bu_per_vd,
		'busi_fix'=>$bu_fix_vd,
		'updated'=>date('Y-m-d H:i:s'),
		);
		
		$hidden='hidden_'.$inst['inst_name'];
	//	echo "<pre>"; print_r($data); echo $this->input->post($hidden);
		$this->mod_settings->update_db($table,$data,$col,$this->input->post($hidden));
		
	}
	
		$this->sci(20);		
}



public function update_ex(){
	//echo "<pre>"; print_r($_POST);echo count($_POST);exit;
	$table = "kt_exchange_setting";
	$col ="id";
	$all_inst=$this->mod_settings->get_data_inst($table,$col)->result_array();
//	print_r($all_inst); 
	
	foreach($all_inst as $inst){

	
		$var1='in_per_w_'.$inst['inst_name'];
	 	$var2='in_fix_w_'.$inst['inst_name'];
	 	$var3='bu_per_w_'.$inst['inst_name'];
		$var4='bu_fix_w_'.$inst['inst_name'];
		
		$in_per_vd = $this->input->post($var1);
		$in_fix_vd = $this->input->post($var2);
		
		$bu_per_vd = $this->input->post($var3);
		$bu_fix_vd = $this->input->post($var4);
		$data = array(
		'indi_per'=>$in_per_vd,
		'indi_fix'=>$in_fix_vd,
		'busi_per'=>$bu_per_vd,
		'busi_fix'=>$bu_fix_vd,
		'updated'=>date('Y-m-d H:i:s'),
		);
		
		$hidden='hidden_'.$inst['inst_name'];
	//	echo "<pre>"; print_r($data); echo $this->input->post($hidden);
		$this->mod_settings->update_db($table,$data,$col,$this->input->post($hidden));
		
	}
	
		$this->exchange(20);		
}

public function update_wd(){
	//echo "<pre>"; print_r($_POST);echo count($_POST);exit;
	$table = "kt_withdraw_setting";
	$col ="id";
	$all_inst=$this->mod_settings->get_data_inst($table,$col)->result_array();
//	print_r($all_inst); 
	
	foreach($all_inst as $inst){

	
		$var1='in_per_w_'.$inst['inst_name'];
	 	$var2='in_fix_w_'.$inst['inst_name'];
	 	$var3='bu_per_w_'.$inst['inst_name'];
		$var4='bu_fix_w_'.$inst['inst_name'];
		
		$in_per_vd = $this->input->post($var1);
		$in_fix_vd = $this->input->post($var2);
		
		$bu_per_vd = $this->input->post($var3);
		$bu_fix_vd = $this->input->post($var4);
		$data = array(
		'indi_per'=>$in_per_vd,
		'indi_fix'=>$in_fix_vd,
		'busi_per'=>$bu_per_vd,
		'busi_fix'=>$bu_fix_vd,
		'updated'=>date('Y-m-d H:i:s'),
		);
		
		$hidden='hidden_'.$inst['inst_name'];
	//	echo "<pre>"; print_r($data); echo $this->input->post($hidden);
		$this->mod_settings->update_db($table,$data,$col,$this->input->post($hidden));
		
	}
	
		$this->withdraw(20);		
}

	public function exc_fee_settings($val=NULL)
	{
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Pages Results
		$table = "kt_fee_setting";
		$col ="id";
		$data['fee_data_inst']=$this->mod_settings->get_data_inst($table,$col)->result_array();
		$data['fee_data_all']=$this->mod_settings->get_data($table,$col)->result_array();
	//echo "<pre>";print_r($data['fee_data_all']);exit;

		if($val==12)
		{
			
		}
		else if($val==20){
			
			$data['success'] = "Setting updated successfully";
		}else
		{
			NULL;
		}
		
		
		$this->load->view('settings/exc_fee_settings',$data);
		
	}//end index()
	
	
	public function group_fee_settings($val=NULL){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching first Result 
		$table = "kt_grp_fee_setting";
		$col ="grp";
		$data['fee_data_inst']=$this->mod_settings->get_data_inst($table,$col)->result_array();
		$data['grp_fee_settings'] =$this->mod_settings->get_grp_fee_setting(1);
		
	//echo "<pre>";print_r($data['grp_fee_settings']);exit;
	
		//get groups
		$data['groups'] = $this->mod_settings->get_groups();
		
			
		if($val==12)
		{
			
		}
		else if($val==20){
			
			$data['success'] = "Setting updated successfully";
		}else
		{
			NULL;
		}
		
		
		if($this->input->post('data'))
		{
			$grp_id = $this->input->post('data');
			$data['grp_fee_settings'] = $this->mod_settings->get_grp_fee_setting($grp_id);
			echo json_encode($data['grp_fee_settings']);
			exit;
		}
		
		$this->load->view('settings/grp_fee_settings',$data);
		
	}//end index()

	public function update_grp_fee(){
	//echo "<pre>"; print_r($_POST);echo count($_POST);
	$table = "kt_grp_fee_setting";
	$col ="id";
	$all_inst=$this->mod_settings->get_data_inst($table,$col)->result_array();
//	print_r($all_inst); 
	
	foreach($all_inst as $inst){

	
		$var1='ex_per_w_'.$inst['inst_name'];
	 	$var2='ex_fix_w_'.$inst['inst_name'];
		
		$ex_per_vd = $this->input->post($var1);
		$ex_fix_vd = $this->input->post($var2);
		
		$data = array(
			'ex_per'=>$ex_per_vd,
			'ex_fix'=>$ex_fix_vd,
			'updated'=>date('Y-m-d H:i:s')
		);
		
		$hidden='hidden_'.$inst['inst_name'];
	//	echo "<pre>"; print_r($data); echo $this->input->post($hidden);
		$this->mod_settings->update_db($table,$data,$col,$this->input->post($hidden));
		
		$var5='ex_per_d_'.$inst['inst_name'];
		$var6='ex_fix_d_'.$inst['inst_name'];
		
		$ex_per_vd = $this->input->post($var5);
		$ex_fix_vd = $this->input->post($var6);
		
		$data1 = array(
		'ex_per'=>$ex_per_vd,
		'ex_fix'=>$ex_fix_vd,
		'updated'=>date('Y-m-d H:i:s'),
		);
		
		$hidden_d='hidden_d_'.$inst['inst_name'];
		//print_r($data1);echo $this->input->post($hidden_d);
	
		$this->mod_settings->update_db($table,$data1,$col,$this->input->post($hidden_d));

	}
	
		$this->group_fee_settings(20);		
}
	
	public function group_SR_settings($val=NULL){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching First group result
		$data['grp_sr_settings'] =$this->mod_settings->get_grp_sr_setting(1);
		
	
		//get groups
		$data['groups'] = $this->mod_settings->get_groups();

		if($val==12)
		{
			
		}
		else if($val==20){
			
			$data['success'] = "Setting updated successfully";
		}else
		{
			NULL;
		}
		
		if($this->input->post('data'))
		{
			$grp_id = $this->input->post('data');
			$data['grp_sr_settings'] = $this->mod_settings->get_grp_sr_setting($grp_id);
			echo json_encode($data['grp_sr_settings']);
			exit;
		}
		
		$this->load->view('settings/group_sr_settings',$data);
		
	}
	
	public function update_grp_sr()
	{
		//echo "<pre>"; print_r($_POST);echo count($_POST);exit;
		$table = "kt_grp_sr_setting";
		$col ="id";
		$all_inst=$this->mod_settings->get_data_inst($table,$col)->result_array();
		//print_r($all_inst); exit;
		
		foreach($all_inst as $inst){

		
			$var1='ex_per_w_'.$inst['inst_name'];
			$var2='ex_fix_w_'.$inst['inst_name'];
			
			
			$ex_per_vd = $this->input->post($var1);
			$ex_fix_vd = $this->input->post($var2);
			
			
			$data = array(
			'ex_per'=>$ex_per_vd,
			'ex_fix'=>$ex_fix_vd,
			'updated'=>date('Y-m-d H:i:s'),
			);
			
			$hidden='hidden_'.$inst['inst_name'];
			//echo "<pre>"; print_r($data); echo $this->input->post($hidden); exit;
			$this->mod_settings->update_db($table,$data,$col,$this->input->post($hidden));
			
		}
		
			$this->group_SR_settings(20);		
	}
	
	
	public function group_withdraw($val=NULL){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching First group result
		$data['grp_withdraw_settings'] =$this->mod_settings->get_grp_withdraw_setting(1);
	
		//get groups
		$data['groups'] = $this->mod_settings->get_groups();

		if($val==12)
		{
			
		}
		else if($val==20){
			
			$data['success'] = "Setting updated successfully";
		}else
		{
			NULL;
		}
		
		if($this->input->post('data'))
		{
			$grp_id = $this->input->post('data');
			$data['grp_withdraw_settings'] = $this->mod_settings->get_grp_withdraw_setting($grp_id);
			echo json_encode($data['grp_withdraw_settings']);
			exit;
		}
		
		
		$this->load->view('settings/group_withdraw_settings',$data);
		
	}
	
	
	public function update_grp_wd()
	{
		//echo "<pre>"; print_r($_POST);echo count($_POST);exit;
		$table = "kt_grp_withdraw_setting";
		$col ="id";
		$all_inst=$this->mod_settings->get_data_inst($table,$col)->result_array();
	//	print_r($all_inst); 
		
		foreach($all_inst as $inst){

		
			$var1='ex_per_'.$inst['inst_name'];
			$var2='ex_fix_'.$inst['inst_name'];
			
			$ex_per_vd = $this->input->post($var1);
			$ex_fix_vd = $this->input->post($var2);
		
			$data = array(
			'ex_per'=>$ex_per_vd,
			'ex_fix'=>$ex_fix_vd,
			'updated'=>date('Y-m-d H:i:s'),
			);
			
			$hidden='hidden_'.$inst['inst_name'];
			//echo "<pre>"; print_r($data); echo $this->input->post($hidden); exit;
			$this->mod_settings->update_db($table,$data,$col,$this->input->post($hidden));
			
		}
		
		$this->group_withdraw(20);	
	}
	
	
	public function group_exchange($val=NULL)
	{
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching First group result
		$data['grp_exchange_settings'] =$this->mod_settings->get_grp_exchange_setting(1);
	
		//get groups
		$data['groups'] = $this->mod_settings->get_groups();

		if($val==12)
		{
			
		}
		else if($val==20){
			
			$data['success'] = "Setting updated successfully";
		}else
		{
			NULL;
		}
		
		if($this->input->post('data'))
		{
			$grp_id = $this->input->post('data');
			$data['grp_exchange_settings'] = $this->mod_settings->get_grp_exchange_setting($grp_id);
			echo json_encode($data['grp_exchange_settings']);
			exit;
		}
		
		$this->load->view('settings/group_exchange_settings',$data);
	}
	
	
	public function update_grp_ex()
	{
		$table = 'kt_grp_exchange_setting';
		$col = 'id';
		$data = array(
		'ex_per'=>$this->input->post('ex_per'),
		'ex_fix'=>$this->input->post('ex_fix'),
		'updated'=>date('Y-m-d H:i:s'),
		);
	
	//	echo "<pre>"; print_r($data); echo $this->input->post($hidden);
		$this->mod_settings->update_db($table,$data,$col,$this->input->post('hidden'));
		
		$this->group_exchange(20);		
	}
	
	
	public function group_sci($val=NULL){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching First group result
		$data['grp_sci_settings'] =$this->mod_settings->get_grp_sci_setting(1);
	
		//get groups
		$data['groups'] = $this->mod_settings->get_groups();

		if($val==12)
		{
			
		}
		else if($val==20){
			
			$data['success'] = "Setting updated successfully";
		}else
		{
			NULL;
		}
		
		if($this->input->post('data'))
		{
			$grp_id = $this->input->post('data');
			$data['grp_sci_settings'] = $this->mod_settings->get_grp_sci_setting($grp_id);
			echo json_encode($data['grp_sci_settings']);
			exit;
		}
		
		$this->load->view('settings/group_sci_settings',$data);
		
	}	
	
	
	public function update_grp_sci()
	{
		//echo "<pre>"; print_r($_POST);echo count($_POST);exit;
		$table = "kt_grp_sci_setting";
		$col ="id";
			
		$data = array(
		'ex_per'=>$this->input->post('ex_per'),
		'ex_fix'=>$this->input->post('ex_fix'),
		'updated'=>date('Y-m-d H:i:s'),
		);

	//	echo "<pre>"; print_r($data); echo $this->input->post($hidden);
		$this->mod_settings->update_db($table,$data,$col,$this->input->post('hidden'));
		
		$this->group_sci(20);		
	}
	
	
}//end Manage setting
