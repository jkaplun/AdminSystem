<?php
 /**
  * 
  * @author jgarfias
  *
  */
class Application_Form_Actualizaciones_Actualizacion extends Zend_Form{
    public function init(){

    	
    	$agencia = new Application_Model_DbTable_Agencia();
    	$element= new Zend_Form_Element_Select('id_agencia');
    	$agencias = $agencia->obtenerTodasLasAgencias();
    	
    	$listaAgencias = array();
    	foreach ( $agencias as $agencias){
    		$listaAgencias[$agencias['id_agencia']]=$agencias['nombre'];
    	}
    	
    	$element
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
    	
    	$this->addElement($element);

    	$producto = new Application_Model_DbTable_Producto();
    	$productos = $producto->obtenerProductosVigentes();
    	$options = array(
    			'' => 'Seleccione un Producto'
    	);
    	foreach ($productos as $key => $value){
    		$options[$value['id_producto']] = $value['nombre_prod'];
    	}
    	 
    	$element= new Zend_Form_Element_Select('id_producto');
    	
    	$element
    	->setLabel("Producto:")
    	->setRequired(true)
    	->addErrorMessage("Es necesario que seleccione un producto")
    	->removeDecorator('HtmlTag')
    	->addMultiOptions($options)
    	->setAttrib("class","form-control")
    	->setAttrib("autocomplete","off");
    	
    	$this->addElement($element);
    	
    	
    	$inputsText =  array(
    			array(
    					'name' => 'titulo_update',
    					'label' => 'Título:',
    					'placeholder' => 'Título',
    					'maxlength' => 100
    			),
    			array(
    					'name' => 'version_update',
    					'label' => 'Vérsion:',
    					'placeholder' => 'Vérsión',
    					'maxlength' => 10
    			),
    			array(
    					'name' => 'http_update',
    					'label' => 'HTTP:',
    					'placeholder' => 'HTTP://',
    					'maxlength' => 1000
    			),
    			array(
    					'name' => 'path_update',
    					'label' => 'Ruta:',
    					'placeholder' => 'Ruta',
    					'maxlength' => 1000
    			),
    			array(
    					'name' => 'archivo_update',
    					'label' => 'Nombre del Archivo:',
    					'placeholder' => 'Nombre del Archivo',
    					'maxlength' => 400
    			),
    	);

    	foreach ( $inputsText as $values ) {
    		$this->createInputText($values);
    	}
    	
    	
    	$element = new Zend_Form_Element_Textarea('descripcion');
    	$element->setRequired(false)
    	->setLabel("Descripción")
    	->removeDecorator('HtmlTag')
    	->setAttrib("class","form-control")
    	->setAttrib("autocomplete","off")
    	->setAttrib("rows","5")
    	->setAttrib("placeholder",("Descripción"))
    	->setAttrib("maxlength",1000);
    	
    	$this->addElement($element);
    	
    	// Submit
    	$submit = new Zend_Form_Element_Submit('Guardar');
    	$submit
    	->setAttrib("class","btn btn-lg btn-success btn-block")
    	->removeDecorator('label')
    	->removeDecorator('HtmlTag')
    	->removeDecorator('Errors');
    	
    	$this->addElement($submit);
    	
    	// Submit
    	$submit = new Zend_Form_Element_Submit('Cerrar');
    	$submit
    	->setAttrib("class","btn btn-lg btn-success btn-block")
    	->removeDecorator('label')
    	->removeDecorator('HtmlTag')
    	->removeDecorator('Errors');
    	
    	$this->addElement($submit);
    }
    
    public  function createInputText($values){
    	
    	$element = new Zend_Form_Element_Text($values['name']);
    	$element->setRequired(false)
    	->setLabel($values['label'])
    	->removeDecorator('HtmlTag')
    	->setAttrib("class","form-control")
    	->setAttrib("autocomplete","off")
    	->setAttrib("placeholder",$values['placeholder'])
    	->setAttrib("maxlength",$values['maxlength']);
    	
    	$this->addElement($element);
    }
    
    
    
    
}