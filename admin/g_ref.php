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

        
		//check_environ();
			
		function chk_inputs()
		{
			var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
			for (j = 0; j <= ulChildNodes.length-1; j++)
			{
				ulChildNodes[j].style.display = 'none';
			}

            if (gown_ref_loc.uvApplicationNo.value == '')
            {
                setMsgBox('labell_msg0','');
                gown_ref_loc.uvApplicationNo.focus();
                return false;
            }
            
            if (gown_ref_loc.uvApplicationNo.value.length!=12)
            {
                setMsgBox('labell_msg0','Invalid matric. number');
                gown_ref_loc.uvApplicationNo.focus();
                return false;
            }
            if (!gown_ref_loc.gown_rec.checked)
            {
                setMsgBox('labell_msg1','Record not saved. Gown not confirmed returned');
                return false;
            }
            
            
            _('g_refund_mode').value=1;

            gown_ref_loc.submit();
            in_progress('1');
            return false
		}

        
        function tidy_screen()
        {        
            //_("ans6").style.display = 'none';
            _("ans8").style.display = 'none';
            
            gown_ref_loc.conf.value = '';
            
            var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
            for (j = 0; j <= ulChildNodes.length-1; j++)
            {
                ulChildNodes[j].style.display = 'none';
            }

            _("user_cEduCtgId").value = '';

            if (gown_ref_loc.uvApplicationNo.value.trim() != '')
            {
                gown_ref_loc.sbtd_pix.value = '';
            }

            if (gown_ref_loc.sbtd_pix.value.trim() != '')
            {
                gown_ref_loc.uvApplicationNo.value = '';
            }
        }
	</script>
	<noscript></noscript>
</head>


