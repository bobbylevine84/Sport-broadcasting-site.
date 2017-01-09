<?php
class mod_sports extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }
	public function get_all_sports(){
		$rss = $this->load->database('rss', TRUE);
		$get_sports = $rss->get('rss_sport_category');
		$row_sports['sports_arr'] = $get_sports->result_array();
		$row_sports['sports_count'] = $get_sports->num_rows;
		return $row_sports;
		
	}

	//Get Image Slider Record
	public function get_sports($image_id){
		$rss = $this->load->database('rss', TRUE);
		//$this->db->dbprefix('bank_sponsor');
		$rss->where('id',$image_id);
		$get_sports = $rss->get('rss_sport_category');

		//echo $this->db->last_query(); exit;
		$row_sports['sports_arr'] = $get_sports->row_array();
		$row_sports['sports_count'] = $get_sports->num_rows;
		//echo "<pre>";print_r($row_games);exit;
		return $row_sports;
		
	}//end get_all_sponsors
	
	//Add New Sponsor
	public function add_new_sports($data){
		
		extract($data);

		//Uploading Slider Imaage
		if($_FILES['logo']['name'] != ''){

			//Create User Directory if not exist
			$games_folder_path = 'uploads/game_images';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['logo']['name'],'.')),'.'); 			
			$file_name = 	'games-'.date('YmdGis').'.jpg';

			$config['upload_path'] = $games_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '6000';
			//$config['width'] = 28;
			//$config['height'] = 28;
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('logo')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image 
				/*
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $games_folder_path.'/'.$file_name;
				$config_profile['new_image'] = $games_folder_path.'/'.$file_name;
				//$config_profile['create_thumb'] = TRUE;
				//$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 80;
				$config_profile['height'] = 80;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				//$this->image_lib->clear();
				*/
				
			}//end if(!$this->upload->do_upload('prof_image'))


		}//end if($_FILES['sponsor_image']['name'] != '')
		
		//$created_date = date('Y-m-d G:i:s');
		//$ip_address = $this->input->ip_address();
		//$created_by = $this->session->userdata('admin_id');

		$ins_data = array(
		   'category_name' => $this->db->escape_str(trim($name)),
		   'sport_logo' => $this->db->escape_str(trim($file_name)),
		   'slug_sport' => $this->db->escape_str(trim($name)),
		   'sport_status' => $status,
		   //'created_by' => $this->db->escape_str(trim($created_by)),
		 //  'created_by_ip' => $this->db->escape_str(trim($ip_address)),
		   //'created_date' => $this->db->escape_str(trim($created_date)),
		);

		//Insert the record into the database.
		//$this->db->dbprefix('bank_sponsor');
		$ins_into_db = $this->db->insert('kt_sport_category', $ins_data);
		
		//echo $this->db->last_query(); exit;
		
		if($ins_into_db) return true;

	}//end add_new_page()
	//Edit Sponsor
	public function edit_sports($data){
		
		extract($data);
		
		$get_image_data = $this->mod_sports->get_sports($sports_id);
		$get_image_data_arr = $get_image_data['sports_arr'];
		
		$old_file_name = $get_image_data_arr['sports_image'];
		
		//Uploading Slider Imaage
		if($_FILES['logo']['name'] != ''){

			//Create User Directory if not exist
			$games_folder_path = 'uploads/game_images';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['logo']['name'],'.')),'.'); 			
			$file_name = 	'slider-'.date('YmdGis').'.jpg';

			$config['upload_path'] = $games_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('logo')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
			
				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image 
			
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $games_folder_path.'/'.$file_name;
				$config_profile['new_image'] = $games_folder_path.'/thumb/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 230;
				$config_profile['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
			
			}

			//if(file_exists($games_folder_path.'/'.$old_file_name))
				//unlink($games_folder_path.'/'.$old_file_name);

		}else{
			$file_name = $old_file_name;	
		}
		if($file_name!=''){
			$upd_data = array(
		   'category_name' => $this->db->escape_str(trim($name)),
		   'sport_logo' => $this->db->escape_str(trim($file_name)),
		   'sport_status' => $status,
		);
		}else{
			$upd_data = array(
		   'category_name' => $this->db->escape_str(trim($name)),
		   'sport_status' => $status,
		);
		}
		
		$this->db->where('id',$sports_id);
		$upd_into_db = $this->db->update('kt_sport_category', $upd_data);
		
		if($upd_into_db) return true;

	}
	public function delete_sports($sports_id){

		$rss = $this->load->database('rss', TRUE);
		
		$get_sports_data = $this->mod_sports->get_sports($sports_id);
		$get_sports_data_arr = $get_testimonial_data['sports_arr'];
		
		//Create User Directory if not exist
		$games_folder_path = '../uploads/game_images';

		$old_file_name = $get_games_data_arr['games_image'];

		//Delete Existing Image
		if(file_exists($games_folder_path.'/'.$old_file_name))
			unlink($games_folder_path.'/'.$old_file_name);
		
		//Delete the record from the database.
		//$this->db->dbprefix('bank_sponsor');
		$rss->where('id',$sports_id);
		$del_into_db = $rss->delete('kt_sport_category');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_sponsor()


}
?>