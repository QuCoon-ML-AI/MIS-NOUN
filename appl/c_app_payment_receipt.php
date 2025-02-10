<?php

// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('lib_fn.php');

require_once 'remita_constants.php';
require_once('const_def.php');

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
$orderId = '';
$Status = '';
$dat = '';

$searc_id = '';
if (isset($_REQUEST["orderId"]) && $_REQUEST["orderId"] <> '')
{
    $searc_id = $_REQUEST["orderId"];
}else if (isset($_REQUEST["rrr"]) && $_REQUEST["rrr"] <> '')
{
    $searc_id = $_REQUEST["rrr"];
}

$stmt = $mysqli->prepare("SELECT Regno, Amount, vDesc, vLastName, vFirstName, vOtherName, payerEmail, payerPhone, AcademicSession, cEduCtgId, MerchantReference,RetrievalReferenceNumber, Status, TransactionDate 
FROM remitapayments_app 
WHERE Regno = ?
AND (RetrievalReferenceNumber = ? OR MerchantReference = ?)");
$stmt->bind_param("sss", $_REQUEST["vApplicationNo"],  $searc_id, $searc_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($Regno_db, $Amount_db, $vDesc_db, $vLastName_db, $vFirstName_db, $vOtherName_db, $payerEmail_db, $payerPhone_db, $AcademicSession_db, $cEduCtgId_1st, $orderId, $rrr, $Status, $dat);
$local_record_of_payment = $stmt->num_rows;
$stmt->fetch();
$stmt->close();?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/capppaymentreceipt.js" />

        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/capppaymentreceipt.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>        
	
        <script language="JavaScript" type="text/javascript">
            function _(el){return document.getElementById(el)}
        </script>
	</head>
	<body><?php
		require_once("feedback_mesages.php");?><?php
        //nclude("feedback_mesages.php");
        //include("forms.php");?>
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
           
            <?php left_conttent('Payment receipt for application for admission');?>
            
            <div class="appl_right_div" style="font-size:1em;">
                <?php //appl_top_menu_home();?>

                <div class="appl_left_child_div" style="width:99%; height:auto; text-align:left; margin:auto; margin-top:5px; background-color: #eff5f0;">
					<img src="<?php echo get_pp_pix('');?>" width="140px" height="140px" style="position:absolute; top:15px; right:15px" /><?php
                    if ($local_record_of_payment == 0)
                    {?>
                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:auto; background-color: #ffffff"></div>
                            <div style="flex:95%; padding-left:4px; height:auto; background-color: #ffffff; color:#FF3300;">
                                No match found<br>
                                There are three possible reasons for this condition:<br>
                                1. The RRR is not correct<br>
                                2. The payment was initiated on remita site instead of this site<br>
                                3. The payment with the entered RRR was not made on the application number that was used to login
                            </div>
                        </div><?php
                    }?>

                    <div class="appl_left_child_div_child">
                        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                            1
                        </div>
                        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                            Application form number
                        </div>
                        <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                            <?php echo $Regno_db;?>
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
                        <?php echo  $vLastName_db.' '.$vFirstName_db.' '.$vOtherName_db;?>
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
                    </div>

                    <div class="appl_left_child_div_child">
                        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                            4
                        </div>
                        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                            Personal phone number
                        </div>
                        <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                            <?php echo $payerPhone_db;?>
                        </div>
                    </div>

                    <div class="appl_left_child_div_child">
                        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                            5
                        </div>
                        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                            Remita retrieval reference
                        </div>
                        <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                            <?php echo $rrr;?>
                        </div>
                    </div>

                    <div class="appl_left_child_div_child">
                        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                            6
                        </div>
                        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                            Transaction order number
                        </div>
                        <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                            <?php echo $orderId;?>
                        </div>
                    </div>

                    <div class="appl_left_child_div_child">
                        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                            7
                        </div>
                        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                            Date
                        </div>
                        <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                            <?php echo $dat;?>
                        </div>
                    </div>

                    <div class="appl_left_child_div_child">
                        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                            8
                        </div>
                        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                            Description
                        </div>
                        <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                            <?php echo $vDesc_db;?>
                        </div>
                    </div>

                    <div class="appl_left_child_div_child">
                        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                            9
                        </div>
                        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                            Amount
                        </div>
                        <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                            <?php if (is_numeric($Amount_db)){echo number_format($Amount_db, 2);}?>
                        </div>
                    </div>

                    <div class="appl_left_child_div_child">
                        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                            9
                        </div>
                        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                        Status
                        </div>
                        <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                            <?php echo $Status;?>
                        </div>
                </div>

                    <div class="appl_left_child_div_child" style="margin-top:10px;">
                        <div style="flex:5%; height:90px; background-color: #eff5f0"></div>
                        <div style="flex:95%; padding-left:4px; height:120px; background-color: #eff5f0">
                            <img class="remita_logo"src="img/remitahorizon.png"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</body>
</html>