<?php

class ProjectPerms {
	const TABLE = 'tbl_project_perms';
	const OBJ_CLASS = 'ProjectPerms';
	
	protected $_id;
	protected $_pid;
	protected $_uid;
	protected $_is_creator;
	
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
		return array('id','pid','uid','is_creator');
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
	
	public function setPid($pid){
		$this->_pid = (int) $pid;
	}
	
	public function getPid(){
		return $this->_pid;
	}
	
	public function setUid($uid){
		$this->_uid = (int) $uid;
		return $this;
	}
	
	public function getUid(){
		return $this->_uid;
	}
	
	public function setIs_creator($str){
		$this->_is_creator = $str;
		return $this;
	}
	
	public function getIs_creator(){
		return $this->_is_creator;
	}
	
	public function getInsert(){
		return " '".$this->getPid()."','".$this->getUid()."','".$this->getIs_creator()."' ";
	}
}