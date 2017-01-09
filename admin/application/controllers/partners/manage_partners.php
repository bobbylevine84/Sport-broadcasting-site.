<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_partners extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		//$this->load->model('sponsor/mod_sponsor');
		$this->load->model('common/mod_common');
		$this->load->model('partners/mod_partners');
		//$this->load->library('image_lib');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(88,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Partners', base_url().'partners/manage_partners');
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
		$get_partners = $this->mod_partners->get_all_partners();
		//echo "<pre>";print_r($get_games_images);exit;

		$data['partners_arr'] = $get_partners['partners_arr'];
		$data['partners_count'] = $get_partners['partners_count'];

		
		$this->load->view('partners/manage_partners',$data);
	}//end index()
	
	public function add_new_partners(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(89,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Partners', base_url().'partners/manage_partners');
		$this->breadcrumbcomponent->add('Add New Partner', base_url().'partners/manage_partners/add-new-partners');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view("partners/add_new_partners",$data);
		
	}
	public function add_new_partners_process(){
			if($_FILES['upload']['name'] != '')
			{
				$file_name=$this->upload_it('upload',$admin_id);
				//print_r($file_name);exit;
			}
			else
			{
				$file_name="";
			}
			//$first_name = $this->input->post("first_name");
            //$last_name = $this->input->post("last_name");
			//$display_name = $this->input->post("display_name");
            $user_name = $this->input->post("username");
            
            $email = $this->input->post("email_address");
            $password = strip_quotes(md5(trim($this->input->post("password"))));
			
			if($this->input->post("seo") != 1){
				$admin_role = 4;
			} else {
				$admin_role = 8;
			}
			
		
			//$this->db->where('password', strip_quotes(md5(trim($password))));
			//$password = $this->tank_auth->admin_password_hash($password);
            //$password = $this->($password);
			
            //$status = $this->input->post("status");

            $insert_array = array(
               // "first_name" => $first_name,
                //"last_name" => $last_name,
                //"display_name" => $display_name,
                "username" => $user_name,
                "profile_image" => $file_name,
                "email_address" => $email,
                "password" => $password,
               // "status" => $status,
                "admin_role_id" => $admin_role,
                "is_sup_admin" => 0,
                "seo" => $this->input->post("seo"),
                "created_date" => date("Y-m-d H:i:s")
            );
			
			
            $query = $this->db->insert("kt_admin", $insert_array);
            
            if ($query) {
				$admin_id = $this->db->insert_id();
				//echo $admin_id;exit;
				$user_folder_path = './assets/user_files/'.$admin_id;
			
				if(!is_dir($user_folder_path))
				mkdir($user_folder_path);
			
				if($_FILES['upload']['name'] != '')
			{
				$file_name=$this->upload_it('upload',$admin_id);
				//print_r($file_name);exit;
			}
			else
			{
				$file_name="";
			}
			
                    $this->session->set_flashdata('message', 'Successful');
                    redirect('partners/manage_partners');
                    $this->session->set_flashdata('error', 'Something went wrong, please try again later');
                    redirect('');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, please try again later');
                redirect('');
            }
            redirect('partners/manage_partners');
	}//end add_page_process
	public function upload_it($fieldname,$admin_id){
		$data =NULL;
		$config['upload_path'] = 'assets/user_files/'.$admin_id.'/';
		$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
		$config['max_size']	= '4096';
		//$config['max_width'] = '11700';
       // $config['max_height'] = '2230';
		$this->load->library('upload', $config);
    
    	$this->upload->initialize($config);
    
    	$this->upload->set_allowed_types('*');

		$data['upload_data'] = '';
		if (!$this->upload->do_upload($fieldname)) {
			$data = array('msg' => $this->upload->display_errors());
			$this->session->set_userdata('image_error',$this->upload->display_errors());

		} else { //else, set the success message
			$this->session->unset_userdata('image_error');
			$data = array('msg' => "Upload success !");
      		$data['upload_data'] = $this->upload->data();
		}
		//print_r($data);exit;
		return $data['upload_data']['file_name']; 
	}
	public function edit_partners($partners_id){
	//echo $games_id;exit;
			//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(90,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage partners', base_url().'partners/manage_partners');
		$this->breadcrumbcomponent->add('Edit partners', base_url().'partners/manage_partners/edit_partners/'.$partners_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		//echo "<pre>"; print_r($data['games_data']);exit;
		//Fetching partners Results
		$data['get_partners'] = $this->mod_partners->get_partners($partners_id);
	//	echo "<pre>"; print_r($data['get_games_image']);exit;
	
		$data['partners_data'] = $data['get_partners']['partners_arr'];
		//echo "<pre>"; print_r($data['games_data']);exit;
		$data['partners_count'] = $data['get_partners']['partners_count'];
		//echo "<pre>"; print_r($data['games_count']);exit;
		if($data['get_partners']['partners_count'] == 0) redirect(base_url().'partners/manage_partners/');
		
		$this->load->view('partners/edit_partners',$data);
		
	}//edit_sponsor

	public function edit_partners_process(){
		
			$partners_id=$this->input->post('partners_id');
			$first_name = $this->input->post("first_name");
			$last_name = $this->input->post("last_name");
			$display_name = $this->input->post("display_name");
			if($this->input->post("seo") == ''){
				$admin_role = 4;
			} else {
				$admin_role = 8;
			}
			
			if($_FILES['upload']['name'] != '')
			{
				$file_name=$this->upload_it2('upload',$partners_id);
				//print_r($file_name);exit;
			}
			else
			{
				$file_name="";
			}
			$user_name = $this->input->post("user_name");
			$email_address = $this->input->post("email_address");  
			
			$password = strip_quotes(md5(trim($this->input->post("password")))); 
			$status = $this->input->post("status"); 
			if($this->input->post("password") ==''){
				if($file_name ==''){
				$update_array = array(
				"first_name" => $first_name,
				"last_name" => $last_name,
				"display_name" => $display_name,
				"username" => $user_name,
				"email_address" => $email_address,
				"status" => $status,
				"admin_role_id" => $admin_role,
				"seo" => $seo
				);
				} else {
				$update_array = array(
				"first_name" => $first_name,
				"last_name" => $last_name,
				"display_name" => $display_name,
				'profile_image'=>$file_name,
				"admin_role_id" => $admin_role,
				"username" => $user_name,
				"email_address" => $email_address,
				"status" => $status,
				"seo" => $seo
				);
				}

			} else {
				if($file_name ==''){ 
				$update_array = array(
				"first_name" => $first_name,
				"last_name" => $last_name,
				"display_name" => $display_name,
				"username" => $user_name,
				"admin_role_id" => $admin_role,
				"email_address" => $email_address,
				"password" => $password,
				"status" => $status,
				"seo" => $seo
				);
				}else{
				$update_array = array(
				"first_name" => $first_name,
				"last_name" => $last_name,
				"display_name" => $display_name,
				'profile_image'=>$file_name,
				"username" => $user_name,
				"admin_role_id" => $admin_role,
				"email_address" => $email_address,
				"password" => $password,
				"status" => $status,
				"seo" => $seo
				);
				}
				
			}
			
				$this->db->where("id", $partners_id);
				$query_update = $this->db->update("kt_admin",$update_array);
				if ($query_update) 
				{	
					$this->session->set_flashdata('message', 'Partner successfully updated.' );
					redirect('partners/manage_partners');			
				}
				else
				{	
					$this->session->set_flashdata('error', 'Something went wrong, please try again' );
					redirect('partners/manage_partners');
				}

	}

	public function upload_it2($fieldname,$partners_id){
		//echo $partners_id;exit;
		$data =NULL;
		$config['upload_path'] = 'assets/user_files/'.$partners_id.'/';
		$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
		$config['max_size']	= '4096';
		//$config['max_width'] = '11700';
       // $config['max_height'] = '2230';
		$this->load->library('upload', $config);
    
    	$this->upload->initialize($config);
    
    	$this->upload->set_allowed_types('*');

		$data['upload_data'] = '';
		if (!$this->upload->do_upload($fieldname)) {
			$data = array('msg' => $this->upload->display_errors());
			$this->session->set_userdata('image_error',$this->upload->display_errors());

		} else { //else, set the success message
			$this->session->unset_userdata('image_error');
			$data = array('msg' => "Upload success !");
      		$data['upload_data'] = $this->upload->data();
		}
		//print_r($data);exit;
		return $data['upload_data']['file_name']; 
	}
	public function delete_partners($partners_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(88,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if
		
		//If Post is not SET
		if(!isset($partners_id)) redirect(base_url());
		
		//Updating Page
		$del_partners = $this->mod_partners->delete_partners($partners_id);
		
		if($del_partners){
			
			$this->session->set_flashdata('ok_message', '- Partner deleted successfully.');
			redirect(base_url().'partners/manage_partners');
			
		}else{
			$this->session->set_flashdata('err_message', '- Partner cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'partners/manage_partners');
			
		}//end if

	}//end delete_page
	

}
