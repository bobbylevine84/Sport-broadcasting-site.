<?php
class Mod_referrals extends CI_Model
{
	public function get_referrals($id = null)
	{
		$this->db->from('kt_referrals');
		if($id)
		{
			$this->db->where('id', $id);
		}
		return $this->db->get()->result_array();
	}
	
}
?>