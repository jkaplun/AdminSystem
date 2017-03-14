<?php
// located at application/forms/Auth/Login.php
 
class Application_Form_Ordenes_NuevaOrden extends Zend_Form
{
	public function init()
	{

    	$id_agencia = new Zend_Form_Element_Hidden('id_agencia');
    	$this->addElement($id_agencia);
		
		// empresa
		$empresa = new Zend_Form_Element_Text('empresa');
		$empresa->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca una empresa.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Empresa"))
		->setAttrib("maxlength","15")
		;
		
		// póliza
		$id_poliza = new Zend_Form_Element_Text('poliza');
		$id_poliza->setRequired(true)
		->addErrorMessage("- Es necesario que elija una póliza.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Empresa"))
		->setAttrib("maxlength","15")
		;
		
		
		// producto
		$producto = new Zend_Form_Element_Text('producto');
		$producto->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el producto.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Producto"))
		->setAttrib("maxlength","45")
		;

		// solicito
		$solicito = new Zend_Form_Element_Select('solicito');
		$solicito->setRequired(true)
			->addErrorMessage("- Es necesario indicar quién solicitó el servicio.")
			->removeDecorator('label')
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off");
		$this->addElement($solicito);
		
		// ejecutivo
		$ejecutivo = new Zend_Form_Element_Text('ejecutivo');
		$ejecutivo->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el ejecutivo que atenderá el servicio.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Ejecutivo"))
		->setAttrib("maxlength","45")
		;


		$os = new Application_Model_DbTable_OrdenServicio();
		$result = $os->obtenerMotivos();
		
		$options = array();
		
		foreach ($result as $key => $value){
			$options[$value['id_motivo']] = $value['motivo'];
		}
		
		// numero de licencias
		$motivo = new Zend_Form_Element_Select('id_motivo');
		$motivo
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->addMultiOptions($options);
		
		$this->addElement($motivo);
		
		$result = $os->obtenerTipoDeSoporte();
		
		$options = array();
		
		foreach ($result as $key => $value){
			$options[$value['id_tipo_soporte']] = $value['description'];
		}
		
		// numero de licencias
		$id_tipo_soporte = new Zend_Form_Element_Select('id_tipo_soporte');
		$id_tipo_soporte
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->addMultiOptions($options);
		
		$this->addElement($id_tipo_soporte);
		
		// descripcion
		$descripcion = new Zend_Form_Element_Textarea('descripcion');
		$descripcion
			->addErrorMessage("- Es necesario que introduzca la descripción de la ayuda.")
			->removeDecorator('label')
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off")
			->setAttrib("rows","5")
			->setAttrib("placeholder",("Descripción"));


		// $username->setRequired(true);
		
		// Submit
		$submit = new Zend_Form_Element_Submit('submit');
		$submit	->setLabel("Guardar Nueva Orden")
		->setAttrib("class","btn btn-lg btn-success btn-block")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		;

		// duracion
		$duracion = new Zend_Form_Element_Text('duracion');
		$duracion->setRequired(true)
		->addErrorMessage("- Es necesario indicar la duración del servicio.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder","Duración del Servicio")
		->setAttrib("maxlength","45")
        ->setAttrib("data-mask","__:__:__")
        ->setValue("__:__:__")
		;


		$idcliente = new Zend_Form_Element_Hidden('idclientes');

		$this
		->setMethod('post')
		->setAction('public/ordenes/nueva-orden')
		->addElements(array($empresa, $id_poliza, $producto, $solicito, $ejecutivo, $motivo, $descripcion, $submit, $idcliente,$duracion));
		
		$solicito_otro = new Zend_Form_Element_Text('solicito_otro');
		
		$solicito_otro->setRequired(false)
			->removeDecorator('label')
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off")
			->setAttrib("placeholder",utf8_encode("Otro"))
			->setAttrib("maxlength","245");
		
		$this->addElement($solicito_otro);
	
	}
		
		

		
}