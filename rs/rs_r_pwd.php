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
		<script language="JavaScript" type="text/javascript" src="./bamboo/rs_r_pwd.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>
        
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE_FILE_NAME;?>styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_r_pwd.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
        require_once(BASE_FILE_NAME."feedback_mesages.php");
        require_once(BASE_FILE_NAME."forms.php");
        $mysqli = link_connect_db();?>

        <form method="post" name="ps" enctype="multipart/form-data">
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];} ?>" />
            <input name="token_request" type="hidden" value="0" />
            <input name="rec_pwd" type="hidden" value="1" />
            
            <input name="token_veri" type="hidden" value="0" />
            <div class="button_container">
                <div style="flex:100%; text-align:center; margin-top:20px; background-color:#FFFFFF;">
                    <img id="logo_pix" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" />
                </div>

                <div style="margin-top:10px; font-size:1.3em; text-align:center;">
                    Reset Password
                </div> 

                <div style="margin-top:10px;">
                    <label for="vMatricNo">
                        Matriculation number
                    </label>
                </div>            
                <div>
                    <input type="text" id="vMatricNo" name="vMatricNo" readonly
                        value="<?php if(isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>">
                </div>
                
                <div>
                </div>

                <?php //send_token('password recovery');?>

                <div style="margin-top:10px; padding:10px 0px 10px 10px; background-color: #fbe1b0; line-height:1.7;">
                    <label for="user_token"><?php
                        if (isset($_REQUEST["token_request"]) && $_REQUEST["token_request"] == '1')
                        {
                            send_token('password recovery');
                            echo 'A fresh token has been sent to your email address';
                        }else
                        {
                            echo 'Token sent to your NOUN student email address. It expires in 20mins. Enter token below. If you have not activated your student email address, contact the ICT unit at your centre for resolution';
                        }?>
                    </label>
                </div>
                <div>
                    <input type="text" id="user_token" name="user_token"
					autocomplete="off" 
                    maxlength="7" 
                    placeholder="Enter token here..." required>
                </div>
                
                <div style="text-align:center">
                    <a href="#" target="_self" style="text-decoration:none;"> 
                        <div class="login_button" title="Resend token" 
                        onclick="chk_inputs();">Submit
                        </div>
                    </a>
                </div>
                
                <div style="text-align:center; margin-top:20px;">
                    <button type="submit" class="login_button" onclick="ps.token_request.value='1';ps.submit()">Resend token</button>
                </div>
                
                <div style="text-align:center; margin-top:20px;">
                    <a href="#" target="_self" style="text-decoration:none;"> 
                        <div class="rec_pwd_button" title="Back to previous page" 
                        onclick="ps.action='student_login_page';
                            ps.rec_pwd.value='';
                            ps.submit();">Back
                        </div>
                    </a>
                </div>
                
                <div style="text-align:center; margin-top:10px;">
                    <a href="../" target="_self" style="text-decoration:none;"> 
                        <div class="login_button">Home
                        </div>
                    </a>
                </div>
            </div>
        </form>
	</body>
</html>