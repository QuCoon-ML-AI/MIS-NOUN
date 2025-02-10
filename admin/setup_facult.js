// JavaScript Document

function chk_inputs()
{
	hideAllMsg();
	
	var letters = /^[A-Za-z ]+$/;
	
	var formdata = new FormData();
	
	var there_is_err = 0;	
	
	if (_("what_to_do").value == '' || _("on_what").value == '')
	{
		there_is_err = 1;
		setMsgBox("labell_msg14","Select action to perform");
		_("what_to_do").focus();
	}else if (_("what_to_do").value == '0' && _("on_what").value == '0')// new faculty
	{
		if (trim(_("cFacultyDescNew").value) == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg19","");
			_("cFacultyDescNew").focus();
		}else if (!_("cFacultyDescNew").value.match(letters))
		{
			there_is_err = 1;
			setMsgBox("labell_msg19","Alphabets only");
			_("cFacultyDescNew").focus();
		}else if (trim(_("cFacultyIdNew_abrv").value) == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg20","");
			_("cFacultyIdNew_abrv").focus();
		}else if (trim(_("cFacultyIdNew_abrv").value).length != 3)
		{
			there_is_err = 1;
			setMsgBox("labell_msg20","Exactly three characters required");
			_("cFacultyIdNew_abrv").focus();
		}else if (!isNaN(_("cFacultyIdNew_abrv").value.substr(0,1)) || !isNaN(_("cFacultyIdNew_abrv").value.substr(1,1)) || !isNaN(_("cFacultyIdNew_abrv").value.substr(2,1)))
		{
			there_is_err = 1;
			setMsgBox("labell_msg20","Alphabets only");
			_("cFacultyIdNew_abrv").focus();
		}else
		{
			formdata.append("cFacultyDescNew", _("cFacultyDescNew").value);
			formdata.append("cFacultyIdNew_abrv", _("cFacultyIdNew_abrv").value);
		}
	}else  if (_("what_to_do").value == '0' && _("on_what").value == '1')//new dept
	{
		if (_("cFacultyIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg15","");
			_("cFacultyIdold").focus();
		}else if (trim(_("cDeptDescNew").value) == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg21","");
			_("cDeptDescNew").focus();
		}else if (!_("cDeptDescNew").value.match(letters))
		{
			there_is_err = 1;
			setMsgBox("labell_msg21","Alphabets only");
			_("cDeptDescNew").focus();
		}else if (_("cFacultyIdNew_abrv").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg20","");
			_("cFacultyIdNew_abrv").focus();
		}else if (trim(_("cFacultyIdNew_abrv").value).length != 3)
		{
			there_is_err = 1;
			setMsgBox("labell_msg20","Exactly three characters required");
			_("cFacultyIdNew_abrv").focus();
		}else
		{
			formdata.append("cFacultyIdold", _("cFacultyIdold").value);
			formdata.append("cDeptDescNew", _("cDeptDescNew").value);
			formdata.append("cFacultyIdNew_abrv", _("cFacultyIdNew_abrv").value);
		}
	}else if (_("what_to_do").value == '0' && _("on_what").value == '2')//new programme
	{
		_("cprogrammeIdNew").style.background = 'none';
		_("cprogrammetitleNew").style.background = 'none';
		_("cprogrammedescNew").style.background = 'none';
		_("cprogrammeIdNew_div").style.border = '1px solid #FFFFFF';
				
		if (_("cFacultyIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg15","");
			_("cFacultyIdold").focus();
		}else if (_("cdeptold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg16","");
			_("cdeptold").focus();
		}else if (_("cprogrammetitleNew").value == '')
		{
			there_is_err = 1;
			seterrMsgBox("cprogrammeIdNew_div","cprogrammetitleNew","");
			caution_box('Please select a qualification for the new programme');
		}else if (trim(_("cprogrammedescNew").value) == '')
		{
			there_is_err = 1;
			seterrMsgBox("cprogrammeIdNew_div","cprogrammedescNew","");
			caution_box('Please enter a title for the new programme');
		}else if (!_("cprogrammedescNew").value.match(letters))
		{
			there_is_err = 1;
			seterrMsgBox("cprogrammeIdNew_div","cprogrammedescNew","");
			caution_box('Only letters are allowed for the tile of the new programme');
		}else if (trim(_("BeginLevel").value) == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg24","Begin level required");
			_("BeginLevel").focus();
		}else if (trim(_("EndLevel").value) == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg24","End level required");
			_("EndLevel").focus();
		}else if ((parseInt(_("EndLevel").value) < parseInt(_("BeginLevel").value)) || (parseInt(_("EndLevel").value) == 100 && (parseInt(_("BeginLevel").value) - parseInt(_("EndLevel").value)) < 3))
		{
			there_is_err = 1;
			seterrMsgBox("cprogrammeLevel_div","EndLevel","");
			caution_box('End level must be greater than or equal to beginning level');
		}else if (_("grdtce").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg24","Min. graduation TCE required");
			_("grdtce").focus();
		}else if (_('cprogrammetitleNew').value.substr(0,3) == 'PSZ' && _("grdtce2").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg25","Min. graduation TCE (DE) required");
			_("grdtce2").focus();
		}else if (_("no_semester").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg43","Minimum number of semester required");
			_("no_semester").focus();
		}else if (_("max_crload").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg25","Max. credit load/semester required");
			_("max_crload").focus();
		}

		if (there_is_err == 0 && (_("tgst_tcu").value == '' || _("tbasic_tcu").value == '' || _("tfaculty_tcu").value == '' || _("tcc_tcu").value == '' || _("telect_tcu").value == '' || _("tsiwess_tcu").value == '' || _("tentrep_tcu").value == '') && (_("tcompul_tcu").value == '' || _("treq_tcu").value == '' || _("telec_tcu").value == '' || _("tgs_tcu").value == ''))
		{
			there_is_err = 1;
			caution_box('TCU (course registration guide) requirements for graduation option a or b must be filled completely');
		}
		
		if (_("tgst_tcu").value != 0 || _("tbasic_tcu").value != 0 || _("tfaculty_tcu").value != 0 || _("tcc_tcu").value != 0 || _("telect_tcu").value != 0 || _("tsiwess_tcu").value != 0 || _("tentrep_tcu").value != 0)
		{
			var tcu_total = parseInt(_("tgst_tcu").value) + parseInt(_("tbasic_tcu").value) + parseInt(_("tfaculty_tcu").value) + parseInt(_("tcc_tcu").value) + parseInt(_("telect_tcu").value) + parseInt(_("tsiwess_tcu").value) + parseInt(_("tentrep_tcu").value);
				
			if (_("tgst_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg30","");
				_("tgst_tcu").focus();
				return;
			}else if (_("tbasic_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg31","");
				_("tbasic_tcu").focus();
				return;
			}else if (_("tfaculty_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg32","");
				_("tfaculty_tcu").focus();
				return;
			}else if (_("tcc_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg33","");
				_("tcc_tcu").focus();
				return;
			}else if (_("telect_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg34","");
				_("telect_tcu").focus();
				return;
			}else if (_("tsiwess_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg35","");
				_("tsiwess_tcu").focus();
				return;
			}else if (_("tentrep_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg36","");
				_("tentrep_tcu").focus();
				return;
			}else if (tcu_total < _("grdtce").value)
			{
				there_is_err = 1;
				seterrMsgBox("cprogrammeLevel_div","grdtce","");
				caution_box("Total ("+tcu_total+") in TCU (option a) not consistent with Min. grad. TCE");
				_("grdtce").focus();
				return;
			}
		}
		
		if (_("tcompul_tcu").value != 0 || _("treq_tcu").value != 0 || _("telec_tcu").value != 0 || _("tgs_tcu").value != 0)
		{
			var tcu_total = parseInt(_("tcompul_tcu").value) + parseInt(_("treq_tcu").value) + parseInt(_("telec_tcu").value) + parseInt(_("tgs_tcu").value);
				
			if (_("tcompul_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg37","");
				_("tcompul_tcu").focus();
				return;
			}else if (_("treq_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg38","");
				_("treq_tcu").focus();
				return;
			}else if (_("telec_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg39","");
				_("telec_tcu").focus();
				return;
			}else if (_("tgs_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg40","");
				_("tgs_tcu").focus();
				return;
			}else if (tcu_total < _("grdtce").value)
			{				
				there_is_err = 1;
				seterrMsgBox("cprogrammeLevel_div","grdtce","");
				caution_box("Total ("+tcu_total+") in TCU (option b) not consistent with Min. grad. TCE");
				_("grdtce").focus();
				return;
			}
		}
		
		formdata.append("cFacultyIdold", _("cFacultyIdold").value);
		formdata.append("cdeptold", _("cdeptold").value);
		formdata.append("cprogrammeIdNew", _("cprogrammeIdNew").value);
		formdata.append("cprogrammetitleNew", _("cprogrammetitleNew").value);
		formdata.append("cprogrammedescNew", _("cprogrammedescNew").value);
		formdata.append("BeginLevel", _("BeginLevel").value);
		formdata.append("EndLevel", _("EndLevel").value);
		formdata.append("grdtce", _("grdtce").value);
		formdata.append("grdtce2", _("grdtce2").value);
		formdata.append("max_crload", _("max_crload").value);
		formdata.append("no_semester", _("no_semester").value);
		
		formdata.append("tgst_tcu", _("tgst_tcu").value);
		formdata.append("tbasic_tcu", _("tbasic_tcu").value);
		formdata.append("tfaculty_tcu", _("tfaculty_tcu").value);
		formdata.append("tcc_tcu", _("tcc_tcu").value);
		formdata.append("telect_tcu", _("telect_tcu").value);
		formdata.append("tsiwess_tcu", _("tsiwess_tcu").value);
		formdata.append("tentrep_tcu", _("tentrep_tcu").value);
		
		formdata.append("tcompul_tcu", _("tcompul_tcu").value);
		formdata.append("treq_tcu", _("treq_tcu").value);
		formdata.append("telec_tcu", _("telec_tcu").value);
		formdata.append("tgs_tcu", _("tgs_tcu").value);			
	}else if (_("what_to_do").value == '0' && _("on_what").value == '3')//new course
	{
		_("cCourseIdNew").style.background = '';
		_("cCoursetitleNew").style.background = '';
		_("cCourseIdNew_div").style.border = '1px solid #FFFFFF';
		
		if (_("cFacultyIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg15","");
			_("cFacultyIdold").focus();
		}else if (_("cdeptold").value == '' && _("warned1").value == 0)
		{
			there_is_err = 1;
			_("warned1").value = 1;
			setMsgBox("labell_msg16","Warning! You skipped this");
			_("cdeptold").focus();
		}else if (trim(_("cCourseIdNew").value) == '')
		{
			there_is_err = 1;
			caution_box('Please complete the code for the new course');
			_("cCourseIdNew_b").focus();
		}else if (trim(_("cCourseIdNew").value).length != _("cc_char").value)
		{
			there_is_err = 1;
			caution_box("Exactly "+_("cc_char").value+" characters are required for course code");
			_("cCourseIdNew_b").focus();
		}else if (trim(_("cCoursetitleNew").value) == '')
		{
			there_is_err = 1;
			caution_box("Please enter a title for the new course");
			_("cCoursetitleNew").focus();
		}else if (!_("cCoursetitleNew").value.match(letters))
		{
			there_is_err = 1;
			caution_box("Alphabets only for course title");
			_("cCoursetitleNew").focus();
		}else if (_("iCreditUnit").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg23","Credit unit required");
			_("iCreditUnit").focus();
		}else if (_("courseclass").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg42","");
			_("courseclass").focus();
		}else if (trim(_("cCoursetitleNew").value) == '')
		{
			there_is_err = 1;
			caution_box("Please enter a title for the new course");
			_("cCoursetitleNew").focus();
		}else if (_("tSemester_h2").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg23","Semester required")
		}else if (!(_("cCourseIdNew").value.substr(5,1)%2 == 0 && trim(_("tSemester_h2").value) == 2) && !(_("cCourseIdNew").value.substr(5,1)%2 != 0 && trim(_("tSemester_h2").value) == 1))
		{
			there_is_err = 1;
			caution_box("Inconsistent semester and course code");
			_("cCourseIdNew").focus();
		}else
		{
			formdata.append("cFacultyIdold", _("cFacultyIdold").value);
			formdata.append("cdeptold", _("cdeptold").value);
			
			formdata.append("cCourseIdNew", _("cCourseIdNew").value);
			formdata.append("cCoursetitleNew", _("cCoursetitleNew").value);
			formdata.append("iCreditUnit", _("iCreditUnit").value);
			formdata.append("courseclass", _("courseclass").value);
			formdata.append("tSemester_h2", _("tSemester_h2").value);
		}
	}else if (_("what_to_do").value == '1' && _("on_what").value == '0')//Edit faculty
	{
		if (_("cFacultyIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg15","");
			_("cFacultyIdold").focus();
		}else if (_("cFacultyDescNew").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg19","");
			_("cFacultyDescNew").focus();
		}else if (_("cFacultyIdNew_abrv").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg20","");
			_("cFacultyIdNew_abrv").focus();
		}else if (trim(_("cFacultyIdNew_abrv").value).length != 3)
		{
			there_is_err = 1;
			setMsgBox("labell_msg20","Exactly three characters required");
			_("cFacultyIdNew_abrv").focus();
		}else if (!isNaN(_("cFacultyIdNew_abrv").value.substr(0,1)) || !isNaN(_("cFacultyIdNew_abrv").value.substr(1,1)) || !isNaN(_("cFacultyIdNew_abrv").value.substr(2,1)))
		{
			there_is_err = 1;
			setMsgBox("labell_msg20","Alphabets only");
			_("cFacultyIdNew_abrv").focus();
		}else
		{   
			formdata.append("cFacultyDescNew_h", _("cFacultyDescNew_h").value);
			formdata.append("cFacultyIdold", _("cFacultyIdold").value);
			formdata.append("cFacultyDescNew", _("cFacultyDescNew").value);
			formdata.append("cFacultyIdNew_abrv", _("cFacultyIdNew_abrv").value);
		} 
	}else if (_("what_to_do").value == '1' && _("on_what").value == '1')//Edit dept
	{
		if (_("cFacultyIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg15","");
			_("cFacultyIdold").focus();
		}else if (_("cdeptold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg16","");
			_("cdeptold").focus();
		}else if (trim(_("cDeptDescNew").value) == '' && _('new_cFacultyIdold').value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg21","");
			_("cDeptDescNew").focus();
		}else if (trim(_("cFacultyIdNew_abrv").value) == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg20","");
			_("cFacultyIdNew_abrv").focus();
		}else if (trim(_("cFacultyIdNew_abrv").value).length != 3)
		{
			there_is_err = 1;
			setMsgBox("labell_msg20","Exactly three characters required");
			_("cFacultyIdNew_abrv").focus();
		}else
		{
			formdata.append("new_cFacultyIdold", _("new_cFacultyIdold").value);
			formdata.append("cFacultyIdold", _("cFacultyIdold").value);
			formdata.append("cdeptold", _("cdeptold").value);
			formdata.append("cDeptDescNew", _("cDeptDescNew").value);
			formdata.append("cDeptDescNew_h", _("cDeptDescNew_h").value);
			formdata.append("cFacultyIdNew_abrv", _("cFacultyIdNew_abrv").value);
			formdata.append("new_cFacultyIdold", _("new_cFacultyIdold").value);
		}
	}else if (_("what_to_do").value == '1' && _("on_what").value == '2')//Edit programme
	{
		_("cprogrammeIdNew").style.background = '#FFFFFF';
		_("cprogrammetitleNew").style.background = '#FFFFFF';
		_("cprogrammedescNew").style.background = '#FFFFFF';
		_("cprogrammeIdNew_div").style.border = '1px solid #FFFFFF';
		
		if (_("cFacultyIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg15","");
			_("cFacultyIdold").focus();
		}else if (_("cdeptold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg16","");
			_("cdeptold").focus();
		}else if (_("cprogrammeIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg17","");
			_("cprogrammeIdold").focus();
		}else if (trim(_("cprogrammeIdNew").value) == '')
		{
			there_is_err = 1;
			seterrMsgBox("cprogrammeIdNew_div","cprogrammeIdNew","");
			caution_box('Please enter a code for the programme');
		}else if (trim(_("cprogrammeIdNew").value).length != _("pc_char").value)
		{
			there_is_err = 1;
			seterrMsgBox("cprogrammeIdNew_div","cprogrammeIdNew","");
			caution_box("Please enter a "+_("pc_char").value+" character code for the programme, first three being faculty code");
		}else if (_("cprogrammetitleNew").value == '')
		{
			there_is_err = 1;
			seterrMsgBox("cprogrammeIdNew_div","cprogrammetitleNew","");
			caution_box("Please select a qualification for the new programme");
		}else if (trim(_("cprogrammedescNew").value) == '')
		{
			there_is_err = 1;
			seterrMsgBox("cprogrammeIdNew_div","cprogrammedescNew","");
			caution_box("Please enter a title for the new programme");
		}else if (trim(_("BeginLevel").value) == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg24","Begin level required");
			_("BeginLevel").focus();
		}else if (trim(_("EndLevel").value) == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg24","End level required");
			_("EndLevel").focus();
		}else if (_("EndLevel").value < _("BeginLevel").value)
		{
			there_is_err = 1;
			seterrMsgBox("cprogrammeLevel_div","EndLevel","");
			caution_box("End level must be greater than or equal to beginning level");
		}else if (_("grdtce").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg24","Min. graduation TCE required");
			_("grdtce").focus();
		}else if (_('cprogrammetitleNew').value.substr(0,3) == 'PSZ' && trim(_("grdtce2").value) == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg24","Min. graduation TCE (DE) required");
			_("grdtce2").focus();
		}else if (_("no_semester").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg43","Minimum number of semester required");
			_("no_semester").focus();
		}else if (_("max_crload").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg24","Max. credit load/semester required");
			_("max_crload").focus();
		}else if (_("tgst_tcu").value != 0 || _("tbasic_tcu").value != 0 || _("tfaculty_tcu").value != 0 || _("tcc_tcu").value != 0 || _("telect_tcu").value != 0 || _("tsiwess_tcu").value != 0 || _("tentrep_tcu").value != 0)
		{
			var tcu_total = parseInt(_("tgst_tcu").value) + parseInt(_("tbasic_tcu").value) + parseInt(_("tfaculty_tcu").value) + parseInt(_("tcc_tcu").value) + parseInt(_("telect_tcu").value) + parseInt(_("tsiwess_tcu").value) + parseInt(_("tentrep_tcu").value);
				
			if (_("tgst_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg30","");
				_("tgst_tcu").focus();
				return;
			}else if (_("tbasic_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg31","");
				_("tbasic_tcu").focus();
				return;
			}else if (_("tfaculty_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg32","");
				_("tfaculty_tcu").focus();
				return;
			}else if (_("tcc_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg33","");
				_("tcc_tcu").focus();
				return;
			}else if (_("telect_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg34","");
				_("telect_tcu").focus();
				return;
			}else if (_("tsiwess_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg35","");
				_("tsiwess_tcu").focus();
				return;
			}else if (_("tentrep_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg36","");
				_("tentrep_tcu").focus();
				return;
			}else if (tcu_total < _("grdtce").value)
			{
				there_is_err = 1;
				seterrMsgBox("cprogrammeLevel_div","grdtce","");
				caution_box("Total ("+tcu_total+") in TCU (option a) not consistent with Min. grad. TCE");
				_("grdtce").focus();
				return;
			}
		}
		
		if (_("tcompul_tcu").value != 0 || _("treq_tcu").value != 0 || _("telec_tcu").value != 0 || _("tgs_tcu").value != 0)
		{
			var tcu_total = parseInt(_("tcompul_tcu").value) + parseInt(_("treq_tcu").value) + parseInt(_("telec_tcu").value) + parseInt(_("tgs_tcu").value);
				
			if (_("tcompul_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg37","");
				_("tcompul_tcu").focus();
				return;
			}else if (_("treq_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg38","");
				_("treq_tcu").focus();
				return;
			}else if (_("telec_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg39","");
				_("telec_tcu").focus();
				return;
			}else if (_("tgs_tcu").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg40","");
				_("tgs_tcu").focus();
				return;
			}else if (tcu_total < _("grdtce").value)
			{				
				there_is_err = 1;
				seterrMsgBox("cprogrammeLevel_div","grdtce","");
				caution_box("Total ("+tcu_total+") in TCU (option b) not consistent with Min. grad. TCE");
				_("grdtce").focus();
				return;
			}
		}
		
		if (_("new_cFacultyIdold").value != '' && _("new_cdeptold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg26","");
			_("new_cdeptold").focus();
		}else
		{
			formdata.append("new_cFacultyIdold", _("new_cFacultyIdold").value);
			formdata.append("new_cdeptold", _("new_cdeptold").value);
			
			formdata.append("cFacultyIdold", _("cFacultyIdold").value);
			formdata.append("cdeptold", _("cdeptold").value);
			formdata.append("cprogrammeIdold", _("cprogrammeIdold").value);
			
			formdata.append("cprogrammeIdNew", _("cprogrammeIdNew").value);
			formdata.append("cprogrammetitleNew", _("cprogrammetitleNew").value.substr(3));
			formdata.append("cprogrammedescNew", _("cprogrammedescNew").value);					
			
			formdata.append("cprogrammedescNew_h", _("cprogrammedescNew_h").value);
			formdata.append("BeginLevel", _("BeginLevel").value);
			formdata.append("EndLevel", _("EndLevel").value);
			formdata.append("grdtce", _("grdtce").value);
			formdata.append("grdtce2", _("grdtce2").value);
			formdata.append("max_crload", _("max_crload").value);
			formdata.append("no_semester", _("no_semester").value);

			
			formdata.append("tgst_tcu", _("tgst_tcu").value);
			formdata.append("tbasic_tcu", _("tbasic_tcu").value);
			formdata.append("tfaculty_tcu", _("tfaculty_tcu").value);
			formdata.append("tcc_tcu", _("tcc_tcu").value);
			formdata.append("telect_tcu", _("telect_tcu").value);
			formdata.append("tsiwess_tcu", _("tsiwess_tcu").value);
			formdata.append("tentrep_tcu", _("tentrep_tcu").value);
			  
			formdata.append("tcompul_tcu", _("tcompul_tcu").value);
			formdata.append("treq_tcu", _("treq_tcu").value);
			formdata.append("telec_tcu", _("telec_tcu").value);
			formdata.append("tgs_tcu", _("tgs_tcu").value);
		}
	}else if (_("what_to_do").value == '1' && _("on_what").value == '3')//edit course
	{
		_("cCourseIdNew").style.background = '#FFFFFF';
		_("cCoursetitleNew").style.background = '#FFFFFF';
		_("cCourseIdNew_div").style.border = '1px solid #FFFFFF';
		
		if (_("cFacultyIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg15","");
			_("cFacultyIdold").focus();
		}else if (_("cdeptold").value == '' && _("warned1").value == 0)
		{
			there_is_err = 1;
			_("warned1").value = 1;
			//_("succ_boxu").style.display = 'block';
			//_("succ_boxu").innerHTML = 'Notice! Selected course will be treated as a faculty course';
			_("cdeptold").focus();
		}else if (_("cprogrammeIdold").value == '' && _("warned2").value == 0)
		{
			there_is_err = 1;
			_("warned2").value = 1;
			//_("succ_boxu").style.display = 'block';
			//_("succ_boxu").innerHTML = 'Notice! Selected course will be treated as a departmental course';
			_("cprogrammeIdold").focus();
		}else if (trim(_("ccourseIdold").value) == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg18","");
			_("ccourseIdold").focus();
		}else if (trim(_("cCourseIdNew").value) == '')
		{
			there_is_err = 1;
			//seterrMsgBox("cCourseIdNew_div","cCourseIdNew","Please enter a code for the course");
		}else if (trim(_("cCourseIdNew").value).length != _("cc_char").value)
		{
			there_is_err = 1;
			seterrMsgBox("cCourseIdNew_div","cCourseIdNew","");
			caution_box("The course code must be made up of "+_("cc_char").value+" characters");
		}else if (trim(_("cCoursetitleNew").value) == '')
		{
			there_is_err = 1;
			seterrMsgBox("cCourseIdNew_div","cCoursetitleNew","");
			caution_box("Please enter a title for the course");
		}else if (_("iCreditUnit").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg23","Credit unit required");
			_("iCreditUnit").focus();
		}else if (_("courseclass").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg42","");
				_("courseclass").focus();
			}else if (_("tSemester_h2").value == '')
		{ 
			there_is_err = 1;
			setMsgBox("labell_msg23","Semester required")
			_("tSemester_h2").focus();
		}else if (!(_("cCourseIdNew").value.substr(5,1)%2 == 0 && trim(_("tSemester_h2").value) == 2) && !(_("cCourseIdNew").value.substr(5,1)%2 != 0 && trim(_("tSemester_h2").value) == 1))
		{
			there_is_err = 1;
			seterrMsgBox("cCourseIdNew_div","cCourseIdNew","")
			caution_box("Incnosistent course code and semester");
		}else 
		{
			formdata.append("new_cFacultyIdold", _("new_cFacultyIdold").value);
			formdata.append("new_cdeptold", _("new_cdeptold").value);
			formdata.append("new_cprogrammeIdold", _("new_cprogrammeIdold").value);
			
			formdata.append("cFacultyIdold", _("cFacultyIdold").value);
			formdata.append("cdeptold", _("cdeptold").value);
			formdata.append("cprogrammeIdold", _("cprogrammeIdold").value);
			
			formdata.append("ccourseIdold", _("ccourseIdold").value);
			formdata.append("cCourseIdNew", _("cCourseIdNew").value);
			
			formdata.append("cCoursetitleNew", _("cCoursetitleNew").value);
			formdata.append("cCoursetitleNew_h", _("cCoursetitleNew_h").value);
			
			formdata.append("iCreditUnit", _("iCreditUnit").value);
			formdata.append("courseclass", _("courseclass").value);
			formdata.append("tSemester_h2", _("tSemester_h2").value);
		}
	}else if (_("what_to_do").value == '2' && _("on_what").value == '0')//delete faculty
	{
		if (_("cFacultyIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg15","");
			_("cFacultyIdold").focus();
		}else if(sets.confam.value == '0')
		{
			there_is_err = 1;
			sets.save.value='-1';
			_("inner_del_impli").innerHTML = 'The following under the selected faculty will be deleted along with the faculty:<br /><br /> Courses<br />Admission criteria<br />Programmes and<br />Departments<br /><br />You want to continue?<br /><br />';
			_("del_impli").style.display = 'block';
			_("del_impli").style.zIndex = '3';
			_("smke_screen_2").style.display = 'block';
			_("smke_screen_2").style.zIndex = '2';
		}else
		{
			formdata.append("cFacultyIdold", _("cFacultyIdold").value);
			formdata.append("confam", sets.confam.value);
		}
	}else if (_("what_to_do").value == '2' && _("on_what").value == '1')//delete dept
	{
		if (_("cFacultyIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg15","");
			_("cFacultyIdold").focus();
		}else if (_("cdeptold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg16","");
			_("cdeptold").focus();
		}else if(sets.confam.value == '0')
		{
			there_is_err = 1;
			sets.save.value='-1';
			_("del_impli").style.display = 'block';
			_("del_impli").style.zIndex = '3';
			_("smke_screen_2").style.display = 'block';
			_("smke_screen_2").style.zIndex = '2';
			_("inner_del_impli").innerHTML = 'The following under the selected department will be deleted along with the department:<br /><br /> Courses<br />Admission criteria and <br />Programmes<br /><br />You want to continue?<br /><br />';
		}else
		{
			formdata.append("cFacultyIdold", _("cFacultyIdold").value);
			formdata.append("cdeptold", _("cdeptold").value);
			formdata.append("confam", _("confam").value);
		}
	}else if (_("what_to_do").value == '2' && _("on_what").value == '2')//delete progr
	{
		if (_("cFacultyIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg15","");
			_("cFacultyIdold").focus();
		}else if (_("cdeptold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg16","");
			_("cdeptold").focus();
		}else if (_("cprogrammeIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg17","");
			_("cprogrammeIdold").focus();
		}else if(sets.confam.value == '0')
		{
			there_is_err = 1;
			sets.save.value='-1';
			_("del_impli").style.display = 'block';
			_("del_impli").style.zIndex = '3';
			_("smke_screen_2").style.display = 'block';
			_("smke_screen_2").style.zIndex = '2';
			_("inner_del_impli").innerHTML = 'All admission criteria and courses under the selected programme will be deleted along with the programme.<br /><br /> You want to continue?<br /><br />';
		}else
		{
			formdata.append("cFacultyIdold", _("cFacultyIdold").value);
			formdata.append("cdeptold", _("cdeptold").value);
			formdata.append("cprogrammeIdold", _("cprogrammeIdold").value);
			formdata.append("confam", _("confam").value);
		}
	}else if (_("what_to_do").value == '2' && _("on_what").value == '3')//delete course
	{
		if (_("cFacultyIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg15","");
			_("cFacultyIdold").focus();
		}else if (_("cdeptold").value == '' && _("warned1").value == 0 && _("ccourseIdold").value != '')
		{
			there_is_err = 1;
			_("warned1").value = 1;
			//_("succ_boxu").style.display = 'block';
			//_("succ_boxu").innerHTML = 'Notice! Selected course will be treated as a faculty course';
			_("cdeptold").focus();
		}else if (_("cprogrammeIdold").value == '' && _("warned2").value == 0 && _("ccourseIdold").value != '')
		{
			there_is_err = 1;
			_("warned2").value = 1;
			//_("succ_boxu").style.display = 'block';
			if (_("warned1").value == 0)
			{
				//_("succ_boxu").innerHTML = 'Notice! Selected course will be treated as a departmental course';
			}else
			{
				//_("succ_boxu").innerHTML = 'Notice! Selected course will be treated as a faculty course';}
				_("cprogrammeIdold").focus();
			}
		}else if (_("ccourseIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg18","");
			_("ccourseIdold").focus();
		}else if(sets.confam.value == '0')
		{
			there_is_err = 1;
			sets.save.value='-1';
			_("del_impli").style.display = 'block';
			_("del_impli").style.zIndex = '3';
			_("smke_screen_2").style.display = 'block';
			_("smke_screen_2").style.zIndex = '2';
			_("inner_del_impli").innerHTML = "You are about to remove selected course from selected programme<br /><br />You still want to delete the course?<br /><br />";
		}else
		{
			formdata.append("cFacultyIdold", _("cFacultyIdold").value);
			formdata.append("cdeptold", _("cdeptold").value);
			formdata.append("cprogrammeIdold", _("cprogrammeIdold").value);
			formdata.append("ccourseIdold", _("ccourseIdold").value);
			formdata.append("confam", _("confam").value);
		}
	}else if (_("what_to_do").value == '3' && _("on_what").value == '3')//add course
	{		
		if (_('course_selector').style.display == 'block')
		{
			var allChildNodes = _("reg_courses_ec").getElementsByTagName('input');
		}else
		{
			var allChildNodes = _("reg_courses").getElementsByTagName('input');
		}

		if (sets.save.value == 2 && _('confam').value != '1')
		{
			_("inner_del_impli").innerHTML = 'Are you sure you want to remove courses in the right box from selected programme?<p>';
			_("del_impli").style.zIndex = '4';
			_("del_impli").style.display = 'block';
			_("smke_screen_2").style.zIndex = '3';
			_("smke_screen_2").style.display = 'block';
			return;
		}else if (sets.save.value == 2 && _('confam').value == '1')
		{			
			_("reg_courses_ec").innerHTML = '';
			_("reg_courses").innerHTML = '';			
		}
		
		if (_("cFacultyIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg15","");
			_("cFacultyIdold").focus();
		}else if (_("cdeptold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg16","");
			_("cdeptold").focus();
		}else if (_("cprogrammeIdold").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg17","");
			_("cprogrammeIdold").focus();
		}else if (_("courseLevel").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg28","Level required");
			_("courseLevel").focus();
			_("level_semester_div").style.border = '1px solid #BDBB6A';
			_("courseLevel").style.background = '#F5F4D6';
		}else if (_("coursesemester_h2").value == '')
		{
			there_is_err = 1;
			setMsgBox("labell_msg28","Semester required");
			_("coursesemester_h2").focus();
			_("level_semester_div").style.border = '1px solid #BDBB6A';
		}else if (allChildNodes.length == 0 && sets.save.value != 2)
		{
			there_is_err = 1;
			caution_box('Please click on course(s) to be selected in the box on the left');
		}else
		{
			formdata.append("cFacultyIdold", _("cFacultyIdold").value);
			formdata.append("cdeptold", _("cdeptold").value);
			formdata.append("cprogrammeIdold", _("cprogrammeIdold").value);
			
			formdata.append("selected_curriculum", _("select_curriculum_h2").value);
			
			formdata.append("coursesemester", _("coursesemester_h2").value);
			formdata.append("courseLevel", _("courseLevel").value);
			formdata.append("numOfiputTag",_("numOfiputTag").value);
			
			for (var i = 0; i <= _("numOfiputTag").value; i++)
			{
				if (_('course_selector').style.display == 'block')
				{
					var selectedCourse = 'regCourses'+i+'_ec';
					if (_(selectedCourse))
					{
						formdata.append(selectedCourse, _(selectedCourse).value);
					}
				}else
				{
					var selectedCourse = 'regCourses'+i;				
					if (_(selectedCourse))
					{
						formdata.append(selectedCourse, _(selectedCourse).value);
					}
				}
			}
		}
	}else if (_("what_to_do").value == '4')//view
	{
		if (_("on_what").value == '3')//view course
		{
			if (_("cFacultyIdold").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg15","");
				_("cFacultyIdold").focus();
				return;
			}else if (_("cdeptold").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg16","");
				_("cdeptold").focus();
				return;
			}else if (_("cprogrammeIdold").value == '')
			{
				there_is_err = 1;
				setMsgBox("labell_msg17","");
				_("cprogrammeIdold").focus();
				return;
			}
		}
		prns_form.submit();
		return;
	}
	
	if(there_is_err == 0)
	{
		formdata.append("sm", sets.sm.value);
		formdata.append("save", sets.save.value);
		formdata.append("currency", sets.currency.value);
		formdata.append("mm", sets.mm.value);
		formdata.append("user_cat", sets.user_cat.value);
		formdata.append("what_to_do", _("what_to_do").value);
		formdata.append("on_what", _("on_what").value);
		formdata.append("vApplicationNo", sets.vApplicationNo.value);
		
		opr_prep(ajax = new XMLHttpRequest(),formdata);
	}
}



