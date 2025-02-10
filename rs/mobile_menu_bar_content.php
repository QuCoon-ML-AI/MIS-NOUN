<div id="m_menu_div" class="data_line data_line_logout" 
    style="padding:0px; 
    height:auto; 
    border-top:1px solid #b6b6b6; 
    border-bottom:1px solid #b6b6b6; 
    margin-top:5px; 
    justify-content:space-between;
    <?php if (isset($_REQUEST['side_menu_no']) && $_REQUEST['side_menu_no'] == '' && isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] <> '')
    {?>
        display:flex;<?php 
    }else{?>
        display:none<?php
    }?>"><?php
    if (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '1')
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none; border-radius:0px; background-color:#ebebeb">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                Orientation</button>
        </div><?php
    }else 
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="std_sections.action='welcome_student';
                std_sections.top_menu_no.value=1;
                std_sections.side_menu_no.value='';
				std_sections.target='_self';
                in_progress('1');
                std_sections.submit(); return false">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                Orientation</button>
        </div><?php
    }

    //department
    /*if (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '2')
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none; border-radius:0px; background-color:#ebebeb">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                My department</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="std_sections.action='welcome_student';
                std_sections.top_menu_no.value=2;
                std_sections.side_menu_no.value='';
				std_sections.target='_self';
                in_progress('1');
                std_sections.submit();
                return false">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                My department</button>
        </div><?php
    }*/

    

    $stmt_grad_mat_list = $mysqli->prepare("SELECT vMatricNo
    FROM s_m_t_grad_mat_list
    WHERE LEFT(vMatricNo,12) = ?");
    $stmt_grad_mat_list->bind_param("s", $_REQUEST["vMatricNo"]);
    $stmt_grad_mat_list->execute();
    $stmt_grad_mat_list->store_result();
    $stmt_grad_mat_list->bind_result($grad_mat);
    $stmt_grad_mat_list->fetch();
    $stmt_grad_mat_list->close();

    //bursary
    if (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '3')
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none; border-radius:0px; background-color:#ebebeb">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                Bursary</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="std_sections.action='welcome_student';
                std_sections.top_menu_no.value=3;
                std_sections.side_menu_no.value='';
				std_sections.target='_self';
                in_progress('1');
                std_sections.submit(); return false">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                Bursary</button>
        </div><?php
    }

    //Registry
    if (!is_null($grad_mat) || (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '4'))
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none; border-radius:0px; background-color:#ebebeb">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                Registry</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="std_sections.action='welcome_student';
                std_sections.top_menu_no.value=4;
                std_sections.side_menu_no.value='';
				std_sections.target='_self';
                in_progress('1');
                std_sections.submit(); return false">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                Registry</button>
        </div><?php
    }

    //My courses
    if (!is_null($grad_mat) || (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '5'))
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none; border-radius:0px; background-color:#ebebeb">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                My courses</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="std_sections.action='welcome_student';
                std_sections.top_menu_no.value=5;
                std_sections.side_menu_no.value='';
				std_sections.target='_self';
                in_progress('1');
                std_sections.submit(); 
                return false">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                My courses</button>
        </div><?php
    }
   
    
    //My learning space
    if (!is_null($grad_mat) || (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '6'))
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none; border-radius:0px; background-color:#ebebeb">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                My learning space</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="std_sections.action='welcome_student';
                std_sections.top_menu_no.value=6;
                std_sections.side_menu_no.value='';
				std_sections.target='_self';
                in_progress('1');
                std_sections.submit(); 
                return false">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                My learning space</button>
        </div><?php
    }
   
    //Library
    if (!is_null($grad_mat) || (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '7'))
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none; border-radius:0px; background-color:#ebebeb">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                Library</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="std_sections.action='welcome_student';
                std_sections.top_menu_no.value=7;
                std_sections.side_menu_no.value='';
				std_sections.target='_self';
                in_progress('1');
                std_sections.submit(); return false">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                Library</button>
        </div><?php
    }
    
    
    //Assessment
    if ($cEduCtgId_loc <> 'ELX')
    {
        if (!is_null($grad_mat) || (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '8'))
        {?>
            <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
                <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none; border-radius:0px; background-color:#ebebeb">
                    <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                    Assessment</button>
            </div><?php
        }else
        {?>
            <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
                <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                    onclick="std_sections.action='welcome_student';
                    std_sections.top_menu_no.value=8;
                    std_sections.side_menu_no.value='';
                    std_sections.target='_self';
                    in_progress('1');
                    std_sections.submit();
                    return false">
                    <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                    Assessment</button>
            </div><?php
        }
    }


    //My progress
    if (!is_null($grad_mat) || (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '9'))
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none; border-radius:0px; background-color:#ebebeb">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                My progress</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="std_sections.action='welcome_student';
                std_sections.top_menu_no.value='9';
                std_sections.side_menu_no.value='';
				std_sections.target='_self';
                in_progress('1');
                std_sections.submit(); return false">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                My progress</button>
        </div><?php
    }


    //Support
    if (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '10')
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none; border-radius:0px; background-color:#ebebeb">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                Support</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="  " class="button mm2_button"  style="padding:7px; border:none" 
                onclick="std_sections.action='welcome_student';
                std_sections.top_menu_no.value='10';
                std_sections.side_menu_no.value='';
				std_sections.target='_self';
                in_progress('1');
                std_sections.submit(); return false">
                <!-- <img width="25" height="22" src="<?php echo BASE_FILE_NAME_FOR_IMG;?>home.png" alt="Home"><br> -->
                Support</button>
        </div><?php
    }?>
