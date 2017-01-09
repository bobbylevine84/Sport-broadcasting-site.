<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_custom extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		//$this->load->model('sponsor/mod_sponsor');
		$this->load->model('common/mod_common');
		$this->load->model('event/mod_event');
		//$this->load->library('image_lib');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(99,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage event', base_url().'event/manage-event');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(37,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(38,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		
		$this->load->view('custom/manage_sport',$data);
	}
	public function manage_sport(){
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 1;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Sport Detail', base_url().'Custom/Sport Details');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		
		$this->load->view('custom/manage_sport',$data);
	}

		public function manage_sports_highlights(){
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 1;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Sports Highlights Detail', base_url().'Custom/Sport Details');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		
		$this->load->view('custom/manage_sports_highlights',$data);
	}
	public function get_data(){
		$sport_id = $this->input->post('sport_id');
		$sport1_id = $this->input->post('sport1_id');
		$event_id = $this->input->post('event_id');
		$h_id = $this->input->post('h_id');
		$c_id = $this->input->post('c_id');
		$n_id = $this->input->post('n_id');
		$team_id = $this->input->post('team_id');
		if($sport_id){
			$this->db->where('sport_id',$sport_id);
			$my_data = $this->db->get('kt_sport_custom_text')->result_array();
		}
		if($sport1_id){
			$this->db->where('sport_id',$sport1_id);
			$my_data = $this->db->get('kt_sports_highlights_custom_text')->result_array();
		}
		if($c_id){
			$this->db->where('competition_id',$c_id);
			$my_data = $this->db->get('kt_nation_custom_text_custom_text')->result_array();
		}
		if($n_id){
			$this->db->where('nation',$n_id);
			$my_data = $this->db->get('kt_nation_custom_text')->result_array();
		}
		if($team_id){
			$this->db->where('team_id',$team_id);
			$my_data = $this->db->get('kt_team_custom_text')->result_array();
		}
		if($event_id){
			$this->db->where('event_id',$event_id);
			$my_data = $this->db->get('kt_event_custom_text')->result_array();
		}
		if($h_id){
			$this->db->where('event_id',$h_id);
			$my_data = $this->db->get('kt_highlight_custom_text')->result_array();
		}
		
		
		
		echo json_encode($my_data);
		//echo "<pre>";print_r($sport_data);
	}
	public function custom_sport_process(){
		$id = $this->input->post('id');
		$sport_type_id = $this->input->post('sport_type');
		$title = $this->input->post('title');
		$keywords = $this->input->post('keywords');
		$description = $this->input->post('description');
		$text_type = $this->input->post('text');
		if($this->input->post('detail')){
			$article = $this->input->post('detail');
		} else {
			$article = $this->input->post('article');
		}
		
		$this->db->select('sport_id');
		$this->db->where('sport_id',$sport_type_id);
		$check = $this->db->get('kt_sport_custom_text')->num_rows();
		
		if($check > 0){
			$update_data = array (
				
				'title' => $title,
				'keywords' => $keywords,
				'description' => $description,
				'article' => $article
			);
			$this->db->where('sport_id',$sport_type_id);
			$update = $this->db->update('kt_sport_custom_text', $update_data); 
			if($update){
				redirect('custom/manage_custom/manage_sport');
			} else {
				echo "false";exit;
			}
		} else {
			$insert_data = array (
				'sport_id' => $sport_type_id,
				
				'title' => $title,
				'keywords' => $keywords,
				'description' => $description,
				'article' => $article
			);
			$insert = $this->db->insert('kt_sport_custom_text',$insert_data);
			if($insert){
				redirect('custom/manage_custom/manage_sport');
			}
		}
		
	}

		public function custom_sports_highlights_process(){
		$id = $this->input->post('id');
		$sport_type_id = $this->input->post('sport_type');
		$title = $this->input->post('title');
		$keywords = $this->input->post('keywords');
		$description = $this->input->post('description');
		$text_type = $this->input->post('text');
		if($this->input->post('detail')){
			$article = $this->input->post('detail');
		} else {
			$article = $this->input->post('article');
		}
		
		$this->db->select('sport_id');
		$this->db->where('sport_id',$sport_type_id);
		$check = $this->db->get('kt_sports_highlights_custom_text ')->num_rows();
		
		if($check > 0){
			$update_data = array (
				
				'title' => $title,
				'keywords' => $keywords,
				'description' => $description,
				'article' => $article
			);
			$this->db->where('sport_id',$sport_type_id);
			$update = $this->db->update('kt_sports_highlights_custom_text ', $update_data); 
			if($update){
				redirect('custom/manage_custom/manage_sports_highlights');
			} else {
				echo "false";exit;
			}
		} else {
			$insert_data = array (
				'sport_id' => $sport_type_id,
				'title' => $title,
				'keywords' => $keywords,
				'description' => $description,
				'article' => $article
			);
			$insert = $this->db->insert('kt_sports_highlights_custom_text',$insert_data);
			if($insert){
				redirect('custom/manage_custom/manage_sports_highlights');
			}
		}
		
	}
	public function manage_competition(){
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 1;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Competition Detail', base_url().'Custom/Competition Details');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		
		$this->load->view('custom/manage_competition',$data);
	}
	public function custom_competition_process(){
		$id = $this->input->post('id');
		$title = $this->input->post('title');
		$keywords = $this->input->post('keywords');
		$description = $this->input->post('description');
		$competition_type_id = $this->input->post('competition_type');
		$text_type = $this->input->post('text');
		
		if($this->input->post('detail')){
			$article = $this->input->post('detail');
		} else {
			$article = $this->input->post('article');
		}
		

		
		$this->db->select('competition_id');
		$this->db->where('competition_id',$competition_type_id);
		$check = $this->db->get('kt_nation_custom_text_custom_text')->num_rows();
		
		if($check > 0){
			$update_data = array (
				'type' => $text_type,
				'title' => $title,
				'keywords' => $keywords,
				'description' => $description,
				'article' => $article
			);
			$this->db->where('competition_id',$competition_type_id);
			$update = $this->db->update('kt_nation_custom_text_custom_text', $update_data); 
			if($update){
				redirect('custom/manage_custom/manage_competition');
			} else {
				echo "false";exit;
			}
		} else {
			$insert_data = array (
				'competition_id' => $competition_type_id,
				'type' => $text_type,
				'title' => $title,
				'keywords' => $keywords,
				'description' => $description,
				'article' => $article
			);
			$insert = $this->db->insert('kt_nation_custom_text_custom_text',$insert_data);
			if($insert){
				redirect('custom/manage_custom/manage_competition');
			}
		}
	}
	public function manage_nation(){
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 1;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Nation Detail', base_url().'Custom/Nation Details');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		
		$this->load->view('custom/manage_nation',$data);
	}
	public function custom_nation_process(){
		$id = $this->input->post('id');
		$title = $this->input->post('title');
		$keywords = $this->input->post('keywords');
		$description = $this->input->post('description');
		$nation = $this->input->post('nation_type');
		$text_type = $this->input->post('text');
		if($this->input->post('detail')){
			$article = $this->input->post('detail');
		} else {
			$article = $this->input->post('article');
		}
		
		$this->db->select('nation');
		$this->db->where('nation',$nation);
		$check = $this->db->get('kt_nation_custom_text')->num_rows();
		
		if($check > 0){
			$update_data = array (
				'type' => $text_type,
				'title' => $title,
				'keywords' => $keywords,
				'description' => $description,
				'article' => $article
			);
			$this->db->where('nation',$nation);
			$update = $this->db->update('kt_nation_custom_text', $update_data); 
			if($update){
				redirect('custom/manage_custom/manage_nation');
			} else {
				echo "false";exit;
			}
		} else {
			$insert_data = array (
				'nation' => $nation,
				'type' => $text_type,
				'title' => $title,
				'keywords' => $keywords,
				'description' => $description,
				'article' => $article
			);
			$insert = $this->db->insert('kt_nation_custom_text',$insert_data);
			if($insert){
				redirect('custom/manage_custom/manage_nation');
			}
		}
	}
	public function manage_team(){
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 1;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Team Detail', base_url().'Custom/Team Details');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		
		$this->load->view('custom/manage_team',$data);
	}
	public function custom_team_process(){
		$id = $this->input->post('id');
		$title = $this->input->post('title');
		$keywords = $this->input->post('keywords');
		$description = $this->input->post('description');
		$team_type = $this->input->post('team_type');
		$text_type = $this->input->post('text');
		if($this->input->post('detail')){
			$article = $this->input->post('detail');
		} else {
			$article = $this->input->post('article');
		}
		
		$this->db->select('team_id');
		$this->db->where('team_id',$team_type);
		$check = $this->db->get('kt_team_custom_text')->num_rows();
		
		if($check > 0){
			$update_data = array (
				//'team_id' => $team_type,
				'type' => $text_type,
				'title' => $title,
				'keywords' => $keywords,
				'description' => $description,
				'article' => $article
			);
			$this->db->where('team_id',$team_type);
			$update = $this->db->update('kt_team_custom_text', $update_data); 
			if($update){
				redirect('custom/manage_custom/manage_team');
			} else {
				echo "false";exit;
			}
		} else {
			$insert_data = array (
				'team_id' => $team_type,
				'type' => $text_type,
				'title' => $title,
				'keywords' => $keywords,
				'description' => $description,
				'article' => $article
			);
			$insert = $this->db->insert('kt_team_custom_text',$insert_data);
			if($insert){
				redirect('custom/manage_custom/manage_team');
			}
		}
	}
	public function manage_event(){
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 1;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Event Detail', base_url().'event/Event Details');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		
		$this->load->view('custom/manage_event',$data);
	}
	public function get_events_by_competition(){
		$rss = $this->load->database('rss', TRUE);
		$nation = $this->input->post('c_id');
		
		$rss->where('nation',$nation);
		$events = $rss->get('rss_events')->result_array();
		foreach($events as $s){?>
			<option value="<?php echo $s['id'];?>">
				<?php echo ucwords($s['home_team']).' / '.ucwords($s['away_team']);?>
			</option>
			
		<?php }
	}
	public function get_competition_by_nation(){
		$rss = $this->load->database('rss', TRUE);
		$nation = $this->input->post('nation'); 
		
		$rss->where('nation',$nation);
		$events = $rss->get('rss_competition')->result_array();
		foreach($events as $s){?>
			<option value="<?php echo $s['competition_id'];?>">
				<?php echo ucwords(strtolower($s['competition_name']));?>
			</option>
			
		<?php }
	}
	public function get_team_by_sport(){
		$rss = $this->load->database('rss', TRUE);
		$sport = $this->input->post('sport'); 
		
		$rss->where('sport_cat_id',$sport);
		$teams = $rss->get('rss_team')->result_array();
		foreach($teams as $s){?>
			<option value="<?php echo $s['id'];?>">
				<?php echo ucwords(strtolower($s['name']));?>
			</option>
			
		<?php }
	}
	
	
	public function custom_event_process(){
		$title = $this->input->post('title');
		$keywords = $this->input->post('keywords');
		$description = $this->input->post('description');
		if($this->input->post('detail')){
			$article = $this->input->post('detail');
		} else {
			$article = $this->input->post('article');
		}
		
			$update_data = array (
				'title' => $title,
				'keywords' => $keywords,
				'description' => $description,
				'article' => $article
			);
			$this->db->where('id',1);
			$update = $this->db->update('kt_event_custom_text', $update_data); 
			if($update){
				redirect('custom/manage_custom/manage_event');
			} else {
				echo "false";exit;
			}
	}
	public function manage_highlight(){
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 1;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Highlight Detail', base_url().'Custom/Highlight Details');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		$this->load->view('custom/manage_highlight',$data);
	}
	
	public function custom_highlight_process(){
		$title = $this->input->post('title');
		$keywords = $this->input->post('keywords');
		$description = $this->input->post('description');
		$note = $this->input->post('note');
		if($this->input->post('detail')){
			$article = $this->input->post('detail');
		} else {
			$article = $this->input->post('article');
		}

		$update_data = array (
			'title' => $title,
			'keywords' => $keywords,
			'description' => $description,
			'article' => $article
		);
		$this->db->where('id',1);
		
			
		$update_array = array(
			"note" => $note
		);
		$query = $this->db->update("kt_welcome_section", $update_array);
		$update = $this->db->update('kt_highlight_custom_text', $update_data); 
		if($update){
			redirect('custom/manage_custom/manage_highlight');
		} else {
			redirect('custom/manage_custom/manage_highlight');
		}	
	}
	public function manage_home(){
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 1;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Highlight Detail', base_url().'Custom/Highlight Details');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		$this->load->view('custom/manage_home',$data);
	}
	public function custom_home_process(){
		$title = $this->input->post('title');
		$keywords = $this->input->post('keywords');
		$description = $this->input->post('description');
		if($this->input->post('detail')){
			$article = $this->input->post('detail');
		} else {
			$article = $this->input->post('article');
		}

		$update_data = array (
			'title' => $title,
			'keywords' => $keywords,
			'description' => $description,
			'article' => $article
		);
		$this->db->where('id',1);
		$update = $this->db->update('kt_home_custom_text', $update_data); 
		if($update){
			redirect('custom/manage_custom/manage_home');
		} else {
			redirect('custom/manage_custom/manage_home');
		}	
	}
	
}
