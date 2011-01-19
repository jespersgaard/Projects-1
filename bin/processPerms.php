<?php
require_once($_SERVER['DOCUMENT_ROOT']."/projects/inc/ProjectsDb.php");
include("FirePHP.class.php");
$fb = FirePHP::getInstance(true);

$db = new ProjectsDb();
$id = $_POST['uid'];
$pid = $_POST['pid'];

$fb->log($_POST,"Posted Items");


if(!array_key_exist('remove',$_POST)){
    $fb->log("Maded it to added to project");
	$db->setPerms($id,$pid,false,&$fb);
} else {
    $fb->log("Remove from project");
	$db->setPerms($id,$pid,true,&$fb);
}

exit();
