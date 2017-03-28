<?php	
// located at application/forms/Auth/Login.php
 
class Application_Form_Ordenes_FiltroSeguimientoOrdenAdmin extends Zend_Form
{
	public function init(){
		$options = array();
		$usuario_admin = new Application_Model_DbTable_UsuarioAdmin();
		
		$user = $usuario_admin->getSoporteUsers();
		$options = array(''=>'Todos');
		foreach ($user as $value){
			$options[$value['id_usuario']] = $value['clave'];
		}

		// usuario atiende
		$element = new Zend_Form_Element_Select('id_usuario_admin_atiende');
		$element
			->setLabel("Ejecutivo:")
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off")
			->addMultiOptions($options);
		$this->addElement($element);
		
		// motivo
		$element = new Zend_Form_Element_Select('id_motivo');
		$element
			->setLabel("Motivo:")
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off")
			->addMultiOptions($this->getOrdenMotivo());
		$this->addElement($element);
		
		// estatus orden
		$element = new Zend_Form_Element_Select('id_orden_servicio_estatus');
		$element
		->setLabel("Estatus de la orden:")
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->addMultiOptions($this->getOrdenEstatus());
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Submit('filtrar');
		$element
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control");
		$this->addElement($element);
		
	}
			
	public function getOrdenMotivo(){
		$os = new Application_Model_DbTable_OrdenServicio();
		$result = $os->obtenerMotivos();
		
		$options = array(''=>'Todos');
		
		foreach ($result as $key => $value){
			$options[$value['id_motivo']] = $value['motivo'];
		}
		return $options;
	}
	
	public function getOrdenEstatus(){
		$os = new Application_Model_DbTable_OrdenServicio();
		$result = $os->obtenerOrdenesEstatus();
	
		$options = array(''=>'Todos');
	
		foreach ($result as $key => $value){
			$options[$value['id_orden_servicio_estatus']] = $value['descripcion'];
		}
		return $options;
	}
}