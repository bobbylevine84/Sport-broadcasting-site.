<?php
class mod_dashboard extends CI_Model {
	function __construct(){
		
        parent::__construct();
    }
	
	//get Sum Acounts
public function get_accounts(){
	$this->db->select('user_account_type');
	$this->db->from('kt_users');
	$query= $this->db->get();
	return $query;
	}
}

?>