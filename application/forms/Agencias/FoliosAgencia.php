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
    	// id_agencia  Para agregar folios
    	$id_agencia = new Zend_Form_Element_Hidden('id_agencia_folios');
    	$this->addElement($id_agencia);
    	
    	// id_folios_agencia_form Para editar Folios
    	$id_folios_agencia_form = new Zend_Form_Element_Hidden('id_folios_agencia_form');
    	$this->addElement($id_folios_agencia_form);
    	
    	$validator = new Zend_Validate_Alnum();
        // Folios
        $folios_comprados = new Zend_Form_Element_Text('folios_comprados');
        $folios_comprados->setRequired(true)
        ->addErrorMessage("Verifique los valores capturados.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Folios Comprados"))
        ->setAttrib("maxlength","10")
        ->addValidator('alnum');
        $this->addElement($folios_comprados);
        
        // Fecha de Compra
        $fecha_compra = new Zend_Form_Element_Text('fecha_compra_folios');
        $fecha_compra->setRequired(true)
        ->addErrorMessage("Es necesario que introduzca la fecha de compra.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control datepicker")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("yyyy-mm-dd"))
        ->setAttrib("maxlength","10")
        ->setAttrib("data-date-format","yyyy-mm-dd")
        ->setAttrib("readonly",true);
        $this->addElement($fecha_compra);
        
        // Observaciones
        $observaciones = new Zend_Form_Element_Textarea('observaciones_folios');
        $observaciones
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("rows","12")
        ->setAttrib("class","form-control")
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->addFilter('StringTrim')
        ->setAttrib("placeholder",utf8_encode("Observaciones"));
        $this->addElement($observaciones);
        
        }
}