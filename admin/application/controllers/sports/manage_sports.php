<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_sports extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		//$this->load->model('sponsor/mod_sponsor');
		$this->load->model('common/mod_common');
		$this->load->model('sports/mod_sports');
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
		$this->breadcrumbcomponent->add('Manage sports', base_url().'sports/manage-sports');
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
		$get_sports_images = $this->mod_sports->get_all_sports();
		//echo "<pre>";print_r($get_sports_images);exit;

		$data['sports_arr'] = $get_sports_images['sports_arr'];
		$data['sports_count'] = $get_sports_images['sports_count'];

		
		$this->load->view('sports/manage_sports',$data);
	}//end index()
	
	public function add_new_sports(){
		
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
		$this->breadcrumbcomponent->add('Manage sports', base_url().'sports/manage-sports');
		$this->breadcrumbcomponent->add('Add New sports', base_url().'sports/manage_sports/add-new-sport');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view("sports/add_new_sports",$data);
		
	}
	public function add_new_sports_process(){
		$rss = $this->load->database('rss', TRUE);
		$sports_id = $this->input->post('sports_id');
		$name = $this->input->post('name');
		if($_FILES['upload']['name'] != '')
			{
				$file_name=$this->upload_it('upload');
				//print_r($file_name);exit;
			}
			else
			{
				$file_name="";
			}
		$status = $this->input->post('status');
		
		if($file_name == ""){
			$insert_data = array(
			'category_name' => $rss->escape_str(trim($name)),
			'slug_sport' => $rss->escape_str(trim($name)),
			'sport_status' => $status,
		);
		} else {
			$insert_data = array(
			'category_name' => $rss->escape_str(trim($name)),
		   'sport_logo' => $rss->escape_str(trim($file_name)),
		   'slug_sport' => $rss->escape_str(trim($name)),
		   'sport_status' => $status,
		);
		}
		$this->db->dbprefix = '';
		$ins_into_db = $rss->insert('rss_sport_category', $insert_data);
		if($ins_into_db){
			$this->session->set_flashdata('ok_message', 'Successful');
               redirect('sports/manage_sports');
		} else{
			$this->session->set_flashdata('err_message', 'Something went wrong');
                redirect('sports/manage_sports');
		}
		
	}//end add_page_process
	//Edit Sponsor
	public function edit_sports($sports_id){
	//echo $games_id;exit;
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
		$this->breadcrumbcomponent->add('Manage sports', base_url().'sports/manage_sports');
		$this->breadcrumbcomponent->add('Edit sports', base_url().'sports/manage_sports/edit_sports/'.$sports_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		//echo "<pre>"; print_r($data['games_data']);exit;
		//Fetching Image sports Results
		$data['get_sports_image'] = $this->mod_sports->get_sports($sports_id);
	//	echo "<pre>"; print_r($data['get_sports_image']);exit;
	
		$data['sports_data'] = $data['get_sports_image']['sports_arr'];
		//echo "<pre>"; print_r($data['games_data']);exit;
		$data['sports_count'] = $data['get_sports_image']['sports_count'];
		//echo "<pre>"; print_r($data['games_count']);exit;
		if($data['get_sports_image']['sports_count'] == 0) redirect(base_url().'sports/manage_sports/');
		
		$this->load->view('sports/edit_sports',$data);
		
	}//edit_sponsor

	public function edit_sports_process(){
		$rss = $this->load->database('rss', TRUE);
		
		$sports_id = $this->input->post('sports_id');
		$name = $this->input->post('name');
		if($_FILES['upload']['name'] != '')
			{
				$file_name=$this->upload_it('upload');
				//print_r($file_name);exit;
			}
			else
			{
				$file_name="";
			}
		$status = $this->input->post('status');
		
		if($file_name == ""){
			$upd_data = array(
			'category_name' => $rss->escape_str(trim($name)),
			'slug_sport' => $rss->escape_str(trim($name)),
			'sport_status' => $status,
		);
		} else {
			$upd_data = array(
			'category_name' => $rss->escape_str(trim($name)),
		   'sport_logo' => $rss->escape_str(trim($file_name)),
		   'slug_sport' => $rss->escape_str(trim($name)),
		   'sport_status' => $status,
		);
		}
		$rss->where('id',$sports_id);
		$upd_into_db = $rss->update('rss_sport_category', $upd_data);
		if($upd_into_db){
			$this->session->set_flashdata('ok_message', 'Successful');
               redirect('sports/manage_sports');
		} else{
			$this->session->set_flashdata('err_message', 'Something went wrong');
                redirect('sports/manage_sports');
		}

	}//end edit_testimonial_process
	public function upload_it($fieldname){
		$data =NULL;
		$config['upload_path'] = 'uploads/game_images/';
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
	public function delete_sports($sports_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(88,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if
		
		//If Post is not SET
		if(!isset($sports_id)) redirect(base_url());
		
		//Updating Page
		$del_sports_image = $this->mod_sports->delete_sports($sports_id);
		
		if($del_sports_image){
			
			$this->session->set_flashdata('ok_message', '- sports deleted successfully.');
			redirect(base_url().'sports/manage-sports');
			
		}else{
			$this->session->set_flashdata('err_message', '- sports cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'sports/manage-sports');
			
		}//end if

	}//end delete_page
	

}
