<?php
class mod_settings extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	public function get_gatway_list_count()
	{
		//echo 'i am consumer/mod_manage/get_consumers_list_count';
		$query=$this->db->get('kt_gateways')->result_array();
		return  count($query);
	}
	public function get_currency_list_count()
	{
		//echo 'i am consumer/mod_manage/get_consumers_list_count';
		$query=$this->db->get('kt_currency')->result_array();
		return  count($query);
	}
	
	public function get_gatways()
	{
		
		$result = $this->db->get('kt_gateways')->result_array();
		return $result;
 }
 public function get_currency()
	{
		$this->db->order_by('status','DESC');
		$result = $this->db->get('kt_currency')->result_array();
		
		return $result;
 }
	public function get_data($table,$col,$val=NULL){
		$result = $this->db->get($table);
		return $result;
	}	
	
	
	public function is_gatway_register($val)
	{
		//echo 'i am consumer/mod_manage/get_consumers_list_count';
		$this->db->where('id',$val);
		return $this->db->get('kt_gateways')->num_rows();
		
	}
	
	public function get_gatway_data($val)
	{
		//echo 'i am consumer/mod_manage/get_consumers_list_count';
		$this->db->where('id',$val);
		return $this->db->get('kt_gateways')->result_array();
	}
	
	public function update_gatway_data($val,$id)
	{
		//echo 'i am consumer/mod_manage/update_consumer_data';
		
		$this->db->where('id',$id);
		$this->db->update('kt_gateways',$val);
		
		/*echo $id.'<pre>';
		print_r($val);
		exit;*/
	}
	public function get_data_indi($table,$col,$val=NULL){

		$this->db->where('account_type',1);


		$result = $this->db->get($table);

		

		return $result;

	}	
	
	public function get_data_busi($table,$col,$val=NULL){

		$this->db->where('account_type',0);


		$result = $this->db->get($table);

		

		return $result;

	}	
	public function get_data_inst($table,$col,$val=NULL){

		$this->db->group_by('inst_name');


		$result = $this->db->get($table);

		

		return $result;

	}	
	public function update_db($table,$data,$col,$val){

		$this->db->where($col,$val);

		$this->db->update($table,$data);	

	}
	
	//Get Site Preferences
	public function get_preferences_setting($setting_name){
		
		$this->db->dbprefix('site_preferences');
		
		$this->db->where('setting_name',$setting_name);
		$get_setting = $this->db->get('site_preferences');

		//echo $this->db->last_query(); exit;
		return $get_setting->row_array();
		
	}//end get_preferences_setting
	
	public function get_setting()
	{
		//for hiding the first two fields
		$this->db->limit(4,2);
		
		$get_setting = $this->db->get('kt_setting');
		
		return $get_setting->result_array();
	}
	public function update_set()
	{
		foreach($this->input->post() as $key_update => $value_update_temp)
		{
			
			if($key_update!="submit")
			{
				$value_update = str_replace("\n","",$value_update_temp);
				$data_update = array('value' => mysql_real_escape_string($value_update));
				
				$this->db->where('options', $key_update);
				$this->db->update('kt_setting', $data_update);	
			}
		}
		
	}
	
	
	public function get_groups()
	{
		return $this->db->query('SELECT * FROM kt_manage_group')->result_array();
	}

	public function get_grp_fee_setting($grp_id)
	{
		$this->db->from('kt_grp_fee_setting');
		$this->db->where('grp', $grp_id);
		return $this->db->get()->result_array();
	}
	
	public function get_grp_sr_setting($grp_id)
	{
		$this->db->from('kt_grp_sr_setting');
		$this->db->where('gid', $grp_id);
		return $this->db->get()->result_array();
	}
	
	public function get_grp_withdraw_setting($grp_id)
	{
		$this->db->from('kt_grp_withdraw_setting');
		$this->db->where('gid', $grp_id);
		return $this->db->get()->result_array();
	}
	
	public function get_grp_exchange_setting($grp_id)
	{
		$this->db->from('kt_grp_exchange_setting');
		$this->db->where('gid', $grp_id);
		return $this->db->get()->result_array();
	}
	
	public function get_grp_sci_setting($grp_id)
	{
		$this->db->from('kt_grp_sci_setting');
		$this->db->where('gid', $grp_id);
		return $this->db->get()->result_array();
	}
}
?>