function opr_prep(ajax,formdata)
{
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	
	ajax.open("POST", "opr_setup_facult.php");
	ajax.send(formdata);
}



function completeHandler(event)
{
	_("returnedStr").value = event.target.responseText;
	var returnedStr = event.target.responseText;

	on_error('0');
	on_abort('0');
	in_progress('0');
	
	if (_("frm_upd").value == 'form_prog_code')
	{
		var str = _('cprogrammetitleNew').options[_('cprogrammetitleNew').selectedIndex].text.substr(0,1);
		var str2 = _('cprogrammetitleNew').options[_('cprogrammetitleNew').selectedIndex].text;
		var str3 = '';

		if (str == 'C')
		{
			str3 = '0';
		}else if (str == 'N' || (str == 'D' && str2.substr(0,2) != 'Dr'))
		{
			str3 = '1';
		}else if (str == 'B' || str == 'L')
		{
			str3 = '2';
		}else if (str2 == 'PGD.,')
		{
			str3 = '3';
		}else if (str == 'M' && str2.indexOf("Phil") == -1)
		{
			str3 = '4';
		}else if (str2.indexOf("Phil") != -1)
		{
			str3 = '5';
		}else if (str2 == 'Ph.D.,')
		{
			str3 = '6';
		}

		_("cprogrammeIdNew").value = _('cFacultyIdold').value.substr(0,3)+str3+returnedStr;
		
		_("frm_upd").value = '';
		return;
	}
	
	if (_("frm_upd").value == 'qual')
	{
		var educat = returnedStr.substr(810,10).trim();

		_("cprogrammetitleNew").value = educat+returnedStr.substr(0,100).trim();
		_("BeginLevel").value = returnedStr.substr(100,100).trim();
		_("EndLevel").value = returnedStr.substr(200,100).trim();
		
		_("grdtce").value = returnedStr.substr(300,100).trim();
		_("grdtce2").value = returnedStr.substr(400,100).trim();
		_("max_crload").value = returnedStr.substr(500,100).trim();
		
		var study_modes = returnedStr.substr(600,100).trim();
				
		_("tgst_tcu").value = returnedStr.substr(700,10).trim();
		_("tbasic_tcu").value = returnedStr.substr(710,10).trim();
		_("tfaculty_tcu").value = returnedStr.substr(720,10).trim();
		_("tcc_tcu").value = returnedStr.substr(730,10).trim();
		_("telect_tcu").value = returnedStr.substr(740,10).trim();
		_("tsiwess_tcu").value = returnedStr.substr(750,10).trim();
		_("tentrep_tcu").value = returnedStr.substr(760,10).trim();
				
		_("tcompul_tcu").value = returnedStr.substr(770,10).trim();
		_("treq_tcu").value = returnedStr.substr(780,10).trim();
		_("telec_tcu").value = returnedStr.substr(790,10).trim();
		_("tgs_tcu").value = returnedStr.substr(800,10).trim();
		
		_("no_semester").value = returnedStr.substr(820,100).trim();
	}
	
	if (isNaN(returnedStr) && returnedStr != '')
	{		
		if (returnedStr.indexOf("successfully") != -1)
		{
			success_box(returnedStr);

			if (_('what_to_do').value == 0 && _('on_what').value == 0)
			{
				_('cFacultyIdold').options[_('cFacultyIdold').options.length] = new Option(_('cFacultyIdNew_abrv').value.toUpperCase()+' '+_('cFacultyDescNew').value, _('cFacultyIdNew_abrv').value);
			}else if (_('what_to_do_frn').value == 2 && _('on_what_frn').value == 0)
			{ 
				_('cFacultyIdold').remove(_('cFacultyIdold').selectedIndex);
			}
		}else if (returnedStr.indexOf("not") != -1 || returnedStr.indexOf("invalid") != -1 || returnedStr.indexOf("already") != -1 || returnedStr.indexOf("aborted") != -1)
		{
			caution_box(returnedStr);
		}
	}

	if (returnedStr != ''){_("frm_upd").value = 0;}
	sets.save.value = -1;
}





