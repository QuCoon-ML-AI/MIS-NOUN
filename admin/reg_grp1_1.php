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

$staff_can_access = 0;

$staff_study_center = '';
if (isset($_REQUEST['user_centre']) && $_REQUEST['user_centre'] <> '')
{
    $staff_study_center = $_REQUEST['user_centre'];
}

$staff_study_center_new = str_replace("|","','",$staff_study_center);
$staff_study_center_new = substr($staff_study_center_new,2,strlen($staff_study_center_new)-4);

$cFacultyId = '';
$vCityName = '';

if ($staff_study_center_new <> '')
{
	$stmt = $mysqli->prepare("SELECT cFacultyId, b.vCityName  
	from s_m_t a, studycenter b
	WHERE a.cStudyCenterId = b.cStudyCenterId
	AND a.cStudyCenterId IN ($staff_study_center_new) 
	AND a.vMatricNo = ?");
	$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);			
	$stmt->execute();
	$stmt->store_result();

	$stmt->bind_result($cFacultyId, $vCityName);
	$stmt->fetch();
	$staff_can_access = $stmt->num_rows;
	$stmt->close();
}?>

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
		var objname = '';
		var eror = 0;
		var part_fill = 0;
		var atleast_a_row_filled = 0;
		
		var numbers_letter = /^[0-9A-Za-z -]+$/;
		var letters = /^[A-Za-z ]+$/;
		var numbers = /^[NOUNSLPC0-9_]+$/;
		
		if (reg_grp1_1_loc.uvApplicationNo.value.trim() == '')
		{
			setMsgBox("labell_msg0_1","");
		}else if (!reg_grp1_1_loc.uvApplicationNo.value.match(numbers))
        {
            setMsgBox("labell_msg0_1","Invalid number");
			m_frm.uvApplicationNo.focus();
        }else if (reg_grp1_1_loc.see_all_qual.value == 1 )
		{
			reg_grp1_1_loc.submit();
		}else if (reg_grp1_1_loc.more_qual.value == 1 || reg_grp1_1_loc.edit_qual.value == 1)
		{
			var files = _("sbtd_pix").files;
			
			var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
			for (j = 0; j <= ulChildNodes.length-1; j++)
			{
				ulChildNodes[j].style.display = 'none';
			}
			
			if (_("prog_class") && _("prog_class").value == '')
			{
				setMsgBox("labell_msg1a","");
				_("prog_class1").focus();
			}else if (_("prog_class_depend") && _("prog_class_depend").value == '')
			{
				setMsgBox("labell_msg1b","");
				_("prog_class_depend1").focus();
			}else if (reg_grp1_1_loc.cQualCodeId.value == '')
			{
				setMsgBox("labell_msg0","");
				reg_grp1_1_loc.cQualCodeId.focus();
			}/*else if (_('card_users_div').style.display == 'block' && s5.vcard_pin.value == '')
			{
				setMsgBox("labell_msg1","");
				s5.vcard_pin.focus();
			}else if(_('card_users_div').style.display == 'block' && marlic(s5.vcard_pin.value)!='')
			{
				setMsgBox("labell_msg1",marlic(s5.vcard_pin.value));
				s5.vcard_pin.focus();
			}else if (_('card_users_div').style.display == 'block' && isNaN(s5.vcard_pin.value))
			{
				setMsgBox("labell_msg1","Numeric entry please");
				s5.vcard_pin.focus();
			}else if (_('vcard_sn_div').style.display == 'block' && s5.vcard_sn.value == '')
			{
				setMsgBox("labell_msg2","");
				s5.vcard_sn.focus();
			}else if(_('vcard_sn_div').style.display == 'block' && marlic(s5.vcard_sn.value)!='')
			{
				setMsgBox("labell_msg2",marlic(s5.vcard_sn.value));
				s5.vcard_sn.focus();
			}/*else if(_('vcard_sn_div').style.display == 'block' && isNaN(s5.vcard_sn.value))
			{
				setMsgBox("labell_msg2","Numeric entry please");
				s5.vcard_sn.focus();
			}*/else if (reg_grp1_1_loc.vExamNo.value.trim() == '')
			{
				setMsgBox("labell_msg3","");
				reg_grp1_1_loc.vExamNo.focus();
			}else if (!reg_grp1_1_loc.vExamNo.value.match(numbers_letter))
			{
				setMsgBox("labell_msg3","Only letters, numbers and hyphen are allowed");
				reg_grp1_1_loc.vExamNo.focus();
			}else if (reg_grp1_1_loc.vExamSchoolName.value.trim() == '')
			{
				setMsgBox("labell_msg4","");
				reg_grp1_1_loc.vExamSchoolName.focus();
			}else if (!reg_grp1_1_loc.vExamSchoolName.value.match(letters))
			{
				setMsgBox("labell_msg4","Only letters are allowed");
				reg_grp1_1_loc.vExamSchoolName.focus();
			}else if (reg_grp1_1_loc.cExamMthYear.value.length != 6 || reg_grp1_1_loc.cExamMthYear.value == '')
			{
				setMsgBox("labell_msg5","");
				reg_grp1_1_loc.cExamMthYear.focus();
			}else if (reg_grp1_1_loc.cExamMthYear.value.substr(2,4) <= _('dBirthYear').value)
			{
				setMsgBox("labell_msg5","Inconsistent year of exam and birth");
				reg_grp1_1_loc.cExamMthYear.focus();
			}else if ((reg_grp1_1_loc.credentialLoaded.value == 0 || (reg_grp1_1_loc.credentialLoaded.value == 1 && _('edit_qual').value == 1 && _('vExamNo').value != _('hdvExamNo').value)) && _("sbtd_pix").files.length == 0)
			{
				setMsgBox("labell_msg6","");
			}else if (_("sbtd_pix").files.length > 0 && !fileValidation("sbtd_pix"))
			{
				setMsgBox("labell_msg6","JPEG required");
			}else if (_("sbtd_pix").files.length > 0 && reg_grp1_1_loc.loadcred.value == 0 && files[0].size > 100000)
			{
				setMsgBox("labell_msg6","File too large. Maximum size is 100KB");
			}else
			{
				for (i = 1; i <= reg_grp1_1_loc.iQSLCount.value; i++)
				{
					if (reg_grp1_1_loc.iQSLCount.value == 9)
					{
						var elemgName = "grade1" + i;
						var elemsName = "subject1" + i;
						var messag = "labell_msg1" + i;
					}else if (reg_grp1_1_loc.iQSLCount.value == 4)
					{
						var elemgName = "grade2" + i;
						var elemsName = "subject2" + i;
						var messag = "labell_msg2" + i;
					}else if (reg_grp1_1_loc.iQSLCount.value == 1)
					{
						var elemgName = "grade3" + i;
						var elemsName = "subject3" + i;
						var messag = "labell_msg3" + i;
					}

					if (_(elemsName).value == '' && _(elemgName).value != '')
					{
						part_fill = 1;
						eror = 1;
						setMsgBox(messag,"Subject required");
						_(elemsName).focus();
						return;
					}else if (_(elemsName).value != '' && _(elemgName).value == '')
					{
						part_fill = 1;
						eror = 1;
						setMsgBox(messag,"Grade required");
						_(elemgName).focus();
						return;
					}else if (_(elemgName).value == '' && _(elemsName).value == '' && atleast_a_row_filled == 0)
					{
						part_fill = 1;
						eror = 1;
						setMsgBox(messag,"Blank row not allowed");
						_(elemsName).focus();
						return;
					}else
					{
						for (j = 1; j <= reg_grp1_1_loc.iQSLCount.value; j++)
						{
							if (reg_grp1_1_loc.iQSLCount.value == 9)
							{
								var elemsName_j = "subject1" + j;
								var messag_j = "labell_msg1" + j;
							}else if (reg_grp1_1_loc.iQSLCount.value == 4)
							{
								var elemsName_j = "subject2" + j;
								var messag_j = "labell_msg2" + j;
							}else if (reg_grp1_1_loc.iQSLCount.value == 1)
							{
								var elemsName_j = "subject3" + j;
								var messag_j = "labell_msg3" + j;
							}
							
							for (k = (j+1); k <= reg_grp1_1_loc.iQSLCount.value; k++)
							{
								if (reg_grp1_1_loc.iQSLCount.value == 9)
								{
									var elemsName_k = "subject1" + k;
									var messag_k = "labell_msg1" + k;
								}else if (reg_grp1_1_loc.iQSLCount.value == 4)
								{
									var elemsName_k = "subject2" + k;
									var messag_k = "labell_msg2" + k;
								}else if (reg_grp1_1_loc.iQSLCount.value == 1)
								{
									var elemsName_k = "subject3" + k;
									var messag_k = "labell_msg3" + k;
								}

								if (j != k && _(elemsName_j).value != '' && _(elemsName_k).value != '' && _(elemsName_j).value == _(elemsName_k).value)
								{
									eror = 1;
									setMsgBox(messag_j,"Subject repeatetion not allowed");
									setMsgBox(messag_k,"Subject repeatetion not allowed");
									return;
								}
								atleast_a_row_filled++;
							}
						}
					}
				}
				
				if (eror == 0)
				{									
					alert('Credential will be verified accordingly');
					//verify olevel result from examination body
					
					reg_grp1_1_loc.submit();

					//opr_prep(ajax = new XMLHttpRequest(),formdata);
				}
			}
		}else
		{
			var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
			for (j = 0; j <= ulChildNodes.length-1; j++)
			{
				ulChildNodes[j].style.display = 'none';
			}
			reg_grp1_1_loc.loadcred.value = 0;
		}
	}

    function centre_select()
    {
        return true;

        if (_("user_centre_loc").value == '')
        {
            //_("succ_boxt").style.display = "block";
            //_("succ_boxt").innerHTML = "Please select a study centre";
            //_("succ_boxt").style.display = "block";
            return false;
        }

        if (_("service_mode_loc").value == '')
        {
            //_("succ_boxt").style.display = "block";
            //_("succ_boxt").innerHTML = "Please select a service mode";
            //_("succ_boxt").style.display = "block";
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
	</form>
	
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
	//time_out_box($currency);
	
	$cEduCtgId = '';
	if (isset($_REQUEST["cEduCtgId"])){$cEduCtgId = $_REQUEST["cEduCtgId"];}
	
	$iQSLCount = '';	
	$cQualCodeId_01 = '';	
	$vQualCodeDesc = '';	

	$vExamNo = '';
	$vcard_pin = '';
	$vcard_sn = '';	
	
	$vExamSchoolName = '';
	$cExamMthYear = '';
	
	$vcard_pin_01 = ''; 
	$vcard_sn_01 = '';
	$vExamNo_01 = '';
	$vExamSchoolName_01 = '';
	$cExamMthYear_01 = '';

	$credent_loaded = 0;

	$number_of_cat_selected = 0;

	$error= 0;
		
	$vcard_pin_dis = 'none';
	$vcard_sn_dis = 'none';

	$vMatricNo = '';
	
	if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
	{
		$vMatricNo = $_REQUEST["uvApplicationNo"];
	}else if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> '')
	{
		$vMatricNo =  trim($_REQUEST["uvApplicationNo"]);
	}

	$stmt = $mysqli->prepare("SELECT vApplicationNo 
	FROM s_m_t 
	WHERE vMatricNo = ?");
	$stmt->bind_param("s", $vMatricNo);
	
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($vApplicationNo);
	$stmt->fetch();
	$stmt->close(); 
	
	$passpotLoaded = passport_loaded($vApplicationNo);

	//add new qual
	if ((isset($_REQUEST['more_qual']) && $_REQUEST['more_qual'] == '1') && (isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1'))
	{
		if ($_REQUEST['hdcQualCodeId'] == '')
		{
			$stmt = $mysqli->prepare("SELECT * FROM applyqual_stff WHERE vMatricNo = ? AND (cQualCodeId <> ? OR vExamNo <> ?) AND cExamMthYear = ? AND cDelFlag = 'N'");
			$stmt->bind_param("ssss", $vMatricNo, $_REQUEST["cQualCodeId"], $_REQUEST["vExamNo"], $_REQUEST['cExamMthYear']);
			$stmt->execute();
			$stmt->store_result();
			if($stmt->num_rows > 0) 
			{
				caution_box('A certificate with this date already exist');
				$error = 1;
			}
			$stmt->close();
			
			if ($error == 0)
			{
				$stmt = $mysqli->prepare("SELECT * FROM applyqual_stff WHERE vMatricNo = ? and cQualCodeId = ? and vExamNo = ? AND cDelFlag = 'N'");
				$stmt->bind_param("sss", $vMatricNo, $_REQUEST["cQualCodeId"], $_REQUEST["vExamNo"]);
				$stmt->execute();
				$stmt->store_result();
				if($stmt->num_rows > 0) 
				{
					caution_box('Qualification already exist');
					$error = 1;
				}
				$stmt->close();
			}
		}

		if ($error == 0 && $_REQUEST['cQualCodeId'] <> $_REQUEST['hdcQualCodeId'] && $_REQUEST['hdcQualCodeId'] <> '')
		{
			$stmt = $mysqli->prepare("SELECT * FROM applyqual_stff WHERE vMatricNo = ? and cQualCodeId = ? and vExamNo = ? AND cDelFlag = 'N'");
			$stmt->bind_param("sss", $vMatricNo, $_REQUEST["cQualCodeId"], $_REQUEST["vExamNo"]);
			$stmt->execute();
			$stmt->store_result();
			if($stmt->num_rows > 0) 
			{
				caution_box('A qualification with this examination number already exists');
				$error = 1;
			}
			$stmt->close();
		}

		if ($error == 0 && substr($_REQUEST['cQualCodeId'], 0, 1) == '2' /*&& $_REQUEST['cQualCodeId'] <> $_REQUEST['hdcQualCodeId']*/)
		{
			$stmt = $mysqli->prepare("SELECT * FROM applyqual_stff WHERE vMatricNo = ? and cQualCodeId like '2%' AND cDelFlag = 'N'");
			$stmt->bind_param("s", $vMatricNo);
			$stmt->execute();
			$stmt->store_result();
			if(($stmt->num_rows  + 1) > 2) 
			{
				caution_box('You can only enter a maximum of two (2) O\'Level qualifications');
				$error = 1;
			}
			$stmt->close();
		}

		if ($error == 0)
		{
			try
			{
				$mysqli->autocommit(FALSE);

				if (isset($_FILES['sbtd_pix']) && $_FILES['sbtd_pix']['name'] <> '')
				{
					//clearstatcache();

					$base_path = "../../ext_docs/pics/$cFacultyId/cc/";

					$flname = $base_path.$_REQUEST["hdcQualCodeId"]."_".addslashes($_REQUEST["hdvExamNo"])."_".$vApplicationNo.".jpg";
					if (file_exists($flname))
					{
						@unlink($flname);
					}			
			
					$flname = $base_path.$_REQUEST["cQualCodeId"]."_".addslashes($_REQUEST["vExamNo"])."_".$vApplicationNo.".jpg";
			
					if (!move_uploaded_file($_FILES['sbtd_pix']['tmp_name'], $base_path . $_FILES['sbtd_pix']['name']))
					{
						echo  "Upload failed, please try again"; exit;
					}
					rename($base_path . $_FILES['sbtd_pix']['name'], $flname);
					chmod($flname, 0755);			
			
					$stmt = $mysqli->prepare("DELETE FROM pics WHERE vApplicationNo = ? AND cinfo_type = 'c' AND cQualCodeId = ? AND vExamNo = ?");
					$stmt->bind_param("sss", $vApplicationNo, $_REQUEST['hdcQualCodeId'], $_REQUEST['hdvExamNo']);
					$stmt->execute();
					$stmt->close();
			
					$stmt = $mysqli->prepare("REPLACE INTO pics (vApplicationNo, cinfo_type, cQualCodeId, vExamNo) VALUES (?, 'C', ?, ?)");
					$stmt->bind_param("sss", $vApplicationNo, $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo']);
					$stmt->execute();
					$stmt->close();
					
					log_actv('Uploaded scanned copy of academic certificate  for '.$_REQUEST['cQualCodeId']. ' '.$_REQUEST['vExamNo']);
				}
			
				$stmt = $mysqli->prepare("DELETE FROM applyqual_stff WHERE vMatricNo = ? and cQualCodeId = ? and vExamNo = ?");
				$stmt->bind_param("sss", $vMatricNo, $_REQUEST['hdcQualCodeId'], $_REQUEST['hdvExamNo']);
				$stmt->execute();
				$stmt->close();
			
				$stmt = $mysqli->prepare("DELETE FROM applyqual_stff WHERE vMatricNo = ? and cQualCodeId = ? and vExamNo = ?");
				$stmt->bind_param("sss", $vMatricNo, $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo']);
				$stmt->execute();
				$stmt->close();


				$stmt = $mysqli->prepare("REPLACE INTO applyqual_stff (vMatricNo, cQualCodeId, vExamNo, vExamSchoolName, vcard_pin, vcard_sn, cExamMthYear) VALUES (?, ?, ?, ?, ?, ?, ?)");
				$stmt->bind_param("sssssss", $vMatricNo, $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo'], $_REQUEST['vExamSchoolName'], $_REQUEST['vcard_pin'], $_REQUEST['vcard_sn'], $_REQUEST['cExamMthYear']);
				$stmt->execute();
				$stmt->close();			
				
				$stmt = $mysqli->prepare("DELETE FROM applysubject_stff WHERE vMatricNo = ? and cQualCodeId = ? and vExamNo = ?");
				$stmt->bind_param("sss", $vMatricNo, $_REQUEST['hdcQualCodeId'], $_REQUEST['hdvExamNo']);
				$stmt->execute();
				$stmt->close();
				
				$stmt = $mysqli->prepare("DELETE FROM applysubject_stff WHERE vMatricNo = ? and cQualCodeId = ? and vExamNo = ?");
				$stmt->bind_param("sss", $vMatricNo, $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo']);
				$stmt->execute();
				$stmt->close();
				
				if ($_REQUEST["iQSLCount"] == 9)
				{
					$subject = "subject1";
					$grade = "grade1";
				}else if ($_REQUEST["iQSLCount"] == 4)
				{
					$subject = "subject2";
					$grade = "grade2";
				}else
				{
					$subject = "subject3";
					$grade = "grade3";
				}

				$stmt1 = $mysqli->prepare("REPLACE INTO applysubject_stff (vMatricNo, cQualCodeId, vExamNo, cQualSubjectId, cQualGradeId) VALUES (?, ?, ?, ?, ?)");

				$stmt2 = $mysqli->prepare("SELECT iQualGradeRank FROM qualgrade WHERE cQualGradeId = ?");
		

				for ($t = 1; $t <= $_REQUEST["iQSLCount"]; $t++)
				{
					if (isset($_REQUEST[$subject.$t]) && $_REQUEST[$subject.$t] <> '' /*&& isset($_REQUEST[$grade.$t]) && $_REQUEST[$grade.$t] <> ''*/)
					{
						$stmt1->bind_param("sssss", $vMatricNo, $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo'], $_REQUEST[$subject.$t], $_REQUEST[$grade.$t]);
						$stmt1->execute();

						log_actv('Saved subject area of academic qualification for '.$vMatricNo.', '.$_REQUEST['cQualCodeId'].', '.$_REQUEST['vExamNo'].', '.$_REQUEST[$subject.$t].', '.$_REQUEST[$grade.$t]);

						$stmt2->bind_param("s",$_REQUEST[$grade.$t]);
						$stmt2->execute();
						$stmt2->store_result();
						$stmt2->bind_result($iQualGradeRank);
						if($stmt2->num_rows === 0){continue;};
						$stmt2->fetch();
					}
				}
				$stmt1->close();
				$stmt2->close();
						
				$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				
				success_box('Record saved successfully');
			}catch(Exception $e)
			{
			$mysqli->rollback(); //remove all queries from queue if error (undo)
			throw $e;
			}
		}
	}

	//edit qual
	if (isset($_REQUEST['edit_qual']) && $_REQUEST['edit_qual'] == '1' && isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1')
	{
		if ($_REQUEST["cQualCodeId"] <> $_REQUEST["hdcQualCodeId"])
		{
			
			$stmt = $mysqli->prepare("SELECT * FROM applyqual_stff WHERE vMatricNo = ? AND (cQualCodeId <> ? OR vExamNo <> ?) AND cExamMthYear = ? AND cDelFlag = 'N'");
			$stmt->bind_param("ssss", $vMatricNo, $_REQUEST["cQualCodeId"], $_REQUEST["vExamNo"], $_REQUEST['cExamMthYear']);
			$stmt->execute();
			$stmt->store_result();
			if($stmt->num_rows > 0) 
			{
				caution_box('A certificate with this date already exists');
				$error = 1;
			}
			$stmt->close();

			if ($error == 0)
			{
				$stmt = $mysqli->prepare("SELECT * FROM applyqual_stff WHERE vMatricNo = ? AND cQualCodeId <> ? AND vExamNo = ?");
				$stmt->bind_param("sss", $vMatricNo, $_REQUEST["cQualCodeId"], $_REQUEST["vExamNo"]);
				$stmt->execute();
				$stmt->store_result();
				if($stmt->num_rows > 0) 
				{
					caution_box('A certificate with this candidate number already exist');
					$error = 1;
				}
				$stmt->close();
			}

			if ($error == 0)
			{
				$stmt = $mysqli->prepare("SELECT * FROM applyqual_stff WHERE vMatricNo = ? and cQualCodeId = ? and vExamNo = ? AND cDelFlag = 'N'");
				$stmt->bind_param("sss", $vMatricNo, $_REQUEST["cQualCodeId"], $_REQUEST["vExamNo"]);
				$stmt->execute();
				$stmt->store_result();
				if($stmt->num_rows > 0) 
				{
					caution_box('Qualification already exist');
					$error = 1;
				}
				$stmt->close();
			}
		}


		if ($error == 0)
		{
			try
			{
				$mysqli->autocommit(FALSE);

				if (isset($_FILES['sbtd_pix']) && $_FILES['sbtd_pix']['name'] <> '')
				{
					$base_path = "../../ext_docs/pics/$cFacultyId/cc/";

					$flname = $base_path.$_REQUEST["hdcQualCodeId"]."_".addslashes($_REQUEST["hdvExamNo"])."_".$vApplicationNo.".jpg";
					if (file_exists($flname))
					{
						@unlink($flname);
					}			
			
					$flname = $base_path.$_REQUEST["cQualCodeId"]."_".addslashes($_REQUEST["vExamNo"])."_".$vApplicationNo.".jpg";
			
					if (!move_uploaded_file($_FILES['sbtd_pix']['tmp_name'], $base_path . $_FILES['sbtd_pix']['name']))
					{
						echo  "Upload failed, please try again"; exit;
					}
					rename($base_path . $_FILES['sbtd_pix']['name'], $flname);
					chmod($flname, 0755);			
			
					$stmt = $mysqli->prepare("DELETE FROM pics WHERE vApplicationNo = ? AND cinfo_type = 'c' AND cQualCodeId = ? AND vExamNo = ?");
					$stmt->bind_param("sss", $vApplicationNo, $_REQUEST['hdcQualCodeId'], $_REQUEST['hdvExamNo']);
					$stmt->execute();
					$stmt->close();
			
					$stmt = $mysqli->prepare("REPLACE INTO pics (vApplicationNo, cinfo_type, cQualCodeId, vExamNo) VALUES (?, 'C', ?, ?)");
					$stmt->bind_param("sss", $vApplicationNo, $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo']);
					$stmt->execute();
					$stmt->close();
				
					log_actv('Re-uploaded scanned copy of academic certificate for '.$_REQUEST['cQualCodeId']. ' '.$_REQUEST['vExamNo']);
				}
			
				$stmt = $mysqli->prepare("DELETE FROM applyqual_stff WHERE vMatricNo = ? and cQualCodeId = ? and vExamNo = ?");
				$stmt->bind_param("sss", $vMatricNo, $_REQUEST['hdcQualCodeId'], $_REQUEST['hdvExamNo']);
				$stmt->execute();
				$stmt->close();
			
				$stmt = $mysqli->prepare("REPLACE INTO applyqual_stff (vMatricNo, cQualCodeId, vExamNo, vExamSchoolName, vcard_pin, vcard_sn, cExamMthYear) VALUES (?, ?, ?, ?, ?, ?, ?)");
				$stmt->bind_param("sssssss", $vMatricNo, $_REQUEST['hdcQualCodeId'], $_REQUEST['vExamNo'], $_REQUEST['vExamSchoolName'], $_REQUEST['vcard_pin'], $_REQUEST['vcard_sn'], $_REQUEST['cExamMthYear']);
				$stmt->execute();
				$stmt->close();			
				
				$stmt = $mysqli->prepare("DELETE FROM applysubject_stff WHERE vMatricNo = ? and cQualCodeId = ? and vExamNo = ?");
				$stmt->bind_param("sss", $vMatricNo, $_REQUEST['hdcQualCodeId'], $_REQUEST['hdvExamNo']);
				$stmt->execute();
				$stmt->close();
								
				if ($_REQUEST["iQSLCount"] == 9)
				{
					$subject = "subject1";
					$grade = "grade1";
				}else if ($_REQUEST["iQSLCount"] == 4)
				{
					$subject = "subject2";
					$grade = "grade2";
				}else
				{
					$subject = "subject3";
					$grade = "grade3";
				}

				$stmt1 = $mysqli->prepare("REPLACE INTO applysubject_stff (vMatricNo, cQualCodeId, vExamNo, cQualSubjectId, cQualGradeId) VALUES (?, ?, ?, ?, ?)");

				$stmt2 = $mysqli->prepare("SELECT iQualGradeRank FROM qualgrade WHERE cQualGradeId = ?");
		

				for ($t = 1; $t <= $_REQUEST["iQSLCount"]; $t++)
				{
					if (isset($_REQUEST[$subject.$t]) && $_REQUEST[$subject.$t] <> '' /*&& isset($_REQUEST[$grade.$t]) && $_REQUEST[$grade.$t] <> ''*/)
					{
						$stmt1->bind_param("sssss", $vMatricNo, $_REQUEST['hdcQualCodeId'], $_REQUEST['vExamNo'], $_REQUEST[$subject.$t], $_REQUEST[$grade.$t]);
						$stmt1->execute();

						log_actv('Updated subject area of academic qualification for '.$vMatricNo.', '.$_REQUEST['cQualCodeId'].', '.$_REQUEST['vExamNo'].', '.$_REQUEST[$subject.$t].', '.$_REQUEST[$grade.$t]);

						$stmt2->bind_param("s",$_REQUEST[$grade.$t]);
						$stmt2->execute();
						$stmt2->store_result();
						$stmt2->bind_result($iQualGradeRank);
						if($stmt2->num_rows === 0){continue;}
						$stmt2->fetch();
					}
				}
				$stmt1->close();
				$stmt2->close();
			
				log_actv('Updated academic qualification for '. $vMatricNo);
			
				$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
				
				success_box('Record updated successfully');
			}catch(Exception $e)
			{
			$mysqli->rollback(); //remove all queries from queue if error (undo)
			throw $e;
			}
		}
	}


	if (isset($_REQUEST['del_qual']) && $_REQUEST['del_qual'] == '1')
	{
		try
		{
			$mysqli->autocommit(FALSE); //turn on transactions
			$stmt = $mysqli->prepare("UPDATE applyqual_stff SET cDelFlag = 'Y' where cQualCodeId = ? and vExamNo = ? and vMatricNo = ?");
			$stmt->bind_param("sss", $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo'], $vMatricNo);
			$stmt->execute();
			$stmt->close();

			$stmt = $mysqli->prepare("UPDATE applysubject_stff  SET cDelFlag = 'Y' WHERE cQualCodeId = ? and vExamNo = ? and vMatricNo = ?");
			$stmt->bind_param("sss", $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo'], $vMatricNo);
			$stmt->execute();
			$stmt->close();

			$stmt = $mysqli->prepare("delete from pics where cQualCodeId = ? and vExamNo = ? and vApplicationNo = ?");
			$stmt->bind_param("sss", $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo'], $vMatricNo);
			//$stmt->execute();
			$stmt->close();

			$base_path = "../../ext_docs/pics/$cFacultyId/cc/";

			$flname = $base_path.$_REQUEST["cQualCodeId"]."_".addslashes($_REQUEST["vExamNo"])."_".$vApplicationNo.".jpg";
			if (file_exists($flname))
			{
				@unlink($flname);
			}

			log_actv('deleted credential with code '.$_REQUEST['cQualCodeId'].' exam number '.$_REQUEST['vExamNo']);
			
			$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
			success_box('Credential deleted successfully');
		}catch(Exception $e) 
		{
			$mysqli->rollback(); //remove all queries from queue if error (undo)
			throw $e;
		}
	}
	
	$cEduCtgId_01 = '';
	$iQSLCount_01 = 0;
	
	if (isset($vMatricNo) && $vMatricNo <> '' && (!isset($_REQUEST['h_more_qual']) && !(isset($_REQUEST['more_qual']) && $_REQUEST['more_qual'] == '1') && !(isset($_REQUEST['see_qual']) && $_REQUEST['see_qual'] == '1') && !(isset($_REQUEST['edit_qual']) && $_REQUEST['edit_qual'] == '1')))
	{
		$stmt = $mysqli->prepare("SELECT a.cQualCodeId, c.cEduCtgId, iQSLCount, vExamNo, vExamSchoolName, cExamMthYear, vcard_pin, vcard_sn 
		from applyqual_stff a, qualification b, educationctg c 
		where a.cQualCodeId = b.cQualCodeId and c.cEduCtgId = b.cEduCtgId and vMatricNo = ? and a.cQualCodeId = ? and vExamNo = ?  AND a.cDelFlag = 'N' order by right(cExamMthYear,4), left(cExamMthYear,2)");
		$stmt->bind_param("sss", $vMatricNo, $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo']);
		
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($cQualCodeId_01, $cEduCtgId_01, $iQSLCount_01, $vExamNo_01, $vExamSchoolName_01, $cExamMthYear_01, $vcard_pin_01, $vcard_sn_01);
		$stmt->fetch();
		
		if ($cQualCodeId_01 == '201' || $cQualCodeId_01 == '202' || $cQualCodeId_01 == '203' || $cQualCodeId_01 == '204')
		{
			$vcard_pin_dis = 'block';
			$vcard_sn_dis = 'block';
		}
		$stmt->close();
		
		$credent_loaded = credential_loaded($vApplicationNo, $cQualCodeId_01, $vExamNo_01);
	}else if (isset($_REQUEST['cQualCodeId']) && $_REQUEST['cQualCodeId'] <> '' && isset($_REQUEST['cEduCtgId']) && $_REQUEST['cEduCtgId'] <> '' && !(isset($_REQUEST['more_qual']) && $_REQUEST['more_qual'] == '1') && !(isset($_REQUEST['see_qual']) && $_REQUEST['see_qual'] == '1') && !(isset($_REQUEST['del_qual'])&&$_REQUEST['del_qual']=='1') && !(isset($_REQUEST['edit_qual']) && $_REQUEST['edit_qual'] == '1'))
	{
		$credent_loaded = credential_loaded($vApplicationNo, $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo']);

		$cEduCtgId_01 = $_REQUEST['cEduCtgId'];
		$vExamNo_01 = $_REQUEST['vExamNo'];
		$cQualCodeId_01 = $_REQUEST['cQualCodeId'];
		$vExamSchoolName_01 = $_REQUEST['vExamSchoolName'];
		$cExamMthYear_01 = $_REQUEST['cExamMthYear'];
		$iQSLCount_01 = $_REQUEST['iQSLCount'];
	}else if ((isset($_REQUEST['more_qual']) && $_REQUEST['more_qual'] == '1') || (isset($_REQUEST['edit_qual']) && $_REQUEST['edit_qual'] == '1'))
	{
		$stmt = $mysqli->prepare("SELECT b.cEduCtgId, c.iQSLCount 
		FROM qualification b, educationctg c 
		WHERE c.cEduCtgId = b.cEduCtgId
		AND b.cQualCodeId =?");
		$stmt->bind_param("s", $_REQUEST['cQualCodeId']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($cEduCtgId_01, $iQSLCount_01);
		$stmt->fetch();
		$stmt->close();
		$cQualCodeId_01 = $_REQUEST['cQualCodeId'];

		if (isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1')
		{
			$cEduCtgId_01 = $_REQUEST['cEduCtgId'];
			$vExamNo_01 = $_REQUEST['vExamNo'];
			if (isset($_REQUEST['edit_qual']) && $_REQUEST['edit_qual'] == '1')
			{
				$cQualCodeId_01 = $_REQUEST['hdcQualCodeId'];
			}else
			{
				$cQualCodeId_01 = $_REQUEST['cQualCodeId'];
			}
			$vExamSchoolName_01 = $_REQUEST['vExamSchoolName'];
			$cExamMthYear_01 = $_REQUEST['cExamMthYear'];
			$iQSLCount_01 = $_REQUEST['iQSLCount'];

			if ($cQualCodeId_01 == '201' || $cQualCodeId_01 == '202' || $cQualCodeId_01 == '203' || $cQualCodeId_01 == '204')
			{
				$vcard_pin_dis = 'block';
				$vcard_sn_dis = 'block';
			}
		}
	}else if (isset($_REQUEST['see_qual']) && $_REQUEST['see_qual'] == '1')
	{
		$stmt = $mysqli->prepare("SELECT c.cEduCtgId, iQSLCount, vExamNo, vExamSchoolName, cExamMthYear, vcard_pin, vcard_sn 
		from applyqual_stff a, qualification b, educationctg c 
		where a.cQualCodeId = b.cQualCodeId 
		AND c.cEduCtgId = b.cEduCtgId 
		AND vMatricNo = ? 
		AND a.cQualCodeId = ?
		AND a.vExamNo = ?
		AND a.cDelFlag = 'N'
		ORDER BY right(cExamMthYear,4), left(cExamMthYear,2) LIMIT 1");
		$stmt->bind_param("sss", $vMatricNo, $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo']);

		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($cEduCtgId_01, $iQSLCount_01, $vExamNo_01, $vExamSchoolName_01, $cExamMthYear_01, $vcard_pin_01, $vcard_sn_01);
		$stmt->fetch();
		$stmt->close();
		$cQualCodeId_01 = $_REQUEST['cQualCodeId'];

		$credent_loaded = credential_loaded($vApplicationNo, $cQualCodeId_01, $vExamNo_01);
	}?>

	<div id="conf_box_loc" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
		<div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Confirmation
		</div>
		<a href="#" style="text-decoration:none;">
			<div style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
			Delete selected qualification?
		</div>
		<div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
			<a href="#" style="text-decoration:none;" 
				onclick="reg_grp1_1_loc.del_qual.value='1';
				reg_grp1_1_loc.save_cf.value='1';
				reg_grp1_1_loc.submit();
				return false">
				<div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
					Yes
				</div>
			</a>

			<a href="#" style="text-decoration:none;" 
				onclick="_('conf_box_loc').style.display='none';
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

	<div id="container_cover_in" 
		style="background:#FFFFFF;
		left:5px;
		top:5px;
		height:97%;
		width:500px; 
		float:left;
		box-shadow: 4px 4px 3px #888888;
		display:<?php if (isset($_REQUEST['see_qual']) && $_REQUEST['see_qual'] == '1'){echo 'block';}else{echo 'none';}?>; 
		position:absolute;
		text-align:center; 
		padding:5px;
		border: 1px solid #696969;
		opacity: 0.9;
		z-Index:2;
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
						<img style="width:15px; height:15px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>"/>
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
				display:block;">
				<img id="credential_img" style="width:100%; height:100%" 
					src="<?php echo get_cert_pix($vApplicationNo);?>"/>
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
	<div id="rtlft_std" style="position:relative; overflow:scroll; overflow-x: hidden;">
		<!-- InstanceBeginEditable name="EditRegion6" -->			
			
			<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
            
            <div id="top_div" class="innercont_top"><?php
				if (isset($_REQUEST['more_qual']) && $_REQUEST['more_qual'] == 1)
				{
					echo 'Adding new credential';
				}else if (isset($_REQUEST['edit_qual']) && $_REQUEST['edit_qual'] == 1)
				{
					echo 'Editing credential';
				}else
				{
					echo 'Update student credentials';
				}?>
			</div><?php
			if (check_scope2('SPGS', 'SPGS menu') > 0)
			{?>
				<a href="#" style="text-decoration:none;" 
					onclick="pg_environ.mm.value=8;pg_environ.sm.value='';pg_environ.submit();return false;">
					<div class="rtlft_inner_button" style="position:absolute; right:0; top:25px; padding:10px;width:auto; height:auto">
						SPGS menu
					</div>
				</a><?php
			}?>
            
			<form action="registration-module-one-one" method="post" name="reg_grp1_1_loc" enctype="multipart/form-data">
				<input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
				<input name="vMatricNo" id="vMatricNo" type="hidden" 
					value="<?php if (isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> ''){echo $_REQUEST['vMatricNo']; }
					else if (isset($_REQUEST['uvApplicationNo']) && $_REQUEST['uvApplicationNo'] <> ''){echo $_REQUEST['uvApplicationNo']; }?>" />
				
				<input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
				<input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />

				<input name="tDeedTime" type="hidden" value="<?php if (isset($GLOBALS['tDeedTime'])){echo $GLOBALS['tDeedTime'];}?>" />
				<input name="cFacultyId" id="cFacultyId" type="hidden" value="<?php if (isset($GLOBALS['cFacultyId'])){echo $GLOBALS['cFacultyId'];} ?>" />
				<input name="cdept" id="cdept" type="hidden" value="<?php if (isset($GLOBALS['cdept'])){echo $GLOBALS['cdept'];} ?>" />
				<input name="vFacultyDesc" id="vFacultyDesc" type="hidden" value="<?php if (isset($GLOBALS['vFacultyDesc'])){echo $GLOBALS['vFacultyDesc'];} ?>" />
				<input name="vdeptDesc" id="vdeptDesc" type="hidden" value="<?php if (isset($GLOBALS['vdeptDesc'])){echo $GLOBALS['vdeptDesc'];} ?>" />
				
				<input name="vObtQualTitle" id="vObtQualTitle" type="hidden" value="<?php if (isset($GLOBALS['vObtQualTitle'])){echo $GLOBALS['vObtQualTitle'];} ?>" />
								
				<input name="prog_cat" id="prog_cat" type="hidden" value="<?php if (isset($GLOBALS['prog_cat'])){echo $GLOBALS['prog_cat'];} ?>" />
				<input name="cProgrammeId" id="cProgrammeId" type="hidden" value="<?php if (isset($GLOBALS['cProgrammeId'])){echo $GLOBALS['cProgrammeId'];} ?>" />
				<input name="vProgrammeDesc" type="hidden" value="<?php if (isset($GLOBALS['vProgrammeDesc'])){echo $GLOBALS['vProgrammeDesc'];} ?>" />				
				
				<input name="loadcred" id="loadcred" type="hidden" value="0" />
				<input name="more_qual" id="more_qual" type="hidden" value="<?php if (isset($_REQUEST['more_qual'])){echo $_REQUEST['more_qual'];} ?>" />
				<input name="edit_qual" id="edit_qual" type="hidden" value="<?php if (isset($_REQUEST['edit_qual'])){echo $_REQUEST['edit_qual'];} ?>" />
				<input name="see_qual" id="see_qual" type="hidden" value="0" />
				<input name="del_qual" id="del_qual" type="hidden" value="0" />
				<input name="see_all_qual" id="see_all_qual" type="hidden" value="0" />
				
				<input name="study_mode" id="study_mode" type="hidden" value="odl" />				
				
				<input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php echo $cEduCtgId_01;?>" />
				<input name="vEduCtgDesc" id="vEduCtgDesc" type="hidden" value="" />	
				
				<input name="iQSLCount" id="iQSLCount" type="hidden" value="<?php echo $iQSLCount_01;?>" />
				<input name="cEduCtgId_app" type="hidden" value="<?php echo $cEduCtgId_01;?>" />
				<input name="credentialLoaded" id="credentialLoaded" type="hidden" value="<?php echo $credent_loaded;?>"/>

				<input name="h_more_qual" id="h_more_qual" type="hidden" value="<?php if (isset($_REQUEST["h_more_qual"])){echo $_REQUEST["h_more_qual"];}?>"/>
				<input name="clked_btn_no" type="hidden"/>
	
				<input name="service_mode" id="service_mode" type="hidden" 
				value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
				else if (isset($service_mode)){echo $service_mode;}?>" />

				<input name="num_of_mode" id="num_of_mode" type="hidden" 
				value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
				else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

				<input name="user_centre" id="user_centre" type="hidden" 
				value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
				else if (isset($service_centre)){echo $service_centre;}?>" />

				<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
				value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
				else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
				
				<input name="sm" type="hidden" value="<?php if (isset($GLOBALS['sm'])){echo $GLOBALS['sm'];} ?>" />
				<input name="mm" type="hidden" value="<?php if (isset($GLOBALS['mm'])){echo $GLOBALS['mm'];} ?>" />

				<input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
                <input name="vMatricNo" type="hidden" 
					value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> '')
					{
						echo $_REQUEST["vMatricNo"];
					}else if (isset($_REQUEST['uvApplicationNo']))
					{
						echo trim($_REQUEST["uvApplicationNo"]);
					}?>" />
                <input name="credentialNo" id="credentialNo" type="hidden" value="0" />	
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                <input name="tabno" id="tabno" type="hidden" 
                    value="<?php if (isset($_REQUEST['tabno'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
                
                <input name="frm_upd" id="frm_upd" type="hidden" />
                <input name="loadcred" id="loadcred" type="hidden" value="0" />
                <div id="succ_boxt" class="succ_box blink_text orange_msg" style="width:auto"></div>
                
                <div class="innercont_stff" style="margin-bottom:3px; padding-top:3px">
                    <label for="uvApplicationNo" class="labell" style="width:250px; margin-left:7px;">Matriculation number</label>
                    <div class="div_select">
                        <input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox" 
							style="text-transform:none;" value="<?php echo $_REQUEST['uvApplicationNo']; ?>"
							onBlur="if (this.value.trim()!='')
							{
								if (_('sub_box')){_('sub_box').style.display='block'}
								if (reg_grp1_1_loc.more_qual.value != 1 && reg_grp1_1_loc.see_qual.value != 1 && reg_grp1_1_loc.edit_qual.value != 1)
								{
									reg_grp1_1_loc.see_all_qual.value = 1;
								}else if (reg_grp1_1_loc.more_qual.value == 1 || reg_grp1_1_loc.edit_qual.value == 1)
								{
									reg_grp1_1_loc.save_cf.value='1';
								}							
								chk_inputs();
							}" />
                        <input name="vApplicationNo_img" id="vApplicationNo_img" type="hidden" />
                    </div>
                    <div id="labell_msg0_1" class="labell_msg blink_text orange_msg"></div>
                    <div id="cred_num" style="float:right; display:none; color:#FF3300;"></div>
                </div><?php
                if ($student_user_num < 1  && $_REQUEST["uvApplicationNo"] <> '')
				{?>
                    <div style="margin: 0 auto; margin-top:20px; padding:0px; height:160px; border:0px; width:480px; text-align:center; border-radius:0px;">
                        <div class="succ_box blink_text orange_msg" style="padding:10px; width:auto; display:block; line-height:1.5"><?php
						if ($student_user_num == 0)
						{
							echo 'Matriculation number is yet to sign-up';
						}else if ($student_user_num == -1)
						{
							echo 'Invalid matriculation number. Hope you are not entering application form number for matriculation number?';
						}?>
					</div>
                    </div><?php 
				}else if ($mm == 8 && $cEduCtgId <> 'PGZ' && $cEduCtgId <> 'PRX')
				{
					caution_box('Matriculation number must be that of an M. Phil. or Ph.D. student');
				}else if ($mm == 1 && ($cEduCtgId == 'PGZ' || $cEduCtgId == 'PRX'))
				{
					caution_box('Matriculation number must be that of an undergraduate, PGD or Masters student');
				}else if ($sRoleID_u == 29 && isset($_REQUEST["cProgrammeId"]) && is_bool(strpos($_REQUEST["cProgrammeId"], 'CHD')))
				{
					caution_box('Matriculaton number must be that of a certificate student in CHRD');
				}else if ($sRoleID_u == 26 && isset($_REQUEST["cProgrammeId"]) && is_bool(strpos($_REQUEST["cProgrammeId"], 'DEG')))
				{
					caution_box('Matriculaton number must be that of a certificate student in DE&GS');
				}else if ($staff_can_access == 0 && $vMatricNo <> '')
                {?>
                    <div style="margin: 0 auto; margin-top:20px; padding:0px; height:160px; border:0px; width:460px; text-align:center; border-radius:0px;">
                        <div class="succ_box blink_text orange_msg" style="padding:10px; width:auto; display:block; line-height:1.5">
                        	Student study centre does not match that of staff that is logged in
						</div>
                    </div><?php 
                }else if ($staff_can_access == '1' && ((isset($_REQUEST['see_all_qual'])&&$_REQUEST['see_all_qual']=='1') || (isset($_REQUEST['more_qual'])&&$_REQUEST['more_qual']=='1') || (isset($_REQUEST['see_qual'])&&$_REQUEST['see_qual']=='1') || (isset($_REQUEST['del_qual']) && $_REQUEST['del_qual'] == '1') || (isset($_REQUEST['edit_qual']) && $_REQUEST['edit_qual'] == '1')))
                {
					$stmt = $mysqli->prepare("SELECT dBirthDate from pers_info where vApplicationNo = ?");
					$stmt->bind_param("s", $vApplicationNo);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($dBirthDate);
					$stmt->fetch();
					$dBirthDate = $dBirthDate ?? '';
					$dBirthYear =  substr($dBirthDate,0,4);?>
					<input name="dBirthYear" id="dBirthYear" type="hidden" value="<?php echo $dBirthYear;?>" /><?php
					$stmt->close();

					$stmt = $mysqli->prepare("SELECT a.cQualCodeId,vExamNo,vcard_pin,vcard_sn,cExamMthYear,vExamSchoolName, b.cEduCtgId, c.iQSLCount, b.vQualCodeDesc FROM applyqual_stff a, qualification b, educationctg c 
					where a.cQualCodeId = b.cQualCodeId AND c.cEduCtgId = b.cEduCtgId AND vMatricNo = ? AND a.cDelFlag = 'N' ORDER BY right(cExamMthYear,4), left(cExamMthYear,2)");
					$stmt->bind_param("s", $vMatricNo);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cQualCodeId_02, $vExamNo_02, $vcard_pin_02, $vcard_sn_02, $cExamMthYear_02, $vExamSchoolName_02, $cEduCtgId_02, $iQSLCount_02, $vQualCodeDesc_02);
					$c = 0;?>
					
					<div class="innercont_stff" style="height:auto; padding:0px; margin-bottom:10px;"><?php
						if ((!isset($_REQUEST["more_qual"]) ||  (isset($_REQUEST["save_cf"]) && $_REQUEST["save_cf"] == '1') || (isset($_REQUEST["more_qual"]) && $_REQUEST["more_qual"] <> 1)) && check_scope3('Academic registry','Update student credentials', 'Add') > 0)
						{?>
							<a href="#" style="text-decoration:none;" 
								onclick="reg_grp1_1_loc.cEduCtgId_app.value='';
									reg_grp1_1_loc.iQSLCount.value='';
									reg_grp1_1_loc.vExamNo.value='';
									reg_grp1_1_loc.hdvExamNo.value='';
									reg_grp1_1_loc.cQualCodeId.value='';
									reg_grp1_1_loc.hdcQualCodeId.value='';
									reg_grp1_1_loc.vcard_pin.value='';
									reg_grp1_1_loc.vcard_sn.value='';
									reg_grp1_1_loc.cExamMthYear.value='';
									reg_grp1_1_loc.vExamSchoolName.value='';
									reg_grp1_1_loc.month.value='';
									reg_grp1_1_loc.year.value='';
									reg_grp1_1_loc.sbtd_pix.value='';
									reg_grp1_1_loc.edit_qual.value='';
									reg_grp1_1_loc.more_qual.value=1;

									if (_('del_qual_div'))
									{
										_('del_qual_div').style.display='none';
									}

									if (_('edit_qual_div'))
									{
										_('edit_qual_div').style.display='none';
									}
									_('sub_box').style.display='block';

									if (_('olevel'))
									{
										_('olevel').style.display='none';
									}
									
									if (_('alevel'))
									{
										_('alevel').style.display='none';
									}
									
									if (_('1subjectspecs'))
									{
										_('1subjectspecs').style.display='none';
									}
									
									_('top_div').innerHTML = 'Adding new qualification';

									_('cancel_ope').style.display='block';
									_('add_qual_div').style.display='none';
									return false">
								<div id="add_qual_div" class="submit_button_green" 
									style="margin-left:0px; 
									margin-right:4px; 
									padding:3px; 
									width:70px; 
									float:left; 
									font-size:0.9em;" 
									title="Click to add a new credential">
									Add
								</div>
							</a><?php
						}?>
						<a href="#" style="text-decoration:none;" 
							onclick="reg_grp1_1_loc.more_qual.value='';
							reg_grp1_1_loc.see_qual.value='';
							reg_grp1_1_loc.edit_qual.value='';
							reg_grp1_1_loc.see_all_qual.value = 1;
							in_progress('1');
							chk_inputs();
								return false">
							<div id="cancel_ope" class="submit_button_green" style="margin-left:0px; padding:3px; width:70px; font-size:0.9em; float:left; 
								display:<?php if (isset($_REQUEST["more_qual"]) && $_REQUEST["more_qual"] == '1' && (isset($_REQUEST["save_cf"]) && $_REQUEST["save_cf"] <> '1')){echo 'block';}else{echo 'none';}?>" 
								title="Click to operation">
								Cancel
							</div>
						</a><?php
						
						if (check_scope3('Academic registry','Update student credentials', 'Edit') > 0)
						{?>
							<a href="#" style="text-decoration:none;" 
								onclick="reg_grp1_1_loc.more_qual.value='';
									reg_grp1_1_loc.edit_qual.value=1;
									if (_('del_qual_div'))
									{
										_('del_qual_div').style.display='none';
									}

									if (_('add_qual_div'))
									{
										_('add_qual_div').style.display='none';
									}

									_('sub_box').style.display='block';
									
									_('top_div').innerHTML = 'Editing credential';
									
									_('cancel_ope').style.display='block';
									_('edit_qual_div').style.display='none';
									return false">
								<div id="edit_qual_div" class="submit_button_green" 
									style="margin-left:0px; 
									margin-right:4px; 
									padding:3px; 
									width:70px; 
									float:left; 
									font-size:0.9em;
									display:<?php if (isset($_REQUEST['see_qual']) && $_REQUEST['see_qual'] == '1'){echo 'block';}else{echo 'none';}?>;" 
									title="Click to edit selected credential">
									Edit
								</div>
							</a><?php
						}
						
						if (check_scope3('Academic registry','Update student credentials', 'Delete') > 0)
						{?>					
							<a href="#" style="text-decoration:none;" 
								onclick="reg_grp1_1_loc.vExamNo.value='<?php echo $vExamNo_01 ?>';
									reg_grp1_1_loc.cQualCodeId.value='<?php echo $cQualCodeId_01 ?>';
									_('smke_screen_2').style.display='block';
									_('smke_screen_2').style.zIndex = 3;
									_('conf_box_loc').style.display='block';
									_('conf_box_loc').style.zIndex = 4;
									return false">
								<div id="del_qual_div" class="submit_button_green" 
									style="display:<?php if(isset($_REQUEST['see_qual']) && $_REQUEST['see_qual']=='1'){echo 'block';}else{echo 'none';}?>; 
									padding:3px; 
									width:70px; 
									float:left; 
									font-size:0.9em;" title="Click to delete selected credential">
									Delete
								</div>
							</a><?php
						}?>


						<div id="certButons" style="width:auto; float:right; text-align:right;"><?php 
							if ($stmt->num_rows > 0) 
							{
								while($stmt->fetch())
								{
									$credential_loaded = credential_loaded($vApplicationNo, $cQualCodeId_02, $vExamNo_02);
									
									$color = '#ffffff';
									$backgroudcolor = '#2F4230';
									
									if (isset($_REQUEST['edit_qual']) && $_REQUEST['edit_qual'] == 1)
									{
										if (isset($_REQUEST['hdcQualCodeId']) && isset($_REQUEST['vExamNo']))
										{
											if ($cQualCodeId_02 == $_REQUEST['hdcQualCodeId'] && $vExamNo_02 == $_REQUEST['vExamNo'])
											{
												$color = '#2F4230';
												$backgroudcolor = '#FFFFFF';
											}								
										}
									}else
									{
										if (isset($_REQUEST['cQualCodeId']) && isset($_REQUEST['vExamNo']))
										{
											if ($cQualCodeId_02 == $_REQUEST['cQualCodeId'] && $vExamNo_02 == $_REQUEST['vExamNo'])
											{
												$color = '#2F4230';
												$backgroudcolor = '#FFFFFF';
											}								
										}
									}

									$qual_abrv = '';
									
									if ($cQualCodeId_02 == '201')
									{
										$qual_abrv = 'GCE';
									}else if ($cQualCodeId_02 == '202')
									{
										$qual_abrv = 'SSCE';
									}else if ($cQualCodeId_02 == '203')
									{
										$qual_abrv = 'NECO';
									}else if ($cQualCodeId_02 == '204')
									{
										$qual_abrv = 'NABTEB';
									}else if ($cQualCodeId_02 == '401')
									{
										$qual_abrv = 'GCE AL/HSC';
									}else if ($cQualCodeId_02 == '402')
									{
										$qual_abrv = 'IJMB A Level';
									}else if ($cQualCodeId_02 == '408')
									{
										$qual_abrv = 'NCE';
									}else if ($cQualCodeId_02 == '431')
									{
										$qual_abrv = 'JUPEB';
									}else if ($cQualCodeId_02 == '412')
									{
										$qual_abrv = 'OND';
									}else if ($cQualCodeId_02 == '411')
									{
										$qual_abrv = 'HND';
									}else if ($cQualCodeId_02 == '701')
									{
										$qual_abrv = 'PGD';
									}else if ($cQualCodeId_02 == '601')
									{
										$qual_abrv = 'First Degree';
									}?>
									
									
									<a href="#" style="text-decoration:none;" 
										onclick="reg_grp1_1_loc.vExamNo.value='<?php echo $vExamNo_02 ?>';
										reg_grp1_1_loc.iQSLCount.value='<?php echo $iQSLCount_02 ?>';
										reg_grp1_1_loc.hdvExamNo.value='<?php echo $vExamNo_02 ?>';
										reg_grp1_1_loc.cQualCodeId.value='<?php echo $cQualCodeId_02 ?>';
										reg_grp1_1_loc.hdcQualCodeId.value='<?php echo $cQualCodeId_02 ?>';
										reg_grp1_1_loc.cEduCtgId.value='<?php echo $cEduCtgId_02 ?>';
										reg_grp1_1_loc.vcard_pin.value='<?php echo $vcard_pin_02 ?>';
										reg_grp1_1_loc.vcard_sn.value='<?php echo $vcard_sn_02 ?>';
										reg_grp1_1_loc.cExamMthYear.value='<?php echo $cExamMthYear_02 ?>';
										reg_grp1_1_loc.vExamSchoolName.value='<?php echo $vExamSchoolName_02 ?>';
										reg_grp1_1_loc.month.value='<?php echo substr($cExamMthYear_02,0,2) ?>';
										reg_grp1_1_loc.year.value='<?php echo substr($cExamMthYear_02,2,4) ?>';
										reg_grp1_1_loc.credentialLoaded.value='<?php echo $credential_loaded;?>';
										reg_grp1_1_loc.clked_btn_no.value='<?php echo $c;?>';
										reg_grp1_1_loc.more_qual.value='';
										reg_grp1_1_loc.edit_qual.value='';
										reg_grp1_1_loc.sbtd_pix.value='';
										reg_grp1_1_loc.see_qual.value = '1';
										reg_grp1_1_loc.submit();
										return false">
										<div id="del_qual_div" class="submit_button_green" 
											style="padding:3px; 
											width:90px; 
											float:right;
											margin-left:4px;
											font-size:0.9em;
											color:<?php echo $color;?>; 
											background-color:<?php echo $backgroudcolor;?>;">
											<?php echo $qual_abrv;?>
										</div>
									</a><?php
								}
							}
							$stmt->close();?>
						</div>	
					</div>
                    
					<div class="innercont_stff">
						<label for="cQualCodeId" class="labell" style="width:250px;">Qualification</label>
						<div class="div_select"><?php
							$sql="SELECT cQualCodeId,vQualCodeDesc,cEduCtgId from qualification where cQualCodeId in ('201', '202','203','204', '207', '411', '412','401', '402', '431', '408','601') and cDelFlag = 'N' order by cEduCtgId, vQualCodeDesc;";
							$rsql=mysqli_query(link_connect_db(), $sql)or die("error: ".mysqli_error(link_connect_db()));?>
							
							<SELECT name="cQualCodeId" id="cQualCodeId" class="select" 
								onchange="reg_grp1_1_loc.sbtd_pix.value='';
								reg_grp1_1_loc.see_qual.value = '';
								reg_grp1_1_loc.cEduCtgId.value = '';
								reg_grp1_1_loc.save_cf.value = '';
								if(this.value==201||this.value==202||this.value==203||this.value==204)
								{
									if (_('vcard_sn_div'))
									{
										_('vcard_sn_div').style.display = 'block';
										_('card_users_div').style.display = 'block';
									}
									
									if (_('olevel'))
									{
										_('olevel').style.display = 'block';
									}
								}

								if (reg_grp1_1_loc.more_qual.value == 1)
								{
									reg_grp1_1_loc.submit();
								}
								return;">
								<option value="" selected="selected"></option><?php
								$prevCat = '';
								if ($sql <> '')
								{
									while ($table = mysqli_fetch_array($rsql))
									{
										if ($prevCat <> '' && $prevCat <> $table['cEduCtgId'] && is_bool(strpos($table['cEduCtgId'],"AL")))
										{?>
											<option value="" disabled="disabled">------------------------------------------------------------------------------</option><?php
										}?>
										<option value="<?php echo $table['cQualCodeId'] ?>"<?php if (isset($cQualCodeId_01) && $table['cQualCodeId'] == $cQualCodeId_01)
										{echo ' selected';}else if (isset($_REQUEST['cQualCodeId']) && $_REQUEST['cQualCodeId'] == $table['cQualCodeId']){echo ' selected';}?>>
										<?php echo $table['vQualCodeDesc'] ;?></option><?php
										$prevCat = $table['cEduCtgId'];
									}
									mysqli_close(link_connect_db());
								}?>
							</SELECT>
							<input name="hdcQualCodeId" id="hdcQualCodeId" type="hidden" value="<?php echo $cQualCodeId_01;?>" />
						</div>
						<div class="labell_msg blink_text orange_msg" id="labell_msg0"></div>
					</div>
			
					<div id="card_users_div" class="innercont_stff" style="display:<?php echo $vcard_pin_dis;?>;">
						<label for="vcard_pin" class="labell" style="width:250px;">Scratch card PIN</label>
						<div class="div_select">
							<input name="vcard_pin" id="vcard_pin" type="text" class="textbox" 
							style="text-transform:none" value="<?php echo $vcard_pin_01;?>" onchange="this.value=this.value.trim()" />
						</div>
						<div class="labell_msg blink_text orange_msg" id="labell_msg1"></div>
					</div>				
				
					<div id="vcard_sn_div" class="innercont_stff" style="display:<?php echo $vcard_sn_dis;?>">
						<label for="vcard_sn" class="labell" style="width:250px;">Scratch card serial number</label>
						<div class="div_select">
							<input name="vcard_sn" id="vcard_sn" type="text" class="textbox" 
							style="text-transform:none" value="<?php echo $vcard_sn_01;?>" onchange="this.value=this.value.trim()" />
						</div>
						<div class="labell_msg blink_text orange_msg" id="labell_msg2"></div>
					</div>
				
					<div class="innercont_stff">
						<label id="lbl_vExamNo" for="vExamNo" class="labell" style="width:250px;"><?php
						if (substr($cQualCodeId_01, 0, 2) == '20')
						{
							echo 'Candidate number';
						}elseif ($cQualCodeId_01 == '411' || $cQualCodeId_01 == '601')
						{
							echo 'Matriculation nunmber';
						}else if (substr($cQualCodeId_01, 0, 1) == '4')
						{
							echo 'Registration number';
						}else
						{
							echo 'Candidate number or Matric number';
						}?></label>
						<div class="div_select">
							<input name="vExamNo" id="vExamNo" type="text" class="textbox" style="text-transform:none" value="<?php echo $vExamNo_01?>" onblur="this.value=this.value.toUpperCase()" onChange="this.value=this.value.trim()" />
							<input name="hdvExamNo" id="hdvExamNo" type="hidden" value="<?php echo $vExamNo_01;?>" />
						</div>
						<div class="labell_msg blink_text orange_msg" id="labell_msg3"></div>
					</div>			
					
					<div class="innercont_stff">
						<label id="lbl_vExamSchoolName" for="vExamSchoolName" class="labell" style="width:250px;"><?php
						if (substr($cQualCodeId_01, 0, 2) == '20')
						{
							echo 'Name of institution or centre number';
						}else
						{
							echo 'Name of institution';
						}?>
						</label>
						<div class="div_select">
							<input name="vExamSchoolName" id="vExamSchoolName" type="text" class="textbox" 
							style="text-transform:none" onChange="this.value=this.value.trim();this.value=capitalizeEachWord(this.value)" value="<?php echo $vExamSchoolName_01;?>" />
						</div>
						<div class="labell_msg blink_text orange_msg" id="labell_msg4"></div>
					</div>
				
					<div class="innercont_stff">
						<label for="month" class="labell" style="width:250px;">Date of qualification</label>
						<div class="div_select"><?php 
							$current=getdate();?>
							<SELECT name="month" id="month" class="SELECT" style="width:auto" onchange="cExamMthYear.value=this.value+year.value;reg_grp1_1_loc.sbtd_pix.value='';">
								<option value="" selected="selected">mm</option><?php
								for($i=1;$i<=12;$i++)
								{?>
									<option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>"<?php if (str_pad($i, 2, "0", STR_PAD_LEFT) == substr($cExamMthYear_01,0,2)){echo " selected";}?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT);?></option><?php
								}?>
							</SELECT>
							<SELECT name="year" id="year" class="SELECT" style="width:auto" onchange="cExamMthYear.value=month.value+this.value;reg_grp1_1_loc.sbtd_pix.value='';">
								<option value="" selected="selected">yyyy</option><?php
								for($i=1950;$i<=$current['year'];$i++)
								{?>
									<option value="<?php echo $i; ?>"<?php if ($i == substr($cExamMthYear_01,2,4)){echo " selected";}?>> <?php echo $i ;?></option><?php
								}?>
							</SELECT> (mm/yyyy)
							<input name="cExamMthYear" id="cExamMthYear" type="hidden" value="<?php echo $cExamMthYear_01;?>" />
						</div>
						<div class="labell_msg blink_text orange_msg" id="labell_msg5"></div>
					</div>

					<div class="innercont_stff" style="margin-bottom:15px;">
						<label for="sbtd_pix" class="labell" style="width:250px;">Scanned copy of credential</label>
						<div class="div_select">
							<input type="file" name="sbtd_pix" id="sbtd_pix" style="width:180px" title="Upload scanned copy of credential. Max. size: 100KB">
						</div>
						<div class="labell_msg blink_text orange_msg" id="labell_msg6"></div>
					</div>
					
					

					<div class="innercont_stff" style="margin-bottom:0px;">
						<label class="labell" style="width:250px;">Qualification subject(s)</label>
					</div><?php 
					}

				if ($staff_can_access == '1' && ((isset($_REQUEST['more_qual'])&&$_REQUEST['more_qual']=='1') || (isset($_REQUEST['see_qual'])&&$_REQUEST['see_qual']=='1') || (isset($_REQUEST['edit_qual'])&&$_REQUEST['edit_qual']=='1')))
				{?>
					<!--Olevel subjects-->
					<div class="innercont_stff" id="olevel" style="border:1px solid #FFFFFF; float:left; height:auto; margin-top:0px; display:<?php if ($cEduCtgId_01 == 'OLX' || $cEduCtgId_01 == 'OLZ'){?>block<?php }else{?>none<?php }?>"><?php
						$sql1 = "select * from qualsubject where OLV = 'Y' AND cDelFlag = 'N' order by vQualSubjectDesc";
						$rsql1 = mysqli_query(link_connect_db(), $sql1)or die("Unable to query qualsubject".mysqli_error(link_connect_db()));
						$cnt = 0;

						$arr_sbjt_olevel = array(array());
						while($table1 = mysqli_fetch_array($rsql1))
						{
							if (isset($table1['cQualSubjectId']))
							{
								$cnt++;
								$arr_sbjt_olevel[$cnt]['cQualSubjectId'] = $table1['cQualSubjectId'];
								$arr_sbjt_olevel[$cnt]['vQualSubjectDesc'] = $table1['vQualSubjectDesc'];
							}
						}
						mysqli_close(link_connect_db());
						
						$arr_sbjt_olevel_grd = array(array());
						$sql2 = "select distinct cQualGradeId, cQualGradeCode, iQualGradeRank from qualgrade where cEduCtgId = '$cEduCtgId_01' AND cDelFlag = 'N' order by iQualGradeRank desc";
						$rsql2=mysqli_query(link_connect_db(), $sql2)or die("Unable to query qualgrade".mysqli_error(link_connect_db()));

						$cnt = 0;
						while($table2 = mysqli_fetch_array($rsql2))
						{
							$cnt++;
							$arr_sbjt_olevel_grd[$cnt]['cQualGradeId'] = $table2['cQualGradeId'];
							$arr_sbjt_olevel_grd[$cnt]['cQualGradeCode'] = $table2['cQualGradeCode'];
						}
						mysqli_close(link_connect_db());
						
						$stmt = $mysqli->prepare("select a.cQualSubjectId, cQualGradeId
						from applysubject_stff a, qualsubject b
						where a.cQualSubjectId = b.cQualSubjectId and cQualCodeId = '$cQualCodeId_01' and vExamNo = '$vExamNo_01' 
						and vMatricNo = ? AND a.cDelFlag = 'N' order by vQualSubjectDesc");
						$stmt->bind_param("s", $vMatricNo);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($cQualSubjectId, $cQualGradeId);
					
						$t = 0;
						$arr_sbjt_olevel_grd_rec = array(array());
						while($stmt->fetch())
						{
							$t++;
							$arr_sbjt_olevel_grd_rec[$t]['cQualSubjectId'] = $cQualSubjectId;
							$arr_sbjt_olevel_grd_rec[$t]['cQualGradeId'] = $cQualGradeId;
						}
						$stmt->close();
						$cand_totoal_subj = $t;

						$subnum = 0;
						while($subnum <= $iQSLCount_01-1)
						{
							$subnum++;
							$cQualSubjectId = '';
							$cQualGradeId = '';
							if (isset($arr_sbjt_olevel_grd_rec[$subnum]["cQualSubjectId"]))
							{
								$cQualSubjectId = $arr_sbjt_olevel_grd_rec[$subnum]["cQualSubjectId"];
								$cQualGradeId = $arr_sbjt_olevel_grd_rec[$subnum]["cQualGradeId"];
							}

							$text_color = '';
							if ($subnum%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							
							<div class="innercont_stff">
								<div id="tabletd<?php echo $subnum; ?>1" class="_label" style="border:1px solid #cdd8cf; width:4.4%; padding:5px; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; color:<?php echo $text_color;?>; text-align:right">
										<?php echo $subnum; ?>
								</div>

								<div class="_label" style="border:1px solid #cdd8cf; width:54.7%; padding:0px; height: 100%; background-color:<?php echo $background_color;?>; color:<?php echo $text_color;?>; text-align:left">
									<select name="subject1<?php echo $subnum; ?>" id="subject1<?php echo $subnum; ?>" 
										class="select" 
										<?php if ($cand_totoal_subj < $subnum && $subnum - $cand_totoal_subj > 1)
										{
											echo 'disabled="disabled"';
										}
										
										if ($subnum <> $iQSLCount_01)
										{?> 
											onchange="if (this.value!=''&&grade1<?php echo $subnum; ?>.value!='')
											{
												grade1<?php echo $subnum+1; ?>.disabled=false;
												subject1<?php echo $subnum+1; ?>.disabled=false
											}else
											{
												grade1<?php echo $subnum+1; ?>.disabled=true;
												subject1<?php echo $subnum+1; ?>.disabled=true
											}"<?php 
										}?>>
										<option value="" selected="selected"></option><?php
											for ($b = 1; $b <= count($arr_sbjt_olevel)-1; $b++)
											{
												if ($b%10==0)
												{?>
													<option disabled></option><?php
												}?>
												<option value="<?php echo $arr_sbjt_olevel[$b]['cQualSubjectId']?>"<?php if ($arr_sbjt_olevel[$b]['cQualSubjectId'] == $cQualSubjectId){echo " selected";}?>><?php echo ucwords(strtolower($arr_sbjt_olevel[$b]['vQualSubjectDesc']))?></option><?php
											}?>
									</select>
								</div>
								
								<div class="_label" style="border:1px solid #cdd8cf; width:8.2%; padding:0px; height: 100%; background-color:<?php echo $background_color;?>; color:<?php echo $text_color;?>; text-align:left">
									<select name="grade1<?php echo $subnum; ?>" id="grade1<?php echo $subnum; ?>" 
										class="select" <?php 
											if ($cand_totoal_subj < $subnum && $subnum - $cand_totoal_subj > 1)
											{
												echo 'disabled="disabled"';
											}
											
											if ($subnum <> $iQSLCount_01)
											{?> 
												onchange="if (this.value!=''&&subject1<?php echo $subnum; ?>.value!='')
												{
													grade1<?php echo $subnum+1; ?>.disabled=false;
													subject1<?php echo $subnum+1; ?>.disabled=false
												}else
												{
													grade1<?php echo $subnum+1; ?>.disabled=true;
													subject1<?php echo $subnum+1; ?>.disabled=true
												}"<?php 
											}?>>
											<option value="" selected="selected"></option><?php
											for ($a = 1; $a <= count($arr_sbjt_olevel_grd)-1; $a++)
											{?>
												<option value="<?php echo $arr_sbjt_olevel_grd[$a]['cQualGradeId']?>"<?php if ($arr_sbjt_olevel_grd[$a]['cQualGradeId'] == $cQualGradeId){echo " selected";}?>><?php echo $arr_sbjt_olevel_grd[$a]['cQualGradeCode']?></option><?php
											}?>
									</select>
								</div>
							</div><?php 
						}?>
					</div>
					
					<!-- alevel subjects-->
					<div class="innercont_stff" id="alevel" style="border:1px solid #FFFFFF; float:left; height:auto; margin-top:0px; display:<?php if ($cEduCtgId_01 == 'OLY' || $cEduCtgId_01 == 'ALX' || $cEduCtgId == 'ALY'){?>block<?php }else{?>none<?php }?>"><?php
						$arr_sbjt_alevel = array(array());
						$sql1 = "select * from qualsubject WHERE cDelFlag = 'N' order by vQualSubjectDesc";
						$rsql1 = mysqli_query(link_connect_db(), $sql1)or die("Unable to query qualsubject".mysqli_error(link_connect_db()));
						$cnt = 0;
						while($table1 = mysqli_fetch_array($rsql1))
						{
							if (isset($table1['cQualSubjectId']))
							{
								$cnt++;
								$arr_sbjt_alevel[$cnt]['cQualSubjectId'] = $table1['cQualSubjectId'];
								$arr_sbjt_alevel[$cnt]['vQualSubjectDesc'] = $table1['vQualSubjectDesc'];
							}
						}
						mysqli_close(link_connect_db());

						$arr_sbjt_alevel_grd = array(array());
						$sql2 = "select distinct cQualGradeId, cQualGradeCode, iQualGradeRank from qualgrade where cEduCtgId = '$cEduCtgId_01' order by iQualGradeRank desc";
						$rsql2=mysqli_query(link_connect_db(), $sql2)or die("Unable to query qualgrade".mysqli_error(link_connect_db()));

						$cnt = 0;
						while($table2 = mysqli_fetch_array($rsql2))
						{
							$cnt++;
							$arr_sbjt_alevel_grd[$cnt]['cQualGradeId'] = $table2['cQualGradeId'];
							$arr_sbjt_alevel_grd[$cnt]['cQualGradeCode'] = $table2['cQualGradeCode'];
						}
						mysqli_close(link_connect_db());

						$arr_sbjt_alevel_grd_rec = array(array());
						$stmt = $mysqli->prepare("select a.cQualSubjectId, cQualGradeId
						from applysubject_stff a, qualsubject b
						where a.cQualSubjectId = b.cQualSubjectId and cQualCodeId = '$cQualCodeId_01' and vExamNo = '$vExamNo_01' 
						and vMatricNo = ? AND a.cDelFlag = 'N' order by vQualSubjectDesc");
						
						$stmt->bind_param("s", $vMatricNo);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($cQualSubjectId, $cQualGradeId);

						$t = 0;
						while($stmt->fetch())	
						{
							$t++;
							$arr_sbjt_alevel_grd_rec[$t]['cQualSubjectId'] = $cQualSubjectId;
							$arr_sbjt_alevel_grd_rec[$t]['cQualGradeId'] = $cQualGradeId;
						}
						$stmt->close();

						$subnum = 0;
						while($subnum <= $iQSLCount_01-1)
						{
							$subnum++;
							$cQualSubjectId = '';
							$cQualGradeId = '';
							if (isset($arr_sbjt_alevel_grd_rec[$subnum]["cQualSubjectId"]))
							{
								$cQualSubjectId = $arr_sbjt_alevel_grd_rec[$subnum]["cQualSubjectId"];
								$cQualGradeId = $arr_sbjt_alevel_grd_rec[$subnum]["cQualGradeId"];
							}
							
							if ($subnum%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>

							<div class="innercont_stff">
								<div id="tabletd<?php echo $subnum; ?>1" class="_label" style="border:1px solid #cdd8cf; width:4.4%; padding:5px; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; color:<?php echo $text_color;?>; text-align:right">
										<?php echo $subnum; ?>
								</div>

								<div class="_label" style="border:1px solid #cdd8cf; width:54.7%; padding:0px; height: 100%; background-color:<?php echo $background_color;?>; color:<?php echo $text_color;?>; text-align:left">
									<select name="subject2<?php echo $subnum; ?>" id="subject2<?php echo $subnum; ?>" 
										class="select" 
										<?php if ($cand_totoal_subj < $subnum && $subnum - $cand_totoal_subj > 1)
										{
											echo 'disabled="disabled"';
										}
										
										if ($subnum <> $iQSLCount_01)
										{?> 
											onchange="if (this.value!=''&&grade2<?php echo $subnum; ?>.value!='')
											{
												grade2<?php echo $subnum+1; ?>.disabled=false;
												subject2<?php echo $subnum+1; ?>.disabled=false
											}else
											{
												grade2<?php echo $subnum+1; ?>.disabled=true;
												subject2<?php echo $subnum+1; ?>.disabled=true
											}"<?php 
										}?>>
										<option value="" selected="selected"></option><?php
											for ($b = 1; $b <= count($arr_sbjt_alevel)-1; $b++)
											{
												if ($b%10==0)
												{?>
													<option disabled></option><?php
												}?>
												<option value="<?php echo $arr_sbjt_alevel[$b]['cQualSubjectId']?>"<?php if ($arr_sbjt_alevel[$b]['cQualSubjectId'] == $cQualSubjectId){echo " selected";}?>><?php echo ucwords(strtolower($arr_sbjt_alevel[$b]['vQualSubjectDesc']))?></option><?php
											}?>
									</select>
								</div>
								
								<div class="_label" style="border:1px solid #cdd8cf; width:8.2%; padding:0px; height: 100%; background-color:<?php echo $background_color;?>; color:<?php echo $text_color;?>; text-align:left">
									<select name="grade2<?php echo $subnum; ?>" id="grade2<?php echo $subnum; ?>" 
										class="select" <?php 
											if ($cand_totoal_subj < $subnum && $subnum - $cand_totoal_subj > 1)
											{
												echo 'disabled="disabled"';
											}
											
											if ($subnum <> $iQSLCount_01)
											{?> 
												onchange="if (this.value!=''&&subject2<?php echo $subnum; ?>.value!='')
												{
													grade2<?php echo $subnum+1; ?>.disabled=false;
													subject2<?php echo $subnum+1; ?>.disabled=false
												}else
												{
													grade2<?php echo $subnum+1; ?>.disabled=true;
													subject2<?php echo $subnum+1; ?>.disabled=true
												}"<?php 
											}?>>
											<option value="" selected="selected"></option><?php
											for ($a = 1; $a <= count($arr_sbjt_alevel_grd)-1; $a++)
											{?>
												<option value="<?php echo $arr_sbjt_alevel_grd[$a]['cQualGradeId']?>"<?php if ($arr_sbjt_alevel_grd[$a]['cQualGradeId'] == $cQualGradeId){echo " selected";}?>><?php echo $arr_sbjt_alevel_grd[$a]['cQualGradeCode']?></option><?php
											}?>
									</select>
								</div>
							</div><?php
						}?>
					</div>
					
					<!--1subject specs-->
					<div class="innercont_stff" id="1subjectspecs" style="border:1px solid #FFFFFF; float:left; height:auto; margin-top:0px; display:<?php if ($cEduCtgId_01 == 'ALW' || $cEduCtgId_01 == 'ALZ' || substr($cEduCtgId_01,0,1) == 'P' || substr($cEduCtgId_01,0,2) == 'EL'){?>block<?php }else{?>none<?php }?>"><?php
						$sql1 = "select * from qualsubject where OLV <> 'Y' AND cDelFlag = 'N' order by vQualSubjectDesc";
						$rsql1 = mysqli_query(link_connect_db(), $sql1)or die("Unable to query qualsubject".mysqli_error(link_connect_db()));
						$cnt = 0;

						$arr_sbjt_1 = array(array());
						while($table1 = mysqli_fetch_array($rsql1))
						{
							if (isset($table1['cQualSubjectId']))
							{
								$cnt++;
								$arr_sbjt_1[$cnt]['cQualSubjectId'] = $table1['cQualSubjectId'];
								$arr_sbjt_1[$cnt]['vQualSubjectDesc'] = $table1['vQualSubjectDesc'];
							}
						}
						mysqli_close(link_connect_db());
						
						$arr_sbjt_1_grd = array(array());
						$sql2 = "select distinct cQualGradeId, cQualGradeCode, iQualGradeRank from qualgrade where cEduCtgId = '$cEduCtgId_01' AND cDelFlag = 'N' order by iQualGradeRank desc";
						$rsql2=mysqli_query(link_connect_db(), $sql2)or die("Unable to query qualgrade".mysqli_error(link_connect_db()));

						$cnt = 0;
						while($table2 = mysqli_fetch_array($rsql2))
						{
							$cnt++;
							$arr_sbjt_1_grd[$cnt]['cQualGradeId'] = $table2['cQualGradeId'];
							$arr_sbjt_1_grd[$cnt]['cQualGradeCode'] = $table2['cQualGradeCode'];
						}
						mysqli_close(link_connect_db());
						
						$stmt = $mysqli->prepare("select a.cQualSubjectId, cQualGradeId
						from applysubject_stff a, qualsubject b
						where a.cQualSubjectId = b.cQualSubjectId and cQualCodeId = '$cQualCodeId_01' and vExamNo = '$vExamNo_01' 
						and vMatricNo = ? AND a.cDelFlag = 'N' order by vQualSubjectDesc");
						$stmt->bind_param("s", $vMatricNo);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($cQualSubjectId, $cQualGradeId);
					
						$t = 0;
						$arr_sbjt_1_rec = array(array());
						while($stmt->fetch())
						{
							$t++;
							$arr_sbjt_1_grd_rec[$t]['cQualSubjectId'] = $cQualSubjectId;
							$arr_sbjt_1_grd_rec[$t]['cQualGradeId'] = $cQualGradeId;
						}
						$stmt->close();
						$cand_totoal_subj = $t;

						$subnum = 0;
						while($subnum <= $iQSLCount_01-1)
						{
							$subnum++;
							$cQualSubjectId = '';
							$cQualGradeId = '';
							if (isset($arr_sbjt_1_grd_rec[$subnum]["cQualSubjectId"]))
							{
								$cQualSubjectId = $arr_sbjt_1_grd_rec[$subnum]["cQualSubjectId"];
								$cQualGradeId = $arr_sbjt_1_grd_rec[$subnum]["cQualGradeId"];
							}
							
							if ($subnum%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>

							<div class="innercont_stff">
								<div id="tabletd<?php echo $subnum; ?>1" class="_label" style="border:1px solid #cdd8cf; width:4.4%; padding:5px; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; color:<?php echo $text_color;?>; text-align:right">
										<?php echo $subnum; ?>
								</div>

								<div class="_label" style="border:1px solid #cdd8cf; width:54.7%; padding:0px; height: 100%; background-color:<?php echo $background_color;?>; color:<?php echo $text_color;?>; text-align:left">
									<select name="subject3<?php echo $subnum; ?>" id="subject3<?php echo $subnum; ?>" 
										class="select" 
										<?php if ($cand_totoal_subj < $subnum && $subnum - $cand_totoal_subj > 1)
										{
											echo 'disabled="disabled"';
										}
										
										if ($subnum <> $iQSLCount_01)
										{?> 
											onchange="if (this.value!=''&&grade2<?php echo $subnum; ?>.value!='')
											{
												grade3<?php echo $subnum+1; ?>.disabled=false;
												subject3<?php echo $subnum+1; ?>.disabled=false
											}else
											{
												grade3<?php echo $subnum+1; ?>.disabled=true;
												subject3<?php echo $subnum+1; ?>.disabled=true
											}"<?php 
										}?>>
										<option value="" selected="selected"></option><?php
											for ($b = 1; $b <= count($arr_sbjt_1)-1; $b++)
											{
												if ($b%10==0)
												{?>
													<option disabled></option><?php
												}?>
												<option value="<?php echo $arr_sbjt_1[$b]['cQualSubjectId']?>"<?php if ($arr_sbjt_1[$b]['cQualSubjectId'] == $cQualSubjectId){echo " selected";}?>><?php echo ucwords(strtolower($arr_sbjt_1[$b]['vQualSubjectDesc']))?></option><?php
											}?>
									</select>
								</div>
								
								<div class="_label" style="border:1px solid #cdd8cf; width:8.2%; padding:0px; height: 100%; background-color:<?php echo $background_color;?>; color:<?php echo $text_color;?>; text-align:left">
									<select name="grade3<?php echo $subnum; ?>" id="grade3<?php echo $subnum; ?>" 
										class="select" <?php 
											if ($cand_totoal_subj < $subnum && $subnum - $cand_totoal_subj > 1)
											{
												echo 'disabled="disabled"';
											}
											
											if ($subnum <> $iQSLCount_01)
											{?> 
												onchange="if (this.value!=''&&subject3<?php echo $subnum; ?>.value!='')
												{
													grade3<?php echo $subnum+1; ?>.disabled=false;
													subject3<?php echo $subnum+1; ?>.disabled=false
												}else
												{
													grade3<?php echo $subnum+1; ?>.disabled=true;
													subject3<?php echo $subnum+1; ?>.disabled=true
												}"<?php 
											}?>>
											<option value="" selected="selected"></option><?php
											for ($a = 1; $a <= count($arr_sbjt_1_grd)-1; $a++)
											{?>
												<option value="<?php echo $arr_sbjt_1_grd[$a]['cQualGradeId']?>"<?php if ($arr_sbjt_1_grd[$a]['cQualGradeId'] == $cQualGradeId){echo " selected";}?>><?php echo $arr_sbjt_1_grd[$a]['cQualGradeCode']?></option><?php
											}?>
									</select>
								</div>
							</div><?php
						}?>
					</div><?php
				}?>
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
                
				<?php echo side_detail($_REQUEST['uvApplicationNo']);?>
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