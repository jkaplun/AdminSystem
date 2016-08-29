<?php
require_once "Soap.php";
/**
* Webservice Server
*
* @author	  Juan Garfias	
* Create Enero 15, 2016
*/
Class Webservice
{
	/**
	 * Training web service
	 *
	 * @Author Juan Garfias
	 * @param string $xmlRequest
	 * @return string
	 */
	public function trainingWebService($xmlRequest) {
		require_once "XmlTraining.php";
		$xmlTraining = new XmlTraining();
		$xmlResponse = $xmlTraining->Execute($xmlRequest);
	
		return $xmlResponse;
	}
}

?>