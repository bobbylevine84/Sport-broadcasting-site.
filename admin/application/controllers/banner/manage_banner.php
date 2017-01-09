<?php
class Manage_banner extends CI_Controller
{
	public function __Construct()
	{
		parent::__Construct();
		$this->load->model('admin/mod_admin');
		
		$this->load->model('common/mod_common');
		$this->load->library('BreadcrumbComponent');
		
		$this->load->model('banner/mod_banner');
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
		$data['PLUGIN_ckeditor'] = 1;
		$data['PLUGIN_floatchart'] = 0;

		//Common Includes
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
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
		
		$data['all_banners'] = $this->mod_banner->get_all_banners();
		
		$data['banners_count'] = count($data['all_banners']);
		//echo '<pre>'; print_r($data['banners_count']); exit;

		$this->load->view('banner/manage_banner',$data);
		
	}//end index()
	
	public function add_new_banner()
	{
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
		$data['meta_title'] = Setting;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('General settings', base_url().'slider/manage-slider');
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
		
		

		$this->load->view('banner/add_banner',$data);
	}
	
	public function add_new_banner_process()
	{
		$b_field_name = 'banner_image';
		$status = $this->input->post('status');
		
		$b_image_data = $this->upload_file($b_field_name);
		if($b_image_data['upload_data'])
		{
			$data = array(
			'b_id' => $this->create_salt(8),
			'banner_name' => $b_image_data['upload_data']['file_name'],
			'status' => $status,
			'updated' => date('Y-m-d H:i:s')
			);
		
			$res = $this->mod_banner->add_banner($data);
			if($res)
			{
				$this->session->set_flashdata('ok_message','Banner Added Successfuly');
				redirect(base_url('banner/manage_banner/'));
			}
			else 
			{
				$this->session->set_flashdata('err_message','Banner cannot be added');
				redirect(base_url('banner/manage_banner/'));
			}
		}
		else
		{
			$this->session->set_flashdata('err_message', $b_image_data['msg']);
			redirect(base_url('banner/manage_banner/add_new_banner'));
		}
		
	}
	
	//make the status of the banner inactive
	public function inactive($id)
	{
		$res = $this->mod_banner->inactive_status($id);
		if($res)
		{
			$this->session->set_flashdata('ok_message','Status Inactivated Successfuly');
			redirect(base_url('banner/manage_banner/'));
		}
		else
		{
			$this->session->set_flashdata('err_message','Status cannot be inactivated');
			redirect(base_url('banner/manage_banner/'));
		}
	}
	
	//make the status of the banner active
	public function active($id)
	{
		$res = $this->mod_banner->active_status($id);
		if($res)
		{
			$this->session->set_flashdata('ok_message','Banner activated Successfuly');
			redirect(base_url('banner/manage_banner/'));
		}
		else
		{
			$this->session->set_flashdata('err_message','Banner cannot be activated');
			redirect(base_url('banner/manage_banner/'));
		}
	}
	
	public function upload_file($fieldname) {
	
		$data = NULL;
		//Configure
		//set the path where the files uploaded will be copied. NOTE if using linux, set the folder to permission 777
		$config['upload_path'] = '../uploads';
		
   	 	// set the filter image types
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		
		//$config['file_name'] = $this->image_name();
		
		//load the upload library
		$this->load->library('upload', $config);
    
    	$this->upload->initialize($config);

		$data['upload_data'] = '';
    
		//if not successful, set the error message
		if (!$this->upload->do_upload($fieldname)) {
			$data = array('msg' => $this->upload->display_errors());
			

		} else { //else, set the success message
			$data = array('msg' => "success");
      		
      		$data['upload_data'] = $this->upload->data();
		}
		return $data; 

	}
	
	public function create_salt($length = 15, $letters = '3454645GFHGDJFFGFJKDAELFDHM'){

		$s = '';

		$lettersLength = strlen($letters)-1;

		

		for($i = 0 ; $i < $length ; $i++){

			$s .= $letters[rand(0,$lettersLength)];

		}

		return $s;

	}
	
	
}

?>