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
    
    
    $semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);

    $num_rec = 0;
    
    if (!isset($_REQUEST["save_cf"]))
    {        
        $stmt1 = $mysqli->prepare("REPLACE INTO matno_reg_24 
        SELECT `vMatricNo`, SUM(b.iCreditUnit) tcu, SUM(b.iCreditUnit) tcu2 
        FROM `examreg_20242025` a, courses_new b 
        WHERE a.cCourseId = b.cCourseId 
        AND `tdate` >= '$semester_begin_date' 
        and vMatricNo NOT IN (SELECT vMatricNo FROM s_m_t WHERE cProgrammeId IN ('LAW301','LAW401')) GROUP BY `vMatricNo` HAVING SUM(b.iCreditUnit) > 24;");
        $stmt1->execute();

        $num_rec = $stmt1->affected_rows;
    }?>

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

            <div class="innercont_top" style="margin-bottom:0px;">Drop Exam (Punitive)</div>
            <p><?php echo $num_rec. ' records available';?><p>
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

            <form method="post" name="adjust_loc" id="adjust_loc" enctype="multipart/form-data">
                <input name="save_cf" id="save_cf" type="hidden" value="-1" />
                
                <input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId_u ?>" />
                <input name="study_mode_su" id="study_mode_su" type="hidden" value="odl" />
                <input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdeptId_u ?>" /><?php 
                frm_vars();

                if (isset($_REQUEST["save_cf"]))
                {
                    $cnter = 0;

                    $stmt = $mysqli->prepare("SELECT vMatricNo, tcu
                    FROM matno_reg_24
                    WHERE tcu = tcu2
                    LIMIT 200");

                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($studenId, $tcu);
                    
                    while($stmt->fetch())
                    {
                        $delete_examreg = 0;
                        $delete_tranxion = 0;

                        $tcu2 = $tcu;

                        $stmt1 = $mysqli->prepare("SELECT cCourseId, tdate
                        FROM examreg_20242025
                        WHERE vMatricNo = '$studenId'
                        AND tdate >= '$semester_begin_date'");
                        $stmt1->execute();
                        $stmt1->store_result();
                        $stmt1->bind_result($cCourse_Id, $tdate);
                        while($stmt1->fetch())
                        {
                            $stmt2 = $mysqli->prepare("SELECT iCreditUnit FROM courses_new WHERE cCourseId = '$cCourse_Id'");
                            $stmt2->execute();
                            $stmt2->store_result();
                            $stmt2->bind_result($iCreditUnit);
                            $stmt2->fetch();

                            if ($iCreditUnit > 3){continue;}
                            
                            //delet from examreg_20242025
                            $delete_from_examreg = $mysqli->prepare("DELETE FROM examreg_20242025 
                            WHERE vMatricNo = '$studenId'
                            AND tdate = '$tdate'
                            AND cCourseId = '$cCourse_Id'");
                            $delete_from_examreg->execute();
                            $delete_examreg = $delete_from_examreg->affected_rows;
                            
                            //delete from s_tranxion_20242025
                            $delete_from_examreg = $mysqli->prepare("DELETE FROM s_tranxion_20242025
                            WHERE vMatricNo = '$studenId'
                            AND tdate = '$tdate'
                            AND cCourseId = '$cCourse_Id'
                            AND fee_item_id = 8");
                            $delete_from_examreg->execute();
                            $delete_tranxion = $delete_from_examreg->affected_rows;

                            if ($delete_examreg > 0)
                            {
                                $tcu2 -= $iCreditUnit;

                                if ($tcu2 <= 24)
                                {
                                    break;
                                }
                            }
                        }

                        if ($tcu2 < $tcu)
                        {
                            $stmt3 = $mysqli->prepare("UPDATE matno_reg_24
                            SET tcu2 = $tcu2
                            WHERE vMatricNo = '$studenId'");
                            $stmt3->execute();

                            echo ($cnter+1).$studenId.'<br>';
                        }
                        
                        $cnter++;
                    }

                    if ($cnter == 0)
                    {
                        echo '<p>Done';
                    }else
                    {
                        echo 'More to go';
                    }
                }else if ($num_rec > 0)
                {
                    echo '<p> Click Submit button to begin'; 
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
                    
                    <?php side_detail($_REQUEST['uvApplicationNo']);?>
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