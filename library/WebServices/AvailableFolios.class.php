<?php
// Include code for making remote connection
require_once('XMLTransactionHanderFE.php');

/**
 * Web Service Portal FE
 * Available Folios
 * Consult the availability of folios for ICAAV
 * @author Juan Garfias Vazquez
 * Create Junio 16, 2015
 * Modified:
*/
class AvailableFolios{

	public $url			= '';		// AccountData: URL to connection
	public $username	= '';		// AccountData: UserName to login
	public $password	= '';		// AccountData: Password to login
	public $language	= '';		// Lenguage of request and the response
	public $timeOut		= 60;		// Timeout: Ensure a 5 second socket timeout to prevent lockups
		
	function XMLBodyRequest(){
		$request = "<?xml version='1.0' encoding='UTF-8'?>";
		$request .= "<AvailableFoliosRequest user='desarrollo' password='M1Gd3s4rr0y02015'>";
		$request .= "<RFC>TTV0812107N4</RFC>";
		$request .= "</AvailableFoliosRequest>";
		
		/**For debugging purposes*/
		//header ("Content-Type:text/xml");echo "$request";die;
		
		return $request;
	}

	function API(){
		//Create request body
		$XMLRequest = $this->XMLBodyRequest();

		$trans = new XMLTransactionHanderFE();

		//Process Request
		$responseDoc = $trans->executeRequest( $this->url, $XMLRequest, $this->timeOut );
		 
		/**For debugging purposes*/
		header ("Content-Type:text/xml");
		echo $responseDoc->SaveXML(); exit;


		return  ;
	}
		
}