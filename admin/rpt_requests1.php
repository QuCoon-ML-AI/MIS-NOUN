
<div id="staff_study_center_div" class="innercont_stff" style="margin-top:15px; height:auto;"><?php
    $rs_sql = mysqli_query(link_connect_db(), "SELECT cStudyCenterId, vCityName, vStateName FROM studycenter a, ng_state b 
        WHERE a.cStateId = b.cStateId AND a.cDelFlag = 'N' ORDER BY b.vStateName, vCityName") or die(mysqli_error(link_connect_db()));?>
    <label for="study_center" class="labell_structure">Study centre</label>
    <div class="div_select"style="width:400px;">
        <select name="study_center" id="study_center" size="20" class="select" style="padding:10px"
            onchange="cust_rpt.study_center_disc.value=this.options[this.selectedIndex].text;">
            <option value="" selected></option><?php                                    
            $study_mode_loc = '';
            $c = 0;
            while ($rs = mysqli_fetch_array($rs_sql))
            {
                $c++;
                if ($c%5==0)
                {?>
                    <option disabled></option><?php
                }?>
                <option value="<?php echo $rs['cStudyCenterId'];?>"><?php echo $rs['vStateName'].' '.$rs['vCityName'];?></option><?php
            }
            mysqli_close(link_connect_db());?>
        </select>
    </div>
    <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
</div>

<div id="cFacultyIdold_div" class="innercont_stff" style="margin-top:10px;">
    <label for="exam_type" class="labell_structure">Type of exam</label>
    <div class="div_select">
        <select name="exam_type" id="exam_type" class="select" style="width:auto">
            <option value="" selected="selected"></option>
            <option value="1">POP</option>
            <option value="2">eExam</option>
        </select>
    </div>
    <div id="labell_msg1" class="labell_msg blink_text orange_msg"></div>
</div>