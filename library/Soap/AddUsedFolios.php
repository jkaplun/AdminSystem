<?php
/**
 * Xml
* @author Juan Garfias V�zquez
* Create February 05, 2016
*/
Class AddUsedFolios{

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
		$getCredentials = $path->query('//AddUsedFoliosRequest', $responseElement);
		$user = $getCredentials->item(0)->getAttribute('user');
		$password = $getCredentials->item(0)->getAttribute('password');
		
		// Validate Login
		$pass = sha1($password);
		$xmlAcceso = new Model_DbTable_XmlAccess();
		$dataAccess = $xmlAcceso->getUser($user,$pass);
		
		// Making the response structure
		
		if ($dataAccess['activo'] != 1) {
			// Error 1031
			$xmlResponse = $xmlClass->XmlError(1031);
			return $xmlResponse;
		}

		$array= array('rfc'=>'','numFolios'=>'','fecha'=>'','foliosTimbrados'=>'');
		$getinfo = $path->query('//RFC', $responseElement);
		$array['rfc'] = $getinfo->item(0)->textContent;

		$getinfo = $path->query('//FoliosUsed', $responseElement);
		$array['numFolios'] = $getinfo->item(0)->textContent;
		
		$getinfo = $path->query('//FoliosTimbrados', $responseElement);
		$array['foliosTimbrados'] = $getinfo->item(0)->textContent;
		
		$getinfo = $path->query('//DateCount', $responseElement);
		$array['fecha'] = $getinfo->item(0)->textContent;
		
		$admin = new Application_Model_DbTable_StoredProcedures();
		$result = $admin->AddUsedFolios($array);

		// Making the response structure
		$xmlResponse = "<?xml version='1.0' encoding='UTF-8'?>
							<AddUsedFoliosResponse>
							<Status>".$result[0]['resultado_out']."</Status>
							<DateTime>".date('Y-m-d h:m:s')."</DateTime>
						</AddUsedFoliosResponse>";

		return  $xmlResponse;
	}
}
?>