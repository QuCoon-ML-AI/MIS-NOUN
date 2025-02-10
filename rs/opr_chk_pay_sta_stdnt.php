<?php

require_once('../../fsher/fisher.php');
include('const_def.php');
include(BASE_FILE_NAME.'lib_fn.php');
include(BASE_FILE_NAME.'lib_fn_2.php');
include (BASE_FILE_NAME.'remita_constants.php');

$orgsetins = settns();

$mysqli = link_connect_db();


function select_fee_srtucture($vMatricNo, $res_ctry, $cEduCtgId_loc)
{
	if ($res_ctry == 'NG')
	{		
		if ($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY' || $cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX' || $cEduCtgId_loc == 'ELX')
		{
		    return " AND new_old_structure = 'o'";
		}
		
		$mysqli = link_connect_db();
		
		$stmt = $mysqli->prepare("SELECT tdate FROM s_tranxion_cr WHERE cTrntype = 'c' AND tdate < '2023-01-01' AND vMatricNo = ?");
        $stmt->bind_param("s", $vMatricNo);
        $stmt->execute();
        $stmt->store_result();
        $recods_found = $stmt->num_rows;
        $stmt->close();
		
		if ($recods_found > 0)
		{
			return " AND new_old_structure = 'o'";
		}else
		{
			return " AND new_old_structure = 'n'";
		}
	}else
	{
		return " AND new_old_structure = 'f'";
	}
}

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

$on_local_db = 0;

