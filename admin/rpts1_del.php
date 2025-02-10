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
<script type="text/javascript" src="rpts.js"></script>
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
		/*if (_('add_qual_div').innerHTML == 'Age distribution')
		{*/
			if (_("rpts1_loc").selection.value.trim() == '')
			{
				caution_box('Please select at least one column in step 2');
				return false;
			}

			if (_("rpts1_loc").selection.value.indexOf('e') > -1 && _("rpts1_loc").crit4.value == '')
			{
				caution_box('You must select a course under Criteria');
				return false;
			}
			
		/*}else if (_('add_qual_div').innerHTML == 'Select column')
		{
			for (f = 1; f <= 10; f++)
			{
				l_lim = 'grp'+f+'1';
				u_lim = 'grp'+f+'2';
				if (_(l_lim))
				{
					val1 = parseInt(_(l_lim).value)
					val2 = parseInt(_(u_lim).value);

					if (val1 >= val2)
					{
						caution_box('Lower limit value greater than uppper limit not allowed');
						elements[f].focus()
						return false
					}
				}
			}

			opt_made = 0;
			for (f = 1; f <= 10; f++)
			{
				l_lim = 'grp'+f+'1';
				u_lim = 'grp'+f+'2';
				if (_(l_lim))
				{
					val1 = parseInt(_(l_lim).value)
					val2 = parseInt(_(u_lim).value);

					if (_(l_lim).value != '' && _(u_lim).value != '')
					{
						opt_made = 1
						break
					}
				}
			}

			if (opt_made == 0)
			{
				caution_box('Please set age group(s)');
				return false;
			}
		}*/

        _("rpts1_loc").target = '_blank';
        _("rpts1_loc").action = 'present-report';
		_("finich").value = 'go';
		_("rpts1_loc").submit();
	}

	function completeHandler(event)
	{
		
		on_error('0');
		on_abort('0');
		in_progress('0');
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
			
			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
            <div class="innercont_top"><?php
				if (isset($sm))
				{
					if ($sm == 1)
					{
						echo 'Select type of report';
					}else if ($sm == 2)
					{
						echo 'Select composite column(s) of report';
					}else if ($sm == 3)
					{
						echo 'Select column by which to sort report';
					}else if ($sm == 4)
					{
						echo 'Select criteria with which to select columns';
					}else if ($sm == 5)
					{
						echo 'Set title of report (optional)';
					}
				}?>
			</div>

            <form method="post" id="rpts1_loc" name="rpts1_loc" enctype="multipart/form-data">                
                <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />

                <input name="staff_study_center" type="hidden" value="<?php  if (isset($staff_study_center_u)){echo $staff_study_center_u;} ?>" />
				
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                <input name="mm" type="hidden" value="<?php if (isset($_REQUEST['mm'])){echo $_REQUEST['mm'];} ?>" />
                <input name="sm" type="hidden" value="<?php if (isset($_REQUEST['sm'])){echo $_REQUEST['sm'];} ?>" />
                <input name="finich" id="finich" type="hidden" value="" />
                <input name="frm_upd" id="frm_upd" type="hidden" />

                <input name="hdcol_width" id="hdcol_width" type="hidden" value="<?php if (isset($_REQUEST["hdcol_width"])){echo $_REQUEST["hdcol_width"];}; ?>" />

                <input name="cStudyCenterId" id="cStudyCenterId" type="hidden" value="<?php if (isset($cStudyCenterId) && $staff_study_center_u <> ''){echo $cStudyCenterId;}?>" />
                <input name="cAcademicDesc" id="cAcademicDesc" type="hidden" value="<?php if (isset($orgsetins['cAcademicDesc']) && $orgsetins['cAcademicDesc'] <> ''){echo $orgsetins['cAcademicDesc'];}?>" />						
                
                <?php rpts_frms_vars();
                
                include('rpt_type.php');
                include('rpt_cols.php');
                include('rpts_srt.php');
                include('rpt_crits.php');?>

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
                
                <select name="courseId_readup" id="courseId_readup" style="display:none"><?php	
                    $sql = "select concat(lpad(b.siLevel,3,'0'),' ',b.cProgrammeId,' ',a.cCourseId) cCourseId, concat(a.tSemester,' ',a.iCreditUnit,' ',b.cCategory,' ',a.cCourseId,' ',a.vCourseDesc) vCourseDesc
                    from courses a 
                    inner join progcourse b 
                    on a.cCourseId = b.cCourseId 
                    inner join programme c 
                    on b.cProgrammeId = c.cProgrammeId
                    where a.cdel = b.cdel
                    and c.cDelFlag = b.cdel
                    and c.cDelFlag = 'N'
                    order by b.siLevel, a.tSemester, b.cCategory, a.cCourseId";
                    $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                    while ($rs = mysqli_fetch_array($rssql))
                    {?>
                        <option value="<?php echo $rs['cCourseId'];?>"><?php echo $rs['vCourseDesc']; ?></option><?php
                    }
					mysqli_close(link_connect_db());?>
                </select>

                <select name="State_readup" id="State_readup" style="display:none"><?php	
                    $sql = "select cStateId,cCountryId,vStateName from ng_state order by vStateName";
                    $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                    while ($rs = mysqli_fetch_array($rssql))
                    {?>
                        <option value="<?php echo $rs['cStateId'].$rs['cCountryId'];?>"><?php echo $rs['vStateName']; ?></option><?php
                    }
					mysqli_close(link_connect_db());?>
                </select>

                <select name="LGA_readup" id="LGA_readup" style="display:none"><?php	
                    $sql = "select cStateId,cLGAId, vLGADesc from localarea order by vLGADesc";
                    $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                    while ($rs = mysqli_fetch_array($rssql))
                    {?>
                        <option value="<?php echo $rs['cStateId'].$rs['cLGAId'];?>"><?php echo ucwords (strtolower ($rs["vLGADesc"]))?></option><?php
                    }
					mysqli_close(link_connect_db());?>
                </select>

                <div class="innercont_stff" id="ans5" 
                    style="display:<?php if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '5'){?>block<?php }else{?>none<?php }?>; 
                    height:462px;
                    width:99.6%; 
                    border:0px solid #000;">
                    <div class="innercont_stff">
                        <label for="corect" class="labell" style="width:7%; margin-left:7px;">Line 1</label>
                        <div class="div_select" style="width:85%">
                            <input type="text" name="rpt_title1" class="textbox" value="<?php if (isset($_REQUEST["rpt_title1"]) && $_REQUEST["rpt_title1"] <>''){echo $_REQUEST["rpt_title1"];}?>"/>
                        </div>
                    </div>
                    
                    <div class="innercont_stff">
                        <label for="corect" class="labell" style="width:7%; margin-left:7px;">Line 2</label>
                        <div class="div_select" style="width:85%">
                            <input type="text" name="rpt_title2" class="textbox" value="<?php if (isset($_REQUEST["rpt_title2"]) && $_REQUEST["rpt_title2"] <>''){echo $_REQUEST["rpt_title2"];}?>"/>
                        </div>
                    </div>
                    
                    <div class="innercont_stff">
                        <label for="corect" class="labell" style="width:7%; margin-left:7px;">Line 3</label>
                        <div class="div_select" style="width:85%">
                            <input type="text" name="rpt_title3" class="textbox" value="<?php if (isset($_REQUEST["rpt_title3"]) && $_REQUEST["rpt_title3"] <>''){echo $_REQUEST["rpt_title3"];}?>"/>
                        </div>
                    </div>
                    
                    <div class="innercont_stff">
                        <label for="corect" class="labell" style="width:7%; margin-left:7px;">Line 4</label>
                        <div class="div_select" style="width:85%">
                            <input type="text" name="rpt_title4" class="textbox" value="<?php if (isset($_REQUEST["rpt_title4"]) && $_REQUEST["rpt_title4"] <>''){echo $_REQUEST["rpt_title4"];}?>"/>
                        </div>
                    </div>							
                    
                    <div class="innercont_stff">
                        <label for="corect" class="labell" style="width:7%; margin-left:7px;">Line 5</label>
                        <div class="div_select" style="width:85%">
                            <input type="text" name="rpt_title5" class="textbox" value="<?php if (isset($_REQUEST["rpt_title5"]) && $_REQUEST["rpt_title5"] <>''){echo $_REQUEST["rpt_title5"];}?>"/>
                        </div>
                    </div>							
                    
                    <div class="innercont_stff">
                        <label for="corect" class="labell" style="width:7%; margin-left:7px;">Line 6</label>
                        <div class="div_select" style="width:85%">
                            <input type="text" name="rpt_title6" class="textbox" value="<?php if (isset($_REQUEST["rpt_title6"]) && $_REQUEST["rpt_title6"] <>''){echo $_REQUEST["rpt_title6"];}?>"/>
                        </div>
                    </div>
                </div>
            </form>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
				<img name="passprt" id="passprt" src="<?php echo get_pp_pix('');?>" width="95%" height="185"  
				style="margin:0px;<?php if (!($currency == '1' /*&& check_scope() <> 0*/)){?>opacity:0.3;<?php }?>" alt="" />
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
                
				<?php side_detail('');?>
				<!-- InstanceEndEditable -->
		</div>
		<div id="insiderightSide" style="position:relative;">
			<!-- InstanceBeginEditable name="EditRegion9" -->
			<?php include ('stff_bottom_right_menu.php');?>
			<!-- InstanceEndEditable -->
		</div>
	</div>
	<div id="futa"><?php foot_bar();?></div>
</div>
</body>
<!-- InstanceEnd --></html>