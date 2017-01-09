<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_channel extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		//$this->load->model('sponsor/mod_sponsor');
		$this->load->model('common/mod_common');
		$this->load->model('channel/mod_channel');
		//$this->load->library('image_lib');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		
		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage channel', base_url().'channel/manage-channel');
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
		$get_channel= $this->mod_channel->get_all_channel();
		$data['channel_arr'] = $get_channel['channel_arr'];
		$data['channel_count'] = $get_channel['channel_count'];
		$this->load->view('channel/manage_channel',$data);
	}//end index()

	public function add_new_highlight_rule_process(){
		
		$rule = $this->input->post('highlight_rule');
		$status = $this->input->post('status');
		
		$update_array = array(
			"highlight_rule" => $rule,
			"status" => $status
		);
		$this->db->where('id',4);
		$query = $this->db->update("kt_highlight_rule", $update_array);
		if ($query) {
				$this->session->set_flashdata('ok_message', 'Successful');
				redirect('highlight/manage_highlight/rules');
				$this->session->set_flashdata('error', 'Something went wrong, please try again later');
				redirect('');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong, please try again later');
			redirect('');
		}
		redirect('highlight/manage_highlight/rules');
		
	}
	
	public function add_new_channel(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage channel', base_url().'channel/manage_channel');
		$this->breadcrumbcomponent->add('Manage channel', base_url().'channel/manage_channel/add_new_channel');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view("channel/add_new_channel",$data);
		
	}
	public function update_highlight_status($highlight_id){
	
	//echo $highlight_id;exit;
	$update_array = array(
	"status" => 'approved'
		);			
	$this->db->where("id", $highlight_id);
	$query_update = $this->db->update("kt_highlight",$update_array);
	
	if($query_update) {
		$this->session->set_flashdata('ok_message', '- Status has been Approved.');
		redirect(base_url().'highlight/manage_highlight/');
	} else {
		$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
		redirect(base_url().'highlight/manage_highlight/');
	}
	}
	public function add_new_channel_process(){
	
		$name = $this->input->post("name");
		$description = $this->input->post("description");
		if($_FILES['upload']['name'] != '')
			{
				$file_name=$this->upload_it('upload');
				//print_r($file_name);exit;
			}
			else
			{
				$file_name="";
			}
		$main_frame = $this->input->post('main_frame');
			$insert_array = array(
			"name" => $name,
			"description" => $description,
			"logo" => $file_name,
			"main_frame" => $main_frame,
			"channel_status" => 'approved'
		);
		$query = $this->db->insert("kt_channel", $insert_array);
		$last_id = $this->db->insert_id();
		
		$iframe = $this->input->post("iframe");
		
		if($iframe){
			$i=1;
			foreach($iframe as $frame){
			if(trim($frame) != ''){
				$insert_array2 = array(
					"channel_id" => $last_id,
					"iframe_number" => $i,
					"iframe_feeds" => $frame,
				);
				$query2 = $this->db->insert('kt_channel_feeds',$insert_array2);
			}
			$i++;
		}
		}
		
		// }else{
			// $insert_array = array(
			// "channel_id" => $id,
			// "iframe_number" => "idea",
			// "iframe_feeds" => $iframe,
		// );
		// }
		// $query = $this->db->insert("kt_channel", $insert_array);
		if ($query) {
				$this->session->set_flashdata('ok_message', 'Successful');
				redirect('channel/manage_channel');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong, please try again later');
			redirect('');
		}
		redirect('channel/manage_channel');
	}//end add_page_process
	public function update_channel($channel_id){
	//echo $channel_id;exit;
			//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Channels', base_url().'channel/manage_channel');
		$this->breadcrumbcomponent->add('Edit Channels', base_url().'channel/manage_channel/edit_channel/'.$channel_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$data['get_channel'] = $this->mod_channel->get_all_channel_to_update($channel_id);
	
		$data['channel_arr'] = $data['get_channel']['channel_arr'];
		$data['channel_count'] = $data['get_channel']['channel_count'];
		
		$this->load->view('channel/edit_channel',$data);
		
	}

	public function edit_channel_process(){
			$channel_id = $this->input->post('channel_id');
			$name=$this->input->post('name'); 
			$description = $this->input->post("description");
			$main_frame = $this->input->post("main_frame");
			if($_FILES['upload']['name'] != '')
			{
				$file_name=$this->upload_it('upload');
			}
			else
			{
				$file_name="";
			}
			$status = $this->input->post("status");
				if($file_name ==''){ 
				$update_array = array(
				"name" => $name,
				"description" => $description,
				"main_frame" => $main_frame,
				"channel_status" => $status
				);
				}else{
				$update_array = array(
				"name" => $name,
				"description" => $description,
				"main_frame" => $main_frame,
				'logo'=>$file_name,
				"channel_status" => $status
				);
				}
				$this->db->where("id", $channel_id);
				$query_update = $this->db->update("kt_channel",$update_array);
				if ($query_update) 
				{	
					$this->db->where('channel_id',$channel_id);
					$delete = $this->db->delete('kt_channel_feeds');
					
					if($delete){
						$iframe = $this->input->post("iframe");
						if($iframe){
							$i=1;
							foreach($iframe as $frame){
							if(trim($frame) != ''){
								$insert_array2 = array(
									"channel_id" => $channel_id,
									"iframe_number" => $i,
									"iframe_feeds" => $frame,
								);
								$query2 = $this->db->insert('kt_channel_feeds',$insert_array2);
							}
							$i++;
						}
						}
					}
					
					$this->session->set_flashdata('ok_message', 'Channel successfully updated.' );
					redirect('channel/manage_channel');			
				}
				else
				{	
					$this->session->set_flashdata('error', 'Something went wrong, please try again' );
					redirect('channel/manage_channel');
				}

	}
	public function upload_it($fieldname){
		$data =NULL;
		$config['upload_path'] = 'uploads/game_images/';
		$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
		$config['max_size']	= '4096';
		$config['height']	= '83';
		$config['width']	= '58';
		
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
	public function delete_channel($channel_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if
		
		//If Post is not SET
		if(!isset($channel_id)) redirect(base_url());
		
		//Updating Page
		$del_channel = $this->mod_channel->delete_channel($channel_id);
		
		if($del_channel){
			
			$this->session->set_flashdata('ok_message', '- Channel deleted successfully.');
			redirect(base_url().'channel/manage_channel');
			
		}else{
			$this->session->set_flashdata('err_message', '- Channel cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'channel/manage_channel');
			
		}//end if

	}//end delete_page
	

}
