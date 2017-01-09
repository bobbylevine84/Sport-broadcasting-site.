<?php

class mod_product extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Get All CMS pages.
	public function get_all_slider_images(){
		
		$this->db->dbprefix('slider_images');
		$this->db->order_by('id DESC');
		$get_slider_images = $this->db->get('slider_images');

		//echo $this->db->last_query();
		$row_slider_images['slider_images_arr'] = $get_slider_images->result_array();
		$row_slider_images['slider_images_count'] = $get_slider_images->num_rows;
		return $row_slider_images;
		
	}//end get_all_slider_images

	//Get Image Slider Record
	/////////////////////////////mutipac//////////////////
	public function get_all_products(){
		$this->db->order_by("p_id", "DESC"); 
        $this->db->select('kt_products.*, kt_product_type.*,kt_brand.*');
        $this->db->from('kt_products');
        $this->db->join('kt_product_type', 'kt_product_type.id = kt_products.product_type_id');
        $this->db->join('kt_brand', 'kt_brand.br_id = kt_products.brand_id');
        $query = $this->db->get();


		//echo $this->db->last_query();
		$get_product['product_array'] = $query->result_array();
		$get_product['product_count'] = $query->num_rows;
		return $get_product;
		
	}
	public function get_product_by_id($id)
	{
		$this->db->where("kt_products.p_id", $id);
        $this->db->select('kt_products.*, kt_flavour.*, kt_product_type.*, kt_brand.*, kt_flavour_map.*');
        $this->db->from('kt_products');
		$this->db->join('kt_product_type', 'kt_product_type.id = kt_products.product_type_id');
		$this->db->join('kt_brand', 'kt_brand.br_id = kt_products.brand_id');
		$this->db->join('kt_flavour_map', 'kt_flavour_map.pr_id = kt_products.p_id');
		$this->db->join('kt_flavour', 'kt_flavour.f_id = kt_flavour_map.fl_id');
        $query = $this->db->get();
		return $query->result_array();
	}
	public function delete_product($id)
	{
		$this->db->dbprefix('kt_products');
		$this->db->where('p_id',$id);
		$del_into_db = $this->db->delete('kt_products');
		return $del_into_db;
	}
	public function delete_product_flav_map($id)
	{
		$this->db->dbprefix('kt_flavour_map');
		$this->db->where('pr_id',$id);
		$del_into_db = $this->db->delete('kt_flavour_map');
		return $del_into_db;
	}
		function add_new_brand($brand)
		{
			$data=array(
			'brand_name' => $brand);
			$res=$this->db->insert('kt_brand',$data);
			return $res;
		}
		function add_new_flavour($flavour,$image)
		{
			$data=array(
			'flavour_name' => $flavour,
			'flavour_image'  => $image
			);
			$this->db->insert('kt_flavour',$data);
			$res=$this->db->insert_id();
			$this->db->where('f_id',$res);
			$res=$this->db->get('kt_flavour');
			return $res->result_array();
		}
			function add_new_product_type($product_type)
		{
			$data=array(
			'product_type' => $product_type);
			$res=$this->db->insert('kt_product_type',$data);
			return $res;
		}
			function add_product($ins_data)
		{
			$this->db->insert('kt_products',$ins_data);
			return $this->db->insert_id();
		}
			function update_product($id,$ins_data)
		{
			$this->db->dbprefix('kt_products');
			$this->db->where("p_id", $id);
			$res=$this->db->update('kt_products',$ins_data);
			return $res;
		}
			function add_flav_map($ins_data)
		{
			$res=$this->db->insert('kt_flavour_map',$ins_data);
			return $res;
		}
			function delete_flav_map($id)
		{
			$this->db->where("pr_id", $id);
			$res=$this->db->delete('kt_flavour_map');
			return $res;
		}
		
	    function get_brands_name($q) {
        $this->db->select('brand_name,br_id');
        $this->db->like('brand_name', $q);
        $query = $this->db->get('kt_brand');
		$i=0;
        foreach ($query->result_array() as $row) {
			
            $row_set[$i]['label'] = htmlentities(stripslashes($row['brand_name']));
			$row_set[$i]['id'] = htmlentities(stripslashes($row['br_id']));
			$i++;
        }
		if($row_set == NULl)
		{
			$i=0;
			$row_set[$i]['label'] = 'Add More';
			$row_set[$i]['id'] = -1;
		}
        echo json_encode($row_set);
    }
	    function get_flavor($q) {
        $this->db->select('flavour_name,f_id,flavour_image');
        $this->db->like('flavour_name', $q);
        $query = $this->db->get('kt_flavour');
		$i=0;
        foreach ($query->result_array() as $row) {
			$row_set[$i]['label'] = htmlentities(stripslashes($row['flavour_name']));
			$row_set[$i]['icon'] = htmlentities(stripslashes($row['flavour_image']));
			$row_set[$i]['id'] = htmlentities(stripslashes($row['f_id']));
			$i++;
        }
		if($row_set == NULl)
		{
			$i=0;
			$row_set[$i]['label'] = 'Add More';
			$row_set[$i]['id'] = -1;
		}
        echo json_encode($row_set);
    }
	function get_brands_type($q) {
        $this->db->select('product_type');
        $this->db->like('product_type', $q);
        $query = $this->db->get('kt_product_type');
		$i=0;
        foreach ($query->result_array() as $row) {
            $row_set[$i]['label'] = htmlentities(stripslashes($row['product_type']));
			$row_set[$i]['id'] = htmlentities(stripslashes($row['id']));
			$i++;
        }
		if($row_set == NULl)
		{
			$i=0;
			$row_set[$i]['label'] = 'Add More';
			$row_set[$i]['id'] = -1;
		}
        echo json_encode($row_set);
    }
	    function get_brand_id($q) {
        $this->db->select('br_id');
        $this->db->where('brand_name', $q);
        $query = $this->db->get('kt_brand')->row_array();
		return $query;
    }
		function get_flavour_id($q) {
        $this->db->select('*');
        $this->db->where('flavour_name', $q);
        $query = $this->db->get('kt_flavour')->row_array();
		return $query;
    }
			function get_flavour_image_name($q) {
        $this->db->select('f_id');
        $this->db->where('flavour_image', $q);
        $query = $this->db->get('kt_flavour')->row_array();
		return $query;
    }
	  function get_product_type_id($q) {
        $this->db->select('id');
        $this->db->where('product_type', $q);
        $query = $this->db->get('kt_product_type')->row_array();
		return $query;
    }
	////////////////multipac end//////////////////////
	public function get_slider_image($image_id){
		
		$this->db->dbprefix('slider_images');
		$this->db->where('id',$image_id);
		$get_slider_image = $this->db->get('slider_images');

		//echo $this->db->last_query(); exit;
		$row_slider_image['slider_image_arr'] = $get_slider_image->row_array();
		$row_slider_image['slider_image_count'] = $get_slider_image->num_rows;
		return $row_slider_image;
		
	}//end get_all_slider_images
	
	//Add New Page
	public function add_new_image($data){
		
		extract($data);
		
		//Uploading Slider Imaage
		if($_FILES['slider_image']['name'] != ''){

			//Create User Directory if not exist
			//$slider_folder_path = '../assets/slider.images';
			$slider_folder_path = '../uploads/slideshow/';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['slider_image']['name'],'.')),'.'); 			
			$file_name = 	'slider-'.date('YmdGis').'.jpg';

			$config['upload_path'] = $slider_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '6000';
			$config['max_width'] = '2000';
            $config['max_height'] = '1200';
			$config['min_width'] = '1400';
            $config['min_height'] = '300';
			//$config['max_width'] = '1600';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('slider_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 800 * 600
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $slider_folder_path.'/'.$file_name;
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
				$config_profile['source_image'] = $slider_folder_path.'/'.$file_name;
				$config_profile['new_image'] = $slider_folder_path.'/thumb/'.$file_name;
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


		}//end if($_FILES['slider_image']['name'] != '')
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		
$slide_con = str_replace('nn','',$this->input->post('slider_content'));
		$ins_data = array(
		   'slider_image' => $this->db->escape_str(trim($file_name)),
		   'slider_button_text' => $this->db->escape_str(trim($button_text)),
		   'slider_caption' => $this->db->escape_str(trim($slider_caption)),
		   'slider_content' => $this->db->escape_str(trim($slide_con)),
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		);

		
		//Insert the record into the database.
		$this->db->dbprefix('slider_images');
		$ins_into_db = $this->db->insert('slider_images', $ins_data);
		//echo $this->db->last_query();
		
		if($ins_into_db) return true;

	}//end add_new_page()
	
	//Edit Page
	public function edit_image($data){
		
		extract($data);
		
		$get_image_data = $this->mod_slider->get_slider_image($image_id);
		$get_image_data_arr = $get_image_data['slider_image_arr'];
		
		$old_file_name = $get_image_data_arr['slider_image'];
		
		//Uploading Slider Imaage
		if($_FILES['slider_image']['name'] != ''){

			//Create User Directory if not exist
			$slider_folder_path = '../uploads/slideshow/';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['slider_image']['name'],'.')),'.'); 			
			$file_name = 	'slider-'.date('YmdGis').'.jpg';

			$config['upload_path'] = $slider_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '6000';
			$config['max_width'] = '1600';
            $config['max_height'] = '450';
			$config['min_width'] = '1400';
            $config['min_height'] = '300';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
			
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('slider_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 1600 * 450
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $slider_folder_path.'/'.$file_name;
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
				$config_profile['source_image'] = $slider_folder_path.'/'.$file_name;
				$config_profile['new_image'] = $slider_folder_path.'/thumb/'.$file_name;
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
			if(file_exists($slider_folder_path.'/'.$old_file_name)){
				
				unlink($slider_folder_path.'/'.$old_file_name);
				//unlink($slider_folder_path.'/thumb/'.$old_file_name);
			}

		}else{
			$file_name = $old_file_name;	
		}//end if($_FILES['slider_image']['name'] != '')
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'slider_image' => $this->db->escape_str(trim($file_name)),
		   'slider_button_text' => $this->db->escape_str(trim($button_text)),
		   'slider_caption' => $this->db->escape_str(trim($slider_caption)),
		   'slider_content' => str_replace('\n','',$this->db->escape_str(trim($slider_content))),
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('slider_images');
		$this->db->where('id',$image_id);
		$upd_into_db = $this->db->update('slider_images', $upd_data);
		//echo $this->db->last_query();exit;
		
		if($upd_into_db) return true;

	}//end edit_new_page()

	//Delete Image
	public function delete_image($image_id){


		$get_image_data = $this->mod_slider->get_slider_image($image_id);
		$get_image_data_arr = $get_image_data['slider_image_arr'];
		
		//Create User Directory if not exist
		$slider_folder_path = '../assets/slider.images';

		$old_file_name = $get_image_data_arr['slider_image'];

		//Delete Existing Image
		if(file_exists($slider_folder_path.'/'.$old_file_name)){
			
			unlink($slider_folder_path.'/'.$old_file_name);
			unlink($slider_folder_path.'/thumb/'.$old_file_name);
		}//end if
		
		//Delete the record from the database.
		$this->db->dbprefix('slider_images');
		$this->db->where('id',$image_id);
		$del_into_db = $this->db->delete('slider_images');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_page()
	public function get_slider_caption()
	{
		return $this->db->get('kt_slide_cap')->result();
	}
	public function update_caption()
	{
		$data = array(
			'title' => $this->input->post('slider_caption'),
    		'content' => $this->input->post('slider_content'),
    		'readmore' => $this->input->post('caption_readmore')	
		);	
		/*echo '<pre>';
		print_r($data);
		exit;*/
		
		$this->db->update('kt_slide_cap',$data);
	}

}
?>