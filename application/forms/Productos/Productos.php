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
                $clave, $nombre_prod, $vigente_prod
                ));
    }

}