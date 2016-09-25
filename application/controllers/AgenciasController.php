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
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/agencias/index.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');
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
	        ->setAttrib("title","Choose one of the following...")
	        ->setAttrib("autocomplete","off");
         
         $zendForm->addElement($selectAgencias);
         $this->view->selectAgencias=$zendForm;
         
         $params=$this->_request->getParams();
         $this->view->form = new Application_Form_Agencias_Agencias();
  
         $this->view->prueba = 'Llega al mensaje';
         //echo '<pre>'.print_r($agencias,true).'</pre>';die;
    }

    public function agregarAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();

        $data = array(
                        'clave' => $params['clave'], 
                        'nombre' => $params['nombre'], 
                        'direccion' => $params['direccion'], 
                        'colonia' => $params['colonia'],
                        'cp' => $params['cp'],
                        //'clave_ciudad' => $params['clave_ciudad'],
                        'tel1' => $params['tel1'],
                        'tel2' => $params['tel2'],
                        'rfc' => $params['rfc'],
                        'email' => $params['email'],
                        'http' => $params['http'],
                        'lic_icaavwin' => $params['lic_icaavwin'],
                        'lic_iriswin' => $params['lic_iriswin'],
                        'lic_gvc' => $params['lic_gvc'],
                        'lic_centauro' => $params['lic_centauro'],
                        'version_icaav' => $params['version_icaav'],
                        //'seguridad' => $params['seguridad'],
                        'factura_electronica' => $params['factura_electronica'],
                        //'fe_activa' => $params['fe_activa'],
                        'cfdi' => $params['cfdi'],
                        //'ftp_login' => $params['ftp_login'],
                        //'ftp_pwd' => $params['ftp_pwd'],
                        //'dba_pwd' => $params['dba_pwd'],
                        //'layout_login' => $params['layout_login'],
                        //'layout_pwd' => $params['layout_pwd'],
                        //'tamara' => $params['tamara'],
                        //'ibank' => $params['ibank'],
                        //'amex' => $params['amex'],
                        'diot' => $params['diot'],
                        'cve_usopor_tit' => $params['cve_usopor_tit'],
                        'cve_usopor_aux' => $params['cve_usopor_aux'],
                        'id_estatus_icaav' => $params['id_estatus_icaav'],
                        'id_estatus_iris' => $params['id_estatus_iris'],
                        //'fecha' => $params['fecha'],
                        //'observaciones' => $params['observaciones'],
                        'sucursales' => $params['sucursales'],
                        'adeudo' => $params['adeudo'],
                        'boleto_e' => $params['boleto_e'],
                        'update_login' => $params['update_login'],
                        'update_pwd' => $params['update_pwd'],
                        //'activa_nuevos_sp' => $params['activa_nuevos_sp'],
                        //'addenda' => $params['addenda'],
                        //'fecha_caducidad' => $params['fecha_caducidad'],
                        //'ftp_add_login' => $params['ftp_add_login'],
                        //'ftp_add_pwd' => $params['ftp_add_pwd'],
                        //'ip_portal_fe' => $params['ip_portal_fe'],
                        //'prov_timbrado' => $params['prov_timbrado'],
                        'facturacion_boleto' => $params['facturacion_boleto'],
                        'implant_am' => $params['implant_am'],
                        //'folios_utilizados' => $params['folios_utilizados'],
                        //'folios_sync' => $params['folios_sync'],
                        'nombre_comercial' => $params['nombre_comercial'],
                        'markup' => $params['markup'],
                        'portal_proveedores' => $params['portal_proveedores'],
                        'agencias_consolidadas' => $params['agencias_consolidadas'],
                        'contabilidad_elect' => $params['contabilidad_elect'],
                        //'fecha_actualizacion_folios' => $params['fecha_actualizacion_folios'],
                        'ine' => $params['ine'],
                );
              
        $form = new Application_Form_Agencias_Agencias();
        $utiles = new Application_Model_Services_Utiles();
        
        $mensajesDeError = $form->getMessages();
        $cantidadDeErrores = count($mensajesDeError);
        if ($cantidadDeErrores == 0)
        {
            // LEER: comenté la siguiente linea por que siempre me manda que el RFC es invalido 
        	//$esRfcValido = $utiles->validarRFC($params['rfc']);
            $esRfcValido=true;
            if ($esRfcValido)
            { // Si es RFC es válido
                $esEmailCorrecto = $utiles->comprobar_email($params['email']);
                if($esEmailCorrecto)
                { // si el emal es correcto:
                      
                   // se inserta en la base de datos a la nueva agencia
                   $idNuevaAgencia = $this->agencia->insert($data);
                   // se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
                   $data['id_agencia']=$idNuevaAgencia;
                   $data['estado']='ok';
                   $data['descripcion']='La agencia ha sido guardada exitosamente';
                   // se responde al cliente
                   $this->_helper->json($data);
                   $this->_redirect('agencias/');
                 }
                 else 
                 { // else cuando el email es incorrecto
  
                   // se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
                   //$data['id_agencia']='0';
                   $data['estado']='error';
                   $data['descripcion']='Email en formato incorrecto';
                   // se responde al cliente
                   $this->_helper->json($data);
                   $this->_redirect('clientes/');
                }
            }
            else 
            { // else cuando el formato del RFC no es correcto

              // se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
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
            $this->_redirect('usuarios/');
        }
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
                        //'clave_ciudad' => $params['clave_ciudad'],
                        'tel1' => $params['tel1'],
                        'tel2' => $params['tel2'],
                        'rfc' => $params['rfc'],
                        'email' => $params['email'],
                        'http' => $params['http'],
                        'lic_icaavwin' => $params['lic_icaavwin'],
                        'lic_iriswin' => $params['lic_iriswin'],
                        'lic_gvc' => $params['lic_gvc'],
                        'lic_centauro' => $params['lic_centauro'],
                        'version_icaav' => $params['version_icaav'],
                        //'seguridad' => $params['seguridad'],
                        'factura_electronica' => $params['factura_electronica'],
                        //'fe_activa' => $params['fe_activa'],
                        'cfdi' => $params['cfdi'],
                        //'ftp_login' => $params['ftp_login'],
                        //'ftp_pwd' => $params['ftp_pwd'],
                        //'dba_pwd' => $params['dba_pwd'],
                        //'layout_login' => $params['layout_login'],
                        //'layout_pwd' => $params['layout_pwd'],
                        //'tamara' => $params['tamara'],
                        //'ibank' => $params['ibank'],
                        //'amex' => $params['amex'],
                        'diot' => $params['diot'],
                        'cve_usopor_tit' => $params['cve_usopor_tit'],
                        'cve_usopor_aux' => $params['cve_usopor_aux'],
                        'id_estatus_icaav' => $params['id_estatus_icaav'],
                        'id_estatus_iris' => $params['id_estatus_iris'],
                        //'fecha' => $params['fecha'],
                        //'observaciones' => $params['observaciones'],
                        'sucursales' => $params['sucursales'],
                        'adeudo' => $params['adeudo'],
                        'boleto_e' => $params['boleto_e'],
                        'update_login' => $params['update_login'],
                        'update_pwd' => $params['update_pwd'],
                        //'activa_nuevos_sp' => $params['activa_nuevos_sp'],
                        //'addenda' => $params['addenda'],
                        //'fecha_caducidad' => $params['fecha_caducidad'],
                        //'ftp_add_login' => $params['ftp_add_login'],
                        //'ftp_add_pwd' => $params['ftp_add_pwd'],
                        //'ip_portal_fe' => $params['ip_portal_fe'],
                        //'prov_timbrado' => $params['prov_timbrado'],
                        'facturacion_boleto' => $params['facturacion_boleto'],
                        'implant_am' => $params['implant_am'],
                        //'folios_utilizados' => $params['folios_utilizados'],
                        //'folios_sync' => $params['folios_sync'],
                        'nombre_comercial' => $params['nombre_comercial'],
                        'markup' => $params['markup'],
                        'portal_proveedores' => $params['portal_proveedores'],
                        'agencias_consolidadas' => $params['agencias_consolidadas'],
                        'contabilidad_elect' => $params['contabilidad_elect'],
                        //'fecha_actualizacion_folios' => $params['fecha_actualizacion_folios'],
                        'ine' => $params['ine'],
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
            		$esEmailCorrecto = true;
                	
                	if($esEmailCorrecto)
                	{ // si el emal es correcto:
        				$where = "id_agencia = {$params['id_agencia']}";
        				// 	se actualiza en la base de datos a la agencia
        				$this->agencia->update($data, $where);
                   		$data['estado']='ok';
                   		$data['descripcion']='La agencia ha sido actualizada exitosamente';
                   		// se responde al cliente
                   		$this->_helper->json($data);
                   		$this->_redirect('clientes/');
                 	}
                 	else 
                 	{ // else cuando el email es incorrecto
                 		// se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
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
            		// se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
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
       
        $this->_helper->json($datosAgencia[0]);

    }

}
