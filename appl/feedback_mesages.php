<div id="smke_screen" class="smoke_scrn"></div>

<div id="smke_screen_2" class="smoke_scrn"></div>

<div id="inform_box" class="center top_most talk_backs talk_backs_logo" 
  style="position:fixed; border-color:#4fbf5c; background-size: 42px 45px; background-image: url('<?php echo BASE_FILE_NAME_FOR_IMG;?>success.png'); overflow:auto; max-height:450px">
    <div id="informa_msg_content" class="informa_msg_content_caution_cls" style="color:#4fbf5c;">Information</div>
    <div class="informa_msg_content_caution_cls" style="margin-top:3px; text-align:right">
      <input id="ok_button" class="buttons_yes"type="submit" value="Ok" 
      style="width:auto; padding:10px; height:auto; display:none;"
      onclick="_('smke_screen').style.display = 'none';
      _('smke_screen').style.zIndex = '-1';
      _('inform_box').style.display = 'none';
      _('inform_box').style.zIndex = '-1';
      _('informa_msg_content').innerHTML = '';
      if (_('token_dialog_box'))
      {
        _('token_dialog_box').style.display = 'none';
        _('token_dialog_box').style.zIndex = '-1';
      }"/>
    </div>
</div>


<div id="inprogress_box" class="center top_most talk_backs talk_backs_logo" 
  style="position:fixed; background-position:12px 15px; border-color:#4fbf5c; background-size: 35px 35px; background-image: url('<?php echo BASE_FILE_NAME_FOR_IMG;?>processing.png'); max-height:450px">
    <div id="inprogress_box_msg" class="informa_msg_content_caution_cls" style="color:#4fbf5c;">Information</div>
    <div class="informa_msg_content_caution_cls" style="margin-top:3px; text-align:right">
    </div>
</div>


<div id="abort_box" class="center top_most talk_backs talk_backs_logo" 
  style="position:fixed; background-position:12px 15px; border-color:#ed7a7d; background-size: 40px 40px; background-image: url('<?php echo BASE_FILE_NAME_FOR_IMG;?>no.png'); max-height:450px">
    <div id="abort_box_msg" class="informa_msg_content_caution_cls" style="color:#ed7a7d;">Information</div>
    <div class="informa_msg_content_caution_cls" style="margin-top:3px; text-align:right">
      <input id="ok_caution_button" class="f_info_buttonss" type="submit" value="Ok" 
      style="width:auto; padding:10px; height:auto;"
      onclick="_('smke_screen').style.display = 'none';
      _('smke_screen').style.zIndex = '-1';
      _('abort_box').style.display = 'none';
      _('abort_box').style.zIndex = '-1';
      _('abort_box_msg').innerHTML = '';
      _('inprogress_box').style.display = 'none';
      _('inprogress_box').style.zIndex = '-1';"/>
    </div>
</div>

<div id="caution_inform_box" class="center top_most talk_backs talk_backs_logo" 
  style="position:fixed; border-color: #e39400; background-position:15px 15px; background-size: 30px 30px; background-image: url('<?php echo BASE_FILE_NAME_FOR_IMG;?>not_allowed.png'); max-height:450px;">
    <div id="informa_msg_content_caution" class="informa_msg_content_caution_cls" style="color:#e39400;">Information</div>
    <div id="informa_msg_content_caution" class="informa_msg_content_caution_cls" style="color:#e39400;">
      <input id="ok_caution_button" class="info_buttonss" type="submit" value="Ok" 
      style="width:auto; padding:10px; height:auto; float:right;"
      onclick="_('smke_screen').style.display = 'none';
      _('smke_screen').style.zIndex = '-1';
      _('caution_inform_box').style.display = 'none';
      _('caution_inform_box').style.zIndex = '-1';
      _('inform_box').style.display = 'none';
      _('inform_box').style.zIndex = '-1';
      _('informa_msg_content_caution').innerHTML = '';
      _('smke_screen_2').style.zIndex='1';"/>
    </div>
</div>


<div id="confirm_box" class="center top_most talk_backs talk_backs_logo" 
  style="position:fixed; background-position:15px 15px; 
  background-size: 35px 35px; 
  background-image: url('<?php echo BASE_FILE_NAME_FOR_IMG;?>error1.png'); 
  border:1px solid #a4a29f;">
    <div id="confirm_msg_content" class="informa_msg_content_caution_cls"></div><p>
    <input class="buttons_yes" type="button" value="Yes" 
      style="width:auto; padding:10px; height:auto; float:right; margin-left:5px;"
      onclick="_('smke_screen').style.display = 'none';
      _('smke_screen').style.zIndex = '-1';

      _('confirm_box').style.display = 'none';
      _('confirm_box').style.zIndex = '-1';
      
      in_progress('1');
      form_sections.submit();"/>
    <input class="buttons_no" type="button" value="No" 
      style="width:auto; padding:10px; height:auto; float:right;"
      onclick="_('smke_screen').style.display = 'none';
      _('smke_screen').style.zIndex = '-1';

      _('confirm_box').style.display = 'none';
      _('confirm_box').style.zIndex = '-1';"/>
</div>


<div id="logout_inform_box" class="center top_most talk_backs talk_backs_logo" 
  style="position:fixed; border-color:#e64246; background-position:15px 15px; 
  background-size: 37px 35px; 
  background-image: url('<?php echo BASE_FILE_NAME_FOR_IMG;?>error1.png'); 
  max-height:450px;">
    <div id="informa_msg_content_caution_l" class="informa_msg_content_caution_cls" style="color:#e64246;"></div>    
    <div class="informa_msg_content_caution_cls" style="margin-top:3px; text-align:right">
      <input id="ok_caution_button" class="buttons_no"type="submit" value="Ok" 
      style="width:auto; padding:10px; height:auto; margin-right:0px"
      onclick="_('smke_screen').style.display = 'none';
      _('smke_screen').style.zIndex = '-1';
      _('logout_inform_box').style.display = 'none';
      _('logout_inform_box').style.zIndex = '-1';
      _('informa_msg_content_caution_l').innerHTML = ''; return false"/>
    </div>    
</div><?php
        
  $mysqli = link_connect_db();
  $stmt = $mysqli->prepare("SELECT cfacultyId FROM a_fac WHERE vappNo = ?");
  $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($app_fac);
  $stmt->fetch();
  $stmt->close();
  
  $prog_choice = 'prog_choice_'.$app_fac;?>