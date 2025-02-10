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
WHERE prog_name like 'DEG%'");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($semester0, $semester1, $regist0, $regist1, $project0, $project1, $exami0, $exami1);
$stmt->fetch();
$stmt->close();?>

<div id="smke_screen_5" class="smoke_scrn" style="opacity:0.7; display:none; z-index:-1"></div>

<div id="degs_div" class="center top_most" 
    style="display:none; 
    text-align:center; 
    padding:15px; 
    box-shadow: 2px 2px 8px 2px #726e41; 
    background:#FFFFFF;
    width:650px;
    z-Index:-1;">
    <div style="width:99%; float:left; text-align:left; padding-bottom:10px; color:#e31e24; font-weight:bold; border-bottom:1px #ccc solid">
        Academic calendar for the Directorate of Entrepreneurship and General Studies<!--Cert., Entrepreneurship Education-->
        <a href="#" style="text-decoration:none;">
            <div id="msg_title" style="width:1%; float:right; text-align:center;">
                <img style="width:17px; height:17px; cursor:pointer" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" 
                    onclick="_('degs_div').style.display='none';
                    _('degs_div').style.zIndex='-1';
                    _('smke_screen_5').style.display='none';
                    _('smke_screen_5').style.zIndex='-1';
                    return false"/>
            </div>
        </a>
    </div>
    
    <div class="innercont_stff" style="margin-top:20px;">
        <label for="semester0" class="labell" style="width:220px;">Semester begins on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="semester0" id="semester0" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $semester0;?>"
                onchange="_('regist0').min=this.value;
                _('semester1').min = this.value;
                //_('regist0').min=set_new_date(this.value);
                _('exami0').min=set_new_date(this.value);"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="semester0_h" id="semester0_h" type="hidden" value="<?php echo $semester0;?>" />
        </div>
        <div id="labell_msg1c" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>


    <div class="innercont_stff" style="margin-top:10px;">
        <label for="semester1" class="labell" style="width:220px;">Semester ends on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="semester1" id="semester1" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $semester1;?>"
                onchange="_('regist0').max=this.value;
                _('regist1').max=this.value;
                _('exami1').max=this.value;"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="semester1_h" id="semester1_h" type="hidden" value="<?php echo $semester1;?>" />
        </div>
        <div id="labell_msg2c" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>
    
    
    <div class="innercont_stff" style="margin-top:20px;">
        <label for="regist0" class="labell" style="width:220px;">Registration begins on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="regist0" id="regist0" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $regist0;?>"
                onchange="_('regist1').min = this.value;"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="semester1_h" id="semester1_h" type="hidden" value="<?php echo $semester1;?>" />
        </div>
        <div id="labell_msg3c" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>


    <div class="innercont_stff" style="margin-top:10px;">
        <label for="regist1" class="labell" style="width:220px;">Registration ends on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="regist1" id="regist1" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $regist1;?>"
                onchange="_('regist0').max=this.value;
                _('exami0').min=this.value;"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="regist0_h" id="regist0_h" type="hidden" value="<?php echo $regist0;?>" />
        </div>
        <div id="labell_msg4c" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>
    
    
    <div class="innercont_stff" style="margin-top:20px;">
        <label for="project0" class="labell" style="width:220px;">Project (Business Canvas): begins on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="project0" id="project0" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $project0;?>"
                onchange="_('project1').min = this.value;"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="project0_h" id="project0_h" type="hidden" value="<?php echo $project0;?>" />
        </div>
        <div id="labell_msg5c" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>


    <div class="innercont_stff" style="margin-top:10px;">
        <label for="project1" class="labell" style="width:220px;">Project (Business Canvas): ends on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="project1" id="project1" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $project1;?>"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="project0_h" id="project0_h" type="hidden" value="<?php echo $project0;?>" />
        </div>
        <div id="labell_msg6c" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>
    
    
    <div class="innercont_stff" style="margin-top:20px;">
        <label for="exami0" class="labell" style="width:220px;">Examination begins on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="exami0" id="exami0" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $exami0;?>"
                onchange="_('exami1').min = this.value;"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="exami0_h" id="exami0_h" type="hidden" value="<?php echo $exami0;?>" />
        </div>
        <div id="labell_msg7c" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>


    <div class="innercont_stff" style="margin-top:10px;">
        <label for="exami1" class="labell" style="width:220px;">Examination ends on</label>
        <div class="div_select" style="width:118px;">
            <input type="date" name="exami1" id="exami1" class="textbox" style="height:99%; width:99%" 
                value="<?php echo $exami1;?>"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            <input name="exami1_h" id="exami1_h" type="hidden" value="<?php echo $exami1;?>" />
        </div>
        <div id="labell_msg8c" class="labell_msg blink_text orange_msg" style="width:270px; text-align:left;"></div>
    </div>

    <div id="add_qual_div" class="submit_button_green" 
        style="margin-left:0px; 
        padding:10px; 
        width:118px;
        float:right;
        cursor:pointer;" 
        title="Click to call up Directorate for Entrepreneurship and General Studies (DEGS) calendar"
        onclick="_('submission').value='1';
        save_cal();">
        Submit
    </div>
    <input name="submission" id="submission" type="hidden" />
