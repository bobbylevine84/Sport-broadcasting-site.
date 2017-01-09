<?php
class Manage_section_m extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Get Site Preferences
	public function get_preferences_setting($setting_name)
	{
		
		$this->db->dbprefix('site_preferences');
		
		$this->db->where('setting_name',$setting_name);
		$get_setting = $this->db->get('site_preferences');

		//echo $this->db->last_query(); exit;
		return $get_setting->row_array();
		
	}//end get_preferences_setting
	
	public function get_setting()
	{
		$get_setting = $this->db->get('kt_home_section');
		
		//print_r($get_setting);
		//exit;
		return $get_setting->result_array();
	}
	public function get_home_page_content()
	{
		$get_setting = $this->db->get('kt_home_page_content');
		
		//print_r($get_setting);
		//exit;
		return $get_setting->result_array();
	}
	
	public function update_sec()
	{
		
		for ( $i=0; $i<count($this->input->post('id')); $i++ ) { 
			
			$title = $this->input->post('title');
			$content = $this->input->post('content');
			$link = $this->input->post('link');
			$type = $this->input->post('type');
			$id = $this->input->post('id');
			
			$image = $_FILES['image']['name'][$i];
			
			if ($image!='') { 
				
				
				//Create User Directory if not exist
			$folder_path = '../uploads/section/';
	
			move_uploaded_file($_FILES['image']['tmp_name'][$i], $folder_path.$image);
				
				$data_update = array(
				'sec_title' => mysql_real_escape_string($title[$i]),
				'sec_image' => mysql_real_escape_string($image),
				'sec_content' => mysql_real_escape_string($content[$i]),
				'link' => mysql_real_escape_string($link[$i]),
				'type' => mysql_real_escape_string($type[$i])
				);
				
			} else { 
				
				
				$data_update = array(
				'sec_title' => mysql_real_escape_string($title[$i]),
				'sec_content' => mysql_real_escape_string($content[$i]),
				'link' => mysql_real_escape_string($link[$i]),
				'type' => mysql_real_escape_string($type[$i])
				);
				
			}
			
			$this->db->where('id', $id[$i]);
			
			$this->db->update('kt_home_section', $data_update);	
				
		}
		redirect('home/manage_section');
	}
	public function get_menus_drop_down()
	{
		$this->db->select('menu_url,menu_name,slug_menu');
		return $this->db->get('kt_menus')->result_array();
		
	}
	
	################################################################
	####################### deposit icon ###########################
	################################################################
	public function get_all_deposit_icons()
	{
		//$this->db->dbprefix('deposit_icons');
		$this->db->order_by('id DESC');
		$get_deposit_icons = $this->db->get('kt_deposit_ways_icons');
		//echo $this->db->last_query();
		$row_deposit_icons['deposit_icons_arr'] = $get_deposit_icons->result_array();
		$row_deposit_icons['deposit_icons_count'] = $get_deposit_icons->num_rows;
		
		/*echo '<pre>';
		print_r($row_deposit_icons);
		exit;*/
		return $row_deposit_icons;
	}
	public function get_deposit_icon($id)
	{
		$this->db->where('id',$id);
		$get_deposit_icon = $this->db->get('kt_deposit_ways_icons');
		return $get_deposit_icon->result_array();;
	}
	public function add_new_deposit_icon($image)
	{
		$folder_path = '../uploads/deposit_icons/';
		move_uploaded_file($_FILES['deposit_icon']['tmp_name'],$folder_path.$image);
		
		$new_data = array(
		'deposit_icon' => $image,
		'deposit_link' => $this->input->post('deposit_link'),
		'display_order' => $this->input->post('display_order'),
		'status' => $this->input->post('status')
		);
		
		$this->db->insert('kt_deposit_ways_icons',$new_data);	
	}
	################################################################
	####################### strategic partner ######################
	################################################################
	public function get_all_partner_icons()
	{
		//$this->db->dbprefix('deposit_icons');
		$this->db->order_by('id DESC');
		$get_partner_icons = $this->db->get('kt_strategic_partner_icons');
		//echo $this->db->last_query();
		$row_partner_icons['partner_icons_arr'] = $get_partner_icons->result_array();
		$row_partner_icons['partner_icons_count'] = $get_partner_icons->num_rows;
		
		/*echo '<pre>';
		print_r($row_partner_icons);
		exit;*/
		return $row_partner_icons;
	}
	public function get_partner_icon($id)
	{
		$this->db->where('id',$id);
		$get_partner_icon = $this->db->get('kt_strategic_partner_icons');
		return $get_partner_icon->result_array();;
	}
	public function add_new_partner_icon($image)
	{
		$folder_path = '../uploads/partner_icons/';
		move_uploaded_file($_FILES['partner_icon']['tmp_name'],$folder_path.$image);
		
		$new_data = array(
		'partner_icon' => $image,
		'partner_link' => $this->input->post('partner_link'),
		'display_order' => $this->input->post('display_order'),
		'status' => $this->input->post('status')
		);
		
		$this->db->insert('kt_strategic_partner_icons',$new_data);	
	}
	################################################################
	####################### Social icons ###########################
	################################################################
	
	public function get_all_social_icons(){
		//$this->db->dbprefix('social_icons');
		//$this->db->order_by('id DESC');
		$all_social_icons = $this->db->query("
				SELECT
					kt_social_icons.*,kt_icon_styles.style_type
				FROM
					kt_social_icons
				INNER JOIN
					kt_icon_styles
				ON
					kt_social_icons.id = kt_icon_styles.social_icon_id
			");
			$new = $all_social_icons->result_array();
		//echo '<pre>';
		//print_r($new);
		//exit;
		//$this->db->dbprefix('social_icons');
		//$this->db->order_by('id DESC');
		//$get_social_icons = $this->db->get('kt_social_icons');
		//echo $this->db->last_query();
		//$row_social_icons['social_icons_arr'] = $get_social_icons->result_array();
		return $new; // $get_social_icons->result_array();
		//$row_social_icons['social_icons_count'] = $get_social_icons->num_rows;
		//return $row_social_icons;
	}
	public function get_social_icon($id)
	{
		$this->db->where('id',$id);
		$get_social_icon = $this->db->get('social_icons');
		//echo $this->db->last_query();
		//$row_social_icon['social_icon_arr'] = $get_social_icon->result_array();
		//$row_social_icon['social_icons_count'] = $get_social_icon->num_rows;
		return $get_social_icon->result_array();;
	}
	public function update_social_icon($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('kt_social_icons', $data);
	}
	public function add_new($image)
	{
		$folder_path = '../uploads/social_icons/';
		move_uploaded_file($_FILES['social_icon']['tmp_name'],$folder_path.$image);
		
		$new_data = array(
		'social_icon' => $image,
		'social_link' => $this->input->post('social_link'),
		'display_order' => $this->input->post('display_order'),
		'status' => $this->input->post('status')
		);
		
		$this->db->insert('kt_social_icons',$new_data);	
	}
	
	public function temp_status_update($x,$y)
	{//this method change the temprary status and insert the url 
	
		//echo '<pre>';
		//print_r($y);
		//exit;
		$temp = array(
			'temp_status'=>1,
			'social_link'=>$y
		);
		$this->db->where('id',$x);
		$this->db->update('kt_social_icons',$temp);
		
	}
	public function assgin_style($style_id)
	{
		//this method will empty the table and than insert new style
		
		$this->db->query("TRUNCATE TABLE kt_icon_styles");
		//$this->db->query("DELETE * FROM 'kt_icon_styles'");
		
		$this->db->where('temp_status',1);
		$this->db->select('id');
		$d = $this->db->get('kt_social_icons')->result_array();
		
		foreach($d as $c)
		{
			$v = array( 'style_type'=>$style_id,'social_icon_id'=>$c['id'],);
			$this->db->insert('kt_icon_styles',$v);
		}
	}
	##########################################################################
	
	//public function get_boxes_data()
	//{
//		return $this->db->get('kt_miscellaneous')->result_array();/
//	}
	##########################################################################
	###################		common methods 	  ################################
	##########################################################################
	public function get_num_rows_where($col_name,$value,$table_name)
	{
		//get values where col_name, its value and table_name
		$this->db->where($col_name,$value);
		return $this->db->get($table_name)->num_rows();
		
	}
	public function get_all_values_frm_table($table_name)
	{
		return $this->db->get($table_name)->result_array();
	}
	public function active($val){
		$this->db->dbprefix('kt_deposit_ways_icons');
		$this->db->set('status', '0', FALSE);
		$this->db->where('id', $val);
		$upd_into_db=$this->db->update('kt_deposit_ways_icons');
		return $upd_into_db;

	}
	public function inactive($val){
		$this->db->dbprefix('kt_deposit_ways_icons');
		$this->db->set('status', '1', FALSE);
		$this->db->where('id', $val);
		$upd_into_db=$this->db->update('kt_deposit_ways_icons');
		return $upd_into_db;

	}
	public function active_icon($val){
		$this->db->dbprefix('kt_strategic_partner_icons');
		$this->db->set('status', '0', FALSE);
		$this->db->where('id', $val);
		$upd_into_db=$this->db->update('kt_strategic_partner_icons');
		return $upd_into_db;

	}
	public function inactive_icon($val){
		$this->db->dbprefix('kt_strategic_partner_icons');
		$this->db->set('status', '1', FALSE);
		$this->db->where('id', $val);
		$upd_into_db=$this->db->update('kt_strategic_partner_icons');
		return $upd_into_db;

	}
	
}
?>