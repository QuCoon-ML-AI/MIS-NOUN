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
    if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
    {
        $names = explode(" ", $_REQUEST["payername"]);
        $lname = $names[0];
        $fname = $names[1];
        $mname = '';
        if (isset($names[2]))
        {
            $mname = $names[2];
        }

        $email = $_REQUEST["vMatricNo"].'@NOUN.EDU.NG';

        if ($_REQUEST["payername"] <> '' && $_REQUEST["payerphone"] <> '' && $_REQUEST["cEduCtgId"] <> '' && is_numeric($_REQUEST["amount"]) && $_REQUEST["amount"] > 0 && $_REQUEST["rrr"] <> '' && is_numeric($_REQUEST["rrr"]))
        {
            $stmt = $mysqli->prepare("INSERT IGNORE INTO s_tranxion_cr_arch SELECT *  FROM s_tranxion_cr WHERE RetrievalReferenceNumber = ?");
            $stmt->bind_param("s", $_REQUEST["rrr"]);
            $stmt->execute();
            $record1 = $stmt->affected_rows;
            
            $stmt = $mysqli->prepare("UPDATE s_tranxion_cr SET vMatricNo = ?, amount = ? WHERE RetrievalReferenceNumber = ?");
            $stmt->bind_param("sds", $_REQUEST["vMatricNo"],$_REQUEST["amount"],$_REQUEST["rrr"]);
            $stmt->execute();
            $record2 = $stmt->affected_rows;

            $stmt = $mysqli->prepare("INSERT IGNORE INTO remitapayments_arch SELECT * FROM remitapayments WHERE RetrievalReferenceNumber = ?");
            $stmt->bind_param("s", $_REQUEST["rrr"]);
            $stmt->execute();
            $record3 = $stmt->affected_rows;

            $stmt = $mysqli->prepare("UPDATE remitapayments SET 
            Regno = ?, 
            payerName = ?, 
            vLastName = ?, 
            vFirstName = ?, 
            vOtherName = ?, 
            payerEmail = ?, 
            payerPhone = ?, 
            cEduCtgId = ?, 
            Amount = ? 
            WHERE RetrievalReferenceNumber = ?");
            $stmt->bind_param("ssssssssds", $_REQUEST["vMatricNo"], $_REQUEST["payername"], $lname, $fname, $mname, $email, $_REQUEST["payerphone"], $_REQUEST["cEduCtgId"], $_REQUEST["amount"], $_REQUEST["rrr"]);
            $stmt->execute();
            $record4 = $stmt->affected_rows;

            log_actv('Rectified RRR '.$_REQUEST["rrr"].' ('.$_REQUEST["amount"].') for '.$_REQUEST["vMatricNo"]);

            echo $record1.$record2.$record3.$record4.'Records updated successfully';
        }else
        {
            echo 'Records not updated';
        }
    }else if (isset($_REQUEST["vMatricNo"]))
    {
        $stmt = $mysqli->prepare("SELECT f.vApplicationNo, f.cFacultyId, h.vFacultyDesc, i.vdeptDesc, f.iStudy_level, f.tSemester, f.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, f.vLastName, f.vFirstName, f.vOtherName, f.cStudyCenterId, g.vCityName, b.cEduCtgId, vMobileNo  
        FROM programme b, obtainablequal c, afnmatric e, s_m_t f, studycenter g, faculty h, depts i
        WHERE f.cProgrammeId = b.cProgrammeId  
        AND b.cObtQualId = c.cObtQualId
        AND e.vMatricNo = f.vMatricNo 
        AND f.cStudyCenterId = g.cStudyCenterId
        AND f.cFacultyId = h.cFacultyId
        AND b.cdeptId = i.cdeptId
        AND e.vMatricNo = ?");
        $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($vApplicationNo_01, $cfacultyId_01, $vFacultyDesc, $vdeptDesc, $iStudy_level_01, $tSemester_01, $cProgrammeId_01, $vObtQualTitle_01, $vProgrammeDesc_01, $vLastName_01, $vFirstName_01, $vOtherName_01, $cStudyCenterId, $vCityName, $cEduCtgId, $vMobileNo);
        if ($stmt->num_rows === 0 && check_grad_student($_REQUEST["vMatricNo"]) == 0)
        {	
            $stmt->close();
            echo 'Invalid matriculation number';exit;
        }
        
        $stmt->fetch();

        $response = remita_transaction_details('', $_REQUEST["rrr"]);
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
        
        $transactionDate = '';
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
        
        $amount = 0.0;
        if (isset($response['amount']) && $response['amount'] > 0)
        {
            $amount = trim($response['amount']);
            //$amount = number_format($amount);
        }
        
        $email_id = strtolower($_REQUEST["vMatricNo"]).'@noun.edu.ng';

        
        $stmt = $mysqli->prepare("SELECT * FROM s_tranxion_cr WHERE RetrievalReferenceNumber = ? AND vMatricNo = ? AND amount = ?");
        $stmt->bind_param("ssd", $_REQUEST["rrr"], $_REQUEST["vMatricNo"], $amount);
        $stmt->execute();
        $stmt->store_result();
        $on_record = $stmt->num_rows;
        
        $stmt->close();
        
        echo $amount.'#'.$vLastName_01.' '.$vFirstName_01.' '.$vOtherName_01.'#'.$vMobileNo.'#'.$response_code.'#'.$transactionDate.'#'.$response_message.'#'.$email_id.'#'.$on_record.'#'.$cEduCtgId;
    }else
    {
        $stmt = $mysqli->prepare("REPLACE INTO s_tranxion_cr SELECT * FROM s_tranxion_cr_arch WHERE RetrievalReferenceNumber = ?");
        $stmt->bind_param("s", $_REQUEST["rrr"]);
        $stmt->execute();
        $record1 = $stmt->affected_rows;

        $stmt = $mysqli->prepare("REPLACE INTO remitapayments SELECT * FROM remitapayments_arch WHERE RetrievalReferenceNumber = ?");
        $stmt->bind_param("s", $_REQUEST["rrr"]);
        $stmt->execute();
        $record3 = $stmt->affected_rows;

        log_actv('Reversed rectified RRR '.$_REQUEST["rrr"]);

        echo $record1.$record3.'Records updated successfully';
    }
}?>