<?php
$show_sc = 'none';
$show_date = 'none';
$show_fac = 'none';
$show_prog = 'none';
$show_level = 'none';
$show_prog_cat = 'none';

$exam_type = 'none';

$show_debit = 'none';
$show_bank = 'none';
$show_crslp = 'none';

$show_debit_smry1 = 'none';
$show_debit_smry2 = 'none';

$show_chd_opt = 'none';

if (isset($_REQUEST['whattodo']))
{
    if ($_REQUEST['whattodo'] == '8')
    {        
        $show_date = 'block';
        $show_fac = 'block';
        $show_level = 'block';
        $show_prog = 'block';
    }else if ($_REQUEST['whattodo'] == '8a')
    {        
        $show_date = 'block';
        $show_fac = 'block';
        $show_level = 'block';
        $show_prog = 'block';
        $exam_type = 'block';
    }else if ($_REQUEST['whattodo'] == '9' || $_REQUEST['whattodo'] == '9a' || $_REQUEST['whattodo'] == '11')
    {
        $show_level = 'block';
        $show_fac = 'block';
        $show_prog_cat = 'block';

        if ($_REQUEST['whattodo'] == '9a')
        {
            $show_sc = 'block';
            $show_crslp = 'block';
        }

        if ($_REQUEST['whattodo'] == '9')
        {
            $show_date = 'block';
        }
    }else if ($_REQUEST['whattodo'] == '12a' || $_REQUEST['whattodo'] == '12')
    {        
        $show_level = 'block';
        $show_fac = 'block';

        if ($_REQUEST['whattodo'] == '12')
        {        
            $show_date = 'block';
        }
    }else if ($_REQUEST['whattodo'] == '13' || $_REQUEST['whattodo'] == '14')
    {   
        $show_date = 'block';
        $show_prog_cat = 'block';

        if ($_REQUEST['whattodo'] == '14')
        {   
            $show_debit = 'block';
            $show_debit_smry1 = 'block';
            $show_debit_smry2 = 'block';
        }
    }else if ($_REQUEST['whattodo'] == '15')
    {
        $show_sc = 'block';
        $show_date = 'block';
        $show_fac = 'block';
        $show_prog = 'block';
        $show_prog_cat = 'block';
        $show_bank = 'block';
    }else if ($_REQUEST['whattodo'] == '16')
    {
        $show_chd_opt = 'block';
    }
}?>


<div id="cFacultyIdold_div" class="innercont_stff" style="margin-top:10px; display:<?php echo $exam_type;?>">
    <label for="exam_type" class="labell_structure">Exam type</label>
    <div class="div_select">
        <select name="exam_type" id="exam_type" class="select" 
            onchange="cust_rpt.exam_type_disc.value=this.options[this.selectedIndex].text;">
            <option value="" selected="selected"></option>
            <option value="('1','2')">e-Exam</option>
            <option value="('3','4','5','7','8')">POP Exam</option>
        </select>
    </div>
    <div id="labell_msg6" class="labell_msg blink_text orange_msg"></div>
</div>

<div id="staff_study_center_div" class="innercont_stff" style="margin-top:15px; display:<?php echo $show_sc;?>"><?php
    $rs_sql = mysqli_query(link_connect_db(), "SELECT cStudyCenterId, vCityName, vStateName FROM studycenter a, ng_state b 
        WHERE a.cStateId = b.cStateId AND a.cDelFlag = 'N' ORDER BY b.vStateName, vCityName") or die(mysqli_error(link_connect_db()));?>
    <label for="staff_study_center" class="labell_structure">Study centre</label>
    <div class="div_select"style="width:400px;">
        <select name="staff_study_center" id="staff_study_center" class="select"
            onchange="cust_rpt.centre_disc.value=this.options[this.selectedIndex].text;">
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
                <option value="<?php echo $rs['cStudyCenterId'];?>"><?php echo $c.' '.$rs['vStateName'].' '.$rs['vCityName'];?></option><?php
            }
            mysqli_close(link_connect_db());?>
        </select>
    </div>
    <div id="labell_msg7" class="labell_msg blink_text orange_msg" atyle="width:auto"></div>
</div>

