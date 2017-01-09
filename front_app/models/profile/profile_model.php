<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_Model extends CI_Model 
{
	public function get_data()
	{
		$user_id=$this->session->userdata('front_user_id');
		$this->db->select('sg.*');
		$this->db->from('sg_front_users sg');
		$this->db->where('sg.front_user_id',$user_id);
		$query=$this->db->get();
		return $query->result_array();
	}

	public function check_if_following($login_user, $slug_name){
		$condition = array(
			'followed_by'	=> $login_user,
			'followed_to'	=> $slug_name,
		);

		$this->db->select('follow_id')->where($condition);
		$query = $this->db->get('kt_users_follow');



		$result = $query->result_array();

		return $result[0]['follow_id'];
	}

	public function get_user_id_from_slug($slug){
		$this->db->select('front_user_id')->where('front_user_name_slug', $slug);
		$query = $this->db->get('sg_front_users');

		$result = $query->result_array();
		return $result[0]['front_user_id'];
	}

	public function unfollow_people($followby, $followto){
		
		$data = array(
			'followed_by'	=> $followby,
			'followed_to'	=> $followto,
		);

		$this->db->delete('kt_users_follow', $data);
		
		return 1;
	}

	public function follow_list($id){
		$this->db->select('followed_to')->where('followed_by', $id);
		$query = $this->db->get('kt_users_follow');

		return $query->result_array();
	}

	public function username_from_id($id){

		$this->db->select('first_name')->where('front_user_id', $id);
		$query = $this->db->get('sg_front_users');

		$result = $query->result_array();
		return $result[0]['first_name'];
	}

	public function get_user_slug($id){
		$this->db->select('front_user_name_slug as slug')->where('front_user_id', $id);
		$query = $this->db->get('sg_front_users');

		$result = $query->result_array();

		return $result[0]['slug'];
	}

	public function get_user_image($id){
		$this->db->select('user_image')->where('front_user_id', $id);
		$query = $this->db->get('sg_front_users');

		$result = $query->result_array();

		return $result[0]['user_image'];
	}

	public function get_pending_matches($id, $status = NULL) {
		$this->db->select("kt_sg_matches.*, kt_sg_consoles.console_name as console, kt_sg_consoles_games.game_name as game, user1.user_name as user1_name, user1.front_user_name_slug as user1_slug, user2.user_name as user2_name, user2.front_user_name_slug as user2_slug,");
		$this->db->join("kt_sg_consoles", "kt_sg_consoles.consoles_id = kt_sg_matches.match_console_id");
		$this->db->join("kt_sg_consoles_games", "kt_sg_consoles_games.game_id = kt_sg_matches.match_game_id");
                $this->db->join('sg_front_users AS user1', 'user1.front_user_id = kt_sg_matches.challange_by_user AND user1.front_user_flag = "active"');
                $this->db->join('sg_front_users AS user2', 'user2.front_user_id = kt_sg_matches.challange_accepted_by_user AND user2.front_user_flag = "active"');
		if($status == NULL || $status == "") {
                    $where = "kt_sg_matches.challange_by_user =".$id." OR kt_sg_matches.challange_accepted_by_user =".$id."";
                }else if($status == "pending") {
                    $where = "(kt_sg_matches.match_status ='pending' OR kt_sg_matches.match_status ='claimed') AND (kt_sg_matches.challange_by_user =".$id." OR kt_sg_matches.challange_accepted_by_user =".$id.")";
                }else if($status == "won") {
                    $where = "kt_sg_matches.match_status ='completed' AND kt_sg_matches.winner_id =".$id." AND (kt_sg_matches.challange_by_user =".$id." OR kt_sg_matches.challange_accepted_by_user=".$id.")";
                }else if($status == "lost") {
                    $where = "kt_sg_matches.match_status ='completed' AND kt_sg_matches.winner_id !=".$id." AND (kt_sg_matches.challange_by_user =".$id." OR kt_sg_matches.challange_accepted_by_user=".$id.")";
                }else if($status == "disputed") {
                    $where = "kt_sg_matches.match_status ='disputed' AND (kt_sg_matches.challange_by_user =".$id." OR kt_sg_matches.challange_accepted_by_user =".$id.")";
                }
                $this->db->where($where);
		$this->db->order_by("kt_sg_matches.updated_date", "desc");
		$query = $this->db->get('kt_sg_matches')->result_array();
        return $query;
	}


}