</div>

<div id="general_smke_screen" class="smoke_scrn" style="display:none; z-index:-1"></div>

<div id="general_smke_screen" class="smoke_scrn" style="display:none; z-index:-1"></div><?php 
if ($iStudy_level_loc <= 200)
{
    $reg_open = $reg_open_100_200;
}else
{
    $reg_open = $reg_open_300;
}

//if ($reg_open == 1 || get_active_request(0) == 1)
if (((!is_bool(strpos($cProgrammeId_loc, "CHD")) || 
(!is_bool(strpos($cProgrammeId_loc, "DEG")))) && $reg_open_cert == 1) || 
(is_bool(strpos($cProgrammeId_loc, "CHD")) && is_bool(strpos($cProgrammeId_loc, "DEG")) && $reg_open == 1) || get_active_request(0) == 1)
{
    if (isset($semester_reg_loc) && $semester_reg_loc == '0')
    {?>
        <ul id="home_menu" class="side_menu" 
            style="margin-top:15px; 
            display:<?php if (!isset($_REQUEST["top_menu_no"]) || (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '')){echo 'block';}else{echo 'none';}?>"><?php
            if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'semester_registration')
            {?>
                <li class="dul_li">Register for the semester</li><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="std_sections.top_menu_no.value='';
                    std_sections.side_menu_no.value='semester_registration';
                    std_sections.action='welcome_student';
                    in_progress('1');
                    std_sections.submit();
                    return false;">
                    <li>Register for the semester</li>
                </a><?php
            }?>
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


<ul id="orient_menu" class="side_menu" style="display:<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '1'){echo 'block';}else{echo 'none';}?>; background-color:#ebebeb">
    <a href="#" style="text-decoration:none;" 
        onclick="lib_js('1','acad_cal','_self', 'university_structure');">
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
    
    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Hear from the...
        <ul style="list-style:none">
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','from_vc','_self', 'university_structure');">
                <li>Vice Chancellor</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','from_reg','_self', 'university_structure');">
                <li>Registrar</li>
            </a>            
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','from_bursar','_self', 'university_structure');">
                <li>Bursar</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','from_lib','_self', 'university_structure');">
                <li>Librarian</li>
            </a>
            
        </ul>
    </li>
        
    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');" title="Meet the Deputy Vice Chancellors (DVC)">Meet the DVCs
        <ul style="list-style:none">
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','from_dvcacad','_self', 'university_structure');">
                <li>DVC Academic </li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','from_dvcadmin','_self', 'university_structure');">
                <li>DVC Adminstration </li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('1','from_dvctir','_self', 'university_structure');" title="TIR = Innovation Technology and Research">
                <li>DVC Tech. Innovation and Research </li>
            </a>
        </ul>
    </li>
        
    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">My learning environment
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
        
    <!--<li style="list-style: inside url('<?php //echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Assessment
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
    </li>
        
    <li style="list-style: inside url('<?php //echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Learner support
        <ul style="list-style:none">                
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
</ul>

   
<!--<ul id="dept_menu" class="side_menu" style="display:<?php //if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '2'){echo 'block';}else{echo 'none';}?>; background-color:#ebebeb">
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
</ul>-->


<ul id="burs_menu" class="side_menu" style="display:<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '3'){echo 'block';}else{echo 'none';}?>; background-color:#ebebeb"><?php
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
    
    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'make_payment')
    {?>
        <li class="dul_li">Make payment</li><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="lib_js('3','make_payment','_self','make-payment');">
            <li>Make payment</li>
        </a><?php
    }
    
    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'check_payment_status')
    {?>
        <li class="dul_li">Check payment status</li><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="std_sections.action='check_state_of_transaction';
                std_sections.side_menu_no.value='check_payment_status';
                std_sections.target='_self';
                in_progress('1');
                std_sections.submit(); return false">
            <li>Check payment status</li>
        </a><?php
    }
    
    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'my_bank_detail')
    {?>
        <li class="dul_li">My bank detail</li><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="std_sections.side_menu_no.value='my_bank_detail';
                std_sections.action='update_bank_detail';
                std_sections.target='_self';
                in_progress('1');
                std_sections.submit();
                return false">
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
            onclick="std_sections.side_menu_no.value='final_year_clearance';
            std_sections.action='final_year_clearance';
            std_sections.target='_self';
            in_progress('1');
            std_sections.submit();
            return false;">
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
                onclick="std_sections.side_menu_no.value='pay_convocation_gown';
                in_progress('1');
                std_sections.request_id.value='1';
                std_sections.vDesc.value='Convocation gown';
                std_sections.action='pay_for_convocation_gown';
                std_sections.target='_self';
                std_sections.submit();
                return false;">
                <li>Pay for convocation gown</li>
            </a><?php
        }
    }
             
    /*$stmt_s_tranxion = $mysqli->prepare("SELECT amount
    FROM s_tranxion_cr
    WHERE fee_item_id = '31' 
    AND vMatricNo = ?");
    $stmt_s_tranxion->bind_param("s", $_REQUEST["vMatricNo"]);

    $stmt_s_tranxion->execute();
    $stmt_s_tranxion->store_result();
    $stmt_s_tranxion->bind_result($s_conv_amount);
    $stmt_s_tranxion->fetch();
    $stmt_s_tranxion->close();
    
    $s_conv_amount = $s_conv_amount ?? 0;
    
    if (isset($grad) && $grad <> '0' && $s_conv_amount == 0)
    {   
        if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'pay_convocation_gown')
        {?>
            <li class="dul_li">Pay for convocation gown</li><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;"
            title="For final year student only" 
                onclick="std_sections.side_menu_no.value='pay_convocation_gown';
                in_progress('1');
                std_sections.request_id.value='1';
                std_sections.vDesc.value='Convocation gown';
                std_sections.action='pay_for_convocation_gown';
                std_sections.target='_self';
                std_sections.submit();
                return false;">
                <li>Pay for convocation gown</li>
            </a><?php
        }
    }*/?>
