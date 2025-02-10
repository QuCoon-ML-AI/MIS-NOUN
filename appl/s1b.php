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
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/s1b.css" />
        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/s1b.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>        
	
        <script language="JavaScript" type="text/javascript">
            function chkinputs()
            {
                var letters_numbers = /^[A-Za-z 0-9]+$/;

                with (ps)
                {
                    if (!vHomeCityName.value.match(letters_numbers))
                    {
                        caution_inform("Enter alphabets and numbers only for name of home town please");
                        return false;
                    }

                    sidemenu.value = '2'; 
                    r_saved.value='1'; 
                }
                in_progress('1');
                return true;
            }
            
        </script>
	</head>
	<body><?php
        require_once("feedback_mesages.php");
        require_once("forms.php");

        if (isset($_REQUEST["r_saved"]) && $_REQUEST["r_saved"] == '1')
        {?>
            <script language="JavaScript" type="text/javascript">
                inform("Success");
            </script><?php
        }
                
	    $mysqli = link_connect_db();

        
        $stmt = $mysqli->prepare("SELECT a.cEduCtgId, vFirstName, b.vEduCtgDesc FROM prog_choice a, educationctg b WHERE a.cEduCtgId  = b.cEduCtgId AND vApplicationNo = ?");
        $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cEduCtgId, $vFirstName, $vEduCtgDesc);
        $stmt->fetch();
		
        $vApplicationNo = '';

        $fetched_from_payment = 0;

        if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST["vApplicationNo"] <> ''){$vApplicationNo = $_REQUEST["vApplicationNo"];}else if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> ''){$vApplicationNo = $_REQUEST["uvApplicationNo"];}
	
            $passpotLoaded = passport_loaded($vApplicationNo);
            
            $vTitle = ''; 
            $vLastName = ''; 
            $vFirstName = ''; 
            $vOtherName = '';
            $cMaritalStatusId = ''; 
            $cDisabilityId = ''; 
            $vHomeCityName = ''; 
            $cHomeLGAId = ''; 
            $cHomeStateId = ''; 
            $cHomeCountryId = '';
            $cmp_lit = '';

            if ($vApplicationNo <> '')
            {
                $stmt = $mysqli->prepare("SELECT
                vTitle, 
                vLastName, 
                vFirstName, 
                vOtherName,
                cMaritalStatusId, 
                cDisabilityId, 
                vHomeCityName, 
                cHomeLGAId, 
                cHomeStateId, 
                cHomeCountryId,
                cmp_lit FROM pers_info WHERE vApplicationNo = ?");
                
                $stmt->bind_param("s", $vApplicationNo);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($vTitle, 
                $vLastName, 
                $vFirstName, 
                $vOtherName,
                $cMaritalStatusId, 
                $cDisabilityId, 
                $vHomeCityName, 
                $cHomeLGAId, 
                $cHomeStateId, 
                $cHomeCountryId,
                $cmp_lit);
                $stmt->fetch();
                
                $stmt->close();
                        
                $stmt = $mysqli->prepare("SELECT vMatricNo FROM afnmatric WHERE vApplicationNo = ?");
                $stmt->bind_param("s", $vApplicationNo);
                $stmt->execute();
                $stmt->store_result();
                $has_matric_num = $stmt->num_rows;
                $stmt->close();
                
                if (isset($_REQUEST["studentID"]) && $_REQUEST["studentID"] <> '')
                {
                    $stmt = $mysqli->prepare("SELECT
                    a.cMaritalStatusId, 
                    a.cDisabilityId, 
                    a.vHomeCityName, 
                    a.cHomeLGAId, 
                    a.cHomeStateId, 
                    a.cHomeCountryId,
                    cmp_lit FROM s_m_t a, pers_info b WHERE a.vApplicationNo = b.vApplicationNo AND vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST["studentID"]);
                    $stmt->execute();
                    $stmt->store_result();
                    
                    if ($stmt->num_rows > 0)
                    {
                        $stmt->bind_result($cMaritalStatusId, 
                        $cDisabilityId, 
                        $vHomeCityName, 
                        $cHomeLGAId, 
                        $cHomeStateId, 
                        $cHomeCountryId, 
                        $cmp_lit);
                        $stmt->fetch();
                    }
                    $stmt->close();
                }
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
            
            $stmt = $mysqli->prepare("SELECT * FROM pers_info WHERE vApplicationNo = ?");
            $stmt->bind_param("s", $vApplicationNo);
            $stmt->execute();
            $stmt->store_result();
            $first_page_record = $stmt->num_rows;
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
                    if ($first_page_record == '0')
                    {?>
                        <div class="center top_most talk_backs talk_backs_logo" style="display:block; z-Index:6; border-color: #ffa300; background-position:15px 15px; background-size: 30px 30px; background-image: url('img/info.png');">
                            <div id="informa_msg_content_caution_appl" class="informa_msg_content_caution_cls" style="color:#ffa300;">
                                You must complete 1 of 2 of the biodata section before this section
                            </div>
                            <div class="informa_msg_content_caution_cls" style="color:#ffa300;">
                            </div>
                        </div><?php
                    }else
                    {?>
                        <form action="postal-address" method="post" name="ps" enctype="multipart/form-data" 
                            onsubmit="return chkinputs()">
                            <input name="name_warn" id="name_warn" type="hidden" value="0" />
                            <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
                            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                            <input name="r_saved" type="hidden" value="0" />
                            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];} ?>" />
                            <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else{echo $cEduCtgId;}?>" />
                            <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php echo $passpotLoaded; ?>" />
                            <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
                            
                            <input name="studentID" id="studentID" type="hidden" value="<?php if (isset($_REQUEST["studentID"]) && $_REQUEST["studentID"] <> ''){echo $_REQUEST["studentID"];} ?>" /><?php

                            appl_form_header ('Biodata 2 of 2',  $vEduCtgDesc, $vLastName, $vFirstName, $vOtherName, $vTitle);?>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    9
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
                                            <option value="<?php echo $table["cMaritalStatusId"]?>"<?php if ($cMaritalStatusId == $table["cMaritalStatusId"]){echo ' selected';}?>><?php echo ucwords (strtolower($table["vMaritalStatusDesc"]))?></option><?php
                                        }
                                        mysqli_close(link_connect_db());?>
                                    </select>
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    10
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cDisabilityId">Physical challenge</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <select name="cDisabilityId" id="cDisabilityId" style="height:100%;" required>
                                        <option value="" selected="selected"></option><?php
                                        $sql1="select cDisabilityId, vDisabilityDesc from disability where cDelFlag = 'N'";
                                        $rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
                                        $cnt = 0;
                                        while ($table = mysqli_fetch_array($rsql1))
                                        {	
                                            $cnt++;
                                            if ($cnt > 0 && $cnt%5 ==0)
                                            {?>
                                               <option disabled></option><?php 
                                            }?>
                                            <option value="<?php echo $table["cDisabilityId"]?>"
                                            <?php if ($cDisabilityId == $table["cDisabilityId"]){echo ' selected';}?>> <?php echo ucwords (strtolower($table["vDisabilityDesc"]))?> </option><?php
                                        }
                                        mysqli_close(link_connect_db());?>
                                    </select>
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    11
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cHomeCountryId">Nationality</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <select name="cHomeCountryId" id="cHomeCountryId" style="height:100%;" 
                                        onchange="update_cat_country('cHomeCountryId', 'State_readup', 'cHomeStateId', 'cHomeLGAId')" required>
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
                                                if (isset($_REQUEST['cHomeCountryId']) && $_REQUEST['cHomeCountryId'] == $table["cCountryId"])
                                                {
                                                    $fnd = '1'; echo ' selected';
                                                }elseif ($cHomeCountryId == $table["cCountryId"])
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
                                        <option value="99" <?php if (isset($_REQUEST['cHomeCountryId']) && $_REQUEST['cHomeCountryId'] == "99"){echo ' selected';}?>>Other Country</option>
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
                                    12
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cHomeStateId">State of origin</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff"><?php
                                    if ($cHomeCountryId <> '')
                                    {
                                        if ($cHomeCountryId == 'NG')
                                        {
                                            $sql1 = "SELECT cStateId,vStateName FROM ng_state where cCountryId = '$cHomeCountryId' ORDER BY vStateName";
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
                                    <select name="cHomeStateId" id="cHomeStateId" style="height:100%;"  
                                            onchange="update_cat_country('cHomeStateId', 'LGA_readup', 'cHomeLGAId', 'cHomeLGAId')" required>
                                        <option value="" selected="selected"></option><?php
                                    if ($cHomeCountryId <> '')
                                    {
                                        while ($table=mysqli_fetch_array($rsql1))
                                        {?>
                                            <option value="<?php echo $table["cStateId"]?>"<?php if (!(isset($_REQUEST['chng_cntry']) && $_REQUEST['chng_cntry'] == '1')){if ((isset($_REQUEST['cHomeStateId']) && $_REQUEST['cHomeStateId'] == $table["cStateId"]) || (strlen($cHomeStateId) > 0 && $cHomeStateId == $table["cStateId"])){echo ' selected';}}?>> <?php echo ucwords (strtolower ($table["vStateName"]))?> </option>
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
                                    13
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cHomeLGAId">Local Govt. Area of origin</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff"><?php
                                    if ($cHomeStateId <> '')
                                    {
                                        if ($cHomeStateId <> '99')
                                        {
                                            $sql1 = "select b.cLGAId,b.vLGADesc
                                            from localarea b, ng_state c
                                            where b.cStateId = c.cStateId and c.cStateId = '$cHomeStateId' order by b.vLGADesc";
                                        }else
                                        {
                                            $sql1 = "select cLGAId,vLGADesc from localarea where cStateId = '99' order by vLGADesc";
                                        }
                                        $rsql1=mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
                                    }?>
                                    <select name="cHomeLGAId" id="cHomeLGAId" style="height:100%;" required>
                                        <option value="" selected="selected"></option><?php
                                        if ($cHomeStateId <> '')
                                        {
                                            while ($table=mysqli_fetch_array($rsql1))
                                            {?>
                                                <option value="<?php echo $table["cLGAId"]?>"<?php if (($cHomeLGAId == $table["cLGAId"]) || ($cHomeStateId == '' && $table["cLGAId"] == '9999')){echo ' selected';}?>> <?php echo ucwords (strtolower ($table["vLGADesc"]))?> </option>
                                                <?php
                                            }
                                        }
                                        mysqli_close(link_connect_db());?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    14
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="vHomeCityName">Home town</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="chng_cntry" type="hidden" />
                                    <input name="chng_state" type="hidden" />
                                    <input name="vHomeCityName" id="vHomeCityName" type="text" maxlength="15" 
                                        onblur="this.value=this.value.trim();
                                        this.value=this.value.replace(/\s+/g, ' ');
                                        this.value=capitalizeEachWord(this.value)" 
                                        value="<?php if (isset($vHomeCityName) && $vHomeCityName <> '')
                                        {
                                            echo $vHomeCityName;
                                        }?>" required />
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    15
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cmp_lit">Level of computer literacy</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <select name="cmp_lit" id="cmp_lit" style="height:100%;" required>
                                        <option value="" selected></option>
                                        <option value="0" <?php if ($cmp_lit == 0){echo 'selected';}?>>None</option>
                                        <option value="1" <?php if ($cmp_lit == 1){echo 'selected';}?>>Low</option>
                                        <option value="2" <?php if ($cmp_lit == 2){echo 'selected';}?>>Moderate</option>
                                        <option value="3" <?php if ($cmp_lit == 3){echo 'selected';}?>>High</option>
                                    </select>
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
                        </form><?php
                    }?>
                </div>
            </div>
        </div>
	</body>
</html>