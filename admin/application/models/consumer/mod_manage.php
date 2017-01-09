<?php
class Mod_manage extends CI_Model
{
	
	public function get_consumers_list_count()
	{
		//echo 'i am consumer/mod_manage/get_consumers_list_count';
		
		return $this->db->count_all('kt_users');
	}
	public function get_individual_list_count()
	{
		//echo 'i am consumer/mod_manage/get_consumers_list_count';
		$query=$this->db->get_where('kt_users',array('user_type'=>1))->result_array();
		return  count($query);
	}
	public function get_all_group()
	{
		$query=$this->db->get_where('kt_manage_group')->result_array();
		return  $query;
	}
	public function get_business_list_count()
	{
		//echo 'i am consumer/mod_manage/get_consumers_list_count';
		$query=$this->db->get_where('kt_users',array('user_type'=>2))->result_array();
		return  count($query);
	}
	public function get_exchanger_list_count()
	{
		//echo 'i am consumer/mod_manage/get_consumers_list_count';
		$query=$this->db->get_where('kt_users',array('user_type'=>3))->result_array();
		return  count($query);
	}
	public function get_all_data_business()
	{
		$this->db->from('kt_users');
		$this->db->where('user_account_type',2);
//$this->db->join('kt_user_documents', 'kt_user_documents.user_id = kt_users.user_id');
$result= $this->db->get()->result();
$result_arr=array();
$count=0;
foreach($result as $res=>$key){
	if($result[$res]->user_account_type==2){
		$result_arr[$count]=$result[$res];
		$count++;
	}
}
return $result_arr;
	
	}
	public function get_all_data_exchanger()
	{
		$this->db->from('kt_users');
		$this->db->where('user_account_type',3);
$this->db->join('kt_user_documents', 'kt_user_documents.user_id = kt_users.user_id');
$result= $this->db->get()->result();
$result_arr=array();
$count=0;
foreach($result as $res=>$key){
	if($result[$res]->user_account_type==3){
		$result_arr[$count]=$result[$res];
		$count++;
	}
}
return $result_arr;
	
	}
	public function get_all_data_individual()
	{
		$this->db->from('kt_users');
$this->db->where('user_type',1);
//$this->db->join('kt_user_documents', 'kt_user_documents.user_id = kt_users.user_id');
$result= $this->db->get()->result();
//echo "<pre>"; print_r($result); exit;
$result_arr=array();
$count=0;
foreach($result as $res=>$key){
	if($result[$res]->user_account_type==1){
		$result_arr[$count]=$result[$res];
		$count++;
	}
}
//echo "<pre>"; print_r($result_arr); exit;
return $result_arr;
		
	}
	
