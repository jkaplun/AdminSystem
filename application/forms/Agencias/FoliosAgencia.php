<?php

/**
 * 
 * @author Juan Garfias
 * 
 *
 */
class Application_Form_Agencias_FoliosAgencia extends Zend_Form
{
    public function init()
    {
    	// id_agencia
    	$id_agencia = new Zend_Form_Element_Hidden('id_agencia_folios');
    	$this->addElement($id_agencia);
    	
    	$validator = new Zend_Validate_Alnum();
        // Folios
        $folios_comprados = new Zend_Form_Element_Text('folios_comprados');
        $folios_comprados->setRequired(true)
        ->addErrorMessage("Verifica los Valores Capturados")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Folios Comprados"))
        ->setAttrib("maxlength","10")
        ->addValidator('alNum')
        ->setRequired(true);
        $this->addElement($folios_comprados);
        
        // Fecha de Compra
        $fecha_compra = new Zend_Form_Element_Text('fecha_compra_folios');
        $fecha_compra->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca los folios de la agencia.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control datepicker")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Folios Comprados"))
        ->setAttrib("maxlength","10")
        ->setAttrib("data-date-format","yyyy-mm-dd")
        ->setRequired(true);
        $this->addElement($fecha_compra);
        
        // Observaciones
        $observaciones = new Zend_Form_Element_Textarea('observaciones_folios');
        $observaciones->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca los folios de la agencia.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("rows","12")
        ->setAttrib("class","form-control")
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Folios Comprados"));
        $this->addElement($observaciones);

        // Estatus
        $estatus = new Zend_Form_Element_Select('estatus_folios');
        $estatus->setAttribs ( array (
                'autocomplete'=>'off'))
                ->addMultiOptions(array(
                        'S'=>'Activo',
                        'N'=>'Inactivo'
                ))
                ->setAttrib("class","form-control")                
                ->removeDecorator('label')
                ->setValue('S')
                ->removeDecorator('HtmlTag');
        ;
        $this->addElement($estatus);
        
        
        }
}