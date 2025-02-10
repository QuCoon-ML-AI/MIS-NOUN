<!-- olevel subjects--><?php

if ((isset($_REQUEST["ope_mode"]) && $_REQUEST["ope_mode"]<>'d') && (isset($_REQUEST["cQualCodeId"]) && ($_REQUEST["cQualCodeId"] == '201' || $_REQUEST["cQualCodeId"] == '202' || $_REQUEST["cQualCodeId"] == '203' || $_REQUEST["cQualCodeId"] == '204' || $_REQUEST["cQualCodeId"] == '207') && $dsplay_qual_header == 'flex'))
{       
    $sql1 = "select * from qualsubject where cDelFlag = 'N' order by vQualSubjectDesc";
    $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("Unable to query qualsubject".mysqli_error(link_connect_db()));
    $cnt = 0;

    $arr_sbjt_olevel = array(array());
    while($table1 = mysqli_fetch_array($rsql1))
    {
        if (isset($table1['cQualSubjectId']))
        {
            $cnt++;
            $arr_sbjt_olevel[$cnt]['cQualSubjectId'] = $table1['cQualSubjectId'];
            $arr_sbjt_olevel[$cnt]['vQualSubjectDesc'] = $table1['vQualSubjectDesc'];
        }
    }
    mysqli_close(link_connect_db());

    
    $arr_sbjt_olevel_grd = array(array());

    $stmt = $mysqli->prepare("SELECT DISTINCT cQualGradeId, cQualGradeCode, iQualGradeRank
    FROM qualgrade
    WHERE cEduCtgId = ? AND cDelFlag = 'N' order by iQualGradeRank desc");
    $stmt->bind_param("s", $cEduCtgId_qual);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cQualGradeId, $cQualGradeCode, $iQualGradeRank);

    $cnt = 0;
    
    while($stmt->fetch())
    {
        $cnt++;
        $arr_sbjt_olevel_grd[$cnt]['cQualGradeId'] = $cQualGradeId;
        $arr_sbjt_olevel_grd[$cnt]['cQualGradeCode'] = $cQualGradeCode;
    }
    $stmt->close();

    
    $stmt = $mysqli->prepare("select a.cQualSubjectId, vQualSubjectDesc, cQualGradeId
    from applysubject a, qualsubject b
    where a.cQualSubjectId = b.cQualSubjectId and cQualCodeId = ? and vExamNo = ? 
    and vApplicationNo = ? AND a.cDelFlag = 'N' order by vQualSubjectDesc");
    $stmt->bind_param("sss", $_REQUEST["cQualCodeId"], $_REQUEST["vExamNo"], $vApplicationNo);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cQualSubjectId, $vQualSubjectDesc, $cQualGradeId);

    $t = 0;
    $arr_sbjt_olevel_grd_rec = array(array());
    while($stmt->fetch())
    {
        $t++;
        $arr_sbjt_olevel_grd_rec[$t]['cQualSubjectId'] = $cQualSubjectId;
        $arr_sbjt_olevel_grd_rec[$t]['cQualGradeId'] = $cQualGradeId;
    }
    $stmt->close();
    $cand_totoal_subj = $t;

    $subnum = 0;
    
    while($subnum <= $iQSLCount_01-1)
    {
        $subnum++;
        $cQualSubjectId = '';
        $cQualGradeId = '';
        if (isset($arr_sbjt_olevel_grd_rec[$subnum]["cQualSubjectId"]))
        {
            $cQualSubjectId = $arr_sbjt_olevel_grd_rec[$subnum]["cQualSubjectId"];
            $cQualGradeId = $arr_sbjt_olevel_grd_rec[$subnum]["cQualGradeId"];
        }?>

        <div id="sbjt_grade_div1<?php echo $subnum; ?>" class="appl_left_child_div_child" style="margin-top:10px; height:auto;">
            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff"><?php echo $subnum;?></div>
            <div style="flex:80%; height:50px; background-color: #ffffff">
                <select name="subject1<?php echo $subnum; ?>" id="subject1<?php echo $subnum; ?>" 
                    style="height:100%" 
                    <?php if ($input_status == ' readonly' || ($cand_totoal_subj < $subnum && $subnum - $cand_totoal_subj > 1))
                    {
                        echo 'disabled="disabled"';
                    }

                    echo $input_status;

                    if ($subnum==1){echo ' required';}
                    
                    if ($subnum <> $iQSLCount_01)
                    {?> 
                        onchange="if (this.value!=''&&grade1<?php echo $subnum; ?>.value!='')
                        {
                            grade1<?php echo $subnum+1; ?>.disabled=false;
                            subject1<?php echo $subnum+1; ?>.disabled=false
                        }else
                        {
                            grade1<?php echo $subnum+1; ?>.disabled=true;
                            subject1<?php echo $subnum+1; ?>.disabled=true
                        }"<?php 
                    }?>>
                    <option value="" selected="selected"></option><?php
                        for ($b = 1; $b <= count($arr_sbjt_olevel)-1; $b++)
                        {
                            if ($b%10==0)
                            {?>
                                <option disabled></option><?php
                            }?>
                            <option value="<?php echo $arr_sbjt_olevel[$b]['cQualSubjectId']?>"<?php 
                            if ($arr_sbjt_olevel[$b]['cQualSubjectId'] == $cQualSubjectId){echo " selected";}?>><?php echo $arr_sbjt_olevel[$b]['vQualSubjectDesc'];?></option><?php
                        }?>
                </select>
            </div>
            <div style="flex:15%; height:50px; background-color: #ffffff">
                <select name="grade1<?php echo $subnum; ?>" id="grade1<?php echo $subnum; ?>" 
                    style="height:100%"  <?php 
                        if ($input_status == ' readonly' || ($cand_totoal_subj < $subnum && $subnum - $cand_totoal_subj > 1))
                        {
                            echo 'disabled="disabled"';
                        }

                        echo $input_status;
                    
                        if ($subnum==1){echo ' required';}
                        
                        if ($subnum <> $iQSLCount_01)
                        {?> 
                            onchange="if (this.value!=''&&subject1<?php echo $subnum; ?>.value!='')
                            {
                                grade1<?php echo $subnum+1; ?>.disabled=false;
                                subject1<?php echo $subnum+1; ?>.disabled=false
                            }else
                            {
                                grade1<?php echo $subnum+1; ?>.disabled=true;
                                subject1<?php echo $subnum+1; ?>.disabled=true
                            }"<?php 
                        }?>>
                        <option value="" selected="selected"></option><?php
                        for ($a = 1; $a <= count($arr_sbjt_olevel_grd)-1; $a++)
                        {?>
                            <option value="<?php echo $arr_sbjt_olevel_grd[$a]['cQualGradeId']?>"<?php if ($arr_sbjt_olevel_grd[$a]['cQualGradeId'] == $cQualGradeId){echo " selected";}?>><?php echo $arr_sbjt_olevel_grd[$a]['cQualGradeCode']?></option><?php
                        }?>
                </select>
            </div>
        </div><?php
    }
}?>


