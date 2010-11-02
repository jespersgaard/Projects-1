<?php
/**
 * Auth Class that handles authentication with Projects using LDAP
 *
 *
 * @author Mark Myers
 * @package Projects
 */
class Auth {
	/**
	 * Object handle to adLDAP object
	 *
	 * @access protected
	 * @var object
	 */
	protected $_ldap;

	/**
	 * Object handle to User object
	 * 
	 * @access protected
	 * @var object
	 */
	protected $_user;
	
	/**
	 * Constructor Method
	 *
	 * Instantiates class variables of said object type
	 */
	public function __construct(){
		$this->_ldap = new adLDAP();
		$this->_user = new Users();
	}
	
	/**
	 * Login Method
	 *
	 * This public method authenticates passed in parameters 
	 * against the adLDAP object
	 *
	 * @access public
	 * @param string $username
	 * @param string $password
	 * @return bool
	 */
	public function login($username,$password){
		if($this->_ldap->authenticate($username,$password)){
			$arrTemp = $this->_ldap->user_info($username);
			$this->__setUser($arrTemp);
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * GetUser Method
	 * 
	 * Gets current logged in user object
	 *
	 * @access public
	 * @return object
	 */
	public function getUser(){
		return $this->_user;
	}
	
	/**
	 * SetUser Method
	 *
	 * Sets user object from authenticated user in login method
	 *
	 * @access protected
	 * @param array $arr
	 */
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
}
