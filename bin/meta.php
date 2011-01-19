<?php
require_once($_SERVER['DOCUMENT_ROOT']."/projects/inc/ProjectsDb.php");
include("FirePHP.class.php");
$fb = FirePHP::getInstance(true);

if(isset($_POST['queryString'])){
    $fb->log("posted data");
	$db = new ProjectsDb();
	$qString = $_POST['queryString'];
	if(preg_match("/, /",$qString)){
		list($throwAway,$qString) = preg_split("/, /",$qString);
	}
	$fb->log($qString,"Query String");
	$arrSuggest = $db->getSuggestions($qString,$fb);
	foreach($arrSuggest as $key => $value){
		echo "<li onClick=\"fill('".$value."');\">".$value."</li>";
	}
}