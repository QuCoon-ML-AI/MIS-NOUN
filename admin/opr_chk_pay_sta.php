<?php
require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

include ('../appl/remita_constants.php');


$orgsetins = settns();
$session = $orgsetins['cAcademicDesc'];

date_default_timezone_set('Africa/Lagos');
$date2 = date("Y-m-d h:i:s");

require_once('var_colls.php');

function remita_transaction_details($orderId, $rrr)
{
	$mert =  MERCHANTID;
	$api_key =  APIKEY;

	if($rrr <> '')
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

if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> '')
{
    if (isset($_REQUEST['arch_mode_hd']) && $_REQUEST['arch_mode_hd'] == '1')
    {
        $remitapayments = "arch_remitapayments";
        if ($_REQUEST['vDesc_loc'] == 'Application Fee')
        {
            $remitapayments = "arch_remitapayments_app";
        }
    }else
    {
        $remitapayments = "remitapayments";
        
        if ($_REQUEST['vDesc_loc'] == 'Application Fee')
        {
            $remitapayments = "remitapayments_app";
        }
    }

    if (isset($_REQUEST['rrr']) && $_REQUEST['rrr'] <> '' || isset($_REQUEST['orderId']) && $_REQUEST['orderId'] <> '')
    {
		if (isset($_REQUEST['rrr']) && $_REQUEST['rrr'] <> '')
        {
            if ($_REQUEST['user_cat'] == 7)
            {
                $stmt = $mysqli->prepare("SELECT 
                Regno,
                vLastName,
                vFirstName,
                vOtherName,
                payerName,
                payerEmail, 
                payerPhone, 
                Amount, 
                vDesc,
                Status, 
                TransactionDate,
                ResponseCode,
                Status,
                AcademicSession,  
                cEduCtgId,
                tSemester 
                FROM $remitapayments WHERE RetrievalReferenceNumber = ? AND (Regno = ? OR Regno = ?)");
                $stmt->bind_param("sss", $_REQUEST["rrr"], $_REQUEST["vApplicationNo"], $_REQUEST["vMatricNo"]);
            }else
            {
                $stmt = $mysqli->prepare("SELECT 
                Regno,
                vLastName,
                vFirstName,
                vOtherName, 
                payerName,
                TRIM(payerEmail), 
                payerPhone, 
                Amount, 
                vDesc,
                Status, 
                TransactionDate,
                ResponseCode,
                Status,
                AcademicSession,  
                cEduCtgId,
                tSemester,
                RetrievalReferenceNumber  
                FROM $remitapayments WHERE RetrievalReferenceNumber = ?");
                $stmt->bind_param("s", $_REQUEST["rrr"]);
            }
        }else  if (isset($_REQUEST['orderId']) && $_REQUEST['orderId'] <> '')
        {
            if ($_REQUEST['user_cat'] == 7)
            {
                $stmt = $mysqli->prepare("SELECT 
                Regno,
                vLastName,
                vFirstName,
                vOtherName, 
                payerName,
                payerEmail, 
                payerPhone, 
                Amount, 
                vDesc,
                Status, 
                TransactionDate,
                ResponseCode,
                Status,
                AcademicSession, 
                cEduCtgId,
                tSemester,
                RetrievalReferenceNumber  
                FROM $remitapayments WHERE MerchantReference = ? AND (Regno = ? OR Regno = ?)");
                $stmt->bind_param("sss", $_REQUEST["orderId"], $_REQUEST["vApplicationNo"], $_REQUEST["vMatricNo"]);
            }else
            {
                $stmt = $mysqli->prepare("SELECT 
                Regno,
                vLastName,
                vFirstName,
                vOtherName, 
                payerName,
                payerEmail, 
                payerPhone, 
                Amount, 
                vDesc,
                Status, 
                TransactionDate,
                ResponseCode,
                Status,
                AcademicSession, 
                cEduCtgId,
                tSemester,
                RetrievalReferenceNumber  
                FROM $remitapayments WHERE MerchantReference = ?");
                $stmt->bind_param("s", $_REQUEST["orderId"]);
            }
        }
        
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($vApplicationNo_01,
        $vLastName,
        $vFirstName,
        $vOtherName,
        $payerName,
        $payerEmail, 
        $payerPhone, 
        $amount, 
        $vDesc,
        $Status, 
        $TransactionDate,
        $ResponseCode,
        $Status,
        $AcademicSession_01, 
        $cEduCtgId_01,
        $tSemester,
        $rrr);
        $on_local_db = $stmt->num_rows;
        
        $stmt->fetch();
        $stmt->close();
        
        $response_code = '';
        $response_message = '';
        $transactionDate = '';
        
        if ($ResponseCode <> '00' && $ResponseCode <> '01')
        {
            $response = remita_transaction_details($_REQUEST['orderId'], $_REQUEST["rrr"]);
            //print_r($response);exit;
            $response_code = '';
            if (isset($response['status']))
            {
                $response_code = trim($response['status']);
            }
            
            $response_message = '';
            if (isset($response['message']))
            {
                $response_message = trim($response['message']);
            }
            
            //$transactionDate = '';
            if (isset($response['transactiontime']))
            {
                $transactionDate = trim($response['transactiontime']);
            }
            
            $rrr = '';
            if (isset($response['RRR']) && strlen(trim($response['RRR'])) > 4)
            {
                $rrr = trim($response['RRR']);
            }

            $orderId = '';
            if (isset($response['transactiontime']))
            {
                $orderId = $response['orderId'];
            }
            
            if (isset($response['amount']) && $response['amount'] > 0)
            {
                $amount = trim($response['amount']);
            }
        }
        
		if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
		{
            $response_code = '01';
            $response_message = 'Approved';
            
            if ($transactionDate == '' || $AcademicSession_01 == '')
            {
                date_default_timezone_set('Africa/Lagos');
                $transactionDate = date("Y-m-d h:i:s");
            }
		}

        if ($response_code == '00' || $response_code == '01')
        {
            if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
            {
                $token_status = validate_token($_REQUEST["vApplicationNo"],'confirmation of payment');
        
                if ($token_status <> 'Token valid')
                {
                    echo $token_status;
                    exit;
                }
            }
            
            if ($_REQUEST["vDesc_loc"] == 'Application Fee' || $_REQUEST["vDesc_loc"] == 'Convocation Gown')
            {
                $stmt = $mysqli->prepare("SELECT iItemID FROM s_f_s a, fee_items b 
                WHERE a.fee_item_id = b.fee_item_id
                AND cEduCtgId = '$cEduCtgId_01'
                AND b.fee_item_desc = ? 
				AND a.cdel = 'N' ORDER BY iItemID LIMIT 1");
                $stmt->bind_param("s", $_REQUEST["vDesc_loc"]);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($iItemID_lc_c);
                $stmt->fetch();
                $stmt->close();
                $iItemID_lc_d = $iItemID_lc_c;

                $iItemID_lc_d = $iItemID_lc_d ?? '';
                
                if ($iItemID_lc_d == '')
                {
                    echo "Invalid ID";exit;
                }                
                                
                if ($vDesc == 'Application Fee')
                {
                    if ($cEduCtgId_01 == 'ELX')
                    {
                        $iStudy_level = 10;
                    }else if ($cEduCtgId_01 == 'PRX')
                    {
                        $iStudy_level = 1000;
                    }else if ($cEduCtgId_01 == 'PGZ')
                    {
                        $iStudy_level = 900;
                    }else if ($cEduCtgId_01 == 'PGY')
                    {
                        $iStudy_level = 800;
                    }else if ($cEduCtgId_01 == 'PGX')
                    {
                        $iStudy_level = 700;
                    }else if ($cEduCtgId_01 == 'PSZ')
                    {
                        $iStudy_level = 100;
                    }
                }else
                {
                    // if ($vDesc == 'Convocation gown')
                    // {
                    //     $amount = $amount - 25000;
                    // }
                    
                    $stmt = $mysqli->prepare("SELECT iStudy_level FROM s_m_t WHERE vMatricNo = '$vApplicationNo_01'");
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($iStudy_level);
                    $stmt->fetch();
                    $stmt->close();
                }
                
                if ($vDesc == 'Application Fee' || $vDesc == 'Convocation Gown')
                {
                    try 
                    {
                        $mysqli->autocommit(FALSE); //turn on transactions
                        initite_write_debit_transaction($vApplicationNo_01, $orgsetins['cAcademicDesc'], $tSemester, 'xxxxxx', $vDesc);

                        if ($vDesc == 'Application Fee')
                        {
                            $s_tranxion = "s_tranxion_app";
                            $s_tranxion_d = "s_tranxion_app";
                        }else
                        {
                            $s_tranxion = "s_tranxion_cr";
                            $s_tranxion_d = "s_tranxion_20242025";
                        }
                        
                        $stmt = $mysqli->prepare("INSERT IGNORE INTO $s_tranxion SET 
                        RetrievalReferenceNumber = '$rrr',
                        vMatricNo = '$vApplicationNo_01', 
                        cCourseId = 'xxxxxx', 
                        cTrntype = 'c', 
                        iItemID = $iItemID_lc_c, 
                        amount = $amount,
                        tSemester = $tSemester,
                        cAcademicDesc = '".$orgsetins['cAcademicDesc']."',
                        siLevel = $iStudy_level,
                        fee_item_id = ?,
                        vremark = 'Paid $vDesc',
                        tdate = '$date2'");
                        $stmt->bind_param("i", $_REQUEST['f_item_id']);
                        $stmt->execute();
                        $stmt->close();
                        
                        $stmt = $mysqli->prepare("INSERT IGNORE INTO $s_tranxion_d SET 
                        RetrievalReferenceNumber = '$rrr',
                        vMatricNo = '$vApplicationNo_01', 
                        cCourseId = 'xxxxxx', 
                        cTrntype = 'd', 
                        iItemID = $iItemID_lc_d, 
                        amount = $amount,
                        tSemester = $tSemester,
                        cAcademicDesc = '".$orgsetins['cAcademicDesc']."',
                        siLevel = $iStudy_level,
                        fee_item_id = ?,
                        vremark = 'Paid $vDesc',
                        tdate = '$date2'");
                        $stmt->bind_param("i", $_REQUEST['f_item_id']);
                        $stmt->execute();
                        $stmt->close();

                        $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
                    } catch (Exception $e)
                    {
                        $mysqli->rollback(); //remove all queries from queue if error (undo)
                        throw $e;
                    }
                }
            }else
            {
                $stmt = $mysqli->prepare("SELECT a.vMatricNo, a.iStudy_level, a.tSemester, c.cEduCtgId, a.cFacultyId, a.cdeptId, a.cAcademicDesc_1, a.cStudyCenterId, a.cProgrammeId 
				FROM s_m_t a, remitapayments b, programme c 
				WHERE b.RetrievalReferenceNumber = ? 
				AND a.vMatricNo = b.Regno
				AND a.cProgrammeId = c.cProgrammeId");
                $stmt->bind_param("s", $_REQUEST["rrr"]);				
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($vMatricNo, $iStudy_level, $tSemester, $cEduCtgId, $cFacultyId, $cdeptId, $cAcademicDesc_1, $cStudyCenterId, $cProgrammeId);
				$stmt->fetch();
                
                $vApplicationNo_01 = $_REQUEST["uvApplicationNo"];

                $stmt = $mysqli->prepare("SELECT iItemID FROM s_f_s 
                WHERE  cFacultyId = '$cFacultyId' 
                AND cEduCtgId = '$cEduCtgId'
                AND fee_item_id = 71");
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($iItemID_lc_c);
                $stmt->fetch();
                $stmt->close();

                
                if ($iItemID_lc_c == '')
                {
                    echo "Invalid ID";exit;
                }

                if (check_rrr($rrr) == 0)
                {
                    $nxt_sn = get_nxt_sn ($vMatricNo, '',$vDesc);

                    $stmt = $mysqli->prepare("INSERT IGNORE INTO s_tranxion_cr SET 
                    RetrievalReferenceNumber = '$rrr',
                    vMatricNo = '$vMatricNo', 
                    cCourseId = 'xxxxxx', 
                    cTrntype = 'c', 
                    iItemID = $iItemID_lc_c, 
                    amount = $amount,
                    tSemester = $tSemester,
                    cAcademicDesc = '$AcademicSession_01',
                    siLevel = ?,
                    trans_count = $nxt_sn,
                    fee_item_id = ?,
                    vremark = '$vDesc',
                    tdate = '$date2'");
                    $stmt->bind_param("ii", $_REQUEST['iStudy_level'], $_REQUEST['f_item_id']);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }

        if (($response_code == '00' || $response_code == '01') && ((isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1') || ($response_code <> $ResponseCode)))
        {
            if ($on_local_db > 0)
            {
                if ($transactionDate == '')
                {
                    $transactionDate = date("Y-m-d");
                }

                if (isset($_REQUEST['rrr']) && $_REQUEST['rrr'] <> '')
                {
                    $stmt_transaction_status = $mysqli->prepare("UPDATE $remitapayments SET 
                    ResponseCode = '$response_code', 
                    ResponseDescription = '$response_message',
                    TransactionDate = '$transactionDate',
                    status = 'Successful'
                    WHERE RetrievalReferenceNumber = ?");
                    $stmt_transaction_status->bind_param("s", $_REQUEST["rrr"]);
                }else if (isset($_REQUEST['orderId']) && $_REQUEST['orderId'] <> '')
                {
                    $stmt_transaction_status = $mysqli->prepare("UPDATE $remitapayments SET 
                    ResponseCode = '$response_code', 
                    ResponseDescription = '$response_message',
                    TransactionDate = '$transactionDate',
                    status = 'Successful'
                    WHERE MerchantReference = ?");
                    $stmt_transaction_status->bind_param("s", $_REQUEST['orderId']);
                }
                
                $stmt_transaction_status->execute();
                $stmt_transaction_status->close();
            }else
            {
                $stmt_transaction_status = $mysqli->prepare("UPDATE $remitapayments SET 
                ResponseCode = '$response_code', 
                ResponseDescription = '$response_message',
                RetrievalReferenceNumber = '$rrr',
                TransactionDate = $transactionDate,
                status = 'Successful'
                WHERE MerchantReference = '$orderId'");
                $stmt_transaction_status->execute();

                if ($stmt_transaction_status->affected_rows == 0)
                {
                    date_default_timezone_set('Africa/Lagos');
                    $date2 = date("Y-m-d h:i:s");
                    
                    $stmt1 = $mysqli->prepare("INSERT INTO $remitapayments SELECT 
                    '',vApplicationNo, CONCAT(vLastName,' ',vFirstName,' ',vOtherName), 
                    vLastName, vFirstName, vOtherName, vEMailId, 
                    vMobileNo, 'odl', cEduCtgId,
                    '$amount', ?, '$orderId', cAcademicDesc, '1', '$rrr', 
                    '$response_code', '$response_message', '$date2', 'Successful'
                    FROM prog_choice");
                    $stmt1->bind_param("s",$_REQUEST['vDesc_loc']);
                    $stmt1->execute();

                    $stmt1->close();
                }
                $stmt_transaction_status->close();
            }

            if (isset($_REQUEST['rrr']) && $_REQUEST['rrr'] <> '')
            {
                if ($_REQUEST['user_cat'] == 7)
                {
                    $stmt = $mysqli->prepare("SELECT Regno, 
                    payerName,
                    payerEmail, 
                    payerPhone, 
                    Amount, 
                    vDesc,
                    Status, 
                    TransactionDate,
                    ResponseCode,
                    Status 
                    FROM $remitapayments WHERE (RetrievalReferenceNumber = ?) AND (Regno = ? OR Regno = ?)");
                    $stmt->bind_param("sss", $_REQUEST["rrr"], $_REQUEST["vApplicationNo"], $_REQUEST["vMatricNo"]);
                }else
                {
                    $stmt = $mysqli->prepare("SELECT Regno, 
                    payerName,
                    payerEmail, 
                    payerPhone, 
                    Amount, 
                    vDesc,
                    Status, 
                    TransactionDate,
                    ResponseCode,
                    Status 
                    FROM $remitapayments WHERE (RetrievalReferenceNumber = ?)");
                    $stmt->bind_param("s", $_REQUEST["rrr"]);
                }
            }else if (isset($_REQUEST['orderId']) && $_REQUEST['orderId'] <> '')
            {
                if ($_REQUEST['user_cat'] == 7)
                {
                    $stmt = $mysqli->prepare("SELECT Regno, 
                    payerName,
                    payerEmail, 
                    payerPhone, 
                    Amount, 
                    vDesc,
                    Status, 
                    TransactionDate,
                    ResponseCode,
                    Status 
                    FROM $remitapayments WHERE (MerchantReference = ?) AND (Regno = ? OR Regno = ?)");
                    $stmt->bind_param("sss", $_REQUEST['orderId'], $_REQUEST["vApplicationNo"], $_REQUEST["vMatricNo"]);
                }else
                {
                    $stmt = $mysqli->prepare("SELECT Regno, 
                    payerName,
                    payerEmail, 
                    payerPhone, 
                    Amount, 
                    vDesc,
                    Status, 
                    TransactionDate,
                    ResponseCode,
                    Status 
                    FROM $remitapayments WHERE (MerchantReference = ?)");
                    $stmt->bind_param("s", $_REQUEST['orderId']);
                }
            }
    
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($Regno, 
            $payerName,
            $payerEmail, 
            $payerPhone, 
            $amount, 
            $vDesc,
            $Status, 
            $TransactionDate,
            $ResponseCode,
            $Status);
            $stmt->fetch();
            
            if (is_null($payerName))
            {
                $payerName = '';
            }
            
            if ($transactionDate <> $TransactionDate)
            {
                $TransactionDate = $transactionDate;
            }

            if ($response_message == 'Approved')
            {
                $Status = 'Successful';
            }

			if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
			{
				log_actv('Confirmed payment successful on RRR, '.$_REQUEST["rrr"]);
			}
        }

        if ($vDesc <> 'Application Fee')
        {
            $stmt_level = $mysqli->prepare("SELECT vApplicationNo, cFacultyId, iStudy_level, tSemester FROM s_m_t WHERE vMatricNo = ?");
            $stmt_level->bind_param("s", $vApplicationNo_01);
            $stmt_level->execute();
            $stmt_level->store_result();
            
            $stmt_level->bind_result($vApplicationNo, $cFacultyId, $iStudy_level, $tSemester);
            $stmt_level->fetch();
            $stmt_level->close();
        }else
        {            
            $stmt_level = $mysqli->prepare("SELECT vApplicationNo, cFacultyId, iBeginLevel FROM prog_choice WHERE vApplicationNo = ?");
            $stmt_level->bind_param("s", $vApplicationNo_01);
            $stmt_level->execute();
            $stmt_level->store_result();
            $stmt_level->bind_result($vApplicationNo, $cFacultyId, $iStudy_level);
            $stmt_level->fetch();
            $stmt_level->close();
        }

        /*if (($response_code == '00' || $response_code == '01') && $_REQUEST["vDesc_loc"] == 'Application Fee')
        {
            if ($vApplicationNo_01 == '')
            {
                //$vApplicationNo_01 = alloc_dum_pin($rrr);
            }
            
            // $stmt = $mysqli->prepare("INSERT IGNORE INTO app_client SET
            // vPassword = 'frsh', 
            // cpwd = '0',
            // vApplicationNo = '$vApplicationNo_01'");
            // $stmt->execute();
            
            $stmt = $mysqli->prepare("UPDATE prog_choice_0 SET 
            vApplicationNo = '$vApplicationNo_01'
            WHERE vLastName = '$vLastName' 
            and vFirstName = '$vFirstName' 
            and vOtherName = '$vOtherName' 
            and vEMailId = '$payerEmail'
            and vMobileNo = '$payerPhone'
            and dAmnt = $amount");
            //$stmt->execute();
            
            $stmt = $mysqli->prepare("INSERT IGNORE INTO prog_choice SELECT * FROM prog_choice_0 WHERE vApplicationNo = '$vApplicationNo_01';");
            //$stmt->execute();
            $stmt->close();
            
            $stmt = $mysqli->prepare("DELETE FROM prog_choice_0 WHERE vApplicationNo = '$vApplicationNo_01';");
            //$stmt->execute();
            $stmt->close();
        }*/

        $cFacultyId = $cFacultyId ?? '';
        $iStudy_level = $iStudy_level ?? '';
        
        if ($payerName <> '' && !is_null($vApplicationNo_01))
        {
            $vmask = get_pp_pix($vApplicationNo_01);

            echo str_pad($vApplicationNo_01, 50).
            str_pad($payerName, 100).
            str_pad(trim($payerEmail), 50).
            str_pad($payerPhone, 50).
            str_pad(number_format($amount, 2, '.', ','), 50).
            str_pad($vDesc, 50).
            str_pad($Status, 50).
            str_pad($TransactionDate, 50).
            str_pad($ResponseCode, 50).
            str_pad($vApplicationNo_01, 50).
            str_pad($iStudy_level, 50).
            str_pad($cFacultyId, 50).
            str_pad($cEduCtgId_01, 50).
            str_pad($vmask, 50);
        }else
        {
            echo '';
        }
        
        exit;
    }
}



/*function alloc_dum_pin($rrr)
{
	$mysqli = link_connect_db();
	
	$c = 0;
	while (1 == 1)
	{
    	$randomid = mt_rand(100000,999999);
    	
    	$stmt_g = $mysqli->prepare("SELECT * FROM remitapayments_app WHERE Regno LIKE '%$randomid';");
    	$stmt_g->execute();
    	$stmt_g->store_result();
    	if ($stmt_g->num_rows == 0)
    	{
        	$randomid = date("y").$randomid;
        	
            try
        	{
        		$mysqli->autocommit(FALSE); //turn on transactions
        		
        		$stmt = $mysqli->prepare("UPDATE remitapayments_app SET Regno = '$randomid' WHERE RetrievalReferenceNumber = ? AND Regno = ''");	
        		$stmt->bind_param("s", $rrr);
        		$stmt->execute();
        
        		$stmt = $mysqli->prepare("INSERT IGNORE INTO app_client SET
        		vPassword = 'frsh', 
        		cpwd = '0',
        		vApplicationNo = '$randomid'");
        		$stmt->execute();
        
        		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
        		
        		$stmt->close();
        	    $stmt_g->close();
        	    
        	    return $randomid;
        	}catch(Exception $e) 
        	{
        		$mysqli->rollback(); //remove all queries from queue if error (undo)
        		throw $e;
        	}
    	}
    	
    	$c++;
    }
    $stmt_g->close();
}*/?>