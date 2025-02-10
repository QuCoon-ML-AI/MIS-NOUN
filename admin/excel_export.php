<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');

$orgsetins = settns();

$mysqli = link_connect_db();

if (isset($_REQUEST['mm']) && isset($_REQUEST['sm']))
{    
    $data = array(array());
    $cont = 0;
    if ($_REQUEST['mm'] == 2)
    {
        if ($_REQUEST['sm'] == 6)
        {
            
            $filename = "fee_structure_" . date('Ymd') . ".xls";

            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Content-Type: application/vnd.ms-excel");
            
            $faculty_sub_sql = "";

            $faculty_sub_sql = "";
            if (isset($_REQUEST['cEduCtgId_loc_ex_burs']) && $_REQUEST['cEduCtgId_loc_ex_burs'] <> '')
            {
                $faculty_sub_sql = " AND a.cEduCtgId = '".$_REQUEST['cEduCtgId_loc_ex_burs']."'";
            }
            
            if (isset($_REQUEST['show_all_ex_burs']) && $_REQUEST['show_all_ex_burs'] == '0')
            {
                $faculty_sub_sql .= " AND d.fee_item_desc <> 'Application Fee' AND d.fee_item_desc <> 'Late Fee'";
            }

            if (isset($_REQUEST['cFacultyId_ex_burs']) && $_REQUEST['cFacultyId_ex_burs'] <> '')
            {
                $faculty_sub_sql .= " AND cFacultyId = '".$_REQUEST['cFacultyId_ex_burs']."'";
            }

            if (isset($_REQUEST['new_old_structure_ex_burs']) && $_REQUEST['new_old_structure_ex_burs'] <> '')
            {
                $faculty_sub_sql .= " AND new_old_structure = '".$_REQUEST['new_old_structure_ex_burs']."'";
            }

            
            $stmt = $mysqli->prepare("select a.iItemID, a.citem_cat, a.cEduCtgId, b.vEduCtgDesc, a.iSemester, c.citem_cat_desc, d.fee_item_desc, d.fee_item_id, a.iCreditUnit, a.Amount, a.cFacultyId, a.cdeptid, a.cprogrammeId, a.ilevel
            FROM s_f_s a, educationctg b, sell_item_cat c, fee_items d
            where a.cEduCtgId = b.cEduCtgId 
            AND a.citem_cat = c.citem_cat
            AND a.fee_item_id = d.fee_item_id
            AND a.cdel = 'N'
            AND d.cdel = 'N'
            $faculty_sub_sql
            order by a.cFacultyId, a.cdeptid, a.cprogrammeId, a.citem_cat, d.fee_item_desc");
            
            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($iItemID_01, $citem_cat_01, $cEduCtgId_01, $vEduCtgDesc_01, $iSemester_01, $citem_cat_desc_01, $vDesc_01, $fee_item_id_01, $iCreditUnit_01, $Amount_01, $cFacultyId_01, $cdeptid_01, $cprogrammeId_01, $ilevel_01);
            
            $prev_citem_cat = '';
            $citem_cat_total = 0;  
            $faculty_diff = '';
            $prev_citem_cat_diff = '';

            $cnt = 0;

            while($stmt->fetch())
            {
                if ( $cnt == 0)
                {
                    array_push($data, array("Sno" => "Sno", "Item ID" => "Item ID", "Faculty" => "Faculty", "Department" => "Department", "Programme" => "Programme", "Fee item" => "Fee item", "Amount" => "Amount"));
                }
                
                array_push($data, array("Sno" => ++$cont, "ItemID" => $iItemID_01, "Faculty" => $cFacultyId_01, "Department" => $cdeptid_01, "Programme" => $cprogrammeId_01, "FeeItem" => $vDesc_01.' - '.$iCreditUnit_01, "Amount" => $Amount_01));

                $cnt++;
            }
            $stmt->close();

            cleanData($str);
                       
            buildSheet($data);
            exit;
        }else if ($_REQUEST['sm'] == 11 && isset($_REQUEST['sq_statement']))
        {            
            $filename = "transaction_list" . date('Ymd') . ".xls";

            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Content-Type: application/vnd.ms-excel");
    
            $binded = array();
            
            $sql = substr($_REQUEST['sq_statement'],0,strpos($_REQUEST['sq_statement'],"^"));//echo $_REQUEST['sq_statement'];

            $binder_start = strpos($_REQUEST['sq_statement'],"^")+1;
            $binder_end = strpos($_REQUEST['sq_statement'],"~")-$binder_start;
            $binders = substr($_REQUEST['sq_statement'], $binder_start, $binder_end);

            $to_bind = substr($_REQUEST['sq_statement'], strpos($_REQUEST['sq_statement'],"~")+1);

            $binded = explode("|", $to_bind);

            $stmt = $mysqli->prepare($sql);

            if (count($binded) > 0)
            {
                if (count($binded) == 1)
                {
                    $stmt->bind_param($binders, $binded[0]);
                }else if (count($binded) == 2)
                {
                    $stmt->bind_param($binders, $binded[0], $binded[1]);
                }else if (count($binded) == 3)
                {
                    $stmt->bind_param($binders, $binded[0], $binded[1], $binded[2]);
                }else if (count($binded) == 4)
                {
                    $stmt->bind_param($binders, $binded[0], $binded[1], $binded[2], $binded[3]);
                }else if (count($binded) == 5)
                {
                    $stmt->bind_param($binders, $binded[0], $binded[1], $binded[2], $binded[3], $binded[4]);
                }else if (count($binded) == 6)
                {
                    $stmt->bind_param($binders, $binded[0], $binded[1], $binded[2], $binded[3], $binded[4], $binded[5]);
                }else if (count($binded) == 7)
                {
                    $stmt->bind_param($binders, $binded[0], $binded[1], $binded[2], $binded[3], $binded[4], $binded[5], $binded[6]);
                }else if (count($binded) == 7)
                {
                    $stmt->bind_param($binders, $binded[0], $binded[1], $binded[2], $binded[3], $binded[4], $binded[5], $binded[6], $binded[7]);
                }
            }
            $stmt->execute();
            $stmt->store_result();
            
            $stmt->bind_result($namess, $Regno, $rrr, $tdate, $amount);
        
            $cnt = 0;            
            while ($stmt->fetch())
            {
                if ( $cnt == 0)
                {
                    array_push($data, array("Sno" => "Sno", "Name" => "Name", "AFN/Mat. No." => "AFN/Mat. No.", "Ref. No." => "Ref. No.", "Date" => "Date", "Amount" => "Amount"));
                }
                
                array_push($data, array("Sno" => ++$cont, "Name" => $namess, "Matric No" => $Regno, "Ref. No." => "'".$rrr, "Date" => $tdate, "Amount" => $amount));

                $cnt++;               
            }
            $stmt->close();
            //cleanData($data);
            buildSheet($data);
            exit;
        }
    }
}?>