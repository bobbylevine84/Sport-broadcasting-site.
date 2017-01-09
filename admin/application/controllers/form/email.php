<?php
class Email extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/mod_admin');
		$this->load->model('slider/mod_slider');
		$this->load->model('common/mod_common');
		
		$this->load->library('BreadcrumbComponent');
		
		$this->load->model('templates/mod_email');
		
	}
	
	public function index()
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
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;

		//Common Includes
		$data['meta_title'] = Manage_Email_Template ;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Administration', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('Email Templating', base_url().'templates/email/manage_template');
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

		//Fetching All template Results
		
		$menus_count = $this->mod_email->get_all_templates_count();
		$data['template_list_count'] = $menus_count;
		$data['templates'] = $this->mod_email->get_filter_template_grid_data();
		
		/*echo '<pre>';
		print_r($data['templates']);
		exit;*/
		
		$this->load->view('templates/email_templating',$data);
	}
	
	
	public function edit_template($id = null)
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
		$data['meta_title'] = Manage_Email_Template ;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Administration', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('Email Templating', base_url().'templates/email');
		$this->breadcrumbcomponent->add('Edit Template', base_url().'templates/email/manage_template');
		
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
		
		
		$this->db->where('id',$id);
		$data['curr_template'] = $this->db->get('kt_email_template')->result();
		
		
		/*
		echo '<pre>';
		print_r($data['curr_template']);
		exit;
		*/
		
		$this->load->view('templates/edit_template',$data);
	}
	public function update_process()
	{
		/*echo 'i am template/email/update_process';
		echo '<pre>';
		print_r($this->input->post());
		exit;*/
		$val = $this->input->post("id");
		$edit_template = array(
			'subject' => $this->input->post("subject"),
    		'message' => $this->input->post("template")
		);
		
		$this->mod_email->update_template($val,$edit_template);
		
		$this->index();	
		
	}



}






?>