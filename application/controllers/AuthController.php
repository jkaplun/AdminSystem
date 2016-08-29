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
		
		
		$loginForm = new Application_Form_Auth_Login();

		if ($loginForm->isValid($_POST)) {
			$dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
			$adapter = new Zend_Auth_Adapter_DbTable(
					$dbAdapter,
					'users',
					'username',
					'password',
					'SHA(password)'
					);

			$adapter->setIdentity($loginForm->getValue('username'));
			$adapter->setCredential(sha1($loginForm->getValue('password')));

			$auth   = Zend_Auth::getInstance();
			$result = $auth->authenticate($adapter);
			//echo '<pre>'.print_r($result,true).'</pre>';die;

			if ($result->isValid()) {
				
				// Save logged user data in (default) namespace session Zend_Auth
				$auth = Zend_Auth::getInstance();
				$authStorage = $auth->getStorage();
				$authStorage->write($result);
				$username = $loginForm->getValue('username');
				$password = $loginForm->getValue('password');
				$userDetails= new Application_Model_DbTable_Users();
			
				$userDetailsResult=$userDetails->getUserValues(array('usuario'=>$username,'password'=>$password));
				$_SESSION['Zend_Auth']['USER_VALUES'] = $userDetailsResult;
				//echo '<pre>'.print_r($_SESSION['Zend_Auth']['USER_VALUES']['id_rol'],true).'</pre>';die;
				
				if($_SESSION['Zend_Auth']['USER_VALUES']['activo']==0){
					unset($_SESSION);
					$this->view->error='El usuario esta inactivo.';
				} else {
					switch ($_SESSION['Zend_Auth']['USER_VALUES']['id_rol']){
						case 1:
							$this->_redirect('/admin');
							break;
						case 2:
							$this->_redirect('/chart');
							break;
						case 3:
							$this->_redirect('/');
							break;
					}
					return;
				}
			} else {
						// datos incorrectos, podríamos mostrar un mensaje de error
					
						switch ($result->getCode()) {
							case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
								$this->view->error='El usuario no esta registrado.';
								break;
							case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
								$this->view->error='Password Incorrecto.';
								break;
							default:
								$this->view->error='No ha ingresado credenciales.';
								break;
						}
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