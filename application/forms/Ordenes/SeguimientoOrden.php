<?php	
// located at application/forms/Auth/Login.php
 
class Application_Form_Ordenes_SeguimientoOrden extends Zend_Form
{
	public function init()
	{

		$id_orden_servicio = new Zend_Form_Element_Hidden('id_orden_servicio');
		$id_orden_servicio->removeDecorator('HtmlTag')->removeDecorator('label');
		$this->addElement($id_orden_servicio);
		
		$options = array();
		
		// póliza
		$element = new Zend_Form_Element_Select('id_producto');
		$element
//			->removeDecorator('label')
			->setLabel("Producto")
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off")
			->addMultiOptions($options);
		$this->addElement($element);
		
		
		// póliza
		$element = new Zend_Form_Element_Select('id_poliza');
		$element
		->setLabel("Poliza")
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setOptions($options);
		$this->addElement($element);
		

		// póliza
		$element = new Zend_Form_Element_Select('id_usuario_admin_atiende');
		$element
		->setLabel("Ejecutivo")
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setOptions($options);
		$this->addElement($element);
		
		// numero de licencias
		$element = new Zend_Form_Element_Select('id_motivo');
		$element
		->setLabel("Motivo")
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->addMultiOptions($this->getOrdenMotivo());
		$this->addElement($element);
		
		// Tipo de soporte
		$element = new Zend_Form_Element_Select('id_tipo_soporte');
		$element
		->setLabel("Tipo de Soporte")
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->addMultiOptions($this->getTipoSoporte());
		
		$this->addElement($element);

		// descripcion
		$element = new Zend_Form_Element_Textarea('comentarios_recepcion');
		$element
			->setLabel("Comentario")
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off")
			->setAttrib("rows","5")
			->setAttrib("placeholder",("Descripción"));
		$this->addElement($element);
		
		// duracion
		$element = new Zend_Form_Element_Text('duracion');
		$element->setRequired(true)
			->addErrorMessage("- Es necesario indicar la duración del servicio.")
			->setLabel("Duración")
			->removeDecorator('HtmlTag')
			//->removeDecorator('Errors')
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off")
			->setAttrib("placeholder","Duración del Servicio")
			->setAttrib("maxlength","45")
	        ->setAttrib("data-mask","__:__:__")
	        ->setValue("__:__:__");
		$this->addElement($element);

		$this
		->setMethod('post')
		->setAction('public/ordenes/nueva-orden');
		
		// Usuario Agencia solicitó
		$element = new Zend_Form_Element_Select('id_usuario_agencia_solicito');
		$element
		->setLabel("Solicitó")
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off");
		
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text('solicito_otro');
		$element->setRequired(false)
			->setLabel("Solicitó [Otro]")
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off")
			->setAttrib("placeholder",utf8_encode("Otro"))
			->setAttrib("maxlength","245");
		
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text('conformidad');
		$element->setRequired(false)
		->setLabel("Conformidad")
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Conformidad"))
		->setAttrib("maxlength","245");
		
		$this->addElement($element);
	
		$element = new Zend_Form_Element_Textarea('motivo_orden');
		$element->setRequired(false)
			->setLabel("Motivo")
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off")
			->setAttrib("rows","5")
			->setAttrib("placeholder",("Descripción"));
		
		$this->addElement($element);

		$element = new Zend_Form_Element_Textarea('solucion_orden');
		$element->setRequired(false)
			->setLabel("Solución")
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off")
			->setAttrib("rows","5")
			->setAttrib("placeholder",("Descripción"));
		
		$this->addElement($element);
		
		
	}
			
	public function getOrdenMotivo(){
		$os = new Application_Model_DbTable_OrdenServicio();
		$result = $os->obtenerMotivos();
		
		$options = array();
		
		foreach ($result as $key => $value){
			$options[$value['id_motivo']] = $value['motivo'];
		}
		return $options;
	}
	
	public function getTipoSoporte(){
		$os = new Application_Model_DbTable_OrdenServicio();
		$result = $os->obtenerTipoDeSoporte();
		$options = array();
		
		foreach ($result as $key => $value){
			$options[$value['id_tipo_soporte']] = $value['description'];
		}
		return $options;
	}
}