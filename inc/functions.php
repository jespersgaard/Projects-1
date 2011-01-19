<?php

function __autoload($class){
	require_once($_SERVER['DOCUMENT_ROOT']."/projects/inc/".$class . ".php");
}

function processMetaItem($arrTemp, &$item){
	foreach($arrTemp as $key=>$value){
		if("TODO" == strtoupper(trim($value))){
			$item->is_todo = 1;
			$return = true;
		}
		if(preg_match("/\d:\d+/",trim($value),$matches)){
			$item->p_time = $matches[0];
			$return = true;
		}
		if(preg_match("/\w+/",trim($value))){
			$return = processPidUid(trim($value),$item);
		}
		if(!$return){
			break;
		}
	}
	return $return;
}

function getAllView($bool=false){
	$db = new ProjectsDb();
	$t = new Task();
	
	$array = $db->getActiveDesc($t,$bool);
	//FB::log($array,"ARRAY");
	if(is_array($array)) {
		foreach($array as $key=>$value) {
			$title = $value->task;
			$id = $value->id;
			//$uid = 
			//FB::log($value,"Task Object");
			if($value->uid){
				//FB::log("Made it here...");
				$u = new Users();
				$u->id = $value->uid;
				$db->getUserById($u);
				$fullName = $u->f_name . " ". $u->l_name;
			} else {
				$fullName = "";
			}
			if($value->pid){
				$p = new Project();
				$p->id = $value->pid;
				$db->getProjectById($p);
				$project = $p->p_name;
			} else {
				$project = "";
			}
			if($value->is_todo){
				if($value->is_done){
					$todo = "<input type='checkbox' class='todo' value='$id' checked='checked' />";
				} else {
					$todo = "<input type='checkbox' class='todo' value='$id' />";
				}
			} else {
				$todo = "";
			}
			echo "<div class='item'>$todo $title";
			echo "<br /><div id='item-subtext'>$fullName";
			
			if($project != ""){
				echo " | $project";
			}
			
			echo "</div></div>\n";
		}
	}
}


function processPidUid($value,&$item){
	$arrWords = explode(" ",$value);
	$db = new ProjectsDb();
	if(!$db->doesExistByFullName($arrWords)){
		if(!$db->doesExistByProjectName($value)){
			$return = false;
		} else {
			$item->pid = $db->doesExistByProjectName($value);
			$return = true;
		}
	} else {
		$item->uid = $db->doesExistByFullName($arrWords);
		$return = true;
	}
	return $return;
}

function getUsers($bool=false,$pid=null){
	$db = new ProjectsDb();
	$u = new Users();

	$array = $db->getActiveDesc($u);
	if(!$bool){
		if(is_array($array)) {
			foreach($array as $key=>$value) {
				$fullname = $value->f_name . " ". $value->l_name;
				$id = $value->id;
				echo "<div class='item'><h4>$fullname</h4>\n";
				echo "<div id='pItem'>";
				getProjectByUserId($id);
				echo "</div>";
				echo "</div>";
			}
		} 
	} else {
		$arrActiveP = $db->getProjectPermsById($pid);
		if(is_array($array) && is_array($arrActiveP)){
            foreach($arrActiveP as $column=>$pValue){
                foreach($array as $key => $value){
                    $fullname = $value->f_name . " ". $value->l_name;
                    $id = $value->id;
                    if($id == $pValue){
                        echo "<input type='checkbox' name='pPerms' class='pPerms' value='$id' checked='checked' />$fullname";
                    } else {
                        echo "<input type='checkbox' name='pPerms' class='pPerms' value='$id' />$fullname";
                    }
                }
			}
		}
	}
}

function getProjects($id=null){
	$db = new ProjectsDb();
	$p = new Project();
	if($id==null){
        $array = $db->getActiveDesc($p);
        if(is_array($array)) {
            foreach($array as $key=>$value) {
                $title = $value->p_name;
                $id = $value->id;
                echo "<div class='item'><h4>$title</h4>\n";
                echo "<div id='pItem'>";
                echo "Basic<hr/>\n";
                echo "<form name='pItem_name' action='projects.php' method='post'>\n";
                echo "<label for='p_name'>Name:</label>    <input type='text' name='p_name' class='input' value='$title' />";
                echo "</form>";
                echo "<br/><br/>Time Entries<hr/>";
                echo "<br/><br/>Permissions<hr/>";
                getUsers(true,$id);
                echo "<input type='hidden' name='pid' id='pid' value='$id' />";
                echo "<br/><br/>Status<hr/>";
                echo "<a href='projects.php?pid=$id&a=a'>Archive this project</a> | <a href='projects.php?pid=$id&a=d'>Delete THIS Project</a>";
                echo "</div>";
                echo "</div>";
            }
        } 
	} else {
	   
	}
}

function getProjectByUserId($id){
	$db = new ProjectsDb();
	$array = $db->getProjectsByUserId($id);
	if(is_array($array)) {
		//echo "<form action='".$_SERVER['PHP_SELF']."' method='post' id='todo' name='todo'>";
		foreach($array as $key=>$value) {
			echo "<a href='projects.php?pid=".$value->id."'>".$value->p_name."</a><br/>";
		}
		//echo "</form>";
	} else {
	   print_r($array);
	}
}

function getTaskByUserId($id){
	$db = new ProjectsDb();
	$t = new Task();
	$t->uid = $id;
	$array = $db->getActiveTaskByUser($t);
	if(is_array($array)) {
		//echo "<form action='".$_SERVER['PHP_SELF']."' method='post' id='todo' name='todo'>";
		foreach($array as $key=>$value) {
			$title = $value->task;
			$id = $value->id;
			echo "<div id='task'><input type='checkbox' name='task_item' class='task_item' value='$id' />$title</div>";
		}
		//echo "</form>";
	} 
}