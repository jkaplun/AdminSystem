<?php

class ReporteAgenciasController extends Zend_Controller_Action
{
            
    public function init()
    {
        $this->orden = new Application_Model_DbTable_Agencia();
    }

    public function reporteAgenciasPolizasAction()
    {
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');    
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/reportes/agencias/reportes-agencias.js');

        $tipoPoliza = new Application_Model_DbTable_TipoPoliza();
        $selectAgencias = new Zend_Form_Element_Select('select_agencias');
        $resultados = $tipoPoliza->obtenerTiposPoliza();
        $lista = array();
        foreach ( $resultados as $resultado){
            $lista[$resultado['tipo']]=$resultado['descripcion'];
        }
         
        $zendForm = new Zend_Form();
         
        $selectAgencias
            ->removeDecorator('label')
            ->removeDecorator('HtmlTag')
            ->addMultiOptions($lista)
            ->setAttrib("class","form-control selectpicker")
            ->setAttrib("data-max-options",10)
            ->setAttrib("data-live-search","true")
            ->setAttrib("title","Ingresa nombre del tipo de Póliza...")
            ->setAttrib("autocomplete","off");
         
        $zendForm->addElement($selectAgencias);
        $this->view->selectAgencias=$zendForm;
    }

    public function reporteAgenciasAvanzadoAction()
    {
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');    
        
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/multi-select/js/multi-select.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/reportes/agencias/reporte-avanzado-agencias.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');



        $this->view->form = new Application_Form_Agencias_Busquedagencias();

    }

    public function reporteAgenciasProductosAction()
    {
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');    
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/reportes/agencias/reportes-agencias.js');

        $usuariosAdmin = new Application_Model_DbTable_Producto(); 
        $selectAgencias = new Zend_Form_Element_Select('select_agencias');
        $this->view->productos = $usuariosAdmin->obtenerProductos();

        $listaEjecutivos = array();
         foreach ( $this->view->productos as $productos){
            $listaEjecutivos[$productos['id_producto']]=$productos['nombre_prod'];
        }
         
        $zendForm = new Zend_Form();
         
        $selectAgencias
            ->removeDecorator('label')
            ->removeDecorator('HtmlTag')
            ->addMultiOptions($listaEjecutivos)
            ->setAttrib("class","form-control selectpicker")
            ->setAttrib("data-max-options",10)
            ->setAttrib("data-live-search","true")
            ->setAttrib("title","Ingresa nombre del producto...")
            ->setAttrib("autocomplete","off");
         
        $zendForm->addElement($selectAgencias);
        $this->view->selectAgencias=$zendForm;
    }

    public function consultarReporteAgenciaProductosAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams(); 
        $serviciosAgencia = $this->orden->obtenerAgenciaPorProducto($params['id_producto']);
        $this->_helper->json($serviciosAgencia);

    }

    public function consultarReporteAgenciaPolizasAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams(); 
        $serviciosAgencia = $this->orden->obtenerAgenciaPorPoliza($params['id_poliza']);
        $this->_helper->json($serviciosAgencia);

    }

    public function consultaAvanzadaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
    
        $agenciaDbTable = new Application_Model_DbTable_Agencia();
        $where = array();
        foreach ($params as $clave => $param)
        {
            if($clave == "nombre")
            {
                if(!empty($param))
                {
                    array_push($where, "ag.nombre like '%".$param."%'");
                }
            }
            if($clave == "nombre_comercial")
            {
                if(!empty($param))
                {
                    array_push($where, "ag.nombre_comercial like '%".$param."%'");
                }
            }
            if($clave == "rfc")
            {
                if(!empty($param))
                {
                    array_push($where, "ag.rfc like '%".$param."%'");
                }
            }
            /*if($clave == "estatus")
            {
                if(!empty($param))
                {
                    array_push($where, "ag.estatus like '%".$param."%'");
                }
            }*/
            if($clave == "ciudad")
            {
                if(!empty($param))
                {
                    array_push($where, "ag.clave_ciudad like '%".$param."%'");
                }
            }
            if($clave == "estado")
            {
                if(!empty($param))
                {
                    array_push($where, "ag.estado like '%".$param."%'");
                }
            }
            if($clave == "cp")
            {
                if(!empty($param))
                {
                    array_push($where, "ag.cp like '%".$param."%'");
                }
            }
            if($clave == "contacto")
            {
                if(!empty($param))
                {
                    array_push($where, "u_ag.nombre like '%".$param."%'");
                }
            }
            if($clave == "email")
            {
                if(!empty($param))
                {
                    array_push($where, "ag.email like '%".$param."%'");
                }
            }
            if($clave == "ejecutivo")
            {
                if(!empty($param))
                {
                    array_push($where, "u_ad.nombre like '%".$param."%'");
                }
            }
            if($clave=="lice"){
                if(!empty($param))
                {
                    array_push($where, "ag_p.id_producto in ('".$param."')");

                }                
            }
        }
        $numero_filas = count($where);
        if($numero_filas>0){
            //Cuento el número de filas de la query
            $indice = 0;
            //var_dump($numero_filas);
            $clausulaWhere = "";
            foreach ($where as $clausula)
            {
                $indice +=1;
                if($indice != $numero_filas)
                {
                    $clausulaWhere .= $clausula." and ";
                }
                else 
                {
                    $clausulaWhere .= $clausula;    
                }
            }
            $productos = $agenciaDbTable->obtenerAgenciaPorAvanzado($clausulaWhere);
            //$this->view->prueba = 'Llega al mensaje';
        }
        else
        {
            $this->_helper->json("No");
        }
            $this->_helper->json($productos);
    }

}

