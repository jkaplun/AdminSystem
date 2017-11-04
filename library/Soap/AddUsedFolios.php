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
		
		$xmlRequest = str_replace('IT&0002251Q9', "<![CDATA[IT&0002251Q9]]>", $xmlRequest);
		
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
		
		$xmlName = 'AddUsedFoliosRequest';
		
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