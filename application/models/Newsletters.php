<?php

class Model_Newsletters {
	
	public $obj;
	
	public function __construct(){
		$this->obj = new Model_DbTable_Newsletters();
	}
	public function getNewsletters()
	{
		return $this->obj->fetchAll()->toArray();
	}
	
	public function find($id)
	{
		return $this->obj->find($id)->toArray();
	}
	
	public function getnewsByemail($idemail){
		return $this->obj->fetchAll($this->obj->select()->where('email=?',$idemail))->toArray();
	}	
	
	public function save($obj)
	{
		return $this->obj->insert($obj);
	}
	
    public function update($obj,$id)
    {
		$where = $this->obj->getAdapter()->quoteInto('idnewsletters = ?', $id);
    	return $this->obj->update($obj,$where);
    }		
    
    public function delete($id){
    	$where = $this->obj->getAdapter()->quoteInto('idnewsletters = ?', $id);
    	return $this->obj->delete($where);
    }     
	
}