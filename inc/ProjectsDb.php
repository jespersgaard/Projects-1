<?php

include_once($_SERVER['DOCUMENT_ROOT']."/projects/inc/PDatabase.php");

class ProjectsDb {
	private $_db;
	
	public function __construct(){
		$this->_db = new PDatabase();
	}
	
	public function delete_by_id($id,$object){
		if(is_object($object)){
			$sql = "UPDATE ".$object::TABLE." SET is_active = '0' WHERE id='".$id."'";
			$results = $this->_db->query($sql);
		}
	}
	
	public function archive_by_id($id,$object){
	   if(is_object($object)){
	       $sql = "UPDATE ".$object::TABLE." SET is_archived = '1' WHERE id='".$id."'";
	       $results = $this->_db->query($sql);
	   }
	}
	
	public function update_by_id($id,$object){
		if(is_object($object)){
			$sql = "UPDATE ".$object::TABLE." SET";
			$arrFields = $object->getFields();
			for($i = 0; $i < sizeof($arrFields); $i++){
				$tmp = $arrFields[$i];
				$sql .= " ".$tmp . " = '".$object->$tmp."' ";
				if($i < (sizeof($arrFields) -1)){
					$sql .= "AND";
				}
			}
			$sql .= " WHERE id '".$id."'";
		}
	}
	
	public function getSuggestions($query, $fb){
		if(strlen($query)>0){			
			$arrColl = array();
			$query = trim($query, "'");
			if(strcasecmp("t",$query) == 0){
				$arrColl[] = "TODO";
			} 
			$fb->log($query,"Passed Query String");
			$sql = "SELECT p_name FROM tbl_projects WHERE p_name LIKE '".$query."%'";
			$fb->log($sql,"SQL Query Project");
			$results = $this->_db->prepare($sql);
			$results->execute();
			if($results->rowCount()){
				while($row = $results->fetch(PDO::FETCH_ASSOC)){
					$arrColl[] = $row['p_name'];
				}
			}
			$sql = "SELECT f_name, l_name FROM tbl_users WHERE f_name LIKE '".$query."%'";
			$fb->log($sql,"SQL Query User");
			$results = $this->_db->prepare($sql);
			$results->execute();
			if($results->rowCount()){
				while($row = $results->fetch(PDO::FETCH_ASSOC)){
					$arrColl[] = $row['f_name'] . " ".$row['l_name'];
				}
			}
			return $arrColl;
		}
	}
	
	public function getActive($object){
		if(is_object($object)){
			$sql = "SELECT * FROM ". $object::TABLE . " WHERE is_active='1' ORDER BY id asc";
			$results = $this->_db->prepare($sql);
			$results->execute();
			if($results->rowCount()){
				$oObj = $object::OBJ_CLASS;
				$tempColl = array();
				while($row = $results->fetch(PDO::FETCH_ASSOC)){
					$tempObj = new $oObj();
					foreach($row as $key=>$value){
						$tmpArr[$key] = $value;
					}
					$tempObj->setFields($tmpArr);
					$tempColl[] = $tempObj;
				}
			}
		} else {
			$tempColl = "No object passed to function";
		}
		return $tempColl;
	}
	
	public function getActiveTaskByUser($object){
		$tempColl = "";
		if(is_object($object)){
			$sql = "SELECT * FROM ". $object::TABLE . " WHERE uid='".$object->uid."' AND is_todo='1' AND is_done='0' ORDER BY id asc";
			$results = $this->_db->prepare($sql);
			$results->execute();
			if($results->rowCount()){
				$oObj = $object::OBJ_CLASS;
				$tempColl = array();
				while($row = $results->fetch(PDO::FETCH_ASSOC)){
					$tempObj = new $oObj();
					foreach($row as $key=>$value){
						$tmpArr[$key] = $value;
					}
					$tempObj->setFields($tmpArr);
					$tempColl[] = $tempObj;
				}
			}
		} else {
			$tempColl = "No object passed to function";
		}
		return $tempColl;
	}
	

	public function doesExistByUsername(&$object){
		if(is_object($object)){
			$sql = "SELECT id FROM ".$object::TABLE." WHERE username='".$object->username."'";
			$results = $this->_db->prepare($sql);
			$results->execute();
			if(!$results->rowCount()){
				$exist = $this->save($object);
			} else {
				$arr = $results->fetch(PDO::FETCH_ASSOC);
				$object->id = $arr['id'];
				$exist = true;
			}
		}
		return $exist;
	}
	
