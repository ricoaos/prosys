<?php

class Model_Cliente {
	
	public $obj;
	
	public function __construct(){
		$this->obj = new Model_DbTable_Cliente();
	}
	
	public function getClientes()
	{
		return $this->obj->fetchAll()->toArray();
	} 

	public function find($id)
	{
		return $this->obj->find($id)->toArray();
	}
	
	public function update($obj,$id)
    {
		$where = $this->obj->getAdapter()->quoteInto('idcliente = ?', $id);
    	return $this->obj->update($obj,$where);
    }
    
	public function save($data)
	{ 			
		//Zend_Debug::dump($data);die;
		return $this->obj->insert($data);
	}
	
}