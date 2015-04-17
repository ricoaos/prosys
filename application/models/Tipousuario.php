<?php

class Model_Tipousuario{
	
	public $obj;
	
	public function __construct(){
		$this->obj = new Model_DbTable_Tipousuario();
	}
	
	public function getTipoUsuario()
	{
		return $this->obj->fetchAll()->toArray();
	} 

	public function find($id)
	{
		return $this->obj->find($id)->toArray();
	}
	
	public function update($obj,$id)
    {
		$where = $this->obj->getAdapter()->quoteInto('idtipo_usuario = ?', $id);
    	return $this->obj->update($obj,$where);
    }
    
	public function save($obj)
	{ 	
		return $this->obj->insert($obj);
	}
}