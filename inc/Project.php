<?php

class Project {
	const TABLE = 'tbl_projects';
	const OBJ_CLASS = 'Project';
	
	protected $_id;
	protected $_p_name;
	protected $_p_desc;
	protected $_is_archived;
	protected $_is_active;
	
	public function __construct(array $options = null){
		$this->_p_desc = null;
		$this->_is_archived = 0;
		$this->_is_active = 1;
		if(is_array($options)){
			$this->setFields($options);
		}
	}
	
	public function __set($name, $value){
        $method = 'set' . ucfirst($name);
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid property');
        }
        $this->$method($value);
    }
	
	public function __get($name){
        $method = 'get' . ucfirst($name);
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid property');
        }
        return $this->$method();
    }
	
	public function getFields(){
		return array('id','p_name','p_desc','is_archived','is_active');
	}
	
	public function setFields(array $arrFields){
		$methods = get_class_methods($this);
		foreach($arrFields as $key=>$value){
			$method = 'set'.ucfirst($key);
			if(in_array($method, $methods)){
				$this->$method($value);
			}
		}
	}
	
	public function setId($id){
		$this->_id = (int) $id;
		return $this;
	}
	
	public function getId(){
		return $this->_id;
	}
	
	public function setP_name($text){
		$this->_p_name = (string) $text;
		return $this;
	}
	
	public function getP_name(){
		return $this->_p_name;
	}
	
	public function setP_desc($text){
		$this->_p_desc = (string) $text;
		return $this;
	}
	
	public function getP_desc(){
		return $this->_p_desc;
	}
	
	public function setIs_archived($bool){
		$this->_is_archived = (int) $bool;
		return $this;
	}
	
	public function getIs_archived(){
		return $this->_is_archived;
	}
	
	public function setIs_active($bool){
		$this->_is_active = (int) $bool;
		return $this;
	}
	
	public function getIs_active(){
		return $this->_is_active;
	}
	
	public function getInsert(){
		return " '".$this->getP_name()."','".$this->getP_desc()."','".$this->getIs_archived()."','".$this->getIs_active()."' ";
	}
}