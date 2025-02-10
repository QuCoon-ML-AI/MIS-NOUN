<?php
// Date in the past

/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('../../PHPMailer/mail_con.php');
require_once('lib_fn.php');

require_once ('remita_constants.php');


$cFacultyId = '';

$payerName = '';
$payerEmail = '';
$payerPhone = '';
$orderId = "";
$regno = "";
$amount = '';
$vDesc = '';
$iItemID = '';
	
$session = '';
$rrr = '';

$p_status = '';

$vLastName = '';
$vFirstName = '';
$vOtherName = '';
$external_rrr = '';

$study_mode = '';
$loop_msg = '';

$cStudyCenterId = '';
$cEduCtgId = '';
$iStudy_level = '';

$in_login_table = 0;

$user_cat = '';
$ilin = '';
$passpotLoaded = '';

$orgsetins = settns();

if(isset($_REQUEST['vLastName']) && $_REQUEST['vLastName'] <> ''){$vLastName = $_REQUEST['vLastName'];}
if(isset($_REQUEST['vFirstName']) && $_REQUEST['vFirstName'] <> ''){$vFirstName = $_REQUEST['vFirstName'];}
if(isset($_REQUEST['vOtherName']) && $_REQUEST['vOtherName'] <> ''){$vOtherName = $_REQUEST['vOtherName'];}
	
if(isset($_REQUEST['payerName']) && $_REQUEST['payerName'] <> ''){$payerName = $_REQUEST['payerName'];}
if(isset($_REQUEST['payerEmail']) && $_REQUEST['payerEmail'] <> ''){$payerEmail = $_REQUEST['payerEmail'];}
if(isset($_REQUEST['payerPhone']) && $_REQUEST['payerPhone'] <> ''){$payerPhone = $_REQUEST['payerPhone'];}

if(isset($_REQUEST['regno']) && $_REQUEST['regno'] <> ''){$regno = $_REQUEST['regno'];}

if(isset($_REQUEST['amount']) && $_REQUEST['amount'] <> ''){$amount = $_REQUEST['amount'];}

if(isset($_REQUEST['rrr']) && $_REQUEST['rrr'] <> ''){$rrr = $_REQUEST['rrr'];}

if(isset($_REQUEST['vDesc']) && $_REQUEST['vDesc'] <> ''){$vDesc = $_REQUEST['vDesc'];}
if(isset($_REQUEST['study_mode']) && $_REQUEST['study_mode'] <> ''){$study_mode = $_REQUEST['study_mode'];}
if(isset($_REQUEST['p_status']) && $_REQUEST['p_status'] <> ''){$p_status = $_REQUEST['p_status'];}
if(isset($_REQUEST['orderId']) && $_REQUEST['orderId'] <> ''){$orderId = $_REQUEST['orderId'];}


if(isset($_REQUEST['user_cat']) && $_REQUEST['user_cat'] <> ''){$user_cat = $_REQUEST['user_cat'];}
if(isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> ''){$ilin = $_REQUEST['ilin'];}
if(isset($_REQUEST['passpotLoaded']) && $_REQUEST['passpotLoaded'] <> ''){$passpotLoaded = $_REQUEST['passpotLoaded'];}

if(isset($_REQUEST['cEduCtgId']) && $_REQUEST['cEduCtgId'] <> ''){$cEduCtgId = $_REQUEST['cEduCtgId'];}
							
date_default_timezone_set('Africa/Lagos');
$date2 = date("Y-m-d h:i:s");

$mysqli = link_connect_db();

if ($vDesc == 'Application Fee')
{
	$tSemester = 1;
}else
{
	$stmt = $mysqli->prepare("SELECT tSemester FROM s_m_t WHERE vMatricNo = ?");
	$stmt->bind_param("s", $_REQUEST['vMatricNo']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($tSemester);
	$stmt->fetch();
	$stmt->close();
}

$tSemester = $tSemester ?? '1';



$mysqli = link_connect_db();

if ($rrr <> '' && $rrr <> 'xxxx')
{
	$stmt = $mysqli->prepare("SELECT a.cEduCtgId, a.vQualCodeDesc, b.AcademicSession
	FROM qualification a, remitapayments_app b
	WHERE a.cEduCtgId = b.cEduCtgId
	AND b.RetrievalReferenceNumber = ?");
	$stmt->bind_param("s", $rrr);
}/*else if ($orderId <> '')
{
	$stmt = $mysqli->prepare("SELECT a.cEduCtgId, a.vQualCodeDesc, b.AcademicSession
	FROM qualification a, remitapayments_app b
	WHERE a.cEduCtgId = b.cEduCtgId
	AND b.MerchantReference = ?");
	$stmt->bind_param("s", $orderId);
}*/

$cEduCtgId_loc = ''; $vQualCodeDesc= ''; $AcademicSession = '';
if (($rrr <> ''  && $rrr <> 'xxxx') /*|| $orderId <> ''*/)
{
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cEduCtgId_loc, $vQualCodeDesc, $AcademicSession);
	$stmt->fetch();
	$stmt->close();
}

if ($cEduCtgId_loc <> '')
{
	$cEduCtgId = $cEduCtgId_loc;
}

$session = $orgsetins['cAcademicDesc'];

$responseurl = PATH . "/feed-back-from-rem";

if (!defined('SERVICETYPEID')) 
{
	exit;
}

$serviceTypeID = SERVICETYPEID;
$merchantId = MERCHANTID;
$gatewayUrl = GATEWAYURL;



function remita_transaction_details($orderId, $rrr)
{
	$mert =  MERCHANTID;
	$api_key =  APIKEY;

	if($rrr <> '' && $rrr <> 'xxxx')
	{
		$concatString = $rrr . $api_key . $mert;
		$hash = hash('sha512', $concatString);
		$url = CHECKSTATUSURL . '/' . $mert  . '/' . $rrr . '/' . $hash . '/' . 'status.reg';
	}else
	{
		$concatString = $orderId . $api_key . $mert;
		$hash = hash('sha512', $concatString);
		$url = CHECKSTATUSURL . '/' . $mert  . '/' . $orderId . '/' . $hash . '/' . 'orderstatus.reg';
	}

	//  Initiate curl
	$ch = curl_init();
	// Disable SSL verification
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Will return the response, if false it print the response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Set the url
	curl_setopt($ch, CURLOPT_URL,$url);
	// Execute
	$result=curl_exec($ch);
	// Closing
	curl_close($ch);
	$response = json_decode($result, true);
	return $response;
}

function httpPost($url, $content, $hash, $merchantId)
{
	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_ENCODING, '');

	curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

	curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
	curl_setopt($curl, CURLOPT_HTTPHEADER,  array(
		"Authorization: remitaConsumerKey=$merchantId,remitaConsumerToken=$hash",
		"Content-Type: application/json",
		"cache-control: no-cache"
		));

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}

