document.onkeydown = function (e) 
{
    if (e.ctrlKey && e.keyCode === 85) 
    {
        return false;
    }
}


function chk_inputs()
{		
    var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
    for (j = 0; j <= ulChildNodes.length-1; j++)
    {
        ulChildNodes[j].style.display = 'none';
    }
    
    
    var formdata = new FormData();			
    
    if (_('schl_session').value == '')
    {
        setMsgBox("labell_msg7","");
        result_stff_loc.save.value = 0;
        _('schl_session').focus();
        return;
    }

    if (_('schl_semester').value == '')
    {
        setMsgBox("labell_msg7a","");
        result_stff_loc.save.value = 0;
        _('schl_semester').focus();
        return;
    }

    var files = _("sbtd_pix").files;
    
    if (_("sbtd_pix").files.length == 0)
    {
        setMsgBox("labell_msg8","");
        result_stff_loc.save.value = 0;
        return;
    }else if (files[0].type != 'text/csv' /*&& files[0].type != 'application/vnd.ms-excel' && files[0].type != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'*/)
    { 
        setMsgBox("labell_msg8","Only CSV file is allowed");
        result_stff_loc.save.value = 0;
        return;
    }else if (files[0].length <= 1 /*|| files[0].size <= 16*/)
    {
        setMsgBox("labell_msg8","Empty file not allowed");
        result_stff_loc.save.value = 0;
        return;
    }
        
    formdata.append("save", result_stff_loc.save.value);
    
    formdata.append("user_cat", result_stff_loc.user_cat.value);
    formdata.append("currency", result_stff_loc.currency.value);
    formdata.append("ilin", result_stff_loc.ilin.value);
    formdata.append("sm", result_stff_loc.sm.value);
    formdata.append("mm", result_stff_loc.mm.value);
    
    formdata.append("vApplicationNo",result_stff_loc.vApplicationNo.value);
                    
    formdata.append("whattodo", result_stff_loc.whattodo.value);

    formdata.append("schl_session", _("schl_session").value);
    formdata.append("for_diff_course", '1');
    
    
    formdata.append("sbtd_pix", _("sbtd_pix").files[0]);

    var file_name = _("sbtd_pix").files[0].name;
    var file_name_ext = file_name.substr( _("sbtd_pix").files[0].name.indexOf(".")+1);

    if (file_name_ext != "csv" /*&& file_name_ext != "xls" && file_name_ext != "xlsx"*/)
    {
        setMsgBox("labell_msg8","Invalid file format. There should be only one dot in the file name");
        result_stff_loc.save.value = 0;
        return;
    }
    formdata.append("file_name_ext", file_name_ext);
    
    if (_('schl_semester_div').style.display == 'block')
    {
        formdata.append("schl_semester", _("schl_semester").value);
    }

    opr_prep(ajax = new XMLHttpRequest(),formdata);
    
}
    
function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);

    ajax.open("POST", "opr_result_stff.php");
    ajax.send(formdata);
}


