<?php
// located at application/forms/Auth/Login.php
 
class Application_Form_Ordenes_NuevaOrden extends Zend_Form
{
	public function init()
	{

		$id_orden_servicio = new Zend_Form_Element_Hidden('id_orden_servicio');
		$this->addElement($id_orden_servicio);
    	$id_agencia = new Zend_Form_Element_Hidden('id_agencia');
    	$this->addElement($id_agencia);
		
		// empresa
		$empresa = new Zend_Form_Element_Text('empresa');
		$empresa->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca una empresa.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Empresa"))
		->setAttrib("maxlength","15")
		;
		
		// póliza
		$id_poliza = new Zend_Form_Element_Text('poliza');
		$id_poliza->setRequired(true)
		->addErrorMessage("- Es necesario que elija una póliza.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Empresa"))
		->setAttrib("maxlength","15")
		;
		
		
		// producto
		$producto = new Zend_Form_Element_Select('id_producto');
		$producto->setRequired(true)
			->removeDecorator('label')
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off");
		$this->addElement($producto);

		// solicito
		$solicito = new Zend_Form_Element_Select('id_usuario_agencia_solicito');
		$solicito->setRequired(true)
			->addErrorMessage("- Es necesario indicar quién solicitó el servicio.")
			->removeDecorator('label')
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off");
		$this->addElement($solicito);
		
		// ejecutivo
		$ejecutivo = new Zend_Form_Element_Text('ejecutivo');
		$ejecutivo->setRequired(true)
		->addErrorMessage("- Es necesario que introduzca el ejecutivo que atenderá el servicio.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder",utf8_encode("Ejecutivo"))
		->setAttrib("maxlength","45")
		;


		$os = new Application_Model_DbTable_OrdenServicio();
		$result = $os->obtenerMotivos();
		
		$options = array();
		
		foreach ($result as $key => $value){
			$options[$value['id_motivo']] = $value['motivo'];
		}
		
		// numero de licencias
		$motivo = new Zend_Form_Element_Select('id_motivo');
		$motivo
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->addMultiOptions($options);
		
		$this->addElement($motivo);
		
		// Ejectivo de soporte.
		$id_usuario_admin_atiende = new Zend_Form_Element_Select('id_usuario_admin_atiende');
		$id_usuario_admin_atiende
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off");

		$this->addElement($id_usuario_admin_atiende);
		
		$result = $os->obtenerTipoDeSoporte();
		
		$options = array();
		
		foreach ($result as $key => $value){
			$options[$value['id_tipo_soporte']] = $value['description'];
		}
		
		// Tipo de soporte
		$id_tipo_soporte = new Zend_Form_Element_Select('id_tipo_soporte');
		$id_tipo_soporte
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->addMultiOptions($options);
		
		$this->addElement($id_tipo_soporte);
		
		
		
		
		
		// Fecha del Soporte en Sitio
		$fecha_soporte_sitio = new Zend_Form_Element_Text('fecha_soporte_sitio');
		$fecha_soporte_sitio
		->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ->setAttrib("autocomplete","off")
        ->setAttrib("class","form-control datepicker")
        ->setAttrib("placeholder",utf8_encode("yyyy-mm-dd"))
        ->setAttrib("maxlength","10")
        ->setAttrib("data-provide","datepicker")
        ->setAttrib("readonly","readonly")
        ->setAttrib("data-date-format","yyyy-mm-dd");

		$this->addElement($fecha_soporte_sitio);
		
		$options = array(
			"07:00" =>"07:00",
			"07:30" =>"07:30",
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
			"20:00" =>"20:00",
			"20:30" =>"20:30",
			"21:00" =>"21:00"
		);
		
		// Tipo de soporte
		$hora_soporte_sitio = new Zend_Form_Element_Select('hora_soporte_sitio');
		$hora_soporte_sitio
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->addMultiOptions($options);
		$this->addElement($hora_soporte_sitio);

		// descripcion
		$comentarios_recepcion = new Zend_Form_Element_Textarea('comentarios_recepcion');
		$comentarios_recepcion
			->removeDecorator('label')
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off")
			->setAttrib("rows","5")
			->setAttrib("placeholder",("Descripción"));


		// $username->setRequired(true);
		
		// Submit
		$submit = new Zend_Form_Element_Submit('submit');
		$submit	->setLabel("Guardar Nueva Orden")
		->setAttrib("class","btn btn-lg btn-success btn-block")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		;

		// duracion
		$duracion = new Zend_Form_Element_Text('duracion');
		$duracion->setRequired(true)
		->addErrorMessage("- Es necesario indicar la duración del servicio.")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		//->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder","Duración del Servicio")
		->setAttrib("maxlength","45")
        ->setAttrib("data-mask","__:__:__")
        ->setValue("__:__:__")
		;


		$idcliente = new Zend_Form_Element_Hidden('idclientes');

		$this
		->setMethod('post')
		->setAction('public/ordenes/nueva-orden')
		->addElements(array($empresa, $id_poliza, $producto, $solicito, $ejecutivo, $motivo, $comentarios_recepcion, $submit, $idcliente,$duracion));
		
		$solicito_otro = new Zend_Form_Element_Text('solicito_otro');
		
		$solicito_otro->setRequired(false)
			->removeDecorator('label')
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off")
			->setAttrib("placeholder",utf8_encode("Otro"))
			->setAttrib("maxlength","245");
		
		$this->addElement($solicito_otro);
	
	}
			
}