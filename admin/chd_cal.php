<?php
$semester0 = '';
$semester1 = '';
$regist0 = '';
$regist1 = '';
$project0  = '';
$project1 = '';
$exami0 = ''; 
$exami1 = '';

$stmt = $mysqli->prepare("SELECT sem0, sem1, reg0, reg1, prj0, prj1, exam0, exam1
FROM other_cals
WHERE prog_name like 'CHD%'");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($semester0, $semester1, $regist0, $regist1, $project0, $project1, $exami0, $exami1);
$stmt->fetch();
$stmt->close();?>

<div id="smke_screen_5" class="smoke_scrn" style="opacity:0.7; display:none; z-index:-1"></div>

<div id="chd_div" class="center top_most" 
    style="display:none; 
    text-align:center; 
    padding:15px; 
    box-shadow: 2px 2px 8px 2px #726e41; 
    background:#FFFFFF;
    width:650px;
    z-Index:-1;">
    <div style="width:99%; float:left; text-align:left; padding-bottom:10px; color:#e31e24; font-weight:bold; border-bottom:1px #ccc solid">
        Academic calendar for the Directorate of Human Resources Development
        <a href="#" style="text-decoration:none;">
            <div id="msg_title" style="width:1%; float:right; text-align:center;">
                <img style="width:17px; height:17px; cursor:pointer" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" 
                    onclick="_('chd_div').style.display='none';
                    _('chd_div').style.zIndex='-1';
                    _('smke_screen_5').style.display='none';
                    _('smke_screen_5').style.zIndex='-1';
                    return false"/>
            </div>
        </a>
    </div>
    
    <div class="innercont_stff" style="margin-top:20px;">
        <label for="chd_semester0" class="labell" style="width:220px;">Semester begins on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="chd_semester0" id="chd_semester0" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $semester0;?>"
                onchange="_('chd_regist0').mmin=this.value;
                _('chd_regist1').max=this.value;
                _('chd_exami1').max=this.value;"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="semester0_h" id="semester0_h" type="hidden" value="<?php echo $semester0;?>" />
        </div>
        <div id="labell_msg1c_chd" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>


    <div class="innercont_stff" style="margin-top:10px;">
        <label for="chd_semester1" class="labell" style="width:220px;">Semester ends on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="chd_semester1" id="chd_semester1" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $semester1;?>"
                onchange="_('chd_regist0').max=this.value;
                _('chd_regist1').max=this.value;
                _('chd_exami1').max=this.value;"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="semester1_h" id="semester1_h" type="hidden" value="<?php echo $semester1;?>" />
        </div>
        <div id="labell_msg2c_chd" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>
    
    
    <div class="innercont_stff" style="margin-top:20px;">
        <label for="chd_regist0" class="labell" style="width:220px;">Registration begins on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="chd_regist0" id="chd_regist0" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $regist0;?>"
                onchange="_('chd_regist1').min = this.value;"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="semester1_h" id="semester1_h" type="hidden" value="<?php echo $semester1;?>" />
        </div>
        <div id="labell_msg3c_chd" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>


    <div class="innercont_stff" style="margin-top:10px;">
        <label for="chd_regist1" class="labell" style="width:220px;">Registration ends on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="chd_regist1" id="chd_regist1" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $regist1;?>"
                onchange="_('chd_regist0').max=this.value;
                _('chd_exami0').min=this.value;"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="regist0_h" id="regist0_h" type="hidden" value="<?php echo $regist0;?>" />
        </div>
        <div id="labell_msg4c_chd" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>
    
    
    <div class="innercont_stff" style="margin-top:20px;">
        <label for="chd_project0" class="labell" style="width:220px;">Project (Business Canvas): begins on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="chd_project0" id="chd_project0" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $project0;?>"
                onchange="_('chd_project1').min = this.value;"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="project0_h" id="project0_h" type="hidden" value="<?php echo $project0;?>" />
        </div>
        <div id="labell_msg5c_chd" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>


    <div class="innercont_stff" style="margin-top:10px;">
        <label for="chd_project1" class="labell" style="width:220px;">Project (Business Canvas): ends on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="chd_project1" id="chd_project1" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $project1;?>"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="project0_h" id="project0_h" type="hidden" value="<?php echo $project0;?>" />
        </div>
        <div id="labell_msg6c_chd" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>
    
    
    <div class="innercont_stff" style="margin-top:20px;">
        <label for="chd_exami0" class="labell" style="width:220px;">Examination begins on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="chd_exami0" id="chd_exami0" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $exami0;?>"
                onchange="_('chd_exami1').min = this.value;"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="exami0_h" id="exami0_h" type="hidden" value="<?php echo $exami0;?>" />
        </div>
        <div id="labell_msg7c_chd" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>


    <div class="innercont_stff" style="margin-top:10px;">
        <label for="chd_exami1" class="labell" style="width:220px;">Examination ends on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="chd_exami1" id="chd_exami1" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $exami1;?>"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="exami1_h" id="exami1_h" type="hidden" value="<?php echo $exami1;?>" />
        </div>
        <div id="labell_msg8c_chd" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>

    <div id="add_qual_div" class="submit_button_green" 
        style="margin-left:0px; 
        padding:10px; 
        width:118px;
        float:right;
        cursor:pointer;" 
        title="Click to call up Directorate for Entrepreneurship and General Studies (DEGS) calendar"
        onclick="_('submission').value='1';
        save_cal_1(); return;
        _('chd_div').style.display='none';
        _('chd_div').style.zIndex='-1';
        _('smke_screen_5').style.display='none';
        _('smke_screen_5').style.zIndex='-1';">
        Submit
    </div>
    <input name="submission" id="submission" type="hidden" />
</div>

<script>
    function set_new_date_1(dateValue)
    {
        var date = new Date(dateValue);
        date.setDate(date.getDate() + 1);
        
        var month = date.getUTCMonth() + 1;
        month = pad_1(month, 0, 2);

        var day = date.getUTCDate();
        day = pad_1(day, 0, 2);

        var year = date.getUTCFullYear();
        year = pad_1(year, 0, 2);

        return year + '-'+ month + '-' + day;
    }
    
    function pad_1(toPad, padChar, lenth)
    {
        if (toPad.toString().length < lenth)
        {
            return padChar + toPad.toString();
        }else
        {
            return toPad;
        }
    }

    function save_cal_1()
    {
        var ulChildNodes = _("container").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }

        if (_("chd_semester0").value == '')
        {
            setMsgBox("labell_msg1c_chd","");
            _("chd_semester0").focus();
            return false;
        }else if (_("chd_semester1").value == '')
        {
            setMsgBox("labell_msg2c_chd","");
            _("chd_semester0").focus();
            return false;
        }else if (_("chd_regist0").value == '')
        {
            setMsgBox("labell_msg3c_chd","");
            _("chd_regist0").focus();
            return false;
        }else if (_("chd_regist1").value == '')
        {
            setMsgBox("labell_msg4c_chd","");
            _("chd_regist1").focus();
            return false;
        }else if (_("chd_project0").value == '')
        {
            setMsgBox("labell_msg5c_chd","");
            _("chd_project0").focus();
            return false;
        }else if (_("chd_project1").value == '')
        {
            setMsgBox("labell_msg6c_chd","");
            _("chd_project1").focus();
            return false;
        }else if (_("chd_exami0").value == '')
        {
            setMsgBox("labell_msg7c_chd","");
            _("chd_exami0").focus();
            return false;
        }else if (_("chd_exami1").value == '')
        {
            setMsgBox("labell_msg8c_chd","");
            _("chd_exami1").focus();
            return false;
        }
        
        var formdata = new FormData();

        formdata.append("ilin", _('nxt').ilin.value);
        formdata.append("session_year0", '');
        
        formdata.append("semester0", _("chd_semester0").value);
        formdata.append("semester1", _("chd_semester1").value);
        
        formdata.append("regist0", _("chd_regist0").value);
        formdata.append("regist1", _("chd_regist1").value);
        
        formdata.append("project0", _("chd_project0").value);
        formdata.append("project1", _("chd_project1").value);
        
        formdata.append("exami0", _("chd_exami0").value);
        formdata.append("exami1", _("chd_exami1").value);
        formdata.append("dept", "CHD");

        if (_('submission').value == '1')
        {
            formdata.append("submission", '1');
        }

        opr_prep_2(ajax = new XMLHttpRequest(),formdata);
    }

    function opr_prep_2(ajax,formdata)
    {
        ajax.upload.addEventListener("progress", progressHandler_2, false);
        ajax.addEventListener("load", completeHandler_2, false);
        ajax.addEventListener("error", errorHandler_2, false);
        ajax.addEventListener("abort", abortHandler_2, false);
        
        ajax.open("POST", "save_other_cal");
        ajax.send(formdata);
    }

    function completeHandler_2(event)
    {
        on_error('0');
        on_abort('0');
        in_progress('0');

        var returnedStr = event.target.responseText;

        if (returnedStr == 'Success')
        {
            success_box(returnedStr);
        }else
        {
            caution_box(returnedStr);
        }
    }
    
    function progressHandler_2(event)
    {
        in_progress('1');
    }

    function errorHandler_2(event)
    {
        on_error('1');
    }

    function abortHandler_2(event)
    {
        on_abort('1');
    }
</script>