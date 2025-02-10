<?php
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

//include('../rs/std_lib_fn.php');
?>
<!DOCTYPE html>
<html lang="en">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php

$currency = 1;

$study_mode_1st = 'odl';
$cStudyCenterId = '';
$cFacultyId = '';

if (isset($_REQUEST['cStudyCenterId']) && $_REQUEST['cStudyCenterId'] <> '')
{
	$cStudyCenterId = $_REQUEST['cStudyCenterId'];

}

if (isset($_REQUEST['cFacultyId']) && $_REQUEST['cFacultyId'] <> '')
{
	$cFacultyId = $_REQUEST['cFacultyId'];
}

if (isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] <> '' && ($cStudyCenterId == '' || $cFacultyId == ''))
{
	$stmt = $mysqli->prepare("SELECT cFacultyId FROM userlogin where vApplicationNo = ?");
	$stmt->bind_param("s", $_REQUEST['vApplicationNo']);$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cFacultyId);
	$stmt->fetch();
	$stmt->close();
}

$orgsetins = settns();

$sql_sub1 = ''; $sql_sub2 = ''; $sql_sub3 = '';
if ($orgsetins['studycenter'] == '1')
{
	$sql_sub1 = ', studycenter f'; $sql_sub2 = 'and a.cStudyCenterId = f.cStudyCenterId'; $sql_sub3 = ', f.vCityName';
}

$vMatricNo = '';

if (isset($_REQUEST['vMatricNo']))
{
	$vMatricNo = $_REQUEST['vMatricNo'];
}

$balance = 0;


$cEduCtgId_su = '';
$cFacultyId_su = '';

