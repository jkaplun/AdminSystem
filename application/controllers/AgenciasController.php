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

    public function busquedaAgenciaAction()
    {
        //$this->view->headScript()->appendFile($this->view->baseUrl().'/css_complete/multi-select/css/multi-select.css');


        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');    
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/multi-select/js/multi-select.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/agencias/busqueda-agencia.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');

        $this->view->form = new Application_Form_Agencias_Busquedagencias();
    }

    public function busquedaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
        $this->view->prueba = 'Llega al mensaje';
    }


    public function indexAction()
    {

         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/data/validacion.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/agencias/index.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/usuariosAgencias/index.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/polizas/index.js');





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
  
         $this->view->prueba = 'Llega al mensaje';
         //echo '<pre>'.print_r($agencias,true).'</pre>';die;
    }

public function agregarAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
        $data = array(
                                'id_agencia' => $params['id_agencia'],
                                'clave' => $params['claveUsuarioAgencia'],
                                'nombre' => $params['nombreUsuarioAgencia'],
                                'apellidos' => $params['apellidos'],
                                'puesto' => $params['puesto'],
                                'telefono' => $params['telefono'],
        						'ext' => $params['ext'],
                                'celular' => $params['celular'],
                                'email' => $params['emailUsuarioAgencia'],
                                'activo' => $params['activo'],
                                'lider_proy' => $params['lider_proy'],
                                'director' => $params['director'],
                                'admin_fe' => $params['admin_fe'],
                                'enviar_reporte_portal_mig' => $params['enviar_reporte_portal_mig'],
                                'bajar_updates' => $params['bajar_updates']
                        );
        
        $form = new Application_Form_UsuariosAgencia_UsuariosAgencia();
        
        $mensajesDeError = $form->getMessages();
        $cantidadDeErrores = count($mensajesDeError);
        if ($cantidadDeErrores == 0)
        {
				//$contraEncrip = sha1($params['pwd']);
                $usuario = $this->usuario_agencia->obtenerUsuariosAgenciaPorClave($params['claveUsuarioAgencia']);
                
                if (!$usuario)
                { // Â¿QuÃ© se verifica aquÃ­?
                    $utiles = new Application_Model_Services_Utiles();
                    $esEmailCorrecto = $utiles->comprobar_email($params['emailUsuarioAgencia']);
                    if($esEmailCorrecto)
                    { // si el emal es correcto:

                    	$dba_pwdEncoded = base64_encode($params['pwd']);
                    	$data['pwd']=$dba_pwdEncoded;
                        // se inserta en la base de datos al nuevo usuario
                        $nuevoUsuarioAgencia = $this->usuario_agencia->insert($data);
                        unset($data['pwd']);
                        $data['estado']='ok';
                        // se responde al cliente
                        $this->_helper->json($data);
                        $this->_redirect('agencias/');
                    }
                    else 
                    { // else cuando el email es incorrecto
  
                       // se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
                        $data['id_agencia']='0';
                        $data['clave']='';
                        $data['estado']='error';
                        $data['descripcion']='Email en formato incorrecto';
                         // se responde al cliente
                        $this->_helper->json($data);
                        $this->_redirect('agencias/');
                    }
                }
                else 
                { // else cuando ya existe una clave igual (??) 

                       // se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
                        $data['id_agencia']='0';
                        $data['clave']='';
                        $data['estado']='error';
                        $data['descripcion']='Ya existe una clave igual';
                        // se responde al cliente
                        $this->_helper->json($data);
                        $this->_redirect('agencias/');
                }
        }
        else 
        { // else cuando existe un error encontrado en el form
            $this->_helper->json($mensajesDeError);
            $this->_redirect('agencias/');
        }
    }
    
public function actualizarAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
       	 //echo $params['id_agencia'];
            	
        $data = array(
                                'id_agencia' => $params['id_agencia'],
                                //'clave' => $params['claveUsuarioAgencia'], no se permite modificación
                                //'pwd' => $params['pwd'],
                                'nombre' => $params['nombreUsuarioAgencia'],
                                'apellidos' => $params['apellidos'],
                                'puesto' => $params['puesto'],
                                'telefono' => $params['telefono'],
                                'ext' => $params['ext'],
                                'celular' => $params['celular'],
                                'email' => $params['emailUsuarioAgencia'],
                                'activo' => $params['activo'],
                                'lider_proy' => $params['lider_proy'],
                                'director' => $params['director'],
                                'admin_fe' => $params['admin_fe'],
                                'enviar_reporte_portal_mig' => $params['enviar_reporte_portal_mig'],
                                'bajar_updates' => $params['bajar_updates']
                        );
        
        	$form = new Application_Form_UsuariosAgencia_UsuariosAgencia();
       		$usuarioActual = $this->usuario_agencia->obtenerUsuarioDeAgenciaPorId($params['id_agencia'],$params['claveUsuarioAgencia']);
        	
        	$mensajesDeError = $form->getMessages();
        	$cantidadDeErrores = count($mensajesDeError);
        	if ($cantidadDeErrores == 0)
        	{
        		/*$esContrasenaYConfValidos=false;
        		//Revisando si el usuario modificï¿½ la contraseï¿½a
        		if($params['pwd'] != $usuarioActual['pwd'])
        		{//Si el usuario la modificï¿½
        			if($params['pwd'] != $params['pwd_conf'])
        			{// else cuando las contraeÃ±as no coinciden
        				
        				// se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
        				$data['estado']='error';
        				$data['descripcion']='Passwords diferentes'.$usuarioActual['pwd'];
        				// se responde al cliente
        				$this->_helper->json($data);
        				$this->_redirect('agencias/');
        			}
        			else 
        			{
        				$contraEncrip = sha1($params['pwd']);
        				$data['pwd']=$contraEncrip;
        			}
        		}*/
        		$utiles = new Application_Model_Services_Utiles();
        		$esEmailCorrecto = $utiles->comprobar_email($params['emailUsuarioAgencia']);
        		if ($esEmailCorrecto)
        		{
        			/*if ($usuarioActual['clave'] != $params['claveUsuarioAgencia'])
        			{
	        				// Si se intenta modificar la clave
        					// se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
        					$data['estado']='error';
        					$data['descripcion']='No se permite modificar la clave';
        					// se responde al cliente
        					$this->_helper->json($data);
        					$this->_redirect('agencias/');
        			}
        			else
        			{ */
        				// 	se actualiza en la base de datos al usuario
                    	$dba_pwdEncoded = base64_encode($params['pwd']);
                    	$data['pwd']=$dba_pwdEncoded;
        				$where = "id_agencia = {$params['id_agencia']} and clave = '{$params['claveUsuarioAgencia']}'";
        				$this->usuario_agencia->update($data, $where);
	        			// 	se inyecta el estado y descripciÃ³n en la respuesta al cliente
        				$data['id_agencia']=$params['id_agencia'];
        				$data['clave']=$params['claveUsuarioAgencia'];
    	    			$data['estado']='ok';
        				$data['descripcion']='El usuario ha sido actualizado exitosamente';
        				// se responde al cliente
        				$this->_helper->json($data);
        				$this->_redirect('agencias/');
        			//}
        		}
        		else
        		{ // else cuando el email es incorrecto
        			// se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
        			//$data['id_usuario_agencia']='0';
        			$data['estado']='error';
        			$data['descripcion']='Email en formato incorrecto';
        			// se responde al cliente
        			$this->_helper->json($data);
        			$this->_redirect('agencias/');
        		}
    	}
	    else
    	{ // else cuando existe un error encontrado en el form
       		$this->_helper->json($mensajesDeError);
       		$this->_redirect('agencias/');
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
