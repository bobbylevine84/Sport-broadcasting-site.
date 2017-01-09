<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // $CI =& get_instance();
	// $CI->load->model('withdraw/mod_manage');
	// $CI->load->library('Stripe');
     
 //$result=$CI->Mod_manage->get_gateway();
	
	
//PAYPAL Section**********************
function PPHttpPost($methodName_, $nvpStr_)
{
			$CI =& get_instance();
			$CI->load->model('withdraw/Mod_managess');
			$result=$CI->Mod_managess->get_gateway();
                        
                        if($result[0]['gatway_account'] == "sdk-three_api1.sdk.com") {
                            $environment = 'sandbox';
                        }else {
                            $environment = 'live';
                        }
		
			 $API_UserName = urlencode($result[0]['gatway_account']);//
			 $API_Password = urlencode($result[0]['gatway_password']);// exit;
//                         echo $API_Password;exit;
                         
			 $API_Signature = urlencode('A-IzJhZZjhg29XQ2qnhapuwxIDzyAZQ92FRP5dqBzVesOkzbdUONzmOU');
			 $API_Endpoint = "https://api-3t.paypal.com/nvp";
		 if("sandbox" === $environment || "beta-sandbox" === $environment)
		 {
		  $API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
		 }
			 $version = urlencode('51.0');
			
			 // Set the curl parameters.
			 $ch = curl_init();
			 curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
			 curl_setopt($ch, CURLOPT_VERBOSE, 1);
			
			 // Turn off the server and peer verification (TrustManager Concept).
			 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			
			 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			 curl_setopt($ch, CURLOPT_POST, 1);
		
		 // Set the API operation, version, and API signature in the request.
			$nvpreq = 			"METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_	";
		
		 // Set the request as a POST FIELD for curl.
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
		
		 // Get response from the server.
		 $httpResponse = curl_exec($ch);
		
		 if( !$httpResponse)
		 {
		  exit("$methodName_ failed: " . curl_error($ch) . '(' . curl_errno($ch) .')');
		 }
		
		 // Extract the response details.
		 $httpResponseAr = explode("&", $httpResponse);
		
		 $httpParsedResponseAr = array();
		 foreach ($httpResponseAr as $i => $value)
		 {
			  $tmpAr = explode("=", $value);
			  if(sizeof($tmpAr) > 1)
			  {
			   $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
			  }
		 }
		
		 if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr))
		 {
		  exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
		 }
		
		 return $httpParsedResponseAr;
}
//PAYPAL CALL
function set_paypal_param($user_data){
		
		$emailSubject = urlencode('PayPal payment');
		$receiverType = urlencode('EmailAddress');
		$currency = urlencode($user_data['currency']); // or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
		
		// Receivers
		// Use '0' for a single receiver. In order `to add new ones: (0, 1, 2, 3...)
		// Here you can modify to obtain array data from database.
		$receivers = array(
		  0 => array(
			'receiverEmail' => $user_data['account_number'],//"user1@paypal.com", 
			'amount' => "20.1",
			'uniqueID' => "id_003", // 13 chars max
			'note' => " payment of commissions"), // I recommend use of space at beginning of string.
		  
		);
		$receiversLenght = count($receivers);
		
		// Add request-specific fields to the request string.
		$nvpStr="&EMAILSUBJECT=$emailSubject&RECEIVERTYPE=$receiverType&CURRENCYCODE=$currency";
		
		$receiversArray = array();
		
		for($i = 0; $i < $receiversLenght; $i++)
		{
		 $receiversArray[$i] = $receivers[$i];
		}
		
		foreach($receiversArray as $i => $receiverData)
		{
		 $receiverEmail = urlencode($receiverData['receiverEmail']);
		 $amount = urlencode($receiverData['amount']);
		 $uniqueID = urlencode($receiverData['uniqueID']);
		 $note = urlencode($receiverData['note']);
		 $nvpStr .= "&L_EMAIL$i=$receiverEmail&L_Amt$i=$amount&L_UNIQUEID$i=$uniqueID&L_NOTE$i=$note";
		}
		
		// Execute the API operation; see the PPHttpPost function above.
		$httpParsedResponseAr = PPHttpPost('MassPay', $nvpStr);
		//echo "<pre>"; print_r($httpParsedResponseAr); exit;
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
		{
		 //exit('MassPay Completed Successfully: ' . print_r($httpParsedResponseAr, true));
		 return $httpParsedResponseAr;
		}
		else
		{
		 //exit('MassPay failed: ' . print_r($httpParsedResponseAr, true));
		 return $httpParsedResponseAr;
		}


}
//End PAYPAL Section**********************

