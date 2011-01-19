<?php 
//require_once('fb.php');
require_once('./inc/functions.php');
print $_SERVER['DOCUMENT_ROOT'];
exit();

$session = new Session();

$id = $session->__get('id');
$fullname = $session->__get('fullname');
if(!isset($id)){
	header("Location: login.php");
}

$status = "";

//ob_start();

//session_start();
if(isset($_POST) && sizeof($_POST)>0){
	//FB::log($_POST,"Post Data");
	$oTask = new Task();
	$task = $_POST['description'];
	$meta = $_POST['meta'];
	$oTask->uid = $id;
	$oTask->task = $task;
	$arrData = explode(",",$meta);
	processMetaItem($arrData,$oTask);
	$db = new ProjectsDb();
	if($db->save($oTask)){
		$status = "<div class='success'><h2>Saved Task Successfully!</h2></div>";
	} else {
		//FB::log($oTask,"Task Object");
		$status = "<div class='error'>!*!ERROR!*!</div>";
	}
}

include("bin/header.php");
?>

	<div class="container">
		<?php print "<br /><br />".$status; ?>
		<br /><br />
		<div class="span-4">&nbsp;</div><!-- spacer -->
		<div id="main" class="span-14">
			<div class="span-2">&nbsp;</div><!-- spacer -->
			<div id="addNewEntry" class="span-10">
				<form action="index.php" method="post">
					<p>
						<textarea name="description" id="description" rows="" cols=""></textarea>
						<input type="text" name="meta" id="meta" onkeyup="lookup(this.value);" class="input" />
						<div class="suggestionBox" id="suggestions" style="display:none;">
							<div class="suggestionList" id="autoSuggestionsList">
							
							</div>
						</div>
						<input type="submit" name="addEntry" id="addEntry" value="Submit" />
					</p>
				</form>
			</div><!--end addNewEntry-->
			<div class="span-2 last">&nbsp;</div><!-- spacer -->
			<br />
			<div class="span-2">&nbsp;</div><!-- spacer -->
			<div id="content-task" class="span-10">
					<?php 
					getAllView(true);
					?>
			</div><!-- end content-task -->
			<div class="span-2 last">&nbsp;</div><!-- spacer -->
		</div><!--end main-->
		<?php 
			include("bin/sidebar.php");
		?>
	</div><!--end container-->
<?php 
include("bin/footer.php");
?>