<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Product extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('products/mod_product');
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
		
		
		$this->breadcrumbcomponent->add('Manage Products', base_url().'product/manage-product');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		//echo "<pre>";print_r($data['breadcrum_data']);die;
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
		$get_product = $this->mod_product->get_all_products();

		$data['product_array'] = $get_product['product_array'];
		$data['product_count'] = $get_product['product_count'];
		$this->load->view('product/manage_product',$data);
		
	}//end index()
	
	//Add New Slider Image
	public function add_brand()
	{
		$brand=$this->input->get('brand');
		$res=$this->mod_product->add_new_brand($brand);
		if($res)
		{
			echo 1;
		}
	}
	public function add_flavor()
	{
		
		if($_FILES['c_img']['name'] != ''){
		$file_name=$this->upload_it('c_img');
		}
		if($file_name){
		$flavour=$this->input->post('flavour');
		$res=$this->mod_product->add_new_flavour($flavour,$file_name);
		if($res)
		{
			echo json_encode($res);
		}
		}
	}
	public function add_product_type()
	{
		$product_type=$this->input->get('product_type');
		$res=$this->mod_product->add_new_product_type($product_type);
		print_r($res);exit;
	}
	public function add_new_product(){
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
		$this->breadcrumbcomponent->add('Manage Product', base_url().'product/manage-product');
		$this->breadcrumbcomponent->add('Add New Product', base_url().'product/manage-product/add-new-product');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view('product/add_new_product',$data);
		
	}//add_new_page
	public function add_new_product_process(){
		$title=$this->input->post('title');		
		$description=$this->input->post('description');		
		$brand=$this->input->post('brand');		
		$product_type=$this->input->post('product_type');
		$selected_flavors=$this->input->post('selected_flavors');
		$selected_icon=$this->input->post('selected_images');
		//echo '<pre>';
		//print_r($selected_icon);
		//print_r($selected_flavors);exit;
		$brand_id=$this->mod_product->get_brand_id($brand);
		
		$product_type_id=$this->mod_product->get_product_type_id($product_type);
		  if($_FILES['upload']['name'] != '')
		{  
          $file_name=$this->upload_it('upload');
		
		}
		else
		{
			$file_name="";
		}
		$ins_data=array(
		'product_title'=>$title,
		'description'=>$description,
		'brand_id'=>$brand_id['br_id'],
		'product_type_id'=>$product_type_id['id'],
		'image'=>$file_name
		);
		$res=$this->mod_product->add_product($ins_data);
		$ins_data1=array(
		'pr_id'=>$res
		);
		foreach($selected_flavors as $flavor)
		{
		$flavour_id=$this->mod_product->get_flavour_id($flavor);
		$ins_data1['fl_id']=$flavour_id['f_id'];
		$res1=$this->mod_product->add_flav_map($ins_data1);
		}
		/*foreach($selected_flavors as $flavor)
		{
		$flavour_id=$this->mod_product->get_flavour_id($flavor);
		$ins_data['flavour']=$flavour_id['f_id'];
		foreach($selected_icon as $icon){
		$flavour_image=$this->mod_product->get_flavour_image_name($icon);
		if($flavour_image['f_id'] ==$flavour_id['f_id'] ){
		$ins_data['flavour_image']=$icon;

		$res=$this->mod_product->add_product($ins_data);
		}
		}
		
		}*/
		if($res1)
		{
			$this->session->set_flashdata('ok_message', '- Product is added successfully.');
			redirect(base_url().'product/manage-product/');
		}
		else{
			$this->session->set_flashdata('err_message', '- Product cannot be added.');
			redirect(base_url().'product/manage-product/');
		}
		
	}
	public function dalete_product($val){
		$res=$this->mod_product->delete_product($val);
		$res1=$this->mod_product->delete_product_flav_map($val);
		if($res)
		{
			$this->session->set_flashdata('ok_message', '- Product is deleted successfully.');
			redirect(base_url().'product/manage-product/');
		}
	else
	{
		$this->session->set_flashdata('err_message', '- Product cannot be deleted.');
			redirect(base_url().'product/manage-product/');
	}
	}
  public function get_brands_name() {
			 if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
           $this->mod_product->get_brands_name($q);
        }
    }
	  public function get_flavor() {
			 if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
           $this->mod_product->get_flavor($q);
        }
    }
	public function get_brands_type() {
			 if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
           $this->mod_product->get_brands_type($q);
        }
    }
