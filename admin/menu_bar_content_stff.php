<?php
if (check_scope1('Faculty') <> 0)
{
    if ($mm == '0')
    {?>
        <div class="dull_stff_mm_btns">Faculty</div><?php
    }else
    {?>    
        <a href="#" style="text-decoration:none;" 
            onclick="nxt.uvApplicationNo.value='';
            nxt.mm_desc.value='Faculty'; 
            nxt.mm.value=0;
            nxt.sm.value=''; 
            nxt.sm_desc.value='';
            nxt.submit(); false">
            <div class="stff_mm_btns">
                Faculty
            </div>
        </a><?php
    }
}


if (check_scope1('Academic registry') <> 0)
{
    if ($mm == '1')
    {?>
        <div class="dull_stff_mm_btns" title="Academic Registry">Academic Registry</div><?php
    }else 
    {?>    
        <a href="#" style="text-decoration:none;" 
            onclick="nxt.uvApplicationNo.value='';
            nxt.mm_desc.value='Academic registry'; 
            nxt.mm.value=1; 
            nxt.sm.value=''; 
            nxt.sm_desc.value='';
            nxt.submit(); false">
            <div class="stff_mm_btns" title="Academic Registry">
                Academic Registry
            </div>
        </a><?php
    }
}


//if (check_scope1('Academic registry') <> 0 && (stfn_role_id('6') == 1 || stfn_role_id('27') == 1))
if (check_scope1('SPGS') <> 0)
{
    if ($mm == '8')
    {?>
        <div class="dull_stff_mm_btns" title="School of Postgraduate Studies">SPGS</div><?php
    }else 
    {?>    
        <a href="#" style="text-decoration:none;" 
            onclick="nxt.action='manage_pg_students';
            nxt.uvApplicationNo.value='';
            nxt.mm_desc.value='SPGS';
            nxt.mm.value=8; 
            nxt.sm.value='';  
            nxt.sm_desc.value='';
            nxt.submit(); false">
            <div class="stff_mm_btns" title="School of Postgraduate Studies">
                SPGS
            </div>
        </a><?php
    }
}


if (check_scope1('Bursary') <> 0)
{
    if ($mm == '2')
    {?>
        <div class="dull_stff_mm_btns">Bursary</div><?php
    }else  if (check_scope1('Bursary') <> 0)
    {?>   
        <a href="#" style="text-decoration:none;" 
            onclick="nxt.uvApplicationNo.value='';
            nxt.mm_desc.value='Bursary';
            nxt.mm.value=2; 
            nxt.sm.value='';  
            nxt.sm_desc.value='';
            nxt.submit(); false">
            <div class="stff_mm_btns">
                Bursary
            </div>
        </a><?php
    }
}


if (check_scope1('Learner support') <> 0)
{
    if ($mm == '3')
    {?>
        <div class="dull_stff_mm_btns" title="Learner support">Learner support</div><?php
    }else
    {?>  
        <a href="#" style="text-decoration:none;" 
            onclick="nxt.uvApplicationNo.value='';
            nxt.mm_desc.value='Learner support';
            nxt.mm.value=3; 
            nxt.sm.value='';  
            nxt.sm_desc.value='';
            nxt.submit(); 
            false">
            <div class="stff_mm_btns" title="Learner support">
                Learner support
            </div>
        </a><?php
    }
}


if (check_scope1('Enquiry') <> 0)
{
    if ($mm == '4')
    {?>
        <div class="dull_stff_mm_btns">Enquiry</div><?php
    }else
    {?> 
        <a href="#" style="text-decoration:none;" 
            onclick="nxt.uvApplicationNo.value='';
            nxt.mm_desc.value='Enquiry';
            nxt.mm.value=4; 
            nxt.sm.value='';  
            nxt.sm_desc.value='';
            nxt.submit(); false">
            <div class="stff_mm_btns">
                Enquiry
            </div>
        </a><?php
    }
}


if (check_scope1('Technical Support') <> 0)
{
    if ($mm == '5')
    {?>
        <div class="dull_stff_mm_btns" title="Technical Support">Technical Support</div><?php
    }else  if (check_scope1('Technical Support') <> 0)
    {?>    
        <a href="#" style="text-decoration:none;" 
            onclick="nxt.uvApplicationNo.value='';
            nxt.mm_desc.value='Technical support';
            nxt.mm.value=5; 
            nxt.sm.value='';  
            nxt.sm_desc.value='';
            nxt.submit(); false">
            <div class="stff_mm_btns" title="Technical Support">
                Technical Support
            </div>
        </a><?php
    }
}


if (check_scope1('Report') <> 0)
{
    if ($mm == '6')
    {?>
        <div class="dull_stff_mm_btns">Report</div><?php
    }else
    {?>    
        <a href="#" style="text-decoration:none;" 
            onclick="nxt.uvApplicationNo.value='';
            nxt.mm_desc.value='Report';
            nxt.mm.value=6; 
            nxt.sm.value='';  
            nxt.sm_desc.value='';
            nxt.submit(); false">
            <div class="stff_mm_btns">
                Report
            </div>
        </a><?php
    }
}


