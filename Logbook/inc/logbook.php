<?php
	include 'db.inc.php';
	include 'user.inc.php';
	include 'logbook.inc.php';
session_start();

	$action = isset($_POST['action'])?$_POST['action']:"";
	if($action == "new"){
		if(!isset($_SESSION['user'])){
			die();
		}else{
			$user = unserialize($_SESSION['user']);
		}
		$name = isset($_POST['name'])?$_POST['name']:"";
		$privacy = isset($_POST['privacy'])?$_POST['privacy']:"";
		$userID = $user->getID();
		echo $id = Logbook::addNew($name, $privacy, $userID);

	}
?>

