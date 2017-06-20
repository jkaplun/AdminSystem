<?php

class PolizasController extends Zend_Controller_Action
{

    private $poliza;
    public function init()
    {
        $this->poliza = new Application_Model_DbTable_Poliza();
    }

    public function indexAction()
    {
       
         $poliza = new Application_Model_DbTable_Poliza();

         
         $selectPolizas = new Zend_Form_Element_Select('select_polizas');
         $this->view->polizas = $poliza->obtenerTodasLasPolizasActivas();
         
         $listaPolizas = array();
         foreach ( $this->view->polizas as $poliza){
         	$listaPolizas[$agencias['id_poliza']]=$poliza['clave'];
         }
         
         $zendForm = new Zend_Form();
         
         $selectPolizas
	        ->removeDecorator('label')
	        ->removeDecorator('HtmlTag')
	        ->addMultiOptions($listaAgencias)
	        ->setAttrib("class","form-control selectpicker")
	        ->setAttrib("data-max-options",10)
	        ->setAttrib("data-live-search","true")
	        ->setAttrib("autocomplete","off");
         
         $zendForm->addElement($selectPolizas);
         $this->view->$selectPolizas=$zendForm;
         
         $params=$this->_request->getParams();
         //$this->view->form = new Application_Form_Polizas_Polizas();
  
         $this->view->prueba = 'Llega al mensaje';
         //echo '<pre>'.print_r($agencias,true).'</pre>';die;
         

         
    }

    public function agregarAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
        ///echo "<pre>".print_r($params,true)."</pre>";die;
        
        $data = array(
    		'id_agencia' => $params['id_agencia'],
    		'id_producto' => $params['id_producto'],
            'horas_poliza' => $params['horas_poliza'], 
            'horas_consumidas' => 0.00, 
            //'clave' => $params['clave'], 
            'fecha_ini' => $params['fecha_ini'], 
            'fecha_fin' => $params['fecha_fin'],
            'costo_poliza' => $params['costo_poliza'],
            'tipo' => $params['tipo'],
            'observaciones' => $params['observaciones_poliza'],
            'id_poliza_estatus' => $params['id_poliza_estatus'],
       		'fecha_fin_servicio' => $params['fecha_fin_servicio']
        );

        $form = new Application_Form_Polizas_Polizas();
        
