<?php

class Model_ReservaItem {
	
	public $obj;
	
	public function __construct(){
		$this->obj = new Model_DbTable_ReservaItem();
	}
	
	public function getReservas()
	{
		return $this->obj->fetchAll()->toArray();
	} 
	
	public function getAllReservas()
	{
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('A1' => 'reserva_item'), array('*'))
        	->join(array('A2' => 'item'),'A1.idItem = A2.idItem',array('A2.nmItem AS nome'))
        	->join(array('A3' => 'usuarios'),'A1.idUsuarios = A3.idusuarios',array('A3.nome AS usuario'))
        	->where('A1.status=?',1);
		return $this->obj->fetchAll($select);	
	}
	
	public function getReservaById($id)
	{
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('A1' => 'reserva_item'), array('*'))
        	->join(array('A2' => 'item'),'A1.idItem = A2.idItem',array( 'A2.nmItem AS nome'))
        	->where('A1.idUsuarios = ?', $id )
        	->where('A1.status=?',1);
		return $this->obj->fetchAll($select);
	}
	
	public function find($id)
	{
		return $this->obj->find($id)->toArray();
	}
	
	public function update($obj,$id)
    {
		$where = $this->obj->getAdapter()->quoteInto('idReserva = ?', $id);
    	return $this->obj->update($obj,$where);
    }
    
	public function save($data)
	{ 	
		return $this->obj->insert($data);
	}
}