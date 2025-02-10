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

if (($mm == 0 && $sm >= 9) || ($mm == 1) || $mm == 3 || ($mm == 2 && $sm > 1) || ($mm == 4) || $mm == 5)
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
	
	$stmt = $mysqli->prepare("select * from afnmatric where vMatricNo = ?");
	$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows === 0)
	{	
		$student_user_num = -1;
	}
	$stmt->close();
	
	$stmt = $mysqli->prepare("select 
	cblk,  
	csuspe, 
	cexpe, 
	tempwith,  
	permwith,
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
	$stmt->bind_result( 
	$cblk,
	$csuspe,
	$cexpe, 
	$tempwith,
	$permwith,
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
		
		var numbers = /^[NOU0-9_]+$/;
        //var letters_numbers = /^[A-Za-z0-9_]+$/;
		
		var formdata = new FormData();

        if (vc_request_loc.conf.value != 1)
        {
            if (_("mat_no_status").value == 0)
            {
                setMsgBox("labell_msg0","Invalid matriculation number");
                _('vc_request_loc').uvApplicationNo.focus();
                return false;
            }

            if (!_('vc_request_loc').uvApplicationNo.value.match(numbers))
            {
                setMsgBox("labell_msg0","Invalid number");
                _('vc_request_loc').uvApplicationNo.focus();
                return false;
            }if (_('vc_request_loc').uvApplicationNo.value == '')
            {
                setMsgBox("labell_msg0","");
                _('vc_request_loc').uvApplicationNo.focus();
                return false;
            }

            var made_request = 0;
            var ulChildNodes = _("rtlft_std").getElementsByTagName("input");
            for (j = 0; j <= ulChildNodes.length-1; j++)
            {
                if (ulChildNodes[j].offsetLeft > 0 && ulChildNodes[j].type == 'checkbox' && ulChildNodes[j].checked)
                {
                    made_request = 1;
                    break;
                }
            }

            if (made_request == 0)
            {
                caution_box('Select one or more request item on the menu by checking the corresponding box');
                return
            }
                
            if (_('vc_request_loc').vc_request_close.value == '')
            {
                setMsgBox("labell_msg1","");
                _('vc_request_loc').vc_request_close.focus();
                return false;
            }
        }else if (vc_request_loc.conf.value == 1)
        {
            formdata.append("conf", vc_request_loc.conf.value);
        }
				
		formdata.append("currency_cf", _("currency_cf").value);
		formdata.append("user_cat", _('vc_request_loc').user_cat.value);
		formdata.append("save_cf", _("save_cf").value);
		formdata.append("uvApplicationNo", _('vc_request_loc').uvApplicationNo.value);
		formdata.append("vApplicationNo", _('vc_request_loc').vApplicationNo.value);
		
		formdata.append("sm", _('vc_request_loc').sm.value);
		formdata.append("mm", _('vc_request_loc').mm.value);

		formdata.append("staff_study_center", _('vc_request_loc').user_centre.value);

        if (_("sp_sem_reg").checked)
        {
		    formdata.append("sp_sem_reg", "1");
        }else
        {
            formdata.append("sp_sem_reg", "0");
        }
        
        if (_("sp_crs_reg").checked)
        {
		    formdata.append("sp_crs_reg", "1");
        }else
        {
            formdata.append("sp_crs_reg", "0");
        }
        
        if (_("sp_drop_crs_reg").checked)
        {
		    formdata.append("sp_drop_crs_reg", "1");
        }else
        {
            formdata.append("sp_drop_crs_reg", "0");
        }
        
        // if (_("sp_see_crs_reg").checked)
        // {
		//     formdata.append("sp_see_crs_reg", "1");
        // }else
        // {
        //     formdata.append("sp_see_crs_reg", "0");
        // }
        
        
        if (_("sp_exam_reg").checked)
        {
		    formdata.append("sp_exam_reg", "1");
        }else
        {
            formdata.append("sp_exam_reg", "0");
        }

        if (_("sp_drop_exam_reg").checked)
        {
		    formdata.append("sp_drop_exam_reg", "1");
        }else
        {
            formdata.append("sp_drop_exam_reg", "0");
        }

        // if (_("sp_see_exam_reg").checked)
        // {
        //     formdata.append("sp_see_exam_reg", "1");
        // }else
        // {
        //     formdata.append("sp_see_exam_reg", "0");
        // }
        
		formdata.append("sp_see_exam_reg", _("sp_see_exam_reg").value);
		formdata.append("sp_see_crs_reg", _("sp_see_crs_reg").value);

		formdata.append("vc_request_close", _("vc_request_close").value);
        
		formdata.append("sp_ilevel", _("ilevel").value);
		formdata.append("sp_tsemester", _("tsemester").value);
        
		opr_prep(ajax = new XMLHttpRequest(),formdata);
	}
	
	
	function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_vc_request.php");
		ajax.send(formdata);
	}
   

    function Call_detail()
    {
        var formdata = new FormData();
        formdata.append("frm_upd", _("frm_upd").value);
        formdata.append("uvApplicationNo", _('vc_request_loc').uvApplicationNo.value);

		formdata.append("currency_cf", _("currency_cf").value);
		opr_prep(ajax = new XMLHttpRequest(),formdata);
    }

    function completeHandler(event)
	{
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}

        on_error('0');
        on_abort('0');
        in_progress('0');
        
        _("mat_no_status").value = 1;

		var returnedStr = event.target.responseText;
		
		var plus_ind = returnedStr.indexOf("+");
		var ash_ind = returnedStr.indexOf("#");
		
		if (returnedStr.indexOf("cannot be granted") != -1)
		{
            caution_box(returnedStr);
		}else if (returnedStr.indexOf("no active") != -1 || returnedStr.indexOf("graduated") != -1 || returnedStr.indexOf("invalid") != -1)
		{
            caution_box(returnedStr);
            _("mat_no_status").value = 0;
		}else if (_("frm_upd").value == 1)
        {
            _('app_frm_no').value = returnedStr.substr(0,plus_ind);
            
            _("std_names").innerHTML = returnedStr.substr(100, 100).trim()+'<br>'+
            returnedStr.substr(200, 100).trim()+'<br>'+
            returnedStr.substr(300, 100).trim();

            _("std_quali").innerHTML = returnedStr.substr(400, 100).trim()+'<br>'+
            returnedStr.substr(500, 100).trim();
            
            if (returnedStr.substr(600, 100).trim() == 20)
            {
                _("std_lvl").innerHTML = 'DIP 1';
            }else if (returnedStr.substr(600, 100).trim() == 30)
            {
                _("std_lvl").innerHTML = 'DIP 2';
            }else
            {
                _("std_lvl").innerHTML = returnedStr.substr(600, 100).trim()+' Level';
                _('ilevel').value = returnedStr.substr(600, 100).trim();
            }	
            
            _("std_lvl").style.display = 'block';

            
            _('tsemester').value = returnedStr.substr(700, 100).trim();

            if (returnedStr.substr(700, 100).trim() == 1)
            {
                if (_("std_sems")){_("std_sems").innerHTML = 'First semester';}
            }else
            {
                if (_("std_sems")){_("std_sems").innerHTML = 'Second semester';}
            }
            _("std_sems").style.display = 'block';
            
            _("std_vCityName").innerHTML = returnedStr.substr(800, 100).trim();
            _("std_vCityName").style.display = 'block';

            facult_id = returnedStr.substr(900,100).trim();

            var mask = returnedStr.substr(1000, 100).trim();

            _("passprt").src = '../../ext_docs/pics/'+facult_id+'/pp/p_'+mask+'.jpg';
            _("passprt").onerror = function() {myFunction1()};
            function myFunction1()
            {
                _("passprt").src = '../../ext_docs/pics/'+facult_id+'/pp/p_'+mask+'.jpeg';

                _("passprt").onerror = function() {myFunction2()};

                function myFunction2() 
                {
                    _("passprt").src = '../../ext_docs/pics/'+facult_id+'/pp/p_'+mask+'.pjpeg';
                    _("passprt").onerror = function() {myFunction3()};

                    function myFunction3() 
                    {
                        _("passprt").src = '../appl/img/left_side_logo.png';
                    }
                }
            }
            
            returnedStr = returnedStr.substr(ash_ind+1).trim();
            
            _("refresh_request").style.display = 'none';
            _("cancel_request").style.display = 'none';
            if (returnedStr != '')
            {
                caution_box("There is a request that is yet to be used");

                _("sp_sem_reg").checked = false;
                if (returnedStr.substr(0, 100).trim() == '1')
                {
                    _("sp_sem_reg").checked = true;
                }

                _("sp_crs_reg").checked = false;
                if (returnedStr.substr(100, 100).trim() == '1')
                {
                    _("sp_crs_reg").checked = true;
                }

                _("sp_drop_crs_reg").checked = false;
                if (returnedStr.substr(200, 100).trim() == '1')
                {
                    _("sp_drop_crs_reg").checked = true;
                }

                // _("sp_see_crs_reg").checked = false;
                // if (returnedStr.substr(300, 100).trim() == '1')
                // {
                //     _("sp_see_crs_reg").checked = true;
                // }

                _("sp_exam_reg").checked = false;
                if (returnedStr.substr(400, 100).trim() == '1')
                {
                    _("sp_exam_reg").checked = true;
                }

                _("sp_drop_exam_reg").checked = false;
                if (returnedStr.substr(500, 100).trim() == '1')
                {
                    _("sp_drop_exam_reg").checked = true;
                }

                // _("sp_see_exam_reg").checked = false;
                // if (returnedStr.substr(600, 100).trim() == '1')
                // {
                //     _("sp_see_exam_reg").checked = true;
                // }
                
                _("request_date").innerHTML = returnedStr.substr(700, 100).trim();
                _("vc_request_close").value = returnedStr.substr(800, 100).trim();

                duration = parseInt(returnedStr.substr(800, 100).trim());
                elapsed_time = parseInt(returnedStr.substr(900, 100).trim());

                _("time_to_go").innerHTML = (duration - elapsed_time)+' minutes';


                _("refresh_request").style.display = 'block';
                _("cancel_request").style.display = 'block';
            }else
            {
                caution_box("There is no active request.<br>You may set options accordingly to set a new one");
                _("time_to_go").innerHTML = '0';
            }

            _("prv_request").style.display = 'block';
            if (_("list_request"))
            {
                _("list_request").style.display = 'none';
            }

            _("frm_upd").value = 0;
        }else if (returnedStr.indexOf("successfully") != -1)
		{
            success_box(returnedStr);
		}

        vc_request_loc.conf.value='0';
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
				border-bottom:1px solid #FF3300;">
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
            <div class="innercont_top">Off-line request</div>

            <form action="off_line_request" method="post" name="vc_request_loc" id="vc_request_loc" enctype="multipart/form-data">
                <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST['user_cat'];} ?>" />	
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                <input name="tabno" id="tabno" type="hidden" 
                    value="<?php if (isset($_REQUEST['save_cf'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
                <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                <input name="frm_upd" id="frm_upd" type="hidden" />
                <input name="numOfiputTag" id="numOfiputTag" type="hidden" value="0"/>
                <input name="study_mode" id="study_mode" type="hidden" value="odl" />
                
                <input name="app_frm_no" id="app_frm_no" type="hidden" value="<?php if (isset($_REQUEST["app_frm_no"])){echo $_REQUEST["app_frm_no"];} ?>"/>
                <input name="ilevel" id="ilevel" type="hidden" value="<?php if (isset($_REQUEST["ilevel"])){echo $_REQUEST["ilevel"];}?>"/>
                <input name="tsemester" id="tsemester" type="hidden" value="<?php if (isset($_REQUEST["tsemester"])){echo $_REQUEST["tsemester"];} ?>"/>
                <input name="mat_no_status" id="mat_no_status" type="hidden"  value="<?php if (isset($_REQUEST["mat_no_status"])){echo $_REQUEST["mat_no_status"];} ?>"/>

                <?php frm_vars(); ?>
                
                <div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
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
                    <div id="submityes_msg" 
                        style="width:inherit; 
                        float:left; 
                        height:auto; 
                        text-align:center; 
                        padding:3px; 
                        margin-top:5px; 
                        margin-bottom:10px;">
                        Are you sure you want to cancel request ?
                    </div>
                    
                    <a href="#" style="text-decoration:none;" 
                        onclick="_('submityes').style.display='none';
                        _('smke_screen_2').style.display='none';
                        vc_request_loc.conf.value='1';
                        chk_inputs();
                        return false">
                        <div class="submit_button_green" style="width:60px; padding:2px; float:right">
                            Yes
                        </div>
                    </a>

                    <a href="#" style="text-decoration:none;" 
                        onclick="vc_request_loc.conf.value='0';
                        _('submityes').style.display='none';
                        _('smke_screen_2').style.display='none';
                        return false">
                        <div class="submit_button_brown_reverse" style="width:60px; padding:2px; margin-right:4px; float:right">
                            No
                        </div>
                    </a>
                </div>


                <div class="innercont_stff" style="margin-bottom:20px; width:99%;">
					<div class="div_select" style="width:270px; padding:5px;">
                        Matriculation number
					</div>
                    <div class="div_select" style="padding-left:0px; width:200px;">
                        <input name="uvApplicationNo" id="uvApplicationNo" 
                            type="text"
                            maxlength="25" 
                            class="textbox"
                            onchange="this.value=this.value.replace(/ /g, '');
			                this.value=this.value.toUpperCase();
                            this.value=this.value.trim();
                            if(this.value.trim()!='')
                            {
                                _('frm_upd').value=1;
                                Call_detail();
                            }else
                            {
                                _('labell_msg0').style.display = 'none';
                                
                                _('cancel_request').style.display = 'none';
                                _('prv_request').style.display = 'none';
                                _('refresh_request').style.display = 'none';
                                
                                _('sp_sem_reg').checked = false;
                                _('sp_crs_reg').checked = false;
                                _('sp_drop_crs_reg').checked = false;
                                _('sp_see_crs_reg').checked = false;
                                _('sp_exam_reg').checked = false;
                                _('sp_drop_exam_reg').checked = false;
                                _('vc_request_close').value = '';
                                _('time_to_go').innerHTML = 0;
                            }" 
                            value="<?php if (isset($_REQUEST['uvApplicationNo'])){echo $_REQUEST['uvApplicationNo'];} ?>" 
                            placeholder="Enter matric. number here"/>
                    </div>
					<div id="labell_msg0" class="labell_msg blink_text orange_msg" style="float:left;width:200px"></div>
                </div>

                <a id="cancel_request" href="#" style="display:none" 
                    onclick="_('smke_screen_2').style.zIndex='1';
                        _('smke_screen_2').style.display='block';
                        _('submityes').style.zIndex='2';
                        _('submityes').style.display='block';">
                    <input type="button" value="Cancel request" class="cancel_stff_btn" 
                    style="float:right; margin-top:5px; margin-right:10px;"/>
                </a>

                <a id="prv_request" href="#" style="display:none" onclick="vc_request_loc.submit();">
                    <input type="button" value="See previous requests" class="prv_reqst_stff_btn" 
                    style="float:right; margin-top:5px; margin-right:10px;"/>
                </a>

                <a id="refresh_request" href="#" style="display:none" onclick="_('frm_upd').value=1;Call_detail();">
                    <input type="button" value="Refresh" class="prv_reqst_stff_btn" 
                    style="float:right; margin-top:5px; margin-right:10px;"/>
                </a>
                
                <div id="make_request" class="innercont_stff" style="margin:auto 0px; width:100%; display:block; height:auto;">
                    <div class="innercont_stff" style="margin-top:0px; padding-top:3px">
                        <div class="div_select" style="width:270px; padding:5px;">
                            Date of request
                        </div>
                        <div id="request_date" class="div_select" style="padding:5px; padding-left:0px;">
                            <?php echo date("d-m-Y");?>
                        </div>
                    </div>
                    
                    <fieldset style="border-radius:3px; width:97.8%; float:left; border:1px solid #ccc">
                        <legend style="font-size:13px">Request menu</legend>
                        <div class="innercont_stff" style="margin-bottom:0px; font-weight:bold">
                            <div class="div_select" style="width:20px; height:80%; padding:5px; text-align:right; background:#f3f3f3">
                                Sn
                            </div>
                            <div class="div_select" style="padding:5px; height:80%; width:220px; background:#f3f3f3">
                                Action
                            </div>
                            <div class="div_select" style="width:720px; height:80%; padding:5px; background:#f3f3f3">
                                Allow
                            </div>
                        </div>
                        
                        <div class="innercont_stff" style="margin-top:10px;">
                            <label for="sp_sem_reg" style="width:100%"> 
                                <div class="div_select" style="width:20px; height:80%; padding:5px; text-align:right; background:#f3f3f3">
                                    1
                                </div>
                                <div class="div_select" style="padding:5px; height:80%; width:220px; background:#f3f3f3">   
                                        Register for the semester
                                </div>
                                <div class="div_select" style="width:720px; height:80%; padding:5px; background:#f3f3f3">
                                    <input name="sp_sem_reg" id="sp_sem_reg" type="checkbox" value="0" onclick="if(this.checked){this.value=1}else{this.value=0}"/>
                                </div>
                            </label>
                        </div>
                        
                        <div class="innercont_stff" style="margin-top:10px;">
                            <label for="sp_crs_reg" style="width:100%">
                                <div class="div_select" style="width:20px; height:80%; padding:5px; text-align:right; background:#f3f3f3">
                                    2
                                </div>
                                <div class="div_select" style="padding:5px; height:80%; width:220px; background:#f3f3f3">
                                    Register courses
                                </div>
                                <div class="div_select" style="width:720px; height:80%; padding:5px; background:#f3f3f3">
                                    <input name="sp_crs_reg" id="sp_crs_reg" type="checkbox" value="0" onclick="if(this.checked){this.value=1}else{this.value=0}"/>
                                </div>
                            </label>
                        </div>
                        
                        <div class="innercont_stff" style="margin-top:10px;">
                            <label for="sp_drop_crs_reg" style="width:100%">
                                <div class="div_select" style="width:20px; height:80%; padding:5px; text-align:right; background:#f3f3f3">
                                    3
                                </div>
                                <div class="div_select" style="padding:5px; height:80%; width:220px; background:#f3f3f3">
                                    Drop registered courses 
                                </div>
                                <div class="div_select" style="width:720px; height:80%; padding:5px; background:#f3f3f3">
                                    <input name="sp_drop_crs_reg" id="sp_drop_crs_reg" type="checkbox" value="0" onclick="if(this.checked){this.value=1}else{this.value=0}"/>
                                </div>
                            </label>
                        </div>
                        
                        
                        <!-- <input name="sp_see_crs_reg" id="sp_see_crs_reg" type="hidden" value="0"/> -->
                        <div class="innercont_stff" style="margin-top:10px;">
                            <label for="sp_see_crs_reg" style="width:100%">
                                <div class="div_select" style="width:20px; height:80%; padding:5px; text-align:right; background:#f3f3f3">
                                    4
                                </div>
                                <div class="div_select" style="padding:5px; height:80%; width:220px; background:#f3f3f3">
                                    See course registeration slip
                                </div>
                                <div class="div_select" style="width:720px; height:80%; padding:5px; background:#f3f3f3">
                                    <input name="sp_see_crs_reg" id="sp_see_crs_reg" type="checkbox" value="0" onclick="if(this.checked){this.value=1}else{this.value=0}"/>
                                </div>
                            </label>
                        </div>
                        
                        <div class="innercont_stff" style="margin-top:10px;">
                            <label for="sp_exam_reg" style="width:100%">
                                <div class="div_select" style="width:20px; height:80%; padding:5px; text-align:right; background:#f3f3f3">
                                    4
                                </div>
                                <div class="div_select" style="padding:5px; height:80%; width:220px; background:#f3f3f3">
                                    Register exam
                                </div>
                                <div class="div_select" style="width:720px; height:80%; padding:5px; background:#f3f3f3">
                                    <input name="sp_exam_reg" id="sp_exam_reg" type="checkbox" value="0" onclick="if(this.checked){this.value=1}else{this.value=0}"/>
                                </div>
                            </label>
                        </div>
                        
                        <div class="innercont_stff" style="margin-top:10px;">
                            <label for="sp_drop_exam_reg" style="width:100%">
                                <div class="div_select" style="width:20px; height:80%; padding:5px; text-align:right; background:#f3f3f3">
                                    5
                                </div>
                                <div class="div_select" style="padding:5px; height:80%; width:220px; background:#f3f3f3">
                                    Drop registered courses for exam
                                </div>
                                <div class="div_select" style="width:720px; height:80%; padding:5px; background:#f3f3f3">
                                    <input name="sp_drop_exam_reg" id="sp_drop_exam_reg" type="checkbox" value="0" onclick="if(this.checked){this.value=1}else{this.value=0}"/>
                                </div>
                            </label>
                        </div>
                        
                        <input name="sp_see_exam_reg" id="sp_see_exam_reg" type="hidden" value="0"/>
                        <!-- <div class="innercont_stff" style="margin-top:10px;">
                            <label for="sp_see_exam_reg" style="width:100%">
                                <div class="div_select" style="width:20px; height:80%; padding:5px; text-align:right; background:#f3f3f3">
                                    7
                                </div>
                                <div class="div_select" style="padding:5px; height:80%; width:220px; background:#f3f3f3">
                                    See exam registeration slip
                                </div>
                                <div class="div_select" style="width:720px; height:80%; padding:5px; background:#f3f3f3">
                                    <input name="sp_see_exam_reg" id="sp_see_exam_reg" type="checkbox" value="0" onclick="if(this.checked){this.value=1}else{this.value=0}"/>
                                </div>
                            </label>
                        </div> -->
                    </fieldset>


                    <div class="innercont_stff" style="margin-top:25px; padding-top:3px">
                        <div class="div_select" style="width:270px; padding:5px;">
                            Expiration time (minutes)
                        </div>
                        <div class="div_select" style="padding:5px; padding-top:0px; padding-left:0px;">
                            <select name="vc_request_close" id="vc_request_close" class="select" style="width:auto" 
                                onchange="_('time_to_go').innerHTML=this.value">
                                <option value="" selected></option><?php
                                for($i=5;$i<=60;$i++)
                                {?>
                                    <option value="<?php echo $i; ?>"><?php echo $i;?></option><?php
                                }?>
                            </select>
                        </div>
                        <div id="labell_msg1" class="labell_msg blink_text orange_msg" style="float:left"></div>
                    </div>
                    
                    
                    <div class="innercont_stff" style="margin-top:14px; background:#fcebeb">
                        <div class="div_select" style="width:270px; padding:5px;">
                            Time left (minutes)
                        </div>
                        <div id="time_to_go" class="div_select" style="padding:5px; padding-left:0px;">
                            0 minute
                        </div>
                    </div>
                </div><?php

                if (isset($_REQUEST['uvApplicationNo']) && $_REQUEST['uvApplicationNo'] <> '')
                {?>
                    <div id="smke_screen_3" class="smoke_scrn" style="display:block"></div>
                    <div id="list_request" class="center" 
                        style="display:block; 
                        width:96%; 
                        text-align:center; 
                        padding:15px;  
                        padding-right:10px; 
                        box-shadow: 2px 2px 8px 2px #726e41; 
                        background:#FFFFFF;
                        z-index:2;">
                        <div style="width:95.7%; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold;">
                            Previous requests
                        </div>
                        <div style="width:3.6%;
                            height:15px;
                            padding:3px;
                            float:left; 
                            text-align:right;">
                                <a href="#"
                                    onclick="_('list_request').style.display = 'none';
                                    _('list_request').zIndex = '-1';
                                    _('smke_screen_3').style.display = 'none';
                                    _('smke_screen_3').zIndex = '-1';
                                    return false" 
                                    style="margin-right:3px; text-decoration:none;">
                                        <img style="width:17px; height:17px; float:right" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>"/>
                                </a>
                        </div>
                        <div style="width:100%; margin-top:30px; height:auto; font-size:0.9em; background:#ccc">
                            <div class="_label" style="border:1px solid #cdd8cf; width:3%; height:auto; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:right; background-color:#E3EBE2;">
                                Sno
                            </div>
                            <div class="_label" style="border:1px solid #cdd8cf; width:12.4%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left; background-color:#E3EBE2;">
                                Date
                            </div>
                            <div class="_label" style="border:1px solid #cdd8cf; width:8.6%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:right; background-color:#E3EBE2;">
                                Duration (min)
                            </div>
                            <div class="_label" style="border:1px solid #cdd8cf; width:10%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; background-color:#E3EBE2;">
                                Reg. for semester
                            </div>
                            <div class="_label" style="border:1px solid #cdd8cf; width:8.5%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; background-color:#E3EBE2;">
                                Reg. courses
                            </div>
                            <div class="_label" style="border:1px solid #cdd8cf; width:8.5%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; background-color:#E3EBE2;">
                                Drop courses
                            </div>
                            <!-- <div class="_label" style="border:1px solid #cdd8cf; width:9.7%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left; background-color:#E3EBE2;">
                                See course reg. slip
                            </div> -->
                            <div class="_label" style="border:1px solid #cdd8cf; width:14%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; background-color:#E3EBE2;">
                                Reg. courses for exam
                            </div>
                            <div class="_label" style="border:1px solid #cdd8cf; width:14%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; background-color:#E3EBE2;">
                                Drop courses for exam
                            </div>
                            <!-- <div class="_label" style="border:1px solid #cdd8cf; width:10%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left; background-color:#E3EBE2;">
                                See exam reg. slip
                            </div> -->
                            <div class="_label" style="border:1px solid #cdd8cf; width:4%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left; background-color:#E3EBE2;">
                                Used
                            </div>
                            <div class="_label" style="border:1px solid #cdd8cf; width:7.3%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left; background-color:#E3EBE2;">
                                Canceled
                            </div>
                        </div>

                        <div style="line-height:2; margin-top:10px; width:100%; float:left; text-align:justify; padding:0px;
                        max-height: 650px;
                        padding-right:5px;
                        overflow:scroll; 
                        font-size:0.9em;
                        overflow-x: hidden;"><?php
                            $stmt = $mysqli->prepare("SELECT semester_reg,crs_reg,drp_crs_reg,see_crs_reg_slip,exam_reg,drp_exam_reg,see_exam_reg_slip,time_act,duration, TIMESTAMPDIFF(MINUTE,time_act,NOW()), used, cdel
                            FROM vc_request
                            WHERE vMatricNo = ?
                            ORDER BY time_act DESC");
                            $stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($semester_reg, $crs_reg, $drp_crs_reg, $see_crs_reg_slip, $exam_reg, $drp_exam_reg, $see_exam_reg_slip, $time_act, $duration, $time_elapse, $used, $cdel);
                            if ($stmt->num_rows > 0)
                            {
                                $cnt = 0;
                                while($stmt->fetch())
                                {
                                    $stmt_a = $mysqli->prepare("SELECT vApplicationNo, vDeed
                                    FROM atv_log
                                    WHERE tDeedTime = '$time_act'
                                    AND vDeed LIKE 'Set up VC request for %'
                                    AND vDeed LIKE '%".$_REQUEST['uvApplicationNo']."'");
                                    //$stmt_a->bind_param("s", $_REQUEST['uvApplicationNo']);
                                    $stmt_a->execute();
                                    $stmt_a->store_result();
                                    if ($stmt_a->num_rows == 0)
                                    {
                                        $stmt_a->close();
                                        $stmt_a = $mysqli->prepare("SELECT vApplicationNo, vDeed
                                        FROM atv_log
                                        WHERE tDeedTime = DATE_ADD('$time_act',INTERVAL 1 SECOND)
                                        AND vDeed LIKE 'Set up VC request for %'
                                        AND vDeed LIKE '%".$_REQUEST['uvApplicationNo']."'");
                                        //$stmt_a->bind_param("s", $_REQUEST['uvApplicationNo']);
                                        $stmt_a->execute();
                                        $stmt_a->store_result();
                                    }
                                    $stmt_a->bind_result($vApplicationNo_1, $vDeed_1);
                                    $stmt_a->fetch();
                                    $stmt_a->close();

                                    $stmt_a = $mysqli->prepare("SELECT vApplicationNo, vDeed
                                    FROM atv_log
                                    WHERE tDeedTime > '$time_act'
                                    AND vDeed LIKE 'Canceled VC request%'
                                    AND vDeed LIKE '%".$_REQUEST['uvApplicationNo']."'
                                    ORDER BY tDeedTime DESC LIMIT 1");
                                    //$stmt_a->bind_param("s", $_REQUEST['vApplicationNo']);
                                    $stmt_a->execute();
                                    $stmt_a->store_result();
                                    $stmt_a->bind_result($vApplicationNo_2, $vDeed_2);
                                    $stmt_a->fetch();
                                    $stmt_a->close();
                                    
                                    $color = 'green';
                                    if ($time_elapse > $duration || $used  == '1' || $cdel == 'Y')
                                    {
                                        $color = '#989e99';
                                    }?>
                                    <div style="width:100%; margin-top:5px; height:auto; color:<?php echo $color;?>" title="<?php echo $vApplicationNo_1.' '.$vDeed_1.', '.$vApplicationNo_2.' '.$vDeed_2;?>">
                                        <div class="_label" style="border:1px solid #cdd8cf; width:3.0%; height:auto; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:right;">
                                            <?php echo ++$cnt;?>
                                        </div>
                                        <div class="_label" style="border:1px solid #cdd8cf; width:12.55%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left;">
                                            <?php echo formatdate($time_act,'fromdb').' '.substr($time_act, 11);?>
                                        </div>
                                        <div class="_label" style="border:1px solid #cdd8cf; width:8.75%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:right;">
                                            <?php echo $duration;?>
                                        </div>
                                        <div class="_label" style="border:1px solid #cdd8cf; width:10.2%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px;">
                                            <?php if ($semester_reg == '1'){echo 'Yes';}else{echo 'No';}?>
                                        </div>
                                        <div class="_label" style="border:1px solid #cdd8cf; width:8.7%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px;">
                                            <?php if ($crs_reg == '1'){echo 'Yes';}else{echo 'No';}?>
                                        </div>
                                        <div class="_label" style="border:1px solid #cdd8cf; width:8.7%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px;">
                                            <?php if ($drp_crs_reg == '1'){echo 'Yes';}else{echo 'No';}?>
                                        </div>
                                        <!-- <div class="_label" style="border:1px solid #cdd8cf; width:9.7%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left;">
                                            <?php if ($see_crs_reg_slip == '1'){echo 'Yes';}else{echo 'No';}?>
                                        </div> -->
                                        <div class="_label" style="border:1px solid #cdd8cf; width:14.3%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px;">
                                            <?php if ($exam_reg == '1'){echo 'Yes';}else{echo 'No';}?>
                                        </div>
                                        <div class="_label" style="border:1px solid #cdd8cf; width:14.2%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px;">
                                            <?php if ($drp_exam_reg == '1'){echo 'Yes';}else{echo 'No';}?>
                                        </div>
                                        <!-- <div class="_label" style="border:1px solid #cdd8cf; width:10%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left;">
                                            <?php if ($see_exam_reg_slip == '1'){echo 'Yes';}else{echo 'No';}?>
                                        </div> -->
                                        <div class="_label" style="border:1px solid #cdd8cf; width:4%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left;">
                                            <?php if ($used == '1'){echo 'Yes';}else{echo 'No';}?>
                                        </div>
                                        <div class="_label" style="border:1px solid #cdd8cf; width:5%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left;">
                                            <?php if ($cdel == 'Y'){echo 'Yes';}else{echo 'No';}?>
                                        </div>
                                    </div><?php
                                }
                            }else
                            {
                                information_box_inline('There are no previous requests');
                            }
                            $stmt->close();?>
                        </div>
                    </div><?php
                }?>
            </form>
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