        $mensajesDeError = $form->getMessages();
        $cantidadDeErrores = count($mensajesDeError);
        
        
        if ($cantidadDeErrores == 0)
        {
        	$servicesPolizas = new Application_Model_Services_ServicesPolizas();
        	$validaParams = $servicesPolizas ->esPolizaValida($params['id_producto'], $params['id_agencia'], 
        										$params['fecha_ini'], $params['fecha_fin'], $params['tipo']);

        	 if($validaParams['valida'])
        	 {
        	 	$v1ClavePoliza = $servicesPolizas->obtenerV1DeClavePoliza($params['id_producto'], $params['id_agencia']);        	 	
        	 	$data['clave'] = strtoupper($v1ClavePoliza);
        	 	//Se crea la póliza con una clave sin el id
        		$idNuevaPoliza = $this->poliza->insert($data);
        		
        		$email = new Application_Model_Services_Emails();
        		$email->altaPoliza($data);
        		
        		// Validación cuando es una poliza para ICAAV la cual tiene id 3 en la tabla de productos.
        		if ($params['id_producto']==3) {
        			$servicePoliza = new Application_Model_Services_ServicesPolizas();
        			$servicePoliza->actualizaProductosPorPoliza($params);
        		}

        		//Se concatena el id de la nueva póliza
        		$data['clave'] = $v1ClavePoliza.$idNuevaPoliza;
        		// 	se actualiza en la base de datos la clave de la p�liza
        		$where = "id_poliza= ".$idNuevaPoliza;
        		$this->poliza->update($data, $where);
        		// se inyecta el ID, estado y descripción en la respuesta al cliente
        		$data['id_poliza']=$idNuevaPoliza;
        		$data['estado']='ok';
        		
        		$polizaInfo = new Application_Model_DbTable_Poliza();
        		$poliza = $polizaInfo->find($idNuevaPoliza)->toArray()[0];
        		$tipoPolizaDB = new Application_Model_DbTable_TipoPoliza();
        		$tipoPoliza = $tipoPolizaDB->find($poliza['tipo'])->toArray()[0];
        		
        		$data['descripcion']= $tipoPoliza['descripcion'];
        		
        		$data['estatus_descripcion']='La poliza ha sido guardada exitosamente';
        		$this->_helper->json($data);

        	 }
        	 else 
        	 {//Si las fechas de la nueva p�liza se traslapan con las de alguna vigente
        	 	$data['estado']='error';
        	 	
        	 	if ($validaParams['errorDesc']==''){
        	 		$data['descripcion']='Hay un error al intentar crear la Póliza. Verifique los datos.';
        	 	} else {
        	 		$data['descripcion']=$validaParams['errorDesc'];
        	 		
        	 	}
        	 	
        	 	// se responde al cliente
        	 	$this->_helper->json($data);
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

        $data = array(
      				//'id_poliza' => $params['id_poliza'],
       				'id_agencia' => $params['id_agencia'],
       				//'id_producto' => $params['id_producto'],
                    'horas_poliza' => $params['horas_poliza'], 
                    'clave' => $params['clave'], 
                    //'fecha_ini' => $params['fecha_ini'], 
                   // 'fecha_fin' => $params['fecha_fin'],
                    'costo_poliza' => $params['costo_poliza'],
                    'observaciones' => $params['observaciones_poliza'],
                    //'tipo' => $params['tipo'],
                    'id_poliza_estatus' => $params['id_poliza_estatus'],
       				'fecha_fin_servicio' => $params['fecha_fin_servicio']
                );
        
        	$form = new Application_Form_Polizas_Polizas();
        	
        	$mensajesDeError = $form->getMessages();
        	$cantidadDeErrores = count($mensajesDeError);
    		if ($cantidadDeErrores == 0)
        	{
        		$where = "id_poliza= {$params['id_poliza']}";
        		// 	se actualiza en la base de datos a la p�liza
        		$this->poliza->update($data, $where);
        		$data['estado']='ok';
        		
        		$polizaInfo = new Application_Model_DbTable_Poliza();
        		$poliza = $polizaInfo->find($params['id_poliza'])->toArray()[0];
        		$tipoPolizaDB = new Application_Model_DbTable_TipoPoliza();
        		$tipoPoliza = $tipoPolizaDB->find($poliza['tipo'])->toArray()[0];
        		
        		$data['descripcion']= $tipoPoliza['descripcion'];
        		
        		
        		$data['estatus_descripcion']='La poliza ha sido actualizada exitosamente';
        		// se responde al cliente
        		
        		$data['id_poliza'] = $params['id_poliza'];
        		$data['id_producto'] = $params['id_producto'];
        		$data['fecha_ini'] = $params['fecha_ini'];
        		$data['fecha_fin'] = $params['fecha_fin'];
        		$this->_helper->json($data);
        		$this->_redirect('agencias/');
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
        $polizasAgencia = $this->poliza->obtenerTodasLasPolizasPorIdAgencia($params['id_agencia']);
        
        
        foreach ( $polizasAgencia as &$poliza) { 
        	$fecha = new Zend_Date($poliza['fecha_ini']);
        	$fechaString = $fecha->toString('d MMMM yyyy');
        	$poliza['fecha_ini'] = $fechaString;
        	$fecha = new Zend_Date($poliza['fecha_fin']);
        	$fechaString = $fecha->toString('d MMMM yyyy');
        	$poliza['fecha_fin'] = $fechaString;
        	$poliza['costo_poliza'] = "$ " . number_format( $poliza['costo_poliza'] ,2);
        	
        }

        $this->_helper->json($polizasAgencia);

    }

   public function consultarpolizasvigentesAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams(); 
        $polizasAgencia = $this->poliza->obtenerPolizasVigentesPorIdAgencia($params['id_agencia']);
        
        foreach ($polizasAgencia as &$polizas){
        	$fecha = new Zend_Date($polizas['fecha_ini']);
        	$fechaString = $fecha->toString('d MMMM yyyy');
        	$polizas['fecha_ini'] = $fechaString;
        	
        	$fecha = new Zend_Date($polizas['fecha_fin']);
        	$fechaString = $fecha->toString('d MMMM yyyy');
        	$polizas['fecha_fin'] = $fechaString;
        	
        	$fecha = new Zend_Date($polizas['fecha_fin_servicio']);
        	$fechaString = $fecha->toString('d MMMM yyyy');
        	$polizas['fecha_fin_servicio'] = $fechaString;
        }
        //echo "<pre>".print_r($polizasAgencia,true)."</pre>";die;
        
        
        
        $this->_helper->json($polizasAgencia);

    }

}
