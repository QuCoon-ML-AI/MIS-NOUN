<div id="menu_div" class="data_line data_line_logout" 
    style="padding:0px; 
    height:auto; 
    border-top:1px solid #b6b6b6; 
    border-bottom:1px solid #b6b6b6; 
    margin-top:5px; 
    justify-content:space-between;"><?php
    if (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '1')
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none">
                Orientation</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="lib_js('1','','_self','welcome_student');">
                Orientation</button>
        </div><?php
    }

    //department
    /*if (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '2')
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none">
                My department</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="lib_js('2','','_self','welcome_student');">
                My department</button>
        </div><?php
    }*/

    //bursary
    if (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '3')
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none">
                Bursary</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="lib_js('3','','_self','welcome_student');">
                Bursary</button>
        </div><?php
    }

    $stmt_grad_mat_list = $mysqli->prepare("SELECT vMatricNo
    FROM s_m_t_grad_mat_list
    WHERE LEFT(vMatricNo,12) = ?");
    $stmt_grad_mat_list->bind_param("s", $_REQUEST["vMatricNo"]);
    $stmt_grad_mat_list->execute();
    $stmt_grad_mat_list->store_result();
    $stmt_grad_mat_list->bind_result($grad_mat);
    $stmt_grad_mat_list->fetch();
    $stmt_grad_mat_list->close();

    //Registry
    if (!is_null($grad_mat) || (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '4'))
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none">
                Registry</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="lib_js('4','','_self','welcome_student');">
                Registry</button>
        </div><?php
    }

    //My courses
    if (!is_null($grad_mat) || (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '5'))
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none">
                My courses</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="lib_js('5','','_self','welcome_student');">
                My courses</button>
        </div><?php
    }
   
    
    //My learning space
    if (!is_null($grad_mat) || (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '6'))
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none">
                My learning space</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="lib_js('6','','_blank','');">
                My learning space</button>
        </div><?php
    }
   
    //Library
    if (!is_null($grad_mat) || (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '7'))
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none">
                Library</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="lib_js('7','','_self','welcome_student');">
                Library</button>
        </div><?php
    }
    
    
    //Assessment
    if ($cEduCtgId_loc <> 'ELX')
    {
        if (!is_null($grad_mat) || (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '8'))
        {?>
            <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
                <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none">
                    Assessment</button>
            </div><?php
        }else
        {?>
            <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
                <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                    onclick="lib_js('8','','_self','welcome_student');">
                    Assessment</button>
            </div><?php
        }
    }


    //My progress
    if (!is_null($grad_mat) || (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '9'))
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none">
                My progress</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="button mm2_button"  style="padding:7px; border:none" 
                onclick="lib_js('9','','_self','welcome_student');">
                My progress</button>
        </div><?php
    }


    //Support
    if (isset($_REQUEST['top_menu_no']) && $_REQUEST['top_menu_no'] == '10')
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="button" class="dull_button mm2_button"  style="padding:7px; border:none">
                Support</button>
        </div><?php
    }else
    {?>
        <div class="data_line_child data_line_child_home" style="text-align:center; margin: 0px;">
            <button type="  " class="button mm2_button"  style="padding:7px; border:none" 
                onclick="std_sections.action='welcome_student';
                std_sections.top_menu_no.value='10';
                std_sections.side_menu_no.value='';
				std_sections.target='_self';
                in_progress('1');
                std_sections.submit(); return false">
                Support</button>
        </div><?php
    }?>
</div>