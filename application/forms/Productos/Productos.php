<?php
// located at application/forms/Productos/Productos.php
 
class Application_Form_Productos_Productos extends Zend_Form
{
    public function init()
    {
        // Clave
        $clave = new Zend_Form_Element_Text('clave');
        $clave->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca la clave del producto.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Clave"))
        ->setAttrib("maxlength","10")
        //->setAttrib("minlength","10")
        //->setAttrib('disabled', 'disabled');
        ;
        
        // Nombre
        $nombre_prod = new Zend_Form_Element_Text('nombre_prod');
        $nombre_prod->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca el nombre del producto.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("autocomplete","off")
        ->setAttrib("class","form-control")
        ->setAttrib("placeholder",utf8_encode("Nombre"))
        ->setAttrib("maxlength","50")
        ;
        
        
        // Version
        $version_prod = new Zend_Form_Element_Text('version_prod');
        $version_prod->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca la versi&oacute;n del producto.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder","Versión")
        ->setAttrib("maxlength","75")
        ;
        
        // Ruta
        $ruta_prod = new Zend_Form_Element_Text('ruta_prod');
        $ruta_prod->setRequired(true)
        ->addErrorMessage("- Es necesario la ruta del producto.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Ruta"))
        ->setAttrib("maxlength","50")
        ;
        
        
        // Cargo
        $cargo_prod = new Zend_Form_Element_Select('cargo_prod');
        $cargo_prod->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        
        // Compila
        $compila_prod = new Zend_Form_Element_Select('compila_prod');
        $compila_prod->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        
        // Vigente
        $vigente_prod = new Zend_Form_Element_Select('vigente_prod');
        $vigente_prod->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;

        $this
        ->setMethod('post')
        ->addElements(array(
                $clave, $nombre_prod, $version_prod, $ruta_prod, $cargo_prod, 
                $compila_prod, $vigente_prod
                ));
    }

}