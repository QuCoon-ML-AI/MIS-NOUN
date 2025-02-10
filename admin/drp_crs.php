<?php
// Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
		
require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

?>
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
	require_once('staff_detail.php');?>

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
	
	<div id="container">		
		<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
		<div id="conf_box_loc" class="center" style="display:none; width:400px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
			<div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
				Confirmation
			</div>
			<a href="#" style="text-decoration:none;">
				<div style="width:20px; float:left; text-align:center; padding:0px;"></div>
			</a>
			
			<div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:100%; float:left; text-align:center; padding:0px;">
				Drop selected courses?
			</div>
			<div style="margin-top:10px; width:100%; float:left; text-align:right; padding:0px;">
				<a href="#" style="text-decoration:none;" 
					onclick="_('sc_1_loc').target='_self';
                    _('sc_1_loc').action = 'drop_courses'; 
                    _('sc_1_loc').conf.value = '1';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
					<div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
						Yes
					</div>
				</a>

				<a href="#" style="text-decoration:none;" 
					onclick="sc_1_loc.conf.value='';
					_('conf_box_loc').style.display='none';
					_('smke_screen_2').style.display='none';
					_('smke_screen_2').style.zIndex='-1';
                    _('sc_1_loc').conf.value = '0';
					return false">
					<div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
						No
					</div>
				</a>
			</div>
		</div><?php
		time_out_box($currency);?>

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

            <div class="innercont_top" style="margin-bottom:0px;">Student's request - Drop course</div>
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

            <form action="student-requests" method="post" name="sc_1_loc" id="sc_1_loc" enctype="multipart/form-data">
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                <input name="tabno" id="tabno" type="hidden" 
                    value="<?php if (isset($_REQUEST['tabno'])){echo $_REQUEST['tabno'];}else{echo '0';} ?>"/>
                <input name="user_cEduCtgId" id="user_cEduCtgId" type="hidden" value="go"/>
                
                <input name="pasUpldFlg" id="pasUpldFlg" type="hidden" value="0"/>
                <input name="uvApplicationNo_loc" id="uvApplicationNo_loc" type="hidden" />
                <input name="app_frm_no" id="app_frm_no" type="hidden" />
                
                <input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId_u ?>" />
                <input name="study_mode_su" id="study_mode_su" type="hidden" value="odl" />
                <input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdeptId_u ?>" />
                                
                <input name="cAcademicDesc" id="cAcademicDesc" type="hidden" value="<?php echo $orgsetins["cAcademicDesc"]; ?>" />
                <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester; ?>" />
            
                <input name="tab_id" id="tab_id" type="hidden" value="<?php if (isset($_REQUEST['tab_id'])){echo $_REQUEST['tab_id'];}?>"/>
                <input name="whattodo" id="whattodo" type="hidden" value="<?php if(isset($_REQUEST['whattodo'])){echo $_REQUEST['whattodo'];}else{echo '';}?>" /><?php 
                frm_vars();
                
                include("student_requests.php");?>

                <div class="innercont_stff" style="margin-top:10px;">
                    <div id="uvApplicationNo_div" class="div_select">
                        <input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox"  
                        placeholder="Enter Mat. no. here"
                        onchange="this.value=this.value.trim();
                        this.value=this.value.toUpperCase();
                        //tidy_screen();
                        _('ans2').style.display='none';
                        _('succ_boxt').style.display='none';" 
                        value="<?php if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> ''){echo $_REQUEST["uvApplicationNo"];}?>"/>
                    </div>
                    <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
                </div><?php

                $semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);                
                

                if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
                {
                    $currentDate = date('Y-m-d');
                    
                    if ($iStudy_level <= 200)
                    {
                        $set_date = substr($orgsetins['drp_examdate'],4,4).'-'.substr($orgsetins['drp_examdate'],2,2).'-'.substr($orgsetins['drp_examdate'],0,2);
                    }else
                    {
                        $set_date = substr($orgsetins['drp_exam_2date'],4,4).'-'.substr($orgsetins['drp_exam_2date'],2,2).'-'.substr($orgsetins['drp_exam_2date'],0,2);
                    }

                    $stmt_last = $mysqli->prepare("SELECT vMatricNo FROM matno_reg_24 WHERE vMatricNo = ?");
                    $stmt_last->bind_param("s", $_REQUEST["uvApplicationNo"]);
                    $stmt_last->execute();
                    $stmt_last->store_result();
                    $stmt_last->bind_result($stid);
                    $stmt_last->fetch();
                    $stmt_last->close();

                    if (!is_null($stid))
                    {
                        caution_box_inline('Not eligible');
                    }else if ($currentDate <= $set_date)
                    {
                        if (isset($_REQUEST["conf"]) && $_REQUEST["conf"] == 1)
                        {
                            //note course to delete
                            $note_exam_drop = $mysqli->prepare("INSERT IGNORE INTO coursereg_arch_drop SELECT * FROM coursereg_arch_20242025  WHERE vMatricNo = ? 
                            AND tdate >= '$semester_begin_date'
                            AND cCourseId = ?");

                            //note exam to delete
                            $note_crs_drop = $mysqli->prepare("INSERT IGNORE INTO examreg_drop SELECT * FROM examreg_20242025  WHERE vMatricNo = ? 
                            AND tdate >= '$semester_begin_date'
                            AND cCourseId = ?");

                            //delete course
                            $delete_from_coursreg_arch = $mysqli->prepare("DELETE FROM coursereg_arch_20242025 
                            WHERE vMatricNo = ? 
                            AND tdate >= '$semester_begin_date'
                            AND cCourseId = ?");
                            
                            //delete exam
                            $delete_from_examreg = $mysqli->prepare("DELETE FROM examreg_20242025 
                            WHERE vMatricNo = ? 
                            AND tdate >= '$semester_begin_date'
                            AND cCourseId = ?"); 

                            //return mone for course and xexam
                            $delete_from_debit = $mysqli->prepare("DELETE FROM s_tranxion_20242025 
                            WHERE vMatricNo = ? 
                            AND tdate >= '$semester_begin_date'
                            AND cCourseId = ?");

                            $count1 = 0;


                            for ($y = 1; $y <= $_REQUEST["seld_opt"]; $y++)
                            {
                                $box_name = "chk".$y;

                                if (isset($_REQUEST["$box_name"]))
                                {
                                    //note exam to delete
                                    $note_exam_drop->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST["$box_name"]);
                                    $note_exam_drop->execute();

                                    //note course to delete
                                    $note_crs_drop->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST["$box_name"]);
                                    $note_crs_drop->execute();
                                    
                                    //drop courses
                                    $delete_from_coursreg_arch->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST["$box_name"]);
                                    $delete_from_coursreg_arch->execute();
                                    
                                    //drop exam
                                    $delete_from_examreg->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST["$box_name"]);
                                    $delete_from_examreg->execute();

                                    //return mone for course and xexam
                                    if ($delete_from_coursreg_arch->affected_rows > 0)
                                    {
                                        $delete_from_debit->bind_param("ss", $_REQUEST['uvApplicationNo'], $_REQUEST["$box_name"]);
                                        $delete_from_debit->execute();

                                        
                                        $count1++;
                                        log_actv('dropped course '.$_REQUEST["$box_name"].' in '.$orgsetins["cAcademicDesc"].', '.$iStudy_level.', '.$tSemester_su.' semester for '.$_REQUEST['uvApplicationNo']);
                                    }
                                }
                            }
                            

                            if ($count1 > 0)
                            {?>
                                <div id="succ_boxt" class="succ_box blink_text green_msg" style="line-height:1.5; width:81%; margin:auto; max-height:400px; margin-top:5px; margin-bottom:5px; text-align:left; display:block"><?php echo $count1;?> course(s) dropped succesfully</div><?php
                            }else
                            {?>
                                <div id="succ_boxt" class="succ_box blink_text orange_msg" style="line-height:1.5; width:81%; margin:auto; max-height:400px; margin-top:5px; margin-bottom:5px; text-align:left; display:block">No course dropped.</div><?php
                            }
                        }


                        //$sql_feet_type = select_fee_srtucture($_REQUEST["uvApplicationNo"], $cResidenceCountryId, $cEduCtgId);
                        /*if ($cResidenceCountryId == 'NG')
                        {*/
                            $sql_feet_type = "AND new_old_structure = 'o'";
                        /*}else
                        {
                            $sql_feet_type = "AND new_old_structure = 'f'";
                        }*/
                        
                        $stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, a.siLevel, a.tSemester, a.tdate, a.iCreditUnit, a.cAcademicDesc, a.cCategory, a.ancilary_type
                        FROM coursereg_arch_20242025 a
                        WHERE a.vMatricNo = ?
                        AND tdate >= '$semester_begin_date'
                        ORDER BY a.siLevel, a.tSemester, a.cCategory, a.cCourseId");
                        /*SELECT a.cCourseId, a.vCourseDesc, a.siLevel, a.tSemester, a.tdate, a.iCreditUnit, a.cAcademicDesc, a.cCategory, a.ancilary_type FROM coursereg_arch_20242025 a WHERE a.vMatricNo = 'NOU211087792' AND a.cAcademicDesc = '2024' AND a.siLevel = 400 AND a.tSemester = 2 ORDER BY a.siLevel, a.tSemester, a.cCategory, a.cCourseId*/
                        $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($cCourseId, $vCourseDesc, $level, $tSemester, $tdate, $iCreditUnit, $cAcademicDesc, $cCategory, $ancilary_type);?>
                        <div class="innercont_stff_tabs" id="ans2" style="height:77.5%; width:83%; display:block;">
                            <div class="innercont_stff" style="font-weight:bold;">
                                <div class="ctabletd_1" style="width:3.8%; height:auto; padding-right:0.3%; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:right; border-radius:0px;">Sn</div>
                                <div class="ctabletd_1" style="width:11.3%; height:auto; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2;  text-align:left;">Course Code</div>
                                <div class="ctabletd_1" style="width:43.7%; height:auto; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:left;">Course Title</div>
                                <div class="ctabletd_1" style="width:7.6%; height:auto; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:right;">Cr. Unit</div>
                                <div class="ctabletd_1" style="width:6.6%; height:auto; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:center;">Category</div>
                                <div class="ctabletd_1" style="width:7.5%; height:auto; padding-right:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:right;">Fee</div>
                                <div class="ctabletd_1" style="width:15.2%; height:auto; padding-top:0.8%; padding-bottom:0.7%; background-color:#E3EBE2; text-align:center;border-radius: 0px;">Date</div>
                            </div><?php
                            $c = 0; $total_cost = 0; 
                            $total_cr = 0;

                            while($stmt->fetch())
                            {
                                $c++;
                                if ($ancilary_type <> 'normal')
                                {
                                    $stmt_amount = $mysqli->prepare("SELECT a.Amount, a.iItemID
                                    FROM s_f_s a, educationctg b, sell_item_cat c, fee_items d
                                    WHERE a.cEduCtgId = b.cEduCtgId 
                                    AND a.citem_cat = c.citem_cat
                                    AND a.fee_item_id = d.fee_item_id
                                    AND d.fee_item_desc = '$ancilary_type'
                                    AND a.cdel = 'N'
                                    AND d.cdel = 'N'
                                    AND a.cEduCtgId = '$cEduCtgId'
                                    AND cFacultyId = '$cFacultyId'
                                    $sql_feet_type
                                    order by a.citem_cat, d.fee_item_desc");
                                }else
                                {
                                    $stmt_amount = $mysqli->prepare("SELECT Amount, iItemID
                                    FROM s_f_s a, fee_items b
                                    WHERE a.fee_item_id = b.fee_item_id
                                    AND fee_item_desc = 'Course Registration'
                                    AND iCreditUnit = $iCreditUnit
                                    AND cEduCtgId = '$cEduCtgId'
                                    $sql_feet_type");
                                }

                                $stmt_amount->execute();
                                $stmt_amount->store_result();
                                $stmt_amount->bind_result($Amount, $itemid);
                                $stmt_amount->fetch();
                                
                                if (is_null($Amount))
                                {
                                    $Amount = 0.0;
                                }
                                if ($c%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>

                                <label class="lbl_beh">
                                    <div class="innercont_stff" style="font-weight:normal;">
                                        <div class="ctabletd_1" style="width:3.8%; height:auto; padding-right:0.3%; padding-top:0.8%; padding-bottom:0.7%; background-color:<?php echo $background_color;?>; text-align:right; border-radius:0px;">
                                            <?php echo $c;?>
                                        </div>
                                        <div class="ctabletd_1" style="width:11.3%; height:auto; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.65%; background-color:<?php echo $background_color;?>;  text-align:left;">
                                            <input name="ancilary_type<?php echo $c;?>" id="ancilary_type<?php echo $c ?>" type="hidden" value="<?php echo $ancilary_type; ?>"/>
                                            <input name="amount<?php echo $c;?>" id="amount<?php echo $c ?>" type="hidden" value="<?php echo $Amount; ?>"/>
                                            <input name="itemid<?php echo $c;?>" id="itemid<?php echo $c ?>" type="hidden" value="<?php echo $itemid; ?>"/>
                                            <input name="chk<?php echo $c;?>" id="<?php echo 'chk'.$c;?>" 
                                                style="margin-top:0px; margin-bottom:0px;"
                                                value="<?php echo $cCourseId; ?>"
                                                type="checkbox"
                                                onclick="if(this.checked){_('sel_opt').value = parseInt(_('sel_opt').value)+1}else if (_('sel_opt').value !=0){_('sel_opt').value = parseInt(_('sel_opt').value)-1}"
                                                <?php if ($Amount == 0.0) {echo ' disabled';}?>/>
                                            <?php echo $cCourseId; ?>
                                        </div>
                                        <div class="ctabletd_1" style="width:43.7%; height:auto; padding-left:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:<?php echo $background_color;?>; text-align:left;">
                                            <?php echo $vCourseDesc;?>
                                        </div>
                                        <div class="ctabletd_1" style="width:7.6%; height:auto; padding-top:0.8%; padding-bottom:0.7%; background-color:<?php echo $background_color;?>; text-align:right;">
                                            <?php echo $iCreditUnit; $total_cr = $total_cr + $iCreditUnit;?>
                                        </div>
                                        <div class="ctabletd_1" style="width:6.6%; height:auto; padding-top:0.8%; padding-bottom:0.7%; background-color:<?php echo $background_color;?>; text-align:center;">
                                            <?php echo $cCategory;?>
                                        </div>
                                        <div class="ctabletd_1" style="width:7.5%; height:auto; padding-right:0.5%; padding-top:0.8%; padding-bottom:0.7%; background-color:<?php echo $background_color;?>; text-align:right;">
                                            <?php echo number_format($Amount);$total_cost = $total_cost + $Amount;?>
                                        </div>
                                        <div class="ctabletd_1" style="width:15.2%; height:auto; padding-top:0.8%; padding-bottom:0.7%; background-color:<?php echo $background_color;?>; text-align:center;border-radius: 0px;">
                                            <?php echo $tdate;?>
                                        </div>
                                    </div>
                                </label><?php
                            }

                            if (isset($stmt_amount))
                            {
                                $stmt_amount->close();
                            }?>

                            <input name="sel_opt" id="sel_opt" type="hidden" value="0"/>
                            <input name="seld_opt" id="seld_opt" type="hidden" value="<?php echo $c;?>"/>
                        </div><?php

                        if ($c == 0)
                        {
                            caution_box_inline('Yet to register courses for the semester');
                        }
                    }else
                    {
                        caution_box_inline('Dropping of course has closed');
                    }
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