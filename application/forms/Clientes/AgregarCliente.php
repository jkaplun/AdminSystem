<?php
// located at application/forms/Auth/Login.php
 
class Application_Form_Clientes_AgregarCliente extends Zend_Form
{
	public function init()
	{
		// RFC
		$rfc = new Zend_Form_Element_Text('rfc');
		$rfc->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el RFC.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("RFC"))
		->setAttrib("maxlength","15")
		;
		
		
		// RFC
		$nombre = new Zend_Form_Element_Text('nombre');
		$nombre->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el Nombre.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Nombre"))
		->setAttrib("maxlength","45")
		;
		// $username->setRequired(true);
		
		// Submit
		$submit = new Zend_Form_Element_Submit('submit');
		$submit	->setLabel("Guardar")
		->setAttrib("class","btn btn-lg btn-success btn-block")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		;

		$idcliente = new Zend_Form_Element_Hidden('idclientes');

		$this
		->setMethod('post')
		->setAction('public/clientes/agregar')
		->addElements(array($rfc, $nombre, $submit,$idcliente));
		}
}