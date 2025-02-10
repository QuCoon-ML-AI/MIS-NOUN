function _(el)
{
    return document.getElementById(el)
}

function chk_inputs()
{
    var boxchk = 0;
    
    var formdata = new FormData();
    
    if (_("resend_req").value == '1')
    {
        formdata.append("resend_req", '1');
        formdata.append("conf", '1');
    }else if (course_form.drp_exam.value == 1)
    {
        for (var cnt = 1; cnt <= _('loc_numOfiputTag').value; cnt++)
        {
            if (_('regCourses'+cnt) && !_("regCourses"+cnt).disabled)
            {
                if (_('regCourses'+cnt).type == 'checkbox')
                {
                    if (_('regCourses'+cnt).checked){boxchk++; break;}
                }
            }
        }
        
        if (boxchk == 0)
        {
            caution_inform("Please select one or more courses to drop for exam");
            return false;
        }				
    
        if (_('conf').value != '1')
        {
            _("smke_screen").style.zIndex = '3';
            _("smke_screen").style.display = 'block';
            _("confirm_box_loc").style.zIndex = '4';
            _("confirm_box_loc").style.display = 'block';
            return false;
        }
        
        with (course_form)
        {
            formdata.append("numOfiputTag", loc_numOfiputTag.value);
            
            formdata.append("AcademicDesc", AcademicDesc.value);
            formdata.append("iStudy_level", iStudy_level.value);
            formdata.append("tSemester", tSemester.value);
            formdata.append("conf", '1');
            
            if (_('conf').value == '1' && _('token_supplied').value == '1')
            {
                for (j = 1; j <= _("loc_numOfiputTag").value; j++)
                {	
                    if (_("regCourses"+j))
                    {
                        if (_("regCourses"+j).checked && !_("regCourses"+j).disabled)
                        {
                            formdata.append("regCourses"+j, _("regCourses"+j).value);
                            formdata.append("vCourseDesc"+j, _("vCourseDesc"+j).value);
                            formdata.append("credUniInput"+j, _("credUniInput"+j).value);
                            formdata.append("amount"+j, _("amntInput"+j).value);
                            formdata.append("itemid"+j, _("itemid"+j).value);
                            
                            formdata.append("exam_amount"+j, _("exam_amntInput"+j).value);
                            formdata.append("exam_itemid"+j, _("exam_itemid"+j).value);
                        }
                    }
                }
                formdata.append("conf", '1');
                formdata.append("token_supplied", '1');
                formdata.append("user_token", _('user_token').value)
            }
        }
    }                
    
    with (course_form)
    {
        formdata.append("ilin", ilin.value);
        formdata.append("vMatricNo", vMatricNo.value);
        formdata.append("user_cat", user_cat.value);
        formdata.append("drp_exam", drp_exam.value);
        formdata.append("edu_cat", edu_cat.value);
    }
    
    opr_prep(ajax = new XMLHttpRequest(),formdata);
}

function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    
    ajax.open("POST", "back_end_exam_reg_slp");
    
    ajax.send(formdata);
}


function completeHandler(event)
{
    on_error('0');
    on_abort('0');
    in_progress('0');

    var returnedStr = event.target.responseText;
    if (returnedStr == 'Token sent')
    {
        _("smke_screen").style.zIndex = '3';
        _("smke_screen").style.display = 'block';
        _("token_dialog_box").style.zIndex = '4';
        _("token_dialog_box").style.display = 'block';

        _("resend_req").value = '';
    }else if (returnedStr.indexOf("success") != -1)
    {
        inform(returnedStr);

        for (var cnt = 1; cnt <= _('loc_numOfiputTag').value; cnt++)
        {
            if (_('regCourses'+cnt))
            {
                if (_('regCourses'+cnt).type == 'checkbox' && _('regCourses'+cnt).checked)
                {
                    _('regCourses'+cnt).disabled = true;
                }
            }
        }

        _("smke_screen").style.zIndex = '-1';
        _("smke_screen").style.display = 'none';
        _("confirm_box_loc").style.zIndex = '-1';
        _("confirm_box_loc").style.display = 'none';
    }else
    {
        caution_inform(returnedStr)
    }
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