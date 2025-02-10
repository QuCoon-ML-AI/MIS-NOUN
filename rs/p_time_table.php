
<div class="appl_left_child_div" style="width:99%; margin:auto; gap:5px; margin-top:10px; background-color:#fff">
    <div class="appl_left_child_div_child">
        <div style="flex:100%; padding-left:5px; padding-top:5px; height:30px; background-color: #FFFFFF; font-weight:bold"><?php 
        echo $orgsetins['cAcademicDesc'];

        if ($tSemester_loc == 1)
        {
            echo ' First semester';
        }else
        {
            echo ' Second semester';
        }

        $stmt = $mysqli->prepare("SELECT final FROM tt");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($final);
        $stmt->fetch();
        $stmt->close();

        if (is_null($final))
        {
            $final = '';
        }
        
        if ($final == '1')
        {
            echo ' Final';
        }else
        {
            echo ' Draft';
        }?> Personal Examination Timetable
        </div>
    </div>
    
    <div class="appl_left_child_div_child" style="flex-flow: row; font-weight:bold; font-size:12px">
        <div style="flex:10%; padding-left:5px; padding-top:5px; height:30px; background-color: #eff5f0">
            Day/Date
        </div>
        <div style="flex:30%; padding-left:5px; padding-top:5px; height:30px; background-color: #fff;">
            8:30am
        </div>
        <div style="flex:30%; padding-left:5px; padding-top:5px; height:30px; background-color: #fff;">
            11:00am
        </div>
        <div style="flex:30%; padding-left:5px; padding-top:5px; height:30px; background-color: #fff;">
            2:00pm
        </div>
    </div><?php
    
    
    $arr_trabsactions = array(array(array()));
    $table = search_starting_pt_crs($_REQUEST['vMatricNo']);
    
    $cnt = 0;
    foreach ($table as &$value)
    {
        $wrking_tab = 'coursereg_arch_'.$value;
    
        $stmt_s = $mysqli->prepare("SELECT cCourseId, vCourseDesc, cCategory, iCreditUnit
        FROM $wrking_tab 
        WHERE vMatricNo = ?
        ORDER BY cCourseId");                                
        $stmt_s->bind_param("s", $_REQUEST["vMatricNo"]);
        $stmt_s->execute();
        $stmt_s->store_result();
        $stmt_s->bind_result($cCourseId, $vCourseDesc, $cCategory, $iCreditUnit);
        while($stmt_s->fetch())
        {
            $cnt++;
            
            $arr_trabsactions[$cnt]['cCourseId'] = $cCourseId;
            $arr_trabsactions[$cnt]['vCourseDesc'] = $vCourseDesc;
            $arr_trabsactions[$cnt]['cCategory'] = $cCategory;
            $arr_trabsactions[$cnt]['iCreditUnit'] = $iCreditUnit;
            
            /*echo $arr_trabsactions[$cnt]['cCourseId'].', '.
            $arr_trabsactions[$cnt]['vCourseDesc'].', '.
            $arr_trabsactions[$cnt]['cCategory'].', '.
            $arr_trabsactions[$cnt]['iCreditUnit'].'<p>';*/
        }
    }
        
    $stmt = $mysqli->prepare("SELECT *
    FROM examreg_20242025
    WHERE tdate >= '$semester_begin_date'
    AND vMatricNo = ?");
    
    $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0)
    {?>                                
        <div class="appl_left_child_div_child calendar_grid" style="margin:0px;">
            <div style="flex:5.2%; padding-top:5px; height:35px; background-color: #ffffff; text-align:right;">
            </div>
            <div style="flex:95%; padding-top:5px; padding-left:5px; padding-top:5px; height:35px; background-color: #fdf0bf">
                You need to register courses for exam for the current semester. See procedure 'M' in <a href="#" style="text-decoration:none; color:#FF3300" 
                onclick="guides_instructions.submit();
                return false">'How to do things'</a> for steps to follow
            </div>
        </div><?php
        $can_see_slip = 0;
        $stmt->close();
    }else
    {
        $stmt_t = $mysqli->prepare("SELECT MAX(iday) FROM tt");
        $stmt_t->execute();
        $stmt_t->store_result();
        $stmt_t->bind_result($days_of_exam);
        $stmt_t->fetch();
        $stmt_t->close();

        if (is_null($days_of_exam))
        {
            $days_of_exam = 0;
        }
        
        $iday = 0;
        
        for ($iday = 1; $iday <= $days_of_exam; $iday++)
        {
            $stmt_t = $mysqli->prepare("SELECT exam_date, b.cCourseId FROM tt b, examreg_20242025 a 
            WHERE iday = $iday 
            AND a.cCourseId = b.cCourseId
            AND a.tdate >= '$semester_begin_date'
            AND a.vMatricNo = ? ");
            $stmt_t->bind_param("s", $_REQUEST["vMatricNo"]);
            $stmt_t->execute();
            $stmt_t->store_result();
            if ($stmt_t->num_rows <> 0)
            {
                $stmt_t->bind_result($exam_date, $cCourseId_0);
                while($stmt_t->fetch())
                {?>
                   <div class="appl_left_child_div_child" style="flex-flow: row; line-height:1.5;; font-size:12px">
                        <div style="flex:10%; padding-left:5px; padding-top:5px; height:50px; line-height:1.5; background-color: #fff; text-align:left; font-weight:bold">
                            <?php echo $iday.'/'.$exam_date;?>
                        </div><?php 
                            $day_work = '';
                            
                            $stmt_s = $mysqli->prepare("SELECT cCourseId
                            FROM examreg_20242025
                            WHERE tdate >= '$semester_begin_date'
                            AND cCourseId = '$cCourseId_0'
                            AND vMatricNo = ?
                            AND cCourseId IN (SELECT cCourseId FROM tt WHERE iday = $iday AND cSession = 1)
                            ORDER BY cCourseId");                                
                            $stmt_s->bind_param("s", $_REQUEST["vMatricNo"]);
                            $stmt_s->execute();
                            $stmt_s->store_result();
                            $stmt_s->bind_result($cCourseId);
                            while($stmt_s->fetch())
                            {
                                $vCourseDesc = '';
                                for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                {
                                    if ($arr_trabsactions[$b]['cCourseId'] == $cCourseId)
                                    {
                                        $vCourseDesc = $arr_trabsactions[$b]['vCourseDesc'];
                                        $cCategory = $arr_trabsactions[$b]['cCategory'];
                                        $iCreditUnit = $arr_trabsactions[$b]['iCreditUnit'];
                                        break;
                                    }
                                }
                                
                                if ($vCourseDesc <> '')
                                {
                                    $day_work .= $cCourseId." ".$vCourseDesc." ".$cCategory." ".$iCreditUnit."\n";
                                }
                            }
                            $stmt_s->close();?>

                        <div style="flex:30%; padding-left:5px; padding-top:5px;  height:50px; line-height:1.5; background-color: #eff5f0; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" title="<?php echo $day_work;?>"><?php 
                            echo $day_work;?>
                        </div><?php 
                            $day_work = '';
                            
                            $stmt_s = $mysqli->prepare("SELECT cCourseId
                            FROM examreg_20242025
                            WHERE tdate >= '$semester_begin_date'
                            AND cCourseId = '$cCourseId_0'
                            AND vMatricNo = ?
                            AND cCourseId IN (SELECT cCourseId FROM tt WHERE iday = $iday AND cSession = 2)
                            ORDER BY cCourseId");                                
                            $stmt_s->bind_param("s", $_REQUEST["vMatricNo"]);
                            $stmt_s->execute();
                            $stmt_s->store_result();
                            $stmt_s->bind_result($cCourseId);
                            while($stmt_s->fetch())
                            {
                                $vCourseDesc = '';
                                for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                {
                                    if ($arr_trabsactions[$b]['cCourseId'] == $cCourseId)
                                    {
                                        $vCourseDesc = $arr_trabsactions[$b]['vCourseDesc'];
                                        $cCategory = $arr_trabsactions[$b]['cCategory'];
                                        $iCreditUnit = $arr_trabsactions[$b]['iCreditUnit'];
                                        break;
                                    }
                                }
                                
                                if ($vCourseDesc <> '')
                                {
                                    $day_work .= $cCourseId." ".$vCourseDesc." ".$cCategory." ".$iCreditUnit."\n";
                                }
                            }
                            $stmt_s->close();?>
                        <div style="flex:30%; padding-left:5px; padding-top:5px;  height:50px; line-height:1.5; background-color: #eff5f0; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" title="<?php echo $day_work;?>"><?php
                            echo $day_work;?>
                        </div><?php 
                            $day_work = '';
                            
                            $stmt_s = $mysqli->prepare("SELECT cCourseId
                            FROM examreg_20242025
                            WHERE tdate >= '$semester_begin_date'
                            AND cCourseId = '$cCourseId_0'
                            AND vMatricNo = ?
                            AND cCourseId IN (SELECT cCourseId FROM tt WHERE iday = $iday AND cSession = 3)
                            ORDER BY cCourseId");                                
                            $stmt_s->bind_param("s", $_REQUEST["vMatricNo"]);
                            $stmt_s->execute();
                            $stmt_s->store_result();
                            $stmt_s->bind_result($cCourseId);
                            while($stmt_s->fetch())
                            {
                                $vCourseDesc = '';
                                for ($b = 1; $b <= count($arr_trabsactions)-1; $b++)
                                {
                                    if ($arr_trabsactions[$b]['cCourseId'] == $cCourseId)
                                    {
                                        $vCourseDesc = $arr_trabsactions[$b]['vCourseDesc'];
                                        $cCategory = $arr_trabsactions[$b]['cCategory'];
                                        $iCreditUnit = $arr_trabsactions[$b]['iCreditUnit'];
                                        break;
                                    }
                                }
                                
                                if ($vCourseDesc <> '')
                                {
                                    $day_work .= $cCourseId." ".$vCourseDesc." ".$cCategory." ".$iCreditUnit."\n";
                                }
                            }
                            $stmt_s->close();;?>
                        <div style="flex:30%; padding-left:5px; padding-top:5px;  height:50px; line-height:1.5; background-color: #eff5f0; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" title="<?php echo $day_work;;?>"><?php
                            echo $day_work;?>
                        </div>
                    </div><?php 
                }
            }
        }
        
        

        if ($iday > 0)
        {?>    
            <div id="btn_div" style="display:flex; 
                flex:100%;
                justify-content:flex-end;
                height:auto;
                margin-top:10px;">
                    <button id="submit_btn" type="button" class="login_button" 
                    onclick="std_id_card.action='print-result'; 
                    std_id_card.submit();">Print</button>
            </div><?php
        }
    }?>
</div>