<?php

class Model_Editora {
	
	public $obj;
	
	public function __construct(){
		$this->obj = new Model_DbTable_Editora();
	}
	
	public function getEditora()
	{
		return $this->obj->fetchAll()->toArray();
	} 

	public function find($id)
	{
		return $this->obj->find($id)->toArray();
	}
	
	public function update($obj,$id)
    {
		$where = $this->obj->getAdapter()->quoteInto('idEditora = ?', $id);
    	return $this->obj->update($obj,$where);
    }
    
	public function save($data)
	{ 	
		return $this->obj->insert($data);
	} 
}