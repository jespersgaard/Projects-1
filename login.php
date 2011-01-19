<?php
require_once($_SERVER['DOCUMENT_ROOT']."/projects/inc/functions.php");
print $_SERVER['DOCUMENT_ROOT'];
include("FirePHP.class.php");
$fb = FirePHP::getInstance(true);

if(isset($_POST) && sizeof($_POST) > 0){
	$fb->log("posted data");
	$session = new Session();
	$auth = new Auth();
	if($auth->login($_POST['uid'],$_POST['pwd'])){
		$fb->::log("Login Successful!");
		$db = new ProjectsDb();
		$oUser = $auth->getUser();
		$fb->log($oUser,"User Object");
		if($db->doesExistByUsername($oUser)){
			$fb->log("User does exist");
			$session->__set('id',$oUser->id);
			$session->__set('fullname',$oUser->f_name." ".$oUser->l_name);
			header("Location: index.php");
		}
	} else {
		print "there was an error";
	}
} else {
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Projects</title>
		<link rel="stylesheet" href="/projects/css/login.css" />
	</head>
<body>
<br/>
<br/>
<form action="login.php" method="post" name="loginFrm">
	<fieldset id="login">
		<legend>Login</legend>
		<label for="uid">Username:</label><br/>
		<input type="text" name="uid" id="uid"/><br/><br/>
		<label for="pwd">Password:</label><br/>
		<input type="password" name="pwd" id="pwd" /><br/><br/>
		<input type="submit" name="submit" id="submit" value="Submit" />
	</fieldset>
</form>
</body>
</html>
	<?php 
}
