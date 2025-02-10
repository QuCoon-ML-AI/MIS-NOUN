<?php
require_once('good_entry.php');
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('lib_fn.php');
require_once('const_def.php');
        
$mysqli = link_connect_db();?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/s2.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/s2.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
        require_once("feedback_mesages.php");
        require_once("forms.php");
        
        $save_status = '';

        if (isset($_REQUEST["r_saved"]) && $_REQUEST["r_saved"] == '1')
        {
            $stmt = $mysqli->prepare("UPDATE pers_info SET
            cMaritalStatusId = ?,
            cDisabilityId = ?,
            vHomeCityName = ?,
            cHomeLGAId = ?,
            cHomeStateId = ?,
            cHomeCountryId = ?,
            cmp_lit = ?
            WHERE vApplicationNo = ?");
            $stmt->bind_param("ssssssss", 
            $_REQUEST["cMaritalStatusId"], 
            $_REQUEST["cDisabilityId"], 
            $_REQUEST["vHomeCityName"], 
            $_REQUEST["cHomeLGAId"],
            $_REQUEST["cHomeStateId"],
            $_REQUEST["cHomeCountryId"],
            $_REQUEST["cmp_lit"],
            $_REQUEST["vApplicationNo"]);
            $stmt->execute();

            $stmt = $mysqli->prepare("UPDATE prog_choice SET cSbmtd = '0' WHERE vApplicationNo = ?");
            $stmt->bind_param("s", $_REQUEST['vApplicationNo']);
            $stmt->execute();
            $stmt->close();

            log_actv('Saved part 2 of personal biodata');
            $save_status = 'Success';
        }
        
        if ($save_status == 'Success')
        {?>
            <script language="JavaScript" type="text/javascript">
                inform('<?php echo $save_status;?>');
            </script><?php
        }
        
        $stmt = $mysqli->prepare("SELECT vFirstName, b.vEduCtgDesc FROM prog_choice a, educationctg b WHERE a.cEduCtgId  = b.cEduCtgId AND vApplicationNo = ?");
        $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($vFirstName, $vEduCtgDesc);
        $stmt->fetch();
		
        $vApplicationNo = '';

        if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST["vApplicationNo"] <> ''){$vApplicationNo = $_REQUEST["vApplicationNo"];}else if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> ''){$vApplicationNo = $_REQUEST["uvApplicationNo"];}
	
            $passpotLoaded = passport_loaded($vApplicationNo);

            $vTitle = ''; 
            $vLastName = ''; 
            $vFirstName = ''; 
            $vOtherName = '';

            
            
            $vPostalAddress = ''; 
            $vPostalCityName = ''; 
            $cPostalLGAId = ''; 
            $cPostalStateId = ''; 
            $cPostalCountryId = ''; 
            $vEMailId = ''; 
            $vMobileNo = '';
            $w_vMobileNo = '';

            $vNOKEMailId = '';
            $vNOKMobileNo = '';

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
                
                $stmt = $mysqli->prepare("SELECT vApplicationNo, 
                vPostalAddress, 
                vPostalCityName, 
                cPostalLGAId, 
                cPostalStateId, 
                cPostalCountryId, 
                vEMailId, 
                vMobileNo,
                w_vMobileNo FROM post_addr WHERE vApplicationNo = ?");
                $stmt->bind_param("s", $vApplicationNo);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($vApplicationNo, 
                $vPostalAddress, 
                $vPostalCityName, 
                $cPostalLGAId, 
                $cPostalStateId, 
                $cPostalCountryId, 
                $vEMailId, 
                $vMobileNo,
                $w_vMobileNo);
                $stmt->fetch();
                $stmt->close();              
                
                $stmt = $mysqli->prepare("SELECT  
                vNOKEMailId, 
                vNOKMobileNo FROM nextofkin WHERE vApplicationNo = ?");
                $stmt->bind_param("s", $vApplicationNo);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($vNOKEMailId, $vNOKMobileNo);
                $stmt->fetch();
                $stmt->close();
                
                
                if (isset($_REQUEST["studentID"]) && $_REQUEST["studentID"] <> '')
                {
                    $stmt = $mysqli->prepare("SELECT
                    a.vPostalAddress, 
                    a.vPostalCityName, 
                    a.cPostalLGAId, 
                    a.cPostalStateId, 
                    a.cPostalCountryId, 
                    a.vEMailId, 
                    a.vMobileNo,
                    a.w_vMobileNo FROM s_m_t a, post_addr b WHERE a.vApplicationNo = b.vApplicationNo AND vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST["studentID"]);
                    $stmt->execute();
                    $stmt->store_result();
                    
                    if ($stmt->num_rows > 0)
                    {
                        $stmt->bind_result($vPostalAddress, 
                        $vPostalCityName, 
                        $cPostalLGAId, 
                        $cPostalStateId, 
                        $cPostalCountryId, 
                        $vEMailId, 
                        $vMobileNo,
                        $w_vMobileNo);
                        $stmt->fetch();
                    }
                    $stmt->close();
                }
            }

            $vEMailId = $vEMailId ?? '';
            $vMobileNo = $vMobileNo ?? '';
             
            
            $stmt = $mysqli->prepare("SELECT payerEmail, payerPhone FROM remitapayments WHERE Regno = ?");
            $stmt->bind_param("s", $vApplicationNo);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($payerEmail, $payerPhone);
            $stmt->fetch();
            $stmt->close();
            
            if ($vMobileNo == '')
            {
                $vMobileNo = $payerPhone;
            }
            if ($vEMailId == '')
            {
                $vEMailId = $payerEmail;
            }
            
            $stmt = $mysqli->prepare("select cEduCtgId from prog_choice where vApplicationNo = ?");
            $stmt->bind_param("s", $vApplicationNo);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($cEduCtgId);
            $stmt->fetch();
            
            $stmt->close();
            
            $sidemenu = '';
            if (isset($_REQUEST["sidemenu"]) && $_REQUEST["sidemenu"] <> '')
            {
                $sidemenu = $_REQUEST["sidemenu"];
            }
            
            
            $stmt = $mysqli->prepare("SELECT * FROM pers_info 
            WHERE vApplicationNo = ? 
            AND cmp_lit <> '' 
            AND vHomeCityName <> '' 
            AND cHomeCountryId <> '' 
            AND cHomeStateId <> '' 
            AND cHomeLGAId <> '' 
            AND cMaritalStatusId <> ''");
            $stmt->bind_param("s", $vApplicationNo);
            $stmt->execute();
            $stmt->store_result();
            $second_page_record = $stmt->num_rows;
            $stmt->close();?>
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
                    if ($second_page_record == '0')
                    {?>
                        <div class="center top_most talk_backs talk_backs_logo" style="display:block; z-Index:6; border-color: #ffa300; background-position:15px 15px; background-size: 30px 30px; background-image: url('img/info.png');">
                            <div id="informa_msg_content_caution_appl" class="informa_msg_content_caution_cls" style="color:#ffa300;">
                                You must complete 2 of 2 of the biodata section before this section
                            </div>
                            <div class="informa_msg_content_caution_cls" style="color:#ffa300;">
                            </div>
                        </div><?php
                    }else
                    {?>
                        <form action="residential-address" method="post" name="ps" enctype="multipart/form-data" onsubmit="return chk_inputs();">
                            <input name="name_warn" id="name_warn" type="hidden" value="0" />
                            <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
                            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                            <input name="r_saved" type="hidden" value="0" />
                            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];} ?>" />
                            <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else{echo $cEduCtgId;}?>" />
                            <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php echo $passpotLoaded; ?>" />
                            <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
                            
                            <input name="nk_mail" id="nk_mail" type="hidden" value="<?php echo $vNOKEMailId; ?>" />
                            <input name="nk_gsm" id="nk_gsm" type="hidden" value="<?php echo $vNOKMobileNo; ?>" />
                            
                            <input name="studentID" id="studentID" type="hidden" value="<?php if (isset($_REQUEST["studentID"]) && $_REQUEST["studentID"] <> ''){echo $_REQUEST["studentID"];} ?>" /><?php

                            appl_form_header ('Contact - Functional Postal Address',  $vEduCtgDesc, $vLastName, $vFirstName, $vOtherName, $vTitle);?>
                            
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    1
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cPostalCountryId">Country</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <select name="cPostalCountryId" id="cPostalCountryId" style="height:100%;" 
                                        onchange="update_cat_country('cPostalCountryId', 'State_readup', 'cHomeStateId', 'cPostalLGAId')" required>
                                        <option value="" selected="selected"></option><?php
                                        $sql1="select cCountryId, vCountryName from country order by vCountryName";
                                        $rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
                                        $fnd = '';

                                        $cnt = 0;
                                        while ($table=mysqli_fetch_array($rsql1))
                                        {
                                            $cnt ++;
                                            if ($cnt%5==0)
                                            {?>
                                                <option disabled></option><?php
                                            }?>
                                            <option value="<?php echo $table["cCountryId"]?>"<?php if($fnd == '')
                                            {
                                                if (isset($_REQUEST['cPostalCountryId']) && $_REQUEST['cPostalCountryId'] == $table["cCountryId"])
                                                {
                                                    $fnd = '1'; echo ' selected';
                                                }elseif ($cPostalCountryId == $table["cCountryId"])
                                                {
                                                    $fnd = '1'; echo ' selected';
                                                }else if ($table["cCountryId"] == 'NG')
                                                {
                                                    echo ' selected';
                                                }
                                            }?>>
                                                <?php echo ucwords (strtolower($table["vCountryName"]))?></option><?php
                                        }
                                        mysqli_close(link_connect_db());?>
                                        <option value="99" <?php if (isset($_REQUEST['cPostalCountryId']) && $_REQUEST['cPostalCountryId'] == "99"){echo ' selected';}?>>Other Country</option>
                                    </select>
                                </div>
                            </div>
                                
                            <select name="State_readup" id="State_readup" style="display:none"><?php	
                                $sql = "select cStateId,cCountryId,vStateName from ng_state order by vStateName";
                                $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                                while ($rs = mysqli_fetch_array($rssql))
                                {?>
                                    <option value="<?php echo $rs['cStateId'].$rs['cCountryId'];?>"><?php echo $rs['vStateName']; ?></option><?php
                                }
                                mysqli_close(link_connect_db());?>
                            </select>

                            <select name="LGA_readup" id="LGA_readup" style="display:none"><?php	
                                $sql = "select cStateId,cLGAId, vLGADesc from localarea order by vLGADesc";
                                $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                                while ($rs = mysqli_fetch_array($rssql))
                                {?>
                                    <option value="<?php echo $rs['cStateId'].$rs['cLGAId'];?>"><?php echo ucwords (strtolower ($rs["vLGADesc"]))?></option><?php
                                }
                                mysqli_close(link_connect_db());?>
                            </select>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    2
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cPostalStateId">State</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff"><?php
                                    if ($cPostalCountryId <> '')
                                    {
                                        if ($cPostalCountryId == 'NG')
                                        {
                                            $sql1 = "SELECT cStateId,vStateName FROM ng_state where cCountryId = '$cPostalCountryId' ORDER BY vStateName";
                                        }else
                                        {
                                            $sql1 = "SELECT cStateId,vStateName FROM ng_state where cCountryId = 'XX' ORDER BY vStateName";
                                        }
                                        $rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
                                    }else
                                    {
                                        $sql1 = "SELECT cStateId,vStateName FROM ng_state where cCountryId = 'NG' ORDER BY vStateName";//echo $sql1;
                                        $rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
                                    }?>
                                    <select name="cPostalStateId" id="cPostalStateId" style="height:100%;"  
                                            onchange="update_cat_country('cPostalStateId', 'LGA_readup', 'cPostalLGAId', 'cPostalLGAId')" required>
                                        <option value="" selected="selected"></option><?php
                                    if ($cPostalCountryId <> '')
                                    {
                                        while ($table=mysqli_fetch_array($rsql1))
                                        {?>
                                            <option value="<?php echo $table["cStateId"]?>"<?php if (!(isset($_REQUEST['chng_cntry']) && $_REQUEST['chng_cntry'] == '1')){if ((isset($_REQUEST['cPostalStateId']) && $_REQUEST['cPostalStateId'] == $table["cStateId"]) || (strlen($cPostalStateId) > 0 && $cPostalStateId == $table["cStateId"])){echo ' selected';}}?>> <?php echo ucwords (strtolower ($table["vStateName"]))?> </option>
                                            <?php
                                        }
                                        mysqli_close(link_connect_db());
                                    }else
                                    {
                                        while ($table=mysqli_fetch_array($rsql1))
                                        {?>
                                            <option value="<?php echo $table["cStateId"]?>"> <?php echo ucwords (strtolower ($table["vStateName"]))?> </option>
                                            <?php
                                        }
                                        mysqli_close(link_connect_db());
                                    }?>
                                    </select>
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    3
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cPostalLGAId">Local government area</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff"><?php
                                    if ($cPostalStateId <> '')
                                    {
                                        if ($cPostalStateId <> '99')
                                        {
                                            $sql1 = "select b.cLGAId,b.vLGADesc
                                            from localarea b, ng_state c
                                            where b.cStateId = c.cStateId and c.cStateId = '$cPostalStateId' order by b.vLGADesc";
                                        }else
                                        {
                                            $sql1 = "select cLGAId,vLGADesc from localarea where cStateId = '99' order by vLGADesc";
                                        }
                                        $rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
                                    }?>
                                    <select name="cPostalLGAId" id="cPostalLGAId" style="height:100%;" required>
                                        <option value="" selected="selected"></option><?php
                                        if ($cPostalStateId <> '')
                                        {
                                            while ($table=mysqli_fetch_array($rsql1))
                                            {?>
                                                <option value="<?php echo $table["cLGAId"]?>"<?php if (($cPostalLGAId == $table["cLGAId"]) || ($cPostalStateId == '' && $table["cLGAId"] == '9999')){echo ' selected';}?>> <?php echo ucwords (strtolower ($table["vLGADesc"]))?> </option>
                                                <?php
                                            }
                                            mysqli_close(link_connect_db());
                                        }?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    4
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="vPostalCityName">Town</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="chng_cntry" type="hidden" />
                                    <input name="chng_state" type="hidden" />
                                    <input name="vPostalCityName" id="vPostalCityName" type="text" maxlength="15" 
                                        onblur="this.value=this.value.replace(/\s+/g, ' ');
                                        this.value=capitalizeEachWord(this.value)" 
                                        value="<?php if (isset($vPostalCityName) && $vPostalCityName <> '')
                                        {
                                            echo $vPostalCityName;
                                        }?>" required />
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    5
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="vPostalAddress">P.O.B./Street address</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="chng_cntry" type="hidden" />
                                    <input name="chng_state" type="hidden" />
                                    <input name="vPostalAddress" id="vPostalAddress" type="text" 
                                        maxlength="25" 
                                        onblur="this.value=this.value.trim();
                                        this.value=this.value.replace(/\s+/g, ' ');
                                        this.value=capitalizeEachWord(this.value);" 
                                        value="<?php if (isset($vPostalAddress) && $vPostalAddress <> '')
                                        {
                                            echo $vPostalAddress;
                                        }?>" required />
                                </div>
                            </div>
                            
                            

                            <div class="appl_left_child_div_child calendar_grid" style="margin-top:20px;">
                                <div style="flex:5%; height:40px; background-color: #ffffff"></div>
                                <div style="flex:95%; padding-left:5px; line-height:2;  height:40px; background-color: #fdf0bf">
                                    eMail address must be <b>functional and personal</b> otherwise, information from the university via this channel may not reach you.
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:50px; background-color: #ffffff">
                                    6
                                </div>
                                <div style="flex:25%; padding-left:5px; height:50px; background-color: #ffffff">
                                    <label for="vEMailId">Personal eMail address</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="vEMailId" id="vEMailId" type="email"
                                    onblur="this.value=this.value.trim();
                                    this.value=this.value.replace(/ /g, '');
                                    this.value=this.value.toLowerCase();" value="<?PHP echo $vEMailId;?>" required />
                                </div>
                            </div>

                            <div  class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:50px; background-color: #ffffff">
                                    7
                                </div>
                                <div style="flex:25%; padding-left:5px; height:50px; background-color: #ffffff">
                                    <label for="vMobileNo">Personal phone number</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="vMobileNo" id="vMobileNo" type="number"
                                    onkeypress="if(this.value.length==11){return false}"
                                    onchange="this.value=this.value.trim();
                                    this.value=this.value.replace(/ /g, '');" value="<?php echo $vMobileNo;?>" required />
                                </div>
                            </div>

                            <div  class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:50px; background-color: #ffffff">
                                    7
                                </div>
                                <div style="flex:25%; padding-left:5px; height:50px; background-color: #ffffff">
                                    <label for="w_vMobileNo">Whatsapp number</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="w_vMobileNo" id="w_vMobileNo" type="number"
                                    onkeypress="if(this.value.length==11){return false}"
                                    onchange="this.value=this.value.trim();
                                    this.value=this.value.replace(/ /g, '');" value="<?php echo $w_vMobileNo;?>" required />
                                </div>
                            </div>

                            <div class="appl_left_child_div_child calendar_grid" style="margin-top:7px;">
                                <div style="flex:5%; padding-left:4px; height:40px; background-color: #ffffff">
                                </div>
                                <div style="flex:95%; padding-right:4px; line-height:2; height:40px; background-color: #fdf0bf; text-align:right;">
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
                        </form><?php
                    }?>
                </div>
            </div>
        </div>
	</body>
</html>