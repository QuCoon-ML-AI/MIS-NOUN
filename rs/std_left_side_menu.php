<div id="general_smke_screen" class="smoke_scrn" style="display:none; z-index:-1"></div>

<div id="general_smke_screen" class="smoke_scrn" style="display:none; z-index:-1"></div><?php 
if ($iStudy_level_loc <= 200)
{
    $reg_open = $reg_open_100_200;
}else
{
    $reg_open = $reg_open_300;
}

if (((!is_bool(strpos($cProgrammeId_loc, "CHD")) || 
(!is_bool(strpos($cProgrammeId_loc, "DEG")))) && $reg_open_cert == 1) || 
(is_bool(strpos($cProgrammeId_loc, "CHD")) && is_bool(strpos($cProgrammeId_loc, "DEG")) && $reg_open == 1) || 
(($cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX') && $reg_open_spg == 1) || get_active_request(0) == 1)
{
    if (isset($semester_reg_loc) && $semester_reg_loc == '0')
    {
        if (!isset($_REQUEST["side_menu_no"]) || (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> 'semester_registration'))
        {?>
            <ul id="home_menu" class="side_menu" 
                style="margin-top:15px; 
                 
                display:<?php if (!isset($_REQUEST["top_menu_no"]) || (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '')){echo 'block';}else{echo 'none';}?>">
                    <a href="#" style="text-decoration:none; color:#31843e;" 
                        onclick="lib_js('','semester_registration','_self','welcome_student');">
                        <li>Register for the semester</li>
                    </a>           
            </ul><?php
        }else
        {?>
            <ul id="home_menu" class="side_menu" 
                style="margin-top:15px; 
                display:<?php if (!isset($_REQUEST["top_menu_no"]) || (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '')){echo 'block';}else{echo 'none';}?>">
                    <li class="inlin_message_color" style="text-align: center; cursor:default">Register for the semesters</li>
            </ul><?php
        } 
    }else if (isset($semester_reg_loc) && $semester_reg_loc == '1')
    {?>
        <ul id="home_menu" class="side_menu" 
            style="margin-top:5px; width:95%; padding:0px;
            display:<?php if (!isset($_REQUEST["top_menu_no"]) || (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '')){echo 'block';}else{echo 'none';}?>">
                <li class="inlin_message_color" style="text-align: center; margin:auto; padding:8px 0px 8px 0px; cursor:default; width:100%; background-color:#74cb81; color:#ffffff; height:auto;">You are registered for the current semester</li>
        </ul><?php
    }
}else
{?>
    <ul id="home_menu" class="side_menu" 
        style="margin-top:15px; 
        display:<?php if (!isset($_REQUEST["top_menu_no"]) || (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '')){echo 'block';}else{echo 'none';}?>">
            <li class="inlin_message_color" style="text-align: center; cursor:default">Registration closed</li>
    </ul><?php   
}?>

<ul id="orient_menu" class="side_menu" style="display:<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '1'){echo 'block';}else{echo 'none';}?>">
    <li class="li_submenu_header"> Sub-menu items</li>
    <a href="#" style="text-decoration:none;" 
        onclick="lib_js('1','acad_cal','_self', 'university_structure');
    return false">
        <li>Callendar</li>
    </a>
    
    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">University structure
        <ul style="list-style:none"> 
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','noun_philosophy','_self', 'university_structure');">
                <li>NOUN Phylosophy</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','noun_admin','_self', 'university_structure');">
                <li>Administration </li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','noun_gc','_self', 'university_structure');">
                <li>Governing Council</li>
            </a>
             
        </ul>
    </li>
    
    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">The Pricipal Officers
        <ul style="list-style:none">
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','from_vc','_self', 'university_structure');">
                <li>Hear from the Vice Chancellor</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','from_dvcacad','_self', 'university_structure');">
                <li>Deputy Vice-Chancellor Academic</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','from_dvcadmin','_self', 'university_structure');">
                <li>Deputy Vice-Chancellor Aamininstration</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','from_dvctir','_self', 'university_structure');" title="TIR = Innovation Technology and Research">
                <li>Deputy Vice-Chancellor TIR</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','from_reg','_self', 'university_structure');">
                <li>The Registrar</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','from_bursar','_self', 'university_structure');">
                <li>The Bursar</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','from_lib','_self', 'university_structure');">
                <li>The University Librarian</li>
            </a>
        </ul>
    </li><?php if ($cFacultyId_loc <> 'DEG' && $cFacultyId_loc <> 'CHD')
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('1','from_dean','_self', 'university_structure');">
            <li>Hear from the Dean</li>
        </a><?php
    }?>
        
    <!-- <li style="list-style: inside url('<?php //echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');" title="Meet the Deputy Vice Chancellors (DVC)">Meet the DVCs
        <ul style="list-style:none">            
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=1;pgprgs.side_menu_no.value='dvc_admin';pgprgs.submit(); return false">
                <li>DVC Adminstration </li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=1;pgprgs.side_menu_no.value='dvc_acad';pgprgs.submit(); return false">
                <li>DVC Academic </li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=1;pgprgs.side_menu_no.value='dvc_tri';pgprgs.submit(); return false" title="DVC Technology Innovation and Research">
                <li>DVC TIR </li>
            </a>
        </ul>
    </li>
         -->
    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Virtual space
        <ul style="list-style:none">
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','virtual_space','_self', 'my_learning_environment');">
                <li>My learning space</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','study_centre','_self', 'my_learning_environment');">
                <li>Study Centre</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','semester_reg','_self', 'my_learning_environment');">
                <li>Semester registration</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','course_reg','_self', 'my_learning_environment');">
                <li>Course registration</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','exam_reg','_self', 'my_learning_environment');">
                <li>Examination registration</li>
            </a>
            
        </ul>
    </li>
    <a href="#" style="text-decoration:none;" 
        onclick="lib_js('1','mle_fac','_self', 'my_learning_environment');">
        <li>Facilitation</li>
    </a>
    <a href="#" style="text-decoration:none;" 
        onclick="lib_js('1','use_of_lib','_self', 'my_learning_environment');">
        <li>Use of Library</li>
    </a> 
        
    <!-- <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Assessment
        <ul style="list-style:none">               
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=1;pgprgs.side_menu_no.value='tutor_marked_assignment';pgprgs.submit(); return false">
                <li>Tutor marked assignment (TMA)</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=1;pgprgs.side_menu_no.value='examination';pgprgs.submit(); return false">
                <li>Examination</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=1;pgprgs.side_menu_no.value='19';pgprgs.submit(); return false">
                <li title="Seminar, SIWES, Research project, Internship and Practicum">Practicals</li>
            </a>                 
        </ul>
    </li> -->
        
    <!-- <li id="lss_menu" style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Learner support
        <ul id="lss_sm" style="list-style:none">                
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=1;pgprgs.side_menu_no.value='councellors';pgprgs.submit(); return false">
                <li>Councellors</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=1;pgprgs.side_menu_no.value='facilitators';pgprgs.submit(); return false">
                <li>Facilitators</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=1;pgprgs.side_menu_no.value='teaching_assistants';pgprgs.submit(); return false">
                <li>Teaching Assistants</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=1;pgprgs.side_menu_no.value='technical_support';pgprgs.submit(); return false">
                <li>Technical support</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=1;pgprgs.side_menu_no.value='faqs';pgprgs.submit(); return false">
                <li>FAQs</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=1;pgprgs.side_menu_no.value='e_ticketing';pgprgs.submit(); return false">
                <li>Lodge complaints (e-ticketing)</li>
            </a>                 
        </ul>
    </li>-->
    
    <a href="#" style="text-decoration:none;" 
        onclick="lib_js('8','','_self', 'welcome_student');">
        <li title="Seminar, SIWES, Research project, Internship and Practicum">Assessment</li>
    </a> 
</ul>
    
    
<!-- <ul id="dept_menu" class="side_menu" style="display:<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '2'){echo 'block';}else{echo 'none';}?>">
    <li class="li_submenu_header"> Sub-menu items</li>
    <a href="#" style="text-decoration:none;" 
        onclick="pgprgs.top_menu_no.value=2;pgprgs.side_menu_no.value=1;pgprgs.submit(); return false">
        <li title="Hear from the Head of Department">Hear from the HOD</li>
    </a>

    <li style="list-style: inside url('<?php //echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');" title="Meet the Full time Academic staff, Part time Academic staff and Non-Academic staff">Meet the...
        <ul style="list-style:none"> 
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=2;pgprgs.side_menu_no.value=2;pgprgs.submit(); return false">
                <li>...full time Academic staff</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=2;pgprgs.side_menu_no.value=3;pgprgs.submit(); return false">
                <li>...part time Academic staff</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=2;pgprgs.side_menu_no.value=4;pgprgs.submit(); return false">
                <li>...non-Academic staff</li>
            </a>
        </ul>
    </li>
</ul> -->

<!-- lib_js(top_menu_no,side_menu_no,target,action); -->

<ul id="burs_menu" class="side_menu" style="display:<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '3'){echo 'block';}else{echo 'none';}?>">
    <li class="li_submenu_header"> Sub-menu items</li><?php
    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'list_transactions')
    {?>
        <li class="dul_li">e-Wallet</li><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('3','list_transactions','_self','account-statement');">
            <li>e-Wallet</li>
        </a><?php
    }
    
    
    if ((isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'make_payment') || $books_ready <> 1)
    {?>
        <li class="dul_li">Make payment</li><?php
    }else
    {?>
        <!--<a href="#" style="text-decoration:none;" 
            onclick="lib_js('3','make_payment','_self','make-payment');">
            <li>Make payment</li>
        </a>--><?php
    }
    
    
    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'check_payment_status')
    {?>
        <li class="dul_li">Check payment status</li><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('3','check_payment_status','_self','check_state_of_transaction');">
            <li>Check payment status</li>
        </a><?php
    }
    
    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'my_bank_detail')
    {?>
        <li class="dul_li">My bank detail</li><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('3','my_bank_detail','_self','update_bank_detail');">
            <li>My bank detail</li>
        </a><?php
    }

    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'final_year_clearance')
    {?>
        <li class="dul_li">Financial standing</li><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;"
        title="For final year student only" 
            onclick="lib_js('3','final_year_clearance','_self','final_year_clearance');">
            <li>Financial standing</li>
        </a><?php
    }
    

    $stmt_grad_mat_list = $mysqli->prepare("SELECT vMatricNo
    FROM s_m_t_grad_mat_list
    WHERE LEFT(vMatricNo,12) = ?");
    $stmt_grad_mat_list->bind_param("s", $_REQUEST["vMatricNo"]);
    $stmt_grad_mat_list->execute();
    $stmt_grad_mat_list->store_result();
    $stmt_grad_mat_list->bind_result($grad_mat);
    $stmt_grad_mat_list->fetch();
    $stmt_grad_mat_list->close();

    if (!is_null($grad_mat))
    {
        $stmt_s_tranxion = $mysqli->prepare("SELECT amount
        FROM s_tranxion_cr
        WHERE fee_item_id = '31' 
        AND vMatricNo = ?");
        $stmt_s_tranxion->bind_param("s", $_REQUEST["vMatricNo"]);

        $stmt_s_tranxion->execute();
        $stmt_s_tranxion->store_result();
        $stmt_s_tranxion->bind_result($s_conv_amount);
        $stmt_s_tranxion->fetch();
        $stmt_s_tranxion->close();

        // if (is_null($s_conv_amount))
        // {
        //     $s_conv_amount = 0;
        // }

        //if (isset($grad) && $grad <> '0' && $s_conv_amount == 0)
        if (!is_null($s_conv_amount) || (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'pay_convocation_gown'))
        {
            if (!is_null($s_conv_amount))
            {?>
                <li class="dul_li">Paid for convocation gown</li><?php
            }else
            {?>
                <li class="dul_li">Pay for convocation gown</li><?php
            }
        }else
        {?>
            <a href="#" style="text-decoration:none;"
            title="For final year student only" 
                onclick="lib_js('3','pay_convocation_gown','_self','pay_for_convocation_gown');">
                <li>Pay for convocation gown</li>
            </a><?php
        }
    }?>
</ul>


<ul id="reg_menu" class="side_menu" style="display:<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '4'){echo 'block';}else{echo 'none';}?>">
    <li class="li_submenu_header"> Sub-menu items</li><?php
    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'change_password')
    {?>
        <li class="dul_li">Change password</li><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('4','change_password','_self','change_password');">
            <li>Change password</li>
        </a><?php
    }

     
    $stmt_last = $mysqli->prepare("SELECT a.vApplicationNo FROM pics a, s_m_t b WHERE a.vApplicationNo = b.vApplicationNo AND b.vMatricNo = ? AND cinfo_type = 'p'");
    $stmt_last->bind_param("s", $_REQUEST["vMatricNo"]);
    $stmt_last->execute();
    $stmt_last->store_result();
    $has_pp = $stmt_last->num_rows;
    $stmt_last->close();
   
    if ($has_pp > 0)
    {
        if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'see_application_record')
        {?>
            <li class="dul_li">See application record</li><?php
        }else
        {?>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('4','see_application_record','_self','see_application_record');">
            <li>See application record</li>
        </a><?php
        }
        
    }
    
     if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'update_bio_data')
     {?>
         <li class="dul_li">Update bio-data</li><?php
     }else
     {?>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('4','update_bio_data','_self','update_bio_data');">
            <li>Update bio-data</li>
        </a><?php
     }
     
    //if ($has_pp > 0)
    //{
        if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'print_identity_card')
        {?>
            <li class="dul_li">Print identity card</li><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="std_id_card.action='print_identity_card';
                std_id_card.submit();
                return false;">
                <li>Print identity card</li>
            </a><?php
        }
    //}
    
    if (($iStudy_level_loc <= 200 && $student_can_request_100 == 1) || ($iStudy_level_loc > 200 && $student_can_request_300 == 1) || ($cFacultyId_loc == 'DEG' || $cFacultyId_loc == 'CHD'))
    {
        if ($cEduCtgId_loc <> 'PGZ' && $cEduCtgId_loc <> 'PRX')
        {?>
            <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Request for...
                <ul style="list-style:none"> 
                    <!--<a href="#" style="text-decoration:none;" 
                        onclick="in_progress('1');
                        std_sections.side_menu_no.value='change_of_name';
                        std_sections.action='students_requests';
                        std_sections.submit();">
                        <li>...change of name</li>
                    </a>--><?php
                    if ($cFacultyId_loc <> 'DEG' && $cFacultyId_loc <> 'CHD')
                    {?>
                        <a href="#" style="text-decoration:none;" 
                            onclick="in_progress('1');
                            std_sections.side_menu_no.value='change_of_level';
                            std_sections.target='_self';
                            std_sections.action='students_requests';
                            std_sections.submit();">
                            <li>...change of level</li>
                        </a><?php
                    }?>

                    <!--<a href="#" style="text-decoration:none;" 
                        onclick="in_progress('1');
                        std_sections.side_menu_no.value='change_of_programme';
                        std_sections.target='_self';
                        std_sections.action='students_requests';
                        std_sections.submit();
                        return false;">
                        <li>...change of programme</li>
                    </a>-->
                    <a href="#" style="text-decoration:none;" 
                        onclick="in_progress('1');
                        std_sections.side_menu_no.value='change_of_study_centre';
                        std_sections.target='_self';
                        std_sections.action='students_requests';
                        std_sections.submit();
                        return false;">
                        <li>...change of Study Centre</li>
                    </a>
                    <!--<a href="#" style="text-decoration:none;" 
                        onclick="in_progress('1');
                        std_sections.side_menu_no.value='passport_upload';
                        std_sections.target='_self';
                        std_sections.action='students_requests';
                        std_sections.submit();
                        return false;">
                        <li>...passport upload</li>
                    </a>
                    <a href="#" style="text-decoration:none;" 
                        onclick="in_progress('1');
                        std_sections.side_menu_no.value='transcript';
                        std_sections.target='_self';
                        std_sections.action='students_requests';
                        std_sections.submit();
                        return false;">
                        <li>...transcript</li>
                    </a>-->
                </ul>
            </li><?php
        }
    }else
    {?>
        <li class="dul_li">Request closed</li><?php
    }?>
