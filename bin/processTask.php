<?php
require_once($_SERVER['DOCUMENT_ROOT']."/projects/inc/ProjectsDb.php");

$tid = $_POST['task_item'];

$db = new ProjectsDb();
$db->setTaskDone($tid);