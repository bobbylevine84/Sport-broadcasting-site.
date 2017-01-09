<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_User extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('users/mod_user');
		$this->load->model('common/mod_common');
		
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		//Login Check
		$this->mod_user->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(7,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Active User', base_url().'users/manage_user');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);

		//Permissions
		$data['ALLOW_user_edit'] =   (in_array(9,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(10,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		$get_active_users = $this->mod_user->get_active_users();
		//$get_admin_user = $this->mod_admin->get_admin_users_limit($page,$config["per_page"]);
		$data['active_user'] = $get_active_users;

		$this->load->view('users/manage_users_active',$data);
			
	}//end index()
	public function manage_inactive_user(){
		
		//Login Check
		$this->mod_user->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(7,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage InActive User', base_url().'users/manage_user');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);

		//Permissions
		$data['ALLOW_user_edit'] =   (in_array(9,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(10,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
	
		
		$get_inactive_users = $this->mod_user->get_inactive_users();
		$data['inactive_user'] = $get_inactive_users;

		$this->load->view('users/manage_users_inactive',$data);
			
	}
        
        public function add_amount() {
            //Login Check
            $this->mod_user->verify_is_admin_login();
            
            $id = $this->input->post("id");
            $amount = $this->input->post("amount");
            $type = $this->input->post("type");
            
            $this->db->select('amount')->where('user_id', $id);
            $user_amount = $this->db->get('kt_sg_wallet')->result_array();
            $new_amount = $user_amount[0]['amount'] + $amount;
            
            $amount_array = array(
                'amount'	=> $new_amount,
            );
            $this->db->where('user_id', $id);
            $this->db->update('kt_sg_wallet', $amount_array);
            
            $transaction = array(
                "transaction_type" => "deposit",
                "user_id_fk" => $id,
                "amount" => $amount,
                "reason" => "Added by admin",
            );
            $this->db->insert("kt_sg_transactions", $transaction);
            
            $this->db->select('amount')->where('user_id', 0);
            $amount_admin = $this->db->get('kt_sg_wallet')->result_array();
            $updated = $amount_admin[0]['amount'] + $amount;
            
            $updated_array = array(
                'amount' => $updated
            );
            
            $this->db->where('user_id', 0);
            $this->db->update('kt_sg_wallet', $updated_array);
            
            $this->session->set_flashdata('ok_message','Amount added Successfully!');
            if($type == "active") {
                redirect(base_url('users/manage_user/'));
            }else if($type == "inactive") {
                redirect(base_url('users/manage_user/manage_inactive_user'));                
            }else if($type == "banned") {
                redirect(base_url('users/manage_user/manage_banned_user'));    
            }
        }
        
	public function manage_banned_user(){
		
		//Login Check
		$this->mod_user->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(7,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Banned User', base_url().'users/manage_user');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);

		//Permissions
		$data['ALLOW_user_edit'] =   (in_array(9,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(10,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		
		$get_banned_users = $this->mod_user->get_banned_users();
		$data['banned_user'] = $get_banned_users;


		$this->load->view('users/manage_users_banned',$data);
			
	}//end index()
	public function get_record()
	{
      $type=$this->input->post('data');
	   $status=$this->input->post('status');
	  $res=$this->mod_user->get_record($type,$status);
	  if($res)
	  {
		  echo json_encode($res);
		  exit;
	  }
	 

	}
	public function delete_user($val=null,$tab=null)
	{
		if($val){
		$res=$this->mod_user->delete_user($val);
		if($res)
		{
			
			if($tab =='active')
			{
		     $this->session->set_flashdata('ok_message','User Deleted SuccessFully!');
		     redirect(base_url('users/manage_user/'));
			}elseif($tab =='inactive')
			{
				$this->session->set_flashdata('ok_message','User Deleted SuccessFully!');
		     redirect(base_url('users/manage_user/manage_inactive_user/'));
			}
			else{
				$this->session->set_flashdata('ok_message','User Deleted SuccessFully!');
		     redirect(base_url('users/manage_user/manage_banned_user/'));
			}
		}
		else{
			if($tab =='active')
			{
				$this->session->set_flashdata('err_message','User Cannot be Deleted ');
				redirect(base_url('users/manage_user/'));
			}elseif($tab =='inactive')
			{
				$this->session->set_flashdata('err_message','User Cannot be Deleted ');
				redirect(base_url('users/manage_user/manage_inactive_user/'));
			}
			else{
				$this->session->set_flashdata('err_message','User Cannot be Deleted ');
				redirect(base_url('users/manage_user/manage_banned_user/'));
			}
			
		}
		
		}
		else
		{
			$this->session->set_flashdata('err_message','User Cannot be Deleted. Something went wrong');
			redirect(base_url('users/manage_user/manage_banned_user/'));	
		}
		
	 

	}
		public function edit_user($val=null,$val1=null){
		//Login Check
		
		$this->mod_user->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(7,$this->session->userdata('permissions_arr'))){
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
		if($val1=="active"){
			$this->breadcrumbcomponent->add('Manage Active User', base_url().'users/manage_user');
		}
		elseif($val1=="inactive"){
			$this->breadcrumbcomponent->add('Manage InActive User', base_url().'users/manage_user/manage_inactive_user');
		}else
		{
			$this->breadcrumbcomponent->add('Manage Banned User', base_url().'users/manage_user/manage_banned_user');
		}
		$this->breadcrumbcomponent->add('Edit User', base_url().'users/manage_user/edit_user');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);

		//Permissions
		$data['ALLOW_user_edit'] =   (in_array(9,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(10,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
	
		$data['page']=$val1;
		$get_users = $this->mod_user->get_record_by_id($val);
		$data['user_record'] = $get_users;

		$data['countries'] = $this->mod_user->get_countries();
		$data['states'] = $this->mod_user->get_states();

		$this->load->view('users/edit_user',$data);
			
	}
	public function edit_process()
	{
		$val = $this->input->post('front_user_id');
		$page = $this->input->post('page');
		$username=$this->input->post('user_name');
		$check=$this->mod_user->check_username_exist($username,$val);
		if($check>0){
			
			if($page=="active"){
					$this->session->set_flashdata('err_message', 'Username is already exist.');
                        redirect('users/manage-user/');
				}
				elseif($page=="inactive"){
					$this->session->set_flashdata('err_message', 'Username is already exist.');
                    redirect('users/manage-user/manage_inactive_user/');
				}
				else
				{
					$this->session->set_flashdata('err_message', 'Username is already exist.');
                    redirect('users/manage-user/manage_banned_user/');
				}
		}
		$this->form_validation->set_rules('first_name','First Name');
		$this->form_validation->set_rules('middle_name','Middle Name');
		$this->form_validation->set_rules('last_name','Last Name');
		$this->form_validation->set_rules('email','Email');
		$this->form_validation->set_rules('mobile_number','Phone');
		$this->form_validation->set_rules('dob','Date Of Birth');
		$this->form_validation->set_rules('address','Address');
		$this->form_validation->set_rules('state','State');
		$this->form_validation->set_rules('country','Country');
		$this->form_validation->set_rules('user_name','User Name');
		$this->form_validation->set_rules('status','Status');
		
		if($this->form_validation->run()==False)
		{
			$this->edit_user($val);
		}else{
			
			$new_data = array(
				'first_name' => $this->input->post('first_name'),
				'middle_name' => $this->input->post('middle_name'),
				'last_name' => $this->input->post('last_name'),
				'email_address' => $this->input->post('email'),
				'mobile_number' => $this->input->post('mobile_number'),
				'date_of_birth' => $this->input->post('dob'),
				'front_user_address' => $this->input->post('address'),
				//'state' => $this->input->post('state'),
				//'country' => $this->input->post('country'),
				'user_name' => $this->input->post('user_name'),
				'front_user_flag' => $this->input->post('status'),
			);
			//echo $val;
			//echo '<pre>';
			//print_r($new_data);exit;
			$res=$this->mod_user->update_user_data($new_data,$val);
			if($res)
			{
				if($page=="active"){
					$this->session->set_flashdata('ok_message', 'User Updated successfully');
                        redirect('users/manage-user/');
				}
				elseif($page=="inactive"){
					$this->session->set_flashdata('ok_message', 'User Updated successfully');
                        redirect('users/manage-user/manage_inactive_user/');
				}
				else
				{
					$this->session->set_flashdata('ok_message', 'User Updated successfully');
                        redirect('users/manage-user/manage_banned_user/');
				}
			}
			else{
				
				
				if($page=="active"){
					$this->session->set_flashdata('err_message', 'User cannot be updated. Something went wrong.');
                        redirect('users/manage-user/');
				}
				elseif($page=="inactive"){
					$this->session->set_flashdata('err_message', 'User cannot be updated. Something went wrong.');
                        redirect('users/manage-user/manage_inactive_user/');
				}
				else
				{
					$this->session->set_flashdata('err_message', 'User cannot be updated. Something went wrong.');
                        redirect('users/manage-user/manage_banned_user/');
				}
				
			}
			
		}
	}
	public function approve_multiple_records()
	{
		$button=$this->input->post('reject');
		$button1=$this->input->post('inactive');
		$button2=$this->input->post('active');
		$page=$this->input->post('page');
		$selected_records=$this->input->post('selected');
		if (!empty($selected_records)) {
		if($button =="Delete Selected"){
            $count = count($selected_records);
            $loop_count = 1;
            foreach ($selected_records as $one) {
                $query = $this->mod_user->delete_user($one);
                if ($query) {
                    if ($count == $loop_count) {
						if($page=="active_page"){
                        $this->session->set_flashdata('ok_message', 'Deleted successfully');
                        redirect('users/manage-user/');
						}elseif($page=="inactive_page"){
							$this->session->set_flashdata('ok_message', 'Deleted successfully');
                        redirect('users/manage-user/manage_inactive_user/');
						}
						else{
							$this->session->set_flashdata('ok_message', 'Deleted successfully');
                        	redirect('users/manage-user/manage_banned_user/');
						}
                    }
                } else {
					if($page=="active_page"){
	                        $this->session->set_flashdata('err_message', 'Something went wrong. Please try again.');
	                        redirect('users/manage-user/');
						}elseif($page=="inactive_page"){
							$this->session->set_flashdata('err_message', 'Something went wrong. Please try again.');
	                        redirect('users/manage-user/manage_inactive_user/');
						}
						else{
							$this->session->set_flashdata('err_message', 'Something went wrong. Please try again.');
                        	redirect('users/manage-user/manage_banned_user/');
						}
                }
                $loop_count++;

			   
            }
	
		}elseif($button1 =="InActive Selected"){
			
			$status='inactive';
            $count = count($selected_records);
            $loop_count = 1;
            foreach ($selected_records as $one) {
                $query = $this->mod_user->inactive_user($one,$status);
                if ($query) {
                    if ($count == $loop_count) {
                        if($page=="active_page"){
	                        $this->session->set_flashdata('ok_message', 'InActive successfully');
	                        redirect('users/manage-user/');
						}elseif($page=="inactive_page"){
							$this->session->set_flashdata('ok_message', 'InActive successfully');
                        	redirect('users/manage-user/manage_inactive_user/');
						}
						else{
							$this->session->set_flashdata('ok_message', 'InActive successfully');
                        	redirect('users/manage-user/manage_banned_user/');
						}
                    }
                } else {
                    if($page=="active_page"){
	                        $this->session->set_flashdata('err_message', 'Something went wrong. Please try again.');
	                        redirect('users/manage-user/');
						}elseif($page=="inactive_page"){
							$this->session->set_flashdata('err_message', 'Something went wrong. Please try again.');
	                        redirect('users/manage-user/manage_inactive_user/');
						}
						else{
							$this->session->set_flashdata('err_message', 'Something went wrong. Please try again.');
                        	redirect('users/manage-user/manage_banned_user/');
						}
                }
                $loop_count++;

			   
            }
			
		}
		elseif($button2 =="Active Selected"){
			
			$status='active';
            $count = count($selected_records);
            $loop_count = 1;
            foreach ($selected_records as $one) {
                $query = $this->mod_user->active_user($one,$status);
                if ($query) {
                    if ($count == $loop_count) {
                        if($page=="active_page"){
                        $this->session->set_flashdata('ok_message', 'Active successfully');
                        redirect('users/manage-user/');
						}elseif($page=="inactive_page"){
							$this->session->set_flashdata('ok_message', 'Active successfully');
                        redirect('users/manage-user/manage_inactive_user/');
						}
						else{
							$this->session->set_flashdata('ok_message', 'Active successfully');
                        redirect('users/manage-user/manage_banned_user');
						}
                    }
                } else {
                   if($page=="active_page"){
                        $this->session->set_flashdata('err_message', 'Something went wrong. Please try again.');
                        redirect('users/manage-user/');
						}elseif($page=="inactive_page"){
						$this->session->set_flashdata('err_message', 'Something went wrong. Please try again.');
                        redirect('users/manage-user/manage_inactive_user/');
						}
						else{
							$this->session->set_flashdata('err_message', 'Something went wrong. Please try again.');
                        redirect('users/manage-user/manage_banned_user/');
						}
                }
                $loop_count++;

			   
            }
			
		}
		else{
			$status='banned';
            $count = count($selected_records);
            $loop_count = 1;
            foreach ($selected_records as $one) {
                $query = $this->mod_user->banned_user($one,$status);
                if ($query) {
                    if ($count == $loop_count) {
                         if($page=="active_page"){
                        $this->session->set_flashdata('ok_message', 'Banned successfully');
                        redirect('users/manage-user/');
						}elseif($page=="inactive_page"){
							$this->session->set_flashdata('ok_message', 'Banned successfully');
                        redirect('users/manage-user/manage_inactive_user/');
						}
						else{
							$this->session->set_flashdata('ok_message', 'Banned successfully');
                        redirect('users/manage-user/manage_banned_user/');
						}
                    }
                } else {
                   if($page=="active_page"){
                        $this->session->set_flashdata('err_message', 'Something went wrong. Please try again.');
                        redirect('users/manage-user/');
						}elseif($page=="inactive_page"){
						$this->session->set_flashdata('err_message', 'Something went wrong. Please try again.');
                        redirect('users/manage-user/manage_inactive_user/');
						}
						else{
							$this->session->set_flashdata('err_message', 'Something went wrong. Please try again.');
                        redirect('users/manage-user/manage_banned_user/');
						}
                }
                $loop_count++;

			   
            }
			
		}
		}
		else{
			$this->session->set_flashdata('err_message', 'No record is selected.');
            redirect('users/manage-user/');
		}
	}

	

}//end Dashboard 
