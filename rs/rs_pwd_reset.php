<?php if (!isset($_REQUEST['user_cat']) )
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
require_once(BASE_FILE_NAME.'lib_fn.php');
require_once(BASE_FILE_NAME.'lib_fn_2.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" />
		<script language="JavaScript" type="text/javascript" src="<?php echo BASE_FILE_NAME;?>js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/pwd_reset.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>        
        
        <script language="JavaScript" type="text/javascript">
            function completeHandler(event)
            {
                on_error('0');
                on_abort('0');
                in_progress('0');
                var returnedStr = event.target.responseText;
                returnedStr = returnedStr.trim();
            
                if (returnedStr == 1)
                {
                    in_progress("1");
                    ps.action = 'student_login_page';
                    ps.submit();
                    return false;
                }else if (returnedStr == 'Already signed up')
                {
                    caution_inform(returnedStr+". Click 'Home' button and then click 'Registered student' to login")
                }else
                {
                    caution_inform("Invalid matriculation number")
                }
            }
        </script>

        <link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE_FILE_NAME;?>styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/pwd_reset.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
        require_once(BASE_FILE_NAME."feedback_mesages.php");
        require_once(BASE_FILE_NAME."forms.php");

        if (isset($_REQUEST["token_veri"]) && $_REQUEST["token_veri"] == '1')
        {?>
            <script language="JavaScript" type="text/javascript">
                inform("Success. Set new password");
            </script><?php
        }
       
        $mysqli = link_connect_db();?>

        <form method="post" name="ps" enctype="multipart/form-data" onsubmit="chk_mtn(); return false">
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
            <input name="new_pwd" type="hidden" value="0" />
            <input name="rec_pwd" type="hidden" value="<?php if (isset($_REQUEST["rec_pwd"]) && $_REQUEST["rec_pwd"] <> ''){echo $_REQUEST["rec_pwd"];}?>" />
            <div class="button_container">
                <div style="flex:100%; text-align:center; margin-top:20px; background-color:#FFFFFF;">
                    <img id="logo_pix" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" />
                </div>

                <div style="margin-top:10px; font-size:1.1em; text-align:center; line-height:1.6;"><?php
                    if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] == '4')
                    {
                        echo 'Fresh student<br>Set new password';
                        $input_state = '';
                    }else
                    {
                        echo "Reset Password";
                        $input_state = 'readonly';
                    }?>
                </div> 

                <div style="margin-top:10px;">
                    <label for="vMatricNo">
                        Matriculation (Registration) number
                    </label>
                </div>            
                <div>
                    <input type="text" id="vMatricNo" name="vMatricNo" 
                        placeholder="Example: NOU123456789"
                        autocomplete="off"
                        maxlength="25" <?php echo $input_state;?> required 
                        value="<?php if (isset($_REQUEST['vMatricNo'])){echo $_REQUEST['vMatricNo'];}?>">
                </div>
                
                <div>
                    <label class="chkbox_container">
                        <input type="checkbox"
                        onclick="if (this.checked)
                        {
                            _('vPassword').type = 'text';
                            _('vrePassword').type = 'text';
                        }else
                        {
                            _('vPassword').type = 'password';
                            _('vrePassword').type = 'password';
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
                    <input type="password" id="vPassword" name="vPassword" placeholder="Your new password..." required>
                </div>

                <div style="margin-top:10px;">
                    <label for="vrePassword">
                        Confirm password
                    </label>
                </div>
                <div>
                    <input type="password" id="vrePassword" name="vrePassword" placeholder="Enter password again..." required>
                </div>
                
                <div style="text-align:center">
                    <button type="submit" class="login_button">Submit</button>
                </div>
                
                <div style="text-align:center; margin-top:10px;">
                    <a href="../" target="_self" style="text-decoration:none;"> 
                        <div class="login_button" title="Recover paasword">Home
                        </div>
                    </a>
                </div>
            </div>
        </form>
	</body>
</html>