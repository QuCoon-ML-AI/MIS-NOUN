function _(el)
{
    return document.getElementById(el)
}

//mm no., 
function lib_js(a,b,c,d)
{
    if(a == '' && b == '' && d == 'welcome_student')
    {
        std_sections.request_id.value='';
    }

    if(a == '' && b == '' && d == 'student_login_page')
    {
        std_sections.logout.value='1';
    }
    
    if(d == 'make-payment')
    {
        std_sections.request_id.value='';
        std_sections.amount.value='';
    }

    if (b == 'pay_convocation_gown')
    {
        std_sections.request_id.value='1';
        std_sections.vDesc.value='Convocation Gown';
    }

    if (b == 'semester_registration')
    {
        //std_sections.reg_sem.value='1';
    }
    
    std_sections.top_menu_no.value=a;
    std_sections.side_menu_no.value=b;
    std_sections.target=c;
    std_sections.action=d;
    if (a == 6)
    {
        //std_sections.action='https://mylearningspace.nouedu2.net/';
        std_sections.action='https://elearn.nou.edu.ng/';
    }

    if (c == '_self')
    {
        in_progress('1');
    }
    std_sections.submit();
    return false;
}