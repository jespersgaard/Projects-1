<?php
class Session{
	var $__setting;
   
	function __construct($name = 'NASUsers'){
		$this->__setting = new stdClass();
		$this->__setting->name = $name;
		$this->__setting->_session = array();
		$this->__setting->space = '___';
		if(!isset($_SESSION)) session_start();
		if(count($_SESSION)>0){
			foreach($_SESSION as $name => $value){
				$temp = explode($this->__setting->space,$name);
				if($temp[0] == $this->__setting->name){
					$name = str_replace($this->__setting->name.$this->__setting->space,'',$name);
					$this->__setting->_session[$name] = $value;
				}
			}
		}
	}
	
	private function name($name = null){
		return $this->__setting->name.$this->__setting->space.$name;
	}
	
	public function __get($name){
		return @$this->__setting->_session[$name];
	}
	
	public function __set($name,$value){
		$this->__setting->_session[$name] = $value;
		$name = $this->name($name);
		$_SESSION[$name] = $value;
	}
	
	public function __isset($name){
		return isset($this->__setting->_session[$name]);
	}
	
	function clean(){
		if(count($this->__setting->_session)>0){
			foreach($this->__setting->_session as $name => $value){
				$name = $this->name($name);
				unset($_SESSION[$name]);
			}
			$this->__setting->_session = array();
		}
	}
	
	function destroy(){
		$this->__setting->_session = array();
		 session_destroy();
	}
	
	function fromArray($a=null){
		if(is_array($a)){
			foreach($a as $k => $v) $this->$k = $v;
		}
	}
	
    function toArray(){
      return $this->__setting->_session;
	}
}