function updateScrn()
{
	hideAllMsg();
	
	if (_("frm_upd").value != '0')
	{
		if ((_("what_to_do").value == '0' && (_("on_what").value == '2' || _("on_what").value == '3')) ||
		(_("what_to_do").value == '1' && (_("on_what").value == '1' || _("on_what").value == '2' || _("on_what").value == '3')) ||
		_("what_to_do").value == '2' || _("what_to_do").value == '3')
		{
			var formdata = new FormData();
			formdata.append("frm_upd", _("frm_upd").value);
						
			//ensure that only visible sub-ordinate combos are updated
			if ((_("frm_upd").value != 'p' || (_("frm_upd").value == 'p' && !(_("what_to_do").value == '1' && _("on_what").value == '2') && !(_("what_to_do").value == '0' && _("on_what").value == '3') && !(_("what_to_do").value == '3' && _("on_what").value == '3'))) &&
			(_("frm_upd").value != 'd' || (_("frm_upd").value == 'd' && !(_("what_to_do").value == '0' && _("on_what").value == '2') && !(_("what_to_do").value == '1' && _("on_what").value == '1'))))
			{
				opr_prep(ajax = new XMLHttpRequest(),formdata);
			}
		}
	}
	
	if (_("what_to_do").value == '1' && _("on_what").value == '0')//edit faculty
	{
		_("cFacultyDescNew").value = _("cFacultyIdold").options[_("cFacultyIdold").selectedIndex].text.substr(4,_("cFacultyIdold").options[_("cFacultyIdold").selectedIndex].text.length-1);
	}else if (_("what_to_do").value == '1' && _("on_what").value == '1')//edit dept
	{
		_("cDeptDescNew").value = _("cdeptold").options[_("cdeptold").selectedIndex].text.substr(4,_("cdeptold").options[_("cdeptold").selectedIndex].text.length-1);
	}else if (_("what_to_do").value == '1' && _("on_what").value == '2' && _("frm_upd").value != 'n_f' && _("frm_upd").value != 'n_d')//edit prog
	{
		_("cprogrammeIdNew").value = _("cprogrammeIdold").options[_("cprogrammeIdold").selectedIndex].value;
		_("cprogrammetitleNew").value = _("cprogrammeIdold").options[_("cprogrammeIdold").selectedIndex].text;
	
		var chrIndex = 0;
		
		if (_("cprogrammeIdold").options[_("cprogrammeIdold").selectedIndex].text.indexOf('.,') != -1)
		{
			chrIndex = _("cprogrammeIdold").options[_("cprogrammeIdold").selectedIndex].text.indexOf('.,') + 3;
		}else if (_("cprogrammeIdold").options[_("cprogrammeIdold").selectedIndex].text.indexOf('.)') != -1)
		{
			chrIndex = _("cprogrammeIdold").options[_("cprogrammeIdold").selectedIndex].text.indexOf('.)') + 3;
		}
		
		_("cprogrammedescNew_h").value = _("cprogrammeIdold").options[_("cprogrammeIdold").selectedIndex].text.substr(chrIndex,_("cprogrammeIdold").options[_("cprogrammeIdold").selectedIndex].text.length);
		_("cprogrammedescNew").value = _("cprogrammeIdold").options[_("cprogrammeIdold").selectedIndex].text.substr(chrIndex,_("cprogrammeIdold").options[_("cprogrammeIdold").selectedIndex].text.length);
	}else if (_("what_to_do").value == '1' && _("on_what").value == '3')//edit course
	{
		if (_("frm_upd").value == 'f')
		{
			_("cprogrammeIdold").options.length = 0;
			_("cprogrammeIdold").options[_("cprogrammeIdold").options.length] = new Option('', '');
		}
		
		_("cCourseIdNew").value = _("ccourseIdold").options[_("ccourseIdold").selectedIndex].value;
		
		_("cCoursetitleNew").value = _("ccourseIdold").options[_("ccourseIdold").selectedIndex].text.substr(13);
		
		_("cCoursetitleNew_h").value = _("ccourseIdold").options[_("ccourseIdold").selectedIndex].text.substr(13);
		_("iCreditUnit").value = _("ccourseIdold").options[_("ccourseIdold").selectedIndex].text.substr(2,1);
		
		if (_("frm_upd").value == 'cc')
		{
			_("tSemester_h2").value = _("ccourseIdold").options[_("ccourseIdold").selectedIndex].text.charAt(0);
		}
	}else if (_("what_to_do").value == '2' && _("on_what").value == '3' && _("frm_upd").value == 'f')//delete course
	{
			
		_("cprogrammeIdold").options.length = 0;
		_("cprogrammeIdold").options[_("cprogrammeIdold").options.length] = new Option('', '');
		
		_("ccourseIdold").options.length = 0;
		_("ccourseIdold").options[_("ccourseIdold").options.length] = new Option('', '');
	}else if (_("what_to_do").value == '3' && _("on_what").value == '3')//
	{
		if (_("frm_upd").value == 'f')
		{
			_("cprogrammeIdold").options.length = 0;
			_("cprogrammeIdold").options[_("cprogrammeIdold").options.length] = new Option('', '');
			_("courseLevel").value = '';
		}
			
		_("coursesemester12").checked = false;
		_("coursesemester22").checked = false;
		_("coursesemester23").checked = false;
		_("coursesemester_h2").value = '';
		
		_("reg_courses").innerHTML = '';
	}
	
	_("del_impli").style.display = 'none';
	_("smke_screen_2").style.display = 'none';
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
	_(coverDiv).style.border = '1px solid #cc5200';
	_(affected).style.background = '#fff0e6';
	_(affected).focus();
	
}



