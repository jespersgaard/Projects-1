<?php
//include("fb.php");
require_once("../inc/ProjectsDb.php");

if(isset($_POST['queryString'])){
	$db = new ProjectsDb();
	$qString = $_POST['queryString'];
	if(preg_match("/, /",$qString)){
		list($throwAway,$qString) = preg_split("/, /",$qString);
	}
	$arrSuggest = $db->getSuggestions($qString);
	foreach($arrSuggest as $key => $value){
		echo "<li onClick=\"fill('".$value."');\">".$value."</li>";
	}
}