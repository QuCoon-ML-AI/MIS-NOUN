<?php
require_once('good_entry.php');
// Date in the past
/*
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once(BASE_FILE_NAME.'lib_fn.php');

require_once('std_lib_fn.php');
	
require_once ('../appl/remita_constants.php');

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

$mysqli = link_connect_db();

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

$stmt = $mysqli->prepare("SELECT Regno, Amount, vDesc, vLastName, vFirstName, vOtherName, payerEmail, payerPhone, AcademicSession, cEduCtgId, tSemester, Status, RetrievalReferenceNumber, MerchantReference, TransactionDate
FROM remitapayments 
WHERE $search_field = ?");
$stmt->bind_param("s", $pay_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($Regno_db, $Amount_db, $vDesc_db, $vLastName_db, $vFirstName_db, $vOtherName_db, $payerEmail_db, $payerPhone_db, $AcademicSession_db, $cEduCtgId_1st, $tSemester, $msg, $rrr, $orderId, $dat);
$stmt->fetch();
$stmt->close();

if (is_null($vLastName_db))
{
    $vLastName_db = '';
}
if (is_null($vFirstName_db))
{
    $vFirstName_db = '';
}
if (is_null($vOtherName_db))
{
    $vOtherName_db = '';
}


$stmt = $mysqli->prepare("SELECT siLevel, cAcademicDesc
FROM s_tranxion_cr 
WHERE RetrievalReferenceNumber = '$rrr'");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($iStudy_level, $session);
$stmt->fetch();
$stmt->close();?>
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
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/see_pay_evi.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_side_menu.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
        require_once("../appl/feedback_mesages.php");

		if ($response_code == '01')
		{?>
			<script language="JavaScript" type="text/javascript">
                inform("Success");
            </script><?php
		}?><?php

		$stmt = $mysqli->prepare("SELECT ilin
		FROM ses_tab
		WHERE vApplicationNo = ?");
		$stmt->bind_param("s", $regno);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($ilin);
		$passpotLoaded = $stmt->num_rows;
		$stmt->fetch();
		$stmt->close();
		
        require_once("./forms.php");?>
        
        <div class="appl_container">
			<div id="background" class="center"
					style="z-index:2; 
					display:block;
					height:auto; 
					width:auto;
					text-align:center">
					<p id="bg-text" 
						style="color:#ff9797;
						font-size:160px;
						transform:rotate(-45deg);
						-webkit-transform:rotate(-45deg);
						opacity:0.3"><?php echo $vDesc_db;?></p>
				</div>
            <?php left_conttent_for_receipt('Payment receipt','');?>
            
            <div class="appl_right_div" style="font-size:1em;">
                <div class="appl_left_child_div" style="text-align: left; margin:auto; max-height:95%; width:98%; margin-top:5px; background-color: #eff5f0;">
                    <div class="appl_left_child_div_child">
                        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                            1
                        </div>
                        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                            Matriculation form number
                        </div>
                        <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                            <?php echo $regno;?>
                        </div>
                    </div>
                    
                    <div class="appl_left_child_div_child">
                        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                            2
                        </div>
                        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                            Name
                        </div>
                        <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                        <?php echo strtoupper($vLastName_db).', '.ucwords(strtolower($vFirstName_db)).' '.ucwords(strtolower($vOtherName_db));?>
                        </div>
                    </div>

                    <div class="appl_left_child_div_child">
                        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                            3
                        </div>
                        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                            Personal eMail address
                        </div>
                        <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                            <?php echo $payerEmail_db;?>
                        </div>
                    </div><?php
    
                    if($rrr <> '')
                    {?>
                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                4
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                Remita retrieval reference (RRR)
                            </div>
                            <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                                <?php echo $rrr;?>
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                5
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                Transaction Reference
                            </div>
                            <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                                <?php echo $orderId;?>
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                6
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                Date
                            </div>
                            <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                                <?php echo $dat;?>
                            </div>
                        </div>						

                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                7
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                Description
                            </div>
                            <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff"><?php 
                                if (!is_bool(strpos($vDesc_db, 'Load fund')) || $vDesc_db == "Wallet Funding")
                                {
                                    if ($tSemester == 1)
                                    {
                                        echo $vDesc_db . "  ".$iStudy_level."Level, first semester ".$session." academic session";
                                    }else
                                    {
                                        echo $vDesc_db . "  ".$iStudy_level."Level, second semester ".$session." academic session";
                                    }
                                }else
                                {
                                    echo $vDesc_db;
                                }?>
                            </div>
                        </div>					

                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                8
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                Amount (NGN)
                            </div>
                            <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                                <?php echo number_format($Amount_db, 2);?>
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
                            <div style="flex:5%; height:auto;"></div>
                            <div style="flex:95%; padding-left:4px; height:auto;"><?php
                                echo $feedback_msg;?>
                            </div>
                        </div><?php
                    }?>

                    <div class="appl_left_child_div_child" style="margin-top:10px;">
                        <div style="flex:5%; height:90px; background-color: #eff5f0"></div>
                        <div style="flex:95%; padding-left:4px; height:120px; background-color: #eff5f0">
                            <img class="remita_logo"src="../appl/img/remitahorizon.png"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</body>
</html>