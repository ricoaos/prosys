<?php
class AutenticacaoController extends Zend_Controller_Action
{
	public function init()
    {
    	parent::init();
    	$this->Model = new Model_Tipousuario();
    }
 
    public function indexAction()
    {
    }
	
	public function loginAction()
	{		
		if ($this->getRequest()->isPost()) {
		
			$this->_helper->viewRenderer->setNoRender();
			$login = $this->_getParam('username');
			$senha = $this->_getParam('password');
			
            $authAdapter = new Zend_Auth_Adapter_DbTable(null, 'usuarios', 'username', 'senha', null);
            //Seta as credenciais com dados vindos do formulário de login
            $authAdapter->setIdentity($login)
            			->setCredential($senha);                     
            			//->setCredentialTreatment('MD5(?)');
   
            //Realiza autenticação e verifica se é valida
			if ($authAdapter->authenticate()->isValid()) {
				
				//Obtém dados do usuário menos a senha
				$usuario = $authAdapter->getResultRowObject(null, array('senha'));
				//Armazena seus dados na sessão
				$storage = Zend_Auth::getInstance()->getStorage();
				$storage->write($usuario);
				//Pega o nome do perfil
				$Perfis = new Model_Perfis();
				$dadosPerfil = $Perfis->find($usuario->perfis_idperfis);
				$session = new Zend_Session_Namespace('sistema');
				$session->nmperfil = $dadosPerfil[0]['nome'];
				$session->dados = $usuario;
				$this->_redirect('admin/index');
				
			}else{
            	$this->_redirect('autenticacao/falha');
            }
        }
	}
	
	public function falhaAction()
	{
		$this->_redirect('autenticacao');
		die ('Erro');
	}
	
	public function logoutAction()
	{
		//Limpa dados da Sessão
		Zend_Auth::getInstance()->clearIdentity();
		//Redireciona a requisição para a tela de Autenticacao novamente
		$this->_redirect('autenticacao');
	}
}