if (isset($_REQUEST['student_enq']) && $_REQUEST['student_enq'] == '1')
{
    $pay_id = '';
    $search_field = '';
    if (isset($_REQUEST['rrr']) && $_REQUEST['rrr'] <> '')
    {
        $pay_id = $_REQUEST['rrr'];
        $search_field = 'RetrievalReferenceNumber';
    }else if (isset($_REQUEST['orderId']) && $_REQUEST['orderId'] <> '')
    {
        $pay_id = $_REQUEST['orderId'];
        $search_field = 'MerchantReference';
    }

    $stmt = $mysqli->prepare("SELECT Regno, vDesc, ResponseCode, Amount, RetrievalReferenceNumber, MerchantReference, cEduCtgId 
    FROM remitapayments WHERE $search_field = ?");
    $stmt->bind_param("s", $pay_id);    
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($vMatricNo, $vDesc_01, $ResponseCode, $amount, $rrr, $orderId, $cEduCtgId);
    
    $on_local_db = $stmt->num_rows;
    $stmt->fetch();
    $stmt->close();

    if ($vMatricNo <> '' && strtolower($vMatricNo) <> strtolower($_REQUEST["vMatricNo"]))
    {
        echo 'RRR and matriculation number do not match';
        exit;
    }

    $response_str = '';
    if ($ResponseCode == '00' || $ResponseCode == '01')
    {
        $response_str = 'Payment already confirmed successful';
    }
    
    $response_code = '';

    if ($ResponseCode <> '01' && $ResponseCode <> '00')
    {
        $response = remita_transaction_details($_REQUEST['orderId'], $_REQUEST["rrr"]);
        //print_r($response);
        
        if (isset($response['status']))
        {
            $response_code = trim($response['status']);
        }
        
        $response_message = '';
        if (isset($response['message']))
        {
            $response_message = trim($response['message']);
        }
        
        $transactionDate = '';
        if (isset($response['transactiontime']))
        {
            $transactionDate = trim($response['transactiontime']);
        }
        
        if (isset($response['RRR']) && strlen(trim($response['RRR'])) > 4)
        {
            $rrr = trim($response['RRR']);
        }

        $orderId = '';
        if (isset($response['orderId']))
        {
            $orderId = $response['orderId'];
        }
        
        $amount = 0;
        if (isset($response['amount']) && $response['amount'] > 0)
        {
            $amount = trim($response['amount']);
        }

        $statuss = 'Pending';
        if ($response_code == '01')
        {
            $response_str = 'Payment successful';
            $statuss = 'Successful';
        }else
        {
            //$response_str = 'Transaction pending<br>Contact Bursary with your RRR at your Study Centre for resolution';
            $response_str = 'Transaction pending';
        }

        $payermail = strtolower($_REQUEST["vMatricNo"])."@noun.edu.ng";

        $sstatus = 'Pending';
        if ($response_message == 'Approved')
        {
            $sstatus = 'Successful';
        }

        
        $payermail = strtolower($_REQUEST["vMatricNo"])."@noun.edu.ng";
        
        /*$stmt1 = $mysqli->prepare("INSERT IGNORE INTO remitapayments 
        SET Regno = ?,
        payerName = ?,
        vLastName = ?,
        vFirstName = ?,
        vOtherName = ?,
        payerEmail = ?,
        cEduCtgId = ?,
        Amount = $amount, 
        payerPhone = ?,
        MerchantReference = ?,
        RetrievalReferenceNumber = ?,
        AcademicSession = '".$orgsetins["cAcademicDesc"]."',
        tSemester = ?, 
        vDesc = 'Wallet Funding',
        TransactionDate = ?,
        Status = ?");
        $stmt1->bind_param("ssssssssssiss", $_REQUEST["vMatricNo"], $_REQUEST['payerName'], $_REQUEST['s_name'], $_REQUEST['f_name'], $_REQUEST['o_name'], $payermail, $_REQUEST['educationcat'], $_REQUEST['payerPhone'], $orderId, $_REQUEST["rrr"], $_REQUEST['tSemester'], $transactionDate, $sstatus);
        $stmt1->execute();

        if ($stmt1->affected_rows == 0)
        {*/

        if ($orderId <> '')
        {
            $stmt1 = $mysqli->prepare("UPDATE IGNORE remitapayments 
            SET ResponseCode = ?,
            MerchantReference = ?,
            AcademicSession = '".$orgsetins["cAcademicDesc"]."',
            ResponseDescription = ?,
            TransactionDate = ?,
            Status = '$statuss'
            WHERE Regno = ?
            AND RetrievalReferenceNumber = ?");
            $stmt1->bind_param("ssssss", $response_code, $orderId, $response_message, $transactionDate, $_REQUEST["vMatricNo"], $_REQUEST['rrr']);
            $stmt1->execute();
        }
        
        //}

        //echo $_REQUEST["vMatricNo"].', '.$_REQUEST['payerName'].', '.$_REQUEST['s_name'].', '.$_REQUEST['f_name'].', '.$_REQUEST['o_name'].', '.$payermail.', '.$_REQUEST['educationcat'].', '.$_REQUEST['payerPhone'].', '.$orderId.', '.$_REQUEST['tSemester'].', '.$transactionDate.', '.$sstatus;exit;
    }else if ($ResponseCode == '01' || $ResponseCode == '00')
    {
        $response_code = $ResponseCode;
    }

    $stmt = $mysqli->prepare("SELECT * FROM s_tranxion_cr WHERE RetrievalReferenceNumber = '$rrr'");
    $stmt->execute();
    $stmt->store_result();
    $cr_transaction_written = $stmt->num_rows;
    $stmt->close();
    //echo $response_code;
    //$sql_feet_type = select_fee_srtucture($_REQUEST["vMatricNo"], $_REQUEST["locality"], $_REQUEST["educationcat"]);
    
    if (($response_code == '00' || $response_code == '01') && $cr_transaction_written == 0)
    {
        $semeter = 1;
        $sql_subqry = " AND citem_cat LIKE '%4'";
        if ($_REQUEST["tSemester"]%2 == 0)
        {
            $semeter = 2;
            $sql_subqry = " AND citem_cat LIKE '%5'";
        }
        
        // $stmt = $mysqli->prepare("SELECT iItemID FROM s_f_s a, fee_items b 
        // WHERE a.fee_item_id = b.fee_item_id 
        // AND cFacultyId = '".$_REQUEST["faculty"]."' 
        // AND cEduCtgId = '".$_REQUEST["educationcat"]."'
        // AND iSemester = $semeter
        // AND b.fee_item_desc = ?");
        
        $stmt = $mysqli->prepare("SELECT iItemID FROM s_f_s
        WHERE cFacultyId = '".$_REQUEST["faculty"]."' 
        AND cEduCtgId = '".$_REQUEST["educationcat"]."'
        $sql_subqry
        AND fee_item_id = 71");
        //$stmt->bind_param("s", $_REQUEST["vDesc_loc"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($iItemID_lc_c);
        $stmt->fetch();
        $stmt->close();
        
        $iItemID_lc_c = $iItemID_lc_c ?? '';
        
        if (check_rrr($rrr) == 0 /*&& ($vDesc_01 == 'Wallet Funding' || $vDesc_01 == 'Late Fee')*/)
        {
            $nxt_sn = get_nxt_sn ($_REQUEST["vMatricNo"], '','Wallet Funding', $_REQUEST["educationcat"]);
        	
            $fee_item_id = get_fee_item_id($_REQUEST["vDesc_loc"]);
            if ($fee_item_id == '')
            {
                echo 'Fee item not defined';exit;
            }

            if ($iItemID_lc_c == '')
            {
                echo 'Unknown item.';exit;
            }
							
            date_default_timezone_set('Africa/Lagos');
            $date2 = date("Y-m-d h:i:s");

            $stmt = $mysqli->prepare("INSERT IGNORE INTO s_tranxion_cr SET 
            RetrievalReferenceNumber = '$rrr',
            vMatricNo = ?, 
            cCourseId = 'xxxxxx', 
            cTrntype = 'c', 
            iItemID = $iItemID_lc_c, 
            amount = $amount,
            tSemester = ?,
            cAcademicDesc = ?,
            siLevel = ?,
            trans_count = $nxt_sn,
			fee_item_id = $fee_item_id,
            vremark = '$vDesc_01',
            tdate = '$date2'");
            $stmt->bind_param("sisi", $_REQUEST["vMatricNo"], $_REQUEST["tSemester"], $orgsetins["cAcademicDesc"], $_REQUEST["iStudy_level"]);
            $stmt->execute();
            $stmt->close();
        }
    }

    /*if (($response_code == '00' || $response_code == '01') && $response_code <> $ResponseCode)
    {
        if ($on_local_db > 0)
        {
            if (isset($_REQUEST['rrr']) && $_REQUEST['rrr'] <> '')
            {
                $stmt_transaction_status = $mysqli->prepare("UPDATE remitapayments SET 
                ResponseCode = '$response_code', 
                ResponseDescription = '$response_message',
                TransactionDate = '$transactionDate',
                RetrievalReferenceNumber = '$rrr',
                status = 'Successful'
                WHERE $search_field = ?");
                $stmt_transaction_status->bind_param("s",$pay_id);            
            
                //$stmt_transaction_status->execute();
                $stmt_transaction_status->close();
            }
        }else
        {
            $stmt_transaction_status = $mysqli->prepare("UPDATE remitapayments SET 
            ResponseCode = '$response_code', 
            ResponseDescription = '$response_message',
            RetrievalReferenceNumber = '$rrr',
            TransactionDate = '$transactionDate',
            status = 'Successful'
            WHERE MerchantReference = '$orderId'");
            //$stmt_transaction_status->execute();

            if ($stmt_transaction_status->affected_rows == 0)
            {
                // $stmt1 = $mysqli->prepare("INSERT INTO remitapayments SELECT 
                // '',vMatricNo, CONCAT(vLastName,' ',vFirstName,' ',vOtherName), 
                // vLastName, vFirstName, vOtherName, vEMailId, 
                // vMobileNo, 'odl', cEduCtgId,
                // '$amount', ?, '$orderId', cAcademicDesc, '1', '$rrr', 
                // '$response_code', '$response_message', NOW(), 'Successful'
                // FROM s_t_m");
                // $stmt1->bind_param("s",$_REQUEST['vDesc_loc']);
                // $stmt1->execute();

                // $stmt1->close();
            }
            $stmt_transaction_status->close();
        }
    }*/

    echo $response_str;
    exit;
}?>