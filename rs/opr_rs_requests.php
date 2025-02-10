<?php

require_once('../../fsher/fisher.php');
include('const_def.php');
include(BASE_FILE_NAME.'lib_fn.php');
include('std_lib_fn.php');

$mysqli = link_connect_db();

$orgsetins = settns();
		
$semester_begin = substr($orgsetins['semdate1'],4,4).'-'.substr($orgsetins['semdate1'],2,2).'-'.substr($orgsetins['semdate1'],0,2);
$semester_end = substr($orgsetins['semdate2'],4,4).'-'.substr($orgsetins['semdate2'],2,2).'-'.substr($orgsetins['semdate2'],0,2);

$wrking_crsreg_tab = 'coursereg_arch_20242025';

$name_req = '';
$prog_req = '';
$prog_req_date= '';
$centre_req = '';
$centre_req_date = '';
$level_req = '';
$level_req_date = '';
$passport = '';
$passport_date = '';

$transcript_req_date = '';
$transcript_req = '';
$req_canceled = '';

$sub_qry = '';



if ($_REQUEST["side_menu_no"] == 'change_of_level')
{
    $sub_qry = " AND level_req = '1' AND level_req_date >= '".$semester_begin."' AND level_req_date <= '".$semester_end."'";
}else if ($_REQUEST["side_menu_no"] == 'change_of_programme')
{
    $sub_qry = " AND prog_req = '1' AND prog_req_date >= '".$semester_begin."' AND prog_req_date <= '".$semester_end."'";
}else if ($_REQUEST["side_menu_no"] == 'change_of_study_centre')
{
    $sub_qry = " AND centre_req = '1' AND centre_req_date >= '".$semester_begin."' AND centre_req_date <= '".$semester_end."'";
}else if ($_REQUEST["side_menu_no"] == 'passport_upload')
{
    $sub_qry = " AND passport = '1' AND passport_date >= '".$semester_begin."' AND passport_date <= '".$semester_end."'";
}else if ($_REQUEST["side_menu_no"] == 'transcript')
{
    $sub_qry = " AND transcript_req = '1' AND transcript_req_date >= '".$semester_begin."' AND transcript_req_date <= '".$semester_end."'";
}

