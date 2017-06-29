<?php
// Includes the class
include('VerifyFolios.class.php');
ini_set("soap.wsdl_cache_enabled", "0");

set_time_limit(0);

$ws = new WSVerifyFolios();

$ws->url = 'http://localhost/portal_fe/public/soap/verifyfolios';
//$ws->url = 'http://fe.icaavwin.com.mx/public/soap/verifyfolios';


$ws->return = 'XML';  // XML or empty for array

$arrayElements = $ws->API();

?>