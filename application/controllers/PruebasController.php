<?php

/**
 * Controlado para pruebas
 * @author Juan Garfias
 *
 */
class PruebasController extends Zend_Controller_Action
{

	public function init()
	{
		//$this->_helper->layout()->disableLayout();
	}
	
	public function indexAction()
	{
		//echo '<pre>'.print_r($_SESSION,true).'</pre>';die;
		$arrBanamexDetails['segundos_para_pago']=1550;
		$dateFromSession = new Zend_Date();
		$dateFromSession->set($_SESSION['counterdownBanamexHotel']);
		
		$minutes = $arrBanamexDetails['segundos_para_pago'] / 60;
		$seconds = $arrBanamexDetails['segundos_para_pago'] % 60;
		$this->view->minutesForPay = floor($minutes).':'.$seconds;
		
		
		
		$dateFromSession->add($arrBanamexDetails['segundos_para_pago'], Zend_Date::SECOND);
		$date = new Zend_Date();
		$timeFirst  = strtotime($dateFromSession->toString("yyyy-MM-dd H:m:s"));
		$timeSecond = strtotime($date->toString("yyyy-MM-dd H:m:s"));
		$differenceInSeconds = $timeFirst - $timeSecond;
		$this->view->secondsRemaining = $differenceInSeconds;
	}
	
	public function playAction()
	{
		$_SESSION['counterdownBanamexHotel'] = new Zend_Date();
		die;
	}
	
	public function stopAction()
	{
		//$_SESSION['counterdownBanamexHotel'] = new Zend_Date();
	}
	
	public function pauseAction()
	{
		//$_SESSION['counterdownBanamexHotel'] = new Zend_Date();
	}
	
	public function mailAction()
	{
		$email = new Application_Model_Services_Emails();
		$values = array (
			'emails' => array (
					'mmunoz@mig.com.mx' => 'mau'
								),
			'subject' => 'test',
			'body' => 'Prueba'
			);
		
		$status = $email->sendEmail($values);
		
		echo $status;
		
		die("Envío mail");
	}

}