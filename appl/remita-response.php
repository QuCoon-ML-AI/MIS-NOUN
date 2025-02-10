<?php
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('const_def.php');
require_once('../../PHPMailer/mail_con.php');
require_once('../../fsher/fisher.php');
require_once('lib_fn.php');

require_once 'remita_constants.php';


$orderId = "";
$response_code ="";
$rrr = "";
$response_message = "";
$dat = '';
$msg = "";
$amount = 0;
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

if(isset($_GET['status']))
{
	$response_message = trim($_GET['status']);
}

if(isset($_GET['statuscode']))
{
	$response_code = trim($_GET['statuscode']);
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
	curl_setopt($ch, CURLOPT_URL, $url);
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

$stmt = $mysqli->prepare("SELECT Regno, Amount, vDesc, vLastName, vFirstName, vOtherName, payerEmail, payerPhone, AcademicSession, cEduCtgId, tSemester, ResponseCode, Amount, TransactionDate, ResponseDescription,Status 
FROM remitapayments_app 
WHERE MerchantReference = ?");
$stmt->bind_param("s", $orderId);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($Regno_db, $Amount_db, $vDesc_db, $vLastName_db, $vFirstName_db, $vOtherName_db, $payerEmail_db, $payerPhone_db, $AcademicSession_db, $cEduCtgId_1st, $tSemester, $ResponseCode, $amount, $dat, $ResponseDescription, $msg);
$local_record_of_payment = $stmt->num_rows;
$stmt->fetch();
$stmt->close();

$Regno_db = $Regno_db ?? '';

$vEduCtgDesc = '';

$stmt = $mysqli->prepare("SELECT vEduCtgDesc FROM educationctg 
WHERE cEduCtgId = '$cEduCtgId_1st'");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($vEduCtgDesc);
$stmt->fetch();
$stmt->close();


$response_code = '';

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
}else if ($ResponseCode == '01' || $ResponseCode == '00')
{
	$response_code = $ResponseCode;
	$response_message = $ResponseDescription;
}

$hash = '';
if($rrr <> "")
{
	$concatString = MERCHANTID . $rrr . APIKEY;
	$hash = hash('sha512', $concatString);
}

$responseurl = PATH . "/feed-back-from-rem";

$orgsetins = settns();
$session = $orgsetins['cAcademicDesc'];

$cEduCtgId = '';

if ($local_record_of_payment > 0)
{
	$session = $AcademicSession_db;
	
	$regno = $Regno_db;
	
    if ($regno == '')
    {
        $stmt = $mysqli->prepare("SELECT cStudyCenterId, cEduCtgId, iBeginLevel
        FROM prog_choice 
        WHERE vLastName = '$vLastName_db' 
        and vFirstName = '$vFirstName_db'
        and vOtherName = '$vOtherName_db' 
        and vEMailId = '$payerEmail_db'
        and vMobileNo = '$payerPhone_db'
        and cAcademicDesc = '$AcademicSession_db'");
    }else
    {       
        $stmt = $mysqli->prepare("SELECT cStudyCenterId, cEduCtgId, iBeginLevel
        FROM prog_choice 
        WHERE vApplicationNo = ?");
        $stmt->bind_param("s", $regno);
    }
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cStudyCenterId, $cEduCtgId_db, $iBeginLevel);
    $stmt->fetch();
    $stmt->close();

	$cEduCtgId = $cEduCtgId_db;

	if($response_code == '01' || $response_code == '00')
	{
		$msg = "Successful";
		
		if($Amount_db == $amount && $amount > 0)
		{
			if ($vDesc_db == 'Application Fee')
			{
				$iStudy_level = 000;
				try
				{
					$mysqli->autocommit(FALSE);
					
					if (trim($regno) == '')
					{
						$regno = alloc_dum_pin($rrr);
					}
					
					if ($regno <> '')
					{
						$vApplicationNo = $regno;
						
						$stmt1 = $mysqli->prepare("UPDATE prog_choice_0 SET 
						vApplicationNo = '$regno'
						WHERE vLastName = '$vLastName_db' 
						and vFirstName = '$vFirstName_db'
						and vOtherName = '$vOtherName_db' 
						and vEMailId = '$payerEmail_db'
						and vMobileNo = '$payerPhone_db'
						and cAcademicDesc = '$AcademicSession_db'");
						$stmt1->execute();
						$stmt1->close();
						
						$stmt1 = $mysqli->prepare("REPLACE INTO prog_choice SELECT * FROM prog_choice_0 WHERE vApplicationNo = '$regno';");
						$stmt1->execute();

						$stmt1 = $mysqli->prepare("UPDATE remitapayments_app a, prog_choice b SET b.cEduCtgId = a.cEduCtgId WHERE a.Regno = b.vApplicationNo AND a.Regno = '$regno'");
						$stmt1->execute();
						
						$stmt1 = $mysqli->prepare("DELETE FROM prog_choice_0 WHERE vApplicationNo = '$regno';");
						//$stmt1->execute();
						$stmt1->close();
					}
						
					$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				}catch(Exception $e)
				{
					$mysqli->rollback(); //remove all queries from queue if error (undo)
					throw $e;
				}
				
				$stmt1 = $mysqli->prepare("SELECT cEduCtgId from prog_choice where vApplicationNo = ?");
				$stmt1->bind_param("s", $regno);
				$stmt1->execute();
				$stmt1->store_result();
				$stmt1->bind_result($cEduCtgId_db);
				$stmt1->fetch();
				$stmt1->close();
				
				if ($cEduCtgId_db <> '' && $cEduCtgId == '')
				{
					$cEduCtgId = $cEduCtgId_db;
				}
				
				if ($cEduCtgId == '')
				{
					$cEduCtgId = $cEduCtgId_1st;
				}

				$rssql = mysqli_query(link_connect_db(), "SELECT iItemID FROM s_f_s a, fee_items b 
				WHERE a.fee_item_id = b.fee_item_id 
				AND a.cEduCtgId = '$cEduCtgId'
				AND b.fee_item_desc = 'Application Fee' 
				AND a.cdel = 'N' ORDER BY iItemID LIMIT 1") or die("error: ".mysqli_error(link_connect_db()));
				$rs_iItemID = mysqli_fetch_array($rssql);
				$iItemID_lc_c = $rs_iItemID[0];
				$iItemID_lc_d = $iItemID_lc_c;
				mysqli_close(link_connect_db());


				if ($iItemID_lc_d == ''){$iItemID_lc_d = 0;}
				

				$fee_item_id = get_fee_item_id($vDesc_db);
				if ($fee_item_id == '')
				{
					echo 'Fee item not defined';exit;
				}
							
                date_default_timezone_set('Africa/Lagos');
                $date2 = date("Y-m-d h:i:s");
				
				if (check_rrr($rrr) == 0){
					$nxt_sn = get_nxt_sn ($regno, '', 'paid '.$vDesc_db, $cEduCtgId_1st);

					$stmt = $mysqli->prepare("INSERT INTO s_tranxion_cr SET 
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
					vremark = 'paid $vDesc_db',
					tdate = '$date2'");
					$stmt->execute();
					$stmt->close();
				}
				
				initite_write_debit_transaction($regno, $session, '1', 'xxxxxx', $vDesc_db);

				$stmt = $mysqli->prepare("INSERT INTO s_tranxion_20242025 SET 
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
				vremark = '$vDesc_db',
				tdate = '$date2'");
				$stmt->execute();
				$stmt->close();				
				
				$ipee = getIPAddress();

				$stmt2 = $mysqli->prepare("INSERT INTO atv_log SET 
				vApplicationNo  = '$regno',
				vDeed = 'Paid $amount for $vDesc_db',
				tDeedTime = now(),
				act_location =  ?");
				$stmt2->bind_param("s", $ipee);
				$stmt2->execute();
				$stmt2->close();
			}
		}

		//if ($ResponseCode <> '01' && $ResponseCode <> '00')
		//{
			if ($regno <> '')
			{
				$stmt = $mysqli->prepare("UPDATE remitapayments_app SET 
				Regno = '$regno',
				RetrievalReferenceNumber = ?, 
				ResponseCode = ?, 
				ResponseDescription = ?, 
				TransactionDate = ?, 
				status = ? 
				WHERE MerchantReference = ?");
			}else
			{
				$stmt = $mysqli->prepare("UPDATE remitapayments_app SET 
				RetrievalReferenceNumber = ?, 
				ResponseCode = ?, 
				ResponseDescription = ?, 
				TransactionDate = ?, 
				status = ? 
				WHERE MerchantReference = ?");
			}

			$stmt->bind_param("ssssss", $rrr, $response_code, $response_message, $dat, $msg, $orderId);
			$stmt->execute();
			$stmt->close();
		//}
	}else if($response_code == '021')
	{
		$msg = "Pending";
	}else
	{
		$msg = "Not Successful"; 
	}
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
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/remresponse.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
		require_once("feedback_mesages.php");?>

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

		$stmt = $mysqli->prepare("SELECT a.ilin, d.cStudyCenterId
		FROM ses_tab a, pics b, afnmatric c, s_m_t d
		WHERE c.vApplicationNo = b.vApplicationNo
		AND a.vApplicationNo = c.vMatricNo
		AND d.vMatricNo = c.vMatricNo
		AND b.cinfo_type = 'p'
		AND a.vApplicationNo = ?");
		$stmt->bind_param("s", $regno);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($ilin, $cStudyCenterId);
		$passpotLoaded = $stmt->num_rows;
		$stmt->fetch();
		$stmt->close();?>
		
		<form action="student-home-page" method="post" name="myhome" enctype="multipart/form-data">
			<input name="vMatricNo" type="hidden" value="<?php echo $regno; ?>" />
			<input name="user_cat" type="hidden" value="5" />
			<input name="ilin" type="hidden" value="<?php echo $ilin; ?>" />
			<input name="just_paid" id="just_paid" type="hidden" />
			<input name="side_menu_no" type="hidden" />
			<input name="currency" id="currency" type="hidden" value="<?php if ($ilin<>''){echo '1';} ?>" />
			<input name="study_mode" id="study_mode" type="hidden" value="">
			<input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php echo $passpotLoaded;?>">
			<input name="cStudyCenterId" id="cStudyCenterId" type="hidden" value="<?php echo $cStudyCenterId;?>">
		</form>
		
        <div class="appl_container">
			<div id="background" class="center"
					style="z-index:2; 
					display:block;
					height:auto; 
					width:auto;
					text-align:center;">
					<p id="bg-text" 
						style="color:#ff9797;
						font-size:150px;
						transform:rotate(-45deg);
						-webkit-transform:rotate(-45deg);
						opacity:0.3"><?php echo $vDesc_db;?></p>
				</div>
            <?php //left_conttent('Transaction alert');?>
			<?php left_conttent_for_receipt('Payment receipt','');?>
            
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

                    <div class="appl_left_child_div" style="text-align: left; margin:auto; margin-top:5px; background-color: #eff5f0;">
						<!-- <img src="<?php //echo get_pp_pix($regno);?>" width="140px" height="140px" style="position:absolute; top:15px; right:15px" /> -->
						<div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff">
                                1
                            </div>
                            <div style="flex:25%; padding-left:4px; height:45px; background-color: #ffffff"><?php
								$extra_msg = '';
								if (!is_bool(strpos($vDesc_db, 'Load fund')) || !is_bool(strpos($vDesc_db, 'Registration')) || !is_bool(strpos($vDesc_db, 'Convocation')))
								{
									echo 'Matriculation form number';
								}else
								{
									echo 'Application form number';
									$extra_msg = '<b>Note the assigned application form number for future reference</b>';
								}?>
                            </div>
                            <div style="flex:70%; padding-left:4px; height:45px; background-color: #ffffff; color:#FF3300;">
								<?php echo $regno.' '.$extra_msg;?>
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
							<?php echo strtoupper($vLastName_db).', '.ucwords(strtolower($vFirstName_db)).' '.ucwords(strtolower($vOtherName_db));
							$payerName = strtoupper($vLastName_db).', '.ucwords(strtolower($vFirstName_db)).' '.ucwords(strtolower($vOtherName_db));?>
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
                        </div>

						<div class="appl_left_child_div_child">
							<div style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff">
								4
							</div>
							<div style="flex:25%; padding-left:4px; height:45px; background-color: #ffffff">
								Personal phone number
							</div>
							<div style="flex:70%; padding-left:4px; height:45px; background-color: #ffffff">
								<?php echo $payerPhone_db;?>
							</div>
						</div><?php
		
						if($rrr <> '')
					   	{?>
							<div class="appl_left_child_div_child">
								<div style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff">
									5
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
									6
								</div>
								<div style="flex:25%; padding-left:4px; height:45px; background-color: #ffffff">
									Transaction Reference
								</div>
								<div style="flex:70%; padding-left:4px; height:45px; background-color: #ffffff">
									<?php echo $orderId;?>
								</div>
							</div>

							<div  class="appl_left_child_div_child">
								<div style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff">
									7
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
									8
								</div>
								<div style="flex:25%; padding-left:4px; height:45px; background-color: #ffffff">
									Description
								</div>
								<div style="flex:70%; padding-left:4px; height:45px; background-color: #ffffff"><?php 
										echo $vDesc_db .' for '.$vEduCtgDesc.' programme';
										
                                
										$p = strpos($vEduCtgDesc, 'Master');
										if ($amount == '20000' && $p !== false)
										{
											echo ' (CEMBA/CEMPA)';
										}?>
								</div>
							</div>					

							<div  class="appl_left_child_div_child">
								<div style="flex:5%; padding-left:4px; height:45px; background-color: #ffffff">
									9
								</div>
								<div style="flex:25%; padding-left:4px; height:45px; background-color: #ffffff">
									Amount (NGN)
								</div>
								<div style="flex:70%; padding-left:4px; height:45px; background-color: #ffffff">
									<?php echo number_format($amount, 2);?>
								</div>
							</div><?php
						}?>

                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                10
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

									$subject = 'Allocation of Application form number';
									$mail_msg = 'Dear '.$payerName.',<p>The application form number, '.$regno.' has been allocated to you<br>.
									You will enter it along with the password of your choice at the point of logging into your application form.<br><br>
									Thank you.';

									$mail_msg = wordwrap($mail_msg, 70);

									$mail->addAddress($payerEmail_db, $payerName); // Add a recipient
									$mail->Subject = $subject;
									$mail->Body = $mail_msg;
									
									for ($incr = 1; $incr <= 5; $incr++)
									{
										if ($mail->send())
										{
											log_actv('Sent Application form number to '.$payerEmail_db);
											break;
										}
									}
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
                            <div style="flex:95%; padding-left:4px; height:120px; background-color: #eff5f0">
                                <img class="remita_logo"src="img/remitahorizon.png"/>
                            </div>
                        </div>
                    </div>

                    <div class="appl_left_child_div" style="text-align: right; margin:auto; margin-top:15px;"><?php
						if ($vDesc_db == 'Application Fee' && $msg == 'Successful')
						{?>
							<a href="#" target="_self" style="text-decoration:none;"
								onclick="nxt.submit(); return false"> 
								<div class="login_button" title="Continue">Cotinue</div>
							</a><?php
						}?>
                    </div>
                </form>
            </div>
        </div><?php
		if ($response_code == '01' || $response_code == '00')
		{?>
			<script language="JavaScript" type="text/javascript">
                inform("Success");
            </script><?php
		}?>
	</body>
</html>