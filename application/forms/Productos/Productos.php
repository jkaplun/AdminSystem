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
                $clave, $version_prod, $vigente_prod
                ));
    }

}