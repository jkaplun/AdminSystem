<?php
// Include code for making remote connection
require_once('XMLTransactionHanderFE.php');

/**
 * @author Juan Garfias Vazquez.
 * Create Julio 23, 2015
 * Modified:
*/
class WSFoliosPerMonth{

	public $url			= '';		// AccountData: URL to connection
	public $username	= '';		// AccountData: UserName to login
	public $password	= '';		// AccountData: Password to login
	public $language	= '';		// Lenguage of request and the response
	public $timeOut		= 60;		// Timeout: Ensure a 5 second socket timeout to prevent lockups
		
	function XMLBodyRequest(){
		$request = "<?xml version='1.0' encoding='UTF-8'?>\n";
		$request .= "<FoliosPerMonthRequest  user='desarrollo' password='M1Gd3s4rr0y02015'>
						<RFC>BVI080520SG7</RFC>
						<DateFrom>2016-02-01</DateFrom>
						<DateTo>2016-02-29</DateTo>
					</FoliosPerMonthRequest>";

		//header ("Content-Type:text/xml");echo "$request";die;
		return $request;
	}

	function API(){
		//Create request body
		$XMLRequest = $this->XMLBodyRequest();

		$trans = new XMLTransactionHanderFE();
		//echo "<pre>".$this->url."</pre><hr/>";
		//echo "<pre>".$XMLRequest."</pre><hr/>";
		//echo "<pre>".$this->timeOut."</pre><hr/>";
		
		//Process Request
		$responseDoc = $trans->executeRequest( $this->url, $XMLRequest, $this->timeOut );
		 
		/**For debugging purposes*/
		header ("Content-Type:text/xml");echo $responseDoc->SaveXML(); exit;


		return  ;
	}
		
}