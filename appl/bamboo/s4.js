function chk_inputs()
{
    var letters = /^[A-Za-z -]+$/;
    var letters_numbers = /^[A-Za-z 0-9]+$/;

    with (ps)
    {
        if (!vNOKName.value.match(letters))
        {
            caution_inform("Only alphabets are allowed for 'Name'")
            return false;
        }

        if (!vNOKAddress.value.match(letters_numbers))
        {
            caution_inform("Only alphabets and number are allowed for 'address'")
            return false;
        }

        if (vNOKMobileNo.value.length != 11)
        {
            caution_inform("Invalid phone number")
            return false;            
        }

        if (vNOKEMailId.value == my_email.value)
        {
            caution_inform("eMail address of your next of kin cannot be the same as yours")
            return false;            
        }

        if (vNOKMobileNo.value == my_gsm.value)
        {
            caution_inform("Phone number of your next of kin cannot be the same as yours")
            return false;            
        }

        if (vNOKMobileNo.value == my_w_gsm.value)
        {
            caution_inform("Phone number of your next of kin cannot be the same as your whatsapp number")
            return false;            
        }

        sidemenu.value = '5'; 
        r_saved.value='1';
    }
    return true;
}