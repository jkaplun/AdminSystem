<?php
/**
 * Xml
* @author Juan Garfias Vázquez
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
		$params = array();
		$xmlResponse = "";
		$xmlClass = new Xml();

		$validate = $xmlClass->XmlValidate($xmlRequest);

		if($validate !== TRUE){
			//return $validate;
		}

		$xml = new DOMDocument();
		$xml->loadXML($xmlRequest);
		 
		$responseElement = $xml->documentElement;
		$path = new DOMXPath($xml);
		 
		$getinfo = $path->query('//nombre', $responseElement);
		$nombre = $getinfo->item(0)->textContent;
		
	/*	$xmlResponse = "<?xml version='1.0' encoding='UTF-8'?>\n";
		$xmlResponse .= "<TrainingResponse>\n";
		$xmlResponse.= "<nombre>$nombre</nombre>\n";
		$xmlResponse .= "</TrainingResponse>\n";
		
		return $xmlResponse; */
		// User
//		$user = $getinfo->item(0)->getAttribute('user');
		 
//		$objLanguage = $path->query('//BookingHotelRequest/Language', $responseElement);
//		$lang = $objLanguage->item(0)->textContent;
		
		
		$trainingArray['errortext']='';
		// Making the Error response structure
		if($trainingArray['errortext'] != ''){
			$xmlResponse = "<?xml version='1.0' encoding='UTF-8'?>\n";
			$xmlResponse .= "<TrainingResponse>\n";
			$xmlResponse .= "<TrainingResponse>Error prueba</TrainingResponse>\n";
			$xmlResponse .= "</TrainingResponse>";
			//return  $xmlResponse;
		}

		// Making the response structure
		$xmlResponse = "<?xml version='1.0' encoding='UTF-8'?>\n";
		$xmlResponse .= "<TrainingResponse>\n";
		$xmlResponse .= "<prueba>XML de entrenamiento a nombre de ".$nombre." El mero mero!!!!</prueba>\n";
		$xmlResponse .= "</TrainingResponse>";

		return  $xmlResponse;
	}
}
?>