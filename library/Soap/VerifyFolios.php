<?php
/**
 * Xml
* @author Juan Garfias V�zquez
* Create February 05, 2016
*/
Class VerifyFolios{

	/**
	 * Xml Response
	 * @author Juan Garfias 
	 * @param string $xmlRequest
	 */
	public function Execute($xmlRequest){
		
		// Initializing the params array to sent it to the information Hotel model
		$params = array();
		$xmlResponse = "";
		$xmlClass = new Xml();

		$validate = $xmlClass->XmlValidate($xmlRequest);

		if($validate !== TRUE){
			$xmlResponse = $xmlClass->XmlError(1021);
			return $xmlResponse;
		}

		$xml = new DOMDocument();
		$xml->loadXML($xmlRequest);
		 
		$responseElement = $xml->documentElement;
		$path = new DOMXPath($xml);
		
		$xmlName = 'VerifyFoliosRequest';
		
		// Validate Login
		$getCredentials = $path->query('//'.$xmlName, $responseElement);
		$xmlAcceso = new Application_Model_DbTable_UsuarioWebService();
		$values['user'] = $getCredentials->item(0)->getAttribute('user');
		$values['pwd']= $getCredentials->item(0)->getAttribute('password');
		
		$dataAccess = $xmlAcceso->getUser($values)[0];
		
		// Making the response structure
		
		if ($dataAccess['activo'] != 1) {
			// Error 1031
			$xmlResponse = $xmlClass->XmlError(1031);
			return $xmlResponse;
		}

		$array= array('rfc'=>'','numFolios'=>'','fecha'=>'');
		$getinfo = $path->query('//RFC', $responseElement);
		$array['rfc'] = $getinfo->item(0)->textContent;
		
		$admin = new Application_Model_DbTable_Admin();
		$result = $admin->VerifyFolios($array);

		// Making the response structure
		$xmlResponse = "<?xml version='1.0' encoding='UTF-8'?>
							<VerifyFoliosResponse>
								<PurchasedFolios>{$result[0]['suma_folios_comprados']}</PurchasedFolios>
								<LastUpdatedFolios>{$result[0]['fecha_actualizacion_folios']}</LastUpdatedFolios>
								<SumFoliosUsed>{$result[0]['suma_folios_utilizados']}</SumFoliosUsed>
								<SumFoliosTimbrados>{$result[0]['suma_folios_timbrados']}</SumFoliosTimbrados>
						</VerifyFoliosResponse>";

		return  $xmlResponse;
	}
}