<body onLoad="checkConnection()">
    <?php admin_frms(); $has_matno = 0;?>
	
	<div id="container">		
		<div id="smke_screen_2" class="smoke_scrn" style="display:none"></div><?php
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
            <input name="sRoleID" id="sRoleID" type="hidden" value="<?php echo $sRoleID_u ?>" />
            
            <div id="conf_box_loc" class="center" style="display:none; width:400px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
                <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                    Confirmation
                </div>
                <a href="#" style="text-decoration:none;">
                    <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
                </a>
                <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:100%; float:left; text-align:center; padding:0px;"></div>
                <div style="margin-top:10px; width:100%; float:left; text-align:right; padding:0px;">
                    <a href="#" style="text-decoration:none;" 
                        onclick="gown_ref_loc.conf.value = '1';
                        chk_inputs(); 
                        return false">
                        <div class="submit_button_green" style="width:60px; padding:6px; margin-left:6px; float:right">
                            Yes
                        </div>
                    </a>

                    <a href="#" style="text-decoration:none;" 
                        onclick="gown_ref_loc.conf.value='';
                        _('conf_box_loc').style.display='none';
                        _('smke_screen_2').style.display='none';
                        _('smke_screen_2').style.zIndex='-1';
                        //_('hd_veri_token').value = '';
                        //_('veri_token').value = '';
                        return false">
                        <div class="submit_button_brown_reverse" style="width:60px; padding:6px; float:right">
                            No
                        </div>
                    </a>
                </div>
            </div>

            <div class="innercont_top" style="margin-bottom:0px;">Request for gown refund</div>
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

            <form method="post" name="gown_ref_loc" id="gown_ref_loc" enctype="multipart/form-data">
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
                
                <input name="g_refund_mode" id="g_refund_mode" type="hidden" value="0" /><?php 
                frm_vars();
                
                require_once("student_requests.php");?>

                <!--<div class="innercont_stff" style="margin-top:20px;" title="Only CSV file">
                    <label for="sbtd_pix" class="labell" style="width:auto">Upload csv file (batch update)</label>
                    <div class="div_select">
                        <input type="file" name="sbtd_pix" id="sbtd_pix"  style="width:223px" 
                        onchange="gown_ref_loc.uvApplicationNo.value=''; 
                        tidy_screen();">
                    </div>
                    <div class="labell_msg blink_text orange_msg" id="labell_msg"  style="width:280px"></div>		
                </div>-->

                <div class="innercont_stff" style="margin-top:20px;">
                    <!--<div class="div_select" style="width:240px;">
                        <select name="id_no" id="id_no" class="select" 
                        onchange="gown_ref_loc.uvApplicationNo.value=''; 
                        tidy_screen();">
                            <option value="0">Application form number (AFN)</option>
                            <option value="1" selected>Matriculation number</option>
                        </select>
                    </div>-->

                    <div id="uvApplicationNo_div" class="div_select" style="display:block">
                        <input name="uvApplicationNo" id="uvApplicationNo" type="text" class="textbox"  
                        placeholder="Enter Mat. no. here"
                        onchange="this.value=this.value.trim();
                        this.value=this.value.toUpperCase();
                        _('g_refund_mode').value=0;
                        tidy_screen()"
                        value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
                    </div>
                    <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
                </div><?php

                if (isset($_REQUEST["g_refund_mode"]) && isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '' && $_REQUEST["mm"] == '2' && $_REQUEST["sm"] == '15')
                {
                    $display = 'block';
                    $stmt = $mysqli->prepare("SELECT RetrievalReferenceNumber, tdate, Amount
                    FROM s_tranxion_cr
                    WHERE vMatricNo = ?
                    AND (vremark = 'Convocation Gown' OR fee_item_id = 31)");
                    $stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($rrr, $tdate, $Amount);
                    $stmt->fetch();
                    if (is_null($rrr))
                    {
                        $rrr = '';
                        $tdate = '';

                        $display = 'none';

                        caution_box_inline('No payment record');
                    }else if (isset($_REQUEST["g_refund_mode"]) && $_REQUEST["g_refund_mode"] == 1)
                    {
                        $stmt = $mysqli->prepare("REPLACE INTO g_refund 
                        (vApplicationNo, 
                        vMatricNo, 
                        return_date, 
                        rrr, 
                        amount,
                        pay_date,
                        bank_id,
                        account_name,
                        annount_no)
                        values
                        (?, ?, NOW(), ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("sssdssss", 
                        $_REQUEST["vApplicationNo"],  
                        $_REQUEST["uvApplicationNo"], 
                        $_REQUEST["rrr"], 
                        $_REQUEST["amount"], 
                        $_REQUEST["p_date"], 
                        $_REQUEST["bank_id"], 
                        $_REQUEST["b_account_name"], 
                        $_REQUEST["b_account_no"]);
                        $stmt->execute();
                        
                        success_box('Record saved successfully');
                    }
                    $stmt->close();?>

                    <div class="innercont_stff_tabs" style="border:0px; height:auto; margin-left:1px; margin-top:10px; width:800px; display:block">
                        <div class="innercont_stff" style="margin-bottom:-1px;">
                            <div id="div_lab_a" class="div_label" style="width:239px;">
                                Matriculation number
                            </div>
                            <div id="div_a" class="div_valu"><?php echo $_REQUEST["uvApplicationNo"];?></div>	
                        </div>
                        <div class="innercont_stff">
                            <div class="div_label" style="width:239px;">
                                Name
                            </div>
                            <div id="div_0" class="div_valu"><?php echo strtoupper($vLastName).' '.ucwords(strtoupper($vFirstName)).' '.ucwords(strtoupper($vOtherName));?></div>	
                        </div>
                        
                        <div class="innercont_stff">
                            <div class="div_label" style="width:239px;">
                                Study centre
                                <input id="studycentre_now" type="hidden"/>
                            </div>
                            <div id="div_1" class="div_valu"><?php echo $vCityName;?></div>	
                        </div>
                        
                        <div class="innercont_stff">
                            <div class="div_label" style="width:239px;">
                                Faculty
                            </div>
                            <div id="div_2"  class="div_valu"><?php echo $vFacultyDesc;?></div>	
                        </div>
                        <div class="innercont_stff">
                            <div class="div_label" style="width:239px;">
                                Department
                            </div>
                            <div id="div_3"  class="div_valu"><?php echo $vdeptDesc;?></div>	
                        </div>
                        <div class="innercont_stff">
                            <div class="div_label" style="width:239px;">
                                Programme
                            </div>
                            <div id="div_4"  class="div_valu"><?php echo $vObtQualTitle.' '.$vProgrammeDesc;?></div>	
                        </div>
                        <div class="innercont_stff">
                            <div class="div_label" style="width:239px;">
                                Begin level/Currrent level/Semester
                            </div>
                            <div id="div_5"  class="div_valu"><?php echo $iBegin_level.'/'.$iStudy_level.'/'.$tSemester_su;?></div>	
                        </div>

                        
                        <div class="innercont_stff">
                            <div class="div_label" style="width:239px;">
                                RRR
                                <input name="rrr" id="rrr" type="hidden" value="<?php echo $rrr;?>"/>
                            </div>
                            <div id="div_4"  class="div_valu"><?php echo $rrr;?></div>	
                        </div>
                        <div class="innercont_stff">
                            <div class="div_label" style="width:239px;">
                                Date
                                <input name="p_date" id="p_date" type="hidden" value="<?php echo $tdate;?>"/>
                            </div>
                            <div id="div_5"  class="div_valu"><?php echo $tdate;?></div>	
                        </div>
                        <div class="innercont_stff">
                            <div class="div_label" style="width:239px;">
                                Amount
                                <input name="amount" id="amount" type="hidden" value="<?php echo $Amount;?>"/>
                            </div>
                            <div id="div_5"  class="div_valu"><?php echo $Amount;?></div>	
                        </div>

                        
                        <div class="innercont_stff" style="display:<?php echo $display;?>">
                            <div class="div_label" style="width:239px;">
                                <input name="gown_rec" id="gown_rec" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
                                    <?php if (isset($_REQUEST["gown_rec"])){echo ' checked';}?>/>
                            </div>
                            <div id="div_5" class="div_valu">
                                <label for="gown_rec">Gown recieved</label>
                            </div>
                            <div id="labell_msg1" class="labell_msg blink_text orange_msg"></div>
                        </div>
                    </div><?php

                    $stmt = $mysqli->prepare("SELECT bank_id, acn_name, acn_no FROM s_bank_d WHERE vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST['uvApplicationNo']);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($vbank_id, $acn_name, $acn_no);
                    $stmt->fetch();
                    $stmt->close();
                    
                    if (is_null($vbank_id))
                    {
                        $vbank_id = '';
                        $acn_name = '';
                        $acn_no = '';
                    }?>
                    <div id="bank_div" class="innercont_stff_tabs" style="border:0px; height:auto; margin-left:1px; margin-bottom:20px; margin-top:10px; display:<?php echo $display;?> ">
                        <div class="innercont_stff">
                            <div class="div_label" style="width:239px;">
                                Bank
                            </div>
                            <div class="div_select">
                                <select name="bank_id" id="bank_id"  class="select" required>
                                    <option value="" selected="selected"></option><?php
                                    $sql = "SELECT ccode, vDesc FROM banks ORDER BY vDesc";
                                    $rsql = mysqli_query(link_connect_db(), $sql)or die("cannot query the database".mysqli_error(link_connect_db()));
                                    $cnt = 0;
                                    while ($table= mysqli_fetch_array($rsql))
                                    {
                                        $cnt++;
                                        if ($cnt > 0 && $cnt%5 == 0)
                                        {?>
                                            <option disaabled></option><?php
                                        }?>
                                        <option value="<?php echo $table['ccode'];?>" <?php 
                                            if (isset($_REQUEST["bank_id"]) && $_REQUEST["bank_id"] == $table["ccode"]){echo ' selected';}else if ($vbank_id == $table["ccode"]){echo ' selected';}?>><?php echo $table['vDesc'] ;?></option><?php
                                    }
                                    mysqli_close(link_connect_db());?>
                                </select>
                            </div>
                            <div id="labell_msg2" class="labell_msg blink_text orange_msg"></div>
                        </div>

                        <div class="innercont_stff">
                            <div class="div_label" style="width:239px;">
                                Account number
                            </div>
                            <div class="div_select">
                                <input name="b_account_no" id="b_account_no" type="number" class="textbox"
                                    onkeypress="if(this.value.length==10){return false}"
                                    value="<?php if (isset($_REQUEST["b_account_no"])){echo $_REQUEST["b_account_no"];}else {echo $acn_no;} ?>" required/>
                            </div>
                            <div id="labell_msg3" class="labell_msg blink_text orange_msg"></div>
                        </div>

                        <div class="innercont_stff">
                            <div class="div_label" style="width:239px;">
                                Account name
                            </div>
                            <div class="div_select">
                                <input name="b_account_name" id="b_account_name" type="text" class="textbox"
                                    onblur="if (this.value.trim()!='')
                                    {
                                        this.value=this.value.trim();
                                        this.value=this.value.replace(/\s+/g, ' ');
                                        this.value=this.value.toLowerCase();
                                        this.value=capitalizeEachWord(this.value);
                                    }"
                                    maxlength="80"
                                    value="<?php if (isset($_REQUEST["b_account_name"])){echo $_REQUEST["b_account_name"];}else {echo $acn_name;} ?>" required/>
                            </div>
                            <div id="labell_msg4" class="labell_msg blink_text orange_msg"></div>
                        </div>
                    </div><?php
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
                    
                    <div id="std_names" style="width:auto; padding-top:6px; padding-bottom:4px; border-bottom:1px dashed #888888"></div>
                    <div id="std_quali" style="width:auto; padding-top:5px; padding-bottom:5px; border-bottom:1px dashed #888888"></div>
                    <div id="std_lvl" style="width:auto; padding-top:6px;"></div>
                    <div id="std_sems" style="width:auto; padding-top:4px; padding-bottom:4px; border-bottom:1px dashed #888888"></div>				
                    <div id="std_vCityName" style="width:auto; padding-bottom:4px; border-bottom:1px dashed #888888"></div>
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