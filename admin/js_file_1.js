// JavaScript Document

//if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
//{
	//window.location.replace("http://localhost/m/");
	//window.location.replace("https://nouonline.nou.edu.ng/m/");
//}

document.addEventListener("contextmenu", (e) => {e.preventDefault()});

document.addEventListener('keydown', function (event) 
{
    if (event.ctrlKey && (event.key === 'u' 
    || event.key === 'U'))
    {
        event.preventDefault();
    }
});

function _(el)
{
	return document.getElementById(el)
}



function capitalizeEachWord(str)
{
	var splitStr = str.toLowerCase().split(' ');
	for (var i = 0; i < splitStr.length; i++)
	{
	   splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
	}
	return splitStr.join(' ');
}

 

function trim(totrim)
{
	var trimed = "";
	for (j = 0; j <= totrim.length-1; j++)
	{
		if (totrim.charAt(j) != " "){trimed = trimed + totrim.charAt(j);}
	}
	return trimed;
}


function setMsgBox(labell_msg, msg)
{
	if (msg == '')
	{
		_(labell_msg).innerHTML = "Required";
	}else
	{
		_(labell_msg).innerHTML = msg;
	}
	
	_(labell_msg).style.display = 'Block';
	
	if (_("cont_box"))
	{
		_("cont_box").style.display = 'none';
	}
	
	if (_("sub_box"))
	{
		_("sub_box").style.display = 'block';		
	}
}


function chk_mail(tempobj)
{
	if(tempobj.value.charAt(0) == ".")
	{
		return "The \'.\' character cannot be the first";
	}else if(tempobj.value.charAt(0) == "@")
	{
		return "The \'@\' character cannot be the first";
	}else if(tempobj.value.indexOf("@") == -1)
	{
		return "The \'@\' character is missing";
	}else if (tempobj.value.indexOf("@") == tempobj.value.length-1)
	{
		return "Can\'t end with the \'@\' character";
	}else if (tempobj.value.indexOf(".") == tempobj.value.length-1)
	{
		return 'Can\'t end with the \'.\' character';
	}
	var emailinval = new String("~`!#$%^&*()+=:;|'{} []|\/?,<>. ")
	for (n = 0; n < emailinval.length-1; n++)
	{
		for (j = 0; j < tempobj.value.length-1; j++)
		{
			if (tempobj.value.charAt(j) == emailinval.charAt(n))
			{
				var invalchar = tempobj.value.charAt(j);
				if  (invalchar != ".")
				{
					return "Remove invalid character: \'"+invalchar+"\'"; 
				}
			}
		}
	}
	
	if (tempobj.value.indexOf(".") == -1)
	{
		return "Should end with  . something";
	}
	
	return '';
}


function rmv_inv_chars(hay_sack,set)
{
	if (set == 1)//name
	{
		var emailinval = new String("~@`!#$%^&*()+=:;|'{}[]|\/?,_<>.0123456789")
	}else if (set == 2)//address
	{
		var emailinval = new String("~`!#$%^&*()+=:;|'{}[]|\/?,_<>")
	}else if (set == 3)//phone
	{
		var emailinval = new String("~@`!#$%^&*()+=:;|'{}[]|\/?,<>- _AbcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ")
	}else if (set == 4)//ID
	{
		var emailinval = new String("~@`!#$%^&*()+=:;|'{}[]|\/?,<>- _.")
	}else if (set == 5)//ID
	{
		var emailinval = new String("~@`!#$%^&*()+=:;|'{}[]|\/?,<> .")
	}

	for (n = 0; n < emailinval.length-1; n++)
	{
		for (j = 0; j <= hay_sack.length-1; j++)
		{
			if (hay_sack.charAt(j) == emailinval.charAt(n))
			{
				var pos = j + parseInt("1");
				if (set == 5)
				{
					return 'Please remove "'+hay_sack.charAt(j)+'", replace with "_"';
				}else
				{
					return 'Please remove "'+hay_sack.charAt(j)+'"';
				}
			}
		}
	}
	return ''
}



function marlic(val)
{
	val = val.toLowerCase();	
	return '';
}


function adjusScreen (disparea, screenHeader, tabno)
{
	_('act_header').innerHTML = screenHeader;
	_(disparea).style.display='block';
	_('sumit').style.display='block';
	
	_('sideMenu').value = tabno;
	_('labell_msg0').style.display='none';
	_('submityes').style.display='none';
	return false;
}



function select_qual()
{
	if ((_("what_to_do").value == '1' && _("on_what").value == '2'))
	{
		if (_("what_to_do").value == '1' && _("on_what").value == '2')
		{
			_("frm_upd").value = 'qual';
			var formdata = new FormData();
			formdata.append("cprogrammeIdold", _("cprogrammeIdold").value);
			formdata.append("frm_upd", _("frm_upd").value);
			opr_prep(ajax = new XMLHttpRequest(),formdata);
		}
		
	}
}




function seterrMsgBox(coverDiv,affected,errVal)
{
	_("succ_boxt").innerHTML = errVal;
	_("succ_boxt").style.display = 'block';
	_("succ_boxu").innerHTML = errVal;
	_("succ_boxu").style.display = 'block';
	
	_(coverDiv).style.border = '1px solid #BDBB6A';
	_(affected).style.background = '#F5F4D6';
	_(affected).focus();
	
}


