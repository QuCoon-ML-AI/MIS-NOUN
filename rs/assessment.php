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
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em;">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em"><?php
                    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'seminar')
                    {
                        echo "About Seminar";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'practicals')
                    {
                        echo "About practical courses";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'siwes')
                    {
                        echo "About SIWES";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'research_project')
                    {
                        echo "About Research project";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'internship')
                    {
                        echo "About internship";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'practicum')
                    {
                        echo "About Practicum";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'teaching_practice')
                    {
                        echo "About teaching practice";
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
                <div id="phil_div" class="appl_left_child_div" style="width:75%; margin:auto; max-height:95%; margin-top:10px; text-align: left; overflow:auto;  background-color:#eff5f0"><?php                    
                    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'seminar')
                    {                        
                        if ($cFacultyId_loc == 'HSC')
                        {?> 
                            <iframe src="../ext_docs/project_report_template/hsc_revised_guide_to_seminar_in_nursing.pdf" style="width:100%; height:730px;" frameborder="0"></iframe><?php
                        }else if ($cFacultyId_loc == 'ART')
                        {?> 
                            <iframe src="../ext_docs/project_report_template/art_guidelines_on_seminar_and_project.pdf" style="width:100%; height:730px;" frameborder="0"></iframe><?php
                            if ($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY' || $cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX')
                            {?> 
                                <iframe src="../ext_docs/project_report_template/art_rubrics_pg_defence_and_sem_presentation.pdf" style="width:100%; height:730px;" frameborder="0"></iframe><?php
                            }
                        }else
                        {?>
                            <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div1').style.display=='flex')
                            {
                                _('div1').style.display='none'
                                _('div1minus').style.display='none'
                                _('div1plus').style.display='block';
                            }else
                            {
                                _('div1').style.display='flex'
                                _('div1minus').style.display='block'
                                _('div1plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    About Seminar
                                </div>
                            </div>
                            <div id="div1" class="appl_left_child_div_child" style="margin-top:-15px; display:block;">
                                <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                    Seminar is a class in the university in which a topic is presented by a person in a small group of students after which the presentation is discussed with aim of accentuating salient points, all anchored by an expert in the subject matter of discussion. Seminar is a course that must be registered by concerned students. It is a core course.
                                    
                                    <p>If you ahve one or more seminar courses to offer, you will do the following:</p>
                                    <ol>
                                        <li>
                                            Register the course and the corresponding examination (though no examination is written yet, the performance at presentation is evaluated)
                                        </li>
                                        <li>
                                            Select a topic with the consent of an assigned supervisor
                                        </li>
                                        <li>
                                            At the appointed date, you will present a paper you have written on the approved topic. Presentation will be within a stipulated time by the seminar parnel
                                        </li>
                                        <li>
                                            The seminar paper should be between 10 to 30 pages and should be...
                                            <p>
                                                <!--<a href="https://nou.edu.ng/coursewarecontent/CRD%20409%20COOPERATIVE%20SEMINAR_0.pdf" target="_blank" style="text-decoration:none; color:#eb0c27;">Read more</a>-->
                                            </p>
                                        </li>
                                    </ol>
                                    

                                    

                                    <ol>
                                        The seminar paper should be between 10 to 30 pages and should be made up of the following:
                                        <li>
                                            Introduction
                                            <ol style="list-style: lower-alpha;">
                                                <li>
                                                    General overview
                                                </li>
                                                <li>
                                                    Problem definition/research questions and study objectives 
                                                </li>
                                            </ol>
                                        </li>
                                        <li>
                                            Methodology
                                            <ol style="list-style: lower-alpha;">
                                                <li>
                                                    Research Methodology
                                                </li>
                                                <li>
                                                    Problem definition/research questions and study objectives 
                                                </li>
                                                <li>
                                                    For pure Science and Agriculture faculties:
                                                    <ol style="list-style: lower-roman;">
                                                        <li>
                                                            Design 
                                                        </li>
                                                        <li>
                                                            Implement
                                                        </li>
                                                    </ol>
                                                </li>
                                                <li>
                                                    For non-Science faculties:
                                                    <ol style="list-style:lower-roman;">
                                                        <li>
                                                            Study location (where applicable) 
                                                        </li>
                                                        <li>
                                                            Data and sampling procedure
                                                        </li>
                                                        <li>
                                                            Analytical techniques
                                                        </li>
                                                    </ol>
                                                </li>
                                            </ol>
                                        </li>
                                        <li>
                                            Results and Discussion
                                        </li>
                                        <li>
                                            Conclusion and Recommendations
                                        </li>
                                        <li>
                                            References
                                        </li>
                                    </ol>
                                    
                                    <ol>
                                        Evaluation shall be based on the following:
                                        <li>
                                            demonstrated knowledge of the topic in relation to the relevant branch of your programme
                                        </li>
                                        <li>
                                            comportment and
                                        </li>
                                        <li>
                                            communication skills
                                        </li>
                                    </ol>
                                    
                                    <ol>
                                        The objectives of the seminar course are:
                                        <li>
                                        Familiarize the students to appreciate problems and other the basic issues in Cooperative Management.
                                        </li>
                                        <li>
                                            Develop the analytical skills of students in cooperative research and field surveys 
                                        </li>
                                        <li>
                                            Develop the confidence of students in public presentations 
                                        </li>
                                        <li>
                                            Develop the written and project reporting skills of students. 
                                        </li>
                                        <li>
                                            Develop competence in statistical analyses of data 
                                        </li>
                                        <li>
                                            Develop skills in writing academic papers.
                                        </li>
                                    </ol>

                                    <!--<p>
                                        For more detail, click
                                        <a href="https://nou.edu.ng/coursewarecontent/CRD%20409%20COOPERATIVE%20SEMINAR_0.pdf" target="_blank" style="text-decoration:none">here</a>  or <a href="https://nou.edu.ng/coursewarecontent/ECO721%20PGD%20Economics%20Guideline%20for%20writing%20seminar%20correctedAugust.pdf" target="_blank" style="text-decoration:none">here</a>
                                    </p>-->
                                    You may also talk to your Supervisor for guide
                                </div>
                            </div><?php
                        }
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'practicals')
                    {
                        echo "About practical courses";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'siwes')
                    {?>
                        <div class="appl_left_child_div_child">
                            <div style="flex:100%; height:40px; line-height:2; text-indent:10px; margin-bottom:4px; background-color: #ffffff; font-weight:bold">
                                About SIWES (Student Industrial Work Experience Scheme)
                            </div>
                        </div>
                        
                        <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div1').style.display=='flex')
                            {
                                _('div1').style.display='none'
                                _('div1minus').style.display='none'
                                _('div1plus').style.display='block';
                            }else
                            {
                                _('div1').style.display='flex'
                                _('div1minus').style.display='block'
                                _('div1plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    What is SIWES?
                                </div>
                        </div>
                        <div id="div1" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                The Students’ Industrial Work Experience Scheme (SIWES) is a part of the approved Benchmark for Minimum Academic Standards (BMAS) in some degree programmes of the National Open University of Nigeria (NOUN). It is a compulsory skills training programme designed to bridge the gap between theory and practice of academic and other professional educational programmes in Nigerian tertiary institutions. It is aimed at exposing students to machines and equipment, professional work methods and ways of safeguarding the workplace.<p></p>
                                The essence of the Students' Industrial Work Experience is to bridge the gap between what you have been taught in school (theory) with the practical hands-on in the industry (practice), to make you a completely informed and valued person in the marketplace. This attachment is for six months, you will be meeting people, gaining valuable experiences from all of them and this may increase your chances of getting better jobs and meeting people that could be springboard to your success in life. <P></P>

                                Note the following<br>
                                <ol>
                                    <li>
                                        To apply for a placement, visit the NOUN SIWES website at at https://mylearningspace.nouedu2.net (See detail below)
                                    </li>
                                    <li>
                                        To change your placement in the event that you are rejected, visit the NOUN SIWES website at https://mylearningspace.nouedu2.net (See detail below)
                                    </li>
                                    <li>
                                        While seeking placement, always go to the organization of your choice with relevant documents (See detail of documents below)
                                    </li>
                                    <li>
                                        During the period of your SIWES, you will be required to have a logbook in which you are expected to record your daily activities. (See detail below on how to obtain your logbook)
                                    </li>
                                </ol>
                            </div>
                        </div>
                        
                        
                        <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div2').style.display=='flex')
                            {
                                _('div2').style.display='none'
                                _('div2minus').style.display='none'
                                _('div2plus').style.display='block';
                            }else
                            {
                                _('div2').style.display='flex'
                                _('div2minus').style.display='block'
                                _('div2plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    What is the Duration for SIWES?
                                </div>
                        </div>
                        <div id="div2" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                            SIWES is for a period of six months only. Some programmes have it as three months in two hundred level and three months in three hundred level, making a total of six months. The only exception is for the students of B.Agriculture that have their Farm Practical Year (FPY/SIWES) for fifty-two weekends.
                            </div>
                        </div>
                        
                        
                        <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div3').style.display=='flex')
                            {
                                _('div3').style.display='none'
                                _('div3minus').style.display='none'
                                _('div3plus').style.display='block';
                            }else
                            {
                                _('div3').style.display='flex'
                                _('div3minus').style.display='block'
                                _('div3plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                	What is the Credit Unit for SIWES
                                </div>
                        </div>
                        <div id="div3" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                SIWES carries a credit load or unit of six credits. In some programmes, you have it as 3 credits in year two and another 3 credits in year 3. The only exception is for B.Agriculture where the Farm Practical Year /SIWES is registered as AGR400 and it is twenty four credit units.
                            </div>
                        </div>
                        
                        
                        <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div4').style.display=='flex')
                            {
                                _('div4').style.display='none'
                                _('div4minus').style.display='none'
                                _('div4plus').style.display='block';
                            }else
                            {
                                _('div4').style.display='flex'
                                _('div4minus').style.display='block'
                                _('div4plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                	To do list of SIWES
                                </div>
                        </div>
                        <div id="div4" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                <ol>
                                    <li>
                                        Register SIWES course
                                    </li>
                                    <li>
                                        Orientation at the Study Centre
                                    </li>
                                    <li>
                                        Placement for attachment
                                    </li>
                                    <li>
                                        Collection of log book and ITF forms
                                    </li>
                                    <li>
                                        Commence the scheme
                                    </li>
                                    <li>
                                        Supervision
                                    </li>
                                    <li>
                                        Submission of logbook
                                    </li>
                                    <li>
                                        Oral presentation
                                    </li>
                                    <li>
                                        Evaluation of performance
                                    </li>
                                    <li>
                                        Release of result
                                    </li>
                                </ol>
                            </div>
                        </div>
                        
                        
                        <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div5').style.display=='flex')
                            {
                                _('div5').style.display='none'
                                _('div5minus').style.display='none'
                                _('div5plus').style.display='block';
                            }else
                            {
                                _('div5').style.display='flex'
                                _('div5minus').style.display='block'
                                _('div5plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                	How do I register for SIWES
                                </div>
                        </div>
                        <div id="div5" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                <ol>
                                    <li>
                                        Click 'My courses' (top)
                                    </li>
                                    <li>
                                        Click 'Register coures'(right)
                                    </li>
                                    <li>
                                        Select SIWESS course to register
                                    </li>
                                    <li>
                                        Click 'Submit'
                                    </li>
                                    <li>
                                        Confirm your intention
                                    </li>
                                </ol>
                            </div>
                        </div>
                        
                        
                        
                        <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div7').style.display=='flex')
                            {
                                _('div7').style.display='none'
                                _('div7minus').style.display='none'
                                _('div7plus').style.display='block';
                            }else
                            {
                                _('div7').style.display='flex'
                                _('div7minus').style.display='block'
                                _('div7plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                	How to login on the SIWES website
                                </div>
                        </div>
                        <div id="div7" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                <ol>
                                    <li>
                                        Go to https://mylearningspace.nouedu2.net
                                    </li>
                                    <li>
                                        Enter your matriculation number in capital letter as username and password
                                    </li>
                                    <li>
                                        Click 'Login' button
                                    </li>
                                    <li>
                                        Select my SIWES Record on the left side menu and login a second time.
                                    </li>
                                    <li>
                                        Enter your matriculation number in capital letter for user name and in small leter for password
                                    </li>
                                    <li>
                                        Click 'Login' button
                                    </li>
                                </ol>
                            </div>
                        </div>
                        
                        
                        
                        <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div8').style.display=='flex')
                            {
                                _('div8').style.display='none'
                                _('div8minus').style.display='none'
                                _('div8plus').style.display='block';
                            }else
                            {
                                _('div8').style.display='flex'
                                _('div8minus').style.display='block'
                                _('div8plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                	How do I secure or change my SIWES placement
                                </div>
                        </div>
                        <div id="div8" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                <ol>
                                    <li>
                                        Login as described above
                                    </li>
                                    <li>
                                    	Click on SIWES detail on the menu bar.
                                    </li>
                                    <li>
                                        To secure a placement
                                        <ol style="list-style: lower-alpha;">
                                            <li>
                                                Click on Add SIWES Record.
                                            </li>
                                            <li>
                                                Fill the presented form as applicable
                                            </li>
                                        </ol>
                                    </li>

                                    
                                    <li>
                                        To change placement
                                        <ol style="list-style: lower-alpha;">
                                            <li>
                                                Click on VIEW and EDIT SIWES Record.
                                            </li>
                                            <li>
                                                Click on your matriculation number
                                            </li>
                                            <li>
                                                Modify form as required
                                            </li>
                                        </ol>
                                    </li>
                                    <li>
                                        Click on Save
                                    </li>
                                    <li>
                                        Dwnload and print the request for placement letter 001 and placement acceptance form 002.
                                    </li>
                                </ol>
                            </div>
                        </div>
                        
                        
                        <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div6').style.display=='flex')
                            {
                                _('div6').style.display='none'
                                _('div6minus').style.display='none'
                                _('div6plus').style.display='block';
                            }else
                            {
                                _('div6').style.display='flex'
                                _('div6minus').style.display='block'
                                _('div6plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                	How do I pay for logbook
                                </div>
                        </div>
                        <div id="div6" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                <ol>
                                    <li>
                                        Go to www.remita.net
                                    </li>
                                    <li>
                                        Click on Pay FGN and State TSA
                                    </li>
                                    <li>
                                        For 'Who do you want to Pay to?', type National Open University of Nigeria
                                    </li>
                                    <li>
                                        For 'Purpose of Payment', type SIWES Logbook
                                    </li>
                                    <li>
                                        Fill in the remaining detail as applicable
                                    </li>
                                    <li>
                                        Fill in the remaining detail as applicable (Amount to be paid is N1,000.00)
                                    </li>
                                    <li>
                                        Click submit button
                                    </li>
                                    <li>
                                        Select payment option and follow the instrctuction on the screen
                                    </li>
                                    <li>
                                        Whan you are done paying, take you payment receipt to the SIWES desk officer at your study centre to collect your logbook
                                    </li>
                                </ol>
                            </div>
                        </div>
                        
                        
                        
                        <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div9').style.display=='flex')
                            {
                                _('div9').style.display='none'
                                _('div9minus').style.display='none'
                                _('div9plus').style.display='block';
                            }else
                            {
                                _('div9').style.display='flex'
                                _('div9minus').style.display='block'
                                _('div9plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                	How do I get the Industrial Training Fund (ITF) Stipend
                                </div>
                        </div>
                        <div id="div9" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                <ol>
                                    <li>
                                        Your placement must be relevant to your programme of study
                                    </li>
                                    <li>
                                        Your SCAF (Student Commencement of Attachment Form) must be submitted in the nearest ITF office within two weeks of commencement of attachment. This will give the ITF officials an idea of where you are placed for effective supervision
                                    </li>
                                    <li>
                                    	Your description of work done must be duly completed with the necessary diagrams and pictures
                                    </li>
                                    <li>
                                    	You must complete the 24 weeks mandatory period for SIWES attachment
                                    </li>
                                    <li>
                                    	The spaces provided must be duly filled by you and your Industry based supervisor must append his or her signature with comments on a weekly basis
                                    </li>
                                    <li>
                                    	The student must be involved in a practical based attachment and must be able to show the relevance of what is being practiced at the time of SIWES supervision
                                    </li>
                                    <li>
                                    	You must supply the account details with sort code at the time of submission,
                                    </li>
                                    <li>
                                    	Student must have fulfilled all the other requirements as stated in the Stepwise procedure for SIWES.
                                    </li>
                                </ol>
                            </div>
                        </div>
                        
                        
                        
                        <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div10').style.display=='flex')
                            {
                                _('div10').style.display='none'
                                _('div10minus').style.display='none'
                                _('div10plus').style.display='block';
                            }else
                            {
                                _('div10').style.display='flex'
                                _('div10minus').style.display='block'
                                _('div10plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                	ITF Funded Programmes for NOUN
                                </div>
                        </div>
                        <div id="div10" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                            There are three programmes funded or sponsored by the Industrial Training Fund (ITF) for the National Open University of Nigeria (NOUN).<br> 
                            Undergraduates of the programmes funded by the ITF will be paid a stipend of fifteen thousand naira only if they meet all the conditions as stated above. The funded programmes for our University are 

                                <ol>
                                    <li>
                                    	B.Sc. Agricultural Economics Management (AEM). 

                                    </li>
                                    <li>
                                        B.Sc. (Ed.) Business Education (BED314 and BED413) 
                                    </li>
                                    <li>
                                        B.Sc. Computer Science (CIT389)
                                    </li>
                                </ol>
                            </div>
                        </div>
                        
                        
                        
                        <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div11').style.display=='flex')
                            {
                                _('div11').style.display='none'
                                _('div11minus').style.display='none'
                                _('div11plus').style.display='block';
                            }else
                            {
                                _('div11').style.display='flex'
                                _('div11minus').style.display='block'
                                _('div11plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                	How do I Check my SIWES Result
                                </div>
                        </div>
                        <div id="div11" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                <ol>
                                    <li>
                                    	Login as described above
                                    </li>
                                    <li>
                                        Click on the “Result Statement” to view your Statement of Result
                                    </li>
                                </ol>
                            </div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'research_project')
                    {
                        echo "About Final year research project";
                        if ($cFacultyId_loc == 'AGR')
                        {
                            echo '<p>Contact your faculty via your study centre';
                        }else if ($cFacultyId_loc == 'ART')
                        {
                            if ($cdeptId_loc == 'LNG')
                            {  
                                if ($cEduCtgId_loc == 'PSZ')
                                {?> 
                                    <iframe src="../ext_docs/project_report_template/art_ug_format_for_project_writing_in_the_department_of_english.pdf" style="width:100%; height:730px;" frameborder="0"></iframe><?php
                                }else
                                {?> 
                                    <iframe src="../ext_docs/project_report_template/art_pg_format_for_project_writing_in_the_department_of_english.pdf" style="width:100%; height:730px;" frameborder="0"></iframe><?php 
                                }
                            }else if ($cdeptId_loc == '')
                            {?> 
                                <iframe src="../ext_docs/project_report_template/Research_Project_Manual_and_Format_undergraduate.pdf" style="width:100%; height:730px;" frameborder="0"></iframe><?php 
                            }
                        }else if ($cFacultyId_loc == 'EDU')
                        {?> 
                            <iframe src="../ext_docs/project_report_template/edu_Research_Project_Manual_and_Format_undergraduate.pdf" style="width:100%; height:730px;" frameborder="0"></iframe><?php
                        }else if ($cFacultyId_loc == 'HSC')
                        {?> 
                            <iframe src="../ext_docs/project_report_template/hsc_research_guide_for_nursing.pdf" style="width:100%; height:730px;" frameborder="0"></iframe><?php
                        }else if ($cFacultyId_loc == 'LAW')
                        {?> 
                            <iframe src="../ext_docs/project_report_template/Research_Project_Manual_and_Format_undergraduate.pdf" style="width:100%; height:730px;" frameborder="0"></iframe><?php
                        }else if ($cFacultyId_loc == 'MSC')
                        {
                            if ($cEduCtgId_loc == 'PSZ')
                            {?> 
                                <iframe src="../ext_docs/project_report_template/msc_Undergraduate_Project_Format.pdf" style="width:100%; height:730px;" frameborder="0"></iframe><?php
                            }else if ($cEduCtgId_loc == 'PRX' || $cEduCtgId_loc == 'PGZ')
                            {?> 
                                <iframe src="../ext_docs/project_report_template/msc_phd_dissertation_template.pdf" style="width:100%; height:730px;" frameborder="0"></iframe><?php
                            }else if ($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY')
                            {?> 
                                <iframe src="../ext_docs/project_report_template/msc_Postgraduate_Dissertation_Format.pdf" style="width:100%; height:730px;" frameborder="0"></iframe><?php
                            }
                        }else if ($cFacultyId_loc == 'SCI')
                        {
                            echo '<p>Contact your faculty via your study centre';
                        }else if ($cFacultyId_loc == 'SSC')
                        {
                             echo '<p>Contact your faculty via your study centre';
                        }
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'internship')
                    {
                        echo "About internship";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'practicum')
                    {
                        echo "About Practicum";
                        if ($cFacultyId_loc == 'HSC')
                        {?> 
                            <iframe src="../ext_docs/project_report_template/hsc_guide_to_practicum_in_nursing.pdf" style="width:100%; height:730px;" frameborder="0"></iframe><?php
                        }else if ($vProgrammeDesc_loc == 'Educational Administration')
                        {?> 
                            <!--<iframe src="../ext_docs/project_report_template/hsc_guide_to_practicum_in_nursing.pdf" style="width:100%; height:730px;" frameborder="0"></iframe>--><?php
                        }
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'teaching_practice')
                    {?>
                        <div class="appl_left_child_div_child">
                            <div style="flex:100%; height:40px; line-height:2; text-indent:10px; margin-bottom:4px; background-color: #ffffff; font-weight:bold">
                                About teaching practice
                            </div>
                        </div>
                        
                        <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div1').style.display=='flex')
                            {
                                _('div1').style.display='none'
                                _('div1minus').style.display='none'
                                _('div1plus').style.display='block';
                            }else
                            {
                                _('div1').style.display='flex'
                                _('div1minus').style.display='block'
                                _('div1plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    What is student teaching practice (STP)?
                                </div>
                        </div>
                        <div id="div1" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                The term STP is defined differently by many educationists. Two of such are state below: <P></P>
                                <ol>
                                    <li>
                                        According to Salawu and Adeoye (2002), student teaching Practice is a practical teaching activity by which the student -teachers are given
                                        an opportunity in actual school situation to demonstrate and improve
                                        training in pedagogical skill over a period of time.
                                    </li>
                                    <li>
                                        Student Teaching Practice is a pre-service professional preparation for
                                        interested persons, aspiring to become teachers with a credible vision for
                                        sustainable human development (Oyekan, 2000).
                                    </li>
                                </ol>
                                </p>
                                <a href="https://nou.edu.ng/coursewarecontent/EDU%20335%20teaching%20practice%20manual.pdf" target="_blank" style="text-decoration:none">Read more</a>
                            </div>
                        </div>
                        
                        
                        
                        <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div2').style.display=='flex')
                            {
                                _('div2').style.display='none'
                                _('div2minus').style.display='none'
                                _('div2plus').style.display='block';
                            }else
                            {
                                _('div2').style.display='flex'
                                _('div2minus').style.display='block'
                                _('div2plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    Why is it important?
                                </div>
                        </div>
                        <div id="div2" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                The National Policy on Education NPE (2004) in section 6 dwells on teacher
                                education. Among others, the section specifies the following as the objectives of
                                teacher education <P></P>
                                <ol>
                                    <li>
                                        to produce highly motivated, conscientious and efficient classroom teachers for all levels of our education system.
                                    </li>
                                    <li>
                                        to encourage further the spirit of enquiry and creativity in teachers.
                                    </li>
                                </ol>
                                </p>

                                Specifically, some of the objectives of the professional exercise are: <P></P>
                                <ol>
                                    <li>
                                        develop skills and competencies of teaching
                                    </li>
                                    <li>
                                        apply the principles you learnt from the courses you studied to teach in addition to bringing about meaningful changes in learners;
                                    </li>
                                    <li>
                                        write scheme of work, lesson notes using appropriate concepts and generalizations that will facilitate learning;
                                    </li>
                                    <li>
                                        select and use a variety of teaching strategies and instructional resources that are appropriate to achieve the objectives you stated in your lesson plan
                                    </li>
                                    <li>
                                        select and use a variety of teaching strategies and instructional resources that are appropriate to achieve the objectives you stated in your lesson plan
                                    </li>
                                </ol>
                            </div>
                        </div>
                        
                        
                        
                        <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div3').style.display=='flex')
                            {
                                _('div3').style.display='none'
                                _('div3minus').style.display='none'
                                _('div3plus').style.display='block';
                            }else
                            {
                                _('div3').style.display='flex'
                                _('div3minus').style.display='block'
                                _('div3plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    What does the Univesity expects of me?
                                </div>
                        </div>
                        <div id="div3" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                You are expected to posess certain qualities, some of which are listed below: <P></P>
                                <ol>
                                    <li>
                                        Neatness, simplicity, and appropriateness in dressing
                                    </li>
                                    <li>
                                        Self-confidence and Emotional Composure
                                    </li>
                                    <li>
                                        Exhibition of Enthusiasm
                                    </li>
                                    <li>
                                        Acceptance of Constructive Criticisms and Corrections:
                                    </li>
                                    <li>
                                        Good Manners
                                    </li><p>
                                    <a href="https://nou.edu.ng/coursewarecontent/EDU%20335%20teaching%20practice%20manual.pdf" target="_blank" style="text-decoration:none">Read more</a>
                                    </p>                                    
                                
                                    <li>
                                        You are also expected to turn in a report at the end of the exercise.
                                        <a href="https://nou.edu.ng/coursewarecontent/EDU%20336.pdf" target="_blank" style="text-decoration:none">Read more</a>
                                    </li>
                                </ol>
                                </p>
                                
                            </div>
                        </div>
                        
                        
                        
                        <div class="appl_left_child_div_child" style="cursor:pointer;"
                            onClick="if(_('div4').style.display=='flex')
                            {
                                _('div4').style.display='none'
                                _('div4minus').style.display='none'
                                _('div4plus').style.display='block';
                            }else
                            {
                                _('div4').style.display='flex'
                                _('div4minus').style.display='block'
                                _('div4plus').style.display='none';
                            }return false">
                                <div style="flex:5%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    <img style="width:10px; height:11px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                </div>
                                <div style="flex:95%; height:30px; padding:10px; margin-bottom:4px; background-color: #ffffff;">
                                    How do I register for STP
                                </div>
                        </div>
                        <div id="div4" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                <ol>
                                    <li>
                                        Click 'My courses' (top)
                                    </li>
                                    <li>
                                        Click 'Register coures'(right)
                                    </li>
                                    <li>
                                        Select STP course to register
                                    </li>
                                    <li>
                                        Click 'Submit'
                                    </li>
                                    <li>
                                        Confirm your intention
                                    </li>
                                </ol>
                            </div>
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