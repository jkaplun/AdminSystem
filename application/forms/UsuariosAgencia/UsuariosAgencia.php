<?php
// located at application/forms/UsuariosAgencia/UsuariosAgencia.php
 
class Application_Form_UsuariosAgencia_UsuariosAgencia extends Zend_Form
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
        ->setAttrib("maxlength","15")
        //->setAttrib('disabled', 'disabled');
        ;
        $this->addElement($clave);
        
        // Password
        $password = new Zend_Form_Element_Password('pwd');
        $password->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca el password.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("autocomplete","off")
        ->setAttrib("class","form-control")
        ->setAttrib("placeholder","Password")
        ->setAttrib("maxlength","15")
        ;
        $this->addElement($password);
        
        
        // Password
        $password_conf = new Zend_Form_Element_Password('pwd_conf');
        $password_conf
        ->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca el password.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("autocomplete","off")
        ->setAttrib("class","form-control")
        ->setAttrib("placeholder","Confirmar password")
        ->setAttrib("maxlength","15")
        ;
        $this->addElement($password_conf);
        
        // Nombre
        $nombre = new Zend_Form_Element_Text('nombreUsuarioAgencia');
        $nombre->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca el nombre.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Nombre"))
        ->setAttrib("maxlength","50")
        ;
        $this->addElement($nombre);
        
        // Apellidos
        $apellidos = new Zend_Form_Element_Text('apellidos');
        $apellidos->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca los apellidos.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Apellidos"))
        ->setAttrib("maxlength","50")
        ;
        $this->addElement($apellidos);
        
        // Puesto
        $puesto = new Zend_Form_Element_Text('puesto');
        $puesto->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca el puesto.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Puesto"))
        ->setAttrib("maxlength","50")
        ;
        $this->addElement($puesto);
        
        // Teléfono
        $telefono = new Zend_Form_Element_Text('telefono');
        $telefono->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca el teléfono.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Telefono"))
        ->setAttrib("maxlength","50")
        ;
        $this->addElement($telefono);
        
        // Extensión
        $ext = new Zend_Form_Element_Text('ext');
        $ext->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("ext"))
        ->setAttrib("maxlength","45")
        ;
        $this->addElement($ext);
        
        // Celular
        $celular = new Zend_Form_Element_Text('celular');
        $celular->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("ext"))
        ->setAttrib("maxlength","50")
        ;
        $this->addElement($celular);
        
        // Email
        $email = new Zend_Form_Element_Text('emailUsuarioAgencia');
        $email->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca el email")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Email"))
        ->setAttrib("maxlength","50")
        ;
        $this->addElement($email);
        
        // Activo
        $activo = new Zend_Form_Element_Select('activo');
        $activo->setAttribs ( array (
                'autocomplete'=>'off'))
                ->addMultiOptions(array(
                        'S'=>'Activo',
                        'N'=>'Inactivo'
                ))
                ->setAttrib("class","form-control")                
                ->removeDecorator('label')
                ->setValue('si')
                ->removeDecorator('HtmlTag');
        ;
        $this->addElement($activo);
        
        // Líder de proyecto
        $lider_proy = new Zend_Form_Element_Select('lider_proy');
        $lider_proy->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Si',
                'N'=>'No'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($lider_proy);
        
        // Director
        $director = new Zend_Form_Element_Select('director');
        $director->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Si',
                'N'=>'No'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($director);
        
        // admin_FE
        $admin_fe = new Zend_Form_Element_Select('admin_fe');
        $admin_fe->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($admin_fe);
        
        // nuevo
        $nuevo = new Zend_Form_Element_Select('nuevo');
        $nuevo->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($nuevo);
        
        // actualizar_pass
        $actualizar_pass = new Zend_Form_Element_Select('actualizar_pass');
        $actualizar_pass->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($actualizar_pass);
        
        // Enviar reporte portal MIG
        $enviar_reporte_portal_mig = new Zend_Form_Element_Select('enviar_reporte_portal_mig');
        $enviar_reporte_portal_mig->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($enviar_reporte_portal_mig);
        
        // Bajar updates
        $bajar_updates = new Zend_Form_Element_Select('bajar_updates');
        $bajar_updates->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($bajar_updates);
        
        // Submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit ->setLabel("Iniciar")
        ->setAttrib("class","btn btn-lg btn-success btn-block")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ;
        $id_agencia = new Zend_Form_Element_Hidden('id_agencia');
        
        $this
        ->setMethod('post');
      }
}