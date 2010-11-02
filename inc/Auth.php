<?php
/**
 * @author 1009498
 *
 */
class Auth {
	/**
	 * @var adLDAP
	 */
	protected $_ldap;
	/**
	 * @var Users
	 */
	protected $_user;
	
	protected $_session;
	
	public function __construct(){
		$this->_ldap = new adLDAP();
		$this->_user = new Users();
	}
	
	public function login($username,$password){
		if($this->_ldap->authenticate($username,$password)){
			$arrTemp = $this->_ldap->user_info($username);
			$this->__setUser($arrTemp);
			return true;
		} else {
			return false;
		}
	}
	
	protected function __setUser(array $arr){
		$fullname = $arr[0]['displayname'][0];
		$username = $arr[0]['samaccountname'][0];
		$email = $arr[0]['mail'][0];
		
		list($f_name,$l_name) = explode(" ",$fullname);
		$account = array('username' =>$username,
						 'f_name'	=>$f_name,
						 'l_name'	=>$l_name,
						 'email'	=>$email
						);
		$this->_user->setFields($account);
	}
	
	public function getUser(){
		return $this->_user;
	}
	
	
}