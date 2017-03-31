<?php
 /**
  * 
  * @author jgarfias
  *
  */
class Application_Form_Agenda_Agenda extends Zend_Form{
    public function init(){

    	// id_usuario_admin
    	$element = new Zend_Form_Element_Hidden('id_usuario_admin');
    	$element
    		->removeDecorator('HtmlTag')
    		->removeDecorator('label');
    	$this->addElement($element);
    	
    	$agencia = new Application_Model_DbTable_Agencia();
    	$selectAgencias = new Zend_Form_Element_Select('id_agencia');
    	$agencias = $agencia->obtenerTodasLasAgencias();
    	
    	$listaAgencias = array();
    	foreach ( $agencias as $agencias){
    		$listaAgencias[$agencias['id_agencia']]=$agencias['nombre'];
    	}
    	
    	$selectAgencias
    	->setLabel("Agencia:")
    	->setRequired(true)
    	->addErrorMessage("Es necesario que seleccione la Agencia")
    	->removeDecorator('HtmlTag')
    	->addMultiOptions($listaAgencias)
    	->setAttrib("class","form-control selectpicker")
    	->setAttrib("data-max-options",10)
    	->setAttrib("data-live-search","true")
    	->setAttrib("title","Ingresa nombre de la agencia...")
    	->setAttrib("autocomplete","off");
    	
    	$this->addElement($selectAgencias);
    	
    	// Fecha
    	$element = new Zend_Form_Element_Text('fecha');
    	$element
	    	->setRequired(true)
	    	->addErrorMessage("Es necesario que introduzca la fecha.")
			->setLabel("Fecha:")
			->removeDecorator('HtmlTag')
	    	->setAttrib("class","form-control datepicker")
	    	->setAttrib("autocomplete","off")
	    	->setAttrib("placeholder",utf8_encode("yyyy-mm-dd"))
	    	->setAttrib("maxlength","10")
	    	->setAttrib("data-date-format","yyyy-mm-dd")
	    	->setAttrib("readonly",true);
    	$this->addElement($element);
    	
    	$horasArray = array(
    			"" => "Seleccione la hora",
    			"08:00" =>"08:00",
    			"08:30" =>"08:30",
    			"09:00" =>"09:00",
    			"09:30" =>"09:30",
    			"10:00" =>"10:00",
    			"10:30" =>"10:30",
    			"11:00" =>"11:00",
    			"11:30" =>"11:30",
    			"12:00" =>"12:00",
    			"12:30" =>"12:30",
    			"13:00" =>"13:00",
    			"13:30" =>"13:30",
    			"14:00" =>"14:00",
    			"14:30" =>"14:30",
    			"15:00" =>"15:00",
    			"15:30" =>"15:30",
    			"16:00" =>"16:00",
    			"16:30" =>"16:30",
    			"17:00" =>"17:00",
    			"17:30" =>"17:30",
    			"18:00" =>"18:00",
    			"18:30" =>"18:30",
    			"19:00" =>"19:00",
    			"19:30" =>"19:30",
    			"20:00" =>"20:00"
    	);
    	
    	// Hora inicial.
    	$element = new Zend_Form_Element_Select('hora_inicial');
    	$element
	    	->setRequired(true)
	    	->addErrorMessage("Es necesario que introduzca la Hora Inicial.")
	    	->setLabel("Hora Inicial:")
	    	->removeDecorator('HtmlTag')
	    	->setAttrib("class","form-control")
	    	->setAttrib("class","form-control")
	    	->setAttrib("autocomplete","off")
	    	->addMultiOptions($horasArray)
	    	->addFilter('StringTrim');
    	$this->addElement($element);
    	
    	// Hora inicial.
    	$element = new Zend_Form_Element_Select('hora_final');
    	$element
	    	->setRequired(true)
	    	->addErrorMessage("Es necesario que introduzca la Hora Final.")
	    	->setLabel("Hora Final:")
	    	->removeDecorator('HtmlTag')
	    	->setAttrib("class","form-control")
	    	->setAttrib("class","form-control")
	    	->setAttrib("autocomplete","off")
	    	->addMultiOptions($horasArray)
	    	->addFilter('StringTrim');
    	$this->addElement($element);
    	
    	// Contacto
    	$element = new Zend_Form_Element_Text('contacto');
    	$element
	    	->setRequired(true)
	    	->addErrorMessage("Es necesario que introduzca el contacto.")
	    	->setLabel("Contacto:")
	    	->removeDecorator('HtmlTag')
	    	->setAttrib("class","form-control")
	    	->setAttrib("autocomplete","off")
	    	->setAttrib("placeholder", "Contacto")
	    	->setAttrib("maxlength","245");
    	$this->addElement($element);
    	
    	// Observaciones
    	$element= new Zend_Form_Element_Textarea('motivo');
    	$element
	    	->setLabel("Motivo:")
	    	->setRequired(true)
	    	->addErrorMessage("Es necesario que introduzca el motivo.")
	    	->removeDecorator('HtmlTag')
	    	->setAttrib("rows","3")
	    	->setAttrib("class","form-control")
	    	->setAttrib("class","form-control")
	    	->setAttrib("autocomplete","off")
	    	->addFilter('StringTrim')
	    	->setAttrib("placeholder",utf8_encode("Motivo"));
    	$this->addElement($element);
    	
    	// Contacto
    	$element = new Zend_Form_Element_Submit('guardar');
    	$element
    		->removeDecorator('HtmlTag')
    		->setAttrib("class","btn btn-primary");
    	
    	$this->addElement($element);
    	
    }
}