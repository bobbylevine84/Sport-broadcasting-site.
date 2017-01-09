<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Partners extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('cms/mod_cms');
		$this->load->model('common/mod_common');
		
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
		$this->breadcrumbcomponent->add('Manage partners Images', base_url().'cms/manage-partners');
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
		$get_partners_images = $this->mod_cms->get_all_partners_images();
		


		$data['partners_images_arr'] = $get_partners_images['partners_images_arr'];
		$data['partners_images_count'] = $get_partners_images['partners_images_count'];
		//echo "<pre>";print_r($data);exit();
		$this->load->view('cms/manage_partners',$data);
		
	}//end index()	
	
	
	//Add New partners Image
	public function add_new_image()
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
		$this->breadcrumbcomponent->add('Manage partners Images', base_url().'cms/manage_partners');
		$this->breadcrumbcomponent->add('Add New Image', base_url().'cms/manage_partners/add_new_image');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);

	    $get_partners_images = $this->mod_cms->get_all_partners_images();
		

		$data['partners_images_arr'] = $get_partners_images['partners_images_arr'];
		$data['partners_images_count'] = $get_partners_images['partners_images_count'];

		
		$this->load->view('cms/add_new_image',$data);
		
	}//add_new_page

	
	public function add_new_image_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_image_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(31,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		

		$data_arr['add-image-data'] = $this->input->post();
		$this->session->set_userdata($data_arr);
		
		if(trim($_FILES['partners_image']['name']) == '')
		{
			$this->session->set_flashdata('err_message', '- Select partners Image.');
			redirect(base_url().'cms/manage-partners/add-new-image');
			
		}//end if(trim($this->input->post('page_title')) == '')
		
		//Adding New partners Image
		$add_partners_image = $this->mod_cms->add_new_image_partners($this->input->post());

		
		if($add_partners_image && $add_partners_image['error'] == ''){		
			
			//Unset POST values from session
			$this->session->unset_userdata('add-image-data');
			
			$this->session->set_flashdata('ok_message', '- New partners Image added successfully.');
			redirect(base_url().'cms/manage-partners');
			
		}else{
			
			if($add_partners_image['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($add_partners_image['error']));
				//echo 'here';
				//exit;
				redirect(base_url().'cms/manage-partners/add-new-image');
				
			}else{
				$this->session->set_flashdata('err_message', '- New partners Image is not uploaded. Something went wrong, please try again.');
				redirect(base_url().'cms/manage-partners/add-new-image');
				
			}//end if($add_new_article['error'] != '')
			
		}//end if($add_partners_image)

	}//end add_page_process
	
	//Edit Page 
	public function edit_image($image_id)
	{
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(32,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage partners Images', base_url().'cms/manage-partners');
		$this->breadcrumbcomponent->add('Edit partners Image', base_url().'cms/manage-partners/edit-image/'.$page_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
        $data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Image partners Results
		$get_partners_image = $this->mod_cms->get_partners_image($image_id);
		$data['partners_image_data'] = $get_partners_image['partners_image_arr'];
		$data['partners_image_count'] = $get_partners_image['partners_image_count'];
		
		if($get_partners_image['partners_image_count'] == 0) redirect(base_url());
		
		$this->load->view('cms/edit_image_partners',$data);	
	}//end of edit page
	
	public function edit_image_process(){
	
	//If Post is not SET
	if(!$this->input->post() && !$this->input->post('upd_image_sbt')) redirect(base_url());
	
	$image_id = $this->input->post('image_id');
	
	//Login Check
	$this->mod_admin->verify_is_admin_login();

	//Verify if Page is Accessable
	if(!in_array(32,$this->session->userdata('permissions_arr'))){
		redirect(base_url().'errors/page-not-found-404');
		exit;
	}//end if

	//Updating Image partners
	$upd_partners_image = $this->mod_cms->edit_image_partners($this->input->post());
	
	if($upd_partners_image && $upd_partners_image['error'] == ''){	
		
		$this->session->set_flashdata('ok_message', '- partners image updated successfully.');
		redirect(base_url().'cms/manage-partners/edit-image/'.$image_id);
		
	}else{

		if($upd_partners_image['error'] != ''){

			$this->session->set_flashdata('err_message', '- '.strip_tags($upd_partners_image['error']));
			redirect(base_url().'cms/manage-partners/edit-image/'.$image_id);
			
		}else{
			
			$this->session->set_flashdata('err_message', '- partners image is not updated. Something went wrong, please try again.');
			redirect(base_url().'cms/manage-partners/edit-image/'.$image_id);

		}//end if($add_partners_image['error'] != '')
		
	}//end if($add_cms_page)

	}//end add_page_process
	
	
	//delete image 
	public function delete_image($image_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(33,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//If Post is not SET
		if(!isset($image_id)) redirect(base_url());
		
		//Updating Page
		$del_partners_image = $this->mod_cms->delete_image($image_id);
		
		if($del_partners_image){
			
			$this->session->set_flashdata('ok_message', '- partners Image deleted successfully.');
			redirect(base_url().'cms/manage-partners');
			
		}else{
			$this->session->set_flashdata('err_message', '- partners Image cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'cms/manage-partners');
			
		}//end if($add_cms_page)

	}//end delete_page
	
public function delete_image_partener($image_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(33,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//If Post is not SET
		if(!isset($image_id)) redirect(base_url());
		
		//Updating Page
		$del_partners_image = $this->mod_cms->delete_image_parteners($image_id);
		
		if($del_partners_image){
			
			$this->session->set_flashdata('ok_message', '- partners Image deleted successfully.');
			redirect(base_url().'cms/manage-partners');
			
		}else{
			$this->session->set_flashdata('err_message', '- partners Image cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'cms/manage-partners');
			
		}//end if($add_cms_page)

	}//end delete_page
	



	public function manage_title()
	{
		//echo 'i am cms/manage_partners/manage_title()';
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
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage partners Images', base_url().'cms/manage-partners');
		$this->breadcrumbcomponent->add('Manage Title', base_url().'');
		
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
		
		$data['title'] = $this->db->get('kt_miscellaneous')->result_array();
		$this->load->view('cms/manage_partners_title',$data);
	}	
	public function update_title()
	{
		/*echo '<pre>';
		print_r($this->input->post());
		exit;*/
		
		
		$data = array( 
			'title' => $this->input->post('title_content')
		);
		$this->db->where('id',$this->input->post('id'));
		$this->db->update('kt_miscellaneous',$data);
		
		
		$this->manage_title();
		
		
		
	}

public function change_partner_status_inactive($id)
	{
		
		$inactive = array('status'=> '1');
		$this->db->where('id',$id);
		//$query=$this->db->get('kt_Seal_certification');

		$this->db->update('kt_partner_images',$inactive);
		//print_r($inactive);exit;
		
	//redirect('/cms/manage_Partners');
		
		$this->index();
	}
	public function change_partner_status_active($id)
	{
		
		$active = array('status'=> '0');
		
		$this->db->where('id',$id);
		$this->db->update('kt_partner_images',$active);
				//echo $active; exit;
		//redirect('/cms/manage_Partners');
		
		$this->index();
	}



}//end Dashboard 
