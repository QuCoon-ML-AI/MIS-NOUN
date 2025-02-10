<?php
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
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
		<script language="JavaScript" type="text/javascript" src="./bamboo/npw.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/npw.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
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
            <?php left_conttent('Set a new password');?> 
            
            <div class="appl_right_div" style="font-size:1em;">
                <form action="applicant_login_page" method="post" id="loc_ps" name="loc_ps" enctype="multipart/form-data" onsubmit="chk_inputs(); return false">
                    <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
                    <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                    <input name="new_pwd" type="hidden" value="1" />
                
                    <?php //appl_top_menu_home();?>

                    <div class="appl_left_child_div" style="text-align: left; margin:auto; overflow:auto; background-color: #eff5f0;">
                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; text-indent:5px; height:50px; background-color: #ffffff">
                                1
                            </div>
                            <div style="flex:15%; padding-left:5px; height:50px; background-color: #ffffff">
                                Application form number
                            </div>
                            <div style="flex:80%; height:50px; padding-left:5px; background-color: #ffffff">
                                 <b><?php if (isset($_REQUEST["vApplicationNo"])){echo substr($_REQUEST["vApplicationNo"],0,8);}?></b>
                                 <input name="pwd_case" type="hidden" value="<?php if (isset($_REQUEST["pwd_case"])){echo $_REQUEST["pwd_case"];}?>"/>
                            </div>
                        </div>
                        
                        <div class="appl_left_child_div_child" style="margin-top:25px;">
                            <div style="flex:5%; padding-left:4px; height:30px; background-color: #ffffff"></div>
                            <div style="flex:95%; padding-left:4px; height:30px; background-color: #ffffff">
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
                                    <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;">Show Password</div>
                                </label>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                2
                            </div>
                            <div style="flex:15%; padding-left:4px; height:50px; background-color: #ffffff">
                                <label for="vPassword">Password</label>
                            </div>
                            <div style="flex:80%; height:50px; background-color: #ffffff">
                                <input type="password" id="vPassword" name="vPassword"  placeholder="Your password..." required>
                            </div>
                        </div>
                        
                        <div class="appl_left_child_div_child">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                3
                            </div>
                            <div style="flex:15%;  padding-left:4px; height:50px; background-color: #ffffff">
                                <label for="vrePassword">Confirm password</label>
                            </div>
                            <div style="flex:80%; height:50px; background-color: #ffffff">
                                <input type="password" id="vrePassword" name="vrePassword"  placeholder="Confirm password..." required>
                            </div>
                        </div>
                        

                        <div style="display:flex; 
                            flex-flow: row;
                            justify-content: flex-end;
                            flex:100%;
                            height:auto; 
                            margin-top:10px;">
                                <button type="submit" class="login_button">Submit</button>  
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</body>
</html>