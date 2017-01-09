<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_shadow_boxes extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('slider/mod_slider');
		$this->load->model('common/mod_common');
		$this->load->model('home/manage_section_m');
		$this->load->library('BreadcrumbComponent');	
	}

	public function index(){
		
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
		$data['meta_title'] = Manage_Sections;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('Manage Shadow Boxes', base_url().'');
		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		
		
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		
		
		
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Pages Results
		$data['boxes_data'] = $this->manage_section_m->get_all_values_frm_table('kt_miscellaneous');
		
		$this->load->view('home/shadow_boxes',$data);
		
	}//end index()
	
	
	public function gen_setting()
	{}
	
	public function update_shadow_box()
	{
		//echo '<pre>';
		//print_r($this->input->post());
		//exit;
		
		 //[shadow_box_content]
		
		$id = $this->input->post('box_id');
		
		$image = $_FILES['sec_image']['name'];
		
		$updated_data = array(
			//'sec_desc' =>$this->input->post(''),
			'title'=> $this->input->post('shadow_box_content')
			//'type'	
		);
		
		
		$this->db->where('id',$id);
		$this->db->update('kt_miscellaneous',$updated_data);
		$this->index();
		/*
		[sec_title] => Why Us
		[sec_image] => 
		[sec_content] => 
		
		Lorem ipsum dolor 
		
		[menu_url_other] => 
		[menu_url_self] => http://dev.ejuicysolutions.com/blackbull/admin/content/view
		[menu_id] => 1
		
		*/
		
		//$this->manage_section_m->update_sec();
		
		/*echo '<pre>';
		print_r($updated_data);
		exit;*/
	}
	public function update_right_sidebar()
	{		
		$id = $this->input->post('right_sidebar_id');
		
		//$image = $_FILES['sec_image']['name'];
		
		$updated_data = array(
			'title'=> $this->input->post('right_sidebar_contents'),
			'desc'=>$this->input->post('right_sidebar_title')
		);
		
		$this->db->where('id',$id);
		$this->db->update('kt_miscellaneous',$updated_data);
		$this->index();
	}	
}//end Manage setting
