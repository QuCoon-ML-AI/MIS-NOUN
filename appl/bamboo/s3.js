function chk_inputs()
{
    var letters = /^[A-Za-z ]+$/;
    var letters_numbers = /^[A-Za-z 0-9]+$/;

    with (ps)
    {
        if (!vResidenceCityName.value.match(letters))
        {
            caution_inform("Only alphabets allowed for 'Town'")
            return false;
        }

        if (!vResidenceAddress.value.match(letters_numbers))
        {
            caution_inform("Only alphabets and number allowed for 'Street address'")
            return false;
        }

        sidemenu.value = '4'; 
        r_saved.value='1';
    }
    return true;
}