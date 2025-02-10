<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');
include ('remita_constants.php');

$mysqli = link_connect_db();

$orgsetins = settns();

function remita_transaction_details($rrr)
{
	$mert =  MERCHANTID;
	$api_key =  APIKEY;
	
	$concatString = $rrr . $api_key . $mert;
	$hash = hash('sha512', $concatString);
	$url = CHECKSTATUSURL . '/' . $mert  . '/' . $rrr . '/' . $hash . '/' . 'status.reg';

	//  Initiate curl
	$ch = curl_init();
	// Disable SSL verification
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Will return the response, if false it print the response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Set the url
	curl_setopt($ch, CURLOPT_URL, $url);
	// Execute
	$result=curl_exec($ch);
	// Closing
	curl_close($ch);

	//var_dump($result) .'<p>';
	
	$response = json_decode($result, true);
	return $response;
}

if (isset($_REQUEST['ilin']) && isset($_REQUEST['mm']) && isset($_REQUEST['sm']))
{
	$file_chk = check_file('5000000', '1');
	if ($file_chk <> '')
	{
		//echo $file_chk;
		//exit;
	}
	
	$file_name = 'appl_record.csv';
	$dir_name = "../../ext_docs/docs/";
	$file = $dir_name . '/' . $file_name;
	
	@unlink($file);
	
	if (!move_uploaded_file($_FILES["sbtd_pix"]["tmp_name"], $file))
	{
		echo "We are Sorry, there was an error uploading your file.";exit;
	}else
	{
		chmod($file, 0755);
		log_actv('Uploaded file '.$file);
		
		$handle = fopen("$file", "r");
		
		$c = 0;
		$feed_back = '';

		$err_count = 0;
		
		$number_of_transactions = 0;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{
			if (count($data) <> 7) 
			{
				fclose($handle);
				chmod($file, 0755);
				unlink($file) or die("Couldn't continue process ");

				echo 'There should be 7 columns of data';
				exit;
			}

			//$lastname = clean_str($data[0]);
			$lastname = strtoupper(clean_string($data[0], 'names'));

			//$firstname = clean_str($data[1]);
			$firstname = ucwords(strtolower(clean_string($data[1], 'names')));

			//$othernames = clean_str($data[2]);
			$othernames = ucwords(strtolower(clean_string($data[2], 'names')));

			// $lastname = strtoupper(trim($data[0]));
			// $firstname = ucfirst(strtolower(trim($data[1])));
			// $othernames = ucfirst(strtolower(trim($data[2])));
			$all_names = $lastname.' '.$firstname.' '.$othernames;
			
			
			//$phone = clean_str($data[3]);
			$phone = clean_string($data[3], 'numbers');
			//$phone = trim($data[3]);
			
			
			if ($phone == '')
			{
			    $feed_back .= ++$err_count.' '.$all_names.' empty '.$phone.' phone number<br>';
			    continue;
			}
			

			if (substr($phone,0,1) <> '0')
			{
			    $phone = '0'.$phone;
			}
			
			if (!is_numeric($phone))
			{
			    $feed_back .= ++$err_count.' '.$all_names.' invalid '.$phone.' phone number<br>';
			    continue;
			}
			
			if (!is_bool(strpos($phone,"+")) || !is_bool(strpos($phone,"-")))
			{
			    $feed_back .= ++$err_count.' '.$all_names.' '.$phone.' has + or - sign<br>';
			    continue;
			}

			if (strlen($phone) <> 11)
			{
			    $feed_back .= ++$err_count.' '.$all_names.' invalid '.$phone.' phone number<br>';
			    continue;
			}
			
			//$email = clean_str($data[4]);
			$email = clean_string($data[4], 'email');
			//$email = trim($data[4]);
			if ($email == '')
			{
			    $feed_back .= ++$err_count.' '.$all_names.' empty '.$email.' email<br>';
			    continue;
			}
			
			
			//$educat1 = clean_str($data[5]);
			$educat1 = strtolower(clean_string($data[5], 'letters'));
			//$educat1 = strtolower(trim($data[5]));
 			

			//$rrr = clean_str($data[6]);
			$rrr = clean_string($data[6], 'numbers');
			//$rrr = trim($data[6]);
			if ($rrr == '')
			{
			     $feed_back .= ++$err_count.' '.$all_names .' no rrr<br>';
			    continue;
			}
				if (!is_numeric($rrr))
			{
			     $feed_back .= ++$err_count.' '.$all_names.' '.$rrr.' invalid rrr<br>';
			    continue;
			}
			
			if (!is_bool(strpos($rrr,"+")))
			{
			    $feed_back .= ++$err_count.' '.$all_names.' '.$rrr.' has + sign<br>';
			    continue;
			}


			$Regno = '';

			$stmt = $mysqli->prepare("SELECT Regno, payerName FROM remitapayments_app WHERE RetrievalReferenceNumber = ?");
			$stmt->bind_param("s", $rrr);
			$stmt->execute();
			$stmt->store_result();
			$rrr_upldd = $stmt->num_rows;
			$stmt->bind_result($Regno, $payerName);
			$stmt->fetch();
			
			if (is_null($Regno))
			{
				$Regno = '';
			}
						 
			if ($Regno <> '')
			{
				$in_prog_choice = 0;
				$stmt = $mysqli->prepare("SELECT * FROM prog_choice WHERE vApplicationNo  = ?");
				$stmt->bind_param("s", $Regno);
				$stmt->execute();
				$stmt->store_result();
				$in_prog_choice = $stmt->num_rows;

				$in_ap_client = 0;
				$stmt = $mysqli->prepare("SELECT * FROM app_client WHERE vApplicationNo  = ?");
				$stmt->bind_param("s", $Regno);
				$stmt->execute();
				$stmt->store_result();
				$in_ap_client = $stmt->num_rows;
				
				if ($in_prog_choice <> 0 && $in_ap_client <> 0)
				{
					$feed_back .= ++$err_count.' '.$all_names.' '.$Regno.' has AFN already<br>';
					continue;
				}
			}

			// if ($rrr_upldd > 0)
			// {
			// 	$feed_back .= ++$err_count.' '.$all_names.' '.$rrr.' already uploaded for '.$payerName.'<br>';
			// 	continue;
			// }
			

			/*$stmt = $mysqli->prepare("SELECT * FROM remitapayments WHERE RetrievalReferenceNumber = ?");
			$stmt->bind_param("s", $rrr);
			$stmt->execute();
			$stmt->store_result();
			$rrr_upldd = $stmt->num_rows;

			if ($rrr_upldd > 0)
			{
				$feed_back .= ++$err_count.' '.$all_names.' '.$rrr.' *already uploaded for '.$payerName.'<br>';
				continue;
			}

			$stmt = $mysqli->prepare("SELECT * FROM s_tranxion_cr WHERE RetrievalReferenceNumber = ?");
			$stmt->bind_param("s", $rrr);
			$stmt->execute();
			$stmt->store_result();
			$rrr_upldd = $stmt->num_rows;

			if ($rrr_upldd > 0)
			{
				$feed_back .= ++$err_count.' '.$all_names.' '.$rrr.' **already uploaded for '.$payerName.'<br>';
				continue;
			}*/

			
			$stmt = $mysqli->prepare("DELETE FROM remitapayments_app 
			WHERE Regno = '' 
			AND (payerEmail = ?
			OR payerPhone = ?)
			AND RetrievalReferenceNumber <> ? 
			AND Status = 'Pending'");
			$stmt->bind_param("sss", $email, $phone, $rrr);
			$stmt->execute();

			$response_code = '';
			$response_message = '';
			$orderid = '';
			$dat = '';
			$amount = 0.0;

			$response = remita_transaction_details($rrr);
			
			//var_dump($response) .'<p>';
			if (isset($response['status']))
			{
				if ($response['status'] == '998')
				{
					$feed_back .= ++$err_count.' '.$all_names.' RRR '.$rrr.' refer to Bursary<br>';
					continue;
				}

				if ($response['status'] <> '00' && $response['status'] <> '01')
				{
					$feed_back .= ++$err_count.' '.$all_names.' RRR '.$rrr.' pending<br>';
					continue;
				}				
				
				if (isset($response['status']))
				{
					$response_code = trim($response['status']);
				}
				
				if (isset($response['message']))
				{
					$response_message = trim($response['message']);
				}
				
				if (isset($response['orderId']))
				{
					$orderid = trim($response['orderId']);
				}
				
				if (isset($response['transactiontime']))
				{
					$dat = trim($response['transactiontime']);
				}
				
				if (isset($response['amount']))
				{
					$amount = trim($response['amount']);
				}
			}
        	
        	
        	if ($amount == 0.0 || $amount > 20000)
			{
			    $feed_back .= ++$err_count.' '.$all_names.' amount '.$amount.' invalid amount of '.$amount.'<br>';
			    continue;
			}
			
			$educat = '';
			if ($educat1 == 'phd')
			{
			    $educat = 'PRX';
			}else if (strtolower($educat1) == 'mphil')
			{
			    $educat = 'PGZ';
			}else if (strtolower($educat1) == 'masters')
			{
			    $educat = 'PGY';
			}else if (strtolower($educat1) == 'pgd')
			{
			    $educat = 'PGX';
			}else if (strtolower($educat1) == 'ug')
			{
			    $educat = 'PSZ';
			}else
			{
			    $feed_back .= ++$err_count.' '.$all_names.' programme category not indicated <br>';
			    continue;
			}
			
        	
        	if ($educat == 'PSZ' && $amount <> 5000)
			{
			    $feed_back .= ++$err_count.' '.$all_names.' amount '.$amount.' does not match '.strtoupper($educat1).'<br>';
			    continue;
			}else if (($educat == 'PRX' || $educat == 'PGZ') && $amount <> 20000)
			{
			     $feed_back .= ++$err_count.' '.$all_names.' amount '.$amount.' does not match '.strtoupper($educat1).'<br>';
			     continue;
			}else if (($educat == 'PGY' || $educat == 'PGX') && $amount <> 7500)
			{
			    $feed_back .= ++$err_count.' '.$all_names.' amount '.$amount.' does not match '.strtoupper($educat1).'<br>';
			    continue;
			}			
	
			if ($response_code == '00' || $response_code == '01')
			{
			    $Status = 'Successful';
			}else
			{
			    $Status = 'Pending';
			}
			
			
			$stmt = $mysqli->prepare("REPLACE INTO prog_choice_0
			SET vApplicationNo = '',
			cEduCtgId = ?,
			vLastName = ?,
			vFirstName = ?,
			vOtherName = ?,
			vEMailId = ?,
			vMobileNo = ?,
			dAmnt = ?,
			cAcademicDesc = '".$orgsetins['cAcademicDesc']."',
			resident_ctry = '1',
			trans_time = now()");
			$stmt->bind_param("ssssssd", 
			$educat, 
			$lastname,
			$firstname,
			$othernames, 
			$email, 
			$phone, 
			$amount);
			$stmt->execute();

            //echo '<br>'.$educat.', '.$all_names.', '.$lastname.', '.$firstname.', '.$othernames.', '.$email.', '.$phone.', '.$rrr.':'.$response_code.', '.$response_message.', '.$dat.', '.$amount.', '.$response_message.'<br>';
            
			$stmt = $mysqli->prepare("INSERT IGNORE INTO remitapayments_app
    		SET Regno = '',
            payerName = ?,
            vLastName = ?,
            vFirstName = ?,
            vOtherName = ?,
            payerEmail = ?,
            payerPhone = ?,
            cEduCtgId = ?,
            Amount = ?, 
            vDesc = 'Application Fee', 
            MerchantReference = ?,
            AcademicSession = '".$orgsetins['cAcademicDesc']."',
            tSemester = ".$orgsetins['tSemester'].",
            RetrievalReferenceNumber = ?,
            TransactionDate = ?,
            Status = 'Pending'");
            
			$stmt->bind_param("sssssssdsss",
			$all_names, 
			$lastname,
    		$firstname, 
			$othernames, 
			$email, 
			$phone, 
			$educat,
			$amount,
			$orderid,
			$rrr,
			$dat);
			$stmt->execute();

			log_actv('Uploaded application payment detail for '.$rrr);
    		
			$c++;
		}
		
		if (isset($stmt))
		{
		    $stmt->close();
		}
	}
	
	echo $c.' record(s) uploaded successfully';
	
	if ($feed_back <> '')
	{
	    echo '<p><b>Records not uploaded</b><br>'.$feed_back;
	}
	exit;
}?>