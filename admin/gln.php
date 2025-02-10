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
		
		if ((_('id_no').value == 0 || _('id_no').value == 2) && _("uvApplicationNo04").value == '' && !_('uvApplicationNo04').disabled)
		{
			if (_('id_no').value == 2)
            {
                setMsgBox("labell_msg0","Either of the two input boxes must be filled");
            }else
            {
                setMsgBox("labell_msg0","");
            }
			_("uvApplicationNo04").focus();
		}/*else if (_('id_no').value == 2 && _('cFacultyId04').value == '')
		{
			setMsgBox("labell_msg1","");
			_("cFacultyId04").focus();
		}else if (_('id_no').value == 2 && _('afn_list').value == '' && !_('afn_list').disabled)
		{
			setMsgBox("labell_msg2","");
			_("afn_list").focus();
		}*/else
		{
			var formdata = new FormData();
            
			//formdata.append("currency", _("currency").value);
			formdata.append("user_cat", _("user_cat").value);
			//formdata.append("save",_('gln1').save.value);
			formdata.append("ilin",_('gln1').ilin.value);
			formdata.append("uvApplicationNo", _('uvApplicationNo04').value);
			formdata.append("id_no", _('id_no').value);
            formdata.append("ilevelold", _('ilevelold').value);
            
			if (_('id_no').value == 2)
			{
				
				if (!_('uvApplicationNo04').disabled)
                {
                    formdata.append("uvApplicationNo04", _("uvApplicationNo04").value);
                }/*else if (!_('afn_list').disabled)
                {
                    formdata.append("afn_list", _("afn_list").value);
                }
                
                formdata.append("cFacultyId", _("cFacultyId04").value);
				if(_('gln1').save.value == 1)
				{
					if (_('count_rec_q'))
					{
						for (x = 1; x <= _('count_rec_q').value; x++)
						{
							apllicant = 'apllicant'+x;
							if (_(apllicant) && _(apllicant).checked)
							{
								formdata.append(apllicant, _(apllicant).value);
							}
						}
						formdata.append('count_rec_q', _('count_rec_q').value);
					}

					if (_('count_rec_nq'))
					{
						for (x = 1; x <= _('count_rec_nq').value; x++)
						{
							apllicant = 'apllicant_0'+x;
							if (_(apllicant) && _(apllicant).checked)
							{
							formdata.append(apllicant, _(apllicant).value);
							}
						}
						formdata.append('count_rec_nq', _('count_rec_nq').value);
					}
				}*/
			}
			opr_prep(ajax = new XMLHttpRequest(),formdata);
		}
	}
	
	
	function opr_prep(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_gln.php");
		ajax.send(formdata);
	}
	
	
	function completeHandler(event)
	{
        on_error('0');
        on_abort('0');
        in_progress('0');
        
        var returnStr = event.target.responseText;
        
        _("smke_screen_2").style.zIndex = '-1';
		_("smke_screen_2").style.display = 'none';
		
        _("status_info_box").style.zIndex = '-1';
		_("status_info_box").style.display = 'none';

		if (!(_('count_rec_q') || _('count_rec_nq')))
		{
			if (_("screen_list"))
			{
				_("screen_list").style.display = 'none';
			}
			if (_("screen_list_0"))
			{
				_("screen_list_0").style.display = 'none';
			}
		}
        
		if (_("loadcred").value == 1)
		{
			if (returnStr.indexOf("not uploaded") == -1)
			{
				_("container_cover_in").style.zIndex = 1;
				_("container_cover_in").style.display = 'block';
                if (_('fil_ex').value == 'g')
                {
				    _("credential_img").src = returnStr;
                }

				_("imgClose").focus();
				_("loadcred").value = 0;
			}
			_("loadcred").value = 0;
		}else if (returnStr == '' && _('id_no').value != 2)
		{
			_("gln1").submit();
		}else if (_('id_no').value != 2)
		{
			setMsgBox("labell_msg0", returnStr);
			_("qual_list").style.display = 'none';
			_("adm_status").style.display = 'none';			
		}else if (_('id_no').value == 2)
		{
            if (returnStr.indexOf("successful") != -1)
            {
                success_box(returnStr);
            }else
            {
                caution_box(returnedStr);
            }
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
	
	
	
    function call_image()
    {
        var formdata = new FormData();
        
        _("loadcred").value = 1;
        
        formdata.append("loadcred",_("loadcred").value);
        formdata.append("currency", _("currency").value);
        formdata.append("user_cat", _("user_cat").value);
        
        formdata.append("vApplicationNo", _("uvApplicationNo04").value);
        formdata.append("vExamNo", _("vExamNo").value);
        formdata.append("cQualCodeId", gln1.cQualCodeId.value);
        
        opr_prep_img(ajax = new XMLHttpRequest(),formdata);
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

    function checkAll(val)
    {
        var cusStatus = '';

        if (event.ctrlKey){var cusStatus = 'C';}else if (event.altKey){var cusStatus = 'R';}else{var cusStatus = 'E';}

        if (cusStatus != 'C')
        {
            for (x = 1; x <= _('count_rec_q').value; x++)
            {
                apllicant = 'apllicant'+x;
                if (val == 0)
                {
                    _(apllicant).checked = false;
                }else if (val == 1)
                {
                    _(apllicant).checked = true;
                }
            }
        }

        for (x = 1; x <= _('count_rec_nq').value; x++)
        {
            apllicant = 'apllicant_0'+x;
            if (val == 0)
            {
                _(apllicant).checked = false;
            }else if (val == 1)
            {
                _(apllicant).checked = true;
            }
        }
    }
    
    //window.resizeTo(screen.availWidth, screen.availHeight)
	//window.moveTo(0,0)
</script><?php

require_once ('set_scheduled_dates.php');
require_once('staff_detail.php');?>
<!-- InstanceEndEditable -->
</head>
<body onLoad="checkConnection()">
    <?php admin_frms(); $has_matno = 0;

    $stmt = $mysqli->prepare("SELECT f_type FROM pics WHERE cinfo_type = 'C' AND vApplicationNo = ? LIMIT 1");
    $stmt->bind_param("s",$_REQUEST["uvApplicationNo04"]);
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
		<input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
		
        <input name="mm" id="mm" type="hidden" value="<?php if (isset($_REQUEST["mm"])){echo $_REQUEST["mm"];} ?>" />
        <input name="mm_desc" id="mm_desc" type="hidden" value="<?php if (isset($_REQUEST["mm_desc"])){echo $_REQUEST["mm_desc"];} ?>" />
        <input name="sm" id="sm" type="hidden" value="<?php if (isset($_REQUEST["sm"])){echo $_REQUEST["sm"];} ?>" />
        <input name="sm_desc" id="sm_desc" type="hidden" value="<?php if (isset($_REQUEST["sm_desc"])){echo $_REQUEST["sm_desc"];} ?>" />
                
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
							style="color:#666666; margin-right:3px; text-decoration:none;text-shadow: 0 1px 0 #fafafa;">
						    <img style="width:15px; height:15px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" />
						</a>
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
			
		<form action="preview-form" method="post" target="_blank" name="m_frm" id="m_frm" enctype="multipart/form-data">
			<input name="uvApplicationNo" id="uvApplicationNo" type="hidden"  value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];}; ?>" />
			<input name="vApplicationNo" id="vApplicationNo" type="hidden"  value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>"  />
			<input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />	
			<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
			<input name="see_frm" id="see_frm" type="hidden" value="1" />
			<input name="sideMenu" id="sideMenu" type="hidden" value="3" />
			<input name="save_cf" id="save_cf" type="hidden" value="-1" />
			<input name="conf" id="conf" type="hidden" value="" />
			<input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
							
			<input name="internalchk" id="internalchk" type="hidden" value="1" />
			<!--<input name="study_mode_ID" id="study_mode_ID" type="hidden" value="odl" />

			<input name="study_mode" id="study_mode" type="hidden" value="odl" />-->	

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
            
            <input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php if (isset($cFacultyId_u)){echo $cFacultyId_u;} ?>" />
            <input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php if (isset($cdeptId_u)){echo $cdeptId_u;} ?>" />
            <input name="NumOfCritQual" id="NumOfCritQual" type="hidden" value="" />
            <input name="frm_upd_loc" id="frm_upd_loc" type="hidden" />
            <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u;?>" />
            
            <div class="innercont_top"><?php
                if (isset($_REQUEST["id_no"]))
                {
                    if ($_REQUEST["id_no"] == 0)
                    {
                        echo 'Verify admission';
                    }else if ($_REQUEST["id_no"] == 1)
                    {
                        echo 'Screen for admission';
                    }else if ($_REQUEST["id_no"] == 2)
                    {
                        echo 'Invitation for interview';
                    }
                }else
                {
                    echo 'Verify/screen admission';
                }?>
            </div>
           
            <form action="verify-admission" method="post" name="gln1" id="gln1" enctype="multipart/form-data">
                <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                <input name="save" id="save" type="hidden" value="-1" />
                <input name="qualified_list_arr" id="qualified_list_arr" type="hidden" />
                <input name="not_qualified_list_arr" id="not_qualified_list_arr" type="hidden" />
                
                <input name="id_no" id="id_no" type="hidden" value="<?php if(isset($_REQUEST['id_no'])){echo $_REQUEST['id_no'];} ?>" />
                <input name="fil_ex" id="fil_ex" type="hidden" value="<?php echo $f_type; ?>" />

                <?php frm_vars();

                $num_valid = 1;
                $msg = '';
                $cEduCtgId_01 = '';
                if (isset($_REQUEST["uvApplicationNo04"]))
                {
                    $stmt = $mysqli->prepare("select cEduCtgId, cProgrammeId from prog_choice where vApplicationNo = ?");
                    $stmt->bind_param("s",$_REQUEST["uvApplicationNo04"]);
                    $stmt->execute();
                    $stmt->store_result();
                    if ($stmt->num_rows == 0)
                    {
                        $stmt->close();
                        $num_valid = 0;
                    }else
                    {
                        $stmt->bind_result($cEduCtgId_01, $cProgrammeId);
                        $stmt->fetch();
                        $stmt->close();
                    }

                    $user_client_dept = match_user_client_dept($cdeptId_u, $_REQUEST["uvApplicationNo04"]);

                    if ($mm == 0 && $user_client_dept == 0 && $sRoleID_u <> 6 && $_REQUEST['vApplicationNo'] <> '05158')
                    {
                        $num_valid = -1;
                        information_box('Application not accessible. Applicant is not in your department');
                    }
                    
                    if ($_REQUEST['mm'] == 8 && $cEduCtgId_01 <> 'PGZ' && $cEduCtgId_01 <> 'PRX' && $cProgrammeId <> 'MSC415' && $cProgrammeId <> 'MSC416')
                    {
                        $num_valid = -1;
                        information_box('Application form number must be that of a postgraduate candidate');
                    }else if (($_REQUEST['mm'] == 0 || $_REQUEST['mm'] == 1) && ($cEduCtgId_01 == 'PGZ' || $cEduCtgId_01 == 'PRX' || $cProgrammeId == 'MSC515' || $cProgrammeId == 'MSC516'))
                    {
                        $num_valid = -1;
                        information_box('Application form number must be that of an undergraduate candidate');
                    }
                }?>

                <div style="width:15%; height:auto; position:absolute; right:10px; border-radius:0px;"><?php
                    if (check_scope2('SPGS', 'SPGS menu') > 0)
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="pg_environ.mm.value=8;pg_environ.sm.value='';pg_environ.submit();return false;">
                            <div class="rtlft_inner_button" style="margin-bottom:5px; border-bottom:1px dashed #ccc;  border-top:1px dashed #ccc;width:100%;">
                                SPGS menu
                            </div>
                        </a><?php
                    }

                    if (check_scope3('Faculty', 'Admission', 'Verify admission') > 0)
                    {
                        if ($num_valid == 1 && isset($_REQUEST['id_no'])&&$_REQUEST['id_no']=='0')
                        {?>
                            <div class="rtlft_inner_button_dull">
                                Verify
                            </div><?php
                        }else
                        {?>
                            <a href="#" style="text-decoration:none;" 
                                onclick="if(_('uvApplicationNo04').value.trim()!='')
                                {
                                    _('gln1').qualified_h.value=''; 
                                    _('gln1').id_no.value='0';
                                    _('gln1').submit();
                                }else
                                {
                                    setMsgBox('labell_msg0', '');
                                }return false;">
                                <div class="rtlft_inner_button" style="width:100%; border-bottom:1px dashed #ccc;">
                                    Verify
                                </div>
                            </a><?php
                        }
                    }

                        
                    if (check_scope3('Faculty', 'Admission', 'Screen for admission') > 0)
                    {
                        if ($num_valid == 1 && isset($_REQUEST['id_no'])&&$_REQUEST['id_no']=='1')
                        {?>
                            <div class="rtlft_inner_button_dull">
                                    Screen
                            </div><?php
                        }else
                        {?>
                            <a href="#" style="text-decoration:none;" 
                                onclick="if(_('uvApplicationNo04').value.trim()!='')
                                {
                                    _('gln1').qualified_h.value='';
                                    _('gln1').id_no.value='1';
                                    _('gln1').submit();
                                }else
                                {
                                    setMsgBox('labell_msg0', '');
                                }return false">
                                <div class="rtlft_inner_button" style="width:100%; border-bottom:1px dashed #ccc;">
                                    Screen
                                </div>
                            </a><?php
                        }
                    }

                        
                    if (check_scope3('SPGS', 'Admission', 'Invite for interview') > 0 && ($cProgrammeId == 'MSC415' || $cProgrammeId == 'MSC416'))
                    {
                        if ($num_valid == 1 && isset($_REQUEST['id_no'])&&$_REQUEST['id_no']=='2')
                        {?>
                            <div class="rtlft_inner_button_dull">
                                    Invite for interview
                            </div><?php
                        }else
                        {?>
                            <a href="#" style="text-decoration:none;" 
                                onclick="_('gln1').qualified_h.value='';
                                    _('gln1').id_no.value='2';
                                    _('gln1').submit(); return false">
                                <div class="rtlft_inner_button" style="width:100%; border-bottom:1px dashed #ccc;">
                                    Invite for interview
                                </div>
                            </a><?php
                        }
                    }?>
                </div>

                <div id="uvApplicationNo04_div" class="innercont_stff">
                    <div class="div_select" style="	width:465px; background:#fff">
                        <input name="uvApplicationNo04" id="uvApplicationNo04" type="number" class="textbox" 
                            onchange="_('cFacultyIdold_div').style.display='none'; 
                            _('cdeptold_div').style.display='none'; 
                            _('cprogrammeIdold_div').style.display='none';"
                            style="text-transform:none; width:48%;" 
                            placeholder="Enter application form number here"
                            onkeypress="if(this.value.length==8){return false}" required
                            value="<?php if(isset($_REQUEST['uvApplicationNo04']) && isset($_REQUEST['id_no']) && $_REQUEST['id_no'] <> '2')
                            {
                                echo $_REQUEST['uvApplicationNo04'];
                            }?>"/>
                    </div><?php 
                    
                    if (isset($_REQUEST['qualified_h']) && $_REQUEST['qualified_h'] <> '')
                    {?>
                        <div id="labell_msg0" class="labell_msg blink_text green_msg" style="display:block"><?php
                            if (isset($_REQUEST['qualified_h']) && $_REQUEST['qualified_h'] <> '')
                            {
                                echo 'Success';
                            }?>
                        </div><?php
                    }else if ($num_valid == 0)
                    {?>
                        <div id="labell_msg0" class="labell_msg blink_text orange_msg" style="display:block">
                            Invalid application form number
                        </div><?php
                    }else
                    {?>
                        <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div><?php
                    }?>
                </div>
               
                <input name="vExamNo" id="vExamNo" type="hidden" />
                <input name="loadcred" id="loadcred" type="hidden" />

                <input name="qualified_h" id="qualified_h" type="hidden" 
                    value="<?php if (isset($_REQUEST['qualified_h'])){echo $_REQUEST['qualified_h'];}else{echo '';}?>"/>
            
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
                    from programme p, obtainablequal o, depts s
                    where p.cObtQualId = o.cObtQualId 
                    and s.cdeptId = p.cdeptId
                    and p.cDelFlag = s.cDelFlag
                    and p.cDelFlag = 'N'
                    order by s.cdeptId, p.cProgrammeId";
                    $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                    while ($rs = mysqli_fetch_array($rssql))
                    {
                        $vProgrammeDesc_01 = $rs['vProgrammeDesc'];
                        if (!is_bool(strpos($rs['vProgrammeDesc'],"(d)")))
                        {
                            $vProgrammeDesc_01 = substr($rs['vProgrammeDesc'], 0, strlen($rs['vProgrammeDesc'])-4);
                        }?>
                        <option value="<?php echo $rs['cdeptId']. $rs['cProgrammeId']?>"><?php echo str_pad($rs['vObtQualTitle'], 10, " ", STR_PAD_LEFT).' '.$vProgrammeDesc_01; ?></option><?php
                    }
                    mysqli_close(link_connect_db());?>
                </select>
                    
                <div id="cFacultyIdold_div" class="setup_fac_dummy_lass innercont_stff" style="margin-top:0.5%; 
                    display:<?php if (isset($_REQUEST["id_no"]) && $_REQUEST["id_no"] == '1')
                    {
                        echo 'block';
                    }else
                    {
                        echo 'none';
                    }?>">
                    <div class="div_select">
                        <select name="cFacultyIdold" id="cFacultyIdold" class="select" 
                            onchange="if(!(_('userInfo_f').value==this.value || _('sRoleID').value==6 || _('sRoleID').value==27 || gln1.vApplicationNo.value == '05158'))
                            {
                                setMsgBox('labell_msg15','You can only work in your own faculty');
                                this.value='';
                                this.focus();
                            }else if (this.value!='')
                            {
                                update_cat_country('cFacultyIdold', 'cdeptId_readup', 'cdeptold', 'cprogrammeIdold');
                                _('labell_msg15').style.display='none';
                            }">
                            <option value="" selected="selected">Select a faculty</option><?php
                                $sql1 = "SELECT cFacultyId, concat(cFacultyId,' ',vFacultyDesc) vFacultyDesc FROM faculty WHERE cCat = 'A' AND cDelFlag = 'N' ORDER BY vFacultyDesc";
                                $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
                                while ($table= mysqli_fetch_array($rsql1))
                                {?>
                                    <option value="<?php echo $table[0] ?>"<?php 
                                    if ($sRoleID_u <> '6' && $table[0] == $cFacultyId_u)
                                    {
                                        echo ' selected';
                                    }else if ((isset($_REQUEST['cFacultyIdNew_abrv']) && $table[0] == strtoupper($_REQUEST['cFacultyIdNew_abrv'])) || 
                                    (isset($_REQUEST['cFacultyIdold']) && $table[0] == $_REQUEST['cFacultyIdold'])){echo ' selected';}?>>
                                        <?php echo $table[1];?>
                                    </option><?php
                                }
                                mysqli_close(link_connect_db());?>
                        </select>
                        <input name="cFacultyDescNew_h" id="cFacultyDescNew_h" type="hidden" value="<?php if (isset($_REQUEST['cFacultyDescNew_h'])){echo $_REQUEST['cFacultyDescNew_h'];}?>" />
                    </div>
                    <div id="labell_msg15" class="labell_msg blink_text orange_msg"></div>
                </div>
                
                <div id="cdeptold_div" class="setup_fac_dummy_lass innercont_stff" 
                    style="display:<?php if (isset($_REQUEST["id_no"]) && $_REQUEST["id_no"] == '1')
                    {
                        echo 'block';
                    }else
                    {
                        echo 'none';
                    }?>">
                    <div class="div_select">
                        <select name="cdeptold" id="cdeptold" class="select" 
                            onchange="if(_('userInfo_f').value==this.value || _('sRoleID').value==6 || _('sRoleID').value==27  || gln1.vApplicationNo.value == '05158')
                            {
                                update_cat_country('cdeptold', 'cprogrammeId_readup', 'cprogrammeIdold', 'ccourseIdold');
                                _('labell_msg16').style.display='none';
                            }else if (this.value!='')
                            {
                                setMsgBox('labell_msg16','You can only work in your own department');
                                this.value='';
                                this.focus();
                            }">
                            <option value="" selected="selected"></option><?php
                            if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '')
                            {
                                $stmt = $mysqli->prepare("select cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where cFacultyId = ? order by vdeptDesc");
                                $stmt->bind_param("s", $_REQUEST['cFacultyIdold']);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($cdeptId1, $vdeptDesc1);
                                
                                while ($stmt->fetch())
                                {?>
                                    <option value="<?php echo $cdeptId1; ?>"<?php if (isset($_REQUEST['cdeptold']) && $cdeptId1 == $_REQUEST['cdeptold']){echo ' selected';}?>>
                                        <?php echo $vdeptDesc1;?>
                                    </option><?php
                                }
                                //$stmt->close();
                            }?>
                        </select>
                    </div>
                    <div id="labell_msg16" class="labell_msg blink_text orange_msg"></div>
                </div>
                
                <div id="cprogrammeIdold_div" class="setup_fac_dummy_lass innercont_stff" 
                    style="display:<?php if (isset($_REQUEST["id_no"]) && $_REQUEST["id_no"] == '1')
                    {
                        echo 'block';
                    }else
                    {
                        echo 'none';
                    }?>">
                    <div class="div_select">
                    <select name="cprogrammeIdold" id="cprogrammeIdold" class="select"
                            onchange="if (this.value!='')
                            {
                                _('labell_msg17').style.display='none';
                            }">
                        <option value="" selected="selected"></option><?php
                        if (isset($_REQUEST['cdeptold']) && $_REQUEST['cdeptold'] <> '')
                        {
                            $stmt = $mysqli->prepare("select cProgrammeId , concat(vObtQualTitle,' ',vProgrammeDesc) from programme a, obtainablequal b where a.cObtQualId = b.cObtQualId and cdeptId = ? order by cProgrammeId");
                            $stmt->bind_param("s", $_REQUEST['cdeptold']);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($cProgrammeId1, $vProgrammeDesc1);
                            
                            while ($stmt->fetch())
                            {?>
                                <option value="<?php echo $cProgrammeId1?>"<?php if (isset($_REQUEST['cprogrammeIdold']) && $cProgrammeId1 == $_REQUEST['cprogrammeIdold']){echo ' selected';}?>><?php echo $vProgrammeDesc1; ?></option><?php
                            }
                            //$stmt->close();
                        }?>
                    </select>
                    </div>
                    <div id="labell_msg17" class="labell_msg blink_text orange_msg"></div>
                    <input name="cprogrammedescNew_h1" id="cprogrammedescNew_h1" type="hidden" value="<?php if(isset($_REQUEST['cprogrammedescNew_h1'])){echo $_REQUEST['cprogrammedescNew_h1'];} ?>"/>
                </div>

                <div id="ilevelold_div" class="setup_fac_dummy_lass innercont_stff" 
                    style="display:<?php if (isset($_REQUEST["id_no"]) && $_REQUEST["id_no"] == '1')
                    {
                        echo 'block';
                    }else
                    {
                        echo 'none';
                    }?>">
                    <div class="div_select">
                    <select name="ilevelold" id="ilevelold" class="select"
                        onchange="if (this.value!='')
                        {
                            _('labell_msg18').style.display='none';
                        }">
                        <option value="" selected="selected">Select level</option>
                        <option value="10" <?php if (isset($_REQUEST['ilevelold']) && $_REQUEST['ilevelold'] == 10){echo 'selected';}?>>10</option>
                        <option value="20" <?php if (isset($_REQUEST['ilevelold']) && $_REQUEST['ilevelold'] == 20){echo 'selected';}?>>20</option>
                        <option value="30" <?php if (isset($_REQUEST['ilevelold']) && $_REQUEST['ilevelold'] == 30){echo 'selected';}?>>30</option>
                        <option value="40" <?php if (isset($_REQUEST['ilevelold']) && $_REQUEST['ilevelold'] == 40){echo 'selected';}?>>40</option><?php
                        for ($t = 100; $t <= 1000; $t+=100)
                        {?>
                            <option value="<?php echo $t ?>" 
                            <?php if (isset($_REQUEST['ilevelold']) && $_REQUEST['ilevelold'] == $t){echo 'selected';}?>><?php echo $t;?></option><?php
                        }?>
                    </select>
                    </div>
                    <div id="labell_msg18" class="labell_msg blink_text orange_msg"></div>
                    <input name="cprogrammedescNew_h1" id="cprogrammedescNew_h1" type="hidden" value="<?php if(isset($_REQUEST['cprogrammedescNew_h1'])){echo $_REQUEST['cprogrammedescNew_h1'];} ?>"/>
                </div>
            </form><?php

            $uvApplicationNo = '';

            $ref_table = src_table("prog_choice");
            
            if (isset($_REQUEST["uvApplicationNo04"]) && $num_valid == 1){$uvApplicationNo = $_REQUEST["uvApplicationNo04"];}

            if ($uvApplicationNo <> '' && isset($_REQUEST['id_no']) && $_REQUEST['id_no'] <> '2')
            {
                $cSbmtd = '';
                $stmt = $mysqli->prepare("SELECT cSbmtd FROM $ref_table WHERE vApplicationNo = ?");
                $stmt->bind_param("s", $uvApplicationNo);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($cSbmtd);
                $stmt->fetch();
                $stmt->close();

                if (isset($_REQUEST['qualified_h']) && ($_REQUEST['qualified_h'] == '2' || $_REQUEST['qualified_h'] == '3'))
                {
                    $sql_subqry = "";
                    if ($cSbmtd == '1' || $_REQUEST['qualified_h'] == 3)
                    {
                        if (isset($_REQUEST['mm']) && $_REQUEST['mm'] == '8')
                        {
                            $stmt = $mysqli->prepare("UPDATE prog_choice_pg 
                            SET cSCrnd = '3',
                            date_cSCrnd = NOW()
                            WHERE vApplicationNo = ?");
                            $stmt->bind_param("s", $uvApplicationNo);
                            $stmt->execute();

                            if (substr($_REQUEST['cprogrammeIdold'],3,1) == 3)
                            {
                                $sql_subqry = "cEduCtgId = 'PGX', iBeginLevel = 700, ";
                            }else if (substr($_REQUEST['cprogrammeIdold'],3,1) == 4)
                            {
                                $sql_subqry = "cEduCtgId = 'PGY', iBeginLevel = 800, ";
                            }else if (substr($_REQUEST['cprogrammeIdold'],3,1) == 5)
                            {
                                $sql_subqry = "cEduCtgId = 'PGZ', iBeginLevel = 900, ";
                            }else if (substr($_REQUEST['cprogrammeIdold'],3,1) == 6)
                            {
                                $sql_subqry = "cEduCtgId = 'PRX', iBeginLevel = 1000, ";
                            }
                        }else
                        {
                            if (substr($_REQUEST['cprogrammeIdold'],3,1) == 2)
                            {
                                $sql_subqry = "cEduCtgId = 'PSZ', iBeginLevel = ".$_REQUEST['ilevelold'].",";
                            }else if (substr($_REQUEST['cprogrammeIdold'],3,1) == 3)
                            {
                                $sql_subqry = "cEduCtgId = 'PGX', iBeginLevel = ".$_REQUEST['ilevelold'].",";
                            }else if (substr($_REQUEST['cprogrammeIdold'],3,1) == 4)
                            {
                                $sql_subqry = "cEduCtgId = 'PGY', iBeginLevel = ".$_REQUEST['ilevelold'].",";
                            } 
                        }
                        
                        $cSCrnd = "cSCrnd = '3',";
                        // if ($_REQUEST['qualified_h'] == '2')
                        // {
                        //     $cSCrnd = "cSCrnd = '2',";
                        // }else if ($_REQUEST['qualified_h'] == '3')
                        // {
                        //     $cSCrnd = "cSCrnd = '3',";
                        // }

                        $cSCrnd = "cSCrnd = '".$_REQUEST['qualified_h']."',";

                        $stmt = $mysqli->prepare("UPDATE $ref_table 
                        SET $sql_subqry
                        $cSCrnd
                        cqualfd = '1',
                        cFacultyId = ?,
                        cProgrammeId = ?
                        WHERE vApplicationNo = ?");

                        $stmt->bind_param("sss", $_REQUEST['cFacultyIdold'], $_REQUEST['cprogrammeIdold'], $uvApplicationNo);
                        $stmt->execute();
                    }else if ($_REQUEST['qualified_h'] <> 3)
                    {
                        information_box('Process aborted. Form not submitted');
                    }
                }else if (isset($_REQUEST['qualified_h']) && $_REQUEST['qualified_h'] == '0')
                {
                    if ($cSbmtd == '1')
                    {
                        $stmt = $mysqli->prepare("UPDATE $ref_table 
                        SET cSCrnd = '1',
                        cqualfd = '0'
                        WHERE vApplicationNo = ?");
                        $stmt->bind_param("s", $uvApplicationNo);
                        $stmt->execute();
                    }else
                    {
                        information_box('Process aborted. Form not submitted');
                    }
                }
                
                if (isset($_REQUEST["id_no"]) && $_REQUEST["id_no"] <> '')
                {
                    $stmt = $mysqli->prepare("SELECT vProcessNote,cSbmtd,cSCrnd,cqualfd,iprnltr, concat(vObtQualDesc,', ',vProgrammeDesc) vProgrammeDesc 
                    FROM $ref_table a, programme b, obtainablequal c
                    WHERE c.cObtQualId = b.cObtQualId and a.cProgrammeId = b.cProgrammeId and vApplicationNo = ?");
                    $stmt->bind_param("s", $uvApplicationNo);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($vProcessNote, $cSbmtd, $cSCrnd, $cqualfd, $iprnltr, $vProgrammeDesc);?>
                    <div id="adm_status" class="innercont_stff" style="margin-top:80px; margin-bottom:5px; text-align:right; height:18px; color:#FF3300;"><?php
                        //if ($stmt->num_rows > 0)
                        //{
                            $stmt->fetch();
                            if ($iprnltr == '1')
                            {
                                echo 'Printed admission letter for '.$vProgrammeDesc;
                            }else if ($iprnltr > '1')
                            {
                                echo 'Re-printed admission letter for '.$vProgrammeDesc;
                            }else if ($cSbmtd == '1')
                            {
                                echo 'Form submitted';
                            }else if ($vProcessNote <> '' && $uvApplicationNo <> '')
                            {
                                echo ucfirst($vProcessNote);
                                
                                $stmt = $mysqli->prepare("SELECT a.cFacultyId, a.vFacultyDesc, b.cEduCtgId
                                FROM faculty a, $ref_table b
                                where a.cFacultyId = b.cFacultyId and
                                b.vApplicationNo = ?");
                                $stmt->bind_param("s", $uvApplicationNo);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($cFacultyId, $vFacultyDesc, $cEduCtgId);
                                                                
                                $stmt->fetch();?>
                                <a href="#" onclick="pgprgs.vFacultyDesc.value='<?php echo $vFacultyDesc; ?>';
                                    pgprgs.cFacultyId.value='<?php echo $cFacultyId;?>';
                                    pgprgs.cEduCtgId.value='<?php echo $cEduCtgId;?>';
                                    pgprgs.submit();return false">
                                    <img src="img/crit.gif" alt="Click to see credential" style="text-decoration:none" border="0" align="bottom"/>
                                </a><?php
                                $stmt->close();
                            }else if ($cSbmtd == '0')
                            {
                                echo 'Yet to submit';
                            }else if ($uvApplicationNo <> '' && $vProgrammeDesc <> '')
                            {
                                echo 'Admitted for '.$vProgrammeDesc;
                            }?>

                            &nbsp;&nbsp;
                            <input name="qualified" id="qualified0" <?php if(isset($_REQUEST['qualified_h']) && $_REQUEST['qualified_h'] == '2'){echo ' checked';}?> 
                                onclick="if (_('cprogrammeIdold').value=='')
                                {
                                    setMsgBox('labell_msg15','Select faculty');
                                    setMsgBox('labell_msg16','Select department');
                                    setMsgBox('labell_msg17','Select programme');
                                    return false;
                                }

                                if (_('ilevelold_div').style.display == 'block')
                                {
                                    if (_('ilevelold').value == '')
                                    {
                                        setMsgBox('labell_msg18','Select level');
                                        return false;
                                    }
                                }
                                qualified_h.value='2'; 
                                gln1.submit()" 
                                value="1" type="radio" <?php if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '0'){echo 'disabled';}?>/>
                                <label for="qualified0" style="color:<?php if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '0'){echo '#999999';}else{echo '#000000';}?>; cursor:pointer;"><?php
                                    if ($_REQUEST['mm'] == 8 && ($cEduCtgId_01 == 'PGZ' || $cEduCtgId_01 == 'PRX'))
                                    {
                                        echo 'Qualified';
                                    }else
                                    {
                                        echo 'Qualified on credit transfer';
                                    }?>
                                </label>&nbsp;

                            <input name="qualified" id="qualified1" <?php if(isset($_REQUEST['qualified_h']) && $_REQUEST['qualified_h'] == '3'){echo ' checked';}?> 
                                onclick="if (_('cprogrammeIdold').value=='')
                                {
                                    setMsgBox('labell_msg15','Select faculty');
                                    setMsgBox('labell_msg16','Select department');
                                    setMsgBox('labell_msg17','Select programme');
                                    return false;
                                }

                                if (_('ilevelold_div').style.display == 'block')
                                {
                                    if (_('ilevelold').value == '')
                                    {
                                        setMsgBox('labell_msg18','Select level');
                                        return false;
                                    }
                                }

                                qualified_h.value='3'; 
                                gln1.submit()" 
                                value="1" type="radio" <?php if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '0'){echo 'disabled';}?>/>
                                <label for="qualified1" style="color:<?php if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '0'){echo '#999999';}else{echo '#000000';}?>; cursor:pointer;">
                                    Qualified on consession                                    
                                </label>&nbsp;

                            <input name="qualified" id="qualified2" <?php if(isset($_REQUEST['qualified_h']) && $_REQUEST['qualified_h'] == '0'){echo ' checked';}?> 
                                onclick="qualified_h.value='0'; 
                                gln1.submit()" value="0" type="radio" <?php if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '0'){echo 'disabled';}?>/> 
                                <label for="qualified2" style="color:<?php if (isset($_REQUEST['id_no']) && $_REQUEST['id_no'] == '0'){echo '#999999';}else{echo '#000000';}?>; cursor:pointer;">
                                    Not qualified
                                </label><?php
                        //}else
                        //{
                            $stmt->close();
                            
                            $stmt = $mysqli->prepare("SELECT vProcessNote FROM $ref_table where vApplicationNo = ?");
                            $stmt->bind_param("s", $uvApplicationNo);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($vProcessNote);
                            $stmt->fetch();
                            
                            echo ucfirst($vProcessNote);
                            $stmt->close();
                        //}?>
                    </div><?php
                }?>
                
                <div id="qual_list" class="innercont_stff" 
                    style="height:67%; width:auto; border:1px solid #ccc; display:<?php if (isset($_REQUEST['id_no']) && ($_REQUEST['id_no'] == '0' || $_REQUEST['id_no'] == '1')){?>block<?php }else{?>none<?php }?>; overflow:scroll;  overflow-x: hidden;"><?php
                    
                    $uvApplicationNo = '';
                    if (isset($_REQUEST["uvApplicationNo04"]))
                    {
                        $uvApplicationNo = $_REQUEST["uvApplicationNo04"];
                    }

                    $stmt = $mysqli->prepare("select c.cEduCtgId, a.vExamNo, a.cExamMthYear, b.cQualCodeId, b.vQualCodeDesc from applyqual a, qualification b, $ref_table c
                    where a.cQualCodeId = b.cQualCodeId and
                    a.vApplicationNo = c.vApplicationNo and
                    a.vApplicationNo = ? order by right(a.cExamMthYear,4), left(a.cExamMthYear,2)");
                    $stmt->bind_param("s", $uvApplicationNo);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($cEduCtgId, $vExamNo, $cExamMthYear, $cQualCodeId, $vQualCodeDesc);
                    $coun = $stmt->num_rows;
                    $cred_cnt = 0;
                    
                    while($stmt->fetch())
                    {
                        $coun--;$cred_cnt++;?>
                        
                        <div id="credentialNum<?php echo $cred_cnt; ?>" class="inner_cont" style="height:auto; width:99%; margin-bottom:5px;border:1px dashed #000000; border-radius:0px;">
                            <div class="innercont_stff" style="text-align:right; height:18px">
                                <a href="#" onclick="
                                    gln1.vExamNo.value='<?php echo $vExamNo; ?>';
                                    gln1.cQualCodeId.value='<?php echo $cQualCodeId; ?>';
                                    call_image();
                                    return false">
                                    <img src="img/cert.gif" title="Click to see credential" style="text-decoration:none" border="0" align="bottom"/>
                                </a>
                            </div>
                            
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
                                <?php echo ucwords(strtolower(stripslashes($cExamMthYear)));?>
                            </div>
                            
                            <div style="width:30%; height:auto; float:left; text-align:right; padding:5px; font-weight:bold; margin-top:3px; padding-left:0px; border-top:1px solid #cdd8cf;">
                                Subject
                            </div>
                            <div style="width:45%; height:auto; float:left; text-align:left; padding:5px; font-weight:bold; margin-top:3px; border-top:1px solid #cdd8cf;">
                                Grade
                            </div><?php 
                            $qual = "s6.cQualCodeId.value='".$cQualCodeId.
                            "';s6.vExamNo.value='".$vExamNo."';";

                            $stmt2 = $mysqli->prepare("select vQualSubjectDesc, cQualGradeCode from applysubject a, qualsubject b, qualgrade c
                            where a.cQualSubjectId = b.cQualSubjectId and
                            a.cQualCodeId = '".$cQualCodeId."' and
                            a.vExamNo = '".$vExamNo."' and
                            a.cQualGradeId = c.cQualGradeId and
                            vApplicationNo = ?");
                            $stmt2->bind_param("s", $uvApplicationNo);
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
                    $stmt->close();?>
                </div><?php
                
                if (isset($_REQUEST['uvApplicationNo04']))
                {	
                    $stmt = $mysqli->prepare("select * from afnmatric a inner join s_m_t b using(vMatricNo) where a.vApplicationNo = ?");
                    $stmt->bind_param("s", $_REQUEST['uvApplicationNo04']);
                    $stmt->execute();
                    $stmt->store_result();
                    
                    $has_matno = $stmt->num_rows;
                    
                    // $stmt->close();						
                    
                    // $uvApplicationNo_1 = '';
                    // $uvApplicationNo_2 = '';
                    // if (isset($_REQUEST['uvApplicationNo04']))
                    // {
                    //     $uvApplicationNo_1 = $_REQUEST['uvApplicationNo04'];
                    //     $uvApplicationNo_2 = $_REQUEST['uvApplicationNo04'];
                    // }						

                    // if ($has_matno > 0)
                    // {                      
                    //     $stmt = $mysqli->prepare("select vTitle, vLastName, vFirstName, vOtherName, b.vFacultyDesc, c.vdeptDesc,a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.iStudy_level, e.cEduCtgId, a.tSemester, a.col_gown, a.ret_gown , h.vCityName
                    //     from s_m_t a, faculty b, depts c, obtainablequal d, programme e, studycenter h, afnmatric g
                    //     where a.cFacultyId = b.cFacultyId
                    //     and a.cdeptId = c.cdeptId
                    //     and a.cObtQualId = d.cObtQualId
                    //     and a.cProgrammeId = e.cProgrammeId
                    //     and a.cStudyCenterId = h.cStudyCenterId
                    //     and g.vMatricNo = a.vMatricNo
                    //     and (g.vMatricNo = ? or
                    //     g.vApplicationNo = ?)");
                    //     $stmt->bind_param("ss", $uvApplicationNo_1, $uvApplicationNo_2);
                    //     $stmt->execute();
                    //     $stmt->store_result();
                    //     $stmt->bind_result($vTitle, $vLastName, $vFirstName, $vOtherName, $vFacultyDesc, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $iStudy_level, $cEduCtgId, $tSemester, $col_gown, $ret_gown,  $vCityName);
                    // }else
                    // {
                    //     $student_user_num = -1;
                        
                    //     $stmt = $mysqli->prepare("select vTitle, a.vLastName, a.vFirstName, a.vOtherName, c.vFacultyDesc, d.vdeptDesc, b.cProgrammeId, f.vObtQualTitle, e.vProgrammeDesc, b.iBeginLevel, e.cEduCtgId, 'tSemester', 'col_gown', 'ret_gown', h.vCityName			
                    //     from pers_info a, $ref_table b, faculty c, depts d, programme e, obtainablequal f, studycenter h
                    //     where a.vApplicationNo = b.vApplicationNo
                    //     and b.cFacultyId = c.cFacultyId
                    //     and e.cdeptId = d.cdeptId
                    //     and e.cProgrammeId = b.cProgrammeId
                    //     and e.cObtQualId = f.cObtQualId
                    //     and b.cStudyCenterId = h.cStudyCenterId
                    //     and a.vApplicationNo = ?");
                    //     $stmt->bind_param("s", $_REQUEST['uvApplicationNo04']);
                    //     $stmt->execute();
                    //     $stmt->store_result();
                        
                    //     if ($stmt->num_rows == 0)
                    //     {
                    //         $stmt->close();

                    //         $stmt = $mysqli->prepare("select vTitle, a.vLastName, a.vFirstName, a.vOtherName, c.vFacultyDesc, d.vdeptDesc, b.cProgrammeId, f.vObtQualTitle, e.vProgrammeDesc, b.iBeginLevel iStudy_level, e.cEduCtgId, 'tSemester', 'col_gown', 'ret_gown', h.vCityName					
                    //         from pers_info a, $ref_table b, faculty c, depts d, programme e, obtainablequal f, studycenter h
                    //         where a.vApplicationNo = b.vApplicationNo
                    //         and b.cFacultyId = c.cFacultyId
                    //         and e.cdeptId = d.cdeptId
                    //         and e.cProgrammeId = b.cProgrammeId
                    //         and e.cObtQualId = f.cObtQualId
                    //         and b.cStudyCenterId = h.cStudyCenterId
                    //         and a.vApplicationNo =?");
                    //         $stmt->bind_param("s", $_REQUEST['uvApplicationNo04']);
                    //         $stmt->execute();
                    //         $stmt->store_result();					
                    //         $stmt->bind_result($vTitle, $vLastName, $vFirstName, $vOtherName, $vFacultyDesc, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $iStudy_level, $cEduCtgId, $tSemester, $col_gown, $ret_gown, $vCityName);
                    //     }else
                    //     {
                    //         $stmt->bind_result($vTitle, $vLastName, $vFirstName, $vOtherName, $vFacultyDesc, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $cEduCtgId, $tSemester, $col_gown, $ret_gown, $vCityName);
                    //     }
                    // }
                    
                    // $student_user_num = $stmt->num_rows;
                    // $stmt->fetch();
                    // $stmt->close();


                    $stmt = $mysqli->prepare("select cblk, csuspe, cexpe 
                    from rectional where vMatricNo = ? and (cexpe = '1' or csuspe = '1' or cblk = '1') order by period1 limit 1");
                    $stmt->bind_param("s", $_REQUEST["uvApplicationNo04"]);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result(
                    $cblk,
                    $csuspe,
                    $cexpe);
                    $stmt->fetch();
                    $stmt->close();
                }
            }else if (isset($_REQUEST["save"]) && $_REQUEST["save"] == '1')
            {?>
                <div class="innercont" style="margin-left:2px; border-radius:0px; margin-top:3px; margin-bottom:3px; width:840px; padding:0px; font-weight:bold">
                    <div class="ctabletd_1" style="width:30px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">
                        Sno
                    </div>
                    <div class="ctabletd_1" style="width:329px;height:17px; text-indent:4px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; margin-right:0px">
                        Programme
                    </div>
                    <div class="ctabletd_1" style="width:75px; height:17px; text-indent:4px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; margin-right:0px">
                        AFN
                    </div>
                    <div class="ctabletd_1" style="width:252px;height:17px; text-indent:4px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; margin-right:0px">
                        Name
                    </div>
                    <div class="ctabletd_1" style="width:25px;height:17px; text-indent:4px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; margin-right:0px">
                        <input onclick="if(this.checked)
                            {
                                checkAll(1);
                            }else
                            {
                                checkAll(0);
                            }" checked type="checkbox"/>
                    </div>
                </div><?php

                if (isset($_REQUEST["qualified_list_arr"]) && $_REQUEST["qualified_list_arr"] <> "'" && $_REQUEST["qualified_list_arr"] <> "")
                {?>						
                    <div id="screen_list" class="innercont_stff" style="height:380px; width:auto; margin-top:5px; margin-left:2px; padding:0px; border:1px solid #ccc; overflow:scroll;"><?php
                        $sql_afn = "SELECT CONCAT(c.vObtQualTitle,' ',vProgrammeDesc) programme, vApplicationNo, CONCAT(UCASE(vLastName),' ', CONCAT(UCASE(LEFT(vFirstName, 1)), LCASE(SUBSTRING(vFirstName, 2))),' ',CONCAT(UCASE(LEFT(vOtherName, 1)), LCASE(SUBSTRING(vOtherName, 2)))) appl_name, vProcessNote, cSCrnd, cqualfd 
                        FROM $ref_table a, programme b, obtainablequal c
                        WHERE a.cProgrammeId = b.cProgrammeId
                        AND b.cObtQualId = c.cObtQualId
                        AND vApplicationNo IN (".$_REQUEST["qualified_list_arr"].")
                        ORDER BY programme, appl_name;";//echo $sql_afn;

                        $count_rec = 0;

                        $rssql_afn = mysqli_query(link_connect_db(), $sql_afn) or die(mysqli_error(link_connect_db()));
                        $previous_prog = '';
                        while ($rs_afn = mysqli_fetch_array($rssql_afn))//criteriaqual
                        {
                            if ($count_rec%2 == 0){$color = '#E3EBE2';}else{$color = '#FFFFFF';}
                            
                            if ($previous_prog == '' || $previous_prog <> $rs_afn["programme"])
                            {?>
                                <div class="innercont" style="margin:0px; margin-left:-1px; border-radius:0px; margin-top:-1px; width:auto; padding:0px; background:#FFFFFF">
                                    <div class="ctabletd_1" style="width:724px; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:left; text-indent:3px;; font-weight:bold">
                                        <?php echo $rs_afn["programme"];?>
                                    </div>
                                </div><?php
                            }?>
                            <div class="innercont" style="margin:0px; margin-left:-1px; border-radius:0px; margin-top:-1px; width:auto; padding:0px; background:#FFFFFF">
                                <div class="ctabletd_1" style="width:32px; height:17px; padding-top:5px; background-color:<?php echo $color;?>; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">
                                    <?php echo ++$count_rec;?>
                                </div>
                                <div class="ctabletd_1" style="width:77px;height:17px; text-indent:4px; padding-top:5px; background-color:<?php echo $color;?>; border:1px solid #A7BAAD; text-align:left; margin-right:0px">
                                    <a href="#" style="text-decoration:none"
                                        onclick="m_frm.uvApplicationNo.value='<?php echo $rs_afn['vApplicationNo'];?>';m_frm.submit();return false"><?php echo $rs_afn["vApplicationNo"];?>
                                    </a>
                                </div>
                                <div class="ctabletd_1" style="width:540px;height:17px; text-indent:4px; padding-top:5px; background-color:<?php echo $color;?>; border:1px solid #A7BAAD; text-align:left; margin-right:0px">											
                                    <?php echo $rs_afn["appl_name"];?>
                                </div><?php
                                                                        
                                $cred_ = "cred_".$rs_afn["appl_name"];?>

                                <a href="#" style="text-decoration: none" onclick="m_frm.uvApplicationNo.value='<?php echo $rs_afn['vApplicationNo'];?>';m_frm.submit();return false" 
                                onmouseover="_('<?php echo $cred_;?>').style.display='block'" 
                                onmouseout="_('<?php echo $cred_;?>').style.display='none'">
                                    <div class="ctabletd_1" style="width:37px;height:17px; text-align:center; padding-top:5px; background-color:<?php echo $color;?>; border:1px solid #A7BAAD; margin-right:0px">											
                                        <img src="img/detail.gif" title="Click to see detail" hspace="0" vspace="0" border="0" />
                                    </div>
                                </a><?php												
                                $stmt = $mysqli->prepare("SELECT b.cQualCodeId, b.vExamNo, c.vQualCodeDesc 
                                FROM $ref_table a, applyqual b, qualification c 
                                WHERE a.vApplicationNo = b.vApplicationNo 
                                AND b.cQualCodeId = c.cQualCodeId 
                                AND a.vApplicationNo = ?
                                ORDER BY a.vApplicationNo");
                                $stmt->bind_param("s", $rs_afn["vApplicationNo"]);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($cQualCodeId, $vExamNo, $vQualCodeDesc);?>
                                <div id="<?php echo $cred_;?>"
                                    style="position: fixed; 
                                    height:AUTO;
                                    width:440px;
                                    box-shadow: 4px 4px 8px 5px #726e41;
                                    padding:8px; 			
                                    background:#FFFFFF;
                                    border:1px solid #cccccc;
                                    font:normal 11px Arial; 
                                    color:#34af3e;
                                    display:none" class="center">
                                        <div id="div_header_main_0" class="innercont_stff" 
                                        style="float:left;
                                        width:99.5%;
                                        height:auto;
                                        padding:0px;
                                        padding-top:3px;
                                        padding-bottom:4px;
                                        border-bottom:0px solid #cccccc;">
                                        <div class="innercont_stff" style="float:left;">
                                            Credentials for <?php echo $rs_afn["vApplicationNo"].' '.$rs_afn["appl_name"];?>
                                        </div>

                                        <div class="innercont_stff" style="float:right;">
                                            <a href="#" style="text-decoration:none;"  
                                                onclick="_('container_cover_in_constat_0').style.display = 'none';
                                                return false">
                                                <div class="basic_three_ok" style="margin-left:2px; color:#996633">Close</div>
                                            </a>
                                        </div>
                                    </div>
                                        
                                    <div class="innercont_stff" 
                                        style="float:left;
                                        width:100%;
                                        height:auto;
                                        padding:0px;
                                        padding-top:3px;
                                        padding-bottom:4px;
                                        border-bottom:0px solid #cccccc;">												
                                        <div class="innercont" style="margin:0px; margin-left:-1px; border-radius:0px; margin-top:-1px; width:99.6%; padding:0px;"><?php
                                            $count_a = 1;
                                            while($stmt->fetch())
                                            {?>																												
                                                <div class="ctabletd_1" style="width:2%; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:right; padding-right:3px; background:#FFFCCC">
                                                    <?php echo $count_a++;?>
                                                </div>
                                                <div class="ctabletd_1" style="width:96%; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:left; text-indent:3px; background:#FFFCCC">
                                                    <?php echo 'Exam. no.:'. $vExamNo.', '.$vQualCodeDesc;?>
                                                </div><?php

                                                $stmt_a = $mysqli->prepare("SELECT b.vQualSubjectDesc, c.cQualGradeCode
                                                FROM applysubject a, qualsubject b, qualgrade c
                                                WHERE a.cQualSubjectId = b.cQualSubjectId
                                                AND a.cQualGradeId = c.cQualGradeId
                                                AND a.vApplicationNo = ?
                                                AND a.cQualCodeId = ?
                                                AND vExamNo = ?
                                                order by b.vQualSubjectDesc");
                                                $stmt_a->bind_param("sss", $rs_afn["vApplicationNo"], $cQualCodeId, $vExamNo);
                                                $stmt_a->execute();
                                                $stmt_a->store_result();
                                                $stmt_a->bind_result($vQualSubjectDesc, $cQualGradeCode);
                                                $count_i = 'a';
                                                while($stmt_a->fetch())
                                                {?>
                                                    <div class="ctabletd_1" style="width:2%; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">
                                                        <?php echo $count_i++;?>
                                                    </div>
                                                    <div class="ctabletd_1" style="width:90.3%; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:left; text-indent:3px;">
                                                        <?php echo $vQualSubjectDesc;?>
                                                    </div>
                                                    <div class="ctabletd_1" style="width:5%; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:center;">
                                                        <?php echo $cQualGradeCode;?>
                                                    </div><?php
                                                }
                                                $stmt_a->close();
                                            }
                                            $stmt->close();?>
                                        </div>
                                    </div>
                                </div>

                                <div class="ctabletd_1" style="width:24px;height:17px; text-indent:4px; padding-top:5px; background-color:<?php echo $color;?>; border:1px solid #A7BAAD; text-align:left; margin-right:0px">
                                    <input name="apllicant<?php echo $count_rec;?>" id="apllicant<?php echo $count_rec;?>"  onclick="_('gln1').save.value=1;"
                                    value="<?php echo $rs_afn["vApplicationNo"];?>" type="checkbox" <?php if ($rs_afn["cqualfd"] == '1'){echo ' checked';} ?>/>
                                </div>
                            </div><?php 
                            $previous_prog = $rs_afn["programme"];
                        }
                        mysqli_close(link_connect_db());?>
                        <input name="count_rec_q" id="count_rec_q" type="hidden" value="<?php echo $count_rec; ?>" />
                    </div><?php
                }

                if (isset($_REQUEST["not_qualified_list_arr"]) && $_REQUEST["not_qualified_list_arr"] <> "'" && $_REQUEST["not_qualified_list_arr"] <> "")
                {?>
                    <div id="screen_list_0" class="innercont_stff" style="height:380px; width:auto; margin-top:5px; margin-left:2px; padding:0px; border:1px solid #ccc; overflow:scroll; display:none"><?php
                        $sql_afn = "SELECT CONCAT(c.vObtQualTitle,' ',vProgrammeDesc) programme, vApplicationNo, CONCAT(UCASE(vLastName),' ', CONCAT(UCASE(LEFT(vFirstName, 1)), LCASE(SUBSTRING(vFirstName, 2))),' ',CONCAT(UCASE(LEFT(vOtherName, 1)), LCASE(SUBSTRING(vOtherName, 2)))) appl_name, vProcessNote 
                        FROM $ref_table a, programme b, obtainablequal c
                        WHERE a.cProgrammeId = b.cProgrammeId
                        AND b.cObtQualId = c.cObtQualId
                        AND vApplicationNo IN (".$_REQUEST["not_qualified_list_arr"].")
                        ORDER BY programme, appl_name;";//echo $sql_afn;

                        $count_rec = 0;
                        $previous_prog = '';

                        $rssql_afn = mysqli_query(link_connect_db(), $sql_afn) or die(mysqli_error(link_connect_db()));
                        while ($rs_afn = mysqli_fetch_array($rssql_afn))//criteriaqual
                        {
                            if ($count_rec%2 == 0){$color = '#E3EBE2';}else{$color = '#FFFFFF';}
                            
                            if ($previous_prog == '' || $previous_prog <> $rs_afn["programme"])
                            {?>
                                <div class="innercont" style="margin:0px; margin-left:-1px; border-radius:0px; margin-top:-1px; width:auto; padding:0px; background:#FFFFFF">
                                    <div class="ctabletd_1" style="width:724px; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:left; text-indent:3px; font-weight:bold">
                                        <?php echo $rs_afn["programme"];?>
                                    </div>
                                </div><?php
                            }?>
                            <div class="innercont" style="margin:0px; margin-left:-1px; border-radius:0px; margin-top:-1px; width:auto; padding:0px; background:#FFFFFF">
                                <div class="ctabletd_1" style="width:32px; height:17px; padding-top:5px; background-color:<?php echo $color;?>; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">
                                    <?php echo ++$count_rec;?>
                                </div>
                                <div class="ctabletd_1" style="width:77px;height:17px; text-indent:4px; padding-top:5px; background-color:<?php echo $color;?>; border:1px solid #A7BAAD; text-align:left; margin-right:0px">
                                    <a href="#" style="text-decoration:none"
                                        onclick="m_frm.uvApplicationNo.value='<?php echo $rs_afn['vApplicationNo'];?>';m_frm.submit();return false"><?php echo $rs_afn["vApplicationNo"];?>
                                    </a>
                                </div>
                                <div class="ctabletd_1" style="width:540px; height:17px; text-indent:4px; padding-top:5px; background-color:<?php echo $color;?>; border:1px solid #A7BAAD; text-align:left; margin-right:0px">
                                    <?php echo $rs_afn["appl_name"];?>
                                </div><?php
                                                                        
                                $cred_ = "cred_".$rs_afn["appl_name"];?>

                                <a href="#" style="text-decoration: none" onclick="m_frm.uvApplicationNo.value='<?php echo $rs_afn['vApplicationNo'];?>';m_frm.submit();return false" 
                                    onmouseover="_('<?php echo $cred_;?>').style.display='block'" 
                                    onmouseout="_('<?php echo $cred_;?>').style.display='none'">
                                    <div class="ctabletd_1" style="width:37px;height:17px; text-align:center; padding-top:5px; background-color:<?php echo $color;?>; border:1px solid #A7BAAD; margin-right:0px">											
                                        <img src="img/detail.gif" title="Click to see detail" hspace="0" vspace="0" border="0" />
                                    </div>
                                </a><?php												
                                $stmt = $mysqli->prepare("SELECT b.cQualCodeId, b.vExamNo, c.vQualCodeDesc 
                                FROM $ref_table a, applyqual b, qualification c 
                                WHERE a.vApplicationNo = b.vApplicationNo 
                                AND b.cQualCodeId = c.cQualCodeId 
                                AND a.vApplicationNo = ?
                                ORDER BY a.vApplicationNo");
                                $stmt->bind_param("s", $rs_afn["vApplicationNo"]);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($cQualCodeId, $vExamNo, $vQualCodeDesc);?>
                                
                                <div id="<?php echo $cred_;?>"
                                    style="position: fixed; 
                                    height:auto;
                                    width:440px;
                                    box-shadow: 4px 4px 8px 5px #726e41;
                                    padding:8px; 			
                                    background:#FFFFFF;
                                    border:1px solid #cccccc;
                                    font:normal 11px Arial; 
                                    color:#34af3e;
                                    display:none" class="center">
                                        <div id="div_header_main_0" class="innercont_stff" 
                                        style="float:left;
                                        width:99.5%;
                                        height:auto;
                                        padding:0px;
                                        padding-top:3px;
                                        padding-bottom:4px;
                                        border-bottom:0px solid #cccccc;">
                                        <div class="innercont_stff" style="float:left;">
                                            Credentials for <?php echo $rs_afn["vApplicationNo"].' '.$rs_afn["appl_name"];?>
                                        </div>

                                        <div class="innercont_stff" style="float:right;">
                                            <a href="#" style="text-decoration:none;"  
                                                onclick="_('container_cover_in_constat_0').style.display = 'none';
                                                return false">
                                                <div class="basic_three_ok" style="margin-left:2px; color:#996633">Close</div>
                                            </a>
                                        </div>
                                    </div>
                                        
                                    <div class="innercont_stff" 
                                        style="float:left;
                                        width:100%;
                                        height:auto;
                                        padding:0px;
                                        padding-top:3px;
                                        padding-bottom:4px;
                                        border-bottom:0px solid #cccccc;">												
                                        <div class="innercont" style="margin:0px; margin-left:-1px; border-radius:0px; margin-top:-1px; width:99.6%; padding:0px; background:#FFFCCC"><?php
                                            $count_a = 1;
                                            while($stmt->fetch())
                                            {?>																												
                                                <div class="ctabletd_1" style="width:2%; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">
                                                    <?php echo $count_a++;?>
                                                </div>
                                                <div class="ctabletd_1" style="width:96%; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:left; text-indent:3px;">
                                                    <?php echo 'Exam. no.:'. $vExamNo.', '.$vQualCodeDesc;?>
                                                </div><?php

                                                $stmt_a = $mysqli->prepare("SELECT b.vQualSubjectDesc, c.cQualGradeCode
                                                FROM applysubject a, qualsubject b, qualgrade c
                                                WHERE a.cQualSubjectId = b.cQualSubjectId
                                                AND a.cQualGradeId = c.cQualGradeId
                                                AND a.vApplicationNo = ?
                                                AND a.cQualCodeId = ?
                                                AND vExamNo = ?
                                                order by b.vQualSubjectDesc");
                                                $stmt_a->bind_param("sss", $rs_afn["vApplicationNo"], $cQualCodeId, $vExamNo);
                                                $stmt_a->execute();
                                                $stmt_a->store_result();
                                                $stmt_a->bind_result($vQualSubjectDesc, $cQualGradeCode);
                                                $count_i = 'a';
                                                while($stmt_a->fetch())
                                                {?>
                                                    <div class="ctabletd_1" style="width:2%; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">
                                                        <?php echo $count_i++;?>
                                                    </div>
                                                    <div class="ctabletd_1" style="width:90.3%; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:left; text-indent:3px;">
                                                        <?php echo $vQualSubjectDesc;?>
                                                    </div>
                                                    <div class="ctabletd_1" style="width:5%; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:center;">
                                                        <?php echo $cQualGradeCode;?>
                                                    </div><?php
                                                }
                                                $stmt_a->close();
                                            }
                                            $stmt->close();?>
                                        </div>
                                    </div>
                                </div>

                                <div class="ctabletd_1" style="width:24px;height:17px; text-indent:4px; padding-top:5px; background-color:<?php echo $color;?>; border:1px solid #A7BAAD; text-align:left; margin-right:0px">
                                    <input name="apllicant_0<?php echo $count_rec;?>" id="apllicant_0<?php echo $count_rec;?>"  onclick="_('gln1').save.value=1;"
                                        value="<?php echo $rs_afn["vApplicationNo"];?>" type="checkbox" <?php if ($rs_afn["cqualfd"] == '1'){echo ' checked';} ?>/>
                                </div>
                            </div><?php  
                            $previous_prog = $rs_afn["programme"];
                        }
                        mysqli_close(link_connect_db());?>
                    </div>
                    <input name="count_rec_nq" id="count_rec_nq" type="hidden" value="<?php echo $count_rec; ?>" /><?php
                }
            }?>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;"><?php
			$img = '';
			if (isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '')
			{
				$stmt_last = $mysqli->prepare("select a.vApplicationNo from pics a, afnmatric b where a.vApplicationNo = b.vApplicationNo and b.vMatricNo = ? and cinfo_type = 'p'");
				$stmt_last->bind_param("s", $_REQUEST["vMatricNo"]);
			}else if (isset($_REQUEST['uvApplicationNo']) && $_REQUEST['uvApplicationNo'] <> '')
			{
				$stmt_last = $mysqli->prepare("select a.vApplicationNo from pics a, afnmatric b where a.vApplicationNo = b.vApplicationNo and b.vMatricNo = ? and cinfo_type = 'p'");
				$stmt_last->bind_param("s", $_REQUEST["uvApplicationNo"]);
			}else if (isset($_REQUEST['uvApplicationNo04']) && $_REQUEST['uvApplicationNo04'] <> '')
			{
				$stmt_last = $mysqli->prepare("select vApplicationNo from pics where vApplicationNo = ? and cinfo_type = 'p'");
				$stmt_last->bind_param("s", $_REQUEST["uvApplicationNo04"]);
			}
			
            $a = '';
			if (isset($stmt_last))
			{
				$stmt_last->execute();
				$stmt_last->store_result();
				if ($stmt_last->num_rows > 0)
				{
					$stmt_last->bind_result($a);
					$stmt_last->fetch();
				}
            }?>
			<div id="pp_box">
				<img name="passprt" id="passprt" src="<?php echo get_pp_pix($a); ?>" width="95%" height="185"  
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
                
				<?php if (isset($_REQUEST['uvApplicationNo04']))
                {
                    side_detail($_REQUEST['uvApplicationNo04']);
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