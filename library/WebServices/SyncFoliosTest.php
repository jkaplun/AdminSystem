<?php
// Includes the class
include('SyncFolios.class.php');
ini_set("soap.wsdl_cache_enabled", "0");

set_time_limit(0);

$training = new SyncFolios();

$training->url = 'http://localhost/portal_fe/public/soap/syncfolios';
//$training->url = 'http://fe.icaavwin.com.mx/public/soap/syncfolios';


$training->return = 'XML';  // XML or empty for array

$arrayElements = $training->API();

?>