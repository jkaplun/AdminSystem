<?php
class Application_Model_Services_Emails {

	public static function emailAuthirizedPurchaseOrder($values){
		
		
		if( trim($values['email'] ) != '' ){
			$config = array('auth' => 'login',
					'username' => 'jgarfias@mig.com.mx',
					'password' => 'ThinkCentre',
					'port' => 26
			);
				
			
			
			$transport = new Zend_Mail_Transport_Smtp('mail.mig.com.mx', $config);
				
			$mail = new Zend_Mail();
		
			$mail->setFrom($config['username'], $config['username']);
			/*
			 $mail->addTo('jgarfias@mig.com.mx', 'MAs MEjor')
			->addTo('pmadrigal@travelnet.com.mx', 'Pambaza')
			->addTo('ing.juan.garfias@gmail.com', 'Juanin Juan Jarry');*/
			$mail->addTo($values['email'], $values['denominacion']);
			$mail->setSubject('Orden de compra.');
			/*
			$mail->createAttachment($xmlRQ,
					'application/xml',
					Zend_Mime::TYPE_TEXT,Zend_Mime::TYPE_TEXT,$nameWS.'_RQ_'.date('l jS \of F Y h:i:s A').'.xml');
			$mail->createAttachment($xmlRS,
					'application/xml',
					Zend_Mime::TYPE_TEXT,Zend_Mime::TYPE_TEXT,$nameWS.'_RS_'.date('l jS \of F Y h:i:s A').'.xml');
			$mail->setBodyText('This is the text of the mail.');
			*/
			
			$body='
				<p>Se hace de su conocimiento la solicitud de comprobante fiscal.</p>
					<p>La referencia en el concepto es la siguiente:</p>
					
					<p>Detalle de la Orden : '.$values['descripcion'].'</p>
					
					<p>
					<b>Clave de Orden de Compra : '.$values['referencia'].'</b>
					</p>
												
							
					
					<p>Por el monto de : $ '.number_format($values['monto'],2).'</p>
					<p>Con fecha programada de pago : '.substr($values['fecha_programacion_pago'],0,10).'</p>
							
				<p>Debe ingresar el texto completo en letras negritas para que pueda ser registrada por el sistema.</p>
					';
			
			$mail->setBodyHtml($body);
		
			try {
				$mail->send($transport);
			} catch (Exception $e){
				
				return 'No Enviado';
			}
	
	
			return 'Enviado';
		} else {
			return 'No Enviado';
		}
	}
	
}