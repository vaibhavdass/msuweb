<?php
/*
******************************************************************
* COMPANY    - FSS Pvt. Ltd.
******************************************************************
Name of the Program : Hosted UMI Sample Pages
Page Description    : Allows Merchant to connect Payment Gateway and send request
Request parameters  : TranporatID,TranportalPassword,Action,Amount,Currency,Merchant 
Response/Error URL & TrackID,Language,UDF1-UDF
Hashing Parameters	: TranporatID,TrackID,Amount,Currency,Action
Response parameters : Payment Id, Pay Page URL, Error
Values from Session : No 
Values to Session   : No
Created by          : FSS Payment Gateway Team
Created On          : 12-03-2013
Version             : Version 4.1
****************************************************************
The set of pages are developed and tested using below set of hardware and software only. 
In case of any issues noticed by merchant during integration, merchant can contact respective bank 
for technical assistance

NOTE - 
This sample pages are developed and tested on below platform

PHP  Version     - 5.3.5
Web/App Server   - Apache 2.2.17/Wamp 2.1
Operating System - Windows 2003/7
*****************************************************************
*/

/*
Disclaimer:- Important Note in Pages
- Transaction data should only be accepted once from a browser at the point of input, and then kept 
in a way that does not allow others to modify it (example server session, database  etc.)

- Any transaction information displayed to a customer, such as amount, should be passed only as 
display information and the actual transactional data should be retrieved from the secure source 
last thing at the point of processing the transaction.

- Any information passed through the customer's browser can potentially be modified/edited/changed
/deleted by the customer, or even by third parties to fraudulently alter the transaction data/
information. Therefore, all transaction information should not be passed through the browser to 
Payment Gateway in a way that could potentially be modified (example hidden form fields). 
*/

