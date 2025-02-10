<?php
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
		<link rel="icon" type="image/ico" href="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" />
		<script language="JavaScript" type="text/javascript" src="<?php echo BASE_FILE_NAME;?>js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE_FILE_NAME;?>styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/n_phyl.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_side_menu.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
	    $mysqli = link_connect_db();

        $orgsetins = settns();

        $tSemester_rsg = '';
        $iStudy_level_rsg = '';
        $cResidenceCountryId_rsg = '';

        /*if (isset($_REQUEST["reg_sem"]) && $_REQUEST["reg_sem"] == '1')
        {
            $stmt = $mysqli->prepare("SELECT tSemester, iStudy_level, cResidenceCountryId
            from s_m_t
            where vMatricNo = ?");
            $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($tSemester_rsg, $iStudy_level_rsg, $cResidenceCountryId_rsg);
            $stmt->fetch();
            $stmt->close();
            
            $iStudy_level_rsg = $iStudy_level_rsg ?? '';
            $cResidenceCountryId_rsg = $cResidenceCountryId_rsg ?? '';

            register_student_global($iStudy_level_rsg, $tSemester_rsg, $_REQUEST["vMatricNo"], $cResidenceCountryId_rsg);
        }*/
        
        
        require_once(BASE_FILE_NAME."feedback_mesages.php");      
        require_once("std_detail_pg1.php");
        require_once("forms.php");

        require_once("set_scheduled_dates.php");
        require_once("token_redirect.php");
        require_once("rs_notice_board.php");
        
        $balance = 0.00;?>

        <div class="appl_container">
            <div class="appl_left_div" style="z-index:2;">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em"><?php
                    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'virtual_space')
                    {                    
                        echo "About my virtual space";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'study_centre')
                    {
                        echo "About Study Centre";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'semester_reg')
                    {
                        echo "About semester registration";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'course_reg')
                    {
                        echo "About course registration";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'exam_reg')
                    {
                        echo "About examination registration";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'mle_fac')
                    {
                        echo "About facilitation";
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
                <div id="phil_div" class="appl_left_child_div" style="width:98%; margin:auto; max-height:95%; margin-top:10px; text-align: left; overflow:auto;  background-color:#eff5f0"><?php                    
                    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'acad_cal' && isset($_REQUEST["top_menu_no"]) && ($_REQUEST["top_menu_no"] == '1' || $_REQUEST["top_menu_no"] == ''))
                    {
                        require_once("acad_cal.php");
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'virtual_space')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div class="middle_left" style="flex:15%; padding-left:4px; height:auto;"></div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>My learning space</b><p>
                                My Learning Space is an integrated system that aims to bring together all teaching and learning related activities into one interface. It connects staff and students to the leaning managment system, facilitation, submission of projects, teaching practice, students' industrial work expereince (SIWES) etc.</p>

                                Features of 'My learning space' includes the following:<br>

                               <ol>
                                    <li>
                                        Home page<br>
                                        This is the point of entry into the space. It provides the details of the user such as full names, photo, programme, faculty, department etc. It also provides navigation blocks to other sections (mentioned below) withing the learning space
                                    </li>
                                    <li>
                                        Notice baord<br>
                                        The notice board provide information to the you after loging into the learning space. All important notices announcements and guides that you need to be aware of can be accessed here. You will only see information that is relevant to your department, programmes, registered courses  and/or study centre.
                                    </li>
                                    <li>
                                        My courses<br>
                                        This section provides the navigation to the courses learning managment system where you can assess your courses online for teacihng and learning activities. Presently, all GST courses are beibg delivered on the learning space. The <b>TMAs</b> for GST and courses being facilitated online can be accessed here.
                                    </li>
                                    <li>
                                        Project Administration System (PAS)<br>
                                        The PAS provides an environemnt where you can enter the project topics and upload soft copies of competed projects. The environment also enables departments in collaboration with the Postgraduate School to coordinate the grading of the students' projects, praticum, teaching practice and seminar score by exernal and internal examiners.
                                    </li>
                                    <li>
                                        SIWES Adminstrtion System (SAS)<br>
                                        The SAS enables you to complete your registration of SIWES, if it is applicable to your programme. See detail under 'Assessment.
                                    </li>
                               </ol>
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'study_centre')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div class="middle_left" style="flex:15%; padding-left:4px; height:auto;"></div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>My Study Centre</b><p>
                                Your Study Cente as shown on the lower right of this page is the major communication channel between you and the University. It is in constant touch with you and the society at large. Learner support services thus takes place largely in your centre. The activities begin with admission and terminates with issuance of certificate of completion of studies to students</p>
                               
                                <ol>
                                    Support services carried out in your Study Cente includes
                                    <li>
                                        Admission
                                    </li>
                                    <li>
                                        Registration of courses
                                    </li>
                                    <li>
                                        Payment of fees
                                    </li>
                                    <li>
                                        Distribution of course materials
                                    </li>
                                    <li>
                                        Organization of seminars
                                    </li>
                                    <li>
                                        Facilitation
                                    </li>
                                    <li>
                                        Couseling
                                    </li>
                                    <li>
                                        Orientation and matriculation
                                    </li>
                                    <li>
                                        Teaching practice
                                    </li>
                                    <li>
                                        Practicum
                                    </li>
                                    <li>
                                        Enquiry
                                    </li>
                                    <li>
                                        Resolving complaints
                                    </li>
                                    <li>
                                        ICT technical support
                                    </li>
                                    <li>
                                        Library services etc.
                                    </li>
                                </ol>
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'semester_reg')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div class="middle_left" style="flex:15%; padding-left:4px; height:auto;"></div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Semester registration</b><p>
                                The flexibility of operation of the NOUN allows you to make payment for registration on semester basis. This puts less pressure on your finacial capacity, thereby helping you to cope better with the demands of being an ODE learner. Payment of semester based fees is tied to semster registration.That is, once you pay, you are automatically registered for the semester. Consequently, you are allowed to go ahead with other registration activiies.
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'course_reg')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div class="middle_left" style="flex:15%; padding-left:4px; height:auto;"></div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Course registration</b><p>
                                Once you are through with semester registration, you are prompted to register courses for the semster. The centre of the course registration page is divided into two section namely 'pending courses' and 'current courses' to register. If you are in the first semester of your first year, you will not see the 'pending' section. Otherwise, you may see this section if you have oustanding courses to register.</p>

                                <ol>
                                    Please note that:
                                    <li>
                                        The number of courses you are able to register is detemenied by the maximum cedit unit you can carry in the semester. It is 24 in most cases with the exception of Law students.
                                    </li>
                                    <li>
                                        Also, the number of courses you are able to register is determined by your e-wallet balance. That is, you cannot register courses to the point of having a negative balance in your e-wallet
                                    </li>
                                    <li>
                                        You can only register courses for the semester after you have registered for the semester
                                    </li>
                                    <li>
                                        Compulsory courses are maked 'C' while elective courses are marked 'E'
                                    </li>
                                    <li>
                                        Compulsory courses are pre-selected for you and you may not be able to deselect them except conditions are relaxed
                                    </li>
                                </ol>
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'exam_reg')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div class="middle_left" style="flex:15%; padding-left:4px; height:auto;"></div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Examination registration</b><p>
                                Once you are through with course registration, you can register courses for examination for the semester. Like the course registation page, the centre of the page is divided into two section namely 'pending courses' and 'current courses' to register for examination. If you are in the first semester of your first year, you will not see the 'pending' section. Otherwise, you may see this section if you have:
                                
                                <ol>                                    
                                    <li>
                                        oustanding courses to register for exam or,
                                    </li>
                                    <li>
                                        previously offered but failed courses
                                    </li>
                                </ol>

                                <ol>
                                    Please note that:
                                    <li>
                                        The number of courses you are able to register for examination is detemenied by the maximum cedit unit you can carry in the semester. It is 24 in most cases with the exception of Law students.
                                    </li>
                                    <li>
                                        Also, the number of courses you are able to register for examination is determined by your e-wallet balance. That is, you cannot register courses for examination to the point of having a negative balance in your e-wallet
                                    </li>
                                    <li>
                                        You can only register courses for examination for the semester after you have registered courses for the semester except if you have outstanding (failed) courses from previous semster
                                    </li>
                                    <li>
                                        Compulsory courses are maked 'C' while elective courses are marked 'E'
                                    </li>
                                    <li>
                                        Compulsory courses are pre-selected for you and you may not be able to deselect them except conditions are relaxed
                                    </li>
                                </ol>
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'mle_fac')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div style="text-align:center; flex:20%; height:auto;">
                                <!-- <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'vc_welcome_msg.png');?>" style="width:155px; height:180px; margin:auto;"/> -->
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>About facilitation</b>
                                
                                <p>
                                    Facilitation is helping the learner to go through structured learning experiences by an expert in a field of study, called Facilitator.
                                </p>
                                <p>
                                    A Facilitator of learning is a teacher who does not operate under the traditional concept of teaching rather, he guides and assists students in learning by themselves. Instead of teaching or lecturing, facilitation of courses is done online for students.
                                </p>
                                <p>
                                   Learning cycles or study groups amongst students are aslo encouraged.
                                </p>
                                <p>
                                    <b>Note:</b>
                                    <ol>
                                        <li>
                                            Facilitation commences as from the fourth week of a new semester with referece to the statistics of course registration from the last semester.
                                        </li>
                                        <li>
                                            Facilitation on week days cannot commence before 3:00pm (local time) while commencement time on weekends is 8:00am (local time)
                                        </li>
                                    </ol>
                                   
                                </p>
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'use_of_lib')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div style="text-align:center; flex:20%; height:auto;">
                                <!-- <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'vc_welcome_msg.png');?>" style="width:155px; height:180px; margin:auto;"/> -->
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Use of Library</b>
                                
                                <p>
                                    The library collection consists of both print and electronic resources. Similarly, the library uninterruptedly subscribes to some library databases such as lawpavilion, Jstor, Sciencedirect etc annually.
                                </p>
                                <p>
                                    Our esteemed users can access any of the libraries between the hours of 8:00 – 16:00 Monday-Friday. Meanwhile, the E-resources are available to users at their convenience. Access details can be obtained from any of the study centre libraries.
                                </p>
                                <p>
                                    Thank you for visiting our library. Kindly click [<a href="http://youtu.be/ZfKHs3TQHGw" target="_blank" style="text-decoration:none;">here</a>]  to watch the library orientation video. You can also contact us on any of the following social media handles:
                                </p>

                                <p>
                                    <ol>
                                        <li><a href="https://facebook.com/NOUNlib.ng" target="_blank" style="text-decoration:none;">facebook</a></li>
                                        <li><a href="https://instagram.com/NOUNlibrary" target="_blank" style="text-decoration:none;">Instagram</a></li>
                                        <li><a href="https://twitter.com/NOUNLIB1" target="_blank" style="text-decoration:none;">Twitter</a></li>
                                    </ol>
                                </p>
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else
                    {
                        echo "Student Home Page";
                    }
                   
                    
                    require_once ('std_bottom_right_menu.php');?>
                </div>
            </div>

            <div id="menu_bs_scrn" class="appl_far_right_div" style="z-index:2;">
                <?php build_menu_right($balance);?>
            </div>
        </div>
	</body>
</html>