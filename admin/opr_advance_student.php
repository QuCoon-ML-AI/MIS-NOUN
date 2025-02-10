<?php
require_once('../../fsher/fisher.php');
include('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$currency = eyes_pilled('0');


$staff_study_center = '';
if (isset($_REQUEST['staff_study_center']))
{
	$staff_study_center = $_REQUEST['staff_study_center'];
}

$orgsetins = settns();


$who_is_this = '';
$blksource = '';
$blksource_name = '';
$act_date = ''; 
$period1 = '';
$str = '';

$hint = '';

$vApplicationNo_01 = '';
$cfacultyId_01 = '';
$iStudy_level_01 = '';
$tSemester_01 = '';
$cSbmtd_01 = '';
$cProgrammeId_01 = '';
$vObtQualTitle_01 = '';
$vProgrammeDesc_0 = '';
$vLastName_01 = '';
$vFirstName_01 = '';
$vOtherName_01 = '';
$cStudyCenterId = '';
$vCityName = '';


$cSbmtd_02 = '';
$cFacultyId_03 = '';
$iBeginLevel_02 = '';
$cProgrammeId_02 = '';
$vObtQualTitle_02 = '';
$vProgrammeDesc_02 = '';
$vLastName_02 = '';
$vFirstName_02 = '';
$vOtherName_02 = '';
$study_mode_02 = '';
$cStudyCenterId = '';

$token = '';
$hint = '';

if (isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1' && isset($_REQUEST['currency_cf']) && $_REQUEST['currency_cf'] == '1' && isset($_REQUEST['whattodo']))
{
    if (!isset($_REQUEST['conf']))
	{		
		$feed_back_message = '';
		
        $stmt = $mysqli->prepare("SELECT f.vApplicationNo, f.cFacultyId, h.vFacultyDesc, i.vdeptDesc, f.iStudy_level, f.tSemester, a.cSbmtd, f.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, a.vLastName, a.vFirstName, a.vOtherName, f.cStudyCenterId, g.vCityName, b.cEduCtgId  
        FROM prog_choice a, programme b, obtainablequal c, afnmatric e, s_m_t f, studycenter g, faculty h, depts i
        WHERE f.cProgrammeId = b.cProgrammeId  
        AND b.cObtQualId = c.cObtQualId 
        AND e.vApplicationNo = a.vApplicationNo 
        AND e.vMatricNo = f.vMatricNo 
        AND f.cStudyCenterId = g.cStudyCenterId
        AND f.cFacultyId = h.cFacultyId
        AND b.cdeptId = i.cdeptId
        AND e.vMatricNo = ?");
        $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($vApplicationNo_01, $cfacultyId_01, $vFacultyDesc, $vdeptDesc, $iStudy_level_01, $tSemester_01, $cSbmtd_01, $cProgrammeId_01, $vObtQualTitle_01, $vProgrammeDesc_01, $vLastName_01, $vFirstName_01, $vOtherName_01, $cStudyCenterId, $vCityName, $cEduCtgId);
        if ($stmt->num_rows === 0 && check_grad_student($_REQUEST["uvApplicationNo"]) == 0)
        {	
            $stmt->close();
            echo '*Matriculation number invalid or yet to sign-up';exit;
        }
        
        $stmt->fetch();
        
        if (is_bool(strpos($staff_study_center, $cStudyCenterId)))
        {
            echo '*Your study centre does not match that of the student<br>Direct student to his/her study centre for required action';exit;
        }
        
        if ($_REQUEST['mm'] == 8 && $vObtQualTitle_01 <> 'M. Phil.,' && $vObtQualTitle_01 <> 'Ph.D.,')
        {
            echo '*Matriculaton number must be that of  an M. Phil. or Ph.D. student'; exit;
        }else if ($_REQUEST['mm'] == 1 && ($vObtQualTitle_01 == 'M. Phil.,' || $vObtQualTitle_01 == 'Ph.D.,'))
        {
            echo '*Matriculaton number must be that of an undergraduate, PGD or Masters student'; exit;
        }

        if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
        {
            echo '*Matriculation number graduated';exit;
        }

        $stmt = $mysqli->prepare("SELECT * FROM student_request_log_1 WHERE passport = '1' AND req_granted = '0' AND vMatricNo = ?");
        $stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0)
        {
            //echo '*Student did not request for reset of passport upload chances';exit;
        }


        $vApplicationNo_01 = $vApplicationNo_01.'+';
        
        if (!is_bool(strpos($vProgrammeDesc_01,"(d)")))
        {
            $vProgrammeDesc_01 = substr($vProgrammeDesc_01, 0, strlen($vProgrammeDesc_01)-4);
        }
        
        $who_is_this = str_pad($vApplicationNo_01, 100).
        str_pad($vLastName_01, 100).
        str_pad($vFirstName_01, 100).
        str_pad($vOtherName_01, 100).
        str_pad($vObtQualTitle_01, 100).
        str_pad($vProgrammeDesc_01, 100).
        str_pad($iStudy_level_01, 100).
        str_pad($tSemester_01, 100).
        str_pad($vCityName, 100).
        str_pad(strtolower($cfacultyId_01), 100).
        str_pad($vFacultyDesc, 100).
        str_pad($vdeptDesc, 100).
        str_pad($cProgrammeId_01, 100).
        str_pad($cEduCtgId, 100).
        str_pad($cStudyCenterId, 100).'#';
        
        $stmt->close();
        
        $feed_back_message = 'Are you sure you want to advance student?';

		if ($_REQUEST['process_step'] == '1')
		{
			echo $who_is_this;exit;
		}else if ($_REQUEST['process_step'] == '2')
		{
            $token = send_token('advancing student','0');
			echo $token.$feed_back_message;exit;
		}
	}else if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
    {
        $token_status = validate_token($_REQUEST["uvApplicationNo"],'advancing student');
    
		if ($token_status <> 'Token valid')
		{
			echo $token_status;
			exit;
		}
        
        try
        {
            $mysqli->autocommit(FALSE); //turn on transactions	
     
			if ($_REQUEST["tSemester"] == 1)
            {
                $sub_sql = " session_reg = '0', semester_reg = '0', ";
            }else if ($_REQUEST["tSemester"] == 2)
            {
                $sub_sql = " session_reg = '1', semester_reg = '0', ";
            }
            
            $stmt = $mysqli->prepare("UPDATE s_m_t  
            SET $sub_sql 
            late_fee = '0', 
            tSemester = ?,
            cAcademicDesc = '".$orgsetins["cAcademicDesc"]."', 
            iStudy_level = ? 
            WHERE vMatricNo = ?");
            $stmt->bind_param("iis", $_REQUEST["tSemester"], $_REQUEST['next_level'], $_REQUEST["uvApplicationNo"]);
            $stmt->execute();
            $stmt->close();

			$stmt = $mysqli->prepare("UPDATE veri_token SET cused = '1', used_time = NOW() WHERE vApplicationNo = ? AND uvApplicationNo = ? AND vtoken = ?");
			$stmt->bind_param("sss", $_REQUEST["vApplicationNo"], $_REQUEST["uvApplicationNo"], $_REQUEST["veri_token"]); 
			$stmt->execute();
			$stmt->close();
           
            log_actv('Advanced '.$_REQUEST["uvApplicationNo"].' to '.$_REQUEST['next_level'].'level, semester '.$_REQUEST["tSemester"]);
			
            $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

            echo "*Student successfully advanced";exit;
        }catch(Exception $e) 
        {
            $mysqli->rollback(); //remove all queries from queue if error (undo)
            throw $e;
        }
    }
}