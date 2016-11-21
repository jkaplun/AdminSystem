<?php

class AgenciasController extends Zend_Controller_Action
{

    private $agencia;
    public function init()
    {
        $this->agencia = new Application_Model_DbTable_Agencia();
        //$this->view->activemenu=4;
        /* Initialize action controller here */
    }

    public function indexAction()
    {

            $config = array('ssl' => 'ssl',
                    'auth' => 'login',
                    'port' => 465,
                    'username' => 'geremias0903@gmail.com',
                    'password' => '03089303'
                    
            );
                
            $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
                
            $mail = new Zend_Mail();
        
            $mail->setFrom($config['username'], $config['username']);
            
            $mail->addTo('pco0903@gmail.com', 'Paco');

            $mail->setSubject('Orden de compra.');
            
            $body='
                <p>Se hace de su conocimiento la solicitud de comprobante fiscal.</p>
                    <p>La referencia en el concepto es la siguiente:</p>';
            
            $mail->setBodyHtml($body);
        
            try {
                $mail->send($transport);
            } catch (Exception $e){
                
                echo $e;die;
            }
    
    
            echo 'Enviado';die;



         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/data/validacion.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/agencias/index.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/usuariosAgencias/index.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/polizas/index.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/productos/index.js');

         $agencia = new Application_Model_DbTable_Agencia();
         
         $selectAgencias = new Zend_Form_Element_Select('select_agencias');
         $this->view->agencias = $agencia->obtenerTodasLasAgencias();
         
         $listaAgencias = array();
         foreach ( $this->view->agencias as $agencias){
         	$listaAgencias[$agencias['id_agencia']]=$agencias['nombre'];
         }
         
         $zendForm = new Zend_Form();
         
         $selectAgencias
	        ->removeDecorator('label')
	        ->removeDecorator('HtmlTag')
	        ->addMultiOptions($listaAgencias)
	        ->setAttrib("class","form-control selectpicker")
	        ->setAttrib("data-max-options",10)
	        ->setAttrib("data-live-search","true")
	        ->setAttrib("title","Ingresa nombre de la agencia...")
	        ->setAttrib("autocomplete","off");
         
         $zendForm->addElement($selectAgencias);
         $this->view->selectAgencias=$zendForm;
         
         $params=$this->_request->getParams();
         $this->view->form = new Application_Form_Agencias_Agencias();
         $this->view->formUsuarioAgencia = new Application_Form_UsuariosAgencia_UsuariosAgencia();
         $this->view->formPolizas = new Application_Form_Polizas_Polizas();
         $this->view->formProductos = new Application_Form_Productos_Productos();

         $this->view->prueba = 'Llega al mensaje';
         //echo '<pre>'.print_r($agencias,true).'</pre>';die;
         
         $this->view->formFoliosAgencia = new Application_Form_Agencias_FoliosAgencia();
         
    }