$content = "{\"serviceTypeId\": \"$serviceTypeID\",
\"amount\": \"$amount\",
\"orderId\": \"$orderId\",
\"payerName\": \"$payerName\",
\"payerEmail\": \"$payerEmail\",
\"payerPhone\": \"$payerPhone\",
\"description\": \"$vDesc\"}";



$regno_01 = '';
$response_code_01 = '';
$Status_01 = '';
$ResponseDescription_01 = '';
$TransactionDate_01 = '';
$amount_01 = '';

$local_pay_record_found = 0;


//ccheck status of pending transaction
/*$stmt = $mysqli->prepare("SELECT RetrievalReferenceNumber, MerchantReference FROM remitapayments_app WHERE vDesc = 'Application Fee' AND Status <> 'Successful' AND MerchantReference <> '$orderId' AND (payerEmail  = ? OR payerPhone  = ?)");
$stmt->bind_param("ss", $payerEmail, $payerPhone);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($rrr_chk, $MerchantReference_chk);
while($stmt->fetch())
{
     $response = remita_transaction_details($MerchantReference_chk, $rrr_chk);
     if (isset($response['status']) && $response['status'] <> '01' && $response['status'] <> '00')
     {
		$mysqli_arch = link_connect_db_arch();
        $stmt_chk = $mysqli_arch->prepare("REPLACE INTO damu82ro_nouonlinenouedu_db2.arch_remitapayments_app SELECT * FROM damu82ro_nouonlinenouedu_db1.remitapayments_app WHERE damu82ro_nouonlinenouedu_db1.remitapayments_app.RetrievalReferenceNumber = '$rrr_chk' OR damu82ro_nouonlinenouedu_db1.remitapayments_app.MerchantReference  = '$MerchantReference_chk'");
        $stmt_chk->execute();
        
        $stmt_chk = $mysqli->prepare("DELETE FROM remitapayments_app WHERE RetrievalReferenceNumber = '$rrr_chk' OR MerchantReference  = '$MerchantReference_chk'");
        $stmt_chk->execute();
        $stmt_chk->close();
     }
}
$stmt->close();*/


