<div id="inmate_div" class="innercont_stff" style="width:80%; margin-top:5px;">
    <label class="labell_structure">Count students by</label>
</div>

<div id="inmate_div" class="innercont_stff" style="width:80%; margin-top:5px;">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="centre_cnt" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="centre_cnt" name="centre_cnt" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
            onclick="if (this.checked)
            {                
                cust_rpt.dist_point.value = cust_rpt.dist_point.value+this.value;
            }else
            {                
                cust_rpt.dist_point.value =  cust_rpt.dist_point.value.replace(this.value, '');
            }" value="s"/>
                Study centre
        </label>
    </div>
    <div id="labell_msg0" class="labell_msg blink_text orange_msg"></div>
</div>

<div id="inmate_div" class="innercont_stff" style="width:80%; margin-top:5px;">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="faculty_cnt" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="faculty_cnt" name="faculty_cnt" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
            onclick="if (this.checked)
            {                
                cust_rpt.dist_point.value = cust_rpt.dist_point.value+this.value;
            }else
            {                
                cust_rpt.dist_point.value =  cust_rpt.dist_point.value.replace(this.value, '');
            }" value="f"/>
                Faculty
        </label>
    </div>
    <div id="labell_msg2" class="labell_msg blink_text orange_msg"></div>
</div>

<div id="inmate_div" class="innercont_stff" style="width:80%; margin-top:5px;">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="dept_cnt" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="dept_cnt" name="dept_cnt" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
            onclick="if (this.checked)
            {                
                cust_rpt.dist_point.value = cust_rpt.dist_point.value+this.value;
            }else
            {                
                cust_rpt.dist_point.value =  cust_rpt.dist_point.value.replace(this.value, '');
            }" value="d"/>
                Department
        </label>
    </div>
    <div id="labell_msg3" class="labell_msg blink_text orange_msg"></div>
</div>

<div id="inmate_div" class="innercont_stff" style="width:80%; margin-top:5px;">
    <label class="labell_structure"></label>
    <div class="div_select" style="width:auto;">
        <label for="prog_cnt" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="prog_cnt" name="prog_cnt" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
            onclick="if (this.checked)
            {                
                cust_rpt.dist_point.value = cust_rpt.dist_point.value+this.value;
            }else
            {                
                cust_rpt.dist_point.value =  cust_rpt.dist_point.value.replace(this.value, '');
            }" value="p"/>
                Programme <font style="color:#FF3300">(Report may not present like others)</font>
        </label>
    </div>
    <div id="labell_msg4" class="labell_msg blink_text orange_msg"></div>
</div>

<div id="inmate_div" class="innercont_stff" style="width:80%; margin-top:5px;">
    <label class="labell_structure"></label>
    <div class="div_select">
        <label for="level_cnt" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="level_cnt" name="level_cnt" type="checkbox" style="margin-top:4px; margin-left:0px; cursor:pointer"
            onclick="if (this.checked)
            {                
                cust_rpt.dist_point.value = cust_rpt.dist_point.value+this.value;
            }else
            {                
                cust_rpt.dist_point.value =  cust_rpt.dist_point.value.replace(this.value, '');
            }" value="l"/>
                Level
        </label>
    </div>
    <div id="labell_msg5" class="labell_msg blink_text orange_msg"></div>
</div>

<div id="inmate_div" class="innercont_stff" style="width:80%; margin-top:5px;">
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
    <div id="labell_msg6" class="labell_msg blink_text orange_msg"></div>
</div>


<div id="inmate_div" class="innercont_stff" style="width:80%; margin-top:5px;">
    <label class="labell_structure">for</label>
</div>

