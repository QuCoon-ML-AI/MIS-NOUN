<?php
if(isset($_REQUEST["top_menu_no"]) && isset($_REQUEST["side_menu_no"]))
{
    if (isset($_REQUEST["top_menu_no"]) && isset($_REQUEST["side_menu_no"]) && ($_REQUEST["top_menu_no"] == '3' && ($_REQUEST["side_menu_no"] == 'make_payment' || $_REQUEST["side_menu_no"] == 'final_year_clearance' || $_REQUEST["side_menu_no"] == 'pay_convocation_gown')) ||
    ($_REQUEST["top_menu_no"] == '4' && ($_REQUEST["side_menu_no"] == 'change_password' || $_REQUEST["side_menu_no"] == 'see_application_record' || $_REQUEST["side_menu_no"] == 'update_bio_data')) ||
    ($_REQUEST["top_menu_no"] == '5' && ($_REQUEST["side_menu_no"] == 'register_courses' || $_REQUEST["side_menu_no"] == 'register_courses_for_exam')))
    {?>
        <div id="sub_box" style="display:flex; 
            flex-flow: row;
            justify-content: flex-end;
            flex:100%;
            height:auto; 
            margin-top:10px;">
                <button type="submit" class="login_button" onclick="chk_inputs();return false">Submits</button>  
        </div><?php
    }

    if (($_REQUEST["top_menu_no"] == '3' && $_REQUEST["side_menu_no"] == 'list_transactions' && isset($wallet_trn_cnt) && $wallet_trn_cnt > 0) || 
    $_REQUEST["top_menu_no"] == '5' && ($_REQUEST["side_menu_no"] == 'see_course_registration_slip' || 
    $_REQUEST["side_menu_no"] == 'see_all_registered_courses' || 
    $_REQUEST["side_menu_no"] == 'see_exam_registeration_slip' || 
    $_REQUEST["side_menu_no"] == 'see_all_registered_courses_for_exam' || 
    $_REQUEST["side_menu_no"] == 'see_course_registration_slip'))
    {?>
        <div id="sub_box" style="display:flex; 
            flex-flow: row;
            justify-content: flex-end;
            flex:100%;
            height:auto;
            align-self:flex-end; 
            margin-top:10px;">
                <button type="submit" class="login_button" 
                onclick="std_sections.side_menu_no.value='<?php echo $_REQUEST['side_menu_no'];?>';
                std_sections.target='_blank';
                std_sections.action='print-result';
                std_sections.submit();
                return false">Print</button>  
        </div><?php
    }
}?>