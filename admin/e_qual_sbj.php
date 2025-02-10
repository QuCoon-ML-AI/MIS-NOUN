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

    $has_matno = 0;    
    
	$sbj_fxd = '';
	$NoOfsbjExpected = 0;
    $NoOfsbjEntered = 0;
    $crit_used = '0';   


    $stmt = $mysqli->prepare("select iQSLCountSubject from educationctg where cEduCtgId = ?");
    $stmt->bind_param("s", $_REQUEST['cEduCtgId']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($iQSLCountSubject);
    $stmt->fetch();
    $NoOfsbjExpected = $iQSLCountSubject;
    $stmt->close();
    
    //$sReqmtId_qry = get_subjects($_REQUEST['cProgrammeId'],$sReqmtId,$cEduCtgId_1,$cEduCtgId_2,$iBeginLevel,$_REQUEST['cdept'],'qry');
    $sReqmtId_qry = get_subjects($_REQUEST['cProgrammeId'],$_REQUEST['sReqmtId'],$_REQUEST['cEduCtgId_1'],$_REQUEST['cEduCtgId_2'],$_REQUEST['iBeginLevel'],$_REQUEST['cdept'],'qry');
    
    //$child_qry = get_subjects($_REQUEST['cProgrammeId'],$sReqmtId,$cEduCtgId_1,$cEduCtgId_2,$iBeginLevel,$_REQUEST['cdept'],'chld');
    $child_qry = get_subjects($_REQUEST['cProgrammeId'],$_REQUEST['sReqmtId'],$_REQUEST['cEduCtgId_1'],$_REQUEST['cEduCtgId_2'],$_REQUEST['iBeginLevel'],$_REQUEST['cdept'],'chld');

    //$cEduCtgId_qry = get_subjects($_REQUEST['cProgrammeId'],$sReqmtId,$cEduCtgId_1,$cEduCtgId_2,$iBeginLevel,$_REQUEST['cdept'],'edctg');
    $cEduCtgId_qry = get_subjects($_REQUEST['cProgrammeId'],$_REQUEST['sReqmtId'],$_REQUEST['cEduCtgId_1'],$_REQUEST['cEduCtgId_2'],$_REQUEST['iBeginLevel'],$_REQUEST['cdept'],'edctg');
    
    $stmt = $mysqli->prepare("SELECT b.vQualSubjectDesc, a.cQualSubjectId, a.cMandate, a.mutual_ex, c.cQualGradeCode, c.cQualGradeId, c.iQualGradeRank
    FROM criteriasubject a, qualsubject b, qualgrade c
    WHERE a.cQualSubjectId = b.cQualSubjectId 
    AND a.cQualGradeId = c.cQualGradeId
    $sReqmtId_qry
    $child_qry
    $cEduCtgId_qry
    ORDER BY a.cMandate, b.vQualSubjectDesc");

    $stmt->execute();
    $stmt->store_result();
    $NoOfsbjEntered = $stmt->num_rows;
    $stmt->close();
    
    if (isset($_REQUEST['used_admitted']) && $_REQUEST['used_admitted'] > 0)
    {
        $crit_used = $_REQUEST['used_admitted'];
        $err_num = 1;
        $msg = 'Subject list cannot be modified because parent criterion has admitted one or more candidate(s)';
    }elseif ($NoOfsbjExpected == $NoOfsbjEntered)
    {
        $err_num = 1;
        $msg = 'Qualification already filled up. More subjects can only be added under a new qualification for the current criterion. Or, you may click on the edit link below to make changes';
    }
    
    if (isset($_REQUEST['save']) && $_REQUEST['save'] == '1' && $currency == '1' && $msg == '')
    {
        $Remediables = "'";
        $sql = "select cQualSubjectId from qualsubject where cRemedial = '1'";
        $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
        while ($rs = mysqli_fetch_array($rssql))
        {
            $Remediables .= $rs[0]."','";
        }
        mysqli_close(link_connect_db());
        $Remediables = substr($Remediables,0,strlen($Remediables)-2);
        
        $optSelected = '0'; $number1 = $NoOfsbjExpected;
        if ($es == '1'){$number1 = 1; $number2 = $NoOfsbjExpected;}else
        if ($as == '1')
        {
            $number2 = $NoOfsbjExpected; 
            if ($NoOfsbjEntered == 0)
            {
                $number1 = 1;
            }else
            {
                $number1 = $NoOfsbjEntered;
            }
        }
        $remSbjtFound = 0;
        
        for ($c = $number1; $c <= $number2; $c++)
        {
            if (isset($_REQUEST["cQualSubjectId$c"]))
            {
                if ($_REQUEST["cQualSubjectId$c"] <> '' && $_REQUEST["cQualGradeId$c"] <> ''&& $_REQUEST["cMandate$c"] <> '')
                {
                    $optSelected = '1';
                }	

                if (($_REQUEST["cQualSubjectId$c"] <> '' && ($_REQUEST["cQualGradeId$c"] == '' || $_REQUEST["cMandate$c"] == '')) ||
                ($_REQUEST["cQualGradeId$c"] <> '' && ($_REQUEST["cQualSubjectId$c"] == '' || $_REQUEST["cMandate$c"] == '')) ||
                ($_REQUEST["cMandate$c"] <> '' && ($_REQUEST["cQualGradeId$c"] == '' || $_REQUEST["cQualSubjectId$c"] == '')))					
                {
                    $optSelected = '0';
                    break;
                }
                
                // if ($iBeginLevel <> 40 && $_REQUEST["cMandate$c"] == 'C' && substr($_REQUEST["cQualGradeId$c"],strlen($_REQUEST["cQualGradeId$c"])-2,strlen($_REQUEST["cQualGradeId$c"])-1) == '1')
                // {
                // 	$err_num = 2;
                // 	$msg = 'You can only set the minimum grade of a compusory subject at F9 if you set parent criterion to 40Level';
                // 	break;
                // }
                
                
                if ($iBeginLevel == 40)
                {
                    if ($_REQUEST["cMandate$c"] == 'C' && substr($_REQUEST["cQualGradeId$c"],strlen($_REQUEST["cQualGradeId$c"])-2,strlen($_REQUEST["cQualGradeId$c"])-1) == '1' && !is_bool(strpos($Remediables,$_REQUEST["cQualSubjectId$c"])))
                    {
                        $remSbjtFound = 1;
                    }
                }
            }
        }
        
        if ($iBeginLevel == 40 && $remSbjtFound == 0)
        {
            $err_num = 2;
            $msg = 'Please set the grade of one or more of (ENG, MAT, LIT, BIO, CHM, PHY) to F9 and the class to compulsory';
        }
        
        
        if ($optSelected == '0')
        {
            $err_num = 2;
            if (($c-1) == $number2)
            {
                $msg = 'Please select subject(s), corresponding grade and class on row [1]';
            }else
            {
                $msg = 'Please select subject(s), corresponding grade and class on row ['.$c.']';
            }
            
        }else
        {
            $d = 0; $e = 0;
            $fnd_f9 = '0';
            for ($c = 1; $c <= $NoOfsbjExpected; $c++)
            {
                if (isset($_REQUEST["cQualSubjectId$c"]) && $_REQUEST["cQualSubjectId$c"] <> '')
                {
                    if (substr($_REQUEST["cQualGradeId$c"],4,1) == '1' && ($_REQUEST["cQualSubjectId$c"] == '001' || $_REQUEST["cQualSubjectId$c"] == '097' || $_REQUEST["cQualSubjectId$c"] == '079' || $_REQUEST["cQualSubjectId$c"] == '016' || $_REQUEST["cQualSubjectId$c"] == '099' || $_REQUEST["cQualSubjectId$c"] == '098'))
                    {
                        $fnd_f9 = '1';
                    }
            
                    $e++;
                    if ($msg == '' && ($_REQUEST["cQualSubjectId$c"] == '' || $_REQUEST["cQualGradeId$c"] == '' || $_REQUEST["cMandate$c"] == ''))
                    {
                        $err_num = 2;
                        $msg = 'Partial selection in row '.$c.' is not allowed'; break;
                    }
        
                    for ($d = 1; $d <= $NoOfsbjExpected; $d++)
                    {
                        if (isset($_REQUEST["cQualSubjectId$c"]) && isset($_REQUEST["cQualSubjectId$d"]))
                        {
                            if ($msg == '' && ($_REQUEST["cQualSubjectId$c"] == $_REQUEST["cQualSubjectId$d"]) && ($d <> $c))
                            {
                                $err_num = 2;
                                $msg = 'Duplicate selections in rows <b>'.$c.'</b> and <b>'.$d.'</b> are not allowed'; break 2;
                            }
                        }                            
                    }
                }
            }
            
            
            if ($msg == '' &&  $e < $iMinItemCount)
            {
                $err_num = 2;
                $msg = 'Selected subjects must be <b>equal to or greater than</b> minimum number of qualification subject';
            }
        
            if ($msg == '' && !isset($_REQUEST['as']) && (isset($_REQUEST['iQSLCount']) && $fnd_f9 == '0' && $_REQUEST["pl"] == '1'))
            {
                $err_num = 2;
                $msg = 'Since this criterion is for pre-degree admission, one or more of the subject grades must be F9';
            }
        }
        
        $recordsAffected = 0;
        if (($as == '1' || $es == '1') && $msg == '')
        {
            try
            {
                $mysqli->autocommit(FALSE); //turn on transactions

                if ($es == '1')
                {
                    $cProgrammeId_loc = "%".$_REQUEST['cProgrammeId']."%";

                    if ($cEduCtgId_2 == '')
                    {
                        $stmt = $mysqli->prepare("SELECT DISTINCT sReqmtId FROM criteriasubject
                        WHERE cProgrammeId LIKE ? 
                        AND cEduCtgId = 'OL'");
                        $stmt->bind_param("s",$cProgrammeId_loc);
                        $stmt->execute();
                        $stmt->bind_result($sReqmtId_loc);
                        $stmt->fetch();
                        $stmt->close();
                        
                        $sReqmt_Id_loc = $sReqmtId_loc;
                        $cEduCtg_Id = 'OL';

                        $stmt = $mysqli->prepare("DELETE FROM criteriasubject
                        WHERE cProgrammeId LIKE ? 
                        AND cEduCtgId = 'OL'");
                        $stmt->bind_param("s",$cProgrammeId_loc);
                        $stmt->execute();
                        $stmt->close();
                    }else
                    {
                        $stmt = $mysqli->prepare("DELETE FROM criteriasubject
                        WHERE cProgrammeId LIKE ? 
                        AND sReqmtId = ?");
                        $stmt->bind_param("si",$cProgrammeId_loc, $sReqmtId);
                        $stmt->execute();
                        $stmt->close();
                        
                        $sReqmt_Id_loc = $sReqmtId;
                        $cEduCtg_Id = $cEduCtgId_2;
                    }
                }else
                {
                    if ($cEduCtgId_2 == '')
                    {
                        $cProgrammeId_loc = "%".$_REQUEST['cProgrammeId']."%";

                        $stmt = $mysqli->prepare("SELECT DISTINCT sReqmtId FROM criteriasubject
                        WHERE cProgrammeId LIKE ? 
                        AND cEduCtgId = 'OL'");
                        $stmt->bind_param("s",$cProgrammeId_loc);
                        $stmt->execute();
                        $stmt->bind_result($sReqmtId_loc);
                        $stmt->fetch();
                        $stmt->close();
                        
                        $sReqmt_Id_loc = $sReqmtId_loc;
                        $cEduCtg_Id = 'OL';
                    }else
                    {
                        $sReqmt_Id_loc = $sReqmtId;
                        $cEduCtg_Id = $cEduCtgId_2;
                    }
                }

                $stmt = $mysqli->prepare("REPLACE INTO criteriasubject SET
                cCriteriaId = ?,
                sReqmtId = ?,
                cProgrammeId = ?,
                cEduCtgId = ?,
                cQualSubjectId = ?,
                mutual_ex = '0',
                cQualGradeId = ?,
                iQualGradeRank = ?,
                cMandate = ?");
                
                for ($c = $number1; $c <= $number2; $c++)
                {
                    if (isset($_REQUEST["cQualSubjectId$c"]) && $_REQUEST["cQualSubjectId$c"] <> '')
                    {
                        $cQualGradeId_loc = substr($_REQUEST["cQualGradeId$c"],0,3);

                        $iQualGradeRank_loc = substr($_REQUEST["cQualGradeId$c"],4,1);

                        $stmt->bind_param("sissssis", $_REQUEST["cFacultyId"], $sReqmt_Id_loc, $_REQUEST['cProgrammeId'], $cEduCtg_Id, $_REQUEST["cQualSubjectId$c"], $cQualGradeId_loc, $iQualGradeRank_loc, $_REQUEST["cMandate$c"]);

                        $stmt->execute();

                        $recordsAffected += $c;

                        if ($es == '1')
                        {
                            log_actv('Edited qualification subjects for '.$_REQUEST['cProgrammeId'].' in '.$_REQUEST["cFacultyId"]);
                        }else if ($as == '1')
                        {
                            log_actv('Added qualification subjects for '.$_REQUEST['cProgrammeId'].' in '.$_REQUEST["cFacultyId"]);
                        }
                    }
                }
                $stmt->close();
            
                $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
            }catch(Exception $e) 
            {
                $mysqli->rollback(); //remove all queries from queue if error (undo)
                throw $e;
            }
        }
    }
    
    if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1' && $msg == '')
    {
        $cProgrammeId_loc = "%".$_REQUEST['cProgrammeId']."%";
        
        try
        {
            $mysqli->autocommit(FALSE); //turn on transactions
                
            if (isset($_REQUEST['das']) && $_REQUEST['das'] == '1')
            {
                if ($iBeginLevel == 100 || ($_REQUEST['cFacultyId'] == 'HSC' && $iBeginLevel == 200))
                {                    
                    $stmt = $mysqli->prepare("DELETE FROM criteriasubject
                    WHERE cProgrammeId LIKE ? 
                    AND sReqmtId LIKE ?
                    AND cEduCtgId = 'OL'");
                    $stmt->bind_param("si", $cProgrammeId_loc, $sReqmtId);
                    $stmt->execute();
                    $stmt->close();
                }else
                {
                    $stmt = $mysqli->prepare("DELETE FROM criteriasubject
                    WHERE cProgrammeId LIKE ? 
                    AND sReqmtId = ? 
                    AND cEduCtgId = ?");
                    $stmt->bind_param("sis", $cProgrammeId_loc, $sReqmtId, $cEduCtgId_2);
                    $stmt->execute();
                    $stmt->close();
                }

                log_actv('Deleted all qualification subjects for '.$_REQUEST["cFacultyId"].' '.$_REQUEST['cEduCtgId'].' '.$sReqmtId);

                $msg = 'All subjects successfully deleted';
            }

            if (isset($_REQUEST['ds']) && $_REQUEST['ds'] == '1')
            {
                if ($iBeginLevel == 100 || ($_REQUEST['cFacultyId'] == 'HSC' && $iBeginLevel == 200))
                {
                    $stmt = $mysqli->prepare("DELETE FROM criteriasubject
                    WHERE cProgrammeId LIKE ?
                    AND sReqmtId = ?
                    AND cQualSubjectId = ?
                    AND cEduCtgId = 'OL'");
                    $stmt->bind_param("sis", $cProgrammeId_loc, $sReqmtId, $_REQUEST['cQualSubjectId']);
                    $stmt->execute();
                    $stmt->close();
                }else
                {
                    $stmt = $mysqli->prepare("DELETE FROM criteriasubject
                    WHERE cProgrammeId LIKE ? 
                    AND sReqmtId LIKE ?
                    AND cQualSubjectId = ?
                    AND cEduCtgId = ?");
                    $stmt->bind_param("siss", $cProgrammeId_loc, $sReqmtId, $_REQUEST['cQualSubjectId'], $cEduCtgId_2);
                    $stmt->execute();
                    $stmt->close();
                }
                
                log_actv('Deleted qualification subject '.$_REQUEST['cQualSubjectId'].' for '.$_REQUEST['cFacultyId'].' '.$_REQUEST['sReqmtId'].' '.$_REQUEST['criteriaqualId']);

                $msg = 'Subject successfully deleted';
            }
        
            $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
        }catch(Exception $e) 
        {
            $mysqli->rollback(); //remove all queries from queue if error (undo)
            throw $e;
        }
    }    
    admin_frms();?>
	
	<form action="staff_home_page" method="post" name="nxt" id="nxt" enctype="multipart/form-data">
		<input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST['vApplicationNo'])){echo $_REQUEST['vApplicationNo'];} ?>" />
        <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" />
		<input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST['vMatricNo'])){echo $_REQUEST['vMatricNo']; }?>" />
		<input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
		<input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
		<input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
		
        <input name="mm" id="mm" type="hidden" value="<?php if (isset($_REQUEST["mm"])){echo $_REQUEST["mm"];} ?>" />
        <input name="mm_desc" id="mm_desc" type="hidden" value="<?php if (isset($_REQUEST["mm_desc"])){echo $_REQUEST["mm_desc"];} ?>" />
        <input name="sm" id="sm" type="hidden" />
        <input name="sm_desc" id="sm_desc" type="hidden" />

		<!--<input name="study_mode" id="study_mode" type="hidden" value="odl" />

		<input name="study_mode_ID" id="study_mode_ID" type="hidden" value="odl" />-->		

		<input name="service_mode" id="service_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_mode" id="num_of_mode" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
		else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

		<input name="user_centre" id="user_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
		else if (isset($study_mode)){echo $study_mode;}?>" />
		<input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
		value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
		else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" />
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
	time_out_box($currency);
    
    if ($msg <> '' && $currency == '1')
    {
        if (!is_bool(strpos($msg, 'successfully')))
        {
            success_box($msg);
        }else
        {
            caution_box($msg);
        }
    }?>
    
    <div id="smke_screen_2" class="smoke_scrn" style="display:none"></div>
    
    <div id="status_info_box" class="center" style="display:none; 
        width:370px; 
        text-align:center; 
        padding:10px; 
        box-shadow: 2px 2px 8px 2px #726e41; 
        background:#FFFFFF; 
        z-index:-1">
        <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
            Status
        </div>
        <a href="#" style="text-decoration:none;">
            <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
        </a>
        <div id="msg_msg_status_info" style="line-height:1.6; margin-top:10px; margin-bottom:10px; width:370px; float:left; text-align:center; padding:0px;"></div>
    </div>
    
    <div id="info_box_green" class="center" style="display:none; 
        width:370px; 
        text-align:center; 
        padding:10px; 
        box-shadow: 2px 2px 8px 2px #726e41; 
        background:#FFFFFF;  
        z-index:3">
        <div style="width:350px; float:left; text-align:left; padding:0px; color:#36743e; font-weight:bold">
            Information
        </div>
        <a href="#" style="text-decoration:none;">
            <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
        </a>
        <div id="msg_msg_info_green" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;"></div>

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
    </div>
    
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
				onclick="e_qual_sbj.conf.value='1';
                _('conf_box_loc').style.display='none';
                e_qual_sbj.submit();
				return false">
				<div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
					Yes
				</div>
			</a>

			<a href="#" style="text-decoration:none;" 
				onclick="e_qual_sbj.ac.value='';
                e_qual_sbj.ec.value='';
                e_qual_sbj.dc.value='';												
                e_qual_sbj.aq.value='';
                e_qual_sbj.eq.value='';
                e_qual_sbj.dq.value='';												
                e_qual_sbj.as.value='';
                e_qual_sbj.es.value='';
                e_qual_sbj.ds.value='';
                e_qual_sbj.das.value='';												
                e_qual_sbj.en.value='';
                e_qual_sbj.dis.value='';
                e_qual_sbj.admt.value='';
                e_qual_sbj.conf.value='';
                e_qual_sbj.sbjlist.value='';
                
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
    
    <div id="conf_warn_loc" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:3">
		<div id="msg_title" style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
			Caution
		</div>
		<a href="#" style="text-decoration:none;">
			<div id="msg_title_loc" style="width:20px; float:left; text-align:center; padding:0px;"></div>
		</a>
		<div id="msg_msg_loc" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px;">
			<?php echo $msg;?>
		</div>
		<div id="msg_title_loc" style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
			<a href="#" style="text-decoration:none;" 
				onclick="_('conf_warn_loc').style.display= 'none';
				_('conf_warn_loc').style.zIndex= '-1';
				_('smke_screen_2').style.display= 'none';
				_('smke_screen_2').style.zIndex= '-1';
				return false">
				<div class="submit_button_green" style="width:60px; padding:6px; float:right">
					Ok
				</div>
			</a>
		</div>
	</div>

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
            {
                if ($cFacultyId_u <> $_REQUEST["cFacultyId"] && $sRoleID_u <> '6')
                {
                    $msg_01 = 'You cannot ';
                    if($as == '1' || $ac == '1')
                    {
                        $msg_01 .= ' create ';
                    }else if($ec == '1' || $es == '1')
                    {
                        $msg_01 .= ' edit ';
                    }else 
                    {
                        $msg_01 .= ' create/edit ';
                    }
                    $msg_01 .= ' admission criteria in the selected faculty ';
                    caution_box($msg_01);
                    $allowed = '0';
                }else if ($sRoleID_u <> '6' && $_REQUEST['cdept'] <> $cdeptId_u && ($ec == '1' || $eq == '1' || $es == '1'))
                {
                    $msg_01 = 'You cannot ';
                    if($as == '1' || $ac == '1')
                    {
                        $msg_01 .= ' create ';
                    }else if($ec == '1' || $es == '1')
                    {
                        $msg_01 .= ' edit ';
                    }
                    $msg_01 .= ' admission criteria in the selected faculty ';
                    caution_box($msg_01);
                    $allowed = '0';
                }else
                {
                    nav_frm();?>
                    
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
                        pgprgs1.cFacultyId.value='<?php echo $_REQUEST['cFacultyId'] ?>';
                        pgprgs1.cdept.value='<?php echo $_REQUEST['cdept'] ?>';
                    	pgprgs1.cProgrammeId.value='<?php echo $_REQUEST['cProgrammeId'] ?>';
                        pgprgs1.submit()"><?php nav_text($sm);?></a> :: 
                        <a href="#"style="text-decoration:none; color:#4ab963" 
                            onclick="
                            e_crit1.ac.value='';
                            e_crit1.ec.value='';
                            e_crit1.dc.value='';												
                            e_crit1.aq.value='';
                            e_crit1.eq.value='';
                            e_crit1.dq.value='';												
                            e_crit1.as.value='';
                            e_crit1.es.value='';
                            e_crit1.ds.value='';
                            e_crit1.das.value='';												
                            e_crit1.en.value='';
                            e_crit1.dis.value='';
                            e_crit1.admt.value='';
                            e_crit1.conf.value='';
                            e_crit1.sbjlist.value='';

                            e_crit1.cFacultyId.value='<?php if (isset($_REQUEST['cFacultyId'])){echo $_REQUEST['cFacultyId'];} ?>';
                            e_crit1.cdept.value='<?php if (isset($_REQUEST['cdept'])){echo $_REQUEST['cdept'];} ?>';
                            e_crit1.cProgrammeId.value='<?php if (isset($_REQUEST['cProgrammeId'])){echo $_REQUEST['cProgrammeId'];} ?>';

                            e_crit1.vFacultyDesc.value='<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>';
                            e_crit1.vdeptDesc.value='<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>';
                            e_crit1.vObtQualTitle.value='<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>';
                            e_crit1.cEduCtgId.value='<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>';
                            e_crit1.vProgrammeDesc.value='<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>';
						
                            e_crit1.cEduCtgId_1.value='<?php echo $cEduCtgId_1;?>';                                            
                            e_crit1.cEduCtgId_2.value='<?php echo $cEduCtgId_2;?>';
                            e_crit1.vReqmtDesc.value='<?php echo addslashes($vReqmtDesc); ?>';

                            e_crit1.submit()">List of criteria</a> ::
                            <?php if ($as == '1') {echo ' :: Add subject';}elseif ($es == '1') {echo ' :: Edit subject list';}else{echo ' :: Subject list';}?>
                    </div>

                    <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID; ?>" />

                    <div class="innercont_stff" style="color:#FF3300;">
                        <?php echo 'Faculty of '.$_REQUEST['vFacultyDesc'].' :: Department of '.$_REQUEST['vdeptDesc'].' :: '.$_REQUEST['vObtQualTitle'].' '.$_REQUEST['vProgrammeDesc']; ?>
                    </div>

                    <div class="innercont_stff" style="margin-top:0px;">
                        <div class="_label" style="border:0px; width:auto;">
                            Description
                        </div>
                        <div class="_value" style="width:30%; border:0px;">
                            <?php echo $vReqmtDesc;?>
                        </div>
                        
                        <div class="_value" style="width:auto; border:0px; text-align:left; float:right;">
                            <?php echo $iBeginLevel;?>
                        </div>
                        <div class="_label" style="border:0px; width:auto; float:right;">
                            Entry level
                        </div>
                    </div>
                    <div class="innercont_stff" style="margin-top:0px;">                        
                        <div class="_label" style="border:0px; width:auto;">
                            Qualification
                        </div>
                        <div class="_value" style="width:30%; border:0px;">
                            <?php echo $vQualCodeDesc;?>
                        </div>
                        
                        <div class="_label" style="border:0px; width:auto">
                            Max. no. of sitting
                        </div>
                        <div class="_value" style="width:30%; border:0px;"><?php
                            $vQualCodeDesc = $vQualCodeDesc ?? '';
                            if (!is_bool(strpos($vQualCodeDesc,"Olevel")))
                            {
                                echo '2';
                            }else
                            {
                                echo '1';   
                            }?>
                        </div>
                        
                        <div class="_value" style="width:auto; border:0px; float:right"><?php
                            //$cEduCtgId = $cEduCtgId ?? '';
                            if (!is_bool(strpos($_REQUEST['cEduCtgId'],"OL")))
                            {
                                echo '5';
                            }else if ($_REQUEST['cdept'] == 'ESC')
                            {
                                echo '3';
                            }else if (!is_bool(strpos($_REQUEST['cEduCtgId'],'AL')))
                            {
                                echo '2';
                            }else
                            {
                                echo '1';   
                            }?>
                        </div>
                        <div class="_label" style="border:0px; width:auto; float:right">
                            Min. no. of subject
                        </div>
                    </div><?php
                    
                    if (isset($_REQUEST['save']) && $_REQUEST['save'] == '1' && $msg == '' && $recordsAffected > 0)
                    {
                        if ($es == '1')
                        {
                            success_box('Record successfully eidted');
                        }else if ($ds == '1')
                        {
                            success_box('Record(s) successfully deleted');
                        }else if ($as == '1')
                        {
                            success_box('Record(s) successfully saved');
                        }                        
                    }else if (isset($_REQUEST['save']) && $_REQUEST['save'] == '1' && $msg == '' && $recordsAffected == 0)
                    {
                        if ($es == '1')
                        {
                            information_box('No record eidted');
                        }else if ($ds == '1')
                        {
                            information_box('No record deleted');
                        }else if ($as == '1')
                        {
                            information_box('No record saved');
                        }				
                    }?>
                    
                    <div class="innercont_stff" style="float:left; width:99.8%; margin-top:0px; font-weight:bold;">
                        <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; padding-right:3px; text-align:right; width:5%">Sno</div>
                        
                        <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; width:54.9%; text-align:left; text-indent:4px">Subject</div>
                        
                        <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; width:8.1%; text-indent:4px;">Min. Grade</div>
                        
                        <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:left; width:8.2%; text-indent:4px;">
                            Mandate
                        </div><?php
                        if ($NoOfsbjEntered > 0 || (isset($_REQUEST['save']) && $_REQUEST['save'] == '1' && $msg == ''))
                        {
                            if ($crit_used <> '0' && $vRoleName <> 'Root')
                            {?>
                                <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:19.9%; padding-right:3px;"></div><?php
                            }else if ($sm == '2')
                            {?>
                                <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:19.9%; padding-right:3px;"><?php 
                                    if ($NoOfsbjEntered > 0)
                                    {
                                        if ($_REQUEST['cFacultyId'] == $cFacultyId_u && $_REQUEST['cdept'] == $cdeptId_u || $sRoleID_u == '6')
                                        {
                                            if ($iBeginLevel > 100 && $cEduCtgId_2 == '')
                                            {?>
                                                <img src="img/edit_dull.gif" style="cursor:not-allowed" title="Go to the corresponding 100L criterion to edit this qualification" hspace="0" vspace="0" border="0"/><?php
                                            }else if ($_REQUEST['es'] == '1' || ((isset($_REQUEST['as'])&&$_REQUEST['as']=='1')||(isset($_REQUEST['vQualCodeDesc'])&&$_REQUEST['vQualCodeDesc']=='Olevel'&&isset($_REQUEST['vReqmtDesc'])&&$_REQUEST['vReqmtDesc']<>'O Level' && $iBeginLevel <> 100)))
                                            {?>
                                                    <img src="img/edit_dull.gif" style="cursor:not-allowed" title="You are already in the edit mode or function not applicable here" hspace="0" vspace="0" border="0"/><?php
                                            }else 
                                            {?>
                                                <a href="#"target="_self" style="text-decoration:none" onclick="
                                                    e_qual_sbj.ac.value='';
                                                    e_qual_sbj.ec.value='';
                                                    e_qual_sbj.dc.value='';												
                                                    e_qual_sbj.aq.value='';
                                                    e_qual_sbj.eq.value='';
                                                    e_qual_sbj.dq.value='';												
                                                    e_qual_sbj.as.value='';
                                                    e_qual_sbj.es.value='1';
                                                    e_qual_sbj.ds.value='';
                                                    e_qual_sbj.das.value='';												
                                                    e_qual_sbj.en.value='';
                                                    e_qual_sbj.dis.value='';
                                                    e_qual_sbj.admt.value='';
                                                    e_qual_sbj.conf.value='';
                                                    e_qual_sbj.sbjlist.value='';
                                                    e_qual_sbj.iQSLCount.value='<?php echo $iQSLCount; ?>';
                                                    e_qual_sbj.cEduCtgId_1.value='OL';
                                                    e_qual_sbj.cEduCtgId_2.value='<?php echo $cEduCtgId_2; ?>';
                                                    
                                                    e_qual_sbj.cFacultyId.value='<?php if (isset($_REQUEST['cFacultyId'])){echo $_REQUEST['cFacultyId'];} ?>';
                                                    e_qual_sbj.cdept.value='<?php if (isset($_REQUEST['cdept'])){echo $_REQUEST['cdept'];} ?>';
                                                    e_qual_sbj.cProgrammeId.value='<?php if (isset($_REQUEST['cProgrammeId'])){echo $_REQUEST['cProgrammeId'];} ?>';

                                                    e_qual_sbj.vFacultyDesc.value='<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>';
                                                    e_qual_sbj.vdeptDesc.value='<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>';
                                                    e_qual_sbj.vObtQualTitle.value='<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>';
                                                    e_qual_sbj.cEduCtgId.value='<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>';
                                                    e_qual_sbj.vProgrammeDesc.value='<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>';

                                                    e_qual_sbj.vReqmtDesc.value='<?php echo addslashes($vReqmtDesc); ?>';
                                                    e_qual_sbj.sReqmtId.value='<?php echo $sReqmtId; ?>';

                                                    e_qual_sbj.submit()">
                                                    <img src="img/edit.gif" title="Click to edit qualification subjects" border="0" />
                                                </a><?php
                                            }
                                        }else 
                                        {?>
                                            <a href="#"target="_self" style="text-decoration:none; cursor:default" onclick="return false">
                                                <img src="img/edit_dull.gif" 
                                                    title="<?php if ($_REQUEST['cFacultyId'] <> $cFacultyId_u && $sRoleID_u <> 6)
                                                    {
                                                        echo "You cannot edit qualification subject in the selected faculty";
                                                    }else if ($_REQUEST['cdept'] <> $cdeptId_u && $sRoleID_u <> '6')
                                                    {
                                                        echo "You cannot edit qualification subject in the selected department";
                                                    }?>" border="0" />
                                            </a><?php
                                        }
                                    }?>
                                </div><?php
                            }
                        }else
                        {?>
                            <!--<div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:19.9%; padding-right:3px;"></div>--><?php
                        }
                        
                        if ($crit_used <> '0' && $vRoleName <> 'Root')
                        {?>
                            <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:19.8%; padding-right:3px;"></div><?php
                        }else if ($sm == '1')
                        {?>
                            <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:19.9%; padding-right:3px;"><?php
                                if (isset($_REQUEST['used_admitted']) && $_REQUEST['used_admitted'] > 0)
                                {?>
                                    <a id="add1" href="#" target="_self" style="text-decoration:none; cursor:not-allowed;"
                                        onclick="return false">
                                        <img src="img/add_dull.gif" 
                                        title="Criterion already used, cannot be modified" border="0"  />
                                    </a><?php
                                }else if (($_REQUEST['cFacultyId']== $cFacultyId_u && $_REQUEST['cdept'] == $cdeptId_u) || $sRoleID_u == '6')
                                {?>
                                    <a id="add0" href="#" target="_self" style="text-decoration:none; 
                                        display:<?php if ((isset($_REQUEST['as'])&&$_REQUEST['as']=='1')||(isset($_REQUEST['vQualCodeDesc'])&&$_REQUEST['vQualCodeDesc']=='Olevel'&&isset($_REQUEST['vReqmtDesc'])&&$_REQUEST['vReqmtDesc']<>'O Level')){?>none<?php }else{?>block<?php } ?>" 
                                        onclick="e_qual_sbj.ac.value='';
                                        e_qual_sbj.ec.value='';
                                        e_qual_sbj.dc.value='';												
                                        e_qual_sbj.aq.value='';
                                        e_qual_sbj.eq.value='';
                                        e_qual_sbj.dq.value='';												
                                        e_qual_sbj.as.value='1';
                                        e_qual_sbj.es.value='';
                                        e_qual_sbj.ds.value='';
                                        e_qual_sbj.das.value='';												
                                        e_qual_sbj.en.value='';
                                        e_qual_sbj.dis.value='';
                                        e_qual_sbj.admt.value='';
                                        e_qual_sbj.conf.value='';
                                        e_qual_sbj.sbjlist.value='';
                                        e_qual_sbj.save.value='';
                                        
                                        e_qual_sbj.cFacultyId.value='<?php if (isset($_REQUEST['cFacultyId'])){echo $_REQUEST['cFacultyId'];} ?>';
                                        e_qual_sbj.cdept.value='<?php if (isset($_REQUEST['cdept'])){echo $_REQUEST['cdept'];} ?>';
                                        e_qual_sbj.cProgrammeId.value='<?php if (isset($_REQUEST['cProgrammeId'])){echo $_REQUEST['cProgrammeId'];} ?>';

                                        e_qual_sbj.vFacultyDesc.value='<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>';
                                        e_qual_sbj.vdeptDesc.value='<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>';
                                        e_qual_sbj.vObtQualTitle.value='<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>';
                                        e_qual_sbj.cEduCtgId.value='<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>';
                                        e_qual_sbj.vProgrammeDesc.value='<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>';

                                        e_qual_sbj.vReqmtDesc.value='<?php echo addslashes($vReqmtDesc); ?>';
                                        e_qual_sbj.sReqmtId.value='<?php echo $sReqmtId; ?>';

                                        e_qual_sbj.criteriaqualId.value='<?php echo $_REQUEST['criteriaqualId'];?>';
                                        e_qual_sbj.submit()">
                                        <img src="img/add.gif" title="Click to add entry qualification subjects" border="0" />
                                    </a>
                                    <a id="add1" href="#" target="_self" style="text-decoration:none; cursor:not-allowed;
                                        display:<?php if ((isset($_REQUEST['as'])&&$_REQUEST['as']=='1')||(isset($_REQUEST['vQualCodeDesc'])&&$_REQUEST['vQualCodeDesc']=='Olevel'&&isset($_REQUEST['vReqmtDesc'])&&$_REQUEST['vReqmtDesc']<>'O Level')){?>block<?php }else{?>none<?php }?>" 
                                        onclick="return false">
                                        <img src="img/add_dull.gif" 
                                        title="Link already clicked or not applicaible." border="0"  />
                                    </a><?php
                                }else if ($_REQUEST['cFacultyId']<> $cFacultyId_u && $sRoleID_u <> '6')
                                {?>
                                    <a href="#"target="_self" style="text-decoration:none;; cursor:default" 
                                        onclick="return false">
                                        <img src="img/add_dull.gif" 
                                        title="You cannot add entry qualification subjects in the selected faculty" border="0"  />
                                    </a><?php
                                }else if ($_REQUEST['cdept']<> $cdeptId_u && $sRoleID_u <> '6')
                                {?>
                                    <a href="#"target="_self" style="text-decoration:none; cursor:default" 
                                        onclick="return false">
                                        <img src="img/add_dull.gif" 
                                        title="You cannot add entry qualification subjects in the selected department" border="0"  />
                                    </a><?php
                                }?>
                            </div><?php
                        }else if ($sm == '5')
                        {
                            if ($iBeginLevel > 100 && $cEduCtgId_2 == '')
                            {?>
                                <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:8px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:19.9%; padding-right:3px;">
                                    <img src="img/delete_d.gif" style="cursor:not-allowed" title="Go to the corresponding 100L criterion to delete these subjects" hspace="0" vspace="0" border="0"/>
                                </div><?php
                            }else if ($NoOfsbjEntered > 0)
                            {?>
                                <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:auto; padding-top:9px; padding-bottom:8px; background-color:#E3EBE2; margin-left:-1px; text-align:right; width:19.9%; padding-right:3px;">
                                    <a href="#" onclick="
                                        e_qual_sbj.ac.value='';
                                        e_qual_sbj.ec.value='';
                                        e_qual_sbj.dc.value='';												
                                        e_qual_sbj.aq.value='';
                                        e_qual_sbj.eq.value='';
                                        e_qual_sbj.dq.value='';												
                                        e_qual_sbj.as.value='';
                                        e_qual_sbj.es.value='';
                                        e_qual_sbj.ds.value='';
                                        e_qual_sbj.das.value='1';												
                                        e_qual_sbj.en.value='';
                                        e_qual_sbj.dis.value='';
                                        e_qual_sbj.admt.value='';
                                        e_qual_sbj.conf.value='';
                                        e_qual_sbj.sbjlist.value='1';
                                        e_qual_sbj.save.value='';
                                        
                                        e_qual_sbj.cFacultyId.value='<?php if (isset($_REQUEST['cFacultyId'])){echo $_REQUEST['cFacultyId'];} ?>';
                                        e_qual_sbj.cdept.value='<?php if (isset($_REQUEST['cdept'])){echo $_REQUEST['cdept'];} ?>';
                                        e_qual_sbj.cProgrammeId.value='<?php if (isset($_REQUEST['cProgrammeId'])){echo $_REQUEST['cProgrammeId'];} ?>';

                                        e_qual_sbj.vFacultyDesc.value='<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>';
                                        e_qual_sbj.vdeptDesc.value='<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>';
                                        e_qual_sbj.vObtQualTitle.value='<?php if (isset($_REQUEST['vObtQualTitle'])){echo $_REQUEST['vObtQualTitle'];} ?>';
                                        e_qual_sbj.cEduCtgId.value='<?php if (isset($_REQUEST['cEduCtgId'])){echo $_REQUEST['cEduCtgId'];}?>';
                                        e_qual_sbj.vProgrammeDesc.value='<?php if (isset($_REQUEST['vProgrammeDesc'])){echo $_REQUEST['vProgrammeDesc'];} ?>';
                            
                                        e_qual_sbj.cEduCtgId_1.value='OL';                                            
                                        e_qual_sbj.cEduCtgId_2.value='<?php echo $cEduCtgId_2;?>';                                        
                                        e_qual_sbj.vReqmtDesc.value='<?php echo addslashes($vReqmtDesc); ?>';
                                        e_qual_sbj.sReqmtId.value='<?php echo $sReqmtId ?>';
                                        
                                        e_qual_sbj.criteriaqualId.value='<?php echo $_REQUEST['criteriaqualId']; ?>';
                                        e_qual_sbj.subjectno.value='';
                                        _('conf_msg_msg_loc').innerHTML = _('progs_affected').value+'Are you sure you want to delete all subjects ?';
                                        _('conf_box_loc').style.display='block';
                                        _('conf_box_loc').style.zIndex='3';
                                        _('smke_screen_2').style.display='block';
                                        _('smke_screen_2').style.zIndex='2';" style="text-decoration: none">
                                        <img src="img/delall.gif" title="Delete all subjects" height="15px" width="36px" hspace="0" vspace="0" border="0" /></a>
                                </div><?php
                            }
                        }?>
                    </div><?php

                    $stmt = $mysqli->prepare("SELECT DISTINCT b.vQualSubjectDesc, a.cQualSubjectId, a.cMandate, a.mutual_ex, c.cQualGradeCode, c.cQualGradeId, c.iQualGradeRank
                    FROM criteriasubject a, qualsubject b, qualgrade c
                    WHERE a.cQualSubjectId = b.cQualSubjectId 
                    AND a.cQualGradeId = c.cQualGradeId
                    $sReqmtId_qry
                    $child_qry
                    $cEduCtgId_qry
                    ORDER BY a.cMandate, b.vQualSubjectDesc");

                    /*echo "SELECT DISTINCT b.vQualSubjectDesc, a.cQualSubjectId, a.cMandate, a.mutual_ex, c.cQualGradeCode, c.cQualGradeId, c.iQualGradeRank
                    FROM criteriasubject a, qualsubject b, qualgrade c
                    WHERE a.cQualSubjectId = b.cQualSubjectId 
                    AND a.cQualGradeId = c.cQualGradeId
                    $sReqmtId_qry
                    $child_qry
                    $cEduCtgId_qry
                    ORDER BY a.cMandate, b.vQualSubjectDesc";*/
                    
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($vQualSubjectDesc, $cQualSubjectId, $cMandate, $mutual_ex, $cQualGradeCode, $cQualGradeId, $iQualGradeRank);
                    $number_of_entry = $stmt->num_rows;
                    
                    $where = '';
                    $sql = "SELECT cQualSubjectId, vQualSubjectDesc FROM qualsubject ";

                    if ($es == '')
                    { 
                        $where = " cQualSubjectId 
                        not in (select cQualSubjectId from criteriasubject 
                        where cProgrammeId = ? and sReqmtId = ? and cEduCtgId = ?)";
                    }
                                        
                    if ($where <> ''){$where = "where $where";}
                    
                    $sql .= " $where order by vQualSubjectDesc";
                    $last_var = $_REQUEST['criteriaqualId'];
                    
                    $stmt_lst = $mysqli->prepare($sql);
                    if ($es == '')
                    {
                        $stmt_lst->bind_param("sis", $_REQUEST['cProgrammeId'], $sReqmtId, $_REQUEST['cEduCtgId']);
                    }
                    $stmt_lst->execute();
                    $stmt_lst->store_result();
                    $stmt_lst->bind_result($cQualSubjectId, $vQualSubjectDesc);
                    
                   
                    if ($cEduCtgId_2 == '')
                    {
                        $stmt_lst1 = $mysqli->prepare("SELECT concat(cQualGradeId,' ',iQualGradeRank) cQualGradeId, cQualGradeCode
                        FROM qualgrade WHERE cEduCtgId = 'OLX' AND cDelFlag = 'N' ORDER BY iQualGradeRank DESC");
                    }else
                    {
                        $stmt_lst1 = $mysqli->prepare("SELECT concat(cQualGradeId,' ',iQualGradeRank) cQualGradeId, cQualGradeCode
                        FROM qualgrade WHERE cEduCtgId = ? AND cDelFlag = 'N' ORDER BY iQualGradeRank DESC");
                        $stmt_lst1->bind_param("s", $cEduCtgId_2);
                    }
                   
                    $stmt_lst1->execute();
                    $stmt_lst1->store_result();
                    $stmt_lst1->bind_result($cQualGradeId, $cQualGradeCode);
                    
                    $cnt = 0;?>
                    <div class="innercont_stff" style="height:69%; margin-top:3px; overflow:scroll; overflow-x: hidden;">
                        <form method="post" name="e_qual_sbj" enctype="multipart/form-data">
                            <input name="vApplicationNo" type="hidden" value="<?php echo $GLOBALS['vApplicationNo']; ?>" />
                            <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($GLOBALS['user_cat'])){echo $GLOBALS['user_cat'];} ?>" />
                            <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($GLOBALS['ilin'])){echo $GLOBALS['ilin'];} ?>" />
                            <input name="tDeedTime" type="hidden" value="<?php if (isset($GLOBALS['tDeedTime'])){echo $GLOBALS['tDeedTime'];}?>" />
                            <input name="cFacultyId" id="cFacultyId" type="hidden" value="<?php if (isset($_REQUEST['cFacultyId'])){echo $_REQUEST['cFacultyId'];} ?>" />
                            <input name="cdept" id="cdept" type="hidden" value="<?php if (isset($_REQUEST['cdept'])){echo $_REQUEST['cdept'];} ?>" />
                            <input name="vFacultyDesc" id="vFacultyDesc" type="hidden" value="<?php if (isset($_REQUEST['vFacultyDesc'])){echo $_REQUEST['vFacultyDesc'];} ?>" />
                            <input name="vdeptDesc" id="vdeptDesc" type="hidden" value="<?php if (isset($_REQUEST['vdeptDesc'])){echo $_REQUEST['vdeptDesc'];} ?>" />
                            <input name="vObtQualTitle" id="vObtQualTitle" type="hidden" value="<?php if (isset($GLOBALS['vObtQualTitle'])){echo $GLOBALS['vObtQualTitle'];} ?>" />
                            
                            <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($GLOBALS['cEduCtgId'])){echo $GLOBALS['cEduCtgId'];} ?>" />
                            <input name="vEduCtgDesc" id="vEduCtgDesc" type="hidden" value="<?php if (isset($GLOBALS['vEduCtgDesc'])){echo $GLOBALS['vEduCtgDesc'];} ?>" />
                            
                            <input name="cEduCtgId_1" id="cEduCtgId_1" type="hidden" value="<?php if (isset($GLOBALS['cEduCtgId_1'])){echo $GLOBALS['cEduCtgId_1'];} ?>" />
                            <input name="cEduCtgId_2" id="cEduCtgId_2" type="hidden" value="<?php if (isset($GLOBALS['cEduCtgId_2'])){echo $GLOBALS['cEduCtgId_2'];} ?>" />
                            
                            <input name="cEduCtgId_selected_qual" id="cEduCtgId_selected_qual" type="hidden" value="<?php if (isset($GLOBALS['cEduCtgId_selected_qual'])){echo $GLOBALS['cEduCtgId_selected_qual'];} ?>" />
                            
                            <input name="cQualCodeId" id="cQualCodeId" type="hidden" value="<?php if (isset($GLOBALS['cQualCodeId'])){echo $GLOBALS['cQualCodeId'];} ?>" />
                            <input name="vQualCodeDesc" id="vQualCodeDesc" type="hidden" value="<?php if (isset($GLOBALS['vQualCodeDesc'])){echo $GLOBALS['vQualCodeDesc'];} ?>" />
                            
                            <input name="prog_cat" id="prog_cat" type="hidden" value="<?php if (isset($GLOBALS['prog_cat'])){echo $GLOBALS['prog_cat'];} ?>" />
                            <input name="cProgrammeId" id="cProgrammeId" type="hidden" value="<?php if (isset($GLOBALS['cProgrammeId'])){echo $GLOBALS['cProgrammeId'];} ?>" />
                            <input name="vProgrammeDesc" type="hidden" value="<?php if (isset($GLOBALS['vProgrammeDesc'])){echo $GLOBALS['vProgrammeDesc'];} ?>" /><?php

                            $cProgrammeId_loc = "%".$_REQUEST['cProgrammeId']."%";
                            $sub_qry = "AND cEduCtgId = 'OL'";
                            if ($vQualCodeDesc <> 'Olevel')
                            {
                                $sub_qry = "AND cEduCtgId = '$cEduCtgId_2'";
                            }

                            $stmt_ds = $mysqli->prepare("SELECT cProgrammeId FROM criteriasubject
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
                            <input name="progs_affected" id="progs_affected" type="hidden" value="<?php if($progs_affected>0){echo $number_of_afected_programmes. ' other programmes will also be affected<br>';}?>"/>
                            
                            <input name="vReqmtDesc" id="vReqmtDesc" type="hidden" value="<?php if (isset($GLOBALS['vReqmtDesc'])){echo $GLOBALS['vReqmtDesc'];} ?>" />
                            <input name="sReqmtId" id="sReqmtId" type="hidden" value="<?php if (isset($GLOBALS['sReqmtId'])){echo $GLOBALS['sReqmtId'];} ?>" />
                            <input name="criteriaqualId" id="criteriaqualId" type="hidden" value="<?php if (isset($GLOBALS['criteriaqualId'])){echo $GLOBALS['criteriaqualId'];}?>" />
                                
                            <input name="iBeginLevel" type="hidden" value="<?php if (isset($GLOBALS['iBeginLevel'])){echo $GLOBALS['iBeginLevel'];} ?>" />
                            
                            <input name="iMinItemCount" id="iMinItemCount" type="hidden" value="<?php if (isset($GLOBALS['iMinItemCount'])){echo $GLOBALS['iMinItemCount'];} ?>" />
                            <input name="iMaxSittingCount" id="iMaxSittingCount" type="hidden" value="<?php if (isset($GLOBALS['iMaxSittingCount'])){echo $GLOBALS['iMaxSittingCount'];} ?>" />
                            <input name="iQSLCount" id="iQSLCount" type="hidden" value="<?php if (isset($GLOBALS['iQSLCount'])){echo $GLOBALS['iQSLCount'];} ?>" />
                            
                            <input name="used_admitted" id="used_admitted" type="hidden" value="" />

                            <input name="clk" type="hidden" value="0" />
                            
                            <input name="es" id="es" type="hidden" value="<?php if (isset($GLOBALS['es'])){echo $GLOBALS['es'];} ?>" />
                            <input name="as" id="as" type="hidden" value="<?php if (isset($GLOBALS['as'])){echo $GLOBALS['as'];} ?>" />
                            <input name="ds" id="ds" type="hidden" value="<?php if (isset($GLOBALS['ds'])){echo $GLOBALS['ds'];} ?>" />
                            <input name="dc" id="dc" type="hidden" value="<?php if (isset($GLOBALS['dc'])){echo $GLOBALS['dc'];} ?>" />
                            <input name="das" id="das" type="hidden" value="<?php if (isset($GLOBALS['das'])){echo $GLOBALS['das'];} ?>" />
                            
                            <input name="ec" id="ec" type="hidden" value="<?php if (isset($GLOBALS['ec'])){echo $GLOBALS['ec'];} ?>" />
                            <input name="ac" id="ac" type="hidden" value="<?php if (isset($GLOBALS['ac'])){echo $GLOBALS['ac'];} ?>" />
                            
                            <input name="eq" id="eq" type="hidden" value="<?php if (isset($GLOBALS['eq'])){echo $GLOBALS['eq'];} ?>" />
                            <input name="aq" id="aq" type="hidden" value="<?php if (isset($GLOBALS['aq'])){echo $GLOBALS['aq'];} ?>" />
                            <input name="dq" id="dq" type="hidden" value="<?php if (isset($GLOBALS['dq'])){echo $GLOBALS['dq'];} ?>" />
                            
                            <input name="m" type="hidden" value="<?php if (isset($GLOBALS['m'])){echo $GLOBALS['m'];} ?>" />
                            <input name="sm" type="hidden" value="<?php if (isset($GLOBALS['sm'])){echo $GLOBALS['sm'];} ?>" />
                            <input name="mm" type="hidden" value="<?php if (isset($GLOBALS['mm'])){echo $GLOBALS['mm'];} ?>" />
                            
                            <input name="dis" type="hidden" value="<?php if (isset($GLOBALS['dis'])){echo $GLOBALS['dis'];} ?>" />
                            <input name="en" type="hidden" value="<?php if (isset($GLOBALS['en'])){echo $GLOBALS['en'];} ?>" />
                            
                            <input name="sbjlist" type="hidden" />
                            <input name="conf" id="conf" type="hidden" />
                            <input name="admt" id="admt" type="hidden" />
                            <input name="conf_g" id="conf_g" type="hidden" value="" />
                                
                            <!--<input name="study_mode_ID" id="study_mode_ID" type="hidden" value="<?php if (isset($_REQUEST["study_mode_ID"]) && $_REQUEST["study_mode_ID"] <> ''){echo $_REQUEST["study_mode_ID"];}?>" />-->

                            <input name="save" type="hidden" value="-1" />
                            <input name="currency" id="currency" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                            <input name="histgo" id="histgo" type="hidden" value="-1" />
                            <input name="cQualSubjectId" id="cQualSubjectId" type="hidden"/>
                            <input name="subjectno" id="subjectno" type="hidden" />
                            <input name="criteriaqualId" type="hidden" value="<?php echo $_REQUEST['criteriaqualId']; ?>" />
                            
                            <input name="userInfo_f" id="userInfo_f" type="hidden" value="<?php echo $_REQUEST['cFacultyId']?>" />
                            <input name="userInfo_d" id="userInfo_d" type="hidden" value="<?php echo $_REQUEST['cdept']?>" />

                            <!--<input name="study_mode" id="study_mode" type="hidden" value="<?php //if (isset($_REQUEST["study_mode"]) && $_REQUEST["study_mode"] <> ''){echo $_REQUEST["study_mode"];}else if ($num_of_mode <= 1){echo $study_mode;}?>" />-->

                            <input name="service_mode" id="service_mode" type="hidden" 
                            value="<?php if (isset($_REQUEST["service_mode"]) && $_REQUEST["service_mode"] <> ''){echo $_REQUEST["service_mode"];}
                            else if (isset($study_mode)){echo $study_mode;}?>" />
                            <input name="num_of_mode" id="num_of_mode" type="hidden" 
                            value="<?php if (isset($_REQUEST["num_of_mode"]) && $_REQUEST["num_of_mode"] <> ''){echo $_REQUEST["num_of_mode"];}
                            else if (isset($num_of_mode)){echo $num_of_mode;}?>" />

                            <input name="user_centre" id="user_centre" type="hidden" 
                            value="<?php if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> ''){echo $_REQUEST["user_centre"];}
                            else if (isset($study_mode)){echo $study_mode;}?>" />
                            <input name="num_of_service_centre" id="num_of_service_centre" type="hidden" 
                            value="<?php if (isset($_REQUEST["num_of_service_centre"]) && $_REQUEST["num_of_service_centre"] <> ''){echo $_REQUEST["num_of_service_centre"];}
                            else if (isset($num_of_service_centre)){echo $num_of_service_centre;}?>" /><?php

                            $prev_subject = '';
                            for ($c = 1; $c <= $NoOfsbjExpected; $c++)
                            {
                                if ($c%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}

                                if ($sbjlist == '1' || (($as == '1' && $c <= $stmt->num_rows) && ($es == '' || (isset($_REQUEST['save']) && $_REQUEST['save'] == '1' && $msg == ''))))
                                {
                                    if ($c > $number_of_entry && !(isset($_REQUEST['save'])&&$_REQUEST['save']=='1')){continue;}
                                    $stmt->fetch();
                                    if ($mutual_ex == 1){$text_color='#a87903';}else if ($mutual_ex == 2){$text_color='#0656b8';}else if ($mutual_ex == 3){$text_color='#05ad42';}else{$text_color='#000000';}?>
                                    <label class="lbl_beh">
                                        <div class="innercont_stff">
                                            <div class="_label" style="border:1px solid #cdd8cf; width:4.4%; padding:5px; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; color:<?php echo $text_color;?>; text-align:right">
                                                <?php echo $c; ?>
                                            </div>
                                            
                                            <div class="_label" style="border:1px solid #cdd8cf; width:55%; padding:5px; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; color:<?php echo $text_color;?>; text-align:left">
                                                <?php if ($mutual_ex == 1){echo '*';}else if ($mutual_ex == 2){echo '**';}else if ($mutual_ex == 32){echo '***';}
                                                echo $vQualSubjectDesc;
                                                if ($mutual_ex <> 0){echo ' (An alternative to another equally marked subject)';}?>
                                                <input name="cQualSubjectId<?php echo $c ?>" type="hidden" value="<?php echo $cQualSubjectId;?>" />
                                            </div>
                                            
                                            <div class="_label" style="border:1px solid #cdd8cf; width:7.2%; padding:5px; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; color:<?php echo $text_color;?>; text-align:left; text-indent:3px;">
                                                <?php echo $cQualGradeCode; ?>
                                                <input name="cQualGradeId<?php echo $c ?>" type="hidden" 
                                                    value="<?php echo $cQualGradeId.' '.$iQualGradeRank;?>" />
                                            </div>
                                            
                                            <div class="_label" style="border:1px solid #cdd8cf; width:7.4%; padding:5px; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; color:<?php echo $text_color;?>; text-align:left">
                                                <?php if ($cMandate == 'E'){echo "Optional";}elseif ($cMandate == 'C'){echo "Compulsory";}; ?>
                                                <input name="cMandate<?php echo $c ?>" type="hidden" value="<?php echo $cMandate;?>" />
                                            </div>
                                            
                                            <div class="_label" style="border:1px solid #cdd8cf; width:19.6%; padding:5px; padding-top:9px; padding-bottom:8px; background-color:<?php echo $background_color;?>; text-align:right"><?php 
                                                if ($sm == '5' && $crit_used == '0' && !($iBeginLevel > 100 && $cEduCtgId_2 == ''))
                                                {?>

                                                    <a href="#"style="text-decoration: none" onclick="
                                                    e_qual_sbj.ac.value='';
                                                    e_qual_sbj.ec.value='';
                                                    e_qual_sbj.dc.value='';												
                                                    e_qual_sbj.aq.value='';
                                                    e_qual_sbj.eq.value='';
                                                    e_qual_sbj.dq.value='';												
                                                    e_qual_sbj.as.value='';
                                                    e_qual_sbj.es.value='';
                                                    e_qual_sbj.ds.value='1';
                                                    e_qual_sbj.das.value='';												
                                                    e_qual_sbj.en.value='';
                                                    e_qual_sbj.dis.value='';
                                                    e_qual_sbj.admt.value='';
                                                    e_qual_sbj.conf.value='';
                                                    e_qual_sbj.sbjlist.value='1';
                                                    if(_('userInfo_f').value!=_('cFacultyId').value&&_('sRoleID').value!=6)
                                                    {
                                                        caution_box('You cannot delete criteria in the selected faculty');
                                                    }else if(_('userInfo_d').value!=_('cdept').value&&_('sRoleID').value!=6)
                                                    {
                                                        caution_box('You cannot delete criteria in the selected department');
                                                    }else
                                                    {
                                                        e_qual_sbj.criteriaqualId.value='<?php echo $_REQUEST['criteriaqualId']; ?>';
                                                        e_qual_sbj.cEduCtgId.value='<?php echo $_REQUEST['cEduCtgId']; ?>';
                                                        e_qual_sbj.sReqmtId.value='<?php echo $sReqmtId; ?>';
                                                        e_qual_sbj.cQualSubjectId.value='<?php echo $cQualSubjectId; ?>';
                                                        e_qual_sbj.cFacultyId.value='<?php echo $_REQUEST['cFacultyId']; ?>';
                                                        e_qual_sbj.subjectno.value='<?php echo $c ?>';
                                                        _('conf_msg_msg_loc').innerHTML = _('progs_affected').value+'Are you sure you want to delete subject number '+_('subjectno').value +'?';
                                                        _('conf_box_loc').style.display='block';
                                                        _('conf_box_loc').style.zIndex='3';
                                                        _('smke_screen_2').style.display='block';
                                                        _('smke_screen_2').style.zIndex='2';
                                                    }">
                                                    <img src="img/delete.gif" title="Delete subject" width="33" height="14" hspace="0" vspace="0" border="0" /></a><?php
                                                }else if ($iBeginLevel > 100 && $cEduCtgId_2 == '')
                                                {?>
                                                    <img src="img/delete_d.gif" style="cursor:not-allowed" title="Go to the corresponding 100L criterion to delete this subject" width="33" height="14" hspace="0" vspace="0" border="0" /></a><?php 
                                                }else
                                                {
                                                    echo '-';
                                                }?>
                                            </div>
                                        </div>
                                    </label><?php                        
                                }elseif ((($c <= $number_of_entry && $es == '1') || $as == '1') && ($msg == '' || ($msg <> '' && $err_num == 2)))
                                {?>
                                    <label class="lbl_beh">
                                        <div class="innercont_stff" style="width:100%; padding:0px;">
                                            <div class="_label" style="border:1px solid #cdd8cf; width:4.3%; padding:5px; padding-top:8px; padding-bottom:8px; background-color:<?php echo $background_color;?>; text-align:right">
                                                <?php echo $c; ?>
                                            </div>
                            
                                            <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:100%; padding:0px; margin-left:-1px; width:56%; text-align:left;">
                                                <select name="cQualSubjectId<?php echo $c; ?>" id="cQualSubjectId<?php echo $c; ?>" class="select">
                                                    <option value="" selected></option><?php
                                                    $stmt_lst->data_seek (0);
                                                    while ($stmt_lst->fetch())
                                                    {?>
                                                        <option value="<?php echo $cQualSubjectId?>" <?php if (isset($_REQUEST["cQualSubjectId$c"]) && $_REQUEST["cQualSubjectId$c"] == $cQualSubjectId){echo ' selected';} ?>><?php echo $vQualSubjectDesc;?></option><?php
                                                    }?>
                                                </select>
                                            </div>
                                            
                                            <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:100%; padding:0px; margin-left:-1px; width:8.2%; text-align:left;">
                                                <select name="cQualGradeId<?php echo $c; ?>" id="cQualGradeId<?php echo $c; ?>" class="select">
                                                    <option value="" selected></option><?php
                                                    $stmt_lst1->data_seek (0);
                                                    while ($stmt_lst1->fetch())
                                                    {?>
                                                        <option value="<?php echo $cQualGradeId;?>"<?php if (isset($_REQUEST["cQualGradeId$c"]) && $_REQUEST["cQualGradeId$c"] == $cQualGradeId){echo ' selected';}?>><?php echo $cQualGradeCode;?></option><?php
                                                    }?>
                                                </select>
                                            </div>
                                            
                                            <div style="float:left; border:1px solid #cccccc; border-radius:0px; height:100%; padding:0px; margin-left:-1px; text-align:left; width:8.3%;">
                                                <select name="cMandate<?php echo $c; ?>" id="cMandate<?php echo $c; ?>" class="select">
                                                    <option value="" selected></option>
                                                    <option value="C"<?php if (isset($_REQUEST["cMandate$c"]) && $_REQUEST["cMandate$c"] == 'C'){echo ' selected';}?>>Compulsory</option>
                                                    <option value="E"<?php if (isset($_REQUEST["cMandate$c"]) && $_REQUEST["cMandate$c"] == 'E'){echo ' selected';}?>>Optional</option>
                                                </select>
                                            </div>
                                        </div>
                                    </label><?php
                                }
                                $prev_subject = $vQualSubjectDesc;
                            }
                            
                            if ($NoOfsbjEntered == 0 && $as <> '1')
                            {?>
                                <div class="succ_box blink_text blue_msg" id="succ_boxt" style="width:50%; float: none; margin:auto; margin-top:45px; display:block">
                                    There are no subjects under this qualification
                                </div><?php                                
                            }?>
                        </form>
                    </div><?php
                }
            }?>
		<!-- InstanceEndEditable -->
	</div>
	<div class="rightSide_0">
		<div id="insiderightSide" style="margin-top:1px;">
			<div id="pp_box">
				<img name="passprt" id="passprt" src="<?php echo get_pp_pix('');?>" width="95%" height="185"  
				style="margin:0px;<?php if ($currency <> '1' ){?>opacity:0.3;<?php }?>" alt="" />
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