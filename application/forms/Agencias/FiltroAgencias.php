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
    	->setAttrib("onchange","this.form.submit()")   	
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
    		$options[$value['id_usuario']] =  $value['nombre'] .' '.$value['apellido_paterno']. ' ['.$value['clave'].']';
    	}
    	
    	// usuario atiende
    	$element = new Zend_Form_Element_Select('id_usuario_soporte_titular');
    	$element
    	->setLabel("Ejecutivo:")
    	->removeDecorator('HtmlTag')
    	->setAttrib("class","form-control input-sm selectpicker")
    	->setAttrib("data-live-search","true")
    	->setAttrib("autocomplete","off")
    	->addMultiOptions($options);
    	$this->addElement($element);
    	
    	
    	$element = new Zend_Form_Element_Submit('Filtrar');
    	$element
    	->removeDecorator('HtmlTag')
    	->setAttrib("class","btn btn-success form-control input-sm");
    	$this->addElement($element);
    	
    	$options=array();
    	$productos = new Application_Model_DbTable_Producto();
    	
    	$productosResult = $productos->fetchAll("vigente_prod='S'");
    	foreach ($productosResult as $value){
    		$options[$value['id_producto']] = $value['nombre_prod'];
    	}

    	$element = new Zend_Form_Element_MultiCheckbox('productos');
    	$element
    	->addMultiOptions( $options);
    	$this->addElement($element); 
    	
//     	$element = new Zend_Form_Element_Hidden('fecha_de');
//     	$element
//     	->removeDecorator('HtmlTag')
//     	->removeDecorator('label');
//     	$this->addElement($element);
    	
//     	$element = new Zend_Form_Element_Hidden('fecha_hasta');
//     	$element
//     	->removeDecorator('HtmlTag')
//     	->removeDecorator('label');
//     	$this->addElement($element);
    	
//     	// Fecha del Soporte en Sitio
//     	$element= new Zend_Form_Element_Text('daterange');
//     	$element
//     	->setLabel("Rango de Fechas:")
//     	->removeDecorator('HtmlTag')
//     	->removeDecorator('Errors')
//     	->setAttrib("autocomplete","off")
//     	->setAttrib("class","form-control input-sm");
//     	$this->addElement($element);
 
    	
    	$options = array(''=>'Todas las Ciudades');
   
    	$productosResult = $agencia->obtenerCiudadesDeAgencias();
    	foreach ($productosResult as $value){
    		$options[$value['clave_ciudad']] = $value['nombre_ciudad'].' ['.$value['numero_por_ciudad'].']';
    	}
    	
    	$element = new Zend_Form_Element_Select('clave_ciudad');
    	$element
    	->setLabel("Ciudad:")
    	->removeDecorator('HtmlTag')
    	->setAttrib("class","form-control input-sm selectpicker")
    	->setAttrib("data-live-search","true")
    	->setAttrib("autocomplete","off")
    	->addMultiOptions($options);
    	$this->addElement($element);

    	
    	$options = array(
    			'' => 'Todos',
    			'B' => 'B',
    			'E' => 'Edicom',
    			'I' => 'Factura Inteligente',
    			'N' => 'No Tiene',
    			'X' => 'EDX'
    	);
    	$element = new Zend_Form_Element_Select('prov_timbrado');
    	$element
    	->setLabel("Proveedor de Timbrado:")
    	->removeDecorator('HtmlTag')
    	->setAttrib("class","form-control input-sm selectpicker")
    	->setAttrib("autocomplete","off")
    	->addMultiOptions($options);
    	$this->addElement($element);
    	
    	
    	
    }
}