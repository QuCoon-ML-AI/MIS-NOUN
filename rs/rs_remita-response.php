<?php
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

if (!(isset($_REQUEST['vDesc']) && isset($_REQUEST['cEduCtgId']) && isset($_REQUEST['cEduCtgId_text']) && isset($_REQUEST['user_cat'])))
{
    if (!(isset($_REQUEST['user_cat']) || isset($_REQUEST["vApplicationNo"]) && $_REQUEST['user_cat'] == 3))
    {?>
        <div style="font-family:Verdana, Arial, Helvetica, sans-serif; 
        margin:auto; 
        text-align:center;
    	font-size: 0.78em;"> Follow <a href="../" style="text-decoration:none;">here</a></div><?php
        exit;
    }
}

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once(BASE_FILE_NAME.'lib_fn.php');

require_once('std_lib_fn.php');

require_once (BASE_FILE_NAME.'remita_constants.php');


$orderId = "";
$response_code ="";
$rrr = "";
$response_message = "";
$dat = '';
$msg = "";
$amount = '';
$regno = '';
	
if (isset($_REQUEST['vMatricNo']))
{
	$regno = $_REQUEST['vMatricNo'];
}

if(isset($_GET['orderID']) && $_GET['orderID'] <> '')
{
	$orderId = trim($_GET["orderID"]);
}else if(isset($_REQUEST['orderId']) && $_REQUEST['orderId'] <>  '')
{
	$orderId = $_REQUEST['orderId'];
}

