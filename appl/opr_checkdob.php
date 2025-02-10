<?php
require_once('../../fsher/fisher.php');
require_once('lib_fn.php');

if (isset($_REQUEST['save']) && $_REQUEST['save'] == '1')
{
   $mysqli = link_connect_db();
    
    $stmt = $mysqli->prepare("SELECT * FROM prog_choice
    WHERE vLastName = ?
    AND vFirstName = ?
    AND vOtherName = ?
    AND dateofbirth = ?");
    $stmt->bind_param("ssss",
    $_REQUEST["vLastName"], 
    $_REQUEST["vFirstName"], 
    $_REQUEST["vOtherName"],
    $_REQUEST["dBirthDate"]);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows <> 0)
    {
        $stmt->close();
        
        $stmt = $mysqli->prepare("SELECT grad FROM s_m_t
        WHERE vLastName = ?
        AND vFirstName = ?
        AND vOtherName = ?
        AND dBirthDate = ?");
        $stmt->bind_param("ssss",
        $_REQUEST["vLastName"], 
        $_REQUEST["vFirstName"], 
        $_REQUEST["vOtherName"],
        $_REQUEST["dBirthDate"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($grad);
        $stmt->fetch();
        $stmt->close();

        if ($grad == 2)
        {
            echo 0;
        }else
        {
            echo 1;
        }
    }else
    {
        echo $stmt->num_rows;
        $stmt->close();
    }
}?>