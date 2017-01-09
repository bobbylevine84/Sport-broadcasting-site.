<?php
class mod_menu extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }
	public function get_menu_top($id)
	{
		$this->db->where('id', $id);
		$this->db->like('position','top');
		$data = $this->db->get('kt_header_menu');
		return $data->result_array();
	}
	public function get_menu_side($id)
	{
		$this->db->where('id', $id);
		$this->db->like('position','side');
		$data = $this->db->get('kt_header_menu');
		return $data->result_array();
	}
	//Buttons Portion
	public function get_buttons()
	{
		$this->db->where('id', 6);
		$this->db->or_where('id', 7);
		$data = $this->db->get('kt_miscellaneous');
		return $data->result_array();
		/*$query=$this->db->get("kt_miscellaneous where id='6' and id='7'")->result();
		 
		 if(!empty($query))
		 {
			 return $query;
			 
			 }*/
		}
	public function insert_button($data){
		$this->db->insert('kt_buttons',$data);
		return $this->db->insert_id();
	}
	public function retrieve_buttons(){
		$query = $this->db->get('kt_buttons');
		return $query->result_array();
	}
	public function get_btn_row($edit_id){
		$this->db->where('id',$edit_id);
		$query = $this->db->get('kt_buttons');
		return $query->first_row('array');
	}
	public function update_button($edit_id,$data){
		$this->db->where('id',$edit_id);
		$this->db->update('kt_buttons',$data);
	}
	public function delete_button($id){
		$this->db->where('id',$id);
		$this->db->delete('kt_buttons');
	}
	
	
	//Get All menus
	public function get_all_menus(){
		
		$this->db->dbprefix('menus');
		$this->db->order_by('id DESC');
		$get_all_menus = $this->db->get('menus');

		//echo $this->db->last_query();
		$row_menu['menu_list_arr'] = $get_all_menus->result_array();
		$row_menu['menu_list_count'] = $get_all_menus->num_rows;
		
		for($i=0;$i<$row_menu['menu_list_count'];$i++){
			
			$menu_id = $row_menu['menu_list_arr'][$i]['id'];
			$create_menu_chain = $this->mod_menu->create_menu_chain($menu_id);
			$row_menu['menu_list_arr'][$i]['menu_chain'] = $create_menu_chain;
			
		}//end for
		
		return $row_menu;
		
	}//end get_all_cms_pages
	
	//Get All menus Count
	public function get_all_menus_count(){
		
		$this->db->dbprefix('menus');
		return $this->db->count_all("menus");
		
	}//end get_all_menus_count

	//Get Menu Record by ID
	public function get_menu($menu_id){
		
		$this->db->dbprefix('menus');
		$this->db->where('id',$menu_id);
		$get_menu = $this->db->get('menus');

		//$this->db->last_query(); exit;
		
		$row_menu['menu_arr'] = $get_menu->row_array();
		$row_menu['menu_arr_count'] = $get_menu->num_rows;
		
		return $row_menu;
		
	}//end get_menu
	
	//Check if menu exist against the selected Parent Id. If Nowt.. proceed
	public function check_if_menu_exist($menu_name,$parent_id,$exclude_self){
		
		$this->db->dbprefix('menus');
		$this->db->select('id'); 
		$this->db->from('menus');
		if($exclude_self != 0) $this->db->where('id !=', strip_quotes($exclude_self));
		$this->db->where('menu_name', strip_quotes($menu_name));
		$this->db->where('parent_id', strip_quotes($parent_id));
		
		$count_result = $this->db->count_all_results();

		//echo $this->db->last_query(); 		exit;
		
		return $count_result;

	}//end check_if_menu_exist

	//Get Parent Menu List
	public function get_menu_parent_list(){
		
		$this->db->dbprefix('menus');
		//$this->db->where('parent_id',0);
		$get_parent_menu_arr = $this->db->get('menus');

		$row_menu['menu_parent_list_arr'] = $get_parent_menu_arr->result_array();
		$row_menu['menu_parent_list_count'] = $get_parent_menu_arr->num_rows;
		
		return $row_menu;
		
	}//end get_menu_parent_list
	
	//Get menu Root Parent
	public function get_menu_root_parent($menu_id){
		
		$this->db->dbprefix('menus');
		$this->db->where('id',$menu_id);
		$get_menu_arr = $this->db->get('menus');

		//echo $this->db->last_query(); exit;
		$row_menu = $get_menu_arr->row_array();
		
		if($row_menu['parent_id'] == 0)
			return $row_menu;
		else
			return $this->mod_menu->get_menu_root_parent($row_menu['parent_id']);
			
	}//end get_menu_root_parent
	

	//Create menu Herachy Chain 
	public function create_menu_chain($menu_id){
		
		global $chain_str;

		$this->db->dbprefix('menus');
		$this->db->select('id,parent_id, menu_name');
		$this->db->where('id',$menu_id);

		$get_menu_arr = $this->db->get('menus');
		$row_menu = $get_menu_arr->row_array();
		
		//echo $this->db->last_query();

		$chain_str[] =  $row_menu['menu_name'];
		
		if($row_menu['parent_id'] == 0){
			$reverse_chain = array_reverse($chain_str);
			$chain_str = array(); //clear the global variable;
			$creating_chain = implode(' > ',$reverse_chain);
			
			return $creating_chain;
			
		}else
			return $this->create_menu_chain($row_menu['parent_id']);
		
		//end if($row_menu['parent_id'] == 0)

	}//end create_menu_chain
	
	//Filter Grid for Manage menus
	public function get_filter_menu_grid_data(){
		
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		* you want to insert a non-database field (for example a counter or static image)
		*/
        $aColumns = array('menu_name','menu_position','status','display_order','id','slug_menu');
        
        // DB table to use
        $sTable = 'menus';
        //
    
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);
    
        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        
        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);
    
                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }
        
				/*
		* Filtering
		* NOTE this does not match the built-in DataTables filtering which does it
		* word by word on any field. It's possible to do here, but concerned about efficiency
		* on very large tables, and MySQL's regex functionality is very limited
		*/
        if(isset($sSearch) && !empty($sSearch))
        {
            for($i=0; $i<count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
                
                // Individual column filtering
                if(isset($bSearchable) && $bSearchable == 'true')
                {
                    $this->db->or_like($aColumns[$i], $sSearch);
                }
            }
        }


        // Select Data
        $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumns)), false);
		$this->db->order_by('created_date','DESC');
		$this->db->dbprefix($sTable);
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
		$this->db->dbprefix($sTable);
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
    
        // Total data set length
        $iTotal = $this->db->count_all($sTable);

    
        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
        foreach($rResult->result_array() as $aRow){
            $row = array();
            $option_html = '';
            foreach($aColumns as $col){
				
				/*
				if($col == 'created_date'){
					 $row[] = date('d, M Y', strtotime($aRow[$col]));
				}
				*/
				if($col == 'menu_name'){
					
					 //$menu_chain = $this->mod_menu->create_menu_chain($aRow[$col]);
					 //$row[] = $menu_parent_arr['menu_name'];
					 $menu_chain = stripslashes($this->mod_menu->create_menu_chain($aRow['id']));
					 $row[] = $menu_chain;
				
				}
				/*elseif($col == 'root_parent_id'){
					
					 $menu_parent_arr = $this->mod_menu->get_menu_root_parent($aRow[$col]);
					 $row[] = $menu_parent_arr['menu_name'];
				
				}*/
				elseif($col == 'status'){
					
					$row[] = ($aRow[$col] == 1) ? '<a herf="#"><span class="label btn-success">Active</span></a>' : '<span class="label btn-danger">InActive</span>';

				}elseif($col == 'id'){
					$option_html .= '<div class="btn-group">';
					if(in_array(10,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."menu/manage-menu/edit-menu/".$aRow['id']." type='button' class='btn btn-info btn-gradient'> <span class='glyphicons glyphicons-edit'></span> </a>";
					}//end if
					
					#########################################
					##									  ###
					##		edit content tab here		  ###
					##									  ###
					#########################################
					#########################################
					#########################################
					
					if(in_array(10,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."menu/manage-menu/edit-content/".$aRow['slug_menu']." type='button' class='btn btn-info btn-gradient' \"> <span class='glyphicon glyphicon-list-alt'></span> </a>";
					}//end if
					
					if(in_array(10,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."menu/manage-menu/delete-menu/".$aRow['id']." type='button' class='btn btn-danger btn-gradient' onClick=\"return confirm('Are you sure you want to delete?')\"> <span class='glyphicons glyphicons-remove'></span> </a>";
					}//end if
					
					
					 $option_html .= '</div>';
					$row[] = $option_html;
					
				}
				else
				$row[] = $aRow[$col];
            }
    
            $output['aaData'][] = $row;
        }

		
        echo json_encode($output);
    }//end get_filter_menu_grid_data
	
	//Add New menu
	public function add_new_menu($data){
		
		extract($data);
		// slug for navigatoin
		$slug = strtolower(url_title($this->input->post('menu_name'), 'dash', TRUE));
		
		#############################################
		##inserting the slug in content pages table## 
		#############################################
		$content_page_data = array(
			'page_title' => $this->input->post('menu_name'),
			'slug_menu' =>$slug 
		);
		$this->db->insert('kt_pages',$content_page_data);
		#############################################
	    $generate_seo_url = $this->mod_common->generate_seo_url(trim($menu_name));
		
		 $verified_seo_url = $this->mod_common->verify_seo_url($generate_seo_url,'menus','seo_url_name',0);
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		
		if($menu_url=='')
		{
			$final_menu_url= base_url('../content/view');
		    
		}
		else
		{
			 $final_menu_url= $menu_url;
		   
		}
		
		$ins_data = array(
		   'menu_name' => $this->db->escape_str(trim($menu_name)),
		   'parent_id' => $this->db->escape_str(trim($parent_id)),
		   'menu_position' => $this->db->escape_str(trim(implode(',', $data['position_id']))),
		   'slug_menu' => $this->db->escape_str(trim($slug)),
		   
		   'menu_url' => $this->db->escape_str(trim($final_menu_url)),
		   'menu_description' => $this->db->escape_str(trim($menu_description)),
		   'meta_title' => $this->db->escape_str(trim($meta_title)),
		   'meta_keywords' => $this->db->escape_str(trim($meta_keywords)),
		   'meta_description' => $this->db->escape_str(trim($meta_description)) ,
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		   'seo_url_name' => $this->db->escape_str(trim($verified_seo_url)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		);
		
		//Insert the record into the database.
		$this->db->dbprefix('menus');
		$ins_into_db = $this->db->insert('menus', $ins_data);
		//echo $this->db->last_query(); exit;
		
		//Updating Root Parent ID
		$last_inserted_id = $this->db->insert_id();

		if($parent_id == 0)
			$root_parent_id = $last_inserted_id;
		else{
			$root_parent_id_arr = $this->get_menu_root_parent($parent_id);
			$root_parent_id =  $root_parent_id_arr['id'];
		}
		//end if
		
		$upd_data = array(
		   'root_parent_id' => $this->db->escape_str(trim($root_parent_id))
			);
		//Update the record into the database.
		$this->db->dbprefix('menus');
		$this->db->where('id', $last_inserted_id);
		$upd_into_db = $this->db->update('menus', $upd_data);
		//echo $this->db->last_query(); exit;
			
		if($ins_into_db && $upd_into_db) return true;

	}//end add_new_menu()




	//Edit menu
	public function edit_menu($data){
		
		extract($data);
		
		$slug = strtolower(url_title($this->input->post('menu_name'), 'dash', TRUE));
		
		$generate_seo_url = $this->mod_common->generate_seo_url(trim($menu_name));
		$verified_seo_url = $this->mod_common->verify_seo_url($generate_seo_url,'menus','seo_url_name',$menu_id);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'menu_name' => $this->db->escape_str(trim($menu_name)),
		   'parent_id' => $this->db->escape_str(trim($parent_id)),
		   'menu_position' => $this->db->escape_str(trim(implode(',', $data['position_id']))),
		   'slug_menu' => $this->db->escape_str(trim($slug)),
		   'menu_url' => $this->db->escape_str(trim($menu_url)),
		   'menu_description' => $this->db->escape_str(trim($menu_description)),
		   'meta_title' => $this->db->escape_str(trim($meta_title)),
		   'meta_keywords' => $this->db->escape_str(trim($meta_keywords)),
		   'meta_description' => $this->db->escape_str(trim($meta_description)) ,
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		   'seo_url_name' => $this->db->escape_str(trim($verified_seo_url)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))

		);

		//Insert the record into the database.
		$this->db->dbprefix('menus');
		$this->db->where('id',$menu_id);
		$upd_into_db = $this->db->update('menus', $upd_data);
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db){

			//Updating Root Parent ID
			$last_inserted_id = $menu_id;
			
			if($parent_id == 0)
				$root_parent_id = $last_inserted_id;
			else{
				$root_parent_id_arr = $this->get_menu_root_parent($parent_id);
				$root_parent_id =  $root_parent_id_arr['id'];
			}//end if
			
			$upd_data = array(
			   'root_parent_id' => $this->db->escape_str(trim($root_parent_id))
				);
				
			//Update the record into the database.
			$this->db->dbprefix('menus');
			$this->db->where('id', $last_inserted_id);
			$upd_into_db1 = $this->db->update('menus', $upd_data);
			//echo $this->db->last_query(); exit;
			
			if($upd_into_db1) return true;
			
		}//end if($upd_into_db)
		
	}//end edit_menu()

	//Delete menu
	public function delete_menu($menu_id){
		
		//Delete the record from the database.
		$this->db->dbprefix('menus');
		$this->db->where('id',$menu_id);
		$del_into_db = $this->db->delete('menus');
		//$this->db->last_query();
		
		if($del_into_db) return true;

	}//end delete_menu()
					#########################################
					##									  ###
					##		edit content data from 		  ###
					##				db					  ###
					#########################################
					#########################################
					#########################################
	//Get All CMS pages.
	public function get_all_cms_pages(){
		
		$this->db->dbprefix('pages');
		$this->db->order_by('id DESC');
		$get_cms_pages = $this->db->get('pages');

		//echo $this->db->last_query();
		$row_cms['cms_pages_arr'] = $get_cms_pages->result_array();
		$row_cms['cms_pages_count'] = $get_cms_pages->num_rows;
		return $row_cms;
		
	}//end get_all_cms_pages

	//Get CMS Page Record
	public function get_cms_page($page_id){
		
		
		$this->db->dbprefix('pages');
		$this->db->where('slug_menu',$page_id);
		$get_cms_page = $this->db->get('pages');

		//echo $this->db->last_query();
		$row_cms['cms_page_arr'] = $get_cms_page->row_array();
		$row_cms['cms_page_count'] = $get_cms_page->num_rows;
		
		/*echo '<pre>';
		print_r($row_cms['cms_page_arr']);
		
		exit;*/
		
		return $row_cms;
		
	}//end get_all_cms_pages
	
	public function update_content($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('kt_pages',$data);
	}
	public function delete_content($id)
	{
		$this->db->where('id',$id);
		$slug = $this->db->get('kt_menus')->result_array();
		
		$id = $slug[0]['slug_menu'];
		
		$this->db->where('slug_menu',$id);
		$data = $this->db->delete('kt_pages');
	}
	#######################################################
	##													 ##			
	##													 ##
	##               Top header menu bar			     ##				
	##													 ##
	##													 ##
	#######################################################
	public function get_header_menus()
	{
		return $this->db->get('kt_header_menu')->result_array();
	}
	public function get_data_where($select_field, $tablename, $where_fieldname, $where_fieldvalue)
	{
		$this->db->select($select_field);
		$this->db->where($where_fieldname,$where_fieldvalue);
		return $this->db->get($tablename)->result_array();
	}
	public function update_where($where_fieldname,$where_fieldvalue,$tablename,$data){
			$this->db->where($where_fieldname,$where_fieldvalue);
			$this->db->update($tablename,$data);
	}
}
?>