</ul>

<ul id="reg_menu" class="side_menu" style="display:<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '4'){echo 'block';}else{echo 'none';}?>; background-color:#ebebeb"><?php
     if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'change_password')
     {?>
         <li class="dul_li">Change password</li><?php
     }else
     {?>
        <a href="#" style="text-decoration:none;" 
            onclick="std_sections.side_menu_no.value='change_password';
            std_sections.action='change_password';
            std_sections.target='_self';
            in_progress('1');
            std_sections.submit();
            return false;">
            <li>Change password</li>
        </a><?php
     } 
     
     if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'see_application_record')
     {?>
         <li class="dul_li">See application record</li><?php
     }else
     {?>
        <a href="#" style="text-decoration:none;" 
            onclick="std_sections.side_menu_no.value='see_application_record';
            std_sections.action='see_application_record';
            std_sections.target='_self';
            in_progress('1');
            std_sections.submit();return false;">
            <li>See application record</li>
        </a><?php
     } 
     
     if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'update_bio_data')
     {?>
         <li class="dul_li">Update bio-data</li><?php
     }else
     {?>
        <a href="#" style="text-decoration:none;" 
            onclick="std_sections.side_menu_no.value='update_bio_data';
            std_sections.action='update_bio_data';
            std_sections.target='_self';
            in_progress('1');
            std_sections.submit();
            return false">
            <li>Update bio-data</li>
        </a><?php
     }
     
     if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'print_identity_card')
     {?>
         <li class="dul_li">Print identity card</li><?php
     }else
     {?>
        <a href="#" style="text-decoration:none;" 
            onclick="std_sections.side_menu_no.value='print_identity_card';
            std_sections.action='print_identity_card';
            std_sections.target='_blank';
            std_sections.submit();
            return false;">
            <li>Print identity card</li>
        </a><?php
     }?>

    <!--<li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Request for...
        <ul style="list-style:none"> 
            <a href="#" style="text-decoration:none;" 
                onclick="in_progress('1');
                std_sections.side_menu_no.value='change_of_name';
                std_sections.action='students_requests';
                std_sections.submit();">
                <li>...change of name</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="in_progress('1');
                std_sections.side_menu_no.value='change_of_level';
                std_sections.target='_self';
                std_sections.action='students_requests';
                std_sections.submit();">
                <li>...change of level</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="in_progress('1');
                std_sections.side_menu_no.value='change_of_programme';
                std_sections.target='_self';
                std_sections.action='students_requests';
                std_sections.submit();
                return false;">
                <li>...change of programme</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="in_progress('1');
                std_sections.side_menu_no.value='change_of_study_centre';
                std_sections.target='_self';
                std_sections.action='students_requests';
                std_sections.submit();
                return false;">
                <li>...change of Study Centre</li>
            </a>
            <a href="#" style="text-decoration:none;" 
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
            </a>            
        </ul>
    </li>-->
