<?php
require_once($_SERVER['DOCUMENT_ROOT']."/projects/inc/ProjectsDb.php");

if(isset($_POST['queryString'])){
    $db = new ProjectsDb();
	$qString = $_POST['queryString'];
	if(preg_match("/, /",$qString)){
		list($throwAway,$qString) = preg_split("/, /",$qString);
	}
	$arrSuggest = $db->getSuggestions(stripslashes($qString));
	foreach($arrSuggest as $key => $value){
		echo "<li onClick=\"fill('".$value."');\">".$value."</li>";
	}
}