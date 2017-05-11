<?php

/**
 * 
 * @author Juan Garfias
 * 
 *
 */
class Application_Form_Agencias_FiltroAgencias extends Zend_Form
{
    public function init()
    {
    	$agencia = new Application_Model_DbTable_Agencia();
    	$selectAgencias = new Zend_Form_Element_Select('id_agencia');
    	$agencias = $agencia->obtenerTodasLasAgencias();
    	
    	$listaAgencias = array(''=>'Todas las Agencias');
    	
    	//echo "<pre>".print_r($agencias,true)."</pre>";die;
    	
    	foreach ( $agencias as $agencias){
    		$listaAgencias[$agencias['id_agencia']]=$agencias['nombre'].' ['.$agencias['clave'].']';
    	}
    	
    	$selectAgencias
    	->setLabel("Agencia:")
    	->setRequired(true)
    	->addErrorMessage("Es necesario que seleccione la Agencia")
    	->removeDecorator('HtmlTag')
    	->addMultiOptions($listaAgencias)
    	->setAttrib("class","form-control selectpicker input-sm")
    	->setAttrib("data-max-options",10)
    	->setAttrib("data-live-search","true")
    	->setAttrib("title","Ingresa nombre de la agencia...")
    	->setAttrib("autocomplete","off");
    	
    	$this->addElement($selectAgencias);
    	
    	$options = array();
    	$usuario_admin = new Application_Model_DbTable_UsuarioAdmin();
    	
    	$user = $usuario_admin->getSoporteUsers();
    	$options = array(''=>'Todos');
    	foreach ($user as $value){
    		$options[$value['id_usuario']] = $value['clave'];
    	}
    	
    	// usuario atiende
    	$element = new Zend_Form_Element_Select('id_usuario_soporte_titular');
    	$element
    	->setLabel("Ejecutivo:")
    	->removeDecorator('HtmlTag')
    	->setAttrib("class","form-control input-sm")
    	->setAttrib("autocomplete","off")
    	->addMultiOptions($options);
    	$this->addElement($element);
    	
    	
    	$element = new Zend_Form_Element_Submit('Filtrar');
    	$element
    	->removeDecorator('HtmlTag')
    	->setAttrib("class","btn btn-primary form-control input-sm");
    	$this->addElement($element);
    }
}