<?php
require_once('../../fsher/fisher.php');
require_once('lib_fn.php');
require_once('lib_fn_2.php');

$mysqli = link_connect_db();

$token_status = validate_token($_REQUEST['vApplicationNo'], 'password recovery');

if ($token_status == 'Invalid token')
{
    echo $token_status;
    exit;
}

