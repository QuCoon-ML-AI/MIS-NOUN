

<div class="appl_left_child_div_child calendar_grid">
    <div style="flex:100%; padding-left:4px; height:40px; background-color: #ffffff; font-weight:bold">
        Fee payable
    </div>
</div>

<div class="appl_left_child_div_child calendar_grid">
    <div id="fee_msg" class="inlin_message_color" style="flex:100%; padding-right:4px; height:auto;">
        The amount to be paid in addition to what is displayed below is determined by your programme and the number of courses to be registered for the semester
    </div>
</div>

<div class="appl_left_child_div_child calendar_grid">
    <div style="flex:15%; padding-left:4px; height:40px; background-color: #ffffff">
        Sn
    </div>
    <div style="flex:35%; padding-left:4px; height:40px; background-color: #ffffff">
        Description
    </div>
    <div style="flex:50%; padding-right:4px; height:40px; background-color: #ffffff; text-align:right">
        <?php if ($cResidenceCountryId_loc == 'NG')
        {
            echo "Amount (N)";
        }else
        {
            echo "Amoun ($)";
        }?>
    </div>
</div><?php

$returnedStr = calc_student_bal($_REQUEST["vMatricNo"], 'mone_at_hand', $cResidenceCountryId_loc);

$balance = trim(substr($returnedStr, 0, 100));
$minfee = trim(substr($returnedStr, 100, 100));
$iItemID_str = trim(substr($returnedStr, 200, 300));
$just_paid = trim(substr($returnedStr, 500, 100));

$min_chd_amnt = 0;
$total_package = 0;

