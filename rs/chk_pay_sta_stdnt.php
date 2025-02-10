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
		<link rel="icon" type="image/ico" href="../appl/img/left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="../appl/js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/chk_pay_sta.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>

        <script language="JavaScript" type="text/javascript">
            function _(el)
            {
                return document.getElementById(el)
            }


            function chk_inputs_cps()
            {
                with(chk_p_sta)
                {
                    if (orderId.value == '' && rrr.value == '')
                    {
                        caution_inform('Fill out the box for either RRR or Oreder ID. Number only');
                        return false;
                    }else if (_('btn_clk').value == 'see')
                    {
                        ps.rrr.value = rrr.value;
                        ps.orderId.value = orderId.value;

                        ps.action = 'see-payment-receipt';
                        ps.target= '_blank';
                        ps.submit();
                    }else
                    {
                        var formdata = new FormData()
                        
                        formdata.append("user_cat", user_cat.value);
                        formdata.append("vMatricNo", vMatricNo.value);
                        formdata.append("ilin", ilin.value);
                        formdata.append("student_enq", 1);

                        formdata.append("rrr", rrr.value);
                        formdata.append("orderId", orderId.value);
                        formdata.append("vDesc_loc", "Wallet Funding");
                        
                        formdata.append("payerName", payerName.value);
                        formdata.append("s_name", s_name.value);
                        formdata.append("f_name", f_name.value);
                        formdata.append("o_name", o_name.value);
                        
                        formdata.append("payerPhone", payerPhone.value);
                            
                        formdata.append("iStudy_level", iStudy_level.value);
                        formdata.append("tSemester", tSemester.value);
                        
                        formdata.append("faculty", _('faculty').value);
                        formdata.append("educationcat", _('educationcat').value);
                        formdata.append("locality", _('locality').value);

                        opr_prep(ajax = new XMLHttpRequest(),formdata);
                    }
                }
            }	

            function opr_prep(ajax,formdata)
            {
                ajax.upload.addEventListener("progress", progressHandler, false);
                ajax.addEventListener("load", completeHandler, false);
                ajax.addEventListener("error", errorHandler, false);
                ajax.addEventListener("abort", abortHandler, false);
                
                ajax.open("POST", "back_end_payment_check");
                
                ajax.send(formdata);
            }


            function completeHandler(event)
            {
                on_error('0');
                on_abort('0');
                in_progress('0');

                var returnedStr = event.target.responseText;
                
                if (returnedStr.indexOf("uccessful") != -1)
                {
                    inform(returnedStr);
                    get_payment_receipt.style.display = 'block';
                }else
                {
                    caution_inform(returnedStr)
                }
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
        </script>

        <link rel="stylesheet" type="text/css" media="all" href="../appl/styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/chk_pay_sta.css" />
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
            
        <form action="std_login_page" method="post" name="ps" enctype="multipart/form-data" onsubmit="chk_mtn(); return false">
            <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
            <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"]) && $_REQUEST["ilin"] <> ''){echo $_REQUEST["ilin"];}?>" />
            <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
            
            <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
            <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />

            <input name="iStudy_level" id="iStudy_level" type="hidden" value="<?php echo $iStudy_level_loc;?>" />
            <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester_loc;?>" />
            
            <input name="faculty" id="faculty" type="hidden" value="<?php echo $cFacultyId_loc;?>" />
            <input name="educationcat" id="educationcat" type="hidden" value="<?php echo $cEduCtgId_loc;?>" />
            <input name="locality" id="locality" type="hidden" value="<?php echo $cResidenceCountryId_loc;?>" />
            
            <input name="rrr" id="rrr" type="hidden" />
            <input name="orderId" id="orderId" type="hidden" />
        </form>

        <div class="appl_container">
            <div class="appl_left_div" style="z-index:2;">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em">Check payment status</div>
                
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
                </div>

                <div class="appl_left_child_div" style="width:98%; margin:auto; max-height:95%; margin-top:10px; overflow:auto;  background-color:#eff5f0">
                    <form action="" method="post" name="chk_p_sta" target="_blank" id="chk_p_sta" enctype="multipart/form-data">
                        <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
                        <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"]) && $_REQUEST["ilin"] <> ''){echo $_REQUEST["ilin"];}?>" />
                        <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
                        
                        <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
                        <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />
                        
                        <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId']) && $_REQUEST['cEduCtgId'] <> ''){echo $_REQUEST['cEduCtgId'];}else{echo $cEduCtgId_loc;}?>" />
                        
                        <input name="tSemester_gpin1" id="tSemester_gpin1" type="hidden" value="<?php if (isset($_REQUEST['tSemester_gpin1']) && $_REQUEST['tSemester_gpin1'] <> ''){echo $_REQUEST['tSemester_gpin1'];}?>" />
                        <input name="tSemester" id="tSemester" type="hidden" value="<?php echo $tSemester_loc;?>" />
                        
                        <input name="request_id" id="request_id" type="hidden" value="<?php if (isset($_REQUEST["request_id"]) && $_REQUEST["request_id"] <> ''){echo '2';}else{echo '1';}?>" />

                        <input name="btn_clk" id="btn_clk" type="hidden" />

                        <input id="payerName" name="payerName" value="<?php if (isset($vLastName_loc)){echo $vLastName_loc.' '.$vFirstName_loc.' '.$vOtherName_loc;} ?>" type="hidden"/>
                        <input id="s_name" name="s_name" value="<?php if (isset($vLastName_loc)){echo $vLastName_loc;} ?>" type="hidden"/>
                        <input id="f_name" name="f_name" value="<?php if (isset($vFirstName_loc)){echo $vFirstName_loc;} ?>" type="hidden"/>
                        <input id="o_name" name="o_name" value="<?php if (isset($vOtherName_loc)){echo $vOtherName_loc;} ?>" type="hidden"/>

                        <input id="payerPhone" name="payerPhone" value="<?php if (isset($vMobileNo_loc)){echo $vMobileNo_loc;} ?>" type="hidden"/>

                        <div class="appl_left_child_div_child" style="margin-bottom:10px;">
                            <div style="flex:5%; height:60px; background-color: #eff5f0"></div>
                            <div style="flex:95%; padding:6px 0px 4px 8px; height:60px; background-color: #eff5f0; font-weight:bold">
                                Enter either the RRR or the order ID
                            </div>
                        </div>
                        
                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding:6px 0px 4px 8px; height:60px; background-color: #ffffff">
                                1
                            </div>
                            <div style="flex:25%; padding:6px 0px 4px 8px; height:60px; background-color: #ffffff">
                                <label for="rrr">Remita retrieval reference (RRR)</label>
                            </div>
                            <div style="flex:70%; padding:6px 0px 4px 8px; height:60px; background-color: #ffffff">
                                <input name="rrr" id="rrr" type="number"
                                    onkeypress="if(this.value.length==12){return false}" />
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding:6px 0px 4px 8px; height:60px; background-color: #ffffff">
                                2
                            </div>
                            <div style="flex:25%; padding:6px 0px 4px 8px; height:60px; background-color: #ffffff">
                                <label for="orderId">Order ID</label>
                            </div>
                            <div style="flex:70%; padding:6px 0px 4px 8px; height:60px; background-color: #ffffff">
                                <input name="orderId" id="orderId" type="number"
                                    onkeypress="if(this.value.length==12){return false}" />
                            </div>
                        </div>
                         
                        <div id="btn_div" style="display:flex; 
                            flex:100%;
                            height:auto; 
                            margin-top:10px;">
                                <button id="get_payment_receipt" type="button" class="login_button" onclick="_('btn_clk').value='see';chk_inputs_cps();" style="display:none">See receipt</button>
                                <button type="button" class="login_button" onclick="_('btn_clk').value='check';chk_inputs_cps();">Check</button>
                        </div>
                       
                        </div>
                    </form>
                </div>
                <div id="menu_bs_scrn">
                   <?php build_menu_right($balance);?>
                </div>
            </div>
        </div>
	</body>
</html>