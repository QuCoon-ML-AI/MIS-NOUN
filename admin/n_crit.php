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

$currency = eyes_pilled('0');

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
		var numbers_letter = /^[0-9A-Za-z ]+$/;
		
		var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}

        _('smke_screen_2').style.display= 'none';
		_('smke_screen_2').style.zIndex = '-1';
				
		_('info_box_green').style.display= 'none';
		_('info_box_green').style.zIndex = '-1';
		
		if (_("vReqmtDesc1").value == '')
		{
			setMsgBox("labell_msg0","");
			_("vReqmtDesc1").focus();
			return;
		}

		if (!_("vReqmtDesc1").value.match(numbers_letter))
		{
			setMsgBox("labell_msg0","Only letters and numbers are allowed");
			_("vReqmtDesc1").focus();
			return;
		}
		
		//if (n_crit.iBeginLevel.value > 100)
		//{
			if (_("iBeginLevel1").value == '')
			{
				setMsgBox("labell_msg1","");
				_("iBeginLevel1").focus();
				return;
			}
			
			if (_("cEduCtgId_2_loc").value == '')
			{
				setMsgBox("labell_msg2","");
				_("cEduCtgId_2_loc").focus();
				return;
			}
		//}
		
		var formdata = new FormData();
		
		formdata.append("save", n_crit.save.value);
		formdata.append("ac", _("ac").value);
		formdata.append("ec", _("ec").value);
		formdata.append("currency", n_crit.currency.value);
		formdata.append("user_cat", n_crit.user_cat.value);
		formdata.append("cAcademicDesc", _("cAcademicDesc").value);
		formdata.append("vReqmtDesc1", _("vReqmtDesc1").value);
		formdata.append("sReqmtId", _("sReqmtId1").value);
		formdata.append("iBeginLevel", n_crit.iBeginLevel.value);
		formdata.append("vApplicationNo", n_crit.vApplicationNo.value);
		formdata.append("cProgrammeId", n_crit.cProgrammeId.value);
		formdata.append("cFacultyId", _("cFacultyId").value);	
		//if (n_crit.iBeginLevel.value > 100)
		//{
			formdata.append("cEduCtgId_2_loc", _("cEduCtgId_2_loc").value);
			formdata.append("iBeginLevel1", _("iBeginLevel1").value);
		//}

		opr_prep(ajax = new XMLHttpRequest(),formdata);
	}
	
	
	function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_n_crit.php");
		ajax.send(formdata);
	}
	


	function completeHandler(event)
	{ 
		returnedStr = event.target.responseText;
        
        _('smke_screen_2').style.display= 'none';
		_('smke_screen_2').style.zIndex = '-1';
		
		_('status_info_box').style.display= 'none';
		_('status_info_box').style.zIndex = '-1';
		
		_('info_box_green').style.display= 'none';
		_('info_box_green').style.zIndex = '-1';
        
        if (event.target.responseText.indexOf("successfully") != -1)
		{
			_("smke_screen_2").style.zIndex = '2';
            _("smke_screen_2").style.display = 'block';
            
            _("msg_msg_info_green").innerHTML = returnedStr;
            _("info_box_green").style.zIndex = '3';
            _("info_box_green").style.display = 'block';
		}else
        {
            _("smke_screen_2").style.zIndex = '2';
            _("smke_screen_2").style.display = 'block';
            
            _("msg_msg_status_info").innerHTML = returnedStr;
            _("status_info_box").style.zIndex = '3';
            _("status_info_box").style.display = 'block';
        }
	}
	
	
	function progressHandler(event)
	{
		_("smke_screen_2").style.zIndex = '2';
		_("smke_screen_2").style.display = 'block';
		
		_("msg_msg_status_info").innerHTML = "Processing request, please...wait";
		_("status_info_box").style.zIndex = '3';
		_("status_info_box").style.display = 'block';
	}
	
	
	
	function errorHandler(event)
	{
        _("smke_screen_2").style.zIndex = '2';
		_("smke_screen_2").style.display = 'block';
		
		_("msg_msg_status_info").innerHTML = "Your internet connection was interrupted. Please try again";
		_("status_info_box").style.zIndex = '3';
		_("status_info_box").style.display = 'block';
	}
	
	function abortHandler(event)
	{
        _("smke_screen_2").style.zIndex = '2';
		_("smke_screen_2").style.display = 'block';
		
		_("msg_msg_status_info").innerHTML = "Process aborted";
		_("status_info_box").style.zIndex = '3';
		_("status_info_box").style.display = 'block';
	}