<div id="staff_study_center_div" class="innercont_stff" style="margin-top:15px; display:<?php echo $show_date;?>">
    <label for="staff_study_center" class="labell_structure">From</label>
    <div class="div_select"style="width:400px;">
        <input type="date" name="date_1" id="date_1" class="textbox" style="height:99%;" 
        onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
    </div>
    <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
</div>

<div id="staff_study_center_div" class="innercont_stff" style="margin-top:10px; display:<?php echo $show_date;?>">
    <label for="staff_study_center" class="labell_structure">To</label>
    <div class="div_select"style="width:400px;">
        <input type="date" name="date_2" id="date_2" class="textbox" style="height:99%;" 
        onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
    </div>
    <div id="labell_msg1" class="labell_msg blink_text orange_msg"></div>
</div>

<div id="cFacultyIdold_div" class="innercont_stff" style="margin-top:20px; display:<?php echo $show_fac;?>">
    <label for="cFacultyIdold" class="labell_structure">Faculty</label>
    <div class="div_select">
        <select name="cFacultyIdold" id="cFacultyIdold" class="select" 
            onchange="/*if(cust_rpt.userInfo_f.value==this.value || _('sRoleID').value==6)
            {*/
                _('labell_msg2').style.display='none';
            /*}else //if (_('what_to_do').value!=4 && _('sRoleID').value!=6)
            {
                setMsgBox('labell_msg2','You can only work in your own faculty');
                this.value='';
                this.focus();
            }*/
            cust_rpt.faculty_disc.value=this.options[this.selectedIndex].text;">
            <option value="" selected="selected">Select a faculty</option><?php
                $sql1 = "SELECT cFacultyId, concat(cFacultyId,' ',vFacultyDesc) vFacultyDesc FROM faculty WHERE cCat = 'A' AND cDelFlag = 'N' ORDER BY vFacultyDesc";
                $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));
                while ($table= mysqli_fetch_array($rsql1))
                {?>
                    <option value="<?php echo $table[0] ?>"<?php 
                    if ($sRoleID_u <> '6' && $table[0] == $cFacultyId_u)
                    {
                        echo ' selected';
                    }else if ((isset($_REQUEST['cFacultyIdNew_abrv']) && $table[0] == strtoupper($_REQUEST['cFacultyIdNew_abrv'])) || 
                    (isset($_REQUEST['cFacultyIdold']) && $table[0] == $_REQUEST['cFacultyIdold'])){echo ' selected';}?>>
                        <?php echo $table[1];?>
                    </option><?php
                }
                mysqli_close(link_connect_db());?>
        </select>
    </div>
    <div id="labell_msg2" class="labell_msg blink_text orange_msg"></div>
</div>


