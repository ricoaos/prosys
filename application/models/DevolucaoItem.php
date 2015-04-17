<?php

class Model_DevolucaoItem {
	
	public $obj;
	
	public function __construct(){
		$this->obj = new Model_DbTable_DevolucaoItem();
	}
	
	public function getDevolucao()
	{
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('A0' => 'emprestimo'), array('*'))
        	->join(array('A1' => 'usuarios'),'A0.idUsuario = A1.idusuarios',array('A1.nome AS usuarios'))
        	->join(array('A2' => 'item'),'A0.idItem = A2.idItem',array('A2.nmItem AS exemplar'))
        	->joinLeft(array('A3' => 'renovar_item'),'A0.idEmprestimo= A3.idEmprestimo',array('A3.dataRenovacao'));
		return $this->obj->fetchAll($select);
	} 
	
	public function getDevolucaobyUser($id)
	{
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('devolucao_item'), array('idDevolucao'))
        	->where('idEmprestimo = ?', $id );
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