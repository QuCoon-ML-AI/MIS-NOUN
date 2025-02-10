<div class="appl_left_child_div" style="width:98%; margin:auto; height:auto; background-color:#eff5f0">
    <div class="appl_left_child_div_child calendar_grid" style="font-weight: bold; margin:0px;">
        <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
            Snos
        </div>
        <div style="flex:10%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
            Course Code
        </div>
        <div style="flex:45%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
            Course Title
        </div>
        <div style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
            Credit unit
        </div>
        <div style="flex:10%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
            Category
        </div>
        <div style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
            Grade
        </div>
        <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
            Repeat
        </div>
    </div><?php
                            
    $c = 0; 
    $total_cost = 0; 
    $total_cr = 0;
    $tcr1 = 0;
    
    $total_cost_all = 0;

    $prev_level = "";
    $semester_opt = "";
    
    if (!isset($cEduCtgId_loc))
    {?>
        <div style="font-family:Verdana, Arial, Helvetica, sans-serif; 
        margin:auto; 
        text-align:center;
    	font-size: 0.78em;"> Follow <a href="../" style="text-decoration:none;">here</a></div><?php
    	exit;
    }

    if ($cEduCtgId_loc == 'PSZ')
    {
        if ($iStudy_level_loc == 100 && $tSemester_loc == 1)
        {
            $prev_level = $iStudy_level_loc;
            $semester_opt = $tSemester_loc;
        }else if ($iStudy_level_loc == 100 && $tSemester_loc == 2)
        {
            $prev_level = $iStudy_level_loc;
            $semester_opt = 1;
        }else if ($iBeginLevel_loc == 100)
        {
            if ($iStudy_level_loc > 100)
            {
                if ($tSemester_loc == 1 || $tSemester_loc%2 > 0)
                {
                    $prev_level = $iStudy_level_loc - 100;
                    $semester_opt = 2;
                }else if ($tSemester_loc == 2 || $tSemester_loc%2 == 0)
                {
                    $prev_level = $iStudy_level_loc;
                    $semester_opt = 1;
                }
            }
        }else if ($iBeginLevel_loc == 200)
        {
            if ($iStudy_level_loc == 200 && $tSemester_loc == 1)
            {
                $prev_level = $iStudy_level_loc;
                $semester_opt = $tSemester_loc;
            }else if ($iStudy_level_loc == 200 && $tSemester_loc == 2)
            {
                $prev_level = $iStudy_level_loc;
                $semester_opt = 1;
            }else if ($iStudy_level_loc > 200)
            {
                if ($tSemester_loc == 1 || $tSemester_loc%2 > 0)
                {
                    $prev_level = $iStudy_level_loc - 100;
                    $semester_opt = 2;
                }else if ($tSemester_loc == 2 || $tSemester_loc%2 == 0)
                {
                    $prev_level = $iStudy_level_loc;
                    $semester_opt = 1;
                }
            }
        }else if ($iBeginLevel_loc == 300)
        {
            if ($iStudy_level_loc == 300 && $tSemester_loc == 1)
            {
                $prev_level = $iStudy_level_loc;
                $semester_opt = $tSemester_loc;
            }else if ($iStudy_level_loc == 300 && $tSemester_loc == 2)
            {
                $prev_level = $iStudy_level_loc;
                $semester_opt = 1;
            }else if ($iStudy_level_loc > 300)
            {
                if ($tSemester_loc == 1 || $tSemester_loc%2 > 0)
                {
                    $prev_level = $iStudy_level_loc - 100;
                    $semester_opt = 2;
                }else if ($tSemester_loc == 2 || $tSemester_loc%2 == 0)
                {
                    $prev_level = $iStudy_level_loc;
                    $semester_opt = 1;
                }
            }
        }
    }
    
    $mysqli = link_connect_db();
    
    $arr_grade = array(array(array(array())));
    $cnt = 0;
    
    $table = search_starting_crs1($_REQUEST['vMatricNo']);
    foreach ($table as &$value)
    {
        $wrking_tab = 'examreg_result_'.$value;
        
    	$stmt1 = $mysqli->prepare("SELECT cCourseId, cgrade, iobtained_comp, tsemester, cAcademicDesc   
        FROM $wrking_tab
        WHERE vMatricNo = ? 
        ORDER BY tSemester, cCourseId");
        
        $stmt1->bind_param("s", $_REQUEST['vMatricNo']);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($cCourseId_02, $cgrade_02, $score_02, $tsemester_02, $session_02);
        
        while($stmt1->fetch())
        {
            $cnt++;
            $arr_grade[$cnt]['cCourseId'] = $cCourseId_02;
            $arr_grade[$cnt]['score'] = $score_02;
            $arr_grade[$cnt]['cgrade'] = $cgrade_02;
            $arr_grade[$cnt]['tsemester'] = $tsemester_02;
            $arr_grade[$cnt]['cAcademicDesc'] = $session_02;
        }
    }

    // $stmt1 = $mysqli->prepare("SELECT cCourseId, cgrade, iobtained_comp, tsemester, cAcademicDesc   
    // FROM examreg_result
    // WHERE vMatricNo = ? 
    // ORDER BY tSemester, cCourseId");
    
    // $stmt1->bind_param("s", $_REQUEST['vMatricNo']);
    // $stmt1->execute();
    // $stmt1->store_result();
    // $stmt1->bind_result($cCourseId_02, $cgrade_02, $score_02, $tsemester_02, $session_02);
    
    // $arr_grade = array(array(array(array())));
    // $cnt = 0;

    // while($stmt1->fetch())
    // {
    //     $cnt++;
    //     $arr_grade[$cnt]['cCourseId'] = $cCourseId_02;
    //     $arr_grade[$cnt]['score'] = $score_02;
    //     $arr_grade[$cnt]['cgrade'] = $cgrade_02;
    //     $arr_grade[$cnt]['tsemester'] = $tsemester_02;
    //     $arr_grade[$cnt]['cAcademicDesc'] = $session_02;
    // }
    $stmt1->close();

    $prev_sem = '';
    $sem_tcc = 0;
    $sem_tcp = 0;
    $cum_sem_tcp = 0;

    $total_semester_weight = 0;

    $cum_weight = 0;
    $tc_with_result = 0;
    $wgp = 0;

    $tcp = 0;
    $c = 0;
    
    $gpa = 0;
    
    $course_found = '';
    
    if ($cEduCtgId_loc == 'PSZ')
    {
        $sub_qry = "";
        if (is_numeric($semester_opt))
        {
            $sub_qry = " AND d.tSemester = $semester_opt";
        }
        
        if ($iEndLevel_loc == $iStudy_level_loc)
        {
            $sub_qry = "";
        }

        if ($prev_level == '')
        {
            $prev_level = 0;
        }
        
        $stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, d.siLevel, d.tSemester, d.tdate, a.iCreditUnit, d.cAcademicDesc, a.cCategory
        FROM coursereg_arch_20242025 a, examreg_20242025 d
        WHERE  a.cCourseId = d.cCourseId 
        AND a.vMatricNo = d.vMatricNo
        AND a.vMatricNo = ? 
        AND d.siLevel = $prev_level
        $sub_qry
        ORDER BY d.siLevel, d.tSemester, d.cCourseId");

        // $stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, d.siLevel, d.tSemester, d.tdate, a.iCreditUnit, d.cAcademicDesc, a.cCategory
        // FROM coursereg_arch_20242025 a, examreg_20242025 d
        // WHERE  a.cCourseId = d.cCourseId 
        // AND a.vMatricNo = d.vMatricNo
        // AND a.vMatricNo = ? 
        // a.tdate >= '$semester_begin_date'
        // ORDER BY d.siLevel, d.tSemester, d.cCourseId");
    }else
    {
        $stmt = $mysqli->prepare("SELECT a.cCourseId, a.vCourseDesc, d.siLevel, d.tSemester, d.tdate, a.iCreditUnit, d.cAcademicDesc, a.cCategory
        FROM coursereg_arch_20242025 a, examreg_20242025 d
        WHERE  a.cCourseId = d.cCourseId 
        AND a.vMatricNo = d.vMatricNo 
        AND a.vMatricNo = ?
        ORDER BY d.siLevel, d.tSemester, d.cCourseId");
    }
    
    $stmt->bind_param("s", $_REQUEST['vMatricNo']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cCourseId_01, $vCourseDesc_01, $siLevel_01, $tSemester_01, $tdate, $iCreditUnit_01, $cAcademicDesc_01, $cCategory_01);
    
    while($stmt->fetch())
    {
        $cgrade_01 = '';
        $score_01 = '';
        $weight = 0;

        $course_found = '';
        $grade_found = '';
        for ($i = 1; $i <= count($arr_grade); $i++)
        {
            if (isset($arr_grade[$i]['cCourseId']))
            {
                if ($course_found == $arr_grade[$i]['cCourseId'] && 
                ((($cEduCtgId_loc == 'PSZ' || $cEduCtgId_loc == 'ELX') && $arr_grade[$i]['cgrade'] == 'F') || 
                (($cEduCtgId_loc == 'PGX' || $cEduCtgId_loc == 'PGY' || $cEduCtgId_loc == 'PRX') && $arr_grade[$i]['cgrade'] == 'E')))
                {
                    continue;
                }
                
                
                $cgrade_01 = '';
                $score_01 = '';

                //if ($arr_grade[$i]['cCourseId'] == $cCourseId_01 && $arr_grade[$i]['tsemester'] == $tSemester_01 && $arr_grade[$i]['cAcademicDesc'] == $cAcademicDesc_01)
                if ($arr_grade[$i]['cCourseId'] == $cCourseId_01 && $arr_grade[$i]['cAcademicDesc'] == $cAcademicDesc_01)
                {
                    $show_student_01 = 1;
                    $cgrade_01 = $arr_grade[$i]['cgrade'];
                    $score_01 = $arr_grade[$i]['score'];
                    
                    if ($score_01 >= 70)
                    {
                        $point = 5;
                    }else if ($score_01 >= 60 && $score_01 <= 69)
                    {
                        $point = 4;
                    }else if ($score_01 >= 50 && $score_01 <= 59)
                    {
                        $point = 3;
                    }else if ($score_01 >= 45 && $score_01 <= 49)
                    {
                        $point = 2;
                    }else if ($score_01 >= 40 && $score_01 <= 44)
                    {
                        $point = 1;
                    }else if ($score_01 <= 39)
                    {
                        $point = 0;
                    }
                    
                    $weight = $point*$iCreditUnit_01;
                    
                    break;
                }

                $course_found = $arr_grade[$i]['cCourseId'];
            }
        }
        
        if ($prev_sem <> '' && $prev_sem <> $tSemester_01)
        {?>
            <div class="appl_left_child_div_child calendar_grid" style="font-weight: bold; margin:0px;">
                <div style="flex:10%; padding-top:5px; padding-right:4px; height:35px; text-align:right;"></div>
                <div style="flex:30%; padding-top:5px; padding-right:4px; height:35px; text-align:right;">
                    Total credit carried (TCC): <?php echo $sem_tcc; ?>
                </div>
                <div style="flex:30%; padding-top:5px; padding-left:4px; height:35px; text-align:right;">
                    Total credit passed (TCP): <?php echo $sem_tcp; ?>
                </div>
                <div style="flex:30%; padding-top:5px; padding-right:4px; height:35px; text-align:right;">
                    Grade point average (GPA): <?php
                    if($sem_tcp>0 && $orgsetins["cShowgpa"] == '1' && $orgsetins["cShowrslt_for_student"] == '1')
                    {
                        $gpa = round(($total_semester_weight/$sem_tcp),1);
                        echo $gpa;

                        if ($gpa >= 4.5)
                        {
                            echo ' 1st Class';
                        }else if ($gpa >= 3.5 && $gpa <= 4.49)
                        {
                            echo ' 2nd Class Upper';
                        }else if ($gpa >= 2.5 && $gpa <= 3.49)
                        {
                            echo ' 2nd Class Lower';
                        }else if ($gpa >= 1.5 && $gpa <= 2.49)
                        {
                            echo ' 3rd Class';
                        }else if ($gpa >= 1.0 && $gpa <= 1.49)
                        {
                            echo ' Pass';
                        }
                    }else
                    {
                        echo '-';
                    }
                    
                    $cum_weight += $total_semester_weight;
                    $cum_sem_tcp += $sem_tcp;?>
                </div>
            </div><?php
            $sem_tcc = 0;
            $sem_tcp = 0;
            $total_semester_weight = 0;
        }
        
    
        if ($prev_sem == '' || ($prev_sem <> '' && $prev_sem <> $tSemester_01))
        {
            if ($cEduCtgId_loc == 'PSZ')
            {
                if ($tSemester_01 == 1)
                {
                    $tSemester_desc = 'First semester';
                }else
                {
                    $tSemester_desc = 'Second semester';
                }
            }else
            {
                $tSemester_desc = 'Semester '.$tSemester_01;
            }?>
            <div class="appl_left_child_div_child calendar_grid" style="margin:0px;">
                <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; text-align:right;">
                </div>
                <div style="flex:95%; padding-top:5px; padding-left:4px; height:35px;">
                    <?php echo $siLevel_01.'L '.$tSemester_desc;?>
                </div>
            </div><?php
        }
        
        $c++;

        $sem_tcc = $sem_tcc + $iCreditUnit_01;
        
        if (isset($cgrade_01) && $cgrade_01 <> '')
        {
            if ($cEduCtgId_loc <> 'PGX' && $cEduCtgId_loc <> 'PGY' && $cEduCtgId_loc <> 'PRX')
            {
                if ($cgrade_01 <> 'F' && $cgrade_01 <> 'I' && $cgrade_01 <> '')
                {
                    $tcp = $tcp + $iCreditUnit_01;
                    $sem_tcp = $sem_tcp + $iCreditUnit_01;

                    $course_status = 'No';
                }else if ($cgrade_01 == 'F')
                {
                    $course_status = 'Yes';
                }else if ($cgrade_01 == 'I')
                {
                    $course_status = 'Incomplete';
                }else 
                {
                    $course_status = 'Pending';
                }
            }else
            {
                if ($cgrade_01 == 'F')
                {
                    $course_status = 'Yes';
                }elseif ($cgrade_01 <> 'E' && $cgrade_01 <> 'I' && $cgrade_01 <> '')
                {
                    $tcp = $tcp + $iCreditUnit_01;
                    $sem_tcp = $sem_tcp + $iCreditUnit_01;

                    $course_status = 'No';
                }else if ($cgrade_01 == 'I')
                {
                    $course_status = 'Incomplete';
                }else  
                {
                    $course_status = 'Pending';
                }
            }
            $total_semester_weight += $weight;
        }else
        {
            $cgrade_01 = '--';
            $course_status = 'Pending';
        }?>

        <div class="appl_left_child_div_child calendar_grid" style="margin:0px; margin-bottom:5px;">
            <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                <?php echo $c;?>
            </div>
            <div style="flex:10%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                <?php echo $cCourseId_01; ?>
            </div>
            <div style="flex:45%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                <?php echo $vCourseDesc_01;?>
            </div>
            <div style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                <?php echo $iCreditUnit_01; $total_cr += $iCreditUnit_01;?>
            </div>
            <div style="flex:10%; padding-top:5px; padding-left:4px; height:35px; background-color: #ffffff">
                <?php echo $cCategory_01;?>
            </div>
            <div style="flex:10%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                <?php if ($orgsetins["cShowrslt"] == '1' /*&& $show_student_01 == '1'*/)
                {
                    if ($orgsetins["cShowscore"] == '1' || $orgsetins["cShowgrade"] == '1')
                    {
                        if ($orgsetins["cShowscore"] == '1')
                        {
                            echo $score_01;
                        }

                        if ($orgsetins["cShowgrade"] == '1')
                        {
                            echo ' '.$cgrade_01;
                        }
                    }else
                    {
                        echo '-';
                    }
                }else
                {
                    echo '-';
                }?>
            </div>
            <div style="flex:5%; padding-top:5px; padding-right:4px; height:35px; background-color: #ffffff; text-align:right;">
                <?php if ($orgsetins["cShowscore"] == '1' || $orgsetins["cShowgrade"] == '1')
                    {
                        echo $course_status;
                    }else
                    {
                        echo '-';
                    }?>
            </div>
        </div><?php
    
        $prev_sem = $tSemester_01;
    }
    $stmt->close();?>
    

    <div class="appl_left_child_div_child calendar_grid" style="font-weight: bold; margin:0px;">
		<div style="flex:10%; padding-top:5px; padding-right:4px; height:35px; text-align:right;"></div>
		<div style="flex:30%; padding-top:5px; padding-right:4px; height:35px; text-align:right;">
            Total credit carried (TCC): <?php echo $sem_tcc; ?>
        </div>
		<div style="flex:30%; padding-top:5px; padding-left:4px; height:35px; text-align:right;">
            Total credit passed (TCP): <?php if ($orgsetins["cShowrslt_for_student"] == '1'){echo $sem_tcp;}else{echo '-';} ?>
		</div>
		<div style="flex:30%; padding-top:5px; padding-right:4px; height:35px; text-align:right;">
            Grade point average (GPA): <?php
            if($orgsetins["cShowgpa"] == '1' && $orgsetins["cShowrslt_for_student"] == '1')
            {
                if ($sem_tcp > 0)
                {
                    $gpa = round(($total_semester_weight/$sem_tcp),1);
                    echo $gpa;
                }else if ($cum_sem_tcp > 0)
                {
                    $gpa = round(($cum_weight/$cum_sem_tcp),1);
                    echo $gpa;
                }
                gpa_class($gpa);
            }else
            {
                echo '-';
            }?>
		</div>
	</div>   
    <?php //$level_semester = cal_cgpa($cEduCtgId_loc);?>
</div><?php



//collect all results


/*$arr_all_reg_courses = array(array(array(array())));
$cnt = 0;
$table = search_starting_crs1($_REQUEST['vMatricNo']);

foreach ($table as &$value)
{
    $wrking_tab = 'coursereg_arch_'.$value;

    $stmt = $mysqli->prepare("SELECT cCourseId, vCourseDesc, iCreditUnit, cCategory
    FROM $wrking_tab  WHERE vMatricNo = ? 
    ORDER BY cCourseId");
    $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cCourseId_02, $vCourseDesc_02, $iCreditUnit_02, $cCategory_02);
    
    while($stmt->fetch())
    {
        $cnt++;
        $arr_all_reg_courses[$cnt]['cCourseId'] = $cCourseId_02;
        $arr_all_reg_courses[$cnt]['vCourseDesc'] = $vCourseDesc_02;
        $arr_all_reg_courses[$cnt]['iCreditUnit'] = $iCreditUnit_02;
        $arr_all_reg_courses[$cnt]['cCategory'] = $cCategory_02;
        
        echo $arr_all_reg_courses[$cnt]['cCourseId'].', '.
        $arr_all_reg_courses[$cnt]['vCourseDesc'].', '.
        $arr_all_reg_courses[$cnt]['iCreditUnit'].', '.
        $arr_all_reg_courses[$cnt]['cCategory'].'<br>';
    }
}*/?>