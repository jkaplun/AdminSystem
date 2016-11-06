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
		$solicito = new Zend_Form_Element_Text('solicito');
		$solicito->setRequired(true)
		->addErrorMessage("- Es necesario indicar quién solicitó el servicio.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Solicitó"))
		->setAttrib("maxlength","45")
		;

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

		// motivo
		$motivo = new Zend_Form_Element_Text('motivo');
		$motivo->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el motivo del servicio.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Motivo"))
		->setAttrib("maxlength","45")
		;

		// descripcion
		$descripcion = new Zend_Form_Element_Text('descripcion');
		$descripcion->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca la descripción de la ayuda.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Descripcion"))
		->setAttrib("maxlength","45")
		;


		// $username->setRequired(true);
		
		// Submit
		$submit = new Zend_Form_Element_Submit('submit');
		$submit	->setLabel("Guardar Nueva Orden")
		->setAttrib("class","btn btn-lg btn-success btn-block")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		;

		$idcliente = new Zend_Form_Element_Hidden('idclientes');

		$this
		->setMethod('post')
		->setAction('public/ordenes/nueva-orden')
		->addElements(array($empresa, $id_poliza, $producto, $solicito, $ejecutivo, $motivo, $descripcion, $submit, $idcliente));
		}
}