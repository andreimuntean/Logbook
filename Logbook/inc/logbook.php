<?php
	include 'db.inc.php';
	include 'user.inc.php';
	include 'logbook.inc.php';
session_start();

	function printRecursively($logbookEntries, $j){
				echo '<div class="entryContainer ';
				if($logbookEntries[$j]->edit_of != 0)
					echo "editedEntryContainer";
				echo '" id="entry'.$logbookEntries[$j]->id.'">
					<div class="entryHeader" id="entry'.$logbookEntries[$j]->id.'H">
						'.$logbookEntries[$j]->date.'
						<span id="entry'.$logbookEntries[$j]->id.'E" onclick="editEntry(this.id)" class="editButton">
							Edit
						</span>
					</div>
					<div class="entryContent" id="entry'.$logbookEntries[$j]->id.'C">'.$logbookEntries[$j]->content.'</div>
				</div>';
				for ($c = 0; $c < count($logbookEntries); $c++) {
					if($logbookEntries[$c]->edit_of == $logbookEntries[$j]->id)
						printRecursively($logbookEntries, $c);
				}
			}


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
			$editOF = isset($_POST['editOF'])?$_POST['editOF']:"";
			echo $logbook->addContent($content, $editOF);
		}
	}
	// displaying all logbook entries
	elseif($action == "showAllEntries"){
		$logbook = new Logbook($id);
		$logbookEntries = $logbook->getAllEntries();
		//print_r($logbookEntries);
		for ($i = 0; $i < count($logbookEntries); $i++) {
			
			printRecursively($logbookEntries, $i);			
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
	elseif($action == "search"){
		echo Logbook::search($_POST['token']);
	}
	elseif($action == "password"){
		$user->setPassword($_POST['password']);
	}
?>