</div>

<script>
    function set_new_date(dateValue)
    {
        var date = new Date(dateValue);
        date.setDate(date.getDate() + 1);
        
        var month = date.getUTCMonth() + 1;
        month = pad(month, 0, 2);

        var day = date.getUTCDate();
        day = pad(day, 0, 2);

        var year = date.getUTCFullYear();
        year = pad(year, 0, 2);

        return year + '-'+ month + '-' + day;
    }
    
    function pad(toPad, padChar, lenth)
    {
        if (toPad.toString().length < lenth)
        {
            return padChar + toPad.toString();
        }else
        {
            return toPad;
        }
    }

    function save_cal()
    {
        var ulChildNodes = _("container").getElementsByClassName("labell_msg");
        for (j = 0; j <= ulChildNodes.length-1; j++)
        {
            ulChildNodes[j].style.display = 'none';
        }

        if (_("semester0").value == '')
        {
            setMsgBox("labell_msg1c","");
            _("semester0").focus();
            return false;
        }else if (_("semester1").value == '')
        {
            setMsgBox("labell_msg2c","");
            _("semester1").focus();
            return false;
        }else if (_("regist0").value == '')
        {
            setMsgBox("labell_msg3c","");
            _("regist0").focus();
            return false;
        }else if (_("regist1").value == '')
        {
            setMsgBox("labell_msg4c","");
            _("regist1").focus();
            return false;
        }else if (_("project0").value == '')
        {
            setMsgBox("labell_msg5c","");
            _("project0").focus();
            return false;
        }else if (_("project1").value == '')
        {
            setMsgBox("labell_msg6c","");
            _("project1").focus();
            return false;
        }else if (_("exami0").value == '')
        {
            setMsgBox("labell_msg7c","");
            _("exami0").focus();
            return false;
        }else if (_("exami1").value == '')
        {
            setMsgBox("labell_msg8c","");
            _("exami1").focus();
            return false;
        }
        
        var formdata = new FormData();

        formdata.append("ilin", _('nxt').ilin.value);

        formdata.append("session_year0", '');
        
        formdata.append("semester0", _("semester0").value);
        formdata.append("semester1", _("semester1").value);
        
        formdata.append("regist0", _("regist0").value);
        formdata.append("regist1", _("regist1").value);
        
        formdata.append("project0", _("project0").value);
        formdata.append("project1", _("project1").value);
        
        formdata.append("exami0", _("exami0").value);
        formdata.append("exami1", _("exami1").value);
        formdata.append("dept", "DEG");

        if (_('submission').value == '1')
        {
            formdata.append("submission", '1');
        }
       
        opr_prep_1(ajax = new XMLHttpRequest(),formdata);
    }

    function opr_prep_1(ajax,formdata)
    {
        ajax.upload.addEventListener("progress", progressHandler_1, false);
        ajax.addEventListener("load", completeHandler_1, false);
        ajax.addEventListener("error", errorHandler_1, false);
        ajax.addEventListener("abort", abortHandler_1, false);
        
        ajax.open("POST", "save_other_cal");
        ajax.send(formdata);
    }

    function completeHandler_1(event)
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
    
    function progressHandler_1(event)
    {
        in_progress('1');
    }

    function errorHandler_1(event)
    {
        on_error('1');
    }

    function abortHandler_1(event)
    {
        on_abort('1');
    }
</script>