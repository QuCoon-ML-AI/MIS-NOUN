<?php
require_once('good_entry.php');
// Date in the past
if (!isset($_REQUEST['user_cat']))
{?>
    <div style="font-family:Verdana, Arial, Helvetica, sans-serif; 
    margin:auto; 
    text-align:center;
	font-size: 0.78em;"> Follow <a href="../" style="text-decoration:none;">here</a></div><?php
    exit;
}

/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once(BASE_FILE_NAME.'lib_fn.php');

require_once('std_lib_fn.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="../appl/img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="../appl/js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/rs_cpw.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="../appl/styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_cpw.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_side_menu.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
	    $mysqli = link_connect_db();

        $orgsetins = settns();
        
        require_once("../appl/feedback_mesages.php");
        
        require_once("std_detail_pg1.php");
        require_once("forms.php");
        
        require_once("./set_scheduled_dates.php");
                    
        $balance = 0.00;?>        
            
        <div class="appl_container">
            <div class="appl_left_div" style="z-index:2;">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em">Change password</div>
                
                <div class="for_computer_screen">
                    <?php require_once ('std_left_side_menu.php');
                    //build_menu($sidemenu);?>                    
                </div>
            </div>
            
            <div class="appl_right_div">  
                <div class="appl_left_child_div for_mobile_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php std_top_samll_menu();?>
                </div>

                <div class="appl_left_child_div for_computer_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php std_top_menu();?>
                </div>

                <div class="appl_left_child_div for_mobile_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php require_once ('mobile_menu_bar_content.php');?>
                </div>
                
                <div class="appl_left_child_div for_computer_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php require_once ('menu_bar_content.php');?>
                </div>

                <div id="menu_sm_scrn">
                    <?php build_menu_right();?>
                </div>

                <div class="appl_left_child_div" style="width:98%; margin:auto; max-height:95%; margin-top:10px; overflow:auto; background-color:#eff5f0">
                    <form action="" method="post" name="rs_cpw" id="rs_cpw" enctype="multipart/form-data" onsubmit="chk_inputs_cpw(); return false">
                        <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
                        <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"]) && $_REQUEST["ilin"] <> ''){echo $_REQUEST["ilin"];}?>" />
                        <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
                        
                        <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
                        <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />

                        <input name="token_req" id="token_req" type="hidden" value="0" />
                        
                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                1
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                <label class="chkbox_container" style="margin-top:7px">
                                    <input type="checkbox"
                                    onclick="if (this.checked)
                                    {
                                        _('vfPassword').type = 'text';
                                        _('vPassword').type = 'text';
                                        _('vrePassword').type = 'text';
                                    }else
                                    {
                                        _('vfPassword').type = 'password';
                                        _('vPassword').type = 'password';
                                        _('vrePassword').type = 'password';
                                    }">
                                    <span class="checkmark radio_checkmark"></span><div style="line-height:1.8;">Show Password</div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                2
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                <label for="vfPassword">Old password</label>
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                <input name="vfPassword" id="vfPassword" type="password" required/>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                3
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                <label for="vPassword">New password</label>
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                <input name="vPassword" id="vPassword" type="password" required/>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                4
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                <label for="vPassword">Confirm password</label>
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                <input name="vrePassword" id="vrePassword" type="password" required/>
                            </div>
                        </div>
                        
                        <div id="token_box" style="display: none;">
                            <div class="appl_left_child_div_child calendar_grid" style="margin-top:15px">
                                <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">                                
                                </div>
                                <div style="flex:95%; padding-left:4px; height:48px; background-color: #fdf0bf; line-height:2.3;">
                                    A token has been sent to your student email address. Enter token below. It expires in 10minutes
                                </div>
                            </div>

                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                    5
                                </div>
                                <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                    <label for="pwd_token">Token</label>
                                </div>
                                <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                    <input name="pwd_token" id="pwd_token" type="text"/>
                                </div>
                            </div>

                            <div id="btn_div" style="display:flex; 
                                flex:100%;
                                height:auto;">
                                    <button type="button" class="login_button" onclick="token_req.value='0'; chk_inputs_cpw()">Resend token</button>
                            </div>
                        </div>
                         
                        <div id="btn_div" style="display:flex; 
                            flex:100%;
                            height:auto; 
                            margin-top:20px;">
                                <button type="submit" class="login_button">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="menu_bs_scrn" class="appl_far_right_div" style="z-index:2;">
                <?php build_menu_right($balance);?>
            </div>
        </div>
	</body>
</html>