<?php

require_once('../../fsher/fisher.php');
include('const_def.php');
include(BASE_FILE_NAME.'lib_fn.php');
include(BASE_FILE_NAME.'lib_fn_2.php');

$mysqli = link_connect_db();

//if (isset($_REQUEST["token_req"]))
if (isset($_REQUEST["ilin"]) && isset($_REQUEST["vMatricNo"]) && isset($_REQUEST["course_ccount"]))
{
    /*if ($_REQUEST["token_req"] == '0')
    {
        send_token('choosing centre of practicals');
        echo 'Token sent';
        exit;
    }else if ($_REQUEST["token_req"] == '1')
    {
        $valid_state = validate_token($_REQUEST['vMatricNo'], 'choosing centre of practicals');
        
        if ($valid_state <> 'Token valid')
        {
            echo $valid_state;
            exit;
        }*/

        
        $stmt = $mysqli->prepare("DELETE FROM pract_centre 
        WHERE acadsession = ? 
        AND tsemester = ?
        AND vMatricNo = ?");
        $stmt->bind_param("sss", $_REQUEST['cAcademicDesc'], $_REQUEST['tSemester'], $_REQUEST['vMatricNo']);
        $stmt->execute();

        $stmt = $mysqli->prepare("INSERT IGNORE INTO pract_centre 
        SET vMatricNo = ?,
        cCourseId = ?,
        cCentreId = ?,
        acadsession = ?,
        tsemester = ?,
        cwindow = ?");

        for ($i = 1; $i <= $_REQUEST["course_ccount"]; $i++)
        {
            for ($j = 1; $j <= 5; $j++)
            {
                $elem_name = 'row'.$i.'col'.$j;
                if (isset($_REQUEST[$elem_name]))
                {
                    $coursecode = substr($_REQUEST[$elem_name], 0, 6);
                    $window = substr($_REQUEST[$elem_name], 6, 1);
                    
                    //echo $_REQUEST[$elem_name].'='.$coursecode.','.$window.'<br>';
                    
                    $stmt->bind_param("ssssss", $_REQUEST['vMatricNo'], $coursecode, $_REQUEST['p_study_center'], $_REQUEST['cAcademicDesc'], $_REQUEST['tSemester'], $window);
                    $stmt->execute();
                    log_actv('Registered '.$coursecode.' for practicals at '.$_REQUEST['p_study_center']);
                }
            }
        }
        $stmt->close();
                
        //log_actv('Changed password for ');
        echo 'Success';
        exit;
    //}
}
?>