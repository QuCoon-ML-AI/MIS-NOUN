<?php
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php

//$currency = eyes_pilled('0');
$currency = '1';

$mysqli = link_connect_db();

$service_mode = '';
$num_of_mode = 0;
$service_centre = '';
$num_of_service_centre = 0;

if (isset($_REQUEST['vApplicationNo']))
{
	$centres = do_service_mode_centre("2", $_REQUEST['vApplicationNo']);	
	$service_centre = substr($centres,10);
	$num_of_service_centre = trim(substr($centres,0, 9));
}


$orgsetins = settns();
require_once('set_scheduled_dates.php');?>

<!-- InstanceBeginEditable name="doctitle" -->
<title>NOUN-MIS</title>
<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
<!-- InstanceEndEditable -->




<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
<script language="JavaScript" type="text/javascript" src="button_ops.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />

<!-- <link rel="stylesheet" type="text/css" media="all" href="cap_style.css" /> -->
<script language="JavaScript" type="text/javascript">
	document.onkeydown = function (e) 
	{
		if (e.ctrlKey && e.keyCode === 85) 
		{
            return false;
        }
	}
</script>
<noscript></noscript>

<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript" type="text/javascript">
	// function preventBack(){window.history.forward();}
	// setTimeout("preventBack()", 0);
	// window.onunload=function(){null};

    //check_environ();
		
    function chk_inputs()
	{
		var ulChildNodes = _("rtlft").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}
        
        var letters = /^[A-Za-z ]+$/;
		var numbers_letter = /^[0-9A-Za-z _.@]+$/;

        var files = _("sbtd_pix").files;
        
                

        if (trim(_("staffid").value) == '')
        {
            setMsgBox("labell_msg14","");
            _("staffid").focus();
            return false;
        }else 
        {
            if (_("sbtd_pix").files.length > 0 || _("sbtd_pix").files.length == 0)
            {
                if (_("sbtd_pix").files.length == 0)
                {
                    setMsgBox("labell_msg7","");
                    return false;
                }/*else if (!fileValidation("sbtd_pix"))
                {
                    setMsgBox("labell_msg7","JPEG required");
                    return false;
                }else if (files[0].size > 50100)
                {
                    setMsgBox("labell_msg7","File too large. Max: 50KB");
                    return false;
                }*/
            }

            if (_('vPassword').value == '')
            {
                setMsgBox("labell_msg15","");
                _('vPassword').focus();
                _('staff_logo_box').style.display = 'none';
                return false;
            }
            
            if (_('vrePassword').value == '')
            {
                setMsgBox("labell_msg16","");
                _('vrePassword').focus();
                _('staff_logo_box').style.display = 'none';
                return false;
            }

             if (_('vPassword').value != _('vrePassword').value)
            {
                setMsgBox("labell_msg15","Entry must be the same");
                setMsgBox("labell_msg16","Entry must be the same");
                _('vPassword').focus();
                _('staff_logo_box').style.display = 'none';
                return false;
            }

            if (_('tk_div').style.display == 'block' && tk.value.trim() == '')
            {
                setMsgBox("labell_msg17","");
                _('tk_div').focus();
                return false;
            }

            /*if (_("cap_text").value == '')
            {
                setMsgBox("labell_msg19","");
                _("cap_text").focus();
                return false;
            }
            
            if (_("cap_text").value != _("hidden_cap_text").value)
            {
                setMsgBox("labell_msg19","Wrong");
                _("cap_text").focus();
                return false;
            }*/
            
            _("join").save.value = '1';
            
            var formdata = new FormData();

            formdata.append("save", _("join").save.value);

            l_zeros = 5 - _("staffid").value.length;

            if (l_zeros == 1)
            {
                _("staffid").value = '0'+_("staffid").value;
            }else if (l_zeros == 2)
            {
                _("staffid").value = '00'+_("staffid").value;
            }else if (l_zeros == 3)
            {
                _("staffid").value = '000'+_("staffid").value;
            }else if (l_zeros == 4)
            {
                _("staffid").value = '0000'+_("staffid").value;
            }
            
            formdata.append("staffid", _("staffid").value);
            
            formdata.append("vPassword", _("vPassword").value);   
            formdata.append("user_cat", 6);         
            
            formdata.append("sbtd_pix", _("sbtd_pix").files[0]);

            _('update_frm').value = 0;

            if (_('tk_div').style.display == 'none')
            {
                formdata.append("ask_f_t", 1);
            }else
            {
                formdata.append("use_t", 1);
                formdata.append("user_token", _("tk").value);
            }
           
            opr_prep(ajax = new XMLHttpRequest(),formdata);
        }
	}
	
	
	function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
        ajax.open("POST", "opr_join.php");
        
		ajax.send(formdata);
	}


    function completeHandler(event)
	{
		on_error('0');
        on_abort('0');
        in_progress('0');
        
        var returnedStr = event.target.responseText;

        _('tk_div').style.display = 'none';

        if (returnedStr.indexOf('successfull') != -1)
        {
            _("sub_box").style.display = 'none';
            _("cont_box").style.display = 'block';
            
            success_box(returnedStr);
        }else if (returnedStr.trim() == 'token sent')
        {
            _('tk_div').style.display = 'block';
        }else if (returnedStr.trim() == 'Invalid token')
        {
            _('tk_div').style.display = 'block';
            caution_box(returnedStr);
        }else
        {
            if (returnedStr == '')
            {
                caution_box('Something went wrong. Please contact MIS');
            }else
            {
                caution_box(returnedStr);
            }
        }


        _("join").save.value = '0';
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
</script><?php

require_once ('set_scheduled_dates.php');?>
<!-- InstanceEndEditable -->
</head>
<body onLoad="checkConnection()">
    <?php admin_frms();?>
	
	<!--<form action="home-page" method="post" name="hpg" enctype="multipart/form-data">
		<input name="uvApplicationNo" type="hidden" value="" />
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
		<input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"])){echo $_REQUEST["vMatricNo"];} ?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="logout" type="hidden" value="1" />
	</form>-->
	
	<!-- InstanceBeginEditable name="nakedbody" -->
		<div id="container_cover_constat" style="display:none"></div>
		<div id="container_cover_in_constat" class="center" style="display:none; position:fixed;">
			<div id="div_header_main" class="innercont_stff" 
				style="float:left;
				width:99.5%;
				height:auto;
				padding:0px;
				padding-top:3px;
				padding-bottom:4px;
				border-bottom:1px solid #cccccc;">
				<div id="div_header_constat" class="innercont_stff" style="float:left; color:#FF3300;">
					Internet Connection Status
				</div>
			</div>
			
			<div id="div_message_constat" class="innercont_stff" style="margin-top:40px; float:left; width:413px; height:auto; color:#FF3300;">
				You are not connected
			</div>
		</div>
	<!-- InstanceEndEditable -->
<div id="container"><?php
	time_out_box($currency);?>

	<noscript>
		<div class="smoke_scrn" style="display:block"></div>
		<?php information_box_inline('You need to enable javascript for this browser');?>
	</noscript>
	<?php do_toup_div('Student Management System');?>
	<div id="menubar">
		<!-- InstanceBeginEditable name="menubar" -->
		<!-- InstanceEndEditable -->
	</div>

	<div id="leftSide" style="margin-left:0px;">
	</div>
	<div id="rtlft" style="position:relative;">
		<!-- InstanceBeginEditable name="EditRegion6" -->			
            <div id="general_smke_screen" class="smoke_scrn" style="display:none; z-index:-1"></div>
            
            <div id="in_progress" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
                <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                    Information
                </div>
                <a href="#" style="text-decoration:none;">
                    <div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
                </a>
                <div style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#000000">
                    Processing. Please wait...
                </div>
                <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;"></div>
            </div>

            <div id="on_error" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
                <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                    Information
                </div>
                <a href="#" style="text-decoration:none;">
                    <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                </a>
                <div style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#000000">
                    Your internet connection was interrupted. Please try again
                </div>
                <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;"></div>
            </div>

            <div id="on_abort" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
                <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                    Information
                </div>
                <a href="#" style="text-decoration:none;">
                    <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                </a>
                <div style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#000000">
                    Process aborted
                </div>
                <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;"></div>
            </div>

            <div id="general_success_box" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:3">
                <div style="width:350px; float:left; text-align:left; padding:0px; color:#36743e; font-weight:bold">
                    Information
                </div>
                <a href="#" style="text-decoration:none;">
                    <div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
                </a>
                <div id="general_success_msg_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#36743e;"></div>
                <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
                    <a href="#" style="text-decoration:none;" 
                        onclick="_('general_success_box').style.display= 'none';
                        _('general_success_box').style.zIndex= '-1';
                        _('general_smke_screen').style.display= 'none';
                        _('general_smke_screen').style.zIndex= '-1';
                        return false">
                        <div class="submit_button_home" style="width:60px; padding:6px; float:right">
                            Ok
                        </div>
                    </a>
                </div>
            </div>

            <div id="general_caution_box" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; max-height:70vh; overflow:auto; overflow-x:hidden; z-index:-1">
                <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                    Caution
                </div>
                <a href="#" style="text-decoration:none;">
                    <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                </a>
                <div id="general_caution_msg_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#6b6b6b;"></div>
                <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
                    <a href="#" style="text-decoration:none;" 
                        onclick="_('general_smke_screen').style.display='none';
                        _('general_smke_screen').style.zIndex='-1';
                        _('general_caution_box').style.display='none';
                        _('general_caution_box').style.zIndex='-1';
                        return false">
                        <div class="submit_button_brown" style="width:60px; padding:6px; float:right">
                            Ok
                        </div>
                    </a>
                </div>
            </div>

			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
            <div class="innercont_top">Staff sign up</div>
            
            <form method="post" name="join" id="join" enctype="multipart/form-data">
                <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST['user_cat'];} ?>" />
                <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];} ?>" />
                <input name="recova" id="recova" type="hidden" value="<?php if (isset($_REQUEST['recova'])){echo $_REQUEST['recova'];} ?>" />
                <input name="save" id="save" type="hidden" value="-0" />
                <!-- <input name="tpreg" type="hidden" value="<?php //if (isset($_REQUEST["tpreg"])){echo $_REQUEST["tpreg"];}?>" />
                <input name="currency" id="currency" type="hidden" value="<?php //if ($currency=='1'){echo $currency;} ?>" /> -->
                
                
                <input name="update_frm" id="update_frm" type="hidden" value=""/>
                <input name="whattodo1" id="whattodo1" type="hidden" value=""/>
                
                <?php
                if (isset($_REQUEST["Qsolicited"]))
                {?>
                    <input name="Qsolicited" type="hidden" value="<?php if (isset($_REQUEST["Qsolicited"])){echo $_REQUEST["Qsolicited"];} ?>"/><?php
                }?>
                <select name="cdeptId_readup" id="cdeptId_readup" style="display:none"><?php	
                    $sql = "select cFacultyId, cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where cDelFlag = 'N' order by cFacultyId, cdeptId, vdeptDesc";
                    $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                    while ($rs = mysqli_fetch_array($rssql))
                    {?>
                        <option value="<?php echo $rs['cFacultyId']. $rs['cdeptId']?>"><?php echo $rs['vdeptDesc'];?></option><?php
                    }
                    mysqli_close(link_connect_db());?>
                </select>

                <select name="cprogrammeId_readup" id="cprogrammeId_readup" style="display:none"><?php	
                    $sql = "select s.cdeptId, p.cProgrammeId,p.vProgrammeDesc,o.vObtQualTitle 
                    from programme p, obtainablequal o, depts s, faculty t
                    where p.cObtQualId = o.cObtQualId 
                    and s.cdeptId = p.cdeptId
                    and s.cFacultyId = t.cFacultyId
                    and p.cDelFlag = s.cDelFlag
                    and p.cDelFlag = t.cDelFlag
                    and p.cDelFlag = 'N'
                    order by s.cdeptId, p.cProgrammeId";
                    $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                    while ($rs = mysqli_fetch_array($rssql))
                    {?>
                        <option value="<?php echo $rs['cdeptId']. $rs['cProgrammeId']?>"><?php echo $rs['vObtQualTitle'].' '.$rs['vProgrammeDesc']; ?></option><?php
                    }
                    mysqli_close(link_connect_db());?>
                </select>
                
				
                <div id="staff_logo_box" 
                    style="position:absolute; 
                    top:30px; 
                    right:20px;
                    width:145px; 
                    height:152px;">
                        <img name="staff_logo" id="staff_logo" src="img/p_.png" width="100%" height="100%" style="border-radius:5%"/> 
                </div>

                <div class="innercont_stff" 
                style="height:100%;
                width:100%;
                height: 617px; 
                overflow-x: hidden;">
                    <div id="staffid_div" class="innercont_stff" style="margin-bottom:1%;">
                        <label for="staffid" class="labell" style="width:200px; margin-left:7px;">Staff ID (User name)</label>
                        <div class="div_select">
                            <input name="staffid" id="staffid" 
                            type="number" 
                            class="textbox" 
                            style="text-transform:uppercase;"
                            onkeypress="if(this.value.length==5){return false}"
                            onchange="this.value = pad(this.value, 5, 0);"/>
                        </div>
                        <div id="labell_msg14" class="labell_msg blink_text orange_msg"></div>
                    </div>
                    
                    <div class="innercont_stff" style="margin-top:1.5%">
                        <label for="sbtd_pix" class="labell" style="width:200px; margin-left:7px;">Upload passport picture</label>
                        <div class="div_select">
                            <input type="file" name="sbtd_pix" id="sbtd_pix" style="width:200px; float:left" title="Max size: 50KB, Format: JPG">
                        </div>                            
                        <div id="labell_msg7" class="labell_msg blink_text orange_msg"></div>
                    </div>

                    <div class="innercont_stff" style="margin-bottom:1.5%; width:60%; height:auto;">
                        <div class="succ_box blue_msg" style="text-align:left; width:100%; display:block">
                            Please ensure the picture :
                            <ol>
                                <li>is of a passport size</li>
                                <li>has a white or red backgorund</li>
                                <li>is not more than 3 months old</li>
                                <li>captures the top of your head, both ears and just below you chin</li>
                                <li>is sharp, clear and bright enough to recognize you</li>
                            </ol>
                        </div>
                    </div>
                            
                    <div class="innercont_stff">
                        <label for="sho_pwd" class="labell" style="width:200px; margin-left:7px;">Show password</label>
                        <div class="div_select" style="height:auto;">
                            <input name="sho_pwd" id="sho_pwd" type="checkbox" style="margin-top:4px; margin-left:0px" 
                                onclick="if (_('vPassword').type === 'password')
                                {
                                    _('vPassword').type = 'text';
                                    _('vrePassword').type = 'text';
                                } else 
                                {
                                    _('vPassword').type = 'password';
                                    _('vrePassword').type = 'password';
                                }" />
                        </div>
                    </div>

                    <div class="innercont_stff" style="margin-top:5px;">
                        <label for="vPassword" class="labell" style="width:200px; margin-left:7px;">Password</label>
                        <div class="div_select">
                            <input name="vPassword" id="vPassword" type="password" class="textbox" style="text-transform:none;"
                            onchange="if (this.value.trim()!=''){passwordStrength(this.value, 'labell_msg15');}"/>
                        </div>
                        <div id="labell_msg15" class="labell_msg blink_text orange_msg"></div>
                    </div>
                    
                    <div class="innercont_stff">
                        <label for="vrePassword" class="labell" style="width:200px; margin-left:7px;">Confirm password</label>
                        <div class="div_select">
                            <input name="vrePassword" id="vrePassword" type="password" class="textbox" style="text-transform:none;"/>
                        </div>
                        <div id="labell_msg16" class="labell_msg blink_text orange_msg"></div>
                    </div>

                    
                    <div id="tk_div" class="innercont_stff" style="margin-top:1%; display:none">
                        <hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.8px; margin-bottom:0.6%;" />
                        <div class="innercont_stff">
                            <div class="succ_box blue_msg" style="text-align:left; width:60%; display:block">
                                A token has been sent to your official emaill address. Enter toke below
                            </div>
                        </div>

                        <div class="innercont_stff" style="margin-top:1%;">
                            <label for="staffid" class="labell" style="width:200px; margin-left:7px;">Token</label>
                            <div class="div_select">
                                <input name="tk" id="tk" 
                                type="text" 
                                class="textbox" 
                                style="text-transform:none;"
                                maxlength="10"/>
                            </div>
                            <div id="labell_msg17" class="labell_msg blink_text orange_msg"></div>
                        </div>
                    </div>

                    <!--<div class="innercont_stff" style="margin-top:10px;">
                        <div class="div_select" style="margin-right:3px; width:177px; height:34px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        flex-direction: column;">
                            <canvas id="valicode" style="width:100%; height:100%">captcha text</canvas>
                        </div>
                        <div class="div_select" style="width:30px;">
                            <img id="refresh_img" src="img/refresh.png" title="Refresh code" width="95%" height="80%" style="cursor:pointer; margin-top:4px;"/>
                        </div>
                        <div class="div_select">
                            <input name="cap_text" id="cap_text" type="textbox" class="textbox" 
                                style="text-transform:none;" 
                                autocomplete="off" 
                                maxlength="7"
                                placeholder="Enter the text in the left box here"/>
                        </div>
                        <div class="labell_msg blink_text orange_msg" id="labell_msg19" style="width:183px;"></div>
                        <input name="hidden_cap_text" id="hidden_cap_text" type="hidden"/>
                    </div>-->
                </div>
                <!-- <script src="cap2.js"></script> -->
            </form>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
				<img name="passprt" id="passprt" src="img/p_.png" width="95%" height="185"  alt="" />
			</div>
			<!-- InstanceBeginEditable name="EditRegion7" -->
			<!-- InstanceEndEditable -->
		</div>
		<div id="insiderightSide">
			<!-- InstanceBeginEditable name="EditRegion8" -->
                <div class="innercont_stff" style="margin:0px; padding:0px;">
                    <a href="#" style="text-decoration:none;" onclick="hpg.action='<?php echo BASE_FILE_NAME;?>';hpg.submit();return false">
                        <div class="basic_three" style="height:auto; width:inherit; padding:8.5px; float:none; margin:0px;">Home</div>
                    </a>
                </div>
                
				<?php side_detail('');?>
				<!-- InstanceEndEditable -->
		</div>
		<div id="insiderightSide" style="position:relative;">
			<!-- InstanceBeginEditable name="EditRegion9" -->
			<?php //include ('stff_bottom_right_menu.php');?>
                <a href="#" style="text-decoration:none;" 
                    onclick="chk_inputs();return false">
                    <div id="sub_box" class="bot_right_std_btns"style="position:absolute; bottom:0; display:block">
                        Submit
                    </div>
                </a>
                
                <a href="#" style="text-decoration:none;" 
                    onclick="hpg.action='staff_login_page';hpg.submit(); hpg.submit();return false">
                    <div id="cont_box" class="bot_right_std_btns"style="position:absolute; bottom:0; display:none">
                        Continue
                    </div>
                </a>
			<!-- InstanceEndEditable -->
		</div>
	</div>
	<div id="futa"><?php foot_bar();?></div>
</div>
</body>
<!-- InstanceEnd --></html>