<?php
class IndexController extends Util_Controller_Action
{
    public function init()
    {
        if(!Zend_Auth::getInstance()->hasIdentity()){
        	$this->_redirect("autenticacao");
        }
    }

    public function indexAction()
    {
    	$this->_redirect("autenticacao");
    	
    }

}