if ($vMatricNo <> '')
{
    $stmt = $mysqli->prepare("select vTitle, vLastName, concat(vFirstName,' ',vOtherName) othernames, b.cFacultyId, b.vFacultyDesc, c.vdeptDesc,a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.iStudy_level, a.vMobileNo, a.vEMailId, a.tSemester, f.vCityName, e.cEduCtgId, a.cAcademicDesc,  a.cAcademicDesc_1
    from s_m_t a, faculty b, depts c, obtainablequal d, programme e, studycenter f
    where a.cFacultyId = b.cFacultyId
    and a.cdeptId = c.cdeptId
    and a.cObtQualId = d.cObtQualId
    and a.cProgrammeId = e.cProgrammeId 
    and a.cStudyCenterId = f.cStudyCenterId
    and a.vMatricNo = ?");
	$stmt->bind_param("s", $vMatricNo);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($vTitle, $vLastName, $othernames, $cFacultyId, $vFacultyDesc, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $iStudy_level, $vMobileNo, $vEMailId, $tSemester, $vCityName, $cEduCtgId, $cAcademicDesc, $cAcademicDesc_1);
	$stmt->fetch();
	$stmt->close();
		
	
    $cEduCtgId_su = $cEduCtgId;
    $cFacultyId_su = $cFacultyId;
}


$userInfo = '';
$stmt = $mysqli->prepare("select concat(vLastName,' ',vFirstName,' ',vOtherName) username, a.cFacultyId, b.vFacultyDesc, a.cdeptId, c.vdeptDesc, d.sRoleID 
from userlogin a, faculty b, depts c, role_user d
where a.cFacultyId = b.cFacultyId and 
a.cdeptId = c.cdeptId and 
d.vUserId = a.vApplicationNo and
vApplicationNo = ?");
$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0){$userInfo = '1';}

$stmt->bind_result($username, $cFacultyId_u, $vFacultyDesc_u, $cdeptId_u, $vdeptDesc_u, $sRoleID_u);
$stmt->fetch();
$stmt->close();

//date_default_timezone_set("Africa/Lagos");?>

<script language="JavaScript" type="text/javascript" src="button_ops.js"></script>
<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
<title>NOUN-MIS</title>
<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
<script language="JavaScript" type="text/javascript">
	function call_image()
	{
		var formdata = new FormData();
		
		_("loadcred").value = 1;
		
		formdata.append("loadcred",_("loadcred").value);
		formdata.append("currency", _("currency_cf").value);
		formdata.append("user_cat", _("user_cat").value);
		
		formdata.append("vApplicationNo", _("vApplicationNo_img").value);
		
		formdata.append("vExamNo", _("vExamNo").value);
		formdata.append("cQualCodeId", _("cQualCodeId").value);
		
		opr_prep_img(ajax = new XMLHttpRequest(),formdata);
	}



	function opr_prep_img(ajax,formdata)
	{
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		
		ajax.open("POST", "opr_s5.php");
		ajax.send(formdata);
	}

	function completeHandler(event)
	{
		if (_("loadcred").value == 1)
		{
			_("container_cover_in").style.zIndex = 1;
			_("container_cover_in").style.display = 'block';
			_("credential_img").src = event.target.responseText;
			_("imgClose").focus();
			_("loadcred").value = 0;
		}
	}
	
	
	function progressHandler(event)
	{
	}
	
	
	function errorHandler(event)
	{
	}
	
	function abortHandler(event)
	{
	}
</script>

<style type="text/css">

	ol { list-style: decimal; margin-left: 2em;}
	.checklist li { background: none; padding: 0px; }
	.checklist {
		border: 0px solid #ccc;
		margin-left:-1px;
		list-style: none;
		overflow:hidden;
		width:100%;
	}
	
	li { margin: 0px;  padding: 0px; margin-top:-1; width:auto; height:20px;}
	.checklist label { display: block; padding-left:0px;}
	.checklist li:hover { background: #777; color: #fff; cursor:default;}
	.alt { background:#EEF7EE; }
</style>
</head>

<body onload="/*window.print();*/ checkConnection()">
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
					style="color:#666666; margin-right:3px; text-decoration:none;text-shadow: 0 1px 0 #fafafa;">X</a>
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
			<img id="credential_img" style="width:100%; height:100%"/>
		</div>
	</div>


	<div id="container" style="margin-top:3px; height:auto; width:820px; text-align:center; padding:10px;">
		<?php do_toup_div_prns('Student Management System');?>
		<div class="innercont" style="margin:auto; margin-top:7px; border-radius:0px; width:100%; display:<?php if (isset($_REQUEST['side_menu_no']) && $_REQUEST['side_menu_no']<>17 && $_REQUEST['side_menu_no']<>18){?>block<?php }else{?>none<?php }?>;">
			<div style="width:auto; border-radius:0px; float:left;">
				<label class="labell" style="text-align:left;width:auto; margin-left:-1px; border:none">Current session</label>
				<div style="width:125px; height:17px; margin-top:-1px; padding-top:5px;text-align:left; border-radius:0px; margin-left:80px;">
					<b><?php echo $orgsetins['cAcademicDesc'];?></b>
				</div>	
			</div>
			
			<div style="width:auto; margin-left:17px;border-radius:0px; float:right;">
				<label class="labell" style="text-align:left;width:auto; margin-left:-1px; border:none;">e-Wallet balance (NGN)</label>
				<div style="width:85px; height:17px; margin-top:-1px; text-align:right; padding-top:5px; float:right; border-radius:0px;">
					<b><?php                 	
                	$balance = wallet_bal1();
					echo number_format($balance, 2, '.', ',');?></b>
				</div>	
			</div>	
		</div><?php
		
		if ((isset($_REQUEST['mm']) && isset($_REQUEST['sm']) && $_REQUEST['mm'] == 0 && $_REQUEST['sm'] == 11) || (isset($_REQUEST['side_menu_no']) && ($_REQUEST['side_menu_no'] == 'see_all_registered_courses' || $_REQUEST['side_menu_no'] == 'see_all_registered_courses_for_exam')))
		{?>
			<div class="innercont" 
				style="margin:auto; 
				margin-top:10px; 
				height:150px; 
				padding-top:2px; 
				margin-left:4px; 
				border-radius:0px; 
				width:99.5%; 
				border-top:1px solid #CCCCCC; 
				border-bottom:1px solid #CCCCCC; 
				display:block">
				<div id="pp_box" style="margin-left:0px; float:right; width:125px; border: 0px; height:inherit;">
					<img src="<?php echo get_pp_pix('');?>" style="width:inherit; height:inherit;" alt="" />
				</div><?php

				$student_data = "";
				if ($vMatricNo <> '')
				{?>
					<div style="margin-top:-1px; width:45%; border-radius:0px; float:left; margin-top:3px;">
						<div style="width:23%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left;">
							Matric no.
						</div>
						<div style="width:75%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left; margin-left:3px;">
							<b><?php echo $vMatricNo;?></b>
						</div>	
					</div>
					
					<div style="margin-top:-1px; width:45%; border-radius:0px; float:left; margin-top:3px;">
						<div style="width:23%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left;">
							Study centre
						</div>
						<div style="width:75%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left; margin-left:3px;">
							<b><?php echo $vCityName;?></b>
						</div>	
					</div>
					
					<div style="margin-top:-1px; width:39.4%; border-radius:0px; float:left; margin-top:3px;">
						<div style="width:25%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; text-indent:2px; border-radius:0px; float:left;">
							Name
						</div>
						<div style="width:73%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left; margin-left:3px;">
							<b><?php echo $vLastName;?></b>
						</div>	
					</div>

					<div style="margin-top:-1px; width:45%; border-radius:0px; float:left; margin-top:3px;">
						<div style="width:23%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left;">
							Faculty
						</div>
						<div style="width:75%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left; margin-left:3px;">
							<b><?php echo $vFacultyDesc;?></b>
						</div>	
					</div>

					<div style="margin-top:-1px; width:39.4%; border-radius:0px; float:left; margin-top:3px;">
						<div style="width:25%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; text-indent:2px; border-radius:0px; float:left;">
							
						</div>
						<div style="width:73%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left; margin-left:3px;">
							<b><?php echo $othernames;?></b>
						</div>	
					</div>
					
					<div style="margin-top:-1px; width:45%; border-radius:0px; float:left; margin-top:3px;">
						<div style="width:23%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left;">
							Department
						</div>
						<div style="width:75%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left; margin-left:3px;">
							<b><?php echo $vdeptDesc;?></b>
						</div>	
					</div>

					<div style="margin-top:-1px; width:39.4%; border-radius:0px; float:left; margin-top:3px;">
						<div style="width:25%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; text-indent:2px; border-radius:0px; float:left;">
							Phone #
						</div>
						<div style="width:73%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left; margin-left:3px;">
							<b><?php echo $vMobileNo;?></b>
						</div>	
					</div>		
					
					<div style="margin-top:-1px; width:45%; border-radius:0px; float:left; margin-top:3px;">
						<div style="width:23%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left;">
							Programme
						</div>
						<div style="width:75%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left; margin-left:3px; white-space: nowrap;
  							overflow: hidden; text-overflow: ellipsis;" title="<?php echo $vObtQualTitle.' '.$vProgrammeDesc;?>">
							<b><?php echo $vObtQualTitle.' '.$vProgrammeDesc;?></b>
						</div>	
					</div>

					<div style="margin-top:-1px; width:39.4%; border-radius:0px; float:left; margin-top:3px;">
						<div style="width:25%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; text-indent:2px; border-radius:0px; float:left;">
							e-Mail
						</div>
						<div style="width:73%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left; margin-left:3px;">
							<b><?php echo $vEMailId;?></b>
						</div>	
					</div>
					
					<div style="margin-top:-1px; width:45%; border-radius:0px; float:left; margin-top:3px;">
						<div style="width:23%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left;">
							Level
						</div>
						<div style="width:75%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left; margin-left:3px;">
							<b><?php echo $iStudy_level;?></b>
						</div>	
					</div>

					<div style="margin-top:-1px; width:39.4%; border-radius:0px; float:left; margin-top:3px;">
						<div style="width:25%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; text-indent:2px; border-radius:0px; float:left;">
							Semester
						</div>
						<div style="width:73%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left; margin-left:3px;">
							<b><?php if ($tSemester == 1)
							{
								echo 'First';$tSemester = 1;
							}else
							{
								echo 'Second';$tSemester = 2;
							};?></b>
						</div>	
					</div><?php

					$student_data = $vMatricNo.' '.$vCityName.' '.$vLastName.' '.$othernames.' '.$vFacultyDesc.' '.$vdeptDesc.' '.$vMobileNo.' '.$vObtQualTitle.' '.$vProgrammeDesc.' '.$vEMailId.' '.$iStudy_level.' '.$tSemester.' '.$vProgrammeDesc.' '.$vProgrammeDesc;
				}?>
			</div><?php
		}

		
		if (isset($_REQUEST['mm']) && isset($_REQUEST['sm']))
		{
			if (isset($_REQUEST['side_menu_no']) && ($_REQUEST['side_menu_no'] == 'see_course_registration_slip' || $_REQUEST['side_menu_no'] == 'see_exam_registeration_slip' || $_REQUEST['side_menu_no'] == 'see_all_registered_courses' || $_REQUEST['side_menu_no'] == 'see_all_registered_courses_for_exam'))
			{?>		
				<div class="innercont" style="margin-top:7px; height:auto; margin-left:4px; border-radius:0px; width:100%; font-size: 1.0em; position:relative;">
					<div class="innercont" style="margin-top:-1px; margin-bottom:5px; margin-left:-1px; padding-top:5px; border-radius:0px; width:100%; line-height:1.6; height:auto; border: 0px solid #FFFFFF;">
						<b><?php if ($_REQUEST['side_menu_no'] == 'see_course_registration_slip')
						{
							echo 'Course Registration Slip [Session: '.substr($cAcademicDesc, 0, 4).']';
						}else if ($_REQUEST['side_menu_no'] == 'see_all_registered_courses')
						{
							echo 'All Registered Courses';
						}else if ($_REQUEST['side_menu_no'] == 'see_exam_registeration_slip')
						{
							echo 'Examination Registration Slip [Session: '.substr($cAcademicDesc, 0, 4).']';
						}else if ($_REQUEST['side_menu_no'] == 'see_all_registered_courses_for_exam')
						{
							echo 'All Registered Courses for Examination';
						}?>
					</div>

					<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:normal">
						<div class="ctabletd_1" style="width:5%; height:17px; padding-top:5px; padding-right:2px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Sno</div>
						
						<div class="ctabletd_1" style="width:11% ;height:17px; margin-left:-1px; text-indent:2px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Course code</div>

						<div class="ctabletd_1" style="width:44%; height:17px; margin-left:-1px; padding-top:5px; padding-left:3px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Course title</div>

						<div class="ctabletd_1" style="width:8%; height:17px; margin-left:-1px; padding-right:3px; padding-top:5px; padding-right:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Cr. unit</div>

						<div class="ctabletd_1" style="width:8%; height:17px; margin-left:-1px; padding-right:2px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:centeer;">Mandate</div>

						<div class="ctabletd_1" style="width:10%; margin-left:-1px; padding-right:3px; height:17px; padding-top:5px; padding-right:3px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Fee (N)</div>

						<div class="ctabletd_1" style="width:10.2%; margin-left:-1px; height:17px; text-indent:2px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Date</div>				
					</div><?php
					
					$c = 0; 
					$total_cost = 0; 
					$tcc = 0;
					
					$prev_siLevel = '';
					$rev_tSemester = '';

					if ($_REQUEST['side_menu_no'] == 'see_all_registered_courses')
					{?>
						<ul id="rtside" class="checklist" style=" padding:0px; height:auto; border:0px solid #cccccc;"><?php
							$table = search_starting_pt_crs($_REQUEST['vMatricNo']);
							foreach ($table as &$value)
							{
								$wrking_tab = 'coursereg_arch_'.$value;

								$stmt = $mysqli->prepare("SELECT d.cCourseId, d.vCourseDesc, d.siLevel, d.tSemester, d.tdate, d.iCreditUnit, d.cAcademicDesc, d.cCategory
								FROM $wrking_tab d
								WHERE d.vMatricNo = ? 
								ORDER BY d.siLevel, d.tSemester, d.cCourseId");
								$stmt->bind_param("s", $_REQUEST['vMatricNo']);
								$stmt->execute();
								$stmt->store_result();

								$stmt->bind_result($cCourseId, $vCourseDesc, $siLevel, $tSemester, $tdate, $iCreditUnit, $cAcademicDesc_01, $cCategory);
								while($stmt->fetch())
								{
									$ref_table = src_table("s_f_s");
									$stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
									FROM $ref_table a, fee_items b
									WHERE a.fee_item_id = b.fee_item_id
									AND fee_item_desc = 'Course Registration'
									AND iCreditUnit = $iCreditUnit
									AND cEduCtgId = '$cEduCtgId_su'
									AND cFacultyId = '$cFacultyId_su'");

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

									if (isset($siLevel))
									{
										if ($prev_siLevel == '' || $prev_siLevel <> $siLevel || $rev_tSemester <> $tSemester)
										{?>
											<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:bold">
												<div class="ctabletd_1" style="width:100%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:left;">
													<?php echo $siLevel.'Level, ';
													if ($tSemester == 1)
													{
														echo 'First semester';
													}else
													{
														echo 'Second semester';
													}?>
												</div>
											</div><?php
										}
									}?>

									<div class="innercont" style="margin-left:0px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:normal">
										<div class="ctabletd_1" style="width:5.1%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:right;">
											<?php echo $c ?>
										</div>
										
										<div class="ctabletd_1" style="width:11.1% ;height:inherit; margin-left:-1px; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
											<?php echo $cCourseId; ?>
										</div>

										<div class="ctabletd_1" style="width:43.9%; height:inherit; margin-left:-1px; padding-top:5px; padding-left:3px; border:1px solid #A7BAAD; text-align:left;">
											<?php echo $vCourseDesc; ?>
										</div>

										<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:3px; padding-top:5px; padding-right:4px; border:1px solid #A7BAAD; text-align:right;">
											<?php echo $iCreditUnit; $tcc += $iCreditUnit; ?>
										</div>

										<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:2px; padding-top:5px;border:1px solid #A7BAAD; text-align:centeer;">
											<?php echo $cCategory; ?>
										</div>

										<div class="ctabletd_1" style="width:10%; margin-left:-1px; padding-right:3px; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;">
											<?php echo number_format($Amount, 0, '.', ',');$total_cost = $total_cost + $Amount; ?>
										</div>

										<div class="ctabletd_1" style="width:10.1%; margin-left:-1px; height:inherit; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
											<?php echo substr($tdate,8,2).'/'.substr($tdate,5,2).'/'.substr($tdate,0,4); ?>
										</div>				
									</div><?php
									if (isset($siLevel))
									{
										$prev_siLevel =  $siLevel;
										$rev_tSemester = $tSemester;
									}
								}
							}?>
						</ul>
						
						<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-top:3px; font-weight:bold; width:100%; padding:0px;">
							<div class="ctabletd_1" style="width:60.7%; height:17px; padding-top:5px; padding-right:3px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Total</div>
							<div class="ctabletd_1" style="width:8.1%; height:17px; padding-right:2px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
								<?php echo $tcc ?>
							</div>
							
							<div class="ctabletd_1" style="width:8%; height:17px; text-indent:2px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;"></div>
							
							<div class="ctabletd_1" style="width:10.1%; padding-right:2px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
								<?php echo number_format($total_cost, 0, '.', ',') ?>
							</div>

							<div class="ctabletd_1" style="width:10%; height:17px; padding-right:2px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:centeer;"></div>				
						</div><?php
					}else if ($_REQUEST['side_menu_no'] == 'see_all_registered_courses_for_exam')
					{
						$c = 0; 
						$total_cost = 0; 
						$total_cr = 0;

						$prev_sem = '';
						$prev_lev = '';?>

						<ul id="rtside" class="checklist" style=" padding:0px; height:auto; border:0px solid #cccccc;"><?php
							$table = search_starting_pt_crs($_REQUEST['vMatricNo']);
				
							foreach ($table as &$value)
							{
								$wrking_exam_tab = 'examreg_'.$value;
                        
                                $stmt = $mysqli->prepare("SELECT cCourseId, silevel, cAcademicDesc, tSemester
                                FROM $wrking_exam_tab 
                                WHERE vMatricNo = ? 
                                ORDER BY cAcademicDesc, tSemester, cCourseId");
                                
                                $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($cCourseId, $siLevel, $cAcademicDesc_ex, $tSemester_01);

                                while($stmt->fetch())
                                {
                                    foreach ($table as &$value1)
                                    {
										$wrking_crs_tab = 'coursereg_arch_'.$value1;

                                        $stmt_ex = $mysqli->prepare("SELECT vCourseDesc, tdate, iCreditUnit, cAcademicDesc, cCategory
                                        FROM $wrking_crs_tab
                                        WHERE cCourseId = '$cCourseId'
                                        AND vMatricNo = ?");
                                        $stmt_ex->bind_param("s", $_REQUEST["vMatricNo"]);
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
												<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:bold">
													<div class="ctabletd_1" style="width:100%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:left;">
													<?php echo $siLevel.'L '.$tSemester_desc;?>
													</div>
												</div><?php
											}?>

											<div class="innercont" style="margin-left:0px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:normal">
												<div class="ctabletd_1" style="width:5.1%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:right;">
													<?php echo $c ?>
												</div>
												
												<div class="ctabletd_1" style="width:11.1% ;height:inherit; margin-left:-1px; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
													<?php echo $cCourseId; ?>
												</div>

												<div class="ctabletd_1" style="width:43.9%; height:inherit; margin-left:-1px; padding-top:5px; padding-left:3px; border:1px solid #A7BAAD; text-align:left;">
													<?php echo $vCourseDesc; ?>
												</div>

												<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:3px; padding-top:5px; padding-right:4px; border:1px solid #A7BAAD; text-align:right;">
													<?php echo $iCreditUnit; $total_cr += $iCreditUnit; ?>
												</div>

												<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:2px; padding-top:5px;border:1px solid #A7BAAD; text-align:centeer;">
													<?php echo $cCategory; ?>
												</div>

												<div class="ctabletd_1" style="width:10%; margin-left:-1px; padding-right:3px; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;">
												<?php if ($ancilary_type == 'normal' || $ancilary_type == 'Laboratory')
                                                        {
                                                            echo number_format($Amount, 0, '', ','); $total_cost += $Amount;
                                                        }else
                                                        {
                                                            echo 'NA';
                                                        }?>
												</div>

												<div class="ctabletd_1" style="width:10.1%; margin-left:-1px; height:inherit; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
													<?php echo substr($tdate,8,2).'/'.substr($tdate,5,2).'/'.substr($tdate,0,4); ?>
												</div>				
											</div><?php
										}
									}
                                    
                                    $prev_sem = $tSemester_01;
                                    $prev_lev = $siLevel;
								}
							}?>						
						</ul>
						<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-top:3px; font-weight:bold; width:100%; padding:0px;">
							<div class="ctabletd_1" style="width:60.7%; height:17px; padding-top:5px; padding-right:3px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Total</div>
							<div class="ctabletd_1" style="width:8.1%; height:17px; padding-right:2px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
								<?php echo $total_cr ?>
							</div>
							
							<div class="ctabletd_1" style="width:8%; height:17px; text-indent:2px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;"></div>
							
							<div class="ctabletd_1" style="width:10.1%; padding-right:2px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
								<?php echo number_format($total_cost, 0, '.', ',') ?>
							</div>

							<div class="ctabletd_1" style="width:10%; height:17px; padding-right:2px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:centeer;"></div>				
						</div><?php

					}?>
				</div><?php
			}else if (isset($_REQUEST['side_menu_no']) && $_REQUEST['side_menu_no'] == 'register_courses')
			{?>
				<div class="innercont" style="margin-top:7px; height:auto; margin-left:4px; border-radius:0px;width:840px;">
					<div class="innercont" style="margin-top:-1px; margin-left:-1px; margin-bottom:4px; padding-top:5px; border-radius:0px; width:97%; border: 0px solid #ccc;">
						<b>Academic History</b>	
					</div>
						<input name="vApplicationNo_img" id="vApplicationNo_img" type="hidden" />
						<input name="user_cat" id="user_cat" type="hidden" value="<?php echo $_REQUEST['user_cat']; ?>" />	
						<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
						<input name="currency" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
						<input name="cQualCodeId" id="cQualCodeId" type="hidden" value="" />
						<input name="vExamNo" id="vExamNo" type="hidden" value="" />
						<input name="loadcred" id="loadcred" type="hidden" value="" /><?php
						
						$stmt = $mysqli->prepare("select cEduCtgId, vExamNo, a.cQualCodeId, a.vExamSchoolName, vQualCodeDesc, cExamMthYear, c.vApplicationNo
						from applyqual_stff a, qualification b, afnmatric c 
						where a.cQualCodeId = b.cQualCodeId 
						and c.vMatricNo = a.vMatricNo
						and c.vMatricNo = ? order by right(a.cExamMthYear,4), left(a.cExamMthYear,2)");
						$stmt->bind_param("s", $vMatricNo);
						$stmt->execute();
						$stmt->store_result();	
						$stmt->bind_result($cEduCtgId, $vExamNo, $cQualCodeId, $vExamSchoolName, $vQualCodeDesc, $cExamMthYear, $vApplicationNo);
						$coun = $stmt->num_rows;
						$cred_cnt = 0;

						while($stmt->fetch())
						{
							$coun--;$cred_cnt++;

							$post_str = '';
							if ($cEduCtgId == 'OLX' ||  $cEduCtgId == 'OLZ'){$post_str = '335px';}
							else if ($cEduCtgId == 'OLY' ||  $cEduCtgId == 'ALX' ||  $cEduCtgId == 'ALY'){$post_str = '220px';}
							else if ($cEduCtgId == 'EVS'){$post_str = '175px';}
							else if (($cEduCtgId == 'ALW' ||  $cEduCtgId == 'ALZ' || substr($cEduCtgId,0,1) ==  'P' || substr($cEduCtgId,0,2) ==  'EL') && ($cEduCtgId <> 'PRP' && $cEduCtgId <> 'PMR')){$post_str = '165px';}?>

							<div id="credentialNum<?php echo $cred_cnt; ?>" class="innercont" 
							style=" width:95.5%; margin-bottom:5px; margin-left:-1px; padding:5px; border-radius:0px; border: 1px dashed #000; height:<?php echo $post_str;?>"><?php
								/* ($study_mode == 'regular_pg')
								{*/?>
									<div class="innercont" style="text-align:right; width:auto; height:18px;"><?php
										$qualc = "?cQualCodeId=".$cQualCodeId.
										"&vExamNo=".$vExamNo.
										"&vApplicationNo=".$_REQUEST["vApplicationNo"];?>
										<a href="#" onclick="_('vExamNo').value='<?php echo $vExamNo ?>';
										_('cQualCodeId').value='<?php echo $cQualCodeId ?>';
										_('vApplicationNo_img').value='<?php echo $vApplicationNo ?>';
										call_image();
										return false">
											<img src="img/cert.gif" title="Click to see uploaded scanned copy of credential" style="text-decoration:none" border="0" align="bottom"/>
										</a>
									</div><?php
								//}?>
								<div class="innercont" style="width:auto; height:20px; margin-top:-1px; padding:0px">
									<label class="div_lab">Exam Authority</label>
									<label class="div_val" style="width:420px;"><?php echo stripslashes($vQualCodeDesc);?></label>
								</div>
								<div class="innercont" style="width:auto; height:20px; margin-top:-1px; padding:0px;">
									<label class="div_lab">Centre/School Name</label>
									<label class="div_val" style="width:420px;"><?php echo ucwords(strtolower(stripslashes($vExamNo)));?></label>
								</div>

								<div class="innercont" style="width:auto; height:20px; margin-top:-1px; padding:0px;">
									<label class="div_lab">Month and year of qualification</label>
									<label class="div_val" style="width:420px;"><?php echo ucwords(strtolower(stripslashes($cExamMthYear)));?></label>
								</div>

								<div class="innercont" style="width:auto; height:20px; margin-top:-1px; padding:0px;">
									<label class="div_lab" style="text-align:right; font-weight:bold;background-color:#E3EBE2;border:1px solid #A7BAAD;">Subject</label>
									<label class="div_val" style="width:420px; text-align:left; margin-left:4px; font-weight:bold;background-color:#E3EBE2;border:1px solid #A7BAAD;">Grade<?php 
									$qual = "s6.cQualCodeId.value='".$cQualCodeId.
									"';s6.vExamNo.value='".$vExamNo."';";?>
									</label>
								</div><?php

								$stmt1 = $mysqli->prepare("select vQualSubjectDesc, cQualGradeCode from applysubject a, qualsubject b, qualgrade c, afnmatric d
								where a.cQualSubjectId = b.cQualSubjectId and
								a.cQualCodeId = '".$cQualCodeId."' and
								a.vExamNo = '".$vExamNo."' and
								a.cQualGradeId = c.cQualGradeId and
								d.vApplicationNo = a.vApplicationNo and 
								d.vMatricNo = ?");
								$stmt1->bind_param("s", $vMatricNo);
								$stmt1->execute();
								$stmt1->store_result();
								$stmt1->bind_result($vQualSubjectDesc, $cQualGradeCode);

								while($stmt1->fetch())
								{?>
									<div class="innercont" style="width:auto; height:20px; margin-top:-1px;">
										<label class="div_lab" style="text-align:right;">
											<?php echo ucwords(strtolower(stripslashes($vQualSubjectDesc)));?>
										</label>
										<label class="div_val" style="text-align:left; margin-left:4px; width:420px;">
											<?php echo stripslashes($cQualGradeCode);?>
										</label>
									</div><?php
								}
								$stmt1->close();?>
							</div><?php
						}
						$stmt->close();?>
				</div><?php
			}else if (isset($_REQUEST['side_menu_no']) && $_REQUEST['side_menu_no'] == '14')
			{
				$new_curr = '';
				$curr_set = '';
				if (isset($_REQUEST['select_curriculum_prn']))
				{
					if ($_REQUEST['select_curriculum_prn'] == '1')
					{
						$new_curr = " AND c.cAcademicDesc <= 2023";
						$curr_set = '(Old curriculum)';
					}else if ($_REQUEST['select_curriculum_prn'] == '2')
					{
						$new_curr = " AND c.cAcademicDesc = 2024";
						$curr_set = '(New curriculum)';
					}
				}
				
				$stmt = $mysqli->prepare("select a.cCourseId 							
				FROM coursereg_arch a
				where a.siLevel = ".$iStudy_level." AND 
				a.cAcademicDesc = '".$orgsetins['cAcademicDesc']."' AND 
				a.tSemester = $tSemester AND 
				a.vMatricNo = ?");
				$stmt->bind_param("s", $vMatricNo);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($cCourseId);
								
				$Regcourse = '';
				while($stmt->fetch())
				{
					$Regcourse .= "'".$cCourseId."',";
				}
				$stmt->close();
				$Regcourse = "(".substr($Regcourse,0,strlen($Regcourse)-1).")";?>
				
				<div class="innercont_stff" style="margin-bottom:2px; margin-top:6px; font-weight:bold; font-size:12px;">My Exam Timetable</div>
				
				<div class="innercont" style="margin-left:3px; border-radius:0px; margin-bottom:3px; padding:0px; width:842px;">
					<div class="ctabletd_1" style="width:20px; height:17px; padding-top:5px; padding-right:3px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Sn</div>
					<div class="ctabletd_1" style="width:66px;height:17px; padding-top:5px; padding-left:2px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Date</div>
					<div class="ctabletd_1" style="width:25px; height:17px; padding-top:5px; padding-right:3px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Day</div>
					<div class="ctabletd_1" style="width:235px; height:17px; padding-top:5px; padding-left:2px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">8am</div>
					<div class="ctabletd_1" style="width:235px; height:17px; padding-top:5px; padding-left:2px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">11am</div>				
					<div class="ctabletd_1" style="width:235px; height:17px; padding-top:5px; padding-left:2px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">2pm</div>				
				</div><?php
				
				$rsday = mysqli_query(link_connect_db(), "select max(iday) a from tt") or die("error: ".mysqli_error(link_connect_db()));
				$sql_day = mysqli_fetch_array($rsday);?>
				
				<ul id="li1" class="checklist" style="margin-left:3px; width:841px"><?php
					$cnt = 0;
					for ($day = 1; $day <= $sql_day['a']; $day++)
					{
						$rschkCourse = mysqli_query(link_connect_db(), "select cCourseId, FixCourse from tt where iday = $day and cCourseId in $Regcourse") or die("error: ".mysqli_error(link_connect_db()));
						if (mysqli_num_rows($rschkCourse) == 0){continue;}
						$cnt++;
						$chkCourse = mysqli_fetch_array($rschkCourse);?>						
						<li <?php if ($cnt%2 == 0){echo ' class="alt"';}?> style="height:25px; width:844px">
							<div class="ctabletd_1" style="width:20px;height:20px; border:1px solid #A7BAAD; text-align:right; padding-right:3px; border-radius: 0px 0px 0px 0px;"><?php echo $cnt?></div>
							<div class="ctabletd_1" style="width:66px; height:20px; border:1px solid #A7BAAD; padding-left:2px; text-align:left;"><?php echo $chkCourse['FixCourse'];?></div>
							<div class="ctabletd_1" style="width:25px; height:20px; border:1px solid #A7BAAD; padding-right:3px; text-align:right;"><?php echo $day?></div><?php
							for ($ses = 1; $ses <= 3; $ses++)
							{
								$sql = "select concat(a.cCourseId,' ', b.vCourseDesc), b.iCreditUnit, c.cCategory
								from tt a, courses b, progcourse c 
								where a.cCourseId = b.cCourseId 
								AND a.cCourseId = c.cCourseId
								$new_curr 
								AND iday = $day and cSession = $ses 
								c.cProgrammeId = '". $cProgrammeId ."' and a.cCourseId in $Regcourse";
								$rschkCourse = mysqli_query(link_connect_db(), $sql) or die("error: ".mysqli_error(link_connect_db()));
								$chkCourse = mysqli_fetch_array($rschkCourse);?>
								<div class="ctabletd_1" style="width:235px; height:20px; border:1px solid #A7BAAD; padding-left:2px; text-align:left;">
									<?php if (isset($chkCourse[0])){echo cutlen($chkCourse[0], 35,'0').'['.$chkCourse[1].']'.'['.$chkCourse[2].']';}?>
								</div><?php
							}?>
						</li><?php
					}?>
				</ul><?php
			}else if (isset($_REQUEST['side_menu_no']) && $_REQUEST['side_menu_no'] == '16')
			{
				$new_curr = '';
				$curr_set = '';
				if (isset($_REQUEST['select_curriculum_prn']))
				{
					if ($_REQUEST['select_curriculum_prn'] == '1')
					{
						$new_curr = " AND f.cAcademicDesc <= 2023";
						$curr_set = '(Old curriculum)';
					}else if ($_REQUEST['select_curriculum_prn'] == '2')
					{
						$new_curr = " AND f.cAcademicDesc = 2024";
						$curr_set = '(New curriculum)';
					}
				}

				$stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, d.siLevel, d.tSemester, d.tdate, a.iCreditUnit, d.cAcademicDesc, a.cCategory
				FROM coursereg_arch a, s_m_t c, examreg d
				WHERE  a.cCourseId = d.cCourseId
				AND c.vMatricNo = d.vMatricNo
				AND c.vMatricNo = ? 
				ORDER BY d.siLevel, d.tSemester, d.cCourseId");
				$stmt->bind_param("s", $_REQUEST['vMatricNo']);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($cCourseId_01, $vCourseDesc_01, $siLevel_01, $tSemester_01, $tdate, $iCreditUnit_01, $cAcademicDesc_01, $cCategory_01);
                
                
				$stmt1 = $mysqli->prepare("SELECT a.cCourseId, iobtained_comp, show_student, cgrade, a.cAcademicDesc  
				from examreg_result a, s_m_t d, progcourse f 
				where d.cProgrammeId = f.cProgrammeId 
				AND a.cCourseId = f.cCourseId 
				AND a.vMatricNo = d.vMatricNo
				$new_curr
				AND a.vMatricNo = ? 
				ORDER BY f.siLevel, f.tSemester, a.cCourseId");

				$stmt1->bind_param("s", $_REQUEST['vMatricNo']);
				$stmt1->execute();
				$stmt1->store_result();
				$stmt1->bind_result($cCourseId_02, $score_02, $show_student_02, $cgrade_02, $session_02);
				
				$arr_grade = array(array(array(array())));
				$cnt = 0;

				while($stmt1->fetch())
				{
					$cnt++;
					$arr_grade[$cnt]['cCourseId'] = $cCourseId_02;
					$arr_grade[$cnt]['score'] = $score_02;

					$arr_grade[$cnt]['show_student'] = $show_student_02;
					$arr_grade[$cnt]['cgrade'] = $cgrade_02;
					$arr_grade[$cnt]['cAcademicDesc'] = $session_02;
				}
				$stmt1->close();?>
				<div class="innercont" style="margin-top:7px; height:auto; margin-left:4px; border-radius:0px; width:840px;font-size: 1.0em;">
					<div class="innercont" style="margin-top:-1px; margin-left:-1px; padding-top:5px; border-radius:0px;width:840px;border: 0px solid #FFFFFF;">
						<b>Examination result</b>	
					</div>

					<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:normal">
						<div class="ctabletd_1" style="width:5%; height:17px; padding-top:5px; padding-right:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Sno</div>
						
						<div class="ctabletd_1" style="width:10% ;height:17px; margin-left:-1px; text-indent:2px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Course code</div>

						<div class="ctabletd_1" style="width:42.7%; height:17px; margin-left:-1px; padding-top:5px; padding-left:3px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Course title</div>

						<div class="ctabletd_1" style="width:6%; height:17px; margin-left:-1px; padding-right:3px; padding-top:5px; padding-right:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Cr. unit</div>

						<div class="ctabletd_1" style="width:8%; height:17px; margin-left:-1px; padding-right:2px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:centeer;">Mandate</div>

						<div class="ctabletd_1" style="width:9%; height:17px; margin-left:-1px; padding-right:2px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:centeer;">Session</div>

						<div class="ctabletd_1" style="width:5%; margin-left:-1px; padding-right:3px; height:17px; padding-top:5px; padding-right:3px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;">Grade</div>

						<div class="ctabletd_1" style="width:7%; margin-left:-1px; height:17px; text-indent:2px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Repeat</div>				
					</div><?php
						$c = 0;

						$tcc = 0;
						$sem_tcc = 0;
						 
						$tcp = 0; 
						$sem_tcp = 0;
	
						$tc_with_result = 0;
						$sem_tc_with_result = 0;
	
						$prev_level = ''; 
						$prev_sem = '';
	
						$wgp = 0; 
						$sem_wgp = 0;
	
						$total_cr = 0;
                    
						while($stmt->fetch())
						{
							$cgrade_01 = '';
							for ($i = 1; $i <= count($arr_grade); $i++)
							{
								if (isset($arr_grade[$i]['cCourseId']))
								{
									if ($arr_grade[$i]['cCourseId'] == $cCourseId_01 /*&& $arr_grade[$cnt]['cAcademicDesc'] == $cAcademicDesc_01*/)
									{
										//$show_student_01 = $arr_grade[$i]['show_student'];
										$show_student_01 = 1;
										$cgrade_01 = $arr_grade[$i]['cgrade'];
										$score_01 = $arr_grade[$i]['score'];
										break;
									}
								}
							}

							if ($prev_sem <> '' && $prev_sem <> $tSemester_01)
							{?>
								<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:96.8%; padding:0px; margin-bottom:10px;  font-weight:normal">
									<div class="ctabletd_1" style="width:32%; height:17px; padding-top:5px; padding-right:4px; background-color:#FFFFFF; border:1px solid #A7BAAD; text-align:right; font-weight:bold;">
										Total credit carried (TCC): <?php echo $sem_tcc; ?>
									</div>
									<div class="ctabletd_1" style="width:32%; height:17px; padding-top:5px; padding-right:4px; background-color:#FFFFFF; border:1px solid #A7BAAD; text-align:right; font-weight:bold;">
										Totla credit earned (TCP): <?php echo $sem_tcp; ?>
									</div>
									<div class="ctabletd_1" style="width:33.5%; height:17px; padding-top:5px; padding-right:4px; background-color:#FFFFFF; border:1px solid #A7BAAD; text-align:right; font-weight:bold;">
										Grade point average (GPA): <?php 
										if($sem_tc_with_result>0 && $orgsetins["cShowgpa"] == '1' && $orgsetins["cShowrslt_for_staff"] == '1')
										{
											echo round(($sem_wgp/$sem_tc_with_result),2);
										}else
										{
											echo '-';
										}
										$wgp += $sem_wgp;?>
									</div>
								</div><?php
								$sem_tcc = 0;
								$sem_wgp = 0; 
								$sem_tcp = 0; 
								$sem_tc_with_result = 0;
							}


							if ($prev_sem == '' || ($prev_sem <> '' && $prev_sem <> $tSemester_01))
							{
								if ($tSemester_01 == 1)
								{
									$tSemester_desc = 'First semester';
								}else
								{
									$tSemester_desc = 'Second semester';
								}?>
								
								<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:96%; padding:0px ;margin-top:10px;  font-weight:normal">
									<div class="ctabletd_1" style="width:100%; height:17px; padding-top:5px; padding-right:4px; background-color:#FFFFFF; border:1px solid #A7BAAD; text-align:left;font-weight:bold;">
									<?php echo $siLevel_01.'L '.$tSemester_desc;?>
									</div>
								</div><?php
							}
							
							$c++;
	
							$sem_tcc = $sem_tcc + $iCreditUnit_01;
							$tcc = $tcc + $iCreditUnit_01;
	
							$course_status = 'Pending';
						   
							if (isset($cgrade_01) && $cgrade_01 <> '')
							{
								if ($cgrade_01 == 'A')
								{
									$sem_wgp = $sem_wgp + (5 * $iCreditUnit_01);
								}else if ($cgrade_01 == 'B')
								{
									$sem_wgp = $sem_wgp + (4 * $iCreditUnit_01);
								}else if ($cgrade_01 == 'C')
								{
									$sem_wgp = $sem_wgp + (3 * $iCreditUnit_01);
								}else if ($cgrade_01 == 'D')
								{
									$sem_wgp = $sem_wgp + (2 * $iCreditUnit_01);
								}else if ($cgrade_01 == 'E')
								{
									$sem_wgp = $sem_wgp + (1 * $iCreditUnit_01);
								}else if ($cgrade_01 == 'F')
								{
									$sem_wgp = $sem_wgp + (0 * $iCreditUnit_01);
								}
	
								if ($_REQUEST["cEduCtgId"] <> 'PGX' && $_REQUEST["cEduCtgId"] <> 'PGY')
								{
									if ($cgrade_01 <> 'F' && $cgrade_01 <> '')
									{
										$tcp = $tcp + $iCreditUnit_01;
										$sem_tcp = $sem_tcp + $iCreditUnit_01;
	
										$course_status = 'No';
									}else if ($cgrade_01 == 'F')
									{
										$course_status = 'Yes';
									}else 
									{
										$course_status = 'Pending';
									}
								}else
								{
									if ($cgrade_01 <> 'E' && $cgrade_01 <> '')
									{
										$tcp = $tcp + $iCreditUnit_01;
										$sem_tcp = $sem_tcp + $iCreditUnit_01;
	
										$course_status = 'No';
									}else if ($cgrade_01 == 'F')
									{
										$course_status = 'Yes';
									}else 
									{
										$course_status = 'Pending';
									}
								}								
								
								$tc_with_result = $tc_with_result +  $iCreditUnit_01;
								$sem_tc_with_result = $sem_tc_with_result +  $iCreditUnit_01;
							}else
							{
								$cgrade_01 = '--';
								$course_status = 'Pending';
							}?>

							<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:normal">
								<div class="ctabletd_1" style="width:5%; height:17px; padding-top:5px; padding-right:4px; border:1px solid #A7BAAD; text-align:right;">
									<?php echo $c;?>
								</div>
								
								<div class="ctabletd_1" style="width:10% ;height:17px; margin-left:-1px; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
									<?php echo $cCourseId_01; ?>
								</div>

								<div class="ctabletd_1" style="width:42.7%; height:17px; margin-left:-1px; padding-top:5px; padding-left:3px; border:1px solid #A7BAAD; text-align:left;">
									<?php echo $vCourseDesc_01;?>
								</div>

								<div class="ctabletd_1" style="width:6%; height:17px; margin-left:-1px; padding-right:3px; padding-top:5px; padding-right:4px; border:1px solid #A7BAAD; text-align:right;">
									<?php echo $iCreditUnit_01; $total_cr += $iCreditUnit_01;?>
								</div>

								<div class="ctabletd_1" style="width:8%; height:17px; margin-left:-1px; padding-right:2px; padding-top:5px;border:1px solid #A7BAAD; text-align:centeer;">
									<?php echo $cCategory_01;?>
								</div>

								<div class="ctabletd_1" style="width:9%; height:17px; margin-left:-1px; padding-right:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:centeer;">
									<?php echo substr($cAcademicDesc_01, 0, 4);?>
								</div>

								<div class="ctabletd_1" style="width:5%; margin-left:-1px; padding-right:3px; height:17px; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:center;">
									<?php if ($orgsetins["cShowrslt"] == '1' /*&& $show_student_01 == '1'*/)
									{
										if ($orgsetins["cShowgrade"] == '1' && $orgsetins["cShowscore"] == '1')
										{
											echo $cgrade_01.'-'.$score_01;
										}else if ($orgsetins["cShowscore"] == '1')
										{
											echo $score_01;
										}else if ($orgsetins["cShowgrade"] == '1')
										{
											echo $cgrade_01;
										}else
										{
											echo '--';
										}
									}else
									{
										echo "--";
									}?>
								</div>

								<div class="ctabletd_1" style="width:7%; margin-left:-1px; height:17px; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
								<?php echo $course_status;?>
								</div>				
							</div><?php
							
							$prev_level = $siLevel_01;
							$prev_sem = $tSemester_01;
						}
						$stmt->close();?>
						<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:96.8%; padding:0px; margin-bottom:10px;  font-weight:normal">
							<div class="ctabletd_1" style="width:32%; height:17px; padding-top:5px; padding-right:4px; background-color:#FFFFFF; border:1px solid #A7BAAD; text-align:right; font-weight:bold;">
								Total credit carried (TCC): <?php echo $sem_tcc; ?>
							</div>
							<div class="ctabletd_1" style="width:32%; height:17px; padding-top:5px; padding-right:4px; background-color:#FFFFFF; border:1px solid #A7BAAD; text-align:right; font-weight:bold;">
								Totla credit earned (TCP): <?php echo $sem_tcp; ?>
							</div>
							<div class="ctabletd_1" style="width:33.4%; height:17px; padding-top:5px; padding-right:4px; background-color:#FFFFFF; border:1px solid #A7BAAD; text-align:right; font-weight:bold;">
								Grade point average (GPA): <?php 
								if($sem_tc_with_result>0 && $orgsetins["cShowgpa"] == '1' && $orgsetins["cShowrslt_for_staff"] == '1')
								{
									echo round(($sem_wgp/$sem_tc_with_result),2);
								}else
								{
									echo '-';
								}
								$wgp += $sem_wgp;?>
							</div>
						</div>
						<div id="succ_boxu" class="succ_box_std orange_msg" 
							style="display:<?php if ($c == 0){?>block<?php }else{?>none<?php }?>; margin-top:95px; height:auto;  padding:25px; margin-left:170px;font-size:12px; line-height:1.5">
							<?php if ($c == 0)
							{
								echo 'No result for student yet';
							}?>
						</div>
					</ul><?php
					if ($vMatricNo <> '')
					{?>
						<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:96.8%; padding:0px; margin-bottom:10px;  font-weight:normal">
							<div class="ctabletd_1" style="width:32%; height:17px; padding-top:5px; padding-right:4px; background-color:#FFFFFF; border:1px solid #A7BAAD; text-align:right; font-weight:bold;">
								Cumm. credit carried (CCC): <?php echo $tcc ?>
							</div>
							<div class="ctabletd_1" style="width:32%; height:17px; padding-top:5px; padding-right:4px; background-color:#FFFFFF; border:1px solid #A7BAAD; text-align:right; font-weight:bold;">
								Cumm. credit passed (CCP): <?php echo $tcp ?>
							</div>
							<div class="ctabletd_1" style="width:33.4%; height:17px; padding-top:5px; padding-right:4px; background-color:#FFFFFF; border:1px solid #A7BAAD; text-align:right; font-weight:bold;">
								Cumm. GPA (CGPA):  <?php
								$f_grade = 0.0;
								if ($tc_with_result > 0 && $wgp > 0 && $orgsetins["cShowgpa"] == '1' && $orgsetins["cShowrslt_for_staff"] == '1' )
								{
									$f_grade = round(($wgp/$tc_with_result),2); 
									echo $f_grade.' ';
									if ($f_grade >= 4.50)
									{
										echo '(1st class)';
									}else if ($f_grade >= 3.50 && $f_grade <= 4.49)
									{
										echo '(2nd class upper)';
									}else if ($f_grade >= 2.40 && $f_grade <= 3.49)
									{
										echo '(2nd class lower)';
									}else if ($f_grade >= 1.50 && $f_grade <= 2.39)
									{
										echo '(3rd class)';
									}else
									{
										echo '(Advised)';
									}
								}else
								{
									echo '--';
								}?>
							</div>
						</div><?php
					}?>
				</div><?php
			}else if ((isset($_REQUEST['side_menu_no']) && $_REQUEST['side_menu_no'] == '17') || (isset($_REQUEST['sm']) && isset($_REQUEST['mm']) && $_REQUEST['mm'] == 0 && $_REQUEST['sm'] == 6))
			{?>
				<div class="innercont" style="margin-top:7px; height:auto; margin-left:-1px; border-radius:0px;width:99.6%;">
					<div class="innercont" style="margin-top:-1px; margin-bottom:5px; padding:5px; border-radius:0px; width:100%; height:auto; border:none;">
						<b>Admission Criteria</b>
					</div>

					<div class="innercont" style="margin-bottom:10px; margin-top:-1px; margin-bottom:5px; padding:5px; border-radius:0px; width:100%; height:auto; border:none;">
						<b><?php 
						$child_qry = " AND a.cProgrammeId LIKE '%".$_REQUEST['cprogrammeIdold_prns']."%' ";
						$begin_level = 100;
	
						$sReqmtId_qry = '';
	
						$cEduCtgId_2_qry = "cEduCtgId_2";
						$ordering = "ORDER BY cEduCtgId_1, $cEduCtgId_2_qry, b.cMandate, c.vQualSubjectDesc";
	
						$aa = get_qry_part('0', $_REQUEST['cFacultyIdold_prns'], $_REQUEST['cdeptold_prns'], $_REQUEST['cprogrammeIdold_prns'], $_REQUEST['courseLevel']);
						if ($aa <> '')
						{
							$sReqmtId_qry = $aa;
						}
	
						$bb = get_qry_part('1', $_REQUEST['cFacultyIdold_prns'], $_REQUEST['cdeptold_prns'], $_REQUEST['cprogrammeIdold_prns'], $_REQUEST['courseLevel']);
						if ($bb <> '')
						{
							$child_qry = $bb;
						}
	
						$cc =  get_qry_part('2', $_REQUEST['cFacultyIdold_prns'], $_REQUEST['cdeptold_prns'], $_REQUEST['cprogrammeIdold_prns'], $_REQUEST['courseLevel']);
						if ($cc <> '')
						{
							$begin_level = $cc;
						}
						
						$child_qry = " AND a.cProgrammeId LIKE '%".$_REQUEST['cprogrammeIdold_prns']."%' ";
						$begin_level = 100;
	
						$sReqmtId_qry = '';    
					
						$progr_cat_desc = $_REQUEST['courseLevel']. ' Level Admission Requirements';
						if ($_REQUEST["courseLevel"] == 20)
						{
							$progr_cat_desc = '<b> [Diploma] Admission Requirements</b>';
						}
						echo $_REQUEST['vFacultyDesc'].' :: ' . $_REQUEST['vProgrammeDesc'] .' :: '.$_REQUEST['courseLevel'].'Level';?></b>	
					</div><?php

					// echo "SELECT cEduCtgId_1, cEduCtgId_2, c.vQualSubjectDesc, b.cMandate, b.mutual_ex, d.cQualGradeCode
                    // FROM criteriadetail a, criteriasubject b, qualsubject c, qualgrade d
                    // WHERE a.cCriteriaId = b.cCriteriaId
                    // AND a.cProgrammeId = b.cProgrammeId
                    // AND a.sReqmtId = b.sReqmtId
                    // AND b.cQualSubjectId = c.cQualSubjectId
                    // AND b.cQualGradeId = d.cQualGradeId
                    // AND a.cCriteriaId = '".$_REQUEST['cFacultyIdold_prns']."'
                    // $child_qry
                    // AND ((a.iBeginLevel = $begin_level 
                    // $sReqmtId_qry)
                    // OR a.iBeginLevel = ".$_REQUEST['courseLevel'].")
                    // ORDER BY cEduCtgId_1, cEduCtgId_2, b.cMandate, c.vQualSubjectDesc";

					$stmt = $mysqli->prepare("SELECT cEduCtgId_1, cEduCtgId_2, c.vQualSubjectDesc, b.cMandate, b.mutual_ex, d.cQualGradeCode
                    FROM criteriadetail a, criteriasubject b, qualsubject c, qualgrade d
                    WHERE a.cCriteriaId = b.cCriteriaId
                    AND a.cProgrammeId = b.cProgrammeId
                    AND a.sReqmtId = b.sReqmtId
                    AND b.cQualSubjectId = c.cQualSubjectId
                    AND b.cQualGradeId = d.cQualGradeId
                    AND a.cCriteriaId = ?
                    $child_qry
                    AND ((a.iBeginLevel = $begin_level 
                    $sReqmtId_qry)
                    OR a.iBeginLevel = ?)
                    ORDER BY cEduCtgId_1, cEduCtgId_2, b.cMandate, c.vQualSubjectDesc");
                    $stmt->bind_param("si",  $_REQUEST['cFacultyIdold_prns'],  $_REQUEST['courseLevel']);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($cEduCtgId_1, $cEduCtgId_2, $vQualSubjectDesc, $cMandate, $mutual_ex, $cQualGradeCode);
                    $numOfcrthd = $stmt->num_rows; 
					
					if ($numOfcrthd == 0)
                    {
						caution_box('Please modify your options on the previous page and try again');
					}else
					{
						if ($_REQUEST["courseLevel"] > 100 && $_REQUEST['cprogrammeIdold_prns'] <> 'HSC201')
						{
							caution_box("You must meet the requiremnts for O'level and anyone of the listed higher qualifications to qualifiy for this programme at the selected level");
						}?>

						<div class="innercont" style="margin-top:-1px; margin-bottom:5px; border-radius:0px; width:100%; height:30px; border:none;font-weight:bold;">
							<div class="ctabletd_1" style="width:10.4%; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; border-radius:0px; height:auto; padding:8px 3px 8px 0px;">
								Sno
							</div>
							<div class="ctabletd_1" style="width:51%; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; margin-left:0.2%; height:auto; padding:8px 0px 8px 3px;">
								Subject
							</div>
							
							<div class="ctabletd_1" style="width:10.4%; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center; margin-left:0.2%; height:auto; padding:8px 0px 8px 3px;">
								Compulsory
							</div>
							
							<div class="ctabletd_1" style="width:10.4%; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center; margin-left:0.2%; height:auto; padding:8px 0px 8px 3px;">
								Optional
							</div>
							
							<div class="ctabletd_1" style="width:13.7%; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center; margin-left:0.2%; height:auto; padding:8px 0px 8px 3px;">
								Min. Grade
							</div>
						</div><?php

						$prev_cEduCtgId_2 = '';
						$cnt = 0;
						while($stmt->fetch())		
						{
							if (($prev_cEduCtgId_2 == '' && $cnt == 0) || $prev_cEduCtgId_2 <> $cEduCtgId_2){?>
								<div class="innercont" style="margin-top:0px; margin-bottom:5px; border-radius:0px; width:100%; height:25px; border:none;font-weight:bold; text-align:left"><?php 
									if ($cEduCtgId_2 == ''){
										echo "O'level subjects. Minimum number of subjects: 5. Maximum number of sittings: 2";
									}else if ($cEduCtgId_2 == 'ALX')
									{
										echo 'AL subjects. Minimum number of subjects: 2. Maximum number of sittings: 1';
									}else if ($cEduCtgId_2 == 'ALZ')
									{
										echo 'NCE AL subjects. Minimum number of subjects: 2. Maximum number of sittings: 1';
									}else if ($cEduCtgId_2 == 'ELZ')
									{
										echo 'OND subjects. Minimum number of subjects: 1. Maximum number of sittings: 1';
									}else if ($cEduCtgId_2 == 'PSX')
									{
										echo 'HND subjects. Minimum number of subjects: 1. Maximum number of sittings: 1';
									}else if ($cEduCtgId_2 == 'PSZ')
									{
										echo 'First degree subjects. Minimum number of subjects: 1. Maximum number of sittings: 1';
									}else if ($cEduCtgId_2 == 'PGX')
									{
										echo 'Post graduate diploma subjects. Minimum number of subjects: 1. Maximum number of sittings: 1';
									}?>
								</div><?php
								$cnt = 0;
							}
							
							if ($mutual_ex == 1){$text_color='#a87903';}else if ($mutual_ex == 2){$text_color='#0656b8';}else if ($mutual_ex == 3){$text_color='#05ad42';}else{$text_color='#000000';}

							if ($cnt%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
							
							<div class="innercont" style="margin-top:-1px; margin-bottom:5px; border-radius:0px; width:100%; height:30px; border:none;">
								<div class="ctabletd_1" style="width:10.2%; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; border-radius:0px; height:auto; padding:8px 3px 8px 0px; background-color:<?php echo $background_color;?>;">
									<?php echo ++$cnt; ?>
								</div>
								<div class="ctabletd_1" style="width:51%; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; margin-left:0.2%; height:auto; padding:8px 0px 8px 3px; background-color:<?php echo $background_color;?>;">
									<?php echo $vQualSubjectDesc; ?>
								</div>
								
								<div class="ctabletd_1" style="width:10.8%; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center; margin-left:0.2%; height:auto; padding:8px 0px 8px 3px; background-color:<?php echo $background_color;?>;">
									<?php if ($cMandate == 'C'){echo '<font color="#3aa238">Yes</font>';}else{echo '<font color="#f52e2e">No</font>';} ?>
								</div>
								
								<div class="ctabletd_1" style="width:10.3%; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center; margin-left:0.2%; height:auto; padding:8px 0px 8px 3px; background-color:<?php echo $background_color;?>;">
									<?php if ($cMandate <> 'C'){echo '<font color="#3aa238">Yes</font>';}else{echo '<font color="#f52e2e">No</font>';}?>
								</div>
								
								<div class="ctabletd_1" style="width:13.7%; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center; margin-left:0.2%; height:auto; padding:8px 0px 8px 3px; background-color:<?php echo $background_color;?>;">
									<?php echo $cQualGradeCode ?>
								</div>
							</div><?php
							
							$prev_cEduCtgId_2 = $cEduCtgId_2;
						}
						$stmt->close();
					}?>
				</div><?php
			}else if (isset($_REQUEST['side_menu_no']) && $_REQUEST['side_menu_no'] == '18')
			{?>
				<div class="innercont" style="margin-top:13px; text-align:center; margin-left:3px; font-size:12px; width:98.6%;">
					<?php echo  '<b>'.$_REQUEST['vFacultyDesc'].'</b>'; ?>
				</div>
				<div class="innercont" style="margin-bottom:2px; text-align:center; margin-left:3px; font-size:12px; width:98.6%;">
					<?php if (substr($_REQUEST['prog_cat_desc'],0,7) == 'Diploma')
					{echo  'List of <b>Diploma</b> programmes for which you are suitable';}else{echo  'List of <b>' . $_REQUEST['prog_cat_desc'].'</b> programmes for which you may be considered';} ?>
				</div><?php
				if (isset($_REQUEST['returnedStr']) && $_REQUEST['returnedStr'] <> '')
				{?>
					<div class="innercont" style="margin-left:4px; width:840px; border-radius:0px; margin-bottom:3px; padding:0px; background:#CCCCCC">
						<div class="ctabletd_1" style="width:30px; height:17px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">Sno</div>
						<div class="ctabletd_1" style="width:135px; height:17px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; text-indent:2px; margin-left:-1px">Qualification</div>
						<div class="ctabletd_1" style="width:662px; height:17px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; text-indent:2px; margin-left:-1px">Title</div>				
					</div><?php 
					
					$ind = -1;			 
			 		for ($i = 0; $i <= strlen($_REQUEST['returnedStr'])-1; $i+=145)
					{
						if (strlen(substr($_REQUEST['returnedStr'], $i)) < 145){break;}
						$ind++;?>
						<div class="innercont" style="margin-left:4px; width:840px; border-radius:0px; margin-bottom:3px; padding:0px;">
							<div class="ctabletd_1" style="width:30px; height:17px; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">
								<?php echo $ind+1;?>
							</div>
							
							<div class="ctabletd_1" style="width:135px; height:17px; border:1px solid #A7BAAD; text-align:left; text-indent:2px; margin-left:-1px">
								<?php echo trim(substr($_REQUEST['returnedStr'], $i+10, 20)); ?>
							</div>
							
							<div class="ctabletd_1" style="width:662px; height:17px; border:1px solid #A7BAAD; text-align:left; text-indent:2px; margin-left:-1px">
								<?php echo trim(substr($_REQUEST['returnedStr'], $i+30,100));?>
							</div>
						</div><?php
					}
				}else
				{?>
					<div class="succ_box blink_text orange_msg" id="succ_boxt" style="margin-top:15px; width:500px; margin-left:170px; display:block">
						No matching qualification found
					</div><?php
				}
			}else if (isset($_REQUEST['side_menu_no']) && $_REQUEST['side_menu_no'] == '26')
			{
				$new_curr = '';
				$curr_set = '';
				if (isset($_REQUEST['select_curriculum_prn']))
				{
					if ($_REQUEST['select_curriculum_prn'] == '1')
					{
						$new_curr = " AND e.cAcademicDesc <= 2023";
						$curr_set = '(Old curriculum)';
					}else if ($_REQUEST['select_curriculum_prn'] == '2')
					{
						$new_curr = " AND e.cAcademicDesc = 2024";
						$curr_set = '(New curriculum)';
					}
				}?>
				<div class="innercont" style="padding:10px; height:auto; margin-left:4px; width:96.5%; border-radius:0px; font-weight:bold">
					Personal exam timtetable
				</div>

				<div class="innercont" style="height:25px; margin-left:4px; width:840px; border-radius:0px; margin-bottom:3px; padding:0px; font-weight:bold;">
					<div class="ctabletd_1" style="width:11%; height:auto; padding:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; ">Date</div>
					<div class="ctabletd_1" style="width:27.9%; height:auto; padding:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; margin-left:-1px">Morning</div>
					<div class="ctabletd_1" style="width:27.9%; height:auto; padding:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; margin-left:-1px">Mid-morning</div>
					<div class="ctabletd_1" style="width:27.8%; height:auto; padding:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; margin-left:-1px">Afternoon</div>				
				</div><?php
				
				$stmt = $mysqli->prepare("SELECT a.cCourseId, b.vCourseDesc, iCreditUnit, e.cCategory, iday, cSession, start_date
                FROM examreg a, courses b, tt c, s_m_t d, progcourse e 
                WHERE a.cCourseId = b.cCourseId
                AND a.cCourseId = c.cCourseId
				AND d.cProgrammeId = e.cProgrammeId
				AND a.vMatricNo = d.vMatricNo
				AND a.cCourseId = e.cCourseId
				$new_curr
                AND a.tSemester = ?
                AND a.cAcademicDesc = '".$orgsetins["cAcademicDesc"]."'
                AND a.vMatricNo = ?
				ORDER BY iday");
            
                $stmt->bind_param("si", $_REQUEST["tSemester"], $_REQUEST["vMatricNo"]);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($cCourseId, $vCourseDesc, $iCreditUnit, $cCategory, $iday, $cSession, $start_date);
				$c = 0;
                while($stmt->fetch())
                {
					$c++;

					$iday_to_use = $iday - 1;

					while (1 == 1)
					{							
						$date = new DateTime($start_date);
						$date->modify("+$iday_to_use day");

						//Convert the date string into a unix timestamp.
						$unixTimestamp = strtotime($date->format("Y-m-d"));

						//Get the day of the week using PHP's date function.
						$dayOfWeek = date("l", $unixTimestamp);
						if ($dayOfWeek == 'Sunday')
						{
							//Print out the day that our date fell on.
							//echo $date . ' fell on a ' . $dayOfWeek;
							$iday_to_use++;
						}else
						{
							break;
						}
					}?>
					<div class="innercont" style="height:53px; margin-left:4px; width:840px; border-radius:0px; margin-bottom:3px; padding:0px;">
						<div class="ctabletd_1" style="width:11%; height:auto; padding:5px; border:1px solid #A7BAAD; text-align:left; "><?php
							$iday_to_use = $iday - 1;

							while (1 == 1)
							{							
								$date = new DateTime($start_date);
								$date->modify("+$iday_to_use day");

								//Convert the date string into a unix timestamp.
								$unixTimestamp = strtotime($date->format("Y-m-d"));

								//Get the day of the week using PHP's date function.
								$dayOfWeek = date("l", $unixTimestamp);
								if ($dayOfWeek == 'Sunday')
								{
									//Print out the day that our date fell on.
									//echo $date . ' fell on a ' . $dayOfWeek;
									$iday_to_use++;
								}else
								{
									break;
								}
							}

							echo 'Day '.$iday.'<br>'.$dayOfWeek.'<br>'.$date->format("d-m-Y");?>
						</div>
						<div class="ctabletd_1" style="width:27.9%; height:auto; padding:5px; border:1px solid #A7BAAD; text-align:left; margin-left:-1px"><?php if ($cSession == 1)
						{
							echo $cCategory.' '.$iCreditUnit.'<br>'.$cCourseId.'<br>'.$vCourseDesc;
						}else
						{
							echo '<font style="color:#FFFFFF">*<br>*<br>*</font>';
						}?></div>
						<div class="ctabletd_1" style="width:27.9%; height:auto; padding:5px; border:1px solid #A7BAAD; text-align:left; margin-left:-1px"><?php if ($cSession == 2)
						{
							echo $cCategory.' '.$iCreditUnit.'<br>'.$cCourseId.'<br>'.$vCourseDesc;
						}else
						{
							echo '<font style="color:#FFFFFF">*<br>*<br>*</font>';
						}?></div>
						<div class="ctabletd_1" style="width:27.8%; height:auto; padding:5px; border:1px solid #A7BAAD; text-align:left; margin-left:-1px"><?php if ($cSession == 3)
						{
							echo $cCategory.' '.$iCreditUnit.'<br>'.$cCourseId.'<br>'.$vCourseDesc;
						}else
						{
							echo '<font style="color:#FFFFFF">*<br>*<br>*</font>';
						}?></div>
					</div><?php					
				}
                $stmt->close();
			}/*else if (isset($_REQUEST['fee_sched']))
			{?>
				<div class="innercont_stff" style="margin-bottom:2px; margin-top:6px; font-weight:bold; font-size:12px;">Schedule of Fees</div>
				
				<div class="innercont" style="margin-left:4px; border-radius:0px; margin-bottom:3px; padding:0px; width:842px;">
					<div class="ctabletd_1" style="width:50px; height:17px; padding-top:5px; padding-right:3px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Sno.</div>
					<div class="ctabletd_1" style="width:635px;height:17px; padding-top:5px; padding-left:2px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Description</div>
					<div class="ctabletd_1" style="width:140px; height:17px; padding-top:5px; padding-right:3px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Cost</div>				
				</div><?php
				
				$sql_cat = '';
				$cEduCtgId_loc = $_REQUEST['cEduCtgId'];
				
				if ($_REQUEST["tSemester"] == 1)
				{
					$tSemester = 1;
				}else
				{
					$tSemester = 2;
				}

				if ($cEduCtgId_loc == 'PSZ')
				{
					//check whether student has paid one-off payment
					$stmt = $mysqli->prepare("SELECT a.* FROM s_tranxion a, s_f_s b
					WHERE a.iItemID = b.iItemID
					AND b.citem_cat = 'A1'
					AND vMatricNo = ? 
					AND cTrntype = 'd'
					AND b.cdel = 'N'");
					$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
					$stmt->execute();
					$stmt->store_result();
					if ($stmt->num_rows <> 0)
					{
						$sql_cat = " and (a.citem_cat = 'A1' or a.citem_cat = 'A3' or a.citem_cat = 'A4')";
					}else
					{
						//$sql_cat = " and (a.citem_cat = 'A3' or a.citem_cat = 'A4')";
						if ($tSemester == 1)
						{
							$sql_cat = " AND citem_cat = 'A4'";
						}else if ($tSemester == 2)
						{
							$sql_cat = " and (a.citem_cat = 'A5')";
						}
					}
					$stmt->close();
				}else if ($cEduCtgId_loc == 'PGX')
				{
					//check whether student has paid one-off payment
					$stmt = $mysqli->prepare("SELECT a.* FROM s_tranxion a, s_f_s b
					WHERE a.iItemID = b.iItemID
					AND b.citem_cat = 'B1'
					AND vMatricNo = ? 
					AND cTrntype = 'd'
					AND b.cdel = 'N'");
					$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
					$stmt->execute();
					$stmt->store_result();
					if ($stmt->num_rows == 0)
					{
						$sql_cat = " and (a.citem_cat = 'B1' or a.citem_cat = 'B3' or a.citem_cat = 'B4' or a.citem_cat = 'B6')";
					}else
					{
						$sql_cat = " and (a.citem_cat = 'B3' or a.citem_cat = 'B4' or a.citem_cat = 'B6')";
						if ($tSemester == 2)
						{
							$sql_cat = " and (a.citem_cat = 'B3' or a.citem_cat = 'B4')";
						}
					}
					$stmt->close();
				}else if ($cEduCtgId_loc == 'PGY')
				{
					//check whether student has paid one-off payment
					$stmt = $mysqli->prepare("SELECT a.* FROM s_tranxion a, s_f_s b
					WHERE a.iItemID = b.iItemID
					AND b.citem_cat = 'C1'
					AND vMatricNo = ? 
					AND cTrntype = 'd'
					AND b.cdel = 'N'");
					$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
					$stmt->execute();
					$stmt->store_result();
					if ($stmt->num_rows == 0)
					{
						$sql_cat = " and (a.citem_cat = 'C1' or a.citem_cat = 'C3' or a.citem_cat = 'C4' or a.citem_cat = 'C6')";
					}else
					{
						$sql_cat = " and (a.citem_cat = 'C3' or a.citem_cat = 'C4' or a.citem_cat = 'C6')";
						if ($tSemester == 2)
						{
							$sql_cat = " and (a.citem_cat = 'C3' or a.citem_cat = 'C4')";
						}
					}
					$stmt->close();
				}else if ($cEduCtgId_loc == 'ELZ')
				{
					//check whether student has paid one-off payment
					$stmt = $mysqli->prepare("SELECT a.* FROM s_tranxion a, s_f_s b
					WHERE a.iItemID = b.iItemID
					AND b.citem_cat = 'E1'
					AND vMatricNo = ? 
					AND cTrntype = 'd'
					AND b.cdel = 'N'");
					$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
					$stmt->execute();
					$stmt->store_result();
					if ($stmt->num_rows == 0)
					{
						$sql_cat = " and (a.citem_cat = 'E1' or a.citem_cat = 'E3' or a.citem_cat = 'E4' or a.citem_cat = 'E6')";
					}else
					{
						$sql_cat = " and (a.citem_cat = 'E3' or a.citem_cat = 'E4' or a.citem_cat = 'E6')";
						if ($tSemester == 2)
						{
							$sql_cat = " and (a.citem_cat = 'E3' or a.citem_cat = 'E4')";
						}
					}
					$stmt->close();
				}
				
				//$fac_dept_prog_spec_pay = "a.cEduCtgId = '".$cEduCtgId_loc."'";

				if ($_REQUEST['cFacultyId'] <> 'ALL')
				{
					$fac_dept_prog_spec_pay = " cFacultyId = '".$_REQUEST['cFacultyId']."'";
				}

				if ($_REQUEST['cdeptId'] <> 'ALL')
				{
					$fac_dept_prog_spec_pay .= " or cdeptId = '".$_REQUEST['cdeptId']."'";
				}

				$fac_dept_prog_spec_pay = " and (".$fac_dept_prog_spec_pay.")";
				$study_mode_loc = $_REQUEST['study_mode'];
				
				$arr = str_split($_REQUEST['iItemID_loc_prn'], $_REQUEST['split_point_loc']);
				$in  = str_repeat('?,', count($arr) - 1) . '?';

				$stmt = $mysqli->prepare("SELECT citem_cat_desc, b.fee_item_desc vDesc, Amount
				FROM s_f_s a, fee_items b, `sell_item_cat` c
				WHERE a.fee_item_id = b.fee_item_id
				AND a.`citem_cat` = c.`citem_cat`
				AND a.cdel = 'N'
				AND iItemID in ($in)
				ORDER BY a.citem_cat, vDesc");
				$types = str_repeat('s', count($arr));
				$stmt->bind_param($types, ...$arr);

				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($citem_cat_desc, $vDesc, $Amount);
								
				$NumOfRec = $stmt->num_rows;?>
				<ul id="li1" class="checklist" style="margin-left:4px; width:838px"><?php
					$cnt = 0;
					$total = 0;
					$prev_cat_desc = '';
					//for ($x = 1; $x <= 3; $x++)
					//{
						while ($stmt->fetch())
						{
							$cnt++;
					
							if ($prev_cat_desc == '' || $prev_cat_desc <> $citem_cat_desc)
							{?>
								<li style="height:27px; width:845px">
									<div class="ctabletd_1" style="width:inherit;height:20px; border:1px solid #A7BAAD; text-align:left; padding-right:3px; padding-top:6px; border-radius: 0px 0px 0px 0px;">
										<?php echo $citem_cat_desc;?>
									</div>
								</li><?php
							}?>
					
							<li <?php if ($cnt%2 == 0){echo ' class="alt"';}?> style="height:25px; width:843px">
								<div class="ctabletd_1" style="width:50px;height:20px; border:1px solid #A7BAAD; text-align:right; padding-right:3px; border-radius: 0px 0px 0px 0px;">
									<?php echo $cnt?>
								</div>
								
								<div class="ctabletd_1" style="width:635px; height:20px; border:1px solid #A7BAAD; padding-left:2px; text-align:left;">
									<?php echo $vDesc;?>
								</div>
								
								<div class="ctabletd_1" style="width:140px; height:20px; border:1px solid #A7BAAD; padding-right:3px; text-align:right;">
									<?php echo number_format($Amount, 2, '.', ',');?>
								</div>
							</li><?php
							$total += $Amount;
							$prev_cat_desc = $citem_cat_desc;
						}
						//mysqli_data_seek($rsql, 0);
					//}?>
					<li <?php if ($cnt%2 == 0){echo ' class="alt"';}?> style="height:25px; width:844px; font-weight:bold">
						<div class="ctabletd_1" style="width:689px; height:20px; border:1px solid #A7BAAD; padding-right:3px; text-align:right; background-color:#E3EBE2;">
							Total
						</div>

						<div class="ctabletd_1" style="width:140px; height:20px; border:1px solid #A7BAAD; padding-right:3px; text-align:right; background-color:#E3EBE2;">
							<?php echo number_format($total, 2);?>
						</div>
					</li>
				</ul><?php
			}*/else if (isset($_REQUEST['mm']))
			{
				$new_curr = '';
				$curr_set = '';
				if (isset($_REQUEST['select_curriculum_prn']))
				{
					if ($_REQUEST['select_curriculum_prn'] == '1')
					{
						$new_curr = " AND d.cAcademicDesc <= 2023";
						$curr_set = '(Old curriculum)';
					}else if ($_REQUEST['select_curriculum_prn'] == '2')
					{
						$new_curr = " AND d.cAcademicDesc = 2024";
						$curr_set = '(New curriculum)';
					}
				}

				if ($_REQUEST['side_menu_no'] == '4')
				{					
					$course_fee_width1 = '359px';
					$course_fee_width2 = '440px';
					if ($orgsetins['course_fee_cat'] == '1')
					{
						$course_fee_width1 = '282px';
						$course_fee_width2 = '383px';
					}
					
					if ($_REQUEST['tabb'] == '2' || $_REQUEST['tabb'] == '3')
					{
						$primary_table = 'coursereg';
						if ( $_REQUEST['tabb'] == '3')
						{
							$primary_table = 'examreg';
						}
						
						if ($orgsetins["course_fee_cat"] == 1)
						{
							$stmt = $mysqli->prepare("SELECT distinct a.cCourseId, b.vCourseDesc, a.tSemester, a.cAcademicDesc, a.tdate, b.iCreditUnit, d.cCategory, e.Amount
							from $primary_table a, courses b, s_m_t c, progcourse d, s_f_s e, programme f
							where a.cCourseId = b.cCourseId
							and a.vMatricNo = c.vMatricNo 
							and c.cProgrammeId = d.cProgrammeId
							and c.cProgrammeId = f.cProgrammeId
							and a.tSemester = d.tSemester  
							and a.siLevel = d.siLevel
							and b.iCreditUnit = e.iCreditUnit 
							and e.cEduCtgId = f.cEduCtgId
							AND e.cdel = 'N'
							$new_curr
							and a.vMatricNo = ?
							ORDER BY a.cAcademicDesc, d.siLevel, a.tSemester, a.cCourseId, a.tdate");
						}else
						{
							$stmt = $mysqli->prepare("SELECT a.cCourseId, b.vCourseDesc, a.tSemester, a.cAcademicDesc, a.tdate, b.iCreditUnit, d.siLevel, d.cCategory, '0.0' 
							FROM $primary_table a, courses b, progcourse d, s_m_t c, programme e 
							WHERE a.cCourseId = b.cCourseId 
							AND a.cCourseId = d.cCourseId 
							AND a.tSemester = d.tSemester 
							AND d.cProgrammeId = c.cProgrammeId 
							AND d.cProgrammeId = e.cProgrammeId
							AND a.siLevel = d.siLevel 
							AND c.iStudy_level = d.siLevel
							AND a.vMatricNo = c.vMatricNo
							$new_curr
							AND a.vMatricNo = ? 
							ORDER BY a.cAcademicDesc, d.siLevel, a.tSemester, a.cCourseId");
						}

						$stmt->bind_param("s", $vMatricNo);
						$stmt->execute();
						$stmt->store_result();
						
						$stmt->bind_result($cCourseId_01, $vCourseDesc_01, $tSemester_02, $cAcademicDesc_01, $tdate_01, $iCreditUnit_01, $siLevel_01, $cCategory_01, $amount_01);?>
						<div class="innercont" style="margin-top:7px; height:auto; margin-left:4px; border-radius:0px;width:840px;">
							<div class="innercont" style="margin-top:-1px; margin-left:-1px; padding-top:5px; border-radius:0px;width:840px;border: 1px solid #FFFFFF;font-weight:bold"><?php
								if ( $_REQUEST['tabb'] == '2')
								{
									echo 'Course Registration Record';
								}else
								{
									echo 'Exam Registration Record';
								}?>
							</div>
							<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:inherit; padding:0px;; font-weight:bold">
								<div class="ctabletd_1" style="width:40px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">Sno</div>
								<div class="ctabletd_1" style="width:83px;height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; text-indent:2px;">Course code</div>
								<div class="ctabletd_1" style="width:<?php echo $course_fee_width1;?>; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; text-indent:2px;">Course title</div>
								<div class="ctabletd_1" style="width:75px; height:17px; padding-top:5px; padding-right:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Credit Unit</div><?php
								if ($orgsetins['course_fee_cat'] == '1')
								{?>
									<div class="ctabletd_1" style="width:80px; height:17px; padding-top:5px; padding-right:2px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Fee</div><?php
								}?>
								<div class="ctabletd_1" style="width:50px; height:17px; padding-top:5px; padding-right:2px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;">Status</div>
								<div class="ctabletd_1" style="width:209px; height:17px; padding-top:5px; text-indent:2px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Dates</div>
							</div><?php

							$new_curr = '';
							$curr_set = '';
							if (isset($_REQUEST['select_curriculum_prn']))
							{
								if ($_REQUEST['select_curriculum_prn'] == '1')
								{
									$new_curr = " AND b.cAcademicDesc <= 2023";
									$curr_set = '(Old curriculum)';
								}else if ($_REQUEST['select_curriculum_prn'] == '2')
								{
									$new_curr = " AND b.cAcademicDesc = 2024";
									$curr_set = '(New curriculum)';
								}
							}?>

							<ul id="rtside" class="checklist" style="height:auto"><?php
								$c = 0; $total_cost = 0; $tcc = 0;
								$prev_sem = '';
								$prev_Level = '';
								$prev_cAcademicDesc = '';
								while($stmt->fetch())
								{
									$stmt_cors_arch = $mysqli->prepare("SELECT d.vCourseDesc, d.siLevel, d.tSemester, d.tdate, d.iCreditUnit, d.cAcademicDesc, b.cCategory, '0.0'
									FROM courses a, progcourse b, s_m_t c, coursereg_arch d
									WHERE a.cCourseId = b.cCourseId
									AND a.cCourseId = d.cCourseId
									AND b.cProgrammeId = c.cProgrammeId
									AND c.vMatricNo = d.vMatricNo
									AND c.vMatricNo = ?
									AND d.cCourseId = '$cCourseId'
									AND d.siLevel = $level
									AND b.cdel = 'N'");
									$stmt_cors_arch->bind_param("s", $_REQUEST["vMatricNo"]);
									$stmt_cors_arch->execute();
									$stmt_cors_arch->store_result();
									$stmt_cors_arch->bind_result($vCourseDesc_arch, $level_arch, $tSemester_arch, $tdate_arch, $iCreditUnit_arch, $cAcademicDesc_arch, $cCategory_arch, $amount_arch);

									if ($stmt_cors_arch->num_rows > 0)
									{
										$stmt_cors_arch->fetch();
										$vCourseDesc_01 = $vCourseDesc_arch;
										$iCreditUnit_01 = $iCreditUnit_arch;
										$siLevel_01 = $level_arch;
										
										$tSemester_02 = $tSemester_arch;
										$tdate_01 = $tdate_arch;
										$cAcademicDesc_01 = $cAcademicDesc_arch;
										$cCategory_01 = $cCategory_arch;
									}
									$stmt_cors_arch->close();
									$c++;
									
									if (($prev_cAcademicDesc == '' OR $prev_cAcademicDesc <> $cAcademicDesc_01) OR
									($prev_Level == '' OR $prev_Level <> $siLevel_01) OR
									($prev_sem == '' OR $prev_sem <> $tSemester_02))
									{?>
										<li style="text-align:left; height:24px; font-weight:bold"<?php if ($c%2 == 0){echo ' class="alt"';}?>>
											<div class="ctabletd_1" style="width:835px; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:left; padding-right:3px;">
												<?php echo $cAcademicDesc_01.', '.$siLevel_01.' Level,  Semester: '.$tSemester_02;?>
											</div>
										</li><?php
									}?>

									<li style="text-align:left; height:24px;"<?php if ($c%2 == 0){echo ' class="alt"';}?>>
										<div class="ctabletd_1" style="width:40px; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">
											<?php echo $c;?>
										</div>
										<div class="ctabletd_1" style="width:83px;height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:left; text-indent:2px;">
											<?php echo $cCourseId_01;?>
										</div>
										<div class="ctabletd_1" style="width:<?php echo $course_fee_width1;?>; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:left; text-indent:2px;">
											<?php if (strlen($vCourseDesc_01) > 44){echo substr($vCourseDesc_01, 0,44)."...";}else{echo $vCourseDesc_01;}?>
										</div>
										<div class="ctabletd_1" style="width:75px; height:17px; padding-top:5px; padding-right:4px; border:1px solid #A7BAAD; text-align:right;">
											<?php echo $iCreditUnit_01; 
											$tcc = $tcc + $iCreditUnit_01;?>
										</div><?php
										if ($orgsetins['course_fee_cat'] == '1')
										{?>
											<div class="ctabletd_1" style="width:80px; height:17px; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:right;">
												<?php echo number_format($amount_01, 2, '.', ',');
												$total_cost = $total_cost + $amount_01;?>
											</div><?php
										}?>
										<div class="ctabletd_1" style="width:50px; height:17px; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:center;">
											<?php echo $cCategory_01;?>
										</div>
										<div class="ctabletd_1" style="width:208px; height:17px; padding-top:5px; text-indent:2px; border:1px solid #A7BAAD; text-align:left;">
											<?php echo substr($tdate_01, 8, 2).'-'.substr($tdate_01, 5, 2).'-'.substr($tdate_01, 0, 4).' '.substr($tdate_01, 11);?>
										</div>
									</li><?php
									$prev_cAcademicDesc = $cAcademicDesc_01;
									$prev_Level = $siLevel_01;
									$prev_sem = $tSemester_02;
								}
								$stmt->close();?>

								<div id="succ_boxu" class="succ_box_std orange_msg" 
									style="display:<?php if ($c == 0){?>block<?php }else{?>none<?php }?>; margin-top:95px; margin-bottom:95px; height:auto;  padding:25px; margin-left:165px;font-size:11px; line-height:1.5">
									<?php if ($c == 0)
									{
										echo 'Student yet to register courses';
									} ?>
								</div>
							</ul>

							<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-top:3px; width:inherit; padding:0px; font-weight:bold">
								<div class="ctabletd_1" style="width:40px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; padding-right:3px;"></div>
								<div class="ctabletd_1" style="width:83px;height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; text-indent:2px;"></div>
								<div class="ctabletd_1" style="width:<?php echo $course_fee_width1;?>; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Total</div>
								<div class="ctabletd_1" style="width:75px; height:17px; padding-top:5px; padding-right:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
									<?php echo $tcc;?>
								</div>
								<div class="ctabletd_1" style="width:85px; height:17px; padding-top:5px; padding-right:2px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; text-indent:2px;"></div><?php
								if ($orgsetins['course_fee_cat'] == '1')
								{?>
									<div class="ctabletd_1" style="width:80px; height:17px; padding-top:5px; padding-right:2px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
										<?php echo number_format($total_cost, 2, '.', ',');?>
									</div><?php
								}?>
								<div class="ctabletd_1" style="width:60px; height:17px; padding-top:5px; padding-right:2px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;"></div>
								<div class="ctabletd_1" style="width:110px; height:17px; padding-top:5px; text-indent:2px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;"></div>
							</div>
						</div><?php
					}else if ($_REQUEST['tabb'] == '4')
					{
						// $stmt1 = $mysqli->prepare("SELECT a.cCourseId, iobtained_comp, show_student, cgrade, a.cAcademicDesc  
						// from examreg_result a, courses b, s_m_t d, progcourse f 
						// where a.cCourseId = b.cCourseId
						// AND d.cProgrammeId = f.cProgrammeId 
						// AND a.cCourseId = f.cCourseId 
						// AND a.vMatricNo = d.vMatricNo
						// AND a.cAcademicDesc = '".$orgsetins["cAcademicDesc"]."'
						// AND a.vMatricNo = ? 
						// ORDER BY f.siLevel, f.tSemester, a.cCourseId");

						// $stmt1->bind_param("s", $vMatricNo);
						// $stmt1->execute();
						// $stmt1->store_result();
						// $stmt1->bind_result($cCourseId_02, $score_02, $show_student_02, $cgrade_02, $session_02);
						
						// $arr_grade = array(array(array(array())));
						// $cnt = 0;

						// while($stmt1->fetch())
						// {
						// 	$cnt++;
						// 	$arr_grade[$cnt]['cCourseId'] = $cCourseId_02;
						// 	$arr_grade[$cnt]['score'] = $score_02;

						// 	$arr_grade[$cnt]['show_student'] = $show_student_02;
						// 	$arr_grade[$cnt]['cgrade'] = $cgrade_02;
						// 	$arr_grade[$cnt]['cAcademicDesc'] = $session_02;
						// }
						// $stmt1->close();

						// if ($orgsetins["regexam"] == '1')
						// {
						// 	$stmt = $mysqli->prepare("SELECT a.cCourseId, b.vCourseDesc, d.siLevel, a.cAcademicDesc, b.iCreditUnit, '0.0', d.cCategory, e.cEduCtgId, a.tSemester, 0,'','' 
						// 	FROM examreg a, courses b, progcourse d, s_m_t c, programme e 
						// 	WHERE a.cCourseId = b.cCourseId 
						// 	AND a.cCourseId = d.cCourseId 
						// 	AND a.tSemester = d.tSemester 
						// 	AND d.cProgrammeId = c.cProgrammeId 
						// 	AND d.cProgrammeId = e.cProgrammeId
						// 	AND a.siLevel = d.siLevel 
						// 	AND c.iStudy_level = d.siLevel
						// 	AND a.vMatricNo = c.vMatricNo
						// 	AND a.cAcademicDesc = '".$orgsetins["cAcademicDesc"]."'
						// 	AND a.vMatricNo = ? 
						// 	ORDER BY  d.siLevel, a.tSemester, a.cCourseId");
						// }else
						// {
						// 	$stmt = $mysqli->prepare("SELECT a.cCourseId, b.vCourseDesc, d.siLevel, a.cAcademicDesc, b.iCreditUnit, '0.0', d.cCategory, e.cEduCtgId, a.tSemester, 0,'',''   
						// 	FROM coursereg a, courses b, progcourse d, s_m_t c, programme e 
						// 	WHERE a.cCourseId = b.cCourseId 
						// 	AND a.cCourseId = d.cCourseId 
						// 	AND a.tSemester = d.tSemester 
						// 	AND d.cProgrammeId = c.cProgrammeId 
						// 	AND d.cProgrammeId = e.cProgrammeId
						// 	AND a.siLevel = d.siLevel 
						// 	AND c.iStudy_level = d.siLevel
						// 	AND a.vMatricNo = c.vMatricNo
						// 	AND a.cAcademicDesc = '".$orgsetins["cAcademicDesc"]."'
						// 	AND a.vMatricNo = ? 
						// 	ORDER BY  d.siLevel, a.tSemester, a.cCourseId");
						// }
						// $stmt->bind_param("s", $vMatricNo);
						// $stmt->execute();
						// $stmt->store_result();
						
						// $stmt->bind_result($cCourseId_02, $vCourseDesc_02, $siLevel_02, $cAcademicDesc_02, $iCreditUnit_02, $amount_02, $cCategory_02, $cEduCtgId_03, $tSemester_03, $score_01, $show_student_01, $cgrade_03);?>

						<!--<div class="innercont" style="margin-top:7px; height:auto; margin-left:4px; border-radius:0px;width:840px;">
							<div class="innercont" style="margin-top:-1px; margin-left:-1px; padding-top:5px; border-radius:0px;width:840px;border: 1px solid #FFFFFF;font-weight:bold">
								Result
							</div>

							<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:inherit; padding:0px;; font-weight:bold">
								<div class="ctabletd_1" style="width:40px; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">Sno</div>
								<div class="ctabletd_1" style="width:83px;height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; text-indent:2px;">Course code</div>
								<div class="ctabletd_1" style="width:365px; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; text-indent:2px;">Course title</div>
								<div class="ctabletd_1" style="width:75px; height:17px; padding-top:5px; padding-right:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Credit Unit</div>
								<div class="ctabletd_1" style="width:60px; height:17px; padding-top:5px; padding-right:2px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;">Status</div>
								<div class="ctabletd_1" style="width:70px; height:17px; padding-top:5px; text-indent:2px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;">Grade</div>
								<div class="ctabletd_1" style="width:110px; height:17px; padding-top:5px; text-indent:2px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:center;">Remark</div>
							</div>

							<ul id="rtside" class="checklist" style="height:auto"><?php
								$total_cost = 0;
								 
								$c = 0; 

								$tcc = 0;
								$sem_tcc = 0;
								 
								$tcp = 0; 
								$sem_tcp = 0;
		
								$tc_with_result = 0;
								$sem_tc_with_result = 0;
		
								$prev_level = ''; 
								$prev_sem = '';

								$wgp = 0; 
								$sem_wgp = 0;
								$prev_cAcademicDesc = '';
								while($stmt->fetch())
								{
									for ($i = 1; $i <= count($arr_grade); $i++)
									{
										if ($arr_grade[$i]['cCourseId'] == $cCourseId_02 && $arr_grade[$cnt]['cAcademicDesc'] == $cAcademicDesc_02)
										{
											$show_student_01 = $arr_grade[$i]['show_student'];
											$cgrade_03 = $arr_grade[$i]['cgrade'];
											$score_01 = $arr_grade[$i]['score'];
											break;
										}
									}

									if (($prev_cAcademicDesc == '' OR $prev_cAcademicDesc <> $cAcademicDesc_02) OR
									($prev_Level == '' OR $prev_Level <> $siLevel_01) OR
									($prev_sem == '' OR $prev_sem <> $tSemester_02))
									{
										if ($prev_sem <> '' AND $prev_sem <> $tSemester_03)
										{?>
											<li id="ali<?php echo $c;?>" style="text-align:left; height:24px; margin-bottom:5px">
												<div class="ctabletd_1" style="width:275px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">
													Total credit carried (TCC): <?php echo $sem_tcc; ?>
												</div>
												<div class="ctabletd_1" style="width:275px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
													Total credit passed (TCP): <?php echo $sem_tcp; ?>
												</div>
												<div class="ctabletd_1" style="width:280px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
													Grade point average (GPA): <?php 
													if ($sem_tc_with_result > 0 && $orgsetins["cShowgpa"] == '1' && $orgsetins["cShowrslt_for_staff"] == '1')
													{
														echo round(($sem_wgp/$sem_tc_with_result),2);
													}
													else
													{
														echo '0';
													} 
													$wgp += $sem_wgp; ?>
												</div>
											</li><?php
											$sem_tcc = 0;
											$sem_wgp = 0; 
											$sem_tcp = 0; 
											$sem_tc_with_result = 0;
										}
										
										if ($prev_sem <> $tSemester_03)
										{?>

											<li style="text-align:left; height:24px;"<?php if ($c%2 == 0){echo ' class="alt"';}?>>
												<div style="padding:3px; font-weight:bold">
													<?php echo $cAcademicDesc_02.', '.$siLevel_02.' level, '; 
													if ($tSemester_03 == 1){echo 'First semester';}else{echo 'Second semester';}?>
												</div>
											</li><?php
										}
									}

									$c++;
									$tcc = $tcc + $iCreditUnit_02;
									$sem_tcc = $sem_tcc + $iCreditUnit_02;

									if ($show_student_01 == '1')
									{								
										if ($cgrade_03 == 'A')
										{
											$sem_wgp = $sem_wgp + (5 * $iCreditUnit_02);
										}else if ($cgrade_03 == 'B')
										{
											$sem_wgp = $sem_wgp + (4 * $iCreditUnit_02);
										}else if ($cgrade_03 == 'C')
										{
											$sem_wgp = $sem_wgp + (3 * $iCreditUnit_02);
										}else if ($cgrade_03 == 'D')
										{
											$sem_wgp = $sem_wgp + (2 * $iCreditUnit_02);
										}else if ($cgrade_03 == 'E')
										{
											$sem_wgp = $sem_wgp + (1 * $iCreditUnit_02);
										}else if ($cgrade_03 == 'F')
										{
											$sem_wgp = $sem_wgp + (0 * $iCreditUnit_02);
										}

										if ($cEduCtgId_su <> 'PGX' && $cEduCtgId_su <> 'PGY')
										{
											if ($cgrade_03 <> 'F')
											{
												$tcp = $tcp + $iCreditUnit_02;
												$sem_tcp = $sem_tcp + $iCreditUnit_02;
											}
										}else
										{
											if ($cgrade_03 <> 'E')
											{
												$tcp = $tcp + $iCreditUnit_02;
												$sem_tcp = $sem_tcp + $iCreditUnit_02;
											}
										}								
										
										$tc_with_result = $tc_with_result +  $iCreditUnit_02;
										$sem_tc_with_result = $sem_tc_with_result +  $iCreditUnit_02;
									}else
									{
										$cgrade_03 = '--';
									}?>


									<li style="text-align:left; height:24px;"<?php if ($c%2 == 0){echo ' class="alt"';}?>>
										<div class="ctabletd_1" style="width:40px; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">
											<?php echo $c;?>
										</div>
										<div class="ctabletd_1" style="width:83px; height:17px; padding-top:5px; text-indent:2px; border:1px solid #A7BAAD; text-align:left;">
											<?php echo $cCourseId_02;?>
										</div>
										<div class="ctabletd_1" style="width:365px; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:left; text-indent:2px;">
											<?php if (strlen($vCourseDesc_02) > 44){echo substr($vCourseDesc_02, 0,44)."...";}else{echo $vCourseDesc_02;}?>
										</div>
										<div class="ctabletd_1" style="width:75px; height:17px; padding-top:5px; border:1px solid #A7BAAD; text-align:right; padding-right:4px;">
											<?php echo $iCreditUnit_02;?>
										</div>
										<div class="ctabletd_1" style="width:60px; height:17px; padding-top:5px; padding-right:2px;  border:1px solid #A7BAAD; text-align:center; text-indent:2px;">
											<?php echo $cCategory_02;?>
										</div>
										<div class="ctabletd_1" style="width:70px; height:17px; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:center;">
											<?php echo $cgrade_03;?>
										</div>
										<div class="ctabletd_1" style="width:118px; height:17px; padding-top:5px; text-indent:2px; border:1px solid #A7BAAD; text-align:center;"><?php
											if ($cEduCtgId_03 <> 'PGX' && $cEduCtgId_03 <> 'PGY')
											{
												if ($cgrade_03 == 'F'){echo 'Repeat';}elseif ($cgrade_03 == '--'){echo 'Pending';}else{echo '--';}
											}else
											{
												if ($cgrade_03 == 'E'){echo 'Repeat';}elseif ($cgrade_03 == '--'){echo 'Pending';}else{echo '--';}
											}?>
										</div>
									</li><?php
									$prev_cAcademicDesc = $cAcademicDesc_02;
									$prev_Level = $siLevel_02;
									$prev_sem = $tSemester_03;
								}
								$stmt->close();?>
								<li id="ali<?php echo $c;?>" style="text-align:left; height:24px; margin-bottom:5px">
									<div class="ctabletd_1" style="width:275px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">
										Total credit carried (TCC): <?php echo $sem_tcc; $sem_tcc = 0; ?>
									</div>
									<div class="ctabletd_1" style="width:275px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
										Total credit earned (TCE): <?php echo $sem_tcp; ?>
									</div>
									<div class="ctabletd_1" style="width:280px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
										Grade point average (GPA): <?php 
										if ($sem_tc_with_result > 0 && $orgsetins["cShowgpa"] == '1' && $orgsetins["cShowrslt_for_staff"] == '1')
										{
											echo round(($sem_wgp/$sem_tc_with_result),2).' ';
										}else
										{
											echo '0';
										}
										$wgp += $sem_wgp; 
										$sem_wgp = 0; 
										$sem_tcp = 0; 
										$sem_tc_with_result = 0; ?>
									</div>
								</li>							
								
								<li id="ali<?php echo $c;?>" style="text-align:left; height:24px; margin-bottom:5px; font-weight:bold">
									<div class="ctabletd_1" style="width:275px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">
									Cummulative TCC: <?php echo $tcc; ?>
									</div>
									<div class="ctabletd_1" style="width:275px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
									Cummulative TCP: <?php echo $tcp; ?>
									</div>
									<div class="ctabletd_1" style="width:280px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">
										Cumm. GPA (CGPA): <?php
										if ($tc_with_result > 0 && $wgp > 0)
										{
											$f_grade = round(($wgp/$tc_with_result),2);
											echo 	$f_grade.' ';
											if ($f_grade >= 4.50)
											{
												echo '(1st class)';
											}else if ($f_grade >= 3.50 && $f_grade <= 4.49)
											{
												echo '(2nd class upper)';
											}else if ($f_grade >= 2.40 && $f_grade <= 3.49)
											{
												echo '(2nd class lower)';
											}else if ($f_grade >= 1.50 && $f_grade <= 2.39)
											{
												echo '(3rd class)';
											}else
											{
												echo '(Advised)';
											}
										}else
										{
											echo '0';
										}?>
									</div>
								</li>
								<div id="succ_boxu" class="succ_box_std orange_msg" 
									style="display:<?php if ($c == 0){?>block<?php }else{?>none<?php }?>; margin-top:95px; margin-bottom:95px; height:auto;  padding:25px; margin-left:165px;font-size:11px; line-height:1.5">
									<?php if ($c == 0)
									{
										echo 'No result for student yet';
									} ?>
								</div>
							</ul>
						</div>--><?php
					}
				}
			}
		}?>
	</div>
</body>
</html>