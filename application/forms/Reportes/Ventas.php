<?php	

/**
 * 
 * @author jgarfias
 *
 */
class Application_Form_Reportes_Ventas extends Zend_Form {
	public function init(){
		
		$agencia = new Application_Model_DbTable_Agencia();
		$selectAgencias = new Zend_Form_Element_Select('id_agencia');
		$agencias = $agencia->obtenerTodasLasAgencias();
		
		$listaAgencias = array(''=>'Todas las Agencias','--prospect--'=>'Prospectos');
		foreach ( $agencias as $agencias){
			$listaAgencias[$agencias['id_agencia']]=$agencias['nombre'];
		}
		
		$selectAgencias
		->setLabel("Agencia:")
		->removeDecorator('HtmlTag')
		->addMultiOptions($listaAgencias)
		->setAttrib("class","form-control selectpicker input-sm")
		->setAttrib("data-max-options",10)
		->setAttrib("data-live-search","true")
		->setAttrib("title","Ingresa nombre de la agencia...")
		->setAttrib("autocomplete","off");
		
		$this->addElement($selectAgencias);
		
		$element = new Zend_Form_Element_Hidden('fecha_de');
		$element
		->removeDecorator('HtmlTag')
		->removeDecorator('label');
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Hidden('fecha_hasta');
		$element
		->removeDecorator('HtmlTag')
		->removeDecorator('label');
		$this->addElement($element);
		
		$options = array();
		$usuario_admin = new Application_Model_DbTable_UsuarioAdmin();
		
		$user = $usuario_admin->getSalesUsers();
		$options = array(''=>'Todos');
		foreach ($user as $value){
			$options[$value['id_usuario']] = $value['clave'];
		}

		// estatus orden
		$element = new Zend_Form_Element_Select('fecha_base');
		$element
		->setLabel("Elegir tipo de fecha:")
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control input-sm")
		->setAttrib("autocomplete","off")
		->addMultiOptions(array(
				0 => 'Ninguna',
				1 => 'Finalización de Póliza',
		));
		$this->addElement($element);
		
		$tipoPoliza = new Application_Model_DbTable_TipoPoliza();
		$resultados = $tipoPoliza->obtenerTiposPoliza();
		$lista = array(''=>'Todas');
		foreach ( $resultados as $resultado){
			$lista[$resultado['tipo']]=$resultado['descripcion'];
		}
		
		//Tipo
		$tipo = new Zend_Form_Element_Select('tipo');
		$tipo
		->setLabel("Tipo de Póliza:")
		->removeDecorator('HtmlTag')
		->addMultiOptions($lista)
		->setAttrib("class","form-control input-sm")
		->setAttrib("autocomplete","off")
		;
		$this->addElement($tipo);
		
		// Fecha del Soporte en Sitio
		$element= new Zend_Form_Element_Text('daterange');
		$element
		->setLabel("Rango de Fechas:")
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		->setAttrib("autocomplete","off")
		->setAttrib("class","form-control input-sm");
		$this->addElement($element);
		
		
		$element = new Zend_Form_Element_Submit('Filtrar');
		$element
		->removeDecorator('HtmlTag')
		->setAttrib("class","btn btn-primary form-control input-sm");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Submit('Exportar');
		$element
		->removeDecorator('HtmlTag')
		->setAttrib("class","btn btn-primary form-control input-sm");
		$this->addElement($element);
		
	}
			
}