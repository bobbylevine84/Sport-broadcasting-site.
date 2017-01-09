<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('common/mod_common');
		$this->load->library('BreadcrumbComponent');
		$this->load->model('consumer/mod_manage');	
		
	}
	
	public function index(){
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] 			= 0;
		$data['PLUGIN_datepicker']			= 0;
		$data['PLUGIN_gcal'] 				= 0;
		$data['PLUGIN_form_validation'] 	= 0;
		$data['PLUGIN_gallery'] 			= 0;
		$data['PLUGIN_ckeditor'] 			= 0;
		$data['PLUGIN_floatchart'] 			= 0;
		
		//Common Includes
		$data['meta_title'] 				= DEFAULT_TITLE;
		$data['meta_keywords'] 				= DEFAULT_META_KEYWORDS;
		$data['meta_description'] 			= DEFAULT_META_DESCRIPTION;
		
		$fetch_nav_panel 					= $this->mod_common->fetch_admin_nav_panel();
		//echo "<pre>"; print_r($fetch_nav_panel); exit;
		$data['nav_panel_arr'] 				= $fetch_nav_panel;
		
		// fetch accounts
		//$data['get_individual_accounts']	= $this->mod_manage->get_individual_list_count();
		//$data['get_business_accounts']		= $this->mod_manage->get_business_list_count();
		//$data['get_exchanger_accounts']		= $this->mod_manage->get_exchanger_list_count();
		
		// fetch verified accounts
		//$data['get_verified_individual_accounts']	= $this->mod_manage->get_verified_individuals_list_count();
		//$data['get_verified_business_accounts']		= $this->mod_manage->get_verified_business_list_count();
		//$data['get_verified_exchanger_accounts']	= $this->mod_manage->get_verified_exchanger_list_count();
		
		//fetch pending accounts
		//$data['get_pending_individual_accounts']	= $this->mod_manage->get_pending_individuals_list_count();
		//$data['get_pending_business_accounts']		= $this->mod_manage->get_pending_business_list_count();
		//$data['get_pending_exchanger_accounts'] 	= $this->mod_manage->get_pending_exchanger_list_count();
		
		//fetch unverified accounts
		//$total_individual_accounts 					= $data['get_individual_accounts'];
		//$verified_and_pending_individual_accounts 	= $data['get_verified_individual_accounts'] + $data['get_pending_individual_accounts'];
		//$unverified_individual_accounts				= $total_individual_accounts - $verified_and_pending_individual_accounts;
		//$data['get_unverified_individual_accounts']	= $unverified_individual_accounts;
		
		//$total_business_accounts 					= $data['get_business_accounts'];
		//$verified_and_pending_business_accounts 	= $data['get_verified_business_accounts'] + $data['get_pending_business_accounts'];;
		//$unverified_business_accounts 				= $total_business_accounts - $verified_and_pending_business_accounts;
		//$data['get_unverified_business_accounts']	= $unverified_business_accounts;
		
		//$total_exchanger_accounts 					= $data['get_exchanger_accounts'] + $data['get_pending_exchanger_accounts'];
		//$verified_and_pending_exchanger_accounts	= $data['get_verified_exchanger_accounts'] + $data['get_pending_exchanger_accounts'];
		//$unverified_exchanger_accounts 				= $total_exchanger_accounts - $verified_and_pending_exchanger_accounts;
		//$data['get_unverified_exchanger_accounts']	= $unverified_exchanger_accounts; 
	
		
		//fetch monthwise withdraw
		//$data['get_monthwise_withdraw']		= $this->get_withdraw();
		
		
		//fetch monthwise deposite
		//$data['get_monthwise_deposite']		= $this->get_deposite();
		
		
		//fetch monthwise transfer
		//$data['get_monthwise_transfer']		= $this->get_transfer();
		//echo '<pre>';print_r($data['get_monthwise_transfer']);exit;
		
		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$data['breadcrum_data'] 			= $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] 		= $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer']	= $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] 			= $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] 		= $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] 				= $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] 				= $this->load->view('common/breadcrum','',true);
		
		$this->load->view('dashboard/dashboard',$data);
		
	}//end index()
	public function get_user_accountdata(){

$begin = new DateTime( '2015-01-01' );
$end = new DateTime( '2016-01-01' );

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
$calulated=array();
		
$res =	$this->mod_manage->get_account_data();
$res1 =	$this->mod_manage->get_accountss_data();
//echo '<pre>'; print_r($res1); exit;
	$count=0;
  foreach ($res as $key => $value) {	
	$phpdate = strtotime( $res[$key]['date'] );
 	$mysqldate = date( 'Y-m-d', $phpdate );
	
	foreach ( $period as $dt ){

		if($dt->format("Y-m-d")==$mysqldate){
			
		$calulated[$count]['0']=$dt->format("Y-m-d");
		//$calulated[$count]['0']=gmdate('l, M j, Y', strtotime($res[$key]['date']));
		//$dt->format("Y-m-d");
		$calulated[$count]['1']=(int)$res[$key]['total'];
			}
			else{
		//	$calulated[$count]['0']=gmdate('l, M j, Y', strtotime($res[$key]['date']));
		//	$calulated[$count]['1']=0;
		}
		
	}
	$count++;
}
//echo '<pre>'; print_r($calulated);
 $new_jason=json_encode($calulated);
 echo $new_jason;
 exit;

}
	
	public function get_withdraw()
	{
		$array = $this->mod_manage->get_monthwise_withdraw();

		foreach($array as $arr)
		{
			$str .= '[Date.UTC('.$arr['year_val'].', '.($arr['month_val']-1).', '.$arr['day_val'].'), '.$arr['total'].'],';
		}
		return $str;
		
	}
	
	public function get_deposite()
	{
		$array = $this->mod_manage->get_monthwise_deposite();

		foreach($array as $arr)
		{
			$str .= '[Date.UTC('.$arr['year_val'].', '.($arr['month_val']-1).', '.$arr['day_val'].'), '.$arr['total'].'],';
		}
		return $str;
		
	}
	
	public function get_transfer()
	{
		$array = $this->mod_manage->get_monthwise_transfer();

		foreach($array as $arr)
		{
			$str .= '[Date.UTC('.$arr['year_val'].', '.($arr['month_val']-1).', '.$arr['day_val'].'), '.$arr['total'].'],';
		}
		return $str;
		
	}
	
}//end Dashboard 
?>

