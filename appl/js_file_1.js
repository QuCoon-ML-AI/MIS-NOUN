// JavaScript Document


document.addEventListener("contextmenu", (e) => {e.preventDefault()});

document.addEventListener('keydown', function (event) 
{
    if (event.ctrlKey && (event.key == 'u' 
    || event.key == 'U'))
    {
        event.preventDefault();
    }
});


function _(el)
{
	return document.getElementById(el)
}

document.addEventListener('keydown', evt => {

if (evt.key === 'Escape')
{
	if (_('container_cover_ini_pay'))
	{
		_('container_cover_ini_pay').style.display = 'none';
		_('container_cover_ini_pay').style.zIndex = '-1';
	}
	
	if (_('smke_screen'))
	{
		_('smke_screen').style.display = 'none';
		_('smke_screen').style.zIndex = '-1';
	}
	
	if (_('smke_screen_2'))
	{
		_('smke_screen_2').style.display = 'none';
		_('smke_screen_2').style.zIndex = '-1';
	}
	
	if (_('container_cover_in_chkps'))
	{
		_("container_cover_in_chkps").style.zIndex = -1;
		_("container_cover_in_chkps").style.display = 'none';
	}
	
	if (_('conf_warn'))
	{
		_("conf_warn").style.zIndex = -1;
		_("conf_warn").style.display = 'none';
	}

	if (_('inform_box'))
	{
		_("inform_box").style.zIndex = -1;
		_("inform_box").style.display = 'none';
	}
	
	if (_('abort_box'))
	{
		_("abort_box").style.zIndex = -1;
		_("abort_box").style.display = 'none';
		_("abort_box_msg").innerHTML = '';
	}
	
	if (_('caution_inform_box'))
	{
		_("caution_inform_box").style.zIndex = -1;
		_("caution_inform_box").style.display = 'none';
		_("informa_msg_content_caution").innerHTML = '';
	}
	
	if (_('container_cover_in'))
	{
		_("container_cover_in").style.zIndex = -1;
		_("container_cover_in").style.display = 'none';
	}
	
	if (_('conf_box_loc'))
	{
		_("conf_box_loc").style.zIndex = -1;
		_("conf_box_loc").style.display = 'none';
	}
	
	
	if (_('intro_video'))
	{
		_("intro_video").style.zIndex = -1;
		_("intro_video").style.display = 'none';

		_("smke_screen_5").style.zIndex = -1;
		_("smke_screen_5").style.display = 'none';
	}
	
	
	if (_('calendar_container'))
	{
		_("calendar_container").style.zIndex = -1;
		_("calendar_container").style.display = 'none';

		_("smke_screen_6").style.zIndex = -1;
		_("smke_screen_6").style.display = 'none';
	}
	
	if (_('token_dialog_box'))
	{
		_("token_dialog_box").style.zIndex = -1;
		_("token_dialog_box").style.display = 'none';

		_("smke_screen").style.zIndex = -1;
		_("smke_screen").style.display = 'none';
	}
	
	if (_('application_steps'))
	{
		_("application_steps").style.zIndex = -1;
		_("application_steps").style.display = 'none';

		_("smke_screen_2").style.zIndex = -1;
		_("smke_screen_2").style.display = 'none';
	}

	if (_('smke_screen_3'))
	{
		_("smke_screen_3").style.zIndex = -1;
		_("smke_screen_3").style.display = 'none';
	}

	if (_('noticeboard'))
	{
		_("noticeboard").style.zIndex = -1;
		_("noticeboard").style.display = 'none';
	}


	if (_('subject_list'))
	{
		_("subject_list").style.zIndex = -1;
		_("subject_list").style.display = 'none';

		_("smke_screen_3").style.zIndex = -1;
		_("smke_screen_3").style.display = 'none';
	}


	if (_('confirm_box'))
	{
		_("confirm_box").style.zIndex = -1;
		_("confirm_box").style.display = 'none';
	}
}
});


function capitalizeEachWord(str)
{
	var splitStr = str.toLowerCase().split(' ');
	for (var i = 0; i < splitStr.length; i++)
	{
	   splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
	}
	return splitStr.join(' ');
}


