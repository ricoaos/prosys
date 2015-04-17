<?php

class Model_Item {
	
	public $obj;
	
	public function __construct(){
		$this->obj = new Model_DbTable_Item();
	}
	
	public function getItem()
	{
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('p' => 'item'), array('*'))
        	->join(array('a' => 'autor'),'p.idAutor = a.idAutor',array( 'a.nomeAutor'))
        	->join(array('b' => 'editora'),'p.idEditora = b.idEditora',array( 'b.nomeEditora'))
        	->join(array('c' => 'categoria'),'p.idCategoria = c.idcategoria',array( 'c.nomeCategoria'))
        	->join(array('d' => 'segmento'),'p.idSegmento = d.idSegmento',array( 'd.nomeSegmento'))
        	->where('p.idExclusao!= ?','E');
		return $this->obj->fetchAll($select);
	} 
	
	public function getItembyAdmin()
	{
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('p' => 'item'), array('*'))
        	->join(array('a' => 'autor'),'p.idAutor = a.idAutor',array( 'a.nomeAutor'))
        	->join(array('b' => 'editora'),'p.idEditora = b.idEditora',array( 'b.nomeEditora'))
        	->join(array('c' => 'categoria'),'p.idCategoria = c.idcategoria',array( 'c.nomeCategoria'))
        	->join(array('d' => 'segmento'),'p.idSegmento = d.idSegmento',array( 'd.nomeSegmento'));
		return $this->obj->fetchAll($select);
	} 
	
	public function getItembyEmprestimo($id)
	{
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('A0' => 'item'), array('*'))
        	->join(array('A1' => 'emprestimo'),'A0.idItem = A1.idItem')
        	->where('A1.idEmprestimo = ?',$id);
		return $this->obj->fetchAll($select);
	}
		
	public function find($id)
	{
		return $this->obj->find($id)->toArray();
	}
	
	public function update($obj,$id)
    {
		$where = $this->obj->getAdapter()->quoteInto('idItem = ?', $id);
    	return $this->obj->update($obj,$where);
    }
    
	public function save($data)
	{ 	
		return $this->obj->insert($data);
	}
}