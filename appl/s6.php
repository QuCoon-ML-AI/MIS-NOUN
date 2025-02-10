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
		<script language="JavaScript" type="text/javascript" src="./bamboo/s6.js"></script>
        <script language="JavaScript" type="text/javascript">
            function completeHandler(event)
            {
                on_error('0');
                on_abort('0');
                in_progress('0');
                
                var returnedStr = event.target.responseText;
                
                //inform(returnedStr)
                //return;

                if (returnedStr == '')
                {
                    caution_inform("No match found. Check other departments");
                }
                
                if (ps.chnge.value == 1)
                {
                    var cProgId = ''; cProgdesc = ''; cProgrammeId7 = ''; cReqmtId_all = '';                    
                    
                    var cProgrammeId7 = 'cProgrammeId7_1st';
                    
                    _(cProgrammeId7).options.length = 0;
                    _(cProgrammeId7).options[_(cProgrammeId7).options.length] = new Option('', '');
                    
                    if (returnedStr.indexOf("Lack") != -1 ||
                    returnedStr.indexOf("There are no") != -1 ||
                    returnedStr.indexOf("Olevel qualification") != -1)
                    {
                        caution_inform(returnedStr);
                        return;
                    }
                    
                    var middle_string = '';
                    var qual_title = ''; prog_title = ''; adm_crit = ''; lvl = '';

                    returnedStr = returnedStr.trim();

                    // if (returnedStr.indexOf("Commonwealth") != -1)
                    // {
                    //     for (var i = 0; i <= returnedStr.length-1; i+=239)
                    //     {
                    //         sReqmtId = returnedStr.substr(i,4);
                    //         sReqmtId = sReqmtId.trim();

                    //         cProgId = returnedStr.substr(i+4,10);
                    //         cProgId = cProgId.trim()+sReqmtId;
                            
                    //         qual_title = returnedStr.substr(i+14, 100);
                    //         qual_title = qual_title.trim();
                            
                    //         prog_title = returnedStr.substr(i+134,100);
                    //         prog_title = prog_title.trim();
                                        
                    //         lvl = returnedStr.substr(i+234,15);
                    //         lvl = lvl.trim();
                    //         alert(sReqmtId+' '+cProgId+' '+qual_title+' '+prog_title+' '+lvl)
                    //     }
                    // }else
                    // {
                        for (var i = 0; i <= returnedStr.length-1; i+=149)
                        {
                            sReqmtId = returnedStr.substr(i,4);
                            sReqmtId = sReqmtId.trim();

                            cProgId = returnedStr.substr(i+4,10);
                            cProgId = cProgId.trim()+sReqmtId;
                            
                            qual_title = returnedStr.substr(i+14, 20);
                            qual_title = qual_title.trim();
                            
                            prog_title = returnedStr.substr(i+34,100);
                            prog_title = prog_title.trim();
                                        
                            lvl = returnedStr.substr(i+134,15);
                            lvl = lvl.trim();
                            
                            cProgdesc = qual_title+' '+prog_title+' '+lvl;
                            
                            _(cProgrammeId7).options[_(cProgrammeId7).options.length] = new Option(cProgdesc, cProgId);
                        }
                    //}
                    
                    
                    
                    ps.chnge.value = 0;
                }
            }
        </script>
        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/s6.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body><?php
        require_once("feedback_mesages.php");
        require_once("forms.php");        
        
        $cFacultyId_1st = '';
        if (isset($_REQUEST["cFacultyIdold07"])){$cFacultyId_1st = $_REQUEST["cFacultyIdold07"];}
        
        $stmt = $mysqli->prepare("SELECT vFirstName, b.vEduCtgDesc, cProgrammeId FROM prog_choice a, educationctg b WHERE a.cEduCtgId  = b.cEduCtgId AND vApplicationNo = ?");
        $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($vFirstName, $vEduCtgDesc, $cProgrammeId);
        $stmt->fetch();

        
        $stmt = $mysqli->prepare("SELECT Amount FROM remitapayments_app WHERE Regno = ?");
        $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($amount);
        $stmt->fetch();

        
		
        $vApplicationNo = '';

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

        
        
        $employ_sta = ''; 
        $vemployer_address = ''; 
        
        $cEduCtgId = '';
        $old_faculty = '';
        $cStudyCenterId = '';

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
            
            $stmt = $mysqli->prepare("SELECT employ_sta, vemployer_address FROM empl_hist WHERE vApplicationNo = ?");
            $stmt->bind_param("s", $vApplicationNo);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($employ_sta, $vemployer_address);
            $stmt->fetch();
            $stmt->close();
            
            if (strlen($employ_sta) == 0)
            {
                $employ_sta = '';
            }

            $stmt = $mysqli->prepare("select cEduCtgId, cStudyCenterId, cFacultyId from prog_choice where vApplicationNo = ?");
            $stmt->bind_param("s", $vApplicationNo);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($cEduCtgId, $cStudyCenterId, $old_faculty);
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
                    if (gaurd_seq(6) == '0')
                    {?>
                        <div class="center top_most talk_backs talk_backs_logo" style="display:block; z-Index:6; border-color: #ffa300; background-position:15px 15px; background-size: 30px 30px; background-image: url('img/info.png');">
                            <div id="informa_msg_content_caution_appl" class="informa_msg_content_caution_cls" style="color:#ffa300;">
                                You must complete the 'Academic qualification' section before this section
                            </div>
                            <div class="informa_msg_content_caution_cls" style="color:#ffa300;">
                            </div>
                        </div><?php
                    }else
                    {?>
                        <form action="preview-form" method="post" name="ps" enctype="multipart/form-data" onsubmit="return chk_inputs();">
                            <input name="name_warn" id="name_warn" type="hidden" value="0" />
                            <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
                            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                            <input name="r_saved" type="hidden" value="0" />
                            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];} ?>" />
                            <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php echo $cEduCtgId;?>" />
                            <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php echo $passpotLoaded; ?>" />
                            <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
                            
                            <input name="cReqmtId_1st" id="cReqmtId_1st" type="hidden" />
                            <input name="selcted_prog_to_send" id="selcted_prog_to_send" type="hidden" />
                            <input name="iBeginLevel_1st" id="iBeginLevel_1st" type="hidden" />

                            <input name="amount" id="amount" type="hidden"  value="<?php echo $amount; ?>"/>                            

                            <input name="old_faculty" id="old_faculty" type="hidden" value="<?php echo $old_faculty; ?>" />
                            <input name="foriegn_appl" id="foriegn_appl" type="hidden" value="<?php echo foriegn_appl(); ?>" /><?php

                            appl_form_header ('Choice of Programme, study centre...',  $vEduCtgDesc, $vLastName, $vFirstName, $vOtherName, $vTitle);?>   
                            
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    1
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    Employment status
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <select name="employ_sta" id="employ_sta" style="height:100%;" required>
                                        <option value="1" <?php if ($employ_sta == 1){echo 'selected';}?>>Part-time</option>
                                        <option value="2" <?php if ($employ_sta == 2){echo 'selected';}?>>Unemployed</option>
                                        <option value="3" <?php if ($employ_sta == 3){echo 'selected';}?>>Self-employed</option>
                                        <option value="4" <?php if ($employ_sta == 4){echo 'selected';}?>>Employed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    2
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="vemployer_address">Employer's address</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="vemployer_address" id="vemployer_address" type="text"
                                    maxlength="40"
                                    style="text-transform:none; width:99.6%"
                                    placeholder="Not applicable if unemployed"
                                    value="<?php echo ucwords(strtolower($vemployer_address));?>"/>
                                </div>
                            </div>

                            <select name="cdeptId_readup" id="cdeptId_readup" style="display:none"><?php	
                                $sql = "select cFacultyId, cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where cDelFlag = 'N' order by cFacultyId, cdeptId, vdeptDesc";
                                $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                                while ($rs = mysqli_fetch_array($rssql))
                                {?>
                                    <option value="<?php echo $rs['cFacultyId']. $rs['cdeptId']?>"><?php echo $rs['vdeptDesc'];?></option><?php
                                }
                                mysqli_close(link_connect_db());?>
                            </select>

                            <select name="cprogrammeId_readup" id="cprogrammeId_readup" style="display:none"><?php	
                                $sql = "select s.cdeptId, p.cProgrammeId,p.vProgrammeDesc,o.vObtQualTitle 
                                from programme p, obtainablequal o, depts s, faculty t
                                where p.cObtQualId = o.cObtQualId 
                                and s.cdeptId = p.cdeptId
                                and s.cFacultyId = t.cFacultyId
                                and p.cDelFlag = s.cDelFlag
                                and p.cDelFlag = t.cDelFlag
                                and p.cDelFlag = 'N'
                                order by s.cdeptId, p.cProgrammeId";
                                $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                                while ($rs = mysqli_fetch_array($rssql))
                                {?>
                                    <option value="<?php echo $rs['cdeptId']. $rs['cProgrammeId']?>"><?php echo $rs['vObtQualTitle'].' '.$rs['vProgrammeDesc']; ?></option><?php
                                }
                                mysqli_close(link_connect_db());?>
                            </select>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    3
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cFacultyIdold07">Faculty, Centre or Directorate</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <select name="cFacultyIdold07" id="cFacultyIdold07" style="height:100%;" required
                                        onchange="_('cdeptold7_1st').length = 0;
                                        
                                        //_('module_exp_div').style.display='none';
                                        _('cdeptold7_1st').options[_('cdeptold7_1st').options.length] = new Option('', '');
                                        
                                        _('cProgrammeId7_1st').length = 0;
                                        _('cProgrammeId7_1st').options[_('cProgrammeId7_1st').options.length] = new Option('', '');
                                                
                                        update_cat_country('cFacultyIdold07', 'cdeptId_readup', 'cdeptold7_1st', 'cProgrammeId7_1st');"><?php
                                        get_faculties($cFacultyId_1st);?>
                                    </select>
						            <input name="chnge" id="chnge" type="hidden" value="0" />
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    4
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cdeptold7_1st">Department</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <select name="cdeptold7_1st" id="cdeptold7_1st" style="height:100%;" required
                                        onchange="ps.chnge.value=1;
                                        
                                        //_('module_exp_div').style.display='none';
                                        if (ps.cEduCtgId.value=='ELX')
                                        {
                                            if (this.value=='DEG' || this.value=='ACL' /*|| this.value=='PRO' || */ || this.value=='PCC')
                                            {
                                                update_cat_country('cdeptold7_1st', 'cprogrammeId_readup', 'cProgrammeId7_1st', 'cProgrammeId7_1st');
                                                ps.chnge.value=0;
                                            }else
                                            {
                                                _('cProgrammeId7_1st').length=0;
                                            }
                                        
                                            if (_('cProgrammeId7_1st').length==0)
                                            {
                                                caution_inform('There are no certificate programmes in the selected department');
                                            }
                                        }else
                                        {
                                            updateScrn();
                                        }"><?php
                                        $stmt = $mysqli->prepare("SELECT cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc FROM depts WHERE cFacultyId = ? ORDER BY vdeptDesc");
                                        $stmt->bind_param("s", $cFacultyId);
                                        $stmt->execute();
                                        $stmt->store_result();
                                        $stmt->bind_result($cdeptId1, $vdeptDesc1);                                        
                                        while ($stmt->fetch())
                                        {?>
                                            <option value="<?php echo $cdeptId1; ?>"<?php if (isset($_REQUEST['cdeptold']) && $cdeptId1 == $_REQUEST['cdeptold']){echo ' selected';}?>>
                                                <?php echo $vdeptDesc1;?>
                                            </option><?php
                                        }
                                        $stmt->close();?>
                                    </select>
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    5
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cProgrammeId7_1st">Suitable programme(s)</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <select name="cProgrammeId7_1st" id="cProgrammeId7_1st" style="height:100%;" 
                                        onchange="var slected_prog = this.value;
                                        if (ps.cEduCtgId.value=='ELX')
                                        {
                                            _('cReqmtId_1st').value = 0;
                                            _('selcted_prog_to_send').value = this.value;
                                            var slected_text = this.options[this.selectedIndex].text;
                                            _('iBeginLevel_1st').value = 10;
                                        }else
                                        {
                                            _('cReqmtId_1st').value = slected_prog.substr(7,2);
                                            _('selcted_prog_to_send').value = slected_prog.substr(0,6);
                                            var slected_text = this.options[this.selectedIndex].text;
                                            _('iBeginLevel_1st').value = slected_text.substr(slected_text.indexOf('[')+1,4).trim();
                                        }
                                        _('centre').style.display='none';
                                        _('centre0').style.display='none';
                                        _('centre1').style.display='none';
                                        _('centre2').style.display='none';
                                        _('centre3').style.display='none';

                                        if (_('foriegn_appl').value == 1)
                                        {
                                            _('centre0').style.display='block';
                                        }else if (this.value.indexOf('DEG') != -1)
                                        {
                                            _('centre1').style.display='block';
                                        }else if (this.value.indexOf('CHD') != -1)
                                        {
                                            _('centre2').style.display='block';
                                        }else 
                                        {
                                            _('centre3').style.display='block';
                                        }" required>
                                        <option value="" selected="selected"></option>
                                    </select>
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                                    6
                                </div>
                                <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                                    <label for="cStudyCenterId">Study centre</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="cStudyCenterId" id="cStudyCenterId" type="hidden" value="<?php echo $cStudyCenterId; ?>" />
                                    
                                    <select name="centre" id="centre" style="height:100%; display:block" disabled>
                                        <option value="" selected>Select a study centre</option>
                                    </select><?php
                                    
                                    $sql = "SELECT cStudyCenterId, vCityName, vStateName FROM studycenter a, ng_state b WHERE a.cStateId = b.cStateId AND cStudyCenterId = 'FC02' AND a.cDelFlag = 'N' ORDER BY b.vStateName, vCityName";
                                    $rsql=mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));?>
                                    <select name="centre0" id="centre0" style="height:100%; display:none" onchange="_('cStudyCenterId').value=this.value">
                                        <option value="" selected>Select a study centre</option><?php
                                        $cnt = 0;
                                        $prev_state = '';
                                        while ($table= mysqli_fetch_array($rsql))
                                        {
                                            if ($prev_state <> '' && $prev_state <> $table['vStateName'])
                                            {?>
                                               <option disabled></option><?php 
                                            }?>
                                            <option value="<?php echo $table['cStudyCenterId'] ?>"<?php if ($cStudyCenterId == $table["cStudyCenterId"])
                                            {echo ' selected';}?>><?php echo $table['vStateName'].' '.$table['vCityName'];?></option><?php
                                            $prev_state = $table['vStateName'];
                                        }?>
                                    </select><?php

                                    $sql = "SELECT cStudyCenterId, vCityName, vStateName FROM studycenter a, ng_state b WHERE a.cStateId = b.cStateId AND cStudyCenterId = 'FC12' AND a.cDelFlag = 'N' ORDER BY vStateName, vCityName";
                                    $rsql=mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));?>
                                    <select name="centre1" id="centre1" style="height:100%; display:none" onchange="_('cStudyCenterId').value=this.value">
                                        <option value="" selected>Select a study centre</option><?php
                                        $cnt = 0;
                                        $prev_state = '';
                                        while ($table= mysqli_fetch_array($rsql))
                                        {
                                            if ($prev_state <> '' && $prev_state <> $table['vStateName'])
                                            {?>
                                               <option disabled></option><?php 
                                            }?>
                                            <option value="<?php echo $table['cStudyCenterId'] ?>"<?php if ($cStudyCenterId == $table["cStudyCenterId"])
                                            {echo ' selected';}?>><?php echo $table['vStateName'].' '.$table['vCityName'];?></option><?php

                                            $prev_state = $table['vStateName'];
                                        }?>
                                    </select><?php

                                    /*$sql = "SELECT cStudyCenterId, vCityName, vStateName FROM studycenter a, ng_state b 
                                    WHERE a.cStateId = b.cStateId AND cStudyCenterId IN ('AD01','AK01','ED01','KD01','KD03','KD06','ON01','AN01','ED01','FC01','FC02','FC09','KD03','KN01','KN16','LA04','LA01','NS01','PL01','RV02') AND a.cDelFlag = 'N' ORDER BY a.cStateId, vCityName";*/
                                    
                                    $sql = "SELECT cStudyCenterId, vCityName, vStateName FROM studycenter a, ng_state b 
                                    WHERE a.cStateId = b.cStateId AND a.cDelFlag = 'N' ORDER BY vStateName, vCityName";
                                    $rsql=mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));?>
                                    <select name="centre2" id="centre2" style="height:100%; display:none" onchange="_('cStudyCenterId').value=this.value">
                                        <option value="" selected>Select a study centre</option><?php
                                        $prev_state = '';
                                        while ($table= mysqli_fetch_array($rsql))
                                        {
                                            if ($prev_state <> '' && $prev_state <> $table['vStateName'])
                                            {?>
                                               <option disabled></option><?php 
                                            }?>
                                            <option value="<?php echo $table['cStudyCenterId'] ?>"<?php if ($cStudyCenterId == $table["cStudyCenterId"])
                                            {echo ' selected';}?>><?php echo $table['vStateName'].' '.$table['vCityName'];?></option><?php

                                            $prev_state = $table['vStateName'];
                                        }
                                        mysqli_close(link_connect_db());?>
                                    </select><?php

                                    $sql = "SELECT cStudyCenterId, vCityName, vStateName FROM studycenter a, ng_state b WHERE a.cStateId = b.cStateId AND cStudyCenterId NOT IN ('FC02','KD06') AND a.cDelFlag = 'N' ORDER BY vStateName, vCityName";
                                    $rsql=mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));
                                    $prev_state = '';?>
                                    <select name="centre3" id="centre3" style="height:100%; display:none" onchange="_('cStudyCenterId').value=this.value">
                                        <option value="" selected>Select a study centre</option><?php
                                        while ($table= mysqli_fetch_array($rsql))
                                        {
                                            if ($prev_state <> '' && $prev_state <> $table['vStateName'])
                                            {?>
                                               <option disabled></option><?php 
                                            }?>
                                            <option value="<?php echo $table['cStudyCenterId'] ?>"<?php if ($cStudyCenterId == $table["cStudyCenterId"])
                                            {echo ' selected';}?>><?php echo $table['vStateName'].' '.$table['vCityName'];?></option><?php

                                            $prev_state = $table['vStateName'];
                                        }
                                        mysqli_close(link_connect_db()); ?>
                                    </select>                                    
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