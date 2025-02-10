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
	require_once('staff_detail.php');
    
    
    //$semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);

    $num_rec = 1;
    
    /*if (!isset($_REQUEST["save_cf"]))
    {        
        $stmt1 = $mysqli->prepare("REPLACE INTO matno_reg_24 
        SELECT `vMatricNo`, SUM(b.iCreditUnit) tcu, SUM(b.iCreditUnit) tcu2 
        FROM `examreg_20242025` a, courses_new b 
        WHERE a.cCourseId = b.cCourseId 
        AND `tdate` >= '$semester_begin_date' 
        and vMatricNo NOT IN (SELECT vMatricNo FROM s_m_t WHERE cProgrammeId IN ('LAW301','LAW401')) GROUP BY `vMatricNo` HAVING SUM(b.iCreditUnit) > 24;");
        $stmt1->execute();

        $num_rec = $stmt1->affected_rows;
    }*/?>

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

            <div class="innercont_top" style="margin-bottom:0px;">Create new balance records</div>
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
            
            <form method="post" name="student_balances_loc" id="student_balances_loc" enctype="multipart/form-data">
                <input name="save_cf" id="save_cf" type="hidden" value="-1" /><?php 
                frm_vars();?>                
                <div class="innercont_stff_tabs" id="ans8" style="display:block; border:0px; height:auto; margin-left:1px; margin-top:10px;">
                    <div class="innercont_stff">
                        <div class="div_label" style="width:239px;">
                            Number of records to process at once
                        </div>
                        <div class="div_select">
                            <select name=" number_of_records_to_process" id="number_of_records_to_process" class="select" style="display:block">
                                <option value="" selected="selected"></option><?php
                                for ($t = 1000; $t <= 10000; $t+=500)
                                {?>
                                    <option value="<?php echo $t ?>" <?php if (isset($_REQUEST["number_of_records_to_process"]) && $_REQUEST["number_of_records_to_process"] == $t){echo 'selected';} ?>><?php echo $t;?></option><?php
                                }?>
                            </select>
                        </div>
                        <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
                    </div>
                </div><?php

                if ((isset($_REQUEST["conf"]) && $_REQUEST["conf"] == '1'))
                {
                    $semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);
                    $account_close_date = substr($orgsetins['ac_close_date'],4,4).'-'.substr($orgsetins['ac_close_date'],2,2).'-'.substr($orgsetins['ac_close_date'],0,2);
                    $account_open_date = substr($orgsetins['ac_open_date'],4,4).'-'.substr($orgsetins['ac_open_date'],2,2).'-'.substr($orgsetins['ac_open_date'],0,2);

                    $wrking_year_tab = WORKING_YR_TABLE;
                    $cnter = 0;

                    $stmt = $mysqli->prepare("SELECT vMatricNo FROM s_m_t WHERE vMatricNo NOT LIKE 'NOU02%' AND vMatricNo NOT IN (SELECT vMatricNo FROM s_tranxion_prev_bal1_new ORDER BY vMatricNo) ORDER BY vMatricNo LIMIT ".$_REQUEST["number_of_records_to_process"]);
                    //$stmt = $mysqli->prepare("SELECT vMatricNo FROM s_m_t WHERE vMatricNo = 'NOU211087737'");
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($studenId);
                    
                    while($stmt->fetch())
                    {
                        $stmt_cr = $mysqli->prepare("SELECT SUM(amount)
                        FROM s_tranxion_cr
                        WHERE LEFT(tdate,10) > '$account_close_date'
                        AND vMatricNo = '$studenId';");							
                        //$stmt_cr->bind_param("s", $_REQUEST["vMatricNo"]);
                        $stmt_cr->execute();
                        $stmt_cr->store_result();
                        $stmt_cr->bind_result($Amount_bal_1);
                        $stmt_cr->fetch();
                        if (is_null($Amount_bal_1))
                        {
                            $Amount_bal_1 = 0.00;
                        }

                        $stmt_dr = $mysqli->prepare("SELECT SUM(amount)
                        FROM $wrking_year_tab
                        WHERE LEFT(tdate,10) > '$account_close_date'
                        AND vMatricNo = '$studenId';");							
                        //$stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                        $stmt_dr->execute();
                        $stmt_dr->store_result();
                        $stmt_dr->bind_result($Amount_bal_2);
                        $stmt_dr->fetch();                    
                        if (is_null($Amount_bal_2))
                        {
                            $Amount_bal_2 = 0.00;
                        }

                        $stmt_cur_bal = $mysqli->prepare("SELECT n_balance
                        FROM s_tranxion_prev_bal1
                        WHERE vMatricNo = '$studenId';");							
                        //$stmt_cur_bal->bind_param("s", $_REQUEST["vMatricNo"]);
                        $stmt_cur_bal->execute();
                        $stmt_cur_bal->store_result();
                        $stmt_cur_bal->bind_result($Amount_bal);
                        $stmt_cur_bal->fetch();                    
                        if (is_null($Amount_bal))
                        {
                            $Amount_bal = 0.00;
                        }


                        $stmt_b = $mysqli->prepare("SELECT SUM(amount)
                        FROM s_tranxion_cr
                        WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_open_date')
                        AND vMatricNo = '$studenId';");							
                        //$stmt_b->bind_param("s", $_REQUEST["vMatricNo"]);
                        $stmt_b->execute();
                        $stmt_b->store_result();
                        $stmt_b->bind_result($old_cr_bal);
                        $stmt_b->fetch();                        
                        if (is_null($old_cr_bal))
                        {
                            $old_cr_bal = 0.00;
                        }

                        $stmt_b = $mysqli->prepare("SELECT SUM(amount)
                        FROM $wrking_year_tab
                        WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_open_date')
                        AND cCourseId NOT LIKE 'F0%'
                        AND trans_count IS NOT NULL
                        AND vMatricNo = '$studenId';");							
                        //$stmt_b->bind_param("s", $_REQUEST["vMatricNo"]);
                        $stmt_b->execute();
                        $stmt_b->store_result();
                        $stmt_b->bind_result($old_dr_bal);
                        $stmt_b->fetch();                        
                        if (is_null($old_dr_bal))
                        {
                            $old_dr_bal = 0.00;
                        }

                        $credit_balance = $Amount_bal_1+$old_cr_bal;
                        $debit_balance = $Amount_bal_2 + $old_dr_bal;

                        if ($Amount_bal < 0)
                        {
                            $debit_balance += $Amount_bal;
                        }else
                        {
                            $credit_balance += $Amount_bal;
                        }

                        $balance = $credit_balance - $debit_balance;
                        //echo $studenId.' 1: '.$Amount_bal_1.' 2: '.$Amount_bal_2.' 3: '.$Amount_bal.' 4: '.$old_cr_bal.' 5: '.$old_dr_bal.' 6: '.$balance.'<br>';
                        
                        $stmt_balance = $mysqli->prepare("INSERT IGNORE INTO s_tranxion_prev_bal1_new
                        SET vMatricNo = '$studenId',
                        credit = $credit_balance,
                        debit = $debit_balance,
                        n_balance = $balance,
                        actual_balance = $balance");
                        $stmt_balance->execute();

                        $cnter++;
                    }

                    if ($cnter == 0)
                    {
                        caution_box_inline('Done.');
                    }else
                    {
                        echo 'More to go';
                    }
                }?>

                <div id="smke_screen_2" class="smoke_scrn" 
                style="display:<?php if (isset($_REQUEST["conf"]) && $_REQUEST["conf"] == '1'){?>block<?php }else{?>none <?php }?>; z-index:2"></div>
                <div id="conf_box_loc" class="center" style="display:<?php if (isset($_REQUEST["conf"]) && $_REQUEST["conf"] == '1'){?>block<?php }else{?>none <?php }?>; width:400px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; z-index:3">
                    <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                        Confirmation
                    </div>
                    <a href="#" style="text-decoration:none;">
                        <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                    </a>
                    
                    <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:100%; float:left; text-align:center; padding:0px;">
                        There are (more) records to process. Continue?
                    </div>
                    <div style="margin-top:10px; width:100%; float:left; text-align:right; padding:0px;">
                        <a href="#" style="text-decoration:none;" 
                            onclick="_('student_balances_loc').conf.value = '1';
                            in_progress('1');
                            student_balances_loc.submit();
                            return false">
                            <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                                Yes
                            </div>
                        </a>

                        <a href="#" style="text-decoration:none;" 
                            onclick="_('conf_box_loc').style.display='none';
                            _('smke_screen_2').style.display='none';
                            _('smke_screen_2').style.zIndex='-1';
                            _('student_balances_loc').conf.value = '0';
                            return false">
                            <div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
                                No
                            </div>
                        </a>
                    </div>
                </div>
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
                    
                    <?php //side_detail($_REQUEST['uvApplicationNo']);?>
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