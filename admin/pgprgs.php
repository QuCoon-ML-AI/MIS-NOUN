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

	// function preventBack(){window.history.forward();}
	// 	setTimeout("preventBack()", 0);
	// 	window.onunload=function(){null};		
		
		function chk_inputs()
		{
			for (j = 0; j <= 5; j++)
			{
				if (_('labell_msg_mail_'+j))
				{
					_('labell_msg_mail_'+j).style.display = 'none';
				}
			}

			if (_("msg_to").value == '')
			{
				setMsgBox("labell_msg_mail_0","");
				_("msg_to").focus();
				return false;
			}

			if (_("msg_to").value == _("sender_id").value)
			{
				setMsgBox("labell_msg_mail_0"," Sender and receiver cannot be the same");
				_("msg_to").focus();
				return false;
			}			

			var last_dig = _('msg_to').value.substr(_('msg_to').value.length-1,1);
			if (_('msg_to').value.length != 12 || 
			(_('msg_to').value.length == 12 && last_dig.indexOf("4") == -1 && last_dig.indexOf("5") == -1 && last_dig.indexOf("6") == -1))
			{
				_('succ_boxt_mail').className = 'succ_box orange_msg center';
				_('succ_boxt_mail').innerHTML = 'Type the first 4-7 digits of phone number of recipient and select correct entry from the dropdown options';
				_('succ_boxt_mail').style.display = 'block';
				return false;
			}

			if (_("msg_sbjt").value.trim() == '')
			{
				setMsgBox("labell_msg_mail_3","");
				_("msg_sbjt").focus();
				return false;
			}

			if (_("msg_msg").value.trim() == '')
			{
				setMsgBox("labell_msg_mail_4","");
				_("msg_msg").focus();
				return false;
			}
			
			var formdata = new FormData();
			
			formdata.append("vApplicationNo", wlcm_staff_frm.vApplicationNo.value);

			formdata.append("user_id", wlcm_staff_frm.vApplicationNo.value);
			formdata.append("msg_sbjt", _('msg_sbjt').value);
			formdata.append("msg_msg", _('msg_msg').value);
			formdata.append("sender_id", _('sender_id').value);
			
		  	formdata.append("user_cat", wlcm_staff_frm.user_cat.value);
		
			if (_('what').value != 'o')
			{
				formdata.append("user_cat_of_reciever", _('msg_to').value.substr(_('msg_to').value.length-1,1));
				_('msg_to').value = _('msg_to').value.substr(0, _('msg_to').value.length-1);
			}
			formdata.append("receiver_id", _('msg_to').value);
			
			formdata.append("what", _('what').value);
			
			formdata.append("currency", wlcm_staff_frm.currency.value);
			
			opr_prep(ajax = new XMLHttpRequest(),formdata);
		}

		function completeHandler(event)
		{
			_("succ_boxt_mail").style.display = 'none';

			var returnedStr = event.target.responseText;
			
			if (returnedStr.indexOf("not") != -1)
			{
				if (returnedStr.indexOf("Receiver") != -1)
				{
					setMsgBox("labell_msg_mail_0","Number not found");
					_("msg_to").focus();
				}else
				{
					_('succ_boxt_mail').className = 'succ_box orange_msg center';
					_('succ_boxt_mail').innerHTML = 'Processing request, please...wait';
					_('succ_boxt_mail').style.display = 'block';
				}
			}else if (_('what').value == 'o')
			{			
				_('succ_boxt_mail').style.display = 'none';
				_('succ_boxt_mail').className = 'succ_box green_msg center';
				_('succ_boxt_mail').innerHTML = '';
			}else if (_('what').value == 'r' || _('what').value == 'cm' || _('what').value == 'f' || _('what').value == 'd' || _('what').value == 'ds')
			{
				if (_("ans0").style.display == 'block')
                {
                    var count_limit = _('tot_num_of_mails').value;
                }else
                {
                    var count_limit = _('tot_num_of_mails_sent').value;
                }
                
                for (i = 1; i < count_limit; i++)
				{
					// var msg_read = 'msg_read' + i;

					// var msg_del = 'msg_del' + i;
					// var msg_archy = 'msg_archy' + i; 
					// var msg_forward = 'msg_forward' + i; 
					var msg_reply = 'msg_reply' + i;

					if (_(msg_reply))
					{
						// _(msg_del).style.display = 'none';
						// _(msg_archy).style.display = 'none';
						// _(msg_forward).style.display = 'none';
						_(msg_reply).style.display = 'none';
					}
				}

				_('succ_boxt_mail').className = 'succ_box green_msg center';
				_('succ_boxt_mail').innerHTML = returnedStr;
				_('succ_boxt_mail').style.display = 'block';
			}
			_('what').value = '';
		}

		function opr_prep(ajax,formdata)
		{
			ajax.upload.addEventListener("progress", progressHandler, false);
			ajax.addEventListener("load", completeHandler, false);
			ajax.addEventListener("error", errorHandler, false);
			ajax.addEventListener("abort", abortHandler, false);
			
			ajax.open("POST", "opr_send_mail.php");
			ajax.send(formdata);
		}

		function progressHandler(event)
		{
			_('succ_boxt_mail').className = 'succ_box orange_msg center';
			_('succ_boxt_mail').innerHTML = 'Processing request, please...wait';
			_('succ_boxt_mail').style.display = 'block';
		}

		function errorHandler(event)
		{
			_('succ_boxt_mail').className = 'succ_box orange_msg center';
			_('succ_boxt_mail').innerHTML = 'Your internet connection was interrupted. Please try again';
			_('succ_boxt_mail').style.display = 'block';
		}
		
		function abortHandler(event)
		{
			_('succ_boxt_mail').className = 'succ_box orange_msg center';
			_('succ_boxt_mail').innerHTML = 'Process aborted';
			_('succ_boxt_mail').style.display = 'block';
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
			
			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div><?php
			if (isset($_REQUEST['contactus']) && $_REQUEST['contactus'] <> '')
			{
				require_once ('msg_service.php');
			}else if ($currency == '1')
            {?>
				<div class="innercont_top"><?php nav_text($sm);?></div>
				<div id="succ_boxt" class="succ_box blink_text orange_msg"></div>
				
				<form action="edit-criterion" method="post" name="e_crit" enctype="multipart/form-data"><?php frm_vars();?></form>
				<form action="programs-by-category" method="post" name="pgprg" enctype="multipart/form-data">
					<input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
					<input name="frm_upd" id="frm_upd" type="hidden" value="0" />
					
					<input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId_u ?>" />
					<input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdeptId_u ?>" />
					<?php frm_vars();?>
					
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

					<div class="innercont_stff">
						<label for="cFacultyId1" class="labell">Faculty</label>
						<div class="div_select"><?php
							$sql = "SELECT cFacultyId, vFacultyDesc FROM faculty WHERE cCat = 'A' AND cFacultyId <> 'CEG' AND cDelFlag = 'N' ORDER BY cFacultyId";
							$rsql = mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));?>
							<select name="cFacultyId1" id="cFacultyId1" class="select" 
								onchange="update_cat_country('cFacultyId1', 'cdeptId_readup', 'cdept1', 'cdept1');">
								<option>Select a faculty</option><?php
								while ($table= mysqli_fetch_array($rsql))
								{?>
									<option value="<?php echo $table['cFacultyId'] ?>" <?php 
									if ($sRoleID_u == '6'){
										if (isset($_REQUEST['cFacultyId1']) && $_REQUEST['cFacultyId1']  <> ''){
											if ($table["cFacultyId"] == $_REQUEST['cFacultyId1']){echo ' selected';}
										}
									}else{
										if ($cFacultyId_u == $table["cFacultyId"]){echo ' selected';}
									}?>><?php echo $table['vFacultyDesc'] ;?></option><?php
								}
                                mysqli_close(link_connect_db());?>
							</select>
						</div>
						<div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
					</div>
					
					<div class="innercont_stff">
						<label for="cdept1" class="labell">Department</label>
						<div class="div_select"><?php
							if ($sRoleID_u == '6' && isset($_REQUEST['cFacultyId1']) && $_REQUEST['cFacultyId1'] <> '')
							{
								$sql1 = "select cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc 
								from depts where cFacultyId = '".$_REQUEST['cFacultyId1']."' order by vdeptDesc";
							}else
							{
								$sql1 = "select cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc 
								from depts where cFacultyId = '$cFacultyId_u' order by vdeptDesc";
							}
							
													
							$rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
							<select name="cdept1" id="cdept1" class="select" 
								onchange="if(this.value!=''&&cFacultyId1.value!=''&&prog_cat1.value!=''){e_crit.vdeptDesc.value=this.options[this.selectedIndex].text;pgprg.submit()}">
								<option></option><?php
									while ($table= mysqli_fetch_array($rsql1))
									{?>
										<option value="<?php echo $table[0] ?>"<?php 
											if ($sRoleID_u == '6'){
												if (isset($_REQUEST['cdept1']) && $_REQUEST['cdept1']  <> ''){
													if ($table["cdeptId"] == $_REQUEST['cdept1']){echo ' selected';}
												}
											}else{
												if ($cdeptId_u == $table["cdeptId"]){echo ' selected';}
											}?>>
										<?php echo $table['vdeptDesc'];?>
										</option><?php
									}
									mysqli_close(link_connect_db());?>
							</select>
						</div>
						<div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
					</div>
					
					<div class="innercont_stff" style="margin-bottom:4px;">
						<label for="prog_cat1" class="labell">Category of programme</label>
						<div class="div_select"><?php						
							$sql = "SELECT DISTINCT cEduCtgId, vEduCtgDesc 
							FROM educationctg
							WHERE LENGTH(vEduCtgDesc) > 3
							AND cEduCtgId IN ('PSZ','PGY','PGX')
							ORDER BY vEduCtgDesc";

							$rssqlEduCtgId = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));?>
							<select name="prog_cat1" id="prog_cat1" class="select" 
								onchange="if(this.value!=''&&cFacultyId1.value!=''&&cdept1.value!=''){pgprg.submit()}">
								<option value="" selected></option><?php
								$cnt = 0;
								while ($r_rssqlEduCtgId = mysqli_fetch_assoc($rssqlEduCtgId))
								{
									if ($cnt%5 == 0)
									{?>
										<option disabled></option><?php
									}?>?>
									<option value="<?php echo $r_rssqlEduCtgId['cEduCtgId']?>" <?php if (isset($_REQUEST['prog_cat1']) && $_REQUEST['prog_cat1'] == $r_rssqlEduCtgId['cEduCtgId']){echo ' selected';}?>><?php echo ucwords(strtolower($r_rssqlEduCtgId['vEduCtgDesc'])); ?></option><?php
									$cnt++;
								}
                                mysqli_close(link_connect_db());?>
							</select>
						</div>
						<div class="labell_msg blink_text orange_msg"></div>
					</div><?php

					if (isset($_REQUEST['cFacultyId1']) && isset($_REQUEST['cdept1']) && isset($_REQUEST['prog_cat1']))
					//if ($cFacultyId <> ''  && $cdept <> '' && $prog_cat <> '')
					{
						$stmt = $mysqli->prepare("SELECT p.cProgrammeId, o.vObtQualTitle, p.vProgrammeDesc, f.vFacultyDesc, d.vdeptDesc
						FROM obtainablequal o, programme p, depts d, faculty f
						WHERE p.cObtQualId = o.cObtQualId 
						AND p.cdeptId = d.cdeptId 
						AND f.cFacultyId = d.cFacultyId  
						AND f.cFacultyId = ?
						AND d.cdeptId = ?
						AND p.cEduCtgId = ?
						AND p.cDelFlag = 'N'
						ORDER BY p.cProgrammeId");

						if ($sRoleID_u == '6' && isset($_REQUEST['cFacultyId1']) && $_REQUEST['cFacultyId1'] <> '')
						{
							$stmt->bind_param("sss", $_REQUEST['cFacultyId1'], $_REQUEST['cdept1'], $_REQUEST['prog_cat1']);
						}else
						{
							$stmt->bind_param("sss", $cFacultyId_u, $cdeptId_u, $_REQUEST['prog_cat1']);
						}
						$stmt->execute();
						$stmt->store_result();							
						$stmt->bind_result($cProgrammeId, $vObtQualTitle, $ProgrammeDesc, $FacultyDesc, $deptDesc);
						
						
						//if (mysqli_num_rows($rssqlprograms) > 0)
						if ($stmt->num_rows > 0)
						{?>
							<div class="innercont_stff" style="width:1302px; font-weight:bold;">
								<div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; padding-right:3px; text-align:right; width:5%">Sno</div>
								
								<div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; width:<?php if ($sm == '4'){?> 40% <?php }else {?>56.9%; <?php }?>; text-align:left; text-indent:2px">Programmes</div><?php
								if ($sm == '4'){?>
									<div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; width:5%; text-align:left; text-indent:2px">
									</div><?php
								}?>
								
								<div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:12%; padding-right:3px;">Submitted form</div>
								
								<div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:12%; padding-right:3px;">Screened</div>
								
								<div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:12.2%; padding-right:3px;">Pending</div>
							</div><?php

							$cnt = 0;$acnt = 0;$bcnt = 0;$ccnt = 0; $dcnt = 0;?>									
							<div class="innercont_stff" style="height:398px; width:100%; padding:0px; overflow:scroll; overflow-x: hidden;"><?php
								while ($stmt->fetch())
								{
									$cnt++;
									if ($cnt%2==0){$background_color = '#FFFFFF';}else{$background_color = '#eaeaea';}?>
									<label class="lbl_beh">
										<div class="innercont_stff" style="width:1302px;">
											<div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; padding-right:3px; text-align:right; width:5%">
												<?php echo $cnt;?>
											</div>
									
											<div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; margin-left:-1px; width:<?php if ($sm == '4'){?> 40% <?php }else {?>56.9%; <?php }?>; text-align:left; text-indent:2px">
												<?php echo $vObtQualTitle.' '.$ProgrammeDesc; 
												if ($sm == '4')
												{?>
													<a href="#" onclick="
														gln.ac.value='';
														gln.ec.value='';
														gln.dc.value='';												
														gln.aq.value='';
														gln.eq.value='';
														gln.dq.value='';												
														gln.as.value='';
														gln.es.value='';
														gln.ds.value='';
														gln.das.value='';												
														gln.en.value='';
														gln.dis.value='';
														gln.admt.value='';
														gln.conf.value='';
														gln.sbjlist.value='';
														gln.vFacultyDesc.value='<?php echo $FacultyDesc; ?>';
														gln.vdeptDesc.value='<?php echo $deptDesc; ?>';
														gln.vObtQualTitle.value='<?php echo $vObtQualTitle; ?>';
														gln.cEduCtgId.value='<?php echo $prog_cat;?>';
														gln.cProgrammeId.value='<?php echo $cProgrammeId; ?>';
														gln.vProgrammeDesc.value='<?php echo $ProgrammeDesc; ?>';
														gln.admt.value='1';gln.submit()"
														style="text-decoration: none; float:right; padding-right:5px;">
														Verify
													</a><?php
												}?>

												<a href="#" onclick="e_crit.ac.value='';
												e_crit.ec.value='';
												e_crit.dc.value='';										
												e_crit.aq.value='';
												e_crit.eq.value='';
												e_crit.dq.value='';					
												e_crit.as.value='';
												e_crit.es.value='';
												e_crit.ds.value='';
												e_crit.das.value='';							
												e_crit.en.value='';
												e_crit.dis.value='';
												e_crit.admt.value='';
												e_crit.conf.value='';
												e_crit.sbjlist.value='';
												e_crit.cFacultyId.value='<?php echo $cFacultyId ?>';
												e_crit.cdept.value='<?php echo $cdept ?>';
												e_crit.vFacultyDesc.value='<?php echo $FacultyDesc; ?>';
												e_crit.vdeptDesc.value='<?php echo $deptDesc; ?>';
												e_crit.vObtQualTitle.value='<?php echo $vObtQualTitle; ?>';
												e_crit.cEduCtgId.value='<?php echo $prog_cat;?>';
												e_crit.cProgrammeId.value='<?php echo $cProgrammeId; ?>';
												e_crit.vProgrammeDesc.value='<?php echo $ProgrammeDesc; ?>';
												e_crit.submit()"
													style="text-decoration: none; float:right; padding-right:5px;">
													Detail
												</a>
											</div>										
											
											<div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; margin-left:-1px; text-align:right; width:12%; padding-right:3px;"><?php
												$sqlcount = "SELECT * FROM prog_choice 
												WHERE cProgrammeId = '$cProgrammeId'
												AND cSbmtd = '1'";
												
												$result = mysqli_query(link_connect_db(), $sqlcount) or die(mysqli_error(link_connect_db()));
												$bcnt = $bcnt + mysqli_num_rows($result);
												echo number_format(mysqli_num_rows($result));
												mysqli_close(link_connect_db());?>
											</div>
											
											<div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; margin-left:-1px; text-align:right; width:12%; padding-right:3px;"><?php
												$sqlcount = "SELECT * FROM prog_choice 
												WHERE cProgrammeId = '$cProgrammeId'
												AND cSbmtd = '2'";
												
												$result = mysqli_query(link_connect_db(), $sqlcount) or die(mysqli_error(link_connect_db()));
												$ccnt = $ccnt + mysqli_num_rows($result);
												echo number_format(mysqli_num_rows($result));
												mysqli_close(link_connect_db());?>
											</div>
											
											<div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; margin-left:-1px; text-align:right; width:12.2%; padding-right:3px;"><?php
												$sqlcount = "SELECT * FROM prog_choice 
												WHERE cProgrammeId = '$cProgrammeId'
												AND cSbmtd = '0'";
									
												$result = mysqli_query(link_connect_db(), $sqlcount) or die(mysqli_error(link_connect_db()));
												$dcnt = $dcnt + mysqli_num_rows($result);
												echo number_format(mysqli_num_rows($result));
												mysqli_close(link_connect_db());?>
											</div>
										</div>
									</label><?php
								}
								$stmt->close();?>
							</div><?php
						}else
						{
							caution_box('Selected category of programme is not offerred in the selected department of the selected faculty');
						}
					}?>
				</form><?php
			}?>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
				<img name="passprt" id="passprt" src="<?php echo get_pp_pix('');?>" width="95%" height="185"  
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
                
				<div style="width:auto; padding-top:6px; padding-bottom:4px; border-bottom:1px dashed #888888">
				</div>
				<div style="width:auto; padding-top:10px;">
				</div>
				<div style="width:auto; padding-top:6px; padding-bottom:4px; line-height:1.3; border-bottom:1px dashed #888888">
				</div>
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