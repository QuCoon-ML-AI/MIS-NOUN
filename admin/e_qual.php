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
	// function preventBack(){window.history.forward();}
	// setTimeout("preventBack()", 0);
	// window.onunload=function(){null};

    //check_environ();

	// function preventBack(){window.history.forward();}
	// 	setTimeout("preventBack()", 0);
	// 	window.onunload=function(){null};		
	
    function chk_inputs()
	{
		//var numbers_letter = /^[0-9A-Za-z ]+$/;
        
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}
		
		if (e_qual.sm.value == 1 || e_qual.sm.value == 2)
		{
			if (_("cEduCtgId_2_loc").value == '')
			{
				setMsgBox("labell_msg1","");
				_("cEduCtgId_2_loc").focus();
			}else
			{
				var formdata = new FormData();
                
				formdata.append("save", e_qual.save.value);
				formdata.append("aq", e_qual.aq.value);
				formdata.append("eq", e_qual.eq.value);
				formdata.append("dq", e_qual.dq.value);
				formdata.append("currency", e_qual.currency.value);
				formdata.append("user_cat", e_qual.user_cat.value);
                
				formdata.append("vApplicationNo", e_qual.vApplicationNo.value);
                formdata.append("cEduCtgId_2_loc", e_qual.cEduCtgId_2_loc.value);
                
				formdata.append("cFacultyId", e_qual.cFacultyId.value);
				formdata.append("cProgrammeId", e_qual.cProgrammeId.value);
				formdata.append("begin_level",e_qual.begin_level.value);
                
				formdata.append("sReqmtId",e_qual.sReqmtId.value);

				opr_prep(ajax = new XMLHttpRequest(),formdata);	
			}
		}else if (e_qual.sm.value == 5)
		{
			if (e_qual.dq.value == '1')
			{
				var formdata = new FormData();
				
				formdata.append("vApplicationNo", e_qual.vApplicationNo.value);
				formdata.append("cEduCtgId", e_qual.cEduCtgId.value);
				formdata.append("cFacultyId", e_qual.cFacultyId.value);
				formdata.append("cProgrammeId", e_qual.cProgrammeId.value);
				formdata.append("sReqmtId",e_qual.sReqmtId.value);
                				
				formdata.append("conf", e_qual.conf.value);
				formdata.append("save", 1);
				formdata.append("dq", e_qual.dq.value);
				formdata.append("currency", e_qual.currency.value);
				formdata.append("user_cat", e_qual.user_cat.value);

				opr_prep(ajax = new XMLHttpRequest(),formdata);	
			}
		}
	}	
	
	function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_e_qual.php");
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

		var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}
		
		if (returnedStr.indexOf("Please") != -1 || returnedStr.indexOf("already") != -1)
		{ 
            _("smke_screen_2").style.zIndex = '2';
            _("smke_screen_2").style.display = 'block';
            
            _("msg_msg_loc").innerHTML = returnedStr;
            _("conf_warn_loc").style.zIndex = '3';
            _("conf_warn_loc").style.display = 'block';
		}else
		{ 
			if (e_qual.aq.value == '1')
            {
                _("sub_box").style.display = 'none';
                _("cont_box").style.display = 'block';
            }
            
            _("smke_screen_2").style.zIndex = '2';
            _("smke_screen_2").style.display = 'block';
            
            _("msg_msg_info_green").innerHTML = returnedStr;
            _("info_box_green").style.zIndex = '3';
            _("info_box_green").style.display = 'block';
			
			e_qual.aq.value='';
			e_qual.eq.value='';
			e_qual.dq.value='';
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
    
    //window.resizeTo(screen.availWidth, screen.availHeight)
	//window.moveTo(0,0)
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
    
    <div id="conf_box_loc" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
		<div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Confirmation
		</div>
		<a href="#" style="text-decoration:none;">
			<div style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;"></div>
		<div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
			<a href="#" style="text-decoration:none;" 
				onclick="_('conf_box_loc').style.display='none';
				e_qual.conf.value='1';
				chk_inputs();
				return false">
				<div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
					Yes
				</div>
			</a>

			<a href="#" style="text-decoration:none;" 
				onclick="e_qual.ac.value='';
                e_qual.ec.value='';
                e_qual.dc.value='';
                e_qual.aq.value='';
                e_qual.eq.value='';
                e_qual.dq.value='';
                e_qual.as.value='';
                e_qual.es.value='';
                e_qual.ds.value='';
                e_qual.das.value='';
                e_qual.en.value='';
                e_qual.dis.value='';
                e_qual.admt.value='';
                e_qual.conf.value='';
                _('conf_box_loc').style.display='none';
                _('conf_box_loc').style.zIndex='-1';
				_('smke_screen_2').style.display='none';
				_('smke_screen_2').style.zIndex='-1';
				return false">
				<div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
					No
				</div>
			</a>
		</div>
	</div>
    
    <div id="conf_warn_loc" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:3">
		<div id="msg_title" style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Caution
		</div>
		<a href="#" style="text-decoration:none;">
			<div id="msg_title_loc" style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div id="msg_msg_loc" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
			<?php echo $msg;?>
		</div>
		<div id="msg_title_loc" style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
			<a href="#" style="text-decoration:none;" 
				onclick="_('conf_warn_loc').style.display= 'none';
				_('conf_warn_loc').style.zIndex= '-1';
				_('smke_screen_2').style.display= 'none';
				_('smke_screen_2').style.zIndex= '-1';
				return false">
				<div class="submit_button_green" style="width:60px; padding:6px; float:right">
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
		<!-- InstanceBeginEditable name="EditRegion6" -->	<?php	
            if ($currency == '1')
            {
                nav_frm();?>
                <form action="edit_qualification_subject" method="post" name="e_qual_sbj" enctype="multipart/form-data">
                    <?php frm_vars();?>
                    <input name="save" type="hidden" value="-1" />
                    <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                </form>
    
                <select name="qualification_readup" id="qualification_readup" style="display:none"><?php	
                    $sql = "select cQualCodeId,cEduCtgId,vQualCodeDesc from qualification order by vQualCodeDesc";
                    $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                    while ($rs = mysqli_fetch_array($rssql))
                    {?>
                        <option value="<?php echo $rs['cQualCodeId'].$rs['cEduCtgId'];?>"><?php echo $rs['vQualCodeDesc']; ?></option><?php
                    }
                    mysqli_close(link_connect_db());?>
                </select>
                
                <input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId; ?>" />
                <input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdept; ?>" />
                <input name="NumOfCritQual" id="NumOfCritQual" type="hidden" value="" />
                <input name="frm_upd_loc" id="frm_upd_loc" type="hidden" />
                <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID;?>" />
                
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
                    pgprgs1.cFacultyId.value='<?php echo $_REQUEST['cFacultyId'] ?>';
                    pgprgs1.cdept.value='<?php echo $_REQUEST['cdept'] ?>';
                    pgprgs1.cProgrammeId.value='<?php echo $_REQUEST['cProgrammeId'] ?>';
                    pgprgs1.submit()"><?php nav_text($sm);?></a> :: 
                    <a href="#"style="text-decoration:none; color:#4ab963" 
                    onclick="
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
                    						
                    e_crit1.cEduCtgId_1.value='<?php echo $cEduCtgId_1;?>';                                            
                    e_crit1.cEduCtgId_2.value='<?php echo $cEduCtgId_2;?>';
                    e_crit1.vReqmtDesc.value='<?php echo addslashes($vReqmtDesc); ?>';
                    
                    e_crit1.cFacultyId.value='<?php echo $_REQUEST['cFacultyId'] ?>';
                    e_crit1.cdept.value='<?php echo $_REQUEST['cdept'] ?>';
                    e_crit1.cProgrammeId.value='<?php echo $_REQUEST['cProgrammeId'] ?>';

                    e_crit1.vFacultyDesc.value='<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>';
                    e_crit1.vdeptDesc.value='<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>';
                    e_crit1.vObtQualTitle.value='<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>';
                    e_crit1.cEduCtgId.value='<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>';
                    e_crit1.vProgrammeDesc.value='<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>';

                    e_crit1.submit()">List of criteria</a> :: Detail of criterion-List of entry qualification
                    <?php if ($aq == '1') {echo ' :: New qualification';}elseif ($eq == '1') {echo ' :: Edit qualification';}?>
                </div>

                <div class="innercont_stff" style="margin-bottom:3px; color:#FF3300;">
                    <?php echo 'Faculty of '.$_REQUEST['vFacultyDesc'].' :: Department of '.$_REQUEST['vdeptDesc'].' :: '.$_REQUEST['vObtQualTitle'].' '.$_REQUEST['vProgrammeDesc']; ?>
                </div>

				<div id="critHeader" class="innercont_stff" style="height:auto; display:<?php if ($eq == '1' || $aq == '1'){echo 'block';}else{echo 'none';}?>;">
                    <div class="_label" style="border:0px; width:15%;">
                        Descriptions
                    </div>
                    <div class="_value" style="width:78.3%; border:0px;">
                        <?php echo $vReqmtDesc;?>
                    </div>
                    
                    <div class="_label" style="border:0px; width:15%;">
                        Entry level
                    </div>
                    <div class="_value" style="width:78.3%; border:0px;">
                        <?php echo $iBeginLevel;?>
                    </div>
                </div><?php
                
                $cProgrammeId_loc = "%$cProgrammeId%";

                $stmt = $mysqli->prepare("SELECT cUsed, cStatus FROM criteriadetail where cProgrammeId LIKE ? and sReqmtId = ?");
                $stmt->bind_param("si", $cProgrammeId_loc, $sReqmtId);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($cUsed, $cStatus);
                $stmt->fetch();
                $crit_used = $cUsed;
                $endis = $cStatus;
                $stmt->close();
                
                $cProgrammeId_loc = "%$cProgrammeId%";
                $sub_qry = "AND cEduCtgId_1 = 'OL' AND iBeginLevel = 100";
                if ($vQualCodeDesc <> 'Olevel')
                {
                    $sub_qry = "AND cEduCtgId_2 = '$cEduCtgId_2'";
                }
                $stmt_ds = $mysqli->prepare("SELECT cProgrammeId FROM criteriadetail
                WHERE cProgrammeId LIKE ?
                AND cProgrammeId LIKE '%,%'
                AND sReqmtId = ?
                $sub_qry");
                $stmt_ds->bind_param("si", $cProgrammeId_loc, $sReqmtId);
                $stmt_ds->execute();
                $stmt_ds->store_result();
                $stmt_ds->bind_result($cProgrammeId_locc);
                $progs_affected = $stmt_ds->num_rows;
                $stmt_ds->fetch();
                $stmt_ds->close();
                
                $cProgrammeId_locc = $cProgrammeId_locc ?? '';
                
                $number_of_afected_programmes = strrpos($cProgrammeId_locc, ",")/4;
                if (is_numeric($number_of_afected_programmes))
                {
                    $number_of_afected_programmes = intval($number_of_afected_programmes-1);
                }?>
                <input name="progs_affected" id="progs_affected" type="hidden" value="<?php if($progs_affected>0){echo $number_of_afected_programmes. ' other programmes will also be affected<br>';}?>"/>

                <div id="qual_list_h" class="innercont_stff" style="width:1320px; font-weight:bold; display:<?php if ($eq == '1' || $aq == '1'){echo 'none';}else{echo 'block';}?>;">
                    <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; padding-right:3px; text-align:right; width:5%">Sno</div>
                    
                    <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; width:55%; text-align:left; text-indent:2px">Qualification</div>
                    
                    <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:12%; padding-right:3px;">Max. no. of Sitings</div>
                    
                    <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:12%; padding-right:3px;">Min. no. of Subject</div>
                    
                    <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:12%; padding-right:3px;"><?php                        
                        if ($sm == '1' && isset($_REQUEST['used_admitted']) && $_REQUEST['used_admitted'] == 0)
                        {?>
                            <a href="#"target="_self" style="text-decoration:none" onclick="
                                e_qual.ac.value='';
                                e_qual.ec.value='';
                                e_qual.dc.value='';												
                                e_qual.aq.value='';
                                e_qual.eq.value='';
                                e_qual.dq.value='';												
                                e_qual.as.value='';
                                e_qual.es.value='';
                                e_qual.ds.value='';
                                e_qual.das.value='';												
                                e_qual.en.value='';
                                e_qual.dis.value='';
                                e_qual.admt.value='';
                                e_qual.conf.value='';
                                                                
                                _('critHeader').style.display='none';
                                if(_('userInfo_f').value!=_('cFacultyId').value&&_('sRoleID').value!=6)
                                {
                                    caution_box('You cannot create entry qualification in the selected faculty');
                                }else if(_('userInfo_d').value!=_('cdept').value&&_('sRoleID').value!=6)
                                {
                                    caution_box('You cannot create entry qualification in the selected department');
                                }else
                                {
                                    e_qual.aq.value='1';
                                    e_qual.iBeginLevel.value='<?php echo $iBeginLevel; ?>';
                                    e_qual.vReqmtDesc.value='<?php echo addslashes($vReqmtDesc); ?>';
                                    e_qual.sReqmtId.value='<?php echo $sReqmtId; ?>';
                                    
                                    e_qual.cProgrammeId.value='<?php if (isset($_REQUEST['cProgrammeId'])){echo $_REQUEST['cProgrammeId'];} ?>';
                                    e_qual.submit();
                                    return false;
                                }">
                                    Add
                            </a><?php
                        }else
                        {
                            echo 'NE';
                        }?>
                    </div>
                </div>

                
                <div id="qual_list" class="innercont_stff" style="height:77%; overflow:scroll; overflow-x: hidden; display:<?php if ($eq == '1' || $aq == '1'){echo 'none';}else{echo 'block';}?>"><?php
                    $cProgrammeId_loc = $cProgrammeId;
                    $cProgrammeId_loc = "%$cProgrammeId_loc%";

                    // $stmt = $mysqli->prepare("SELECT DISTINCT sReqmtId
                    // FROM criteriadetail
                    // WHERE cEduCtgId_1 = 'OL'
                    // AND cProgrammeId LIKE ? LIMIT 1");
                    
                    // $stmt->bind_param("s", $cProgrammeId_loc);
                    // $stmt->execute();
                    // $stmt->store_result();
                    // $stmt->bind_result($sReqmtId_loc);
                    // $cnt = 0;
                    // $stmt->fetch();
                    
                    //if ($cnt%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
                    <label class="lbl_beh">
                        <div class="innercont_stff" style="width:1320px; font-weight:bold; display:<?php if ($eq == '1' || $aq == '1'){echo 'none';}else{echo 'block';}?>;">
                            <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; padding-right:3px; text-align:right; width:5%">1</div>
                            
                            <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; margin-left:-1px; width:55%; text-align:left; text-indent:2px">O'level</div>
                            
                            <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; margin-left:-1px; text-align:right; width:12%; padding-right:3px;">2</div>
                            
                            <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; margin-left:-1px; text-align:right; width:12%; padding-right:3px;">5</div>
                            
                            <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; margin-left:-1px; text-align:right; width:12%; padding-right:3px;"><?php                        
                                if ($sm == '1' || $sm == '2'  || $sm == '3' || $sm == '5')
                                {
                                    if (isset($_REQUEST['used_admitted']) && $_REQUEST['used_admitted'] > 0)
                                    {
                                        if ($sm == '1')
                                        {
                                            echo 'NE';
                                        }else if ($sm == '2')
                                        {
                                            echo 'NE';   
                                        }
                                    }else if ($sm == '5')
                                    {
                                        if (isset($_REQUES['used_admitted']) && $_REQUES['used_admitted'] > 0)
                                        {
                                            echo 'NE';
                                        }else if ($iBeginLevel == 100 || ($_REQUEST['cFacultyId'] == 'HSC' && $iBeginLevel == 200))
                                        {?>
                                            <a href="#" onclick="
                                            e_qual.ac.value='';
                                            e_qual.ec.value='';
                                            e_qual.dc.value='';												
                                            e_qual.aq.value='';
                                            e_qual.eq.value='';
                                            e_qual.dq.value='1';												
                                            e_qual.as.value='';
                                            e_qual.es.value='';
                                            e_qual.ds.value='';
                                            e_qual.das.value='';												
                                            e_qual.en.value='';
                                            e_qual.dis.value='';
                                            e_qual.admt.value='';
                                            e_qual.conf.value='';
                                            if(_('userInfo_f').value!=_('cFacultyId').value&&_('sRoleID').value!=6)
                                            {
                                                caution_box('You cannot delete criteria in the selected faculty');
                                            }else if(_('userInfo_d').value!=_('cdept').value&&_('sRoleID').value!=6)
                                            {
                                                caution_box('You cannot delete criteria in the selected department');
                                            }else
                                            {
                                                e_qual.sReqmtId.value='<?php echo $sReqmtId ?>';
                                                e_qual.cEduCtgId_selected_qual.value='OL';

                                                e_qual.cFacultyId.value='<?php if (isset($_REQUEST['cFacultyId'])){echo $_REQUEST['cFacultyId'];} ?>';
                                                e_qual.cdept.value='<?php if (isset($_REQUEST['cdept'])){echo $_REQUEST['cdept'];} ?>';
                                                e_qual.cProgrammeId.value='<?php if (isset($_REQUEST['cProgrammeId'])){echo $_REQUEST['cProgrammeId'];} ?>';

                                                e_qual.vFacultyDesc.value='<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>';
                                                e_qual.vdeptDesc.value='<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>';
                                                e_qual.vObtQualTitle.value='<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>';
                                                e_qual.cEduCtgId.value='<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>';
                                                e_qual.vProgrammeDesc.value='<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>';

                                                e_qual.vReqmtDesc.value='<?php echo addslashes($vReqmtDesc); ?>';
                                                _('conf_msg_msg_loc').innerHTML = 'Are you sure you want to delete this qualification ?';
                                                _('conf_box_loc').style.display='block';
                                                _('conf_box_loc').style.zIndex='3';
                                                _('smke_screen_2').style.display='block';
                                                _('smke_screen_2').style.zIndex='2';
                                            }" style="text-decoration: none">
                                                Delete
                                            </a><?php
                                        }else
                                        {
                                            echo 'NE';
                                        }
                                    }else if ($sm == '2')
                                    {
                                        echo 'NE';
                                    }else if ($endis == '0')
                                    {
                                        echo 'NE';
                                    }else
                                    {
                                        echo '-';
                                    }
                                }?>

                                <a href="#"style="text-decoration: none" 
                                    onclick="e_qual_sbj.ac.value='';
                                    e_qual_sbj.ec.value='';
                                    e_qual_sbj.dc.value='';
                                    e_qual_sbj.aq.value='';
                                    e_qual_sbj.eq.value='';
                                    e_qual_sbj.dq.value='';												
                                    e_qual_sbj.as.value='';
                                    e_qual_sbj.es.value='';
                                    e_qual_sbj.ds.value='';
                                    e_qual_sbj.das.value='';
                                    e_qual_sbj.en.value='';
                                    e_qual_sbj.dis.value='';
                                    e_qual_sbj.admt.value='';
                                    e_qual_sbj.conf.value='';
                                    e_qual_sbj.sbjlist.value='1';
                                    e_qual_sbj.sReqmtId.value='<?php echo $sReqmtId; ?>';
                                    e_qual_sbj.cQualCodeId.value='<?php echo $cQualCodeId; ?>';
                                    e_qual_sbj.vQualCodeDesc.value='<?php echo 'Olevel'; ?>';
                                            
                                    e_qual_sbj.used_admitted.value='<?php if (isset($_REQUEST['used_admitted'])){echo $_REQUEST['used_admitted'];}?>';
                                    
                                    e_qual_sbj.cFacultyId.value='<?php if (isset($_REQUEST['cFacultyId'])){echo $_REQUEST['cFacultyId'];} ?>';
                                    e_qual_sbj.cdept.value='<?php if (isset($_REQUEST['cdept'])){echo $_REQUEST['cdept'];} ?>';
                                    e_qual_sbj.cProgrammeId.value='<?php if (isset($_REQUEST['cProgrammeId'])){echo $_REQUEST['cProgrammeId'];} ?>';

                                    e_qual_sbj.vFacultyDesc.value='<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>';
                                    e_qual_sbj.vdeptDesc.value='<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>';
                                    e_qual_sbj.vObtQualTitle.value='<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>';
                                    e_qual_sbj.vProgrammeDesc.value='<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>';

                                    e_qual_sbj.cEduCtgId_1.value='<?php echo $cEduCtgId_1;?>';                                            
                                    e_qual_sbj.cEduCtgId_2.value='';
                                    e_qual.cEduCtgId_selected_qual.value='OL';
                                    e_qual_sbj.vReqmtDesc.value='<?php echo addslashes($vReqmtDesc); ?>';
                                    e_qual_sbj.iBeginLevel.value='<?php if (isset($_REQUEST['iBeginLevel'])){echo $_REQUEST['iBeginLevel'];}; ?>';

                                    e_qual_sbj.cEduCtgId.value='OLX';
                                    e_qual_sbj.vEduCtgDesc.value='<?php echo addslashes($vEduCtgDesc) ?>';
                                    e_qual_sbj.begin_level.value='<?php echo $begin_level;?>';
                                    
                                    e_qual_sbj.iQSLCount.value='<?php echo $iQSLCount ?>';
                                    e_qual_sbj.submit()">
                                        Detail
                                </a>
                            </div>
                        </div>
                    </label><?php
                    $vReqmtDesc = $vReqmtDesc ?? ''; 
                    if ($iBeginLevel > 100 && !($cFacultyId == 'HSC' && is_bool(strpos($vReqmtDesc,'AL')) && is_bool(strpos($vReqmtDesc,'OND')) && is_bool(strpos($vReqmtDesc,'HND'))&& is_bool(strpos($vReqmtDesc,'FD'))))
                    {
                        $al_opt = " cEduCtgId = ?";
                        if (!is_bool(strpos($vReqmtDesc,'AL')))
                        {
                            if (!is_bool(strpos($vReqmtDesc,'NCE')))
                            {
                                $al_opt = " cEduCtgId = 'ALZ'";
                            }else
                            {
                                $al_opt = " cEduCtgId = 'ALX'";
                            }
                        }

                        $stmt = $mysqli->prepare("SELECT DISTINCT cQualCodeId, vQualCodeDesc FROM qualification WHERE $al_opt");
                        if (is_bool(strpos($vReqmtDesc,'AL')))
                        {
                            $stmt->bind_param("s", $cEduCtgId_2);
                        }                        
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($cQualCodeId, $vQualCodeDesc);
                        $NumOfCritQual =  $stmt->num_rows;
                        $stmt->fetch();

                    
                        $stmt2 = $mysqli->prepare("SELECT *
                        from prog_choice a, criteriadetail b
                        where a.cReqmtId = b.sReqmtId 
                        AND a.cProgrammeId = b.cProgrammeId 
                        AND a.cProgrammeId LIKE ?
                        AND cReqmtId = '".$sReqmtId."'");
                        $stmt2->bind_param("s",$cProgrammeId_loc);
                        $stmt2->execute();
                        $stmt2->store_result();
                        $admitted =  $stmt2->num_rows;
                        $stmt2->close();?>
                        <label class="lbl_beh">
                            <div class="innercont_stff" style="width:1320px; font-weight:bold; display:<?php if ($eq == '1' || $aq == '1'){echo 'none';}else{echo 'block';}?>;">
                                <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; padding-right:3px; text-align:right; width:5%">2</div>
                                
                                <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; margin-left:-1px; width:55%; text-align:left; text-indent:2px"><?php 
                                    echo $vQualCodeDesc;
                                    $cEduCtgId_2 = $cEduCtgId_2 ?? '';
                                    if (!is_bool(strpos($cEduCtgId_2,'AL')) || !is_bool(strpos($cEduCtgId_2,'OND')))
                                    {
                                        echo ' or its equivalent';
                                    }?>
                                </div>
                                
                                <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; margin-left:-1px; text-align:right; width:12%; padding-right:3px;">1
                                </div>
                                
                                <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; margin-left:-1px; text-align:right; width:12%; padding-right:3px;"><?php
                                    $vReqmtDesc = $vReqmtDesc ?? '';
                                    if ($cdept == 'ESC')
                                    {
                                        echo '3';
                                    }else if (!is_bool(strpos($vReqmtDesc,'AL')))
                                    {
                                        echo '2';
                                    }else
                                    {
                                        echo '1';
                                    }?>
                                </div>
                                
                                <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; margin-left:-1px; text-align:right; width:12%; padding-right:3px;"><?php
                                    if ($sm == '1' || $sm == '2'  || $sm == '3' || $sm == '5')
                                    {
                                        if (isset($_REQUEST['used_admitted']) && $_REQUEST['used_admitted'] > 0)
                                        {
                                            if ($sm == '1')
                                            {?>
                                                <img src="img/edit_dull.gif" style="cursor:not-allowed" title="Not editable. Qualification used for admission" hspace="0" vspace="0" border="0"/><?php
                                            }else if ($sm == '2')
                                            {?>
                                                <img src="img/edit_dull.gif" style="cursor:not-allowed" title="Not editable. Qualification used for admission" hspace="0" vspace="0" border="0"/><?php                                                    
                                            }
                                        }else if ($sm == '5')
                                        {
                                            if (isset($_REQUES['used_admitted']) && $_REQUES['used_admitted'] > 0)
                                            {?>
                                                <img src="img/delete_d.gif" style="cursor:not-allowed" hspace="0" vspace="0" border="0" title="Closed to modification. Used to admit one or more candidate" /><?php
                                            }else
                                            {?>
                                                <a href="#" onclick="e_qual.ac.value='';
                                                e_qual.ec.value='';
                                                e_qual.dc.value='';												
                                                e_qual.aq.value='';
                                                e_qual.eq.value='';
                                                e_qual.dq.value='1';												
                                                e_qual.as.value='';
                                                e_qual.es.value='';
                                                e_qual.ds.value='';
                                                e_qual.das.value='';												
                                                e_qual.en.value='';
                                                e_qual.dis.value='';
                                                e_qual.admt.value='';
                                                e_qual.conf.value='';
                                                if(_('userInfo_f').value!=_('cFacultyId').value&&_('sRoleID').value!=6)
                                                {
                                                    caution_box('You cannot delete criteria in the selected faculty');
                                                }else if(_('userInfo_d').value!=_('cdept').value&&_('sRoleID').value!=6)
                                                {
                                                    caution_box('You cannot delete criteria in the selected department');
                                                }else
                                                {
                                                    e_qual.sReqmtId.value='<?php echo $sReqmtId ?>';
                                                    
                                                    e_qual.cEduCtgId.value='<?php echo $prog_cat;?>';
                                                    e_qual.cEduCtgId_2.value='<?php echo $cEduCtgId_2;?>';
                                                    e_qual.cEduCtgId_selected_qual.value='<?php echo $cEduCtgId_2; ?>';
                                                    
                                                    e_qual.cFacultyId.value='<?php if (isset($_REQUEST['cFacultyId'])){echo $_REQUEST['cFacultyId'];} ?>';
                                                    e_qual.cdept.value='<?php if (isset($_REQUEST['cdept'])){echo $_REQUEST['cdept'];} ?>';
                                                    e_qual.cProgrammeId.value='<?php if (isset($_REQUEST['cProgrammeId'])){echo $_REQUEST['cProgrammeId'];} ?>';

                                                    e_qual.vFacultyDesc.value='<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>';
                                                    e_qual.vdeptDesc.value='<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>';
                                                    e_qual.vObtQualTitle.value='<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>';
                                                    e_qual.cEduCtgId.value='<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>';
                                                    e_qual.vProgrammeDesc.value='<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>';
                                                    e_qual.iBeginLevel.value='<?php if (isset($_REQUEST['iBeginLevel'])){echo $_REQUEST['iBeginLevel'];}; ?>';

                                                    _('conf_msg_msg_loc').innerHTML = 'Are you sure you want to delete this qualification ?';
                                                    _('conf_box_loc').style.display='block';
                                                    _('conf_box_loc').style.zIndex='3';
                                                    _('smke_screen_2').style.display='block';
                                                    _('smke_screen_2').style.zIndex='2';
                                                }" style="text-decoration: none">
                                                    <img src="img/delete.gif" width="33" height="14" hspace="0" vspace="0" border="0" title="delete qualification" />
                                                </a><?php
                                            }
                                        }else if ($sm == '2')
                                        {?>
                                            <a href="#"target="_self" style="text-decoration:none" onclick="e_qual.ac.value='';
                                                e_qual.ec.value='';
                                                e_qual.dc.value='';												
                                                e_qual.aq.value='';
                                                e_qual.eq.value='';
                                                e_qual.dq.value='';												
                                                e_qual.as.value='';
                                                e_qual.es.value='';
                                                e_qual.ds.value='';
                                                e_qual.das.value='';												
                                                e_qual.en.value='';
                                                e_qual.dis.value='';
                                                e_qual.admt.value='';
                                                e_qual.conf.value='';
                                                if(_('userInfo_f').value!=_('cFacultyId').value&&_('sRoleID').value!=6)
                                                {
                                                    caution_box('You cannot edit entry qualification in the selected faculty');
                                                    _('sub_box').style.display='none';
                                                    _('critHeader').style.display='none';
                                                    _('qual_list_h').style.display='none';
                                                    _('qual_list').style.display='none';
                                                    _('facdptprg').style.display='none';
                                                }else if(_('userInfo_d').value!=_('cdept').value&&_('sRoleID').value!=6)
                                                {
                                                    caution_box('You cannot edit entry qualification in the selected department');
                                                    _('sub_box').style.display='none';
                                                    _('critHeader').style.display='none';
                                                    _('qual_list_h').style.display='none';
                                                    _('qual_list').style.display='none';
                                                    _('facdptprg').style.display='none';
                                                }else
                                                {
                                                    e_qual.eq.value='1';
                                                    e_qual.vQualCodeDesc.value='<?php echo $vQualCodeDesc; ?>';
                                                    e_qual.cEduCtgId_selected_qual.value='<?php echo $cEduCtgId_2; ?>';
                                                    e_qual.vReqmtDesc.value='<?php echo $vReqmtDesc; ?>';
                                                    e_qual.sReqmtId.value='<?php echo $sReqmtId; ?>';
                                                    
                                                    e_qual.cFacultyId.value='<?php if (isset($_REQUEST['cFacultyId'])){echo $_REQUEST['cFacultyId'];} ?>';
                                                    e_qual.cdept.value='<?php if (isset($_REQUEST['cdept'])){echo $_REQUEST['cdept'];} ?>';
                                                    e_qual.cProgrammeId.value='<?php if (isset($_REQUEST['cProgrammeId'])){echo $_REQUEST['cProgrammeId'];} ?>';

                                                    e_qual.vFacultyDesc.value='<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>';
                                                    e_qual.vdeptDesc.value='<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>';
                                                    e_qual.vObtQualTitle.value='<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>';
                                                    e_qual.cEduCtgId.value='<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>';
                                                    e_qual.vProgrammeDesc.value='<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>';
                                                    e_qual.iBeginLevel.value='<?php if (isset($_REQUEST['iBeginLevel'])){echo $_REQUEST['iBeginLevel'];}; ?>';
                                                    
                                                    e_qual.submit();
                                                }">
                                                Edit
                                            </a><?php
                                        }else if ($endis == '0')
                                        {
                                            echo 'NE';
                                        }else
                                        {
                                            echo '-';
                                        }
                                    }?>

                                    <a href="#"style="text-decoration: none" 
                                        onclick="e_qual_sbj.ac.value='';
                                        e_qual_sbj.ec.value='';
                                        e_qual_sbj.dc.value='';
                                        e_qual_sbj.aq.value='';
                                        e_qual_sbj.eq.value='';
                                        e_qual_sbj.dq.value='';												
                                        e_qual_sbj.as.value='';
                                        e_qual_sbj.es.value='';
                                        e_qual_sbj.ds.value='';
                                        e_qual_sbj.das.value='';
                                        e_qual_sbj.en.value='';
                                        e_qual_sbj.dis.value='';
                                        e_qual_sbj.admt.value='';
                                        e_qual_sbj.conf.value='';
                                        e_qual_sbj.sbjlist.value='1';
                                        e_qual_sbj.sReqmtId.value='<?php echo $sReqmtId; ?>';
                                        e_qual_sbj.cQualCodeId.value='<?php echo $cQualCodeId; ?>';
                                        e_qual_sbj.vQualCodeDesc.value='<?php echo $vQualCodeDesc; ?>';
                                                
                                        e_qual_sbj.used_admitted.value='<?php if (isset($_REQUEST['used_admitted'])){echo $_REQUEST['used_admitted'];}?>';
                                        
                                        e_qual_sbj.cFacultyId.value='<?php if (isset($_REQUEST['cFacultyId'])){echo $_REQUEST['cFacultyId'];} ?>';
                                        e_qual_sbj.cdept.value='<?php if (isset($_REQUEST['cdept'])){echo $_REQUEST['cdept'];} ?>';
                                        e_qual_sbj.cProgrammeId.value='<?php if (isset($_REQUEST['cProgrammeId'])){echo $_REQUEST['cProgrammeId'];} ?>';

                                        e_qual_sbj.vFacultyDesc.value='<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>';
                                        e_qual_sbj.vdeptDesc.value='<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>';
                                        e_qual_sbj.vObtQualTitle.value='<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>';
                                        e_qual_sbj.cEduCtgId.value='<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>';
                                        e_qual_sbj.vProgrammeDesc.value='<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>';
                                
                                        e_qual_sbj.cEduCtgId_1.value='<?php echo $cEduCtgId_1;?>';                                            
                                        e_qual_sbj.cEduCtgId_2.value='<?php echo $cEduCtgId_2;?>';
                                        e_qual_sbj.cEduCtgId_selected_qual.value='';
                                        e_qual_sbj.vReqmtDesc.value='<?php echo addslashes($vReqmtDesc); ?>';

                                        e_qual.iBeginLevel.value='<?php if (isset($_REQUEST['iBeginLevel'])){echo $_REQUEST['iBeginLevel'];}; ?>';

                                        e_qual_sbj.cEduCtgId.value='<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];} ?>';
                                        e_qual_sbj.vEduCtgDesc.value='<?php echo addslashes($vEduCtgDesc) ?>';
                                        e_qual_sbj.begin_level.value='<?php echo $begin_level;?>';
                                        
                                        e_qual_sbj.iQSLCount.value='<?php echo $iQSLCount ?>';
                                        e_qual_sbj.submit()">
                                            Detail
                                    </a>
                                </div>
                            </div>
                        </label><?php
                    }
                    //}
                    //$stmt->close();?>
                </div>
                <div id="new_qual" class="innercont_stff" style="margin:0px; display:<?php if ($eq == '1' || $aq == '1'){echo 'block';}else{echo 'none';}?>">
                    <form action="edit_qualification" method="post" name="e_qual" enctype="multipart/form-data">
                        <input name="sReqmtId_1" id="sReqmtId_1" type="hidden" value="<?php echo $_REQUEST['sReqmtId'];?>" />
                        <?php frm_vars();?>
                        <input name="save" id="save" type="hidden" value="-1" />
                        <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                        <input name="histgo" id="histgo" type="hidden" value="-1" />
                        <input name="cQualCodeIdTmp" id="cQualCodeIdTmp" type="hidden" value="" />
                        <input name="lowlim" id="lowlim" type="hidden"/>
                        <input name="uplim" id="uplim" type="hidden"/>
                        <!--<input name="study_mode_ID" id="study_mode_ID" type="hidden" value="odl>" />--><?php
                        if ($cEduCtgId_selected_qual == 'OL')
                        {?>
                            <input name="cEduCtgId_2_loc" id="cEduCtgId_2_loc" type="hidden" value="OL" /><?php
                        }else
                        {?>
                            <div class="innercont_stff" style="float:left; margin:0px;"><?php
                                $stmt = $mysqli->prepare("SELECT DISTINCT cEduCtgId, vEduCtgDesc 
                                FROM educationctg
                                WHERE cEduCtgId IN ('ALX','ALZ','ELZ','PSX','PSZ','PGX')
                                ORDER BY vEduCtgDesc");
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($cEduCtgId_to_select, $vEduCtgDesc_to_select);?>
                                <label for="cEduCtgId" class="labell" style="width:15%; text-align:left">
                                    Category of qualification
                                </label>
                                <div class="div_select" style="width:78.3%"><?php
                                    $cnt = 0;?>
                                    <select name="cEduCtgId_2_loc" id="cEduCtgId_2_loc" class="select" style="width:auto">
                                        <option value="" selected>Select a category</option><?php
                                            while ($stmt->fetch())
                                            {?>
                                                <option value="<?php echo $cEduCtgId_to_select;?>"<?php if ($cEduCtgId_selected_qual == $cEduCtgId_to_select && $aq <> '1'){echo ' selected';}?>><?php echo $vEduCtgDesc_to_select;?></option><?php
                                            }
                                            $stmt->close();?>
                                    </select>
                                </div>
                                <div id="labell_msg1" class="labell_msg blink_text orange_msg"></div>
                            </div><?php
                        }?>
                    </form>                    
                </div><?php
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