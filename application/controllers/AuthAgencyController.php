<?php 
class AuthAgencyController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */

	}
	
	
	public function indexAction(){
		if( count( $_SESSION['Zend_Auth'] ) > 0){
			$this->_redirect('/agencia-admin/');
		}
		$this->_redirect('/auth-agency/login');
	}
	
	public function loginAction()
	{
        $this->_helper->layout->setLayout('layout_login_agencia');		
		$loginForm = new Application_Form_Auth_Login();
		$params=$this->_request->getParams();

		if( $this->_request->isPost() ){
			
			if ($loginForm->isValid($params)) {

				$userDetails= new Application_Model_DbTable_AgenciaUsuario();
				$usuarioAgencia = $userDetails->obtenerUsuarioDeAgencia( $params['clave'] , $params['pwd']);
				
				if (count($usuarioAgencia) != 0) {
					
					// Save logged user data in (default) namespace session Zend_Auth
					$auth = Zend_Auth::getInstance();
					$authStorage = $auth->getStorage();
					$authStorage->write($usuarioAgencia[0]);

				
					//$_SESSION['Zend_Auth']['USER_VALUES'] = $userDetails->obtenerUsuarioDeAgencia( $params['clave'] , $params['pwd']);
					$_SESSION['Zend_Auth']['storage']['agencia_usuario']=true;

					if($usuarioAgencia[0]['activo']=='N'){
						unset($_SESSION);
						$this->view->error='El usuario est&aacute; inactivo.';
					} else {

							$this->_redirect('/agencia-admin/');
						return;
					}
				} else {
					// datos incorrectos, podr�amos mostrar un mensaje de error
	
					switch (0) {
						default:
							$this->view->error='No ha ingresado credenciales correctas.';
							break;
					}
				}
			} else {

				$loginForm->populate($params);
			}
		}
		
		$this->view->form = $loginForm;

	}

	/**
	 * @method finalize the session of user
	 * @author Juan Garfias Vázquez
	 */
	public function logoutAction() {
		$storage = new Zend_Auth_Storage_Session();
		$storage->clear();
	
		Zend_Session::namespaceUnset('session') ;
		Zend_Session::namespaceUnset('Zend_Auth');
	
		session_destroy();
		$this->_redirect('auth-agency');
	
		$this->_helper->Layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}
}