	public function get_all_data_individual_verified()
	{
		$this->db->from('kt_users');
		//$this->db->where('user_account_type',1);
		$this->db->join('kt_user_documents', 'kt_user_documents.user_id = kt_users.user_id');
		$result= $this->db->get()->result();
		//echo "<pre>"; print_r($result); exit;
		$result_arr=array();
		$count=0;
		foreach($result as $res=>$key){
			if($result[$res]->user_account_type==1 && $result[$res]->is_verify==1){
				$result_arr[$count]=$result[$res];
				$count++;
			}
		}
		//echo "<pre>"; print_r($result_arr); exit;
	return $result_arr;
		
	}
	public function get_all_data_business_verified()
	{
		$this->db->from('kt_users');
		//$this->db->where('user_account_type',2);
		$this->db->join('kt_user_documents', 'kt_user_documents.user_id = kt_users.user_id');
		$result= $this->db->get()->result();
		//echo "<pre>"; print_r($result); exit;
		$result_arr=array();
		$count=0;
		foreach($result as $res=>$key){
			if($result[$res]->user_account_type==2 && $result[$res]->is_verify==1){
				$result_arr[$count]=$result[$res];
				$count++;
			}
		}
	return $result_arr;
		
	}
	public function get_all_data_exchange_verified()
	{
		$this->db->from('kt_users');
		//$this->db->where('user_account_type',2);
		$this->db->join('kt_user_documents', 'kt_user_documents.user_id = kt_users.user_id');
		$result= $this->db->get()->result();
		//echo "<pre>"; print_r($result); exit;
		$result_arr=array();
		$count=0;
		foreach($result as $res=>$key){
			if($result[$res]->user_account_type==3 && $result[$res]->is_verify==1){
				$result_arr[$count]=$result[$res];
				$count++;
			}
		}
	return $result_arr;
		
	}
	public function get_all_data_individual_pending()
	{
		$this->db->from('kt_users');
		//$this->db->where('user_account_type',1);
		$this->db->join('kt_user_documents', 'kt_user_documents.user_id = kt_users.user_id');
		$result= $this->db->get()->result();
		//echo "<pre>"; print_r($result); exit;
		$result_arr=array();
		$count=0;
		foreach($result as $res=>$key){
			if($result[$res]->user_account_type==1 && $result[$res]->is_verify==2){
				$result_arr[$count]=$result[$res];
				$count++;
			}
		}
	return $result_arr;
		
	}
		public function get_all_data_individual_unverified()
	{
		$this->db->from('kt_users');
		//$this->db->where('user_account_type',1);
		$this->db->join('kt_user_documents', 'kt_user_documents.user_id = kt_users.user_id');
		$result= $this->db->get()->result();
		//echo "<pre>"; print_r($result); exit;
		$result_arr=array();
		$count=0;
		foreach($result as $res=>$key){
			if($result[$res]->user_account_type==1 && $result[$res]->is_verify==0){
				$result_arr[$count]=$result[$res];
				$count++;
			}
		}
	return $result_arr;
		
	}
	public function get_all_data_business_unverfied()
	{
		$this->db->from('kt_users');
		//$this->db->where('user_account_type',1);
		$this->db->join('kt_user_documents', 'kt_user_documents.user_id = kt_users.user_id');
		$result= $this->db->get()->result();
		//echo "<pre>"; print_r($result); exit;
		$result_arr=array();
		$count=0;
		foreach($result as $res=>$key){
			if($result[$res]->user_account_type==2 && $result[$res]->is_verify==0){
				$result_arr[$count]=$result[$res];
				$count++;
			}
		}
	return $result_arr;
		
	}
	public function get_all_data_exchanger_unverfied()
	{
		$this->db->from('kt_users');
		//$this->db->where('user_account_type',1);
		$this->db->join('kt_user_documents', 'kt_user_documents.user_id = kt_users.user_id');
		$result= $this->db->get()->result();
		//echo "<pre>"; print_r($result); exit;
		$result_arr=array();
		$count=0;
		foreach($result as $res=>$key){
			if($result[$res]->user_account_type==3 && $result[$res]->is_verify==0){
				$result_arr[$count]=$result[$res];
				$count++;
			}
		}
	return $result_arr;
		
	}
	public function get_all_data_business_pending()
	{
		$this->db->from('kt_users');
		//$this->db->where('user_account_type',1);
		$this->db->join('kt_user_documents', 'kt_user_documents.user_id = kt_users.user_id');
		$result= $this->db->get()->result();
		//echo "<pre>"; print_r($result); exit;
		$result_arr=array();
		$count=0;
		foreach($result as $res=>$key){
			if($result[$res]->user_account_type==2 && $result[$res]->is_verify==2){
				$result_arr[$count]=$result[$res];
				$count++;
			}
		}
	return $result_arr;
		
	}
	public function get_all_data_exchanger_pending()
	{
		$this->db->from('kt_users');
		//$this->db->where('user_account_type',1);
		$this->db->join('kt_user_documents', 'kt_user_documents.user_id = kt_users.user_id');
		$result= $this->db->get()->result();
		//echo "<pre>"; print_r($result); exit;
		$result_arr=array();
		$count=0;
		foreach($result as $res=>$key){
			if($result[$res]->user_account_type==3 && $result[$res]->is_verify==2){
				$result_arr[$count]=$result[$res];
				$count++;
			}
		}
	return $result_arr;
		
	}
	
