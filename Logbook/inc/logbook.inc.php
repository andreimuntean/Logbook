<?php
	class Logbook{
		public $id, $name, $privacy, $userID;

		function __construct($id){
			$db = DB::getInstance();
			$res = $db->query("SELECT * FROM `logbooks` WHERE id = $id");
			foreach($res as $row){
				$this->id = $id;
				$this->name = $row['name'];
				$this->privacy = $row['privacy'];
				$this->userID = $row['user_id'];
			}
		}

		public static function addNew($name, $privacy, $userID){
			$db = DB::getInstance();
	        $stmt = $db->prepare("INSERT INTO `logbooks`(`name`,`privacy`,`user_id`,`theme_id`) VALUES(?, ?, ?, 1)");
	        $stmt->bindParam(1, $name);
	        $stmt->bindParam(2, $privacy);
	        $stmt->bindParam(3, $userID);
	        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);   
	        $stmt->execute();
	        return $db->lastInsertID();
		}

		function getID(){
			return $this->id;
		}
	}
?>

