<?php
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/
	
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
<link rel="stylesheet" type="text/css" media="all" href="style_sheet_1.css" />
<script language="JavaScript" type="text/javascript">
	document.onkeydown = function (e) 
	{
		if (e.ctrlKey && e.keyCode === 85) 
		{
            return false;
        }
	}
</script>
<noscript></noscript>

<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript" type="text/javascript">
	// function preventBack(){window.history.forward();}
	// setTimeout("preventBack()", 0);
	// window.onunload=function(){null};

    //check_environ();

	// function preventBack(){window.history.forward();}
	// 	setTimeout("preventBack()", 0);
	// 	window.onunload=function(){null};		
		
    //window.resizeTo(screen.availWidth, screen.availHeight)
	//window.moveTo(0,0)
</script><?php

require_once ('set_scheduled_dates.php');?>
<!-- InstanceEndEditable -->
</head>
<body onLoad="checkConnection()"><?php 
    
    $msg = '';
    if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1' && isset($_REQUEST['critno']))
    {
        $cProgrammeId_loc = "%".$_REQUEST['cProgrammeId']."%";

        if ($dc == '1')
        {
            $stmt = $mysqli->prepare("SELECT *
            FROM criteriasubject
            WHERE cProgrammeId LIKE ?
            AND sReqmtId = ?");
            $stmt->bind_param("si", $cProgrammeId_loc, $sReqmtId);
            $stmt->execute();
            $stmt->store_result();
            
            if ($stmt->num_rows > 0)
            {
                $msg = 'Please delete qualification(s) under this criterion';
                $stmt->close();
            }else
            {
                $stmt = $mysqli->prepare("DELETE from criteriadetail WHERE cProgrammeId LIKE ? AND sReqmtId = ?");
                $stmt->bind_param("si", $cProgrammeId_loc, $sReqmtId);
                $stmt->execute();
                $stmt->close();
                
                $msg = 'Criterion number '.$_REQUEST['critno'].' successfully deleted';
                log_actv('Deleted criterion for '.$cProgrammeId.' in '.$cFacultyId);
            }
        }

        if ($en == '1')
        {
            $stmt = $mysqli->prepare("UPDATE criteriadetail SET cStatus = '1' WHERE cProgrammeId LIKE ? AND sReqmtId = ?");
            $stmt->bind_param("si", $cProgrammeId_loc, $sReqmtId);
            $stmt->execute();
            $stmt->close();
            
            $msg = 'Criterion number '.$_REQUEST['critno'].' successfully enabled';
            log_actv('Enabled criterion for '.$cProgrammeId.' in '.$cFacultyId);
        }

        if ($dis == '1')
        {
            $stmt = $mysqli->prepare("UPDATE criteriadetail SET cStatus = '0' WHERE cProgrammeId LIKE ? AND sReqmtId = ?");
            $stmt->bind_param("si", $cProgrammeId_loc, $sReqmtId);
            $stmt->execute();
            $stmt->close();
            
            $msg = 'Criterion number '.$_REQUEST['critno'].' successfully disabled';
            log_actv('Disabled criterion for '.$cProgrammeId.' in '.$cFacultyId);
        }
    }
    
    admin_frms(); $has_matno = 0;?>
	
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
    
    <?php nav_frm();?>
    <form action="add-edit-criterion" method="post" name="n_crit" enctype="multipart/form-data">
        <?php frm_vars();?>
        <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
    </form>
    <form action="edit_qualification" method="post" name="e_qual" enctype="multipart/form-data">
        <?php frm_vars();?>
        <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
    </form>
    
    <form action="edit-criterion" method="post" name="e_crit" enctype="multipart/form-data">
        <input name="critno" id="critno" type="hidden" />
        <input name="endis" id="endis" type="hidden" value="" />
        <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
        <input name="move_crit" id="move_crit" type="hidden" value="0" />
        <input name="save" id="save" type="hidden" value="0" />
        <?php frm_vars();?>
    </form><?php
	//include ('msg_service.php');?>
	
	<!-- InstanceBeginEditable name="nakedbody" -->
		<div id="container_cover_constat" style="display:none"></div>
		<div id="container_cover_in_constat" class="center" style="display:none; position:fixed;">
			<div id="div_header_main" class="innercont_stff" 
				style="float:left;
				width:99.5%;
				height:auto;
				padding:0px;
				padding-top:3px;
				padding-bottom:4px;
				border-bottom:1px solid #cccccc;">
				<div id="div_header_constat" class="innercont_stff" style="float:left; color:#FF3300;">
					Internet Connection Status
				</div>
			</div>
			
			<div id="div_message_constat" class="innercont_stff" style="margin-top:40px; float:left; width:413px; height:auto; color:#FF3300;">
				You are not connected
			</div>
		</div>
	<!-- InstanceEndEditable -->
<div id="container"><?php
	time_out_box($currency);?>

	<noscript>
		<div class="smoke_scrn" style="display:block"></div>
		<?php information_box_inline('You need to enable javascript for this browser');?>
	</noscript>
	<?php do_toup_div('Student Management System');?>
	<div id="menubar">
		<!-- InstanceBeginEditable name="menubar" -->
		<?php require_once ('menu_bar_content_stff.php');?>
		<!-- InstanceEndEditable -->
	</div>

	<div id="leftSide_std" style="margin-left:0px;"><?php
		require_once ('stff_left_side_menu.php');?>
	</div>
	<div id="rtlft_std" style="position:relative;">
		<!-- InstanceBeginEditable name="EditRegion6" --><?php	
            if ($currency == '1')
            {?>
                <div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>

                <input name="conf" id="conf" type="hidden" value="-1" />

                <div id="conf_box" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
                    <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                        Confirmation
                    </div>
                    <a href="#" style="text-decoration:none;">
                        <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                    </a>
                    <div id="conf_msg_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;"></div>
                    <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
                        <a href="#" style="text-decoration:none;" 
                            onclick="e_crit.conf.value='1';
                            e_crit.submit();
                            return false">
                            <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                                Yes
                            </div>
                        </a>

                        <a href="#" style="text-decoration:none;" 
                            onclick="e_crit.ac.value='';
                            e_crit.ec.value='';
                            e_crit.dc.value='';												
                            e_crit.aq.value='';
                            e_crit.eq.value='';
                            e_crit.dq.value='';												
                            e_crit.as.value='';
                            e_crit.es.value='';
                            e_crit.ds.value='';
                            e_crit.das.value='';												
                            e_crit.en.value='';
                            e_crit.dis.value='';
                            e_crit.admt.value='';
                            e_crit.conf.value='';
                            e_crit.sbjlist.value='';
                            return false">
                            <div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
                                No
                            </div>
                        </a>
                    </div>
                </div><?php

                if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1' && $msg <> '')
                {
                    if(!is_bool(strpos(strtolower($msg), 'successful')))
                    {?>
                        <div id="info_box_green" class="center" style="display:block; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:3">
                            <div style="width:350px; float:left; text-align:left; padding:0px; color:#36743e; font-weight:bold">
                                Information
                            </div>
                            <a href="#" style="text-decoration:none;">
                                <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                            </a>
                            <div id="msg_msg_info_green" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;"><?php echo $msg; ?></div>

                            <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
                                <a href="#" style="text-decoration:none;" 
                                    onclick="_('info_box_green').style.display='none';
                                    _('info_box_green').style.zIndex='-1';
                                    _('smke_screen_2').style.display='none';
                                    _('smke_screen_2').style.zIndex='-1';
                                    return false">
                                    <div class="submit_button_home" style="width:60px; padding:6px; float:right">
                                        Ok
                                    </div>
                                </a>
                            </div>
                        </div><?php
                    }else if(!is_bool(strpos(strtolower($msg), 'please')))
                    {
                        caution_box($msg);
                    }else
                    {
                        caution_box($msg);
                    }
                }?>

                
                
                <div id="conf_box_loc" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
                    <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                        Confirmation
                    </div>
                    <a href="#" style="text-decoration:none;">
                        <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                    </a>
                    <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;"></div>
                    <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
                        <a href="#" style="text-decoration:none;" 
                            onclick="e_crit.conf.value='1';
							e_crit.submit();
                            return false">
                            <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                                Yes
                            </div>
                        </a>

                        <a href="#" style="text-decoration:none;" 
                            onclick="e_crit.ac.value='';
							e_crit.ec.value='';
							e_crit.dc.value='';												
							e_crit.aq.value='';
							e_crit.eq.value='';
							e_crit.dq.value='';												
							e_crit.as.value='';
							e_crit.es.value='';
							e_crit.ds.value='';
							e_crit.das.value='';												
							e_crit.en.value='';
							e_crit.dis.value='';
							e_crit.admt.value='';
							e_crit.conf.value='';
							e_crit.sbjlist.value='';
                            _('conf_box_loc').style.display='none';
                            _('conf_box_loc').style.zIndex='-1';
                            _('smke_screen_2').style.display='none';
                            _('smke_screen_2').style.zIndex='-1';
                            return false">
                            <div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
                                No
                            </div>
                        </a>
                    </div>
                </div>


                <input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $cFacultyId ?>" />
                <input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $cdept ?>" />
                <input name="cFacultyId_loc" id="cFacultyId_loc" type="hidden" value="<?php echo $cFacultyId ?>" />
                <input name="cdeptId_loc" id="cdeptId_loc" type="hidden" value="<?php echo $cdept ?>" />
                <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u ?>" />
                
                <div class="innercont_top">
                    <a href="#"style="text-decoration:none; color:#4ab963" onclick="
                        pgprgs1.ac.value='';
                        pgprgs1.ec.value='';
                        pgprgs1.dc.value='';												
                        pgprgs1.aq.value='';
                        pgprgs1.eq.value='';
                        pgprgs1.dq.value='';
                        pgprgs1.as.value='';
                        pgprgs1.es.value='';
                        pgprgs1.ds.value='';
                        pgprgs1.das.value='';												
                        pgprgs1.en.value='';
                        pgprgs1.dis.value='';
                        pgprgs1.admt.value='';
                        pgprgs1.conf.value='';
                        pgprgs1.sbjlist.value='';
                        pgprgs1.cFacultyId.value='<?php if (isset($_REQUEST['cFacultyId'])){echo $_REQUEST['cFacultyId'];} ?>';
                        pgprgs1.cdept.value='<?php if (isset($_REQUEST['cdept'])){echo $_REQUEST['cdept'];} ?>';
                        pgprgs1.cProgrammeId.value='<?php if (isset($_REQUEST['cProgrammeId'])){echo $_REQUEST['cProgrammeId'];} ?>';

                        pgprgs1.vFacultyDesc.value='<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>';
                        pgprgs1.vdeptDesc.value='<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>';
                        pgprgs1.vObtQualTitle.value='<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>';
                        pgprgs1.cEduCtgId.value='<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>';
                        pgprgs1.vProgrammeDesc.value='<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>';
                        pgprgs1.submit()"><?php nav_text($sm);?></a> :: List of criteria
                </div>
                
            
                <div id="succ_boxt" class="succ_box blink_text orange_msg"></div>

                <div class="innercont_stff" style="margin-bottom:3px; color:#FF3300;">
                    <?php echo 'Faculty of '.$_REQUEST['vFacultyDesc'].' ::: Department of '.$_REQUEST['vdeptDesc'].' :: '.$_REQUEST['vObtQualTitle'].' '.$_REQUEST['vProgrammeDesc']; ?>
                </div>
                
                <hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />

                <div id="numAdmitd" class="innercont_stff" style="text-align:right; color:#FF3300;"><?php 
                    $stmt = $mysqli->prepare("SELECT * FROM prog_choice 
                    WHERE cProgrammeId = ?");
                    $stmt->bind_param("s", $_REQUEST['cProgrammeId']);
                    $stmt->execute();
                    $stmt->store_result();
                    $count1 = $stmt->num_rows;
                    $stmt->close();
                    
                    $stmt = $mysqli->prepare("SELECT * FROM prog_choice WHERE cProgrammeId = ? AND cSbmtd <> '0'");
                    $stmt->bind_param("s", $_REQUEST['cProgrammeId']);
                    $stmt->execute();
                    $stmt->store_result();
                    $count2 = $stmt->num_rows;
                    $stmt->close();
                    echo 'Total admitted: '.number_format($count2).'::Total available: '.number_format($count1); ?>
                </div>

                <div class="innercont_stff" style="width:1320px; font-weight:bold;">
                    <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; padding-right:3px; text-align:right; width:5%">Sno</div>
                    
                    <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; width:55%; text-align:left; text-indent:2px">Description</div>
                    
                    <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:12%; padding-right:3px;">Entry level</div>
                    
                    <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:12%; padding-right:3px;">Admitted</div><?php
                    if ($sm == '1')
                    {?>
                        <a href="#"target="_self" style="text-decoration:none" 
                            onclick="
                            n_crit.ac.value='1';
                            n_crit.ec.value='';
                            n_crit.dc.value='';												
                            n_crit.aq.value='';
                            n_crit.eq.value='';
                            n_crit.dq.value='';												
                            n_crit.as.value='';
                            n_crit.es.value='';
                            n_crit.ds.value='';
                            n_crit.das.value='';												
                            n_crit.en.value='';
                            n_crit.dis.value='';
                            n_crit.admt.value='';
                            n_crit.conf.value='';
                            n_crit.sbjlist.value='';
                            n_crit.vReqmtDesc.value='';
                            n_crit.iBeginLevel.value='';
                            n_crit.submit()">
                                <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:12.2%; padding-right:3px;">
                                    Add
                                </div>
                        </a><?php 
                    }else
                    {?>                    
                        <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; color:#E3EBE2; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:12.2%; padding-right:3px;">.</div><?php
                    }?>
                </div><?php
                $cProgrammeId_loc = "%".$_REQUEST['cProgrammeId']."%";
                
                $stmt = $mysqli->prepare("SELECT cUsed, cStatus FROM criteriadetail where cCriteriaId = ? and sReqmtId = ?");
                $stmt->bind_param("si", $cProgrammeId, $sReqmtId);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($cUsed, $cStatus);
                $stmt->fetch();
                $crit_used = $cUsed;
                $endis = $cStatus;
                $stmt->close();
                
                $sub_qry = "AND cEduCtgId_1 = 'OL' AND iBeginLevel = 100";
                if ($vQualCodeDesc <> 'Olevel')
                {
                    $sub_qry = "AND cEduCtgId_2 = '$cEduCtgId_2'";
                };

                $stmt_ds = $mysqli->prepare("SELECT cProgrammeId FROM criteriadetail
                WHERE cProgrammeId LIKE ?
                AND cProgrammeId LIKE '%,%'
                AND sReqmtId = ?
                $sub_qry");
                $stmt_ds->bind_param("si", $cProgrammeId_loc, $sReqmtId);
                $stmt_ds->execute();
                $stmt_ds->store_result();
                $stmt_ds->bind_result($cProgrammeId_locc);
                $progs_affected = $stmt_ds->num_rows;
                $stmt_ds->fetch();
                $stmt_ds->close();
                
                $cProgrammeId_locc = $cProgrammeId_locc ?? '';
                
                $number_of_afected_programmes = strrpos($cProgrammeId_locc, ",")/4;
                if (is_numeric($number_of_afected_programmes))
                {
                    $number_of_afected_programmes = intval($number_of_afected_programmes-1);
                }?>
                <input name="progs_affected" id="progs_affected" type="hidden" value="<?php if($progs_affected>0){echo $number_of_afected_programmes. ' other programmes will also be affected<br>';}?>"/><?php

                $stmt = $mysqli->prepare("SELECT sReqmtId, vReqmtDesc, iBeginLevel, cUsed, cStatus, cEduCtgId_1, cEduCtgId_2
                FROM criteriadetail 
                WHERE cProgrammeId LIKE ?
                ORDER BY iBeginLevel DESC");
                $stmt->bind_param("s",  $cProgrammeId_loc);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($sReqmtId, $vReqmtDesc, $iBeginLevel, $cUsed, $cStatus, $cEduCtgId_1, $cEduCtgId_2);
                $numOfcrthd = $stmt->num_rows;
                
                $tot_cnt= 0; $cnt = 0;?>
                <div class="innercont_stff" style="height:73.2%; overflow:scroll; overflow-x: hidden;"><?php
                    while($stmt->fetch())
                    {
                        $cnt++;
                        if ($cnt%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
                        <label class="lbl_beh">
                            <div class="innercont_stff" style="width:1320px;">
                                <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; padding-right:3px; text-align:right; width:5%"><?php echo $cnt;?></div>
                                
                                <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; margin-left:-1px; width:55%; text-align:left; text-indent:2px"><?php echo $vReqmtDesc; ?></div>
                                
                                <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; margin-left:-1px; text-align:right; width:12%; padding-right:3px;"><?php echo $iBeginLevel;?></div>
                                
                                <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; margin-left:-1px; text-align:right; width:12%; padding-right:3px;"><?php											
                                    $stmt2 = $mysqli->prepare("SELECT * 
                                    FROM prog_choice 
                                    WHERE cProgrammeId = ?
                                    AND cSbmtd <> '0'
                                    AND cReqmtId = '".$sReqmtId."'");
                                    $stmt2->bind_param("s", $_REQUEST['cProgrammeId']);
                                    $stmt2->execute();
                                    $stmt2->store_result();
                        
                                    $admitted = number_format($stmt2->num_rows);
                                    echo $admitted;
                                    $tot_cnt += $stmt2->num_rows;
                                    $stmt2->close();?>
                                </div>

                                <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; margin-left:-1px; text-align:right; width:12.2%; padding-right:3px;"><?php
                                    if ($cUsed == '1' || $admitted > 0)
                                    {
                                        $img_src = '';
                                        $title_txt = '';
                                        if ($sm == '1')
                                        {
                                            echo 'Used';
                                        }else if ($sm == '2')
                                        {
                                            //$img_src = 'edit_dull.gif';
                                            echo 'NE';
                                            $title_txt = 'Not editable. Criterion used for admission';
                                        }else if ($sm == '3')
                                        {
                                            //$img_src = 'enable_d.gif';
                                            echo 'NE';
                                            $title_txt = 'Cannot be dis/enable. Criterion used for admission';
                                        }else if ($sm == '5')
                                        {
                                            $img_src = 'delete_d.gif';
                                            echo 'NE';
                                            $title_txt = 'Cannot be deleted. Criterion used for admission';
                                        }

                                        if ($sm <> '1')
                                        {?>.
                                            <!--<img src="img/<?php echo $img_src; ?>" style="cursor:not-allowed" title="<?php echo $title_txt;?>"  width="33" height="13" hspace="0" vspace="0" border="0"/>--><?php
                                        }
                                    }elseif ($sm == '2')
                                    {
                                        if ($cStatus == '1')
                                        {?>
                                            <a href="#"style="text-decoration: none" 
                                                onclick="
                                                n_crit.ac.value='';
                                                n_crit.ec.value='1';
                                                n_crit.dc.value='';												
                                                n_crit.aq.value='';
                                                n_crit.eq.value='';
                                                n_crit.dq.value='';												
                                                n_crit.as.value='';
                                                n_crit.es.value='';
                                                n_crit.ds.value='';
                                                n_crit.das.value='';												
                                                n_crit.en.value='';
                                                n_crit.dis.value='';
                                                n_crit.admt.value='';
                                                n_crit.conf.value='';
                                                n_crit.sbjlist.value='';
                                                
                                                n_crit.cFacultyId.value='<?php if (isset($_REQUEST['cFacultyId'])){echo $_REQUEST['cFacultyId'];} ?>';
                                                n_crit.cdept.value='<?php if (isset($_REQUEST['cdept'])){echo $_REQUEST['cdept'];} ?>';
                                                n_crit.cProgrammeId.value='<?php if (isset($_REQUEST['cProgrammeId'])){echo $_REQUEST['cProgrammeId'];} ?>';

                                                n_crit.vFacultyDesc.value='<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>';
                                                n_crit.vdeptDesc.value='<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>';
                                                n_crit.vObtQualTitle.value='<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>';
                                                n_crit.cEduCtgId.value='<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>';
                                                n_crit.vProgrammeDesc.value='<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>';
                                                
                                                n_crit.cEduCtgId_1.value='<?php echo $cEduCtgId_1;?>';                                            
                                                n_crit.cEduCtgId_2.value='<?php echo $cEduCtgId_2;?>';

                                                n_crit.iBeginLevel.value='<?php echo $iBeginLevel; ?>';
                                                n_crit.vReqmtDesc.value='<?php echo addslashes( $vReqmtDesc); ?>';
                                                n_crit.sReqmtId.value='<?php echo $sReqmtId; ?>';
                                                n_crit.submit()">
                                                    Edit
                                                </a><?php
                                        }else
                                        {
                                            echo 'Disabled';?>
                                            <!-- <img src="img/enable_d.gif" title="Disabled criterion" width="28" height="15" hspace="0" vspace="0" />--><?php
                                        }
                                    }elseif ($sm == '3')
                                    {
                                        if ($cUsed == '0')
                                        {?>
                                            <a href="#"style="text-decoration: none" 
                                            onclick="										
                                            e_crit.ac.value='';
                                            e_crit.ec.value='';
                                            e_crit.dc.value='';												
                                            e_crit.aq.value='';
                                            e_crit.eq.value='';
                                            e_crit.dq.value='';												
                                            e_crit.as.value='';
                                            e_crit.es.value='';
                                            e_crit.ds.value='';
                                            e_crit.das.value='';												
                                            e_crit.en.value='';
                                            e_crit.dis.value='';
                                            e_crit.admt.value='';
                                            e_crit.conf.value='';
                                            e_crit.sbjlist.value='';
                                            if(_('userInfo_f').value!=_('cFacultyId').value&&_('sRoleID').value!=6)
                                            {
                                                caution_box('You cannot delete criteria in the selected faculty');
                                            }
                                            else if(_('userInfo_d').value!=_('cdept').value&&_('sRoleID').value!=6)
                                            {
                                                caution_box('You cannot delete criteria in the selected department');
                                            }else
                                            {
                                                e_crit.en.value='<?php if ($cStatus == '0'){?>1<?php }?>';
                                                e_crit.dis.value='<?php if ($cStatus == '1'){?>1<?php }?>';
                                                e_crit.iBeginLevel.value='<?php echo $iBeginLevel; ?>';
                                                e_crit.vReqmtDesc.value='<?php echo addslashes($vReqmtDesc); ?>';
                                                e_crit.sReqmtId.value='<?php echo $sReqmtId; ?>';
                                                e_crit.cProgrammeId.value='<?php echo $cProgrammeId; ?>';
                                                e_crit.endis.value='<?php echo $cStatus; ?>';
                                                e_crit.critno.value=<?php echo $cnt ?>;
                                                if(e_crit.dis.value=='1')
                                                {
                                                    _('conf_msg_msg_loc').innerHTML = 'Are you sure you want to <b>disable</b> criteion number '+_('critno').value +'? ';
                                                    _('conf_box_loc').style.display='block';
                                                    _('conf_box_loc').style.zIndex='3';
                                                    _('smke_screen_2').style.display='block';
                                                    _('smke_screen_2').style.zIndex='2';
                                                }else if(e_crit.en.value=='1')
                                                {
                                                    _('conf_msg_msg_loc').innerHTML = 'Are you sure you want to <b>enable</b> criteion number '+_('critno').value +'? ';
                                                    _('conf_box_loc').style.display='block';
                                                    _('conf_box_loc').style.zIndex='3';
                                                    _('smke_screen_2').style.display='block';
                                                    _('smke_screen_2').style.zIndex='2';
                                                }
                                            }"><?php 
                                            if ($cStatus == '0')
                                            {
                                                echo 'Enable';?>
                                                <!-- <img src="img/enable.gif" title="Enable criterion"  width="32" height="16" hspace="0" vspace="0" border="0" />--><?php
                                            }else
                                            {
                                                echo 'Disable';?>
                                                <!-- <img src="img/disable.gif" title="Disable criterion"  width="32" height="16" hspace="0" vspace="0" border="0" />--><?php
                                            }?>
                                            </a><?php
                                        }
                                    }elseif ($sm == '5')
                                    {?>	
                                        <a href="#" onclick="
                                        e_crit.ac.value='';
                                        e_crit.ec.value='';
                                        e_crit.dc.value='1';												
                                        e_crit.aq.value='';
                                        e_crit.eq.value='';
                                        e_crit.dq.value='';												
                                        e_crit.as.value='';
                                        e_crit.es.value='';
                                        e_crit.ds.value='';
                                        e_crit.das.value='';												
                                        e_crit.en.value='';
                                        e_crit.dis.value='';
                                        e_crit.admt.value='';
                                        e_crit.conf.value='';	
                                        e_crit.sbjlist.value='';													
                                        if(_('userInfo_f').value!=_('cFacultyId').value&&_('sRoleID').value!=6)
                                        {
                                            caution_box('You cannot delete criteria in the selected faculty');
                                        }else if(_('userInfo_d').value!=_('cdept').value&&_('sRoleID').value!=6)
                                        {
                                            caution_box('You cannot delete criteria in the selected department');
                                        }else
                                        {
                                            e_crit.iBeginLevel.value='<?php echo $iBeginLevel; ?>';
                                            e_crit.vReqmtDesc.value='<?php echo addslashes($vReqmtDesc); ?>';
                                            e_crit.sReqmtId.value='<?php echo $sReqmtId; ?>';
                                            e_crit.critno.value=<?php echo $cnt ?>;

                                            e_crit.cFacultyId.value='<?php if (isset($_REQUEST['cFacultyId'])){echo $_REQUEST['cFacultyId'];} ?>';
                                            e_crit.cdept.value='<?php if (isset($_REQUEST['cdept'])){echo $_REQUEST['cdept'];} ?>';
                                            e_crit.cProgrammeId.value='<?php if (isset($_REQUEST['cProgrammeId'])){echo $_REQUEST['cProgrammeId'];} ?>';

                                            e_crit.vFacultyDesc.value='<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>';
                                            e_crit.vdeptDesc.value='<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>';
                                            e_crit.vObtQualTitle.value='<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>';
                                            e_crit.cEduCtgId.value='<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>';
                                            e_crit.vProgrammeDesc.value='<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>';
                                                                                        
                                            _('conf_msg_msg_loc').innerHTML = 'Are you sure you want to delete criterion number <?php echo $cnt; ?>? ';
                                            _('conf_box_loc').style.display='block';
                                            _('conf_box_loc').style.zIndex='3';
                                            _('smke_screen_2').style.display='block';
                                            _('smke_screen_2').style.zIndex='2';
                                        }" style="text-decoration: none">
                                            Delete
                                            <!-- <img src="img/delete.gif" hspace="0" width="33" height="13" vspace="0" border="0" title="delete criterion" /> -->
                                        </a><?php
                                    }else
                                    {
                                        echo '-';
                                    }?>

                                    <a href="#"style="text-decoration: none"
                                        onclick="e_qual.ac.value='';
                                        e_qual.ec.value='';
                                        e_qual.dc.value='';												
                                        e_qual.aq.value='';
                                        e_qual.eq.value='';
                                        e_qual.dq.value='';												
                                        e_qual.as.value='';
                                        e_qual.es.value='';
                                        e_qual.ds.value='';
                                        e_qual.das.value='';												
                                        e_qual.en.value='';
                                        e_qual.dis.value='';
                                        e_qual.admt.value='';
                                        e_qual.conf.value='';
                                        e_qual.sbjlist.value='';

                                        e_qual.cFacultyId.value='<?php if (isset($_REQUEST['cFacultyId'])){echo $_REQUEST['cFacultyId'];} ?>';
                                        e_qual.cdept.value='<?php if (isset($_REQUEST['cdept'])){echo $_REQUEST['cdept'];} ?>';
                                        e_qual.cProgrammeId.value='<?php if (isset($_REQUEST['cProgrammeId'])){echo $_REQUEST['cProgrammeId'];} ?>';

                                        e_qual.vFacultyDesc.value='<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>';
                                        e_qual.vdeptDesc.value='<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>';
                                        e_qual.vObtQualTitle.value='<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>';
                                        e_qual.cEduCtgId.value='<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>';
						                e_qual.vProgrammeDesc.value='<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>';
                                                                                
                                        e_qual.cEduCtgId_1.value='<?php echo $cEduCtgId_1;?>';                                            
                                        e_qual.cEduCtgId_2.value='<?php echo $cEduCtgId_2;?>';

                                        e_qual.vReqmtDesc.value='<?php echo addslashes($vReqmtDesc); ?>';
                                        
                                        e_qual.used_admitted.value='<?php echo $admitted;?>';
                                                    
                                        e_qual.iBeginLevel.value='<?php echo $iBeginLevel; ?>';
                                        e_qual.sReqmtId.value='<?php echo $sReqmtId; ?>';
                                        e_qual.submit();">
                                        Details <!-- <img src="img/detail.gif" title="Criterion detail" width="33" height="14" border="0" /> -->
                                    </a>
                                </div>
                            </div>
                        </label><?php
                    }?>            
                </div><?php
            }?>
		<!-- InstanceEndEditable -->
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
                
				<div style="width:auto; padding-top:6px; padding-bottom:4px; border-bottom:1px dashed #888888">
				</div>
				<div style="width:auto; padding-top:10px;">
				</div>
				<div style="width:auto; padding-top:6px; padding-bottom:4px; line-height:1.3; border-bottom:1px dashed #888888">
				</div>
				<!-- InstanceEndEditable -->
		</div>
		<div id="insiderightSide" style="position:relative;">
			<!-- InstanceBeginEditable name="EditRegion9" -->
			<?php require_once ('stff_bottom_right_menu.php');?>
			<!-- InstanceEndEditable -->
		</div>
	</div>
	<div id="futa"><?php foot_bar();?></div>
</div>
</body>
<!-- InstanceEnd --></html>