function progressHandler(event)
{
	if (_("frm_upd").value == 'form_prog_code' || _("frm_upd").value == 'qual')
	{
		in_progress('1');
	}else if (sets.save.value == '1' || _("frm_upd").value == '' || (_("frm_upd").value == 'f' && _("what_to_do").value == '0' && (_("on_what").value == '1' || _("on_what").value == '2' || _("on_what").value == '3')) || (_("what_to_do").value == '3' && _("on_what").value == '3'))
	{
		if (!(_("what_to_do").value == '3' && _("on_what").value == '3'))
		{
			in_progress('1');
		}else
		{
			in_progress('1');
		}
	}
}



function errorHandler(event)
{
	if (_("frm_upd").value == 'form_prog_code')
	{
		on_error('1');
	}else if (!(_("what_to_do").value == '3' && _("on_what").value == '3'))
	{
		on_error('1');
	}else
	{
		on_error('1');
	}
}


function abortHandler(event)
{
	if (!(_("what_to_do").value == '3' && _("on_what").value == '3'))
	{
		on_abort('1');
	}
}




function show_proper(what_to_do,on_what)
{
	hideAllMsg();
	
	var allChildNodes = _("inner_structure").getElementsByTagName('input');
	for (i = 0; i < allChildNodes.length; i++)
	{
		if((allChildNodes[i].type == 'checkbox' || allChildNodes[i].type == 'radio') && allChildNodes[i].name != 'select_curri_gen')
		{
			allChildNodes[i].checked = false;
		}
	}
	
	_('confam').value = '0';
	
	_("del_impli").style.display = 'none';
	_("smke_screen_2").style.display = 'none';	
	

	if (what_to_do >= 0 && on_what >= 0)
	{
		_("inner_structure").style.display = 'block';
		_("sub_box").style.display = 'block';
		
		if (what_to_do == '3' && on_what == '3')
		{
			
		}else
		{
			if (_("clear_all"))
			{
				_("clear_all").style.display = 'none';
			}
			
			if (_("print_all"))
			{
				_("print_all").style.display = 'none';
			}
		}
	}
	

	_('what_to_do_frn').value = what_to_do;
	_('on_what_frn').value = on_what;
	
	var ulChildNodes = _("inner_structure").getElementsByClassName("setup_fac_dummy_lass");
	for (j = 0; j <= ulChildNodes.length-1; j++)
	{
		ulChildNodes[j].style.display = 'none';
	}
	
	if (what_to_do == '0' && on_what == '0')//new faculty
	{
		_("cFacultyIdNew_div").style.display = 'block';
		_("cFacultyIdNew_abrv_div").style.display = 'block';
	}else if (what_to_do == '0' && on_what == '1')//new dept
	{
		_("cFacultyIdold_div").style.display = 'block';
		_("cDeptDescNew_div").style.display = 'block';
		_("cFacultyIdNew_abrv_div").style.display = 'block';
	}else if (what_to_do == '0' && on_what == '2')//new programme
	{		
		if (_("cprogrammeLevel_div").style.display == 'block')
        {
            _("cdeptold").options.length = 0;
            _("cdeptold").options[_("cdeptold").options.length] = new Option('', '');
        }
		
		_("cprogrammeLevel_div").style.display = 'block';
		_("cprogrammeLevel1_div").style.display = 'block';
		_("no_semester_div").style.display = 'block';
		_("cprogrammeIdNew_div").style.display = 'block';
		
		_("tcu_counts_div").style.display = 'block';

		_("cFacultyIdold_div").style.display = 'block';
		_("cdeptold_div").style.display = 'block';
	}else if (what_to_do == '0' && on_what == '3')//new course
	{
		if(_("cdeptold").style.display == 'block')
        {
            _("cdeptold").options.length = 0;
            _("cdeptold").options[_("cdeptold").options.length] = new Option('', '');
            
            _("cprogrammeIdold").options.length = 0;
            _("cprogrammeIdold").options[_("cprogrammeIdold").options.length] = new Option('', '');
        }
        
		_("cCourseIdNew").value = '';
		_("cCoursetitleNew").value = '';
		_("iCreditUnit").value = '';
		_("courseclass").value = '';
		
		_("tSemester_h2").value = '';
					
		_("cFacultyIdold_div").style.display = 'block';
		_("cdeptold_div").style.display = 'block';
		_("cCourseIdNew_div").style.display = 'block';
		_("cCourseIdNew_div2").style.display = 'block';
		_("courseclass_div").style.display = 'block';
	}else if (what_to_do == '1' && on_what == '0')//Edit faculty
	{
		_("cFacultyIdold_div").style.display = 'block';
		_("cFacultyIdNew_div").style.display = 'block';
		_("cFacultyIdNew_abrv_div").style.display = 'block';
	}else if (what_to_do == '1' && on_what == '1')//Edit dept
	{
		if (_("cdeptold").style.display == 'block')
        {
            _("cdeptold").options.length = 0;
            _("deptold").options[_("cdeptold").options.length] = new Option('', '');
        }
		
		_("cFacultyIdold_div").style.display = 'block';
		_("cdeptold_div").style.display = 'block';
		_("cDeptDescNew_div").style.display = 'block';
		_("cFacultyIdNew_abrv_div").style.display = 'block';
		_("new_cFacultyIdold_div").style.display = 'block';
	}else if (what_to_do == '1' && on_what == '2')//Edit programme
	{		
		if (_("new_cdeptold").style.display == 'block')
        {
            _("new_cdeptold").options.length = 0;
            _("new_cdeptold").options[_("cdeptold").options.length] = new Option('', '');
            
            _("cdeptold").options.length = 0;
            _("cdeptold").options[_("cdeptold").options.length] = new Option('', '');
            
            _("cprogrammeIdold").options.length = 0;
            _("cprogrammeIdold").options[_("cprogrammeIdold").options.length] = new Option('', '');
        }
		
		_("cprogrammeIdNew").value = ''; _("cprogrammetitleNew").value = ''; _("cprogrammedescNew").value = '';
		_("BeginLevel").value = ''; _("EndLevel").value = '';
		
		_("tcu_counts_div").style.display = 'block';
		
		_("cFacultyIdold_div").style.display = 'block';
		_("cdeptold_div").style.display = 'block';
		_("cprogrammeIdold_div").style.display = 'block';
		_("cprogrammeIdNew_div").style.display = 'block';
		_("cprogrammeLevel_div").style.display = 'block';
		_("cprogrammeLevel1_div").style.display = 'block';
		_("no_semester_div").style.display = 'block';
		_("new_cFacultyIdold_div").style.display = 'block';
		_("new_cdeptold_div").style.display = 'block';
	}else if (what_to_do == '1' && on_what == '3')//Edit course
	{
		if (_("new_cdeptold").style.display == 'block')
        {
            _("new_cdeptold").options.length = 0;
            _("new_cdeptold").options[_("new_cdeptold").options.length] = new Option('', '');
		
            _("cdeptold").options.length = 0;
            _("cdeptold").options[_("cdeptold").options.length] = new Option('', '');
            
            _("cprogrammeIdold").options.length = 0;
            _("cprogrammeIdold").options[_("cprogrammeIdold").options.length] = new Option('', '');
        }
        		
		_("new_cprogrammeIdold").options.length = 0;
		_("new_cprogrammeIdold").options[_("new_cprogrammeIdold").options.length] = new Option('', '');
		
		
		_("ccourseIdold").options.length = 0;
		_("ccourseIdold").options[_("ccourseIdold").options.length] = new Option('', '');
		
		_("cFacultyIdold_div").style.display = 'block';
		_("cdeptold_div").style.display = 'block';
		_("cprogrammeIdold_div").style.display = 'block';
		_("ccourseIdold_div").style.display = 'block';

		_("curriculum_div").style.display = 'block';
		
		_("cCourseIdNew_div").style.display = 'block';
		_("cCourseIdNew_div2").style.display = 'block';
		_("courseclass_div").style.display = 'block';
		_("new_cFacultyIdold_div").style.display = 'block';
		_("new_cdeptold_div").style.display = 'block';
		_("new_cprogrammeIdold_div").style.display = 'block';
	}else if (what_to_do == '2' && on_what == '0')//delete faculty
	{
		_("cFacultyIdold_div").style.display = 'block';
	}else if (what_to_do == '2' && on_what == '1')//delete dept
	{
		if (_("cprogrammeIdold_div").style.display == 'block')
        {
            _("cdeptold").options.length = 0;
            _("cdeptold").options[_("cdeptold").options.length] = new Option('', '');
        }
        
		_("cFacultyIdold_div").style.display = 'block';
		_("cdeptold_div").style.display = 'block';
	}else if (what_to_do == '2' && on_what == '2')//delete progr
	{
		if (_("cdeptold").style.display == 'block')
        {
            _("cdeptold").options.length = 0;
            _("cdeptold").options[_("cdeptold").options.length] = new Option('', '');
            _("cprogrammeIdold").options.length = 0;
            _("cprogrammeIdold").options[_("cprogrammeIdold").options.length] = new Option('', '');
        }
        
		_("cFacultyIdold_div").style.display = 'block';
		_("cdeptold_div").style.display = 'block';
		_("cprogrammeIdold_div").style.display = 'block';
	}else if (what_to_do == '2' && on_what == '3')//delete course
	{
        if (_("cprogrammeIdold_div").style.display == 'block')
        {
            _("cdeptold").options.length = 0;
            _("cdeptold").options[_("cdeptold").options.length] = new Option('', '');
            _("cprogrammeIdold").options.length = 0;
            _("cprogrammeIdold").options[_("cprogrammeIdold").options.length] = new Option('', '');
            _("ccourseIdold").options.length = 0;
            _("ccourseIdold").options[_("ccourseIdold").options.length] = new Option('', '');
        }
    
		_("cFacultyIdold_div").style.display = 'block';
		_("cdeptold_div").style.display = 'block';
		_("cprogrammeIdold_div").style.display = 'block';
		_("ccourseIdold_div").style.display = 'block';
		_("curriculum_div").style.display = 'block';
	}else if (what_to_do == '3' && on_what == '3')//add course
	{
		if (_("cdeptold").style.display == 'block')
        {
            _("cdeptold").options.length = 0;
            _("cdeptold").options[_("cdeptold").options.length] = new Option('', '');
			
            _("cprogrammeIdold").options.length = 0;
            _("cprogrammeIdold").options[_("cprogrammeIdold").options.length] = new Option('', '');
        }

        _("cFacultyIdold_div").style.display = 'block';
        _("cdeptold_div").style.display = 'block';
        _("cprogrammeIdold_div").style.display = 'block';
        _("ccourseIdold_div1").style.display = 'block';

        _("level_semester_div").style.display = 'block';
	}else if (what_to_do == '3' && on_what != '3' && on_what != '')//add course
	{
		_("del_impli").style.display = 'block';
		_("del_impli").innerHTML = 'The \'Add/Remove\' option is only applicable to courses';
		_("sub_box").style.display = 'none';
	}else if (what_to_do == '4' && on_what == '0')//view faculty
	{
		_("cFacultyIdold_div").style.display = 'block';
		_("sub_box").style.display = 'block';
	}else if (what_to_do == '4' && on_what == '1')//view dept
	{
		_("cFacultyIdold_div").style.display = 'block';
		_("cdeptold_div").style.display = 'block';
		_("sub_box").style.display = 'block';
	}else if (what_to_do == '4' && on_what == '2')//view prog
	{
		_("cFacultyIdold_div").style.display = 'block';
		_("cdeptold_div").style.display = 'block';
		_("cprogrammeIdold_div").style.display = 'block';
		_("sub_box").style.display = 'block';
	}else if (what_to_do == '4' && on_what == '3')//view courses
	{
		_("cFacultyIdold_div").style.display = 'block';
		_("cdeptold_div").style.display = 'block';
		_("cprogrammeIdold_div").style.display = 'block';
		_("ccourseIdold_div").style.display = 'block';
		_("curriculum_div").style.display = 'block';
		_("sub_box").style.display = 'block';
	}else if (what_to_do == '' || on_what == '')
	{
		_("inner_structure").style.display = 'none';
		_("sub_box").style.display = 'none';
	}else
	{
		if (what_to_do == '5' && on_what != '3')//Assign course
		{
			_("sub_box").style.display = 'none';
			return;
		}
		
		var formdata = new FormData();
		formdata.append("frm_upd", _("frm_upd").value);
		opr_prep(ajax = new XMLHttpRequest(),formdata);
	}
	
	if (on_what == '2')// prog
	{
		update_cat_country('cFacultyIdold', 'cdeptId_readup', 'cdeptold', 'cprogrammeIdold');
	}
}



