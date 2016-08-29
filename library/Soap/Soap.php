<?php
/**
 * Xml 
 * @author Juan Garfias
 * Create 15 de Enero de 2016
 */
Class Xml {
	
	/**
	* To check if the xml is valid
	* @Author Juan Garfias
	* Create: Enero 15, 2016
	*/
	public function XmlValidate($xml) {
		$resp = "";
				
		// Chek if valid xml
		$xmlLoad =  simplexml_load_string($xml );
		if($xmlLoad === FALSE){
			// error: 1021
    		$resp = $this->XmlError(1021);
		} else {
			// Is valid
			$resp = TRUE;
		}
				
		return $resp;
	}
		
	public function XmlError($error, $text) { 		 
		$xml   = "<?xml version='1.0' encoding='UTF-8'?>";
		switch($error){			 
			case 1010:
 				$text  = "Invalid Request";
				break;
 			case 1021:
 				$text  = "Invalid Xml";
				break;
 			case 1031:
 				$text  = "Access denied";
				break;
			default: 
				// 1000.- Error not found
				$error = "1000";
 		}
		
   		$xml .= "<error>";
   		$xml .= "<code>{$error}</code>";
   		$xml .= "<text>{$text}</text>";
   		$xml .= "</error>";
   		
   		return $xml;
	}
}
?>