function adjustScreen(val)
{
	sets.sm.value = val;
		
	_("succ_boxt").style.display = 'none';
	_("succ_boxu").style.display = 'none';
	
	
	if (val == '1')
	{

		_("OrgName").style.display = 'block';
		_("events").style.display = 'none';
		_("settings").style.display = 'none';
		_("opsuns").style.display = 'none';
		_("structure").style.display = 'none';
		
		_("contac").style.display = 'none';
		_("datetime").style.display = 'block';
		_("compmat").style.display = 'block';
		_("acadstruc").style.display = 'block';
		_("optns").style.display = 'block';		
		
		_("contac_dull").style.display = 'block';
		_("datetime_dull").style.display = 'none';
		_("compmat_dull").style.display = 'none'
		_("acadstruc_dull").style.display = 'none';
		_("optns_dull").style.display = 'none';
	}else if (val == '2')
	{
		//_("act_header").innerHTML = 'Dates - Annual month and day of major events, System idle time';
		_("events").style.display = 'block';
		_("OrgName").style.display = 'none';
		_("settings").style.display = 'none';
		_("opsuns").style.display = 'none';
		_("structure").style.display = 'none';
		
		_("contac").style.display = 'block';
		_("datetime").style.display = 'none';
		_("datetime_dull").style.display = 'block';
		_("compmat").style.display = 'block';
		_("acadstruc").style.display = 'block';
		_("optns").style.display = 'block';	
		
		_("contac_dull").style.display = 'none';
		_("datetime_dull").style.display = 'block';
		_("compmat_dull").style.display = 'none'
		_("acadstruc_dull").style.display = 'none';
		_("optns_dull").style.display = 'none';
	}else if (val == '3')
	{
		//_("act_header").innerHTML = 'Compose matriculation number';
		_("settings").style.display = 'block';
		_("OrgName").style.display = 'none';
		_("events").style.display = 'none';
		_("opsuns").style.display = 'none';
		_("structure").style.display = 'none';
		
		_("contac").style.display = 'block';
		_("datetime").style.display = 'block';
		_("compmat").style.display = 'none';
		_("compmat_dull").style.display = 'block';
		_("acadstruc").style.display = 'block';
		_("optns").style.display = 'block';
		
		_("contac_dull").style.display = 'none';
		_("datetime_dull").style.display = 'none';
		_("compmat_dull").style.display = 'block'
		_("acadstruc_dull").style.display = 'none';
		_("optns_dull").style.display = 'none';
	}else if (val == '4')
	{
		//_("act_header").innerHTML = 'Academic Structure - Composition of faculties, departments, programmes and courses';
		_("settings").style.display = 'none';
		_("OrgName").style.display = 'none';
		_("events").style.display = 'none';
		_("opsuns").style.display = 'none';
		_("structure").style.display = 'block';
		
		_("contac").style.display = 'block';
		_("datetime").style.display = 'block';
		_("compmat").style.display = 'block';
		_("acadstruc").style.display = 'none';
		_("acadstruc_dull").style.display = 'block';
		_("optns").style.display = 'block';
		
		_("contac_dull").style.display = 'none';
		_("datetime_dull").style.display = 'none';
		_("compmat_dull").style.display = 'none'
		_("acadstruc_dull").style.display = 'block';
		_("optns_dull").style.display = 'none';
	}else if (val == '5')
	{
		//_("act_header").innerHTML = 'Options - Turn various options on or off';
		_("opsuns").style.display = 'block';
		_("settings").style.display = 'none';
		_("OrgName").style.display = 'none';
		_("events").style.display = 'none';
		_("structure").style.display = 'none';
		
		_("contac").style.display = 'block';
		_("datetime").style.display = 'block';
		_("compmat").style.display = 'block';
		_("acadstruc").style.display = 'block';
		_("optns").style.display = 'none';
		_("optns_dull").style.display = 'block';
		
		_("contac_dull").style.display = 'none';
		_("datetime_dull").style.display = 'none';
		_("compmat_dull").style.display = 'none'
		_("acadstruc_dull").style.display = 'none';
		_("optns_dull").style.display = 'block';
	}
	_("sumit").style.display = 'block';
}


function progressHandler(event)
{
	if (_('save').value == '1' || _("frm_upd").value == '' || (_("frm_upd").value == 'f' && _("what_to_do").value == '0' && (_("on_what").value == '1' || _("on_what").value == '2' || _("on_what").value == '3')))
	{
		_("succ_boxt").style.display = 'Block';
		_("succ_boxt").innerHTML = "Processing request, please...wait";
		
		_box
		_("succ_boxu").innerHTML = "Processing request, please...wait";
	}
}



function errorHandler(event)
{
	_("succ_boxt").innerHTML = "Your internet connection was interrupted. Please try again";
	_("succ_boxu").innerHTML = "Your internet connection was interrupted. Please try again";
}

function abortHandler(event)
{
	_("succ_boxt").innerHTML = "Process aborted";
	_("succ_boxu").innerHTML = "Process aborted";
}

function compose_number(name_val, val)
{
	var str = '';
	if ((_(name_val).value != '' && _(name_val).value != '0') || _(name_val).value == '1')
	{
		if (_("mat_comp_orda").value.indexOf(val) == -1)
		{
			_("mat_comp_orda").value += val;
		}
	}else
	{
		for (i = 0; i < _("mat_comp_orda").value.length-1; i++)
		{
			if (_("mat_comp_orda").value.charAt(i) != val)
			{
				str += _("mat_comp_orda").value.charAt(i);
			}
		}
		_("mat_comp_orda").value = str;
	}
}


function smpl_matno(val,prefix_sufix)
{
	if (_('sampl_compoMat').value.indexOf(val) == -1)
	{
		if (prefix_sufix == '1')
		{
			_('sampl_compoMat').value = _('sampl_compoMat').value+_("matnosepa").value+val;
		}else
		{
			_('sampl_compoMat').value = val+_("matnosepa").value+_('sampl_compoMat').value
		}
	}
}

