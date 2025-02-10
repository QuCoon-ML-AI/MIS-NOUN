<?php
include('lib_fn.php');
include('lib_fn_2.php');
require_once('../../fsher/fisher.php');

$mysqli = link_connect_db();

if (valid_afn() == '0')
{
    log_actv('Login attempt failed - Invalid AFN');
   echo 'Invalid Application form number'; exit;
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


//has mat. no for candidate logged in?
$stmt = $mysqli->prepare("SELECT * FROM afnmatric a, atv_log b WHERE a.vMatricNo = b.vApplicationNo AND a.vApplicationNo = ? AND vDeed = 'Login'");
$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
$stmt->execute();
$stmt->store_result();
$logins = $stmt->num_rows;

$stmt = $mysqli->prepare("SELECT * FROM prog_choice WHERE vApplicationNo = ? AND cSbmtd = '2'");
$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
$stmt->execute();
$stmt->store_result();
$verified = $stmt->num_rows;

if ($logins > 0 || $verified > 0)
{
    $stmt->close();
    log_actv('Login attempt failed - Form is already submitted');
    //echo 'You have logged in with your matriculation number.<p> Please access your form via Registry (top) => See application reocrd (left) on your (student) home page';exit;
    echo 'Form not available<p> Please access your form via Registry (top) => See application reocrd (left) on your (student) home page';exit;
}

//is applicant blocked from reg?
$stmt = $mysqli->prepare("SELECT cblk, rect_risn, rect_risn1, act_date FROM rectional WHERE vMatricNo = ? AND regist = '1' ORDER BY act_date desc limit 1");
$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($cblk, $rect_risn, $rect_risn1, $act_date);
$stmt->fetch();
$stmt->close();

$cblk = $cblk ?? '';

if ($cblk == '1')
{
    log_actv('Login attempt failed - Applicant is blocked');
    echo 'Access to application form blocked on '.formatdate($act_date,'fromdb').' at the Registry. Reason: '.$rect_risn.' '.$rect_risn1; exit;
}

//is applicant blocked from sc?
$stmt = $mysqli->prepare("SELECT cblk, rect_risn, rect_risn1, act_date FROM rectional WHERE vMatricNo = ? AND stdycentre = '1' ORDER BY act_date desc limit 1");
$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($cblk, $rect_risn, $rect_risn1, $act_date);
$stmt->fetch();
$stmt->close();

if ($cblk == '1')
{
    log_actv('Login attempt failed - Applicant is blocked');
    echo 'Access to application form blocked on '.formatdate($act_date,'fromdb').' the study centre. Reason: '.$rect_risn.' '.$rect_risn1; exit;
}

//is applicant blocked from mis?
$stmt = $mysqli->prepare("SELECT cblk, rect_risn, rect_risn1, act_date FROM rectional WHERE vMatricNo = ? AND ictech = '1' ORDER BY act_date desc limit 1");
$stmt->bind_param("s", $_REQUEST['vApplicationNo']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($cblk, $rect_risn, $rect_risn1, $act_date);
$stmt->fetch();
$stmt->close();

if ($cblk == '1')
{
    log_actv('Login attempt failed - Applicant is blocked');
    echo 'Access to application form blocked on '.formatdate($act_date,'fromdb').' at MIS. Reason: '.$rect_risn.' '.$rect_risn1; exit;
}


if (isset($_REQUEST["recover_pwd"]) && $_REQUEST["recover_pwd"] == '1')
{
    //send_token('password recovery');

    echo 'can continue';
    exit;
}else
{
    $stmt_a = $mysqli->prepare("SELECT vPassword, md5(?) vPassword_md5, cap_text FROM app_client WHERE vApplicationNo = ?");
    $stmt_a->bind_param("ss", $_REQUEST['vPassword'], $_REQUEST['vApplicationNo']);
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

    log_actv('Logged in');
    echo create_session(); exit;
}