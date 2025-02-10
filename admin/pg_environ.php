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
require_once('staff_detail.php');


$stmt = $mysqli->prepare("SELECT vFacultyDesc FROM faculty WHERE cFacultyId = '$cFacultyId_u'");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($vFacultyDesc_u);
$stmt->fetch();
$stmt->close();

$vFacultyDesc_u = $vFacultyDesc_u ?? '';

$stmt = $mysqli->prepare("SELECT vdeptDesc FROM depts WHERE cdeptId = '$cdeptId_u'");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($vdeptDesc_u);
$stmt->fetch();
$stmt->close();

$vdeptDesc_u = $vdeptDesc_u ?? '';?>

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
			
			var formdata = new FormData();
			
			if (_("new_esminar_div") && _("new_esminar_div").style.display == 'block')
			{
				if (_("s_topic").value.trim() == '')
				{
					setMsgBox("labell_msg0","");
					_("s_topic").focus();
					return false;
				}

				if (_("date_ass").value == '')
				{
					setMsgBox("labell_msg1","");
					_("date_ass").focus();
					return false;
				}
				
				if (_("presented").checked && _("date_presented").value.trim() == '')
				{
					setMsgBox("labell_msg3","");
					_("date_presented").focus();
					return false;
				}

				if (_('date_presented').value != '' && !properdate(_('date_ass').value,_('date_presented').value))
				{
					setMsgBox("labell_msg3","Date should come after the date of assignment of topic");
					_("date_presented").focus();
					return false;
				}

				formdata.append("s_topic", _("s_topic").value.trim());
				formdata.append("date_ass", _("date_ass").value);
				if (_("presented").checked)
				{
					formdata.append("presented",'1');
				}else
				{
					formdata.append("presented",'0');
				}

				formdata.append("date_presented", _("date_presented").value);
				if (_("score").value != '')
				{
					formdata.append("score",_("score").value);
				}else
				{
					formdata.append("score",-1);
				}

				formdata.append("vMatricNo",_('pg_environ').uvApplicationNo.value);
			}else if (_("new_sup_div") && _("new_sup_div").style.display == 'block')
			{
				if (_("exist_user").value.trim() == '')
				{
					setMsgBox("labell_msg0b","");
					_("exist_user").focus();
					return false;
				}
				
				formdata.append("supervisor",_('exist_user').value);
				formdata.append("vMatricNo",_('pg_environ').uvApplicationNo.value);
			}else
			{
				if (pg_environ.del.value == '1')
				{
					formdata.append("del", '1');
					formdata.append("s_topic", _("s_topic").value);
					formdata.append("uvApplicationNo", pg_environ.uvApplicationNo.value);
				}else if (pg_environ.conf.value != '1')
				{
					if (pg_environ.sm.value == 20 || pg_environ.sm.value == 21 || pg_environ.sm.value == 22 || pg_environ.sm.value == 23 || pg_environ.sm.value == 24 || pg_environ.sm.value == 25 || pg_environ.sm.value == 26 || pg_environ.sm.value == 28 || (pg_environ.sm.value.length == 3 && isNaN(pg_environ.sm.value.substr(2,1))))//fwd to dept, retreive, iv
					{
						box_checked = 0;
						
						var ulChildNodes = _("all_chk_box").getElementsByTagName("input");
						for (j = 0; j <= ulChildNodes.length-1; j++)
						{
							if (ulChildNodes[j].type == 'checkbox' && !ulChildNodes[j].disabled && ulChildNodes[j].id.indexOf("afn") != -1)
							{
								if (ulChildNodes[j].checked)
								{
									box_checked++;
									break;
								}
							}
						}
					}
					
					msg = '';
					if (pg_environ.sm.value == 20)
					{
						msg = 'Forward selected application(s)?';
					}else if (pg_environ.sm.value == 21)
					{
						msg = 'Retrieve selected application(s)?';
					}else if (pg_environ.sm.value == 22)
					{
						msg = 'Invite selected candidate(s)?';
					}else if (pg_environ.sm.value == 23)
					{
						msg = 'Selected candidate(s) have been interviewed?';
					}else if (pg_environ.sm.value == 24)
					{
						msg = 'Recommend selected candidate(s) for admission?';
					}else if (pg_environ.sm.value == 25)
					{
						msg = 'Enable admission letter for selected candidate(s)?';
					}else if (pg_environ.sm.value == 26)
					{
						msg = 'Selected candidate(s) have been screened qualified?';
					}else if (pg_environ.sm.value == 28)
					{
						msg = 'Selected candidate(s) have submitted their transcripts?';
					}else if (pg_environ.sm.value == '27b')
					{
						msg = 'Selected candidate(s) have submitted their respective proposals?';
					}else if (pg_environ.sm.value == '27c')
					{
						msg = 'Selected candidate(s) have defended their respective proposals successfully?';
					}else if (pg_environ.sm.value == '27d')
					{
						msg = 'Selected candidate(s) have done their post-field defence successfully?';
					}else if (pg_environ.sm.value == '27e')
					{
						msg = 'Thesis of selected student(s) have been approved?';
					}else if (pg_environ.sm.value == '27f')
					{
						msg = 'Selected students have defended their thesis successfully?';
					}else if (pg_environ.sm.value == '27g')
					{
						msg = 'Selected students have been awarded degree successfully?';
					}
					
					msg = ' Candidates enabled unchecked boxes may result in reversal of already taken action for such candidates<br>'+msg;
					confirm_box_loc(msg);
					return false;
				}else if (pg_environ.sm.value == 22 && pg_environ.conf2.value != '1')
				{
					_("msg_composer").style.display = 'block';
					_("msg_composer").style.zIndex = 5;
					_("general_smke_screen_loc").style.display = 'block';
					_("general_smke_screen_loc").style.zIndex = 4;
					return false;
				}else
				{
					if (pg_environ.sm.value == 20 || pg_environ.sm.value == 21 || pg_environ.sm.value == 22 || pg_environ.sm.value == 23  || pg_environ.sm.value == 24 || pg_environ.sm.value == 25 || pg_environ.sm.value == 26 || pg_environ.sm.value == 28 || (pg_environ.sm.value.length == 3 && isNaN(pg_environ.sm.value.substr(2,1))))//fwd to dept, retreive, iv
					{
						var ulChildNodes = _("all_chk_box").getElementsByTagName("input");
						for (j = 0; j <= ulChildNodes.length-1; j++)
						{
							if (ulChildNodes[j].type == 'checkbox' && ulChildNodes[j].checked && !ulChildNodes[j].disabled && ulChildNodes[j].id.indexOf("afn") != -1)
							{
								formdata.append(ulChildNodes[j].id, ulChildNodes[j].value);
								
								var box_check = 'box_check_'+ulChildNodes[j].id.substr(4);

								formdata.append(box_check, _(box_check).value);
							}
						}
					}
					
					if (pg_environ.sm.value == 22)
					{						
						formdata.append("msg_subject", _("msg_subject").value);
						formdata.append("msg_body", _("msg_body").value);
						formdata.append("msg_date", _("msg_date").value);
						formdata.append("msg_time", _("msg_time").value);
						formdata.append("msg_venue", _("msg_venue").value);
					}

					formdata.append("conf", 1);
					
					formdata.append("number_of_boxes", ulChildNodes.length);
				}
			}
				
			formdata.append("ilin", nxt.ilin.value);
			formdata.append("user_cat", nxt.user_cat.value);
			formdata.append("vApplicationNo", nxt.vApplicationNo.value);
			formdata.append("sm", nxt.sm.value);
			formdata.append("mm", nxt.mm.value);
			formdata.append("staff_study_center", nxt.user_centre.value);

			opr_prep(ajax = new XMLHttpRequest(),formdata);
		}


		function completeHandler(event)
		{
			on_error('0');
			on_abort('0');
			in_progress('0');
			
			var returnedStr = event.target.responseText;
			
			
			if ((_("new_esminar_div") && _("new_esminar_div").style.display == 'block') || (_("new_sup_div") && _("new_sup_div").style.display == 'block'))
			{
				success_box_loc(returnedStr); 
			}else if (returnedStr.trim() != '')
			{
				success_box(returnedStr); 
			
				var ulChildNodes = _("rtlft_std").getElementsByTagName("input");
				for (j = 0; j <= ulChildNodes.length-1; j++)
				{
					if (ulChildNodes[j].type == 'checkbox' && ulChildNodes[j].checked)
					{
						ulChildNodes[j].disabled = true;

						if (ulChildNodes[j].id.indexOf("afn") == -1)
						{
							ulChildNodes[j].checked = false;
							ulChildNodes[j].disabled = false;
						}
					}
				}

				pg_environ.conf.value = '';
			}
		}


		function opr_prep(ajax,formdata)
		{
			ajax.upload.addEventListener("progress", progressHandler, false);
			ajax.addEventListener("load", completeHandler, false);
			ajax.addEventListener("error", errorHandler, false);
			ajax.addEventListener("abort", abortHandler, false);
			
			ajax.open("POST", "opr_pg_environ.php");
			ajax.send(formdata);
		}

		function progressHandler(event)
		{
			if (_("new_sup_div") && _("new_sup_div").style.display == 'block')
			{
				_("new_sup_div").style.zIndex = '5';
			}else if (_("new_esminar_div") && _("new_esminar_div").style.display == 'block')
			{
				_("new_esminar_div").style.zIndex = '5';
			}
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

		function set_other_box(caller, box_grp)
		{
			var ulChildNodes = _("rtlft_std").getElementsByTagName("input");
			for (j = 0; j <= ulChildNodes.length-1; j++)
			{
				if (ulChildNodes[j].type == 'checkbox' && !ulChildNodes[j].disabled)
				{
					if (ulChildNodes[j].name.indexOf(box_grp) != -1 && ulChildNodes[j].name != caller)
					{
						ulChildNodes[j].checked = _(caller).checked;
					}
				}
			}
			
		}


		function confirm_box_loc(msg)
		{
			_("general_smke_screen_loc").style.display = 'block';
			_("general_smke_screen_loc").style.zIndex = '5';

			_("submityes_msg_1").innerHTML = msg;

			_("submityes").style.display = 'block';
			_("submityes").style.zIndex = '6';
		}


		function caution_box_loc(msg)
		{
			_("general_smke_screen_loc").style.display = 'block';
			_("general_smke_screen_loc").style.zIndex = '5';

			_("general_caution_msg_msg_loc").innerHTML = msg;

			_("general_caution_box_loc").style.display = 'Block';
			_("general_caution_box_loc").style.zIndex = '6';
		}


		function success_box_loc(msg)
		{
			_("general_smke_screen_loc").style.display = 'block';
			_("general_smke_screen_loc").style.zIndex = '5';
			
			_("general_success_box_loc").style.display = 'Block';
			_("general_success_box_loc").style.zIndex = '6';

			if ((_("new_esminar_div") && _("new_esminar_div").style.display == 'block') || (_("new_sup_div") && _("new_sup_div").style.display == 'block'))
			{
				_("general_smke_screen_loc").style.zIndex = '7';
				_("general_success_box_loc").style.zIndex = '8';
			}
			_("general_success_msg_msg_loc").innerHTML = msg;
		}

</script><?php

require_once ('set_scheduled_dates.php');
require_once('staff_detail.php');?>
<!-- InstanceEndEditable -->
</head>
<body onLoad="checkConnection()"><?php
	$z_index = "display:none; z-index:-1";
	if (isset($_REQUEST["mm"]) && $_REQUEST["mm"] == '8' && isset($_REQUEST["sm"]) && $_REQUEST["sm"] <> '')
	{
		$z_index = "display:block; z-index:2";
		if (!is_bool(strpos($_REQUEST["sm"],'27')) && isset($_REQUEST["uvApplicationNo"]) &&$_REQUEST["uvApplicationNo"] <> '')
		{
			$z_index = "display:block; z-index:4";
		}
	}?>
	<div id="general_smke_screen_loc" class="smoke_scrn" style="display:none; <?php echo $z_index;?>"></div>
    <?php admin_frms(); $has_matno = 0;?>
    
    <form action="staff_home_page" method="post" name="nxt" id="nxt" enctype="multipart/form-data">
		<input name="uvApplicationNo" id="uvApplicationNo" type="hidden" value="" />
		<input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
		<input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST['vMatricNo'])){echo $_REQUEST['vMatricNo']; }?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
		<input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="currency" id="currency" type="hidden" value="<?php if (isset($_REQUEST["currency"])){echo $_REQUEST["currency"];} ?>" />
		
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
	</form>
	
	<form action="../appl/preview-form" method="post" target="_blank" name="m_frm" id="m_frm" enctype="multipart/form-data">
		<input name="uvApplicationNo" id="uvApplicationNo" type="hidden" value="" />
		<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
		<input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />	
		<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
		<input name="sm" id="sm" type="hidden" value="<?php echo $sm ?>" />
		<input name="mm" id="mm" type="hidden" value="<?php echo $mm ?>" />
		<input name="save_cf" id="save_cf" type="hidden" value="-1" />
		<input name="conf" id="conf" type="hidden" value="" />
		<input name="see_frm" id="see_frm" type="hidden" value="1" />
		<input name="currency_cf" id="currency_cf" type="hidden" value="<?php if (isset($_REQUEST["currency"])){echo $_REQUEST["currency"];} ?>" />
		<input name="internalchk" id="internalchk" type="hidden" value="1" />
		<input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />
		
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
		<input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u;?>" />
	</form><?php
	//include ('msg_service.php');?>
	
	<!-- InstanceBeginEditable name="nakedbody" -->
		<!-- <div id="container_cover_constat" style="display:none"></div> -->
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
		
		<!-- <div id="container_cover_constat" class="smoke_scrn" style="display:none"></div> -->
	<!-- InstanceEndEditable -->
