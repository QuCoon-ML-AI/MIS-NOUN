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
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php
	require_once('var_colls.php');

	$currency = 1;

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
	<link rel="icon" type="image/ico" href="./img/p_.png" />
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
			
		function chk_inputs()
		{
			var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
			for (j = 0; j <= ulChildNodes.length-1; j++)
			{
				ulChildNodes[j].style.display = 'none';
			}

            if (_("conf_box_loc").style.display == 'block')
            {
                if (_('veri_token').value == '')
                {
                    setMsgBox('labell_msg_token','Token required');
                    return false;
                }
               
               _("labell_msg_token").style.display = 'none';
                
                if (sc_1_loc.cProgrammeId_02.value.indexOf("CHD") > -1)
                {
                    if (!_('name_check0').checked ||
                    !_('pix_check').checked ||
                    _('certh_check').value == -1)
                    {
                        caution_box('Either you check at least three of the confirmation boxes or you advise candidate accordingly');
                        return false;
                    }
                }else if (!_('name_check').checked ||
                !_('pix_check').checked || 
                !_('o_level_sit').checked ||
                !_('prog_check').checked || 
                !_('o_subject').checked ||
                (_('other_cred') && !_('other_cred').checked))
                {
                    caution_box('Either you check all the confirmation boxes or you advise candidate accordingly');
                    return false;
                }

                if (_("hd_deg_appl_cat") && _("hd_deg_appl_cat").value == 0)
                {
                    caution_box('Please select type of candidate');
                    return false;
                }
            }else if (sc_1_loc.uvApplicationNo.value == '')
            {
                setMsgBox("labell_msg0","");
                sc_1_loc.uvApplicationNo.focus();
                return false;
            }else
            {
                in_progress('1');
                sc_1_loc.submit();
                return false;
            }
            
            var formdata = new FormData();
            
			formdata.append("whattodo", _("whattodo").value);
		
            if (sc_1_loc.conf.value == '1')
            {
                formdata.append("conf", sc_1_loc.conf.value);
            }
            
            if (sc_1_loc.resend_req.value == '1')
            {
                formdata.append("resend_req", sc_1_loc.resend_req.value);
            }

            if (_("hd_deg_appl_cat"))
            {
                formdata.append("deg_appl_cat", _("hd_deg_appl_cat").value);
            }
		
            formdata.append("ilin", sc_1_loc.ilin.value);
            formdata.append("user_cat", sc_1_loc.user_cat.value);
            
            formdata.append("uvApplicationNo", sc_1_loc.uvApplicationNo.value);

            formdata.append("vApplicationNo", sc_1_loc.vApplicationNo.value);
            formdata.append("sm", sc_1_loc.sm.value);
            formdata.append("mm", sc_1_loc.mm.value);
            
		    formdata.append("staff_study_center", sc_1_loc.user_centre.value);
		    formdata.append("user_token", _('veri_token').value);

		    formdata.append("cEduCtgId", sc_1_loc.cEduCtgId_03.value);
            
		    opr_prep(ajax = new XMLHttpRequest(),formdata);
		}
		

        function call_image()
        {
            var formdata = new FormData();
            
            with(ps)
            {
                formdata.append("loadcred",'1');
                formdata.append("user_cat", user_cat.value);
                
                formdata.append("vApplicationNo", uvApplicationNo.value);
                
                formdata.append("vExamNo", vExamNo.value);
                formdata.append("cQualCodeId", cQualCodeId.value);
            }
            
            opr_prep(ajax = new XMLHttpRequest(),formdata);
        }

	
        function opr_prep(ajax,formdata)
        {
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            
            if (ps.loadcred.value == '1')
            {
                ajax.open("POST", "../appl/opr_s5.php");
            }else
            {
                ajax.open("POST", "opr_veri_cred.php");
            }
            ajax.send(formdata);
        }
        
        function progressHandler(event)
        {
            in_progress('1');
        }

        function errorHandler(event)
        {
            on_error('1');
        }
        
        function abortHandler(event)
        {
            on_abort('1');
        }

        function completeHandler(event)
        {
            on_error('0');
            on_abort('0');
            in_progress('0');

            var returnedStr = event.target.responseText;
            
            if (returnedStr == 'Invalid token')
            {
                setMsgBox('labell_msg_token','Invalid token');
            }else if (ps.loadcred.value == 1)
            {
                if (returnedStr.indexOf("credential not uploaded") != -1)
                {
                    caution_box(returnedStr);
                }else
                {
                    _("credential_img").src = returnedStr;
                    _("credential_img").style.display = 'block';
                    _("container_cover_in").style.zIndex = 3; 
                    _("container_cover_in").style.display = 'block';
                     
                    
                    _('smke_screen_2').style.display = 'block';
                    _('smke_screen_2').style.zIndex = '2';
                    
                    _("close_cert_container").focus();
                }
            }else if (_("whattodo"))
		    { 
                var plus_ind = returnedStr.indexOf("+");
                var ash_ind = returnedStr.indexOf("#");
                
                returnedStr = returnedStr.substr(ash_ind+1);
                returnedStr = returnedStr.trim();
                
                _("labell_msg_token").style.display = 'none';

                if (returnedStr.charAt(0) == 'x')
                {
                    success_box(returnedStr.substr(1));
                    
                    //_("hd_veri_token").value = '';
                    _("veri_token").value = '';
                    
                    //_("labell_msg_token").style.display = 'none';
                    _('conf_box_loc').style.display = 'none';
                    _('conf_box_loc').style.zIndex = '-1';
                    _('smke_screen_2').style.display = 'none';
                    _('smke_screen_2').style.zIndex = '-1';
                }else  if (returnedStr.indexOf("?") != -1)
                {
                    //_("conf_msg_msg_loc").innerHTML = returnedStr.substr(returnedStr.indexOf("#")+7);
                    _('conf_box_loc').style.display = 'block';
                    _('conf_box_loc').style.zIndex = '3';
                    _('smke_screen_2').style.display = 'block';
                    _('smke_screen_2').style.zIndex = '2';

                    //_("hd_veri_token").value = returnedStr.substr(0,6);
                }else
                {
                    caution_box(returnedStr);
                    if (returnedStr.indexOf("exhuasted") != -1 || returnedStr.indexOf("expired") != -1)
                    {
                        //_('resend_token_div').style.display = 'block';
                        //_("labell_msg_token").style.display = 'none';
                    }
                }
                
                
                _('name_check').checked = false;
                _('pix_check').checked = false;
                _('o_level_sit').checked = false;
                _('prog_check').checked = false;
                _('o_subject').checked = false;

                if (_('other_cred'))
                {
                    _('other_cred').checked = false;
                }

                _("deg_appl_cat1").checked = false;
                _("deg_appl_cat2").checked = false;
                _("deg_appl_cat3").checked = false;
                
                _("hd_deg_appl_cat").value = '';
                
                sc_1_loc.resend_req.value = '';
                sc_1_loc.conf.value = ''
                
                ps.loadcred.value == '';
            }
        }
	</script>
	<noscript></noscript>
