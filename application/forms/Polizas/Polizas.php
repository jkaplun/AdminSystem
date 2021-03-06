<?php
// located at application/forms/Polizas/Polizas.php
 
class Application_Form_Polizas_Polizas extends Zend_Form
{
    public function init()
    {
    	
    	// id_poliza
    	// $id_poliza = new Zend_Form_Element_Hidden('id_poliza');
    	// $this->addElement(id_poliza);
    	
    	$horasCien = array();
    	
    	for ( $i=0 ; $i <= 100 ; $i++ ) {
    		$horasCien[$i] = $i;
    	}
    	
        // Horas soporte
        $horas_poliza = new Zend_Form_Element_Select('horas_poliza');
        $horas_poliza
        ->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca las horas de soporte.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setValue(12)
        ->addMultiOptions($horasCien);
        
        
        
        $this->addElement($horas_poliza);

        
        $producto = new Application_Model_DbTable_Producto();
        $resultados = $producto->obtenerProductos();
        $lista = array();
        foreach ( $resultados as $resultado){
        	$lista[$resultado['id_producto']]=$resultado['nombre_prod'];
        }
        
        // Producto
        $producto = new Zend_Form_Element_Select('producto');
        $producto->setAttribs ( array (
                'autocomplete'=>'off'))
                //->addMultiOptions($lista)
                ->setAttrib("class","form-control")                
                ->removeDecorator('label')
                //->setValue('producto1')
                ->removeDecorator('HtmlTag');
        
        $this->addElement($producto);
                
        // Clave
        $clave = new Zend_Form_Element_Text('clave');
        $clave->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca la clave.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Nombre"))
        ->setAttrib("maxlength","15")
        ;
        $this->addElement($clave);
        
        // Fecha inicial
        $fecha_ini = new Zend_Form_Element_Text('fecha_ini');
        $fecha_ini->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ->setAttrib("autocomplete","off")
        ->setAttrib("class","form-control datepicker")
        ->setAttrib("placeholder",utf8_encode("yyyy-mm-dd"))
        ->setAttrib("maxlength","10")
        ->setAttrib("data-provide","datepicker")
        ->setAttrib("readonly","readonly")
        ->setAttrib("data-date-format","yyyy-mm-dd");
        $this->addElement($fecha_ini);
        
        // Fecha final
        $fecha_fin = new Zend_Form_Element_Text('fecha_fin');
        $fecha_fin->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ->setAttrib("autocomplete","off")
        ->setAttrib("class","form-control datepicker")
        ->setAttrib("placeholder",utf8_encode("yyyy-mm-dd"))
        ->setAttrib("maxlength","10")
        ->setAttrib("data-provide","datepicker")
        ->setAttrib("readonly","readonly")
        ->setAttrib("data-date-format","yyyy-mm-dd");
        $this->addElement($fecha_fin);
        
        // Fecha corte servi
        $fecha_fin_servicio = new Zend_Form_Element_Text('fecha_fin_servicio');
        $fecha_fin_servicio->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ->setAttrib("autocomplete","off")
        ->setAttrib("class","form-control datepicker")
        ->setAttrib("placeholder",utf8_encode("yyyy-mm-dd"))
        ->setAttrib("maxlength","10")
        ->setAttrib("data-provide","datepicker")
        ->setAttrib("readonly","readonly")
        ->setAttrib("data-date-format","yyyy-mm-dd");
        $this->addElement($fecha_fin_servicio);
        
        // Cantidad facturar
        $costo_poliza = new Zend_Form_Element_Text('costo_poliza');
        $costo_poliza->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder","$$$")
        ->setAttrib("maxlength","11")
        ;
        $this->addElement($costo_poliza);
         
        // Tiempo agotado
        $tiempo_agotado = new Zend_Form_Element_Select('tiempo_agotado');
        $tiempo_agotado
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($tiempo_agotado);
         
        //Garant�a
        // $garantia = new Zend_Form_Element_Select('garantia');
        // $garantia
        // ->removeDecorator('label')
        // ->removeDecorator('HtmlTag')
        // ->addMultiOptions(array(
        //         'S'=>'Activo',
        //         'N'=>'Inactivo'
        // ))
        // ->setAttrib("class","form-control")
        // ->setAttrib("autocomplete","off")
        // ;
        // $this->addElement($garantia);

        $tipoPoliza = new Application_Model_DbTable_TipoPoliza();
        $resultados = $tipoPoliza->obtenerTiposPoliza();
        $lista = array();
        foreach ( $resultados as $resultado){
        	$lista[$resultado['tipo']]=$resultado['descripcion'];
        }
        
        //Tipo
        $tipo = new Zend_Form_Element_Select('tipo');
        $tipo
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions($lista)
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($tipo);
        
        // //Descripci�n de  servicios
        // $observaciones = new Zend_Form_Element_TextArea('observaciones');
        // $observaciones->removeDecorator('label')
        // ->removeDecorator('HtmlTag')
        // ->setAttrib("class","form-control")
        // ->setAttrib("autocomplete","off")
        // ->setAttrib("placeholder",utf8_encode("Observaciones"))
        // ;
        // $this->addElement($observaciones);
        
        // // Estatus
        // $estatus = new Zend_Form_Element_Select('estatus');
        // $estatus
        // ->removeDecorator('label')
        // ->removeDecorator('HtmlTag')
        // ->addMultiOptions(array(
        //         'ACT'=>'Activo',
        //         'ADE'=>'Adeudo',
        // 		'BLQ'=>'Bloqueado',
        // 		'CAN'=>'Cancelado',
        // ))
        // ->setAttrib("class","form-control")
        // ->setAttrib("autocomplete","off")
        // ;
        // $this->addElement($estatus);
        
        // Submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit ->setLabel("Iniciar")
        ->setAttrib("class","btn btn-lg btn-success btn-block")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ;
        $id_agencia = new Zend_Form_Element_Hidden('id_agencia');


        // Estatus
        $id_poliza_estatus = new Zend_Form_Element_Select('id_poliza_estatus');
        $id_poliza_estatus->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                '1'=>'Activo',
                '2'=>'Adeudo',
                '3'=>'Bloqueado',
                '4'=>'Cancelado',
               // '5'=>'Caducada',
                '6'=>'Agotada',
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($id_poliza_estatus);

        // Observaciones
        $observaciones_poliza = new Zend_Form_Element_Textarea('observaciones_poliza');
        $observaciones_poliza
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder","Observaciones de la Póliza")
        ->setAttrib("maxlength","256")
        ->setAttrib("rows","5")
        ;
        $this->addElement($observaciones_poliza);

        }
}