/*if ($orderId <> '')
{
	$stmt = $mysqli->prepare("SELECT RetrievalReferenceNumber, Regno, ResponseCode, Status, ResponseDescription, TransactionDate, Amount
	FROM remitapayments_app 
	WHERE MerchantReference = ?");
	$stmt->bind_param("s", $orderId);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($rrr, $regno_01, $response_code_01, $Status_01, $ResponseDescription_01, $TransactionDate_01, $amount_01);
  	$local_pay_record_found = $stmt->num_rows;
	$stmt->fetch();
	$stmt->close();
	if ( $Status_01 <> '')
	{
		$p_status =  $Status_01;
	}
}else*/ if ($rrr <> '' && $rrr <> 'xxxx')
{
	$stmt = $mysqli->prepare("SELECT MerchantReference, Regno, ResponseCode, Status, ResponseDescription, TransactionDate, Amount
	FROM remitapayments_app 
	WHERE RetrievalReferenceNumber = ?");
	$stmt->bind_param("s", $rrr);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($orderId, $regno_01, $response_code_01, $Status_01, $ResponseDescription_01, $TransactionDate_01, $amount_01);
  	$local_pay_record_found = $stmt->num_rows;
	$stmt->fetch();
	$stmt->close();
	if ( $Status_01 <> '')
	{
		$p_status =  $Status_01;
	}
}


$response = remita_transaction_details($orderId, $rrr);
if (isset($response['status']) && $response_code_01 <> '01' && $response_code_01 <> '00')
{
  $response_code = trim($response['status']);
}else
{
  $response_code = $response_code_01;
}

$rspns_message = '';
if (isset($response['message']))
{
  $response_message = trim($response['message']);
}

if (isset($response['transactiontime']))
{
  $dat = trim($response['transactiontime']);
}

if (isset($response['RRR']) && strlen(trim($response['RRR'])) > 4)
{
  $rrr = trim($response['RRR']);
}

//$amount = 0;
if (isset($response['amount']) && $response['amount'] > 0)
{
  $amount = trim($response['amount']);
}

if (isset($response['RRR']) && strlen(trim($response['RRR'])) > 4)
{
  $rrr = trim($response['RRR']);
}



if ($local_pay_record_found == 0)
{
  $stmt1 = $mysqli->prepare("INSERT IGNORE INTO remitapayments_app 
  SET Regno = ?,
  payerName = ?,
  vLastName = ?,
  vFirstName = ?,
  vOtherName = ?,
  payerEmail = ?,
  cEduCtgId = ?,
  payerPhone = ?,
  Amount = ?, 
  MerchantReference = ?,
  AcademicSession = '$session',
  tSemester = $tSemester, 
  vDesc = '$vDesc',
  TransactionDate = NOW(),
  Status = 'Pending'");
  $stmt1->bind_param("ssssssssds", $regno, $payerName, $vLastName, $vFirstName, $vOtherName, $payerEmail, $cEduCtgId, $payerPhone, $amount, $orderId);
  $stmt1->execute();
}

if ($rrr == '' || $rrr == 'xxxx')
{
	$concatString = MERCHANTID.SERVICETYPEID.$orderId.$amount.APIKEY;
	$hash = hash('sha512', $concatString);	
	
  	$url = GATEWAYURL;
  
  	$response = '';
	$response = httpPost($url, $content, $hash, $merchantId);
	
	//echo MERCHANTID.'/'.SERVICETYPEID.'/'.$orderId.'/'.$amount.'/'.APIKEY.'<br>';
	//var_dump($response);
	
	$uncutmsg = $response;
	
	$response = substr($response, 7, -1);
	$response = json_decode($response, true);

	if (isset($response))
	{
		$statuscode = $response['statuscode'];
		$statusMsg = $response['status'];
		
		if($statuscode == '025')
		{
			$rrr = trim($response['RRR']);
			$new_hash_string = MERCHANTID . $rrr . APIKEY;
			$hash = hash('sha512', $new_hash_string);
			$url = GATEWAYRRRPAYMENTURL;

			$stmt1 = $mysqli->prepare("UPDATE remitapayments_app 
			SET RetrievalReferenceNumber = '$rrr'
			WHERE MerchantReference = ?");
			$stmt1->bind_param("s", $orderId);
			$stmt1->execute();
			$stmt1->close();

			$p_status = 'Pending';

			$subject = 'NOUN - Initiation of payment for Application form';
			$mail_msg = 'Dear '.$payerName.',<br><br>You initiated a transaction with respect to the subject matter<br><br>
			The remita retrieval reference (RRR) for the transaction is<br><br>:<b>'.
			$rrr.'</b><p><br>
			<i>You may use available support channels or visit the nearest Study centre for guidance.<p>
			Thank you.';

			$mail_msg = wordwrap($mail_msg, 70);
			
            $mail->addAddress($payerEmail, $payerName);
            $mail->Subject = $subject;
            $mail->Body = $mail_msg;
            
            //for ($incr = 1; $incr <= 5; $incr++)
        	//{
                //try 
                //{
                    //$mysqli->autocommit(FALSE); //turn on transactions
                    
                    if ($mail->send())
                    {
                        log_actv('Sent NOUN - payment order ID to '.$payerEmail);
                        //$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
            			//break;
                    }
                //} catch (Exception $e)
                //{
                    //$mysqli->rollback(); //remove all queries from queue if error (undo)
        	        //throw $e;
                //}
        	//}
		}
	}else if (!is_bool(strpos($uncutmsg, "DUPLICATE_REQUEST")))
	{echo 'x';
	    /*$response = remita_transaction_details($orderId, '');
        
        if (isset($response['RRR']) && strlen(trim($response['RRR'])) > 4)
        {
          $rrr = trim($response['RRR']);
        }*/
        
        //echo $response['message'];
	}
}else if ($orderId <> '' || ($rrr <> '' && $rrr <> 'xxxx'))
{
	if ($response_code_01 <> '01' && $response_code_01 <> '00')
	{
		if (isset($response_code) && $response_code == '01')
		{
			$p_status = 'Successful';			
		}else if (isset($response_code) && $response_code == '021')
		{
			$p_status = 'Pending';
			$new_hash_string = MERCHANTID . $rrr . APIKEY;
			$hash = hash('sha512', $new_hash_string);
			$url = GATEWAYRRRPAYMENTURL;	
		}
	}else
	{
		$response_code = $response_code_01;		
		$response_message = $ResponseDescription_01;
		$dat = $TransactionDate_01;
		$amount = $amount_01;
	}

	if (isset($response_code) && $amount > 0)
	{
		if ($response_code == '00' || $response_code == '01')
		{
			$stmt = $mysqli->prepare("SELECT Regno, vLastName, vFirstName, vOtherName, payerEmail, payerPhone, AcademicSession, cEduCtgId, vDesc, MerchantReference
			FROM remitapayments_app 
			WHERE RetrievalReferenceNumber = ?");
			$stmt->bind_param("s", $rrr);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($regno, $vLastName_02, $vFirstName_02, $vOtherName_02, $payerEmail_02, $payerPhone_02, $AcademicSession_02, $cEduCtgId_02, $vDesc_02, $orderId_02);
			$stmt->fetch();
			$stmt->close();	
			
			if ($cEduCtgId == '' && $cEduCtgId_02 <> '')
			{
				$cEduCtgId = $cEduCtgId_02;
			}

			if ($vDesc == '')
			{
				$vDesc = $vDesc_02;
			}

			if ($vDesc_02 == 'Application Fee')
			{
				/*try
				{
					$mysqli->autocommit(FALSE);*/
					if (trim($regno) == '')
					{
						$regno = alloc_dum_pin($rrr);
					}			

					$stmt = $mysqli->prepare("SELECT * FROM prog_choice  
					WHERE vApplicationNo = '$regno'");
					$stmt->execute();
					$stmt->store_result();
					$records = $stmt->num_rows;
					$stmt->close();

					if ($records == 0 && $regno <> '')
					{
						$stmt1 = $mysqli->prepare("SELECT resident_ctry, cEduCtgId, cProgrammeId FROM prog_choice_0 
						WHERE vLastName = '$vLastName' 
						AND vFirstName = '$vFirstName'
						AND vOtherName = '$vOtherName'
						AND vEMailId = '$payerEmail'
						AND vMobileNo = '$payerPhone'");
						$stmt1->execute();
						$stmt1->store_result();
						$stmt1->bind_result($resident_ctry, $cEduCtgId_c, $cProgrammeId_c);
						$stmt1->fetch();
						$stmt1->close();
						
						$cEduCtgId_c = $cEduCtgId_c ?? '';

                        if ($cEduCtgId_c <> '')
                        {
    						$stmt1 = $mysqli->prepare("REPLACE INTO prog_choice SET 
    						vApplicationNo = '$regno',
    						cStudyCenterId = '$cStudyCenterId',
    						cEduCtgId = '$cEduCtgId_c',
    						cAcademicDesc = '$AcademicSession',
    						vLastName = '$vLastName', 
    						vFirstName = '$vFirstName',
    						vOtherName = '$vOtherName',
    						vEMailId = '$payerEmail',
    						vMobileNo = '$payerPhone',
    						cProgrammeId = '$cProgrammeId_c',
    						resident_ctry = '$resident_ctry'");
    						$stmt1->execute();
    						$stmt1->close();
    												
    						$stmt1 = $mysqli->prepare("DELETE FROM prog_choice_0 
    						WHERE cAcademicDesc = '$AcademicSession'
    						AND vLastName = '$vLastName' 
    						AND vFirstName = '$vFirstName'
    						AND vOtherName = '$vOtherName'
    						AND vEMailId = '$payerEmail'
    						AND vMobileNo = '$payerPhone'");
    						//$stmt1->execute();
    						$stmt1->close();
                        }else
                        {
                            $subject = 'Empty programme category';
                            
                            $mail_msg = 'AFN: '.$regno.'<br>
                            Name '.$vLastName.', '.$vFirstName.', '.$vOtherName.'<br>
                            Email '.$payerEmail.'<br>
                            Phone '.$payerPhone.'<br>
                            RRR '.$rrr;
                            
                            $mail->addAddress('aadeboyejo@noun.edu.ng', '');
                            $mail->Subject = $subject;
                            $mail->Body = $mail_msg;
                            //$mail->send();
                            
                            //exit;
                        }
					}
					
					$rssql = mysqli_query(link_connect_db(), "SELECT iItemID FROM s_f_s a, fee_items b 
					WHERE a.fee_item_id = b.fee_item_id 
					AND a.cEduCtgId = '$cEduCtgId'
					AND b.fee_item_desc = 'Application Fee' 
					AND a.cdel = 'N' ORDER BY iItemID LIMIT 1") or die("error: ".mysqli_error(link_connect_db()));
					$rs_iItemID = mysqli_fetch_array($rssql);
					$iItemID_lc_c = $rs_iItemID[0];
					mysqli_close(link_connect_db());
				
					$stmt = $mysqli->prepare("DELETE FROM s_tranxion_app WHERE RetrievalReferenceNumber = '$rrr'");
					$stmt->execute();
					$stmt->close();					

					$fee_item_id = get_fee_item_id($vDesc_02);
					if ($fee_item_id == '')
					{
						echo 'Fee item not defined';exit;
					}

					if (check_rrr($rrr) == 0){
						$nxt_sn = get_nxt_sn ($regno, '', 'paid '.$vDesc_02, $cEduCtgId);

						$stmt = $mysqli->prepare("INSERT IGNORE INTO s_tranxion_app set 
						RetrievalReferenceNumber = '$rrr',
						vMatricNo = '$regno', 
						cCourseId = 'xxxxxx',
						cTrntype = 'c', 
						iItemID = $iItemID_lc_c, 
						amount = $amount,
						tSemester = 1,
						cAcademicDesc = '$session',
						siLevel = 0,
						fee_item_id = $fee_item_id,
						vremark = 'paid $vDesc_02',
						tdate = '$date2'");
						$stmt->execute();
						$stmt->close();
					}
					
					//initite_write_debit_transaction($regno, $session, '1', 'xxxxxx', $vDesc_02);

					$stmt1 = $mysqli->prepare("DELETE FROM s_tranxion_app 
					WHERE vMatricNo = ?
					AND cAcademicDesc = ?
					AND tSemester = 1
					AND cTrntype = 'd'
					AND cCourseId = 'xxxxxx'
					AND vremark = ?");
					$stmt1->bind_param("sss", $regno, $session, $vDesc_02);
					$stmt1->execute();
					$stmt1->close();

					$stmt = $mysqli->prepare("INSERT IGNORE INTO s_tranxion_app SET 
					RetrievalReferenceNumber = '$rrr',
					vMatricNo = '$regno', 
					cCourseId = 'xxxxxx',
					cTrntype = 'd', 
					iItemID = $iItemID_lc_c, 
					amount = $amount,
					tSemester = 1,
					cAcademicDesc = '$session',
					siLevel = 0,
					fee_item_id = $fee_item_id,
					vremark = '$vDesc_02',
					tdate = '$date2'");
					$stmt->execute();
					$stmt->close();		
					
					$ipee = getIPAddress();

					$stmt2 = $mysqli->prepare("insert into atv_log set 
					vApplicationNo  = '$regno',
					vDeed = 'Paid $amount for $vDesc_02',
					tDeedTime = now(),
					act_location =  ?");
					$stmt2->bind_param("s", $ipee);
					$stmt2->execute();
					$stmt2->close();

				/*	$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				}catch(Exception $e)
				{
					$mysqli->rollback(); //remove all queries from queue if error (undo)
					throw $e;
				}*/
			}
		}else if ($regno_01 <> '')
		{
			$regno = $regno_01;
		}
		
		if ($response_code_01 <> '01' && $response_code_01 <> '00')
		{
			/*$stmt = $mysqli->prepare("UPDATE remitapayments_app SET 
			Regno = ?,
			ResponseCode = ?, 
			ResponseDescription = ?,
			status = ?,
			AcademicSession = '$session' 
			WHERE RetrievalReferenceNumber = ?
			AND MerchantReference = ?");
			$stmt->bind_param("ssssss", $regno, $response_code, $response_message, $p_status, $rrr, $orderId);*/

			$stmt = $mysqli->prepare("UPDATE remitapayments_app SET 
			Regno = ?,
			ResponseCode = ?, 
			ResponseDescription = ?,
			status = ?,
			AcademicSession = '$session' 
			WHERE RetrievalReferenceNumber = ?");
			$stmt->bind_param("sssss", $regno, $response_code, $response_message, $p_status, $rrr);
			$stmt->execute();
			$stmt->close();
		}
	}
}

if ($p_status <> 'Successful' && $rrr <> '' && $rrr <> 'xxxx')
{
    $trn_date = date('d/m/Y h:i:s a', time());

	$subject = 'NOUN - Transaction Order Number';
	$mail_msg = 'Dear '.$vLastName.' '.$vFirstName.' '.$vOtherName.',<p>You initiated payment for '.$vDesc.' on '.$trn_date.'<br>Your order ID for the payment is: '.$orderId.'<p><i>You may use available support channels or visit the nearest Study centre for guidance.<p>Thank you';

	$mail_msg = wordwrap($mail_msg, 70);
	
	/*for ($incr = 1; $incr <= 5; $incr++)
	{
        try 
        {
            $mysqli->autocommit(FALSE); //turn on transactions
            */
            $mail->addAddress($payerEmail, $payerName);
            $mail->Subject = $subject;
            $mail->Body = $mail_msg;
            
			$mail->send();
            
            log_actv('Sent NOUN - payment order ID to '.$payerEmail);
            /*$mysqli->autocommit(TRUE);
			break;
        } catch (Exception $e)
        {
            $mysqli->rollback(); 
	        throw $e;
        }
	}*/
}?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/remitaconfirm.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>       
	
        <script language="JavaScript" type="text/javascript">            
            function _(el){return document.getElementById(el)}
        </script>
	</head>
	<body onload="in_progress('0');"><?php 
		if ($p_status == 'Successful')
		{?>
			<div id="inform_box" class="center top_most talk_backs talk_backs_logo" 
			style="position:fixed; border-color:#4fbf5c; background-size: 42px 45px; background-image: url('<?php echo BASE_FILE_NAME_FOR_IMG;?>success.png'); overflow:auto; max-height:450px; display:flex;">
				<div id="informa_msg_content" class="informa_msg_content_caution_cls" style="color:#4fbf5c; width:2835px;">
					Payment already successful.<br>You application form number is diaplayed above<br>Login to your application form on the home page to fill and submit it<br>If you have not set a password for access to your form, click on Reset password on the login page<br>See relevant guide under 'Help' above
				</div>
			</div>
			<!--<script language="JavaScript" type="text/javascript">
				//$msg = "Payment already successful.<br>You application form number is diaplayed above<br>Login to your application form on the home page to fill and submit it<br>If you have not set a password for access to your form, click on Reset password on the login page<br>See relevant guide under 'Help' above";
                //inform($msg);
            </script>--><?php
		}?>

        <form method="post" name="ps" enctype="multipart/form-data">
            <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
            <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
            <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else if (isset($GLOBALS['cEduCtgId'])){echo $GLOBALS['cEduCtgId'];}?>" />
            <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
        </form>
        
        <form action="student-home-page" method="post" name="myhome" enctype="multipart/form-data">
            <input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"])){echo $_REQUEST["vMatricNo"];} ?>" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
            <input name="just_paid" id="just_paid" type="hidden" />
            <input name="side_menu_no" type="hidden" />
            <input name="currency" type="hidden" value="<?php if (isset($_REQUEST['currency'])){echo $_REQUEST['currency'];} ?>" />
            
            <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php echo $passpotLoaded;?>">
            <input name="cStudyCenterId" id="cStudyCenterId" type="hidden" value="<?php echo $cStudyCenterId;?>">
            <input name="want_to_pay" id="want_to_pay" type="hidden" value="<?php if (isset($_REQUEST['want_to_pay'])){echo $_REQUEST['want_to_pay'];}?>"/>
        </form>
        
        <form action="new-application-number" method="post" name="nxt" enctype="multipart/form-data">
            <input name="vLastName" id="vLastName" type="hidden" value="<?php echo $vLastName;?>" />
            <input name="vFirstName" id="vFirstName" type="hidden" value="<?php echo $vFirstName;?>" />
            <input name="vOtherName" id="vOtherName" type="hidden" value="<?php echo $vOtherName;?>" />
            
            <input name="payerEmail" id="payerEmail" type="hidden" value="<?php echo $payerEmail;?>" />
            <input name="payerPhone" id="payerPhone" type="hidden" value="<?php echo $payerPhone;?>" />

            <input name="vApplicationNo" type="hidden" value="<?php echo $regno; ?>" />
            <input name="user_cat" type="hidden" value="1" />
            
            <input name="nap" type="hidden" value="1" />
        </form>

        <div id="smke_screen_2" class="smoke_scrn" style="display:none; z-index:5"></div>
        
        <div id="conf_box_loc" class="center top_most" 
            style="display:none;
            text-align:center; 
            padding:10px; 
            box-shadow: 2px 2px 8px 2px #726e41; 
            background:#eff5f0; 
            z-index:6">
            <div style="width:90%; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                Confirmation
            </div>
            <a href="#" style="text-decoration:none;">
                <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
            </a>
            <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:90%; float:left; text-align:center; padding:0px;">
                Have you checked your credentials against the requirements for admission into your programme of choice?
            </div>
            <div style="margin-top:10px; width:90%; float:right; text-align:right; padding:0px;">
                <a href="#" style="text-decoration:none;" 
                    onclick="_('conf_box_loc').style.display='none';
                    /*_('smke_screen_2').style.display='none';*/
                    _('smke_screen_2').style.zIndex='3';
                    _('labell_msg0').style.display = 'none';
                    _('application_steps').style.display = 'block';
                    return false">
                    <div class="login_button" style="width:60px; padding:6px; margin-left:10px; float:right">
                        Yes
                    </div>
                </a>

                <a href="#" style="text-decoration:none;" 
                    onclick="iamqual.side_menu.value='1'; iamqual.submit(); return false">
                    <div class="rec_pwd_button" style="width:60px; padding:6px; float:right">
                        No
                    </div>
                </a>
            </div>
        </div><?php
        require_once("feedback_mesages.php");
        require_once("forms.php");
        
	    $mysqli = link_connect_db();		
	
        $sidemenu = '';
        if (isset($_REQUEST["sidemenu"]) && $_REQUEST["sidemenu"] <> '')
        {
            $sidemenu = $_REQUEST["sidemenu"];
        }?>
        <div class="appl_container">			
			<script language="JavaScript" type="text/javascript">
				in_progress('1');
			</script>
			
			<?php left_conttent('Confirmation of payment detail');?>
            
            <div class="appl_right_div" style="font-size:1em;">
			
			<form action="<?php echo $url;?>" id="remita_form" name="remita_form" method="POST" onsubmit="in_progress('1');">
				<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
				<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
				
				<input name="cFacultyId" type="hidden" value="<?php if (isset($_REQUEST["cFacultyId"])){echo $_REQUEST["cFacultyId"];}; ?>" />

				<input id="merchantId" name="merchantId" value="<?php echo MERCHANTID; ?>" type="hidden"/>
				<input id="serviceTypeId" name="serviceTypeId" value="<?php echo SERVICETYPEID; ?>" type="hidden"/>
				<input id="amount" name="amount" value="<?php echo $amount; ?>" type="hidden"/>
				<input id="responseurl" name="responseurl" value="<?php echo $responseurl; ?>" type="hidden"/>
				<?php if($rrr<>"" && $rrr <> 'xxxx')
				{?>
					<input name="rrr" value="<?php echo $rrr?>" type="hidden"><?php 
				}?>
				<input id="hash" name="hash" value="<?php if (isset($hash)){echo $hash;} ?>" type="hidden"/>
				<input id="payerName" name="payerName" value="<?php echo $payerName; ?>" type="hidden"/>
				<input id="paymenttype" name="paymenttype" value="Application fee" type="hidden"/>
				<input id="payerEmail" name="payerEmail" value="<?php echo $payerEmail; ?>" type="hidden"/>
				<input id="payerPhone" name="payerPhone" value="<?php echo $payerPhone; ?>" type="hidden"/>
				<input id="orderId" name="orderId" value="<?php echo $orderId; ?>" type="hidden"/>
				<input id="vDesc" name="vDesc" value="<?php echo $vDesc;?>" type="hidden"/>
				<input id="status" name="status" value="<?php echo $p_status;?>" type="hidden"/>
				
				<input name="regno" type="hidden" value="<?php if (isset($regno) && trim($regno) <> ''){echo $regno;}else if (isset($regno_01) && trim($regno_01) <> ''){echo $regno_01;} ?>" />                
					<?php appl_top_menu_home();?>

                    <div class="appl_left_child_div" style="text-align: left; margin:auto; max-height:90%; margin-top:5px; overflow:auto; background-color: #eff5f0;"><?php
                        $in_login_table = 0;
                        
                        if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] == '5')
                        {?>
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:47px; background-color: #ffffff">
                                    1
                                </div>
                                <div style="flex:25%; padding-left:4px; height:47px; background-color: #ffffff">
                                    Matrculation number
                                </div>
                                <div style="flex:70%; padding-left:4px; height:47px; background-color: #ffffff">
                                    <?php echo $_REQUEST["vMatricNo"];?>
                                </div>
                            </div><?php
                        }else if ($p_status == 'Successful')
				        {
                            if ($vDesc == 'Application Fee')
                            {
                                $stmt = $mysqli->prepare("SELECT a.vPassword
                                FROM app_client a, remitapayments_app b
                                WHERE a.vApplicationNo = b.Regno
                                AND b.MerchantReference = ?");
                                $stmt->bind_param("s", $orderId);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($pwd);
                                $in_login_table = $stmt->num_rows;
                                $stmt->fetch();
                                $stmt->close();
                            }?>
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:47px; background-color: #ffffff">
                                    
                                </div>
                                <div style="flex:25%; padding-left:4px; height:47px; background-color: #ffffff"><?php
									if ($vDesc == 'Application Fee')
									{
                                    	echo "Application form number (AFN)";
									}else
									{
										echo "Matriculation number";
									}?>
                                </div> 
                                <div style="flex:70%; padding-left:4px; height:47px; color:#FF3300; background-color: #ffffff">
                                    <?php
                                    if ($pwd <> 'frsh' && $vDesc == 'Application Fee')
                                    {
                                            echo $regno .' This number has already been used to login';
                                    }else
                                    {
                                        echo 'Note: The application form number, '.$regno.' has been allocated to you';
                                    }?>
                                </div>
                            </div><?php
                        }?>
                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:47px; background-color: #ffffff">
                                1
                            </div>
                            <div style="flex:25%; padding-left:4px; height:47px; background-color: #ffffff">
                                Name
                            </div>
                            <div style="flex:70%; padding-left:4px; height:47px; background-color: #ffffff">
                                <?php if (isset($_REQUEST['payerName'])){echo $_REQUEST['payerName'];}?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:47px; background-color: #ffffff">
                                2
                            </div>
                            <div style="flex:25%; padding-left:4px; height:47px; background-color: #ffffff">
                                Personal eMail address
                            </div>
                            <div style="flex:70%; padding-left:4px; height:47px; background-color: #ffffff">
                                <?php if (isset($_REQUEST['payerEmail'])){echo $_REQUEST['payerEmail'];}?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:47px; background-color: #ffffff">
                                3
                            </div>
                            <div style="flex:25%; padding-left:4px; height:47px; background-color: #ffffff">
                                Personal phone number
                            </div>
                            <div style="flex:70%; padding-left:4px; height:47px; background-color: #ffffff">
                                <?php if (isset($_REQUEST['payerPhone'])){echo $_REQUEST['payerPhone'];}?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child" style="margin-bottom:10px;">
                            <div style="flex:5%; height:47px; background-color: #eff5f0"></div>
                            <div style="flex:95%; padding-left:4px; height:47px; background-color: #eff5f0">
                                Pieces of information above <b>must</b> be those of the candidate
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:47px; background-color: #ffffff">
                                4
                            </div>
                            <div style="flex:25%; padding-left:4px; height:47px; background-color: #ffffff"><?php
                                if (isset($_REQUEST['cEduCtgId_text']))
                                {
                                    if (!is_bool(strpos($_REQUEST['cEduCtgId_text'],"$")))
                                    {
                                        echo "Amount ($)";
                                    }else
                                    {
                                        echo "Amount (NGN)";
                                    }
                                }?>
                            </div>
                            <div style="flex:70%; padding-left:4px; height:47px; background-color: #ffffff">
                                <?php if (isset($_REQUEST['amount'])){echo number_format($_REQUEST['amount'], 2, '.', ',');}?>
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:47px; background-color: #ffffff">
                                5
                            </div>
                            <div style="flex:25%; padding-left:4px; height:47px; background-color: #ffffff">
                                Description
                            </div>
                            <div style="flex:70%; padding-left:4px; height:47px; background-color: #ffffff">
                                <?php if (isset($_REQUEST['cEduCtgId_text']))
								{
								    if (isset($_REQUEST['vDesc']))
    								{
    									echo $_REQUEST['vDesc'].' '.$_REQUEST['cEduCtgId_text'];
    								}
                                    
                                    $p = strpos($_REQUEST['cEduCtgId_text'], 'Master');
                                    if ($_REQUEST['amount'] == '20000' && $p !== false)
                                    {
                                        echo ' (CEMBA/CEMPA)';
                                    }
                                }?>
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:47px; background-color: #ffffff">
                                6
                            </div>
                            <div style="flex:25%; padding-left:4px; height:47px; background-color: #ffffff">
                                Order ID
                            </div>
                            <div style="flex:70%; padding-left:4px; height:47px; background-color: #ffffff">
                                <?php echo $orderId;?>
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:47px; background-color: #ffffff">
                                7
                            </div>
                            <div style="flex:25%; padding-left:4px; height:47px; background-color: #ffffff">
                                Remita retrieval reference (RRR)
                            </div>
                            <div style="flex:70%; padding-left:4px; height:47px; background-color: #ffffff; color:#FF3300">
                                <?php $rrr = $rrr ?? ''; if (trim($rrr) == '' || trim($rrr) == 'xxxx'){echo 'Unable to generate RRR now. Check your network connection or try again later.';}else{echo $rrr;}?>
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:47px; background-color: #ffffff">
                                8
                            </div>
                            <div style="flex:25%; padding-left:4px; height:47px; background-color: #ffffff">
                                Status
                            </div><?php
                                $status_color = '#000000';
                                if (!is_bool(strpos($p_status, 'Pending')))
                                {
                                    $status_color = '#FF3300';
                                }else if (!is_bool(strpos($p_status, 'Unpaid')))
                                {
                                    $status_color = '#990000';
                                }else if (!is_bool(strpos($p_status, 'Successful')))
                                {
                                    $status_color = '#009900';
                                }?>
                            <div style="flex:70%; padding-left:4px; height:47px; background-color: #ffffff; color:<?php echo $status_color;?>">
                                <?php echo $p_status;?>
                            </div>
                        </div><?php
						if ($p_status <> 'Successful')
						{?>
							<div class="appl_left_child_div_child">
								<div style="flex:5%; height:47px; background-color: #eff5f0"></div>
								<div style="flex:95%; padding-left:4px; height:47px; background-color: #eff5f0">
									If above details are correct, note the instruction below and click the Next button otherwise, click Home to start afresh
								</div>
							</div><?php
						}

                        if(($p_status == 'Pending' && $rrr <> '' && $rrr <> 'xxxx') || ($p_status == 'Successful' && $in_login_table == 0 && $vDesc == 'Application Fee') || $loop_msg <> '')
						{?>
							<div class="appl_left_child_div_child" style="margin-top:5px; color:#FF3300; background-color: #FFFFFF">
								<div style="flex:5%; height:auto;"></div>
								<div style="flex:95%; padding-left:4px; height:auto;"><?php
									if ($p_status == 'Pending' && $rrr <> '' && $rrr <> 'xxxx')
									{
										echo 'When you click the Next button below, you will be taken to remita site.<br> 
											At the appropriate time, you will receive a one-time-password (OTP) on your phone from Remita.<br> 
											After you enter the OTP and the transaction is successful, 
											<b">WAIT to be returned to your section of the NOUN portal</b> before you do anything on the screen';
									}else if ($p_status == 'Successful' && $in_login_table == 0 && $vDesc == 'Application Fee')
									{
										echo 'Remember to save and print a copy of this page before you click the continue button ';
									}else if ($loop_msg <> '')
									{
										echo $loop_msg;			
									}?>
								</div>
							</div>
							
                            <div class="appl_left_child_div_child" style="padding-top:15px; color:#FF3300; background-color: #FFFFFF">
								<div style="flex:5%; height:auto;">.</div>
								<div style="flex:95%; padding-left:4px; height:auto;">
								    <input name="conf_prog" id="conf_prog" 
                                    type="checkbox" required />
                                    <label for="conf_prog" style="color: #FF3300">I have read the instructions above</label>
								</div>
							</div><?php
						}?>
                    </div><?php
					if ($p_status <> 'Successful')
					{?>
						<div class="appl_left_child_div" style="text-align: left; margin:auto; margin-top:5px;">
							<div style="display:flex; 
								flex-flow: row;
								justify-content:flex-end;
								flex:100%;
								height:auto; 
								margin-top:10px;">
									<button type="submit" class="login_button">Next</button>  
							</div>
						</div><?php
					}else if ($in_login_table == 0)
					{?>
						<div class="appl_left_child_div" style="text-align: right; margin:auto; margin-top:15px;">
							<a href="#" target="_self" style="text-decoration:none;"
								onclick="if (_('conf_prog').checked)
								{
								    nxt.submit(); 
								    return false;
								}else
								{
								    caution_inform('Please confirm that you have read the instructions');
								}"> 
								<div class="login_button" title="Continue">Cotinue</div>
							</a>
                        </div><?php
					}?>
                </form>
            </div>
        </div>
	</body>
</html>