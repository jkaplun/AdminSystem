<?php

class Application_Form_Scrum_TicketForm extends Zend_Form
{
    public function init()
    {
    	
    	$this->setMethod('post');
    	
        // titulo
        $titulo = new Zend_Form_Element_Text('titulo');
        $titulo->setRequired(true)
        ->setLabel("Título")
        ->addFilters(array('StringTrim'))
        ->addErrorMessage("- Es necesario que introduzca el titulo.")
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",("Título"))
        ->setAttrib("maxlength","1000");

        $this->addElement($titulo);
        
        // descripcion
        $descripcion = new Zend_Form_Element_Textarea('descripcion');
        $descripcion
        ->setLabel("Descripción")
        ->addFilters(array('StringTrim'))
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder","Descripción...")
        ->setAttrib("maxlength","5000")
        ->setAttrib("rows","5");

        $this->addElement($descripcion);
 
        $rh = new Application_Model_DbTable_ScrumRH();
        $rhs = $rh->obtenerRH();
        //echo "<pre>".print_r($this->view->rhs,true)."</pre>";die;
        
        $lista = array();
        foreach ( $rhs as $rh){
        	$lista[$rh['id_scrum_recursos_humanos']]=$rh['nombre_completo'];
        }
        
        // id_rh_asignado
        
        
        $id_rh_asignado = new Zend_Form_Element_Select('id_rh_asignado');
        $id_rh_asignado->setRequired(true)
        ->setLabel("RH Asignado")
        ->setValue(1)
        ->removeDecorator('HtmlTag')
        ->addMultiOptions($lista)
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($id_rh_asignado);

        // fecha_alta
        $fecha_alta = new Zend_Form_Element_Text('fecha_alta');
        $fecha_alta
        ->setLabel("Fecha de Alta")
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control datepicker")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("YYYY-MM-DD"))
        ->setAttrib("maxlength","10")
        ->setAttrib("readonly","readonly")
        ->setAttrib("data-date-format","yyyy-mm-dd")
        ->setAttrib("data-provide","datepicker");
        
        
        $this->addElement($fecha_alta);
        
        // fecha_inicio
        $fecha_inicio = new Zend_Form_Element_Text('fecha_inicio');
        $fecha_inicio
        ->setLabel("Fecha de Inicio")
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control datepicker")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("YYYY-MM-DD"))
        ->setAttrib("maxlength","10")
        ->setAttrib("readonly","readonly")
        ->setAttrib("data-date-format","yyyy-mm-dd")
        ->setAttrib("data-provide","datepicker");
        
        $this->addElement($fecha_inicio);
 
        // fecha_cierre
        $fecha_cierre = new Zend_Form_Element_Text('fecha_cierre');
        $fecha_cierre
        ->setLabel("Fecha de Cierre")
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control datepicker")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("YYYY-MM-DD"))
        ->setAttrib("maxlength","10")
        ->setAttrib("readonly","readonly")
        ->setAttrib("data-date-format","yyyy-mm-dd")
        ->setAttrib("data-provide","datepicker");
        $this->addElement($fecha_cierre);
        
        // fecha_cierre
        $fecha_estimada_inicio = new Zend_Form_Element_Text('fecha_estimada_inicio');
        $fecha_estimada_inicio
        ->setLabel("Fecha Estimada de Inicio")
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control datepicker")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("YYYY-MM-DD"))
        ->setAttrib("maxlength","10")
        ->setAttrib("readonly","readonly")
        ->setAttrib("data-date-format","yyyy-mm-dd")
        ->setAttrib("data-provide","datepicker");
        $this->addElement($fecha_estimada_inicio);
        
        // dificultad
        $dificultad = new Zend_Form_Element_Select('dificultad');
        $dificultad->setRequired(true)
        ->setLabel("Dificultad")
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
        	'1' => 'Baja',
        	'3' => 'Media',
        	'4' => 'Alta',
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off");
        $this->addElement($dificultad);
        
        // sprint
        $sprint = new Zend_Form_Element_Select('sprint');
        $sprint->setRequired(true)
        ->setLabel("Sprint")
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
        		'1' => 'Sprint 1',
        		'3' => 'Sprint 2',
        		'4' => 'Sprint 3',
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off");
        $this->addElement($sprint);
        
        // url
        $url = new Zend_Form_Element_Text('url');
        $url
        ->setLabel("Url")
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("URL"))
        ->setAttrib("maxlength","5000");
        $this->addElement($url);
        
        $set = new Application_Model_DbTable_ScrumStatusTicket();
        $sets = $set->obtenerStatus();
        
        $lista2 = array();
        foreach ( $sets as $rh){
        	$lista2[$rh['id_scrum_estatus_ticket']]=$rh['descripcion'];
        }
        
        // sprint
        $id_estatus_ticket = new Zend_Form_Element_Select('id_estatus_ticket');
        $id_estatus_ticket->setRequired(true)
        ->setLabel("Status de Ticket")
        ->removeDecorator('HtmlTag')
        ->addMultiOptions($lista2)
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off");
        $this->addElement($id_estatus_ticket);
        
        // Submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit ->setLabel("Agregar")
        ->setAttrib("class","btn btn-lg btn-success btn-block")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ;
        $this->addElement($submit);
        }
}