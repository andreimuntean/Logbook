// Global utility scripts go here.

function addLogbookToDB(logbookName, logbookPrivacy){
    $.ajax({
            url:"inc/logbook.php",
            type:"post",
            data:{
                "name":logbookName,
                "privacy":logbookPrivacy,
                "action":"new"
            }
    }).done(function(response){
        createLogbook(logbookName, response)
            console.log(response);
    })
}

function deleteLogbookfromDB(logbookID){
    $.ajax({
            url:"inc/logbook.php",
            type:"post",
            data:{
                "id":logbookID,
                "action":"delete"
            }
    }).done(function(response){
            console.log(response);
    })
}

var logbookIDCounter = 0;     // Keeps track of the id number given to logbooks.
var idCounter = 0;            // Keeps track of the id number given to logbook entries.
var logbooks = [];            // This keeps an array of every logbook created so far.
var createNewLogbook = false; // Decides whether or not to create a new logbook when saving.
var currentLogbookID = 0;

// Creates a logbook and settings button in the left selection pane.
function createLogbook (logbookName, logbookID)
{
  /*var logbookID       = "logbook" + logbookIDCounter;*/
  var logbookDiv      = document.createElement ("div");
  var logbookButton   = document.createElement ("button");
  var settingsButton  = document.createElement ("button");

  // Creates the container div for the logbook and settings button.
  logbookDiv.setAttribute ("class", "logbookContainer");
  logbookDiv.id = logbookID;
  document.getElementById("logbookSelectionPane").appendChild (logbookDiv);

  // Creates the logbook button and adds it to the new div.
  logbookButton.setAttribute ("class", "logbookButton");
  logbookButton.setAttribute ("type", "button");
  logbookButton.innerHTML = /*"Test text";*/ logbookName;
  document.getElementById(logbookID).appendChild (logbookButton);

  // Creates the logbook settings button and adds it as well.
  settingsButton.setAttribute ("class", "settingsButton");
  settingsButton.setAttribute ("type", "button");
  settingsButton.onclick = partial (openLogbookSettings, logbookID);
  document.getElementById(logbookID).appendChild (settingsButton);

  // logbookIDCounter is incremented (guarantees each entry id is unique).
  logbookIDCounter++;
}

// Creates a logbook entry in the right editor pane.
function createLogbookEntry ()
{
  document.getElementById("createLogbookEntryButton").disabled = true;
  document.getElementById("createLogbookEntryButton").setAttribute("style", "background-color: #393F48");
  var editArray = document.getElementsByClassName("editButton");
  for (var editInstance = 0; editInstance < editArray.length; editInstance++)
  {
    editArray[editInstance].removeAttribute("onclick");
    editArray[editInstance].setAttribute("style", "color: #9B9EA2");
  }

  var entryDiv      = document.createElement ("div");
  var entryHeader   = document.createElement ("div");
  var entryContent  = document.createElement ("div");
  var entryID       = "entry" + idCounter;
  var entryTextArea = document.createElement ("textarea");
  var saveEntry     = document.createElement ("span");

  // Creates the container div and sets its id so the other divs can be placed
  // inside.
  entryDiv.setAttribute ("class", "entryContainer");
  entryDiv.id = entryID;
  document.getElementById("logbookEditorSpace").appendChild (entryDiv);

  // Adds the inner divs inside of the new container div.
  entryHeader.setAttribute ("class", "entryHeader");
  entryHeader.innerHTML = "More test text";

  entryContent.setAttribute ("class", "entryContent");
  document.getElementById(entryID).appendChild (entryHeader);
  entryHeader.id = entryID + "H";
  document.getElementById(entryID).appendChild (entryContent);
  entryContent.id = entryID + "C";

  entryTextArea.setAttribute ("class", "entryTextArea");
  entryTextArea.id = "currentTextArea";
  saveEntry.setAttribute ("class", "saveButton");
  saveEntry.id = "currentSaveButton";
  saveEntry.setAttribute ("onclick", "saveEntry()");

  entryHeader.appendChild (saveEntry);
  entryContent.appendChild (entryTextArea);

  saveEntry.innerHTML = "Save";

  // idCounter is incremented (guarantees each entry id is unique).
  idCounter++;
}

