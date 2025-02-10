<?php
// Date in the past
require_once('good_entry.php');

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
        
        
        include(BASE_FILE_NAME."feedback_mesages.php");      
        include("std_detail_pg1.php");
        include("forms.php");

        include("set_scheduled_dates.php");
        include("token_redirect.php");
        include("rs_notice_board.php");
        
        $balance = 0.00;?>

        <div class="appl_container">
            <div class="appl_left_div" style="z-index:2;">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em"><?php
                    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'abuot_tma')
                    {                    
                        echo "About Tutor Marked Assignment (TMA)";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'abuot_exam')
                    {                    
                        echo "About examination";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'personal_timetable')
                    {
                        echo "Examination timetable";
                    }?>
                </div>
                
                <div class="for_computer_screen">
                    <?php include ('std_left_side_menu.php');?>                    
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
                    <?php include ('mobile_menu_bar_content.php');?>
                </div>

                
                <div class="appl_left_child_div for_computer_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php include ('menu_bar_content.php');?>
                </div>

                <div class="menu_sm_scrn">
                    <?php build_menu_right();?>
                </div>
                <div id="phil_div" class="appl_left_child_div" style="width:95%; margin:auto; max-height:95%; margin-top:10px; text-align: left; overflow:auto;  background-color:#eff5f0"><?php          
                    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'abuot_tma')
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
                                About Tutor Marked Assignement
                            </div>
                        </div>
                        <div id="div1" class="appl_left_child_div_child" style="margin-top:-15px; display:block;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                            Tutor Marked Assignement (TMA) stands for continuous assessment. There are three for every course you register except project, seminar, teaching practice and practicum which do not have TMAs. They are called TMA1 , TMA2 and TMA3. All TMA1 in all registered courses for examination are made available in the same period. Likewise TMA2 and TMA3. Each TMA is made up of multiple choice, fill-in-the-blank or true/false questions which are targetted at testing your understaning of what you read in the course. 
                                <p>You can only access the TMAs of courses you have registered for examination after 48hrs of registration. This is subject to the schedule on the University academic callendar. Each TMA carries 10 marks that is, TMA makes up 30% of your total score in every course you register.</p>
                                
                                To access a TMA in any given course after you have met the above stated condition, do the following:
                                <ol>
                                    <li>
                                        Go to <a href="https://elearn.nou.edu.ng/" target="_blank">elearn.nou.edu.ng</a>
                                    </li>
                                    <li>
                                        Note the announcement on the screen, if there is any
                                    </li>
                                    <li>
                                        Watch video for more detail
                                    </li>
                                    <li>
                                        Click the login button on the top right corner of the page
                                    </li>
                                    <li>
                                        Enter your matriculation number and password to login
                                    </li>
                                    <li>
                                        Click on the TMA link of the course of interest
                                    </li>
                                    <li>
                                        Attempt all questions accordingly
                                    </li>
                                    <li>
                                        Click the submit button
                                    </li>
                                    <li>
                                        Logout when you are through
                                    </li>
                                </ol>                                
                            </div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'abuot_exam')
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
                                About examination
                            </div>
                        </div>
                        <div id="div1" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                Examinations are conducted by the Directorate of Examination and Assessment (DEA). Results are presented to the Senate through the University Examination Committee for approval, forwarded to the Study Centres and uploaded to the stuents' section of the portal by the Directorste of Management Information Systems (DMIS)
                                <P>
                                    There are three Categories of examination namely:
                                </P>
                                <ol>
                                    <li>
                                        e-Examination - for 100L and 200L students.
                                    </li>
                                    <li>
                                        Pen-on-paper examination - for 300L and above
                                    </li>
                                    <li>
                                        Virtual Examination
                                    </li>
                                    
                                    
                                    <p>
                                        To qualify to write examination, do the following:
                                        <ol>
                                            <li>
                                                Register the course and the corresponding examination
                                            </li>
                                            <li>
                                                Study the course material for a minimum period of eight weeks
                                            </li>
                                            <li>
                                                Do the continous assessment test that is tutor marked assignment. See detail above
                                            </li>
                                        </ol>
                                    </p>
                                    
                                    
                                    <p>
                                        On the day of any given examination, you are expected to
                                        <ol>
                                            <li>
                                                be at the venue, thirty minutes (30 mins) ahead of the beginning of the examination
                                            </li>
                                            <li>
                                                come along with your examination registration slip and current student identity card
                                            </li>
                                            <li>
                                                wait to be assigned a seat when you enter the examination hall
                                            </li>

                                            <p>
                                                For e-examination:
                                            </p>
                                            <li>
                                                The seat you will be assigned will have a functional computer system
                                            </li>
                                            <li>
                                                The login page should be displayed on the screen otherwise, raise your hand to call for assistance.
                                            </li>
                                            <li>
                                                Login when you are told to do so. You matriculation number is your user name. You will be told what your password is.
                                            </li>
                                            <li>
                                                NOUN uses modular object oriented dynamic learning environment (MOODLE) to conduct all forms of examinations. Therefore, you are adivsed to get yourself familiar with the application and have a basic knowledged on the use of computer.
                                            </li>
                                            <li>
                                                The questions may be in either multiple choice, true/false or fill-in-the-blank format.
                                            </li>

                                            <p>
                                                If you have more than one examinations to write, inform the invigilator before you begin the first examination. <br>
                                                The University implements examination rules to the letter so, ensure you comply. See detail of examination rules below
                                            </p>
                                        </ol>
                                    </p>
                                </ol>
                                </p>
                                
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
                                Examinations guidelines and regulations
                            </div>
                        </div>
                        <div id="div2" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; padding:10px; background-color: #ffffff;">
                                <ol>
                                    <li>
                                        Your matriculation number serves as your examination number
                                    </li>
                                    <li>
                                        You must show your examination registration slip for the current semester in the current session on each day of examination
                                    </li>
                                    <li>
                                    	You will only be allowed into the examination hall if your examination registration slip carries the course whose examination you want to write
                                    </li>
                                    <li>
                                        You will not be allowed into the examination hall if examination duration has gone beyond 30 minutes
                                    </li>
                                    <li>
                                    	Once you are admitted in to the examination hall, you may not be allowed to leave the hall until you finish the examination. If for any reason you must leave the hall, 
                                        
                                        <ol style="list-style: lower-alpha;">
                                            <li>
                                                it must be with the permission of the supervisor
                                            </li>
                                            <li>
                                                you must be accompanied by an invigilator with a limited time
                                            </li>
                                            <li>
                                                extra time will not be given to such student
                                            </li>
                                        </ol>
                                    </li>
                                    <li>
                                    	You cannot use any other booklet unless the one provided by the university 
                                    </li>
                                    <li>
                                    	All extra sheet provided by the invigilator must be attached to your main booklet
                                    </li>
                                    <li>
                                    	Silence must be observed in the examination hall
                                    </li>
                                    <li>
                                    	Any student requiring the attention of the invigilator should raise his/her hand
                                    </li>
                                    <li>
                                    	Communication between students is strictly forbidden during examinations
                                    </li>
                                    <li>
                                    	Any form of cheating is not allowed in the examination hall
                                    </li>
                                    <li>
                                    	If you are found to be receiving or giving assistance during examinations, you will be sanctioned and you will face malpractice panel 
                                    </li>
                                    <li>
                                    	Phones, bags, notebooks, course materials are not allowed inside the examination hall
                                    </li>
                                    <li>
                                    	University is not liable to any loss or damage of your personal property
                                    </li>
                                    <li>
                                    	Student are not permitted to smoke inside the examination hall
                                    </li>
                                    <li>
                                    	Any form of distraction is forbidden inside the examination hall
                                    </li>
                                </ol>
                            </div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'personal_timetable')
                    {
                        include("p_time_table.php");
                    }else
                    {?>
                        <div class="appl_left_child_div_child" style="margin-bottom: 20px;">
                            <div style="flex:100%; padding:5px; height:auto; background-color: #ffffff">
                                <img style="width:100%; height:580px" src="data:image/png;base64,<?php echo c_image('img/cbt.jpg');?>"/>
                            </div>
                        </div><?php
                    }
                   
                    
                    include ('std_bottom_right_menu.php');?>
                </div>
            </div>

            <div id="menu_bs_scrn" class="appl_far_right_div" style="z-index:2;">
                <?php build_menu_right($balance);?>
            </div>
        </div>
	</body>
</html>