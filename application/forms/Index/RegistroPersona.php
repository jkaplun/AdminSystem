<?php

/**
 * 
 * @author Ing. Juan Garfias
 *
 */
class Application_Form_Index_RegistroPersona extends Zend_Form
{
	public function init()
	{
		$nombre_persona_contacto = new Zend_Form_Element_Text('nombre_persona_contacto');
		$nombre_persona_contacto
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("maxlength","200");
		
		$parentesco_persona_contacto = new Zend_Form_Element_Text('parentesco_persona_contacto');
		$parentesco_persona_contacto
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
		
		$fechanacimiento = new Zend_Form_Element_Text('fechanacimiento');
		$fechanacimiento
			->removeDecorator('label')
			->removeDecorator('HtmlTag')
			->removeDecorator('Errors')
			->setAttrib("autocomplete","off")
			->setAttrib("class","form-control datepicker")
			->setAttrib("placeholder",utf8_encode("dd-mm-yyyy"))
			->setAttrib("maxlength","10");

		$email = new Zend_Form_Element_Text('email');
		$email
			->removeDecorator('label')
			->removeDecorator('HtmlTag')
			->removeDecorator('Errors')
			->setAttrib("class","form-control")
			->setAttrib("maxlength","200");
		
		$catalogoMunLoc = new Application_Model_DbTable_CatalogoMunLoc();
		$estados = $catalogoMunLoc->getEntidades();
		
		foreach ($estados as $key => $value ){
				$options[$value['clave_entidad']]=$value['nombre_entidad'];
		}
		
		$estado = new Zend_Form_Element_Select( 'estado');
		$estado->setAttribs ( array (
				'class' => 'form-control',
				'onchange'=>"traerMunDel(this.value)",
				'autocomplete'=>'off'))
				->addMultiOptions($options)
				->removeDecorator('label')
				->removeDecorator('HtmlTag');

		$mun_del = new Zend_Form_Element_Select( 'mun_del');
		$mun_del->setAttribs ( array (
				'class' => 'form-control',
				'autocomplete'=>'off'))
				->addMultiOptions(array('0'=>'No sabe'))
				->removeDecorator('label')
				->removeDecorator('HtmlTag');

		$genero = new Zend_Form_Element_Radio('genero');		
		$genero->setAttribs ( array (
				'autocomplete'=>'off')) 
				->addMultiOptions(array(
			        'm' => 'Masculino',
			        'f' => 'Femenino'))
      			->setSeparator('&ensp;&ensp;&ensp;')
				->removeDecorator('label')
				->removeDecorator('HtmlTag')
				->setValue('m');
				
		$escolaridad = new Zend_Form_Element_Radio('escolaridad');
		$escolaridad->setAttribs ( array (
				'autocomplete'=>'off'))
				->addMultiOptions(array(
				'nes' => 'Sin Estudios',
				'pri' => 'Primaria',
				'sec' => 'Secundaria',
				'pre' => 'Preparatoria',
				'uni' => 'Universidad'
				))
				->setSeparator('&ensp;&ensp;&ensp;')
				->removeDecorator('label')
				->removeDecorator('HtmlTag')
				->setValue('nes');
				
		$ocupacion = new Zend_Form_Element_Text('ocupacion');
		$ocupacion
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("maxlength","200");
		
		$catalogoEstadosUSA = new Application_Model_DbTable_CatalogoEstadosUSA();
		$estadosUSA = $catalogoEstadosUSA->getEstadosUSA();
		foreach ($estadosUSA as $key => $value ){
			$optionsUSA[$value['idcatalogo_estados_eua']]=$value['estado'];
		}
		
		$estado_eu = new Zend_Form_Element_Select( 'estado_eu');
		$estado_eu->setAttribs ( array (
				'class' => 'form-control',
				'autocomplete'=>'off'))
				->addMultiOptions($optionsUSA)
				->removeDecorator('label')
				->removeDecorator('HtmlTag');
		
		$radica = new Zend_Form_Element_Text('radica');
		$radica
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("maxlength","200");
		
		 for($i=0;$i<=99;$i++){
			$optionsAnios[$i]=$i;
		}
		
		$tiempo_radicar_anio = new Zend_Form_Element_Select( 'tiempo_radicar_anio');
		$tiempo_radicar_anio->setAttribs ( array (
				'class' => 'form-control',
				'autocomplete'=>'off'))
				->addMultiOptions($optionsAnios)
				->removeDecorator('label')
				->removeDecorator('HtmlTag');
		for($i=0;$i<=11;$i++){
			$optionsMeses[$i]=$i;
		}
		$tiempo_radicar_meses = new Zend_Form_Element_Select( 'tiempo_radicar_meses');
		$tiempo_radicar_meses->setAttribs ( array (
				'class' => 'form-control',
				'autocomplete'=>'off'))
				->addMultiOptions($optionsMeses)
				->removeDecorator('label')
				->removeDecorator('HtmlTag');		
			
		$tel_contacto_casa = new Zend_Form_Element_Text('tel_contacto_casa');
		$tel_contacto_casa
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("maxlength","45");
		
		$tel_contacto_celular = new Zend_Form_Element_Text('tel_contacto_celular');
		$tel_contacto_celular
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("maxlength","45");
		
		$tel_contacto_trabajo = new Zend_Form_Element_Text('tel_contacto_trabajo');
		$tel_contacto_trabajo
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("maxlength","45");
				
		
		$cuenta_registro = new Zend_Form_Element_Radio('cuenta_registro');
		$cuenta_registro->setAttribs ( array (
				'autocomplete'=>'off'))
				->addMultiOptions(array(
						'si' => 'Si',
						'no' => 'No',
						'ns' => utf8_encode('No	está seguro')
				))
				->setSeparator('&ensp;&ensp;&ensp;')
				->removeDecorator('label')
				->removeDecorator('HtmlTag')
				->setValue('si');
				
		$sabe_donde_nacio = new Zend_Form_Element_Radio('sabe_donde_nacio');
		$sabe_donde_nacio->setAttribs ( array (
				'autocomplete'=>'off',
				'onchange'=>"otroDondeNacio(this.value)",
		))
				->addMultiOptions(array(
						'ni' => utf8_encode('Nació en una Institución de Salud'),
						'ne' => utf8_encode('Nació en Casa'),
						'ot' => utf8_encode('Otro')
				))
				
				->setSeparator('&ensp;&ensp;&ensp;')
				->removeDecorator('label')
				->removeDecorator('HtmlTag')
				->setValue('ni');
				
		$donde_nacio_otro = new Zend_Form_Element_Text('donde_nacio_otro');
		$donde_nacio_otro
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("maxlength","245");
		
		$desc_problema = new Zend_Form_Element_Textarea('desc_problema');
		$desc_problema
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors')
		->setAttrib("class","form-control")
		->setAttrib("maxlength","50000")
		->setAttrib("rows","3");
		
		$cuenta_documentos = new Zend_Form_Element_MultiCheckbox('cuenta_documentos');
		$cuenta_documentos->setAttribs ( array (
				'autocomplete'=>'off'))
				->addMultiOptions(array(
						'cn' => utf8_encode('Certificado de nacimiento'),
						'ci' => utf8_encode('Constancias de inexistencia de registro'),
						'in' => utf8_encode('Identificaciones con nombre correcto'),
						'cl' => utf8_encode('Copias del libro'),
						'nd' => utf8_encode('Ningún documento'),
						'ot' => utf8_encode('Otro')
				))
				->setSeparator('<br>')
				->removeDecorator('label')
				->removeDecorator('HtmlTag');
		

		$cuenta_documentos_otro = new Zend_Form_Element_Text('cuenta_documentos_otro');
		$cuenta_documentos_otro
				->removeDecorator('label')
				->removeDecorator('HtmlTag')
				->removeDecorator('Errors')
				->setAttrib("class","form-control")
				->setAttrib("maxlength","244");
		
		$si_cuenta_con_personas_aux = new Zend_Form_Element_Checkbox('si_cuenta_con_personas_aux');
		$si_cuenta_con_personas_aux->setAttribs ( array (
				'autocomplete'=>'off'))
				->removeDecorator('label')
				->setValue('si')
				->removeDecorator('HtmlTag');
				
		$desc_cuenta_con_persona = new Zend_Form_Element_Textarea('desc_cuenta_con_persona');
		$desc_cuenta_con_persona
				->removeDecorator('label')
				->removeDecorator('HtmlTag')
				->removeDecorator('Errors')
				->setAttrib("class","form-control")
				->setAttrib("maxlength","50000")
				->setAttrib("rows","3");
		
				
		$seguimiento = new Zend_Form_Element_Radio('seguimiento');
		$seguimiento->setAttribs ( array (
				'autocomplete'=>'off'
		))
		->addMultiOptions(array(
				'1' => utf8_encode('Aplica'),
				'2' => utf8_encode('Expediente en Proceso'),
				'3' => utf8_encode('No Aplica')
		))
		->setSeparator('&ensp;&ensp;&ensp;')
		->removeDecorator('label')
		->removeDecorator('HtmlTag')->setValue(1);				
				
		// Submit
		$guardar = new Zend_Form_Element_Submit('guardar');
		$guardar	->setLabel("Guardar Registro")
		->setAttrib("class","btn btn-default")
		->removeDecorator('label')
		->removeDecorator('HtmlTag')
		->removeDecorator('Errors');
		
		$this
		->setMethod('post')
		->addElements(array(
				$apellido_paterno,
				$apellido_materno,
				$nombre,
				$fechanacimiento,
				$email,
				$estado,
				$mun_del,
				$genero,
				$escolaridad,
				$ocupacion,
				$estado_eu,
				$radica,
				$tiempo_radicar_anio,
				$tiempo_radicar_meses,
				$tel_contacto_casa,
				$tel_contacto_celular,
				$tel_contacto_trabajo,
				$cuenta_registro,
				$sabe_donde_nacio,
				$donde_nacio_otro,
				$desc_problema,
				$cuenta_documentos,
				$cuenta_documentos_otro,
				$si_cuenta_con_personas_aux,
				$desc_cuenta_con_persona,
				$seguimiento,
				$guardar,
				$nombre_persona_contacto,
				$parentesco_persona_contacto
		));
		}
}