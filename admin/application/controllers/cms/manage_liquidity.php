<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_liquidity extends CI_Controller {
	
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
		$this->breadcrumbcomponent->add('Manage Liquidity Images', base_url().'cms/manage-liquidity');
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
		$get_liquidity_images = $this->mod_cms->get_all_liquidity_images();
		
		$data['liquidity_images_arr'] = $get_liquidity_images['liquidity_images_arr'];
		$data['liquidity_images_count'] = $get_liquidity_images['liquidity_images_count'];
		
		$this->load->view('cms/manage_liquidity',$data);
		
	}//end index()	
	
	
	//Add New liquidity Image
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
		$this->breadcrumbcomponent->add('Manage liquidity Images', base_url().'cms/manage_liquidity');
		$this->breadcrumbcomponent->add('Add New Image', base_url().'cms/manage_liquidity/add_new_image');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
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
		
		if(trim($_FILES['liquidity_image']['name']) == '')
		{
			$this->session->set_flashdata('err_message', '- Select liquidity Image.');
			redirect(base_url().'cms/manage-liquidity/add-new-image');
			
		}//end if(trim($this->input->post('page_title')) == '')
		
		//Adding New liquidity Image
		$add_liquidity_image = $this->mod_cms->add_new_image($this->input->post());

		
		if($add_liquidity_image && $add_liquidity_image['error'] == ''){		
			
			//Unset POST values from session
			$this->session->unset_userdata('add-image-data');
			
			$this->session->set_flashdata('ok_message', '- New liquidity Image added successfully.');
			redirect(base_url().'cms/manage-liquidity');
			
		}else{
			
			if($add_liquidity_image['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($add_liquidity_image['error']));
				//echo 'here';
				//exit;
				redirect(base_url().'liquidity/manage-liquidity/add-new-image');
				
			}else{
				$this->session->set_flashdata('err_message', '- New liquidity Image is not uploaded. Something went wrong, please try again.');
				redirect(base_url().'liquidity/manage-liquidity/add-new-image');
				
			}//end if($add_new_article['error'] != '')
			
		}//end if($add_liquidity_image)

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
		$this->breadcrumbcomponent->add('Manage liquidity Images', base_url().'cms/manage-liquidity');
		$this->breadcrumbcomponent->add('Edit liquidity Image', base_url().'cms/manage-liquidity/edit-image/'.$page_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Fetching Image liquidity Results
		$get_liquidity_image = $this->mod_cms->get_liquidity_image($image_id);
		
		
		$data['liquidity_image_data'] = $get_liquidity_image['liquidity_image_arr'];
		$data['liquidity_image_count'] = $get_liquidity_image['liquidity_image_count'];
		
		if($get_liquidity_image['liquidity_image_count'] == 0) redirect(base_url());
		
		$this->load->view('cms/edit_image',$data);	
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

	//Updating Image liquidity
	$upd_liquidity_image = $this->mod_cms->edit_image($this->input->post());
	
	if($upd_liquidity_image && $upd_liquidity_image['error'] == ''){	
		
		$this->session->set_flashdata('ok_message', '- liquidity image updated successfully.');
		redirect(base_url().'cms/manage-liquidity/edit-image/'.$image_id);
		
	}else{

		if($upd_liquidity_image['error'] != ''){

			$this->session->set_flashdata('err_message', '- '.strip_tags($upd_liquidity_image['error']));
			redirect(base_url().'cms/manage-liquidity/edit-image/'.$image_id);
			
		}else{
			
			$this->session->set_flashdata('err_message', '- liquidity image is not updated. Something went wrong, please try again.');
			redirect(base_url().'cms/manage-liquidity/edit-image/'.$image_id);

		}//end if($add_liquidity_image['error'] != '')
		
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
		$del_liquidity_image = $this->mod_cms->delete_image($image_id);
		
		if($del_liquidity_image){
			
			$this->session->set_flashdata('ok_message', '- liquidity Image deleted successfully.');
			redirect(base_url().'cms/manage-liquidity');
			
		}else{
			$this->session->set_flashdata('err_message', '- liquidity Image cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'cms/manage-liquidity');
			
		}//end if($add_cms_page)

	}//end delete_page
	
	public function manage_title()
	{
		//echo 'i am cms/manage_liquidity/manage_title()';
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
		$this->breadcrumbcomponent->add('Manage Liquidity Images', base_url().'cms/manage-liquidity');
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
		$this->load->view('cms/manage_liquidity_title',$data);
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
}//end Dashboard 
