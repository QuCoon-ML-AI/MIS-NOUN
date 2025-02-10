<?php 
$study_mode = '';
$cStudyCenterId = '';

$sql_where = '';

$binders = '';
$binded_none_arr = '';

$sql_from = '';
$sql_srt = '';


if (isset($_REQUEST['save']))
{
    $binded = array();
    
    $sql_flds = '';
    $columns = 6; 

    if (isset($_REQUEST['trn_side']))
    {
        if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '2')
        {
            $sql_from .= 'split_rec a';
            $sql_flds = "CONCAT(vLastName,' ',vFirstName,' ',vOtherName) namess, vMatricNo, rrr, orderid, split_date, amount";

            if (isset($_REQUEST['date_burs1']) && $_REQUEST['date_burs1'] <> '' && isset($_REQUEST['date_burs2']) && $_REQUEST['date_burs2'] <> '')
            {                        
               $sql_where .= ' (LEFT(a.split_date,10) >= ? AND LEFT(a.split_date,10) <= ?) AND';
                
                $binders .= 'ss';
                $binded[count($binded)] = $_REQUEST['date_burs1'];
                $binded[count($binded)] = $_REQUEST['date_burs2'];
            }else if (isset($_REQUEST['date_burs1']) && $_REQUEST['date_burs1'] <> '')
            {
                $sql_where .= ' LEFT(a.split_date,10) >= ? AND ';
                
                $binders .= 's';
                $binded[count($binded)] = $_REQUEST['date_burs1'];
            }else if (isset($_REQUEST['date_burs2']) && $_REQUEST['date_burs2'] <> '')
            {                     
                $sql_where .= ' LEFT(a.split_date,10) <= ? AND ';
                
                $binders .= 's';
                $binded[count($binded)] = $_REQUEST['date_burs2'];
            }
           

            if (substr($sql_where, strlen($sql_where)-4 == 'AND '))
            {
                $sql_where = substr($sql_where, 0, strlen($sql_where)-4);
            }

            if ($sql_where == '')
            {
                $sql_where = "1 = 1";
            }
        }else if ($_REQUEST["trn_side"] == 'n')
        {
            $sql_flds = "CONCAT(d.vLastName,' ',d.vFirstName,' ',d.vOtherName) namess, a.vMatricNo, a.RetrievalReferenceNumber, a.tdate, a.amount";
            if ($_REQUEST['fee_disc'] == 'Application Fee')
            {
                if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '1')
                {
                    $sql_flds = "CONCAT(a.vLastName,' ',a.vFirstName,' ',a.vOtherName) namess, a.Regno, a.RetrievalReferenceNumber, a.MerchantReference, a.TransactionDate, a.Amount";
                }
            }

            if ($_REQUEST['fee_disc'] == 'Application Fee')
            {
                $sql_from = 's_tranxion_app a';
            }else
            {
                $sql_from = 's_tranxion_cr a';
            }

            if (isset($_REQUEST['cEduCtgId_burs']) && $_REQUEST['cEduCtgId_burs'] <> '')
            {
                $sql_from .= ', programme c';

                if ($_REQUEST['fee_disc'] == 'Application Fee')
                {
                    $sql_where .= ' c.cEduCtgId = a.cEduCtgId AND ';
                }else
                {
                    $sql_where .= ' c.cProgrammeId = d.cProgrammeId AND ';
                }
            }

            if($_REQUEST["fee_disc"] == 'Course Registration' || $_REQUEST["fee_disc"] == 'Examination Registration')
            {
                $sql_flds = "CONCAT(d.vLastName,' ',d.vFirstName,' ',d.vOtherName) namess, CONCAT(a.vMatricNo,' ',a.cCourseId), a.RetrievalReferenceNumber, a.tdate, a.amount";
            }

            $sql_where .= " a.fee_item_id = ? AND ";
            $binders .= 'i';
            $binded[count($binded)] = $_REQUEST['fee_item'];

            $sql_where .= " a.cTrntype = 'c' AND ";
           
            if ($_REQUEST['fee_disc'] == 'Application Fee')
            {
                //if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '0')
                //{
                    if (is_bool(strpos($sql_from, ", prog_choice d")))
                    {
                        $sql_from .= ', prog_choice d';
                        if (isset($_REQUEST["chk_refund"]))
                        {
                            $sql_where .= ' a.vMatricNo = d.vApplicationNo AND ';
                        }else
                        {
                            $sql_where .= ' a.vMatricNo = d.vApplicationNo AND ';
                        }
                    }
                //}
            }else
            {
                if (is_bool(strpos($sql_from, ", s_m_t d")))
                {
                    $sql_from .= ', s_m_t d';
                    $sql_where .= ' a.vMatricNo = d.vMatricNo AND ';
                }
            }
            
            if ($_REQUEST['fee_disc'] == 'Application Fee' && isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '1')
            {
                if ($_REQUEST["l_f_resi"] == 'l')
                {
                    $sql_where .= " a.Amount > 1000 AND ";
                }else if ($_REQUEST["l_f_resi"] == 'f')
                {
                    $sql_where .= " a.Amount < 1000 AND ";
                }
            }else
            {
                if ($_REQUEST["l_f_resi"] == 'l')
                {
                    $sql_where .= " a.amount > 1000 AND ";
                }else if ($_REQUEST["l_f_resi"] == 'f')
                {
                    $sql_where .= " a.amount < 1000 AND ";
                }
            }

            if ($cStudyCenterId <> '')
            {
                $sql_where .= ' d.cStudyCenterId = ? AND ';
                $binders .= 's';
                $binded[count($binded)] = $cStudyCenterId;
            }

            if (isset($_REQUEST['faculty_burs']) && $_REQUEST['faculty_burs'] <> '')
            {
                if ($_REQUEST['fee_disc'] == 'Application Fee')
                {			
                    if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '0')
                    {
                        if (is_bool(strpos($sql_from, ", prog_choice d")))
                        {
                            $sql_from .= ', prog_choice d';
                        }
                    }
                    $sql_where .= ' d.cFacultyId = ? AND ';
                }else
                {
                    if (is_bool(strpos($sql_from, ", s_m_t d")))
                    {
                        $sql_from .= ', s_m_t d';
                    }
                    $sql_where .= ' a.vMatricNo = d.vMatricNo AND d.cFacultyId = ? AND ';
                }
                
                $binders .= 's';
                $binded[count($binded)] = $_REQUEST['faculty_burs'];
            }

            if (isset($_REQUEST['department_burs']) && $_REQUEST['department_burs'] <> '')
            {
                if ($_REQUEST['fee_disc'] == 'Application Fee')
                {			
                    if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '0')
                    {
                        if (is_bool(strpos($sql_from, ", prog_choice d")))
                        {
                            $sql_from .= ', prog_choice d';
                        }

                        if (is_bool(strpos($sql_from, ", programme e")))
                        {
                            $sql_from .= ', programme e';
                            $sql_where .= ' e.cProgrammeId = d.cProgrammeId AND e.cdeptId = ? AND ';
                        }
                    }
                }else
                {
                    if (is_bool(strpos($sql_from, ", s_m_t d")))
                    {
                        $sql_from .= ', s_m_t d';
                    }
                    $sql_where .= ' d.cdeptId = ? AND ';
                }
                
                $binders .= 's';
                $binded[count($binded)] = $_REQUEST['department_burs'];
            }


            if (isset($_REQUEST['level_burs']) && $_REQUEST['level_burs'] <> '')
            {
                if ($_REQUEST['fee_disc'] == 'Application Fee')
                {			
                    if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '0')
                    {
                        if (is_bool(strpos($sql_from, ", prog_choice d")))
                        {
                            $sql_from .= ', prog_choice d';
                            $sql_where .= ' a.vMatricNo = d.vApplicationNo AND ';
                        }
                    }
                }else
                {
                    if (is_bool(strpos($sql_from, ", s_m_t d")))
                    {
                        $sql_from .= ', s_m_t d';
                        $sql_where .= ' a.vMatricNo = d.vMatricNo AND ';
                    }
                }
                
                if ($_REQUEST['fee_disc'] == 'Application Fee')
                {
                    if (!is_bool(strpos($sql_from, ", prog_choice d")))
                    {
                        $sql_where .= ' d.iBeginLevel = ? AND ';
                    }
                }else
                {
                    if (!is_bool(strpos($sql_from, ", s_m_t d")))
                    {
                        $sql_where .= ' d.iStudy_level = ? AND ';
                    }
                }
                
                $binders .= 'i';
                $binded[count($binded)] = $_REQUEST['level_burs'];
            }
                
            if (isset($_REQUEST['cEduCtgId_burs']) && $_REQUEST['cEduCtgId_burs'] <> '')
            {
                $sql_where .= ' c.cEduCtgId = ? AND ';
                $binders .= 's';
                $binded[count($binded)] = substr($_REQUEST['cEduCtgId_burs'], 0, 3);
            }


            if (isset($_REQUEST['date_burs1']) && $_REQUEST['date_burs1'] <> '' && isset($_REQUEST['date_burs2']) && $_REQUEST['date_burs2'] <> '')
            {                        
               $sql_where .= ' (LEFT(a.tdate,10) >= ? AND LEFT(a.tdate,10) <= ?) AND';
                
                $binders .= 'ss';
                $binded[count($binded)] = $_REQUEST['date_burs1'];
                $binded[count($binded)] = $_REQUEST['date_burs2'];
            }else if (isset($_REQUEST['date_burs1']) && $_REQUEST['date_burs1'] <> '')
            {
                $sql_where .= ' LEFT(a.tdate,10) >= ? AND ';
                
                $binders .= 's';
                $binded[count($binded)] = $_REQUEST['date_burs1'];
            }else if (isset($_REQUEST['date_burs2']) && $_REQUEST['date_burs2'] <> '')
            {                     
                $sql_where .= ' LEFT(a.tdate,10) <= ? AND ';
                
                $binders .= 's';
                $binded[count($binded)] = $_REQUEST['date_burs2'];
            }
           

            if (substr($sql_where, strlen($sql_where)-4 == 'AND '))
            {
                $sql_where = substr($sql_where, 0, strlen($sql_where)-4);
            }
        }else if ($_REQUEST["trn_side"] == 'r')
        {
            $sql_flds = "CONCAT(d.vLastName,' ',d.vFirstName,' ',d.vOtherName) namess, a.Regno, a.RetrievalReferenceNumber, a.MerchantReference, a.TransactionDate, a.Amount";
            
            if ($_REQUEST['fee_disc'] == 'Application Fee')
            {
                if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '1')
                {
                    $sql_flds = "CONCAT(a.vLastName,' ',a.vFirstName,' ',a.vOtherName) namess, a.Regno, a.RetrievalReferenceNumber, a.MerchantReference, a.TransactionDate, a.Amount";
                }
                
                $sql_from = 'remitapayments_app a';
            }else
            {
                $sql_from = 'remitapayments a';
            }

            if (isset($_REQUEST['cEduCtgId_burs']) && $_REQUEST['cEduCtgId_burs'] <> '')
            {
                $sql_from .= ', programme c';

                if ($_REQUEST['fee_disc'] == 'Application Fee')
                {			
                    $sql_where .= ' c.cEduCtgId = a.cEduCtgId AND ';
                }else
                {
                    $sql_where .= ' c.cProgrammeId = d.cProgrammeId AND ';
                }            
            } 

            
            $sql_where .= " a.vDesc = ? AND ";
            $binders .= 's';
            $binded[count($binded)] = $_REQUEST['fee_disc'];

            if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '0')
            {
                $sql_where .= " (a.ResponseCode = '00' || a.ResponseCode = '01') AND ";
            }else if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '1')
            {
                $sql_where .= " (a.ResponseCode <> '00' && a.ResponseCode <> '01') AND ";
            }
            
            if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '0')
            {
                $sql_where .= " d.vApplicationNo <> '' AND ";
            }

            if ($_REQUEST['fee_disc'] == 'Application Fee')
            {			
                if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '0')
                {
                    if (is_bool(strpos($sql_from, ", prog_choice d")))
                    {
                        $sql_from .= ', prog_choice d';
                        if (isset($_REQUEST["chk_refund"]))
                        {
                            $sql_where .= ' a.vMatricNo = d.vApplicationNo AND ';
                        }else
                        {
                            $sql_where .= ' a.Regno = d.vApplicationNo AND ';
                        }
                    }
                }
            }else
            {
                if (is_bool(strpos($sql_from, ", s_m_t d")))
                {
                    $sql_from .= ', s_m_t d';
                    $sql_where .= ' a.Regno = d.vMatricNo AND ';
                }
            }

            if ($_REQUEST['fee_disc'] == 'Application Fee' && isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '1')
            {
                if ($_REQUEST["l_f_resi"] == 'l')
                {
                    $sql_where .= " a.Amount > 1000 AND ";
                }else if ($_REQUEST["l_f_resi"] == 'f')
                {
                    $sql_where .= " a.Amount < 1000 AND ";
                }
            }else
            {
                if ($_REQUEST["l_f_resi"] == 'l')
                {
                    $sql_where .= " a.amount > 1000 AND ";
                }else if ($_REQUEST["l_f_resi"] == 'f')
                {
                    $sql_where .= " a.amount < 1000 AND ";
                }
            }

            // if ($_REQUEST["l_f_resi"] == 'l')
            // {
            //     $sql_where .= " a.amount > 1000 AND ";
            // }else if ($_REQUEST["l_f_resi"] == 'f')
            // {
            //     $sql_where .= " a.amount < 1000 AND ";
            // }
            
            if ($cStudyCenterId <> '')
            {
                $sql_where .= ' d.cStudyCenterId = ? AND ';
                $binders .= 's';
                $binded[count($binded)] = $cStudyCenterId;
            }


            if (isset($_REQUEST['faculty_burs']) && $_REQUEST['faculty_burs'] <> '')
            {
                if ($_REQUEST['fee_disc'] == 'Application Fee')
                {			
                    if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '0')
                    {
                        if (is_bool(strpos($sql_from, ", prog_choice d")))
                        {
                            $sql_from .= ', prog_choice d';
                        }
                        $sql_where .= ' d.cFacultyId = ? AND ';
                    }
                }else
                {
                    if (is_bool(strpos($sql_from, ", s_m_t d")))
                    {
                        $sql_from .= ', s_m_t d';
                    }
                    $sql_where .= ' a.Regno = d.vMatricNo AND d.cFacultyId = ? AND ';
                }
                
                $binders .= 's';
                $binded[count($binded)] = $_REQUEST['faculty_burs'];
            }
            
            if (isset($_REQUEST['department_burs']) && $_REQUEST['department_burs'] <> '')
            {
                if ($_REQUEST['fee_disc'] == 'Application Fee')
                {			
                    if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '0')
                    {
                        if (is_bool(strpos($sql_from, ", prog_choice d")))
                        {
                            $sql_from .= ', prog_choice d';
                        }

                        if (is_bool(strpos($sql_from, ", programme e")))
                        {
                            $sql_from .= ', programme e';
                            $sql_where .= ' e.cProgrammeId = d.cProgrammeId AND e.cdeptId = ? AND ';
                        }
                    }
                }else
                {
                    if (is_bool(strpos($sql_from, ", s_m_t d")))
                    {
                        $sql_from .= ', s_m_t d';
                    }
                    $sql_where .= ' d.cdeptId = ? AND ';
                }
                
                $binders .= 's';
                $binded[count($binded)] = $_REQUEST['department_burs'];
            }

                
            if (isset($_REQUEST['level_burs']) && $_REQUEST['level_burs'] <> '')
            {
                if ($_REQUEST['fee_disc'] == 'Application Fee')
                {			
                    if (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '0')
                    {
                        if (is_bool(strpos($sql_from, ", prog_choice d")))
                        {
                            $sql_from .= ', prog_choice d';
                            $sql_where .= ' a.Regno = d.vApplicationNo AND ';
                        }
                    }
                }else
                {
                    if (is_bool(strpos($sql_from, ", s_m_t d")))
                    {
                        $sql_from .= ', s_m_t d';
                        $sql_where .= ' a.Regno = d.vMatricNo AND ';
                        $sql_where .= ' a.Regno = d.vMatricNo AND ';
                    }
                }
                
                if ($_REQUEST['fee_disc'] == 'Application Fee')
                {
                    if (!is_bool(strpos($sql_from, ", prog_choice d")))
                    {
                        $sql_where .= ' d.iBeginLevel = ? AND ';
                    }
                }else
                {
                    if (!is_bool(strpos($sql_from, ", s_m_t d")))
                    {
                        $sql_where .= ' d.iStudy_level = ? AND ';
                    }
                }
                
                $binders .= 'i';
                $binded[count($binded)] = $_REQUEST['level_burs'];
            }
                
            if (isset($_REQUEST['cEduCtgId_burs']) && $_REQUEST['cEduCtgId_burs'] <> '')
            {
                $sql_where .= ' c.cEduCtgId = ? AND ';
                $binders .= 's';
                $binded[count($binded)] = substr($_REQUEST['cEduCtgId_burs'], 0, 3);
            }
            

            if (isset($_REQUEST['date_burs1']) && $_REQUEST['date_burs1'] <> '' && isset($_REQUEST['date_burs2']) && $_REQUEST['date_burs2'] <> '')
            {                        
                $sql_where .= ' (LEFT(a.TransactionDate,10) >= ? AND LEFT(a.TransactionDate,10) <= ?) AND';
                                
                $binders .= 'ss';
                $binded[count($binded)] = $_REQUEST['date_burs1'];
                $binded[count($binded)] = $_REQUEST['date_burs2'];
            }else if (isset($_REQUEST['date_burs1']) && $_REQUEST['date_burs1'] <> '')
            {
                $sql_where .= ' LEFT(a.TransactionDate,10) >= ? AND ';
                
                $binders .= 's';
                $binded[count($binded)] = $_REQUEST['date_burs1'];
            }else if (isset($_REQUEST['date_burs2']) && $_REQUEST['date_burs2'] <> '')
            {                     
                $sql_where .= ' LEFT(a.TransactionDate,10) <= ? AND ';
                
                $binders .= 's';
                $binded[count($binded)] = $_REQUEST['date_burs2'];
            }

            if (substr($sql_where, strlen($sql_where)-4 == 'AND '))
            {
                $sql_where = substr($sql_where, 0, strlen($sql_where)-4);
            }
        }
    }


    foreach ($binded as $v)
    {
        //echo $v."<br>";
        if ($c == 0)
        {
            $binded_none_arr .= $v;
        }else
        {
            $binded_none_arr .= $v."|";
        }
    }

    $binded_none_arr = substr($binded_none_arr, 0, strlen($binded_none_arr)-1);

    $sql = "SELECT DISTINCT $sql_flds FROM $sql_from WHERE $sql_where";
    //echo $binders.'<br>'.$sql.'<br>'.count($binded).'<p>';

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
        }
    }
    
    $stmt->execute();
    $stmt->store_result();

    //echo $stmt->num_rows;

    if ($_REQUEST["trn_side"] == 'r' || $_REQUEST["trn_stat"] == '2')
    {
        $stmt->bind_result($namess, $Regno, $rrr, $orderid, $tdate, $amount);
    }else
    {
        $stmt->bind_result($namess, $Regno, $rrr, $tdate, $amount);
    }
    $cnt = 0;
    $str = '';?>
    
    <div class="innercont_stff_tabs" id="ans2" style="margin-top:-1px; border:0px; margin-bottom:5px; height:556px; display:block">
        <table id="gridz" class="table table-condensed table-responsive" style="width:95%;">
            <thead>
                <tr>
                    <th style="text-align:right; width:6%; padding-right:2%">Sn</th>
                    <th style="width:25%;">Name</th>
                    <th style="width:10%;">AFN/Mat. No.</th>
                    <th style="width:10%;">Ref. No.</th>
                    <th style="width:18%;">Order ID</th>
                    <th style="width:15%;">Date</th>
                    <th style="text-align:right; width:12%; padding-right:2%"><?php
                        if (isset($_REQUEST["l_f_resi_h"]))
                        {
                            if ($_REQUEST["l_f_resi_h"] == 'l')
                            {
                                echo 'Amount (NGN)';
                            }else
                            {
                                echo 'Amount ($)';
                            }
                        }?>
                    </th>
                </tr>
            </thead><?php
            $cnt = 0;
            $total_amount = 0;
            
            while ($stmt->fetch())
            {
                if (isset($_REQUEST['fee_disc']))
                {?>
                     <tr>
                        <td style="text-align:right; width:6%; padding-right:2%"><?php echo ++$cnt;?></td>
                        <td style="width:25%;"><?php echo $namess; ?></td>
                        <td style="width:10%;"><?php echo $Regno;?></td>
                        <td style="width:10%;"><?php echo $rrr;?></td>
                        <td style="width:18%;"><?php
                            if ((isset($_REQUEST["trn_side"]) && $_REQUEST["trn_side"] == 'r') || (isset($_REQUEST["trn_stat"]) && $_REQUEST["trn_stat"] == '2'))
                            {
                                echo $orderid;
                            }else
                            {
                                echo 'order ID';
                            }?>
                        </td>
                        <td style="width:15%;"><?php echo substr($tdate, 8,2).'-'.substr($tdate, 5,2).'-'.substr($tdate, 0,4).' '.substr($tdate, 11,strlen($tdate));?></td>
                        <td style="text-align:right; width:12%; padding-right:2%"><?php echo number_format($amount); $total_amount += $amount;?></td>
                    </tr><?php
                }
            }?>
                
            <tfoot>
                <tr>
                    <th style="text-align:right; width:6%; padding-right:2%"></th>
                    <th style="width:25%;"></th>
                    <th style="width:10%;"></th>
                    <th style="width:10%;"></th>
                    <th style="width:18%;"></th>
                    <th style="width:15%;"></th>
                    <th style="text-align:right; width:12%; padding-right:2%"><?php
                        echo number_format($total_amount)?>
                    </th>
            </tfoot>
        </table>
    </div><?php
}?>