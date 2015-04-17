<?php

class Model_Multa {
	
	public $obj;
	
	public function __construct(){
		$this->obj = new Model_DbTable_Multa();
	}
	
	public function getMulta()
	{
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('A0' => 'multa'), array('*'))
        	->join(array('A1' => 'devolucao_item'),'A0.idDevolucao = A1.idDevolucao')
        	->join(array('A2' => 'emprestimo'),'A1.idEmprestimo = A2.idEmprestimo')
        	->join(array('A3' => 'usuarios'),'A2.idUsuario= A3.idusuarios',array('A3.nome'));
        	//->where('A0.status != ?', 1 );
		return $this->obj->fetchAll($select);
	} 
	
	public function getMultabyUser($id)
	{
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('A0' => 'multa'), array('*'))
        	->join(array('A1' => 'devolucao_item'),'A0.idDevolucao = A1.idDevolucao')
        	->join(array('A2' => 'emprestimo'),'A1.idEmprestimo = A2.idEmprestimo')
        	->join(array('A3' => 'usuarios'),'A2.idUsuario= A3.idusuarios',array('A3.nome'))
        	->where('A3.idusuarios = ?', $id );
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