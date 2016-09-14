<?php
// located at application/forms/Auth/Login.php
 
class Application_Form_Ordenes_NuevaOrden extends Zend_Form
{
	public function init()
	{
		// RFC
		$rfc = new Zend_Form_Element_Text('empresa');
		$rfc->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca una empresa.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Empresa"))
		->setAttrib("maxlength","15")
		;
		
		
		// RFC
		$nombre = new Zend_Form_Element_Text('producto');
		$nombre->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el producto.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Producto"))
		->setAttrib("maxlength","45")
		;

		// RFC
		$nombre = new Zend_Form_Element_Text('solicito');
		$nombre->setRequired(true)
		->addErrorMessage("- Es necesario que quien solicito el servicio.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Solicito"))
		->setAttrib("maxlength","45")
		;

		// RFC
		$nombre = new Zend_Form_Element_Text('ejecutivo');
		$nombre->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el ejecutivo que atendera el soporte.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Ejecutivo"))
		->setAttrib("maxlength","45")
		;

		// RFC
		$nombre = new Zend_Form_Element_Text('motivo');
		$nombre->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el motivo del soporte.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Motivo"))
		->setAttrib("maxlength","45")
		;

		// RFC
		$nombre = new Zend_Form_Element_Text('descripcion');
		$nombre->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca la descripcion de la ayuda.")
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
		->addElements(array($rfc, $nombre, $submit,$idcliente));
		}
}