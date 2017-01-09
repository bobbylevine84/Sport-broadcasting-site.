<?php
class Manage extends CI_Controller
{
	public function __Construct()
	{
		parent::__Construct();
		$this->load->model('admin/mod_admin');
		
		$this->load->model('common/mod_common');
		$this->load->library('BreadcrumbComponent');
		$this->load->library('image_lib');
		$this->load->model('console/console_handler', 'consoles');
	}
	
	public function index()
	{
	//echo 'i am consumer/manage/index';
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(25,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;
		
		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('Manage Consoles', base_url().'console/manage');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		////////////////////////////////////
		
		$data['all_consoles'] = $this->consoles->fetch_all_consoles();
		
		
		
		$this->load->view('console/manage',$data);
	}

	/*ADD NEW CONSOLE*/
	public function add_console(){

		$result = $this->consoles->add_console($this->input->post('name'));

		if($result){
			echo '<b>'.$this->input->post('name').'</b> Console has been added';
		}else{
			echo 'Some problems occurs ... please try back latter';
		}
	}

	/*EDIT CONSOLE */
	public function edit_console(){
		$console_name = $this->consoles->get_console_name($this->input->post('consoleId'));

		if($console_name[0]['console_name'] != ''){
			echo $console_name[0]['console_name'];
		}else{
			echo 'Some problem occurs ... try back later';
		}
	}

	/*POST EDIT CONSOLE DATA*/
	public function post_edit_console(){

		$result = $this->consoles->edit_console_name($this->input->post('name'), $this->input->post('consoleId'));
		if($result){
			echo 'Console name has been updated to : <b> ' .$this->input->post('name') . '</b>';
		}else{
			echo 'Some problems occurs ... please try back latter';
		}

	}

	/*DELETE CONSOLE*/
	public function delete_console(){

		$result = $this->consoles->delete_console($this->input->post('id'));

		if($result){
			echo '<b>'.$this->input->post('name').'</b> Console has been deleted';
		}else{
			echo 'Some problems occurs ... please try back latter';
		}

	}

	/*SHOW GAMES IN CONSOLE */
	public function console_games(){

		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(25,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;
		
		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('Console games', base_url().'console/manage');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		////////////////////////////////////
		
		$data['console_games'] = $this->consoles->console_games($this->uri->segment(4));
		$data['consoles_id'] = $this->uri->segment(4);
		$console_name = $this->consoles->get_console_name($this->uri->segment(4));
		$data['console_name'] = $console_name[0]['console_name'];
		
		$this->load->view('console/console_detail',$data);



	}

	/*ADD NEW GAME TO CONSOLE*/
	public function add_game(){
		

		if($this->input->post('gameName') == '' || $this->input->post('gameType') == ''){
			echo 0;
		}else{

			$upload_res = $this->upload_it('gameImages');

			$game_data = array(
					'console_id'	=> $this->input->post('console_id'),
					'game_name'		=> $this->input->post('gameName'),
					'game_type'		=> $this->input->post('gameType')
				);

				$result = $this->consoles->add_game($game_data);
				if($result){
					echo '<b>'.$this->input->post('gameName').'</b> is added to Console ';
				}else{
					echo 'Some problems occurs ... please try back latter';
				}

			
			
		}
	}

	/*UPDATE GAME DETAILS TO COINSOLE*/
	public function edit_game(){

		$game_details = $this->consoles->get_game_details($this->input->post('gameId'));

		echo json_encode($game_details[0]);

		
	}


	public function post_edit_game(){
		if($this->input->post('editgameName') == '' || $this->input->post('editgameType') == '' ){
			echo 0;
		}else{

			$game_data = array();
			
			if($_FILES['editgameImages'] != ''){
				
				$upload_res = $this->upload_it('editgameImages');

				if($upload_res['msg'] == 'Upload success !'){
					$data = array('msg' => "Upload success !");
					
					$data['upload_data'] = $this->upload->data();
					
					
						$game_data['game_name']		= $this->input->post('editgameName');
						$game_data['game_type']		= $this->input->post('editgameType');
						$game_data['game_image']	= $data['upload_data']['file_name'];
				

					

				}else{
				
					echo $this->upload->display_errors();
					
				}
			
			}else{
				/*IF USER DIDNT SELECT IMAGE*/
				
					$game_data['game_name']		= $this->input->post('editgameName');
					$game_data['game_type']		= $this->input->post('editgameType');
			

				
			}

			$result = $this->consoles->edit_game($game_data, $this->input->post('edit_game_id'));
				
				if($result){
					echo 'Game Updated succesfully ';
				}else{
					echo 'Some problems occurs ... please try back latter';
				}

			
		}
	}

	/*DELETE GAME FROM CONSOLE*/
	public function delete_game(){

		$result = $this->consoles->delete_game($this->input->post('id'));

		if($result){
			echo 'Game has been deleted';
		}else{
			echo 'Some problems occurs ... please try back latter';
		}
	}

	

	public function upload_it($fieldname) {
	 
		$data =NULL;
		//Configure
		//set the path where the files uploaded will be copied. NOTE if using linux, set the folder to permission 777
		$config['upload_path'] = 'uploads/game_images';
		//echo $config['upload_path'];exit;
   	 	// set the filter image types
		$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
		$config['max_size']	= '5000';
		//$config['max_width'] = '1170';
        //$config['max_height'] = '223';
		
		//$config['file_name'] = $this->image_name();
		
		//load the upload library
		$this->load->library('upload', $config);
    
    	$this->upload->initialize($config);
    
    	$this->upload->set_allowed_types('*');

		$data['upload_data'] = '';
    
		//if not successful, set the error message
		if (!$this->upload->do_upload($fieldname)) {
			$data = array('msg' => $this->upload->display_errors());
			

		} else { //else, set the success message
			$data = array('msg' => "Upload success !");
      		
      		$data['upload_data'] = $this->upload->data();
		}
		return $data; 
	}


}