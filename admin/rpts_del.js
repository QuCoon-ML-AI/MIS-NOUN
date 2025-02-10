// JavaScript Documentvar 
function set_other_chkboxes(obj1,obj2,status,range)
{
	if (range.indexOf("-") != -1)
	{
			for (t = parseInt(range.substr(0,range.indexOf("-"))); t <= parseInt(range.substr(range.indexOf("-")+1)); t++)
			{
				obj = obj2 + t;
				if(range == '1-11' || range == '1-14' || range == '1-17' || range == '13-26' || range == '16-22' || range == '16-26' || range == '19-26' || range == '20-26')
				{
					if (obj1.checked)
					{
						if (status == '0')
						{
							_(obj).checked = false;
							_(obj).disabled = true;
						}else if (status == '1')
						{
							if (range == '1-11' || range == '13-26' || range == '1-14' || range == '16-26' || range == '1-17' || range == '19-26')
							{
								if(t == 9 || t == 10  || t == 11 || t == 19){continue;}
								_(obj).disabled = false
							}else if (!(range == '16-22' && obj2 == 'srt'))
							{
								_(obj).disabled = false
							}
						}else
						{
							if (range == '20-26' && !_("col11").checked && !_("col14").checked && !_("col18").checked)
							{
								_(obj).disabled = false
							}
						}
					}else
					{
						if (((range == '1-11' || range == '1-14' || range == '1-17') && (t == 9 || t == 10 || t == 11)) || ((range == '1-8' || range == '10-22' || range == '13-26' || range == '16-26' || range == '19-26') && t == 19))
						{
							continue;
						}
						
						if (t >= 20)
						{
							if (!_("qry_type1").checked)
							{
								_(obj).disabled = false;
							}
						}else if ((range == '2-5' || range == '7-12') && _(obj).type == 'select-one')
						{
							_(obj).disabled = true;
						}else 
						{
							_(obj).disabled = false;
						}
					}
				}else if(range == '10-11')
				{
					if (obj1.checked)
					{
						_(obj).disabled = false
					}else
					{
						_(obj).checked = false; 
						_(obj).disabled = true
					}
				}
			}
	}else if (range.indexOf(",") != -1)
	{
		
	}else
	{
		obj = obj2 + range;
		if (status != '')
		{
			if (status == '0')
			{
				_(obj).checked = false;
				_(obj).disabled = false;
			}else
			{
				_(obj).disabled = true;
			}
		}else if (obj1.checked)
		{
			_(obj).disabled = false
		}else
		{
			if (_(obj).type == 'checkbox')
			{
				_(obj).checked = false; 
			}
			_(obj).disabled = true
		}
	}
}


function compose_sel(chkobj,wch_boxes)
{
	with(rpts1_loc)
	{
		if (chkobj.checked)
		{
			
			if (hdqry_type.value == 1 && (chkobj.value == 'l' || chkobj.value == 'o' || chkobj.value == 'r'))
			{
				selection.value = chkobj.value;
				
				if (wch_boxes == 'col')
				{
					selectionst.value = '';
					var ulChildNodes = _('ans3').getElementsByTagName("input");
					for (j = 0; j <= ulChildNodes.length-1; j++)
					{
						if (ulChildNodes[j].type == 'checkbox')
						{
							ulChildNodes[j].checked = false;
							if (ulChildNodes[j].value != chkobj.value)
							{
								ulChildNodes[j].disabled = true;
							}
						}
					}
				}else
				{
					selectionst.value = chkobj.value;
				}
			}else
			{
				if (wch_boxes == 'col')
				{
					selection.value = selection.value + chkobj.value;
				}else if (wch_boxes == 'st')
				{
					selectionst.value = selectionst.value + chkobj.value;
				}
			}
		}else if (!chkobj.checked)
		{
			var tmpvarCOL = ''; tmpvarST = '';
			if (wch_boxes == 'col')
			{
				for (t = 0; t <= selection.value.length-1; t++)
				{
					if (selection.value.charAt(t) != chkobj.value && tmpvarCOL.indexOf(selection.value.charAt(t)) == -1){tmpvarCOL = tmpvarCOL + selection.value.charAt(t)}
				}
				selection.value = tmpvarCOL;
				
				for (t = 0; t <= selectionst.value.length-1; t++)
				{
					if (selectionst.value.charAt(t) != chkobj.value && tmpvarST.indexOf(selectionst.value.charAt(t)) == -1){tmpvarST = tmpvarST + selectionst.value.charAt(t)}
				}
				selectionst.value = tmpvarST;
			}else (wch_boxes == 'st')
			{
				for (t = 0; t <= selectionst.value.length-1; t++)
				{
					if (selectionst.value.charAt(t) != chkobj.value && tmpvarST.indexOf(selectionst.value.charAt(t)) == -1){tmpvarST = tmpvarST + selectionst.value.charAt(t)}
				}
				selectionst.value = tmpvarST;
			}
		}
	}
}