function in_progress(state)
{
    _("smke_screen").style.display = 'none';
	_("smke_screen").style.zIndex = '-1';

	_("inprogress_box").style.display = 'none';
	_("inprogress_box").style.zIndex = '-1';

	_("ok_button").style.display = 'none';

	if(state == 1)
	{
		_("smke_screen").style.display = 'block';
		_("smke_screen").style.zIndex = '5';

		_("inprogress_box").style.display = 'Block';
		_("inprogress_box").style.zIndex = '6';

		_("inprogress_box_msg").innerHTML = 'Processing, Please wait...';
	}
}


function on_error(state)
{
    _("smke_screen").style.display = 'none';
    _("smke_screen").style.zIndex = '-1';

    _("abort_box").style.display = 'none';
    _("abort_box").style.zIndex = '-1';

	if(state == 1)
	{
		_("ok_button").style.display = 'block';

		_("smke_screen").style.display = 'block';
		_("smke_screen").style.zIndex = '5';

		_("abort_box").style.display = 'Block';
		_("abort_box").style.zIndex = '6';

		_("abort_box_msg").innerHTML = 'Your internet connection was interrupted. Please try again';
	}
}

function on_abort(state)
{
	_("smke_screen").style.display = 'none';
    _("smke_screen").style.zIndex = '-1';

    _("abort_box").style.display = 'none';
    _("abort_box").style.zIndex = '-1';

	if(state == 1)
	{		
		_("ok_button").style.display = 'block';
		
		_("smke_screen").style.display = 'block';
		_("smke_screen").style.zIndex = '5';
	
		_("abort_box").style.display = 'Block';
		_("abort_box").style.zIndex = '6';

		_("abort_box_msg").innerHTML = 'Process aborted';
	}
}


function inform(msg)
{
	_("smke_screen").style.display = 'block';
	_("smke_screen").style.zIndex = '5';

	_("inform_box").style.display = 'Block';
	_("inform_box").style.zIndex = '6';

	_("ok_button").style.display = 'block';
		
	_("informa_msg_content").innerHTML = msg;
}



function caution_inform(msg)
{
	_("smke_screen").style.display = 'block';
	_("smke_screen").style.zIndex = '5';

	_("caution_inform_box").style.display = 'Block';
	_("caution_inform_box").style.zIndex = '6';

	_("ok_caution_button").style.display = 'block';
		
	_("informa_msg_content_caution").innerHTML = msg;
}


function logout_inform_box(msg)
{
	_("smke_screen").style.display = 'block';
	_("smke_screen").style.zIndex = '5';

	_("logout_inform_box").style.display = 'Block';
	_("logout_inform_box").style.zIndex = '6';
		
	_("informa_msg_content_caution_l").innerHTML = msg;
}


