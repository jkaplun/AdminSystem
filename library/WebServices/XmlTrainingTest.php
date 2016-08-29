<?php
// Includes the class
include('XmlTraining.class.php');
ini_set("soap.wsdl_cache_enabled", "0");

set_time_limit(0);

$training = new xmltraining();


$training->url = 'http://localhost/BeFoundation/public/soap/trainingwebservices';


$training->return = 'XML';  // XML or empty for array

$arrayElements = $training->API();

?>