</head>


<body onLoad="checkConnection()"><?php
    $stmt = $mysqli->prepare("SELECT sRoleID
    FROM role_user
    WHERE sRoleID = 35
    AND vUserId = ?");
    $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
    $stmt->execute();
    $stmt->store_result();
    $sRoleID_cemba = $stmt->num_rows;

    $stmt = $mysqli->prepare("SELECT f_type FROM pics WHERE cinfo_type = 'C' AND vApplicationNo = ? LIMIT 1");
    $stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($f_type);
    $stmt->fetch();
    if (is_null($f_type))
    {
        $f_type = '';
    }
    
    $f_name = '';
    if ($f_type == 'f')
    {
        //compose file name
        $f_name = call_f_file();
    }?>

    <div class="cert_img_container" id="container_cover_in" 
        style="display:none;">
        <div id="inner_submityes_header0" style="width:50px;
            height:15px;
            padding:3px; 
            float:right; 
            text-align:right;
            z-Index:-1;">
                <a id="close_cert_container" href="#"
                    onclick="_('container_cover_in').style.display = 'none';
                    _('container_cover_in').style.zIndex = -1;
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
            z-index:-1;
            position:absolute;
            display:block;"><?php
            if ($f_type == 'g')
            {?>
                <img id="credential_img" style="width:100%; height:100%; display:none" src=""/><?php
            }else if ($f_type == 'f')
            {?>
                <iframe id="credential_img" src="<?php echo $f_name;?>" style="width:100%; height:100%;" frameborder="0"></iframe><?php
            }?>
        </div>
    </div>
    <?php admin_frms(); $has_matno = 0;?>
	
	<div id="container"><?php
	    $show = 'none';
        	
        $stmt = $mysqli->prepare("SELECT a.cSbmtd, a.cFacultyId, a.iBeginLevel, a.cProgrammeId, c.vObtQualTitle, b.vProgrammeDesc, b.cdeptId, a.vLastName, a.vFirstName, a.vOtherName, a.cStudyCenterId, a.cEduCtgId
        FROM prog_choice a, programme b, obtainablequal c 
        WHERE a.cProgrammeId = b.cProgrammeId
        AND b.cObtQualId = c.cObtQualId
        AND a.vApplicationNo = ?");
        $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cSbmtd_02, $cFacultyId_03, $iBeginLevel_02, $cProgrammeId_02, $vObtQualTitle_02, $vProgrammeDesc_02, $cdeptId, $vLastName_02, $vFirstName_02, $vOtherName_02, $cStudyCenterId, $cEduCtgId_03);
        $stmt->fetch();

        $stmt = $mysqli->prepare("SELECT vMatricNo
        FROM afnmatric
        WHERE vApplicationNo = ?");
        $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
        $stmt->execute();
        $stmt->store_result();
        $given_mat_not = $stmt->num_rows;
        $stmt->bind_result($vMatricNo);
        $stmt->fetch();

        if (is_null($vMatricNo))
        {
            $vMatricNo = '';
        }
        
        if (is_null($cStudyCenterId))
        {
            $cStudyCenterId = '';
        }

        if (is_null($cProgrammeId_02))
        {
            $cProgrammeId_02 = '';
        }
        
        $err = 0;
	    
	    if (isset($_REQUEST["sbt_clk"]) && isset($_REQUEST["user_centre"]) && !(isset($_REQUEST["centre_select"]) && $_REQUEST["centre_select"] == '1'))
	    {
    		$stmt = $mysqli->prepare("SELECT * FROM pics WHERE cinfo_type = 'p' AND vApplicationNo = ?");
            $stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
            $stmt->execute();
            $stmt->store_result();
            $pp_uploaded = $stmt->num_rows;
                        
            $stmt = $mysqli->prepare("SELECT * FROM afnmatric WHERE vApplicationNo = ?");
            $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
            $stmt->execute();
            $stmt->store_result();
            $has_mat_no = $stmt->num_rows;
            
            if (is_null($cSbmtd_02))
            {
                $cSbmtd_02 = '';
            }

	        $stmt = $mysqli->prepare("SELECT * FROM prog_choice WHERE vApplicationNo = ?");
            $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
            $stmt->execute();
            $stmt->store_result();
            
            if ($stmt->num_rows == 0)
            {
                $err = 1;
                caution_box('Invalid application form number');
            }else if ($cStudyCenterId == '' || $cProgrammeId_02 == '')
            {
                $err = 1;
                caution_box('Form not completed and therefore not available for verification.');
            }else if (is_bool(strpos($_REQUEST["user_centre"], $cStudyCenterId)))
            {
                $err = 1;
                caution_box('Your study centre does not match that of the candidate<br>Direct candidate to his/her study centre for required actions');
            }else if ($sRoleID_u == 29 && is_bool(strpos($cProgrammeId_02, 'CHD')))
            {
                $err = 1;
                caution_box('Application number must be that of a certificate candidate in CHRD');
            }else if ($sRoleID_u == 26 && is_bool(strpos($cProgrammeId_02, 'DEG')))
            {
                $err = 1;
                caution_box('Application number must be that of a certificate candidate in DE&GS');
            }else if ($cSbmtd_02 == '0' && $_REQUEST['sm'] == 4)
            {
                $err = 1;
                caution_box('Form not yet submitted');
            }else if ($_REQUEST['mm'] == 8 && $cEduCtgId_03 <> 'PGZ' && $cEduCtgId_03 <> 'PRX')
            {
                $err = 1;
                caution_box('Application form number must be that of an MPhil or PhD');
            }else if ($_REQUEST['mm'] == 1 && ($cEduCtgId_03 == 'PGZ' || $cEduCtgId_03 == 'PRX'))
            {
                $err = 1;
                caution_box('Application form number must be that of an undergraduate, PGD or Masters candidate');
            }else if ($cSbmtd_02 == '2' && $given_mat_not <> 0)
            {
                $err = 1;
                caution_box('Candidate already verified<br>'.$vMatricNo);
            }else if ($pp_uploaded == 0)
            {
                $err = 1;
                caution_box('Applicant to upload a valid passport picture');
            }else if ($err == 0)
            {
	            $token = send_token('verifying credentials', '20');

                if ($token == 'NOUN official email required')
                {
                    $err = 1;
                    caution_box($token);
                }else
                {
                    $show = 'block';
                    
                    if ($given_mat_not == 0)
                    {
                        if ($cEduCtgId_03 == 'ELX')
                        {
                            if ($cFacultyId_03 == 'CHD')
                            {
                                assign_matno_cert_chd_admin();
                            }else
                            {
                                assign_matno_cert_admin();
                            }
                        }else
                        {                            
                            assign_matno_admin($cdeptId);
                        }
                        
                        
                    }
                }
            }

            $stmt->close();
	    }?>
	    
		<div id="smke_screen_2" class="smoke_scrn" style="z-index:2; display:<?php echo $show;?>"></div>
		
        <div id="conf_box_loc" class="center" style="display:<?php echo $show;?>; width:500px; text-align:center; padding:15px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; z-index:3">
			<div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
				Confirmation
			</div>
			<a href="#" style="text-decoration:none;">
				<div style="width:20px; float:left; text-align:center; padding:0px;"></div>
			</a>
			<div id="submityes0" 
                style="border-radius:3px; margin:auto; margin-top:30px; margin-bottom:5px; height:auto; width:99%; text-align:center; padding:15px 0px 15px 0px; background:#f1f1f1">
                <div style="width:auto; margin:auto; margin-bottom:5px; padding:0px; width:95%; float:none; line-height:2.0;">
                    Check your official e-mail in-box for a token to use for this session<br>Token expires in 60minutes
                </div>
                <div style="margin:auto; margin-top:10px; height:auto; text-align:center; padding:0px; width:95%;">
                    <input name="veri_token" id="veri_token" type="text" class="textbox" 
                    placeholder="Enter token here..."
                    autocomplete="off" 
                    style="float:none; width:50%; padding:5px; text-align:center; height:25px"/>
                    <div id="labell_msg_token" class="labell_msg blink_text orange_msg" style="float:none; text-align:center; display:none; width:50%; margin:auto; margin-top:10px;"></div>
                </div>
                
                <div id="resend_token_div" style="display:none; margin:auto; margin-top:10px; height:auto; text-align:center; padding:0px; width:95%;">
                    <a href="#" style="text-decoration:none;" 
    					onclick="sc_1_loc.resend_req.value = '1';chk_inputs(); return false">
    					<div class="submit_button_green" style="width:120px; margin:auto; padding:8px;">
    						Resend token
    					</div>
    				</a>
				</div>
            </div>
            
			<div style="border-radius:3px; margin:auto; margin-top:10px; margin-bottom:0px; height:22px; width:96%; padding:5px 0px 5px 0px;">
                <a href="#" style="text-decoration:none;" 
					onclick="_('sc_1_loc').action = '../appl/preview-form'; _('sc_1_loc').target='_blank'; _('sc_1_loc').submit(); return;">
					<div class="submit_button_brown" style="width:60px; margin:auto; padding:4px; margin-left:3px; font-size:10px; float:left">
						App. form
					</div>
				</a><?php
				
                if ($f_type == 'g')
                {
                    $cEduCtgId = ''; 
                    $cQualCodeId = ''; 
                    $vExamSchoolName = ''; 
                    $vExamNo = ''; 
                    $vQualCodeDesc = ''; 
                    $cExamMthYear = ''; 
                    $iQSLCount = '';

                    $stmt = $mysqli->prepare("SELECT b.cEduCtgId, b.cQualCodeId, a.vExamSchoolName, a.vExamNo, b.vQualCodeDesc, a.cExamMthYear, c.iQSLCount 
                    FROM applyqual a, qualification b, educationctg c 
                    WHERE a.cQualCodeId = b.cQualCodeId 
                    AND b.cEduCtgId = c.cEduCtgId 
                    AND vApplicationNo = ? ORDER BY right(a.cExamMthYear,4), left(a.cExamMthYear,2)");
                    $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($cEduCtgId, $cQualCodeId, $vExamSchoolName, $vExamNo, $vQualCodeDesc, $cExamMthYear, $iQSLCount);
                    $coun = $stmt->num_rows;

                    $cred_cnt = 0;
                    $prev_cred_cnt = 0;
                    while($stmt->fetch())
                    {
                        $qual_abrv = '';
                                                
                        if ($cQualCodeId == '201')
                        {
                            $qual_abrv = 'GCE';
                        }else if ($cQualCodeId == '202')
                        {
                            $qual_abrv = 'SSCE';
                        }else if ($cQualCodeId == '203')
                        {
                            $qual_abrv = 'NECO';
                        }else if ($cQualCodeId == '204')
                        {
                            $qual_abrv = 'NABTEB';
                        }else if ($cQualCodeId == '401')
                        {
                            $qual_abrv = 'GCE AL';
                        }else if ($cQualCodeId == '402')
                        {
                            $qual_abrv = 'IJMBAL';
                        }else if ($cQualCodeId == '408')
                        {
                            $qual_abrv = 'NCE';
                        }else if ($cQualCodeId == '431')
                        {
                            $qual_abrv = 'JUPEB';
                        }else if ($cQualCodeId == '412')
                        {
                            $qual_abrv = 'OND';
                        }else if ($cQualCodeId == '411')
                        {
                            $qual_abrv = 'HND';
                        }else if ($cQualCodeId == '701')
                        {
                            $qual_abrv = 'PGD';
                        }else if ($cQualCodeId == '801')
                        {
                            $qual_abrv = 'MD';
                        }else if ($cQualCodeId == '804')
                        {
                            $qual_abrv = 'AL NAB.';
                        }else if ($cQualCodeId == '601')
                        {
                            $qual_abrv = 'FD';
                        }?>
                        <a href="#" style="text-decoration:none;"
                            onclick="ps.vExamNo.value='<?php echo $vExamNo; ?>';
                            ps.cQualCodeId.value='<?php echo $cQualCodeId; ?>';
                            ps.loadcred.value='1';
                            call_image();
                            return false;">
                            <div class="submit_button_green" style="width:40px; margin:auto; padding:4px; margin-left:3px; font-size:10px; float:right">
                                <?php echo $qual_abrv;?>
                            </div>
                        </a><?php
                    }
                }else if ($f_type == 'f')
                {?>
                    <a href="#" style="text-decoration:none;"
                        onclick="_('container_cover_in').style.zIndex = 3; 
                        _('container_cover_in').style.display = 'block';                        
                        
                        _('smke_screen_2').style.display = 'block';
                        _('smke_screen_2').style.zIndex = '2';
                        
                        _('close_cert_container').focus();
                        return false;">
                        <div class="submit_button_green" style="width:auto; margin:auto; padding:4px; margin-left:3px; font-size:10px; float:right">
                            Credential(s)
                        </div>
                    </a><?php
                }?>
            </div><?php 
            if ($cFacultyId_03 == 'CHD')
            {?>
                <div id="conf_msg_msg_loc" style="margin-top:15px; width:100%; float:left; text-align:left; padding:0px;">
                    <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                        <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%; color:#fff">.</div>
                        <div style="float:left; width:91%; line-height:2; margin-left:0.5%; text-align:justify; font-weight:bold;">
                            Original certiifcates or documents have been uploaded to support the following:
                        </div>
                    </div>
                    
                    <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                        <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%;">
                            1
                        </div>
                        <div style="float:left; width:5%; line-height:2; text-align:left; padding-right:1%;">
                            <input type="checkbox" id="name_check0" name="name_check0">
                        </div>
                        <label for="name_check0">
                            <div style="float:left;  width:86%; line-height:2; margin-left:0.5%; text-align:justify;">
                                Names are the same as those on uploaded supporting document(s)
                            </div>
                        </label>
                    </div>
                    
                    <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                        <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%;">
                            2
                        </div>
                        <div style="float:left; width:5%; line-height:2; text-align:left; padding-right:1%;">
                            <input type="checkbox" id="pix_check" name="pix_check">
                        </div>
                        <label for="pix_check">
                            <div style="float:left;  width:86%; line-height:2; margin-left:0.5%; text-align:justify;">
                                Uploaded picture is a passport size picture with white or red backgorund
                            </div>
                        </label>
                    </div>
                    
                    <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                        <input type="hidden" id="certh_check" name="certh_check" value="-1">
                        <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%;">
                            3
                        </div>
                        <div style="float:left; width:5%; line-height:2; text-align:left; padding-right:1%;">
                            <input type="radio" id="cert1_check" name="cert_check" onclick="_('certh_check').value=1">
                        </div>
                        <label for="cert1_check">
                            <div style="float:left;  width:86%; line-height:2; margin-left:0.5%; text-align:justify;">
                                Skill/Experience testimonial or certificate
                            </div>
                        </label>
                    </div>
                    
                    <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                        <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%;">
                            4
                        </div>
                        <div style="float:left; width:5%; line-height:2; text-align:left; padding-right:1%;">
                            <input type="radio" id="cert2_check" name="cert_check" onclick="_('certh_check').value=2">
                        </div>
                        <label for="cert2_check">
                            <div style="float:left; width:86%; line-height:2; margin-left:0.5%; text-align:justify;" title="open-ended questions to evaluate understanding, problem-solving abilities and practical skills">
                                Interview Conversation is satisfactory
                            </div>
                        </label>
                    </div>
                    
                    <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                        <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%;">
                            5
                        </div>
                        <div style="float:left; width:5%; line-height:2; text-align:left; padding-right:1%;">
                            <input type="radio" id="cert3_check" name="cert_check" onclick="_('certh_check').value=3">
                        </div>
                        <label for="cert3_check">
                            <div style="float:left;  width:86%; line-height:2; margin-left:0.5%; text-align:justify;">
                                Recommendations from organization, community representatives, recognized industry/persons or associations.
                            </div>
                        </label>
                    </div>
                    
                    <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                        <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%;">
                            6
                        </div>
                        <div style="float:left; width:5%; line-height:2; text-align:left; padding-right:1%;">
                            <input type="radio" id="cert4_check" name="cert_check" onclick="_('certh_check').value=4">
                        </div>
                        <label for="cert4_check">
                            <div style="float:left;  width:86%; line-height:2; margin-left:0.5%; text-align:justify;">
                                Primary School Leaving Certificate/Qur’anic/Basic Education Certificate
                            </div>
                        </label>
                    </div>
                    
                    <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                        <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%;">
                            7
                        </div>
                        <div style="float:left; width:5%; line-height:2; text-align:left; padding-right:1%;">
                            <input type="radio" id="cert5_check" name="cert_check" onclick="_('certh_check').value=5">
                        </div>
                        <label for="cert5_check">
                            <div style="float:left;  width:86%; line-height:2; margin-left:0.5%; text-align:justify;">
                                Secondary School Leaving Certificate or higher
                            </div>
                        </label>
                    </div>
                </div><?php
            }else
            {?>            
                <div id="conf_msg_msg_loc" style="margin-top:15px; width:100%; float:left; text-align:left; padding:0px;">
                    <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                        <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%; color:#fff">.</div>
                        <div style="float:left; width:91%; line-height:2; margin-left:0.5%; text-align:justify; font-weight:bold;">
                            Original certificates have been uploaded to support the following:
                        </div>
                    </div>
                    
                    <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                        <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%;">
                            1
                        </div>
                        <div style="float:left; width:5%; line-height:2; text-align:left; padding-right:1%;">
                            <input type="checkbox" id="name_check" name="name_check">
                        </div>
                        <label for="name_check">
                            <div style="float:left;  width:86%; line-height:2; margin-left:0.5%; text-align:justify;">
                                The names on the application form are the same as those on the uploaded credentials
                            </div>
                        </label>
                    </div>
                    
                    <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                        <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%;">
                            2
                        </div>
                        <div style="float:left; width:5%; line-height:2; text-align:left; padding-right:1%;">
                            <input type="checkbox" id="pix_check" name="pix_check">
                        </div>
                        <label for="pix_check">
                            <div style="float:left;  width:86%; line-height:2; margin-left:0.5%; text-align:justify;">
                                Uploaded picture is a passport size picture with white or red backgorund
                            </div>
                        </label>
                    </div>
                    
                    <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                        <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%;">
                            3
                        </div>
                        <div style="float:left; width:5%; line-height:2; text-align:left; padding-right:1%;">
                            <input type="checkbox" id="o_level_sit" name="cred_auth_check">
                        </div>
                        <label for="o_level_sit">
                            <div style="float:left;  width:86%; line-height:2; margin-left:0.5%; text-align:justify;">
                                Olevel qualification obtained in not more than two sittings
                            </div>
                        </label>
                    </div>
                    
                    <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                        <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%;">
                            4
                        </div>
                        <div style="float:left; width:5%; line-height:2; text-align:left; padding-right:1%;">
                            <input type="checkbox" id="o_subject" name="o_subject">
                        </div>
                        <label for="o_subject">
                            <div style="float:left;  width:86%; line-height:2; margin-left:0.5%; text-align:justify;"><?php
                                if ($cEduCtgId_03 == 'ELX')
                                {
                                    echo "O'level qualification has at least three required subjects including English and Mathematics at minimum credit grade";
                                }else
                                {
                                    echo "O'level qualification has at least five required subjects including English and Mathematics at minimum credit grade";
                                }?>
                            </div>
                        </label>
                    </div>
                    
                    <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                        <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%;">
                            5
                        </div>
                        <div style="float:left; width:5%; line-height:2; text-align:left; padding-right:1%;">
                            <input type="checkbox" id="prog_check" name="prog_check">
                        </div>
                        <label for="prog_check">
                            <div style="float:left;  width:86%; line-height:2; margin-left:0.5%; text-align:justify;">
                                Selected programme at the selected level is the choice of the candidate
                            </div>
                        </label>
                    </div>
                    <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                        <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%;">
                            6
                        </div>
                        <div style="float:left; width:5%; line-height:2; text-align:left; padding-right:1%;">
                            <input type="checkbox" id="other_cred" name="other_cred">
                        </div>
                        <label for="other_cred">
                            <div style="float:left;  width:86%; line-height:2; margin-left:0.5%; text-align:justify;">
                                Other relevant credentials uploaded accordingly
                            </div>
                        </label>
                    </div><?php
                    
                    if ($cFacultyId_03 == 'DEG')
                    {?>
                        <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                            <div style="float:left; width:5%; line-height:2; text-align:right; padding-right:1%;">
                                7
                            </div>
                            <div style="float:left; width:90%; line-height:2; text-align:left; padding-right:1%;">
                                Type of candidate
                            </div>
                        </div>
                        <div style="margin-top:10px; width:100%; float:left; text-align:left; padding:0px;">
                            <div style="float:left; width:10%; line-height:2; text-align:right; padding-right:1%; color:#fff">.</div>
                            <div style="float:left;  width:80%; line-height:2; margin-left:0.5%; text-align:justify;">
                                <div style="float:left;  width:86%; line-height:2; margin-left:0.5%; text-align:justify;">
                                    <label for="deg_appl_cat1">
                                        <input type="radio" id="deg_appl_cat1" name="deg_appl_cat" onclick="if(this.checked){_('hd_deg_appl_cat').value=this.value}" value="1">
                                        Incubatee
                                    </label>
                                </div>
                                <div style="float:left;  width:86%; line-height:2; margin-left:0.5%; text-align:justify;">
                                    <label for="deg_appl_cat2">
                                        <input type="radio" id="deg_appl_cat2" name="deg_appl_cat" onclick="if(this.checked){_('hd_deg_appl_cat').value=this.value}" value="2">
                                        NOUN staff/Alumni
                                    </label>
                                </div>
                                <div style="float:left;  width:86%; line-height:2; margin-left:0.5%; text-align:justify;">
                                    <label for="deg_appl_cat3">
                                        <input type="radio" id="deg_appl_cat3" name="deg_appl_cat" onclick="if(this.checked){_('hd_deg_appl_cat').value=this.value}" value="3">
                                        Public
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" id="hd_deg_appl_cat" name="hd_deg_appl_cat" value = "0">
                        </div><?php
                    }?>
                </div><?php
            }?>

			<div style="margin-top:10px; width:100%; float:left; text-align:right; padding:0px;">
				<a href="#" style="text-decoration:none;" 
					onclick="ps.loadcred.value='0';
                    sc_1_loc.conf.value = '1';
                    chk_inputs(); return false">
					<div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
						Yes
					</div>
				</a>

				<a href="#" style="text-decoration:none;" 
					onclick="sc_1_loc.conf.value='';
                    _('conf_box_loc').style.display='none';
                    _('smke_screen_2').style.display='none';
                    _('smke_screen_2').style.zIndex='-1';
                    _('labell_msg0').style.display = 'none';
                    _('veri_token').value = '';
					return false">
					<div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
						No
					</div>
				</a>
			</div>
		</div><?php
		//time_out_box($currency);?>

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
            <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u ?>" />

            <div class="innercont_top" style="margin-bottom:0px;">Student's request - Verify credentials</div>
            
            <form method="post" name="ps" enctype="multipart/form-data">
                <input name="vApplicationNo" type="hidden" value="<?php if (isset($vApplicationNo)){echo $vApplicationNo;} ?>" />
                <input name="uvApplicationNo" id="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];}?>"/>
                <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
                
                <input name="vExamNo" id="vExamNo" type="hidden" />
                <input name="cQualCodeId" id="cQualCodeId" type="hidden" />
                <input name="loadcred" id="loadcred" type="hidden" />

                <input name="fil_ex" id="fil_ex" type="hidden" value="<?php echo $f_type; ?>" />
            </form>
                            
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
                <input name="currency_cf" id="currency_cf" type="hidden" value="<?php if ($currency=='1'){echo $currency;} ?>" />
                <input name="user_cEduCtgId" id="user_cEduCtgId" type="hidden" value="go"/>
                
                <input name="uvApplicationNo_loc" id="uvApplicationNo_loc" type="hidden" />
                <input name="app_frm_no" id="app_frm_no" type="hidden" />
                <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester; ?>" />
                <input name="whattodo" id="whattodo" type="hidden" value="<?php if(isset($_REQUEST['whattodo'])){echo $_REQUEST['whattodo'];}else{echo '';}?>" />
                
                <input name="process_step" id="process_step" type="hidden" value="" />
                <input name="resend_req" id="resend_req" type="hidden" value="" />
                <input name="user_token" id="user_token" type="hidden" value="" />
                
                <input name="cancel_perm" id="cancel_perm" type="hidden" value="" />
                <input name="sbt_clk" id="sbt_clk" type="hidden" value="1" />
                
                <input name="cEduCtgId_03" id="cEduCtgId_03" type="hidden" value="<?php echo $cEduCtgId_03;?>" />
                
                <input name="cProgrammeId_02" id="cProgrammeId_02" type="hidden" value="<?php echo $cProgrammeId_02;?>" />
                <input name="centre_select" id="centre_select" type="hidden" value="0" /><?php
                frm_vars();
                
                require_once("student_requests.php");
                
                if ($sRoleID_u == '26' || $_REQUEST['vApplicationNo'] == '05120' || $reg_open_100_200 == 1)
                {?>
                    <div class="innercont_stff" style="margin-top:20px;">
                        <div class="div_select" style="text-align:right">
                        Application form number (AFN)
                        </div>

                        <div id="uvApplicationNo_div" class="div_select">
                            <input name="uvApplicationNo" id="uvApplicationNo" type="number" class="textbox"  
                            placeholder="Enter AFN here..."
                            onchange="this.value=this.value.trim();
                            this.value=this.value.toUpperCase();"
                            onkeypress="if(this.value.length==8){return false}" required 
                            value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];}?>"/>
                            <input name="id_no" id="id_no" type="hidden" value="0" />
                        </div>
                        <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
                    </div><?php

                    $centre = '';

                    if (isset($_REQUEST["user_centre"]) && strlen($_REQUEST["user_centre"]) > 6)
                    {?>
                        <div class="innercont_stff" style="margin-top:20px;">
                            <div class="div_select" style="text-align:right">
                                Select centre
                            </div>

                            <div id="uvApplicationNo_div" class="div_select"><?php
                                $rs_sql = mysqli_query(link_connect_db(), "SELECT cStudyCenterId, vCityName FROM studycenter WHERE cDelFlag = 'N' ORDER BY vCityName") or die(mysqli_error(link_connect_db()));?>
                                <select name="selected_centre" id="selected_centre" class="select" 
                                    onchange="if (this.value != '')
                                    {
                                        _('centre_select').value='1';
                                        in_progress('1');
                                        _('sc_1_loc').action = '';
                                        _('sc_1_loc').target = '_self';
                                        _('sc_1_loc').submit();
                                    }">
                                    <option value="" selected>Select a centre</option><?php
                                    $c = 0;
                                    while ($rs = mysqli_fetch_array($rs_sql))
                                    {
                                        if (is_bool(strpos($_REQUEST["user_centre"], $rs['cStudyCenterId'])))
                                        {
                                            continue;
                                        }
                                        
                                        $c++;
                                        if ($c%5==0)
                                        {?>
                                            <option disabled></option><?php
                                        }?>
                                        <option value="<?php echo $rs['cStudyCenterId'];?>" <?php if (isset($_REQUEST["selected_centre"]) && $_REQUEST["selected_centre"] == $rs['cStudyCenterId']){echo 'selected';}?>><?php echo $rs['vCityName'];?></option><?php
                                    }
                                    mysqli_close(link_connect_db());?>
                                </select>
                            </div>
                        </div><?php

                        if (isset($_REQUEST["selected_centre"]) && $_REQUEST["selected_centre"] <> '')
                        {
                            $centre = $_REQUEST["selected_centre"];
                        }
                    }else if (isset($_REQUEST["user_centre"]) && $_REQUEST["user_centre"] <> '')
                    {
                        $centre = str_replace("|","",$_REQUEST["user_centre"]);
                    }

                    if ($centre <> '')
                    {
                        $prog_cond = '';
                        if ($sRoleID_cemba == 1)
                        {
                            $prog_cond = " and a.cProgrammeId IN ('MSC415','MSC416')";
                        }

                        $stmt = $mysqli->prepare("SELECT vApplicationNo , vLastName, vFirstName, vOtherName, b.vFacultyDesc
                        FROM prog_choice a, faculty b
                        WHERE a.cFacultyId = b.cFacultyId
                        and cSbmtd = '1'
                        $prog_cond
                        and cStudyCenterId = ?
                        ORDER BY b.vFacultyDesc");
                        $stmt->bind_param("s", $centre);
                        $stmt->execute();
                        $stmt->store_result();
                        $total_num = $stmt->num_rows;
                        $stmt->bind_result($vApplicationNo_loc, $vLastName, $vFirstName, $vOtherName, $vFacultyDesc);
                        
                        if ($total_num > 0)
                        {?>
                            <div class="innercont_stff" style="width:100%;">
                                <div class="div_select" style="width:1010px; height:25px; padding:5px; text-align:left;">
                                    Total: <?php echo $total_num;?>
                                </div>
                            </div>

                            <div class="innercont_stff" style="margin-bottom:0.5%; font-weight:bold; border:0px; background:#fff">
                                <div class="_label" style="border:0px; width:5%; height:auto; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:right; background:#fff">
                                    Sno
                                </div>
                                <div class="_label" style="border:0px; border-left:1px solid #cdd8cf; width:20%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left; background:#fff">
                                    Application form number
                                </div>
                                <div class="_label" style="border:0px; border-left:1px solid #cdd8cf; width:72.5%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left; background:#fff">
                                    Name
                                </div>
                            </div><?php
                                $c = 0;
                                $prev_faculty = '';
                                //for ($x = 1; $x < 15; $x++)
                                //{
                                while ($stmt->fetch())
                                {
                                    if ($prev_faculty == '' || $prev_faculty <> $vFacultyDesc)
                                    {?>                                    
                                        <div class="innercont_stff" style="margin-bottom:0.5%; font-weight:bold; border:0px; background:#fff">
                                            <div class="_label" style="border:0px; width:100%; height:auto; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left; background:#fff">
                                                <?php echo $vFacultyDesc;?>
                                            </div>
                                        </div><?php
                                    }?>
                                    <label for="app_<?php echo ++$c;?>" class="lbl_beh" for="mat_chk_all">
                                        <div class="innercont_stff" style="margin-bottom:0.5%; border:0px; background:#fff">
                                            <div class="_label" style="border:0px; width:5%; height:auto; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:right; background:#fff">
                                                <?php echo $c;?>
                                            </div>
                                            <div class="_label" style="border:0px; border-left:1px solid #cdd8cf; width:20%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left; background:#fff">
                                                <input name="app_radio_but" id="app_<?php echo $c;?>" type="radio" 
                                                onclick="if (this.checked){sc_1_loc.uvApplicationNo.value='<?php echo $vApplicationNo_loc;?>'}else{sc_1_loc.uvApplicationNo.value=''}"/>
                                                <?php echo $vApplicationNo_loc;?>
                                            </div>
                                            <div class="_label" style="border:0px; border-left:1px solid #cdd8cf; width:72.5%; height:auto; padding-left:3px; padding-top:8px; padding-bottom:8px; border-radius:0px; text-align:left; background:#fff">
                                                <?php echo $vLastName.' '.$vFirstName.' '.$vOtherName;?>
                                            </div>
                                        </div>
                                    </label><?php
                                    $prev_faculty = $vFacultyDesc;
                                //}
                                //$stmt->data_seek(0);
                                }
                                $stmt->close();
                        }else if ($err == 0 && isset($_REQUEST["selected_centre"]) && $_REQUEST["selected_centre"] <> '')
                        {
                            caution_box('There are no waiting candidates in the selected centre');
                        }
                    }
                }else
                {
                    caution_box('Issuing of matriculation number to resume when registration opens');
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
                <?php require_once ('stff_bottom_right_menu.php');?>
                <!-- InstanceEndEditable -->
            </div>
        </div>
        <div id="futa"><?php foot_bar();?></div>
	</div>
</body>
</html>