</ul>


<ul id="course_menu" class="side_menu" style="display:<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '5'){echo 'block';}else{echo 'none';}?>">
    <li class="li_submenu_header"> Sub-menu items</li><?php
    
    if ((((!is_bool(strpos($cProgrammeId_loc, "CHD")) || 
    (!is_bool(strpos($cProgrammeId_loc, "DEG")))) && $reg_open_cert <> 1) || 
    (is_bool(strpos($cProgrammeId_loc, "CHD")) && is_bool(strpos($cProgrammeId_loc, "DEG")) && $reg_open <> 1)) && get_active_request(1) <> 1)
    {?>
        <li class="dul_li">Register courses - Closed</li><?php
    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'register_courses')
    {?>
        <li class="dul_li">Register courses</li><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
        onclick="lib_js('5','register_courses','_self','register_courses');">
        <li>Register courses</li>
        </a><?php
    }

    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'see_course_registration_slip')
    {?>
        <li class="dul_li">See course registration slip</li><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('5','see_course_registration_slip','_self','see_course_registration_slip');">
            <li title="Contains a list of currently registered courses">See course registration slip</li>
        </a><?php
    }
    
    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'see_all_registered_courses')
    {?>
        <li class="dul_li">See all registered courses</li><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('5','see_all_registered_courses','_self','see_all_registered_courses');">
            <li>See all registered courses</li>
        </a><?php
    }

    /*$stmt_last = $mysqli->prepare("SELECT vMatricNo FROM matno_reg_24 WHERE vMatricNo = ?");
    $stmt_last->bind_param("s", $_REQUEST["vMatricNo"]);
    $stmt_last->execute();
    $stmt_last->store_result();
    $stmt_last->bind_result($stid);
    $stmt_last->fetch();
    $stmt_last->close();*/

    if ($cEduCtgId_loc <> 'PGZ' && $cEduCtgId_loc <> 'PRX' && is_bool(strpos($cProgrammeId_loc, "DEG")) && is_bool(strpos($cProgrammeId_loc, "CHD")))
    {
        /*if (!is_null($stid))
        {?>
            <li class="dul_li">Register courses for exam</li><?php
        }else*/ if ($reg_open <> 1 && get_active_request(4) <> 1)
        {?>
            <li class="dul_li">Register courses for exam - Closed</li><?php
        }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'register_courses_for_exam')
        {?>
            <li class="dul_li">Register courses for exam</li><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('5','register_courses_for_exam','_self','register_courses_for_exam');">
                <li>Register courses for exam</li>
            </a><?php 
        }
    }

     
    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'see_exam_registration_slip')
    {?>
        <li class="dul_li">See exam registration slip</li><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('5','see_exam_registration_slip','_self','see_exam_registration_slip');">
            <li>See exam registration slip</li>
        </a><?php
    }
     

    //if (is_bool(strpos($cProgrammeId_loc, "DEG")) && is_bool(strpos($cProgrammeId_loc, "CHD")))
    //{
        if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'see_all_registered_exams')
        {?>
            <li class="dul_li">See all registered courses for exam</li><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('5','see_all_registered_exams','_self','see_all_registered_exams');">
                <li>See all registered courses for exams</li>
            </a> <?php
        }
        
        //if ($cFacultyId_loc  == 'SCI')
        //{
            if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'choose_centre_for_practicals')
            {?>
                <li class="dul_li">Choose centre for practicals</li><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="lib_js('5','choose_centre_for_practicals','_self','choose_centre_for_practicals');">
                    <li>Choose centre for practicals</li>
                </a> <?php
            }
        //}
    //}
    
    if ($cEduCtgId_loc <> 'PGZ' && $cEduCtgId_loc <> 'PRX'  && is_bool(strpos($cProgrammeId_loc, "DEG")) && is_bool(strpos($cProgrammeId_loc, "CHD")) && $orgsetins['cShowtt'] == '1')
    {
        if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'personal_timetable')
        {?>    
            <li class="dul_li">Examination timetable</li><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('5','personal_timetable','_self','examinations_in_noun');">
                <li style="margin-top:15px">Examination timetable</li>
            </a><?php
        }
    }?>   
