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

        $data = array(
    		'id_agencia' => $params['id_agencia'],
    		'id_producto' => $params['id_producto'],
            'horas_poliza' => $params['horas_poliza'], 
            'horas_poliza' => 0.00, 
            //'clave' => $params['clave'], 
            'fecha_ini' => $params['fecha_ini'], 
            'fecha_fin' => $params['fecha_fin'],
            'costo_poliza' => $params['costo_poliza'],
            'tipo' => $params['tipo'],
            'observaciones' => $params['observaciones_poliza'],
            'estatus' => 1,
        );
              
        $form = new Application_Form_Polizas_Polizas();
        
        $mensajesDeError = $form->getMessages();
        $cantidadDeErrores = count($mensajesDeError);
        if ($cantidadDeErrores == 0)
        {
        	$servicesPolizas = new Application_Model_Services_ServicesPolizas();
        	$esFechaDePolizaValida = $servicesPolizas ->esPolizaValida($params['id_producto'], $params['id_agencia'], 
        										$params['fecha_ini'], $params['fecha_fin']);
        	
        	 if($esFechaDePolizaValida)
        	 {
        	 	$v1ClavePoliza = $servicesPolizas->obtenerV1DeClavePoliza($params['id_producto'], $params['id_agencia']);        	 	
        	 	$data['clave'] = $v1ClavePoliza;
        	 	//Se crea la póliza con una clave sin el id
        		$idNuevaPoliza = $this->poliza->insert($data);
        		//Se concatena el id de la nueva póliza
        		$data['clave'] = $v1ClavePoliza.$idNuevaPoliza;
        		// 	se actualiza en la base de datos la clave de la p�liza
        		$where = "id_poliza= ".$idNuevaPoliza;
        		$this->poliza->update($data, $where);
        		// se inyecta el ID, estado y descripción en la respuesta al cliente
        		$data['id_poliza']=$idNuevaPoliza;
        		$data['estado']='ok';
        		$data['descripcion']='La poliza ha sido guardada exitosamente';
        		$this->_helper->json($data);
        		//$this->_redirect('agencias/');
        	 }
        	 else 
        	 {//Si las fechas de la nueva p�liza se traslapan con las de alguna vigente
        	 	$data['estado']='error';
        	 	$data['descripcion']='La fecha de la póliza que intenta crear se traslapa con otra.';
        	 	// se responde al cliente
        	 	$this->_helper->json($data);
        	 	//$this->_redirect('agencias/');
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
        				'id_poliza' => $params['id_poliza'],
        				'id_agencia' => $params['id_agencia'],
        				'id_producto' => $params['id_producto'],
                        'horas_poliza' => $params['horas_poliza'], 
                        'clave' => $params['clave'], 
                        'fecha_ini' => $params['fecha_ini'], 
                        'fecha_fin' => $params['fecha_fin'],
                        'costo_poliza' => $params['costo_poliza'],
                        'observaciones' => $params['observaciones_poliza'],
                        'tipo' => $params['tipo'],
                        'estatus' => $params['estatus_poliza'],
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
        		$data['descripcion']='La poliza ha sido actualizada exitosamente';
        		// se responde al cliente
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
        $polizasAgencia = $this->poliza->obtenerPolizasPorIdAgencia($params['id_agencia']);
        $this->_helper->json($polizasAgencia);

    }

   public function consultarpolizasvigentesAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams(); 
        $polizasAgencia = $this->poliza->obtenerPolizasVigentesPorIdAgencia($params['id_agencia']);
        $this->_helper->json($polizasAgencia);

    }
    
}
