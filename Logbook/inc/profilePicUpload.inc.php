<?php
session_start();
include 'functions.php';

if(!isset($_SESSION['user'])){
	die();
}
$user = unserialize($_SESSION['user']);
if(isset($_FILES['image'])) {
  $dir = "../assets/profile-pics/";
  $name = $_FILES["image"]["name"];
  move_uploaded_file($_FILES['image']['tmp_name'], $dir.basename($name));
  $db = DB::getInstance();
  $stmt = $db->prepare("UPDATE `users` SET `profile_pic` = ? WHERE id = ?");
  $stmt->bindParam(1, $name);
  $stmt->bindParam(2, $user->getID());
  $stmt->execute();
  $user = new User($user->getID());
  $_SESSION['user'] = serialize($user);
}
?>