function clearAll()
{
	var allChildNodes = _("settings").getElementsByTagName('input');
	for (i = 3; i < allChildNodes.length; i++)
	{
		if(allChildNodes[i].type == 'text' || allChildNodes[i].type == 'hidden'){allChildNodes[i].value = '';}
		if(allChildNodes[i].type == 'checkbox' || allChildNodes[i].type == 'radio'){allChildNodes[i].checked = false;}
		if(allChildNodes[i].type == 'checkbox'){allChildNodes[i].value = '0';}
		if(allChildNodes[i].type == 'radio'){allChildNodes[i].disabled = true}
	}
	_("sampl_compoMat").value = 'xxxxx';		
}




function form_code(val)
{
	var str = ''; Index_spacefound = 0; spacefound = 0; courseSelected = trim(val);
	
	if (courseSelected.length > 0)
	{
		for (x = 0; x <= val.length-1; x++)
		{
			if (x == 0){str = val.substr(x,1);}
			else if (val.substr(x-1,1) == ' ')
			{
				Index_spacefound = x;
				spacefound++;
									
				if (!(val.substr(x,1).toUpperCase() == 'A' && val.substr(x+1,1).toLowerCase() == 'n' && val.substr(x+2,1).toLowerCase() == 'd') && 
				!(val.substr(x,1).toUpperCase() == 'O' && val.substr(x+1,1).toLowerCase() == 'f') && 
				!(val.substr(x,1).toUpperCase() == 'I' && val.substr(x+1,1).toLowerCase() == 'n') && 
				!(val.substr(x,1).toUpperCase() == 'T' && val.substr(x+1,1).toLowerCase() == 'o'))
				{
					str = str + val.substr(x,1)
				}
			}
		}
		
		if (spacefound == 1)
		{
			str = str + val.substr(Index_spacefound+1,1);
		}else if (str.length == 1)
		{
			str = str + val.substr(1,1) + val.substr(2,1);
		}else if (str.length == 2)
		{
			if (spacefound == 2)
			{
				str = str + val.substr(Index_spacefound+1,1);
			}
		}
		_("cFacultyIdNew_abrv").value = str;
	}
}


function resetSideMenu()
{
	var ulChildNodes = document.getElementsByTagName("form")
	for (j = 0; j <= ulChildNodes.length-1; j++)
	{
		if (ulChildNodes[j].side_menu_no)
		{
			ulChildNodes[j].side_menu_no.value = 0;
		}
	}
}