</ul>


<ul id="course_menu" class="side_menu" style="display:<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '5'){echo 'block';}else{echo 'none';}?>; background-color:#ebebeb"><?php
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
        onclick="std_sections.side_menu_no.value='register_courses';
        std_sections.action='register_courses';
        std_sections.target='_self';
        in_progress('1');
        std_sections.submit();
        return false;">
        <li>Register courses</li>
    </a><?php
    }

    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'see_course_registration_slip')
    {?>
        <li class="dul_li">See course registration slip</li><?php
    }else
    {?>
    <a href="#" style="text-decoration:none;" 
        onclick="std_sections.side_menu_no.value='see_course_registration_slip';
        std_sections.action='see_course_registration_slip';
        std_sections.target='_self';
        in_progress('1');
        std_sections.submit();
        return false;">
        <li title="Contains a list of currently registered courses">See course registration slip</li>
    </a><?php
    }
    
    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'see_all_registered_courses')
    {?>
        <li class="dul_li">See all registered courses</li><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="std_sections.side_menu_no.value='see_all_registered_courses';
            std_sections.action='see_all_registered_courses';
            std_sections.target='_self';
            in_progress('1');
            std_sections.submit();
            return false;">
            <li>See all registered courses</li>
        </a><?php
    }


    if ($orgsetins['cShowrslt'] == '1')
    {
        if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'see_last_semester_result')
        {?>
            <li class="dul_li">See last semester result</li><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="std_sections.side_menu_no.value='see_last_semester_result';
                std_sections.action='see_last_semester_result';
                std_sections.target='_self';
                in_progress('1');
                std_sections.submit();
                return false;">
                <li>See last semester result</li>
            </a><?php
        }
    }

    if (is_bool(strpos($cProgrammeId_loc, "CHD")) && is_bool(strpos($cProgrammeId_loc, "DEG")))
    {
        if ($reg_open <> 1 && get_active_request(0) <> 1)
        {?>
            <li class="dul_li">Register courses for exam - Closed</li><?php
        }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'register_courses_for_exam')
        {?>
            <li class="dul_li">Register courses for exam</li><?php
        }else
        {?>
        <a href="#" style="text-decoration:none;" 
            onclick="std_sections.side_menu_no.value='register_courses_for_exam';
            std_sections.action='register_courses_for_exam';
            std_sections.target='_self';
            in_progress('1');
            std_sections.submit();
            return false;">
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
        onclick="std_sections.side_menu_no.value='see_exam_registration_slip';
            std_sections.action='see_exam_registration_slip';
            std_sections.target='_self';
            in_progress('1');
            std_sections.submit();
            return false;">
        <li>See exam registration slip</li>
    </a><?php
    }
    
    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'see_all_registered_exams')
    {?>
        <li class="dul_li">See all registered courses for exam</li><?php
    }else
    {?>
    <a href="#" style="text-decoration:none;" 
        onclick="std_sections.side_menu_no.value='see_all_registered_exams';
        std_sections.action='see_all_registered_exams';
        std_sections.target='_self';
        in_progress('1');
        std_sections.submit();
        return false;">
        <li>See all registered courses for exam</li>
    </a> <?php
    }
    
    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'choose_centre_for_practicals')
    {?>
        <li class="dul_li">Choose centre for practicals</li><?php
    }else
    {?>
    <a href="#" style="text-decoration:none;" 
        onclick="std_sections.side_menu_no.value='choose_centre_for_practicals';
        std_sections.action='choose_centre_for_practicals';
        std_sections.target='_self';
        in_progress('1');
        std_sections.submit();
        return false;">
        <li>Choose centre for practicals</li>
    </a> <?php
    }?>   
