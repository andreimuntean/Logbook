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

		public function addContent($content){
			$db = DB::getInstance();
			$logbookID = $this->getID();
			$userID = $this->getUserID();
	        $stmt = $db->prepare("INSERT INTO `logs`(`logbook_id`, `content`, `date`, `user_id`) VALUES(?, ?, ?, ?)");
	        $stmt->bindParam(1, $logbookID);
	        $stmt->bindParam(2, $content);
	        $stmt->bindParam(3, date('Y-m-d H:i:s'));
	        $stmt->bindParam(4, $userID);
	        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);   
	        $stmt->execute();
	        return $db->lastInsertID();
		}

		public function getAllEntries(){
			$db = DB::getInstance();
			$logbookID = $this->getID();
			return $db->query("SELECT * FROM `logs` WHERE `logbook_id` = $logbookID");
		}

		public function hasAccess($userID){
			$db = DB::getInstance();
			$logbookID = $this->getID();
			$res = $db->query("SELECT * FROM `accesses` WHERE logbook_id = $logbookID");
			foreach($res as $row){
				if($row['user_id']==$userID)
					return true;
			}
			return false;

		}

		public function share($userID){
			$db = DB::getInstance();
			$logbookID = $this->getID();
			$db->exec("INSERT INTO `accesses`(`logbook_id`, `user_id`, `level`) VALUES($logbookID, $userID, 1)");
		}



		public function getUserID(){
			return $this->userID;
		}

		public function delete(){
			$db = DB::getInstance();
	        $stmt = $db->prepare("DELETE FROM `logbooks` WHERE `id` = ?");
	        $stmt->bindParam(1, $this->id);
	        $stmt->execute();
	        $db->exec("DELETE FROM `accesses` WHERE `logbook_id` = $id");
		}

		public function getID(){
			return $this->id;
		}


	}
?>

