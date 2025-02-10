<?php

$child_qry = " AND a.cProgrammeId LIKE '%".$_REQUEST['cprogrammeIdold']."%' ";
$begin_level = 100;

$sReqmtId_qry = '';

$cEduCtgId_2_qry = "cEduCtgId_2";
$ordering = "ORDER BY cEduCtgId_1, $cEduCtgId_2_qry, b.cMandate, c.vQualSubjectDesc";

$aa = get_qry_part('0', $_REQUEST['cFacultyIdold07'], $_REQUEST['cdeptold'], $_REQUEST['cprogrammeIdold'], $_REQUEST['courseLevel_old']);
if ($aa <> '')
{
    $sReqmtId_qry = $aa;
}

$bb = get_qry_part('1', $_REQUEST['cFacultyIdold07'], $_REQUEST['cdeptold'], $_REQUEST['cprogrammeIdold'], $_REQUEST['courseLevel_old']);
if ($bb <> '')
{
    $child_qry = $bb;
}

$cc =  get_qry_part('2', $_REQUEST['cFacultyIdold07'], $_REQUEST['cdeptold'], $_REQUEST['cprogrammeIdold'], $_REQUEST['courseLevel_old']);
if ($cc <> '')
{
    $begin_level = $cc;
}

//echo "$child_qry AND ((a.iBeginLevel = $begin_level $sReqmtId_qry) OR a.iBeginLevel = ".$_REQUEST['courseLevel_old'].")";

/*echo "SELECT cEduCtgId_1, $cEduCtgId_2_qry, c.vQualSubjectDesc, b.cMandate, b.mutual_ex, d.cQualGradeCode
FROM criteriadetail a, criteriasubject b, qualsubject c, qualgrade d
WHERE a.cCriteriaId = b.cCriteriaId
AND a.cProgrammeId = b.cProgrammeId
AND a.sReqmtId = b.sReqmtId
AND b.cQualSubjectId = c.cQualSubjectId
AND b.cQualGradeId = d.cQualGradeId
AND a.cCriteriaId = '".$_REQUEST['cFacultyIdold07']."'
AND a.cDelFlag = 'N'
AND b.cDelFlag = 'N'
$child_qry
AND ((a.iBeginLevel = $begin_level 
$sReqmtId_qry)
OR a.iBeginLevel = ".$_REQUEST['courseLevel_old'].")
$ordering";*/

