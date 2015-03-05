<?php
	include "db.inc.php";
	include "functions.php";
	include "user.inc.php";
	session_start();
	if(isset($_POST['email']) && isset($_POST['password'])){
		echo $result = login($_POST['email'], $_POST['password']);
		if($result == 1){
			$user = new User($result);
			$_SESSION['user'] = serialize($user);
		}
	}
	if(isset($_POST['logout'])){
		unset($_SESSION['user']);
		session_destroy();
	}




