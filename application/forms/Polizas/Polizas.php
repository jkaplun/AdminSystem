<?php
// located at application/forms/Polizas/Polizas.php
 
class Application_Form_Polizas_Polizas extends Zend_Form
{
    public function init()
    {
    	
    	// id_poliza
    	$id_poliza = new Zend_Form_Element_Hidden('id_poliza');
    	$this->addElement(id_poliza);
    	
        // Horas soporte
        $horasopor_year = new Zend_Form_Element_Text('horasopor_year');
        $horasopor_year
        ->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca las horas de soporte.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Horas soporte"))
        ->setAttrib("maxlength","11")
        ;
        $this->addElement($horasopor_year);
        
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
        ->setAttrib("maxlength","10");
        $this->addElement($fecha_ini);
        
        // Fecha final
        $fecha_fin = new Zend_Form_Element_Text('fecha_fin');
        $fecha_fin->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ->setAttrib("autocomplete","off")
        ->setAttrib("class","form-control datepicker")
        ->setAttrib("placeholder",utf8_encode("yyyy-mm-dd"))
        ->setAttrib("maxlength","10");
        $this->addElement($fecha_fin);
        
        // Cantidad facturar
        $cantidad_fact = new Zend_Form_Element_Text('cantidad_fact');
        $cantidad_fact->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Cantidad"))
        ->setAttrib("maxlength","11")
        ;
        $this->addElement($cantidad_fact);
         
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
        $garantia = new Zend_Form_Element_Select('garantia');
        $garantia
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($garantia);
         
        //Tipo
        $tipo = new Zend_Form_Element_Select('tipo');
        $tipo
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($tipo);
        
        //Descripci�n de  servicios
        $desc_servicios = new Zend_Form_Element_Text('desc_servicios');
        $desc_servicios->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Descripci�n de servicios"))
        ->setAttrib("maxlength","250")
        ;
        $this->addElement($desc_servicios);
        
        // Actualizaci�n
        $actualizacion = new Zend_Form_Element_Text('actualizacion');
        $actualizacion->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Actualizaci�n"))
        ->setAttrib("maxlength","2")
        ;
        $this->addElement($actualizacion);
        
        // Telef�nico
        $telefonico = new Zend_Form_Element_Text('telefonico');
        $telefonico->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Telef�nico"))
        ->setAttrib("maxlength","2")
        ;
        $this->addElement($telefonico);
        
        // Remoto
        $remoto = new Zend_Form_Element_Text('remoto');
        $remoto->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Remoto"))
        ->setAttrib("maxlength","2")
        ;
        $this->addElement($remoto);
        
        // AdmConvenios
        $admconvenios = new Zend_Form_Element_Text('admconvenios');
        $admconvenios->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Convenios adm"))
        ->setAttrib("maxlength","2")
        ;
        $this->addElement($admconvenios);
        
        // Sitio
        $sitio = new Zend_Form_Element_Text('sitio');
        $sitio->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Sitio"))
        ->setAttrib("maxlength","2")
        ;
        $this->addElement($sitio);
        
        // Estatus
        $estatus = new Zend_Form_Element_Select('estatus');
        $estatus
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($estatus);
        
        // Pagxeven
        $pagxeven = new Zend_Form_Element_Text('pagxeven');
        $pagxeven->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Pagxeven"))
        ->setAttrib("maxlength","2")
        ;
        $this->addElement($pagxeven);
        
        // Submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit ->setLabel("Iniciar")
        ->setAttrib("class","btn btn-lg btn-success btn-block")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ;
        $id_agencia = new Zend_Form_Element_Hidden('id_agencia');
        

        }
}