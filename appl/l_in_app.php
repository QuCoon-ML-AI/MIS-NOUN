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
		<script language="JavaScript" type="text/javascript" src="./bamboo/linapp.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/linapp.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
        require_once("feedback_mesages.php");
        
        $mysqli = link_connect_db();

        if (isset($_REQUEST["new_pwd"]) && $_REQUEST["new_pwd"] == '1')
        {
            if (strlen($_REQUEST['vApplicationNo']) > 9)
            {
                exit;
            }
            
            
            $stmt = $mysqli->prepare("SELECT cSbmtd FROM prog_choice 
            WHERE vApplicationNo = ?");
            $stmt->bind_param("s", $_REQUEST['vApplicationNo']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($cSbmtd);
            $stmt->fetch();

            if (is_null($cSbmtd))
            {
                $cSbmtd == '0';
            }
            
            if ($cSbmtd == '0' || $cSbmtd == '1')
            {
                $stmt = $mysqli->prepare("REPLACE INTO app_client SET
                vPassword = md5(?), 
                cpwd = '0',
                vApplicationNo = ?");
                $stmt->bind_param("ss", $_REQUEST['vPassword'], $_REQUEST['vApplicationNo']);
                $stmt->execute();
                $stmt->close();?>
                <script language="JavaScript" type="text/javascript">
                    inform('Success. Login to continue');
                </script><?php 
            }else
            {?>
                <script language="JavaScript" type="text/javascript">
                    caution_inform('Form not available');
                </script><?php 
            }           
        }
        
        if (isset($_REQUEST["logout"]) && $_REQUEST["logout"] == '1')
        {
            clean_up();   
        }?>

        <form action="" method="post" name="ps" enctype="multipart/form-data" onsubmit="chk_inputs(); return false">
			<input name="ilin" type="hidden" value="" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
            <input name="recover_pwd" type="hidden" value="" />
            <div class="button_container">
                <div style="flex:100%; text-align:center; margin-top:10px; background-color:#FFFFFF;">
                    <img id="logo_pix" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" />
                </div>
                
                <div style="margin-top:10px; font-size:1.1em; text-align:center;">
                    Applicant Login Page
                </div>

                <div style="margin-top:10px;">
                    <label for="vApplicationNo">
                        Application form number
                    </label>
                </div>            
                <div>
                    <input type="number" id="vApplicationNo" name="vApplicationNo" 
                    placeholder="Your application form number..."
                    onkeypress="if(this.value.length==9){return false}" 
                    onchange="this.value=this.value.replace(/ /g, '');
                    if (this.value.trim() != '' && ps.vPassword.value.trim() != '')
                    {
                        do_capt()
                    }"
					autocomplete="off"
                    required>
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
                        do_capt()
                    }" required>
                </div><?php
                $show = 'none';
                if ((isset($_REQUEST["logout"]) && $_REQUEST["logout"] == '1') || (isset($_REQUEST["new_pwd"]) && $_REQUEST["new_pwd"] == '1'))
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
                    maxlength="7" 
                    required>
                </div>
                <!-- <script src="cap2.js"></script> -->
                
                <div style="text-align:center">
                    <button type="submit" class="login_button">Login</button>
                </div>
                
                <div style="text-align:center; margin-top:10px;">
                    <a href="#" target="_self" style="text-decoration:none;"> 
                        <div class="rec_pwd_button" title="Reset paasword"
                        onclick="ps.recover_pwd.value=1;
                        chk_inputs();">Reset paasword
                        </div>
                    </a>
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