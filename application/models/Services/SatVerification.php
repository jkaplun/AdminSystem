<?php
/**
 * 
 * @author Juan Garfias V�zquez
 * Date 07 May 2015
 */
class Application_Model_Services_SatVerification {
	/**
	 * 
	 * @return string
	 */
	public function getTimeStamp (){
		$date = new Zend_Date();
		
		// Output of the current timestamp
		 
		// Making the response structure
		$xmlResponse = "<?xml version='1.0' encoding='UTF-8'?>
						<TimestampWSResponse>
							<DateTime>".$date->toString('yyyy-MM-dd hh:mm:ss')."</DateTime>
						</TimestampWSResponse>";
		
		return $xmlResponse;
	} 
	
	
}