public function upload_it($fieldname){
		$data =NULL;
		$config['upload_path'] = '../uploads/section/';
		$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
		$config['max_size']	= '20000';
		$config['max_width'] = '11700';
        $config['max_height'] = '2230';
		$this->load->library('upload', $config);
    
    	$this->upload->initialize($config);
    
    	$this->upload->set_allowed_types('*');

		$data['upload_data'] = '';
    
		//if not successful, set the error message
		if (!$this->upload->do_upload($fieldname)) {
			$data = array('msg' => $this->upload->display_errors());
			$this->session->set_userdata('image_error',$this->upload->display_errors());

		} else { //else, set the success message
			$this->session->unset_userdata('image_error');
			$data = array('msg' => "Upload success !");
      		$data['upload_data'] = $this->upload->data();
		}
		return $data['upload_data']['file_name']; 
	}
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
	public function edit_product($val){

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
		$this->breadcrumbcomponent->add('Manage Product', base_url().'product/manage-product');
		$this->breadcrumbcomponent->add('Edit Product', base_url().'product/manage-product/edit-product');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Fetching Image slider Results
		$get_product = $this->mod_product->get_product_by_id($val);
		//echo '<pre>';
		//print_r($get_product);exit;
		$data['product']=$get_product;
		$data['repeat'] = "";
		//$data['slider_image_data'] = $get_slider_image['slider_image_arr'];
		//$data['slider_image_count'] = $get_slider_image['slider_image_count'];
		
		//if($get_slider_image['slider_image_count'] == 0) redirect(base_url());
		
		$this->load->view('product/edit_product',$data);
		
	}//add_new_page
	public function update_product_process()
	{
		$p_id=$this->input->post('product_id');
		$title=$this->input->post('title');		
		$description=$this->input->post('description');		
		$brand=$this->input->post('brand');		
		$product_type=$this->input->post('product_type');
		$selected_flavors=$this->input->post('selected_flavors');
		$image_name=$this->input->post('upload1');
		$brand_id=$this->mod_product->get_brand_id($brand);
		$product_type_id=$this->mod_product->get_product_type_id($product_type);
		  if($_FILES['upload']['name'] != '')
		{  
          $file_name=$this->upload_it('upload');
		
		}
		else{
			$file_name=$image_name;
		}
		$upd_data=array(
		'product_title'=>$title,
		'description'=>$description,
		'brand_id'=>$brand_id['br_id'],
		'product_type_id'=>$product_type_id['id'],
		'image'=>$file_name
		);
		$res=$this->mod_product->update_product($p_id,$upd_data);
		
		$updat_data1=array(
		'pr_id'=>$p_id
		);
		$res1=$this->mod_product->delete_flav_map($p_id);
		foreach($selected_flavors as $flavor)
		{
		$flavour_id=$this->mod_product->get_flavour_id($flavor);
		$updat_data1['fl_id']=$flavour_id['f_id'];
		$res1=$this->mod_product->add_flav_map($updat_data1);
		}
			if($res1)
		{
			$this->session->set_flashdata('ok_message', '- Product is updated successfully.');
			redirect(base_url().'product/manage-product/');
		}
	else
	{
		$this->session->set_flashdata('err_message', '- Product cannot be Updated.');
			redirect(base_url().'product/manage-product/');
	}
	}
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

		//Verify if Page is Accessable
		if(!in_array(33,$this->session->userdata('permissions_arr'))){
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
	{/*
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
	}*/
	}

}//end slider  
