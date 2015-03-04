<?php
	include "db.inc.php";
	include "functions.php";
	include "user.inc.php";

	if(isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])){
		$result = register($_POST['email'], $_POST['username'], $_POST['password']);
		if($result > 0){
			$user = new User($result);
			session_start();
			$_SESSION['user'] = serialize($user);
		}
		echo $result;
	}




