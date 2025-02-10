<?php

/*if (!(isset($_REQUEST['vDesc']) && isset($_REQUEST['cEduCtgId']) && isset($_REQUEST['cEduCtgId_text']) && isset($_REQUEST['user_cat'])))
{
    if (!(isset($_REQUEST['user_cat']) || isset($_REQUEST["vApplicationNo"]) && $_REQUEST['user_cat'] == 3))
    {?>
        <div style="font-family:Verdana, Arial, Helvetica, sans-serif; 
        margin:auto; 
        text-align:center;
    	font-size: 0.78em;"> Follow <a href="../" style="text-decoration:none;">here</a></div><?php
        exit;
    }
}*/

$rem_cont_error = 0;

//$apistatus="test";

// if ((isset($_REQUEST['cEduCtgId_text']) && !is_bool(strpos($_REQUEST['cEduCtgId_text'], "$"))) || 
// (isset($_REQUEST['cEduCtgId']) && $_REQUEST['cEduCtgId'] == 'ELX'))
// {
//     $apistatus="live";
// }


$apistatus="live";

if($apistatus=="test")
{
    define("MERCHANTID", "2547916");
    define("SERVICETYPEID", "4430731");
    define("APIKEY", "1946");

    define("GATEWAYURL", "https://remitademo.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit");
    define("GATEWAYRRRPAYMENTURL", "https://remitademo.net/remita/ecomm/finalize.reg");
    define("CHECKSTATUSURL", "https://remitademo.net/remita/ecomm");

    //define("GATEWAYURL", "demo.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit");

    define("PATH", 'https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));
}elseif($apistatus=="live")
{
    define("MERCHANTID", "532216410");
    
    if (isset($_REQUEST['vDesc']) && isset($_REQUEST['cEduCtgId']) && isset($_REQUEST['cEduCtgId_text']))
    {
        if ($_REQUEST['vDesc'] == 'Application Fee')
        {
            if (isset($_REQUEST['cEduCtgId_text']) && !is_bool(strpos($_REQUEST['cEduCtgId_text'], "$")))//foreign applicant
            {
                define("SERVICETYPEID", "12918875107");
            }else if ($_REQUEST['cEduCtgId'] == 'ELX')//cert 
            {
                if (isset($_REQUEST['department']))
                {
                    if ($_REQUEST['department'] == 'ACL')
                    {
                        define("SERVICETYPEID", "12942468871");
                    }else if ($_REQUEST['department'] == 'PCC')
                    {
                        define("SERVICETYPEID", "12942334317");
                    }else if ($_REQUEST['department'] == 'PRO')
                    {
                        define("SERVICETYPEID", "12942489939");
                    }else if ($_REQUEST['department'] == 'DEG')
                    {
                        define("SERVICETYPEID", "1854576396");
                    }else
                    {
                        caution_box('Service undefined');
                        $rem_cont_error = 1;
                    }
                }else
                {
                    caution_box('Service ID not defined');
                    $rem_cont_error = 1;
                }
            }else if ($_REQUEST['amount'] == 20000 && !is_bool(strpos($_REQUEST['cEduCtgId_text'], "Master")))//cember cempa
            {
                define("SERVICETYPEID", "1854576396");
            }else if ($_REQUEST['cEduCtgId'] == 'PSZ')//UG form
            {
                define("SERVICETYPEID", "1519323399");
            }else if ($_REQUEST['cEduCtgId'] == 'PGX' || $_REQUEST['cEduCtgId'] == 'PGY' || $_REQUEST['cEduCtgId'] == 'PGZ' || $_REQUEST['cEduCtgId'] == 'PRX')//PGD, Masters, pre-odcotrate and doctorate form
            {
                define("SERVICETYPEID", "1519419057");
            }else
            {
                caution_box('Service undefined');
                $rem_cont_error = 1;
            }
        }else if ($_REQUEST['vDesc'] == 'Wallet Funding' || $_REQUEST['vDesc'] == 'Convocation Gown')
        {
            if (($_REQUEST['cEduCtgId'] == 'ELX'))//cert
            {
                if (isset($_REQUEST['department']))
                {
                    if ($_REQUEST['department'] == 'ACL')
                    {
                        define("SERVICETYPEID", "12942535623");
                    }else if ($_REQUEST['department'] == 'PCC')
                    {
                        define("SERVICETYPEID", "12942348979");
                    }else if ($_REQUEST['department'] == 'PRO')
                    {
                        define("SERVICETYPEID", "12942453679");
                    }else if ($_REQUEST['department'] == 'DEG')
                    {
                        define("SERVICETYPEID", "1854576396");
                    }else
                    {
                        caution_box('Service ID not defined');
                        $rem_cont_error = 1;
                    }
                }else
                {
                    caution_box('Service ID not defined');
                    $rem_cont_error = 1;
                }
            }else if ($_REQUEST['amount'] == 20000 && !is_bool(strpos($_REQUEST['cEduCtgId_text'], "Master")))//cember cempa
            {
                define("SERVICETYPEID", "1854576396");
            }else if (isset($cResidenceCountryId_loc) && $cResidenceCountryId_loc <> 'NG')
            {
                define("SERVICETYPEID", "12918875354");
            }else
            {
                define("SERVICETYPEID", "1519419447");
            }
        }
    }
    
    define("APIKEY", "841573");

    define("GATEWAYURL", "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit");
    define("GATEWAYRRRPAYMENTURL", "https://login.remita.net/remita/ecomm/finalize.reg");

    define("CHECKSTATUSURL", "https://login.remita.net/remita/ecomm");    
    //define("CHECKSTATUSURL","https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc");

    define("CHECKSTATUSURL_SHORT","https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/");

    
    define("PATH", 'https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));
}?>