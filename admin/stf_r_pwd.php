<?php
if (!isset($_REQUEST['user_cat']) || !isset($_REQUEST["vApplicationNo"]))
{?>
    <div style="font-family:Verdana, Arial, Helvetica, sans-serif; 
    margin:auto; 
    text-align:center;
	font-size: 0.78em;"> Follow <a href="../" style="text-decoration:none;">here</a></div><?php
    exit;
}

// Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="../appl/js_file_1.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="../appl/styless.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>

        
        <style>
            input[type=number]
            {
                width: 99.8%;
                padding: 2px 0px 6px 0px;
                text-indent:8px;
                height:45px;
                border-radius:5px;
                border:1px solid #b6b6b6
            }

            input[type=text],select
            {
                width: 99.8%;
                padding: 2px 0px 6px 0px;
                text-indent:8px;
                border-radius:5px;
                height:45px;
                border:1px solid #b6b6b6;
                font-size: 13px;
            }

            input[type=password]
            {
                width: 99.8%;
                padding: 2px 0px 6px 0px;
                text-indent:8px;
                border-radius:5px;
                height:45px;
                border:1px solid #b6b6b6
            }

            #logo_pix
            {
                width:158px; 
                height:180;
            }

            #valicode
            {
                width:91.5%;
            }

            @media screen and (max-width: 800px) 
            {
                #logo_pix
                {
                    width:98px; 
                    height:120;
                }

                #valicode
                {
                    width:81.5%;
                }
            }
        </style>

        
	
        <script language="JavaScript" type="text/javascript">            
            function _(el)
            {
                return document.getElementById(el)
            }

            function chk_inputs()
            {
                var formdata = new FormData();
                with (ps)
                {
                    if (user_token.value.trim() == '')
                    {
                        caution_inform("Enter token");
                        return false;
                    }
                    formdata.append("vApplicationNo", vApplicationNo.value);
                    formdata.append("user_token", user_token.value);
                    formdata.append("user_cat", 6);
                }
                opr_prep(ajax = new XMLHttpRequest(),formdata);   
            }
            
        
            function opr_prep(ajax,formdata)
            {
                ajax.upload.addEventListener("progress", progressHandler, false);
                ajax.addEventListener("load", completeHandler, false);
                ajax.addEventListener("error", errorHandler, false);
                ajax.addEventListener("abort", abortHandler, false);
                
                ajax.open("POST", "check_staff_token");
                ajax.send(formdata);
            }
                
            function completeHandler(event)
            {
                on_error('0');
                on_abort('0');
                in_progress('0');
                var returnedStr = event.target.responseText;
                returnedStr = returnedStr.trim();
                
                if (returnedStr == 'Token valid')
                {
                    in_progress("1");
                    ps.action = 'staff_reset_password';
                    ps.token_veri.value='1';
                    ps.submit();
                    //inform(returnedStr)
                    return false;
                }else
                {
                    caution_inform(returnedStr)
                }
            }

            function progressHandler(event)
            {
                in_progress('1');
            }

            function errorHandler(event)
            {
                on_error('1');
            }

            function abortHandler(event)
            {
                on_abort('1');
            }
        </script>
	</head>
	<body><?php
        require_once("../appl/feedback_mesages.php");
        require_once("../appl/forms.php");
       
        $mysqli = link_connect_db();

        if (isset($_REQUEST["new_pwd"]) && $_REQUEST["new_pwd"] == '1')
        {
            log_actv('Set new password');?>

            <script language="JavaScript" type="text/javascript">
                inform("Success. Login to continue")
            </script><?php
        }

        if (isset($_REQUEST["logout"]) && $_REQUEST["logout"] == '1')
        {
            clean_up();   
        }?>

        <form method="post" name="ps" enctype="multipart/form-data">
            <input name="user_cat" type="hidden" value="6" />
            <input name="token_request" type="hidden" value="0" />
            <input name="token_veri" type="hidden" value="0" />
            <div class="button_container">
                <div style="flex:100%; text-align:center; margin-top:20px; background-color:#FFFFFF;">
                    <img id="logo_pix" src="./img/left_side_logo.png" />
                </div>

                <div style="margin-top:10px; font-size:1.1em; text-align:center;">
                    Reset password
                </div>

                <div style="margin-top:10px;">
                    <label for="vApplicationNo">
                        User name
                    </label>
                </div>            
                <div>
                    <input type="number" id="vApplicationNo" name="vApplicationNo" readonly 
                        value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];}?>">
                </div>
                
                <div>
                </div>

                <?php //send_token('password recovery','0');?>

                <div style="margin-top:10px; padding:10px 0px 10px 10px; background-color: #fbe1b0; line-height:1.7">
                    <label for="user_token"><?php
                        if (isset($_REQUEST["token_request"]) && $_REQUEST["token_request"] == '1')
                        {
                            send_token('password recovery','0');
                            echo 'A fresh token has been sent to your official email address';
                        }else
                        {
                            echo 'A token has been sent to your official email address. Enter token below. If your official email address is not active, contact ICT for resolution';
                        }?>
                    </label>
                </div>
                <div>
                    <input type="text" id="user_token" name="user_token"
					autocomplete="off" 
                    maxlength="8" 
                    placeholder="Enter token here..." required>
                </div>
                
                <div style="text-align:center">
                    <a href="#" target="_self" style="text-decoration:none;"> 
                        <div class="login_button" onclick="chk_inputs();">Submit</div>
                    </a>
                </div>
                
                <div style="text-align:center; margin-top:20px;">
                    <button type="submit" class="login_button" onclick="ps.token_request.value='1';ps.submit()">Resend token</button>
                </div>
                
                <div style="text-align:center; margin-top:20px;">
                    <a href="#" target="_self" style="text-decoration:none;"> 
                        <div class="rec_pwd_button" title="Back to previous page" 
                        onclick="ps.action='staff_login_page';
                            ps.user_cat.value='6';
                            ps.submit();">Back
                        </div>
                    </a>
                </div>
                
                <div style="text-align:center; margin-top:10px;">
                    <a href="#" target="_self" style="text-decoration:none;" onclick="ps.action='<?php echo BASE_FILE_NAME;?>';ps.submit();return false"> 
                        <div class="login_button" title="Go to the home page">Home
                        </div>
                    </a>
                </div>
            </div>
        </form>
	</body>
</html>