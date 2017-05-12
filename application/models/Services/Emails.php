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
		
		$config = array('auth' => 'login',
			'username' => $this->emailConfig['email'],
			'password' => $this->emailConfig['password'],
			'port' => $this->emailConfig['port'],
		);
		
		$transport = new Zend_Mail_Transport_Smtp($this->emailConfig['smtp'], $config);
		
		$mail = new Zend_Mail();
		
		$mail->setFrom($this->emailConfig['email'], $this->emailConfig['nombre_comercial']);
		
		foreach ($values['emails'] as $key => $email){
			$mail->addTo($key, $email);
		}
		$mail->setSubject($values['subject']);
		
		$mail->setBodyHtml($values['body']);
		
		try {
			$mail->send($transport);
		} catch (Exception $e){
			echo $e;
			return 'No Enviado';
		}
		
		return 'Enviado';
		
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
		
		$agenciaDatos = $agencia->find($values['id_agencia'])->toArray()[0];
		$usuarioAdminDatos = $usuarioAdmin->find($values['id_usuario_admin_atiende'])->toArray()[0];
		$agenciaUsuarioDatos = $agenciaUsuario->find($values['id_usuario_agencia_solicito'])->toArray()[0];
		
		$body="Admin V2 <br>
<h1>Prueba Nueva orden de servicio.</h1>
 <p>Se ha creado nueva Orden de Servicio.</p>";
		
		$valuesDos = array(
				'subject' => 'Nueva Orden de Servicio.',
				'body' => $body
		);
		
		$valuesDos['emails'][$agenciaDatos['email']] = utf8_decode($agenciaDatos['nombre']);
		$valuesDos['emails'][$usuarioAdminDatos['email']] = utf8_decode($usuarioAdminDatos['nombre'].' '.$usuarioAdminDatos['apellido_paterno']);
		$valuesDos['emails'][$agenciaUsuarioDatos['email']] =  utf8_decode($agenciaUsuarioDatos['nombre'].' '.$agenciaUsuarioDatos['apellidos']);
		
		$this->sendEmail($valuesDos);
		
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
		
		$body="Admin V2 <br>
<h1>Prueba Cierre orden de servicio.</h1>
 <p>Se ha cerrado la Orden de Servicio.</p>";
		
		$valuesDos = array(
				'subject' => 'Cierre de Orden de Servicio.',
				'body' => $body
		);
		
		$valuesDos['emails'][$agenciaDatos['email']] = utf8_decode($agenciaDatos['nombre']);
		$valuesDos['emails'][$usuarioAdminDatos['email']] = utf8_decode($usuarioAdminDatos['nombre'].' '.$usuarioAdminDatos['apellido_paterno']);
		$valuesDos['emails'][$agenciaUsuarioDatos['email']] =  utf8_decode($agenciaUsuarioDatos['nombre'].' '.$agenciaUsuarioDatos['apellidos']);
		
		$this->sendEmail($valuesDos);
		
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
		
		foreach ( $usuarios as $values){
			$valuesDos['emails'][$values['email']] = utf8_decode($values['nombre'].' '.$values['apellido_paterno']);
		}

		$this->sendEmail($valuesDos);
		
	}
	
	
	
}