    public function agregarAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
        $data = array(
            			'clave' => $params['clave'], 
                        'nombre' => $params['nombre'], 
                        'direccion' => $params['direccion'], 
                        'colonia' => $params['colonia'],
                        'cp' => $params['cp'],
                        //'clave_ciudad' => '51',
                        'tel1' => $params['tel1'],
                        'tel2' => $params['tel2'],
                        'rfc' => $params['rfc'],
                        'email' => $params['email'],
        				'email_alt' => $params['email_alt'],
                        //'http' => $params['http'],
                        //'cfdi' => $params['cfdi'],
                        //'dba_pwd' => $params['dba_pwd'],
                        //'layout_login' => $params['layout_login'],
                        //'layout_pwd' => $params['layout_pwd'],
        				//'fecha' => $params['fecha'],
        				//'observaciones' => $params['observaciones'],
        				'sucursales' => $params['sucursales'],
        				'update_login' => $params['update_login'],
        				'update_pwd' => $params['update_pwd'],
                        'iatas1' => $params['iatas1'],
                        'iatas2' => $params['iatas2'],
                        'iatas3' => $params['iatas3'],
                        'iatas4' => $params['iatas4'],
                        'iatas5' => $params['iatas5'],                    
        				//'activa_nuevos_sp' => $params['activa_nuevos_sp'],
        				//'addenda' => $params['addenda'],
        				//'ftp_add_login' => $params['ftp_add_login'],
        		     	//'ftp_add_pwd' => $params['ftp_add_pwd'],
        				//'ip_portal_fe' => $params['ip_portal_fe'],
        				//'prov_timbrado' => $params['prov_timbrado'],
        				//'facturacion_boleto' => $params['facturacion_boleto'],
        			//	'nombre_comercial' => $params['nombre_comercial'],
        				//'markup' => $params['markup'],
        				//'agencias_consolidadas' => $params['agencias_consolidadas'],
        				//'id_usuario_soporte_titular' => 1,
        				//'id_usuario_soporte_auxiliar' => 1,
                        'id_usuario_soporte_titular' => $params['id_usuario_soporte_titular'],
        				'id_usuario_soporte_auxiliar' => $params['id_usuario_soporte_auxiliar']
        );
       // echo '<pre>'.print_r($params['email'],true).'</pre>';die();
        $form = new Application_Form_Agencias_Agencias();
        $utiles = new Application_Model_Services_Utiles();
        $mensajesDeError = $form->getMessages();
        $cantidadDeErrores = count($mensajesDeError);
        if ($cantidadDeErrores == 0)
        {
        	// LEER: coment� la siguiente linea por que siempre me manda que el RFC es invalido
        	$rfcMinusculas = strtolower($params['rfc']);
        	$esRfcValido = $utiles->validarRFC($rfcMinusculas);
        	if ($esRfcValido)
        	{ // Si es RFC es v�lido
	        	$data['rfc'] = $rfcMinusculas;
	        	$esEmailCorrecto = $utiles->comprobar_email($params['email']);
	        	$esEmailAltCorrecto = true;
	        	/*if($params['email_alt'] != null)
	        	{
	        		$esEmailAltCorrecto = $utiles->comprobar_email($params['email_alt']);
	        	}
	        	else 
	        	{
	        		$esEmailAltCorrecto = true;
	        	}*/
	        	if($esEmailCorrecto)
    			//if($esEmailCorrecto)
	        	{ // si el emal es correcto:
	        		// se inserta en la base de datos a la nueva agencia
	        		$idNuevaAgencia = $this->agencia->insert($data);
	        		// se inyecta el ID, estado y descripción en la respuesta al cliente
	        		$data['id_agencia']=$idNuevaAgencia;
	        		$data['estado']='ok';
	        		$data['descripcion']='La agencia ha sido guardada exitosamente';
	        		// se responde al cliente
	        		$this->_helper->json($data);
	        		$this->_redirect('agencias/');
	        	}
	        	else
	        	{ // else cuando el email es incorrecto
	        		// se inyecta el ID, estado y descripción en la respuesta al cliente
	        		//$data['id_agencia']='0';
	        		$data['estado']='error';
	        		$data['descripcion']='Email en formato incorrecto ';
	        		// se responde al cliente
	        		$this->_helper->json($data);
	        		$this->_redirect('clientes/');
	        	}
        	}
        	else
        	{ // else cuando el formato del RFC no es correcto
        		// se inyecta el ID, estado y descripción en la respuesta al cliente
        		$data['estado']='error';
        		$data['descripcion']='RFC en formato incorrecto';
        		// se responde al cliente
        		$this->_helper->json($data);
        		$this->_redirect('clientes/');
        	}		
        }
        else
        { // else cuando existe un error encontrado en el form
        	$this->_helper->json($mensajesDeError);
        	$this->_redirect('usuarios/');
        }
    }

    public function observacionesAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
        //echo '<pre>';print_r($params);echo '</pre>';
        $idAgencia=$params['id_agencia'];
        $data['observaciones']=$params['observaciones'];
        //  se actualiza en la base de datos la clave de la p�liza
        $where = "id_agencia= {$idAgencia}";
        $this->agencia->update($data, $where);
        // se inyecta el ID, estado y descripción en la respuesta al cliente
        $data['estado']='ok';
        $data['descripcion']='El comentario ha sido actualizado exitosamente';
        $this->_helper->json($data);
    }
    
    public function actualizarAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
        //echo '<pre>'.print_r($params,true).'</pre>';die;
        
        
        $data = array(
        				'clave' => $params['clave'], 
                        'nombre' => $params['nombre'], 
                        'direccion' => $params['direccion'], 
                        'colonia' => $params['colonia'],
                        'cp' => $params['cp'],
                        //'clave_ciudad' => '51',
                        'tel1' => $params['tel1'],
                        'tel2' => $params['tel2'],
                        'rfc' => $params['rfc'],
                        'email' => $params['email'],
        				'email_alt' => $params['email_alt'],
                        //'http' => $params['http'],
                        //'cfdi' => $params['cfdi'],
                        'dba_pwd' => $params['update_pwd_bd'],
                        //'layout_login' => $params['layout_login'],
                        //'layout_pwd' => $params['layout_pwd'],
        				//'fecha' => $params['fecha'],
        				//'observaciones' => $params['observaciones'],
        				'sucursales' => $params['sucursales'],
        				'update_login' => $params['update_login'],
        				'iatas1' => $params['iatas1'],
                        'iatas2' => $params['iatas2'],
                        'iatas3' => $params['iatas3'],
                        'iatas4' => $params['iatas4'],
                        'iatas5' => $params['iatas5'],
        				//'activa_nuevos_sp' => $params['activa_nuevos_sp'],
        				//'addenda' => $params['addenda'],
        				//'ftp_add_login' => $params['ftp_add_login'],
        		     	//'ftp_add_pwd' => $params['ftp_add_pwd'],
        				//'ip_portal_fe' => $params['ip_portal_fe'],
        				//'prov_timbrado' => $params['prov_timbrado'],
        				//'facturacion_boleto' => $params['facturacion_boleto'],
        			//	'nombre_comercial' => $params['nombre_comercial'],
        				//'markup' => $params['markup'],
        				//'agencias_consolidadas' => $params['agencias_consolidadas'],
        				//'id_usuario_soporte_titular' => 1,
        				//'id_usuario_soporte_auxiliar' => 1,
                        'id_usuario_soporte_titular' => $params['id_usuario_soporte_titular'],
        				'id_usuario_soporte_auxiliar' => $params['id_usuario_soporte_auxiliar']
        );

    	$form = new Application_Form_Agencias_Agencias();
        $utiles = new Application_Model_Services_Utiles();
    	
    	$mensajesDeError = $form->getMessages();
    	$cantidadDeErrores = count($mensajesDeError);
    	if ($cantidadDeErrores == 0)
    	{
    		//$esRfcValido = $utiles->validarRFC($params['rfc']);
    		$esRfcValido = true;
    		if ($esRfcValido)
    		{ // Si es RFC es válido
    			$esEmailCorrecto = $utiles->comprobar_email($params['email']);
    			$esEmailAltCorrecto = true;
    			/*if($params['email_alt'] != null)
    			 {
    			 $esEmailAltCorrecto = $utiles->comprobar_email($params['email_alt']);
    			 }
    			 else
    			 {
    			 $esEmailAltCorrecto = true;
    			 }*/
    			if($esEmailCorrecto && $esEmailAltCorrecto)
		    	{ // si el emal es correcto:
    				$where = "id_agencia = {$params['id_agencia']}";
    				//se actualiza en la base de datos a la agencia
		    		$this->agencia->update($data, $where);
		    		$data['estado']='ok';
		    		$data['descripcion']='La agencia ha sido actualizada exitosamente';
		    		// se responde al cliente
		    		$this->_helper->json($data);
		    		$this->_redirect('clientes/');
	    		}
	    		else
	    		{ // else cuando el email es incorrecto
		    		// se inyecta el ID, estado y descripción en la respuesta al cliente
		    		$data['id_agencia']='0';
		    		$data['estado']='error';
		    		$data['descripcion']='Email en formato incorrecto';
		    		// se responde al cliente
		    		$this->_helper->json($data);
		    		$this->_redirect('clientes/');
	    		}
    		}
    		else
    		{ // else cuando el formato del RFC no es correcto
	    		// se inyecta el ID, estado y descripción en la respuesta al cliente
	    		$data['id_usuario']='0';
		    	$data['estado']='error';
	    		$data['descripcion']='RFC en formato incorrecto';
	    		// se responde al cliente
	    		$this->_helper->json($data);
	    		$this->_redirect('clientes/');
    		}
    		
    	}
    	else
    	{ // else cuando existe un error encontrado en el form
    		$this->_helper->json($mensajesDeError);
    		$this->_redirect('clientes/');
    	}
    }
        

    public function consultarAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams(); 
        $datosAgencia = $this->agencia->find($params['id_agencia'])->toArray();
        $datosAgencia[0]['update_pwd_bd'] = $datosAgencia[0]['dba_pwd'];
        
        $this->_helper->json($datosAgencia[0]);

    }

    public function agregarfoliosAction(){
    
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();

    	$params['error']='0';
    	$formFoliosAgencia = new Application_Form_Agencias_FoliosAgencia();

    	if (!$formFoliosAgencia->isValid($params)) {
    		$params = $formFoliosAgencia->getErrors();
    		$params['error']='1';
    		$this->_helper->json($params);
    	}
    	$foliosAgencia = new Application_Model_DbTable_FoliosAgencia();
    	
    	$data = array(
    			'id_agencia' => $params['id_agencia_folios'],
    			'fecha_compra' => $params['fecha_compra_folios'],
    			'folios_comprados' => $params['folios_comprados'],
    			'observaciones' => $params['observaciones_folios']
    	);
    	try {
    		$foliosAgencia->insert($data);
    	} catch (Exception $e){
    		$params['error']=$e;
    	}
    	
    	$this->_helper->json($params);
    
    }
    
    
    public function obtienefoliosagenciaAction(){
    
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	
    	$foliosAgencia = new Application_Model_DbTable_FoliosAgencia();
    	
    	$result = $foliosAgencia->obtenerFoliosPorId($params['id_agencia']);
    	$this->_helper->json($result);
    
    }
    
    
    
    public function editarfoliosAction(){
    
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    
    	$params['error']='0';
    	$formFoliosAgencia = new Application_Form_Agencias_FoliosAgencia();
    
    	if (!$formFoliosAgencia->isValid($params)) {
    		$params = $formFoliosAgencia->getErrors();
    		$params['error']='1';
    		$this->_helper->json($params);
    	}
    	$foliosAgencia = new Application_Model_DbTable_FoliosAgencia();
    	
    	$data = array(
    			'fecha_compra' => $params['fecha_compra_folios'],
    			'folios_comprados' => $params['folios_comprados'],
    			'observaciones' => $params['observaciones_folios']
    	);
    	try {
    		$where ='id_folios_agencia='.$params['id_folios_agencia_form'];
    		$foliosAgencia->update($data,$where);
    	} catch (Exception $e){
    		$params['error']=$e;
    	}
    	 
    	$this->_helper->json($params);
    
    }
}
