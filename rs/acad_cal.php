<?php

if (isset($_REQUEST["top_menu_no"]) && ($_REQUEST["top_menu_no"] == '1' || $_REQUEST["top_menu_no"] == ''))
{
    $sesdate0 = $orgsetins['sesdate0'];
    $sesdate1 = $orgsetins['sesdate1'];
    if ($cEduCtgId_loc == 'PGZ' || $cEduCtgId_loc == 'PRX')
    {
        $semdate1 = substr($orgsetins_spg['sem0'],8,2).substr($orgsetins_spg['sem0'],5,2).substr($orgsetins_spg['sem0'],0,4);
        $semdate2 = substr($orgsetins_spg['sem1'],8,2).substr($orgsetins_spg['sem1'],5,2).substr($orgsetins_spg['sem1'],0,4);

        $regdate1 = substr($orgsetins_spg['reg0'],8,2).substr($orgsetins_spg['reg0'],5,2).substr($orgsetins_spg['reg0'],0,4);
        $regdate2 = substr($orgsetins_spg['reg1'],8,2).substr($orgsetins_spg['reg1'],5,2).substr($orgsetins_spg['reg1'],0,4);
    }else
    {
        $semdate1 = $orgsetins['semdate1'];
        $semdate2 = $orgsetins['semdate2'];

        $regdate1 = $orgsetins['regdate1'];
        if ($iStudy_level_loc <= 200)
        {
            $regdate2 = $orgsetins['regdate_100_200_2'];
        }else
        {
            $regdate2 = $orgsetins['regdate_300_2'];
        }
    }
    
    $iextend_reg = $orgsetins['iextend_reg'];

    $examregdate1 = $orgsetins['examregdate1'];
    if ($iStudy_level_loc <= 200)
    {
        $examregdate2 = $orgsetins['examregdate_100_200_2'];
    }else
    {
        $examregdate2 = $orgsetins['examregdate_300_2'];
    }
    				
    $iextend_exam = $orgsetins['iextend_exam'];
    
    $tmadate1 = $orgsetins['tmadate1'];
    $tmadate2 = $orgsetins['tmadate2'];
    $iextend_tma = $orgsetins['iextend_tma'];
    
    $examdate1 = $orgsetins['examdate1'];
    $examdate2 = $orgsetins['examdate2'];
    
    if ($iStudy_level_loc <= 200)
    {
        $drp_examdate = $orgsetins['drp_examdate'];
        $student_request_end_date = $orgsetins['student_req1'];

        $student_centre_request_close = $orgsetins['student_req1'];
    }else
    {
        $drp_examdate = $orgsetins['drp_exam_2date'];
        $student_request_end_date = $orgsetins['student_req2'];
        
        $student_centre_request_close = $orgsetins['student_req2'];
    }

    /*if ($iStudy_level_loc <= 200)
    {
        $student_request_end_date = $orgsetins['student_req1'];
    }else
    {
        $student_request_end_date = $orgsetins['student_req2'];
    }*/

    //$student_request_close_100 = $orgsetins['student_req1'];
    //$student_request_close_300 = $orgsetins['student_req2'];
    
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
            Sn
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
            <?php echo substr($sesdate0,0,2).'/'.substr($sesdate0,2,2).'/'.substr($sesdate0,4,4);?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php echo substr($sesdate1,0,2).'/'.substr($sesdate1,2,2).'/'.substr($sesdate1,4,4);?>
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
            <?php echo substr($semdate1,0,2).'/'.substr($semdate1,2,2).'/'.substr($semdate1,4,4);?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php echo substr($semdate2,0,2).'/'.substr($semdate2,2,2).'/'.substr($semdate2,4,4);?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <input name="semester_begin_date" id="semester_begin_date" type="hidden" value="<?php echo $semdate1; ?>" />
            <input name="semester_end_date" id="semester_end_date" type="hidden" value="<?php echo $semdate2; ?>" />
            <script>
                var yearsBB_1 = _("semester_begin_date").value.substr(4,4);
                var monthsBB_1 = _("semester_begin_date").value.substr(2,2)-1;
                var daysBB_1 = _("semester_begin_date").value.substr(0,2);
                var countDownDateB_1 = new Date(yearsBB_1, monthsBB_1, daysBB_1).getTime();

                var countDownDateB_0 = new Date().getTime();
                if(countDownDateB_1 <= countDownDateB_0)
                {
                    var yearsBB = _("semester_end_date").value.substr(4,4);
                    var monthsBB = _("semester_end_date").value.substr(2,2)-1;
                    var daysBB = _("semester_end_date").value.substr(0,2);

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
            Registration (Semester, course and examination)
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php echo substr($regdate1,0,2).'/'.substr($regdate1,2,2).'/'.substr($regdate1,4,4);?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php echo substr($regdate2,0,2).'/'.substr($regdate2,2,2).'/'.substr($regdate2,4,4);?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <input name="registration_begin_date" id="registration_begin_date" type="hidden" value="<?php echo $regdate1; ?>" />
            <input name="registration_end_date" id="registration_end_date" type="hidden" value="<?php echo $regdate2; ?>" />
            <script>
                var yearsCC_1 = _("registration_begin_date").value.substr(4,4);
                var monthsCC_1 = _("registration_begin_date").value.substr(2,2)-1;
                var daysCC_1 = _("registration_begin_date").value.substr(0,2);
                var countDownDateC_1 = new Date(yearsCC_1, monthsCC_1, daysCC_1).getTime();

                var countDownDateC_0 = new Date().getTime();
                if(countDownDateC_1 <= countDownDateC_0)
                {
                    var yearsCC = _("registration_end_date").value.substr(4,4);
                    var monthsCC = _("registration_end_date").value.substr(2,2)-1;
                    var daysCC = _("registration_end_date").value.substr(0,2);

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
    </div><?php
    
    if ($cEduCtgId_loc <> 'PGZ' && $cEduCtgId_loc <> 'PRX')
    {?>
        <div class="appl_left_child_div_child calendar_grid">
            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                4
            </div>
            <div style="flex:20%; padding-left:4px; height:50px; background-color: #ffffff">
                Dropping of course for exam
            </div>
            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                <?php echo substr($regdate1,0,2).'/'.substr($regdate1,2,2).'/'.substr($regdate1,4,4);?>
            </div>
            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                <?php echo substr($drp_examdate,0,2).'/'.substr($drp_examdate,2,2).'/'.substr($drp_examdate,4,4);?>
            </div>
            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                <input name="exam_registration_drop_begin_date" id="exam_registration_drop_begin_date" type="hidden" value="<?php echo $regdate1; ?>" />
                <input name="exam_registration_drop_end_date" id="exam_registration_drop_end_date" type="hidden" value="<?php echo $drp_examdate; ?>" />

                <script>
                    var yearsDD_1 = _("exam_registration_drop_begin_date").value.substr(4,4);
                    var monthsDD_1 = _("exam_registration_drop_begin_date").value.substr(2,2)-1;
                    var daysDD_1 = _("exam_registration_drop_begin_date").value.substr(0,2);
                    var countDownDateD_1 = new Date(yearsDD_1, monthsDD_1, daysDD_1).getTime();
                    
                    var countDownDateD_0 = new Date().getTime();
                    if(countDownDateD_1 <= countDownDateD_0)
                    {
                        var yearsDD = _("exam_registration_drop_end_date").value.substr(4,4);
                        var monthsDD = _("exam_registration_drop_end_date").value.substr(2,2)-1;
                        var daysDD = _("exam_registration_drop_end_date").value.substr(0,2);

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
    }?>
    
    <div class="appl_left_child_div_child calendar_grid">
        <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
            5
        </div>
        <div style="flex:20%; padding-left:4px; height:50px; background-color: #ffffff">
            Requests for change...
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php echo substr($regdate1,0,2).'/'.substr($regdate1,2,2).'/'.substr($regdate1,4,4);?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <?php /*if ($iStudy_level_loc <= 200)
            {
                echo substr($student_request_close_100,0,2).'/'.substr($student_request_close_100,2,2).'/'.substr($student_request_close_100,4,4);
            }else if ($iStudy_level_loc > 200)
            {
                echo substr($student_request_close_300,0,2).'/'.substr($student_request_close_300,2,2).'/'.substr($student_request_close_300,4,4);
            }*/
            echo substr($student_request_end_date,0,2).'/'.substr($student_request_end_date,2,2).'/'.substr($student_request_end_date,4,4);
            ?>
        </div>
        <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
            <input name="request_begin_date" id="request_begin_date" type="hidden" value="<?php echo $regdate1; ?>" />
            <input name="request_end_date" id="request_end_date" type="hidden" value="<?php echo $student_request_end_date; ?>" />

            <script>
                var yearsGG_1 = _("request_begin_date").value.substr(4,4);
                var monthsGG_1 = _("request_begin_date").value.substr(2,2)-1;
                var daysGG_1 = _("request_begin_date").value.substr(0,2);
                var countDownDateG_1 = new Date(yearsGG_1, monthsGG_1, daysGG_1).getTime();
                
                var countDownDateG_0 = new Date().getTime();
                if(countDownDateG_1 <= countDownDateG_0)
                {
                    var yearsGG = _("request_end_date").value.substr(4,4);
                    var monthsGG = _("request_end_date").value.substr(2,2)-1;
                    var daysGG = _("request_end_date").value.substr(0,2);

                    var countDownDateG = new Date(yearsGG, monthsGG, daysGG).getTime();
                    
                    // Update the count down every 1 second
                    var xG = setInterval(function() 
                    {
                        var nowG = new Date().getTime();
                        var distanceG = countDownDateG - nowG;

                        var weeksG = Math.floor(distanceG / (1000 * 60 * 60 * 24 * 7));
                        var daysG = Math.floor((distanceG % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24));
                        var hoursG = Math.floor((distanceG % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutesG = Math.floor((distanceG % (1000 * 60 * 60)) / (1000 * 60));
                        var secondsG = Math.floor((distanceG % (1000 * 60)) / 1000);

                        // Display the result in the element with id="demo"                    
                        _("demoG1").innerHTML = weeksG + "Wks ";                    
                        _("demoG2").innerHTML = daysG + "Days ";                    
                        _("demoG3").innerHTML = hoursG + "Hr ";
                        _("demoG4").innerHTML = minutesG + "Mins ";
                        _("demoG5").innerHTML = secondsG + "Sec ";

                        // If the count down is finished, write some text
                        if (distanceG < 0)
                        {
                            clearInterval(xG);
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoG"+c).style.display = 'none';
                            }
                            _("demoG").style.display = 'block';
                            _("demoG").innerHTML = 'Closed';
                        }else
                        { 
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoG"+c).style.display = 'block';
                            }
                            _("demoG").style.display = 'none';

                        }
                    }, 1000);
                }
            </script>

            <div id="demoG" class="count_down_div" style="display:block; width:100%; height:auto;">
                Loading...
            </div>
            <div id="demoG1" class="count_down_div" style="height:auto;">
                00
            </div>
            <div id="demoG2" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoG3" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoG4" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoG5" class="count_down_div" style="margin-left:2%; font-weight:bold;">
                00
            </div>
        </div>
    </div><?php
    
    if ($cEduCtgId_loc <> 'PGZ' && $cEduCtgId_loc <> 'PRX')
    {?>
        <div class="appl_left_child_div_child calendar_grid">
            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                6
            </div>
            <div style="flex:20%; padding-left:4px; height:50px; background-color: #ffffff">
                Tutor Marked Assignement (TMA)
            </div>
            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                <?php echo substr($tmadate1,0,2).'/'.substr($tmadate1,2,2).'/'.substr($tmadate1,4,4);?>
            </div>
            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                <?php echo substr($tmadate2,0,2).'/'.substr($tmadate2,2,2).'/'.substr($tmadate2,4,4);?>
            </div>
            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                <input name="tma_begin_date" id="tma_begin_date" type="hidden" value="<?php echo $tmadate1; ?>" />
                <input name="tma_end_date" id="tma_end_date" type="hidden" value="<?php echo $tmadate2; ?>" />
                <script>
                    var yearsEE_1 = _("tma_begin_date").value.substr(4,4);
                    var monthsEE_1 = _("tma_begin_date").value.substr(2,2)-1;
                    var daysEE_1 = _("tma_begin_date").value.substr(0,2);
                    var countDownDateE_1 = new Date(yearsEE_1, monthsEE_1, daysEE_1).getTime();

                    var countDownDateE_0 = new Date().getTime();
                    if(countDownDateE_1 <= countDownDateE_0)
                    {
                        var yearsEE = _("tma_end_date").value.substr(4,4);
                        var monthsEE = _("tma_end_date").value.substr(2,2)-1;
                        var daysEE = _("tma_end_date").value.substr(0,2);

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
                <div id="demoE2" class="count_down_div" style="margin-left:2%">
                    00
                </div>
                <div id="demoE3" class="count_down_div" style="margin-left:2%">
                    00
                </div>
                <div id="demoE4" class="count_down_div" style="margin-left:2%">
                    00
                </div>
                <div id="demoE5" class="count_down_div" style="margin-left:2%; font-weight:bold;">
                    00
                </div>
            </div>
        </div>
    
        <div class="appl_left_child_div_child calendar_grid">
            <div style="flex:5%; padding-left:4px; height:50px; background-color: #ffffff">
                7
            </div>
            <div style="flex:20%; padding-left:4px; height:50px; background-color: #ffffff">
                Examination
            </div>
            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                <?php echo substr($examdate1,0,2).'/'.substr($examdate1,2,2).'/'.substr($examdate1,4,4);?>
            </div>
            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                <?php echo substr($examdate2,0,2).'/'.substr($examdate2,2,2).'/'.substr($examdate2,4,4);?>
            </div>
            <div style="flex:25%; padding-left:4px; height:50px; background-color: #ffffff">
                <input name="exam_begin_date" id="exam_begin_date" type="hidden" value="<?php echo $examdate1; ?>" />
                <input name="exam_end_date" id="exam_end_date" type="hidden" value="<?php echo $examdate2; ?>" />
                <script>
                    var yearsFF_1 = _("exam_begin_date").value.substr(4,4);
                    var monthsFF_1 = _("exam_begin_date").value.substr(2,2)-1;
                    var daysFF_1 = _("exam_begin_date").value.substr(0,2);
                    var countDownDateF_1 = new Date(yearsFF_1, monthsFF_1, daysFF_1).getTime();

                    var countDownDateF_0 = new Date().getTime();
                    if(countDownDateF_1 <= countDownDateF_0)
                    {
                        var yearsFF = _("exam_end_date").value.substr(4,4);
                        var monthsFF = _("exam_end_date").value.substr(2,2)-1;
                        var daysFF = _("exam_end_date").value.substr(0,2);

                        var countDownDateF = new Date(yearsFF, monthsFF, daysFF).getTime();
                        
                        // Update the count down every 1 second
                        var xF = setInterval(function() 
                        {
                            var nowF = new Date().getTime();
                            var distanceF = countDownDateF - nowF;

                            var weeksF = Math.floor(distanceF / (1000 * 60 * 60 * 24 * 7));
                            var daysF = Math.floor((distanceF % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24));
                            var hoursF = Math.floor((distanceF % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutesF = Math.floor((distanceF % (1000 * 60 * 60)) / (1000 * 60));
                            var secondsF = Math.floor((distanceF % (1000 * 60)) / 1000);

                            // Display the result in the element with id="demo"                    
                            _("demoF1").innerHTML = weeksF + "Wks ";                    
                            _("demoF2").innerHTML = daysF + "Days ";                    
                            _("demoF3").innerHTML = hoursF + "Hr ";
                            _("demoF4").innerHTML = minutesF + "Mins ";
                            _("demoF5").innerHTML = secondsF + "Sec ";

                            // If the count down is finished, write some text
                            if (distanceF < 0)
                            {
                                clearInterval(xF);
                                for (c = 1; c <= 5; c++)
                                {
                                    _("demoF"+c).style.display = 'none';
                                }
                                _("demoF").style.display = 'block';
                                _("demoF").innerHTML = 'Closed';
                            }else
                            { 
                                for (c = 1; c <= 5; c++)
                                {
                                    _("demoF"+c).style.display = 'block';
                                }
                                _("demoF").style.display = 'none';

                            }
                        }, 1000);
                    }
                </script>

                <div id="demoF" class="count_down_div" style="display:block; width:100%; height:auto;">
                    Loading...
                </div>
                <div id="demoF1" class="count_down_div" style="height:auto">
                    00
                </div>
                <div id="demoF2" class="count_down_div" style="margin-left:2%">
                    00
                </div>
                <div id="demoF3" class="count_down_div" style="margin-left:2%">
                    00
                </div>
                <div id="demoF4" class="count_down_div" style="margin-left:2%">
                    00
                </div>
                <div id="demoF5" class="count_down_div" style="margin-left:2%; font-weight:bold;">
                    00
                </div>
            </div>
        </div><?php
    }
}