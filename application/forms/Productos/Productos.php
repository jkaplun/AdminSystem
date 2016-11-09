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
        
        // // Nombre
        // $nombre_prod = new Zend_Form_Element_Text('nombre_prod');
        // $nombre_prod->setRequired(true)
        // ->addErrorMessage("- Es necesario que introduzca el nombre del producto.")
        // ->removeDecorator('label')
        // ->removeDecorator('HtmlTag')
        // ->setAttrib("autocomplete","off")
        // ->setAttrib("class","form-control")
        // ->setAttrib("placeholder",utf8_encode("Nombre"))
        // ->setAttrib("maxlength","50")
        // ;
        
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



        // Nombre Producto
        $nombre_prod = new Zend_Form_Element_Select('nombre_prod');
        $nombre_prod->setAttribs ( array (
                'autocomplete'=>'off'))
                ->addMultiOptions(array())
                ->setAttrib("class","form-control")                
                ->removeDecorator('label')
                ->setValue('producto1')
                ->removeDecorator('HtmlTag');
        ;
        $this->addElement($nombre_prod);

                // numero de licencias
        $numero_licencias = new Zend_Form_Element_Text('numero_licencias');
        $numero_licencias
       // ->setRequired(true)
       // ->addErrorMessage("- Es necesario que introduzca el número de licencias.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder","Número de licencias")
        ->setAttrib("maxlength","11")
        ;
        $this->addElement($numero_licencias);


        // Estatus
        $estatus_producto = new Zend_Form_Element_Select('estatus_producto');
        $estatus_producto->setAttribs ( array (
                'autocomplete'=>'off'))
                ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
                ->setAttrib("class","form-control")                
                ->removeDecorator('label')
                ->setValue('activo')
                ->removeDecorator('HtmlTag');
        ;
        $this->addElement($estatus_producto);
        $this
        ->setMethod('post')
        ->addElements(array(
                $clave, $nombre_prod, $vigente_prod
                ));


    }

}