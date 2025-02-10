<?php

$orgsetins_deg = settns_deg();
$orgsetins_chd = settns_chd();
$orgsetins_spg = settns_spg();

$vApplicationNo_loc = '';
$vTitle_loc = '';
$vLastName_loc = '';
$vFirstName_loc = '';
$vOtherName_loc = '';
$cFacultyId_loc = '';
$vFacultyDesc_loc = '';
$cdeptId_loc = '';
$vdeptDesc_loc = '';
$cProgrammeId_loc = '';
$vObtQualTitle_loc = '';
$vProgrammeDesc_loc = '';
$tSemester_loc = '';
$iStudy_level_loc = '';
$session_reg_loc = '';
$semester_reg_loc = '';
$vEMailId_loc = '';
$vMobileNo_loc = '';
$cEduCtgId_loc = '';
$iEndLevel_loc = '';
$iBeginLevel_loc = '';
$cAcademicDesc = '';
$cAcademicDesc_1 = '';
$cStudyCenterId_loc = '';
$vCityName_loc = '';
$grad = '';
$cResidenceCountryId_loc = '';
$max_crload_loc = '';
$vEduCtgDesc_loc = '';

$number_of_reg_courses = 0;
$number_of_reg_exam = 0;
$successful_login = 0;
$passpotLoaded = 0;
$paid_convoc_gown = 0;

$deg_appl_cat = '';

$balance = 0;
$minfee = 0;
$iItemID_str = '';
$just_paid = '';

$charged_amount = 0;
$charged_desc = '';

$ap_frm_no = '';

$vMatricNo = '';

$number_of_semesters = 0;

$account_close_date = '2024-08-31';
$account_open_date = '2024-09-01';

$wrking_year_tab = 's_tranxion_20242025';

$semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);
$account_close_date = substr($orgsetins['ac_close_date'],4,4).'-'.substr($orgsetins['ac_close_date'],2,2).'-'.substr($orgsetins['ac_close_date'],0,2);
$account_open_date = substr($orgsetins['ac_open_date'],4,4).'-'.substr($orgsetins['ac_open_date'],2,2).'-'.substr($orgsetins['ac_open_date'],0,2);

$wrking_year_tab = WORKING_YR_TABLE;
$wrking_crsreg_tab = 'coursereg_arch_20242025';
$wrking_examreg_tab = 'examreg_20242025';

if (isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '')
{
    $vMatricNo = $_REQUEST['vMatricNo'];
}else if (isset($regno) && $regno <> '')
{
    $vMatricNo = $regno;
}else if (isset($Regno_db) && $Regno_db <> '')
{
    $vMatricNo = $Regno_db;
}