function update_cat_country(callerctrl, parentctrl, childctrl1, childctrl2)
{
	cProgdesc = '';
	cProgId = '';
	
	if (callerctrl.indexOf("Country") > -1)	
	{
		_(childctrl1).length = 0;
		_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');

		_(childctrl2).length = 0;
		_(childctrl2).options[_(childctrl2).options.length] = new Option('', '');
		
	 	for (var i = 0; i <= _(parentctrl).length-1; i++)
		{
			if (_(parentctrl).options[i].value.substr(2,2) == _(callerctrl).value)
			{
				cProgdesc = _(parentctrl).options[i].text;
				cProgId = _(parentctrl).options[i].value.substr(0,2);

				_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
			}
		}
		
		if (cProgId == '')
		{
			_(childctrl1).length = 0;
			_(childctrl1).options[_(childctrl1).options.length] = new Option('Non Nigerian', '99');
			
			_(childctrl2).length = 0;
			_(childctrl2).options[_(childctrl2).options.length] = new Option('Non Nigerian', '99999');
		}
	}else if (callerctrl.indexOf("State") > -1 || callerctrl == 'crit9' || callerctrl == 'crit11')	
	{
		_(childctrl1).length = 0;
		_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
		
	 	for (var i = 0; i <= _(parentctrl).length-1; i++)
		{
			if (_(parentctrl).options[i].value.substr(0,2) == _(callerctrl).value)
			{
				cProgdesc = _(parentctrl).options[i].text;
				cProgId = _(parentctrl).options[i].value.substr(2,5);

				_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
			}
		}
	}else if (callerctrl.indexOf("Faculty") > -1 || callerctrl.indexOf("faculty") > -1 || callerctrl == 'crit2')	
	{
		_(childctrl1).length = 0;
		_(childctrl1).options[_(childctrl1).options.length] = new Option('Select a department', '');

		_(childctrl2).length = 0;
		_(childctrl2).options[_(childctrl2).options.length] = new Option('', '');

		if (_(callerctrl).value == 'NA')
		{
			_(childctrl1).options[_(childctrl1).options.length] = new Option('Not applicable', 'NA');
			return;
		}
		
		if (_("courseId1"))
		{
			_("courseId1").length = 0;
			_("courseId1").options[_("courseId1").options.length] = new Option('', '');
		}		
		
		if (_("ccourseIdold") && _('frm_upd').value != 'n_f' && _('frm_upd').value != 'n_d')
		{
			_("ccourseIdold").length = 0;
			_("ccourseIdold").options[_("ccourseIdold").options.length] = new Option('', '');
		}
		
	 	for (var i = 0; i <= _(parentctrl).length-1; i++)
		{
			if (_(parentctrl).options[i].value.substr(0,3) == _(callerctrl).value)
			{
				cProgdesc = _(parentctrl).options[i].text;
				cProgId = _(parentctrl).options[i].value.substr(3,3);

				_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
			}
		}
	}else if (callerctrl.indexOf("dept") > -1 || callerctrl.indexOf("department") > -1 || callerctrl == 'crit3')	
	{
		_(childctrl1).length = 0;
		_(childctrl1).options[_(childctrl1).options.length] = new Option('Select a programme', '');		
		
		if (_(callerctrl).value == 'NA')
		{
			_(childctrl1).options[_(childctrl1).options.length] = new Option('Not applicable', 'NA');
			return;
		}

		var notice_written = 0;

		for (var i = 0; i <= _(parentctrl).length-1; i++)
		{
			if (_(parentctrl).options[i].value.substr(0,3) == _(callerctrl).value)
			{				
				cProgdesc = _(parentctrl).options[i].text;
				cProgId = _(parentctrl).options[i].value.substr(3,6);
				
				if (cProgdesc.indexOf("Ph.D.") != -1 || cProgdesc.indexOf("M. Phil.") != -1)
				{
					if (notice_written == 0 && !_("mm"))
					{
						_(childctrl1).options[_(childctrl1).options.length+1] = new Option("M. Phil. and Ph.D. candidates are screened addionally via interview", '');
						notice_written = 1;
						if (_("labell_msg2"))
						{
							caution_box("M. Phil. and Ph.D. candidates are screened addionally via interview");
						}
					}else
					{
						_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
					}
				}else
				{
					_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
				}
			}
		}
	}else if (callerctrl.indexOf("programme") > -1 || callerctrl == 'crit4')	
	{
		_(childctrl1).length = 0;
		_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');		
		
		var prev_semester = '';
		
		for (var i = 0; i <= _(parentctrl).length-1; i++)
		{
			if (childctrl1 == childctrl2 && (childctrl1.indexOf("crit5") > -1 || (childctrl1.indexOf("courseIdold") > -1 && _("what_to_do").value == '1' && _("on_what").value == '3')))
			{
				if ((_('crit3') && _('crit3').value == _(parentctrl).options[i].value.substr(18,3)) || (_('cdeptold') && _('cdeptold').value == _(parentctrl).options[i].value.substr(18,3)))
				{
					if (prev_semester != '' && prev_semester != _(parentctrl).options[i].text.substr(0,1))
					{
						_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
						_(childctrl1).options[_(childctrl1).options.length-1].disabled = true;
					}
					
					cProgdesc = _(parentctrl).options[i].text.trim();
					cProgId = _(parentctrl).options[i].value.substr(11,6);

					var alreadyEntered = 0;
					for (j = 0; j < _(childctrl1).length; j++)
					{
						if (_(childctrl1).options[j].value == cProgId)
						{
							alreadyEntered = 1;
							break;
						}
					}

					if (alreadyEntered == 0)
					{
						_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
					}

					
					prev_semester = _(parentctrl).options[i].text.substr(0,1);
				}
			}else if (_(parentctrl).options[i].value.substr(4,6).trim() == _(callerctrl).value.trim())
			{
				if (prev_semester != '' && prev_semester != _(parentctrl).options[i].text.substr(0,1))
				{
					_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
					_(childctrl1).options[_(childctrl1).options.length-1].disabled = true;
				}
				
				cProgdesc = _(parentctrl).options[i].text.trim();
				cProgId = _(parentctrl).options[i].value.substr(11,6);

				_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
				
				prev_semester = _(parentctrl).options[i].text.substr(0,1);
			}
		}

		for (i = 0; i < _(childctrl1).length; i++)
		{
			//alert(_(childctrl1).options[i].value)
		}
	}else if (callerctrl == 'cEduCtgId_loc')
	{
		_(childctrl1).length = 0;
		_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
		
		for (var i = 0; i <= _(parentctrl).length-1; i++)
		{
			if (_(parentctrl).options[i].value.substr(2,3) == _(callerctrl).value)
			{
				cProgdesc = _(parentctrl).options[i].text;
				cProgId = _(parentctrl).options[i].value;

				_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
				_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
			}
		}
	}else if (callerctrl == 'cEduCtgId1')
	{
		_(childctrl1).length = 0;
		_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
		
		for (var i = 0; i <= _(parentctrl).length-1; i++)
		{
			if (_(parentctrl).options[i].value.substr(3,3) == _(callerctrl).value)
			{
				cProgdesc = _(parentctrl).options[i].text;
				cProgId = _(parentctrl).options[i].value.substr(0,3);

				_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
			}
		}
		
		if (_("cQualCodeIdTmp").value != ''){e_qual.cQualCodeId1.value = _("cQualCodeIdTmp").value;}
	}
}


function properdate(dt1,dt2)
{
	var dd1 = '';
	var mm1 = '';
	var yy1 = '';
	
	var date = '';
	var dd2 = '';
	var mm2 = '';
	var yy2 = '';
	
	if (dt1.length == 8)
	{
		dd1 = dt1.substr(0,2);
		mm1 = dt1.substr(2,3);
		yy1 = dt1.substr(4,4);
	}else if (dt1.length == 10)
	{
		dd1 = dt1.substr(0,2);
		mm1 = dt1.substr(3,2);
		yy1 = dt1.substr(6,4);
	}
	
	if (trim(dt2) == '')
	{
		date = new Date();
		dd2 = pad(date.getDate(), 2, 0);
		mm2 =  pad(date.getMonth() + 1, 2, 0);
		yy2 = date.getFullYear();
	}else
	{
		if (dt2.length == 8)
		{
			dd2 = dt2.substr(0,2);
			mm2 = dt2.substr(2,3);
			yy2 = dt2.substr(4,4);
		}else if (dt2.length == 10)
		{
			dd2 = dt2.substr(0,2);
			mm2 = dt2.substr(3,4);
			yy2 = dt2.substr(6,4);
		}
	}
	
	return (yy2 > yy1) || ((yy2 == yy1) && (mm2 > mm1)) || ((yy2 == yy1) && (mm2 == mm1) && (dd2 > dd1));
}


