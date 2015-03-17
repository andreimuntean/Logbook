<?php
	include 'db.inc.php';
	include 'user.inc.php';
	include 'logbook.inc.php';
session_start();

	$action = isset($_POST['action'])?$_POST['action']:"";
	$id = isset($_POST['id'])?$_POST['id']:0;
	if(!isset($_SESSION['user'])){
			die();
	}else{
			$user = unserialize($_SESSION['user']);
	}
	//creating a new logbook
	if($action == "new"){
		$name = isset($_POST['name'])?$_POST['name']:"";
		$privacy = isset($_POST['privacy'])?$_POST['privacy']:"";
		$userID = $user->getID();
		echo $id = Logbook::addNew($name, $privacy, $userID);
	}
	//deleting the logbook
	elseif($action == "delete"){
		$logbook = new Logbook($id);
		//checking if the user is the owner of the logbook
		if($logbook->getUserID() == $user->getID()){
			$logbook->delete();
		}
	}
	// Adding new logbook entry
	elseif($action == "newEntry"){
		$logbook = new Logbook($id);
		//checking if the user has access to the logbook
		if($logbook->getUserID() == $user->getID()){
			$content = isset($_POST['content'])?$_POST['content']:"";
			echo $logbook->addContent($content);
		}
	}
	// displaying all logbook entries
	elseif($action == "showAllEntries"){
		$logbook = new Logbook($id);
		$logbookEntries = $logbook->getAllEntries();
		foreach ($logbookEntries as $logbookEntry) {
			echo '<div class="entryContainer" id="entry'.$logbookEntry["id"].'">
					<div class="entryHeader" id="entry'.$logbookEntry["id"].'H">
						'.$logbookEntry["date"].'
						<span id="entry'.$logbookEntry["id"].'E" onclick="editEntry(this.id)" class="editButton">
							Edit
						</span>
					</div>
					<div class="entryContent" id="entry'.$logbookEntry["id"].'C">'.$logbookEntry["content"].'</div>
				</div>';
		}
	}
	elseif($action == "share"){
		$username = isset($_POST['username'])?$_POST['username']:"";
		$contributorID = User::getIDfromUsername($username);
		if($contributorID == 0)
			echo "Couldn't find such user";
		else{
			$logbook = new Logbook($id);
			if($logbook->getUserID() == $user->getID()){
				$logbook->share($contributorID);
				echo "Logbook is now shared with ".$username;
			}
		}
	}
?>