function validate_date()
{
	with(rpts1_loc)
	{
		if (properdate(start_date.value, '') || properdate(end_date.value, ''))
		{
			_("succ_boxt").innerHTML = "Future dates are not allowed";
			_("succ_boxt").style.display = 'Block';
			return false
		}

		if (properdate(end_date.value, start_date.value) && end_date.value != '')
		{
			_("succ_boxt").innerHTML = "Start date must come before the end date";
			_("succ_boxt").style.display = 'Block';
			return false
		}

		hdstart_date.value = start_date.value
		hdend_date.value = end_date.value
	}
	return true
}


function validate (vtabno,ky)
{
	with(rpts1_loc)
	{
		if (vtabno == 6)
		{
			if (hdqry_type.value == 4 && hdstd_cent.value == '')
			{
				_("succ_boxt").innerHTML = "Please select a study centre in step 4";
				_("succ_boxt").style.display = 'Block';
				return false
			}

			if (whc_lnk.value == 'sf' && ky == '')
			{
				if (selection.value.length == 0 && hdqry_type.value != 4)
				{
					_("succ_boxt").innerHTML = "Please check and/or uncheck appropriate boxes in step 2";
					_("succ_boxt").style.display = 'Block';
					return false
				}

				if (selection.value.indexOf("u") > -1 && hdstd_entry_qual.value == '')
				{
					_("succ_boxt").innerHTML = "Please select a qualification in step 4";
					_("succ_boxt").style.display = 'Block';
					return false
				}
			}else
			{
				for (f = 0; f <= 19; f+=2)
				{
					if (elements[f].value != '' && elements[f+1].value != '')
					{
						val1 = parseInt(elements[f].value)
						val2 = parseInt(elements[f+1].value)
						if (val1 >= val2)
						{
							_("succ_boxt").innerHTML = "Please correct the lower and upper limits of one or more of your options in step 2";
							_("succ_boxt").style.display = 'Block';
							elements[f].focus()
							return false
						}
					}
				}

				opt_made = 0;
				for (f = 0; f <= 19; f+=2)
				{
					if (elements[f].value != '' && elements[f+1].value != '')
					{
						opt_made = 1
						break
					}
				}

				if (opt_made == 0)
				{
					_("succ_boxt").innerHTML = "You must at least set an age group in step 2";
					_("succ_boxt").style.display = 'Block';

					if (f == 20){f = 0}
					elements[f].focus()
					return false
				}
			}
			fwd.value = 1
		}else
		{
			tabno.value = vtabno
		}
		/*if (ky != '')
		{
			whc_lnk.value = ky
		}*/
		//submit()
	}
}


function properdate(dt1,dt2)
{
	var dd1 = dt1.substr(0,2);
	var mm1 = dt1.substr(3,2);
	var yy1 = dt1.substr(6,4);
	
	if (trim(dt2) == '')
	{
		var date = new Date();
		var dd2 = date.getDate()
		var mm2 = date.getMonth() + 1
		var yy2 = date.getFullYear()
		//return (yy1 > yy) || ((yy1 == yy) && (mm1 > mm)) || ((yy1 == yy) && (mm1 == mm) && (dd1 >dd))
	}else
	{
		var dd2 = dt2.substr(0,2);
		var mm2 = dt2.substr(3,2);
		var yy2 = dt2.substr(6,4)
		
		//return (yy2 > yy1) || ((yy2 == yy1) && (mm2 > mm1)) || ((yy2 == yy1) && (mm2 == mm1) && (dd2 > dd1))
	}
	return (yy1 > yy2) || ((yy1 == yy2) && (mm1 > mm2)) || ((yy1 == yy2) && (mm1 == mm2) && (dd1 > dd2))
}


