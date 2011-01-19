<?php
require_once($_SERVER['DOCUMENT_ROOT']."/projects/inc/ProjectsDb.php");

$db = new ProjectsDb();
$id = $_POST['uid'];
$pid = $_POST['pid'];

if(sizeof($_POST) > 2){
	$db->setPerms($id,$pid,true,&$fb);
} else {
	$db->setPerms($id,$pid,false,&$fb);
}
