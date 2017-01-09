<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // $CI =& get_instance();
	// $CI->load->model('withdraw/mod_manage');
	// $CI->load->library('Stripe');
     
 //$result=$CI->Mod_manage->get_gateway();
 function thesportsdb(){
	 
						
		 $url = "http://www.thesportsdb.com/api/v1/json/1/searchteams.php?t=Arsenal";

				//setting the curl parameters.
				$ch = curl_init();
			  curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		//curl_setopt($ch, CURLOPT_POST, 1);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
											   'Content-type: application/xml', 
											   'Content-length: ' . strlen($xml)
											 ));
				$data = curl_exec($ch);
				curl_close($ch);

				//convert the XML result into array
			   // $array_data = json_decode(json_encode(simplexml_load_string($data)), true);

				print_r('<pre>');
				print_r($data);
				print_r('</pre>');
 }