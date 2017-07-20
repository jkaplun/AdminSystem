<?php	

/**
 * 
 * @author jgarfias
 *
 */
class Application_Form_Ordenes_FiltroSeguimientoVentas extends Zend_Form {
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

		// usuario atiende
		$element = new Zend_Form_Element_Select('id_usuario_admin_atiende');
		$element
			->setLabel("Ejecutivo:")
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control input-sm")
			->setAttrib("autocomplete","off")
			->addMultiOptions($options);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Submit('Filtrar');
		$element
		->removeDecorator('HtmlTag')
		->setAttrib("class","btn btn-primary form-control input-sm");
		$this->addElement($element);
		
		// Fecha del Soporte en Sitio
		$element= new Zend_Form_Element_Text('daterange');
		$element
		->setLabel("Rango de Fechas:")
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		->setAttrib("autocomplete","off")
		->setAttrib("class","form-control input-sm");
		$this->addElement($element);
		
		// estatus orden
		$element = new Zend_Form_Element_Select('id_orden_ventas_estatus');
		$element
		->setLabel("Estatus de la llamada:")
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control input-sm")
		->setAttrib("autocomplete","off")
		->addMultiOptions(array(
				0 => 'Todas',
				1 => 'Entrante',
				2 => 'Atendida'
		));
		$this->addElement($element);
		
	}
			
}