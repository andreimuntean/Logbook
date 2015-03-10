<?php
	include 'db.inc.php';
	include 'user.inc.php';
	include 'logbook.inc.php';
session_start();

	$action = isset($_POST['action'])?$_POST['action']:"";
	if(!isset($_SESSION['user'])){
			die();
		}else{
			$user = unserialize($_SESSION['user']);
		}
	if($action == "new"){
		$name = isset($_POST['name'])?$_POST['name']:"";
		$privacy = isset($_POST['privacy'])?$_POST['privacy']:"";
		$userID = $user->getID();
		echo $id = Logbook::addNew($name, $privacy, $userID);
	}
	elseif($action == "delete"){
		$id = isset($_POST['id'])?$_POST['id']:0;
		$logbook = new Logbook($id);
		//checking if the user is the owner of the logbook
		if($logbook->getUserID() == $user->getID()){
			$logbook->delete();
		}
	}
?>

