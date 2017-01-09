<?php
class mod_sponsor extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Get All Sponsors.
	public function get_all_sponsor(){
		
		$this->db->dbprefix('bank_sponsor');
		$this->db->order_by('id DESC');
		$get_sponsor = $this->db->get('bank_sponsor');

		//echo $this->db->last_query();
		$row_sponsor['sponsor_arr'] = $get_sponsor->result_array();
		$row_sponsor['sponsor_count'] = $get_sponsor->num_rows;
		return $row_sponsor;
		
	}//end get_all_sponsor

	//Get Image Slider Record
	public function get_sponsor($image_id){
		
		$this->db->dbprefix('bank_sponsor');
		$this->db->where('id',$image_id);
		$get_sponsor = $this->db->get('bank_sponsor');

		//echo $this->db->last_query(); exit;
		$row_sponsor['sponsor_arr'] = $get_sponsor->row_array();
		$row_sponsor['sponsor_count'] = $get_sponsor->num_rows;
		return $row_sponsor;
		
	}//end get_all_sponsors
	
	//Add New Sponsor
	public function add_new_sponsor($data){
		
		extract($data);

		//Uploading Slider Imaage
		if($_FILES['sponsor_image']['name'] != ''){

			//Create User Directory if not exist
			$sponsor_folder_path = '../assets/sponsor.images';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['sponsor_image']['name'],'.')),'.'); 			
			$file_name = 	'sponsor-'.date('YmdGis').'.jpg';

			$config['upload_path'] = $sponsor_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('sponsor_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image 
				/*
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $sponsor_folder_path.'/'.$file_name;
				$config_profile['new_image'] = $sponsor_folder_path.'/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 230;
				$config_profile['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				*/
				
			}//end if(!$this->upload->do_upload('prof_image'))


		}//end if($_FILES['sponsor_image']['name'] != '')
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');

		$ins_data = array(
		   'sponsor_bank_name' => $this->db->escape_str(trim($sponsor_bank_name)),
		   'sponsor_bank_url' => $this->db->escape_str(trim($sponsor_bank_url)),
		   'sponsor_bank_image' => $this->db->escape_str(trim($file_name)),
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		);

		//Insert the record into the database.
		$this->db->dbprefix('bank_sponsor');
		$ins_into_db = $this->db->insert('bank_sponsor', $ins_data);
		
		//echo $this->db->last_query(); exit;
		
		if($ins_into_db) return true;

	}//end add_new_page()
	
	//Edit Sponsor
	public function edit_sponsor($data){
		
		extract($data);
		
		$get_image_data = $this->mod_sponsor->get_sponsor($spons_id);
		$get_image_data_arr = $get_image_data['sponsor_arr'];
		
		$old_file_name = $get_image_data_arr['sponsor_bank_image'];
		
		//Uploading Slider Imaage
		if($_FILES['sponsor_image']['name'] != ''){

			//Create User Directory if not exist
			$sponsor_folder_path = '../assets/sponsor.images';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['sponsor_image']['name'],'.')),'.'); 			
			$file_name = 	'slider-'.date('YmdGis').'.jpg';

			$config['upload_path'] = $sponsor_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('sponsor_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
			
				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image 
				/*
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $sponsor_folder_path.'/'.$file_name;
				$config_profile['new_image'] = $sponsor_folder_path.'/thumb/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 230;
				$config_profile['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				*/
			}//end if(!$this->upload->do_upload('prof_image'))

			//Delete Existing Image
			if(file_exists($sponsor_folder_path.'/'.$old_file_name))
				unlink($sponsor_folder_path.'/'.$old_file_name);

		}else{
			$file_name = $old_file_name;	
		}//end if($_FILES['sponsor_image']['name'] != '')
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'sponsor_bank_name' => $this->db->escape_str(trim($sponsor_bank_name)),
		   'sponsor_bank_url' => $this->db->escape_str(trim($sponsor_bank_url)),
		   'sponsor_bank_image' => $this->db->escape_str(trim($file_name)),
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('bank_sponsor');
		$this->db->where('id',$spons_id);
		$upd_into_db = $this->db->update('bank_sponsor', $upd_data);
		//echo $this->db->last_query();exit;
		
		if($upd_into_db) return true;

	}//end edit_new_page()

	//Delete Sponsor
	public function delete_sponsor($spons_id){


		$get_sponsor_data = $this->mod_sponsor->get_sponsor($spons_id);
		$get_sponsor_data_arr = $get_sponsor_data['sponsor_arr'];
		
		//Create User Directory if not exist
		$sponsor_folder_path = '../assets/sponsor.images';

		$old_file_name = $get_sponsor_data_arr['sponsor_bank_image'];

		//Delete Existing Image
		if(file_exists($sponsor_folder_path.'/'.$old_file_name))
			unlink($sponsor_folder_path.'/'.$old_file_name);
		
		//Delete the record from the database.
		$this->db->dbprefix('bank_sponsor');
		$this->db->where('id',$spons_id);
		$del_into_db = $this->db->delete('bank_sponsor');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_sponsor()

}
?>