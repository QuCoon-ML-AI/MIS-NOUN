<?php 
require_once('../../fsher/fisher.php');
include('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');


if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> '')
{
	send_token('confirmation of payment','0');

	echo 'token:';exit;
}?>