<?php
// located at application/forms/Usuarios/Usuarios.php
 
class Application_Form_Agencias_Busquedagencias extends Zend_Form
{
    public function init()
    {
        
        // Nombre
        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Nombre"))
        ->setAttrib("maxlength","225")
        ;
        $this->addElement($nombre);

        // Nombre Comercial
        $nombre_comercial = new Zend_Form_Element_Text('nombre_comercial');
        $nombre_comercial->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Nombre comercial"))
        ->setAttrib("maxlength","225")
        ;
        $this->addElement($nombre_comercial);   

        // Rfc
        $rfc = new Zend_Form_Element_Text('rfc');
        $rfc->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("R.F.C."))
        ->setAttrib("maxlength","13")
        ->setAttrib("minlength","12")
        ;
        $this->addElement($rfc);
        
        // Estatus
        $estatus = new Zend_Form_Element_Select('estatus');
        $estatus
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($estatus);


        // C.P.
        $cp = new Zend_Form_Element_Text('cp');
        $cp->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder","Codigo postal")
        ->setAttrib("maxlength","5")
        ->setAttrib("minlength","5")
        ;
        $this->addElement($cp);
        
        // Ciudad
        $ciudad = new Zend_Form_Element_Select('ciudad');
        $ciudad
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($ciudad);

        // Estado
        $estado = new Zend_Form_Element_Select('estado');
        $estado
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($estado);
        
        // Email
        $email = new Zend_Form_Element_Text('email');
        $email->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Email"))
        ->setAttrib("maxlength","100")
        ;
        $this->addElement($email);

        // Contacto
        $contacto = new Zend_Form_Element_Text('contacto');
        $contacto->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Contacto"))
        ->setAttrib("maxlength","100")
        ;
        $this->addElement($contacto);

        // Ejecutivo
        $ejecutivo = new Zend_Form_Element_Text('ejecutivo');
        $ejecutivo->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Ejecutivo"))
        ->setAttrib("maxlength","100")
        ;
        $this->addElement($ejecutivo);

        // Licencias
        $licencias = new Zend_Form_Element_Select('licencias');
        $licencias->setAttribs ( array (
                'autocomplete'=>'off'))
                ->addMultiOptions(array())
                ->removeDecorator('name')              
                ->removeDecorator('label')
                ->removeDecorator('HtmlTag')
                ->setValue('producto1')
                ->setAttrib("class","form-control")
                ->setAttrib("autocomplete","off")
                ->setAttrib("name","licencias[]")
                ->setAttrib("multiple","multiple")
                ;
        ;
        $this->addElement($licencias);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit ->setLabel("Generar Reporte")
        ->setAttrib("class","btn btn-lg btn-success btn-block")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ;
        $this->addElement($submit);
    }
}