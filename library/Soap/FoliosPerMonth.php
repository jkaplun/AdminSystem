<?php
/**
 * Xml
* @author Juan Garfias V�zquez
* Create February 05, 2016
*/
Class FoliosPerMonth{

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
		$getCredentials = $path->query('//FoliosPerMonthRequest', $responseElement);
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
		$array['rfc'] = $getinfo->item(0)->textContent;

		$getinfo = $path->query('//DateFrom', $responseElement);
		$array['DateFrom'] = $getinfo->item(0)->textContent;
		
		$getinfo = $path->query('//DateTo', $responseElement);
		$array['DateTo'] = $getinfo->item(0)->textContent;
		
		$admin = new Application_Model_DbTable_StoredProcedures();
		$result = $admin->FoliosPerMonth($array);
		
		// Making the response structure
		$xmlResponse = "<?xml version='1.0' encoding='UTF-8'?>";
		$xmlResponse .= "<FoliosPerMonthResponse>";
			$xmlResponse .= "<FoliosUsed>".print_r($result[0]['folios_utilizados_suma'],true)."</FoliosUsed>";
			$xmlResponse .= "<FoliosTimbrados>".print_r($result[0]['folios_timbrados_suma'],true)."</FoliosTimbrados>";
		$xmlResponse .= "</FoliosPerMonthResponse>";

		return  $xmlResponse;
	}
}
?>