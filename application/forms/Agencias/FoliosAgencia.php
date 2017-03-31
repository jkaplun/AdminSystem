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
    	$element = new Zend_Form_Element_Hidden('id_agencia_folios');
    	$element->removeDecorator('HtmlTag')
    		->removeDecorator('label');
    	$this->addElement($element);
    	
    	// id_folios_agencia_form Para editar Folios
    	$element = new Zend_Form_Element_Hidden('id_folios_agencia_form');
    	$element->removeDecorator('HtmlTag')
	    	->removeDecorator('label');
    	$this->addElement($element);
    	
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
        	->setLabel("Observaciones")
	        ->removeDecorator('HtmlTag')
	        ->setAttrib("rows","3")
	        ->setAttrib("class","form-control")
	        ->setAttrib("class","form-control")
	        ->setAttrib("autocomplete","off")
	        ->addFilter('StringTrim')
	        ->setAttrib("placeholder",utf8_encode("Observaciones"));
        $this->addElement($observaciones);
        
        // Folios Agencia
        $element = new Zend_Form_Element_Select('id_folios_agencia_cat_tipo');
        $element
        	->setLabel("Tipo de Folios:")
	        ->removeDecorator('HtmlTag')
	        ->setAttrib("class","form-control")
	        ->setAttrib("class","form-control")
	        ->setAttrib("autocomplete","off")
	       	 ->addMultiOptions(array(
                '1'=>'Icaav',
                '2'=>'Nomina'
        	))
	        ->addFilter('StringTrim');
        $this->addElement($element);
        

        // Pack de timbrado
        $element = new Zend_Form_Element_Select('prov_timbrado');
        $element
        ->setLabel("Tipo de Folios:")
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->addMultiOptions(array(
        		'1'=>'Icaav',
        		'2'=>'Nomina'
        ))
        ->addFilter('StringTrim');
        $this->addElement($element);
        
        }
}