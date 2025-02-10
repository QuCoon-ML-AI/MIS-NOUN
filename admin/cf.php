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
    function chk_inputs()
	{
		var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}
		
        var numbers = /^[NOUNSLPC0-9_]+$/;

        if (m_frm.uvApplicationNo.value == '')
		{
			setMsgBox("labell_msg0","");
			m_frm.uvApplicationNo.focus();
		}else if (((m_frm.mm.value == 0 && m_frm.sm.value > 8)  || 
        ((m_frm.mm.value == 1 || m_frm.mm.value == 8) && m_frm.sm.value == 7) || 
        (m_frm.mm.value == 3 && m_frm.sm.value == 4) || 
        (m_frm.mm.value == 4 && m_frm.sm.value == 3) || 
        (m_frm.mm.value == 5 && m_frm.sm.value == 4)) && !m_frm.uvApplicationNo.value.match(numbers))
        {
            setMsgBox("labell_msg0","Invalid number");
			m_frm.uvApplicationNo.focus();
        }else
		{
			var formdata = new FormData();
			
			
			formdata.append("currency_cf", _("currency_cf").value);
			formdata.append("user_cat", m_frm.user_cat.value);
			formdata.append("ilin", m_frm.ilin.value);
			formdata.append("save_cf", _("save_cf").value);
			formdata.append("uvApplicationNo", m_frm.uvApplicationNo.value);
			if (m_frm.mm.value == 0 && m_frm.sm.value == 8)
			{
				formdata.append("whattodo", m_frm.whattodo.value);
			}
			
			formdata.append("vApplicationNo", m_frm.vApplicationNo.value);
			formdata.append("sm", m_frm.sm.value);
			formdata.append("mm", m_frm.mm.value);

		    formdata.append("staff_study_center", m_frm.user_centre.value);

			formdata.append("arch_mode_hd", m_frm.arch_mode_hd.value);
            formdata.append("sRoleID", _('sRoleID').value);
            
			
			opr_prep(ajax = new XMLHttpRequest(),formdata);
			
		}
	}
	
	
	function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_cf.php");
		ajax.send(formdata);
	}
	

    function completeHandler(event)
	{
		on_error('0');
        on_abort('0');
        in_progress('0');
    
        var returnedStr = event.target.responseText;
        
        if (returnedStr.indexOf("does not") == -1 && 
        returnedStr.indexOf("Invalid") == -1 && 
        returnedStr.indexOf("Insufficient") == -1 && 
        returnedStr.indexOf("yet to sign-up") == -1 && 
        returnedStr.indexOf("must be that") == -1 && 
        returnedStr.indexOf("not yet available") == -1)
		{
			_("labell_msg0").style.display = 'none';
			if ((m_frm.mm.value == 1 && m_frm.sm.value == 5) ||
            (m_frm.mm.value == 2 && m_frm.sm.value == 7) || 
            (m_frm.mm.value == 3 && m_frm.sm.value == 2) || 
            (m_frm.mm.value == 5 && m_frm.sm.value == 2) || 
            (m_frm.mm.value == 8 && m_frm.sm.value == 5))
			{
                _("m_frm").target = '_blank';
				_("m_frm").action = '../appl/preview-form';
				_("m_frm").submit();
			}else if (m_frm.mm.value == 0 && m_frm.sm.value == 9)
			{
                _("m_frm").target = '_self';
				_("m_frm").action = 'attend-to-students';
				_("m_frm").submit();
			}else if (m_frm.mm.value == 0 && m_frm.sm.value == 8)
			{
                if (m_frm.whattodo.value == 0)
                {
                    m_frm.action = '../appl/preview-form';
                }else if (m_frm.whattodo.value == 1)
                {
                    //m_frm.action = '../appl/see-admission-letter';
                    if (returnedStr == 'ELX')
                    {
                        m_frm.action = '../appl/see-admission-slip';
                    }else if (returnedStr == 'PGZ' || returnedStr == 'PRX')
                    {
                        m_frm.action = '../appl/see-admission-letter-phd';
                    }else if (returnedStr == 'PGYC')
                    {
                        m_frm.action = '../appl/see-admission-letter-cemba';
                    }else //if (returnedStr == 'PSZ')
                    {
                        m_frm.action = '../appl/see-admission-letter';
                    }
                }
        
				m_frm.submit();
            }else if ((m_frm.mm.value == 4 && m_frm.sm.value == 1))
            {
                m_frm.action = '../appl/preview-form';
                m_frm.submit();
            }else if ((m_frm.mm.value == 1 && m_frm.sm.value == 6) ||
            (m_frm.mm.value == 3 && m_frm.sm.value == 3) ||
            (m_frm.mm.value == 4 && m_frm.sm.value == 2)||
            (m_frm.mm.value == 8 && m_frm.sm.value == 6))
            {
                if (returnedStr == 'ELX')
                {
                    m_frm.action = '../appl/see-admission-slip';
                }else if (returnedStr == 'PGZ' || returnedStr == 'PRX')
                {
                    m_frm.action = '../appl/see-admission-letter-phd';
                }else if (returnedStr == 'PGYC')
                {
                    m_frm.action = '../appl/see-admission-letter-cemba';
                }else //if (returnedStr == 'PSZ')
                {
                    m_frm.action = '../appl/see-admission-letter';
                }
                
                m_frm.submit();
            }else if ((m_frm.mm.value == 5 && m_frm.sm.value == 3) ||
            (m_frm.mm.value == 2 && m_frm.sm.value == 8) ||
            (m_frm.mm.value == 0 && m_frm.sm.value == 8))
            {
                if (returnedStr == 'Record marked succefully')
                {
                    success_box(returnedStr);
                    return;
                }

                admltr.uvApplicationNo.value = m_frm.uvApplicationNo.value;
                admltr.submit();
            }else if ((m_frm.mm.value == '0' && m_frm.sm.value >= 9) || 
            ((m_frm.mm.value == '1' || m_frm.mm.value == '8') && m_frm.sm.value == '7') || 
            (m_frm.mm.value == 3 && m_frm.sm.value == 3) || 
            (m_frm.mm.value == 4 && m_frm.sm.value == 3) || 
            (m_frm.mm.value == 5 && m_frm.sm.value == 4))
            {
                _("m_frm").target = '_self';
                _("m_frm").action = 'attend-to-students';
                _("m_frm").submit();
            }else if ((m_frm.mm.value == 1 || m_frm.mm.value == 8) && m_frm.sm.value == 2)
            {
                _("m_frm").target = '_self';
                _("m_frm").action = 'registration-module-one';
                _("m_frm").submit();
            }
		}else
		{			
			if (returnedStr.indexOf("not submitted") != -1)
			{
				_('labell_msg0').style.display = 'none';
               
				if ((m_frm.mm.value == 0 && _("whattodo") && m_frm.whattodo.value == 0) || 
				(m_frm.mm.value == 4 && m_frm.sm.value == 1) || 
				(m_frm.mm.value == 5 && m_frm.sm.value == 2) ||
				(m_frm.mm.value == 2 && m_frm.sm.value == 7))
				{
					_('submityes_msg').innerHTML = returnedStr+'<br> You still want to see application form';
					_('submityes').style.display = 'block'; alert(returnedStr+' '+m_frm.mm.value+' '+m_frm.whattodo.value)
				}else if ((m_frm.mm.value == 0 && _("whattodo") && m_frm.whattodo.value == 1) || 
				(m_frm.mm.value == 4 && m_frm.sm.value == 2) ||  
				(m_frm.mm.value == 5 && m_frm.sm.value == 3) ||
				(m_frm.mm.value == 2 && m_frm.sm.value == 8))
				{
					_("labell_msg0").className = 'labell_msg blink_text orange_msg';
					_("labell_msg0").style.width= 'auto';
					setMsgBox("labell_msg0", 'Admission letter not yet available. '+returnedStr);

                    caution_box('Admission letter not yet available. '+returnedStr);
				}
			}else
			{
                caution_box(returnedStr);
			}
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
        <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u ?>" />
		<!-- InstanceBeginEditable name="EditRegion6" -->			
			
			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div><?php
            time_out_box($currency);
            
            if ($currency == '1')
            {
                $staff_can_access = 1;

                if (isset($_REQUEST['user_centre']) && $_REQUEST['user_centre'] <> '')
                {
                    $staff_study_center = $_REQUEST['user_centre'];
                }
                
                if (isset($_REQUEST['vApplicationNo']))
                {
                    $vCityName = '';
                    
                    if ((isset($_REQUEST['uvApplicationNo']) && $_REQUEST['uvApplicationNo'] <> '') /*&& 
                    (($_REQUEST['mm'] == '1' && $_REQUEST['sm'] == '7') || ($_REQUEST['mm'] == '0' && ($_REQUEST['sm'] == '8' || $_REQUEST['sm'] == '9')) || ($_REQUEST['mm'] == '3' && $_REQUEST['sm'] == '4') || ($_REQUEST['mm'] == '4' && $_REQUEST['sm'] == '3') || ($_REQUEST['mm'] == '5' && $_REQUEST['sm'] == '4'))*/)
                    {
                        $staff_study_center_new = str_replace("|","','",$staff_study_center);
                        $staff_study_center_new = substr($staff_study_center_new,2,strlen($staff_study_center_new)-4);
                        
                        if (($_REQUEST['mm'] == '4' && $_REQUEST['sm'] == '1') || ($_REQUEST['mm'] == '5' && $_REQUEST['sm'] == '2') || ($_REQUEST['mm'] == '0' && $_REQUEST['sm'] == '8'))
                        {
                            if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                            {
                                $mysqli_arch = link_connect_db_arch();
                                $stmt = $mysqli_arch->prepare("SELECT concat(b.vCityName,' centre')  
                                from arch_prog_choice a, studycenter b
                                WHERE a.cStudyCenterId = b.cStudyCenterId
                                AND a.cStudyCenterId IN ($staff_study_center_new) 
                                AND a.vApplicationNo = ?");
                            }else
                            {
                                $stmt = $mysqli->prepare("SELECT concat(b.vCityName,' centre')  
                                from prog_choice a, studycenter b
                                WHERE a.cStudyCenterId = b.cStudyCenterId
                                AND a.cStudyCenterId IN ($staff_study_center_new) 
                                AND a.vApplicationNo = ?");
                            }
                            $stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
                        }else if ($_REQUEST['sm'] == '7' || $_REQUEST['sm'] == '9' || $_REQUEST['sm'] == '3' || $_REQUEST['sm'] == '4')
                        {
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
                                $stmt = $mysqli->prepare("SELECT concat(b.vCityName,' centre')  
                                from s_m_t a, studycenter b
                                WHERE a.cStudyCenterId = b.cStudyCenterId
                                AND a.cStudyCenterId IN ($staff_study_center_new)
                                AND a.vMatricNo = ?");
                            }
                            $stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
                        }                        
                        
                        $stmt->execute();
                        $stmt->store_result();

                        $stmt->bind_result($vCityName);
                        $stmt->fetch();
                        
                        //$staff_can_access = $stmt->num_rows;
                        $stmt->close();
                    }
                }?>

                <form action="../appl/see-admission-letter" method="post" name="admltr" id="admltr" target="_blank" enctype="multipart/form-data">
                    <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
                    <input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];}?>" />
                    <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                    <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                    <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                    <input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />
                    <input name="study_mode" id="study_mode" type="hidden" value="odl">
                    
                    <input name="service_mode" id="service_mode" type="hidden" 
                    value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
                    else if (isset($study_mode)){echo $study_mode;}?>" />
                    <input name="num_of_mode" id="num_of_mode" type="hidden" 
                    value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
                    else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

                    <input name="user_centre" id="user_centre" type="hidden" 
                    value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}?>" />
                    <input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
                    value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
                    else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
		
                    <input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
                </form>
                <form action="see-admission-letter-pdf" method="post" name="admltr_pdf" target="_blank" enctype="multipart/form-data">
                    <input name="vApplicationNo" type="hidden" value="<?php if (isset($vApplicationNo)){echo $vApplicationNo;} ?>" />
                    <input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];}?>" />
                    <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                    <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                    <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                    <input name="study_mode" id="study_mode" type="hidden" value="odl">
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
		
                    <input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
                </form>

                <div class="innercont_top"><?php 
                    if (($mm == 0 && $sm == 7) || 
                    ($mm == 4 && $sm == 1) || 
                    ($mm == 5 && $sm == 2) || 
                    ($mm == 2 && $sm == 7) || 
                    ($mm == 3 && $sm == 2)|| 
                    ($mm == 1 && $sm == 5)|| 
                    ($mm == 8 && $sm == 5))
                    {
                        echo 'View application form';
                    }else if ($mm == 0 && $sm == 8)
                    {
                        echo 'View application record';
                    }else if (($mm == 5 && $sm == 3) || 
                    ($mm == 4 && $sm == 2) || 
                    ($mm == 2 && $sm == 8) ||  
                    ($mm == 3 && $sm == 3)|| 
                    ($mm == 1 && $sm == 6)|| 
                    ($mm == 8 && $sm == 6))
                    {
                        echo 'View admission letter';
                    }else if (($mm == 0 && $sm == 9) || (($mm == 1 || $mm == 8) && $sm == 7) || ($mm == 3 && $sm == 4) || ($mm == 4 && $sm == 3) || ($mm == 5 && $sm == 4))
                    {
                        echo "View student's biodata";
                    }?>
                </div><?php 
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
                                        admltr_pdf.arch_mode_hd.value='1';
                                        admltr.arch_mode_hd.value='1';
                                        m_frm.arch_mode_hd.value='1';
                                    }else
                                    {
                                        nxt.arch_mode_hd.value='0';
                                        cf.arch_mode_hd.value='0';
                                        std_acad_hist.arch_mode_hd.value='0';
                                        chk_pay_sta.arch_mode_hd.value='0';
                                        vw_std_acnt_stff.arch_mode_hd.value='0';
                                        std_stat.arch_mode_hd.value='0';
                                        admltr_pdf.arch_mode_hd.value='0';
                                        admltr.arch_mode_hd.value='0';
                                        m_frm.arch_mode_hd.value='0';
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
                }?>

                <div id="appl_box" class="innercont_stff" 
                    style="display:<?php 
                        if (($mm == 0 && $sm >= 7) || 
                        (($mm == 1 || $mm == 8) && $sm == 7) || 
                        ($mm == 3 && ($sm == 2 || $sm == 3 || $sm == 4)) || 
                        ($mm == 4  && ($sm == 1 || $sm == 2 || $sm == 3)) || 
                        ($mm == 5 && ($sm == 2 || $sm == 3 || $sm == 4)) || 
                        ($mm == 2 && ($sm == 7 || $sm == 8)) || 
                        ($mm == 1 && ($sm == 5 || $sm == 6))|| 
                        ($mm == 8 && ($sm == 5 || $sm == 6))){?>block<?php }else{?>none<?php }?>">
                        <form action="../appl/preview-form" method="post" target="_blank" name="m_frm" id="m_frm" enctype="multipart/form-data">
                            <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
                            <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];} ?>" />	
                            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                            <input name="sm" id="sm" type="hidden" value="<?php echo $sm ?>" />
                            <input name="mm" id="mm" type="hidden" value="<?php echo $mm ?>" />
                            <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                            <input name="conf" id="conf" type="hidden" value="" />
                            <input name="see_frm" id="see_frm" type="hidden" value="1" />
                            <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
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

                            <input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
                           
                           <div class="innercont_stff" style="margin-top:0px;">
                                <div class="div_select" style="text-align:right">
                                    <?php if (($mm == 0 && $sm == 8))
                                        {?>
                                            <select name="whattodo" id="whattodo" class="select">
                                                <option value="0">Application form</option>
                                                <option value="1">Admission letter</option>
                                            </select><?php
                                        }else if (($mm == 0 && $sm > 8)  || 
                                        (($mm == 1 || $mm == 8) && $sm == 7) || 
                                        ($mm == 3 && $sm == 4) || 
                                        ($mm == 4 && $sm == 3) || 
                                        ($mm == 5 && $sm == 4)){echo 'Matriculation number';}else{echo 'Application form number';}?>
                                </div>
                                
                                <div class="div_select"><?php
                                    if (($mm == 0 && $sm > 8)  || 
                                    (($mm == 1 || $mm == 8) && $sm == 7) || 
                                    ($mm == 3 && $sm == 4) || 
                                    ($mm == 4 && $sm == 3) || 
                                    ($mm == 5 && $sm == 4))
                                    {?>
                                        <input name="uvApplicationNo" id="uvApplicationNo" 
                                        type="text" 
                                        class="textbox"
                                        maxlength="25"
                                        onchange="this.value=this.value.replace(/ /g, '');
						                this.value=this.value.toUpperCase();" required 
                                        placeholder="Enter matriculation number here"/><?php
                                    }else
                                    {?>
                                        <input name="uvApplicationNo" id="uvApplicationNo" 
                                        type="number" 
                                        class="textbox"
                                        maxlength="8"
                                        onkeypress="if(this.value.length==8){return false}" required 
                                        placeholder="Enter application form number here"/><?php
                                    }?>                                    
                                </div>
                                <div id="labell_msg0" class="labell_msg blink_text orange_msg" style="width:auto; margin-right:5px;"></div>
                                <!-- <div class="div_select" style="width:auto">
                                    <select name="faculty_u_no" id="faculty_u_no" style="height:100%;"><?php
                                        /*$faculty_u_no = '';
                                        if (isset($_REQUEST["faculty_u_no"])){$faculty_u_no = $_REQUEST["faculty_u_no"];}
                                        get_faculties_if_u_know($faculty_u_no);*/?>
                                    </select>
                                </div> -->
                            </div>
                        </form>
                </div><?php
                
                if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
                {
                    $where_am_i = ($_REQUEST["mm"] == '0' && $_REQUEST["sm"] == '9') || ($_REQUEST["mm"] == '4' && $_REQUEST["sm"] == '3') || ($_REQUEST["mm"] == '5' && $_REQUEST["sm"] == '4');

                    if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                    {
                        $mysqli_arch = link_connect_db_arch();
                        $stmt = $mysqli_arch->prepare("SELECT * from arch_s_m_t where vMatricNo = ?");
                    }else
                    {
                        $stmt = $mysqli->prepare("SELECT * from s_m_t where vMatricNo = ?");
                    }        
                    $stmt = $mysqli->prepare("SELECT * from s_m_t where vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
                    $stmt->execute();
                    $stmt->store_result();
                    
                    if ($stmt->num_rows === 0 && isset($_REQUEST["uvApplicationNo"]) && trim($_REQUEST["uvApplicationNo"]) <> '' && $where_am_i && check_grad_student($_REQUEST["uvApplicationNo"]) == 0)
                    {
                        caution_box('Invalid matriculation number');
                    
                    }else if ($staff_can_access == 0 && isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1')
                    {
                        if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                        {
                            caution_box('Student\'s record is not in the archive');
                        }else
                        {
                            caution_box('Student study centre does not match that of staff that is logged in');
                        }
                    }else if (($mm == 0 && $sm > 8)  || 
                    (($mm == 1 || $mm == 8) && $sm == 7) || 
                    ($mm == 3 && $sm == 4) || 
                    ($mm == 4 && $sm == 3) || 
                    ($mm == 5 && $sm == 4))
                    {		
                        if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
                        {
                            caution_box('Matriculation number graduated');
                        }
                        $stmt->close();

                        /*if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                        {
                            $mysqli_arch = link_connect_db_arch();
                            $stmt = $mysqli_arch->prepare("SELECT a.vLastName, CONCAT(a.vFirstName,' ',a.vOtherName) namess, a.cGender, a.dBirthDate, 
                            a.vMobileNo, a.vEMailId, b.vDisabilityDesc, a.vPostalAddress, a.vPostalCityName, c.vLGADesc, d.vStateName, 
                            e.vCountryName, a.vNOKName, f.vNOKTypeDesc, a.vNOKAddress, a.vNOKEMailId, a.vNOKMobileNo, a.vNOKName1, a.vNOKAddress1, a.vNOKEMailId1, a.vNOKMobileNo1, g.vMaritalStatusDesc, cStudyCenterId
                            FROM arch_s_m_t a, disability b, localarea c, ng_state d, country e, noktype f, maritalstatus g
                            WHERE a.cDisabilityId = b.cDisabilityId
                            AND c.cLGAId = a.cPostalLGAId
                            AND d.cStateId = a.cPostalStateId
                            AND e.cCountryId = a.cPostalCountryId
                            AND f.cNOKType = a.cNOKType
                            AND g.cMaritalStatusId = a.cMaritalStatusId
                            AND a.vMatricNo = ?");
                        }else
                        {
                            $ref_table = src_table("s_m_t");
                            $stmt = $mysqli->prepare("SELECT a.vLastName, CONCAT(a.vFirstName,' ',a.vOtherName) namess, a.cGender, a.dBirthDate, 
                            a.vMobileNo, a.vEMailId, b.vDisabilityDesc, a.vPostalAddress, a.vPostalCityName, c.vLGADesc, d.vStateName, 
                            e.vCountryName, a.vNOKName, f.vNOKTypeDesc, a.vNOKAddress, a.vNOKEMailId, a.vNOKMobileNo, a.vNOKName1, a.vNOKAddress1, a.vNOKEMailId1, a.vNOKMobileNo1, g.vMaritalStatusDesc, cStudyCenterId
                            FROM $ref_table a, disability b, localarea c, ng_state d, country e, noktype f, maritalstatus g
                            WHERE a.cDisabilityId = b.cDisabilityId
                            AND c.cLGAId = a.cPostalLGAId
                            AND d.cStateId = a.cPostalStateId
                            AND e.cCountryId = a.cPostalCountryId
                            AND f.cNOKType = a.cNOKType
                            AND g.cMaritalStatusId = a.cMaritalStatusId
                            AND a.vMatricNo = ?");
                        }*/

                        $stmt = $mysqli->prepare("SELECT a.vLastName, CONCAT(a.vFirstName,' ',a.vOtherName) namess, a.cGender, a.dBirthDate, a.vMobileNo, a.vEMailId, b.vDisabilityDesc, cStudyCenterId, g.vMaritalStatusDesc
                        FROM s_m_t a, disability b, maritalstatus g
                        WHERE a.cDisabilityId = b.cDisabilityId
                        AND g.cMaritalStatusId = a.cMaritalStatusId
                        AND a.vMatricNo = ?");
                        $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
                        $stmt->execute();
                        $stmt->store_result();
                        $rec1 = $stmt->num_rows;                      
                        $stmt->bind_result($vLastName, $namess, $cGender, $dBirthDate, $vMobileNo, $vEMailId, $vDisabilityDesc, $cStudyCenterId, $vMaritalStatusDesc);
                        $stmt->fetch();

                        if (is_null($vLastName))
                        {
                            $vLastName = '';
                        }
                        
                        if (is_null($namess))
                        {
                            $namess = '';
                        }
                        
                        $vLastName = stripslashes(stripslashes($vLastName));
                        $namess = stripslashes(stripslashes($namess));

                        $stmt = $mysqli->prepare("SELECT a.vPostalAddress, a.vPostalCityName, c.vLGADesc, d.vStateName, 
                        e.vCountryName
                        FROM s_m_t a, localarea c, ng_state d, country e
                        WHERE  c.cLGAId = a.cPostalLGAId
                        AND d.cStateId = a.cPostalStateId
                        AND e.cCountryId = a.cPostalCountryId
                        AND a.vMatricNo = ?");
                        $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
                        $stmt->execute();
                        $stmt->store_result();
                        $rec2 = $stmt->num_rows;
                        $stmt->bind_result($vPostalAddress, $vPostalCityName, $vLGADesc, $vStateName, $vCountryName);
                        $stmt->fetch();
                        
                        if (is_null($vPostalAddress))
                        {
                            $vPostalAddress = '';
                        }

                        if (is_null($vPostalCityName))
                        {
                            $vPostalCityName = '';
                        }
                        
                        if (is_null($vLGADesc))
                        {
                            $vLGADesc = '';
                        }
                        
                        if (is_null($vStateName))
                        {
                            $vStateName = '';
                        }
                        
                        if (is_null($vCountryName))
                        {
                            $vCountryName = '';
                        }
                        
                        $stmt = $mysqli->prepare("SELECT a.vNOKName, f.vNOKTypeDesc, a.vNOKAddress, a.vNOKEMailId, a.vNOKMobileNo, a.vNOKName1, a.vNOKAddress1, a.vNOKEMailId1, a.vNOKMobileNo1
                        FROM s_m_t a, noktype f
                        WHERE  f.cNOKType = a.cNOKType
                        AND a.vMatricNo = ?");
                        $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
                        $stmt->execute();
                        $stmt->store_result();
                        $rec3 = $stmt->num_rows;
                        $stmt->bind_result($vNOKName, $vNOKTypeDesc, $vNOKAddress, $vNOKEMailId, $vNOKMobileNo, $vNOKName1, $vNOKAddress1, $vNOKEMailId1, $vNOKMobileNo1);
                        $stmt->fetch();
                       
                        // $stmt->bind_result($vLastName, $namess, $cGender, $dBirthDate, 
                        // $vMobileNo, $vEMailId, $vDisabilityDesc, $vPostalAddress, $vPostalCityName, $vLGADesc, $vStateName, 
                        // $vCountryName, $vNOKName, $vNOKTypeDesc, $vNOKAddress, $vNOKEMailId, $vNOKMobileNo, $vNOKName1, $vNOKAddress1, $vNOKEMailId1, $vNOKMobileNo1, $vMaritalStatusDesc, $cStudyCenterId);
                        // $stmt->fetch();

                        if ($rec1 === 0 && $rec2 === 0 && $rec3 === 0 && trim($_REQUEST["uvApplicationNo"]) <> '')
                        {
                            if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
                            {
                                caution_box('Student record not in the archive');
                            }else
                            {
                                $msg = "Record not found<br>Student may not have signed up";
                                caution_box($msg);
                            }
                        }/*else if (is_bool(strpos($_REQUEST["user_centre"], $cStudyCenterId)))
                        {
                            caution_box('Your study centre does not match that of the student<br>Direct student to his/her study centre for required actions');
                        }*/else
                        {?>
                            <div id="std_biodata" class="innercont_stff" 
                                style="display:<?php 
                                if ((($mm == 0&&$sm == 9)||
                                (($mm == 1 || $mm == 8)&&$sm == 7)||
                                ($mm == 3 && $sm == 4)||
                                ($mm == 4 && $sm == 3)||
                                ($mm == 5 && $sm == 4)||
                                ($mm == 85 && $sm == 6))){?>block<?php }else{?>none<?php }?>; height:85%; overflow:auto;">
                                <div class="innercont_stff" style="margin-bottom:-1px">
                                    <div class="div_label">
                                        Matriculation number
                                    </div>
                                    <div  class="div_valu">
                                        <b><?php echo $_REQUEST['uvApplicationNo'];?></b>
                                    </div>	
                                </div>
                                <div class="innercont_stff">
                                    <div class="div_label">
                                        Surname
                                    </div>
                                    <div  class="div_valu">
                                        <b><?php echo $vLastName;?></b>
                                    </div>	
                                </div>
                                <div class="innercont_stff">
                                    <div class="div_label">
                                        Other names
                                    </div>
                                    <div  class="div_valu">
                                        <b><?php echo $namess;?></b>
                                    </div>	
                                </div>
                                <div class="innercont_stff">
                                    <div class="div_label">
                                        Gender
                                    </div>
                                    <div  class="div_valu">
                                        <b><?php echo $cGender;?></b>
                                    </div>	
                                </div>
                                <div class="innercont_stff">
                                    <div class="div_label">
                                        Date of birth
                                    </div>
                                    <div  class="div_valu">
                                        <b><?php echo substr($dBirthDate,8,2).'/'.substr($dBirthDate,5,2).'/'.substr($dBirthDate,0,4);?></b>
                                    </div>	
                                </div>
                                <div class="innercont_stff">
                                    <div class="div_label">
                                        Marital status
                                    </div>
                                    <div  class="div_valu">
                                        <b><?php echo ucwords(strtolower($vMaritalStatusDesc));?></b>
                                    </div>	
                                </div>
                                <div class="innercont_stff">
                                    <div class="div_label">
                                        Disability
                                    </div>
                                    <div  class="div_valu">
                                        <b><?php echo ucwords(strtolower($vDisabilityDesc));?></b>
                                    </div>	
                                </div>
                                <div class="innercont_stff">
                                    <div class="div_label">
                                        phone number
                                    </div>
                                    <div  class="div_valu">
                                        <b><?php echo $vMobileNo;?></b>
                                    </div>	
                                </div>
                                <div class="innercont_stff">
                                    <div class="div_label">
                                        eMail address
                                    </div>
                                    <div  class="div_valu">
                                        <b><?php echo $vEMailId;?></b>
                                    </div>	
                                </div>
                                <div class="innercont_stff">
                                    <div class="div_label">
                                        Address
                                    </div>
                                    <div  class="div_valu">
                                        <b><?php echo $vPostalAddress.', '.$vPostalCityName.', '.
                                        ucwords(strtolower($vLGADesc)).' LGA, '.ucwords(strtolower($vStateName)).' State, '.
                                        ucwords(strtolower($vCountryName));?></b>
                                    </div>	
                                </div>
                                <div class="innercont_stff">
                                    <div class="div_label">
                                        <b>Next of kin</b>
                                    </div>
                                </div>
                                <div class="innercont_stff">
                                    <div class="div_label">
                                        Relationship
                                    </div>
                                    <div  class="div_valu">
                                        <b><?php echo $vNOKTypeDesc;?></b>
                                    </div>	
                                </div>
                                <div class="innercont_stff">
                                    <div class="div_label">
                                        Name
                                    </div>
                                    <div  class="div_valu">
                                        <b><?php echo $vNOKName;?></b>
                                    </div>	
                                </div>
                                <div class="innercont_stff">
                                    <div class="div_label">
                                        mobile phone numner
                                    </div>
                                    <div  class="div_valu">
                                        <b><?php echo $vNOKMobileNo;?></b>
                                    </div>	
                                </div>
                                <div class="innercont_stff">
                                    <div class="div_label">
                                        eMail address
                                    </div>
                                    <div  class="div_valu">
                                        <b><?php echo $vNOKEMailId;?></b>
                                    </div>	
                                </div>
                                <div class="innercont_stff">
                                    <div class="div_label">
                                        Address
                                    </div>
                                    <div  class="div_valu">
                                        <b><?php echo $vNOKAddress;?></b>
                                    </div>	
                                </div>
                            </div><?php
                        }
                        $stmt->close();
                    }
                }
            }?>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
                 <img name="passprt" id="passprt" src="<?php echo get_pp_pix(''); ?>" width="95%" height="185" style="margin:0px;<?php if ($currency <> '1' ){?>opacity:0.3;<?php }?>"/>
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
                if (isset($_REQUEST["uvApplicationNo"]))
                {
                    side_detail($_REQUEST['uvApplicationNo']);;
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