</script><?php

require_once ('set_scheduled_dates.php');?>
<!-- InstanceEndEditable -->
</head>
<body onLoad="checkConnection()">
    <?php admin_frms(); $has_matno = 0;?>
	
	<form action="staff_home_page" method="post" name="nxt" id="nxt" enctype="multipart/form-data">
		<?php frm_vars();?>
		<input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST['vMatricNo'])){echo $_REQUEST['vMatricNo']; }?>" />
		<input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
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

    <div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
    
    <div id="status_info_box" class="center" style="display:none; 
        width:370px; 
        text-align:center; 
        padding:10px; 
        box-shadow: 2px 2px 8px 2px #726e41; 
        background:#FFFFFF; 
        z-index:-1">
        <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
            Status
        </div>
        <a href="#" style="text-decoration:none;">
            <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
        </a>
        <div id="msg_msg_status_info" style="line-height:1.6; margin-top:10px; margin-bottom:10px; width:370px; float:left; text-align:center; padding:0px;"></div>
    </div>

    <div id="info_box_green" class="center" style="display:none; 
        width:370px; 
        text-align:center; 
        padding:10px; 
        box-shadow: 2px 2px 8px 2px #726e41; 
        background:#FFFFFF;  
        z-index:3">
        <div style="width:350px; float:left; text-align:left; padding:0px; color:#36743e; font-weight:bold">
            Information
        </div>
        <a href="#" style="text-decoration:none;">
            <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
        </a>
        <div id="msg_msg_info_green" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;"></div>

        <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
            <a href="#" style="text-decoration:none;" 
                onclick="_('info_box_green').style.display='none';
                _('info_box_green').style.zIndex='-1';
                _('smke_screen_2').style.display='none';
                _('smke_screen_2').style.zIndex='-1';
                return false">
                <div class="submit_button_home" style="width:60px; padding:6px; float:right">
                    Ok
                </div>
            </a>
        </div>
    </div>

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
		<!-- InstanceBeginEditable name="EditRegion6" --><?php	
            if ($currency == '1')
            {
                nav_frm();?>
				<div class="innercont_top">
                    <a href="#"style="text-decoration:none; color:#4ab963" onclick="
                        pgprgs1.ac.value='';
                        pgprgs1.ec.value='';
                        pgprgs1.dc.value='';												
                        pgprgs1.aq.value='';
                        pgprgs1.eq.value='';
                        pgprgs1.dq.value='';												
                        pgprgs1.as.value='';
                        pgprgs1.es.value='';
                        pgprgs1.ds.value='';
                        pgprgs1.das.value='';												
                        pgprgs1.en.value='';
                        pgprgs1.dis.value='';
                        pgprgs1.admt.value='';
                        pgprgs1.conf.value='';
                        pgprgs1.sbjlist.value='';
                        pgprgs1.cFacultyId.value='<?php echo $_REQUEST['cFacultyId'] ?>';
                        pgprgs1.cdept.value='<?php echo $_REQUEST['cdept'] ?>';
                    	pgprgs1.cProgrammeId.value='<?php echo $_REQUEST['cProgrammeId'] ?>';

                        pgprgs1.submit()"><?php echo nav_text($sm); ?></a> ::
                    <a href="#"style="text-decoration:none; color:#4ab963" onclick="
                        e_crit1.ac.value='';
                        e_crit1.ec.value='';
                        e_crit1.dc.value='';												
                        e_crit1.aq.value='';
                        e_crit1.eq.value='';
                        e_crit1.dq.value='';												
                        e_crit1.as.value='';
                        e_crit1.es.value='';
                        e_crit1.ds.value='';
                        e_crit1.das.value='';												
                        e_crit1.en.value='';
                        e_crit1.dis.value='';
                        e_crit1.admt.value='';
                        e_crit1.conf.value='';
                        e_crit1.sbjlist.value='';
                        e_crit1.cFacultyId.value='<?php echo $_REQUEST['cFacultyId'] ?>';
                        e_crit1.cdept.value='<?php echo $_REQUEST['cdept'] ?>';
                    	e_crit1.cProgrammeId.value='<?php echo $_REQUEST['cProgrammeId']; ?>';

						e_crit1.vFacultyDesc.value='<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>';
						e_crit1.vdeptDesc.value='<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>';
						e_crit1.vObtQualTitle.value='<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>';
						e_crit1.vProgrammeDesc.value='<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>';
						e_crit1.cEduCtgId.value='<?php if (isset($_REQUEST['prog_cat1'])){echo $_REQUEST['prog_cat1'];}?>';
						
						e_crit1.cEduCtgId_1.value='<?php echo $cEduCtgId_1;?>';                                            
                        e_crit1.cEduCtgId_2.value='<?php echo $cEduCtgId_2;?>';

						e_crit1.cProgrammeId.value='<?php echo $cProgrammeId; ?>';
                        e_crit1.vReqmtDesc.value='<?php echo addslashes($vReqmtDesc); ?>';

                        e_crit1.as.value='';
						e_crit1.submit()">List of criteria</a> 
                    <?php if ($ac == '1') {echo ' :: Add new criterion';}elseif ($ec == '1') {echo ' :: Edit criterion';}?>
                </div><?php
                if ($_REQUEST['cFacultyId'] <> $cFacultyId && $sRoleID_u <> 6)
				{
                    $msg = 'You cannot ';
                    if($as == '1' || $ac == '1')
                    {
                        $msg .= 'create ';
                    }else if($ec == '1' || $es == '1')
                    {
                        $msg .= 'edit ';
                    }
                    $msg .= 'admission criteria in the selected faculty';
                    caution_box($msg);
					$allowed = '0';
				}else if ($_REQUEST['cdept'] <> $cdeptId_u && $sRoleID_u <> 6)
				{
                    $msg = 'You cannot ';
                    if($as == '1' || $ac == '1')
                    {
                        $msg .= 'create ';
                    }else if($ec == '1' || $es == '1')
                    {
                        $msg .= 'edit ';
                    }
                    $msg .= 'admission criteria in the selected faculty';
                    caution_box($msg);
					$allowed = '0';
				}else
				{?>	
					<form action="edit-criterion" name="e_crit_form" method="post">
						<input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
						<?php frm_vars();?>
					</form>
					
					<form action="add-edit-criterion" name="n_crit" method="post">
						<?php frm_vars();?>
						<input name="save" id="save" type="hidden" value="-1" />
						<input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
						<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
						<div class="innercont_stff" style="color:#FF3300;">
							<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];}
							if (isset($_REQUEST['vdeptDesc'])){echo ' :: '.$_REQUEST['vdeptDesc'];}
							if (isset($_REQUEST['vObtQualTitle'])){echo ' :: '.$_REQUEST['vObtQualTitle'];}
							if (isset($_REQUEST['vProgrammeDesc'])){echo ' '.$_REQUEST['vProgrammeDesc'];}?>
						</div><?php 

                        $cAcademicDesc = $orgsetins['cAcademicDesc'];?>

                        <div class="innercont_stff" style="margin-top:0px; margin-bottom:0px">
							<label class="labell">Session:</label>
							<label class="labell" style="text-align:left;"><?php echo substr($cAcademicDesc, 0, 4);?></label>
							<input name="cAcademicDesc" id="cAcademicDesc" type="hidden" value="<?php echo $cAcademicDesc ?>">
						</div>

                        <div class="innercont_stff"><?php
                            if ($ac == '1')
                            {
                                //$sql = "select max(sReqmtId)+1 nxt from criteriadetail where cCriteriaId = '$cProgrammeId'";
                                $sql = "select max(sReqmtId)+1 nxt from criteriadetail where cProgrammeId LIKE '%$cProgrammeId%'";
                                $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                                $r_rssql = mysqli_fetch_array($rssql);
                                if(!isset($r_rssql['nxt']) || strlen($r_rssql['nxt']) == 0){$nxt = 1;}else{$nxt = $r_rssql['nxt'];}
                                mysqli_close(link_connect_db());
                            }?>
                            <label for="vReqmtDesc1" class="labell">Description of criterion</label>
                            <div class="div_select">
                                <input name="vReqmtDesc1"  id="vReqmtDesc1" 
								type="text" 
								maxlength="15" 
								class="textbox" 
								value="<?php echo $vReqmtDesc?>">
                                <input name="sReqmtId1" id="sReqmtId1" type="hidden" value="<?php if ($ec == '1' && $sReqmtId <> ''){echo $sReqmtId;}else{echo $nxt;}?>" />
                            </div> 
                            <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
                        </div>
						
						<div class="innercont_stff">
							<label for="iBeginLevel1" class="labell">Entry level</label>
							<div class="div_select">
								<select name="iBeginLevel1" id="iBeginLevel1" class="select">
									<option value="" selected></option><?php
									if (isset($_REQUEST["iBeginLevel"]) && isset($_REQUEST["cEduCtgId"]))
									{
										$prog_cat = $_REQUEST["cEduCtgId"];
										$iBeginLevel = $_REQUEST["iBeginLevel"];

										if ($prog_cat == 'ELX' || $prog_cat == 'ELZ')
										{?>
											<option value="10"<?php if ($iBeginLevel == '10'){echo ' selected';}?>>10 Proficiency certificate</option>
											<option value="20"<?php if ($iBeginLevel == '20'){echo ' selected';}?>>20 Certificate</option>
											<option value="30"<?php if ($iBeginLevel == '30'){echo ' selected';}?>>30 Diploma</option><?php
										}
										if ($prog_cat == 'PSZ')
										{?>
											<option value="100"<?php if ($iBeginLevel == '100'){echo ' selected';}?>>100 Undergraduate</option>
											<option value="200"<?php if ($iBeginLevel == '200'){echo ' selected';}?>>200 Direct Entry I</option>
											<option value="300"<?php if ($iBeginLevel == '300'){echo ' selected';}?>>300 Direct Entry II</option><?php
										}
										if ($prog_cat == 'PGX')
										{?>
											<option value="700"<?php if ($iBeginLevel == '700'){echo ' selected';}?>>700 PGD</option><?php
										}
										if ($prog_cat == 'PGY')
										{?>
											<option value="800"<?php if ($iBeginLevel == '800'){echo ' selected';}?>>800 Masters</option><?php
										}
										if ($prog_cat == 'PRX')
										{?>
											<option value="900"<?php if ($iBeginLevel == '900'){echo ' selected';}?>>900 Ph. D.</option><?php
										}
									}?>
								</select>
							</div>
							<div id="labell_msg1" class="labell_msg blink_text orange_msg"></div>
						</div>

						<div class="innercont_stff">
							<label for="cEduCtgId_2_loc" class="labell">Additional qualification</label>
							<div class="div_select"><?php						
								$sql = "SELECT DISTINCT cEduCtgId, vEduCtgDesc 
								FROM educationctg
								WHERE cEduCtgId IN ('ALX','ALZ','ELZ','PSX','PSZ','PGX')
								ORDER BY cEduCtgId";

								$rssqlEduCtgId = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));?>
								<select name="cEduCtgId_2_loc" id="cEduCtgId_2_loc" class="select">
									<option value="" selected></option><?php
									while ($r_rssqlEduCtgId = mysqli_fetch_assoc($rssqlEduCtgId))
									{?>
										<option value="<?php echo $r_rssqlEduCtgId['cEduCtgId']?>" <?php if($cEduCtgId_2==$r_rssqlEduCtgId['cEduCtgId']){echo 'selected';}?> ><?php echo $r_rssqlEduCtgId['vEduCtgDesc']; ?></option><?php
									}
									mysqli_close(link_connect_db());?>
								</select>
							</div>
							<div id="labell_msg2" class="labell_msg blink_text orange_msg"></div>
						</div>
                    </form><?php
                }
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