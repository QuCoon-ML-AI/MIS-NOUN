<?php
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('../appl/lib_fn.php');
require_once('../appl/lib_fn_2.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
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
                    if (vrePassword.value != vPassword.value)
                    {
                        caution_inform("Passwords not the same");
                        return false;
                    }
                    new_pwd.value = '1';
                }
                
                return true;
            }
        </script>
	</head>
	<body><?php
        require_once("../appl/feedback_mesages.php");
        require_once("../appl/forms.php");
       
        $mysqli = link_connect_db();

        if (isset($_REQUEST["token_veri"]) && $_REQUEST["token_veri"] == '1')
        {
            $stmt = $mysqli->prepare("delete FROM veri_token
        	WHERE vApplicationNo = ?
        	AND purpose = 'password recovery'");
        	$stmt->bind_param("s",$_REQUEST["vApplicationNo"]);
        	$stmt->execute();?>
        	
            <script language="JavaScript" type="text/javascript">
                inform("Success. Set new password");
            </script><?php
        }?>

        <form action="staff_login_page" method="post" name="ps" enctype="multipart/form-data" onsubmit="return chk_inputs();">
            <input name="user_cat" type="hidden" value="6" />
            <input name="new_pwd" type="hidden" value="0" />
            <div class="button_container">
                <div style="flex:100%; text-align:center; margin-top:20px; background-color:#FFFFFF;">
                    <img id="logo_pix" src="./img/left_side_logo.png" />
                </div>

                <div style="margin-top:10px; font-size:1.1em; text-align:center;">
                    Set New Password
                </div> 

                <div style="margin-top:10px;">
                    <label for="vApplicationNo">
                        User name
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
                    <a href="#" onclick="ps.action='<?php echo BASE_FILE_NAME;?>';ps.submit();return false" target="_self" style="text-decoration:none;"> 
                        <div class="login_button" title="Recover paasword">Home
                        </div>
                    </a>
                </div>
            </div>
        </form>
	</body>
</html>