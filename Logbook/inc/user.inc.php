<?php
	class User{
		public $id, $username, $email, $profile_pic, $bio;

		function __construct($id){
			$db = DB::getInstance();
			$res = $db->query("SELECT * FROM `users` WHERE id = $id");
			foreach($res as $row){
				$this->id = $id;
				$this->username = $row['username'];
				$this->email = $row['email'];
				$this->profile_pic = is_null($row['profile_pic'])?'':$row['profile_pic'];
				$this->bio = $row['bio'];
			}
		}

		function getUsername(){
			return $this->username;
		}

		function getID(){
			return $this->id;
		}
	}
?>

