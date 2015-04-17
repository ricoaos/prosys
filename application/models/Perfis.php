<?php

class Model_Perfis {
	
	public $obj;
	public $chave;
	
	public function __construct(){
		$this->obj = new Model_DbTable_Perfis();
		$this->chave = 'idperfis';
	}
	
	public function getPerfis()
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
		$where = $this->obj->getAdapter()->quoteInto("$this->chave = ?", $id);
    	return $this->obj->update($obj,$where);
    }	
    
    public function delete($id){
    	$where = $this->obj->getAdapter()->quoteInto("$this->chave = ?", $id);
    	return $this->obj->delete($where);
    }    
}