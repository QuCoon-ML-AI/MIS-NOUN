<?php
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('../../PHPMailer/mail_con.php');
require_once('lib_fn.php');?>
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
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/payment.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>	
        <script language="JavaScript" type="text/javascript">
            // function _(el)
            // {
            //     return document.getElementById(el)
            // }
        </script>
	</head>
	<body>

        <form method="post" name="ps" enctype="multipart/form-data">
            <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
            <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
            <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else if (isset($GLOBALS['cEduCtgId'])){echo $GLOBALS['cEduCtgId'];}?>" />
            <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
        </form><?php
        require_once("feedback_mesages.php");
        require_once("forms.php");
        
	    $mysqli = link_connect_db();
        $orgsetins = settns();		
	
        $sidemenu = '';
        if (isset($_REQUEST["sidemenu"]) && $_REQUEST["sidemenu"] <> '')
        {
            $sidemenu = $_REQUEST["sidemenu"];
        }?>
        <div class="appl_container">
            <?php require_once("opr_pay.php");
            left_conttent('Pay for application form');?>
                        
            <div class="appl_right_div" style="font-size:1em;">
                <form action="confirm-pay-detail" method="post" name="pay" id="pay" enctype="multipart/form-data" onsubmit="in_progress('1')">
                    <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
                    <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
                    <input name="save" id="save" type="hidden" value="-1" />
                    <input name="rrr_sys" type="hidden" value="1" />
                    
                    <input name="p_status" id="p_status" type="hidden" value="Pending"/>
				    <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>" />
				    <input name="department" id="department" type="hidden" value="<?php if (isset($_REQUEST['department'])){echo $_REQUEST['department'];}?>" />
                    <input name="pgrID" id="pgrID" type="hidden" value="<?php if (isset($_REQUEST['pgrID'])){echo $_REQUEST['pgrID'];}?>"/>

                    <input name="payerName" id="payerName" type="hidden" value="<?php if (isset($_REQUEST['payerName'])){echo $_REQUEST['payerName'];}?>" />
				
                    <input name="vLastName" id="vLastName" type="hidden" value="<?php if (isset($_REQUEST['vLastName'])){echo $_REQUEST['vLastName'];}?>" />
                    <input name="vFirstName" id="vFirstName" type="hidden" value="<?php if (isset($_REQUEST['vFirstName'])){echo $_REQUEST['vFirstName'];};?>" />
                    <input name="vOtherName" id="vOtherName" type="hidden" value="<?php if (isset($_REQUEST['vOtherName'])){echo $_REQUEST['vOtherName'];};?>" />
                    
                    <input name="payerEmail" id="payerEmail" type="hidden" value="<?php if (isset($_REQUEST['payerEmail'])){echo $_REQUEST['payerEmail'];}?>" />
                    <input name="payerPhone" id="payerPhone" type="hidden" value="<?php if (isset($_REQUEST['payerPhone'])){echo $_REQUEST['payerPhone'];}?>" />
                    <input name="amount" id="amount" type="hidden" value="<?php if (isset($_REQUEST['amount'])){echo $_REQUEST['amount'];}?>" />

                    <input name="dBirthDate" id="dBirthDate" type="hidden" value="<?php if (isset($_REQUEST['dBirthDate'])){echo $_REQUEST['dBirthDate'];}?>" />
                    
                    
                    <input name="vDesc" id="vDesc" type="hidden" value="<?php if (isset($_REQUEST['vDesc'])){echo $_REQUEST['vDesc'];}?>" />
                    <input name="jambno" id="jambno" type="hidden" value="<?php if (isset($_REQUEST['jambno'])){echo $_REQUEST['jambno'];}?>" />
                    
                    <?php $orderId = DATE("dmyHis");?>
                    <input name="orderId" id="orderId" type="hidden" value="<?php echo $orderId;?>" />

                    <input name="cEduCtgId_text" id="cEduCtgId_text" type="hidden" value="<?php if (isset($_REQUEST["cEduCtgId_text"])){echo $_REQUEST["cEduCtgId_text"];} ?>"/>
                
                    <?php appl_top_menu_home();?>

                    <div class="appl_left_child_div" style="text-align: left; margin:auto; margin-top:5px; background-color: #eff5f0;">
                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                1
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                Name
                            </div>
                            <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                                <?php if (isset($_REQUEST['payerName'])){echo $_REQUEST['payerName'];}?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                2
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                Personal eMail address
                            </div>
                            <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                                <?php if (isset($_REQUEST['payerEmail'])){echo $_REQUEST['payerEmail'];}?>
                            </div>
                            </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                3
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                Personal phone number
                            </div>
                            <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                                <?php if (isset($_REQUEST['payerPhone'])){echo $_REQUEST['payerPhone'];}?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child" style="margin-bottom:10px;">
                            <div style="flex:5%; height:50px; background-color: #eff5f0"></div>
                            <div style="flex:95%; padding-left:4px; height:50px; background-color: #eff5f0">
                                Pieces of information above <b>must</b> be those of the candidate otherwise, click on Home (above) and begin afresh
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                4
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff"><?php
                                if (isset($_REQUEST["resident_ctry"]) && $_REQUEST["resident_ctry"] == '0')
                                {
                                    echo 'Amount ($)';
                                }else
                                {
                                    echo 'Amount (NGN)';
                                }?>
                            </div>
                            <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                                <?php if (isset($_REQUEST['amount']) && $_REQUEST['amount'] <> ''){echo number_format($_REQUEST['amount'], 2, '.', ',');}?>
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                5
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                Description
                            </div>
                            <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff">
                                <?php if (isset($_REQUEST['vDesc']))
                                {
                                    echo $_REQUEST['vDesc'].' '.$_REQUEST['cEduCtgId_text'];
                                }
                                
                                $p = false;
                                if (isset($_REQUEST["cEduCtgId_text"]))
                                {
                                    $p = strpos($_REQUEST['cEduCtgId_text'], 'Master');
                                }

                                if (isset($_REQUEST['amount']) && $_REQUEST['amount'] == '20000' && $p !== false)
                                {
                                    echo ' (CEMBA/CEMPA)';
                                }?>
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                6
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                Status
                            </div>
                            <div style="flex:70%; padding-left:4px; height:50px; background-color: #ffffff"><?php
                                $stmt = $mysqli->prepare("SELECT Status FROM remitapayments WHERE payerName = ? AND payerEmail = ? AND payerPhone = ? AND Amount = ? AND Regno = ''");
                                $stmt->bind_param("sssd", $_REQUEST['payerName'], $_REQUEST['payerEmail'], $_REQUEST['payerPhone'], $_REQUEST['amount']);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($Status);
                                
                                if ($stmt->num_rows === 0)
                                {
                                    $p_status = 'Pending';
                                }else
                                {
                                    $stmt->fetch();
                                    $p_status = $Status;
                                }
                                $stmt->close();?>
                                <?php echo $p_status;?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child" style="margin-top:10px;">
                            <div style="flex:5%; height:50px; background-color: #eff5f0"></div>
                            <div style="flex:95%; padding-left:4px; height:50px; background-color: #eff5f0">
                                If above details are correct, click the Next button otherwise, click Home (above) and to begin again
                            </div>
                        </div>

                        <!-- <div class="appl_left_child_div_child" style="margin-top:10px;">
                            <div style="flex:5%; height:90px; background-color: #eff5f0"></div>
                            <div style="flex:95%; padding-left:4px; height:120px; background-color: #eff5f0">
                                <img class="remita_logo"src="img/remitahorizon.png"/>
                            </div>
                        </div> -->
                    </div>

                    <div class="appl_left_child_div" style="text-align: left; margin:auto; margin-top:15px;">
                        <div style="display:flex; 
                            flex-flow: row;
                            justify-content: flex-end;
                            flex:100%;
                            height:auto; 
                            margin-top:10px;">
                                <button type="submit" class="login_button">Next</button>  
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</body>
</html>