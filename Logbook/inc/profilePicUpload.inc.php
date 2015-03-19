<?php
if(isset($_FILES['image'])) {
  $dir = "../assets/profile-pics/";
  $name = $_FILES["image"]["name"];
  move_uploaded_file($_FILES['image']['tmp_name'], $dir.basename($name));
}
?>
