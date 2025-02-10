<?php
// Date in the past
require_once('good_entry.php');
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
		<script language="JavaScript" type="text/javascript" src="./bamboo/bnk_dtl.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="../appl/styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/bnk_dtl.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_side_menu.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>        
        
        <style>
            
        </style>
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
                
                $vbank_id = '';
                $acn_name = '';
                $acn_no = '';

                if (isset($_REQUEST['vMatricNo']))
                {
                    $stmt = $mysqli->prepare("SELECT bank_id, acn_name, acn_no FROM s_bank_d WHERE vMatricNo = ?");
                    $stmt->bind_param("s", $_REQUEST['vMatricNo']);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($vbank_id, $acn_name, $acn_no);
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
                        
                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                1
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                <label for="bank_id">Bank</label>
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                <select name="bank_id" id="bank_id" style="height:100%;" required>
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
                                            if ($vbank_id == $table["ccode"]){echo 'selected';}?>><?php echo $table['vDesc'] ;?></option><?php
                                    }
                                    mysqli_close(link_connect_db());?>
                                </select>
                                <input name="bank_id_h" id="bank_id_h" type="hidden" value="<?php echo $vbank_id; ?>" />
                            </div>
                        </div>
                        
                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                2
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                <label for="b_account_no">Account number</label>
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                <input name="b_account_no" id="b_account_no" type="number" 
                                    value="<?php echo $acn_no; ?>"
                                    onkeypress="if(this.value.length==10){return false}" required/>
                                <input name="b_account_no_h" id="b_account_no_h" type="hidden" value="<?php echo $acn_no; ?>" />
                            </div>
                        </div>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-left:4px; height:48px; background-color: #ffffff">
                                3
                            </div>
                            <div style="flex:25%; padding-left:4px; height:48px; background-color: #ffffff">
                                <label for="b_account_name">Account name</label>
                            </div>
                            <div style="flex:70%; padding-left:4px; height:48px; background-color: #ffffff">
                                <input name="b_account_name" id="b_account_name" type="text"
                                    onblur="if (this.value.trim()!='')
                                    {
                                        this.value=this.value.trim();
                                        this.value=this.value.replace(/\s+/g, ' ');
                                        this.value=this.value.toLowerCase();
                                        this.value=capitalizeEachWord(this.value);
                                    }"  value="<?php echo $acn_name; ?>"
                                    maxlength="80" required/>
                                <input name="b_account_name_h" id="b_account_name_h" type="hidden" value="<?php echo $acn_name; ?>" />
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