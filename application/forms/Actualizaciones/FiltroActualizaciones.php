<?php	

/**
 * 
 * @author jgarfias
 *
 */
class Application_Form_Actualizaciones_FiltroActualizaciones extends Zend_Form {
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see Zend_Form::init()
	 */
	public function init(){
		
		$agencia = new Application_Model_DbTable_Agencia();
		$selectAgencias = new Zend_Form_Element_Select('id_agencia');
		$agencias = $agencia->obtenerTodasLasAgencias();
		
		$listaAgencias = array("" => "Todas");
		foreach ( $agencias as $agencias){
			$listaAgencias[$agencias['id_agencia']]=$agencias['nombre'];
		}
		
		$selectAgencias
		->setLabel("Agencia:")
		->setRequired(true)
		->addErrorMessage("Es necesario que seleccione la Agencia")
		->removeDecorator('HtmlTag')
		->addMultiOptions($listaAgencias)
		->setAttrib("class","form-control selectpicker input-sm")
		->setAttrib("data-max-options",10)
		->setAttrib("data-live-search","true")
		->setAttrib("title","Ingresa nombre de la agencia...")
		->setAttrib("autocomplete","off");
		
		$this->addElement($selectAgencias);
		
		
		$element = new Zend_Form_Element_Submit('Filtrar');
		$element
		->removeDecorator('HtmlTag')
		->setAttrib("class","btn btn-primary form-control input-sm");
		$this->addElement($element);
		
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
		
		$user = $usuario_admin->getSoporteUsers();
		$options = array(''=>'Todos');
		foreach ($user as $value){
			$options[$value['id_usuario']] = $value['clave'];
		}
		
		// usuario atiende
		$element = new Zend_Form_Element_Select('id_usuario_solicita');
		$element
		->setLabel("Ejecutivo:")
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control input-sm")
		->setAttrib("autocomplete","off")
		->addMultiOptions($options);
		$this->addElement($element);
		
		// Fecha Actualizacion
		$element= new Zend_Form_Element_Text('daterange');
		$element
		->setLabel("Rango de Fechas:")
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		->setAttrib("autocomplete","off")
		->setAttrib("class","form-control input-sm");
		$this->addElement($element);
		
	}		
}