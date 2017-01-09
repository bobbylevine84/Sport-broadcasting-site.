<?php
class From_management extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/mod_admin');
		$this->load->model('slider/mod_slider');
		$this->load->model('common/mod_common');
		$this->load->library('encrypt');
		
		$this->load->library('BreadcrumbComponent');
		
		$this->load->model('templates/mod_email');
		
	}
	
	public function index()
	{
		
	//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Manage_Email_Template ;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Administration', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('Form Management', base_url().'form/form_management');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching All Results
		 $data['result_forms']=$this->db->get('kt_forms')->result();
		
		$this->load->view('form/manage_forms',$data);
		
	
		//$this->load->view('form/add_form',$data);
	}
	
	public function new_form()
	{
		
		
	//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Manage_Email_Template ;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Administration', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('Form Management', base_url().'form/form_management');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching All template Results
		
		
		
		/*echo '<pre>';
		print_r($data['templates']);
		exit;*/
		
		$this->load->view('form/add_form',$data);
	
		
		}
	
	public function edit_template($id = null)
	{
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
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
		$data['meta_title'] = Manage_Email_Template ;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Administration', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('Email Templating', base_url().'templates/email');
		$this->breadcrumbcomponent->add('Edit Template', base_url().'templates/email/manage_template');
		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		
		$this->db->where('id',$id);
		$data['curr_template'] = $this->db->get('kt_email_template')->result();
		
		
		/*
		echo '<pre>';
		print_r($data['curr_template']);
		exit;
		*/
		
		$this->load->view('templates/edit_template',$data);
	}
	public function update_process()
	{
		/*echo 'i am template/email/update_process';
		echo '<pre>';
		print_r($this->input->post());
		exit;*/
		$val = $this->input->post("id");
		$edit_template = array(
			'subject' => $this->input->post("subject"),
    		'message' => $this->input->post("template")
		);
		
		$this->mod_email->update_template($val,$edit_template);
		
		$this->index();	
		
	}
	
	
	public function generate_form()
	{
		 $email=$this->input->get('email');
		 $form_name=$this->input->get('form_name');
		 $button_name=$this->input->get('button_name');
		
		 $this->db->where('email',$email);
		 $result_st=$this->db->get('kt_forms')->result();

		if (!empty($result_st))
		{
			$this->session->set_flashdata('err_message', 'Unique Email Required');
			echo "error";
			//redirect('form/from_management/new_form');
		}
		else
		{
		 /*=========================Generate Slug===================================*/
          $form_ids=$this->slug($form_name);
		 /*========================end generate slug=================================*/
		
		$insert_array=array(
		"form_name"=>$form_name,
		"email"=>$email,
		"button_name"=>$button_name,
		);
		
		$this->db->insert('kt_forms',$insert_array);
		$form_id = $this->db->insert_id();
		
		$form_slug='%%'.$form_ids.'-'.$form_id.'%/%';
		
		$update_form_rec=array(
		"form_ids"=>$form_slug
		);
		
		$this->db->where('form_id',$form_id);
		$this->db->update('kt_forms',$update_form_rec);
	 
	   $count=count($_GET['payload']['fields']);
	   
     for($i=0;$i<=$count;$i++)
		{
		
		$c_id=$_GET['payload']['fields'][$i]['cid'];
		$field_type=$_GET['payload']['fields'][$i]['field_type'];
		$lable=$_GET['payload']['fields'][$i]['label'];
		//echo $_GET['payload']['fields'][$i]['field_options'];
		$required=$_GET['payload']['fields'][$i]['required'];
		$size_field=$_GET['payload']['fields'][$i]['field_options']['size'];
		//$size=$_GET['payload']['fields'][$i]['size'];
		$form_detail=array(
		"field_type"=>$field_type,
		"label"=>$lable,
		"required"=>$required,
		"size"=>$size_field,
		//"option_type"=>$size,
		"form_id"=>$form_id
		);
	if(!empty($form_detail['field_type']))
	{
    $this->db->insert('kt_forms_detail',$form_detail);
	$form_detail_id = $this->db->insert_id();
	}
	if($_GET['payload']['fields'][$i]['field_options'])
	 { 
	
		 foreach($_GET['payload']['fields'][$i]['field_options'] as $row_1=>$chj )
		 {
			
			
			 if(is_array($chj))
				{
                
				foreach($chj as $res_1)
					{
					
					   $lable_1=$res_1['label'];
					   $checked_1=$res_1['checked'];
					   if(!empty($lable_1))
					   {
						   
						   $in_data=array(
						   "option_name"=>$lable_1,
						   "option_type"=>$checked_1,
						   "form_detail_id"=>$form_detail_id,
						   "form_id"=>$form_id
						   );
						 
						   $this->db->insert('kt_forms_detail_options',$in_data);
						}
					}
				}
			 else
			 {
				 //echo "<pre>"; print_r($chj);exit;
				 //$lable_1=$chj['label'];
				 $size=$chj;
				 $in_data=array(
				   //"option_name"=>$lable_1,
				   "field_size"=>$size,
				   "form_detail_id"=>$form_detail_id,
				   "form_id"=>$form_id
				   );
				   if(!empty($in_data))
				   {
						$this->db->insert('kt_forms_detail_options',$in_data);
				   }
			//echo "no array";
			 }

			 }
		 
		 }
	}

	$g_form=$this->generate_form_content($form_id);
	
	$upd_form_content=array(
	'form_contents'=>$g_form
	);
	$this->db->where('form_id',$form_id);
	$this->db->update('kt_forms',$upd_form_content);
 $this->session->set_flashdata('ok_message', 'New Form Added Successfully');
echo "Added";
 //redirect('form/from_management/all_form');
		}
		
 }
 
 public function generate_form_content($form_id)
	{
	 $f_base_path=explode("admin/",base_url());
	 
	 $this->db->where('form_id',$form_id);
	 $result_form=$this->db->get('kt_forms')->result();
	 if(!empty($result_form))
		{
		 $html='
		 <form action="'.$f_base_path[0].'content/send_generated_form" id="form_'.$form_id.'" method="post" class="form_records">
		 <table cellpadding="2" cellspacing="2" class="form_table" style="width:100%;">
			 <tr>
				 <td colspan="2">
					<h2>'.@$result_form[0]->form_name.'</h2>
					<input type="hidden" name="form_ids" id="form_ids" value="'.@$result_form[0]->form_id.'" />
				 </td>
		 </tr>';
		 $this->db->where('form_id',$form_id);
		 $form_detail=$this->db->get('kt_forms_detail')->result();
		 if(!empty($form_detail))
		 {  
		    //echo "<pre>"; print_r($form_detail); exit;
			foreach($form_detail as $f_row)
			 {
				if($f_row->required==='true'){$required="required";}else{$required=" ";}
			  $html.='
			   <tr>
			   <td><lable>'.$f_row->label.'</label></td>
			   <td>';
			   if($f_row->field_type=='text')
					{
					 $html.='<input '.$required.' type="'.$f_row->field_type.'" class="form_address '.$f_row->size.'"  name="'.$f_row->label.'" />';
					 
					}
				if($f_row->field_type=='paragraph')
					{
						$html.='<textarea '.$required.' name="'.$f_row->label.'" class="form_address '.$f_row->size.'" ></textarea>';
					}	
				if($f_row->field_type=='radio')
				{
				$this->db->where('form_detail_id',$f_row->id);
				$option_detail=$this->db->get('kt_forms_detail_options')->result();	
				
				foreach($option_detail as $opt_detail)
				{
					if($opt_detail->option_type=='true')
					{
						$html.='<input '.$required.' type="radio" class="form_cls_option form_address" name="'.$f_row->label.'" checked="checked" value="'.$opt_detail->option_name.'" />'.$opt_detail->option_name.'<br />';
					}
					else
					{
						$html.='<input '.$required.' type="radio" class="form_cls_option form_address" name='.$f_row->label.'" value="'.$opt_detail->option_name.'" />'.$opt_detail->option_name.'<br />';
					}
				}
				} 
				
			 if($f_row->field_type=='checkboxes')
				{
					$this->db->where('form_detail_id',$f_row->id);
					$option_detail=$this->db->get('kt_forms_detail_options')->result();	
					
					foreach($option_detail as $opt_detail)
					{
						if($opt_detail->option_type=='true')
						{
							$html.='<input '.$required.' type="checkbox" class="form_cls_option form_address" name="'.$f_row->label.'" checked="checked" value="'.$opt_detail->option_name.'" />'.$opt_detail->option_name.'<br />';
						}
						else
						{
							$html.='<input '.$required.' type="checkbox" class="form_cls_option form_address" name="'.$f_row->label.'" value="'.$opt_detail->option_name.'" />'.$opt_detail->option_name.'<br />';
						}
					}
				}
				 
				if($f_row->field_type=='dropdown')
				{
					$this->db->where('form_detail_id',$f_row->id);
					$option_detail=$this->db->get('kt_forms_detail_options')->result();	
					$html.='<select '.$required.' name="'.$f_row->label.'" class="form_address"  >';
					foreach($option_detail as $opt_detail)
					{
						if($opt_detail->option_type=='true')
						{
							$html.='<option selected="selected" value="'.$opt_detail->option_name.'">'.$opt_detail->option_name.'</option>'.$opt_detail->option_name;
						}
						else
						{
							$html.='<option value="'.$opt_detail->option_name.'">'.$opt_detail->option_name.'</option>'.$opt_detail->option_name;
						}
					}
					$html.='</select>';	
				} 
				if($f_row->field_type=='date')
				{
					$html.='
					<table>
						<tr>
							<td><input '.$required.' type="text" name="month" placeholder="Month" style="width:50px; margin-left:4px; margin-right:4px;margin-top:4px;margin-bottom:4px;" /></td>
							<td><input '.$required.' type="text" name="day" placeholder="Day" style="width:50px; margin-left:4px; margin-right:4px;margin-top:4px;margin-bottom:4px;" /></td>
							<td><input '.$required.' type="text" name="year" placeholder="Year" style="width:50px; margin-left:4px; margin-right:4px;margin-top:4px;margin-bottom:4px;" /></td>
						</tr>
					</table>
					 ';
				}
				
				if($f_row->field_type=='number')
				{
					$html.='<input type="text" />';
				}
				if($f_row->field_type=='email')
				{
					$html.='<input '.$required.' type="text" class="form_address" name="email" />';
				}
				if($f_row->field_type=='time')
				{
				$html.='<table>
							<tr>
								<td><input '.$required.' type="text" name="hour" placeholder="HH" style="width:30px;margin-left:4px; margin-right:4px;margin-top:4px;margin-bottom:4px;"></td>
								<td><input '.$required.' type="text" name="minutes" placeholder="MM" style="width:30px;margin-left:4px; margin-right:4px;margin-top:4px;margin-bottom:4px;"></td>
								<td><input '.$required.' type="text" name="seconds" placeholder="Seconds" style="width:30px;margin-left:4px; margin-right:4px;margin-top:4px;margin-bottom:4px;"></td>
								<td><select name="time_type" style="width:50px;margin-left:4px; margin-right:4px;margin-top:4px;margin-bottom:4px;">
								<option>AM</option>
								<option>PM</option>
								</select></td>
							</tr>
				        </table>
					    ';
				}
				if($f_row->field_type=='website')
				{
					$html.='<input '.$required.' type="text" name="website" class="form_address"  placeholder="http://">';
				}
				if($f_row->field_type=='price')
				{
					$html.='
					<table>
						<tr>
							<td><input '.$required.' type="text" placeholder="$" class="form_address" name="doller"></td>
							<td><input '.$required.' type="text" placeholder="cent" class="form_address" name="cent"></td>
						</tr>
						<tr></tr>
					</table>';
				}
				if($f_row->field_type=='country')
				{
				$html.=' 
				<table>
					<tr>
						<td colspan="2">
							<select name="country" class="form_address" style="width:184px;">
								
								<option value="United Kingdom">United Kingdom</option> 
								<option value="Afghanistan">Afghanistan</option> 
								<option value="Albania">Albania</option> 
								<option value="Algeria">Algeria</option> 
								<option value="American Samoa">American Samoa</option> 
								<option value="Andorra">Andorra</option> 
								<option value="Angola">Angola</option> 
								<option value="Anguilla">Anguilla</option> 
								<option value="Antarctica">Antarctica</option> 
								<option value="Antigua and Barbuda">Antigua and Barbuda</option> 
								<option value="Argentina">Argentina</option> 
								<option value="Armenia">Armenia</option> 
								<option value="Aruba">Aruba</option> 
								<option value="Australia">Australia</option> 
								<option value="Austria">Austria</option> 
								<option value="Azerbaijan">Azerbaijan</option> 
								<option value="Bahamas">Bahamas</option> 
								<option value="Bahrain">Bahrain</option> 
								<option value="Bangladesh">Bangladesh</option> 
								<option value="Barbados">Barbados</option> 
								<option value="Belarus">Belarus</option> 
								<option value="Belgium">Belgium</option> 
								<option value="Belize">Belize</option> 
								<option value="Benin">Benin</option> 
								<option value="Bermuda">Bermuda</option> 
								<option value="Bhutan">Bhutan</option> 
								<option value="Bolivia">Bolivia</option> 
								<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> 
								<option value="Botswana">Botswana</option> 
								<option value="Bouvet Island">Bouvet Island</option> 
								<option value="Brazil">Brazil</option> 
								<option value="British Indian Ocean Territory">British Indian Ocean Territory</option> 
								<option value="Brunei Darussalam">Brunei Darussalam</option> 
								<option value="Bulgaria">Bulgaria</option> 
								<option value="Burkina Faso">Burkina Faso</option> 
								<option value="Burundi">Burundi</option> 
								<option value="Cambodia">Cambodia</option> 
								<option value="Cameroon">Cameroon</option> 
								<option value="Canada">Canada</option> 
								<option value="Cape Verde">Cape Verde</option> 
								<option value="Cayman Islands">Cayman Islands</option> 
								<option value="Central African Republic">Central African Republic</option> 
								<option value="Chad">Chad</option> 
								<option value="Chile">Chile</option> 
								<option value="China">China</option> 
								<option value="Christmas Island">Christmas Island</option> 
								<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> 
								<option value="Colombia">Colombia</option> 
								<option value="Comoros">Comoros</option> 
								<option value="Congo">Congo</option> 
								<option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option> 
								<option value="Cook Islands">Cook Islands</option> 
								<option value="Costa Rica">Costa Rica</option> 
								<option value="Croatia">Croatia</option> 
								<option value="Cuba">Cuba</option> 
								<option value="Cyprus">Cyprus</option> 
								<option value="Czech Republic">Czech Republic</option> 
								<option value="Denmark">Denmark</option> 
								<option value="Djibouti">Djibouti</option> 
								<option value="Dominica">Dominica</option> 
								<option value="Dominican Republic">Dominican Republic</option> 
								<option value="Ecuador">Ecuador</option> 
								<option value="Egypt">Egypt</option> 
								<option value="El Salvador">El Salvador</option> 
								<option value="Equatorial Guinea">Equatorial Guinea</option> 
								<option value="Eritrea">Eritrea</option> 
								<option value="Estonia">Estonia</option> 
								<option value="Ethiopia">Ethiopia</option> 
								<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option> 
								<option value="Faroe Islands">Faroe Islands</option> 
								<option value="Fiji">Fiji</option> 
								<option value="Finland">Finland</option> 
								<option value="France">France</option> 
								<option value="French Guiana">French Guiana</option> 
								<option value="French Polynesia">French Polynesia</option> 
								<option value="French Southern Territories">French Southern Territories</option> 
								<option value="Gabon">Gabon</option> 
								<option value="Gambia">Gambia</option> 
								<option value="Georgia">Georgia</option> 
								<option value="Germany">Germany</option> 
								<option value="Ghana">Ghana</option> 
								<option value="Gibraltar">Gibraltar</option> 
								<option value="Greece">Greece</option> 
								<option value="Greenland">Greenland</option> 
								<option value="Grenada">Grenada</option> 
								<option value="Guadeloupe">Guadeloupe</option> 
								<option value="Guam">Guam</option> 
								<option value="Guatemala">Guatemala</option> 
								<option value="Guinea">Guinea</option> 
								<option value="Guinea-bissau">Guinea-bissau</option> 
								<option value="Guyana">Guyana</option> 
								<option value="Haiti">Haiti</option> 
								<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option> 
								<option value="Honduras">Honduras</option> 
								<option value="Hong Kong">Hong Kong</option> 
								<option value="Hungary">Hungary</option> 
								<option value="Iceland">Iceland</option> 
								<option value="India">India</option> 
								<option value="Indonesia">Indonesia</option> 
								<option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option> 
								<option value="Iraq">Iraq</option> 
								<option value="Ireland">Ireland</option> 
								<option value="Israel">Israel</option> 
								<option value="Italy">Italy</option> 
								<option value="Jamaica">Jamaica</option> 
								<option value="Japan">Japan</option> 
								<option value="Jordan">Jordan</option> 
								<option value="Kazakhstan">Kazakhstan</option> 
								<option value="Kenya">Kenya</option> 
								<option value="Kiribati">Kiribati</option> 
								<option value="Latvia">Latvia</option> 
								<option value="Lebanon">Lebanon</option> 
								<option value="Lesotho">Lesotho</option> 
								<option value="Liberia">Liberia</option> 
								<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option> 
								<option value="Liechtenstein">Liechtenstein</option> 
								<option value="Lithuania">Lithuania</option> 
								<option value="Luxembourg">Luxembourg</option> 
								<option value="Macao">Macao</option> 
								<option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option> 
								<option value="Madagascar">Madagascar</option> 
								<option value="Malawi">Malawi</option> 
								<option value="Malaysia">Malaysia</option> 
								<option value="Maldives">Maldives</option> 
								<option value="Mali">Mali</option> 
								<option value="Malta">Malta</option> 
								<option value="Marshall Islands">Marshall Islands</option> 
								<option value="Martinique">Martinique</option> 
								<option value="Mauritania">Mauritania</option> 
								<option value="Mauritius">Mauritius</option> 
								<option value="Mayotte">Mayotte</option> 
								<option value="Mexico">Mexico</option> 
								<option value="Micronesia, Federated States of">Micronesia, Federated States of</option> 
								<option value="Moldova, Republic of">Moldova, Republic of</option> 
								<option value="Monaco">Monaco</option> 
								<option value="Mongolia">Mongolia</option> 
								<option value="Montenegro">Montenegro</option>
								<option value="Montserrat">Montserrat</option> 
								<option value="Morocco">Morocco</option> 
								<option value="Mozambique">Mozambique</option> 
								<option value="Myanmar">Myanmar</option> 
								<option value="Namibia">Namibia</option> 
								<option value="Nauru">Nauru</option> 
								<option value="Nepal">Nepal</option> 
								<option value="Netherlands">Netherlands</option> 
								<option value="Netherlands Antilles">Netherlands Antilles</option> 
								<option value="New Caledonia">New Caledonia</option> 
								<option value="New Zealand">New Zealand</option> 
								<option value="Nicaragua">Nicaragua</option> 
								<option value="Niger">Niger</option> 
								<option value="Nigeria">Nigeria</option> 
								<option value="Niue">Niue</option> 
								<option value="Norfolk Island">Norfolk Island</option> 
								<option value="Northern Mariana Islands">Northern Mariana Islands</option> 
								<option value="Norway">Norway</option> 
								<option value="Oman">Oman</option> 
								<option value="Pakistan">Pakistan</option> 
								<option value="Palau">Palau</option> 
								<option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option> 
								<option value="Panama">Panama</option> 
								<option value="Papua New Guinea">Papua New Guinea</option> 
								<option value="Paraguay">Paraguay</option> 
								<option value="Peru">Peru</option> 
								<option value="Philippines">Philippines</option> 
								<option value="Pitcairn">Pitcairn</option> 
								<option value="Poland">Poland</option> 
								<option value="Portugal">Portugal</option> 
								<option value="Puerto Rico">Puerto Rico</option> 
								<option value="Qatar">Qatar</option> 
								<option value="Reunion">Reunion</option> 
								<option value="Romania">Romania</option> 
								<option value="Russian Federation">Russian Federation</option> 
								<option value="Rwanda">Rwanda</option> 
								<option value="Saint Helena">Saint Helena</option> 
								<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
								<option value="Saint Lucia">Saint Lucia</option> 
								<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> 
								<option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option> 
								<option value="Samoa">Samoa</option> 
								<option value="San Marino">San Marino</option> 
								<option value="Sao Tome and Principe">Sao Tome and Principe</option> 
								<option value="Saudi Arabia">Saudi Arabia</option> 
								<option value="Senegal">Senegal</option> 
								<option value="Serbia">Serbia</option> 
								<option value="Seychelles">Seychelles</option> 
								<option value="Sierra Leone">Sierra Leone</option> 
								<option value="Singapore">Singapore</option> 
								<option value="Slovakia">Slovakia</option> 
								<option value="Slovenia">Slovenia</option> 
								<option value="Solomon Islands">Solomon Islands</option> 
								<option value="Somalia">Somalia</option> 
								<option value="South Africa">South Africa</option> 
								<option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option> 
								<option value="South Sudan">South Sudan</option> 
								<option value="Spain">Spain</option> 
								<option value="Sri Lanka">Sri Lanka</option> 
								<option value="Sudan">Sudan</option> 
								<option value="Suriname">Suriname</option> 
								<option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option> 
								<option value="Swaziland">Swaziland</option> 
								<option value="Sweden">Sweden</option> 
								<option value="Switzerland">Switzerland</option> 
								<option value="Syrian Arab Republic">Syrian Arab Republic</option> 
								<option value="Taiwan, Republic of China">Taiwan, Republic of China</option> 
								<option value="Tajikistan">Tajikistan</option> 
								<option value="Tanzania, United Republic of">Tanzania, United Republic of</option> 
								<option value="Thailand">Thailand</option> 
								<option value="Timor-leste">Timor-leste</option> 
								<option value="Togo">Togo</option> 
								<option value="Tokelau">Tokelau</option> 
								<option value="Tonga">Tonga</option> 
								<option value="Trinidad and Tobago">Trinidad and Tobago</option> 
								<option value="Tunisia">Tunisia</option> 
								<option value="Turkey">Turkey</option> 
								<option value="Turkmenistan">Turkmenistan</option> 
								<option value="Turks and Caicos Islands">Turks and Caicos Islands</option> 
								<option value="Tuvalu">Tuvalu</option> 
								<option value="Uganda">Uganda</option> 
								<option value="Ukraine">Ukraine</option> 
								<option value="United Arab Emirates">United Arab Emirates</option> 
								<option value="United Kingdom">United Kingdom</option> 

								<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option> 
								<option value="Uruguay">Uruguay</option> 
								<option value="Uzbekistan">Uzbekistan</option> 
								<option value="Vanuatu">Vanuatu</option> 
								<option value="Venezuela">Venezuela</option> 
								<option value="Viet Nam">Viet Nam</option> 
								<option value="Virgin Islands, British">Virgin Islands, British</option> 
								<option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option> 
								<option value="Wallis and Futuna">Wallis and Futuna</option> 
								<option value="Western Sahara">Western Sahara</option> 
								<option value="Yemen">Yemen</option> 
								<option value="Zambia">Zambia</option> 
								<option value="Zimbabwe">Zimbabwe</option>
							</select>
						</td>
					</tr>
				</table>';
				}
			   $html.='</td>
			          </tr>';
					$required=" ";
				}
				$html.='
					<tr>
						<td></td>
						<td>
							<button type="submit"
						 onclick="" id="sub_button" style="color:#ffffff;font-weight:900;font-size:16px;" class="sub_button form_submit_btn" value="" style="padding: 0px; margin: 0px;">
						 <div id="sub_button_1" class="sub_button_1 form_submit_btn_1">
						 <span style="">'.@$result_form[0]->button_name.'</span>
						 </div>
						 </button>
						 </td>
					</tr>';
			 }
			 $base_url=base_url();
	$html.= '
		 </table>
		 </form>
		 ';
		 }
		return $html;
	 }
