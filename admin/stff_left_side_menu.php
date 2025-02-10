<div id="fac_menu" class="side_menu" style="display:<?php if ($mm == '0'){echo 'block';}else{echo 'none';}?>" style="position:relative"><?php
    if (check_scope2('Faculty','New admission criterion') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '1')
        {?>
            <div class="staff_left_side_button_dull">
                New admission criterion
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.mm.value=0;pgprgs.sm.value=1;in_progress('1'); pgprgs.submit(); return false">
                <div class="staff_left_side_button" style="margin-top:0px;">
                    New admission criterion
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    if (check_scope2('Faculty','Edit admission criterion') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '2')
        {?>
             <div class="staff_left_side_button_dull">
                Edit admission criterion
            </div><?php
        }else
        {?>	
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.mm.value=0;pgprgs.sm.value=2;in_progress('1'); pgprgs.submit(); return false">
                <div class="staff_left_side_button">
                    Edit admission criterion
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    if (check_scope2('Faculty','Toggle admission criterion') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '3')
        {?>
             <div class="staff_left_side_button_dull">
                Toggle admission criterion
            </div><?php
        }else
        {?>	
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.mm.value=0;pgprgs.sm.value=3;in_progress('1'); pgprgs.submit(); return false">
                <div class="staff_left_side_button">
                    Toggle admission criterion
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    if (check_scope2('Faculty','Admission') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '4')
        {?>
            <div class="staff_left_side_button_dull">
                Admission (Verify/Screen)
           </div><?php
        }else
        {?>	
            <a href="#" style="text-decoration:none;" 
                onclick="gln.mm.value=0;gln.sm.value=4;in_progress('1'); gln.submit(); return false">
                <div class="staff_left_side_button">
                    Admission (Verify/Screen)
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    if (check_scope2('Faculty','Delete admission criterion') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '5')
        {?>
            <div class="staff_left_side_button_dull">
                Delete admission criterion
           </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="pgprgs.mm.value=0;pgprgs.sm.value=5;in_progress('1'); pgprgs.submit(); return false">
                <div class="staff_left_side_button">
                    Delete admission criterion
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    if (check_scope2('Faculty','See admission criterion') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '6')
        {?>
            <div class="staff_left_side_button_dull">
                See admission criterion
           </div><?php
        }else
        {?>	
            <a href="#" style="text-decoration:none;" 
                onclick="crtrpt.mm.value=0;crtrpt.sm.value=6;in_progress('1'); crtrpt.submit(); return false">
                <div class="staff_left_side_button">
                    See admission criterion
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php

    if (check_scope2('Faculty','Faculties, departent, programmes') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '7')
        {?>
            <div class="staff_left_side_button_dull">
                Faculties, departments ...
           </div><?php
        }else
        {?>	
            <a href="#" style="text-decoration:none;" 
                onclick="setup_facult.mm.value=0;setup_facult.sm.value=7;in_progress('1'); setup_facult.submit(); return false">
                <div class="staff_left_side_button">
                    Faculties, departments ...
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php

    
    if (check_scope2('Faculty','See application record') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '8')
        {?>
            <div class="staff_left_side_button_dull">
                See application record
           </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=8;cf.uvApplicationNo.value='';in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See application record
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
                    
    if (check_scope2('Faculty','See student biodata') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '9')
        {?>
            <div class="staff_left_side_button_dull">
                See student's biodata
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=9;cf.uvApplicationNo.value='';in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See student's biodata
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    if (check_scope2('Faculty','See student academic record') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '10')
        {?>
            <div class="staff_left_side_button_dull">
                See student's academic record
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="std_acad_hist.sm.value=10;std_acad_hist.uvApplicationNo.value='';in_progress('1'); std_acad_hist.submit(); return false">
                <div class="staff_left_side_button">
                    See student's academic record
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    if (check_scope2('Faculty','See student account') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '11')
        {?>
            <div class="staff_left_side_button_dull">
                See student's account record
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="vw_std_acnt_stff.sm.value=11;vw_std_acnt_stff.uvApplicationNo.value='';in_progress('1'); vw_std_acnt_stff.submit(); return false">
                <div class="staff_left_side_button">
                    See student's account record
                </div>
            </a><?php
        }
    } 
    
    if (check_scope2('Faculty','Assessment result') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '12')
        {?>
            <div class="staff_left_side_button_dull">
                Assessment result
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="result_stff.sm.value=12;result_stff.uvApplicationNo.value='';in_progress('1'); result_stff.submit(); return false">
                <div class="staff_left_side_button">
                    Assessment result
                </div>
            </a><?php
        }
    }?>

    <a href="#" style="text-decoration:none;" 
        onclick="hpg.action='./staff_login_page';in_progress('1'); hpg.submit();return false">
        <div class="staff_left_side_logout_button" style="position:absolute; bottom:0; left:0">
            Logout
        </div>
    </a>
</div>				
        

<div id="reg_menu" class="side_menu" style="display:<?php if ($mm == '1'){echo 'block';}else{echo 'none';}?>" style="position:relative"><?php
    if (check_scope2('Academic registry','Reactivate application') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '14')
        {?>
            <div class="staff_left_side_button_dull">
                Reactivate application
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="recall_appl.sm.value=14;in_progress('1'); recall_appl.submit(); return false">
                <div class="staff_left_side_button">
                    Reactivate application
                </div>
            </a><?php
        }
    }
    
    if (check_scope2('Academic registry','Update biodata') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '2')
        {?>
            <div class="staff_left_side_button_dull">
                Update biodata
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="reg_grp1.sm.value=2;in_progress('1'); reg_grp1.submit(); return false">
                <div class="staff_left_side_button">
                    Update biodata
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php

    if (check_scope2('Academic registry','Update student credentials') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '3')
        {?>
            <div class="staff_left_side_button_dull">
                Update student's credentials
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="reg_grp1_1.sm.value=3;in_progress('1'); reg_grp1_1.submit(); return false">
                <div class="staff_left_side_button">
                    Update student's credentials
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php

    if (check_scope2('Academic registry','Student request') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '4')
        {?>
            <div class="staff_left_side_button_dull">
                Students' requests
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="sc_1.sm.value=4;in_progress('1'); sc_1.submit(); return false">
                <div class="staff_left_side_button">
                    Students' requests
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    /*if (check_scope2('Academic registry','See application form') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '5')
        {?>
            <div class="staff_left_side_button_dull">
                See application form
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=5;cf.uvApplicationNo.value='';in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See application form
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php

    /*if (check_scope2('Academic registry','See admission letter') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '6')
        {?>
            <div class="staff_left_side_button_dull">
                See admission letter
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=6;cf.uvApplicationNo.value='';in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See admission letter
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    /*if (check_scope2('Academic registry','See student biodata') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '7')
        {?>
            <div class="staff_left_side_button_dull">
                See student's biodata
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=7;in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See student's biodata
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    /*if (check_scope2('Academic registry','See student academic record') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '8')
        {?>
            <div class="staff_left_side_button_dull">
                See student's academic record
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="std_acad_hist.sm.value=8;std_acad_hist.uvApplicationNo.value='';in_progress('1'); std_acad_hist.submit(); return false">
                <div class="staff_left_side_button">
                    See student's academic record
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    /*if (check_scope2('Academic registry','See student account') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '9')
        {?>
            <div class="staff_left_side_button_dull">
                See student's account
            </div><?php
        }else
        {?>	
            <a href="#" style="text-decoration:none;" 
                onclick="vw_std_acnt_stff.sm.value=9;vw_std_acnt_stff.uvApplicationNo.value='';in_progress('1'); vw_std_acnt_stff.submit(); return false">
                <div class="staff_left_side_button">
                    See student's account
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php

    if (check_scope2('Academic registry','Correctional facility') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '10')
        {?>
            <div class="staff_left_side_button_dull">
                Correctional facilities
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="rectional.sm.value=10;in_progress('1'); rectional.submit(); return false">
                <div class="staff_left_side_button">
                    Correctional facilities
                </div>
            </a><?php
        }
    }
    
    if (check_scope2('Academic registry','Send message to students') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '12')
        {?>
            <div class="staff_left_side_button_dull">
                Students' notice board
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="student_msg.sm.value=12;student_msg.uvApplicationNo.value='';in_progress('1'); student_msg.submit(); return false">
                <div class="staff_left_side_button">
                    Students' notice board
                </div>
            </a><?php
        }
    }   
    
    
    if (check_scope2('Academic registry','Unarchive') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '13')
        {?>
            <div class="staff_left_side_button_dull">
                Archive/Unarchive
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="unarch.sm.value='13';unarch.uvApplicationNo.value='';in_progress('1'); unarch.submit(); return false">
                <div class="staff_left_side_button">
                    Archive/Unarchive
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php

    if (check_scope2('Academic registry','Settings') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '11')
        {?>
            <div class="staff_left_side_button_dull">
                Settings
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="opsions.sm.value=11;in_progress('1'); opsions.submit(); return false">
                <div class="staff_left_side_button">
                    Settings
                </div>
            </a><?php
        }
    }?>

    <a href="#" style="text-decoration:none;" 
        onclick="hpg.action='./staff_login_page';in_progress('1'); hpg.submit();return false">
        <div class="staff_left_side_logout_button" style="position:absolute; bottom:0; left:0">
            Logout
        </div>
    </a>
</div>				
        

<div id="spgs_menu" class="side_menu" style="display:<?php if ($mm == '8'){echo 'block';}else{echo 'none';}?>" style="position:relative"><?php
    if (check_scope2('SPGS','Update biodata') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '2')
        {?>
            <div class="staff_left_side_button_dull">
                Update biodata
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="reg_grp1.sm.value=2;in_progress('1'); reg_grp1.submit(); return false">
                <div class="staff_left_side_button">
                    Update biodata
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php

    if (check_scope2('SPGS','Update student credentials') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '3')
        {?>
            <div class="staff_left_side_button_dull">
                Update student's credentials
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="reg_grp1_1.sm.value=3;in_progress('1'); reg_grp1_1.submit(); return false">
                <div class="staff_left_side_button">
                    Update student's credentials
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php

    if (check_scope2('SPGS','Student request') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '4')
        {?>
            <div class="staff_left_side_button_dull">
                Students' requests
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="sc_1.sm.value=4;in_progress('1'); sc_1.submit(); return false">
                <div class="staff_left_side_button">
                    Students' requests
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    /*if (check_scope2('SPGS','See application form') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '5')
        {?>
            <div class="staff_left_side_button_dull">
                See application form
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=5;cf.uvApplicationNo.value='';in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See application form
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php

    /*if (check_scope2('SPGS','See admission letter') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '6')
        {?>
            <div class="staff_left_side_button_dull">
                See admission letter
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=6;cf.uvApplicationNo.value='';in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See admission letter
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    /*if (check_scope2('SPGS','See student biodata') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '7')
        {?>
            <div class="staff_left_side_button_dull">
                See student's biodata
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=7;in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See student's biodata
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    /*if (check_scope2('SPGS','See student academic record') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '8')
        {?>
            <div class="staff_left_side_button_dull">
                See student's academic record
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="std_acad_hist.sm.value=8;std_acad_hist.uvApplicationNo.value='';in_progress('1'); std_acad_hist.submit(); return false">
                <div class="staff_left_side_button">
                    See student's academic record
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    /*if (check_scope2('SPGS','See student account') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '9')
        {?>
            <div class="staff_left_side_button_dull">
                See student's aaccount
            </div><?php
        }else
        {?>	
            <a href="#" style="text-decoration:none;" 
                onclick="vw_std_acnt_stff.sm.value=9;vw_std_acnt_stff.uvApplicationNo.value='';in_progress('1'); vw_std_acnt_stff.submit(); return false">
                <div class="staff_left_side_button">
                    See student's account
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php

    if (check_scope2('SPGS','Correctional facility') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '10')
        {?>
            <div class="staff_left_side_button_dull">
                Reformatory facilities
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="rectional.sm.value=10;in_progress('1'); rectional.submit(); return false">
                <div class="staff_left_side_button">
                    Reformatory facilities
                </div>
            </a><?php
        }
    }
    
    if (check_scope2('SPGS','Send message to students') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '12')
        {?>
            <div class="staff_left_side_button_dull">
                Students' notice board
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="student_msg.sm.value=12;in_progress('1'); student_msg.submit(); return false">
                <div class="staff_left_side_button">
                    Students' notice board
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php

    if (check_scope2('SPGS','Admission') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '13')
        {?>
            <div class="staff_left_side_button_dull">
                Admission (Verify/Screen)
        </div><?php
        }else
        {?>	
            <a href="#" style="text-decoration:none;" 
                onclick="gln.mm.value=8;gln.sm.value=13;in_progress('1'); gln.submit(); return false">
                <div class="staff_left_side_button">
                    Admission (Verify/Screen)
                </div>
            </a><?php
        }
    }?>

    <a href="#" style="text-decoration:none;" 
        onclick="hpg.action='./staff_login_page';in_progress('1'); hpg.submit();return false">
        <div class="staff_left_side_logout_button" style="position:absolute; bottom:0; left:0">
            Logout
        </div>
    </a>
</div>


<div id="bur_menu" class="side_menu" style="display:<?php if ($mm == '2'){echo 'block';}else{echo 'none';}?>" style="position:relative"><?php				    
    if (check_scope2('Bursary','Check payment satatus') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '1')
        {?>
            <div class="staff_left_side_button_dull">Check payment status</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="chk_pay_sta.sm.value=1;in_progress('1'); chk_pay_sta.submit(); return false">
                <div class="staff_left_side_button">
                    Check payment status
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php

    /*if (check_scope2('Bursary','See student account') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '2')
        {?>
            <div class="staff_left_side_button_dull">See student's account</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="vw_std_acnt_stff.sm.value=2;vw_std_acnt_stff.uvApplicationNo.value='';in_progress('1'); vw_std_acnt_stff.submit(); return false">
                <div class="staff_left_side_button">
                    See student's account
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    
    /*if (check_scope2('Bursary','See student academic record') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '3')
        {?>
            <div class="staff_left_side_button_dull">
                See student's academic record
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="std_acad_hist.sm.value=3;std_acad_hist.uvApplicationNo.value='';in_progress('1'); std_acad_hist.submit(); return false">
                <div class="staff_left_side_button">
                    See student's academic record
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    /*if (check_scope2('Bursary','4') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '4')
        {?>
            <div class="staff_left_side_button_dull">Reverse transaction</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="rev_sactn.sm.value=4;rev_sactn.submit(); return false">
                <div class="staff_left_side_button">
                    Reverse transaction
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    if (check_scope2('Bursary','Adjust balance') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '5')
        {?>
            <div class="staff_left_side_button_dull">Adjust balance</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="adj_bal.sm.value=5;in_progress('1'); adj_bal.submit(); return false">
                <div class="staff_left_side_button">
                    Adjust balance
                </div>
            </a><?php
        }
    }
    
    
    if (check_scope2('Bursary','Adjust opening balance') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '14')
        {?>
            <div class="staff_left_side_button_dull">Adjust opening balance</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="opn_bal.sm.value=14;in_progress('1'); opn_bal.submit(); return false">
                <div class="staff_left_side_button">
                    Adjust opening balance
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    
    if (check_scope2('Bursary','Fee structure') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '6')
        {?>
            <div class="staff_left_side_button_dull">Fee structure</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="selitems.show_all_burs.value=0;selitems.sm.value=6;selitems.study_mode0.value='';in_progress('1'); selitems.submit(); return false">
                <div class="staff_left_side_button">
                    Fee structure
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    /*if (check_scope2('Bursary','See application form') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '7')
        {?>
            <div class="staff_left_side_button_dull">See application form</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=7;cf.uvApplicationNo.value='';in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See application form
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    /*if (check_scope2('Bursary','See admission letter') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '8')
        {?>
            <div class="staff_left_side_button_dull">See admission letter</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=8;cf.uvApplicationNo.value='';in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See admission letter
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    /*if (check_scope2('Bursary','Fund account') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '12')
        {?>
            <div class="staff_left_side_button_dull">Fund account</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="f_account.sm.value=12;in_progress('1'); f_account.submit(); return false">
                <div class="staff_left_side_button">
                    Fund account
                </div>
            </a><?php
        }
    }*/
    
    if (check_scope2('Bursary','Clearance') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '9')
        {?>
            <div class="staff_left_side_button_dull">Clearance</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="clearance.sm.value=9;in_progress('1'); clearance.submit(); return false">
                <div class="staff_left_side_button">
                Clearance
                </div>
            </a><?php
        }
    }

    if (check_scope2('Bursary','Gown refund') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '15')
        {?>
            <div class="staff_left_side_button_dull">Gown refund</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="gown_ref.sm.value=15;in_progress('1'); gown_ref.submit(); return false">
                <div class="staff_left_side_button">
                    Gown refund
                </div>
            </a><?php
        }
    }
    
    if (check_scope2('Bursary','Rectify RRR') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '13')
        {?>
            <div class="staff_left_side_button_dull">Rectify RRR</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="rect_payment.sm.value=13;in_progress('1'); rect_payment.submit(); return false">
                <div class="staff_left_side_button">
                    Rectify RRR
                </div>
            </a><?php
        }
    }
    
    if (check_scope2('Bursary','New students balance') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '16')
        {?>
            <div class="staff_left_side_button_dull">New students balance</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="student_balances.sm.value=16;in_progress('1'); student_balances.submit(); return false">
                <div class="staff_left_side_button">
                    	New students balance
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php		
    
    if (check_scope2('Bursary','Settings') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '10')
        {?>
            <div class="staff_left_side_button_dull">Settings</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="opsions.sm.value=10;in_progress('1'); opsions.submit(); return false">
                <div class="staff_left_side_button">
                    Settings
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    if (check_scope2('Bursary','Report') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '11')
        {?>
            <div class="staff_left_side_button_dull">Report</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="b_report.sm.value=11;in_progress('1'); b_report.submit(); return false">
                <div class="staff_left_side_button">
                    Report
                </div>
            </a><?php
        }
    }?>

    <a href="#" style="text-decoration:none;" 
        onclick="hpg.action='./staff_login_page';in_progress('1'); hpg.submit();return false">
        <div class="staff_left_side_logout_button" style="position:absolute; bottom:0; left:0">
            Logout
        </div>
    </a>
</div>


<div id="sc_menu" class="side_menu" style="display:<?php if ($mm == '3'){echo 'block';}else{echo 'none';}?>" style="position:relative"><?php
    /*if (check_scope2('Learner support','Student request') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '1')
        {?>
            <div class="staff_left_side_button_dull">
                Students' requests
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="sc_1.sm.value=1;in_progress('1'); sc_1.submit(); return false">
                <div class="staff_left_side_button">
                    Students' request
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    if (check_scope2('Learner support','See application form') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '2')
        {?>
            <div class="staff_left_side_button_dull">
                See application form
            </div><?php
        }else
        {?>	
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=2;cf.uvApplicationNo.value='';in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See application form
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    if (check_scope2('Learner support','See admission letter') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '3')
        {?>
            <div class="staff_left_side_button_dull">
                See admision letter
            </div><?php
        }else
        {?>	
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=3;cf.uvApplicationNo.value='';in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See admision letter
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    if (check_scope2('Learner support','See student biodata') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '4')
        {?>
            <div class="staff_left_side_button_dull">
                See student's biodata
            </div><?php
        }else
        {?>	
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=4;in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See student's biodata
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    if (check_scope2('Learner support','See student academic record') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '5')
        {?>
            <div class="staff_left_side_button_dull">
                See student's academic record
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="std_acad_hist.sm.value=5;in_progress('1'); std_acad_hist.submit(); return false">
                <div class="staff_left_side_button">
                    See student's academic record
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    if (check_scope2('Learner support','Check payment satatus') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '6')
        {?>
            <div class="staff_left_side_button_dull">
                Check payment status
            </div><?php
        }else
        {?>	
            <a href="#" style="text-decoration:none;" 
                onclick="chk_pay_sta.sm.value=6;in_progress('1'); chk_pay_sta.submit(); return false">
                <div class="staff_left_side_button">
                    Check payment status
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    if (check_scope2('Learner support','See student account') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '7')
        {?>
            <div class="staff_left_side_button_dull">
                See student's account
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="vw_std_acnt_stff.sm.value=7;in_progress('1'); vw_std_acnt_stff.submit(); return false">
                <div class="staff_left_side_button">
                    See student's account
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    if (check_scope2('Learner support','See student status') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '8')
        {?>
            <div class="staff_left_side_button_dull">See student's status</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="std_stat.sm.value=8;in_progress('1'); std_stat.submit(); return false">
                <div class="staff_left_side_button">
                    See student's status
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    if (check_scope2('Learner support','Study centre') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '9')
        {?>
            <div class="staff_left_side_button_dull">Study centre</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="study_cnetre.sm.value=9; in_progress('1'); study_cnetre.submit(); return false">
                <div class="staff_left_side_button">
                    Study centre
                </div>
            </a><?php
        }
    }
    
    if (check_scope2('Learner support','Inmate') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '11')
        {?>
            <div class="staff_left_side_button_dull">Inmate</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="mgt_inmates.uvApplicationNo.value=''; mgt_inmates.sm.value=11; in_progress('1'); mgt_inmates.submit(); return false">
                <div class="staff_left_side_button">
                    Inmate
                </div>
            </a><?php
        }
    }
    
    
    if (check_scope2('Learner support','Send message to students') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '10')
        {?>
            <div class="staff_left_side_button_dull">
                Students' notice board
            </div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="student_msg.sm.value=10;in_progress('1'); student_msg.submit(); return false">
                <div class="staff_left_side_button">
                    Students' notice board
                </div>
            </a><?php
        }
    }?>

    <a href="#" style="text-decoration:none;" 
        onclick="hpg.action='./staff_login_page';in_progress('1'); hpg.submit();return false">
        <div class="staff_left_side_logout_button" style="position:absolute; bottom:0; left:0">
            Logout
        </div>
    </a>
</div>


<div id="enq_menu" class="side_menu" style="display:<?php if ($mm == '4'){echo 'block';}else{echo 'none';}?>" style="position:relative"><?php
     if (check_scope2('Enquiry','See admission criterion') > 0)
     {
         if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '10')
         {?>
             <div class="staff_left_side_button_dull">
                 See admission criterion
            </div><?php
         }else
         {?>	
             <a href="#" style="text-decoration:none;" 
                 onclick="pgprgs.mm.value=0;crtrpt.sm.value=10;in_progress('1'); crtrpt.submit(); return false">
                 <div class="staff_left_side_button">
                     See admission criterion
                 </div>
             </a><?php
         }
     }
     
    if (check_scope2('Enquiry','See application form') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '1')
        {?>
            <div class="staff_left_side_button_dull">See application form</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=1;cf.uvApplicationNo.value='';in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See application form
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    if (check_scope2('Enquiry','See admission letter') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '2')
        {?>
            <div class="staff_left_side_button_dull">See admission letter</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=2;cf.uvApplicationNo.value='';in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See admission letter
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    if (check_scope2('Enquiry','See student biodata') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '3')
        {?>
            <div class="staff_left_side_button_dull">See student's biodata</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=3;cf.uvApplicationNo.value='';in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See student's biodata
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    if (check_scope2('Enquiry','See student academic record') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '4')
        {?>
            <div class="staff_left_side_button_dull">See student's academic record</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="std_acad_hist.sm.value=4;in_progress('1'); std_acad_hist.submit(); return false">
                <div class="staff_left_side_button">
                    See student's academic record
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    if (check_scope2('Enquiry','Check payment satatus') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '5')
        {?>
            <div class="staff_left_side_button_dull">Check payment status</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="chk_pay_sta.sm.value=5;in_progress('1'); chk_pay_sta.submit(); return false">
                <div class="staff_left_side_button">
                    Check payment status
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    if (check_scope2('Enquiry','See student account') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '6')
        {?>
            <div class="staff_left_side_button_dull">See student's account</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="vw_std_acnt_stff.sm.value=6;vw_std_acnt_stff.uvApplicationNo.value='';in_progress('1'); vw_std_acnt_stff.submit(); return false">
                <div class="staff_left_side_button">
                    See student's account
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    if (check_scope2('Enquiry','See student status') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '7')
        {?>
            <div class="staff_left_side_button_dull">See student's status</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="std_stat.sm.value=7;in_progress('1'); std_stat.submit(); return false">
                <div class="staff_left_side_button">
                    See student's status
                </div>
            </a><?php
        }
    }
    
    
    if (isset($_REQUEST['vApplicationNo']) && $_REQUEST['vApplicationNo'] == '00062')
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '8')
        {?>
            <div class="staff_left_side_button_dull">Adjust</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="adjust.sm.value=8;in_progress('1'); adjust.submit(); return false">
                <div class="staff_left_side_button">
                    Adjust
                </div>
            </a><?php
        }
        
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '10')
        {?>
            <div class="staff_left_side_button_dull">Force hanging payment</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="anavail.sm.value=10;in_progress('1'); anavail.submit(); return false">
                <div class="staff_left_side_button">
                    Force hanging payment
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    /*if (check_scope2('Enquiry','Retrieve password') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '8')
        {?>
            <div class="staff_left_side_button_dull">Retrieve password</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="enq_pwd.sm.value=8;enq_pwd.whattodo.value=0; enq_pwd.submit(); return false">
                <div class="staff_left_side_button">
                    Retrieve password
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    /*if (check_scope2('Enquiry','Reset password') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '9')
        {?>
            <div class="staff_left_side_button_dull">Reset password</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="enq_pwd.sm.value=9;enq_pwd.whattodo.value=1; enq_pwd.submit(); return false">
                <div class="staff_left_side_button">
                    Reset password
                </div>
            </a><?php
        }
    }*/?>

    <a href="#" style="text-decoration:none;" 
        onclick="hpg.action='./staff_login_page';in_progress('1'); hpg.submit();return false">
        <div class="staff_left_side_logout_button" style="position:absolute; bottom:0; left:0">
            Logout
        </div>
    </a>
</div>


<div id="tec_menu" class="side_menu" style="display:<?php if ($mm == '5'){echo 'block';}else{echo 'none';}?>" style="position:relative"><?php
    if (check_scope2('Technical Support','Student request') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '1')
        {?>
            <div class="staff_left_side_button_dull">Students' requests</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="sc_1.sm.value=1;in_progress('1'); sc_1.submit(); return false">
                <div class="staff_left_side_button">
                    Students' requests
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    /*if (check_scope2('Technical Support','See application form') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '2')
        {?>
            <div class="staff_left_side_button_dull">See application form</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=2; in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See application form
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    /*if (check_scope2('Technical Support','See admission letter') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '3')
        {?>
            <div class="staff_left_side_button_dull">See admission letter</div><?php
        }else
        {?>	
            <a href="#" style="text-decoration:none;" 
                onclick="cf.sm.value=3; in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                    See admission letter
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    /*if (check_scope2('Technical Support','See student biodata') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '4')
        {?>
            <div class="staff_left_side_button_dull">See student's biodata</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="cf.uvApplicationNo.value='';cf.sm.value=4;in_progress('1'); cf.submit(); return false">
                <div class="staff_left_side_button">
                See student's biodata
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    /*if (check_scope2('Technical Support','See student academic record') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '5')
        {?>
            <div class="staff_left_side_button_dull">See student's academic record</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="std_acad_hist.uvApplicationNo.value='';std_acad_hist.sm.value=5;in_progress('1'); std_acad_hist.submit(); return false">
                <div class="staff_left_side_button">
                    See student's academic record
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    
    /*if (check_scope2('Technical Support','Check payment satatus') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '6')
        {?>
            <div class="staff_left_side_button_dull">Check payment status</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="chk_pay_sta.sm.value=6;in_progress('1'); chk_pay_sta.submit(); return false">
                <div class="staff_left_side_button">
                    Check payment status
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    /*if (check_scope2('Technical Support','See student account') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '7')
        {?>
            <div class="staff_left_side_button_dull">See student's account</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="vw_std_acnt_stff.sm.value=7;in_progress('1'); vw_std_acnt_stff.submit(); return false">
                <div class="staff_left_side_button">
                    See student's account
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    /*if (check_scope2('Technical Support','See student status') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '8')
        {?>
            <div class="staff_left_side_button_dull">See student's status</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="std_stat.sm.value=8;in_progress('1'); std_stat.submit(); return false">
                <div class="staff_left_side_button">
                    See student's status
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
                    
    if (check_scope2('Technical Support',"VC's request") > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '9')
        {?>
            <div class="staff_left_side_button_dull">VC's request</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="vc_request.sm.value=9;in_progress('1'); vc_request.submit(); return false">
                <div class="staff_left_side_button">
                    VC's request
                </div>
            </a><?php
        }
    }
    
                    
    /*if (check_scope2('Technical Support',"Paid application") > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '11')
        {?>
            <div class="staff_left_side_button_dull">Paid application</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="skolasip.sm.value=11;in_progress('1'); skolasip.submit(); return false">
                <div class="staff_left_side_button">
                    Paid application
                </div>
            </a><?php
        }
    }*/
    
    if (check_scope2('Technical Support',"Logout all") > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '10')
        {?>
            <div class="staff_left_side_button_dull">Logout all users</div><?php
        }else
        {?>
            <a href="#" style="text-decoration:none;" 
                onclick="l_all_user.sm.value=10;in_progress('1'); l_all_user.submit(); return false">
                <div class="staff_left_side_button">
                    Logout all users
                </div>
            </a><?php
        }
    }?>

    <a href="#" style="text-decoration:none;" 
        onclick="hpg.action='./staff_login_page';in_progress('1'); hpg.submit();return false">
        <div class="staff_left_side_logout_button" style="position:absolute; bottom:0; left:0">
            Logout
        </div>
    </a>
</div>

<div id="rpt_menu" class="side_menu" style="display:<?php if ($mm == '6'){echo 'block';}else{echo 'none';}?>" style="position:relative"><?php
    if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '1')
    {?>
        <div class="staff_left_side_button_dull">Distributions</div><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="rpt_1.whattodo.value=''; rpt_1.sm.value=1;in_progress('1'); rpt_1.submit();
            return false">
            <div class="staff_left_side_button">
                Distributions
            </div>
        </a><?php
    }
    
    if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '2')
    {?>
        <div class="staff_left_side_button_dull">List</div><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="rpt_1.whattodo.value=''; rpt_1.sm.value=2;in_progress('1'); rpt_1.submit();
            return false">
            <div class="staff_left_side_button">
                List
            </div>
        </a><?php
    }
    
    if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '3')
    {?>
        <div class="staff_left_side_button_dull">Custom</div><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="rpt_1.whattodo.value=''; rpt_1.sm.value=3;in_progress('1'); rpt_1.submit();
            return false">
            <div class="staff_left_side_button">
                Custom
            </div>
        </a><?php
    }
    
    /*if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '4')
    {?>
        <div class="staff_left_side_button_dull">Title</div><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="rpt_1.sm.value=4;in_progress('1'); rpt_1.submit();
            return false">
            <div class="staff_left_side_button">
                Title
            </div>
        </a><?php
    }*/?>

    <a href="#" style="text-decoration:none;" 
        onclick="hpg.action='./staff_login_page';in_progress('1'); hpg.submit();return false">
        <div class="staff_left_side_logout_button" style="position:absolute; bottom:0; left:0">
            Logout
        </div>
    </a>
</div>

<!--<div id="rpt_menu" class="side_menu" style="display:<?php if ($mm == '6'){echo 'block';}else{echo 'none';}?>" style="position:relative"><?php
    if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '1')
    {?>
        <div class="staff_left_side_button_dull">Step 1 - Type of report</div><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="<?php if(isset($_REQUEST['sm']) && $_REQUEST['sm'] <> '')
            {?>
                rpts1_loc.sm.value=1;
                _('rpts1_loc').target = '_self';
                _('rpts1_loc').action = '';
                in_progress('1'); rpts1_loc.submit();<?php
            }else
            {?>
                rpts1.sm.value=1;rpts1.submit();<?php
            }?>;
            tab_modify_rpts(1,'Step 1 - Set Type of Report');
            return false">
            <div class="staff_left_side_button">
                Step 1 Type of report
            </div>
        </a><?php
    }
    
    if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '2')
    {?>
        <div class="staff_left_side_button_dull">Step 2 - Columns</div><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="rpts1_loc.sm.value=2;
                _('rpts1_loc').target = '_self';
                _('rpts1_loc').action = '';
                in_progress('1'); rpts1_loc.submit();return false">
            <div class="staff_left_side_button">
            Step 2 - Columns
            </div>
        </a><?php
    }
    
    if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '3')
    {?>
        <div class="staff_left_side_button_dull">Stept 3 - Sorting</div><?php
    }else
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="rpts1_loc.sm.value=3;
                _('rpts1_loc').target = '_self';
                _('rpts1_loc').action = '';
                in_progress('1'); rpts1_loc.submit();
                return false">
            <div class="staff_left_side_button">
                Stept 3 - Sorting
            </div>
        </a><?php
    }
    
    if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '4')
    {?>
        <div class="staff_left_side_button_dull">Criteria</div><?php
    }else 
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="rpts1_loc.sm.value=4;
            _('rpts1_loc').target = '_self';
            _('rpts1_loc').action = '';
            in_progress('1'); rpts1_loc.submit();
            return false">
            <div class="staff_left_side_button">
                Step 4 - Criteria
            </div>
        </a><?php
    }
    
    if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '5')
    {?>
        <div class="staff_left_side_button_dull">Title</div><?php
    }else 
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="rpts1_loc.sm.value=5;
                _('rpts1_loc').target = '_self';
                _('rpts1_loc').action = '';
                in_progress('1'); rpts1_loc.submit();return false">
            <div class="staff_left_side_button">
                Step 5 - Title
            </div>
        </a><?php
    }?>

    <a href="#" style="text-decoration:none;" 
        onclick="hpg.action='./staff_login_page';in_progress('1'); hpg.submit();return false">
        <div class="staff_left_side_logout_button" style="position:absolute; bottom:0; left:0">
            Logout
        </div>
    </a>