if ($cdeptId_loc == "PCC")
{
    $stmt = $mysqli->prepare("SELECT SUM(Amount)
    FROM s_f_s a, fee_items b, `sell_item_cat` c
    WHERE a.fee_item_id = b.fee_item_id
    AND a.`citem_cat` = c.`citem_cat`
    AND iItemID in ($iItemID_str)");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($Amount);
    $stmt->fetch();

    $min_chd_amnt = $Amount/3;
    $total_package = $Amount;
}else if ($cdeptId_loc == "ACL")
{
    $stmt = $mysqli->prepare("SELECT SUM(Amount)
    FROM s_f_s a, fee_items b, `sell_item_cat` c
    WHERE a.fee_item_id = b.fee_item_id
    AND a.`citem_cat` = c.`citem_cat`
    AND iItemID in ($iItemID_str)");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($Amount);
    $stmt->fetch();

    $min_chd_amnt = $Amount/2;
    $total_package = $Amount;
}


$stmt_reuse = $mysqli->prepare("SELECT citem_cat_desc, b.fee_item_desc vDesc, Amount, iItemID
FROM s_f_s a, fee_items b, `sell_item_cat` c
WHERE a.fee_item_id = b.fee_item_id
AND a.`citem_cat` = c.`citem_cat`
AND iItemID in ($iItemID_str)
ORDER BY a.citem_cat, vDesc");

$stmt_reuse->execute();
$stmt_reuse->store_result();
$stmt_reuse->bind_result($citem_cat_desc, $vDesc, $Amount, $iItemID);
$NumOfRec = $stmt_reuse->num_rows;

$str = '';
$prev_citem_cat_desc = '';
$c = 0;

$total = 0;
while ($stmt_reuse->fetch())
{
    if ($prev_citem_cat_desc == '' || $prev_citem_cat_desc <> $citem_cat_desc)
    {?>
        <div class="appl_left_child_div_child calendar_grid">
            <div style="flex:100%; padding-left:4px; height:40px; background-color: #ffffff; font-weight:bold">
                <?php echo $citem_cat_desc;?>
            </div>
        </div><?php
    }?>

    <div class="appl_left_child_div_child calendar_grid">
        <div style="flex:15%; padding-left:4px; height:40px; background-color: #ffffff">
            <?php echo ++$c;?>
        </div>
        <div style="flex:35%; padding-left:4px; height:40px; background-color: #ffffff">
            <?php echo $vDesc;?>
        </div>
        <div style="flex:50%; padding-right:4px; height:40px; background-color: #ffffff; text-align:right">
            <?php echo number_format($Amount, 2, '.', ',');
            $total += $Amount;?>
        </div>
    </div><?php
    //$str .= str_pad($citem_cat_desc,100).str_pad($vDesc,100).str_pad($Amount,10);

    $prev_citem_cat_desc = $citem_cat_desc;
}
$stmt_reuse->close();?>
<div class="appl_left_child_div_child calendar_grid">
    <div style="flex:100%; padding-right:4px; height:40px; background-color: #ffffff; font-weight:bold; text-align:right">
        <?php echo "Total ".number_format($total,2);?>
    </div>
</div>


<form action="pay_registration_fee" method="post" name="pay_reg_fee" id="pay_reg_fee" enctype="multipart/form-data" 
    onsubmit="if (pay_reg_fee.reg_sem.value!='1' && pay_reg_fee.amount.value != '' && (std_sections.pgrID.value.indexOf('CHD') == -1 && parseFloat(pay_reg_fee.amount.value) < parseFloat(pay_reg_fee.amount_h.value)))
    {
        caution_inform('Minimum amount is '+pay_reg_fee.amount_h.value);
        return false;
    }else if (pay_reg_fee.reg_sem.value!='1' && 
    pay_reg_fee.amount.value != '' && 
    std_sections.pgrID.value.indexOf('CHD') > -1)
    {
        var outstanding = parseFloat(pay_reg_fee.walletBalance.value) - parseFloat(pay_reg_fee.totalPackage.value);
        if (parseFloat(pay_reg_fee.amount.value) < parseFloat(pay_reg_fee.min_chd_amnt.value) && parseFloat(outstanding) > parseFloat(pay_reg_fee.min_chd_amnt.value))
        {
            caution_inform('Minimum amount is '+pay_reg_fee.min_chd_amnt.value);
            return false;
        }

        in_progress('1');
        return true;
    }else
    {
        in_progress('1');
        return true;
    }">

    <input name="user_cat" id="user_cat" type="hidden" value="<?php if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] <> ''){echo $_REQUEST["user_cat"];}?>" />
    <input name="ilin" id="ilin" type="hidden" value="<?php if (isset($_REQUEST["ilin"]) && $_REQUEST["ilin"] <> ''){echo $_REQUEST["ilin"];}?>" />
    <input name="vMatricNo" id="vMatricNo" type="hidden" value="<?php if (isset($_REQUEST["vMatricNo"]) && $_REQUEST["vMatricNo"] <> ''){echo $_REQUEST["vMatricNo"];}?>" />
    
    <input name="top_menu_no" id="top_menu_no" type="hidden" value="<?php if (isset($_REQUEST["top_menu_no"]) && $_REQUEST["top_menu_no"] <> ''){echo $_REQUEST["top_menu_no"];}?>" />
    <input name="side_menu_no" id="side_menu_no" type="hidden" value="<?php if (isset($_REQUEST["side_menu_no"]) && $_REQUEST["side_menu_no"] <> ''){echo $_REQUEST["side_menu_no"];}?>" />
    
    <input id="vDesc" name="vDesc" value="Wallet Funding" type="hidden"/>
    <input id="amount_h" name="amount_h" type="hidden" value="<?php echo $total;?>"/>
    <input id="request_id" name="request_id" value="1" type="hidden"/>
    
    <input id="min_chd_amnt" name="min_chd_amnt" value="<?php echo $min_chd_amnt;?>" type="hidden"/>
    <input id="walletBalance" name="walletBalance" value="<?php echo $balance;?>" type="hidden"/>
    <input id="totalPackage" name="totalPackage" value="<?php echo $total_package;?>" type="hidden"/>
    
    <input id="cEduCtgId" name="cEduCtgId" value="<?php echo $cEduCtgId_loc; ?>" type="hidden"/>
    <input id="cEduCtgId_text" name="cEduCtgId_text" value="<?php echo $vEduCtgDesc_loc; ?>" type="hidden"/>
	<input name="department" id="department" type="hidden" value="<?php echo $cdeptId_loc;?>" />
    
    <input id="reg_sem" name="reg_sem" value="0" type="hidden"/><?php

    if (strlen($iItemID_str) < 8)
    {
        
    }else if ($balance >= $minfee && $NumOfRec > 0 && $orgsetins['ewallet_cred_for_sem_reg'] == '1')
    {?>
        <div class="appl_left_child_div_child calendar_grid">
            <div id="fee_msg" class="inlin_message_color" style="flex:100%; padding-right:4px; height:auto; text-align:right;">
                You see the 'Register for the semester' button because your wallet balance can cover the minimum fee expected. To register for the semester, click the said button
            </div>
        </div>
        <div id="btn_div" style="display:flex; 
            flex:100%;
            height:auto; 
            margin-top:5px; 
            margin-bottom:30px;
            justify-content:flex-end;">
                <button type="submit" class="login_button" 
                    onclick="pay_reg_fee.request_id.value='';
                    pay_reg_fee.top_menu_no.value='';
                    pay_reg_fee.side_menu_no.value='';
                    pay_reg_fee.reg_sem.value='1';
                    pay_reg_fee.action='welcome_student';">Register for the semester</button>
        </div><?php
    }
    
    
    if (is_bool(strpos($cProgrammeId_loc, " DEG")) && is_bool(strpos($cProgrammeId_loc, "CHD")))
    {?>
        <div class="appl_left_child_div_child calendar_grid">
            <div id="fee_msg" class="inlin_message_color" style="flex:100%; padding-right:4px; height:auto; text-align:right;">
                Minimum amount due is as indicated below. You may enter a higher amount (if you wish) before you click the 'Initiate payment' button
            </div>
        </div><?php
    }?>

    <div class="appl_left_child_div_child calendar_grid">
        <div style="flex:15%; padding-left:4px; height:48px; background-color: #ffffff"></div>
        <div style="flex:35%; padding-left:4px; height:48px; background-color: #ffffff">
            Amount (NGN)
        </div>
        <div style="flex:50%; padding-left:4px; height:48px; background-color: #ffffff">
            <input name="amount" id="amount" type="number" style="text-align: right;"
                value="<?php echo $total;?>" required/>
        </div>
    </div><?php

    if ($NumOfRec > 0)
    {?>
        <div id="btn_div" style="display:flex; 
            flex:100%;
            height:auto; 
            margin-top:10px;
            justify-content:flex-end;">
                <button type="submit" class="login_button">Initiate payment</button>
        </div><?php
    }?>
</form>