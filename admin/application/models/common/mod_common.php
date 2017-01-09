<?php
class mod_common extends CI_Model {
	function __construct(){
		
        parent::__construct();
    }
	
	//Random Password Generator
	public function random_number_generator($digit){

		$randnumber = '';
		$totalChar = $digit;  //length of random number
		$salt = "0123456789";  // salt to select chars
		srand((double)microtime()*1000000); // start the random generator
		$password=""; // set the inital variable
		
		for ($i=0;$i<$totalChar;$i++)  // loop and create number
		$randnumber = $randnumber. substr ($salt, rand() % strlen($salt), 1);
		
		return $randnumber;
		
	}// random_password_generator()

	//Generating URL string, eliminating special characters.
	public function generate_seo_url($url_string){
		
		$str_tmp = str_replace(' ', '-', $url_string); // Replaces all spaces with hyphens.
		return strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $str_tmp)); 	// Replaces all Special characters	
		
	}//end generate_seo_url
	
	//If URL String already exist in the database table record generate new.
	public function verify_seo_url($url_string,$table_name,$field_name,$exclude_self){

			$this->db->dbprefix($table_name);
			$this->db->select('id');
			$this->db->where($field_name, $url_string); 
			if($exclude_self != 0) $this->db->where('id !=', $exclude_self); 
			$rs_count_rec = $this->db->get($table_name);
			//echo $this->db->last_query(); exit;
			
			if($rs_count_rec->num_rows == 0) return $url_string;
			else{
				//Add Postfix and generate concatenate.
				$generate_postfix = $this->mod_common->random_number_generator(3);
				$new_url_string = $url_string.'-'.$generate_postfix;
				return $this->mod_common->verify_seo_url($new_url_string,$table_name,'seo_url_name',$exclude_self);
				
			}//end if
		
	}//end verify_seo_url
	
	//Convert mysql format date to user defined date
	public function user_define_date($sqldate){
		
		if($sqldate!='') return date("M j, Y", strtotime($sqldate));
		else return '';
		
	}//end user_define_ddate()


	//Convert mm/dd/yyyy to Mysql Date forma Y-m-d
	public function convert_to_mysql_date($user_date){
		
		if($user_date!='') return date("Y-m-d", strtotime($user_date));
		else return '';	//end if($user_date!='')
		
	}//end convert_mysql_date()

	//Convert Mysql Date format Y-m-d to mm/dd/yyyy
	public function convert_to_standard_date($mysqldate){
		
		if($mysqldate!=''){
			return date("m/d/Y", strtotime($mysqldate));
		}else{
			return '';	
		}//end if($user_date!='')
		
	}//end convert_mysql_date()

	//Split the date and get the Array of Month, Day and Year. Allowed Date format Y-m-d and mm/dd/yyyy
	public function convert_date_to_array($mysqldate, $date_format){
		
		$date_split = array();
		
		if($mysqldate!=''){
			
			if($date_format == 'Y-m-d'){

				$dated = explode('-', $mysqldate);
				$date_split['year']  = $dated[0];
				$date_split['month'] = $dated[1];
				$date_split['day'] = $dated[2];
				
			}else{
				
				$dated = explode('/', $mysqldate);
				$date_split['year']  = $dated[2];
				$date_split['month'] = $dated[0];
				$date_split['day'] = $dated[1];
				
			}//end if($date_format == 'Y-m-d')
			
		}//end if($mysqldate!='')
		
		return $date_split;
		
	}//end convert_mysql_date()
	
	
	//A generic Function Used When a single value need to be accessed from the database. 
	public function db_common_function($select_field, $tablename, $where_fieldname, $where_fieldvalue){
		
		$this->db->select($select_field);
		$this->db->where($where_fieldname, $where_fieldvalue); 
		$get_if_record_exist = $this->db->get($tablename);
		$row_get_if_record_exist = $get_if_record_exist->row();
		
		if($get_if_record_exist->num_rows > 0) return $row_get_if_record_exist->$select_field;
		else return;
		
		
	}//end db_common_function

	//To get the number of days of a month in a given year. Parameter Given is a MYSQL date format
	function calculate_no_of_month_days($date){
		
		$year 	= date('Y', strtotime($date));
		$mmonth	= date('m', strtotime($date));
		$no_of_days  = cal_days_in_month(CAL_GREGORIAN,$month,$year);
		return $no_of_days ;
		
	}//end calculate_no_of_month_days
	


	##################################################
	#
	#  	A function that would delete folders, subfolders and files
	#
	##################################################
	
	public function remove_directory( $dir, $DeleteMe = TRUE ){
	
		if ( ! $dh = @opendir ( $dir ) ) return;
		
		while ( false !== ( $obj = readdir ( $dh ) ) ){
			if ( $obj == '.' || $obj == '..') continue;

			if ( ! @unlink ( $dir . '/' . $obj ) ) 
				rmdir_r ( $dir . '/' . $obj, true );
			
		}
		
		closedir ( $dh );
		if ( $DeleteMe ){
			@rmdir ( $dir );
		}
	}//end remove_directory
	
	//Fetch Left Navigation Panel
	function fetch_admin_nav_panel(){

		$this->db->dbprefix('admin_user_roles');
		$this->db->where('show_in_nav',1);
		$this->db->order_by('display_order', 'DESC');
		
		$get_admin_navpanel = $this->db->get('admin_menu');

		//echo $this->db->last_query(); exit;
		$admin_nav_panel_arr = $get_admin_navpanel->result_array();
		
		for($i = 0 ;$i<count($admin_nav_panel_arr);$i++){
			
			if($admin_nav_panel_arr[$i]['parent_id'] == 0){
				
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['menu_id'] = $admin_nav_panel_arr[$i]['id'];
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['menu_title'] = $admin_nav_panel_arr[$i]['menu_title'];
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['menu_icon_class'] = $admin_nav_panel_arr[$i]['icon_class_name'];
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['show_in_nav'] = $admin_nav_panel_arr[$i]['show_in_nav'];
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['url_link'] = $admin_nav_panel_arr[$i]['url_link'];
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['status'] = $admin_nav_panel_arr[$i]['status'];
				
			}else{
				
				$nav_panel_arr[$admin_nav_panel_arr[$i]['parent_id']]['sub_menu'][] = $admin_nav_panel_arr[$i];
				
			}//end if
			
		}//end for

/*		echo '<pre>';
		print_r($nav_panel_arr);
		exit;
*/		
		return array_reverse($nav_panel_arr);
		
	}//end fetch_admin_nav_panel

	//Get List of all Menues
	function get_admin_menu_list(){

		$this->db->dbprefix('admin_user_roles');
		$this->db->select('id,menu_title,parent_id,set_as_default,status');
		$this->db->where('status',1);
		
		$get_admin_navpanel = $this->db->get('admin_menu');

		//echo $this->db->last_query();
		$admin_nav_panel_arr = $get_admin_navpanel->result_array();
		
		for($i = 0 ;$i<count($admin_nav_panel_arr);$i++){
			
			if($admin_nav_panel_arr[$i]['parent_id'] == 0){
				
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['menu_title'] = $admin_nav_panel_arr[$i]['menu_title'];
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['status'] = $admin_nav_panel_arr[$i]['status'];
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['set_as_default'] = $admin_nav_panel_arr[$i]['set_as_default'];
				
			}else{
				
				$nav_panel_arr[$admin_nav_panel_arr[$i]['parent_id']]['sub_menu'][] = $admin_nav_panel_arr[$i];
				
			}//end if
			
		}//end for
		
		return $nav_panel_arr;
		
	}//end get_admin_menu_list
	
	##########################################################
	#############common email sending function ###############
	##########################################################
	
	//////////////sednding email////////////////////
	public function sendEmail($type,$data)
	{
		$this->load->library('email');
		
		//echo $type;
		echo '<pre>';
		print_r($data);
		exit;
		/*
			Array
			(
			[user_firstname] => test
			[user_lastname] => test
			[user_email] => a@g.com
			[user_phone] => t
			[user_dob] => t
			[user_street] => t
			[user_city] => t
			[user_state] => t
			[user_country] => t
			[user_postcode] => t
			[user_name] => aad
			[user_password] => 12
			[user_status] => 0
			)
		*/
		
		$template = $this->get_template($type);
		$temp = $template[0]['message'];
		
		$this->email->from('your@example.com', 'Your Name');
		$this->email->to('someone@example.com');
		$this->email->cc('another@another-example.com');
		$this->email->bcc('them@their-example.com');
		
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');
		
		$this->email->send();
		
		//echo $this->email->print_debugger();	
	}
	public function get_template($type)
	{
		$this->db->select('subject,message');
		$this->db->where('email_type',$type);
		return $this->db->get('kt_email_template')->result_array();
	}
}

?>