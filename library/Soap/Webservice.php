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
	
	/**
	 * Get invoice values for the 'timbrado' with EDX
	 *
	 * @Author Juan Garfias
	 * @param string $xmlRequest
	 * @return string
	 */
	public function addUsedFolios($xmlRequest) {
		$classNameFile='AddUsedFolios';
		require_once $classNameFile.".php";
		$webService = new $classNameFile();
		$xmlResponse = $webService->Execute($xmlRequest);
		
		return $xmlResponse;
	}
	
	/**
	 * Get search of avaiable folios for Icaav.
	 *
	 * @Author Juan Garfias
	 * @param string $xmlRequest
	 * @return string
	 */
	public function availableFolios($xmlRequest) {
		$classNameFile='AvailableFolios';
		require_once $classNameFile.".php";
		$webService = new $classNameFile();
		$xmlResponse = $webService->Execute($xmlRequest);
		
		return $xmlResponse;
	}
	
	/**
	 * Get invoice values for the 'timbrado' with EDX
	 *
	 * @Author Juan Garfias
	 * @param string $xmlRequest
	 * @return string
	 */
	public function foliosPerMonth($xmlRequest) {
		$classNameFile='FoliosPerMonth';
		require_once $classNameFile.".php";
		$webService = new $classNameFile();
		$xmlResponse = $webService->Execute($xmlRequest);
		
		return $xmlResponse;
	}
	
	
	/**
	 * Update the number of folios used from icaav to the admin.
	 *
	 * @Author Juan Garfias
	 * @param string $xmlRequest
	 * @return string
	 */
	public function syncFolios($xmlRequest) {
		$classNameFile='SyncFolios';
		require_once $classNameFile.".php";
		$webService = new $classNameFile();
		$xmlResponse = $webService->Execute($xmlRequest);
		
		return $xmlResponse;
	}
}

?>