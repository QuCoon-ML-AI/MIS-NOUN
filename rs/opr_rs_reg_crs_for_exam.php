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


$stmt = $mysqli->prepare("SELECT max_crload, a.cProgrammeId
FROM programme a, s_m_t b
WHERE a.cProgrammeId = b.cProgrammeId
AND b.vMatricNo = ?");
$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($max_crload, $cProgrammeId);
$stmt->fetch();

// if (is_null($max_crload))
// {
//     $max_crload = 0;
// }

// if ($max_crload < 24)
// {
//     echo 'Maximum credit load not valid'; exit;
// }

// if (is_null($cProgrammeId))
// {
//     $cProgrammeId = '';
// }

// if ($cProgrammeId == '')
// {
//     echo 'Unknown programme'; exit;
// }


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

if ($cProgrammeId <> 'CHD001' && $max_crload < 24)
{
    echo 'Maximum credit load not valid'; exit;
}


$semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);

$stmt = $mysqli->prepare("SELECT SUM(iCreditUnit) FROM examreg_20242025 a, courses_new b 
WHERE a.cCourseId = b.cCourseId 
AND tdate >= '$semester_begin_date'
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
    
    // if (isset($_REQUEST["regCourses$k"])&& is_numeric($_REQUEST["credUniInput$k"]) && $_REQUEST["credUniInput$k"] > 0)
    // {					
    //     $totalCreditToRegister += $_REQUEST["credUniInput$k"];
    // }
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

// if ($cProgrammeId == 'LAW301' || $cProgrammeId == 'LAW401')
// {
//     if ($carried_crload > 29)
//     {
//         echo 'Maximum credit load exceeded';
//         exit;
//     }
// }else
// {
//     if ($carried_crload > 24)
//     {
//         echo 'Maximum credit load exceeded';
//         exit;
//     }
// }


// if ($carried_crload > 0)
// {
//     echo 'Maximum credit load exceeded'; exit;
// }

// if (($_REQUEST["totCredUnit"] + $carried_crload) > $max_crload)
// {
//     if ($carried_crload > 0)
//     {
//         echo $carried_crload.' credit units already registered for the semester<br> Addition of '.$_REQUEST["totCredUnit"].' units exceeds '.$max_crload.' maximum credit unit load for the smester.';
//         exit;
//     }
    
//     echo 'Maximum credit load exceeded'; exit;
// }



// if ($_REQUEST["total_unit_carried"] > $_REQUEST["max_crload"])
// {
//     echo $_REQUEST["carried_crload"].' credit units already registered for the semester<br> Addition of '.$_REQUEST["totCredUnit"].' units exceeds '.$_REQUEST["max_crload"].' maximum credit unit load for the smester.';
//     exit;
// }

if (((isset($_REQUEST["conf"]) && $_REQUEST["conf"] == '1') || (isset($_REQUEST["resend_req"]) && $_REQUEST["resend_req"] == '1')) && !isset($_REQUEST["token_supplied"]))
{
    send_token('registering courses for exam');
    echo 'Token sent';
    exit;
}else if (isset($_REQUEST['numofreg']) &&  $_REQUEST['numofreg'] > 0 && isset($_REQUEST["conf"]) && $_REQUEST["conf"] == '1' && isset($_REQUEST["token_supplied"]) && $_REQUEST["token_supplied"] == '1')
{
    $token_status = validate_token('registering courses for exam');
    
    if ($token_status <> 'Token valid')
    {
        echo $token_status;
        exit;
    }
    
    date_default_timezone_set('Africa/Lagos');
    $date2 = date("Y-m-d h:i:s");

    try
    {
        $mysqli->autocommit(FALSE); //turn on transactions
                
        $stmt1 = $mysqli->prepare("REPLACE INTO examreg_20242025 
        (vMatricNo, cCourseId, tSemester, siLevel, cAcademicDesc, tdate)
        values (?, ?, ?, ?, ?, '$date2')");

        $nxt_sn = get_nxt_sn ($_REQUEST["vMatricNo"], '', 'Examination Registration', $_REQUEST["edu_cat"]);
				
        $fee_item_id = get_fee_item_id('Examination Registration');
        if ($fee_item_id == '')
        {
            echo 'Fee item not defined';exit;
        }

        $stmt2 = $mysqli->prepare("REPLACE INTO s_tranxion_20242025 
        (vMatricNo, cCourseId, tdate, cTrntype, iItemID, amount, tSemester, cAcademicDesc, siLevel, trans_count, fee_item_id, vremark)
        values (?, ?, '$date2', 'd', ?, ?, ?, ?, ?, $nxt_sn, $fee_item_id, 'Examination Registration')");

        $cnt = 0;
        for ($k = 1; $k <= $_REQUEST["numofreg"]; $k++)
        {
            if (isset($_REQUEST["regCourses$k"]) && strlen(trim($_REQUEST["regCourses$k"])) == 6 && is_numeric($_REQUEST["credUniInput$k"]) && $_REQUEST["credUniInput$k"] > 0)
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

                /*if ($cProgrammeId == 'LAW301' || $cProgrammeId == 'LAW401')
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
                
                $stmt1->bind_param("ssiis", $_REQUEST["vMatricNo"], $_REQUEST["regCourses$k"], $_REQUEST["tSemester"], $_REQUEST["iStudy_level"], $_REQUEST["AcademicDesc"]);
                $stmt1->execute();
                
                $stmt2->bind_param("sssiisi", $_REQUEST["vMatricNo"], $_REQUEST["regCourses$k"], $_REQUEST["itemid$k"], $_REQUEST["amount$k"], $_REQUEST["tSemester"], $_REQUEST["AcademicDesc"], $_REQUEST["iStudy_level"]);
                $stmt2->execute();
        
                log_actv('registered e '.$_REQUEST["regCourses$k"].' in '.$_REQUEST["AcademicDesc"].', '.$_REQUEST["iStudy_level"].', '.$_REQUEST["tSemester"].' semester');
                
                $carried_crload += $credunit;
                //$carried_crload += $_REQUEST["credUniInput$k"];

                $cnt++;
            }
        }
        $stmt1->close();
        $stmt2->close();
        
        if (get_active_request(4) == 1)
        {
            $stmt = $mysqli->prepare("UPDATE vc_request 
            SET used = '1'
            WHERE vMatricNo = ?
            AND cdel = 'N'
            ORDER BY time_act DESC LIMIT 1");
            $stmt->bind_param("s", $_REQUEST["vMatricNo"]); 
            $stmt->execute();
            $stmt->close();

            log_actv('Used register courses for exam request');
        }

        $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

        echo $cnt.' course(s) successfully registered for exam,'.$carried_crload;
    }catch(Exception $e) 
    {
        $mysqli->rollback(); //remove all queries from queue if error (undo)
        throw $e;
    }
}?>