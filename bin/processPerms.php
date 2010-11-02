<?php
//require_once('fb.php');
require_once("../inc/ProjectsDb.php");
$db = new ProjectsDb();
$id = $_POST['uid'];
$pid = $_POST['pid']
if(array_key_exist('remove',$_POST)){
	$db->setPerms($id,$pid,true);
} else {
	$db->setPerms($id,$pid);
}

