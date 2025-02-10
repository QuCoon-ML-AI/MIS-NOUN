<?php
if (!isset($_REQUEST['user_cat']))
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

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once(APPL_BASE_FILE_NAME.'lib_fn.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="<?php echo APPL_BASE_FILE_NAME;?>js_file_1.js"></script>
		<!-- <script language="JavaScript" type="text/javascript" src="./bamboo/l_in_staff.js"></script> -->

        <script language="JavaScript" type="text/javascript">
            function preventBack(){window.history.forward();}
            setTimeout("preventBack()", 0);
            //window.onunload=function(){null};    

            function _(el)
            {
                return document.getElementById(el)
            }

            function chk_inputs()
            {
                var numbers = /^[0-9]+$/;

                with(ps)
                {
                    if (!vApplicationNo.value.match(numbers))
                    {
                        caution_inform("Invalid 'User name (Staff ID)'")
                        return false;
                    }

                    if (vApplicationNo.value == '')
                    {
                        caution_inform("Enter your user name")
                        return false;
                    }
                    
                    var formdata = new FormData();

                    formdata.append("vApplicationNo", vApplicationNo.value);
                    formdata.append("vPassword", vPassword.value);
                    formdata.append("user_cat", user_cat.value);
                    formdata.append("cap_text", cap_text.value);
                    if (recover_pwd.value == 1)
                    {
                        formdata.append("recover_pwd", recover_pwd.value);
                    }

                    //formdata.append("token_sent", token_sent.value);
                }
                opr_prep(ajax = new XMLHttpRequest(),formdata);
            }


            function opr_prep(ajax,formdata)
            {
                ajax.upload.addEventListener("progress", progressHandler, false);
                ajax.addEventListener("load", completeHandler, false);
                ajax.addEventListener("error", errorHandler, false);
                ajax.addEventListener("abort", abortHandler, false);
                
                ajax.open("POST", "opr_staff_l_ins.php");
                ajax.send(formdata);
            }
                
                    
            function completeHandler(event)
            {
                on_error('0');
                on_abort('0');
                in_progress('0');
                var returnedStr = event.target.responseText;
                returnedStr = returnedStr.trim();

                with(ps)
                {
                    if (returnedStr == 'can continue')
                    {
                        in_progress('1');
                        action = './staff_recover_password';
                        submit();
                        return false;
                    }else if (returnedStr.indexOf("session created") > -1)
                    {
                        in_progress('1');
                        ilin.value = returnedStr.substr(15);
                        action = './staff_home_page';
                        submit();
                        return false;
                    }else if (returnedStr.trim() == '')
                    {
                        caution_inform('We could not reach your official email address. Contact MIS for resolution')
                    }/*else if (returnedStr == '1')
                    {
                        token_sent.value = '1';
                    }*/else
                    {
                        caution_inform(returnedStr)
                    }
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

        <link rel="stylesheet" type="text/css" media="all" href="<?php echo APPL_BASE_FILE_NAME;?>styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/styless0.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>  
	</head>
	<body><?php
        require_once(APPL_BASE_FILE_NAME."feedback_mesages.php");
       
        $mysqli = link_connect_db();

        if (isset($_REQUEST["new_pwd"]) && $_REQUEST["new_pwd"] == '1')
        {
            /*$stmt = $mysqli->prepare("REPLACE INTO userlogin SET
			vPassword = md5(?), 
			cpwd = '0',
			vApplicationNo = ?");*/
			
			$stmt = $mysqli->prepare("UPDATE userlogin SET
			vPassword = md5(?), 
			cpwd = '0'
			WHERE vApplicationNo = ?");
			$stmt->bind_param("ss", $_REQUEST['vPassword'], $_REQUEST['vApplicationNo']);
			$stmt->execute();
			$stmt->close();
            
            log_actv('Set new password');?>

            <script language="JavaScript" type="text/javascript">
                inform("Success. Login to continue")
            </script><?php
        }

        if (isset($_REQUEST["logout"]) && $_REQUEST["logout"] == '1')
        {
            clean_up();
        }?>

        <form method="post" name="ps" enctype="multipart/form-data" onsubmit="chk_inputs(); return false">
			<input name="ilin" type="hidden" value="" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
            <input name="recover_pwd" type="hidden" value="" />
            
            <input name="comonboard" type="hidden" value="" />
            <input name="just_coming" type="hidden" value="1" />
            <!-- <input name="token_sent" id="token_sent" type="hidden" value="0" />
            <input name="token_supplied" id="token_supplied" type="hidden" value="0" /> -->

            <div class="button_container">
                <div style="flex:100%; text-align:center; margin-top:20px; background-color:#FFFFFF;">
                    <img id="logo_pix" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" />
                </div>
                
                <div style="margin-top:10px; font-size:1.1em; text-align:center;">
                    Staff Login Page
                </div>

                <div style="margin-top:10px;">
                    <label for="vApplicationNo">
                        User name (Staff ID)
                    </label>
                </div>            
                <div>
                    <input type="number" id="vApplicationNo" name="vApplicationNo" 
                        placeholder="Enter your user name here..."
                        onkeypress="if(this.value.length==5){return false}"
                        onchange="if (this.value.trim() != '')
                        {
                            this.value = pad(this.value, 5, 0);
                        }
                        
                        if (this.value.trim() != '' && ps.vPassword.value.trim() != '')
                        {
                            do_capt();
                        }" required 
                        value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];}?>"
                        autocomplete="off">
                </div>
                
                <div>
                    <label class="chkbox_container">
                        <input type="checkbox"
                        onclick="if (this.checked)
                        {
                            _('vPassword').type = 'text';
                        }else
                        {
                            _('vPassword').type = 'password';
                        }">
                        <span class="checkmark box_checkmark"></span><div style="line-height:1.8;">Show Password</div>
                    </label>
                </div>

                <div style="margin-top:10px;">
                    <label for="vPassword">
                        Password
                    </label>
                </div>
                <div>
                    <input type="password" id="vPassword" name="vPassword" placeholder="Your password..."
                        onchange="if (this.value.trim() != '' && ps.vApplicationNo.value.trim() != '')
                        {
                            do_capt();
                        }" required>
                </div><?php
                $show = 'none';
                if (isset($_REQUEST["logout"]) && $_REQUEST["logout"] == '1')
                {
                    $show = 'flex';
                }?>

                <div id="cap_mean" style="margin-top:10px; display:<?php echo $show;?>">
                    <label for="cap_text" title="Completely Automated Public Turing test to tell Computers and Humans Apart">
                        Captcha
                    </label>
                </div>
                
                <div id="cap_caller" style="margin-top:0px; display:<?php echo $show;?>">
                    <img id="refresh_img" src="data:image/png;base64,<?php echo c_image('./img/refresh.png');?>" 
                        title="Refresh code" 
                        width="35px" 
                        height="35px" 
                        style="cursor:pointer; margin-top:4px;"
                        onclick="if (ps.vApplicationNo.value.trim() != '')
                        {
                            do_capt()
                        }"/>
                    <canvas id="valicode" style="height:35px; width:50%"></canvas>
                    <input name="hidden_cap_text" id="hidden_cap_text" type="hidden"/>
                </div>

                <div id="cap_resp" style="display:<?php echo $show;?>">
                    <input type="text" id="cap_text" name="cap_text" 
                    placeholder="Enter the above captcha text here"
					autocomplete="off" 
                    maxlength="7" 
                    required>
                </div>
                <!-- <script src="<?php //echo APPL_BASE_FILE_NAME;?>cap2.js"></script> -->

                <div style="text-align:center">
                    <button type="submit" class="login_button">Login</button>
                </div>
                
                <div style="text-align:center; margin-top:10px;">
                    <a href="#" target="_self" style="text-decoration:none;"> 
                        <div class="rec_pwd_button" title="Recover/reset paasword" 
                        onclick="ps.recover_pwd.value=1;
                        chk_inputs();">Reset password
                        </div>
                    </a>
                </div>
                
                <div style="text-align:center; margin-top:10px;">
                    <a href="#" target="_self" style="text-decoration:none;" onclick="ps.comonboard.value=1;ps.action='come-onboard';ps.submit();return false"> 
                        <div class="login_button">Sign-up
                        </div>
                    </a>
                </div><div style="text-align:center; margin-top:10px;">
                    <a href="#" target="_self" style="text-decoration:none;" onclick="ps.action='<?php echo BASE_FILE_NAME;?>';ps.submit();return false"> 
                        <div class="login_button">Home
                        </div>
                    </a>
                </div>
            </div>
        </form>
	</body>
</html>