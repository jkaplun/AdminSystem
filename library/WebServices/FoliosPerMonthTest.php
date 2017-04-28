<?php
// Includes the class
include('FoliosPerMonth.class.php');
ini_set("soap.wsdl_cache_enabled", "0");

set_time_limit(0);

$ws = new WSFoliosPerMonth();

$ws->url = 'http://localhost/portal_fe/public/soap/foliospermonth';
//$ws->url = 'http://fe.icaavwin.com.mx/public/soap/foliospermonth';


$ws->return = 'XML';  // XML or empty for array

$arrayElements = $ws->API();

?>