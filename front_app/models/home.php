<?php
class Home_Model extends CI_Model
{
	public function get_country($country)
	{
	$this->db->select('Country');
	$this->db->from('kt_countries');
	$this->db->where('CountryId');
	$query=$this->db->get();
	return $query->result_array();
	}
}
?>