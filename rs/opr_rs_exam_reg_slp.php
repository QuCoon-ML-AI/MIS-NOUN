<?php
require_once('../../fsher/fisher.php');
include('const_def.php');
include(BASE_FILE_NAME.'lib_fn.php');

include('std_lib_fn.php');

$mysqli = link_connect_db();

$orgsetins = settns();

$count1 = 0;

if (((isset($_REQUEST["conf"]) && $_REQUEST["conf"] == '1') || (isset($_REQUEST["resend_req"]) && $_REQUEST["resend_req"] == '1')) && !isset($_REQUEST["token_supplied"]))
{
    send_token('dropping exam registration');
    echo 'Token sent';
    exit;
}else if (isset($_REQUEST['numOfiputTag']) &&  $_REQUEST['numOfiputTag'] > 0 && isset($_REQUEST["conf"]) && $_REQUEST["conf"] == '1' && isset($_REQUEST["token_supplied"]) && $_REQUEST["token_supplied"] == '1')
{
    $token_status = validate_token('dropping exam registration');
    
    if ($token_status <> 'Token valid')
    {
        echo $token_status;
        exit;
    }

    $fee_item_id = get_fee_item_id('Examination Registration');
    if ($fee_item_id == '')
    {
        echo 'Fee item not defined';exit;
    }
    
    //try
    //{
        //$mysqli->autocommit(FALSE); //turn on transactions
        
        $semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);

        //not exam to drop
        $note_exam_drop = $mysqli->prepare("INSERT IGNORE INTO examreg_drop SELECT * FROM examreg_20242025  WHERE vMatricNo = ?
        AND siLevel = ?
        AND tSemester = ?
        AND cAcademicDesc = ?
        AND cCourseId = ?");

        //drop exam
        $delete_from_examreg = $mysqli->prepare("DELETE FROM examreg_20242025 
        WHERE vMatricNo = ?
        AND siLevel = ?
        AND tSemester = ?
        AND cAcademicDesc = ?
        AND cCourseId = ?");

        //return money
        $delete_from_debit = $mysqli->prepare("DELETE FROM s_tranxion_20242025 
        WHERE vMatricNo = ?
        AND siLevel = ?
        AND tSemester = ?
        AND cAcademicDesc = ?
        AND cCourseId = ?
        AND fee_item_id  = 8");

        for ($i = 1; $i <= $_REQUEST['numOfiputTag']; $i++)
        {
            if (isset($_REQUEST["regCourses$i"]))
            {
                //drop exam
                $delete_from_examreg->bind_param("siiss", $_REQUEST['vMatricNo'], $_REQUEST['iStudy_level'], $_REQUEST['tSemester'], $_REQUEST['AcademicDesc'], $_REQUEST["regCourses$i"]);
                $delete_from_examreg->execute();
                
                
                if ($delete_from_examreg->affected_rows > 0)
                {
                    //not exam to drop
                    $note_exam_drop->bind_param("ssiis", $_REQUEST["vMatricNo"], $_REQUEST["iStudy_level"], $_REQUEST["tSemester"], $_REQUEST["AcademicDesc"],$_REQUEST["regCourses$i"]);
                    $note_exam_drop->execute();

                    //return money
                    $delete_from_debit->bind_param("siiss", $_REQUEST['vMatricNo'], $_REQUEST['iStudy_level'], $_REQUEST['tSemester'], $_REQUEST['AcademicDesc'], $_REQUEST["regCourses$i"]);
                    $delete_from_debit->execute();
                
                    log_actv('dropped exam '.$_REQUEST["regCourses$i"].' in '.$_REQUEST["AcademicDesc"].', '.$_REQUEST["iStudy_level"].', '.$_REQUEST["tSemester"].' semester');
                }

                $count1++;
            }
        }
        
        //$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
        
        $note_exam_drop->close();
        $delete_from_examreg->close();
        $delete_from_debit->close();
        
        if (get_active_request(5) == 1)
        {
            $stmt = $mysqli->prepare("UPDATE vc_request 
            SET used = '1'
            WHERE vMatricNo = ?
            AND cdel = 'N'
            ORDER BY time_act DESC LIMIT 1");
            $stmt->bind_param("s", $_REQUEST["vMatricNo"]); 
            $stmt->execute();
            $stmt->close();

            log_actv('Used drop exam request');
        }

        echo $count1.' course(s) successfully dropped for exam';exit;
        
    /*}catch(Exception $e)
    {
        $mysqli->rollback(); //remove all queries from queue if error (undo)
        throw $e;
    }*/
}?>