<div style="width:15%; height:auto; position:absolute; right:5px; margin-top:10px; border-radius:0px;"><?php
    if (check_scope2('SPGS', 'SPGS menu') > 0)
    {?>
        <a href="#" style="text-decoration:none;" 
            onclick="pg_environ.mm.value=8;pg_environ.sm.value='';pg_environ.submit();return false;">
            <div class="rtlft_inner_button" style="margin-bottom:5px; width:100%;">
                SPGS menu
            </div>
        </a><?php
    }
    
    if ($sm == 1)
    {
        if (check_scope3('Report', 'Distributions', 'Exam registration') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='1')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                    Exam registration
                </div>
                
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=1;
                    in_progress('1');
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss4" class="rtlft_inner_button" style="width:100%; display:none;">
                        Exam registration
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=1;
                    in_progress('1');
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss4" class="rtlft_inner_button" style="width:100%;">
                        Exam registration
                    </div>
                </a><?php
            }
        }
        
        if (check_scope3('Report', 'Distributions', 'Student') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='2')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                    Students
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=2;
                    in_progress('1');
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Students
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=2;
                    in_progress('1');
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Students
                    </div>
                </a><?php
            }
        }
    }else if ($sm == 2)
    {
        if (check_scope3('Report', 'List', 'Faculties') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='3')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Faculties
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=3;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    cust_rpt.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Faculties
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=3;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Faculties
                    </div>
                </a><?php
            }
        }
        
        if (check_scope3('Report', 'List', 'Departments') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='4')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Departments
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=4;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Departments
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=4;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Departments
                    </div>
                </a><?php
            }
        }
        
        if (check_scope3('Report', 'List', 'Programmes') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='5')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Programmes
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=5;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Programmes
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=5;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Programmes
                    </div>
                </a><?php
            }
        }
        
        if (check_scope3('Report', 'List', 'Courses') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='6')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                    Courses
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=6;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Courses
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=6;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Courses
                    </div>
                </a><?php
            }
        }
        
        if (check_scope3('Report', 'List', 'Study centres') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='7')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Study centres
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=7;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Study centres
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=7;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Study centres
                    </div>
                </a><?php
            }
        }
        
        if (check_scope3('Report', 'List', 'Students') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='7a')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Students
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value='7a';
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Students
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value='7a';
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Students
                    </div>
                </a><?php
            }
        }
    }else if ($sm == 3)
    {
        if (check_scope3('Report', 'Custom', 'CEMBA') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='10')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        CEMBA
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=10;
			        rpt_1_loc.target = '_blank';
			        rpt_1_loc.action = 'custom_report';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        CEMBA
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=10;
			        rpt_1_loc.target = '_blank';
			        rpt_1_loc.action = 'custom_report';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        CEMBA
                    </div>
                </a><?php
            }
        }

        if (check_scope3('Report', 'Custom', 'CHD') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='10')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        CHRD
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=16;
			        /*rpt_1_loc.target = '_blank';
			        rpt_1_loc.action = 'custom_report';*/
                    rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        CHRD
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=16;
			        /*rpt_1_loc.target = '_blank';
			        rpt_1_loc.action = 'custom_report';*/
                    rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        CHRD
                    </div>
                </a><?php
            }
        }

        if (check_scope3('Report', 'Custom', 'LAW') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='10')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        LAW
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=17;
			        rpt_1_loc.target = '_blank';
			        rpt_1_loc.action = 'custom_report';
                    /*rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';*/
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        LAW
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=17;
			        rpt_1_loc.target = '_blank';
			        rpt_1_loc.action = 'custom_report';
                    /*rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';*/
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        LAW
                    </div>
                </a><?php
            }
        }
        
        if (check_scope3('Report', 'Custom', 'TMA preparation') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='8')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        TMA preparation
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=8;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        TMA preparation
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=8;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        TMA preparation
                    </div>
                </a><?php
            }
        } 
        
        if (check_scope3('Report', 'Custom', 'Exam preparation') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='8a')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Exam registrations
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value='8a';
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Exam registrations
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value='8a';
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Exam registrations
                    </div>
                </a><?php
            }
        }

        if (check_scope3('Report', 'Custom', 'JAMB') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='12')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        JAMB
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=12;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        JAMB
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=12;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        JAMB
                    </div>
                </a><?php
            }
        }

        if (check_scope3('Report', 'Custom', 'NELFUND') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='11')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        NELFUND
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=11;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        NELFUND
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=11;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        NELFUND
                    </div>
                </a><?php
            }
        }

        if (check_scope3('Report', 'Custom', 'PAS') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='9')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        PAS
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=9;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        PAS
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=9;
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        PAS
                    </div>
                </a><?php
            }
        }

        if (check_scope3('Report', 'Custom', 'Printing press') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='9a')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Printing press
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value='9a';
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Printing press
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value='9a';
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Printing press
                    </div>
                </a><?php
            }
        }

        if (check_scope3('Report', 'Custom', 'SIWES') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='12a')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        SIWES
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value='12a';
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        SIWES
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value='12a';
			        rpt_1_loc.target = '_self';
			        rpt_1_loc.action = 'rpt_page_1';
                    in_progress('1');
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        SIWES
                    </div>
                </a><?php
            }
        }

        if (check_scope3('Report', 'Custom', 'Wallet funding') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='13')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Wallet funding
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=13;
			        rpt_1_loc.target = '_self';
                    in_progress('1');
			        rpt_1_loc.action = 'rpt_page_1';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Wallet funding
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=13;
			        rpt_1_loc.target = '_self';
                    in_progress('1');
			        rpt_1_loc.action = 'rpt_page_1';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Wallet funding
                    </div>
                </a><?php
            }
        }

        if (check_scope3('Report', 'Custom', 'Wallet debits') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='14')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Wallet debits
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=14;
			        rpt_1_loc.target = '_self';
                    in_progress('1');
			        rpt_1_loc.action = 'rpt_page_1';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Wallet debits
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=14;
			        rpt_1_loc.target = '_self';
                    in_progress('1');
			        rpt_1_loc.action = 'rpt_page_1';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Wallet debits
                    </div>
                </a><?php
            }
        }

        if (check_scope3('Report', 'Custom', 'Gown refund') > 0)
        {
            if (isset($_REQUEST['whattodo'])&&$_REQUEST['whattodo']=='15')
            {?>
                <div class="rtlft_inner_button_dull" 
                    style="background-color:#a6cda0;
                    color:#FFFFFF;">
                        Gown refund
                </div>

                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=15;
			        rpt_1_loc.target = '_self';
                    in_progress('1');
			        rpt_1_loc.action = 'rpt_page_1';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%; display:none;">
                        Gown refund
                    </div>
                </a><?php
            }else
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="rpt_1_loc.whattodo.value=15;
			        rpt_1_loc.target = '_self';
                    in_progress('1');
			        rpt_1_loc.action = 'rpt_page_1';
                    rpt_1_loc.submit();
                    return false">
                    <div id="tabss5" class="rtlft_inner_button" style="width:100%;">
                        Gown refund
                    </div>
                </a><?php
            }
        }
    }?>
</div>