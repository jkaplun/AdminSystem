<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {

    	$params=$this->_request->getParams();
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/index/index.js');
    	$this->view->activemenu=1;
    	$this->view->form = new Application_Form_Index_RegistroPersona();
    	$this->view->guardado = 0;
    	if( $this->_request->isPost() ){
    		$this->view->form->populate($params);
    		
    		$registroPersonas = new Application_Model_DbTable_RegistroPersonas();
    		
    		$cn=0;$ci=0;$in=0;$cl=0;$nd=0;$ot=0;
    	

    	if(isset($params['cuenta_documentos'])){
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
						default:
							
							break;
	    			}
	    			
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
    			'donde_nacio_otro' => $params['donde_nacio_otro'],
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
				"id_seguimiento" =>  $params['seguimiento'],
				"id_user_registro_inicial" => $_SESSION['Zend_Auth']['USER_VALUES']['id_user'],
    			'nombre_persona_contacto'=> $params['nombre_persona_contacto'],
    			'parentesco_persona_contacto'=> $params['parentesco_persona_contacto']
    		);
	   		$registroPersonas->insert($data);	
	   		$this->view->guardado = 1;
    	}
    }

    public function seguimientoAction()
    {
    
    	$this->view->activemenu=2;
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/index/seguimiento.js');
    	$registroPersonas = new Application_Model_DbTable_RegistroPersonas();
    	$params=$this->_request->getParams();
    	unset($params['controller']);
    	unset($params['action']);
    	unset($params['module']);
    	$registros = $registroPersonas->getSeguimientoRegistros($params);
    	
    	$this->view->countArray= count($registros);
    	 
    	// Get a Paginator object using Zend_Paginator's built-in factory.
    	$page = $this->_request->getParam('page', 0);
    	//$page = 0;
    	$paginator = Zend_Paginator::factory($registros);
    	$paginator->setCurrentPageNumber($page)
    	->setItemCountPerPage(10)
    	->setPageRange(10);
    	//Zend_Paginator::setCache($cache);
    	$paginator->setCacheEnabled(true);
    	// Assign paginator to view
    	Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination_sm.phtml');
    	$this->view->paginator=$paginator;
    	
    	
    	$this->view->formFiltro = new Application_Form_Index_FiltroSeguimiento();
    	$this->view->formFiltro->populate($params);
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
    	
    	if( $params['accion_ajax'] == 'update_user' ){
    		
    		$user = new Application_Model_DbTable_Users();
    		
    		$data=array(
    				'realname' => $params['realname']
    		);
    		
    		if(trim($params['newpass']) != ''){
    			$data['password']=sha1($params['newpass']);
    		}
    		
    		$where = "id_user=".$params['id_user'];
    		$user->update($data, $where);
    		
    		echo json_encode(array('1'));
    	}
    }
    
    public function modificaregistroAction()
    {
    	$this->view->activemenu=2;
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/index/modificaregistro.js');
    	$params=$this->_request->getParams();
    	$this->view->guardado = 0;
    	
    	$this->view->form = new Application_Form_Index_RegistroPersona();
    	
    	
    	$registroPersonas = new Application_Model_DbTable_RegistroPersonas();
		$values = $registroPersonas->getRegistroPersona($params['id_registro_personas']);
    	//echo '<pre>'.print_r($values,true).'</pre>';die;
    	 
    	
		$cuenta_documentos = Array(
				0 => '',
				1 => '',
				2 => '',
				3 => '',
				4 => '',
				5 => ''	);
		
		if ($values['doc_certificado_nacimiento']=='Si'){$cuenta_documentos[0]='cn';}
		if ($values['doc_const_inex_de_reg']=='Si'){$cuenta_documentos[1]='ci';}
		if ($values['doc_ident_nombre_correcto']=='Si'){$cuenta_documentos[2]='in';}
		if ($values['doc_copias_del_libro']=='Si'){$cuenta_documentos[3]='cl';}
		if ($values['ningun_documento']=='Si'){$cuenta_documentos[4]='nd';}
		if ($values['otro']=='Si'){$cuenta_documentos[5]='ot';}

		$genero = ($values['genero']=='F')? 'f':'m' ;
    	$cuenta_persona_auxiliar = ($values['cuenta_persona_auxiliar']=='Si')?1:0;
    	
    	
    	$date = new Zend_Date($values['fecha_nacimiento'],'yyyy-mm-dd');
    	
    	$fechanacimiento = $date->toString('dd-mm-yyyy');
    	
    	
    	
		$arreglo = array(
			'apellido_paterno' =>$values['apellido_paterno'],
			'apellido_materno' => $values['apellido_materno'],
			'nombre' => $values['nombre'],
			'fechanacimiento' => $fechanacimiento ,
			'email' => $values['email_contacto'],
			'estado' => $values['clave_entidad'],
			//'mun_del' => $values['clave_municipio'],
			'genero' => $genero,
			'cuenta_registro' => $values['clave_cuenta_con_registro'],
			'sabe_donde_nacio' => $values['clave_donde_nacio'],
			'escolaridad' => $values['clave_escolaridad'],
			'ocupacion' => $values['ocupacion'],
			'estado_eu' => $values['idcatalogo_estados_eua'],
			'radica' =>$values['lugar_radica'],
			'tiempo_radicar_anio' => $values['anios_radica'],
			'tiempo_radicar_meses' => $values['meses_radica'],
			'tel_contacto_casa' => $values['tel_casa'],
			'tel_contacto_celular' => $values['tel_celular'],
			'tel_contacto_trabajo' => $values['tel_trabajo'],
			'donde_nacio_otro' => $values['donde_nacio_otro'],
			'desc_problema' => $values['descripcion_del_problema'],
			'cuenta_documentos' =>$cuenta_documentos,
			'cuenta_documentos_otro' =>$values['cuenta_documentos_otro'],
			'si_cuenta_con_personas_aux' =>$cuenta_persona_auxiliar,
			'desc_cuenta_con_persona' =>$values['descripcion_persona_auxiliar'],
			'seguimiento' => $values['id_seguimiento'],
			'nombre_persona_contacto'=> $values['nombre_persona_contacto'],
			'parentesco_persona_contacto'=> $values['parentesco_persona_contacto']
		);
		
		$this->view->clave_municipio = $values['clave_municipio'];
    	$this->view->form->populate($arreglo);
    	
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
    	
    		$date = new Zend_Date($params['fechanacimiento'],'dd-mm-yyyy');
    		
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
    				'donde_nacio_otro' => $params['donde_nacio_otro'],
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
    				"id_seguimiento" =>  $params['seguimiento'],
    				"id_user_registro_inicial" => $_SESSION['Zend_Auth']['USER_VALUES']['id_user'],
    				'nombre_persona_contacto'=> $params['nombre_persona_contacto'],
    				'parentesco_persona_contacto'=> $params['parentesco_persona_contacto']
    		);
    		$registroPersonas->update($data,'id_registro_personas='.$params['id_registro_personas']);
    		$this->view->guardado = 1;
    	}
    	
    	
    }
    
    public function consultaregistroAction()
    {
    	$params=$this->_request->getParams();
    	
    	
    	$this->view->activemenu=2;
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/index/modificaregistro.js');
    	$params=$this->_request->getParams();
    	$this->view->guardado = 0;
    	 
    	$this->view->form = new Application_Form_Index_RegistroPersona();
    	 
    	 
    	$registroPersonas = new Application_Model_DbTable_RegistroPersonas();
    	$values = $registroPersonas->getRegistroPersona($params['id_registro_personas']);
    	//echo '<pre>'.print_r($values,true).'</pre>';die;
    	
    	 
    	$cuenta_documentos = Array(
    			0 => '',
    			1 => '',
    			2 => '',
    			3 => '',
    			4 => '',
    			5 => ''	);
    	
    	if ($values['doc_certificado_nacimiento']=='Si'){$cuenta_documentos[0]='cn';}
    	if ($values['doc_const_inex_de_reg']=='Si'){$cuenta_documentos[1]='ci';}
    	if ($values['doc_ident_nombre_correcto']=='Si'){$cuenta_documentos[2]='in';}
    	if ($values['doc_copias_del_libro']=='Si'){$cuenta_documentos[3]='cl';}
    	if ($values['ningun_documento']=='Si'){$cuenta_documentos[4]='nd';}
    	if ($values['otro']=='Si'){$cuenta_documentos[5]='ot';}
    	
    	$genero = ($values['genero']=='F')? 'f':'m' ;
    	$cuenta_persona_auxiliar = ($values['cuenta_persona_auxiliar']=='Si')?1:0;
    	 
    	$arreglo = array(
    			'apellido_paterno' =>$values['apellido_paterno'],
    			'apellido_materno' => $values['apellido_materno'],
    			'nombre' => $values['nombre'],
    			'fechanacimiento' => $values['fecha_nacimiento'],
    			'email' => $values['email_contacto'],
    			'estado' => $values['clave_entidad'],
    			//'mun_del' => $values['clave_municipio'],
    			'genero' => $genero,
    			'cuenta_registro' => $values['clave_cuenta_con_registro'],
    			'sabe_donde_nacio' => $values['clave_donde_nacio'],
    			'escolaridad' => $values['clave_escolaridad'],
    			'ocupacion' => $values['ocupacion'],
    			'estado_eu' => $values['idcatalogo_estados_eua'],
    			'radica' =>$values['lugar_radica'],
    			'tiempo_radicar_anio' => $values['anios_radica'],
    			'tiempo_radicar_meses' => $values['meses_radica'],
    			'tel_contacto_casa' => $values['tel_casa'],
    			'tel_contacto_celular' => $values['tel_celular'],
    			'tel_contacto_trabajo' => $values['tel_trabajo'],
    			'donde_nacio_otro' => $values['donde_nacio_otro'],
    			'desc_problema' => $values['descripcion_del_problema'],
    			'cuenta_documentos' =>$cuenta_documentos,
    			'cuenta_documentos_otro' =>$values['cuenta_documentos_otro'],
    			'si_cuenta_con_personas_aux' =>$cuenta_persona_auxiliar,
    			'desc_cuenta_con_persona' =>$values['descripcion_persona_auxiliar'],
    			'seguimiento' => $values['id_seguimiento'],
    			'nombre_persona_contacto'=> $values['nombre_persona_contacto'],
    			'parentesco_persona_contacto'=> $values['parentesco_persona_contacto']
    			
    	);
    	
    	$this->view->clave_municipio = $values['clave_municipio'];
    	$this->view->form->populate($arreglo);
    	
    	//echo '<pre>'.print_r($params,true).'</pre>';die;
    }
}

