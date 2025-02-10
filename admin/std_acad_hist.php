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

$spgs_msg = '';

/*if (($mm == 0 && $sm >= 9) || $mm == 1 || $mm == 8 || $mm == 3 || ($mm == 2 && $sm > 1) || ($mm == 4) || $mm == 5)
{   
    if ($mm == 8 && $cEduCtgId <> 'PGX' && $cEduCtgId <> 'PGY' && $cEduCtgId <> 'PGZ' && $cEduCtgId <> 'PRX')
    {
        $spgs_msg = 'Matriculaton number must be that of an MPhil, PhD or postgraduate student';
    }else if ($mm == 1 && ($cEduCtgId == 'PRX' || $cEduCtgId == 'PGZ'))
    {
        $spgs_msg = 'Matriculaton number must be that of an undergraduate, PGD or Masters student';
    }else if ($sRoleID_u == 29 && is_bool(strpos($cProgrammeId, 'CHD')))
    {
        $spgs_msg = 'Matriculaton number must be that of a certificate student in CHRD';
    }else if ($sRoleID_u == 26 && is_bool(strpos($cProgrammeId, 'DEG')))
    {
        $spgs_msg = 'Matriculaton number must be that of a certificate student in DE&GS';
    }
}*/?>

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
        var numbers = /^[NOUNSLPC0-9_]+$/;

		var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}
				
		if (_('acad_rec').uvApplicationNo.value == '')
		{
			setMsgBox("labell_msg0","");
			_('acad_rec').uvApplicationNo.focus();
		}else if (!_('acad_rec').uvApplicationNo.value.match(numbers))
        {
            setMsgBox("labell_msg0","Invalid number");
			_('acad_rec').uvApplicationNo.focus();
        }else if(marlic(_('acad_rec').uvApplicationNo.value)!='')
		{
			setMsgBox("labell_msg0",marlic(_('acad_rec').uvApplicationNo.value));
			_('acad_rec').uvApplicationNo.focus();
			return false;
		}else
		{
			_("acad_rec").submit();
            return;			
		}
	}

    function opr_prep_img(ajax,formdata)
    {
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        
        ajax.open("POST", "../appl/opr_s5.php");
        ajax.send(formdata);
    }

    function completeHandler(event)
    {
        on_error('0');
        on_abort('0');
        in_progress('0');
        
        if (event.target.responseText.indexOf("Invalid") == -1 && _("loadcred").value != 1)
        {
            _("acad_rec").submit();
        }else if (_("loadcred").value == 1)
        {
            _("container_cover_in").style.zIndex = 1;
            _("container_cover_in").style.display = 'block';

            if (_('fil_ex').value == 'g')
            {
                _("credential_img").src = event.target.responseText;
            }
            
            _("imgClose").focus();
            _("loadcred").value = 0;
            
            _("labell_msg0").innerHTML = "";
            _("labell_msg0").style.display = 'none';
        }else
        {
            setMsgBox("labell_msg0", event.target.responseText);
        }
    }

    function tab_modify(tab_no)
    {
        if (tab_no == 6)
        {
            // if (_('acad_rec').tabno.value == 2)
            // {
            //     _('prns_form').side_menu_no.value = 7;
                
            // }else if (_('acad_rec').tabno.value == 3)
            // {
            //     _('prns_form').side_menu_no.value = 10;
            // }else if (_('acad_rec').tabno.value == 4)
            // {
            //     _('prns_form').side_menu_no.value = 16;
            // }else if (_('acad_rec').tabno.value == 5)
            // {
            //     _('prns_form').side_menu_no.value = 5;
            // }
            
            _('prns_form').tabb.value = _('acad_rec').tabno.value;
            _('prns_form').submit();
        }else
        {
            if (tab_no != 1 && tab_no != 5)
            {
                _("tabss6").style.display = 'block'; 
                _('acad_rec').tabno.value = tab_no;
            }else
            {
                _("tabss6").style.display = 'none';
            }
            
            tablinks = document.getElementsByClassName("innercont_stff_tabs");
            for (i = 0; i < tablinks.length; i++) 
            {
                var tab_Id = 'tabss' + (i+1);
                var cover_maincontent_id = 'ans' + (i+1);
                if (tab_no == (i+1))
                {
                    _(tab_Id).style.borderBottom = '1px solid #FFFFFF';
                    _(cover_maincontent_id).style.visibility = 'visible';
                    _(cover_maincontent_id).style.display = 'block';
                }else
                {
                    _(tab_Id).style.border = '1px solid #BCC6CF';
                    _(cover_maincontent_id).style.visibility = 'hidden';
                    _(cover_maincontent_id).style.display = 'none';
                }
            }
        }
    }


    function call_image()
    {
        var formdata = new FormData();
        
        _("loadcred").value = 1;
        
        formdata.append("loadcred",_("loadcred").value);
        formdata.append("ilin", _('acad_rec').ilin.value);
        formdata.append("user_cat", _('acad_rec').user_cat.value);
        
        formdata.append("vApplicationNo", _('acad_rec').vApplicationNo_img.value);
        
        formdata.append("vExamNo", _('acad_rec').vExamNo.value);
        formdata.append("cQualCodeId", _('acad_rec').cQualCodeId.value);
        
        opr_prep_img(ajax = new XMLHttpRequest(),formdata);
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
    <?php admin_frms(); $has_matno = 0;

    $stmt = $mysqli->prepare("SELECT f_type FROM pics a, afnmatric b
    WHERE a.vApplicationNo = b.vApplicationNo
    AND cinfo_type = 'C'
    AND vMatricNo = ? LIMIT 1");

    //$stmt = $mysqli->prepare("SELECT f_type FROM pics WHERE cinfo_type = 'C' AND vApplicationNo = ?");
    $stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($f_type);
    $stmt->fetch();
    $f_type = $f_type ?? '';

    $f_name = '';
    if ($f_type == 'f')
    {
        //compose file name
        $f_name = call_f_file();
    }?>
	
	<form action="staff_home_page" method="post" name="nxt" id="nxt" enctype="multipart/form-data">
		<input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
        <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" />
		<input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST['vMatricNo'])){echo $_REQUEST['vMatricNo']; }?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
		<input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		
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
    <div id="container_cover_in" 
        style="background:#FFFFFF;
        left:5px;
        top:5px;
        height:97%;
        width:500px; 
        float:left;
        box-shadow: 4px 4px 3px #888888;
        display:none; 
        position:absolute;
        text-align:center; 
        padding:5px;
        border: 1px solid #696969;
        opacity: 0.9;
        font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px">
            <div id="inner_submityes_header0" style="width:494px;
                height:15px;
                padding:3px; 
                float:left;
                text-align:right;">
                    <a id="imgClose" href="#"
                        onclick="_('container_cover_in').style.display = 'none';
                        _('container_cover_in').style.zIndex = -1;return false" 
                        style="color:#666666; margin-right:3px; text-decoration:none;text-shadow: 0 1px 0 #fafafa;"><img style="width:17px; height:17px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>"/></a>
            </div>
            
            <div id="inner_submityes_g1" 
                style="width:inherit; 
                height:96%;
                border-radius:3px; 
                text-align:center; 
                float:left;
                top:15px; 
                z-index:-1;
                position:absolute;
                display:block;"><?php
                if ($f_type == 'g')
                {?>
                    <img id="credential_img" style="width:100%; height:100%"/><?php
                }else if ($f_type == 'f')
                {?>
                    <iframe id="credential_img" src="<?php echo $f_name;?>" style="width:100%; height:100%;" frameborder="0"></iframe><?php
                }?>
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
		<!-- InstanceBeginEditable name="EditRegion6" -->			
			
            <div id="smke_screen_2" class="smoke_scrn" style="display:none"></div><?php
            $staff_can_access = 1;
            $staff_study_center = '';

            
            /*if (isset($_REQUEST['vApplicationNo']))
            {
                if (isset($_REQUEST['user_centre']) && $_REQUEST['user_centre'] <> '')
                {
                    $staff_study_center = $_REQUEST['user_centre'];
                }
                $staff_study_center_new = str_replace("|","','",$staff_study_center);
                $staff_study_center_new = substr($staff_study_center_new,2,strlen($staff_study_center_new)-4);
                
                if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                {
                    $mysqli_arch = link_connect_db_arch();
                    $stmt = $mysqli_arch->prepare("SELECT concat(b.vCityName,' centre')  
                    from arch_s_m_t a, studycenter b
                    WHERE a.cStudyCenterId = b.cStudyCenterId
                    AND a.cStudyCenterId IN ($staff_study_center_new) 
                    AND a.vMatricNo = ?");
                }else
                {
                    $ref_table = src_table("s_m_t");
                    $stmt = $mysqli->prepare("SELECT concat(b.vCityName,' centre')  
                    from $ref_table a, studycenter b
                    WHERE a.cStudyCenterId = b.cStudyCenterId
                    AND a.cStudyCenterId IN ($staff_study_center_new) 
                    AND a.vMatricNo = ?");
                }
                $stmt->bind_param("s", $_REQUEST['uvApplicationNo']);			
                $stmt->execute();
                $stmt->store_result();
    
                $stmt->bind_result($vCityName);
                $stmt->fetch();
                
                $staff_can_access = $stmt->num_rows;
                $stmt->close();
            }*/?>

            <div class="innercont_top">View student's academic record</div>
            <form action="print-result" method="post" name="prns_form" target="_blank" id="prns_form" enctype="multipart/form-data">
                <input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];}; ?>" />
                <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
                <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                <input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
                <input name="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
		        <input name="sm" id="sm" type="hidden" value="<?php if (isset($_REQUEST["sm"])){echo $_REQUEST["sm"];} ?>" />
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <input name="save" id="save" type="hidden" value="-1" />
                <input name="tabb" id="tabb" type="hidden" value="" />
                <input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />

                <!-- <input name="study_mode" id="study_mode" type="hidden" value="<?php //if (isset($_REQUEST["study_mode"]) && $_REQUEST["study_mode"] <> ''){echo $_REQUEST["study_mode"];}else if ($num_of_mode <= 1){echo $study_mode;}?>" />	 -->

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

                <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php echo $cEduCtgId_su;?>" />

                <input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>

            </form>
            
            <form name="acad_rec" method="post" id="acad_rec" enctype="multipart/form-data">
                <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
                <input name="vApplicationNo_img" type="hidden" />
                <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];} ?>" />	
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <input name="sm" id="sm" type="hidden" value="<?php echo $sm ?>" />
                <input name="mm" id="mm" type="hidden" value="<?php echo $mm ?>" />
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                <input name="tabno" id="tabno" type="hidden"/>
                <input name="cQualCodeId" type="hidden" value="" />
                <input name="vExamNo" type="hidden" value="" />
                <input name="loadcred" id="loadcred" type="hidden" value="" />
                
                <input name="can_see_detail" id="can_see_detail" type="hidden" value="1" />

                <input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />

                <!-- <input name="study_mode" id="study_mode" type="hidden" value="<?php //if (isset($_REQUEST["study_mode"]) && $_REQUEST["study_mode"] <> ''){echo $_REQUEST["study_mode"];}else if ($num_of_mode <= 1){echo $study_mode;}?>" />	 -->

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
                <input name="fil_ex" id="fil_ex" type="hidden" value="<?php echo $f_type; ?>" />
                
                <div class="innercont_stff" id="enq_div">
                    <label for="uvApplicationNo" class="labell">
                        <?php if (($mm == 0 && $sm == 10) || (($mm == 1 || $mm == 8) && $sm > 7) || ($mm == 3 && $sm > 4) || ($mm == 4 && $sm == 4) || ($mm == 5 && $sm == 5) || ($mm == 2 && $sm == 3)){echo 'Matriculation number';}else{echo 'Application form number';}?>
                    </label>
                    <div class="div_select">
                        <input name="uvApplicationNo" id="uvApplicationNo" 
                            type="text" 
                            class="textbox"
                            maxlength="25"
                            onchange="this.value=this.value.replace(/ /g, '');
                            this.value=this.value.toUpperCase();" required 
                            placeholder="Enter matriculation number here"/>
                    </div>
                    <div id="labell_msg0" class="labell_msg blink_text orange_msg" style="width:auto; margin-right:4px;"></div>
                    <!-- <div class="div_select" style="width:auto">
                        <select name="faculty_u_no" id="faculty_u_no" style="height:100%;"><?php
                            //$faculty_u_no = '';
                            //if (isset($_REQUEST["faculty_u_no"])){$faculty_u_no = $_REQUEST["faculty_u_no"];}
                            //get_faculties_if_u_know($faculty_u_no);?>
                        </select> 
                    </div> -->
                </div>
            </form><?php 
            /*if (check_scope2('Academic registry','Archive') > 0 && isset($_REQUEST["mm"]) && $_REQUEST["mm"] == 4)
            {?>
                <div class="innercont_stff" style="width:auto; height:auto; position:absolute; right:100px; top:32px;">
                    <label for="arch_mode" class="lbl_beh" for="arch_modeall" style="float:right;"> 
                        <div class="div_select" style="width:20px; height:25px; padding:5px; background:#f3f3f3">   
                            <input name="arch_mode" id="arch_mode" type="checkbox" 
                                onclick="if (this.checked)
                                {
                                    nxt.arch_mode_hd.value='1';
                                    cf.arch_mode_hd.value='1';
                                    std_acad_hist.arch_mode_hd.value='1';
                                    chk_pay_sta.arch_mode_hd.value='1';
                                    vw_std_acnt_stff.arch_mode_hd.value='1';
                                    std_stat.arch_mode_hd.value='1';
                                    acad_rec.arch_mode_hd.value='1';
                                    prns_form.arch_mode_hd.value='1';
                                }else
                                {
                                    nxt.arch_mode_hd.value='0';
                                    cf.arch_mode_hd.value='0';
                                    std_acad_hist.arch_mode_hd.value='0';
                                    chk_pay_sta.arch_mode_hd.value='0';
                                    vw_std_acnt_stff.arch_mode_hd.value='0';
                                    std_stat.arch_mode_hd.value='0';
                                    acad_rec.arch_mode_hd.value='0';
                                    prns_form.arch_mode_hd.value='0';
                                }" 
                                <?php if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1'){echo 'checked';} ?>/>
                        </div>
                        <div class="div_select" style="width:130px; height:25px; padding:5px; margin-right:0px; background:#f3f3f3">
                            Look in the archive
                        </div>                   
                    </label>
                </div><?php
            }*/

            if (check_scope2('SPGS', 'SPGS menu') > 0)
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="pg_environ.mm.value=8;pg_environ.sm.value='';pg_environ.submit();return false;">
                    <div class="rtlft_inner_button" style="position:absolute; right:0; top:20px; padding:10px; width:auto; height:auto">
                        SPGS menu
                    </div>
                </a><?php
            }

            if ($student_user_num <= 0)
            {
                if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                {
                    caution_box('Student\'s record is not in the archive');
                }else if (isset($_REQUEST["uvApplicationNo"]) && trim($_REQUEST["uvApplicationNo"]) <> '' && check_grad_student($_REQUEST["uvApplicationNo"]) == 0)
                {
                    caution_box('Invalid matriculation number');
                }
            }/*else if ($staff_can_access == 0 && isset($_REQUEST['can_see_detail'])&&$_REQUEST['can_see_detail']<>'')
            {
                $msg = "Record not found<br>Possible reasons are<br> (a) Student study centre does not match that of staff that is logged in<br> (b) Record not in selected faculty";
                caution_box($msg);
            }*/else if ($spgs_msg <> '')
            {
                caution_box($spgs_msg);
            }else
            {
                if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
                {
                    caution_box('Matriculation number graduated');
                }?>
                <div class="innercont_stff" style="display:<?php if (isset($_REQUEST['can_see_detail'])&&$_REQUEST['can_see_detail']<>''){?>block<?php }else{?>none<?php }?>;">  
                    <div id="cover_tab" class="frm_element_tab_cover frm_element_tab_cover_std">
                        <a id="tabss6" href="#" onclick="tab_modify('6')" style="display:none">
                            <input type="button" value="Print" class="basic_three_stff_bck_btns" 
                                style="float:right; width:80px; margin-top:-1px; padding:10px; margin-right:-1px;"/>
                        </a>    
                        
                        <a href="#" onclick="tab_modify('1')">
                            <div id="tabss1" class="tabss tabss_std" style=" border-bottom:1px solid #FFFFFF;">
                                Current
                            </div>
                        </a>
                        <a href="#" onclick="prns_form.side_menu_no.value='see_all_registered_courses';tab_modify('2')">
                            <div id="tabss2" class="tabss tabss_std">
                                Course registration
                            </div>
                        </a>
                        <a href="#" onclick="prns_form.side_menu_no.value='see_all_registered_courses_for_exam';tab_modify('3')">
                            <div id="tabss3" class="tabss tabss_std">
                                Exam registration
                            </div>
                        </a>
                        <a href="#" onclick="caution_box('Visit ERP'); _('tabss6').style.display = 'none'; return false;">
                            <div id="tabss4" class="tabss tabss_std">
                                Result
                            </div>
                        </a>
                        <a href="#" onclick="tab_modify('5')">
                            <div id="tabss5" class="tabss tabss_std">
                                History
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="innercont_stff_tabs" id="ans1" style="height:81%; display:<?php if (isset($_REQUEST['can_see_detail'])&&$_REQUEST['can_see_detail']<>''){?>block<?php }else{?>none<?php }?>;"><?php
                    if ($student_user_num == 0 && $sRoleID <> 6)
                    {?>
                        <div id="succ_boxt" class="succ_box blink_text orange_msg" style="width:auto; display:block;margin-bottom:2px;">
                            Students needs to sign up to bring up his/her record here
                        </div><?php	
                    }else if ($student_user_num == -1)
                    {?>
                        <div id="succ_boxt" class="succ_box blink_text orange_msg" style="width:auto; display:block;margin-bottom:2px;"><?php 
                            if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
                            {
                                echo 'Matriculation number graduated';
                            }else if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                            {
                                caution_box_inline('Matriculation number not in the archive');
                            }else
                            {
                                echo 'Invalid matriculation number';
                            }?>                                
                        </div><?php	
                    }else
                    {?>
                        <div class="innercont_stff" style="margin-top:8px;">
                            <div class="div_label">
                                Matriculation number
                            </div>
                            <div  class="div_valu">
                                <b><?php echo $_REQUEST['uvApplicationNo'];?></b>
                            </div>	
                        </div>
                        <div class="innercont_stff" style="margin-top:8px;">
                            <div class="div_label">
                                Faculty
                            </div>
                            <div  class="div_valu">
                                <b><?php echo $vFacultyDesc_su;?></b>
                            </div>	
                        </div>
                        <div class="innercont_stff">
                            <div class="div_label">
                                Department
                            </div>
                            <div  class="div_valu">
                                <b><?php echo $vdeptDesc_su;?></b>
                            </div>	
                        </div>
                        <div class="innercont_stff">
                            <div class="div_label">
                                Programme
                            </div>
                            <div  class="div_valu">
                                <b><?php if ($vObtQualTitle == 'N. D.,')
                                {
                                    echo $vObtQualTitle_su.' '.substr($vProgrammeDesc_su, 0, strlen($vProgrammeDesc)-4);
                                }else{echo $vObtQualTitle_su.' '.$vProgrammeDesc_su;}?></b>
                            </div>	
                        </div>
                        <div class="innercont_stff">
                            <div class="div_label">
                                Entry level
                            </div>
                            <div  class="div_valu">
                                <b><?php echo $entry_level_su;?></b>
                            </div>	
                        </div>
                        
                        <div class="innercont_stff">
                            <div class="div_label">
                                Current level
                            </div>
                            <div  class="div_valu">
                                <b><?php echo $iStudy_level_su;?></b>
                            </div>	
                        </div>
                        
                        <div class="innercont_stff">
                            <div class="div_label">
                                Semester
                            </div>
                            <div  class="div_valu">
                                <b><?php if ($tSemester_su%2 == 0){echo 'Second';}else{echo 'First';}
                                if ($cEduCtgId_su <> 'PSZ' && $cEduCtgId_su <> 'ELX')
                                {
                                    echo " (".$tSemester_su.")";
                                }?></b>
                            </div>
                        </div>
                        
                        <div class="innercont_stff">
                            <div class="div_label">
                                Registered
                            </div>
                            <div  class="div_valu">
                                <b><?php if ($tSemester_reg_su == '1'){echo 'Yes';}else{echo 'No';}?></b>
                            </div>
                        </div>
                        
                        <div class="innercont_stff">
                            <div class="div_label">
                                Study centre
                            </div>
                            <div  class="div_valu">
                                <b><?php echo $vCityName_su;?></b>
                            </div>	
                        </div><?php
                    }?>
                </div><?php 

                $sql_feet_type = select_fee_srtucture($_REQUEST["uvApplicationNo"], $cResidenceCountryId_su, $cEduCtgId_su);?>
                <div class="innercont_stff_tabs" id="ans2" style="height:77.5%">
                    <div class="innercont_stff" style="font-weight:bold;">
                        <div class="ctabletd_1" style="width:3.8%; height:auto; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:right; border-radius:0px;">Sn</div>
                        <div class="ctabletd_1" style="width:9.3%; height:auto; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2;  text-align:left;">Course Code</div>
                        <div class="ctabletd_1" style="width:45.2%; height:auto; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:left;">Course Title</div>
                        <div class="ctabletd_1" style="width:7.6%; height:auto; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:right;">Cr. Unit</div>
                        <div class="ctabletd_1" style="width:6.6%; height:auto; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:center;">Category</div>
                        <div class="ctabletd_1" style="width:6.6%; height:auto; padding-right:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:right;">Fee</div>
                        <div class="ctabletd_1" style="width:17.2%; height:auto; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:center;border-radius: 0px;">Date</div>
                    </div><?php
                    if ($student_user_num == 0)
                    {
                        caution_box_inline_bkp('Students needs to sign up to bring up his/her record here');
                    }else if ($student_user_num == -1)
                    {
                        if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
                        {
                            caution_box_inline_bkp('Matriculation number graduated');
                        }else if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                        {
                            caution_box_inline('Matriculation number not in the archive');
                        }else
                        {
                            caution_box_inline_bkp('Invalid matriculation number');
                        }
                    }else
                    {?>
                        <div class="innercont_stff" style="height:83%; margin-bottom:5px; overflow:scroll; overflow-x: hidden;"><?php
                            $background_color='#dbe3dc';
                            $c = 0; $total_cost = 0; 
                            $total_cr = 0;

                            $prev_sem = '';
                            $prev_lev = '';
                            
                            $table = search_starting_pt_crs($_REQUEST['uvApplicationNo']);
                
                            foreach ($table as &$value)
                            {
                                $wrking_tab = 'coursereg_arch_'.$value;
                                $stmt = $mysqli->prepare("SELECT d.cCourseId, d.vCourseDesc, d.siLevel, d.tSemester, d.tdate, d.iCreditUnit, d.cAcademicDesc, d.cCategory
                                FROM $wrking_tab d
                                WHERE d.vMatricNo = ? 
                                ORDER BY d.siLevel, d.tSemester, d.cCourseId");
                                $stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
                                $stmt->execute();
                                $stmt->store_result();

                                $stmt->bind_result($cCourseId, $vCourseDesc, $siLevel, $tSemester_01, $tdate, $iCreditUnit, $cAcademicDesc_01, $cCategory);
                                while($stmt->fetch())
                                {
                                    $ref_table = src_table("s_f_s");
                                    $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                                    FROM $ref_table a, fee_items b
                                    WHERE a.fee_item_id = b.fee_item_id
                                    AND fee_item_desc = 'Course Registration'
                                    AND iCreditUnit = $iCreditUnit
                                    AND cEduCtgId = '$cEduCtgId_su'
                                    AND cFacultyId = '$cFacultyId_su'
                                    $sql_feet_type");

                                    $stmt_amount->execute();
                                    $stmt_amount->store_result();
                                    $stmt_amount->bind_result($Amount, $itemid);
                                    $stmt_amount->fetch();
                                    $stmt_amount->close();

                                    if (is_null($Amount))
                                    {
                                        $Amount = 0;
                                    }
                                    $c++;

                                    if ($prev_sem == '' || $prev_lev == '' || $prev_lev <> $siLevel || $prev_sem <> $tSemester_01)
                                    {
                                        if ($tSemester_01 == 1)
                                        {
                                            $tSemester_desc = 'First semester';
                                        }else
                                        {
                                            $tSemester_desc = 'Second semester';
                                        }?>
                                        <div class="_label" style="border:1px solid #cdd8cf; width:98.2%; padding-left:0.4%; padding-top:0.8%; padding-bottom:0.7%; text-align:left; font-weight:bold; margin-top:10px; background-color:#FFFFFF;">
                                            <?php echo $siLevel.'L '.$tSemester_desc;?>
                                        </div><?php
                                    }

                                    if ($c%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
                                    <label class="lbl_beh">
                                        <div class="innercont_stff">
                                            <div class="_label" style="margin-left:-1px; border:1px solid #cdd8cf; width:3.5%; padding-top:0.8%; padding-bottom:0.7%; text-align:right; background-color:<?php echo $background_color;?>;">
                                                <?php echo $c;?>
                                            </div>

                                            <div class="_label" style="border:1px solid #cdd8cf; width:9.2%; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; text-align:left; background-color:<?php echo $background_color;?>;">
                                                <?php echo $cCourseId; ?>
                                            </div>
                                            
                                            <div class="_label" style="border:1px solid #cdd8cf; width:45.6%; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; text-align:left; background-color:<?php echo $background_color;?>;">
                                                <?php echo $vCourseDesc;?>
                                            </div>

                                            <div class="_label" style="border:1px solid #cdd8cf; width:7.1%; text-align:right; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:<?php echo $background_color;?>;">
                                                <?php echo $iCreditUnit; $total_cr = $total_cr + $iCreditUnit;?>
                                            </div>

                                            <div class="_label" style="border:1px solid #cdd8cf; width:6.1%; text-align:center; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:<?php echo $background_color;?>;">
                                                <?php if ($cCategory <> ''){echo $cCategory;}else{echo '.';}?>
                                            </div>

                                            <div class="_label" style="border:1px solid #cdd8cf; width:6.3%; text-align:right; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:<?php echo $background_color;?>;">
                                                <?php echo number_format($Amount);$total_cost = $total_cost + $Amount;?>
                                            </div>

                                            <div class="_label" style="border:1px solid #cdd8cf; width:14.8%; text-align:center; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:<?php echo $background_color;?>;">
                                                <?php echo $tdate;?>
                                            </div>
                                        </div>
                                    </label><?php

                                    $prev_sem = $tSemester_01;
                                    $prev_lev = $siLevel;
                                }
                            }
                            $stmt->close();?>
                        </div>
                        <label class="lbl_beh" style="font-weight:bold;">
                            <div class="_label" style="border:1px solid #cdd8cf; width:59%; padding:5px; text-align:right; background-color:<?php echo $background_color;?>;">
                                Total
                            </div>

                            <div class="_label" style="border:1px solid #cdd8cf; width:7.1%; text-align:right; padding:5px; background-color:<?php echo $background_color;?>;">
                                <?php echo $total_cr; ?>
                            </div>

                            <div class="_label" style="border:1px solid #cdd8cf; width:5.9%; text-align:center; padding:5px; background-color:<?php echo $background_color;?>;">
                                --
                            </div>

                            <div class="_label" style="border:1px solid #cdd8cf; width:6.2%; text-align:right; padding:5px; background-color:<?php echo $background_color;?>;">
                                <?php echo number_format($total_cost);?>
                            </div>

                            <div class="_label" style="border:1px solid #cdd8cf; width:14.9%; text-align:center; padding:5px; background-color:<?php echo $background_color;?>;">
                                --
                            </div>
                        </label><?php

                        if ($c == 0)
                        {
                            caution_box_inline_bkp('Student has not registered any course');
                        }
                    }?>
                </div><?php

                $c = 0;
                
                if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                {
                    $mysqli_arch = link_connect_db_arch();
                    $stmt = $mysqli_arch->prepare("SELECT a.cCourseId, a.vCourseDesc, d.siLevel, d.tSemester, d.tdate, a.iCreditUnit, d.cAcademicDesc, a.cCategory
                    FROM arch_coursereg_arch a, arch_s_m_t c, arch_examreg d
                    WHERE  a.cCourseId = d.cCourseId
                    AND c.vMatricNo = d.vMatricNo
                    AND c.vMatricNo = ? 
                    ORDER BY d.siLevel, d.tSemester, d.cCourseId");
                }else
                {
                    $ref_table = src_table("coursereg_arch");
                    $ref_table1 = src_table("s_m_t");
                    $stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, d.siLevel, d.tSemester, d.tdate, a.iCreditUnit, d.cAcademicDesc, a.cCategory
                    FROM $ref_table a, $ref_table1 c, examreg d
                    WHERE  a.cCourseId = d.cCourseId
                    AND c.vMatricNo = d.vMatricNo
                    AND c.vMatricNo = ? 
                    ORDER BY d.siLevel, d.tSemester, d.cCourseId");
                }
                $stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
                $stmt->execute();
                $stmt->store_result();
                
                $stmt->bind_result($cCourseId, $vCourseDesc, $siLevel, $tSemester_01, $tdate, $iCreditUnit, $cAcademicDesc_01, $cCategory);?>
                <div class="innercont_stff_tabs" id="ans3" style="height:78%">
                    <div class="innercont_stff" style="font-weight:bold;">
                        <div class="ctabletd_1" style="width:3.8%; height:auto; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:right; border-radius:0px;">Sn</div>
                        <div class="ctabletd_1" style="width:9.3%; height:auto; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2;  text-align:left;">Course Code</div>
                        <div class="ctabletd_1" style="width:44.5%; height:auto; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:left;">Course Title</div>
                        <div class="ctabletd_1" style="width:7.6%; height:auto; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:right;">Cr. Unit</div>
                        <div class="ctabletd_1" style="width:6.6%; height:auto; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:center;">Mandate</div>
                        <div class="ctabletd_1" style="width:6.6%; height:auto; padding-right:0.4%; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:right;">Fee</div>
                        <div class="ctabletd_1" style="width:17.5%; height:auto; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:center;border-radius: 0px;">Date</div>
                    </div><?php
                    if ($student_user_num == 0)
                    {
                        caution_box_inline_bkp_b('Students needs to sign up to bring up his/her record here');
                    }else if ($student_user_num == -1)
                    {
                        if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
                        {
                            caution_box_inline_bkp_b('Matriculation number graduated');
                        }else if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                        {
                            caution_box_inline('Matriculation number not in the archive');
                        }else
                        {
                            caution_box_inline_bkp_b('Invalid matriculation number');
                        }
                    }else
                    {?>
                        <div class="innercont_stff" style="height:86%; margin-bottom:5px; overflow:scroll; overflow-x: hidden;"><?php
                            $c = 0; $total_cost = 0; 
                            $total_cr = 0;

                            $prev_sem = '';
                            $prev_lev = '';
                            
                            $table = search_starting_pt_crs($_REQUEST['uvApplicationNo']);
                
                            foreach ($table as &$value)
                            {
                                $wrking_exam_tab = 'examreg_'.$value;
                        
                                $stmt = $mysqli->prepare("SELECT cCourseId, silevel, cAcademicDesc, tSemester, tdate
                                FROM $wrking_exam_tab 
                                WHERE vMatricNo = ? 
                                ORDER BY cAcademicDesc, tSemester, cCourseId");
                                
                                $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($cCourseId, $siLevel, $cAcademicDesc_ex, $tSemester_01, $tdate_ex);

                                while($stmt->fetch())
                                {
                                    foreach ($table as &$value1)
                                    {
                                        $wrking_crs_tab = 'coursereg_arch_'.$value1;

                                        $stmt_ex = $mysqli->prepare("SELECT vCourseDesc, tdate, iCreditUnit, cAcademicDesc, cCategory
                                        FROM $wrking_crs_tab
                                        WHERE cCourseId = '$cCourseId'
                                        AND vMatricNo = ?");
                                        $stmt_ex->bind_param("s", $_REQUEST["uvApplicationNo"]);
                                        $stmt_ex->execute();
                                        $stmt_ex->store_result();
                                        $stmt_ex->bind_result($vCourseDesc, $tdate, $iCreditUnit, $cAcademicDesc, $cCategory);
                                        
										if (is_null($cCategory))
										{
											$cCategory = ".";
										}
										
										if (is_null($vCourseDesc))
										{
											$vCourseDesc = ".";
										}

                                        if ($stmt_ex->num_rows > 0)
                                        {
                                            $stmt_ex->fetch();
                                    
                                            $c++;
                                            $stmt_anx = $mysqli->prepare("SELECT ancilary_type
                                            FROM courses
                                            WHERE cCourseId = '$cCourseId'");
                                            $stmt_anx->execute();
                                            $stmt_anx->store_result();
                                            $stmt_anx->bind_result($ancilary_type);
                                            $stmt_anx->fetch();

                                            $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                                            FROM s_f_s a, fee_items b
                                            WHERE a.fee_item_id = b.fee_item_id
                                            AND fee_item_desc = 'Examination Registration'
                                            AND cEduCtgId = '$cEduCtgId_su'
                                            AND a.citem_cat = 'A2'");
            
                                            $stmt_amount->execute();
                                            $stmt_amount->store_result();
                                            $stmt_amount->bind_result($Amount, $itemid);
                                            $stmt_amount->fetch();
                                            $stmt_amount->close();
            
											if (is_null($Amount))
											{
												$Amount = 0;
											}

                                            if ($prev_sem == '' || $prev_lev == '' || $prev_lev <> $siLevel || $prev_sem <> $tSemester_01)
                                            {
                                                if ($tSemester_01 == 1)
                                                {
                                                    $tSemester_desc = 'First semester';
                                                }else
                                                {
                                                    $tSemester_desc = 'Second semester';
                                                }?>
                                                <div class="_label" style="border:1px solid #cdd8cf; width:98.1%; padding-top:0.8%; padding-bottom:0.7%; text-align:left; font-weight:bold; margin-top:10px; background-color:#FFFFFF;">
                                                    <?php echo $siLevel.'L '.$tSemester_desc;?>
                                                </div><?php
                                            }

                                            if ($c%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
                                            <label class="lbl_beh">
                                                <div class="innercont_stff">
                                                    <div class="_label" style="border:1px solid #cdd8cf; width:3.5%; padding-top:0.8%; padding-bottom:0.7%; text-align:right; background-color:<?php echo $background_color;?>;">
                                                        <?php echo $c;?>
                                                    </div>

                                                    <div class="_label" style="border:1px solid #cdd8cf; width:9%; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; text-align:left; background-color:<?php echo $background_color;?>;">
                                                        <?php echo $cCourseId; ?>
                                                    </div>
                                                    
                                                    <div class="_label" style="border:1px solid #cdd8cf; width:45%; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; text-align:left; background-color:<?php echo $background_color;?>;">
                                                        <?php if ($vCourseDesc <> ''){echo $vCourseDesc;}else{echo '.';}?>
                                                    </div>

                                                    <div class="_label" style="border:1px solid #cdd8cf; width:7.2%; text-align:right; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:<?php echo $background_color;?>;">
                                                        <?php echo $iCreditUnit; $total_cr = $total_cr + $iCreditUnit;?>
                                                    </div>

                                                    <div class="_label" style="border:1px solid #cdd8cf; width:5.9%; text-align:center; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:<?php echo $background_color;?>;">
                                                        <?php if ($cCategory <> ''){echo $cCategory;}else{echo '.';}?>
                                                    </div>

                                                    <div class="_label" style="border:1px solid #cdd8cf; width:6.3%; text-align:right; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:<?php echo $background_color;?>;">
                                                        <?php if ($ancilary_type == 'normal' || $ancilary_type == 'Laboratory')
                                                        {
                                                            echo number_format($Amount, 0, '', ','); $total_cost = $total_cost  + $Amount;
                                                        }else
                                                        {
                                                            echo 'NA';
                                                        }?>
                                                    </div>

                                                    <div class="_label" style="border:1px solid #cdd8cf; width:15%; text-align:center; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:<?php echo $background_color;?>;">
                                                        <?php echo $tdate_ex;?>
                                                    </div>
                                                </div>
                                            </label><?php
                                        }
                                    }
                                    
                                    $prev_sem = $tSemester_01;
                                    $prev_lev = $siLevel;
                                }
                                    
                                    
                            }
                            $stmt->close();?>
                        </div>
                        <label class="lbl_beh" style="font-weight:bold;">
                            <div class="_label" style="border:1px solid #cdd8cf; width:58.3%; padding:5px; text-align:right;">
                                Total
                            </div>

                            <div class="_label" style="border:1px solid #cdd8cf; width:7%; text-align:right; padding:5px;">
                                <?php echo $total_cr; ?>
                            </div>

                            <div class="_label" style="border:1px solid #cdd8cf; width:5.9%; text-align:center; padding:5px;">
                                --
                            </div>

                            <div class="_label" style="border:1px solid #cdd8cf; width:6.3%; text-align:right; padding:5px;">
                                <?php echo number_format($total_cost);?>
                            </div>

                            <div class="_label" style="border:1px solid #cdd8cf; width:14.8%; text-align:center; padding:5px;">
                                --
                            </div>
                        </label><?php
                    }?>
                </div>
                
                <div class="innercont_stff_tabs" id="ans5" style="height:81%;">
                    <div id="qual_list" class="innercont_stff" style="height:99.5%; border:0px solid #ccc; overflow:scroll; overflow-x: hidden;"><?php
                        if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                        {
                            $mysqli_arch = link_connect_db_arch();
                            $stmt1 = $mysqli_arch->prepare("SELECT cEduCtgId, vExamNo, a.cQualCodeId, a.vExamSchoolName, vQualCodeDesc, cExamMthYear, c.vApplicationNo
                            FROM arch_applyqual_stff a, qualification b, arch_afnmatric c 
                            WHERE a.cQualCodeId = b.cQualCodeId 
                            and c.vMatricNo = a.vMatricNo
                            and c.vMatricNo = ? 
                            ORDER BY RIGHT(a.cExamMthYear,4), LEFT(a.cExamMthYear,2)");
                        }else
                        {
                            //$ref_table = src_table("applyqual_stff");
                            $stmt1 = $mysqli->prepare("SELECT cEduCtgId, vExamNo, a.cQualCodeId, a.vExamSchoolName, vQualCodeDesc, cExamMthYear, c.vApplicationNo
                            FROM applyqual_stff a, qualification b, afnmatric c 
                            WHERE a.cQualCodeId = b.cQualCodeId 
                            and c.vMatricNo = a.vMatricNo
                            and c.vMatricNo = ? 
                            ORDER BY RIGHT(a.cExamMthYear,4), LEFT(a.cExamMthYear,2)");
                        }
                        $stmt1->bind_param("s", $_REQUEST["uvApplicationNo"]);
                        $stmt1->execute();
                        $stmt1->store_result();	
                        $stmt1->bind_result($cEduCtgId, $vExamNo, $cQualCodeId, $vExamSchoolName, $vQualCodeDesc, $cExamMthYear, $vApplicationNo);
                        $coun = $stmt1->num_rows;
                        $cred_cnt = 0;
                        
                        while($stmt1->fetch())
                        {
                            if (is_null($vExamNo))
                            {
                                $vExamNo = '';
                            }
                            
                            $coun--;
                            $cred_cnt++;
                            
                            $post_str = '';
                            if ($cEduCtgId == 'OLX' ||  $cEduCtgId == 'OLZ'){$post_str = '335px';}
                            else if ($cEduCtgId == 'OLY' ||  $cEduCtgId == 'ALX' ||  $cEduCtgId == 'ALY'){$post_str = '220px';}
                            else if ($cEduCtgId == 'EVS'){$post_str = '175px';}
                            else if (($cEduCtgId == 'ALW' ||  $cEduCtgId == 'ALZ' || substr($cEduCtgId,0,1) ==  'P' || substr($cEduCtgId,0,2) ==  'EL') && ($cEduCtgId <> 'PRP' && $cEduCtgId <> 'PMR')){$post_str = '155px';}?>
                            
                            <div id="credentialNum<?php echo $cred_cnt; ?>" class="inner_cont" style="height:<?php echo $post_str ?>; margin-bottom:5px; border:1px dashed #000000;border-radius:0px; width:98.8%;"><?php
                                if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                                {
                                    $mysqli_arch = link_connect_db_arch();
                                    $stmt = $mysqli_arch->prepare("SELECT * FROM arch_pics a, arch_afnmatric b
                                    where a.vApplicationNo = b.vApplicationNo
                                    and vMatricNo = ? 
                                    and vExamNo = '".$vExamNo."'
                                    and cQualCodeId = '".$cQualCodeId."'");
                                }else
                                {
                                    $stmt = $mysqli->prepare("select * from pics a, afnmatric b
                                    where a.vApplicationNo = b.vApplicationNo
                                    and vMatricNo = ? 
                                    and vExamNo = '".$vExamNo."'
                                    and cQualCodeId = '".$cQualCodeId."'");
                                }
                                $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
                                $stmt->execute();
                                $stmt->store_result();

                                if ($stmt->num_rows === 0)
                                {?>
                                    <div class="innercont_stff" style="text-align:right; height:32px;">
                                        <div class="innercont" 
                                        style="height:auto; width:auto; padding:3px; margin-top:5px; margin-bottom:3px; margin-right:3px; float:right; background-color:#F5F4D6; border:1px solid #000000">
                                            Please upload scanned copy of credential with exam no. NO 
                                        </div>
                                    </div><?php
                                }else
                                {?>
                                    <div class="innercont_stff" style="text-align:right; height:18px">
                                        <a href="#" onclick="_('acad_rec').vExamNo.value='<?php echo $vExamNo ?>';
                                        _('acad_rec').cQualCodeId.value='<?php echo $cQualCodeId ?>';
                                        _('acad_rec').vApplicationNo_img.value='<?php echo $vApplicationNo;?>';
                                        call_image();return false">
                                            <img src="img/cert.gif" title="Click to see uploaded scanned copy of credential" style="text-decoration:none" border="0" align="bottom"/>
                                        </a>
                                    </div><?php
                                }
                                $stmt->close();?>
                                    
                                <div class="_label">
                                    Qualification
                                </div>
                                <div class="_value" style="width:67.7%;">
                                    <?php echo stripslashes($vQualCodeDesc);?>
                                </div>

                                <div class="_label">
                                    Centre/School Name
                                </div>
                                <div class="_value" style="width:67.7%;">
                                    <?php echo ucwords(strtolower(stripslashes($vExamNo)));?>
                                </div>

                                <div class="_label">
                                    Month and year of qualification
                                </div>
                                <div class="_value" style="width:67.7%;">
                                    <?php echo stripslashes($cExamMthYear);?>
                                </div>
                                
                                <div style="width:30%; height:auto; float:left; text-align:right; padding:5px; font-weight:bold; margin-top:3px; padding-left:0px; border-top:1px solid #cdd8cf;">
                                    Subject
                                </div>
                                <div style="width:45%; height:auto; float:left; text-align:left; padding:5px; font-weight:bold; margin-top:3px; border-top:1px solid #cdd8cf;">
                                    Grade
                                </div><?php 
                                $qual = "s6.cQualCodeId.value='".$cQualCodeId.
                                "';s6.vExamNo.value='".$vExamNo."';";

                                if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                                {
                                    $mysqli_arch = link_connect_db_arch();
                                    $stmt2 = $mysqli_arch->prepare("select vQualSubjectDesc, cQualGradeCode from arch_applysubject a, qualsubject b, qualgrade c
                                    where a.cQualSubjectId = b.cQualSubjectId and
                                    a.cQualCodeId = '".$cQualCodeId."' and
                                    a.vExamNo = '".$vExamNo."' and
                                    a.cQualGradeId = c.cQualGradeId and
                                    vApplicationNo = ?");
                                }else
                                {
                                    $stmt2 = $mysqli->prepare("select vQualSubjectDesc, cQualGradeCode from applysubject a, qualsubject b, qualgrade c
                                    where a.cQualSubjectId = b.cQualSubjectId and
                                    a.cQualCodeId = '".$cQualCodeId."' and
                                    a.vExamNo = '".$vExamNo."' and
                                    a.cQualGradeId = c.cQualGradeId and
                                    vApplicationNo = ?");
                                }
                                $stmt2->bind_param("s", $vApplicationNo);
                                $stmt2->execute();
                                $stmt2->store_result();
                                $stmt2->bind_result($vQualSubjectDesc, $cQualGradeCode);
                                            
                                while($stmt2->fetch())
                                {?>
                                    <div style="width:30%; height:auto; float:left; text-align:right; padding:5px; margin-top:3px; padding-left:0px;">
                                        <?php echo ucwords(strtolower(stripslashes($vQualSubjectDesc)));?>
                                    </div>
                                    <div style="width:50%; height:auto; float:left; text-align:left; padding:5px; font-weight:bold; margin-top:3px;">
                                        <?php echo stripslashes($cQualGradeCode);?>
                                    </div>
                                    <div style="width:9.2%; height:auto; float:left; text-align:left; padding:3.4px; margin-top:3px;"></div><?php
                                }
                                $stmt2->close();?>
                            </div><?php
                        }
                        $stmt1->close();?>
                    </div>
                </div><?php
            }?>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
                 <img name="passprt" id="passprt" src="<?php echo get_pp_pix(''); ?>" width="95%" height="185" style="margin:0px;"/>
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
                </div><?php 
                if (isset($_REQUEST['uvApplicationNo']))
                {
                    side_detail($_REQUEST['uvApplicationNo']);
                }?>
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