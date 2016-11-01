<?php

class OrdenServicioController extends Zend_Controller_Action
{

    public function indexAction(){


    }

    public function nuevaOrdenAction()
    {    
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/orden-servicio/nueva-orden.js');
        
        
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

    }

    public function atencionOrdenAction()
    {    


    }

    public function seguimientoOrdenAction()
    {      
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js'); 
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/orden-servicio/seguimiento-ordenes.js');  

        $orden = new Application_Model_DbTable_OrdenServicio();
        
        $valores = array();
        $resultado = $orden->obtenerOrdenes($valores);
        
        $this->view->countArray= count($resultado);

        // Get a Paginator object using Zend_Paginator's built-in factory.
        $page = $this->_request->getParam('page', 0);
        $paginator = Zend_Paginator::factory($resultado);
        $paginator->setCurrentPageNumber($page)
        ->setItemCountPerPage(10)
        ->setPageRange(10);
        $paginator->setCacheEnabled(true);
        // Assign paginator to view
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination_sm.phtml');
        $this->view->paginator=$paginator;
    }

    public function monitoreoordenAction()
    {    
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	
    	$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
		$ordenesBd = $ordenServicioDbTable->obtenerOrdenesMonitoreo($idProducto, $idAgencia);
		$ordenes = array();
		foreach ($ordenesBd as $orden)
		{
			$ordenes[$orden['id_usuario_admin_atiende']] = $orden;
		}
		$this->_helper->json($ordenes);
        $this->_helper->layout->setLayout('layout_monitoreo');  
    }

}

