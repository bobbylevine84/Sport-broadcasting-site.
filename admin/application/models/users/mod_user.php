<?php
class mod_user extends CI_Model {
	
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
	public function get_active_users(){
		
		$this->db->dbprefix = '';
                $this->db->select('sg_front_users.*, kt_sg_wallet.amount as wallet_amount');
                $this->db->join('kt_sg_wallet', 'kt_sg_wallet.user_id = sg_front_users.front_user_id');
		$this->db->where('front_user_flag','active');
                $this->db->where('sg_front_users.front_user_id != ', 0);
		$get_active_user = $this->db->get('sg_front_users')->result_array();
	
		//echo '<pre>';print_r($get_active_user);exit;
		return $get_active_user;
		
	}//end get_admin_profile
	public function get_inactive_users(){
		
		$this->db->dbprefix = '';		
                $this->db->select('sg_front_users.*, kt_sg_wallet.amount as wallet_amount');
                $this->db->join('kt_sg_wallet', 'kt_sg_wallet.user_id = sg_front_users.front_user_id');
		$this->db->where('front_user_flag','inactive');
                $this->db->where('sg_front_users.front_user_id != ', 0);
		$get_inactive_users = $this->db->get('sg_front_users')->result_array();
		//echo '<pre>';print_r($get_inactive_users);exit;
		return $get_inactive_users;
		
	}
	public function get_banned_users(){
		
		$this->db->dbprefix = '';		
                $this->db->select('sg_front_users.*, kt_sg_wallet.amount as wallet_amount');
                $this->db->join('kt_sg_wallet', 'kt_sg_wallet.user_id = sg_front_users.front_user_id');
		$this->db->where('front_user_flag','banned');
                $this->db->where('sg_front_users.front_user_id != ', 0);
		$get_banned_users = $this->db->get('sg_front_users')->result_array();
		//echo '<pre>';print_r($get_banned_users);exit;
		return $get_banned_users;
		
	}
	public function get_record($type,$status){
		if($type== 0){
		$this->db->select('user_id, user_firstname, user_lastname, user_email, user_type, user_status');
		$this->db->dbprefix('kt_users');
		$this->db->where('user_status',$status);
		$get_records = $this->db->get('kt_users')->result_array();
		return $get_records;
		}
		else{
		
		$this->db->select('user_id, user_firstname, user_lastname, user_email, user_type, user_status');
		$this->db->dbprefix('kt_users');
		$this->db->where('user_type',$type);
		$this->db->where('user_status',$status);
		$get_records = $this->db->get('kt_users')->result_array();
		return $get_records;
		}
		
	}
	public function delete_user($id)
	{
		$this->db->dbprefix = '';
		$this->db->where('front_user_id',$id);
		$res=$this->db->delete('sg_front_users');
		return $res;
		
	}
	public function inactive_user($id,$status)
	{
		$upd_array=array(
		'front_user_flag'=>$status
		);
		$this->db->dbprefix = '';
		$this->db->where('front_user_id',$id);
		$res=$this->db->update('sg_front_users',$upd_array);
		return $res;
	}
	public function active_user($id,$status)
	{
		$upd_array=array(
			'front_user_flag'=>$status
		);
		$this->db->dbprefix = '';
		$this->db->where('front_user_id',$id);
		$res=$this->db->update('sg_front_users',$upd_array);
		return $res;
	}
	public function banned_user($id,$status)
	{
		$upd_array=array(
			'front_user_flag'=>$status
		);
		$this->db->dbprefix = '';
		$this->db->where('front_user_id',$id);
		$res=$this->db->update('sg_front_users',$upd_array);
		return $res;
	}
	public function get_record_by_id($id){
		$this->db->dbprefix = '';
		$this->db->where('front_user_id',$id);
		$get_records = $this->db->get('sg_front_users')->result_array();
		return $get_records;
		
	}
	public function update_user_data($data,$id)
	{
		$this->db->dbprefix = '';
		$this->db->where('front_user_id',$id);
		$get_records = $this->db->update('sg_front_users',$data);
		return $get_records;
	}
	public function check_username_exist($username,$id)
	{
		$this->db->dbprefix = '';
		$this->db->select('user_name');
		$this->db->where('front_user_id !=',$id);
		$this->db->where('user_name',$username);
		$get_records = $this->db->count_all_results('sg_front_users');
		//print_r($get_records);exit;
		return $get_records;
	}

	public function get_countries() {
        $this->db->select("CountryId as id, Country as name");
        $query = $this->db->get('kt_countries')->result_array();
        return $query;
    }

    public function get_states() {
        $this->db->select("RegionID as id, Region as name");
        $query = $this->db->get('kt_state')->result_array();
        return $query;
    }
	

}
?>