</ul>


<ul id="lib_menu" class="side_menu" style="display:<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '7'){echo 'block';}else{echo 'none';}?>">
    <li class="li_submenu_header"> Sub-menu items</li>     
    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Agriculture Sciences
        <ul style="list-style:none"> 
            <a href="https://login.research4life.org/tacsgr1portal_research4life_org/content/agora" style="text-decoration:none;" target="_blank" title="NIE658 26379">
                <li>RESEARCH4LIFE AGORA</li>
            </a>
        </ul>
    </li>

    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Arts
        <ul style="list-style:none"> 
            <a href="http://www.jstor.org" style="text-decoration:none;" target="_blank" title="Library.Jstor@noun.edu.ng learning1">
                <li>JSTOR</li>
            </a>
            <a href="https://login.research4life.org/tacsgr1portal_research4life_org/content/oare_in.cshtml" style="text-decoration:none;"style="text-decoration:none;" target="_blank" title="NIE658 26379, library@noun.edu.ng nounlibrary">
                <li>RESEARCH4LIFE OARE</li>
            </a>
        </ul>
    </li>

    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Management Sciences
        <ul style="list-style:none"> 
            <a href="http://www.jstor.org" style="text-decoration:none;" target="_blank" title="Library.Jstor@noun.edu.ng learning1">
                <li>JSTOR</li>
            </a>
            <a href="https://login.research4life.org/tacsgr1portal_research4life_org/content/oare" style="text-decoration:none;"style="text-decoration:none;" target="_blank" title="NIE658 26379, library@noun.edu.ng nounlibrary">
                <li>RESEARCH4LIFE OARE</li>
            </a>
        </ul>
    </li>

    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Science
        <ul style="list-style:none"> 
            <a href="https://www.scienedirect.com" style="text-decoration:none;" target="_blank" title="library@noun.edu.ng nounlibrary@2023">
                <li>JSTOR</li>
            </a>
            <a href="https://login.research4life.org/tacsgr1portal_research4life_org" style="text-decoration:none;"style="text-decoration:none;" target="_blank" title="NIE658 26379">
                <li>RESEARCH4LIFE ARD I</li>
            </a>
        </ul>
    </li>

    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Social Sciences
        <ul style="list-style:none"> 
            <a href="https://www.jstor.org" style="text-decoration:none;" target="_blank" title="Library.Jstor@noun.edu.ng learning1">
                <li>JSTOR</li>
            </a>
            <a href="https://login.research4life.org/tacsgr1portal_research4life_org/content/hinari" style="text-decoration:none;"style="text-decoration:none;" target="_blank" title="NIE658 26379">
                <li>Hinari</li>
            </a>
            <a href="https://elibrary.imf.org" style="text-decoration:none;"style="text-decoration:none;" target="_blank" title="Library@noun.edu.ng Nounlibrary@2023">
                <li>IMF e-Library (OERDB)</li>
            </a>
        </ul>
    </li>    

    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Education
        <ul style="list-style:none"> 
            <a href="https://www.scienedirect.com" style="text-decoration:none;" target="_blank" title="Library.Jstor@noun.edu.ng learning1">
                <li>JSTOR</li>
            </a>
            <a href="https://www.scopus.com" style="text-decoration:none;"style="text-decoration:none;" target="_blank" title="Library@noun.edu.ng nounlibrary@2023">
                <li>Scopus</li>
            </a>
        </ul>
    </li>   

    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Health Sciences
        <ul style="list-style:none"> 
        <a href="https://login.research4life.org/tacsgr1portal_research4life_org/content/hinari" style="text-decoration:none;"style="text-decoration:none;" target="_blank" title="NIE658 26379">
                <li>Hinari</li>
            </a>
        </ul>
    </li>  

    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">All Faculties
        <ul style="list-style:none"> 
            <a href="https://search.ebscohost.com" style="text-decoration:none;"style="text-decoration:none;" target="_blank" title="Noun LIB2023!">
                <li>EBSCOhost</li>
            </a>
            <a href="https://www.proquest.com/?accountid=194157" style="text-decoration:none;"style="text-decoration:none;" target="_blank" title="AcetelNoun Research@123">
                <li>ProQuest</li>
            </a>
        </ul>
    </li>
