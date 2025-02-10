<?php
require_once('good_entry.php');

/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once(BASE_FILE_NAME.'lib_fn.php');
require_once('std_lib_fn.php');
$mysqli = link_connect_db();
?>
<!DOCTYPE html>
<html lang="en">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
		
	<title>NOUN-SMS</title>
	<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" /><?php


//include('php_qr_code/qrlib.php');
//$currency = eyes_pilled('0');

//require_once('stdnt_ids.php');

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
	$stmt = $mysqli->prepare("SELECT staff_study_center, cFacultyId FROM userlogin where vApplicationNo = ?");
	$stmt->bind_param("s", $_REQUEST['vApplicationNo']);$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cStudyCenterId, $cFacultyId);
	$stmt->fetch();
	$stmt->close();
}

$orgsetins = settns();

$semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);		
$account_close_date = substr($orgsetins['ac_close_date'],4,4).'-'.substr($orgsetins['ac_close_date'],2,2).'-'.substr($orgsetins['ac_close_date'],0,2);
$account_open_date = substr($orgsetins['ac_open_date'],4,4).'-'.substr($orgsetins['ac_open_date'],2,2).'-'.substr($orgsetins['ac_open_date'],0,2);		
$wrking_year_tab = WORKING_YR_TABLE;

$sql_sub1 = ''; $sql_sub2 = ''; $sql_sub3 = '';
if ($orgsetins['studycenter'] == '1')
{
	$sql_sub1 = ', studycenter f'; $sql_sub2 = 'and a.cStudyCenterId = f.cStudyCenterId'; $sql_sub3 = ', f.vCityName';
}

$vMatricNo = '';
$balance = 0;

if (isset($_REQUEST['vMatricNo']))
{
	$vMatricNo = $_REQUEST['vMatricNo'];
}


