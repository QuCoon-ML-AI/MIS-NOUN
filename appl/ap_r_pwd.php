<?php
include_once('good_entry.php');

// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
include_once('const_def.php');
require_once('lib_fn.php');
require_once('lib_fn_2.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/aprpwd.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/aprpwd.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
        require_once("feedback_mesages.php");
        require_once("forms.php");
        $mysqli = link_connect_db();?>

        <form method="post" name="ps" enctype="multipart/form-data">
            <input name="user_cat" type="hidden" value="3" />
            <input name="token_request" type="hidden" value="0" />
            
            <input name="token_veri" type="hidden" value="0" />
            <div class="button_container">
                <div style="flex:100%; text-align:center; margin-top:20px; background-color:#FFFFFF;">
                    <img id="logo_pix" src="./img/left_side_logo.png" />
                </div>

                <div style="margin-top:10px; font-size:1.3em; text-align:center;">
                    Reset Password
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

                <?php //send_token('password recovery');?>

                <div style="margin-top:10px; padding:10px 0px 10px 10px; background-color: #fbe1b0">
                    <label for="user_token"><?php
                        if (isset($_REQUEST["token_request"]) && $_REQUEST["token_request"] == '1')
                        {
                            send_token('password recovery');
                            echo 'A fresh token has been sent to your email address';
                        }else
                        {
                            echo 'A token has been sent to your email address. Enter token below';
                        }?>
                    </label>
                </div>
                <div>
                    <input type="text" id="user_token" name="user_token" placeholder="Enter token here..." required>
                </div>
                
                <div style="text-align:center">
                    <a href="#" target="_self" style="text-decoration:none;"> 
                        <div class="login_button"
                        onclick="chk_inputs()">Submit
                        </div>
                    </a>
                </div>
                
                <div style="text-align:center; margin-top:20px;">
                    <button type="submit" class="login_button" onclick="ps.token_request.value='1';ps.submit()">Resend token</button>
                </div>
                
                <div style="text-align:center; margin-top:20px;">
                    <a href="#" target="_self" style="text-decoration:none;"> 
                        <div class="rec_pwd_button" title="Back to previous page" 
                        onclick="ps.action='applicant_login_page';
                            ps.user_cat.value='3';
                            ps.submit();">Back
                        </div>
                    </a>
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