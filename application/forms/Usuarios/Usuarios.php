<?php
// located at application/forms/Usuarios/Usuarios.php
 
class Application_Form_Auth_Usuarios extends Zend_Form
{
	public function init()
	{
		// Clave
		$clave = new Zend_Form_Element_Text('clave');
		$clave->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el nombre de usuario.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Usuario"))
		->setAttrib("maxlength","45")
		;
		
		// Password
		$password = new Zend_Form_Element_Password('pwd');
		$password->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el password.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("autocomplete","off")
		->setAttrib("class","form-control")
		->setAttrib("placeholder","Password")
		->setAttrib("maxlength","45")
		;
		
		// Nombre
		$nombre = new Zend_Form_Element_Text('nombre');
		$nombre->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el nombre.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Nombre"))
		->setAttrib("maxlength","75")
		;
		
		// Apellido paterno
		$apellido_paterno = new Zend_Form_Element_Text('apellido_paterno');
		$apellido_paterno->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el apellido paterno.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Apellido paterno"))
		->setAttrib("maxlength","75")
		;
		
		// Apellido materno
		$apellido_materno = new Zend_Form_Element_Text('apellido_materno');
		$apellido_materno->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el apellido materno.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Apellido materno"))
		->setAttrib("maxlength","75")
		;
		
		// Puesto
		$puesto = new Zend_Form_Element_Text('apellido_materno');
		$puesto->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el apellido materno.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Apellido materno"))
		->setAttrib("maxlength","75")
		;
		
		// Email
		$email = new Zend_Form_Element_Text('email');
		$email->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el email")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Email"))
		->setAttrib("maxlength","100")
		;
		
		$permisos = new Zend_Form_Element_MultiCheckbox('permisos');
		$permisos->setAttribs ( array (
				'autocomplete'=>'off'))
				->addMultiOptions(array(
						'admin' => utf8_encode('Administrador'),
						'supervisor' => utf8_encode('Supervisor'),
						'folios' => utf8_encode('Folios'),
						'compila' => utf8_encode('Compila')
				))
				->setSeparator('<br>')
				->removeDecorator('label')
				->removeDecorator('HtmlTag');
		
		/*// Admin
		$admin = new Zend_Form_Element_Checkbox('admin');
		$admin->setRequired(true)
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		;
		
		// Supervisor
		$supervisor = new Zend_Form_Element_Checkbox('supervisor');
		$supervisor->setRequired(true)
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		;
		
		// Folios
		$folios = new Zend_Form_Element_Checkbox('folios');
		$folios->setRequired(true)
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		;
		
		// Compila
		$compila = new Zend_Form_Element_Checkbox('compila');
		$compila->setRequired(true)
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		;*/
		
		// Activo
		$activo = new Zend_Form_Element_Checkbox('activo');
		$activo->setAttribs ( array (
				'autocomplete'=>'off'))
				->removeDecorator('label')
				->setValue('si')
				->removeDecorator('HtmlTag');
		;
		
		// Submit
		$submit = new Zend_Form_Element_Submit('submit');
		$submit	->setLabel("Iniciar")
		->setAttrib("class","btn btn-lg btn-success btn-block")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		;

		$id_usuario = new Zend_Form_Element_Hidden('id_usuario');
		
		$this
		->setMethod('post')
		->addElements(array(
				$clave, $password, $nombre, $apellido_paterno, 
				$apellido_materno, $puesto, $email, /*$admin, 
				$supervisor, $folios, $compila*/$permisos, $activo, $id_usuario, $submit
				));
		}
}