if ($vMatricNo <> '')
{
    $stmt = $mysqli->prepare("SELECT vTitle, vLastName, concat(vFirstName,' ',vOtherName) othernames, b.cFacultyId, b.vFacultyDesc, c.vdeptDesc,a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.iStudy_level, a.vMobileNo, a.vEMailId, a.tSemester, f.vCityName, e.cEduCtgId, a.cAcademicDesc,  a.cAcademicDesc_1, a.cResidenceCountryId
    FROM s_m_t a, faculty b, depts c, obtainablequal d, programme e, studycenter f
    WHERE a.cFacultyId = b.cFacultyId
    and a.cdeptId = c.cdeptId
    and a.cObtQualId = d.cObtQualId
    and a.cProgrammeId = e.cProgrammeId 
    and a.cStudyCenterId = f.cStudyCenterId
    and a.vMatricNo = ?");
	$stmt->bind_param("s", $vMatricNo);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($vTitle, $vLastName, $othernames, $cFacultyId, $vFacultyDesc, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $iStudy_level, $vMobileNo, $vEMailId, $tSemester, $vCityName, $cEduCtgId, $cAcademicDesc, $cAcademicDesc_1, $cResidenceCountryId);
	$stmt->fetch();

	$stmt = $mysqli->prepare("SELECT SUM(amount)
	FROM s_tranxion_cr
	WHERE LEFT(tdate,10) > '$account_close_date'
	AND vMatricNo = ?;");							
	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Amount_bal_1);
	$stmt->fetch();

	if (is_null($Amount_bal_1))
	{
		$Amount_bal_1 = 0.00;
	}
	//echo $Amount_bal_1;

	$stmt = $mysqli->prepare("SELECT SUM(amount)
	FROM $wrking_year_tab
	WHERE LEFT(tdate,10) > '$account_close_date'
	AND vMatricNo = ?;");							
	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Amount_bal_2);
	$stmt->fetch();

	if (is_null($Amount_bal_2))
	{
		$Amount_bal_2 = 0.00;
	}
	//echo ', '.$Amount_bal_2;


	$stmt = $mysqli->prepare("SELECT n_balance
	FROM s_tranxion_prev_bal1
	WHERE vMatricNo = ?;");							
	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($Amount_bal);
	$stmt->fetch();

	if (is_null($Amount_bal))
	{
		$Amount_bal = 0.00;
	}
	//echo ', '.$Amount_bal;

	$stmt_b = $mysqli->prepare("SELECT SUM(amount)
	FROM s_tranxion_cr
	WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_open_date')
	AND vMatricNo = ?;");							
	$stmt_b->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt_b->execute();
	$stmt_b->store_result();
	$stmt_b->bind_result($old_cr_bal);
	$stmt_b->fetch();
	
	if (is_null($old_cr_bal))
	{
		$old_cr_bal = 0.00;
	}
	
	//echo $old_cr_bal.'<br>';

	$stmt_b = $mysqli->prepare("SELECT SUM(amount)
	FROM $wrking_year_tab
	WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_open_date')
	AND cCourseId NOT LIKE 'F0%'
	AND trans_count IS NOT NULL
	AND vMatricNo = ?;");							
	$stmt_b->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt_b->execute();
	$stmt_b->store_result();
	$stmt_b->bind_result($old_dr_bal);
	$stmt_b->fetch();
	$stmt_b->close();
	
	if (is_null($old_dr_bal))
	{
		$old_dr_bal = 0.00;
	}
	
	//echo $old_dr_bal;

	$balance = $Amount_bal + ($Amount_bal_1-$Amount_bal_2) + ($old_cr_bal - $old_dr_bal);
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

date_default_timezone_set("Africa/Lagos");?>

<script language="JavaScript" type="text/javascript" src="button_ops.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="prns_css.css" />
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
		font-size:12px;
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


	<div id="container" style="margin-top:3px; height:auto; border-top:1px solid #CCCCCC; border-left:1px solid #CCCCCC; width:820px; text-align:center; padding:10px;">
		<?php do_toup_div_prns('Student Management System');?>
		<div class="innercont" style="margin:auto; margin-top:7px; border-radius:0px; width:100%; display:<?php if ($_REQUEST['side_menu_no']<>17 && $_REQUEST['side_menu_no']<>18){?>block<?php }else{?>none<?php }?>;">
			<div style="width:auto; border-radius:0px; float:left;">
				<label class="labell" style="text-align:left;width:auto; margin-left:-1px; border:none">Session</label>
				<div style="width:125px; height:17px; margin-top:-1px; padding-top:5px;text-align:left; border-radius:0px; margin-left:80px;">
					<b><?php echo $orgsetins['cAcademicDesc'];?></b>
				</div>	
			</div>
			
			<div style="width:auto; margin-left:17px;border-radius:0px; float:right;">
				<label class="labell" style="text-align:left;width:auto; margin-left:-1px; border:none;">e-Wallet balance (NGN)</label>
				<div style="width:85px; height:17px; margin-top:-1px; text-align:right; padding-top:5px; float:right; border-radius:0px;">
					<b><?php 
					echo number_format($balance, 2, '.', ',');?></b>
				</div>	
			</div>	
		</div>
		
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
			display:<?php if (isset($_REQUEST['side_menu_no']) && $_REQUEST['side_menu_no']<>17 && $_REQUEST['side_menu_no']<>18){?>block<?php }else{?>none<?php }?>">
			<div id="pp_box" style="margin-left:0px; float:right; width:125px; border: 0px; height:inherit;">
				<img src="<?php echo get_pp_pix('');?>" style="width:inherit; height:inherit;" alt="" />
			</div><?php
            
            $sql_feet_type = select_fee_srtucture($vMatricNo, $cResidenceCountryId, $cEduCtgId);
			
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
					<div style="width:75%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; border-radius:0px; float:left; margin-left:3px;  white-space: nowrap;
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
						<b><?php $tSemester_locp = '';
						
						if ($tSemester == 1)
						{
							echo 'First';$tSemester_locp = 1;
						}else
						{
							echo 'Second';$tSemester_locp = 2;
						};?></b>
					</div>	
				</div><?php

				$student_data = $vMatricNo.' '.$vCityName.' '.$vLastName.' '.$othernames.' '.$vFacultyDesc.' '.$vdeptDesc.' '.$vMobileNo.' '.$vObtQualTitle.' '.$vProgrammeDesc.' '.$vEMailId.' '.$iStudy_level.' '.$tSemester_locp.' '.$vProgrammeDesc.' '.$vProgrammeDesc;
			}?>
		</div><?php
		if (isset($_REQUEST['side_menu_no']))
		{
			if ($_REQUEST['side_menu_no'] == 'list_transactions')
			{?>
				<div class="innercont" style="margin-top:7px; height:auto; margin-left:4px; border-radius:0px; width:100%;">
					<div class="innercont" style="margin-top:-1px; margin-left:-1px; padding-top:5px; border-radius:0px;width:100%; border: 1px solid #FFFFFF;">
						<b>List of transactions</b>	
					</div>
					<div class="innercont" style="margin-left:0px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px;">
						<div class="ctabletd_1" style="width:5%; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">Sno</div>

						<div class="ctabletd_1" style="width:18%; height:17px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-indent:3px; text-align:left;">Date</div>
						
						<div class="ctabletd_1" style="width:40.2%; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-indent:3px; text-align:left;">Description</div>

						<div class="ctabletd_1" style="width:10%; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">Debit(N)</div>
						
						<div class="ctabletd_1" style="width:10.3%; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">Credit(N)</div>
						
						<div class="ctabletd_1" style="width:12%; height:17px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right; padding-right:3px;">Balance(N)</div>
					</div><?php
					
					// $stmt = $mysqli->prepare("SELECT tdate, cCourseId, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester) vDesc,  cTrntype, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc 
                    // FROM s_tranxion_cr a, fee_items b
                    // WHERE a.fee_item_id = b.fee_item_id
                    // AND b.cdel = 'N'
                    // AND vMatricNo = ?
                    // ORDER BY cTrntype, tdate;");
                    
					// $stmt->bind_param("s", $_REQUEST['vMatricNo']);
					// $stmt->execute();
					// $stmt->store_result();
					
					// $stmt->bind_result($tdate, $cCourseId, $vDesc, $cTrntype, $Amount_a, $vremark, $RetrievalReferenceNumber, $fee_item_desc);?>
					
					<ul id="rtside" class="checklist" style="padding:0px; height:auto; border:0px solid #cccccc;"><?php
					
					$cnt = 0;
					$balance_loc = 0.00;

					$neg_bal = 0;

					$balance_c = 0;
					$balance_d = 0;

					
					$stmt = $mysqli->prepare("select  SUM(`amount`) 
					from s_tranxion_cr
					where vMatricNo = ?");
					$stmt->bind_param("s", $_REQUEST['vMatricNo']);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($balance_loc);
					$stmt->fetch();
					
					if (is_null($balance_loc))
					{
						$balance_loc = 0.00;
					}

					$table = search_starting_pt1($_REQUEST['vMatricNo']);
					foreach ($table as &$value)
					{
						$wrking_tab = 's_tranxion_'.$value;
						
						//echo $wrking_tab.'<br>';
					
						$stmt = $mysqli->prepare("select  SUM(`amount`) 
						from $wrking_tab
						where vMatricNo = ?");
						$stmt->bind_param("s", $_REQUEST['vMatricNo']);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($Amount_b);
						$stmt->fetch();
					
						if (is_null($Amount_b))
						{
							$Amount_b = 0.00;
						}
						
						$balance_loc -= $Amount_b;
					}

					// if ($balance_loc < 0)
					// {
					// 	$neg_bal = 1;
						
					// 	//$semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);

					// 	$stmt_b = $mysqli->prepare("SELECT SUM(amount)
					// 	FROM s_tranxion_cr
					// 	WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_close_date')
					// 	AND vMatricNo = ?;");							
					// 	$stmt_b->bind_param("s", $_REQUEST["uvApplicationNo"]);
					// 	$stmt_b->execute();
					// 	$stmt_b->store_result();
					// 	$stmt_b->bind_result($Amount_bal_1);
					// 	$stmt_b->fetch();

					// 	if (is_null($Amount_bal_1))
					// 	{
					// 		$Amount_bal_1 = 0.00;
					// 	}
						
						$stmt_b = $mysqli->prepare("SELECT n_balance, narata
						FROM s_tranxion_prev_bal1
						WHERE vMatricNo = ?;");							
						$stmt_b->bind_param("s", $_REQUEST["vMatricNo"]);
						$stmt_b->execute();
						$stmt_b->store_result();
						$stmt_b->bind_result($balance_loc, $narata);
						$stmt_b->fetch();
						$stmt_b->close();
			
						if (is_null($balance_loc))
						{
							$balance_loc = 0.00;
							$narata = 'Opening balance';
						}

						//$balance_loc = $Amount_bal + $Amount_bal_1;?>

						<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px;">
							<div class="ctabletd_1" style="width:5.2%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:right;">
								<?php echo ++$cnt; ?>
							</div>
								
							<div class="ctabletd_1" style="width:18.1%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:left;">
								<?php echo $account_open_date ?>
							</div>
							<div class="ctabletd_1" style="width:40.1%; height:inherit; padding-top:5px; padding-left:2px; border:1px solid #A7BAAD; text-align:left;">
								<?php echo $narata;?>
							</div>
							<div class="ctabletd_1" style="width:10%; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;"><?php 
                                    if ($balance_loc < 0.00)
                                    {
                                        echo number_format($balance_loc, 2, '.', ',');
                                        $balance_d = $balance_loc;
                                    }else
                                    {
                                        echo '--';
                                    }?>
							</div>
							<div class="ctabletd_1" style="width:10.2%; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;"><?php 
                                    if ($balance_loc >= 0.00)
                                    {
                                        echo number_format($balance_loc, 2, '.', ',');
                                        $balance_c = $balance_loc;
                                    }else
                                    {
                                        echo '--';
                                    }?>
							</div>
							<div class="ctabletd_1" style="width:12%; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;"><?php 
								echo number_format($balance_loc, 2, '.', ','); ?>
							</div>
						</div><?php

						$stmt = $mysqli->prepare("SELECT tdate, cCourseId, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester) vDesc,  cTrntype, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc 
						FROM s_tranxion_cr a, fee_items b
						WHERE a.fee_item_id = b.fee_item_id
						AND a.tdate NOT LIKE '0000%'
						AND a.tdate > '$account_close_date'
						AND b.cdel = 'N'
						AND vMatricNo = ?
						ORDER BY tdate;");
					// }else
					// {
					// 	$balance_loc = 0.00;
						
					// 	$stmt = $mysqli->prepare("SELECT tdate, cCourseId, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester) vDesc,  cTrntype, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc 
					// 	FROM s_tranxion_cr a, fee_items b
					// 	WHERE a.fee_item_id = b.fee_item_id
					// 	AND b.cdel = 'N'
					// 	AND vMatricNo = ?
					// 	ORDER BY cTrntype, tdate;");
					// }

					$stmt->bind_param("s", $_REQUEST['vMatricNo']);
					$stmt->execute();
					$stmt->store_result();
					
					$stmt->bind_result($tdate, $cCourseId, $vDesc, $cTrntype, $Amount_a, $vremark, $RetrievalReferenceNumber, $fee_item_desc);

					// $balance_c = 0;
					// $balance_d = 0;
					// $cnt = 0;
					// $balance_loc = 0;
					while($stmt->fetch())
					{?>						
						<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px;">
							<div class="ctabletd_1" style="width:5.2%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:right;">
								<?php echo ++$cnt; ?>
							</div>
								
							<div class="ctabletd_1" style="width:18.1%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:left;">
								<?php echo $tdate ?>
							</div>
							<div class="ctabletd_1" style="width:40.1%; height:inherit; padding-top:5px; padding-left:2px; border:1px solid #A7BAAD; text-align:left;">
								<?php echo $vDesc;
                                        if($vremark == 'Registration Deduction'){echo ' '.$fee_item_desc;}else{echo ' '.$vremark;}
                                        if ($RetrievalReferenceNumber <> '0000'){echo ' '.$RetrievalReferenceNumber;}?>
							</div>
							<div class="ctabletd_1" style="width:10%; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;">
							    --
							</div>
							<div class="ctabletd_1" style="width:10.2%; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;"><?php 
								echo number_format($Amount_a, 2, '.', ',');
								$balance_loc = $balance_loc + $Amount_a;
								$balance_c += $Amount_a;?>
							</div>
							<div class="ctabletd_1" style="width:12%; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;"><?php 
								echo number_format($balance_loc, 2, '.', ','); ?>
							</div>
						</div><?php  
					}
					
					/*if ($neg_bal == 0)
                    {
						$table = search_starting_pt($_REQUEST['vMatricNo']);
						foreach ($table as &$value)
						{
							$wrking_tab = 's_tranxion_'.$value;
							$stmt = $mysqli->prepare("SELECT tdate, cCourseId, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester) vDesc,  cTrntype, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc 
							FROM $wrking_tab a, fee_items b
							WHERE a.fee_item_id = b.fee_item_id
							AND b.cdel = 'N'
							AND vMatricNo = ?
							ORDER BY cTrntype, tdate;");
							
							$stmt->bind_param("s", $_REQUEST['vMatricNo']);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($tdate, $cCourseId, $vDesc, $cTrntype, $Amount_a, $vremark, $RetrievalReferenceNumber, $fee_item_desc);
							while($stmt->fetch())
							{?>						
								<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px;">
									<div class="ctabletd_1" style="width:5.2%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:right;">
										<?php echo ++$cnt; ?>
									</div>
										
									<div class="ctabletd_1" style="width:18.1%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:left;">
										<?php echo $tdate ?>
									</div>
									<div class="ctabletd_1" style="width:40.1%; height:inherit; padding-top:5px; padding-left:2px; border:1px solid #A7BAAD; text-align:left;">
										<?php echo $vDesc;
												if($vremark == 'Registration Deduction'){echo ' '.$fee_item_desc;}else{echo $cCourseId. ' '.$vremark;}
												if ($RetrievalReferenceNumber <> '0000'){echo ' '.$RetrievalReferenceNumber;}?>
									</div>
									<div class="ctabletd_1" style="width:10%; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right; color:#e31e24;"><?php 
										echo number_format($Amount_a, 2, '.', ',');$balance_loc = $balance_loc - $Amount_a;
										$balance_d += $Amount_a;?>
									</div>
									<div class="ctabletd_1" style="width:10.2%; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;">
										--
									</div>
									<div class="ctabletd_1" style="width:12%; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;"><?php 
										echo number_format($balance_loc, 2, '.', ','); ?>
									</div>
								</div><?php
							}
						}
					}else
					{*/
						$stmt = $mysqli->prepare("SELECT tdate, cCourseId, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester) vDesc,  cTrntype, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc 
						FROM $wrking_year_tab a, fee_items b
						WHERE a.fee_item_id = b.fee_item_id
						AND tdate NOT LIKE '0000%'
						AND tdate > '$account_close_date'
						AND b.cdel = 'N'
						AND vMatricNo = ?
						ORDER BY cTrntype, tdate;");
						
						$stmt->bind_param("s", $_REQUEST['vMatricNo']);
						$stmt->execute();
						$stmt->store_result();
						
						$stmt->bind_result($tdate, $cCourseId, $vDesc, $cTrntype, $Amount_a, $vremark, $RetrievalReferenceNumber, $fee_item_desc);
						while($stmt->fetch())
						{?>						
							<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px;">
								<div class="ctabletd_1" style="width:5.2%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:right;">
									<?php echo ++$cnt; ?>
								</div>
									
								<div class="ctabletd_1" style="width:18.1%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:left;">
									<?php echo $tdate ?>
								</div>
								<div class="ctabletd_1" style="width:40.1%; height:inherit; padding-top:5px; padding-left:2px; border:1px solid #A7BAAD; text-align:left;">
									<?php echo $vDesc;
											if($vremark == 'Registration Deduction'){echo ' '.$fee_item_desc;}else{echo $cCourseId. ' '.$vremark;}
											if ($RetrievalReferenceNumber <> '0000'){echo ' '.$RetrievalReferenceNumber;}?>
								</div>
								<div class="ctabletd_1" style="width:10%; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right; color:#e31e24;"><?php 
									echo number_format($Amount_a, 2, '.', ',');$balance_loc = $balance_loc - $Amount_a;
									$balance_d += $Amount_a;?>
								</div>
								<div class="ctabletd_1" style="width:10.2%; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;">
									--
								</div>
								<div class="ctabletd_1" style="width:12%; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;"><?php 
									echo number_format($balance_loc, 2, '.', ','); ?>
								</div>
							</div><?php
						}
					//}
					$stmt->close();?>
					</ul>
				
				<div class="innercont" style="margin-top:10px; height:60px; padding-top:2px; padding-left:3px; margin-left:4px; margin-bottom:10px; border-radius:0px; width:98%; border:0px solid #CCCCCC;">
					<div style="margin-top:-1px; width:100%; width:100%; border-radius:0px; float:left;">
						<div style="width:30%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; float:left; border-radius:0px;">Total credit transaction(N)</div>
						<div style="width:20%; height:17px; margin-top:-1px; padding-top:5px; text-align:right; float:left; border-radius:0px; margin-left:5px;">
							<b><?php echo number_format($balance_c, 2, '.', ','); ?></b>
						</div>	
					</div>
					
					<div style="margin-top:-1px; width:inherit; width:100%; border-radius:0px; float:left;">
						<div style="width:30%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; float:left; border-radius:0px;">Total debit transaction(N)</div>
						<div style="width:20%; height:17px; margin-top:-1px; padding-top:5px; text-align:right; float:left; border-radius:0px; margin-left:5px;">
							<b><?php echo number_format($balance_d, 2, '.', ','); ?></b>
						</div>	
					</div>

					<div style="margin-top:-1px; width:inherit; width:100%; border-radius:0px; float:left;">
						<div style="width:30%; height:17px; margin-top:-1px; padding-top:5px; text-align:left; float:left; border-radius:0px;">Balance(N)</div>
						<div style="width:20%; height:17px; margin-top:-1px; padding-top:5px; text-align:right; float:left; border-radius:0px; margin-left:5px;">
							<b><?php echo number_format($balance_loc, 2, '.', ','); ?></b>
						</div>	
					</div>
				</div><?php
			}else if ($_REQUEST['side_menu_no'] == 'see_course_registration_slip' || $_REQUEST['side_menu_no'] == 'see_exam_registration_slip' || $_REQUEST['side_menu_no'] == 'see_all_registered_courses' || $_REQUEST['side_menu_no'] == 'see_all_registered_exams')
			{?>		
				<div class="innercont" style="margin-top:7px; height:auto; margin-left:4px; border-radius:0px; width:100%; font-size: 1.0em;position:relative;">

					<div class="innercont" style="margin-top:-1px; margin-bottom:5px; margin-left:-1px; padding-top:5px; border-radius:0px; width:100%; line-height:1.6; height:auto; border: 0px solid #FFFFFF;">
						<b><?php if ($_REQUEST['side_menu_no'] == 'see_course_registration_slip')
						{
							echo 'Course Registration Slip [Session: '.substr($cAcademicDesc, 0, 4).']';
						}else if ($_REQUEST['side_menu_no'] == 'see_all_registered_courses')
						{
							echo 'All Registered Courses';
						}else if ($_REQUEST['side_menu_no'] == 'see_exam_registration_slip')
						{
							echo 'Examination Registration Slip [Session: '.substr($cAcademicDesc, 0, 4).']';
						}else if ($_REQUEST['side_menu_no'] == 'see_all_registered_exams')
						{
							echo 'All Registered Courses for Examination';
						}?>
					</div>

					<div class="innercont" style="margin-left:-4px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:normal">
						<div class="ctabletd_1" style="width:5%; height:17px; padding-top:5px; padding-right:2px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Sno</div>
						
						<div class="ctabletd_1" style="width:11% ;height:17px; margin-left:-1px; text-indent:2px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Course code</div>

						<div class="ctabletd_1" style="width:44%; height:17px; margin-left:-1px; padding-top:5px; padding-left:3px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Course title</div>

						<div class="ctabletd_1" style="width:8%; height:17px; margin-left:-1px; padding-right:3px; padding-top:5px; padding-right:4px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Cr. unit</div>

						<div class="ctabletd_1" style="width:8%; height:17px; margin-left:-1px; padding-right:2px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:centeer;">Mandate</div>

						<div class="ctabletd_1" style="width:10%; margin-left:-1px; padding-right:3px; height:17px; padding-top:5px; padding-right:3px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:right;">Fee (N)</div>

						<div class="ctabletd_1" style="width:10.2%; margin-left:-1px; height:17px; text-indent:2px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left;">Date</div>				
					</div><?php
					
					if ($_REQUEST['side_menu_no'] == 'see_course_registration_slip')
					{?>
					   <ul id="rtside" class="checklist" style=" padding:0px; height:auto; border:0px solid #cccccc;"><?php
    						$c = 0; 
    						$total_cost = 0; 
    						$tcc = 0;
    						
    						$prev_siLevel = '';
    						$rev_tSemester = '';
                            
                            // $stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, a.cCategory, a.iCreditUnit, a.cAcademicDesc, a.siLevel, a.tSemester, a.tdate, a.ancilary_type
    						// FROM coursereg_arch_20242025 a
    						// WHERE a.siLevel = $iStudy_level
    						// AND a.tSemester = $tSemester
    						// AND a.vMatricNo = ?
    						// ORDER BY a.cCategory, a.cCourseId");

							$stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, a.cCategory, a.iCreditUnit, a.cAcademicDesc, a.siLevel, a.tSemester, a.tdate, a.ancilary_type
    						FROM coursereg_arch_20242025 a
    						WHERE tdate >= '$semester_begin_date'
    						AND a.vMatricNo = ?
    						ORDER BY a.cCategory, a.cCourseId");
    						$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
    						$stmt->execute();
    						$stmt->store_result();
    						$stmt->bind_result($cCourseId, $vCourseDesc, $cCategory, $iCreditUnit, $cAcademicDesc, $siLevel, $tSemester, $tdate, $ancilary_type);
						
    						while($stmt->fetch())
    						{
    							$student_data .= $cCourseId.' ';
    							
    							if ($_REQUEST['side_menu_no'] == 'see_course_registration_slip' || $_REQUEST['side_menu_no'] == 'see_all_registered_courses')
    							{
    								if ($cCourseId == 'PHS326' || $cCourseId == 'PHS430')
                                    {
                                        $Amount = 15000;
                                        $itemid = '7116';
                                    }else if ($cCourseId == 'PHS823')
                                    {
                                        $Amount = 20000;
                                        $itemid = '7180';
                                    }else if ($cCourseId == 'MAC312' || $cCourseId == 'MAC421')
                                    {
                                        $Amount = 6500;
                                        $itemid = '7115';
                                    }else 
                                    {
                                        if ($ancilary_type == 'normal' || $ancilary_type == 'Laboratory')
                                        {
                                            $deg_cond = '';
											if (!is_bool(strpos($cProgrammeId, "DEG")))
											{
												if ($deg_appl_cat == '1')
												{
													$deg_cond = " AND fee_item_desc LIKE '%NOUN Incubatee'";
												}else if ($deg_appl_cat == '2')
												{
													$deg_cond = " AND fee_item_desc LIKE '%Staff/Alumni'";
												}else if ($deg_appl_cat == '3')
												{
													$deg_cond = " AND fee_item_desc LIKE '%Public'";
												}
											}
											
											if ($cEduCtgId == 'PGZ' || $cEduCtgId == 'PRX')
                                            {
                                                $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                                                FROM s_f_s a, fee_items b
                                                WHERE a.fee_item_id = b.fee_item_id
                                                AND (fee_item_desc LIKE '%Course Registration%' $deg_cond)
                                                AND cEduCtgId = '$cEduCtgId'
                                                AND cFacultyId = '$cFacultyId'
                                                $sql_feet_type");
                                            }else
                                            {
                                                $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                                                FROM s_f_s a, fee_items b
                                                WHERE a.fee_item_id = b.fee_item_id
                                                AND (fee_item_desc LIKE '%Course Registration%' $deg_cond)
                                                AND iCreditUnit = $iCreditUnit
                                                AND cEduCtgId = '$cEduCtgId'
                                                AND cFacultyId = '$cFacultyId'
                                                $sql_feet_type");
                                            }
                                        }else 
                                        {
                                            $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                                            FROM s_f_s a, fee_items b
                                            WHERE a.fee_item_id = b.fee_item_id
                                            AND b.fee_item_desc = '$ancilary_type'
                                            AND cEduCtgId = '$cEduCtgId'
                                            AND cFacultyId = '$cFacultyId'
                                            $sql_feet_type");
                                        }

                                        $stmt_amount->execute();
                                        $stmt_amount->store_result();
                                        $stmt_amount->bind_result($Amount, $itemid);
                                        $stmt_amount->fetch();
                                        $stmt_amount->close();
                                    }
                                    
                                    if (is_null($Amount))
									{
										$Amount = 0.0;
									}
									
									
									// if ($ancilary_type <> 'normal')
                                    // {
                                    //     $stmt_amount = $mysqli->prepare("SELECT a.Amount, a.iItemID
                                    //     FROM s_f_s a, educationctg b, sell_item_cat c, fee_items d
                                    //     WHERE a.cEduCtgId = b.cEduCtgId 
                                    //     AND a.citem_cat = c.citem_cat
                                    //     AND a.fee_item_id = d.fee_item_id
                                    //     AND d.fee_item_desc = '$ancilary_type'
                                    //     AND a.cdel = 'N'
                        		    //     AND d.cdel = 'N'
                                    //     AND a.cEduCtgId = '$cEduCtgId'
                                    //     AND cFacultyId = '$cFacultyId'
                                    //     $sql_feet_type
                                    //     order by a.citem_cat, d.fee_item_desc");
                                    // }else
                                    // {
									// 	$stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
									// 	FROM s_f_s a, fee_items b
									// 	WHERE a.fee_item_id = b.fee_item_id
									// 	AND fee_item_desc = 'Course Registration'
									// 	AND iCreditUnit = $iCreditUnit
									// 	AND cEduCtgId = '$cEduCtgId'
									// 	AND cFacultyId = '$cFacultyId'
									// 	AND a.citem_cat = 'A2'");
									// }

									// $stmt_amount->execute();
									// $stmt_amount->store_result();
									// $stmt_amount->bind_result($Amount, $itemid);
									// $stmt_amount->fetch();

									// if (is_null($Amount))
									// {
									// 	$Amount = 0.0;    
									// }
    							}
    
    							// $stmt_amount->execute();
    							// $stmt_amount->store_result();
    							// $stmt_amount->bind_result($Amount, $itemid);
    							// $stmt_amount->fetch();
    							// $stmt_amount->close();
    
    							//$Amount = $Amount ?? 0;
    							$c++;
    							
    							if (isset($siLevel))
    							{
    								if ($prev_siLevel == '' || $prev_siLevel <> $siLevel || $rev_tSemester <> $tSemester)
    								{?>
    									<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:99%; padding:0px; font-weight:bold">
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
    							
    							<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:normal">
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
    
    								<div class="ctabletd_1" style="width:9.7%; margin-left:-1px; height:inherit; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
    									<?php echo substr($tdate,8,2).'/'.substr($tdate,5,2).'/'.substr($tdate,0,4); ?>
    								</div>				
    							</div><?php
    							if (isset($siLevel))
    							{
    								$prev_siLevel =  $siLevel;
    								$rev_tSemester = $tSemester;
    							}
    						}
    						$stmt->close();?>
    					</ul><?php 
					}
					
					
					if ($_REQUEST['side_menu_no'] == 'see_exam_registration_slip')
					{
					    $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                        FROM s_f_s a, fee_items b
                        WHERE a.fee_item_id = b.fee_item_id
                        AND fee_item_desc = 'Examination Registration'
                        AND cEduCtgId = '$cEduCtgId'
                        $sql_feet_type");
                        $stmt_amount->execute();
                        $stmt_amount->store_result();
                        $stmt_amount->bind_result($Amount, $itemid);
                        $stmt_amount->fetch();
                        $stmt_amount->close();
                        
                        $Amount = $Amount ?? 0.0;
                        
                        $arr_trabsactions = array(array(array(array())));

                        $cnt = 0;
                        $table = search_starting_pt_crs($_REQUEST['vMatricNo']);
                        foreach ($table as &$value)
                        {
                            $wrking_tab = 'coursereg_arch_'.$value;
                            $stmt = $mysqli->prepare("SELECT cCourseId, vCourseDesc, cCategory, iCreditUnit
                            FROM $wrking_tab
                            WHERE vMatricNo = ?
                            ORDER BY cCourseId"); 
                            
                            $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($cCourseId, $vCourseDesc, $cCategory, $iCreditUnit);
                            
                            while($stmt->fetch())
                            {
                                if (isset($cCourseId))
                                {
                                    $cnt++;
                                    $arr_trabsactions[$cnt]['cCourseId'] = $cCourseId;
                                    $arr_trabsactions[$cnt]['vCourseDesc'] = $vCourseDesc;
                                    $arr_trabsactions[$cnt]['cCategory'] = $cCategory;
                                    $arr_trabsactions[$cnt]['iCreditUnit'] = $iCreditUnit;
                                    
                                    /*echo $arr_trabsactions[$cnt]['cCourseId'].', '.
                                    $arr_trabsactions[$cnt]['vCourseDesc'].', '.
                                    $arr_trabsactions[$cnt]['cCategory'].', '.
                                    $arr_trabsactions[$cnt]['iCreditUnit'].'<p>';*/
                                }
                            }
                        }
                        
                        $stmt->close();?>
                            
					   <ul id="rtside" class="checklist" style=" padding:0px; height:auto; border:0px solid #cccccc;"><?php
    						$c = 0; 
    						$total_cost = 0; 
    						$tcc = 0;
    						
    						$prev_siLevel = '';
    						$rev_tSemester = '';

							$stmt = $mysqli->prepare("SELECT a.cCourseId, a.cAcademicDesc, a.tdate
    						FROM examreg_20242025 a
    						WHERE tdate >= '$semester_begin_date'
    						AND a.vMatricNo = ?
    						ORDER BY a.cCourseId");
    				
    						$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
    						$stmt->execute();
    						$stmt->store_result();
    						$stmt->bind_result($cCourseId, $cAcademicDesc, $tdate);
    
    						while($stmt->fetch())
    						{
    						    $vCourseDesc = '';
                                $iCreditUnit = '';
                                $cCategory = '';
                                    
    							for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                {
                                    if ($arr_trabsactions[$b]['cCourseId'] == $cCourseId)
                                    {
                                        $vCourseDesc = $arr_trabsactions[$b]['vCourseDesc'];
                                        $iCreditUnit = $arr_trabsactions[$b]['iCreditUnit'];
                                        $cCategory = $arr_trabsactions[$b]['cCategory'];
                                        break;
                                    }
                                }

								if ($vCourseDesc == '')
								{
									continue;
								}
								
								$stmt_anx = $mysqli->prepare("SELECT ancilary_type
								FROM courses_new
								WHERE cCourseId = '$cCourseId'");
								$stmt_anx->execute();
								$stmt_anx->store_result();
								$stmt_anx->bind_result($ancilary_type);
								$stmt_anx->fetch();

								if ($cCourseId == 'EDU216' || $cCourseId == 'MAC312' || $cCourseId == 'MAC421' || $cCourseId == 'PHS823' || $cCourseId == 'PHS326' || $cCourseId == 'PHS430' || $ancilary_type == 'Project' || $ancilary_type == 'Seminar' || $ancilary_type == 'SIWES' || $ancilary_type == 'Teaching Practice' || $ancilary_type == 'Practicum' || $ancilary_type == 'Clinical Practicum' || $ancilary_type == 'Field Exercise' || $ancilary_type == 'Field Trip')
								{
									$Amount = 0.0;
									$itemid = '';
								}else if ($ancilary_type == 'Laboratory')
								{
									$stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
									FROM s_f_s a, fee_items b
									WHERE a.fee_item_id = b.fee_item_id
									AND fee_item_desc = 'Laboratory'
									AND cEduCtgId = '$cEduCtgId'
									AND cFacultyId = '$cFacultyId'
									$sql_feet_type");
									$stmt_amount->execute();
									$stmt_amount->store_result();
									$stmt_amount->bind_result($Amount, $itemid);
									$stmt_amount->fetch();
									$stmt_amount->close();
									
									$Amount = 6500;
								}else
								{
									$stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
									FROM s_f_s a, fee_items b
									WHERE a.fee_item_id = b.fee_item_id
									AND fee_item_desc = 'Examination Registration'
									AND cEduCtgId = '$cEduCtgId'
									$sql_feet_type");
									$stmt_amount->execute();
									$stmt_amount->store_result();
									$stmt_amount->bind_result($Amount, $itemid);
									$stmt_amount->fetch();
									$stmt_amount->close();
												
									if (is_null($Amount))
									{
										$Amount = 0.0;    
									}
								}
								
    							$c++;

    							
    							if (isset($siLevel))
    							{
    								if ($prev_siLevel == '' || $prev_siLevel <> $siLevel || $rev_tSemester <> $tSemester)
    								{?>
    									<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:99%; padding:0px; font-weight:bold">
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
    							
    							<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:normal">
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
    									<?php //if ($ancilary_type == 'normal')
										//{
											echo number_format($Amount, 0, '.', ',');$total_cost = $total_cost + $Amount;
										/*}else
										{
											echo 'NA';
										}*/ ?>
    								</div>
    
    								<div class="ctabletd_1" style="width:10.1%; margin-left:-1px; height:inherit; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
    									<?php echo substr($tdate,8,2).'/'.substr($tdate,5,2).'/'.substr($tdate,0,4); ?>
    								</div>				
    							</div><?php
    						}
    						$stmt->close();
							
							
							if (($tcc <= 24 || (($cProgrammeId == 'LAW301' || $cProgrammeId == 'LAW401') && $iCreditUnit <= 29)))
							{?>
								<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:bold">
									<div class="ctabletd_1" style="width:5.1%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:right;">
										.
									</div>
									
									<div class="ctabletd_1" style="width:11.1% ;height:inherit; margin-left:-1px; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
										.
									</div>

									<div class="ctabletd_1" style="width:43.9%; height:inherit; margin-left:-1px; padding-top:5px; padding-left:3px; border:1px solid #A7BAAD; text-align:left;">
										Total
									</div>

									<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:3px; padding-top:5px; padding-right:4px; border:1px solid #A7BAAD; text-align:right;">
										<?php echo $tcc; ?>
									</div>

									<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:2px; padding-top:5px;border:1px solid #A7BAAD; text-align:centeer;">
										.
									</div>

									<div class="ctabletd_1" style="width:10%; margin-left:-1px; padding-right:3px; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;">
										<?php echo number_format($total_cost, 0, '.', ','); ?>
									</div>

									<div class="ctabletd_1" style="width:10.1%; margin-left:-1px; height:inherit; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
										.
									</div>				
								</div><?php
							}?>
    					</ul><?php 


						if ($tcc <= 24 || (($cProgrammeId == 'LAW301' || $cProgrammeId == 'LAW401') && $tcc <= 29))
						{?>
							<div class="innercont" style="margin-left:-1px; text-align:left; border-radius:0px; margin-top:25px; width:99%; padding:1px; height:auto; font-weight:normal;">
								<div style="float:left; width:40%; text-align:center; border-bottom:1px dashed #ccc; line-height:1.5;">.</div>
								<div style="float:left; width:20%; text-align:center; line-height:2;">For office use only</div>
								<div style="float:left; width:40%; text-align:center; border-bottom:1px dashed #ccc; line-height:1.5;">.</div>
							</div>
							
							<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-top:30px; width:99.5%; padding:1px; height:25px; font-weight:normal">
								<div style="width:45%; height:30px; text-align:left; border:0px; border-bottom:1px dashed #595959; float:left;">Name</div>
								<div style="width:10%; height:30px; text-align:center; border:0px; float:left;"></div>

								<div style="width:45%; height:30px; text-align:left; border:0px; border-bottom:1px dashed #595959; float:left;">Name</div>
							</div>
							
							<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-top:30px; width:99.5%; padding:1px; height:25px; font-weight:normal">
								<div style="width:45%; height:30px; text-align:left; border:0px; border-bottom:1px dashed #595959; float:left;">Designation</div>

								<div style="width:10%; height:30px; text-align:center; border:0px; float:left;"></div>

								<div style="width:45%; height:30px; text-align:left; border:0px; border-bottom:1px dashed #595959; float:left;">Designation</div>
							</div>
							
							<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-top:30px; width:99.5%; padding:1px; height:25px; font-weight:normal">
								<div style="width:45%; height:30px; text-align:left; border:0px; border-bottom:1px dashed #595959; float:left;">Sgnature and date</div>

								<div style="width:10%; height:30px; text-align:center; border:0px; float:left;"></div>

								<div style="width:45%; height:30px; text-align:left; border:0px; border-bottom:1px dashed #595959; float:left;">Sgnature and date</div>
							</div>

							<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-top:3px; width:99.5%; padding:1px; height:25px; font-weight:normal">
								<div style="width:45%; height:30px; text-align:center; border:0px; float:left;">
									Bursary
								</div>

								<div style="width:10%; height:30px; text-align:center; border:0px; float:left;"></div>

								<div style="width:45%; height:30px; text-align:center; border:0px; float:left;">
									Registry
								</div>
							</div>						
							
							<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-top:50px; width:837px; padding:1px; height:70px; font-weight:normal">
								<div class="ctabletd_1" style="width:100%; height:auto; padding-top:5px; text-align:center; border:0px; margin-right:auto; float:left;">
									------------------------------------------------------------
								</div>
								<div class="ctabletd_1" style="width:100%; height:auto; text-align:center; margin-right:auto; border:0px; float:left;">
									Director<br>Name, signature and date
								</div>
							</div><?php

							//include '../phpqrcode/qrlib.php';
							//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);?>

							<!--<div class="innercont" 
							style="position:absolute;
							left:0;
							bottom:0; 
							margin:0px; 
							padding:0px; 
							height:130px; 
							width:130px;">
							<img src="<?php //echo bar_codde($student_data, $_REQUEST["vMatricNo"]);?>" style="height:100%; width:100%" /></div>--><?php
						}else //if (!($iCreditUnit <= 24 || (($cProgrammeId == 'LAW301' || $cProgrammeId == 'LAW401') && $iCreditUnit <= 29)))
						{
							echo 'Drop excess credit load now';
						}
					}




					
					// 	if ($_REQUEST['side_menu_no'] == 'see_all_registered_courses')
					// 	{
					// 		$stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, a.cCategory, a.iCreditUnit, a.cAcademicDesc, a.siLevel, a.tSemester, a.tdate
					// 		FROM coursereg_arch a
					// 		WHERE a.vMatricNo = ?
					// 		ORDER BY  a.siLevel, a.tSemester, a.cCategory, a.cCourseId");
					// 		$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
					// 		$stmt->execute();
					// 		$stmt->store_result();
					// 		$stmt->bind_result($cCourseId, $vCourseDesc, $cCategory, $iCreditUnit, $cAcademicDesc, $siLevel, $tSemester, $tdate);
					// 	}else if ($_REQUEST['side_menu_no'] == 'see_all_registered_exams')
					// 	{						
					// 		$stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, d.siLevel, d.tSemester, d.tdate, a.iCreditUnit, d.cAcademicDesc, a.cCategory
					// 		FROM coursereg_arch a, s_m_t c, examreg d
					// 		WHERE  a.cCourseId = d.cCourseId
					// 		AND c.vMatricNo = d.vMatricNo
					// 		AND c.vMatricNo = ? 
					// 		ORDER BY d.siLevel, d.tSemester, a.cCategory, d.cCourseId");
					
					// 		$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
					// 		$stmt->execute();
					// 		$stmt->store_result();
					// 		$stmt->bind_result($cCourseId, $vCourseDesc, $siLevel, $tSemester, $tdate, $iCreditUnit, $cAcademicDesc, $cCategory);
					// 	}
					
					if ($_REQUEST['side_menu_no'] == 'see_all_registered_courses')
					{?>
    					<ul id="rtside" class="checklist" style=" padding:0px; height:auto; border:0px solid #cccccc;"><?php
    						$c = 0; 
    						$total_cost = 0; 
    						$tcc = 0;
    						
    						
    						$total_semester_cost = 0; 
    						$tcc_semester = 0;
    						
    						$prev_siLevel = '';
    						$rev_tSemester = '';
    						
    						$table = search_starting_pt_crs($_REQUEST['vMatricNo']);
    						
    						foreach ($table as &$value)
                            {
                                $wrking_tab_coursereg_arch = 'coursereg_arch_'.$value;
                                $wrking_tab_examreg = 'examreg_'.$value;
                                
                                if ($_REQUEST['side_menu_no'] == 'see_all_registered_courses')
            					{
            						$stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, a.cCategory, a.iCreditUnit, a.cAcademicDesc, a.siLevel, a.tSemester, a.tdate
            						FROM $wrking_tab_coursereg_arch a
            						WHERE a.vMatricNo = ?
            						ORDER BY  a.siLevel, a.tSemester, a.cCategory, a.cCourseId");
            						$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
            						$stmt->execute();
            						$stmt->store_result();
            						$stmt->bind_result($cCourseId, $vCourseDesc, $cCategory, $iCreditUnit, $cAcademicDesc, $siLevel, $tSemester, $tdate);
            					}else if ($_REQUEST['side_menu_no'] == 'see_all_registered_exams')
            					{						
            						$stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, d.siLevel, d.tSemester, d.tdate, a.iCreditUnit, d.cAcademicDesc, a.cCategory
            						FROM $wrking_tab_coursereg_arch a, s_m_t c, $wrking_tab_examreg d
            						WHERE  a.cCourseId = d.cCourseId
            						AND c.vMatricNo = d.vMatricNo
            						AND c.vMatricNo = ? 
            						ORDER BY d.siLevel, d.tSemester, a.cCategory, d.cCourseId");
            				
            						$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
            						$stmt->execute();
            						$stmt->store_result();
            						$stmt->bind_result($cCourseId, $vCourseDesc, $siLevel, $tSemester, $tdate, $iCreditUnit, $cAcademicDesc, $cCategory);
            					}
    
        						while($stmt->fetch())
        						{
        							$student_data .= $cCourseId.' ';
        							
        							if ($_REQUEST['side_menu_no'] == 'see_course_registration_slip' || $_REQUEST['side_menu_no'] == 'see_all_registered_courses')
        							{
        								$stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
        								FROM s_f_s a, fee_items b
        								WHERE a.fee_item_id = b.fee_item_id
        								AND fee_item_desc = 'Course Registration'
        								AND iCreditUnit = $iCreditUnit
        								AND cEduCtgId = '$cEduCtgId'
        								AND cFacultyId = '$cFacultyId'
        								AND a.citem_cat = 'A2'");
        							}else if ($_REQUEST['side_menu_no'] == 'see_exam_registration_slip' || $_REQUEST['side_menu_no'] == 'see_all_registered_exams')
        							{
        								$stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
        								FROM s_f_s a, fee_items b
        								WHERE a.fee_item_id = b.fee_item_id
        								AND fee_item_desc = 'Examination Registration'
        								AND cEduCtgId = '$cEduCtgId'
        								AND cFacultyId = '$cFacultyId'
        								AND a.citem_cat = 'A2'");
        							}
        
        							$stmt_amount->execute();
        							$stmt_amount->store_result();
        							$stmt_amount->bind_result($Amount, $itemid);
        							$stmt_amount->fetch();
        							$stmt_amount->close();
        
        							$Amount = $Amount ?? 0;
        							$c++;
        							
        							if (isset($siLevel))
        							{
        								if ($prev_siLevel == '' || $prev_siLevel <> $siLevel || $rev_tSemester <> $tSemester)
        								{
        								    if ($prev_siLevel <> '')
            								{?>
            									<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:normal">
													<div class="ctabletd_1" style="width:5.1%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:right;"></div>
													
													<div class="ctabletd_1" style="width:11.1% ;height:inherit; margin-left:-1px; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;"></div>
					
													<div class="ctabletd_1" style="width:43.9%; height:inherit; margin-left:-1px; padding-top:5px; padding-left:3px; border:1px solid #A7BAAD; text-align:left;"></div>
					
													<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:3px; padding-top:5px; padding-right:4px; border:1px solid #A7BAAD; text-align:right;">
														<?php echo $tcc_semester;?>
													</div>
					
													<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:2px; padding-top:5px;border:1px solid #A7BAAD; text-align:centeer;"></div>
					
													<div class="ctabletd_1" style="width:10%; margin-left:-1px; padding-right:3px; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;">
														<?php echo number_format($total_semester_cost, 0, '.', ',');?>
													</div>
					
													<div class="ctabletd_1" style="width:10.1%; margin-left:-1px; height:inherit; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;"></div><?php
												}?>
												
												
												<div class="innercont" style="margin-left:0px; border-radius:0px; margin-bottom:3px; width:99.4%; padding:0px; font-weight:bold">
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
												</div>
											</div><?php
        									
        									$total_semester_cost = 0; 
    						                $tcc_semester = 0;
        								}
        							}?>
        							
        							<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:normal">
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
        									<?php echo $iCreditUnit; 
        									$tcc += $iCreditUnit; 
											$tcc_semester += $iCreditUnit;?>
        								</div>
        
        								<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:2px; padding-top:5px;border:1px solid #A7BAAD; text-align:centeer;">
        									<?php echo $cCategory; ?>
        								</div>
        
        								<div class="ctabletd_1" style="width:10%; margin-left:-1px; padding-right:3px; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;">
        									<?php echo number_format($Amount, 0, '.', ',');$total_cost += $Amount;
        									$total_semester_cost += $Amount;?>
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
                            }
    						$stmt->close();?>
    					</ul><?php
					}
					
					
					if ($_REQUEST['side_menu_no'] == 'see_all_registered_exams')
					{?>
    					<ul id="rtside" class="checklist" style=" padding:0px; height:auto; border:0px solid #cccccc;"><?php
    						$c = 0;
				
                            $total_cost = 0;
                            $total_cr = 0;
                            $total_cost_all = 0;
                            $tcr1 = 0;
                            
                            $prev_level = '';
                            $prev_semester = '';
                            
                            $prev_level = '';
                            $prev_semester = '';
                            
                            $table = search_starting_pt_crs($_REQUEST['vMatricNo']);
                            
                            foreach ($table as &$value)
                            {
                                $wrking_exam_tab = 'examreg_'.$value;
                                
                                $stmt = $mysqli->prepare("SELECT cCourseId, silevel, tSemester
                				FROM $wrking_exam_tab 
                				WHERE vMatricNo = ? 
                				ORDER BY siLevel, tSemester, cCourseId");
                				
                				$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                				$stmt->execute();
                				$stmt->store_result();
                				$stmt->bind_result($cCourseId, $level, $tSemester);
                				
                                
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
                        				
                        				if ($stmt_ex->num_rows > 0)
                        				{
                        				    $stmt_ex->fetch();
                                    
                        				    $c++;
                        				    
                                            $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                                            FROM s_f_s a, fee_items b
                                            WHERE a.fee_item_id = b.fee_item_id
                                            AND fee_item_desc = 'Examination Registration'
                                            AND cEduCtgId = '$cEduCtgId'
                                            AND a.citem_cat = 'A2'");
            
                                            $stmt_amount->execute();
                                            $stmt_amount->store_result();
                                            $stmt_amount->bind_result($Amount, $itemid);
                                            $stmt_amount->fetch();
                                            $stmt_amount->close();
            
                                            $Amount = $Amount ?? 0;
                                            
                                            
                                            if (($prev_level == '' || $prev_level <> $level) || ($prev_semester <> '' && $prev_semester <> $tSemester))
                                            {
                                                if ($prev_level <> '' && $prev_level <> '')
                                                {?>
                                                   <div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:bold">
                        								<div class="ctabletd_1" style="width:5.1%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:right;">
                        									.
                        								</div>
                        								
                        								<div class="ctabletd_1" style="width:11.1% ;height:inherit; margin-left:-1px; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
                        									.
                        								</div>
                        
                        								<div class="ctabletd_1" style="width:43.9%; height:inherit; margin-left:-1px; padding-top:5px; padding-left:3px; border:1px solid #A7BAAD; text-align:right;">
                        									Total
                        								</div>
                        
                        								<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:3px; padding-top:5px; padding-right:4px; border:1px solid #A7BAAD; text-align:right;">
                        									<?php echo $tcr1;?>
                        								</div>
                        
                        								<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:2px; padding-top:5px;border:1px solid #A7BAAD; text-align:centeer;">
                        									.
                        								</div>
                        
                        								<div class="ctabletd_1" style="width:10%; margin-left:-1px; padding-right:3px; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;">
                        									<?php echo number_format($total_cost, 0, '.', ',');?>
                        								</div>
                        
                        								<div class="ctabletd_1" style="width:10.1%; margin-left:-1px; height:inherit; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
                        									.
                        								</div>				
                        							</div><?php
                        							
                									$total_cr += $tcr1;
                									$total_cost_all += $total_cost;
                									
                        							$tcr1 = 0;
                        							$total_cost = 0;
                                                }?>
                                                
                                                <div class="innercont" style="margin-left:0px; border-radius:0px; margin-bottom:3px; width:99.4%; padding:0px; font-weight:bold">
                										<div class="ctabletd_1" style="width:100%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:left;">
            											<?php echo $level.'Level, ';
            											if ($tSemester == 1)
            											{
            												echo 'First semester';
            											}else
            											{
            												echo 'Second semester';
            											}?>
            										</div>
            									</div><?php
                                            }?>
                                            
                                            <div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:normal">
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
                									<?php echo $iCreditUnit; 
                									$tcr1 += $iCreditUnit;?>
                								</div>
                
                								<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:2px; padding-top:5px;border:1px solid #A7BAAD; text-align:centeer;">
                									<?php echo $cCategory; ?>
                								</div>
                
                								<div class="ctabletd_1" style="width:10%; margin-left:-1px; padding-right:3px; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;">
                									<?php echo number_format($Amount, 0, '.', ',');
                									$total_cost += $Amount;?>
                								</div>
                
                								<div class="ctabletd_1" style="width:10.1%; margin-left:-1px; height:inherit; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
                									<?php echo substr($tdate,8,2).'/'.substr($tdate,5,2).'/'.substr($tdate,0,4); ?>
                								</div>				
                							</div><?php
                        				    
                        				}
                                    }
                            
                                    $prev_level = $level;
                                    $prev_semester = $tSemester;
                                }
                            }?>
                            
                            <div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px; font-weight:bold">
								<div class="ctabletd_1" style="width:5.1%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:right;">
									.
								</div>
								
								<div class="ctabletd_1" style="width:11.1% ;height:inherit; margin-left:-1px; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
									.
								</div>

								<div class="ctabletd_1" style="width:43.9%; height:inherit; margin-left:-1px; padding-top:5px; padding-left:3px; border:1px solid #A7BAAD; text-align:right;">
									Total
								</div>

								<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:3px; padding-top:5px; padding-right:4px; border:1px solid #A7BAAD; text-align:right;">
									<?php echo $tcr1;
									$total_cr += $tcr1;?>
								</div>

								<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:2px; padding-top:5px;border:1px solid #A7BAAD; text-align:left;">
									.
								</div>

								<div class="ctabletd_1" style="width:10%; margin-left:-1px; padding-right:3px; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;">
									<?php echo number_format($total_cost, 0, '.', ',');
									$total_cost_all += $total_cost;?>
								</div>

								<div class="ctabletd_1" style="width:10.1%; margin-left:-1px; height:inherit; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
									.
								</div>				
							</div>
							
							<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-bottom:5px; margin-top:10px; width:100%; padding:0px; font-weight:bold">
								<div class="ctabletd_1" style="width:5.1%; height:inherit; padding-top:5px; padding-right:2px; border:1px solid #A7BAAD; text-align:right;">
									.
								</div>
								
								<div class="ctabletd_1" style="width:11.1% ;height:inherit; margin-left:-1px; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
									.
								</div>

								<div class="ctabletd_1" style="width:43.9%; height:inherit; margin-left:-1px; padding-top:5px; padding-left:3px; border:1px solid #A7BAAD; text-align:right;">
									Grand total
								</div>

								<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:3px; padding-top:5px; padding-right:4px; border:1px solid #A7BAAD; text-align:right;">
									<?php echo $total_cr;?>
								</div>

								<div class="ctabletd_1" style="width:8%; height:inherit; margin-left:-1px; padding-right:2px; padding-top:5px;border:1px solid #A7BAAD; text-align:centeer;">
									.
								</div>

								<div class="ctabletd_1" style="width:10%; margin-left:-1px; padding-right:3px; height:inherit; padding-top:5px; padding-right:3px; border:1px solid #A7BAAD; text-align:right;">
									<?php echo number_format($total_cost_all, 0, '.', ',');?>
								</div>

								<div class="ctabletd_1" style="width:10.1%; margin-left:-1px; height:inherit; text-indent:2px; padding-top:5px; border:1px solid #A7BAAD; text-align:left;">
									.
								</div>				
							</div>
    					</ul><?php
					}?>
					
						
					<div class="innercont" style="margin-left:-1px; border-radius:0px; margin-top:5px; width:837px; padding:1px; height:auto; font-weight:normal">
						This document is only valid if its content exactly matches what is on the University database
					</div>
				</div><?php
			}else if ($_REQUEST['side_menu_no'] == 'register_courses')
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
			}*/else if ($_REQUEST['side_menu_no'] == 'personal_timetable')
			{?>
				<div class="innercont" style="margin-top:7px; margin-bottom:20px; height:auto; margin-left:4px; border-radius:0px; width:100%; color:#000">
					<div class="innercont" style="margin-top:-1px; margin-left:-1px; padding-top:5px; border-radius:0px;width:100%; border: 0px solid #FFFFFF;">
						<b><?php 
						echo $orgsetins['cAcademicDesc'];
						if ($tSemester == 1)
						{
							echo ' First semester';
						}else
						{
							echo ' Second semester';
						}

						$stmt = $mysqli->prepare("SELECT final FROM tt");
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($final);
						$stmt->fetch();
						$stmt->close();
				
						$final = $final ?? '';
						
						if ($final == '1')
						{
							echo ' Final';
						}else
						{
							echo ' Draft';
							
						}?> Personal Examination Timetable</b>	
					</div>
					<div class="innercont" style="margin-left:0px; border-radius:0px; margin-bottom:3px; width:100%; padding:0px;">
						<div class="ctabletd_1" style="width:10.9%; height:27px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; padding-left:0.4%;">Day/Date</div>

						<div class="ctabletd_1" style="width:28.3%; height:27px; padding-top:5px; background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; padding-left:0.4%;">8:30am</div>
						
						<div class="ctabletd_1" style="width:28.5%; height:27px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; padding-left:0.4%;">11:00am</div>

						<div class="ctabletd_1" style="width:28.3%; height:27px; padding-top:5px;background-color:#E3EBE2; border:1px solid #A7BAAD; text-align:left; padding-right:3px;">2:00pm</div>
					</div><?php
					
					$arr_trabsactions = array(array(array()));
                    $table = search_starting_pt_crs($_REQUEST['vMatricNo']);
                    
                    $cnt = 0;
                    foreach ($table as &$value)
                    {
                        $wrking_tab = 'coursereg_arch_'.$value;
                    
                        $stmt_s = $mysqli->prepare("SELECT cCourseId, vCourseDesc, cCategory, iCreditUnit
                        FROM $wrking_tab 
                        WHERE vMatricNo = ?
                        ORDER BY cCourseId");                                
                        $stmt_s->bind_param("s", $_REQUEST["vMatricNo"]);
                        $stmt_s->execute();
                        $stmt_s->store_result();
                        $stmt_s->bind_result($cCourseId, $vCourseDesc, $cCategory, $iCreditUnit);
                        while($stmt_s->fetch())
                        {
                            $cnt++;
                            
                            $arr_trabsactions[$cnt]['cCourseId'] = $cCourseId;
                            $arr_trabsactions[$cnt]['vCourseDesc'] = $vCourseDesc;
                            $arr_trabsactions[$cnt]['cCategory'] = $cCategory;
                            $arr_trabsactions[$cnt]['iCreditUnit'] = $iCreditUnit;
                            
                            /*echo $arr_trabsactions[$cnt]['cCourseId'].', '.
                            $arr_trabsactions[$cnt]['vCourseDesc'].', '.
                            $arr_trabsactions[$cnt]['cCategory'].', '.
                            $arr_trabsactions[$cnt]['iCreditUnit'].'<p>';*/
                        }
                    }

					$stmt_t = $mysqli->prepare("SELECT MAX(iday) FROM tt");
					$stmt_t->execute();
					$stmt_t->store_result();
					$stmt_t->bind_result($days_of_exam);
					$stmt_t->fetch();
					$stmt_t->close();

					$days_of_exam = $days_of_exam ?? 0;

					$cnt = 0;
					for ($iday = 1; $iday <= $days_of_exam; $iday++)
					{
						$stmt_t = $mysqli->prepare("SELECT exam_date, b.cCourseId FROM tt b, examreg_20242025 a 
                        WHERE iday = $iday 
                        AND a.cCourseId = b.cCourseId
            			AND a.tdate >= '$semester_begin_date'
                        AND a.vMatricNo = ? ");
                        $stmt_t->bind_param("s", $_REQUEST["vMatricNo"]);
                        $stmt_t->execute();
                        $stmt_t->store_result();
						if ($stmt_t->num_rows <> 0)
						{
							$cnt++;
							$stmt_t->bind_result($exam_date, $cCourseId_0);
							while($stmt_t->fetch())
							{?>
								<li <?php /*if ($cnt%2 == 0){echo ' class="alt"';}*/?> style="height:70px; width:99.5%; list-style:none;">
									<div class="ctabletd_1" style="width:11%; height:65px; border:1px solid #A7BAAD; text-align:left; padding-left:0.4%;">
										<?php echo $iday.'/'.$exam_date;?>
									</div>

									<div class="ctabletd_1" style="width:28.4%; height:65px; border:1px solid #A7BAAD; text-align:left; padding-left:0.4%;"><?php
                                        $day_work = '';
                                        
                                        $stmt_s = $mysqli->prepare("SELECT cCourseId
                                        FROM examreg_20242025
                                        WHERE tdate >= '$semester_begin_date'
                            			AND cCourseId = '$cCourseId_0'
                                        AND vMatricNo = ?
                                        AND cCourseId IN (SELECT cCourseId FROM tt WHERE iday = $iday AND cSession = 1)
                                        ORDER BY cCourseId");                                
                                        $stmt_s->bind_param("s", $_REQUEST["vMatricNo"]);
                                        $stmt_s->execute();
                                        $stmt_s->store_result();
                                        $stmt_s->bind_result($cCourseId);
                                        while($stmt_s->fetch())
                                        {
                                            $vCourseDesc = '';
                                            for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                            {
                                                if ($arr_trabsactions[$b]['cCourseId'] == $cCourseId)
                                                {
                                                    $vCourseDesc = $arr_trabsactions[$b]['vCourseDesc'];
                                                    $cCategory = $arr_trabsactions[$b]['cCategory'];
                                                    $iCreditUnit = $arr_trabsactions[$b]['iCreditUnit'];
                                                    break;
                                                }
                                            }
                                            
                                            if ($vCourseDesc <> '')
                                            {
                                                $day_work .= $cCourseId." ".$vCourseDesc." ".$cCategory." ".$iCreditUnit."\n";
                                            }
                                        }
                                        $stmt_s->close();
                                        echo $day_work;?>
									</div>
									
									<div class="ctabletd_1" style="width:28.6%; height:65px; border:1px solid #A7BAAD; text-align:left; padding-left:0.4%;"><?php 
										$day_work = '';
                                        
                                        $stmt_s = $mysqli->prepare("SELECT cCourseId
                                        FROM examreg_20242025
                                        WHERE tdate >= '$semester_begin_date'
                            			AND cCourseId = '$cCourseId_0'
                                        AND vMatricNo = ?
                                        AND cCourseId IN (SELECT cCourseId FROM tt WHERE iday = $iday AND cSession = 2)
                                        ORDER BY cCourseId");                                
                                        $stmt_s->bind_param("s", $_REQUEST["vMatricNo"]);
                                        $stmt_s->execute();
                                        $stmt_s->store_result();
                                        $stmt_s->bind_result($cCourseId);
                                        while($stmt_s->fetch())
                                        {
                                            $vCourseDesc = '';
                                            for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                            {
                                                if ($arr_trabsactions[$b]['cCourseId'] == $cCourseId)
                                                {
                                                    $vCourseDesc = $arr_trabsactions[$b]['vCourseDesc'];
                                                    $cCategory = $arr_trabsactions[$b]['cCategory'];
                                                    $iCreditUnit = $arr_trabsactions[$b]['iCreditUnit'];
                                                    break;
                                                }
                                            }
                                            
                                            if ($vCourseDesc <> '')
                                            {
                                                $day_work .= $cCourseId." ".$vCourseDesc." ".$cCategory." ".$iCreditUnit."\n";
                                            }
                                        }
                                        $stmt_s->close();
                                        echo $day_work;?>
									</div>

									<div class="ctabletd_1" style="width:28.4%; height:65px; border:1px solid #A7BAAD; text-align:left; padding-left:0.4%;"><?php 
										$day_work = '';
                                        
                                        $stmt_s = $mysqli->prepare("SELECT cCourseId
                                        FROM examreg_20242025
                                        WHERE tdate >= '$semester_begin_date'
                            			AND cCourseId = '$cCourseId_0'
                                        AND vMatricNo = ?
                                        AND cCourseId IN (SELECT cCourseId FROM tt WHERE iday = $iday AND cSession = 3)
                                        ORDER BY cCourseId");                                
                                        $stmt_s->bind_param("s", $_REQUEST["vMatricNo"]);
                                        $stmt_s->execute();
                                        $stmt_s->store_result();
                                        $stmt_s->bind_result($cCourseId);
                                        while($stmt_s->fetch())
                                        {
                                            $vCourseDesc = '';
                                            for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                            {
                                                if ($arr_trabsactions[$b]['cCourseId'] == $cCourseId)
                                                {
                                                    $vCourseDesc = $arr_trabsactions[$b]['vCourseDesc'];
                                                    $cCategory = $arr_trabsactions[$b]['cCategory'];
                                                    $iCreditUnit = $arr_trabsactions[$b]['iCreditUnit'];
                                                    break;
                                                }
                                            }
                                            
                                            if ($vCourseDesc <> '')
                                            {
                                                $day_work .= $cCourseId." ".$vCourseDesc." ".$cCategory." ".$iCreditUnit."\n";
                                            }
                                        }
                                        $stmt_s->close();
                                        echo $day_work;?>
									</div>
								</li><?php
							}
							$stmt_t->close();
						}
					}?>
				</div><?php
			}
		}?>
	</div>
</body>
</html>