/* 
BELOW ARE LIST OF PARAMETERS THAT WILL BE RECEIVED BY MERCHANT FROM PAYMENT GATEWAY 
*/
try {
	$mageFilename = '../app/Mage.php';
	require_once $mageFilename;
	Mage::app();

	/* Capture the IP Address from where the response has been received */
	$strResponseIPAdd = getenv('REMOTE_ADDR');
	$ResTrackID = isset($_POST['trackid']) ? $_POST['trackid'] : '';        //Merchant Track ID
	$_order_orig = Mage::getModel('sales/order')->loadByIncrementId($ResTrackID);
	$store_id = $_order_orig->getStoreId();
	// Mage::log($_POST, null, 'mylogfile87.log');
	/* Check whether the IP Address from where response is received is PG IP */
	if ($strResponseIPAdd != "221.134.101.175" && $strResponseIPAdd != "221.134.101.166" && $strResponseIPAdd != "221.134.101.167" && $strResponseIPAdd != "221.134.101.187" && $strResponseIPAdd != "125.17.18.200" && $strResponseIPAdd != "119.226.198.10") {
		/*
		IMPORTAN NOTE - IF IP ADDRESS MISMATCHES, ME LOGS DETAILS IN LOGS,
		UPDATES MERCHANT DATABASE WITH PAYMENT FAILURE, REDIRECTS CUSTOMER 
		ON FAILURE PAGE WITH RESPECTIVE MESSAGE
		*/
		/*
		<!-- 
		to get the IP Address in case of proxy server used
		function getIPfromXForwarded() { 
		$ipString=@getenv("HTTP_X_FORWARDED_FOR"); 
		$addr = explode(",",$ipString); 
		return $addr[sizeof($addr)-1]; 
		} 
		*/
			$REDIRECT = 'REDIRECT=http://www.mysoresareeudyog.com/index.php/checkout/onepage/failure/?ResError=--IP MISSMATCH-- Response IP Address is: '.$strResponseIPAdd;
		echo $REDIRECT;
	} else {	
		/*Variable Declaration*/
		/*=========================================================================================*/
		$ResErrorText= isset($_POST['ErrorText']) ? $_POST['ErrorText'] : ''; 	//Error Text/message
		$ResPaymentId = isset($_POST['paymentid']) ? $_POST['paymentid'] : '';	//Payment Id
		$ResTrackID = isset($_POST['trackid']) ? $_POST['trackid'] : '';        //Merchant Track ID
		$ResErrorNo = isset($_POST['Error']) ? $_POST['Error'] : '';            //Error Number
		$ResResult = isset($_POST['result']) ? $_POST['result'] : '';           //Transaction Result
		$ResPosdate = isset($_POST['postdate']) ? $_POST['postdate'] : '';      //Postdate
		$ResTranId = isset($_POST['tranid']) ? $_POST['tranid'] : '';           //Transaction ID
		$ResAuth = isset($_POST['auth']) ? $_POST['auth'] : '';                 //Auth Code		
		$ResAVR = isset($_POST['avr']) ? $_POST['avr'] : '';                    //TRANSACTION avr					
		$ResRef = isset($_POST['ref']) ? $_POST['ref'] : '';                    //Reference Number also called Seq Number
		$ResAmount = isset($_POST['amt']) ? $_POST['amt'] : '';                 //Transaction Amount
		$Resudf1 = isset($_POST['udf1']) ? $_POST['udf1'] : '';                  //UDF1
		$Resudf2 = isset($_POST['udf2']) ? $_POST['udf2'] : '';                  //UDF2
		$Resudf3 = isset($_POST['udf3']) ? $_POST['udf3'] : '';                  //UDF3
		$Resudf4 = isset($_POST['udf4']) ? $_POST['udf4'] : '';                  //UDF4
		$Resudf5 = isset($_POST['udf5']) ? $_POST['udf5'] : '';                  //UDF5			

		// $_order_orig = Mage::getModel('sales/order')->loadByIncrementId($ResTrackID);
		// $store_id = $_order_orig->getStoreId();

		// Mage::log($ResResult,null,'test.log');
		// Mage::log($ResPaymentId,null,'test1.log');
		// Mage::log($ResAuth,null,'test2.log');
		// Mage::log($ResRef,null,'test3.log');
		// Mage::log($ResTranId,null,'test4.log');
		// Mage::log($ResTrackID,null,'test5.log');
		// Mage::log($ResAmount,null,'test6.log');
		// Mage::log($ResErrorText,null,'test7.log');
		// Mage::log($ResErrorNo,null,'test8.log');

		/*LIST OF PARAMETERS RECEIVED BY MERCHANT FROM PAYMENT GATEWAY ENDS HERE */
		/*/=================================================================================================	*/

		/* 
		First check, if error number is NOT present,then go for Hashing using required parameters 
		*/
		/* 
		NOTE - MERCHANT MUST LOG THE RESPONSE RECEIVED IN LOGS AS PER BEST PRACTICE. Since the
		logging mechanism is merchant driven, the sample code for same is not provided in this
		pages
		*/
		if ($ResErrorNo == '') {          
			/*******************HASHING CODE LOGIC START************************************/
			/*IMP NOTE: For Hashing below listed parameters have been used. In case merchant develops 
			his/her own pages, merchant to 		make note of these parameters to ensure hashing 
			logic remains same.
			Tranportal ID, TrackID, Amount, Result, Payment ID, Reference Number, Auth Code, Transaction ID 

			If any Hashing parameters is null of blank then merchant need to exclude those parameters 
			from hashing*/					

			/*
			USE Tranportal ID FIELD as one parameter for hashing.
			Tranportal ID is a sensitive parameter, Merchant can store the Tranportal ID field in 
			database as well in page as config value. We recommend merchant storing this parameter 
			in database and then calling from database.
			*/
			// Mage::log($ResResult, null, 'naresh87.log');
			if ($ResResult == 'CAPTURED' || $ResResult == 'APPROVED') {
				if($_order_orig['order_currency_code']=='AUD') {
					$strHashTraportalID=trim("79090063");
				} else if($_order_orig['order_currency_code']=='USD') {
					$strHashTraportalID=trim("79020668");
				} else if($_order_orig['order_currency_code']=='SGD') {
					$strHashTraportalID=trim("79080042");
				} else if($_order_orig['order_currency_code']=='EUR') {
					$strHashTraportalID=trim("79040215");
				} else if($_order_orig['order_currency_code']=='GBP') {
					$strHashTraportalID=trim("79030216");
				} else if($_order_orig['order_currency_code']=='AED') {
					$strHashTraportalID=trim("79050058");
				} else if($_order_orig['order_currency_code']=='CAD') {
					$strHashTraportalID=trim("79110029");
				} else {
					$strHashTraportalID=trim("70011206");
				}

				// // $strHashTraportalID=trim("XXXXX"); //USE Tranportal ID FIELD FOR HASHING ,Mercahnt need to take this filed value  from his Secure channel such as DATABASE.
				$strhashstring1='';            //Declaration of Hashing String 

				$strhashstring1=trim($strHashTraportalID);

				//Below code creates the Hashing String also it will check NULL and Blank parmeters and exclude from the hashing string
				if ($ResTrackID != '' && $ResTrackID != null )
					$strhashstring1=trim($strhashstring1).trim($ResTrackID);					
				if ($ResAmount != '' && $ResAmount != null )
					$strhashstring1=trim($strhashstring1).trim($ResAmount);					
				if ($ResResult != '' && $ResResult != null )
					$strhashstring1=trim($strhashstring1).trim($ResResult);					
				if ($ResPaymentId != '' && $ResPaymentId != null )
					$strhashstring1=trim($strhashstring1).trim($ResPaymentId);					
				if ($ResRef != '' && $ResRef != null )
					$strhashstring1=trim($strhashstring1).trim($ResRef);					
				if ($ResAuth != '' && $ResAuth != null )
					$strhashstring1=trim($strhashstring1).trim($ResAuth);					
				if ($ResTranId != '' && $ResTranId != null )
					$strhashstring1=trim($strhashstring1).trim($ResTranId);

				//Use sha256 method which is defined below for Hashing ,It will return Hashed valued of above strin	
				$hashvalue= hash('sha256', $strhashstring1);

				/*******************HASHING CODE LOGIC END************************************/

				if ($hashvalue == $Resudf5) {
					/* NOTE - MERCHANT MUST LOG THE RESPONSE RECEIVED IN LOGS AS PER BEST PRACTICE */
					/*IMPORTANT NOTE - MERCHANT DOES RESPONSE HANDLING AND VALIDATIONS OF 
					TRACK ID, AMOUNT AT THIS PLACE. THEN ONLY MERCHANT SHOULD UPDATE 
					TRANACTION PAYMENT STATUS IN MERCHANT DATABASE AT THIS POSITION 
					AND THEN REDIRECT CUSTOMER ON RESULT PAGE*/

					/* !!IMPORTANT INFORMATION!!
					During redirection, ME can pass the values as per ME requirement.
					NOTE: NO PROCESSING should be done on the RESULT PAGE basis of values passed in the RESULT PAGE from this page. 
					ME does all validations on the responseURL page and then redirects the customer to RESULT PAGE ONLY FOR RECEIPT PRESENTATION/TRANSACTION STATUS CONFIRMATION
					For demonstration purpose the result and track id are passed to Result page	*/

					/* Hashing Response Successful	*/

						$REDIRECT = 'REDIRECT=http://www.mysoresareeudyog.com/index.php/checkout/onepage/success?ResResult=TRANSACTION SUCESSFUL&ME_TX_ID='.$ResTrackID;
					echo $REDIRECT;
				} else {
					/* NOTE - MERCHANT MUST LOG THE RESPONSE RECEIVED IN LOGS AS PER BEST PRACTICE */
					/*Udf5 field values not matched with calculetd hashed valued then show appropriate message to
					Mercahnt for E.g.Hashing Response NOT Successful*/

					/* Hashing Response NOT Successful */
						$REDIRECT = 'REDIRECT=http://www.mysoresareeudyog.com/index.php/checkout/onepage/failure?ResError=HASHING RESPONSE MISMATCH';
					echo $REDIRECT;														
				}
			} else {
				/* PAYMENT GATEWAY RESPONSE IS NOT CAPTURED */
					$REDIRECT = 'REDIRECT=http://www.mysoresareeudyog.com/index.php/checkout/onepage/failure?ResError=TRANSACTION FAILURE';
				echo $REDIRECT;														
			}
		} else {
			/*ERROR IN TRANSACTION processing
			IMPORTANT NOTE - MERCHANT SHOULD UPDATE 
			TRANACTION PAYMENT STATUS IN MERCHANT DATABASE AT THIS POSITION 
			AND THEN REDIRECT CUSTOMER ON RESULT PAGE*/

				$REDIRECT = 'REDIRECT=http://www.mysoresareeudyog.com/index.php/checkout/onepage/failure?ResResult='.$ResResult;
			echo $REDIRECT;
		}
	}	
}
catch(Exception $e) {
	var_dump($e->getMessage());
} ?>