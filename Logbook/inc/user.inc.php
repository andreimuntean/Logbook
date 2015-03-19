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

		function getIDfromUsername($username){
			$db = DB::getInstance();
			$stmt = $db->prepare("SELECT * FROM `users` WHERE `username` = ?");
			$stmt->bindParam(1, $username);
			$stmt->execute();
	        $result = $stmt->fetchAll();
	        foreach($result as $row){
	        	return $row['id'];
	        }
	        return 0;
		}

		public static function userExists($userID){
			$db = DB::getInstance();
			$stmt = $db->prepare("SELECT * FROM `users` WHERE `id` = ?");
			$stmt->bindParam(1, $userID);
			$stmt->execute();
	        $result = $stmt->fetchAll();
	        foreach($result as $row){
	        	return true;
	        }
	        return false;
		}
	}
?>

