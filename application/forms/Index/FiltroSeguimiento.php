<?php

/**
 * 
 * @author Ing. Juan Garfias
 *
 */
class Application_Form_Index_FiltroSeguimiento extends Zend_Form
{
	public function init()
	{
		$id_registro_personas = new Zend_Form_Element_Text('id_registro_personas');
		$id_registro_personas
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("maxlength","200");
		
		$apellido_paterno = new Zend_Form_Element_Text('apellido_paterno');
		$apellido_paterno
			->removeDecorator('label')
			->removeDecorator('HtmlTag')
			->removeDecorator('Errors')
			->setAttrib("class","form-control")
			->setAttrib("maxlength","200");
		
		$apellido_materno = new Zend_Form_Element_Text('apellido_materno');
		$apellido_materno
			->removeDecorator('label')
			->removeDecorator('HtmlTag')
			->removeDecorator('Errors')
			->setAttrib("class","form-control")
			->setAttrib("maxlength","200");
		
		$nombre = new Zend_Form_Element_Text('nombre');
		$nombre
			->removeDecorator('label')
			->removeDecorator('HtmlTag')
			->removeDecorator('Errors')
			->setAttrib("class","form-control")
			->setAttrib("maxlength","200");
		
		$catalogoMunLoc = new Application_Model_DbTable_CatalogoMunLoc();
		$estados = $catalogoMunLoc->getEntidades();
		
		foreach ($estados as $key => $value ){
			
				if ( $value['clave_entidad'] != 0 ){
					$options[$value['clave_entidad']]=$value['nombre_entidad'];
				} else {
					$options[0]='Seleccione...';
				}
		}
		
		$estado = new Zend_Form_Element_Select( 'estado');
		$estado->setAttribs ( array (
				'class' => 'form-control',
				'autocomplete'=>'off'))
				->addMultiOptions($options)
				->removeDecorator('label')
				->removeDecorator('HtmlTag');
				
		$seguimiento = new Zend_Form_Element_Select('seguimiento');
		$seguimiento->addMultiOptions(array(
					'0' => utf8_encode('Todos'),
					'1' => utf8_encode('Aplica'),
					'2' => utf8_encode('Expediente en Proceso'),
					'3' => utf8_encode('No Aplica')
					))
					->removeDecorator('label')
					->setAttribs ( array (
						'class' => 'form-control',
						'autocomplete'=>'off'))
					->removeDecorator('label')
					->removeDecorator('HtmlTag');				
				
		// Submit
		$filtrar = new Zend_Form_Element_Submit('filtrar');
		$filtrar	->setLabel("Filtrar")
		->setAttrib("class","btn btn-default")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors');
		
		$fecharegistro = new Zend_Form_Element_Text('fecharegistro');
		$fecharegistro
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		->setAttrib("autocomplete","off")
		->setAttrib("class","form-control datepicker")
		->setAttrib("placeholder",utf8_encode("yyyy-mm-dd"))
		->setAttrib("maxlength","10");
		
		$catalogoEstadosUSA = new Application_Model_DbTable_CatalogoEstadosUSA();
		$estadosUSA = $catalogoEstadosUSA->getEstadosUSA();
		foreach ($estadosUSA as $key => $value ){
			
			
			if ( $value['idcatalogo_estados_eua'] != 52 ){
				$optionsUSA[$value['idcatalogo_estados_eua']]=$value['estado'];
			} else {
				$optionsUSA[0]='Seleccione...';
			}
			
		}
		
		$estado_eu = new Zend_Form_Element_Select( 'estado_eu');
		$estado_eu->setAttribs ( array (
				'class' => 'form-control',
				'autocomplete'=>'off'))
				->addMultiOptions($optionsUSA)
				->removeDecorator('label')
				->removeDecorator('HtmlTag');
		
		$this
		->setMethod('post')
		->addElements(array(
				$fecharegistro,
				$filtrar,
				$seguimiento,
				$nombre,
				$apellido_materno,
				$apellido_paterno,
				$estado,
				$estado_eu,
				$id_registro_personas
		));
		}
}