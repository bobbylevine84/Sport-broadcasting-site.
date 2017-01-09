<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_User extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('common/mod_common');
		
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(7,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage User', base_url().'cms/manage-user');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);

		//Permissions
		$data['ALLOW_user_edit'] =   (in_array(9,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(10,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		//Pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'admin/manage-user/index';
		$config['total_rows'] = $this->mod_admin->count_total_admin_users();
		$config['per_page'] = 50;
		$config['num_links'] = 10;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] = 4;
		
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		
		$config['prev_link'] = '&laquo;';

		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		
		$config['cur_tag_open'] = '<li><a href="#"><b>';
		$config['cur_tag_close'] = '</b></a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		if($page !=0) $page = ($page-1) * $config['per_page'];

		$data['page_links'] = $this->pagination->create_links();
		
		$get_admin_user = $this->mod_admin->get_admin_users_limit($page,$config["per_page"]);
		$data['admin_user_list'] = $get_admin_user['admin_list_result'];
		$data['admin_user_list_count'] = $get_admin_user['admin_list_result_count'];

		$this->load->view('admin/manage_user',$data);
			
	}//end index()
	
	//Add New User
	public function add_new_user(){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(8,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Users', base_url().'cms/manage-user');
		$this->breadcrumbcomponent->add('Add New User', base_url().'admin/manage-user/add-new-user');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Admin User Roles List
		$get_all_admin_roles = $this->mod_admin_roles->get_all_admin_roles();

		$data['admin_roles_arr'] = $get_all_admin_roles['admin_roles_result'];
		$data['admin_roles_count'] = $get_all_admin_roles['admin_roles_result_count'];
		
		
		$this->load->view('admin/add_new_user',$data);
		
	}//add_new_user

	public function add_new_user_process(){
		
		$this->load->helper(array('email', 'url'));

		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_new_user_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(8,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		$err_msg = '';

		if(trim($this->input->post('first_name')) == ''){
			
			$err_msg.= '- First Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('last_name')) == ''){
			
			$err_msg.= '- Last Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')
		
		if(trim($this->input->post('display_name')) == ''){
			
			$err_msg.= '- Display Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('username')) == ''){
			
			$err_msg.= '- Username cannot be empty.<br>';
			
		}//end if(trim($this->input->post('username')) == '')

		if(trim($this->input->post('email_address')) != '' && !(valid_email($this->input->post('email_address')))){
			
			$err_msg.= '- Please enter valid Email Address<br>';
			
		}//end if(trim($this->input->post('email_address')) == '')

		if($_FILES['prof_image']['name'] != ''){
			
			$allowed_extesntions = array('jpg','jpeg','tiff','png','gif');
			$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 
			
			if(!in_array($file_ext,$allowed_extesntions)){
				$err_msg.= '- Invalid image for your profile (Use: jpg, jpeg, gif, tiff, png)<br>';	
			}//end if
			
		}//end if($_FILES['prof_image']['name'] != '')
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'admin/manage-user/add-new-user');
			
		}//end if($err_msg !='')

		$is_username_exist = $this->mod_admin->check_if_username_exist($this->input->post('username'));
		
		if($is_username_exist){
			//Username already exist

			$data_arr['add-user-data'] = $this->input->post();
			$this->session->set_userdata($data_arr);
			
			$this->session->set_flashdata('err_message', '- Username already exist. Please try another one.');
			redirect(base_url().'admin/manage-user/add-new-user');
			
		}else{
			
			//Add New User	
			$add_new_user = $this->mod_admin->add_new_user($this->input->post());
			
			if($add_new_user && $add_new_user['error'] == ''){
				
				//Unset POST values from session
				$this->session->unset_userdata('add-user-data');
				
				$this->session->set_flashdata('ok_message', '- New User added successfully.');
				redirect(base_url().'admin/manage-user');
				
			}else{
				
				if($add_new_user['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'admin/manage-user/add-new-user-user/'.$admin_id);
					
				}else{
					$this->session->set_flashdata('err_message', '- New User cannot be added. Something went wrong, please try again.');
					redirect(base_url().'admin/manage-user/add-new-user');
					
				}//end if($add_new_user['error'] != '')
				
			}//end if($upd_admin_profile)

		}//end if($is_username_exist)

	}//end add_new_user_process

	//edit User
	public function edit_user($admin_id){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(9,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Users', base_url().'cms/manage-user');
		$this->breadcrumbcomponent->add('Edit User', base_url().'admin/manage-user/edit-user/'.$admin_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Admin User data
		$admin_user_data = $this->mod_admin->get_admin_user_data($admin_id);
		$data['admin_user_data'] = $admin_user_data['admin_user_arr'];
		$data['admin_user_count'] = $admin_user_data['admin_user_count'];
		
		//Admin User Roles List
		$get_all_admin_roles = $this->mod_admin_roles->get_all_admin_roles();

		$data['admin_roles_arr'] = $get_all_admin_roles['admin_roles_result'];
		$data['admin_roles_count'] = $get_all_admin_roles['admin_roles_result_count'];
		
		
		if($admin_user_data['admin_user_count'] == 0) redirect(base_url());
		
		$this->load->view('admin/edit_user',$data);
		
	}//edit_user

	public function edit_user_process(){
		
		$this->load->helper('email');

		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('upd_user_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(9,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		$admin_id = $this->input->post('admin_id');

		$err_msg = '';
		if(trim($this->input->post('first_name')) == ''){
			
			$err_msg.= '- First Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('last_name')) == ''){
			
			$err_msg.= '- Last Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('display_name')) == ''){
			
			$err_msg.= '- Display Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('username')) == ''){
			
			$err_msg.= '- Username cannot be empty.<br>';
			
		}//end if(trim($this->input->post('username')) == '')

		if(trim($this->input->post('email_address')) != '' && !(valid_email($this->input->post('email_address')))){
			
			$err_msg.= '- Please enter valid Email Address<br>';
			
		}//end if(trim($this->input->post('email_address')) == '')
		
		if($_FILES['prof_image']['name'] != ''){
			
			$allowed_extesntions = array('jpg','jpeg','tiff','png','gif');
			$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 
			
			if(!in_array($file_ext,$allowed_extesntions)){
				$err_msg.= '- Invalid image for your profile (Use: jpg, jpeg, gif, tiff, png)<br>';	
			}//end if
			
		}//end if($_FILES['prof_image']['name'] != '')
		
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'admin/manage-user/edit-user/'.$admin_id);
			
		}//end if($err_msg !='')

		//Updating Admin Data
		$upd_admin = $this->mod_admin->edit_user($this->input->post());
		
		if($upd_admin && $upd_admin['error'] == ''){
			
			$this->session->set_flashdata('ok_message', '- User record updated successfully.');
			redirect(base_url().'admin/manage-user/edit-user/'.$admin_id);
			
		}else{

			if($upd_admin['error'] != ''){
				
				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_admin['error']));
				redirect(base_url().'admin/manage-user/edit-user/'.$admin_id);
				
			}else{
				$this->session->set_flashdata('err_message', '- User record cannot be updated. Something went wrong, please try again.');
				redirect(base_url().'admin/manage-user/edit-user/'.$admin_id);
				
			}//end if($upd_admin['error'] != '')
			
		}//end if($add_cms_page)

	}//end edit_user_process
	
	//Delete Admin User
	public function delete_user($admin_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(10,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//If Post is not SET
		if(!isset($admin_id)) redirect(base_url());
		
		//Updating Page
		$del_admin_user = $this->mod_admin->delete_user($admin_id);
		
		if($del_admin_user){
			
			$this->session->set_flashdata('ok_message', '- User deleted successfully.');
			redirect(base_url().'admin/manage-user');
			
		}else{
			$this->session->set_flashdata('err_message', '- User cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'admin/manage-user');
			
		}//end if($del_admin_user)

	}//end delete_user


	//Edit Profile
	public function edit_profile(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(4,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Edit Profile', base_url().'admin/manage-user/edit-profile');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$admin_profile_arr = $this->mod_admin->get_admin_profile($this->session->userdata('admin_id'));
		$data['admin_profile_data'] = $admin_profile_arr['admin_profile_arr'];
		$data['admin_profile_count'] = $admin_profile_arr['admin_profile_count'];
		
		if($admin_profile_arr['admin_profile_count'] == 0) redirect(base_url());
		$this->load->view('admin/edit_profile',$data);
		
	}//edit_profile

	public function edit_profile_process(){
		
		$this->load->helper('email');

		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('upd_profile_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(4,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		

		$err_msg = '';
		if(trim($this->input->post('new_password')) == ''){
			
			$err_msg.= '- New Password cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(strlen(trim($this->input->post('new_password'))) < 6 ){
			
			$err_msg.= '- New Password must be atleast 6 characters long.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')
		

		if(trim($this->input->post('confirm_password')) != trim($this->input->post('new_password'))){
			
			$err_msg.= '- Confirm Password must match with your New Password.<br>';
			
		}//end if(trim($this->input->post('username')) == '')
		if(trim($this->input->post('display_name')) == ''){
			
			$err_msg.= '- Display Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('username')) == ''){
			
			$err_msg.= '- Username cannot be empty.<br>';
			
		}//end if(trim($this->input->post('username')) == '')

		if(trim($this->input->post('email_address')) != '' && !(valid_email($this->input->post('email_address')))){
			
			$err_msg.= '- Please enter valid Email Address<br>';
			
		}//end if(trim($this->input->post('email_address')) == '')
		
		if($_FILES['prof_image']['name'] != ''){
			
			$allowed_extesntions = array('jpg','jpeg','tiff','png','gif');
			$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 
			
			if(!in_array($file_ext,$allowed_extesntions)){
				$err_msg.= '- Invalid image for your profile (Use: jpg, jpeg, gif, tiff, png)<br>';	
			}//end if
			
		}//end if($_FILES['prof_image']['name'] != '')

		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'admin/manage-user/edit-profile');
			
		}//end if($err_msg !='')

		//Updating Admin Profile
		$upd_admin_profile = $this->mod_admin->update_admin_profile($this->input->post(),$this->session->userdata('admin_id'));

		//Updating Admin Password
		$upd_admin_password = $this->mod_admin->update_admin_password($this->input->post(),$this->session->userdata('admin_id'));
		
		if($upd_admin_profile && $upd_admin_password && $upd_admin_profile['error'] == ''){
			
			$this->session->set_flashdata('ok_message', '- Profile updated successfully.');
			redirect(base_url().'admin/manage-user/edit-profile');
			
		}else{

			if($upd_admin_profile['error'] != ''){
				
				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_admin['error']));
				redirect(base_url().'admin/manage-user/edit-profile');
				
			}else{
				
				$this->session->set_flashdata('err_message', '- Profile cannot be updated. Something went wrong, please try again.');
				redirect(base_url().'admin/manage-user/edit-profile');

			}//end if($upd_admin_profile['error'] != '')
			
		}//end if($add_cms_page)

	}//end add_page_process

	//Change Admin Password
	public function edit_password(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(5,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Change Password', base_url().'adminadmin/manage-user/edit-password');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view('admin/edit_password',$data);
		
	}//edit_password



}//end Dashboard 
