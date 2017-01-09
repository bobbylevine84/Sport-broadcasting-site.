<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Slider extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('slider/mod_slider');
		$this->load->model('common/mod_common');
		
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(13,$this->session->userdata('permissions_arr'))){
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
		
		
		$this->breadcrumbcomponent->add('Manage Slider Images', base_url().'slider/manage-slider');
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
		
		$this->load->view('slider/manage_slider',$data);
		
	}//end index()
	
	//Add New Slider Image
	public function add_new_image(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(13,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 0;
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
		$this->breadcrumbcomponent->add('Manage Slider Images', base_url().'slider/manage-slider');
		$this->breadcrumbcomponent->add('Add New Image', base_url().'slider/manage-slider/add-new-image');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view('slider/add_new_image',$data);
		
	}//add_new_page

	public function add_new_image_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_image_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(13,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		

		$data_arr['add-image-data'] = $this->input->post();
		$this->session->set_userdata($data_arr);
		
		if(trim($_FILES['slider_image']['name']) == '')
		{
			$this->session->set_flashdata('err_message', '- Select Slider Image.');
			redirect(base_url().'slider/manage-slider/add-new-image');
			
		}//end if(trim($this->input->post('page_title')) == '')
		
		//Adding New Slider Image
		$add_slider_image = $this->mod_slider->add_new_image($this->input->post());

		
		if($add_slider_image && $add_slider_image['error'] == ''){		
			
			//Unset POST values from session
			$this->session->unset_userdata('add-image-data');
			
			$this->session->set_flashdata('ok_message', '- New Slider Image added successfully.');
			redirect(base_url().'slider/manage-slider');
			
		}else{
			
			if($add_slider_image['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($add_slider_image['error']));
				//echo 'here';
				//exit;
				redirect(base_url().'slider/manage-slider/add-new-image');
				
			}else{
				$this->session->set_flashdata('err_message', '- New Slider Image is not uploaded. Something went wrong, please try again.');
				redirect(base_url().'slider/manage-slider/add-new-image');
				
			}//end if($add_new_article['error'] != '')
			
		}//end if($add_slider_image)

	}//end add_page_process

	//Edit Page
	public function edit_image($image_id){

		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable > 32
		if(!in_array(13,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 1;
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
		$this->breadcrumbcomponent->add('Manage Slider Images', base_url().'slider/manage-slider');
		$this->breadcrumbcomponent->add('Edit Slider Image', base_url().'slider/manage-slider/edit-image/'.$page_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Fetching Image slider Results
		$get_slider_image = $this->mod_slider->get_slider_image($image_id);
		$data['slider_image_data'] = $get_slider_image['slider_image_arr'];
		$data['slider_image_count'] = $get_slider_image['slider_image_count'];
		
		if($get_slider_image['slider_image_count'] == 0) redirect(base_url());
		
		$this->load->view('slider/edit_image',$data);
		
	}//add_new_page

	public function edit_image_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('upd_image_sbt')) redirect(base_url());
		
		$image_id = $this->input->post('image_id');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(13,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Updating Image slider
		$upd_slider_image = $this->mod_slider->edit_image($this->input->post());
		
		if($upd_slider_image && $upd_slider_image['error'] == ''){	
			
			$this->session->set_flashdata('ok_message', '- Slider image updated successfully.');
			redirect(base_url().'slider/manage-slider/edit-image/'.$image_id);
			
		}else{

			if($upd_slider_image['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_slider_image['error']));
				redirect(base_url().'slider/manage-slider/edit-image/'.$image_id);
				
			}else{
				
				$this->session->set_flashdata('err_message', '- Slider image is not updated. Something went wrong, please try again.');
				redirect(base_url().'slider/manage-slider/edit-image/'.$image_id);

			}//end if($add_slider_image['error'] != '')
			
		}//end if($add_cms_page)

	}//end add_page_process
	
	public function delete_image($image_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable >33
		if(!in_array(13,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//If Post is not SET
		if(!isset($image_id)) redirect(base_url());
		
		//Updating Page
		$del_slider_image = $this->mod_slider->delete_image($image_id);
		
		if($del_slider_image){
			
			$this->session->set_flashdata('ok_message', '- Slider Image deleted successfully.');
			redirect(base_url().'slider/manage-slider');
			
		}else{
			$this->session->set_flashdata('err_message', '- Slider Image cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'slider/manage-slider');
			
		}//end if($add_cms_page)

	}//end delete_page
	
	public function edit_slider_caption()
	{
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(31,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 0;
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
		$this->breadcrumbcomponent->add('Manage Slider', base_url().'slider/manage-slider');
		$this->breadcrumbcomponent->add('Edit Slider Caption', base_url().'slider/manage-slider/add-new-image');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		
		$data['slide_cap'] = $this->mod_slider->get_slider_caption();
		
		
		$this->load->view('slider/edit_slider_caption',$data);
	}
	public function edit_caption_process()
	{
		$this->mod_slider->update_caption();
		$this->edit_slider_caption();		
	}
	

}//end slider  
