<?php 
require_once('good_entry.php');

/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once(BASE_FILE_NAME.'lib_fn.php');

require_once('std_lib_fn.php');

require_once (BASE_FILE_NAME.'remita_constants.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="../appl/img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="../appl/js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/gpinone.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="../appl/styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/gpinone.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_side_menu.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
	    $mysqli = link_connect_db();

        $orgsetins = settns();
        
        require_once("../appl/feedback_mesages.php");
        require_once("std_detail_pg1.php");
        require_once("./forms.php");
        
        require_once("./set_scheduled_dates.php");

        if ($iStudy_level_loc <= 200)
        {
            $reg_open = $reg_open_100_200;
        }else
        {
            $reg_open = $reg_open_300;
        }
        
        $orderId = '';
        $balance = 0.00;?>
        <div class="appl_container">
            <div class="appl_left_div" style="z-index:2;">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em">Make payment</div>
                
                <div class="for_computer_screen">
                    <?php require_once ('std_left_side_menu.php');?>                    
                </div>
            </div>
            
            <div class="appl_right_div">
                <div class="appl_left_child_div for_mobile_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php std_top_samll_menu();?>
                </div>

                <div class="appl_left_child_div for_computer_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php std_top_menu();?>
                </div>

                <div class="appl_left_child_div for_mobile_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php require_once ('mobile_menu_bar_content.php');?>
                </div>
                
                <div class="appl_left_child_div for_computer_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php require_once ('menu_bar_content.php');?>
                </div>

                <div id="menu_sm_scrn">
                    <?php build_menu_right();?>
                </div><?php

                $responseurl = PATH . "/feed-back-from-rem";
                $serviceTypeID = SERVICETYPEID;
                $merchantId = MERCHANTID;
                $gatewayUrl = GATEWAYURL;

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
                
                $session = $orgsetins['cAcademicDesc'];
                
                $vLastName = $vLastName_loc;
                $vFirstName = $vFirstName_loc;
                $vOtherName = $vOtherName_loc;

                $vEMailId = $vEMailId_loc;
                $vMobileNo = $vMobileNo_loc;

                $cEduCtgId = $cEduCtgId_loc;
                $tSemester = $tSemester_loc;

                $rrr = '';
                
                if (isset($_REQUEST["request_id"]) && $_REQUEST["request_id"] == '1')
                {
                    $orderId = DATE("dmyHis");                       
                    
                    if(isset($_REQUEST['amount']) && $_REQUEST['amount'] <> ''){$amount = $_REQUEST['amount'];}else {$amount = 0;}
                    if(isset($_REQUEST['orderId']) && $_REQUEST['orderId'] <> ''){$orderId = $_REQUEST['orderId'];}
                    if(isset($_REQUEST['vDesc'])&& $_REQUEST['vDesc'] <> ''){$vDesc = $_REQUEST['vDesc'];}else {$vDesc = '';}
                    
                    $response = '';
                    $response_code = '';

                    $stmt = $mysqli->prepare("SELECT RetrievalReferenceNumber, ResponseCode FROM remitapayments WHERE MerchantReference = ?");
                    $stmt->bind_param("s", $orderId);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($rrr, $response_code_01);
                    $stmt->fetch();

                    $hash = '';
                    $payerName = $vLastName.' '.$vFirstName.' '.$vOtherName;

                    $payerEmail = $vEMailId;
                    $payerPhone = $vMobileNo;

                    if ($rrr == '' || $rrr == 'xxxx')
                    {
                        $url = GATEWAYURL;
                        
                        $split_body = '';

                        $app_rrr_exist = -1;
                        $reg_rrr_exist = -1;
                        $r_rrr_exist = -1;

                        $lp_cnt = 0;

                        function split_merchantID($orderId)
                        {
                            $tnxref = '';
                            for($i = 0; $i < 4; $i++)
                            {
                                $tnxref .= mt_rand(0, 9);
                            }
                            return $tnxref.$orderId;
                        }
                                    

                        while ($reg_rrr_exist <> 0 || $app_rrr_exist <> 0 || $r_rrr_exist <> 0)
                        {
                            if ($app_rrr_exist <> -1)
                            {
                                $orderId = DATE("dmyHis");
                            }

                            if ($amount >= 3000 && $cResidenceCountryId_loc == 'NG' && $reg_open == 1 && is_bool(strpos($cProgrammeId_loc, "CHD")) && is_bool(strpos($cProgrammeId_loc, "DEG")))
                            {
                                $stmt1 = $mysqli->prepare("SELECT vMatricNo FROM split_rec WHERE vMatricNo  = ? AND split_date  >= '$semester_begin_date'");
                                $stmt1->bind_param("s", $_REQUEST['vMatricNo']);
                                $stmt1->execute();
                                $stmt1->store_result();
                                if ($stmt1->num_rows == 0)
                                {
                                    $itemid0 = split_merchantID($orderId);
                                    $itemid1 = split_merchantID($orderId);
                                    $itemid2 = split_merchantID($orderId);
    
                                    $parent_share_name = "National Open University";
                                    $parent_share_bank_acnt = '0230171261018';
                                    $parent_share_bank_code = '000';
    
                                    $parent_share = $amount - 2000;
                                    $child_share = 2000;
    
                                    $child_share_name = 'Intradot Limited';
                                    $child_share_bank_acnt = '1017753107';
                                    $child_share_bank_code = '057';
    
    
                                    $parent_share = $parent_share - 1000;
                                    $child_share1 = 1000;                        
                                
                                    $child_share1_name = 'Cyberspace Ltd';
                                    $child_share1_bank_acnt = '1012598972';
                                    $child_share1_bank_code = '057';
    
                                    $split_body = ",
                                    \"lineItems\":[
                                        {
                                            \"lineItemsId\":\"$itemid0\",
                                            \"beneficiaryName\":\"$parent_share_name\",
                                            \"beneficiaryAccount\":\"$parent_share_bank_acnt\",
                                            \"bankCode\":\"$parent_share_bank_code\",
                                            \"beneficiaryAmount\":\"$parent_share\",
                                            \"deductFeeFrom\":\"1\"
                                        },
                                        {
                                            \"lineItemsId\":\"$itemid1\",
                                            \"beneficiaryName\":\"$child_share_name\",
                                            \"beneficiaryAccount\":\"$child_share_bank_acnt\",
                                            \"bankCode\":\"$child_share_bank_code\",
                                            \"beneficiaryAmount\":\"$child_share\",
                                            \"deductFeeFrom\":\"0\"
                                        },
                                        {
                                            \"lineItemsId\":\"$itemid2\",
                                            \"beneficiaryName\":\"$child_share1_name\",
                                            \"beneficiaryAccount\":\"$child_share1_bank_acnt\",
                                            \"bankCode\":\"$child_share1_bank_code\",
                                            \"beneficiaryAmount\":\"$child_share1\",
                                            \"deductFeeFrom\":\"0\"
                                        }
                                    ]";
                                }
                                $stmt1->close();
                            }

                            $content = "{\"serviceTypeId\": \"$serviceTypeID\",
                            \"amount\": \"$amount\",
                            \"orderId\": \"$orderId\",
                            \"payerName\": \"$payerName\",
                            \"payerEmail\": \"$payerEmail\",
                            \"payerPhone\": \"$payerPhone\",
                            \"description\": \"$vDesc\"$split_body}";

                            $concatString = MERCHANTID.SERVICETYPEID.$orderId.$amount.APIKEY;
                            $hash = hash('sha512', $concatString);
                            
                            $response = httpPost($url, $content, $hash, $merchantId);
                            //print_r($response);

                            $response = substr($response, 7, -1);
                            $response = json_decode($response, true);

                            //print_r($response);

                            if (isset($response))
                            {
                                $statuscode = $response['statuscode'];
                                if($statuscode == '025')
                                {
                                    $rrr = trim($response['RRR']);

                                    $stmt = $mysqli->prepare("SELECT * FROM remitapayments_app WHERE RetrievalReferenceNumber = ?");
                                    $stmt->bind_param("s", $rrr);
                                    $stmt->execute();
                                    $stmt->store_result();
                                    $app_rrr_exist = $stmt->num_rows;

                                    $stmt = $mysqli->prepare("SELECT * FROM remitapayments WHERE RetrievalReferenceNumber = ?");
                                    $stmt->bind_param("s", $rrr);
                                    $stmt->execute();
                                    $stmt->store_result();
                                    $reg_rrr_exist = $stmt->num_rows;

                                    $stmt = $mysqli->prepare("SELECT * FROM s_tranxion_cr WHERE RetrievalReferenceNumber = ?");
                                    $stmt->bind_param("s", $rrr);
                                    $stmt->execute();
                                    $stmt->store_result();
                                    $r_rrr_exist = $stmt->num_rows;				
                                }
                            }

                            $lp_cnt++;
                            if ($lp_cnt > 5)
                            {                                
                                if ($reg_rrr_exist <> 0 || $app_rrr_exist <> 0 || $r_rrr_exist <> 0)
                                {
                                    $rrr = '';
                                    unset($response);
                                }
                                break;
                            }
                        }

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

                                $stmt1 = $mysqli->prepare("INSERT IGNORE INTO remitapayments 
                                SET Regno = ?,
                                payerName = '$vLastName $vFirstName $vOtherName',
                                vLastName = '$vLastName',
                                vFirstName = '$vFirstName',
                                vOtherName = '$vOtherName',
                                payerEmail = '$payerEmail',
                                cEduCtgId = '$cEduCtgId',
                                Amount = ?, 
                                payerPhone = '$payerPhone',
                                MerchantReference = '$orderId',
                                RetrievalReferenceNumber = '$rrr',
                                AcademicSession = '$session',
                                tSemester = $tSemester, 
                                vDesc = ?,
                                TransactionDate = NOW(),
                                Status = 'Pending'");
                                $stmt1->bind_param("sds", $_REQUEST['vMatricNo'], $_REQUEST['amount'], $_REQUEST['vDesc']);
                                $stmt1->execute();
                                //$stmt1->close();
                                
                                log_actv('Initiated payment for '.$_REQUEST['vDesc']);
                                
                                if ($split_body <> '')
                                {
                                    $stmt1 = $mysqli->prepare("INSERT IGNORE INTO split_rec SET 
                                    vMatricNo = ?, 
                                    vLastName = '$vLastName', 
                                    vFirstName = '$vFirstName', 
                                    vOtherName = '$vOtherName',
                                    rrr = '$rrr',
                                    orderid  = '$orderId', 
                                    amount = 2000,
                                    split_date = NOW(),
                                    Acadsession = '".$orgsetins["cAcademicDesc"]."',
                                    tsemster = $tSemester_loc");
                                    $stmt1->bind_param("s",$_REQUEST['vMatricNo']);
                                    $stmt1->execute();

                                    $stmt1 = $mysqli->prepare("INSERT IGNORE split_rec SET 
                                    vMatricNo = ?, 
                                    vLastName = '$vLastName', 
                                    vFirstName = '$vFirstName', 
                                    vOtherName = '$vOtherName',
                                    rrr = '$rrr',
                                    orderid  = '$orderId', 
                                    amount = 1000,
                                    split_date = NOW(),
                                    Acadsession = '".$orgsetins["cAcademicDesc"]."',
                                    tsemster = $tSemester_loc");
                                    $stmt1->bind_param("s",$_REQUEST['vMatricNo']);
                                    $stmt1->execute();
                                }
                                $stmt1->close();
                            }
                        }
                    }
                    
                    if ($rrr <> '')
                    {
                        $stmt1 = $mysqli->prepare("INSERT IGNORE INTO remitapayments_log 
                        SET Regno = ?,
                        payerName = '$vLastName $vFirstName $vOtherName',
                        vLastName = '$vLastName',
                        vFirstName = '$vFirstName',
                        vOtherName = '$vOtherName',
                        payerEmail = '$vEMailId',
                        cEduCtgId = '$cEduCtgId',
                        Amount = ?, 
                        payerPhone = '$vMobileNo',
                        MerchantReference = '$orderId',
                        RetrievalReferenceNumber = '$rrr',
                        AcademicSession = '$session',
                        tSemester = $tSemester, 
                        vDesc = 'Wallet Funding',
                        TransactionDate = NOW(),
                        Status = 'Pending'");
                        $stmt1->bind_param("sd", $_REQUEST['vMatricNo'], $_REQUEST['amount']);
                        $stmt1->execute();
                    }
                }else if (isset($_REQUEST["request_id"]) && $_REQUEST["request_id"] == '')
                {
                    $orderId = '';
                }?>                
                
                <form action="<?php echo $url;?>" id="remita_form" name="remita_form" method="POST" onsubmit="in_progress('1');">
                    <input id="merchantId" name="merchantId" value="<?php echo MERCHANTID; ?>" type="hidden"/>
                    <input id="serviceTypeId" name="serviceTypeId" value="<?php echo SERVICETYPEID; ?>" type="hidden"/>
                    <input id="amount" name="amount" value="<?php if (isset($amount)){echo $amount;} ?>" type="hidden"/>
                    <input id="responseurl" name="responseurl" value="<?php echo $responseurl; ?>" type="hidden"/>

                    <input name="rrr" value="<?php echo $rrr?>" type="hidden">
                    <input id="hash" name="hash" value="<?php if (isset($hash)){echo $hash;} ?>" type="hidden"/>
                    <input id="payerName" name="payerName" value="<?php if (isset($payerName)){echo $payerName;} ?>" type="hidden"/>
                    <input id="paymenttype" name="paymenttype" value="<?php if (isset($vDesc)){echo $vDesc;}?>" type="hidden"/>
                    <input id="payerEmail" name="payerEmail" value="<?php if (isset($payerEmail)){echo $payerEmail;} ?>" type="hidden"/>

                    <input id="payerPhone" name="payerPhone" value="<?php if (isset($payerPhone)){echo $payerPhone;} ?>" type="hidden"/>
                    <input id="orderId" name="orderId" value="<?php echo $orderId; ?>" type="hidden"/>
                    <input id="vDesc" name="vDesc" value="<?php if (isset($vDesc)){echo $vDesc;}?>" type="hidden"/>
                    
                    <input name="department" id="department" type="hidden" value="<?php if (isset($cdeptId_loc)){echo $cdeptId_loc;} ?>" />
                    <input name="pgrID" id="pgrID" type="hidden" value="<?php if (isset($cProgrammeId_loc)){echo $cProgrammeId_loc;} ?>" />
                    <input name="cEduCtgId_text" id="cEduCtgId_text" type="hidden" value="<?php if (isset($vEduCtgDesc_loc)){echo $vEduCtgDesc_loc;} ?>" />
                    
                    <input name="locality" id="locality" type="hidden" value="<?php if (isset($cResidenceCountryId_loc)){echo $cResidenceCountryId_loc;} ?>" />
                </form>
                
                <div class="appl_left_child_div" style="width:98%; margin:auto; max-height:95%; margin-top:10px; overflow:auto;  background-color:#eff5f0">
                    <form method="post" name="ps" enctype="multipart/form-data" onsubmit="return chk_inputs();">
                        <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
                        <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"]) && $_REQUEST["ilin"] <> ''){echo $_REQUEST["ilin"];}?>" />
                        <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
                        
                        <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
                        <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />
                        
                        <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId']) && $_REQUEST['cEduCtgId'] <> ''){echo $_REQUEST['cEduCtgId'];}else{echo $cEduCtgId;}?>" />
                        
                        <input name="tSemester_gpin1" id="tSemester_gpin1" type="hidden" value="<?php if (isset($_REQUEST['tSemester_gpin1']) && $_REQUEST['tSemester_gpin1'] <> ''){echo $_REQUEST['tSemester_gpin1'];}else{echo $tSemester;}?>" />
                        
                        <input name="request_id" id="request_id" type="hidden" value="<?php if (isset($_REQUEST["request_id"]) && $_REQUEST["request_id"] <> ''){echo '2';}else{echo '1';}?>" />
                        
                        <input name="department" id="department" type="hidden" value="<?php if (isset($cdeptId_loc)){echo $cdeptId_loc;} ?>" />
                        <input name="pgrID" id="pgrID" type="hidden" value="<?php if (isset($cProgrammeId_loc)){echo $cProgrammeId_loc;} ?>" />
                        
                        <input name="cEduCtgId_text" id="cEduCtgId_text" type="hidden" value="<?php if (isset($vEduCtgDesc_loc)){echo $vEduCtgDesc_loc;} ?>" />

                        <div class="appl_left_child_div_child" style="margin-bottom:10px;">
                            <div style="flex:5%; height:48px; background-color: #eff5f0"></div>
                            <div style="flex:95%; padding-left:4px; height:48px; background-color: #eff5f0; font-weight:bold">
                                Make payment
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid">
                            <input name="vLastName" id="vLastName" type="hidden" value="<?php if (isset($_REQUEST['vLastName']) && $_REQUEST['vLastName'] <> ''){echo $_REQUEST['vLastName'];}else{echo $vLastName;}?>" />
                            <input name="vFirstName" id="vFirstName" type="hidden" value="<?php if (isset($_REQUEST['vFirstName']) && $_REQUEST['vFirstName'] <> ''){echo $_REQUEST['vFirstName'];}else{echo $vFirstName;}?>" />
                            <input name="vOtherName" id="vOtherName" type="hidden" value="<?php if (isset($_REQUEST['vOtherName']) && $_REQUEST['vOtherName'] <> ''){echo $_REQUEST['vOtherName'];}else{echo $vOtherName;}?>" />
                            <input name="payerName" id="payerName" type="hidden" value="<?php if (isset($_REQUEST['payerName']) && $_REQUEST['payerName'] <> ''){echo $_REQUEST['payerName'];}else{echo $vLastName.' '.$vFirstName.' '. $vOtherName;}?>" />
                        </div>

                        <input name="payerEmail" id="payerEmail" type="hidden" value="<?php if (isset($_REQUEST['payerEmail']) && $_REQUEST['payerEmail'] <> ''){echo $_REQUEST['payerEmail'];}else{echo $vEMailId;}?>" />
                        <input name="payerPhone" id="payerPhone" type="hidden" value="<?php if (isset($_REQUEST['payerPhone']) && $_REQUEST['payerPhone'] <> ''){echo $_REQUEST['payerPhone'];}else{echo $vMobileNo;}?>" />
                        
                        <?php if (isset($_REQUEST['amount']) && $_REQUEST['amount'] <> '')
                        {?>
                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:30%; padding-left:10px; height:48px; background-color: #ffffff"></div>
                                <div style="flex:70%; padding-left:4px; color:#FF3300; background-color: #ffffff">
                                    Amount cannot be changed at this stage. If you want to change it, go to the previous page by clicking on the back button (top left corner)
                                </div>
                            </div><?php
                        }?>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                1
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff"><?php
                                if ($cResidenceCountryId_loc == 'NG')
                                {
                                    echo 'Amount (NGN)';
                                }else
                                {
                                    echo 'Amount ($)';
                                }?>
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                <input name="amount" id="amount" type="number"
                                onchange="this.value=this.value.trim();" min="500" value="<?php if (isset($_REQUEST['amount']) && $_REQUEST['amount'] <> ''){echo $_REQUEST['amount'];}else if (isset($amount)){echo $amount;} ?>" required <?php if (isset($_REQUEST['amount']) && $_REQUEST['amount'] <> ''){echo ' readonly';} ?>/>
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                2
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                Description
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                Wallet Funding
                                <input name="vDesc" id="vDesc" type="hidden" value="Wallet Funding" />
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                3
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                Status
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff"><?php
                                $stmt = $mysqli->prepare("SELECT Status FROM remitapayments WHERE MerchantReference = ?");
                                $stmt->bind_param("s", $_REQUEST['orderId']);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($Status);
                                $stmt->fetch();
                                //$stmt->close();

                                $Status = $Status ?? 'Pending';
                                if ($Status <> 'Success')
                                {
                                    echo '<font style="color:#FF3300">'.$Status.'</font>';
                                }else
                                {
                                    echo '<font style="color:#22ac25">'.$Status.'</font>';
                                };?>
                            </div>
                        </div><?php
                        if (isset($_REQUEST["request_id"]) && $_REQUEST["request_id"] <> '')
                        {?>

                            <div  class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                    4
                                </div>
                                <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                    Order ID
                                </div>
                                <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                    <?php echo $orderId;?>
                                    <input name="orderId" id="orderId" type="hidden" value="<?php if (isset($_REQUEST['orderId']) && $_REQUEST['orderId'] <> ''){echo $_REQUEST['orderId'];}else{echo $orderId;}?>" />
                                </div>
                            </div>
                            <div  class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                    5
                                </div>
                                <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                    Remita retrieval reference
                                </div>
                                <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff; color:#FF3300">
                                    <?php if (trim($rrr) == 'xxxx' || $rrr == ''){echo 'Unable to generate RRR now. Check your network connection or try again  later';}else{echo $rrr;}?>
                                    <input name="rrr" id="rrr" type="hidden" value="<?php echo $rrr;?>" />
                                </div>
                            </div><?php
                        }
                         
                        if($Status == 'Pending' && isset($rrr) &&  $rrr <> '' &&  $rrr <> 'xxxx')
						{?>
							<div class="appl_left_child_div_child" style="margin-top:5px; color:#FF3300; background-color: #FFFFFF">
								<div style="flex:5%; height:auto;"></div>
								<div style="flex:95%; padding-left:4px; height:auto;">
                                    When you click the Next button below, you will be taken to remita site.<br> 
                                    At the appropriate time, you will receive a one-time-password (OTP) on your phone from Remita.<br> 
                                    After you enter the OTP and the transaction is successful, 
                                    <b>WAIT to be returned to your section of the NOUN portal</b> before you do anything on the screen
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
						}
                         
                        if(($Status == 'Pending' && isset($rrr) &&  $rrr <> '' &&  $rrr <> 'xxxx') || (isset($_REQUEST["request_id"]) && $_REQUEST["request_id"] == ''))
						{?>
                            <div style="display:flex; 
                                flex-flow: row;
                                justify-content: flex-end;
                                flex:100%;
                                height:auto; 
                                margin-top:10px;">
                                    <button type="submit" class="login_button">Next</button>  
                            </div><?php
						}?>
                    </form>
                </div>
            </div>

            <div id="menu_bs_scrn" class="appl_far_right_div" style="z-index:2;">
                <?php build_menu_right($balance);?>
            </div>
        </div>
	</body>
</html>