function fileValidation(fileId)
{
	//var fileInput = document.getElementById('file');
	var fileInput = fileId;
	var filePath = _(fileInput).value;
	//var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
	//var allowedExtensions = /(\.jpg|\.jpeg)$/i;
	var allowedExtensions = /(\.jpg)$/i;
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




function update_cat_country(callerctrl, parentctrl, childctrl1, childctrl2)
{
	cProgdesc = '';
	cProgId = '';

	external_cnt = 0;
	
	if (callerctrl.indexOf("Country") > -1)	
	{
		_(childctrl1).length = 0;
		_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');

		if (_(childctrl2))
		{
			_(childctrl2).length = 0;
			_(childctrl2).options[_(childctrl2).options.length] = new Option('', '');
		}

	 	for (var i = 0; i <= _(parentctrl).length-1; i++)
		{
			if (_(parentctrl).options[i].value.substr(2,2) == _(callerctrl).value)
			{
				external_cnt++;
				if (external_cnt%5==0)
				{
					_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
					//_(childctrl1).options[_(childctrl1).options.length].disabled = true;
				}

				cProgdesc = _(parentctrl).options[i].text;
				cProgId = _(parentctrl).options[i].value.substr(0,2);

				_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
			}
		}
		
		if (cProgId == '')
		{
			_(childctrl1).length = 0;
			_(childctrl1).options[_(childctrl1).options.length] = new Option('Non Nigerian', '99');
			
			if (_(childctrl2))
			{
				_(childctrl2).length = 0;
				_(childctrl2).options[_(childctrl2).options.length] = new Option('Non Nigerian', '99999');
			}
		}
	}else if (callerctrl.indexOf("State") > -1 || callerctrl == 'crit9' || callerctrl == 'crit11')	
	{
		_(childctrl1).length = 0;
		_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
		
	 	for (var i = 0; i <= _(parentctrl).length-1; i++)
		{
			if (_(parentctrl).options[i].value.substr(0,2) == _(callerctrl).value)
			{
				external_cnt++;
				if (external_cnt%5==0)
				{
					_(childctrl1).options[_(childctrl1).options.length] = new Option('', '');
					//_(childctrl1).options[_(childctrl1).options.length].disabled = true;
				}
				
				cProgdesc = _(parentctrl).options[i].text;
				cProgId = _(parentctrl).options[i].value.substr(2,5);

				_(childctrl1).options[_(childctrl1).options.length] = new Option(cProgdesc, cProgId);
			}
		}
	}else if (callerctrl.indexOf("Faculty") > -1 || callerctrl.indexOf("faculty") > -1 || callerctrl == 'crit2')	
	{
		_(childctrl1).length = 0;
		_(childctrl1).options[_(childctrl1).options.length] = new Option('Select a department', '');

		if (_(childctrl2))
		{
			_(childctrl2).length = 0;
			_(childctrl2).options[_(childctrl2).options.length] = new Option('', '');
		}
		
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
				
				if (cProgId == 'HSC204' || cProgId == 'HSC205')
				{
				    continue;
				}
				
				if (cProgdesc.indexOf("PhD") != -1 || cProgdesc.indexOf("MPhil") != -1)
				{
					if (notice_written == 0 && !_("mm"))
					{
						if (_(callerctrl).value == 'ENG' || _(callerctrl).value == 'RST' || _(callerctrl).value == 'LNG' || 
						_(callerctrl).value == 'EFO' || _(callerctrl).value == 'SED' || 
						_(callerctrl).value == 'PHE' || 
						_(callerctrl).value == 'LLW' ||
						_(callerctrl).value == 'ENT' ||
						_(callerctrl).value == 'CSS' || _(callerctrl).value == 'MAC' || _(callerctrl).value == 'ECO' || _(callerctrl).value == 'PCR')
						{
							_(childctrl1).options[_(childctrl1).options.length+1] = new Option("MPhil and PhD candidates are screened via interview", '');
							notice_written = 1;
						}
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



// function set_lower_uper_limit()
// {
// 	function _(el)
// 	{
// 		return document.getElementById(el)
// 	}
	
// 	_('courseLevel_old').length = 0;
// 	_('courseLevel_old').options[_('courseLevel_old').options.length] = new Option('Select level', '');

// 	if(_('cprogrammeIdold').value!='')
// 	{
// 		if (_('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,3) == 'PGD')
// 		{
// 			_('courseLevel_old').options[_('courseLevel_old').options.length] = new Option(700, 700);
// 			_('courseLevel_old').value=700;
// 		}else if ((_('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,1) == 'M' || _('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,6) == 'Common') && _('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,7) != 'M. Phil')
// 		{
// 			_('courseLevel_old').options[_('courseLevel_old').options.length] = new Option(800, 800);
// 			_('courseLevel_old').value=800;
// 		}else if (_('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,1) == 'B' || _('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,3) == 'LLM')
// 		{
// 			cnt1 = 100;
// 			cnt2 = 300;

// 			if (_('cprogrammeIdold').value.substr(0,6) == 'AGR206')
// 			{
// 				cnt1 = 100;
// 				cnt2 = 100;
// 			}else if (_('cprogrammeIdold').value.substr(0,4) == 'EDU2' || _('cprogrammeIdold').value.substr(0,4) == 'ART2')
// 			{
// 				cnt1 = 100;
// 				cnt2 = 200;
// 			}else if (_('cFacultyIdold07').value == 'HSC')
// 			{
// 				cnt1 = 200;
// 				cnt2 = 300;
// 				if (_('cprogrammeIdold').value == 'HSC202'|| _('cprogrammeIdold').value == 'HSC204')
// 				{
// 					cnt1 = 200;
// 					cnt2 = 200;
// 				}
// 			}else if (_('cFacultyIdold07').value == 'MSC')
// 			{
// 				if (_('cprogrammeIdold').value == 'MSC207')
// 				{
// 					cnt1 = 100;
// 					cnt2 = 300;
// 				}                                                    
// 			}else if (_('cFacultyIdold07').value == 'SCI')
// 			{
// 				if (_('cprogrammeIdold').value == 'SCI204' || _('cprogrammeIdold').value == 'SCI207' || _('cprogrammeIdold').value == 'SCI210')
// 				{
// 					cnt1 = 100;
// 					cnt2 = 200;
// 				}else if (_('cprogrammeIdold').value == 'SCI209')
// 				{
// 					cnt1 = 100;
// 					cnt2 = 300;alert()
// 				}
// 			}else if (_('cFacultyIdold07').value == 'SSC')
// 			{
// 				if (_('cprogrammeIdold').value == 'SSC205' || _('cprogrammeIdold').value == 'SSC206' || _('cprogrammeIdold').value == 'SSC201' || _('cprogrammeIdold').value == 'SSC209')
// 				{
// 					cnt1 = 100;
// 					cnt2 = 200;
// 				}
// 			}else if (_('cFacultyIdold07').value == 'LAW')
// 			{
// 				cnt1 = 800;
// 				cnt2 = 800;
// 			}

// 			for (cnt = cnt1; cnt <= cnt2; cnt+=100)
// 			{
// 				_('courseLevel_old').options[_('courseLevel_old').options.length] = new Option(cnt, cnt);
// 			}

// 			_('courseLevel_old').value=100;
// 		}else if (_('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(3,3) == 'Phi')
// 		{
// 			_('courseLevel_old').length = 0;
// 		}else
// 		{
// 			_('courseLevel_old').length = 0;
// 		}
// 		_('level_options').value = _('cprogrammeIdold').options[_('cprogrammeIdold').selectedIndex].text.substr(0,3);
// 	}
// }


function resetSideMenu()
{
	var ulChildNodes = document.getElementsByTagName("form")
	for (j = 0; j <= ulChildNodes.length-1; j++)
	{
		if (ulChildNodes[j].top_menu_no)
		{
			ulChildNodes[j].top_menu_no.value = 0;
		}
		
		if (ulChildNodes[j].side_menu_no)
		{
			ulChildNodes[j].side_menu_no.value = 0;
		}
	}
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
	
	var disabledFound = 0;
	
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
						caution_inform('Maximum credit unit load of '+_("max_crload").value+' exceeded');
						return false;
					}
				}

				if (!_('regCourses'+cnt).disabled)
				{
					_('regCourses'+cnt).checked=true;
				}
				
				if (_('total_number_of_course_pend'))
				{
					if (cnt <= _('total_number_of_course_pend').value && _('cc_must').value == '0')
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
					caution_inform("<b>Insufficient fund</b><br>To fund your eWallet:<br>1. Click the Ok button<br>2. Click 'Bursary' above<br>3. Click 'Make payment' (left)<br>4. Follow the prompt on the screen");
					return false;
				}
			}else
			{
				if (!_('regCourses'+cnt).disabled)
				{
					_('regCourses'+cnt).checked=false;
				
    				// grand_totalAmnt = 0.00;
    
    				// //_('grand_total_amount').value = _('arch_grand_totalAmnt').value;
    				// _('grand_total_amount').value = 0.00;
    				// _('grand_total_amnt').value = 0.00;
				}else
				{
				    disabledFound = 1;
				}
			}
		}
	}
	
	if (_('select_all1').innerHTML=='De-select all' && disabledFound == 0)
	{
        grand_totalAmnt = 0.00;
    
		//_('grand_total_amount').value = _('arch_grand_totalAmnt').value;
		_('grand_total_amount').value = 0.00;
		_('grand_total_amnt').value = 0.00;
	}
	
	if (_('select_all1').innerHTML=='Select all')
	{
		_('select_all1').innerHTML='De-select all';
	}else
	{
		_('select_all1').innerHTML='Select all';
	}

	if (_('total_number_of_course_pend') /*&& _('cc_must').value == '1'*/)
	{
		if (_('total_credit_unit_pend'))
		{
		    _('total_credit_unit_pend').value = totalUnit_pend;
		}
		_('total_amnt_pend').value = totalAmnt_pend;
        
        if (_('total_credunit_div_pend'))
		{
		    _('total_credunit_div_pend').innerHTML = totalUnit_pend;
		}
		
		
        if (_('total_amnt_div_pend'))
		{
		    _('total_amnt_div_pend').innerHTML = totalAmnt_pend;
		}
		
		val_total_amnt = _('total_amnt_pend').value;
		val_total_amnt = parseInt(val_total_amnt);
		
        if (_('total_amnt_div_pend'))
		{
		    _('total_amnt_div_pend').innerHTML = addCommas(val_total_amnt);
		}
	}

	_('total_credunit_div_toreg').innerHTML = totalUnit_toreg;
	_('total_amnt_div_toreg').innerHTML = totalAmnt_toreg;

	_('total_credit_unit_toreg').value = totalUnit_toreg;
	_('total_amnt_toreg').value = totalAmnt_toreg
	
	_('grand_total_creditunit_div').innerHTML = grand_totalUnit;
	_('grand_total_amount_div').innerHTML = addCommas(grand_totalAmnt);
	
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
	//_('grand_total_amount_div').innerHTML = addCommas(val_total_amnt);
}


