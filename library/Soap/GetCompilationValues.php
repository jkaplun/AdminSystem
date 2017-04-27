<?php
/**
 * Xml
* @author Juan Garfias V�zquez
* Create July 17, 2014
*/
Class GetCompilationValues{

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
		
		$xmlName = 'GetCompilationValuesRequest';
		// Validate Login
		$getCredentials = $path->query('//'.$xmlName, $responseElement);
		$xmlAcceso = new Application_Model_DbTable_UsuarioWebService();
		$values['user'] = $getCredentials->item(0)->getAttribute('user');
		$values['pwd']= $getCredentials->item(0)->getAttribute('password');
		
		$dataAccess = $xmlAcceso->getUser($values)[0];
		
		if ($dataAccess['activo'] != 1) {
			// Error 1031
			$xmlResponse = $xmlClass->XmlError(1031);
			return $xmlResponse;
		}
		// Fin Validacion de usuario.
		
		
		$array= array('client_user'=>'','client_pasw'=>'');
		$getinfo = $path->query('//ClientUser', $responseElement);
		$array['client_user'] = $getinfo->item(0)->textContent;
		
		$getinfo = $path->query('//ClientPassword', $responseElement);
		$array['client_pasw'] = $getinfo->item(0)->textContent;
		
		$admin = new Application_Model_DbTable_StoredProcedures();
		$result = $admin->getCompilationValues($array);
		
		// Making the response structure
		$xmlResponse = "<?xml version='1.0' encoding='UTF-8'?>";
		$xmlResponse .= "<GetCompilationValuesResponse>";
				
		if(count($result[0])>0){
			$xmlResponse .= "<Status>success</Status>";
			foreach( $result[0] as $key => $value){
				$xmlResponse .= "<$key><![CDATA[".(trim($value))."]]></$key>";
			}
		} else {
			$xmlResponse.='<Status>No results</Status><Error><![CDATA['.print_r($result,true).']]></Error>';
		}
		
		$xmlResponse .= "</GetCompilationValuesResponse>";
		return  $xmlResponse;
	}
}
?>