function completeHandler(event)
{
    var returnedStr = event.target.responseText;
        
    on_error('0');
    on_abort('0');
    in_progress('0');

    _("succ_boxt").style.display = 'block';
    
    _("message_text2").style.display = 'none';
    _("message_text3").style.display = 'none';

    if ( returnedStr.indexOf("?") != -1)
    {
        _("submityes_msg").innerHTML = returnedStr;
        _("submityes").style.display = 'block';
    }else if (_('whattodo').value == '2' || _('whattodo').value == '4' || _('whattodo').value == '16')
    {
        _('succ_boxt').className = "succ_box blink_text orange_msg";
        if (returnedStr.indexOf("successfully") != -1)
        {
            _('succ_boxt').className = "succ_box blink_text green_msg";
        }
                        
        if (returnedStr.indexOf("Sorry") != -1)
        {
            //_("succ_boxt").innerHTML = returnedStr;
            _("message_text").innerHTML = returnedStr;
        }else if (returnedStr.indexOf("Invalid") != -1 || returnedStr.indexOf("has no") != -1 || returnedStr.indexOf("did not") != -1)
        {
            if (returnedStr.indexOf("+") != -1)
            {
                //_("succ_boxt").innerHTML = returnedStr.substr(0,returnedStr.indexOf("+")-1);
                _("message_text").innerHTML = returnedStr.substr(returnedStr.indexOf("+")+1);
            }else
            {
                //_("succ_boxt").innerHTML = returnedStr;
                _("message_text").innerHTML = returnedStr;
            }
        }else
        {
            //_("succ_boxt").innerHTML = returnedStr;
        }
    }else if (_('whattodo').value == '10')//iss
    {			
        if (returnedStr.indexOf("needs to") != -1 || returnedStr.indexOf("did not") != -1)
        {
            _('succ_boxt').className = "succ_box blink_text orange_msg";
            //_("succ_boxt").innerHTML = returnedStr;
            return;
        }

        _("message_text2").style.display = 'block';	
        var serialNo = 0;
        var prev_level = '';
        var prev_semester = '';

        var student_name = returnedStr.substr(0,returnedStr.indexOf("#"));
        returnedStr = returnedStr.substr(returnedStr.indexOf("#")+1);
        
        

        prns_form.student_name.value = student_name;

        _('div_header_left2').innerHTML = 'Score sheet for ' + result_stff_loc.vMatricNo.value+', '+student_name;

        // while (_("ul_courses").hasChildNodes())
        // {  
        //     _("ul_courses").removeChild(_("ul_courses").firstChild);
        // }
        
        /*for (var counter = 0; counter <= returnedStr.length-1; counter+=190)
        {
            serialNo++;
            prns_form.select_level_1.value = returnedStr.substr(counter+150,10).trim();
            prns_form.select_semester_1.value = returnedStr.substr(counter+180,10).trim();
            
            if ((prev_level == '' || (prev_level != returnedStr.substr(counter+150,10).trim())) ||
            (prev_semester == '' || (prev_semester != returnedStr.substr(counter+180,10).trim())))
            {
                var li = document.createElement('li');
                li.style.height = '25px';
                li.style.marginTop = '0px';
                li.style.border = '0px';
                
                var div1 = document.createElement('div');
                div1.setAttribute('class','ctabletd_1');
                div1.style.backgroundColor = '#ffffff';
                div1.style.width = '702px';
                div1.style.paddingRight = '3px';
                div1.style.textAlign = 'left';
                div1.style.fontWeight = 'bold';
                div1.innerHTML = returnedStr.substr(counter+160,10).trim()+' '+returnedStr.substr(counter+150,10).trim()+' Level, Semester: '+returnedStr.substr(counter+180,10).trim();
                li.appendChild(div1);
                _("ul_courses").appendChild(li);
            }

            var li = document.createElement('li');
            li.style.height = '25px';
            li.style.marginTop = '0px';
            li.style.border = '0px';
            if (serialNo%2 == 0)
            {
                li.style.backgroundColor = '#ffffff';
            }else
            {
                li.style.backgroundColor = '#cccccc';
            }

            var div1 = document.createElement('div');
            div1.setAttribute('class','ctabletd_1');
            
            div1.style.width = '40px';
            div1.style.paddingRight = '3px';
            div1.style.textAlign = 'right';
            div1.innerHTML = serialNo;
            li.appendChild(div1);

            //course code
            var div1 = document.createElement('div');
            div1.setAttribute('class','ctabletd_1');
            
            div1.style.width = '83px';
            div1.style.textIndent = '3px';
            div1.style.textAlign = 'left';
            div1.innerHTML =  returnedStr.substr(counter,10).trim();
            li.appendChild(div1);

            //title
            var div1 = document.createElement('div');
            div1.setAttribute('class','ctabletd_1');
            
            div1.style.width = '350px';
            div1.style.textIndent = '3px';
            div1.style.textAlign = 'left';
            div1.innerHTML =  returnedStr.substr(counter+10,100).trim();
            li.appendChild(div1);

            //credit unit
            var div1 = document.createElement('div');
            div1.setAttribute('class','ctabletd_1');
            
            div1.style.width = '35px';
            div1.style.paddingRight = '3px';
            div1.style.textAlign = 'right';
            div1.innerHTML =  returnedStr.substr(counter+110,10).trim();
            li.appendChild(div1);

            //CA
            var div1 = document.createElement('div');
            div1.setAttribute('class','ctabletd_1');
            if (serialNo%2 == 0)
            {
                div1.style.backgroundColor = '#ffffff';
            }else
            {
                div1.style.backgroundColor = '#cccccc';
            }
            div1.style.width = '50px';
            div1.style.paddingRight = '3px';
            div1.style.textAlign = 'right';
            div1.innerHTML =  returnedStr.substr(counter+120,10).trim();
            li.appendChild(div1);

            //Exam
            var div1 = document.createElement('div');
            div1.setAttribute('class','ctabletd_1');
            
            div1.style.width = '50px';
            div1.style.paddingRight = '3px';
            div1.style.textAlign = 'right';
            div1.innerHTML =  returnedStr.substr(counter+130,10).trim();
            li.appendChild(div1);

            //score
            var div1 = document.createElement('div');
            div1.setAttribute('class','ctabletd_1');
            
            div1.style.paddingRight = '3px';
            div1.style.textAlign = 'right';
            div1.style.width = '68px';
            div1.innerHTML =  returnedStr.substr(counter+140,10).trim();
            li.appendChild(div1);
            
            _("ul_courses").appendChild(li);
            prev_level = returnedStr.substr(counter+150,10).trim();
            prev_semester = returnedStr.substr(counter+180,10).trim();
        }*/

        //_("succ_boxt").style.display= 'none';
        _('container_cover_in2').style.display= 'block';
        _('container_cover_in2').style.zIndex = 1;
        result_stff_loc.save.value = 0;
    }else if (_('whattodo').value == '11')//css
    {				
        /*if (returnedStr.indexOf("did not") != -1)
        {
            _('succ_boxt').className = "succ_box blink_text orange_msg";
            //_("succ_boxt").innerHTML = returnedStr;
            return;
        }
        
        _("message_text3").style.display = 'block';
        
        _('div_header_left2').innerHTML = 'Score sheet for <b>' + result_stff_loc.courseId1.options[result_stff_loc.courseId1.selectedIndex].text.substr(6) +', ' + result_stff_loc.schl_session.value+'</b>';

        prns_form.student_name.value = result_stff_loc.courseId1.options[result_stff_loc.courseId1.selectedIndex].text.substr(6);
        prns_form.courseId_1.value = _("courseId1").value
        
        while (_("ul_courses").hasChildNodes())
        {  
            _("ul_courses").removeChild(_("ul_courses").firstChild);
        }
        
        var serialNo = 0;
        for (var counter = 0; counter <= returnedStr.length-1; counter+=180)
        {
            serialNo++;
            //sno
            var li = document.createElement('li');
            li.style.height = '25px';
            li.style.marginTop = '0px';
            li.style.border = '0px';

            if (serialNo%2 == 0)
            {
                li.style.backgroundColor = '#ffffff';
            }else
            {
                li.style.backgroundColor = '#cccccc';
            }

            //serial no
            var div1 = document.createElement('div');
            div1.setAttribute('class','ctabletd_1');
            div1.style.width = '50px';
            div1.style.paddingRight = '3px';
            div1.style.textAlign = 'right';
            div1.innerHTML = serialNo;
            li.appendChild(div1);

            //matric no
            var div1 = document.createElement('div');
            div1.setAttribute('class','ctabletd_1');
            div1.style.width = '170px';
            div1.style.textIndent = '2px';
            div1.style.textAlign = 'left';
            div1.innerHTML =  returnedStr.substr(counter,50).trim();
            li.appendChild(div1);
            
            //name
            var div1 = document.createElement('div');
            div1.setAttribute('class','ctabletd_1');
            div1.style.width = '310px';
            div1.style.textIndent = '2px';
            div1.style.textAlign = 'left';
            div1.innerHTML =  returnedStr.substr(counter+50,100).trim();
            li.appendChild(div1);

            //CA
            var div1 = document.createElement('div');
            div1.setAttribute('class','ctabletd_1');
            div1.style.width = '50px';
            div1.style.textAlign = 'right';
            div1.style.paddingRight = '2px';
            div1.innerHTML =  returnedStr.substr(counter+150,10).trim();
            li.appendChild(div1);

            //Exam
            var div1 = document.createElement('div');
            div1.setAttribute('class','ctabletd_1');
            if (serialNo%2 == 0)
            {
                div1.style.backgroundColor = '#ffffff';
            }else
            {
                div1.style.backgroundColor = '#cccccc';
            }
            div1.style.width = '50px';
            div1.style.textAlign = 'right';
            div1.style.paddingRight = '2px';
            div1.innerHTML =  returnedStr.substr(counter+160,10).trim();
            li.appendChild(div1);					

            //score
            var div1 = document.createElement('div');
            div1.setAttribute('class','ctabletd_1');
            if (serialNo%2 == 0)
            {
                div1.style.backgroundColor = '#ffffff';
            }else
            {
                div1.style.backgroundColor = '#cccccc';
            }
            div1.style.width = '51px';
            div1.style.textAlign = 'right';
            div1.style.paddingRight = '3px';
            div1.innerHTML =  returnedStr.substr(counter+170,10).trim();
            li.appendChild(div1);

            _("ul_courses").appendChild(li);
        }

        //_("succ_boxt").style.display= 'none';
        _('container_cover_in2').style.display= 'block';
        _('container_cover_in2').style.zIndex = 1;
        result_stff_loc.save.value = 0;*/
    }else if (_('whattodo').value == '17') // show grade distribution
    {
        // result_stff_loc.grade_dist.value = returnedStr;				
        // _('result_stff_loc').submit();
        // return;
    }else
    {
        // var num_rec_treated = parseInt(returnedStr.substr(0, 10).trim());
        // var total_num_rec = parseInt(returnedStr.substr(10, 10).trim());

        // _('succ_boxt').className = "succ_box blink_text green_msg";
        // if (returnedStr.indexOf("successfully") == -1 && (num_rec_treated == 0 || returnedStr.indexOf("already") != -1  || returnedStr.indexOf("yet") != -1|| returnedStr.indexOf("not") != -1 || returnedStr.indexOf("Insufficient") != -1 || returnedStr.indexOf("Invalid") != -1 || returnedStr.indexOf("Time out") != -1 || returnedStr.indexOf("out of") != -1 || (returnedStr.indexOf("Process aborted") != -1 && num_rec_treated != total_num_rec)))
        // {
        // 	_('succ_boxt').className = "succ_box blink_text orange_msg";
        // }else
        // {
        // 	_('succ_boxt').className = "succ_box blink_text green_msg";
        // }

        _('succ_boxt').className = "succ_box blink_text orange_msg";

        if (returnedStr.indexOf("successfully") != -1)
        {
            _('succ_boxt').className = "succ_box blink_text green_msg";
        }

        //_("succ_boxt").innerHTML = returnedStr.substr(0, returnedStr.indexOf("+")-1);
        if (returnedStr.indexOf("+") >= 0)
        {
            _("succ_boxt").innerHTML = returnedStr.substr(0, returnedStr.indexOf("+")-1);
            _("message_text").innerHTML = returnedStr.substr(returnedStr.indexOf("+")+1);
        }else
        {
            _("succ_boxt").innerHTML = returnedStr;
        }            
    }
    
    result_stff_loc.save.value = 0;
    _('result_stff_loc').conf.value = 0;
}