function form_code(val)
{
	var str = ''; Index_spacefound = 0; spacefound = 0; val1 = trim(val);
	
	if (val1.length > 0)
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



function hideAllMsg()
{
	var ulChildNodes = _("rtlft_std").getElementsByClassName("labell_msg");
	for (j = 0; j <= ulChildNodes.length-1; j++)
	{
		ulChildNodes[j].style.display = 'none';
	}
		
	_("level_semester_div").style.border = '1px solid #FFFFFF';
	_("courseLevel").style.background = '#FFFFFF';
	
	_("del_impli").style.display = 'none';
	_("smke_screen_2").style.display = 'none';
	
	if (_("cprogrammeLevel_div"))
	{
		_("cprogrammeLevel_div").style.border = '1px solid #FFFFFF';
		_("cprogrammeLevel1_div").style.border = '1px solid #FFFFFF';
	}
}



/*function selectCourse(courseCode, tSemester, iCreditUnit, courseTitle)
{
	if (courseCode.substr(3,1) != 9)
	{
		if (courseCode.substr(3,1)+'00' != _("courseLevel").value && _("courseLevel").value >= 100)
		{alert(courseCode.substr(3,1))
			return;
		}else if (_("coursesemester_h2").value == '' || ((courseCode.substr(5,1))%2 == 0 && _("coursesemester_h2").value == 1) || ((courseCode != 'CHM499' && (courseCode.substr(5,1))%2 > 0 && _("coursesemester_h2").value == 2)))
		{        
			return;
		}	
	}

	var retActive = '0';
	if (_('course_selector').style.display == 'block')
	{
		var cusStatus = _('course_mandate_h').value;
		var retActive = _('course_effect_h').value;
	}else if (event.ctrlKey)
	{
		var cusStatus = 'C';
	}else if (event.altKey)
	{
		var cusStatus = 'R';
	}else
	{
		var cusStatus = 'E';
	}
	    
	var allChildNodes = _("reg_courses").getElementsByTagName('input');
	for (i = 0; i < allChildNodes.length; i++)
	{
		if (allChildNodes[i].value.substr(1,6) == courseCode){return;}
	}

	if (_("numOfiputTag").value == ''){_("numOfiputTag").value = 0;}
	
	_("numOfiputTag").value = parseInt(_("numOfiputTag").value) + 1;
	var numOfiputTags = _("numOfiputTag").value;
	
	
	var li = document.createElement('li');
	li.setAttribute('onclick', 'this.parentNode.removeChild(this);');
	li.style.background = '#E2D8D6';
	li.style.height = '30px';
	
	var input = document.createElement('input');
	input.type = 'hidden';
	input.name = 'regCourses'+numOfiputTags;
	input.id = 'regCourses'+numOfiputTags;
	input.value = cusStatus+retActive+courseCode;
	li.appendChild(input);
	
	var div1 = document.createElement('div');
	div1.setAttribute('class','chkboxNoDiv');
	div1.innerHTML = parseInt(numOfiputTags)+1;
	li.appendChild(div1);
	
    var div2 = document.createElement('div');
    div2.setAttribute('class','ccodeDiv');
    div2.innerHTML = courseCode;
    li.appendChild(div2);

    var div3 = document.createElement('div');
    div3.setAttribute('class','singlecharDiv');
    div3.innerHTML = cusStatus;
    li.appendChild(div3);

    var div4 = document.createElement('div');
    div4.setAttribute('class','singlecharDiv');
    div4.innerHTML = tSemester;
    li.appendChild(div4);


    var div6 = document.createElement('div');
    div6.setAttribute('class','ctitle ctitle_right');
    div6.innerHTML = courseTitle;
    li.appendChild(div6);
	
	_("reg_courses").appendChild(li);



	var allChildNodes = _("reg_courses_ec").getElementsByTagName('input');
	for (i = 0; i < allChildNodes.length; i++)
	{
		if (allChildNodes[i].value.substr(1,6) == courseCode){return;}
	}

	if (_("numOfiputTag").value == ''){_("numOfiputTag").value = 0;}
	
	var numOfiputTags = _("numOfiputTag").value;
	
	
	var li = document.createElement('li');
	li.setAttribute('onclick', 'this.parentNode.removeChild(this);');
	li.style.background = '#E2D8D6';
	
	var input = document.createElement('input');
	input.type = 'hidden';
	input.name = 'regCourses'+numOfiputTags+'_ec';
	input.id = 'regCourses'+numOfiputTags+'_ec';
	input.value = cusStatus+retActive+courseCode;
	li.appendChild(input);
	
	var div1 = document.createElement('div');
	div1.setAttribute('class','chkboxNoDiv');
	div1.innerHTML = parseInt(numOfiputTags)+1;
	li.appendChild(div1);
	
    var div2 = document.createElement('div');
    div2.setAttribute('class','ccodeDiv');
    div2.innerHTML = courseCode;
    li.appendChild(div2);

    var div3 = document.createElement('div');
    div3.setAttribute('class','singlecharDiv');
    div3.innerHTML = cusStatus;
    li.appendChild(div3);

    var div4 = document.createElement('div');
    div4.setAttribute('class','singlecharDiv');
    div4.innerHTML = tSemester;
    li.appendChild(div4);


    var div6 = document.createElement('div');
    div6.setAttribute('class','ctitle ctitle_right');
    div6.innerHTML = courseTitle;
    li.appendChild(div6);
	_("reg_courses_ec").appendChild(li);
	
	_("sub_box").style.display = 'block';
}*/


function form_prog_code()
{
	if (_("cFacultyIdold").value == "")
	{
		seterrMsgBox("cFacultyIdold_div","cFacultyIdold","");
		caution_box('Please select host faculty for the new programme');
		return false;
	}

	if (_("cdeptold").value == "")
	{
		seterrMsgBox("cdeptold_div","cdeptold","");
		caution_box('Please select host department for the new programme');
		return false;
	}
	
	var formdata = new FormData();	
	
	_('frm_upd').value = 'form_prog_code'; 

	formdata.append("sm", sets.sm.value);
	formdata.append("mm", sets.mm.value);
	formdata.append("currency", sets.currency.value);
	formdata.append("user_cat", sets.user_cat.value);
	formdata.append("vApplicationNo", sets.vApplicationNo.value);
	formdata.append("frm_upd", _('frm_upd').value);
	formdata.append("cEduCtgId", sets.cprogrammetitleNew.value.substr(0,3));
	formdata.append("cprogrammetitleNew", sets.cprogrammetitleNew.value.substr(3,3));
	formdata.append("cFacultyIdold", _("cFacultyIdold").value.substr(0,3));
	
	opr_prep(ajax = new XMLHttpRequest(),formdata);	
}


function tab_modify(tab_no)
{
	
	//return false;
	
	for (i = 0; i <= 20; i++) 
	{
		var tab_Id = 'tabss' + i;
		var tab_Id_0 = 'tabss' + i + '_0';
		if (_(tab_Id))
		{
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
	 
	//_("level3_opts").style.display='none';
}

function tab_modify_1(tab_no)
{
	for (i = 6; i <= 9; i++) 
	{
		var tab_Id = 'tabs' + i;
		var tab_Id_0 = 'tabs' + i + '_0';
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