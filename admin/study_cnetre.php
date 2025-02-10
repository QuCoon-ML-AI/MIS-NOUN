<?php
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/
	
require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/applform.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php
require_once('var_colls.php');

$currency = 1;

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
require_once('set_scheduled_dates.php');
require_once('staff_detail.php');?>

<!-- InstanceBeginEditable name="doctitle" -->
<title>NOUN-MIS</title>
<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
<!-- InstanceEndEditable -->




<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
<script language="JavaScript" type="text/javascript" src="button_ops.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
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
    function chk_inputs()
	{		
		var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}

		var letters = /^[A-Za-z ]+$/;
        var numbers_letter = /^[0-9A-Za-z ]+$/;
        var name_letter = /^[A-Za-z .()]+$/;
        var addresses = /^[0-9A-Za-z .,/]+$/;
		
		var error_free = 0;
		
		
		var formdata = new FormData();
		
		if (_("whattodo").value == 1 || _("whattodo").value == 2)
		{
			if (_("cstdStudyCenterId_div").style.display == 'block' && _("cstdStudyCenterId").value == '')
			{
				setMsgBox("labell_msg1","");
				_("cstdStudyCenterId").focus();
			}else if (_("cstdCountryId").value == '')
			{
				setMsgBox("labell_msg2","");
				_("cstdCountryId").focus();
			}else if (_("cstdStateId").value == '')
			{
				setMsgBox("labell_msg3","");
				_("cstdStateId").focus();
			}else if (_("cstdLGAId").value == '')
			{
				setMsgBox("labell_msg4","");
				_("cstdLGAId").focus();
			}else if (_("vstdCityName").value.trim() == '')
			{
				setMsgBox("labell_msg5","");
				_("vstdCityName").focus();
			}else if (!_("vstdCityName").value.match(name_letter))
			{
				setMsgBox("labell_msg5","Only letters are allowed");
				_("vstdCityName").focus();
			}else if (_("vstdStudyCenterAddress").value.trim() == '')
			{
				setMsgBox("labell_msg6","");
				_("vstdStudyCenterAddress").focus();
			}else if (!_("vstdStudyCenterAddress").value.match(addresses))
            {
                setMsgBox("labell_msg6","Only letters and numbers are allowed");
                _("vstdStudyCenterAddress").focus();
            }else if (_("vstdEMailId").value.trim() == '')
			{
				setMsgBox("labell_msg7","");
				_("vstdEMailId").focus();
			}else if (chk_mail(_("vstdEMailId")) != '')
			{
				setMsgBox("labell_msg7",chk_mail(_("vstdEMailId")));
				_("vstdEMailId").focus();
			}else if (_("contact_name1").value.trim() == '')
			{
				setMsgBox("labell_msg7a","");
				_("contact_name1").focus();
			}else if (!_("contact_name1").value.match(name_letter))
			{
				setMsgBox("labell_msg7a","Only letters are allowed");
				_("contact_name1").focus();
			}else if (_("vstdMobileNo1").value.trim() == '')
			{
				setMsgBox("labell_msg8","");
				_("vstdMobileNo1").focus();
			}else if (_("contact_name2").value.trim() == '')
			{
				setMsgBox("labell_msg8a","");
				_("contact_name2").focus();
			}else if (!_("contact_name2").value.match(name_letter))
			{
				setMsgBox("labell_msg8a","Only letters are allowed");
				_("contact_name2").focus();
			}else if (_("vstdMobileNo2").value.trim() == '')
			{
				setMsgBox("labell_msg9","");
				_("vstdMobileNo2").focus();
			}else
			{				
				if (_("whattodo").value == 2)
				{
					formdata.append("cstdStudyCenterId", _("cstdStudyCenterId").value);
				}
				
				formdata.append("cstdCountryId", _("cstdCountryId").value);
				formdata.append("cstdStateId", _("cstdStateId").value);
				formdata.append("cstdLGAId", _("cstdLGAId").value);
				formdata.append("vstdCityName", _("vstdCityName").value);
				
				formdata.append("vstdStudyCenterAddress", _("vstdStudyCenterAddress").value);
				formdata.append("vstdEMailId", _("vstdEMailId").value);
				formdata.append("vstdMobileNo1", _("vstdMobileNo1").value);				
				formdata.append("vstdMobileNo2", _("vstdMobileNo2").value);
				
				formdata.append("contact_name1", _("contact_name1").value);
				formdata.append("contact_name2", _("contact_name2").value);
				formdata.append("p_center", _("p_center").value);
								
				error_free = 1;
			}
		}else if (_("whattodo").value == 3)
		{
			error_free = 1;
            
            /*if (study_cnetre_loc.conf.value == '')
			{
				_("conf_msg_msg_loc").innerHTML = "Delete selected study centre ?";
                _('conf_box_loc').style.display = 'block';
                _('conf_box_loc').style.zIndex = '3';
                _('smke_screen_2').style.display = 'block';
                _('smke_screen_2').style.zIndex = '2';
			}else*/ if (study_cnetre_loc.conf.value == '1')
			{
				formdata.append("cstdStudyCenterId", _("cstdStudyCenterId").value);
				formdata.append("vstdCityName", _("vstdCityName").value);
				formdata.append("conf", '1');
			}			
		}
		
		if (error_free == 1)
		{
			formdata.append("currency", _("study_cnetre_loc").currency.value);
			formdata.append("user_cat", _("study_cnetre_loc").user_cat.value);
			formdata.append("cStudyCenterId", _('cstdStudyCenterId').value);
			formdata.append("vApplicationNo", _("study_cnetre_loc").vApplicationNo.value);
			formdata.append("save", '1');
			formdata.append("whattodo", _("whattodo").value);

			formdata.append("mm", _("study_cnetre_loc").mm.value);
			formdata.append("sm", _("study_cnetre_loc").sm.value);
			
			opr_prep(ajax = new XMLHttpRequest(),formdata);
		}
	}
	
	
	function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_study_centre.php");
		ajax.send(formdata);
	}


    function completeHandler(event)
	{
        on_error('0');
        on_abort('0');
        in_progress('0');
		
		var returnedStr = event.target.responseText;
			
        if (returnedStr.indexOf("success") != -1)
        {
            success_box(returnedStr);
        }			
			
        if (returnedStr.indexOf('aborted') != -1)
        {
            _('sub_box').style.display = 'none';
            caution_box(returnedStr);
            return;
        }

        if (_("whattodo").value == 3 && study_cnetre_loc.conf.value == '')
		{
            _("conf_msg_msg_loc").innerHTML = returnedStr;
            _('conf_box_loc').style.display = 'block';
            _('conf_box_loc').style.zIndex = '3';
            _('smke_screen_2').style.display = 'block';
            _('smke_screen_2').style.zIndex = '2';
            return;
        }
		
		if (_("whattodo").value == 3 && study_cnetre_loc.conf.value == '1' && returnedStr.indexOf('aborted') == -1)
		{
			_('cstdCountryId').value = '';
			_('cstdStateId').value = '';
			_('cstdLGAId').value = '';
			_('vstdStudyCenterAddress').value = '';

			_('vstdCityName').value = '';
			//_('vstdCityName_abrv').value = '';
			_('vstdEMailId').value = '';

			_('contact_name1').value = '';
			_('vstdMobileNo1').value = '';
			_('contact_name2').value = '';
			_('vstdMobileNo2').value = '';

			_('cstdStudyCenterId').options[_('cstdStudyCenterId').selectedIndex] = null;
			
			_("sub_box").style.display = 'none';
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

    function centre_select()
    {
        return true;

        if (_("user_centre_loc").value == '')
        {
            _("succ_boxt").style.display = "block";
            _("succ_boxt").innerHTML = "Please select a study centre";
            _("succ_boxt").style.display = "block";
            return false;
        }

        if (_("service_mode_loc").value == '')
        {
            _("succ_boxt").style.display = "block";
            _("succ_boxt").innerHTML = "Please select a service mode";
            _("succ_boxt").style.display = "block";
            return false;
        }

        return true;
    }
</script><?php

require_once ('set_scheduled_dates.php');?>
<!-- InstanceEndEditable -->
</head>
<body onLoad="checkConnection()">
    <?php admin_frms(); $has_matno = 0;?>
	
	<form action="staff_home_page" method="post" name="nxt" id="nxt" enctype="multipart/form-data">
		<input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
        <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" />
		<input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST['vMatricNo'])){echo $_REQUEST['vMatricNo']; }?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
		<input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
		
		<input name="mm" id="mm" type="hidden" value="<?php if (isset($_REQUEST["mm"])){echo $_REQUEST["mm"];} ?>" />
		<input name="mm_desc" id="mm_desc" type="hidden" value="<?php if (isset($_REQUEST["mm_desc"])){echo $_REQUEST["mm_desc"];} ?>" />
		<input name="sm" id="sm" type="hidden" value="<?php if (isset($_REQUEST["sm"])){echo $_REQUEST["sm"];} ?>" />
		<input name="sm_desc" id="sm_desc" type="hidden"  value="<?php if (isset($_REQUEST["sm_desc"])){echo $_REQUEST["sm_desc"];} ?>"/>

		<input name="contactus" id="contactus" type="hidden" />
		<input name="what" id="what" type="hidden" />
		
		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($service_mode)&&$service_mode<>''){echo $service_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($service_centre)&&$service_centre<>''){echo $service_centre;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
	</form><?php
	//include ('msg_service.php');?>
	
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
		<?php require_once ('menu_bar_content_stff.php');?>
		<!-- InstanceEndEditable -->
	</div>

	<div id="leftSide_std" style="margin-left:0px;"><?php
		require_once ('stff_left_side_menu.php');?>
	</div>
	<div id="rtlft_std" style="position:relative;">
		<!-- InstanceBeginEditable name="EditRegion6" -->			
			
			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
            <div id="conf_box_loc" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
                <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                    Confirmation
                </div>
                <a href="#" style="text-decoration:none;">
                    <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                </a>
                <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
                    Delete selected qualification?
                </div>
                <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
                    <a href="#" style="text-decoration:none;" 
                        onclick="_('conf_box_loc').style.display='none';
                        _('smke_screen_2').style.display='none';
                        _('smke_screen_2').style.zIndex='-1';
                        _('labell_msg1').style.display = 'none';
                        study_cnetre_loc.conf.value='1';
                        chk_inputs();
                        return false">
                        <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                            Yes
                        </div>
                    </a>

                    <a href="#" style="text-decoration:none;" 
                        onclick="study_cnetre_loc.conf.value='';
                        _('conf_box_loc').style.display='none';
                        _('smke_screen_2').style.display='none';
                        _('smke_screen_2').style.zIndex='-1';
                        _('labell_msg1').style.display = 'none';
                        return false">
                        <div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
                            No
                        </div>
                    </a>
                </div>
            </div>
            <div class="innercont_top">Manage study centre</div>

            <form action="manage-study-centres" method="post" name="study_cnetre_loc" id="study_cnetre_loc" enctype="multipart/form-data">
                <input name="currency39" id="currency39" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                <input name="study_mode_ID" id="study_mode_ID" type="hidden" value="odl" />
                <input name="call_record" id="call_record" type="hidden" value="" />
                <input name="logoLoaded" id="logoLoaded" type="hidden"/>
                
                <?php frm_vars(); ?>

                <select name="State_readup" id="State_readup" style="display:none"><?php	
                    $sql = "select cStateId,cCountryId,vStateName from ng_state order by vStateName";
                    $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                    while ($rs = mysqli_fetch_array($rssql))
                    {?>
                        <option value="<?php echo $rs['cStateId'].$rs['cCountryId'];?>"><?php echo $rs['vStateName']; ?></option><?php
                    }
                    mysqli_close(link_connect_db());?>
                </select>

                <select name="LGA_readup" id="LGA_readup" style="display:none"><?php	
                    $sql = "select cStateId,cLGAId, vLGADesc from localarea order by vLGADesc";
                    $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                    while ($rs = mysqli_fetch_array($rssql))
                    {?>
                        <option value="<?php echo $rs['cStateId'].$rs['cLGAId'];?>"><?php echo ucwords (strtolower ($rs["vLGADesc"]))?></option><?php
                    }
                    mysqli_close(link_connect_db());?>
                </select>

                
                <input name="whattodo" id="whattodo" type="hidden" value="<?php if (isset($_REQUEST["whattodo"]) && $_REQUEST["whattodo"] <> ''){echo $_REQUEST["whattodo"];}?>"/>
                
                <div style="width:13%; height:auto; position:absolute; right:0; border-radius:0px;"><?php
                    if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='0')
                    {?>
                        <div id="tabss0_0" class="rtlft_inner_button" style="margin-left:0%;
                            border-left:1px solid #2b8007;
                            background-color:#2b8007;
                            color:#FFFFFF;
                            width:100%;
                            display:block;">
                                View
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="study_cnetre_loc.whattodo.value=0;
                            _('cstdStudyCenterId').value = '';
                            study_cnetre_loc.submit();
                            return false">
                            <div id="tabss0" class="rtlft_inner_button" style="width:100%; display:none;">
                                View
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="study_cnetre_loc.whattodo.value=0;
                            _('cstdStudyCenterId').value = '';
                            study_cnetre_loc.submit();
                            return false">
                            <div id="tabss0" class="rtlft_inner_button" style="width:100%;">
                                View
                            </div>
                        </a><?php
                    }
                    
                    if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='1')
                    {?>
                        <div id="tabss1_0" class="rtlft_inner_button" style="margin-left:0%;
                            border-left:1px solid #2b8007; 
                            background-color:#2b8007;
                            color:#FFFFFF;
                            width:100%;
                            display:block;">
                                Create
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="study_cnetre_loc.whattodo.value=1;
                            _('cstdStudyCenterId').value = '';
                            study_cnetre_loc.submit();
                            return false">
                            <div id="tabss1" class="rtlft_inner_button" style="width:100%; display:none;">
                                Create
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="study_cnetre_loc.whattodo.value=1;
                            _('cstdStudyCenterId').value = '';
                            study_cnetre_loc.submit();
                            return false">
                            <div id="tabss1" class="rtlft_inner_button" style="width:100%;">
                                Create
                            </div>
                        </a><?php
                    }
                    
                    if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='2')
                    {?>
                        <div id="tabss4_0" class="rtlft_inner_button" style="margin-left:0%;
                            border-left:1px solid #2b8007;
                            background-color:#2b8007;
                            color:#FFFFFF;
                            width:100%;
                            display:block;">
                                Edit
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="study_cnetre_loc.whattodo.value=2;
                            _('cstdStudyCenterId').value = '';
                            study_cnetre_loc.submit();
                            return false">
                            <div id="tabss4" class="rtlft_inner_button" style="width:100%; display:none;">
                                Edit
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="study_cnetre_loc.whattodo.value=2;
                            _('cstdStudyCenterId').value = '';
                            study_cnetre_loc.submit();
                            return false">
                            <div id="tabss4" class="rtlft_inner_button" style="width:100%;">
                                Edit
                            </div>
                        </a><?php
                    }
                    
                    if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='3')
                    {?>
                        <div id="tabss5_0" class="rtlft_inner_button" style="background-color:#2b8007;
                            color:#FFFFFF;
                            width:100%;
                            display:block;">
                                Delete
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="study_cnetre_loc.whattodo.value=3;
                            _('cstdStudyCenterId').value = '';
                            study_cnetre_loc.submit();
                            return false">
                            <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                                Delete
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="study_cnetre_loc.whattodo.value=3;
                            _('cstdStudyCenterId').value = '';
                            study_cnetre_loc.submit();
                            return false">
                            <div id="tabss5" class="rtlft_inner_button" style="width:100%; border-bottom:1px dashed #2b8007;">
                                Delete
                            </div>
                        </a><?php
                    }?>
                </div><?php
                $sho = 'none';
                if (isset($_REQUEST["whattodo"]) && $_REQUEST["whattodo"] <> 1)
                {
                    $sho = 'block';
                }?>
                <div id="loc_container" class="innercont_stff" style="height:auto; overflow:auto;">
                    <div id="cstdStudyCenterId_div" class="innercont_stff" style="margin-top:0px; display:<?php echo $sho;?>;">
                        <label for="cstdStudyCenterId" class="labell" style="width:195px">Study centre</label>
                        <div class="div_select"><?php
                            $sql = "SELECT cStudyCenterId, vCityName from studycenter WHERE cDelFlag = 'N' order by vCityName";                            
                            $rsql=mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));?>
                            
                            <select name="cstdStudyCenterId" id="cstdStudyCenterId" class="select" onchange="study_cnetre_loc.submit();">
                                <option value=""></option><?php
                                $cnt = -1;
                                while ($table= mysqli_fetch_array($rsql))
                                {
                                    $cnt++;
                                    if ($cnt > 0 && $cnt%5==0)
                                    {?>
                                        <option value=""></option><?php
                                    }?>
                                    <option value="<?php echo $table['cStudyCenterId'] ?>" <?php if (isset($_REQUEST['cstdStudyCenterId']) && $_REQUEST['cstdStudyCenterId'] == $table['cStudyCenterId']){echo ' selected';}?>><?php echo ucwords(strtolower($table['vCityName'])) ;?> </option><?php
                                }
                                mysqli_close(link_connect_db());?>
                            </select>
                        </div>
                        <div id="labell_msg1" class="labell_msg blink_text orange_msg"></div>
                    </div><?php
                    
                    if ((isset($_REQUEST['cstdStudyCenterId']) && $_REQUEST['cstdStudyCenterId'] <> '') || (isset($_REQUEST["whattodo"]) && $_REQUEST["whattodo"] == 1))
                    {
                        // $stmt = $mysqli->prepare("SELECT cCountryId, cStateId, cLGAId, vCityName, vStudyCenterAddress, vEMailId, contact_name1, vPhoneNo1, contact_name2, vPhoneNo2, banker, account_number, account_name, study_mode_ID, clogo, pay_install, install_amnt1, install_amnt2, install_amnt3 
                        // FROM studycenter 
                        // WHERE cStudyCenterId = ?");

                        $stmt = $mysqli->prepare("SELECT cCountryId, cStateId, cLGAId, vCityName, vStudyCenterAddress, vEmaild, contact_name1, vPhoneNo1,  contact_name2, vPhoneNo2, p_center 
                        FROM studycenter 
                        WHERE cStudyCenterId = ?");

                        $stmt->bind_param("s", $_REQUEST['cstdStudyCenterId']);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($cCountryId_01, $cStateId_01, $cLGAId_01, $vCityName_01, $vStudyCenterAddress_01, $vEMailId_01, $contact_name1, $vPhoneNo1_01, $contact_name2, $vPhoneNo2_01, $p_center);
                        $stmt->fetch();
                        $stmt->close();?>

                        <div id="cstdCountryId_div" class="innercont_stff" style="margin-bottom:4px;">
                            <label for="cstdCountryId" class="labell" style="width:195px">Country</label>
                            <div class="div_select"><?php
                                $sqlcCountryId="select cCountryId, vCountryName from country order by vCountryName";
                                $rsqlcCountryId=mysqli_query(link_connect_db(), $sqlcCountryId)or die("cannot query the table".mysqli_error(link_connect_db()));?>
                                <select name="cstdCountryId" id="cstdCountryId" onchange="
                                    update_cat_country('cstdCountryId', 'State_readup', 'cstdStateId', 'cstdLGAId')" class="select">
                                    <option selected="selected" ></option><?php
                                    while ($table=mysqli_fetch_array($rsqlcCountryId))
                                    {?>
                                        <option value="<?php echo $table["cCountryId"]?>" <?php if ($cCountryId_01 == $table['cCountryId']){echo ' selected';}else if ($table['cCountryId'] == 'NG'){echo ' selected';}?>> <?php echo ucwords (strtolower ($table["vCountryName"]))?> </option><?php
                                    }
                                    mysqli_close(link_connect_db());?>
                                </select>
                            </div>
                            <div id="labell_msg2" class="labell_msg blink_text orange_msg"></div>
                        </div>
                        
                        <div id="cstdStateId_div" class="innercont_stff" style="margin-bottom:4px;">
                            <label for="cstdStateId" class="labell" style="width:195px">State</label>
                            <div class="div_select"><?php
                                $sql1 = "select cStateId, vStateName from ng_state where cCountryId = 'NG' order by vStateName";
                                $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
                                <select name="cstdStateId" id="cstdStateId" onchange="update_cat_country('cstdStateId', 'LGA_readup', 'cstdLGAId', 'cstdLGAId')" class="select">
                                    <option value="" selected="selected" ></option><?php
                                    while ($table=mysqli_fetch_array($rsql1))
                                    {?>
                                        <option value="<?php echo $table["cStateId"]?>" <?php if ($cStateId_01 == $table['cStateId']){echo ' selected';}?>> <?php echo ucwords (strtolower ($table["vStateName"]))?> </option><?php
                                    }
                                    mysqli_close(link_connect_db());?>
                                </select>
                            </div>
                            <div id="labell_msg3" class="labell_msg blink_text orange_msg"></div>
                        </div>
                        
                        <div id="cstdLGAId_div" class="innercont_stff" style="margin-bottom:4px;">
                            <label for="cstdLGAId" class="labell" style="width:195px">Local Govt. Area of origin</label>
                            <div class="div_select"><?php
                                $sql1 = "select cLGAId, vLGADesc from localarea where cStateId = '$cStateId_01' order by vLGADesc";
                                $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
                                <select name="cstdLGAId" id="cstdLGAId" class="select">
                                    <option value="" selected="selected" ></option><?php
                                    while ($table=mysqli_fetch_array($rsql1))
                                    {?>
                                        <option value="<?php echo $table["cLGAId"]?>" <?php if ($cLGAId_01 == $table['cLGAId']){echo ' selected';}?>> <?php echo ucwords (strtolower ($table["vLGADesc"]))?> </option><?php
                                    }
                                    mysqli_close(link_connect_db());?>
                                </select>
                            </div>
                            <div id="labell_msg4" class="labell_msg blink_text orange_msg"></div>
                        </div>
                        
                        <div id="vstdCityName_div" class="innercont_stff" style="margin-bottom:4px;">
                            <label for="vstdCityName" class="labell" style="width:195px;">Town</label>
                            <div class="div_select">
                                <input name="vstdCityName" id="vstdCityName" type="text" class="textbox" style="margin-right:3px; float:left" 
                                    value="<?php echo $vCityName_01;?>" 
                                    onblur="this.value=this.value.trim();
                                    this.value=capitalizeEachWord(this.value);"
                                    maxlength="25"/>
                            </div>
                            <div id="labell_msg5" class="labell_msg blink_text orange_msg"></div>
                        </div>
                        
                        <div id="vstdStudyCenterAddress_div" class="innercont_stff" style="margin-bottom:4px;">
                            <label for="vstdStudyCenterAddress" class="labell" style="width:195px">Street address</label>
                            <div class="div_select">
                                <input name="vstdStudyCenterAddress" id="vstdStudyCenterAddress" type="text" class="textbox" style="margin-right:3px; float:left" 
                                    value="<?php echo $vStudyCenterAddress_01;?>" 
                                    onblur="this.value=this.value.trim();
                                    this.value=capitalizeEachWord(this.value);"
                                    maxlength="40"/>
                            </div>
                            <div id="labell_msg6" class="labell_msg blink_text orange_msg"></div>
                        </div>
                        
                        
                       <div id="vstdEMailId_div" class="innercont_stff" style="margin-bottom:4px; margin-top:20px;">
                            <label for="vstdEMailId" class="labell" style="width:195px">eMail address</label>
                            <div class="div_select">
                                <input name="vstdEMailId" id="vstdEMailId" type="email" class="textbox" style="text-transform:none;" 
                                    onblur="this.value=this.value.trim();
                                    this.value=this.value.toLowerCase();" 
                                    maxlength="45"
                                    value="<?php echo $vEMailId_01;?>"/>
                            </div>
                            <div id="labell_msg7" class="labell_msg blink_text orange_msg"></div>
                        </div>
                        
                        <div id="contact_name1_div" class="innercont_stff" style="margin-bottom:4px;">
                            <label for="contact_name1" class="labell" style="width:195px">Name of contact1</label>
                            <div class="div_select">
                                <input name="contact_name1" id="contact_name1" type="text" class="textbox" 
                                    onblur="this.value=this.value.trim();
                                    this.value=capitalizeEachWord(this.value)"
                                    maxlength="30" 
                                    value="<?php echo $contact_name1;?>"/>
                            </div>
                            <div id="labell_msg7a" class="labell_msg blink_text orange_msg"></div>
                        </div>
                        
                        <div id="vstdMobileNo1_div" class="innercont_stff" style="margin-bottom:4px;">
                            <label for="vstdMobileNo2" class="labell" style="width:195px">Mobile phone number 1</label>
                            <div class="div_select">
                                <input name="vstdMobileNo1" id="vstdMobileNo1" type="number" class="textbox" 
                                    onblur="this.value=this.value.trim()"
                                    value="<?php echo $vPhoneNo1_01;?>"
                                    onkeypress="if(this.value.length==11){return false}"/>
                            </div>
                            <div id="labell_msg8" class="labell_msg blink_text orange_msg"></div>
                        </div>

                        <div id="contact_name2_div" class="innercont_stff" style="margin-bottom:4px;">
                            <label for="contact_name2" class="labell" style="width:195px">Name of contact2</label>
                            <div class="div_select">
                                <input name="contact_name2" id="contact_name2" type="text" class="textbox" 
                                    onblur="this.value=this.value.trim();
                                    this.value=capitalizeEachWord(this.value);"
                                    maxlength="30" 
                                    value="<?php echo $contact_name2;?>"/>
                            </div>
                            <div id="labell_msg8a" class="labell_msg blink_text orange_msg"></div>
                        </div>	
                        
                        <div id="vstdMobileNo2_div" class="innercont_stff" style="margin-bottom:4px;">
                            <label for="vstdMobileNo2" class="labell" style="width:195px">Mobile phone number 2</label>
                            <div class="div_select">
                                <input name="vstdMobileNo2" id="vstdMobileNo2" type="number" class="textbox" 
                                    onblur="this.value=this.value.trim()"
                                    value="<?php echo $vPhoneNo2_01;?>"
                                    onkeypress="if(this.value.length==11){return false}"/>
                            </div>
                            <div id="labell_msg9" class="labell_msg blink_text orange_msg"></div>
                        </div>	
                        
                        <div id="vstdMobileNo2_div" class="innercont_stff" style="margin-bottom:4px;">
                            <label for="p_center" class="labell" style="width:195px">Practical centre</label>
                            <div class="div_select">
                                <input name="p_center" id="p_center" type="number" class="textbox" 
                                    onblur="this.value=this.value.trim()"
                                    value="<?php echo $p_center;?>"
                                    onkeypress="if(this.value.length==3){return false}"/>
                            </div>
                            <div id="labell_msg9" class="labell_msg blink_text orange_msg"></div>
                        </div><?php
                    }?>

                </div>
            </form>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
				<img name="passprt" id="passprt" src="img/p_.png" width="95%" height="185"  
				style="margin:0px;<?php if ($currency <> '1' ){?>opacity:0.3;<?php }?>" alt="" />
			</div>
			<!-- InstanceBeginEditable name="EditRegion7" -->
			<!-- InstanceEndEditable -->
		</div>
		<div id="insiderightSide">
			<!-- InstanceBeginEditable name="EditRegion8" -->
                <div class="innercont_stff" style="margin:0px; padding:0px;">
                    <a href="#" style="text-decoration:none;" onclick="_('nxt').action = 'staff_home_page';_('nxt').mm.value='';_('nxt').submit();return false">
                        <div class="basic_three" style="height:auto; width:inherit; padding:8.5px; float:none; margin:0px;">Home</div>
                    </a>
                </div>
                
				<?php side_detail('');?>
				<!-- InstanceEndEditable -->
		</div>
		<div id="insiderightSide" style="position:relative;">
			<!-- InstanceBeginEditable name="EditRegion9" -->
			<?php require_once ('stff_bottom_right_menu.php');?>
			<!-- InstanceEndEditable -->
		</div>
	</div>
	<div id="futa"><?php foot_bar();?></div>
</div>
</body>
<!-- InstanceEnd --></html>