function pad(n, width, z) 
{
  z = z || '0';
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}


function set_figures(courseSelected,amount,creditUnit,pend_current)
{
	if (courseSelected)
	{
		if (_('total_amnt_'+pend_current))
		{
			if (parseInt(_('student_balance').value) < 0)
			{
				_("smke_screen_2").style.zIndex = '2';
				_("smke_screen_2").style.display = 'Block';
				
				_('msg_msg_info').innerHTML = "<b>Insufficient fund</b><br>To fund your eWallet:<br>1. Click the Ok button here<br>2. Click 'My home' (top right)<br>3. Close the central notice boxes<br>4. Click 'Make payment' (bottom right)";
				_('info_box').style.zIndex = '3';
				_('info_box').style.display = 'block';
				return false;
			}
			
			_('total_amnt_div_'+pend_current).innerHTML = parseInt(_('total_amnt_'+pend_current).value) + parseInt(amount);
			_('total_amnt_'+pend_current).value = parseInt(_('total_amnt_'+pend_current).value) + parseInt(amount);
		}
		
		if (_('total_credunit_div_'+pend_current))
		{
			_('total_credunit_div_'+pend_current).innerHTML = parseInt(_('total_credunit_div_'+pend_current).innerHTML) + parseInt(creditUnit);
			_('total_credit_unit_'+pend_current).value = parseInt(_('total_credit_unit_'+pend_current).value) + parseInt(creditUnit);
		}
		
		_('grand_total_creditunit_div').innerHTML = parseInt(_('grand_total_creditunit_div').innerHTML) + parseInt(creditUnit);
		_('grand_total_credit_unit').value = parseInt(_('grand_total_credit_unit').value) + parseInt(creditUnit);
		_('grand_total_amount_div').innerHTML = parseInt(_('grand_total_amount_div').innerHTML) + parseInt(amount);
		_('grand_total_amount').value = parseInt(_('grand_total_amount').value) + parseInt(amount);
	}else
	{
		if (parseInt(_('grand_total_amount').value) + amount > parseInt(_('student_balance').value))
		{
			return false;
		}
		
		if (_('total_amnt_'+pend_current))
		{
			_('total_amnt_div_'+pend_current).innerHTML = parseInt(_('total_amnt_'+pend_current).value) - parseInt(amount);
			if (_('total_amnt_div_'+pend_current).innerHTML < 0)
			{
				_('total_amnt_div_'+pend_current).innerHTML = 0;
			}
			_('total_amnt_'+pend_current).value = parseInt(_('total_amnt_'+pend_current).value) - parseInt(amount);
			if (_('total_amnt_'+pend_current).value < 0)
			{
				_('total_amnt_'+pend_current).value = 0;
			}
		}
		
		if (_('total_credunit_div_'+pend_current))
		{
			_('total_credunit_div_'+pend_current).innerHTML = parseInt(_('total_credunit_div_'+pend_current).innerHTML) - parseInt(creditUnit);
			if (_('total_credunit_div_'+pend_current).innerHTML < 0)
			{
				_('total_credunit_div_'+pend_current).innerHTML = 0;
			}
			_('total_credit_unit_'+pend_current).value = parseInt(_('total_credit_unit_'+pend_current).value) - parseInt(creditUnit);
			if (_('total_credit_unit_'+pend_current).value < 0)
			{
				_('total_credit_unit_'+pend_current).value = 0;
			}
		}
		
		_('grand_total_creditunit_div').innerHTML = parseInt(_('grand_total_creditunit_div').innerHTML) - parseInt(creditUnit);
		if (_('grand_total_creditunit_div').innerHTML < 0)
		{
			_('grand_total_creditunit_div').innerHTML = 0;
		}
		_('grand_total_credit_unit').value = parseInt(_('grand_total_credit_unit').value) - parseInt(creditUnit);
		if (_('grand_total_credit_unit').value < 0)
		{
			_('grand_total_credit_unit').value = 0;
		}
		_('grand_total_amount_div').innerHTML = parseInt(_('grand_total_amount_div').innerHTML) - parseInt(amount);
		if (_('grand_total_amount_div').innerHTML < 0)
		{
			_('grand_total_amount_div').innerHTML = 0;
		}
		_('grand_total_amount').value = parseInt(_('grand_total_amount').value) - parseInt(amount);
		if (_('grand_total_amount').value < 0)
		{
			_('grand_total_amount').value = 0;
		}
	}

	val_total_amnt = _('total_amnt_'+pend_current).value;
	val_total_amnt = parseInt(val_total_amnt);
	_('total_amnt_div_'+pend_current).innerHTML = addCommas(val_total_amnt);
	
	val_total_amnt = _('grand_total_amount').value;
	val_total_amnt = parseInt(val_total_amnt);
	_('grand_total_amount_div').innerHTML = addCommas(val_total_amnt);
}