</ul>


<ul id="lib_menu" class="side_menu" style="display:<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '7'){echo 'block';}else{echo 'none';}?>; background-color:#ebebeb">     
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

    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">All faculties
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


<ul id="ass_menu" class="side_menu" style="display:<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '8'){echo 'block';}else{echo 'none';}?>; background-color:#ebebeb"><?php
    /*if ($tma_open <> 1)
    {?>
        <li class="dul_li">TMA - Closed</li><?php
    }else
    {*/?>
        <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');"> Tutor marked assignment (TMA)
            <ul style="list-style:none">            
                <a href="#" style="text-decoration:none;" 
                    onclick="lib_js('8','abuot_tma','_self', 'examinations_in_noun');">
                    <li>About TMA</li>
                </a>
                <!--<a href="#" style="text-decoration:none;" 
                    onclick="myhome.top_menu_no.value='10';myhome.side_menu_no.value='tma2';myhome.submit(); return false">
                    <li>TMA2</li>
                </a>
                <a href="#" style="text-decoration:none;" 
                    onclick="myhome.top_menu_no.value='10';myhome.side_menu_no.value='tma3';myhome.submit(); return false">
                    <li>TMA3</li>
                </a>-->
            </ul>
        </li><?php
    //}?>
    
    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Examination
        <ul style="list-style:none">            
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('8','personal_timetable','_self','examinations_in_noun');">
                <li>Examination timetable</li>
            </a>
            <!--<a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value='10';pgprgs.side_menu_no.value=2;pgprgs.submit(); return false">
                <li>Request for virtual exam</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.top_menu_no.value='10';pgprgs.side_menu_no.value=3;pgprgs.submit(); return false">
                <li>Take exam</li>
            </a>-->        
        </ul>
    </li> 
    <li style="list-style: inside url('<?php echo BASE_FILE_NAME_FOR_IMG;?>submenu_icon.png');">Authentic Assessment
        <ul style="list-style:none">            
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('8','seminar','_self', 'orientation_on_assessment');">
                <li>Seminar</li>
            </a><?php

            $stmt = $mysqli->prepare("SELECT tsiwess_tcu FROM programme WHERE cProgrammeId = 'cProgrammeId_loc'");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($tsiwess_tcu);
            $stmt->fetch();
            $stmt->close();
            if ($tsiwess_tcu == 0)
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="lib_js('8','siwes','_self', 'orientation_on_assessment');">
                    <li>SIWESS</li>
                </a><?php
            }?>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('8','research_project','_self', 'orientation_on_assessment');">
                <li>Research project</li>
            </a>
            <!--<a href="#" style="text-decoration:none;" 
                onclick="myhome.top_menu_no.value='10';myhome.side_menu_no.value='internship';myhome.submit(); return false">
                <li>Internship</li>
            </a>-->
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('8','practicum','_self', 'orientation_on_assessment');">
                <li>Practicum</li>
            </a>
            <a href="#" style="text-decoration:none;" 
                onclick="lib_js('8','teaching_practice','_self', 'orientation_on_assessment');">
                <li>Teaching practice</li>
            </a>
        </ul>
    </li>
