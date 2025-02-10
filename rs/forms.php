
<form action="student_login_page" method="post" name="std_lgin_pg" enctype="multipart/form-data">
    <input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
    <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
    <input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"])){echo $_REQUEST["vMatricNo"];} ?>" />
    <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
    <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
    <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"])){echo $_REQUEST["top_menu_no"];} ?>" />
    <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"])){echo $_REQUEST["side_menu_no"];} ?>" />
    <input name="logout" id="logout" type="hidden" value="1" />
</form>

<form action="welcome_student" method="post" name="std_hpg" enctype="multipart/form-data">
    <input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
    <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
    <input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"])){echo $_REQUEST["vMatricNo"];} ?>" />
    <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
    <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
    <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"])){echo $_REQUEST["top_menu_no"];} ?>" />
    <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"])){echo $_REQUEST["side_menu_no"];} ?>" />
</form>

<form method="post" name="std_sections" enctype="multipart/form-data">
    <input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
    <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
    <input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"])){echo $_REQUEST["vMatricNo"];}else if (isset($regno)){echo $regno;} ?>" />
    <input name="user_cat" type="hidden" value="5" />
    <input name="ilin" type="hidden" value="<?php if (isset($ilin)){echo $ilin;}else if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> ''){echo $_REQUEST['ilin'];} ?>" />
    <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
    <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId']) && $_REQUEST['cEduCtgId'] <> ''){echo $_REQUEST['cEduCtgId'];}else if (isset($cEduCtgId_loc)){echo $cEduCtgId_loc;}?>" />
    <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"])){echo $_REQUEST["top_menu_no"];} ?>" />
    <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"])){echo $_REQUEST["side_menu_no"];} ?>" />

    <input name="tSemester" id="tSemester" type="hidden" 
        value="<?php if (isset($_REQUEST["tSemester"]) && $_REQUEST["tSemester"] <> ''){echo $_REQUEST["tSemester"];}else if (isset($tSemester)){echo $tSemester;}?>" />

    <input name="AcademicDesc" id="AcademicDesc" type="hidden" value="<?php if (isset($orgsetins['cAcademicDesc'])){echo $orgsetins['cAcademicDesc'];} ?>" />
    <input name="minfee_ewallet" id="minfee_ewallet" type="hidden"/>
    <input name="cStudyCenterId" id="cStudyCenterId" type="hidden" 
        value="<?php if (isset($_REQUEST["cStudyCenterId"]) && $_REQUEST["cStudyCenterId"] <> ''){echo $_REQUEST["cStudyCenterId"];}?>">
    
    <!--for payments -->
    <input name="request_id" id="request_id" type="hidden" 
    value="<?php if (isset($_REQUEST["request_id"]) && $_REQUEST["request_id"] <> ''){echo $_REQUEST["request_id"];}?>" />
    <input id="vDesc" name="vDesc" value="Wallet Funding" type="hidden"/>    
                    
    <input name="department" id="department" type="hidden" value="<?php if (isset($cdeptId_loc)){echo $cdeptId_loc;} ?>" />
    <input name="pgrID" id="pgrID" type="hidden" value="<?php if (isset($cProgrammeId_loc)){echo $cProgrammeId_loc;} ?>" />
    <input name="cEduCtgId_text" id="cEduCtgId_text" type="hidden" value="<?php if (isset($vEduCtgDesc_loc)){echo $vEduCtgDesc_loc;} ?>" />
    
    <input name="reg_sem" id="reg_sem" type="hidden" value="0" />

    <input id="amount" name="amount" value="<?php if (isset($_REQUEST["amount"]) && $_REQUEST["amount"] <> ''){echo $_REQUEST["amount"];}?>" type="hidden"/>
    <input id="logout" name="logout" value="0" type="hidden"/>    
</form>



<form method="post" name="std_id_card" target="_blank" enctype="multipart/form-data">
    <input name="uvApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["uvApplicationNo"])){echo $_REQUEST["uvApplicationNo"];} ?>" />
    <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
    <input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"])){echo $_REQUEST["vMatricNo"];}else if (isset($regno)){echo $regno;} ?>" />
    <input name="user_cat" type="hidden" value="5" />
    <input name="ilin" type="hidden" value="<?php if (isset($ilin)){echo $ilin;}else if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> ''){echo $_REQUEST['ilin'];} ?>" />
    <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
    <input name="cEduCtgId" id="cEduCtgId" type="hidden" 
        value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else if (isset($cEduCtgId)){echo $cEduCtgId;}?>" />
    <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"])){echo $_REQUEST["top_menu_no"];} ?>" />
    <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"])){echo $_REQUEST["side_menu_no"];} ?>" />

    <input name="tSemester" id="tSemester" type="hidden" 
        value="<?php if (isset($_REQUEST["tSemester"]) && $_REQUEST["tSemester"] <> ''){echo $_REQUEST["tSemester"];}else if (isset($tSemester)){echo $tSemester;}?>" />

    <input name="AcademicDesc" id="AcademicDesc" type="hidden" value="<?php if (isset($orgsetins['cAcademicDesc'])){echo $orgsetins['cAcademicDesc'];} ?>" />
    <!-- <input name="minfee_ewallet" id="minfee_ewallet" type="hidden"/> -->
    <input name="cStudyCenterId" id="cStudyCenterId" type="hidden" 
        value="<?php if (isset($_REQUEST["cStudyCenterId"]) && $_REQUEST["cStudyCenterId"] <> ''){echo $_REQUEST["cStudyCenterId"];}?>">
    <input id="logout" name="logout" value="0" type="hidden"/>
    
</form>


<form action="https://accounts.google.com/" method="post" target="_blank" name="mail_account" enctype="multipart/form-data"></form>
<form action="../appl/guides-instructions" method="post" target="_blank" name="guides_instructions" enctype="multipart/form-data"></form>