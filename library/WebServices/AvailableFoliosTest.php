<?php
// Includes the class
include('AvailableFolios.class.php');
ini_set("soap.wsdl_cache_enabled", "0");

set_time_limit(0);

$training = new AvailableFolios();

//$training->url = 'http://localhost/portal_fe/public/soap/availablefolios';
$training->url = 'http://fe.icaavwin.com.mx/public/soap/availablefolios';


$training->return = 'XML';  // XML or empty for array

$arrayElements = $training->API();

?>