<div id="cFacultyIdold_div" class="innercont_stff" style="margin-top:10px; display:<?php echo $show_prog_cat;?>">
    <label for="cFacultyIdold" class="labell_structure">Programme category</label>
    <div class="div_select"><?php
        $stmt = $mysqli->prepare("SELECT distinct cEduCtgId, vEduCtgDesc, iEduCtgRank 
        FROM educationctg WHERE cEduCtgId IN ('ELX','ELZ','PGX','PGY','PGZ','PRX','PSZ') ORDER BY iEduCtgRank");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cEduCtgId_02, $vEduCtgDesc_02, $iEduCtgRank_02);									
        $prev_iEduCtgRank = '';?>

        <select name="prog_cat_loc" id="prog_cat_loc" class="select" 
            onchange="cust_rpt.prog_cat_disc.value=this.options[this.selectedIndex].text;">
            <option value="" selected>Select category</option><?php
            while ($stmt->fetch())
            {
                if ($prev_iEduCtgRank <> $iEduCtgRank_02)
                {?>
                    <option disabled></option><?php
                }?>
                <option value="<?php echo $cEduCtgId_02?>" <?php if (isset($_REQUEST['cEduCtgId_loc_0']) && $_REQUEST['cEduCtgId_loc_0'] == $cEduCtgId_02){echo ' selected';}?>>
                    <?php echo $vEduCtgDesc_02;?>
                </option><?php
                $prev_iEduCtgRank = $iEduCtgRank_02;
            }
            $stmt->close();?>
        </select>
    </div>
    <div id="labell_msg3" class="labell_msg blink_text orange_msg"></div>
</div>


<div id="cFacultyIdold_div" class="innercont_stff" style="margin-top:10px; display:<?php echo $show_level;?>">
    <label for="courseLevel" class="labell_structure">Level</label>
    <div class="div_select">
        <select name="courseLevel" id="courseLevel" class="select">
            <option value="" selected="selected"></option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="40">40</option><?php
            for ($t = 100; $t <= 1000; $t+=100)
            {?>
                <option value="<?php echo $t ?>"><?php echo $t;?></option><?php
            }?>
        </select>
    </div>
    <div id="labell_msg4" class="labell_msg blink_text orange_msg"></div>
</div>

<div id="cFacultyIdold_div" class="innercont_stff" style="margin-top:10px; display:<?php echo $show_debit;?>">
    <label for="debitype" class="labell_structure">Debit type</label>
    <div class="div_select">
        <select name="debitype" id="debitype" class="select" 
            onchange="cust_rpt.debitype_disc.value=this.options[this.selectedIndex].text;">
            <option value="" selected="selected"></option><?php
            $sql = "SELECT fee_item_id, fee_item_desc FROM fee_items WHERE cdel = 'N' ORDER BY fee_item_desc";
            $rssql = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
            while ($rs = mysqli_fetch_array($rssql))
            {?>
                <option value="<?php echo $rs['fee_item_id'];?>"><?php echo ucwords(strtolower($rs['fee_item_desc']));?></option><?php
            }?>
        </select>
    </div>
    <div id="labell_msg5" class="labell_msg blink_text orange_msg"></div>
</div>



<div id="staff_study_center_div" class="innercont_stff" style="margin-top:15px; display:<?php echo $show_bank;?>"><?php
    $rs_sql = mysqli_query(link_connect_db(), "SELECT ccode, vDesc FROM banks ORDER BY vDesc") or die(mysqli_error(link_connect_db()));?>
    <label for="staff_study_center" class="labell_structure">Bank</label>
    <div class="div_select"style="width:400px;">
        <select name="bank_loc" id="bank_loc" class="select"
            onchange="cust_rpt.bank_disc.value=this.options[this.selectedIndex].text;">
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
                <option value="<?php echo $rs['ccode'];?>"><?php echo $rs['vDesc'];?></option><?php
            }
            mysqli_close(link_connect_db());?>
        </select>
    </div>
    <div id="labell_msg8" class="labell_msg blink_text orange_msg" atyle="width:auto"></div>
</div>


<div class="innercont_stff" style="width:80%; margin-top:5px; display:<?php echo $show_crslp;?>">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="crs_reg_slip" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="crs_reg_slip" name="crs_reg_slip" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"/>
                Course registration slip
        </label>
    </div>
</div>


<div class="innercont_stff" style="width:80%; margin-top:5px; display:<?php echo $show_debit_smry1;?>">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="debit_smry1" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="debit_smry1" name="debit_smry1" type="checkbox" onclick="if(this.checked){_('debit_smry2').checked=false}" style="margin-top:4px; margin-left:0px; cursor:pointer"/>
                Summary of wallet debits
        </label>
    </div>
</div>

<div class="innercont_stff" style="width:80%; margin-top:5px; display:<?php echo $show_debit_smry2;?>">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="debit_smry2" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="debit_smry2" name="debit_smry2" type="checkbox" onclick="if(this.checked){_('debit_smry1').checked=false}" style="margin-top:4px; margin-left:0px; cursor:pointer"/>
                Payment distribution by items
        </label>
    </div>
</div>



<div class="innercont_stff" style="width:80%; margin-top:5px; display:<?php echo $show_chd_opt;?>">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="show_chd_opt1" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="show_chd_opt1" name="show_chd_opt" type="radio" style="margin-top:4px; margin-left:0px; cursor:pointer" onclick="show_chd_opt_h.value=1"/>
                Application record
        </label>
    </div>
    <div id="labell_msg9" class="labell_msg blink_text orange_msg" atyle="width:auto"></div>
</div>

<div class="innercont_stff" style="width:80%; margin-top:5px; display:<?php echo $show_chd_opt;?>">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="show_chd_opt2" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="show_chd_opt2" name="show_chd_opt" type="radio" style="margin-top:4px; margin-left:0px; cursor:pointer" onclick="show_chd_opt_h.value=2"/>
                Student record
        </label>
    </div>
    <input name="show_chd_opt_h" id="show_chd_opt_h" type="hidden" />
</div>