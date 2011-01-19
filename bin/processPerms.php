<?php
require_once($_SERVER['DOCUMENT_ROOT']."/projects/inc/ProjectsDb.php");
include("FirePHP.class.php");
$fb = FirePHP::getInstance(true);

$db = new ProjectsDb();
$id = $_POST['uid'];
$pid = $_POST['pid']
$fb->log($id,"User ID");
$fb->log($pid,"Project ID");

print_r($_POST);

if(array_key_exist('remove',$_POST)){
    $fb->log("Remove from project");
	$db->setPerms($id,$pid,true);
} else {
    $fb->log("Add to project");
	$db->setPerms($id,$pid);
}

