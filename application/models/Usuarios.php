<?php

class Model_Usuarios {
	
	public $obj;
	
	public function __construct(){
		$this->obj = new Model_DbTable_Usuarios();
	}
	public function getUsuarios()
	{
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('A1' => 'usuarios'), array('*'))
        	->join(array('A2' => 'perfis'),'A1.perfis_idperfis = A2.idperfis',array( 'A2.nome AS nomePerfil'));
		return $this->obj->fetchAll($select);
		
		return $this->obj->fetchAll()->toArray();
	}
	
	public function find($id)
	{
		return $this->obj->find($id)->toArray();
	}
	
	public function getusuariosByid($idusuarios)
	{
		return $this->obj->fetchAll($this->obj->select()->where('idusuarios=?',$idusuarios))->toArray();
	}

	public function getuserbymatr($matricula)
	{
		return $this->obj->fetchAll($this->obj->select()->where('matricula=?',$matricula))->toArray();
	}
	
	public function save($data)
	{ 	
		return $this->obj->insert($data);
	}
	
    public function update($obj,$id)
    {
		$where = $this->obj->getAdapter()->quoteInto('idusuarios = ?', $id);
    	return $this->obj->update($obj,$where);
    }	

    
}