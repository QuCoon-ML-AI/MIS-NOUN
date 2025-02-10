<?php
require_once('../../fsher/fisher.php');

include('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$mysqli = link_connect_db();

echo validate_token($_REQUEST['vApplicationNo'], 'password recovery');