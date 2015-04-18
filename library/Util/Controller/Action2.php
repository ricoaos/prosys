<?php

class Util_Controller_Action2 extends Zend_Controller_Action
{
	public $userInfo;
	
	public function init()
	{			
		$this->_helper->layout()->setLayout('admin/layoutadmin');	
		
		if(!Zend_Auth::getInstance()->hasIdentity()){
			$this->_redirect("autenticacao");
		}	
	}
}