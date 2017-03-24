<?php 
class AuthController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}
	
	
	public function indexAction(){
		$this->_redirect('/auth/login');
	}
	
	public function loginAction()
	{
        $this->_helper->layout->setLayout('layout_login');		
		$loginForm = new Application_Form_Auth_Login();
		$params=$this->_request->getParams();
		
		
		if( $this->_request->isPost() ){
			
			if ($loginForm->isValid($_POST)) {
				$dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
				$adapter = new Zend_Auth_Adapter_DbTable(
						$dbAdapter,
						'usuario_admin',
						'clave',
						'pwd',
						'SHA(pwd)'
						);
	
				$adapter->setIdentity($params['clave']);
				$adapter->setCredential(sha1($params['pwd']));	
				
				$auth   = Zend_Auth::getInstance();
				$result = $auth->authenticate($adapter);

				if ($result->isValid()) {
					
					// Save logged user data in (default) namespace session Zend_Auth
					$auth = Zend_Auth::getInstance();
					$authStorage = $auth->getStorage();
					$authStorage->write($result);

					$userDetails= new Application_Model_DbTable_UsuarioAdmin();
				
					$_SESSION['Zend_Auth']['USER_VALUES'] = $userDetails->getUserValues(
							array(
									'clave'=>$params['clave'],
									'pwd'=>$params['pwd'])
							);
						
					if($_SESSION['Zend_Auth']['USER_VALUES']['activo']=='N'){
						unset($_SESSION);
						$this->view->error='El usuario est&aacute; inactivo.';
					} else {
							$this->_redirect('/');
						return;
					}
				} else {
					// datos incorrectos, podr�amos mostrar un mensaje de error
	
					switch ($result->getCode()) {
						case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
							$this->view->error='El usuario no est&aacute; registrado.';
							break;
						case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
							$this->view->error='Password Incorrecto.';
							break;
						default:
							$this->view->error='No ha ingresado credenciales.';
							break;
					}
				}
			} else {
				$loginForm->populate($_POST);
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
		$this->_redirect('auth');
	
		$this->_helper->Layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}
}