function set_hds(prv,hdv,elem)
{
	if (elem == 'chk')
	{
		if (prv.checked)
		{
			hdv.value = prv.value
		}else
		{
			hdv.value = ''
		}
	}else
	{
		hdv.value = prv.value
	}
}




function set_suppl()
{
	var ulChildNodes = _("rtlft_std").getElementsByTagName("input");
	for (j = 0; j <= ulChildNodes.length-1; j++)
	{
		if (ulChildNodes[j].type == 'checkbox')
		{
			ulChildNodes[j].checked = false;
		}

		// if (ulChildNodes[j].type == 'select-one' && ulChildNodes[j].id.indexOf("crit") != -1)
		// {
		// 	ulChildNodes[j].value = '';
		// }
	}

	_('selection').value = '';
	_('selectionst').value = '';
	
	with(rpts1_loc)
	{
		// hdxtra_col.value='';
		// col_name.value='';
		// col_name.disabled=true;
		// hdcol_name.value='';

		// suppl_lst.disabled = true
		// suppl_lst.checked=false;

		// src_tbl.disabled = true
		// src_tbl.checked=false;
		// hdsrc_tbl.value='';
		
		// exp_reg.disabled = true
		// exp_reg.checked=false;
		// hdexp_reg.value='';

		// act_reg.disabled = true
		// act_reg.checked=false;
		// hdact_reg.value='';

		// ln_page.disabled = true
		// ln_page.value='';
		// hdln_page.value='';

		// page_fetch.disabled = true
		// page_fetch.value='';
		// hdpage_fetch.value='';

		// exp_reg.disabled = true
		// exp_reg.checked=false;
		//hdexp_reg.value='';

		// col_width.disabled = true
		// col_width.value=0;
		// hdcol_width.value=0;

		// xtra_col.disabled=true;
		// xtra_col.checked=false;
		// hdxtra_col.value='';
		
		// suppl_lst.disabled=true;
		// suppl_lst.checked=false;
		// hdsuppl_lst.value='';
		
		hdqry_type.value='';
		
		if(_("qry_type1").checked)//Counts and groupings
		{
			hdqry_type.value=1;
		}else if(_("qry_type2").checked)//A list
		{
			hdqry_type.value=2;
		}else if(_("qry_type3").checked)//Exam attendance list
		{
			hdqry_type.value=3;
			
			// hdxtra_col.value=1;
			// col_name.value='REMARK';
			// col_name.disabled=false;
			// hdcol_name.value='REMARK';
			
			// std_cat.value='c'
			
			// xtra_col.disabled=false;
			// xtra_col.checked=true;
			
			// src_tbl.disabled = false
			// exp_reg.disabled = false
			// act_reg.disabled = false
			
			// col_width.disabled = false
		}/*else if(_("qry_type4").checked)//A matriculation list
		{
			hdqry_type.value=4;
			
			// suppl_lst.disabled = false
			// xtra_col.disabled = false
			//src_tbl.disabled = true
			//exp_reg.disabled = true
			//act_reg.disabled = true
			//ln_page.disabled = true
			//page_fetch.disabled = true
			
			//col_width.disabled = false
		}*/
	}
}


