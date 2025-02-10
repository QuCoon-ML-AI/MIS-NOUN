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
		<script language="JavaScript" type="text/javascript" src="./bamboo/s4.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/s4.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
        require_once("feedback_mesages.php");
        require_once("forms.php");        
        
        $save_status = '';

        if (isset($_REQUEST["r_saved"]) && $_REQUEST["r_saved"] == '1')
        {
            $stmt = $mysqli->prepare("REPLACE INTO res_addr 
            (vApplicationNo, 
            vResidenceAddress, 
            vResidenceCityName, 
            cResidenceLGAId, 
            cResidenceStateId, 
            cResidenceCountryId) 
            VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", 
            $_REQUEST["vApplicationNo"], 
            $_REQUEST["vResidenceAddress"], 
            $_REQUEST["vResidenceCityName"], 
            $_REQUEST["cResidenceLGAId"], 
            $_REQUEST["cResidenceStateId"], 
            $_REQUEST["cResidenceCountryId"]);
            $stmt->execute();

            $stmt = $mysqli->prepare("UPDATE prog_choice SET cSbmtd = '0' WHERE vApplicationNo = ?");
            $stmt->bind_param("s", $_REQUEST['vApplicationNo']);
            $stmt->execute();
                
            log_actv('Saved residential address');
            $save_status = 'Success';
        }

        if ($save_status == 'Success')
        {?>
            <script language="JavaScript" type="text/javascript">
                inform('<?php echo $save_status;?>');
            </script><?php
        }
        
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
            
            $sponsor = '';

            $vNOKName = ''; 
            $vNOKAddress = ''; 
            $vNOKEMailId = ''; 
            $vNOKMobileNo = ''; 
            $cNOKType = '';

            $vEMailId = '';
            $vMobileNo = '';
            $w_vMobileNo = '';

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
                
                $stmt = $mysqli->prepare("SELECT vNOKName, 
                vNOKAddress, 
                vNOKEMailId, 
                vNOKMobileNo, 
                cNOKType FROM nextofkin WHERE vApplicationNo = ?");
                $stmt->bind_param("s", $vApplicationNo);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($vNOKName, 
                $vNOKAddress, 
                $vNOKEMailId, 
                $vNOKMobileNo, 
                $cNOKType);
                $stmt->fetch();
                $stmt->close();

                
                $stmt = $mysqli->prepare("SELECT vEMailId, vMobileNo,
                w_vMobileNo FROM post_addr WHERE vApplicationNo = ?");
                $stmt->bind_param("s", $vApplicationNo);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($vEMailId, 
                $vMobileNo,
                $w_vMobileNo);
                $stmt->fetch();
                $stmt->close();
                
                if (isset($_REQUEST["studentID"]) && $_REQUEST["studentID"] <> '')
                {
                    $stmt = $mysqli->prepare("SELECT
                    a.vNOKName,
                    a.vNOKAddress, 
                    a.vNOKEMailId, 
                    a.vNOKMobileNo, 
                    a.cNOKType FROM s_m_t a, nextofkin b WHERE a.vApplicationNo = b.vApplicationNo AND vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST["studentID"]);
                    $stmt->execute();
                    $stmt->store_result();
                    
                    if ($stmt->num_rows > 0)
                    {
                        $stmt->bind_result($vNOKName, 
                        $vNOKAddress, 
                        $vNOKEMailId, 
                        $vNOKMobileNo, 
                        $cNOKType);
                        $stmt->fetch();
                    }
                    $stmt->close();
                }
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
                    if (gaurd_seq(4) == '0')
                    {?>
                        <div class="center top_most talk_backs talk_backs_logo" style="display:block; z-Index:6; border-color: #ffa300; background-position:15px 15px; background-size: 30px 30px; background-image: url('img/info.png');">
                            <div id="informa_msg_content_caution_appl" class="informa_msg_content_caution_cls" style="color:#ffa300;">
                                You must complete the Contact - Residential address section before this section
                            </div>
                            <div class="informa_msg_content_caution_cls" style="color:#ffa300;">
                            </div>
                        </div><?php
                    }else
                    {?>
                        <form action="academic-history" method="post" name="ps" enctype="multipart/form-data" onsubmit="return chk_inputs();">
                            <input name="name_warn" id="name_warn" type="hidden" value="0" />
                            <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
                            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                            <input name="r_saved" type="hidden" value="0" />
                            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];} ?>" />
                            <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else{echo $cEduCtgId;}?>" />
                            <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php echo $passpotLoaded; ?>" />
                            <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
                            
                            <input name="my_email" id="my_email" type="hidden" value="<?php echo $vEMailId; ?>" />
                            <input name="my_gsm" id="my_gsm" type="hidden" value="<?php echo $vMobileNo; ?>" />
                            <input name="my_w_gsm" id="my_w_gsm" type="hidden" value="<?php echo $w_vMobileNo; ?>" />
                            
                            <input name="studentID" id="studentID" type="hidden" value="<?php if (isset($_REQUEST["studentID"]) && $_REQUEST["studentID"] <> ''){echo $_REQUEST["studentID"];} ?>" /><?php
                            
                            appl_form_header ('Next of Kin - Person to be contacted in the event of an emergency',  $vEduCtgDesc, $vLastName, $vFirstName, $vOtherName, $vTitle);?>
                            
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    1
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="vNOKName">Name</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="vNOKName" id="vNOKName" type="text"
                                        maxlength="35"  
                                        onblur="this.value=this.value.trim();
                                        this.value=this.value.replace(/\s+/g, ' ');
                                        this.value=capitalizeEachWord(this.value)" 
                                        value="<?php if (isset($vNOKName) && $vNOKName <> '')
                                        {
                                            echo $vNOKName;
                                        }?>" required />
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    2
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
											<option value="<?php echo $table["cNOKType"]?>"<?php if ($cNOKType == $table["cNOKType"])
											{echo ' selected';} ?>> <?php echo ucwords (strtolower($table["vNOKTypeDesc"]))?></option><?php
										}
                                        mysqli_close(link_connect_db());?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    3
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="vNOKAddress">Address</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="vNOKAddress" id="vNOKAddress" type="text"  
                                        onblur="this.value=this.value.trim();
                                        maxlength="25"
                                        this.value=this.value.replace(/\s+/g, ' ');
                                        this.value=capitalizeEachWord(this.value);"
                                        value="<?php echo $vNOKAddress;?>" required />
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    4
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="vNOKEMailId">eMail Address</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="vNOKEMailId" id="vNOKEMailId" type="email"  
                                        onblur="this.value=this.value.trim();
                                        this.value=this.value.replace(/ /g, '');
                                        this.value=this.value.toLowerCase();" 
                                        value="<?php echo $vNOKEMailId;?>" />
                                </div>
                            </div>

                            <div  class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    5
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="vNOKMobileNo">Phone number</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="vNOKMobileNo" id="vNOKMobileNo" type="number"
                                    onchange="this.value=this.value.trim();" value="<?php echo $vNOKMobileNo;?>" required />
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