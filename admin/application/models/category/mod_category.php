<?php
class mod_category extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Get All Categories
	public function get_all_categories(){
		
		$this->db->dbprefix('categories');
		$this->db->order_by('id DESC');
		$get_all_categories = $this->db->get('categories');

		//echo $this->db->last_query();
		$row_category['category_list_arr'] = $get_all_categories->result_array();
		$row_category['category_list_count'] = $get_all_categories->num_rows;
		
		for($i=0;$i<$row_category['category_list_count'];$i++){
			
			$category_id = $row_category['category_list_arr'][$i]['id'];
			$create_category_chain = $this->mod_category->create_category_chain($category_id);
			$row_category['category_list_arr'][$i]['category_chain'] = $create_category_chain;
			
		}//end for
		
		return $row_category;
		
	}//end get_all_cms_pages

	//Get All Categories Count
	public function get_all_categories_count(){
		
		$this->db->dbprefix('categories');
		return $this->db->count_all("categories");
		
	}//end get_all_categories_count

	//Get Categofy Record by ID
	public function get_category($cat_id){
		
		$this->db->dbprefix('categories');
		$this->db->where('id',$cat_id);
		$get_category = $this->db->get('categories');

		//$this->db->last_query(); exit;
		
		$row_category['category_arr'] = $get_category->row_array();
		$row_category['category_arr_count'] = $get_category->num_rows;
		
		return $row_category;
		
	}//end get_category
	
	//Check if Category exist against the selected Parent Id. If Nowt.. proceed
	public function check_if_category_exist($category_name,$parent_id,$exclude_self){
		
		$this->db->dbprefix('categories');
		$this->db->select('id');
		$this->db->from('categories');
		if($exclude_self != 0) $this->db->where('id !=', strip_quotes($exclude_self));
		$this->db->where('category_name', strip_quotes($category_name));
		$this->db->where('parent_id', strip_quotes($parent_id));
		
		$count_result = $this->db->count_all_results();

		//echo $this->db->last_query(); 		exit;
		
		return $count_result;

	}//end check_if_category_exist

	//Get Category Root Parent
	public function get_category_root_parent($cat_id){
		
		$this->db->dbprefix('categories');
		$this->db->where('id',$cat_id);
		$get_category_arr = $this->db->get('categories');

		//echo $this->db->last_query(); exit;
		$row_category = $get_category_arr->row_array();
		
		if($row_category['parent_id'] == 0)
			return $row_category;
		else
			return $this->mod_category->get_category_root_parent($row_category['parent_id']);
			
	}//end get_category_root_parent
	

	//Create Category Herachy Chain 
	public function create_category_chain($cat_id){
		
		global $chain_str;

		$this->db->dbprefix('categories');
		$this->db->select('id,parent_id, category_name');
		$this->db->where('id',$cat_id);

		$get_category_arr = $this->db->get('categories');
		$row_category = $get_category_arr->row_array();
		
		//echo $this->db->last_query();

		$chain_str[] =  $row_category['category_name'];
		
		if($row_category['parent_id'] == 0){
			$reverse_chain = array_reverse($chain_str);
			$chain_str = array(); //clear the global variable;
			$creating_chain = implode(' > ',$reverse_chain);
			
			return $creating_chain;
			
		}else
			return $this->create_category_chain($row_category['parent_id']);
		
		//end if($row_category['parent_id'] == 0)

	}//end create_category_chain
	
	//Filter Grid for Manage Categories
	public function get_filter_category_grid_data(){
		
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		* you want to insert a non-database field (for example a counter or static image)
		*/
        $aColumns = array('category_name','status','display_order','id');
        
        // DB table to use
        $sTable = 'categories';
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
            foreach($aColumns as $col)
            {
				/*
				if($col == 'created_date'){
					 $row[] = date('d, M Y', strtotime($aRow[$col]));
				}
				*/
				if($col == 'category_name'){
					
					 //$category_chain = $this->mod_category->create_category_chain($aRow[$col]);
					 //$row[] = $category_parent_arr['category_name'];
					 $category_chain = stripslashes($this->mod_category->create_category_chain($aRow['id']));
					 $row[] = $category_chain;
				
				}
				/*elseif($col == 'root_parent_id'){
					
					 $category_parent_arr = $this->mod_category->get_category_root_parent($aRow[$col]);
					 $row[] = $category_parent_arr['category_name'];
				
				}*/
				elseif($col == 'status'){
					
					$row[] = ($aRow[$col] == 1) ? '<span class="label btn-success">Active</span>' : '<span class="label btn-danger">InActive</span>';

				}elseif($col == 'id'){
					$option_html .= '<div class="btn-group">';
					if(in_array(22,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."category/manage-category/edit-category/".$aRow['id']." type='button' class='btn btn-info btn-gradient'> <span class='glyphicons glyphicons-edit'></span> </a>";
					}//end if
					
					if(in_array(23,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."category/manage-category/delete-category/".$aRow['id']." type='button' class='btn btn-danger btn-gradient' onClick=\"return confirm('Are you sure you want to delete?')\"> <span class='glyphicons glyphicons-remove'></span> </a>";
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
    }//end get_filter_category_grid_data
	
	//Add New Category
	public function add_new_category($data){
		
		extract($data);
		$generate_seo_url = $this->mod_common->generate_seo_url(trim($category_name));
		$verified_seo_url = $this->mod_common->verify_seo_url($generate_seo_url,'categories','seo_url_name',0);
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		
		$ins_data = array(
		   'category_name' => $this->db->escape_str(trim($category_name)),
		   'parent_id' => $this->db->escape_str(trim($parent_id)),
		   'category_description' => $this->db->escape_str(trim($category_description)),
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
		$this->db->dbprefix('categories');
		$ins_into_db = $this->db->insert('categories', $ins_data);
		//echo $this->db->last_query(); exit;
		
		//Updating Root Parent ID
		$last_inserted_id = $this->db->insert_id();

		if($parent_id == 0)
			$root_parent_id = $last_inserted_id;
		else{
			$root_parent_id_arr = $this->get_category_root_parent($parent_id);
			$root_parent_id =  $root_parent_id_arr['id'];
		}
		//end if
		
		$upd_data = array(
		   'root_parent_id' => $this->db->escape_str(trim($root_parent_id))
			);
		//Update the record into the database.
		$this->db->dbprefix('categories');
		$this->db->where('id', $last_inserted_id);
		$upd_into_db = $this->db->update('categories', $upd_data);
		//echo $this->db->last_query(); exit;
			
		if($ins_into_db && $upd_into_db) return true;

	}//end add_new_category()

	//Edit Category
	public function edit_category($data){
		
		extract($data);
		$generate_seo_url = $this->mod_common->generate_seo_url(trim($category_name));
		$verified_seo_url = $this->mod_common->verify_seo_url($generate_seo_url,'categories','seo_url_name',$cat_id);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'category_name' => $this->db->escape_str(trim($category_name)),
		   'parent_id' => $this->db->escape_str(trim($parent_id)),
		   'category_description' => $this->db->escape_str(trim($category_description)),
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
		$this->db->dbprefix('categories');
		$this->db->where('id',$cat_id);
		$upd_into_db = $this->db->update('categories', $upd_data);
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db){

			//Updating Root Parent ID
			$last_inserted_id = $cat_id;
			
			if($parent_id == 0)
				$root_parent_id = $last_inserted_id;
			else{
				$root_parent_id_arr = $this->get_category_root_parent($parent_id);
				$root_parent_id =  $root_parent_id_arr['id'];
			}//end if
			
			$upd_data = array(
			   'root_parent_id' => $this->db->escape_str(trim($root_parent_id))
				);
				
			//Update the record into the database.
			$this->db->dbprefix('categories');
			$this->db->where('id', $last_inserted_id);
			$upd_into_db1 = $this->db->update('categories', $upd_data);
			//echo $this->db->last_query(); exit;
			
			if($upd_into_db1) return true;
			
		}//end if($upd_into_db)
		
	}//end edit_category()

	//Delete Category
	public function delete_category($cat_id){
		
		//Delete the record from the database.
		$this->db->dbprefix('categories');
		$this->db->where('id',$cat_id);
		$del_into_db = $this->db->delete('categories');
		//$this->db->last_query();
		
		if($del_into_db) return true;

	}//end delete_page()
	
}
?>