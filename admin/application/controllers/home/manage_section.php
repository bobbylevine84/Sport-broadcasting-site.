<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_section extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('admin/mod_admin');
        $this->load->model('slider/mod_slider');
        $this->load->model('common/mod_common');
        $this->load->model('home/manage_section_m');
        $this->load->library('BreadcrumbComponent');
    }

    public function index() {

        //Login Check
        $this->mod_admin->verify_is_admin_login();

        //Verify if Page is Accessable
        if (!in_array(30, $this->session->userdata('permissions_arr'))) {
            redirect(base_url() . 'errors/page-not-found-404');
            exit;
        }//end if
        //Plugin Files Permission
        $data['PLUGIN_datagrid'] = 1;
        $data['PLUGIN_datepicker'] = 0;
        $data['PLUGIN_gcal'] = 0;
        $data['PLUGIN_form_validation'] = 0;
        $data['PLUGIN_gallery'] = 0;
        $data['PLUGIN_ckeditor'] = 1;
        $data['PLUGIN_floatchart'] = 0;

        //Common Includes
        $data['meta_title'] = Manage_Sections;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;

        //Bread crum
        $this->breadcrumbcomponent->add('Dashboard', base_url() . 'dashboard/dashboard');

        $this->breadcrumbcomponent->add('Manage Homepage Sections', base_url() . 'slider/manage-slider');

        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();


        $data['INC_top_header'] = $this->load->view('common/top_header', '', true);
        $data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel', $data, true);
        $data['INC_breadcrum'] = $this->load->view('common/breadcrum', $data, true);



        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);



        //Permissions
        $data['ALLOW_pages_edit'] = (in_array(32, $this->session->userdata('permissions_arr'))) ? 1 : 0;
        $data['ALLOW_pages_delete'] = (in_array(33, $this->session->userdata('permissions_arr'))) ? 1 : 0;

        //Fetching Pages Results
        $get_slider_images = $this->mod_slider->get_all_slider_images();

        $data['slider_images_arr'] = $get_slider_images['slider_images_arr'];
        $data['slider_images_count'] = $get_slider_images['slider_images_count'];
        $data['adminsetting'] = $this->gen_setting();
        $data['self_menu'] = $this->manage_section_m->get_menus_drop_down();




        $this->load->view('home/sections', $data);
    }
    
    public function readmore() {
        //Login Check
        $this->mod_admin->verify_is_admin_login();

        //Verify if Page is Accessable
        if (!in_array(87, $this->session->userdata('permissions_arr'))) {
            redirect(base_url() . 'errors/page-not-found-404');
            exit;
        }//end if
        //Plugin Files Permission
        $data['PLUGIN_datagrid'] = 1;
        $data['PLUGIN_datepicker'] = 0;
        $data['PLUGIN_gcal'] = 0;
        $data['PLUGIN_form_validation'] = 0;
        $data['PLUGIN_gallery'] = 0;
        $data['PLUGIN_ckeditor'] = 1;
        $data['PLUGIN_floatchart'] = 0;

        //Common Includes
        $data['meta_title'] = Manage_Sections;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;

        //Bread crum
        $this->breadcrumbcomponent->add('Dashboard', base_url() . 'dashboard/dashboard');

        $this->breadcrumbcomponent->add('Manage Homepage Readmore', base_url() . 'home/manage_section/readmore');

        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();


        $data['INC_top_header'] = $this->load->view('common/top_header', '', true);
        $data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel', $data, true);
        $data['INC_breadcrum'] = $this->load->view('common/breadcrum', $data, true);



        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);



        //Permissions
        $data['ALLOW_pages_edit'] = (in_array(32, $this->session->userdata('permissions_arr'))) ? 1 : 0;
        $data['ALLOW_pages_delete'] = (in_array(33, $this->session->userdata('permissions_arr'))) ? 1 : 0;

        //Fetching Pages Results
        $get_slider_images = $this->mod_slider->get_all_slider_images();

        $data['slider_images_arr'] = $get_slider_images['slider_images_arr'];
        $data['slider_images_count'] = $get_slider_images['slider_images_count'];
        $data['adminsetting'] = $this->gen_setting();
        $data['self_menu'] = $this->manage_section_m->get_menus_drop_down();


        $text = $this->db->get("homepage_readmore")->result_array();
        $data['text'] = $text[0]['text'];

        $this->load->view('home/readmore', $data);
    }
    
    public function update_readmore() {
        //Login Check
        $this->mod_admin->verify_is_admin_login();
        
        $text = $this->input->post("readmore");
        
        $this->db->where("id", 1);
        $query = $this->db->update("homepage_readmore", array("text" => $text));
        if ($query) {
            $this->session->set_flashdata('ok_message', 'Updated Successfully');
            redirect('home/manage-section/readmore');
        } else {
            $this->session->set_flashdata('err_message', 'Something went wrong, Please try again later');
            redirect('home/manage-section/readmore');
        }
    }

