<?php

class Task {
	const TABLE = 'tbl_task';
	const OBJ_CLASS = 'Task';
	
	protected $_id;
	protected $_task;
	protected $_s_date;
	protected $_uid;
	protected $_p_time;
	protected $_pid;
	protected $_file;
	protected $_is_todo;
	protected $_is_done;
	protected $_is_active;
	
	public function __construct(array $options = null){
		$this->_s_date = date('Y-m-d');
		$this->_uid = null;
		$this->_p_time = null;
		$this->_pid = null;
		$this->_file = null;
		$this->_is_todo = null;
		$this->_is_done = null;
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
		return array('id','task','s_date','uid','p_time','pid','file','is_todo','is_done','is_active');
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
	
	public function setTask($text){
		$this->_task = (string) $text;
		return $this;
	}
	
	public function getTask(){
		return $this->_task;
	}
	
	public function setS_date($date=false){
		if(!$date){
			$this->_s_date = date('Y-m-d');
		} else {
			$this->_s_date = $date;
		}
	}
	
	public function getS_date(){
		if($this->_s_date == false){
			return date('Y-m-d');
		} else {
			return $this->_s_date;
		}
	}
	
	public function setUid($uid = null){
		if($uid != null){
			$this->_uid = (int) $uid;
		}
		return $this;
	}
	
	public function getUid(){
		return $this->_uid;
	}
	
	public function setP_time($time=null){
		if($time != null){
			$this->_p_time = (int)$time;
		}
		return $this;
	}
	
	public function getP_time(){
		return $this->_p_time;
	}
	
	public function setPid($pid=null){
		if($pid != null){
			$this->_pid = (int) $pid;
		}
		return $this;
	}
	
	public function getPid(){
		return $this->_pid;
	}
	
	public function setFile($file){
		if($file != null){
			$this->_file = $file;
		}
		return $this;
	}
	
	public function getFile(){
		return $this->_file;
	}
	
	public function setIs_todo($bool=0){
		$this->_is_todo = $bool;
		return $this;
	}
	
	public function getIs_todo(){
		return $this->_is_todo;
	}
	
	public function setIs_done($bool=0){
		$this->_is_done = $bool;
		return $this;
	}
	
	public function getIs_done(){
		return$this->_is_done;
	}
	
	public function setIs_active($bool=1){
		$this->_is_active = $bool;
		return $this;
	}
	
	public function getIs_active(){
		if($this->_is_active == ""){
			return 1;
		} else {
			return $this->_is_active;
		}
	}
	
	public function getInsert(){
		return " '".$this->getTask()."','".$this->getS_date()."','".$this->getUid()."','".$this->getP_time()."','".$this->getPid()."','".$this->getFile()."','".$this->getIs_todo()."','".$this->getIs_done()."', '".$this->getIs_active()."' ";
	}
}