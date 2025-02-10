<?php
require_once('good_entry.php');
// Date in the past

/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once(BASE_FILE_NAME.'lib_fn.php');

require_once('std_lib_fn.php');?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="../appl/img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="../appl/js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>
        
        <link rel="stylesheet" type="text/css" media="all" href="../appl/styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/gpinfour.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_side_menu.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>

        <script language="JavaScript" type="text/javascript">
            function _(el)
            {
                return document.getElementById(el)
            }
        </script>
	</head>
	<body><?php
	    $mysqli = link_connect_db();

        $orgsetins = settns();
        
        require_once("../appl/feedback_mesages.php");
        
        require_once("std_detail_pg1.php");
        require_once (BASE_FILE_NAME.'remita_constants.php');
        
        require_once("forms.php");
        
        require_once("./set_scheduled_dates.php");
                    
        $balance = 0.00;?>        
            
        <div class="appl_container">
            <div class="appl_left_div" style="z-index:2;">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em">Final year clearance<br>Initiate payment for outstanding fee</div>
                
                <div class="menu_bg_scrn">
                    <?php require_once ('std_left_side_menu.php');
                    //build_menu($sidemenu);?>                    
                </div>
            </div>
            
            <div class="appl_right_div">                
                <div class="appl_left_child_div" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php std_top_menu();?>
                </div>
                
                <div class="appl_left_child_div" style="text-align: left; margin-top:0px; margin-bottom:0px;">
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

                $session = $orgsetins['cAcademicDesc'];

                $vLastName = $vLastName_loc;
                $vFirstName = $vFirstName_loc;
                $vOtherName = $vOtherName_loc;
                $payerName = $vLastName_loc.' '.$vFirstName_loc.' '.$vOtherName_loc;
                //$payerName = stripslashes(stripslashes($vLastName_loc)).' '.stripslashes(stripslashes($vFirstName_loc)).' '.stripslashes(stripslashes($vOtherName_loc));

                $payerEmail = $vEMailId_loc;
                $payerPhone = $vMobileNo_loc;

                $vDesc = $_REQUEST['vDesc'];
                $cEduCtgId = $cEduCtgId_loc;
                $tSemester = $tSemester_loc;
                $amount = abs($_REQUEST['amount']);
                
                $rrr = '';

                if (isset($_REQUEST["request_id"]) && $_REQUEST["request_id"] == '1')
                {
                    //try
                    //{
                        //$mysqli->autocommit(FALSE);
                        
                        $orderId = DATE("dmyHis");
                        
                        // $stmt1 = $mysqli->prepare("INSERT IGNORE INTO remitapayments 
                        // SET Regno = ?,
                        // payerName = '$vLastName $vFirstName $vOtherName',
                        // vLastName = '$vLastName',
                        // vFirstName = '$vFirstName',
                        // vOtherName = '$vOtherName',
                        // payerEmail = '$vEMailId_loc',
                        // cEduCtgId = '$cEduCtgId',
                        // Amount = ?, 
                        // payerPhone = '$vMobileNo_loc',
                        // MerchantReference = '$orderId',
                        // AcademicSession = '$session',
                        // tSemester = $tSemester, 
                        // vDesc = 'Outstanding amount at graduation',
                        // TransactionDate = NOW(),
                        // Status = 'Pending'");
                        // $stmt1->bind_param("sd", $_REQUEST['vMatricNo'], $amount);
                        // $stmt1->execute();
                        // $stmt1->close();
                        
                        // log_actv('Initiated payment for '.$_REQUEST['vDesc']);

                    //     $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
                    // }catch(Exception $e)
                    // {
                    //     $mysqli->rollback(); //remove all queries from queue if error (undo)
                    //     throw $e;
                    // }

                    
                    $response = '';
                    $response_code = '';

                    $response_message = '';

                    $stmt = $mysqli->prepare("SELECT RetrievalReferenceNumber, ResponseCode FROM remitapayments WHERE MerchantReference = ?");
                    $stmt->bind_param("s", $orderId);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($rrr, $response_code_01);
                    $stmt->fetch();
                    $stmt->close();

                    /*if ($orderId <> '' && $response_code_01 <> '01' && $response_code_01 <> '00')
                    {
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
                    }*/

                    $hash = '';
                    
                    if ($rrr == '' || $rrr == 'xxxx')
                    {             
                        $url = GATEWAYURL;
                        
                        $split_body = '';

                        $app_rrr_exist = -1;
                        $reg_rrr_exist = -1;
                        $r_rrr_exist = -1;

                        $lp_cnt = 0;

                        while ($reg_rrr_exist <> 0 || $app_rrr_exist <> 0 || $r_rrr_exist <> 0)
                        {
                            if ($app_rrr_exist <> -1)
                            {
                                $orderId = DATE("dmyHis");
                            }

                            $content = "{\"serviceTypeId\": \"$serviceTypeID\",
                            \"amount\": \"$amount\",
                            \"orderId\": \"$orderId\",
                            \"payerName\": \"$payerName\",
                            \"payerEmail\": \"$payerEmail\",
                            \"payerPhone\": \"$payerPhone\",
                            \"description\": \"$vDesc\"}";
                        
                            $concatString = MERCHANTID.SERVICETYPEID.$orderId.$amount.APIKEY;
                            $hash = hash('sha512', $concatString);	
                            
                            $url = GATEWAYURL;
                            
                            $response = httpPost($url, $content, $hash, $merchantId);
            
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

                                // $stmt1 = $mysqli->prepare("UPDATE remitapayments 
                                // SET RetrievalReferenceNumber = '$rrr'
                                // WHERE Regno = ?
                                // AND MerchantReference = ?");
                                // $stmt1->bind_param("ss", $_REQUEST['vMatricNo'], $orderId);
                                // $stmt1->execute();

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
                                $stmt1->bind_param("sds", $_REQUEST['vMatricNo'], $amount, $_REQUEST['vDesc']);
                                $stmt1->execute();
                            }
                        }
                    }/*else if ($orderId <> '' || ($rrr <> '' && $rrr <> 'xxxx'))
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

                        $stmt1 = $mysqli->prepare("UPDATE remitapayments 
                        SET RetrievalReferenceNumber = '$rrr',
                        ResponseDescription = '$response_message',
                        ResponseCode = '$response_code'
                        WHERE MerchantReference = ?");
                        $stmt1->bind_param("s", $orderId);
                        $stmt1->execute();
                        $stmt1->close();
                    }*/

                    if ($rrr <> '')
                    {
                        $stmt1 = $mysqli->prepare("INSERT IGNORE INTO remitapayments_log 
                        SET Regno = ?,
                        payerName = '$vLastName $vFirstName $vOtherName',
                        vLastName = '$vLastName',
                        vFirstName = '$vFirstName',
                        vOtherName = '$vOtherName',
                        payerEmail = '$vEMailId_loc',
                        cEduCtgId = '$cEduCtgId',
                        Amount = ?, 
                        payerPhone = '$vMobileNo_loc',
                        MerchantReference = '$orderId',
                        RetrievalReferenceNumber = '$rrr',
                        AcademicSession = '$session',
                        tSemester = $tSemester, 
                        vDesc = 'Outstanding amount at graduation',
                        TransactionDate = NOW(),
                        Status = 'Pending'");
                        $stmt1->bind_param("sd", $_REQUEST['vMatricNo'], $amount);
                        $stmt1->execute();
                        $stmt1->close();
                    }
                }

                $vbank_id = '';
                $acn_name = '';
                $acn_no = '';

                if (isset($_REQUEST['vMatricNo']))
                {
                    $stmt = $mysqli->prepare("SELECT bank_id, acn_name, acn_no FROM s_bank_d WHERE vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST['vMatricNo']);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($vbank_id, $acn_name, $acn_no);
                    $stmt->fetch();
                    $stmt->close();
                }?>

                
                
                <form action="<?php echo $url;?>" id="remita_form" name="remita_form" method="POST" onsubmit="in_progress('1');">
                    <input id="merchantId" name="merchantId" value="<?php echo MERCHANTID; ?>" type="hidden"/>
                    <input id="serviceTypeId" name="serviceTypeId" value="<?php echo SERVICETYPEID; ?>" type="hidden"/>
                    <input id="amount" name="amount" value="<?php echo $amount; ?>" type="hidden"/>
                    <input id="responseurl" name="responseurl" value="<?php echo $responseurl; ?>" type="hidden"/>

                    <input name="rrr" value="<?php echo $rrr?>" type="hidden">
                    <input id="hash" name="hash" value="<?php echo $hash; ?>" type="hidden"/>
                    <input id="payerName" name="payerName" value="<?php echo $payerName; ?>" type="hidden"/>
                    <input id="paymenttype" name="paymenttype" value="<?php echo $vDesc;?>" type="hidden"/>
                    <input id="payerEmail" name="payerEmail" value="<?php echo $payerEmail; ?>" type="hidden"/>

                    <input id="payerPhone" name="payerPhone" value="<?php echo $payerPhone; ?>" type="hidden"/>
                    <input id="orderId" name="orderId" value="<?php echo $orderId; ?>" type="hidden"/>
                    <input id="vDesc" name="vDesc" value="<?php echo $vDesc;?>" type="hidden"/>
                    
                    <input name="locality" id="locality" type="hidden" value="<?php if (isset($cResidenceCountryId_loc)){echo $cResidenceCountryId_loc;} ?>" />
                </form>

                <div class="appl_left_child_div" style="width:98%; margin:auto; max-height:95%; margin-top:10px; overflow:auto; background-color:#eff5f0">
                    <form action="" method="post" name="chk_p_sta" id="chk_p_sta" enctype="multipart/form-data" onsubmit="in_progress('1');">
                        <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
                        <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"]) && $_REQUEST["ilin"] <> ''){echo $_REQUEST["ilin"];}?>" />
                        <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
                        
                        <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
                        <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />

                        <input id="vDesc" name="vDesc" value="<?php if (isset($_REQUEST["vDesc"]) && $_REQUEST["vDesc"] <> ''){echo $_REQUEST["vDesc"];}?>" type="hidden"/>

                        <input id="amount" name="amount" value="<?php if (isset($_REQUEST["amount"]) && $_REQUEST["amount"] <> ''){echo $_REQUEST["amount"];}?>" type="hidden"/>
                        
                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                1
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                Name
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                <?php if (isset($_REQUEST['payerName']) && $_REQUEST['payerName'] <> '')
                                {
                                    echo $_REQUEST['payerName'];
                                }else
                                {
                                    echo $vLastName.' '.$vFirstName.' '. $vOtherName;
                                }?>
                            </div>
                        </div>
                       
                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                2
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                Personal eMail address
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                <?php echo $payerEmail;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                3
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                Personal phone number
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                <?php echo $payerPhone;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                4
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
                                <?php echo number_format($amount, 2, '.', ',');?>
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                5
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                Description
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                <?php echo $vDesc;?>
                            </div>
                        </div>
                            

                        <div  class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                6
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                Transaction order number
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                <?php echo $orderId;?>
                            </div>
                        </div>
                            

                        <div  class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                7
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                Remita retrieval reference
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff; color:#FF3300">
                                <?php if ($rrr == '' || $rrr == 'xxxx')
                                {
                                    echo'Unable to generate RRR. Please try again later';
                                }else
                                {
                                    echo $rrr;
                                }?>
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                8
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
                                $stmt->close();

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
                         
                         if($Status == 'Pending' && isset($rrr) &&  $rrr <> '' && $rrr <> 'xxxx')
                         {?>
                             <div class="appl_left_child_div_child" style="margin-top:5px; color:#FF3300; background-color: #FFFFFF">
                                 <div style="flex:5%; height:auto;"></div>
                                 <div style="flex:95%; padding-left:4px; height:auto;">
                                     When you click the Proceed button below, you will be taken to remita site.<br> 
                                     At the appropriate time, you will receive a one-time-password (OTP) on your phone from Remita.<br> 
                                     After you enter the OTP and the transaction is successful, 
                                     <b>WAIT to be returned to your section of the NOUN portal</b> before you do anything on the screen
                                 </div>
                             </div>
							
                            <div class="appl_left_child_div_child" style="padding-top:15px; color:#FF3300; background-color: #FFFFFF">
								<div style="flex:5%; height:auto;">.</div>
								<div style="flex:95%; padding-left:4px; height:auto;">
								    <input name="conf_prog" id="conf_prog" 
                                    type="checkbox" />
                                    <label for="conf_prog" style="color: #FF3300">I have read the instructions above</label>
								</div>
							</div>
                            
                            <div id="btn_div" style="display:flex; 
                                flex:100%;
                                height:auto; 
                                margin-top:10px;">
                                    <button type="button" class="login_button" onclick="if(!_('conf_prog').checked)
                                    {
                                        caution_inform('Please check the appropriate box to confirm that you have read the instructions in red');
                                        return false;
                                    }
                                    in_progress('1'); remita_form.submit();">Proceed</button>
                            </div><?php
                         }?>

                        </div>
                    </form>
                </div>
                <div id="menu_bs_scrn">
                   <?php build_menu_right($balance);?>
                </div>
            </div>
        </div>
	</body>
</html>