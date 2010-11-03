<?php

include_once($_SERVER['DOCUMENT_ROOT']."/projects/inc/PDatabase.php");

class UserDb
{
	private $_db;

	public function __construct()
	{
		$this->_db = new PDatabase();
	}

	public function login($username,$password)
	{
		$pwd = md5($password."eprojects");
		$sql = "SELECT * FROM tbl_users WHERE username = '".$username."' AND '".$pwd."'";
		$results = $this->_db->prepare($sql);
		$results->execute();
		if($results->rowCount()){
			$row = $results->fetch(PDO::FETCH_ASSOC);	
			return true;	
		} else {
			return false;		
		}
	}
}
