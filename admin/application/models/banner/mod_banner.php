<?php
class Mod_banner extends CI_Model
{
	public function get_all_banners()
	{
		$this->db->from('kt_banner');
		return $this->db->get()->result_array();
	}
	
	public function add_banner($data)
	{
		return $this->db->insert('kt_banner', $data);
	}
	
	public function inactive_status($id)
	{
		$this->db->set('status', 0);
		$this->db->where('id', $id);
		return $this->db->update('kt_banner');
	}
	
	public function active_status($id)
	{
		$this->db->set('status', 1);
		$this->db->where('id', $id);
		return $this->db->update('kt_banner');
	}
	
}
?>