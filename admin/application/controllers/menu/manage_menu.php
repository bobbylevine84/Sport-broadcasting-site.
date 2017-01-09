<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Menu extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('menu/mod_menu');
		$this->load->model('common/mod_common');
		
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(10,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Menus', base_url().'menu/manage-menu');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Fetching All Menus Results
		
		$menus_count = $this->mod_menu->get_all_menus_count();
		$data['menu_list_count'] = $menus_count;
		
		$this->load->view('menu/manage_menu',$data);
		
	}//end index()
	
	public function process_menu_grid(){
		
		echo $this->mod_menu->get_filter_menu_grid_data();
		
	}//end 
	
	//Add New menu
	public function add_new_menu(){
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(10,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Menus', base_url().'menu/manage-menu');
		$this->breadcrumbcomponent->add('Add New Menu', base_url().'menu/manage-menu/add-new-menu');
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

		$this->load->view('menu/add_new_menu',$data);
		
	}//add_new_menu

	public function add_new_menu_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_new_menu_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(10,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		$data_arr['add-new-menu-data'] = $this->input->post();
		
		
		/*echo '<pre>';
		print_r($data_arr);
		exit;
		
		[menu_name] => test1
		[parent_id] => 0
		[position_id] => Array
		(
		[0] => Footerwidget1
		)
		
		[menu_url] => 
		[display_order] => 0
		[status] => 1
		[meta_title] => 
		[meta_keywords] => 
		[meta_description] => 
		[menu_description] => 
		[seo_url_name] => 
		[add_new_menu_sbt] => Add New Menu
		)
		*/
		
		$this->session->set_userdata($data_arr);
		

		if(trim($this->input->post('menu_name')) == '')
		{
			$this->session->set_flashdata('err_message', '- Menu Name is empty.');
			redirect(base_url().'menu/manage-menu/add-new-menu');

		}//end if(trim($this->input->post('menu_name')) == '')
		

		//Check if The ctaegory name already exist against the selected Parent menu
		$check_if_menu_exist  = $this->mod_menu->check_if_menu_exist(trim($this->input->post('menu_name')),trim($this->input->post('parent_id')),0);
		//echo "<pre>";print_r($check_if_menu_exist);
		if($check_if_menu_exist > 0){
			$this->session->set_flashdata('err_message', '- Menu Name already exist in the selected Parent menu.');
			redirect(base_url().'menu/manage-menu/add-new-menu');
		}
		else
		{
			$add_new_menu = $this->mod_menu->add_new_menu($this->input->post());
			//echo $add_new_menu;exit();
			if($add_new_menu){
				
				//Unset POST values from session
				$this->session->unset_userdata('add-new-menu-data');
				
				$this->session->set_flashdata('ok_message', '- New menu added successfully.');
			
				redirect(base_url().'menu/manage-menu');
				
			}else{

				$this->session->set_flashdata('err_message', '- New menu is not added. Something went wrong, please try again.');
				redirect(base_url().'menu/manage-menu/add-new-menu');
				
			}//end if($add_new_menu)
			
		}//end if($check_if_menu_exist == 0)
		
	}//end add_new_menu_process
	
	//Edit menu
	public function edit_menu($menu_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(10,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Menus', base_url().'menu/manage-menu');
		$this->breadcrumbcomponent->add('Edit Menu', base_url().'menu/manage-menu/add-new-menu/edit-menu/'.$menu_id);
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
		
		//Get menu Data
		$get_menu_record = $this->mod_menu->get_menu($menu_id);
		$data['menu_arr'] = $get_menu_record['menu_arr'];
		$data['menu_count'] = $get_menu_record['menu_arr_count'];
		
		if($get_menu_record['menu_arr_count'] == 0) redirect(base_url().'errors/page-not-found-404');
		
		$this->load->view('menu/edit_menu',$data);
		
	}//edit_menu

	public function edit_menu_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_new_menu_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(10,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		if(trim($this->input->post('menu_name')) == ''){
			
			$this->session->set_flashdata('err_message', '- Menu Name is empty.');
			redirect(base_url().'menu/manage-menu/add-new-menu');
			
		}//end if(trim($this->input->post('menu_name')) == '')

		//Check if The ctaegory name already exist against the selected Parent menu
		$check_if_menu_exist  = $this->mod_menu->check_if_menu_exist(trim($this->input->post('menu_name')),trim($this->input->post('parent_id')),trim($this->input->post('menu_id')));
		
		if($check_if_menu_exist > 0){
			
			$this->session->set_flashdata('err_message', '- Menu Name already exist in the selected Parent menu.');
			redirect(base_url().'menu/manage-menu/add-new-menu');
			
		}else{
				
			$upd_new_menu = $this->mod_menu->edit_menu($this->input->post());
			
			if($upd_new_menu){

				$this->session->set_flashdata('ok_message', '- Menu Updated successfully.');
				redirect(base_url().'menu/manage-menu/edit-menu/'.$this->input->post('menu_id'));
				
			}else{
				$this->session->set_flashdata('err_message', '- Menu is not updated. Something went wrong, please try again.');
				redirect(base_url().'menu/manage-menu');
				
			}//end if($upd_new_menu)
			
		}//end if($check_if_menu_exist == 0)

	}//end edit_menu_process

	//Delete menu
	public function delete_menu($menu_id){
		$this->mod_menu->delete_content($menu_id);
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(10,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//If Post is not SET
		if(!isset($menu_id)) redirect(base_url());
		
		//Updating Page
		$del_menu = $this->mod_menu->delete_menu($menu_id);
		
		if($del_menu){
			
			$this->session->set_flashdata('ok_message', '- Menu deleted successfully.');
			redirect(base_url().'menu/manage-menu');
			
		}else{
			$this->session->set_flashdata('err_message', '- Menu cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'menu/manage-menu');
			
		}//end if($del_menu)

	}//end delete_menu
	#######################################################
	##													 ##			
	##													 ##
	##               edit to content pages			     ##				
	##													 ##
	##													 ##
	#######################################################
	
	public function edit_content($page_id)
	{
		
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
		$this->breadcrumbcomponent->add('Manage Menu', base_url().'menu/manage-menu');
		$this->breadcrumbcomponent->add('Edit Content', base_url().'cms/manage-pages/edit-page/'.$page_id);
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
		$get_cms_page = $this->mod_menu->get_cms_page($page_id);
		
		$data['page_data'] = $get_cms_page['cms_page_arr'];
		$data['page_data_count'] = $get_cms_page['cms_page_count'];
		
		
		if($get_cms_page['cms_page_count'] == 0) redirect(base_url());
		
		
		
		$this->load->view('cms/edit_page',$data);
		
	}
	public function edit_content_process()
	{
		$id = $this->input->post('page_id');
		/*
			[page_title] => About BlackBull
			[page_long_desc] => dafda
			[status] => 0
			[meta_title] => 
			[meta_keywords] => 
			[meta_description] => 
			[seo_url_name] => about-blackbull
			[upd_page_sbt] => Update Page
			[page_id] => 
			
			
			`page_title`, 
			`slug_menu`,
			`meta_title`, 
			`meta_keywords`, 
			`meta_description`, 
			`page_short_desc`, 
			`page_long_desc`, 
			`seo_url_name`, 
			`status`, 
			`created_by`, 
			`created_by_ip`, 
			`created_date`, 
			`last_modified_by`, 
			`last_modified_date`, 
			`last_modified_ip`
		*/
		$updated_data = array(
			'page_title' => $this->input->post('page_title'), 
			'meta_title' => $this->input->post('meta_title'), 
			'meta_keywords' => $this->input->post('meta_keywords'), 
			'meta_description' => $this->input->post('meta_description'), 
			//'page_short_desc' => $this->input->post(''), 
			'page_long_desc' => $this->input->post('page_long_desc'), 
			'seo_url_name' => $this->input->post('seo_url_name'), 
			'status' => $this->input->post('status'), 
			//'created_by' => $this->input->post(''), 
			//'created_by_ip' => $this->input->post(''), 
			//'created_date' => $this->input->post(''), 
			//'last_modified_by' => $this->session->userdata(''), 
			'last_modified_date' => date('Y-m-d') 
			//'last_modified_ip' => $this->input->post('')
		);
		
		/*echo '<pre>';
		print_r($updated_data);
		exit;*/
		$this->mod_menu->update_content($id,$updated_data);
		$this->index();		
	}
	#######################################################
	##													 ##			
	##													 ##
	##               Top header menu bar			     ##				
	##													 ##
	##													 ##
	#######################################################
	public function header_menu()
	{
		//echo 'i am header menu in managemenu class under menu directtory in admin controller';
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(25,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
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
		$this->breadcrumbcomponent->add('Header Menus', base_url().'menu/manage-menu/header-menu');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Fetching All Header Menus Results
		$data['Header_menu_list'] = $this->mod_menu->get_header_menus();
		//echo '<pre>';
		//print_r($data['Header_menu_list']); 
		$this->load->view('menu/manage_header_menu',$data);
	} 
	
	public function edit_header_menu($id=NULL)
	{
		//echo 'i am header menu in managemenu class under menu directtory in admin controller';
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(25,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
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
		$this->breadcrumbcomponent->add('Header Menus', base_url().'menu/manage-menu/header-menu');
		$this->breadcrumbcomponent->add('Edit Menu', base_url().'menu/manage-menu/header-menu');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Fetching All Header Menus Results
		$select_field = "*";
		$tablename = "kt_header_menu";
		$where_fieldname = "id";
		$where_fieldvalue = $id;
		
		$data['edit_header_menu'] = $this->mod_menu->get_data_where($select_field, $tablename, $where_fieldname, $where_fieldvalue);
		$data['top'] = $this->mod_menu->get_menu_top($id);
		$data['side'] = $this->mod_menu->get_menu_side($id);
				
		//echo '<pre>';
		//print_r($data['edit_header_menu']); 
		//exit;
		$this->load->view('menu/edit_header_menu',$data);
	}
	public function process_edit_header_menu()
	{
		//echo 'i am process of edit menu in manage_menu';
		//[menu_name] => Live Chat
    	//[menu_link] => asdfad
    	//[mode] => 1
		$id = $this->input->post('mode');
		$this->form_validation->set_rules('menu_name', 'Menu', 'required');
		$this->form_validation->set_rules('menu_link', 'Link', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			//$this->load->view('myform');
			$this->edit_header_menu($id);
			
		}
		else
		{

			$top = $this->input->post('top');
			$side = $this->input->post('side');
			$data['name'] = $this->input->post('menu_name');
    		$data['link'] = $this->input->post('menu_link');
			$data['position'] = $top.",". $side; 
			$where_fieldname = "id";
			$where_fieldvalue = $id;
			$tablename = "kt_header_menu";
			
			$this->mod_menu->update_where($where_fieldname,$where_fieldvalue,$tablename,$data);
			
			redirect("menu/manage_menu/header_menu/");
		}
		
	}
	

}//end Dashboard 