function progressHandler(event)
{
    in_progress('1');
}

function errorHandler(event)
{
    on_error('1');
}

function abortHandler(event)
{
    on_abort('1');
}

function updateCombo(maxVal, objName)
{
    if (objName == 'obtained' && _('obtained_div').style.display == 'none')
    {
        return;
    }
    
    _(objName).length = 0;
    _(objName).options[0] = new Option('','');

    for (var i = 1; i <= maxVal; i++)
    {
        _(objName).options[i] = new Option(i, i);
    }
}

function show_list()
{
    /*_('container_cover').style.zIndex = 2;
    _('container_cover').style.display = 'block';*/
    _('container_cover_in').style.zIndex = 3;
    _('container_cover_in').style.display = 'block';
    
    _('container_cover').style.display='block';
    _('container_cover_in').style.display='block';
}


function tab_modify_loc(tab_no)
{
    for (i = 0; i <= 5; i++) 
    {
        var tab_Id = 'tabss' + i;
        var tab_Id_0 = 'tabss' + i + '_0';
        if (tab_no == i)
        {
            _(tab_Id).style.background = '#2b8007';
            _(tab_Id).style.color = '#FFFFFF';
        }else
        {
            if (_(tab_Id_0))
            {
                _(tab_Id_0).style.display = 'none';
                _(tab_Id).style.display = 'block';
            }
            
            _(tab_Id).style.background = '#FFFFFF';
            _(tab_Id).style.color = '#2b8007';
        }
    }
}