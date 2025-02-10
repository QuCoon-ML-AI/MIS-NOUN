<?php

$vTitle = '';
$vLastName = '';
$vFirstName = '';
$vOtherName = '';
$vFacultyDesc = '';
$vdeptDesc = '';
$cProgrammeId = '';
$vObtQualTitle = '';
$vProgrammeDesc = '';
$iStudy_level = '';
$cEduCtgId = '';
$tSemester = '';
$tSemester_reg = '';
$col_gown = '';
$ret_gown = '';
$vCityName = '';

$cEduCtgId_su = '';

if ($mm == 1 || $mm == 8 || ($mm == 0 && $sm >= 9) || $mm == 3 || ($mm == 2 && $sm > 1) || ($mm == 4) || $mm == 5)
{
    // $uvApplicationNo_1 = '';
    // $uvApplicationNo_2 = '';
    // if (isset($_REQUEST['uvApplicationNo']))
    // {
    //     $uvApplicationNo_1 = $_REQUEST['uvApplicationNo'];
    //     $uvApplicationNo_2 = $_REQUEST['uvApplicationNo'];
    // }
    
    $stmt = $mysqli->prepare("select vTitle, vLastName, vFirstName, vOtherName, a.cFacultyId, b.vFacultyDesc, c.vdeptDesc,a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.tSemester, a.semester_reg, a.iBegin_level, a.iStudy_level, e.cEduCtgId, a.tSemester, a.col_gown, a.ret_gown , f.vCityName, cResidenceCountryId
    from s_m_t a, faculty b, depts c, obtainablequal d, programme e, studycenter f, afnmatric g
    where a.cFacultyId = b.cFacultyId
    and a.cdeptId = c.cdeptId
    and a.cObtQualId = d.cObtQualId
    and a.cProgrammeId = e.cProgrammeId
    and a.cStudyCenterId = f.cStudyCenterId
    and g.vMatricNo = a.vMatricNo
    and (g.vMatricNo = ? or
    g.vApplicationNo = ?)");
    $stmt->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST['uvApplicationNo']);
    $stmt->execute();
    $stmt->store_result();

    $stmt->bind_result($vTitle, $vLastName, $vFirstName, $vOtherName, $cFacultyId, $vFacultyDesc, $vdeptDesc, $cProgrammeId, $vObtQualTitle, $vProgrammeDesc, $tSemester_su, $tSemester_reg_su, $iBegin_level, $iStudy_level, $cEduCtgId, $tSemester, $col_gown, $ret_gown,  $vCityName, $cResidenceCountryId);
    
    $student_user_num = $stmt->num_rows;
    $stmt->fetch();
    $stmt->close();

    $cEduCtgId_su = $cEduCtgId;

    $cFacultyId_su = $cFacultyId;
    $vFacultyDesc_su = $vFacultyDesc;
    $vdeptDesc_su = $vdeptDesc;

    $vObtQualTitle_su = $vObtQualTitle;
    $vProgrammeDesc_su = $vProgrammeDesc;
    $iStudy_level_su = $iStudy_level;
    $entry_level_su = $iBegin_level;
    $tSemester_su = $tSemester;
    $vCityName_su = $vCityName;

    $cResidenceCountryId_su = $cResidenceCountryId;

	if ($orgsetins['ind_semster'] == '1')
	{
		$tSemester = $tSemester_su;
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

$userInfo = '';

$username = '';
$cFacultyId_u= '';
$vFacultyDesc_u = '';
$cdeptId_u = '';
$vdeptDesc_u = '';
$sRoleID = '';
$sRoleID_u = '';
$cProgrammeId_u = '';
$cemail = '';
$cphone_u = '';


$stmt = $mysqli->prepare("SELECT concat(vLastName,' ',vFirstName,' ',vOtherName) username, a.cFacultyId, b.vFacultyDesc, a.cdeptId, c.vdeptDesc, d.sRoleID, a.cemail, a.cphone
FROM userlogin a, faculty b, depts c, role_user d
WHERE a.cFacultyId = b.cFacultyId and 
a.cdeptId = c.cdeptId and 
d.vUserId = a.vApplicationNo and
vApplicationNo = ?");
$stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($username, $cFacultyId_u, $vFacultyDesc_u, $cdeptId_u, $vdeptDesc_u, $sRoleID_u, $cemail, $cphone_u);

if ($stmt->num_rows == 0)
{
    $stmt = $mysqli->prepare("SELECT concat(vLastName,' ',vFirstName,' ',vOtherName) username, a.cFacultyId, a.cdeptId, d.sRoleID, a.cemail, a.cphone
    FROM userlogin a, role_user d
    WHERE d.vUserId = a.vApplicationNo and
    vApplicationNo = ?");
    $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
    $stmt->execute();
    $stmt->store_result();
	$stmt->bind_result($username, $cFacultyId_u, $cdeptId_u, $sRoleID_u, $cemail, $cphone_u);
}

if ($stmt->num_rows > 0){$userInfo = '1';}

$stmt->fetch();
$stmt->close();

//$account_close_date = '2024-08-31';
//$account_open_date = '2024-09-01';

//$wrking_year_tab = 's_tranxion_20242025';?>