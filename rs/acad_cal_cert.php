<?php

if (isset($_REQUEST["top_menu_no"]) && ($_REQUEST["top_menu_no"] == '1' || $_REQUEST["top_menu_no"] == ''))
{    
    $sesdate0 = $orgsetins['sesdate0'];
    $sesdate1 = $orgsetins['sesdate1'];

    $semdate1 = '';
    $semdate2 = '';

    $regdate1 = '';
    $regdate2 = '';

    $progdate1 = '';
    $progdate2 = '';

    $examdate1 = '';
    $examdate2 = '';

    if (!is_bool(strpos($cProgrammeId_loc, "DEG")))
	{
        $semdate1 = $orgsetins_deg['sem0'];
        $semdate2 = $orgsetins_deg['sem1'];

        $regdate1 = $orgsetins_deg['reg0'];
        $regdate2 = $orgsetins_deg['reg1'];    

        $progdate1 = $orgsetins_deg['prj0'];
        $progdate2 = $orgsetins_deg['prj1'];

        $examdate1 = $orgsetins_deg['exam0'];
        $examdate2 = $orgsetins_deg['exam1'];
    }else if (!is_bool(strpos($cProgrammeId_loc, "CHD")))
    {
        $semdate1 = $orgsetins_chd['sem0'];
        $semdate2 = $orgsetins_chd['sem1'];

        $regdate1 = $orgsetins_chd['reg0'];
        $regdate2 = $orgsetins_chd['reg1'];    

        $progdate1 = $orgsetins_chd['prj0'];
        $progdate2 = $orgsetins_chd['prj1'];

        $examdate1 = $orgsetins_chd['exam0'];
        $examdate2 = $orgsetins_chd['exam1'];
    }
    
    $today_date = date("Y-m-d");
    $today_date = intval(substr($today_date,0,4)).'-'.intval(substr($today_date,5,6)).'-'.substr($today_date,8,2);?>
    <div class="appl_left_child_div_child calendar_grid">
        <div style="flex:5%; padding-left:4px; height:50px; background-color: #eff5f0; font-weight:bold">
            <img style="width:45px; height:inherit" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'calendar.png');?>"/>
        </div>
        <div style="flex:95%; padding-left:4px; height:50px; background-color: #eff5f0; font-weight:bold">
            <?php echo "Callendar for ".substr($orgsetins['cAcademicDesc'], 0, 4)." Academic Session";?>
        </div>
    </div>
    
    <div class="appl_left_child_div_child calendar_grid" style="font-weight: bold;">
        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
            Sns
        </div>
        <div style="flex:20%; padding-left:4px; height:50px; background-color: #ffffff">
            Event
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            Begins on...
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            Ends on...
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            Status/Time count-down
        </div>
    </div>
    
    
    <div class="appl_left_child_div_child calendar_grid">
        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
            1
        </div>
        <div style="flex:20%; padding-left:4px; height:50px; background-color: #ffffff">
            Session
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php echo substr($sesdate0,0,2).'-'.substr($sesdate0,2,2).'-'.substr($sesdate0,4,4);?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php echo substr($sesdate1,0,2).'-'.substr($sesdate1,2,2).'-'.substr($sesdate1,4,4);?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <input name="session_begin_date" id="session_begin_date" type="hidden" value="<?php echo $sesdate0; ?>" />
            <input name="session_end_date" id="session_end_date" type="hidden" value="<?php echo $sesdate1; ?>" />
            <script>
                var yearsAA_1 = _("session_begin_date").value.substr(4,4);
                var monthsAA_1 = _("session_begin_date").value.substr(2,2)-1;
                var daysAA_1 = _("session_begin_date").value.substr(0,2);
                var countDownDateB_1 = new Date(yearsAA_1, monthsAA_1, daysAA_1).getTime();

                var countDownDateB_0 = new Date().getTime();

                if(countDownDateB_1 <= countDownDateB_0)
                {
                    var yearsAA = _("session_end_date").value.substr(4,4);
                    var monthsAA = _("session_end_date").value.substr(2,2)-1;
                    var daysAA = _("session_end_date").value.substr(0,2);

                    var countDownDateA = new Date(yearsAA, monthsAA, daysAA).getTime();
                    
                    // Update the count down every 1 second
                    var xA = setInterval(function() 
                    {
                        var nowA = new Date().getTime();
                        var distanceA = countDownDateA - nowA;

                        var weeksA = Math.floor(distanceA / (1000 * 60 * 60 * 24 * 7));
                        var daysA = Math.floor((distanceA % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24));
                        var hoursA = Math.floor((distanceA % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutesA = Math.floor((distanceA % (1000 * 60 * 60)) / (1000 * 60));
                        var secondsA = Math.floor((distanceA % (1000 * 60)) / 1000);

                        // Display the result in the element with id="demo"                    
                        _("demoA1").innerHTML = weeksA + "Wks ";                    
                        _("demoA2").innerHTML = daysA + "Days ";                    
                        _("demoA3").innerHTML = hoursA + "Hr ";
                        _("demoA4").innerHTML = minutesA + "Mins ";
                        _("demoA5").innerHTML = secondsA + "Sec ";

                        // If the count down is finished, write some text
                        if (distanceA < 0)
                        {
                            clearInterval(xA);
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoA"+c).style.display = 'none';
                            }
                            _("demoA").style.display = 'block';
                            _("demoA").innerHTML = 'Closed';
                        }else
                        { 
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoA"+c).style.display = 'block';
                            }
                            _("demoA").style.display = 'none';

                        }
                    }, 1000);
                }
            </script>

            <div id="demoA" class="count_down_div" style="display:block; width:100%; height:auto;">
                Loading...
            </div>
            <div id="demoA1" class="count_down_div" style="height:auto;">
                00
            </div>
            <div id="demoA2" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoA3" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoA4" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoA5" class="count_down_div" style="margin-left:2%; font-weight:bold;">
                00
            </div>
        </div>
    </div>
    
    
    <div class="appl_left_child_div_child calendar_grid">
        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
            2
        </div>
        <div style="flex:20%; padding-left:4px; height:50px; background-color: #ffffff">
            Semester
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php echo formatdate($semdate1,'fromdb');?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php echo formatdate($semdate2,'fromdb');?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <input name="semester_begin_date" id="semester_begin_date" type="hidden" value="<?php echo $semdate1; ?>" />
            <input name="semester_end_date" id="semester_end_date" type="hidden" value="<?php echo $semdate2; ?>" />
            <script>
                var yearsBB_1 = _("semester_begin_date").value.substr(0,4);
                var monthsBB_1 = _("semester_begin_date").value.substr(5,2)-1;
                var daysBB_1 = _("semester_begin_date").value.substr(8,2);
                var countDownDateB_1 = new Date(yearsBB_1, monthsBB_1, daysBB_1).getTime();

                var countDownDateB_0 = new Date().getTime();
                if(countDownDateB_1 <= countDownDateB_0)
                {
                    var yearsBB = _("semester_end_date").value.substr(0,4);
                    var monthsBB = _("semester_end_date").value.substr(5,2)-1;
                    var daysBB = _("semester_end_date").value.substr(8,2);

                    var countDownDateB = new Date(yearsBB, monthsBB, daysBB).getTime();

                    // Update the count down every 1 second
                    var xB = setInterval(function() 
                    {									
                        var nowB = new Date().getTime();
                        var distanceB = countDownDateB - nowB;

                        var weeksB = Math.floor(distanceB / (1000 * 60 * 60 * 24 * 7));
                        var daysB = Math.floor((distanceB % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24));
                        var hoursB = Math.floor((distanceB % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutesB = Math.floor((distanceB % (1000 * 60 * 60)) / (1000 * 60));
                        var secondsB = Math.floor((distanceB % (1000 * 60)) / 1000);

                        // Display the result in the element with id="demo"
                        _("demoB1").innerHTML = weeksB + "Wks ";                    
                        _("demoB2").innerHTML = daysB + "Days ";                    
                        _("demoB3").innerHTML = hoursB + "Hr ";
                        _("demoB4").innerHTML = minutesB + "Mins ";
                        _("demoB5").innerHTML = secondsB + "Sec ";
                        
                        // If the count down is finished, write some text
                        if (distanceB < 0)
                        {
                            clearInterval(xB);
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoB"+c).style.display = 'none';
                            }
                            _("demoB").style.display = 'block';
                            _("demoB").innerHTML = 'Closed';
                        }else
                        { 
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoB"+c).style.display = 'block';
                            }
                            _("demoB").style.display = 'none';

                        }
                    }, 1000);
                }
            </script>

            <div id="demoB" class="count_down_div" style="display:block; width:100%; height:auto;">
                Loading...
            </div>
            <div id="demoB1" class="count_down_div" style="height:auto;">
                00
            </div>
            <div id="demoB2" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoB3" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoB4" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoB5" class="count_down_div" style="margin-left:2%; font-weight:bold;">
                00
            </div>
        </div>
    </div>
    
    <div class="appl_left_child_div_child calendar_grid">
        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
            3
        </div>
        <div style="flex:20%; padding-left:4px; height:50px; background-color: #ffffff; max-width:20%; text-overflow: ellipsis;">
            Registration (course and examination)
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php echo formatdate($regdate1,'fromdb');?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php echo formatdate($regdate2,'fromdb');?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <input name="registration_begin_date" id="registration_begin_date" type="hidden" value="<?php echo $regdate1; ?>" />
            <input name="registration_end_date" id="registration_end_date" type="hidden" value="<?php echo $regdate2; ?>" />
            <script>
                var yearsCC_1 = _("registration_begin_date").value.substr(0,4);
                var monthsCC_1 = _("registration_begin_date").value.substr(5,2)-1;
                var daysCC_1 = _("registration_begin_date").value.substr(8,2);
                var countDownDateC_1 = new Date(yearsCC_1, monthsCC_1, daysCC_1).getTime();

                var countDownDateC_0 = new Date().getTime();
                if(countDownDateC_1 <= countDownDateC_0)
                {
                    var yearsCC = _("registration_end_date").value.substr(0,4);
                    var monthsCC = _("registration_end_date").value.substr(5,2)-1;
                    var daysCC = _("registration_end_date").value.substr(8,2);

                    var countDownDateC = new Date(yearsCC, monthsCC, daysCC).getTime();
                    
                    // Update the count down every 1 second
                    var xC = setInterval(function() 
                    {
                        var nowC = new Date().getTime();
                        var distanceC = countDownDateC - nowC;

                        var weeksC = Math.floor(distanceC / (1000 * 60 * 60 * 24 * 7));
                        var daysC = Math.floor((distanceC % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24));
                        var hoursC = Math.floor((distanceC % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutesC = Math.floor((distanceC % (1000 * 60 * 60)) / (1000 * 60));
                        var secondsC = Math.floor((distanceC % (1000 * 60)) / 1000);

                        // Display the result in the element with id="demo"                    
                        _("demoC1").innerHTML = weeksC + "Wks ";                    
                        _("demoC2").innerHTML = daysC + "Days ";                    
                        _("demoC3").innerHTML = hoursC + "Hr ";
                        _("demoC4").innerHTML = minutesC + "Mins ";
                        _("demoC5").innerHTML = secondsC + "Sec ";

                        // If the count down is finished, write some text
                        if (distanceC < 0)
                        {
                            clearInterval(xC);
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoC"+c).style.display = 'none';
                            }
                            _("demoC").style.display = 'block';
                            _("demoC").innerHTML = 'Closed';
                        }else
                        { 
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoC"+c).style.display = 'block';
                            }
                            _("demoC").style.display = 'none';

                        }
                    }, 1000);
                }
            </script>

            <div id="demoC" class="count_down_div" style="display:block; width:100%; height:auto;">
                Loading...
            </div>
            <div id="demoC1" class="count_down_div" style="height:auto;">
                00
            </div>
            <div id="demoC2" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoC3" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoC4" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoC5" class="count_down_div" style="margin-left:2%; font-weight:bold;">
                00
            </div>
        </div>
    </div>

    <div class="appl_left_child_div_child calendar_grid">
        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
            4
        </div>
        <div style="flex:20%; padding-left:4px; height:50px; background-color: #ffffff">
            Project (Business Canvas)
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php echo formatdate($progdate1,'fromdb');?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php echo formatdate($progdate2,'fromdb');?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <input name="proj_begin_date" id="proj_begin_date" type="hidden" value="<?php echo $progdate1; ?>" />
            <input name="proj_edn_date" id="proj_edn_date" type="hidden" value="<?php echo $progdate2; ?>" />
            <script>
                var yearsEE_1 = _("proj_begin_date").value.substr(0,4);
                var monthsEE_1 = _("proj_begin_date").value.substr(5,2)-1;
                var daysEE_1 = _("proj_begin_date").value.substr(8,2);
                var countDownDateE_1 = new Date(yearsEE_1, monthsEE_1, daysEE_1).getTime();

                var countDownDateE_0 = new Date().getTime();
                if(countDownDateE_1 <= countDownDateE_0)
                {
                    var yearsEE = _("proj_edn_date").value.substr(0,4);
                    var monthsEE = _("proj_edn_date").value.substr(5,2)-1;
                    var daysEE = _("proj_edn_date").value.substr(8,2);

                    var countDownDateE = new Date(yearsEE, monthsEE, daysEE).getTime();
                    
                    // Update the count down every 1 second
                    var xE = setInterval(function() 
                    {
                        var nowE = new Date().getTime();
                        var distanceE = countDownDateE - nowE;

                        var weeksE = Math.floor(distanceE / (1000 * 60 * 60 * 24 * 7));
                        var daysE = Math.floor((distanceE % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24));
                        var hoursE = Math.floor((distanceE % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutesE = Math.floor((distanceE % (1000 * 60 * 60)) / (1000 * 60));
                        var secondsE = Math.floor((distanceE % (1000 * 60)) / 1000);

                        // Display the result in the element with id="demo"                    
                        _("demoE1").innerHTML = weeksE + "Wks ";                    
                        _("demoE2").innerHTML = daysE + "Days ";                    
                        _("demoE3").innerHTML = hoursE + "Hr ";
                        _("demoE4").innerHTML = minutesE + "Mins ";
                        _("demoE5").innerHTML = secondsE + "Sec ";

                        // If the count down is finished, write some text
                        if (distanceE < 0)
                        {
                            clearInterval(xE);
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoE"+c).style.display = 'none';
                            }
                            _("demoE").style.display = 'block';
                            _("demoE").innerHTML = 'Closed';
                        }else
                        { 
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoE"+c).style.display = 'block';
                            }
                            _("demoE").style.display = 'none';

                        }
                    }, 1000);
                }
            </script>

            <div id="demoE" class="count_down_div" style="display:block; width:100%; height:auto;">
                Loading...
            </div>
            <div id="demoE1" class="count_down_div" style="height:auto">
                00
            </div>
            <div id="demoE2" class="count_down_div background:#ccc" style="margin-left:2%">
                00
            </div>
            <div id="demoE3" class="count_down_div background:#ccc" style="margin-left:2%">
                00
            </div>
            <div id="demoE4" class="count_down_div background:#ccc" style="margin-left:2%">
                00
            </div>
            <div id="demoE5" class="count_down_div background:#ccc" style="margin-left:2%; font-weight:bold;">
                00
            </div>
        </div>
    </div>
    
    <div class="appl_left_child_div_child calendar_grid">
        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
            4
        </div>
        <div style="flex:20%; padding-left:4px; height:50px; background-color: #ffffff">
            Examination
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php echo formatdate($examdate1,'fromdb');?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php echo formatdate($examdate2,'fromdb');?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <input name="exam_begin_date" id="exam_begin_date" type="hidden" value="<?php echo $examdate1; ?>" />
            <input name="exam_end_date" id="exam_end_date" type="hidden" value="<?php echo $examdate2; ?>" />

            <script>
                var yearsDD_1 = _("exam_begin_date").value.substr(0,4);
                var monthsDD_1 = _("exam_begin_date").value.substr(5,2)-1;
                var daysDD_1 = _("exam_begin_date").value.substr(8,2);
                var countDownDateD_1 = new Date(yearsDD_1, monthsDD_1, daysDD_1).getTime();
                
                var countDownDateD_0 = new Date().getTime();
                if(countDownDateD_1 <= countDownDateD_0)
                {
                    var yearsDD = _("exam_end_date").value.substr(0,4);
                    var monthsDD = _("exam_end_date").value.substr(5,2)-1;
                    var daysDD = _("exam_end_date").value.substr(8,2);

                    var countDownDateD = new Date(yearsDD, monthsDD, daysDD).getTime();
                    
                    // Update the count down every 1 second
                    var xD = setInterval(function() 
                    {
                        var nowD = new Date().getTime();
                        var distanceD = countDownDateD - nowD;

                        var weeksD = Math.floor(distanceD / (1000 * 60 * 60 * 24 * 7));
                        var daysD = Math.floor((distanceD % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24));
                        var hoursD = Math.floor((distanceD % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutesD = Math.floor((distanceD % (1000 * 60 * 60)) / (1000 * 60));
                        var secondsD = Math.floor((distanceD % (1000 * 60)) / 1000);

                        // Display the result in the element with id="demo"                    
                        _("demoD1").innerHTML = weeksD + "Wks ";                    
                        _("demoD2").innerHTML = daysD + "Days ";                    
                        _("demoD3").innerHTML = hoursD + "Hr ";
                        _("demoD4").innerHTML = minutesD + "Mins ";
                        _("demoD5").innerHTML = secondsD + "Sec ";

                        // If the count down is finished, write some text
                        if (distanceD < 0)
                        {
                            clearInterval(xD);
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoD"+c).style.display = 'none';
                            }
                            _("demoD").style.display = 'block';
                            _("demoD").innerHTML = 'Closed';
                        }else
                        { 
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoD"+c).style.display = 'block';
                            }
                            _("demoD").style.display = 'none';

                        }
                    }, 1000);
                }
            </script>

            <div id="demoD" class="count_down_div" style="display:block; width:100%; height:auto;">
                Loading...
            </div>
            <div id="demoD1" class="count_down_div" style="height:auto;">
                00
            </div>
            <div id="demoD2" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoD3" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoD4" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoD5" class="count_down_div" style="margin-left:2%; font-weight:bold;">
                00
            </div>
        </div>
    </div><?php
}