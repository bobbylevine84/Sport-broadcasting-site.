<?php
class Chats extends CI_Model
{
	
	
	public function add_message($msg,$user_id)
	{
		$data=array("front_user_id"=>$user_id,"chat_message"=>$msg);
		$query=$this->db->insert("kt_shout_messages",$data);
		return $query;
	}
	
	public function get_messages($user_id)
	{
		
		//$query=$this->db->query("SELECT * FROM  `kt_shout_messages` WHERE  `chat_message` NOT LIKE  '%undefined%'ORDER BY created_date DESC LIMIT 0 , 30");
		$query=$this->db->query("SELECT * FROM kt_shout_messages WHERE (shout_message_id %2) =1 ORDER BY created_date DESC LIMIT 0 , 30");
		return $query->result_array();
	}
	
}
?>