<?php
class mod_captcha extends CI_Model {
	function __construct(){
		
        parent::__construct();
        
    }

	public function creat_captcha()
	{
		$vals = array(
			'img_path' => 'assets/images/',
			'img_url' => base_url().'assets/images/',
			'font_path'  => '/assets/images/fonts/'.$font_name[0]['font'],
			'img_width' => '150',
			'img_height' => '40'
			);
			//print_r($vals);exit;
		$cap = create_captcha($vals);
		
		$data = array(
			'cap_time' =>$cap['time'],
			'cap_word' =>$cap['word'],
			'ip_address' =>$this->input->ip_address()			
		);
		$this->db->insert('kt_captcha',$data);
		return $cap;
	}
	public function chk_isvalid_captcha($val)
	{			
	    $this->db->where('cap_word',$val);
		$found_row = $this->db->get('kt_captcha')->num_rows();
		$expiration = time()-7200; 
		$this->db->query("
							DELETE
							FROM
							kt_captcha 
							WHERE 
							cap_time < ".$expiration
						);
		return ($found_row == 0) ? 0 : 1 ;		
	}
}
?>