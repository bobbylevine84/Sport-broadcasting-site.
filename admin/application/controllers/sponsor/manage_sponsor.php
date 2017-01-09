<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Sponsor extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('sponsor/mod_sponsor');
		$this->load->model('common/mod_common');
		
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
		$this->breadcrumbcomponent->add('Manage Bank Sponsor Images', base_url().'sponsor/manage-sponsor');
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
		$get_sponsor_images = $this->mod_sponsor->get_all_sponsor();

		$data['sponsor_arr'] = $get_sponsor_images['sponsor_arr'];
		$data['sponsor_count'] = $get_sponsor_images['sponsor_count'];
		
		$this->load->view('sponsor/manage_sponsor',$data);
		
	}//end index()
	
	//Add New sponsor
	public function add_new_sponsor(){
		
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
		$this->breadcrumbcomponent->add('Manage Bank Sponsor Images', base_url().'sponsor/manage-sponsor');
		$this->breadcrumbcomponent->add('Add New Image', base_url().'sponsor/manage-sponsor/add-new-sponsor');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view('sponsor/add_new_sponsor',$data);
		
	}//add_new_sponsor

	public function add_new_sponsor_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_sponsor_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(36,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		

		$data_arr['add-sponsor-data'] = $this->input->post();
		
		$this->session->set_userdata($data_arr);
		
		if(trim($this->input->post(sponsor_bank_name)) == '')
			$err_message .= '- Select Bank Sponsor Image.<br>';

		if(trim($_FILES['sponsor_image']['name']) == ''){
			
			$err_message .= '- Select Bank Sponsor Image.<br>';
			
			
		}//end if(trim($_FILES['sponsor_image']['name']) == '')
		
		if(trim($err_message) != '')
			redirect(base_url().'sponsor/manage-sponsor/add-new-sponsor');

		//Adding New Sponsor
		$add_sponsor_image = $this->mod_sponsor->add_new_sponsor($this->input->post());

		if($add_sponsor_image && $add_sponsor_image['error'] == ''){		
			
			//Unset POST values from session
			$this->session->unset_userdata('add-sponsor-data');
			
			$this->session->set_flashdata('ok_message', '- New Bank Sponsor added successfully.');
			redirect(base_url().'sponsor/manage-sponsor');
			
		}else{
			
			if($add_sponsor_image['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($add_sponsor_image['error']));
				redirect(base_url().'sponsor/manage-sponsor/add-new-sponsor');
				
			}else{
				$this->session->set_flashdata('err_message', '- New Sponsor is not added. Something went wrong, please try again.');
				redirect(base_url().'sponsor/manage-sponsor/add-new-sponsor');
				
			}//end if
			
		}//end if($add_sponsor_image)

	}//end add_page_process

	//Edit Sponsor
	public function edit_sponsor($spons_id){

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
		$this->breadcrumbcomponent->add('Manage Bank Sponsors', base_url().'sponsor/manage-sponsor');
		$this->breadcrumbcomponent->add('Edit Sppnsor', base_url().'sponsor/manage-sponsor/edit-sponsor/'.$spons_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Fetching Image sponsor Results
		$get_sponsor_image = $this->mod_sponsor->get_sponsor($spons_id);
		$data['sponsor_data'] = $get_sponsor_image['sponsor_arr'];
		$data['sponsor_count'] = $get_sponsor_image['sponsor_count'];
		
		if($get_sponsor_image['sponsor_count'] == 0) redirect(base_url());
		
		$this->load->view('sponsor/edit_sponsor',$data);
		
	}//edit_sponsor

	public function edit_sponsor_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('upd_sponsor_sbt')) redirect(base_url());
		
		$spons_id = $this->input->post('spons_id');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(37,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if

		//Updating Image sponsor
		$upd_sponsor_image = $this->mod_sponsor->edit_sponsor($this->input->post());
		
		if($upd_sponsor_image && $upd_sponsor_image['error'] == ''){	
			
			$this->session->set_flashdata('ok_message', '- Sponsor updated successfully.');
			redirect(base_url().'sponsor/manage-sponsor/edit-sponsor/'.$spons_id);
			
		}else{

			if($upd_sponsor_image['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_sponsor_image['error']));
				redirect(base_url().'sponsor/manage-sponsor/edit-sponsor/'.$image_id);
				
			}else{
				
				$this->session->set_flashdata('err_message', '- Sponsor is not updated. Something went wrong, please try again.');
				redirect(base_url().'sponsor/manage-sponsor/edit-sponsor/'.$spons_id);

			}//end if($add_sponsor_image['error'] != '')
			
		}//end if

	}//end edit_sponsor_process
	
	public function delete_sponsor($spons_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(38,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if
		
		//If Post is not SET
		if(!isset($spons_id)) redirect(base_url());
		
		//Updating Page
		$del_sponsor_image = $this->mod_sponsor->delete_sponsor($spons_id);
		
		if($del_sponsor_image){
			
			$this->session->set_flashdata('ok_message', '- Bank Sponsor deleted successfully.');
			redirect(base_url().'sponsor/manage-sponsor');
			
		}else{
			$this->session->set_flashdata('err_message', '- Bank Sponor cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'sponsor/manage-sponsor');
			
		}//end if

	}//end delete_page

}//end Dashboard 