<!-- alevel subjects--><?php
if ((isset($_REQUEST["ope_mode"]) && $_REQUEST["ope_mode"]<>'d') && (isset($cEduCtgId_qual) && $cEduCtgId_qual == 'OLY' || $cEduCtgId_qual == 'ALX' || $cEduCtgId_qual == 'ALY' || $cEduCtgId_qual == 'ALZ' || $cEduCtgId_qual == 'ALW'))
{
    $arr_sbjt_alevel = array(array());
    $sql1 = "select * from qualsubject WHERE cDelFlag = 'N' order by vQualSubjectDesc";
    $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("Unable to query qualsubject".mysqli_error(link_connect_db()));
    $cnt = 0;
    while($table1 = mysqli_fetch_array($rsql1))
    {
        if (isset($table1['cQualSubjectId']))
        {
            $cnt++;
            $arr_sbjt_alevel[$cnt]['cQualSubjectId'] = $table1['cQualSubjectId'];
            $arr_sbjt_alevel[$cnt]['vQualSubjectDesc'] = $table1['vQualSubjectDesc'];
        }
    }
    mysqli_close(link_connect_db());

    $stmt = $mysqli->prepare("SELECT DISTINCT cQualGradeId, cQualGradeCode, iQualGradeRank
    FROM qualgrade
    WHERE cEduCtgId = ? AND cDelFlag = 'N' order by iQualGradeRank desc");
    $stmt->bind_param("s", $cEduCtgId_qual);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cQualGradeId, $cQualGradeCode, $iQualGradeRank);

    $cnt = 0;
    
    while($stmt->fetch())
    {
        $cnt++;
        $arr_sbjt_alevel_grd[$cnt]['cQualGradeId'] = $cQualGradeId;
        $arr_sbjt_alevel_grd[$cnt]['cQualGradeCode'] = $cQualGradeCode;
    }
    $stmt->close();


    $stmt = $mysqli->prepare("select a.cQualSubjectId, vQualSubjectDesc, cQualGradeId
    from applysubject a, qualsubject b
    where a.cQualSubjectId = b.cQualSubjectId and cQualCodeId = ? and vExamNo = ? 
    and vApplicationNo = ? AND a.cDelFlag = 'N' order by vQualSubjectDesc");
    $stmt->bind_param("sss", $_REQUEST["cQualCodeId"], $_REQUEST["vExamNo"], $vApplicationNo);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cQualSubjectId, $vQualSubjectDesc, $cQualGradeId);

    $t = 0;
    $arr_sbjt_alevel_grd_rec = array(array());
    while($stmt->fetch())
    {
        $t++;
        $arr_sbjt_alevel_grd_rec[$t]['cQualSubjectId'] = $cQualSubjectId;
        $arr_sbjt_alevel_grd_rec[$t]['cQualGradeId'] = $cQualGradeId;
    }
    $stmt->close();
    $cand_totoal_subj = $t;

    $subnum = 0;
    while($subnum <= $iQSLCount_01-1)
    {
        $subnum++;
        $cQualSubjectId = '';
        $cQualGradeId = '';
        if (isset($arr_sbjt_alevel_grd_rec[$subnum]["cQualSubjectId"]))
        {
            $cQualSubjectId = $arr_sbjt_alevel_grd_rec[$subnum]["cQualSubjectId"];
            $cQualGradeId = $arr_sbjt_alevel_grd_rec[$subnum]["cQualGradeId"];
        }?>

        <div id="sbjt_grade_div2<?php echo $subnum; ?>" class="appl_left_child_div_child" style="margin-top:10px; height:auto;">
            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff"><?php echo $subnum;?></div>
            <div style="flex:80%; height:50px; background-color: #ffffff">
                <select name="subject2<?php echo $subnum; ?>" id="subject2<?php echo $subnum; ?>"
                style="height:100%"  <?php 
                if ($input_status == ' readonly' || ($cand_totoal_subj < $subnum && $subnum - $cand_totoal_subj > 1))
                {
                    echo 'disabled="disabled"';
                }

                echo $input_status;
                
                if ($subnum==1){echo ' required';}

                if ($subnum <> $iQSLCount_01)
                {?> 
                    onchange="if (this.value!=''&&grade2<?php echo $subnum; ?>.value!='')
                    {
                        grade2<?php echo $subnum+1; ?>.disabled=false;
                        subject2<?php echo $subnum+1; ?>.disabled=false
                    }else
                    {
                        grade2<?php echo $subnum+1; ?>.disabled=true;
                        subject2<?php echo $subnum+1; ?>.disabled=true
                    }"<?php 
                }?>>
                <option value="" selected="selected"></option><?php
                    for ($b = 1; $b <= count($arr_sbjt_alevel)-1; $b++)
                    {
                        if ($b%10==0)
                        {?>
                            <option disabled></option><?php
                        }?>
                        <option value="<?php echo $arr_sbjt_alevel[$b]['cQualSubjectId']?>"<?php if ($arr_sbjt_alevel[$b]['cQualSubjectId'] == $cQualSubjectId){echo " selected";}?>><?php echo $arr_sbjt_alevel[$b]['vQualSubjectDesc'];?></option><?php
                    }?>
            </select>
            </div>
            <div style="flex:15%; height:50px; background-color: #ffffff">
                <select name="grade2<?php echo $subnum; ?>" id="grade2<?php echo $subnum; ?>" 
                    style="height:100%" <?php 
                    if ($input_status == ' readonly' || ($cand_totoal_subj < $subnum && $subnum - $cand_totoal_subj > 1))
                    {
                        echo 'disabled="disabled"';
                    }

                    echo $input_status;
                    
                    if ($subnum==1){echo ' required';}
                    
                    if ($subnum <> $iQSLCount_01)
                    {?> 
                        onchange="if (this.value!=''&&subject2<?php echo $subnum; ?>.value!='')
                        {
                            grade2<?php echo $subnum+1; ?>.disabled=false;
                            subject2<?php echo $subnum+1; ?>.disabled=false
                        }else
                        {
                            grade2<?php echo $subnum+1; ?>.disabled=true;
                            subject2<?php echo $subnum+1; ?>.disabled=true
                        }"<?php 
                    }?>>
                    <option value="" selected="selected"></option><?php
                    for ($a = 1; $a <= count($arr_sbjt_alevel_grd)-1; $a++)
                    {?>
                        <option value="<?php echo $arr_sbjt_alevel_grd[$a]['cQualGradeId']?>"<?php if ($arr_sbjt_alevel_grd[$a]['cQualGradeId'] == $cQualGradeId){echo " selected";}?>><?php echo $arr_sbjt_alevel_grd[$a]['cQualGradeCode']?></option><?php
                    }?>
                </select>
            </div>
        </div><?php
    }
}?>


                            
<!-- 1subject specs--><?php
if ((isset($_REQUEST["ope_mode"]) && $_REQUEST["ope_mode"]<>'d') && (isset($cEduCtgId_qual) && substr($cEduCtgId_qual,0,1) == 'P' || substr($cEduCtgId_qual,0,2) == 'EL'))
{
    $sql1 = "select * from qualsubject where cDelFlag = 'N' order by vQualSubjectDesc";
    $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("Unable to query qualsubject".mysqli_error(link_connect_db()));
    $cnt = 0;

    $arr_sbjt_1 = array(array());
    while($table1 = mysqli_fetch_array($rsql1))
    {
        if (isset($table1['cQualSubjectId']))
        {
            $cnt++;
            $arr_sbjt_1[$cnt]['cQualSubjectId'] = $table1['cQualSubjectId'];
            $arr_sbjt_1[$cnt]['vQualSubjectDesc'] = $table1['vQualSubjectDesc'];
        }
    }
    mysqli_close(link_connect_db());

    $arr_sbjt_1_grd = array(array());

    $stmt = $mysqli->prepare("SELECT DISTINCT cQualGradeId, cQualGradeCode, iQualGradeRank
    FROM qualgrade
    WHERE cEduCtgId = ? AND cDelFlag = 'N' order by iQualGradeRank desc");
    $stmt->bind_param("s", $cEduCtgId_qual);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cQualGradeId, $cQualGradeCode, $iQualGradeRank);

    $cnt = 0;
    
    while($stmt->fetch())
    {
        $cnt++;
        $arr_sbjt_1_grd[$cnt]['cQualGradeId'] = $cQualGradeId;
        $arr_sbjt_1_grd[$cnt]['cQualGradeCode'] = $cQualGradeCode;
    }
    $stmt->close();
    
    
    
    $stmt = $mysqli->prepare("select a.cQualSubjectId, vQualSubjectDesc, cQualGradeId
    from applysubject a, qualsubject b
    where a.cQualSubjectId = b.cQualSubjectId and cQualCodeId = ? and vExamNo = ? 
    and vApplicationNo = ? AND a.cDelFlag = 'N' order by vQualSubjectDesc");
    $stmt->bind_param("sss", $_REQUEST["cQualCodeId"], $_REQUEST["vExamNo"], $vApplicationNo);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cQualSubjectId, $vQualSubjectDesc, $cQualGradeId);

    $t = 0;
    $arr_sbjt_1_rec = array(array());
    while($stmt->fetch())
    {
        $t++;
        $arr_sbjt_1_grd_rec[$t]['cQualSubjectId'] = $cQualSubjectId;
        $arr_sbjt_1_grd_rec[$t]['cQualGradeId'] = $cQualGradeId;
    }
    $stmt->close();
    $cand_totoal_subj = $t;

    $subnum = 0;
    while($subnum <= $iQSLCount_01-1)
    {
        $subnum++;
        $cQualSubjectId = '';
        $cQualGradeId = '';
        if (isset($arr_sbjt_1_grd_rec[$subnum]["cQualSubjectId"]))
        {
            $cQualSubjectId = $arr_sbjt_1_grd_rec[$subnum]["cQualSubjectId"];
            $cQualGradeId = $arr_sbjt_1_grd_rec[$subnum]["cQualGradeId"];
        }?>

        <div id="sbjt_grade_div3<?php echo $subnum; ?>" class="appl_left_child_div_child" style="margin-top:10px; height:auto;">
            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff"><?php echo $subnum;?></div>
            <div style="flex:80%; height:50px; background-color: #ffffff">
                <select name="subject3<?php echo $subnum; ?>" id="subject3<?php echo $subnum; ?>"
                style="height:100%" <?php 
                    if ($input_status == ' readonly' || ($cand_totoal_subj < $subnum && $subnum - $cand_totoal_subj > 1))
                    {
                        echo 'disabled="disabled"';
                    }
                    
                    if ($subnum <> $iQSLCount_01)
                    {?> 
                        onchange="if (this.value!=''&&subject3<?php echo $subnum; ?>.value!='')
                        {
                            grade3<?php echo $subnum+1; ?>.disabled=false;
                            subject3<?php echo $subnum+1; ?>.disabled=false
                        }else
                        {
                            grade3<?php echo $subnum+1; ?>.disabled=true;
                            subject3<?php echo $subnum+1; ?>.disabled=true
                        }"<?php 
                    }?>>
                    <option value="" selected="selected"></option><?php
                        for ($b = 1; $b <= count($arr_sbjt_1)-1; $b++)
                        {
                            if ($b%10==0)
                            {?>
                                <option disabled></option><?php
                            }?>
                            <option value="<?php echo $arr_sbjt_1[$b]['cQualSubjectId']?>"<?php if ($arr_sbjt_1[$b]['cQualSubjectId'] == $cQualSubjectId){echo " selected";}?>><?php echo $arr_sbjt_1[$b]['vQualSubjectDesc'];?></option><?php
                        }?>
                </select>
            </div>
            <div style="flex:15%; height:50px; background-color: #ffffff">
                <select name="grade3<?php echo $subnum; ?>" id="grade3<?php echo $subnum; ?>" 
                    style="height:100%"<?php 
                        if ($input_status == ' readonly' || ($cand_totoal_subj < $subnum && $subnum - $cand_totoal_subj > 1))
                        {
                            echo 'disabled="disabled"';
                        }
                        
                        if ($subnum <> $iQSLCount_01)
                        {?> 
                            onchange="if (this.value!=''&&subject3<?php echo $subnum; ?>.value!='')
                            {
                                grade3<?php echo $subnum+1; ?>.disabled=false;
                                subject3<?php echo $subnum+1; ?>.disabled=false
                            }else
                            {
                                grade3<?php echo $subnum+1; ?>.disabled=true;
                                subject3<?php echo $subnum+1; ?>.disabled=true
                            }"<?php 
                        }?>>
                        <option value="" selected="selected"></option><?php
                        for ($a = 1; $a <= count($arr_sbjt_1_grd)-1; $a++)
                        {?>
                            <option value="<?php echo $arr_sbjt_1_grd[$a]['cQualGradeId']?>"<?php if ($arr_sbjt_1_grd[$a]['cQualGradeId'] == $cQualGradeId){echo " selected";}?>><?php echo $arr_sbjt_1_grd[$a]['cQualGradeCode']?></option><?php
                        }?>
                </select>
            </div>
        </div><?php
    }
}