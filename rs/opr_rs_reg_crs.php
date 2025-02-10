<?php
require_once('../../fsher/fisher.php');
include('const_def.php');
include(BASE_FILE_NAME.'lib_fn.php');

include('std_lib_fn.php');

$orgsetins = settns();

$mysqli = link_connect_db();

if (!isset($_REQUEST["numofreg"]))
{
    exit;
}

$stmt = $mysqli->prepare("SELECT max_crload, a.cProgrammeId, cFacultyId
FROM programme a, s_m_t b
WHERE a.cProgrammeId = b.cProgrammeId
AND b.vMatricNo = ?");
$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($max_crload, $cProgrammeId, $cFacultyId);
$stmt->fetch();

if (is_null($max_crload))
{
    $max_crload = 0;
}

if (is_null($cProgrammeId))
{
    $cProgrammeId = '';
}

if ($cProgrammeId == '')
{
    echo 'Unknown programme'; exit;
}

if ($cFacultyId <> 'CHD' && $cFacultyId <> 'DEG' && $max_crload < 24)
{
    echo 'Maximum credit load not valid'; exit;
}

// if ($cProgrammeId <> 'CHD001' && $max_crload < 24)
// {
//     echo 'Maximum credit load not valid'; exit;
// }


$semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);

$stmt = $mysqli->prepare("SELECT SUM(iCreditUnit) FROM coursereg_arch_20242025
WHERE tdate >= '$semester_begin_date'
AND vMatricNo = ?");
$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($carried_crload);
$stmt->fetch();

if (is_null($carried_crload))
{
    $carried_crload = 0;
}


$stmt = $mysqli->prepare("SELECT SUM(iCreditUnit) FROM examreg_20242025 a, courses_new b 
WHERE a.cCourseId = b.cCourseId 
AND tdate >= '$semester_begin_date'
AND vMatricNo = ?");
$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($exam_carried_crload);
$stmt->fetch();

if (is_null($exam_carried_crload))
{
    $exam_carried_crload = 0;
}


    
$totalCreditToRegister = 0;
for ($k = 1; $k <= $_REQUEST["numofreg"]; $k++)
{
    if (isset($_REQUEST["regCourses$k"]))
    //if (isset($_REQUEST["regCourses$k"])&& is_numeric($_REQUEST["credUniInput$k"]) && $_REQUEST["credUniInput$k"] > 0)
    {					
        $stmt_credunit = $mysqli->prepare("SELECT iCreditUnit FROM courses_new WHERE cCourseId = ?");
        $stmt_credunit->bind_param("i", $_REQUEST["regCourses$k"]);
        $stmt_credunit->execute();
        $stmt_credunit->store_result();
        $stmt_credunit->bind_result($credunit);
        $stmt_credunit->fetch();
        
        $totalCreditToRegister += $credunit;
        //$totalCreditToRegister += $_REQUEST["credUniInput$k"];
    }
}

if ($_REQUEST["cProgramme"] == 'LAW301' || $_REQUEST["cProgramme"] == 'LAW401')
{
    if (($carried_crload + $totalCreditToRegister) > 29)
    {
        echo 'Maximum credit load exceeded';
        exit;
    }
}else
{
    if (($carried_crload + $totalCreditToRegister) > 24)
    {
        echo 'Maximum credit load exceeded';
        exit;
    }
}



// if ($_REQUEST["total_unit_carried"] > $_REQUEST["max_crload"])
// {
//     echo $_REQUEST["carried_crload"].' credit units already registered for the semester<br> Addition of '.$_REQUEST["totCredUnit"].' units exceeds '.$_REQUEST["max_crload"].' maximum credit unit load for the smester.';
//     exit;
// }

if (((isset($_REQUEST["conf"]) && $_REQUEST["conf"] == '1') || (isset($_REQUEST["resend_req"]) && $_REQUEST["resend_req"] == '1')) && !isset($_REQUEST["token_supplied"]))
{
    send_token('registering course');
    echo 'Token sent';
    exit;
}else if (isset($_REQUEST['numofreg']) &&  $_REQUEST['numofreg'] > 0 && isset($_REQUEST["conf"]) && $_REQUEST["conf"] == '1' && isset($_REQUEST["token_supplied"]) && $_REQUEST["token_supplied"] == '1')
{
    $token_status = validate_token('registering course');
    
    if ($token_status <> 'Token valid')
    {
        echo $token_status;
        exit;
    }
    
    
    // $totalCreditToRegister = 0;
    // for ($k = 1; $k <= $_REQUEST["numofreg"]; $k++)
    // {
    //     if (isset($_REQUEST["regCourses$k"]))
    //     {					
    //         $totalCreditToRegister += $_REQUEST["credUniInput$k"];
    //     }
    // }

    // if ($_REQUEST["cProgramme"] == 'LAW301' || $_REQUEST["cProgramme"] == 'LAW401')
    // {
    //     if ($totalCreditToRegister > 29)
    //     {
    //         echo 'Credit load exceeded';
    //         exit;
    //     }
    // }else
    // {
    //     if ($totalCreditToRegister > 24)
    //     {
    //         echo 'Credit load exceeded';
    //         exit;
    //     }
    // }

    
    
    date_default_timezone_set('Africa/Lagos');
    $date2 = date("Y-m-d h:i:s");

    /*try
    {
        $mysqli->autocommit(FALSE); //turn on transactions*/
                
        $stmt_exam_reg = $mysqli->prepare("REPLACE INTO examreg_20242025 
        (vMatricNo, cCourseId, tSemester, siLevel, cAcademicDesc, tdate)
        values (?, ?, ?, ?, ?, '$date2')");
        
        
        $nxt_sn = get_nxt_sn ($_REQUEST["vMatricNo"], '', 'Course Registration', $_REQUEST["cEduCtgId"]);
        
        if (isset($_REQUEST["cProgrammeId"]) && !is_bool(strpos($_REQUEST["cProgrammeId"], "DEG")))
        {
            $deg_cond = '';
            if ($_REQUEST["deg_appl_cat"] == '1')
            {
                $deg_cond = " AND fee_item_desc LIKE '%NOUN Incubatee'";
            }else if ($_REQUEST["deg_appl_cat"] == '2')
            {
                $deg_cond = " AND fee_item_desc LIKE '%Staff/Alumni'";
            }else if ($_REQUEST["deg_appl_cat"] == '3')
            {
                $deg_cond = " AND fee_item_desc LIKE '%Public'";
            }
            
            $fee_item_id = get_fee_item_id_deg($deg_cond);
        }else
        {
            $fee_item_id = get_fee_item_id('Course Registration');
            if ($fee_item_id == '')
            {
                echo 'Fee item not defined';exit;
            }
        }
        
        // $stmt2 = $mysqli->prepare("REPLACE INTO s_tranxion_20242025 
        // (vMatricNo, cCourseId, tdate, cTrntype, iItemID, amount, tSemester, cAcademicDesc, siLevel, trans_count, fee_item_id, vremark)
        // values (?, ?, '$date2', 'd', ?, ?, ?, ?, ?, $nxt_sn, $fee_item_id, 'Course Registration')");

        $stmt_arch = $mysqli->prepare("REPLACE INTO coursereg_arch_20242025 (vMatricNo, cCourseId, tSemester, siLevel, cAcademicDesc, tdate, iCreditUnit, vCourseDesc, cCategory, ancilary_type)
        values (?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)");

        $cnt = 0;
        for ($k = 1; $k <= $_REQUEST["numofreg"]; $k++)
        {
            if (isset($_REQUEST["regCourses$k"]) && strlen(trim($_REQUEST["regCourses$k"])) == 6 && ($_REQUEST["regCourses$k"] == 'DES303' || (is_numeric($_REQUEST["credUniInput$k"]) && $_REQUEST["credUniInput$k"] > 0)))
            //if (isset($_REQUEST["regCourses$k"]) && is_numeric($_REQUEST["itemid$k"]))
            {
                $stmt_credunit = $mysqli->prepare("SELECT iCreditUnit FROM courses_new WHERE cCourseId = ?");
                $stmt_credunit->bind_param("s", $_REQUEST["regCourses$k"]);
                $stmt_credunit->execute();
                $stmt_credunit->store_result();
                $stmt_credunit->bind_result($credunit);
                $stmt_credunit->fetch();
                
                if ($cProgrammeId == 'LAW301' || $cProgrammeId == 'LAW401')
                {
                    if (($carried_crload + $credunit) > 29)
                    {
                        break;
                    }
                }else
                {
                    if (($carried_crload + $credunit) > 24)
                    {
                        break;
                    }
                }
                
                /* if ($cProgrammeId == 'LAW301' || $cProgrammeId == 'LAW401')
                {
                    if (($carried_crload + $_REQUEST["credUniInput$k"]) > 29)
                    {
                        break;
                    }
                }else
                {
                    if (($carried_crload + $_REQUEST["credUniInput$k"]) > 24)
                    {
                        break;
                    }
                }*/

                //if its a cert prog or course is anxiliary
                if (($_REQUEST["ancilary_type$k"] <> 'normal' && $_REQUEST["ancilary_type$k"] <> 'Laboratory') || (isset($_REQUEST["cProgrammeId"]) && (!is_bool(strpos($_REQUEST["cProgrammeId"], "CHD")) || !is_bool(strpos($_REQUEST["cProgrammeId"], "DEG")))))
                {
                    if ((($cProgrammeId == 'LAW301' || $cProgrammeId == 'LAW401') && ($exam_carried_crload + $credunit) <= 29) ||
                    (($exam_carried_crload + $credunit) <= 24))
                    {
                        $stmt_exam_reg->bind_param("ssiis", $_REQUEST["vMatricNo"], $_REQUEST["regCourses$k"], $_REQUEST["tSemester_loc"], $_REQUEST["iStudy_level"], $_REQUEST["AcademicDesc"]);
                        $stmt_exam_reg->execute();

                        $exam_carried_crload += $credunit;
                    }else
                    {
                        break;
                    }
                }

                if (!(isset($_REQUEST["cProgrammeId"]) && (!is_bool(strpos($_REQUEST["cProgrammeId"], "CHD")) || !is_bool(strpos($_REQUEST["cProgrammeId"], "DEG")))))
                {
                    $remark = 'Course Registration';
                    if ($_REQUEST["amount$k"] >= 25000)
                    {
                        $remark = 'Project';
                    }

                    $stmt2 = $mysqli->prepare("REPLACE INTO s_tranxion_20242025 
                    (vMatricNo, cCourseId, tdate, cTrntype, iItemID, amount, tSemester, cAcademicDesc, siLevel, trans_count, fee_item_id, vremark)
                    values (?, ?, '$date2', 'd', ?, ?, ?, ?, ?, $nxt_sn, $fee_item_id, '$remark')");
                    
                    $stmt2->bind_param("sssiisi", $_REQUEST["vMatricNo"], $_REQUEST["regCourses$k"], $_REQUEST["itemid$k"], $_REQUEST["amount$k"], $_REQUEST["tSemester_loc"], $_REQUEST["AcademicDesc"], $_REQUEST["iStudy_level"]);
                    $stmt2->execute();
                }
                
                //$stmt_arch = $mysqli->prepare("REPLACE INTO coursereg_arch_20242025 (vMatricNo, cCourseId, tSemester, siLevel, cAcademicDesc, tdate, iCreditUnit, vCourseDesc, cCategory, ancilary_type) values (?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)");
                
                //echo $_REQUEST["vMatricNo"].','.$_REQUEST["regCourses$k"].','.$_REQUEST["tSemester_loc"].','.$_REQUEST["iStudy_level"].','.$_REQUEST["AcademicDesc"].','.$credunit.','.$_REQUEST["vCourseDesc$k"].','.$_REQUEST["cCategoryInput$k"].','.$_REQUEST["ancilary_type$k"];

                $stmt_arch->bind_param("ssiisisss", $_REQUEST["vMatricNo"], $_REQUEST["regCourses$k"], $_REQUEST["tSemester_loc"], $_REQUEST["iStudy_level"], $_REQUEST["AcademicDesc"], $credunit, $_REQUEST["vCourseDesc$k"], $_REQUEST["cCategoryInput$k"], $_REQUEST["ancilary_type$k"]);

                //$stmt_arch->bind_param("ssiisisss", $_REQUEST["vMatricNo"], $_REQUEST["regCourses$k"], $_REQUEST["tSemester_loc"], $_REQUEST["iStudy_level"], $_REQUEST["AcademicDesc"], $_REQUEST["credUniInput$k"], $_REQUEST["vCourseDesc$k"], $_REQUEST["cCategoryInput$k"], $_REQUEST["ancilary_type$k"]);
                $stmt_arch->execute();
        
                log_actv('registered '.$_REQUEST["regCourses$k"].' in '.$_REQUEST["AcademicDesc"].', '.$_REQUEST["iStudy_level"].', '.$_REQUEST["tSemester_loc"].' semester');
                
                $carried_crload += $credunit;
                //$carried_crload += $_REQUEST["credUniInput$k"];

                $cnt++;
            }
        }
        //$stmt1->close();

        if (isset($stmt2))
        {
            $stmt2->close();
        }
        if (isset($stmt_arch))
        {
            $stmt_arch->close();
        }

        $stmt_credunit->close();
        
        if (get_active_request(1) == 1)
        {
            $stmt = $mysqli->prepare("UPDATE vc_request 
            SET used = '1'
            WHERE vMatricNo = ?
            AND cdel = 'N'
            ORDER BY time_act DESC LIMIT 1");
            $stmt->bind_param("s", $_REQUEST["vMatricNo"]); 
            $stmt->execute();
            $stmt->close();

            log_actv('Used course registration request');
        }

        echo $cnt.' course(s) successfully registered,'.$carried_crload;
        
    /*    $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
    }catch(Exception $e) 
    {
        $mysqli->rollback(); //remove all queries from queue if error (undo)
        throw $e;
    }*/
}?>