function chk_setFigure()
{
	var grand_totalUnit = 0; 
	var grand_totalAmnt = 0.00; 
	
	var totalUnit_pend = 0; 
	var totalAmnt_pend = 0.00; 
	
	var totalUnit_toreg = 0; 
	var totalAmnt_toreg = 0.00;
	
	var check_totalUnit = 0;

	var student_balance = _('student_balance').value;
	alert()
	for (var cnt = 1; cnt <= _('loc_numOfiputTag_0').value; cnt++)
	{
		if (_('regCourses'+cnt))
		{
			if (_('select_all1').innerHTML=='Select all')
			{
				if (cnt == 1)
				{
					_('arch_grand_totalAmnt').value = _('grand_total_amount').value;

					for (var cnt_1 = 1; cnt_1 <= _('loc_numOfiputTag_0').value; cnt_1++)
					{
						check_totalUnit += parseInt(_('credUniInput'+cnt_1).value);
					}

					if (check_totalUnit > _("max_crload").value)
					{
						_("smke_screen_2").style.zIndex = '2';
						_("smke_screen_2").style.display = 'Block';
						
						_("msg_msg_info").innerHTML = 'Maximum credit unit load of '+_("max_crload").value+' exceeded';
						_("info_box").style.zIndex = '3';
						_("info_box").style.display = 'block';
						return;
					}
				}

				if (!_('regCourses'+cnt).disabled)
				{
					_('regCourses'+cnt).checked=true;
				}
				
				if (_('total_number_of_course_pend'))
				{
					if (cnt <= _('total_number_of_course_pend').value && _('enforce_co').value == '0')
					{
						totalAmnt_pend += parseInt(_('amntInput'+cnt).value);
						totalUnit_pend += parseInt(_('credUniInput'+cnt).value);

						student_balance -= parseInt(_('amntInput'+cnt).value);
					}else if (cnt > _('total_number_of_course_pend').value)
					{
						totalAmnt_toreg += parseInt(_('amntInput'+cnt).value);
						totalUnit_toreg += parseInt(_('credUniInput'+cnt).value);

						student_balance -= parseInt(_('amntInput'+cnt).value);
					}
				}else
				{
					totalAmnt_toreg += parseInt(_('amntInput'+cnt).value);
					totalUnit_toreg += parseInt(_('credUniInput'+cnt).value);

					student_balance -= parseInt(_('amntInput'+cnt).value);
				}
				
				grand_totalAmnt +=  parseInt(_('amntInput'+cnt).value);
				grand_totalUnit += parseInt(_('credUniInput'+cnt).value);
				
				if (student_balance < 0)
				{
					_("smke_screen_2").style.zIndex = '2';
					_("smke_screen_2").style.display = 'Block';

					_('msg_msg_info').innerHTML = "<b>Insufficient fund</b><br>To fund your eWallet:<br>1. Click the Ok button here<br>2. Click 'My home' (top right)<br>3. Close the central notice boxes<br>4. Click 'Make payment' (bottom right)";
					_('info_box').style.zIndex = '3';
					_('info_box').style.display = 'block';
					return false;
				}
			}else
			{
				if (!_('regCourses'+cnt).disabled)
				{
					_('regCourses'+cnt).checked=false;
				}

				_('grand_total_amount').value = _('arch_grand_totalAmnt').value;
			}
		}
	}

	
	
	if (_('select_all1').innerHTML=='Select all')
	{
		_('select_all1').innerHTML='De-select all';
	}else
	{
		_('select_all1').innerHTML='Select all';
	}

	if (_('total_number_of_course_pend') && _('enforce_co').value == '0')
	{
		_('total_credit_unit_pend').value = totalUnit_pend;
		_('total_amnt_pend').value = totalAmnt_pend;

		_('total_credunit_div_pend').innerHTML = totalUnit_pend;
		_('total_amnt_div_pend').innerHTML = totalAmnt_pend;
		
		val_total_amnt = _('total_amnt_pend').value;
		val_total_amnt = parseInt(val_total_amnt);
		_('total_amnt_div_pend').innerHTML = addCommas(val_total_amnt);
	}

	_('total_credunit_div_toreg').innerHTML = totalUnit_toreg;
	_('total_amnt_div_toreg').innerHTML = totalAmnt_toreg;

	_('total_credit_unit_toreg').value = totalUnit_toreg;
	_('total_amnt_toreg').value = totalAmnt_toreg
	
	_('grand_total_creditunit_div').innerHTML = grand_totalUnit;
	_('grand_total_amount_div').innerHTML = grand_totalAmnt;
	
	_('grand_total_credit_unit').value = grand_totalUnit;

	if (grand_totalAmnt < 0)
	{
		_('grand_total_amount').value = parseInt(_('grand_total_amount').value) + grand_totalAmnt;
	}else
	{
		_('grand_total_amount').value = parseInt(_('grand_total_amount').value) + grand_totalAmnt;
	}
	
	val_total_amnt = _('total_amnt_toreg').value;
	val_total_amnt = parseInt(val_total_amnt);
	_('total_amnt_div_toreg').innerHTML = addCommas(val_total_amnt);
	
	val_total_amnt = _('grand_total_amount').value;
	val_total_amnt = parseInt(val_total_amnt);
	_('grand_total_amount_div').innerHTML = addCommas(val_total_amnt);
}
	
		
function addCommas(nStr)
{
	nStr += '';
	var x = nStr.split('.');
	var x1 = x[0];
	var x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1))
	{
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	//return x1 + x2;
	return x1;
}


function doesConnectionExist() {
    var xhr = new XMLHttpRequest();
    var file = "https://www.nouonline.nou.edu.ng";
    var randomNum = Math.round(Math.random() * 10000);
 
    xhr.open('HEAD', file + "?rand=" + randomNum, true);
    xhr.send();
     
    xhr.addEventListener("readystatechange", processRequest, false);
 
    function processRequest(e) {
      if (xhr.readyState == 4) {
        if (xhr.status >= 200 && xhr.status < 304) {
          return 1;
        } else {
         return 0;
        }
      }
    }
}



function fileValidation(fileId)
{
	//var fileInput = document.getElementById('file');
	var fileInput = fileId;
	var filePath = _(fileInput).value;
	//var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
	var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
	if(!allowedExtensions.exec(filePath))
	{
		return false;
	}else
	{
		return true;
		//Image preview
		/*if (fileInput.files && fileInput.files[0])
		{
			var reader = new FileReader();
			reader.onload = function(e) {
				document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"/>';
			};
			reader.readAsDataURL(fileInput.files[0]);
		}*/
	}
}