<div id="staff_study_center_div" class="innercont_stff" style="margin-top:15px;"><?php
    $rs_sql = mysqli_query(link_connect_db(), "SELECT cStudyCenterId, vCityName, vStateName FROM studycenter a, ng_state b 
        WHERE a.cStateId = b.cStateId AND a.cDelFlag = 'N' ORDER BY b.vStateName, vCityName") or die(mysqli_error(link_connect_db()));?>
    <label class="labell_structure">Registration point</label>
    <div class="div_select"style="width:auto;">
        <label for="reg_point1" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="reg_point1" name="reg_point" type="radio" style="margin-top:4px; margin-left:0px; cursor:pointer" checked value="s" onclick="cust_rpt.reg_point_disc.value='Registered for the semester'"/>
                Fresh students
        </label>
    </div>
    <div class="div_select"style="width:auto; margin-left:10px">
        <label for="reg_point2" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="reg_point2" name="reg_point" type="radio" style="margin-top:4px; margin-left:0px; cursor:pointer" value="c" onclick="cust_rpt.reg_point_disc.value='Registered courses'"/>
                Registered courses
        </label>
    </div>
    <div class="div_select"style="width:auto; margin-left:10px">
        <label for="reg_point3" class="labell" style="width:auto; text-align:left; cursor:pointer;">
            <input id="reg_point3" name="reg_point" type="radio" style="margin-top:4px; margin-left:0px; cursor:pointer" value="e" onclick="cust_rpt.reg_point_disc.value='Registered exam'"/>
                Registered exam
        </label>
    </div>
    <a href="#" style="text-decoration:none;" 
        onclick="_('reg_point1').checked = false;
        _('reg_point2').checked = false;
        _('reg_point3').checked = false;">
        <div class="submit_button_brown" style="width:60px; margin:auto; padding:4px; margin-left:3px; font-size:10px; float:left">
            Clear
        </div>
    </a>
    <div id="labell_msg8" class="labell_msg blink_text orange_msg"></div>
</div>



<div id="staff_study_center_div" class="innercont_stff" style="margin-top:15px;"><?php
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
                <option value="<?php echo $rs['cStudyCenterId'];?>"><?php echo $rs['vStateName'].' '.$rs['vCityName'];?></option><?php
            }
            mysqli_close(link_connect_db());?>
        </select>
    </div>
    <div id="labell_msg7" class="labell_msg blink_text orange_msg"></div>
</div>

<div id="cFacultyIdold_div" class="innercont_stff" style="margin-top:10px;">
    <label for="cFacultyIdold" class="labell_structure">Faculty</label>
    <div class="div_select">
        <select name="cFacultyIdold" id="cFacultyIdold" class="select" 
            onchange="/*if(cust_rpt.userInfo_f.value==this.value || _('sRoleID').value==6 || _('sRoleID').value==36)
            {*/
                _('labell_msg2').style.display='none';
                        
                _('cdeptold').length = 0;
                _('cdeptold').options[_('cdeptold').options.length] = new Option('', '');
                        
                _('cprogrammeIdold').length = 0;
                _('cprogrammeIdold').options[_('cprogrammeIdold').options.length] = new Option('', '');
                        
                //_('ccourseIdold').length = 0;
                //_('ccourseIdold').options[_('ccourseIdold').options.length] = new Option('', '');
                update_cat_country_loc('cFacultyIdold', 'cdeptId_readup', 'cdeptold', 'cprogrammeIdold');
            /*}else if (_('what_to_do').value!=4 && _('sRoleID').value!=6 && _('sRoleID').value!=36)
            {
                setMsgBox('labell_msg2','You can only work in your own faculty');
                this.value='';
                this.focus();
            }*/
            cust_rpt.faculty_disc.value=this.options[this.selectedIndex].text;">
            <option value="" selected="selected"></option><?php
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

<div id="cdeptold_div" class="setup_fac_dummy_lass innercont_stff">
    <label for="cdeptold" class="labell_structure">Department</label>
    <div class="div_select">
        <select name="cdeptold" id="cdeptold" class="select" 
            onchange="/*if(cust_rpt.userInfo_d.value==this.value|| _('sRoleID').value==6 || _('sRoleID').value==36)
            {*/
                _('cprogrammeIdold').length = 0;
                _('cprogrammeIdold').options[_('cprogrammeIdold').options.length] = new Option('', '');

                //_('ccourseIdold').length = 0;
                //_('ccourseIdold').options[_('ccourseIdold').options.length] = new Option('', '');

                update_cat_country_loc('cdeptold', 'cprogrammeId_readup', 'cprogrammeIdold', 'ccourseIdold');
            /*}else if (_('what_to_do').value!=4&&_('sRoleID').value!=6 && _('sRoleID').value!=36)
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

<div id="cprogrammeIdold_div" class="setup_fac_dummy_lass innercont_stff">
    <label for="cprogrammeIdold" class="labell_structure">Programme</label>
    <div class="div_select">
    <select name="cprogrammeIdold" id="cprogrammeIdold" class="select" 
        onchange="
        cust_rpt.prog_disc.value=this.options[this.selectedIndex].text;
        if(this.value!='')
        {
            update_cat_country_loc('cprogrammeIdold', 'courseId_readup', 'ccourseIdold', 'ccourseIdold');
        }">
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

<div id="cFacultyIdold_div" class="setup_fac_dummy_lass innercont_stff">
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