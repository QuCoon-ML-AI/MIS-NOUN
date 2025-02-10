<?php
require_once('../../fsher/fisher.php');

require_once('const_def.php');
require_once(BASE_FILE_NAME.'lib_fn.php');
require_once(BASE_FILE_NAME.'lib_fn_2.php');

$mysqli = link_connect_db();

echo validate_token($_REQUEST['vMatricNo'],'password recovery');

