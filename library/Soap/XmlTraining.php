<?php
/**
 * Xml
* @author Juan Garfias V�zquez
* Create July 17, 2014
*/
Class XmlTraining{

	/**
	 * Xml Response training datas
	 * @author Juan Garfias 
	 * @param string $xmlRequest
	 */
	public function Execute($xmlRequest){
		
		// Initializing the params array to sent it to the information Hotel model
		$xmlResponse = "";
		$xmlClass = new Xml();
		$validate = $xmlClass->XmlValidate($xmlRequest);

		$xml = new DOMDocument();
		$xml->loadXML($xmlRequest);
		
		$responseElement = $xml->documentElement;
		$path = new DOMXPath($xml);
		$values = array();
		$xmlAcceso = new Application_Model_DbTable_UsuarioWebService();
		
		$getCredentials = $path->query('//XmlTrainingRequest', $responseElement);

		// Validate Login
		$values['user'] = $getCredentials->item(0)->getAttribute('user');
		$values['pwd']= $getCredentials->item(0)->getAttribute('password');

		$dataAccess = $xmlAcceso->getUser($values)[0];
		
		if ($dataAccess['activo'] != 1) {
			// Error 1031
			$xmlResponse = $xmlClass->XmlError(1031);
			return $xmlResponse;
		}
		// Fin Validacion de usuario.
		
		$getinfo = $path->query('//nombre', $responseElement);
		$nombre = $getinfo->item(0)->textContent;

		// Making the response structure
		$xmlResponse = "<?xml version='1.0' encoding='UTF-8'?>
							<TrainingResponse>
							<prueba>XML de entrenamiento a nombresito de ".$nombre." El mero mero!!!!</prueba>
						</TrainingResponse>";

		return  $xmlResponse;
	}
}