if(isset($_GET['RRR']) && strlen(trim($_GET['RRR'])) > 4)
{
	$rrr = trim($_GET['RRR']);
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


$mysqli = link_connect_db();

$Regno_db = '';
$Amount_db = '';
$vDesc_db = '';
$vLastName_db = '';
$vFirstName_db = '';
$vOtherName_db = '';
$payerEmail_db = '';
$payerPhone_db = '';
$AcademicSession_db = '';
$cEduCtgId_1st = '';
$tSemester = '';
$ResponseCode = '';

$stmt = $mysqli->prepare("SELECT Regno, Amount, vDesc, vLastName, vFirstName, vOtherName, payerEmail, payerPhone, AcademicSession, cEduCtgId, tSemester, ResponseCode, Amount, TransactionDate, Status 
FROM remitapayments 
WHERE MerchantReference = ?");
$stmt->bind_param("s", $orderId);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($Regno_db, $Amount_db, $vDesc_db, $vLastName_db, $vFirstName_db, $vOtherName_db, $payerEmail_db, $payerPhone_db, $AcademicSession_db, $cEduCtgId_1st, $tSemester, $ResponseCode, $amount, $dat, $msg);
$local_record_of_payment = $stmt->num_rows;
$stmt->fetch();
$stmt->close();


$ilin = create_new_session($Regno_db);

$orgsetins = settns();

require_once("std_detail_pg1.php");

if($orderId <> '' && $ResponseCode <> '01' && $ResponseCode <> '00')
{
	$response = remita_transaction_details($orderId, $rrr);
	
	//print_r($response);
	
	if (isset($response['status']))
	{
		$response_code = trim($response['status']);
	}
	
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
	
	if (isset($response['amount']))
	{
		$amount = trim($response['amount']);
	}
}

$hash = '';
if($rrr <> "")
{
	$concatString = MERCHANTID . $rrr . APIKEY;
	$hash = hash('sha512', $concatString);
}

$responseurl = PATH . "/feed-back-from-rem";

$session = $orgsetins['cAcademicDesc'];

$cEduCtgId = $cEduCtgId_1st;

if ($local_record_of_payment > 0)
{
	$session = $AcademicSession_db;
	
	$regno = $Regno_db;
	
	$stmt = $mysqli->prepare("SELECT cStudyCenterId
	FROM s_m_t 
	WHERE vMatricNo = '$Regno_db'");
	$stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cStudyCenterId);
    $stmt->fetch();
    $stmt->close();


	if($response_code == '01' || $response_code == '00' || $ResponseCode == '01')
	{
		$msg = "Successful";
		
		if($Amount_db == $amount && $amount > 0)
		{
			if (!is_bool(strpos($vDesc_db, 'Load fund')) || $vDesc_db == 'Wallet Funding' || $vDesc_db == 'Outstanding amount at graduation' || $vDesc_db == 'Convocation gown')
			{
				$stmt1 = $mysqli->prepare("SELECT vApplicationNo FROM s_m_t WHERE vMatricNo = ?");
				$stmt1->bind_param("s", $regno);
				$stmt1->execute();
				$stmt1->store_result();
				$stmt1->bind_result($vApplicationNo);
				$stmt1->fetch();
				$stmt1->close();
				
				$iItemID_str = '';
				
				$stmt = $mysqli->prepare("SELECT a.vMatricNo, a.iStudy_level, a.tSemester, c.cEduCtgId, a.cFacultyId, a.cdeptId, a.cAcademicDesc_1, a.cStudyCenterId, a.cProgrammeId 
				FROM s_m_t a, remitapayments b, programme c 
				WHERE b.MerchantReference = '$orderId' 
				AND a.vMatricNo = b.Regno
				AND a.cProgrammeId = c.cProgrammeId");
				
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($vMatricNo, $iStudy_level, $tSemester, $cEduCtgId, $cFacultyId, $cdeptId, $cAcademicDesc_1, $cStudyCenterId, $cProgrammeId);
				$stmt->fetch();
				$stmt->close();
					
				$stmt = $mysqli->prepare("SELECT iItemID FROM s_f_s a, fee_items b 
                WHERE a.fee_item_id = b.fee_item_id 
                AND cFacultyId = '$cFacultyId' 
                AND cEduCtgId = '$cEduCtgId'
                AND iSemester = $tSemester
                AND b.fee_item_desc = 'Wallet Funding'");
                //$stmt->bind_param("s", $_REQUEST["vDesc_loc"]);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($iItemID_lc_c);
                $stmt->fetch();
                $stmt->close();
                
                $iItemID_lc_c = $iItemID_lc_c ?? '';
                
                
				if ($iItemID_lc_c == '')
				{
					echo 'We could not complete the transaction. Please contact ICT for resolution';exit;
				}
				
				try
				{
					$mysqli->autocommit(FALSE);

					if (check_rrr($rrr) == 0)
					{
						$nxt_sn = get_nxt_sn($vMatricNo, $iItemID_lc_c, $vDesc_db, $cEduCtgId);
        	
						$fee_item_id = get_fee_item_id($vDesc_db);
						if ($fee_item_id == '')
						{
							echo 'Fee item not defined';exit;
						}
						
						$stmt = $mysqli->prepare("INSERT INTO s_tranxion_cr SET 
						RetrievalReferenceNumber = '$rrr',
						vMatricNo = '$vMatricNo', 
						cCourseId = 'xxxxxx',
						tdate = now(), 
						cTrntype = 'c', 
						iItemID = $iItemID_lc_c, 
						amount = $amount,
						tSemester = $tSemester,
						cAcademicDesc = '".$orgsetins["cAcademicDesc"]."',
						siLevel = $iStudy_level,
						trans_count = $nxt_sn,
						fee_item_id = $fee_item_id,
						vremark = '$vDesc_db'");
						$stmt->execute();
						$stmt->close();

						if ($vDesc_db == 'Convocation gown')
						{
							initite_write_debit_transaction($vMatricNo, $orgsetins["cAcademicDesc"], $tSemester, 'xxxxxx', $vDesc_db);

							$stmt = $mysqli->prepare("INSERT INTO s_tranxion_20242025 SET 
							RetrievalReferenceNumber = '$rrr',
							vMatricNo = '$vMatricNo', 
							cCourseId = 'xxxxxx',
							tdate = now(), 
							cTrntype = 'd', 
							iItemID = $iItemID_lc_c, 
							amount = $amount,
							tSemester = $tSemester,
							cAcademicDesc = '".$orgsetins["cAcademicDesc"]."',
							siLevel = $iStudy_level,
							fee_item_id = $fee_item_id,
							vremark = '$vDesc_db'");
							$stmt->execute();
							$stmt->close();	
						}
					}
					
					if (is_bool(strpos($cProgrammeId, "DEG")) && is_bool(strpos($cProgrammeId, "CHD")))
					{
						register_student_global($iStudy_level, $tSemester, $vMatricNo, $cResidenceCountryId_loc, $cEduCtgId);
					}else
					{
						$nxt_sn = get_nxt_sn($vMatricNo, $iItemID_lc_c, $vDesc_db, $cEduCtgId);
        	
						$fee_item_id = get_fee_item_id($vDesc_db);
						if ($fee_item_id == '')
						{
							echo 'Fee item not defined';exit;
						}
						
						$stmt_reuse = $mysqli->prepare("SELECT a.Amount, a.iItemID, d.fee_item_id 
						FROM s_f_s a, fee_items d 
						WHERE a.fee_item_id = d.fee_item_id 
						AND a.cdel = 'N' 
						AND d.cdel = 'N' 
						AND a.cEduCtgId = 'ELX' 
						AND d.fee_item_desc <> 'Application Fee' 
						AND d.fee_item_desc <> 'Late Fee' 
						AND d.fee_item_desc <> 'Acceptance Fee' 
						AND d.fee_item_desc <> 'Convocation gown' 
						AND d.fee_item_desc <> 'Outstanding amount at graduation' 
						AND cFacultyId = '$cFacultyId'
						AND cdeptid = '$cdeptId' 
						AND new_old_structure = 'o' 
						AND Amount > 0");

						$stmt_reuse->execute();
						$stmt_reuse->store_result();
						$stmt_reuse->bind_result($Amount_01, $iItemID_01, $fee_item_id_01);
						//$vMatricNo, $iStudy_level, $tSemester, $cEduCtgId, $cFacultyId, $cdeptId, $cAcademicDesc_1, $cStudyCenterId, $cProgrammeId
						while ($stmt_reuse->fetch())
						{
							$stmt = $mysqli->prepare("INSERT IGNORE INTO s_tranxion_20242025 
							(vMatricNo, cCourseId, tdate, cTrntype, iItemID, amount, 
							tSemester, 
							cAcademicDesc, 
							siLevel,
							trans_count,
							fee_item_id, 
							vremark
							)VALUE('$vMatricNo','xxxxxx',NOW(),'d','".$iItemID_01."',".$Amount_01.",?,?,?,$nxt_sn,$fee_item_id_01,'Registration Deduction')");
							$stmt->bind_param("isi", $tSemester, $orgsetins["cAcademicDesc"], $iStudy_level);
							$stmt->execute();
						}
						$stmt_reuse->close();

						if ($tSemester == 1)
						{
							$stmt = $mysqli->prepare("UPDATE s_m_t SET 
							session_reg = '1',  
							semester_reg = '1', 
							cAcademicDesc = '".$orgsetins["cAcademicDesc"]."', 
							act_time = NOW() 
							WHERE vMatricNo = '$vMatricNo'");
							$stmt->execute();
							log_actv('registered for new semesetr');
						}else
						{
							$stmt = $mysqli->prepare("UPDATE s_m_t SET 
							semester_reg = '1', 
							cAcademicDesc = '".$orgsetins["cAcademicDesc"]."', 
							act_time = NOW() 
							WHERE vMatricNo = '$vMatricNo'");
							$stmt->execute();
							log_actv('registered for second semesetr');
						}
					}
					
					if (get_active_request(0) == 1)
					{
						$stmt = $mysqli->prepare("UPDATE vc_request 
						SET used = '1'
						WHERE vMatricNo = ?
						AND cdel = 'N'
						ORDER BY time_act DESC LIMIT 1");
						$stmt->bind_param("s", $_REQUEST["vMatricNo"]); 
						$stmt->execute();

						log_actv('Used semester registration request');
					}

					$ipee = getIPAddress();

					$stmt = $mysqli->prepare("insert into atv_log set 
					vApplicationNo  = '$vMatricNo',
					vDeed = 'Paid $amount for $vDesc_db',
					tDeedTime = now(),
					act_location =  ?");
					$stmt->bind_param("s", $ipee);
					$stmt->execute();
					
					$stmt->close();
					
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				}catch(Exception $e)
				{
					$mysqli->rollback(); //remove all queries from queue if error (undo)
					throw $e;
				}
			}
		}
	}else if($response_code == '021')
	{
		$msg = "Pending";
	}else
	{
		$msg = "Not Successful"; 
	}
}

if ($ResponseCode <> '01' && $ResponseCode <> '00')
{
	$stmt = $mysqli->prepare("UPDATE remitapayments SET
	RetrievalReferenceNumber = ?, 
	ResponseCode = ?, 
	ResponseDescription = ?, 
	TransactionDate = ?, 
	status = ? 
	WHERE MerchantReference = ?");
	$stmt->bind_param("ssssss", $rrr, $response_code, $response_message, $dat, $msg, $orderId);
	$stmt->execute();
	$stmt->close();
}?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="<?php echo BASE_FILE_NAME;?>js_file_1.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE_FILE_NAME;?>styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rem_response.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
        require_once(BASE_FILE_NAME."feedback_mesages.php");

		if ($response_code == '01')
		{?>
			<script language="JavaScript" type="text/javascript">
                inform("Success");
            </script><?php
		}?>

		<form action="new-application-number" method="post" name="nxt" enctype="multipart/form-data">
			<input name="vApplicationNo" type="hidden" value="<?php echo $regno; ?>" />
			<input name="study_mode" type="hidden" value="" />
			<input name="cEduCtgId" type="hidden" value="<?php echo $cEduCtgId; ?>" />
			<input name="user_cat" type="hidden" value="1" />
			<input name="nap" type="hidden" value="1" />
			
			<input name="payerEmail" id="payerEmail" type="hidden" value="<?php echo $payerEmail_db;?>" />
			<input name="payerPhone" id="payerPhone" type="hidden" value="<?php echo $payerPhone_db;;?>" />
			<input name="payerName" id="payerName" type="hidden" value="<?php echo $vLastName_db.' '.$vFirstName_db.' '.$vOtherName_db;?>" />
		</form>
	
		<form action="home-page" method="post" name="hpg" enctype="multipart/form-data">
			<input name="vApplicationNo" type="hidden" value="<?php if (isset($vApplicationNo)){echo $vApplicationNo;} ?>" />
			<input name="vMatricNo" type="hidden" value="<?php if (isset($vMatricNo)){echo $vMatricNo;} ?>" />
			<input name="user_cat" type="hidden" value="" />
			<input name="ilin" type="hidden" value="<?php if (isset($ilin)){echo $ilin;} ?>" />
			<input name="logout" type="hidden" value="1" />
			<input name="currency" id="currency" type="hidden" value="<?php if (isset($currency) && $currency=='1'){echo $currency;} ?>" />
		</form>
	
		<form action="home-page" method="post" name="hpg" enctype="multipart/form-data">
			<input name="vApplicationNo" type="hidden" value="<?php if (isset($vApplicationNo)){echo $vApplicationNo;} ?>" />
			<input name="vMatricNo" type="hidden" value="<?php if (isset($vMatricNo)){echo $vMatricNo;} ?>" />
			<input name="user_cat" type="hidden" value="" />
			<input name="ilin" type="hidden" value="<?php if (isset($ilin)){echo $ilin;} ?>" />
			<input name="logout" type="hidden" value="1" />
			<input name="currency" id="currency" type="hidden" value="<?php if (isset($currency) && $currency=='1'){echo $currency;} ?>" />
		</form><?php
		
        require_once("./forms.php");?>

		<!-- <form action="<?php //echo GATEWAYRRRPAYMENTURL;?>" id="remita_form" name="remita_form" method="POST">
			<input id="merchantId" name="merchantId" value="<?php //echo MERCHANTID; ?>" type="hidden"/>
			<input id="serviceTypeId" name="serviceTypeId" value="<?php //echo SERVICETYPEID; ?>" type="hidden"/>
			<input id="amt" name="amt" value="<?php //echo $amount; ?>" type="hidden"/>
			<input id="responseurl" name="responseurl" value="<?php //echo $responseurl; ?>" type="hidden"/>
			<?php //if($rrr!=""){?>
			<input name="rrr" value="<?php //echo $rrr?>" type="hidden">
			<?php //}?>
			<input id="hash" name="hash" value="<?php //echo $hash; ?>" type="hidden"/>
		</form> -->
		
        <div class="appl_container">
			<div id="background" class="center"
				style="z-index:2; 
				display:block;
				height:auto; 
				width:auto;
				left: 45%;
				top: 30%;
				text-align:center">
				<p id="bg-text" 
					style="color:#ff9797;
					font-size:155px;
					transform:rotate(-48deg);
					-webkit-transform:rotate(-48deg);
					opacity:0.3"><?php echo $vDesc_db;?></p>
			</div>
            
			<?php left_conttent_for_receipt('Payment receipt',$regno);?>
            
            <div class="appl_right_div" style="font-size:1em;">
                <form action="confirm-pay-detail" method="post" name="pay" id="pay" enctype="multipart/form-data">
                    <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
                    <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
                    <input name="save" id="save" type="hidden" value="-1" />
                    <input name="rrr_sys" type="hidden" value="1" />
                    
                    <input name="p_status" id="p_status" type="hidden" value="Pending"/>				
				    <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>" />

                    <input name="payerName" id="payerName" type="hidden" value="<?php if (isset($_REQUEST['payerName'])){echo $_REQUEST['payerName'];}?>" />
				
                    <input name="vLastName" id="vLastName" type="hidden" value="<?php if (isset($_REQUEST['vLastName'])){echo $_REQUEST['vLastName'];}?>" />
                    <input name="vFirstName" id="vFirstName" type="hidden" value="<?php if (isset($_REQUEST['vFirstName'])){echo $_REQUEST['vFirstName'];};?>" />
                    <input name="vOtherName" id="vOtherName" type="hidden" value="<?php if (isset($_REQUEST['vOtherName'])){echo $_REQUEST['vOtherName'];};?>" />
                    
                    <input name="payerEmail" id="payerEmail" type="hidden" value="<?php if (isset($_REQUEST['payerEmail'])){echo $_REQUEST['payerEmail'];}?>" />
                    <input name="payerPhone" id="payerPhone" type="hidden" value="<?php if (isset($_REQUEST['payerPhone'])){echo $_REQUEST['payerPhone'];}?>" />
                    <input name="amount" id="amount" type="hidden" value="<?php if (isset($_REQUEST['amount'])){echo $_REQUEST['amount'];}?>" />
                    
                    <input name="vDesc" id="vDesc" type="hidden" value="<?php if (isset($_REQUEST['vDesc'])){echo $_REQUEST['vDesc'];}?>" />
                    
                    <input name="orderId" id="orderId" type="hidden" value="<?php echo $orderId;?>" />

                    <input name="cEduCtgId_text" id="cEduCtgId_text" type="hidden" value="<?php if (isset($_REQUEST["cEduCtgId_text"])){echo $_REQUEST["cEduCtgId_text"];} ?>"/>
                
                    <?php //appl_top_menu_home();?>

                    <div class="appl_left_child_div" style="text-align: left; margin:auto; max-height:95%; margin-top:5px; background-color: #eff5f0;">
						<!-- <img src="<?php echo get_pp_pix('');?>" width="140px" height="140px" style="position:absolute; top:15px; right:15px" /> -->
						<div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff">
                                1
                            </div>
                            <div style="flex:25%; padding-left:4px; height:45px; background-color: #ffffff">
								Matriculation form number
                            </div>
                            <div style="flex:70%; padding-left:4px; height:45px; background-color: #ffffff">
								<?php echo $regno;?>
                            </div>
                        </div>
						
						<div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff">
                                2
                            </div>
                            <div style="flex:25%; padding-left:4px; height:45px; background-color: #ffffff">
                                Name
                            </div>
                            <div style="flex:70%; padding-left:4px; height:45px; background-color: #ffffff">
							<?php echo strtoupper($vLastName_db).', '.ucwords(strtolower($vFirstName_db)).' '.ucwords(strtolower($vOtherName_db));?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff">
                                3
                            </div>
                            <div style="flex:25%; padding-left:4px; height:45px; background-color: #ffffff">
                                Personal eMail address
                            </div>
                            <div style="flex:70%; padding-left:4px; height:45px; background-color: #ffffff">
								<?php echo $payerEmail_db;?>
                            </div>
                        </div><?php
		
						if($rrr <> '')
					   	{?>
							<div class="appl_left_child_div_child">
								<div style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff">
									4
								</div>
								<div style="flex:25%; padding-left:4px; height:45px; background-color: #ffffff">
									Remita retrieval reference (RRR)
								</div>
								<div style="flex:70%; padding-left:4px; height:45px; background-color: #ffffff">
									<?php echo $rrr;?>
								</div>
							</div>

							<div  class="appl_left_child_div_child">
								<div style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff">
									5
								</div>
								<div style="flex:25%; padding-left:4px; height:45px; background-color: #ffffff">
									Transaction order number
								</div>
								<div style="flex:70%; padding-left:4px; height:45px; background-color: #ffffff">
									<?php echo $orderId;?>
								</div>
							</div>

							<div  class="appl_left_child_div_child">
								<div style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff">
									6
								</div>
								<div style="flex:25%; padding-left:4px; height:45px; background-color: #ffffff">
									Date
								</div>
								<div style="flex:70%; padding-left:4px; height:45px; background-color: #ffffff">
									<?php echo $dat;?>
								</div>
							</div>						

							<div  class="appl_left_child_div_child">
								<div style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff">
									7
								</div>
								<div style="flex:25%; padding-left:4px; height:45px; background-color: #ffffff">
									Description
								</div>
								<div style="flex:70%; padding-left:4px; height:45px; background-color: #ffffff"><?php 
									if (!is_bool(strpos($vDesc_db, 'Load fund')) || $vDesc_db == "Wallet Funding")
									{
										if ($tSemester == 1)
										{
											if ($iStudy_level < 100 || $iStudy_level > 500)
											{
												echo $vDesc_db . ",  first semester ".$session." academic session";
											}else
											{
												echo $vDesc_db . "  ".$iStudy_level."Level, first semester ".$session." academic session";
											}
										}else
										{
											if ($iStudy_level < 100 || $iStudy_level > 500)
											{
												echo $vDesc_db . ", second semester ".$session." academic session";
											}else
											{
												echo $vDesc_db . "  ".$iStudy_level."Level, second semester ".$session." academic session";
											}
										}
									}else
									{
										echo $vDesc_db;
									}?>
								</div>
							</div>					

							<div  class="appl_left_child_div_child">
								<div style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff">
									8
								</div>
								<div style="flex:25%; padding-left:4px; height:45px; background-color: #ffffff">
									Amount (NGN)
								</div>
								<div style="flex:70%; padding-left:4px; height:45px; background-color: #ffffff">
									<?php if (is_numeric($amount))
									{
										echo number_format($amount, 2);
									}else
									{
										echo 'Check your network connection and try again';
									}?>
								</div>
							</div><?php
						}?>

                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                9
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                Status
                            </div><?php
                               $status_color = '#000000';
							   if (!is_bool(strpos($msg, 'pending')) || !is_bool(strpos($msg, 'Not')))
							   {
								   $status_color = '#FF3300';
							   }else if (!is_bool(strpos($msg, 'unpaid')))
							   {
								   $status_color = '#990000';
							   }else if (!is_bool(strpos($msg, 'Successful')))
							   {
								   $status_color = '#009900';
							   }?>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff; color:<?php echo $status_color;?>">
                                <?php echo $msg;?>
                            </div>
                        </div><?php
			
						if ($vDesc_db <> 'Acceptance Fee')
						{
							$feedback_msg = 'Remember to save and print a copy of this page before you click the continue button.<br>';
						}else
						{
							$feedback_msg = 'Remember to save a copy of this page before you leave the page.<br>';
						}

						if ($msg == 'Successful')
						{
							if ($vDesc_db == 'Application Fee')
							{
								//$feedback_msg .= 'You may click on the Continue bitton to proceed'; 
							}
						}else if ($msg == 'Pending')
						{
							$feedback_msg = "Please click the 'Refresh page' button to double-check status<br>";
						}

						if ($feedback_msg <> '')
						{?>							
							<div class="appl_left_child_div_child" style="margin-top:5px; color:#FF3300; background-color: #FFFFFF">
								<div style="flex:5%; height:40px;"></div>
								<div style="flex:95%; padding-right:4px; height:40px; text-align:right; font-weight:bold"><?php
									echo $feedback_msg;?>
								</div>
							</div><?php
						}?>

                        <div class="appl_left_child_div_child" style="margin-top:10px;">
                            <div style="flex:5%; height:90px; background-color: #eff5f0"></div>
                            <div style="flex:95%; padding-left:4px; height:110px; background-color: #eff5f0">
                                <img class="remita_logo"src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'remitahorizon.png');?>"/>
                            </div>
                        </div>
                    </div>

                    <div class="appl_left_child_div" style="text-align: right; margin:auto; margin-top:15px;"><?php
						if ($msg == 'Successful')
						{
						    $stmt = $mysqli->prepare("DELETE FROM ses_tab WHERE vApplicationNo = ?");
                    		$stmt->bind_param("s", $regno);
                    		$stmt->execute();
                    		$stmt->close();
                    		
                    		date_default_timezone_set('Africa/Lagos');
                    		$date2 = date("Y-m-d h:i:s");
                    		$date3 = date("Y-m-d");
                    		
                    		$today = getdate();
                    		$min = ($today['hours'] * 60) + $today['minutes'];
                    		$ilin = date("dmyHis");
                    		
                    		$stmt = $mysqli->prepare("REPLACE INTO ses_tab 
                    		SET vApplicationNo = ?,
                    		ilin = '$ilin',
                    		dtl_date = '$date3',
                    		timer_prev = $min,
                    		time_stamp = '$date2'");
                    		$stmt->bind_param("s", $regno);
                    		$stmt->execute();
                    		$stmt->close();
                    		
                    		$ilin = hash('sha512', $ilin)?>
                    		
							<a href="#" target="_self" style="text-decoration:none;"
								onclick="resetSideMenu();
								std_sections.top_menu_no.value='';
								std_sections.side_menu_no.value='';
								std_sections.ilin.value='<?php echo $ilin;?>';
								std_sections.action='welcome_student';
								in_progress('1');
								std_sections.submit();
								return false"> 
								<div class="login_button" title="Recover paasword">Continue</div>
							</a><?php
						}?>
                    </div>
                </form>
            </div>
        </div>
	</body>
</html>