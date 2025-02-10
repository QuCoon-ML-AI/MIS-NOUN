
<?php 
$show_fac = 'none';
$show_dept = 'none';
$show_prog = 'none';

$show_cc = 'none';
$show_sc = 'none';
$show_std = 'none';

$show_fs = 'none';

if (isset($_REQUEST['whattodo']))
{
    if ($_REQUEST['whattodo'] == '3')
    {
        $show_fac = 'block';
    }else if ($_REQUEST['whattodo'] == '4')
    {
        $show_fac = 'block';
        $show_dept = 'block';
    }else if ($_REQUEST['whattodo'] == '5')
    {
        $show_fac = 'block';
        $show_dept = 'block';
        $show_prog = 'block';
    }else if ($_REQUEST['whattodo'] == '6')
    {
        $show_fac = 'block';
        $show_dept = 'block';
        $show_prog = 'block';
        $show_cc = 'block';
    }else if ($_REQUEST['whattodo'] == '7')
    {
        $show_sc = 'block';
    }else if ($_REQUEST['whattodo'] == '7a')
    {        
        $show_fac = 'block';
        $show_dept = 'block';
        $show_prog = 'block';

        $show_cc = 'block';
        $show_sc = 'block';
        $show_fs = 'block';
    }
}?>



<div class="innercont_stff" style="width:80%; margin-top:5px; display:<?php echo $show_std;?>">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="mat_cnt" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="mat_cnt" name="mat_cnt" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
            onclick="if (this.checked)
            {                
                cust_rpt.dist_point.value = cust_rpt.dist_point.value+this.value;
            }else
            {
                cust_rpt.dist_point.value =  cust_rpt.dist_point.value.replace(this.value, '');
            }" value="m"/>
                Matriculation number
        </label>
    </div>
    <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
</div>

<div class="innercont_stff" style="width:80%; margin-top:5px; display:<?php echo $show_std;?>">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="name_cnt" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="name_cnt" name="name_cnt" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
            onclick="if (this.checked)
            {                
                cust_rpt.dist_point.value = cust_rpt.dist_point.value+this.value;
            }else
            {                
                cust_rpt.dist_point.value =  cust_rpt.dist_point.value.replace(this.value, '');
            }" value="n"/>
                Name
        </label>
    </div>
</div>

<div class="innercont_stff" style="width:80%; margin-top:5px; display:<?php echo $show_std;?>">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="gender_cnt" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="gender_cnt" name="gender_cnt" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
            onclick="if (this.checked)
            {                
                cust_rpt.dist_point.value = cust_rpt.dist_point.value+this.value;
            }else
            {                
                cust_rpt.dist_point.value =  cust_rpt.dist_point.value.replace(this.value, '');
            }" value="g"/>
                Gender
        </label>
    </div>
</div>

<div class="innercont_stff" style="width:80%; margin-top:5px; display:<?php echo $show_std;?>">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="phone_cnt" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="phone_cnt" name="phone_cnt" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
            onclick="if (this.checked)
            {                
                cust_rpt.dist_point.value = cust_rpt.dist_point.value+this.value;
            }else
            {                
                cust_rpt.dist_point.value =  cust_rpt.dist_point.value.replace(this.value, '');
            }" value="p"/>
                Phone number
        </label>
    </div>
</div>

<div class="innercont_stff" style="width:80%; margin-top:5px; display:<?php echo $show_std;?>">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="mail_cnt" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="mail_cnt" name="mail_cnt" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
            onclick="if (this.checked)
            {                
                cust_rpt.dist_point.value = cust_rpt.dist_point.value+this.value;
            }else
            {                
                cust_rpt.dist_point.value =  cust_rpt.dist_point.value.replace(this.value, '');
            }" value="e"/>
                eMail
        </label>
    </div>
</div>