function csvfileValidation(fileId)
{
	//var fileInput = document.getElementById('file');
	var fileInput = fileId;
	var filePath = _(fileInput).value;
	//var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
	var allowedExtensions = /(\.csv)$/i;
	if(!allowedExtensions.exec(filePath))
	{
		return false;
	}else
	{
		return true;
	}
}


function update_day(month_no, day_no)
{
	var selected_day = _(day_no).value;

	_(day_no).length = 0;
	_(day_no).options[_(day_no).length] = new Option('', '');

	if (month_no == 1 || month_no == 3 || month_no == 5 || month_no == 7 || month_no == 8 || month_no == 10 || month_no == 12)
	{
		var max_day = 31;//31
	}else if (month_no == 4 || month_no == 6 || month_no == 9 || month_no == 11)
	{
		var max_day = 30;//30
	}else
	{
		var max_day = 29;//29
	}

	for (i = 1; i <= max_day; i++)
	{
		_(day_no).options[_(day_no).length] = new Option(pad(i, 2, 0), pad(i, 2, 0));
	}
	_(day_no).value = selected_day;
}


function checkConnection()
{
	return false;
	var ifConnected = window.navigator.onLine;
	setInterval
	(
		function()
		{
			var ifConnected = window.navigator.onLine;
			if (ifConnected)
			{
				// _("on_error").style.display = 'none';
				// _("on_error").style.zIndex = -1;
                // _("on_error_msg").innerHTML = 'Request not processed. Please try again';
			} else if (!ifConnected)
			{
				// _("on_error_msg").innerHTML = 'You are not connected';
                // _("on_error").style.display = 'Block';
                // _("on_error").style.zIndex = '6';
                
                //_("general_smke_screen").style.display = 'block';
                //_("general_smke_screen").style.zIndex = '5';

                
                // _("container_cover_constat").style.display = 'block';
				// _("container_cover_in_constat").style.display = 'block';
				// _("div_header_constat").style.display = 'block';
				// _("div_message_constat").style.display = 'block';
				
				// _("container_cover_constat").style.zIndex = 10;
				// _("container_cover_in_constat").style.zIndex = 11;
			}
		}, 3000
	);
}


function Intials(cString) 
{
	var sInitials = "";
	var wordArray = cString.split(" ");
	for( i = 0; i<wordArray.length; i++)
	{
		sInitials += wordArray[i].substring(0,1).toUpperCase();
	} // end loop name words;
	return sInitials; // return initials;
} // end Initials function;


function passwordStrength(password, message_box)
{	
	var desc = new Array();
	desc[0] = "Very Weak";
	desc[1] = "Weak";
	desc[2] = "Fair";
	desc[3] = "Strong";
	desc[4] = "Very Strong";

	var score   = 0;

	//if password bigger than 6 give 1 point
	if (password.length > 8) score++;

	//if password has both lower and uppercase characters give 1 point
	if ( ( password.match(/[a-z]/)) && (password.match(/[A-Z]/)) && score > 0 ) score++;

	//if password has at least one number give 1 point
	if (password.match(/\d+/)) score++;

	//if password has at least one special caracther give 1 point
	if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) && score > 0) score++;

	//if password bigger than 12 give another 1 point
	if (password.length > 10) score++;

	// do a serverside dictionary check

	
	
	for (var j = 0; j <= password.length-1; j++)
	{
		if (password.length > 1 && j < password.length-1)
		{
			var currect_chracter_code = parseInt(password.charCodeAt(j));
			var next_chracter_code = parseInt(password.charCodeAt(j+1));

			//check aphabetic/numeric sequence
			if ((password.charCodeAt(j) >= 48 && password.charCodeAt(j) <= 57) || (password.charCodeAt(j) >= 97 && password.charCodeAt(j) <= 122))
			{
				if ((next_chracter_code - currect_chracter_code) == 1)
				{
					if (score > 0){score--;}
				}
			}

			//check for repetitive chrachters
			if ((password.charCodeAt(j) >= 97 && password.charCodeAt(j) <= 122) && password.charAt(j).toLowerCase() == password.charAt(j+1).toLowerCase())
			{
				if (score > 0){score--;}
			}else if (next_chracter_code == currect_chracter_code)
			{
				if (score > 0){score--;}
			}
		}
	}

	if (score == 0)
	{
		_(message_box).style.background = '#CCCCCC';
	}else if (score == 1)
	{
		_(message_box).style.background = '#ff0000';
	}else if (score == 2)
	{
		_(message_box).style.background = '#ff5f5f';
	}else if (score == 3)
	{
		_(message_box).style.background = '#56e500';
	}else if (score == 4)
	{
		_(message_box).style.background = '#4dcd00';
	}
	_(message_box).innerHTML = desc[score];
	_(message_box).style.display = 'block';
}


function in_progress(state)
{
    _("general_smke_screen").style.display = 'none';
	_("general_smke_screen").style.zIndex = '-1';

	_("in_progress").style.display = 'none';
	_("in_progress").style.zIndex = '-1';

	if(state == 1)
	{
		_("general_smke_screen").style.display = 'block';
		_("general_smke_screen").style.zIndex = '5';

		_("in_progress").style.display = 'Block';
		_("in_progress").style.zIndex = '6';
	}
}

