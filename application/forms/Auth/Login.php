<?php
// located at application/forms/Auth/Login.php
 
class Application_Form_Auth_Login extends Zend_Form
{
	public function init()
	{
		// Username
		$user = new Zend_Form_Element_Text('clave');
		$user->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el usuario.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Usuario"))
		->setAttrib("maxlength","45")
		;
		// $username->setRequired(true);
		
		// Password
		$password = new Zend_Form_Element_Password('pwd');
		$password->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el password.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("autocomplete","off")
		->setAttrib("class","form-control")
		->setAttrib("placeholder","Password")
		->setAttrib("maxlength","45")
		;
		
		// Submit
		$submit = new Zend_Form_Element_Submit('submit');
		$submit	->setLabel("Iniciar")
		->setAttrib("class","btn btn-lg btn-success btn-block")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		;
		
		$this
		->setMethod('post')
		->addElements(array($user, $password, $submit));
		}
}