//PAYZA Section**********************
function payza_transaction(){

	//Setting information about the transaction
	//$receivedSecurityCode = $_POST['ap_securitycode'];
	$senderEmailAddress ="abc@gmail.com";
    $receiverEmailAddress = "abc.team@gmail.com";
	$testModeStatus = "1";	 
	//$transactionReferenceNumber = $_POST['ap_referencenumber'];
	$currency = "USD"; 		
	$paymentAmount = "20.2";
    $transactionType = "masspay";	
	//$transactionDate= $_POST['ap_transactiondate'];
	//$myCustomField= $_POST['ap_mpcustom'];
	
	//Setting the information about the MassPay from the IPN post variables
    $batchNumber = $_POST['ap_batchnumber'];
	$apiReturnCode = "100";
	$apiReturnCodeDescription = $_POST['ap_returncodedescription'];


	 $API_UserName = urlencode('ejuicy.team@gmail.com');
	 $API_Password = urlencode('eJuicy@123');

	$API_Endpoint = "https://api.payza.com/svc/api.svc/sendmoney";
 // Set the curl parameters.
	 $ch = curl_init();
	 curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	 curl_setopt($ch, CURLOPT_VERBOSE, 1);

 // Turn off the server and peer verification (TrustManager Concept).
	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 	 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

 	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 	 curl_setopt($ch, CURLOPT_POST, 1);

 // Set the API operation, version, and API signature in the request.
	 $nvpreq = 
"USER=$API_UserName&PASSWORD=$API_Password&AMOUNT=$paymentAmount&CURRENCY=$currency&RECEIVEREMAIL=$receiverEmailAddress &SENDEREMAIL=$senderEmailAddress&PURCHASETYPE=1&OTE=This+is+a+test+transaction.&TESTMODE=$testModeStatus"; 

 // Set the request as a POST FIELD for curl.
	 curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

 // Get response from the server.
	 $httpResponse = curl_exec($ch);
	 echo"<pre>"; print_r($httpResponse); exit;


	if ($receivedMerchantEmailAddress != MY_MERCHANT_EMAIL) {
		// The data was not meant for the business profile under this email address.
		// Take appropriate action 
	}
	else {	
		//Check if the security code matches
		if ($receivedSecurityCode != IPN_SECURITY_CODE) {
  		    // The data is NOT sent by Payza.
			// Take appropriate action.
		}
		else {
            if ($transactionType == "masspay") {
				if ($apiReturnCode == "100") {
					if ($testModeStatus == "1") {
						// Since Test Mode is ON, no transaction reference number will be returned.
						// Your site is currently being integrated with Payza IPN for TESTING PURPOSES
						// ONLY. Don't store any information in your production database and 
						// DON'T process this transaction as a real MassPay payment.				
					}
					else {
						// This REAL transaction is complete and the amount was paid successfully to the recipient.
						// Check that there is a TRANSACTION REFERENCE NUMBER that was returned for this payment.
					}
				}
				else {
					// The transaction did not complete. 
                    // Check the return code and its description for more information.
				}
			}
			else {
				// The transaction type is not "masspay", take appropriate action.
			}
		}
	}
}


function payza_handler(){

 	//The value is the url address of IPN V2 handler and the identifier of the token string 
	define("IPN_V2_HANDLER", "https://secure.payza.com/ipn2.ashx");
	define("TOKEN_IDENTIFIER", "token=");
	
	// get the token from Payza
	$token = urlencode($_POST['token']);

	//preappend the identifier string "token=" 
	$token = TOKEN_IDENTIFIER.$token;
	
	/**
	 * 
	 * Sends the URL encoded TOKEN string to the Payza's IPN handler
	 * using cURL and retrieves the response.
	 * 
	 * variable $response holds the response string from the Payza's IPN V2.
	 */
	
	$response = '';
	
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, IPN_V2_HANDLER);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $token);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	$response = curl_exec($ch);

	curl_close($ch);
	
	if(strlen($response) > 0)
	{
		if(urldecode($response) == "INVALID TOKEN")
		{
			//the token is not valid
		}
		else
		{
			//urldecode the received response from Payza's IPN V2
			$response = urldecode($response);
			
			//split the response string by the delimeter "&"
			$aps = explode("&", $response);
				
			//create a file to save the response information from Payza's IPN V2	
			$myFile = "IPNRes.txt";
			$fh = fopen($myFile,'a') or die("can't open the file");
			
			//define an array to put the IPN information
			$info = array();
			
			foreach ($aps as $ap)
			{
				//put the IPN information into an associative array $info
				$ele = explode("=", $ap);
				$info[$ele[0]] = $ele[1];
				
				//write the information to the file IPNRes.txt
				fwrite($fh, "$ele[0] \t");
				fwrite($fh, "=\t");
				fwrite($fh, "$ele[1]\r\n");
			}
			
			fclose($fh);
			
			//setting information about the transaction from the IPN information array
			$receivedMerchantEmailAddress = $info['ap_merchant'];
			$transactionStatus = $info['ap_status'];
			$testModeStatus = $info['ap_test'];
			$purchaseType = $info['ap_purchasetype'];
			$totalAmountReceived = $info['ap_totalamount'];
			$feeAmount = $info['ap_feeamount'];
			$netAmount = $info['ap_netamount'];
			$transactionReferenceNumber = $info['ap_referencenumber'];
			$currency = $info['ap_currency'];
			$transactionDate = $info['ap_transactiondate'];
			$transactionType = $info['ap_transactiontype'];
			
			//setting the customer's information from the IPN information array
			$customerFirstName = $info['ap_custfirstname'];
			$customerLastName = $info['ap_custlastname'];
			$customerAddress = $info['ap_custaddress'];
			$customerCity = $info['ap_custcity'];
			$customerState = $info['ap_custstate'];
			$customerCountry = $info['ap_custcountry'];
			$customerZipCode = $info['ap_custzip'];
			$customerEmailAddress = $info['ap_custemailaddress'];
			
			//setting information about the purchased item from the IPN information array
			$myItemName = $info['ap_itemname'];
			$myItemCode = $info['ap_itemcode'];
			$myItemDescription = $info['ap_description'];
			$myItemQuantity = $info['ap_quantity'];
			$myItemAmount = $info['ap_amount'];
			
			//setting extra information about the purchased item from the IPN information array
			$additionalCharges = $info['ap_additionalcharges'];
			$shippingCharges = $info['ap_shippingcharges'];
			$taxAmount = $info['ap_taxamount'];
			$discountAmount = $info['ap_discountamount'];
			
			//setting your customs fields received from the IPN information array
			$myCustomField_1 = $info['apc_1'];
			$myCustomField_2 = $info['apc_2'];
			$myCustomField_3 = $info['apc_3'];
			$myCustomField_4 = $info['apc_4'];
			$myCustomField_5 = $info['apc_5'];
			$myCustomField_6 = $info['apc_6'];
			
		}
	}
	else
	{
		//something is wrong, no response is received from Payza
	}
}
//End PAYZA Section**********************