// Code that gets executed when you save an entry
function saveEntry ()
{
  var editEntry    = document.createElement("span");
  var saveEntry    = document.getElementById("currentSaveButton");
  var textArea     = document.getElementById("currentTextArea");
  var sectionBreak = document.createElement("hr");
  var textToSave   = textArea.value;

  // Create an edit button.
  saveEntry.parentNode.appendChild(editEntry);
  editEntry.id = editEntry.parentNode.parentNode.id + "E";
  editEntry.setAttribute("onclick", "editEntry(this.id)");
  editEntry.setAttribute("class", "editButton");
  editEntry.innerHTML = "Edit";

  // Remove the save button.
  document.getElementById("currentSaveButton").remove();

  // Save the text inside the log.
  textArea.remove();
  var entryContentID = (editEntry.id).substring(0, (editEntry.id).length - 1) + "C";
  document.getElementById(entryContentID).innerHTML += textToSave;
  document.getElementById(entryContentID).appendChild (sectionBreak);

  // Re-enable the create log button.
  document.getElementById("createLogbookEntryButton").disabled = false;
  document.getElementById("createLogbookEntryButton").setAttribute("style", "background-color: #2d3239");
  var editArray =  document.getElementsByClassName("editButton");
  for (var editInstance = 0; editInstance < editArray.length; editInstance++)
  {
    editArray[editInstance].setAttribute("onclick", "editEntry(this.id)");
    editArray[editInstance].removeAttribute("style");
  }
}

function editEntry (buttonId)
{
  document.getElementById("createLogbookEntryButton").disabled = true;
  document.getElementById("createLogbookEntryButton").setAttribute("style", "background-color: #393F48");
  var editArray = document.getElementsByClassName("editButton");
  for (var editInstance = 0; editInstance < editArray.length; editInstance++)
  {
    editArray[editInstance].removeAttribute("onclick");
    editArray[editInstance].setAttribute("style", "color: #9B9EA2");
  }

  var entryTextArea = document.createElement ("textarea");
  var saveEntry     = document.createElement ("span");
  var editEntry     = document.getElementById(buttonId);

  entryTextArea.setAttribute ("class", "entryTextArea");
  entryTextArea.id = "currentTextArea";
  saveEntry.setAttribute ("class", "saveButton");
  saveEntry.id = "currentSaveButton";
  saveEntry.setAttribute ("onclick", "saveEntry()");

  // Replacing edit with save.
  editEntry.remove();
  var entryHeaderID = buttonId.substring(0, buttonId.length - 1) + "H";
  document.getElementById(entryHeaderID).appendChild (saveEntry);
  saveEntry.innerHTML = "Save";

  // Adding the text area.
  var entryContentID = buttonId.substring(0, buttonId.length - 1) + "C";
  document.getElementById(entryContentID).appendChild (entryTextArea);
}

// This function generates a log so that it can be pulled from the server.
function generatePulledLog()
{
  var entryDiv      = document.createElement ("div");
  var entryHeader   = document.createElement ("div");
  var entryContent  = document.createElement ("div");
  var entryID       = "entry" + idCounter;
  var editEntry    = document.createElement("span");
  var sectionBreak = document.createElement("hr");

  // Creates the container div and sets its id so the other divs can be placed
  // inside.
  entryDiv.setAttribute ("class", "entryContainer");
  entryDiv.id = entryID;
  document.getElementById("logbookEditorSpace").appendChild (entryDiv);

  // Adds the inner divs inside of the new container div.
  entryHeader.setAttribute ("class", "entryHeader");
  entryHeader.innerHTML = "More test text";

  entryContent.setAttribute ("class", "entryContent");
  document.getElementById(entryID).appendChild (entryHeader);
  entryHeader.id = entryID + "H";
  document.getElementById(entryID).appendChild (entryContent);
  entryContent.id = entryID + "C";

  // Create an edit button.
  entryHeader.appendChild(editEntry);
  editEntry.id = editEntry.parentNode.parentNode.id + "E";
  editEntry.setAttribute("onclick", "editEntry(this.id)");
  editEntry.setAttribute("class", "editButton");
  editEntry.innerHTML = "Edit";

  entryContent.innerHTML = "Text pulled from server here";
  entryContent.appendChild(sectionBreak);

  idCounter++;
}

