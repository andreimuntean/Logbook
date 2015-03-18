<?php
$dir = "../uploads/";
$name = $_FILES["img"]["name"];
move_uploaded_file($_FILES['img']['tmp_name'], $dir.$name);
?>
