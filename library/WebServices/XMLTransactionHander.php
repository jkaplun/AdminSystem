<?php
/**
* XMLTransactionHander Factura Electronica
* 
* @Author Juan Garfias
* Create Date: 9/July/2014
* Modifications:
*/
Class XMLTransactionHander{
    public $XMLResponseRaw;
    public $XPath;
    public $errno; 
     
    /**
    * Attribute						Description
    * CURLOPT_URL					The URL to fetch This can also be set when initializing a session with curl_init()
    * CURLOPT_TIMEOUT				The maximum number of seconds to allow cURL functions to execute
    * CURLOPT_HEADER				TRUE to include the header in the output
    * CURLOPT_RETURNTRANSFER		TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly
    * CURLOPT_POST					TRUE to do a regular HTTP POST, This POST is the normal application/x-www-form-urlencoded kind, most commonly used by HTML forms
    * CURLOPT_POSTFIELDS			The full data to post in a HTTP "POST" operation. To post a file, prepend a filename with @ and use the full path, 
    * 								The filetype can be explicitly specified by following the filename with the type in the format ';type=mimetype', 
    * 								This parameter can either be passed as a urlencoded string like 'para1=val1&para2=val2&...' or as an array with the field name as key and field data as value, abstract, 
    * 								If value is an array, the Content-Type header will be set to multipart/form-data.
    * CURLOPT_SSL_VERIFYHOST		1 to check the existence of a common name in the SSL peer certificate, 
    * 								2 to check the existence of a common name and also verify that it matches the hostname provided, 
    * 								In production environments the value of this option should be kept at 2 (default value)
    * CURLOPT_SSLVERSION			The SSL version (2 or 3) to use, By default PHP will try to determine this itself, although in some cases this must be set manually
    * CURLOPT_FOLLOWLOCATION		TRUE to follow any "Location: " header that the server sends as part of the HTTP header (note this is recursive, PHP will follow as many 
    * 								"Location: " headers that it is sent, unless CURLOPT_MAXREDIRS is set).
    */ 
    function curlIni( $URL, $request,  $timeout ){
    	 
        // Configure headers, etc for request, IMPORTANT: MEDIA SOAP
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $URL );
        curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $request );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2);   //  with value 1 is deprecated 
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt( $ch, CURLOPT_SSLVERSION, 3 );     
	    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

		// Header to get a compressed response.  			
			 
		$httpHeader = array( 
			"Content-Type: text/xml;charset=UTF-8", 
			"Cache-Control: no-cache",
		    "Accept-Encoding:gzip, deflate",
            "Accept: text/xml",			    
 			"Pragma: no-cache", 	
		    'Connection: Keep-Alive',	          	
 			"Content-Length: ".strlen($request), 
		);
			         
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);		
		
	    return($ch);
    }
 
    /** 
	* It executes the XML request to get the information and It translates to a DOMDocument object.
	* 
	* @Author Juan Garfias
	* Last Modification:
	*/
    function executeRequest( $URL, $request,   $timeout ){
        //Configure headers
   	
        $ch = $this->curlIni( $URL, $request,  $timeout );
    	 
        //Execute request, store response and HTTP response code
        $data = curl_exec( $ch );
        $this->errno = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        
        curl_close( $ch );
        if ( $data != -1 ){
            $this->XMLResponseRaw = $data;
        }
        
        // For debugging purposes 
		// echo $this->errno; exit; 
		         
    	//Process response XML if a successful HTTP response returned
        if(  $data > '' ){
            
   	    	//Convert to a DOMDocument object, Version: 1.0, Encoding: UTF-8
            $inputDoc = new DOMDocument();
            
            // If is compressed
           	if ( substr($data, 0, 2) <> '<?' ){  
	
            	$this->XMLResponseRaw = gzinflate( substr($data, 10) );
            }
            
           	// For debugging purposes
           	//echo $this->XMLResponseRaw; exit;
                     
            $inputDoc->loadXML($this->XMLResponseRaw);
            
            return $inputDoc;
        } else {
            return NULL;
        }
    }
}
?>