function tab_modify_rpts(tab_no, descr)
{
	_("type_of_rpt_1").style.display = 'block';
	_("type_of_rpt_0").style.display = 'none';
	
	_("column_1").style.display = 'block';
	_("column_0").style.display = 'none';
	
	_("sorting_1").style.display = 'block';
	_("sorting_0").style.display = 'none';
	
	_("criteri_1").style.display = 'block';
	_("criteri_0").style.display = 'none';
	
	_("title_1").style.display = 'block';
	_("title_0").style.display = 'none';
	
	_("succ_boxt").style.display = 'none';

	for (i = 0; i <= 5; i++) 
	{
	  var cover_maincontent_id = 'ans' + i;
	   if (tab_no == i)
	   {
			_("id_top").style.display = 'block';
			_("id_top").innerHTML = descr;
			//_("top_desc").value = descr;
			//_("liner").style.display = 'block';
			_(cover_maincontent_id).style.display = 'block';
			
			if (tab_no == 1)
	   		{
				_("type_of_rpt_1").style.display = 'none';
				_("type_of_rpt_0").style.display = 'block';
				_("stat_noti_box_id").style.marginTop = '76px';
				_("stat_noti_box_id").innerHTML = "Selecting 'Counts and groupings' will disable the boxes under 'Identity Columns' in step 2";	
				_("sub_box0").style.display = 'none';
			}else if (tab_no == 2)
	   		{
				_("column_1").style.display = 'none';
				_("column_0").style.display = 'block';
				_("stat_noti_box_id").style.marginTop = '63px';
				_("stat_noti_box_id").innerHTML = "Choices made in this step determines the boxes to enable or disable in step 3 and, the available options in step 4";	
				_("sub_box0").style.display = 'none';
			}else if (tab_no == 3)
	   		{
				_("sorting_1").style.display = 'none';
				_("sorting_0").style.display = 'block';
				_("stat_noti_box_id").style.marginTop = '103px';
				_("stat_noti_box_id").innerHTML = "Choices made in step 2 determines the boxes to enable or disable here";	
				_("sub_box0").style.display = 'none';
			}else if (tab_no == 4)
	   		{
				_("criteri_1").style.display = 'none';
				_("criteri_0").style.display = 'block';
				
				_("sub_box0").style.marginTop = '74px';
				_("sub_box0").style.display = 'block';
			}else if (tab_no == 5)
			{
				_("title_1").style.display = 'none';
				_("title_0").style.display = 'block';
				_("sub_box0").style.marginTop = '74px';
				_("sub_box0").style.display = 'block';
			}
			
			if (tab_no != 4 && tab_no != 5)
			{
				_("stat_noti_box_id").style.display = 'block';
			}else
			{
				_("stat_noti_box_id").style.display = 'none';
			}
	   }else
	   {
			_(cover_maincontent_id).style.display = 'none';
	   }
	}
}



function opr_prep(ajax,formdata,srcFile)
{
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	
	ajax.open("POST", srcFile);
	ajax.send(formdata);
}



function progressHandler(event)
{
	_('ans4').style.height = '417px';
	_("succ_boxt").style.display = 'Block';
	_("succ_boxt").innerHTML = "Processing request, please...wait";
}



function errorHandler(event)
{
	_('ans4').style.height = '417px';
	_("succ_boxt").style.display = 'Block';
	_("succ_boxt").innerHTML = "Your internet connection was interrupted. Please try again";
}



function abortHandler(event)
{
	_('ans4').style.height = '417px';
	_("succ_boxt").style.display = 'Block';
	_("succ_boxt").innerHTML = "Process aborted";
}

