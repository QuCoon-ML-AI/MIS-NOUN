<?php

//include('../appl/const_def.php');
require_once('../../fsher/fisher.php');

include('../appl/lib_fn.php');
include('../appl/lib_fn_2.php');


if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST["vApplicationNo"] <> '')
{
    $user_name = $_REQUEST["vApplicationNo"];
}else if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> '')
{
    $user_name = $_REQUEST["vMatricNo"];
}else
{
    echo 'User not defined';
    exit;
}

echo validate_token($user_name,'not defined');

?>