<div id="container_cover_in_chkps_cal" class="center" style="display:block; 
    flex-direction:column; 
    gap:8px;  
    justify-content:space-around; 
    height:auto;
    padding:10px;
    box-shadow: 2px 2px 8px 2px #726e41;
    z-Index:3;
    background-color:#fff;
    position: absolute;
    max-height:65vh;
    overflow:auto;
    overflow-x:hidden;
    opacity:0.9;
    width:65vw;" 
    title="Press escape to close">
    <div style="line-height:1.5; width:70%; font-weight:bold">
        <?php echo "Student Academic Calendar for ".substr($orgsetins['cAcademicDesc'], 0, 4)." Academic Session,";

        if ($orgsetins['tSemester'] == 1)
        {
            echo ' First semester';
        }else if ($orgsetins['tSemester'] == 2)
        {
            echo ' Second semester';
        }?>
    </div>
    <div style="width:auto; float:right; margin-top:-20px;">
        <img style="width:17px; height:17px; cursor:pointer" src="./img/close.png" 
        onclick="_('container_cover_in_chkps_cal').style.zIndex = -1;
            _('container_cover_in_chkps_cal').style.display = 'none';
            _('cal_btn').style.display = 'block'"/>
    </div>
    
    <div class="innercont_stff" style="height:auto; width:100%; margin-top:10px; border-radius:3px; font-weight:bold;">
        <div class="_label" style="width:4%; height:18px; background-color:#ccc; border:0px solid #cdd8cf; padding:0px; padding-right:0.3%; padding-top:9px; padding-bottom:9px; text-align:right; margin-right:0.3%; background:#ccc">
            Sno
        </div>
        <div class="_label" style="width:41.8%; height:18px; background-color:#ccc; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px;margin-right:0.3%;">
            Event
        </div>
        <div class="_label" style="width:14%; height:18px; background-color:#ccc; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px;margin-right:0.3%;">
            Begins on...
        </div>
        <div class="_label" style="width:14%; height:18px; background-color:#ccc; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            Ends on...
        </div>
        <div class="_label" style="width:24.6%; height:18px; background-color:#ccc; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px;">
            Status/Time count-down
        </div>
    </div>
    
    
    <div class="innercont_stff" style="height:auto; width:100%; margin-top:5px; background-color:#fff; border-radius:3px;">
        <div class="_label" style="width:4%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-right:0.3%; padding-top:9px; padding-bottom:9px; text-align:right; margin-right:2px; margin-right:0.3%;">
            1
        </div>
        <div class="_label" style="width:41.8%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px; text-align:left; text-indent:5px; margin-right:0.3%;">
            Session
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['sesdate0'],0,2).'/'.substr($orgsetins['sesdate0'],2,2).'/'.substr($orgsetins['sesdate0'],4,4);?>
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['sesdate1'],0,2).'/'.substr($orgsetins['sesdate1'],2,2).'/'.substr($orgsetins['sesdate1'],4,4);?>
        </div>
        <div class="_label" style="width:24.6%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px;">
            <input name="session_begin_date" id="session_begin_date" type="hidden" value="<?php echo $orgsetins['sesdate0']; ?>" />
            <input name="session_end_date" id="session_end_date" type="hidden" value="<?php echo $orgsetins['sesdate1']; ?>" />
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

            <div id="demoA" class="count_down_div" style="display:block; height:auto;">
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

    <div class="innercont_stff" style="height:auto; width:100%; margin-top:5px; background-color:#dbe3dc; border-radius:3px;">
        <div class="_label" style="width:4%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-right:0.3%; padding-top:9px; padding-bottom:9px; text-align:right; margin-right:2px; margin-right:0.3%;">
            2
        </div>
        <div class="_label" style="width:41.8%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            Semester
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['semdate1'],0,2).'/'.substr($orgsetins['semdate1'],2,2).'/'.substr($orgsetins['semdate1'],4,4);?>
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['semdate2'],0,2).'/'.substr($orgsetins['semdate2'],2,2).'/'.substr($orgsetins['semdate2'],4,4);?>
        </div>
        <div class="_label" style="width:24.6%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px;">
            <input name="semester_begin_date" id="semester_begin_date" type="hidden" value="<?php echo $orgsetins['semdate1']; ?>" />
            <input name="semester_end_date" id="semester_end_date" type="hidden" value="<?php echo $orgsetins['semdate2']; ?>" />
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

            <div id="demoB" class="count_down_div" style="display:block; height:auto;">
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
    </div><?php

    $set_date_100 = substr($orgsetins['regdate_100_200_2'],4,4).'-'.substr($orgsetins['regdate_100_200_2'],2,2).'-'.substr($orgsetins['regdate_100_200_2'],0,2);
    $set_date_300 = substr($orgsetins['regdate_300_2'],4,4).'-'.substr($orgsetins['regdate_300_2'],2,2).'-'.substr($orgsetins['regdate_300_2'],0,2);?>

    <div class="innercont_stff" style="height:auto; width:100%; margin-top:5px; background-color:#fff; border-radius:3px;">
        <div class="_label" style="width:4%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-right:0.3%; padding-top:9px; padding-bottom:9px; text-align:right; margin-right:2px; margin-right:0.3%;">
            3a
        </div>
        <div class="_label" style="width:41.8%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            100L and 200L registration (Semester, course and examination)
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['regdate1'],0,2).'/'.substr($orgsetins['regdate1'],2,2).'/'.substr($orgsetins['regdate1'],4,4);?>
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['regdate_100_200_2'],0,2).'/'.substr($orgsetins['regdate_100_200_2'],2,2).'/'.substr($orgsetins['regdate_100_200_2'],4,4);?>
        </div>
        <div class="_label" style="width:24.6%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px;">
            <input name="registration_begin_date" id="registration_begin_date" type="hidden" value="<?php echo $orgsetins['regdate1']; ?>" />
            <input name="registration_end_date" id="registration_end_date" type="hidden" value="<?php echo $orgsetins['regdate_100_200_2']; ?>" />
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

            <div id="demoC" class="count_down_div" style="display:block; height:auto;">
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

    <div class="innercont_stff" style="height:auto; width:100%; margin-top:5px; background-color:#dbe3dc; border-radius:3px;">
        <div class="_label" style="width:4%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-right:0.3%; padding-top:9px; padding-bottom:9px; text-align:right; margin-right:2px; margin-right:0.3%;">
            3b
        </div>
        <div class="_label" style="width:41.8%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            300L and above Registration (Semester, course and examination)
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['regdate1'],0,2).'/'.substr($orgsetins['regdate1'],2,2).'/'.substr($orgsetins['regdate1'],4,4);?>
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['regdate_300_2'],0,2).'/'.substr($orgsetins['regdate_300_2'],2,2).'/'.substr($orgsetins['regdate_300_2'],4,4);?>
        </div>
        <div class="_label" style="width:24.6%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px;">
            <input name="registration_begin_date" id="registration_begin_date" type="hidden" value="<?php echo $orgsetins['regdate1']; ?>" />
            <input name="registration_end_dateb" id="registration_end_dateb" type="hidden" value="<?php echo $orgsetins['regdate_300_2']; ?>" />
            <script>
                var yearsCCb_1 = _("registration_begin_date").value.substr(4,4);
                var monthsCCb_1 = _("registration_begin_date").value.substr(2,2)-1;
                var daysCCb_1 = _("registration_begin_date").value.substr(0,2);
                var countDownDateCb_1 = new Date(yearsCCb_1, monthsCCb_1, daysCCb_1).getTime();

                var countDownDateCb_0 = new Date().getTime();
                if(countDownDateCb_1 <= countDownDateCb_0)
                {
                    var yearsCCb = _("registration_end_dateb").value.substr(4,4);
                    var monthsCCb = _("registration_end_dateb").value.substr(2,2)-1;
                    var daysCCb = _("registration_end_dateb").value.substr(0,2);

                    var countDownDateCb = new Date(yearsCCb, monthsCCb, daysCCb).getTime();
                    
                    // Update the count down every 1 second
                    var xCb = setInterval(function() 
                    {
                        var nowCb = new Date().getTime();
                        var distanceCb = countDownDateCb - nowCb;

                        var weeksCb = Math.floor(distanceCb / (1000 * 60 * 60 * 24 * 7));
                        var daysCb = Math.floor((distanceCb % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24));
                        var hoursCb = Math.floor((distanceCb % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutesCb = Math.floor((distanceCb % (1000 * 60 * 60)) / (1000 * 60));
                        var secondsCb = Math.floor((distanceCb % (1000 * 60)) / 1000);

                        // Display the result in the element with id="demo"                    
                        _("demoCb1").innerHTML = weeksCb + "Wks ";                    
                        _("demoCb2").innerHTML = daysCb + "Days ";                    
                        _("demoCb3").innerHTML = hoursCb + "Hr ";
                        _("demoCb4").innerHTML = minutesCb + "Mins ";
                        _("demoCb5").innerHTML = secondsCb + "Sec ";

                        // If the count down is finished, write some text
                        if (distanceCb < 0)
                        {
                            clearInterval(xCb);
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoCb"+c).style.display = 'none';
                            }
                            _("demoCb").style.display = 'block';
                            _("demoCb").innerHTML = 'Closed';
                        }else
                        { 
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoCb"+c).style.display = 'block';
                            }
                            _("demoCb").style.display = 'none';

                        }
                    }, 1000);
                }
            </script>

            <div id="demoCb" class="count_down_div" style="display:block; height:auto;">
                Loading...
            </div>
            <div id="demoCb1" class="count_down_div" style="height:auto;">
                00
            </div>
            <div id="demoCb2" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoCb3" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoCb4" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoCb5" class="count_down_div" style="margin-left:2%; font-weight:bold;">
                00
            </div>
        </div>
    </div>

    <div class="innercont_stff" style="height:auto; width:100%; margin-top:5px; background-color:#fff; border-radius:3px;">
        <div class="_label" style="width:4%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-right:0.3%; padding-top:9px; padding-bottom:9px; text-align:right; margin-right:0.3%;">
            4a
        </div>
        <div class="_label" style="width:41.8%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            Dropping of course for exam for 100L and 200L
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['regdate1'],0,2).'/'.substr($orgsetins['regdate1'],2,2).'/'.substr($orgsetins['regdate1'],4,4);?>
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px;" margin-right:0.3%;>
            <?php echo substr($orgsetins['drp_examdate'],0,2).'/'.substr($orgsetins['drp_examdate'],2,2).'/'.substr($orgsetins['drp_examdate'],4,4);?>
        </div>
        <div class="_label" style="width:24.6%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px;">
            <input name="exam_registration_drop_begin_date" id="exam_registration_drop_begin_date" type="hidden" value="<?php echo $orgsetins['regdate1']; ?>" />
            <input name="exam_registration_drop_end_date" id="exam_registration_drop_end_date" type="hidden" value="<?php echo $orgsetins['drp_examdate']; ?>" />
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

            <div id="demoD" class="count_down_div" style="display:block; height:auto;">
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
    </div>    
    
    <div class="innercont_stff" style="height:auto; width:100%; margin-top:5px; background-color:#dbe3dc; border-radius:3px;">
        <div class="_label" style="width:4%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-right:0.3%; padding-top:9px; padding-bottom:9px; text-align:right; margin-right:0.3%;">
            4b
        </div>
        <div class="_label" style="width:41.8%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            Dropping of course for exam for 300L and above
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['regdate1'],0,2).'/'.substr($orgsetins['regdate1'],2,2).'/'.substr($orgsetins['regdate1'],4,4);?>
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['drp_exam_2date'],0,2).'/'.substr($orgsetins['drp_exam_2date'],2,2).'/'.substr($orgsetins['drp_exam_2date'],4,4);?>
        </div>
        <div class="_label" style="width:24.6%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px;">
            <input name="exam_registration_drop_begin_dateb" id="exam_registration_drop_begin_dateb" type="hidden" value="<?php echo $orgsetins['regdate1']; ?>" />
            <input name="exam_registration_drop_end_dateb" id="exam_registration_drop_end_dateb" type="hidden" value="<?php echo $orgsetins['drp_exam_2date']; ?>" />
            <script>
                var yearsDDb_1 = _("exam_registration_drop_begin_dateb").value.substr(4,4);
                var monthsDDb_1 = _("exam_registration_drop_begin_dateb").value.substr(2,2)-1;
                var daysDDb_1 = _("exam_registration_drop_begin_dateb").value.substr(0,2);
                var countDownDateDb_1 = new Date(yearsDDb_1, monthsDDb_1, daysDDb_1).getTime();
                
                var countDownDateDb_0 = new Date().getTime();
                if(countDownDateDb_1 <= countDownDateDb_0)
                {
                    var yearsDDb = _("exam_registration_drop_end_dateb").value.substr(4,4);
                    var monthsDDb = _("exam_registration_drop_end_dateb").value.substr(2,2)-1;
                    var daysDDb = _("exam_registration_drop_end_dateb").value.substr(0,2);

                    var countDownDateDb = new Date(yearsDDb, monthsDDb, daysDDb).getTime();
                    
                    // Update the count down every 1 second
                    var xDb = setInterval(function() 
                    {
                        var nowDb = new Date().getTime();
                        var distanceDb = countDownDateDb - nowDb;

                        var weeksDb = Math.floor(distanceDb / (1000 * 60 * 60 * 24 * 7));
                        var daysDb = Math.floor((distanceDb % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24));
                        var hoursDb = Math.floor((distanceDb % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutesDb = Math.floor((distanceDb % (1000 * 60 * 60)) / (1000 * 60));
                        var secondsDb = Math.floor((distanceDb % (1000 * 60)) / 1000);

                        // Display the result in the element with id="demo"                    
                        _("demoDb1").innerHTML = weeksDb + "Wks ";                    
                        _("demoDb2").innerHTML = daysDb + "Days ";                    
                        _("demoDb3").innerHTML = hoursDb + "Hr ";
                        _("demoDb4").innerHTML = minutesDb + "Mins ";
                        _("demoDb5").innerHTML = secondsDb + "Sec ";

                        // If the count down is finished, write some text
                        if (distanceDb < 0)
                        {
                            clearInterval(xDb);
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoDb"+c).style.display = 'none';
                            }
                            _("demoDb").style.display = 'block';
                            _("demoDb").innerHTML = 'Closed';
                        }else
                        { 
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoDb"+c).style.display = 'block';
                            }
                            _("demoDb").style.display = 'none';

                        }
                    }, 1000);
                }
            </script>

            <div id="demoDb" class="count_down_div" style="display:block; height:auto;">
                Loading...
            </div>
            <div id="demoDb1" class="count_down_div" style="height:auto;">
                00
            </div>
            <div id="demoDb2" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoDb3" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoDb4" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoDb5" class="count_down_div" style="margin-left:2%; font-weight:bold;">
                00
            </div>
        </div>
    </div>

    <div class="innercont_stff" style="height:auto; width:100%; margin-top:5px; background-color:#fff; border-radius:3px;">
        <div class="_label" style="width:4%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-right:0.3%; padding-top:9px; padding-bottom:9px; text-align:right;  margin-right:0.3%;">
            5a
        </div>
        <div class="_label" style="width:41.8%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            Requests for change for 100L and 200L
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['regdate1'],0,2).'/'.substr($orgsetins['regdate1'],2,2).'/'.substr($orgsetins['regdate1'],4,4);?>
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['student_req1'],0,2).'/'.substr($orgsetins['student_req1'],2,2).'/'.substr($orgsetins['student_req1'],4,4);?>
        </div>
        <div class="_label" style="width:24.6%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px;">
            <input name="request_begin_date" id="request_begin_date" type="hidden" value="<?php echo $orgsetins['regdate1']; ?>" />
            <input name="request_end_date" id="request_end_date" type="hidden" value="<?php echo $orgsetins['student_req1']; ?>" />
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

            <div id="demoG" class="count_down_div" style="display:block; height:auto;">
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
    </div>

    <div class="innercont_stff" style="height:auto; width:100%; margin-top:5px; background-color:#dbe3dc; border-radius:3px;">
        <div class="_label" style="width:4%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-right:0.3%; padding-top:9px; padding-bottom:9px; text-align:right;  margin-right:0.3%;">
            5b
        </div>
        <div class="_label" style="width:41.8%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            Requests for change for 300L and above
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['regdate1'],0,2).'/'.substr($orgsetins['regdate1'],2,2).'/'.substr($orgsetins['regdate1'],4,4);?>
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['student_req2'],0,2).'/'.substr($orgsetins['student_req2'],2,2).'/'.substr($orgsetins['student_req2'],4,4);?>
        </div>
        <div class="_label" style="width:24.6%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px;">
            <input name="request_begin_dateb" id="request_begin_dateb" type="hidden" value="<?php echo $orgsetins['regdate1']; ?>" />
            <input name="request_end_dateb" id="request_end_dateb" type="hidden" value="<?php echo $orgsetins['student_req2']; ?>" />
            <script>
                var yearsGGb_1 = _("request_begin_dateb").value.substr(4,4);
                var monthsGGb_1 = _("request_begin_dateb").value.substr(2,2)-1;
                var daysGGb_1 = _("request_begin_dateb").value.substr(0,2);
                var countDownDateGb_1 = new Date(yearsGGb_1, monthsGGb_1, daysGGb_1).getTime();
                
                var countDownDateGb_0 = new Date().getTime();
                if(countDownDateGb_1 <= countDownDateGb_0)
                {
                    var yearsGGb = _("request_end_dateb").value.substr(4,4);
                    var monthsGGb = _("request_end_dateb").value.substr(2,2)-1;
                    var daysGGb = _("request_end_dateb").value.substr(0,2);

                    var countDownDateGb = new Date(yearsGGb, monthsGGb, daysGGb).getTime();
                    
                    // Update the count down every 1 second
                    var xGb = setInterval(function() 
                    {
                        var nowGb = new Date().getTime();
                        var distanceGb = countDownDateGb - nowGb;

                        var weeksGb = Math.floor(distanceGb / (1000 * 60 * 60 * 24 * 7));
                        var daysGb = Math.floor((distanceGb % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24));
                        var hoursGb = Math.floor((distanceGb % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutesGb = Math.floor((distanceGb % (1000 * 60 * 60)) / (1000 * 60));
                        var secondsGb = Math.floor((distanceGb % (1000 * 60)) / 1000);

                        // Display the result in the element with id="demo"                    
                        _("demoGb1").innerHTML = weeksGb + "Wks ";                    
                        _("demoGb2").innerHTML = daysGb + "Days ";                    
                        _("demoGb3").innerHTML = hoursGb + "Hr ";
                        _("demoGb4").innerHTML = minutesGb + "Mins ";
                        _("demoGb5").innerHTML = secondsGb + "Sec ";

                        // If the count down is finished, write some text
                        if (distanceGb < 0)
                        {
                            clearInterval(xGb);
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoGb"+c).style.display = 'none';
                            }
                            _("demoGb").style.display = 'block';
                            _("demoGb").innerHTML = 'Closed';
                        }else
                        { 
                            for (c = 1; c <= 5; c++)
                            {
                                _("demoGb"+c).style.display = 'block';
                            }
                            _("demoGb").style.display = 'none';

                        }
                    }, 1000);
                }
            </script>

            <div id="demoGb" class="count_down_div" style="display:block; height:auto;">
                Loading...
            </div>
            <div id="demoGb1" class="count_down_div" style="height:auto;">
                00
            </div>
            <div id="demoGb2" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoGb3" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoGb4" class="count_down_div" style="margin-left:2%">
                00
            </div>
            <div id="demoGb5" class="count_down_div" style="margin-left:2%; font-weight:bold;">
                00
            </div>
        </div>
    </div>

    <div class="innercont_stff" style="height:auto; width:100%; margin-top:5px; background-color:#fff; border-radius:3px;">
        <div class="_label" style="width:4%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-right:0.3%; padding-top:9px; padding-bottom:9px; text-align:right; margin-right:0.3%;">
            6
        </div>
        <div class="_label" style="width:41.8%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            Tutor Marked Assignement (TMA)
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['tmadate1'],0,2).'/'.substr($orgsetins['tmadate1'],2,2).'/'.substr($orgsetins['tmadate1'],4,4);?>
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['tmadate2'],0,2).'/'.substr($orgsetins['tmadate2'],2,2).'/'.substr($orgsetins['tmadate2'],4,4);?>
        </div>
        <div class="_label" style="width:24.6%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px;">
            <input name="tma_begin_date" id="tma_begin_date" type="hidden" value="<?php echo $orgsetins['tmadate1']; ?>" />
            <input name="tma_end_date" id="tma_end_date" type="hidden" value="<?php echo $orgsetins['tmadate2']; ?>" />
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

            <div id="demoE" class="count_down_div" style="display:block; height:auto;">
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

    <div class="innercont_stff" style="height:auto; width:100%; margin-top:5px; background-color:#dbe3dc; border-radius:3px;">
        <div class="_label" style="width:4%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-right:0.3%; padding-top:9px; padding-bottom:9px; text-align:right; margin-right:0.3%;">
            7
        </div>
        <div class="_label" style="width:41.8%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            Examination
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['examdate1'],0,2).'/'.substr($orgsetins['examdate1'],2,2).'/'.substr($orgsetins['examdate1'],4,4);?>
        </div>
        <div class="_label" style="width:14%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px; margin-right:0.3%;">
            <?php echo substr($orgsetins['examdate2'],0,2).'/'.substr($orgsetins['examdate2'],2,2).'/'.substr($orgsetins['examdate2'],4,4);?>
        </div>
        <div class="_label" style="width:24.6%; height:18px; border:0px solid #cdd8cf; padding:0px; padding-top:9px; padding-bottom:9px;text-align:left; text-indent:5px;">
            <input name="exam_begin_date" id="exam_begin_date" type="hidden" value="<?php echo $orgsetins['examdate1']; ?>" />
            <input name="exam_end_date" id="exam_end_date" type="hidden" value="<?php echo $orgsetins['examdate2']; ?>" />
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

            <div id="demoF" class="count_down_div" style="display:block; height:auto;">
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
    </div>
</div>