</ul>


<ul id="ass_menu" class="side_menu" style="display:<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '8'){echo 'block';}else{echo 'none';}?>">
    <li class="li_submenu_header"> Sub-menu items</li>
    <a href="#" style="text-decoration:none;" 
        onclick="lib_js('8','abuot_tma','_self', 'examinations_in_noun');">
        <li>About TMA</li>
    </a>

    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Examination
        <ul style="list-style:none">            
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('8','abuot_exam','_self','examinations_in_noun');">
                <li>About Examination</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('8','personal_timetable','_self','examinations_in_noun');">
                <li>Examination timetables</li>
            </a>
        </ul>
    </li> 
    <!-- <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Authentic Assessment
        <ul style="list-style:none">            
            <a href="#" style="text-decoration:none;" 
                onclick="myhome.top_menu_no.value='10';myhome.side_menu_no.value='seminar';myhome.submit(); return false">
                <li>Seminar</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value=1;pgprgs.side_menu_no.value='19';pgprgs.submit(); return false">
                <li title="Seminar, SIWES, Research project, Internship and Practicum">Practicals</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="myhome.top_menu_no.value='10';myhome.side_menu_no.value='siwess';myhome.submit(); return false">
                <li>SIWESS</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="myhome.top_menu_no.value='10';myhome.side_menu_no.value='research_project';myhome.submit(); return false">
                <li>Research project</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="myhome.top_menu_no.value='10';myhome.side_menu_no.value='internship';myhome.submit(); return false">
                <li>Internship</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="myhome.top_menu_no.value='10';myhome.side_menu_no.value='practicum';myhome.submit(); return false">
                <li>Practicum</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="myhome.top_menu_no.value='10';myhome.side_menu_no.value='teaching_practice';myhome.submit(); return false">
                <li>Teaching practice</li>
            </a>
        </ul>
    </li> -->

    <a href="#" style="text-decoration:none;" 
        onclick="lib_js('8','seminar','_self', 'orientation_on_assessment');">
        <li>Seminar</li>
    </a>
    <!--<a href="#" style="text-decoration:none;" 
        onclick="lib_js('8','practicals','_self', 'orientation_on_assessment');">
        <li>Practicals</li>
    </a>--><?php

    $stmt = $mysqli->prepare("SELECT tsiwess_tcu FROM programme WHERE cProgrammeId = 'cProgrammeId_loc'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($tsiwess_tcu);
    $stmt->fetch();
    $stmt->close();
    if ($tsiwess_tcu == 0)
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('8','siwes','_self', 'orientation_on_assessment');" title="Student Industrial Work Experience Scheme">
            <li>SIWESS</li>
        </a><?php
    }?>
    <a href="#" style="text-decoration:none;" 
        onclick="lib_js('8','research_project','_self', 'orientation_on_assessment');">
        <li>Research project</li>
    </a>
    <!-- <a href="#" style="text-decoration:none;" 
        onclick="lib_js('8','internship','_self', 'orientation_on_assessment');">
        <li>Internship</li>
    </a>--><?php 
    
    if ($cFacultyId_loc == 'HSC' || $vProgrammeDesc_loc == 'Educational Administration')
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('8','practicum','_self', 'orientation_on_assessment');">
            <li>Practicum</li>
        </a><?php
    }
    
    if ($cFacultyId_loc == 'EDU')
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('8','teaching_practice','_self', 'orientation_on_assessment');">
            <li>Teaching practice</li>
        </a><?php
    }?>
</ul>


<ul id="tech_menu" class="side_menu" style="display:<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '10'){echo 'block';}else{echo 'none';}?>">
    <li class="li_submenu_header"> Sub-menu items</li><?php 
    if (foriegn_rs() <> '0')
    {?>
        <!-- <a href="#" style="text-decoration:none;" 
            onclick="std_sections.action='welcome_student';
                std_sections.target='_self';
                std_sections.top_menu_no.value='10';
                std_sections.side_menu_no.value='course_adviser';
                in_progress('1');
                std_sections.submit(); return false">
            <li>Course adviser</li>
        </a> -->
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('10','counselling','_self','welcome_student');">
            <li>Counselling</li>
        </a>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('10','bursary','_self','welcome_student');">
            <li>Bursary</li>
        </a>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('10','registry','_self','welcome_student');">
            <li>Registry</li>
        </a>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('10','library','_self','welcome_student');">
            <li>Library</li>
        </a>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('10','mis','_self','welcome_student');">
            <li>ICT</li>
        </a><?php
    }?>

    <a href="https://support.nou.edu.ng/" style="text-decoration:none;" target="_blank">
        <li>Drop a complaint (e-Ticketing)</li>
    </a>    
</ul>