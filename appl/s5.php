<?php
require_once('good_entry.php');

// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('lib_fn.php');
require_once('const_def.php');
        
$mysqli = link_connect_db();
$save_status = '';

if (isset($_REQUEST["r_saved"]) && $_REQUEST["r_saved"] == '1')
{
	$stmt = $mysqli->prepare("REPLACE INTO nextofkin (vApplicationNo, vNOKName, vNOKAddress, vNOKEMailId, vNOKMobileNo, 
	cNOKType) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssssss", 
    $_REQUEST["vApplicationNo"], 
    $_REQUEST["vNOKName"], 
    $_REQUEST["vNOKAddress"], 
    $_REQUEST["vNOKEMailId"], 
    $_REQUEST["vNOKMobileNo"], 
    $_REQUEST["cNOKType"]);
	$stmt->execute();

    $stmt = $mysqli->prepare("UPDATE prog_choice SET cSbmtd = '0' WHERE vApplicationNo = ?");
    $stmt->bind_param("s", $_REQUEST['vApplicationNo']);
    $stmt->execute();
	$stmt->close();
        
    log_actv('Saved next of kin information');
    $save_status = 'Success';
}


$cEduCtgId = '';
if (isset($_REQUEST["cEduCtgId"])){$cEduCtgId = $_REQUEST["cEduCtgId"];}

$iQSLCount = '';	
$cQualCodeId_01 = '';	
$vQualCodeDesc = '';	

$vExamNo = '';
$vcard_pin = '';
$vcard_sn = '';	

$vExamSchoolName = '';
$cExamMthYear = '';

$vApplicationNo = '';

$vcard_pin_01 = ''; 
$vcard_sn_01 = '';
$vExamSchoolName_01 = '';
$cExamMthYear_01 = '';

$credent_loaded = 0;

$number_of_cat_selected = 0;


if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST["vApplicationNo"] <> '')
{
    $vApplicationNo = $_REQUEST["vApplicationNo"];
}else if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
{
    $vApplicationNo = $_REQUEST["uvApplicationNo"];
}

$del_status = '';

