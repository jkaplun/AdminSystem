<?php
// Includes the class
include('GetCompilationValues.class.php');
ini_set("soap.wsdl_cache_enabled", "0");

set_time_limit(0);

$training = new GetCompilationValues();

//$training->url = 'http://localhost/portal_fe/public/soap/getcompilationvalues';
$training->url = 'http://fe.icaavwin.com.mx/public/soap/getcompilationvalues';


$training->return = 'XML';  // XML or empty for array

$arrayElements = $training->API();

?>