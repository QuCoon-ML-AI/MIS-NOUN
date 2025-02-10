<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');
include('const_def.php');

$staff_study_center = '';
if (isset($_REQUEST['staff_study_center']))
{
	$staff_study_center = $_REQUEST['staff_study_center'];
}

$orgsetins = settns();

$who_is_this = '';
$str = '';

if (isset($_REQUEST['ilin']))
{
	$a_uvApplicationNo = '';
	if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
	{
		$a_uvApplicationNo = trim($_REQUEST["uvApplicationNo"]);
	}
	
	$stmt = $mysqli->prepare("select * from prog_choice where vApplicationNo = ?");
	$stmt->bind_param("s", $a_uvApplicationNo);
	$stmt->execute();
	$stmt->store_result();
	
	if ($stmt->num_rows == 0)
	{
		$stmt->close();
		echo 'Invalid application form number';exit;
	}else
	{
		$stmt->close();
	}
	
	$stmt = $mysqli->prepare("select a.cSbmtd, a.cFacultyId, a.iBeginLevel, a.cEduCtgId, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName, a.cStudyCenterId 
	from prog_choice a, programme b, obtainablequal c
	where a.cProgrammeId = b.cProgrammeId and 
	b.cObtQualId = c.cObtQualId and
	a.vApplicationNo = ?");
	$stmt->bind_param("s", $a_uvApplicationNo);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cSbmtd_02, $cFacultyId_03, $iBeginLevel_02, $cEduCtgId, $cProgrammeId_02, $vObtQualTitle_02, $vProgrammeDesc_02, $vLastName_02, $vFirstName_02, $vOtherName_02, $cStudyCenterId);
	$stmt->fetch();
			
	if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
	{
		echo 'Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required actions';exit;
	}

	if ($cSbmtd_02 == '0' && isset($_REQUEST['sm']) && $_REQUEST['sm'] == 3)
	{
		$stmt->close();
		echo 'Form not yet submitted';exit;
	}

	if ($_REQUEST['mm'] == 8 && $vObtQualTitle_02 <> 'M. Phil.,' && $vObtQualTitle_02 <> 'Ph.D.,')
	{
		echo 'Application form number must be that of an M. Phil. or Ph.D. candidate'; exit;
	}else if ($_REQUEST['mm'] == 1 && ($vObtQualTitle_02 == 'M. Phil.,' || $vObtQualTitle_02 == 'Ph.D.,'))
	{
		echo 'Application form number must be that of an undergraduate, PGD or Masters candidate'; exit;
	}else if ($_REQUEST['sRoleID'] == 29 && is_bool(strpos($cProgrammeId_02, 'CHD')))
	{
		echo '*Application form number must be that of a certificate candidate in CHRD'; exit;
	}else if ($_REQUEST['sRoleID'] == 26 && is_bool(strpos($cProgrammeId_02, 'DEG')))
	{
		echo '*Application form number must be that of a certificate candidate in DE&GS';exit;
	}

	echo $cEduCtgId.','.$cProgrammeId_02;
	
}
