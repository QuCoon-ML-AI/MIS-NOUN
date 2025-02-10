<?php
require_once('../../fsher/fisher.php');
include('const_def.php');
include(BASE_FILE_NAME.'lib_fn.php');
include(BASE_FILE_NAME.'lib_fn_2.php');

$mysqli = link_connect_db();

$mtn_satus = valid_mtn();

if ($mtn_satus == '0')
{
    echo 'Invalid matriculation number'; exit;
}else if ($mtn_satus == '2')
{
    $stmt = $mysqli->prepare("INSERT IGNORE INTO mtn_act_request SET vMatricNo = ?");
	$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
	$stmt->execute();
	$stmt->close();

    echo 'Matriculation number to be activated'; exit;
}else if ($mtn_satus == '3')
{
    echo 'Programme no more on offer. Contact Academic Registry via your Study Centre for resolution please'; exit;
}else if ($mtn_satus == '4')
{
    echo 'Matriculation number graduated'; exit;
}else if (isset($_REQUEST["recover_pwd"]) && $_REQUEST["recover_pwd"] == '1')
{    
    $feed_back = send_token('password recovery');
    if ($feed_back == 'Token not sent' || $feed_back == 'eMail address error')
    {
        echo $feed_back;
    }else
    {
        echo 'can continue';
    }

    exit;
}

// if (valid_mtn() == '0')
// {
//     // if (mtn_in_arch() == '1')
//     // {
//     //    echo 'Matriculation number archived'; exit;
//     // }
//     echo 'Invalid matriculation number.'; exit;
// }else if (isset($_REQUEST["recover_pwd"]) && $_REQUEST["recover_pwd"] == '1')
// {
    
//     $feed_back = send_token('password recovery');
//     if ($feed_back == 'Token not sent' || $feed_back == 'eMail address error')
//     {
//         echo $feed_back;
//     }else
//     {
//         echo 'can continue';
//     }

//     exit;
// }


if (isset($_REQUEST["cap_text"]) && trim($_REQUEST["cap_text"]) == '')
{
    echo "Enter captcha";exit;
}

