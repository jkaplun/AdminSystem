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
    	$params=$this->_request->getParams();
    	
    	//echo "<pre>".print_r($params,true)."</pre>";die;
    	$this->view->id_agencia = null;
    	if (isset( $params['id_agencia'] )) {
    		$this->view->id_agencia = $params['id_agencia'];
    	}
    	
    	
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/data/validacion.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/agencias/index.js?'.rand());
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/usuariosAgencias/index.js?'.rand());
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/polizas/index.js?'.rand());
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/productos/index.js?'.rand());

         $agencia = new Application_Model_DbTable_Agencia();
         
         $selectAgencias = new Zend_Form_Element_Select('select_agencias');
         $this->view->agencias = $agencia->obtenerTodasLasAgencias();
         
         $listaAgencias = array();
         
         foreach ( $this->view->agencias as $agencias){
         	$listaAgencias[$agencias['id_agencia']]=$agencias['nombre'].' ['.$agencias['clave'].']';
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
         

         $tipoPoliza = new Application_Model_DbTable_TipoPoliza();
          
         $result = $tipoPoliza->obtenerTiposPoliza();
         
         $this->view->tipoPoliza = $result;
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

        		$data['rfc'] = strtoupper($params['rfc']);
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
        { // else cuando existe un error encontrado en el form
        	$this->_helper->json($mensajesDeError);
        	$this->_redirect('usuarios/');
        }
    }

    public function observacionesAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
        $idAgencia=$params['id_agencia'];
        $data['observaciones']=$params['observaciones'];
        $data['observaciones_internas']=$params['observaciones_internas'];
        
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

        $data = array(
        				'clave' => $params['clave'], 
                        'nombre' => $params['nombre'], 
                        'direccion' => $params['direccion'], 
                        'colonia' => $params['colonia'],
                        'cp' => $params['cp'],
                        'tel1' => $params['tel1'],
                        'tel2' => $params['tel2'],
                        'rfc' => $params['rfc'],
                        'email' => $params['email'],
        				'email_alt' => $params['email_alt'],
                        'dba_pwd' => $params['update_pwd_bd'],
        				#'dba_user' => $params['update_login_bd'],
        				'sucursales' => $params['sucursales'],
        				'update_login' => $params['update_login'],
        				'update_pwd' => $params['update_pwd'],
        				'iatas1' => $params['iatas1'],
                        'iatas2' => $params['iatas2'],
                        'iatas3' => $params['iatas3'],
                        'iatas4' => $params['iatas4'],
                        'iatas5' => $params['iatas5'],
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
    			//$esEmailCorrecto = $utiles->comprobar_email($params['email']);
    			//$esEmailAltCorrecto = true;
    			/*if($params['email_alt'] != null)
    			 {
    			 $esEmailAltCorrecto = $utiles->comprobar_email($params['email_alt']);
    			 }
    			 else
    			 {
    			 $esEmailAltCorrecto = true;
    			 }*/
    			//if($esEmailCorrecto && $esEmailAltCorrecto)
		    	//{ // si el emal es correcto:
    				$where = "id_agencia = {$params['id_agencia']}";
    				//se actualiza en la base de datos a la agencia
		    		$this->agencia->update($data, $where);
		    		$data['estado']='ok';
		    		$data['descripcion']='La agencia ha sido actualizada exitosamente';
		    		// se responde al cliente
		    		$this->_helper->json($data);
		    		$this->_redirect('clientes/');
	    		//}
	    		//else
	    		//{ // else cuando el email es incorrecto
		    		// se inyecta el ID, estado y descripción en la respuesta al cliente
// 		    		$data['id_agencia']='0';
// 		    		$data['estado']='error';
// 		    		$data['descripcion']='Email en formato incorrecto';
// 		    		// se responde al cliente
// 		    		$this->_helper->json($data);
// 		    		$this->_redirect('clientes/');
	    		//}
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
        $ciudades = new Application_Model_DbTable_Ciudades();
        $ciudad = $ciudades->find($datosAgencia[0]['clave_ciudad'])->toArray();
        $datosAgencia[0]['nombre_ciudad'] = $ciudad[0]['nombre_ciudad'];
        $acd = new Application_Model_DbTable_AgenciaConexionDatos();
        
        $datosAgencia[0]['conexiones'] = $acd->fetchAll("id_agencia=".$params['id_agencia'],'id_agencia_conexion_datos')->toArray();
        
        $objProducto = new Application_Model_DbTable_Producto();
        
        foreach (  $datosAgencia[0]['conexiones'] as  $key => $value) {
        	$result = $objProducto->obtenerProductoPorId($value['id_producto']);
        	$datosAgencia[0]['conexiones'][$key]['nombre_prod'] = $result['nombre_prod'];
        }
        
        $a = new Application_Model_DbTable_Actualizaciones();
        
        $actualizaciones = $a->actualizacionesTodas($params);
        
        foreach ( $actualizaciones as &$actualizacion ){
        	
        	
        	$fecha = new Zend_Date($actualizacion['fecha_solicitud']);
        	$fechaString = $fecha->toString('d MMMM yyyy, H:m:s');
        	$actualizacion['fecha_solicitud'] = $fechaString;
        	
        	if ( $actualizacion['fecha_cierre'] == null ) {
	        	$actualizacion['fecha_cierre'] = "<span style='color: red'>Pendiente</span>";
	        	$actualizacion['http_update'] = "<span style='color: red'>Pendiente</span>";
	        	$actualizacion['nombre_usuario_cierra'] = "<span style='color: red'>Pendiente</span>";
	        	$actualizacion['path_update'] = "<span style='color: red'>Pendiente</span>";
	        	$actualizacion['version_update'] = "<span style='color: red'>Pendiente</span>";
	        	$actualizacion['archivo_update'] = "<span style='color: red'>Pendiente</span>";
	        	
        	} else {
        		$fecha = new Zend_Date( $actualizacion['fecha_cierre'] );
        		$fechaString = $fecha->toString( 'd MMMM yyyy, H:m:s' );
        		$actualizacion['fecha_cierre'] = $fechaString;
        		
        	}
        }
        
        $datosAgencia[0]['actualizaciones'] = $actualizaciones;
        
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
    	
		if ($_SESSION['Zend_Auth']['USER_VALUES']['p_agrega_folios']=='S') {
    	
	    	$data = array(
	    			'id_agencia' => $params['id_agencia_folios'],
	    			'fecha_compra' => $params['fecha_compra_folios'],
	    			'folios_comprados' => $params['folios_comprados'],
	    			'observaciones' => $params['observaciones_folios'],
	    			'id_folios_agencia_cat_tipo' => $params['id_folios_agencia_cat_tipo']
	    	);
	    	try {
	    		$foliosAgencia->insert($data);
	    	} catch (Exception $e){
	    		$params['error_log']=$e->__toString();
	    	}
		} else {
			$params['error']='Sin permisos';
		}
    	$this->_helper->json($params);
    
    }
    
    
    public function obtienefoliosagenciaAction(){
    
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	
    	$foliosAgencia = new Application_Model_DbTable_FoliosAgencia();
    	
    	$result = $foliosAgencia->obtenerFoliosPorId($params['id_agencia']);
    	
    	foreach ( $result as &$compra) {
    		$fecha = new Zend_Date($compra['fecha_compra']);
    		$fechaString = $fecha->toString('d MMMM yyyy');
    		$compra['fecha_compra'] = $fechaString;
    		$compra['folios_comprados'] = number_format( $compra['folios_comprados'] );
    		
    	}
    	
    	
    	
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
    			'observaciones' => $params['observaciones_folios'],
    			'id_folios_agencia_cat_tipo' => $params['id_folios_agencia_cat_tipo']
    	);
    	try {
    		$where ='id_folios_agencia='.$params['id_folios_agencia_form'];
    		$foliosAgencia->update($data,$where);
    	} catch (Exception $e){
    		$params['error']=$e;
    	}
    	 
    	$this->_helper->json($params);
    
    }
    
    public  function configfoliosAction(){
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	
    	$data = array(
    			//'cfdi' => $params['cfdi'],
    			'prov_timbrado' =>  $params['prov_timbrado']
    	);
    	
    	$params['success'] = true;
    	try{
			$this->agencia->update($data, "id_agencia=".$params['id_agencia']);
    	} catch (Exception $e) {
    		$params['success'] = false;
    		$params['error_log'] = $e->__toString();
    	}
	   	$this->_helper->json($params);
   }
   
   
   public function agregarDatosConexionAction(){
   	$this->_helper->layout()->disableLayout();
   	$this->_helper->viewRenderer->setNoRender();
   	$params=$this->_request->getParams();
   	
   	$params['success'] = true;
   	
   	$acd = new Application_Model_DbTable_AgenciaConexionDatos();
   	
   	$data = array(
   			"id_agencia" => $params["id_agencia"],
   			"nombre_bd" => $params["nombre_bd"],
   			"host" => $params["host"],
   			"puerto" => $params["puerto"],
   			"observaciones_conexion" => $params["observaciones_conexion"],
   			"data_source_name" => $params["data_source_name"],
   			"id_producto" => $params["id_producto"]
   	);
   	$acd->insert($data);
   	
   	$this->_helper->json($params);
   }

   public function consultarDatosConexionAction(){
	   	$this->_helper->layout()->disableLayout();
	   	$this->_helper->viewRenderer->setNoRender();
	   	$params=$this->_request->getParams();
	   	
	   	$params['success'] = true;
	   	
	   	$acd = new Application_Model_DbTable_AgenciaConexionDatos();
	   	
	   	$params['conexiones'] = $acd->fetchAll("id_agencia=".$params['id_agencia'],'id_agencia_conexion_datos')->toArray();
	   	
	   	$objProducto = new Application_Model_DbTable_Producto();
	   	
	   	foreach ( $params['conexiones']as  $key => $value) {
	   		$result = $objProducto->obtenerProductoPorId($value['id_producto']);
	   		$params['conexiones'][$key]['nombre_prod'] = $result['nombre_prod'];
	   	}
	   	
	   	$this->_helper->json($params);
   }
 
   public function eliminarDatosConexionAction(){
   	$this->_helper->layout()->disableLayout();
   	$this->_helper->viewRenderer->setNoRender();
   	$params=$this->_request->getParams();
   	
   	$params['success'] = true;
   	
   	$acd = new Application_Model_DbTable_AgenciaConexionDatos();
   	
   	$acd->delete("id_agencia_conexion_datos = ". $params['id_agencia_conexion_datos']);
   	
   	$params['conexiones'] = $acd->fetchAll("id_agencia=".$params['id_agencia'],'id_agencia_conexion_datos')->toArray();
   	
   	$objProducto = new Application_Model_DbTable_Producto();
   	
   	foreach ( $params['conexiones']as  $key => $value) {
   		$result = $objProducto->obtenerProductoPorId($value['id_producto']);
   		$params['conexiones'][$key]['nombre_prod'] = $result['nombre_prod'];
   	}
   	
   	$this->_helper->json($params);
   }
   

   public function actualizarDatosConexionAction(){
   	$this->_helper->layout()->disableLayout();
   	$this->_helper->viewRenderer->setNoRender();
   	$params=$this->_request->getParams();
   	
   	$params['success'] = true;
   	
   	$acd = new Application_Model_DbTable_AgenciaConexionDatos();
   	
   	$data = array(
   			"nombre_bd" => $params["nombre_bd"],
   			"host" => $params["host"],
   			"puerto" => $params["puerto"],
   			"observaciones_conexion" => $params["observaciones_conexion"],
   			"data_source_name" => $params["data_source_name"],
   			"id_producto" => $params["id_producto"]
   	);
   	$where = 'id_agencia_conexion_datos='.$params["id_agencia_conexion_datos"];
   	$acd->update($data, $where);
   	
   	$this->_helper->json($params);
   }
   
}