if ($vMatricNo <> '')
{
    $stmt = $mysqli->prepare("SELECT a.vApplicationNo,
    vTitle,
    a.vLastName,
    a.vFirstName,
    a.vOtherName,
    a.cFacultyId,
    b.vFacultyDesc,
    a.cdeptId,
    c.vdeptDesc,
    a.cProgrammeId,
    d.vObtQualTitle,
    e.vProgrammeDesc,
    a.tSemester,
    a.iStudy_level,
    session_reg,
    semester_reg,
    a.vEMailId,
    a.vMobileNo,
    e.cEduCtgId,
    e.iEndLevel,
    a.iBegin_level,
    a.cAcademicDesc,
    a.cAcademicDesc_1,
    a.cStudyCenterId,
    f.vCityName,
    a.grad,
    a.cResidenceCountryId,
    e.max_crload,
    h.vEduCtgDesc,
    e.no_sem
    FROM s_m_t a, faculty b, depts c, obtainablequal d, programme e, studycenter f, educationctg h
    WHERE a.cFacultyId = b.cFacultyId
    AND a.cdeptId = c.cdeptId
    AND a.cObtQualId = d.cObtQualId
    AND a.cProgrammeId = e.cProgrammeId 
    AND a.cStudyCenterId = f.cStudyCenterId
    AND e.cEduCtgId = h.cEduCtgId
    AND a.vMatricNo = ?");
    $stmt->bind_param("s", $vMatricNo);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($vApplicationNo_loc, 
    $vTitle_loc, 
    $vLastName_loc, 
    $vFirstName_loc, 
    $vOtherName_loc, 
    $cFacultyId_loc, 
    $vFacultyDesc_loc, 
    $cdeptId_loc, 
    $vdeptDesc_loc, 
    $cProgrammeId_loc, 
    $vObtQualTitle_loc, 
    $vProgrammeDesc_loc, 
    $tSemester_loc, 
    $iStudy_level_loc, 
    $session_reg_loc, 
    $semester_reg_loc, 
    $vEMailId_loc, 
    $vMobileNo_loc, 
    $cEduCtgId_loc, 
    $iEndLevel_loc, 
    $iBeginLevel_loc, 
    $cAcademicDesc, 
    $cAcademicDesc_1, 
    $cStudyCenterId_loc, 
    $vCityName_loc, 
    $grad, 
    $cResidenceCountryId_loc, 
    $max_crload_loc, 
    $vEduCtgDesc_loc,
    $number_of_semesters_loc);
    $stmt->fetch();

    if (is_null($tSemester_loc) || trim($tSemester_loc) == '')
    {
        $tSemester_loc = 0;
    }
    
    if (is_null($iStudy_level_loc) || trim($iStudy_level_loc) == '')
    {
        $iStudy_level_loc = 0;
    }
    
    if (is_null($cAcademicDesc_1) || trim($cAcademicDesc_1) == '')
    {
        $cAcademicDesc_1 = 0;
    }

    if (is_null($vOtherName_loc))
    {
        $vOtherName_loc = '';
    }
    
    if (is_null($cResidenceCountryId_loc) || trim($cResidenceCountryId_loc) == '' || trim($cResidenceCountryId_loc) <> 'NG')
    {
        $cResidenceCountryId_loc = 'NG';
    }

    
    $vLastName_loc = clean_string_as($vLastName_loc, 'names');
    $vFirstName_loc = clean_string_as($vFirstName_loc, 'names');
    $vOtherName_loc = clean_string_as($vOtherName_loc, 'names');

    /*
    AND LEFT(cAcademicDesc = '".$orgsetins["cAcademicDesc"]."' 
    */
    $stmt = $mysqli->prepare("SELECT * FROM coursereg_arch_20242025
    WHERE tdate >= '$semester_begin_date'
    AND vMatricNo = ?");
    $stmt->bind_param("s", $vMatricNo);
    $stmt->execute();
    $stmt->store_result();
    $number_of_reg_courses = $stmt->num_rows;

    $stmt = $mysqli->prepare("SELECT *
    FROM examreg_20242025
    WHERE tdate >= '$semester_begin_date'
    AND vMatricNo = ?");
    $stmt->bind_param("s", $vMatricNo);
    $stmt->execute();
    $stmt->store_result();
    $number_of_reg_exam = $stmt->num_rows;

    $deg_appl_cat = '';
    if (!is_bool(strpos($cProgrammeId_loc, "DEG")))
    {
        $stmt = $mysqli->prepare("SELECT deg_appl_cat FROM deg_appl_cat
        WHERE vApplicationNo  = '$vApplicationNo_loc'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($deg_appl_cat);
        $stmt->fetch();
    }

    $deg_appl_cat = $deg_appl_cat ?? '';

    if (!is_bool(strpos($cProgrammeId_loc, "DEG")))
    {
        $settns_cert = settns_deg();
    }else if (!is_bool(strpos($cProgrammeId_loc, "CHD")))
    {
        $settns_cert = settns_chd();
    }

    $returnedStr = calc_student_bal($vMatricNo, 'mone_at_hand', $cResidenceCountryId_loc);

    $balance = trim(substr($returnedStr, 0, 100));
    $minfee = trim(substr($returnedStr, 100, 100));
    $iItemID_str = trim(substr($returnedStr, 200, 300));
    $just_paid = trim(substr($returnedStr, 500, 100));
    //$split_point = trim(substr($returnedStr, 600, 100));

    if ($balance - $minfee >= 0){$enough_bal = 1;}

    $charged_amount = $minfee;
    $charged_desc = 'Wallet Funding';


    $stmt = $mysqli->prepare("SELECT vApplicationNo from afnmatric where vMatricNo = ?");
    $stmt->bind_param("s", $vMatricNo);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($ap_frm_no);
    $stmt->fetch();

    $stmt = $mysqli->prepare("SELECT a.vApplicationNo from pics a, afnmatric b where a.vApplicationNo = b.vApplicationNo AND b.vMatricNo = ? AND cinfo_type = 'p'");
    $stmt->bind_param("s", $vMatricNo);
    $stmt->execute();
    $stmt->store_result();
    $passpotLoaded = $stmt->num_rows;

    $stmt = $mysqli->prepare("SELECT * FROM s_tranxion_20242025 WHERE cTrntype = 'd' AND vremark LIKE '%Convocation gown%' AND vMatricNo = ?");
    $stmt->bind_param("s", $vMatricNo);
    $stmt->execute();
    $stmt->store_result();
    $paid_convoc_gown = $stmt->num_rows;


    $stmt = $mysqli->prepare("SELECT *
    FROM atv_log 
    WHERE vDeed = 'Login'
    AND vApplicationNo = ?"); 
    $stmt->bind_param("s", $vMatricNo);
    $stmt->execute();
    $stmt->store_result();
    $successful_login = $stmt->num_rows;
 
    $semester_spent_loc = 0;
    $table = search_starting_pt_crs($vMatricNo);
    foreach ($table as &$value)
    {
        $wrking_tab = 'coursereg_arch_'.$value;

        //$stmt = $mysqli->prepare("SELECT COUNT(DISTINCT siLevel,tSemester) FROM $wrking_tab  WHERE vMatricNo = ?");

        // $stmt = $mysqli->prepare("SELECT COUNT(DISTINCT siLevel,tSemester) FROM $wrking_tab  
        // WHERE vMatricNo = ? 
        // AND (cAcademicDesc < ".$orgsetins['cAcademicDesc']." OR (cAcademicDesc = ".$orgsetins['cAcademicDesc']." AND tSemester < $tSemester_loc))");

        $stmt = $mysqli->prepare("SELECT COUNT(DISTINCT LEFT(cAcademicDesc,4),tSemester) FROM $wrking_tab  
        WHERE vMatricNo = ? 
        AND tdate < '$semester_begin_date'");
        $stmt->bind_param("s", $vMatricNo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($num_of_sem_spent);
        $stmt->fetch();

        //echo $value.', '.$num_of_sem_spent.'<br>';
        $semester_spent_loc += $num_of_sem_spent;
    }
    $stmt->close();
    $semester_spent_loc++;

    define("BEGIN_LEVEL", $iBeginLevel_loc);
    define("END_LEVEL", $iEndLevel_loc);
    define("SEMESTER_COUNT", $semester_spent_loc);
}?>