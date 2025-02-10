<?php

if (isset($_REQUEST["sm"]) && !is_bool(strpos($_REQUEST["sm"],'27')) && isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
{
    if ($_REQUEST["sm"] == '27a')
    {
        $sup_info = ' <font style="color:#f52e2e">Supervisor: Not yet assigned</font>';?>
        <div id="mgt_esminar_div" class="center" 
            style="transform: translate(-51.5%, -51%);
            width:76vw; 
            height:700px;
            border:1px solid #CCCCCC; 
            padding:8px; 
            display:block;
            box-shadow: 4px 4px 3px #888888; 
            background:#ffffff; z-index:4;">
            <div id="div_header" class="innercont_stff" style="height:auto; color:#FFFFFF; margin-bottom:5px; width:97.8%; color:#637649;"><?php
                if ($_REQUEST["sm"] == '27a')
                {
                    $stmt1 = $mysqli->prepare("SELECT cemail, concat(vLastName,' ',vFirstName,' ',vOtherName) allname, cphone
                    FROM mgt_pg_std a, userlogin b
                    WHERE a.supervisor = b.vApplicationNo
                    AND vMatricNo = ?");
                    $stmt1->bind_param("s",$_REQUEST["uvApplicationNo"]);
                    $stmt1->execute();
                    $stmt1->store_result();
                    $stmt1->bind_result($vEMailId, $allname_s, $phone);
                    $stmt1->fetch();
                    $stmt1->close();

                    if (isset($vEMailId))
                    {
                        $sup_info = ' <font style="color:#f52e2e">Supervisor: '.$allname_s.'::'.$vEMailId.'::'.$phone.'</font>';
                    }
                    echo 'Manage seminar topics for ';
                }else if ($_REQUEST["sm"] == '27b')
                {
                    echo 'Manage thesis proposal for ';
                }else if ($_REQUEST["sm"] == '27c')
                {
                    echo 'Manage pre-field proposal defence for ';
                }else if ($_REQUEST["sm"] == '27d')
                {
                    echo 'Manage post-field defence for ';
                }else if ($_REQUEST["sm"] == '27e')
                {
                    echo 'Manage approval of thesis for ';
                }else if ($_REQUEST["sm"] == '27f')
                {
                    echo 'Manage defence of thesis for ';
                }else if ($_REQUEST["sm"] == '27g')
                {
                    echo 'Manage Award of degree for ';
                }
                
                echo $_REQUEST["uvApplicationNo"].$sup_info;?>
            </div>

            <div class="innercont_stff" style="height:auto; color:#FFFFFF; margin-bottom:5px; width:2%; color:#637649; text-align:right;">
                <img style="width:17px; height:17px; cursor:pointer" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" 
                    onclick="_('mgt_esminar_div').style.zIndex = '-1';
                    _('mgt_esminar_div').style.display='none';
                    _('general_smke_screen_loc').style.zIndex = '2';
                    _('general_smke_screen_loc').style.display = 'block';
                    _('pg_environ').uvApplicationNo.value='';
                    return false"/>
            </div>

            <hr style="height:5px; width:100%; margin-top:6px;  margin-bottom:0.5%; background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0px; height:1px;" /><?php
            

            if (check_scope3('SPGS', 'Manage seminar topics', 'New topic') > 0)
            {?>
                <a href="#" style="text-decoration:none;" 
                    onclick="_('new_esminar_div').style.zIndex = '7';
                    _('new_esminar_div').style.display='block';
                    _('general_smke_screen_loc').style.zIndex = '6';
                    _('general_smke_screen_loc').style.display = 'block';
                    return false">
                    <div class="middle_std_btns" style="width:auto; position:absolute; right:11px; top:40px">
                        New topic
                    </div>
                </a><?php
            }
            
            if (check_scope3('SPGS', 'Manage supervisor', 'Assign supervisor') > 0)
            {?>        
                <a href="#" style="text-decoration:none;" 
                    onclick="_('new_sup_div').style.zIndex = '7';
                    _('new_sup_div').style.display='block';
                    _('general_smke_screen_loc').style.zIndex = '6';
                    _('general_smke_screen_loc').style.display = 'block';
                    return false">
                    <div class="middle_std_btns" style="width:auto; position:absolute; right:100px; top:40px">
                        (Re)Assign Supervisor
                    </div>
                </a><?php
            }?>
            
            <div class="innercont_stff" style="margin-top:35px; font-weight:bold">
                <div class="_label" style="border-right:1px solid #cdd8cf; text-align:right; width:3%; padding:0.5%; margin-top:0%; color:#6b6b6b;">
                    Sno
                </div>
                <div class="_label" style="border-right:1px solid #cdd8cf; width:49%; padding:0.5%; margin-top:0%; color:#6b6b6b;">
                    Topic
                </div>
                <div class="_label" style="border-right:1px solid #cdd8cf; width:11.8%; padding:0.5%; margin-top:0%; color:#6b6b6b;">
                    Date assigned
                </div>
                <div class="_label" style="border-right:1px solid #cdd8cf; width:5.66%; padding:0.5%; margin-top:0%; color:#6b6b6b;">
                    Presented
                </div>
                <div class="_label" style="border-right:1px solid #cdd8cf; width:11.76%; padding:0.5%; margin-top:0%; color:#6b6b6b;">
                    Date presented
                </div>
                <div class="_label" style="border-right:1px solid #cdd8cf; text-align:right; width:4%; padding:0.5%; margin-top:0%; color:#6b6b6b;">
                    Score
                </div>
            </div>
            <div class="innercont_stff" style="height:84%; overflow:scroll;overflow-x: hidden;"><?php
            
            $stmt = $mysqli->prepare("SELECT 
            topic, date_ass, presented, date_presented, score
            FROM pg_seminar
            WHERE cDel = 'N' AND vMatricNo = ?");

            $stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($topic, $date_ass, $presented, $date_presented, $score);
            $cnt_topic = 0;
            while($stmt->fetch())
            {
                if ($cnt_topic%2 == 0){$background = ' background:#EEF7EE';}else{$background = ' background:#FFFFFF';}?>
                <div class="innercont_stff" style="height:32px; margin-top:0%;">
                    <div class="_label" style="border-right:1px solid #cdd8cf; text-align:right; width:3%; padding:0.5%; margin-top:0%; color:#6b6b6b; <?php echo $background;?>"><?php 
                        echo ++$cnt_topic;?>
                    </div>
                    <div class="_label" style="border-right:1px solid #cdd8cf; width:49.9%; padding:0.5%; margin-top:0%; color:#6b6b6b; <?php echo $background;?>"><?php 
                        echo ucwords($topic);?>
                    </div>
                    <div class="_label" style="border-right:1px solid #cdd8cf; width:12%; padding:0.5%; margin-top:0%; color:#6b6b6b; <?php echo $background;?>"><?php 
                        echo formatdate(substr($date_ass,0,10),'fromdb').' '.substr($date_ass,11);?>
                    </div>
                    <div class="_label" style="border-right:1px solid #cdd8cf; width:5.8%; padding:0.5%; margin-top:0%; color:#6b6b6b; <?php echo $background;?>"><?php 
                        if ($presented == '0'){echo 'No';}else{echo 'Yes';}?>
                    </div>
                    <div class="_label" style="border-right:1px solid #cdd8cf; width:12%; padding:0.5%; margin-top:0%; color:#6b6b6b; <?php echo $background;?>"><?php 
                        echo formatdate(substr($date_presented,0,10),'fromdb').' '.substr($date_presented,11);?>
                    </div>
                    <div class="_label" style="border-right:1px solid #cdd8cf; text-align:right; width:4%; padding:0.5%; margin-top:0%; color:#6b6b6b; <?php echo $background;?>" title="<?php 
                        if ($score == -1){echo 'Not yet recorded';}?>"><?php 
                        if ($score > -1){echo $score;}else{echo 'NYR';}?>
                    </div>
                    <div class="_label" style="border-right:1px solid #cdd8cf; text-align:right; width:5.5%; padding:0.5%; margin-top:0%; margin-bottom:0%; color:#6b6b6b; <?php echo $background;?>"><?php
                        if (check_scope3('SPGS', 'Manage seminar topics', 'Edit seminar record') > 0)
                        {?>
                            <a href="#" style="text-decoration:none;" 
                            onclick="_('s_topic').value='<?php echo $topic;?>';
                            _('date_ass').value='<?php echo $date_ass;?>';
                            _('presented').value='<?php echo $presented;?>';
                            if (_('presented').value == '1'){_('presented').checked=true}else{_('presented').checked=false}
                            _('date_presented').value='<?php echo $date_presented;?>';
                            _('score').value='<?php echo $score;?>';
                            _('edit').value='1';
                            _('new_esminar_div').style.zIndex = '7';
                            _('new_esminar_div').style.display='block';
                            _('general_smke_screen_loc').style.zIndex = '6';
                            _('general_smke_screen_loc').style.display = 'block';">
                                <div style="margin:0px;
                                    float:right;
                                    margin-left:10%; 
                                    width:20%;
                                    border:0px solid #ccc;" 
                                    title="Click to edit selected item">
                                    <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'edit.png');?>" style="cursor:pointer; height:auto; width:100%;">
                                </div>
                            </a><?php
                        }else
                        {?>
                            <div style="margin:0px;
                                float:right;
                                margin-left:10%; 
                                width:20%;
                                border:0px solid #ccc;
                                opacity:0.3;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'edit.png');?>" style="cursor:pointer; height:auto; width:100%;cursor:not-allowed;">
                            </div><?php
                        }
                        
                        if (check_scope3('SPGS', 'Manage seminar topics', 'Delete seminar record') > 0)
                        {?>
                            <a href="#" style="text-decoration:none;" 
                            onclick="_('s_topic').value='<?php echo $topic;?>';
                            _('s_topic').value='<?php echo $topic;?>';
                            _('submityes').style.display = 'block';
                            _('submityes').style.zIndex = '7';
                            _('general_smke_screen_loc').style.zIndex = '6';
                            _('general_smke_screen_loc').style.display = 'block';
                            pg_environ.del.value='1';">
                                <div 
                                    style="margin:0px;
                                    float:right;
                                    margin-left:2%; 
                                    width:20%;
                                    border:0px solid #ccc;">
                                    <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'delete_one.png');?>" style="cursor:pointer; height:auto; width:100%;">
                                </div>
                            </a><?php
                        }else
                        {?>
                            <div 
                                style="margin:0px;
                                float:right;
                                margin-left:2%; 
                                width:20%;
                                border:0px solid #ccc;
                                opacity:0.3;">
                                <img src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'delete_one.png');?>" style="cursor:pointer; height:auto; width:100%;cursor:not-allowed;">
                            </div><?php
                        }?>
                    </div>
                </div><?php 
            }
            $stmt->close()?>
            </div>
        </div><?php
    }?>

    <div id="new_esminar_div" class="center" 
        style="transform: translate(-51.5%, -51%);
        width:50vw; 
        height:auto;
        border:1px solid #CCCCCC; 
        padding:10px; 
        display:none;
        box-shadow: 4px 4px 3px #888888; 
        background:#ffffff; z-index:7;">
        <div id="div_header" class="innercont_stff" style="height:auto; color:#FFFFFF; margin-bottom:5px; width:97.4%; color:#637649;">
            Add new seminar topic for <?php echo $_REQUEST["uvApplicationNo"];?>
        </div>

        <div class="innercont_stff" style="height:auto; color:#FFFFFF; margin-bottom:5px; width:2%; color:#637649; text-align:right;">
            <img style="width:17px; height:17px; cursor:pointer" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" 
                onclick="_('new_esminar_div').style.zIndex = '-1';
                _('new_esminar_div').style.display='none';
               
                _('general_smke_screen_loc').style.zIndex = '4';
                _('general_smke_screen_loc').style.display = 'block';
                return false"/>
        </div>

        <hr style="height:5px; width:100%; margin-top:6px;  margin-bottom:0.5%; background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0px; height:1px;" />

        <div class="innercont_stff" style="padding-top:4x;">
            <label for="cEduCtgId_loc" class="labell" style="width:140px;">Seminar topic</label>
            <div class="div_select" style="margin-right:0px;">
                <input name="s_topic" id="s_topic" type="text" class="textbox" style="text-transform:none; width:96.5%" />
            </div>
            <div class="labell_msg orange_msg" style="width:370px; margin-left:2px;" id="labell_msg0"></div>
        </div>               

        <div class="innercont_stff" style="padding-top:4px;">
            <label for="cEduCtgId_loc" class="labell" style="width:140px;">Date assigned</label>
            <div class="div_select" style="margin-right:0px;">
                <input type="date" name="date_ass" id="date_ass" class="textbox" style="height:99%; width:97.5%"
                onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            </div>
            <div class="labell_msg orange_msg" style="width:370px; margin-left:2px;" id="labell_msg1"></div>
        </div>

        <div class="innercont_stff" style="padding-top:4px;">
            <label for="presented" class="labell" style="width:140px;">Done presentation</label>
            <div class="div_select" style="margin-right:0px;">
                <input name="presented" id="presented" type="checkbox" style="margin-top:4px; margin-left:0px" 
                onclick="if(this.checked)
                {
                    _('date_presented').disabled=false;
                }else
                {
                    _('date_presented').disabled=true;
                    _('date_presented').value='';
                }"/>
            </div>
            <div class="labell_msg orange_msg" style="width:370px; margin-left:2px;" id="labell_msg2"></div>
        </div>        

        <div class="innercont_stff" style="padding-top:4px;">
            <label for="date_presented" class="labell" style="width:140px;">Date of presentation</label>
            <div class="div_select" style="margin-right:0px;">
                <input type="date" name="date_presented" id="date_presented" class="textbox" style="height:99%; width:97.5%" disabled
                    onkeydown="caution_box('Click on callendar icon inside the input box on the right to pick date');return false">
            </div>
            <div class="labell_msg orange_msg" style="width:370px; margin-left:2px;" id="labell_msg3"></div>
        </div>

        <div class="innercont_stff" style="padding-top:4px;">
            <label for="score" class="labell" style="width:140px;">Score</label>
            <div class="div_select" style="margin-right:0px;">
                <input name="score" id="score" type="number" class="textbox" style="text-transform:none; width:96.5%" />
            </div>
            <div class="labell_msg orange_msg" style="width:370px; margin-left:2px;" id="labell_msg4"></div>
        </div>        

        <div class="innercont_stff" style="padding-top:4px">                        
            <div id="konfirm" style="float:right">                
                <a id="btn_save" href="#" class="basic_three_sm_stff"
                style="width:85px; padding:9px; margin:0px; display:block" 
                onclick="_('save_cf').value='1';
                chk_inputs();return false">Save</a>
            </div>
        </div>
    </div>
    
    <div id="new_sup_div" class="center" 
        style="transform: translate(-51.5%, -51%);
        width:50vw; 
        height:auto;
        border:1px solid #CCCCCC; 
        padding:10px; 
        display:none;
        box-shadow: 4px 4px 3px #888888; 
        background:#ffffff; z-index:7;">
        <div id="div_header" class="innercont_stff" style="height:auto; color:#FFFFFF; margin-bottom:5px; width:97.4%; color:#637649;">
            Assign supervisor to <?php echo $_REQUEST["uvApplicationNo"];?>
        </div>

        <div class="innercont_stff" style="height:auto; color:#FFFFFF; margin-bottom:5px; width:2%; color:#637649; text-align:right;">
            <img style="width:17px; height:17px; cursor:pointer" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" 
                onclick="_('new_sup_div').style.zIndex = '-1';
                _('new_sup_div').style.display='none';
               
                _('general_smke_screen_loc').style.zIndex = '4';
                _('general_smke_screen_loc').style.display = 'block';
                return false"/>
        </div>

        <hr style="height:5px; width:100%; margin-top:6px;  margin-bottom:0.5%; background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0px; height:1px;" />

        <div class="innercont_stff" style="padding-top:4x;">
            <label for="user_names" class="labell" style="width:145px; margin-left:7px;">Existing supervisor(s)</label>
            <div class="div_select">
                <input list="user_names" name="exist_user" id="exist_user" class="textbox"
                    placeholder="Type name here..." 
                    style="height:78%;
                    background-image: url('img/preview.png'); 
                    background-position: 10px 5px; 
                    background-repeat: no-repeat;
                    background-size: 10% 73%;
                    text-indent:45px;
                    border-radius:3px;
                    padding:3px;"
                    value="<?php if (isset($_REQUEST["exist_user"])){echo $_REQUEST["exist_user"];} ?>"/>
                <datalist id="user_names"><?php
                    $sql = "SELECT vApplicationNo, concat(vLastName,', ',vFirstName,' ',vOtherName) allnames FROM userlogin WHERE vLastName is not null ORDER BY vLastName, vFirstName, vOtherName";
                    $rsgetroles = mysqli_query(link_connect_db(), $sql) or die(mysqli_error(link_connect_db()));
                    $item_count = 0;
                    while($getroles = mysqli_fetch_array($rsgetroles))
                    {
                        if (!isset($getroles['allnames'])){continue;}
                        
                        $item_count++;
                        if (($item_count%5)==0)
                        {?>
                            <option disabled></option><?php
                        }?>
                        <option value="<?php echo $getroles['vApplicationNo']?>"><?php echo strtoupper($getroles['allnames'])?></option><?php
                    }
                    mysqli_close(link_connect_db());?>
                </datalist>
            </div>
            <div class="labell_msg orange_msg" style="width:365px; margin-left:2px;" id="labell_msg0b"></div>
        </div>               

        <div class="innercont_stff" style="padding-top:4px">                        
            <div id="konfirm" style="float:right">                
                <a id="btn_save" href="#" class="basic_three_sm_stff"
                style="width:85px; padding:9px; margin:0px; display:block" 
                onclick="_('save_cf').value='1';
                chk_inputs();return false">Assign</a>
            </div>
        </div>
    </div><?php
}

