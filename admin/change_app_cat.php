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
	
	<div id="container"><?php
        if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
        {
            $stmt = $mysqli->prepare("SELECT cSbmtd FROM prog_choice WHERE vApplicationNo = ?");
            $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($cSbmtd);
            $stmt->fetch();
            
            $stmt = $mysqli->prepare("SELECT payerName, payerEmail, payerPhone, cEduCtgId, Amount FROM remitapayments_app WHERE Regno = ?");
            $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
            $stmt->execute();
            $stmt->store_result();
            $afn_found = $stmt->num_rows;
            $stmt->bind_result($payerName, $payerEmail, $payerPhone, $cEduCtgId, $db_amount);
            $stmt->fetch();
            
            if (isset($_REQUEST["prog_cat1"]) && (($_REQUEST['prog_cat1'] == 'PSZ' && $db_amount <> 5000) ||
            (($_REQUEST['prog_cat1'] == 'PGX' || $_REQUEST['prog_cat1'] == 'PGY') && $db_amount <> 7500) ||
            (($_REQUEST['prog_cat1'] == 'PRX' || $_REQUEST['prog_cat1'] == 'PGYC') && $db_amount <> 2000)))
            {
                caution_box($db_amount.' application fee is not for selected category');
            }else if (isset($_REQUEST["prog_cat1"]) && (($cEduCtgId == $_REQUEST['prog_cat1'] && $_REQUEST['prog_cat1'] == 'PSZ' && $db_amount == 5000) ||
            (($cEduCtgId == $_REQUEST['prog_cat1'] && ($_REQUEST['prog_cat1'] == 'PGY' || $_REQUEST['prog_cat1'] == 'PGY')) && $db_amount == 7500) ||
            (($cEduCtgId == $_REQUEST['prog_cat1'] && ($_REQUEST['prog_cat1'] == 'PRX' || $_REQUEST['prog_cat1'] == 'PGYC')) && $db_amount == 2000)))
            {
                caution_box('Application already set to selected category');
            }else if ($afn_found == 1 && isset($_REQUEST["prog_cat1"]) && $_REQUEST["prog_cat1"] <> '' && !(isset($_REQUEST["conf"]) && $_REQUEST["conf"] == 1))
            {?>
                <div id="smke_screen_2" class="smoke_scrn" style="display:block; z-index:2"></div>
                <div id="conf_box_loc" class="center" style="display:block; width:400px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; z-index:3">
                    <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                        Confirmation
                    </div>
                    <a href="#" style="text-decoration:none;">
                        <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                    </a>
                    
                    <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:100%; float:left; text-align:center; padding:0px;">
                        Effect change?
                    </div>
                    <div style="margin-top:10px; width:100%; float:left; text-align:right; padding:0px;">
                        <a href="#" style="text-decoration:none;" 
                            onclick="_('sc_1_loc').target='_self';
                            _('sc_1_loc').action = 'change_application_programme_category'; 
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
            }
        }

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

            <div class="innercont_top" style="margin-bottom:0px;">Change category of application</div>
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

            <form method="post" name="sc_1_loc" id="sc_1_loc" enctype="multipart/form-data">
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
                        placeholder="Enter AFN here..."                        
                        onchange="this.value=this.value.trim();
                        _('all_div').style.display='none';
                        _('prog_cat_div').style.display='none';
                        _('succ_boxt').style.display='none';"
                        onkeypress="if(this.value.length==8){return false}"
                        autorepeat="off" 
                        value="<?php if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> ''){echo $_REQUEST["uvApplicationNo"];}?>"/>
                    </div>
                    <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
                </div><?php

                if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
                {                    
                    if ($afn_found == 0)
                    {
                        caution_box('Invalid application form number');
                    }else if ($cSbmtd == 2)
                    {
                        caution_box('Application form already screened');
                    }else
                    {?>
                        <div id="all_div" style="display:block">
                            <div id="name_div" class="innercont_stff">
                                <div class="div_label" style="width:220px; margin-left:7px;">
                                    Name
                                </div>
                                <div id="name_div_val" class="div_valu" style="font-weight:bold"><?php echo $payerName;?></div>	
                            </div>
                            
                            <div id="faculty_div" class="innercont_stff">
                                <div class="div_label" style="width:220px; margin-left:7px;">
                                    eMail
                                </div>
                                <div id="faculty_div_val" class="div_valu" style="font-weight:bold"><?php echo $payerEmail;?></div>	
                            </div>

                            <div id="dept_div" class="innercont_stff">
                                <div class="div_label" style="width:220px; margin-left:7px;">
                                    Phone
                                </div>
                                <div id="dept_div_val" class="div_valu" style="font-weight:bold"><?php echo $payerPhone;?></div>	
                            </div>

                            <div id="prog_div" class="innercont_stff">
                                <div class="div_label" style="width:220px; margin-left:7px;">
                                    Application category
                                </div>
                                <div id="prog_div_val" class="div_valu" style="font-weight:bold"><?php 
                                    if ($cEduCtgId == 'ELX')
                                    {
                                        echo 'Certificate';
                                    }else if ($cEduCtgId == 'PSZ')
                                    {
                                        echo 'Undergraduate';
                                    }else if ($cEduCtgId == 'PSZ')
                                    {
                                        echo 'Undergraduate';
                                    }else if ($cEduCtgId == 'PGX')
                                    {
                                        echo 'Postgraduate';
                                    }else if ($cEduCtgId == 'PGY')
                                    {
                                        echo 'Masters';
                                    }else if ($cEduCtgId == 'PRX')
                                    {
                                        echo 'MPhil/PhD';
                                    }?></div>	
                            </div>
                            <input name="old_cEduCtgId" id="old_cEduCtgId" type="hidden" value="<?php echo $cEduCtgId; ?>" />
                        </div>
                        
                        <div id="prog_cat_div" class="innercont_stff" style="display:block; margin-bottom:4px;">
                            <label for="prog_cat1" class="labell">Category of programme</label>
                            <div class="div_select"><?php						
                                $sql = "SELECT DISTINCT cEduCtgId, vEduCtgDesc 
                                FROM educationctg
                                WHERE LENGTH(vEduCtgDesc) > 3
                                AND cEduCtgId IN ('PSZ','PGY','PGX','ELX','PRX')
                                ORDER BY vEduCtgDesc";

                                $rssqlEduCtgId = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));?>
                                <select name="prog_cat1" id="prog_cat1" class="select" 
                                    onchange="if(this.value!=''&&cFacultyId1.value!=''&&cdept1.value!=''){pgprg.submit()}">
                                    <option value="" selected></option><?php
                                    $cnt = 0;
                                    while ($r_rssqlEduCtgId = mysqli_fetch_assoc($rssqlEduCtgId))
                                    {?>
                                        <option value="<?php echo $r_rssqlEduCtgId['cEduCtgId']?>" <?php if (isset($_REQUEST['prog_cat1']) && $_REQUEST['prog_cat1'] == $r_rssqlEduCtgId['cEduCtgId']){echo ' selected';}?>><?php echo ucwords(strtolower($r_rssqlEduCtgId['vEduCtgDesc'])); ?></option><?php
                                        $cnt++;
                                    }
                                    mysqli_close(link_connect_db());?>
                                    <option value="PGYC" <?php if (isset($_REQUEST['prog_cat1']) && $_REQUEST['prog_cat1'] == 'PGYC'){echo ' selected';}?>>Masters (CEMPA/CEMBA)</option>
                                </select>
                            </div>
                            <div id="labell_msg1" class="labell_msg blink_text orange_msg"></div>
                        </div><?php

                        if (isset($_REQUEST["conf"]) && $_REQUEST["conf"] == 1)
                        {
                            if ($_REQUEST['prog_cat1'] == 'ELX')
                            {
                                $cEduCtgId = $_REQUEST['prog_cat1'];
                            }else if ($_REQUEST['prog_cat1'] == 'PSZ')
                            {
                                $cEduCtgId = $_REQUEST['prog_cat1'];
                            }else if ($_REQUEST['prog_cat1'] == 'PGX' || $_REQUEST['prog_cat1'] == 'PGY')
                            {
                                $cEduCtgId = $_REQUEST['prog_cat1'];
                            }else if ($_REQUEST['prog_cat1'] == 'PGYC' || $_REQUEST['prog_cat1'] == 'PRX')
                            {
                                $cEduCtgId = $_REQUEST['prog_cat1'];

                                if ($_REQUEST['prog_cat1'] == 'PGYC')
                                {
                                    $cEduCtgId = 'PGY';
                                }
                            }
                            
                            
                            $stmt = $mysqli->prepare("UPDATE IGNORE remitapayments_app SET cEduCtgId = ? WHERE Regno = ? AND Amount = $db_amount;");
                            $stmt->bind_param("ss", $cEduCtgId, $_REQUEST['uvApplicationNo']);
                            $stmt->execute();
                            $number_affected_record_a = $stmt->affected_rows;

                            if ($number_affected_record_a == 0)
                            {
                                $stmt = $mysqli->prepare("DELETE FROM remitapayments_app WHERE payerEmail = ? AND Regno = '';");
                                $stmt->bind_param("s", $_REQUEST['payerEmail']);
                                $stmt->execute();
                                
                                $stmt = $mysqli->prepare("UPDATE IGNORE remitapayments_app SET cEduCtgId = ? WHERE Regno = ? AND Amount = $db_amount;");
                                $stmt->bind_param("ss", $cEduCtgId, $_REQUEST['uvApplicationNo']);
                                $stmt->execute();
                                $number_affected_record_a = $stmt->affected_rows;
                            }

                            $number_affected_record_b = 0;
                            if ($number_affected_record_a == 1)
                            {
                                $stmt = $mysqli->prepare("UPDATE prog_choice SET cEduCtgId = ? WHERE vApplicationNo = ? AND cSbmtd = '0';");
                                $stmt->bind_param("ss", $cEduCtgId, $_REQUEST['uvApplicationNo']);
                                $stmt->execute();
                                $number_affected_record_b = $stmt->affected_rows;

                                log_actv('Changed application category from '.$_REQUEST['old_cEduCtgId'].' to '.$cEduCtgId.' for '.$_REQUEST['uvApplicationNo']);
                            }?>

                            <div id="succ_boxt" class="succ_box blink_text green_msg" style="line-height:1.5; width:81%; margin:auto; max-height:400px; margin-top:5px; margin-bottom:5px; text-align:left; display:block">
                                <?php echo ($number_affected_record_a+$number_affected_record_b);?> Record(s) updated succesfully
                            </div><?php
                            
                        }
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