/*
style="background: none repeat scroll 0 0 background;border: medium none whitesmoke;color: white;margin-top: 12px;"
<script >
				 $( "#live_btn" ).click(function() {
  $( ".form_records" ).submit();
});

				 </script>
				 <div class="default_button">
<div id="live_btn_con">             
<a id="live_btn" style="color:#ffffff;font-weight:900;font-size:16px;padding:10px;text-decoration:none;">'.@$result_form[0]->button_name.'</a>
   						</div>
                    </div>
<!--<script>
		 function sub_form_data()
		 {
			 var all_form_data = $("#form_'.$form_id.'").serialize();
		   alert(all_form_data);
				$.ajax({
				url: '.$base_url.'content/add_form,
				type: "GET",
				data: {"from_data":all_form_data},
				success: function(data){
					if(data=="error")
					{
						//location.reload();
						}
					else
					{
						//location.reload();
				     //window.location=base_url+"form/from_management/all_form";
					}
				//alert(data);
				//console.log(data);
				},
				error: function (xhr, ajaxOptions, thrownError)
				{alert("ERROR:" + xhr.responseText+" - "+thrownError);}
		});  
		
			 
			 }
		 </script>-->*/
 /*<tr>
				<td><input '.$required.' type="text" name="Address" placeholder="Address" class="form_address" /></td>
				<td><input '.$required.' type="text" name="city" placeholder="City" class="form_address" /></td>
				</tr>
				<tr>
				<td><input '.$required.' type="text" name="state" placeholder="State" class="form_address" /></td>
				<td><input '.$required.' type="text" name="zip" placeholder="Zip" class="form_address" /></td>
				</tr>*/
 public function slug($name){
	$name = stripslashes($name);
	
	$removingcomma_name1 = str_replace("'", "", $name);
	$removingcomma_name2 = str_replace('"', "", $removingcomma_name1);
	$slugname_pre = strtolower(trim($removingcomma_name2));
	$slugname_post =  str_replace(" ","-",$slugname_pre);
	
	$slugname_post = $this->refine_sp_chr($slugname_post);
	return $slugname_post.'-'.$this->randomstr(8);
	/*$is_unique = $this->confirm_slug_db($tblname, $findin_field, $slugname_post);
	if($is_unique){
	return $slugname_post;
	}else{
	return $slugname_post.'-'.$this->randomstr(8);
	}*/
	}
	
 public function randomstr($length = 6, $letters = '1234567890qwertyuiopasdfghjklzxcvbnm'){
	$s = '';
	$lettersLength = strlen($letters)-1;
	for($i = 0 ; $i < $length ; $i++){
	$s .= $letters[rand(0,$lettersLength)];
	}
	return $s;
	}
	
 public function refine_sp_chr($slug){
	$code_entities_match = array( '&quot;','!','@','#','$','%','^','&','*','(',')','+','{','}','|',':','"','<','>','?','[',']','',';',"'",',','.','_','/','*','+','~','`','=',' ','---','--','--');
	$code_entities_replace = array('','','-','','','','-','-','','','','','','','','-','','','','','','','','','','-','','-','-','','','','','','-','-','-','-');
	$slug = str_replace($code_entities_match, $code_entities_replace, $slug);
	$slug=substr($slug,0,150);
	return $slug;
	}
 
 public function edit_current_form()
 {
	
	    $form_id=$this->input->get('form_id');
		 $email=$this->input->get('email');
		 $button_name=$this->input->get('button_name');
		 $form_name=$this->input->get('form_name');
		
		$insert_array_1=array(
		"form_name"=>$form_name,
		"email"=>$email,
		"button_name"=>$button_name
		);
	 $this->db->where('form_id',$form_id);
	 $this->db->update('kt_forms',$insert_array_1);
	 
	 /*===================Remove specific record==========================*/
	 
	 $this->db->where('form_id',$form_id);
	 $this->db->delete('kt_forms_detail');
	 
	 $this->db->where('form_id',$form_id);
	 $this->db->delete('kt_forms_detail_options');
	 
	 /*===================End Remove Record===============================*/
	 	
	 $count=count($_GET['payload']['fields']);
	 for($i=0;$i<=$count;$i++)
      {
		
	 $c_id=$_GET['payload']['fields'][$i]['cid'];
	$field_type=$_GET['payload']['fields'][$i]['field_type'];
	$lable=$_GET['payload']['fields'][$i]['label'];
	//echo $_GET['payload']['fields'][$i]['field_options'];
	$required=$_GET['payload']['fields'][$i]['required'];
	$size_field=$_GET['payload']['fields'][$i]['field_options']['size'];
    
	$form_detail=array(
	"field_type"=>$field_type,
	"label"=>$lable,
	"required"=>$required,
	"size"=>$size_field,
	"form_id"=>$form_id
	);
	if(!empty($form_detail['field_type']))
	{
    $this->db->insert('kt_forms_detail',$form_detail);
	$form_detail_id = $this->db->insert_id();
	}
	//echo "here";
	//echo "<pre>"; print_r($_GET); exit;
	if($_GET['payload']['fields'][$i]['field_options'])
	 { 
	
		 foreach($_GET['payload']['fields'][$i]['field_options'] as $row_1=>$chj )
		 {
			
			
			 if(is_array($chj))
			 {
                
				foreach($chj as $res_1)
				{
					
			       $lable_1=$res_1['label'];
				   $checked_1=$res_1['checked'];
				   if(!empty($lable_1)){
					   
				   $in_data=array(
				   "option_name"=>$lable_1,
				   "option_type"=>$checked_1,
				   "form_detail_id"=>$form_detail_id,
				   "form_id"=>$form_id
				   );
			     
				   $this->db->insert('kt_forms_detail_options',$in_data);
				 }
					}
				 }
			 else
			 {
				  //echo "<pre>"; print_r($chj);exit;
				  $size=$chj;
				  //$lable_1=$chj['label'];
				 $in_data=array(
				 	//"option_name"=>$lable_1,
				   "field_size"=>$size,
				   "form_detail_id"=>$form_detail_id,
				   "form_id"=>$form_id
				   );
				   if(!empty($in_data))
				   {
				   $this->db->insert('kt_forms_detail_options',$in_data);
				   }
			//echo "no array";
			 }

			 }
		 
		 }
	}


	$g_form=$this->generate_form_content($form_id);
	
	$upd_form_content=array(
	 'form_contents'=>$g_form
	  );
	$this->db->where('form_id',$form_id);
	$this->db->update('kt_forms',$upd_form_content);
	$this->session->set_flashdata('ok_message', 'Form Updated Successfully');
	echo "Updated";
 //redirect('form/from_management/all_form');
		
  
	 
	 }
	 
 public function delete_form($id)
 {
	 $this->db->where('form_id',$id);
	 $this->db->delete('kt_forms');
	 
	$this->db->where('form_id',$id);
	$this->db->delete('kt_forms_detail');
	
	$this->db->where('form_id',$id);
	$this->db->delete('kt_forms_detail_options');
	
	$this->session->set_flashdata('ok_message', 'Record Deleted Successfully');
	redirect('form/from_management/all_form');
	 
	 }	 

 public function all_form()
 {
	 
		
	//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = Manage_FORMS ;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Administration', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('Form Management', base_url().'form/form_management');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		 $data['result_forms']=$this->db->get('kt_forms')->result();
		
		$this->load->view('form/manage_forms',$data);
	
	
	 
	 } 
	 
  public function edit_form($id)
  {
	  
  if(!empty($id))
	  {
	
	//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
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
		$data['meta_title'] = EDIT_FORM ;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Administration', base_url().'dashboard/dashboard');
		
		$this->breadcrumbcomponent->add('Form Management', base_url().'form/form_management');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(32,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(33,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		  $this->db->where('form_id',$id);
		  $data['form_data']=$this->db->get('kt_forms')->result();
      
		   $this->load->view('form/edit_form',$data);		  
		  
		  }
	  }	  

}






?>