	public function doesExistByFullName($name){
		$sql = "SELECT id FROM tbl_users WHERE f_name='".$name[0]."' AND l_name='".$name[1]."'";
		$results = $this->_db->prepare($sql);
		$results->execute();
		if(!$results->rowCount()){
			$exist = false;
		} else {
			$arr = $results->fetch(PDO::FETCH_ASSOC);
			$exist = $arr['id'];
		}
		return $exist;
	}
	
	public function doesExistByProjectName($name){
		$sql = "SELECT id FROM tbl_projects WHERE p_name='".$name."'";
		$results = $this->_db->prepare($sql);
		$results->execute();
		if(!$results->rowCount()){
			$exist = false;
		} else {
			$arr = $results->fetch(PDO::FETCH_ASSOC);
			$exist = $arr['id'];
		}
		return $exist;
	}
	
	public function getUserById(&$object){
		if(is_object($object)){
			$sql = "SELECT f_name, l_name FROM tbl_users WHERE id = '".$object->id."'";
			$results = $this->_db->prepare($sql);
			$results->execute();
			if($results->rowCount()){
				$row = $results->fetch(PDO::FETCH_ASSOC);
				$object->f_name = $row['f_name'];
				$object->l_name = $row['l_name'];
			}
		}
	}
	
	public function getProjectById(&$object){
		if(is_object($object)){
			$sql = "SELECT p_name FROM tbl_projects WHERE id = '".$object->id."'";
			$results = $this->_db->prepare($sql);
			$results->execute();
			if($results->rowCount()){
				$row = $results->fetch(PDO::FETCH_ASSOC);
				$object->setP_name($row['p_name']);
				$object->setP_desc($row['p_desc']);
			}
		}
	}
	
	public function setTaskDone($id){
		$sql = "UPDATE tbl_task SET is_done='1' WHERE id='$id'";
		print_r($sql);
		$results = $this->_db->query($sql);
		
	}
	
	public function setPerms($id,$pid,$bool = false){
		if(!$bool){
			$sql = "INSERT INTO tbl_project_perms (pid,uid,is_creator) VALUES ('".$pid."','".$id."',0)";
		} else {
			$sql = "DELETE FROM tbl_project_perms WHERE uid='".$id."'";
		}
		$this->_db->query($sql);
	}
	
	public function getProjectsByUserId($id){
	   $sql = "SELECT * FROM tbl_project_perms as t1 INNER JOIN tbl_projects as t2 ON t1.pid = t2.id WHERE uid = '".$id."' AND t2.is_active = '1' AND t2.is_archived = '0'";
	   $results = $this->_db->prepare($sql);
	   $results->execute();
	   if($results->rowCount()){
	       while($row = $results->fetch(PDO::FETCH_ASSOC)){
	           $pObj = new Project();
	           $pObj->id = $row['pid'];
	           $this->getProjectById($pObj);
	           $tempColl[] = $pObj;
	       }
	   }
	   return $tempColl;
	}
	
	public function getActiveDesc($object,$bool=false){
		$tempColl = "";
		if(is_object($object)){
			if($bool){
				$add = " LIMIT 25 ";
			} else {
				$add = "";
			}
			$sql = "SELECT * FROM ".$object::TABLE." WHERE is_active='1' ORDER BY id desc$add";
			$results = $this->_db->prepare($sql);
			$results->execute();
			if($results->rowCount()){
				$oObj = $object::OBJ_CLASS;
				$tempColl = array();
				while($row = $results->fetch(PDO::FETCH_ASSOC)){
					if($row != NULL){
						$tempObj = new $oObj();
						foreach($row as $key=>$value){
							$tmpObjArr[$key] = $value;
						}
						$tempObj->setFields($tmpObjArr);
						$tempColl[] = $tempObj;
					}
				}
			}
		} else {
			$tempColl = "No object passed to function";
		}
		return $tempColl;
	}
	
	public function save(&$object){
		if(is_object($object)){
			$sql = "INSERT INTO ".$object::TABLE." (";
			$fields = $object->getFields();
			$size = sizeof($fields);
			$i = 1;
			foreach($fields as $key=>$value){
				if($i != 1){
					$sql .= $value;
					if($i < $size){
						$sql .= ",";
					}
				}
				$i++;
			}
			$sql .= ") VALUES (";
			$sql .= $object->getInsert();
			$sql .= ")";
			$results = $this->_db->query($sql);
		}
		$object->id = $this->_db->lastInsertId();
		
		return $object->id;
	}
}
