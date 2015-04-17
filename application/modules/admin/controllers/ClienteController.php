<?php

class Admin_ClienteController extends Util_Controller_Action2
{	
    public function init()
    {
    	parent::init();
    	$this->Model = new Model_Cliente();
    	$this->iduser = Zend_Auth::getInstance()->getStorage()->read();
    }

    public function indexAction()
    {    	
    	if($this->_request->isPost())
    	{
    		$post = $this->_request->getPost();
    		$insert = $this->Model->save($post);
    		$msg = $insert != 0 ? "Registro cadastrado com sucesso!" : "Erro ao cadastrar registro";
    		$this->view->resposta = $msg;
    	}
    }
    
    public function allclientesAction()
    {
    	$getClientes = $this->Model->getClientes();
    	
    	$pagina = intval($this->_getParam('pagina', 1));
    	$paginator = Zend_Paginator::factory($getClientes);
    	$paginator->setItemCountPerPage(10);
    	$paginator->setPageRange(7);
    	$paginator->setCurrentPageNumber($pagina);
    	 
    	$this->view->paginator = $paginator;
    	//$this->view->autor = $getClientes;
    	$this->view->usuario = $this->iduser->nome;
    	
    }
}