$stmt = $mysqli->prepare("SELECT cEduCtgId_1, $cEduCtgId_2_qry, c.vQualSubjectDesc, b.cMandate, b.mutual_ex, d.cQualGradeCode
FROM criteriadetail a, criteriasubject b, qualsubject c, qualgrade d
WHERE a.cCriteriaId = b.cCriteriaId
AND a.cProgrammeId = b.cProgrammeId
AND a.sReqmtId = b.sReqmtId
AND b.cQualSubjectId = c.cQualSubjectId
AND b.cQualGradeId = d.cQualGradeId
AND a.cCriteriaId = ?
AND a.cDelFlag = 'N'
AND b.cDelFlag = 'N'
$child_qry
AND ((a.iBeginLevel = $begin_level 
$sReqmtId_qry)
OR a.iBeginLevel = ?)
$ordering");
$stmt->bind_param("si",  $_REQUEST['cFacultyIdold07'],  $_REQUEST['courseLevel_old']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($cEduCtgId_1, $cEduCtgId_2, $vQualSubjectDesc, $cMandate, $mutual_ex, $cQualGradeCode);
$numOfcrthd = $stmt->num_rows;

if ($numOfcrthd == 0)
{?>
    <script language="JavaScript" type="text/javascript">
        caution_inform("Please modify your options and try again");			
    </script><?php
}else
{
    if ((($_REQUEST['cprogrammeIdold'] == "MSC204" || $_REQUEST['cprogrammeIdold'] == "MSC205") && $_REQUEST['courseLevel_old'] == 100) || ($_REQUEST["courseLevel_old"] > 100 && $_REQUEST['cprogrammeIdold'] <> 'HSC201'))
    {?>
        <script language="JavaScript" type="text/javascript"><?php
            if ($_REQUEST['cprogrammeIdold'] == 'HSC202' || $_REQUEST['cprogrammeIdold'] == 'HSC204' || $_REQUEST['cprogrammeIdold'] == 'HSC205')
            {?>
                caution_inform("You must:<br> (1) meet the requiremnts for O'level qualification<br> (2) have Registered Nurse Certificate of Nursing and Midwifery Council of Nigeria (NMCN)<br>(3) have a valid practice license issued by Nursing and Midwifery Council of Nigeria<br>(4) have at least, six month working experience and letter of attestation from current place of clinical practice");<?php
            }ELSE if ($_REQUEST['cprogrammeIdold'] == 'HSC203')
            {?>
                caution_inform("You must meet the requiremnts for O'level in addition to being a certified Public Health Officer");<?php
            }else
            {?>
                caution_inform("You must meet the requiremnts for O'level and anyone of the listed higher qualifications to qualifiy for this programme at the selected level");<?php
            }?>
        </script><?php
    }
    
    $prev_cEduCtgId_2 = '';
    $cnt = 0;
    $cnt_1 = 1;?>
    
    <div class="appl_left_child_div" style="text-align: left; margin:auto; margin-top:5px; width:99.8%; overflow:auto; background-color: #eff5f0;">
        <div class="appl_left_child_div_child" style="font-weight: bold;">
            <div style="flex:5%; padding-right:4px; height:50px; text-align:right; background-color: #ffffff">
                Sn
            </div>
            <div style="flex:65%; padding-left:4px; height:50px; background-color: #ffffff">
                <label for="cprogrammeIdold">Subject</label>
            </div>
            <div style="flex:15%; padding-left:4px; height:50px; background-color: #ffffff">
                Mandate
            </div>
            <div style="flex:15%; padding-left:4px; height:50px; background-color: #ffffff">
                Minimum grade   
            </div>
        </div><?php
        while($stmt->fetch())		
        {
            if (($_REQUEST['cprogrammeIdold'] == "MSC203" || $_REQUEST['cprogrammeIdold'] == "MSC206") && $_REQUEST['courseLevel_old'] == 200 && $cMandate == "E" && ($cEduCtgId_2 == '' || $cEduCtgId_2 == 'OL'))
            {
                continue;
            }
            
            if (($vQualSubjectDesc == 'Economics' || $vQualSubjectDesc == 'Commerce' || $vQualSubjectDesc == 'Government' || $vQualSubjectDesc == 'History') && (($_REQUEST['cdeptold'] == 'PAD' || $_REQUEST['cdeptold'] == 'BUS') && $_REQUEST['courseLevel_old'] >= 700) && ($cEduCtgId_2 == '' || $cEduCtgId_2 == 'OL') && $_REQUEST['cprogrammeIdold'] <> "MSC402")
            {
                continue;
            }

            if ($_REQUEST['cprogrammeIdold'] == "HSC203" && $_REQUEST['courseLevel_old'] == 300)
            {
                if ($vQualSubjectDesc == 'Community Health Extension' || !($cEduCtgId_1 == 'OL' && ($cEduCtgId_2 == '' || $cEduCtgId_2 == 'PSX')))
                {
                    continue;
                }
            }
            
            if ($_REQUEST['cprogrammeIdold'] == "HSC401" && $cEduCtgId_2 == 'PSZ' && $cQualGradeCode == '3C')
            {
                continue;
            }
            
                                
            if (($prev_cEduCtgId_2 == '' && $cnt == 0) || $prev_cEduCtgId_2 <> $cEduCtgId_2)
            {?>            
                <div class="appl_left_child_div_child">
                    <div style="flex:100%; padding-right:4px; height:50px; text-align:left; background-color: #f4f4f4"><?php
                    if ($cEduCtgId_2 == '' || $cEduCtgId_2 == 'OL')
                    {
                        if (($_REQUEST['cprogrammeIdold'] == "MSC203" || $_REQUEST['cprogrammeIdold'] == "MSC206") && $_REQUEST['courseLevel_old'] == 200 && ($cEduCtgId_2 == '' || $cEduCtgId_2 == 'OL'))
                        {
                            echo "O'level subjects. Minimum number of subjects: 3. Maximum number of sittings: 2";
                        }else
                        {
                            echo "O'level subjects. Minimum number of subjects: 5. Maximum number of sittings: 2";
                        }
                    }else if ($cEduCtgId_2 == 'ALW')
                    {
                        echo 'AL NABTEB subjects. Minimum number of subjects: 2. Maximum number of sittings: 1';
                    }else if ($cEduCtgId_2 == 'ALX')
                    {
                        echo 'AL IJMB subjects. Minimum number of subjects: 2. Maximum number of sittings: 1';
                    }else if ($cEduCtgId_2 == 'ALZ')
                    {
                        echo 'NCE AL subjects. Minimum number of subjects: 2. Maximum number of sittings: 1';
                    }else if ($cEduCtgId_2 == 'ELZ')
                    {
                        echo 'OND field/discipline. Minimum number of subjects: 1. Maximum number of sittings: 1';
                    }else if (($cEduCtgId_2 == 'PSZ' || $cEduCtgId_2 == 'PSX') && $_REQUEST['courseLevel_old']  == 800 &&  ($_REQUEST['cprogrammeIdold'] == 'MSC403' || $_REQUEST['cprogrammeIdold'] == 'MSC401' || $_REQUEST['cprogrammeIdold'] == 'MSC408' || $_REQUEST['cprogrammeIdold'] == 'MSC409' || $_REQUEST['cprogrammeIdold'] == 'MSC410' || $_REQUEST['cprogrammeIdold'] == 'MSC411' || $_REQUEST['cprogrammeIdold'] == 'MSC412' || $_REQUEST['cprogrammeIdold'] == 'MSC413'))
                    {
                        echo 'HND/First degree field/discipline. Minimum number of subjects: 1. Maximum number of sittings: 1';
                    }else if ($cEduCtgId_2 == 'PSX')
                    {
                        echo 'HND subjects. Minimum number of subjects: 1. Maximum number of sittings: 1';
                    }else if ($cEduCtgId_2 == 'PSZ')
                    {
                        echo 'First degree field/discipline. Minimum number of subjects: 1. Maximum number of sittings: 1';
                    }else if ($cEduCtgId_2 == 'PGX')
                    {
                        echo 'Post graduate diploma field/discipline. Minimum number of subjects: 1. Maximum number of sittings: 1';
                    }?>
                    </div>
                </div><?php
                $cnt = 0;
            }

            if ($cEduCtgId_2 == 'PSZ' && $begin_level == 200 && $_REQUEST['cprogrammeIdold'] == 'ART209')
            {?>
                <div class="appl_left_child_div_child">
                    <div style="flex:100%; padding-right:4px; height:50px; text-align:right; background-color: #ffffff">
                        Any field/discipline with a minimum grade of Second lower
                    </div>
                </div><?php
                break;
            }

            if (($cEduCtgId_2 == 'PSZ' || $cEduCtgId_2 == 'PSX') && $begin_level = 800 && ($_REQUEST['cprogrammeIdold'] == 'MSC403' || $_REQUEST['cprogrammeIdold'] == 'MSC401' || $_REQUEST['cprogrammeIdold'] == 'MSC408' || $_REQUEST['cprogrammeIdold'] == 'MSC409' || $_REQUEST['cprogrammeIdold'] == 'MSC410' || $_REQUEST['cprogrammeIdold'] == 'MSC411' || $_REQUEST['cprogrammeIdold'] == 'MSC412' || $_REQUEST['cprogrammeIdold'] == 'MSC413'))
            {?>
                <div class="appl_left_child_div_child">
                    <div style="flex:100%; padding-right:4px; height:50px; text-align:right; background-color: #ffffff">
                        Any field/discipline with a minimum grade of third class for first degree and upper credit for HND<p>
                        Candidate who possess HND below uppper credit will be required to have a PGD in Business Administration
                    </div>
                </div><?php
                break;
            }
            
            if ($mutual_ex == 1){$text_color='#a87903';}else if ($mutual_ex == 2){$text_color='#0656b8';}else if ($mutual_ex == 3){$text_color='#05ad42';}else{$text_color='#000000';}
            
            if ($cnt%2==0){$background_color='#dbe3dc';}else{$background_color='#FFFFFF';}?>
            
            <label class="lbl_beh">
                <div class="appl_left_child_div_child">
                    <div style="flex:5%; padding-right:4px; height:50px; text-align:right; background-color: #ffffff">
                        <?php echo ++$cnt; ?>
                    </div>
                    <div style="flex:65%; padding-left:4px; height:50px; color:<?php echo $text_color;?>; background-color: #ffffff">
                        <?php if ($mutual_ex == 1){echo '*';}else if ($mutual_ex == 2){echo '**';}else if ($mutual_ex == 32){echo '***';} 
                        echo $vQualSubjectDesc;
                        if ($mutual_ex <> 0){echo ' (This is an alternative to any other similarly marked subject)';} ?>
                    </div>
                    <div style="flex:15%; padding-left:4px; height:50px; background-color: #ffffff">
                        <?php if ($cMandate == 'C'){echo '<font color="#3aa238">Yes</font>';}else{echo '<font color="#f52e2e">No</font>';} ?>
                    </div>
                    <div style="flex:15%; padding-left:4px; height:50px; background-color: #ffffff">
                        <?php echo $cQualGradeCode; ?>
                    </div>
                </div>
            </label><?php
            $prev_cEduCtgId_2 = $cEduCtgId_2;
        }?>
        
        <div style="display:flex; 
        flex-flow: row;
        justify-content: flex-end;
        flex:100%;
        height:auto; 
        margin-top:10px;">
            <button type="button" class="login_button" style="width:20%" onclick="ps.action='pay-for-application-form';
                ps.user_cat.value='1';
                ps.submit();
                return false">Apply for admission</button>  
    </div>
    </div><?php
    
}?>