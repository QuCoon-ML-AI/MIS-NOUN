<?php

require_once('../../fsher/fisher.php');
include('const_def.php');
include(BASE_FILE_NAME.'lib_fn.php');

$mysqli = link_connect_db();

$stmt = $mysqli->prepare("INSERT IGNORE INTO s_bank_d SET
vMatricNo = ?,
bank_id = ?,
acn_name = ?,
acn_no = ?");
$stmt->bind_param("ssss",$_REQUEST['vMatricNo'], $_REQUEST['bank_id'], $_REQUEST['b_account_name'], $_REQUEST['b_account_no']);
$stmt->execute();

if ($stmt->affected_rows == 0)
{
    $stmt->close();

    $stmt = $mysqli->prepare("UPDATE IGNORE s_bank_d SET
    bank_id = ?,
    acn_name = ?,
    acn_no = ?
    WHERE vMatricNo = ?");
    $stmt->bind_param("ssss", $_REQUEST['bank_id'], $_REQUEST['b_account_name'], $_REQUEST['b_account_no'], $_REQUEST['vMatricNo']);
    $stmt->execute();
    
    if ($stmt->affected_rows == 0)
    {
        $stmt->close();
        echo 'No changes';
        exit;
    }
}


$stmt->close();
echo 'Success';
exit;
?>