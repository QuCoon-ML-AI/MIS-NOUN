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
// require_once('ids_1.php');
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
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }
            
        if (_("cFacultyIdold07").value == '')
        {
            setMsgBox("labell_msg0","");
            _("cFacultyIdold07").focus();
            return false;
        }else if (_("cdeptold").value == '')
        {
            setMsgBox("labell_msg1","");
            _("cdeptold").focus();
            return false;
        }else if (_("cprogrammeIdold").value == '')
        {
            setMsgBox("labell_msg2","");
            _("cprogrammeIdold").focus();
            return false;
        }else if (_("courseLevel_old").value == ''/* && _("warned1").value < 2*/)
        {
            setMsgBox("labell_msg3","");
            _("courseLevel_old").focus();
            return false;
        }
        
        sets.vFacultyDesc.value = _("cFacultyIdold07").options[_("cFacultyIdold07").selectedIndex].text;
        sets.vProgrammeDesc.value = _("cprogrammeIdold").options[_("cprogrammeIdold").selectedIndex].text;
        
        if (sets.save.value == 1){_("sets").submit();}
    }		
    
    
    function opr_prep(ajax,formdata)
    {
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        
        ajax.open("POST", "opr_setup_facult.php");
        ajax.send(formdata);
    }		
    
    
    function completeHandler(event)
    {
        var returnedStr = event.target.responseText;
        
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
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
		<!-- InstanceBeginEditable name="EditRegion6" --><?php	
            if ($currency == '1')
            {?>
                <div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>

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

                <form action="print-result" method="post" name="prns_form" target="_blank" id="prns_form" enctype="multipart/form-data">
                    <input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];}; ?>" />
                    <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
                    <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                    <input name="side_menu_no" type="hidden" value="17" />
                    <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                    <input name="save" id="save" type="hidden" value="-1" />
                    <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                    
                    <input name="vFacultyDesc" id="vFacultyDesc" type="hidden" value="<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>" />
                    <input name="vdeptDesc" id="vdeptDesc" type="hidden" value="<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>" />
                    <input name="vProgrammeDesc" id="vProgrammeDesc" type="hidden" value="<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];}?>" />
                    
                    <input name="cFacultyIdold_prns" id="cFacultyIdold_prns" type="hidden" value="<?php if (isset($_REQUEST['cFacultyIdold07'])){echo $_REQUEST['cFacultyIdold07'];} ?>" />
                    <input name="cdeptold_prns" id="cdeptold_prns" type="hidden" value="<?php if (isset($_REQUEST['cdeptold'])){echo $_REQUEST['cdeptold'];} ?>" />
                    <input name="cprogrammeIdold_prns" id="cprogrammeIdold_prns" type="hidden" value="<?php if (isset($_REQUEST['cprogrammeIdold'])){echo $_REQUEST['cprogrammeIdold'];} ?>" />
                    
                    <input name="courseLevel" id="courseLevel" type="hidden" value="<?php if (isset($_REQUEST['courseLevel_old'])){echo $_REQUEST['courseLevel_old'];} ?>" />
                    <input name="level_options" id="level_options" type="hidden" value="<?php if (isset($_REQUEST['level_options'])){echo $_REQUEST['level_options'];} ?>" />
                    <!--<input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php //if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />-->

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
                </form>

                <div class="innercont_top">View admission criteria</div>
                <form method="post" name="sets" id="sets" enctype="multipart/form-data">
                    <input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
                    <input name="uvApplicationNo" type="hidden" value="<?php  if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
                    <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                    <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                    <input name="mm" type="hidden" value="<?php if (isset($_REQUEST["mm"])){echo $_REQUEST["mm"];}?>" />
		            <input name="sm" type="hidden" value="<?php if (isset($_REQUEST["sm"])){echo $_REQUEST["sm"];}?>" />
                    <input name="save" id="save" type="hidden" value="-1" />
                    <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                    <input name="frm_upd" id="frm_upd" type="hidden" value="0" />
                    <input name="warned1" id="warned1" type="hidden" value="0" />
                    <input name="vFacultyDesc" id="vFacultyDesc" type="hidden" />
                    <input name="vdeptDesc" id="vdeptDesc" type="hidden" />
                    <input name="vProgrammeDesc" id="vProgrammeDesc" type="hidden" />
                    <div id="cFacultyIdold07_div" class="class=innercont_structure innercont_stff" style="height:auto; margin-top:-4px; padding:0px;">
                        <!--<input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />-->

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
                        
                        <div id="cFacultyIdold07_div" class="innercont_stff">
							<label for="cFacultyIdold07" class="labell_structure">Faculty</label>
							<div class="div_select" style="width:28%;">
								<select name="cFacultyIdold07" id="cFacultyIdold07" class="select" 
									onchange="_('cdeptold').length = 0;
										_('cdeptold').options[_('cdeptold').options.length] = new Option('', '');
												
										_('cprogrammeIdold').length = 0;
										_('cprogrammeIdold').options[_('cprogrammeIdold').options.length] = new Option('', '');

                                        _('courseLevel_old').length = 0;
                                        _('courseLevel_old').options[_('courseLevel_old').options.length] = new Option('Select level', '');
												
										update_cat_country('cFacultyIdold07', 'cdeptId_readup', 'cdeptold', 'cprogrammeIdold');
                                        _('warned1').value='0'; _('sub_box_0').style.display='block'; _('sub_box_1').style.display='none';"><?php
                                        
                                        $faculty = '';
                                        if (isset($_REQUEST["cFacultyIdold07"])){$faculty = $_REQUEST["cFacultyIdold07"];}
                                        get_faculties($faculty);?>
								</select>
							</div>
							<div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
						</div>
						
						<div id="cdeptold_div" class="innercont_stff">
							<label for="cdeptold" class="labell_structure">Department</label>
							<div class="div_select" style="width:28%;">
								<select name="cdeptold" id="cdeptold" class="select" 
									onchange="_('cprogrammeIdold').length = 0;
                                    _('cprogrammeIdold').options[_('cprogrammeIdold').options.length] = new Option('', '');

                                    _('courseLevel_old').length = 0;
                                    _('courseLevel_old').options[_('courseLevel_old').options.length] = new Option('Select level', '');

                                    update_cat_country('cdeptold', 'cprogrammeId_readup', 'cprogrammeIdold', 'ccourseIdold');
                                    _('warned1').value='0'; _('sub_box_0').style.display='block'; _('sub_box_1').style.display='none';">
									<option value="" selected="selected"></option><?php
                                    if (isset($_REQUEST['cFacultyIdold07'])){
                                        $stmt = $mysqli->prepare("select cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where cFacultyId = ? order by vdeptDesc");
                                        $stmt->bind_param("s", $_REQUEST['cFacultyIdold07']);
                                        $stmt->execute();
                                        $stmt->store_result();
                                        $stmt->bind_result($cdeptId1, $vdeptDesc1);
                                        
                                        while ($stmt->fetch())
                                        {?>
                                            <option value="<?php echo $cdeptId1; ?>"<?php if (isset($_REQUEST['cdeptold']) && $cdeptId1 == $_REQUEST['cdeptold']){echo ' selected';}?>>
                                                <?php echo $vdeptDesc1;?>
                                            </option><?php
                                        }
                                        $stmt->close();
                                    }?>
								</select>
							</div>
							<div id="labell_msg1" class="labell_msg blink_text orange_msg"></div>
						</div>

						<div id="cprogrammeIdold_div" class="innercont_stff">
							<label for="cprogrammeIdold" class="labell_structure">Programme</label>
							<div class="div_select" style="width:28%;">
                                <select name="cprogrammeIdold" id="cprogrammeIdold" class="select" 
                                    onchange="set_lower_uper_limit();">
                                    <option value="" selected="selected"></option><?php                             
                                    if (isset($_REQUEST['cdeptold']))
                                    {
                                        $stmt = $mysqli->prepare("select p.cProgrammeId, p.vProgrammeDesc, o.vObtQualTitle 
                                        from programme p, obtainablequal o, depts s
                                        where p.cObtQualId = o.cObtQualId 
                                        and s.cdeptId = p.cdeptId
                                        and p.cDelFlag = s.cDelFlag
                                        and p.cDelFlag = 'N'
                                        and p.cdeptId = ?
                                        order by s.cdeptId, p.cProgrammeId");
                                        $stmt->bind_param("s", $_REQUEST['cdeptold']);
                                        $stmt->execute();
                                        $stmt->store_result();
                                        $stmt->bind_result($cProgrammeId, $vProgrammeDesc, $vObtQualTitle);

                                        while ($stmt->fetch())
                                        {
                                            $vProgrammeDesc = $vProgrammeDesc ?? '';
                                            
                                            $vProgrammeDesc_01 = $vProgrammeDesc;
                                            if (!is_bool(strpos($vProgrammeDesc,"(d)")))
                                            {
                                                $vProgrammeDesc_01 = substr($vProgrammeDesc, 0, strlen($vProgrammeDesc)-4);
                                            }?>
                                            <option value="<?php echo $cProgrammeId?>"<?php if (isset($_REQUEST['cprogrammeIdold']) && $cProgrammeId == $_REQUEST['cprogrammeIdold']){echo ' selected';}?>><?php echo $vObtQualTitle.' '.$vProgrammeDesc_01; ?></option><?php
                                        }
                                        $stmt->close();
                                    }?>
                                </select>
                                <input name="level_options" id="level_options" type="hidden" value="<?php if (isset($_REQUEST["level_options"]) && $_REQUEST["level_options"] <> ''){echo $_REQUEST["level_options"];}?>" />
							</div>
							<div id="labell_msg2" class="labell_msg blink_text orange_msg"></div>
						</div>
                        
                        <div id="level_semester_div" class="innercont_stff">
							<label for="courseLevel_old" class="labell_structure">Entry level</label>
							<div class="div_select">
                                <select name="courseLevel_old" id="courseLevel_old" class="select" style="width:auto" 
                                    onchange="prns_form.courseLevel.value=this.value; 
                                    _('sub_box_0').style.display='block'; 
                                    _('sub_box_1').style.display='none';
                                        
                                    sets.save.value='1';
                                    chk_inputs();">
                                    <option value="" selected="selected"></option><?php
                                    $t1 = begin_end_level(0);
                                    $t2 = begin_end_level(1);

                                    for ($t = $t1; $t <= $t2; $t+=100)
                                    {?>
                                        <option value="<?php echo $t ?>" <?php if (isset($_REQUEST['courseLevel_old']) && $_REQUEST['courseLevel_old'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
                                    }?>
                                </select>
							</div>
							<div id="labell_msg3" class="labell_msg blink_text orange_msg"></div>
						</div><?php
                        //$sql1 = "SELECT cFacultyId, vFacultyDesc FROM faculty WHERE cCat = 'A' ORDER BY vFacultyDesc";
                        //$rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
                    </div>
                </form><?php
            
                if (isset($_REQUEST['save']))
                {                    
                    $child_qry = " AND a.cProgrammeId LIKE '%".$_REQUEST['cprogrammeIdold']."%' ";
                    $begin_level = 100;

                    $sReqmtId_qry = '';

                    $cEduCtgId_2_qry = "cEduCtgId_2";
                    $ordering = "ORDER BY cEduCtgId_1, $cEduCtgId_2_qry, b.cMandate, c.vQualSubjectDesc";

                    $aa = get_qry_part('0', $_REQUEST['cFacultyIdold07'], $_REQUEST['cdeptold'], $_REQUEST['cprogrammeIdold'], $_REQUEST['courseLevel_old']);
                    if ($aa <> '')
                    {
                        $sReqmtId_qry = $aa;
                    }

                    $bb = get_qry_part('1', $_REQUEST['cFacultyIdold07'], $_REQUEST['cdeptold'], $_REQUEST['cprogrammeIdold'], $_REQUEST['courseLevel_old']);
                    if ($bb <> '')
                    {
                        $child_qry = $bb;
                    }

                    $cc =  get_qry_part('2', $_REQUEST['cFacultyIdold07'], $_REQUEST['cdeptold'], $_REQUEST['cprogrammeIdold'], $_REQUEST['courseLevel_old']);
                    if ($cc <> '')
                    {
                        $begin_level = $cc;
                    }
                   

                    $stmt = $mysqli->prepare("SELECT cEduCtgId_1, cEduCtgId_2, c.vQualSubjectDesc, b.cMandate, b.mutual_ex, d.cQualGradeCode
                    FROM criteriadetail a, criteriasubject b, qualsubject c, qualgrade d
                    WHERE a.cCriteriaId = b.cCriteriaId
                    AND a.cProgrammeId = b.cProgrammeId
                    AND a.sReqmtId = b.sReqmtId
                    AND b.cQualSubjectId = c.cQualSubjectId
                    AND b.cQualGradeId = d.cQualGradeId
                    AND a.cCriteriaId = ?
                    AND a.cDelFlag = 'N'
                    AND b.cDelFlag = 'N'
                    $child_qry
                    AND ((a.iBeginLevel = $begin_level 
                    $sReqmtId_qry)
                    OR a.iBeginLevel = ?)
                    ORDER BY cEduCtgId_1, cEduCtgId_2, b.cMandate, c.vQualSubjectDesc");
                    $stmt->bind_param("si",  $_REQUEST['cFacultyIdold07'],  $_REQUEST['courseLevel_old']);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($cEduCtgId_1, $cEduCtgId_2, $vQualSubjectDesc, $cMandate, $mutual_ex, $cQualGradeCode);
                    $numOfcrthd = $stmt->num_rows;
                    
                    if ($numOfcrthd == 0)
                    {
                        caution_box('Please modify your options and try again');
                    }else
                    {
                        if ($_REQUEST["courseLevel_old"] > 100 && $_REQUEST['cprogrammeIdold'] <> 'HSC201')
                        {
                            caution_box("The requiremnts for O'level and anyone of the listed higher qualifications must be met to qualifiy for this programme at the selected level");
                        }?>                        
                        <div class="innercont_stff" style="margin-bottom:1px;">
                            <div class="ctabletd_1" style="width:5.6%; background-color:#E2EBE3; border:1px solid #A7BAAD; text-align:right; padding:4px; padding-top:8px; padding-bottom:8px;">
                                Sn
                            </div>
                            <div class="ctabletd_1" style="width:60.1%; background-color:#E2EBE3; border:1px solid #A7BAAD; text-align:left; padding:4px; padding-top:8px; padding-bottom:8px;">
                                Subject
                            </div>									
                            <div class="ctabletd_1" style="width:9.4%; background-color:#E2EBE3; border:1px solid #A7BAAD; text-align:center; padding:4px; padding-top:8px; padding-bottom:8px;">
                                Compulsory
                            </div>									
                            <div class="ctabletd_1" style="width:9.2%; background-color:#E2EBE3; border:1px solid #A7BAAD; text-align:center; padding:4px; padding-top:8px; padding-bottom:8px;">
                                Optional
                            </div>						
                            <div class="ctabletd_1" style="width:10.4%; background-color:#E2EBE3; border:1px solid #A7BAAD; text-align:center; padding:4px; padding-top:8px; padding-bottom:8px;">Minimum Grade</div>
                        </div>
                                    
                        <div class="innercont_stff" id="ans2" style="height:57.5%; overflow: auto; margin-left:1px; margin-top:5px; padding:0px; padding-bottom:3px; border:0px;"><?php
                            $prev_cEduCtgId_2 = '';
                            $cnt = 0;
                            $cnt_1 = 1;

                            while($stmt->fetch())		
                            {
                                if (($_REQUEST['cprogrammeIdold'] == "MSC203" || $_REQUEST['cprogrammeIdold'] == "MSC206") && $_REQUEST['courseLevel_old'] == 200 && $cMandate == "E" && ($cEduCtgId_2 == '' || $cEduCtgId_2 == 'OL'))
                                {
                                    continue;
                                }

                                if ($vQualSubjectDesc == 'Economics' && (($_REQUEST['cdeptold'] == 'PAD' || $_REQUEST['cdeptold'] == 'BUS') && $_REQUEST['courseLevel_old'] >= 700) && ($cEduCtgId_2 == '' || $cEduCtgId_2 == 'OL') && $_REQUEST['cprogrammeIdold'] <> "MSC402")
                                {
                                    continue;
                                }
                                
                                if (($prev_cEduCtgId_2 == '' && $cnt == 0) || $prev_cEduCtgId_2 <> $cEduCtgId_2)
                                {?>
                                    <div class="innercont_stff" style="font-weight:bold; margin-top:25px; margin-bottom:-10px;"><?php 
                                        if ($cEduCtgId_2 == '' || $cEduCtgId_2 == 'OL')
                                        {
                                            if (($_REQUEST['cprogrammeIdold'] == "MSC203" || $_REQUEST['cprogrammeIdold'] == "MSC206") && $_REQUEST['courseLevel_old'] == 200 && ($cEduCtgId_2 == '' || $cEduCtgId_2 == 'OL'))
                                            {
                                                echo "O'level subjects. Minimum number of subjects: 3. Maximum number of sittings: 2";
                                            }else
                                            {
                                                echo "O'level subjects. Minimum number of subjects: 5. Maximum number of sittings: 2";
                                            }
                                        }else if ($cEduCtgId_2 == 'ALW')
                                        {
                                            echo 'AL NABTEB subjects. Minimum number of subjects: 2. Maximum number of sittings: 1';
                                        }else if ($cEduCtgId_2 == 'ALX')
                                        {
                                            echo 'AL subjects. Minimum number of subjects: 2. Maximum number of sittings: 1';
                                        }else if ($cEduCtgId_2 == 'ALZ')
                                        {
                                            echo 'NCE AL subjects. Minimum number of subjects: 2. Maximum number of sittings: 1';
                                        }else if ($cEduCtgId_2 == 'ELZ')
                                        {
                                            echo 'OND field/discipline. Minimum number of subjects: 1. Maximum number of sittings: 1';
                                        }else if (($cEduCtgId_2 == 'PSZ' || $cEduCtgId_2 == 'PSX') && $_REQUEST['courseLevel_old']  == 800 &&  ($_REQUEST['cprogrammeIdold'] == 'MSC403' || $_REQUEST['cprogrammeIdold'] == 'MSC401' || $_REQUEST['cprogrammeIdold'] == 'MSC402' || $_REQUEST['cprogrammeIdold'] == 'MSC408' || $_REQUEST['cprogrammeIdold'] == 'MSC409' || $_REQUEST['cprogrammeIdold'] == 'MSC410' || $_REQUEST['cprogrammeIdold'] == 'MSC411' || $_REQUEST['cprogrammeIdold'] == 'MSC412' || $_REQUEST['cprogrammeIdold'] == 'MSC413'))
                                        {
                                            echo 'HND/First degree field/discipline. Minimum number of subjects: 1. Maximum number of sittings: 1';
                                        }else if ($cEduCtgId_2 == 'PSX')
                                        {
                                            echo 'HND subjects. Minimum number of subjects: 1. Maximum number of sittings: 1';
                                        }else if ($cEduCtgId_2 == 'PSZ')
                                        {
                                            echo 'First degree field/discipline. Minimum number of subjects: 1. Maximum number of sittings: 1';
                                        }else if ($cEduCtgId_2 == 'PGX')
                                        {
                                            echo 'Post graduate diploma field/discipline. Minimum number of subjects: 1. Maximum number of sittings: 1';
                                        }?>
                                    </div><?php
                                    $cnt = 0;
                                }                                

                                if ($cEduCtgId_2 == 'PSZ' && $begin_level = 200 && $_REQUEST['cprogrammeIdold'] == 'ART209')
                                {?>
                                    <div class="innercont_stff">
                                        <label class="lbl_beh">
                                            Any field/discipline with a minimum grade of Second lower
                                        </label>
                                    </div><?php
                                    break;
                                }

                                if (($cEduCtgId_2 == 'PSZ' || $cEduCtgId_2 == 'PSX') && $begin_level = 800 && ($_REQUEST['cprogrammeIdold'] == 'MSC403' || $_REQUEST['cprogrammeIdold'] == 'MSC401' || $_REQUEST['cprogrammeIdold'] == 'MSC402' || $_REQUEST['cprogrammeIdold'] == 'MSC408' || $_REQUEST['cprogrammeIdold'] == 'MSC409' || $_REQUEST['cprogrammeIdold'] == 'MSC410' || $_REQUEST['cprogrammeIdold'] == 'MSC411' || $_REQUEST['cprogrammeIdold'] == 'MSC412' || $_REQUEST['cprogrammeIdold'] == 'MSC413'))
                                {?>
                                    <div class="innercont_stff">
                                        <label class="lbl_beh">
                                            Any field/discipline with a minimum grade of third class for first degree and upper credit for HND<p>
                                            Candidate who possess HND below uppper credit will be required to have a PGD in Business Administration
                                            </p>
                                        </label>
                                    </div><?php
                                    break;
                                }
                                
                                
                                
                                if ($mutual_ex == 1){$text_color='#a87903';}else if ($mutual_ex == 2){$text_color='#0656b8';}else if ($mutual_ex == 3){$text_color='#05ad42';}else{$text_color='#000000';}

                                if ($cnt%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
                                <div class="innercont_stff" style="margin-bottom:1px;">
                                    <label class="lbl_beh">
                                        <div class="_label" style="border:1px solid #cdd8cf; width:5.5%; padding:5px; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; text-align:right">
                                            <?php echo ++$cnt; ?>
                                        </div>
                                        
                                        <div class="_label" style="border:1px solid #cdd8cf; width:61%; padding:5px; padding-top:8px; padding-bottom:8px; text-align:left; background-color:<?php echo $background_color;?>; color:<?php echo $text_color;?>">
                                            <?php if ($mutual_ex == 1){echo '*';}else if ($mutual_ex == 2){echo '**';}else if ($mutual_ex == 32){echo '***';} 
                                            echo $vQualSubjectDesc;
                                            if ($mutual_ex <> 0){echo ' (This is an alternative to any other similarly marked subject)';} ?>
                                        </div>									
                                        <div class="_label" style="border:1px solid #cdd8cf; width:9.4%; padding:5px; padding-top:8px; padding-bottom:8px; text-align:center; background-color:<?php echo $background_color;?>;">
                                            <?php if ($cMandate == 'C'){echo '<font color="#3aa238">Yes</font>';}else{echo '<font color="#f52e2e">No</font>';} ?>
                                        </div>									
                                        <div class="_label" style="border:1px solid #cdd8cf; width:9.1%; padding:5px; padding-top:8px; padding-bottom:8px; text-align:center; background-color:<?php echo $background_color;?>;">
                                            <?php if ($cMandate <> 'C'){echo '<font color="#3aa238">Yes</font>';}else{echo '<font color="#f52e2e">No</font>';}?>
                                        </div>						
                                        <div class="_label" style="border:1px solid #cdd8cf; width:8.6%; padding:5px; padding-top:8px; padding-bottom:8px; text-align:center; background-color:<?php echo $background_color;?>;">
                                            <?php echo $cQualGradeCode ?>
                                        </div>
                                    </label>
                                </div><?php

                                if (($cEduCtgId_2 == 'PSZ' || $cEduCtgId_2 == 'PSX') && $_REQUEST['courseLevel_old']  == 700 && $_REQUEST['cdeptold'] == 'BUS')
                                {
                                    if ($cEduCtgId_2 == 'PSX')
                                    {
                                        if ($cnt_1 == 6)
                                        {?>
                                            <div class="innercont_stff">
                                                <label class="lbl_beh">
                                                    ...and any other field/discipline with a minimum grade of lower credit
                                                </label>
                                            </div><?php
                                            $cnt_1 = 1;
                                        }else
                                        {
                                            $cnt_1++;
                                        }
                                    }else if ($cEduCtgId_2 == 'PSZ')
                                    {
                                        if ($cnt_1 == 7)
                                        {?>
                                            <div class="innercont_stff">
                                                <label class="lbl_beh">
                                                    ...and any other field/discipline with a minimum grade of pass
                                                </label>
                                            </div><?php
                                            $cnt_1 = 1;
                                        }else
                                        {
                                            $cnt_1++;
                                        }
                                    }
                                }
                                $prev_cEduCtgId_2 = $cEduCtgId_2;
                            }
                            $stmt->close();?>
                        </div><?php
                    }?><?php                    
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