	public function get_all_data_consumers()
	{
		$this->db->from('kt_users');
//$this->db->where('user_account_type',1);
//$this->db->join('kt_user_documents', 'kt_user_documents.user_id = kt_users.user_id');
return $this->db->get()->result();

	}
	public function is_consumer_verified($val)
	{
		//echo 'i am consumer/mod_manage/get_consumers_list_count';
		$this->db->where('user_id',$val);
		return $this->db->get('kt_user_documents')->num_rows();
		
	}
	public function is_consumer_register($val)
	{
		//echo 'i am consumer/mod_manage/get_consumers_list_count';
		$this->db->where('User_id',$val);
		return $this->db->get('kt_users')->num_rows();
		
	}
	
	public function get_consumer_verified_data($val)
	{
		//echo 'i am consumer/mod_manage/get_consumers_list_count';
		$this->db->where('user_id',$val);
		return $this->db->get('kt_user_documents')->result_array();
	}
	public function get_consumer_data($val)
	{
		//echo 'i am consumer/mod_manage/get_consumers_list_count';
		$this->db->where('User_id',$val);
		return $this->db->get('kt_users')->result_array();
	}
	
	
	public function update_consumer_verify($val,$id)
	{
		//echo 'i am consumer/mod_manage/update_consumer_data';
		
		$this->db->where('user_id',$id);
		$this->db->update('kt_user_documents',$val);
		
		/*echo $id.'<pre>';
		print_r($val);
		exit;*/
	}
	public function update_group($val,$id)
	{
		//echo 'i am consumer/mod_manage/update_consumer_data';
		
		$this->db->where('user_id',$id);
		$res=$this->db->update('kt_users',$val);
		return $res;
		
		/*echo $id.'<pre>';
		print_r($val);
		exit;*/
	}
	public function update_consumer_data($val,$id)
	{
		//echo 'i am consumer/mod_manage/update_consumer_data';
		
		$this->db->where('user_id',$id);
		$this->db->update('kt_users',$val);
		
		/*echo $id.'<pre>';
		print_r($val);
		exit;*/
	}
	public function remove_consumer($val)
	{
		//echo 'i am consumer/mod_manage/remove_consumer';
		$this->db->where('user_id',$val);
		$this->db->delete('kt_users');
	}
	public function insert_consumer_data($val)
	{
		/*echo 'i am consumer/mod_manage/insert_consumer_data';
		echo '<pre>';
		print_r($val);
		exit;*/
		$this->db->insert('kt_users',$val);
	}
	public function is_chk_unique($email,$username)
	{//this method checks on base of email and username
	//	echo $email.$username;
	//	exit;
	}
	public function get_accountss_data(){
		
		 return $query=$this->db->query("
		 SELECT YEAR(user_account_create) as year_val, MONTH(user_account_create) as month_val ,COUNT(*) as total
FROM kt_users
GROUP BY YEAR(user_account_create), MONTH(user_account_create)")->result_array();

		
	}
	public function get_account_data(){
		
		 return $query=$this->db->query("SELECT DATE(`user_account_create`) as date, count(1) as total
FROM kt_users
GROUP BY `user_account_create`")->result_array();

		$this->db->select('user_account_create, COUNT(user_account_create) as total');
	 	$this->db->group_by('user_account_create'); 
 		$this->db->order_by('user_account_create', 'desc'); 
		$query=$this->db->get('kt_users');
		return $res = $query->result_array();
	/*	echo '<pre>';
	print_r($res);
	exit;*/
     //$query->result_array();
 		if ($query->num_rows>0){
	 		$data = array();
   foreach ($res as $key => $value) {
			$data[$key]['Date'] = $value['user_account_create'];
			$data[$key]['Total'] = $value['total'];
	echo '<pre>';
	print_r($value);
	
	
		$begin 		= new DateTime( '2013-05-01' );
		$end 		= new DateTime( '2015-05-10' );

	$interval 	= DateInterval::createFromDateString('1 day');
	$period 	= new DatePeriod($begin, $interval, $end);
		

	
foreach ($period as $dt ){
 if ($res==$dt) {
	 //echo $dt->format( "l Y-m-d H:i:s\n" );
	$res['user_account_create']		=	$res['total'];
		
 }
	else {
//echo "failed";
		$res['user_account_create'] =0;
		}
}
	
	
	
	
}
$data2 = array();
foreach ($res as $key=> $val){
	$data2[$key][Date]=$val['user_account_create'].$val['total'];
        
	
	}
	/*echo '<pre>';
	print_r($data2);
	exit;*/
	return $data1;
	 
	 
	 }
   

 	
	
}
public function status_inactive($val)
	{
		$inactive = array('user_status'=> '0');
		$this->db->where('user_id',$val);
		$query=$this->db->update('kt_users',$inactive);
		return $query;
	}
	public function status_active($val)
	{
		$active = array('user_status'=> '1');
		$this->db->where('user_id',$val);
		$query=$this->db->update('kt_users',$active);
		return $query;
	}
	
	public function get_verified_individuals_list_count()
	{
		$this->db->from('kt_users');
		$this->db->where(array('user_type'=>1, 'is_verify'=>1));
		$this->db->join('kt_user_documents','kt_users.user_id = kt_user_documents.user_id');
		$query = $this->db->get()->result_array();
		return count($query);
	}
	
	public function get_pending_individuals_list_count()
	{
		$this->db->from('kt_users');
		$this->db->where(array('user_type'=>1, 'is_verify'=>0));
		$this->db->join('kt_user_documents','kt_users.user_id = kt_user_documents.user_id');
		$query = $this->db->get()->result_array();
		return count($query);
	}
	
	public function get_verified_business_list_count()
	{
		$this->db->from('kt_users');
		$this->db->where(array('user_type'=>2, 'is_verify'=>1));
		$this->db->join('kt_user_documents','kt_users.user_id = kt_user_documents.user_id');
		$query = $this->db->get()->result_array();
		return count($query);
	}
	
	public function get_pending_business_list_count()
	{
		$this->db->from('kt_users');
		$this->db->where(array('user_type'=>2, 'is_verify'=>0));
		$this->db->join('kt_user_documents','kt_users.user_id = kt_user_documents.user_id');
		$query = $this->db->get()->result_array();
		return count($query);
	}
	
	public function get_verified_exchanger_list_count()
	{
		$this->db->from('kt_users');
		$this->db->where(array('user_type'=>3, 'is_verify'=>1));
		$this->db->join('kt_user_documents','kt_users.user_id = kt_user_documents.user_id');
		$query = $this->db->get()->result_array();
		return count($query);
	}
	
	public function get_pending_exchanger_list_count()
	{
		$this->db->from('kt_users');
		$this->db->where(array('user_type'=>3, 'is_verify'=>0));
		$this->db->join('kt_user_documents','kt_users.user_id = kt_user_documents.user_id');
		$query = $this->db->get()->result_array();
		return count($query);
	}
	
	public function get_monthwise_withdraw()
	{
		return $query = $this->db->query('SELECT YEAR(  `withdraw_date` ) AS year_val, MONTH(  `withdraw_date` ) AS month_val, DAY(  `withdraw_date` ) AS day_val, COUNT( * ) AS total
							FROM kt_withdraw
							GROUP BY YEAR(  `withdraw_date` ) , MONTH( withdraw_date ) ')->result_array();
									
	}
	
	public function get_monthwise_deposite()
	{
		return $query = $this->db->query('SELECT YEAR(  `deposite_date` ) AS year_val, MONTH(  `deposite_date` ) AS month_val, DAY(  `deposite_date` ) AS day_val, COUNT( * ) AS total
							FROM kt_deposite
							GROUP BY YEAR(  `deposite_date` ) , MONTH(  `deposite_date` ) ')->result_array();
						
	}
	
	public function get_monthwise_transfer()
	{
		return $query = $this->db->query('SELECT YEAR(  `transfer_date` ) AS year_val, MONTH(  `transfer_date` ) AS month_val, DAY(  `transfer_date` ) AS day_val, COUNT( * ) AS total
							FROM kt_transfer
							GROUP BY YEAR(  `transfer_date` ) , MONTH(  `transfer_date` ) ')->result_array();
	}
}
?>