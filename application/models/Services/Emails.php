<?php
class Application_Model_Services_Emails {
	
	public $emailConfig = array();

	
	public function __construct() {
		$string = file_get_contents('properties.txt', true);
		$preArray =  explode("\n", $string);
		
		
		foreach ( $preArray as $value ){
			$aux = explode("=", $value);
			if (trim($aux[0])=='email') {
				$this->emailConfig['email'] = trim($aux[1]);
			}
			if (trim($aux[0])=='password') {
				$this->emailConfig['password'] = trim($aux[1]);
			}
			if (trim($aux[0])=='smtp') {
				$this->emailConfig['smtp'] = trim($aux[1]);
			}
			if (trim($aux[0])=='port') {
				$this->emailConfig['port'] = trim($aux[1]);
			}
			if (trim($aux[0])=='nombre_comercial') {
				$this->emailConfig['nombre_comercial'] = trim($aux[1]);
			}
		}

	}
	
	/**
	 * 
	 * @param array $values = array (
	 *	'emails' => array (
	 *					mail1@mail.com => mail1 ,
	 *					mail2@mail.com => mail2 ,
	 *					mail3@mail.com => mail3 ,
								.
	 *							.
	 *							.
	 *					mailn@mail.com => mailn ,
	 *						)
	 *	'subject' => subject
	 *	'body' => body
	 *	);
	 * @return string
	 */
	public function sendEmail($values){
		$errorConfig = false;
		$config = array('auth' => 'login',
			'username' => $this->emailConfig['email'],
			'password' => $this->emailConfig['password'],
			'port' => $this->emailConfig['port'],
		);
		try { 
			$transport = new Zend_Mail_Transport_Smtp($this->emailConfig['smtp'], $config);
		} catch (Exception $e) {
			$errorConfig =true;
			return 'No Enviado';
		}

		if ( $errorConfig == false ) {
		
			$mail = new Zend_Mail();
			
			$mail->setFrom($this->emailConfig['email'], $this->emailConfig['nombre_comercial']);
			
			foreach ($values['emails'] as $key => $email){
				if ($key!=''){
					if($email=='') {
						$email=$key;
					}
					$mail->addTo($key, $email);
				}
			}
			$mail->setSubject($values['subject']);
			$mail->setBodyHtml($values['body']);
			
			try {
				$mail->send($transport);
			} catch (Exception $e){
				//echo $e;
				return 'No Enviado';
			}
			
			return 'Enviado';
		} else {
			return 'No Enviado';
		}
	}
	
	/**
	 * 
	 * @param unknown $values
	 * @return number
	 */
	public function agregarOrdenServicio($values){
		
		$agencia = new Application_Model_DbTable_Agencia();
		$usuarioAdmin = new Application_Model_DbTable_UsuarioAdmin();
		$agenciaUsuario = new Application_Model_DbTable_AgenciaUsuario();
		$ordenServicioEstatus = new Application_Model_DbTable_OrdenServicioEstatus();
		
		$agenciaDatos = $agencia->find($values['id_agencia'])->toArray()[0];
		$usuarioAdminDatos = $usuarioAdmin->find($values['id_usuario_admin_atiende'])->toArray()[0];
		$agenciaUsuarioDatos = $agenciaUsuario->find($values['id_usuario_agencia_solicito'])->toArray()[0];
		$estatusDesc = $ordenServicioEstatus->find($values['id_orden_servicio_estatus'])->toArray()[0];
		
		
		if(trim($values['solicito_otro'])!=''){
			
		}
		
		$bodyCSS = $this->bodyStyleCSS();
		
		$body = "
		<h1>Nueva orden de servicio.</h1>
		<p>Agencia: <b>".utf8_decode($agenciaDatos['nombre']).".</b></p>
 		<p>Se ha creado nueva Orden de Servicio solicitada por: <b>".utf8_decode($agenciaUsuarioDatos['nombre'])." ".utf8_decode($agenciaUsuarioDatos['apellidos']).".</b></p>
 		<p>Su llamada est&aacute;: <b>".utf8_decode($estatusDesc['descripcion']).".</b> </p>

		<p>Saludos Cordiales.</p>";

		$bodyFooter = $this->bodyFooterHTML();
		
		$valuesDos = array(
				'subject' => 'Nueva Orden de Servicio.',
				'body' => $bodyCSS.$body.$bodyFooter
		);
		
		
		$domain = strpos(strtolower($agenciaDatos['nombre']), 'travelnet');
		
		if ($domain==''){
			$valuesDos['emails'][$agenciaDatos['email']] = utf8_decode($agenciaDatos['nombre']);
			$valuesDos['emails'][$agenciaUsuarioDatos['email']] =  utf8_decode($agenciaUsuarioDatos['nombre'].' '.$agenciaUsuarioDatos['apellidos']);
		}
		
		$valuesDos['emails'][$usuarioAdminDatos['email']] = utf8_decode($usuarioAdminDatos['nombre'].' '.$usuarioAdminDatos['apellido_paterno']);

		if ($usuarioAdminDatos['mail_new_orden']=='S') {
			$this->sendEmail($valuesDos);
		}
		
		
	}
	
