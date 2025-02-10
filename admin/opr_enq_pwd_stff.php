<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$orgsetins = settns();

$staff_study_center = '';
if (isset($_REQUEST['user_centre']) && $_REQUEST['user_centre'] <> '')
{
	$staff_study_center = $_REQUEST['user_centre'];
}

if (isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1' && isset($_REQUEST['currency_cf']) && $_REQUEST['currency_cf'] == '1')
{
	$vPasswordp_01 = '';
    
    $stmt = $mysqli->prepare("select vPasswordp from userlogin
    where vApplicationNo = ?");
    $stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows === 0)
    {	
        $stmt->close();
        echo 'User name not found';exit;
    }else
    {
        
        $stmt->bind_result($vPasswordp_01);
        $stmt->fetch();
        $stmt->close();
    }
    
    if ($_REQUEST['sm'] == '3')
    {
        $stmt = $mysqli->prepare("UPDATE userlogin SET vPassword = md5(?), cpwd = '1' WHERE vApplicationNo = ?");
        $stmt->bind_param("ss", $_REQUEST["uvApplicationNo"], $_REQUEST["uvApplicationNo"]);
        $stmt->execute();
        $stmt->close();
        
        log_actv('User, '.$_REQUEST["uvApplicationNo"].' password reset');
        echo 'User password reset successful';
    }else if ($_REQUEST['sm'] == '4')
    {
        //echo $vPasswordp_01;exit;
        echo 'Facility stepped down';exit;
    }
}?>