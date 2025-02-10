<?php
// Date in the past
// header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// header("Cache-Control: no-cache");
// header("Pragma: no-cache");
		
require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/applform.dwt.php" codeOutsideHTMLIsLocked="false" -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php
        require_once('var_colls.php');

        $currency = eyes_pilled('0');

        $mysqli = link_connect_db();

        $service_mode = '';
        $num_of_mode = 0;
        $service_centre = '';
        $num_of_service_centre = 0;

        if (isset($_REQUEST['vApplicationNo']))
        {
            $centres = do_service_mode_centre("2", $_REQUEST['vApplicationNo']);	
            $service_centre = substr($centres,10);
            $num_of_service_centre = trim(substr($centres,0, 9));
        }

        
        $orgsetins = settns();
        require_once('set_scheduled_dates.php');
        require_once('staff_detail.php');
        
        $num_rec = 0;

        // $semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);
        
        // $stmt1 = $mysqli->prepare("REPLACE INTO matno_reg_24 
        // SELECT `vMatricNo`, SUM(b.iCreditUnit) tcu, SUM(b.iCreditUnit) tcu2 
        // FROM `examreg_20242025` a, courses_new b 
        // WHERE a.cCourseId = b.cCourseId 
        // AND `tdate` >= '$semester_begin_date' 
        // and vMatricNo NOT IN (SELECT vMatricNo FROM s_m_t WHERE cProgrammeId IN ('LAW301','LAW401')) GROUP BY `vMatricNo` HAVING SUM(b.iCreditUnit) > 24;");
        // $stmt1->execute();

        // $num_rec = $stmt1->affected_rows;
        
    ?>

        <!-- InstanceBeginEditable name="doctitle" -->
        <title>NOUN-MIS</title>
        <link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
        <!-- InstanceEndEditable -->




        <script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
        <script language="JavaScript" type="text/javascript" src="button_ops.js"></script>
        <script language="JavaScript" type="text/javascript" src="./bamboo/blkstd.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
    </head>


    <body onLoad="checkConnection()">
        <?php admin_frms(); $has_matno = 0;?>
        
        <div id="container"><?php
            if (isset($_REQUEST["can_update"]) && $_REQUEST["can_update"] == '1' && !(isset($_REQUEST["conf"]) && $_REQUEST["conf"] == '1'))
            {?>
                <div id="smke_screen_2" class="smoke_scrn" style="display:block; z-index:2"></div>
                <div id="conf_box_loc" class="center" style="display:block; width:400px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; z-index:3">
                    <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                        Confirmation
                    </div>
                    <a href="#" style="text-decoration:none;">
                        <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                    </a>
                    <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:100%; float:left; text-align:center; padding:0px;">Continue?</div>
                    <div style="margin-top:10px; width:100%; float:left; text-align:right; padding:0px;">
                        <a href="#" style="text-decoration:none;" 
                            onclick="anavail_loc.conf.value = '1';
                            anavail_loc.submit(); 
                            return false">
                            <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                                Yes
                            </div>
                        </a>
            
                        <a href="#" style="text-decoration:none;" 
                            onclick="anavail_loc.conf.value='';
                            _('conf_box_loc').style.display='none';
                            _('smke_screen_2').style.display='none';
                            _('smke_screen_2').style.zIndex='-1';
                            return false">
                            <div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
                                No
                            </div>
                        </a>
                    </div>
                </div><?php
            }?>

            <noscript>
                <div class="smoke_scrn" style="display:block"></div>
                <?php information_box_inline('You need to enable javascript for this browser');?>
            </noscript>
            <?php do_toup_div('Student Management System');?>
            <div id="menubar">
                <!-- InstanceBeginEditable name="menubar" -->
                <?php include ('menu_bar_content_stff.php');?>
                <!-- InstanceEndEditable -->
            </div>

            <div id="leftSide_std" style="margin-left:0px;"><?php
                include ('stff_left_side_menu.php');?>
            </div>

            <div id="rtlft_std" style="position:relative;">
                <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u ?>" />

                <div class="innercont_top" style="margin-bottom:0px;">Force hanging payment</div>
                <p><?php //echo $num_rec. ' records available';?><p>
                <form action="staff_home_page" method="post" name="nxt" id="nxt" enctype="multipart/form-data">
                    <input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
                    <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" />
                    <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST['vMatricNo'])){echo $_REQUEST['vMatricNo']; }?>" />
                    <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                    <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
                    <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                    
                    <input name="mm" id="mm" type="hidden" value="<?php if (isset($_REQUEST["mm"])){echo $_REQUEST["mm"];} ?>" />
                    <input name="mm_desc" id="mm_desc" type="hidden" value="<?php if (isset($_REQUEST["mm_desc"])){echo $_REQUEST["mm_desc"];} ?>" />
                    <input name="sm" id="sm" type="hidden" value="<?php if (isset($_REQUEST["sm"])){echo $_REQUEST["sm"];} ?>" />
                    <input name="sm_desc" id="sm_desc" type="hidden"  value="<?php if (isset($_REQUEST["sm_desc"])){echo $_REQUEST["sm_desc"];} ?>"/>

                    <input name="contactus" id="contactus" type="hidden" />
                    <input name="what" id="what" type="hidden" />
                    
                    <input name="service_mode" id="service_mode" type="hidden" 
                    value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
                    else if (isset($service_mode)&&$service_mode<>''){echo $service_mode;}?>" />
                    <input name="num_of_mode" id="num_of_mode" type="hidden" 
                    value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
                    else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

                    <input name="user_centre" id="user_centre" type="hidden" 
                    value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
                    else if (isset($service_centre)&&$service_centre<>''){echo $service_centre;}?>" />
                    <input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
                    value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
                    else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
                </form>

                <form method="post" name="anavail_loc" id="anavail_loc" enctype="multipart/form-data">
                    <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                    
                    <input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId_u ?>" />
                    <input name="study_mode_su" id="study_mode_su" type="hidden" value="odl" />
                    <input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdeptId_u ?>" /><?php 
                    frm_vars();?>

                    <div class="innercont_stff" style="margin-top:0px;">
                        <div class="div_select">
                            <input name="rrr" id="rrr" 
                                type="text" 
                                class="textbox"
                                maxlength="15"
                                onkeypress="if(this.value.length==12){return false}"
                                onchange="this.value=this.value.trim()" required 
                                placeholder="Enter RRR here"
                                value="<?php if (isset($_REQUEST["rrr"]) && $_REQUEST["rrr"] <> '')
                                {
                                    echo clean_string($_REQUEST['rrr'], 'numbers');
                                }?>"/>                                
                        </div>
                        <div id="labell_msg0" class="labell_msg blink_text orange_msg" style="width:auto; margin-right:5px;"></div>
                        <!-- <div class="div_select" style="width:auto">
                            <select name="faculty_u_no" id="faculty_u_no" style="height:100%;"><?php
                                /*$faculty_u_no = '';
                                if (isset($_REQUEST["faculty_u_no"])){$faculty_u_no = $_REQUEST["faculty_u_no"];}
                                get_faculties_if_u_know($faculty_u_no);*/?>
                            </select>
                        </div> -->
                    </div><?php
            
                    if (isset($_REQUEST["rrr"]) && $_REQUEST["rrr"] <> '')
                    {
                        $rrr = clean_string($_REQUEST['rrr'], 'numbers');

                        $stmt1 = $mysqli->prepare("SELECT Regno, payerName, vLastName, vFirstName, vOtherName, payerEmail, payerPhone, cEduCtgId 
                        FROM remitapayments_app
                        WHERE RetrievalReferenceNumber = ?");
                        $stmt1->bind_param("s", $rrr);
                        $stmt1->execute();
                        $stmt1->store_result();
                        $stmt1->bind_result($afn, $payerName, $vLastName, $vFirstName, $vOtherName, $payerEmail, $payerPhone, $cEduCtgId);
                        $stmt1->fetch();

                        if (!is_null($afn))
                        {
                            $stmt1 = $mysqli->prepare("SELECT *
                            FROM afnmatric
                            WHERE vApplicationNo = '$afn'");
                            $stmt1->execute();
                            $stmt1->store_result();
                            $num_in_afnmatric = $stmt1->num_rows;

                            $stmt1 = $mysqli->prepare("SELECT *
                            FROM pers_info
                            WHERE vApplicationNo = '$afn'");
                            $stmt1->execute();
                            $stmt1->store_result();
                            $num_in_pers_info = $stmt1->num_rows;

                            $stmt1 = $mysqli->prepare("SELECT *
                            FROM prog_choice
                            WHERE vApplicationNo = '$afn'");
                            $stmt1->execute();
                            $stmt1->store_result();
                            $num_in_prog_choice = $stmt1->num_rows;                        
                            
                            $vLastName = clean_string($vLastName, 'names');
                            $vFirstName = clean_string($vFirstName, 'names');
                            $vOtherName = clean_string($vOtherName, 'names');

                            $payerName = $vLastName .' '. $vFirstName .' '. $vOtherName;

                            $stmt1 = $mysqli->prepare("SELECT *
                            FROM prog_choice
                            WHERE vLastName = '$vLastName'
                            AND vFirstName = '$vFirstName'
                            AND vOtherName = '$vOtherName'
                            AND vEMailId = '$payerEmail'
                            AND vMobileNo = '$payerPhone'");
                            $stmt1->execute();
                            $stmt1->store_result();
                            $num_in_prog_choice1 = $stmt1->num_rows;

                            $stmt1 = $mysqli->prepare("SELECT *
                            FROM pers_info
                            WHERE vLastName = '$vLastName'
                            AND vFirstName = '$vFirstName'
                            AND vOtherName = '$vOtherName'
                            AND vApplicationNo = '$afn'");
                            $stmt1->execute();
                            $stmt1->store_result();
                            $num_in_pers_info = $stmt1->num_rows;

                            
                            $payerEmail = clean_string($payerEmail, 'email');
                            $payerPhone = clean_string($payerPhone, 'numbers');?>

                            <div id="name_div" class="innercont_stff">
                                <div class="div_label" style="width:220px; margin-left:7px;">
                                    Application form number
                                </div>
                                <div id="name_div_val" class="div_valu" style="font-weight:bold"><?php
                                    echo $afn;?>
                                </div>	
                            </div>

                            <div id="name_div" class="innercont_stff">
                                <div class="div_label" style="width:220px; margin-left:7px;">
                                    Name
                                </div>
                                <div id="name_div_val" class="div_valu" style="font-weight:bold"><?php
                                    echo $vLastName.', '.$vFirstName.' '.$vOtherName;?>
                                </div>	
                            </div>
                            
                            <div id="mail_div" class="innercont_stff">
                                <div class="div_label" style="width:220px; margin-left:7px;">
                                    eMail address
                                </div>
                                <div id="mail_div_val" class="div_valu" style="font-weight:bold"><?php
                                    echo $payerEmail;?>
                                </div>	
                            </div>
                            
                            <div id="phone_div" class="innercont_stff">
                                <div class="div_label" style="width:220px; margin-left:7px;">
                                    Phone
                                </div>
                                <div id="phone_div_val" class="div_valu" style="font-weight:bold;"><?php
                                    echo $payerPhone;?>
                                </div>	
                            </div>
                            
                            <div id="phone_div" class="innercont_stff">
                                <div class="div_label" style="width:220px; margin-left:7px;">
                                    Programme category
                                </div>
                                <div id="phone_div_val" class="div_valu" style="font-weight:bold;"><?php
                                    if ($cEduCtgId == 'ELX')
                                    {
                                        echo 'Certificate';
                                    }else if ($cEduCtgId == 'PSZ')
                                    {
                                        echo 'Undergraduate';
                                    }else if ($cEduCtgId == 'PGX')
                                    {
                                        echo 'Postgrduate Diploma';
                                    }else if ($cEduCtgId == 'PGY')
                                    {
                                        echo 'Masters';
                                    }else if ($cEduCtgId == 'PRX')
                                    {
                                        echo 'Doctoral';
                                    }?>
                                </div>	
                            </div>
                            
                            <div id="phone_div" class="innercont_stff">
                                <div class="div_label" style="width:220px; margin-left:7px;">
                                    Above name has started filling form?
                                </div>
                                <div id="phone_div_val" class="div_valu" style="font-weight:bold;"><?php
                                    if ($num_in_pers_info == 0 || $num_in_prog_choice1 == 0)
                                    {
                                        echo 'No';
                                    }else
                                    {
                                        echo 'Yes';
                                    }?>
                                </div>	
                            </div><?php
                            
                            if ($num_in_afnmatric == 0 && ($num_in_pers_info == 0 || $num_in_prog_choice == 0))
                            {?>
                                <input name="can_update" id="can_update" type="hidden" value="1" /><?php

                                if (isset($_REQUEST["conf"]) && $_REQUEST["conf"] == '1')
                                {
                                    $update_remitapayments_app = $mysqli->prepare("UPDATE remitapayments_app
                                    SET payerName = '$payerName',
                                    vLastName = '$vLastName',
                                    vFirstName = '$vFirstName',
                                    vOtherName = '$vOtherName',
                                    payerEmail = '$payerEmail',
                                    payerPhone = '$payerPhone'
                                    WHERE RetrievalReferenceNumber = ?");
                                    $update_remitapayments_app->bind_param("s", $rrr);
                                    $update_remitapayments_app->execute();
                                    
                                    if ($num_in_prog_choice1 == 0)
                                    {
                                        $stmt = $mysqli->prepare("INSERT IGNORE INTO prog_choice
                                        SET vApplicationNo = '$afn',
                                        cEduCtgId = '$cEduCtgId',
                                        vLastName = '$vLastName',
                                        vFirstName = '$vFirstName',
                                        vOtherName = '$vOtherName',
                                        vEMailId = '$payerEmail',
                                        vMobileNo = '$payerPhone',
                                        cAcademicDesc = '".$orgsetins['cAcademicDesc']."',
                                        resident_ctry = 'NG',
                                        trans_time = now()");
                                        $stmt->execute();

                                        caution_box_inline('Records updated successfully');

                                        log_actv('Made AFN available for '.$afn.', '.$vLastName.'  '.$vLastName.'  '.$vOtherName.', '.$payerEmail.' '.$payerPhone);
                                    }else
                                    {
                                        caution_box_inline('Record with payment details exists');
                                    }
                                }
                            }else
                            {
                                caution_box_inline('AFN ('.$afn.') not available');
                            }
                        }else
                        {
                            caution_box_inline('Payment not initiated here. Refer to Bursary for confirmation');
                        }
                        
                        //echo $_REQUEST["rrr"].', '.$afn;
                    }?>
                </form>
            </div>
            
            <div class="rightSide_0">
                <div id="insiderightSide" style="margin-top:1px;">
                    <div id="pp_box">
                        <img name="passprt" id="passprt" src="<?php echo get_pp_pix('');?>" width="95%" height="185"  
                        style="margin:0px;" alt="" />
                    </div>
                    <!-- InstanceBeginEditable name="EditRegion7" -->
                    <!-- InstanceEndEditable -->
                </div>
                <div id="insiderightSide">
                    <!-- InstanceBeginEditable name="EditRegion8" -->
                        <div class="innercont_stff" style="margin:0px; padding:0px;">
                            <a href="#" style="text-decoration:none;" onclick="_('nxt').action = 'staff_home_page';_('nxt').mm.value='';_('nxt').submit();return false">
                                <div class="basic_three" style="height:auto; width:inherit; padding:8.5px; float:none; margin:0px;">Home</div>
                            </a>
                        </div>
                        
                        <?php if (isset($_REQUEST['uvApplicationNo']))
                        {
                            side_detail($_REQUEST['uvApplicationNo']);
                        }else
                        {
                            side_detail('');
                        }?>
                        <!-- InstanceEndEditable -->
                </div>
                <div id="insiderightSide" style="position:relative;">
                    <!-- InstanceBeginEditable name="EditRegion9" -->
                    <?php include ('stff_bottom_right_menu.php');?>
                    <!-- InstanceEndEditable -->
                </div>
            </div>
            <div id="futa"><?php foot_bar();?></div>
        </div>
    </body>
</html>