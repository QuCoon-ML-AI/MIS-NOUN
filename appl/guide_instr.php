<?php
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('const_def.php');
require_once('../../fsher/fisher.php');
require_once('lib_fn.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/guideinstr.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body>
        <div id="smke_screen" class="smoke_scrn" style="opacity:0.9;"></div>
        <div id="video1_div" style="text-align:center; display: none;" class="center">
            <div style="line-height:1.5; width:20; position:absolute; top:10px; right:10px; z-index:7">
                <img style="width:17px; height:17px; cursor:pointer" src="./img/close.png" 
                onclick="_('video1').pause();
                    _('video1_div').style.zIndex = -1;
                    _('video1_div').style.display = 'none';
                    _('smke_screen').style.zIndex = -1;
                    _('smke_screen').style.display = 'none';"/>
            </div>
            <video id="video1" style="width:70vw" controls>
                <source src="./img/student_demo_video_1.mp4" type="video/mp4">
                Your browser does not support HTML video.
            </video>
        </div>

        <div id="video2_div" style="text-align:center; display: none;" class="center">
            <div style="line-height:1.5; width:20; position:absolute; top:10px; right:10px; z-index:7">
                <img style="width:17px; height:17px; cursor:pointer" src="./img/close.png" 
                onclick="_('video2').pause();
                    _('video2_div').style.zIndex = -1;
                    _('video2_div').style.display = 'none';
                    _('smke_screen').style.zIndex = -1;
                    _('smke_screen').style.display = 'none';"/>
            </div>
            <video id="video2" style="width:70vw" controls>
                <source src="./img/student_demo_video_2.mp4" type="video/mp4">
                Your browser does not support HTML video.
            </video>
        </div>

        <form method="post" name="ps" enctype="multipart/form-data">
            <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
            <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
            <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else if (isset($GLOBALS['cEduCtgId'])){echo $GLOBALS['cEduCtgId'];}?>" />
            <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
        </form>

        <div class="appl_container">
            <?php left_conttent('Procedural steps on how to do things');?>
            
            <div class="appl_right_div" style="font-size:1em;">                
                <div class="data_line data_line_logout" style="display:flex; padding:0px; width:98.7%; height:auto; margin-top:5px; justify-content:space-between;">
                    <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
                        <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
                            onclick="ps.sidemenu.value=''; ps.target='_self';ps.action='../';
                                ps.submit();">
                            <img width="25" height="22" src="./img/home.png" alt="Home">
                            <br>Home</button>
                    </div>
                    
                    <div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
                        <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
                        onclick="_('smke_screen').style.zIndex=5;
                        _('smke_screen').style.display='block';
                        _('video1_div').style.zIndex=6;
                        _('video1_div').style.display='flex';
                        _('video1').play()">
                        <img width="22" height="22" src="./img/play.png" alt="Play">
                        <br>Video1</button>
                    </div>
                    
                    
                    <div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
                        <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
                        onclick="_('smke_screen').style.zIndex=5;
                        _('smke_screen').style.display='block';
                        _('video2_div').style.zIndex=6;
                        _('video2_div').style.display='flex';
                        _('video2').play()">
                        <img width="22" height="22" src="./img/play.png" alt="Play">
                        <br>Video2</button>
                    </div>
                </div>

                <div class="appl_left_child_div" style="text-align: left; margin:auto; width:98%; margin-top:5px; background-color: #eff5f0;">
                    <div class="appl_left_child_div_child" style="cursor:not-alowed;">
                        <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;"></div>
                        <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #fdf0bf;">
                            You may have to click the 'Home' button before excuting the first step of each procedure
                        </div>
                    </div>
                </div>
                
                <div class="appl_left_child_div" style="text-align: left; margin:auto; width:98%; margin-top:5px; overflow:auto; background-color: #eff5f0;">
                    <div class="appl_left_child_div_child" style="cursor:not-alowed;">
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;"></div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; font-weight:bold; background-color: #ffffff;">
                                Application for admission
                            </div>
                    </div>

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;"
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
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                A
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Check your qualification against available programmes
                            </div>
                    </div>
                    <div id="div1" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                                <ol>
                                    <li>
                                        Click 'Admission'
                                    </li>
                                    <li>
                                        Click 'Am I qualified'
                                    </li>
                                    <li>
                                        Select faculty
                                    </li>
                                    <li>
                                        Select department
                                    </li>
                                    <li>
                                        Select programme
                                    </li>
                                    <li>
                                        Select level
                                    </li>
                                    <li>
                                        Click the 'Next' button
                                    </li>
                                </ol> 
                            </div>
                    </div>

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
                        onClick="if(_('div2').style.display=='flex')
                        {
                            _('div2').style.display='none'
                            _('div2minus').style.display='none'
                            _('div2plus').style.display='none';
                        }else
                        {
                            _('div2').style.display='flex'
                            _('div2minus').style.display='block'
                            _('div2plus').style.display='none';
                        }return false">
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                B
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Apply for admission
                            </div>
                    </div>
                    <div id="div2" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                                <ol style="margin-bottom:20px;">
                                    <li>
                                        Click on the 'Admission'
                                    </li>
                                    <li>
                                        Click on the 'Apply for admission'
                                    </li>
                                    <li>
                                        Click 'Yes' if you have checked your credentials against the requirements for the programme of your choice otherwise, click 'No' and check as applicable
                                    </li>
                                    <li>
                                        Follow the guide in the pop-up box if applicable otherwise, close it
                                    </li>
                                    <li>
                                        Select/enter all options as applicable
                                    </li>
                                    <li>
                                        Click on the 'Next' button
                                    </li>
                                    <li>
                                        Click on 'Details confirmed' button after confirming displayed pieces of information
                                    </li>
                                    <li>
                                        Re-confirm payment details, click on 'Yes' and then on 'Make payment' button
                                    </li>
                                    <li>
                                        On the remita page, confirm displayed information and click on the 'Submit' button
                                    </li>
                                    <li>
                                        Select applicable payment option and click on 'Make payment' button
                                    </li>
                                    <li>
                                        Still at the remita end, follow the prompts on the screen.
                                    </li>
                                    <li style="height:auto">
                                        When you enter your one-time-password (OTP) and click the submit button, it is <b>strongly advised</b> that you do not do anything on the keyboard, mouse or screen until you are returned to NOUN page
                                    </li>
                                    <li style="border:none;">
                                        You will be debited and returned (if there was no interruption) to NOUN page. Follow the instructions and note the pieces of information on the screen
                                    </li>
                                </ol> 
                            </div>
                    </div>

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
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
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                C
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                             Check/complete payment for application form. Applicable to cases of incomplete payment transaction
                            </div>
                    </div>
                    <div id="div3" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                                <ol style="margin-bottom:20px;">
                                    <li>
                                        Click on the 'Apply for admission' icon on the left side of the screen
                                    </li>
                                    <li>
                                        Select/enter all options as applicable
                                    </li>
                                    <li>
                                        Click on the 'Submit' button
                                    </li>
                                    <li>
                                        Click on 'Details confimed' button after confirming displayed pieces of information
                                    </li>
                                    <li>
                                        Re-confirm payment details, click on 'Yes' and then on 'Make payment' button
                                    </li>
                                    <li>
                                        On the remita page, confirm displayed information and click on the 'Submit' button
                                    </li>
                                    <li>
                                        Select applicable payment option and click on 'Make payment' button
                                    </li>
                                    <li>
                                        Still at the remita end, follow the prompts on the screen.
                                    </li>
                                    <li style="height:auto">
                                        When you enter your one-time-password (OTP) and click the submit button, it is <b>srongly advised</b> that you do not do anything on the keyboard, mouse or screen until you are returned to NOUN page
                                    </li>
                                    <li style="border:none;">
                                        You will be debited and returned (if there was no interuption) to NOUN page. Follow the intructions and note the pieces of information on the screen
                                    </li>
                                </ol> 
                            </div>
                    </div>

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
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
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                D
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Login to the application form
                            </div>
                    </div>
                    <div id="div4" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                        <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                            <ol>
                                <li>
                                    Click 'Home'
                                </li>
                                <li>
                                    Click 'Admission'
                                </li>
                                <li>
                                    Click on 'Return to application form'
                                </li>
                                <li>
                                    Enter your application form number and your password
                                </li>
                                <li>
                                    Click on the 'Login' button
                                </li>
                                <li>
                                    Follow the prompts on the screen
                                </li>
                            </ol> 
                        </div>
                    </div>

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
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
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                E
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Fill/edit the application form
                            </div>
                    </div>
                    <div id="div5" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                        <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                            <ol>
                                <li>
                                    Sections of the application form must be completed sequentially. Skipping is not allowed.
                                </li>
                                <li style="margin-bottom:12px">
                                    The top of the head, the front baseline of the neck and the two ears must be clearly visible on the passport picture
                                </li>
                                <li>
                                    To delete one or more of the credentials you have entered <span style="color:#ff9666">(possible only if every section of the applicaforn form has been completed)</span>
                                </li>
                                <dl>
                                    <!-- <dt>To delete one or more of the credentials you have entered</dt> -->
                                    <dd>a. Click on the 'Preview form' button (top) if you are not on the form preview page</dd>
                                    <dd>b. Scroll to the 'Academic history' section</dd>
                                    <dd>c. Click on the corresponding 'edit' icon <!-- <img src="img/delete.gif" title="Looks like this" border="0" />--></dd> 
                                    <dd>d. Click on the button for the credential</dd>
                                    <dd>e. Click on the 'Delete' button</dd>
                                    <dd>f. Confirm your intention</dd>
                                </dl>

                                <li>
                                    To access/edit any section of your application form from the form preview page 
                                </li>
                                <dl>
                                    <!-- <dt>To access/edit any section of your application form from the form preview page</dt> -->
                                    <dd>a. Click on the corresponding edit icon <!-- <img src="img/edit.gif" title="Looks like this" border="0" />--></dd>
                                    <dd>b. Make adjustments as applicable</dd>
                                    <dd>c. Click on the 'Next' button to save changes and move to the next page</dd>
                                </dl>
                            </ol> 
                        </div>
                    </div>

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
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
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                F
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Submit application form
                            </div>
                    </div>
                    <div id="div6" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                        <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                            <ol>
                                <li>
                                Login to the application form as described in D above
                                </li>
                                <li>
                                    Complete all the sections(1 - 6) of the form
                                </li>
                                <li>
                                    Click on the 'Submit' button at the right bottom area on the form preview page 
                                </li>
                                <li>
                                    Read the message on the screen carefully and respond accordingly
                                </li>
                                <li>
                                    Read and follow the guides on the screen
                                </li>
                            </ol>
                        </div>
                    </div>

                    
                    <div class="appl_left_child_div_child" style="text-align:left;
                        cursor:not-alowed;">
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;"></div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; font-weight:bold; background-color: #ffffff;">
                                Registration
                            </div>
                    </div>

                    
                    <div  class="appl_left_child_div_child" style="cursor:not-alowed;">
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                G
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Visit your study centre of choice for screening
                            </div>
                    </div>

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
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
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                H
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Check admission/application status
                            </div>
                    </div>
                    <div id="div7" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                                <ol>
                                    <li>
                                        Login to the application form as described in D above
                                        </li>
                                        <li>
                                            Follow the instruction on the screen.
                                        </li>
                                        <li>
                                            Read the pieces of information and follow the instruction(s) on the page. Your admission/application status will be reflected here
                                        </li>
                                </ol>
                            </div>
                    </div>

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;"
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
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                I
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Sign-up with your matriculation number (one-time action, only possible if you are screened qualified)
                            </div>
                    </div>
                    <div id="div8" class="appl_left_child_div_child" style=" margin-top:-15px; display:none;">
                        <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                            <ol>
                                <li>
                                    Click on 'Fresh student' icon on the lower left area of the page
                                </li>
                                <li>
                                    Fill in the boxes according to the labels
                                </li>
                                <li>
                                    Be mindful of what you type as your password and answer to your security question 
                                </li>
                                <li>
                                    Click the 'Submit' button.
                                </li>
                                <li>
                                    Read the instruction that pops up on the screen and take step(s) accordingly 
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
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
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                J
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Sign-in with your matriculation number
                            </div>
                    </div>
                    <div id="div9" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                                <ol>
                                    <li>
                                        Click on 'Registered student'
                                    </li>
                                    <li>
                                        Enter your matriculation number and password accordingly
                                    </li>
                                    <li>
                                        Click the 'Login' button.
                                    </li>
                                    <li>
                                        Read the instruction that pops up on the screen and take step(s) accordingly 
                                    </li>
                                    <li>
                                        Note the calendar summary that pops up and click to remove 
                                    </li>
                                </ol>
                            </div>
                    </div>

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
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
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                K
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Register for new session or second semester (Pay session/semester registration fee)
                            </div>
                    </div>
                    <div id="div10" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                                <ol>
                                    <li>
                                        Sign-in as descibed in procedure J
                                    </li>
                                    <li>
                                        Click on 'Register for the semester' on the left side of your home page
                                    </li>
                                    <li>
                                        Note the fee break-down that pops up and click on 'Yes' at the bottom of the pop-up
                                    </li>
                                    <li>
                                        Read the pieces of information and instruction on the page
                                    </li>
                                    <li>
                                        Answer the question below the boxed instruction to confirm your intention
                                    </li>
                                    <li>
                                        Click on the Submit button and you will be directed to remita site
                                    </li>
                                    <li>
                                        On remita site, note the peices of information and click the submit button if they are correct. Else, re-start the process.
                                    </li>
                                    <li>
                                        On the pop-up box that comes up, click on your choice of payment (card option is the default) and follow the prompt on the screen
                                    </li>
                                    <li>
                                        When the payment is successful, you will be re-directed back to your section of the University portal. <b>Wait for this redirection to complete before you do anything else on the screen</b>.
                                    </li>
                                    <li>
                                        Read and follow the instructions on the page carefully
                                    </li>
                                    <li>
                                        Click on 'Register courses' and check the box corresponding to each course of interest.
                                    </li>
                                    <li>
                                        Click on the 'Submit' button on the lower right area of the screen
                                    </li>
                                    <li>
                                        Confirm your selections
                                    </li>
                                    <li>
                                        Bring up your course registration slip by clicking on 'Course registration slip'
                                    </li>
                                    <li>
                                        Print and keep a copy of the slip for future reference
                                    </li>
                                </ol>
                            </div>
                    </div>

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
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
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                L
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Register courses
                            </div>
                    </div>
                    <div id="div11" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                                <ol>
                                    <li>
                                        Sign-in as descibed in procedure J
                                    </li>
                                    <li>
                                        Close the pop-up event calendar and any other pop-up box
                                    </li>
                                    <li>
                                        If you have already done 1 and 2, return to the page from which you came here and click the 'My home' button (top)
                                    </li>
                                    <li>
                                        Close any pop-up box
                                    </li>
                                    <li>
                                        Click 'Register courses'
                                    </li>
                                    <li>
                                        Click courses to register
                                    </li>
                                    <li>
                                        Click 'Submit' button
                                    </li>
                                    <li>
                                        Confirm your intention
                                    </li>
                                </ol>
                            </div>
                    </div>

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
                        onClick="if(_('div12').style.display=='flex')
                        {
                            _('div12').style.display='none'
                            _('div12minus').style.display='none'
                            _('div12plus').style.display='block';
                        }else
                        {
                            _('div12').style.display='flex'
                            _('div12minus').style.display='block'
                            _('div12plus').style.display='none';
                        }return false">
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                M
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Register courses for exam
                            </div>
                    </div>
                    <div id="div12" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                        <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                            <ol>
                                <li>
                                    Sign-in as descibed in procedure J
                                </li>
                                <li>
                                    Close the pop-up event calendar
                                </li>
                                <li>
                                    Click 'Register courses for exam'
                                </li>
                                <li>
                                    Click courses to be registered for exam
                                </li>
                                <li>
                                    Click 'Submit' button
                                </li>
                                <li>
                                    Confirm your intention
                                </li>
                            </ol>
                        </div>
                    </div>

                    
                    <div class="appl_left_child_div_child" style="cursor:not-alowed;">
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;"></div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; font-weight:bold; background-color: #ffffff;">
                                Others
                            </div>
                    </div>

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
                        onClick="if(_('div13').style.display=='flex')
                        {
                            _('div13').style.display='none'
                            _('div13minus').style.display='none'
                            _('div13plus').style.display='block';
                        }else
                        {
                            _('div13').style.display='flex'
                            _('div13minus').style.display='block'
                            _('div13plus').style.display='none';
                        }return false">
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                N
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Drop courses (if applicable)
                            </div>
                    </div>
                    <div id="div13" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                            <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                                <ol>
                                    <li>
                                        Sign-in as descibed in procedure J
                                    </li>
                                    <li>
                                        Click 'See course registration slip'
                                    </li>
                                    <li>
                                        Click 'Courses to be dropped drop'
                                    </li>
                                    <li>
                                        Click 'Drop course' at the top of the list of courses
                                    </li>
                                    <li>
                                        Confirm your intention
                                    </li>
                                </ol>
                            </div>
                    </div>

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
                        onClick="if(_('div14').style.display=='flex')
                        {
                            _('div14').style.display='none'
                            _('div14minus').style.display='none'
                            _('div14plus').style.display='block';
                        }else
                        {
                            _('div14').style.display='flex'
                            _('div14minus').style.display='block'
                            _('div14plus').style.display='none';
                        }return false">
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                O
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Drop courses for exam (if applicable)
                            </div>
                    </div>
                    <div id="div14" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                        <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                            <ol>
                                <li>
                                    Sign-in as descibed in procedure J
                                </li>
                                <li>
                                    Click 'See exam registration slip'
                                </li>
                                <li>
                                    Click 'Courses to drop for exam'
                                </li>
                                <li>
                                    Click 'Drop exam'
                                </li>
                                <li>
                                    Confirm your intention
                                </li>
                            </ol>
                        </div>
                    </div>

                    <!--<div class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
                        onClick="if(_('div15').style.display=='flex')
                        {
                            _('div15').style.display='none'
                            _('div15minus').style.display='none'
                            _('div15plus').style.display='block';
                        }else
                        {
                            _('div15').style.display='flex'
                            _('div15minus').style.display='block'
                            _('div15plus').style.display='none';
                        }return false">
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                P
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Check payment status/Validate payment
                            </div>
                    </div>
                    <div id="div15"  class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                        <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                            <ol>
                                <li>
                                    Sign-in as descibed in procedure J
                                </li>
                                <li>
                                    Click on 'Check payment status'
                                </li>
                                <li>
                                    Enter the RRR (on the remita receipt) for the payment
                                </li>
                                <li>
                                    Click on the 'Check' buttom
                                </li>
                                <li>
                                    Note the payment status message that pops up next to the RRR
                                </li>
                            </ol>
                        </div>
                    </div>-->

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
                        onClick="if(_('div16').style.display=='flex')
                        {
                            _('div16').style.display='none'
                            _('div16minus').style.display='none'
                            _('div16plus').style.display='block';
                        }else
                        {
                            _('div16').style.display='flex'
                            _('div16minus').style.display='block'
                            _('div16plus').style.display='none';
                        }return false">
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                P
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Check payment status/Validate payment
                            </div>
                    </div>
                    <div id="div16"  class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                        <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                            <ol>
                                <li>
                                    Sign-in as descibed in procedure J
                                </li>
                                <li>
                                    Click on 'Check payment status'
                                </li>
                                <li>
                                    Enter the RRR (on the remita receipt) for the payment
                                </li>
                                <li>
                                    Click on the 'Check' buttom
                                </li>
                                <li>
                                    Note the payment status message that pops up next to the RRR
                                </li>
                                <li>
                                    If payment is confirmed, the 'See payment receipt' button will be displayed under the RRR you entered. Click the button to see your receipt
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
                        onClick="if(_('div17').style.display=='flex')
                        {
                            _('div17').style.display='none'
                            _('div17minus').style.display='none'
                            _('div17plus').style.display='block';
                        }else
                        {
                            _('div17').style.display='flex'
                            _('div17minus').style.display='block'
                            _('div17plus').style.display='none';
                        }return false">
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Q
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Make payment (Only available on your home page)
                            </div>
                    </div>
                    <div id="div17" class="appl_left_child_div_child" style="margin-top:-15px; display:none;">
                        <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                            <ol>
                                <li>
                                    Sign-in as descibed in procedure J
                                </li>
                                <li>
                                    Click on 'Make payment' on the lower right area of the page
                                </li>
                                <li>
                                    Note the fee break-down that pops up and click on 'Yes' at the bottom of the pop-up (optional)
                                </li>
                                <li>
                                    Read the pieces of information and instructions on the page
                                </li>
                                <li>
                                    Answer the question below the boxed instruction to confirm your intention
                                </li>
                                <li>
                                    Click on the 'Complete payment' button and you will be directed to remita site
                                </li>
                                <li>
                                    On remita site, note the peices of information and click the submit button if they are correct
                                </li>
                                <li>
                                    On the pop-up box that comes up, click on your choice of payment (card option is the default)
                                </li>
                                <li>
                                    Enter the required numbers and click the submit button
                                </li>
                                <li>
                                    Enter the OTP sent to your phone and click the submit button
                                </li>
                                <li>
                                    When the payment is successful, you will be re-directed back to your section of the University portal. Wait for this redirection to complete before you do anything else on the screen.
                                </li>
                                <li>
                                    Read and follow the instructions on the page carefully
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div  class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
                        onClick="if(_('div18').style.display=='flex')
                        {
                            _('div18').style.display='none'
                            _('div18minus').style.display='none'
                            _('div18plus').style.display='block';
                        }else
                        {
                            _('div18').style.display='flex'
                            _('div18minus').style.display='block'
                            _('div18plus').style.display='none';
                        }return false">
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                R
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Check result
                            </div>
                    </div>
                    <div class="appl_left_child_div_child" id="div18" style="margin-top:-15px; display:none;">
                        <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                            <ol>
                                <li>
                                    Sign-in as descibed in procedure J
                                </li>
                                <li>
                                    Click on 'My progress' at the top right area of your home page.
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div  class="appl_left_child_div_child red-effect" style="cursor:pointer;" 
                        onClick="if(_('div19').style.display=='flex')
                        {
                            _('div19').style.display='none'
                            _('div18minus').style.display='none'
                            _('div18plus').style.display='block';
                        }else
                        {
                            _('div19').style.display='flex'
                            _('div18minus').style.display='block'
                            _('div18plus').style.display='none';
                        }return false">
                            <div style="flex:5%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                S
                            </div>
                            <div style="flex:95%; height:50px; text-indent:5px; margin-bottom:4px; background-color: #ffffff;">
                                Print student ID card
                            </div>
                    </div>
                    <div class="appl_left_child_div_child" id="div19" style="margin-top:-15px; display:none;">
                        <div style="flex:100%; height:auto; margin-bottom:4px; background-color: #ffffff;">
                            <ol>
                                <li>
                                    Sign-in as descibed in procedure J
                                </li>
                                <li>
                                    Click on 'Registry' on the top horizontal second level list of menu items of your home page.
                                </li>
                                <li>
                                    Click 'Print identity card' left on the left side of your home page
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</body>
</html>