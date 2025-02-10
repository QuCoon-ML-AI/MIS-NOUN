<?php

if (!isset($_REQUEST['payerName']))
{?>
    <div style="font-family:Verdana, Arial, Helvetica, sans-serif; 
    margin:auto; 
    text-align:center;
	font-size: 0.78em;"> Follow <a href="../" style="text-decoration:none;">here</a></div><?php
    exit;
}
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('const_def.php');
require_once('../../PHPMailer/mail_con.php');
require_once('../../fsher/fisher.php');
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
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/nap.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>

        <script language="JavaScript" type="text/javascript">	
            // function preventBack(){window.history.forward();}
            // setTimeout("preventBack()", 0);
            // window.onunload=function(){null};
            
            
            function _(el){return document.getElementById(el)}
        </script>
	</head>
	<body><?php
        require_once("feedback_mesages.php");
        require_once("forms.php");
        
	    $mysqli = link_connect_db();		
	
        $sidemenu = '';
        if (isset($_REQUEST["sidemenu"]) && $_REQUEST["sidemenu"] <> '')
        {
            $sidemenu = $_REQUEST["sidemenu"];
        }?>
        <div class="appl_container">
            <?php if (isset($_REQUEST["payerName"]))
            {
                left_conttent('Fresh applicant<br>'.$_REQUEST["payerName"].'<br>you are welcome');
            }?> 
            
            <div class="appl_right_div" style="font-size:1em;">
                <form action="new-loggin-parameters" method="post" id="nxt" name="nxt" enctype="multipart/form-data">
                    <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
                    <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                    
                    <input name="save" type="hidden" />                    
                    <input name="payerName" id="payerName" type="hidden" value="<?php if (isset($_REQUEST['payerName'])){echo $_REQUEST['payerName'];}?>" />			
                    <input name="payerEmail" id="payerEmail" type="hidden" value="<?php if (isset($_REQUEST['payerEmail'])){echo $_REQUEST['payerEmail'];}?>" />
                    <input name="payerPhone" id="payerPhone" type="hidden" value="<?php if (isset($_REQUEST['payerPhone'])){echo $_REQUEST['payerPhone'];};?>" />
                                
                    <?php //appl_top_menu_home();?>

                    <div class="appl_left_child_div" style="text-align: left; margin:auto; margin-top:25px; height:100%; background-color: #ffffff;">
                        <div style="flex:100%; height:100%; text-align:center; font-size:1.1em; background-color: #ffffff">
                            <img id="logo_pix" src="data:image/jpg;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" height="150px"/><p>
                            
                            <b><font color="#FF5300">Please read carefully</font></b><br><br><br>
                            <hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin-top:12px;" /><br><br><br>
                            The application form number
                            <p></p><font color="#FF5300" size="+1"><b><?php echo substr($_REQUEST["vApplicationNo"],0,8); ?></b></font>
                            <p>has been allocated to you.</p>
                            <p>Please <font color="#FF5300">copy</font> it for future reference</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <font color="#FF5300">You will need to set a password for yourself on the next screen</font><br><br><br><br><?php

                            if (!isset($_REQUEST["save"]))
                            {
                                $subject = 'NOUN - Application form number';
                                $mail_msg = 'Dear '.$_REQUEST['payerName'].',<p>
                                The application form number<p>'.
                                $_REQUEST["vApplicationNo"].'</b><p>
                                has been allocated to you<p>
                                You may use available support channels or visit the nearest Study centre for assistance.<p>
                                Thank you.';

                                $mail_msg = wordwrap($mail_msg, 70);

                                $mail->addAddress($_REQUEST['payerEmail'], $_REQUEST['payerName']); // Add a recipient
                                $mail->Subject = $subject;
                                $mail->Body = $mail_msg;
                                
                                for ($incr = 1; $incr <= 5; $incr++)
                                {
                                    if ($mail->send())
                                    {
                                        log_actv('Notification of allocation of application form number sent to '.$_REQUEST['payerEmail']);
                                        break;
                                    }
                                }?>

                                Have you read the information above?
                                <button type="submit" class="login_button" style="width:50px; height:auto; padding:5px;" 
                                    onclick="nap.save.value=1;
                                    nap.submit();
                                    return false">Yes</button><br><br><br><br><?php 
                            }else
                            {?>
                                Please click the continue button to proceed<br><br><br><br><?php 
                            }?>
                        </div><?php
                        if (isset($_REQUEST['save']))
				        {?>
                            <div style="flex-flow: row;
                                justify-content: flex-end;
                                flex:100%;
                                height:auto; 
                                margin-top:10px;
                                text-align:right;">
                                    <button type="submit" class="login_button">Continue</button>
                            </div><?php
                        }?>
                    </div>
                </form>
            </div>
        </div>
	</body>
</html>