</div>-->


<div id="adm_menu" class="side_menu" style="display:<?php if ($mm == '7'){echo 'block';}else{echo 'none';}?>" style="position:relative"><?php 
    if (check_scope2('System Admin','Role') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '1')
        {?>
            <div class="staff_left_side_button_dull">Role</div><?php
        }else 
        {?>	
            <a href="#" style="text-decoration:none;" 
                onclick="manag.sm.value=1;
                in_progress('1'); manag.submit();return false">
                <div class="staff_left_side_button">
                    Role
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php
    if (check_scope2('System Admin','User') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '2')
        {?>
            <div class="staff_left_side_button_dull">User account</div><?php
        }else
        {?>		
            <a href="#" style="text-decoration:none;" 
                onclick="manag.sm.value=2;in_progress('1');manag.submit();return false">
                <div class="staff_left_side_button">
                    User account
                </div>
            </a><?php
        }
    }?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php			
    /*if (check_scope2('System Admin','Reset password') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '3')
        {?>
            <div class="staff_left_side_button_dull">Reset password</div><?php
        }else
        {?>		
            <a href="#" style="text-decoration:none;" 
                onclick="manag_user_acc.sm.value=3;in_progress('1'); manag_user_acc.submit();return false">
                <div class="staff_left_side_button">
                    Reset password
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php			
    /*if (check_scope2('System Admin','Retrieve passowrd') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '4')
        {?>
            <div class="staff_left_side_button_dull">Retrieve password</div><?php
        }else
        {?>		
            <a href="#" style="text-decoration:none;" 
                onclick="manag_user_acc.sm.value=4;in_progress('1'); manag_user_acc.submit();return false">
                <div class="staff_left_side_button">
                    Retrieve password
                </div>
            </a><?php
        }
    }*/?>
    <!--<hr style="background-image:linear-gradient(90deg, #a8c1aa, transparent, #a8c1aa); border:0; width:99.9%; float:left; height:0.8px; margin:0px" />--><?php			
    if (check_scope2('System Admin','Settings') > 0)
    {
        if (isset($_REQUEST['sm']) && $_REQUEST['sm'] == '5')
        {?>
            <div class="staff_left_side_button_dull">Options/Settings</div><?php
        }else
        {?>		
            <a href="#" style="text-decoration:none;" 
                onclick="opsions.sm.value=5;in_progress('1'); opsions.submit();return false">
                <div class="staff_left_side_button">
                    Options/Settings
                </div>
            </a><?php
        }
    }?>

    <a href="#" style="text-decoration:none;" 
        onclick="hpg.action='./staff_login_page';in_progress('1'); hpg.submit();return false">
        <div class="staff_left_side_logout_button" style="position:absolute; bottom:0; left:0">
            Logout
        </div>
    </a>
</div>


<div id="empty_menu" class="sidemenu" 
    style="float:left; padding:0px; width:100%; height:100%; position:relative; display:<?php if (!isset($mm)||(isset($mm)&&$mm=='')){echo 'block';}else{echo 'none';}?>;">    
    <div class="submit_button_brown_std_home">Faculty</div>
    <div class="submit_button_brown_std_home">Registry</div>
    <div class="submit_button_brown_std_home">SPGS</div>
    <div class="submit_button_brown_std_home">Bursary</div>    
    <div class="submit_button_brown_std_home">Learner support</div>
    <div class="submit_button_brown_std_home">Enquiry</div>
    <div class="submit_button_brown_std_home">Technical support</div>
    <div class="submit_button_brown_std_home">Report</div>
    <div class="submit_button_brown_std_home">Admin</div>
    <a href="#" style="text-decoration:none;" 
        onclick="hpg.action='./staff_login_page';in_progress('1'); hpg.submit();return false">
        <div class="staff_left_side_logout_button" style="line-height:2; position:absolute; bottom:0; left:0">
            Logout
        </div>
    </a>
</div>