<?php
class Mod_email extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }
	
	public function get_all_templates_count()
	{
		$this->db->dbprefix('email_template');
		return $this->db->count_all('email_template');
	}
	
	
	
	
	public function get_filter_template_grid_data(){
		
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		* you want to insert a non-database field (for example a counter or static image)
		*/
        //$aColumns = array('subject','message','type','id');
        
        // DB table to use
        //$sTable = 'email_template';
        //
    
        /*$iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        */
		//$sEcho = $this->input->get_post('sEcho', true);
    
        
        // Select Data
        //$this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumns)), false);
		
		//$this->db->order_by('created_date','DESC');
		//$this->db->dbprefix($sTable);
//        $rResult = $this->db->get($sTable);

        // Data set length after filtering
		/*$this->db->dbprefix($sTable);
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
    */
        // Total data set length
        //$iTotal = $this->db->count_all($sTable);

    
        // Output
        /*$output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );*/
		$output = $this->db->get('kt_email_template')->result();
		
        return $output;
		
        //echo json_encode($output);
    }//end get_filter_menu_grid_data
	
	public function update_template($val,$edit_template)
	{
		/*echo 'i am template/email/update_template';
		echo '<pre>';
		print_r($edit_template);
		exit;*/
		
		$this->db->where('id',$val);
		$this->db->update('kt_email_template',$edit_template);
	}
	
	
	
}
?>