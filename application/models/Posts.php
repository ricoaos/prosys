<?php

class Model_Posts {
	
	public $obj;
	
	public function __construct(){
		$this->obj = new Model_DbTable_Posts();
	}
	
	public function getPosts()
	{
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('p' => 'posts'), array('*'))
        	->join(array('u' => 'usuarios'),'p.usuarios_idusuarios = u.idusuarios',array('u.username', 'u.nome AS nmuser'))
        	->join(array('s' => 'status_registro'),'p.status_registro_idstatus_registro = s.idstatus_registro',array('s.nome AS nmstatus', 's.idstatus_registro'))
        	->order('s.idstatus_registro');		
		return $this->obj->fetchAll($select);		
		
		return $this->obj->fetchAll()->toArray();
	}
		
	public function getEstatisticas(){
		$select = $this->obj->select()->setIntegrityCheck(false)
        	->from(array('p' => 'posts'), array(
        		'COUNT(CASE WHEN p.status_registro_idstatus_registro=1 THEN 1 end) as Publicado',
        		'COUNT(CASE WHEN p.status_registro_idstatus_registro=2 THEN 2 end) as Rascunho',
        		'COUNT(CASE WHEN p.status_registro_idstatus_registro=3 THEN 3 end) as Revisao_Pendente',
        		'COUNT(CASE WHEN p.status_registro_idstatus_registro=4 THEN 4 end) as Lixeira'
        	));
        return $this->obj->fetchAll($select);	
	}
		
	public function getPostsAtivos()
	{
		$select = $this->obj->select(Zend_Db_Table::SELECT_WITH_FROM_PART)->setIntegrityCheck(false)
			->distinct()	
			->join('status_registro', 'status_registro_idstatus_registro = idstatus_registro', array('nome AS nmStatus'))
			->join('categorias', 'idcategorias = categorias_idcategorias', array('nome AS nmCategoria', 'idcategorias'))
			->join('usuarios', 'idusuarios = posts.usuarios_idusuarios', array('nome AS nmUsuario'))
			->where('posts.ativo = ?','S')
			->order('idposts DESC');
		return $this->obj->fetchAll($select);	
	}
	
	public function getPostsAtivosByCategoria($idcategoria)
	{
		$select = $this->obj->select(Zend_Db_Table::SELECT_WITH_FROM_PART)->setIntegrityCheck(false)
			->distinct()	
			->join('status_registro', 'status_registro_idstatus_registro = idstatus_registro', array('nome AS nmStatus'))
			->join('categorias', 'idcategorias = categorias_idcategorias', array('nome AS nmCategoria', 'idcategorias'))
			->join('usuarios', 'idusuarios = posts.usuarios_idusuarios', array('nome AS nmUsuario'))
			->where('posts.ativo = ?','S')
			->where('categorias.idcategorias=?',$idcategoria)
			->order('idposts DESC');
		return $this->obj->fetchAll($select);	
	}	
	
	public function getPostsAtivosById($idpost)
	{
		$select = $this->obj->select(Zend_Db_Table::SELECT_WITH_FROM_PART)->setIntegrityCheck(false)
			->distinct()	
			->join('status_registro', 'status_registro_idstatus_registro = idstatus_registro', array('nome AS nmStatus'))
			->join('categorias', 'idcategorias = categorias_idcategorias', array('nome AS nmCategoria', 'idcategorias'))
			->join('usuarios', 'idusuarios = posts.usuarios_idusuarios', array('nome AS nmUsuario'))
			->where('posts.ativo = ?','S')
			->where('posts.idposts = ?',$idpost)
			->order('idposts DESC');
		return $this->obj->fetchAll($select);	
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
		$where = $this->obj->getAdapter()->quoteInto('idposts = ?', $id);
    	return $this->obj->update($obj,$where);
    }	
    
    public function delete($id){
    	
		$obj = array(
		    'status_registro_idstatus_registro' => '4',
		    'userinclusao' => '10',
			'ativo' => 'N'
		);    	
    	$where = $this->obj->getAdapter()->quoteInto('idposts = ?', $id);
    	return $this->obj->update($obj,$where);    	
    }    
}