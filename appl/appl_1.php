<?php
include_once('good_entry.php');
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
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/appl.js" />

        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/appl.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body>
		<form action="see-app-payment-receipt" method="post" name="show_recpt" target="_blank" id="show_recpt" enctype="multipart/form-data" 
            onsubmit="            
            if (orderId.value == '' && rrr.value == '')
            {
                caution_inform('Fill out the box for either RRR or transaction order number');
                return false;
            }else
            {
                 _('container_cover_in_chkps').style.zIndex='-1';
                _('smke_screen').style.display='none';
                _('smke_screen').style.zIndex='-1';
                
                _('container_cover_in_chkps').style.display = 'none';
                _('container_cover_in_chkps').style.zIndex = -1;

                return true;
            }">
			<input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
			<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
			<input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
            <div id="container_cover_in_chkps" class="center" style="display: none; 
            flex-direction:column; 
            gap:8px;  
            justify-content:space-around; 
            height:auto;
            padding:10px;
            box-shadow: 2px 2px 8px 2px #726e41;
            z-Index:3;
            background-color:#fff;" title="Press escape to close">
                <div style="line-height:1.5; width:70%; font-weight:bold">
                    See payment receipt
                </div>
                <div style="line-height:1.5; width:20; position:absolute; top:10px; right:10px;">
                    <img style="width:17px; height:17px; cursor:pointer" src="./img/close.png" 
                    onclick="_('container_cover_in_chkps').style.zIndex = -1;
                        _('container_cover_in_chkps').style.display = 'none';
                        _('smke_screen').style.zIndex = -1;
                        _('smke_screen').style.display = 'none';"/>
                </div>

                <div style="line-height:1.4; padding:8px 0px 8px 5px; width:99%; background-color: #fdf0bf;">
                    Enter either your Remita retrieval reference (RRR) or Transaction order number
                </div>

                <div style="line-height:1.5; margin-top:15px">
                    <label for="rrr">Remita retrieval reference</label>
                </div>
                <div style="height:53px">
                    <input name="rrr" id="rrr" type="number"
                        onchange="this.value=this.value.trim();" />
                </div>
                <div style="line-height:1.5; margin-top:15px">
                    <label for="orderId">Transaction order number</label>
                </div>
                <div style="height:53px">
                    <input name="orderId" id="orderId" type="number"
                        onchange="this.value=this.value.trim()" />
                </div>

                
                <div style="height:auto; display:flex; justify-content:flex-end; margin-top:15px">
                    <button type="submit" class="button" style="padding:12px 0px 12px 0px; border:1px solid #b6b6b6; width:30%;">
                        See payment receipt</button>
                </div>
            </div>        
		</form><?php

        require_once("feedback_mesages.php");
        
        $mysqli = link_connect_db();

        $vApplicationNo = '';
        if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST["vApplicationNo"] <> '')
        {
            $vApplicationNo = $_REQUEST["vApplicationNo"];
        }

        



        $stmt = $mysqli->prepare("SELECT cEduCtgId, Amount
        FROM remitapayments_app 
        WHERE Regno = ?");
        $stmt->bind_param("s", $vApplicationNo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cEduCtgId_last1, $Amount_last1);
        $stmt->fetch();

        if (is_null($cEduCtgId_last1))
        {
            $cEduCtgId_last1 = '';
        }else
        {
            if ($Amount_last1 == 5000 && $cEduCtgId_last1 <> 'PSZ' && $cEduCtgId_last1 <> 'ELX')
            {
                $stmt = $mysqli->prepare("UPDATE prog_choice
                SET cEduCtgId = 'PSZ'
                WHERE vApplicationNo = ?");
                $stmt->bind_param("s", $vApplicationNo);
                $stmt->execute();

                $stmt = $mysqli->prepare("UPDATE remitapayments_app
                SET cEduCtgId = 'PSZ'
                WHERE Regno = ?");
                $stmt->bind_param("s", $vApplicationNo);
                $stmt->execute();
            }
        }

        $stmt = $mysqli->prepare("SELECT cEduCtgId 
        FROM prog_choice 
        WHERE vApplicationNo = ?");
        $stmt->bind_param("s", $vApplicationNo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cEduCtgId_last2);
        $stmt->fetch();

        if (is_null($cEduCtgId_last2))
        {
            $cEduCtgId_last2 = '';
        }

        if ($cEduCtgId_last1 <> '' && $cEduCtgId_last1 <> $cEduCtgId_last2)
        {
            $stmt = $mysqli->prepare("UPDATE prog_choice
            SET cEduCtgId = '$cEduCtgId_last1'
            WHERE vApplicationNo = ?");
            $stmt->bind_param("s", $vApplicationNo);
            $stmt->execute();
        }
        
        $stmt = $mysqli->prepare("SELECT a.iBeginLevel, cReqmtId, a.cEduCtgId, vFirstName, b.vEduCtgDesc, cProgrammeId FROM prog_choice a, educationctg b WHERE a.cEduCtgId  = b.cEduCtgId AND vApplicationNo = ?");
        $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($iBeginLevel, $cReqmtId, $cEduCtgId, $vFirstName, $vEduCtgDesc, $cProgrammeId);
        $stmt->fetch();
		$stmt->close();
        
        require_once("forms.php");?>            

        <div class="appl_container">
            <div class="appl_left_div">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em">Application form for admission </div>
                
                <div class="menu_bg_scrn"><?php
                    $submission_status = stbmt_sta('2');
                    $submission_status = $submission_status ?? '0';
                        
                    if ($submission_status == '0')//submitted?
                    {?>
                        <?php build_menu('');
                    }else
                    {?>
                        <?php build_dull_menu();
                    }?>
                    
                </div>
            </div>
            
            <div class="appl_right_div">
                <div class="data_line data_line_logout" style="display:flex; height:auto; margin-top:5px;">
                    <div class="data_line_child data_line_child_edu_cat" style="flex:80%; margin: 0px;"></div>
                    <div class="data_line_child" style="flex:20%; text-align:center; margin: 0px;">
                        <button type="button" class="button" style="padding:8px; border:1px solid #b6b6b6;" 
                        onclick="appl_lgin_pg.logout.value='1';
                        appl_lgin_pg.submit();">
                        <img width="30" height="32" src="./img/logout.png" alt="Loogout">
                        <br>Logout</button>
                    </div>
                </div>
                <div class="data_line data_line_logout" style="display:flex; height:auto;">
                    <div class="data_line_child" style="flex:100%; text-align:center; font-size:1.1em; font-weight:bold;">
                        <?php echo $vEduCtgDesc.' Application Form';?>
                    </div>               
                </div>
                <div class="data_line data_line_logout" style="display:flex; height:auto">
                    <div class="data_line_child" style="flex:100%; text-align:center; margin: 0px;">
                        <?php echo $_REQUEST["vApplicationNo"].'<br>'.stdnt_name(); ?>
                    </div>
                </div>
                <div class="data_line data_line_logout" style="display:flex; height:auto">
                    <div class="data_line_child" style="flex:100%; text-align:center; margin: 0px;">
                        <img src="<?php echo get_pp_pix('');?>" width="140px" height="140px"/>
                    </div>
                </div>
                <div class="data_line data_line_logout" style="display:flex; height:auto;">
                    <div id="success_div" class="data_line_child" style="flex:100%; text-align:center;">
                        You are successfully logged in, <?php echo $vFirstName;?>
                    </div>               
                </div>
                <div class="data_line data_line_logout" style="display:flex; height:auto;">                  
                    <div class="data_line_child" style="flex:100%; text-align:center;"><?php
                        if (isset($_REQUEST['user_cat']) && ($_REQUEST['user_cat'] == 1 || $_REQUEST['user_cat'] == 2 || $_REQUEST['user_cat'] == 3))
                        {
                            if ($submission_status == '0')//submitted?
                            {
                                echo 'Click on the buttons by the left or above (small screen) in sequence to fill your form';
    
                                if(can_preview_form() <> 0)
                                {
                                    echo '<br><br><br>
                                    To submit your form, click on "Preview form"';?>

                                    <div class="data_line data_line_logout" 
                                        style="display:flex; padding:0px; width:98.7%; height:auto; margin-top:5px; justify-content:center;">
                                        <div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
                                            <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
                                            onclick="form_sections.action='preview-form'; in_progress('1'); form_sections.submit();">
                                            <img width="30" height="22" src="./img/preview.png" alt="Preview form">
                                            <br>Preview form</button>
                                        </div>
                                    </div><?php
                                }else
                                {
                                    echo '<br><br><br>Preview buttton appears here when all sections are filled';
                                }
                            }else
                            {
                                $prv_button_shown = '1';
                                
                                //$non_phd = ($cEduCtgId == 'PSZ' || $cEduCtgId == 'PGY' || $cEduCtgId == 'PGX') && !($cProgrammeId == 'MSC415' || $cProgrammeId == 'MSC416');
                                $non_phd = ($cEduCtgId == 'PSZ' || $cEduCtgId == 'PGY' || $cEduCtgId == 'PGX');
                                $phd = ($cEduCtgId == 'PGZ' || $cEduCtgId == 'PRX');
                                $cemba = ($cProgrammeId == 'MSC415' || $cProgrammeId == 'MSC416');

                                if ($submission_status == '1')//submitted?
                                {
                                    IF ($cEduCtgId == 'ELX')
                                    {
                                        echo '<font style="color:#009900">You have submitted your application form<br>You are yet to be screened<p>
                                        See steps to follow on your admission slip</font><p>
                                        The link to your admision slip is on your form preview';
                                    }else if ($non_phd == 1)
                                    {
                                        echo '<font style="color:#009900">You have submitted your application form<p>
                                        See steps to follow in your admission letter</font><p>
                                        The link to your admision letter is on your form preview';
                                    }else  if ($phd == 1)
                                    {
                                        echo '<font style="color:#009900">You have submitted your application form</font>';
                                        
                                        $stmt = $mysqli->prepare("SELECT ltr_sent, cSCrnd FROM prog_choice_pg WHERE vApplicationNo = ?");
                                        $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
                                        $stmt->execute();
                                        $stmt->store_result();
                                        $stmt->bind_result($ltr_sent, $cSCrnd);
                                        $stmt->fetch();
                                        $stmt->close();

                                        if ($ltr_sent == '1')
                                        {
                                            echo '<br>The link to your admision letter is on your form preview';
                                        }else 
                                        {
                                            echo '<br>The link to your admision letter is yet to be enabled';
                                        }

                                        if ($cSCrnd == '1')
                                        {
                                            echo '<br>You have been screened';
                                        }else
                                        {
                                            echo '<br>You are yet to be screened';
                                        }
                                    }?>

                                    <div class="data_line data_line_logout" 
                                        style="display:flex; padding:0px; width:98.7%; height:auto; margin-top:5px; justify-content:center;">
                                        <div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
                                            <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
                                            onclick="form_sections.action='preview-form'; in_progress('1'); form_sections.submit();">
                                            <img width="30" height="22" src="./img/preview.png" alt="Preview form">
                                            <br>Preview form</button>
                                        </div>
                                    </div><?php
                                }else if ($submission_status == '2')//screened?
                                {
                                    $id_type = 'matriculation number';
                                    if ($cEduCtgId == 'ELX')
                                    {
                                        $id_type = 'registration number';
                                    }
                                    echo "<font color='#009900'>You have been screened</font><br><br>Click on Preview form to see your <font color='#FF3300'>$id_type</font><br><br>";?>
                                    <div class="data_line data_line_logout" 
                                        style="display:flex; padding:0px; width:98.7%; height:auto; margin-top:5px; justify-content:center;">
                                        <div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
                                            <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
                                            onclick="form_sections.action='preview-form'; in_progress('1'); form_sections.submit();">
                                            <img width="30" height="22" src="./img/preview.png" alt="Preview form">
                                            <br>Preview form</button>
                                        </div>
                                    </div><?php
                                    
                                    echo "<br><br>Click on sign-up to create student user account with your $id_type<br><br>";?>
                                    <div class="data_line data_line_logout" 
                                        style="display:flex; padding:0px; width:98.7%; height:auto; margin-top:5px; justify-content:center;">
                                        <div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
                                            <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
                                            onclick="form_sections.user_cat.value='4';form_sections.target='_blank';form_sections.action='../rs/student_reset_password'; form_sections.submit();">
                                            <img width="30" height="20" src="./img/fresh_student.png" alt="SIgn-up">
                                            <br>Sign-up</button>
                                        </div>
                                    </div><?php
                                }
                            }
                        }?>

                        <div class="data_line data_line_logout" 
                            style="display:flex; padding:0px; width:98.7%; height:auto; margin-top:15px; justify-content:center;">
                            <div  class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
                                <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
                                onclick="_('container_cover_in_chkps').style.display='flex';
                                _('container_cover_in_chkps').style.zIndex='3';
                                _('smke_screen').style.display='block';
                                _('smke_screen').style.zIndex='2';">
                                <img width="30" height="24" src="./img/receipt.png" alt="Preview form">
                                <br>See payment receipt</button>
                            </div>
                        </div>
                    </div>               
                </div>

                <div class="menu_sm_scrn">
                   <?php //build_menu('');?>
                </div>
            </div>
        </div>
	</body>
</html>