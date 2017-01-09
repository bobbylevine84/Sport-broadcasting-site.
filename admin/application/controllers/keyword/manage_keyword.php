<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_keyword extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		//$this->load->model('sponsor/mod_sponsor');
		$this->load->model('common/mod_common');
		$this->load->model('keyword/mod_keyword');
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
		$this->breadcrumbcomponent->add('Manage keyword', base_url().'keyword/manage-keyword');
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
		$get_keyword = $this->mod_keyword->get_all_keyword();
		$data['keyword_arr'] = $get_keyword['keyword_arr'];
		$data['keyword_count'] = $get_keyword['keyword_count'];
		//echo "<pre>"; print_r($data['keyword_count']);exit;
		$this->load->view('keyword/manage_keyword',$data);
	}//end index()
	public function add_new_keyword(){
		
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
		$this->breadcrumbcomponent->add('Manage keyword', base_url().'keyword/manage-keyword');
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
		

		$this->load->view('keyword/add_new_keyword',$data);
	}//end index()
	public function add_keyword_process(){
		$keyword = $this->input->post('keyword');
		
		$check = $this->db->get('kt_keyword')->num_rows();
		if($check < 10){
			$insert_array = array(
			'keyword' => $keyword
			);
			$insert = $this->db->insert('kt_keyword',$insert_array);
			
			if($insert){
			$this->session->set_flashdata('ok_message', 'Successfully Added');
			redirect('keyword/manage_keyword');
			} else {
				$this->session->set_flashdata('err_message', 'Something went wrong');
				redirect('keyword/manage_keyword');
			}
		
		} else {
			$this->session->set_flashdata('err_message', 'You cannot add more then 10 keywords.');
			redirect('keyword/manage_keyword');
		}
		
		
	}
	public function edit_keyword($id){
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
		$this->breadcrumbcomponent->add('Manage keyword', base_url().'keyword/manage-keyword');
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
		
		$this->db->where('id',$id);
		$keyword = $this->db->get('kt_keyword')->result_array();
		$data['keyword'] = $keyword;
		$this->load->view('keyword/edit_keyword',$data);
	}
	public function edit_keyword_process(){
		$id = $this->input->post('id');
		$keyword = $this->input->post('keyword');
		
		$update_array = array(
			'keyword' => $keyword
		);
		$this->db->where('id',$id);
		$update = $this->db->update('kt_keyword',$update_array);
		if($update){
			$this->session->set_flashdata('ok_message', 'Successfully updated');
			redirect('keyword/manage_keyword');
		} else {
			$this->session->set_flashdata('err_message', 'Something went wrong');
			redirect('keyword/manage_keyword');
		}
	}
	public function delete_keyword($id){
		
		$this->db->where('id',$id);
		$delete = $this->db->delete('kt_keyword');
		if($delete){
			redirect('keyword/manage_keyword');
		} else {
			redirect('keyword/manage_keyword');
		}
	}
}
