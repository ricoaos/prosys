<?php

class Model_Emprestimo {
	
	public $obj;
	
	public function __construct(){
		$this->obj = new Model_DbTable_Emprestimo();
	}
	
	public function getEmprestimo()
	{
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('A0' => 'emprestimo'), array('*'))
        	->join(array('A1' => 'usuarios'),'A0.idUsuario = A1.idusuarios',array('A1.nome AS usuarios'))
        	->join(array('A2' => 'item'),'A0.idItem = A2.idItem',array('A2.nmItem AS exemplar'))
        	->joinLeft(array('A3' => 'renovar_item'),'A0.idEmprestimo= A3.idEmprestimo',array('A3.dataRenovacao'))
        	->where('A0.status != ?', 1 );
		return $this->obj->fetchAll($select);
	} 
	
	public function getEmprestimobyUser($id)
	{
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('A1' => 'emprestimo'), array('*'))
        	->join(array('A2' => 'item'),'A1.idItem = A2.idItem',array( 'A2.nmItem AS exemplar'))
        	->joinLeft(array('A3' => 'renovar_item'),'A1.idEmprestimo= A3.idEmprestimo',array('A3.dataRenovacao'))
        	->where('A1.idUsuario = ?', $id )
        	->where('A1.status!=?',1);
		return $this->obj->fetchAll($select);
	}

	public function find($id)
	{
		return $this->obj->find($id)->toArray();
	}
	
	public function update($obj,$id)
    {
		$where = $this->obj->getAdapter()->quoteInto('idEmprestimo = ?', $id);
    	return $this->obj->update($obj,$where);
    }
    
	public function save($data)
	{ 	
		return $this->obj->insert($data);
	} 
}