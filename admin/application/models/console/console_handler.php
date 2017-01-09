<?php

class Console_Handler extends CI_Model{
	public function __construct(){
		$this->load->database();
	}

	public function fetch_all_consoles(){
		
		$query = $this->db->get('sg_consoles');
		return $query->result_array();
	
	}

	public function add_console($name){
		$data = array(
			'console_name'	=> $name,
		);

		$this->db->insert('kt_sg_consoles', $data);

		if($this->db->affected_rows() > 0){

   		 	return true; 
		}

		return false;
	}

	public function delete_console($id){
		
		$this->db->where('consoles_id', $id);
		$this->db->delete('kt_sg_consoles');

		if($this->db->affected_rows() > 0){

   		 	return true; 
		} 

		return false;
	}

	public function console_games($id){
		
		$this->db->where('console_id', $id);
		$query = $this->db->get('kt_sg_consoles_games');

		return $query->result_array();

	}

	public function get_console_name($id){
		$this->db->select('console_name')->where('consoles_id', $id);
		$query = $this->db->get('kt_sg_consoles');
		return $query->result_array();

	}

	public function add_game($game_data){
		$this->db->insert('kt_sg_consoles_games', $game_data);

		if($this->db->affected_rows() > 0){

   		 	return true; 
		} 

		return false;
	}

	public function delete_game($id){

		$this->db->where('game_id', $id);
		$this->db->delete('kt_sg_consoles_games');

		if($this->db->affected_rows() > 0){

   		 	return true; 
		} 

		return false;
	}
	
	public function edit_console_name($name, $id){

		$data = array(
			'console_name'	=> $name,
		);

		$this->db->where('consoles_id', $id);
		$this->db->update('kt_sg_consoles', $data); 

		return true;
	}

	/* GET GAME DETAILS */
	public function get_game_details($gameId){
		
		$this->db->where('game_id', $gameId);
		$query = $this->db->get('kt_sg_consoles_games');
		return $query->result_array();
	}

	/*EDIT GAME */
	public function edit_game($game_data, $gameId){

		$this->db->where('game_id', $gameId);

		$this->db->update('kt_sg_consoles_games', $game_data);

		return 1;

	}


}
