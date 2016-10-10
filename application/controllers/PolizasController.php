<?php

class PolizasController extends Zend_Controller_Action
{

    private $poliza;
    public function init()
    {
        $this->poliza = new Application_Model_DbTable_Poliza();
        //$this->view->activemenu=4;
        /* Initialize action controller here */
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
                        'horasopor_year' => $params['horasopor_year'], 
                        'clave' => $params['clave'], 
                        'fecha_ini' => $params['fecha_ini'], 
                        'fecha_fin' => $params['fecha_fin'],
                        'cantidad_fact' => $params['cantidad_fact'],
                        //'tiempo_agotado' => $params['tiempo_agotado'],
                       // 'garantia' => $params['garantia'],
                        'tipo' => $params['tipo'],
                       // 'desc_servicios' => $params['desc_servicios'],
                      //  'actualizacion' => $params['actualizacion'],
                       // 'telefonico' => $params['telefonico'],
                       // 'remoto' => $params['remoto'],
                       // 'admconvenios' => $params['admconvenios'],
                       // 'sitio' => $params['sitio'],
                        'estatus' => 'S'
                       // 'pagxeven' => $params['pagxeven']
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
        		$idNuevaPoliza = $this->poliza->insert($data);
        		// se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
        		$data['id_poliza']=$idNuevaPoliza;
        		$data['estado']='ok';
        		$data['descripcion']='La poliza ha sido guardada exitosamente';
        		// se responde al cliente
        		//$this->_helper->json("todo bien");
        		$this->_helper->json($data);
        		//$this->_redirect('agencias/');
        	}
        	else 
        	{//Si las fechas de la nueva póliza se traslapan con las de alguna vigente
        		$data['estado']='error';
        		$data['descripcion']='La fecha de la poliza que intenta crear se traslapa con otra.';
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
        				'id_agencia' => $params['id_agencia'],
        				'id_producto' => $params['id_producto'],
                        'horasopor_year' => $params['horasopor_year'], 
                        'clave' => $params['clave'], 
                        'fecha_ini' => $params['fecha_ini'], 
                        'fecha_fin' => $params['fecha_fin'],
                        'cantidad_fact' => $params['cantidad_fact'],
                        'tiempo_agotado' => 'tiempo_agotado',
                        'garantia' => $params['garantia'],
                        'tipo' => $params['tipo'],
                        'desc_servicios' => $params['desc_servicios'],
                        'actualizacion' => $params['actualizacion'],
                        'telefonico' => $params['telefonico'],
                        'remoto' => $params['remoto'],
                        'admconvenios' => $params['admconvenios'],
                        'sitio' => $params['sitio'],
                        'estatus' => $params['estatus'],
                        'pagxeven' => $params['pagxeven']
                );
        
        	$form = new Application_Form_Polizas_Polizas();
        	
        	$mensajesDeError = $form->getMessages();
        	$cantidadDeErrores = count($mensajesDeError);
    		if ($cantidadDeErrores == 0)
        	{
        		$where = "id_poliza= {$params['id_poliza']}";
        		// 	se actualiza en la base de datos a la póliza
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
        $polizasAgencia = $this->poliza->find($params['id_agencia'])->toArray();
       
        $this->_helper->json($polizasAgencia);

    }

}
