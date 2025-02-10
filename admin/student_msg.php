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

    function chk_inputs()
    {
		var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			ulChildNodes[j].style.display = 'none';
		}
		
		if (_("loc_what").value != 0)
        {
            if (student_msg_loc.msg_prv.value == '')
            {
                setMsgBox("labell_msg1","");
                student_msg_loc.msg_prv.focus();
                return false;
            }
        }
        
        if (_("loc_what").value != 2)
        {
            if (_('loc_what').value == 1 && _('msg_prv').value == '')
            {
                setMsgBox("labell_msg1","");
                student_msg_loc.msg_prv.focus();
                return false;
            }
            
            var skipped = 0;

            if (/*!_("all_pg_student").checked && */student_msg_loc.msg_faculty.value == '' && _("target_student_skipped").value == 0)
            {
                setMsgBox("labell_msg2","Not selected");
                student_msg_loc.msg_faculty.focus();
                skipped = 1;
            }
            
            if (/*!_("all_pg_student").checked && */student_msg_loc.msg_dept.value == '' && _("target_student_skipped").value == 0)
            {
                setMsgBox("labell_msg3","Not selected");
                student_msg_loc.msg_dept.focus();
                skipped = 1;
            }

            if (/*!_("all_pg_student").checked && */student_msg_loc.msg_programe.value == '' && _("target_student_skipped").value == 0)
            {
                setMsgBox("labell_msg4","Not selected");
                student_msg_loc.msg_programe.focus();
                skipped = 1;
            }
            
            if (student_msg_loc.msg_level.value == '' && _("target_student_skipped").value == 0)
            {
                setMsgBox("labell_msg5","Not selected");
                student_msg_loc.msg_level.focus();
                skipped = 1;
            }
            
            if (skipped == 1 && _("target_student_skipped").value == 0)
            {
                student_msg_loc.conf.value = 1;

                _("conf_msg_msg_loc").innerHTML = 'Are you sure you want to skip fields under target students?';
                _('conf_box_loc').style.display = 'block';
                _('conf_box_loc').style.zIndex = '3';
                _('smke_screen_2').style.display = 'block';
                _('smke_screen_2').style.zIndex = '2';
                return;
            }

            if (student_msg_loc.mm.value == '8' && student_msg_loc.msg_level.value == '')
            {
                setMsgBox("labell_msg5","");
                student_msg_loc.msg_level.focus();
                return false;
            }
            
            if (student_msg_loc.msg_subject.value == '')
            {
                setMsgBox("labell_msg6","");
                student_msg_loc.msg_subject.focus();
                return false;
            }

            if (wordCount(student_msg_loc.msg_subject.value) > 10)
            {
                setMsgBox("labell_msg6","Too many words. Maximum is 10");
                student_msg_loc.msg_body.focus();
                return false;
            }


            if (student_msg_loc.msg_body.value == '')
            {
                setMsgBox("labell_msg7","");
                student_msg_loc.msg_body.focus();
                return false;
            }

            if (wordCount(student_msg_loc.msg_body.value) > 200)
            {
                setMsgBox("labell_msg7","Too many words. Maximum is 200");
                student_msg_loc.msg_body.focus();
                return false;
            }

            if (student_msg_loc.msg_sign.value == '')
            {
                setMsgBox("labell_msg8","");
                student_msg_loc.msg_sign.focus();
                return false;
            }

            if (student_msg_loc.date_msg1.value == '' || student_msg_loc.date_msg1.value.length != 10)
            {
                setMsgBox("labell_msg9","");
                student_msg_loc.date_msg1.focus();
                return false;
            }

            if (_("date_msg1") && _("date_msg1").value != '' && properdate(_("date_msg1").value,_("current_date").value))
            {
                setMsgBox("labell_msg9","Future date required");
                return false;
            }

            if (_("msg_loc") && _("msg_loc").value == '')
            {
                setMsgBox("labell_msg10","");
                return false;
            }

            if (student_msg_loc.save_cf.value == 2 && student_msg_loc.conf.value != 2)
            {
                student_msg_loc.conf.value = 2;

                _("conf_msg_msg_loc").innerHTML = 'Message will only be saved but, not sent to the notice board. If message is already sent, it will be removed from the board.<br>Continue?';
                _('conf_box_loc').style.display = 'block';
                _('conf_box_loc').style.zIndex = '3';
                _('smke_screen_2').style.display = 'block';
                _('smke_screen_2').style.zIndex = '2';
                return;
            }
        }
		
        var formdata = new FormData();

        if (_("loc_what").value == 2 && student_msg_loc.conf.value == '')
		{            
            _("conf_msg_msg_loc").innerHTML = 'Are you sure you want to delete selected message?';
            _('conf_box_loc').style.display = 'block';
            _('conf_box_loc').style.zIndex = '3';
            _('smke_screen_2').style.display = 'block';
            _('smke_screen_2').style.zIndex = '2';
            return;
        }else  if (_("loc_what").value == 2 && student_msg_loc.conf.value == '1')
        {
            formdata.append("conf_del", student_msg_loc.conf.value);
        }     
        
        formdata.append("mm", student_msg_loc.mm.value);
        formdata.append("sm", student_msg_loc.sm.value);
        
        formdata.append("save_cf", student_msg_loc.save_cf.value);
        formdata.append("currency_cf", student_msg_loc.currency_cf.value);
        formdata.append("user_cat", student_msg_loc.user_cat.value);
        formdata.append("what", student_msg_loc.loc_what.value);
        
        formdata.append("vApplicationNo", student_msg_loc.vApplicationNo.value);
        formdata.append("msg_subject", student_msg_loc.msg_subject.value);

        if (student_msg_loc.mm.value == 8)
        {
            //formdata.append("pg_students", '1');
            if (_("all_pg").checked)
            {
                formdata.append("all_pg", '1');
            }
        }
        // if (student_msg_loc.conf.value == '1')
        // {
        //     formdata.append("conf", student_msg_loc.conf.value);
        // }else
        // {
            if (!student_msg_loc.msg_faculty.disabled)
            {
                formdata.append("msg_faculty", student_msg_loc.msg_faculty.value);
            }else
            {
                formdata.append("msg_faculty", '');
            }

            
            if (!student_msg_loc.msg_dept.disabled)
            {
                formdata.append("msg_dept", student_msg_loc.msg_dept.value);
            }else
            {
                formdata.append("msg_dept", '');
            }

            
            if (!student_msg_loc.msg_programe.disabled)
            {
                formdata.append("msg_programe", student_msg_loc.msg_programe.value);
            }else
            {
                formdata.append("msg_programe", '');
            }
            
            formdata.append("msg_level", student_msg_loc.msg_level.value);
        
            formdata.append("existing_msg_subject", student_msg_loc.existing_msg_subject.value);

            formdata.append("msg_subject", student_msg_loc.msg_subject.value);
            formdata.append("msg_body", student_msg_loc.msg_body.value);
            formdata.append("msg_loc", student_msg_loc.msg_loc.value);
            formdata.append("msg_sign", student_msg_loc.msg_sign.value);

            formdata.append("date_msg1", student_msg_loc.date_msg1.value);
        //}        
        
        opr_prep(ajax = new XMLHttpRequest(),formdata);		
	}
	
	function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_student_msg.php");
		ajax.send(formdata);
	}


    function completeHandler(event)
	{
        on_error('0');
        on_abort('0');
        in_progress('0');
        _("succ_box_inbtwn").style.display = 'none';

		var returnedStr = event.target.responseText;
        
        if (returnedStr.indexOf("already") != -1)
        {
            caution_box(returnedStr);
        }else if (returnedStr.indexOf("success") != -1 ||
        returnedStr.indexOf("Success") != -1)
        {
            success_box(returnedStr);
            _("msg_subject").value = '';
            _("msg_body").value = '';
            _("msg_sign").value = '';
            _("date_msg1").value = '';

            if (returnedStr.indexOf("saved") != -1)
            {
                _("send_box").innerHTML = 'Send';
            }

            if (returnedStr.indexOf("deleted") != -1 )
            {
                _('msg_prv').remove(_('msg_prv').selectedIndex);
                student_msg_loc.conf.value = '';
            }
        }else if (returnedStr.indexOf("cannot") != -1 || returnedStr.indexOf("must be") != -1)
        {
            //caution_box(returnedStr);
            setMsgBox("labell_msg9",returnedStr);
            student_msg_loc.dday1.focus();
        }else if (_("get_msg_detail").value != '')
        {
            _("msg_target_std_div").style.display = 'block';
            _("msg_subject_div").style.display = 'block';
            _("msg_body_div").style.display = 'block';
            _("msg_sign_div").style.display = 'block';
            _("msg_show_div").style.display = 'block';
            _("date_msg_div").style.display = 'block';         

            _("msg_faculty").value = returnedStr.substr(0,5).trim();
            
            update_cat_country('msg_faculty', 'cdeptId_readup', 'msg_dept', 'msg_programe');
            _("msg_dept").value = returnedStr.substr(5,5).trim();

            update_cat_country('msg_dept', 'cprogrammeId_readup', 'msg_programe', 'ccourseIdold');
            _("msg_programe").value = returnedStr.substr(10,10).trim();

            
            _("msg_level").value = returnedStr.substr(20,5).trim();

            _("msg_subject").value = returnedStr.substr(25,150).trim();
            _("existing_msg_subject").value = returnedStr.substr(25,150).trim();
            
            _("msg_body").value = returnedStr.substr(175,1000).trim();
            _("msg_sign").value = returnedStr.substr(1175,150).trim();

            _("date_msg1").value = returnedStr.substr(1325,15).trim();
            
            if (returnedStr.substr(1340,10).trim() == '1')
            {
                _("succ_box_inbtwn").className = 'succ_box blink_text green_msg';
                _("succ_box_inbtwn").innerHTML = 'Message sent';
                if (student_msg_loc.loc_what.value != 2)
                {
                    _("send_box").innerHTML = 'Re-send';
                }                
            }else
            {
                _("succ_box_inbtwn").className = 'succ_box blink_text orange_msg';
                _("succ_box_inbtwn").innerHTML = 'Message not sent';
                if (student_msg_loc.loc_what.value != 2)
                {
                    _("send_box").innerHTML = 'send';
                }                
            }
            _('msg_loc').value = returnedStr.substr(1350,10).trim()

            _("succ_box_inbtwn").style.display = 'block';

            if (_("dday1"))
            {
                _("dday1").value = _("date_msg1").value.substr(8,2);
                _("mmonth1").value = _("date_msg1").value.substr(5,2);
                _("yyear1").value = _("date_msg1").value.substr(0,4);
            }
            
            _("save_box").style.display = 'none';
            _("send_box").style.display = 'none';
            _("del_box").style.display = 'none';

            if (student_msg_loc.loc_what.value == 1)
            {
                _("save_box").style.display = 'block';
                _("send_box").style.display = 'block';
            }else if (student_msg_loc.loc_what.value == 2)
            {
                _("del_box").style.display = 'block';
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

    function fetch_msg_detail()
    {
        _("msg_target_std_div").style.display = 'none';
        _("msg_subject_div").style.display = 'none';
        _("msg_body_div").style.display = 'none';
        _("msg_sign_div").style.display = 'none';
        _("date_msg_div").style.display = 'none';
        _("msg_show_div").style.display = 'none';
        
        
        
        if (student_msg_loc.loc_what.value == 0)
        {
            if ( _("tabss0_0"))
            {
                _("tabss0_0").style.display = 'none';
                _("tabss0").style.display = 'block';
            }
            
            if ( _("tabss1_0"))
            {
                _("tabss1_0").style.display = 'none';
                _("tabss1").style.display = 'block';
            }
            
            if ( _("tabss2_0"))
            {
                _("tabss2_0").style.display = 'none';
                _("tabss2").style.display = 'block';
            }

            student_msg_loc.loc_what.value = '';
        }
       
        
        var formdata = new FormData();

        formdata.append("mm", student_msg_loc.mm.value);
        formdata.append("sm", student_msg_loc.sm.value);
        
        formdata.append("currency_cf", student_msg_loc.currency_cf.value);
        formdata.append("user_cat", student_msg_loc.user_cat.value);
        
        formdata.append("vApplicationNo", student_msg_loc.vApplicationNo.value);
        formdata.append("msg_prv", student_msg_loc.msg_prv.value);

        _("get_msg_detail").value = '1';
        formdata.append("get_msg_detail", _("get_msg_detail").value);
        
        opr_prep(ajax = new XMLHttpRequest(),formdata);              
    }
</script><?php

//include ('set_scheduled_dates.php');?>
<!-- InstanceEndEditable -->
</head>
<body onLoad="checkConnection()">
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

    <?php admin_frms(); $has_matno = 0;?>
	
	<form action="staff_home_page" method="post" name="nxt" id="nxt" enctype="multipart/form-data">
        <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" value="" />
        <input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
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
                
                if (_('loc_what').value == 0 || _('loc_what').value == 1)
                {
                    _('target_student_skipped').value = '1';                    
                    
                    student_msg_loc.conf_1.value = parseInt(student_msg_loc.conf_1.value) + 1;
                }else if (_('loc_what').value == 2)
                {
                    if (student_msg_loc.conf.value!='2')
                    {
                        student_msg_loc.conf.value='1';
                    }                    
                    _('target_student_skipped').value = '1';
                }
                chk_inputs();
                return false">
                <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                    Yes
                </div>
            </a>

            <a href="#" style="text-decoration:none;" 
                onclick="student_msg_loc.conf.value='';
                _('conf_box_loc').style.display='none';
                _('smke_screen_2').style.display='none';
                _('smke_screen_2').style.zIndex='-1';
                _('target_student_skipped').value == '0';
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
	<div id="rtlft_std" style="position:relative; overflow:scroll; overflow-x: hidden;">
		<!-- InstanceBeginEditable name="EditRegion6" -->
		<div class="innercont_top">Manage student notice board</div>
        <form action="send_message_to_student" method="post" name="student_msg_loc" id="student_msg_loc" enctype="multipart/form-data">
            <input name="save_cf" id="save_cf" type="hidden" value="-1" />
            <input name="tabno" id="tabno" type="hidden" 
                value="<?php if (isset($_REQUEST['tabno'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
            <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
            <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
            
            <input name="get_msg_detail" id="get_msg_detail" type="hidden" />
            
            <input name="loc_what" id="loc_what" type="hidden" value="<?php if (isset($_REQUEST['loc_what'])){echo $_REQUEST['loc_what'];}?>" />
            <input name="target_student_skipped" id="target_student_skipped" type="hidden" value='0'/>
            
            <input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId_u ?>" />
            <input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdeptId_u ?>" />
            <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u ?>" />
            
            <input name="conf_1" id="conf_1" type="hidden" value="0" />
            <?php frm_vars();?>
            
            <div style="width:10%; height:auto; position:absolute; right:10px; top:30px; border-radius:0px; display:<?php //echo $sho_0;?>"><?php
                if (check_scope2('SPGS', 'SPGS menu') > 0)
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="pg_environ.mm.value=8;pg_environ.sm.value='';pg_environ.submit();return false;">
                        <div class="rtlft_inner_button" style="margin-bottom:5px; width:100%;">
                            SPGS menu
                        </div>
                    </a><?php
                }

                if (check_scope3('Academic registry', 'Send message to students', 'Compose') > 0 ||
                check_scope3('Learner support', 'Send message to students', 'Compose') > 0)
                {
                    if (isset($_REQUEST['loc_what'])&&$_REQUEST['loc_what']=='0')
                    {?>
                        <div id="tabss0_0" class="rtlft_inner_button_dull">
                                Compose
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="student_msg_loc.loc_what.value=0;
                            student_msg_loc.submit();
                            return false">
                            <div id="tabss0" class="rtlft_inner_button" style="width:100%; display:none;">
                                Compose
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="student_msg_loc.loc_what.value=0;
                            student_msg_loc.submit();
                            return false">
                            <div id="tabss0" class="rtlft_inner_button" style="width:100%;">
                                Compose
                            </div>
                        </a><?php
                    }
                }

                if (check_scope3('Academic registry', 'Send message to students', 'Edit') > 0 ||
                check_scope3('Learner support', 'Send message to students', 'Edit') > 0)
                {
                    if (isset($_REQUEST['loc_what'])&&$_REQUEST['loc_what']=='1')
                    {?>
                        <div id="tabss1_0" class="rtlft_inner_button_dull">
                                Edit
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="student_msg_loc.loc_what.value=1;
                            student_msg_loc.submit();
                            return false">
                            <div id="tabss1" class="rtlft_inner_button" style="width:100%; display:none;">
                                Edit
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="student_msg_loc.loc_what.value=1;
                            student_msg_loc.submit();
                            return false">
                            <div id="tabss1" class="rtlft_inner_button" style="width:100%;">
                                Edit
                            </div>
                        </a><?php
                    }
                }
                
                if (check_scope3('Academic registry', 'Send message to students', 'Delete') > 0 ||
                check_scope3('Learner support', 'Send message to students', 'Delete') > 0)
                {
                    if (isset($_REQUEST['loc_what'])&&$_REQUEST['loc_what']=='2')
                    {?>
                        <div id="tabss2_0" class="rtlft_inner_button_dull">
                                Delete
                        </div>

                        <a href="#" style="text-decoration:none;" 
                            onclick="student_msg_loc.loc_what.value=2;
                            student_msg_loc.submit();
                            return false">
                            <div id="tabss2" class="rtlft_inner_button" style="width:100%; display:none;">
                                Delete
                            </div>
                        </a><?php
                    }else
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="student_msg_loc.loc_what.value=2;
                            student_msg_loc.submit();
                            return false">
                            <div id="tabss2" class="rtlft_inner_button" style="width:100%;">
                                Delete
                            </div>
                        </a><?php
                    }
                }?>
            </div>
            
            <div class="innercont_stff" style="height:auto; margin-top:0px;">
                <div id="msg_prv_div" class="innercont_stff" style="margin-top:0px; margin-bottom:20px;">
                    <label for="msg_prv" class="labell" style="width:150px">Previous messages</label>
                    <div class="div_select" style="width:500px;">                        
                        <select name="msg_prv" id="msg_prv" class="select" style="width:97.6%" onchange="fetch_msg_detail()">
                            <option value="" selected="selected"></option><?php
                            $sql1 = "SELECT msg_subject FROM student_notice_board WHERE vApplicationNo = '".$_REQUEST["vApplicationNo"]."' ORDER BY msg_subject";
                            $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
                            while ($table= mysqli_fetch_array($rsql1))
                            {?>
                                <option value="<?php echo $table[0] ?>">
                                    <?php echo $table[0];?>
                                </option><?php
                            }
                            mysqli_close(link_connect_db());?>
                        </select>
                    </div>
                    <div id="labell_msg1" class="labell_msg blink_text orange_msg"></div>
                    <hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.8px; margin:15px" />
                </div>
                
                <div id="msg_target_std_div" class="innercont_stff"  style="padding:10px; width:87%; height:auto; margin-top:10px; display:<?Php if (!isset($_REQUEST['loc_what']) || (isset($_REQUEST['loc_what'])&&$_REQUEST['loc_what']<>'0')){echo 'none';}else{echo 'block';}?>;">
					<fieldset style="border-radius:3px; width:100%; float:left;">
						<legend>Target students<b><?php if ($mm == 8){echo ' (Postgraduates only)';}else{echo ' (Undergraduates only)';}?></b></legend><?php
                        if ($sRoleID_u == 6 || $sRoleID_u == 10 || $sRoleID_u == 28)
                        {?>
                            <div class="innercont_stff">
                                <label for="all_student" class="labell_structure" style="width:130px">All students</label>
                                <div class="div_select" style="height:auto;">
                                    <input name="all_student" id="all_student" type="checkbox" style="margin-top:4px; margin-left:0px" 
                                        onclick="if (this.checked)
                                        {
                                            _('msg_faculty').disabled = true;
                                            _('msg_dept').disabled = true;
                                            _('msg_programe').disabled = true;
                                            
                                            //_('all_ug_student').disabled = true;
                                            //_('all_pg_student').disabled = true;
                                        } else 
                                        {
                                            _('msg_faculty').disabled = false;
                                            _('msg_dept').disabled = false;
                                            _('msg_programe').disabled = false;
                                            
                                            //_('all_ug_student').disabled = false;
                                            //_('all_pg_student').disabled = false;
                                        }" />
                                </div>
                            </div><?php
                        }?>

                        <!-- <div class="innercont_stff">
                            <label for="all_ug_student" class="labell_structure" style="width:130px">All undergradaute students</label>
                            <div class="div_select" style="height:auto;">
                                <input name="all_ug_student" id="all_ug_student" type="checkbox" style="margin-top:4px; margin-left:0px" 
                                    onclick="if (this.checked)
                                    {
                                        _('msg_faculty').disabled = true;
                                        _('msg_dept').disabled = true;
                                        _('msg_programe').disabled = true;
                                        
                                        _('all_student').disabled = true;
                                        _('all_pg_student').disabled = true;
                                    } else 
                                    {
                                        _('msg_faculty').disabled = false;
                                        _('msg_dept').disabled = false;
                                        _('msg_programe').disabled = false;
                                        
                                        _('all_student').disabled = false;
                                        _('all_pg_student').disabled = false;
                                    }" />
                            </div>
                        </div>
                        <div class="innercont_stff">
                            <label for="all_pg_student" class="labell_structure" style="width:130px">All postgraduate students</label>
                            <div class="div_select" style="height:auto;">
                                <input name="all_pg_student" id="all_pg_student" type="checkbox" style="margin-top:4px; margin-left:0px" 
                                    onclick="if (this.checked)
                                    {
                                        _('msg_faculty').disabled = true;
                                        _('msg_dept').disabled = true;
                                        _('msg_programe').disabled = true;
                                        
                                        _('all_student').disabled = true;
                                        _('all_ug_student').disabled = true;
                                    } else 
                                    {
                                        _('msg_faculty').disabled = false;
                                        _('msg_dept').disabled = false;
                                        _('msg_programe').disabled = false;
                                        
                                        _('all_student').disabled = false;
                                        _('all_ug_student').disabled = false;
                                    }" />
                            </div>
                        </div> -->
                        
                        <div id="msg_faculty_div" class="innercont_stff">
                            <label for="msg_faculty" class="labell_structure" style="width:130px">Faculty</label>
                            <div class="div_select" style="width:28%;">
                                <select name="msg_faculty" id="msg_faculty" class="select" 
                                    onchange="/*if (!(student_msg_loc.userInfo_f.value==this.value||_('sRoleID').value==6||_('sRoleID').value==19||_('sRoleID').value==10||_('sRoleID').value==22||_('sRoleID').value==24))
                                    {*/
                                        _('msg_dept').length = 0;
                                        _('msg_dept').options[_('msg_dept').options.length] = new Option('', '');
                                                
                                        _('msg_programe').length = 0;
                                        _('msg_programe').options[_('msg_programe').options.length] = new Option('', '');
                                                
                                        update_cat_country('msg_faculty', 'cdeptId_readup', 'msg_dept', 'msg_programe');

                                        _('warned1').value='0'; 
                                        _('sub_box_0').style.display='block'; 
                                        _('sub_box_1').style.display='none';
                                    /*}else
                                    {
                                        setMsgBox('labell_msg2','You can only work in your own faculty');
                                        this.value='';
                                        this.focus();
                                    }*/">
                                    <option value="" selected="selected">Select faculty</option><?php
                                    $sql1 = "SELECT cFacultyId, vFacultyDesc vFacultyDesc FROM faculty WHERE cCat = 'A' AND cDelFlag = 'N' ORDER BY vFacultyDesc";
                                    $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
                                    while ($table= mysqli_fetch_array($rsql1))
                                    {?>
                                        <option value="<?php echo $table[0] ?>" <?php 
                                            if ($sRoleID_u == '6')
                                            {
                                                if ($cFacultyId_u == $table[0]){echo ' selected';}
                                            }?>>
                                            <?php echo $table[1];?>
                                        </option><?php
                                    }
                                    mysqli_close(link_connect_db());?>
                                </select>
                            </div>
                            <div id="labell_msg2" class="labell_msg blink_text orange_msg"></div>
                        </div>
                        
                        <div id="msg_dept_div" class="innercont_stff">
                            <label for="msg_dept" class="labell_structure" style="width:130px">Department</label>
                            <div class="div_select" style="width:28%;">
                                <select name="msg_dept" id="msg_dept" class="select" 
                                    onchange="/*if(student_msg_loc.userInfo_d.value==this.value||_('sRoleID').value==6||_('sRoleID').value==10||_('sRoleID').value==22||_('sRoleID').value==26)
                                    {*/
                                        _('msg_programe').length = 0;
                                        _('msg_programe').options[_('msg_programe').options.length] = new Option('', '');

                                        update_cat_country('msg_dept', 'cprogrammeId_readup', 'msg_programe', 'ccourseIdold');
                                        _('warned1').value='0'; 
                                        _('sub_box_0').style.display='block'; 
                                        _('sub_box_1').style.display='none';
                                    /*}else
                                    {
                                        setMsgBox('labell_msg3','You can only work in your own department');
                                        this.value='';
                                        this.focus();
                                    }*/">
                                    <option value="" selected="selected"></option><?php
                                    if (isset($_REQUEST['msg_faculty']) && $_REQUEST['msg_faculty'] <> '')
                                    {
                                        $msg_faculty = $_REQUEST['msg_faculty'];
                                    }else if (isset($cFacultyId_u))
                                    {
                                        $msg_faculty = $cFacultyId_u;
                                    }
                                    
                                    $stmt = $mysqli->prepare("select cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where cFacultyId = ? order by vdeptDesc");
                                    $stmt->bind_param("s", $msg_faculty);
                                    $stmt->execute();
                                    $stmt->store_result();
                                    $stmt->bind_result($cdeptId1, $vdeptDesc1);
                                    
                                    while ($stmt->fetch())
                                    {?>
                                        <option value="<?php echo $cdeptId1; ?>"<?php 
                                        if ($sRoleID_u == '6')
                                        {
                                            if ($cdeptId_u == $cdeptId1){echo ' selected';}
                                        }?>>
                                            <?php echo $vdeptDesc1;?>
                                        </option><?php
                                    }
                                    $stmt->close();?>
                                </select>
                            </div>
                            <div id="labell_msg3" class="labell_msg blink_text orange_msg"></div>
                        </div>
                        
                        <div id="msg_programe_div" class="innercont_stff">
                            <label for="msg_programe" class="labell_structure" style="width:130px">Programme</label>
                            <div class="div_select" style="width:28%;">
                                <select name="msg_programe" id="msg_programe" class="select" 
                                    onchange="if(this.value!='')
                                    {
                                        _('msg_level').length = 0;
                                        _('msg_level').options[_('msg_level').options.length] = new Option('Select level', '');

                                        if (this.options[this.selectedIndex].text.substr(0,3) == 'PGD')
                                        {
                                            _('msg_level').options[_('msg_level').options.length] = new Option(700, 700);
                                            _('msg_level').value=700;
                                        }else if (this.options[this.selectedIndex].text.substr(0,1) == 'M')
                                        {
                                            _('msg_level').options[_('msg_level').options.length] = new Option(800, 800);
                                            _('msg_level').value=800;
                                        }else if (this.options[this.selectedIndex].text.substr(0,1) == 'B')
                                        {
                                            cnt1 = 100;
                                            cnt2 = 300;

                                            if (this.value.substr(0,4) == 'EDU2' || this.value.substr(0,4) == 'ART2')
                                            {
                                                cnt1 = 100;
                                                cnt2 = 200;
                                            }else if (_('msg_faculty').value == 'HSC')
                                            {
                                                cnt1 = 200;
                                                cnt2 = 300;
                                                if (this.value == 'HSC201')
                                                {
                                                    cnt1 = 200;
                                                    cnt2 = 200;
                                                }
                                            }else if (_('msg_faculty').value == 'MSC')
                                            {
                                                if (this.value == 'MSC207')
                                                {
                                                    cnt1 = 100;
                                                    cnt2 = 200;
                                                }                                                    
                                            }else if (_('msg_faculty').value == 'SCI')
                                            {
                                                if (this.value == 'SCI204' || this.value == 'SCI207' || this.value == 'SCI210')
                                                {
                                                    cnt1 = 100;
                                                    cnt2 = 200;
                                                }
                                            }else if (_('msg_faculty').value == 'SSC')
                                            {
                                                if (this.value == 'SSC205' || this.value == 'SSC206')
                                                {
                                                    cnt1 = 100;
                                                    cnt2 = 200;
                                                }
                                            }

                                            for (cnt = cnt1; cnt <= cnt2; cnt+=100)
                                            {
                                                _('msg_level').options[_('msg_level').options.length] = new Option(cnt, cnt);
                                            }

                                            _('msg_level').value=100;
                                        }else if (this.options[this.selectedIndex].text.substr(0,3) == 'Phi')
                                        {
                                            _('msg_level').options[_('msg_level').options.length] = new Option(900, 900);
                                            _('msg_level').value=900;
                                        }else
                                        {
                                            _('msg_level').options[_('msg_level').options.length] = new Option(1000, 1000);
                                            _('msg_level').value=1000;
                                        }
                                        _('warned1').value='0'; _('sub_box_0').style.display='block'; _('sub_box_1').style.display='none';
                                        sets.level_options.value = this.options[this.selectedIndex].text.substr(0,3);
                                    }">
                                    <option value="" selected="selected"></option><?php
                                    if (isset($_REQUEST['msg_dept']) && $_REQUEST['msg_dept'] <> '')
                                    {
                                        $msg_dept = $_REQUEST['msg_dept'];
                                    }else if (isset($cdeptId_u))
                                    {
                                        $msg_dept = $cdeptId_u;
                                    }
                                    
                                    $stmt = $mysqli->prepare("select p.cProgrammeId, p.vProgrammeDesc, o.vObtQualTitle 
                                    from programme p, obtainablequal o, depts s
                                    where p.cObtQualId = o.cObtQualId 
                                    and s.cdeptId = p.cdeptId
                                    and p.cDelFlag = s.cDelFlag
                                    and p.cDelFlag = 'N'
                                    and p.cdeptId = ?
                                    order by s.cdeptId, p.cProgrammeId");
                                    $stmt->bind_param("s", $msg_dept);
                                    $stmt->execute();
                                    $stmt->store_result();
                                    $stmt->bind_result($cProgrammeId_student, $vProgrammeDesc_student, $vObtQualTitle_student);

                                    while ($stmt->fetch())
                                    {?>
                                        <option value="<?php echo $cProgrammeId_student?>"<?php 
                                        if ($sRoleID_u == '6')
                                        {
                                            if ($cProgrammeId_u == $cProgrammeId_student){echo ' selected';}
                                        }?>><?php echo $vObtQualTitle_student.' '.$vProgrammeDesc_student; ?></option><?php
                                    }
                                    $stmt->close();?>
                                </select>
                                <input name="level_options" id="level_options" type="hidden" value="<?php if (isset($_REQUEST["level_options"]) && $_REQUEST["level_options"] <> ''){echo $_REQUEST["level_options"];}?>" />
                            </div>
                            <div id="labell_msg4" class="labell_msg blink_text orange_msg"></div>
                        </div>
                        
                        <div id="msg_level_div" class="innercont_stff">
                            <label for="msg_level" class="labell_structure" style="width:130px">Entry level</label>
                            <div class="div_select" style="width:28%;">
                                <select name="msg_level" id="msg_level" class="select" style="width:auto" 
                                    onchange="prns_form.courseLevel.value=this.value; 
                                    _('sub_box_0').style.display='block'; 
                                    _('sub_box_1').style.display='none';
                                        
                                    sets.save.value='1';
                                    chk_inputs();">
                                    <option value="" selected="selected"></option><?php
                                    for ($t = 100; $t <= 1000; $t+=100)
                                    {
                                        if ($mm == 8 && $t < 700){continue;}?>
                                        <option value="<?php echo $t ?>" <?php if (isset($_REQUEST['msg_level']) && $_REQUEST['msg_level'] == $t){echo ' selected';} ?>><?php echo $t;?></option><?php
                                    }?>
                                </select>
                            </div>
                            <div id="labell_msg5" class="labell_msg blink_text orange_msg"></div>
                        </div>                    
                    </fieldset>
                </div>

                <div id="msg_subject_div" class="innercont_stff" style="margin-top:10px; display:<?Php if (!isset($_REQUEST['loc_what']) || (isset($_REQUEST['loc_what'])&&$_REQUEST['loc_what']<>'0')){echo 'none';}else{echo 'block';}?>">
                    <label for="msg_subject" class="labell" style="width:150px">Subject</label>
                    <div class="div_select" style="width:500px;">
                        <input name="msg_subject" id="msg_subject" type="text" class="textbox" 
                            style="text-transform:none;"
                            onChange="this.value=this.value.trim()" 
                            placeholder="Maximum of 10 words"/>
                    </div>
                    <div id="labell_msg6" class="labell_msg blink_text orange_msg"></div>
                </div>

                
                <input name="existing_msg_subject" id="existing_msg_subject" type="hidden" />
                <div id="succ_box_inbtwn" class="succ_box blink_text orange_msg" style="margin-top:7px; margin-bottom:7px; margin-left:157px; width:auto; height:auto;"></div>
                
                <div id="msg_body_div" class="innercont_stff" style="margin-top:10px; height:auto; display:<?Php if (!isset($_REQUEST['loc_what']) || (isset($_REQUEST['loc_what'])&&$_REQUEST['loc_what']<>'0')){echo 'none';}else{echo 'block';}?>">
                    <label for="msg_body" class="labell" style="width:150px">Message</label>
                    <div class="div_select" style="height:150px; width:500px;">
                        <textarea style="width:96.5%; height:93%;" name="msg_body" id="msg_body" placeholder="Maximum of 80 words"
                            onChange="this.value=this.value.trim()"></textarea>
                    </div>
                    <div id="labell_msg7" class="labell_msg blink_text orange_msg"></div>
                </div>
                
                <div id="msg_sign_div" class="innercont_stff" style="height:50px; display:<?Php if (!isset($_REQUEST['loc_what']) || (isset($_REQUEST['loc_what'])&&$_REQUEST['loc_what']<>'0')){echo 'none';}else{echo 'block';}?>">
                    <label for="msg_sign" class="labell" style="width:150px">Signature</label>
                    <div class="div_select" style="height:150px; width:500px;">
                        <textarea maxlength="80"
                        style="width:96.5%; height:30%" name="msg_sign" id="msg_sign"></textarea>
                    </div>
                    <div id="labell_msg8" class="labell_msg blink_text orange_msg"></div>
                </div>
                
                <div id="msg_show_div" class="innercont_stff" style="height:50px; display:<?Php if (!isset($_REQUEST['loc_what']) || (isset($_REQUEST['loc_what'])&&$_REQUEST['loc_what']<>'0')){echo 'none';}else{echo 'block';}?>">
                    <label for="msg_loc" class="labell" style="width:150px">Show message on</label>
                    <div class="div_select" style="width:500px;">                        
                        <select name="msg_loc" id="msg_loc" class="select" style="width:97.6%">
                            <option value="" selected="selected"></option>
                            <option value="1">General home page</option>
                            <option value="2">Student home page</option>
                        </select>
                    </div>
                    <div id="labell_msg10" class="labell_msg blink_text orange_msg"></div>
                </div>
                 
                <div id="date_msg_div" class="innercont_stff" style="margin-top:10px; display:<?Php if (!isset($_REQUEST['loc_what']) || (isset($_REQUEST['loc_what'])&&$_REQUEST['loc_what']<>'0')){echo 'none';}else{echo 'block';}?>">
                    <label class="labell" style="width:150px;">Message expires on</label>
                    <div class="div_select" style="width:500px;"><?php
                        //date_default_timezone_set('Africa/Lagos');
                        $current_date = date("Y-m-d");?>
                        <input type="date" name="date_msg1" id="date_msg1" class="textbox" style="height:99%; width:99%"
                            onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
                        <input name="current_date" id="current_date" type="hidden" value="<?php echo $current_date;?>"/>
                    </div>
                    <div id="labell_msg9" class="labell_msg blink_text orange_msg" style="width:355px;"></div>
                </div>
            </div>
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
                
				<?php //side_detail($_REQUEST['uvApplicationNo']);?>
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