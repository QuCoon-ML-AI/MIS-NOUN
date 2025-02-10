<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$orgsetins = settns();
//$staff_study_center = $_REQUEST['staff_study_center'];

date_default_timezone_set('Africa/Lagos');
$date2 = date("Y-m-d h:i:s");
$date3 = date("Y-m-d");

if (isset($_REQUEST['currency_cf']) && $_REQUEST['currency_cf'] == '1')
{
	$who_is_this = '';
	$grad_status = '';

	if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
    {
        $stmt = $mysqli->prepare("UPDATE vc_request SET
        cdel = 'Y'
        WHERE vMatricNo = ?
        AND cdel = 'N'
        AND LEFT(time_act,10) = '$date3'");
        $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0)
        {
            echo 'Request canceled successfully';
        }else
        {
            echo 'There is no active request';
        }
        
        $stmt->close();
        log_actv('Canceled VC request for '.$_REQUEST['uvApplicationNo']);
    }else if (isset($_REQUEST['frm_upd']) && $_REQUEST['frm_upd'] == '1')
    {
		$stmt = $mysqli->prepare("SELECT f.vApplicationNo, f.cFacultyId, f.iStudy_level, f.tSemester, f.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, f.vLastName, f.vFirstName, f.vOtherName, f.cStudyCenterId, g.vCityName  
		FROM programme b, obtainablequal c, afnmatric e, s_m_t f, studycenter g
		WHERE b.cObtQualId = c.cObtQualId 
		AND e.vMatricNo = f.vMatricNo 
		AND f.cStudyCenterId = g.cStudyCenterId
		AND e.vMatricNo = ?");
		$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($vApplicationNo_01, $cfacultyId_01, $iStudy_level_01, $tSemester_01, $cProgrammeId_01, $vObtQualTitle_01, $vProgrammeDesc_01, $vLastName_01, $vFirstName_01, $vOtherName_01, $cStudyCenterId, $vCityName);
		if ($stmt->num_rows === 0)
		{	
			$stmt->close();
			echo 'Matriculation number invalid or yet to sign-up';exit;
		}
		
		$stmt->fetch();

        $mask = get_mask($_REQUEST['uvApplicationNo']);

        $vApplicationNo_01 = $vApplicationNo_01.'+';

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
        str_pad(strtolower($mask), 100).'#';
		$stmt->close();

        $stmt = $mysqli->prepare("SELECT semester_reg,crs_reg,drp_crs_reg,see_crs_reg_slip,exam_reg,drp_exam_reg,see_exam_reg_slip,time_act,duration, used
		FROM vc_request
		WHERE vMatricNo = ?
        AND cdel = 'N'
        AND used = '0'
        AND LEFT(time_act,10) = '$date3'
        ORDER BY time_act DESC LIMIT 1");
		$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($semester_reg, $crs_reg, $drp_crs_reg, $see_crs_reg_slip, $exam_reg, $drp_exam_reg, $see_exam_reg_slip, $time_act, $duration, $used);
		if ($stmt->num_rows > 0)
		{
			$stmt->fetch();
            
            $date1 = strtotime($time_act); 
            $date3 = strtotime($date2); 
            $diff = abs($date3 - $date1);
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24) / (60*60*24));
            $hours = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24 - $days * 60*60*24) / (60*60));
            $total_minutes = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24 - $days * 60*60*24 - $hours * 60*60) / 60);
            
            // $datetime_1 = $time_act; 
            // $datetime_2 = date("Y-m-d h:i:s");
            // $start_datetime = new DateTime($datetime_1); 
            // $diff = $start_datetime->diff(new DateTime($datetime_2)); 
            // $total_minutes = ($diff->days * 24 * 60);
            // $total_minutes += ($diff->h * 60);
            // $total_minutes += $diff->i;
            
            if ($total_minutes < $duration && $used == '0')
            {
                $who_is_this .= str_pad($semester_reg, 100).
                str_pad($crs_reg, 100).
                str_pad($drp_crs_reg, 100).
                str_pad($see_crs_reg_slip, 100).
                str_pad($exam_reg, 100).
                str_pad($drp_exam_reg, 100).
                str_pad($see_exam_reg_slip, 100).
                str_pad($time_act, 100).
                str_pad($duration, 100).
                str_pad(strtolower($total_minutes), 100).
                str_pad(strtolower($used), 100).'#';        
            }
		}
        $stmt->close();

        echo $who_is_this;
        
        log_actv('Called up VC request history for '.$_REQUEST['uvApplicationNo']);
        exit;
	}else
    {
        //is there a hot request 
        $stmt = $mysqli->prepare("SELECT semester_reg, crs_reg, drp_crs_reg, see_crs_reg_slip, exam_reg, drp_exam_reg, see_exam_reg_slip, time_act, duration, used
		FROM vc_request
		WHERE vMatricNo = ?
        AND cdel = 'N'
        AND LEFT(time_act,10) = '$date3'
        ORDER BY time_act DESC LIMIT 1");
		$stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($semester_reg, $crs_reg, $drp_crs_reg, $see_crs_reg_slip, $exam_reg, $drp_exam_reg, $see_exam_reg_slip, $time_act, $duration, $used);
		if ($stmt->num_rows > 0)
		{	
			$stmt->fetch();
            
            $date1 = strtotime($time_act); 
            $date3 = strtotime($date2); 
            $diff = abs($date3 - $date1);
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24) / (60*60*24));
            $hours = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24 - $days * 60*60*24) / (60*60));
            $total_minutes = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24 - $days * 60*60*24 - $hours * 60*60) / 60);
            
            // $datetime_1 = $time_act; 
            // $datetime_2 = date("Y-m-d h:i:s");
            // $start_datetime = new DateTime($datetime_1); 
            // $diff = $start_datetime->diff(new DateTime($datetime_2)); 
            // $total_minutes = ($diff->days * 24 * 60);
            // $total_minutes += ($diff->h * 60);
            // $total_minutes += $diff->i;
            
            if ($total_minutes < $duration && $used == '0')
            {
                log_actv('Attempted to set up VC request for '.$_REQUEST['uvApplicationNo']);
                echo "There is a request that is yet to be used. Another one cannot be granted";
                exit;
            }
		}
        
        $stmt = $mysqli->prepare("INSERT INTO vc_request SET
        vMatricNo = ?,
        semester_reg = ?,
        crs_reg = ?,
        drp_crs_reg = ?,
        see_crs_reg_slip = ?,
        exam_reg = ?,
        drp_exam_reg = ?,
        see_exam_reg_slip = ?,
        duration = ?,
        ilevel = ?,
        tsemester = ?,
        cAcademicDesc = '".$orgsetins['cAcademicDesc']."',
        time_act = '$date2'");
        $stmt->bind_param("ssssssssiii", $_REQUEST["uvApplicationNo"], $_REQUEST["sp_sem_reg"], $_REQUEST["sp_crs_reg"], $_REQUEST["sp_drop_crs_reg"], $_REQUEST["sp_see_crs_reg"], $_REQUEST["sp_exam_reg"], $_REQUEST["sp_drop_exam_reg"], $_REQUEST["sp_see_exam_reg"], $_REQUEST["vc_request_close"], $_REQUEST["sp_ilevel"], $_REQUEST["sp_tsemester"]); 
        $stmt->execute();
        $stmt->close();

        echo 'Request granted successfully';        
        log_actv('Set up VC request for '.$_REQUEST['uvApplicationNo']);
        exit;        
    }
}
