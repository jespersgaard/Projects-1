<?php
require_once($_SERVER['DOCUMENT_ROOT']."/projects/inc/ProjectsDb.php");
include("FirePHP.class.php");
$fb = FirePHP::getInstance(true);

$db = new ProjectsDb();
$id = $_POST['uid'];
$pid = $_POST['pid'];

$fb->log($_POST,"Posted Items");
exit();

if(!array_key_exist('remove',$_POST)){
	$db->setPerms($id,$pid);
} else {
	$db->setPerms($id,$pid,true);
}