$stmt = $mysqli->prepare("SELECT 
cFacultyId,
cdeptId,
cProgrammeId,
cStudyCenterId
FROM s_m_t 
WHERE vMatricNo = ?");
$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
$stmt->execute();
$stmt->store_result();
$on_record = $stmt->num_rows;

if ($on_record <> 0)
{
    $stmt->bind_result($cFacultyId_loc1, 
    $cdeptId_loc1, 
    $cProgrammeId_loc1, 
    $cStudyCenterId_loc1);
    $stmt->fetch();
    $err_msg = '';

    $stmt = $mysqli->prepare("SELECT *
    FROM faculty 
    WHERE cFacultyId = '$cFacultyId_loc1'
    AND cDelFlag = 'N'");
    $stmt->execute();
    $stmt->store_result();
    $faculty_found = $stmt->num_rows;        

    $stmt = $mysqli->prepare("SELECT *
    FROM depts 
    WHERE cdeptId = '$cdeptId_loc1'
    AND cDelFlag = 'N'");
    $stmt->execute();
    $stmt->store_result();
    $dept_found = $stmt->num_rows;

    $stmt = $mysqli->prepare("SELECT *
    FROM programme 
    WHERE cProgrammeId  = '$cProgrammeId_loc1'
    AND cDelFlag = 'N'");
    $stmt->execute();
    $stmt->store_result();
    $programme_found = $stmt->num_rows;


    $stmt = $mysqli->prepare("SELECT *
    FROM studycenter 
    WHERE cStudyCenterId = '$cStudyCenterId_loc1'
    AND cDelFlag = 'N'");
    $stmt->execute();
    $stmt->store_result();
    $centre_found = $stmt->num_rows;


    if ($centre_found == 0)
    {
        echo 'Study centre not defined. Contact Academic Registry via your Study Centre for resolution please';
        exit;
    }else if ($programme_found == 0 && $cProgrammeId_loc1 <> 'MSC205' && $cProgrammeId_loc1 <> 'HSC204' && $cProgrammeId_loc1 <> 'MSC208')
    {
        echo 'Programme not defined. Contact Academic Registry via your Study Centre for resolution please'; 
        exit;
    }else if ($dept_found == 0)
    {
        echo 'Department not defined. Contact Academic Registry via your Study Centre for resolution please';
        exit;
    }else if ($faculty_found == 0)
    {
        echo 'Faculty not defined. Contact Academic Registry via your Study Centre for resolution please';
        exit;
    }
}


/*$stmt_a = $mysqli->prepare("SELECT * FROM s_m_t WHERE vMatricNo = ? and cProgrammeId IN ('MSC202','MSC203')");
$stmt_a->bind_param("s", $_REQUEST['vMatricNo']);
$stmt_a->execute();
$stmt_a->store_result();
if ($stmt_a->num_rows > 0)
{
    echo 'Please try again latter';
    exit;
}*/



$dob_status = check_dob();
if ($dob_status <> '')
{
    //echo $dob_status;
    //exit;
}

$pp_status = get_s_pp_pix();
if ($pp_status <> '')
{
    //echo $pp_status;
    //exit;
}


$orgsetins = settns();

//Track login attempts
$count_log_attempt = count_login_attempt();

$count_login_attempt = '';
$attempt_msg = '';
if (strpos($count_log_attempt,"*"))
{
    $login_count = substr($count_log_attempt, 0, strlen($count_log_attempt)-3);
    
    if ($orgsetins["max_login"]-($login_count+1) > 0 && $orgsetins["max_login"]-($login_count+1) <= 3)
    {
        $count_login_attempt = substr($count_log_attempt, 0, strlen($count_log_attempt)-1);
        $attempt_msg = '<p>'.($orgsetins["max_login"]-($count_login_attempt+1)) . ' more attempt(s)';
    }
}

$elapsed_time = '';
if (strpos($count_log_attempt,"min"))
{
    $elapsed_time = substr($count_log_attempt, 0, strlen($count_log_attempt)-3);
}

if ((is_numeric($count_login_attempt) && $count_login_attempt >= $orgsetins["max_login"]) || (is_numeric($elapsed_time) && $elapsed_time < $orgsetins["wait_max_login"] && $elapsed_time >= 0))
{
    if ($orgsetins["wait_max_login"] - $elapsed_time > 1)
    {
        echo 'Account temporarily disabled. Try again in '.($orgsetins["wait_max_login"] - $elapsed_time).'mins';
    }else
    {
        echo 'Account temporarily disabled. Try again in '.($orgsetins["wait_max_login"] - $elapsed_time).'min';
    }
    
    exit;
}


$check_grad_student = 0;

//has mat. no for candidate logged in?
$stmt_a = $mysqli->prepare("SELECT vPassword, md5(?) vPassword_md5 FROM rs_client WHERE vMatricNo = ?");
$stmt_a->bind_param("ss", $_REQUEST['vPassword'], $_REQUEST['vMatricNo']);
$stmt_a->execute();
$stmt_a->store_result();
$stmt_a->bind_result($vPassword, $vPassword_md5);
$stmt_a->fetch();
$stmt_a->close();

$vPassword = $vPassword ?? '';

if ($vPassword == 'frsh' || $vPassword == '')
{
    log_actv('Login attempt failed because student has not signed up');
    $msg = 'If you were active on the student section of the University portal before 14th July 2024, see announcement section on the home page for guide<p>
    If you are a fresh student, do the following to sign-up:
        <ol>
            <li>Click home button</li>
            <li>Enter your matriculation number in the corresponding box</li>
            <li>Enter a password of your choice in the two corresponding boxes</li>
            <li>Click the submit button</li>
            <li>Follow the prompt on the screen</li>
        </ol>';
    echo  $msg;exit;
}

//did earlier sign-up fail?
$stmt = $mysqli->prepare("SELECT * FROM s_m_t WHERE vMatricNo = ?");
$stmt->bind_param("s", $_REQUEST['vMatricNo']);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0)
{
    $stmt_a = $mysqli->prepare("UPDATE rs_client SET vPassword = 'frsh', cap_text = 'xxxxxxx' WHERE vMatricNo = ?");
    $stmt_a->bind_param("s", $_REQUEST['vMatricNo']);
    $stmt_a->execute();
    $stmt_a->close();
    
    echo 'We could not conclude the earlier signing-up process<br> Please ensure you have a steady internet connection and sign-up by clicking <br> Home->Fresh student->Follow prompt on the screen';
    exit;
}


//is candidate expected to submit transcript?
/*$stmt = $mysqli->prepare("SELECT vApplicationNo, b.cEduCtgId FROM s_m_t a, programme b WHERE a.cProgrammeId = b.cProgrammeId  AND vMatricNo = ?");
$stmt->bind_param("s", $_REQUEST['vMatricNo']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($vApplicationNo_loc, $cEduCtgId_loc);
$stmt->fetch();

if ($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY' || $cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX')
{
    $stmt = $mysqli->prepare("SELECT * FROM prog_choice_pg WHERE transcript = '1' AND vApplicationNo = ?");
    $stmt->bind_param("s", $vApplicationNo_loc);
    $stmt->execute();
    $stmt->store_result();
    $submited_trn = $stmt->num_rows;

    if ($cEduCtgId_loc <> 'PRX')
    {
        $stmt = $mysqli->prepare("SELECT DATEDIFF(NOW(), tDeedTime) FROM atv_log WHERE vDeed = 'submitted application form'  AND vApplicationNo  = '$vApplicationNo_loc'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($time_elapsed);
        $stmt->fetch();

        if ($submited_trn == 0 && $time_elapsed > 90)
        {
            $stmt->close();
            echo 'Account. blocked<br>Transcript yet to be submitted<br>Contact SPGS for resolution';exit;
        }
    }else
    {
        if ($submited_trn == 0)
        {
            $stmt->close();
            echo 'Account. blocked<br>Transcript yet to be submitted<br>Contact SPGS for resolution';exit;
        }
    }
}*/


//is student blocked/suspnded/expelled from reg?
$stmt = $mysqli->prepare("SELECT cblk, csuspe, act_date, cexpe, tempwith, permwith, rect_risn, (now() >= period2) deadline, period1, DATE_ADD(period2, INTERVAL 1 DAY) period2, regist, stdycentre, ictech FROM rectional WHERE vMatricNo = ? AND stdycentre = '0' ORDER BY act_date desc limit 1");
$stmt->bind_param("s", $_REQUEST['vMatricNo']);
$stmt->execute();
$stmt->store_result();
$number_of_record = $stmt->num_rows;
$stmt->bind_result($cblk, $csuspe, $act_date, $cexpe, $tempwith, $permwith, $rect_risn, $deadline, $period1, $period2, $regist, $stdycentre, $ictech);
$stmt->fetch();
$stmt->close();

if ($number_of_record > 0)
{
    if ($deadline == '1' && $csuspe == '1')
    {
        $stmt1 = $mysqli->prepare("update rectional SET csuspe_arch = '1', csuspe = '0' WHERE vMatricNo = ? AND act_date = '$act_date' AND period2 = '$period2'");
        $stmt1->bind_param("s", $_REQUEST['vMatricNo']);
        $stmt1->execute();
        $stmt1->close();

        $csuspe = '0';
    }

    $sub_naration = '';
    if ($regist == '1')
    {
        $sub_naration = ' at the Registry';
    }else  if ($stdycentre == '1')
    {
        $sub_naration = ' at the Study Centre';
    }else  if ($ictech == '1')
    {
        $sub_naration = ' at the DMIS';
    }

    if ($cblk == '1')
    {
        log_actv('Login attempt failed because student is blocked');
        //echo 'Account blocked on '.formatdate($act_date,'fromdb').' '.$sub_naration .'. Reason :'.$rect_risn;exit;
        echo 'Account blocked on '.formatdate($act_date,'fromdb').' Reason : '.$rect_risn;exit;
    }else if ($csuspe == '1')
    {
        log_actv('Login attempt failed because student is suspended');
        //echo '0Student suspended on '.$act_date.'; '.$rect_risn; exit;
        //echo 'Student suspended on '.formatdate($period1,'fromdb').' '.$sub_naration .'. Reason :'.$rect_risn.'. To return on '.formatdate($period2,'fromdb'); exit;
        echo 'Account suspended on '.formatdate($period1,'fromdb').'. Reason :'.$rect_risn.'. To return on '.formatdate($period2,'fromdb'); exit;
    }else if ($cexpe == '1')
    {
        log_actv('Login attempt failed because student is expelled');
        //echo 'Student expelled on '.formatdate($act_date,'fromdb').' '.$sub_naration .'. Reason :'.$rect_risn; exit;
        echo 'Student expelled on '.formatdate($act_date,'fromdb').'. Reason :'.$rect_risn; exit;
    }else if ($tempwith == '1')
    {
        log_actv('Login attempt failed because student has withdrawn temporarily');
        //echo 'Student withdrew temporarily on '.formatdate($act_date,'fromdb').' '.$sub_naration .'. Reason :'.$rect_risn; exit;
        echo 'Student withdrew temporarily on '.formatdate($act_date,'fromdb').'. Reason :'.$rect_risn; exit;
    }else if ($permwith == '1')
    {
        log_actv('Login attempt failed because student has withdrawn permanently');
        //echo 'Student withdrew permanently on '.formatdate($act_date,'fromdb').' '.$sub_naration .'. Reason :'.$rect_risn; exit;
        echo 'Student withdrew permanently on '.formatdate($act_date,'fromdb').'. Reason :'.$rect_risn; exit;
    }else if ($check_grad_student == 1)
    {
        log_actv('Login attempt failed because student has graduated');
        echo 'Student graduated'; exit;
    }
}


//is applicant blocked from sc?
$stmt = $mysqli->prepare("SELECT cblk, rect_risn, rect_risn1, act_date FROM rectional WHERE vMatricNo = ? AND stdycentre = '1' ORDER BY act_date desc limit 1");
$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($cblk, $rect_risn, $rect_risn1, $act_date);
$stmt->fetch();

if ($cblk == '1')
{
    log_actv('Login attempt failed because applicant is blocked');
    $stmt->close();
    echo 'Access to application form blocked on '.formatdate($act_date,'fromdb').' the study centre. Reason: '.$rect_risn.' '.$rect_risn1; exit;
}

//is applicant blocked from mis?
$stmt = $mysqli->prepare("SELECT cblk, rect_risn, rect_risn1, act_date FROM rectional WHERE vMatricNo = ? AND ictech = '1' ORDER BY act_date desc limit 1");
$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($cblk, $rect_risn, $rect_risn1, $act_date);
$stmt->fetch();

if ($cblk == '1')
{
    log_actv('Login attempt failed because applicant is blocked');
    $stmt->close();
    echo 'Access to application form blocked on '.formatdate($act_date,'fromdb').' at MIS. Reason: '.$rect_risn.' '.$rect_risn1; exit;
}
$stmt->close();


$stmt_a = $mysqli->prepare("SELECT vPassword, md5(?) vPassword_md5, cap_text FROM rs_client WHERE vMatricNo = ?");
$stmt_a->bind_param("ss", $_REQUEST['vPassword'], $_REQUEST['vMatricNo']);
$stmt_a->execute();
$stmt_a->store_result();

$stmt_a->bind_result($vPassword, $vPassword_md5, $cap_text);
$stmt_a->fetch();
$stmt_a->close();

if ($_REQUEST["cap_text"] == 'xxxxxxx' || $_REQUEST["cap_text"] <> $cap_text)
{
    log_actv('Login attempt failed - Wrong captcha');
    echo "Wrong captcha";exit;
}

if($vPassword <> $vPassword_md5 && $vPassword <> '' && !isset($_REQUEST["recova"]))
{
    log_actv('Login attempt failed - Invalid password');
    echo "Invalid password".$attempt_msg;exit;
}

log_actv('Login');
echo create_session(); exit;


function get_s_pp_pix()
{
	$mysqli = link_connect_db();
	$vmask = '';
	$cFacultyId = '';

    $stmt = $mysqli->prepare("SELECT cFacultyId FROM s_m_t WHERE vMatricNo = ?");		
    $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
    $stmt->execute();
    $stmt->store_result();		
    $stmt->bind_result($cFacultyId);
    $stmt->fetch();
    $record_f = $stmt->num_rows;
    
    if ($record_f == 0)
    {
        $stmt->close();
        return '';
    }
    $cFacultyId = $cFacultyId ?? '';

    if ($cFacultyId == 'DEG')
    {
        $stmt->close();
        return '';
    }

    $stmt = $mysqli->prepare("SELECT a.vApplicationNo, trim(vmask) FROM pics a, afnmatric b WHERE a.vApplicationNo = b.vApplicationNo AND b.vMatricNo = ? AND cinfo_type = 'p'");
    $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($vApplicationNo, $vmask);
    $stmt->fetch();
    $stmt->close();

    $vApplicationNo = $vApplicationNo ?? '';
    $vmask = $vmask ?? '';

    $pix_file_name_jpg = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".jpg";
	$pix_file_name_jpeg = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".jpeg";
	$pix_file_name_png = BASE_FILE_NAME_FOR_PP.strtolower($cFacultyId)."/pp/p_".$vmask.".png";

	if(!file_exists($pix_file_name_jpg) && !file_exists($pix_file_name_jpeg) && !file_exists($pix_file_name_png))
	{
		return 'Please visit the Academic Registry at  your study centre to upload a valid passport picture of yourself<p>
        Please note:<p>
        <ol>
            <li>The picture should not be more than three months old</li>
            <li>The top of your head, your ears and your chin must be clearly vissible</li>
            <li>Your face must take up at least 80% of the picture</li>
            <li>The background of the picture must be either red or white</li>
        </ol>';
	}else
    {
        return '';
    }
}

function check_dob()
{
	$mysqli = link_connect_db();

    $stmt = $mysqli->prepare("SELECT dBirthDate, cFacultyId FROM s_m_t WHERE vMatricNo = ?");		
    $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($dBirthDate, $cFacultyId);
    $record_f = $stmt->num_rows;
    $stmt->fetch();
    $stmt->close();
    
    if ($record_f == 0)
    {
        return '';
    }

    $cFacultyId = $cFacultyId ?? '';
    if ($cFacultyId == 'DEG')
    {
        return '';
    }
    
    $dBirthDate = $dBirthDate ?? '';

    if (strlen($dBirthDate) == 10 && 
    is_numeric(substr($dBirthDate,0,4)) && 
    is_numeric(substr($dBirthDate,5,2)) && 
    substr($dBirthDate,5,2) <= 12 && 
    is_numeric(substr($dBirthDate,8,2)) && 
    substr($dBirthDate,8,2) <= 31 )
    {
        return '';
    }else
    {
        return 'Please visit the Academic Registry at your study centre with relevant documents to update your date of birth';
    }
}