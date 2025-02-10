function chk_inputs()
{
    var letters_numbers = /^[A-Za-z 0-9]+$/;
    var letters = /^[A-Za-z ]+$/;

    with (ps)
    {
        if (!vPostalCityName.value.match(letters))
        {
            caution_inform("Only alphabets are allowed for 'Town'")
            return false;
        }

        if (!vPostalAddress.value.match(letters_numbers))
        {
            caution_inform("Only alphabets and numbers are allowed for 'Street address'")
            return false;
        }

        if (nk_mail.value == vEMailId.value)
        {
            caution_inform("Your email address and that of your next of kin cannot be the same")
            return false;            
        }

        if (chk_mail(_('vEMailId')) != '')
        {
            caution_inform('eMail address '+chk_mail(_('vEMailId')));
            return false;
        }

        if (vMobileNo.value == nk_gsm.value)
        {
            caution_inform("Your phone number and that of your next of kin cannot be the same")
            return false;            
        }

        if (w_vMobileNo.value == nk_gsm.value)
        {
            caution_inform("Your whatsapp number and the phone number of your next of kin cannot be the same")
            return false;            
        }

        sidemenu.value = '3'; 
        r_saved.value='1';
    }
    return true;
}