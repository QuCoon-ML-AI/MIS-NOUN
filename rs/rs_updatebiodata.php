<?php
require_once('good_entry.php');
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once(BASE_FILE_NAME.'lib_fn.php');

require_once('std_lib_fn.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME;?>img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="<?php echo BASE_FILE_NAME;?>js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/updatebio.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE_FILE_NAME;?>styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/updatebio.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_side_menu.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
	    $mysqli = link_connect_db();

        $orgsetins = settns();
        
        require_once("../appl/feedback_mesages.php");
        
        require_once("std_detail_pg1.php");
        require_once("forms.php");
        
        require_once("./set_scheduled_dates.php");
                    
        $balance = 0.00;?>        
            
        <div class="appl_container">
            <div class="appl_left_div" style="z-index:2;">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em">Update bank account detail</div>
                
                <div class="for_computer_screen">
                    <?php require_once ('std_left_side_menu.php');?>
                </div>
            </div>
            
            <div class="appl_right_div">   
                <div class="appl_left_child_div for_mobile_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php std_top_samll_menu();?>
                </div>

                <div class="appl_left_child_div for_computer_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php std_top_menu();?>
                </div>

                <div class="appl_left_child_div for_mobile_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php require_once ('mobile_menu_bar_content.php');?>
                </div>
                
                <div class="appl_left_child_div for_computer_screen" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php require_once ('menu_bar_content.php');?>
                </div>

                <div id="menu_sm_scrn">
                    <?php build_menu_right();?>
                </div><?php
                
                $vApplicationNo1 = '';
                $vLastName_su1 = '';
                $vFirstName_su1 = '';
                $vOtherName_su1 = '';
                $cGender_su1 = '';
                $dBirthDate_su1 = '';
                $cMaritalStatusId_su1 = '';
                $cDisabilityId_su1 = '';
                $cHomeCountryId_su1 = '';
                $cHomeStateId_su1 = '';
                $cHomeLGAId_su1 = '';
                $vHomeCityName_su1 = '';
                $cPostalCountryId_su1 = '';
                $cPostalStateId_su1 = '';
                $cPostalLGAId_su1 = '';
                $vPostalCityName_su1 = '';
                $vPostalAddress_su1 = '';
                $vEMailId_su1 = '';
                $vMobileNo_su1 = '';
                $w_vMobileNo_su1 = '';
                $cResidenceCountryId_su1 = '';
                $cResidenceStateId_su1 = '';
                $cResidenceLGAId_su1 = '';
                $vResidenceCityName_su1 = '';
                $vResidenceAddress_su1 = '';
                $vNOKName_su1 = '';
                $cNOKType_su1 = '';
                $sponsor_su1 = '';
                $vNOKAddress_su1 = '';
                $vNOKEMailId_su1 = '';
                $vNOKMobileNo_su1 = '';
                $vNOKName1_su1 = '';
                $cNOKType1_su1 = '';
                $sponsor1_su1 = '';
                $vNOKAddress1_su1 = '';
                $vNOKEMailId1_su1 = '';
                $vNOKMobileNo1_su1 = '';
                $sponsor2_su1 = '';

                $std_upld_passpic_no = '';

                if (isset($_REQUEST['vMatricNo']))
                {
                    $stmt = $mysqli->prepare("SELECT vApplicationNo, vLastName, vFirstName, vOtherName, cGender, dBirthDate, cMaritalStatusId, cDisabilityId, cHomeCountryId, cHomeStateId, cHomeLGAId, vHomeCityName, cPostalCountryId, cPostalStateId, cPostalLGAId, vPostalCityName, vPostalAddress, vEMailId, vMobileNo, w_vMobileNo, cResidenceCountryId, cResidenceStateId, cResidenceLGAId, vResidenceCityName, vResidenceAddress, vNOKName, cNOKType, sponsor, vNOKAddress, vNOKEMailId, vNOKMobileNo, vNOKName1, cNOKType1, sponsor1, vNOKAddress1, vNOKEMailId1, vNOKMobileNo1, sponsor2 
					FROM s_m_t  
					WHERE vMatricNo = ?");
					$stmt->bind_param("s", $_REQUEST['vMatricNo']);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($vApplicationNo1, $vLastName_su1, $vFirstName_su1, $vOtherName_su1, $cGender_su1, $dBirthDate_su1, $cMaritalStatusId_su1, $cDisabilityId_su1, $cHomeCountryId_su1, $cHomeStateId_su1, $cHomeLGAId_su1, $vHomeCityName_su1, $cPostalCountryId_su1, $cPostalStateId_su1, $cPostalLGAId_su1, $vPostalCityName_su1, $vPostalAddress_su1, $vEMailId_su1, $vMobileNo_su1, $w_vMobileNo_su1, $cResidenceCountryId_su1, $cResidenceStateId_su1, $cResidenceLGAId_su1, $vResidenceCityName_su1, $vResidenceAddress_su1, $vNOKName_su1, $cNOKType_su1, $sponsor_su1, $vNOKAddress_su1, $vNOKEMailId_su1, $vNOKMobileNo_su1, $vNOKName1_su1, $cNOKType1_su1, $sponsor1_su1, $vNOKAddress1_su1, $vNOKEMailId1_su1, $vNOKMobileNo1_su1, $sponsor2_su1);
					$stmt->fetch();
					$stmt->close();
                    
                    $cResidenceStateId_su1 = $cResidenceStateId_su1 ?? '';

                    $stmt = $mysqli->prepare("SELECT upld_passpic_no, vmask FROM pics a, afnmatric b 
                    WHERE a.vApplicationNo = b.vApplicationNo 
                    AND b.vMatricNo = ? 
                    AND cinfo_type = 'p'");
                    $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                    $stmt->execute();
                    $stmt->store_result();
                    $passpotLoaded = $stmt->num_rows;
                    $stmt->bind_result($std_upld_passpic_no, $vmask);
                    $stmt->fetch();
                    $stmt->close();
                }?>

                <div class="appl_left_child_div" style="width:98%; margin:auto; max-height:95%; margin-top:10px; overflow:auto; background-color:#eff5f0">
                    <form action="" method="post" name="chk_p_sta" id="chk_p_sta" enctype="multipart/form-data" onsubmit="chk_inputs_cps(); return false">
                        <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
                        <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"]) && $_REQUEST["ilin"] <> ''){echo $_REQUEST["ilin"];}?>" />
                        <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
                        
                        <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
                        <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />
                        
                        <input name="cFacultyId" id="cFacultyId" type="hidden" value="<?php if (isset($_REQUEST["cFacultyId"]) && $_REQUEST["cFacultyId"] <> ''){echo $_REQUEST["cFacultyId"];}else{echo $cFacultyId_loc;}?>" />
                        
                        <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST["cEduCtgId"]) && $_REQUEST["cEduCtgId"] <> ''){echo $_REQUEST["cEduCtgId"];}else{echo $cEduCtgId_loc;}?>" />
                                                
                        <input name="vApplicationNo" id="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST["vApplicationNo"] <> ''){echo $_REQUEST["vApplicationNo"];}else{echo $vApplicationNo_loc;}?>" />
                        
                        <input name="std_upld_passpic_no" id="std_upld_passpic_no" type="hidden" value="<?php if (isset($_REQUEST["std_upld_passpic_no"]) && $_REQUEST["std_upld_passpic_no"] <> ''){echo $_REQUEST["std_upld_passpic_no"];}else{echo $std_upld_passpic_no;}?>" />
                        
                        <input name="upld_passpic_no" id="upld_passpic_no" type="hidden" value="<?php if (isset($_REQUEST["upld_passpic_no"]) && $_REQUEST["upld_passpic_no"] <> ''){echo $_REQUEST["upld_passpic_no"];}else{echo $orgsetins['upld_passpic_no'];}?>" />
                        
                        <input name="vmask" id="vmask" type="hidden" value="<?php if (isset($_REQUEST["vmask"]) && $_REQUEST["vmask"] <> ''){echo $_REQUEST["vmask"];}else{echo $vmask;}?>" />
                        <input name="resident_ctry" id="resident_ctry" type="hidden" value="<?php echo $cResidenceCountryId_su1;?>"/>
                        <input name="token_req" id="token_req" type="hidden" value="0" /><?php
					

                        if ($orgsetins['upld_passpic_no'] > 0 && $std_upld_passpic_no > 0)
                        {?>
                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                    0
                                </div>
                                <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                    <label for="bank_id">Upload passport picture</label>
                                </div>
                                <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                    <input type="file" name="sbtd_pix" id="sbtd_pix" style="width:180px"
								    title="Max size: 50KB, Format: JPG">
                                </div>
                            </div><?php
                        }?>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                1
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                <label for="cMaritalStatusId">Marital status</label>
                            </div>
                            <div style="flex:70%; height:50px; background-color: #ffffff">
                                <select name="cMaritalStatusId" id="cMaritalStatusId" style="height:100%;" required>
                                    <option value="" selected="selected"></option><?php
                                    $sql1 = "select cMaritalStatusId,vMaritalStatusDesc from maritalstatus ";
                                    $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
                                    while ($table = mysqli_fetch_array($rsql1))
                                    {?>
                                        <option value="<?php echo $table["cMaritalStatusId"]?>"<?php if ($cMaritalStatusId_su1 == $table["cMaritalStatusId"]){echo ' selected';}?>><?php echo ucwords (strtolower($table["vMaritalStatusDesc"]))?></option><?php
                                    }
                                    mysqli_close(link_connect_db());?>
								</select>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                2
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                <label for="cDisabilityId">Physical challenge</label>
                            </div>
                            <div style="flex:70%; height:50px; background-color: #ffffff">
                                <select name="cDisabilityId" id="cDisabilityId" style="height:100%;" required>
                                    <option value="" selected="selected"></option><?php
                                    $sql1="select cDisabilityId, vDisabilityDesc from disability where cDelFlag = 'N'";
                                    $rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
                                    while ($table = mysqli_fetch_array($rsql1))
                                    {	?>
                                        <option value="<?php echo $table["cDisabilityId"]?>"
                                        <?php if ($cDisabilityId_su1 == $table["cDisabilityId"]){echo ' selected';}?>> <?php echo ucwords (strtolower($table["vDisabilityDesc"]))?> </option><?php
                                    }
                                    mysqli_close(link_connect_db());?>
                                </select>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                            </div>
                            <div style="flex:95%; padding-left:4px; height:50px; background-color: #ffffff; font-weight:bold;">
                                Residential address
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                3
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                <label for="cResidenceCountryId">Country</label>
                            </div>
                            <div style="flex:70%; height:50px; background-color: #ffffff">
                                <select name="cResidenceCountryId" id="cResidenceCountryId" style="height:100%;" 
                                    onchange="update_cat_country('cResidenceCountryId', 'State_readup', 'cResidenceStateId', 'cResidenceLGAId')" required>
                                    <option value="" selected="selected"></option><?php
                                    $sql1="select cCountryId, vCountryName from country order by vCountryName";
                                    $rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
                                    $fnd = '';
                                    while ($table=mysqli_fetch_array($rsql1))
                                    {?>
                                        <option value="<?php echo $table["cCountryId"]?>"<?php if($fnd == '')
                                        {
                                            if (isset($_REQUEST['cResidenceCountryId']) && $_REQUEST['cResidenceCountryId'] == $table["cCountryId"])
                                            {
                                                $fnd = '1'; echo ' selected';
                                            }elseif ($cResidenceCountryId_su1 == $table["cCountryId"])
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
                                    <option value="99" <?php if (isset($_REQUEST['cResidenceCountryId']) && $_REQUEST['cResidenceCountryId'] == "99"){echo ' selected';}?>>Other Country</option>
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

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                4
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                <label for="cResidenceStateId">State</label>
                            </div>
                            <div style="flex:70%; height:50px; background-color: #ffffff"><?php
                                if ($cResidenceCountryId_su1 <> '')
                                {
                                    if ($cResidenceCountryId_su1 == 'NG')
                                    {
                                        $sql1 = "SELECT cStateId,vStateName FROM ng_state where cCountryId = '$cResidenceCountryId_su1' ORDER BY vStateName";
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
                                <select name="cResidenceStateId" id="cResidenceStateId" style="height:100%;"  
                                        onchange="update_cat_country('cResidenceStateId', 'LGA_readup', 'cResidenceLGAId', 'cResidenceLGAId')" required>
                                    <option value="" selected="selected"></option><?php
                                    if ($cResidenceCountryId_su1 <> '')
                                    {
                                        while ($table=mysqli_fetch_array($rsql1))
                                        {?>
                                            <option value="<?php echo $table["cStateId"]?>"<?php if (!(isset($_REQUEST['chng_cntry']) && $_REQUEST['chng_cntry'] == '1')){if ((isset($_REQUEST['cResidenceStateId']) && $_REQUEST['cResidenceStateId'] == $table["cStateId"]) || (strlen($cResidenceStateId_su1) > 0 && $cResidenceStateId_su1 == $table["cStateId"])){echo ' selected';}}?>> <?php echo ucwords (strtolower ($table["vStateName"]))?> </option>
                                            <?php
                                        }
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

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                5
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                <label for="cResidenceStateId">Local Govt. Area</label>
                            </div>
                            <div style="flex:70%; height:50px; background-color: #ffffff"><?php
                                if ($cResidenceStateId_su1 <> '')
                                {
                                    if ($cResidenceStateId_su1 <> '99')
                                    {
                                        $sql1 = "select b.cLGAId,b.vLGADesc
                                        from localarea b, ng_state c
                                        where b.cStateId = c.cStateId and c.cStateId = '$cResidenceStateId_su1' order by b.vLGADesc";
                                    }else
                                    {
                                        $sql1 = "select cLGAId,vLGADesc from localarea where cStateId = '99' order by vLGADesc";
                                    }
                                    $rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
                                }?>
                                <select name="cResidenceLGAId" id="cResidenceLGAId" style="height:100%;" required>
                                    <option value="" selected="selected"></option><?php
                                    if ($cResidenceStateId_su1 <> '')
                                    {
                                        while ($table=mysqli_fetch_array($rsql1))
                                        {?>
                                            <option value="<?php echo $table["cLGAId"]?>"<?php if (($cResidenceLGAId_su1 == $table["cLGAId"]) || ($cResidenceLGAId_su1 == '' && $table["cLGAId"] == '9999')){echo ' selected';}?>> <?php echo ucwords (strtolower ($table["vLGADesc"]))?> </option>
                                            <?php
                                        }
                                        mysqli_close(link_connect_db());
                                    }?>
                                </select>
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                6
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                <label for="vResidenceCityName">Town</label>
                            </div>
                            <div style="flex:70%; height:50px; background-color: #ffffff">
                                <input name="chng_cntry" type="hidden" />
                                <input name="chng_state" type="hidden" />
                                <input name="vResidenceCityName" id="vResidenceCityName" type="text"  
                                    onChange="this.value=this.value.trim();
                                    this.value=this.value.replace(/\s+/g, ' ');
                                    this.value=capitalizeEachWord(this.value);"
                                    maxlength="15"
                                    value="<?php if (isset($vResidenceCityName_su1) && $vResidenceCityName_su1 <> '')
                                    {
                                        echo $vResidenceCityName_su1;
                                    }?>" required />
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                7
                            </div>
                            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                <label for="vResidenceAddress">Street address</label>
                            </div>
                            <div style="flex:70%; height:50px; background-color: #ffffff">
                                <input name="chng_cntry" type="hidden" />
                                <input name="chng_state" type="hidden" />
                                <input name="vResidenceAddress" id="vResidenceAddress" type="text"  
                                    onChange="this.value=this.value.trim();
                                    this.value=this.value.replace(/\s+/g, ' ');
                                    this.value=capitalizeEachWord(this.value)"
                                    maxlength="18" 
                                    value="<?php if (isset($vResidenceAddress_su1) && $vResidenceAddress_su1 <> '')
                                    {
                                        echo $vResidenceAddress_su1;
                                    }?>" required />
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                            </div>
                            <div style="flex:95%; padding-left:4px; height:50px; background-color: #ffffff; font-weight:bold;">
                                Personal contact
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:5px; height:50px; background-color: #ffffff">
                                8
                            </div>
                            <div style="flex:25%; padding-left:5px; height:50px; background-color: #ffffff">
                                <label for="vEMailId">Student eMail address</label>
                            </div>
                            <div style="flex:70%; height:50px; background-color: #ffffff">
                                <input name="vEMailId" id="vEMailId" type="email"
                                onblur="this.value=this.value.trim();
                                this.value=this.value.replace(/ /g, '');" 
                                value="<?php echo $vEMailId_su1;?>" 
                                placeholder="your matric number@noun.edu.ng"
                                readonly
                                <?php if (!is_bool(strpos($vEMailId_su1, '@noun.edu.ng')))
                                {
                                    //echo ' readonly';
                                }?>
                                title="your_matric_number@noun.edu.ng is what should be here"
                                required />
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:5px; height:50px; background-color: #ffffff">
                                9
                            </div>
                            <div style="flex:25%; padding-left:5px; height:50px; background-color: #ffffff">
                                <label for="vMobileNo">Personal phone number</label>
                            </div>
                            <div style="flex:70%; height:50px; background-color: #ffffff">
                                <input name="vMobileNo" id="vMobileNo" type="number"                                
                                onkeypress="if (_('resident_ctry').value=='NG')
                                {
                                    if(this.value.length==11){return false}
                                }else
                                {
                                    if(this.value.length==13){return false}
                                }"
                                onchange="this.value=this.value.trim();
                                this.value=this.value.replace(/ /g, '');" value="<?php echo $vMobileNo_su1;?>" required />
                            </div>
                        </div>

                        <div  class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:5px; height:50px; background-color: #ffffff">
                                10
                            </div>
                            <div style="flex:25%; padding-left:5px; height:50px; background-color: #ffffff">
                                <label for="w_vMobileNo">WhatsApp number</label>
                            </div>
                            <div style="flex:70%; height:50px; background-color: #ffffff">
                                <input name="w_vMobileNo" id="w_vMobileNo" type="number"                                
                                onkeypress="if (_('resident_ctry').value=='NG')
                                {
                                    if(this.value.length==11){return false}
                                }else
                                {
                                    if(this.value.length==13){return false}
                                }"
                                onchange="this.value=this.value.trim();
                                this.value=this.value.replace(/ /g, '');" value="<?php echo $w_vMobileNo_su1;?>" required />
                            </div>
                        </div>
                       
                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                            </div>
                            <div style="flex:95%; padding-left:4px; height:50px; background-color: #ffffff; font-weight:bold;">
                                Next of kin
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    11
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="vNOKName">Name</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="vNOKName" id="vNOKName" type="text"
                                        maxlength="24"  
                                        onblur="this.value=this.value.trim();
                                        this.value=this.value.replace(/\s+/g, ' ');
                                        this.value=capitalizeEachWord(this.value)" 
                                        value="<?php echo $vNOKName_su1;?>" required />
                                </div>
                            </div>

                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    12
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cNOKType">Relationship</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff"><?php
                                    $sql1="select cNOKType, vNOKTypeDesc from noktype order by vNOKTypeDesc";
                                    $rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
                                    <select name="cNOKType" id="cNOKType" style="height:100%;" required>
                                        <option value="" selected="selected"></option><?php
                                        while ($table=mysqli_fetch_array($rsql1))
										{?>
											<option value="<?php echo $table["cNOKType"]?>"<?php if ($cNOKType_su1 == $table["cNOKType"])
											{echo ' selected';} ?>> <?php echo ucwords (strtolower($table["vNOKTypeDesc"]))?></option><?php
										}
                                        mysqli_close(link_connect_db());?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    13
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="vNOKAddress">Address</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="vNOKAddress" id="vNOKAddress" type="text"
                                        maxlength="30"  
                                        onblur="this.value=this.value.trim();
                                        this.value=this.value.replace(/\s+/g, ' ');
                                        this.value=capitalizeEachWord(this.value);"
                                        value="<?php echo $vNOKAddress_su1;?>" required />
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    14
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="vNOKEMailId">eMail Address</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="vNOKEMailId" id="vNOKEMailId" type="email"  
                                        onblur="this.value=this.value.trim();
                                        this.value=this.value.replace(/ /g, '');
                                        this.value=capitalizeEachWord(this.value)" 
                                        value="<?php echo $vNOKEMailId_su1;?>" required />
                                </div>
                            </div>

                            <div  class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    15
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="vNOKMobileNo">Phone number</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="vNOKMobileNo" id="vNOKMobileNo" type="number"
                                    onkeypress="if(this.value.length==11){return false}"
                                    onchange="this.value=this.value.trim();" value="<?php echo $vNOKMobileNo_su1;?>" required />
                                </div>
                            </div>

                            <div id="token_box" style="display: none;">
                                <div class="appl_left_child_div_child calendar_grid" style="margin-top:15px">
                                    <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">                                
                                    </div>
                                    <div style="flex:95%; padding-left:4px; height:48px; background-color: #fdf0bf; line-height:2.3;">
                                        A token has been sent to your student email address. Enter token below. It expires in 10minutes
                                    </div>
                                </div>

                                <div class="appl_left_child_div_child calendar_grid">
                                    <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                        16
                                    </div>
                                    <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                        <label for="p_token">Token</label>
                                    </div>
                                    <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                        <input name="p_token" id="p_token" type="text"/>
                                    </div>
                                </div>

                                <div id="btn_div" style="display:flex; 
                                    flex:100%;
                                    height:auto;">
                                        <button type="button" class="login_button" onclick="token_req.value='0'; chk_inputs_cps()">Resend token</button>
                                </div>
                            </div>
                         
                        <div id="btn_div" style="display:flex; 
                            flex:100%;
                            height:auto; 
                            margin-top:10px;">
                                <button type="submit" class="login_button">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="menu_bs_scrn" class="appl_far_right_div" style="z-index:2;">
                <?php build_menu_right($balance);?>
            </div>
        </div>
	</body>
</html>