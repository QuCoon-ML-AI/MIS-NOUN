<?php
require_once('good_entry.php');

// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once(BASE_FILE_NAME.'lib_fn.php');

require_once('std_lib_fn.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="<?php echo BASE_FILE_NAME;?>js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>
        
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE_FILE_NAME;?>styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_1.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_side_menu.css" />
        
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/floating_pprogress.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
	    $mysqli = link_connect_db();

        $orgsetins = settns();
        
        require_once("std_detail_pg1.php");

        /*$stmt = $mysqli->prepare("SELECT 
        cFacultyId,
        cdeptId,
        cProgrammeId,
        cStudyCenterId
        FROM s_m_t 
        WHERE vMatricNo = ?");
        $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cFacultyId_loc1, 
        $cdeptId_loc1, 
        $cProgrammeId_loc1, 
        $cStudyCenterId_loc1);
        $stmt->fetch();

        $err_msg = '';

        $stmt = $mysqli->prepare("SELECT *
        FROM faculty 
        WHERE cFacultyId = '$cFacultyId_loc1'
        AND cDelFlag = 'N'");
        $stmt->execute();
        $stmt->store_result();
        $faculty_found = $stmt->num_rows;        
        
        $stmt = $mysqli->prepare("SELECT *
        FROM depts 
        WHERE cdeptId = '$cdeptId_loc1'
        AND cDelFlag = 'N'");
        $stmt->execute();
        $stmt->store_result();
        $dept_found = $stmt->num_rows;
        
        $stmt = $mysqli->prepare("SELECT *
        FROM programme 
        WHERE cProgrammeId  = '$cProgrammeId_loc1'
        AND cDelFlag = 'N'");
        $stmt->execute();
        $stmt->store_result();
        $programme_found = $stmt->num_rows;        
       

        $stmt = $mysqli->prepare("SELECT *
        FROM studycenter 
        WHERE cStudyCenterId = '$cStudyCenterId_loc1'
        AND cDelFlag = 'N'");
        $stmt->execute();
        $stmt->store_result();
        $centre_found = $stmt->num_rows;

        
        if ($centre_found == 0)
        {
            $err_msg = 'Study centre not defined. Contact Academic Registry via your Study Centre for resolution please';
        }else  if ($programme_found == 0)
        {
            $err_msg = 'Programme not defined. Contact Academic Registry via your Study Centre for resolution please';
        }else if ($dept_found == 0)
        {
            $err_msg = 'Department not defined. Contact Academic Registry via your Study Centre for resolution please';
        }else if ($faculty_found == 0)
        {
            $err_msg = 'Faculty not defined. Contact Academic Registry via your Study Centre for resolution please';
        }
        
        //$err_msg = '';
        
        if ($err_msg <> '')
        {?>
             <form action="student_login_page" method="post" name="ps" enctype="multipart/form-data" onsubmit="chk_mtn(); return false">
                <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
                <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"]) && $_REQUEST["ilin"] <> ''){echo $_REQUEST["ilin"];}?>" />
                <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
                
                <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
                <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />
            </form>
            <div id="intro_video" class="center top_most" 
                style="display:block; 
                text-align:center; 
                padding:10px; 
                box-shadow: 2px 2px 8px 2px #726e41; 
                background:#FFFFFF;
                font-size:0.96em; 
                z-Index:8;"
                
                onclick="_('intro_video').style.display = 'none';
                _('intro_video').zIndex = '-1';
                _('smke_screen_5').style.display = 'none';
                _('smke_screen_5').zIndex = '-1';
                return false;">
                <div style="width:99%; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold; line-height:1.6">
                    Information
                </div>
                <a href="#" style="text-decoration:none;">
                    <div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
                </a>
                <div style="line-height:2; margin-top:10px; width:99%; float:left; text-align:left; padding:0px;">
                    <?php echo $err_msg;?>
                </div>
                <div style="margin-top:10px; width:99%; float:left; text-align:right; padding:0px;">
                    <a href="#" style="text-decoration:none;" 
                        onclick="ps.submit();
                        return false">
                    <div class="login_button" style="width:60px; padding:6px; margin-left:10px; float:right">
                            Ok
                        </div>
                    </a>
                </div>
            </div><?php
            exit;
        }*/

        $tSemester_rsg = '';
        $iStudy_level_rsg = '';
        $cResidenceCountryId_rsg = '';
        
        
        require_once(BASE_FILE_NAME."feedback_mesages.php");
        
        
        if (isset($_REQUEST["reg_sem"]) && $_REQUEST["reg_sem"] == '1' && is_bool(strpos($cProgrammeId_loc, "DEG")) && is_bool(strpos($cProgrammeId_loc, "CHD")))
        {
            // $stmt = $mysqli->prepare("SELECT tSemester, iStudy_level, cResidenceCountryId
            // from s_m_t
            // where vMatricNo = ?");
            // $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
            // $stmt->execute();
            // $stmt->store_result();
            // $stmt->bind_result($tSemester_rsg, $iStudy_level_rsg, $cResidenceCountryId_rsg);
            // $stmt->fetch();
            // $stmt->close();
            
            // $iStudy_level_rsg = $iStudy_level_rsg ?? '';
            // $cResidenceCountryId_rsg = $cResidenceCountryId_rsg ?? '';
            
            if ($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY' || $cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX')
            {
                if ($tSemester_loc%2 == 0)
                {
                    $tSemester_rsg = 2;
                }else if ($tSemester_loc%2 > 0)
                {
                    $tSemester_rsg = 1;
                }
            }else
            {
                $tSemester_rsg = $tSemester_loc;
            }
            
            $feedback = register_student_global($iStudy_level_loc, $tSemester_rsg, $_REQUEST["vMatricNo"], $cResidenceCountryId_loc, $cEduCtgId_loc);
            
            if ($cEduCtgId_loc <> 'ELX')
            {
                $email_loc = strtolower($_REQUEST['vMatricNo']).'@noun.edu.ng';
                $program_loc = $vObtQualTitle_loc.' '.$vProgrammeDesc_loc;

                $mysqli_dot = link_connect_db_dot();
                $stmt1 = $mysqli_dot->prepare("INSERT IGNORE INTO students SET 
                matriculationNo = ?, 
                lastName = '$vLastName_loc', 
                firstName = '$vFirstName_loc', 
                otherName = '$vOtherName_loc',
                email = '$email_loc',
                phoneNumber  = '$vMobileNo_loc', 
                studyCenter = '$cStudyCenterId_loc',
                programme = '$program_loc',
                courseOfStudy = '',
                faculty = '$vFacultyDesc_loc',
                department = '$cdeptId_loc',
                level = $iStudy_level_loc,
                status = ''");
                $stmt1->bind_param("s",$_REQUEST['vMatricNo']);
                $stmt1->execute();
            }
        }

        require_once("forms.php");

        require_once("set_scheduled_dates.php");
        require_once("token_redirect.php");
        require_once("rs_notice_board.php");

        //handle debit without registering
        // if ($semester_reg_loc == '0')
        // {
        //     $stmt = $mysqli->prepare("SELECT *
        //     FROM s_tranxion_20242025
        //     WHERE cCourseId = 'xxxxxx'
        //     AND tdate >= '$semester_begin_date'
        //     AND vMatricNo = ?");
        //     $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
        //     $stmt->execute();
        //     $stmt->store_result();

        //     $can_update = 0;
        //     if (($cEduCtgId_loc == 'PSZ' || $cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY' && ($stmt->num_rows == 5 || $stmt->num_rows == 11)))
        //     {
        //         $can_update = 1;
        //     }else if (($cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX' && ($stmt->num_rows == 5 || $stmt->num_rows == 10)))
        //     {
        //         $can_update = 1;
        //     }

        //     if ($can_update == 1)
        //     {
        //         $stmt = $mysqli->prepare("UPDATE s_m_t 
        //         SET session_reg = '1',
        //         semester_reg = '1', 
        //         cAcademicDesc = '".$orgsetins["cAcademicDesc"]."', 
        //         act_time = NOW() 
        //         WHERE vMatricNo = ?");
        //         $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
        //         $stmt->execute();
        //     }            
        // }

        if (isset($_REQUEST["just_coming"]))
        {
            //do_balance ();
            if ($cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX')
            {
                //prev_wallet_bal();
            }
        }
        
        $balance = 0.00;
        
        $successful_login = 5;
        
        if (!is_bool(strpos($cProgrammeId_loc, "CHD")))
        {
            $set_date1 = $orgsetins_chd['reg0'];
            $set_date2 = $orgsetins_chd['reg1'];
        }else if (!is_bool(strpos($cProgrammeId_loc, "DEG")))
        {
            $set_date1 = $orgsetins_deg['reg0'];
            $set_date2 = $orgsetins_deg['reg1'];
        }else
        {
            $set_date1 = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);
            if ($iStudy_level_loc <= 200)
            {
                $set_date2 = substr($orgsetins['regdate_100_200_2'],4,4).'-'.substr($orgsetins['regdate_100_200_2'],2,2).'-'.substr($orgsetins['regdate_100_200_2'],0,2);
            }else
            {
                $set_date2 = substr($orgsetins['regdate_300_2'],4,4).'-'.substr($orgsetins['regdate_300_2'],2,2).'-'.substr($orgsetins['regdate_300_2'],0,2);
            }
        }

        if (!isset($_REQUEST["top_menu_no"]) || (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == ''))
        {
            // $stmt = $mysqli->prepare("SELECT *
            // FROM atv_log 
            // WHERE vDeed = 'Login'
            // AND tDeedTime > '$set_date1'
            // AND tDeedTime < '$set_date2'
            // AND vApplicationNo = ?"); 
            // $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
            // $stmt->execute();
            // $stmt->store_result();
            // $successful_login = $stmt->num_rows;
            // $stmt->close();
            
            
            if ($cFacultyId_loc == 'AGR')
            {
                $g_url_cw = 'https://nou.edu.ng/ecourseware-faculty-of-agric/';
            }else if ($cFacultyId_loc == 'ART')
            {
                $g_url_cw = 'https://nou.edu.ng/ecourseware-faculty-of-arts/';
            }else if ($cFacultyId_loc == 'EDU')
            {
                $g_url_cw = 'https://nou.edu.ng/ecourseware-faculty-of-edu/';
            }else if ($cFacultyId_loc == 'HSC')
            {
                $g_url_cw = 'https://nou.edu.ng/ecourseware-faculty-of-health-sc/';
            }else if ($cFacultyId_loc == 'LAW')
            {
                $g_url_cw = 'https://nou.edu.ng/ecourseware-faculty-of-law/';
            }else if ($cFacultyId_loc == 'MSC')
            {
                $g_url_cw = 'https://nou.edu.ng/ecourseware-faculty-of-management-sc/';
            }else if ($cFacultyId_loc == 'SCI')
            {
                $g_url_cw = 'https://nou.edu.ng/ecourseware-faculty-of-sciences/';
            }else if ($cFacultyId_loc == 'SSC')
            {
                $g_url_cw = 'https://nou.edu.ng/ecourseware-faculty-of-social-sc/';
            }else if ($cFacultyId_loc == 'CMP')
            {
                $g_url_cw = 'https://nou.edu.ng/ecourseware-faculty-of-sciences/';
            }else if ($cFacultyId_loc == 'DEG')
            {
                $g_url_cw = 'https://nou.edu.ng/ecourseware-degs/';
            }else
            {
                $g_url_cw = 'https://nou.edu.ng/e-courseware/';
            }
            
            if ($number_of_reg_courses == 0)//intro video for fresh students
            {?>
                <div id="smke_screen_5" class="smoke_scrn" style="opacity:0.9; display:none; z-index:7"></div><?php
                if (!is_bool(strpos($cProgrammeId_loc, "CHD")))
                {?>
                    <div id="intro_video" class="center top_most" 
                        style="display:block; 
                        text-align:center; 
                        padding:10px; 
                        box-shadow: 2px 2px 8px 2px #726e41; 
                        background:#FFFFFF;
                        font-size:0.96em; 
                        z-Index:8;"
                        
                        onclick="_('intro_video').style.display = 'none';
                        _('intro_video').zIndex = '-1';
                        _('smke_screen_5').style.display = 'none';
                        _('smke_screen_5').zIndex = '-1';
                        return false;">
                        <div style="width:99%; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold; line-height:1.6">
                            Information - Centre For Human Resources Development In Collaboration With Supernannies Nigeria Limited
                        </div>
                        <a href="#" style="text-decoration:none;">
                            <div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
                        </a>
                        <div style="line-height:2; margin-top:10px; width:99%; float:left; text-align:left; padding:0px;">
                            <font style="color:#e31e24;">You need to do the following when the semester opens:</font>
                            <p>
                            <ol>                                                            
                                <li style="line-height:2.4; border:none;">
                                    Make payment for registeration
                                </li>
                                <li style="line-height:2.4; border:none;">
                                    Download course material on the course registration page
                                </li>
                                <li style="line-height:2.4; border:none;">
                                    Click <a href="https://elearn.nouedu2.net/" target="_blank">
                                        <font style="color:#13750b;">here</font></a> to attend classes and intereact with facilitator for each of the registered courses
                                </li>
                                <li style="line-height:2.4; border:none;">
                                    Do your tutor assignment when it is time
                                </li>
                                <li style="line-height:2.4; border:none;">
                                    Take exams when it is time
                                </li>
                            </ol>
                        </div>
                        <div style="margin-top:10px; width:99%; float:left; text-align:right; padding:0px;">
                            <a href="#" style="text-decoration:none;" 
                                onclick="_('intro_video').style.display = 'none';
                                _('intro_video').zIndex = '-1';
                                _('smke_screen_5').style.display = 'none';
                                _('smke_screen_5').zIndex = '-1';
                                return false;">
                            <div class="login_button" style="width:60px; padding:6px; margin-left:10px; float:right">
                                    Ok
                                </div>
                            </a>
                        </div>
                    </div><?php
                }else
                {?>                
                    <div id="intro_video" class="center top_most" 
                        style="display:block; 
                        text-align:center; 
                        padding:10px; 
                        box-shadow: 2px 2px 8px 2px #726e41; 
                        background:#FFFFFF;
                        font-size:0.96em; 
                        z-Index:8;"
                        onclick="_('intro_video').style.display = 'none';
                        _('intro_video').zIndex = '-1';
                        _('smke_screen_5').style.display = 'none';
                        _('smke_screen_5').zIndex = '-1';
                        return false;">
                        <div style="width:99%; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                            Information
                        </div>
                        <a href="#" style="text-decoration:none;">
                            <div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
                        </a>
                        <div style="line-height:2; margin-top:10px; width:99%; float:left; text-align:left; padding:0px;"><?php
                            if ($semester_open == 1)
                            {?>
                                <font style="color:#e31e24;">You need to do the following:</font><?php
                            }else
                            {?>
                                <font style="color:#e31e24;">You need to do the following when the semester opens:</font><?php
                            }?>
                            <p>
                            <ol><?php
                                if ($cEduCtgId_loc <> 'ELX')
                                {
                                    if ($semester_reg_loc == '0')
                                    {?>
                                        <li style="line-height:2.4; border:none;">
                                            Register for current semester that is by clicking on Register for the semester (left)
                                        </li><?php
                                    }
                                    
                                    if ($number_of_reg_courses == '0')
                                    {?>
                                        <li style="line-height:2.4; border:none;">
                                            Register courses (and print out your course registration slip)
                                        </li><?php
                                    }
                                    
                                    if ($number_of_reg_exam == '0')
                                    {?>
                                        <li style="line-height:2.4; border:none;">
                                            Register courses for exam (and print out your exam registration slip)
                                            <ol  style="list-style-type:none">
                                                <li style="line-height:2.4; border:none;">
                                                    See procedure K, L and M for steps to follow under 'Help' above for items 1, 2 and 3
                                                </li>
                                            </ol>
                                        </li><?php
                                    }
                                }else
                                {?>                            
                                    <li style="line-height:2.4; border:none;">
                                        Make payment for registeration
                                    </li><?php                                    
                                }?>
                                <li style="line-height:2.4; border:none;">
                                    Collect available course materials at the store in your study centre or,
                                </li>
                                <!-- <li style="line-height:2.4; border:none;">
                                    Click <a href="<?php echo $g_url_cw;?>" target="_blank">
                                        <font style="color:#13750b;">here</font></a> to download course materials
                                </li> -->
                                <li style="line-height:2.4; border:none;">
                                    <!--Click <a href="https://elearn.nou.edu.ng/" target="_blank">
                                        <font style="color:#13750b;">here</font></a> to--> Attend classes under My learning space (above) and intereact with your course mates for each of the registered courses
                                </li>
                                <li style="line-height:2.4; border:none;">
                                    Do your tutor marked assignment (TMA) when it is time
                                </li>
                                <li style="line-height:2.4; border:none;">
                                    Take exams when it is time
                                </li>
                            </ol>
                        </div>
                        <div style="margin-top:10px; width:99%; float:left; text-align:right; padding:0px;">
                            <a href="#" style="text-decoration:none;" 
                                onclick="_('intro_video').style.display = 'none';
                                _('intro_video').zIndex = '-1';
                                _('smke_screen_5').style.display = 'none';
                                _('smke_screen_5').zIndex = '-1';
                                return false;">
                            <div class="login_button" style="width:60px; padding:6px; margin-left:10px; float:right">
                                    Ok
                                </div>
                            </a>
                        </div>
                    </div><?php
                }
            }
        }?>
        
            
        <form action="std_login_page" method="post" name="ps" enctype="multipart/form-data" onsubmit="chk_mtn(); return false">
            <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
            <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"]) && $_REQUEST["ilin"] <> ''){echo $_REQUEST["ilin"];}?>" />
            <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
            
            <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
            <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />
        </form>

        <div class="appl_container">
            <div class="appl_left_div" style="z-index:2;">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em"><?php
                    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'semester_registration')
                    {                    
                        echo "Pay registration fee to register for the semester";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == '' && isset($_REQUEST["top_menu_no"]) && ($_REQUEST["top_menu_no"] == '1' || $_REQUEST["top_menu_no"] == ''))
                    {
                        echo "Academic callendar";
                    }else if ($semester_reg_loc == '0' && isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'semester_registration')
                    {
                        echo "Fee schedule";
                    }else if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '10')
                    {
                        echo "Contact support";
                    }/*else if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '8')
                    {
                        if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'personal_timetable')
                        {
                            echo "Personal exam timetable";
                        }
                    }*/else if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '9')
                    {
                        /*if ($tSemester_loc == 1)
                        {
                            echo "Result of ".($orgsetins ["cAcademicDesc"]-1)."_2";
                        }else
                        {
                            echo "Result of ".($orgsetins ["cAcademicDesc"]-1)."_1";
                        }*/

                        echo 'Result of previous semester';
                    }else
                    {
                        echo "Student Home Page";
                    }?>
                </div>
                
                <div class="for_computer_screen">
                    <?php require_once ('std_left_side_menu.php');?>                    
                </div>
            </div>
            
            <div class="appl_right_div">             
                <div class="appl_left_child_div for_mobile_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php std_top_samll_menu();?>
                </div>

                <div class="appl_left_child_div for_computer_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php std_top_menu();?>
                </div>
                
                
                <div class="appl_left_child_div for_mobile_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php require_once ('mobile_menu_bar_content.php');?>
                </div>

                
                <div class="appl_left_child_div for_computer_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php require_once ('menu_bar_content.php');?>
                </div>
                
                <div class="menu_sm_scrn">
                    <?php build_menu_right();?>
                </div>
                <div id="par_name" class="appl_left_child_div" style="width:98%; margin:auto; height:95%; margin-top:10px; overflow:auto; background-color:#eff5f0;"><?php
                    /*$stmt = $mysqli->prepare("SELECT * FROM prog_choice_pg WHERE transcript = '1' AND vApplicationNo = ?");
                    $stmt->bind_param("s", $vApplicationNo_loc);
                    $stmt->execute();
                    $stmt->store_result();
                    $submited_trn = $stmt->num_rows;
                    $stmt->close();

                    if ($submited_trn == 0 && $cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY' || $cEduCtgId_loc == 'PGZ')
                    {
                        $stmt = $mysqli->prepare("SELECT tDeedTime, DATEDIFF(NOW(), tDeedTime) FROM atv_log WHERE vDeed = 'submitted application form'  AND vApplicationNo  = '$vApplicationNo_loc'");
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($tDeedTime, $time_elapsed);
                        $stmt->fetch();
                        $stmt->close();
                        
                        $deadline = date('Y-m-d', strtotime($tDeedTime. ' + 90 days'));
                        
                        $tDeedTime = formatdate($tDeedTime, 'fromdb');
                        $tDeedTime = substr( $tDeedTime,0,2).substr( $tDeedTime,3,2).substr($tDeedTime,6,4);
                        ?>
                        <div class="appl_left_child_div_child" style="margin-bottom: 20px;">
                        <div style="flex:5%; padding:5px; line-height:1.6; height:50px; background-color: #ffffff">
                            <img style="width:45px; height:inherit" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'error1.png');?>"/>
                        </div>
                        <div style="flex:45%; padding:5px; line-height:1.6; height:50px; background-color:#FFFFFF; color:#e64246">
                            Transcript submission count down:
                        </div>

                        <div style="flex:50%; padding:5px; line-height:1.6; height:50px; background-color: #ffffff">
                            <input name="tDeedTime" id="tDeedTime" type="hidden" value="<?php echo $tDeedTime; ?>" />
                            <input name="deadline" id="deadline" type="hidden" value="<?php echo $deadline; ?>" />
                                <script>
                                    var yearsAA_1 = _("tDeedTime").value.substr(4,4);
                                    var monthsAA_1 = _("tDeedTime").value.substr(2,2)-1;
                                    var daysAA_1 = _("tDeedTime").value.substr(0,2);
                                    var countDownDateB_1 = new Date(yearsAA_1, monthsAA_1, daysAA_1).getTime();

                                    var countDownDateB_0 = new Date().getTime();

                                    if(countDownDateB_1 <= countDownDateB_0)
                                    {
                                        var yearsAA = _("deadline").value.substr(4,4);
                                        var monthsAA = _("deadline").value.substr(2,2)-1;
                                        var daysAA = _("deadline").value.substr(0,2);

                                        var countDownDateA = new Date(yearsAA, monthsAA, daysAA).getTime();
                                        
                                        // Update the count down every 1 second
                                        var xA = setInterval(function() 
                                        {
                                            var nowA = new Date().getTime();
                                            var distanceA = countDownDateA - nowA;

                                            var weeksA = Math.floor(distanceA / (1000 * 60 * 60 * 24 * 7));
                                            var daysA = Math.floor((distanceA % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24));
                                            var hoursA = Math.floor((distanceA % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            var minutesA = Math.floor((distanceA % (1000 * 60 * 60)) / (1000 * 60));
                                            var secondsA = Math.floor((distanceA % (1000 * 60)) / 1000);

                                            // Display the result in the element with id="demo"                    
                                            _("demoF1").innerHTML = weeksA + "Wks ";                    
                                            _("demoF2").innerHTML = daysA + "Days ";                    
                                            _("demoF3").innerHTML = hoursA + "Hr ";
                                            _("demoF4").innerHTML = minutesA + "Mins ";
                                            _("demoF5").innerHTML = secondsA + "Sec ";

                                            // If the count down is finished, write some text
                                            if (distanceA < 0)
                                            {
                                                clearInterval(xA);
                                                for (c = 1; c <= 5; c++)
                                                {
                                                    _("demoF"+c).style.display = 'none';
                                                }
                                                _("demoF").style.display = 'block';
                                                _("demoF").innerHTML = 'Closed';
                                            }else
                                            { 
                                                for (c = 1; c <= 5; c++)
                                                {
                                                    _("demoF"+c).style.display = 'block';
                                                }
                                                _("demoF").style.display = 'none';

                                            }
                                        }, 1000);
                                    }
                                </script>

                                <div id="demoF" class="count_down_div" style="display:block; width:100%; height:auto;">
                                    Loading...
                                </div>
                                <div id="demoF1" class="count_down_div" style="height:auto;">
                                    00
                                </div>
                                <div id="demoF2" class="count_down_div" style="margin-left:2%">
                                    00
                                </div>
                                <div id="demoF3" class="count_down_div" style="margin-left:2%">
                                    00
                                </div>
                                <div id="demoF4" class="count_down_div" style="margin-left:2%">
                                    00
                                </div>
                                <div id="demoF5" class="count_down_div" style="margin-left:2%; font-weight:bold;">
                                    00
                                </div>
                            </div>
                        </div><?php
                    }*/
                    
                    if ($semester_reg_loc == '1')
                    {?>
                        <div class="appl_left_child_div_child" style="margin-bottom: 20px;">
                            <div style="flex:5%; padding:5px; line-height:1.6; height:50px; background-color: #ffffff"><?php
                                if (((!is_bool(strpos($cProgrammeId_loc, "CHD")) || 
                                (!is_bool(strpos($cProgrammeId_loc, "DEG")))) && $reg_open_cert == 1) || 
                                (is_bool(strpos($cProgrammeId_loc, "CHD")) && is_bool(strpos($cProgrammeId_loc, "DEG")) && $reg_open == 1) ||
                                (($cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX') && $reg_open_spg == 1) || get_active_request(0) == 1)
                                {?>
                                    <img style="width:45px; height:inherit" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'success.png');?>"/><?php
                                }?>
                            </div><?php
                            if (((!is_bool(strpos($cProgrammeId_loc, "CHD")) || 
                            (!is_bool(strpos($cProgrammeId_loc, "DEG")))) && $reg_open_cert == 1) || 
                            (is_bool(strpos($cProgrammeId_loc, "CHD")) && is_bool(strpos($cProgrammeId_loc, "DEG")) && $reg_open == 1) ||
                            (($cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX') && $reg_open_spg == 1) || get_active_request(0) == 1)
                            {?>
                                <div style="flex:95%; padding:5px; line-height:1.6; height:50px; background-color:#74cb81; color:#ffffff">
                                    You are registered for the current semester. You may proceed to register your courses under 'My courses' above
                                </div><?php
                            }else
                            {?>
                                <div style="flex:95%; padding:5px; line-height:1.6; height:50px; background-color:#fdf0bf; color:#000">
                                    Registration closed
                                </div><?php
                            }?>
                        </div><?php
                    }
                    
                    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == '' && isset($_REQUEST["top_menu_no"]) && ($_REQUEST["top_menu_no"] == '1' || $_REQUEST["top_menu_no"] == ''))
                    {
                        if (!is_bool(strpos($cProgrammeId_loc, "CHD")))
                        {
                            require_once("acad_cal_cert.php");
                        }else if (!is_bool(strpos($cProgrammeId_loc, "DEG")))
                        {
                            require_once("acad_cal_cert.php");
                        }else
                        {
                            require_once("acad_cal.php");
                        }
                    }else if ($semester_reg_loc == '0' && isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'semester_registration')
                    {
                        if (/*!is_bool(strpos($cProgrammeId_loc, "CHD")) ||*/ !is_bool(strpos($cProgrammeId_loc, "DEG")))
                        {
                            $stmt = $mysqli->prepare("UPDATE s_m_t 
                            SET session_reg = '1',
                            semester_reg = '1', 
                            cAcademicDesc = '".$orgsetins["cAcademicDesc"]."', 
                            act_time = NOW() 
                            WHERE vMatricNo = '$vMatricNo'");
                            $stmt->execute();
			                $stmt->close();?>

                            <div class="appl_left_child_div_child" style="margin-bottom: 20px;">
                                <div style="flex:5%; padding:5px; line-height:1.6; height:50px; background-color: #ffffff">
                                    <img style="width:45px; height:inherit" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'success.png');?>"/>
                                </div>
                                <div style="flex:95%; padding:5px; line-height:1.6; height:50px; background-color:#74cb81; color:#ffffff">
                                    You are registered for the current semester. You may proceed to register your courses under 'My courses' above
                                </div>
                            </div><?php
                        }else
                        {
                            require_once("fee_to_pay.php");
                        }
                    }else if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '10')
                    {
                        require_once("support_contact.php");
                    }else if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '9')
                    {
                        require_once("rs_see_prev_rslt.php");
                    }else if (isset($_REQUEST["top_menu_no"]))
                    {
                        $width = '44%';
                        $height = '580px';
                        
                        $img = 'img/cbt_c.jpg';
                        if ($_REQUEST["top_menu_no"] == '1')
                        {
                            $img = 'img/cbt_c.jpg';
                        }else if ($_REQUEST["top_menu_no"] == '2')
                        {
                            $img = 'img/dept.jpg';
                        }else if ($_REQUEST["top_menu_no"] == '3')
                        {
                            $img = 'img/burs_c.jpg';
                        }else if ($_REQUEST["top_menu_no"] == '4')
                        {
                            $img = 'img/reg_c.jpg';
                        }else if ($_REQUEST["top_menu_no"] == '5')
                        {
                            $img = 'img/c_reg_c.jpg';
                        }else if ($_REQUEST["top_menu_no"] == '7')
                        {
                            $img = 'img/lib_c.jpg';
                        }else if ($_REQUEST["top_menu_no"] == '8')
                        {
                            $img = 'img/cbt_c.jpg';
                        }?>
                        
                        <div  class="appl_left_child_div_child" id="spec_img_div" style="margin-bottom: 20px;">
                            <div style="flex:100%; padding:5px; height:auto; text-align:center; background-color: #ffffff">
                                <img style="width:<?php echo $width;?>; height:<?php echo $height;?>" src="data:image/png;base64,<?php echo c_image($img);?>"/>
                            </div>
                        </div><?php
                    }else
                    {?>
                        <div class="appl_left_child_div_child" id="gen_img_div" style="margin-bottom: 20px;">
                            <div style="flex:100%; padding:5px; height:auto;; text-align:center; background-color: #ffffff">
                                <img style="width:44%; height:580px" src="data:image/png;base64,<?php echo c_image('img/cbt_c.jpg');?>"/>
                            </div>
                        </div><?php
                    }
                   
                    
                    require_once ('std_bottom_right_menu.php');?>
                </div>
            </div>

            <div id="menu_bs_scrn" class="appl_far_right_div" style="z-index:2; position:relative">
                <?php build_menu_right($balance);?>
            </div>
        </div>
	</body>
</html>