if (isset($_REQUEST["sm"]) && $_REQUEST["sm"] <> '')
{?>
    <div id="fwd_app_div" class="center" 
        style="transform: translate(-50%, -50%);
        width:97vw; 
        height:95vh;
        border:1px solid #CCCCCC; 
        padding:8px; 
        display:block;
        box-shadow: 4px 4px 3px #888888; 
        background:#ffffff; z-index:3">
        <div id="div_header" class="innercont_stff" style="height:30px; color:#FFFFFF; margin-bottom:5px; width:97.8%; color:#637649;"><?php
            /*if ($_REQUEST["sm"] == '20')
            {
                echo 'Forwarding of submitted PG applications';
            }else if ($_REQUEST["sm"] == '21')
            {
                echo 'Retrieve forwarded application';
            }else */if ($_REQUEST["sm"] == '22')
            {
                echo 'Manage invitation for interview';
            }else if ($_REQUEST["sm"] == '23')
            {
                echo 'Interview status';
            }else if ($_REQUEST["sm"] == '24')
            {
                echo 'Recommend candidate(s)';
            }else if ($_REQUEST["sm"] == '25')
            {
                echo 'Send admission letter';
            }else if ($_REQUEST["sm"] == '26')
            {
                echo 'Screening';
            }else if ($_REQUEST["sm"] == '28')
            {
                echo 'Transcript submission';
            }else if ($_REQUEST["sm"] == '27a')
            {
                echo 'Manage seminar topics';
            }else if ($_REQUEST["sm"] == '27b')
            {
                echo 'Manage thesis proposal';
            }else if ($_REQUEST["sm"] == '27c')
            {
                echo 'Manage pre-field proposal defence';
            }else if ($_REQUEST["sm"] == '27d')
            {
                echo 'Manage post-field defence';
            }else if ($_REQUEST["sm"] == '27e')
            {
                echo 'Manage approval of thesis';
            }else if ($_REQUEST["sm"] == '27f')
            {
                echo 'Manage defence of thesis';
            }else if ($_REQUEST["sm"] == '27g')
            {
                echo 'Manage award of degree';
            }?>
        </div>

        <div class="innercont_stff" style="height:auto; color:#FFFFFF; margin-bottom:5px; width:2%; color:#637649; text-align:right;">
            <img style="width:17px; height:17px; cursor:pointer" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'close.png');?>" 
                onclick="_('fwd_app_div').style.zIndex = '-1';
                _('fwd_app_div').style.display='none';
                _('general_smke_screen_loc').style.zIndex = '-1';
                _('general_smke_screen_loc').style.display = 'none';
                _('pg_environ').uvApplicationNo.value='';
                return false"/>
        </div>
        
        <hr style="width:100%; margin-top:20px; margin-bottom:0.5%; background-image:linear-gradient(90deg, #a8c1aa, transparent); border:0px; height:0.5px;" /><?php
        
        $sql1 = "SELECT cFacultyId, vFacultyDesc FROM faculty WHERE cFacultyId = '$cFacultyId_u' AND cDelFlag = 'N' ORDER BY cFacultyId";
        if ($sRoleID_u == 6 || $sRoleID_u == 27)
        {
            $sql1 = "SELECT cFacultyId, vFacultyDesc FROM faculty WHERE cCat = 'A' AND cFacultyId NOT IN ('DEG','CHD') AND cDelFlag = 'N' ORDER BY cFacultyId";
        }
        
        $rsql1 = mysqli_query(link_connect_db(), $sql1)or die("cannot query the table".mysqli_error(link_connect_db()));?>
        <div id="all_chk_box" class="innercont_stff" style=" height:93%; overflow:scroll; overflow-x: hidden; margin-top:0px;">
            <div class="innercont_stff" style="position:fixed; margin-top:5px; right:50px; top:4px"><?php
                /*if ($sm == '20')
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="chk_inputs();return false">
                        <div class="middle_std_btns" style="width:auto">
                            Forward selected candidate(s) to their respective departments
                        </div>
                    </a><?php
                }else if ($sm == '21')
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="chk_inputs();return false">
                        <div class="middle_std_btns" style="width:auto">
                            Retrieve forwarded applications
                        </div>
                    </a><?php
                }else*/ if ($sm == '22')
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="chk_inputs();return false">
                        <div class="middle_std_btns" style="width:auto">
                            Send invitation for interview to selected candidate(s)
                        </div>
                    </a><?php
                }else if ($sm == '23')
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="chk_inputs();return false">
                        <div class="middle_std_btns" style="width:auto">
                            Confirm interview status
                        </div>
                    </a><?php
                }else if ($sm == '24')
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="chk_inputs();return false">
                        <div class="middle_std_btns" style="width:auto">
                            Recommend candidate(s) to SPGS
                        </div>
                    </a><?php
                }else if ($sm == '25')
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="chk_inputs();return false">
                        <div class="middle_std_btns" style="width:auto">
                            Enable admission letter for successfull candidate(s)
                        </div>
                    </a><?php
                }else if ($sm == '26')
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="chk_inputs();return false">
                        <div class="middle_std_btns" style="width:auto">
                            Confirm candidates' screening
                        </div>
                    </a><?php
                }else if ($sm == '28')
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="chk_inputs();return false">
                        <div class="middle_std_btns" style="width:auto">
                            Confirm submission of transcript
                        </div>
                    </a><?php
                }else if ($sm == '27b')
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="chk_inputs();return false">
                        <div class="middle_std_btns" style="width:auto">
                            Confirm submission of thesis proposal
                        </div>
                    </a><?php
                }else if ($sm == '27c')
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="chk_inputs();return false">
                        <div class="middle_std_btns" style="width:auto">
                            Confirm defence of thesis proposal
                        </div>
                    </a><?php
                }else if ($sm == '27d')
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="chk_inputs();return false">
                        <div class="middle_std_btns" style="width:auto">
                            Confirm post-field defence
                        </div>
                    </a><?php
                }else if ($sm == '27e')
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="chk_inputs();return false">
                        <div class="middle_std_btns" style="width:auto">
                            Confirm approval of thesis
                        </div>
                    </a><?php
                }else if ($sm == '27f')
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="chk_inputs();return false">
                        <div class="middle_std_btns" style="width:auto">
                            Confirm thesis defence
                        </div>
                    </a><?php
                }else if ($sm == '27g')
                {?>
                    <a href="#" style="text-decoration:none;" 
                        onclick="chk_inputs();return false">
                        <div class="middle_std_btns" style="width:auto">
                            Confirm award of degree
                        </div>
                    </a><?php
                }?>
            </div><?php 
            $cnt1 = 0; 
            $cnt4 = 0;
            while ($table = mysqli_fetch_array($rsql1))
            {?>
                <label for="<?php echo $table[0]; ?>">
                    <div class="_label" style="border:1px solid #cdd8cf; width:10.5%; padding:0%; padding-top:0.5%; padding-left:0.5%; text-align:left; background:#eff5f0">
                        <?php echo ++$cnt1;?>
                        <input name="<?php echo $table[0]; ?>" id="<?php echo $table[0]; ?>" value="<?php echo $table[0]; ?>" type="checkbox" 
                        onclick="set_other_box(this.id, '<?php echo $table[0]; ?>')"/><?php
                        echo ' '.$table[1].'<p>';//faculty?><?php
                        
                        $sql2 = "SELECT cdeptId, vdeptDesc FROM depts WHERE cFacultyId  = '$cFacultyId_u' AND cdeptId = '$cdeptId_u'  AND cDelFlag = 'N' ORDER BY vdeptDesc";
                        if ($sRoleID_u == 6 || $sRoleID_u == 27)
                        {
                            $sql2 = "SELECT cdeptId, vdeptDesc FROM depts WHERE cFacultyId  = '".$table[0]."' AND cDelFlag = 'N' ORDER BY vdeptDesc";
                        }

                        
                        $rsql2 = mysqli_query(link_connect_db(), $sql2)or die("cannot query the table".mysqli_error(link_connect_db()));
                        $cnt2 = 0;
                        while ($table2 = mysqli_fetch_array($rsql2))
                        {?>
                            <div class="_label" style="border:1px solid #cdd8cf; width:97%; margin-bottom:4%; background:#FFFFFF">
                                <label for="<?php echo $table[0].'_'.$table2[0]; ?>">
                                    <div class="_label" style="border:0px; text-align:right; width:100%; margin:0; margin-bottom:2%;">
                                        <div class="_label" style="border:0px; border-right:1px solid #cdd8cf; text-align:right; width:15%; margin-top:-1%;"><?php 
                                            echo ++$cnt2;?>
                                        </div>
                                        <div class="_label" style="border:0px solid #cdd8cf; width:78%; margin-top:-1px; 
                                            background-image:linear-gradient(0deg, #FFFFFF, transparent, #cdd8cf);">
                                            <input name="<?php echo $table[0].'_'.$table2[0]; ?>" id="<?php echo $table[0].'_'.$table2[0]; ?>" value="<?php echo $table2[0]; ?>" type="checkbox" onclick="set_other_box(this.id, '<?php echo $table2[0]; ?>')"/>
                                            <?php echo ' '.$table2[1];//department?>
                                        </div>
                                    </div>
                                </label><?php

                                /*if ($sm == '20')//fwd app
                                {
                                    $prev_session_0 = substr($orgsetins["cAcademicDesc"],0,4)-1;
                                    $prev_session_1 = substr($orgsetins["cAcademicDesc"],5,4)-1;

                                    $prev_session = $prev_session_0.'/'.$prev_session_1;
                                    $pg_select = " AND a.cEduCtgId IN ('PGX','PGY','PGZ','PRX') AND cSbmtd  = '1' AND (cAcademicDesc = '".$orgsetins["cAcademicDesc"]."' OR cAcademicDesc = '$prev_session') ";

                                    //$pg_select = '';

                                    $sql3 = "SELECT vApplicationNo FROM prog_choice a, programme b  
                                    WHERE a.cProgrammeId = b.cProgrammeId
                                    AND b.cdeptId = '".$table2[0]."'
                                    $pg_select 
                                    AND b.cDelFlag = 'N' 
                                    ORDER BY vApplicationNo";
                                }else if ($sm == '21')//retr app
                                {
                                    $sql3 = "SELECT vApplicationNo FROM prog_choice a, programme b  
                                    WHERE a.cProgrammeId = b.cProgrammeId
                                    AND b.cdeptId = '".$table2[0]."'
                                    AND vApplicationNo IN (SELECT vApplicationNo from prog_choice_pg WHERE cDel = 'N' AND (fwdd = '1' OR (fwdd = '0' AND retr = '1')))
                                    AND b.cDelFlag = 'N' 
                                    ORDER BY vApplicationNo";
                                }else*/ if ($sm == '22')//iv
                                {
                                    $sql3 = "SELECT vApplicationNo, a.cEduCtgId FROM prog_choice a, programme b  
                                    WHERE a.cProgrammeId = b.cProgrammeId
                                    AND b.cdeptId = '".$table2[0]."'
                                    AND vApplicationNo IN (SELECT vApplicationNo from prog_choice_pg WHERE fwdd = '1' AND cDel = 'N')
                                    AND b.cDelFlag = 'N' 
                                    ORDER BY vApplicationNo";
                                }else if ($sm == '23')//intv status
                                {
                                    $sql3 = "SELECT vApplicationNo, a.cEduCtgId FROM prog_choice a, programme b  
                                    WHERE a.cProgrammeId = b.cProgrammeId
                                    AND b.cdeptId = '".$table2[0]."'
                                    AND vApplicationNo IN (SELECT vApplicationNo from prog_choice_pg WHERE invited = '1' AND cDel = 'N')
                                    AND b.cDelFlag = 'N' 
                                    ORDER BY vApplicationNo";
                                }else if ($sm == '24')//fwd intv rpt
                                {
                                    $sql3 = "SELECT vApplicationNo, a.cEduCtgId FROM prog_choice a, programme b  
                                    WHERE a.cProgrammeId = b.cProgrammeId
                                    AND b.cdeptId = '".$table2[0]."'
                                    AND vApplicationNo IN (SELECT vApplicationNo from prog_choice_pg WHERE itervwd = '1' AND cDel = 'N')
                                    AND b.cDelFlag = 'N' 
                                    ORDER BY vApplicationNo";
                                }else if ($sm == '25')//ltr
                                {
                                    $sql3 = "SELECT vApplicationNo, a.cEduCtgId FROM prog_choice a, programme b  
                                    WHERE a.cProgrammeId = b.cProgrammeId
                                    AND b.cdeptId = '".$table2[0]."'
                                    AND vApplicationNo IN (SELECT vApplicationNo from prog_choice_pg WHERE recon = '1' AND cDel = 'N')
                                    AND b.cDelFlag = 'N' 
                                    ORDER BY vApplicationNo";
                                }else if ($sm == '26')//scrn
                                {
                                    $sql3 = "SELECT vApplicationNo, a.cEduCtgId FROM prog_choice a, programme b  
                                    WHERE a.cProgrammeId = b.cProgrammeId
                                    AND b.cdeptId = '".$table2[0]."'
                                    AND vApplicationNo IN (SELECT vApplicationNo from prog_choice_pg WHERE ltr_sent = '1')
                                    AND b.cDelFlag = 'N' 
                                    ORDER BY vApplicationNo";
                                }else if (!is_bool(strpos($_REQUEST["sm"],'27')))//seminar
                                {
                                    $sql3 = "SELECT vMatricNo, b.cEduCtgId FROM s_m_t a, programme b  
                                    WHERE a.cProgrammeId = b.cProgrammeId
                                    AND b.cdeptId = '".$table2[0]."'
                                    AND vApplicationNo IN (SELECT vApplicationNo from prog_choice_pg WHERE cSCrnd = '1' AND cDel = 'N')
                                    AND b.cDelFlag = 'N' 
                                    ORDER BY vApplicationNo";
                                }else if (!is_bool(strpos($_REQUEST["sm"],'28')))//transcript
                                {
                                    $sql3 = "SELECT vApplicationNo, a.cEduCtgId FROM prog_choice a, programme b  
                                    WHERE a.cProgrammeId = b.cProgrammeId
                                    AND b.cdeptId = '".$table2[0]."'
                                    AND (vApplicationNo IN (SELECT vApplicationNo from prog_choice_pg WHERE cSCrnd = '1' AND cDel = 'N') OR
                                    a.cSCrnd = '1' OR a.cSbmtd = '2')
                                    AND b.cDelFlag = 'N' 
                                    ORDER BY vApplicationNo";
                                }
                                
                                $rsql3 = mysqli_query(link_connect_db(), $sql3)or die("cannot query the table".mysqli_error(link_connect_db()));
                                $cnt3 = 0;
                                while ($table3 = mysqli_fetch_array($rsql3))
                                {
                                    $extra_msg = "";
                                    $extra_msg_1 = "";

                                    $box_state = "";
                                    
                                    if (strlen($sm) == 3 && !is_numeric(substr($sm,2,1)))
                                    {
                                        $sql4 = "SELECT vMatricNo, 
                                        supervisor, 
                                        date_supervisor, 
                                        thesis_prop, 
                                        date_thesis_prop, 
                                        pre_fld_def, 
                                        date_pre_fld_def, 
                                        post_fld_def, 
                                        date_post_fld_def, 
                                        thesis_apr, 
                                        date_thesis_apr, 
                                        thesis_def, 
                                        date_thesis_def, 
                                        deg_award, 
                                        date_deg_award
                                        FROM mgt_pg_std WHERE vMatricNo = '".$table3[0]."' AND cDel = 'N'";
                                    }else
                                    {
                                        $sql4 = "SELECT fwdd,
                                        date_fwdd,
                                        retr,
                                        date_retr,
                                        invited,
                                        date_iv,
                                        itervwd,
                                        date_itervwd,
                                        rpt_fwdd,
                                        date_rpt_fwdd,
                                        ltr_sent,
                                        date_ltr_sent,
                                        cSCrnd,
                                        date_cSCrnd,
                                        recon,
                                        date_recon,
                                        transcript,
                                        date_transcript
                                        FROM prog_choice_pg WHERE vApplicationNo = '".$table3[0]."' AND cDel = 'N'";
                                    }

                                    $rsql4 = mysqli_query(link_connect_db(), $sql4)or die("cannot query the table".mysqli_error(link_connect_db()));
                                    $table4 = mysqli_fetch_array($rsql4);

                                    if (isset($table4))
                                    {
                                        /*if ($sm == '20')//fwd app
                                        {
                                            if ($table4["fwdd"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Date forwarded: ".formatdate($table4["date_fwdd"],'fromdb'); 
                                            }
                                        }else if ($sm == '21')//retr app
                                        {
                                            if ($table4["invited"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Date invited: ".formatdate($table4["date_iv"],'fromdb');
                                            }else if ($table4["retr"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Date retrieved: ".formatdate($table4["date_retr"],'fromdb');
                                            }else if ($table4["fwdd"] == '1')
                                            {
                                                $box_state = "";
                                                $extra_msg_1 = "Date forwarded: ".formatdate($table4["date_fwdd"],'fromdb');
                                            }
                                        }else*/ if ($sm == '22')//iv
                                        {
                                            if ($table4["invited"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Date invited: ".formatdate($table4["date_iv"],'fromdb');
                                            }
                                        }else if ($sm == '23')//intvw status
                                        {
                                            if ($table4["invited"] == '1' && $table4["itervwd"] == '0')
                                            {
                                                $extra_msg_1 = "Date invited: ".formatdate($table4["date_iv"],'fromdb');
                                            }else if ($table4["itervwd"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Date interviewed: ".formatdate($table4["date_itervwd"],'fromdb');
                                            }
                                        }else if ($sm == '24')//fwd intvw rpt
                                        {
                                            if ($table4["recon"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Date reconmmended: ".formatdate($table4["date_recon"],'fromdb');
                                            }else if ($table4["itervwd"] == '1')
                                            {
                                                $extra_msg_1 = "Date interviewed: ".formatdate($table4["date_itervwd"],'fromdb');
                                            }else  if ($table4["rpt_fwdd"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Date report forwarded: ".formatdate($table4["date_rpt_fwdd"],'fromdb');
                                            }else  if ($table4["invited"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Date invited: ".formatdate($table4["date_iv"],'fromdb');
                                            }
                                        }else if ($sm == '25')//ltr
                                        {
                                            if ($table4["ltr_sent"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Letter enabled on ".formatdate($table4["date_ltr_sent"],'fromdb');
                                            }else if ($table4["recon"] == '1')
                                            {
                                                $box_state = "";
                                                $extra_msg_1 = "Date reconmmended: ".formatdate($table4["date_recon"],'fromdb');
                                            }
                                        }else if ($sm == '26')//scrn
                                        {
                                            if ($table4["cSCrnd"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Date screened: ".formatdate($table4["date_cSCrnd"],'fromdb');
                                            }
                                        }else if ($sm == '28')//transcript
                                        {
                                            if ($table4["transcript"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Date submitted: ".formatdate($table4["date_transcript"],'fromdb');
                                            }
                                        }else if ($sm == '27b')//submitted  thesis prop
                                        {
                                            if ($table4["thesis_prop"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Submision date: ".formatdate($table4["date_thesis_prop"],'fromdb');
                                            }
                                        }else if ($sm == '27c')//def thesis
                                        {
                                            if ($table4["thesis_prop"] == '0')
                                            {
                                                $box_state = " disabled checked";
                                            }else if ($table4["pre_fld_def"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Defence date: ".formatdate($table4["date_pre_fld_def"],'fromdb');
                                            }
                                        }else if ($sm == '27d')//post fld def
                                        {
                                            if ($table4["pre_fld_def"] == '0')
                                            {
                                                $box_state = " disabled checked";
                                            }else if ($table4["post_fld_def"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Post-field defence date: ".formatdate($table4["date_post_fld_def"],'fromdb');
                                            }
                                        }else if ($sm == '27e')//post fld def
                                        {
                                            if ($table4["post_fld_def"] == '0')
                                            {
                                                $box_state = " disabled checked";
                                            }else if ($table4["thesis_apr"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Thesis approval date: ".formatdate($table4["date_thesis_apr"],'fromdb');
                                            }
                                        }else if ($sm == '27f')//thesis def
                                        {
                                            if ($table4["thesis_apr"] == '0')
                                            {
                                                $box_state = " disabled checked";
                                            }else if ($table4["thesis_def"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Defence date: ".formatdate($table4["date_thesis_def"],'fromdb');
                                            }
                                        }else if ($sm == '27g')//deg award
                                        {
                                            if ($table4["thesis_def"] == '0')
                                            {
                                                $box_state = " disabled checked";
                                            }else if ($table4["deg_award"] == '1')
                                            {
                                                $box_state = " disabled checked";
                                                $extra_msg_1 = "Award date: ".formatdate($table4["date_deg_award"],'fromdb');
                                            }
                                        }
                                    }
                                    $cnt4++;?>
                                    <label for="<?php echo 'afn_'.$cnt4;?>"><?php
                                        if ($cnt3 == 0)
                                        {?>
                                            <div class="_label" style="border:0px; border-right:1px solid #cdd8cf; text-align:right; width:15%; margin-top:0%; color:#6b6b6b;"><?php 
                                                echo ++$cnt3;?>
                                            </div>
                                            <div class="_label" style="border:0px; width:78%; margin-top:0%; color:#6b6b6b;" title="<?php echo $extra_msg_1;?>"><?php
                                        }else
                                        {?>     
                                            <div class="_label" style="border:0px; border-right:1px solid #cdd8cf; text-align:right; width:15%; margin-top:-1%; color:#6b6b6b;"><?php 
                                                echo ++$cnt3;?>
                                            </div>
                                            <div class="_label" style="border:0px solid #cdd8cf; width:78%; margin-top:-1px; color:#6b6b6b;" title="<?php echo $extra_msg_1;?>"><?php
                                        }?>
                                        
                                        <input id="<?php echo 'afn_'. $cnt4; ?>" name="<?php echo 'afn_'.$table[0].'_'.$table2[0].'_'.$table3[0]; ?>" value="<?php echo $table3[0]; ?>" type="checkbox" 
                                            onclick="if(this.checked)
                                                {
                                                    _('<?php echo 'box_check_'. $cnt4; ?>').value='1';
                                                }else
                                                {
                                                    _('<?php echo 'box_check_'. $cnt4; ?>').value='0';
                                                }
                                                
                                                if (pg_environ.sm.value.indexOf('27') == -1)
                                                {
                                                    if (!event.ctrlKey)
                                                    {
                                                        if(this.checked)
                                                        {
                                                            _('m_frm').uvApplicationNo.value='<?php echo $table3[0];?>';
                                                            _('m_frm').submit();
                                                        }
                                                    }
                                                }else if (pg_environ.sm.value == '27a' || !(pg_environ.sm.value.length == 3 && isNaN(pg_environ.sm.value.substr(2,1))))
                                                {
                                                    _('pg_environ').uvApplicationNo.value='<?php echo $table3[0];?>';_('pg_environ').submit();
                                                }" <?php echo  $box_state;?>/>

                                        <input id="<?php echo 'box_check_'. $cnt4; ?>" type="hidden" value="<?php if ($box_state == '' || $box_state == ' disabled checked'){echo '0';}else{echo '1';}?>" /><?php
                                            echo $table3[0].',';
                                            if ($table3[1] == 'PGX')
                                            {
                                                echo 'A';
                                            }else if ($table3[1] == 'PGY')
                                            {
                                                echo 'B';
                                            }else if ($table3[1] == 'PGZ')
                                            {
                                                echo 'C';
                                            }else if ($table3[1] == 'PRX')
                                            {
                                                echo 'D';
                                            }?><font style="color:#584bf1"><?php
                                            if (isset($table4))
                                            {
                                                /*if ($sm == '20')//fwd app
                                                {
                                                    if ($table4["fwdd"] == '1')
                                                    {?>
                                                        <br>Forwarded<?php
                                                    }
                                                }elseif ($sm == '21')//retr app
                                                {
                                                    if ($table4["invited"] == '1')
                                                    {?>
                                                        <br>Invited<?php
                                                    }elseif ($table4["retr"] == '1')
                                                    {?>
                                                        <br>Retrieved<?php
                                                    }else if ($table4["fwdd"] == '1')
                                                    {?>
                                                        <br>Forwarded<?php
                                                    }
                                                }else */if ($sm == '22')//iv
                                                {
                                                    if ($table4["invited"] == '1')
                                                    {?>
                                                        <br>Invited<?php
                                                    }
                                                }else if ($sm == '23')//itnv
                                                {
                                                    if ($table4["invited"] == '1' && $table4["itervwd"] == '0')
                                                    {?>
                                                        <br>Invited<?php
                                                    }else if ($table4["itervwd"] == '1')
                                                    {?>
                                                        <br>Interviewed<?php
                                                    }
                                                }else if ($sm == '24')//fwd intv rpt
                                                {
                                                    if ($table4["recon"] == '1')
                                                    {?>
                                                        <br>Recommended<?php
                                                    }else if ($table4["itervwd"] == '1')
                                                    {?>
                                                        <br>Interviewed<?php
                                                    }else if ($table4["rpt_fwdd"] == '1')
                                                    {?>
                                                        <br>Forwarded<?php
                                                    }else  if ($table4["invited"] == '1')
                                                    {?>
                                                        <br>Invited<?php
                                                    }else if ($table4["recon"] == '0')
                                                    {?>
                                                        <br>Reconmmend<?php
                                                    }
                                                }else if ($sm == '25')//ltr
                                                {
                                                    if ($table4["ltr_sent"] == '1')
                                                    {?>
                                                        <br>Letter enabled<?php
                                                    }else if ($table4["recon"] == '1')
                                                    {?>
                                                        <br>Reconmmended<?php
                                                    }
                                                }else if ($sm == '26')//ltr
                                                {
                                                    if ($table4["cSCrnd"] == '1')
                                                    {?>
                                                        <br>Screened qualified<?php
                                                    }else if ($table4["cSCrnd"] == '0')
                                                    {?>
                                                        <br>Screen<?php
                                                    }
                                                }else if ($sm == '28')//ltr
                                                {
                                                    if ($table4["transcript"] == '1')
                                                    {?>
                                                        <br>Submitted transcript<?php
                                                    }else if ($table4["transcript"] == '0')
                                                    {?>
                                                        <br>Transcript pending<?php
                                                    }
                                                }else if ($sm == '27b')//submitted prop
                                                { 
                                                    if ($table4["thesis_prop"] == '1')
                                                    {?>
                                                        <br>Submitted proposal<?php
                                                    }
                                                }else if ($sm == '27c')//defended prop
                                                { 
                                                    if ($table4["thesis_prop"] == '0')
                                                    {?>
                                                        <br>To submit proposal<?php
                                                    }else if ($table4["pre_fld_def"] == '1')
                                                    {?>
                                                        <br>Defended proposal<?php
                                                    }
                                                }else if ($sm == '27d')//post fld def
                                                { 
                                                    if ($table4["pre_fld_def"] == '0')
                                                    {?>
                                                        <br>To defend proposal<?php
                                                    }else if ($table4["post_fld_def"] == '1')
                                                    {?>
                                                        <br>Post field defended<?php
                                                    }
                                                }else if ($sm == '27e')//thesis apr
                                                { 
                                                    if ($table4["post_fld_def"] == '0')
                                                    {?>
                                                        <br>To do post-field defence<?php
                                                    }else if ($table4["thesis_apr"] == '1')
                                                    {?>
                                                        <br>Thesis approved<?php
                                                    }
                                                }else if ($sm == '27f')//thesis def
                                                { 
                                                    if ($table4["thesis_apr"] == '0')
                                                    {?>
                                                        <br>To be approved<?php
                                                    }else if ($table4["thesis_def"] == '1')
                                                    {?>
                                                        <br>Thesis defended<?php
                                                    }
                                                }else if ($sm == '27g')//deg award
                                                { 
                                                    if ($table4["thesis_def"] == '0')
                                                    {?>
                                                        <br>To defend thesis<?php
                                                    }else if ($table4["deg_award"] == '1')
                                                    {?>
                                                        <br>Degree awarded<?php
                                                    }
                                                }
                                            }?></font>
                                    </div>
                                </label><?php
                                }?>
                            </div><?php
                        }?>
                    </div>
                </label><?php
            }
            mysqli_close(link_connect_db());?>
        </div>
    </div><?php
}?>