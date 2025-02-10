<?php

require_once('../../fsher/fisher.php');
include('const_def.php');
include(BASE_FILE_NAME.'lib_fn.php');
include(BASE_FILE_NAME.'lib_fn_2.php');

if (isset($_REQUEST['vMatricNo']) && $_REQUEST['vMatricNo'] <> '')
{
    $valid_mat_no =  valid_mtn();

    if ($valid_mat_no <> 1)
    {
        echo 'Invalid matriculation number';
        exit;
    }

    if (isset($_REQUEST["rec_pwd"]) && $_REQUEST["rec_pwd"] == '1')
    {
        echo $_REQUEST["rec_pwd"];
        exit;
    }
    
    $vPassword = student_signup();

    if($vPassword <> 'frsh' && $vPassword <> '')
    {
        log_actv('Login attempt failed - attempted to sign up again');
        echo "Already signed up"; exit;
    }

    echo $valid_mat_no;
}?>