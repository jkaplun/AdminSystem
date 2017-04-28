<?php
/**
 * Xml
* @author Juan Garfias V�zquez
* Create July 17, 2014
*/
Class AvailableFolios{

	/**
	 * Xml Response training datas
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
		
		$getCredentials = $path->query('//AvailableFoliosRequest', $responseElement);
		$user = $getCredentials->item(0)->getAttribute('user');
		$password = $getCredentials->item(0)->getAttribute('password');
		
		//$login= new Model_DbTable_XmlAccess();
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
		
		$array= array('RFC'=>'');
		$getinfo = $path->query('//RFC', $responseElement);
		$array['RFC'] = $getinfo->item(0)->textContent;

		$admin = new Application_Model_DbTable_StoredProcedures();
		$result=$admin->getAvailableFolios($array['RFC']);

		// Making the response structure
		$xmlResponse = "<?xml version='1.0' encoding='UTF-8'?>";
		$xmlResponse .= "<AvailableFoliosResponse>";
		$xmlResponse .= "<RFC>{$result[0]['rfc_cte']}</RFC>";
		$xmlResponse .= "<FoliosAssigned>{$result[0]['folios_asignados']}</FoliosAssigned>";
		$xmlResponse .= "<Foliosused>{$result[0]['folios_utilizados']}</Foliosused>";
		$xmlResponse .= "</AvailableFoliosResponse>";

		return  $xmlResponse;
	}
}
?>