function completeHandler(event)
{
	var returnedStr = event.target.responseText;
	
	if (_("frm_upd").value == 'f')
	{
		_("crit3").options.length = 0;
		_("crit3").options[_("crit3").options.length] = new Option('', '');
		
		_("crit4").options.length = 0;
		_("crit4").options[_("crit4").options.length] = new Option('', '');
		
		_("crit5").options.length = 0;
		_("crit5").options[_("crit5").options.length] = new Option('', '');
	}else if (_("frm_upd").value == 'd')
	{
		_("crit4").options.length = 0;
		_("crit4").options[_("crit4").options.length] = new Option('', '');
		
		_("crit5").options.length = 0;
		_("crit5").options[_("crit5").options.length] = new Option('', '');
	}else if (_("frm_upd").value == 'p')
	{
		_("crit5").options.length = 0;
		_("crit5").options[_("crit5").options.length] = new Option('', '');
	}else if (_("frm_upd").value == 'c')
	{
		_("crit5").options.length = 0;
		_("crit5").options[_("crit5").options.length] = new Option('', '');
	}else if (_("frm_upd").value == 's')
	{
		_("crit5").options.length = 0;
		_("crit5").options[_("crit5").options.length] = new Option('', '');
	}else if (_("frm_upd").value == 'so')
	{
		_("crit10").options.length = 0;
		_("crit10").options[_("crit10").options.length] = new Option('', '');
	}else if (_("frm_upd").value == 'sr')
	{
		_("crit12").options.length = 0;
		_("crit12").options[_("crit12").options.length] = new Option('', '');
	}
	
	_("succ_boxt").style.display = 'none';
	
	_('ans4').style.height = '447px';
	
	var comaFound = 0; semicol = 0;  dolarFound = 0; cProgId = ''; cProgdesc = '';
	var lgaid = ''; lganame = '';
	for (i = 0; i <= returnedStr.length-1; i++)
	{
		if (_("frm_upd").value == 'f' || _("frm_upd").value == 'd' || _("frm_upd").value == 'p')
		{
			if (returnedStr.charAt(i) == '%'){semicol = 1;}
			if (returnedStr.charAt(i) == '+'){comaFound = 1;}
			if (returnedStr.charAt(i) == '$'){dolarFound = 1;}
		
			if ((i == 0 || comaFound == 0) && returnedStr.charAt(i) != '$')
			{
				cProgId = cProgId + returnedStr.charAt(i);
			}else if (comaFound == 1 && semicol == 0 && returnedStr.charAt(i) != '+')
			{
				cProgdesc = cProgdesc + returnedStr.charAt(i);
			}else if (semicol == 1)
			{
				if (_("frm_upd").value == 'f')
				{
					if (dolarFound == 0)
					{
						_("crit3").options[_("crit3").options.length] = new Option(cProgdesc, cProgId);//dept
					}
				}else if (_("frm_upd").value == 'd')
				{
					if (dolarFound == 0)
					{
						_("crit4").options[_("crit4").options.length] = new Option(cProgdesc, cProgId);
					}else if (dolarFound == 1)
					{
						_("crit5").options[_("crit5").options.length] = new Option(cProgdesc, cProgId);
					}
				}else if (_("frm_upd").value == 'p')
				{
					if (dolarFound == 0)
					{
						_("crit5").options[_("crit5").options.length] = new Option(cProgdesc, cProgId);
					}else if (dolarFound == 1)
					{
						_("crit4").options[_("crit4").options.length] = new Option(cProgdesc, cProgId);
					}
				}
				cProgId = ''; cProgdesc = ''; semicol = 0; comaFound = 0
			}
		}else if (_("frm_upd").value == 'so' || _("frm_upd").value == 'sr')
		{
			if (lgaid.length != 5)
			{
				lgaid = lgaid + returnedStr.charAt(i);
			}else if (returnedStr.charAt(i) != ',' && returnedStr.charAt(i) != ';' && lgaid.length == 5)
			{
				lganame = lganame + returnedStr.charAt(i);
			}else if (returnedStr.charAt(i) != ',')
			{
				if (_("frm_upd").value == 'so')
				{
					_("crit10").options[_("crit10").options.length] = new Option(lganame, lgaid);
				}else if (_("frm_upd").value == 'sr')
				{
					_("crit12").options[_("crit12").options.length] = new Option(lganame, lgaid);
				}					
									
				lgaid = '';
				lganame = '';
			}
		}
	}
}




function unchkAll(parDiv)
{
	var ulChildNodes = _(parDiv).getElementsByTagName("input");
	for (j = 0; j <= ulChildNodes.length-1; j++)
	{
		if (ulChildNodes[j].type == 'checkbox')
		{
			ulChildNodes[j].checked = false;
			
			if (parDiv == 'ans2')
			{
				ulChildNodes[j].disabled = false;
				
				if (ulChildNodes[j].id  == 'col9' || 
				ulChildNodes[j].id  == 'col10' || 
				ulChildNodes[j].id  == 'col11' || 
				ulChildNodes[j].id  == 'col19')
				{
					ulChildNodes[j].disabled = true;
				}
				
				if (_("qry_type1").checked && 
				(ulChildNodes[j].id  == 'col20' || 
				ulChildNodes[j].id  == 'col21' || 
				ulChildNodes[j].id  == 'col22' ||
				ulChildNodes[j].id  == 'col23' || 
				ulChildNodes[j].id  == 'col24' || 
				ulChildNodes[j].id  == 'col25' || 
				ulChildNodes[j].id  == 'col26')){ulChildNodes[j].disabled = true;}
			}
		}
	}
	
	if (parDiv == 'ans2')
	{
		_('selection').value = '';
		_('selectionst').value = '';
		
		var ulChildNodes = _('ans3').getElementsByTagName("input");
		for (j = 0; j <= ulChildNodes.length-1; j++)
		{
			if (ulChildNodes[j].type == 'checkbox')
			{
				ulChildNodes[j].checked = false;
				ulChildNodes[j].disabled = true;
			}
		}
	}
}