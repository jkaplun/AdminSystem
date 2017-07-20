<?php
 
class Application_Form_Ordenes_NuevaOrdenVentas extends Zend_Form
{
	public function init()
	{

		$element = new Zend_Form_Element_Hidden('formulario');
		$element
			->removeDecorator('HtmlTag')
			->removeDecorator('label')
			->setValue("ventas");
		
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Hidden('id_orden_ventas');
		$element->removeDecorator('HtmlTag')->removeDecorator('label');
		$this->addElement($element);
		
		$element= new Zend_Form_Element_Hidden('id_agencia');
		$element->removeDecorator('HtmlTag')->removeDecorator('label');
		$this->addElement($element);
		
		$agencia = new Application_Model_DbTable_Agencia();
		$selectAgencias = new Zend_Form_Element_Select('select_agencias_ventas');
		$agencias = $agencia->obtenerTodasLasAgencias();
		
		$listaAgencias = array(''=>'Sin Agencia');
		foreach ( $agencias as $agencia){
			$listaAgencias[$agencia['id_agencia']]=$agencia['nombre'];
		}
			
		$selectAgencias
		->setLabel("Agencia (Opcional)")
		->setValue('')
		->addMultiOptions($listaAgencias)
		->setAttrib("class","form-control selectpicker")
		->setAttrib("data-max-options",10)
		->setAttrib("data-live-search","true")
		->setAttrib("title","Ingresa nombre de la agencia...")
		->setAttrib("autocomplete","off");
		
		$this->addElement($selectAgencias);
		
		$element= new Zend_Form_Element_Select('select_ejecutivo');
		
		$usuarioAdmin= new Application_Model_DbTable_UsuarioAdmin();
		$ejecutivos = $usuarioAdmin->getSalesUsers();
		
		$listaEjecutivos = array();
		foreach ( $ejecutivos as $elemento){
			$listaEjecutivos[$elemento['id_usuario']]=$elemento['nombre']." ".$elemento['apellido_paterno'];
		}
		
		
		$element
		->setLabel("Ejecutivo de Ventas")
		->addMultiOptions($listaEjecutivos)
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off");
		
		$this->addElement($element);
		
		
		$element= new Zend_Form_Element_Text('nombre_agencia');
		$element->setRequired(true)
			->setLabel("Nombre de la Agencia")
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off")
			->setAttrib("placeholder",utf8_encode("Agencia"))
			->setAttrib("maxlength","1000");
		
		$this->addElement($element);
		
		$element= new Zend_Form_Element_Text('nombre_contacto');
		$element
			->setRequired(true)
			->setLabel("Nombre del Contacto")
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off")
			->setAttrib("placeholder",utf8_encode("Contacto"))
			->setAttrib("maxlength","1000");
		
		$this->addElement($element);
		
		$element= new Zend_Form_Element_Text('email');
		$element->setRequired(true)
			->setLabel("E-mail")
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off")
			->setAttrib("placeholder",utf8_encode("Email"))
			->setAttrib("maxlength","250");
		
		$this->addElement($element);
		
		$element= new Zend_Form_Element_Text('telefono');
		$element->setRequired(true)
		->setLabel("Teléfono")
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder", "Teléfono" )
		->setAttrib("maxlength","45");
		
		$this->addElement($element);
		
		$element= new Zend_Form_Element_Textarea('motivo');
		$element
		->setLabel("Motivo")
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("rows","5")
		->setAttrib("placeholder",("Motivo"));
		$this->addElement($element);
		
		$element= new Zend_Form_Element_Textarea('solucion');
		$element
		->setLabel("Solución")
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("rows","5")
		->setAttrib("placeholder",("Solución"));
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Button("Registrar");
		$element->setAttrib("class","btn btn-lg btn-success");
		
		$this->addElement($element);
	
		$this->setAttrib('id','form-ventas');
	}
			
}