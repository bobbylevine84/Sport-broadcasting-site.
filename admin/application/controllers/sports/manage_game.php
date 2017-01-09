<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_game extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('sponsor/mod_sponsor');
		$this->load->model('common/mod_common');
		$this->load->model('testimonial/mod_testimonial');
		
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(35,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage testimonial Images', base_url().'testimonial/manage-testimonial');
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
		$get_testimonial_images = $this->mod_testimonial->get_all_testimonial();

		$data['testimonial_arr'] = $get_testimonial_images['testimonial_arr'];
		$data['testimonial_count'] = $get_testimonial_images['testimonial_count'];

		
		$this->load->view('testimonial/manage_testimonial',$data);
	}//end index()
	
	public function add_new_testimonial(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(36,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Testimonial Images', base_url().'testimonial/manage-testimonial');
		$this->breadcrumbcomponent->add('Add New Image', base_url().'testimonial/manage-testimonial/add-new-testimonial');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view("testimonial/add_new_testimonial",$data);
		
	}//add_new_testimonial
	public function add_new_testimonial_process(){
		
		//If Post is not SET
		//if(!$this->input->post() && !$this->input->post('add_sponsor_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(36,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		

		$data_arr['add-testimonial-data'] = $this->input->post();
		
		$this->session->set_userdata($data_arr);
		
		if(trim($this->input->post(testimonial_name)) == '')
			$err_message .= '- Select Bank Sponsor Image.<br>';

		if(trim($_FILES['testimonial_image']['name']) == ''){
			
			$err_message .= '- Select Image.<br>';
			
			
		}//end if(trim($_FILES['sponsor_image']['name']) == '')
		
		if(trim($err_message) != '')
			redirect(base_url().'testimonial/manage-testimonial/add-new-testimonial');

		//Adding New Sponsor
		$add_testimonial_image = $this->mod_testimonial->add_new_testimonial($this->input->post());

		if($add_testimonial_image && $add_testimonial_image['error'] == ''){		
			
			//Unset POST values from session
			$this->session->unset_userdata('add-sponsor-data');
			
			$this->session->set_flashdata('ok_message', '- added successfully.');
			redirect(base_url().'testimonial/manage-testimonial');
			
		}else{
			
			if($add_sponsor_image['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($add_testimonial_image['error']));
				redirect(base_url().'testimonial/manage-testimonial/add-new-testimonial');
				
			}else{
				$this->session->set_flashdata('err_message', '- New Sponsor is not added. Something went wrong, please try again.');
				redirect(base_url().'testimonial/manage-testimonial/add-new-testimonial');
				
			}//end if
			
		}//end if($add_sponsor_image)

	}//end add_page_process
	//Edit Sponsor
	public function edit_testimonial($testimonial_id){

		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(37,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage testimonials', base_url().'testimonial/manage-testimonial');
		$this->breadcrumbcomponent->add('Edit testimonial', base_url().'testimonial/manage-testimonial/edit-testimonial/'.$spons_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Fetching Image sponsor Results
		$get_testimonial_image = $this->mod_testimonial->get_testimonial($testimonial_id);
		$data['testimonial_data'] = $get_testimonial_image['testimonial_arr'];
		$data['testimonial_count'] = $get_testimonial_image['testimonial_count'];
		
		if($get_testimonial_image['testimonial_count'] == 0) redirect(base_url());
		
		$this->load->view('testimonial/edit_testimonial',$data);
		
	}//edit_sponsor

	public function edit_testimonial_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('upd_testimonial_sbt')) redirect(base_url());
		
		$testimonial_id = $this->input->post('testimonial_id');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(37,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if

		//Updating Image sponsor
		$upd_testimonial_image = $this->mod_testimonial->edit_testimonial($this->input->post());
		
		if($upd_testimonial_image && $upd_testimonial_image['error'] == ''){	
			
			$this->session->set_flashdata('ok_message', '- Testimonial updated successfully.');
			redirect(base_url().'testimonial/manage-testimonial/');
			//redirect(base_url().'testimonial/manage-testimonial/edit-testimonial/'.$testimonial_id);
			
		}else{

			if($upd_testimonial_image['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_testimonial_image['error']));
				redirect(base_url().'testimonial/manage-testimonial/edit-testimonial/'.$image_id);
				
			}else{
				
				$this->session->set_flashdata('err_message', '- Testimonial is not updated. Something went wrong, please try again.');
				redirect(base_url().'testimonial/manage-testimonial/edit-testimonial/'.$testimonial_id);

			}//end if($add_testimonial_image['error'] != '')
			
		}//end if

	}//end edit_testimonial_process
	public function delete_testimonial($testimonial_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(38,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if
		
		//If Post is not SET
		if(!isset($testimonial_id)) redirect(base_url());
		
		//Updating Page
		$del_testimonial_image = $this->mod_testimonial->delete_testimonial($testimonial_id);
		
		if($del_testimonial_image){
			
			$this->session->set_flashdata('ok_message', '- Testimonial deleted successfully.');
			redirect(base_url().'testimonial/manage-testimonial');
			
		}else{
			$this->session->set_flashdata('err_message', '- Testimonial cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'testimonial/manage-testimonial');
			
		}//end if

	}//end delete_page
	

}