// Opens the logbook settings popup.
function togglePopUp (isOn, id)
{
  var display = "";
  if (isOn) {
    display = 'block';
  } else {
    display = 'none'
  }

  document.getElementById(id).style.display = display;
  document.getElementById("blanket").style.display = display;
}

// Saves the desired settings for a logbook.
function saveLogbookSettings ()
{
  togglePopUp (false, 'settings')
  // If true, a logbook is created with these
  if (createNewLogbook)
  {
    createNewLogbook = false;
    name = $("#logbookName").val();
    $("#logbookName").val("");
    privacy = $("#visibility").val();
    addLogbookToDB(name, privacy);
  }
}

// Cancels logbook creation or removes a logbook from the user's logbooks.
function deleteLogbook ()
{
	togglePopUp (false, 'settings')
	// If false, the logbook is a preexisting one and must be removed.
	// NOTE: Insert some code here that can remove a logbook from server!
	if (!createNewLogbook)
	{
    deleteLogbookfromDB(currentLogbookID);
		var logbookToDelete = document.getElementById (currentLogbookID);
		document.getElementById ("logbookSelectionPane").removeChild (logbookToDelete)
	}
}

// Toggles the logbook settings popup on AND sets the currentLogbookID.
function openLogbookSettings (logbookID)
{
	togglePopUp (true, 'settings');
	currentLogbookID = logbookID;
}

/* Code taken from: 'http://blog.dreasgrech.com/2009/11/passing-pointer-to-functi
 * on-with.html'. It allows a function reference to be passed with parameters.*/

  var partial = function (func /*, 0..n args */) {
    var args = Array.prototype.slice.call(arguments, 1);
    return function () {
        var allArguments = args.concat(Array.prototype.slice.call(arguments));
        return func.apply(this, allArguments);
    }
  }


$(document).ready(function(){
	$("#signUpButton").click(function(){
		var username = $("input[name='username']").val();
		var email = $("input[name='email']").val();
		var password = $("input[name='password']").val();

		if(username.length == 0 || email.length == 0 || password.length == 0){
			$.notify("Please fill all required fields", "warn")
			return false;
		}
		if(password.length > 15 || password.length < 5){
			$.notify("Password length must be between 5 and 15", "warn");
			return false;
		}
  		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
 		if(!regex.test(email)){
 			$.notify("Email is not valid", "warn");
 			return false
 		}
 		regex = /^([a-zA-Z0-9_.])/;
 		if(!regex.test(username)){
 			$.notify("Username is not valid", "warn");
 			return false;
 		}

 		$.ajax({
 			url:"inc/register.php",
 			type:"post",
 			data:{
 				"username":username,
 				"email":email,
 				"password":password
 			}
 		})
 		.done(function(response){
 			response = response.trim();
 			if(response == "-1"){
 				$.notify("Something unforseen has happened", "error");
 			}else if(response == "-2"){
				$.notify("Email is already in use", "warn");
 			}else if(response == "-3"){
				$.notify("Username is already in use", "warn");
 			}else if(parseInt(response) > 0){
				$.notify("Successfully registered, redirecting...", "success");
				setTimeout(function(){
					location.href = "home.php";
				}, 2000);
 			}else{
 				console.log(response);
 			}
 		})
	})

	//logout
	$("#sign-out-button").click(function(){
		$.ajax({
 			url:"inc/login.php",
 			type:"post",
 			data:{
 				"logout":"1"
 			}
 		}).done(function(response){
 			$.notify("Bye!", "success");
 			setTimeout(function(){
 				location.href = "index.php";
 			}, 1000)
 		})
	})

  $("#sign-in-button").click(function(){
    $.ajax({
      url:"inc/login.php",
      type:"post",
      data:{
        "username":$("#sign-in-username").val(),
        "password":$("#sign-in-password").val()
      }
    }).done(function(response){
      response = response.trim();
      console.log(response);
      if(response == "0")
        $.notify("Wrong username and password combination", "alert");
      else
      {
        $.notify("Successfully logged in", "success");
        setTimeout(function(){
          location.href = "home.php";
        }, 500)
      }
    })
  })
})