if (isset($_REQUEST['ope_mode']) && $_REQUEST['ope_mode'] == 'd' && isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
{
    try
    {
        $mysqli->autocommit(FALSE); //turn on transactions

        $stmt = $mysqli->prepare("delete from applyqual where cQualCodeId = ? and vExamNo = ? and vApplicationNo = ?");
        $stmt->bind_param("sss", $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo'], $vApplicationNo);
        $stmt->execute();
        $stmt->close();

        $stmt = $mysqli->prepare("delete from applysubject where cQualCodeId = ? and vExamNo = ? and vApplicationNo = ?");
        $stmt->bind_param("sss", $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo'], $vApplicationNo);
        $stmt->execute();
        $stmt->close();

        $stmt = $mysqli->prepare("delete from afnqualsubject where cQualCodeId = ? and vExamNo = ? and vApplicationNo = ?");
        $stmt->bind_param("sss", $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo'], $vApplicationNo);
        $stmt->execute();
        $stmt->close();

        $stmt = $mysqli->prepare("delete from pics where cQualCodeId = ? and vExamNo = ? and vApplicationNo = ?");
        $stmt->bind_param("sss", $_REQUEST['cQualCodeId'], $_REQUEST['vExamNo'], $vApplicationNo);
        $stmt->execute();
        $stmt->close();

        $flname = BASE_FILE_NAME_FOR_PP.$_REQUEST["cQualCodeId"]."_".addslashes($_REQUEST["vExamNo"])."_".$vApplicationNo.".jpg";
        if (file_exists($flname))
        {
            @unlink($flname);
        }else
        {
            $flname = BASE_FILE_NAME_FOR_PP.$_REQUEST["cQualCodeId"]."_".addslashes($_REQUEST["vExamNo"])."_".$vApplicationNo.".png";
            if (file_exists($flname))
            {
                @unlink($flname);
            }
        }

        log_actv('deleted credential with code '.$_REQUEST['cQualCodeId'].' exam number '.$_REQUEST['vExamNo']);
        
        $mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

        $del_status = 'Success';
    }catch(Exception $e) 
    {
        $mysqli->rollback(); //remove all queries from queue if error (undo)
        throw $e;
    }
}?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/s5.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/s5.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
        if (isset($_REQUEST["ope_mode"]) && $_REQUEST["ope_mode"] <> '' &&  $_REQUEST["ope_mode"] <> 'c' && $_REQUEST["ope_mode"]<>'d' && isset($_REQUEST["cQualCodeId"]) && $_REQUEST["cQualCodeId"] == 'others')
        {?>
            <div id="smke_screen_3" class="smoke_scrn" style="display:block; z-index:2"></div>
            <form method="post" enctype="multipart/form-data" 
                onsubmit="return other_otherqual();">
                <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];}; ?>" />
                <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                <div id="container_cover_in_chkps" class="center" style="display: block; 
                flex-direction:column; 
                gap:8px;  
                justify-content:space-around; 
                height:auto;
                padding:10px;
                box-shadow: 2px 2px 8px 2px #726e41;
                z-Index:3;
                background-color:#fff;" title="Press escape to close">
                    <div style="line-height:1.5; width:70%; font-weight:bold">
                        Upload complementary credential <font style="color:#e31e24">(PDF format required)</font>
                    </div>
                    <div style="line-height:1.5; width:20; position:absolute; top:10px; right:10px;">
                        <img style="width:17px; height:17px; cursor:pointer" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" 
                        onclick="_('container_cover_in_chkps').style.zIndex = -1;
                            _('container_cover_in_chkps').style.display = 'none';
                            _('smke_screen_3').style.zIndex = -1;
                            _('smke_screen_3').style.display = 'none';"/>
                    </div>

                    <div style="line-height:1.4; padding:8px 0px 8px 5px; width:99%; background-color: #fdf0bf; margin-top:10px;">
                        Supporting document (Referals, attestation, testimonials, badges, evidence of acquired skills etc.)
                    </div>

                    <div style="height:53px; margin-top:10px;">
                        <input type="file" name="other_sbtd_pix" id="other_sbtd_pix" style="width:180px" title="Max size: 100KB, Acceptable format: PDF" required>
                    </div>
                    
                    <div style="height:auto; display:flex; justify-content:flex-end; margin-top:15px">
                        <button type="submit" name="other_sbtd_pix_submit" class="button" style="padding:12px 0px 12px 0px; border:1px solid #b6b6b6; width:30%;">
                            Upload
                        </button>
                    </div>
                </div>        
            </form><?php
        }

        if (isset($_POST["other_sbtd_pix_submit"]))
        {
            $filepath = $_FILES['other_sbtd_pix']['tmp_name'];
			$fileSize = filesize($filepath);
			//$fileinfo = finfo_open(FILEINFO_MIME_TYPE);
			//$filetype = finfo_file($fileinfo, $filepath);
			if ($fileSize == 0)
			{
				caution_box('Cannot upload empty file for complementary credential');
			}else if ($fileSize > 100000)
			{ // 3 MB (1 byte* 1024 * 1024 * 3 (for 3 MB))
				
				caution_box("The file is too large for complementary credential. Max is 100KB");
			}else if (mime_content_type($_FILES['other_sbtd_pix']['tmp_name']) <> "application/pdf")
            {
                caution_box('Invalid file format');
            }else
            {
                $stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM pics WHERE vApplicationNo  = ? AND cinfo_type = 'ccr'");
                $stmt_last->bind_param("s", $_REQUEST["vApplicationNo"]);
                $stmt_last->execute();
                $stmt_last->store_result();
                $stmt_last->bind_result($mask);
                $stmt_last->fetch();
                $stmt_last->close();

                $pix_file_name = "../ext_docs/ccr/ccr_".$mask.".pdf";
                if(file_exists($pix_file_name))
                {
                    @unlink($pix_file_name);
                }

                $token = openssl_random_pseudo_bytes(6);
		        $token = bin2hex($token);
                $pix_file_name = "../ext_docs/ccr/ccr_".$token.".pdf";

                if (move_uploaded_file($_FILES['other_sbtd_pix']['tmp_name'], $pix_file_name))
                {
                    chmod($pix_file_name, 0644);

                    $stmt = $mysqli->prepare("REPLACE INTO pics
                    SET vmask = '$token', vApplicationNo = ?, cinfo_type = 'ccr', vExamNo = '', cQualCodeId = ''");
                    $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
                    $stmt->execute();
                    $stmt->close();
            
                    log_actv('Uploaded complementary credential');
                    success_box('File uploaded succesfully');
                }else
                {
                    success_box('File not uploaded. Try again');
                }
                
            }
        }

        require_once("subject_list.php");?>
        <div id="conf_box_loc" class="center top_most" 
            style="text-align:center; 
            padding:10px; 
            box-shadow: 2px 2px 8px 2px #726e41; 
            background:#FFFFFF;">
            <div style="width:90%; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                Confirmation
            </div>
            <a href="#" style="text-decoration:none;">
                <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
            </a>
            <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:90%; float:left; text-align:center; padding:0px;">
                Are you sure about this?
            </div>
            <div style="margin-top:10px; width:90%; float:right; text-align:right; padding:0px;">
                <a href="#" style="text-decoration:none;" 
                    onclick="ps.conf.value='1';
                    set_rec_mgt_btn();
                    in_progress('1');
                    ps.submit();
                    return false">
                    <div class="login_button" style="width:60px; padding:6px; margin-left:10px; float:right">
                        Yes
                    </div>
                </a>

                <a href="#" style="text-decoration:none;" 
                    onclick="ps.conf.value='0';
                    _('conf_box_loc').style.display='none';
                    _('conf_box_loc').style.zIndex='-1';
                    _('smke_screen_2').style.display='none';
                    _('smke_screen_2').style.zIndex='-1';">
                    <div class="rec_pwd_button" style="width:60px; padding:6px; float:right">
                        No
                    </div>
                </a>
            </div>
        </div>

        <div class="cert_img_container" id="container_cover_in" 
            style="
            display:<?php if (isset($_REQUEST['cQualCodeId']) && $_REQUEST['cQualCodeId'] <> '' && isset($_REQUEST['vExamNo']) && $_REQUEST['vExamNo'] <> '' &&isset($_REQUEST["ope_mode"])&&$_REQUEST["ope_mode"]=='v'){echo 'block';}else{echo 'none';} ?>;">
                <div id="inner_submityes_header0" style="width:50px;
                    height:15px;
                    padding:3px; 
                    float:right; 
                    text-align:right;">
                        <a href="#"
                            onclick="_('container_cover_in').style.display = 'none';
                            _('container_cover_in').style.zIndex = -1;return false" 
                            style="color:#666666; margin-right:3px; text-decoration:none;text-shadow: 0 1px 0 #fafafa;">
                            <img style="width:15px; height:15px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" />
                        </a>
                </div>
                
                <div id="inner_submityes_g1" 
                    style="width:inherit; 
                    height:96%;
                    border-radius:3px; 
                    text-align:center; 
                    float:left;
                    top:15px; 
                    z-index:-1;
                    position:absolute;
                    display:block;">
                    <img id="credential_img" style="width:100%; height:100%" 
                        src="<?php if (isset($_REQUEST['cQualCodeId']) && $_REQUEST['cQualCodeId'] <> '' && isset($_REQUEST['vExamNo']) && $_REQUEST['vExamNo'] <> '')
                        {
                            echo get_cert_pix('');
                        }else
                        {
                            echo 'No image found';
                        }?>"/>
                </div>
        </div>
        
        
        <div class="cert_img_container" id="ccr_container_cover_in" 
            style="
            display:<?php if (isset($_REQUEST['ccr_qual']) && $_REQUEST['ccr_qual'] <> '' && isset($_REQUEST["ope_mode"])&&$_REQUEST["ope_mode"]=='v'){echo 'block';}else{echo 'none';} ?>;">
                <div id="inner_submityes_header0" style="width:50px;
                    height:15px;
                    padding:3px; 
                    float:right; 
                    text-align:right;">
                        <a href="#"
                            onclick="_('ccr_container_cover_in').style.display = 'none';
                            _('ccr_container_cover_in').style.zIndex = -1;
                            return false" 
                            style="color:#666666; margin-right:3px; text-decoration:none;text-shadow: 0 1px 0 #fafafa;">
                            <img style="width:15px; height:15px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" />
                        </a>
                </div>
                
                <div id="inner_submityes_g1" 
                    style="width:inherit; 
                    height:96%;
                    border-radius:3px; 
                    text-align:center;
                    float:left;
                    top:15px; 
                    z-index:2;
                    position:absolute;
                    display:block;">
                    <iframe src="<?php if (isset($_REQUEST["ccr_qual"])){echo $_REQUEST["ccr_qual"];}?>" style="width:95%; height:inherit;" frameborder="0"></iframe>
                </div>
        </div><?php
        require_once("feedback_mesages.php");
        require_once("forms.php");

        $orgsetins = settns();

        if ($save_status == 'Success')
        {
            success_box($save_status);
        }else if ($del_status == 'Success')
        {
            success_box($del_status);
        }
        
        $stmt = $mysqli->prepare("SELECT a.cEduCtgId, b.vEduCtgDesc FROM prog_choice a, educationctg b WHERE a.cEduCtgId  = b.cEduCtgId AND vApplicationNo = ?");
        $stmt->bind_param("s", $vApplicationNo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cEduCtgId, $vEduCtgDesc);
        $stmt->fetch();
        $stmt->close();
		
        $can_go_next = 0;
        if ($cEduCtgId == 'PGX' || $cEduCtgId == 'PGY' || $cEduCtgId == 'PRX')
        {
            if ($cEduCtgId == 'PGX')//PGD
            {
                $stmt = $mysqli->prepare("SELECT DISTINCT cEduCtgId FROM applyqual WHERE vApplicationNo = ? AND cEduCtgId IN ('PSZ','PSX')");
            }else if ($cEduCtgId == 'PGY')//Masters
            {
                $stmt = $mysqli->prepare("SELECT DISTINCT cEduCtgId FROM applyqual WHERE vApplicationNo = ? AND  cEduCtgId IN ('PSZ','PSX','PGX')");
            }else if ($cEduCtgId == 'PRX' || $cEduCtgId == 'PGZ')//PhD. MPhil
            {
                $stmt = $mysqli->prepare("SELECT DISTINCT cEduCtgId FROM applyqual WHERE vApplicationNo = ? AND cEduCtgId IN ('PSZ','PGY')");
            }
       
            $stmt->bind_param("s", $vApplicationNo);
            $stmt->execute();
            $stmt->store_result();
            $can_go_next = $stmt->num_rows;
        }else
        {
            $can_go_next = 1;
        }
        
        $passpotLoaded = passport_loaded($vApplicationNo);

        $vTitle = ''; 
        $vLastName = ''; 
        $vFirstName = ''; 
        $vOtherName = '';

        if ($vApplicationNo <> '')
        {
            $stmt = $mysqli->prepare("SELECT 
            vTitle, 
            vLastName, 
            vFirstName, 
            vOtherName  FROM pers_info WHERE vApplicationNo = ?");
            
            $stmt->bind_param("s", $vApplicationNo);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($vTitle, 
            $vLastName, 
            $vFirstName, 
            $vOtherName);
            $stmt->fetch();
            $stmt->close();
        }
        
        $sidemenu = '';
        if (isset($_REQUEST["sidemenu"]) && $_REQUEST["sidemenu"] <> '')
        {
            $sidemenu = $_REQUEST["sidemenu"];
        }?>

        <div class="appl_container">
            <div class="appl_left_div">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;">Application Form for Admission </div>
                
                <div class="menu_bg_scrn"><?php
                    build_menu($sidemenu);?>
                </div>
            </div>
            
            <div class="appl_right_div" style="font-size:1em;">
                <div class="appl_left_child_div" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php appl_top_menu();?>
                </div>
                <div class="appl_left_child_div" style="text-align: left; width:98%; margin:auto; overflow:auto; margin-top:10px; background-color:#eff5f0"><?php
                    if (gaurd_seq(5) == '0')
                    {?>
                        <div class="center top_most talk_backs talk_backs_logo" style="display:block; z-Index:6; border-color: #ffa300; background-position:15px 15px; background-size: 30px 30px; background-image: url('img/info.png');">
                            <div id="informa_msg_content_caution_appl" class="informa_msg_content_caution_cls" style="color:#ffa300;">
                                You must complete the Contact - Next of kin section before this section
                            </div>
                            <div class="informa_msg_content_caution_cls" style="color:#ffa300;">
                            </div>
                        </div><?php
                    }else
                    {
                        $vExamNo_01 = '';
                        $cQualCodeId_01 = '';
                        $cEduCtgId_01 = '';
                        $iQSLCount_01 = 0;
                        $cEduCtgId_qual = '';
                        $vExamSchoolName_01 = '';
                        $cExamMthYear_01 = '';

                        if(isset($_REQUEST['cQualCodeId']))
                        {    
                            $stmt = $mysqli->prepare("SELECT c.cEduCtgId, iQSLCount 
                            from qualification b, educationctg c 
                            where  c.cEduCtgId = b.cEduCtgId and b.cQualCodeId = ?");
                            $stmt->bind_param("s", $_REQUEST['cQualCodeId']);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($cEduCtgId_qual, $iQSLCount_01);
                            $stmt->fetch();
                            $stmt->close();
                            
                        }
                        
                        $stmt = $mysqli->prepare("SELECT dBirthDate from pers_info where vApplicationNo = ?");
                        $stmt->bind_param("s", $vApplicationNo);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($dBirthDate);
                        $stmt->fetch();
                        $dBirthDate = $dBirthDate ?? '';
                        $dBirthYear =  substr($dBirthDate,0,4);?>
                        <input name="dBirthYear" id="dBirthYear" type="hidden" value="<?php echo $dBirthYear;?>" /><?php
                        $stmt->close();?>

                        <form method="post" name="ps" enctype="multipart/form-data" onsubmit="return false">
                            <input name="name_warn" id="name_warn" type="hidden" value="0" />
                            <input name="vApplicationNo" type="hidden" value="<?php if (isset($vApplicationNo)){echo $vApplicationNo;} ?>" />
                            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                            <input name="r_saved" type="hidden" value="0" />
                            <input name="conf" type="hidden" value="0" />
                            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];} ?>" />
                            <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else{echo $cEduCtgId;}?>" />

		                    <input name="cEduCtgId_qual" id="cEduCtgId_qual" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId_qual'])&&$_REQUEST['cEduCtgId_qual']<> ''){echo $_REQUEST['cEduCtgId_qual'];}else{echo $cEduCtgId_qual;}?>" />

                            <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php echo $passpotLoaded; ?>" />
                            <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
                            <input name="iQSLCount" id="iQSLCount" type="hidden" value="<?php echo $iQSLCount_01; ?>" />
                            
                            <input name="cQualCodeId_desc" id="cQualCodeId_desc" type="hidden" value="<?php if (isset($_REQUEST["cQualCodeId_desc"])){echo $_REQUEST["cQualCodeId_desc"];} ?>" />
                            
                            <input name="date_of_today" id="date_of_today" type="hidden" value="<?php echo date("Y-m-d");?>">

                            <input name="ope_mode" id="ope_mode" type="hidden" value="<?php if (isset($_REQUEST["ope_mode"])){echo $_REQUEST["ope_mode"];}; ?>" />
                            <input name="can_go_next" id="can_go_next" type="hidden" value="<?php echo $can_go_next; ?>" />
                            
                            <input name="max_size_of_cred" id="max_size_of_cred" type="hidden" value="<?php echo $orgsetins['size_cred']; ?>" />
                            <input name="ccr_qual" id="ccr_qual" type="hidden" value="<?php if (isset($_REQUEST['ccr_qual'])){echo $_REQUEST['ccr_qual'];} ?>" />
                            
                            <input name="studentID" id="studentID" type="hidden" value="<?php if (isset($_REQUEST["studentID"]) && $_REQUEST["studentID"] <> ''){echo $_REQUEST["studentID"];} ?>" /><?php

                            $stmt = $mysqli->prepare("SELECT * FROM applyqual WHERE cQualCodeId IN ('201','202','203','204','207') AND vApplicationNo = ?");
                            $stmt->bind_param("s", $vApplicationNo);
                            $stmt->execute();
                            $stmt->store_result();
                            $entered_Ol_qualifications = $stmt->num_rows;?>

                            <input name="entered_Ol_qualifications" id="entered_Ol_qualifications" type="hidden" value="<?php echo $entered_Ol_qualifications; ?>" /><?php

                            if ((isset($cEduCtgId) && ($cEduCtgId == 'PRX' || $cEduCtgId == 'PGZ')) || (isset($_REQUEST['cEduCtgId']) && ($_REQUEST['cEduCtgId'] == 'PRX' || $_REQUEST['cEduCtgId'] == 'PGZ')))
                            {
                                $stmt = $mysqli->prepare("SELECT * from applyqual a, qualification b where a.cQualCodeId = b.cQualCodeId AND vApplicationNo = ? AND b.cEduCtgId IN ('PSZ','PGY')");
                                $stmt->bind_param("s", $vApplicationNo);
                                $stmt->execute();
                                $stmt->store_result();
                                $entered_Ol_qualifications = $stmt->num_rows;
                            }
                            $stmt->close();?>

                            <input name="entered_Ol_qualifications" id="entered_Ol_qualifications" type="hidden" value="<?php echo $entered_Ol_qualifications; ?>" /><?php


                            appl_form_header ('Academic qualifications',  $vEduCtgDesc, $vLastName, $vFirstName, $vOtherName, $vTitle);?>
                            
                            <div id="guide_div" class="appl_left_child_div_child">
                                <div style="flex:100%; padding:5px; height:auto; background-color: #fdf0bf; position:relative">
                                    <a href="#"
                                        onclick="_('guide_div').style.display = 'none';
                                        _('guide_div').style.zIndex = -1;return false" 
                                        style="color:#666666; margin-right:3px; text-decoration:none;text-shadow: 0 1px 0 #fafafa; position:absolute; top:10px; right:10px;">
                                            <img style="width:15px; height:15px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" />
                                        </a>
                                    <b>Guide</b>
                                    <ol>
                                        <li>To add new qualification, click 'Add' button (below, left)</li>
                                        <li>To see or select already entered qualifications, click the respective button (below, right)</li>
                                        <li>To delete selected qualification, click the 'Delete' button. Available only when a qualification is selected</li>
                                        <li>To edit selected qualification, click the 'Edit' button. Available only when a qualification is selected</li>
                                    </ol>
                                </div>
                            </div>                                
                                
                            <div class="appl_left_child_div_child" style="margin-bottom:8px">
                                <div id="access_btn_div" style="flex:100%; display:flex; gap:4px; height:50px; background-color: #eff5f0">
                                    <div id="add_qual_div" class="data_line_child data_line_child_home" 
                                        style="text-align:center; margin:0px; display:none" title="Add qualification">
                                        <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
                                            onclick="ps.vExamNo.value='';
                                                ps.cQualCodeId.value='';
                                                
                                                ps.hdvExamNo.value='';
                                                ps.hdcQualCodeId.value='';
                                                ps.cExamMthYear.value='';
                                                ps.vExamSchoolName.value='';
                                                ps.month.value='';
                                                ps.year.value='';
                                                ps.sbtd_pix.value='';
                                                ps.cEduCtgId_qual.value = '';
                                                
                                                cQualCodeId_div.style.display='none';
                                                vExamNo_div.style.display='none';
                                                vExamSchoolName_div.style.display='none';
                                                month_div.style.display='none';
                                                sbtd_pix_div.style.display='none';
                                                qual_sbj_div.style.display='none';

                                                sub_div.style.display='none';
                                                
                                                for(var i = 1; i <= ps.iQSLCount.value; i++)
                                                {
                                                    if (iQSLCount.value == 9)
                                                    {
                                                        var elemgName = 'grade1' + i;
                                                        var elemsName = 'subject1' + i;
                                                        var sbjt_grade_div = 'sbjt_grade_div1'+i;
                                                    }else if (iQSLCount.value == 4)
                                                    {
                                                        var elemgName = 'grade2' + i;
                                                        var elemsName = 'subject2' + i;
                                                        var sbjt_grade_div = 'sbjt_grade_div2'+i;
                                                    }else if (iQSLCount.value == 1)
                                                    {
                                                        var elemgName = 'grade3' + i;
                                                        var elemsName = 'subject3' + i;
                                                        var sbjt_grade_div = 'sbjt_grade_div3'+i;
                                                    }
                                                    
                                                    if ( _(elemsName))
                                                    {
                                                        _(elemsName).value = '';
                                                        _(elemgName).value = '';

                                                        _(sbjt_grade_div).style.display = 'none';
                                                    }
                                                }
                                                ps.iQSLCount.value='';

                                                _('ope_mode').value = 'a';
                                                ps.ccr_qual.value='';
                                                set_rec_mgt_btn();
                                                _('cancel_add_div').style.display='block';
                                                _('add_qual_div').style.display='none';
                                                return false">
                                            <img width="20" height="17" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>" alt="Add">
                                            Add</button>
                                    </div>
                                    
                                    <div id="show_all_div" class="data_line_child data_line_child_home" 
                                        style="text-align:center; margin:0px; display:none" title="Add qualification">
                                        <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
                                            onclick="_('ope_mode').value = 'c';
                                                _('cQualCodeId').value='';
                                                ps.ccr_qual.value='';
                                                in_progress('1');
                                                ps.submit();
                                                return false;">
                                            <img width="20" height="17" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>" alt="Add">
                                            Show all</button>
                                    </div><?php

                                    $show = 'none';
                                    if (isset($_REQUEST["ccr_qual"]) && $_REQUEST["ccr_qual"] == '' && isset($_REQUEST["ope_mode"]) && $_REQUEST["ope_mode"] == 'v')
                                    {
                                        $show = 'block';
                                    }?>

                                    <div id="edit_qual_div" class="data_line_child data_line_child_logout" 
                                        style="text-align:center; margin: 0px; display:<?php echo $show;?>;">
                                        <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6; display:<?php echo $show;?>" 
                                        onclick="_('ope_mode').value = 'e';
                                        set_rec_mgt_btn();">
                                        <img width="20" height="17" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'edit.png');?>" alt="Edit">
                                        Edit</button>
                                    </div>
                                    
                                    <div id="del_qual_div" class="data_line_child data_line_child_logout" 
                                        style="text-align:center; margin: 0px; display:<?php echo $show;?>;">
                                        <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6; display:<?php echo $show;?>" 
                                            onclick="_('ope_mode').value = 'd';
                                                ps.vExamNo.value='<?php if (isset($_REQUEST['vExamNo']) && $_REQUEST['vExamNo'] <> ''){echo $_REQUEST['vExamNo'];} ?>';
                                                ps.cQualCodeId.value='<?php if (isset($_REQUEST['cQualCodeId']) && $_REQUEST['cQualCodeId'] <> ''){echo $_REQUEST['cQualCodeId'];} ?>';
                                                _('smke_screen_2').style.display='block';
                                                _('smke_screen_2').style.zIndex = '2';
                                                _('conf_box_loc').style.display='block';
                                                _('conf_box_loc').style.zIndex = '3';
                                            return false">
                                        <img width="20" height="17" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'delete_one.png');?>" alt="Delete">
                                        Delete</button>
                                    </div>
                                    
                                    <div id="cancel_add_div" class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px; display:none;">
                                        <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
                                            onclick="_('ope_mode').value = 'c';
                                                _('cQualCodeId').value='';
                                                ps.ccr_qual.value='';
                                                in_progress('1');
                                                ps.submit();
                                                return false;">
                                        <img width="20" height="17" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'cancel.png');?>" alt="Cancel">
                                        Cancel</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child" style="margin-bottom:8px">
                                <div id="qual_btn_div"  style="flex:100%; display:flex; gap:4px; height:50px; background-color: #eff5f0"><?php            
                                    $cQualCodeId_02 = '';
                                    $vExamNo_02 = '';
                                    $vcard_pin_02 = '';
                                    $vcard_sn_02 = '';
                                    $cExamMthYear_02 = '';
                                    $vExamSchoolName_02 = '';
                                    $cEduCtgId_02 = '';
                                    $iQSLCount_02 = '';
                                    $vQualCodeDesc_02 = '';
                                    
                                    $stmt = $mysqli->prepare("SELECT a.cQualCodeId,vExamNo,vcard_pin,vcard_sn,cExamMthYear,vExamSchoolName, b.cEduCtgId, c.cEduCtgId, c.iQSLCount, b.vQualCodeDesc 
                                    FROM applyqual a, qualification b, educationctg c 
                                    WHERE a.cQualCodeId = b.cQualCodeId 
                                    AND c.cEduCtgId = b.cEduCtgId 
                                    AND vApplicationNo = ? 
                                    ORDER BY right(cExamMthYear,4), left(cExamMthYear,2)");
                                    $stmt->bind_param("s", $vApplicationNo);
                                    $stmt->execute();
                                    $stmt->store_result();
                                    $stmt->bind_result($cQualCodeId_02, $vExamNo_02, $vcard_pin_02, $vcard_sn_02, $cExamMthYear_02, $vExamSchoolName_02, $cEduCtgId_02, $cEduCtgId_qual_02, $iQSLCount_02, $vQualCodeDesc_02);
                                    $entered_qualifications = $stmt->num_rows;

                                    $qual_counter = 0;
                                    $number_of_quals = $stmt->num_rows;?>
                                    <input name="number_of_quals" id="number_of_quals" type="hidden" value="<?php echo $number_of_quals;?>" />
                                    <input name="entered_qualifications" id="entered_qualifications" type="hidden" value="<?php echo $entered_qualifications;?>"><?php

                                    $color = '#ffffff';
                                    $backgroudcolor = '#2F4230';
                                    $border = 'none';
                                    
                                    if ($number_of_quals > 0)
                                    {
                                        //$stmt->data_seek(0);
                                        while($stmt->fetch())
                                        {
                                            $credential_loaded = credential_loaded($vApplicationNo, $cQualCodeId_02, $vExamNo_02);
                                            
                                            $color = '#ffffff';
                                            $backgroudcolor = '#2F4230';
                                            $border = 'none';

                                            if (isset($_REQUEST['ope_mode']) && $_REQUEST['ope_mode'] == 'v')
                                            {
                                                if (($cQualCodeId_02 == $_REQUEST['cQualCodeId']) && ($vExamNo_02 == $_REQUEST['vExamNo']))
                                                {
                                                    $color = '#2F4230';
                                                    $backgroudcolor = '#FFFFFF';
                                                    $border = '1px solid #b6b6b6;';
                                                }								
                                            }

                                            $qual_abrv = '';
                                            
                                            if ($cQualCodeId_02 == '201')
                                            {
                                                $qual_abrv = 'GCE';
                                            }else if ($cQualCodeId_02 == '202')
                                            {
                                                $qual_abrv = 'SSCE';
                                            }else if ($cQualCodeId_02 == '203')
                                            {
                                                $qual_abrv = 'NECO';
                                            }else if ($cQualCodeId_02 == '204')
                                            {
                                                $qual_abrv = 'NABTEB';
                                            }else if ($cQualCodeId_02 == '401')
                                            {
                                                $qual_abrv = 'GCE AL/HSC';
                                            }else if ($cQualCodeId_02 == '402')
                                            {
                                                $qual_abrv = 'IJMB A Level';
                                            }else if ($cQualCodeId_02 == '408')
                                            {
                                                $qual_abrv = 'NCE';
                                            }else if ($cQualCodeId_02 == '431')
                                            {
                                                $qual_abrv = 'JUPEB';
                                            }else if ($cQualCodeId_02 == '412')
                                            {
                                                $qual_abrv = 'OND';
                                            }else if ($cQualCodeId_02 == '411')
                                            {
                                                $qual_abrv = 'HND';
                                            }else if ($cQualCodeId_02 == '701')
                                            {
                                                $qual_abrv = 'PGD';
                                            }else if ($cQualCodeId_02 == '801')
                                            {
                                                $qual_abrv = 'Masters Degree';
                                            }else if ($cQualCodeId_02 == '804')
                                            {
                                                $qual_abrv = 'AL NABTEB';
                                            }else if ($cQualCodeId_02 == '601')
                                            {
                                                $qual_abrv = 'First Degree';
                                            }?> 
                                            
                                            <div class="data_line_child data_line_child_home" 
                                                style="text-align:center; margin:0px; 
                                                display:<?php if (isset($_REQUEST["ope_mode"]) && $_REQUEST["ope_mode"] == 'a'){echo 'none';}else{echo 'block';}?>;">
                                                <button type="button" class="button" style="padding:7px; 
                                                    color:<?php echo $color;?>; 
                                                    background-color:<?php echo $backgroudcolor;?>;
                                                    border:<?php echo $border;?>;
                                                    font-size:0.7em;" 
                                                    onclick="ps.ope_mode.value='v';
                                                    ps.vExamSchoolName.value='<?php echo $vExamSchoolName_02;?>';
                                                    ps.cExamMthYear.value='<?php echo $cExamMthYear_02;?>';
                                                    ps.cEduCtgId.value='<?php echo $cEduCtgId_02;?>';
                                                    ps.vExamNo.value='<?php echo $vExamNo_02 ?>';
                                                    ps.cEduCtgId_qual.value='<?php echo $cEduCtgId_qual_02 ?>';
                                                    ps.cQualCodeId.value='<?php echo $cQualCodeId_02 ?>';
                                                    ps.ccr_qual.value='';
                                                    in_progress('1');
                                                    ps.submit(); return false;" title="Click to call up this qualification">
                                                    <img width="20" height="28" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'cert.png');?>" alt="certificate">
                                                    <?php echo $qual_abrv;?></button>
                                            </div><?php
                                            $qual_counter++;
                                        }
                                    }
                                    $stmt->close();

                                    if ($cEduCtgId == 'ELX')
                                    {
                                        $stmt_last = $mysqli->prepare("SELECT trim(vmask) FROM pics WHERE vApplicationNo  = ? AND cinfo_type = 'ccr'");
                                        $stmt_last->bind_param("s", $_REQUEST["vApplicationNo"]);
                                        $stmt_last->execute();
                                        $stmt_last->store_result();
                                        $stmt_last->bind_result($mask);
                                        $stmt_last->fetch();
                                        $stmt_last->close();

                                        $pix_file_name = "../ext_docs/ccr/ccr_".$mask.".pdf";
                                        if(file_exists($pix_file_name))
                                        {?>
                                            <div class="data_line_child data_line_child_home" 
                                                style="text-align:center; margin:0px; 
                                                display:<?php if (isset($_REQUEST["ope_mode"]) && $_REQUEST["ope_mode"] == 'a'){echo 'none';}else{echo 'block';}?>;">
                                                <button type="button" class="button" style="padding:7px; 
                                                    color:<?php echo $color;?>; 
                                                    background-color:<?php echo $backgroudcolor;?>;
                                                    border:<?php echo $border;?>;
                                                    font-size:0.7em;" 
                                                    onclick="ps.ope_mode.value='v';
                                                    ps.vExamSchoolName.value='';
                                                    ps.cExamMthYear.value='';
                                                    ps.cEduCtgId.value='<?php echo $cEduCtgId;?>';
                                                    ps.vExamNo.value='';
                                                    ps.cEduCtgId_qual.value='';
                                                    ps.cQualCodeId.value='';
                                                    ps.ccr_qual.value='<?php echo $pix_file_name;?>';
                                                    in_progress('1');
                                                    ps.submit(); return false;" title="Click to call up this complementary credential">
                                                    <img width="20" height="28" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'cert.png');?>" alt="Complementary credential">
                                                    CCR</button>
                                            </div><?php
                                        }
                                    }?>

                                    <input name="qual_counter" id="qual_counter" type="hidden" value="<?php echo $qual_counter; ?>" />
                                </div>
                            </div><?php
                            						
                            if ($number_of_cat_selected > 0)
                            {
                                if(substr($cEduCtgId_01, 0, 2) == 'OL' && $number_of_cat_selected > 1)
                                {?>
                                    <script language="JavaScript" type="text/javascript">
                                        caution_inform('You cannot add more than two qualifications in this category');
                                    </script><?php
                                    $cEduCtgId_01 = '';
                                }else if(substr($cEduCtgId_01, 0, 2) <> 'OL' && $number_of_cat_selected > 0)
                                {?>
                                     <script language="JavaScript" type="text/javascript">
                                        caution_inform('You cannot add more than one qualifications in this category');
                                    </script><?php
                                    $cEduCtgId_01 = '';
                                }
                            }
						
                            if (isset($_REQUEST['ope_mode']) && $_REQUEST['ope_mode'] == '1')
                            {?>
                                <script language="JavaScript" type="text/javascript">
                                    inform('Qualification succesfully deleted');
                                </script><?php
                            }
                            
                            $dsplay_qual_header = 'none';
                            if (isset($_REQUEST["ccr_qual"]) && $_REQUEST["ccr_qual"] == '' && isset($_REQUEST["ope_mode"]) && $_REQUEST["ope_mode"] <> '' &&  $_REQUEST["ope_mode"] <> 'c' && $_REQUEST["ope_mode"]<>'d' && isset($_REQUEST["cQualCodeId"]) && $_REQUEST["cQualCodeId"] <> 'others')
                            {
                                $dsplay_qual_header = 'flex';
                            }
                            
                            $input_status = '';
                            if (isset($_REQUEST['ope_mode']) && $_REQUEST['ope_mode'] == 'v')
                            {
                                $input_status = ' readonly';
                            }?>

                            <div id="cQualCodeId_div" class="appl_left_child_div_child" style="display:<?php echo $dsplay_qual_header;?>;">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    1
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cQualCodeId">Qualification</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff"><?php	
                                if ($cEduCtgId == 'ELX')
                                {
                                    $sql="SELECT cQualCodeId,vQualCodeDesc,cEduCtgId from qualification where cQualCodeId in ('201', '202','203','204', '207') and cDelFlag = 'N' order by cEduCtgId, vQualCodeDesc;";
                                }else
                                {
								    $sql="SELECT cQualCodeId,vQualCodeDesc,cEduCtgId from qualification where cQualCodeId in ('201', '202','203','204', '207', '411', '412','401', '402', '431', '408','601','701','801','804') and cDelFlag = 'N' order by cEduCtgId, vQualCodeDesc;";
                                }
								$rsql=mysqli_query(link_connect_db(), $sql)or die("error: ".mysqli_error(link_connect_db()));?>
								<SELECT name="cQualCodeId" id="cQualCodeId" style="height:100%;"
									onchange="if (ope_mode.value=='v')
                                    {
                                        this.value=hdcQualCodeId.value;
                                        caution_inform('You must click the Edit button before you can make changes');
                                        return false;
                                    }else if (ope_mode.value=='e' || ope_mode.value=='a')
                                    {
                                        if (entered_Ol_qualifications.value > 1 && this.value.indexOf('20') > -1)
                                        {
                                            caution_inform('You can only enter a maximum of 2 Olevel qualifications');
                                            return false;
                                        }
                                        
                                        if (ope_mode.value=='e' && this.value.substr(0,2) != hdcQualCodeId.value.substr(0,2))
                                        {
                                            caution_inform('Changes are only allowed within the same category of qualification');
                                            this.value=hdcQualCodeId.value;
                                            return false;
                                        }
                                        
                                        if (this.value.indexOf('20') > -1)
                                        {
                                            if (this.value!='')
                                            {
                                                _('cQualCodeId_desc').value = this.options[this.selectedIndex].text;
                                            }
                                        }
                                    }
									in_progress('1');
									ps.submit();
									return false;" required <?php echo $input_status;?>>
									<option value="" selected="selected"></option><?php
									$prevCat = '';
									while ($table = mysqli_fetch_array($rsql))
									{
										if ($prevCat <> '' && $prevCat <> $table['cEduCtgId'] && is_bool(strpos($table['cEduCtgId'],"OL")) && is_bool(strpos($table['cEduCtgId'],"AL")))
										{?>
											<option value="" disabled="disabled">------------------------------------------------------------------------------</option><?php
										}?>
										<option value="<?php echo $table['cQualCodeId']; ?>"<?php if ((isset($_REQUEST["cQualCodeId"]) && $_REQUEST["cQualCodeId"] == $table['cQualCodeId'])){echo " selected";}else if(isset($cQualCodeId_01) && $table['cQualCodeId'] == $cQualCodeId_01){echo " selected";}?>>
										<?php echo $table['vQualCodeDesc'] ;?></option><?php
										if ($table['cEduCtgId'] == 'ELZ')
										{?>
											<option value="" disabled="disabled">------------------------------------------------------------------------------</option><?php
										}
										$prevCat = $table['cEduCtgId'];
									}
                                    mysqli_close(link_connect_db());
                                    
                                    if (isset($cEduCtgId) && $cEduCtgId == 'ELX')
                                    {?>
                                        <option value="" disabled="disabled">------------------------------------------------------------------------------</option>
                                        <option value="others" <?php if (isset($_REQUEST["cQualCodeId"]) && $_REQUEST["cQualCodeId"] == 'others'){echo " selected";}else if(isset($cQualCodeId_01) && isset($_REQUEST["cQualCodeId"]) && $_REQUEST['cQualCodeId'] == $cQualCodeId_01){echo " selected";}?>>Others</option><?phP
                                    }?>
								</SELECT>
								<input name="hdcQualCodeId" id="hdcQualCodeId" type="hidden" value="<?php if ((isset($_REQUEST["cQualCodeId"]) && $_REQUEST["cQualCodeId"] <> '')){echo $_REQUEST["cQualCodeId"];}?>" />
                                </div>
                            </div>
                            
                            <div id="vExamNo_div" class="appl_left_child_div_child" style="display:<?php echo $dsplay_qual_header;?>;">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    2
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="vExamNo"><?php
                                    if (isset($_REQUEST["cQualCodeId"]))
                                    {
                                        if (substr($_REQUEST["cQualCodeId"], 0, 2) == '20')
                                        {
                                            echo 'Candidate number';
                                        }elseif ($_REQUEST["cQualCodeId"] == '411' || $_REQUEST["cQualCodeId"] == '601')
                                        {
                                            echo 'Matriculation nunmber';
                                        }else if (substr($_REQUEST["cQualCodeId"], 0, 1) == '4')
                                        {
                                            echo 'Registration number';
                                        }else
                                        {
                                            echo 'Candidate number or Matric number';
                                        }
                                    }else
                                    {
                                        echo 'Candidate number or Matric number';
                                    }?></label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="vExamNo" id="vExamNo" type="text"
                                        maxlength="15"
                                        value="<?php if (isset($_REQUEST["vExamNo"])){echo $_REQUEST["vExamNo"];}?>" 
                                        onclick="if (ope_mode.value=='v')
                                        {
                                            caution_inform('You must click the Edit button if you want to make changes');
                                        }"
                                        onblur="this.value=this.value.toUpperCase(); get_ol_subjects()" 
                                        onChange="this.value=this.value.replace(/ /g, '');
                                        this.value=this.value.replace(/[&\/\\#, +()$~%.':*?<>{}]/g, '_');" required <?php echo $input_status;?> />
                                    <input name="hdvExamNo" id="hdvExamNo" type="hidden" value="<?php if (isset($_REQUEST["vExamNo"])){echo $_REQUEST["vExamNo"];}?>" />
                                </div>
                            </div>
                            
                            <div id="vExamSchoolName_div" class="appl_left_child_div_child" style="display:<?php echo $dsplay_qual_header;?>;">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    3
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="vExamSchoolName"><?php
                                        if (isset($_REQUEST["cQualCodeId"]) && substr($_REQUEST["cQualCodeId"], 0, 2) == '20')
                                        {
                                            echo 'Name of institution or centre number';
                                        }else
                                        {
                                            echo 'Name of institution';
                                        }?>
                                    </label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                <input name="vExamSchoolName" id="vExamSchoolName" type="text"
                                maxlength="70"
								style="text-transform:none" 
                                onclick="if (ope_mode.value=='v')
                                {
                                    caution_inform('You must click the Edit button if you want to make changes');
                                }"
                                onChange="this.value=this.value.trim();
                               /*this.value=this.value.replace(/\s+/g, ' ');*/
                                this.value=this.value.trim();
                                this.value=capitalizeEachWord(this.value)" value="<?php if (isset($_REQUEST["vExamSchoolName"])){echo $_REQUEST["vExamSchoolName"];}?>" required <?php echo $input_status;?>/>
                                </div>
                            </div>

                            <div id="month_div" class="appl_left_child_div_child" style="display:<?php echo $dsplay_qual_header;?>;">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    4
                                </div>
                                <div style="flex:25%; padding-left:5px; height:50px; background-color: #ffffff">
                                    <label for="month">Date of qualification</label>
                                </div>
                                <div style="flex:70%; height:50px; text-align:justify;  background-color: #ffffff">
                                    <?php $current=getdate();?>
                                    <SELECT name="month" id="month" style="width:49%; height:100%" 
                                        onchange="if (ope_mode.value=='v')
                                        {
                                            this.value=hdmonth.value;
                                            caution_inform('You must click the Edit button before you can make changes');
                                            return false;
                                        }
                                        cExamMthYear.value=this.value+year.value;
                                        ps.sbtd_pix.value='';
                                        get_ol_subjects();" required <?php echo $input_status;?>>
                                        <option value="" selected="selected">mm</option><?php
                                        for($i=1;$i<=12;$i++)
                                        {?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>"<?php if (isset($_REQUEST["cExamMthYear"]) && str_pad($i, 2, "0", STR_PAD_LEFT) == substr($_REQUEST["cExamMthYear"],0,2)){echo " selected";}?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT);?></option><?php
                                        }?>
                                    </SELECT>
								    <input name="hdmonth" id="hdmonth" type="hidden" value="<?php if ((isset($_REQUEST["cExamMthYear"]) && $_REQUEST["cExamMthYear"] <> '')){echo substr($_REQUEST["cExamMthYear"],0,2);}?>" />

                                    <SELECT name="year" id="year" style="width:49%; height:100%" 
                                        onchange="if (ope_mode.value=='v')
                                        {
                                            this.value=hdyear.value;
                                            caution_inform('You must click the Edit button before you can make changes');
                                            return false;
                                        }
                                        cExamMthYear.value=month.value+this.value;ps.sbtd_pix.value='';
                                        get_ol_subjects()"
                                        title="The least year displayed here is with reference to your year of birth" required <?php echo $input_status;?>>
                                        <option value="" selected="selected">yyyy</option><?php
                                        for($i=($dBirthYear+13);$i<=$current['year'];$i++)
                                        {?>
                                            <option value="<?php echo $i; ?>"<?php if (isset($_REQUEST["cExamMthYear"]) && $i == substr($_REQUEST["cExamMthYear"],2,4)){echo " selected";}?>> <?php echo $i ;?></option><?php
                                        }?>
                                    </SELECT>
								    <input name="hdyear" id="hdyear" type="hidden" value="<?php if ((isset($_REQUEST["cExamMthYear"]) && $_REQUEST["cExamMthYear"] <> '')){echo substr($_REQUEST["cExamMthYear"],2,4);}?>" />
                                    <input name="cExamMthYear" id="cExamMthYear" type="hidden" value="<?php if (isset($_REQUEST["cExamMthYear"])){echo $_REQUEST["cExamMthYear"];}?>" />
                                </div>
                            </div>
                            
                            <div id="sbtd_pix_div" class="appl_left_child_div_child" style="margin-top:10px; display:<?php echo $dsplay_qual_header;?>">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">5</div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="sbtd_pix">Upload copy of certificate</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff"><?php
                                    if (isset($_REQUEST["cQualCodeId"]) && $_REQUEST["cQualCodeId"] <> '')
                                    {
                                        $credent_loaded = credential_loaded($vApplicationNo, $_REQUEST["cQualCodeId"], $_REQUEST["vExamNo"]);
                                    }?>
                                    <input name="credentialLoaded" id="credentialLoaded" type="hidden" value="<?php echo $credent_loaded;?>"/>
                                    
                                    <input type="file" name="sbtd_pix" id="sbtd_pix" style="width:180px" title="Max size: 100KB, Acceptable format: JPG" <?php if ($credent_loaded == 0){echo 'required';}?>>
                                </div>
                            </div>
                            
                            <div id="subject_list_btn_div" class="appl_left_child_div_child" style="display:none;">
                                <div id="access_btn_div" style="flex:100%; display:flex; justify-content:flex-end; gap:4px; height:50px; background-color: #eff5f0">
                                    <div class="data_line_child data_line_child_logout" style="text-align:center; margin: 0px;">
                                        <button type="button" class="button" style="padding:7px; border:1px solid #b6b6b6;" 
                                            onclick="get_ol_subjects();
                                                return false;">
                                            <img width="20" height="17" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'subject_list.png');?>" alt="Cancel">
                                        See subject list</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="qual_sbj_div" class="appl_left_child_div_child" style="margin-top:10px; display:<?php echo $dsplay_qual_header;?>">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff"></div>
                                <div style="flex:95%; padding-left:4px; height:50px; background-color: #ffffff; font-weight:bold">
                                    Qualification subject(s)
                                </div>
                            </div>
                            
                            <?php require_once("olevel_subject.php");?>

                            <div id="sub_div" style="display:flex;
                                flex-flow: row; 
                                gap:4px;                               
                                flex:100%;
                                height:auto; 
                                margin-top:10px; 
                                margin-bottom:10px;"><?php 
                                    if (isset($_REQUEST["ope_mode"]) && $_REQUEST["ope_mode"] == 'a')
                                    {
                                        $show = 'block';
                                    }else
                                    {
                                        $show = 'none';
                                    }?>
                                    <button id="sub_btn" type="submit" class="login_button" onclick="chk_inputs();" style="display:<?php echo $show;?>">Save</button><?php
                                    
                                    if ((!isset($_REQUEST["ope_mode"]) || (isset($_REQUEST["ope_mode"]) && $_REQUEST["ope_mode"] == '')) && $number_of_quals > 0)
                                    {
                                        $show = 'block';
                                    }else
                                    {
                                        $show = 'none';
                                    }?>
                                    <button id="next_btn" type="button" class="rec_pwd_button" style="display:<?php echo $show;?>;border:1px solid #cccccc;" 
                                        onclick="if(_('entered_Ol_qualifications').value==0)
                                        {
                                            caution_inform('Please add your Olevel qualification');
                                            return false   
                                        }

                                        if (ps.cEduCtgId.value == 'PGX')//PGD
                                        {
                                            if (_('can_go_next').value < 1)
                                            {
                                                caution_inform('Please add your first degree or HND qualification(s)');
                                                return false   
                                            }
                                        }else if (ps.cEduCtgId.value == 'PGY')//Masters
                                        {
                                            if (_('can_go_next').value < 1)
                                            {
                                                caution_inform('Please add your first degree qualification(s)');
                                                return false   
                                            }
                                        }else if (ps.cEduCtgId.value == 'PRX' || ps.cEduCtgId.value == 'PGZ')//PhD. MPhil
                                        {
                                            if (_('can_go_next').value < 2)
                                            {
                                                caution_inform('Please add your first and Masters degree qualification(s)');
                                                return false   
                                            }
                                        }else if (_('can_go_next').value == 0)
                                        {
                                            caution_inform('Please add your higher qualification(s)');
                                            return false   
                                        }

                                        ps.action='programme-of-choice';
                                        ps.sidemenu.value = '6';
                                        ps.submit();
                                        return false;" >Next</button>
                            </div>
                            
                                        
                            <script>
                                set_rec_mgt_btn();
                                
                                function set_rec_mgt_btn()
                                {
                                    _('edit_qual_div').style.display='none';
                                    _('del_qual_div').style.display='none';
                                    _('cancel_add_div').style.display='none';
                                    _('add_qual_div').style.display='none';
                                    _('show_all_div').style.display='none';

                                    _('sub_btn').style.display='none';
                                    _('next_btn').style.display='none';

                                    if (_('number_of_quals').value > 0 && (_('ope_mode').value == 'c' || _('ope_mode').value == 'v' || _('ope_mode').value == ''))
                                    {
                                        _('next_btn').style.display='block';
                                    }
                                    
                                   if (_('ope_mode').value == 'v')
                                    {
                                        _('add_qual_div').style.display='block';
                                        _('del_qual_div').style.display='block';
                                        _('edit_qual_div').style.display='block';
                                    }else if (_('ope_mode').value == 'a')
                                    {
                                        _('cancel_add_div').style.display='block';
                                        _('show_all_div').style.display='block';
                                        _('cQualCodeId_div').style.display='flex';
                                        _('cQualCodeId').readonly=false;

                                        _('sub_btn').style.display='block';
                                    }else if (_('ope_mode').value == 'e' || _('ope_mode').value == 'd')
                                    {
                                        _('cancel_add_div').style.display='block';
                                        _('sub_btn').style.display='block';

                                        with (ps)
                                        {
                                            for (var c = 0; c <= elements.length-1; c++)
                                            {
                                                if (elements[c].type == 'select-one' ||
                                                elements[c].type == 'text' ||
                                                elements[c].type == 'file')
                                                {
                                                    elements[c].readOnly = false;
                                                    elements[c].disabled = false;
                                                }
                                            }
                                        }
                                    }else if (_('ope_mode').value == 'c' || _('ope_mode').value == '')
                                    {
                                        _('add_qual_div').style.display='block';
                                        
                                        if (_('ope_mode').value == 'e')
                                        {
                                            _('edit_qual_div').style.display='block';
                                        }else
                                        {
                                            _('cQualCodeId_div').style.display='none';
                                            _('vExamNo_div').style.display='none';
                                            _('vExamSchoolName_div').style.display='none';
                                            _('month_div').style.display='none';
                                            _('sbtd_pix_div').style.display='none';
                                            _('qual_sbj_div').style.display='none';
                                        }
                                    }
                                }
                            </script>
                        </form><?php
                    }?>
                </div>
            </div>
        </div>
	</body>
</html>