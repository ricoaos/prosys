<?php

class Model_StatusRegistro {
	
	public $obj;
	
	public function __construct(){
		$this->obj = new Model_DbTable_StatusRegistro();
	}
	public function getStatus()
	{
		return $this->obj->fetchAll()->toArray();
	}
	
	public function find($id)
	{
		return $this->obj->find($id)->toArray();
	}
	
	public function save($obj)
	{
		return $this->obj->insert($obj);
	}
	
}