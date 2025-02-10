
<form action="applicant_login_page" method="post" name="appl_lgin_pg" enctype="multipart/form-data">
    <input name="uvApplicationNo" type="hidden" value="" />
    <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
    <input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"])){echo $_REQUEST["vMatricNo"];} ?>" />
    <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
    <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
    <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
    <input name="logout" id="logout" type="hidden" value="1" />
</form>

<form action="applicant_welcome_page" method="post" name="appl_hpg" enctype="multipart/form-data">
    <input name="uvApplicationNo" type="hidden" value="" />
    <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
    <input name="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"])){echo $_REQUEST["vMatricNo"];} ?>" />
    <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
    <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
    <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
</form>


<form method="post" name="form_sections" enctype="multipart/form-data">
    <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
    <input name="user_cat" type="hidden" value="<?php if (isset($_REQUEST['user_cat'])){echo $_REQUEST['user_cat'];} ?>" />
    <input name="ilin" type="hidden" value="<?php if (isset($_REQUEST['ilin'])){echo $_REQUEST['ilin'];} ?>" />
    <input name="passpotLoaded" id="passpotLoaded" type="hidden" value="<?php if (isset($_REQUEST["passpotLoaded"])){echo $_REQUEST["passpotLoaded"];}?>">
    <input name="cEduCtgId" id="cEduCtgId" type="hidden" value="<?php if (isset($_REQUEST['cEduCtgId'])&&$_REQUEST['cEduCtgId']<> ''){echo $_REQUEST['cEduCtgId'];}else if (isset($GLOBALS['cEduCtgId'])){echo $GLOBALS['cEduCtgId'];}?>" />
    <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
                            
    <input name="studentID" id="studentID" type="hidden" value="<?php if (isset($_REQUEST["studentID"]) && $_REQUEST["studentID"] <> ''){echo $_REQUEST["studentID"];} ?>" />
    
    <input name="cReqmtId_fp" id="cReqmtId_fp" type="hidden" value="<?php if (isset($_REQUEST["cReqmtId_fp"]) && $_REQUEST["cReqmtId_fp"] <> ''){echo str_pad($_REQUEST["cReqmtId_fp"], 2, "0", STR_PAD_LEFT);}else if (isset($cReqmtId) && $cReqmtId <> ''){echo str_pad($cReqmtId, 2, "0", STR_PAD_LEFT);} ?>" />
    <input name="iBeginLevel_fp" id="iBeginLevel_fp" type="hidden" value="<?php if (isset($_REQUEST["iBeginLevel_fp"]) && $_REQUEST["iBeginLevel_fp"] <> ''){echo $_REQUEST["iBeginLevel_fp"];}else if (isset($iBeginLevel) && $iBeginLevel <> ''){echo $iBeginLevel;} ?>" />
    
</form>


<form action="applicant_login_page" method="post" name="appl_home_page" enctype="multipart/form-data">
    <input name="vApplicationNo" type="hidden" value="<?php if (isset($_REQUEST["vApplicationNo"])){echo $_REQUEST["vApplicationNo"];} ?>" />
    <input name="user_cat" type="hidden" value="" />
    <input name="ilin" type="hidden" value="" />
    <input name="sidemenu" id="sidemenu" type="hidden" value="<?php if (isset($_REQUEST["sidemenu"])){echo $_REQUEST["sidemenu"];} ?>" />
</form>