<?php 
require_once('fb.php');
require_once('inc/functions.php');

$session = new Session();

$id = $session->__get('id');
$fullname = $session->__get('fullname');
if(!isset($id)){
	header("Location: login.php");
}

$status = "";

//ob_start();


if(isset($_POST) && sizeof($_POST)>0){
	$db = new ProjectsDb();
	if($_POST['addEntry']){
		$oProject = new Project();
		$oProject->p_name = $_POST['p_name'];
		$oProject->is_active = 1;
		$oProject->is_archived = 0;
		if($db->save($oProject)){
			$status = "<div class='success'>Saved Project Successfully!</div>";
			$pPerms = new ProjectPerms();
			$pPerms->pid = $oProject->id;
			$pPerms->uid = $id;
			if($db->save($pPerms)){
				$status .= "<div class='success'>Assigned Project to YOU Successfully!</div>";
			} else {
				$status .= "<div class='success'>!*!ERROR!*! DID NOT SAVE PROJECT PERMISSIONS</div>";
			}
		} else {
			//FB::log($oTask,"Task Object");
			$status = "<div class='error'>!*!ERROR!*! DID NOT SAVE PROJECT</div>";
		}
	}
	
}
include('bin/header.php');
?>

	<div class="container">
		<?php print "<br/><br/>".$status; ?>
		<br/><br/>
		<div class="span-4">&nbsp;</div><!-- spacer -->
		<div id="main" class="span-14">
			<div class="span-2">&nbsp;</div><!-- spacer -->
			<div id="addNewEntry" class="span-10">
				<div id="head">
					<h2>People</h2>
				</div>
			</div><!--end addNewEntry-->
			<div class="span-2 last">&nbsp;</div><!-- spacer -->
			<br/>
			<div class="span-2">&nbsp;</div><!-- spacer -->
			<div id="content-project" class="span-10">
					<?php 
					getUsers();
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