</ul>


<ul id="tech_menu" class="side_menu" style="display:<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '10'){echo 'block';}else{echo 'none';}?>; background-color:#ebebeb">   
    <!--<a href="#" style="text-decoration:none;" 
        onclick="std_sections.action='welcome_student';
            std_sections.target='_self';
            std_sections.top_menu_no.value='10';
            std_sections.side_menu_no.value='course_adviser';
            in_progress('1');
            std_sections.submit(); return false">
        <li>Course adviser</li>
    </a>-->
    <a href="#" style="text-decoration:none;" 
        onclick="std_sections.action='welcome_student';
            std_sections.target='_self';
            std_sections.top_menu_no.value='10';
            std_sections.side_menu_no.value='counselling';
            in_progress('1');
            std_sections.submit(); return false">
        <li>Counselling</li>
    </a>
    <a href="#" style="text-decoration:none;" 
        onclick="std_sections.action='welcome_student';
            std_sections.target='_self';
            std_sections.top_menu_no.value='10';
            std_sections.side_menu_no.value='bursary';
            in_progress('1');
            std_sections.submit(); return false">
        <li>Bursary</li>
    </a>
    <a href="#" style="text-decoration:none;" 
        onclick="std_sections.action='welcome_student';
            std_sections.target='_self';
            std_sections.top_menu_no.value='10';
            std_sections.side_menu_no.value='registry';
            in_progress('1');
            std_sections.submit(); return false">
        <li>Registry</li>
    </a>
    <a href="#" style="text-decoration:none;" 
        onclick="std_sections.action='welcome_student';
            std_sections.target='_self';
            std_sections.top_menu_no.value='10';
            std_sections.side_menu_no.value='library';
            in_progress('1');
            std_sections.submit(); return false">
        <li>Library</li>
    </a>
    <a href="#" style="text-decoration:none;" 
        onclick="std_sections.action='welcome_student';
            std_sections.target='_self';
            std_sections.top_menu_no.value='10';
            std_sections.side_menu_no.value='mis';
            in_progress('1');
            std_sections.submit(); return false">
        <li>MIS</li>
    </a>
    <a href="https://support.nou.edu.ng" target="_blank" style="text-decoration:none;">
        <li>Drop a complaint (e-Ticketing)</li>
    </a>    
</ul>