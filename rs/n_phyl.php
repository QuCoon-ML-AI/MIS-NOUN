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
                    if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'noun_philosophy')
                    {                    
                        echo "Our Philosophy";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'noun_admin')
                    {
                        echo "Administration";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'noun_gc')
                    {
                        echo "Governing Council";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'from_vc')
                    {
                        echo "Hear from the Vice Chancellor";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'from_reg')
                    {
                        echo "Hear from the Registrar";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'from_bursar')
                    {
                        echo "Hear from the Bursar";
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'from_lib')
                    {
                        echo "Hear from the Librarian";
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
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'noun_philosophy')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div class="middle_left" style="flex:15%; padding-left:4px; height:auto;"></div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Vision</b><p>
                                To be regarded as the foremost university providing highly accessible and enhanced quality  education anchored  by social justice, equity, equality and national cohesion through a comprehensive reach that transcends all barriers.<br><br>
                                <b>Mission</b><p>
                                To provide functional, cost-effective, flexible learning which adds life-long value to quality education for all who seek knowledge.
                                </p>
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div>

                        <div class="for_sm" class="appl_left_child_div_child calendar_grid course_line">
                            <div class="inlin_message_color" style="text-align:center; flex:100%; padding:10px; background-color: #ffffff; height:auto;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" width="125px"/>
                            </div>
                        </div>
                        
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div class="middle_left" style="flex:15%; padding-left:4px; height:auto;"></div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>NOUN Logo</b><p>
                                The NOUN Logo is the soul of the institution. It is open at the top to emphasize the open nature  of the university. It carries the national emblem to confirm that it is a national university; the open book at the centre indicates that you can work and learn at the same time and that education can even be brought  to you at your workplace. The colours of green and white are the national colours and the red colour carrying the name of the university underscores the distinctiveness of the institution in Nigeria.
                            </div>
                            <div class="middle_right" style="text-align:center; flex:20%; padding-left:4px; height:auto;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" style="width:135px; height:180px; margin:auto;"/>
                            </div>
                        </div>
                        
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div class=" middle_left" style="flex:15%; padding-left:4px; height:auto;"></div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>NOUN Anthem</b><p>
                                    National Open University of Nigeria<br>
                                    Determined to be the foremost University in Nigeria<br>
                                    Providing highly accessible and enhanced quality education<br>
                                    Anchored by Social justice, equity, equality and national cohesion<p></p>

                                    Come to NOUN<br>
                                    For quality, cost effective and flexible learning<br>
                                    That adds lifelong value, For all who yearn<br>
                                    For quality education and for all<br>
                                    Who seek knowledge
                            </div>
                            <div class=" middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'noun_admin')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line" style="margin-bottom: 20px;">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'vc.png');?>" style="width:135px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Vice-Chancellor</b><p>
                                Professor Olufemi Ayinde Peters was born on 11 May 1956 at Ebute Metta, Lagos State Nigeria to Egba parents who were originally from Alagbado in Ifo Local Government in Ogun State. He attended the University of Ibadan for a Bachelor of Science degree in Chemistry between 1976 and 1979.
                                </p>
                                <a href="https://nou.edu.ng/university-management-team/prof-olufemi-a-peters/" target="_blank" style="text-decoration:none">Read more...</a>
                            </div>
                            <div class="middle_right" style="flex:15%; padding-left:4px; height:auto;"></div>
                        </div>
                        
                        <div class="appl_left_child_div_child calendar_grid course_line" style="margin-bottom: 20px;">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'dvcacad.png');?>" style="width:135px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Deputy Vice Chancellor, Academic</b><p>    
                                Chiedu Felix Mafiana, a Professor of Parasitology, was born on January 01, 1959 in Kano. He had his tertiary education at the University of Lagos, where he obtained his Bachelor and Master of Science degrees in Zoology in 1980 and 1986 respectively. 
                                </p>
                                <a href="https://nou.edu.ng/prof-chiedu-felix-mafiana/" target="_blank" style="text-decoration:none">Read more...</a>
                            </div>
                            <div class=" middle_right" style="flex:15%; padding-left:4px; height:auto;"></div>
                        </div>
                        
                        <div class="appl_left_child_div_child calendar_grid course_line" style="margin-bottom: 20px;">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'dvc_admin.png');?>" style="width:135px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Deputy Vice Chancellor, Administration</b><p>    
                                Isaac S.R. Butswat is a Professor of Animal Science, (Animal Reproductive and Environmental Physiology). Born in Gagdi, Kanam LGA of Plateau State, 11–01–1959. 
                                </p>
                                <a href="https://nou.edu.ng/university-management-team/prof-isaac-sammani-butswat/" target="_blank" style="text-decoration:none">Read more...</a>
                            </div>
                            <div class=" middle_right" style="flex:15%; padding-left:4px; height:auto;"></div>
                        </div>
                        
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'dvc_tir.png');?>" style="width:135px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Deputy Vice Chancellor, Technology, Innovation and Research</b><p>    
                                Professor Godwin Iornenge Akper, born on July 19, 1969, in Mbagen, Buruku Local Govt. Area, Benue State, Nigeria, is the current Deputy Vice-Chancellor (Technology, Innovation, and Research). 
                                </p>
                                <a href="https://nou.edu.ng/university-management-team/professor-godwin-iornenge-akper/" target="_blank" style="text-decoration:none">Read more...</a>
                            </div>
                            <div class=" middle_right" style="flex:15%; padding-left:4px; height:auto;"></div>
                        </div>
                        
                        <div class="appl_left_child_div_child calendar_grid course_line" style="margin-bottom: 20px;">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'registrar.png');?>" style="width:135px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Registrar</b><p>
                                    Oladipo Adetayo Ajayi, the distinguished 3rd substantive Registrar of the National Open University of Nigeria (NOUN), assumed office on September 6, 2022.
                                </p>
                                <a href="https://nou.edu.ng/oladipo-adetayo-ajayi/" target="_blank" style="text-decoration:none">Read more...</a>
                            </div>
                            <div class=" middle_right" style="text-align:center; flex:15%; padding-left:4px; height:auto;"></div>
                        </div>
                        
                        <div class="appl_left_child_div_child calendar_grid course_line" style="margin-bottom: 20px;">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'bursar.jpg');?>" style="width:135px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Bursar</b><p>                                    
                                    Mr. Nasir Marafa<p>
                                    More to come...
                                </p>
                                <!-- <a href="https://nou.edu.ng/university-management-team/librarian-2/" target="_blank" style="text-decoration:none">Read more...</a> -->
                            </div>
                            <div class=" middle_right" style="flex:15%; padding-left:4px; height:auto;"></div>
                        </div>
                        
                        <div class="appl_left_child_div_child calendar_grid course_line" style="margin-bottom: 20px;">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'librarian.png');?>" style="width:135px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Librarian</b><p>                                    
                                    Dr Angela Ebele Okpala is an Associate Professor in National Open University of Nigeria(NOUN). She started her library career in Kenneth Dike Library, University of Ibadan, Nigeria from 1993-1997.
                                </p>
                                <a href="https://nou.edu.ng/university-management-team/librarian-2/" target="_blank" style="text-decoration:none">Read more...</a>
                            </div>
                            <div class=" middle_right" style="flex:15%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'noun_gc')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line" style="margin-bottom: 20px;">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/jpg;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'nig_president.jpg');?>" style="width:135px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>President Bola Ahmed Tinubu</b><br>
                                The Visitor<p>
                                Chief Bola Ahmed Adekunle Tinubu GCFR (born 29 March 1952) is a Nigerian politician who is the 16th and current president of Nigeria. He was the governor of Lagos State from 1999 to 2007; and senator for Lagos West in the Third Republic.

                                Tinubu spent his early life in southwestern Nigeria and later moved to the United States where he studied accounting at Chicago State University. He returned to Nigeria in the early 1990s and was employed by Mobil Nigeria as an accountant, before entering politics as a Lagos West senatorial candidate in 1992 under the banner of the Social Democratic Party. After dictator Sani Abacha dissolved the Senate in 1993, Tinubu became an activist campaigning for the return of democracy as a part of the National Democratic Coalition movement.

                                In the first post-transition Lagos State gubernatorial election, Tinubu won by a wide margin as a member of the Alliance for Democracy. Four years later, he won re-election to a second term. After leaving office in 2007, he played a key role in the formation of the All Progressives Congress in 2013. In 2023, he was elected president of Nigeria.
                            </div>
                            <div class="middle_right" style="flex:15%; padding-left:4px; height:auto;"></div>
                        </div>
                        
                        <div class="appl_left_child_div_child calendar_grid course_line" style="margin-bottom: 20px;">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'vc.png');?>" style="width:135px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Professor Olufemi A. Peters</b><br>
                                Member<p>
                                Professor Olufemi Ayinde Peters was born on 11 May 1956 at Ebute Metta, Lagos State Nigeria to Egba parents who were originally from Alagbado in Ifo Local Government in Ogun State. He attended the University of Ibadan for a Bachelor of Science degree in Chemistry between 1976 and 1979. He obtained a Master of Science degree in Polymer Science and Technology from Ahmadu Bello University, Zaria in 1982. He later obtained a Ph.D degree in degradation and stabilization from the University of Manchester Institute of Science and Technology (UMIST) England in 1988.
                                </p>
                                <a href="https://nou.edu.ng/university-council/prof-olufemi-a-peters" target="_blank" style="text-decoration:none">Read more...</a>
                            </div>
                            <div class=" middle_right" style="text-align:center; flex:15%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'from_vc')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'vc_welcome_msg.png');?>" style="width:155px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Welcome Message from the Vice-Chancellor</b>
                                
                                <p>
                                    On behalf of the Council and Senate, I welcome you to the National Open University of Nigeria, the largest University in Nigeria by student enrolment and national spread. By the click of a button, you are now in the single largest community of flexible, open and distance learning in West Africa. We are proud to be the only institution licensed by the National Universities Commission to offer single-mode Open and Distance Education to Learners in Nigeria.
                                </p>
                                <p>
                                    At the National Open University of Nigeria (NOUN), our programmes are tailored to make learning accessible, flexible and available for you, at all times, in any place and at your pace. Our 103 Study Centres spread across the geopolitical zones of Nigeria are equipped with requisite physical infrastructure, human and material resources with top-notch ICT competencies for learning, in compliance with the best global standards of education in all our accredited programmes.
                                </p>
                                <p>
                                    With over 500,000 enrolled students that cut across all the strata of society, we are Nigeria’s leading institutional partner for the development of the much-needed skills and competencies, for the attainment of adult literacy and economic empowerment, which education offers.
                                </p>
                                <p>
                                    As you navigate our flexible, friendly and educative learning environment, I invite you to pay special attention to our programmes which cut across the Sciences (Agricultural, Biological, Computational, Environmental, Health, Management, Mathematical, Physical and Social), Arts, Humanities, ICT and Entrepreneurship studies.
                                </p>
                                <p>
                                    Our Centres of Excellence have been a source of inspiration to thousands of learners in vocational and special competence programmes for personal improvement. They are ably supported by reputable international partners such as the World Bank and the Commonwealth of Learning.
                                </p>
                                <p>
                                    We assure you of access to global opportunities offered by our international linkages with the worldwide community of distance learning through institutional partners such as the Commonwealth of Learning (COL, Canada), African Council for Distance Education (ACDE), International Council for Distance Education (ICDE) and Association of Commonwealth Universities (ACU), to mention a few.
                                </p>
                                <p>
                                    Please take advantage of our online student registration facilities, course facilitation and 24 hours access to open educational resources, to improve your learning experience anywhere and at any time.
                                </p>
                                <p>
                                    Once again, on behalf of the Council, the Management and the entire University Community, I welcome you.
                                </p>
                                <p>
                                    Thank you for your interest in the National Open University of Nigeria.
                                </p>

                                <p style="text-align:right">
                                    Professor Olufemi A. Peters<br>Vice Chancellor
                                </p>
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'from_dvcadmin')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" style="width:155px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Office of the Deputy Vice Chancellor, Administration</b>
                                
                                <p>
                                    The Office of the Deputy Vice-Chancellor (Administration) is one of the Units in the Office of the Vice-Chancellor. The Office of the Deputy Vice-Chancellor is headed by a Professor, known as the Deputy Vice-Chancellor (Administrtaion). The Deputy Vice-Chancellor is assisted by administrative, secretarial and clerical staff.
                                </p>
                                
                                <p>
                                    The Office of the Deputy Vice-Chancellor (Administration) has been blessed with astute Professors and administrative staff that have assisted the Vice-Chancellors of the University over the years in successfully executing their duties and responsibilities as the Chief Executive Officers, in accordance with the mandate of the University.
                                </p>
                                <p>
                                    The first Deputy Vice-Chancellor (Administration) of the National Open University of Nigeria is Professor Vincent Ado Tenebe. He was appointed into the Office on the 7th of March, 2008. He had a successful tenure that was crowned with his appointment as the Vice-Chancellor of our dear University, National Open University of Nigeris, on the 1st of October, 2010. Professor Nebath Tanglang took over the leadership of the Office of the Deputy Vice-Chancellor (Administration) from Professor Vincent Ado Tenebe. He was appointed the Deputy Vice Chancellor (Adminsitration) on the 11th of February, 2011. His dedication to work and the service of the University earned him two (2) temures in the Office until 10th of February, 2015. He was therefter appointed as the Director of Academic Planning of te University. Professor Nebath Tanglang passed the baton to Professor Victor Oluwole Adedipe. Professor Victor Oluwole Adedipe was appointed the Deputy Vice-Chancellor (Administration) on the 9th of March, 2021. His commitment and loyalty to the University also earned him two (2) tenures in the Office, which ended on the 10th of March, 2019. Professor Justus Adedji Sokefun was later appointed as the Deputy Vice Chancellor (Adminsitration) on the 22nd of March, 2022. His passion for the development of staff prompted him to ensure the training of staff so that their skills are further honed and attained competency. The current Deputy Vice-Chancellor (Administration) of the University is Professor Isaac Sammani Butswat. His commitment to task and attention to details prompted the Vice-Chancellor, Professor Olufemi Peters, to repose his confidence in him by appointing into the elevated position. As the administrative adviser to the Vice-Chancellor, he analyses issues, problems, concerns, and trends to determine the best course of action, and makes appropriate recommendation(s) to the Vice-Chancellor.
                                </p>
                                
                                <a href="https://nou.edu.ng/deputy-vice-chancellor-administration/" target="_blank" style="text-decoration:none; float:right">Read more...</a>
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'from_dvcacad')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" style="width:155px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Office of the Deputy Vice Chancellor, Academics</b>
                                
                                <p>
                                    The office of the Deputy Vice –Chancellor (Academic) is an office under the Vice- Chancellor office. Put succinctly, the Deputy Vice-Chancellor (Academic) is responsible to the Vice-Chancellor for all academic matters, such as academic administration, curriculum development, examinations, admissions and other Senate matters.

                                    The office is headed by a Professor and since inception of NOUN, the office has been headed by different eminent Professors:
                                </p>
                                
                                <a href="https://nou.edu.ng/deputy-vice-chancellor-academic/" target="_blank" style="text-decoration:none; float:right">Read more...</a>
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'from_dvctir')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" style="width:155px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Office of the Deputy Vice Chancellor, Innovation, Technology and Research</b>
                                
                                <p>
                                    The office of the Deputy Vice-Chancellor (Technology, Innovation, and Research) was established in the year 2021 to support the Vice-Chancellor in terms of providing policy and administrative guidelines to the university community in the areas of technology, innovation, and research.
                                </p>

                                <b>
                                    The directorates and activities under the purview of the DVC-TIR are:
                                </b>
                                <p>
                                    <ol>
                                        <li>Directorate of Information and Communication Technology (DICT)</li>
                                        <li>Directorate of Management Information Systems (DMIS) and</li>
                                        <li>Content delivery process</li>
                                    </ol>
                                </p>

                                <b>
                                    The Statutory function of the Deputy Vice-Chancellor Technology, Innovation and Research (DVC-TIR) Include:
                                </b>
                                <p>
                                    <ol>
                                        <li>To develop and update strategic plans and other related policies of deployment of technology in the National Open University of Nigeria.</li>
                                        <li>Facilitate and maintain the technology infrastructure that will be required for the smooth running of the university’s knowledge acquisition services.</li>
                                        <li>To network with relevant governmental and private organisations.</li>
                                    </ol>
                                </p>
                                
                                <a href="https://nou.edu.ng/deputy-vice-chancellor-technology-innovation-research/" target="_blank" style="text-decoration:none; float:right">Read more...</a>
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'from_reg')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" style="width:155px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Office of the Registrar</b>
                                
                                <p>
                                    The National Open University of Nigeria (NOUN) was first established by the 1983 act, suspended in 1984 and resuscitated in 2002. The President of the Federal Republic of Nigeria is the Visitor of the University.

                                    The University is governed by Council while the highest Academic body is the Senate with the Vice Chancellor as its chairman. The Registrar serves as Secretary to Council and Senate bodies.

                                    The Registry Department’s primary responsibility is to provide support services for the general administration of the University.

                                    You can visit our office in person, telephone or send email.
                                </p>
                                <b>
                                    Mission and Vision
                                </b>
                                <p>
                                    Our vision is to provide quality support services for students and the General Administration of the University with emphasis on Council affairs, Senate matters, Staff recruitment, Students’ admission/welfare, Staff welfare and other related activities.

                                    The Registry Department of NOUN is considered to be the “heartbeat” of the University from where the administrative and academic services and provided for in all arms of the University. It offers administrative and support services to Governing Council, Senate, management Committees as well as other service Departments such as the Bursary, Physical Planning, Internal Audit, Academic Planning Unit, Legal Unit University Library, Media and information Unit and office of the Vice-Chancellor. The Registry therefore ensures that the operational goals and objectives of the University are achieved as enshrined in the Act establishing the University.
                                </p>
                                
                                <a href="https://nou.edu.ng/deputy-vice-chancellor-technology-innovation-research/" target="_blank" style="text-decoration:none; float:right">Read more...</a>
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'from_bursar')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" style="width:155px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Office of the Bursar</b>
                                
                                <p>
                                    Welcome to Bursary, a directorate in National Open University of Nigeria (NOUN), Lagos. We are poised to provide financial guide to management, custodian of study and other materials, act as interface for the University with students, Government agencies and other parties and lots more.
                                </p>
                                <b>
                                    General Information
                                </b>
                                <p>
                                    Being the bedrock of the university finances, the Directorate has Seven main units viz:
                                </p>
                                
                                <p>
                                    <ol>
                                        <li>Treasury and Fund management</li>
                                        <li>Final Accounts and Reports</li>
                                        <li>Expenditure</li>
                                        <li>Budgetary control Payroll</li>
                                        <li>Students Accounts</li>
                                        <li>Store and Warehouse</li>
                                        <li>Business and Auxiliary Services Unit (BASU)</li>
                                    </ol>

                                    Each of the units above is headed by Chief Accountants who are professionals in their respective fields.
                                </p>
                                <b>Services and Activities</b>
                                <p>
                                    The Directorate is saddled with the following responsibilities:
                                    <ol>
                                        <li>
                                            Provision of financial information to management for day-to-day activities and other supervisory bodies- Accountant General Office, Auditor General Office, National University Commission and other relevant governmental agencies.
                                        </li>
                                        <li>Responsible for the preparation of the University accounts and its statutory audit as at when due.</li>
                                        <li>Liaise with financial Institutions, Banks, Insurance companies, Pension fund Administrators on behalf of the University.</li>
                                        <li>Recipient and custodian of study and other materials of the University.</li>
                                        <li>Act as interface with students having PIN Code problems.</li>
                                        <li>Assisting students in their registration exercise.</li>
                                        <li>Budget and budgetary control and continual matching of budget to actual for variance analysis purpose.</li>
                                        <li>Advice management on variances that would impact negatively on the school’s finances.</li>
                                    </ol>
                                </p>
                                
                                <a href="https://nou.edu.ng/bursary/" target="_blank" style="text-decoration:none; float:right">Read more...</a>
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'from_lib')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" style="width:155px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Office of the Librarian</b>
                                
                                <p>
                                    I heartily welcome our distinguished clients to National Open University of Nigeria (NOUN) Library. It is pertinent to inform you that NOUN library is a hybrid service delivery library with about twenty-seven (27) study centre libraries including regional libraries. In addition, NOUN has central library (Gabriel Afolabi Ojo Central Library) located at headquarters in Jabi, Abuja. Also at the headquarters there are eight (8) faculty libraries

                                    The library collection consists of both print and electronic resources. Similarly, the library uninterruptedly subscribes to some library databases such as lawpavilion, Jstor, Sciencedirect etc annually.

                                    Our esteemed users can access any of the libraries between the hours of 8:00 - 16:00 Monday-Friday. Meanwhile, the E-resources are available to users at their convenience. Access details can be obtained from any of the study centre libraries.
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

                                <b>Brief history of NOUN Library</b>
                                <p>
                                    National Open University of Nigeria (NOUN) library was established in 2007 with seating capacity of about forty-eight (48). Library operations in NOUN commenced at Lagos liaison office which was formally NOUN headquarters before the headquarters was moved to Abuja in year 2016. The movement of NOUN headquarters to Abuja automatically necessitated the movement of the central library alongside. The new central library (Gabriel Afolabi Ojo Central Library) was commissioned on the 9th February, 2021 and formally opened for operation on 4th July, 2021.

                                    The size of the Central Library is with seating capacity of about 650. The central library is a  beehive of activities as it coordinates the activities of the zonal, faculties and study centre libraries.

                                    Organizational structure: the University librarian is the overall head of the entire library system. There are other professionals, para-professionals and supportive staff for the smooth running of the library. The library system consist of:
                                </p>

                                <a href="https://nou.edu.ng/library/" target="_blank" style="text-decoration:none; float:right">Read more...</a>
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
                    }else if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] == 'from_dean')
                    {?>
                        <div class="appl_left_child_div_child calendar_grid course_line">
                            <div style="text-align:center; flex:20%; height:auto; background-color: #ffffff;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png');?>" style="width:155px; height:180px; margin:auto;"/>
                            </div>
                            <div class="inlin_message_color" style="flex:65%; padding:10px; background-color: #ffffff; height:auto;">
                                <b>Dean, Faculty of <?php echo $vFacultyDesc_loc;?></b><?php
                                if ($cFacultyId_loc == 'AGR')
                                {?><br>
                                    Professor Ahmed A. Njidda
                                    <p>
                                        It is my pleasure to welcome you to the Faculty of Agricultural Sciences, National Open University of Nigeria. This handbook is a maiden issued by the Faculty of Agricultural Sciences (FAS) which contains the rules and regulations governing the undergraduate programmes in the Faculty. The handbook is a must for all students of the Faculty. The information contained in it is necessary for students' registration, choice, of course, programme planning, duration of the study and other relevant information that will help the students during their stay in the National Open University of Nigeria (NOUN). It also contains a brief history of the University and the Faculty of Agricultural Sciences, the SIWES/Farm Practical Year, Laboratory practicals, as well as Teaching and Research Farm. The handbook is, therefore, necessary for all students who want to study Agricultural Sciences at the National Open University of Nigeria (NOUN).
                                    </p>

                                    <a href="https://fas.nou.edu.ng/" target="_blank" style="text-decoration:none; float:right">Read more...</a><?php
                                }else if ($cFacultyId_loc == 'ART')
                                {?><br>
                                    Professor Iyabode Omolara Akewo Nwabueze
                                    <p>
                                        Welcome! Soyez les bienvenus! E kaabo! Nnor! Sannu de zuwa! !مرحبا بك/ أهلا وسهلا

                                        I welcome you to the Faculty of Arts, where we build people as citizens of our great country, Nigeria, as well as create human capital as asset for the nation. I say to you that you have made the right decision by choosing to study the liberal arts. No matter where we go and what we do, humanity is the core of all existence. Technology without humanness is disaster waiting to happen! 
                                    </p>

                                    <a href="https://foa.nou.edu.ng/" target="_blank" style="text-decoration:none; float:right">Read more...</a><?php
                                }else if ($cFacultyId_loc == 'CMP')
                                {?><br>
                                    Dr. Greg Onwodi.
                                    <p>
                                        It is my pleasure to welcome you to the Faculty of Computing (FOC) of the National Open University of Nigeria (NOUN). FOC was established in 2023 following senate’s approval at its hybrid 104th meeting held on Tuesday. 5th September 2023. The faculty is blessed with twenty-eight full time Academic staff and several Facilitators/part time academic staff with PHD and specialisation in various fields of Computing.
                                    </p>

                                    <a href="https://foc.nou.edu.ng/" target="_blank" style="text-decoration:none; float:right">Read more...</a><?php
                                }else if ($cFacultyId_loc == 'EDU')
                                {?><br>
                                    Professor Bamikole Ogunleye
                                    <p>
                                        Welcome to the Faculty of Education (FOE) of the National Open University of Nigeria (NOUN). The faculty which started as a school is one of the foundation faculties of the National Open University of Nigeria, and is fondly referred to as, the mother of all Faculties. The faculty is blessed with about eighty (80) full time academic staff and hundreds of other part time academic staff who are PhD holders in their various specializations, across the 36 states and the Federal Capital territory. There are five departments in the Faculty. Namely:
                                    </p>

                                    <a href="https://foe.nou.edu.ng/" target="_blank" style="text-decoration:none; float:right">Read more...</a><?php
                                }else if ($cFacultyId_loc == 'HSC')
                                {?><br>
                                    Professor Shehu Usman Adamu
                                    <p>
                                        You are welcome to the Faculty of Health Sciences, National Open University of Nigeria. The Faculty was established recently, arising from the need to provide lifelong learning for health workers.  The Faculty attempts to ensure that training emphasizes relevance, rather than just academic knowledge. The Faculty is intended to achieve two closely related objectives; one is to produce a broad range of health manpower that will serve the depressed and underserved rural and peri-urban communities in Nigeria, and the other is to design test programme models for health manpower development that would be replicable in various parts of the country, and hopefully in other countries of the world where health conditions are similar to those of Nigeria. 
                                    </p>

                                    <a href="https://fohs.nou.edu.ng/" target="_blank" style="text-decoration:none; float:right">Read more...</a><?php
                                }else if ($cFacultyId_loc == 'SCI')
                                {?><br>
                                    Professor Kolawole Lawal
                                    <p>
                                        The Faculty started as the School of Science and Technology at inception, In 2016, the University adopted the faculty system with defined departments and the School of Science and Technology metamorphosed into the Faculty of Sciences. The Faculty of Sciences has six departments namely; Department of Computer Science, Department of Environmental Sciences, Department of Mathematics,  the Department of Biology, Department of  Chemistry and Department of Physics.
                                    </p>

                                    <a href="https://fos.nou.edu.ng//" target="_blank" style="text-decoration:none; float:right">Read more...</a><?php
                                }else if ($cFacultyId_loc == 'SSC')
                                {?><br>
                                    Professor Kamal Deen Bello
                                    <p>
                                        Welcome to Faculty of Social Sciences that was created in 2016 through the restructuring from the former Schools and Units system to Faculty and Departmental system by the new Vice Chancellor. You as a member of this Faculty should make yourself a good ambassador by performing excellently in your chosen careers. The Faculty has produced many first class graduates in various programmes out of which one is currently our Faculty member.
                                    </p>

                                    <a href="https://fss.nou.edu.ng//" target="_blank" style="text-decoration:none; float:right">Read more...</a><?php
                                }else if ($cFacultyId_loc == 'MSC')
                                {?><br>
                                    Professor Wilfred N. J. Ugwuanyi
                                    <p>
                                        It is my pleasure, delight and singular honour to heartily welcome you to the great Faculty of Management Sciences! On behalf of the Vice-Chancellor and the entire Staff of the Faculty I also thank you for choosing to study at the Faculty of Management Sciences.

                                        The National Open University of Nigeria stands out as a 21st Century University and this uniqueness transcends beyond her four walls in offering cutting edge Programmes in the various Faculties.
                                    </p>

                                    <a href="https://fms.nou.edu.ng//" target="_blank" style="text-decoration:none; float:right">Read more...</a><?php
                                }else if ($cFacultyId_loc == 'LAW')
                                {?><br>
                                    Professor Ernest O. Ugbejeh
                                    <p>
                                        I heartily congratulate those students who have the privilege of being admitted into the Faculty of Law.
                                        As a starting point, you are encouraged to go through the Faculty Handbook.The handbook contains information that are vital in guiding the students and to assist them in the course of their study,in registration for the required number of core courses and the choice of the elective courses. For the avoidance of doubt, where an elective course is taken by a student in the first semester, the corresponding elective course must be taken in the second semester.
                                    </p>

                                    <a href="https://fol.nou.edu.ng//" target="_blank" style="text-decoration:none; float:right">Read more...</a><?php
                                }else if ($cFacultyId_loc == 'DEG')
                                {
                                    
                                }else if ($cFacultyId_loc == 'CHD')
                                {
                                    
                                }?>
                            </div>
                            <div class="middle_right" style="flex:20%; padding-left:4px; height:auto;"></div>
                        </div><?php
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