function on_error(state)
{
    _("general_smke_screen").style.display = 'none';
    _("general_smke_screen").style.zIndex = '-1';

    _("on_error").style.display = 'none';
    _("on_error").style.zIndex = '-1';

	if(state == 1)
	{
		_("general_smke_screen").style.display = 'block';
		_("general_smke_screen").style.zIndex = '5';

		_("on_error").style.display = 'Block';
		_("on_error").style.zIndex = '6';
	}
}

function on_abort(state)
{
	_("general_smke_screen").style.display = 'none';
    _("general_smke_screen").style.zIndex = '-1';

    _("on_abort").style.display = 'none';
    _("on_abort").style.zIndex = '-1';

	if(state == 1)
	{
		_("general_smke_screen").style.display = 'block';
		_("general_smke_screen").style.zIndex = '5';
	
		_("on_abort").style.display = 'Block';
		_("on_abort").style.zIndex = '6';
	}
}


function caution_box(msg)
{
    _("general_smke_screen").style.display = 'block';
    _("general_smke_screen").style.zIndex = '5';

	_("general_caution_msg_msg").innerHTML = msg;

    _("general_caution_box").style.display = 'Block';
    _("general_caution_box").style.zIndex = '6';
}


function success_box(msg)
{
    _("general_smke_screen").style.display = 'block';
    _("general_smke_screen").style.zIndex = '5';

	_("general_success_msg_msg").innerHTML = msg;

    _("general_success_box").style.display = 'Block';
    _("general_success_box").style.zIndex = '6';
}

function wordCount(text)
{
	numWords = 0;
	for (var i = 0; i < text.length; i++) {
		var currentCharacter = text[i];
	
		if (currentCharacter == " ")
		{
			numWords += 1;
		}
	}

	if (numWords > 0)
	{
		return ++numWords;
	}else
	{
		return 0;
	}
}


function remove_hyphen(val)
{
	var new_val = '';
	for (x = 0; x <= val.length-1; x++)
	{
		if (val.charAt(x) != '-')
		{
			new_val = new_val + val.charAt(x);
		}
	}

	new_val = new_val.substr(6,2) + new_val.substr(4,2)+new_val.substr(0,4);
	return new_val;
}


function set_lower_uper_limit()
{
	if(_('cprogrammeIdold').value!='')
	{
		//update_cat_country('cprogrammeIdold', 'courseId_readup', 'ccourseIdold', 'ccourseIdold');
		_('courseLevel_old').length = 0;
		_('courseLevel_old').options[_('courseLevel_old').options.length] = new Option('Select level', '');

		if (_('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,3) == 'PGD')
		{
			_('courseLevel_old').options[_('courseLevel_old').options.length] = new Option(700, 700);
			_('courseLevel_old').value=700;
		}else if ((_('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,1) == 'M' || _('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,6) == 'Common') && _('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,7) != 'M. Phil')
		{
			_('courseLevel_old').options[_('courseLevel_old').options.length] = new Option(800, 800);
			_('courseLevel_old').value=800;
		}else if (_('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,1) == 'B' || _('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,3) == 'LLM')
		{
			cnt1 = 100;
			cnt2 = 300;

			if (_('cprogrammeIdold').value.substr(0,6) == 'AGR206')
			{
				cnt1 = 100;
				cnt2 = 100;
			}else if (_('cprogrammeIdold').value.substr(0,4) == 'EDU2' || _('cprogrammeIdold').value.substr(0,4) == 'ART2')
			{
				cnt1 = 100;
				cnt2 = 200;
			}else if (_('cFacultyIdold07').value == 'HSC')
			{
				cnt1 = 200;
				cnt2 = 300;
				if (_('cprogrammeIdold').value == 'HSC202'|| _('cprogrammeIdold').value == 'HSC204')
				{
					cnt1 = 200;
					cnt2 = 200;
				}
			}else if (_('cFacultyIdold07').value == 'MSC')
			{
				if (_('cprogrammeIdold').value == 'MSC207')
				{
					cnt1 = 100;
					cnt2 = 300;
				}                                                    
			}else if (_('cFacultyIdold07').value == 'SCI')
			{
				if (_('cprogrammeIdold').value == 'SCI204' || _('cprogrammeIdold').value == 'SCI207' || _('cprogrammeIdold').value == 'SCI210' || _('cprogrammeIdold').value == 'SCI209')
				{
					cnt1 = 100;
					cnt2 = 200;
				}
			}else if (_('cFacultyIdold07').value == 'SSC')
			{
				if (_('cprogrammeIdold').value == 'SSC205' || _('cprogrammeIdold').value == 'SSC206' || _('cprogrammeIdold').value == 'SSC201' || _('cprogrammeIdold').value == 'SSC209')
				{
					cnt1 = 100;
					cnt2 = 200;
				}
			}else if (_('cFacultyIdold07').value == 'LAW')
			{
				cnt1 = 800;
				cnt2 = 800;
			}

			for (cnt = cnt1; cnt <= cnt2; cnt+=100)
			{
				_('courseLevel_old').options[_('courseLevel_old').options.length] = new Option(cnt, cnt);
			}

			_('courseLevel_old').value=100;
		}else if (_('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(3,3) == 'Phi')
		{
			_('courseLevel_old').length = 0;
			//_('courseLevel_old').options[_('courseLevel_old').options.length] = new Option(900, 900);
			//_('courseLevel_old').value=900;
		}else
		{
			_('courseLevel_old').length = 0;
			//_('courseLevel_old').options[_('courseLevel_old').options.length] = new Option(1000, 1000);
			//_('courseLevel_old').value=1000;
		}
		_('warned1').value='0'; _('sub_box_0').style.display='block'; _('sub_box_1').style.display='none';
		sets.level_options.value = _('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,3);
	}
}