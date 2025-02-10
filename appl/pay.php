<?php 
if (!isset($_REQUEST['user_cat']))
{?>
    <div style="font-family:Verdana, Arial, Helvetica, sans-serif; 
    margin:auto; 
    text-align:center;
	font-size: 0.78em;"> Follow <a href="../" style="text-decoration:none;">here</a></div><?php
    exit;
}
// Date in the past
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('lib_fn.php');?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<title>NOUN-SMS</title>
		<link rel="icon" type="image/ico" href="./img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/pay.js"></script>

        <script language="JavaScript" type="text/javascript">
            function chk_inputs()
            {
                var letters = /^[A-Za-z '-]+$/;           

                with(to_remita)
                {
                    if (orderId.value.trim() == '' &&  rrr.value.trim() == '')
                    {
                        caution_inform("Fill out either the order ID or the RRR");
                        return false;
                    }

                    if (!vLastName.value.match(letters))
                    {
                        caution_inform("Enter alphabets only for surname please");
                        return false;
                    }

                    if (!vFirstName.value.match(letters))
                    {
                        caution_inform("Enter alphabets only for first name please");
                        return false;
                    }

                    if (vOtherName.value.trim() != '' && !vOtherName.value.match(letters))
                    {
                        caution_inform("Enter alphabets only for other name please");
                        return false;
                    }

                    if (vLastName.value.trim().length < 3)
                    {
                        caution_inform("Enter last name in full please");
                        return false;
                    }
                
                    if (vFirstName.value.trim().length < 3)
                    {
                        caution_inform("Enter first name in full please");
                        return false;
                    }
                
                    if (vOtherName.value.trim() != '' && vOtherName.value.trim().length < 3)
                    {
                        caution_inform("Enter other name in full please");
                        return false;
                    }

                    if (chk_mail(_('payerEmail')) != '')
                    {
                        caution_inform('Personal eMail address '+chk_mail(_('payerEmail')));
                        return false;
                    }

                    if (cEduCtgId.value == '')
                    {
                        caution_inform("Select a programme please");
                        return false;
                    }
                    
                    var formdata = new FormData();

                    formdata.append("rrr", rrr.value);
                    formdata.append("orderId", orderId.value);
                        
                    formdata.append("vLastName", vLastName.value);
                    formdata.append("vFirstName", vFirstName.value);
                    formdata.append("vOtherName", vOtherName.value);
                    formdata.append("vEMailId", payerEmail.value);
                    formdata.append("vMobileNo", payerPhone.value);
                    formdata.append("amount", amount.value);
                    formdata.append("confirm_pay", '1');

                    opr_prep(ajax = new XMLHttpRequest(),formdata);
                }
            }
            
            function completeHandler(event)
            {
                on_error('0');
                on_abort('0');
                in_progress('0');
                var returnedStr = event.target.responseText;//alert(returnedStr)
                
                _("submit_btn").style.display = 'block';
                _("continue_btn").style.display = 'none';

                if (returnedStr.indexOf("No match found") > -1)
                {
                    caution_inform(returnedStr);
                }else if (returnedStr.indexOf("Got AFN") > -1)
                {
                    inform("Payment already concluded successfully. Click continue to proceed");
                    _("submit_btn").style.display = 'none';
                    _("continue_btn").style.display = 'block';

                    nxt.action ='new-application-number';
                    
                    nxt.vApplicationNo.value = returnedStr.substr(7,9);
                    nxt.vApplicationNo.value.trim(); 
                    nxt.payerName.value = '';
                    nxt.payerEmail.value = to_remita.payerEmail.value;
                }else if (returnedStr.indexOf("success") != -1)
                {
                    inform("Payment already concluded successfully.<br>Click continue to login to your application form with your application form number and password<br>Check your email box for your application number<br>Click on 'Reset password' on the login page if you do not have a password<br>See guide under 'Help'");
                    _("submit_btn").style.display = 'none';
                    _("continue_btn").style.display = 'block';

                    nxt.action ='applicant_login_page';
                }else
                {
                    with(to_remita)
                    {
                        payerName.value = vLastName.value+' '+vFirstName.value+' '+vOtherName.value;
                        
                        rrr.value = returnedStr.substr(0,50).trim();
                        orderId.value = returnedStr.substr(50,50).trim();
                        p_status.value = returnedStr.substr(100,50).trim();
                        
                        submit();
                    }        
                }
            }
        </script>
        <link rel="stylesheet" type="text/css" media="all" href="styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/pay.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>
	</head>
	<body>
        <form method="post" name="ps" enctype="multipart/form-data">
            <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
            <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
            <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
            <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
            <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
        </form>
        
        <div id="smke_screen_2" class="smoke_scrn" style="display:none; z-index:5"></div>
        
        <div id="conf_box_loc" class="center top_most" 
            style="display:none;
            text-align:center; 
            padding:10px; 
            box-shadow: 2px 2px 8px 2px #726e41; 
            background:#eff5f0; 
            z-index:6">
            <div style="width:90%; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
                Confirmation
            </div>
            <a href="#" style="text-decoration:none;">
                <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
            </a>
            <div id="conf_msg_msg_loc" style="line-height:1.6; margin-top:10px; width:90%; float:left; text-align:center; padding:0px;">
                Have you checked your credentials against the requirements for admission into your programme of choice?
            </div>
            <div style="margin-top:10px; width:90%; float:right; text-align:right; padding:0px;">
                <a href="#" style="text-decoration:none;" 
                    onclick="_('conf_box_loc').style.display='none';
                    /*_('smke_screen_2').style.display='none';*/
                    _('smke_screen_2').style.zIndex='3';
                    _('labell_msg0').style.display = 'none';
                    _('application_steps').style.display = 'block';
                    return false">
                    <div class="login_button" style="width:60px; padding:6px; margin-left:10px; float:right">
                        Yes
                    </div>
                </a>

                <a href="#" style="text-decoration:none;" 
                    onclick="iamqual.side_menu.value='1'; iamqual.submit(); return false">
                    <div class="rec_pwd_button" style="width:60px; padding:6px; float:right">
                        No
                    </div>
                </a>
            </div>
        </div>
        
        
        
        <div id="container_cover_ini_pay" class="center" style="display: none; 
            flex-direction:column; 
            gap:8px;  
            justify-content:space-around; 
            height:auto;
            padding:10px;
            box-shadow: 2px 2px 8px 2px #726e41;
            z-Index:3;
            background-color: #ffffff;" title="Press escape to close">
            
            <div class="appl_left_child_div_child" style="border-bottom:1px solid #ccc;">
                <div class="prog_cat_div1" style="flex:95%; height:35px; padding-left:5px; line-height:1.8; font-weight:bold; color:#e31e24;">
                    Certificate programmes
                </div>
                
                <div class="prog_cat_div1" style="flex:4%; height:35px; padding-left:5px; line-height:1.8;">
                    <img style="width:17px; height:17px; cursor:pointer" src="./img/close.png" 
                    onclick="show_appl_cat('');
                        _('container_cover_ini_pay').style.zIndex = -1;
                        _('container_cover_ini_pay').style.display = 'none';
                        _('smke_screen').style.zIndex = -1;
                        _('smke_screen').style.display = 'none';"/>
                </div>
            </div>

            <div class="appl_left_child_div_child" style="margin-top:10px;">
                <div style="flex:99%; padding:10px; height:45px; line-height:1.6; background-color: #fdf0bf">
                    Select from certificate programmes listed below and click the Ok button
                    <br>Click the 'x' icon (top right) to cancel
                </div>
            </div><?php
             $sql = "SELECT DISTINCT a.cFacultyId, b.vFacultyDesc, a.cdeptid, e.cProgrammeId, e.vProgrammeDesc, c.vdeptDesc, a.Amount 
             FROM s_f_s a, faculty b, depts c, fee_items d, programme e
             WHERE a.fee_item_id = d.fee_item_id
             AND a.cFacultyId = b.cFacultyId
             AND c.cFacultyId = a.cFacultyId
             AND a.cdeptid = c.cdeptId
             AND e.cdeptId = c.cdeptId
             AND a.cdel = 'N' 
             AND c.cDelFlag = 'N' 
             AND d.fee_item_desc LIKE 'Application%'
             AND a.cEduCtgId = 'ELX'
             ORDER BY vFacultyDesc, a.cdeptid;";
            $rssqlEduCtgId = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
            
            $choice_count_cert = 0;
            $choice_count_cert_display = 0;

            $prev_dept = '';?>
            <div class="appl_left_child_div" 
                style="max-height:480px;
                overflow:auto; 
                overflow-x: hidden;"><?php
                while ($r_rssqlEduCtgId = mysqli_fetch_assoc($rssqlEduCtgId))
                {
                    if ($prev_dept == '' || $prev_dept <> $r_rssqlEduCtgId['vdeptDesc'])
                    {?>
                        <div class="appl_left_child_div_child" style="border-bottom:1px dashed #ccc;">
                            <div class="prog_cat_div1" style="flex:99%; height:35px; padding-left:5px; line-height:1.8; font-weight:bold">
                                <?php echo $r_rssqlEduCtgId['vFacultyDesc'].'-'.$r_rssqlEduCtgId['vdeptDesc'];?>
                            </div>
                        </div><?php
                    }?>
                    <label id="<?php echo 'lbl'.++$choice_count_cert;?>" class="lbl_beh" for="cEduCtgId<?php echo $choice_count_cert;?>">
                        <div class="appl_left_child_div_child" style="border-bottom:1px dashed #ccc;">
                            <div class="prog_cat_div1" style="flex:5%; height:35px; padding-left:5px; line-height:1.8;">
                                <?php echo $choice_count_cert;?>
                            </div>
                            <div class="prog_cat_div2" style="flex:5%; height:35px; padding-left:5px; line-height:1.8;">
                                <input type="radio" id="cEduCtgId<?php echo $choice_count_cert;?>" name="cEduCtgId_option" 
                                value="<?php echo 'ELX'.
                                str_pad('odl', 30, " ", STR_PAD_LEFT).
                                str_pad($r_rssqlEduCtgId['Amount'], 10, " ", STR_PAD_LEFT).
                                str_pad('Application Fee', 100, " ", STR_PAD_LEFT);?>" 
                                onClick="to_remita.cEduCtgId_text.value='<?php echo 'Certificate, '.$r_rssqlEduCtgId['vProgrammeDesc'].' [N'.number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',').']';?>';
                                _('amount').value ='<?php echo $r_rssqlEduCtgId['Amount'];?>';
                                to_remita.cEduCtgId.value ='ELX';
                                _('vDesc').value ='Application Fee';
                                to_remita.department.value = '<?php echo $r_rssqlEduCtgId['cdeptid'];?>';
                                
                                _('resident_ctry').value='1';
                                _('pinfo').style.display='flex';
                                _('ok_btn').style.display='flex';" <?php if ($choice_count_cert == 1){echo ' required';}?>/>
                            </div>                                            
                            <div class="prog_cat_div3" style="flex:65%; height:35px; padding-left:5px; line-height:1.8;">
                                <?php echo $r_rssqlEduCtgId['vProgrammeDesc'];?>
                            </div>
                            <div class="prog_cat_div4" style="flex:25%; height:35px; padding-right:5px; line-height:1.8; text-align:right;">
                                <?php  echo number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',');?>
                            </div>
                        </div>
                    </label><?php
                    $prev_dept = $r_rssqlEduCtgId['vdeptDesc'];
                }?>
            </div>

            <div id="ok_btn" class="appl_left_child_div_child" style="display:none; margin-top:20px;">
                <div class="prog_cat_div1" style="flex:99%; height:35px; justify-content:flex-end;">
                    <button type="submit" 
                    class="button" 
                    style="float:right; padding:8px 0px 12px 0px; border:1px solid #b6b6b6; width:30%;"
                    onclick="_('container_cover_ini_pay').style.zIndex = -1;
                    _('container_cover_ini_pay').style.display = 'none';
                    _('smke_screen').style.zIndex = -1;
                    _('smke_screen').style.display = 'none';">
                    Ok</button>
                </div>
            </div>
        </div><?php
        require_once("feedback_mesages.php");
        require_once("forms.php");
        
	    $mysqli = link_connect_db();		
	
        $sidemenu = '';
        if (isset($_REQUEST["sidemenu"]) && $_REQUEST["sidemenu"] <> '')
        {
            $sidemenu = $_REQUEST["sidemenu"];
        }?>
        <div class="appl_container">
            <?php left_conttent('Conclude hanging payment');?> 
            
            <div id="right_div" class="appl_right_div" style="font-size:1em;">
                
                <?php appl_top_menu_home();?>

                <div class="appl_left_child_div" style="text-align: left; margin:auto; margin-top:5px; max-height:90%; width:100%; overflow:auto; overflow-x:hidden; background-color: #eff5f0;">
                    <form action="confirm-pay-detail" method="post" id="to_remita" name="to_remita" enctype="multipart/form-data"               onsubmit="chk_inputs(); return false;">
                        <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
                        <input name="save" id="save" type="hidden" value="-1" />
                        <input name="rrr_sys" type="hidden" value="1" />
                        <input name="payerName" id="payerName" type="hidden" />
                        <input name="cEduCtgId" id="cEduCtgId" type="hidden" />
                        
                        <input name="department" id="department" type="hidden" />

                        <input name="cEduCtgId_text" id="cEduCtgId_text" type="hidden"/>
                        <input name="vDesc" id="vDesc" type="hidden" value="Application Fee" />
                        <input name="amount" id="amount" type="hidden" value="" />
                        <input name="p_status" id="p_status" type="hidden" />

                        <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
                        <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                        <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />

                        <div class="appl_left_child_div_child" style="margin-top:10px;">
                            <div style="flex:5%; height:50px; background-color: #ffffff"></div>
                            <div style="flex:95%; padding-left:5px; height:50px; background-color: #fdf0bf">
                                Information entered or selected on this page <b>must</b> be the same as those entered when payment was initiated<br>
                                Click/tap and select option below accordingly
                            </div>
                        </div><?php
                    
                        
                        $sql = "SELECT DISTINCT iEduCtgRank, a.cEduCtgId, e.vEduCtgDesc, a.Amount 
                        FROM s_f_s a, fee_items d, educationctg e
                        WHERE a.fee_item_id = d.fee_item_id
                        AND a.cEduCtgId = e.cEduCtgId
                        AND a.cdel = 'N' 
                        AND d.fee_item_desc LIKE 'Application%'  
                        AND a.new_old_structure = 'f'
                        AND a.cEduCtgId <> 'PGZ'
                        ORDER BY iEduCtgRank;";
                        $rssqlEduCtgId = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));  
                        

                        if (mysqli_num_rows($rssqlEduCtgId) > 0)
                        {?>
                            <div class="appl_left_child_div_child cat_div" onclick="show_appl_cat('lbl_beh_f')" style="cursor:pointer">
                                <div style="flex:5%; height:35px; padding-left:5px; background-color: #eff5f0">A.</div>
                                <div style="flex:5%; height:35px; padding-left:5px; background-color: #eff5f0">
                                    <img width="10" height="10" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>" alt="More options">
                                </div>
                                <div style="flex:70%; height:35px; padding-left:5px;">
                                    Applicants residing outside Nigeria
                                </div>
                                <div style="flex:20%; height:35px; padding-left:5px; background-color: #eff5f0;font-weight:bold;text-align:right">
                                    Amount ($)
                                </div>
                            </div><?php
                        }

                        $choice_count = 0;
                        $choice_count_display = 0;
                        while ($r_rssqlEduCtgId = mysqli_fetch_assoc($rssqlEduCtgId))
                        {
                            $choice_count++;?>
                            <label id="<?php echo 'lbl'.$choice_count;?>" class="lbl_beh_f" for="cEduCtgId<?php echo $choice_count;?>_f" style="display:none">
                                <div class="appl_left_child_div_child">
                                    <div class="prog_cat_div1" style="flex:5%; height:35px; padding-left:5px; background-color: #FFFFFF">
                                        <?php echo $choice_count;?>
                                    </div>
                                    <div class="prog_cat_div2" style="flex:5%; height:35px; padding-left:5px;  background-color: #FFFFFF">
                                        <input type="radio" id="cEduCtgId<?php echo $choice_count;?>_f" name="cEduCtgId_option" 
                                        value="<?php echo $r_rssqlEduCtgId['cEduCtgId'].
                                        str_pad('odl', 30, " ", STR_PAD_LEFT).
                                        str_pad($r_rssqlEduCtgId['Amount'], 10, " ", STR_PAD_LEFT).
                                        str_pad('Application Fee', 100, " ", STR_PAD_LEFT);?>" 
                                        onClick="to_remita.cEduCtgId_text.value='<?php echo $r_rssqlEduCtgId['vEduCtgDesc'].' [$'.number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',').']';?>';
                                        _('amount').value ='<?php echo $r_rssqlEduCtgId['Amount'];?>';
                                        to_remita.cEduCtgId.value ='<?php echo $r_rssqlEduCtgId['cEduCtgId'];?>';
                                        _('vDesc').value ='Application Fee';
                                        to_remita.department.value = ''; 
                                        _('resident_ctry').value='0';
                                        _('pinfo').style.display='flex';"/>
                                    </div>                                            
                                    <div class="prog_cat_div3" style="flex:65%; height:35px; padding-left:5px; background-color: #FFFFFF">
                                        <?php echo $r_rssqlEduCtgId['vEduCtgDesc'];?>
                                    </div>
                                    <div class="prog_cat_div4" style="flex:25%; height:35px; padding-right:5px; background-color: #FFFFFF; text-align:right;">
                                        <?php  echo number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',');?>
                                    </div>
                                </div>
                            </label><?php
                        }




                        $sql = "SELECT DISTINCT iEduCtgRank, a.cEduCtgId, e.vEduCtgDesc, a.Amount 
                        FROM s_f_s a, fee_items d, educationctg e
                        WHERE a.fee_item_id = d.fee_item_id
                        AND a.cEduCtgId = e.cEduCtgId
                        AND a.cdel = 'N' 
                        AND d.fee_item_desc LIKE 'Application%'  
                        AND a.new_old_structure <> 'f' 
                        AND a.cdeptid <> 'CPE'
                        AND a.cEduCtgId <> 'ELX'
                        AND a.cEduCtgId <> 'PGZ'
                        ORDER BY iEduCtgRank;";
                        $rssqlEduCtgId = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));                        
                        $choice_count = 0;

                        if (mysqli_num_rows($rssqlEduCtgId) > 0)
                        {?>
                            <div class="appl_left_child_div_child cat_div" onclick="show_appl_cat('lbl_beh_l')" style="cursor:pointer">
                                <div style="flex:5%; height:35px; padding-left:5px; background-color: #eff5f0">B.</div>
                                <div style="flex:5%; height:35px; padding-left:5px; background-color: #eff5f0">
                                    <img width="10" height="10" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>" alt="More options">
                                </div>
                                <div style="flex:70%; height:35px; padding-left:5px;">
                                    Applicants residing in Nigeria
                                </div>
                                <div style="flex:20%; height:35px; padding-left:5px; background-color: #eff5f0;font-weight:bold;text-align:right">
                                    Amount (N)
                                </div>
                            </div>
                            
                            <label id="<?php echo 'lbl'.$choice_count;?>" class="lbl_beh_l" style="display:none; cursor:pointer" title="More options"
                                onClick="show_appl_cat('lbl_beh_l');
                                _('container_cover_ini_pay').style.zIndex = 3;
                                _('container_cover_ini_pay').style.display = 'block';
                                _('smke_screen').style.zIndex = 2;
                                _('smke_screen').style.display = 'block';">
                                <div class="appl_left_child_div_child">
                                    <div class="prog_cat_div1" style="flex:5%; height:35px; padding-left:5px;">
                                        <img width="8" height="8" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'add.png');?>"/>
                                    </div>
                                    <div class="prog_cat_div2" style="flex:5%; height:35px; padding-left:5px;">
                                        <input type="radio" id="cEduCtgId<?php echo $choice_count;?>_l" name="cEduCtgId_option" 
                                       />
                                    </div>                                            
                                    <div class="prog_cat_div3" style="flex:65%; height:35px; padding-left:5px;">
                                        Certificate programmes
                                    </div>
                                    <div class="prog_cat_div4" style="flex:25%; height:35px; padding-right:5px; text-align:right;"></div>
                                </div>
                            </label><?php
                        }

                        $choice_count_display = 0;
                        $choice_count = 0;
                        while ($r_rssqlEduCtgId = mysqli_fetch_assoc($rssqlEduCtgId))
                        {
                            $choice_count++;?>

                            <label id="<?php echo 'lbl'.$choice_count;?>" class="lbl_beh_l" for="cEduCtgId<?php echo $choice_count;?>_l" style="display:none">
                                <div class="appl_left_child_div_child">
                                    <div class="prog_cat_div1" style="flex:5%; height:35px; padding-left:5px; background-color: #FFFFFF">
                                        <?php echo $choice_count;?>
                                    </div>
                                    <div class="prog_cat_div2" style="flex:5%; height:35px; padding-left:5px;  background-color: #FFFFFF">
                                        <input type="radio" id="cEduCtgId<?php echo $choice_count;?>_l" name="cEduCtgId_option" 
                                        value="<?php echo $r_rssqlEduCtgId['cEduCtgId'].
                                        str_pad('odl', 30, " ", STR_PAD_LEFT).
                                        str_pad($r_rssqlEduCtgId['Amount'], 10, " ", STR_PAD_LEFT).
                                        str_pad('Application Fee', 100, " ", STR_PAD_LEFT);?>" 
                                        onClick="to_remita.cEduCtgId_text.value='<?php echo $r_rssqlEduCtgId['vEduCtgDesc'].' [N'.number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',').']';?>';
                                        _('amount').value ='<?php echo $r_rssqlEduCtgId['Amount'];?>';
                                        to_remita.cEduCtgId.value ='<?php echo $r_rssqlEduCtgId['cEduCtgId'];?>';
                                        _('vDesc').value ='Application Fee';
                                        to_remita.department.value = ''; 
                                                                                
                                        _('resident_ctry').value='1';
                                        _('pinfo').style.display='flex';"/>
                                    </div>                                            
                                    <div class="prog_cat_div3" style="flex:65%; height:35px; padding-left:5px; background-color: #FFFFFF">
                                        <?php echo $r_rssqlEduCtgId['vEduCtgDesc'];?>
                                    </div>
                                    <div class="prog_cat_div4" style="flex:25%; height:35px; padding-right:5px; background-color: #FFFFFF; text-align:right;">
                                        <?php  echo number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',');?>
                                    </div>
                                </div>
                            </label><?php
                        }


                        $sql = "SELECT DISTINCT iEduCtgRank, a.cEduCtgId, e.vEduCtgDesc, a.Amount 
                        FROM s_f_s a, fee_items d, educationctg e
                        WHERE a.fee_item_id = d.fee_item_id
                        AND a.cEduCtgId = e.cEduCtgId
                        AND a.cdel = 'N' 
                        AND d.fee_item_desc LIKE 'Application%' 
                        AND a.cdeptid = 'CPE'
                        AND a.new_old_structure <> 'f'
                        AND a.cEduCtgId <> 'ELX'
                        AND a.cEduCtgId <> 'PGZ'
                        ORDER BY iEduCtgRank;";
                        $rssqlEduCtgId = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));                        
                        
                        while ($r_rssqlEduCtgId = mysqli_fetch_assoc($rssqlEduCtgId))
                        {
                            $choice_count++;?>

                            <label id="<?php echo 'lbl'.$choice_count;?>" class="lbl_beh_l" for="cEduCtgId<?php echo $choice_count;?>_l" style="display:none">
                                <div class="appl_left_child_div_child" style="margin-top:20px">
                                    <div class="prog_cat_div1" style="flex:5%; height:45px; padding-left:5px; background-color: #FFFFFF">
                                        <?php echo ++$choice_count_display.', '.$choice_count;?>
                                    </div>
                                    <div class="prog_cat_div2" style="flex:5%; height:45px; padding-left:5px;  background-color: #FFFFFF">
                                        <input type="radio" id="cEduCtgId<?php echo $choice_count;?>_l" name="cEduCtgId_option" 
                                        value="<?php echo $r_rssqlEduCtgId['cEduCtgId'].
                                        str_pad('odl', 30, " ", STR_PAD_LEFT).
                                        str_pad($r_rssqlEduCtgId['Amount'], 10, " ", STR_PAD_LEFT).
                                        str_pad('Application Fee', 100, " ", STR_PAD_LEFT);?>" 
                                        onClick="to_remita.cEduCtgId_text.value='<?php echo $r_rssqlEduCtgId['vEduCtgDesc'].' [N'.number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',').']';?>';
                                        _('amount').value ='<?php echo $r_rssqlEduCtgId['Amount'];?>';
                                        to_remita.cEduCtgId.value ='<?php echo $r_rssqlEduCtgId['cEduCtgId'];?>';
                                        _('vDesc').value ='Application Fee';
                                        to_remita.department.value = ''; 
                                                                                
                                        _('resident_ctry').value='0';
                                        _('pinfo').style.display='flex';"/>
                                    </div>                                            
                                    <div class="prog_cat_div3" 
                                        style="flex:65%; height:45px; padding-left:5px; background-color: #FFFFFF" 
                                        title="Common wealth executive Masters in Business Administration (CEMBA)/Common wealth executive Masters in Public Administration (CEMPA)">
                                        <?php echo $r_rssqlEduCtgId['vEduCtgDesc'].' '.'CEMBA/CEMPA Programmes <font style="color: #e31e24">(In addition to the admission requirement, candidate must possess at least 3 years of managerial experience from a recognized organization)</font>';?>
                                    </div>
                                    <div class="prog_cat_div4" style="flex:25%; height:45px; padding-right:5px; background-color: #FFFFFF; text-align:right;">
                                        <?php  echo number_format($r_rssqlEduCtgId['Amount'], 2, '.', ',');?>
                                    </div>
                                </div>
                            </label><?php
                        }
                        mysqli_close(link_connect_db());?>
                        <input name="resident_ctry" id="resident_ctry" type="hidden"/>

                        <div id="pinfo" class="appl_left_child_div_child" style="display:none; flex-flow: column; margin-top:10px;">
                            <div class="appl_left_child_div_child" style="margin-top:15px;">
                                <div style="flex:5%; padding-left:5px; height:50px; background-color: #ffffff">
                                </div>
                                <div style="flex:95%; padding-left:5px; height:50px; background-color: #fdf0bf">
                                    Enter either Order ID or RRR
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:50px; background-color: #ffffff">
                                    11
                                </div>
                                <div style="flex:25%; padding-left:5px; height:50px; background-color: #ffffff">
                                    <label for="orderId">Order ID</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="orderId" id="orderId" type="number"
                                        onchange="this.value=this.value.trim();
                                        this.value=this.value.replace(/ /g, '');" 
                                        placeholder="Either you enter order ID here or RRR below"
                                        autocomplete="off"
                                        onkeypress="if(this.value.length==12){return false}"/>
                                </div>
                            </div>

                            <div class="appl_left_child_div_child" style="margin-bottom:15px">
                                <div style="flex:5%; padding-left:5px; height:50px; background-color: #ffffff">
                                    12
                                </div>
                                <div style="flex:25%; padding-left:5px; height:50px; background-color: #ffffff">
                                    <label for="rrr">Remita retrieval reference (RRR)</label>
                                </div>
                                <div style="flex:70%; height:50px; background-color: #ffffff">
                                    <input name="rrr" id="rrr" type="number"
                                    
                                    onchange="this.value=this.value.trim();
                                        this.value=this.value.replace(/ /g, '');"  
                                        placeholder="Either you enter RRR here or order ID above"
                                        autocomplete="off"
                                        onkeypress="if(this.value.length==12){return false}" />
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:40px; background-color: #ffffff">
                                    1
                                </div>
                                <div style="flex:25%; padding-left:5px; height:40px; background-color: #ffffff">
                                    <label for="vLastName">Surname</label>
                                </div>
                                <div style="flex:70%; height:40px; background-color: #ffffff">
                                    <input name="vLastName" id="vLastName" type="text"
                                    maxlength="50"
                                    onchange="this.value=this.value.trim();
                                    this.value=this.value.toUpperCase();
                                    _('payerName').value = _('vLastName').value +' '+ _('vFirstName').value +' '+ _('vOtherName').value;"
                                    autocomplete="off"
                                    required />
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:40px; background-color: #ffffff">
                                    2
                                </div>
                                <div style="flex:25%; padding-left:5px; height:40px; background-color: #ffffff">
                                    <label for="vFirstName">First name</label>
                                </div>
                                <div style="flex:70%; height:40px; background-color: #ffffff">
                                    <input name="vFirstName" id="vFirstName" type="text"
                                    maxlength="50"
                                    onchange="this.value=this.value.trim();this.value=capitalizeEachWord(this.value);
                                    _('payerName').value = _('vLastName').value +' '+ _('vFirstName').value +' '+ _('vOtherName').value;"
                                    autocomplete="off"
                                    required />
                                </div>
                            </div>

                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:40px; background-color: #ffffff">
                                    3
                                </div>
                                <div style="flex:25%; padding-left:5px; height:40px; background-color: #ffffff">
                                    <label for="vOtherName">Other name</label>
                                </div>
                                <div style="flex:70%; height:40px; background-color: #ffffff">
                                    <input name="vOtherName" id="vOtherName" type="text"
                                    maxlength="50"
                                    onchange="this.value=this.value.trim();this.value=capitalizeEachWord(this.value);
                                    _('payerName').value = _('vLastName').value +' '+ _('vFirstName').value +' '+ _('vOtherName').value;"
                                    autocomplete="off" />
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:40px; background-color: #ffffff">
                                    4
                                </div>
                                <div style="flex:25%; padding-left:5px; height:40px; background-color: #ffffff">
                                    <label for="payerEmail">Personal eMail address</label>
                                </div>
                                <div style="flex:70%; height:40px; background-color: #ffffff">
                                    <input name="payerEmail" id="payerEmail" type="email"
                                    maxlength="50"
                                    style="height:80%;"
                                    onchange="this.value=this.value.trim();"
                                    autocomplete="off"
                                    required />
                                </div>
                            </div>

                            <div  class="appl_left_child_div_child">
                                <div style="flex:5%; padding-left:5px; height:40px; background-color: #ffffff">
                                    5
                                </div>
                                <div style="flex:25%; padding-left:5px; height:40px; background-color: #ffffff">
                                    <label for="payerPhone">Personal phone number</label>
                                </div>
                                <div style="flex:70%; height:40px; background-color: #ffffff">
                                    <input name="payerPhone" id="payerPhone" 
                                    type="number"
                                    autocomplete="off"
                                    onkeypress="if(this.value.length==12){return false};
                                    /*if (_('resident_ctry').value=='1')
                                    {
                                        if(this.value.length==12){return false}
                                    }else
                                    {
                                        if(this.value.length==13){return false}
                                    }*/"
                                    onchange="this.value=this.value.trim();" required />
                                </div>
                            </div>

                            <div style="display:flex; 
                                flex-flow: row;
                                justify-content: flex-end;
                                flex:100%;
                                height:auto; 
                                margin-top:10px;">
                                    <button id="submit_btn" type="submit" class="login_button" style="display:block">Submit</button>
                                    <button id="continue_btn" type="button" class="login_button" style="display:none" onclick="nxt.submit();">Continue</button>
                            </div>
                        </div>
                    </form>
                    <form action="new-application-number" method="post" name="nxt" enctype="multipart/form-data">
                        <input name="vApplicationNo" type="hidden" />
                        <input name="study_mode" type="hidden" value="" />
                        <input name="cEduCtgId" type="hidden" />
                        <input name="user_cat" type="hidden" value="1" />
                        <input name="nap" type="hidden" value="1" />
                            
                        <input name="payerEmail" id="payerEmail" type="hidden" />
                        <input name="payerPhone" id="payerPhone" type="hidden" />
                        <input name="payerName" id="payerName" type="hidden" />
                    </form>
                </div>
            </div>
        </div>
	</body>
</html>