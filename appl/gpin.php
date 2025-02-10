<?php
if (!isset($_REQUEST['user_cat']))
{?>
    <div style="font-family:Verdana, Arial, Helvetica, sans-serif; 
    margin:auto; 
    text-align:center;
	font-size: 0.78em;"> Follow <a href="../" style="text-decoration:none;">here</a></div><?php
    exit;
}
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('lib_fn.php');
require_once('const_def.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/gpin.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/gpin.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body>
    
        <form method="post" name="ps" enctype="multipart/form-data">
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
            <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
        </form>
        
        <?php $mysqli = link_connect_db();?>

        <div id="smke_screen_2" class="smoke_scrn" style="display:block; z-index:2"></div>
        
        <div id="conf_box_loc" class="center top_most" 
            style="display:block;
            text-align:center; 
            padding:10px; 
            box-shadow: 2px 2px 8px 2px #726e41; 
            background:#FFFFFF; 
            z-index:6">
            <div style="width:90%; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                Confirmation
            </div>
            <a href="#" style="text-decoration:none;">
                <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
            </a>
            <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:20px; width:100%; float:left; text-align:left; font-size:1em; padding:0px;">
                Have you checked your credentials against the requirements for admission into your programme of choice?
            </div>
            <div style="margin-top:20px; width:90%; float:right; text-align:right; padding:0px;">
                <a href="#" style="text-decoration:none;" 
                    onclick="_('conf_box_loc').style.display='none';
                    _('conf_box_loc').style.zIndex='-1';
                    _('application_steps').style.display = 'block';
                    _('conf_box_loc').style.zIndex='3';
                    return false">
                    <div class="login_button" style="width:60px; padding:6px; margin-left:10px; float:right">
                        Yes
                    </div>
                </a>

                <a href="#" style="text-decoration:none;" 
                    onclick="in_progress('1'); ps.action='check-qualification'; ps.submit(); return false">
                    <div class="rec_pwd_button" style="width:60px; padding:6px; float:right">
                        No
                    </div>
                </a>
            </div>
        </div>
        
        <div id="tel_phd_available" class="center top_most" 
            style="display:none;
            text-align:center; 
            padding:10px; 
            box-shadow: 2px 2px 8px 2px #726e41; 
            background:#FFF; 
            z-index:4;">
            <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                Information
            </div>
            <a href="#" style="text-decoration:none;">
                <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
            </a>
            <div id="conf_msg_msg_loc" style="line-height:2; margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                Doctrate programmes are only available in the following departments:<p><?php
                $sql = "SELECT DISTINCT a.vFacultyDesc, b.vdeptDesc
                FROM faculty a, depts b, programme c
                WHERE a.cFacultyId = b.cFacultyId
                AND b.cdeptId = c.cdeptId
                AND c.cEduCtgId = 'PRX'
                AND c.`cDelFlag` = 'N'
                ORDER BY a.vFacultyDesc";
                $rssqlEduCtgId = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));

                $choice_count = 0;
                $prev_fac = '';?>
                <table style="width:100%"><?php
                while ($r_rssqlEduCtgId = mysqli_fetch_assoc($rssqlEduCtgId))
                {
                    if ($prev_fac == '' || $prev_fac <> $r_rssqlEduCtgId["vFacultyDesc"])
                    {?>
                        <tr style="font-weight:bold">
                            <td colspan=2><?php echo "Faculty of ".$r_rssqlEduCtgId["vFacultyDesc"];?></td>
                        </tr><?php
                        $choice_count = 0;
                    }?>
                    <tr>
                        <td><?php echo ++$choice_count;?></td>
                        <td><?php echo $r_rssqlEduCtgId["vdeptDesc"];?></td>
                    </tr><?php
                    $prev_fac = $r_rssqlEduCtgId["vFacultyDesc"];
                }
                mysqli_close(link_connect_db());?>
                </table>
            </div>
            <div style="margin-top:10px; width:100%; float:left; text-align:right; padding:0px;">
                <a href="#" style="text-decoration:none;" 
                    onclick="_('tel_phd_available').style.display='none';
                    _('smke_screen_2').style.display='none';
                    _('smke_screen_2').style.zIndex='-1';
                    _('labell_msg0').style.display = 'none';
                    return false">
                    <div class="login_button" style="width:60px; padding:6px; margin-left:6px; float:right">
                        Ok
                    </div>
                </a>
            </div>
        </div>
       
        <div id="application_steps" 
            style="display:none; 		
            text-align:center; 
            padding:10px;  
            padding-right:3px; 
            box-shadow: 2px 2px 8px 2px #726e41; 
            background:#fff; 
            z-index:3;
            opacity:0.9;" 
			onclick="_('smke_screen_2').style.display='none';
			_('smke_screen_2').style.zIndex='-1';">
            <div style="width:96.5%; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold; height:35px; line-height:2.0;" 
                data-tooltip="See step-wise procedure to follow here">
                    Steps for Application for Admission
            </div>
            <a href="#" style="text-decoration:none;" 
                onclick="_('application_steps').style.display='none';
                _('smke_screen_2').style.display='none';
                _('smke_screen_2').style.zIndex='-1';">
                <div style="width:20px; text-align:center; padding:0px; position:absolute; top:12px; right:12px">
                    <img style="width:17px; height:17px" src="./img/close.png"/>
                </div>
            </a>
            
            <div style="width:99.8%;
                margin:0px;
                margin-top:5px;
                padding:0px;
                max-height: 544px; 
                overflow-x: hidden;">
                <div class="innercont_stff guide_instruct" style="width:100%; padding:4px; margin-top:0px; float:left; height:auto; text-align:left; background:#fafffb; border:0px dashed #82ad8b; cursor:pointer" 
                    onClick="if(_('div1').style.display=='block')
                    {
                        _('div1').style.display='none'
                        _('div1minus').style.display='none'
                        _('div1plus').style.display='block';
                    }else
                    {
                        _('div1').style.display='block'
                        _('div1minus').style.display='block'
                        _('div1plus').style.display='none';
                    }return false">
                    <div id="div1plus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:block;">&plus;</div>
                    <div id="div1minus" style="cursor:pointer; float:left; width:10px; height:inherit; text-align:center;display:none;">&minus;</div>
                    <div style="float:left; width:auto; height:inherit;">
                        A. Check your qualification against available programmes (Step can be executed on the home page)
                    </div>
                </div>
                
                <div id="div1" style="width:100%; margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left; display:none;">
                    <ol>
                        <li>
                            Click on 'Admission'
                        </li>
                        <li>
                            Click on  'Am I qualified'
                        </li>
                        <li>
                            Select options as applicable
                        </li>
                        <li>
                            Click on 'Next' button
                        </li>
                        <li>
                            Check the criteria on the screen against what is on your credential to ascertain your eligibility for the selected programme at the selecte level
                        </li>
                    </ol> 
                </div>

                <div class="innercont_stff guide_instruct" style="width:100%; margin-top:10px; padding:4px; float:left; height:auto; text-align:left; background:#fafffb;  border-top:1px dashed #82ad8b; cursor:pointer;" 
                    onClick="if(_('div2').style.display=='block')
                    {
                        _('div2').style.display='none'
                        _('div2minus').style.display='none'
                        _('div2plus').style.display='block';
                    }else
                    {
                        _('div2').style.display='block'
                        _('div2minus').style.display='block'
                        _('div2plus').style.display='none';
                    }return false">
                    <div id="div2plus" style="cursor:pointer; float:left; width:10px; height:auto; text-align:center;;display:block;">&plus;</div>
                    <div id="div2minus" style="cursor:pointer; float:left; width:10px; height:auto; text-align:center;;display:none;">&minus;</div>
                    <div style="float:left; width:auto; height:auto;">
                        B. Apply for admission (Step can be executed on the home page)
                    </div>
                </div>
                
                <div id="div2" style="width:100%; margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">                
                    <ol style="margin-bottom:20px;">
                        <li>
                            Click on 'Admission'
                        </li>
                        <li>
                            Click on the 'Apply for admission'
                        </li>
                        <li>
                            Your response to the displayed question determines your next step
                        </li>
                        <li>
                            If you click 'No', you follow step A above else, you continue with the current procedure
                        </li>
                        <li>
                            Note the displayed steps to follow. You may close it to continue or follow it for guide.
                        </li>
                        <li>
                            Select options as applicable and click the 'Next' button
                        </li>
                        <li>
                            Confirm displayed information and click on the 'Submit' button. If there are selection/entry error(s), click the 'Home' and start afresh
                        </li>
                        <li>
                            On the first remita page, Click the 'Submit' button. Select applicable payment option and click on 'Make patment' button
                        </li>
                        <li>
                            On the second remita page, select applicable payment option and click on 'Make patment' button
                        </li>
                        <li style="height:auto">
                            When you enter your one-time-password (OTP) and click the submit button, it is <b>srongly advised</b> that you do not do anything on the keyboard, mouse or screen until you are returned to NOUN page
                        </li>
                        <li style="border:none;">
                            You will be debited and returned (if there is no interuption) to NOUN page. Follow the intructions and note the pieces of information on the screen
                        </li>
                    </ol>
                </div>
                            


                <div class="innercont_stff guide_instruct" style="width:100%; margin-top:10px; padding:4px; float:left; height:auto; text-align:left; background:#fafffb; border-top:1px dashed #82ad8b; cursor:pointer" 
                    onClick="if(_('div3').style.display=='block')
                    {
                        _('div3').style.display='none'
                        _('div3minus').style.display='none'
                        _('div3plus').style.display='block';
                    }else
                    {
                        _('div3').style.display='block'
                        _('div3minus').style.display='block'
                        _('div3plus').style.display='none';
                    }return false">
                    <div id="div3plus" style="cursor:pointer; float:left; width:10px; height:auto; text-align:center;;display:block;">&plus;</div>
                    <div id="div3minus" style="cursor:pointer; float:left; width:10px; height:auto; text-align:center;;display:none;">&minus;</div>
                    <div style="float:left; width:auto; height:auto;">
                        C. Check/complete payment for application form. Applicable to cases of incomplete payment transaction
                    </div>
                </div>
                
                <div id="div3" style="width:100%; margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                    <ol>
                        <li>
                            Click on 'Admission'
                        </li>
                        <li>
                            Click on the 'Continue after payment'
                        </li>
                        <li>
                            Select/enter all initially supplied options. RRR is on the remita payment receipt sent to your email box
                        </li>
                        <li>
                            Click on the 'Submit' button
                        </li>
                        <li>
                            Follow the prompts on the screen to continue. 
                        </li>
                    </ol>
                </div>
                


                <div class="innercont_stff guide_instruct" style="width:100%; margin-top:10px; padding:4px; float:left; height:auto; text-align:left; background:#fafffb;  border-top:1px dashed #82ad8b; cursor:pointer" 
                    onClick="if(_('div4').style.display=='block')
                    {
                        _('div4').style.display='none'
                        _('div4minus').style.display='none'
                        _('div4plus').style.display='block';
                    }else
                    {
                        _('div4').style.display='block'
                        _('div4minus').style.display='block'
                        _('div4plus').style.display='none';
                    }return false">
                    <div id="div4plus" style="float:left; width:10px; height:auto; text-align:center;;display:block;">&plus;</div>
                    <div id="div4minus" style="cursor:pointer; float:left; width:10px; height:auto; text-align:center;;display:none;">&minus;</div>
                    <div style="float:left; width:auto; height:auto;">
                        D. How to return to the application form
                    </div>
                </div>
                
                <div id="div4" style="width:100%; margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                    <ol>
                        <li>
                            Click on Admission
                        </li>
                        <li>
                            Click on 'Return to application form'
                        </li>
                        <li>
                            Enter your application form number, password and captcha accordingly
                        </li>
                        <li>
                            Click on the 'Login' button
                        </li>
                    </ol>
                </div>
                
                
                <div class="innercont_stff guide_instruct" style="width:100%; margin-top:10px; padding:4px; float:left; height:auto; text-align:left; background:#fafffb; border-top:1px dashed #82ad8b; cursor:pointer" 
                    onClick="if(_('div5').style.display=='block')
                    {
                        _('div5').style.display='none'
                        _('div5minus').style.display='none'
                        _('div5plus').style.display='block';
                    }else
                    {
                        _('div5').style.display='block'
                        _('div5minus').style.display='block'
                        _('div5plus').style.display='none';
                    }return false">
                    <div id="div5plus" style="cursor:pointer; float:left; width:10px; height:auto; text-align:center;display:block;">&plus;</div>
                    <div id="div5minus" style="cursor:pointer;float:left; width:10px; height:auto; text-align:center;display:none;">&minus;</div>
                    <div style="float:left; width:auto; height:auto;">
                        E. Fill/edit the application form
                    </div>
                </div>
                
                <div id="div5" style="width:100%; margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                    <ol>
                        <li>
                            Sections of the application form must be completed sequentially. Skipping is not allowed.
                        </li>
                        <li style="margin-bottom:12px">
                            The top of the head, the front baseline of the neck and the two ears must be clearly visible on the passport picture
                        </li>
                        <li style="height:auto">
                            To edit anyone of the sections of the form:
                            <ol style="list-style:lower-alpha">
                                <li>
                                    Login to your form, procedure D
                                </li>
                                <li>
                                    click on the corresponding button on the left side of the the home page, possible if you have not submitted yoru form
                                </li>
                                <li>
                                    Make chages as applicable
                                </li>
                                <li>
                                    Click the 'Next' button to save changes
                                </li>
                            </ol>
                        </li>
                        <li style="height:auto">
                            To delete/edit one or more of the credentials you have entered
                            <ol style="list-style:lower-alpha">
                                <li>
                                    Login to your form,  procedure D
                                </li>
                                <li>
                                    Click on 'Academic qualification' on the left, possible if you have not submitted yoru form
                                </li>
                                <li>
                                    Click on the button for the qualification
                                </li>
                                <li>
                                    Make changes as applicable
                                </li>
                                <li>
                                    Click the 'Next' button to save changes
                                </li>
                            </ol>
                        </li>
                    </ol>
                </div>

                <div class="innercont_stff guide_instruct" style="width:100%; margin-top:10px; padding:4px; float:left; height:auto; text-align:left; background:#fafffb; border-top:1px dashed #82ad8b; cursor:pointer" 
                    onClick="if(_('div6').style.display=='block')
                    {
                        _('div6').style.display='none'
                        _('div6minus').style.display='none'
                        _('div6plus').style.display='block';
                    }else
                    {
                        _('div6').style.display='block'
                        _('div6minus').style.display='block'
                        _('div6plus').style.display='none';
                    }return false">
                    <div id="div6plus" style="cursor:pointer; float:left; width:10px; height:auto; text-align:center;display:block;">&plus;</div>
                    <div id="div6minus" style="cursor:pointer;float:left; width:10px; height:auto; text-align:center;display:none;">&minus;</div>
                    <div style="float:left; width:auto; height:auto;">
                        F. Submit application form
                    </div>
                </div>
                
                <div id="div6" style="width:100%; margin-top:0px; padding:0px; float:left; height:auto; margin-left:0px; text-align:left;display:none">
                    <ol>
                        <li>
                            Login to your form,  procedure D
                        </li>
                        <li>
                            Complete all the sections of the form
                        </li>
                        <li>
                            Go to the form preveiw page as follow:
                            <ol style="list-style:lower-alpha">
                                <li>
                                    Click on the 'Next' button the sixth section, Choice of programme. You cal also click on the 'Preview form' button on the home page
                                </li>
                                <li>
                                    Scroll to the end of the preview page
                                </li>
                                <li>
                                    Click on the 'Submit'
                                </li>
                                <li>
                                    Read the pop-upmessage on the screen carefully and respond accordingly
                                </li>
                                <li>
                                    Read and follow the guides on the screen
                                </li>
                            </ol>
                        </li>
                    </ol>
                </div>
            </div>
            
            <div style="margin-top:10px; width:auto; float:left; text-align:left; padding:0px; line-height:2.4; margin-right:0px">
                Above steps (and more) are also available&nbsp; <a href="#" style="text-decoration:none;" 
                    onclick="ps.action='guides-instructions';
                    ps.target='_blank';
                    ps.submit();
                    return false;">
                    <div class="login_button" style="width:auto; padding:6px; float:right">
                        here
                    </div>
                </a>
            </div>
        </div>
        
        <div id="container_cover_ini_pay" class="center" style="display: none; 
            flex-direction:column; 
            gap:8px;  
            justify-content:space-around; 
            height:auto;
            padding:10px;
            box-shadow: 2px 2px 8px 2px #726e41;
            z-Index:3;
            background-color: #ffffff;" title="Press escape to close">
            
            <div class="appl_left_child_div_child" style="border-bottom:1px solid #ccc;">
                <div class="prog_cat_div1" style="flex:95%; height:35px; padding-left:5px; line-height:1.8; font-weight:bold; color:#e31e24;">
                    Certificate programmes
                </div>
                
                <div class="prog_cat_div1" style="flex:4%; height:35px; padding-left:5px; line-height:1.8;">
                    <img style="width:17px; height:17px; cursor:pointer" src="./img/close.png" 
                    onclick="show_appl_cat('');
                        _('container_cover_ini_pay').style.zIndex = -1;
                        _('container_cover_ini_pay').style.display = 'none';
                        _('smke_screen').style.zIndex = -1;
                        _('smke_screen').style.display = 'none';
                        _('ok_btn').style.display = 'none';"/>
                </div>
            </div>
            

            <div class="appl_left_child_div_child" style="margin-top:10px;">
                <div style="flex:99%; padding:10px; height:45px; line-height:1.6; background-color: #fdf0bf">
                    Select from certificate programmes listed below and click the Ok button
                    <br>Click the 'x' icon (top right) to cancel
                </div>
            </div><?php

            $sql = "SELECT DISTINCT a.cFacultyId, b.vFacultyDesc, a.cdeptid, e.cProgrammeId, e.vProgrammeDesc, c.vdeptDesc, a.Amount 
            FROM s_f_s a, faculty b, depts c, fee_items d, programme e
            WHERE a.fee_item_id = d.fee_item_id
            AND a.cFacultyId = b.cFacultyId
            AND c.cFacultyId = a.cFacultyId
            AND a.cdeptid = c.cdeptId
            AND e.cdeptId = c.cdeptId
            AND a.cdel = 'N' 
            AND c.cDelFlag = 'N' 
            AND e.cDelFlag = 'N' 
            AND d.fee_item_desc LIKE 'Application%'
            AND a.cEduCtgId = 'ELX'
            ORDER BY vFacultyDesc, a.cdeptid;";
            $rssqlEduCtgId = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
            
            $choice_count_cert = 0;
            $choice_count_cert_display = 0;

            $prev_dept = '';?>
            <div class="appl_left_child_div" 
                style="max-height:480px;
                overflow:auto; 
                overflow-x: hidden;"><?php
                while ($r_rssqlEduCtgId = mysqli_fetch_assoc($rssqlEduCtgId))
                {
                    if ($prev_dept == '' || $prev_dept <> $r_rssqlEduCtgId['vdeptDesc'])
                    {?>
                        <div class="appl_left_child_div_child" style="border-bottom:1px dashed #ccc;">
                            <div class="prog_cat_div1" style="flex:99%; height:35px; padding-left:5px; line-height:1.8; font-weight:bold">
                                <?php echo $r_rssqlEduCtgId['vFacultyDesc'].' - '.$r_rssqlEduCtgId['vdeptDesc'];?>
                            </div>
                        </div><?php
                    }?>
                    <label id="<?php echo 'lbl'.++$choice_count_cert;?>" class="lbl_beh" for="cEduCtgId<?php echo $choice_count_cert;?>">
                        <div class="appl_left_child_div_child" style="border-bottom:1px dashed #ccc;">
                            <div class="prog_cat_div1" style="flex:5%; height:35px; padding-left:5px; line-height:1.8;">
                                <?php echo $choice_count_cert;?>
                            </div>
                            <div class="prog_cat_div2" style="flex:5%; height:35px; padding-left:5px; line-height:1.8;">
                                <input type="radio" id="cEduCtgId<?php echo $choice_count_cert;?>" name="cEduCtgId_option" 
                                value="<?php echo 'ELX'.
                                str_pad('odl', 30, " ", STR_PAD_LEFT).
                                str_pad($r_rssqlEduCtgId['Amount'], 10, " ", STR_PAD_LEFT).
                                str_pad('Application Fee', 100, " ", STR_PAD_LEFT);?>" 
                                onClick="to_remita.cEduCtgId_text.value='<?php echo 'Certificate, '.$r_rssqlEduCtgId['vProgrammeDesc'].' [N'.number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',').']';?>';
                                _('amount').value ='<?php echo $r_rssqlEduCtgId['Amount'];?>';
                                to_remita.cEduCtgId.value ='ELX';
                                _('vDesc').value ='Application Fee';
                                to_remita.department.value = '<?php echo $r_rssqlEduCtgId['cdeptid'];?>';
                                to_remita.pgrID.value = '<?php echo $r_rssqlEduCtgId['cProgrammeId'];?>';
                                
                                _('resident_ctry').value='1';
                                _('pinfo').style.display='flex';
                                _('ok_btn').style.display='flex';" <?php if ($choice_count_cert == 1){echo ' required';}?>/>
                            </div>                                            
                            <div class="prog_cat_div3" style="flex:65%; height:35px; padding-left:5px; line-height:1.8;">
                                <?php echo $r_rssqlEduCtgId['vProgrammeDesc'];?>
                            </div>
                            <div class="prog_cat_div4" style="flex:25%; height:35px; padding-right:5px; line-height:1.8; text-align:right;">
                                <?php  echo number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',');?>
                            </div>
                            <!-- <input name="new_old_structure<?php echo $choice_count_cert;?>" id="new_old_structure<?php echo $choice_count_cert;?>" 
                                value="o" type="hidden"/> -->
                        </div>
                    </label><?php
                    $prev_dept = $r_rssqlEduCtgId['vdeptDesc'];
                }?>
            </div>

            <div id="ok_btn" class="appl_left_child_div_child" style="display:none; margin-top:20px;">
                <div class="prog_cat_div1" style="flex:99%; height:35px; justify-content:flex-end;">
                    <button type="submit" 
                    class="button" 
                    style="float:right; padding:8px 0px 12px 0px; border:1px solid #b6b6b6; width:30%;"
                    onclick="_('container_cover_ini_pay').style.zIndex = -1;
                    _('container_cover_ini_pay').style.display = 'none';
                    _('smke_screen').style.zIndex = -1;
                    _('smke_screen').style.display = 'none';">
                    Ok</button>
                </div>
            </div>
        </div><?php
        require_once("feedback_mesages.php");
        require_once("forms.php");
        	
        $sidemenu = '';
        if (isset($_REQUEST["sidemenu"]) && $_REQUEST["sidemenu"] <> '')
        {
            $sidemenu = $_REQUEST["sidemenu"];
        }?>
        <div class="appl_container">
            <?php left_conttent('Pay for application form for admission');?>
            
            <div id="right_div" class="appl_right_div" style="font-size:1em;">
                <?php appl_top_menu_home();?>
                <div class="appl_left_child_div" style="text-align: left; margin:auto; max-height:95%; overflow:scroll; overflow-x:hidden; margin-top:5px; background-color: #eff5f0;">
                    <form action="initiate-pay" method="post" id="to_remita" name="to_remita" enctype="multipart/form-data" onsubmit="chk_dob(); return false">
                        <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
                        <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
                        <input name="save" id="save" type="hidden" value="1" />
                        <input name="rrr_sys" type="hidden" value="1" />
                        <input name="payerName" id="payerName" type="hidden" />
                        <input name="cEduCtgId" id="cEduCtgId" type="hidden" />
                        
                        <input name="department" id="department" type="hidden" />
                        <input name="pgrID" id="pgrID" type="hidden" />

                        <input name="cEduCtgId_text" id="cEduCtgId_text" type="hidden"/>
                        <input name="vDesc" id="vDesc" type="hidden" value="" />
                        <input name="amount" id="amount" type="hidden" value="" />
                    
                        <div class="appl_left_child_div_child" style="margin-top:10px;">
                            <div style="flex:5%; height:40px; background-color: #ffffff"></div>
                            <div style="flex:95%; padding-left:5px; height:40px; background-color: #fdf0bf">
                                Click/tap and select option below according to your country of residence and choice of programme
                            </div>
                        </div>
                    
                        <input name="name_warn" id="name_warn" type="hidden" value="0" />

                        <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
                        <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" /><?php
                        
                        
                        /*$sql = "SELECT DISTINCT iEduCtgRank, a.cEduCtgId, e.vEduCtgDesc, a.Amount 
                        FROM s_f_s a, fee_items d, educationctg e
                        WHERE a.fee_item_id = d.fee_item_id
                        AND a.cEduCtgId = e.cEduCtgId
                        AND a.cdel = 'N' 
                        AND d.fee_item_desc LIKE 'Application%'  
                        AND a.new_old_structure = 'fx'
                        AND e.cEduCtgId <> 'PGZ'
                        ORDER BY iEduCtgRank;";
                        $rssqlEduCtgId = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));  
                        

                        if (mysqli_num_rows($rssqlEduCtgId) > 0)
                        {?>
                            <div class="appl_left_child_div_child cat_div" onclick="show_appl_cat('lbl_beh_f')" style="cursor:pointer">
                                <div style="flex:5%; height:35px; padding-left:5px; background-color: #eff5f0">A.</div>
                                <div style="flex:5%; height:35px; padding-left:5px; background-color: #eff5f0">
                                    <img width="10" height="10" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>" alt="More options">
                                </div>
                                <div style="flex:70%; height:35px; padding-left:5px;">
                                    Applicants residing outside Nigeria
                                </div>
                                <div style="flex:20%; height:35px; padding-left:5px; background-color: #eff5f0;font-weight:bold;text-align:right">
                                    Amount ($)
                                </div>
                            </div><?php
                        }

                        $choice_count = 0;
                        $choice_count_display = 0;
                        while ($r_rssqlEduCtgId = mysqli_fetch_assoc($rssqlEduCtgId))
                        {
                            $choice_count++;?>
                            <label id="<?php echo 'lbl'.$choice_count;?>" class="lbl_beh_f" for="cEduCtgId<?php echo $choice_count;?>_f" style="display:none">
                                <div class="appl_left_child_div_child">
                                    <div class="prog_cat_div1" style="flex:5%; height:35px; padding-left:5px; background-color: #FFFFFF">
                                        <?php echo $choice_count;?>
                                    </div>
                                    <div class="prog_cat_div2" style="flex:5%; height:35px; padding-left:5px;  background-color: #FFFFFF">
                                        <input type="radio" id="cEduCtgId<?php echo $choice_count;?>_f" name="cEduCtgId_option" 
                                        value="<?php echo $r_rssqlEduCtgId['cEduCtgId'].
                                        str_pad('odl', 30, " ", STR_PAD_LEFT).
                                        str_pad($r_rssqlEduCtgId['Amount'], 10, " ", STR_PAD_LEFT).
                                        str_pad('Application Fee', 100, " ", STR_PAD_LEFT);?>" 
                                        onClick="to_remita.cEduCtgId_text.value='<?php echo $r_rssqlEduCtgId['vEduCtgDesc'].' [$'.number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',').']';?>';
                                        _('amount').value ='<?php echo $r_rssqlEduCtgId['Amount'];?>';
                                        to_remita.cEduCtgId.value ='<?php echo $r_rssqlEduCtgId['cEduCtgId'];?>';
                                        _('vDesc').value ='Application Fee';
                                        to_remita.department.value = '';
                                        to_remita.pgrID.value = '';

                                        _('resident_ctry').value='0';
                                        _('pinfo').style.display='flex';
                                        _('conf_prog_div').style.display = 'flex';
                                        _('conf_prog').required = true;"/>
                                    </div>                                            
                                    <div class="prog_cat_div3" style="flex:65%; height:35px; padding-left:5px; background-color: #FFFFFF">
                                        <?php echo $r_rssqlEduCtgId['vEduCtgDesc'];?>
                                    </div>
                                    <div class="prog_cat_div4" style="flex:25%; height:35px; padding-right:5px; background-color: #FFFFFF; text-align:right;">
                                        <?php  echo number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',');?>
                                    </div>
                                </div>
                            </label><?php
                        }*/




                        $sql = "SELECT DISTINCT iEduCtgRank, a.cEduCtgId, e.vEduCtgDesc, a.Amount 
                        FROM s_f_s a, fee_items d, educationctg e
                        WHERE a.fee_item_id = d.fee_item_id
                        AND a.cEduCtgId = e.cEduCtgId
                        AND a.cdel = 'N' 
                        AND d.fee_item_desc LIKE 'Application%'  
                        AND a.new_old_structure <> 'f' 
                        AND a.cdeptid <> 'CPE'
                        AND a.cEduCtgId <> 'ELX'
                        AND a.cEduCtgId <> 'PGZ'
                        ORDER BY iEduCtgRank;";
                        $rssqlEduCtgId = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));                        
                        $choice_count = 0;

                        if (mysqli_num_rows($rssqlEduCtgId) > 0)
                        {?>
                            <div class="appl_left_child_div_child cat_div" onclick="show_appl_cat('lbl_beh_l')" style="cursor:pointer">
                                <div style="flex:5%; height:35px; padding-left:5px; background-color: #eff5f0">A.</div>
                                <div style="flex:5%; height:35px; padding-left:5px; background-color: #eff5f0">
                                    <img width="10" height="10" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>" alt="More options">
                                </div>
                                <div style="flex:70%; height:35px; padding-left:5px;">
                                    <!-- Applicants residing in Nigeria -->
                                    Available programmes
                                </div>
                                <div style="flex:20%; height:35px; padding-left:5px; background-color: #eff5f0;font-weight:bold;text-align:right">
                                    Amount (N)
                                </div>
                            </div>
                            
                            <label id="<?php echo 'lbl'.$choice_count;?>" class="lbl_beh_l" style="display:none; cursor:pointer" title="More options"
                                onClick="show_appl_cat('lbl_beh_l');
                                _('container_cover_ini_pay').style.zIndex = 3;
                                _('container_cover_ini_pay').style.display = 'block';
                                _('smke_screen').style.zIndex = 2;
                                _('smke_screen').style.display = 'block';">
                                <div class="appl_left_child_div_child">
                                    <div class="prog_cat_div1" style="flex:5%; height:35px; padding-left:5px;">
                                        <img width="8" height="8" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                    </div>
                                    <div class="prog_cat_div2" style="flex:5%; height:35px; padding-left:5px;">
                                        <input type="radio" id="cEduCtgId<?php echo $choice_count;?>_l" 
                                        name="cEduCtgId_option" 
                                        onclick="_('conf_prog_div').style.display = 'none';
                                        _('conf_prog').required = false;"
                                       />
                                    </div>                                            
                                    <div class="prog_cat_div3" style="flex:65%; height:35px; padding-left:5px;">
                                        Certificate programmes
                                    </div>
                                    <div class="prog_cat_div4" style="flex:25%; height:35px; padding-right:5px; text-align:right;"></div>
                                </div>
                            </label><?php
                        }

                        $choice_count_display = 0;
                        $choice_count = 0;
                        while ($r_rssqlEduCtgId = mysqli_fetch_assoc($rssqlEduCtgId))
                        {
                            $choice_count++;?>

                            <label id="<?php echo 'lbl'.$choice_count;?>" class="lbl_beh_l" for="cEduCtgId<?php echo $choice_count;?>_l" style="display:none">
                                <div class="appl_left_child_div_child">
                                    <div class="prog_cat_div1" style="flex:5%; height:35px; padding-left:5px; background-color: #FFFFFF">
                                        <?php echo $choice_count;?>
                                    </div>
                                    <div class="prog_cat_div2" style="flex:5%; height:35px; padding-left:5px;  background-color: #FFFFFF">
                                        <input type="radio" id="cEduCtgId<?php echo $choice_count;?>_l" name="cEduCtgId_option" 
                                        value="<?php echo $r_rssqlEduCtgId['cEduCtgId'].
                                        str_pad('odl', 30, " ", STR_PAD_LEFT).
                                        str_pad($r_rssqlEduCtgId['Amount'], 10, " ", STR_PAD_LEFT).
                                        str_pad('Application Fee', 100, " ", STR_PAD_LEFT);?>" 
                                        onClick="to_remita.cEduCtgId_text.value='<?php echo $r_rssqlEduCtgId['vEduCtgDesc'].' [N'.number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',').']';?>';
                                        _('amount').value ='<?php echo $r_rssqlEduCtgId['Amount'];?>';
                                        to_remita.cEduCtgId.value ='<?php echo $r_rssqlEduCtgId['cEduCtgId'];?>';
                                        _('vDesc').value ='Application Fee';
                                        to_remita.department.value = '';
                                        to_remita.pgrID.value = '';
                                                                                
                                        _('resident_ctry').value='1';
                                        _('pinfo').style.display='flex';
                                        _('conf_prog_div').style.display = 'flex';
                                        _('conf_prog').required = true;
                                        if (this.value.substr(0,3)=='PSZ')
                                        {
                                            caution_inform('JAMB registration number will be required to complete the application form for undergraduate programmes as from January 2025. However, this does not imply that applicants will be required to sit for JAMB exams. See more details on the left side of the screen')
                                        }"/>
                                    </div>                                            
                                    <div class="prog_cat_div3" style="flex:65%; height:35px; padding-left:5px; background-color: #FFFFFF">
                                        <?php echo $r_rssqlEduCtgId['vEduCtgDesc'];?>
                                    </div>
                                    <div class="prog_cat_div4" style="flex:25%; height:35px; padding-right:5px; background-color: #FFFFFF; text-align:right;">
                                        <?php  echo number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',');?>
                                    </div>
                                </div>
                            </label><?php
                        }


                        $sql = "SELECT DISTINCT iEduCtgRank, a.cEduCtgId, e.vEduCtgDesc, a.Amount 
                        FROM s_f_s a, fee_items d, educationctg e
                        WHERE a.fee_item_id = d.fee_item_id
                        AND a.cEduCtgId = e.cEduCtgId
                        AND a.cdel = 'N' 
                        AND d.fee_item_desc LIKE 'Application%' 
                        AND  a.cdeptid = 'CPE'
                        AND a.new_old_structure <> 'f'
                        AND a.cEduCtgId <> 'ELX'
                        AND a.cEduCtgId <> 'PGZ'
                        ORDER BY iEduCtgRank;";
                        $rssqlEduCtgId = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));                        
                        
                        while ($r_rssqlEduCtgId = mysqli_fetch_assoc($rssqlEduCtgId))
                        {
                            $choice_count++;?>

                            <label id="<?php echo 'lbl'.$choice_count;?>" class="lbl_beh_l" for="cEduCtgId<?php echo $choice_count;?>_l" style="display:none">
                                <div class="appl_left_child_div_child" style="margin-top:20px">
                                    <div class="prog_cat_div1" style="flex:5%; height:45px; padding-left:5px; background-color: #FFFFFF">
                                        <?php ++$choice_count_display; echo $choice_count;?>
                                    </div>
                                    <div class="prog_cat_div2" style="flex:5%; height:45px; padding-left:5px;  background-color: #FFFFFF">
                                        <input type="radio" id="cEduCtgId<?php echo $choice_count;?>_l" name="cEduCtgId_option" 
                                        value="<?php echo $r_rssqlEduCtgId['cEduCtgId'].
                                        str_pad('odl', 30, " ", STR_PAD_LEFT).
                                        str_pad($r_rssqlEduCtgId['Amount'], 10, " ", STR_PAD_LEFT).
                                        str_pad('Application Fee', 100, " ", STR_PAD_LEFT);?>" 
                                        onClick="to_remita.cEduCtgId_text.value='<?php echo $r_rssqlEduCtgId['vEduCtgDesc'].' [N'.number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',').']';?>';
                                        _('amount').value ='<?php echo $r_rssqlEduCtgId['Amount'];?>';
                                        to_remita.cEduCtgId.value ='<?php echo $r_rssqlEduCtgId['cEduCtgId'];?>';
                                        _('vDesc').value ='Application Fee';
                                        to_remita.department.value = ''; 
                                        to_remita.pgrID.value = ''; 
                                                                                 
                                        _('resident_ctry').value='0';
                                        _('pinfo').style.display='flex';
                                        _('conf_prog_div').style.display = 'flex';
                                        _('conf_prog').required = true;"/>
                                    </div>                                            
                                    <div class="prog_cat_div3" 
                                        style="flex:65%; height:45px; padding-left:5px; background-color: #FFFFFF" 
                                        title="Common wealth executive Masters in Business Administration (CEMBA)/Common wealth executive Masters in Public Administration (CEMPA)">
                                        <?php echo $r_rssqlEduCtgId['vEduCtgDesc'].' '.'CEMBA/CEMPA Programmes <font style="color: #e31e24">(In addition to the admission requirement, candidate must possess at least 3 years of managerial experience from a recognized organization)</font>';?>
                                    </div>
                                    <div class="prog_cat_div4" style="flex:25%; height:45px; padding-right:5px; background-color: #FFFFFF; text-align:right;">
                                        <?php  echo number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',');?>
                                    </div>
                                </div>
                            </label><?php
                        }
                        mysqli_close(link_connect_db());?>
                        <input name="resident_ctry" id="resident_ctry" type="hidden"/>
                        <input name="choice_count" id="choice_count" type="hidden" value="<?php echo $choice_count;?>"/>

                        <div class="appl_left_child_div_child cat_div" style="margin-top:20px;">
                            <div class="cemba_cls" style="flex:5%; padding-left:5px; background-color: #eff5f0">
                                <?php $choice_count++;?>B.
                            </div>
                            <div class="cemba_cls" style="flex:95%; padding-left:5px; background-color: #eff5f0; cursor:pointer"
                                onclick="show_appl_cat(''); ps.target='_blank'; ps.action='https://acetel.nou.edu.ng'; ps.submit(); return false">
                                Africa Centre of Excellence in Technology Enhanced Learning (ACETEL) programmes
                                <font style="color: #e31e24">(Applicants may or may not reside in Nigeria)</font>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child" style="margin-top:10px;">
                            <div style="flex:100%; height:40px; background-color: #ffffff"></div>
                        </div>

                        <div id="pinfo" class="appl_left_child_div_child" style="display:none; flex-flow: column; margin-top:10px;">
                            <div class="appl_left_child_div_child" style="margin-top:10px;">
                                <div style="flex:5%; height:40px; background-color: #ffffff"></div>
                                <div style="flex:95%; padding-left:5px; height:40px; background-color: #fdf0bf">
                                    Pieces of information below <b>must</b> be those of the candidate
                                </div>
                            </div>
    
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:40px; background-color: #ffffff">
                                    1
                                </div>
                                <div style="flex:25%; padding-left:5px; height:40px; background-color: #ffffff">
                                    <label for="vLastName">Surname</label>
                                </div>
                                <div style="flex:70%; height:40px; background-color: #ffffff">
                                    <input name="vLastName" id="vLastName" type="text"
                                    onchange="this.value=this.value.trim();
                                    this.value=this.value.replace(/ /g, '');
                                    this.value=this.value.toUpperCase();
                                    _('payerName').value = _('vLastName').value +' '+ _('vFirstName').value +' '+ _('vOtherName').value;"
                                    autocomplete="off"
                                    maxlength="20"
                                    required />
                                </div>
                            </div>
    
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:40px; background-color: #ffffff">
                                    2
                                </div>
                                <div style="flex:25%; padding-left:5px; height:40px; background-color: #ffffff">
                                    <label for="vFirstName">First name</label>
                                </div>
                                <div style="flex:70%; height:40px; background-color: #ffffff">
                                    <input name="vFirstName" id="vFirstName" type="text"
                                    onchange="this.value=this.value.trim();
                                    this.value=this.value.replace(/ /g, '');
                                    this.value=capitalizeEachWord(this.value);
                                    _('payerName').value = _('vLastName').value +' '+ _('vFirstName').value +' '+ _('vOtherName').value;"
                                    autocomplete="off"
                                    maxlength="25"
                                    required />
                                </div>
                            </div>
    
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:40px; background-color: #ffffff">
                                    3
                                </div>
                                <div style="flex:25%; padding-left:5px; height:40px; background-color: #ffffff">
                                    <label for="vOtherName">Other name</label>
                                </div>
                                <div style="flex:70%; height:40px; background-color: #ffffff">
                                    <input name="vOtherName" id="vOtherName" type="text"
                                    onchange="this.value=this.value.trim();
                                    this.value=capitalizeEachWord(this.value);
                                    this.value=this.value.replace(/ /g, '');
                                    _('payerName').value = _('vLastName').value +' '+ _('vFirstName').value +' '+ _('vOtherName').value;"
                                    maxlength="25"
                                    autocomplete="off"/>
                                </div>
                            </div>
    
                            <div class="appl_left_child_div_child" style="margin-top:10px;">
                                <div style="flex:5%; height:40px; background-color: #ffffff"></div>
                                <div style="flex:95%; padding-left:5px; height:40px; background-color: #fdf0bf">
                                    The date of birth entered here will appear on the application form where you will not be able to modify it. Ensure it is error free here.
                                </div>
                            </div>
    
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:40px; background-color: #ffffff">
                                    4
                                </div>
                                <div style="flex:25%; padding-left:5px; height:40px; background-color: #ffffff">
                                    <label for="dBirthDate">Date of birth</label>
                                </div>
                                
                                <div style="flex:70%; height:40px; background-color: #ffffff"><?php
                                    $curr_date = date("Y-m-d"); 
                                    $curr_year = substr($curr_date,0,4);
    
                                    $max_date = ($curr_year - 15)."-01-01";?>
                                    <input type="date" name="dBirthDate" id="dBirthDate" max="<?php echo $max_date;?>"  
    								 onkeydown=" caution_inform('Use the calendar icon inside the input box on the right to pick a date'); return false"
                                    autocomplete="off"
                                    required style="height:99%;">
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:40px; background-color: #ffffff">
                                    5
                                </div>
                                <div style="flex:25%; padding-left:5px; height:40px; background-color: #ffffff">
                                    <label for="payerEmail">Personal eMail address</label>
                                </div>
                                <div style="flex:70%; height:40px; background-color: #ffffff">
                                    <input name="payerEmail" id="payerEmail" type="email" 
                                    style="height:80%;"
                                    onblur="this.value=this.value.trim();
                                    this.value=this.value.replace(/ /g, '');
                                    this.value=this.value.toLowerCase();"
                                    maxlength="50"
                                    autocomplete="off"
                                    required />
                                </div>
                            </div>
    
                            <div  class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:40px; background-color: #ffffff">
                                    6
                                </div>
                                <div style="flex:25%; padding-left:5px; height:40px; background-color: #ffffff">
                                    <label for="payerPhone">Personal phone number</label>
                                </div>
                                <div style="flex:70%; height:40px; background-color: #ffffff">
                                    <input name="payerPhone" id="payerPhone" 
                                    type="number"
                                    autocomplete="off"
                                    onkeypress="if (_('resident_ctry').value=='1')
                                    {
                                        if(this.value.length==11){return false}
                                    }else
                                    {
                                        if(this.value.length==13){return false}
                                    }"
                                    onchange="this.value=this.value.trim();" required />
                                </div>
                            </div>
    
                            <div  class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:40px; background-color: #ffffff">
                                    7
                                </div>
                                <div style="flex:25%; padding-left:5px; height:40px; background-color: #ffffff"></div>
                                <div style="flex:70%; height:40px; background-color: #ffffff">
                                    <input name="conf_id" id="conf_id" 
                                    type="checkbox" required />
                                    <label for="conf_id" style="color: #e31e24">The names, date of birth, personal email and phone number are those of the candidate</label>
                                </div>
                            </div>
    
                            <div  class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:40px; background-color: #ffffff">
                                    8
                                </div>
                                <div style="flex:25%; padding-left:5px; height:40px; background-color: #ffffff"></div>
                                <div style="flex:70%; height:40px; background-color: #ffffff">
                                    <input name="conf_emailid" id="conf_emailid" 
                                    type="checkbox" required />
                                    <label for="conf_emailid" style="color: #e31e24">The email address is correct and functional</label>
                                </div>
                            </div>
                            
    
                            <div id="conf_prog_div" class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:40px; background-color: #ffffff">
                                    9
                                </div>
                                <div style="flex:25%; padding-left:5px; height:40px; background-color: #ffffff"></div>
                                <div style="flex:70%; height:40px; background-color: #ffffff">
                                    <input name="conf_prog" id="conf_prog" 
                                    type="checkbox" required />
                                    <label for="conf_prog" style="color: #e31e24">I am currently not running any degree programme in NOUN</label>
                                </div>
                            </div>
    
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:40px; background-color: #ffffff">
                                    10
                                </div>
                                <div style="flex:25%; padding-left:5px; height:40px; background-color: #ffffff">
                                    <label for="jambno">JAMB registration number</label>
                                </div>
                                <div style="flex:70%; height:40px; background-color: #ffffff">
                                    <input name="jambno" id="jambno" type="text"
                                    onchange="this.value=this.value.trim();
                                    this.value=this.value.toUpperCase();
                                    this.value=this.value.replace(/ /g, '');"
                                    maxlength="20"
                                    autocomplete="off"
                                    placeholder="For undergraduate application only"/>
                                </div>
                            </div>
    
                            <div style="display:flex; 
                                flex-flow: row;
                                justify-content: flex-end;
                                flex:100%;
                                height:auto; 
                                margin-top:10px;">
                                    <button type="submit" class="login_button">Next</button>  
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	</body>
</html>