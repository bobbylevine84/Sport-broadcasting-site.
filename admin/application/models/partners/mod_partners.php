<?php
class mod_partners extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }
	public function get_all_partners(){

		$get_partners = $this->db->get('kt_admin');

		$row_partners['partners_arr'] = $get_partners->result_array();
		$row_partners['partners_count'] = $get_partners->num_rows;
		return $row_partners;
		
	}
	public function get_partners($partners_id){
		
		$this->db->where('id',$partners_id);
		$get_partners = $this->db->get('kt_admin');
		$row_partners['partners_arr'] = $get_partners->row_array();
		$row_partners['partners_count'] = $get_partners->num_rows;
		return $row_partners;
		
	}
	

	public function delete_partners($partners_id){


		$get_partners_data = $this->mod_partners->get_partners($partners_id);
		$get_partners_data_arr = $get_partners_data['partners_arr'];
		
		//Create User Directory if not exist
		//$partners_folder_path = '../uploads/game_images';

		//$old_file_name = $get_games_data_arr['games_image'];

		//Delete Existing Image
		//if(file_exists($games_folder_path.'/'.$old_file_name))
		//	unlink($games_folder_path.'/'.$old_file_name);
		
		//Delete the record from the database.
		//$this->db->dbprefix('bank_sponsor');
		$this->db->where('id',$partners_id);
		$del_into_db = $this->db->delete('kt_admin');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_sponsor()


}
?>