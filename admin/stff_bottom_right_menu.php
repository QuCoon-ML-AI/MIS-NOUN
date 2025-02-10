<?php 

//echo $mm.',' .$sm.','; if (isset($_REQUEST['whattodo'])){echo $_REQUEST['whattodo'].',, ';} if (isset($_REQUEST['whattodo1'])){echo $_REQUEST['whattodo1'].', ';}

if ($mm == 0)
{
    if ($sm == 1)
    {
        if ($ac == '1')
        {
            $para = "n_crit.save.value='1'";
        }else if ($aq == '1')
        {
            $para = "e_qual.save.value='1'";
        }else if ($ec == '1')
        {
            $para = "n_crit.save.value='1';";   
        }
        
        if ($ac == '1' || $aq == '1' || $ec == '1')
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="<?php echo $para;?>;chk_inputs();return false">
                <div id="sub_box" class="bot_right_std_btns">
                    Submit
                </div>
            </a><?php
        }else if ($as == '1')
        {
            $condi = ((isset($_REQUEST['as'])&&$_REQUEST['as']=='1') || (isset($_REQUEST['es'])&&$_REQUEST['es']=='1'));
            $condi2 = (isset($_REQUEST['save'])&&$_REQUEST['save']=='1');
        
            $condi3 = ((isset($_REQUEST['das'])&&$_REQUEST['das']=='1') || (isset($_REQUEST['ds'])&&$_REQUEST['ds']=='1'));
            
            if($crit_used == '0'&&((!$condi2&&$condi&&$sbjlist=='')||($msg<>''&&!$condi3)))
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="e_qual_sbj.save.value=1;e_qual_sbj.submit();return false">
                    <div id="sub_box" class="bot_right_std_btns" style="display:block">
                        Submit
                    </div>
                </a>
                
                <a href="#" style="text-decoration:none;" 
                    onclick="e_crit.ec.value='';
                    e_crit.dc.value='';										
                    e_crit.aq.value='';
                    e_crit.eq.value='';
                    e_crit.dq.value='';					
                    e_crit.as.value='';
                    e_crit.es.value='';
                    e_crit.ds.value='';
                    e_crit.das.value='';							
                    e_crit.en.value='';
                    e_crit.dis.value='';
                    e_crit.admt.value='';
                    e_crit.conf.value='';
                    e_crit.sbjlist.value='';
                    
                    e_crit.cFacultyId.value='<?php echo $cFacultyId ?>';
                    e_crit.cdept.value='<?php echo $cdept ?>';
                    e_crit.vFacultyDesc.value='<?php echo $FacultyDesc; ?>';
                    e_crit.vdeptDesc.value='<?php echo $deptDesc; ?>';
                    e_crit.vObtQualTitle.value='<?php echo $vObtQualTitle; ?>';
                    e_crit.cEduCtgId.value='<?php echo $prog_cat;?>';
                    e_crit.cProgrammeId.value='<?php echo $cProgrammeId; ?>';
                    e_crit.vProgrammeDesc.value='<?php echo $ProgrammeDesc; ?>';
                    e_crit.submit();
                    return false">
                    <div id="cont_box" class="bot_right_std_btns" style="display:none">
                        Continue
                    </div>
                </a><?php
            }else if ($condi2&&$msg=='')
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="e_qual_sbj.ec.value='';
                    e_qual_sbj.dc.value='';												
                    e_qual_sbj.aq.value='';
                    e_qual_sbj.eq.value='';
                    e_qual_sbj.dq.value='';												
                    e_qual_sbj.as.value='';
                    e_qual_sbj.es.value='';
                    e_qual_sbj.ds.value='';
                    e_qual_sbj.das.value='';												
                    e_qual_sbj.en.value='';
                    e_qual_sbj.dis.value='';
                    e_qual_sbj.admt.value='';
                    e_qual_sbj.conf.value='';
                    e_qual_sbj.sbjlist.value='1';
                    e_qual_sbj.save.value='';

                    e_qual_sbj.cFacultyId.value='<?php echo $cFacultyId ?>';
                    e_qual_sbj.cdept.value='<?php echo $cdept ?>';
                    e_qual_sbj.vFacultyDesc.value='<?php echo $vFacultyDesc; ?>';
                    e_qual_sbj.vdeptDesc.value='<?php echo $vdeptDesc; ?>';
                    e_qual_sbj.vObtQualTitle.value='<?php echo $vObtQualTitle; ?>';
                    e_qual_sbj.cEduCtgId.value='<?php echo $cEduCtgId;?>';
                    e_qual_sbj.cProgrammeId.value='<?php echo $cProgrammeId; ?>';
                    e_qual_sbj.vProgrammeDesc.value='<?php echo $vProgrammeDesc; ?>';
                    e_qual_sbj.vReqmtDesc.value='<?php echo addslashes($vReqmtDesc); ?>';

                    e_qual_sbj.criteriaqualId.value='<?php echo $_REQUEST['criteriaqualId'];?>';

                    e_qual_sbj.sReqmtId.value='<?php echo $sReqmtId ?>';
                    e_qual_sbj.histgo.value='-3';
                    e_qual_sbj.submit();
                    return false">
                    <div id="sub_box" class="bot_right_std_btns">
                        Continue
                    </div>
                </a><?php
            }
        }
    }else if ($sm == 2)
    {
        if ($ec == '1')
        {
            $para = "n_crit.save.value='1';";   
        }else if ($eq == '1')
        {
            $para = "e_qual.save.value='1';";   
        }
        
        if ($eq == '1' || $ec == '1')
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="<?php echo $para;?>;chk_inputs();return false">
                <div id="sub_box" class="bot_right_std_btns">
                    Submit
                </div>
            </a><?php
        }else if ($es == '1')
        {
            $condi = ((isset($_REQUEST['as'])&&$_REQUEST['as']=='1') || (isset($_REQUEST['es'])&&$_REQUEST['es']=='1'));
            $condi2 = (isset($_REQUEST['save'])&&$_REQUEST['save']=='1');
        
            $condi3 = ((isset($_REQUEST['das'])&&$_REQUEST['das']=='1') ||     (isset($_REQUEST['ds'])&&$_REQUEST['ds']=='1'));

            if($crit_used == '0'&&((!$condi2&&$condi&&$sbjlist=='')||($msg<>''&&!$condi3)))
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="e_qual_sbj.save.value=1;in_progress('1');e_qual_sbj.submit();return false">
                    <div id="sub_box" class="bot_right_std_btns">
                        Submit
                    </div>
                </a><?php
            }else if ($condi2&&$msg=='')
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="e_qual_sbj.ac.value='';
                    e_qual_sbj.ec.value='';
                    e_qual_sbj.dc.value='';												
                    e_qual_sbj.aq.value='';
                    e_qual_sbj.eq.value='';
                    e_qual_sbj.dq.value='';												
                    e_qual_sbj.as.value='';
                    e_qual_sbj.es.value='';
                    e_qual_sbj.ds.value='';
                    e_qual_sbj.das.value='';												
                    e_qual_sbj.en.value='';
                    e_qual_sbj.dis.value='';
                    e_qual_sbj.admt.value='';
                    e_qual_sbj.conf.value='';
                    e_qual_sbj.sbjlist.value='1';
                    e_qual_sbj.sReqmtId.value='<?php echo $sReqmtId ?>';
                    
                    e_qual_sbj.cEduCtgId_1.value='<?php echo $cEduCtgId_1;?>';
                    e_qual_sbj.cEduCtgId_2.value='<?php echo $cEduCtgId_2;?>';
                    e_qual_sbj.vQualCodeDesc.value='<?php echo $vQualCodeDesc;?>';
                    
                    e_qual_sbj.cFacultyId.value='<?php echo $cFacultyId ?>';
                    e_qual_sbj.cdept.value='<?php echo $cdept ?>';
                    e_qual_sbj.vFacultyDesc.value='<?php echo $vFacultyDesc; ?>';
                    e_qual_sbj.vdeptDesc.value='<?php echo $vdeptDesc; ?>';
                    e_qual_sbj.vObtQualTitle.value='<?php echo $vObtQualTitle; ?>';
                    e_qual_sbj.cEduCtgId.value='<?php echo $prog_cat;?>';
                    
                    e_qual_sbj.cEduCtgId_selected_qual.value='<?php echo $cEduCtgId_selected_qual;?>';
                    
                    e_qual_sbj.cProgrammeId.value='<?php echo $cProgrammeId; ?>';
                    e_qual_sbj.vProgrammeDesc.value='<?php echo $vProgrammeDesc; ?>';
                    e_qual_sbj.vReqmtDesc.value='<?php echo addslashes($vReqmtDesc); ?>';
                    e_qual_sbj.submit();
                    return false">
                    <div id="sub_box" class="bot_right_std_btns">
                        Continue
                    </div>
                </a><?php
            }
        }
    }else if ($sm == 3)
    {

    }else if ($sm == 4)
    {?>
        <!--<a href="#" style="text-decoration:none;" 
            onclick="chk_inputs();return false">
            <div id="sub_box" class="bot_right_std_btns"style="position:absolute; bottom:0; display:<?php if(isset($_REQUEST['id_no']) && $_REQUEST['id_no'] <> ''){echo 'block';}else{echo 'none';} ?>">
                Submit
            </div>
        </a>--><?php
    }else if ($sm == 6)
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="sets.save.value='1';chk_inputs(); return false">
            <div id="sub_box_0" class="bot_right_std_btns" style="<?php if (!isset($_REQUEST['save'])){?>display:block <?php }else{?>display:none <?php }?>">
                Submit
            </div>
        </a>
        
        <a href="#" style="text-decoration:none;" 
            onclick="prns_form.submit(); return false">
            <div id="sub_box_1" class="bot_right_std_btns" style="<?php if (isset($_REQUEST['save'])){?>display:block <?php }else{?>display:none <?php }?>">
            Print
            </div>
        </a>
        
        <!--<a href="#" style="text-decoration:none;" 
            onclick="<?php if (!isset($_REQUEST['save'])){?>sets.save.value='1';chk_inputs();<?php }else{?>prns_form.submit();<?php }?>return false">
            <div id="sub_box" class="bot_right_std_btns">
                <?php if (!isset($_REQUEST['save'])){?>Submit<?php }else{?>Print<?php }?>
            </div>
        </a>--><?php
    }else if ($sm == 7)
    {?>
        <div id="sub_box" style="float:left; 
            height:inherit; 
            width:inherit; 
            margin-top:3px; 
            display:<?php if (isset($sho3) && $sho3 == 'block' && $numOfiputTag >= 0){?>block<?php }else{?>none;<?php }?>;">                 
            <a href="#" style="text-decoration:none;" 
                onclick="sets.save.value='2';chk_inputs();return false">
                <div id="clear_all" class="bot_right_std_btns"style="position:absolute; bottom:90px; display:<?php echo $sho3;?>;">
                    Clear all
                </div>
            </a>
                                
            <a href="#" style="text-decoration:none;" 
                onclick="prns_form.submit();return false">
                <div id="print_all" class="bot_right_std_btns"style="position:absolute; bottom:45px; display:<?php echo $sho3;?>;">
                    Print
                </div>
            </a>
                                
            <a href="#" style="text-decoration:none;" 
                onclick="sets.save.value='1';chk_inputs();return false">
                <div id="sub_btn" class="bot_right_std_btns">
                    Submit
                </div>
            </a>
        </div><?php
    }else if ($sm == 8 || $sm == 9 || $sm == 10 || $sm == 11 || $sm == 12)
    {
        if ($sm == 11 &&  isset($_REQUEST['save_cf']) && $_REQUEST['save_cf'] == '1' && isset($_REQUEST["uvApplicationNo"]) && trim($_REQUEST["uvApplicationNo"]) <> '')
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="prns_form.submit();return false">
                <div id="print_all" class="bot_right_std_btns"style="position:absolute; bottom:45px; display:none;">
                    Print
                </div>
            </a><?php
        }?>
        
        <a href="#" style="text-decoration:none;" 
            onclick="if (_('save_cf')){_('save_cf').value='1';}chk_inputs();return false">
            <div id="sub_box" class="bot_right_std_btns">
                Submit
            </div>
        </a><?php
    }
}else if ($mm == 1 || $mm == 8)
{
    if ($sm == 2)
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="if (_('save_cf')){_('save_cf').value='1';}chk_inputs();return false">
            <div id="sub_box" class="bot_right_std_btns">
                Submit
            </div>
        </a><?php
    }else if ($sm == 3)
    {
        if (check_scope3('Academic registry','Update student credentials', 'Add') > 0 ||
        check_scope3('Academic registry','Update student credentials', 'Edit') > 0)
        {
            $display = 'none';
            if ((isset($_REQUEST['more_qual']) && $_REQUEST['more_qual'] == '1') || (isset($_REQUEST['edit_qual']) && $_REQUEST['edit_qual'] == '1'))
            {
                $display = 'bock';
            }?>
            <a href="#" style="text-decoration:none;"
                onclick="if (reg_grp1_1_loc.more_qual.value != 1 && reg_grp1_1_loc.see_qual.value != 1 && reg_grp1_1_loc.edit_qual.value != 1)
                {
                    reg_grp1_1_loc.see_all_qual.value = 1;
                }else if (reg_grp1_1_loc.more_qual.value == 1 || reg_grp1_1_loc.edit_qual.value == 1)
                {
                    reg_grp1_1_loc.save_cf.value='1';
                }

                
                chk_inputs();return false">
                <div id="sub_box" class="bot_right_std_btns" style="display:<?php echo $display;?>">
                    Submit
                </div>
            </a><?php
        }
    }else if ((isset($_REQUEST['whattodo']) && $sm == 4) || $sm == 5 || $sm == 6 || $sm == 7 || $sm == 8 || $sm == 9 || ($sm == 10 && isset($_REQUEST['corect']) && $_REQUEST['corect'] <> ''))
    {
        $para_str = "chk_inputs();return false";
        if ($sm == 4 && isset($_REQUEST['whattodo']) && ($_REQUEST['whattodo'] == 12 || $_REQUEST['whattodo'] == 13))
        {
            if ($_REQUEST['whattodo'] == 12)
            {
                $para_str = "in_progress('1');sc_1_loc.submit();return false";
            }else if ($_REQUEST['whattodo'] == 13)
            {
                $para_str = "if (sc_1_loc.uvApplicationNo.value=='')
                {
                    setMsgBox('labell_msg0','');
                    sc_1_loc.uvApplicationNo.focus();
                    return false;
                }

                if (_('prog_cat1') && _('prog_cat_div').style.display=='block')
                {
                    if (sc_1_loc.prog_cat1.value=='')
                    {
                        setMsgBox('labell_msg1','');
                        sc_1_loc.prog_cat1.focus();
                        return false;
                    }
                }
                    
                sc_1_loc.action='change_application_programme_category';
                in_progress('1');
                sc_1_loc.submit();
                return false";
            }
        }else if ($sm == 4 && isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] == 7)
        {
            $para_str = "if (sc_1_loc.uvApplicationNo.value=='')
            {
                setMsgBox('labell_msg0','');
                sc_1_loc.uvApplicationNo.focus();
                return false;
            }
            _('sc_1_loc').target='_self';
            _('sc_1_loc').action = 'verify_credentials'; 
            in_progress('1');sc_1_loc.submit();
            return false";
        }else if ($sm == 4 && isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] == 15)
        {
            $para_str = "if (sc_1_loc.uvApplicationNo.value=='')
            {
                setMsgBox('labell_msg0','');
                sc_1_loc.uvApplicationNo.focus();
                return false;
            }

            if (_('sel_opt') && _('sel_opt').value==0 && _('ans2').style.display=='block')
            {
                caution_box('Select course(s) to drop');
                return false;
            }

            if (_('ans2') && _('ans2').style.display=='block')
            {                
                _('conf_box_loc').style.display = 'block';
                _('conf_box_loc').style.zIndex = 3;
                _('smke_screen_2').style.display = 'block';
                _('smke_screen_2').style.zIndex = 2;
            }else
            {                					
                _('sc_1_loc').target='_self';
                _('sc_1_loc').action = 'drop_courses'; 
                in_progress('1');
                sc_1_loc.submit();
                return false
            }";
            
        }else if ($sm == 4 && isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] == 9)
        {
           $para_str = "sc_1_loc.conf.value = '0';chk_inputs();return false";
        }?>
        
        <a href="#" style="text-decoration:none;" 
            onclick="<?php echo $para_str;?>">
            <div id="sub_box" class="bot_right_std_btns">
                Submit
            </div>
        </a><?php
    }else if ($sm == 11)
    {
        if (check_scope3('Academic registry', 'Settings', 'Modify') > 0)
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="if (_('save_cf')){_('save_cf').value='1';}chk_inputs();return false">
                <div id="bursubmit" class="bot_right_std_btns"style="position:absolute; bottom:0; display:<?php if ($mm == 2 && $sm == 10){?>none<?php }else{?>block<?php }?>">
                    Submit
                </div>
            </a><?php
        }
    }else if ($sm == 12)
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="student_msg_loc.save_cf.value='2';chk_inputs();return false">
            <div id="save_box" class="bot_right_std_btns" style="position:absolute; bottom:45px; 
                display:<?php if (isset($_REQUEST["loc_what"]) && ($_REQUEST["loc_what"] == 0 || $_REQUEST["loc_what"] == 1)){echo 'block';}else{echo 'none';}?>" title="This button will remove the message from the notice board if already displayed">
                Save
            </div>
        </a>
        <a href="#" style="text-decoration:none;" 
            onclick="student_msg_loc.save_cf.value='1';chk_inputs();return false">
            <div id="send_box" class="bot_right_std_btns" 
                style="display:<?php if (isset($_REQUEST["loc_what"]) && ($_REQUEST["loc_what"] == 0 || $_REQUEST["loc_what"] == 1)){echo 'block';}else{echo 'none';}?>">
                Send
            </div>
        </a>
        <a href="#" style="text-decoration:none;" 
            onclick="student_msg_loc.save_cf.value='3';chk_inputs();return false">
            <div id="del_box" class="bot_right_std_btns" 
                style="display:<?php if (isset($_REQUEST["loc_what"]) && $_REQUEST["loc_what"] == 2){echo 'block';}else{echo 'none';}?>">
                Delete
            </div>
        </a><?php
    }else if ($sm == 13 || $sm == 14)
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="chk_inputs();return false">
            <div id="bursubmit" class="bot_right_std_btns"style="position:absolute; bottom:0;">
                Submit
            </div>
        </a><?php
    }
}else if ($mm == 2)
{
    if ($sm == 1 || $sm == 2 || $sm == 3 || $sm == 5 || $sm == 13 || $sm == 14)
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="chk_inputs();return false">
            <div id="sub_box" class="bot_right_std_btns">
                Submit
            </div>
        </a><?php
    }else if ($sm == 15)
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="chk_inputs();">
            <div id="sub_box" class="bot_right_std_btns">
                Submit
            </div>
        </a><?php
    }else if ($sm == 16)
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="if (_('student_balances_loc').number_of_records_to_process.value == '')
            {
                setMsgBox('labell_msg0','');
                _('student_balances_loc').number_of_records_to_process.focus();
            }else
            {
                _('conf_box_loc').style.display='block';
                _('conf_box_loc').style.zIndex='3';
                _('smke_screen_2').style.display='block';
                _('smke_screen_2').style.zIndex='2';
                
                _('labell_msg0').style.display='none';
            }">
            <div id="sub_box" class="bot_right_std_btns">
                Submit
            </div>
        </a><?php
    }else if ($sm == 6)
    {
        if (isset($_REQUEST['cFacultyId_loc_0']) && $_REQUEST['cFacultyId_loc_0'] <> '')
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="_('user_centre_ex_burs').value=_('user_centre').value;
                _('cFacultyId_ex_burs').value=_('cFacultyId_loc_1').value;
                _('show_all_ex_burs').value=_('show_all_burs').value;
                _('cEduCtgId_loc_ex_burs').value=_('cEduCtgId_loc_1').value;
                _('new_old_structure_ex_burs').value=_('new_old_structure_h').value;
                excel_export.submit();return false">
                <div id="sub_box" class="bot_right_std_btns"style="position:absolute; bottom:45px;">
                    Export to excel
                </div>
            </a>
            
            <a href="#" style="text-decoration:none;" 
                onclick="prns_form.cFacultyId_desc_loc_0.value=selitems.cFacultyId_desc_loc_0.value;
                prns_form.submit();return false">
                <div id="print_btn" class="bot_right_std_btns">
                    Print
                </div>
            </a><?php
        }
    }else  if ($sm == 7 || $sm == 8 || $sm == 9 || $sm == 12)
    {
        if ($sm == 9)
        {                
            if (check_scope3('Bursary', 'Clearance', 'Modify') > 0)
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="if (_('clearance_loc').uvApplicationNo.value == '')
                    {
                        setMsgBox('labell_msg0','');
                        _('clearance_loc').uvApplicationNo.focus();
                    }else
                    {
                        _('save_cf').value='1';
                        _('clearance_loc').submit();
                    }">
                    <div id="sub_box" class="bot_right_std_btns">
                        Submit
                    </div>
                </a><?php
            }
        }else if ($sm == 7 || $sm == 8)
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="if (_('save_cf')){_('save_cf').value='1';}chk_inputs();return false">
                <div id="sub_box" class="bot_right_std_btns">
                    Submit
                </div>
            </a><?php
        }else if ($sm == 12)
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="if (_('save_cf')){_('save_cf').value='1';}chk_inputs();return false">
                <div id="sub_box" class="bot_right_std_btns"><?php
                    if (isset($_POST["uvApplicationNo"]) && $_POST["uvApplicationNo"] <> '' && $err == 0)
                    {
                        echo 'Continue';
                    }else
                    {
                        echo 'Submit';
                    }?>
                </div>
            </a><?php
        }
    }else  if ($sm == 10)
    {
        if (check_scope3('Bursary', 'Settings', 'Modify') > 0)
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="if (_('save_cf')){_('save_cf').value='1';}chk_inputs();return false">
                <div id="sub_box" class="bot_right_std_btns"style="position:absolute; bottom:0;">
                    Submit
                </div>
            </a><?php
        }
    }else if ($sm == 11)
    {
        $exp_excel_div = 'none';
        $print_all_div = 'none';
        $sub_box2_div = 'none';

        if (isset($_REQUEST['save']) && $_REQUEST['save'] == '1')
        {
            if (isset($_REQUEST["tabno"]))
            {
                if ($_REQUEST["tabno"] == 1)
                {
                    $sub_box2_div = 'block';
                }else
                {
                    $exp_excel_div = 'block';
                    $print_all_div = 'block';
                }
            }
        }else
        {
            $sub_box2_div = 'block';
        }?>
        <!--<a href="#" style="text-decoration:none;" 
            onclick="excel_export.submit();return false">
            <div id="exp_excel" class="bot_right_std_btns"style="position:absolute; bottom:45px; display:<?php echo $exp_excel_div;?>">
                Export to Excel
            </div>
        </a>
        
        <a href="#" style="text-decoration:none;" 
            onclick="prns_form.submit();return false">
            <div id="print_all" class="bot_right_std_btns"style="position:absolute; bottom:0; display:<?php echo $print_all_div;?>">
                Print
            </div>
        </a>-->
        
        <a href="#" style="text-decoration:none;" 
            onclick="burs_loc.tabno.value='2';burs_loc.save.value='1';chk_inputs();return false">
            <div id="sub_box2" class="bot_right_std_btns"style="position:absolute; bottom:0; display:<?php echo $sub_box2_div;?>">
                Submit
            </div>
        </a><?php
    }
}else if ($mm == 3)
{
    if ((isset($_REQUEST['whattodo']) && $sm == 1) || $sm == 2 || $sm == 3 || $sm == 4 || $sm == 5 || $sm == 6 || $sm == 7 || $sm == 8)
    {
        $para_str = "if (_('save_cf')){_('save_cf').value='1';}chk_inputs();return false";
        if ($sm == 1 && isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] == 12)
        {
            $para_str = "in_progress('1');sc_1_loc.submit();return false";
        }?>
        <a href="#" style="text-decoration:none;" 
            onclick="<?php echo $para_str;?>">
            <div id="sub_box" class="bot_right_std_btns">
                Submit
            </div>
        </a><?php
    }else if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] <> 0 && $sm == 9)
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="chk_inputs();return false">
            <div id="sub_box" class="bot_right_std_btns">
                Submit
            </div>
        </a><?php
    }else if ($sm == 10)
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="student_msg_loc.save_cf.value='2';chk_inputs();return false">
            <div id="save_box" class="bot_right_std_btns" style="position:absolute; bottom:45px; 
                display:<?php if (isset($_REQUEST["loc_what"]) && $_REQUEST["loc_what"] == 0){echo 'block';}else{echo 'none';}?>" title="This button will remove the message from the notice board if already displayed">
                Save
            </div>
        </a>
        <a href="#" style="text-decoration:none;" 
            onclick="student_msg_loc.save_cf.value='1';chk_inputs();return false">
            <div id="send_box" class="bot_right_std_btns" 
                style="display:<?php if (isset($_REQUEST["loc_what"]) && $_REQUEST["loc_what"] == 0){echo 'block';}else{echo 'none';}?>">
                Send
            </div>
        </a>
        <a href="#" style="text-decoration:none;" 
            onclick="student_msg_loc.save_cf.value='3';chk_inputs();return false">
            <div id="del_box" class="bot_right_std_btns" 
                style="display:none">
                Delete
            </div>
        </a><?php
    }else if ($sm == 11)
    {
        if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] <> '')
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="chk_inputs();return false">
                <div id="sub_box" class="bot_right_std_btns">
                    Submit
                </div>
            </a><?php
        }
    }
}else if ($mm == 4)
{
    if ($sm == 1 || $sm == 2 || $sm == 3 || $sm == 4 || $sm == 5 || $sm == 6 || $sm == 7 || $sm == 9)
    {?>
            <a href="#" style="text-decoration:none;" 
            onclick="if (_('save_cf')){_('save_cf').value='1';}chk_inputs();return false">
            <div id="sub_box" class="bot_right_std_btns">
                Submit
            </div>
        </a><?php
    }else if ($sm == 8)
    {
        if ($num_rec > 0)
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="adjust_loc.save_cf.value='1';adjust_loc.submit();">
                <div id="sub_box" class="bot_right_std_btns">
                    Submit
                </div>
            </a><?php
        }
    }else if ($sm == 10)
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="if (anavail_loc.rrr.value == '')
            {
                setMsgBox('labell_msg0','');
                anavail_loc.rrr.focus();
                return false;
            }
            anavail_loc.save_cf.value='1';anavail_loc.submit();">
            <div id="sub_box" class="bot_right_std_btns">
                Submit
            </div>
        </a><?php
    }else  if ($sm == 10)
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="sets.save.value='1';chk_inputs(); return false">
            <div id="sub_box_0" class="bot_right_std_btns" style="<?php if (!isset($_REQUEST['save'])){?>display:block <?php }else{?>display:none <?php }?>">
                Submit
            </div>
        </a><?php
    }
}else if ($mm == 5)
{
    if ((isset($_REQUEST['whattodo']) && $sm == 1) || $sm == 2 || $sm == 3 || $sm == 4 || $sm == 5 || $sm == 6 || $sm == 7 || $sm == 8 || $sm == 9 || $sm == 11)
    {
        if ($sm == 1 && isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] == 12)
        {
            $para_str = "in_progress('1');_('conf_box_loc').style.display='block';sc_1_loc.submit();return false";
        }else if ($sm == 1 && isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] == 14)
        {
            $para_str = "_('smke_screen_2').style.display='block'; _('smke_screen_2').style.zIndex='2';_('conf_box_loc').style.display='block'; _('conf_box_loc').style.zIndex='3';";
        }else if ($sm == 1 && isset($_REQUEST['whattodo']) && $_REQUEST['whattodo'] == 13)
        {
            $para_str = "sc_1_loc.submit();";
        }else if ($sm == 5)
        {
            $para_str = "in_progress('1');acad_rec.submit();return false";
        }else
        {
            $para_str = "if (_('save_cf')){_('save_cf').value='1';}chk_inputs();return false";            
        }?>
        
        <a href="#" style="text-decoration:none;" 
            onclick="<?php echo $para_str;?>">
            <div id="sub_box" class="bot_right_std_btns">
                Submit
            </div>
        </a><?php
    }
}else if ($mm == 6)
{
    if (isset($_REQUEST['whattodo']))
    {
        if ($sm == 1 /*|| $sm == 2 || $sm == 3 || $sm == 4 || $sm == 5 || $sm == 6 || $sm == 7 || $sm == 8 || $sm == 9 || $sm == 11*/)
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="chk_inputs();">
                <div id="sub_box" class="bot_right_std_btns">
                    Submit
                </div>
            </a><?php
        }else  if ($sm == 2)
        {
            if ($_REQUEST['whattodo'] == 3 || $_REQUEST['whattodo'] == 4 || $_REQUEST['whattodo'] == 5 || $_REQUEST['whattodo'] == 6 || $_REQUEST['whattodo'] == 7 || $_REQUEST['whattodo'] == '7a')
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="chk_inputs();">
                    <div id="sub_box" class="bot_right_std_btns">
                        Submit
                    </div>
                </a><?php
            }
        }else  if ($sm == 3)
        {
            if ($_REQUEST['whattodo'] == 8 || $_REQUEST['whattodo'] == '8a' || $_REQUEST['whattodo'] == 9 || $_REQUEST['whattodo'] == '9a' || $_REQUEST['whattodo'] == '11'|| $_REQUEST['whattodo'] == '12' || $_REQUEST['whattodo'] == '12a' || $_REQUEST['whattodo'] == 13 || $_REQUEST['whattodo'] == 14 || $_REQUEST['whattodo'] == 15 || $_REQUEST['whattodo'] == 16)
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="chk_inputs();">
                    <div id="sub_box" class="bot_right_std_btns">
                        Submit
                    </div>
                </a><?php
            }
        }
    }?><?php
}else if ($mm == 7)
{
    if ($sm == 1 || $sm == 2)
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="chk_inputs();return false">
            <div id="sub_box" class="bot_right_std_btns"style="position:absolute; bottom:0; 
                display:<?php if((isset($_REQUEST["whattodo"]) && ($_REQUEST["whattodo"] == 0||$_REQUEST["whattodo"] == 1||$_REQUEST["whattodo"] == 5||$_REQUEST["whattodo"] == 6||($_REQUEST["whattodo"] == 4&&isset($_REQUEST["exist_user"])&&$_REQUEST["exist_user"]<>''))) || (isset($_REQUEST["whattodo1"]) && ($_REQUEST["whattodo1"] == '1'||$_REQUEST["whattodo1"] == '3'||$_REQUEST["whattodo1"] == '4'))){echo 'block';}else{echo 'none';}?>">
                Submit
            </div>
        </a><?php
    }else if ($sm == 3 || $sm == 4) 
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="chk_inputs();return false">
            <div id="sub_box" class="bot_right_std_btns"style="position:absolute; bottom:0; ">
                Submit
            </div>
        </a><?php
    }
}?>