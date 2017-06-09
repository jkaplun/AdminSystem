<?php
/**
 * Xml
* @author ADR
* Create April 25, 2016
*/
Class TimestampWS{

	/**
	 * Xml Response training datas
	 * @author Juan Garfias 
	 * @param string $xmlRequest
	 */
	public function Execute($xmlRequest){
		
		// Initializing the params array to sent it to the information Hotel model
	//	$params = array();
		$xmlResponse = "";
	//	$xmlClass = new Xml();


/*		$validate = $xmlClass->XmlValidate($xmlRequest);

		if($validate !== TRUE){
			$xmlResponse = $xmlClass->XmlError(1021);
			return $xmlResponse;
		}
*/
		$xml = new DOMDocument();
		$xml->loadXML($xmlRequest);
			
		$responseElement = $xml->documentElement;
		$path = new DOMXPath($xml);

		$date = new Zend_Date();
		 
		// Output of the current timestamp
		
		// Making the response structure
		$xmlResponse = "<?xml version='1.0' encoding='UTF-8'?>
						<TimestampWSResponse>
							<DateTime>".$date->toString('yyyy-MM-dd hh:mm:ss')."</DateTime>
						</TimestampWSResponse>";

		return  $xmlResponse;
	}
}