function set_figures(courseSelected,amount,creditUnit,pend_current)
{
	if (courseSelected)
	{
		_('select_all1').innerHTML = 'De-select all';
		
		if (_('total_amnt_'+pend_current))
		{
			if (parseInt(_('student_balance').value) < 0)
			{
				caution_inform("<b>Insufficient fund</b><br>To fund your eWallet:<br>1. Click the Ok button<br>2. Click 'Bursary' above<br>3. Click 'Make payment' (left)<br>4. Follow the prompt on the screen");
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
		//if (parseInt(_('grand_total_amount').value) + amount > parseInt(_('student_balance').value))
		if (parseInt(_('grand_total_amount').value) - amount < 0)
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

		_('grand_total_amount').value = _('grand_total_amount').value - parseInt(amount);
		if (_('grand_total_amount').value < 0)
		{
			_('grand_total_amount').value = 0;
		}


		// _('grand_total_amount_div').innerHTML = parseInt(_('grand_total_amount_div').innerHTML) - parseInt(amount);alert(_('grand_total_amount_div').innerHTML)
		// if (_('grand_total_amount_div').innerHTML < 0)
		// {
		// 	_('grand_total_amount_div').innerHTML = 0;
		// }

		_('grand_total_amount_div').innerHTML = _('grand_total_amount').value ;
		// if (_('grand_total_amount_div').innerHTML < 0)
		// {
		// 	_('grand_total_amount_div').innerHTML = 0;
		// }

		// alert(_('grand_total_amount').value)
		// _('grand_total_amount').value = parseInt(_('grand_total_amount').value) - parseInt(amount);alert(_('grand_total_amount').value)
		// if (_('grand_total_amount').value < 0)
		// {
		// 	_('grand_total_amount').value = 0;
		// }

		if (_('grand_total_credit_unit').value == 0)
		{
			_('select_all1').innerHTML = 'Select all';
		}
	}

	val_total_amnt = _('total_amnt_'+pend_current).value;
	val_total_amnt = parseInt(val_total_amnt);
	_('total_amnt_div_'+pend_current).innerHTML = addCommas(val_total_amnt);
	
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


function get_ol_subjects()
{
	return false;
	
	if (_("cQualCodeId").value != '' && _("vExamNo").value != '' && _("cExamMthYear").value.length == 6)
	{
		_('exam_id').innerHTML = 'Exam:'+' <b>'+_("cQualCodeId_desc").value+'</b><br>Exam number:<b>'+_("vExamNo").value+'</b><br>Exam month and year:<b>'+_("cExamMthYear").value+'</b>';

		_("subject_list").style.zIndex = 3;
		_("subject_list").style.display = 'block';

		_("smke_screen_3").style.zIndex = 2;
		_("smke_screen_3").style.display = 'block';
	}
}


function pad(n, width, z) 
{
  z = z || '0';
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}


function app_confirm_box()
{	
	if (_('success_div'))
	{
		_("smke_screen").style.display = 'none';
		_("smke_screen").style.zIndex = '-1';

		_("confirm_box").style.display = 'none';
		_("confirm_box").style.zIndex = '-1';

		in_progress('1');
		form_sections.submit();
	}else
	{
		_("smke_screen").style.display = 'block';
		_("smke_screen").style.zIndex = '5';

		_("confirm_box").style.display = 'block';
		_("confirm_box").style.zIndex = '6';
	}
		
	_("confirm_msg_content").innerHTML = 'This action does not save changes<br>To save changes, click No then click the Next button (lower right) otherwise, click Yes<br>Continue?';
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
		return "should end with  . something";
	}
	
	return '';
}




function do_capt()
{
	var formdata = new FormData();
	with (ps)
	{
		if (ps.user_cat.value == 6)
		{
			formdata.append("vApplicationNo", vApplicationNo.value);
		}else if (ps.user_cat.value == 4 || ps.user_cat.value == 5)
		{
			formdata.append("vMatricNo", vMatricNo.value);
		}else if (ps.user_cat.value == 3 || ps.user_cat.value == 1)
		{
			formdata.append("vApplicationNo", vApplicationNo.value);
		}
	}

	opr_prep_1(ajax = new XMLHttpRequest(),formdata);
}


function opr_prep_1(ajax,formdata)
{
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler_1, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    
	if (ps.user_cat.value == 6)
	{
    	ajax.open("POST", "opr_conf_cap.php");
	}else if (ps.user_cat.value == 4 || ps.user_cat.value == 5)
	{
		ajax.open("POST", "opr_conf_cap_5.php");
	}else if (ps.user_cat.value == 3 || ps.user_cat.value == 1)
	{
		ajax.open("POST", "opr_conf_cap_4.php");
	}
    ajax.send(formdata);
}




function completeHandler_1(event)
{
	on_error('0');
	on_abort('0');
	in_progress('0');
	var returnedStr = event.target.responseText;
	
	if (returnedStr.indexOf("Invalid user name") > -1 || 
	returnedStr.indexOf("Role not assigned") > -1 || 
	returnedStr.indexOf("Centre not assigned") > -1 || 
	returnedStr.indexOf("Matriculation number archived") > -1 ||  
	returnedStr.indexOf("to be activated") > -1 || 
	returnedStr.indexOf("Invalid matriculation number") > -1 || 
	returnedStr.indexOf("Invalid Application form number") > -1 || 
	returnedStr.indexOf("Enter captcha") > -1)
	{
		_("cap_mean").style.display = 'none';
		_("cap_caller").style.display = 'none';
		_("cap_resp").style.display = 'none';

		caution_inform(returnedStr);
	}else
	{
		_("cap_text").value = '';

		var canvasWinth = 150;
		var canvasHeight = 30;

		var context = _('valicode').getContext('2d');
		_('valicode').width = canvasWinth;
		_('valicode').height = canvasHeight;

		context.clearRect(0, 0, canvasWinth, canvasHeight);

		var saCode = returnedStr.split(',');

		var cTxt = '';
		var x = '';
		var y = '';
		var sDeg = '';

		for (var i = 0; i <= 4; i++)
		{
			sDeg = (Math.random()*30*Math.PI) / 180;
			cTxt = saCode[i];
			
			x = 10 + i*20;
			y = 20 + Math.random()*8;

			context.font = 'bold 23px Verdana, Arial, Helvetica, sans-serif';

			context.translate(x, y);
			context.rotate(sDeg);

			context.fillStyle = "#3c6d10";
			context.fillText(cTxt, 0, 0);

			context.rotate(-sDeg);
			context.translate(-x, -y);
		}

		for (let i = 0; i <= 6; i++)
		{
		context.strokeStyle = randomColor();
		context.beginPath();
		context.moveTo(
			Math.random() * canvasWinth,
			Math.random() * canvasHeight
		);
		context.lineTo(
			Math.random() * canvasWinth,
			Math.random() * canvasHeight
		);
		context.stroke();
		}

		for (let i = 0; i < 30; i++)
		{
		context.strokeStyle = randomColor();
		context.beginPath();
		let x = Math.random() * canvasWinth;
		let y = Math.random() * canvasHeight;
		context.moveTo(x,y);
		context.lineTo(x+1, y+1);
		context.stroke();
		}

		function randomColor ()
		{
		let r = Math.floor(Math.random()*256);
		let g = Math.floor(Math.random()*256);
		let b = Math.floor(Math.random()*256);
		return 'rgb(' + r + ',' + g + ',' + b + ')';
		}

		_("cap_mean").style.display = 'flex';
		_("cap_caller").style.display = 'flex';
		_("cap_resp").style.display = 'flex';
	}    
}
