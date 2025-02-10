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
		<script language="JavaScript" type="text/javascript" src="./bamboo/std_m_js.js"></script>
        
        <link rel="stylesheet" type="text/css" media="all" href="../appl/styless.css" />
        <link rel="stylesheet" type="text/css" media="all" href="./bamboo/conv_clearance.css" />
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
        
        $balance = 0.00;


        $sql_feet_type = select_fee_srtucture($_REQUEST["vMatricNo"], $cResidenceCountryId_loc, $cEduCtgId_loc);


        $deg_cond = '';
        if (!is_bool(strpos($cProgrammeId_loc, "DEG")))
        {
            if ($deg_appl_cat == '1')
            {
                $deg_cond = " AND fee_item_desc LIKE '%NOUN Incubatee'";
            }else if ($deg_appl_cat == '2')
            {
                $deg_cond = " AND fee_item_desc LIKE '%Staff/Alumni'";
            }else if ($deg_appl_cat == '3')
            {
                $deg_cond = " AND fee_item_desc LIKE '%Public'";
            }
        }?>        
            
        <div class="appl_container">
            <div class="appl_left_div" style="z-index:2;">
                <div class="appl_left_child_logo_div"></div>
                <div class="appl_left_child_div" style="margin-top:0px; font-size:1.1em; font-weight:bold">National Open University of Nigeria</div>
                <div class="appl_left_child_div" style="margin-top:0px;  font-size:1.2em">Final year clearance</div>
                
                <div class="menu_bg_scrn">
                    <?php require_once ('std_left_side_menu.php');
                    //build_menu($sidemenu);?>                    
                </div>
            </div>
            
            <div class="appl_right_div">                
                <div class="appl_left_child_div" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php std_top_menu();?>
                </div>
                
                <div class="appl_left_child_div" style="text-align: left; margin-top:0px; margin-bottom:0px;">
                    <?php require_once ('menu_bar_content.php');?>
                </div>

                <div id="menu_sm_scrn">
                    <?php build_menu_right();?>
                </div>
                <div class="appl_left_child_div" style="width:98%; margin:auto; height:20%; margin-top:10px; overflow-y: scroll; background-color:#eff5f0">
                    <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                        <div style="flex:100%; padding:8px 5px 0px 0px; height:40px; text-align:left; text-indent:5px">
                            Financial Standing
                        </div>
                    </div>
                    
                    <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                        <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                            Sno
                        </div>
                        <div style="flex:35%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px;">
                            Fee item
                        </div>
                        <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                            Expected amount
                        </div>
                        <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                            Paid amount
                        </div>
                        <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                            Outstanding
                        </div>
                    </div>
                </div>
                
                <div class="appl_left_child_div" style="width:98%; margin:auto; max-height:73%; margin-top:5px; overflow:auto; background-color:#eff5f0"><?php
                    $cnt = 0;

                    $arr_trabsactions = array(array(array(array(array(array())))));

                    $table = search_starting_pt($_REQUEST['vMatricNo']);
                    
                    foreach ($table as &$value)
                    {
                        $wrking_tab = 's_tranxion_'.$value;
                        
                        $stmt = $mysqli->prepare("SELECT cCourseId, amount, tSemester, siLevel, a.fee_item_id, vremark, b.fee_item_desc, LEFT(a.cAcademicDesc,4), tdate 
                        FROM $wrking_tab a, fee_items b
                        WHERE a.fee_item_id = b.fee_item_id
                        AND b.cdel = 'N'
                        AND vMatricNo = ?
                        ORDER BY cTrntype, tdate;");
                        
                        $stmt->bind_param("s", $_REQUEST['vMatricNo']);
                        $stmt->execute();
                        $stmt->store_result();
                        
                        //$stmt->bind_result($tdate, $cCourseId, $vDesc, $cTrntype, $Amount_a, $vremark, $RetrievalReferenceNumber, $fee_item_desc);
                        $stmt->bind_result($cCourseId, $amount, $tSemester, $siLevel, $fee_item_id, $vremark, $fee_item_desc, $cAcademicDesc_conv, $tdate_trxn);
                       
                        while($stmt->fetch())
                        {
                            if (isset($cCourseId))
                            {
                                $cnt++;
                                $arr_trabsactions[$cnt]['cCourseId'] = $cCourseId;
                                $arr_trabsactions[$cnt]['amount'] = $amount;
                                $arr_trabsactions[$cnt]['tSemester'] = $tSemester;
                                $arr_trabsactions[$cnt]['siLevel'] = $siLevel;
                                $arr_trabsactions[$cnt]['fee_item_id'] = $fee_item_id;
                                $arr_trabsactions[$cnt]['vremark'] = $vremark;
                                $arr_trabsactions[$cnt]['fee_item_desc'] = $fee_item_desc;
                                $arr_trabsactions[$cnt]['cAcademicDesc'] = $cAcademicDesc_conv;
                                $arr_trabsactions[$cnt]['tdate'] = $tdate_trxn;
                                
                                /*echo $arr_trabsactions[$cnt]['cCourseId'].', '.
                                $arr_trabsactions[$cnt]['amount'].', '.
                                $arr_trabsactions[$cnt]['tSemester'].', '.
                                $arr_trabsactions[$cnt]['siLevel'].', '.
                                $arr_trabsactions[$cnt]['fee_item_id'].', '.
                                $arr_trabsactions[$cnt]['vremark'].', '.
                                $arr_trabsactions[$cnt]['fee_item_desc'].', '.
                                $arr_trabsactions[$cnt]['cAcademicDesc'].
                                $arr_trabsactions[$cnt]['tdate'].'<p>';*/
                            }
                        }
                    }
                    
                    $stmt->close();
                    
                    
                            
                    //collect first reg date
                    $earliest_reg = '';
                    $table = search_starting_pt($_REQUEST['vMatricNo']);
                
                    foreach ($table as &$value)
                    {
                        $wrking_tab = 's_tranxion_'.$value;
                    
                        $stmt_elr = $mysqli->prepare("SELECT min(tdate)
                        FROM $wrking_tab 
                        WHERE vMatricNo = ?");
                        $stmt_elr->bind_param("s", $_REQUEST["vMatricNo"]);
                        $stmt_elr->execute();
                        $stmt_elr->store_result();
                        $stmt_elr->bind_result($earliest_reg);
                        $stmt_elr->fetch();
                    
                        if (is_null($earliest_reg))
                        {
                            $earliest_reg = '';
                        }
                        
                        if ($earliest_reg <> '')
                        {
                            break;
                        }
                    }
                    
                    $outstanding = 0;
                    $g_tot_expt_amnt = 0;
                    $g_tot_paid_amnt = 0;
                    $g_tot_out_amnt = 0;
                    
                    $lvl_count = $iBeginLevel_loc;
                    
                    /*for ($x = $cAcademicDesc_1; $x <= $cAcademicDesc; $x+=1)
                    {
                        if ($x <= 2019)
                        {
                            $course_table = 'coursereg_arch_20172019';
                            $exam_table = 'examreg_20172019';
                        }else if ($x >= 2020 && $x <= 2021)
                        {
                            $course_table = 'coursereg_arch_20202021';
                            $exam_table = 'examreg_20202021';
                        }else if ($x >= 2022 && $x <= 2023)
                        {
                            $course_table = 'coursereg_arch_20222023';
                            $exam_table = 'examreg_20222023';
                        }else if ($x >= 2024)
                        {
                            $course_table = 'coursereg_arch_20242025';
                            $exam_table = 'examreg_20242025';
                        }
                        
                        $level = '';
                        for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                        {
                            if ($arr_trabsactions[$b]['cAcademicDesc'] == $x &&
                            $arr_trabsactions[$b]['tSemester'] == 1)
                            {
                                $level = $lvl_count;
                                break;
                            }
                        }
                        
                        
                        if ($level <> '')
                        {?>
                            <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                <div style="flex:100%; padding:8px 5px 0px 0px; height:40px; text-align:left; text-indent:5px;">
                                    <?php
                                        $level = '';
                                        for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                        {
                                            if ($arr_trabsactions[$b]['cAcademicDesc'] == $x &&
                                            $arr_trabsactions[$b]['tSemester'] == 1)
                                            {
                                                $level = $lvl_count;
                                                break;
                                            }
                                        }
                                        echo $x . ' First semester';?>
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                                <div style="flex:75%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px">
                                    Compulsory fees
                                </div>
                                <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; text-align:right"></div>
                            </div><?php
                            if ($cEduCtgId_loc == 'ELX')
                            {
                                $sql_cat = "AND c.citem_cat = 'F4' AND a.cdeptid = '$cdeptId_loc'";
                            }else if ($cEduCtgId_loc == 'PSZ')
                            {
                                if ($level == $iBeginLevel_loc)
                                {
                                    $sql_cat = "AND (c.citem_cat = 'A1' OR a.citem_cat = 'A4')";
                                }else
                                {
                                    $sql_cat = "AND c.citem_cat = 'A4'";
                                }
                            }else if ($cEduCtgId_loc == 'PGX')//PG
                            {
                                if ($level == $iBeginLevel_loc)
                                {
                                    $sql_cat = "AND (c.citem_cat = 'B1' OR c.citem_cat = 'B4')";
                                }else
                                {
                                    $sql_cat = "AND c.citem_cat = 'B4'";
                                }
                            }else if ($cEduCtgId_loc == 'PGY')//Mas
                            {
                                if ($level == $iBeginLevel_loc)
                                {
                                    $sql_cat = "AND (c.citem_cat = 'C1' OR c.citem_cat = 'C4')";
                                }else
                                {
                                    $sql_cat = "AND c.citem_cat = 'C4'";
                                }
                            }else if ($cEduCtgId_loc == 'PGZ')//Pre-Dr
                            {
                                if ($level == $iBeginLevel_loc)
                                {
                                    $sql_cat = "AND (c.citem_cat = 'G1' OR c.citem_cat = 'G4')";
                                }else
                                {
                                    $sql_cat = "AND c.citem_cat = 'G4'";
                                }
                            }else if ($cEduCtgId_loc == 'PRX')//Dr
                            {
                                if ($level == $iBeginLevel_loc)
                                {
                                    $sql_cat = "AND (c.citem_cat = 'D1' OR c.citem_cat = 'D4')";
                                }else
                                {
                                    $sql_cat = "AND c.citem_cat = 'D4'";
                                }
                            }
                            
                            //first semester compulsory payments
                            $stmt = $mysqli->prepare("SELECT a.fee_item_id, cdeptid, cprogrammeId, c.citem_cat, `iCreditUnit`, citem_cat_desc, fee_item_desc, Amount, add_date
                            FROM s_f_s a, fee_items b, sell_item_cat c
                            WHERE a.fee_item_id = b.fee_item_id
                            AND a.citem_cat = c.citem_cat
                            AND a.cEduCtgId = c.cEduCtgId
                            AND Amount > 0
                            $sql_feet_type
                            $sql_cat
                            $deg_cond
                            AND a.cFacultyId = '$cFacultyId_loc'
                            AND a.cEduCtgId = '$cEduCtgId_loc'
                            AND fee_item_desc NOT IN ('Application Fee', 'Convocation Gown')
                            ORDER BY c.citem_cat, citem_cat_desc, fee_item_desc");
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($fee_item_id, $cdeptid, $cprogrammeId, $citem_cat, $iCreditUnit, $citem_cat_desc, $fee_item_desc, $Amount, $add_date);

                            
                            $c = 0;
                            $sem_tot_expt_amnt = 0;
                            $sem_tot_paid_amnt = 0;
                            $sem_tot_out_amnt = 0;

                            while ($stmt->fetch())
                            {
                                $paid_amount = 0;
                                $paid_date = '';
                                for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                {
                                    if ($arr_trabsactions[$b]['fee_item_id'] == $fee_item_id &&
                                    //$arr_trabsactions[$b]['siLevel'] == $x &&
                                    $arr_trabsactions[$b]['cAcademicDesc'] == $x)
                                    {
                                        $paid_amount = $arr_trabsactions[$b]['amount'];
                                        $paid_date = $arr_trabsactions[$b]['tdate'];
                                        break;
                                    }
                                }
                                
                                if ($fee_item_desc == 'Registration Fee' && $paid_date <= '2024-01-15 00:00:00')
                                {
                                    if ($cEduCtgId_loc == 'PSZ')
                                    {
                                        $Amount = 6000;
                                    }else if ($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY')
                                    {
                                        $Amount = 7500;
                                    }
                                }
                    
                                if (is_null($add_date))
                                {
                                    $add_date = '';
                                }
                                if ($earliest_reg < $add_date && $add_date <> '' && $cEduCtgId_loc <> 'PGZ' && $cEduCtgId_loc <> 'PRX')
                                {
                                    continue;
                                }?>
                                <div class="appl_left_child_div_child calendar_grid">
                                    <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo ++$c;?>
                                    </div>
                                    <div style="flex:35%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px;">
                                        <?php echo $fee_item_desc;?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo number_format($Amount); 
                                        $sem_tot_expt_amnt+=$Amount;?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"><?php
                                        echo number_format($paid_amount);
                                        $sem_tot_paid_amnt+=$paid_amount;?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo number_format(($paid_amount-$Amount));?>
                                    </div>
                                </div><?php
                            }?>
                            
                            <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                                <div style="flex:35%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px">
                                    Total compulsory fee
                                </div>
                                <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                    <?php echo number_format($sem_tot_expt_amnt,2);
                                    $g_tot_expt_amnt+=$sem_tot_expt_amnt;?>
                                </div>
                                <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                    <?php echo number_format($sem_tot_paid_amnt,2);
                                    $g_tot_paid_amnt+=$sem_tot_paid_amnt;?>
                                </div>
                                <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                    <?php echo number_format(($sem_tot_paid_amnt-$sem_tot_expt_amnt),2);
                                    $g_tot_out_amnt+=($sem_tot_paid_amnt-$sem_tot_expt_amnt);?>
                                </div>
                            </div><?php
                            
                            
                            //course registration payments
                            if ($cEduCtgId_loc <> 'ELX')
                            {?>
                                <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                    <div style="flex:100%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                                </div>
            
                                <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                    <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                                    <div style="flex:95%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px">
                                        Course registration fees
                                    </div>
                                </div><?php
                                
                                $sem_tot_expt_amnt = 0;
                                $sem_tot_paid_amnt = 0;
                                $sem_tot_out_amnt = 0;
                                
                                $stmt_course_reg = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, a.tdate, a.iCreditUnit, LEFT(a.cAcademicDesc,4), a.cCategory, a.ancilary_type
                                FROM $course_table a
                                WHERE a.vMatricNo = ?
                                AND LEFT(a.cAcademicDesc,4) = '$x'
                                AND a.tSemester = 1
                                ORDER BY a.siLevel, a.tSemester, a.cCategory, a.cCourseId");
                                $stmt_course_reg->bind_param("s", $_REQUEST["vMatricNo"]);
                                $stmt_course_reg->execute();
                                $stmt_course_reg->store_result();
                                $stmt_course_reg->bind_result($cCourseId_crs_reg, $vCourseDesc_crs_reg, $tdate_crs_reg_crs_reg, $iCreditUnit_crs_reg, $cAcademicDesc_crs_reg, $cCategory_crs_reg, $ancilary_type_crs_reg);

                                
                                while ($stmt_course_reg->fetch())
                                {
                                    if (is_null($vCourseDesc_crs_reg))
                                    {
                                        $vCourseDesc_crs_reg = '';
                                    }
                                    
                                    if ($ancilary_type_crs_reg <> 'normal')
                                    {
                                        $stmt_amount = $mysqli->prepare("SELECT a.Amount
                                        FROM s_f_s a, educationctg b, sell_item_cat c, fee_items d
                                        WHERE a.cEduCtgId = b.cEduCtgId 
                                        AND a.citem_cat = c.citem_cat
                                        AND a.fee_item_id = d.fee_item_id
                                        AND d.fee_item_desc = '$ancilary_type_crs_reg'
                                        AND a.cdel = 'N'
                                        AND d.cdel = 'N'
                                        AND a.cEduCtgId = '$cEduCtgId_loc'
                                        AND cFacultyId = '$cFacultyId_loc'
                                        $sql_feet_type");
                                        
                                        $stmt_amount->execute();
                                        $stmt_amount->store_result();
                                        
                                        $stmt_amount->bind_result($Amount_crs);
                                        $stmt_amount->fetch();
                                    }else
                                    {
                                        $stmt_amount = $mysqli->prepare("SELECT Amount
                                        FROM s_f_s a, fee_items b
                                        WHERE a.fee_item_id = b.fee_item_id
                                        AND fee_item_desc = 'Course Registration'
                                        AND iCreditUnit = $iCreditUnit_crs_reg
                                        AND cEduCtgId = '$cEduCtgId_loc'
                                        AND cFacultyId = '$cFacultyId_loc'
                                        $sql_feet_type
                                        $deg_cond");

                                        $stmt_amount->execute();
                                        $stmt_amount->store_result();
                                        $stmt_amount->bind_result($Amount_crs);
                                        $stmt_amount->fetch();
                                    }
                                    $stmt_amount->close();
                                    if (is_null($Amount_crs))
                                    {
                                        $Amount_crs = 0;
                                    }?>
                                    <div class="appl_left_child_div_child calendar_grid">
                                        <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                            <?php echo ++$c;?>
                                        </div>
                                        <div style="flex:35%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px;">
                                            <?php echo $iCreditUnit_crs_reg.' '.$cCourseId_crs_reg.' '.ucwords(strtolower($vCourseDesc_crs_reg));?>
                                        </div>
                                        <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                            <?php echo number_format($Amount_crs); $sem_tot_expt_amnt+=$Amount_crs;?>
                                        </div>
                                        <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"><?php
                                            $paid_amount = 0;
                                            for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                            {
                                                if ($arr_trabsactions[$b]['cCourseId'] == $cCourseId_crs_reg &&
                                                //$arr_trabsactions[$b]['vremark'] == 'Course Registration' && 
                                                $arr_trabsactions[$b]['fee_item_id'] == 56 &&
                                                //$arr_trabsactions[$b]['siLevel'] == $x &&
                                                $arr_trabsactions[$b]['cAcademicDesc'] == $x
                                                )
                                                {
                                                    $paid_amount = $arr_trabsactions[$b]['amount'];
                                                    break;
                                                }
                                            }
                                            echo number_format($paid_amount);
                                            $sem_tot_paid_amnt+=$paid_amount;?>
                                        </div>
                                        <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                            <?php echo number_format(($paid_amount-$Amount_crs));?>
                                        </div>
                                    </div><?php
                                }
                                $stmt_course_reg->close();?>
                                    
                                <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                    <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                                    <div style="flex:35%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px">
                                        Total course registration fee
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo number_format($sem_tot_expt_amnt,2);
                                        $g_tot_expt_amnt+=$sem_tot_expt_amnt;?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo number_format($sem_tot_paid_amnt,2);
                                        $g_tot_paid_amnt+=$sem_tot_paid_amnt;?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo number_format(($sem_tot_paid_amnt-$sem_tot_expt_amnt),2);
                                        $g_tot_out_amnt+=($sem_tot_paid_amnt-$sem_tot_expt_amnt);?>
                                    </div>
                                </div>


                                <!--first semester exam registration payments-->
                                <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                    <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                                    <div style="flex:95%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px">
                                        Examination registration fees
                                    </div>
                                </div><?php

                                $stmt_exam_reg = $mysqli->prepare("SELECT a.cCourseId, b.vCourseDesc, b.cCategory, b.iCreditUnit, a.tdate, b.ancilary_type
                                FROM $exam_table a, $course_table b
                                WHERE a.cCourseId = b.cCourseId
                                AND a.vMatricNo = b.vMatricNo
                                AND LEFT(a.cAcademicDesc,4) = '$x'
                                AND a.tSemester = 1
                                AND a.vMatricNo = ?
                                ORDER BY b.cCourseId");

                                $stmt_exam_reg->bind_param("s", $_REQUEST["vMatricNo"]);
                                $stmt_exam_reg->execute();
                                $stmt_exam_reg->store_result();
                                $stmt_exam_reg->bind_result($cCourseId_exam, $vCourseDesc_exam, $cCategory_exam, $iCreditUnit_exam, $tdate_exam, $ancilary_type);

                                $sem_tot_expt_amnt = 0;
                                $sem_tot_paid_amnt = 0;
                                $sem_tot_out_amnt = 0;

                                $exam_Amount = 0;
                                
                                while ($stmt_exam_reg->fetch())
                                {
                                    if (is_null($vCourseDesc_exam))
                                    {
                                        $vCourseDesc_exam = '';
                                    }

                                    if ($tdate_exam <= '2023-01-15 00:00:00')
                                    {
                                        if ($cEduCtgId_loc == 'PSZ')
                                        {
                                            $exam_Amount = 1000;
                                        }else if ($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY')
                                        {
                                            $exam_Amount = 1500;
                                        }
                                    }else
                                    {
                                        if ($cEduCtgId_loc == 'PSZ')
                                        {
                                            $exam_Amount = 1500;
                                            if ($ancilary_type == 'Laboratory')
                                            {
                                                $exam_Amount = 6500;
                                            }
                                        }else if ($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY')
                                        {
                                            $exam_Amount = 3000;
                                        }
                                    }?>
                                    <div class="appl_left_child_div_child calendar_grid">
                                        <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                            <?php echo ++$c;?>
                                        </div>
                                        <div style="flex:35%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px;">
                                            <?php echo $cCourseId_exam.' '.ucwords(strtolower($vCourseDesc_exam));?>
                                        </div>
                                        <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                            <?php echo number_format($exam_Amount); $sem_tot_expt_amnt+=$exam_Amount;?>
                                        </div>
                                        <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"><?php
                                            $paid_amount = 0;
                                            for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                            {
                                                if ($arr_trabsactions[$b]['cCourseId'] == $cCourseId_exam &&
                                                $arr_trabsactions[$b]['fee_item_id'] == 8 &&
                                                $arr_trabsactions[$b]['cAcademicDesc'] == $x)
                                                {
                                                    $paid_amount = $arr_trabsactions[$b]['amount'];
                                                    break;
                                                }
                                            }
                                            echo number_format($paid_amount);
                                            $sem_tot_paid_amnt+=$paid_amount;?>
                                        </div>
                                        <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                            <?php echo number_format(($paid_amount-$exam_Amount));?>
                                        </div>
                                    </div><?php
                                }
                                $stmt_exam_reg->close();?>

                                    
                                <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                    <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                                    <div style="flex:35%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px">
                                        Total exam registration fees
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo number_format($sem_tot_expt_amnt,2);
                                        $g_tot_expt_amnt+=$sem_tot_expt_amnt;?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo number_format($sem_tot_paid_amnt,2);
                                        $g_tot_paid_amnt+=$sem_tot_paid_amnt;?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo number_format(($sem_tot_paid_amnt-$sem_tot_expt_amnt),2);
                                        $g_tot_out_amnt+=($sem_tot_paid_amnt-$sem_tot_expt_amnt);?>
                                    </div>
                                </div>
                                
                                <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                    <div style="flex:100%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                                </div><?php
                            }
                        }
                        
                        
                        //second semester compulsory payments
                        if ($level <> '')
                        {
                            //has student registered for current semester
                            if ($x == $cAcademicDesc && $semester_reg_loc == 0)
                            {
                                continue;
                            }?>
                            
                            <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                <div style="flex:100%; padding:8px 5px 0px 0px; height:40px; text-align:left; text-indent:5px;">
                                    <?php
                                        $level = '';
                                        for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                        {
                                            if ($arr_trabsactions[$b]['cAcademicDesc'] == $x &&
                                            $arr_trabsactions[$b]['tSemester'] == 2)
                                            {
                                                //$level = $arr_trabsactions[$b]['siLevel'];
                                                $level = $lvl_count;
                                                break;
                                            }
                                        }
                                        echo $x . ' Second semester';?>
                                </div>
                            </div>

                            <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                                <div style="flex:75%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px">
                                    Compulsory fees
                                </div>
                                <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; text-align:right"></div>
                            </div><?php
                            $sql_cat = '';
                            if ($cEduCtgId_loc == 'PSZ')
                            {
                                $sql_cat = "AND c.citem_cat = 'A5'";
                            }else if ($cEduCtgId_loc == 'PGX')//PG
                            {
                                $sql_cat = "AND c.citem_cat = 'B5'";
                            }else if ($cEduCtgId_loc == 'PGY')//Mas
                            {
                                $sql_cat = "AND c.citem_cat = 'C5'";
                            }else if ($cEduCtgId_loc == 'PGZ')//Pre-Dr
                            {
                                $sql_cat = "AND c.citem_cat = 'G5'";
                            }else if ($cEduCtgId_loc == 'PRX')//Dr
                            {
                                $sql_cat = "AND c.citem_cat = 'D5'";
                            }
                            
                            $c= 0;
                            $sem_tot_expt_amnt = 0;
                            $sem_tot_paid_amnt = 0;
                            $sem_tot_out_amnt = 0;
                            
                            $stmt = $mysqli->prepare("SELECT a.fee_item_id, cdeptid, cprogrammeId, c.citem_cat, `iCreditUnit`, citem_cat_desc, fee_item_desc, Amount, add_date
                            FROM s_f_s a, fee_items b, sell_item_cat c
                            WHERE a.fee_item_id = b.fee_item_id
                            AND a.citem_cat = c.citem_cat
                            AND a.cEduCtgId = c.cEduCtgId
                            AND Amount > 0
                            $sql_feet_type
                            $sql_cat
                            $deg_cond
                            AND a.cFacultyId = '$cFacultyId_loc'
                            AND a.cEduCtgId = '$cEduCtgId_loc'
                            AND fee_item_desc NOT IN ('Application Fee', 'Convocation Gown')
                            ORDER BY c.citem_cat, citem_cat_desc, fee_item_desc");
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($fee_item_id, $cdeptid, $cprogrammeId, $citem_cat, $iCreditUnit, $citem_cat_desc, $fee_item_desc, $Amount, $add_date);

                            while ($stmt->fetch())
                            {
                                if ($fee_item_desc == 'Registration Fee' && $paid_date <= '2024-01-15 00:00:00')
                                {
                                    if ($cEduCtgId_loc == 'PSZ')
                                    {
                                        $Amount = 6000;
                                    }else if ($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY')
                                    {
                                        $Amount = 7500;
                                    }
                                }

                                if (is_null($add_date))
                                {
                                    $add_date = '';
                                }
                                
                                if ($earliest_reg < $add_date && $add_date <> '' && $cEduCtgId_loc <> 'PGZ' && $cEduCtgId_loc <> 'PRX')
                                {
                                    continue;
                                }?>
                                <div class="appl_left_child_div_child calendar_grid">
                                    <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo ++$c;?>
                                    </div>
                                    <div style="flex:35%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px;">
                                        <?php echo $fee_item_desc;?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo number_format($Amount); $sem_tot_expt_amnt+=$Amount;?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"><?php
                                        $paid_amount = 0;
                                        for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                        {
                                            if ($arr_trabsactions[$b]['fee_item_id'] == $fee_item_id &&
                                            //$arr_trabsactions[$b]['siLevel'] == $x &&
                                            $arr_trabsactions[$b]['cAcademicDesc'] == $x)
                                            {
                                                $paid_amount = $arr_trabsactions[$b]['amount'];
                                                break;
                                            }
                                        }
                                        echo number_format($paid_amount);
                                        $sem_tot_paid_amnt+=$paid_amount;?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo number_format(($paid_amount-$Amount));?>
                                    </div>
                                </div><?php
                            }
                            $stmt->close();?>

                            <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                                <div style="flex:35%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px">
                                    Total compulsory fee
                                </div>
                                <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                    <?php echo number_format($sem_tot_expt_amnt,2);
                                    $g_tot_expt_amnt+=$sem_tot_expt_amnt;?>
                                </div>
                                <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                    <?php echo number_format($sem_tot_paid_amnt,2);
                                    $g_tot_paid_amnt+=$sem_tot_paid_amnt;?>
                                </div>
                                <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                    <?php echo number_format(($sem_tot_paid_amnt-$sem_tot_expt_amnt),2);
                                    $g_tot_out_amnt+=($sem_tot_paid_amnt-$sem_tot_expt_amnt);?>
                                </div>
                            </div>
                            <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                <div style="flex:100%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                            </div>

                            <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                                <div style="flex:95%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px">
                                    Course registration fees
                                </div>
                            </div><?php
                                
                            //second semester course registration payments
                            $sem_tot_expt_amnt = 0;
                            $sem_tot_paid_amnt = 0;
                            $sem_tot_out_amnt = 0;
                            
                            $stmt_course_reg = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, a.tdate, a.iCreditUnit, LEFT(a.cAcademicDesc,4), a.cCategory, a.ancilary_type
                            FROM $course_table a
                            WHERE a.vMatricNo = ?
                            AND LEFT(a.cAcademicDesc,4) = '$x'
                            AND a.tSemester = 2
                            ORDER BY a.siLevel, a.tSemester, a.cCategory, a.cCourseId");
                            $stmt_course_reg->bind_param("s", $_REQUEST["vMatricNo"]);
                            $stmt_course_reg->execute();
                            $stmt_course_reg->store_result();
                            $stmt_course_reg->bind_result($cCourseId_crs_reg, $vCourseDesc_crs_reg, $tdate_crs_reg_crs_reg, $iCreditUnit_crs_reg, $cAcademicDesc_crs_reg, $cCategory_crs_reg, $ancilary_type_crs_reg);

                            
                            while ($stmt_course_reg->fetch())
                            {
                                if (is_null($vCourseDesc_crs_reg))
                                {
                                    $vCourseDesc_crs_reg = '';
                                }
                                
                                if ($ancilary_type_crs_reg <> 'normal')
                                {
                                    $stmt_amount = $mysqli->prepare("SELECT a.Amount
                                    FROM s_f_s a, educationctg b, sell_item_cat c, fee_items d
                                    WHERE a.cEduCtgId = b.cEduCtgId 
                                    AND a.citem_cat = c.citem_cat
                                    AND a.fee_item_id = d.fee_item_id
                                    AND d.fee_item_desc = '$ancilary_type_crs_reg'
                                    AND a.cdel = 'N'
                                    AND d.cdel = 'N'
                                    AND a.cEduCtgId = '$cEduCtgId_loc'
                                    AND cFacultyId = '$cFacultyId_loc'
                                    $sql_feet_type");
                                    
                                    $stmt_amount->execute();
                                    $stmt_amount->store_result();
                                    
                                    $stmt_amount->bind_result($Amount_crs);
                                    $stmt_amount->fetch();
                                }else
                                {
                                    $stmt_amount = $mysqli->prepare("SELECT Amount
                                    FROM s_f_s a, fee_items b
                                    WHERE a.fee_item_id = b.fee_item_id
                                    AND fee_item_desc = 'Course Registration'
                                    AND iCreditUnit = $iCreditUnit_crs_reg
                                    AND cEduCtgId = '$cEduCtgId_loc'
                                    AND cFacultyId = '$cFacultyId_loc'
                                    $sql_feet_type
                                    $deg_cond");

                                    $stmt_amount->execute();
                                    $stmt_amount->store_result();
                                    $stmt_amount->bind_result($Amount_crs);
                                    $stmt_amount->fetch();
                                }
                                $stmt_amount->close();
                                if (is_null($Amount_crs))
                                {
                                    $Amount_crs = 0;
                                }?>
                                <div class="appl_left_child_div_child calendar_grid">
                                    <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo ++$c;?>
                                    </div>
                                    <div style="flex:35%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px;">
                                        <?php echo $iCreditUnit_crs_reg.' '.$cCourseId_crs_reg.' '.ucwords(strtolower($vCourseDesc_crs_reg));?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo number_format($Amount_crs); $sem_tot_expt_amnt+=$Amount_crs;?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"><?php
                                        $paid_amount = 0;
                                        for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                        {
                                            if ($arr_trabsactions[$b]['cCourseId'] == $cCourseId_crs_reg &&
                                            //$arr_trabsactions[$b]['vremark'] == 'Course Registration' && 
                                            $arr_trabsactions[$b]['fee_item_id'] == 56 &&
                                            //$arr_trabsactions[$b]['siLevel'] == $x &&
                                            $arr_trabsactions[$b]['cAcademicDesc'] == $x)
                                            {
                                                $paid_amount = $arr_trabsactions[$b]['amount'];
                                                break;
                                            }
                                        }
                                        echo number_format($paid_amount);
                                        $sem_tot_paid_amnt+=$paid_amount;?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo number_format(($paid_amount-$Amount_crs));?>
                                    </div>
                                </div><?php
                            }
                            $stmt_course_reg->close();?>
                                
                            <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                                <div style="flex:35%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px">
                                    Total course registration fee
                                </div>
                                <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                    <?php echo number_format($sem_tot_expt_amnt,2);
                                    $g_tot_expt_amnt+=$sem_tot_expt_amnt;?>
                                </div>
                                <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                    <?php echo number_format($sem_tot_paid_amnt,2);
                                    $g_tot_paid_amnt+=$sem_tot_paid_amnt;?>
                                </div>
                                <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                    <?php echo number_format(($sem_tot_paid_amnt-$sem_tot_expt_amnt),2);
                                    $g_tot_out_amnt+=($sem_tot_paid_amnt-$sem_tot_expt_amnt);?>
                                </div>
                            </div>
    
    
                            <!--second semester exam registration payments-->
                            <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                                <div style="flex:95%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px">
                                    Examination registration fees
                                </div>
                            </div><?php

                            $stmt_exam_reg = $mysqli->prepare("SELECT a.cCourseId, b.vCourseDesc, b.cCategory, b.iCreditUnit, a.tdate
                            FROM $exam_table a, $course_table b
                            WHERE a.cCourseId = b.cCourseId
                            AND a.vMatricNo = b.vMatricNo
                            AND LEFT(a.cAcademicDesc,4) = '$x'
                            AND a.tSemester = 2
                            AND a.vMatricNo = ?
                            ORDER BY b.cCourseId");

                            $stmt_exam_reg->bind_param("s", $_REQUEST["vMatricNo"]);
                            $stmt_exam_reg->execute();
                            $stmt_exam_reg->store_result();
                            $stmt_exam_reg->bind_result($cCourseId_exam, $vCourseDesc_exam, $cCategory_exam, $iCreditUnit_exam, $tdate_exam);

                            $sem_tot_expt_amnt = 0;
                            $sem_tot_paid_amnt = 0;
                            $sem_tot_out_amnt = 0;

                            while ($stmt_exam_reg->fetch())
                            {
                                if (is_null($vCourseDesc_exam))
                                {
                                    $vCourseDesc_exam = '';
                                }
                                
                                if ($tdate_exam <= '2023-01-15 00:00:00')
                                {
                                    if ($cEduCtgId_loc == 'PSZ')
                                    {
                                        $exam_Amount = 1000;
                                    }else if ($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY')
                                    {
                                        $exam_Amount = 1500;
                                    }
                                }else
                                {
                                    if ($cEduCtgId_loc == 'PSZ')
                                    {
                                        $exam_Amount = 1500;
                                    }else if ($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY')
                                    {
                                        $exam_Amount = 2000;
                                    }
                                }?>
                                <div class="appl_left_child_div_child calendar_grid">
                                    <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo ++$c;?>
                                    </div>
                                    <div style="flex:35%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px;">
                                        <?php echo $cCourseId_exam.' '.ucwords(strtolower($vCourseDesc_exam));?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo number_format($exam_Amount); $sem_tot_expt_amnt+=$exam_Amount;?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"><?php
                                        $paid_amount = 0;
                                        for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                        {
                                            if ($arr_trabsactions[$b]['cCourseId'] == $cCourseId_exam &&
                                            $arr_trabsactions[$b]['fee_item_id'] == 8 &&
                                            $arr_trabsactions[$b]['cAcademicDesc'] == $x)
                                            {
                                                $paid_amount = $arr_trabsactions[$b]['amount'];
                                                break;
                                            }
                                        }
                                        echo number_format($paid_amount);
                                        $sem_tot_paid_amnt+=$paid_amount;?>
                                    </div>
                                    <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                        <?php echo number_format(($paid_amount-$exam_Amount));?>
                                    </div>
                                </div><?php
                            }
                            $stmt_exam_reg->close();?>

                                
                            <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                                <div style="flex:35%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px">
                                    Total exam registration fees
                                </div>
                                <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                    <?php echo number_format($sem_tot_expt_amnt,2);
                                    $g_tot_expt_amnt+=$sem_tot_expt_amnt;?>
                                </div>
                                <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                    <?php echo number_format($sem_tot_paid_amnt,2);
                                    $g_tot_paid_amnt+=$sem_tot_paid_amnt;?>
                                </div>
                                <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                    <?php echo number_format(($sem_tot_paid_amnt-$sem_tot_expt_amnt),2);
                                    $g_tot_out_amnt+=($sem_tot_paid_amnt-$sem_tot_expt_amnt);?>
                                </div>
                            </div>
                            
                            <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                                <div style="flex:100%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                            </div><?php
                        }
                        
                        $lvl_count+=100;
                    }?>
                            

                    <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                        <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                        <div style="flex:35%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px;">
                            Grand total
                        </div>
                        <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                            <?php echo number_format($g_tot_expt_amnt,2);?>
                        </div>
                        <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                            <?php echo number_format($g_tot_paid_amnt,2);?>
                        </div>
                        <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                            <?php echo number_format(($g_tot_out_amnt),2);?>
                        </div>
                    </div>
                        

                    <div class="appl_left_child_div_child calendar_grid" style="font-weight:bold">
                        <div style="flex:100%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                    </div><?php
    
                    if (isset($stmt_elr))
                    {
                        $stmt_elr->close();
                    }
                    
                    $stmt_s_tranxion = $mysqli->prepare("SELECT amount
                    FROM s_tranxion_20242025
                    WHERE fee_item_id = '61' 
                    AND vMatricNo = ?");
                    $stmt_s_tranxion->bind_param("s", $_REQUEST["vMatricNo"]);
    
                    $stmt_s_tranxion->execute();
                    $stmt_s_tranxion->store_result();
                    $stmt_s_tranxion->bind_result($s_tranxion_amount);
                    $stmt_s_tranxion->fetch();
                    $stmt_s_tranxion->close();
                    
                    if (is_null($s_tranxion_amount))
                    {
                        $s_tranxion_amount = 0;
                    }                    
                    
                    if ($s_tranxion_amount == 0 && $g_tot_out_amnt < 0)
                    {?>
                        <div class="appl_left_child_div_child calendar_grid">
                            <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                            <div style="flex:35%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:left; text-indent:5px;">
                                Outstanding amount at graduation
                            </div>
                            <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                            <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right"></div>
                            <div style="flex:20%; padding:8px 5px 0px 0px; height:40px; background-color: #ffffff; text-align:right">
                                <?php echo number_format(($g_tot_out_amnt),2);?>
                            </div>
                        </div><?php
                    }*/
                    
                    if (isset($grad) && $grad == '2')
                    {
                        /*if ($g_tot_out_amnt < 0)
                        {?>
                            <form action="pay_balance_for_clearance" method="post" name="chk_p_sta" id="chk_p_sta" enctype="multipart/form-data" onsubmit="in_progress('1');">
                                <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
                                <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"]) && $_REQUEST["ilin"] <> ''){echo $_REQUEST["ilin"];}?>" />
                                <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
                                
                                <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
                                <!-- <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" /> -->
                                
                                <input id="vDesc" name="vDesc" value="Outstanding amount at graduation" type="hidden"/>
                                <input id="request_id" name="request_id" value="1" type="hidden"/>
                                <input name="amount" id="amount" type="hidden" value="<?php echo $g_tot_out_amnt;?>" />
                                <div id="btn_div" style="display:flex; 
                                    flex:100%;
                                    height:auto; 
                                    margin-top:10px;">
                                        <button type="submit" class="login_button">Pay</button>
                                </div>
                            </form><?php 
                        }else
                        {*/?>
                            <div class="appl_left_child_div_child calendar_grid">
                                <div style="flex:5%; padding:8px 5px 0px 0px; height:40px; background-color: none; text-align:right">
                                </div>
                                <div style="flex:95%; padding:8px 5px 0px 0px; height:40px; background-color: none; text-align:center; line-height:2; background-color: #fdf0bf;">
                                    You are cleared
                                </div>
                            </div>

                            <form action="see-clearance-slip" method="post" name="scs" target="_blank" enctype="multipart/form-data">
                                <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
                                <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"])){echo $_REQUEST["user_cat"];}; ?>" />
                                <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"])){echo $_REQUEST["ilin"];}; ?>" />
                                <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else{echo $cEduCtgId;}?>" /><input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />
                                <input name="vDesc" type="hidden" value="Wallet Funding" />
                            </form>

                            <div id="btn_div" style="display:flex; 
                                flex:100%;
                                height:auto; 
                                margin-top:10px;">
                                    <button type="button" class="login_button" onclick="scs.submit()">Print clearance slip</button>
                            </div><?php 
                        //}
                    }?>
                </div>
                
            </div>

            <div id="menu_bs_scrn" class="appl_far_right_div" style="z-index:2;">
                <?php build_menu_right($balance);?>
            </div>
        </div>
	</body>
</html>