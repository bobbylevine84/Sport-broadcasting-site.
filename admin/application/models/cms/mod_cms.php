<?php
class mod_cms extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Get All CMS pages.
	public function get_all_cms_pages(){
		
		$this->db->dbprefix('pages');
		$this->db->order_by('id DESC');
		$get_cms_pages = $this->db->get('pages');

		//echo $this->db->last_query();
		$row_cms['cms_pages_arr'] = $get_cms_pages->result_array();
		$row_cms['cms_pages_count'] = $get_cms_pages->num_rows;
		return $row_cms;
		
	}//end get_all_cms_pages

	//Get CMS Page Record
	public function get_cms_page($page_id){
		
		$this->db->dbprefix('pages');
		$this->db->where('id',$page_id);
		$get_cms_page = $this->db->get('pages');

		//echo $this->db->last_query();
		$row_cms['cms_page_arr'] = $get_cms_page->row_array();
		$row_cms['cms_page_count'] = $get_cms_page->num_rows;
		return $row_cms;
		
	}//end get_all_cms_pages
	
	//Add New Page
	public function add_new_page($data){
		
		extract($data);
		$generate_seo_url = $this->mod_common->generate_seo_url($page_title);
		$verified_seo_url = $this->mod_common->verify_seo_url($generate_seo_url,'pages','seo_url_name',0);
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');

		$ins_data = array(
		   'page_title' => $this->db->escape_str(trim($page_title)),
		   'menu_id' => $this->db->escape_str(trim($menu_id)),
		   'page_short_desc' => $this->db->escape_str(trim($page_short_desc)),
		   'page_long_desc' => str_replace('\n','',$this->db->escape_str(trim($page_long_desc))),
		   'meta_title' => $this->db->escape_str(trim($meta_title)),
		   'meta_keywords' => $this->db->escape_str(trim($meta_keywords)),
		   'meta_description' => $this->db->escape_str(trim($meta_description)) ,
		   'status' => $this->db->escape_str(trim($status)),
		   'seo_url_name' => $this->db->escape_str(trim($verified_seo_url)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		);

		//Insert the record into the database.
		$this->db->dbprefix('pages');
		$ins_into_db = $this->db->insert('pages', $ins_data);
		//echo $this->db->last_query();
		
		if($ins_into_db) return true;

	}//end add_new_page()
	
	//Edit Page
	public function edit_new_page($data){
		
		extract($data);
		$generate_seo_url = $this->mod_common->generate_seo_url(trim($page_title));
		$verified_seo_url = $this->mod_common->verify_seo_url($generate_seo_url,'pages','seo_url_name',$page_id);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'page_title' => $this->db->escape_str(trim($page_title)),
		   'menu_id' => $this->db->escape_str(trim($menu_id)),
		   'page_short_desc' => $this->db->escape_str(trim($page_short_desc)),
		   'page_long_desc' => str_replace('nn','',str_replace('\n','',$this->db->escape_str(trim($page_long_desc)))),
		   'meta_title' => $this->db->escape_str(trim($meta_title)),
		   'meta_keywords' => $this->db->escape_str(trim($meta_keywords)),
		   'meta_description' => $this->db->escape_str(trim($meta_description)) ,
		   'status' => $this->db->escape_str(trim($status)),
		   'seo_url_name' => $this->db->escape_str(trim($verified_seo_url)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('pages');
		$this->db->where('id',$page_id);
		$upd_into_db = $this->db->update('pages', $upd_data);
		//echo $this->db->last_query();exit;
		
		if($upd_into_db) return true;

	}//end edit_new_page()

	//Delete Page
	public function delete_page($page_id){
		
		//Delete the record from the database.
		$this->db->dbprefix('pages');
		$this->db->where('id',$page_id);
		$del_into_db = $this->db->delete('pages');
		//$this->db->last_query();
		
		if($del_into_db) return true;

	}//end delete_page()
	
	
	public function get_content()
	{
		$get_content = $this->db->get('');
		return $get_content->result_array();
	}
	/////////uses for liquidity section ////////////////////////////
	
	//Get All images of liquidity page.
	public function get_all_liquidity_images()
	{
		$this->db->dbprefix('liquidity_images');
		$this->db->order_by('id DESC');
		$get_liquidity_images = $this->db->get('liquidity_images');

//echo $this->db->last_query();
		$row_liquidity_images['liquidity_images_arr'] = $get_liquidity_images->result_array();
		$row_liquidity_images['liquidity_images_count'] = $get_liquidity_images->num_rows;
		return $row_liquidity_images;
		
	}//end get_all_liquidity_images
	// start get_all_partners_images
	public function get_all_partners_images()
	{
		//$this->db->dbprefix('liquidity_images');
		$this->db->order_by('id DESC');
		$get_liquidity_images = $this->db->get('kt_partner_images');

//echo $this->db->last_query();
		$row_liquidity_images['partners_images_arr'] = $get_liquidity_images->result_array();
		$row_liquidity_images['partners_images_count'] = $get_liquidity_images->num_rows;
		return $row_liquidity_images;
		
	}//end get_all_partners_images
	
	//Get Image liquidity Record
	public function get_liquidity_image($image_id)
	{
		$this->db->dbprefix('liquidity_images');
		$this->db->where('id',$image_id);
		$get_liquidity_image = $this->db->get('liquidity_images');

		//echo $this->db->last_query(); exit;
		$row_liquidity_image['liquidity_image_arr'] = $get_liquidity_image->row_array();
		$row_liquidity_image['liquidity_image_count'] = $get_liquidity_image->num_rows;
		return $row_liquidity_image;
		
	}//end get_all_liquidity_images
	public function get_partners_image($image_id)
	{
		//$this->db->dbprefix('liquidity_images');
		$this->db->where('id',$image_id);
		$get_liquidity_image = $this->db->get('kt_partner_images');

		//echo $this->db->last_query(); exit;
		$row_partners_image['partners_image_arr'] = $get_liquidity_image->row_array();
		$row_partners_image['partners_image_count'] = $get_liquidity_image->num_rows;
		return $row_partners_image;
		
	}
	//Add New image logo for liquidity
	public function add_new_image($data){
		
		extract($data);
		
		//Uploading liquidity Imaage
		if($_FILES['liquidity_image']['name'] != ''){

			//Create User Directory if not exist
			//$liquidity_folder_path = '../assets/liquidity.images';
			$liquidity_folder_path = '../uploads/liquidity/';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['liquidity_image']['name'],'.')),'.'); 			
			$file_name = 	'liquidity-'.date('YmdGis').'.jpg';

			$config['upload_path'] = $liquidity_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('liquidity_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 800 * 600
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $liquidity_folder_path.'/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 350;
				$config_profile['height'] = 200;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();

				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image 
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $liquidity_folder_path.'/'.$file_name;
				$config_profile['new_image'] = $liquidity_folder_path.'/thumb/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 230;
				$config_profile['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
			}//end if(!$this->upload->do_upload('prof_image'))


		}//end if($_FILES['liquidity_image']['name'] != '')
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');

		$ins_data = array(
		   'liquidity_image' => $this->db->escape_str(trim($file_name)),
		   'liquidity_caption' => $this->db->escape_str(trim($liquidity_caption)),
		   /*'liquidity_content' => $this->db->escape_str(trim($liquidity_content)),*/
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		);

		//Insert the record into the database.
		$this->db->dbprefix('liquidity_images');
		$ins_into_db = $this->db->insert('liquidity_images', $ins_data);
		//echo $this->db->last_query();
		
		if($ins_into_db) return true;

	}//end add_new_page()
	public function add_new_image_partners($data){
		
		extract($data);
		
		//Uploading partners Imaage
		if($_FILES['partners_image']['name'] != ''){

			//Create User Directory if not exist
			//$partners_folder_path = '../assets/partners.images';
			$partners_folder_path = '../uploads/liquidity/';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['partners_image']['name'],'.')),'.'); 			
			$file_name = 	'partners-'.date('YmdGis').'.jpg';

			$config['upload_path'] = $partners_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('partners_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 800 * 600
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $partners_folder_path.'/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 350;
				$config_profile['height'] = 200;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();

				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image 
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $partners_folder_path.'/'.$file_name;
				$config_profile['new_image'] = $partners_folder_path.'/thumb/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 230;
				$config_profile['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
			}//end if(!$this->upload->do_upload('prof_image'))


		}//end if($_FILES['partners_image']['name'] != '')
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');

		$ins_data = array(
		   'partners_image' => $this->db->escape_str(trim($file_name)),
		   'partners_caption' => $this->db->escape_str(trim($partners_caption)),
		   /*'partners_content' => $this->db->escape_str(trim($partners_content)),*/
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		);

		//Insert the record into the database.
		//$this->db->dbprefix('partners_images');
		$ins_into_db = $this->db->insert('kt_partner_images', $ins_data);
		//echo $this->db->last_query();
		
		if($ins_into_db) return true;

	}//end add_new_page()
	
	
	//Edit Page
	public function edit_image($data){
		
		extract($data);
		
		$get_image_data = $this->mod_cms->get_liquidity_image($image_id);
		$get_image_data_arr = $get_image_data['liquidity_image_arr'];
		
		$old_file_name = $get_image_data_arr['liquidity_image'];
		
		//Uploading liquidity Imaage
		if($_FILES['liquidity_image']['name'] != ''){

			//Create User Directory if not exist
			$liquidity_folder_path = '../uploads/liquidity/';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['liquidity_image']['name'],'.')),'.'); 			
			$file_name = 	'liquidity-'.date('YmdGis').'.jpg';

			$config['upload_path'] = $liquidity_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('liquidity_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 1600 * 450
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $liquidity_folder_path.'/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 1600;
				$config_profile['height'] = 450;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();

				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image 
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $liquidity_folder_path.'/'.$file_name;
				$config_profile['new_image'] = $liquidity_folder_path.'/thumb/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 230;
				$config_profile['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
			}//end if(!$this->upload->do_upload('prof_image'))

			//Delete Existing Image
			if(file_exists($liquidity_folder_path.'/'.$old_file_name)){
				
				unlink($liquidity_folder_path.'/'.$old_file_name);
				unlink($liquidity_folder_path.'/thumb/'.$old_file_name);
			}

		}else{
			$file_name = $old_file_name;	
		}//end if($_FILES['liquidity_image']['name'] != '')
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'liquidity_image' => $this->db->escape_str(trim($file_name)),
		   'liquidity_caption' => $this->db->escape_str(trim($liquidity_caption)),
		   'liquidity_content' => $this->db->escape_str(trim($liquidity_content)),
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('liquidity_images');
		$this->db->where('id',$image_id);
		$upd_into_db = $this->db->update('liquidity_images', $upd_data);
		//echo $this->db->last_query();exit;
		
		if($upd_into_db) return true;

	}//end edit_new_page()
	
	public function edit_image_partners($data){
		
		extract($data);
		
		$get_image_data = $this->mod_cms->get_partners_image($image_id);
		$get_image_data_arr = $get_image_data['partners_image_arr'];
		
		$old_file_name = $get_image_data_arr['partners_image'];
		
		//Uploading partners Imaage
		if($_FILES['partners_image']['name'] != ''){

			//Create User Directory if not exist
			$liquidity_folder_path = '../uploads/liquidity/';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['partners_image']['name'],'.')),'.'); 			
			$file_name = 	'partners-'.date('YmdGis').'.jpg';

			$config['upload_path'] = $liquidity_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('partners_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 1600 * 450
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $liquidity_folder_path.'/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 1600;
				$config_profile['height'] = 450;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();

				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image 
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $liquidity_folder_path.'/'.$file_name;
				$config_profile['new_image'] = $liquidity_folder_path.'/thumb/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 230;
				$config_profile['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
			}//end if(!$this->upload->do_upload('prof_image'))

			//Delete Existing Image
			if(file_exists($partners_folder_path.'/'.$old_file_name)){
				
				unlink($liquidity_folder_path.'/'.$old_file_name);
				unlink($liquidity_folder_path.'/thumb/'.$old_file_name);
			}

		}else{
			$file_name = $old_file_name;	
		}//end if($_FILES['partners_image']['name'] != '')
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'partners_image' => $this->db->escape_str(trim($file_name)),
		   //'partners_caption' => $this->db->escape_str(trim($partners_caption)),
		  // 'partners_content' => $this->db->escape_str(trim($partners_content)),
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		//$this->db->dbprefix('partners_images');
		$this->db->where('id',$image_id);
		$upd_into_db = $this->db->update('kt_partner_images', $upd_data);
		//echo $this->db->last_query();exit;
		
		if($upd_into_db) return true;

	}
	
	//Delete Image
	public function delete_image($image_id)
	{
		$get_image_data = $this->mod_cms->get_liquidity_image($image_id);
		$get_image_data_arr = $get_image_data['liquidity_image_arr'];
		
		//Create User Directory if not exist
		$liquidity_folder_path = '../resources/liquidity.images';

		$old_file_name = $get_image_data_arr['liquidity_image'];

		//Delete Existing Image
		if(file_exists($liquidity_folder_path.'/'.$old_file_name)){
			
			unlink($liquidity_folder_path.'/'.$old_file_name);
			unlink($liquidity_folder_path.'/thumb/'.$old_file_name);
		}//end if
		
		//Delete the record from the database.
		$this->db->dbprefix('liquidity_images');
		$this->db->where('id',$image_id);
		$del_into_db = $this->db->delete('liquidity_images');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_page()
	

public function delete_image_parteners($image_id)
	{
		$get_image_data = $this->mod_cms->get_liquidity_image($image_id);
		$get_image_data_arr = $get_image_data['liquidity_image_arr'];
		
		//Create User Directory if not exist
		$liquidity_folder_path = '../resources/liquidity.images';

		$old_file_name = $get_image_data_arr['liquidity_image'];

		//Delete Existing Image
		if(file_exists($liquidity_folder_path.'/'.$old_file_name)){
			
			unlink($liquidity_folder_path.'/'.$old_file_name);
			unlink($liquidity_folder_path.'/thumb/'.$old_file_name);
		}//end if
		
		//Delete the record from the database.
		//$this->db->dbprefix('liquidity_images');
		$this->db->where('id',$image_id);
		$del_into_db = $this->db->delete('kt_partner_images');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_page()
	


}
?>