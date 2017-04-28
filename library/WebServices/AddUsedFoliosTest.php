<?php
// Includes the class
include('AddUsedFolios.class.php');
ini_set("soap.wsdl_cache_enabled", "0");

set_time_limit(0); 

$ws = new WSAddUsedFolios();

//$ws->url = 'http://localhost/portal_fe/public/soap/addusedfolios';
$ws->url = 'http://fe.icaavwin.com.mx/public/soap/addusedfolios';


$ws->return = 'XML';  // XML or empty for array

$arrayElements = $ws->API();