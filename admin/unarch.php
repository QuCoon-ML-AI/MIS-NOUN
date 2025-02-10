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
<!DOCTYPE html>
<html lang="en">
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
	
</script>
<noscript></noscript>

<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript" type="text/javascript">
	document.onkeydown = function (e) 
	{
		if (e.ctrlKey && e.keyCode === 85) 
		{
            return false;
        }
	}
		
    function chk_inputs()
	{
		var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}
		
		var formdata = new FormData();

		if (unarch_loc.id_no.value.trim() == '')
		{
			setMsgBox("labell_msg0","Select either application form number or matriculation number");
			unarch_loc.id_no.focus();
			return false;
		}

		if (unarch_loc.action_to_do.value == '')
		{
			setMsgBox("labell_msg1","Select action to perform: archive or unarchive");
			unarch_loc.action_to_do.focus();
			return false;
		}

		if (!unarch_loc.bulk_change.disabled && unarch_loc.bulk_change.value.trim() == '')
		{
			setMsgBox("labell_msg3","");
			unarch_loc.bulk_change.focus();
			return false;
		}

		if (!unarch_loc.uvApplicationNo.disabled && unarch_loc.uvApplicationNo.value == '')
		{
			if (unarch_loc.id_no.value.trim() == '0')
			{
				setMsgBox("labell_msg2","Enter the application form number");
			}else if (unarch_loc.id_no.value.trim() == '1')
			{
				setMsgBox("labell_msg2","Enter the matriculation number");
			}
			unarch_loc.uvApplicationNo.focus();
			return false;
		}

		if (unarch_loc.conf.value != '1')
		{
			if (!unarch_loc.uvApplicationNo.disabled && unarch_loc.uvApplicationNo.value != '')
			{
				if (unarch_loc.action_to_do.value == '0')
				{
					_("conf_msg_msg_loc").innerHTML = 'Are you sure you want to archive record';
				}else if (unarch_loc.action_to_do.value == '1')
				{
					_("conf_msg_msg_loc").innerHTML = 'Are you sure you want to unarchive record';
				}
			}else if (!unarch_loc.bulk_change.disabled && unarch_loc.bulk_change.value != '')
			{
				if (unarch_loc.action_to_do.value == '0')
				{
					_("conf_msg_msg_loc").innerHTML = 'Are you sure you want to archive records';
				}else if (unarch_loc.action_to_do.value == '1')
				{
					_("conf_msg_msg_loc").innerHTML = 'Are you sure you want to unarchive records';
				}
			}
			_('conf_box_loc').style.display = 'block';
			_('conf_box_loc').style.zIndex = '3';
			_('smke_screen_2').style.display = 'block';
			_('smke_screen_2').style.zIndex = '2';
			return;
		}

		formdata.append("ilin", unarch_loc.ilin.value);
		formdata.append("vApplicationNo", unarch_loc.vApplicationNo.value);
		if (!unarch_loc.uvApplicationNo.disabled && unarch_loc.uvApplicationNo.value != '')
		{
			formdata.append("uvApplicationNo", unarch_loc.uvApplicationNo.value);
		}

		
		if (!unarch_loc.bulk_change.disabled && unarch_loc.bulk_change.value != '')
		{
			formdata.append("bulk_change", unarch_loc.bulk_change.value);
		}
		
		formdata.append("staff_study_center", unarch_loc.user_centre.value);
		formdata.append("user_cat", unarch_loc.user_cat.value);
		formdata.append("id_no", unarch_loc.id_no.value);
		
		formdata.append("action_to_do", unarch_loc.action_to_do.value);
		formdata.append("arch_mode_hd", unarch_loc.arch_mode_hd.value);
		
		formdata.append("mm", unarch_loc.mm.value);
		formdata.append("ilin", unarch_loc.ilin.value);

		opr_prep(ajax = new XMLHttpRequest(),formdata);
	}
	
	
	function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_un_arcive.php");
		ajax.send(formdata);
	}


    function completeHandler(event)
    {
        on_error('0');
        on_abort('0');
        in_progress('0');

        var returnedStr = event.target.responseText;
		if (returnedStr == 'success')
		{
			if (unarch_loc.action_to_do.value == '0')
			{
				if (unarch_loc.id_no.value == '0')
				{
					success_box('Application form number archived successfully');
				}else if (unarch_loc.id_no.value == '1')
				{
					success_box('Matriculation number archived successfully');
				}
			}else if (unarch_loc.action_to_do.value == '1')
			{
				if (unarch_loc.id_no.value == '0')
				{
					success_box('Application form number re-instated successfully');
				}else if (unarch_loc.id_no.value == '1')
				{
					success_box('Matriculation number re-instated successfully');
				}
			}
		}else
		{
			caution_box(returnedStr);returnedStr
		}

		unarch_loc.conf.value = '';
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

		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
	</form>
        
	<form action="<?php echo APPL_BASE_FILE_NAME;?>see-admission-letter" method="post" name="admltr" target="_blank" enctype="multipart/form-data">
		<input name="mm" type="hidden" value="<?php if (isset($_REQUEST["mm"])){echo $_REQUEST["mm"];}?>" />
		<input name="sm" type="hidden" value="<?php if (isset($_REQUEST["sm"])){echo $_REQUEST["sm"];}?>" />
		
		<input name="uvApplicationNo" id="uvApplicationNo" type="hidden" value="<?php if (isset($vApplicationNo)){echo $vApplicationNo;} ?>" />
		<input name="vApplicationNo" id="vApplicationNo" type="hidden" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
		<input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
		<input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />
		<input name="study_mode" id="study_mode" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />

		<input name="study_mode" id="study_mode" type="hidden" value="<?php if (isset($_REQUEST["study_mode"]) && $_REQUEST["study_mode"] <> ''){echo $_REQUEST["study_mode"];}?>" />		

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />

		<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
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
<div id="container">
    <div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
	<div id="conf_box_loc" class="center" style="display:none; width:400px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
		<div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Confirmation
		</div>
		<a href="#" style="text-decoration:none;">
			<div style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<!-- <div id="submityes0" 
			style="border-radius:3px; margin:auto; margin-top:30px; margin-bottom:5px; height:auto; width:95%; text-align:center; padding:2%; background:#f1f1f1">
			<div style="width:auto; margin:auto; margin-bottom:5px; padding:0px; width:95%; float:none; line-height:1.5;">
				Check your official e-mail in-box for a token to use for this session<br>Token expires in 20minutes
			</div>
			<div style="margin:auto; margin-top:10px; height:auto; text-align:center; padding:0px; width:95%;">
				<input name="veri_token" id="veri_token" type="text" class="textbox" placeholder="Enter token here..." style="float:none; width:50%; padding:5px; text-align:center; height:25px"/>
				<div id="labell_msg_token" class="labell_msg blink_text orange_msg" style="float:none; text-align:center; display:none; width:50%; margin:auto; margin-top:10px;"></div>
				<input name="hd_veri_token" id="hd_veri_token" type="hidden"/>
			</div>
		</div> -->
		<div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:100%; float:left; text-align:center; padding:0px;"></div>
		<div style="margin-top:10px; width:100%; float:left; text-align:right; padding:0px;">
			<a href="#" style="text-decoration:none;" 
				onclick="unarch_loc.conf.value = '1';
				_('conf_box_loc').style.display='none';
				_('smke_screen_2').style.display='none';
				_('smke_screen_2').style.zIndex='-1';
				chk_inputs(); 
				return false">
				<div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
					Yes
				</div>
			</a>

			<a href="#" style="text-decoration:none;" 
				onclick="unarch_loc.conf.value='';
				_('conf_box_loc').style.display='none';
				_('smke_screen_2').style.display='none';
				_('smke_screen_2').style.zIndex='-1';
				return false">
				<div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
					No
				</div>
			</a>
		</div>
	</div><?php
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
            <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u ?>" />

			<div class="innercont_top" style="margin-bottom:0px;">Student's request</div>
            <form method="post" name="unarch_loc" id="unarch_loc" enctype="multipart/form-data">
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
				
                <input name="pasUpldFlg" id="pasUpldFlg" type="hidden" value="0"/>
                <input name="upld_passpic_no" id="upld_passpic_no" type="hidden" value="<?php echo $orgsetins['upld_passpic_no']; ?>"/>
                <input name="uvApplicationNo_loc" id="uvApplicationNo_loc" type="hidden" />
                <input name="app_frm_no" id="app_frm_no" type="hidden" />
                <input name="pc_char" id="pc_char" type="hidden" value="<?php echo $orgsetins['pc_char'];?>" />
                
                <input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId_u ?>" />
                <input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdeptId_u ?>" />
                                
                <input name="cAcademicDesc" id="cAcademicDesc" type="hidden" value="<?php echo $orgsetins["cAcademicDesc"]; ?>" />
                <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester; ?>" />
                <input name="next_level_frm_var" id="next_level_frm_var" type="hidden"/>
                <input name="tab_id" id="tab_id" type="hidden" value="<?php if (isset($_REQUEST['tab_id'])){echo $_REQUEST['tab_id'];}?>"/>
                <input name="whattodo" id="whattodo" type="hidden" value="<?php if(isset($_REQUEST['whattodo'])){echo $_REQUEST['whattodo'];}else{echo '';}?>" />
			
				<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>

                <?php frm_vars();

                require_once("student_requests.php");?>
				<div class="innercont_stff" style="margin-top:15px">
					<div class="div_select" style="width:auto">
						<input name="id_no" id="id_no_1" 
						value="0" 
						type="radio"/>
					</div>							
					<div class="div_select">
						<label for="id_no_1" id="enforce_cc_lbl">
							Application form number (AFN)
						</label>
					</div>

					<div class="div_select" style="width:auto">
						<input name="id_no" id="id_no_2"
						value="1" 
						type="radio"/>
					</div>							
					<div class="div_select">
						<label for="id_no_2" id="enforce_cc_lbl">
							Matriculation number
						</label>
					</div>
					<div id="labell_msg0" class="labell_msg blink_text orange_msg" style="width:auto"></div>
				</div>
				
				<div class="innercont_stff" style="margin-top:15px">
					<div class="div_select" style="width:auto">
						<input name="action_to_do" id="action_to_do_1"
						value="0" 
						type="radio"/>
					</div>							
					<div class="div_select">
						<label for="action_to_do_1" id="enforce_cc_lbl">
							Archive
						</label>
					</div>

					<div class="div_select" style="width:auto">
						<input name="action_to_do" id="action_to_do_2"
						value="1" 
						type="radio"/>
					</div>							
					<div class="div_select">
						<label for="action_to_do_2" id="enforce_cc_lbl">
							Unarchive
						</label>
					</div>
					<div id="labell_msg1" class="labell_msg blink_text orange_msg" style="width:auto"></div>
				</div>

				<div class="innercont_stff">
					<!-- <div class="div_select">
						<select name="id_no" id="id_no" class="select" style="margin-top:0px"
							onchange="_('uvApplicationNo').value = '';">
							<option value=""  selected>Select an option</option>
							<option value="0">Application form number (AFN)</option>
							<option value="1">Matriculation number</option>
						</select>
					</div>
					<div class="div_select">
						<select name="action_to_do" id="action_to_do" class="select" style="margin-top:0px"
							onchange="_('uvApplicationNo').value = '';">
							<option value=""  selected>Select action to perform</option>
							<option value="0">Archive</option>
							<option value="1">Unarchive</option>
						</select>
					</div> -->
					<div class="div_select" style="margin-top:0px">
						<input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox"
							onchange="this.value=this.value.trim();
							this.value = this.value.toUpperCase()"
                            title="Only usable if box below is empty"
							maxlength="12"
                            onblur="if (this.value.trim() != '')
                            {
                                unarch_loc.bulk_change.disabled=true
                            }else
                            {
                                unarch_loc.bulk_change.disabled=false
                            }" placeholder="Enter number here"/>
					</div>
					<div id="labell_msg2" class="labell_msg blink_text orange_msg" style="width:auto"></div>
				</div>

				<div class="innercont_stff" style="margin-top:20px; height:auto">
                    <div class="div_select" style="height:auto">
                    <textarea rows="5" 
                        style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; height:250px; width:96%; padding:5px" 
                        name="bulk_change" 
                        id="bulk_change" 
                        placeholder="To treat cases in batch, copy and paste numbers here"
                        title="Only usable if box above is empty"
                        onblur="if (this.value.trim() != '')
                        {
                            unarch_loc.uvApplicationNo.disabled=true;
                        }else
                        {
                            unarch_loc.uvApplicationNo.disabled=false;
                        }"></textarea>
                    </div>
					<div id="labell_msg3" class="labell_msg blink_text orange_msg" style="width:auto"></div>
                </div>
            </form>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
				<img name="passprt" id="passprt" src="<?php echo get_pp_pix('');?>" width="95%" height="185" style="margin:0px;" alt="" />
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
                
				<?php if (isset($_REQUEST['uvApplicationNo'])){side_detail($_REQUEST['uvApplicationNo']);}?>
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