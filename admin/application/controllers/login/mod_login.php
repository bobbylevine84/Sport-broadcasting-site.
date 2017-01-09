<?php
class mod_login extends CI_Model {
	function __construct(){
		
        parent::__construct();
        
    }
	
	//Validation of Login
	public function validate_credentials($username, $password){
		
		$this->db->dbprefix('admin');
		$this->db->select('admin.*,admin_roles.role_title, admin_roles.permissions');
		$this->db->where('username', strip_quotes($username));
		$this->db->where('password', strip_quotes(md5(trim($password))));
		$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
		$this->db->where('admin.status',1);
		$this->db->where('admin_roles.status',1);
		$get = $this->db->get('admin');

		//echo $this->db->last_query(); 		exit;
		
		if($get->num_rows > 0) return $get->row_array();

	}//end function validate	

	//Email Address Validation
	public function verify_email($email_address){
		
		$this->db->dbprefix('admin');
		$this->db->where('email_address', strip_quotes($email_address));
		$this->db->where('status',1);
		$get = $this->db->get('admin');
		
		//echo $this->db->last_query(); 		exit;

		if($get->num_rows > 0) return $get->row_array();

	}//end function verify_email	

	//Send New password
	public function send_new_password($admin_id){
		
		//User data
		$get_user_data = $this->mod_admin->get_admin_user_data($admin_id);

		$user_first_last_name = ucwords(strtolower(stripslashes($get_user_data['admin_user_arr']['first_name'].' '.$get_user_data['admin_user_arr']['last_name'])));
		$username = stripslashes($get_user_data['admin_user_arr']['username']);
		$new_password_decryp = trim($this->mod_common->random_number_generator(6));
		$new_password = md5($new_password_decryp);
		$email_address = stripslashes(trim($get_user_data['admin_user_arr']['email_address']));
		
		//Updating New Password into the database

		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'password' => $this->db->escape_str(trim($new_password)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('admin');
		$this->db->where('id',$admin_id);
		$upd_into_db = $this->db->update('admin', $upd_data);
		
		if($upd_into_db){
			
			$email_from_txt_arr = $this->mod_preferences->get_preferences_setting('email_from_txt');
			$email_from_txt = $email_from_txt_arr['setting_value'];
			
			$noreply_email_arr = $this->mod_preferences->get_preferences_setting('noreply_email');
			$noreply_email = $noreply_email_arr['setting_value'];
			
			
			//Email Contents
			$get_email_data = $this->mod_email->get_email(1);
			
			$email_subject = $get_email_data['email_arr']['email_subject'];
			$email_body = $get_email_data['email_arr']['email_body'];
			
			$search_arr = array('[SITE_URL]','[USER_FIRST_LAST_NAME]','[USER_USERNAME]','[USER_NEWPASSWORD]');
			$replace_arr = array(FRONT_SURL,$user_first_last_name,$username,$new_password_decryp);
			$email_body = str_replace($search_arr,$replace_arr,$email_body);

			//Preparing Sending Email
			$config['charset'] = 'utf-8';
			$config['mailtype'] = 'html';
			$config['wordwrap'] = TRUE;			
			$config['protocol'] = 'mail';
			
			$this->load->library('email',$config);

			$this->email->from($noreply_email, $email_from_txt);
			$this->email->to($email_address);
			$this->email->subject($email_subject);
			$this->email->message($email_body);
			$this->email->send();
			//echo $this->email->print_debugger();
			$this->email->clear();
			
			return true;

		}else{
			return false;	
		}//end if($upd_into_db)
		
	}//end function verify_email	

	//Update Last Sigin Date in Admin
	public function update_signin_date($user_id){
		
		$data = array(
		   'last_signin_date' => date('Y-m-d G:i:s'),
		   'last_signin_ip' => $this->input->ip_address(),
		);
		
		$this->db->dbprefix('admin');
		$this->db->where('id', strip_quotes($user_id));
		$update_st = $this->db->update('admin', $data);

	}//end function validate	
	
	public function creat_captcha()
	{//this fucntion is creating the captcha image and saving its values in db
		$vals = array(
			'img_path' => './assets/captcha/',
			'img_url' => base_url().'assets/captcha/',
			'font_path'  => '/assets/captcha/fonts/'.$font_name[0]['font'],
			'img_width' => '150',
			'img_height' => '40'
			);
		
		$cap = create_captcha($vals);
		
		$data = array(
			'cap_time' =>$cap['time'],
			'cap_word' =>$cap['word'],
			'ip_address' =>$this->input->ip_address()			
		);
		
		
		$this->db->insert('kt_captcha',$data);
		return $cap;
	}
	
	public function chk_isvalid_captcha($val)
	{//this function is to check the captcha form db
						
	    $this->db->where('cap_word',$val);
		$found_row = $this->db->get('kt_captcha')->num_rows();
		$expiration = time()-7200; 
		$this->db->query("
							DELETE
							FROM
							kt_captcha 
							WHERE 
							cap_time < ".$expiration
						);
		return ($found_row == 0) ? 0 : 1 ;		
	}
}
?>