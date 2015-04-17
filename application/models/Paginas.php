<?php

class Model_Paginas {
	
	public $obj;
	
	public function __construct(){
		$this->obj = new Model_DbTable_Paginas();
	}
	
	public function getPaginas()
	{
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('p' => 'paginas'), array('*'))
        	->join(array('u' => 'usuarios'),'p.usuarios_idusuarios = u.idusuarios',array('u.username', 'u.nome AS nmuser'))
        	->join(array('s' => 'status_registro'),'p.status_registro_idstatus_registro = s.idstatus_registro',array('s.nome AS nmstatus', 's.idstatus_registro'))
        	->order('s.idstatus_registro');		
		return $this->obj->fetchAll($select);
	}
	
	public function getEstatisticas(){
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('p' => 'paginas'), array(
        		'COUNT(CASE WHEN p.status_registro_idstatus_registro=1 THEN 1 end) as Publicado',
        		'COUNT(CASE WHEN p.status_registro_idstatus_registro=2 THEN 2 end) as Rascunho',
        		'COUNT(CASE WHEN p.status_registro_idstatus_registro=3 THEN 3 end) as Revisao_Pendente',
        		'COUNT(CASE WHEN p.status_registro_idstatus_registro=4 THEN 4 end) as Lixeira'
        	));
        return $this->obj->fetchAll($select);	
	}
		
	public function getPaginasPublicadas()
	{
		return $this->obj->fetchAll($this->obj->select()->where('status_registro_idstatus_registro=?',1))->toArray();
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
		$where = $this->obj->getAdapter()->quoteInto('idpaginas = ?', $id);
    	return $this->obj->update($obj,$where);
    }	
    
    public function delete($id){
		$obj = array(
		    'status_registro_idstatus_registro' => '4',
		    'userinclusao' => '1',
			'ativo' => 'N'
		);    	
    	$where = $this->obj->getAdapter()->quoteInto('idpaginas = ?', $id);
    	return $this->obj->update($obj,$where);
    }    
}