<div class="innercont_stff" style="width:80%; margin-top:5px; display:<?php echo $show_std;?>">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="prg_cnt" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="prg_cnt" name="prg_cnt" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
            onclick="if (this.checked)
            {                
                cust_rpt.dist_point.value = cust_rpt.dist_point.value+this.value;
            }else
            {                
                cust_rpt.dist_point.value =  cust_rpt.dist_point.value.replace(this.value, '');
            }" value="r"/>
                Programme
        </label>
    </div>
</div>


<div id="cFacultyIdold_div" class="innercont_stff" style="margin-top:10px; display:<?php echo $show_fac;?>">
    <label for="cFacultyIdold" class="labell_structure">Faculty</label>
    <div class="div_select">
        <select name="cFacultyIdold" id="cFacultyIdold" class="select" 
            onchange="//if(cust_rpt.userInfo_f.value==this.value || _('sRoleID').value==6)
            //{
                _('labell_msg2').style.display='none';
                        
                _('cdeptold').length = 0;
                _('cdeptold').options[_('cdeptold').options.length] = new Option('', '');
                        
                _('cprogrammeIdold').length = 0;
                _('cprogrammeIdold').options[_('cprogrammeIdold').options.length] = new Option('', '');
                        
                _('ccourseIdold').length = 0;
                _('ccourseIdold').options[_('ccourseIdold').options.length] = new Option('', '');
                update_cat_country_loc('cFacultyIdold', 'cdeptId_readup', 'cdeptold', 'cprogrammeIdold');
            /*}else
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

<div id="cdeptold_div" class="setup_fac_dummy_lass innercont_stff" style="display:<?php echo $show_dept;?>">
    <label for="cdeptold" class="labell_structure">Department</label>
    <div class="div_select">
        <select name="cdeptold" id="cdeptold" class="select" 
            onchange="/*if(cust_rpt.userInfo_d.value==this.value|| _('sRoleID').value==6)
            {*/
                _('labell_msg3').style.display='none';

                _('cprogrammeIdold').length = 0;
                _('cprogrammeIdold').options[_('cprogrammeIdold').options.length] = new Option('', '');

                _('ccourseIdold').length = 0;
                _('ccourseIdold').options[_('ccourseIdold').options.length] = new Option('', '');

                update_cat_country_loc('cdeptold', 'cprogrammeId_readup', 'cprogrammeIdold', 'ccourseIdold');
            /*}else //if (_('what_to_do').value!=4&&_('sRoleID').value!=6)
            {
                setMsgBox('labell_msg3','You can only work in your own department');
                this.value='';
                this.focus();
            }*/
            cust_rpt.dept_disc.value=this.options[this.selectedIndex].text;">
            <option value="" selected="selected"></option><?php
            if (isset($_REQUEST['cFacultyIdold']) && $_REQUEST['cFacultyIdold'] <> '' && $sho3 == 'block')
            {
                $stmt = $mysqli->prepare("select cdeptId, concat(cdeptId,' ',vdeptDesc) vdeptDesc from depts where cFacultyId = ? order by vdeptDesc");
                $stmt->bind_param("s", $_REQUEST['cFacultyIdold']);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($cdeptId1, $vdeptDesc1);
                
                while ($stmt->fetch())
                {?>
                    <option value="<?php echo $cdeptId1; ?>"<?php if (isset($_REQUEST['cdeptold']) && $cdeptId1 == $_REQUEST['cdeptold']){echo ' selected';}?>>
                        <?php echo $vdeptDesc1;?>
                    </option><?php
                }
                $stmt->close();
            }?>
        </select>
    </div>
    <div id="labell_msg3" class="labell_msg blink_text orange_msg"></div>
</div>