$stmt = $mysqli->prepare("SELECT name_req, prog_req, prog_req_date, centre_req, centre_req_date, level_req, level_req_date, passport, passport_date, transcript_req, transcript_req_date, req_canceled
FROM student_request_log_1 
WHERE vMatricNo = ? 
AND req_granted = '0'
AND req_canceled = '0' 
$sub_qry
ORDER BY act_date DESC LIMIT 1");
$stmt->bind_param("s", $_REQUEST['vMatricNo']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($name_req, $prog_req, $prog_req_date, $centre_req, $centre_req_date, $level_req, $level_req_date, $passport, $passport_date, $transcript_req, $transcript_req_date, $req_canceled);
$stmt->fetch();
$stmt->close();

$can_cancel = 0;

if ($_REQUEST["side_menu_no"] == 'change_of_level' && $level_req == '1')
{
    $can_cancel = 1;
}else if ($_REQUEST["side_menu_no"] == 'change_of_programme' && $prog_req == '1')
{
    $can_cancel = 1;
}else if ($_REQUEST["side_menu_no"] == 'change_of_study_centre' && $centre_req == '1')
{
    $can_cancel = 1;
}else if ($_REQUEST["side_menu_no"] == 'passport_upload' && $passport == '1')
{
    $can_cancel = 1;
}else if ($_REQUEST["side_menu_no"] == 'transcript' && $transcript_req == '1')
{
    $can_cancel = 1;
}

if (isset($_REQUEST["cancel_op"]) && $_REQUEST["cancel_op"] == '1')
{    
    if ($can_cancel == 0)
    {
        echo 'No request palced in the current semester';
        exit;
    }

    if ($_REQUEST["side_menu_no"] == 'change_of_level' && $level_req == '1')
    {
        $stmt = $mysqli->prepare("UPDATE student_request_log_1 SET
        req_canceled = '1'
        WHERE vMatricNo = ?
        AND level_req = '1'
        AND req_granted = '0'");
        $stmt->bind_param("s", $_REQUEST['vMatricNo']);
        $stmt->execute();
        if ($stmt->affected_rows > 0)
        {
            echo 'Success';
            log_actv('Request for change of level canceled');    
        }else
        {
            echo 'No record updated';
            log_actv('Attempted to cancel request for change of level');    
        }
        $stmt->close();
        exit;
    }else if ($_REQUEST["side_menu_no"] == 'change_of_programme' && $prog_req == '1')
    {
        $stmt = $mysqli->prepare("UPDATE student_request_log_1 SET
        req_canceled = '1'
        WHERE vMatricNo = ?
        AND prog_req = '1'
        AND req_granted = '0'");
        $stmt->bind_param("s", $_REQUEST['vMatricNo']);
        $stmt->execute();
        if ($stmt->affected_rows > 0)
        {
            echo 'Success';
            log_actv('Request for change of programme canceled');    
        }else
        {
            echo 'No record updated';
            log_actv('Attempted to cancel request for change of programme');    
        }
        $stmt->close();
        exit;
    }else if ($_REQUEST["side_menu_no"] == 'change_of_study_centre' && $centre_req == '1')
    {
        $stmt = $mysqli->prepare("UPDATE student_request_log_1 SET
        req_canceled = '1'
        WHERE vMatricNo = ?
        AND centre_req = '1'
        AND req_granted = '0'");
        $stmt->bind_param("s", $_REQUEST['vMatricNo']);
        $stmt->execute();
        if ($stmt->affected_rows > 0)
        {
            echo 'Success';
            log_actv('Request for change of study centre canceled');    
        }else
        {
            echo 'No record updated';
            log_actv('Attempted to cancel request for change of study centre');    
        }
        $stmt->close();
        exit;
    }else if ($_REQUEST["side_menu_no"] == 'passport_upload' && $passport == '1')
    {
        $stmt = $mysqli->prepare("UPDATE student_request_log_1 SET
        req_canceled = '1'
        WHERE vMatricNo = ?
        AND passport = '1'
        AND req_granted = '0'");
        $stmt->bind_param("s", $_REQUEST['vMatricNo']);
        $stmt->execute();
        if ($stmt->affected_rows > 0)
        {
            echo 'Success';
            log_actv('Request for re-uploading of passport picture canceled');    
        }else
        {
            echo 'No record updated';
            log_actv('Attempted to cancel request for re-uploading of passport picture');    
        }
        $stmt->close();
        exit;
    }else if ($_REQUEST["side_menu_no"] == 'transcript' && $transcript_req == '1')
    {
        $stmt = $mysqli->prepare("UPDATE student_request_log_1 SET
        req_canceled = '1'
        WHERE vMatricNo = ?
        AND transcript_req = '1'
        AND req_granted = '0'");
        $stmt->bind_param("s", $_REQUEST['vMatricNo']);
        $stmt->execute();
        if ($stmt->affected_rows > 0)
        {
            echo 'Success';
            log_actv('Request for transcript canceled');    
        }else
        {
            echo 'No record updated';
            log_actv('Attempted to cancel request for transcript');    
        }
        $stmt->close();
        exit;
    }else if ($_REQUEST["side_menu_no"] == 'change_of_name')
    {
        
    }
}else
{
    if ($name_req == '1' && $level_req_date >= $semester_begin && $level_req_date <= $semester_end)
    {
        echo "Request for change of name placed on ".formatdate($level_req_date,'fromdb')." is pending<br>New request cannot be placed";exit;
    }else if ($level_req == '1' && $level_req_date >= $semester_begin && $level_req_date <= $semester_end)
    {
        echo "Request for change of level placed on ".formatdate($level_req_date,'fromdb')." is pending<br>New request cannot be placed";exit;
    }else if ($prog_req == '1' && $prog_req_date >= $semester_begin && $prog_req_date <= $semester_end)
    {
        echo "Request for change of prgramme placed on ".formatdate($prog_req_date,'fromdb')." is pending<br>New request cannot be placed";exit;
    }else if ($centre_req == '1' && $centre_req_date >= $semester_begin && $centre_req_date <= $semester_end)
    {
        echo "Request for change of study centre placed on ".formatdate($centre_req_date,'fromdb')." is pending<br>New request cannot be placed";exit;
    }else if ($passport == '1' && $passport_date >= $semester_begin && $passport_date <= $semester_end)
    {
        echo "Request for re-uplaoding of passport placed on ".formatdate($passport_date,'fromdb')." is pending<br>New request cannot be placed";exit;
    }else if ($transcript_req == '1' && $transcript_req_date >= $semester_begin && $transcript_req_date <= $semester_end)
    {
        echo "Request for transcript placed on ".formatdate($transcript_req_date,'fromdb')." is pending<br>New request cannot be placed";exit;
    }
}

if (isset($_REQUEST["name_req"]))
{
    $stmt = $mysqli->prepare("REPLACE INTO student_request_log_1 SET
    vMatricNo = ?,
    name_req = '1',
    cnewname = ?,
    name_req_date = CURDATE(),
    coldname = ?");
    $stmt->bind_param("sss", $_REQUEST['vMatricNo'], $_REQUEST['name_req'], $_REQUEST['curent_level']);
    $stmt->execute();
    $stmt->close();
    
    log_actv('Requested for change of level');
}else if (isset($_REQUEST["level_req"]))
{
    $stmt = $mysqli->prepare("SELECT * FROM $wrking_crsreg_tab
    WHERE tdate >= '$semester_begin'
    AND vMatricNo = ?");
    $stmt->bind_param("s", $_REQUEST['vMatricNo']);
    $stmt->execute();
    $stmt->store_result();
    $number_of_reg_courses = $stmt->num_rows;

    if ($number_of_reg_courses > 0)
    {
        echo 'You have registered courses in the semester';
        exit;
    }

    $cango = courses_reg_above_level ();
    if ($cango > 0 && $_REQUEST['vMatricNo'] <> 'NOU240000112')
    {
        echo 'You have registered courses above requested level';
        exit;
    }


    $cango = immediate_past_course_reg();
    //if ($cango == 0 && $_REQUEST['vMatricNo'] == 'NOU240000112')
    //if ($_REQUEST['vMatricNo'] == 'NOU240000112')
    //{
        if ($cango == -1)
        {
            echo 'Invalid request';
            exit;
        }else if ($cango == 0)
        {
            echo 'There are no course registration records in the immediate past level and semester';
            exit;
        }
        
        //echo $cango;
        //exit;
    //}



    if (isset($_REQUEST['request_token']) && $_REQUEST['request_token'] == 1)
    {
        send_token('request for change of level');
        echo 'Token sent';
        exit;
    }else if (isset($_REQUEST['token_supplied']) && $_REQUEST['token_supplied'] == 1)
    {
        $token_status = validate_token('request for change of level');
        
        if ($token_status <> 'Token valid')
        {
            echo $token_status;
            exit;
        }
    }else
    {
        echo 'Invalid request';
        exit;
    }

    $stmt = $mysqli->prepare("REPLACE INTO student_request_log_1 SET
    vMatricNo = ?,
    level_req = '1',
    cnewlevel = ?,
    level_req_date = CURDATE(),
    coldlevel = ?,
    cnewsemester = ?,
    coldsemester = ?");
    $stmt->bind_param("sssii", $_REQUEST['vMatricNo'], $_REQUEST['level_req'], $_REQUEST['curent_level'], $_REQUEST['semester_req'], $_REQUEST['curent_semester']);
    $stmt->execute();
    $stmt->close();
    
    log_actv('Requested for change of level');
}else if (isset($_REQUEST["cprogrammeIdold_req"]))
{
    $stmt = $mysqli->prepare("REPLACE INTO student_request_log_1 SET
    vMatricNo = ?,
    prog_req = '1',
    cnewprog = ?,
    prog_req_date = CURDATE(),
    coldprog = ?");
    $stmt->bind_param("sss", $_REQUEST['vMatricNo'], $_REQUEST['cprogrammeIdold_req'], $_REQUEST['curent_program']);
    $stmt->execute();
    $stmt->close();
    
    log_actv('Requested for change of programme');
}else if (isset($_REQUEST["cStudyCenterId"]))
{
    if (isset($_REQUEST['request_token']) && $_REQUEST['request_token'] == 1)
    {
        send_token('request for change of centre');
        echo 'Token sent';
        exit;
    }else if (isset($_REQUEST['token_supplied']) && $_REQUEST['token_supplied'] == 1)
    {
        $token_status = validate_token('request for change of centre');
        
        if ($token_status <> 'Token valid')
        {
            echo $token_status;
            exit;
        }
    }else
    {
        echo 'Invalid request';
        exit;
    }
    
    $stmt = $mysqli->prepare("REPLACE INTO student_request_log_1 SET
    vMatricNo = ?,
    centre_req = '1',
    cnewcentre = ?,
    centre_req_date = CURDATE(),
    coldcentre = ?");
    $stmt->bind_param("sss", $_REQUEST['vMatricNo'], $_REQUEST['cStudyCenterId'], $_REQUEST['curent_sc']);
    $stmt->execute();
    $stmt->close();
    
    log_actv('Requested for change of center');
}else if (isset($_REQUEST["passport_req"]))
{
    $stmt = $mysqli->prepare("REPLACE INTO student_request_log_1 SET
    vMatricNo = ?,
    passport = ?,
    passport_date = CURDATE()");
    $stmt->bind_param("ss", $_REQUEST['vMatricNo'], $_REQUEST['passport_req']);
    $stmt->execute();
    $stmt->close();
    
    log_actv('Requested for passport update');
}else if (isset($_REQUEST["transcript_req"]))
{
    $stmt = $mysqli->prepare("REPLACE INTO student_request_log_1 SET
    vMatricNo = ?,
    transcript_req = ?,
    transcript_req_date = CURDATE()");
    $stmt->bind_param("ss", $_REQUEST['vMatricNo'], $_REQUEST['transcript_req']);
    $stmt->execute();
    $stmt->close();
    
    log_actv('Requested for transcript');
}
echo "Success";
exit;


function courses_reg_above_level ()
{
	$matno = $_REQUEST['vMatricNo'];
    $level = $_REQUEST['level_req'];

    if ($level == 100)
	{
		$confirm_str = "('1','2','3','4','5','7','8','9')";
	}else if ($level == 200)
	{
		$confirm_str = "('2','3','4','5','7','8','9')";
	}else if ($level == 300)
	{
		$confirm_str = "('3','4','5','7','8','9')";
	}else if ($level == 400)
	{
		$confirm_str = "('4','5','7','8','9')";
	}else if ($level == 500)
	{
		$confirm_str = "('5','7','8','9')";
	}else if ($level == 700)
	{
		$confirm_str = "('8','9')";
	}else if ($level == 800)
	{
		$confirm_str = "('9')";
	}

	$mysqli = link_connect_db();

    if(substr($matno,3,2) <= 19)
	{
		$tables = '20172019,20202021,20222023,20242025';		
	}else if(substr($matno,3,2) == 20 || substr($matno,3,2) == 21)
	{
		$tables = '20202021,20222023,20242025';
	}else if(substr($matno,3,2) == 22 || substr($matno,3,2) == 23)
	{
		$tables = '20222023,20242025';
	}else
	{
		$tables = '20242025';
	}
	
    $num = 0;
	$table = explode(",", $tables);

    foreach ($table as &$value)
    {
        $wrking_tab_loc = 'coursereg_arch_'.$value;

        $stmt = $mysqli->prepare("SELECT *
        FROM $wrking_tab_loc 
        WHERE vMatricNo = ?
        AND MID(cCourseId,4,1) IN $confirm_str");
        $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
        $stmt->execute();
        $stmt->store_result();
        $num = $stmt->num_rows;

        if ($num > 0)
        {
            return $num;
        }
    }

	// $stmt = $mysqli->prepare("SELECT * FROM coursereg_arch_20242025 WHERE vMatricNo = ? AND MID(cCourseId,4,1) IN $confirm_str");
	// $stmt->bind_param("s", $matno);
	// $stmt->execute();
	// $stmt->store_result();
	// $num = $stmt->num_rows;
	// $stmt->close();

	return $num;
}

function immediate_past_course_reg()
{
    $mysqli = link_connect_db();

    if(substr($_REQUEST["vMatricNo"],3,2) <= 19)
	{
		$tables = '20172019,20202021,20222023,20242025';		
	}else if(substr($_REQUEST["vMatricNo"],3,2) == 20 || substr($_REQUEST["vMatricNo"],3,2) == 21)
	{
		$tables = '20202021,20222023,20242025';
	}else if(substr($_REQUEST["vMatricNo"],3,2) == 22 || substr($_REQUEST["vMatricNo"],3,2) == 23)
	{
		$tables = '20222023,20242025';
	}else
	{
		$tables = '20242025';
	}
	
    $num = 0;
	$table = explode(",", $tables);

    if ($_REQUEST['begin_level'] ==  $_REQUEST['level_req'])
    {
        if ($_REQUEST['semester_req'] == 1)
        {
            return -1;
        }else if ($_REQUEST['semester_req'] == 2)
        {
            //check course reg. record in $_REQUEST['level_req'] and $_REQUEST['semester_req'] -1
            $pst_level = $_REQUEST['level_req'];
            $past_semester = 1;
            return 0;
        }
    }else if ($_REQUEST['level_req'] < $_REQUEST['begin_level'])
    {
        //invalid request
        return -1;
    }else if ($_REQUEST['level_req'] > $_REQUEST['begin_level'])
    {
        $pst_level = $_REQUEST['level_req'] - 100;
        if ($_REQUEST['semester_req'] == 1)
        {
            //check course reg. record in $pst_level and 2nd semester
            $past_semester = 2;
        }else if ($_REQUEST['semester_req'] == 2)
        {
            //check course reg. record in $pst_level and 1st semester
            $past_semester = 1;
        }
    }


    $subqry = "";

    if ($pst_level == 100)
	{
        $subqry = " AND MID(cCourseId,4,1) = 1";
	}else if ($pst_level == 200)
	{
        $subqry = " AND MID(cCourseId,4,1) = 2";
	}else if ($pst_level == 300)
	{
        $subqry = " AND MID(cCourseId,4,1) = 3";
	}else if ($pst_level == 400)
	{
        $subqry = " AND MID(cCourseId,4,1) = 4";
	}else if ($pst_level == 500)
	{
        $subqry = " AND MID(cCourseId,4,1) = 5";
	}else if ($pst_level == 700)
	{
        $subqry = " AND MID(cCourseId,4,1) = 7";
	}else if ($pst_level == 800)
	{
        $subqry = " AND MID(cCourseId,4,1) = 8";
	}

    
    if ($past_semester == 1)
    {
        $subqry .= " AND MID(cCourseId,6,1) IN ('1','3','5','7','9')";
    }else if ($past_semester == 2)
    {
        $subqry .= " AND MID(cCourseId,6,1) IN ('0','2','4','6','8')";
    }
    
    foreach ($table as &$value)
    {
        $wrking_tab_loc = 'coursereg_arch_'.$value;

        $stmt = $mysqli->prepare("SELECT *
        FROM $wrking_tab_loc 
        WHERE vMatricNo = ?
        $subqry");
        $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
        $stmt->execute();
        $stmt->store_result();
        $num = $stmt->num_rows;
    }

    return $num;

    // return $_REQUEST['begin_level'].','.$_REQUEST['curent_level'].','.$_REQUEST['curent_semester'];
}?>