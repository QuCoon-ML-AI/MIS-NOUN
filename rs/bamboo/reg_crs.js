function _(el)
{
    return document.getElementById(el)
}

// function chk_inputs()
// {
//     var totCredUnit = 0;
//     var boxchk = 0; 
//     var boxavail = 0;
    
//     var formdata = new FormData();
    
//     if (_("resend_req").value == '1')
//     {
//         with (course_form)
//         {
//             formdata.append("resend_req", '1');
//             formdata.append("conf", '1');
//         }
//     }else 
//     {
//         totCredUnit = parseInt(_('grand_total_credit_unit').value);

//         total_unit_carried =  parseInt(totCredUnit) + parseInt(_('carried_crload').value);

//         if (total_unit_carried > _("max_crload").value)
//         {
//             caution_inform(total_unit_carried +' credit units already registered for the semester<br> Addition of '+totCredUnit+' units exceeds '+_("max_crload").value+' maximum credit unit load for the smester.');
//             return false;
//         }
        
//         for (var cnt = 1; cnt <= _('loc_numOfiputTag_0').value; cnt++)
//         {
//             if (_('regCourses'+cnt) && !_("regCourses"+cnt).disabled)
//             {
//                 if (_('regCourses'+cnt).type == 'checkbox')
//                 {
//                     boxavail++;
//                     if (_('regCourses'+cnt).checked){boxchk++;}
//                 }
//             }
//         }
        
//         if (boxavail == 0)
//         {
//             caution_inform('You have registered all available courses for this semester');
//             return false;
//         }
    
//         if (boxchk == 0)
//         {
//             caution_inform('Select one or more courses to register');
//             return false;
//         }			
    
//         if (course_form.cEduCtgId.value != 'ELX' && (parseInt(_('grand_total_amount').value) > parseInt(_('student_balance').value) || _('student_balance').value <= 0))
//         {
//             caution_inform("<b>Insufficient fund</b><br>To fund your eWallet:<p>1. Click the Ok button<br>2. Click 'Bursary' above<br>3. Click 'Make payment' (left)<br>4. Follow the prompt on the screen");
//             return false; 
//         }
    
//         if (_('conf').value != '1')
//         {
//             _("smke_screen").style.zIndex = '3';
//             _("smke_screen").style.display = 'block';
//             _("confirm_box_loc").style.zIndex = '4';
//             _("confirm_box_loc").style.display = 'block';
//             return false;
//         }
    
//         var formdata = new FormData();
        
//         if (_('conf').value == '1' && _('token_supplied').value == '1')
//         {
//             with(course_form)
//             {
//                 formdata.append("AcademicDesc", AcademicDesc.value);
                
//                 formdata.append("tSemester", tSemester.value);
//                 formdata.append("semester_spent_loc", semester_spent_loc.value);alert(semester_spent_loc.value)
//                 formdata.append("numofreg", loc_numOfiputTag_0.value);
//                 formdata.append("iStudy_level", iStudy_level.value);
                
//                 for (j = 1; j <= loc_numOfiputTag_0.value; j++)
//                 {								
//                     if (_("regCourses"+j))
//                     {
//                         if (_("regCourses"+j).checked && !_("regCourses"+j).disabled)
//                         {
//                             formdata.append("regCourses"+j, _("regCourses"+j).value);
//                             formdata.append("vCourseDesc"+j, _("vCourseDesc"+j).value);
//                             formdata.append("credUniInput"+j, _("credUniInput"+j).value);
//                             formdata.append("amount"+j, _("amntInput"+j).value);
//                             formdata.append("itemid"+j, _("itemid"+j).value);
//                             formdata.append("cCategoryInput"+j, _("cCategoryInput"+j).value);
//                             formdata.append("ancilary_type"+j, _("ancilary_type"+j).value);
//                         }
//                     }
//                 }
//             }
            
//             if (course_form.cProgrammeId.value.indexOf("DEG") >= 0 || course_form.cProgrammeId.value.indexOf("CHD") >= 0)
//             {
//                 formdata.append("cProgrammeId", course_form.cProgrammeId.value);
//                 if (course_form.cProgrammeId.value.indexOf("DEG") >= 0)
//                 {
//                     formdata.append("deg_appl_cat", course_form.deg_appl_cat.value);
//                 }
//             }
            
//             formdata.append("token_supplied", '1');
//             formdata.append("user_token", _('user_token').value)
//         }
//     }                
    
//     with (course_form)
//     {
//         formdata.append("ilin", ilin.value);
//         formdata.append("vMatricNo", vMatricNo.value);
//         formdata.append("user_cat", user_cat.value);

//         formdata.append("max_crload", max_crload.value);
//         formdata.append("total_unit_carried", total_unit_carried);
        
//         formdata.append("carried_crload", carried_crload.value);
//         formdata.append("totCredUnit", totCredUnit);
//         formdata.append("cEduCtgId", cEduCtgId.value);
        
//         formdata.append("conf", '1');
//     }
    
//     opr_prep(ajax = new XMLHttpRequest(),formdata);
// }

function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    
    ajax.open("POST", "back_end_register_courses");
    
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
        const myArray = returnedStr.split(",");

        inform(myArray[0]);
        course_form.carried_crload.value = myArray[1];

        for (var cnt = 1; cnt <= _('loc_numOfiputTag_0').value; cnt++)
        {
            if (_('regCourses'+cnt))
            {
                if (_('regCourses'+cnt).type == 'checkbox' && _('regCourses'+cnt).checked)
                {
                    _('regCourses'+cnt).disabled = true;
                }
            }
        }
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