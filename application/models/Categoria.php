<?php

class Model_Categoria {
	
	public $obj;
	
	public function __construct(){
		$this->obj = new Model_DbTable_Categoria();
	}
	public function getCategoria()
	{
		return $this->obj->fetchAll()->toArray();
	}
	
	public function find($id)
	{
		return $this->obj->find($id)->toArray();
	}
	
	public function save($obj)
	{
		return $this->obj->insert($obj);
	}
	
    public function update($obj,$id){
		$where = $this->obj->getAdapter()->quoteInto('idCategoria = ?', $id);
    	return $this->obj->update($obj,$where);
    }		
	
}