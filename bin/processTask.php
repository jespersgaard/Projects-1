<?php
//require_once('fb.php');
require_once("../inc/ProjectsDb.php");

$tid = $_POST['task_item'];

$db = new ProjectsDb();
$db->setTaskDone($tid);