//end index()

    public function section_1() {
        $data['PLUGIN_datagrid'] = 1;
        $data['PLUGIN_datepicker'] = 0;
        $data['PLUGIN_gcal'] = 0;
        $data['PLUGIN_form_validation'] = 0;
        $data['PLUGIN_gallery'] = 0;
        $data['PLUGIN_ckeditor'] = 1;
        $data['PLUGIN_floatchart'] = 0;

        //Common Includes
        $data['meta_title'] = Manage_Sections;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;

        //Bread crum
        $this->breadcrumbcomponent->add('Dashboard', base_url() . 'dashboard/dashboard');

        $this->breadcrumbcomponent->add('Manage Homepage Sections', base_url() . 'slider/manage-slider');

        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();


        $data['INC_top_header'] = $this->load->view('common/top_header', '', true);
        /* $data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true); */
        $data['INC_breadcrum'] = $this->load->view('common/breadcrum', $data, true);



        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);



        //Permissions
        $data['ALLOW_pages_edit'] = (in_array(32, $this->session->userdata('permissions_arr'))) ? 1 : 0;
        $data['ALLOW_pages_delete'] = (in_array(33, $this->session->userdata('permissions_arr'))) ? 1 : 0;


        //Fetching Pages Results
        $get_slider_images = $this->mod_slider->get_all_slider_images();

        $data['slider_images_arr'] = $get_slider_images['slider_images_arr'];
        $data['slider_images_count'] = $get_slider_images['slider_images_count'];
        $data['adminsetting'] = $this->gen_setting();
        $data['self_menu'] = $this->manage_section_m->get_menus_drop_down();


        $this->load->view('home/sections_1', $data);
    }

    public function section_2() {
        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);

        $data['PLUGIN_datagrid'] = 1;
        $data['PLUGIN_datepicker'] = 0;
        $data['PLUGIN_gcal'] = 0;
        $data['PLUGIN_form_validation'] = 0;
        $data['PLUGIN_gallery'] = 0;
        $data['PLUGIN_ckeditor'] = 1;
        $data['PLUGIN_floatchart'] = 0;

        //Common Includes
        $data['meta_title'] = Manage_Sections;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;


        //Fetching Pages Results
        $get_slider_images = $this->mod_slider->get_all_slider_images();

        $data['slider_images_arr'] = $get_slider_images['slider_images_arr'];
        $data['slider_images_count'] = $get_slider_images['slider_images_count'];
        $data['adminsetting'] = $this->gen_setting();
        $data['self_menu'] = $this->manage_section_m->get_menus_drop_down();
        $this->load->view('home/sections_2', $data);
    }

    public function section_3() {
        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);
        $data['PLUGIN_datagrid'] = 1;
        $data['PLUGIN_datepicker'] = 0;
        $data['PLUGIN_gcal'] = 0;
        $data['PLUGIN_form_validation'] = 0;
        $data['PLUGIN_gallery'] = 0;
        $data['PLUGIN_ckeditor'] = 1;
        $data['PLUGIN_floatchart'] = 0;

        //Common Includes
        $data['meta_title'] = Manage_Sections;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;


        //Fetching Pages Results
        $get_slider_images = $this->mod_slider->get_all_slider_images();

        $data['slider_images_arr'] = $get_slider_images['slider_images_arr'];
        $data['slider_images_count'] = $get_slider_images['slider_images_count'];
        $data['adminsetting'] = $this->gen_setting();
        $data['self_menu'] = $this->manage_section_m->get_menus_drop_down();
        $this->load->view('home/sections_3', $data);
    }
    
    

    public function gen_setting() {
        $results_profile = $this->manage_section_m->get_setting();
        return $results_profile;
    }

    public function update_sections() {
        /* echo '<pre>';
          print_r($this->input->post());
          exit; */
        $id = $this->input->post('menu_id');

        $image = $_FILES['sec_image']['name'];
        if ($image == '') {
            //echo 'if image value not set sustain current image here';
            $image = $this->input->post('sec_curr_image');
            //exit;
        } else {
            //echo 'if image value set fetch for db';

            $folder_path = '../uploads/section/';
            move_uploaded_file($_FILES['sec_image']['tmp_name'], $folder_path . $image);
        }


        if ($this->input->post('menu_url_self')) {
            $link = $this->input->post('menu_url_self');
        } else {
            $link = $this->input->post('menu_url_other');
        }
        //////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////
        $iframe = $this->input->post('iframe');

        if ($iframe == '') {
            $iframe_id = $this->input->post('curr_iframe');
        } else {
            $iframe_id = $iframe;
        }
        $iframe_id = $updated_data = array(
            //'sec_desc' =>$this->input->post(''),
            'sec_title' => $this->input->post('sec_title'),
            'sec_title_1' => $this->input->post('sec_title_1'),
            'sec_image' => $image,
            'sec_content' => $this->input->post('sec_content'),
            'link' => $link,
            'iframe' => $iframe_id
                //'type'	
        );


        $this->db->where('id', $id);
        $this->db->update('kt_home_section', $updated_data);
        redirect('home/manage_section');
        //$this->index();
        /*
          [sec_title] => Why Us
          [sec_image] =>
          [sec_content] =>

          Lorem ipsum dolor

          [menu_url_other] =>
          [menu_url_self] => http://dev.ejuicysolutions.com/blackbull/admin/content/view
          [menu_id] => 1

         */

        //$this->manage_section_m->update_sec();

        /* echo '<pre>';
          print_r($updated_data);
          exit; */
    }

    ##############################################################
    ###############deposit method icons###########################
    ##############################################################
    ##############################################################

    public function manage_deposit_icons() {
        //echo 'i am manage_section/manage_deposit_icons()';
        //exit;
        //Login Check
        $this->mod_admin->verify_is_admin_login();

        //Verify if Page is Accessable
        if (!in_array(30, $this->session->userdata('permissions_arr'))) {
            redirect(base_url() . 'errors/page-not-found-404');
            exit;
        }//end if
        //Plugin Files Permission
        $data['PLUGIN_datagrid'] = 1;
        $data['PLUGIN_datepicker'] = 0;
        $data['PLUGIN_gcal'] = 0;
        $data['PLUGIN_form_validation'] = 0;
        $data['PLUGIN_gallery'] = 0;
        $data['PLUGIN_ckeditor'] = 1;
        $data['PLUGIN_floatchart'] = 0;

        //Common Includes
        $data['meta_title'] = Manage_Sections;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;

        //Bread crum
        $this->breadcrumbcomponent->add('Dashboard', base_url() . 'dashboard/dashboard');

        $this->breadcrumbcomponent->add('Manage Deposit Ways Icons', base_url() . '');

        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();


        $data['INC_top_header'] = $this->load->view('common/top_header', '', true);
        $data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel', $data, true);
        $data['INC_breadcrum'] = $this->load->view('common/breadcrum', $data, true);



        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);



        //Permissions
        $data['ALLOW_pages_edit'] = (in_array(32, $this->session->userdata('permissions_arr'))) ? 1 : 0;
        $data['ALLOW_pages_delete'] = (in_array(33, $this->session->userdata('permissions_arr'))) ? 1 : 0;

        //Fetching Pages Results

        $get_deposit_icons = $this->manage_section_m->get_all_deposit_icons();


        $data['deposit_icons_arr'] = $get_deposit_icons['deposit_icons_arr'];
        $data['deposit_icons_count'] = $get_deposit_icons['deposit_icons_count'];

        //$data['adminsetting'] = $this->gen_setting();
        //$data['self_menu'] = $this->manage_section_m->get_menus_drop_down();
        /* echo '<pre>';
          print_r($data['deposit_icons_count']);
          exit; */

        $this->load->view('home/deposit-ways/deposit_icons', $data);
    }

    public function edit_deposit_icon($id) {
        echo $id;

        $this->mod_admin->verify_is_admin_login();
        //Verify if Page is Accessable
        if (!in_array(30, $this->session->userdata('permissions_arr'))) {
            redirect(base_url() . 'errors/page-not-found-404');
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
        $data['meta_title'] = Manage_Sections;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;

        //Bread crum
        $this->breadcrumbcomponent->add('Dashboard', base_url() . 'dashboard/dashboard');

        $this->breadcrumbcomponent->add('Manage Deposit Methods Icons', base_url() . 'home/manage-section/manage-deposit-icons');
        $this->breadcrumbcomponent->add('Edit Deposit Method Icon', base_url() . '');

        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();


        $data['INC_top_header'] = $this->load->view('common/top_header', '', true);
        $data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel', $data, true);
        $data['INC_breadcrum'] = $this->load->view('common/breadcrum', $data, true);



        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);



        //Permissions
        $data['ALLOW_pages_edit'] = (in_array(32, $this->session->userdata('permissions_arr'))) ? 1 : 0;
        $data['ALLOW_pages_delete'] = (in_array(33, $this->session->userdata('permissions_arr'))) ? 1 : 0;

        //Fetching Pages Results
        $get_deposit_icon = $this->manage_section_m->get_deposit_icon($id);

        //$data['social_icon_arr'] = $get_social_icon['social_icon_arr'];
        $data['deposit_icon_arr'] = $get_deposit_icon[0];
        //$data['social_icons_count'] = $get_social_icons['social_icons_count'];


        /* [id] => 1
          [social_icon] => twitter.jpg
          [social_link] => ejuicysolutions.com
          [display_order] => 1
          [status] => 0
          [created_date] =>
          [created_by] =>
          [created_by_ip] =>
          [last_modified_by] =>
          [last_modified_date] =>
          [last_modified_ip] =>
         */
        $this->load->view('home/deposit-ways/edit_deposit_icon', $data);
    }

    public function edit_deposit_icon_process() {
        $id = $this->input->post('id');
        $image = $_FILES['deposit_icon']['name'];
        /*
          [deposit_link] => ejuicysolutions.com
          [display_order] => 1
          [status] => 1
          [id] => 1
         */
        if ($image == '') {
            $image = $this->input->post('curr_deposit_icon');
        } else {
            $image = $_FILES['deposit_icon']['name'];
            $folder_path = '../uploads/deposit_icons/';
            move_uploaded_file($_FILES['deposit_icon']['tmp_name'], $folder_path . $image);
        }
        $updated = array(
            'deposit_link' => $this->input->post('deposit_link'),
            'display_order' => $this->input->post('display_order'),
            'status' => $this->input->post('status')
        );

        $this->db->where('id', $id);
        $this->db->update('kt_deposit_ways_icons', $updated);

        /* echo '<pre>';
          print_r($this->input->post());
          exit; */

        $this->manage_deposit_icons();
    }

    public function add_new_deposit_icon() {
        $this->mod_admin->verify_is_admin_login();
        //Verify if Page is Accessable
        if (!in_array(30, $this->session->userdata('permissions_arr'))) {
            redirect(base_url() . 'errors/page-not-found-404');
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
        $data['meta_title'] = Manage_Sections;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;

        //Bread crum
        $this->breadcrumbcomponent->add('Dashboard', base_url() . 'dashboard/dashboard');

        $this->breadcrumbcomponent->add('Manage Deposit Method Icons', base_url() . 'home/manage-section/manage-deposit-icons');
        $this->breadcrumbcomponent->add('Add New Deposit Icon', base_url() . '');


        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();
        $data['INC_top_header'] = $this->load->view('common/top_header', '', true);
        $data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel', $data, true);
        $data['INC_breadcrum'] = $this->load->view('common/breadcrum', $data, true);

        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);

        //Permissions
        $data['ALLOW_pages_edit'] = (in_array(32, $this->session->userdata('permissions_arr'))) ? 1 : 0;
        $data['ALLOW_pages_delete'] = (in_array(33, $this->session->userdata('permissions_arr'))) ? 1 : 0;

        $this->load->view('home/deposit-ways/add-new-deposit-icon');
    }

    public function add_icon_deposit_process() {
        $image = $_FILES['deposit_icon']['name'];

        $this->form_validation->set_rules('deposit_link', 'deposit Link', 'required');
        //$this->form_validation->set_rules('display_order','','required');
        //$this->form_validation->set_rules('status','','required');
        //$this->form_validation->set_rules('social_icon','your new icon','required');

        if ($image == '') {
            $this->add_new_deposit_icon();
        } else {
            if ($this->form_validation->run() == False) {
                $this->add_new_deposit_icon();
            } else {
                $this->manage_section_m->add_new_deposit_icon($image);
                /* echo '<pre>';
                  print_r($_FILES['social_icon']);
                  print_r($this->input->post());
                  exit; */
                redirect('/home/manage-section/manage-deposit-icons');
            }
        }
    }

    public function delete_deposit_icon($id) {
        /* echo $id;
          exit; */
        $this->db->where('id', $id);
        $this->db->delete('kt_deposit_ways_icons');
        $this->manage_deposit_icons();
    }

    ##############################################################
    ###############Strategic partner icons########################
    ##############################################################
    ##############################################################

    public function manage_partner_icons() {
        //echo 'i am manage_section/manage_partner_icons()';
        //exit;
        //Login Check
        $this->mod_admin->verify_is_admin_login();

        //Verify if Page is Accessable
        if (!in_array(30, $this->session->userdata('permissions_arr'))) {
            redirect(base_url() . 'errors/page-not-found-404');
            exit;
        }//end if
        //Plugin Files Permission
        $data['PLUGIN_datagrid'] = 1;
        $data['PLUGIN_datepicker'] = 0;
        $data['PLUGIN_gcal'] = 0;
        $data['PLUGIN_form_validation'] = 0;
        $data['PLUGIN_gallery'] = 0;
        $data['PLUGIN_ckeditor'] = 1;
        $data['PLUGIN_floatchart'] = 0;

        //Common Includes
        $data['meta_title'] = Manage_Sections;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;

        //Bread crum
        $this->breadcrumbcomponent->add('Dashboard', base_url() . 'dashboard/dashboard');

        $this->breadcrumbcomponent->add('Manage Strategic Partner Icons', base_url() . '');

        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();


        $data['INC_top_header'] = $this->load->view('common/top_header', '', true);
        $data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel', $data, true);
        $data['INC_breadcrum'] = $this->load->view('common/breadcrum', $data, true);



        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);



        //Permissions
        $data['ALLOW_pages_edit'] = (in_array(32, $this->session->userdata('permissions_arr'))) ? 1 : 0;
        $data['ALLOW_pages_delete'] = (in_array(33, $this->session->userdata('permissions_arr'))) ? 1 : 0;

        //Fetching Pages Results

        $get_partner_icons = $this->manage_section_m->get_all_partner_icons();


        $data['partner_icons_arr'] = $get_partner_icons['partner_icons_arr'];
        $data['partner_icons_count'] = $get_partner_icons['partner_icons_count'];

        //$data['adminsetting'] = $this->gen_setting();
        //$data['self_menu'] = $this->manage_section_m->get_menus_drop_down();
        /* echo '<pre>';
          print_r($data['partner_icons_count']);
          exit; */

        $this->load->view('home/partner/partner_icons', $data);
    }

    public function edit_partner_icon($id) {
        echo $id;

        $this->mod_admin->verify_is_admin_login();
        //Verify if Page is Accessable
        if (!in_array(30, $this->session->userdata('permissions_arr'))) {
            redirect(base_url() . 'errors/page-not-found-404');
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
        $data['meta_title'] = Manage_Sections;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;

        //Bread crum
        $this->breadcrumbcomponent->add('Dashboard', base_url() . 'dashboard/dashboard');

        $this->breadcrumbcomponent->add('Manage Strategic Partner Icons', base_url() . 'home/manage-section/manage-partner-icons');
        $this->breadcrumbcomponent->add('Edit Strategic Partner Icon', base_url() . '');

        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();


        $data['INC_top_header'] = $this->load->view('common/top_header', '', true);
        $data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel', $data, true);
        $data['INC_breadcrum'] = $this->load->view('common/breadcrum', $data, true);



        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);



        //Permissions
        $data['ALLOW_pages_edit'] = (in_array(32, $this->session->userdata('permissions_arr'))) ? 1 : 0;
        $data['ALLOW_pages_delete'] = (in_array(33, $this->session->userdata('permissions_arr'))) ? 1 : 0;

        //Fetching Pages Results
        $get_partner_icon = $this->manage_section_m->get_partner_icon($id);

        //$data['social_icon_arr'] = $get_social_icon['social_icon_arr'];
        $data['partner_icon_arr'] = $get_partner_icon[0];
        //$data['social_icons_count'] = $get_social_icons['social_icons_count'];


        /* [id] => 1
          [social_icon] => twitter.jpg
          [social_link] => ejuicysolutions.com
          [display_order] => 1
          [status] => 0
          [created_date] =>
          [created_by] =>
          [created_by_ip] =>
          [last_modified_by] =>
          [last_modified_date] =>
          [last_modified_ip] =>
         */
        $this->load->view('home/partner/edit_partner_icon', $data);
    }

    public function edit_partner_icon_process() {
        $id = $this->input->post('id');
        $image = $_FILES['partner_icon']['name'];
        /*
          [partner_link] => ejuicysolutions.com
          [display_order] => 1
          [status] => 1
          [id] => 1
         */
        if ($image == '') {
            $image = $this->input->post('curr_partner_icon');
        } else {
            $image = $_FILES['partner_icon']['name'];
            $folder_path = '../uploads/partner_icons/';
            move_uploaded_file($_FILES['partner_icon']['tmp_name'], $folder_path . $image);
        }
        $updated = array(
            'partner_link' => $this->input->post('partner_link'),
            'display_order' => $this->input->post('display_order'),
            'status' => $this->input->post('status')
        );

        $this->db->where('id', $id);
        $this->db->update('kt_strategic_partner_icons', $updated);

        /* echo '<pre>';
          print_r($this->input->post());
          exit; */

        $this->manage_partner_icons();
    }

    public function add_new_partner_icon() {
        $this->mod_admin->verify_is_admin_login();
        //Verify if Page is Accessable
        if (!in_array(30, $this->session->userdata('permissions_arr'))) {
            redirect(base_url() . 'errors/page-not-found-404');
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
        $data['meta_title'] = Manage_Sections;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;

        //Bread crum
        $this->breadcrumbcomponent->add('Dashboard', base_url() . 'dashboard/dashboard');

        $this->breadcrumbcomponent->add('Manage Strategic Partner Icons', base_url() . 'home/manage-section/manage-partner-icons');
        $this->breadcrumbcomponent->add('Add New Strategic Partner Icon', base_url() . '');


        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();
        $data['INC_top_header'] = $this->load->view('common/top_header', '', true);
        $data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel', $data, true);
        $data['INC_breadcrum'] = $this->load->view('common/breadcrum', $data, true);

        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);

        //Permissions
        $data['ALLOW_pages_edit'] = (in_array(32, $this->session->userdata('permissions_arr'))) ? 1 : 0;
        $data['ALLOW_pages_delete'] = (in_array(33, $this->session->userdata('permissions_arr'))) ? 1 : 0;

        $this->load->view('home/partner/add-new-partner-icon');
    }

    public function add_icon_partner_process() {
        $image = $_FILES['partner_icon']['name'];

        $this->form_validation->set_rules('partner_link', 'partner Link', 'required');
        //$this->form_validation->set_rules('display_order','','required');
        //$this->form_validation->set_rules('status','','required');
        //$this->form_validation->set_rules('social_icon','your new icon','required');

        if ($image == '') {
            $this->add_new_partner_icon();
        } else {
            if ($this->form_validation->run() == False) {
                $this->add_new_partner_icon();
            } else {
                $this->manage_section_m->add_new_partner_icon($image);
                /* echo '<pre>';
                  print_r($_FILES['social_icon']);
                  print_r($this->input->post());
                  exit; */
                redirect('/home/manage-section/manage-partner-icons');
            }
        }
    }

    public function delete_partner_icon($id) {
        /* echo $id;
          exit; */
        $this->db->where('id', $id);
        $this->db->delete('kt_strategic_partner_icons');
        $this->manage_partner_icons();
    }

    ##############################################################
    ###############Manage social  icons###########################
    ##############################################################
    ##############################################################

    public function manage_social_icons() {
        //echo 'i am manage_section/manage_social_icons()';
        //exit;
        //Login Check
        $this->mod_admin->verify_is_admin_login();
        //Verify if Page is Accessable
        if (!in_array(11, $this->session->userdata('permissions_arr'))) {
            redirect(base_url() . 'errors/page-not-found-404');
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
        $data['meta_title'] = Manage_Sections;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;
        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;
        //Bread crum
        $this->breadcrumbcomponent->add('Dashboard', base_url() . 'dashboard/dashboard');
        $this->breadcrumbcomponent->add('Manage Social Icons', base_url() . 'slider/manage-slider');
        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();
        $data['INC_top_header'] = $this->load->view('common/top_header', '', true);
        $data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel', $data, true);
        $data['INC_breadcrum'] = $this->load->view('common/breadcrum', $data, true);
        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);
        //Permissions
        $data['ALLOW_pages_edit'] = (in_array(32, $this->session->userdata('permissions_arr'))) ? 1 : 0;
        $data['ALLOW_pages_delete'] = (in_array(33, $this->session->userdata('permissions_arr'))) ? 1 : 0;
        //Fetching Pages Results
        //$data['social_icons'] = $this->manage_section_m->get_all_social_icons();
        $data['social_icons'] = $this->manage_section_m->get_all_values_frm_table('kt_social_icons');
        $data['style_type'] = $data['social_icons'][0]['style_type'];
        //echo '<pre>';
        //print_r($data['social_icons'][0]);
        //exit;
        //$data['social_icons_arr'] = $get_social_icons['social_icons_arr'];
        //$data['social_icons_count'] = $get_social_icons['social_icons_count'];
        //$data['adminsetting'] = $this->gen_setting();
        //$data['self_menu'] = $this->manage_section_m->get_menus_drop_down();
        $this->load->view('home/social_icons', $data);
    }

    public function add_new_icon() {
        $this->mod_admin->verify_is_admin_login();
        //Verify if Page is Accessable
        if (!in_array(11, $this->session->userdata('permissions_arr'))) {
            redirect(base_url() . 'errors/page-not-found-404');
            exit;
        }//end if
        //Plugin Files Permission
        $data['PLUGIN_datagrid'] = 1;
        $data['PLUGIN_datepicker'] = 0;
        $data['PLUGIN_gcal'] = 0;
        $data['PLUGIN_form_validation'] = 0;
        $data['PLUGIN_gallery'] = 0;
        $data['PLUGIN_ckeditor'] = 1;
        $data['PLUGIN_floatchart'] = 0;

        //Common Includes
        $data['meta_title'] = Manage_Sections;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;

        //Bread crum
        $this->breadcrumbcomponent->add('Dashboard', base_url() . 'dashboard/dashboard');

        $this->breadcrumbcomponent->add('Manage Social Icons', base_url() . 'home/manage-section/manage-social-icons');
        $this->breadcrumbcomponent->add('Add New Social Icon', base_url() . '');

        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();


        $data['INC_top_header'] = $this->load->view('common/top_header', '', true);
        $data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel', $data, true);
        $data['INC_breadcrum'] = $this->load->view('common/breadcrum', $data, true);

        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);

        //Permissions
        $data['ALLOW_pages_edit'] = (in_array(32, $this->session->userdata('permissions_arr'))) ? 1 : 0;
        $data['ALLOW_pages_delete'] = (in_array(33, $this->session->userdata('permissions_arr'))) ? 1 : 0;

        //$this->db->dbprefix('social_icons');
        //$this->db->order_by('id DESC');
        //$data['social_icons_drop'] = $this->db->get('kt_social_icons')->result_array();
        $data['social_icons_drop'] = $this->manage_section_m->get_all_values_frm_table('kt_social_icons');

        $data['remain_icons_count'] = $this->manage_section_m->get_num_rows_where('temp_status', 0, 'kt_social_icons');

        $this->load->view('home/add_new_icon', $data);
    }

    public function add_icon_process() {
        if ($this->input->post('update')) {

            //echo 'update';
            //echo '<pre>';
            //print_r($this->input->post());
            //exit;
            //$this->input->post();
            //$this->input->post();
            //$this->input->post();
            //$this->form_validation->set_rules('','','required');
            //$this->form_validation->set_rules('url1','URL','required');
            //$this->form_validation->set_rules('style_id','Select Style','required');
            if ($this->form_validation->run() == FALSE) {
                //echo 0;
                //$this->add_new_icon();
                //update icons
                $icons = $this->manage_section_m->get_all_values_frm_table('kt_social_icons');
                foreach ($icons as $icon) {
                    $id = $this->input->post($icon['name']);

                    $icon_link = $icon['name'] . '_link';
                    $data = array(
                        'social_link' => $this->input->post($icon_link)
                    );
                    $result = $this->manage_section_m->update_social_icon($id, $data);
                }
                if ($result) {
                    $this->session->set_flashdata('ok_message', 'Icon link updated successfully');
                    redirect('home/manage-section/add-new-icon');
                } else {
                    $this->session->set_flashdata('err_message', 'Icon link cannot be updated');
                    redirect('home/manage-section/add-new-icon');
                }
            } else {
                //echo 1;
                $id = $this->input->post('id_icon');
                $url = $this->input->post('url1');
                $this->manage_section_m->temp_status_update($id, $url);

                $style_id = $this->input->post('style_id');
                $this->manage_section_m->assgin_style($style_id);
                //echo '<pre>';
                //print_r($d);
                //exit;
                redirect('/home/manage-section/manage-social-icons');
            }

            /*
              [id_icon] => 24
              [url1] => https://www.twitter.com/blackbull
              [style_id] => 0
             */
        } else {
            /* echo '<pre>';
              print_r($this->input->post());
              exit; */

            $this->form_validation->set_rules('url1', 'URl', 'required');

            if ($this->form_validation->run() == FALSE) {
                redirect('/home/manage-section/add-new-icon');
            } else {
                $id = $this->input->post('id_icon');
                $url = $this->input->post('url1');
                $this->manage_section_m->temp_status_update($id, $url);

                //$selected = array( 'temp_status'=>1, 'social_link'=>$this->input->post('url1'));
                //$this->db->where('id',$this->input->post('id_icon'));
                //$this->db->update('kt_social_icons',$selected);


                redirect('/home/manage-section/add-new-icon');
            }
        }
    }

    public function remove_icon($id) {
        //echo $id;
        //exit;
        $temp_status = array('temp_status' => 0);
        $this->db->where('id', $id);
        $this->db->update('kt_social_icons', $temp_status);

        //deleting the row with style id
        $this->db->where('social_icon_id', $id);
        $this->db->delete('kt_icon_styles');

        redirect('/home/manage-section/add-new-icon');
        //$this->manage_social_icons();
    }

    public function active($val) {
        $result = $this->manage_section_m->active($val);
        redirect(base_url() . 'home/manage-section/manage-deposit-icons');
    }

//end Active on click function

    public function inactive($val) {
        //echo $category_id;exit;
        $result = $this->manage_section_m->inactive($val);
        redirect(base_url() . 'home/manage-section/manage-deposit-icons');
    }

    public function active_icon($val) {
        $result = $this->manage_section_m->active_icon($val);
        redirect(base_url() . 'home/manage-section/manage-partner-icons');
    }

//end Active on click function

    public function inactive_icon($val) {
        //echo $category_id;exit;
        $result = $this->manage_section_m->inactive_icon($val);
        redirect(base_url() . 'home/manage-section/manage-partner-icons');
    }

}

//end Manage setting
