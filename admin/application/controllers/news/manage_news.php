<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_news extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		//$this->load->model('sponsor/mod_sponsor');
		$this->load->model('common/mod_common');
		$this->load->model('news/mod_news');
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
		$this->breadcrumbcomponent->add('Manage news', base_url().'news/manage-news');
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
		$get_news = $this->mod_news->get_all_news();
		//echo "<pre>";print_r($get_games_images);exit;

		$data['news_arr'] = $get_news['news_arr'];
		$data['news_count'] = $get_news['news_count'];

		
		$this->load->view('news/manage_news',$data);
	}//end index()
	
	public function add_new_news(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(91,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage news', base_url().'news/manage-news');
		$this->breadcrumbcomponent->add('Add New news', base_url().'news/manage-news/add-new-news');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view("news/add_new_news",$data);
		
	}
	public function add_new_news_process(){
		
			$title = $this->input->post("title");
            $description = $this->input->post("description");
            	$keywords = $this->input->post("keywords");
					$content = $this->input->post("content");
			if($_FILES['upload']['name'] != '')
			{
				$file_name=$this->upload_it('upload');
				//print_r($file_name);exit;
			}
			else
			{
				$file_name="";
			}
            $status = $this->input->post("status");
			
			$slug = $this->mod_news->news_slug_generator($title);

            $insert_array = array(
                "title" => $title,
                "content" => $content,
                "description" => $description,
                "image" => $file_name,
                "status" => $status,
                "slug_news" => $slug,
                "keywords" => $keywords,
                "created_date" => date("Y-m-d H:i:s")
            );
			
            $query = $this->db->insert("kt_news", $insert_array);
            if ($query) {
                    $this->session->set_flashdata('message', 'Successful');
                    redirect('news/manage_news');
                    $this->session->set_flashdata('error', 'Something went wrong, please try again later');
                    redirect('');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, please try again later');
                redirect('');
            }
            redirect('news/manage_news');
        

	}//end add_page_process
	public function edit_news($news_id){
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
		$this->breadcrumbcomponent->add('Manage news', base_url().'news/manage_news');
		$this->breadcrumbcomponent->add('Edit news', base_url().'news/manage_news/edit_news/'.$partners_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		//echo "<pre>"; print_r($data['games_data']);exit;
		//Fetching partners Results
		$data['get_news'] = $this->mod_news->get_news($news_id);
	//	echo "<pre>"; print_r($data['get_games_image']);exit;
	
		$data['news_data'] = $data['get_news']['news_arr'];
		//echo "<pre>"; print_r($data['games_data']);exit;
		$data['news_count'] = $data['get_news']['news_count'];
		//echo "<pre>"; print_r($data['games_count']);exit;
		if($data['get_news']['news_count'] == 0) redirect(base_url().'news/manage_news/');
		
		$this->load->view('news/edit_news',$data);
		
	}//edit_sponsor

	public function edit_news_process(){
		
			$news_id=$this->input->post('news_id'); 
			$title = $this->input->post("title");
			$keywords = $this->input->post("keywords");
			$description = $this->input->post("description");
			$content = $this->input->post("content");
			if($_FILES['upload']['name'] != '')
			{
				$file_name=$this->upload_it('upload');
				//print_r($file_name);exit;
			}
			else
			{
				$file_name="";
			}
			$status = $this->input->post("status"); 
				if($file_name ==''){ 
				$update_array = array(
				"title" => $title,
				"description" => $description,
				"status" => $status,
				"content" => $content,
				"keywords" => $keywords

				);
				}else{
				$update_array = array(
				"title" => $title,
				"description" => $description,
				'image'=>$file_name,
				"status" => $status,
				"content" => $content,
				"keywords" => $keywords
				);
				}
				$this->db->where("id", $news_id);
				$query_update = $this->db->update("kt_news",$update_array);
				if ($query_update) 
				{	
					$this->session->set_flashdata('message', 'News successfully updated.' );
					redirect('news/manage_news');			
				}
				else
				{	
					$this->session->set_flashdata('error', 'Something went wrong, please try again' );
					redirect('news/manage_news');
				}

	}
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
	public function delete_news($news_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(91,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if
		
		//If Post is not SET
		if(!isset($news_id)) redirect(base_url());
		
		//Updating Page
		$del_news = $this->mod_news->delete_news($news_id);
		
		if($del_news){
			
			$this->session->set_flashdata('ok_message', '- News deleted successfully.');
			redirect(base_url().'news/manage_news');
			
		}else{
			$this->session->set_flashdata('err_message', '- News cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'news/manage_news');
			
		}//end if

	}//end delete_page
	

}
