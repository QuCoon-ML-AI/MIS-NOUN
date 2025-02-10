
<div class="appl_left_child_div" style="width:98%; margin:auto; max-height:83%; margin-top:10px; overflow:auto;  background-color:#fff">
    <div class="appl_left_child_div_child" style="margin-bottom:10px;">
        <div style="flex:10%; height:46px; background-color: #eff5f0"></div>
        <div style="flex:95%; padding-left:4px; height:46px; background-color: #eff5f0; font-weight:bold"><?php
            $side_no = '';
            $phone_number = '';
            $phone_contact_time = '';
            $phone_contact_days = '';
            $phone_contact_call = '0';
            $phone_contact_text = '0';

            $whatsapp_number = '';
            $whatsapp_conctact_time = '';
            $whatsapp_conctact_days = '';
            $whatsapp_contact_call = '0';
            $whatsapp_contact_text = '0';

            $email_id = '';

            $side_click = " AND side_no = 'counselling'";
            if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> '')
            {
                $side_click = " AND side_no = ?";

            }

            $stmt = $mysqli->prepare("SELECT 
            side_no,
            phone_number, 
            phone_contact_time, 
            phone_contact_days, 
            phone_contact_call, 
            phone_contact_text, 
            whatsapp_number, 
            whatsapp_conctact_time, 
            whatsapp_conctact_days, 
            whatsapp_contact_call, 
            whatsapp_contact_text, 
            email_id 
            FROM support_contact 
            WHERE cStudyCenterId = '$cStudyCenterId_loc'
            $side_click 
            AND cdel = 'N'");

            if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> '')
            {
                $stmt->bind_param("s", $_REQUEST["side_menu_no"]);
            }
            $stmt->bind_result($side_no,
            $phone_number, 
            $phone_contact_time, 
            $phone_contact_days, 
            $phone_contact_call, 
            $phone_contact_text, 
            $whatsapp_number, 
            $whatsapp_conctact_time, 
            $whatsapp_conctact_days, 
            $whatsapp_contact_call, 
            $whatsapp_contact_text, 
            $email_id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->fetch();
            $stmt->close();
            
            if ($side_no == 'course_adviser')
            {
                echo 'Contact a Course Adviser';
            }else if ($side_no == 'counselling')
            {
                echo 'Contact a Counsellor';
            }else if ($side_no == 'bursary')
            {
                echo 'Contact Bursary';
            }else if ($side_no == 'registry')
            {
                echo 'Contact Registry';
            }else if ($side_no == 'library')
            {
                echo 'Contact Library';
            }else if ($side_no == 'mis')
            {
                echo 'Contact MIS';
            }?>
        </div>
    </div><?php
    if ($phone_number <> '')
    {?>
        <div class="appl_left_child_div_child calendar_grid">
            <div style="flex:10%; padding-left:4px; height:46px; background-color: #ffffff">
                <img style="width:35px; height:35px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'accept-call-icon.png');?>" title="phone number contact"/>
            </div>
            <div style="flex:20%; padding-left:4px; height:46px; background-color: #ffffff">
                Phone number
            </div>
            <div style="flex:70%; padding-left:4px; height:46px; background-color: #ffffff">
                <?php echo $phone_number;?>
            </div>
        </div><?php
        if ($phone_contact_time <> '' && ($phone_contact_text == '1' || $phone_contact_call == '1'))
        {?>
            <div class="appl_left_child_div_child calendar_grid">
                <div style="flex:10%; padding-left:4px; height:46px; background-color: #ffffff">
                </div>
                <div style="flex:20%; padding-left:4px; height:46px; background-color: #ffffff">
                    Contact time
                </div>
                <div style="flex:70%; padding-left:4px; height:46px; background-color: #ffffff">
                    <?php echo $phone_contact_time;?> (local time)
                </div>
            </div><?php
        }
        
        if ($phone_contact_days <> '' && ($phone_contact_text == '1' || $phone_contact_call == '1'))
        {?>
            <div class="appl_left_child_div_child calendar_grid">
                <div style="flex:10%; padding-left:4px; height:46px; background-color: #ffffff">
                </div>
                <div style="flex:20%; padding-left:4px; height:46px; background-color: #ffffff">
                    Contact days
                </div>
                <div style="flex:70%; padding-left:4px; height:46px; background-color: #ffffff">
                    <?php echo $phone_contact_days;?>
                </div>
            </div><?php
        }
        
        if ($phone_contact_call == '1' || $phone_contact_text == '1')
        {?>
            <div class="appl_left_child_div_child calendar_grid">
                <div style="flex:10%; padding-left:4px; height:46px; background-color: #ffffff">
                </div>
                <div style="flex:20%; padding-left:4px; height:46px; background-color: #ffffff">
                    Guide
                </div>
                <div style="flex:70%; padding-left:4px; height:46px; background-color: #ffffff">
                    <?php if ($phone_contact_call == '1' && $phone_contact_text == '0')
                    {
                        echo 'Calls only';
                    }else if ($phone_contact_call == '0' && $phone_contact_text == '1')
                    {
                        echo 'Text only';
                    }else if ($phone_contact_call == '1' && $phone_contact_text == '1')
                    {
                        echo 'Calls and text are welcome';
                    }?>
                </div>
            </div><?php
        }

        if ($email_id <> '')
        {?>
            <div class="appl_left_child_div_child calendar_grid">
                <div style="flex:100%; padding-left:4px; height:46px; background-color: #eff5f0">
                </div>
            </div>
            <div class="appl_left_child_div_child calendar_grid">
                <div style="flex:10%; padding-left:4px; height:46px; background-color: #ffffff">
                    <img style="width:35px; height:25px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'envelope-line1.png');?>" title="eMaill address contact"/>
                </div>
                <div style="flex:20%; padding-left:4px; height:46px; background-color: #ffffff">
                    e-Mail address
                </div>
                <div style="flex:70%; padding-left:4px; height:46px; background-color: #ffffff">
                    <?php echo $email_id;?>
                </div>
            </div><?php
        }
    }
    
    
    if ($whatsapp_number <> '')
    {?>
        <div class="appl_left_child_div_child calendar_grid">
            <div style="flex:100%; padding-left:4px; height:46px; background-color: #eff5f0">
            </div>
        </div>
        <div class="appl_left_child_div_child calendar_grid">
            <div style="flex:10%; padding-left:4px; height:46px; background-color: #ffffff">
                <img style="width:35px; height:35px" src="data:image/png;base64,<?php echo c_image(BASE_FILE_NAME_FOR_IMG.'whatsapp.png');?>" title="Whatsapp contact"/>
            </div>
            <div style="flex:20%; padding-left:4px; height:46px; background-color: #ffffff">
                Phone number
            </div>
            <div style="flex:70%; padding-left:4px; height:46px; background-color: #ffffff">
                <?php echo $whatsapp_number;?>
            </div>
        </div><?php
        if ($whatsapp_conctact_time <> '' &&  ($whatsapp_contact_call == '1' || $whatsapp_contact_text == '1'))
        {?>
            <div class="appl_left_child_div_child calendar_grid">
                <div style="flex:10%; padding-left:4px; height:46px; background-color: #ffffff">
                </div>
                <div style="flex:20%; padding-left:4px; height:46px; background-color: #ffffff">
                    Contact Time
                </div>
                <div style="flex:70%; padding-left:4px; height:46px; background-color: #ffffff">
                    <?php echo $whatsapp_conctact_time;?>  (local time)
                </div>
            </div><?php
        }
        
        if ($whatsapp_conctact_days <> '' &&  ($whatsapp_contact_call == '1' || $whatsapp_contact_text == '1'))
        {?>
            <div class="appl_left_child_div_child calendar_grid">
                <div style="flex:10%; padding-left:4px; height:46px; background-color: #ffffff">
                </div>
                <div style="flex:20%; padding-left:4px; height:46px; background-color: #ffffff">
                    Contact days 
                </div>
                <div style="flex:70%; padding-left:4px; height:46px; background-color: #ffffff">
                    <?php echo $whatsapp_conctact_days;?>
                </div>
            </div><?php
        }

        if ($whatsapp_contact_call == '1' || $whatsapp_contact_text == '1')
        {?>
            <div class="appl_left_child_div_child calendar_grid">
                <div style="flex:10%; padding-left:4px; height:46px; background-color: #ffffff">
                </div>
                <div style="flex:20%; padding-left:4px; height:46px; background-color: #ffffff">
                    Guide
                </div>
                <div style="flex:70%; padding-left:4px; height:46px; background-color: #ffffff">
                    <?php if ($whatsapp_contact_call == '1' && $whatsapp_contact_text == '0')
                    {
                        echo 'Calls only';
                    }else if ($whatsapp_contact_call == '0' && $whatsapp_contact_text == '1')
                    {
                        echo 'Text only';
                    }else if ($whatsapp_contact_call == '1' && $whatsapp_contact_text == '1')
                    {
                        echo 'Calls and text are welcome';
                    }?>
                </div>
            </div><?php
        }
    }?>
</div>