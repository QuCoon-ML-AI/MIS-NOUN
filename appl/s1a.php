<?php
require_once('good_entry.php');
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
		<script language="JavaScript" type="text/javascript" src="./bamboo/s1a.js"></script>
        <script language="JavaScript" type="text/javascript">
            function chk_inputs()
            {
                var letters = /^[A-Za-z '-]+$/;

                if (!_("vLastName").value.match(letters))
                {
                    caution_inform("Enter alphabets only for last name please");
                    return false;
                }

                if (_('vLastName').value.length < 3)
                {
                    caution_inform("Abrevition not allowed for last name");
                    return false;
                }


                if (!_("vFirstName").value.match(letters))
                {
                    caution_inform("Enter alphabets only for first name please");
                    return false;
                }
                
                if (_('vFirstName').value.length < 3)
                {
                    caution_inform("Abrevition not allowed for first name");
                    return false;
                }
                

                if (_('vOtherName').value.length > 0 && !_("vFirstName").value.match(letters))
                {
                    caution_inform("Enter alphabets only for other name please")
                    return false;
                }

                if (_('vOtherName').value.length > 0 && _('vOtherName').value.length < 3)
                {
                    caution_inform("Abrevition not allowed for other name")
                    return false;
                }
                
                if (_('cnin').value.length != 11)
                {
                    caution_inform("Invalid NIN")
                    return false;
                }

                
                var files = _("sbtd_pix").files;
                
                if (_("sbtd_pix").files.length > 0)
                {  
                    if (!fileValidation("sbtd_pix"))
                    {
                        caution_inform("Only JPG file format for passport picture is allowed");
                        return false;
                    }

                    max_size = _("max_size_of_pp").value * 1000
                    
                    if (files[0].size > max_size)
                    {                        
                        size = files[0].size/1000;
                        caution_inform("File too large. Max. size: 100KB. Attempted size: "+size+"KB")
                        return false;
                    }
                }
                
                if (_('name_warn').value == 0 && !_('vLastName').readOnly)
                {
                    caution_inform("Names can only be entered once. Ensure they are correct")

                    _('name_warn').value = 1;
                    return false;
                }
                
                var formdata = new FormData();
                formdata.append("save", '1');

                formdata.append("user_cat", ps.user_cat.value);
                formdata.append("vApplicationNo", ps.vApplicationNo.value);
                
                formdata.append("ilin",ps.ilin.value);

                formdata.append("vTitle", _("vTitle").value);
                formdata.append("vLastName", _("vLastName").value);
                formdata.append("vFirstName", _("vFirstName").value);
                formdata.append("vOtherName", _("vOtherName").value);
                formdata.append("cGender", _("cGender").value);
                
                formdata.append("cnin", _("cnin").value);
                formdata.append("dBirthDate", _("dBirthDate").value);
                formdata.append("cEduCtgId", ps.cEduCtgId.value);
                

                if (files.length > 0)
                {
                    formdata.append("sbtd_pix", _("sbtd_pix").files[0]);
                }

                opr_prep(ajax = new XMLHttpRequest(),formdata);   
            }
        </script>

        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/s1a.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
        require_once("feedback_mesages.php");
        require_once("forms.php");        
	    $mysqli = link_connect_db();

        $orgsetins = settns();
        
        $stmt = $mysqli->prepare("SELECT a.cEduCtgId, vFirstName, b.vEduCtgDesc FROM prog_choice a, educationctg b WHERE a.cEduCtgId  = b.cEduCtgId AND vApplicationNo = ?");
        $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
        $stmt->execute();
        $stmt->store_result();
        $local_record_of_payment1 = $stmt->num_rows;
        $stmt->bind_result($cEduCtgId, $vFirstName, $vEduCtgDesc);
        $stmt->fetch();

        if ($local_record_of_payment1 == 0)
        {
            $stmt = $mysqli->prepare("SELECT Amount, vDesc, vLastName, vFirstName, vOtherName, payerEmail, payerPhone, AcademicSession, cEduCtgId, MerchantReference,RetrievalReferenceNumber, Status, TransactionDate 
            FROM remitapayments_app 
            WHERE Regno = ?");
            $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($Amount_db, $vDesc_db, $vLastName_db, $vFirstName_db, $vOtherName_db, $payerEmail_db, $payerPhone_db, $AcademicSession_db, $cEduCtgId_1st, $orderId, $rrr, $Status, $dat);
            $local_record_of_payment2 = $stmt->num_rows;
            $stmt->fetch();
            
            if ($local_record_of_payment2 <> 0)
            {
                $stmt = $mysqli->prepare("INSERT IGNORE INTO prog_choice
                SET vApplicationNo = ?,
                cEduCtgId = ?,
                vLastName = ?,
                vFirstName = ?,
                vOtherName = ?,
                vEMailId = ?,
                vMobileNo = ?,
                dAmnt = ?,
                cAcademicDesc = '".$orgsetins['cAcademicDesc']."',
                resident_ctry = '1',
                in_mate = '0',
                trans_time = '$dat'");
                $stmt->bind_param("sssssssd", 
                $_REQUEST["vApplicationNo"],
                $cEduCtgId_1st, 
                $vLastName_db,
                $vFirstName_db, 
                $vOtherName_db, 
                $payerEmail_db, 
                $payerPhone_db, 
                $Amount_db);
                $stmt->execute();
            }
        }
		
        $vApplicationNo = '';

        $fetched_from_payment = 0;

        if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST["vApplicationNo"] <> '')
        {
            $vApplicationNo = $_REQUEST["vApplicationNo"];
        }else if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
        {
            $vApplicationNo = $_REQUEST["uvApplicationNo"];
        }
	
        $passpotLoaded = passport_loaded($vApplicationNo);
        
        $vTitle = ''; 
        $vLastName = ''; 
        $vFirstName = ''; 
        $vOtherName = ''; 
        $dBirthDate = ''; 
        $cGender = ''; 
        $cnin = '';

        if ($vApplicationNo <> '')
        {
            $stmt = $mysqli->prepare("SELECT 
            vTitle, 
            vLastName, 
            vFirstName, 
            vOtherName, 
            dBirthDate, 
            cGender,
            cnin FROM pers_info WHERE vApplicationNo = ?");
            
            $stmt->bind_param("s", $vApplicationNo);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($vTitle, 
            $vLastName, 
            $vFirstName, 
            $vOtherName, 
            $dBirthDate, 
            $cGender, 
            $cnin);
            $stmt->fetch();

            if (is_null($vLastName))
            {
                $vLastName = '';
            }

            if ($vLastName == '')
            {
                $stmt = $mysqli->prepare("SELECT 
                vLastName, 
                vFirstName, 
                vOtherName
                FROM remitapayments_app WHERE Regno = ?");
                
                $stmt->bind_param("s", $vApplicationNo);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($vLastName, 
                $vFirstName, 
                $vOtherName);
                $stmt->fetch();

                if (is_null($vLastName))
                {
                    $vLastName = '';
                }
                
                // if ($vLastName <> '')
                // {
                //     $fetched_from_payment = 1;
                // }
            }

            if ($vLastName == '')
            {
                $stmt = $mysqli->prepare("SELECT 
                vLastName, 
                vFirstName, 
                vOtherName
                FROM prog_choice WHERE vApplicationNo = ?");
                
                $stmt->bind_param("s", $vApplicationNo);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($vLastName, 
                $vFirstName, 
                $vOtherName);
                $stmt->fetch();
            }

            $stmt = $mysqli->prepare("SELECT a.cEduCtgId, b.vEduCtgDesc FROM prog_choice a, educationctg b WHERE a.cEduCtgId  = b.cEduCtgId AND vApplicationNo = ?");
            $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
            $stmt->execute();
            $stmt->store_result();
            $local_record = $stmt->num_rows;
            $stmt->bind_result($cEduCtgId, $vEduCtgDesc);
            $stmt->fetch();

            if ($local_record == 0)
            {
                $stmt = $mysqli->prepare("SELECT Amount, vDesc, vLastName, vFirstName, vOtherName, payerEmail, payerPhone, AcademicSession, cEduCtgId, MerchantReference,RetrievalReferenceNumber, Status, TransactionDate 
                FROM remitapayments_app 
                WHERE Regno = ?");
                $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($Amount_db, $vDesc_db, $vLastName_db, $vFirstName_db, $vOtherName_db, $payerEmail_db, $payerPhone_db, $AcademicSession_db, $cEduCtgId_1st, $orderId, $rrr, $Status, $dat);
                $local_record_of_payment = $stmt->num_rows;
                $stmt->fetch();
                
                if ($local_record_of_payment <> 0)
                {
                    $vLastName_db = addslashes($vLastName_db);
                    $vFirstName_db = addslashes($vFirstName_db);
                    $vOtherName_db = addslashes($vOtherName_db);
                    
                    $stmt = $mysqli->prepare("INSERT IGNORE INTO prog_choice
                    SET vApplicationNo = ?,
                    cEduCtgId = ?,
                    vLastName = ?,
                    vFirstName = ?,
                    vOtherName = ?,
                    vEMailId = ?,
                    vMobileNo = ?,
                    dAmnt = ?,
                    cAcademicDesc = '".$orgsetins['cAcademicDesc']."',
                    resident_ctry = '1',
                    in_mate = '0',
                    trans_time = '$dat'");
                    $stmt->bind_param("sssssssd", 
                    $_REQUEST["vApplicationNo"],
                    $cEduCtgId_1st, 
                    $vLastName_db,
                    $vFirstName_db, 
                    $vOtherName_db, 
                    $payerEmail_db, 
                    $payerPhone_db, 
                    $Amount_db);
                    $stmt->execute();
                }
            }
            
            $dBirthDate = formatdate($dBirthDate, 'fromdb');

            if ($dBirthDate == '')
            {
                $stmt = $mysqli->prepare("SELECT dateofbirth FROM prog_choice WHERE vApplicationNo = ?");
                $stmt->bind_param("s", $vApplicationNo);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($dBirthDate);
                $stmt->fetch();
                $dBirthDate = formatdate($dBirthDate, 'fromdb');
            }
                    
            $stmt = $mysqli->prepare("SELECT vMatricNo FROM afnmatric WHERE vApplicationNo = ?");
            $stmt->bind_param("s", $vApplicationNo);
            $stmt->execute();
            $stmt->store_result();
            $has_matric_num = $stmt->num_rows;
            
            if (isset($_REQUEST["studentID"]) && $_REQUEST["studentID"] <> '')
            {
                $stmt = $mysqli->prepare("SELECT a.vTitle, a.vLastName, a.vFirstName, a.vOtherName, a.dBirthDate, a.cGender, cnin FROM s_m_t a, pers_info b WHERE a.vApplicationNo = b.vApplicationNo AND vMatricNo = ?");
                $stmt->bind_param("s", $_REQUEST["studentID"]);
                $stmt->execute();
                $stmt->store_result();
                $has_pers_info = $stmt->num_rows;
                
                if ($has_pers_info > 0)
                {
                    $stmt->bind_result($vTitle, 
                    $vLastName, 
                    $vFirstName, 
                    $vOtherName, 
                    $dBirthDate, 
                    $cGender, 
                    $cnin);
                    $stmt->fetch();
                    $dBirthDate = formatdate($dBirthDate, 'fromdb');
                }
            }
            
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
                <div class="appl_left_child_div" style="text-align: left; width:98%; margin:auto; overflow:auto; margin-top:10px; background-color:#eff5f0">
                    <form action="appl-biodata_2" method="post" name="ps" enctype="multipart/form-data" onsubmit="chk_inputs(); return false">
                        <input name="name_warn" id="name_warn" type="hidden" value="0" />
		                <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
                        <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                        <input name="r_saved" type="hidden" value="0" />
                        <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];} ?>" />
                        <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else{echo $cEduCtgId;}?>" />
                        <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php echo $passpotLoaded; ?>" />
                        <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
                        
                        <input name="max_size_of_pp" id="max_size_of_pp" type="hidden" value="<?php echo $orgsetins['size_pp']; ?>" /><?php

                        appl_form_header ('Biodata 1 of 2',  $vEduCtgDesc, $vLastName, $vFirstName, $vOtherName, $vTitle);
                        
                        if ($cEduCtgId == 'ELX')
                        {?>
                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:100%; padding:5px; height:auto; background-color: #fdf0bf;">
                                    An incubatee is a student who has achieved excellence in GST302 (Business Creation and Growth) and is subsequently inducted into the incubation center. This privilege affords such student access to mentorship and entrepreneurial development, where he/she can refine and develop his/her innovative ideas, products, or services, ultimately preparing him/her for successful startup and commercialization
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child calendar_grid" style="margin-bottom:15px">
                                <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff"></div>
                                <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff; color:#FF3300">
                                    <label for="studentID">Are you an incubatee of NOUN?</label>
                                </div>
                                <div style="flex:70%; height:48px; background-color: #ffffff">
                                    <input name="studentID" id="studentID" type="text" maxlength="20" 
                                        placeholder="If you are an incubatee of the University (NOUN) type your matriculation number here otherwise leave blank" 
                                        onchange="if(this.value.trim()!='')
                                        {
                                            in_progress('1');
                                            ps.action = '';
                                            ps.submit();
                                            return;
                                        }" value="<?php if (isset($_REQUEST["studentID"]) && $_REQUEST["studentID"] <> ''){echo $_REQUEST["studentID"];} ?>" />
                                </div>
                            </div><?php
                        }?>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                1
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                <label for="vTitle">Title</label>
                            </div>
                            <div style="flex:70%; height:48px; background-color: #ffffff">
                                <input name="vTitle" id="vTitle" type="text"
                                    placeholder="Mrs, Mr, Dr, Prof, Ms etc."
                                    maxlength="15" 
                                    onchange="if(this.value!='')
                                    {
                                        this.value=this.value.trim();
                                        this.value=this.value.replace(/\s+/g, ' ');
                                        this.value=capitalizeEachWord(this.value);
                                    }" value="<?php if ($vTitle <> ''){echo $vTitle;} ?>" />
                            </div>
                        </div>

                        <!--<div class="appl_left_child_div_child calendar_grid" style="margin-top:20px;">
                            <div style="flex:5%; height:40px; background-color: #ffffff"></div>
                            <div style="flex:95%; padding-left:5px; height:40px; background-color: #fdf0bf">
                                The names supplied here must be the same as those on the credentials you will upload under 'Academic qualification'.
                            </div>
                        </div>-->

                        <div class="appl_left_child_div_child calendar_grid" style="margin-top:7px;">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                2
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                <label for="vLastName">Last name</label>
                            </div>
                            <div style="flex:70%; height:48px; background-color: #ffffff"><?php
                                if (trim($vLastName) == '' /*|| $fetched_from_payment == 1 || stbmt_sta('2') == '0'*/)
                                {?>
                                    <input name="vLastName" id="vLastName" type="text"
                                        onblur="if (this.value.trim()!='')
                                        {
                                            this.value=this.value.trim();
                                            this.value=this.value.replace(/\s+/g, ' ');
                                            this.value=this.value.toUpperCase();
                                            /*_('smke_screen').style.zIndex='2';
                                            _('smke_screen').style.display='block';
                                            _('conf_warn').style.zIndex='3';
                                            _('conf_warn').style.display='block'*/;
                                    }" required value="<?php echo stripslashes($vLastName); ?>"
                                    maxlength="40"/><?php
                                }else
                                {?>
                                    <input name="vLastName" id="vLastName" type="text" style="color:#999999" readonly  value="<?php echo stripslashes($vLastName);?>" /><?php
                                }?>
                            </div>
                        </div>
                        <div class="appl_left_child_div_child calendar_grid" style="margin-top:7px;">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                3
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                <label for="vLastName">First name</label>
                            </div>
                            <div style="flex:70%; height:48px; background-color: #ffffff"><?php
                                if (trim($vFirstName) == '' /*|| $fetched_from_payment == 1 || stbmt_sta('2') == '0'*/)
                                {?>
                                    <input name="vFirstName" id="vFirstName" type="text"
                                    onblur="if (this.value.trim()!='')
                                    {
                                        this.value=this.value.trim();
                                        this.value=this.value.replace(/\s+/g, ' ');
                                        this.value=this.value.toLowerCase();
                                        this.value=capitalizeEachWord(this.value);
                                        /*_('smke_screen').style.zIndex='2';
                                        _('smke_screen').style.display='block';
                                        _('conf_warn').style.zIndex='3';
                                        _('conf_warn').style.display='block'*/;
                                    }" required value="<?php echo stripslashes($vFirstName); ?>"  
                                    placeholder="Enter name in full, no abreviation"
                                    maxlength="25"/><?php
                                }else
                                {?>
                                    <input name="vFirstName" id="vFirstName" type="text" style="color:#999999" readonly  value="<?php echo stripslashes($vFirstName);?>" /><?php
                                }?>
                            </div>
                        </div>
                        <div class="appl_left_child_div_child calendar_grid" style="margin-top:7px;">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                4
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                <label for="vOtherName">Other names</label>
                            </div>
                            <div style="flex:70%; height:48px; background-color: #ffffff"><?php
                               if (trim($vOtherName) == '' /*|| $fetched_from_payment == 1 || stbmt_sta('2') == '0'*/)
                               {?>
                                    <input name="vOtherName" id="vOtherName" type="text"
                                   onblur="if (this.value.trim()!='')
                                   {
                                        this.value=this.value.trim();
                                        this.value=this.value.replace(/\s+/g, ' ');
                                        this.value=this.value.toLowerCase();
                                        this.value=capitalizeEachWord(this.value);
                                        /*_('smke_screen').style.zIndex='2';
                                        _('smke_screen').style.display='block';
                                        _('conf_warn').style.zIndex='3';
                                        _('conf_warn').style.display='block'*/;
                                   }" value="<?php echo stripslashes($vOtherName); ?>"  
                                    placeholder="Enter name in full, no abreviation" 
                                    maxlength="25"/><?php
                               }else
                               {?>
                                   <input name="vOtherName" id="vOtherName" type="text" style="color:#999999" readonly  value="<?php echo stripslashes($vOtherName);?>" /><?php
                               }?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child" style="margin-top:20px;">
                            <div style="flex:100%; padding:5px; height:auto; background-color: #fdf0bf; position:relative">
                                <!--<a href="#"
                                    onclick="_('guide_div').style.display = 'none';
                                    _('guide_div').style.zIndex = -1;return false" 
                                    style="color:#666666; margin-right:3px; text-decoration:none;text-shadow: 0 1px 0 #fafafa; position:absolute; top:10px; right:10px;">
                                        <img style="width:15px; height:15px" src="data:image/png;base64,<?php //echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" />
                                    </a>-->
                                <b>Ensure that uploaded picture is:</b>
                                <ol>
                                    <li>of passport size</li>
                                    <li>has either a white or a red background</li>
                                </ol>
                            </div>
                        </div>
                        
                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                5
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                <label for="sbtd_pix">Upload <b>RECENT</b> passport pix</label>
                            </div>
                            <div style="flex:70%; height:48px; background-color: #ffffff">
                                <input type="file" name="sbtd_pix" id="sbtd_pix" style="width:180px" title="Max size: 50KB, Format: JPG" <?php if ($passpotLoaded <> '1'){echo 'required';}?>>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid" style="margin-top:7px;">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                6
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                Gender
                            </div>
                            <div style="flex:70%; height:48px; background-color: #ffffff">
                                <label for="cGender1">
                                    <input type="radio" id="cGender1" name="cGender_opt" value="M"
                                    onclick="_('cGender').value=this.value;"  
                                    <?php if ($cGender == 'M'){echo ' checked';}?> required> Male
                                </label>&nbsp;&nbsp;&nbsp;&nbsp;

                                <label for="cGender2">
                                    <input type="radio" id="cGender2" name="cGender_opt" value="F"
                                    onclick="_('cGender').value=this.value;"  
                                    <?php if ($cGender == 'F'){echo ' checked';}?>> Female
                                </label>
                                <input name="cGender" id="cGender" type="hidden" value="<?php echo $cGender;?>"/>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child  calendar_grid" style="margin-top:7px;">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                7
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                <label for="cnin">NIN</label>
                            </div>
                            <div style="flex:70%; height:48px; background-color: #ffffff">
                                <input name="cnin" id="cnin" type="number" maxlength="11"
                                    onblur="if(this.value!='')
                                    {
                                        this.value=this.value.trim();
                                        this.value=this.value.replace(/ /g, '')
                                    }" required value="<?php if ($cnin <> ''){echo $cnin;} ?>" />
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid" style="margin-top:7px;">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                8
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                <label for="dBirthDate">Date of birth</label>
                            </div>
                            <div style="flex:70%; height:48px; background-color: #ffffff"><?php
                                $date_value = '';
                                if ($dBirthDate == '00-00-0000' || trim($dBirthDate)  == '')
                                {
                                    $curr_date = date("Y-m-d");
                                    $curr_year = substr($curr_date,0,4);

                                    $max_date = ($curr_year - 14)."-01-01";?>
                                    <input type="date" name="dBirthDate" id="dBirthDate" max="<?php echo $max_date;?>"  
								    onkeydown="caution_inform('Use the calendar icon inside the input box on the right to pick a date'); return false" required style="height:99%;"><?php
                                }else
                                {
                                    echo '<b>'.$dBirthDate.'</b>';?>
                                    <input name="dBirthDate" id="dBirthDate" type="hidden" value="<?php if(isset($dBirthDate)){echo formatdate($dBirthDate,'todb');}?>"><?php
                                }?>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid" style="margin-top:7px;">
                            <div style="flex:5%; padding-left:4px; height:40px; background-color: #ffffff">
                            </div>
                            <div style="flex:95%; padding-right:4px; height:40px; background-color: #fdf0bf; text-align:right;">
                                Click/Tap 'Next' button to save entries and proceed
                            </div>
                        </div>

                         <div style="display:flex; 
                            flex-flow: row;
                            justify-content: flex-end;
                            flex:100%;
                            height:auto; 
                            margin-top:10px;">
                                <button type="submit" class="login_button">Next</button>  
                        </div> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
	</body>
</html>