<div id="container"><?php
	//time_out_box($currency);?>
	
	<form method="post" name="iv_msg" id="iv_msg" enctype="multipart/form-data" onsubmit="return false">
		<div id="msg_composer" class="center" style="display:none; width:40vw; text-align:center; padding:15px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; z-index:3">
			<div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
				Interview invitation
			</div>
			<a href="#" style="text-decoration:none;">
				<div style="width:20px; float:left; text-align:center; padding:0px; float:right">
					<img style="width:17px; height:17px; cursor:pointer" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" 
						onclick="_('msg_composer').style.zIndex = '-1';
						_('msg_composer').style.display='none';
						_('general_smke_screen_loc').style.zIndex = '-1';
						_('general_smke_screen_loc').style.display = 'none';
						pg_environ.conf.value = '';
						pg_environ.conf2.value = '';
						return false"/>
				</div>
			</a>
			<div id="submityes0" 
				style="border-radius:3px; margin:auto; margin-top:30px; margin-bottom:5px; height:auto; width:99%; text-align:center; padding:15px 0px 15px 0px; background:#f1f1f1">
				<!--<div style="width:auto; margin:auto; margin-bottom:5px; padding:0px; width:95%; float:none; line-height:2.0;">
					Check your official e-mail in-box for a token to use for this session<br>Token expires in 60minutes
				</div>-->
				<div style="margin:auto; margin-top:5px; height:auto; text-align:left; padding:0px; width:99%;">
					Subject<br><br>
					<input name="msg_subject" id="msg_subject" type="text" class="textbox" placeholder="Subject of message" 
						style="float:none; 
						width:98%; 
						padding:5px; 
						height:25px; 
						border:none"
						required/>
					<div id="labell_msg_1" class="labell_msg blink_text orange_msg" style="float:none; text-align:center; display:none; width:50%; margin:auto; margin-top:10px;"></div>
				</div>
				<div style="margin:auto; margin-top:10px; height:auto; text-align:left; padding:0px; width:99%;">
					Body of message<br><br>
					<textarea name="msg_body" id="msg_body" rows="5" class="textbox" placeholder="Enter body of message here" 
						style="float:none; 
						width:98%; 
						padding:5px; 
						border:none;"
						required></textarea>
					<div id="labell_msg_2" class="labell_msg blink_text orange_msg" style="float:none; text-align:center; display:none; width:50%; margin:auto; margin-top:10px;"></div>
				</div>
				<div style="margin:auto; margin-top:10px; height:auto; text-align:left; padding:0px; width:99%;">
					Date<br><br>
					<input name="msg_date" id="msg_date" type="date" class="textbox" placeholder="Date of interview" 
						style="float:none; 
						width:98%; 
						padding:5px; 
						height:25px; 
						border:none;"
						required/>
					<div id="labell_msg_2" class="labell_msg blink_text orange_msg" style="float:none; text-align:center; display:none; width:50%; margin:auto; margin-top:10px;"></div>
				</div>
				<div style="margin:auto; margin-top:10px; height:auto; text-align:left; padding:0px; width:99%;">
					Time<br><br>
					<input name="msg_time" id="msg_time" type="time" class="textbox" placeholder="Set time of interview" 
						style="float:none; 
						width:98%; 
						padding:5px; 
						height:25px; 
						border:none;"
						required/>
					<div id="labell_msg_3" class="labell_msg blink_text orange_msg" style="float:none; text-align:center; display:none; width:50%; margin:auto; margin-top:10px;"></div>
				</div>
				<div style="margin:auto; margin-top:10px; height:auto; text-align:left; padding:0px; width:99%;">
					Venue<br><br>
					<input name="msg_venue" id="msg_venue" type="text" class="textbox" placeholder="Venue of interview" 
						style="float:none; 
						width:98%; 
						padding:5px; 
						height:25px; 
						border:none;"
						required/>
					<div id="labell_msg_4" class="labell_msg blink_text orange_msg" style="float:none; text-align:center; display:none; width:50%; margin:auto; margin-top:10px;"></div>
				</div>
				
				<div style="margin:auto; margin-top:20px; height:auto; text-align:left; padding:0px; width:99%;">
					<button type="submit" class="submit_button_green middle_std_btns" 
						style="border-radius:3px; margin-right:0px;; cursor:pointer"
						onclick="pg_environ.conf2.value = '1';chk_inputs();">Send</button>
				</div>
			</div>
		</div>
	</form>

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

	<div id="leftSide_std"><?php
		require_once ('stff_left_side_menu.php');?>
	</div>
	<div id="rtlft_std" style="position:relative;">
		<div id="general_caution_box_loc" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
			<div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
				Caution
			</div>
			<a href="#" style="text-decoration:none;">
				<div style="width:20px; float:left; text-align:center; padding:0px;"></div>
			</a>
			<div id="general_caution_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#6b6b6b;"></div>
			<div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
				<a href="#" style="text-decoration:none;" 
					onclick="if(_('fwd_app_div').style.display=='block')
					{
						_('general_smke_screen_loc').style.display= 'block';
						_('general_smke_screen_loc').style.zIndex= '2';
					}else
					{
						_('general_smke_screen_loc').style.display= 'none';
						_('general_smke_screen_loc').style.zIndex= '-1';
					}
					_('general_caution_box_loc').style.display='none';
					_('general_caution_box_loc').style.zIndex='-1';
					return false">
					<div class="submit_button_brown" style="width:60px; padding:6px; float:right">
						Ok
					</div>
				</a>
			</div>
		</div>


		<div id="general_success_box_loc" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:3">
			<div style="width:350px; float:left; text-align:left; padding:0px; color:#36743e; font-weight:bold">
				Information
			</div>
			<a href="#" style="text-decoration:none;">
				<div id="msg_title_loc" style="width:20px; float:left; text-align:center; padding:0px;"></div>
			</a>
			<div id="general_success_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#36743e;"></div>
			<div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
				<a href="#" style="text-decoration:none;" 
					onclick="if(_('fwd_app_div').style.display=='block' && _('new_esminar_div') && _('new_esminar_div').style.display == 'none' && _('new_sup_div') && _('new_sup_div').style.display == 'none')
					{
						_('general_smke_screen_loc').style.display= 'block';
						_('general_smke_screen_loc').style.zIndex= '2';
					}else if ((_('new_esminar_div') && _('new_esminar_div').style.display == 'block') || (_('new_sup_div') &&  _('new_sup_div').style.display == 'block'))
					{
						_('general_smke_screen_loc').style.display= 'block';
						_('general_smke_screen_loc').style.zIndex= '4';

						if (_('new_esminar_div').style.display == 'block')
						{
							_('new_esminar_div').style.display = 'none'
							_('new_esminar_div').style.zIndex= '-1';
						}else if (_('new_sup_div').style.display == 'block')
						{
							_('new_sup_div').style.display = 'none'
							_('new_sup_div').style.zIndex= '-1';
						}
					}else
					{
						_('general_smke_screen_loc').style.display= 'none';
						_('general_smke_screen_loc').style.zIndex= '-1';
					}
					_('general_success_box_loc').style.display= 'none';
					_('general_success_box_loc').style.zIndex= '-1';
					return false">
					<div class="submit_button_home" style="width:60px; padding:6px; float:right">
						Ok
					</div>
				</a>
			</div>
		</div>


		<div id="submityes" class="center" 
			style="display:none; 
			width:300px;
			text-align:center; 
			padding:10px; 
			line-height:1.6; 
			box-shadow: 4px 4px 8px 5px #726e41; 
			background:#FFFFFF">
			<div id="submityes_msg" style="width:inherit; float:left; height:auto; text-align:left; padding:3px; color:#bf2323">
				Confirmation
			</div>
			<div id="submityes_msg_1" 
				style="width:inherit; 
				float:left; 
				height:auto; 
				text-align:center; 
				padding:3px; 
				margin-top:5px; 
				margin-bottom:10px;">
				Are you sure you want to proceed ?
			</div>
			
			<a href="#" style="text-decoration:none;" 
				onclick="pg_environ.conf.value='1';
				_('submityes').style.display = 'none';
				_('submityes').style.zIndex = '-1';
				if(_('fwd_app_div').style.display=='block')
				{
					_('general_smke_screen_loc').style.display='block';
					_('general_smke_screen_loc').style.zIndex='2';
				}else
				{
					_('general_smke_screen_loc').style.display='none';
					_('general_smke_screen_loc').style.zIndex='-1';
				}
				chk_inputs();
				return false">
				<div class="submit_button_green" style="width:60px; padding:2px; float:right">
					Yes
				</div>
			</a>

			<a href="#" style="text-decoration:none;" 
				onclick="pg_environ.conf.value='0';
				_('submityes').style.display='none';
				_('submityes').style.zIndex = '-1';
				if(_('fwd_app_div').style.display=='block' && !_('general_smke_screen_loc'))
				{
					_('general_smke_screen_loc').style.display='block';
					_('general_smke_screen_loc').style.zIndex='2';
				}else if (_('mgt_esminar_div') && _('mgt_esminar_div').style.display == 'block')
				{
					_('general_smke_screen_loc').style.display = 'block';
					_('general_smke_screen_loc').style.zIndex = '4';
				}else
				{
					_('general_smke_screen_loc').style.display='none';
					_('general_smke_screen_loc').style.zIndex='-1';
				}
				return false">
				<div class="submit_button_brown_reverse" style="width:60px; padding:2px; margin-right:4px; float:right">
					No
				</div>
			</a>
		</div>

		<!-- InstanceBeginEditable name="EditRegion6" --><?php
			if (isset($_REQUEST['contactus']) && $_REQUEST['contactus'] <> '')
			{
				require_once ('msg_service.php');
			}else
			{
				$add_title = '';
                if ($sm == 20)
                {
                    $add_title = ' - Forward applications...';
                }else if ($sm == 21)
                {
                    $add_title = ' - Retrieve Forwarded application(s)';
                }else if ($sm == 22)
                {
                    $add_title = ' - Send invitation for interview';
                }else if ($sm == 23)
                {
                    $add_title = ' - Interview Status';
                }else if ($sm == 24)
                {
                    $add_title = ' - Forward interview report to SPGS';
                }else if ($sm == 25)
                {
                    $add_title = ' - Send admission letter...';
                }else if ($sm == 26)
                {
                    $add_title = ' - Screen admitted candidates';
                }else if ($sm == '27a')
                {
                    $add_title = ' - Seminar topics';
                }else if ($sm == '27b')
                {
                    $add_title = ' - Thesis proposal';
                }else if ($sm == '27c')
                {
                    $add_title = ' - Pre-field proposal defence';
                }else if ($sm == '27d')
                {
                    $add_title = ' - Post-field defence';
                }else if ($sm == '27e')
                {
                    $add_title = ' - Approval of thesis';
                }else if ($sm == '27f')
                {
                    $add_title = ' - Defence of thesis';
                }else if ($sm == '27g')
                {
                    $add_title = ' - Award of degree';
                }?>
				<div class="innercont_top">My Home Page<?php echo $add_title;?></div>
				
				<div class="innercont_stff" style="font-size:11px; line-height:1.3; text-align:center; display:none"><?php
					$stmt = $mysqli->prepare("SELECT * FROM messages a, userlogin c 
					WHERE a.receiver_id = c.cphone
					AND c.vApplicationNo = ?
					AND in_box = '1'
					AND opened = '0'");
					$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
					$stmt->execute();
					$stmt->store_result();
					$waiting_mail = $stmt->num_rows;
					$stmt->close();
					if (isset($_REQUEST['contactus']) && $_REQUEST['contactus'] <> '')
					{?>
						<a id="basic_three" href="#" style="text-decoration:none; margin:0px;" onclick="return false">
							<div class="basic_three_white" style="padding-top:3px; position:relative;">
								Mail
								<div id="mail_waiting_cnt" style="background:#f03535; color:#FFFFFF; width:auto; height:auto; padding:2px; position:absolute; top:-5px; right:12px;">
									<?php echo $waiting_mail;?>
								</div>
							</div>
						</a><?php
					}else
					{?>
						<a id="basic_three" href="#" style="text-decoration:none; margin:0px;" 
							onclick="if(centre_select())
							{
								nxt.mm.value='';
								nxt.contactus.value=1;
								nxt.submit();
								rt_scrn_clr();}
							return false">
							<div class="basic_three" style="padding-top:3px; position:relative;">
								Mail
								<div id="mail_waiting_cnt" style="background:#f03535; color:#FFFFFF; width:auto; height:auto; padding:2px; padding-top:0px; text-align:center; position:absolute; top:-5px; right:12px;">
									<?php echo $waiting_mail;?>
								</div>
							</div>
						</a><?php
					}?>
				</div><?php

				require_once("pg_menu.php");

				$sql_cond = "((cProgrammeId LIKE '___3%' OR cProgrammeId LIKE '___4%'  OR cProgrammeId LIKE '___5%'  OR cProgrammeId LIKE '___6%') AND cAcademicDesc = '".$orgsetins["cAcademicDesc"]."' AND semester_reg = '1')";
				
				$sql = "SELECT count(*) FROM s_m_t WHERE $sql_cond AND cAcademicDesc = '".$orgsetins["cAcademicDesc"]."'";
				$rsql_0 = mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));
				$std_count_0 = mysqli_fetch_array($rsql_0);
				mysqli_close(link_connect_db());

				$cn = 0;

				$row_start = 0;
				$sql = "SELECT cFacultyId, vFacultyDesc FROM faculty WHERE cCat = 'A' AND cFacultyId NOT IN ('DEG','CHD') AND cDelFlag = 'N' ORDER BY cFacultyId";
				$rsql = mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));
				while ($table= mysqli_fetch_array($rsql))
				{
					$cn++;
					$right_margin = "";
					if ($cn%4 > 0)
					{
						$right_margin = "margin-right:2.3%; ";
						$row_start = 0;
					}

					$left_margin = "";
					if ($row_start == 0)
					{
						$left_margin = "margin-left:0.5%; ";
					}

					$row_start++;

					$colo = '';
					if ($table["cFacultyId"] == 'AGR')
					{
						$colo = '#159938';
					}else if ($table["cFacultyId"] == 'ART')
					{
						$colo = '#188bb1';
					}else if ($table["cFacultyId"] == 'EDU')
					{
						$colo = '#d6871d';
					}else if ($table["cFacultyId"] == 'HSC')
					{
						$colo = '#e02b20';
					}else if ($table["cFacultyId"] == 'LAW')
					{
						$colo = '#e09900';
					}else if ($table["cFacultyId"] == 'MSC')
					{
						$colo = '#1ed2d8';
					}else if ($table["cFacultyId"] == 'SCI')
					{
						$colo = '#e02b20';
					}else if ($table["cFacultyId"] == 'SSC')
					{
						$colo = '#7cda24';
					}

					$sql = "SELECT count(*) FROM s_m_t WHERE $sql_cond AND cFacultyId = '".$table["cFacultyId"]."' AND cAcademicDesc = '".$orgsetins["cAcademicDesc"]."' AND semester_reg = '1'";
					$rsql_1 = mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));			
					$std_count = mysqli_fetch_array($rsql_1);
					mysqli_close(link_connect_db());
					
					$sql = "SELECT count(*) FROM depts WHERE cFacultyId = '".$table["cFacultyId"]."' AND cDelFlag = 'N'";
					$rsql_2 = mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));
					$std_count_3 = mysqli_fetch_array($rsql_2);
					mysqli_close(link_connect_db());?>
					
					<div class="innercont_stff home_pg_pg_fac_dist" 
						style="<?php echo $left_margin.$right_margin;?>">
						<?php echo '<b>'.$table["vFacultyDesc"].'</b><p>'.
						'Departments<br>'.
						$std_count_3[0].'<p>Active Students<br>'.
						$std_count[0].'<br>';
						if ($std_count_0[0] > 0)
						{
							echo round((($std_count[0]/$std_count_0[0])*100),1).'%';
						}else
						{
							echo '0%';
						}?>
					</div><?php
				}
				mysqli_close(link_connect_db());?>
				
				<div class="innercont_stff home_pg_pg_fac_dist" 
					style="background-color:#f6faf7;
					margin-left:0.5%;">
					Total active student<br><?php
					echo $std_count_0[0];?>
				</div><?php
			}?>
		<!-- InstanceEndEditable -->
	</div><?php
	

	if (isset($_REQUEST["sm"]))
	{
		require_once("forward_pg_apps.php");
	}?>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
				<img name="passprt" id="passprt" src="<?php echo get_pp_pix('');?>" width="95%" height="185"  
				style="margin:0px;" alt="" />
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