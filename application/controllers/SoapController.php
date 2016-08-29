<?php
//require_once realpath(APPLICATION_PATH .'/../library/Soap/Webservice.php');

//Quitar realpath para Localhost
require_once APPLICATION_PATH .'/../library/Soap/Webservice.php';


/**
 * Travelnet
 *
 * Soap Controller
 * 
 * @category   Soap (Simple Object Access Protocol)
 * @author	   Juan Garfias 
 * @version    v 1.1
 * Create Enero 01 de 2016
 */
Class SoapController extends Zend_Controller_Action
{
    /**
     * http://example.com/Soap?wsdl
     */
	public function indexAction() {	 
     	$this->_helper->Layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender();
	    
 	    ini_set("soap.wsdl_cache_enabled", "0");
 	    if(isset($_GET['wsdl'])){
	    	//return the WSDL
	    	$this->handleWSDL();
	    } else {
	    	//handle SOAP request
 	    	$this->handleSOAP();
	    }
    }
	
	private function handleWSDL() {
		ini_set ( "soap.wsdl_cache_enabled", "0" );
		$autodiscover = new Zend_Soap_AutoDiscover ();
		$autodiscover->setClass ( 'Webservice' );
		$autodiscover->handle ();
	}
    
    private function handleSOAP() {
    	ini_set("soap.wsdl_cache_enabled", "0");
     	$wsdl_url = $this->getWSDL_URI();
     
     	$soap = new Zend_Soap_Server($wsdl_url);
    	$soap->setClass('Webservice');
    	$soap->handle();
    }

    public function getWSDL_URI() {
    	ini_set("soap.wsdl_cache_enabled", "0");
    	
    	// Calculamos la ruta del WSDL del servidor
        $WSDL_URI = sprintf('http://%s%s/soap?wsdl', $_SERVER['HTTP_HOST'], $this->view->baseUrl()); 
        
        return $WSDL_URI;
    }
                 
    public function trainingwebservicesAction() {
    
    	ini_set("soap.wsdl_cache_enabled", "0");
    	$this->_helper->Layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    
    	$xml_post = file_get_contents('php://input');
    
    	// Get WSDL URI
    	$wsdl_url = $this->getWSDL_URI();
    	$client = new Zend_Soap_Client($wsdl_url,  array('soap_version' => SOAP_1_2));
    
    	$xmlResponse = $client->trainingWebService($xml_post);
    	print_r ($xmlResponse);
    }

}