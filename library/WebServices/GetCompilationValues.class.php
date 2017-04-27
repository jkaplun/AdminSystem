<?php
// Include code for making remote connection
require_once('XMLTransactionHanderFE.php');

/**
 * Web Service Portal FE
 * Get Compilation Values
 * The purpose of this is get the necesary values for the compilation of icaav.
 * @author Juan Garfias Vazquez
 * Create Junio 16, 2015
 * Modified:
*/
class GetCompilationValues{

	public $url			= '';		// AccountData: URL to connection
	public $username	= '';		// AccountData: UserName to login
	public $password	= '';		// AccountData: Password to login
	public $language	= '';		// Lenguage of request and the response
	public $timeOut		= 60;		// Timeout: Ensure a 5 second socket timeout to prevent lockups
		
	function XMLBodyRequest(){
		$request = "<?xml version='1.0' encoding='UTF-8'?>
  						<GetCompilationValuesRequest user='desarrollo' password='M1Gd3s4rr0y02015'>
							<ClientUser>1392b4e4ac2d753d9bb4d6c9c59878a3</ClientUser>
							<ClientPassword>6b1b51c770722f9d6e074b7b0b6cd808</ClientPassword>
						</GetCompilationValuesRequest>";
		
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