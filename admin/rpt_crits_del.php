<div class="innercont_stff" id="ans4" 
    style="display:<?php if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '4'){?>block<?php }else{?>none<?php }?>; 
    height:100%;
    width:100%;
    max-height: 587px; 
    overflow-x: hidden;">
    <div class="innercont_stff" style="margin-top:0px;">
        <label for="crit1" class="labell" style="width:190px;">Study Centre 1</label>
        <div class="div_select"><?php
            $sql = "SELECT cStudyCenterId, CONCAT(vCityName,' ',cStudyCenterId) AS centre FROM studycenter ORDER BY vCityName";
            
            $rscentres = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));?>
            <select id="crit1" name="crit1" class="select" 
                <?php if (!isset($_REQUEST['col1'])){echo ' disabled="disabled"';} ?>
                onchange="if(this.value!=''){_('crit1lab').value=this.options[this.selectedIndex].text}">
                <option value="">Select study centre </option><?php
                while ($rowoverall = mysqli_fetch_array($rscentres))
                {?>
                    <option value="<?php echo $rowoverall['cStudyCenterId'];?>"
                    <?php if (isset($_REQUEST["crit1"]) && $_REQUEST["crit1"] == $rowoverall['cStudyCenterId']){echo ' selected';}?>> <?php echo $rowoverall['centre'] ?> </option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>
        </div>
    </div>

    <div class="innercont_stff">
        <label for="crit2" class="labell" style="width:190px;">Faculty 2</label>
        <div class="div_select"><?php
            $sqlschool = "SELECT cFacultyId, vFacultyDesc AS school FROM faculty WHERE cCat = 'A' ORDER BY cFacultyId";
            $rsschool = mysqli_query(link_connect_db(), stripslashes($sqlschool)) or die(mysqli_error(link_connect_db()));?>
            <select id="crit2" name="crit2" class="select" 
                <?php if (!isset($_REQUEST['col2'])){echo ' disabled="disabled"';} ?>
                onchange="update_cat_country('crit2', 'cdeptId_readup', 'crit3', 'crit4');
                if(this.value!=''){_('crit2lab').value=this.options[this.selectedIndex].text}">
                <option value="">Select faculty </option><?php
                while ($rowschool = mysqli_fetch_array($rsschool))
                {?>
                    <option value="<?php echo $rowschool['cFacultyId'];?>"
                    <?php if (isset($_REQUEST["crit2"]) && $_REQUEST["crit2"] == $rowschool['cFacultyId']){echo ' selected';}?>><?php echo $rowschool['school'] ?></option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>
        </div>
    </div>
    
    <div class="innercont_stff">
        <label for="crit3" class="labell" style="width:190px;">Department 3</label>
        <div class="div_select"><?php
            if (isset($_REQUEST["crit2"])&&$_REQUEST["crit2"]<> '')
            {
                $stmt = $mysqli->prepare("SELECT cdeptId, vdeptDesc FROM depts where cFacultyId = ? ORDER BY vdeptDesc");
                $stmt->bind_param("s", $_REQUEST['crit2']);
                $stmt->execute();
                $result = $stmt->store_result();
                $stmt->bind_result($cdeptId, $vdeptDesc);
            }?>
            <select id="crit3" name="crit3" class="select"  
                <?php if (!isset($_REQUEST['col3'])){echo ' disabled="disabled"';} ?>
                onchange="update_cat_country('crit3', 'cprogrammeId_readup', 'crit4', 'crit4');
                if(this.value!=''){_('crit3lab').value=this.options[this.selectedIndex].text}">
                <option value="">Select department </option><?php
                if (isset($_REQUEST["crit2"])&&$_REQUEST["crit2"]<> '')
                {
                    while($stmt->fetch())
                    {?>
                        <option value="<?php echo $cdeptId;?>"
                        <?php if (isset($_REQUEST["crit3"]) && $_REQUEST["crit3"] == $cdeptId){echo ' selected';}?>><?php echo $vdeptDesc; ?></option><?php
                    }
                    $stmt->close();
                }?>
            </select>
        </div>
    </div>
    
    <div class="innercont_stff">
        <label for="crit4" class="labell" style="width:190px;">Programme 4</label>
        <div class="div_select"><?php
            if (isset($_REQUEST["crit3"])&&$_REQUEST["crit3"]<> '')
            {
                $stmt = $mysqli->prepare("SELECT cProgrammeId, vProgrammeDesc FROM programme where cdeptId = ? ORDER BY vProgrammeDesc");
                $stmt->bind_param("s", $_REQUEST['crit3']);
                $stmt->execute();
                $result = $stmt->store_result();
                $stmt->bind_result($cProgrammeId, $vProgrammeDesc);
            }?>
            <select id="crit4" name="crit4" class="select" 
                <?php if (!isset($_REQUEST['col4'])){echo ' disabled="disabled"';} ?>
                onchange="if(this.value!=''){_('crit4lab').value=this.options[this.selectedIndex].text}
                update_cat_country('crit4', 'courseId_readup', 'crit5', 'crit5');">
                <option value="">Select programme </option><?php
                if (isset($_REQUEST["crit3"])&&$_REQUEST["crit3"]<> '')
                {
                    while($stmt->fetch())
                    {?>
                        <option value="<?php echo $cProgrammeId;?>"
                        <?php if (isset($_REQUEST["crit4"]) && $_REQUEST["crit4"] == $cProgrammeId){echo ' selected';}?>><?php echo $vProgrammeDesc; ?></option><?php
                    }
                    $stmt->close();
                }?>
            </select>
        </div>
    </div>
    
    <div class="innercont_stff">
        <label for="crit5" class="labell" style="width:190px;">Course 5</label>
        <div class="div_select"><?php
            if (isset($_REQUEST["crit4"])&&$_REQUEST["crit4"]<> '')
            {
                
				$new_curr = '';
				$curr_set = '';
				if (isset($_REQUEST['select_curriculum_prn']))
				{
					if ($_REQUEST['select_curriculum_prn'] == '1')
					{
						$new_curr = " AND c.cAcademicDesc <= 2023";
						$curr_set = '(Old curriculum)';
					}else if ($_REQUEST['select_curriculum_prn'] == '2')
					{
						$new_curr = " AND c.cAcademicDesc = 2024";
						$curr_set = '(New curriculum)';
					}
				}
                
                $stmt = $mysqli->prepare("SELECT siLevel, a.tSemester, a.cCourseId, CONCAT(a.tSemester,' ',b.iCreditUnit,' ',a.cCourseId,' ',b.vCourseDesc) vCourseDesc 
                FROM progcourse a, courses b 
                WHERE a.cCourseId = b.cCourseId 
                $new_curr
                AND cProgrammeId = ? 
                ORDER BY siLevel, a.tSemester, a.cCourseId");
                $stmt->bind_param("s", $_REQUEST['crit4']);
                $stmt->execute();
                $result = $stmt->store_result();
                $stmt->bind_result($siLevel, $tSemester, $cCourseId, $vCourseDesc);
            }?>
            <select id="crit5" name="crit5" class="select"  
                <?php if (!isset($_REQUEST['col5'])){echo ' disabled="disabled"';} ?>
                onchange="if(this.value!=''){_('crit5lab').value=this.options[this.selectedIndex].text}">
                <option value="">Select course</option><?php
                if (isset($_REQUEST["crit4"])&&$_REQUEST["crit4"]<> '')
                {
                    $prev_level = '';
                    $prev_sem = '';
                    while($stmt->fetch())
                    {
                        if(($prev_level <> '' && $prev_level <> $siLevel) || $prev_sem <> '' && $prev_sem <> $tSemester)
                        {?>
                            <option disabled></option><?php
                        }?>
                        <option value="<?php echo $cCourseId;?>"
                        <?php if (isset($_REQUEST["crit5"]) && $_REQUEST["crit5"] == $cCourseId){echo ' selected';}?>><?php echo $vCourseDesc; ?></option><?php

                        $prev_level = $siLevel;
                        $prev_sem = $tSemester;
                    }
                    $stmt->close();
                }?>
            </select>
        </div>
    </div>	
    
    <div class="innercont_stff">
        <label for="crit6" class="labell" style="width:190px;">Qualification 6</label>
        <div class="div_select"><?php
            $sqleq = "SELECT cEduCtgId, cQualCodeId ,vQualCodeDesc FROM qualification ORDER BY cEduCtgId, vQualCodeDesc";
            $rseq = mysqli_query(link_connect_db(), stripslashes($sqleq)) or die(mysqli_error(link_connect_db()));?>
            <select id="crit6" name="crit6"  class="select" 
                <?php if (!isset($_REQUEST['col6'])){echo ' disabled="disabled"';} ?>
                onchange="if(this.value!=''){_('crit6lab').value=this.options[this.selectedIndex].text}">
                <option value="">Select qualification </option><?php

                $cEduCtgId = '';

                while ($rseq_row = mysqli_fetch_array($rseq))
                {
                    if ($cEduCtgId <> '' && $cEduCtgId <> $rseq_row['cEduCtgId'])
                    {?>
                        <option disabled></option><?php
                    }?>
                    <option value="<?php echo $rseq_row['cQualCodeId'];?>"
                        <?php if (isset($_REQUEST["crit6"]) && $_REQUEST["crit6"] == $rseq_row['cQualCodeId']){echo ' selected';}?>> <?php echo $rseq_row['vQualCodeDesc'] ?> </option><?php

                    $cEduCtgId = $rseq_row['cEduCtgId'];
                }
                mysqli_close(link_connect_db());?>
            </select>
        </div>
    </div>					
    
    <div class="innercont_stff">
        <label for="crit7" class="labell" style="width:190px;">Level 7</label>
        <div class="div_select">
            <select id="crit7" name="crit7" class="select"  
                <?php if (!isset($_REQUEST['col7'])){echo ' disabled="disabled"';} ?>
                onchange="if(this.value!=''){_('crit7lab').value=this.options[this.selectedIndex].text}">
                <option value="">Select level </option>
                <option value = "10"<?php if (isset($_REQUEST["crit7"]) && $_REQUEST["crit7"] == 10){echo ' selected';}?>>10 </option>
                <option value = "20"<?php if (isset($_REQUEST["crit7"]) && $_REQUEST["crit7"] == 20){echo ' selected';}?>>20 </option>
                <option value = "30"<?php if (isset($_REQUEST["crit7"]) && $_REQUEST["crit7"] == 20){echo ' selected';}?>>30 </option>
                <option value = "40"<?php if (isset($_REQUEST["crit7"]) && $_REQUEST["crit7"] == 40){echo ' selected';}?>>40 </option><?php
                for ($t = 100; $t <= 700; $t+=100)
                {?>
                    <option value="<?php echo $t ?>"<?php if (isset($_REQUEST["crit7"]) && $_REQUEST["crit7"] == $t){echo ' selected';}?>><?php echo $t ?></option><?php
                }?>
            </select>
        </div>
    </div>						
    
    <div class="innercont_stff" style="margin-top:7px">
        <label for="crit8" class="labell" style="width:190px;">Gender 8</label>
        <div class="div_select">
            <select id="crit8" name="crit8" class="select"  
                <?php if (!isset($_REQUEST['col8'])){echo ' disabled="disabled"';} ?>
                onchange="if(this.value!=''){_('crit8lab').value=this.options[this.selectedIndex].text}">
                <option value="">Select gender </option>
                <option value="F"<?php if (isset($_REQUEST["crit8"]) && $_REQUEST["crit8"] == 'F'){echo ' selected';}?>>Female</option>
                <option value="M"<?php if (isset($_REQUEST["crit8"]) && $_REQUEST["crit8"] == 'M'){echo ' selected';}?>>Male</option>
            </select>
        </div>
    </div>						
    
    <div class="innercont_stff">
        <label for="crit9" class="labell" style="width:190px;">State of origin 9</label>
        <div class="div_select"><?php
            $sqlsta_org = "SELECT cStateId,vStateName FROM ng_state ORDER BY vStateName";
            $rssta_org = mysqli_query(link_connect_db(), stripslashes($sqlsta_org)) or die(mysqli_error(link_connect_db()));?>
            <select id="crit9" name="crit9" class="select"  
                <?php if (!isset($_REQUEST['col9'])){echo ' disabled="disabled"';} ?>
                onchange="if(this.value!=''){_('crit9lab').value=this.options[this.selectedIndex].text}
                update_cat_country('crit9', 'LGA_readup', 'crit10', 'crit10')">
                <option value="">Select state of origin </option><?php
                while ($rowsta_org = mysqli_fetch_array($rssta_org))
                {?>
                    <option value="<?php echo $rowsta_org['cStateId'];?>"
                    <?php if (isset($_REQUEST["crit9"]) && $_REQUEST["crit9"] == $rowsta_org['cStateId']){echo ' selected';}?>> <?php echo $rowsta_org['vStateName'] ?> </option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>
        </div>
    </div>			
    
    <div class="innercont_stff">
        <label for="crit10" class="labell" style="width:190px;">LGA of origin 10</label>
        <div class="div_select"><?php            
            if (isset($_REQUEST["crit9"])&&$_REQUEST["crit9"]<> '')
            {
                $stmt = $mysqli->prepare("SELECT cLGAId, vLGADesc
                FROM localarea
                WHERE cStateId = ? 
                ORDER BY vLGADesc");
                $stmt->bind_param("s", $_REQUEST['crit9']);
                $stmt->execute();
                $result = $stmt->store_result();
                $stmt->bind_result($cLGAId, $vLGADesc);
            }?>
            <select id="crit10" name="crit10" class="select" 
                <?php if (!isset($_REQUEST['col10'])){echo ' disabled="disabled"';} ?>
                onchange="if(this.value!=''){_('crit10lab').value=this.options[this.selectedIndex].text}">
                <option value="">Select LGA of origin </option><?php
                if (isset($_REQUEST["crit9"])&&$_REQUEST["crit9"]<> '')
                {
                    while($stmt->fetch())
                    {?>
                        <option value="<?php echo $cLGAId;?>"
                        <?php if (isset($_REQUEST["crit10"]) && $_REQUEST["crit10"] == $cLGAId){echo ' selected';}?>><?php echo ucwords(strtolower($vLGADesc)); ?></option><?php
                    }
                    $stmt->close();
                }?>
            </select>
        </div>
    </div>			
    
    <div class="innercont_stff">
        <label for="crit11" class="labell" style="width:190px;">State of residence 11</label>
        <div class="div_select"><?php
            $sqlsta_res = "SELECT cStateId,vStateName
            FROM ng_state ORDER BY vStateName";
            $rssta_res = mysqli_query(link_connect_db(), stripslashes($sqlsta_res)) or die(mysqli_error(link_connect_db()));?>
            <select id="crit11" name="crit11" class="select" 
                <?php if (!isset($_REQUEST['col13'])){echo ' disabled="disabled"';} ?> 
                onchange="if(this.value!=''){_('crit11lab').value=this.options[this.selectedIndex].text}
                update_cat_country('crit11', 'LGA_readup', 'crit12', 'crit12')">
                <option value="">Select state of residence </option><?php
                while ($rowsta_res = mysqli_fetch_array($rssta_res))
                {?>
                    <option value="<?php echo $rowsta_res['cStateId'];?>"
                        <?php if (isset($_REQUEST["crit11"]) && $_REQUEST["crit11"] == $rowsta_res['cStateId']){echo ' selected';}?>> <?php echo $rowsta_res['vStateName'] ?> </option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>
        </div>
    </div>	
    
    <div class="innercont_stff">
        <label for="crit12" class="labell" style="width:190px;">LGA of residence 12</label>
        <div class="div_select"><?php            
            if (isset($_REQUEST["crit11"])&&$_REQUEST["crit11"]<> '')
            {
                $stmt = $mysqli->prepare("SELECT cLGAId, vLGADesc
                FROM localarea
                WHERE cStateId = ? 
                ORDER BY vLGADesc");
                $stmt->bind_param("s", $_REQUEST['crit11']);
                $stmt->execute();
                $result = $stmt->store_result();
                $stmt->bind_result($cLGAId, $vLGADesc);
            }?>
            <select name="crit12" id="crit12" class="select"  
                <?php if (!isset($_REQUEST['col14'])){echo ' disabled="disabled"';} ?>
                onchange="if(this.value!=''){_('crit12lab').value=this.options[this.selectedIndex].text}">
                <option value="">Select state of residence </option><?php
                if (isset($_REQUEST["crit11"])&&$_REQUEST["crit11"]<> '')
                {
                    while($stmt->fetch())
                    {?>
                        <option value="<?php echo $cLGAId;?>"
                        <?php if (isset($_REQUEST["crit12"]) && $_REQUEST["crit12"] == $cLGAId){echo ' selected';}?>><?php echo ucwords(strtolower($vLGADesc)); ?></option><?php
                    }
                    $stmt->close();
                }?>
            </select>
        </div>
    </div>	
    
    <div class="innercont_stff">
        <label for="crit13" class="labell" style="width:190px;">Geo-political zone 13</label>
        <div class="div_select"><?php
            $sqllgaa_res = "select distinct cGeoZoneId from ng_state where cGeoZoneId <> '' order by cGeoZoneId";
            $rslga_res = mysqli_query(link_connect_db(), stripslashes($sqllgaa_res)) or die(mysqli_error(link_connect_db()));?>
            <select name="crit13" id="crit13" class="select" 
                <?php if (!isset($_REQUEST['col13'])){echo ' disabled="disabled"';} ?>
                 onchange="if(this.value!=''){_('crit13lab').value=this.options[this.selectedIndex].text}">
                <option value="">Geo-political zone</option><?php
                while ($rowsta_res = mysqli_fetch_array($rslga_res))
                {?>
                    <option value="<?php echo $rowsta_res['cGeoZoneId'];?>"
                        <?php if (isset($_REQUEST["crit13"]) && $_REQUEST["crit13"] == $rowsta_res['cGeoZoneId']){echo ' selected';}?>> <?php echo $rowsta_res['cGeoZoneId'] ?> </option><?php
                }
                mysqli_close(link_connect_db());?>
            </select>
        </div>
    </div>						
    
    <div class="innercont_stff">
        <label for="crit14" class="labell" style="width:190px;">Admission status 14</label>
        <div class="div_select">
            <select id="crit14" name="crit14" class="select"  
                <?php if (isset($_REQUEST['std_cat']) && $_REQUEST['std_cat'] <> 'b'){echo ' disabled="disabled"';} ?>
                onchange="if(this.value!=''){_('crit14lab').value=this.options[this.selectedIndex].text}">
                <option value="">Select status </option>
                <option value="0" <?php if (!isset($_REQUEST["crit14"]) || (isset($_REQUEST["crit14"]) && ($_REQUEST["crit14"] == 0 || $_REQUEST["crit14"] == ''))){echo ' selected';}?>>Screened qualified</option>
                <option value="1" <?php if (isset($_REQUEST["crit14"]) && $_REQUEST["crit14"] == '1'){echo ' selected';}?>>Screened not qualified</option>
                <option value="2" <?php if (isset($_REQUEST["crit14"]) && $_REQUEST["crit14"] == '2'){echo ' selected';}?>>Submitted form, yet to screen</option>
                <option value="3" <?php if (isset($_REQUEST["crit14"]) && $_REQUEST["crit14"] == '3'){echo ' selected';}?>>Printed letter</option>
                <option value="4" <?php if (isset($_REQUEST["crit14"]) && $_REQUEST["crit14"] == '4'){echo ' selected';}?>>Printed letter, yet to screen</option>
            </select>
        </div>
    </div>
    
    <div class="innercont_stff" style="padding-top:5px">
        <label class="labell" style="width:190px; margin-left:7px;">In-mate? 15</label>
        <div class="div_select" style="height:auto; padding:3px; padding-left:0px;">
            <div style="float:left; width:auto; padding-left:0px">
                <input id="crit181" name="crit18_r" type="radio" value="1"
                    onClick="_('crit18').value=this.value;">
                <label for="crit181" style="width:auto;">Yes</label>
            </div>

            <div style="float:left; width:auto; margin-left:15px; padding-left:0px">
                <input id="crit182" name="crit18_r" type="radio" value="0"
                    onClick="_('crit18').value=this.value;" checked>
                <label for="crit182" style="width:auto;">No</label>
            </div>
        </div>
        <input type="hidden" id="crit18" name="crit18" value="0"/>
    </div>
    
    <!-- <div class="innercont_stff">
        <label for="crit18" class="labell" style="width:190px;">Inmate? 15</label>
        <div class="div_select">
            <input type="checkbox" id="crit18" name="crit18" value="1" />
        </div>
    </div> -->
    
    <div class="innercont_stff" style="margin-top:7px">
        <label for="crit15" class="labell" style="width:190px;">Application Form number 16</label>
        <div class="div_select">
            <input id="crit15" name="crit15" type="number" class="textbox" value="<?php if (isset($_REQUEST["crit15"]) && $_REQUEST["crit15"] <>''){echo $_REQUEST["crit15"];}?>"/>
        </div>
    </div>
    
    <div class="innercont_stff">
        <label for="crit16" class="labell" style="width:190px;">Matriculation number 17</label>
        <div class="div_select">
            <input name="crit16" id="crit16" type="text" class="textbox" value="<?php if (isset($_REQUEST["crit16"]) && $_REQUEST["crit16"] <>''){echo $_REQUEST["crit16"];}?>"/>
        </div>
    </div>
    
    <div class="innercont_stff">
        <label for="crit17" class="labell" style="width:190px;">Last name 18</label>
        <div class="div_select">
            <input name="crit17" id="crit17" type="text" class="textbox" value="<?php if (isset($_REQUEST["crit17"]) && $_REQUEST["crit17"] <>''){echo $_REQUEST["crit17"];}?>"/>
        </div>
    </div>
</div>