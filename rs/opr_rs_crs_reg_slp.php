<?php
require_once('../../fsher/fisher.php');
include('const_def.php');
include(BASE_FILE_NAME.'lib_fn.php');

include('std_lib_fn.php');

$mysqli = link_connect_db();

$orgsetins = settns();

$str1 = '';
$count1 = 0;

if (((isset($_REQUEST["conf"]) && $_REQUEST["conf"] == '1') || (isset($_REQUEST["resend_req"]) && $_REQUEST["resend_req"] == '1')) && !isset($_REQUEST["token_supplied"]))
{
    send_token('dropping registered courses');
    echo 'Token sent';
    exit;
}else if (isset($_REQUEST['numOfiputTag']) &&  $_REQUEST['numOfiputTag'] > 0 && isset($_REQUEST["conf"]) && $_REQUEST["conf"] == '1' && isset($_REQUEST["token_supplied"]) && $_REQUEST["token_supplied"] == '1')
{
    $token_status = validate_token('dropping registered courses');
    
    if ($token_status <> 'Token valid')
    {
        echo $token_status;
        exit;
    }
    
    $nxt_sn_for_drop_course = get_nxt_sn_cr ($_REQUEST["vMatricNo"], '', 'Dropped course', $_REQUEST["edu_cat"]);
    $nxt_sn_for_drop_exam = get_nxt_sn_cr ($_REQUEST["vMatricNo"], '', 'Dropped exam', $_REQUEST["edu_cat"]);

    $sql_feet_type = select_fee_srtucture($_REQUEST["vMatricNo"], $_REQUEST["res_ctry"], $_REQUEST["edu_cat"]);
    
    //require_once("std_detail_pg1.php");
    //$sql_feet_type = select_fee_srtucture($_REQUEST["vMatricNo"], $cResidenceCountryId_loc, $cEduCtgId_loc);    
    
    $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
    FROM s_f_s a, fee_items b
    WHERE a.fee_item_id = b.fee_item_id
    AND fee_item_desc = 'Examination Registration'
    AND cEduCtgId = ?
    $sql_feet_type");
    $stmt_amount->bind_param("s", $_REQUEST["edu_cat"]);
    $stmt_amount->execute();
    $stmt_amount->store_result();
    $stmt_amount->bind_result($Amount, $itemid);
    $stmt_amount->fetch();
    $stmt_amount->close();

    try
    {
        $mysqli->autocommit(FALSE); //turn on transactions

        for ($j = 1; $j <= 2; $j++)
        {
            if ($j == 2 && $str1 <> '')
            {
                if ($count1 > 1)
                {
                    echo 'Please return course material for: '.substr($str1,0,strlen($str1)-10).' and '.substr($str1,strlen($str1)-8,6).' to the store'; exit;
                }else if ($str1 <> '')
                {
                    echo 'Please return course material for: '.substr($str1,0,strlen($str1)-2).' to the store'; exit;
                }
            }else
            {
                $delete_from_coursreg_arch = $mysqli->prepare("delete from coursereg_arch_20242025 
                where vMatricNo = ? and
                siLevel = ? and
                tSemester = ? and
                cAcademicDesc = ? and
                cCourseId = ?");
                
                /*$delete_from_coursreg = $mysqli->prepare("delete from coursereg 
                where vMatricNo = ? and
                siLevel = ? and
                tSemester = ? and
                cAcademicDesc = ? and
                cCourseId = ?");*/
                
                $delete_from_examreg = $mysqli->prepare("delete from examreg_20242025 
                where vMatricNo = ? and
                siLevel = ? and
                tSemester = ? and
                cAcademicDesc = ? and
                cCourseId = ?");
				
                $fee_item_id = get_fee_item_id('Course Registration');
                if ($fee_item_id == '')
                {
                    echo 'Fee item not defined';exit;
                }
							
                date_default_timezone_set('Africa/Lagos');
                $date2 = date("Y-m-d h:i:s");

                $reverse_coursereg_saction = $mysqli->prepare("REPLACE INTO s_tranxion_cr 
                (vMatricNo, cCourseId, tdate, cTrntype, iItemID, amount, tSemester, cAcademicDesc, siLevel, trans_count, fee_item_id, vremark)
                VALUE (?, ?, '$date2', 'c', ?, ?, ?, ?, ?, $nxt_sn_for_drop_course, $fee_item_id, 'Dropped course')");

				
                $fee_item_id = get_fee_item_id('Examination Registration');
                if ($fee_item_id == '' && !(isset($_REQUEST["cProgrammeId"]) && (!is_bool(strpos($_REQUEST["cProgrammeId"], "CHD")) || !is_bool(strpos($_REQUEST["cProgrammeId"], "DEG")))))
                {
                    echo 'Fee item not defined';exit;
                }

                $reverse_examreg_saction = $mysqli->prepare("REPLACE INTO s_tranxion_cr 
                (vMatricNo, cCourseId, tdate, cTrntype, iItemID, amount, tSemester, cAcademicDesc, siLevel, trans_count, fee_item_id, vremark)
                values (?, ?, '$date2', 'c', ?, ?, ?, ?, ?, $nxt_sn_for_drop_exam, $fee_item_id, 'Dropped exam')");
            }

            for ($i = 1; $i <= $_REQUEST['numOfiputTag']; $i++)
            {
                if (isset($_REQUEST["regCourses$i"]))
                {
                    if ($j == 1)
                    {
                        //check if course mat was give and has been returned
                        if ($orgsetins['uni_give_mat'] == '1')
                        {
                            $stmt = $mysqli->prepare("SELECT * FROM coursereg_arch 
                            WHERE vMatricNo = ? 
                            AND siLevel = ? 
                            AND tSemester = ?
                            AND cCourseId = ? 
                            AND c_mat = '1'");
                            $stmt->bind_param("siis", $_REQUEST["vMatricNo"], $_REQUEST["iStudy_level"], $_REQUEST["tSemester"], $_REQUEST["regCourses$i"]);
                            $stmt->execute();
                            $stmt->store_result();
                            if ($stmt->num_rows > 0){$str1 = $str1 .  $_REQUEST["regCourses$i"].', '; $count1++;}
                        }
                    }else
                    {
                        //drop from archive							
                        $delete_from_coursreg_arch->bind_param("siiss", $_REQUEST['vMatricNo'], $_REQUEST['iStudy_level'], $_REQUEST['tSemester'], $_REQUEST['AcademicDesc'], $_REQUEST["regCourses$i"]);
                        $delete_from_coursreg_arch->execute();
                        log_actv('dropped course '.$_REQUEST["regCourses$i"].' in '.$_REQUEST["AcademicDesc"].', '.$_REQUEST["iStudy_level"].', '.$_REQUEST["tSemester"].' semester');
                        
                        //drop from coursereg
                        /*$delete_from_coursreg->bind_param("siiss", $_REQUEST['vMatricNo'], $_REQUEST['iStudy_level'], $_REQUEST['tSemester'], $_REQUEST['AcademicDesc'], $_REQUEST["regCourses$i"]);
                        $delete_from_coursreg->execute();*/
                        log_actv('dropped course '.$_REQUEST["regCourses$i"].' in '.$_REQUEST["AcademicDesc"].', '.$_REQUEST["iStudy_level"].', '.$_REQUEST["tSemester"].' semester');

                        if ($delete_from_coursreg_arch->affected_rows > 0)
                        {
                            //reverse s_tranxion table entries
                            $reverse_coursereg_saction->bind_param("sssiisi", $_REQUEST['vMatricNo'], $_REQUEST["regCourses$i"], $_REQUEST["itemid$i"],  $_REQUEST["amount$i"], $_REQUEST['tSemester'], $_REQUEST['AcademicDesc'], $_REQUEST['iStudy_level']);
                            $reverse_coursereg_saction->execute();

                            // drop from examreg					
                            $delete_from_examreg->bind_param("siiss", $_REQUEST['vMatricNo'], $_REQUEST['iStudy_level'], $_REQUEST['tSemester'], $_REQUEST['AcademicDesc'], $_REQUEST["regCourses$i"]);
                            $delete_from_examreg->execute();
                            log_actv('dropped exam '.$_REQUEST["regCourses$i"].' in '.$_REQUEST["AcademicDesc"].', '.$_REQUEST["iStudy_level"].', '.$_REQUEST["tSemester"].' semester');
                            
                            if ($delete_from_examreg->affected_rows > 0 && !(isset($_REQUEST["cProgrammeId"]) && (!is_bool(strpos($_REQUEST["cProgrammeId"], "CHD")) || !is_bool(strpos($_REQUEST["cProgrammeId"], "DEG")))))
                            {
                                //reverse s_tranxion table entries
                                $reverse_examreg_saction->bind_param("sssdisi", $_REQUEST['vMatricNo'], $_REQUEST["regCourses$i"], $itemid, $Amount, $_REQUEST['tSemester'], $_REQUEST['AcademicDesc'], $_REQUEST['iStudy_level']);
                                $reverse_examreg_saction->execute();
                            }
                        }
                        $count1++;
                    }
                }
            }
        }			
        
        if (get_active_request(2) == 1)
        {
            $stmt = $mysqli->prepare("UPDATE vc_request 
            SET used = '1'
            WHERE vMatricNo = ?
            AND cdel = 'N'
            ORDER BY time_act DESC LIMIT 1");
            $stmt->bind_param("s", $_REQUEST["vMatricNo"]); 
            $stmt->execute();
            $stmt->close();

            log_actv('Used drop course request');
        }

        $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
        
        //$delete_from_coursreg->close();
        $delete_from_examreg->close();
        $reverse_coursereg_saction->close();
        $reverse_examreg_saction->close();

        echo $count1.' course(s) successfully dropped';exit;
    }catch(Exception $e)
    {
        $mysqli->rollback(); //remove all queries from queue if error (undo)
        throw $e;
    }
}?>