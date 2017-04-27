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
	
	/**
	 * Get configuration values for the icaav compilation.
	 *
	 * @Author Juan Garfias
	 * @param string $xmlRequest
	 * @return string
	 */
	public function getCompilationValues($xmlRequest) {
		$classNameFile='GetCompilationValues';
		require_once $classNameFile.".php";
		$webService = new $classNameFile();
		$xmlResponse = $webService->Execute($xmlRequest);
		
		return $xmlResponse;
	}
}

?>