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

$currency = '';

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

if (($mm == 0 && $sm >= 9) || $mm == 1 || $mm == 8 || $mm == 3 || ($mm == 2 && $sm > 1) || ($mm == 4) || $mm == 5)
{
	$uvApplicationNo_1 = '';
	$uvApplicationNo_2 = '';
	if (isset($_REQUEST['uvApplicationNo']))
	{
		$uvApplicationNo_1 = $_REQUEST['uvApplicationNo'];
		$uvApplicationNo_2 = $_REQUEST['uvApplicationNo'];
	}
	
	$stmt = $mysqli->prepare("select vTitle, vLastName, vFirstName, vOtherName, b.vFacultyDesc, c.vdeptDesc,a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.iStudy_level, e.cEduCtgId, a.tSemester, a.col_gown, a.ret_gown , f.vCityName
	from s_m_t a, faculty b, depts c, obtainablequal d, programme e, studycenter f, afnmatric g
	where a.cFacultyId = b.cFacultyId
	and a.cdeptId = c.cdeptId
	and a.cObtQualId = d.cObtQualId
	and a.cProgrammeId = e.cProgrammeId
	and a.cStudyCenterId = f.cStudyCenterId
	and g.vMatricNo = a.vMatricNo
	and (g.vMatricNo = ? or
	g.vApplicationNo = ?)");
	$stmt->bind_param("ss", $uvApplicationNo_1, $uvApplicationNo_2);
	$stmt->execute();
	$stmt->store_result();

	$stmt->bind_result($vTitle, $vLastName, $vFirstName, $vOtherName, $vFacultyDesc, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $iStudy_level, $cEduCtgId, $tSemester, $col_gown, $ret_gown,  $vCityName);
	
	$student_user_num = $stmt->num_rows;
	$stmt->fetch();
	$stmt->close();

	if ($orgsetins['studycenter'] == '1')
	{
		if ($orgsetins['ind_semster'] <> '1')
		{
			$tSemester = $orgsetins["tSemester"];
		}
	}else
	{
		$tSemester = $orgsetins['tSemester'];
	}

	
	$stmt = $mysqli->prepare("select * from afnmatric where vMatricNo = ?");
	$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows === 0)
	{	
		$student_user_num = -1;
	}
	$stmt->close();
}

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

    function chk_inputs()
    {		
		var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}
        
		if (_('single_opr_div').style.display == 'block' && rectional_loc.uvApplicationNo.value == '')
		{
			setMsgBox("labell_msg1","");
			rectional_loc.uvApplicationNo.focus();
			return false;
		}else if (_('mass_opr_div').style.display == 'block' && _("afn_list").value.trim() == '')
        {
            if (_("afn_list").value == '')
            {
                setMsgBox("labell_msg0a","");
                rectional_loc.afn_list.focus();
                return false;
            }
        }else if (_("period1") && _("period1").value == '' && (rectional_loc.corect.value == '0' || rectional_loc.corect.value == '1' || rectional_loc.corect.value == '3'))
		{
			setMsgBox("labell_msg2","");
			return false;
		}else if (_("period1") && _("period1").value != '' && properdate(_("period1").value,_("current_date").value))
		{
			setMsgBox("labell_msg2","Future date required");
			return false;
		}else if (_("rect_risn").value == '')
		{
			setMsgBox("labell_msg3","");
			rectional_loc.rect_risn.focus();
			return false;
		}else 
		{
			var formdata = new FormData();
			
			rectional_loc.vMatricNo.value = rectional_loc.uvApplicationNo.value;
			if (rectional_loc.conf.value == '' && _('mass_opr_div').style.display == 'block')
            {
                _("conf_msg_msg_loc").innerHTML = 'Are you sure you want to do this ?';
				_('conf_box_loc').style.display = 'block';
                _('conf_box_loc').style.zIndex = '3';
                _('smke_screen_2').style.display = 'block';
                _('smke_screen_2').style.zIndex = '2';
                
                return false;
            }else if (rectional_loc.conf.value == '1')
			{
				formdata.append("conf", rectional_loc.conf.value);
			}
			
			if (_("period1") && rectional_loc.period1.value != '')
			{
				formdata.append("period1", rectional_loc.period1.value);
			}
			formdata.append("vApplicationNo", rectional_loc.vApplicationNo.value);
			
			formdata.append("mm", rectional_loc.mm.value);
			formdata.append("sm", rectional_loc.sm.value);
						
            formdata.append("ilin", rectional_loc.ilin.value);
			formdata.append("user_cat", rectional_loc.user_cat.value);			
            
            if (_('mass_opr_div').style.display == 'block')
            {
                formdata.append("afn_list", _("afn_list").value);
            }else if (_('single_opr_div').style.display == 'block')
            {
			    formdata.append("uvApplicationNo", rectional_loc.uvApplicationNo.value);
            }
           
			formdata.append("corect", rectional_loc.corect.value);
			formdata.append("rect_risn", rectional_loc.rect_risn.value);
            
		    formdata.append("staff_study_center", rectional_loc.user_centre.value);
            
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
		
		ajax.open("POST", "opr_rectional.php");
		ajax.send(formdata);
	}


    function completeHandler(event)
	{
        on_error('0');
        on_abort('0');
        in_progress('0');
		var returnedStr = event.target.responseText;
        
        mask = '';

        if (_('single_opr_div').style.display == 'block')
        {
            _('app_frm_no').value = returnedStr.substr(0,returnedStr.indexOf("+")-1).trim();

            if (returnedStr.indexOf('Invalid') == -1 && returnedStr.indexOf('graduated') == -1 && returnedStr.indexOf('mismatch') == -1 && returnedStr.indexOf("must be that of") == -1)
            {
                returnedStr_1 = returnedStr.substr(returnedStr.indexOf("+")+1);

                _("std_names").innerHTML = returnedStr_1.substr(0, 100).trim()+'<br>'+
                returnedStr_1.substr(100, 100).trim()+'<br>'+
                returnedStr_1.substr(200, 100).trim();

                _("std_quali").innerHTML = returnedStr_1.substr(300, 100).trim()+'<br>'+
                returnedStr_1.substr(400, 100).trim();
                
                if (returnedStr_1.substr(500, 100).trim() == 20)
                {
                    _("std_lvl").innerHTML = 'DIP 1';
                }else if (returnedStr_1.substr(500, 100).trim() == 30)
                {
                    _("std_lvl").innerHTML = 'DIP 2';
                }else
                {
                    _("std_lvl").innerHTML = returnedStr_1.substr(500, 100).trim()+' Level';
                }	
                
                _("std_sems").innerHTML = returnedStr_1.substr(600, 100).trim();
                if (_("std_sems").innerHTML == 1)
                {
                    _("std_sems").innerHTML = 'First semester';
                }else
                {
                    _("std_sems").innerHTML = 'Second semester';
                }

                faculty = returnedStr_1.substr(700, 100).trim().toLowerCase();
                mask = returnedStr_1.substr(800, 100).trim();
            }
        }
		
        returnedStr_1 = returnedStr.substr(returnedStr.indexOf("#")+1);

		if (returnedStr_1.indexOf('Invalid') != -1 || returnedStr_1.indexOf('graduated') != -1 || returnedStr_1.indexOf('not') != -1)
		{
			caution_box(returnedStr);
            
            //setMsgBox("labell_msg1", returnedStr_1);
			rectional_loc.uvApplicationNo.focus();
		}else if (returnedStr_1.indexOf('success') != -1)
		{
            success_box(returnedStr_1);
		}else if (returnedStr_1.indexOf('already') != -1 || 
        returnedStr_1.indexOf('must') != -1 || 
        returnedStr_1.indexOf('does not') != -1)
		{
            caution_box(returnedStr_1);
		}else if (returnedStr_1.indexOf("?") != -1)
		{
            _('conf_msg_msg_loc').innerHTML = returnedStr_1;
			_('conf_box_loc').style.display = 'block';
            _('conf_box_loc').style.zIndex = '3';
            _('smke_screen_2').style.display = 'block';
            _('smke_screen_2').style.zIndex = '2';
		}else if (_('mass_opr_div').style.display == 'block')
        {
            caution_box(returnedStr);
        }

        _("passprt").src = '../../ext_docs/pics/'+faculty+'/pp/p_'+mask+'.jpg';
		_("passprt").onerror = function() {myFunction1()};
        function myFunction1()
        {
            _("passprt").src = '../../ext_docs/pics/'+faculty+'/pp/p_'+mask+'.jpeg';

            _("passprt").onerror = function() {myFunction2()};

            function myFunction2() 
            {
                _("passprt").src = '../../ext_docs/pics/'+faculty+'/pp/p_'+mask+'.pjpeg';
                _("passprt").onerror = function() {myFunction3()};

                function myFunction3() 
                {
                    _("passprt").src = '../appl/img/left_side_logo.png';
                }
            }
        }

        rectional_loc.conf.value = '';
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
        <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" value="" />
        <input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
		<input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST['vMatricNo'])){echo $_REQUEST['vMatricNo']; }?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
		<input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<!-- <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" /> -->
		
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
    
    <div id="container"><div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
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
                _('smke_screen_2').style.display='none';
                _('smke_screen_2').style.zIndex='-1';
                rectional_loc.conf.value='1';
                chk_inputs();
                return false">
                <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                    Yes
                </div>
            </a>

            <a href="#" style="text-decoration:none;" 
                onclick="rectional_loc.conf.value='';
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
	//time_out_box($currency);?>

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
		<!-- InstanceBeginEditable name="EditRegion6" --><?php
        
        $additional_title = '';
        if (isset($_REQUEST['corect']))
        {
            if ($_REQUEST['corect']=='0')
            {
                $additional_title = ' - Block';
            }else if ($_REQUEST['corect']=='1')
            {
                $additional_title = ' - Suspend';
            }else if ($_REQUEST['corect']=='2')
            {
                $additional_title = ' - Expell';
            }else if ($_REQUEST['corect']=='3')
            {
                $additional_title = ' - Withdraw temporarily';
            }else if ($_REQUEST['corect']=='4')
            {
                $additional_title = ' - Withdraw Permanently';
            }else if ($_REQUEST['corect']=='5')
            {
                $additional_title = ' - Unblock';
            }else if ($_REQUEST['corect']=='6')
            {
                $additional_title = ' - Lift suspension';
            }
        }?>
		<div class="innercont_top" style="margin-bottom:0px">Correctional facilities<?php echo $additional_title;?></div>
        <form action="reformatory-facility" method="post" name="rectional_loc" id="rectional_loc" enctype="multipart/form-data">
            
            <input name="app_frm_no" id="app_frm_no" type="hidden" />

            <input name="vMatricNo" type="hidden" value="<?php echo trim($_REQUEST["uvApplicationNo"]);?>" />
            <input name="tabno" id="tabno" type="hidden" 
                value="<?php if (isset($_REQUEST['tabno'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
            
            <input name="corect" id="corect" type="hidden" value="<?php if(isset($_REQUEST['corect'])){echo $_REQUEST['corect'];}else{echo '';}?>" />
            <?php frm_vars(); 

            $stmt = $mysqli->prepare("select act_date, 
            vMatricNo, 
            cblk, 
            cblk_arch, 
            csuspe, 
            csuspe_arch, 
            cexpe, 
            cexpe_arch, 
            cre_expe, 
            tempwith, 
            tempwith_arch, 
            permwith, 
            permwith_arch, 
            period1, 
            period2, 
            re_call, 
            rect_risn, 
            rect_risn1, 
            stdycentre, 
            regist, 
            ictech from rectional where vMatricNo = ? and (cexpe = '1' or csuspe = '1' or cblk = '1') order by period1 limit 1");
            $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($act_date, 
            $vMatricNo, 
            $cblk, 
            $cblk_arch, 
            $csuspe, 
            $csuspe_arch, 
            $cexpe, 
            $cexpe_arch, 
            $cre_expe, 
            $tempwith, 
            $tempwith_arch, 
            $permwith, 
            $permwith_arch, 
            $period1, 
            $period2, 
            $re_call, 
            $rect_risn, 
            $rect_risn1, 
            $stdycentre, 
            $regist, 
            $ictech);
            $stmt->fetch();
            $stmt->close();
            
            $today = getdate();						
            $curnt_date = str_pad($today['mday'], 2, "0", STR_PAD_LEFT).'-'.str_pad($today['mon'], 2, "0", STR_PAD_LEFT).'-'.$today['year'];?>
            
            <div style="width:15%; height:auto; position:absolute; right:10px; top:35px; border-radius:0px;"><?php
                if (check_scope2('SPGS', 'SPGS menu') > 0)
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="pg_environ.mm.value=8;pg_environ.sm.value='';pg_environ.submit();return false;">
                        <div class="rtlft_inner_button" style="margin-bottom:5px; width:100%;">
                            SPGS menu
                        </div>
                    </a><?php
                }

                if (check_scope3('Academic registry', 'Correctional facility', 'Block student form') > 0)
                {
                    if (isset($_REQUEST['corect']) && $_REQUEST['corect']=='0')
                    {?>
                        <div id="tabss0_0" class="rtlft_inner_button_dull">
                            Block
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=0;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss0" class="rtlft_inner_button" style="width:100%; display:none;">
                                Block
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=0;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss0" class="rtlft_inner_button" style="width:100%;">
                                Block
                            </div>
                        </a><?php
                    }
                }

                if (check_scope3('Academic registry', 'Correctional facility', 'Suspend') > 0)
                {
                    if (isset($_REQUEST['corect'])&&$_REQUEST['corect']=='1')
                    {?>
                        <div id="tabss1_0" class="rtlft_inner_button_dull">
                            Suspend
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=1;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss1" class="rtlft_inner_button" style="width:100%; display:none;">
                                Suspend
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=1;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss1" class="rtlft_inner_button" style="width:100%;">
                                Suspend
                            </div>
                        </a><?php
                    }
                }
                
                if (check_scope3('Academic registry', 'Correctional facility', 'Expel') > 0)
                {
                    if (isset($_REQUEST['corect'])&&$_REQUEST['corect']=='2')
                    {?>
                        <div id="tabss4_0" class="rtlft_inner_button_dull">
                            Expell
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=2;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss4" class="rtlft_inner_button" style="width:100%; display:none;">
                                Expell
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=2;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss4" class="rtlft_inner_button" style="width:100%;">
                                Expell
                            </div>
                        </a><?php
                    }
                }
                
                if (check_scope3('Academic registry', 'Correctional facility', 'Withdraw teporarily') > 0)
                {
                    if (isset($_REQUEST['corect'])&&$_REQUEST['corect']=='3')
                    {?>
                        <div id="tabss5_0" class="rtlft_inner_button_dull">
                            Withdraw temporarily
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=3;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                                Withdraw temporarily
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=3;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                                Withdraw temporarily
                            </div>
                        </a><?php
                    }
                }
                
                if (check_scope3('Academic registry', 'Correctional facility', 'Withdraw permanently') > 0)
                {
                    if (isset($_REQUEST['corect'])&&$_REQUEST['corect']=='4')
                    {?>
                        <div id="tabss5_0" class="rtlft_inner_button_dull">
                            Withdraw Permanently
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=4;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                                Withdraw Permanently
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=4;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                                Withdraw Permanently
                            </div>
                        </a><?php
                    }
                }
                
                if (check_scope3('Academic registry', 'Correctional facility', 'Unblock') > 0)
                {
                    if (isset($_REQUEST['corect'])&&$_REQUEST['corect']=='5')
                    {?>
                        <div id="tabss5_0" class="rtlft_inner_button_dull">
                            Unblock
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=5;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                                Unblock
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=5;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss5" class="rtlft_inner_button" style="width:100%; margin-top:5%">
                                Unblock
                            </div>
                        </a><?php
                    }
                }
                
                if (check_scope3('Academic registry', 'Correctional facility', 'Left suspension') > 0)
                {
                    if (isset($_REQUEST['corect'])&&$_REQUEST['corect']=='6')
                    {?>
                        <div id="tabss5_0" class="rtlft_inner_button_dull">
                                Lift suspension
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=6;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                                Lift suspension
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=6;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                                Lift suspension
                            </div>
                        </a><?php
                    }
                }                 
                
                if (check_scope3('Academic registry', 'Correctional facility', 'Recall from expulsion') > 0)
                {
                    if (isset($_REQUEST['corect'])&&$_REQUEST['corect']=='7')
                    {?>
                        <div id="tabss5_0" class="rtlft_inner_button_dull">
                            Re-call from expulsion
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=7;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                                Re-call from expulsion
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=7;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                                Re-call from expulsion
                            </div>
                        </a><?php
                    }
                }
                
                if (check_scope3('Academic registry', 'Correctional facility', 'Recall from withdrawal') > 0)
                {
                    if (isset($_REQUEST['corect'])&&$_REQUEST['corect']=='8')
                    {?>
                        <div id="tabss5_0" class="rtlft_inner_button_dull">
                                Re-call from withdrawal
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=8;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                                Re-call from withdrawal
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="_('corect').value=8;
                            rectional_loc.submit();
                            return false">
                            <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                                Re-call from withdrawal
                            </div>
                        </a><?php
                    }
                }?>
            </div>

           <div class="innercont_stff" style="float:left; height:auto; margin-top:0px; display:<?php if(isset($_REQUEST['corect']) && $_REQUEST['corect'] <> ''){echo 'block';}else{echo 'none';}?>">
                <div class="innercont_stff" style="margin-top:10px; display:<?php if (isset($_REQUEST['corect'])&&($_REQUEST['corect']=='0' || $_REQUEST['corect']=='1' || $_REQUEST['corect']=='5')){echo 'block;';}else{echo 'none;';}?>">
                    <div class="innercont_stff" style="margin-top:0px;">
                        <label for="mass_opr" class="labell">Mass operation</label>
                        <div class="div_select">
                        <input name="mass_opr" id="mass_opr" 
                            onclick="
                            var ulChildNodes = _('rtlft_std').getElementsByClassName('labell_msg');
                            for (j = 0; j <= ulChildNodes.length-1; j++)
                            {
                                ulChildNodes[j].style.display = 'none';
                            }
                                                    
                            if(this.checked)
                            {
                                this.value=1;
                                _('mass_opr_div').style.display = 'block';
                                _('single_opr_div').style.display = 'none';
                            }else
                            {
                                this.value=0;
                                _('mass_opr_div').style.display = 'none';
                                _('single_opr_div').style.display = 'block';
                            }"
                            value="0" type="checkbox"/>
                        </div>
                    </div>
                    <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
                </div>
                
                <div id="mass_opr_div" class="innercont_stff" style="height:415px; display:none;">
                    <div class="innercont_stff" style="margin-top:0px;">
                        <label for="mass_opr" class="labell">Concerned mat. numbers</label>
                        <div class="div_select" style="height:auto;">
                            <textarea rows="18" cols="20" 
                            style="width:148px;
                            padding:10px;" 
                            name="afn_list" 
                            id="afn_list" 
                            placeholder="Enter mat. nos. one per line here..."></textarea>
                        </div>
                        <div id="labell_msg0a" class="labell_msg blink_text orange_msg"></div>
                    </div>
                </div>
                
                <div id="single_opr_div" class="innercont_stff" style="margin-top:10px; display:block;">
                    <label for="uvApplicationNo" class="labell">Matriculation number</label>
                    <div class="div_select">
                        <input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox" style="text-transform:none;" value="<?php echo $_REQUEST['uvApplicationNo']; ?>" />
                    </div>
                    <div id="labell_msg1" class="labell_msg blink_text orange_msg"></div>
                </div>
                
                
                <div id="succ_box_inbtwn" class="succ_box blink_text orange_msg" style="width:auto; height:auto; margin-top:15px;"></div>
                <?php 
                if (isset($_REQUEST['corect'])&&$_REQUEST['corect'] == 1)
                {
                    //date_default_timezone_set('Africa/Lagos');
                    $current_date = date("Y-m-d");?>
                    <div id="period1_div" class="innercont_stff">
                        <div class="labell">End date</div>
                        <div class="div_select">
                            <input name="current_date" id="current_date" type="hidden" value="<?php echo $current_date; ?>" />
                            <input type="date" name="period1" id="period1" class="textbox" style="height:99%; width:99%" 
                                value="<?php echo $period1;?>"  
                                min="<?php echo $current_date;?>"
                                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
                        </div>
                        <div class="labell_msg blink_text orange_msg" id="labell_msg2"></div>
                    </div><?php
                }?>
                
                <div class="innercont_stff" style="height:85px; margin-top:5px">
                    <label for="rect_risn" class="labell">Reason for action</label>
                    <div class="div_select" style="height:80px;">
                        <textarea maxlength="40"
                        style="width:92%; height:89%; padding:10px" name="rect_risn" id="rect_risn"></textarea>
                    </div>
                    <div id="labell_msg3" class="labell_msg blink_text orange_msg"></div>
                </div>
            </div>
            <div id="succ_boxu" class="succ_box blink_text orange_msg" style="width:auto; height:auto; padding-bottom:4px;"></div>
        </form>
		<!-- InstanceEndEditable -->
	</div>
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
                
				<?php side_detail($_REQUEST['uvApplicationNo']);?>
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