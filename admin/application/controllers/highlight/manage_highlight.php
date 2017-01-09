<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_highlight extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		//$this->load->model('sponsor/mod_sponsor');
		$this->load->model('common/mod_common');
		$this->load->model('highlight/mod_highlight');
		//$this->load->library('image_lib');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		
		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage highlight', base_url().'highlight/manage-highlight');
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
		
		//Fetching Pages Results
		$get_highlight = $this->mod_highlight->get_all_highlight();
		$data['highlight_arr'] = $get_highlight['highlight_arr'];
		$data['highlight_count'] = $get_highlight['highlight_count'];

		$get_highlight2 = $this->mod_highlight->get_all_highlight_pending();
		$data['highlight_arr2'] = $get_highlight2['highlight_arr2'];
		$data['highlight_count2'] = $get_highlight2['highlight_count2'];
		
		$data['blocked'] = $get_highlight2['blocked'];
		//echo "<pre>";print_r($data['highlight_arr']);exit;

			$this->load->view('highlight/manage_highlight',$data);
		
		
	}//end index()
	
	public function approve_multiple_highlight_pending(){
		$rss = $this->load->database('rss', TRUE);
		$all = $this->input->post("raw_highlight");
		// echo "<pre>";
		// print_r($all);exit;
		if(!empty($all) && $all != "Approve Selected") {
			foreach($all as $raw_id) {
				$update_array = array(
				"status_raw" => 'approved'
					);			
				$rss->where("id", $raw_id);
				$query_update = $rss->update("rss_highlight",$update_array);
			}
			$this->session->set_flashdata('ok_message', '- Highlights have been Approved.');
			redirect(base_url().'highlight/manage_highlight/');
		}else{
			$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
			redirect(base_url().'highlight/manage_highlight/');
		}
		
	}
	public function update_new(){
	
		$rss = $this->load->database('rss', TRUE);
		
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$compatibility = $this->input->post('compatibility');
		if($compatibility){
			$update_compatibility = array(
			'compatibility' => $compatibility
		);
		$rss->where('id',$id);
		$update = $rss->update('rss_highlight',$update_compatibility);
		}
		if($type){
			$update_type = array(
			'type' => $type
		);
		$rss->where('id',$id);
		$update = $rss->update('rss_highlight',$update_type);
		}
		if($update){
			echo "success";
		}else{
			echo "failed"; 
		}
		
		
	}
	public function manage_highlight_raw(){
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
		$this->breadcrumbcomponent->add('Manage Highlight', base_url().'Highlight/Manage-Highlight');
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
		
		//Fetching Pages Results
		$get_highlight = $this->mod_highlight->get_all_highlight_raw2();
		$data['highlight_arr'] = $get_highlight['highlight_arr'];
		$data['highlight_count'] = $get_highlight['highlight_count'];
		//echo "<pre>";print_r($data['highlight_arr']);
		$this->load->view('highlight/manage_highlight_raw',$data);
	}
	public function update_highlight_raw($raw_id){
		
		$update_array = array(
		"status_raw" => 'approved'
			);			
		$this->db->where("id", $raw_id);
		$query_update = $this->db->update("kt_highlight_raw",$update_array);
		if($query_update) {
			$this->db->where('id',$raw_id);
			$result = $this->db->get('kt_highlight_raw')->result_array();
			//echo "<pre>"; print_r($result);exit;
			foreach ($result as $raw){
				//echo $id = $raw['id'];
				$event_id_highlight = $raw['event_id_highlight'];
				$url = $raw['url'];
				$highlight_domain = $raw['highlight_domain'];
				$type = $raw['type'];
				$compatibility = $raw['compatibility'];
				$status_raw = $raw['status_raw'];
			}

			$this->db->where('url',$url);
			$this->db->where('event_id',$event_id_highlight);
			$query2 = $this->db->count_all_results('kt_highlight');
			//echo "<pre>"; print_r($query2);exit;
			
				
			if($query2 < 1 ) {
				$insert_array = array(
					'event_id' => $event_id_highlight,
					'url' => $url,
					'highlight_domain' => $highlight_domain,
					'type' => $type,
					'compatibility' => $compatibility,
					'status' =>$status_raw
				);
					
				$insert = $this->db->insert('kt_highlight',$insert_array);
				if($insert){
					$this->session->set_flashdata('ok_message', '- Highlight has been Approved.');
					redirect(base_url().'highlight/manage_highlight/manage_highlight_raw');
				}else{
					$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
					redirect(base_url().'highlight/manage_highlight/manage_highlight_raw');
				}
			}
			$this->session->set_flashdata('ok_message', '- Event has been Approved.');
			redirect(base_url().'highlight/manage_highlight/manage_highlight_raw');
		}else{
			$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
			redirect(base_url().'highlight/manage_highlight/manage_highlight_raw');
		}
	}
	public function approve_multiple_highlight(){
		$all = $this->input->post("raw_highlight");
		//echo "<pre>";
		//print_r($all);exit;
		if(!empty($all) && $all != "Approve Selected") {
			foreach($all as $raw_id) {
				$update_array = array(
				"status_raw" => 'approved'
					);			
				$this->db->where("id", $raw_id);
				$query_update = $this->db->update("kt_highlight_raw",$update_array);
			
			
				if($query_update) {
					$this->db->where('id',$raw_id);
					$result = $this->db->get('kt_highlight_raw')->result_array();
					//echo "<pre>"; print_r($result);
					foreach ($result as $raw){
						//echo $id = $raw['id'];
						$event_id_highlight = $raw['event_id_highlight'];
						$url = $raw['url'];
						$highlight_domain = $raw['highlight_domain'];
						$type = $raw['type'];
						$compatibility = $raw['compatibility'];
						$status_raw = $raw['status_raw'];
					}
				
					$this->db->where('url',$url);
					$this->db->where('event_id',$event_id_highlight);
					$query2 = $this->db->count_all_results('kt_highlight');
						
					if($query2 < 1) {
						$insert_array = array(
							'event_id' => $event_id_highlight,
							'url' => $url,
							'highlight_domain' => $highlight_domain,
							'type' => $type,
							'compatibility' => $compatibility,
							'status' =>$status_raw
						);
						
						$insert = $this->db->insert('kt_highlight',$insert_array);
					}
				}
			}
			$this->session->set_flashdata('ok_message', '- Event has been Approved.');
			redirect(base_url().'highlight/manage_highlight/manage_highlight_raw');
		}else{
			$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
			redirect(base_url().'highlight/manage_highlight/manage_highlight_raw');
		}
		
	}
	public function view_highlight($highlight_id=null){
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Highlights/ View Highlight', base_url().'highlight/manage_highlight');
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
		
		//Fetching Pages Results
		$data['get_highlight'] = $this->mod_highlight->get_highlight($highlight_id);
		
		$this->load->view('highlight/view_highlight',$data);
	}
	public function rules()
	{
		
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
		$this->breadcrumbcomponent->add('Manage Highlight Rule', base_url().'highlight/highlights rules');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view('highlight/add_highlight_rules',$data);
		
	}
	public function add_new_highlight_rule_process(){
		$rule = $this->input->post('highlight_rule');
		$status = $this->input->post('status');
		
		$update_array = array(
			"highlight_rule" => $rule,
			"status" => $status
		);
		$this->db->where('id',4);
		$query = $this->db->update("kt_highlight_rule", $update_array);
		if ($query) {
				$this->session->set_flashdata('ok_message', 'Successful');
				redirect('highlight/manage_highlight/rules');
				$this->session->set_flashdata('error', 'Something went wrong, please try again later');
				redirect('');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong, please try again later');
			redirect('');
		}
		redirect('highlight/manage_highlight/rules');
		
	}
	public function block_highlight($domain_id){
		
		$rss = $this->load->database('rss', TRUE);
		$rss->select('highlight_domain');
		$rss->where('id',$domain_id);
		$get_domain = $rss->get('rss_highlight')->result_array();
		$domain = $get_domain[0]['highlight_domain'];
		$insert_array = array(
		"domain_name" => $domain
		);
		$query = $rss->insert('rss_block_domain',$insert_array);
		if ($query) {
				$this->session->set_flashdata('ok_message', 'Successful');
				redirect('highlight/manage_highlight');
				$this->session->set_flashdata('error', 'Something went wrong, please try again later');
				redirect('');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong, please try again later');
			redirect('');
		}
		redirect('highlight/manage_highlight');
	}
	public function get_highlight(){
		$video_url_id = $this->input->post('iframe_id');
		
		$this->db->select('url');
		$this->db->where('id',$video_url_id);
		$query = $this->db->get('kt_highlight')->result_array();
		echo $query[0]['url'];
	}
	
	public function add_new_highlight(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
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
		$this->breadcrumbcomponent->add('Manage highlight', base_url().'highlight/manage_highlight');
		$this->breadcrumbcomponent->add('Manage Highlights', base_url().'highlight/manage_highlight/add_new_highlight');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$this->load->view("highlight/add_new_highlight",$data);
		
	}
	public function update_highlight_status($highlight_id){
	$rss = $this->load->database('rss', TRUE);
	//echo $highlight_id;exit;
	$update_array = array(
	"status_raw" => 'approved'
		);			
	$rss->where("id", $highlight_id);
	$query_update = $rss->update("rss_highlight",$update_array);
	
	if($query_update) {
		$this->session->set_flashdata('ok_message', '- Status has been Approved.');
		redirect(base_url().'highlight/manage_highlight/');
	} else {
		$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
		redirect(base_url().'highlight/manage_highlight/');
	}
	}
	public function add_new_highlight_process(){
		
		//echo $this->input->post('video');exit;
		
		if($this->input->post("video") == 'youtube'){
		$url = $this->input->post("url");
		
		if($url != ''){
		//$url = $this->input->post("url");
		$result = parse_url($url);
		$pieces4 = $result['host']; // To get www.youtube.com not http://
		preg_match(
        '/[\\?\\&]v=([^\\?\\&]+)/',
        $url,
        $matches
		);
		$id = $matches[1];
		 
		$width = '500px'; //$_POST['width'];
		$height = '500px'; //$_POST['height'];
		
		$new_url = '<object width="' . $width . '" height="' . $height . '"><param name="movie" value="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' . $width . '" height="' . $height . '"></embed></object>';
		}else{
			$this->session->set_flashdata('err_message', 'please Enter Youtube URL');
			redirect('highlight/manage_highlight/add_new_highlight');
			exit;
		}
		
		
		}else if($this->input->post("video") == 'dailymotion'){
		$url = $this->input->post("url");
		if($url != ''){
		$url = $this->input->post("url");
		$result = parse_url($url);
		$pieces4 = $result['host']; // To get www.youtube.com not http://
		$pieces = explode('video/',$url);
		$string=substr($pieces[1],0,7);
		preg_match(
				'/[\\?\\&]v=([^\\?\\&]+)/',
				$url,
				$matches
			);
			$width =  '500px';
			$height = '500px';
			$new_url ='<iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="//www.dailymotion.com/embed/video/'.$string.'" allowfullscreen></iframe><br /><a href="'.$url.'" target="_blank"></a> <i>by <a href="http://www.dailymotion.com/autovideoreviewcom" target="_blank">autovideoreviewcom</a></i>';
		}else{
			$this->session->set_flashdata('err_message', 'please Enter URL');
			redirect('highlight/manage_highlight/add_new_highlight');
			exit;
		}
		//imgur
		}else if($this->input->post("video") == 'imgur'){
		$url = $this->input->post("url");
		if($url != ''){
		$url = $this->input->post("url");
		//echo $url;
		$result = parse_url($url);
		$pieces4 = $result['host']; // To get www.youtube.com not http://
		$pieces = explode('gallery/',$url);
		$string=substr($pieces[1],0,7);
		//echo $string;exit;

		?>
		<?php
		preg_match(
				'/[\\?\\&]v=([^\\?\\&]+)/',
				$url,
				$matches
			);
		$new_url ='<blockquote class="imgur-embed-pub" lang="en" data-id="'.$string.'"><a href="//imgur.com/'.$string.'">&amp;quot;o-okay.. i guess&amp;quot;FP*: Send pictures of your t̶o̶e̶s̶ feet to my inbox</a></blockquote><script async src="//s.imgur.com/min/embed.js" charset="utf-8"></script>';
		//echo $new_url;exit;
		}else{
			$this->session->set_flashdata('err_message', 'please Enter URL');
			redirect('highlight/manage_highlight/add_new_highlight');
			exit;
		}
		}else if($this->input->post("video") == 'gyfcat'){
		$url = $this->input->post("url");
		if($url != ''){
		$url = $this->input->post("url");
		$result = parse_url($url);
		$pieces4 = $result['host']; // To get www.youtube.com not http://
		//echo $url;

		$pieces = explode('http://gfycat.com/',$url);
		$string=substr($pieces[1],0,50);
		//echo $string;exit;

		?>
		<?php
		preg_match(
				'/[\\?\\&]v=([^\\?\\&]+)/',
				$url,
				$matches
			);
		$new_url ="<iframe src='http://gfycat.com/ifr/".$string."' frameborder='0' scrolling='no' width='700' height='700' style='-webkit-backface-visibility: hidden;-webkit-transform: scale(1);' ></iframe>";
		//echo $new_url;exit;
		}else{
			$this->session->set_flashdata('err_message', 'please Enter URL');
			redirect('highlight/manage_highlight/add_new_highlight');
			exit;
		}
		}
		
		//Embed Code For Other!
		else if($this->input->post("video") == 'other'){
			//echo "ammar";exit;
			$new_url = $this->input->post("embed_code");
			function GetRealURL( $url ) // A function taht will convert embed code into url.
			{ 
			   $options = array(
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_HEADER         => true,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_ENCODING       => "",
				  CURLOPT_USERAGENT      => "spider",
				  CURLOPT_AUTOREFERER    => true,
				  CURLOPT_CONNECTTIMEOUT => 120,
				  CURLOPT_TIMEOUT        => 120,
				  CURLOPT_MAXREDIRS      => 10,
			   );
			   $ch = curl_init( $url ); 
			   curl_setopt_array( $ch, $options ); 
			   $content = curl_exec( $ch ); 
			   $err     = curl_errno( $ch ); 
			   $errmsg  = curl_error( $ch ); 
			   $header  = curl_getinfo( $ch ); 
			   curl_close( $ch ); 
			   return $header['url']; 
			} //end of function
			if($new_url != ''){
				$new_url = $this->input->post("embed_code");
				
				$string = $new_url;
				$regex = '$\b(https?|ftp|file)://[-A-Z0-9+&@#/%?=~_|!:,.;]*[-A-Z0-9+&@#/%=~_|]$i';
				preg_match_all($regex, $string, $result, PREG_PATTERN_ORDER);
				$A = $result[0];
				$URL = null;
				foreach($A as $B)
				{
				   $URL = GetRealURL($B);
				   break;
				}

				echo $URL;
				$result = parse_url($URL);
				$pieces4 = $result['host'];

			}
			else{
				$this->session->set_flashdata('err_message', 'Please Enter Embed Code');
			redirect('highlight');
			exit;
			}
		}else{
			//$new_url = $this->input->post("embed_code");
			$this->session->set_flashdata('err_message', 'Please Select Video Type');
			redirect('highlight');
			exit;
			
		}
		//end of radio button process
		$type = $this->input->post("type");
		$compatibility = $this->input->post("compatibility");
		$event = $this->input->post('event');
		$insert_array = array(
			"event_id_highlight" => $event,
			"url" => $new_url,
			"highlight_domain" => $pieces4,
			"type" => $type,
			"compatibility" => $compatibility,
			"status_raw" => 'approved'
		);
		$rss = $this->load->database('rss', TRUE);
		$query = $rss->insert("rss_highlight", $insert_array);
		if ($query) {
				$this->session->set_flashdata('ok_message', 'Successful');
				redirect('highlight/manage_highlight');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong, please try again later');
			redirect('highlight/manage_highlight');
		}
		redirect('highlight/manage_highlight');
	}//end add_page_process
	
	
	public function delete_highlight($highlight_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(95,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if
		
		//If Post is not SET
		if(!isset($highlight_id)) redirect(base_url());
		
		//Updating Page
		$del_highlight = $this->mod_highlight->delete_highlight($highlight_id);
		
		if($del_highlight){
			
			$this->session->set_flashdata('ok_message', '- Highlight deleted successfully.');
			redirect(base_url().'highlight/manage_highlight');
			
		}else{
			$this->session->set_flashdata('err_message', '- Highlight cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'highlight/manage_highlight');
			
		}//end if

	}//end delete_page
	public function update_highlight_raw2($raw_id){
		//echo $raw_id;exit;
		$update_array = array(
		"status_raw" => 'approved'
			);			
		$this->db->where("id", $raw_id);
		$query_update = $this->db->update("kt_highlight_raw2",$update_array);
		if($query_update) {
			$this->db->select('kt_highlight_raw2.*,kt_events.id as event_id');
			$this->db->where('kt_highlight_raw2.id',$raw_id);
			$this->db->join('kt_events','kt_events.home_team = kt_highlight_raw2.home_team AND kt_events.away_team = kt_highlight_raw2.away_team ');
			$result = $this->db->get('kt_highlight_raw2')->result_array();
			//echo "<pre>"; print_r($result);exit;
			if($result[0]['event_id']) {
				foreach ($result as $raw){
					$url = $raw['url'];
					//$home_team = $raw['home_team'];
					//$away_team = $raw['away_team'];
					$time = $raw['time'];
					$status_raw = $raw['status_raw'];
					$event_id = $raw['event_id'];
				}
				
				$this->db->where('url',$url);
				$this->db->where('event_id',$event_id);
				$query2 = $this->db->count_all_results('kt_highlight');
					
				if($query2 < 1 ) {
					$insert_array = array(
						'event_id' => $event_id,
						'url' => $url,
						'highlight_domain' => $url,
						'type' => "none",
						'compatibility' => "none",
						'status' =>$status_raw,
						'time' =>$time
					);
					$insert = $this->db->insert('kt_highlight',$insert_array);
					if($insert){
						$this->session->set_flashdata('ok_message', '- Highlight has been Approved.');
						redirect(base_url().'highlight/manage_highlight/manage_highlight_raw');
					}else{
						$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
						redirect(base_url().'highlight/manage_highlight/manage_highlight_raw');
					}
				}
				$this->session->set_flashdata('ok_message', '- Event has been Approved.');
				redirect(base_url().'highlight/manage_highlight/manage_highlight_raw');
			} else{
			$this->session->set_flashdata('err_message', '- Approved but Not added in highlights.');
			redirect(base_url().'highlight/manage_highlight/manage_highlight_raw');
			}
		}else{
				$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
			redirect(base_url().'highlight/manage_highlight/manage_highlight_raw');
	}
	}
	public function approve_multiple_highlight2(){
		$all = $this->input->post("raw_highlight");
		//echo "<pre>";
		//print_r($all);exit;
		if(!empty($all) && $all != "Approve Selected") {
			foreach($all as $raw_id) {
				$update_array = array(
				"status_raw" => 'approved'
					);			
				$this->db->where("id", $raw_id);
				$query_update = $this->db->update("kt_highlight_raw",$update_array);
			
			
				if($query_update) {
					$this->db->where('id',$raw_id);
					$result = $this->db->get('kt_highlight_raw')->result_array();
					//echo "<pre>"; print_r($result);
					foreach ($result as $raw){
						//echo $id = $raw['id'];
						$event_id_highlight = $raw['event_id_highlight'];
						$url = $raw['url'];
						$highlight_domain = $raw['highlight_domain'];
						$type = $raw['type'];
						$compatibility = $raw['compatibility'];
						$status_raw = $raw['status_raw'];
					}
				
					$this->db->where('url',$url);
					$this->db->where('event_id',$event_id_highlight);
					$query2 = $this->db->count_all_results('kt_highlight');
						
					if($query2 < 1) {
						$insert_array = array(
							'event_id' => $event_id_highlight,
							'url' => $url,
							'highlight_domain' => $highlight_domain,
							'type' => $type,
							'compatibility' => $compatibility,
							'status' =>$status_raw
						);
						
						$insert = $this->db->insert('kt_highlight',$insert_array);
					}
				}
			}
			$this->session->set_flashdata('ok_message', '- Event has been Approved.');
			redirect(base_url().'highlight/manage_highlight/manage_highlight_raw');
		}else{
			$this->session->set_flashdata('err_message', '- Something went wrong, please try again.');
			redirect(base_url().'highlight/manage_highlight/manage_highlight_raw');
		}
		
	}
	public function delete_highlight_raw($highlight_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(99,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
		}//end if
		
		//If Post is not SET
		if(!isset($highlight_id)) redirect(base_url());
		
		//Updating Page
		$del_highlight = $this->mod_highlight->delete_highlights_raw($highlight_id);
		
		if($del_highlight){
			
			$this->session->set_flashdata('ok_message', '- Stream deleted successfully.');
			redirect(base_url().'highlight/manage_highlight/manage_highlight_raw');
			
		}else{
			$this->session->set_flashdata('err_message', '- Stream cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'stream/manage_highlight/manage_highlight_raw');
			
		}//end if

	}//end delete_page
	public function get_date(){
		$my_date = $this->input->post('date');
		$date = date("Y-m-d",strtotime($my_date));
		$this->session->set_userdata('session_date',$date);
		$this->session->userdata('session_date');
		
		$my_date_time = $this->input->post('date_time');
		
		$date_time = date("Y-m-d H:i:s",strtotime($my_date_time));
		$this->session->set_userdata('session_date_time',$date_time);
		$this->session->userdata('session_date_time');
	}
	public function get_date_by_timezone(){
		
		$session_date = date("M d Y H:i:s"); //Get start date here
		$timezone = $this->input->post('timezone'); // Get time zone
		$this->session->set_userdata('my_timezone',$timezone); //Storing time zone in session
		$stored_timezone = $this->session->userdata('my_timezone'); // To display stored session
		
		//to get time zone in Y-m-d H:i:s
		$timezone_date_time = date("Y-m-d H:i:s", strtotime($session_date));

		//To get timezone in Date format
		$timezone_date = date('Y-m-d',strtotime($timezone_date_time));
		
		// Setting Up Sessions......
		$this->session->set_userdata('time_timezone',$timezone_date_time);
		$this->session->set_userdata('date_timezone',$timezone_date);

		//Echoing Sessions.
		echo $time_timezone = $this->session->userdata('time_timezone');
		echo $time_timezone_date = $this->session->userdata('date_timezone');

	}
	

}