<div id="cprogrammeIdold_div" class="setup_fac_dummy_lass innercont_stff" style="display:<?php echo $show_prog;?>">
    <label for="cprogrammeIdold" class="labell_structure">Programme</label>
    <div class="div_select">
    <select name="cprogrammeIdold" id="cprogrammeIdold" class="select" 
        onchange="if(this.value!='')
        {
            _('labell_msg4').style.display='none';
            update_cat_country_loc('cprogrammeIdold', 'courseId_readup', 'ccourseIdold', 'ccourseIdold');
        }
        cust_rpt.prog_disc.value=this.options[this.selectedIndex].text;">
        <option value="" selected="selected"></option><?php
        if (isset($_REQUEST['cdeptold']) && $_REQUEST['cdeptold'] <> '' && $sho3 == 'block')
        {
            while ($stmt->fetch())
            {
                $vProgrammeDesc_01 = $vProgrammeDesc;
                if (!is_bool(strpos($vProgrammeDesc,"(d)")))
                {
                    $vProgrammeDesc_01 = substr($vProgrammeDesc, 0, strlen($vProgrammeDesc)-4);
                }?>
                <option value="<?php echo $cProgrammeId?>"<?php if (isset($_REQUEST['cprogrammeIdold']) && $cProgrammeId == $_REQUEST['cprogrammeIdold']){echo ' selected';}?>><?php echo $vObtQualTitle.' '.$vProgrammeDesc_01; ?></option><?php
            }
            $stmt->close();
        }?>
    </select>
    </div>
    <div id="labell_msg4" class="labell_msg blink_text orange_msg"></div>
</div>

<div id="ccourseIdold_div" class="setup_fac_dummy_lass innercont_stff" style="height:400px; display:<?php echo $show_cc;?>">
    <label for="ccourseIdold" class="labell_structure">Course</label>
    <div id="ccourseIdold_cont" class="div_select">
    <select name="ccourseIdold[]" multiple="multiple" id="ccourseIdold" class="select" style="width:auto;"
        onchange="cust_rpt.crs_disc.value=this.options[this.selectedIndex].text;">
        <option value="" selected="selected"></option>
    </select>
    </div>
    <div id="labell_msg4"class="labell_msg blink_text orange_msg"></div>
</div>

<div class="innercont_stff" style="width:80%; margin-top:5px; display:<?php echo $show_cc;?>">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="crs_focus" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="crs_focus" name="crs_focus" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
            onclick="if (this.checked)
            {                
                cust_rpt.cFacultyIdold.disabled = true; 
                cust_rpt.cdeptold.disabled = true; 
                cust_rpt.cprogrammeIdold.disabled = true;
            }else
            {                
                cust_rpt.cFacultyIdold.disabled = false; 
                cust_rpt.cdeptold.disabled = false; 
                cust_rpt.cprogrammeIdold.disabled = false;
            }"/>
                Focus on course only
        </label>
    </div>
</div>

<div id="cFacultyIdold_div" class="innercont_stff" style="margin-top:10px; display:<?php echo $show_cc;?>">
    <label for="courseLevel" class="labell_structure">Level</label>
    <div class="div_select">
        <select name="courseLevel" id="courseLevel" class="select" style="width:auto">
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

<div id="staff_study_center_div" class="innercont_stff" style="margin-top:15px; display:<?php echo $show_sc;?>"><?php
    $rs_sql = mysqli_query(link_connect_db(), "SELECT cStudyCenterId, vCityName, vStateName FROM studycenter a, ng_state b 
        WHERE a.cStateId = b.cStateId AND a.cDelFlag = 'N' ORDER BY b.vStateName, vCityName") or die(mysqli_error(link_connect_db()));?>
    <label for="staff_study_center" class="labell_structure">Study centre</label>
    <div class="div_select"style="width:400px;">
        <select name="staff_study_center" id="staff_study_center" class="select" style="padding:10px"
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
    <div id="labell_msg7" class="labell_msg blink_text orange_msg"></div>
</div>

<div class="innercont_stff" style="width:80%; margin-top:5px; display:<?php echo $show_fs;?>">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="frs_students" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="frs_students" name="frs_students" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"/>
                Fresh students only
        </label>
    </div>
</div>