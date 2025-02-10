<?php
require_once('good_entry.php');
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
		<link rel="icon" type="image/ico" href="<?php echo BASE_FILE_NAME_FOR_IMG;?>left_side_logo.png" />
		<script language="JavaScript" type="text/javascript" src="<?php echo BASE_FILE_NAME;?>js_file_1.js"></script>
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>

        <link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE_FILE_NAME;?>styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/ewallet.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/rs_side_menu.css" />
        <noscript>Please, enable JavaScript on your browser</noscript>

        
        <style></style>
        
	
        <script language="JavaScript" type="text/javascript">
            function _(el)
            {
                return document.getElementById(el)
            }
        </script>
	</head>
	<body><?php
	    $mysqli = link_connect_db();

        $orgsetins = settns();
        
        require_once(BASE_FILE_NAME."feedback_mesages.php");
        require_once("forms.php");
        
        require_once("std_detail_pg1.php");
        require_once("./set_scheduled_dates.php");
                    
        $balance = 0.00;?>        
            
        <form action="std_login_page" method="post" name="ps" enctype="multipart/form-data" onsubmit="chk_mtn(); return false">
            <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
            <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"]) && $_REQUEST["ilin"] <> ''){echo $_REQUEST["ilin"];}?>" />
            <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
            
            <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
            <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />
        </form>

        <div class="appl_container">
            <div class="appl_left_div" style="z-index:2;">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em">Statement of account (e-Wallet)</div>
                
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
                    <?php build_menu_right($balance);?>
                </div>
                <div class="appl_left_child_div" style="width:98%; margin:auto; height:15%; margin-top:10px; overflow-x: hidden; overflow-y: scroll;  background-color:#eff5f0">
                    <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                        <div style="flex:5%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                            Sn
                        </div>
                        <div style="flex:15%; padding-left:4px; height:35px; background-color: #ffffff">
                            Date
                        </div>
                        <div style="flex:50%; padding-left:4px; height:35px; background-color: #ffffff">
                            Session-Level-Semester Description-RRR
                        </div>
                        <div style="flex:10%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                            Debit(N)
                        </div>
                        <div style="flex:10%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                            Credit(N)
                        </div>
                        <div style="flex:10%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                            Balance(N)
                        </div>
                    </div>
                </div>
                <div class="appl_left_child_div" style="width:98%; margin:auto; max-height:80%; margin-top:10px; overflow:auto;  background-color:#eff5f0"><?php
                    if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] == '3')
                    {
                        $wallet_trn_cnt = 0;                                               
                                                    
                        $stmt = $mysqli->prepare("SELECT n_balance, narata
                        FROM s_tranxion_prev_bal1
                        WHERE vMatricNo = ?;");							
                        $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($balance_loc, $narata);
                        $stmt->fetch();
                
                        if (is_null($balance_loc))
                        {
                            $balance_loc = 0.00;
                            $narata = 'Opening balance';
                        }
                        //echo $balance_loc.'<br>';                            
                        
                        $stmt_b = $mysqli->prepare("SELECT SUM(amount)
                        FROM s_tranxion_cr
                        WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_open_date')
                        AND vMatricNo = ?;");							
                        $stmt_b->bind_param("s", $_REQUEST["vMatricNo"]);
                        $stmt_b->execute();
                        $stmt_b->store_result();
                        $stmt_b->bind_result($old_cr_bal);
                        $stmt_b->fetch();
                        
                        if (is_null($old_cr_bal))
                        {
                            $old_cr_bal = 0.00;
                        }                            
                        //echo $old_cr_bal.'<br>';

                        $stmt_b = $mysqli->prepare("SELECT SUM(amount)
                        FROM $wrking_year_tab
                        WHERE (tdate >= '$semester_begin_date' AND tdate < '$account_open_date')
                        AND cCourseId NOT LIKE 'F0%'
                        AND trans_count IS NOT NULL
                        AND vMatricNo = ?;");							
                        $stmt_b->bind_param("s", $_REQUEST["vMatricNo"]);
                        $stmt_b->execute();
                        $stmt_b->store_result();
                        $stmt_b->bind_result($old_dr_bal);
                        $stmt_b->fetch();
                        $stmt_b->close();
                        
                        if (is_null($old_dr_bal))
                        {
                            $old_dr_bal = 0.00;
                        }
                        
                        //echo $old_dr_bal;
                        
                        $balance_loc = $balance_loc + ($old_cr_bal - $old_dr_bal);                        
                        $opening_balance = $balance_loc;?>

                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                <?php echo ++$wallet_trn_cnt;?>
                            </div>
                            <div style="flex:15%; padding-left:4px; height:35px; background-color: #ffffff">
                                <?php echo $account_open_date ?>
                            </div>
                            <div style="flex:50%; padding-left:4px; height:35px; background-color: #ffffff">
                                <?php echo $narata;?>
                            </div>
                            <div style="flex:10%; padding-right:4px; height:35px; background-color: #ffffff; color:#e31e24; text-align:right;"><?php 
                                if ($balance_loc < 0.00)
                                {
                                    echo number_format($balance_loc, 2, '.', ',');
                                    //$balance = $Amount_bal;
                                }else
                                {
                                    echo '--';
                                }?>
                            </div>
                            <div style="flex:10%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"><?php 
                                if ($balance_loc >= 0.00)
                                {
                                    echo number_format($balance_loc, 2, '.', ',');
                                    //$balance = $Amount_bal;
                                }else
                                {
                                    echo '--';
                                }?>
                            </div>
                            <div style="flex:10%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                <?php echo number_format($balance_loc, 2, '.', ','); ?>
                            </div>
                        </div><?php

                        $stmt = $mysqli->prepare("SELECT tdate, cCourseId, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester) vDesc,  cTrntype, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc 
                        FROM s_tranxion_cr a, fee_items b
                        WHERE a.fee_item_id = b.fee_item_id
                        AND a.tdate NOT LIKE '0000%'
                        AND LEFT(a.tdate,10) > '$account_close_date'
                        AND b.cdel = 'N'
                        AND vMatricNo = ?
                        ORDER BY tdate;");
                        
                        $stmt->bind_param("s", $_REQUEST['vMatricNo']);
                        $stmt->execute();
                        $stmt->store_result();
                        
                        $stmt->bind_result($tdate, $cCourseId, $vDesc, $cTrntype, $Amount_a, $vremark, $RetrievalReferenceNumber, $fee_item_desc);
                        
                        $credit_balance = 0;
                        while($stmt->fetch())
                        {?>    
                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                    <?php echo ++$wallet_trn_cnt;?>
                                </div>
                                <div style="flex:15%; padding-left:4px; height:35px; background-color: #ffffff">
                                    <?php echo $tdate ?>
                                </div>
                                <div style="flex:50%; padding-left:4px; height:35px; background-color: #ffffff">
                                    <?php if ($cCourseId <> 'xxxxxx' && strlen($cCourseId) == 6){echo ' '.$cCourseId.' ';}
                                    echo $vDesc;
                                    if($vremark == 'Registration Deduction'){echo ' '.$fee_item_desc;}else{echo ' '.$vremark;}
                                    if ($RetrievalReferenceNumber <> '0000'){echo ' '.$RetrievalReferenceNumber;}?>
                                </div>
                                <div style="flex:10%; padding-right:4px; height:35px; background-color: #ffffff; color:#e31e24; text-align:right;"><?php 
                                    echo '--';?>
                                </div>
                                <div style="flex:10%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"><?php 
                                   echo number_format($Amount_a, 2, '.', ',');
                                    $balance_loc = $balance_loc + $Amount_a;
                                    $credit_balance += $Amount_a;?>
                                </div>
                                <div style="flex:10%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                    <?php echo number_format($balance_loc, 2, '.', ','); ?>
                                </div>
                            </div><?php
                        }

                        if ($wallet_trn_cnt == 0)
                        {?>
                            <div class="appl_left_child_div_child calendar_grid inlin_message_color">
                                <div style="flex:5%; padding-right:4px; height:35px; text-align:center;">
                                    There are no credit transactions to display
                                </div>
                            </div><?php
                        }

                        /*if ($neg_bal == 0)
                        {
                            $table = search_starting_pt($_REQUEST['vMatricNo']);
                            $wallet_trn_cnt = 0;
                            
                            foreach ($table as &$value)
                            {
                                $wrking_tab = 's_tranxion_'.$value;
                                
                                //echo $wrking_tab;
                            
                                $stmt = $mysqli->prepare("SELECT tdate, cCourseId, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester) vDesc,  cTrntype, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc 
                                FROM $wrking_tab a, fee_items b
                                WHERE a.fee_item_id = b.fee_item_id
                                AND b.cdel = 'N'
                                AND vMatricNo = ?
                                ORDER BY cTrntype, tdate;");
                                
                                $stmt->bind_param("s", $_REQUEST['vMatricNo']);
                                $stmt->execute();
                                $stmt->store_result();
                                
                                $stmt->bind_result($tdate, $cCourseId, $vDesc, $cTrntype, $Amount_a, $vremark, $RetrievalReferenceNumber, $fee_item_desc);
                            
                                while($stmt->fetch())
                                {?>    
                                    <div class="appl_left_child_div_child calendar_grid">
                                        <div style="flex:5%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                            <?php echo ++$wallet_trn_cnt;?>
                                        </div>
                                        <div style="flex:15%; padding-left:4px; height:35px; background-color: #ffffff">
                                            <?php echo $tdate ?>
                                        </div>
                                        <div style="flex:50%; padding-left:4px; height:35px; background-color: #ffffff">
                                            <?php if ($cCourseId <> 'xxxxxx' && strlen($cCourseId) == 6){echo ' '.$cCourseId.' ';}
                                            echo $vDesc;
                                            if($vremark == 'Registration Deduction'){echo ' '.$fee_item_desc;}else{echo ' '.$vremark;}
                                            if ($RetrievalReferenceNumber <> '0000'){echo ' '.$RetrievalReferenceNumber;}?>
                                        </div>
                                        <div style="flex:10%; padding-right:4px; height:35px; background-color: #ffffff; color:#e31e24; text-align:right;"><?php 
                                            echo number_format($Amount_a, 2, '.', ',');$balance_loc = $balance_loc - $Amount_a;?>
                                        </div>
                                        <div style="flex:10%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"><?php 
                                            echo '--';?>
                                        </div>
                                        <div style="flex:10%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                            <?php echo number_format($balance_loc, 2, '.', ','); ?>
                                        </div>
                                    </div><?php
                                }
                            }
                        }else
                        {*/
                            $stmt = $mysqli->prepare("SELECT tdate, cCourseId, concat(LEFT(a.cAcademicDesc,4),'-',siLevel,'-',tSemester) vDesc,  cTrntype, a.Amount Amount_a, vremark, a.RetrievalReferenceNumber, b.fee_item_desc 
                            FROM $wrking_year_tab a, fee_items b
                            WHERE a.fee_item_id = b.fee_item_id
							AND tdate NOT LIKE '0000%'
							AND LEFT(a.tdate,10) > '$account_close_date'
                            AND b.cdel = 'N'
                            AND vMatricNo = ?
                            ORDER BY cTrntype, tdate;");
                            
                            $stmt->bind_param("s", $_REQUEST['vMatricNo']);
                            $stmt->execute();
                            $stmt->store_result();
                            
                            $stmt->bind_result($tdate, $cCourseId, $vDesc, $cTrntype, $Amount_a, $vremark, $RetrievalReferenceNumber, $fee_item_desc);
                        
                            $debit_balance = 0;
                            while($stmt->fetch())
                            {?>    
                                <div class="appl_left_child_div_child calendar_grid">
                                    <div style="flex:5%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                        <?php echo ++$wallet_trn_cnt;?>
                                    </div>
                                    <div style="flex:15%; padding-left:4px; height:35px; background-color: #ffffff">
                                        <?php echo $tdate ?>
                                    </div>
                                    <div style="flex:50%; padding-left:4px; height:35px; background-color: #ffffff">
                                        <?php if ($cCourseId <> 'xxxxxx' && strlen($cCourseId) == 6){echo ' '.$cCourseId.' ';}
                                        echo $vDesc;
                                        if($vremark == 'Registration Deduction'){echo ' '.$fee_item_desc;}else{echo ' '.$vremark;}
                                        if ($RetrievalReferenceNumber <> '0000'){echo ' '.$RetrievalReferenceNumber;}?>
                                    </div>
                                    <div style="flex:10%; padding-right:4px; height:35px; background-color: #ffffff; color:#e31e24; text-align:right;"><?php 
                                        echo number_format($Amount_a, 2, '.', ',');
                                        $balance_loc = $balance_loc - $Amount_a;
                                        $debit_balance += $Amount_a;?>
                                    </div>
                                    <div style="flex:10%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;"><?php 
                                        echo '--';?>
                                    </div>
                                    <div style="flex:10%; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                                        <?php echo number_format($balance_loc, 2, '.', ','); ?>
                                    </div>
                                </div><?php
                            }
                        //}                        
                        
                        if ($wallet_trn_cnt == 0)
                        {?>
                            <div class="appl_left_child_div_child calendar_grid inlin_message_color">
                                <div style="flex:5%; padding-right:4px; height:35px; text-align:center;">
                                    There are no debit transactions to display
                                </div>
                            </div><?php
                        }
                        $stmt->close();
                    }
                    require_once ('std_bottom_right_menu.php');?>
                </div>
            </div>

            <div id="menu_bs_scrn" class="appl_far_right_div" style="z-index:2;">
                <?php build_menu_right();?>
            </div>
        </div>
	</body>
</html>