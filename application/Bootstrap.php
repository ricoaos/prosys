<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');       
    }
    
    protected  function _initPaginacao()
    {
		Zend_Paginator::setDefaultScrollingStyle('Sliding');    	
    	Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
    }
    
    /**
     * Locale PHP (Solucao Caracteres Especiais)
     */
    
    protected function _initLocale()
    {
    	setlocale(LC_ALL, 'pt_BR.utf-8');
    }
    
   	protected function _initDb()
   	{
      $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini');
      $dbAdapters = array();
 
      foreach($config->{APPLICATION_ENV}->resources->db as $config_name => $db){
         $dbAdapters[$config_name] = Zend_Db::factory($db->adapter,$db->params->toArray());
         if((boolean)$db->isDefaultTableAdapter){
            Zend_Db_Table::setDefaultAdapter($dbAdapters[$config_name]);
         }
      }
   }
}

