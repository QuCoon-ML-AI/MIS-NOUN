function other_otherqual()
{
    if (_('other_sbtd_pix').files.length > 0)
    {                
        var allowedExtensions = /(\.PDF)$/i;
        var filePath = _("other_sbtd_pix").value;
        var files = _("other_sbtd_pix").files;

        if(!allowedExtensions.exec(filePath))
        {
            caution_inform("PDF file format required");
            return false;
        }
        
        if (files[0].size > 100000)
        {                            
            size = files[0].size/1000;
            caution_inform("File too large. Max. size is 100KB Attempted size is "+size+"KB");
            return false;
        }
    }
    in_progress('1');
    return true;
}


function chk_inputs()
{                
    with(ps)
    {
        if (cQualCodeId.value == '' ||
        vExamNo.value == '' ||
        vExamSchoolName.value == '' ||
        cExamMthYear.value == '')
        {
            return false;
        }
        
        var address = /^[A-Za-z0-9 _]+$/;
        var letters = /^[A-Za-z ]+$/;
            
        if (!vExamNo.value.match(address))
        {
            caution_inform("Only alphabets and number are allowed for 'Candidate number or Matric number'")
            return false;
        }

        if (!vExamSchoolName.value.match(address))
        {
            caution_inform("Only alphabets and numbers are allowed for 'Name of institution'")
            return false;
        }

        var oneDate = new Date();
        var theYear = oneDate.getFullYear();
        var theMOnth = oneDate.getMonth() + 1; 
        if (theYear == year.value && month.value > theMOnth)
        {
            caution_inform("Future month not allowed in the date of qualification")
            return false;
        }
        

        var files = _("sbtd_pix").files;
    
        if (sbtd_pix.files.length > 0)
        {  
            max_size = _("max_size_of_cred").value * 1000
            
            if (!fileValidation("sbtd_pix"))
            {
                caution_inform("JPEG file format required");
                return false;
            }
            
            if (files[0].size > max_size)
            {
                size = files[0].size/1000;
                caution_inform("File too large. Max. size is 100KB Attempted size is "+size+"KB");
                return false;
            }
        }else if (credentialLoaded.value != 1)
        {
            caution_inform("Upload scanned copy of credentials");
            return false;
        }


        if (cQualCodeId.value == '402' && cExamMthYear.value != '')
        {
            var date1 = new Date(date_of_today.value);
            var date2 =  new Date(cExamMthYear.value.substr(2,4)+"-"+cExamMthYear.value.substr(0,2)+"-01");
            
            var monthDiff = date1.getMonth() - date2.getMonth();
            var yearDiff = date1.getYear() - date2.getYear();
            if ((monthDiff + (yearDiff * 12)) > (12*7))
            {
                caution_inform("Certificate should not be more than 7years old");
                return false;
            }
        }

        var eror = 0;
        var part_fill = 0;
        var atleast_a_row_filled = 0;

        var formdata = new FormData();

        for (i = 1; i <= iQSLCount.value; i++)
        {
            if (iQSLCount.value == 9)
            {
                var elemgName = "grade1" + i;
                var elemsName = "subject1" + i;
            }else if (iQSLCount.value == 4)
            {
                var elemgName = "grade2" + i;
                var elemsName = "subject2" + i;
            }else if (iQSLCount.value == 1)
            {
                var elemgName = "grade3" + i;
                var elemsName = "subject3" + i;
            }

            if (_(elemsName).value == '' && _(elemgName).value != '')
            {
                part_fill = 1;
                eror = 1;
                _(elemsName).setCustomValidity("Subject required");
                return false;
            }else
            {
                _(elemsName).setCustomValidity("");
            }
            
            if (_(elemsName).value != '' && _(elemgName).value == '')
            {
                part_fill = 1;
                eror = 1;
                _(elemgName).setCustomValidity("Grade required");
                return false;
            }else
            {
                _(elemgName).setCustomValidity("");
            }
            
            if (_(elemgName).value == '' && _(elemsName).value == '' && atleast_a_row_filled == 0)
            {
                part_fill = 1;
                eror = 1;
                _(elemsName).setCustomValidity("Blank row not allowed");
                return false;
            }else
            {
                _(elemsName).setCustomValidity("");
            }
            
            for (j = 1; j <= iQSLCount.value; j++)
            {
                if (iQSLCount.value == 9)
                {
                    var elemsName_j = "subject1" + j;
                    var messag_j = "labell_msg1" + j;
                }else if (iQSLCount.value == 4)
                {
                    var elemsName_j = "subject2" + j;
                    var messag_j = "labell_msg2" + j;
                }else if (iQSLCount.value == 1)
                {
                    var elemsName_j = "subject3" + j;
                    var messag_j = "labell_msg3" + j;
                }
                
                for (k = (j+1); k <= iQSLCount.value; k++)
                {
                    if (iQSLCount.value == 9)
                    {
                        var elemsName_k = "subject1" + k;
                        var messag_k = "labell_msg1" + k;
                    }else if (iQSLCount.value == 4)
                    {
                        var elemsName_k = "subject2" + k;
                        var messag_k = "labell_msg2" + k;
                    }else if (iQSLCount.value == 1)
                    {
                        var elemsName_k = "subject3" + k;
                        var messag_k = "labell_msg3" + k;
                    }

                    if (j != k && _(elemsName_j).value != '' && _(elemsName_k).value != '' && _(elemsName_j).value == _(elemsName_k).value)
                    {
                        eror = 1;
                        _(elemsName_j).setCustomValidity("Subject repeatetion not allowed");
                        return false;
                    }else
                    {
                        _(elemsName_j).setCustomValidity("");
                    }
                }
            }
            
            if (eror == 0 && !_(elemsName).readonly && _(elemsName).value != '')
            {
                atleast_a_row_filled = 1;
                formdata.append(elemsName, _(elemsName).value);
                formdata.append(elemgName, _(elemgName).value);
            }						
        }

        if (eror == 0)
        {
            formdata.append("vApplicationNo",vApplicationNo.value);
            formdata.append("ilin",ilin.value);

            formdata.append("cQualCodeId",cQualCodeId.value);
            formdata.append("hdcQualCodeId",hdcQualCodeId.value);
            formdata.append("vExamNo",vExamNo.value.trim());
            formdata.append("hdvExamNo",hdvExamNo.value);
            formdata.append("vExamSchoolName",vExamSchoolName.value);
            formdata.append("iQSLCount",iQSLCount.value);
            formdata.append("cEduCtgId",cEduCtgId.value);
            formdata.append("cEduCtgId_qual",cEduCtgId_qual.value);
            
            formdata.append("cExamMthYear", cExamMthYear.value);
            
            if (files.length > 0)
            {
                formdata.append("sbtd_pix", _("sbtd_pix").files[0]);
                //formdata.append("file_type", files[0].type);
            }
                
            formdata.append("ope_mode",ope_mode.value);

            opr_prep(ajax = new XMLHttpRequest(),formdata);
        }
    }
}
    
function opr_prep(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    
    ajax.open("POST", "opr_s5.php");
    ajax.send(formdata);
}
    
function completeHandler(event)
{
    on_error('0');
    on_abort('0');
    in_progress('0');
    var returnedStr = event.target.responseText;
    returnedStr = returnedStr.trim();

    if (returnedStr.indexOf("Success") != -1)
    {
        _('cancel_add_div').style.display='none';
        _('add_qual_div').style.display='block';

        _('next_btn').style.display='block';
        _('sub_btn').style.display='none';

        if (_("cQualCodeId").value.indexOf("20") > -1)
        {
            _("entered_Ol_qualifications").value = _("entered_Ol_qualifications").value + 1;
        }
        
        inform(returnedStr);
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