<?php
/**
 * Xml
* @author Juan Garfias V�zquez
* Create July 17, 2014
*/
Class SyncFolios{

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
		
		$xmlName = 'SyncFoliosRequest';
		
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

		$array= array('rfc'=>'','folios_utilizados'=>0);
		$getinfo = $path->query('//RFC', $responseElement);
		$array['rfc'] = $getinfo->item(0)->textContent;
		
		$getinfo = $path->query('//FoliosUsed', $responseElement);
		$array['folios_utilizados'] = $getinfo->item(0)->textContent;
		
		$admin = new Application_Model_DbTable_StoredProcedures();
		$result = $admin->SyncFoliosFromIcaav($array);
		
		// Making the response structure
		$xmlResponse = "<?xml version='1.0' encoding='UTF-8'?>";
		$xmlResponse .= "<SyncFolios>";
			$xmlResponse .= "<Status>{$result[0]['status']}</Status>";
			if($result[0]['status']==0){
				$xmlResponse .= "<Description>Ya ha sido sincronizado anteriormente.</Description>";
			} else {
				$xmlResponse .= "<Description>Sincronizado correctamente.</Description>";
			}
		$xmlResponse .= "</SyncFolios>";
		return  $xmlResponse;
		
	}
}
?>