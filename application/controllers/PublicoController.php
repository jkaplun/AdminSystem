<?php

class PublicoController extends Zend_Controller_Action
{

    public function init()
    {
    	//$this->view->activemenu=3;
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	
    	//echo '<pre>'.print_r($_SESSION,true).'</pre>';die;
    	$params=$this->_request->getParams();
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/publico/index.js');
    	$this->view->activemenu=1;
    	$this->view->form = new Application_Form_Index_RegistroPersona();
    	$this->view->guardado = 0;
    	if( $this->_request->isPost() ){
    		//echo '<pre>'.print_r($params,true).'</pre>';die;
    		$this->view->form->populate($params);
    		
    		$registroPersonas = new Application_Model_DbTable_RegistroPersonas();
    		
    		$cn=0;$ci=0;$in=0;$cl=0;$nd=0;$ot=0;
    		
    		foreach ($params['cuenta_documentos'] as $value){
    			switch ($value){
					case 'cn' :
						$cn = 1;
						break;
					case 'ci' :
						$ci = 1;
						break;
					case 'in' :
						$in = 1;
						break;
					case 'cl' :
						$cl = 1;
						break;
					case 'nd' :
						$nd = 1;
						break;
					case 'ot' :
						$ot = 1;
						break;						
    			}
    		}
    		
    		
    		
    		if( $params['fechanacimiento'] != ''){
    			$date = new Zend_Date($params['fechanacimiento'],'dd-mm-yyyy');
    			$fechanacimiento = $date->toString('yyyy-mm-dd');
    		} else {
    			$fechanacimiento = '1800-01-01';
    		}
    		
    		$data = array(
				"apellido_paterno" =>$params['apellido_paterno'],
				"apellido_materno" =>$params['apellido_materno'],
				"nombre" =>$params['nombre'],
				"clave_entidad" =>$params['estado'],
				"clave_municipio" =>$params['mun_del'],
				"genero" =>$params['genero'],
				"escolaridad" =>$params['escolaridad'],
				"ocupacion" =>$params['ocupacion'],
				"lugar_radica" =>$params['radica'],
				"anios_radica" =>$params['tiempo_radicar_anio'],
				"meses_radica" =>$params['tiempo_radicar_meses'],
				"tel_casa" =>$params['tel_contacto_casa'],
				"tel_celular" =>$params['tel_contacto_celular'],
				"tel_trabajo" =>$params['tel_contacto_trabajo'],
				"cuenta_con_registro" =>$params['cuenta_registro'],
				"donde_nacio" =>$params['sabe_donde_nacio'],
				"descripcion_del_problema" =>$params['desc_problema'],
				"doc_certificado_nacimiento" =>$cn,
				"doc_const_inex_de_reg" =>$ci,
				"doc_ident_nombre_correcto" =>$in,
				"doc_copias_del_libro" =>$cl,
				"ningun_documento" =>$nd,
				"otro" =>$ot,
				"cuenta_persona_auxiliar" =>$params['si_cuenta_con_personas_aux'],
				"descripcion_persona_auxiliar" =>$params['desc_cuenta_con_persona'],
				"email_contacto" =>$params['email'],
				"cuenta_documentos_otro" =>$params['cuenta_documentos_otro'],
				"fecha_nacimiento" =>$fechanacimiento,
				"idcatalogo_estados_eua" =>$params['estado_eu'],
				"id_seguimiento" =>  1,
				"id_user_registro_inicial" => 0
    		);
	   		$registroPersonas->insert($data);	
	   		$this->view->guardado = 1;
    	}
    }

    public function ajaxAction()
    {
    	$params=$this->_request->getParams();
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    
    	// SAVE A PURCHASE PROCESS.
    	if( $params['accion_ajax'] == 'trae_mun_del' ){
    		$catalogoMunLoc = new Application_Model_DbTable_CatalogoMunLoc();
    		$municipios = $catalogoMunLoc->getMunicipios($params['clave_entidad']);
    		echo json_encode($municipios);
    	}
    }
    
    
    public function pruebaAction(){
    	$a = 10;
    	$b = 15;
    	
    	$this->view->resultado = ($a + $b);
    	$this->view->datos = array('nombre' => 'Juan');
    }
}