//STRIPE Section**********************
function stripe_transaction($data_array){
	//echo "<pre>"; print_r($data_array); ;
		$config['stripe_key_test_public']         = 'pk_test_hqeycZpBUUeQsvm7hjY58QfX';
		$config['stripe_key_test_secret']         = 'sk_test_LWfQ0z6BTa1HhMhpq9yoVnAp';
		$config['stripe_key_live_public']         = 'pk_live_Y7a2ERDwQOkmyMXwGITKo6Ej';
		$config['stripe_key_live_secret']         = 'sk_live_UkuUxw6s7Q9Wfm8Tqavrx9Y2';
		$config['stripe_test_mode']               = TRUE;
		$config['stripe_verify_ssl']              = FALSE;
		
		// Create the library object
		$stripe = new Stripe( $config );
		$account_id=urlencode($data_array['account_number']);
		$amount=$data_array['amount'];
		$currency = $data_array['currency']; 	
		// Run the required operations
		$res= $stripe->transfer($account_id, $amount, $currency);//example cus_6E3AjBYj8TuJv7
		$result=(json_decode($res));
		//echo "<pre>"; print_r($result); exit;
		return $result;
		//require(dirname(__FILE__) . '/stripe/lib/Stripe.php');
		//////////////////////////////////////////////////////////////////
			Stripe::setApiKey("sk_test_LWfQ0z6BTa1HhMhpq9yoVnAp");
		//	echo Stripe::getApiKey();
			//$strip=Stripe::setApiKey($api_key);
			//echo "<pre>"; print_r($strip); exit;
		$result=Transfer::create(array(
		  "amount" => 400,
		  "currency" => "usd",
		  "destination" => "self",
		  "description" => "Transfer for test@example.com"
		));
		return $result; 
		//echo Stripe_Error::getJsonBody();

}
// End STRIPE Section**********************

//SKRILL Section**********************
function skrill_transaction($data_array){
		$CI =& get_instance();
		$CI->load->model('mod_manage');
		$result=$CI->mod_manage->get_gateway();
	//Setting information about the transaction
	//$receivedSecurityCode = $_POST['ap_securitycode'];
    $receiverEmailAddress = urlencode($result[1]['gatway_account']);//merchant account id
	$testModeStatus = "1";	 
	//$transactionReferenceNumber = $_POST['ap_referencenumber'];
	$currency = $data_array['currency']; 		
	$paymentAmount =$data_array['amount'];
 	$API_UserName = urlencode($data_array['account_number']);
 	$API_Password = md5(urlencode($data_array['password']));

	$API_Endpoint = "https://www.moneybookers.com/app/pay.pl";
	 // Set the curl parameters.
	 $ch = curl_init();
	 curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	 curl_setopt($ch, CURLOPT_VERBOSE, 1);
	
	 // Turn off the server and peer verification (TrustManager Concept).
	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt($ch, CURLOPT_POST, 1);
	
	 // Set the API operation, version, and API signature in the request.
	 $nvpreq = 	"action=prepare&email=$API_UserName&password=$API_Password&amount=$paymentAmount&currency=USD&bnf_email=$receiverEmailAddress&subject=some_subject&note=some_note"; 
	
	 // Set the request as a POST FIELD for curl.
	// echo  $nvpreq; exit;
	 curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
	
	 // Get response from the server.
	 $httpResponse = curl_exec($ch);
	 //echo "<pre>"; print_r(urldecode($httpResponse)); exit;
	return $httpResponse;
}
//End SKRILL Section**********************