<?php
require_once ('good_entry.php');

// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('const_def.php');
require_once('../../fsher/fisher.php');
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

$vFacultyDesc_u = '';
$vdeptDesc_u = '';

require_once('staff_detail.php');?>

<!-- InstanceBeginEditable name="doctitle" -->
<title>NOUN-MIS</title>
<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
<!-- InstanceEndEditable -->




<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
<script language="JavaScript" type="text/javascript" src="button_ops.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
<script language="JavaScript" type="text/javascript">
	
</script>
<noscript></noscript>

<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript" type="text/javascript">
	document.onkeydown = function (e) 
	{
		if (e.ctrlKey && e.keyCode === 85) 
		{
            return false;
        }
	}

	function update_cat_country_loc(callerctrl, parentctrl, childctrl1, childctrl2)
	{
		cProgdesc = '';
		cProgId = '';
		
		if (callerctrl.indexOf("Country") > -1)	
		{
			_(childctrl1).length = 0;
			_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');

			_(childctrl2).length = 0;
			_(childctrl2).options[_(childctrl2).options.length] = new Option('', '');
			
			for (var i = 0; i <= _(parentctrl).length-1; i++)
			{
				if (_(parentctrl).options[i].value.substr(2,2) == _(callerctrl).value)
				{
					cProgdesc = _(parentctrl).options[i].text;
					cProgId = _(parentctrl).options[i].value.substr(0,2);

					_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
				}
			}
			
			if (cProgId == '')
			{
				_(childctrl1).length = 0;
				_(childctrl1).options[_(childctrl1).options.length] = new Option('Non Nigerian', '99');
				
				_(childctrl2).length = 0;
				_(childctrl2).options[_(childctrl2).options.length] = new Option('Non Nigerian', '99999');
			}
		}else if (callerctrl.indexOf("State") > -1 || callerctrl == 'crit9' || callerctrl == 'crit11')	
		{
			_(childctrl1).length = 0;
			_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
			
			for (var i = 0; i <= _(parentctrl).length-1; i++)
			{
				if (_(parentctrl).options[i].value.substr(0,2) == _(callerctrl).value)
				{
					cProgdesc = _(parentctrl).options[i].text;
					cProgId = _(parentctrl).options[i].value.substr(2,5);

					_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
				}
			}
		}else if (callerctrl.indexOf("Faculty") > -1 || callerctrl.indexOf("faculty") > -1 || callerctrl == 'crit2')	
		{
			_(childctrl1).length = 0;
			_(childctrl1).options[_(childctrl1).options.length] = new Option('Select a department', '');

			_(childctrl2).length = 0;
			_(childctrl2).options[_(childctrl2).options.length] = new Option('', '');

			if (_(callerctrl).value == 'NA')
			{
				_(childctrl1).options[_(childctrl1).options.length] = new Option('Not applicable', 'NA');
				return;
			}
			
			if (_("courseId1"))
			{
				_("courseId1").length = 0;
				_("courseId1").options[_("courseId1").options.length] = new Option('', '');
			}		
			
			if (_("ccourseIdold") /*&& _('frm_upd').value != 'n_f' && _('frm_upd').value != 'n_d'*/)
			{
				_("ccourseIdold").length = 0;
				_("ccourseIdold").options[_("ccourseIdold").options.length] = new Option('', '');
			}
			
			for (var i = 0; i <= _(parentctrl).length-1; i++)
			{
				if (_(parentctrl).options[i].value.substr(0,3) == _(callerctrl).value)
				{
					cProgdesc = _(parentctrl).options[i].text;
					cProgId = _(parentctrl).options[i].value.substr(3,3);

					_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
				}
			}
		}else if (callerctrl.indexOf("dept") > -1 || callerctrl.indexOf("department") > -1 || callerctrl == 'crit3')	
		{
			_(childctrl1).length = 0;
			_(childctrl1).options[_(childctrl1).options.length] = new Option('Select a programme', '');		
			
			if (_(callerctrl).value == 'NA')
			{
				_(childctrl1).options[_(childctrl1).options.length] = new Option('Not applicable', 'NA');
				return;
			}

			var notice_written = 0;

			for (var i = 0; i <= _(parentctrl).length-1; i++)
			{
				if (_(parentctrl).options[i].value.substr(0,3) == _(callerctrl).value)
				{				
					cProgdesc = _(parentctrl).options[i].text;
					cProgId = _(parentctrl).options[i].value.substr(3,6);
					
					if (cProgdesc.indexOf("Ph.D.") != -1 || cProgdesc.indexOf("M. Phil.") != -1)
					{
						if (notice_written == 0 && !_("mm"))
						{
							_(childctrl1).options[_(childctrl1).options.length+1] = new Option("M. Phil. and Ph.D. candidates are screened addionally via interview", '');
							notice_written = 1;
							if (_("labell_msg2"))
							{
								caution_box("M. Phil. and Ph.D. candidates are screened addionally via interview");
							}
						}else
						{
							_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
						}
					}else
					{
						_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
					}
				}
			}
		}else if (callerctrl.indexOf("programme") > -1 || callerctrl == 'crit4')	
		{
			_(childctrl1).length = 0;
			_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');		
			
			var prev_semester = '';
			
			for (var i = 0; i <= _(parentctrl).length-1; i++)
			{
				/*if (childctrl1 == childctrl2 && (childctrl1.indexOf("crit5") > -1 || (childctrl1.indexOf("courseIdold") > -1 && _("whattodo").value == '6')))
				{
					if ((_('crit3') && _('crit3').value == _(parentctrl).options[i].value.substr(18,3)) || (_('cdeptold') && _('cdeptold').value == _(parentctrl).options[i].value.substr(18,3)))
					{
						if (prev_semester != '' && prev_semester != _(parentctrl).options[i].text.substr(0,1))
						{
							_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
							_(childctrl1).options[_(childctrl1).options.length-1].disabled = true;
						}
						
						cProgdesc = _(parentctrl).options[i].text.trim();
						cProgId = _(parentctrl).options[i].value.substr(11,6);

						var alreadyEntered = 0;
						for (j = 0; j < _(childctrl1).length; j++)
						{
							if (_(childctrl1).options[j].value == cProgId)
							{
								alreadyEntered = 1;
								break;
							}
						}

						if (alreadyEntered == 0)
						{
							_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
						}

						
						prev_semester = _(parentctrl).options[i].text.substr(0,1);
					}
				}else*/ if (_(parentctrl).options[i].value.substr(4,6).trim() == _(callerctrl).value.trim())
				{
					if (prev_semester != '' && prev_semester != _(parentctrl).options[i].text.substr(0,1))
					{
						_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
						_(childctrl1).options[_(childctrl1).options.length-1].disabled = true;
					}
					
					cProgdesc = _(parentctrl).options[i].text.trim();
					cProgId = _(parentctrl).options[i].value.substr(11,6);

					_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
					
					prev_semester = _(parentctrl).options[i].text.substr(0,1);
				}
			}

			for (i = 0; i < _(childctrl1).length; i++)
			{
				//alert(_(childctrl1).options[i].value)
			}
		}else if (callerctrl == 'cEduCtgId_loc')
		{
			_(childctrl1).length = 0;
			_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
			
			for (var i = 0; i <= _(parentctrl).length-1; i++)
			{
				if (_(parentctrl).options[i].value.substr(2,3) == _(callerctrl).value)
				{
					cProgdesc = _(parentctrl).options[i].text;
					cProgId = _(parentctrl).options[i].value;

					_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
					_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
				}
			}
		}else if (callerctrl == 'cEduCtgId1')
		{
			_(childctrl1).length = 0;
			_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
			
			for (var i = 0; i <= _(parentctrl).length-1; i++)
			{
				if (_(parentctrl).options[i].value.substr(3,3) == _(callerctrl).value)
				{
					cProgdesc = _(parentctrl).options[i].text;
					cProgId = _(parentctrl).options[i].value.substr(0,3);

					_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
				}
			}
			
			if (_("cQualCodeIdTmp").value != ''){e_qual.cQualCodeId1.value = _("cQualCodeIdTmp").value;}
		}
	}
		
    function chk_inputs()
	{
        var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }
		

		if (cust_rpt.sm.value == 1)
		{
			if (cust_rpt.whattodo.value == '1')
			{
				if (cust_rpt.study_center.value == '')
				{
					setMsgBox("labell_msg0","");
					cust_rpt.study_center.focus();
					return false;
				}
				
				if (cust_rpt.exam_type.value == '')
				{
					setMsgBox("labell_msg1","");
					cust_rpt.exam_type.focus();
					return false;
				}
			}else if (cust_rpt.whattodo.value == '2')
			{
				if (cust_rpt.dist_point.value == '')
				{
					setMsgBox("labell_msg0","Check one or more boxes to select counting reference");
					cust_rpt.centre_cnt.focus();
					return false;
				}
			}

			cust_rpt.submit();
			return;
		}else if (cust_rpt.sm.value == 2)
		{
			if (cust_rpt.whattodo.value == '6')
			{
				if (cust_rpt.cFacultyIdold.value == '')
				{
					setMsgBox("labell_msg2","");
					cust_rpt.cFacultyIdold.focus();
					return false;
				}

				if (cust_rpt.cdeptold.value == '')
				{
					setMsgBox("labell_msg3","");
					cust_rpt.cdeptold.focus();
					return false;
				}
				
				if (cust_rpt.cprogrammeIdold.value == '')
				{
					setMsgBox("labell_msg4","");
					cust_rpt.cprogrammeIdold.focus();
					return false;
				}
			}else if (cust_rpt.whattodo.value == '7a')
			{
				if (cust_rpt.cFacultyIdold.value == '' && 
				cust_rpt.cdeptold.value == '' && 
				cust_rpt.cprogrammeIdold.value == '' && 
				cust_rpt.ccourseIdold.value == '' && 
				cust_rpt.courseLevel.value == '' && 
				cust_rpt.staff_study_center.value == '')
				{
					setMsgBox("labell_msg2","Select one or more of these options");
					cust_rpt.cFacultyIdold.focus();
					return false;
				}

				if (cust_rpt.cFacultyIdold.value == '' && 
				cust_rpt.cdeptold.value == '' && 
				cust_rpt.cprogrammeIdold.value == '' && 
				cust_rpt.ccourseIdold.value == '' && 
				cust_rpt.courseLevel.value != '' && 
				cust_rpt.staff_study_center.value == '')
				{
					setMsgBox("labell_msg2","Select one or more of these options");
					cust_rpt.cFacultyIdold.focus();
					return false;
				}
			}

			//cust_rpt.target = '_blank';
			//cust_rpt.action = 'custom_report';
			cust_rpt.submit();
			return;
		}else if (cust_rpt.sm.value == 3)
		{
			if (cust_rpt.whattodo.value == '8' || cust_rpt.whattodo.value == '8a')
			{
				if (cust_rpt.whattodo.value == '8a')
				{
					if (cust_rpt.exam_type.value == '')
					{
						setMsgBox("labell_msg6","");
						cust_rpt.exam_type.focus();
						return false;
					}
				}
				
				if ((cust_rpt.date_1.value == '' && cust_rpt.date_2.value != '') || (cust_rpt.date_1.value != '' && cust_rpt.date_2.value == ''))
				{
					setMsgBox("labell_msg0","Both are either empty or filled");
					setMsgBox("labell_msg1","Both are either empty or filled");
					cust_rpt.date_1.focus();
					return false;
				}

				if ((cust_rpt.date_1.value == '' && cust_rpt.date_2.value == '') && (cust_rpt.cFacultyIdold.value == '' && cust_rpt.prog_cat_loc.value == '' && cust_rpt.courseLevel.value == ''))
				{
					setMsgBox("labell_msg2","Select option(s)");
					cust_rpt.date_1.focus();
					return false;
				}
			}else if (cust_rpt.whattodo.value == '12a')
			{
				if (cust_rpt.cFacultyIdold.value == '' && cust_rpt.courseLevel.value == '')
				{
					setMsgBox("labell_msg2","Select one or more options");
					cust_rpt.date_1.focus();
					return false;
				}
			}else if (cust_rpt.whattodo.value == '11' || cust_rpt.whattodo.value == '12')
			{
				if (cust_rpt.whattodo.value == '12')
				{
					if (cust_rpt.date_1.value == '')
					{
						setMsgBox("labell_msg0","Set date");
						cust_rpt.date_1.focus();
						return false;
					}

					if (cust_rpt.date_2.value == '')
					{
						setMsgBox("labell_msg1","Set date");
						cust_rpt.date_2.focus();
						return false;
					}
				}

				if (cust_rpt.cFacultyIdold.value == '' && cust_rpt.courseLevel.value == '')
				{
					setMsgBox("labell_msg2","Select one or more options");
					cust_rpt.cFacultyIdold.focus();
					return false;
				}
			}else if (cust_rpt.whattodo.value == '9' || cust_rpt.whattodo.value == '12a')
			{
				if (cust_rpt.whattodo.value == '9')
				{
					if ((cust_rpt.date_1.value == '' && cust_rpt.date_2.value != '') || (cust_rpt.date_1.value != '' && cust_rpt.date_2.value == ''))
					{
						setMsgBox("labell_msg0","Set a date range");
						cust_rpt.date_1.focus();
						return false;
					}
				}
				
				if (cust_rpt.cFacultyIdold.value == '' && cust_rpt.courseLevel.value == '' && cust_rpt.prog_cat_loc.value == '' && cust_rpt.date_1.value == '' && cust_rpt.date_2.value == '')
				{
					if (cust_rpt.whattodo.value == '9')
					{
						setMsgBox("labell_msg0","Select one or more options");
					}else
					{
						setMsgBox("labell_msg2","Select one or more options");
					}
					cust_rpt.cFacultyIdold.focus();
					return false;
				}
			}else if (cust_rpt.whattodo.value == '9a')
			{
				if (cust_rpt.cFacultyIdold.value == '' && cust_rpt.courseLevel.value == '' && cust_rpt.prog_cat_loc.value == '' && cust_rpt.staff_study_center.value == '')
				{
					setMsgBox("labell_msg7","Select one or more options");
					cust_rpt.staff_study_center.focus();
					return false;
				}
			}else if (cust_rpt.whattodo.value == '13' || cust_rpt.whattodo.value == '14')
			{
				if ((cust_rpt.date_1.value == '' && cust_rpt.date_2.value != '') || (cust_rpt.date_1.value != '' && cust_rpt.date_2.value == '') || (cust_rpt.date_1.value == '' && cust_rpt.date_2.value == ''))
				{
					setMsgBox("labell_msg0","Set date");
					cust_rpt.date_1.focus();
					return false;
				}
				
				if (cust_rpt.prog_cat_loc.value == '')
				{
					setMsgBox("labell_msg3","");
					cust_rpt.prog_cat_loc.focus();
					return false;
				}

				if (cust_rpt.whattodo.value == '14')
				{
					if (!cust_rpt.debit_smry1.checked && !cust_rpt.debit_smry2.checked && cust_rpt.debitype.value == '')
					{
						setMsgBox("labell_msg5","");
						cust_rpt.debitype.focus();
						return false;
					}
				}
			}else if (cust_rpt.whattodo.value == '15')
			{
				if ((cust_rpt.date_1.value == '' && cust_rpt.date_2.value != '') || (cust_rpt.date_1.value != '' && cust_rpt.date_2.value == ''))
				{
					setMsgBox("labell_msg0","Set dates");
					cust_rpt.date_1.focus();
					return false;
				}
			}else if (cust_rpt.whattodo.value == '16')
			{
				if (cust_rpt.show_chd_opt_h.value == '')
				{
					setMsgBox("labell_msg9","");
					//cust_rpt.show_chd_opt.focus();
					return false;
				}
			}
			
			if (cust_rpt.whattodo.value == '9a' && cust_rpt.crs_reg_slip.checked)
			{
				crs_reg_slip_form.whattodo.value = cust_rpt.whattodo.value;
				
				crs_reg_slip_form.faculty_disc.value = cust_rpt.faculty_disc.value;
				crs_reg_slip_form.dept_disc.value = cust_rpt.dept_disc.value;
				crs_reg_slip_form.prog_disc.value = cust_rpt.prog_disc.value;
				crs_reg_slip_form.centre_disc.value = cust_rpt.centre_disc.value;

				crs_reg_slip_form.cFacultyIdold_loc.value = cust_rpt.cFacultyIdold.value;
				crs_reg_slip_form.prog_cat_loc.value = cust_rpt.prog_cat_loc.value;
				crs_reg_slip_form.courseLevel.value = cust_rpt.courseLevel.value;
				crs_reg_slip_form.staff_study_center.value = cust_rpt.staff_study_center.value;
				

				crs_reg_slip_form.submit();
				return;
			}

			cust_rpt.submit();
			return;
		}
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
    
    <div id="smke_screen_2" class="smoke_scrn" style="display:none"></div><?php
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
            <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u ?>" />

			<div class="innercont_top" style="margin-bottom:0px;"><?php
			if(isset($_REQUEST['sm']))
			{
				if($_REQUEST['sm'] == 1)
				{
					echo 'Distributions';
				}else if($_REQUEST['sm'] == 2)
				{
					echo 'List';
				}else if($_REQUEST['sm'] == 3)
				{
					echo 'Custom';
				}
			}else
			{
				echo '';
			}?></div>
			
			<select name="cdeptId_readup" id="cdeptId_readup" style="display:none"><?php	
				$sql = "select cFacultyId, cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where cDelFlag = 'N' order by cFacultyId, cdeptId, vdeptDesc";
				$rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
				while ($rs = mysqli_fetch_array($rssql))
				{?>
					<option value="<?php echo $rs['cFacultyId']. $rs['cdeptId']?>"><?php echo $rs['vdeptDesc'];?></option><?php
				}?>
			</select>

			<select name="cprogrammeId_readup" id="cprogrammeId_readup" style="display:none"><?php	
				$sql = "select s.cdeptId, p.cProgrammeId,p.vProgrammeDesc,o.vObtQualTitle 
				from programme p, obtainablequal o, depts s
				where p.cObtQualId = o.cObtQualId 
				and s.cdeptId = p.cdeptId
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
				}?>
			</select>
			
			<select name="courseId_readup" id="courseId_readup" style="display:none"><?php	
				$sql = "SELECT concat(lpad(b.siLevel,3,'0'),' ',b.cProgrammeId,' ',a.cCourseId,' ',a.cdeptId) cCourseId, concat(a.tSemester,' ',a.iCreditUnit,' ',b.cCategory,' ',a.cCourseId,' ',a.vCourseDesc) vCourseDesc
				FROM courses_new a 
				INNER JOIN progcourse b 
				on a.cCourseId = b.cCourseId 
				INNER JOIN programme c 
				on b.cProgrammeId = c.cProgrammeId
				WHERE a.cdel = b.cdel
				AND c.cDelFlag = b.cdel
				AND c.cDelFlag = 'N'
				ORDER BY b.siLevel, a.tSemester, b.cCategory, a.cCourseId";
				$rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
				while ($rs = mysqli_fetch_array($rssql))
				{?>
					<option value="<?php echo $rs['cCourseId'];?>"><?php echo $rs['vCourseDesc']; ?></option><?php
				}
				mysqli_close(link_connect_db());?>
			</select>
			
			<form action="rpt_page_1" method="post" name="rpt_1_loc" id="rpt_1_loc" enctype="multipart/form-data">
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
				
                <input name="tabno" id="tabno" type="hidden" 
                    value="<?php if (isset($_REQUEST['tabno'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
                <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                
                <input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId_u ?>" />
                <input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdeptId_u ?>" />
                                
                <input name="cAcademicDesc" id="cAcademicDesc" type="hidden" value="<?php echo $orgsetins["cAcademicDesc"]; ?>" />
                <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester; ?>" />
				
                <input name="whattodo" id="whattodo" type="hidden" value="<?php if(isset($_REQUEST['whattodo'])){echo $_REQUEST['whattodo'];}else{echo '';}?>" />
				
                <?php frm_vars();

				require_once("rpt_requests.php");?>
			</form>

			<form action="course_reg_slip_for_press" method="post" name="crs_reg_slip_form" id="crs_reg_slip_form" target="_blank" enctype="multipart/form-data">
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
				
                <input name="tabno" id="tabno" type="hidden" 
                    value="<?php if (isset($_REQUEST['tabno'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
                <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                
                <input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId_u ?>" />
                <input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdeptId_u ?>" />
                                
                <input name="cAcademicDesc" id="cAcademicDesc" type="hidden" value="<?php echo $orgsetins["cAcademicDesc"]; ?>" />
                <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester; ?>" />
				
                <input name="whattodo" id="whattodo" type="hidden" value="<?php if(isset($_REQUEST['whattodo'])){echo $_REQUEST['whattodo'];}else{echo '';}?>" />
				<input name="faculty_disc" id="faculty_disc" type="hidden" value="<?php if (isset($_REQUEST["faculty_disc"])){echo $_REQUEST["faculty_disc"];}?>"/>
				<input name="dept_disc" id="dept_disc" type="hidden" value="<?php if (isset($_REQUEST["dept_disc"])){echo $_REQUEST["dept_disc"];}?>"/>
				<input name="prog_disc" id="prog_disc" type="hidden" value="<?php if (isset($_REQUEST["prog_disc"])){echo $_REQUEST["prog_disc"];}?>"/>
				<input name="centre_disc" id="centre_disc" type="hidden" value="<?php if (isset($_REQUEST["centre_disc"])){echo $_REQUEST["centre_disc"];}?>"/>


				<input name="cFacultyIdold_loc" id="cFacultyIdold_loc" type="hidden" value="<?php if (isset($_REQUEST["cFacultyIdold_loc"])){echo $_REQUEST["cFacultyIdold_loc"];}?>"/>
				<input name="prog_cat_loc" id="prog_cat_loc" type="hidden" value="<?php if (isset($_REQUEST["prog_cat_loc"])){echo $_REQUEST["prog_cat_loc"];}?>"/>
				<input name="courseLevel" id="courseLevel" type="hidden" value="<?php if (isset($_REQUEST["courseLevel"])){echo $_REQUEST["courseLevel"];}?>"/>
				<input name="staff_study_center" id="staff_study_center" type="hidden" value="<?php if (isset($_REQUEST["staff_study_center"])){echo $_REQUEST["staff_study_center"];}?>"/>				   
				
				<input name="crs_reg_slip_form_chk" id="crs_reg_slip_form_chk" type="hidden" value="1"/>
                <?php frm_vars();?>
			</form>
			
			<form action="custom_report" method="post" name="cust_rpt" id="cust_rpt" target="_blank" enctype="multipart/form-data">
				<input name="save_cf" id="save_cf" type="hidden" value="-1" />
				
				<input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
				
				<input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId_u ?>" />
				<input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdeptId_u ?>" />
				<input name="whattodo" id="whattodo" type="hidden" value="<?php if(isset($_REQUEST['whattodo'])){echo $_REQUEST['whattodo'];}else{echo '';}?>" />
			
				<input name="arch_mode_hd" id="arch_mode_hd" type="hidden" value="<?php if (isset($_REQUEST["arch_mode_hd"])){echo $_REQUEST["arch_mode_hd"];}?>"/>
				
			
				<input name="dist_point" id="dist_point" type="hidden" value="<?php if (isset($_REQUEST["dist_point"])){echo $_REQUEST["dist_point"];}?>"/>
			
				<input name="study_center_disc" id="study_center_disc" type="hidden" value="<?php if (isset($_REQUEST["study_center_disc"])){echo $_REQUEST["study_center_disc"];}?>"/>
				
				<input name="faculty_disc" id="faculty_disc" type="hidden" value="<?php if (isset($_REQUEST["faculty_disc"])){echo $_REQUEST["faculty_disc"];}?>"/>
				<input name="dept_disc" id="dept_disc" type="hidden" value="<?php if (isset($_REQUEST["dept_disc"])){echo $_REQUEST["dept_disc"];}?>"/>
				<input name="prog_disc" id="prog_disc" type="hidden" value="<?php if (isset($_REQUEST["prog_disc"])){echo $_REQUEST["prog_disc"];}?>"/>
				<input name="crs_disc" id="crs_disc" type="hidden" value="<?php if (isset($_REQUEST["crs_disc"])){echo $_REQUEST["crs_disc"];}?>"/>
				<input name="centre_disc" id="centre_disc" type="hidden" value="<?php if (isset($_REQUEST["centre_disc"])){echo $_REQUEST["centre_disc"];}?>"/>

				<input name="prog_cat_disc" id="prog_cat_disc" type="hidden" value="<?php if (isset($_REQUEST["prog_cat_disc"])){echo $_REQUEST["prog_cat_disc"];}?>"/>
				<input name="debitype_disc" id="debitype_disc" type="hidden" value="<?php if (isset($_REQUEST["debitype_disc"])){echo $_REQUEST["debitype_disc"];}?>"/>
				<input name="exam_type_disc" id="exam_type_disc" type="hidden" value="<?php if (isset($_REQUEST["exam_type_disc"])){echo $_REQUEST["exam_type_disc"];}?>"/>
				<input name="reg_point_disc" id="reg_point_disc" type="hidden" value="<?php if (isset($_REQUEST["reg_point_disc"])){echo $_REQUEST["reg_point_disc"];}else{echo 'Registered for the semester';}?>"/>
				<input name="bank_disc" id="bank_disc" type="hidden" value="<?php if (isset($_REQUEST["bank_disc"])){echo $_REQUEST["bank_disc"];}?>"/>
				
				<?php frm_vars();
				if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '1')
				{
					if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] == '1')
					{
						require_once("rpt_requests1.php");
					}else if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] == '2')
					{
						require_once("rpt_requests2.php");
					}
				}else if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '2')
				{
					require_once("rpt_requests3.php");
				}else if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '3')
				{
					if (isset($_REQUEST['whattodo']) && ($_REQUEST['whattodo'] == '8' || $_REQUEST['whattodo'] == '8a' || $_REQUEST['whattodo'] == '9' || $_REQUEST['whattodo'] == '9a' || $_REQUEST['whattodo'] == '11' || $_REQUEST['whattodo'] == '12' || $_REQUEST['whattodo'] == '12a' || $_REQUEST['whattodo'] == '13' || $_REQUEST['whattodo'] == '14' || $_REQUEST['whattodo'] == '15' || $_REQUEST['whattodo'] == '16'))
					{
						include("rpt_requests4.php");
					}
				}?>
			</form>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
				<img name="passprt" id="passprt" src="<?php echo get_pp_pix('');?>" width="95%" height="185" style="margin:0px;" alt="" />
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