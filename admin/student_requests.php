<?php
$sho_0 = 'none';

if ($sm == 6 || $sm == 5 || $sm == 4 || $sm == 1)
{
    $sho_0 = 'block';
}?>
<div style="width:15%; height:auto; position:absolute; right:5px; margin-top:10px; border-radius:0px; display:<?php echo $sho_0;?>"><?php
    if (check_scope2('SPGS', 'SPGS menu') > 0)
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="pg_environ.mm.value=8;pg_environ.sm.value='';pg_environ.submit();return false;">
            <div class="rtlft_inner_button" style="margin-bottom:5px; width:100%;">
                SPGS menu
            </div>
        </a><?php
    }

    if ( $sm == 4 || $sm == 1)
    {
       /* if (check_scope3('Academic registry', 'Student request', 'Retrieve password') > 0 || 
        check_scope3('Learner support', 'Student request', 'Retrieve password') > 0 || 
        check_scope3('Technical support', 'Student request', 'Retrieve password') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='0')
            {?>
                <div id="tabss0_0" class="rtlft_inner_button_dull" style="width:100%;">
                        Retrieve password
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=0;
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss0" class="rtlft_inner_button" style="width:100%; display:none;">
                        Retrieve password
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=0;
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss0" class="rtlft_inner_button" style="width:100%;">
                        Retrieve password
                    </div>
                </a><?php
            }
        }

        if (check_scope3('Academic registry', 'Student request', 'Reset password') > 0 || 
        check_scope3('Learner support', 'Student request', 'Reset password') > 0 || 
        check_scope3('Technical support', 'Student request', 'Reset password') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='1')
            {?>
                <div class="rtlft_inner_button_dull" style="width:100%;
                    margin-top:6.5%;">
                        Reset password
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=1;
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss1" class="rtlft_inner_button" style="width:100%; display:none;">
                        Reset password
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=1;
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss1" class="rtlft_inner_button" style="width:100%;">
                        Reset password
                    </div>
                </a><?php
            }
        }*/
        
        if (check_scope3('Academic registry', 'Student request', 'Block student form') > 0 || 
        check_scope3('Learner support', 'Student request', 'Block student form') > 0 || 
        check_scope3('Technical support', 'Student request', 'Block student form') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='4')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                    Block
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=4;
                    in_progress('1');
                    sc_1_loc.action='block_unblock_students';
                    sc_1_loc.uvApplicationNo.value='';
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss4" class="rtlft_inner_button" style="width:100%; display:none;">
                        Block
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=4;
                    sc_1_loc.action='block_unblock_students';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss4" class="rtlft_inner_button" style="width:100%;">
                        Block
                    </div>
                </a><?php
            }
        }
        
        if (check_scope3('Academic registry', 'Student request', 'Unblock student form') > 0 || 
        check_scope3('Learner support', 'Student request', 'Unblock student form') > 0 || 
        check_scope3('Technical support', 'Student request', 'Unblock student form') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='5')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                    Unblock
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=5;
                    sc_1_loc.action='block_unblock_students';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Unblock
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=5;
                    sc_1_loc.action='block_unblock_students';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Unblock
                    </div>
                </a><?php
            }
        }
        
        /*if (check_scope3('Academic registry', 'Student request', 'Release form') > 0 || 
        check_scope3('Learner support', 'Student request', 'Release form') > 0 || 
        check_scope3('Technical support', 'Student request', 'Release form') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='6')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                    Release form
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=6;
                    sc_1_loc.action='let_go_of_form';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Release form
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=6;
                    sc_1_loc.action='let_go_of_form';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Release form
                    </div>
                </a><?php
            }
        }*/
        
        if (check_scope3('Academic registry', 'Student request', 'Activate matric no.') > 0 ||
        check_scope3('SPGS', 'Student request', 'Activate matric no.') > 0 ||   
        check_scope3('Learner support', 'Student request', 'Activate matric no.') > 0 || 
        check_scope3('Technical support', 'Student request', 'Activate matric no.') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='7')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Verify credentials
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=7;
                    sc_1_loc.action='verify_credentials';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Verify credentials
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=7;
                    sc_1_loc.action='verify_credentials';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Verify credentials
                    </div>
                </a><?php
            }
        }
        
        if (check_scope3('Technical support', 'Student request', 'Request mail account') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='14')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Request for eMail Account
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=14;
                    sc_1_loc.action='request_for_email_account';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Request for eMail Account
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=14;
                    sc_1_loc.action='request_for_email_account';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Request for eMail Account
                    </div>
                </a><?php
            }
        }
        
        //$currentDate = date('Y-m-d');
        //$req_close_date =  substr($orgsetins["student_req2"],4,4).'-'.substr($orgsetins["student_req2"],2,2).'-'.substr($orgsetins["student_req2"],0,2);
        
        $title = '';
        // if ($currentDate > $req_close_date && $req_close_date <> '--')
        // {
        //     $title = 'Request closed';
        // }
        
        if (check_scope3('Academic registry', 'Student request', 'Change programme') > 0 || 
        check_scope3('Learner support', 'Student request', 'Change programme') > 0 || 
        check_scope3('Technical support', 'Student request', 'Change programme') > 0)
        {
            if ($title <> '')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#f2f5f1;
                    color:#c6d5c8;" title="<?php echo $title;?>">
                        Change programme
                </div><?php                
            }else if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='8')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Change programme
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=8;
                    sc_1_loc.action='change_programme';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Change programme
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=8;
                    sc_1_loc.action='change_programme';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Change programme
                    </div>
                </a><?php
            }
        }

        if (check_scope3('Academic registry', 'Student request', 'Change study centre') > 0 || 
        check_scope3('Learner support', 'Student request', 'Change study centre') > 0 || 
        check_scope3('Technical support', 'Student request', 'Change study centre') > 0)
        {
            if ($title <> '')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#f2f5f1;
                    color:#c6d5c8;" title="<?php echo $title;?>">
                        Change study centre
                </div><?php                
            }else if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='9')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Change study centre
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=9;
                    sc_1_loc.action='change_study_center';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Change study centre
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=9;
                    sc_1_loc.action='change_study_center';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Change study centres
                    </div>
                </a><?php
            }
        }
        
        if (check_scope3('Academic registry', 'Student request', 'Change level') > 0 || 
        check_scope3('Learner support', 'Student request', 'Change level') > 0 || 
        check_scope3('Technical support', 'Student request', 'Change level') > 0)
        {
            
            if ($title <> '')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#f2f5f1;
                    color:#c6d5c8;" title="<?php echo $title;?>">
                        Change level
                </div><?php                
            }else if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='10')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Change level
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=10;
                    sc_1_loc.action='change_level';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Change level
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=10;
                    sc_1_loc.action='change_level';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Change level
                    </div>
                </a><?php
            }
        }
        
        if (check_scope3('Academic registry', 'Student request', 'Reset passport upload') > 0 || 
        check_scope3('Learner support', 'Student request', 'Reset passport upload') > 0 || 
        check_scope3('Technical support', 'Student request', 'Reset passport upload') > 0)
        {
            if ($title <> '')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#f2f5f1;
                    color:#c6d5c8;" title="<?php echo $title;?>">
                        Reset passport upload
                </div><?php                
            }else if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='11')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Reset passport upload
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=11;
                    sc_1_loc.action='reset_passport_upload';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Reset passport upload
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=11;
                    sc_1_loc.action='reset_passport_upload';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Reset passport upload
                    </div>
                </a><?php
            }
        }
        
        if (check_scope3('Academic registry', 'Student request', 'Update eMail address') > 0 || 
        check_scope3('Learner support', 'Student request', 'Update eMail address') > 0 || 
        check_scope3('Technical support', 'Student request', 'Update eMail address') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='12')
            {?>
                <div class="rtlft_inner_button_dull"
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Update eMail address
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=12;
                    sc_1_loc.action='update_student_email';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Update eMail address
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=12;
                    sc_1_loc.action='update_student_email';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Update eMail address
                    </div>
                </a><?php
            }
        }
        
        if (check_scope3('Academic registry', 'Student request', 'Drop course') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='15')
            {?>
                <div class="rtlft_inner_button_dull"
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Drop course
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=15;
                    sc_1_loc.action='drop_courses';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Drop course
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value=15;
                    sc_1_loc.action='drop_courses';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Drop course
                    </div>
                </a><?php
            }
        }

        if (check_scope3('Academic registry', 'Student request', 'Change prog cat') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='13')
            {?>
                <div class="rtlft_inner_button_dull" 
                style="background-color:#a6cda0;
                    color:#FFFFFF;">
                    Change prog. category
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value='13';
                    in_progress('1');
                    sc_1_loc.action='change_application_programme_category';
                    sc_1_loc.uvApplicationNo.value='';
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Change prog. category
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="sc_1_loc.whattodo.value='13';
                    sc_1_loc.action='change_application_programme_category';
                    sc_1_loc.uvApplicationNo.value='';
                    in_progress('1');
                    sc_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Change prog. category
                    </div>
                </a><?php
            }
        }
    }?>
</div>