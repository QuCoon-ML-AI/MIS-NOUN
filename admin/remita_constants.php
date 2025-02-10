<?php

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
    
    define("APIKEY", "841573");

    define("GATEWAYURL", "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit");
    define("GATEWAYRRRPAYMENTURL", "https://login.remita.net/remita/ecomm/finalize.reg");

    define("CHECKSTATUSURL", "https://login.remita.net/remita/ecomm");    
    //define("CHECKSTATUSURL","https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc");

    define("CHECKSTATUSURL_SHORT","https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/");

    
    define("PATH", 'https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));
}?>