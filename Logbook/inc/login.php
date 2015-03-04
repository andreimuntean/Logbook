<?php
	include "db.inc.php";
	include "functions.php";
	include "user.inc.php";
	session_start();
	if(isset($_POST['username']) && isset($_POST['password'])){
		$result = login($_POST['username'], $_POST['password']);
		if($result == 1){
			$user = new User($result);
			
			$_SESSION['user'] = serialize($user);
		}
		echo $result;
	}

	if(isset($_POST['logout'])){
		unset($_SESSION['user']);
		session_destroy();
	}