	public function bodyFooterHTML(){
		
		$fc = Zend_Controller_Front::getInstance();
		$tarjetaPresentacion = '<img height="225" width="384" src="http://'.$_SERVER['SERVER_NAME'].$fc->getBaseUrl().'/img/mail/departamento-de-soporte.png" alt="Departamento de Soporte" height="42" width="42">';
		$bodyFooter =utf8_decode("
				<br>
				$tarjetaPresentacion
				<br/>
				<p class='texto-azul'>
				AVISO DE CONFIDENCIALIDAD.- Este correo electrónico, y los archivos adjuntos son de carácter estrictamente confidencial de conformidad con las leyes aplicables y de uso exclusivo del destinatario.
				En el caso de recibir información que no es del legítimo destinatario, repórtelo al remitente y elimínelo de inmediato. Queda expresamente prohibido la divulgación, retrasmisión y divulgación de la información de terceros.
				</p>
				<p class='texto-azul'>
				PROTECCIÓN DE DATOS PERSONALES
				Aviso de privacidad en cumplimiento de lo dispuesto en el artículo 15 de la Ley Federal de Protección de Datos personales, que estén en resguardo de Microinformática Gerencial, S.A.  de C.V. derivados de la celebración
				de un contrato, quedarán asegurados y no se trasmitirán a terceros, vea el aviso de privacidad en www.mig.com.mx
				</p>");
		return $bodyFooter;
		
	}
	
	public function bodyStyleCSS(){
		return "<style>
		h1 {
 			font-family: 'Arial', Verdana, Sans-serif;
			color:#1F497D;
		}
		p {
 			font-family: 'Arial', Verdana, Sans-serif;
			color:#1F497D;
		}
		.texto-azul{
			font-size:8.0pt;
			font-family:'Arial Unicode MS','sans-serif';
			color:#1F497D;
			mso-fareast-language:ES-MX'
		}
				</style>";
	}
	
	/**
	 *
	 * @param unknown $values
	 * @return number
	 */
	public function cerrarOrdenServicio($values){

		$agencia = new Application_Model_DbTable_Agencia();
		$usuarioAdmin = new Application_Model_DbTable_UsuarioAdmin();
		$agenciaUsuario = new Application_Model_DbTable_AgenciaUsuario();
		
		$agenciaDatos = $agencia->find($values['id_agencia'])->toArray()[0];
		$usuarioAdminDatos = $usuarioAdmin->find($values['id_usuario_admin_atiende'])->toArray()[0];
		$agenciaUsuarioDatos = $agenciaUsuario->find($values['id_usuario_agencia_solicito'])->toArray()[0];
		
		$bodyCSS = $this->bodyStyleCSS();
		
		$body = "
		<h1>Cierre Orden de Servicio.</h1>
		<p>Agencia: <b>".utf8_decode($agenciaDatos['nombre'])."</b></p>
		<p>Se ha cerrado Orden de Servicio solicitada por: <b>".utf8_decode($agenciaUsuarioDatos['nombre'])." ".utf8_decode($agenciaUsuarioDatos['apellidos']).".</b></p>
				
		<p>Saludos Cordiales.</p>";
		
		$bodyFooter = $this->bodyFooterHTML();
		
		$valuesDos = array(
				'subject' => 'Cierre Orden de Servicio.',
				'body' => $bodyCSS.$body.$bodyFooter
		);
		
		$domain = strpos(strtolower($agenciaDatos['nombre']), 'travelnet');
		
		if ($domain==''){
			$valuesDos['emails'][$agenciaDatos['email']] = utf8_decode($agenciaDatos['nombre']);
			$valuesDos['emails'][$agenciaUsuarioDatos['email']] =  utf8_decode($agenciaUsuarioDatos['nombre'].' '.$agenciaUsuarioDatos['apellidos']);
		}
		
		$valuesDos['emails'][$usuarioAdminDatos['email']] = utf8_decode($usuarioAdminDatos['nombre'].' '.$usuarioAdminDatos['apellido_paterno']);
		
		if ($usuarioAdminDatos['mail_new_orden']=='S') {
			$this->sendEmail($valuesDos);
		}
	}

	/**
	 *
	 * @param unknown $values
	 * @return number
	 */
	public function altaPoliza($values){
		
		$agencia = new Application_Model_DbTable_Agencia();
		$usuarioAdmin = new Application_Model_DbTable_UsuarioAdmin();

		
		$agenciaDatos = $agencia->find($values['id_agencia'])->toArray()[0];

		$where = 'id_usuario_admin_puesto=10';
		$usuarios = $usuarioAdmin->fetchAll($where)->toArray();
		
		$body="Admin V2 <br>
				<h1>Prueba Alta de poliza.</h1>
 				<p>Se ha creado una poliza de servicio.</p>";
		
		$valuesDos = array(
				'subject' => 'Alta de Poliza de Servicio',
				'body' => $body
		);
		
		if (count($usuarios)>0){
			foreach ( $usuarios as $values){
				$valuesDos['emails'][$values['email']] = utf8_decode($values['nombre'].' '.$values['apellido_paterno']);
			}

			$this->sendEmail($valuesDos);
		}
		
	}
	
	
	public function agregarPoliza($values){
		$agencia = new Application_Model_DbTable_Agencia();
		$usuarioAdmin = new Application_Model_DbTable_UsuarioAdmin();

		$tipoPoliza = new Application_Model_DbTable_TipoPoliza();
		
		$tipoDesc = $tipoPoliza->fetchRow("tipo='{$values['tipo']}'");
		
		$agenciaDatos = $agencia->find($values['id_agencia'])->toArray()[0];
		$usuarioAdminDatos = $usuarioAdmin->find($_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'])->toArray()[0];
		$usuarioAdminDatosTitular = $usuarioAdmin->find( $agenciaDatos['id_usuario_soporte_titular'] )->toArray()[0];
		
		
		$bodyCSS = $this->bodyStyleCSS();
		
		
		$body = "
		<h1>Se ha dado de alta una nueva poliza.</h1>
		<p>Agencia: <b>".utf8_decode($agenciaDatos['nombre']).".</b></p>
		<p>Horas: <b>{$values['horas_poliza']}.</b></p>
		<p>Fecha Inicial: <b>{$values['fecha_ini']}.</b></p>
		<p>Fecha Final: <b>{$values['fecha_fin']}.</b></p>
		<p>Tipo: <b>".utf8_decode($tipoDesc['descripcion'])."</b></p>
		
		<p>Saludos Cordiales.</p>";
		
		$bodyFooter = $this->bodyFooterHTML();
		
		$valuesDos = array(
				'subject' => 'Alta de Nueva Poliza.',
				'body' => $bodyCSS.$body.$bodyFooter
		);
		
		//$valuesDos['emails'][$agenciaDatos['email']] = utf8_decode($agenciaDatos['nombre']);
		$valuesDos['emails'][$usuarioAdminDatos['email']] = utf8_decode($usuarioAdminDatos['nombre'].' '.$usuarioAdminDatos['apellido_paterno']);
		
		if ($usuarioAdminDatosTitular['email']!='') {
			$valuesDos['emails'][$usuarioAdminDatosTitular['email']] = utf8_decode($usuarioAdminDatosTitular['nombre'].' '.$usuarioAdminDatosTitular['apellido_paterno']);
		}
		
		
		$where = 'mail_add_poliza="S"';
		$usuarios = $usuarioAdmin->fetchAll($where)->toArray();
		
		
		if (count($usuarios)>0){
			foreach ( $usuarios as $values){
				$valuesDos['emails'][$values['email']] = utf8_decode($values['nombre'].' '.$values['apellido_paterno']);
			}
		}
		
		
		
		
		return $this->sendEmail($valuesDos);
	}
	

	public function agregarFolios($values){
		$agencia = new Application_Model_DbTable_Agencia();
		$usuarioAdmin = new Application_Model_DbTable_UsuarioAdmin();
		
		$agenciaDatos = $agencia->find($values['id_agencia'])->toArray()[0];
		$usuarioAdminDatos = $usuarioAdmin->find($_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'])->toArray()[0];
		$usuarioAdminDatosTitular = $usuarioAdmin->find( $agenciaDatos['id_usuario_soporte_titular'] )->toArray()[0];
		
		
		$bodyCSS = $this->bodyStyleCSS();
		
		$body = "
		<h1>Se han Registrado Nuevos Folios.</h1>
		<p>Agencia: <b>".utf8_decode($agenciaDatos['nombre']).".</b></p>
		<p>N&uacute;mero de Folios: <b>".$values['folios_comprados'].".</b></p>
		<p>Fecha de Compra: <b>".$values['fecha_compra'].".</b></p>
		<p>Observaciones: <b>".$values['observaciones'].".</b></p>
		<p>Tipo: <b>".(($values['id_folios_agencia_cat_tipo']==2)?'Nomina':'Icaav')."</b></p>
				
		<p>Saludos Cordiales.</p>";
		
		$bodyFooter = $this->bodyFooterHTML();
		
		$valuesDos = array(
				'subject' => 'Registro de Folios.',
				'body' => $bodyCSS.$body.$bodyFooter
		);

		if ($usuarioAdminDatosTitular['email']!='') {
			$valuesDos['emails'][$usuarioAdminDatosTitular['email']] = utf8_decode($usuarioAdminDatosTitular['nombre'].' '.$usuarioAdminDatosTitular['apellido_paterno']);
		}
		
		
		$where = 'mail_add_folios="S"';
		$usuarios = $usuarioAdmin->fetchAll($where)->toArray();
		
		$valuesDos['emails'][$usuarioAdminDatos['email']] = utf8_decode($usuarioAdminDatos['nombre'].' '.$usuarioAdminDatos['apellido_paterno']);
		
		if (count($usuarios)>0){
			foreach ( $usuarios as $values){
				$valuesDos['emails'][$values['email']] = utf8_decode($values['nombre'].' '.$values['apellido_paterno']);
			}
		}
		
		return $this->sendEmail($valuesDos);
		
	}

	public function registrarActualizacion($values){
		$agencia = new Application_Model_DbTable_Agencia();
		$usuarioAdmin = new Application_Model_DbTable_UsuarioAdmin();
		
		$agenciaDatos = $agencia->find($values['id_agencia'])->toArray()[0];
		$usuarioAdminDatos = $usuarioAdmin->find($_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'])->toArray()[0];
		$usuarioAdminDatosTitular = $usuarioAdmin->find( $agenciaDatos['id_usuario_soporte_titular'] )->toArray()[0];
		
		$bodyCSS = $this->bodyStyleCSS();

		$body = "
		<h1>Se ha Registrado una Actualizaci&oacute;n.</h1>
		<p>Agencia: <b>".utf8_decode($agenciaDatos['nombre']).".</b></p>
		<p>Nombre del Archivo: <b>".utf8_decode($values['archivo_update']).".</b></p>
		<p>HTTP: <b>".utf8_decode($values['http_update']).".</b></p>				
		<p>Saludos Cordiales.</p>";
		
		$bodyFooter = $this->bodyFooterHTML();
		
		$valuesDos = array(
				'subject' => utf8_decode('Registro de Actualización.'),
				'body' => $bodyCSS.$body.$bodyFooter
		);
		
		if ($usuarioAdminDatosTitular['email']!='') {
			$valuesDos['emails'][$usuarioAdminDatosTitular['email']] = utf8_decode($usuarioAdminDatosTitular['nombre'].' '.$usuarioAdminDatosTitular['apellido_paterno']);
		}
		
		$valuesDos['emails'][$usuarioAdminDatos['email']] = utf8_decode($usuarioAdminDatos['nombre'].' '.$usuarioAdminDatos['apellido_paterno']);
		
		return $this->sendEmail($valuesDos);
		
	}
	
}