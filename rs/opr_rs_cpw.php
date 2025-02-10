<?php

require_once('../../fsher/fisher.php');
include('const_def.php');
include(BASE_FILE_NAME.'lib_fn.php');
include(BASE_FILE_NAME.'lib_fn_2.php');

$mysqli = link_connect_db();

$stmt = $mysqli->prepare("SELECT vPassword, md5(?) vfPassword FROM rs_client where vMatricNo = ?");
$stmt->bind_param("ss", $_REQUEST["vfPassword"], $_REQUEST['vMatricNo']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($vPassword, $vfPassword);

$stmt->fetch();
$stmt->close();

if (isset($vPassword) && $vPassword <> $vfPassword)
{
    echo "Invalid old password";exit;
}

if (isset($_REQUEST["token_req"]))
{
    if ($_REQUEST["token_req"] == '0')
    {
        send_token('change of password');
        echo 'Token sent';
        exit;
    }else if ($_REQUEST["token_req"] == '1')
    {
        $valid_state = validate_token($_REQUEST['vMatricNo'], 'password recovery');
        
        if ($valid_state <> 'Token valid')
        {
            echo $valid_state;
            exit;
        }
        
        $stmt = $mysqli->prepare("UPDATE rs_client SET
        vPassword = md5(?),
        cpwd = '1'
        WHERE vMatricNo = ?");
        $stmt->bind_param("ss",$_REQUEST['vPassword'], $_REQUEST['vMatricNo']);
        $stmt->execute();
        $stmt->close();
                
        log_actv('Changed password for ');		
        echo 'Success';
        exit;
    }
}
?>