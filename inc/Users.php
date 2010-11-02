<?php

class Users {
	const TABLE = 'tbl_users';
	const OBJ_CLASS = 'Users';
	
	protected $_id;
	protected $_username;
	protected $_f_name;
	protected $_l_name;
	protected $_email;
	
	public function __construct(array $options = null){
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
		return array('id','username','f_name','l_name','email');
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
	
	public function setUsername($text){
		$this->_username = (string) $text;
		return $this;
	}
	
	public function getUsername(){
		return $this->_username;
	}
	
	public function setF_name($text){
		$this->_f_name = (string) $text;
		return $this;
	}
	
	public function getF_name(){
		return $this->_f_name;
	}
	
	public function setL_name($text){
		$this->_l_name = (string) $text;
		return $this;
	}
	
	public function getL_name(){
		return $this->_l_name;
	}
	
	public function setEmail($text){
		$this->_email = (string) $text;
		return $this;
	}
	
	public function getEmail(){
		return $this->_email;
	}
	
	public function getInsert(){
		return " '".$this->getUsername()."','".$this->getF_name()."','".$this->getL_name()."','".$this->getEmail()."' ";
	}
}