if (check_scope1('System Admin') <> 0)
{
    if ($mm == '7')
    {?>
        <div class="dull_stff_mm_btns">Admin</div><?php
    }else
    {?>    
        <a href="#" style="text-decoration:none;" 
            onclick="nxt.uvApplicationNo.value='';
            nxt.mm_desc.value='System admin';
            nxt.mm.value=7; 
            nxt.sm.value='';  
            nxt.sm_desc.value='';
            nxt.submit(); false">
            <div class="stff_mm_btns">
                Admin
            </div>
        </a><?php
    }
}?>

<!-- <a href="#" style="text-decoration:none;" 
    onclick="stff_guide_instr.submit();return false">
    <div class="stff_mm_btns_how" style="margin-left:0.55%; margin-right:0.55%; font-size:small" title="How to do things">
        Help
    </div>
</a>

<a href="#" style="text-decoration:none;" 
    onclick="hpg.action='./staff_login_page';hpg.submit();return false">
    <div class="stff_mm_btns_logout" style="float:right; font-size:small">
        Logout
    </div>
</a> -->


<div id="general_smke_screen" class="smoke_scrn" style="display:none; z-index:-1"></div>
<div id="in_progress" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
    <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
        Information
    </div>
    <a href="#" style="text-decoration:none;">
        <div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
    </a>
    <div style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#6b6b6b">
        Processing. Please wait...
    </div>
    <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;"></div>
</div>


<div id="on_error" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
    <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
        Information
    </div>
    <a href="#" style="text-decoration:none;">
        <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
    </a>
    <div id="on_error_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#6b6b6b">
        Your internet connection was interrupted. Please try again
    </div>
    <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
        <a href="#" style="text-decoration:none;" 
            onclick="_('general_smke_screen').style.display='none';
            _('general_smke_screen').style.zIndex='-1';
            _('on_error').style.display='none';
            _('on_error').style.zIndex='-1';
            return false">
            <div class="submit_button_brown" style="width:60px; padding:6px; float:right">
                Ok
            </div>
        </a>
    </div>
</div>



<div id="on_abort" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:-1">
    <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
        Information
    </div>
    <a href="#" style="text-decoration:none;">
        <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
    </a>
    <div style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#6b6b6b">
        Process aborted
    </div>
    <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
        <a href="#" style="text-decoration:none;" 
            onclick="_('general_smke_screen').style.display='none';
            _('general_smke_screen').style.zIndex='-1';
            _('on_abort').style.display='none';
            _('on_abort').style.zIndex='-1';
            return false">
            <div class="submit_button_brown" style="width:60px; padding:6px; float:right">
                Ok
            </div>
        </a></div>
</div>

<div id="general_caution_box" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF; max-height:70vh; overflow:auto; overflow-x:hidden; z-index:-1">
    <div style="width:350px; float:left; text-align:left; padding:0px; color:#e31e24; font-weight:bold">
        Caution
    </div>
    <a href="#" style="text-decoration:none;">
        <div style="width:20px; float:left; text-align:center; padding:0px;"></div>
    </a>
    <div id="general_caution_msg_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#6b6b6b;"></div>
    <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
        <a href="#" style="text-decoration:none;" 
            onclick="_('general_smke_screen').style.display='none';
            _('general_smke_screen').style.zIndex='-1';
            _('general_caution_box').style.display='none';
            _('general_caution_box').style.zIndex='-1';
            return false">
            <div class="submit_button_brown" style="width:60px; padding:6px; float:right">
                Ok
            </div>
        </a>
    </div>
</div>



<div id="general_success_box" class="center" style="display:none; width:370px; text-align:center; padding:10px; box-shadow: 2px 2px 8px 2px #726e41; background:#FFFFFF;  z-index:3">
    <div style="width:350px; float:left; text-align:left; padding:0px; color:#36743e; font-weight:bold">
        Information
    </div>
    <a href="#" style="text-decoration:none;">
        <div id="msg_title" style="width:20px; float:left; text-align:center; padding:0px;"></div>
    </a>
    <div id="general_success_msg_msg" style="line-height:1.6; margin-top:10px; width:370px; float:left; text-align:center; padding:0px; color:#36743e;"></div>
    <div style="margin-top:10px; width:370px; float:left; text-align:right; padding:0px;">
        <a href="#" style="text-decoration:none;" 
            onclick="_('general_success_box').style.display= 'none';
            _('general_success_box').style.zIndex= '-1';
            _('general_smke_screen').style.display= 'none';
            _('general_smke_screen').style.zIndex= '-1';
            return false">
            <div class="submit_button_home" style="width:60px; padding:6px; float:right">
                Ok
            </div>
        </a>
    </div>
</div>