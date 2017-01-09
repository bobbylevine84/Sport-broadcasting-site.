<?php
class mod_admin extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Verify If User is Login on the authorized Pages.
	public function verify_is_admin_login(){
		
		if(!$this->session->userdata('admin_id')){
			

			$this->session->set_flashdata('err_message', '- You have to login to access this page.');
			redirect(base_url().'login/login');
			
		}//if(!$this->session->userdata('id'))
		
	}//end verify_is_user_login()

	## UPDATE PROFILE ##

	//Get Admin Profile Record
	public function get_admin_profile($admin_id){
		
		$this->db->select('id, first_name, last_name, display_name, username, email_address, profile_image');
		$this->db->dbprefix('admin');
		$this->db->where('id',$admin_id);
		$get_admin_profile = $this->db->get('admin');

		//echo $this->db->last_query();
		$row_admin['admin_profile_arr'] = $get_admin_profile->row_array();
		$row_admin['admin_profile_count'] = $get_admin_profile->num_rows;
		return $row_admin;
		
	}//end get_admin_profile
	
	//Updatiing Admin Profile
	public function update_admin_profile($data,$admin_id){
		
		extract($data);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'first_name' => $this->db->escape_str(trim($first_name)),
		   'last_name' => $this->db->escape_str(trim($last_name)),
		   'display_name' => $this->db->escape_str(trim($display_name)),
		   'username' => $this->db->escape_str(trim($username)),
		   'email_address' => $this->db->escape_str(trim($email_address)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);		

		//Create User Directory if not exist
		$user_folder_path = './assets/user_files/'.$admin_id;
		
		if(!is_dir($user_folder_path))
			mkdir($user_folder_path);
			
		//Uploading profile Imaage
		if($_FILES['prof_image']['name'] != ''){
			
			$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 			
			$profile_file_name = 	'user_profile_'.$admin_id.'.jpg';

			$config['upload_path'] = $user_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '1000';
			$config['overwrite'] = true;
			$config['file_name'] = $profile_file_name;
		
			$this->load->library('upload', $config);
			
			if(!$this->upload->do_upload('prof_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{
				
				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 180 * 180
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $user_folder_path.'/'.$profile_file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 180;
				$config_profile['height'] = 180;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
				
				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image 
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $user_folder_path.'/'.$profile_file_name;
				$config_profile['new_image'] = $user_folder_path.'/t1-'.$profile_file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 28;
				$config_profile['height'] = 28;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
	
			}//end if else if(!$this->upload->do_upload('upload_cv'))
			
			$upd_data['profile_image'] = $this->db->escape_str(trim($profile_file_name));

			$add_profile_to_session = array(
				'profile_image'	=>	trim($profile_file_name),
			);
				
			$this->session->set_userdata($add_profile_to_session);			
			
		}//end if($_FILES['prof_image']['name'] != '')

		//Update the record into the database.
		$this->db->dbprefix('admin');
		$this->db->where('id',$admin_id);
		$upd_into_db = $this->db->update('admin', $upd_data);
		
		//echo $this->db->last_query();
		
		if($upd_into_db){

			$login_sess_array = array(
				'display_name'	=>	$display_name,
				'email_address'	=>	$mail_address,
				);
					
				$this->session->set_userdata($login_sess_array);
			
			return true;
			
		}//end if($upd_into_db)
		
	}//end update_admin_profile

	## CHANGE PASSWORD ##
	
	//Updatiing Admin Password
	public function update_admin_password($data,$admin_id){
		
		extract($data);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'password' => $this->db->escape_str(md5(trim($new_password))),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);		

		//Update the record into the database.
		$this->db->dbprefix('admin');
		$this->db->where('id',$admin_id);
		$upd_into_db = $this->db->update('admin', $upd_data);
		
		//echo $this->db->last_query();
		
		if($upd_into_db)
			return true;
			
	}//end update_admin_password
	
	## ADMIN USER MANAGEMENT ##
	
	//Get Admin User Record
	public function get_admin_user_data($admin_id){
		
		$this->db->dbprefix('admin');
		$this->db->where('id',$admin_id);
		$get_admin = $this->db->get('admin');

		//echo $this->db->last_query();
		$row_admin['admin_user_arr'] = $get_admin->row_array();
		$row_admin['admin_user_count'] = $get_admin->num_rows;
		return $row_admin;
		
	}//end get_admin_user_data

	
	//Get Total Number of admin Users in Database
	public function count_total_admin_users(){
		
		$this->db->dbprefix('admin');
		return $this->db->count_all("admin");
		
	}//end count_total_admin_users

	//Get All Admin Users record.
	public function get_admin_users_limit($start, $limit){
		
		$this->db->dbprefix('admin');
		$this->db->select('admin.*,admin_roles.role_title');
		$this->db->where('is_sup_admin != 1');
		$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
		$this->db->limit($limit,$start);
		$this->db->order_by('admin.created_date DESC');
		
		$get_admin_user_list_limit = $this->db->get('admin');

		//echo $this->db->last_query();exit;
		
		$row_admin_user_list_limit['admin_list_result'] = $get_admin_user_list_limit->result_array();
		$row_admin_user_list_limit['admin_list_result_count'] = $get_admin_user_list_limit->num_rows;
		
		return $row_admin_user_list_limit;		
		
	}//end get_all_admin_users_limit
	
	//Check if username already exist
	public function check_if_username_exist($username){
		
		$this->db->dbprefix('admin');
		$this->db->select('id,');
		$this->db->dbprefix('admin');
		$this->db->where('username',$username);
		$get_count = $this->db->get('admin');
		
		$num_if_rows = $get_count->num_rows;
		
		//echo $this->db->last_query();

		if($num_if_rows > 0) return true;
		else 
		return false;

		//echo $this->db->last_query();
		
	}//end check_if_username_exist

	//Add new Admin User
	public function add_new_user($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');

		$ins_data = array(
		   'first_name' => $this->db->escape_str(trim($first_name)),
		   'last_name' => $this->db->escape_str(trim($last_name)),
		   'display_name' => $this->db->escape_str(trim($display_name)),
		   'username' => $this->db->escape_str(trim($username)),
		   'email_address' => $this->db->escape_str(trim($email_address)),
		   'admin_role_id' => $this->db->escape_str(trim($admin_role_id)),
		   'status' => $this->db->escape_str(trim($status)),
		   'password' => $this->db->escape_str(md5(trim($password))),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		   'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('admin');
		$ins_into_db = $this->db->insert('admin', $ins_data);
		
		//echo $this->db->last_query(); exit;
		
		if($ins_into_db){
			
			$new_admin_id = $this->db->insert_id();

			//Create User Directory if not exist
			$user_folder_path = './assets/user_files/'.$new_admin_id;
			
			if(!is_dir($user_folder_path))
				mkdir($user_folder_path);
				
			//Uploading profile Imaage
			if($_FILES['prof_image']['name'] != ''){
				
				$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 			
				$profile_file_name = 	'user_profile_'.$new_admin_id.'.jpg';
	
				$config['upload_path'] = $user_folder_path;
				$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
				$config['max_size']	= '1000';
				$config['overwrite'] = true;
				$config['file_name'] = $profile_file_name;
			
				$this->load->library('upload', $config);
				
				if(!$this->upload->do_upload('prof_image')){
					
					$error_file_arr = array('error' => $this->upload->display_errors());
					return $error_file_arr;
					
				}else{
					
					$data_image_upload = array('upload_image_data' => $this->upload->data());
					
					//Resize the Uploaded Image 180 * 180
					$config_profile['image_library'] = 'gd2';
					$config_profile['source_image'] = $user_folder_path.'/'.$profile_file_name;
					$config_profile['create_thumb'] = TRUE;
					$config_profile['thumb_marker'] = '';
					
					$config_profile['maintain_ratio'] = TRUE;
					$config_profile['width'] = 180;
					$config_profile['height'] = 180;
					
					$this->load->library('image_lib');
					$this->image_lib->initialize($config_profile);
					$this->image_lib->resize();
					$this->image_lib->clear();
					
					//Creating Thumbmail 28 * 28
					//Uploading is successful now resizing the uploaded image 
					$config_profile['image_library'] = 'gd2';
					$config_profile['source_image'] = $user_folder_path.'/'.$profile_file_name;
					$config_profile['new_image'] = $user_folder_path.'/t1-'.$profile_file_name;
					$config_profile['create_thumb'] = TRUE;
					$config_profile['thumb_marker'] = '';
					
					$config_profile['maintain_ratio'] = TRUE;
					$config_profile['width'] = 28;
					$config_profile['height'] = 28;
					
					$this->load->library('image_lib');
					$this->image_lib->initialize($config_profile);
					$this->image_lib->resize();
					$this->image_lib->clear();
		
				}//end if else if(!$this->upload->do_upload('upload_cv'))
				
				$upd_data['profile_image'] = $this->db->escape_str(trim($profile_file_name));
				
				//Updating the record into the database.
				$this->db->dbprefix('admin');
				$this->db->where('id',$new_admin_id);
				$upd_into_db = $this->db->update('admin', $upd_data);

			}//end if($_FILES['prof_image']['name'] != '')
			
			return true;
			
		}else
			return false;
		//end if($ins_into_db)
		
	}//end add_new_user

	//Edit Admin User Data
	public function edit_user($data){
		
		extract($data);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');
		
		$upd_data = array(
		   'first_name' => $this->db->escape_str(trim($first_name)),
		   'last_name' => $this->db->escape_str(trim($last_name)),
		   'display_name' => $this->db->escape_str(trim($display_name)),
		   'username' => $this->db->escape_str(trim($username)),
		   'email_address' => $this->db->escape_str(trim($email_address)),
		   'admin_role_id' => $this->db->escape_str(trim($admin_role_id)),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);		

		if(trim($password) != ''){
			$upd_data['password'] =  $this->db->escape_str(md5(trim($password)));
		}

		//Create User Directory if not exist
		$user_folder_path = './assets/user_files/'.$admin_id;
		
		if(!is_dir($user_folder_path))
			mkdir($user_folder_path);
			
		//Uploading profile Imaage
		if($_FILES['prof_image']['name'] != ''){
			
			$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 			
			$profile_file_name = 	'user_profile_'.$admin_id.'.jpg';

			$config['upload_path'] = $user_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '1000';
			$config['overwrite'] = true;
			$config['file_name'] = $profile_file_name;
		
			$this->load->library('upload', $config);
			
			if(!$this->upload->do_upload('prof_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{
				
				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 180 * 180
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $user_folder_path.'/'.$profile_file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 180;
				$config_profile['height'] = 180;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
				
				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image 
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $user_folder_path.'/'.$profile_file_name;
				$config_profile['new_image'] = $user_folder_path.'/t1-'.$profile_file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 28;
				$config_profile['height'] = 28;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
	
			}//end if else if(!$this->upload->do_upload('upload_cv'))
			
			$upd_data['profile_image'] = $this->db->escape_str(trim($profile_file_name));
			
		}//end if($_FILES['prof_image']['name'] != '')

		//Updating the record into the database.
		$this->db->dbprefix('admin');
		$this->db->where('id',$admin_id);
		$upd_into_db = $this->db->update('admin', $upd_data);
		
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db)
			return true;
		
	}//end edit_user
	
	//Delete Admin User
	public function delete_user($admin_id){
		
		if($admin_id != 1){
			
			//Deleting User folder
			if($admin_id!=''){
				$user_folder_path = './assets/user_files/'.$admin_id;
				$delete_user_folder = $this->mod_common->remove_directory($user_folder_path);
			}//end if($admin_id!='')
			
			//Delete the record from the database.
			$this->db->dbprefix('admin');
			$this->db->where('id',$admin_id);
			$del_into_db = $this->db->delete('admin');
			if($del_into_db) return true;
			//echo $this->db->last_query();

		}//end if($admin_id != 1)
		
	}//end delete_user

}
?>