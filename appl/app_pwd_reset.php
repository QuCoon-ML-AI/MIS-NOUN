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
require_once('lib_fn.php');
require_once('lib_fn_2.php');
require_once('const_def.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/apppwdreset.js" />

        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/apppwdreset.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
        include_once("feedback_mesages.php");
        require_once("forms.php");

        if (isset($_REQUEST["token_veri"]) && $_REQUEST["token_veri"] == '1')
        {?>
            <script language="JavaScript" type="text/javascript">
                inform("Success. Set new password");
            </script><?php
        }
       
        $mysqli = link_connect_db();?>

        <form action="applicant_login_page" method="post" name="ps" enctype="multipart/form-data" 
            onsubmit="if (vrePassword.value != vPassword.value)
            {
                caution_inform('Passwords not the same');
                return false;
            }
            return true;">
            <input name="user_cat" type="hidden" value="3" />
            <input name="new_pwd" type="hidden" value="1" />
            <div class="button_container">
                <div style="flex:100%; text-align:center; margin-top:20px; background-color:#FFFFFF;">
                    <img id="logo_pix" src="./img/left_side_logo.png" />
                </div>

                <div style="margin-top:10px; font-size:1.1em; text-align:center;">
                    Set New Password
                </div> 

                <div style="margin-top:10px;">
                    <label for="vApplicationNo">
                        Application form number
                    </label>
                </div>            
                <div>
                    <input type="number" id="vApplicationNo" name="vApplicationNo" placeholder="Your application form number..." readonly 
                        value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];}?>">
                </div>
                
                <div>
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
                    <label for="vPassword">
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
                    <a href="<?php echo base_URL;?>" target="_self" style="text-decoration:none;"> 
                        <div class="login_button" title="Recover paasword">Home
                        </div>
                    </a>
                </div>
            </div>
        </form>
	</body>
</html>